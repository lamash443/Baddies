<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserPhotoController;
use App\Http\Controllers\UserVideoController;
use App\Http\Controllers\VerificationSubmissionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // Only verified female (call girl) users
    $users = \App\Models\User::where('is_verified', true)
        ->where(function($q) {
            $q->where('gender', 'female')
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
        ->where(function($q) {
            $q->where('gender', 'female')
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
    $videos = \App\Models\UserVideo::with('user')->latest()->get();
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
    $users = \App\Models\User::where('gender', 'male')
        ->where('is_verified', true)
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
    
    $users = \App\Models\User::where('is_verified', true)
        ->where(function ($query) use ($searchLocation) {
            $query->where('county', 'LIKE', '%' . $searchLocation . '%')
                  ->orWhere('city_town', 'LIKE', '%' . $searchLocation . '%')
                  ->orWhere('location', 'LIKE', '%' . $searchLocation . '%')
                  ->orWhere('area', 'LIKE', '%' . $searchLocation . '%');
        })
        ->with('photos')
        ->get();
        
    $vipUsers = $users->filter(function($u) {
        return in_array($u->subscription_plan, ['vip', 'prime_vip', 'prime-vip']) && $u->hasActiveSubscription();
    });
    
    $regularUsers = $users->filter(function($u) {
        return !in_array($u->subscription_plan, ['vip', 'prime_vip', 'prime-vip']) || !$u->hasActiveSubscription();
    });

    return view('location', compact('vipUsers', 'regularUsers', 'searchLocation'));
})->name('location.show');

// Public profile view
Route::get('/profile/{id}', function ($id) {
    $user = \App\Models\User::with(['photos', 'videos'])
        ->where('is_verified', true)
        ->findOrFail($id);

    // Increment profile views (not tracking unique per IP for simplicity yet)
    $user->increment('profile_views');
    \Illuminate\Support\Facades\DB::table('profile_statistics')->updateOrInsert(
        ['user_id' => $user->id, 'date' => now()->toDateString()],
        ['views' => \Illuminate\Support\Facades\DB::raw('views + 1'), 'updated_at' => now()]
    );

    // Similar profiles: same gender, verified, exclude current
    $similarProfiles = \App\Models\User::with('photos')
        ->where('is_verified', true)
        ->where('id', '!=', $user->id)
        ->when($user->gender, fn($q) => $q->where('gender', $user->gender))
        ->inRandomOrder()
        ->limit(6)
        ->get();

    return view('profile-view', compact('user', 'similarProfiles'));
})->where('id', '[0-9]+')->name('profile.view');

// Track phone clicks
Route::post('/profile/{id}/track-call', function ($id) {
    $user = \App\Models\User::where('is_verified', true)->findOrFail($id);
    $user->increment('phone_calls');
    \Illuminate\Support\Facades\DB::table('profile_statistics')->updateOrInsert(
        ['user_id' => $user->id, 'date' => now()->toDateString()],
        ['phone_calls' => \Illuminate\Support\Facades\DB::raw('phone_calls + 1'), 'updated_at' => now()]
    );
    return response()->json(['success' => true]);
})->where('id', '[0-9]+')->name('profile.track-call');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

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
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // User Photos
    Route::post('/profile/photos', [UserPhotoController::class, 'store'])->name('user.photos.store');
    Route::delete('/profile/photos/{photo}', [UserPhotoController::class, 'destroy'])->name('user.photos.destroy');
    // User Videos
    Route::post('/profile/videos', [UserVideoController::class, 'store'])->name('user.videos.store');
    Route::delete('/profile/videos/{video}', [UserVideoController::class, 'destroy'])->name('user.videos.destroy');
    // Verification
    Route::post('/profile/verification', [VerificationSubmissionController::class, 'store'])->name('verification.submit');
    Route::get('/verify-account', function () {
        return view('verify-account');
    })->name('account.verify');
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
                    return back()->withErrors(['wallet' => 'Insufficient wallet balance. Please add funds.']);
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
                return redirect()->route('profile.edit', ['#tab-classifieds'])
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
                return back()->withErrors(['wallet' => 'Insufficient wallet balance. Please add funds.']);
            }

            // Deduct cost from wallet
            $user->decrement('wallet_balance', $cost);

            if ($planType === 'chat') {
                $user->update([
                    'chat_plan'        => 'active',
                    'chat_expires_at'  => now()->addDays($planDays),
                ]);
            } else {
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
            // Redirect back to same checkout page with success toast
            return back()->with('success', "You're now subscribed to the {$planLabel} plan!");
        }
        
        // Save to session or database to process later for MPESA
        session(['checkout_plan_type' => $planType, 'checkout_plan' => $planDays]);
        
        // If phone is provided directly in the form, simulate STK push and return to same page
        if ($request->has('mpesaPhone')) {
             return back()->with('success', 'Payment request sent to ' . $request->mpesaPhone . '. Please check your phone.');
        }

        // Fallback for older forms that don't have inline MPESA
        return redirect()->route('checkout.mpesa');
    })->name('membership.process');

    Route::get('/checkout-mpesa', function () {
        return view('mpesa-checkout');
    })->name('checkout.mpesa');

    Route::post('/checkout-mpesa', function (\Illuminate\Http\Request $request) {
        $request->validate([
            'phone' => 'required|string',
        ]);
        
        // TODO: Implement actual MPESA STK Push logic here
        
        $type = session('checkout_plan_type');
        if ($type === 'classified') {
            $classifiedId = session('classified_id');
            if ($classifiedId) {
                \App\Models\Classified::where('id', $classifiedId)->update(['payment_status' => 'paid']);
            }
        }
        
        return back()->with('success', 'Payment request sent to ' . $request->phone . '. Please check your phone.');
    });

    Route::get('/wallet/add-funds', function () {
        $deposits = auth()->user()->deposits()->latest()->get();
        return view('wallet-add-funds', compact('deposits'));
    })->name('wallet.add');
    
    Route::post('/wallet/add-funds', function (\Illuminate\Http\Request $request) {
        $request->validate([
            'amount' => 'required|numeric|min:50',
            'payment_method' => 'required|string',
        ]);
        
        session(['checkout_plan_type' => 'wallet', 'checkout_amount' => $request->amount]);
        
        return redirect()->route('checkout.mpesa');
    });
});

Route::get('/contact', function () {
    $sitePage = \App\Models\Page::where('slug', 'contact')->first();
    return view('contact', compact('sitePage'));
})->name('contact');

Route::post('/contact', function (\Illuminate\Http\Request $request) {
    $rules = [
        'subject' => 'required|string|max:255',
        'message' => 'required|string|min:5',
    ];

    if (!auth()->check()) {
        $rules['name'] = 'required|string|max:255';
        $rules['email'] = 'required|email|max:255';
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

require __DIR__.'/auth.php';
