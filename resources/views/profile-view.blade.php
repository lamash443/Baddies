<!DOCTYPE html>
<html lang="en" style="overflow-y:auto!important;height:auto!important;">
<head>
  <meta charset="utf-8">
  <x-site-favicon />
  <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
  <title>{{ $user->name ?? 'Profile' }} – Kenyan Baddies Club</title>
  <meta name="description" content="View the full profile of {{ $user->name }} on Kenyan Baddies Club. {{ $user->age ? $user->age.' years old. ' : '' }}{{ $user->city_town ? 'Based in '.$user->city_town.'. ' : '' }}{{ $user->services ? 'Services: '.implode(', ', array_slice(is_array($user->services) ? $user->services : json_decode($user->services, true) ?? [], 0, 3)).'.' : '' }}">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  <style>
    *, *::before, *::after { box-sizing: border-box; }
    html, body { margin: 0; padding: 0; font-family: "Outfit", sans-serif; background: #0d0d0d; color: #fff; min-height: 100vh; }

    /* ── HERO ── */
    .pv-hero {
      position: relative;
      height: min(75vh, 640px);
      overflow: hidden;
      background: linear-gradient(135deg, #1a0f00, #0d0d0d);
    }
    .pv-hero__bg {
      position: absolute; inset: 0;
      width: 100%; height: 100%;
      object-fit: cover; object-position: top center;
      filter: brightness(0.42) saturate(1.1);
      transition: transform 8s ease;
    }
    .pv-hero:hover .pv-hero__bg { transform: scale(1.04); }
    .pv-hero__overlay {
      position: absolute; inset: 0;
      background: linear-gradient(180deg,
        rgba(13,13,13,0.15) 0%,
        rgba(13,13,13,0.45) 40%,
        rgba(13,13,13,0.97) 100%
      );
    }
    .pv-hero__content {
      position: absolute; bottom: 0; left: 0; right: 0;
      padding: 2.5rem 1.5rem 2rem;
    }
    .pv-hero__badge {
      display: inline-flex; align-items: center; gap: .5rem;
      font-size: .68rem; font-weight: 700; letter-spacing: .08em;
      text-transform: uppercase; color: rgba(255,140,0,0.95);
      margin-bottom: .85rem;
    }
    @keyframes pulseGreen { 0%,100%{opacity:1;transform:scale(1);} 50%{opacity:.4;transform:scale(1.6);} }
    .pv-hero__name {
      font-size: clamp(2.2rem, 5vw, 3.6rem);
      font-weight: 900; line-height: 1.08;
      letter-spacing: -.03em; margin: 0 0 .5rem;
    }
    .pv-hero__name span {
      background: linear-gradient(135deg, #ff8c00, #ffb347);
      -webkit-background-clip: text; -webkit-text-fill-color: transparent;
      background-clip: text;
    }
    .pv-hero__meta {
      display: flex; flex-wrap: wrap; gap: .6rem 1.2rem;
      font-size: .88rem; color: rgba(255,255,255,.65); margin-bottom: 1rem;
    }
    .pv-hero__meta-item { display: flex; align-items: center; gap: .35rem; }
    .pv-hero__meta-item svg { color: rgba(255,140,0,.8); flex-shrink: 0; }
    .pv-hero__vip {
      display: inline-flex; align-items: center; gap: .35rem;
      background: #ff8c00; color: #000;
      border-radius: 4px; padding: .22rem .75rem;
      font-size: .68rem; font-weight: 900; letter-spacing: .08em;
      text-transform: uppercase;
    }
    .pv-back-btn {
      position: absolute; top: 1.25rem; left: 1.25rem; z-index: 10;
      width: 40px; height: 40px;
      background: rgba(0,0,0,.65); backdrop-filter: blur(8px);
      border: 1px solid rgba(255,255,255,.18); border-radius: 50%;
      display: flex; align-items: center; justify-content: center;
      color: #fff; text-decoration: none; transition: all .2s;
    }
    .pv-back-btn:hover { background: rgba(255,140,0,.2); border-color: rgba(255,140,0,.5); color: #ff8c00; }

    /* ── LAYOUT ── */
    .pv-body { padding: 2.5rem 0 5rem; }
    .pv-section-title {
      font-size: .68rem; font-weight: 700; letter-spacing: .12em;
      text-transform: uppercase; color: rgba(255,140,0,.8);
      margin-bottom: 1.1rem; display: flex; align-items: center; gap: .6rem;
    }
    .pv-section-title::before {
      content: ''; display: block; width: 24px; height: 2px;
      background: rgba(255,140,0,.5); border-radius: 2px; flex-shrink: 0;
    }

    /* ── ABOUT CARD ── */
    .pv-card {
      background: linear-gradient(135deg, #1a0f00 0%, #111 100%);
      border: 1px solid rgba(255,140,0,.18); border-radius: 16px;
      padding: 1.5rem; margin-bottom: 1.4rem;
    }
    .pv-about-text {
      font-size: .93rem; line-height: 1.9;
      color: rgba(255,255,255,.65);
    }

    /* ── DETAILS GRID ── */
    .pv-details-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
      gap: .9rem;
    }
    .pv-detail-chip {
      background: rgba(255,140,0,.06); border: 1px solid rgba(255,140,0,.14);
      border-radius: 12px; padding: .85rem 1rem;
      transition: border-color .2s, background .2s;
    }
    .pv-detail-chip:hover { background: rgba(255,140,0,.1); border-color: rgba(255,140,0,.3); }
    .pv-detail-chip__key {
      font-size: .6rem; font-weight: 700; letter-spacing: .08em;
      text-transform: uppercase; color: rgba(255,255,255,.35); margin-bottom: .3rem;
    }
    .pv-detail-chip__val {
      font-size: .9rem; font-weight: 700; color: #fff;
    }

    /* ── RATES ── */
    .pv-rates { display: flex; gap: 1rem; flex-wrap: wrap; }
    .pv-rate-card {
      flex: 1 1 160px; background: rgba(255,140,0,.08);
      border: 1.5px solid rgba(255,140,0,.3); border-radius: 14px;
      padding: 1.2rem 1.4rem; text-align: center;
      transition: box-shadow .25s, border-color .25s;
    }
    .pv-rate-card:hover {
      border-color: rgba(255,140,0,.7);
      box-shadow: 0 0 20px rgba(255,140,0,.18);
    }
    .pv-rate-card__type {
      font-size: .65rem; font-weight: 700; letter-spacing: .1em;
      text-transform: uppercase; color: rgba(255,255,255,.45); margin-bottom: .45rem;
    }
    .pv-rate-card__price {
      font-size: 1.7rem; font-weight: 900;
      background: linear-gradient(135deg, #ff8c00, #ffb347);
      -webkit-background-clip: text; -webkit-text-fill-color: transparent;
      background-clip: text; line-height: 1;
    }
    .pv-rate-card__per {
      font-size: .72rem; color: rgba(255,255,255,.35); margin-top: .3rem;
    }

    /* ── SERVICES ── */
    .pv-tags { display: flex; flex-wrap: wrap; gap: .2rem; align-items: center; }
    .pv-tag {
      font-size: .85rem; font-weight: 600;
      color: rgba(255,140,0,.9);
      transition: all .2s;
    }
    .pv-tag:not(:last-child):after {
      content: "•";
      color: rgba(255,255,255,0.3);
      margin-left: 0.5rem;
      margin-right: 0.2rem;
    }
    .pv-tag:hover {
      color: #ff8c00;
    }

    /* ── PHOTO GALLERY ── */
    .pv-gallery {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(190px, 1fr));
      gap: 1rem;
    }
    .pv-gallery__item {
      aspect-ratio: 3/4; border-radius: 14px; overflow: hidden;
      position: relative; cursor: pointer;
      border: 1.5px solid rgba(255,140,0,.15);
      transition: transform .3s ease, border-color .3s ease, box-shadow .3s ease;
    }
    .pv-gallery__item:hover {
      transform: scale(1.03);
      border-color: rgba(255,140,0,.55);
      box-shadow: 0 0 18px rgba(255,140,0,.22);
    }
    .pv-gallery__item img {
      width: 100%; height: 100%; object-fit: cover; display: block;
      transition: transform .5s ease;
    }
    .pv-gallery__item:hover img { transform: scale(1.07); }
    .pv-gallery__overlay {
      position: absolute; inset: 0;
      background: linear-gradient(180deg, transparent 55%, rgba(0,0,0,.75) 100%);
      opacity: 0; transition: opacity .25s;
      display: flex; align-items: flex-end; padding: .75rem;
    }
    .pv-gallery__item:hover .pv-gallery__overlay { opacity: 1; }
    .pv-gallery__overlay-text { font-size: .72rem; color: rgba(255,255,255,.8); }

    /* ── LIGHTBOX ── */
    .pv-lightbox {
      display: none; position: fixed; inset: 0; z-index: 2000;
      background: rgba(0,0,0,.95); backdrop-filter: blur(12px);
      align-items: center; justify-content: center; padding: 1rem;
    }
    .pv-lightbox.open { display: flex; animation: lbFadeIn .2s ease both; }
    @keyframes lbFadeIn { from{opacity:0;} to{opacity:1;} }
    .pv-lightbox__img {
      max-height: 90vh; max-width: 90vw; border-radius: 12px;
      object-fit: contain; box-shadow: 0 0 60px rgba(255,140,0,.25);
      animation: lbPop .25s cubic-bezier(.34,1.4,.64,1) both;
    }
    @keyframes lbPop { from{transform:scale(.88);} to{transform:scale(1);} }
    .pv-lightbox__close {
      position: fixed; top: 1.2rem; right: 1.2rem;
      width: 42px; height: 42px; border-radius: 50%;
      background: rgba(255,255,255,.1); border: 1px solid rgba(255,255,255,.2);
      color: #fff; cursor: pointer; display: flex; align-items: center; justify-content: center;
      transition: all .2s;
    }
    .pv-lightbox__close:hover { background: rgba(255,140,0,.25); border-color: rgba(255,140,0,.5); }

    /* ── SIMILAR PROFILES ── */
    .pv-similar { padding: 3rem 0 5rem; background: #080808; border-top: 1px solid rgba(255,140,0,.1); }
    .pv-similar-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(170px, 1fr));
      gap: 1.1rem;
      margin-top: 1.4rem;
    }
    .pv-similar-card {
      border-radius: 14px; overflow: hidden;
      border: 1.5px solid rgba(255,140,0,.15);
      background: #111;
      transition: transform .3s, border-color .3s, box-shadow .3s;
      text-decoration: none; display: block;
      cursor: pointer;
    }
    .pv-similar-card:hover {
      transform: translateY(-4px);
      border-color: rgba(255,140,0,.5);
      box-shadow: 0 8px 24px rgba(255,140,0,.18);
    }
    .pv-similar-card__img {
      aspect-ratio: 3/4; width: 100%; object-fit: cover;
      display: block;
    }
    .pv-similar-card__info {
      padding: .65rem .75rem;
    }
    .pv-similar-card__name {
      font-size: .88rem; font-weight: 700; color: #fff;
      white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    }
    .pv-similar-card__meta {
      font-size: .72rem; color: rgba(255,255,255,.4); margin-top: .2rem;
    }
    /* ── AUTH GATE ── */
    .pv-auth-gate {
      background: rgba(255,140,0,.06); border: 1.5px dashed rgba(255,140,0,.3);
      border-radius: 14px; padding: 1.5rem 1.25rem; text-align: center;
      margin-bottom: .65rem;
    }
    .pv-auth-gate__icon { font-size: 1.6rem; margin-bottom: .5rem; display: block; }
    .pv-auth-gate__text { font-size: .82rem; color: rgba(255,255,255,.5); margin-bottom: .9rem; line-height: 1.5; }
    .pv-auth-gate__btn {
      display: inline-flex; align-items: center; gap: .45rem;
      padding: .6rem 1.2rem; border-radius: 8px;
      background: #ff8c00; color: #000; font-weight: 700; font-size: .85rem;
      text-decoration: none; transition: all .2s;
    }
    .pv-auth-gate__btn:hover { background: #000; color: #ff8c00; box-shadow: 0 0 16px rgba(255,140,0,.4); }
    /* ── CTA SIDEBAR ── */
    .pv-cta-card {
      background: linear-gradient(160deg, #1a0f00, #111);
      border: 1.5px solid rgba(255,140,0,.3); border-radius: 18px;
      padding: 1.75rem 1.5rem; position: sticky; top: 1.5rem;
    }
    .pv-cta-avatar {
      width: 88px; height: 88px; border-radius: 50%; overflow: hidden;
      border: 3px solid rgba(255,140,0,.5); margin: 0 auto 1rem; display: block;
      box-shadow: 0 0 22px rgba(255,140,0,.25);
    }
    .pv-cta-avatar img { width: 100%; height: 100%; object-fit: cover; }
    .pv-cta-name {
      font-size: 1.3rem; font-weight: 900; text-align: center;
      background: linear-gradient(135deg, #ff8c00, #ffb347);
      -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
      margin-bottom: .25rem;
    }
    .pv-cta-sub {
      font-size: .78rem; color: rgba(255,255,255,.4); text-align: center; margin-bottom: 1.4rem;
    }
    .pv-cta-btn {
      display: flex; align-items: center; justify-content: center; gap: .5rem;
      width: 100%; padding: .8rem 1rem; border-radius: 10px;
      font-family: "Outfit", sans-serif; font-size: .9rem; font-weight: 700;
      cursor: pointer; text-decoration: none; transition: all .25s; margin-bottom: .65rem;
      border: 2px solid transparent;
    }
    .pv-cta-btn--primary {
      background: #ff8c00; color: #000; border-color: #ff8c00;
    }
    .pv-cta-btn--primary:hover {
      background: #000; color: #ff8c00; box-shadow: 0 0 20px rgba(255,140,0,.5);
    }
    .pv-cta-btn--ghost {
      background: transparent; color: rgba(255,140,0,.9); border-color: rgba(255,140,0,.35);
    }
    .pv-cta-btn--ghost:hover {
      background: rgba(255,140,0,.1); border-color: rgba(255,140,0,.65); color: #ff8c00;
    }
    .pv-cta-divider {
      border: none; border-top: 1px solid rgba(255,255,255,.08); margin: 1.2rem 0;
    }
    .pv-cta-stat {
      display: flex; justify-content: space-between; align-items: center;
      padding: .45rem 0; border-bottom: 1px solid rgba(255,255,255,.05);
      font-size: .82rem;
    }
    .pv-cta-stat:last-child { border-bottom: none; }
    .pv-cta-stat__key { color: rgba(255,255,255,.4); }
    .pv-cta-stat__val { font-weight: 700; color: #fff; }

    /* ── STATUS PILL ── */
    .pv-status-pill {
      display: inline-flex; align-items: center; gap: .4rem;
      background: rgba(74,222,128,.12); border: 1px solid rgba(74,222,128,.3);
      border-radius: 4px; padding: .3rem .65rem; font-size: .68rem;
      font-weight: 700; letter-spacing: .06em; text-transform: uppercase;
      color: #4ade80; margin-bottom: .5rem;
    }
    .pv-status-pill .dot { width: 5px; height: 5px; background: #4ade80; border-radius: 50%; animation: pulseGreen 1.6s infinite; }

    /* responsive */
    @media (max-width: 768px) {
      .pv-hero { height: min(65vh, 480px); }
      .pv-cta-card { position: static; }
    }

    /* ── LIGHT THEME OVERRIDES ── */
    [data-bs-theme="light"] body { background: #f4f6f9 !important; color: #111 !important; }
    [data-bs-theme="light"] .pv-hero { background: linear-gradient(135deg, #fff3e6, #ffffff) !important; }
    [data-bs-theme="light"] .pv-hero__bg { filter: brightness(0.9) saturate(1.1) !important; }
    [data-bs-theme="light"] .pv-hero__overlay {
      background: linear-gradient(180deg, rgba(244,246,249,0.1) 0%, rgba(244,246,249,0.6) 50%, rgba(244,246,249,1) 100%) !important;
    }
    [data-bs-theme="light"] .pv-back-btn {
      background: rgba(255,255,255,0.9) !important; border-color: rgba(0,0,0,0.1) !important; color: #111 !important;
    }
    [data-bs-theme="light"] .pv-back-btn:hover { background: rgba(255,140,0,0.15) !important; color: #ff8c00 !important; border-color: rgba(255,140,0,0.4) !important; }
    [data-bs-theme="light"] .pv-hero__meta { color: rgba(0,0,0,0.7) !important; }
    [data-bs-theme="light"] .pv-card {
      background: #ffffff !important; border-color: rgba(255,140,0,0.3) !important; box-shadow: 0 4px 20px rgba(0,0,0,0.03) !important;
    }
    [data-bs-theme="light"] .pv-about-text { color: rgba(0,0,0,0.7) !important; }
    [data-bs-theme="light"] .pv-detail-chip { background: rgba(255,140,0,0.05) !important; border-color: rgba(255,140,0,0.2) !important; }
    [data-bs-theme="light"] .pv-detail-chip:hover { background: rgba(255,140,0,0.08) !important; border-color: rgba(255,140,0,0.35) !important; }
    [data-bs-theme="light"] .pv-detail-chip__key { color: rgba(0,0,0,0.5) !important; }
    [data-bs-theme="light"] .pv-detail-chip__val { color: #111 !important; }
    [data-bs-theme="light"] .pv-rate-card { background: rgba(255,140,0,0.04) !important; border-color: rgba(255,140,0,0.25) !important; }
    [data-bs-theme="light"] .pv-rate-card:hover { border-color: rgba(255,140,0,0.6) !important; box-shadow: 0 0 15px rgba(255,140,0,0.1) !important; }
    [data-bs-theme="light"] .pv-rate-card__type, [data-bs-theme="light"] .pv-rate-card__per { color: rgba(0,0,0,0.5) !important; }
    [data-bs-theme="light"] .pv-tag:not(:last-child):after { color: rgba(0,0,0,0.3) !important; }
    [data-bs-theme="light"] .pv-gallery__item { border-color: rgba(255,140,0,0.2) !important; }
    [data-bs-theme="light"] .pv-similar { background: #f8f9fa !important; border-top-color: rgba(255,140,0,0.2) !important; }
    [data-bs-theme="light"] .pv-similar-card { background: #ffffff !important; border-color: rgba(255,140,0,0.2) !important; box-shadow: 0 4px 15px rgba(0,0,0,0.03) !important; }
    [data-bs-theme="light"] .pv-similar-card__name { color: #111 !important; }
    [data-bs-theme="light"] .pv-similar-card__meta { color: rgba(0,0,0,0.6) !important; }
    [data-bs-theme="light"] .pv-auth-gate { background: rgba(255,140,0,0.04) !important; border-color: rgba(255,140,0,0.3) !important; }
    [data-bs-theme="light"] .pv-auth-gate__text { color: rgba(0,0,0,0.6) !important; }
    [data-bs-theme="light"] .pv-cta-card { background: #ffffff !important; border-color: rgba(255,140,0,0.3) !important; box-shadow: 0 8px 30px rgba(0,0,0,0.05) !important; }
    [data-bs-theme="light"] .pv-cta-sub { color: rgba(0,0,0,0.6) !important; }
    [data-bs-theme="light"] .pv-cta-btn--ghost { color: rgba(255,140,0,0.95) !important; border-color: rgba(255,140,0,0.5) !important; }
    [data-bs-theme="light"] .pv-cta-btn--ghost:hover { background: rgba(255,140,0,0.08) !important; border-color: #ff8c00 !important; color: #ff8c00 !important; }
    [data-bs-theme="light"] .pv-cta-divider { border-top-color: rgba(0,0,0,0.08) !important; }
    [data-bs-theme="light"] .pv-cta-stat { border-bottom-color: rgba(0,0,0,0.05) !important; }
    [data-bs-theme="light"] .pv-cta-stat__key { color: rgba(0,0,0,0.6) !important; }
    [data-bs-theme="light"] .pv-cta-stat__val { color: #111 !important; }
    [data-bs-theme="light"] .text-white-50 { color: rgba(0,0,0,0.5) !important; }
    [data-bs-theme="light"] .pv-card svg[stroke="rgba(255,140,0,0.6)"] { stroke: rgba(255,140,0,0.8) !important; }
    [data-bs-theme="light"] .pv-card div[style*="color:rgba(255,255,255,0.45)"] { color: rgba(0,0,0,0.5) !important; }
    [data-bs-theme="light"] .pv-auth-gate__icon svg { color: rgba(0,0,0,0.5) !important; }
    [data-bs-theme="light"] .pv-cta-stat__val[style*="color:#ff8c00;"] { color: rgba(255,140,0,0.95) !important; }
    [data-bs-theme="light"] p[style*="color:rgba(255,255,255,.25)"] { color: rgba(0,0,0,0.4) !important; }
  </style>
</head>
<body>
<x-site-preloader />
@php
  $cover     = $user->profile_photo ? asset('storage/'.$user->profile_photo) : ($user->photos->first() ? asset('storage/'.$user->photos->first()->path) : asset('callboy-1.png'));
  $services  = $user->services ? (is_array($user->services) ? $user->services : json_decode($user->services, true)) : [];
  $services  = is_array($services) ? $services : [];
  $isVip     = $user->hasActiveSubscription() && in_array($user->subscription_plan, ['vip','prime_vip','prime-vip']);
  $photos    = $user->photos ?? collect();
  $age       = $user->age;
  $city      = $user->city_town;
  $county    = $user->county;
  $nation    = $user->nationality;
  $orient    = $user->sexual_orientation;
  $gender    = $user->gender;
  $location  = $user->location;
  $area      = $user->area;
  $nearby    = $user->nearby_places;
  $incalls   = $user->incalls_rate;
  $outcalls  = $user->outcalls_rate;
  $otherSvc  = $user->other_services;
  $otherCit  = $user->other_cities;
@endphp

{{-- NAVBAR --}}
<x-navbar />

{{-- HERO --}}
<section class="pv-hero">
  <img class="pv-hero__bg" src="{{ $cover }}" alt="{{ $user->name }}">
  <div class="pv-hero__overlay"></div>

  {{-- Back button --}}
  <a href="javascript:history.back()" class="pv-back-btn" aria-label="Go back">
    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M19 12H5M12 5l-7 7 7 7"/></svg>
  </a>

  <div class="pv-hero__content container">
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-3 w-100">
      <h1 class="pv-hero__name mb-0">
        <span>{{ $user->name }}</span>
      </h1>
      
      <div class="pv-hero__badge mb-0 mt-2">
        @if($isVip) <span class="pv-hero__vip">VIP</span> @endif
        Available Now
      </div>
    </div>

    <div class="pv-hero__meta">
      @if($age)
      <span class="pv-hero__meta-item">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M12 12a4 4 0 1 1 0-8 4 4 0 0 1 0 8Zm0 2c4.42 0 8 2.24 8 5v1H4v-1c0-2.76 3.58-5 8-5Z"/></svg>
        {{ $age }} years old
      </span>
      @endif
      @if($city)
      <span class="pv-hero__meta-item">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M12 21s-6-5.33-6-11a6 6 0 1 1 12 0c0 5.67-6 11-6 11Z"/><circle cx="12" cy="10" r="2.5"/></svg>
        {{ $city }}@if($county), {{ $county }}@endif
      </span>
      @endif
      @if($nation)
      <span class="pv-hero__meta-item">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="12" cy="12" r="10"/><path d="M2 12h20M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10A15.3 15.3 0 0 1 12 2z"/></svg>
        {{ $nation }}
      </span>
      @endif
    </div>
  </div>
</section>

{{-- BODY --}}
<div class="pv-body">
  <div class="container">
    <div class="row g-4">

      {{-- LEFT: Main content --}}
      <div class="col-lg-8">

        {{-- About --}}
        @if($otherSvc || $nearby || $otherCit)
        <div class="pv-card">
          <div class="pv-section-title">About</div>
          <p class="pv-about-text mb-0">
            {{ $otherSvc ?? '' }}
            @if($nearby) Located near: {{ $nearby }}.@endif
            @if($otherCit) Also available in: {{ $otherCit }}.@endif
          </p>
        </div>
        @endif

        {{-- Details --}}
        <div class="pv-card">
          <div class="pv-section-title">Details</div>
          <div class="pv-details-grid">
            @if($age)
            <div class="pv-detail-chip">
              <div class="pv-detail-chip__key">Age</div>
              <div class="pv-detail-chip__val">{{ $age }} years</div>
            </div>
            @endif
            @if($gender)
            <div class="pv-detail-chip">
              <div class="pv-detail-chip__key">Gender</div>
              <div class="pv-detail-chip__val">{{ ucfirst($gender) }}</div>
            </div>
            @endif
            @if($orient)
            <div class="pv-detail-chip">
              <div class="pv-detail-chip__key">Orientation</div>
              <div class="pv-detail-chip__val">{{ ucwords(str_replace('_', ' ', $orient)) }}</div>
            </div>
            @endif
            @if($nation)
            <div class="pv-detail-chip">
              <div class="pv-detail-chip__key">Nationality</div>
              <div class="pv-detail-chip__val">{{ $nation }}</div>
            </div>
            @endif
            @if($city)
            <div class="pv-detail-chip">
              <div class="pv-detail-chip__key">City</div>
              <div class="pv-detail-chip__val">{{ $city }}</div>
            </div>
            @endif
            @if($county)
            <div class="pv-detail-chip">
              <div class="pv-detail-chip__key">County</div>
              <div class="pv-detail-chip__val">{{ $county }}</div>
            </div>
            @endif
            @if($location)
            <div class="pv-detail-chip">
              <div class="pv-detail-chip__key">Location</div>
              <div class="pv-detail-chip__val">{{ $location }}</div>
            </div>
            @endif
            @if($area)
            <div class="pv-detail-chip">
              <div class="pv-detail-chip__key">Area</div>
              <div class="pv-detail-chip__val">{{ $area }}</div>
            </div>
            @endif
          </div>
        </div>

        {{-- Rates --}}
        @if($incalls || $outcalls)
        <div class="pv-card">
          <div class="pv-section-title">Rates</div>
          <div class="pv-rates">
            @if($incalls)
            <div class="pv-rate-card">
              <div class="pv-rate-card__type">In-calls</div>
              <div class="pv-rate-card__price">KES {{ number_format($incalls) }}</div>
              <div class="pv-rate-card__per">per session</div>
            </div>
            @endif
            @if($outcalls)
            <div class="pv-rate-card">
              <div class="pv-rate-card__type">Out-calls</div>
              <div class="pv-rate-card__price">KES {{ number_format($outcalls) }}</div>
              <div class="pv-rate-card__per">per session</div>
            </div>
            @endif
          </div>
        </div>
        @endif

        {{-- Services --}}
        @if(count($services) > 0)
        <div class="pv-card">
          <div class="pv-section-title">Services Offered</div>
          <div class="pv-tags">
            @foreach($services as $svc)
              <span class="pv-tag">{{ $svc }}</span>
            @endforeach
          </div>
        </div>
        @endif

        {{-- Photo Gallery --}}
        @php
            $canSeePhotos = ($user->photos_visibility ?? 'everybody') === 'everybody'
                || (auth()->check() && auth()->id() === $user->id);
        @endphp
        @if($photos->count() > 0 && $canSeePhotos)
        <div class="pv-card">
          <div class="pv-section-title">Photo Gallery ({{ $photos->count() }} {{ Str::plural('photo', $photos->count()) }})</div>
          <div class="pv-gallery">
            @foreach($photos as $i => $photo)
            <div class="pv-gallery__item" onclick="openLightbox('{{ asset('storage/'.$photo->path) }}')" title="View photo">
              <img src="{{ asset('storage/'.$photo->path) }}" alt="{{ $user->name }} photo {{ $i+1 }}" loading="lazy">
              <div class="pv-gallery__overlay">
                <span class="pv-gallery__overlay-text">
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" style="vertical-align:middle;margin-right:4px;"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                  View
                </span>
              </div>
            </div>
            @endforeach
          </div>
        </div>
        @elseif($photos->count() > 0 && !$canSeePhotos)
        <div class="pv-card" style="text-align:center;padding:2rem;">
          <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="rgba(255,140,0,0.6)" stroke-width="1.5" stroke-linecap="round" style="margin-bottom:1rem;"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
          <div style="color:rgba(255,255,255,0.45);font-size:0.9rem;">Photos are set to private by this user.</div>
        </div>
        @endif

        {{-- Videos --}}
        @if($user->videos->count() > 0)
        <div class="pv-card">
          <div class="pv-section-title">Videos ({{ $user->videos->count() }})</div>
          <div class="row g-3">
            @foreach($user->videos as $video)
            <div class="col-sm-6">
              <div style="border-radius:12px;overflow:hidden;border:1.5px solid rgba(255,140,0,.18);">
                <video controls preload="metadata" style="width:100%;display:block;background:#0d0d0d;max-height:240px;object-fit:cover;" onplay="trackVideoPlay({{ $video->id }}, this)">
                  <source src="{{ asset('storage/'.$video->path) }}">
                </video>
                <div class="p-2 text-white-50" style="font-size:0.85rem;">
                  <span class="video-views-count">{{ number_format($video->views) }}</span> views
                </div>
              </div>
            </div>
            @endforeach
          </div>
        </div>
        @endif

      </div>{{-- /col-lg-8 --}}

      {{-- RIGHT: CTA card --}}
      <div class="col-lg-4">
        <div class="pv-cta-card">

          <div class="pv-cta-avatar">
            <img src="{{ $cover }}" alt="{{ $user->name }}">
          </div>

          <div class="pv-cta-name">{{ $user->name }}</div>
          <div class="pv-cta-sub">
            @if($city){{ $city }}@if($county), {{ $county }}@endif @endif
          </div>

          @if($isVip)
          <div class="text-center mb-3">
            <span class="pv-hero__vip">VIP Member</span>
          </div>
          @endif

          {{-- WhatsApp / Call CTA — auth-gated --}}
          @auth
            @if($user->phone_number)
            <a href="https://wa.me/{{ preg_replace('/\D/', '', $user->phone_number) }}?text=Hi+{{ urlencode($user->name) }}%2C+I+found+your+profile+on+Kenyan+Baddies+Club+and+I%27m+interested."
               target="_blank" rel="noopener" class="pv-cta-btn pv-cta-btn--primary" onclick="trackCall({{ $user->id }})">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 0 0-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z"/></svg>
              WhatsApp
            </a>
            <a href="tel:{{ $user->phone_number }}" class="pv-cta-btn pv-cta-btn--ghost" onclick="trackCall({{ $user->id }})">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12.34a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.6 1.62h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 9.22a16 16 0 0 0 6.29 6.29l.96-.96a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
              Call Now
            </a>
            @else
            <a href="#" class="pv-cta-btn pv-cta-btn--primary" onclick="alert('This member has not added a contact number yet.');return false;">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
              Contact
            </a>
            @endif
          @else
            {{-- Guest: show auth gate --}}
            <div class="pv-auth-gate">
              <span class="pv-auth-gate__icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" style="color:rgba(255,255,255,0.7);"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
              </span>
              <p class="pv-auth-gate__text">Sign in to view contact details and connect with this member.</p>
              <a href="{{ route('login') }}" class="pv-auth-gate__btn">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4M10 17l5-5-5-5M15 12H3"/></svg>
                Sign In
              </a>
            </div>
          @endauth

          <hr class="pv-cta-divider">

          {{-- Quick Stats --}}
          <div>
            @if($age)
            <div class="pv-cta-stat">
              <span class="pv-cta-stat__key">Age</span>
              <span class="pv-cta-stat__val">{{ $age }} years</span>
            </div>
            @endif
            @if($nation)
            <div class="pv-cta-stat">
              <span class="pv-cta-stat__key">Nationality</span>
              <span class="pv-cta-stat__val">{{ $nation }}</span>
            </div>
            @endif
            @if($incalls)
            <div class="pv-cta-stat">
              <span class="pv-cta-stat__key">In-call Rate</span>
              <span class="pv-cta-stat__val" style="color:#ff8c00;">KES {{ number_format($incalls) }}</span>
            </div>
            @endif
            @if($outcalls)
            <div class="pv-cta-stat">
              <span class="pv-cta-stat__key">Out-call Rate</span>
              <span class="pv-cta-stat__val" style="color:#ff8c00;">KES {{ number_format($outcalls) }}</span>
            </div>
            @endif
            @if(count($services) > 0)
            <div class="pv-cta-stat">
              <span class="pv-cta-stat__key">Services</span>
              <span class="pv-cta-stat__val">{{ count($services) }} listed</span>
            </div>
            @endif
            @if($photos->count() > 0)
            <div class="pv-cta-stat">
              <span class="pv-cta-stat__key">Photos</span>
              <span class="pv-cta-stat__val">{{ $photos->count() }}</span>
            </div>
            @endif
            <div class="pv-cta-stat">
              <span class="pv-cta-stat__key">Status</span>
              <span class="pv-cta-stat__val" style="color:#4ade80;">Verified</span>
            </div>
          </div>

          <hr class="pv-cta-divider">
          <p style="font-size:.7rem;color:rgba(255,255,255,.25);text-align:center;margin:0;">
            Always meet in safe, public places. Stay safe.
          </p>
        </div>
      </div>{{-- /col-lg-4 --}}

    </div>{{-- /row --}}
  </div>{{-- /container --}}
</div>

{{-- SIMILAR PROFILES --}}
@if(isset($similarProfiles) && $similarProfiles->isNotEmpty())
<section class="pv-similar">
  <div class="container">
    <div class="pv-section-title">You May Also Like</div>
    <div class="pv-similar-grid">
      @foreach($similarProfiles as $sp)
        @php
          $spCover = $sp->profile_photo ? asset('storage/'.$sp->profile_photo)
                   : ($sp->photos->first() ? asset('storage/'.$sp->photos->first()->path) : asset('callboy-1.png'));
        @endphp
        <a href="{{ url('profile', $sp->id) }}" class="pv-similar-card">
          <img class="pv-similar-card__img" src="{{ $spCover }}" alt="{{ $sp->name }}" loading="lazy">
          <div class="pv-similar-card__info">
            <div class="pv-similar-card__name">{{ $sp->name }}</div>
            <div class="pv-similar-card__meta">
              {{ $sp->age ? $sp->age.' yrs' : '' }}{{ $sp->age && $sp->city_town ? ' · ' : '' }}{{ $sp->city_town ?? '' }}
            </div>
          </div>
        </a>
      @endforeach
    </div>
  </div>
</section>
@endif

{{-- LIGHTBOX --}}
<div class="pv-lightbox" id="pv-lightbox" onclick="closeLightbox(event)">
  <button class="pv-lightbox__close" onclick="closeLightbox()" aria-label="Close">
    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M18 6L6 18M6 6l12 12"/></svg>
  </button>
  <img class="pv-lightbox__img" id="pv-lightbox-img" src="" alt="Photo">
</div>

{{-- FOOTER --}}
<x-footer />

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  function openLightbox(src) {
    document.getElementById('pv-lightbox-img').src = src;
    document.getElementById('pv-lightbox').classList.add('open');
    document.body.style.overflow = 'hidden';
  }
  function closeLightbox(e) {
    if (!e || e.target === document.getElementById('pv-lightbox') || e.target.closest('.pv-lightbox__close')) {
      document.getElementById('pv-lightbox').classList.remove('open');
      document.body.style.overflow = '';
    }
  }
  document.addEventListener('keydown', e => {
    if (e.key === 'Escape') closeLightbox({ target: document.getElementById('pv-lightbox') });
  });
</script>
<script>
  function trackCall(id) {
    fetch('/profile/' + id + '/track-call', {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}',
        'Content-Type': 'application/json'
      }
    }).catch(console.error);
  }

  function trackVideoPlay(id, element) {
    if (element.dataset.viewed) return;
    fetch('/videos/' + id + '/view', {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}',
        'Accept': 'application/json'
      }
    })
    .then(r => r.json())
    .then(data => {
       if (data.success) {
           element.dataset.viewed = "true";
           var countEl = element.parentElement.querySelector('.video-views-count');
           if (countEl) countEl.textContent = data.views.toLocaleString();
       }
    })
    .catch(console.error);
  }
</script>
</body>
</html>
