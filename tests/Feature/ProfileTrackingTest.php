<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ProfileTrackingTest extends TestCase
{
    use RefreshDatabase;

    public function test_viewing_verified_profile_increments_profile_views(): void
    {
        $user = User::factory()->create([
            'is_verified' => true,
            'profile_views' => 0,
        ]);

        $response = $this->get("/profile/{$user->id}");

        $response->assertStatus(200);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'profile_views' => 1,
        ]);
    }

    public function test_viewing_verified_profile_creates_daily_statistics(): void
    {
        $user = User::factory()->create([
            'is_verified' => true,
            'profile_views' => 0,
        ]);

        $this->get("/profile/{$user->id}");

        $this->assertDatabaseHas('profile_statistics', [
            'user_id' => $user->id,
            'date' => now()->toDateString(),
            'views' => 1,
            'phone_calls' => 0,
        ]);
    }

    public function test_viewing_profile_twice_increments_views_twice(): void
    {
        $user = User::factory()->create([
            'is_verified' => true,
            'profile_views' => 0,
        ]);

        $this->get("/profile/{$user->id}");
        $this->get("/profile/{$user->id}");

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'profile_views' => 2,
        ]);

        $this->assertDatabaseHas('profile_statistics', [
            'user_id' => $user->id,
            'date' => now()->toDateString(),
            'views' => 2,
            'phone_calls' => 0,
        ]);
    }

    public function test_viewing_unverified_profile_returns_not_found(): void
    {
        $user = User::factory()->create([
            'is_verified' => false,
            'profile_views' => 0,
        ]);

        $response = $this->get("/profile/{$user->id}");

        $response->assertNotFound();

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'profile_views' => 0,
        ]);
    }

    public function test_tracking_phone_call_increments_phone_calls(): void
    {
        $user = User::factory()->create([
            'is_verified' => true,
            'phone_calls' => 0,
        ]);

        $response = $this->postJson("/profile/{$user->id}/track-call");

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
        ]);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'phone_calls' => 1,
        ]);
    }

    public function test_tracking_phone_call_creates_daily_statistics(): void
    {
        $user = User::factory()->create([
            'is_verified' => true,
            'phone_calls' => 0,
        ]);

        $this->postJson("/profile/{$user->id}/track-call");

        $this->assertDatabaseHas('profile_statistics', [
            'user_id' => $user->id,
            'date' => now()->toDateString(),
            'views' => 0,
            'phone_calls' => 1,
        ]);
    }

    public function test_tracking_phone_call_twice_increments_calls_twice(): void
    {
        $user = User::factory()->create([
            'is_verified' => true,
            'phone_calls' => 0,
        ]);

        $this->postJson("/profile/{$user->id}/track-call");
        $this->postJson("/profile/{$user->id}/track-call");

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'phone_calls' => 2,
        ]);

        $this->assertDatabaseHas('profile_statistics', [
            'user_id' => $user->id,
            'date' => now()->toDateString(),
            'views' => 0,
            'phone_calls' => 2,
        ]);
    }

    public function test_tracking_phone_call_for_unverified_profile_returns_not_found(): void
    {
        $user = User::factory()->create([
            'is_verified' => false,
            'phone_calls' => 0,
        ]);

        $response = $this->postJson("/profile/{$user->id}/track-call");

        $response->assertNotFound();

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'phone_calls' => 0,
        ]);
    }
}
