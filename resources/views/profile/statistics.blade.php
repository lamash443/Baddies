<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Statistics - Baddies Club</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  <style>
    *, *::before, *::after { box-sizing:border-box; }
    html, body { margin:0; padding:0; font-family:"Outfit",sans-serif; background:#0d0d0d; color:#fff; min-height:100vh; }
    
    /* DASHBOARD LAYOUT */
    .dashboard-header { padding:3rem 0 2rem; border-bottom:1px solid rgba(255,140,0,0.12); margin-bottom:2.5rem; }
    .dashboard-title { font-size:clamp(1.8rem,4vw,2.5rem); font-weight:900; letter-spacing:-0.02em; line-height:1.1; margin-bottom:0.5rem; }
    .dashboard-title span { background:linear-gradient(135deg,#ff8c00,#ffb347); -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text; }
    
    .dash-card {
      background:rgba(17,17,17,0.85); backdrop-filter:blur(15px);
      border:1px solid rgba(255,140,0,0.2); border-radius:18px; padding:2rem;
      box-shadow:0 8px 32px rgba(0,0,0,0.5); margin-bottom: 2rem;
    }
    
    .stat-card {
      background:linear-gradient(145deg, rgba(255,140,0,0.1) 0%, rgba(17,17,17,0.6) 100%);
      border:1px solid rgba(255,140,0,0.2);
      border-radius:12px;
      padding:1.5rem;
      transition:transform 0.3s ease, box-shadow 0.3s ease;
      display: flex;
      align-items: center;
      gap: 1.5rem;
      text-align: left;
    }
    .stat-card:hover {
      transform:translateY(-3px);
      box-shadow:0 8px 24px rgba(255,140,0,0.15);
    }
    .stat-icon {
      width: 52px; height: 52px; flex-shrink: 0;
      background: rgba(255,140,0,0.15);
      border-radius: 12px;
      display: flex; align-items: center; justify-content: center;
      color: orange;
      margin: 0;
    }
    .stat-value {
      font-size: 2.2rem;
      font-weight: 800;
      color: #fff;
      line-height: 1;
      margin-bottom: 0.2rem;
    }
    .stat-label {
      font-size: 0.85rem;
      color: rgba(255,255,255,0.6);
      text-transform: uppercase;
      letter-spacing: 0.05em;
      font-weight: 600;
      margin: 0;
    }

    .btn-orange {
      display: inline-flex; align-items: center; justify-content: center; gap: 0.45rem;
      background: transparent; border: 2px solid orange; color: orange;
      padding: 0.6rem 1.4rem; border-radius: 8px; font-size: 0.88rem; font-weight: 700;
      text-decoration: none; transition: all 0.3s ease;
    }
    .btn-orange:hover {
      background: orange; color: #000; box-shadow: 0 0 18px 4px rgba(255, 165, 0, 0.55);
    }
  </style>
</head>
<body>
  <x-navbar :hideSearch="true" />

  <div class="dashboard-header">
    <div class="container text-center">
      <h1 class="dashboard-title">Profile <span>Statistics</span></h1>
      <p style="color:rgba(255,255,255,0.6); max-width:600px; margin:0 auto;">
        Track the engagement on your public profile. See how many people are checking you out and trying to reach you.
      </p>
    </div>
  </div>

  <div class="container pb-5 mb-5">
    <div class="dash-card">
      <div class="row g-4">
        <!-- Views Stat -->
        <div class="col-12 col-md-6">
          <div class="stat-card">
            <div class="stat-icon">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
            </div>
            <div>
              <div class="stat-value">{{ number_format(auth()->user()->profile_views ?? 0) }}</div>
              <div class="stat-label">Profile Views</div>
            </div>
          </div>
        </div>
        
        <!-- Calls Stat -->
        <div class="col-12 col-md-6">
          <div class="stat-card">
            <div class="stat-icon">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
            </div>
            <div>
              <div class="stat-value">{{ number_format(auth()->user()->phone_calls ?? 0) }}</div>
              <div class="stat-label">Phone Calls</div>
            </div>
          </div>
        </div>
      </div>
      </div>
      
      <!-- Chart Section -->
      <div class="mt-5 pt-4 border-top border-secondary" style="border-color: rgba(255,255,255,0.1) !important;">
        <div class="d-flex justify-content-between align-items-center mb-4">
          <h3 class="fw-bold mb-0" style="font-size:1.5rem;">Activity Overview</h3>
          <select id="periodSelect" name="period" class="form-select form-select-sm bg-dark text-light border-secondary" style="width: auto; cursor:pointer;">
            <option value="today" {{ request('period') == 'today' ? 'selected' : '' }}>Today</option>
            <option value="7" {{ request('period') == '7' ? 'selected' : '' }}>Last 7 Days</option>
            <option value="30" {{ request('period', '30') == '30' ? 'selected' : '' }}>Last 30 Days</option>
            <option value="all" {{ request('period') == 'all' ? 'selected' : '' }}>All Time</option>
          </select>
        </div>
        
        <div style="position: relative; height:400px; width:100%;">
          <canvas id="statsChart"></canvas>
        </div>
      </div>
      
      <div class="text-center mt-5">
        <a href="{{ route('profile.edit') }}" class="btn-orange">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
          Back to Dashboard
        </a>
      </div>
    </div>
  </div>

  <x-footer />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    const ctx = document.getElementById('statsChart').getContext('2d');
    
    // Gradients
    const viewsGradient = ctx.createLinearGradient(0, 0, 0, 400);
    viewsGradient.addColorStop(0, 'rgba(255, 140, 0, 0.5)');
    viewsGradient.addColorStop(1, 'rgba(255, 140, 0, 0.0)');
    
    const callsGradient = ctx.createLinearGradient(0, 0, 0, 400);
    callsGradient.addColorStop(0, 'rgba(0, 200, 255, 0.5)');
    callsGradient.addColorStop(1, 'rgba(0, 200, 255, 0.0)');

    const statsChart = new Chart(ctx, {
      type: 'line',
      data: {
        labels: {!! json_encode($labels) !!},
        datasets: [
          {
            label: 'Profile Views',
            data: {!! json_encode($viewsData) !!},
            borderColor: '#ff8c00',
            backgroundColor: viewsGradient,
            borderWidth: 3,
            pointBackgroundColor: '#ff8c00',
            pointBorderColor: '#111',
            pointBorderWidth: 2,
            pointRadius: 4,
            pointHoverRadius: 6,
            fill: true,
            tension: 0.4
          },
          {
            label: 'Phone Calls',
            data: {!! json_encode($callsData) !!},
            borderColor: '#00c8ff',
            backgroundColor: callsGradient,
            borderWidth: 3,
            pointBackgroundColor: '#00c8ff',
            pointBorderColor: '#111',
            pointBorderWidth: 2,
            pointRadius: 4,
            pointHoverRadius: 6,
            fill: true,
            tension: 0.4
          }
        ]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        interaction: {
          mode: 'index',
          intersect: false,
        },
        plugins: {
          legend: {
            labels: { color: 'rgba(255, 255, 255, 0.8)', font: { family: 'Outfit', size: 14 } }
          },
          tooltip: {
            backgroundColor: 'rgba(17, 17, 17, 0.9)',
            titleColor: '#fff',
            bodyColor: 'rgba(255, 255, 255, 0.8)',
            borderColor: 'rgba(255, 140, 0, 0.3)',
            borderWidth: 1,
            padding: 12,
            displayColors: true,
            titleFont: { family: 'Outfit', size: 14, weight: 'bold' },
            bodyFont: { family: 'Outfit', size: 13 }
          }
        },
        scales: {
          x: {
            grid: { color: 'rgba(255, 255, 255, 0.05)', drawBorder: false },
            ticks: { color: 'rgba(255, 255, 255, 0.5)', font: { family: 'Outfit' } }
          },
          y: {
            grid: { color: 'rgba(255, 255, 255, 0.05)', drawBorder: false },
            ticks: { color: 'rgba(255, 255, 255, 0.5)', font: { family: 'Outfit' }, stepSize: 1, beginAtZero: true }
          }
        }
      }
    });

    document.getElementById('periodSelect').addEventListener('change', function() {
      const period = this.value;
      fetch(`{{ route('profile.statistics') }}?period=${period}`, {
        headers: {
          'X-Requested-With': 'XMLHttpRequest',
          'Accept': 'application/json'
        }
      })
      .then(res => res.json())
      .then(data => {
        statsChart.data.labels = data.labels;
        statsChart.data.datasets[0].data = data.viewsData;
        statsChart.data.datasets[1].data = data.callsData;
        statsChart.update();
      })
      .catch(console.error);
    });
  </script>
</body>
</html>
