<!DOCTYPE html>
<html lang="en" class="h-full bg-slate-950 text-slate-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Access Restricted • Kenyan Baddies Club</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;600&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Outfit', sans-serif;
        }
        .font-mono {
            font-family: 'JetBrains Mono', monospace;
        }
        .glow-red {
            box-shadow: 0 0 50px -10px rgba(239, 68, 68, 0.35);
        }
    </style>
</head>
<body class="h-full flex items-center justify-center p-4 bg-gradient-to-b from-slate-950 via-slate-900 to-black select-none">
    <div class="max-w-md w-full text-center">
        <!-- Shield Warning Card -->
        <div class="relative bg-slate-900/80 backdrop-blur-xl border border-red-500/20 rounded-2xl p-8 glow-red">
            <!-- Icon -->
            <div class="mx-auto w-16 h-16 rounded-2xl bg-red-500/10 border border-red-500/20 flex items-center justify-center text-red-500 mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>

            <!-- Title -->
            <h1 class="text-2xl font-bold tracking-tight text-white mb-2">
                Access Restricted
            </h1>
            <p class="text-sm text-slate-400 mb-6 leading-relaxed">
                Your IP address has been restricted from browsing Kenyan Baddies Club due to a security flag or policy violation.
            </p>

            <!-- IP Box -->
            <div class="bg-black/40 border border-white/5 rounded-xl p-3.5 mb-6">
                <div class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider mb-1">
                    Your IP Address
                </div>
                <div class="font-mono text-base font-bold text-red-400 tracking-wide">
                    {{ $ip ?? request()->ip() ?? 'Unknown' }}
                </div>
                <div class="text-[11px] text-slate-500 mt-1">
                    HTTP 403 • Forbidden
                </div>
            </div>

            <!-- Support note -->
            <p class="text-xs text-slate-500 leading-relaxed">
                If you believe this restriction was made in error or wish to appeal, please contact the site administrator.
            </p>
        </div>

        <!-- Brand Footer -->
        <div class="mt-6 text-xs text-slate-600">
            &copy; {{ date('Y') }} Kenyan Baddies Club. All rights reserved.
        </div>
    </div>
</body>
</html>
