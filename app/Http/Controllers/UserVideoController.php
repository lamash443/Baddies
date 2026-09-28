<?php

namespace App\Http\Controllers;

use App\Models\UserVideo;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class UserVideoController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        // 1. Handle PHP post_max_size / upload_max_filesize limit error on Ubuntu / Linux servers
        if ($request->hasFile('video') && !$request->file('video')->isValid()) {
            $errorCode = $request->file('video')->getError();
            if ($errorCode === UPLOAD_ERR_INI_SIZE || $errorCode === UPLOAD_ERR_FORM_SIZE) {
                return back()->withFragment('tab-publish-media')->withErrors([
                    'video' => 'The uploaded video exceeds the server\'s upload limit (upload_max_filesize / post_max_size in php.ini).'
                ]);
            }
        }

        // 2. Validate video file — support all common extensions & MIME types on Ubuntu
        $request->validate([
            'video' => [
                'required',
                'file',
                'max:102400', // 100MB max limit
                function ($attribute, $value, $fail) {
                    if (!$value || !$value->isValid()) {
                        $fail('Invalid video file or upload was interrupted.');
                        return;
                    }

                    $ext = strtolower($value->getClientOriginalExtension());
                    $validExtensions = [
                        'mp4', 'mov', 'avi', 'mkv', 'webm', '3gp', '3gpp',
                        'flv', 'wmv', 'm4v', 'mpg', 'mpeg', 'ogv', 'qt', 'ts'
                    ];

                    $mime = strtolower($value->getMimeType() ?? '');

                    $isMimeValid = str_starts_with($mime, 'video/')
                        || $mime === 'application/octet-stream'
                        || $mime === 'application/x-mpegurl'
                        || $mime === 'application/vnd.apple.mpegurl';

                    if (!in_array($ext, $validExtensions) && !$isMimeValid) {
                        $fail('The uploaded file must be a valid video format (MP4, MOV, WEBM, AVI, MKV, 3GP, etc.). Detected format: ' . ($ext ?: $mime));
                    }
                }
            ],
        ]);

        $user = auth()->user();

        if ($user->videosCountForLimit() >= $user->video_limit) {
            return back()->withFragment('tab-publish-media')->withErrors([
                'video' => 'You have reached the video upload limit for your current subscription plan.'
            ]);
        }

        try {
            // Ensure target directory exists on Linux filesystem
            $directory = 'user-videos/' . $user->id;
            if (!Storage::disk('public')->exists($directory)) {
                Storage::disk('public')->makeDirectory($directory);
            }

            $path = $request->file('video')->store($directory, 'public');

            if (!$path) {
                throw new \Exception('Failed to write video file to storage disk.');
            }

            UserVideo::create([
                'user_id' => auth()->id(),
                'path'    => $path,
                'title'   => $request->input('title'),
            ]);

            return back()->withFragment('tab-publish-media')->with('video_upload_success', 'Video uploaded successfully.');

        } catch (\Exception $e) {
            Log::error('Video Upload Exception on Ubuntu: ' . $e->getMessage());
            return back()->withFragment('tab-publish-media')->withErrors([
                'video' => 'Error saving video to server: ' . $e->getMessage() . '. Please verify storage folder permissions.'
            ]);
        }
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
