<?php

namespace App\Http\Controllers;

use App\Models\UserVideo;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserVideoController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'video' => ['required', 'file', 'mimes:mp4,webm,ogg', 'max:102400'], // 100MB
        ]);

        $user = auth()->user();

        if ($user->videosCountForLimit() >= $user->video_limit) {
            return back()->withFragment('tab-publish-media')->withErrors(['video' => 'You have reached the video upload limit for your current subscription plan.']);
        }

        $path = $request->file('video')->store('user-videos/' . $user->id, 'public');

        UserVideo::create([
            'user_id' => auth()->id(),
            'path'    => $path,
            'title'   => $request->input('title'),
        ]);

        return back()->withFragment('tab-publish-media')->with('video_upload_success', 'Video uploaded successfully.');
    }

    public function destroy(UserVideo $video): RedirectResponse
    {
        abort_unless($video->user_id === auth()->id(), 403);

        if (Storage::disk('public')->exists($video->path)) {
            Storage::disk('public')->delete($video->path);
        }

        $video->delete();

        return back()->withFragment('tab-publish-media')->with('video_delete_success', 'Video deleted.');
    }

    public function incrementView($id)
    {
        $video = UserVideo::findOrFail($id);

        $sessionKey = 'viewed_video_' . $id;
        if (!session()->has($sessionKey)) {
            $video->increment('views');
            session()->put($sessionKey, true);
        }

        return response()->json(['success' => true, 'views' => $video->views]);
    }
}
