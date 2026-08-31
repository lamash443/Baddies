<?php

namespace Tests\Feature;

use App\Models\Deposit;
use App\Models\MembershipPlan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class PaymentTest extends TestCase
{
    use RefreshDatabase;

    public function test_unauthenticated_user_cannot_initiate_payment(): void
    {
        $response = $this->postJson('/payment/initiate', [
            'phone' => '0712345678',
            'purpose' => 'wallet',
            'amount' => 100,
        ]);

        $response->assertStatus(401);
    }

    public function test_authenticated_user_can_initiate_wallet_payment(): void
    {
        $user = User::factory()->create();

        Http::fake([
            'https://backend.payhero.co.ke/api/v2/payments' => Http::response([
                'CheckoutRequestID' => 'ws_CO_123456',
                'reference' => 'PH_REF_123',
            ], 200),
        ]);

        $response = $this->actingAs($user)->postJson('/payment/initiate', [
            'phone' => '0712345678',
            'purpose' => 'wallet',
            'amount' => 500,
        ]);

        $response
            ->assertStatus(200)
            ->assertJson(['success' => true]);

        $this->assertDatabaseHas('deposits', [
            'user_id' => $user->id,
            'amount' => 500,
            'status' => 'pending',
            'payment_method' => 'mpesa',
        ]);

        $deposit = Deposit::where('user_id', $user->id)->first();

        $this->assertSame('ws_CO_123456', $deposit->checkout_request_id);
        $this->assertSame('PH_REF_123', $deposit->payhero_reference);
    }

    public function test_successful_wallet_webhook_completes_deposit_and_credits_wallet(): void
    {
        $user = User::factory()->create([
            'wallet_balance' => 0,
        ]);

        $deposit = Deposit::create([
            'user_id' => $user->id,
            'amount' => 500,
            'status' => 'pending',
            'reference' => 'DEP_TEST_123',
            'payment_method' => 'mpesa',
            'meta' => ['purpose' => 'wallet'],
        ]);

        $response = $this->postJson('/webhook/payhero', [
            'response' => [
                'ExternalReference' => 'DEP_TEST_123',
                'Status' => 'Success',
                'ResultCode' => 0,
                'MerchantRequestID' => 'PH_REF_123',
            ],
        ]);

        $response
            ->assertStatus(200)
            ->assertJson(['success' => true]);

        $this->assertDatabaseHas('deposits', [
            'id' => $deposit->id,
            'status' => 'completed',
        ]);

        $this->assertEquals(500, (float) $user->fresh()->wallet_balance);
    }

    public function test_duplicate_successful_webhook_does_not_double_credit_wallet(): void
    {
        $user = User::factory()->create([
            'wallet_balance' => 0,
        ]);

        Deposit::create([
            'user_id' => $user->id,
            'amount' => 500,
            'status' => 'pending',
            'reference' => 'DEP_DUPLICATE',
            'payment_method' => 'mpesa',
            'meta' => ['purpose' => 'wallet'],
        ]);

        $payload = [
            'response' => [
                'ExternalReference' => 'DEP_DUPLICATE',
                'Status' => 'Success',
                'ResultCode' => 0,
            ],
        ];

        $this->postJson('/webhook/payhero', $payload)
            ->assertStatus(200);

        $this->postJson('/webhook/payhero', $payload)
            ->assertStatus(200);

        $this->assertEquals(500, (float) $user->fresh()->wallet_balance);
    }

    public function test_failed_webhook_marks_deposit_as_failed(): void
    {
        $user = User::factory()->create();

        $deposit = Deposit::create([
            'user_id' => $user->id,
            'amount' => 500,
            'status' => 'pending',
            'reference' => 'DEP_FAILED',
            'payment_method' => 'mpesa',
            'meta' => ['purpose' => 'wallet'],
        ]);

        $response = $this->postJson('/webhook/payhero', [
            'response' => [
                'ExternalReference' => 'DEP_FAILED',
                'Status' => 'Failed',
                'ResultCode' => 1032,
                'ResultDesc' => 'Request cancelled by user',
            ],
        ]);

        $response
            ->assertStatus(200)
            ->assertJson(['success' => true]);

        $deposit->refresh();

        $this->assertSame('failed', $deposit->status);
        $this->assertSame(
            'Request cancelled by user',
            $deposit->meta['failure_reason']
        );

        $this->assertEquals(0, (float) $user->fresh()->wallet_balance);
    }

    public function test_invalid_membership_plan_is_rejected(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->postJson('/payment/initiate', [
            'phone' => '0712345678',
            'purpose' => 'membership',
            'plan_type' => 'does-not-exist',
            'plan_days' => 30,
        ]);

        $response
            ->assertStatus(404)
            ->assertJson(['success' => false]);
    }

    public function test_invalid_membership_duration_is_rejected(): void
    {
        $user = User::factory()->create();

        MembershipPlan::create([
            'name' => 'Regular',
            'slug' => 'regular',
            'photo_limit' => 4,
            'video_limit' => 1,
            'features' => [],
            'pricing' => [
                30 => 1000,
                90 => 2500,
            ],
        ]);

        $response = $this->actingAs($user)->postJson('/payment/initiate', [
            'phone' => '0712345678',
            'purpose' => 'membership',
            'plan_type' => 'regular',
            'plan_days' => 999,
        ]);

        $response
            ->assertStatus(422)
            ->assertJson(['success' => false]);
    }

    public function test_membership_payment_uses_plan_pricing(): void
    {
        $user = User::factory()->create();

        MembershipPlan::create([
            'name' => 'Regular',
            'slug' => 'regular',
            'photo_limit' => 10,
            'video_limit' => 3,
            'features' => [],
            'pricing' => [
                30 => 1500,
                90 => 4000,
            ],
        ]);

        Http::fake([
            'https://backend.payhero.co.ke/api/v2/payments' => Http::response([
                'CheckoutRequestID' => 'ws_CO_MEMBERSHIP',
                'reference' => 'PH_MEMBERSHIP',
            ], 200),
        ]);

        $response = $this->actingAs($user)->postJson('/payment/initiate', [
            'phone' => '0712345678',
            'purpose' => 'membership',
            'plan_type' => 'regular',
            'plan_days' => 30,
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('deposits', [
            'user_id' => $user->id,
            'amount' => 1500,
            'status' => 'pending',
        ]);
    }

    public function test_payment_status_only_exposes_authenticated_users_own_deposit(): void
    {
        $owner = User::factory()->create();
        $otherUser = User::factory()->create();

        Deposit::create([
            'user_id' => $owner->id,
            'amount' => 750,
            'status' => 'pending',
            'reference' => 'DEP_PRIVATE',
            'payment_method' => 'mpesa',
            'meta' => ['purpose' => 'wallet'],
        ]);

        $response = $this->actingAs($otherUser)
            ->getJson('/payment/status/DEP_PRIVATE');

        $response->assertStatus(404);
    }
}
