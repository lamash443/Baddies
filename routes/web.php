<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserPhotoController;
use App\Http\Controllers\UserVideoController;
use App\Http\Controllers\VerificationSubmissionController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // Only verified female (call girl) users
    $users = \App\Models\User::where('is_verified', true)
        ->activeSubscription()
        ->where(function($q) {
            $q->whereIn('gender', ['female', 'Female'])
              ->orWhereNull('gender')
              ->orWhere('gender', '');
        })
        ->with('photos')
        ->latest()
        ->get();

    // VIP tier — subscription_plan = 'vip' with active subscription
    $vipGirls = $users->filter(fn($u) =>
        $u->subscription_plan === 'vip' && $u->hasActiveSubscription()
    )->values();

    // Prime VIP tier — subscription_plan = 'prime_vip' with active subscription
    $primeVipGirls = $users->filter(fn($u) =>
        in_array($u->subscription_plan, ['prime_vip', 'prime-vip']) && $u->hasActiveSubscription()
    )->values();

    // Prime tier — subscription_plan = 'prime' with active subscription
    $primeGirls = $users->filter(fn($u) =>
        $u->subscription_plan === 'prime' && $u->hasActiveSubscription()
    )->values();

    // Regular tier — subscription_plan = 'regular' with active subscription
    $regularGirls = $users->filter(fn($u) =>
        $u->subscription_plan === 'regular' && $u->hasActiveSubscription()
    )->values();

    return view('welcome', compact('vipGirls', 'primeVipGirls', 'primeGirls', 'regularGirls'));
})->name('home');

Route::get('/escort-girls', function () {
    $users = \App\Models\User::where('is_verified', true)
        ->activeSubscription()
        ->where(function($q) {
            $q->whereIn('gender', ['female', 'Female'])
              ->orWhereNull('gender')
              ->orWhere('gender', '');
        })
        ->with('photos')
        ->latest()
        ->get();

    $vipGirls     = $users->filter(fn($u) => $u->subscription_plan === 'vip' && $u->hasActiveSubscription())->values();
    $primeVipGirls= $users->filter(fn($u) => in_array($u->subscription_plan, ['prime_vip', 'prime-vip']) && $u->hasActiveSubscription())->values();
    $primeGirls   = $users->filter(fn($u) => $u->subscription_plan === 'prime' && $u->hasActiveSubscription())->values();
    $regularGirls = $users->filter(fn($u) => $u->subscription_plan === 'regular' && $u->hasActiveSubscription())->values();

    return view('escort-girls', compact('vipGirls', 'primeVipGirls', 'primeGirls', 'regularGirls'));
})->name('escort-girls');

Route::get('/classifieds', function (\Illuminate\Http\Request $request) {
    $query = \App\Models\Classified::where('payment_status', 'paid')
        ->where('status', 'approved');
        
    if ($request->has('category')) {
        $query->where('category', $request->category);
    }
        
    $classifieds = $query->latest()->get();
        
    return view('classifieds', compact('classifieds'));
})->name('classifieds');

Route::get('/classifieds/{id}', function ($id) {
    $classified = \App\Models\Classified::where('id', $id)
        ->where('payment_status', 'paid')
        ->where('status', 'approved')
        ->firstOrFail();
        
    return view('classifieds-show', compact('classified'));
})->name('classifieds.show');

Route::get('/videos', function () {
    $videos = \App\Models\UserVideo::with('user')
        ->whereHas('user', function($q) {
            $q->where('is_verified', true)
              ->activeSubscription();
        })
        ->latest()
        ->get();
    return view('videos', compact('videos'));
})->name('videos');

Route::get('/search', function (\Illuminate\Http\Request $request) {
    $q = trim($request->input('q', ''));

    $users       = collect();
    $classifieds = collect();
    $isKnownLocation = false;

    // Master list of all known Kenyan locations used across the site
    $knownLocations = array_map('strtolower', [
        // Counties
        'Nairobi','Mombasa','Nakuru','Kiambu','Kisumu','Machakos','Kajiado','Uasin Gishu',
        'Kilifi','Meru','Nyeri','Embu','Kakamega','Bungoma','Bomet','Kisii','Migori',
        'Homa Bay','Siaya','Vihiga','Trans Nzoia','Nandi','Elgeyo Marakwet','Baringo',
        'Laikipia','Nyandarua','Murang\'a','Kirinyaga','Tharaka Nithi','Isiolo','Garissa',
        'Wajir','Mandera','Marsabit','Samburu','Turkana','West Pokot','Lamu','Taita Taveta',
        'Kwale','Tana River','Narok','Kericho','Nyamira','Rachuonyo',
        // Nairobi Areas
        'Allsops','Banana','Buruburu','Chokaa','Dagoretti','Dandora','Donholm','Eastlands',
        'Eastleigh','Embakasi','Garden City','Githurai 44','Githurai 45','Homeland',
        'Hurlingham','Huruma','Imara Daima','Jamhuri','Joska','Juja','Kabete','Kahawa Sukari',
        'Kahawa Wendani','Kahawa West','Kamulu','Kangemi','Karen','Kariobangi','Kasarani',
        'Kawangware','Kayole','Kenyatta Road','Kibera','Kikuyu','Kileleshwa','Kilimani',
        'Kitengela','Kitisuru','Komarock','Langata','Lavington','Loresho','Madaraka',
        'Makadara','Malaa','Mathare','Milimani','Mlolongo','Muthaiga','Muthangari',
        'Muthurwa','Mwiki','Nairobi Town','Nairobi West','Ndenderu','Ngara','Ngong',
        'Ngumba','Njiru','Pangani','Parklands','Roasters','Ongata Rongai','Roysambu',
        'Ruai','Ruaka','Ruaraka','Ruiru','Runda','Saika','South B','South C','Syokimau',
        'Thogoto','Thome','Umoja','Upper Hill','Utawala','Uthiru','Westlands',
        // Major Roads
        'James Gichuru Road','Southern Bypass','Gitanga Road','Naivasha Road',
        'Northern Bypass','Eastern Bypass','Manyanja Rd','Waiyaki Way','Kiambu Road',
        'Langata Road','Outering Road','Kangundo Road','Ngong Road','Kamiti Road',
        'Jogoo Road','Mombasa Road','Thika Road',
    ]);

    if ($q !== '') {
        $users = \App\Models\User::where('is_verified', true)
            ->activeSubscription()
            ->where(function ($query) use ($q) {
                $query->where('name', 'LIKE', '%' . $q . '%')
                      ->orWhere('county', 'LIKE', '%' . $q . '%')
                      ->orWhere('city_town', 'LIKE', '%' . $q . '%')
                      ->orWhere('location', 'LIKE', '%' . $q . '%')
                      ->orWhere('area', 'LIKE', '%' . $q . '%')
                      ->orWhere('subscription_plan', 'LIKE', '%' . $q . '%');
            })
            ->with('photos')
            ->latest()
            ->get();

        $classifieds = \App\Models\Classified::where('payment_status', 'paid')
            ->where('status', 'approved')
            ->where(function ($query) use ($q) {
                $query->where('title', 'LIKE', '%' . $q . '%')
                      ->orWhere('category', 'LIKE', '%' . $q . '%')
                      ->orWhere('description', 'LIKE', '%' . $q . '%')
                      ->orWhere('city', 'LIKE', '%' . $q . '%');
            })
            ->latest()
            ->get();

        // Check if query matches a known Kenyan location
        $isKnownLocation = in_array(strtolower($q), $knownLocations)
            || collect($knownLocations)->contains(fn($loc) => str_contains($loc, strtolower($q)) || str_contains(strtolower($q), $loc));
    }

    return view('search', compact('users', 'classifieds', 'q', 'isKnownLocation'));
})->name('search');

Route::get('/category/call-boys', function () {
    $users = \App\Models\User::whereIn('gender', ['male', 'Male'])
        ->where('is_verified', true)
        ->activeSubscription()
        ->with('photos')
        ->get();
        
    $vipUsers = $users->filter(function($u) {
        return in_array($u->subscription_plan, ['vip', 'prime_vip', 'prime-vip']) && $u->hasActiveSubscription();
    });
    
    $regularUsers = $users->filter(function($u) {
        return !in_array($u->subscription_plan, ['vip', 'prime_vip', 'prime-vip']) || !$u->hasActiveSubscription();
    });

    return view('call-boys', compact('vipUsers', 'regularUsers'));
})->name('call-boys');

