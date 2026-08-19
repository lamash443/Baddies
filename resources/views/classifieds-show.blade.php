<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ $classified->title }} - Adult Classifieds - Baddies Club</title>
  <meta name="description" content="Adult Classifieds: {{ $classified->title }}">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  <style>
    *, *::before, *::after { box-sizing: border-box; }
    html, body { margin:0; padding:0; font-family:"Outfit",sans-serif; background:#0d0d0d; color:#fff; min-height:100vh; }
    
    /* HEADER / HERO */
    .hero {
      position: relative;
      padding: 6rem 0 3rem;
      background: linear-gradient(180deg, rgba(255,140,0,0.05) 0%, #0d0d0d 100%);
      border-bottom: 1px solid rgba(255,140,0,0.1);
      margin-bottom: 3rem;
    }
    
    .classified-container {
      max-width: 900px;
      margin: 0 auto;
      padding: 2rem;
      background: rgba(17,17,17,0.7);
      border: 1px solid rgba(255,140,0,0.2);
      border-radius: 16px;
      box-shadow: 0 10px 30px rgba(0,0,0,0.5);
    }
    
    .classified-image {
      width: 100%;
      max-height: 500px;
      object-fit: cover;
      border-radius: 12px;
      margin-bottom: 2rem;
      border: 1px solid rgba(255,140,0,0.3);
    }
    
    .classified-title {
      font-size: 2.5rem;
      font-weight: 800;
      color: #fff;
      margin-bottom: 1rem;
      line-height: 1.2;
    }
    
    .classified-meta {
      display: flex;
      flex-wrap: wrap;
      gap: 1.5rem;
      margin-bottom: 2rem;
      padding-bottom: 1.5rem;
      border-bottom: 1px solid rgba(255,255,255,0.1);
    }
    
    .meta-item {
      display: flex;
      align-items: center;
      gap: 0.5rem;
      color: rgba(255,255,255,0.7);
      font-size: 1rem;
    }
    
    .classified-description {
      font-size: 1.1rem;
      line-height: 1.7;
      color: rgba(255,255,255,0.85);
      margin-bottom: 3rem;
      white-space: pre-wrap;
    }
    
    .contact-box {
      background: linear-gradient(145deg, rgba(255,140,0,0.1) 0%, rgba(255,140,0,0.02) 100%);
      border: 1px solid rgba(255,140,0,0.3);
      border-radius: 12px;
      padding: 2rem;
      text-align: center;
    }
    
    .contact-box h3 {
      font-size: 1.5rem;
      font-weight: 700;
      color: #fff;
      margin-bottom: 1.5rem;
    }
    
    .btn-contact {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 0.5rem;
      background: orange;
      color: #000;
      font-weight: 700;
      font-size: 1.1rem;
      padding: 1rem 2rem;
      border-radius: 8px;
      text-decoration: none;
      transition: all 0.3s ease;
      border: 2px solid orange;
    }
    
    .btn-contact:hover {
      background: transparent;
      color: orange;
      box-shadow: 0 0 15px rgba(255,165,0,0.4);
    }
    
  </style>
</head>
<body>
  <x-navbar :hideSearch="true" />

  <section class="hero">
    <div class="container text-center">
      <a href="{{ route('classifieds') }}" class="btn btn-outline-warning mb-3" style="border-radius:8px;">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:5px;"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
        Back to Classifieds
      </a>
    </div>
  </section>

  <div class="container mb-5">
    <div class="classified-container">
      @if($classified->image_path)
      <img src="{{ asset('storage/' . $classified->image_path) }}" alt="{{ $classified->title }}" class="classified-image">
      @endif
      
      <div class="d-flex align-items-center gap-2 mb-3">
        <span class="badge bg-warning text-dark px-3 py-2 text-uppercase" style="font-size:0.9rem; font-weight:700;">{{ $classified->category }}</span>
      </div>
      
      <h1 class="classified-title">{{ $classified->title }}</h1>
      
      <div class="classified-meta">
        <div class="meta-item">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="orange" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
          {{ $classified->city ?? 'Location Not Specified' }}
        </div>
        <div class="meta-item">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="orange" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
          Posted on {{ $classified->created_at->format('M d, Y') }}
        </div>
      </div>
      
      <div class="classified-description">
{{ $classified->description }}
      </div>
      
      @if($classified->phone || $classified->contact_name)
      <div class="contact-box">
        <h3>Contact Details</h3>
        @if($classified->contact_name)
        <p class="mb-3" style="font-size:1.2rem; color:rgba(255,255,255,0.9);">Ask for <strong>{{ $classified->contact_name }}</strong></p>
        @endif
        
        @if($classified->phone)
        <a href="tel:{{ $classified->phone }}" class="btn-contact">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
          {{ $classified->phone }}
        </a>
        @endif
      </div>
      @endif
      
    </div>
  </div>

  <x-footer />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
