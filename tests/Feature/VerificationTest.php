<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\VerificationSubmission;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class VerificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_unauthenticated_user_cannot_submit_verification_photo(): void
    {
        $photo = UploadedFile::fake()->image('verification.jpg');

        $response = $this->post('/profile/verification', [
            'photo' => $photo,
        ]);

        $response->assertRedirect('/login');

        $this->assertDatabaseCount('verification_submissions', 0);
    }

    public function test_authenticated_user_can_submit_verification_photo(): void
    {
        Storage::fake('public');

        $user = User::factory()->create([
            'is_verified' => false,
        ]);

        $photo = UploadedFile::fake()->image('verification.jpg');

        $response = $this->actingAs($user)->post('/profile/verification', [
            'photo' => $photo,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas(
            'verification_upload_success',
            'Verification photo submitted successfully. Please wait for admin approval.'
        );

        $this->assertDatabaseHas('verification_submissions', [
            'user_id' => $user->id,
            'status' => 'pending',
        ]);

        $submission = VerificationSubmission::where('user_id', $user->id)->first();

        Storage::disk('public')->assertExists($submission->photo_path);
    }

    public function test_verification_photo_is_required(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/profile/verification', []);

        $response->assertSessionHasErrors('photo');

        $this->assertDatabaseCount('verification_submissions', 0);
    }

    public function test_invalid_verification_file_is_rejected(): void
    {
        $user = User::factory()->create();

        $file = UploadedFile::fake()->create(
            'document.pdf',
            100,
            'application/pdf'
        );

        $response = $this->actingAs($user)->post('/profile/verification', [
            'photo' => $file,
        ]);

        $response->assertSessionHasErrors('photo');

        $this->assertDatabaseCount('verification_submissions', 0);
    }

    public function test_existing_verification_submission_is_overwritten(): void
    {
        Storage::fake('public');

        $user = User::factory()->create([
            'is_verified' => false,
        ]);

        Storage::disk('public')->put(
            'verification-photos/old-photo.jpg',
            'old photo'
        );

        $existing = VerificationSubmission::create([
            'user_id' => $user->id,
            'photo_path' => 'verification-photos/old-photo.jpg',
            'status' => 'rejected',
        ]);

        $photo = UploadedFile::fake()->image('new-photo.jpg');

        $response = $this->actingAs($user)->post('/profile/verification', [
            'photo' => $photo,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('verification_upload_success');

        $this->assertDatabaseCount('verification_submissions', 1);

        $submission = VerificationSubmission::where('user_id', $user->id)->first();

        $this->assertSame($existing->id, $submission->id);
        $this->assertSame('pending', $submission->status);
        $this->assertNotSame('verification-photos/old-photo.jpg', $submission->photo_path);

        Storage::disk('public')->assertExists($submission->photo_path);
        Storage::disk('public')->assertExists('verification-photos/old-photo.jpg');
    }
}
