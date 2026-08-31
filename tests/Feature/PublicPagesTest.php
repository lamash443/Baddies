<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicPagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_page_can_be_rendered(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_escort_girls_page_can_be_rendered(): void
    {
        $response = $this->get('/escort-girls');

        $response->assertStatus(200);
    }

    public function test_call_boys_page_can_be_rendered(): void
    {
        $response = $this->get('/category/call-boys');

        $response->assertStatus(200);
    }

    public function test_classifieds_page_can_be_rendered(): void
    {
        $response = $this->get('/classifieds');

        $response->assertStatus(200);
    }

    public function test_videos_page_can_be_rendered(): void
    {
        $response = $this->get('/videos');

        $response->assertStatus(200);
    }

    public function test_search_page_can_be_rendered(): void
    {
        $response = $this->get('/search');

        $response->assertStatus(200);
    }

    public function test_contact_page_can_be_rendered(): void
    {
        $response = $this->get('/contact');

        $response->assertStatus(200);
    }

    public function test_terms_page_can_be_rendered(): void
    {
        $response = $this->get('/terms');

        $response->assertStatus(200);
    }

    public function test_privacy_page_can_be_rendered(): void
    {
        $response = $this->get('/privacy');

        $response->assertStatus(200);
    }

    public function test_unverified_users_are_not_shown_on_escort_page(): void
    {
        $unverifiedUser = User::factory()->create([
            'name' => 'Unverified Test User',
            'gender' => 'female',
            'is_verified' => false,
        ]);

        $response = $this->get('/escort-girls');

        $response->assertStatus(200);
        $response->assertViewHas('vipGirls');
        $response->assertViewHas('primeVipGirls');
        $response->assertViewHas('primeGirls');
        $response->assertViewHas('regularGirls');

        $response->assertDontSee($unverifiedUser->name);
    }

    public function test_active_vip_female_is_shown_on_escort_page(): void
    {
        $user = User::factory()->create([
            'name' => 'Active VIP Test User',
            'gender' => 'female',
            'is_verified' => true,
            'subscription_plan' => 'vip',
            'subscription_expires_at' => now()->addDays(30),
        ]);

        $response = $this->get('/escort-girls');

        $response->assertStatus(200);
        $response->assertViewHas('vipGirls', function ($vipGirls) use ($user) {
            return $vipGirls->contains('id', $user->id);
        });
    }

    public function test_expired_vip_female_is_not_in_vip_section(): void
    {
        $user = User::factory()->create([
            'name' => 'Expired VIP Test User',
            'gender' => 'female',
            'is_verified' => true,
            'subscription_plan' => 'vip',
            'subscription_expires_at' => now()->subDay(),
        ]);

        $response = $this->get('/escort-girls');

        $response->assertStatus(200);
        $response->assertViewHas('vipGirls', function ($vipGirls) use ($user) {
            return !$vipGirls->contains('id', $user->id);
        });
    }

    public function test_unverified_vip_female_is_not_shown_on_escort_page(): void
    {
        $user = User::factory()->create([
            'name' => 'Unverified VIP Test User',
            'gender' => 'female',
            'is_verified' => false,
            'subscription_plan' => 'vip',
            'subscription_expires_at' => now()->addDays(30),
        ]);

        $response = $this->get('/escort-girls');

        $response->assertStatus(200);
        $response->assertViewHas('vipGirls', function ($vipGirls) use ($user) {
            return !$vipGirls->contains('id', $user->id);
        });

        $response->assertDontSee($user->name);
    }
}
