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
    public function edit(Request $request)
    {
        $user = $request->user();
        $deposits = $user->deposits()->latest()->paginate(6, ['*'], 'deposits_page')->withQueryString();

        $userClassifiedsQuery = \App\Models\Classified::where('user_id', $user->id);
        $classifiedsStats = [
            'unpublished'   => (clone $userClassifiedsQuery)->where('payment_status', 'pending')->count(),
            'in_moderation' => (clone $userClassifiedsQuery)->where('status', 'pending')->count(),
            'approved'      => (clone $userClassifiedsQuery)->where('status', 'approved')->where('payment_status', 'paid')->count(),
            'rejected'      => (clone $userClassifiedsQuery)->where('status', 'rejected')->count(),
        ];
        $classifieds = (clone $userClassifiedsQuery)->latest()->paginate(6, ['*'], 'classifieds_page')->withQueryString();

        if ($request->ajax() || $request->wantsJson()) {
            if ($request->has('classifieds_page')) {
                return response()->json([
                    'html' => view('profile.partials.classifieds-history', ['classifieds' => $classifieds])->render()
                ]);
            }
            return response()->json([
                'html' => view('profile.partials.wallet-history', ['deposits' => $deposits])->render()
            ]);
        }

        $membershipPlans = MembershipPlan::whereNotIn('slug', ['chat'])->get();

        $sessions = [];
        if (config('session.driver') === 'database') {
            $rawSessions = \Illuminate\Support\Facades\DB::table('sessions')
                ->where('user_id', $user->id)
                ->orderBy('last_activity', 'desc')
                ->get();

            foreach ($rawSessions as $session) {
                $ua = $this->parseUserAgent($session->user_agent);
                $sessions[] = (object) [
                    'id'                => $session->id,
                    'ip_address'        => $session->ip_address,
                    'is_current_device' => $session->id === $request->session()->getId(),
                    'platform'          => $ua->platform,
                    'browser'           => $ua->browser,
                    'device'            => $ua->device,
                    'last_active'       => \Carbon\Carbon::createFromTimestamp($session->last_activity)->diffForHumans(),
                ];
            }
        }

        return view('profile.edit', [
            'user'                   => $user,
            'photos'                 => UserPhoto::where('user_id', $user->id)->latest()->get(),
            'videos'                 => UserVideo::where('user_id', $user->id)->latest()->get(),
            'verificationSubmission' => \App\Models\VerificationSubmission::where('user_id', $user->id)->first(),
            'hasSubscription'        => $user->hasActiveSubscription(),
            'deposits'               => $deposits,
            'classifieds'            => $classifieds,
            'classifiedsStats'       => $classifiedsStats,
            'membershipPlans'        => $membershipPlans,
            'sessions'               => $sessions,
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
    public function uploadPhoto(Request $request)
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

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'status' => 'success',
                'path' => asset('storage/' . $path)
            ]);
        }

        return Redirect::route('profile.edit')->with('status', 'photo-updated');
    }
    /**
     * Delete the user's profile photo.
     */
    public function deletePhoto(Request $request)
    {
        $user = $request->user();

        if ($user->profile_photo && Storage::disk('public')->exists($user->profile_photo)) {
            Storage::disk('public')->delete($user->profile_photo);
            $user->update(['profile_photo' => null]);
        }

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'status' => 'success',
                'initials_url' => 'https://ui-avatars.com/api/?name=' . urlencode(substr($user->name, 0, 2)) . '&background=ff8c00&color=000&size=200&bold=true'
            ]);
        }

        return Redirect::route('profile.edit')->with('status', 'photo-deleted');
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

    /**
     * Terminate a specific user session.
     */
    public function terminateSession(Request $request, string $id): RedirectResponse
    {
        if ($id === $request->session()->getId()) {
            return back()->withErrors(['session' => 'You cannot terminate your current session. Please log out instead.']);
        }

        \Illuminate\Support\Facades\DB::table('sessions')
            ->where('user_id', $request->user()->id)
            ->where('id', $id)
            ->delete();

        return Redirect::route('profile.edit', ['#tab-settings'])->with('status', 'session-terminated');
    }

    /**
     * Terminate all other active user sessions.
     */
    public function terminateAllOtherSessions(Request $request): RedirectResponse
    {
        $currentSessionId = $request->session()->getId();

        \Illuminate\Support\Facades\DB::table('sessions')
            ->where('user_id', $request->user()->id)
            ->where('id', '!=', $currentSessionId)
            ->delete();

        return Redirect::route('profile.edit', ['#tab-settings'])->with('status', 'other-sessions-terminated');
    }

    /**
     * Helper to parse user agent string and return OS, Browser, Device types.
     */
    private function parseUserAgent(?string $userAgent): object
    {
        if (!$userAgent) {
            return (object) [
                'platform' => 'Unknown OS',
                'browser' => 'Unknown Browser',
                'device' => 'Desktop',
            ];
        }

        // Detect OS / Platform
        $os = 'Unknown OS';
        $osArray = [
            '/windows nt 10/i'      =>  'Windows 10/11',
            '/windows nt 6.3/i'     =>  'Windows 8.1',
            '/windows nt 6.2/i'     =>  'Windows 8',
            '/windows nt 6.1/i'     =>  'Windows 7',
            '/windows nt 6.0/i'     =>  'Windows Vista',
            '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
            '/windows nt 5.1/i'     =>  'Windows XP',
            '/windows xp/i'         =>  'Windows XP',
            '/macintosh|mac os x/i' =>  'macOS',
            '/linux/i'              =>  'Linux',
            '/ubuntu/i'             =>  'Ubuntu',
            '/iphone/i'             =>  'iPhone',
            '/ipod/i'               =>  'iPod',
            '/ipad/i'               =>  'iPad',
            '/android/i'            =>  'Android',
            '/blackberry/i'         =>  'BlackBerry',
            '/webos/i'              =>  'Mobile'
        ];

        foreach ($osArray as $regex => $value) {
            if (preg_match($regex, $userAgent)) {
                $os = $value;
                break;
            }
        }

        // Detect Browser
        $browser = 'Unknown Browser';
        $browserArray = [
            '/msie/i'      => 'Internet Explorer',
            '/firefox/i'   => 'Firefox',
            '/safari/i'    => 'Safari',
            '/chrome/i'    => 'Chrome',
            '/edge/i'      => 'Edge',
            '/opera/i'     => 'Opera',
            '/netscape/i'  => 'Netscape',
            '/maxthon/i'   => 'Maxthon',
            '/konqueror/i' => 'Konqueror',
            '/mobile/i'    => 'Handheld Browser'
        ];

        foreach ($browserArray as $regex => $value) {
            if (preg_match($regex, $userAgent)) {
                $browser = $value;
                break;
            }
        }

        // Handheld vs Desktop
        $device = 'Desktop';
        if (preg_match('/(tablet|ipad|playbook)|(android(?!.*mobi))/i', $userAgent)) {
            $device = 'Tablet';
        } elseif (preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|android|iemobile)/i', $userAgent)) {
            $device = 'Mobile';
        }

        return (object) [
            'platform' => $os,
            'browser' => $browser,
            'device' => $device,
        ];
    }
}
