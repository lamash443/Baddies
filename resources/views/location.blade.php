<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Escorts and Call Girls in {{ ucwords($searchLocation) }} - Baddies Club</title>
  <meta name="description" content="Browse verified escorts, call girls, and companions in {{ ucwords($searchLocation) }} on Baddies Club. Find your perfect companion near you.">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/listing-card.css') }}">
  <style>
    *, *::before, *::after { box-sizing:border-box; }
    html, body { margin:0; padding:0; font-family:"Outfit",sans-serif; background:#0d0d0d; color:#fff; min-height:100vh; }

    /* NAVBAR */
    .nr-navbar { background:linear-gradient(160deg,#0d0d0d 0%,#1a0f00 50%,#0d0d0d 100%) !important; border-bottom:2px solid rgba(255,140,0,0.6); box-shadow:inset 0 -2px 30px rgba(255,140,0,0.06); padding-top:1.25rem !important; padding-bottom:1.25rem !important; }
    .nr-navbar .nav-link { font-weight:500; font-size:0.82rem; color:rgba(255,140,0,0.92) !important; text-decoration:none !important; display:inline-block !important; position:relative !important; padding-bottom:3px !important; box-shadow:none !important; transition:color 0.3s ease !important; }
    .nr-navbar .nav-link::after { content:"" !important; position:absolute !important; left:0 !important; bottom:0 !important; width:100% !important; height:1.5px !important; background:linear-gradient(90deg,rgba(255,255,255,0) 0%,rgba(255,255,255,0.9) 50%,rgba(255,255,255,0) 100%) !important; border-radius:2px !important; transform:scaleX(0) !important; transform-origin:center !important; transition:transform 0.35s cubic-bezier(0.4,0,0.2,1) !important; }
    .nr-navbar .nav-link.active, .nr-navbar .nav-link:hover, .nr-navbar .nav-link:focus { color:#ffffff !important; text-decoration:none !important; box-shadow:none !important; }
    .nr-navbar .nav-link.active::after, .nr-navbar .nav-link:hover::after, .nr-navbar .nav-link:focus::after { transform:scaleX(1) !important; }

    /* BREADCRUMB */
    .cb-breadcrumb-bar { background:linear-gradient(160deg,#0d0d0d 0%,#1a0f00 50%,#0d0d0d 100%); border-bottom:1px solid rgba(255,140,0,0.18); padding:0.65rem 0; }
    .cb-breadcrumb { display:flex; align-items:center; gap:0.4rem; font-size:0.78rem; font-weight:500; color:rgba(255,255,255,0.45); list-style:none; margin:0; padding:0; flex-wrap:wrap; }
    .cb-breadcrumb li { display:flex; align-items:center; gap:0.4rem; }
    .cb-breadcrumb a { color:rgba(255,140,0,0.85); text-decoration:none; transition:color 0.2s; }
    .cb-breadcrumb a:hover { color:#fff; }
    .cb-breadcrumb .sep { color:rgba(255,255,255,0.2); }
    .cb-breadcrumb .current { color:rgba(255,255,255,0.6); }

    /* PAGE HEADER */
    .cb-page-header { position:relative; overflow:hidden; padding:4rem 0 3rem; background:linear-gradient(180deg,rgba(26,15,0,0.6) 0%,transparent 100%); border-bottom:1px solid rgba(255,140,0,0.12); margin-bottom:0; }
    .cb-page-header::before { content:""; position:absolute; top:-80px; right:-80px; width:400px; height:400px; background:radial-gradient(circle,rgba(255,140,0,0.07) 0%,transparent 65%); pointer-events:none; }
    .cb-header-label { font-size:0.7rem; letter-spacing:0.14em; text-transform:uppercase; color:rgba(255,140,0,0.75); font-weight:600; margin-bottom:0.6rem; display:flex; align-items:center; gap:0.5rem; }
    .cb-header-label::before { content:""; display:block; width:28px; height:1.5px; background:rgba(255,140,0,0.5); border-radius:2px; }
    .cb-page-title { font-size:clamp(2rem,4vw,3rem); font-weight:900; letter-spacing:-0.02em; line-height:1.1; margin-bottom:0.6rem; }
    .cb-page-title span { background:linear-gradient(135deg,#ff8c00,#ffb347); -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text; }
    .cb-page-desc { font-size:0.92rem; color:rgba(255,255,255,0.48); font-weight:400; max-width:520px; line-height:1.7; }
    .cb-count-badge { display:inline-flex; align-items:center; gap:0.4rem; background:rgba(255,140,0,0.1); border:1px solid rgba(255,140,0,0.25); border-radius:50px; padding:0.3rem 1rem; font-size:0.75rem; font-weight:600; color:rgba(255,140,0,0.9); margin-bottom:1rem; }
    .cb-count-badge .dot { width:6px; height:6px; background:rgba(255,140,0,0.9); border-radius:50%; animation:pulseDot 1.8s infinite; }
    @keyframes pulseDot { 0%,100%{opacity:1;transform:scale(1);} 50%{opacity:0.4;transform:scale(1.6);} }

    /* FILTER BAR */
    .cb-filter-bar { background:rgba(255,140,0,0.03); border-bottom:1px solid rgba(255,140,0,0.1); padding:1rem 0; margin-bottom:2.5rem; }
    .cb-filters { display:flex; gap:0.6rem; flex-wrap:wrap; align-items:center; }
    .cb-filter-btn { padding:0.4rem 1rem; border-radius:50px; cursor:pointer; font-family:"Outfit",sans-serif; font-size:0.78rem; font-weight:700; border:2px solid orange; background:transparent; color:orange; transition:color 0.3s ease, background-color 0.3s ease, box-shadow 0.3s ease, transform 0.2s ease; letter-spacing:0.02em; }
    .cb-filter-btn:hover { background:#000; border-color:orange; color:orange; box-shadow:0 0 18px rgba(255,165,0,0.55), 0 4px 14px rgba(0,0,0,0.3); transform:translateY(-2px); }
    .cb-filter-btn:active { transform:scale(0.97); }
    .cb-filter-btn.active { background:orange; border-color:orange; color:#000; }
    .cb-filter-btn.active:hover { background:#000; color:orange; box-shadow:0 0 18px rgba(255,165,0,0.55), 0 4px 14px rgba(0,0,0,0.3); transform:translateY(-2px); }
    .cb-filter-select { background:#111; border:1.5px solid rgba(255,140,0,0.28); border-radius:50px; color:#fff; padding:0.4rem 2.2rem 0.4rem 1rem; font-family:"Outfit",sans-serif; font-size:0.78rem; font-weight:500; appearance:none; -webkit-appearance:none; cursor:pointer; background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='7' viewBox='0 0 10 7'%3E%3Cpath d='M1 1l4 4 4-4' stroke='%23ff8c00' stroke-width='1.5' fill='none' stroke-linecap='round'/%3E%3C/svg%3E"); background-repeat:no-repeat; background-position:right 0.75rem center; transition:border-color 0.22s ease; }
    .cb-filter-select:focus { outline:none; border-color:rgba(255,140,0,0.7); }
    .cb-filter-select option { background:#1a1a1a; }

    /* GRID */
    .cb-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(260px,1fr)); gap:1.6rem; padding-bottom:5rem; }

    /* CARD */
    .cb-card { background:#111; border:1px solid rgba(255,140,0,0.1); border-radius:18px; overflow:hidden; position:relative; transition:transform 0.3s ease, box-shadow 0.3s ease, border-color 0.3s ease; cursor:pointer; }
    .cb-card:hover { transform:translateY(-8px) scale(1.012); box-shadow:0 20px 56px rgba(0,0,0,0.65), 0 0 0 1px rgba(255,140,0,0.38); border-color:rgba(255,140,0,0.38); }
    .cb-card:focus-visible { outline:2px solid rgba(255,140,0,0.7); outline-offset:2px; }

    /* Photo */
    .cb-card__photo { position:relative; width:100%; padding-top:118%; overflow:hidden; background:#1a1a1a; }
    .cb-card__photo img { position:absolute; inset:0; width:100%; height:100%; object-fit:cover; transition:transform 0.45s ease; }
    .cb-card:hover .cb-card__photo img { transform:scale(1.06); }
    .cb-card__photo-overlay { position:absolute; inset:0; background:linear-gradient(180deg,transparent 45%,rgba(0,0,0,0.92) 100%); z-index:1; }
    .cb-card__photo-inner { position:absolute; inset:0; display:flex; align-items:center; justify-content:center; }

    /* Badges */
    .cb-card__status { position:absolute; top:0.8rem; left:0.8rem; z-index:2; display:flex; align-items:center; gap:0.35rem; background:rgba(0,0,0,0.7); backdrop-filter:blur(6px); border:1px solid rgba(255,140,0,0.3); border-radius:50px; padding:0.22rem 0.65rem; font-size:0.65rem; font-weight:600; letter-spacing:0.06em; text-transform:uppercase; color:rgba(255,200,60,1); }
    .cb-card__status .sdot { width:5px; height:5px; background:#4ade80; border-radius:50%; animation:pulseDot 1.6s infinite; }
    .cb-card__status.offline { color:rgba(255,255,255,0.45); }
    .cb-card__status.offline .sdot { background:rgba(255,255,255,0.3); animation:none; }
    .cb-card__verified { position:absolute; top:0.8rem; right:0.8rem; z-index:2; background:rgba(255,140,0,0.9); border-radius:50%; width:28px; height:28px; display:flex; align-items:center; justify-content:center; box-shadow:0 2px 10px rgba(255,140,0,0.5); }
    .cb-card__photo-info { position:absolute; bottom:0; left:0; right:0; z-index:2; padding:0.8rem 1rem 0.6rem; }
    .cb-card__name { font-size:1.15rem; font-weight:800; color:#fff; line-height:1.1; margin-bottom:0.2rem; }
    .cb-card__age-city { font-size:0.76rem; color:rgba(255,255,255,0.55); display:flex; align-items:center; gap:0.5rem; }
    .cb-card__sep { color:rgba(255,140,0,0.4); font-size:0.6rem; }

    /* Body */
    .cb-card__body { padding:0.9rem 1rem 1rem; }
    .cb-card__tags { display:flex; flex-wrap:wrap; gap:0.4rem; margin-bottom:0.85rem; }
    .cb-card__tag { font-size:0.63rem; font-weight:600; letter-spacing:0.06em; text-transform:uppercase; color:rgba(255,140,0,0.8); background:rgba(255,140,0,0.08); border:1px solid rgba(255,140,0,0.18); border-radius:4px; padding:0.15rem 0.5rem; }
    .cb-card__tag.dk { color:rgba(255,255,255,0.5); background:rgba(255,255,255,0.04); border-color:rgba(255,255,255,0.08); }
    .cb-card__rate { display:flex; align-items:baseline; gap:0.3rem; margin-bottom:0.85rem; }
    .cb-card__rate-price { font-size:1.2rem; font-weight:800; background:linear-gradient(135deg,#ff8c00,#ffb347); -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text; }
    .cb-card__rate-per { font-size:0.72rem; color:rgba(255,255,255,0.4); }
    .cb-card__stats { display:flex; gap:1.2rem; margin-bottom:1rem; }
    .cb-card__stat { display:flex; flex-direction:column; }
    .cb-card__stat-val { font-size:0.82rem; font-weight:700; color:#fff; }
    .cb-card__stat-key { font-size:0.62rem; color:rgba(255,255,255,0.35); text-transform:uppercase; letter-spacing:0.07em; }

    /* CTA */
    .cb-card__cta { display:flex; gap:0.5rem; }
    .cb-btn-primary { flex:1; padding:0.55rem 0.8rem; background:orange; border:2px solid orange; border-radius:8px; font-family:"Outfit",sans-serif; font-size:0.82rem; font-weight:700; color:#000; cursor:pointer; text-align:center; transition:color 0.3s ease, background-color 0.3s ease, box-shadow 0.3s ease, transform 0.2s ease; position:relative; overflow:hidden; display:flex; align-items:center; justify-content:center; gap:0.35rem; }
    .cb-btn-primary:hover { background:#000; border-color:orange; color:orange; box-shadow:0 0 18px rgba(255,165,0,0.55),0 4px 14px rgba(0,0,0,0.3); transform:translateY(-2px); }
    .cb-btn-primary:active { transform:scale(0.97); }
    .cb-btn-ghost { width:38px; height:38px; flex-shrink:0; background:rgba(255,255,255,0.05); border:1.5px solid rgba(255,255,255,0.12); border-radius:8px; display:flex; align-items:center; justify-content:center; cursor:pointer; color:rgba(255,255,255,0.5); transition:all 0.22s ease; }
    .cb-btn-ghost:hover { background:rgba(255,140,0,0.1); border-color:rgba(255,140,0,0.4); color:rgba(255,140,0,0.9); }

    /* PAGINATION */
    .cb-pagination { display:flex; justify-content:center; gap:0.4rem; padding:1rem 0 3rem; }
    .cb-page-btn { width:38px; height:38px; border-radius:8px; border:1.5px solid rgba(255,140,0,0.2); background:transparent; color:rgba(255,255,255,0.5); font-family:"Outfit",sans-serif; font-size:0.82rem; font-weight:600; cursor:pointer; transition:all 0.2s ease; display:flex; align-items:center; justify-content:center; text-decoration:none; }
    .cb-page-btn:hover { border-color:rgba(255,140,0,0.55); color:#fff; background:rgba(255,140,0,0.08); text-decoration:none; }
    .cb-page-btn.active { background:orange; border-color:orange; color:#000; }

    /* PROFILE MODAL */
    .cb-modal { display:none; position:fixed; inset:0; z-index:1070; background:rgba(0,0,0,0.9); backdrop-filter:blur(12px); align-items:center; justify-content:center; padding:1rem; }
    .cb-modal.open { display:flex; animation:mFadeIn 0.2s ease both; }
    @keyframes mFadeIn { from{opacity:0;} to{opacity:1;} }
    .cb-modal__inner { position:relative; width:100%; max-width:820px; max-height:90vh; background:#0d0d0d; border:1px solid rgba(255,140,0,0.22); border-radius:20px; overflow:hidden; overflow-y:auto; box-shadow:0 24px 80px rgba(0,0,0,0.8); animation:mSlideIn 0.32s cubic-bezier(0.34,1.2,0.64,1) both; }
    @keyframes mSlideIn { from{opacity:0;transform:translateY(30px) scale(0.96);} to{opacity:1;transform:none;} }
    .cb-modal__close { position:absolute; top:1rem; right:1rem; z-index:10; width:36px; height:36px; background:rgba(0,0,0,0.7); border:1px solid rgba(255,255,255,0.15); border-radius:50%; display:flex; align-items:center; justify-content:center; cursor:pointer; color:#fff; transition:all 0.2s; }
    .cb-modal__close:hover { background:rgba(255,140,0,0.2); border-color:rgba(255,140,0,0.5); }
    .cb-modal__hero { position:relative; height:320px; overflow:hidden; background:linear-gradient(135deg,#1a0f00,#2d1a00,#0d0d0d); }
    .cb-modal__hero img { width:100%; height:100%; object-fit:cover; object-position:top; }
    .cb-modal__hero-overlay { position:absolute; inset:0; background:linear-gradient(180deg,transparent 30%,rgba(0,0,0,0.95) 100%); }
    .cb-modal__hero-info { position:absolute; bottom:1.2rem; left:1.5rem; right:1.5rem; }
    .cb-modal__name { font-size:1.8rem; font-weight:900; color:#fff; margin-bottom:0.25rem; }
    .cb-modal__sub { font-size:0.82rem; color:rgba(255,255,255,0.55); display:flex; gap:0.75rem; flex-wrap:wrap; }
    .cb-modal__body { padding:1.5rem; }
    .cb-modal__section-title { font-size:0.68rem; font-weight:700; letter-spacing:0.1em; text-transform:uppercase; color:rgba(255,140,0,0.75); margin-bottom:0.75rem; margin-top:1.2rem; }
    .cb-modal__section-title:first-child { margin-top:0; }
    .cb-modal__about { font-size:0.88rem; color:rgba(255,255,255,0.62); line-height:1.8; }
    .cb-modal__details { display:grid; grid-template-columns:repeat(auto-fill,minmax(130px,1fr)); gap:0.8rem; }
    .cb-modal__detail { background:rgba(255,140,0,0.05); border:1px solid rgba(255,140,0,0.1); border-radius:10px; padding:0.7rem 0.9rem; }
    .cb-modal__detail-key { font-size:0.62rem; color:rgba(255,255,255,0.35); text-transform:uppercase; letter-spacing:0.08em; margin-bottom:0.2rem; }
    .cb-modal__detail-val { font-size:0.9rem; font-weight:700; color:#fff; }
    .cb-modal__tags { display:flex; flex-wrap:wrap; gap:0.5rem; }
    .cb-modal__cta { display:grid; grid-template-columns:1fr 1fr; gap:0.75rem; margin-top:1.5rem; }
    .cb-modal__btn { padding:0.75rem; border-radius:10px; font-family:"Outfit",sans-serif; font-size:0.9rem; font-weight:700; cursor:pointer; text-align:center; transition:all 0.25s ease; border:2px solid orange; }
    .cb-modal__btn.primary { background:orange; color:#000; }
    .cb-modal__btn.primary:hover { background:#000; color:orange; }
    .cb-modal__btn.ghost { background:transparent; color:rgba(255,140,0,0.9); }
    .cb-modal__btn.ghost:hover { background:rgba(255,140,0,0.1); color:#fff; }

    /* AUTH MODAL */
    .auth-input { background-color:#1a1a1a; border:1px solid #444; color:white; padding:12px; border-radius:8px; width:100%; }
    .auth-input:focus { background-color:#1a1a1a; border-color:orange; color:white; box-shadow:0 0 0 0.25rem rgba(255,165,0,0.25); outline:none; }
    .auth-btn { background-color:orange; color:black; font-weight:bold; padding:12px; border-radius:8px; border:1px solid orange; transition:0.3s; text-transform:uppercase; letter-spacing:1px; width:100%; }
    .auth-btn:hover { background-color:#e69500; }
    #authTabsCB .nav-link.active { background-color:orange !important; color:black !important; }

    /* FOOTER */
    .nr-footer { background:linear-gradient(160deg,#0d0d0d 0%,#1a0f00 50%,#0d0d0d 100%); color:rgba(255,255,255,0.78); border-top:2px solid rgba(255,140,0,0.6); box-shadow:inset 0 2px 30px rgba(255,140,0,0.06); }
    .nr-footer__brand,.nr-footer__title{color:#fff;}
    .nr-footer a { color:rgba(255,140,0,0.92); text-decoration:none; display:inline-block; position:relative; padding-bottom:3px; transition:color 0.3s ease; }
    .nr-footer a::after { content:""; position:absolute; left:0; bottom:0; width:100%; height:1.5px; background:linear-gradient(90deg,rgba(255,255,255,0) 0%,rgba(255,255,255,0.9) 50%,rgba(255,255,255,0) 100%); border-radius:2px; transform:scaleX(0); transform-origin:center; transition:transform 0.35s cubic-bezier(0.4,0,0.2,1); }
    .nr-footer a:hover,.nr-footer a:focus{color:#fff;text-decoration:none;}
    .nr-footer a:hover::after,.nr-footer a:focus::after{transform:scaleX(1);}
    .nr-footer__logo-text { font-size:1.6rem; font-weight:800; letter-spacing:-0.5px; line-height:1; background:linear-gradient(135deg,#ff8c00,#ffb347); -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text; display:inline-block; }
    hr.border-light-subtle{border-color:rgba(255,255,255,0.1) !important;}

    @keyframes fadeInUp { from{opacity:0;transform:translateY(28px);} to{opacity:1;transform:translateY(0);} }
    .fi1{animation:fadeInUp 0.5s ease 0s both;}
    .fi2{animation:fadeInUp 0.5s ease 0.08s both;}
    .fi3{animation:fadeInUp 0.5s ease 0.16s both;}
    .fi4{animation:fadeInUp 0.5s ease 0.24s both;}
    .fi5{animation:fadeInUp 0.5s ease 0.32s both;}
    .fi6{animation:fadeInUp 0.5s ease 0.4s both;}

    /* Avatar placeholder */
    .cb-avatar-ph { position:absolute; inset:0; display:flex; align-items:center; justify-content:center; }
    .cb-avatar-circle { width:80px; height:80px; border-radius:50%; background:rgba(255,140,0,0.15); border:2px solid rgba(255,140,0,0.25); display:flex; align-items:center; justify-content:center; }

    /* NR Listing Card grid container */
    .nr-card-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(220px,1fr)); gap:1.4rem; padding-bottom:1rem; }

    /* btn-primary orange override for nr-listing-card */
    .nr-listing-card .btn-primary,
    .nr-listing-card .btn-primary:visited {
      background-color: #ff8c00 !important;
      border-color: #ff8c00 !important;
      color: #000 !important;
      font-weight: 700 !important;
      transition: all 0.3s ease !important;
    }
    .nr-listing-card .btn-primary:hover,
    .nr-listing-card .btn-primary:focus {
      background-color: #000 !important;
      border-color: #ff8c00 !important;
      color: #ff8c00 !important;
      box-shadow: 0 0 18px rgba(255,140,0,0.5) !important;
    }
    /* Dark-mode text overrides for nr-listing-card */
    .nr-listing-card__title a { color: #ff8c00 !important; }
    .nr-listing-card__eyebrow { color: rgba(255,140,0,0.8) !important; }
    .nr-listing-card__value,
    .nr-listing-card__value-text,
    .nr-listing-card__value-icon { color: rgba(255,255,255,0.75) !important; }
    .nr-listing-card {
      background: linear-gradient(180deg,#1a0f00,#111) !important;
      border: 1px solid rgba(255,140,0,0.35) !important;
      box-shadow: 0 0 10px rgba(255,140,0,0.18), 0 0.85rem 1.6rem rgba(0,0,0,0.4) !important;
    }
    .nr-listing-card:hover {
      border-color: rgba(255,140,0,0.75) !important;
      box-shadow: 0 0 20px rgba(255,140,0,0.5), 0 0.85rem 1.6rem rgba(0,0,0,0.5) !important;
    }
    .nr-listing-card__ribbon { background: #ff8c00 !important; color: #000 !important; }
    /* LIGHT THEME OVERRIDES */
    [data-bs-theme="light"] body { background:#fdfdfd; color:#111; }
    [data-bs-theme="light"] .cb-page-header { background:linear-gradient(180deg,rgba(255,140,0,0.05) 0%,transparent 100%); border-bottom-color:rgba(0,0,0,0.05); }
    [data-bs-theme="light"] .cb-page-desc { color:rgba(0,0,0,0.65); }
    [data-bs-theme="light"] .cb-filter-bar { background:rgba(0,0,0,0.02); border-bottom-color:rgba(0,0,0,0.05); }
    [data-bs-theme="light"] .cb-filter-select { background:#fff; color:#000; border-color:rgba(255,140,0,0.5); }
    [data-bs-theme="light"] .cb-filter-select option { background:#fff; color:#000; }
    [data-bs-theme="light"] .cb-card { background:#fff; box-shadow:0 4px 15px rgba(0,0,0,0.05); border-color:rgba(0,0,0,0.08); }
    [data-bs-theme="light"] .cb-card:hover { box-shadow:0 12px 30px rgba(0,0,0,0.1); border-color:rgba(255,140,0,0.3); }
    [data-bs-theme="light"] .cb-card__photo-overlay { background:linear-gradient(180deg,transparent 40%,rgba(0,0,0,0.6) 100%); }
    [data-bs-theme="light"] .cb-card__name { color:#fff; }
    [data-bs-theme="light"] .cb-card__age-city { color:rgba(255,255,255,0.9); }
    [data-bs-theme="light"] .cb-card__stat-val { color:#000; }
    [data-bs-theme="light"] .cb-card__stat-key { color:rgba(0,0,0,0.5); }
    [data-bs-theme="light"] .cb-card__rate-per { color:rgba(0,0,0,0.5); }
    [data-bs-theme="light"] .cb-card__tag.dk { color:rgba(0,0,0,0.6); background:rgba(0,0,0,0.04); border-color:rgba(0,0,0,0.08); }
    [data-bs-theme="light"] .cb-modal__inner { background:#fdfdfd; border-color:rgba(255,140,0,0.3); }
    [data-bs-theme="light"] .cb-modal__hero { background:linear-gradient(135deg,#ffefe0,#ffe0c2,#fdfdfd); }
    [data-bs-theme="light"] .cb-modal__hero-overlay { background:linear-gradient(180deg,transparent 30%,rgba(0,0,0,0.6) 100%); }
    [data-bs-theme="light"] .cb-modal__name { color:#fff; }
    [data-bs-theme="light"] .cb-modal__sub { color:rgba(255,255,255,0.9); }
    [data-bs-theme="light"] .cb-modal__about { color:rgba(0,0,0,0.7); }
    [data-bs-theme="light"] .cb-modal__detail { background:rgba(255,140,0,0.08); border-color:rgba(255,140,0,0.15); }
    [data-bs-theme="light"] .cb-modal__detail-key { color:rgba(0,0,0,0.5); }
    [data-bs-theme="light"] .cb-modal__detail-val { color:#000; }
    [data-bs-theme="light"] .cb-page-btn { background:#fff; color:rgba(0,0,0,0.6); border-color:rgba(0,0,0,0.1); }
    [data-bs-theme="light"] .cb-page-btn:hover { background:rgba(255,140,0,0.1); color:#000; border-color:rgba(255,140,0,0.3); }
    [data-bs-theme="light"] .cb-page-btn.active { background:orange; color:#000; border-color:orange; }
    [data-bs-theme="light"] .cb-btn-ghost { color:rgba(0,0,0,0.5); border-color:rgba(0,0,0,0.1); background:#fdfdfd; }
    [data-bs-theme="light"] .cb-btn-ghost:hover { color:rgba(255,140,0,0.9); border-color:rgba(255,140,0,0.4); background:rgba(255,140,0,0.1); }
    [data-bs-theme="light"] .auth-input { background-color:#fff; border:1px solid #ccc; color:#000; }
    [data-bs-theme="light"] .auth-input:focus { background-color:#fff; border-color:orange; color:#000; }
  </style>
</head>
<body>

<x-navbar :hideSearch="true" />



<!-- BREADCRUMB -->
<div class="container mt-4 mb-2">
  <div style="font-size: 0.85rem; color: rgba(255,255,255,0.6); font-weight: 500;">
    <a href="/" style="color: #ff8c00; text-decoration: none;">Home</a> &raquo; Nairobi &raquo; <span style="color: #fff;">{{ ucwords($searchLocation) }} Escorts</span>
  </div>
</div>

<!-- PAGE HEADER -->
<div class="cb-page-header" style="padding-top: 2rem;">
  <div class="container">
    <h1 class="cb-page-title" style="font-size: clamp(1.8rem,3vw,2.5rem);">Hook up with <span>{{ ucwords($searchLocation) }} Escorts</span></h1>
    <p class="cb-page-desc mb-2">Welcome to {{ ucwords($searchLocation) }} in Nairobi, Kenya escorts and call girls page.</p>
    <p class="cb-page-desc mb-2">Are you an escort in {{ ucwords($searchLocation) }} in Nairobi, Kenya? Create your escort profile today and get listed.</p>
    <p class="cb-page-desc" style="color: rgba(255,140,0,0.8); font-weight: 500;">VIP Listing Guarantees you a spot in {{ ucwords($searchLocation) }} in Nairobi, Kenya listing page and A VIP Tag on your profile for Best Visibility MAXIMUM EXPOSURE as an escort in {{ ucwords($searchLocation) }} in Nairobi, Kenya.</p>
  </div>
</div>

<!-- FILTER BAR -->
<div class="cb-filter-bar">
  <div class="container">
    <form method="GET" action="{{ route('location.show', $searchLocation) }}" id="locationFilterForm">
      <div class="cb-filters">
        <span style="font-size: 0.85rem; color: rgba(255,255,255,0.6); font-weight: 600; text-transform: uppercase; flex-shrink:0;">Filter By</span>

        <select name="gender" class="cb-filter-select" aria-label="Select Gender" onchange="document.getElementById('locationFilterForm').submit()">
          <option value="">Select Gender</option>
          <option value="Female" {{ ($gender ?? '') === 'Female' ? 'selected' : '' }}>Female</option>
          <option value="Male"   {{ ($gender ?? '') === 'Male'   ? 'selected' : '' }}>Male</option>
          <option value="Other"  {{ ($gender ?? '') === 'Other'  ? 'selected' : '' }}>Other</option>
        </select>

        <select name="orientation" class="cb-filter-select" aria-label="Select Sexual Orientation" onchange="document.getElementById('locationFilterForm').submit()">
          <option value="">Select Sexual Orientation</option>
          <option value="Straight"  {{ ($orientation ?? '') === 'Straight'  ? 'selected' : '' }}>Straight</option>
          <option value="Bisexual"  {{ ($orientation ?? '') === 'Bisexual'  ? 'selected' : '' }}>Bisexual</option>
          <option value="Gay"       {{ ($orientation ?? '') === 'Gay'       ? 'selected' : '' }}>Gay</option>
          <option value="Lesbian"   {{ ($orientation ?? '') === 'Lesbian'   ? 'selected' : '' }}>Lesbian</option>
        </select>

        <div class="ms-auto">
          <select name="sort" class="cb-filter-select" aria-label="Sort by" onchange="document.getElementById('locationFilterForm').submit()">
            <option value="featured" {{ ($sort ?? 'featured') === 'featured' ? 'selected' : '' }}>Sort: Featured</option>
            <option value="newest"   {{ ($sort ?? '') === 'newest'   ? 'selected' : '' }}>Sort: Newest</option>
            <option value="oldest"   {{ ($sort ?? '') === 'oldest'   ? 'selected' : '' }}>Sort: Oldest</option>
            <option value="name_asc" {{ ($sort ?? '') === 'name_asc' ? 'selected' : '' }}>Sort: Name A–Z</option>
          </select>
        </div>
      </div>
    </form>
  </div>
</div>

<!<!-- GRID -->
<main class="container">

  @if($users->isNotEmpty())
  <div class="mb-5">
    <div class="nr-card-grid">
      @foreach($users as $user)
        @include('partials.user-card', ['user' => $user])
      @endforeach
    </div>
  </div>
  @else
    <div class="text-center py-5">
      <div style="max-width: 540px; margin: 0 auto; background: linear-gradient(145deg, rgba(26,15,0,0.8), rgba(13,13,13,0.9)); border: 1px solid rgba(255, 140, 0, 0.25); border-radius: 20px; padding: 3.5rem 2rem; box-shadow: 0 15px 40px rgba(0,0,0,0.6), inset 0 0 0 1px rgba(255,255,255,0.05);">
        <div style="width: 72px; height: 72px; background: rgba(255, 140, 0, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; border: 1px solid rgba(255, 140, 0, 0.2);">
          <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#ff8c00" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
            <circle cx="8.5" cy="7" r="4"></circle>
            <line x1="20" y1="8" x2="20" y2="14"></line>
            <line x1="23" y1="11" x2="17" y2="11"></line>
          </svg>
        </div>
        <h3 style="font-size: 1.6rem; font-weight: 800; color: #fff; margin-bottom: 0.75rem;">Be the first in {{ ucwords($searchLocation) }}!</h3>
        <p style="color: rgba(255, 255, 255, 0.6); font-size: 0.95rem; margin-bottom: 2rem; line-height: 1.6;">
          There are currently no verified profiles in this location. Create your escort profile today and instantly claim exclusive visibility.
        </p>
        <a href="#" class="btn-orange text-decoration-none px-4 py-3" style="border-radius: 12px; font-weight: 700; display: inline-flex; align-items: center; gap: 0.6rem; font-size: 1.05rem; box-shadow: 0 8px 25px rgba(255, 140, 0, 0.25); transition: transform 0.3s ease, box-shadow 0.3s ease;" data-bs-toggle="modal" data-bs-target="#authModal" data-auth-tab="register" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 12px 30px rgba(255, 140, 0, 0.35)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 8px 25px rgba(255, 140, 0, 0.25)';">
          <span>Register Now</span>
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
        </a>
      </div>
    </div>
  @endif

</main>

  <!-- PAGINATION -->
  @if($users->hasPages())
  <div class="cb-pagination">

    {{-- Previous --}}
    @if($users->onFirstPage())
      <span class="cb-page-btn" style="opacity:0.3; cursor:default;">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M15 18l-6-6 6-6"/></svg>
      </span>
    @else
      <a class="cb-page-btn" href="{{ $users->previousPageUrl() }}">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M15 18l-6-6 6-6"/></svg>
      </a>
    @endif

    {{-- Page numbers --}}
    @foreach($users->getUrlRange(1, $users->lastPage()) as $page => $url)
      <a class="cb-page-btn {{ $page === $users->currentPage() ? 'active' : '' }}"
         href="{{ $url }}">{{ $page }}</a>
    @endforeach

    {{-- Next --}}
    @if($users->hasMorePages())
      <a class="cb-page-btn" href="{{ $users->nextPageUrl() }}">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M9 18l6-6-6-6"/></svg>
      </a>
    @else
      <span class="cb-page-btn" style="opacity:0.3; cursor:default;">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M9 18l6-6-6-6"/></svg>
      </span>
    @endif

  </div>
  @endif
</main>



<!-- AUTH MODAL -->
<div class="modal fade" id="authModal" tabindex="-1" aria-labelledby="authModalLabelCB" aria-hidden="true" style="backdrop-filter:blur(5px);">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" style="background-color:#000;border:1px solid #333;border-radius:12px;box-shadow:0 10px 30px rgba(0,0,0,0.5);">
      <div class="modal-header border-bottom-0 pb-0 mt-2 mx-2">
        <div class="w-100 d-flex justify-content-between align-items-center">
          <h5 class="modal-title fw-bold fs-3" id="authModalLabelCB" style="color:orange;text-transform:uppercase;letter-spacing:1px;">Kenyan Baddies Club</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
      </div>
      <div class="modal-body pt-0 px-4 pb-4">
        <ul class="nav nav-pills nav-justified mb-4 mt-4" id="authTabsCB" role="tablist">
          <li class="nav-item" role="presentation"><button class="nav-link active rounded-pill fw-bold" id="tab-login-cb" data-bs-toggle="pill" data-bs-target="#content-login-cb" type="button" role="tab" style="color:white;border:1px solid orange;">Login</button></li>
          <li class="nav-item" role="presentation"><button class="nav-link rounded-pill fw-bold ms-2" id="tab-register-cb" data-bs-toggle="pill" data-bs-target="#content-register-cb" type="button" role="tab" style="color:white;border:1px solid orange;">Sign Up</button></li>
        </ul>
        <div class="tab-content">
          <div class="tab-pane fade show active" id="content-login-cb" role="tabpanel">
            <div class="text-center mb-4"><h4 class="text-light fw-bold">Member Log In</h4><p class="text-secondary small fw-bold">Access your Baddies Club account</p></div>
            <form method="POST" action="{{ route('login') }}">
              @csrf
              <div class="mb-3"><label class="form-label text-light small fw-bold">Email</label><input type="email" name="email" class="auth-input" required placeholder="your@email.com" value="{{ old('email') }}">@error('email')<div class="text-danger small mt-1">{{ $message }}</div>@enderror</div>
              <div class="mb-4"><label class="form-label text-light small fw-bold">Password</label><input type="password" name="password" class="auth-input" required placeholder="••••••••">@error('password')<div class="text-danger small mt-1">{{ $message }}</div>@enderror</div>
              <button type="submit" class="auth-btn">Log In</button>
            </form>
            <div class="text-center mt-3"><a href="#" class="text-decoration-none small fw-bold" style="color:orange;" onclick="document.getElementById('tab-register-cb').click();return false;">No account? Sign Up</a></div>
          </div>
          <div class="tab-pane fade" id="content-register-cb" role="tabpanel">
            <div class="text-center mb-4"><h4 class="text-light fw-bold">Create Account</h4><p class="text-secondary small fw-bold">Join Baddies Club for free</p></div>
            <form method="POST" action="{{ route('register') }}">
              @csrf
              <div class="mb-3"><label class="form-label text-light small fw-bold">Full Name</label><input type="text" name="name" class="auth-input" required placeholder="Your name" value="{{ old('name') }}">@error('name')<div class="text-danger small mt-1">{{ $message }}</div>@enderror</div>
              <div class="mb-3"><label class="form-label text-light small fw-bold">Email</label><input type="email" name="email" class="auth-input" required placeholder="your@email.com" value="{{ old('email') }}">@error('email')<div class="text-danger small mt-1">{{ $message }}</div>@enderror</div>
              <div class="mb-3"><label class="form-label text-light small fw-bold">Password</label><input type="password" name="password" class="auth-input" required placeholder="••••••••">@error('password')<div class="text-danger small mt-1">{{ $message }}</div>@enderror</div>
              <div class="mb-4"><label class="form-label text-light small fw-bold">Confirm Password</label><input type="password" name="password_confirmation" class="auth-input" required placeholder="••••••••"></div>
              <button type="submit" class="auth-btn">Create Account</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<x-footer />

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
function toggleWishlist(btn) {
  var svg=btn.querySelector('svg'), saved=btn.dataset.saved;
  if (saved) { svg.style.fill='none'; svg.style.stroke='currentColor'; delete btn.dataset.saved; }
  else { svg.style.fill='rgba(255,140,0,0.9)'; svg.style.stroke='rgba(255,140,0,0.9)'; btn.dataset.saved='1'; }
}
function setFilter(el) { document.querySelectorAll('.cb-filter-btn').forEach(function(b){b.classList.remove('active');}); el.classList.add('active'); }
var authEl = document.getElementById('authModal');
if (authEl) { authEl.addEventListener('show.bs.modal', function(event) { var tab=event.relatedTarget?event.relatedTarget.getAttribute('data-auth-tab'):null; var el=document.getElementById(tab==='register'?'tab-register-cb':'tab-login-cb'); if(el) new bootstrap.Tab(el).show(); }); }
</script>

<!-- -- AUTH MODAL -- -->
<x-auth-modal />
</body>
</html>
