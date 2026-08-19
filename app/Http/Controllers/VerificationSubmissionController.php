<?php

namespace App\Http\Controllers;

use App\Models\VerificationSubmission;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VerificationSubmissionController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'photo' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ]);

        $path = $request->file('photo')->store('verification-photos', 'public');

        // Overwrite existing submission if any
        VerificationSubmission::updateOrCreate(
            ['user_id' => auth()->id()],
            [
                'photo_path' => $path,
                'status'     => 'pending',
            ]
        );

        return back()->with('verification_upload_success', 'Verification photo submitted successfully. Please wait for admin approval.');
    }
}
