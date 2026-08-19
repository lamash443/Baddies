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

        if ($user->photos()->count() >= $user->photo_limit) {
            return back()->withFragment('tab-publish-media')->withErrors(['photo' => 'You have reached the photo upload limit for your current subscription plan.']);
        }

        $path = $request->file('photo')->store('user-photos/' . $user->id, 'public');

        UserPhoto::create([
            'user_id' => auth()->id(),
            'path'    => $path,
            'caption' => $request->input('caption'),
        ]);

        return back()->withFragment('tab-publish-media')->with('photo_upload_success', 'Photo uploaded successfully.');
    }

    public function destroy(UserPhoto $photo): RedirectResponse
    {
        // Only owner can delete
        abort_unless($photo->user_id === auth()->id(), 403);

        if (Storage::disk('public')->exists($photo->path)) {
            Storage::disk('public')->delete($photo->path);
        }

        $photo->delete();

        return back()->withFragment('tab-publish-media')->with('photo_delete_success', 'Photo deleted.');
    }
}
