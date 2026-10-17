<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthToastTest extends TestCase
{
    use RefreshDatabase;

    public function test_unregistered_email_login_is_rejected_and_flashes_toast(): void
    {
        $response = $this->post('/login', [
            'email' => 'unregistered_user_9988@test.com',
            'password' => 'AnyPassword123!',
        ]);

        $response->assertSessionHasErrors(['email']);
        $response->assertSessionHas('toast_type', 'warning');
        $response->assertSessionHas('toast_title', 'Email Not Registered');
        $this->assertGuest();
    }

    public function test_existing_email_registration_is_rejected_and_flashes_toast(): void
    {
        $user = User::factory()->create([
            'email' => 'existing_baddie@test.com',
        ]);

        $response = $this->post('/register', [
            'name' => 'Existing Baddie',
            'email' => 'existing_baddie@test.com',
            'password' => 'SecurePass123!',
            'password_confirmation' => 'SecurePass123!',
        ]);

        $response->assertSessionHasErrors(['email']);
        $response->assertSessionHas('toast_type', 'warning');
        $response->assertSessionHas('toast_title', 'Email Already Registered');
    }

    public function test_registered_user_with_wrong_password_flashes_toast(): void
    {
        $user = User::factory()->create([
            'email' => 'valid_user@test.com',
            'password' => bcrypt('CorrectPassword123!'),
        ]);

        $response = $this->post('/login', [
            'email' => 'valid_user@test.com',
            'password' => 'WrongPassword123!',
        ]);

        $response->assertSessionHasErrors(['email']);
        $response->assertSessionHas('toast_type', 'danger');
        $response->assertSessionHas('toast_title', 'Incorrect Password');
        $this->assertGuest();
    }

    public function test_authenticated_user_visiting_login_get_clears_session(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/login');

        $response->assertRedirect('/?auth=login');
        $this->assertGuest();
    }

    public function test_authenticated_user_submitting_unregistered_email_login_is_rejected_and_not_bypassed_to_dashboard(): void
    {
        $user = User::factory()->create([
            'email' => 'active_session_user@test.com',
        ]);

        $response = $this->actingAs($user)->post('/login', [
            'email' => 'does_not_exist_404@test.com',
            'password' => 'SomePassword123!',
        ]);

        $response->assertSessionHasErrors(['email']);
        $response->assertSessionHas('toast_type', 'warning');
        $response->assertSessionHas('toast_title', 'Email Not Registered');
        $this->assertGuest();
    }

    public function test_authenticated_user_can_reauthenticate_as_different_user(): void
    {
        $user1 = User::factory()->create([
            'email' => 'user_one@test.com',
        ]);
        $user2 = User::factory()->create([
            'email' => 'user_two@test.com',
            'password' => bcrypt('UserTwoPass123!'),
        ]);

        $response = $this->actingAs($user1)->post('/login', [
            'email' => 'user_two@test.com',
            'password' => 'UserTwoPass123!',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticatedAs($user2);
    }
}
