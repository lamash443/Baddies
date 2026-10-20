<?php

namespace App\Http\Controllers;

use App\Models\Visitor;
use App\Services\GeoLocationService;
use Illuminate\Http\Request;

class VisitorTrackerController extends Controller
{
    /**
     * Receive visitor heartbeat pings to track active time on site.
     */
    public function heartbeat(Request $request)
    {
        $ip = $request->ip();
        if (!$ip) {
            return response()->json(['status' => 'ignored']);
        }

        $seconds = (int) $request->input('seconds', 15);
        $seconds = max(5, min(60, $seconds));

        $date = now()->toDateString();
        $now = now();

        $visitor = Visitor::where('ip_address', $ip)
            ->where('visit_date', $date)
            ->latest('id')
            ->first();

        if (!$visitor) {
            $geo = GeoLocationService::lookup($ip);
            $visitor = Visitor::create([
                'ip_address' => $ip,
                'visit_date' => $date,
                'user_agent' => $request->userAgent(),
                'first_visit_at' => $now,
                'last_visit_at' => $now,
                'visits_count' => 1,
                'total_time_seconds' => $seconds,
                'country' => $geo['country'] ?? null,
                'country_code' => $geo['country_code'] ?? null,
                'city' => $geo['city'] ?? null,
                'region' => $geo['region'] ?? null,
            ]);
        } else {
            $visitor->increment('total_time_seconds', $seconds);
            $visitor->update(['last_visit_at' => $now]);
        }

        return response()->json(['status' => 'ok']);
    }
}
