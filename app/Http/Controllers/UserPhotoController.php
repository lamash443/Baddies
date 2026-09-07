<?php

namespace App\Http\Controllers;

use App\Models\UserPhoto;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserPhotoController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'photo' => ['required', 'image', 'mimes:jpg,jpeg,png,webp,gif', 'max:5120'],
        ]);

        $user = auth()->user();

        if ($user->photosCountForLimit() >= $user->photo_limit) {
            return back()->withFragment('tab-publish-media')->withErrors(['photo' => 'You have reached the photo upload limit for your current subscription plan.']);
        }

        $isFirstPhoto = $user->photos()->count() === 0;
        $path = $request->file('photo')->store('user-photos/' . $user->id, 'public');

        UserPhoto::create([
            'user_id' => auth()->id(),
            'path'    => $path,
            'caption' => $request->input('caption'),
            'is_main' => $isFirstPhoto,
        ]);

        return back()->withFragment('tab-publish-media')->with('photo_upload_success', 'Photo uploaded successfully.');
    }

    public function setMain(UserPhoto $photo): RedirectResponse
    {
        abort_unless($photo->user_id === auth()->id(), 403);

        UserPhoto::where('user_id', auth()->id())->update(['is_main' => false]);
        $photo->update(['is_main' => true]);

        return back()->withFragment('tab-publish-media')->with('photo_upload_success', 'Main listing card cover image updated.');
    }

    public function destroy(UserPhoto $photo): RedirectResponse
    {
        // Only owner can delete
        abort_unless($photo->user_id === auth()->id(), 403);

        $wasMain = $photo->is_main;

        if (Storage::disk('public')->exists($photo->path)) {
            Storage::disk('public')->delete($photo->path);
        }

        $photo->delete();

        if ($wasMain) {
            $nextPhoto = UserPhoto::where('user_id', auth()->id())->first();
            if ($nextPhoto) {
                $nextPhoto->update(['is_main' => true]);
            }
        }

        return back()->withFragment('tab-publish-media')->with('photo_delete_success', 'Photo deleted.');
    }
}
