<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\UserPhoto;
use App\Models\UserVideo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProfileMediaTest extends TestCase
{
    use RefreshDatabase;

    public function test_unauthenticated_user_cannot_upload_photo(): void
    {
        $photo = UploadedFile::fake()->create('photo.jpg', 10, 'image/jpeg');

        $response = $this->post('/profile/photos', [
            'photo' => $photo,
        ]);

        $response->assertRedirect('/login');

        $this->assertDatabaseCount('user_photos', 0);
    }

    public function test_authenticated_user_can_upload_photo(): void
    {
        Storage::fake('public');

        $user = User::factory()->create([
            'subscription_plan' => 'regular',
            'subscription_expires_at' => now()->addDays(30),
        ]);

        $photo = UploadedFile::fake()->create('photo.jpg', 10, 'image/jpeg');

        $response = $this->actingAs($user)->post('/profile/photos', [
            'photo' => $photo,
            'caption' => 'My profile photo',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('photo_upload_success', 'Photo uploaded successfully.');

        $this->assertDatabaseHas('user_photos', [
            'user_id' => $user->id,
            'caption' => 'My profile photo',
        ]);

        $storedPhoto = UserPhoto::where('user_id', $user->id)->first();

        Storage::disk('public')->assertExists($storedPhoto->path);
    }

    public function test_photo_upload_limit_is_enforced(): void
    {
        Storage::fake('public');

        $user = User::factory()->create([
            'subscription_plan' => 'regular',
            'subscription_expires_at' => now()->addDays(30),
        ]);

        for ($i = 1; $i <= 4; $i++) {
            UserPhoto::create([
                'user_id' => $user->id,
                'path' => "user-photos/{$user->id}/photo-{$i}.jpg",
                'caption' => "Photo {$i}",
            ]);
        }

        $photo = UploadedFile::fake()->create('extra.jpg', 10, 'image/jpeg');

        $response = $this->actingAs($user)->post('/profile/photos', [
            'photo' => $photo,
        ]);

        $response->assertRedirect();
        $response->assertSessionHasErrors('photo');

        $this->assertDatabaseCount('user_photos', 4);
    }

    public function test_authenticated_user_can_delete_own_photo(): void
    {
        Storage::fake('public');

        $user = User::factory()->create();

        Storage::disk('public')->put(
            'user-photos/test/photo.jpg',
            'fake image contents'
        );

        $photo = UserPhoto::create([
            'user_id' => $user->id,
            'path' => 'user-photos/test/photo.jpg',
            'caption' => 'Delete me',
        ]);

        $response = $this->actingAs($user)->delete("/profile/photos/{$photo->id}");

        $response->assertRedirect();
        $response->assertSessionHas('photo_delete_success', 'Photo deleted.');

        $this->assertSoftDeleted('user_photos', [
            'id' => $photo->id,
        ]);

        Storage::disk('public')->assertMissing('user-photos/test/photo.jpg');
    }

    public function test_user_cannot_delete_another_users_photo(): void
    {
        Storage::fake('public');

        $owner = User::factory()->create();
        $otherUser = User::factory()->create();

        Storage::disk('public')->put(
            'user-photos/test/photo.jpg',
            'fake image contents'
        );

        $photo = UserPhoto::create([
            'user_id' => $owner->id,
            'path' => 'user-photos/test/photo.jpg',
        ]);

        $response = $this->actingAs($otherUser)
            ->delete("/profile/photos/{$photo->id}");

        $response->assertForbidden();

        $this->assertDatabaseHas('user_photos', [
            'id' => $photo->id,
        ]);

        Storage::disk('public')->assertExists('user-photos/test/photo.jpg');
    }

    public function test_authenticated_user_can_upload_video(): void
    {
        Storage::fake('public');

        $user = User::factory()->create([
            'subscription_plan' => 'prime',
            'subscription_expires_at' => now()->addDays(30),
        ]);

        $video = UploadedFile::fake()->create(
            'video.mp4',
            100,
            'video/mp4'
        );

        $response = $this->actingAs($user)->post('/profile/videos', [
            'video' => $video,
            'title' => 'My profile video',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('video_upload_success', 'Video uploaded successfully.');

        $this->assertDatabaseHas('user_videos', [
            'user_id' => $user->id,
            'title' => 'My profile video',
        ]);

        $storedVideo = UserVideo::where('user_id', $user->id)->first();

        Storage::disk('public')->assertExists($storedVideo->path);
    }

    public function test_video_upload_limit_is_enforced(): void
    {
        Storage::fake('public');

        $user = User::factory()->create([
            'subscription_plan' => 'regular',
            'subscription_expires_at' => now()->addDays(30),
        ]);

        for ($i = 1; $i <= 2; $i++) {
            UserVideo::create([
                'user_id' => $user->id,
                'path' => "user-videos/{$user->id}/video-{$i}.mp4",
                'title' => "Video {$i}",
            ]);
        }

        $video = UploadedFile::fake()->create(
            'extra.mp4',
            100,
            'video/mp4'
        );

        $response = $this->actingAs($user)->post('/profile/videos', [
            'video' => $video,
        ]);

        $response->assertRedirect();
        $response->assertSessionHasErrors('video');

        $this->assertDatabaseCount('user_videos', 2);
    }

    public function test_authenticated_user_can_delete_own_video(): void
    {
        Storage::fake('public');

        $user = User::factory()->create();

        Storage::disk('public')->put(
            'user-videos/test/video.mp4',
            'fake video contents'
        );

        $video = UserVideo::create([
            'user_id' => $user->id,
            'path' => 'user-videos/test/video.mp4',
            'title' => 'Delete me',
        ]);

        $response = $this->actingAs($user)->delete("/profile/videos/{$video->id}");

        $response->assertRedirect();
        $response->assertSessionHas('video_delete_success', 'Video deleted.');

        $this->assertSoftDeleted('user_videos', [
            'id' => $video->id,
        ]);

        Storage::disk('public')->assertMissing('user-videos/test/video.mp4');
    }

    public function test_user_cannot_delete_another_users_video(): void
    {
        Storage::fake('public');

        $owner = User::factory()->create();
        $otherUser = User::factory()->create();

        Storage::disk('public')->put(
            'user-videos/test/video.mp4',
            'fake video contents'
        );

        $video = UserVideo::create([
            'user_id' => $owner->id,
            'path' => 'user-videos/test/video.mp4',
        ]);

        $response = $this->actingAs($otherUser)
            ->delete("/profile/videos/{$video->id}");

        $response->assertForbidden();

        $this->assertDatabaseHas('user_videos', [
            'id' => $video->id,
        ]);

        Storage::disk('public')->assertExists('user-videos/test/video.mp4');
    }

    public function test_deleted_photo_still_counts_towards_photo_limit(): void
    {
        Storage::fake('public');

        $user = User::factory()->create([
            'subscription_plan' => 'regular',
            'subscription_expires_at' => now()->addDays(30),
        ]);

        for ($i = 1; $i <= 4; $i++) {
            UserPhoto::create([
                'user_id' => $user->id,
                'path' => "user-photos/{$user->id}/photo-{$i}.jpg",
                'caption' => "Photo {$i}",
            ]);
        }

        $photoToDelete = UserPhoto::where('user_id', $user->id)->first();
        $this->actingAs($user)->delete("/profile/photos/{$photoToDelete->id}");

        $this->assertEquals(3, $user->photos()->count());
        $this->assertEquals(4, $user->photosCountForLimit());

        $extraPhoto = UploadedFile::fake()->create('extra.jpg', 10, 'image/jpeg');
        $response = $this->actingAs($user)->post('/profile/photos', [
            'photo' => $extraPhoto,
        ]);

        $response->assertRedirect();
        $response->assertSessionHasErrors('photo');
    }
}
