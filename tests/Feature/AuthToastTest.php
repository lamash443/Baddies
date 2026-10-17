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
}