Route::get('/location/{name}', function ($name) {
    // Decode the location name (e.g. from %20 to space)
    $searchLocation = urldecode($name);

    // Filter inputs
    $gender      = request('gender');
    $orientation = request('orientation');
    $sort        = request('sort', 'featured');

    $query = \App\Models\User::where('is_verified', true)
        ->activeSubscription()
        ->where(function ($q) use ($searchLocation) {
            $q->where('county', 'LIKE', '%' . $searchLocation . '%')
              ->orWhere('city_town', 'LIKE', '%' . $searchLocation . '%')
              ->orWhere('location', 'LIKE', '%' . $searchLocation . '%')
              ->orWhere('area', 'LIKE', '%' . $searchLocation . '%');
        })
        ->with('photos');

    // Apply gender filter
    if ($gender && $gender !== '') {
        $query->where('gender', 'LIKE', '%' . $gender . '%');
    }

    // Apply sexual orientation filter
    if ($orientation && $orientation !== '') {
        $query->where('sexual_orientation', 'LIKE', '%' . $orientation . '%');
    }

    // Apply sort
    match ($sort) {
        'newest'    => $query->orderBy('created_at', 'desc'),
        'oldest'    => $query->orderBy('created_at', 'asc'),
        'name_asc'  => $query->orderBy('name', 'asc'),
        default     => $query->orderByRaw("FIELD(subscription_plan,'prime_vip','prime-vip','prime','vip','regular') ASC"),
    };

    $users = $query->paginate(16)->withQueryString();

    $vipUsers     = $users->getCollection()->filter(fn($u) =>
        in_array($u->subscription_plan, ['vip', 'prime_vip', 'prime-vip', 'prime']) && $u->hasActiveSubscription()
    );
    $regularUsers = $users->getCollection()->filter(fn($u) =>
        !in_array($u->subscription_plan, ['vip', 'prime_vip', 'prime-vip', 'prime']) || !$u->hasActiveSubscription()
    );

    return view('location', compact('users', 'vipUsers', 'regularUsers', 'searchLocation', 'gender', 'orientation', 'sort'));
})->name('location.show');

