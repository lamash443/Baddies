@php
    $logo = \App\Models\SiteSetting::get('logo');
@endphp

@if($logo && \Illuminate\Support\Facades\Storage::disk('public')->exists($logo))
    <img src="{{ asset('storage/' . $logo) }}" {{ $attributes->merge(['style' => 'object-fit: contain;']) }} alt="{{ config('app.name') }} Logo">
@else
    <span {{ $attributes->merge(['class' => 'font-bold tracking-widest uppercase text-xl']) }} style="letter-spacing: 1px;">
        <span style="color: orange;">Baddies</span><span style="color: white;">Club</span>
    </span>
@endif
