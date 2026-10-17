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

    public function test_google_redirect_forces_account_selection_prompt(): void
    {
        config([
            'services.google.client_id' => 'mock-client-id',
            'services.google.client_secret' => 'mock-client-secret',
            'services.google.redirect' => 'https://kenyanbaddies.com/auth/google/callback',
        ]);

        $response = $this->get('/auth/google');

        $response->assertRedirect();
        $targetUrl = $response->headers->get('Location');
        $this->assertStringContainsString('prompt=select_account', $targetUrl);
    }

    public function test_logout_clears_remember_token_and_cookie(): void
    {
        $user = User::factory()->create([
            'remember_token' => 'existing_token_xyz',
        ]);

        $response = $this->actingAs($user)->post('/logout');

        $response->assertRedirect('/');
        $this->assertGuest();
        $this->assertNull($user->fresh()->remember_token);
        $response->assertCookieExpired(auth()->guard('web')->getRecallerName());
    }

    public function test_google_login_mode_rejects_unregistered_email_and_does_not_create_account(): void
    {
        config([
            'services.google.client_id' => 'mock-id',
            'services.google.client_secret' => 'mock-secret',
            'services.google.redirect' => 'https://kenyanbaddies.com/auth/google/callback',
        ]);

        $abstractUser = \Mockery::mock('Laravel\Socialite\Two\User');
        $abstractUser->shouldReceive('getId')->andReturn('google-id-unreg');
        $abstractUser->shouldReceive('getEmail')->andReturn('unregistered_google@test.com');

        $provider = \Mockery::mock('Laravel\Socialite\Contracts\Provider');
        $provider->shouldReceive('user')->andReturn($abstractUser);

        \Laravel\Socialite\Facades\Socialite::shouldReceive('driver')->with('google')->andReturn($provider);

        $response = $this->withSession(['google_auth_mode' => 'login'])
            ->get('/auth/google/callback');

        $response->assertRedirect('/?auth=register');
        $response->assertSessionHas('toast_type', 'warning');
        $response->assertSessionHas('toast_title', 'Email Not Registered');
        $this->assertGuest();
        $this->assertDatabaseMissing('users', ['email' => 'unregistered_google@test.com']);
    }

    public function test_google_signup_mode_rejects_already_registered_email_and_does_not_redirect_to_dashboard(): void
    {
        config([
            'services.google.client_id' => 'mock-id',
            'services.google.client_secret' => 'mock-secret',
            'services.google.redirect' => 'https://kenyanbaddies.com/auth/google/callback',
        ]);

        $existingUser = User::factory()->create([
            'email' => 'existing_google@test.com',
        ]);

        $abstractUser = \Mockery::mock('Laravel\Socialite\Two\User');
        $abstractUser->shouldReceive('getId')->andReturn('google-id-existing');
        $abstractUser->shouldReceive('getEmail')->andReturn('existing_google@test.com');

        $provider = \Mockery::mock('Laravel\Socialite\Contracts\Provider');
        $provider->shouldReceive('user')->andReturn($abstractUser);

        \Laravel\Socialite\Facades\Socialite::shouldReceive('driver')->with('google')->andReturn($provider);

        $response = $this->withSession(['google_auth_mode' => 'register'])
            ->get('/auth/google/callback');

        $response->assertRedirect('/?auth=login');
        $response->assertSessionHas('toast_type', 'warning');
        $response->assertSessionHas('toast_title', 'Email Already Registered');
        $this->assertGuest();
    }

    public function test_google_signup_mode_creates_account_when_email_not_registered(): void
    {
        config([
            'services.google.client_id' => 'mock-id',
            'services.google.client_secret' => 'mock-secret',
            'services.google.redirect' => 'https://kenyanbaddies.com/auth/google/callback',
        ]);

        $abstractUser = \Mockery::mock('Laravel\Socialite\Two\User');
        $abstractUser->shouldReceive('getId')->andReturn('google-id-brand-new');
        $abstractUser->shouldReceive('getEmail')->andReturn('brand_new_user@test.com');
        $abstractUser->shouldReceive('getName')->andReturn('Brand New User');
        $abstractUser->shouldReceive('getNickname')->andReturn('BrandNew');
        $abstractUser->shouldReceive('getAvatar')->andReturn('https://avatar.url/pic.jpg');

        $provider = \Mockery::mock('Laravel\Socialite\Contracts\Provider');
        $provider->shouldReceive('user')->andReturn($abstractUser);

        \Laravel\Socialite\Facades\Socialite::shouldReceive('driver')->with('google')->andReturn($provider);

        $response = $this->withSession(['google_auth_mode' => 'register'])
            ->get('/auth/google/callback');

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticated();
        $this->assertDatabaseHas('users', ['email' => 'brand_new_user@test.com']);
    }
}