// Public profile view
Route::get('/profile/{id}', function ($id) {
    $user = \App\Models\User::with(['photos', 'videos'])
        ->where('is_verified', true)
        ->findOrFail($id);

    // If the profile is hidden from the public, only allow the owner or admin to view it
    if ($user->is_profile_hidden && auth()->id() !== $user->id && !(auth()->check() && auth()->user()->is_admin)) {
        return redirect()->route('home')->with([
            'toast_title' => 'Profile Hidden',
            'toast_msg'   => 'This profile has been hidden from the public by its owner.',
            'toast_type'  => 'warning',
        ]);
    }

    // Increment profile views (not tracking unique per IP for simplicity yet)
    $user->increment('profile_views');

    $stat = \Illuminate\Support\Facades\DB::table('profile_statistics')
        ->where('user_id', $user->id)
        ->where('date', now()->toDateString())
        ->first();

    if ($stat) {
        \Illuminate\Support\Facades\DB::table('profile_statistics')
            ->where('id', $stat->id)
            ->increment('views');
    } else {
        \Illuminate\Support\Facades\DB::table('profile_statistics')->insert([
            'user_id' => $user->id,
            'date' => now()->toDateString(),
            'views' => 1,
            'phone_calls' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    // Similar profiles: prioritise same subscription plan, then fill with others
    $viewedPlan = $user->subscription_plan ?? 'regular';

    // Pass 1: same gender + same plan (up to 6)
    // Pass 1: same gender + same plan (up to 6)
    $samePlanProfiles = \App\Models\User::with('photos')
        ->where('is_verified', true)
        ->activeSubscription()
        ->where('id', '!=', $user->id)
        ->when(auth()->check(), fn($q) => $q->where('id', '!=', auth()->id()))
        ->when($user->gender, fn($q) => $q->where('gender', $user->gender))
        ->where('subscription_plan', $viewedPlan)
        ->inRandomOrder()
        ->limit(6)
        ->get();

    $remaining = 6 - $samePlanProfiles->count();

    // Pass 2: fill remaining slots with any other plan (exclude already fetched IDs)
    $otherProfiles = collect();
    if ($remaining > 0) {
        $excludeIds = $samePlanProfiles->pluck('id')->push($user->id);
        if (auth()->check()) {
            $excludeIds->push(auth()->id());
        }
        $otherProfiles = \App\Models\User::with('photos')
            ->where('is_verified', true)
            ->activeSubscription()
            ->whereNotIn('id', $excludeIds)
            ->when($user->gender, fn($q) => $q->where('gender', $user->gender))
            ->inRandomOrder()
            ->limit($remaining)
            ->get();
    }

    // Merge: same-plan first, then others
    $similarProfiles = $samePlanProfiles->concat($otherProfiles);


    return view('profile-view', compact('user', 'similarProfiles'));
})->where('id', '[0-9]+')->name('profile.view');

// Track phone clicks
Route::post('/profile/{id}/track-call', function ($id) {
    $user = \App\Models\User::where('is_verified', true)->findOrFail($id);
    $user->increment('phone_calls');

    $stat = \Illuminate\Support\Facades\DB::table('profile_statistics')
        ->where('user_id', $user->id)
        ->where('date', now()->toDateString())
        ->first();

    if ($stat) {
        \Illuminate\Support\Facades\DB::table('profile_statistics')
            ->where('id', $stat->id)
            ->increment('phone_calls');
    } else {
        \Illuminate\Support\Facades\DB::table('profile_statistics')->insert([
            'user_id' => $user->id,
            'date' => now()->toDateString(),
            'views' => 0,
            'phone_calls' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    return response()->json(['success' => true]);
    return response()->json(['success' => true]);
})->where('id', '[0-9]+')->name('profile.track-call');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile/statistics', function (\Illuminate\Http\Request $request) {
        $period = $request->query('period', '30');
        $user = auth()->user();
        
        $startDate = match ($period) {
            'today' => now()->startOfDay(),
            '7' => now()->subDays(6)->startOfDay(),
            '30' => now()->subDays(29)->startOfDay(),
            'all' => now()->subYears(10),
            default => now()->subDays(29)->startOfDay(),
        };

        $stats = \Illuminate\Support\Facades\DB::table('profile_statistics')
            ->where('user_id', $user->id)
            ->where('date', '>=', $startDate->toDateString())
            ->orderBy('date', 'asc')
            ->get();
            
        $labels = [];
        $viewsData = [];
        $callsData = [];
        
        if ($period !== 'all' && $period !== 'today') {
            $days = (int) $period;
            for ($i = $days - 1; $i >= 0; $i--) {
                $dateStr = now()->subDays($i)->toDateString();
                $labels[] = now()->subDays($i)->format('M d');
                
                $stat = $stats->firstWhere('date', $dateStr);
                $viewsData[] = $stat ? $stat->views : 0;
                $callsData[] = $stat ? $stat->phone_calls : 0;
            }
        } elseif ($period === 'today') {
            $dateStr = now()->toDateString();
            $labels[] = 'Today';
            $stat = $stats->firstWhere('date', $dateStr);
            $viewsData[] = $stat ? $stat->views : 0;
            $callsData[] = $stat ? $stat->phone_calls : 0;
        } else {
            foreach ($stats as $stat) {
                $labels[] = \Carbon\Carbon::parse($stat->date)->format('M d, Y');
                $viewsData[] = $stat->views;
                $callsData[] = $stat->phone_calls;
            }
        }
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(compact('labels', 'viewsData', 'callsData', 'period'));
        }

        return view('profile.statistics', compact('labels', 'viewsData', 'callsData', 'period'));
    })->name('profile.statistics');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile', [ProfileController::class, 'update']); // fallback for browsers missing _method field
    Route::post('/profile/photo', [ProfileController::class, 'uploadPhoto'])->name('profile.photo');
    Route::delete('/profile/photo', [ProfileController::class, 'deletePhoto'])->name('profile.photo.delete');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile/sessions/{id}/terminate', [ProfileController::class, 'terminateSession'])->name('profile.sessions.terminate');
    Route::post('/profile/sessions/terminate-others', [ProfileController::class, 'terminateAllOtherSessions'])->name('profile.sessions.terminate-others');
    Route::post('/profile/toggle-calls', [ProfileController::class, 'toggleCalls'])->name('profile.toggle-calls');
    Route::post('/profile/toggle-visibility', [ProfileController::class, 'toggleProfileVisibility'])->name('profile.toggle-visibility');
    // User Photos
    Route::post('/profile/photos', [UserPhotoController::class, 'store'])->name('user.photos.store');
    Route::post('/profile/photos/{photo}/set-main', [UserPhotoController::class, 'setMain'])->name('user.photos.set-main');
    Route::delete('/profile/photos/{photo}', [UserPhotoController::class, 'destroy'])->name('user.photos.destroy');
    // User Videos
    Route::post('/profile/videos', [UserVideoController::class, 'store'])->name('user.videos.store');
    Route::delete('/profile/videos/{video}', [UserVideoController::class, 'destroy'])->name('user.videos.destroy');
    // Verification
    Route::post('/profile/verification', [VerificationSubmissionController::class, 'store'])->name('verification.submit');
    Route::get('/verify-account', function () {
        return view('verify-account');
    })->name('account.verify');

    // Chat System
    Route::get('/chat', function () {
        if (!auth()->user()->hasActiveChatSubscription()) {
            return redirect()->route('chat.memberships')->with('error', 'You need an active chat subscription to message members.');
        }
        return view('chat.index');
    })->name('chat.index');

    Route::get('/chat/{user_id}', function ($user_id) {
        if (!auth()->user()->hasActiveChatSubscription()) {
            return redirect()->route('chat.memberships')->with('error', 'You need an active chat subscription to message members.');
        }
        if (auth()->id() == $user_id) {
            return redirect()->route('chat.index');
        }
        return view('chat.index', ['activeUserId' => $user_id]);
    })->name('chat.show');

    Route::get('/chat-memberships', function () {
        $chatPlan = \App\Models\MembershipPlan::where('slug', 'chat')->first();
        return view('chat-memberships', compact('chatPlan'));
    })->name('chat.memberships');
    Route::get('/chat-checkout', function () {
        $chatPlan = \App\Models\MembershipPlan::where('slug', 'chat')->first();
        return view('chat-checkout', compact('chatPlan'));
    })->name('chat.checkout');
    Route::get('/regular-checkout', function () {
        $plan = \App\Models\MembershipPlan::where('slug', 'regular')->first();
        return view('regular-checkout', compact('plan'));
    })->name('membership.regular.checkout');
    Route::get('/prime-checkout', function () {
        $plan = \App\Models\MembershipPlan::where('slug', 'prime')->first();
        return view('prime-checkout', compact('plan'));
    })->name('membership.prime.checkout');
    Route::get('/prime-vip-checkout', function () {
        $plan = \App\Models\MembershipPlan::where('slug', 'prime-vip')->first();
        return view('prime-vip-checkout', compact('plan'));
    })->name('membership.prime-vip.checkout');
    Route::get('/vip-checkout', function () {
        $plan = \App\Models\MembershipPlan::where('slug', 'vip')->first();
        return view('vip-checkout', compact('plan'));
    })->name('membership.vip.checkout');
    
    Route::post('/membership/process', function (\Illuminate\Http\Request $request) {
        $request->validate([
            'plan_type' => 'required|string',
        ]);
        
        // plan and payment_method are only required for non-classified flows
        if ($request->plan_type !== 'classified') {
            $request->validate([
                'plan'           => 'required|integer',
                'payment_method' => 'required|string',
            ]);
        }
        $pricing = [];
        $planLimits = [];

        \App\Models\MembershipPlan::all()->each(function ($plan) use (&$pricing, &$planLimits) {
            if ($plan->pricing) {
                $pricing[$plan->slug] = collect($plan->pricing)->mapWithKeys(fn($v, $k) => [(int)$k => (int)$v])->all();
            }
            $planLimits[$plan->slug] = [
                'photo_limit' => $plan->photo_limit,
                'video_limit' => $plan->video_limit,
            ];
        });

        $planType = $request->plan_type;
        $planDays = (int) $request->plan;

        if ($planType === 'classified') {
            $request->validate([
                'title' => 'required|string|max:255',
                'category' => 'required|in:personals,jobs,massage,events',
                'image' => 'required|image|max:5120',
            ]);

            $cost = 1000.00;
            $paymentStatus = 'pending';

            if ($request->payment_method === 'wallet') {
                $user = auth()->user();
                if ($user->wallet_balance < $cost) {
                    return redirect()->route('profile.edit', ['#tab-wallet'])->withErrors(['wallet' => 'Insufficient wallet balance. Please add funds.']);
                }
                $user->decrement('wallet_balance', $cost);
                $paymentStatus = 'paid';
            }

            $imagePath = $request->file('image')->store('classifieds', 'public');
            
            $classified = \App\Models\Classified::create([
                'user_id' => auth()->id(),
                'title' => $request->title,
                'category' => $request->category,
                'city' => $request->city,
                'image_path' => $imagePath,
                'description' => $request->description,
                'phone' => $request->phone,
                'contact_name' => $request->contact_name,
                'amount' => $cost,
                'payment_status' => $paymentStatus,
                'status' => 'approved',
            ]);

            if ($paymentStatus === 'paid') {
                return redirect()->route('profile.edit', ['#tab-wallet'])
                    ->with('success', 'Your classified post has been published! Your wallet has been debited KSh ' . number_format($cost, 2) . '.');
            }

            session(['checkout_plan_type' => 'classified', 'checkout_amount' => $cost, 'classified_id' => $classified->id]);
            return redirect()->route('checkout.mpesa');
        }

        if ($request->payment_method === 'wallet') {
            if (!isset($pricing[$planType]) || !isset($pricing[$planType][$planDays])) {
                return back()->withErrors(['plan' => 'Invalid plan selected.']);
            }

            $cost = $pricing[$planType][$planDays];
            $user = auth()->user();

            if ($user->wallet_balance < $cost) {
                return redirect()->route('profile.edit', ['#tab-wallet'])->withErrors(['wallet' => 'Insufficient wallet balance. Please add funds.']);
            }

            // Deduct cost from wallet
            $user->decrement('wallet_balance', $cost);

            if ($planType === 'chat') {
                $planName = $planDays == 1 ? '1 Day Chat Plan' : ($planDays == 3 ? '3 Day Chat Plan' : $planDays . ' Days Chat Plan');
                $user->update([
                    'chat_plan'        => $planName,
                    'chat_expires_at'  => now()->addDays($planDays),
                ]);
            } else {
                // If the user's previous subscription already expired, wipe their old media before applying the new one
                $user->purgeMediaIfSubscriptionExpired();

                $updateData = [
                    'subscription_plan'       => $planType,
                    'subscription_expires_at' => now()->addDays($planDays),
                ];
                // Apply photo/video limits
                if (isset($planLimits[$planType])) {
                    $updateData['photo_limit'] = $planLimits[$planType]['photo_limit'];
                    $updateData['video_limit'] = $planLimits[$planType]['video_limit'];
                }
                $user->update($updateData);
            }

            $planLabel = strtoupper($planType) . ' (' . $planDays . ' days)';

            // Log the subscription activity
            activity()
                ->causedBy($user)
                ->withProperties(['plan' => $planType, 'days' => $planDays, 'cost' => $cost, 'method' => 'wallet'])
                ->log("Subscribed to {$planLabel} plan via wallet");

            // Redirect: chat plan goes to chat-memberships, others go to profile publish-media tab
            if ($planType === 'chat') {
                return redirect()->route('chat.memberships')->with('success', "You're now subscribed to the {$planLabel} plan!");
            }
            return redirect()->to(route('profile.edit') . '#tab-publish-media')->with('success', "You're now subscribed to the {$planLabel} plan!");
        }
        
        // Save to session or database to process later for MPESA
        session(['checkout_plan_type' => $planType, 'checkout_plan' => $planDays]);
        
        // If phone is provided directly in the form, store in session and redirect to mpesa checkout
        if ($request->has('mpesaPhone') && $request->mpesaPhone) {
            $suffix = preg_replace('/\D/', '', $request->mpesaPhone);
            // Strip leading 254 if user accidentally entered it, keep just 9 digits
            $suffix = ltrim($suffix, '254');
            $suffix = substr($suffix, -9);
            session(['checkout_prefilled_phone' => $suffix]);
        }

        // Redirect to dedicated MPESA checkout page
        return redirect()->route('checkout.mpesa');
    })->name('membership.process');

    Route::get('/checkout-mpesa', function () {
        return view('mpesa-checkout');
    })->name('checkout.mpesa');

    Route::get('/wallet/add-funds', function () {
        $deposits = auth()->user()->deposits()->latest()->get();
        return view('wallet-add-funds', compact('deposits'));
    })->name('wallet.add');

    Route::post('/wallet/add-funds', function (\Illuminate\Http\Request $request) {
        $request->validate([
            'amount' => 'required|numeric|min:10',
        ]);
        session([
            'checkout_plan_type' => 'wallet',
            'checkout_amount' => $request->amount,
        ]);

        // Log wallet top-up initiation
        activity()
            ->causedBy(auth()->user())
            ->withProperties(['amount' => $request->amount])
            ->log('Initiated wallet top-up of KSh ' . number_format($request->amount, 2));

        return redirect()->route('checkout.mpesa');
    })->name('wallet.add.post');

    Route::post('/payment/initiate', [PaymentController::class, 'initiate'])->name('payment.initiate');
    Route::get('/payment/status/{reference}', [PaymentController::class, 'status'])->name('payment.status');

    // Referral bonus redemption
    Route::post('/referrals/redeem', [\App\Http\Controllers\ReferralController::class, 'redeem'])->name('referrals.redeem');
});


// ── PAYHERO WEBHOOK & PAYMENT ROUTES ──────────────────────────────────────────
// Supports GET / HEAD for health checks & dashboard verification, and POST for payment callbacks
$payheroWebhook = [PaymentController::class, 'webhook'];

Route::match(['GET', 'POST', 'HEAD'], '/webhook/payhero', $payheroWebhook)->name('webhook.payhero');
Route::match(['GET', 'POST', 'HEAD'], '/api/webhook/payhero', $payheroWebhook);
Route::match(['GET', 'POST', 'HEAD'], '/payhero/webhook', $payheroWebhook);
Route::match(['GET', 'POST', 'HEAD'], '/payhero/callback', $payheroWebhook);
Route::match(['GET', 'POST', 'HEAD'], '/api/payhero/webhook', $payheroWebhook);
Route::match(['GET', 'POST', 'HEAD'], '/api/payhero/callback', $payheroWebhook);
Route::match(['GET', 'POST', 'HEAD'], '/payment/callback', $payheroWebhook);
Route::match(['GET', 'POST', 'HEAD'], '/payment/webhook', $payheroWebhook);
Route::match(['GET', 'POST', 'HEAD'], '/api/payment/callback', $payheroWebhook);
Route::match(['GET', 'POST', 'HEAD'], '/api/payment/webhook', $payheroWebhook);
Route::match(['GET', 'POST', 'HEAD'], '/callback/payhero', $payheroWebhook);
Route::match(['GET', 'POST', 'HEAD'], '/payhero-callback', $payheroWebhook);
Route::match(['GET', 'POST', 'HEAD'], '/mpesa/callback', $payheroWebhook);
Route::match(['GET', 'POST', 'HEAD'], '/mpesa/webhook', $payheroWebhook);
Route::match(['GET', 'POST', 'HEAD'], '/api/mpesa/callback', $payheroWebhook);
Route::match(['GET', 'POST', 'HEAD'], '/api/mpesa/webhook', $payheroWebhook);
Route::match(['GET', 'POST', 'HEAD'], '/callback', $payheroWebhook);
Route::match(['GET', 'POST', 'HEAD'], '/api/callback', $payheroWebhook);
Route::match(['GET', 'POST', 'HEAD'], '/webhook', $payheroWebhook);
Route::match(['GET', 'POST', 'HEAD'], '/api/webhook', $payheroWebhook);

// Payment route aliases to prevent 404s
Route::get('/checkout/mpesa', fn () => redirect()->route('checkout.mpesa'));
Route::get('/checkout', fn () => redirect()->route('checkout.mpesa'));
Route::get('/payhero', fn () => redirect()->route('checkout.mpesa'));
Route::get('/payment', fn () => redirect()->route('checkout.mpesa'));
Route::get('/mpesa', fn () => redirect()->route('checkout.mpesa'));
Route::get('/mpesa-checkout', fn () => redirect()->route('checkout.mpesa'));
Route::get('/payhero/checkout', fn () => redirect()->route('checkout.mpesa'));
Route::get('/payment/checkout', fn () => redirect()->route('checkout.mpesa'));


Route::get('/contact', function () {
    $sitePage = \App\Models\Page::where('slug', 'contact')->first();
    return view('contact', compact('sitePage'));
})->name('contact');

Route::post('/contact', function (\Illuminate\Http\Request $request) {
    $key = 'contact-support:' . $request->ip();

    if (\Illuminate\Support\Facades\RateLimiter::tooManyAttempts($key, 3)) {
        return back()->with('throttle_error', 'You have reached the 3 message limit for today. Please try again in 24 hours.');
    }

    $rules = [
        'subject' => 'required|string|max:80',
        'message' => 'required|string|min:5|max:1000',
    ];

    if (!auth()->check()) {
        $rules['name']  = 'required|string|max:50';
        $rules['email'] = 'required|email|max:100';
    }

    $data = $request->validate($rules);

    \App\Models\SupportTicket::create([
        'user_id' => auth()->id(),
        'name' => auth()->check() ? auth()->user()->name : $data['name'],
        'email' => auth()->check() ? auth()->user()->email : $data['email'],
        'subject' => $data['subject'],
        'message' => $data['message'],
        'status' => 'pending',
    ]);

    \Illuminate\Support\Facades\RateLimiter::hit($key, 1440 * 60); // 24 hours

    return back()->with('success', 'Your support ticket has been submitted. Our team will review it soon.');
})->name('contact.submit');

Route::get('/terms', function () {
    $sitePage = \App\Models\Page::where('slug', 'terms')->first();
    return view('terms', compact('sitePage'));
})->name('terms');

Route::get('/privacy', function () {
    $sitePage = \App\Models\Page::where('slug', 'privacy')->first();
    return view('privacy', compact('sitePage'));
})->name('privacy');

// Direct media/storage serving fallback for shared hosting / cPanel environments
Route::get('/storage/{path}', function (string $path) {
    $cleanPath = str_replace(['..', "\0"], '', $path);
    $cleanPath = ltrim($cleanPath, '/');

    $candidates = [
        '/home/kenyanba/public_html/storage/' . $cleanPath,
        storage_path('app/public/' . $cleanPath),
        base_path('storage/app/public/' . $cleanPath),
        '/home/kenyanba/repositories/Baddies/storage/app/public/' . $cleanPath,
        storage_path('app/' . $cleanPath),
        public_path('storage/' . $cleanPath),
    ];

    $foundFile = null;
    foreach ($candidates as $c) {
        if (@is_file($c) || @file_exists($c)) {
            $foundFile = $c;
            break;
        }
    }

    if (!$foundFile) {
        abort(404);
    }

    $ext = strtolower(pathinfo($cleanPath, PATHINFO_EXTENSION));
    $mimes = [
        'jpg' => 'image/jpeg', 'jpeg' => 'image/jpeg', 'png' => 'image/png',
        'gif' => 'image/gif', 'webp' => 'image/webp', 'svg' => 'image/svg+xml',
        'mp4' => 'video/mp4', 'mov' => 'video/quicktime', 'webm' => 'video/webm',
        'pdf' => 'application/pdf',
    ];
    $mime = $mimes[$ext] ?? (@mime_content_type($foundFile) ?: 'application/octet-stream');

    return response()->file($foundFile, [
        'Content-Type' => $mime,
        'Cache-Control' => 'public, max-age=31536000',
    ]);
})->where('path', '.*')->name('storage.local.fallback');


require __DIR__.'/auth.php';

// =============================================================================
// ONE-TIME SERVER SETUP ROUTE  — /server-setup?token=kbc-setup-2026-secure
// exec() is disabled on this server — uses PHP native + Artisan::call() only
// Steps: 1) Full Setup  2) Rebuild Caches  3) Test login
// =============================================================================
Route::match(['GET', 'POST'], '/server-setup', function (\Illuminate\Http\Request $request) {

    if ($request->query('token') !== 'kbc-setup-2026-secure') { abort(404); }

    $appDir  = base_path();
    $artisan = $appDir . '/artisan';
    $envFile = $appDir . '/.env';
    $results = [];
    $action  = $request->query('action', 'status');

    // Run an Artisan command in-process — no exec() needed
    $artisanCall = function (string $command, array $args = []) use (&$results): bool {
        try {
            \Illuminate\Support\Facades\Artisan::call($command, $args);
            $out = trim(\Illuminate\Support\Facades\Artisan::output());
            $results[] = ['label' => $command, 'cmd' => "Artisan::call('$command')", 'out' => $out ?: '(done)', 'ok' => true];
            return true;
        } catch (\Throwable $e) {
            $results[] = ['label' => $command, 'cmd' => "Artisan::call('$command')", 'out' => '❌ ' . $e->getMessage(), 'ok' => false];
            return false;
        }
    };

    // Recursive directory remover (pure PHP, no exec)
    $rrmdir = function (string $dir) use (&$rrmdir): bool {
        if (is_link($dir)) return unlink($dir);
        if (!is_dir($dir)) return @unlink($dir);
        foreach (scandir($dir) as $item) {
            if ($item === '.' || $item === '..') continue;
            $rrmdir($dir . '/' . $item);
        }
        return rmdir($dir);
    };

    // ── FIX ENV ──────────────────────────────────────────────────────────────
    if (in_array($action, ['fix-env', 'full-setup'])) {
        try {
            $env = file_get_contents($envFile);
            if ($env === false) throw new \RuntimeException('.env not readable');
            $replacements = [
                '/^FILESYSTEM_DISK=.*/m'      => 'FILESYSTEM_DISK=public',
                '/^SESSION_DRIVER=.*/m'       => 'SESSION_DRIVER=database',
                '/^SESSION_DOMAIN=.*/m'       => 'SESSION_DOMAIN=.kenyanbaddies.com',
                '/^APP_DEBUG=.*/m'            => 'APP_DEBUG=false',
                '/^PAYHERO_CALLBACK_URL=.*/m' => 'PAYHERO_CALLBACK_URL=https://kenyanbaddies.com/webhook/payhero',
            ];
            foreach ($replacements as $p => $r) {
                if (preg_match($p, $env)) {
                    $env = preg_replace($p, $r, $env);
                } else {
                    $env .= "\n" . $r;
                }
            }
            $w = file_put_contents($envFile, $env);
            $results[] = ['label' => 'Patch .env', 'cmd' => 'file_put_contents(.env)', 'out' => $w !== false
                ? '✅ FILESYSTEM_DISK=public, SESSION_DRIVER=database, SESSION_DOMAIN=.kenyanbaddies.com, APP_DEBUG=false, PAYHERO_CALLBACK_URL=https://kenyanbaddies.com/webhook/payhero'
                : '❌ Cannot write .env', 'ok' => $w !== false];
        } catch (\Throwable $e) {
            $results[] = ['label' => 'Patch .env', 'cmd' => '', 'out' => '❌ ' . $e->getMessage(), 'ok' => false];
        }
    }

    // ── SEED MEMBERSHIP PLANS ───────────────────────────────────────────────
    if (in_array($action, ['seed-plans', 'full-setup'])) {
        try {
            $plansCount = \App\Models\MembershipPlan::count();
            if ($plansCount === 0 || $action === 'seed-plans') {
                $seeder = new \Database\Seeders\MembershipPlanSeeder();
                $seeder->run();
                $newCount = \App\Models\MembershipPlan::count();
                $results[] = [
                    'label' => 'Seed Membership Plans',
                    'cmd'   => 'MembershipPlanSeeder::run()',
                    'out'   => "✅ Membership plans seeded successfully ($newCount active plans in DB: chat, regular, prime, prime-vip, vip)",
                    'ok'    => true,
                ];
            } else {
                $results[] = [
                    'label' => 'Membership Plans Check',
                    'cmd'   => 'MembershipPlan::count()',
                    'out'   => "✅ $plansCount membership plans already present in database",
                    'ok'    => true,
                ];
            }
        } catch (\Throwable $e) {
            $results[] = ['label' => 'Seed Membership Plans', 'cmd' => '', 'out' => '❌ ' . $e->getMessage(), 'ok' => false];
        }
    }

    // ── SAVE PAYHERO SETTINGS ────────────────────────────────────────────────
    if ($action === 'save-payhero') {
        try {
            $newU = trim((string) $request->input('payhero_username', $request->query('payhero_username', '')));
            $newP = trim((string) $request->input('payhero_password', $request->query('payhero_password', '')));
            $newC = trim((string) $request->input('payhero_channel_id', $request->query('payhero_channel_id', '')));
            $newA = trim((string) $request->input('payhero_account_id', $request->query('payhero_account_id', '')));
            $newW = trim((string) $request->input('payhero_callback_url', $request->query('payhero_callback_url', '')));

            if ($newU !== '') { \App\Models\SiteSetting::set('payhero_username', $newU); }
            if ($newP !== '') { \App\Models\SiteSetting::set('payhero_password', $newP); }
            if ($newC !== '') { \App\Models\SiteSetting::set('payhero_channel_id', $newC); }
            if ($newA !== '') { \App\Models\SiteSetting::set('payhero_account_id', $newA); }
            if ($newW !== '') { \App\Models\SiteSetting::set('payhero_callback_url', $newW); }

            // Clear any stale auth_token so fresh username:password is used
            \App\Models\SiteSetting::set('payhero_auth_token', null);

            // Update .env file as well
            $env = file_get_contents($envFile);
            if ($env !== false) {
                $envUpdates = [];
                if ($newU !== '') $envUpdates['/^PAYHERO_USERNAME=.*/m'] = 'PAYHERO_USERNAME=' . $newU;
                if ($newP !== '') $envUpdates['/^PAYHERO_PASSWORD=.*/m'] = 'PAYHERO_PASSWORD=' . $newP;
                if ($newC !== '') $envUpdates['/^PAYHERO_CHANNEL_ID=.*/m'] = 'PAYHERO_CHANNEL_ID=' . $newC;
                if ($newA !== '') $envUpdates['/^PAYHERO_ACCOUNT_ID=.*/m'] = 'PAYHERO_ACCOUNT_ID=' . $newA;
                if ($newW !== '') $envUpdates['/^PAYHERO_CALLBACK_URL=.*/m'] = 'PAYHERO_CALLBACK_URL=' . $newW;

                foreach ($envUpdates as $pat => $rep) {
                    if (preg_match($pat, $env)) {
                        $env = preg_replace($pat, $rep, $env);
                    } else {
                        $env .= "\n" . $rep;
                    }
                }
                file_put_contents($envFile, $env);
            }

            // Flush config and route caches
            \Illuminate\Support\Facades\Artisan::call('config:clear');
            \Illuminate\Support\Facades\Artisan::call('cache:clear');

            $results[] = [
                'label' => 'Save PayHero Credentials',
                'cmd'   => 'Update SiteSettings, .env, and clear caches',
                'out'   => "✅ PayHero credentials successfully saved to Database & .env!\nUsername: " . ($newU ?: '(preserved)') . "\nChannel ID: " . ($newC ?: '(preserved)') . "\nCallback URL: " . ($newW ?: '(preserved)'),
                'ok'    => true,
            ];
            $action = 'test-payhero'; // Automatically run test with newly saved credentials
        } catch (\Throwable $e) {
            $results[] = ['label' => 'Save PayHero', 'cmd' => '', 'out' => '❌ ' . $e->getMessage(), 'ok' => false];
        }
    }

    // ── TEST PAYHERO ──────────────────────────────────────────────────────────
    if (in_array($action, ['test-payhero', 'save-payhero'])) {
        try {
            $phUser = \App\Models\SiteSetting::get('payhero_username', config('services.payhero.username'));
            $phPass = \App\Models\SiteSetting::get('payhero_password', config('services.payhero.password'));
            $phChan = \App\Models\SiteSetting::get('payhero_channel_id', config('services.payhero.channel_id'));
            $phAcc  = \App\Models\SiteSetting::get('payhero_account_id', config('services.payhero.account_id'));
            $phCb   = \App\Models\SiteSetting::get('payhero_callback_url', config('services.payhero.callback_url')) ?: url('/webhook/payhero');

            $results[] = [
                'label' => '1. PayHero Settings Diagnostic',
                'cmd'   => 'Verify PayHero credentials in DB & .env',
                'out'   => "Username: " . ($phUser ? substr($phUser, 0, 4) . '****' : '❌ NOT CONFIGURED') .
                           "\nPassword: " . ($phPass ? '**** (Configured)' : '❌ NOT CONFIGURED') .
                           "\nChannel ID: " . ($phChan ?: '❌ NOT CONFIGURED') .
                           "\nAccount ID: " . ($phAcc ?: 'None') .
                           "\nActive Callback URL: " . $phCb,
                'ok'    => !empty($phUser) && !empty($phPass) && !empty($phChan),
            ];

            // 1. Test local webhook endpoint with GET ping
            $webhookUrl = url('/webhook/payhero');
            $localPing = \Illuminate\Support\Facades\Http::timeout(5)->get($webhookUrl);
            $results[] = [
                'label' => '2. Local Webhook Health (GET /webhook/payhero)',
                'cmd'   => "Http::get('$webhookUrl')",
                'out'   => "HTTP Status: " . $localPing->status() . " — " . $localPing->body(),
                'ok'    => $localPing->status() === 200,
            ];

            // 2. Test local webhook endpoint with a dummy test POST payload
            $testPayload = ['event' => 'test', 'external_reference' => 'test_diagnose', 'status' => 'success'];
            $postPing = \Illuminate\Support\Facades\Http::timeout(5)->post($webhookUrl, $testPayload);
            $results[] = [
                'label' => '3. Local Webhook Callback Processing (POST /webhook/payhero)',
                'cmd'   => "Http::post('$webhookUrl', testPayload)",
                'out'   => "HTTP Status: " . $postPing->status() . " — " . $postPing->body(),
                'ok'    => $postPing->status() === 200,
            ];

            // 3. Test PayHero API Authentication (Payment Channels)
            $authHeader = 'Basic ' . base64_encode($phUser . ':' . $phPass);
            $chanResp = \Illuminate\Support\Facades\Http::timeout(8)
                ->withHeaders(['Authorization' => $authHeader])
                ->get('https://backend.payhero.co.ke/api/v2/payment_channels');

            $chanStatus = $chanResp->status();
            $chanRaw    = $chanResp->body();

            if ($chanResp->successful()) {
                $results[] = [
                    'label' => '4. PayHero API Authentication (GET /api/v2/payment_channels)',
                    'cmd'   => "Authorization: Basic <base64(username:password)>",
                    'out'   => "✅ HTTP Status: 200 OK — Credentials authenticated successfully!\nChannels: " . $chanRaw,
                    'ok'    => true,
                ];
            } else {
                $errExplanation = ($chanStatus === 401 && str_contains(strtolower((string) $chanRaw), 'unable to perform request'))
                    ? "\n\n⚠️ PayHero returned HTTP 401: 'Unable to perform request'." .
                      "\nPayHero returns this for 3 primary reasons:" .
                      "\n  1) 💰 SERVICE WALLET FLOAT IS 0.00 KES: PayHero requires float in your prepaid Service Wallet to process STK pushes. Top up KES 50-100 on https://app.payhero.co.ke under 'Wallets' -> 'Service Wallet'." .
                      "\n  2) 🔑 API KEYS CHANGED OR EXPIRED: Check https://app.payhero.co.ke/api_keys and update the Username & Password below." .
                      "\n  3) 📡 CHANNEL ID: Ensure Channel ID ($phChan) is active on app.payhero.co.ke."
                    : "\nRaw response: $chanRaw";

                $results[] = [
                    'label' => '4. PayHero API Authentication (GET /api/v2/payment_channels)',
                    'cmd'   => "Authorization: Basic <base64(username:password)>",
                    'out'   => "HTTP Status: $chanStatus$errExplanation",
                    'ok'    => false,
                ];
            }

            // 4. Test Service Wallet Balance
            $walletResp = \Illuminate\Support\Facades\Http::timeout(8)
                ->withHeaders(['Authorization' => $authHeader])
                ->get('https://backend.payhero.co.ke/api/v2/wallets?wallet_type=service_wallet');

            $results[] = [
                'label' => '5. PayHero Service Wallet Balance Check',
                'cmd'   => 'GET https://backend.payhero.co.ke/api/v2/wallets?wallet_type=service_wallet',
                'out'   => "HTTP Status: " . $walletResp->status() . " — " . ($walletResp->successful() ? $walletResp->body() : $walletResp->body()),
                'ok'    => $walletResp->successful(),
            ];

            // 5. Test Live STK Push Simulation Probe
            $probePayload = [
                'amount'             => 10,
                'phone_number'       => '254712345678',
                'provider'           => 'm-pesa',
                'network_code'       => '63902',
                'channel_id'         => (int) $phChan,
                'external_reference' => 'test_probe_' . time(),
                'callback_url'       => $phCb,
            ];
            if (!empty($phAcc)) { $probePayload['account_id'] = (int) $phAcc; }

            $probeResp = \Illuminate\Support\Facades\Http::timeout(8)
                ->withHeaders([
                    'Content-Type'  => 'application/json',
                    'Authorization' => $authHeader,
                ])->post('https://backend.payhero.co.ke/api/v2/payments', $probePayload);

            $results[] = [
                'label' => '6. PayHero Payment Initiation Probe (POST /api/v2/payments)',
                'cmd'   => "POST https://backend.payhero.co.ke/api/v2/payments",
                'out'   => "HTTP Status: " . $probeResp->status() . "\nBody: " . $probeResp->body(),
                'ok'    => $probeResp->successful(),
            ];
        } catch (\Throwable $e) {
            $results[] = ['label' => 'Test PayHero', 'cmd' => '', 'out' => '❌ ' . $e->getMessage(), 'ok' => false];
        }
    }

    // ── FIX STORAGE SYMLINK (pure PHP — no exec) ─────────────────────────────
    if (in_array($action, ['fix-storage', 'full-setup'])) {
        $target = '/home/kenyanba/repositories/Baddies/storage/app/public';
        $link   = '/home/kenyanba/public_html/storage';
        try {
            // Remove whatever is there
            if (is_link($link)) {
                $removed = unlink($link);
                $results[] = ['label' => 'Remove old symlink', 'cmd' => "unlink('$link')", 'out' => $removed ? '✅ Removed' : '❌ Could not remove', 'ok' => $removed];
            } elseif (is_dir($link)) {
                $removed = $rrmdir($link);
                $results[] = ['label' => 'Remove old storage dir', 'cmd' => "rrmdir('$link')", 'out' => $removed ? '✅ Removed' : '❌ Could not remove (may have files)', 'ok' => $removed];
            } else {
                $results[] = ['label' => 'Check existing link', 'cmd' => "is_link/is_dir '$link'", 'out' => 'Clean — nothing to remove', 'ok' => true];
            }

            // Create symlink if function is available
            $ok = false;
            if (function_exists('symlink')) {
                $ok = @symlink($target, $link);
            }

            if ($ok && is_link($link) && is_dir($link)) {
                $results[] = ['label' => 'Create symlink', 'cmd' => "symlink('$target', '$link')", 'out' => '✅ Native symlink created and verified working', 'ok' => true];
            } else {
                // Shared hosting: symlink() disabled. Recursively mirror storage/app/public into public_html/storage
                $copyDir = function ($src, $dst) use (&$copyDir): int {
                    $c = 0;
                    if (!is_dir($dst)) @mkdir($dst, 0775, true);
                    foreach (scandir($src) ?: [] as $f) {
                        if ($f === '.' || $f === '..') continue;
                        $sf = $src . '/' . $f;
                        $df = $dst . '/' . $f;
                        if (is_dir($sf)) {
                            $c += $copyDir($sf, $df);
                        } else {
                            if (@copy($sf, $df)) {
                                @chmod($df, 0664);
                                $c++;
                            }
                        }
                    }
                    return $c;
                };

                $copied = $copyDir($target, $link);
                $results[] = [
                    'label' => 'Public Storage Mirror',
                    'cmd'   => "copyDir('$target', '$link')",
                    'out'   => "✅ Mirrored $copied media files directly into public_html/storage! LiteSpeed web server now serves all images natively 🚀",
                    'ok'    => $copied > 0
                ];
            }

            // Set recursive permissions using PHP chmod
            $chmodR = function ($dir, $mode) use (&$chmodR): void {
                if (!file_exists($dir)) return;
                @chmod($dir, $mode);
                if (is_dir($dir)) {
                    foreach (scandir($dir) ?: [] as $item) {
                        if ($item === '.' || $item === '..') continue;
                        $chmodR($dir . '/' . $item, $mode);
                    }
                }
            };
            $chmodR($appDir . '/storage', 0775);
            $chmodR($appDir . '/bootstrap/cache', 0775);
            if (is_dir($link)) {
                $chmodR($link, 0775);
            }
            $results[] = ['label' => "chmod recursive", 'cmd' => "chmodR(storage, 0775)", 'out' => '✅ Storage & public_html/storage permissions set to 0775', 'ok' => true];

            // Verify
            $symOk = is_link($link) && is_dir($link);
            $dirOk = is_dir($link) && count(glob($link . '/*') ?: []) > 0;
            $results[] = ['label' => 'Media delivery status', 'cmd' => 'Verification', 'out' => $symOk
                ? '✅ Native symlink is working'
                : ($dirOk ? '✅ Direct public_html/storage delivery is ACTIVE (LiteSpeed native serving)' : '⚠️ Storage path still empty'), 'ok' => ($symOk || $dirOk)];
        } catch (\Throwable $e) {
            $results[] = ['label' => 'Fix Storage Symlink', 'cmd' => '', 'out' => '❌ ' . $e->getMessage(), 'ok' => false];
        }
    }

    // ── CLEAR CACHES (file deletion — safe in any context) ───────────────────
    if (in_array($action, ['clear-cache', 'full-setup'])) {
        try {
            $deleted = 0;
            foreach ([
                $appDir . '/bootstrap/cache',
                $appDir . '/storage/framework/cache/data',
                $appDir . '/storage/framework/views',
            ] as $dir) {
                if (!is_dir($dir)) continue;
                foreach (glob($dir . '/*') ?: [] as $f) {
                    if (is_file($f) && basename($f) !== '.gitignore') { @unlink($f); $deleted++; }
                }
            }
            $results[] = ['label' => 'Clear caches', 'cmd' => 'unlink cached files', 'out' => "✅ Deleted $deleted cached files", 'ok' => true];
        } catch (\Throwable $e) {
            $results[] = ['label' => 'Clear caches', 'cmd' => '', 'out' => '❌ ' . $e->getMessage(), 'ok' => false];
        }
    }

    // ── MIGRATIONS (Artisan::call — no exec needed) ──────────────────────────
    if (in_array($action, ['migrate', 'full-setup'])) {
        $artisanCall('migrate', ['--force' => true]);
    }

    // ── REBUILD CACHES (Artisan::call — separate step, safe after full-setup) ─
    if ($action === 'rebuild-cache') {
        $artisanCall('config:clear');
        $artisanCall('config:cache');
        $artisanCall('route:clear');
        $artisanCall('route:cache');
        $artisanCall('view:clear');
        $artisanCall('view:cache');
    }

    // ── STATUS ───────────────────────────────────────────────────────────────
    $envRaw = @file_get_contents($envFile) ?: '';
    $val    = fn($k) => preg_match("/^{$k}=(.*)$/m", $envRaw, $m) ? trim($m[1]) : '(not set)';
    $sym    = '/home/kenyanba/public_html/storage';
    $symOk  = is_link($sym) && is_dir($sym);
    $dirOk  = is_dir($sym) && count(glob($sym . '/*') ?: []) > 0;

    $hasSessions = false;
    $userCount = null;
    try {
        $hasSessions = \Illuminate\Support\Facades\Schema::hasTable('sessions');
        $userCount = \Illuminate\Support\Facades\Schema::hasTable('users') ? \App\Models\User::count() : null;
    } catch (\Throwable $e) {}

    $phUserConfigured = !empty(\App\Models\SiteSetting::get('payhero_username', config('services.payhero.username')));
    $phChannelId = \App\Models\SiteSetting::get('payhero_channel_id', config('services.payhero.channel_id'));
    $phCallbackUrl = \App\Models\SiteSetting::get('payhero_callback_url', config('services.payhero.callback_url')) ?: url('/webhook/payhero');

    $status = [
        'APP_URL'          => $val('APP_URL'),
        'APP_ENV'          => $val('APP_ENV'),
        'APP_DEBUG'        => $val('APP_DEBUG'),
        'SESSION_DRIVER'   => $val('SESSION_DRIVER'),
        'SESSION_DOMAIN'   => $val('SESSION_DOMAIN'),
        'Sessions Table'   => $hasSessions ? '✅ Present in DB' : '❌ Missing (Click Migrate)',
        'Users in DB'      => $userCount !== null ? "✅ $userCount users found" : '❌ Table missing or DB error',
        'FILESYSTEM_DISK'  => $val('FILESYSTEM_DISK'),
        'Storage Mode'     => $symOk ? '✅ Symlink Active' : ($dirOk ? '✅ Direct Web Root Active (public_html/storage)' : '⚠️ Not mirrored (Click Fix Storage)'),
        'PayHero Status'   => $phUserConfigured ? '✅ Credentials Configured' : '⚠️ Missing Credentials',
        'PayHero Channel'  => $phChannelId ? '✅ Channel ' . $phChannelId : '⚠️ Missing Channel ID',
        'PayHero Callback' => $phCallbackUrl,
        'DB_DATABASE'      => $val('DB_DATABASE'),
        'PHP_VERSION'      => PHP_VERSION,
        '.env writable'    => is_writable($envFile) ? '✅ Yes' : '❌ No',
        'exec() status'    => function_exists('exec') ? '✅ Enabled' : 'ℹ️ Disabled (Artisan::call active)',
    ];

    // Scan storage directories for media files
    $scanDirs = [
        'repositories/Baddies/storage/app/public' => $appDir . '/storage/app/public',
        'public_html/storage' => '/home/kenyanba/public_html/storage',
        'repositories/Baddies/storage/app' => $appDir . '/storage/app',
    ];
    $mediaScans = [];
    foreach ($scanDirs as $name => $path) {
        if (!is_dir($path)) {
            $mediaScans[] = ['name' => $name, 'status' => 'Directory does not exist', 'count' => 0, 'files' => []];
            continue;
        }
        $count = 0;
        $files = [];
        try {
            $it = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($path, \FilesystemIterator::SKIP_DOTS));
            foreach ($it as $f) {
                if ($f->isFile()) {
                    $count++;
                    if (count($files) < 6) {
                        $files[] = str_replace($path . DIRECTORY_SEPARATOR, '', $f->getPathname());
                    }
                }
            }
            $mediaScans[] = ['name' => $name, 'status' => "$count files found", 'count' => $count, 'files' => $files];
        } catch (\Throwable $e) {
            $mediaScans[] = ['name' => $name, 'status' => 'Error: ' . $e->getMessage(), 'count' => 0, 'files' => []];
        }
    }

    $siteImagesCheck = [];
    try {
        if (\Illuminate\Support\Facades\Schema::hasTable('site_settings')) {
            $rows = \Illuminate\Support\Facades\DB::table('site_settings')
                ->whereIn('key', ['logo', 'preloader', 'favicon', 'hero_background', 'escort_girls_header_background'])
                ->get();
            foreach ($rows as $r) {
                if ($r->value) {
                    $clean = ltrim($r->value, '/');
                    $existsInPublic = file_exists($appDir . '/storage/app/public/' . $clean);
                    $existsInHtml = file_exists('/home/kenyanba/public_html/storage/' . $clean);
                    $siteImagesCheck[] = [
                        'key' => $r->key,
                        'file' => $r->value,
                        'exists' => ($existsInPublic || $existsInHtml),
                        'loc' => $existsInPublic ? 'storage/app/public' : ($existsInHtml ? 'public_html/storage' : '❌ MISSING FROM DISK'),
                    ];
                }
            }
        }
    } catch (\Throwable $e) {}

    $token = 'kbc-setup-2026-secure';
    $base  = '/server-setup?token=' . $token;

    ob_start(); ?>
<!DOCTYPE html><html lang="en"><head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>KBC Server Setup</title>
<style>
*{box-sizing:border-box;margin:0;padding:0}
body{font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",sans-serif;background:#0d0d0d;color:#eee;padding:1.5rem}
h1{color:#ff8c00;font-size:1.6rem;margin-bottom:.2rem}
.sub{color:#777;font-size:.85rem;margin-bottom:1.5rem}
.grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(240px,1fr));gap:.75rem;margin-bottom:1.5rem}
.card{background:#161616;border:1px solid #2a2a2a;border-radius:8px;padding:1rem}
.card h3{font-size:.7rem;text-transform:uppercase;letter-spacing:.06em;color:#666;margin-bottom:.35rem}
.val{font-size:.9rem;word-break:break-all}
.ok{color:#4ade80}.bad{color:#f87171}
.btns{display:flex;flex-wrap:wrap;gap:.6rem;margin-bottom:1.5rem}
.btn{padding:.55rem 1.1rem;border-radius:7px;font-weight:600;font-size:.85rem;text-decoration:none;display:inline-block}
.p{background:#ff8c00;color:#000}.s{background:#222;color:#ddd;border:1px solid #333}.g{background:#15803d;color:#fff}
h2{color:#ff8c00;font-size:1.1rem;margin:.75rem 0}
.res{margin-bottom:.5rem;background:#111;border:1px solid #222;border-radius:7px;padding:.8rem}
.ok2{border-left:3px solid #4ade80}.fail{border-left:3px solid #f87171}
.lbl{font-weight:700;font-size:.85rem;margin-bottom:.2rem}
.cmd{font-size:.72rem;color:#555;font-family:monospace;margin-bottom:.3rem}
.out{font-family:monospace;font-size:.82rem;white-space:pre-wrap;word-break:break-word}
.note{background:#1a1400;border:1px solid #665500;border-radius:8px;padding:.9rem;margin-bottom:1.5rem;font-size:.85rem;color:#fbbf24}
</style></head><body>
<h1>🔧 KBC Server Setup</h1>
<p class="sub">kenyanbaddies.com — exec() disabled; using PHP native + Artisan::call()</p>
<div class="note">⚠️ <strong>Two steps:</strong> <strong>Full Setup</strong> first → then <strong>Rebuild Caches</strong> separately.</div>
<div class="grid">
<?php foreach ($status as $k => $v):
    $good = match($k) {
        'APP_URL'=>str_contains($v,'kenyanbaddies'),'APP_ENV'=>$v==='production',
        'APP_DEBUG'=>$v==='false','SESSION_DRIVER'=>$v==='database',
        'FILESYSTEM_DISK'=>$v==='public',
        'SESSION_DOMAIN'=>in_array($v,['.kenyanbaddies.com','null','']),
        'Sessions Table'=>str_starts_with($v,'✅'),
        'Users in DB'=>str_starts_with($v,'✅'),
        'Storage Mode'=>str_starts_with($v,'✅'),
        'PayHero Status'=>str_starts_with($v,'✅'),
        'PayHero Channel'=>str_starts_with($v,'✅'),
        'PayHero Callback'=>!str_contains($v,'trycloudflare') && !str_contains($v,'localhost'),
        '.env writable'=>str_starts_with($v,'✅'),
        'exec() status'=>true,
        default=>true
    };
    $cls = $good ? 'ok' : 'bad'; ?>
<div class="card"><h3><?=htmlspecialchars($k)?></h3><div class="val <?=$cls?>"><?=htmlspecialchars($v)?></div></div>
<?php endforeach; ?>
</div>
<h2>Actions</h2>
<div class="btns">
  <a class="btn p" href="<?=$base?>&action=full-setup">🚀 1. Full Setup</a>
  <a class="btn g" href="<?=$base?>&action=rebuild-cache">⚡ 2. Rebuild Caches</a>
  <a class="btn p" href="<?=$base?>&action=test-payhero">💳 Test PayHero</a>
  <a class="btn s" href="<?=$base?>&action=seed-plans">🌱 Seed Plans</a>
  <a class="btn s" href="<?=$base?>&action=fix-storage">🔗 Fix Symlink</a>
  <a class="btn s" href="<?=$base?>&action=fix-env">📝 Fix .env</a>
  <a class="btn s" href="<?=$base?>&action=clear-cache">🗑️ Clear Caches</a>
  <a class="btn s" href="<?=$base?>&action=migrate">🗄️ Migrate</a>
  <a class="btn s" href="<?=$base?>&action=status">🔄 Refresh</a>
</div>
<h2>💳 PayHero M-Pesa Live Credentials & Instant Test</h2>
<div class="card" style="background:#161616;border:1px solid #ff8c00;border-radius:8px;padding:1.25rem;margin-bottom:1.5rem;">
  <p style="color:#aaa;font-size:0.85rem;margin-bottom:1rem;">
    Update your PayHero API keys below and click <strong>Save &amp; Test Live</strong>. The keys are automatically saved to the database and <code>.env</code> file, caches cleared, and a live verification probe is run.
  </p>
  <form method="POST" action="<?=$base?>&action=save-payhero" style="display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:0.9rem;align-items:end;">
    <div>
      <label style="display:block;font-size:0.75rem;color:#888;margin-bottom:0.25rem;text-transform:uppercase;">API Username</label>
      <input type="text" name="payhero_username" value="<?=htmlspecialchars(\App\Models\SiteSetting::get('payhero_username', config('services.payhero.username')) ?? '')?>" placeholder="e.g. IlvxJNuM91zkYWIdu8jN" style="width:100%;padding:0.5rem 0.75rem;background:#0d0d0d;border:1px solid #333;border-radius:6px;color:#fff;font-size:0.85rem;">
    </div>
    <div>
      <label style="display:block;font-size:0.75rem;color:#888;margin-bottom:0.25rem;text-transform:uppercase;">API Password</label>
      <input type="password" name="payhero_password" value="<?=htmlspecialchars(\App\Models\SiteSetting::get('payhero_password', config('services.payhero.password')) ?? '')?>" placeholder="Enter new or existing password" style="width:100%;padding:0.5rem 0.75rem;background:#0d0d0d;border:1px solid #333;border-radius:6px;color:#fff;font-size:0.85rem;">
    </div>
    <div>
      <label style="display:block;font-size:0.75rem;color:#888;margin-bottom:0.25rem;text-transform:uppercase;">Channel ID</label>
      <input type="text" name="payhero_channel_id" value="<?=htmlspecialchars(\App\Models\SiteSetting::get('payhero_channel_id', config('services.payhero.channel_id')) ?? '')?>" placeholder="e.g. 11727" style="width:100%;padding:0.5rem 0.75rem;background:#0d0d0d;border:1px solid #333;border-radius:6px;color:#fff;font-size:0.85rem;">
    </div>
    <div>
      <label style="display:block;font-size:0.75rem;color:#888;margin-bottom:0.25rem;text-transform:uppercase;">Account ID (Optional)</label>
      <input type="text" name="payhero_account_id" value="<?=htmlspecialchars(\App\Models\SiteSetting::get('payhero_account_id', config('services.payhero.account_id')) ?? '')?>" placeholder="e.g. 7806" style="width:100%;padding:0.5rem 0.75rem;background:#0d0d0d;border:1px solid #333;border-radius:6px;color:#fff;font-size:0.85rem;">
    </div>
    <div style="grid-column:1/-1;">
      <label style="display:block;font-size:0.75rem;color:#888;margin-bottom:0.25rem;text-transform:uppercase;">Callback / Webhook URL</label>
      <input type="text" name="payhero_callback_url" value="<?=htmlspecialchars(\App\Models\SiteSetting::get('payhero_callback_url', config('services.payhero.callback_url')) ?: url('/webhook/payhero'))?>" style="width:100%;padding:0.5rem 0.75rem;background:#0d0d0d;border:1px solid #333;border-radius:6px;color:#fff;font-size:0.85rem;">
    </div>
    <div style="grid-column:1/-1;display:flex;gap:0.75rem;margin-top:0.5rem;">
      <button type="submit" class="btn p" style="border:none;cursor:pointer;">💾 Save &amp; Test Live</button>
      <a class="btn s" href="<?=$base?>&action=test-payhero">🔄 Run Diagnostic Test Only</a>
    </div>
  </form>
</div>
<h2>📁 Storage Media Diagnostics</h2>
<div class="res ok2">
  <div class="lbl">Storage Directories File Counts</div>
  <div class="out"><?php foreach ($mediaScans as $ms): ?>
• <?=htmlspecialchars($ms['name'])?>: <?=htmlspecialchars($ms['status'])?>
<?php if (!empty($ms['files'])): ?>   Samples: <?=htmlspecialchars(implode(', ', $ms['files']))?>
<?php endif; ?>
<?php endforeach; ?></div>
</div>
<?php if (!empty($siteImagesCheck)): ?>
<div class="res ok2">
  <div class="lbl">Database Site Settings Image Files Check</div>
  <div class="out"><?php foreach ($siteImagesCheck as $sic): ?>
• <?=htmlspecialchars($sic['key'])?> (<?=htmlspecialchars($sic['file'])?>): <?=htmlspecialchars($sic['loc'])?>
<?php endforeach; ?></div>
</div>
<?php endif; ?>
<?php if (!empty($results)): ?>
<h2>Results — <?=htmlspecialchars($action)?></h2>
<?php foreach ($results as $r): $cls = $r['ok'] ? 'ok2' : 'fail'; ?>
<div class="res <?=$cls?>">
  <div class="lbl"><?=htmlspecialchars($r['label'])?></div>
  <div class="cmd">$ <?=htmlspecialchars($r['cmd'])?></div>
  <div class="out"><?=htmlspecialchars($r['out'] ?: '(no output)')?></div>
</div>
<?php endforeach; ?>
<?php endif; ?>
</body></html>
<?php
    return response(ob_get_clean(), 200)->header('Content-Type', 'text/html');

})->name('server.setup');

Route::post('/visitor/heartbeat', [\App\Http\Controllers\VisitorTrackerController::class, 'heartbeat'])->name('visitor.heartbeat');
