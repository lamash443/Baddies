<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ProfileStatisticsTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_view_statistics_page(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->get('/profile/statistics');

        $response->assertStatus(200);
        $response->assertViewIs('profile.statistics');
    }

    public function test_statistics_page_defaults_to_30_day_period(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->get('/profile/statistics');

        $response->assertStatus(200);
        $response->assertViewHas('period', '30');
    }

    public function test_today_statistics_are_returned(): void
    {
        $user = User::factory()->create();

        DB::table('profile_statistics')->insert([
            'user_id' => $user->id,
            'date' => now()->toDateString(),
            'views' => 7,
            'phone_calls' => 3,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $response = $this->actingAs($user)
            ->get('/profile/statistics?period=today');

        $response->assertStatus(200);
        $response->assertViewHas('period', 'today');
        $response->assertViewHas('labels', ['Today']);
        $response->assertViewHas('viewsData', [7]);
        $response->assertViewHas('callsData', [3]);
    }

    public function test_seven_day_statistics_return_seven_labels(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->get('/profile/statistics?period=7');

        $response->assertStatus(200);
        $response->assertViewHas('period', '7');

        $labels = $response->viewData('labels');

        $this->assertCount(7, $labels);
    }

    public function test_thirty_day_statistics_return_thirty_labels(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->get('/profile/statistics?period=30');

        $response->assertStatus(200);
        $response->assertViewHas('period', '30');

        $labels = $response->viewData('labels');

        $this->assertCount(30, $labels);
    }

    public function test_statistics_only_include_authenticated_users_own_data(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();

        DB::table('profile_statistics')->insert([
            'user_id' => $user->id,
            'date' => now()->toDateString(),
            'views' => 5,
            'phone_calls' => 2,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('profile_statistics')->insert([
            'user_id' => $otherUser->id,
            'date' => now()->toDateString(),
            'views' => 99,
            'phone_calls' => 99,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $response = $this->actingAs($user)
            ->get('/profile/statistics?period=today');

        $response->assertStatus(200);
        $response->assertViewHas('viewsData', [5]);
        $response->assertViewHas('callsData', [2]);
    }

    public function test_statistics_can_be_requested_as_json(): void
    {
        $user = User::factory()->create();

        DB::table('profile_statistics')->insert([
            'user_id' => $user->id,
            'date' => now()->toDateString(),
            'views' => 12,
            'phone_calls' => 4,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $response = $this->actingAs($user)
            ->getJson('/profile/statistics?period=today');

        $response->assertStatus(200);
        $response->assertJson([
            'labels' => ['Today'],
            'viewsData' => [12],
            'callsData' => [4],
            'period' => 'today',
        ]);
    }

    public function test_unauthenticated_user_cannot_view_statistics(): void
    {
        $response = $this->get('/profile/statistics');

        $response->assertRedirect('/login');
    }
}
