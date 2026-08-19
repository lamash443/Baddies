<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\MembershipPlan;
use App\Models\UserPhoto;
use App\Models\UserVideo;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();
        $classifieds = \App\Models\Classified::where('user_id', $user->id)->latest()->get();
        $membershipPlans = MembershipPlan::whereNotIn('slug', ['chat'])->get();
        return view('profile.edit', [
            'user'                   => $user,
            'photos'                 => UserPhoto::where('user_id', $user->id)->latest()->get(),
            'videos'                 => UserVideo::where('user_id', $user->id)->latest()->get(),
            'verificationSubmission' => \App\Models\VerificationSubmission::where('user_id', $user->id)->first(),
            'hasSubscription'        => $user->hasActiveSubscription(),
            'deposits'               => $user->deposits()->latest()->get(),
            'classifieds'            => $classifieds,
            'membershipPlans'        => $membershipPlans,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Upload / change the user's profile photo.
     */
    public function uploadPhoto(Request $request): RedirectResponse
    {
        $request->validate([
            'profile_photo' => ['required', 'image', 'mimes:jpg,jpeg,png,webp,gif', 'max:4096'],
        ]);

        $user = $request->user();

        // Delete old photo if exists
        if ($user->profile_photo && Storage::disk('public')->exists($user->profile_photo)) {
            Storage::disk('public')->delete($user->profile_photo);
        }

        // Store new photo
        $path = $request->file('profile_photo')->store('profile-photos', 'public');

        $user->update(['profile_photo' => $path]);

        return Redirect::route('profile.edit')->with('status', 'photo-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        // Register deletion request
        $user->update(['deletion_requested_at' => now()]);

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::route('login')->with('status', 'Your account deletion request has been submitted and is pending admin approval.');
    }
}
