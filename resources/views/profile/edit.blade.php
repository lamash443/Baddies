<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Profile - Baddies Club</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  <style>
    *, *::before, *::after { box-sizing:border-box; }
    html, body { margin:0; padding:0; font-family:"Outfit",sans-serif; background:#0d0d0d; color:#fff; min-height:100vh; }
    
    /* DASHBOARD LAYOUT */
    .dashboard-header { padding:3rem 0 2rem; border-bottom:1px solid rgba(255,140,0,0.12); margin-bottom:2.5rem; }
    .dashboard-title { font-size:clamp(1.8rem,4vw,2.5rem); font-weight:900; letter-spacing:-0.02em; line-height:1.1; margin-bottom:0.5rem; }
    .dashboard-title span { background:linear-gradient(135deg,#ff8c00,#ffb347); -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text; }
    .dashboard-sub { font-size:0.9rem; color:rgba(255,255,255,0.5); font-weight:400; }
    
    .dash-card {
      background:rgba(17,17,17,0.85); backdrop-filter:blur(15px);
      border:1px solid rgba(255,140,0,0.2); border-radius:18px; padding:2rem;
      box-shadow:0 8px 32px rgba(0,0,0,0.5); margin-bottom: 2rem;
    }
    .dash-card-title { font-size:1.2rem; font-weight:700; color:#fff; margin-bottom:0.5rem; }
    .dash-card-text { font-size:0.9rem; color:rgba(255,255,255,0.6); margin-bottom:1.5rem; line-height:1.5; }

    /* FORMS */
    .form-label { font-size: 0.9rem; font-weight: 500; color: rgba(255,255,255,0.8); margin-bottom: 0.4rem; }
    .form-control, .form-select {
      background-color: rgba(0,0,0,0.3); border: 1px solid rgba(255,140,0,0.2);
      color: #fff; padding: 0.75rem 1rem; border-radius: 8px; font-size: 0.95rem;
    }
    .form-control:focus, .form-select:focus {
      background-color: rgba(0,0,0,0.5); border-color: orange; box-shadow: 0 0 0 3px rgba(255,165,0,0.15); color: #fff;
    }
    .form-control option, .form-select option {
      background-color: #111;
      color: #fff;
    }
    .text-danger { color: #ff4d4d !important; font-size: 0.85rem; margin-top: 0.4rem; }

    /* â”€â”€ UNIFIED BUTTON STYLE (matches "View Statistics") â”€â”€ */
    /* Base style: outlined orange, transparent bg */
    .btn-profile-action,
    .btn-orange,
    .btn-verify-now,
    .btn-settings-fund,
    .btn-save-settings,
    .btn-outline-warning,
    .btn.btn-orange,
    .btn.btn-outline-warning,
    .btn.btn-outline-secondary {
      display: inline-flex !important;
      align-items: center !important;
      justify-content: center !important;
      gap: 0.45rem !important;
      background: transparent !important;
      border: 2px solid orange !important;
      color: orange !important;
      padding: 0.6rem 1.4rem !important;
      border-radius: 8px !important;
      font-size: 0.88rem !important;
      font-weight: 700 !important;
      font-family: "Outfit", sans-serif !important;
      text-decoration: none !important;
      transition: all 0.3s ease !important;
      cursor: pointer;
      letter-spacing: 0.02em;
      box-shadow: none !important;
      white-space: nowrap;
    }

    /* Hover: fill + glow */
    .btn-profile-action:hover,
    .btn-orange:hover,
    .btn-verify-now:hover,
    .btn-settings-fund:hover,
    .btn-save-settings:hover,
    .btn-outline-warning:hover,
    .btn.btn-orange:hover,
    .btn.btn-outline-warning:hover,
    .btn.btn-outline-secondary:hover {
      background: orange !important;
      color: #000 !important;
      border-color: orange !important;
      box-shadow: 0 0 18px 4px rgba(255, 165, 0, 0.55), 0 0 35px rgba(255, 165, 0, 0.25) !important;
      transform: translateY(-1px) !important;
    }

    /* Active / pressed */
    .btn-profile-action:active,
    .btn-orange:active,
    .btn-verify-now:active,
    .btn-settings-fund:active,
    .btn-save-settings:active,
    .btn.btn-orange:active,
    .btn.btn-outline-warning:active {
      transform: translateY(0) !important;
      box-shadow: 0 0 10px 2px rgba(255,165,0,0.4) !important;
    }

    /* Danger button keeps its own colour but same shape */
    .btn-danger-custom {
      display: inline-flex; align-items: center; justify-content: center; gap: 0.4rem;
      background: transparent; border: 2px solid #dc3545; color: #dc3545;
      padding: 0.6rem 1.2rem; border-radius: 8px; font-size: 0.88rem; font-weight: 700;
      font-family: "Outfit", sans-serif; text-decoration: none; transition: all 0.3s ease;
    }
    .btn-danger-custom:hover {
      background: #dc3545; color: #fff;
      box-shadow: 0 0 18px 4px rgba(220,53,69,0.5);
      transform: translateY(-1px);
    }

    /* LIGHT THEME OVERRIDES */
    [data-bs-theme="light"] body {
      background: #f4f5f8 !important;
      color: #111111 !important;
    }
    [data-bs-theme="light"] .dashboard-header {
      border-color: rgba(0,0,0,0.08) !important;
    }
    [data-bs-theme="light"] .dashboard-title {
      color: #111111 !important;
    }
    [data-bs-theme="light"] .dashboard-sub {
      color: rgba(0,0,0,0.6) !important;
    }
    [data-bs-theme="light"] .dash-card {
      background: #ffffff !important;
      border: 1px solid rgba(0,0,0,0.08) !important;
      box-shadow: 0 4px 20px rgba(0,0,0,0.04) !important;
      color: #111111 !important;
    }
    [data-bs-theme="light"] .dash-card-title {
      color: #111111 !important;
    }
    [data-bs-theme="light"] .dash-card-text {
      color: rgba(0,0,0,0.65) !important;
    }

    /* Text utility overrides in light mode */
    [data-bs-theme="light"] .text-white,
    [data-bs-theme="light"] .text-light,
    [data-bs-theme="light"] .text-white-50 {
      color: #111111 !important;
    }
    [data-bs-theme="light"] .text-secondary {
      color: #666666 !important;
    }

    /* Sidebar Navigation Card */
    [data-bs-theme="light"] .side-nav-card {
      background: #ffffff !important;
      border: 1px solid rgba(0,0,0,0.08) !important;
      box-shadow: 0 4px 20px rgba(0,0,0,0.04) !important;
    }
    [data-bs-theme="light"] .side-nav-title {
      color: rgba(0,0,0,0.45) !important;
      border-bottom-color: rgba(0,0,0,0.08) !important;
    }
    [data-bs-theme="light"] .side-nav-link {
      color: rgba(0,0,0,0.7) !important;
    }
    [data-bs-theme="light"] .side-nav-link:hover {
      background: rgba(255,140,0,0.08) !important;
      color: #ff8c00 !important;
    }
    [data-bs-theme="light"] .side-nav-link.active {
      background: rgba(255,140,0,0.12) !important;
      color: #ff8c00 !important;
    }

    /* Form Controls & Inputs */
    [data-bs-theme="light"] .form-label,
    [data-bs-theme="light"] .settings-field-label {
      color: #222222 !important;
    }
    [data-bs-theme="light"] .form-control,
    [data-bs-theme="light"] .form-select,
    [data-bs-theme="light"] .settings-input,
    [data-bs-theme="light"] .settings-select {
      background-color: #f9f9fb !important;
      border: 1px solid rgba(0,0,0,0.15) !important;
      color: #111111 !important;
    }
    [data-bs-theme="light"] .form-control:focus,
    [data-bs-theme="light"] .form-select:focus,
    [data-bs-theme="light"] .settings-input:focus,
    [data-bs-theme="light"] .settings-select:focus {
      background-color: #ffffff !important;
      border-color: orange !important;
      color: #111111 !important;
      box-shadow: 0 0 0 3px rgba(255,165,0,0.15) !important;
    }
    [data-bs-theme="light"] .form-control option,
    [data-bs-theme="light"] .form-select option,
    [data-bs-theme="light"] .settings-select option {
      background-color: #ffffff !important;
      color: #111111 !important;
    }
    [data-bs-theme="light"] .form-control::placeholder,
    [data-bs-theme="light"] .settings-input::placeholder {
      color: #888888 !important;
    }
    [data-bs-theme="light"] .form-control[readonly] {
      background-color: #eef0f3 !important;
      border-color: rgba(0,0,0,0.1) !important;
      color: #666666 !important;
    }

    /* Settings Tab */
    [data-bs-theme="light"] .settings-wallet-card,
    [data-bs-theme="light"] .settings-form-card,
    [data-bs-theme="light"] .settings-sessions-card {
      background: #ffffff !important;
      border: 1px solid rgba(0,0,0,0.08) !important;
      box-shadow: 0 4px 20px rgba(0,0,0,0.04) !important;
    }
    [data-bs-theme="light"] .settings-section-label {
      color: #111111 !important;
    }
    [data-bs-theme="light"] .settings-group-label {
      color: #e67e00 !important;
      border-bottom-color: rgba(0,0,0,0.08) !important;
    }
    [data-bs-theme="light"] .settings-select-current {
      color: #111111 !important;
    }
    [data-bs-theme="light"] .settings-balance-inner {
      background: rgba(255,140,0,0.06) !important;
      border-color: rgba(255,140,0,0.25) !important;
    }
    [data-bs-theme="light"] .settings-balance-amount,
    [data-bs-theme="light"] .settings-balance-num {
      color: #111111 !important;
    }
    [data-bs-theme="light"] .settings-balance-sub,
    [data-bs-theme="light"] .settings-help-text {
      color: rgba(0,0,0,0.65) !important;
    }
    [data-bs-theme="light"] .settings-save-footer {
      border-top-color: rgba(0,0,0,0.1) !important;
    }
    
    .profile-stats-divider {
      border-top: 1px solid rgba(255,255,255,0.1);
      border-bottom: 1px solid rgba(255,255,255,0.1);
    }
    .profile-stats-vsep {
      width: 1px;
      background: rgba(255,255,255,0.1);
    }

    [data-bs-theme="light"] .profile-stats-divider {
      border-top: 1px solid rgba(0,0,0,0.1) !important;
      border-bottom: 1px solid rgba(0,0,0,0.1) !important;
    }
    [data-bs-theme="light"] .profile-stats-vsep {
      background: rgba(0,0,0,0.1) !important;
    }

    /* MAIN CARD IMAGE BUTTON & BADGE STYLES */
    .btn-set-main-card {
      background: rgba(0, 0, 0, 0.85) !important;
      color: #ff8c00 !important;
      border: 1.5px solid #ff8c00 !important;
      font-size: 0.68rem !important;
      font-weight: 700 !important;
      padding: 0.35rem 0.65rem !important;
      border-radius: 4px !important;
      cursor: pointer !important;
      transition: all 0.25s ease-in-out !important;
      letter-spacing: 0.03em !important;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.5) !important;
      line-height: 1 !important;
      display: inline-flex !important;
      align-items: center !important;
      justify-content: center !important;
      text-transform: uppercase !important;
      white-space: nowrap !important;
    }
    .btn-set-main-card:hover {
      background: #ff8c00 !important;
      color: #000000 !important;
      border-color: #ff8c00 !important;
      box-shadow: 0 0 14px 2px rgba(255, 140, 0, 0.65) !important;
      transform: translateY(-1px) !important;
    }
    .btn-set-main-card:active {
      transform: translateY(0) !important;
    }
    .btn-main-card-badge {
      background: linear-gradient(135deg, #ff8c00, #ffb347) !important;
      color: #000000 !important;
      border: 1px solid #ff8c00 !important;
      font-size: 0.68rem !important;
      font-weight: 800 !important;
      padding: 0.35rem 0.65rem !important;
      border-radius: 4px !important;
      letter-spacing: 0.03em !important;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.6) !important;
      line-height: 1 !important;
      display: inline-flex !important;
      align-items: center !important;
      gap: 0.25rem !important;
      text-transform: uppercase !important;
      white-space: nowrap !important;
    }
    [data-bs-theme="light"] .settings-sessions-card .list-group {
      border-color: rgba(0,0,0,0.08) !important;
    }
    [data-bs-theme="light"] .settings-sessions-card .list-group-item {
      background: #f8f9fa !important;
      border-color: rgba(0,0,0,0.08) !important;
      color: #111111 !important;
    }

    /* Photos & Videos Sidebar Cards */
    [data-bs-theme="light"] .photos-sidebar-card,
    [data-bs-theme="light"] .videos-sidebar-card {
      background: #ffffff !important;
      border: 1px solid rgba(0,0,0,0.08) !important;
    }
    [data-bs-theme="light"] .photos-locked-title {
      color: #222222 !important;
    }
    [data-bs-theme="light"] .photos-locked-sub {
      color: #666666 !important;
    }
    [data-bs-theme="light"] .media-upload-drop {
      background: rgba(255,140,0,0.03) !important;
      border-color: rgba(255,140,0,0.25) !important;
    }
    [data-bs-theme="light"] .media-upload-drop span {
      color: #444444 !important;
    }

    /* Photo Management Overlay Modal */
    [data-bs-theme="light"] .photo-mgmt-panel {
      background: #ffffff !important;
      border: 1px solid rgba(0,0,0,0.12) !important;
      box-shadow: 0 20px 60px rgba(0,0,0,0.15) !important;
    }
    [data-bs-theme="light"] .photo-mgmt-header {
      border-bottom-color: rgba(0,0,0,0.08) !important;
    }
    [data-bs-theme="light"] .photo-mgmt-header-title {
      color: #111111 !important;
    }
    [data-bs-theme="light"] .photo-mgmt-header-sub {
      color: rgba(0,0,0,0.55) !important;
    }
    [data-bs-theme="light"] .photo-mgmt-close {
      background: rgba(0,0,0,0.05) !important;
      border-color: rgba(0,0,0,0.1) !important;
      color: rgba(0,0,0,0.55) !important;
    }
    [data-bs-theme="light"] .photo-mgmt-btn--upload {
      background: rgba(255,140,0,0.06) !important;
      border-color: rgba(255,140,0,0.25) !important;
    }
    [data-bs-theme="light"] .photo-mgmt-btn-label {
      color: #111111 !important;
    }
    [data-bs-theme="light"] .photo-mgmt-btn-desc {
      color: rgba(0,0,0,0.55) !important;
    }
    [data-bs-theme="light"] .photo-mgmt-divider {
      border-color: rgba(0,0,0,0.08) !important;
    }

    /* Delete Account Modal */
    [data-bs-theme="light"] .del-modal {
      background: #ffffff !important;
      border-color: rgba(220,53,69,0.3) !important;
      color: #111111 !important;
    }
    [data-bs-theme="light"] .del-modal__header {
      border-bottom-color: rgba(0,0,0,0.08) !important;
    }
    [data-bs-theme="light"] .del-modal__close {
      background: rgba(0,0,0,0.05) !important;
      border-color: rgba(0,0,0,0.1) !important;
      color: rgba(0,0,0,0.5) !important;
    }
    [data-bs-theme="light"] .del-modal__info-box {
      background: rgba(220,53,69,0.05) !important;
      border-color: rgba(220,53,69,0.2) !important;
      color: #111111 !important;
    }
    [data-bs-theme="light"] .del-modal__info-title {
      color: #c82333 !important;
    }
    [data-bs-theme="light"] .del-modal__info-list li {
      color: #444444 !important;
    }
    [data-bs-theme="light"] .del-modal__label {
      color: #222222 !important;
    }
    [data-bs-theme="light"] .del-modal__input {
      background: #f9f9fb !important;
      border-color: rgba(0,0,0,0.15) !important;
      color: #111111 !important;
    }
    [data-bs-theme="light"] .del-modal__footer {
      border-top-color: rgba(0,0,0,0.08) !important;
    }
    [data-bs-theme="light"] .del-modal__btn-cancel {
      background: rgba(0,0,0,0.05) !important;
      color: #444444 !important;
      border-color: rgba(0,0,0,0.1) !important;
    }

    /* Tables, Borders & Spans */
    [data-bs-theme="light"] .table { color: #111111 !important; }
    [data-bs-theme="light"] .table th,
    [data-bs-theme="light"] .table td {
      border-color: rgba(0,0,0,0.08) !important;
      color: #111111 !important;
    }
    [data-bs-theme="light"] .input-group-text {
      background-color: rgba(255,140,0,0.1) !important;
      border-color: rgba(0,0,0,0.15) !important;
      color: #e67e00 !important;
    }
    [data-bs-theme="light"] div[style*="border-color: rgba(255,255,255"] {
      border-color: rgba(0,0,0,0.08) !important;
    }
    [data-bs-theme="light"] div[style*="background: rgba(0,0,0,0.2)"] {
      background: #f8f9fa !important;
    }
    [data-bs-theme="light"] h4[style*="color:#fff"],
    [data-bs-theme="light"] h4[style*="color: #fff"] {
      color: #111111 !important;
    }
    [data-bs-theme="light"] p[style*="color:rgba(255,255,255"],
    [data-bs-theme="light"] span[style*="color:rgba(255,255,255"] {
      color: rgba(0,0,0,0.65) !important;
    }

    /* PAGINATION STYLING FOR WALLET & TABLES */
    .pagination { gap: 3px; margin-bottom: 0; }
    .pagination .page-item .page-link {
      background: transparent;
      border: 1px solid rgba(255,140,0,0.25);
      color: orange;
      padding: 0.32rem 0.7rem;
      border-radius: 6px !important;
      font-size: 0.8rem;
      font-weight: 700;
      font-family: "Outfit", sans-serif;
      transition: all 0.2s ease;
      box-shadow: none;
    }
    .pagination .page-item.active .page-link {
      background: orange !important;
      border-color: orange !important;
      color: #000 !important;
      font-weight: 800;
      box-shadow: 0 0 12px rgba(255,165,0,0.4) !important;
    }
    .pagination .page-item.disabled .page-link {
      background: transparent !important;
      border-color: rgba(255,255,255,0.08) !important;
      color: rgba(255,255,255,0.25) !important;
    }
    .pagination .page-item .page-link:hover:not(.active) {
      background: rgba(255,140,0,0.15) !important;
      border-color: orange !important;
      color: orange !important;
    }
    [data-bs-theme="light"] .pagination .page-item.disabled .page-link {
      border-color: rgba(0,0,0,0.08) !important;
      color: rgba(0,0,0,0.3) !important;
    }

    /* Mobile Pagination Spacing (Previous on Left, Next on Right) */
    @media (max-width: 575.98px) {
      nav, nav > div, .pagination {
        width: 100% !important;
      }
      .pagination {
        display: flex !important;
        justify-content: space-between !important;
      }
      .pagination .page-item:first-child,
      .pagination .page-item:has(a[rel="prev"]) {
        margin-right: auto !important;
      }
      .pagination .page-item:last-child,
      .pagination .page-item:has(a[rel="next"]) {
        margin-left: auto !important;
      }
    }

    /* Table Transparent Background Overrides for Wallet & Classifieds History */
    #walletHistoryContainer, #classifiedsHistoryContainer,
    #walletHistoryContainer table, #classifiedsHistoryContainer table,
    #walletHistoryContainer tr, #classifiedsHistoryContainer tr,
    #walletHistoryContainer th, #classifiedsHistoryContainer th,
    #walletHistoryContainer td, #classifiedsHistoryContainer td {
      background: transparent !important;
      background-color: transparent !important;
      --bs-table-bg: transparent !important;
      --bs-table-accent-bg: transparent !important;
      --bs-table-striped-bg: transparent !important;
      --bs-table-hover-bg: transparent !important;
    }

    /* ── PROFILE AVATAR CARD ── */
    .profile-avatar-wrap {
      position: relative;
      width: 120px; height: 120px;
      border-radius: 50%;
      cursor: pointer;
      margin: 0 auto;
      overflow: hidden;
      border: 3px solid rgba(255,140,0,0.5);
      background: rgba(255,140,0,0.07);
      box-shadow: 0 0 0 5px rgba(255,140,0,0.08), 0 8px 24px rgba(0,0,0,0.4);
      transition: border-color 0.3s ease, box-shadow 0.3s ease;
    }
    .profile-avatar-wrap:hover { border-color: #ff8c00; box-shadow: 0 0 0 6px rgba(255,140,0,0.18), 0 0 30px rgba(255,140,0,0.2); }
    .profile-avatar-img {
      width: 100%; height: 100%;
      object-fit: cover;
      border-radius: 50%;
      display: block;
    }
    .profile-avatar-overlay {
      position: absolute; inset: 0;
      background: linear-gradient(180deg, rgba(0,0,0,0.3) 0%, rgba(0,0,0,0.72) 100%);
      display: flex; flex-direction: column;
      align-items: center; justify-content: center;
      color: #fff;
      opacity: 0;
      transition: opacity 0.28s ease;
      border-radius: 50%;
      gap: 4px;
    }
    .profile-avatar-wrap:hover .profile-avatar-overlay { opacity: 1; }

    /* ── PHOTO MANAGEMENT PANEL ── */
    .photo-mgmt-backdrop {
      display: none;
      position: fixed; inset: 0; z-index: 1060;
      background: rgba(0,0,0,0.55);
      backdrop-filter: blur(4px);
      align-items: center; justify-content: center;
      animation: mgmtFadeIn 0.2s ease both;
    }
    .photo-mgmt-backdrop.open { display: flex; }
    @keyframes mgmtFadeIn { from{opacity:0} to{opacity:1} }
    .photo-mgmt-panel {
      background: linear-gradient(160deg, #1a1100 0%, #111 60%, #0d0d0d 100%);
      border: 1px solid rgba(255,140,0,0.28);
      border-radius: 20px;
      padding: 0;
      width: 320px;
      max-width: calc(100vw - 2rem);
      box-shadow: 0 32px 80px rgba(0,0,0,0.8), 0 0 0 1px rgba(255,140,0,0.1), 0 0 60px rgba(255,140,0,0.06);
      animation: mgmtSlideUp 0.3s cubic-bezier(0.34,1.4,0.64,1) both;
      overflow: hidden;
    }
    @keyframes mgmtSlideUp { from{opacity:0;transform:translateY(24px) scale(0.95)} to{opacity:1;transform:translateY(0) scale(1)} }
    .photo-mgmt-header {
      padding: 1.25rem 1.5rem 1rem;
      border-bottom: 1px solid rgba(255,140,0,0.12);
      display: flex; align-items: center; gap: 0.75rem;
    }
    .photo-mgmt-header-icon {
      width: 38px; height: 38px; border-radius: 10px; flex-shrink: 0;
      background: rgba(255,140,0,0.12); border: 1px solid rgba(255,140,0,0.25);
      display: flex; align-items: center; justify-content: center;
      color: #ff8c00;
    }
    .photo-mgmt-header-title { font-size: 1rem; font-weight: 700; color: #fff; line-height: 1.2; margin: 0; }
    .photo-mgmt-header-sub  { font-size: 0.73rem; color: rgba(255,255,255,0.4); margin: 0; }
    .photo-mgmt-close {
      margin-left: auto; flex-shrink: 0;
      width: 30px; height: 30px; border-radius: 8px;
      background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);
      color: rgba(255,255,255,0.45); cursor: pointer;
      display: flex; align-items: center; justify-content: center;
      transition: all 0.2s;
    }
    .photo-mgmt-close:hover { background: rgba(255,140,0,0.15); border-color: rgba(255,140,0,0.4); color: #ff8c00; }
    .photo-mgmt-preview {
      padding: 1.25rem 1.5rem;
      display: flex; align-items: center; gap: 1rem;
    }
    .photo-mgmt-avatar {
      width: 64px; height: 64px; border-radius: 50%; flex-shrink: 0;
      border: 2px solid rgba(255,140,0,0.4);
      object-fit: cover;
      box-shadow: 0 0 16px rgba(255,140,0,0.18);
    }
    .photo-mgmt-info { flex: 1; min-width: 0; }
    .photo-mgmt-name { font-size: 0.9rem; font-weight: 700; color: #fff; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; margin: 0 0 0.2rem; }
    .photo-mgmt-hint { font-size: 0.72rem; color: rgba(255,255,255,0.38); margin: 0; line-height: 1.4; }
    .photo-mgmt-actions {
      padding: 0 1rem 1.25rem;
      display: flex; flex-direction: column; gap: 0.6rem;
    }
    .photo-mgmt-btn {
      display: flex; align-items: center; gap: 0.75rem;
      width: 100%; padding: 0.8rem 1rem;
      border-radius: 12px; border: 1.5px solid transparent;
      font-family: "Outfit", sans-serif; font-size: 0.88rem; font-weight: 600;
      cursor: pointer; text-align: left; text-decoration: none;
      transition: all 0.22s ease;
    }
    .photo-mgmt-btn-icon {
      width: 34px; height: 34px; border-radius: 9px; flex-shrink: 0;
      display: flex; align-items: center; justify-content: center;
      transition: all 0.22s;
    }
    .photo-mgmt-btn--upload {
      background: rgba(255,140,0,0.08); border-color: rgba(255,140,0,0.25); color: #fff;
    }
    .photo-mgmt-btn--upload .photo-mgmt-btn-icon { background: rgba(255,140,0,0.15); color: #ff8c00; }
    .photo-mgmt-btn--upload:hover {
      background: rgba(255,140,0,0.15); border-color: rgba(255,140,0,0.55); color: #fff;
      box-shadow: 0 0 20px rgba(255,140,0,0.12);
    }
    .photo-mgmt-btn--upload:hover .photo-mgmt-btn-icon { background: rgba(255,140,0,0.28); }
    .photo-mgmt-btn--remove {
      background: rgba(220,53,69,0.06); border-color: rgba(220,53,69,0.18); color: rgba(255,255,255,0.65);
    }
    .photo-mgmt-btn--remove .photo-mgmt-btn-icon { background: rgba(220,53,69,0.1); color: #dc3545; }
    .photo-mgmt-btn--remove:hover {
      background: rgba(220,53,69,0.14); border-color: rgba(220,53,69,0.45); color: #ff6b77;
      box-shadow: 0 0 20px rgba(220,53,69,0.1);
    }
    .photo-mgmt-btn--remove:hover .photo-mgmt-btn-icon { background: rgba(220,53,69,0.22); }
    .photo-mgmt-btn-text { flex: 1; }
    .photo-mgmt-btn-label { display: block; font-size: 0.88rem; font-weight: 600; line-height: 1.2; }
    .photo-mgmt-btn-desc  { display: block; font-size: 0.71rem; color: rgba(255,255,255,0.35); margin-top: 1px; }
    .photo-mgmt-btn--upload .photo-mgmt-btn-desc { color: rgba(255,200,100,0.5); }
    .photo-mgmt-btn-arrow { color: rgba(255,255,255,0.2); transition: transform 0.2s; }
    .photo-mgmt-btn:hover .photo-mgmt-btn-arrow { transform: translateX(3px); color: rgba(255,255,255,0.45); }
    .photo-mgmt-divider { margin: 0 1rem 0.6rem; border: none; border-top: 1px solid rgba(255,255,255,0.06); }
  </style>
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
  <script>
    function openPhotoMgmt() {
      document.getElementById('photoMgmtBackdrop').classList.add('open');
      document.body.style.overflow = 'hidden';
    }
    function closePhotoMgmt() {
      document.getElementById('photoMgmtBackdrop').classList.remove('open');
      document.body.style.overflow = '';
    }
    function showDynamicToast(title, message) {
      const toastHtml = `
      <div class="success-toast" id="dynamicToast" role="alert" aria-live="assertive" style="z-index: 999999;">
        <div class="success-toast__icon">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline>
          </svg>
        </div>
        <div class="success-toast__body">
          <p class="success-toast__title">${title}</p>
          <p class="success-toast__msg">${message}</p>
        </div>
        <button class="success-toast__close" onclick="this.closest('.success-toast').remove();" aria-label="Dismiss">
          <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round">
            <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
          </svg>
        </button>
        <div class="success-toast__bar"></div>
      </div>`;
      
      const existing = document.getElementById('dynamicToast');
      if (existing) existing.remove();
      
      document.body.insertAdjacentHTML('beforeend', toastHtml);
      setTimeout(() => {
        const t = document.getElementById('dynamicToast');
        if (t) t.remove();
      }, 6000);
    }
    function previewAndSubmit(input) {
      if (!input.files || !input.files[0]) return;
      closePhotoMgmt();
      var file = input.files[0];
      var reader = new FileReader();
      reader.onload = function(e) {
        var preview = document.getElementById('avatarPreview');
        var placeholder = document.getElementById('avatarPlaceholder');
        if (preview) { preview.src = e.target.result; preview.style.display = 'block'; }
        if (placeholder) placeholder.style.display = 'none';
      };
      reader.readAsDataURL(file);
      
      var spinner = document.getElementById('photoUploadStatus');
      if (spinner) spinner.style.display = 'flex';
      
      var formData = new FormData();
      formData.append('profile_photo', file);
      formData.append('_token', '{{ csrf_token() }}');
      
      fetch('{{ route("profile.photo") }}', {
        method: 'POST',
        headers: {
          'Accept': 'application/json',
          'X-Requested-With': 'XMLHttpRequest'
        },
        body: formData
      })
      .then(response => response.json())
      .then(data => {
        if (spinner) spinner.style.display = 'none';
        if (data.status === 'success') {
          showDynamicToast('Photo Published', 'Your profile photo has been successfully updated.');
          var removeBtn = document.getElementById('btnRemovePhoto');
          if (removeBtn) removeBtn.style.display = 'flex';
          var divider = document.getElementById('photoMgmtDivider');
          if (divider) divider.style.display = 'block';
        }
      })
      .catch(error => {
        if (spinner) spinner.style.display = 'none';
        alert('Upload failed');
      });
      input.value = ''; // reset so same file can be selected again
    }
    function confirmRemovePhoto() {
      closePhotoMgmt();
      if (confirm('Are you sure you want to remove your profile photo?')) {
        var spinner = document.getElementById('photoUploadStatus');
        if (spinner) spinner.style.display = 'flex';
        
        var formData = new FormData();
        formData.append('_token', '{{ csrf_token() }}');
        formData.append('_method', 'DELETE');

        fetch('{{ route("profile.photo.delete") }}', {
          method: 'POST',
          headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
          },
          body: formData
        })
        .then(response => response.json())
        .then(data => {
          if (spinner) spinner.style.display = 'none';
          if (data.status === 'success') {
            var preview = document.getElementById('avatarPreview');
            if (preview) preview.src = data.initials_url;
            showDynamicToast('Photo Removed', 'Your profile photo has been successfully removed.');
            var removeBtn = document.getElementById('btnRemovePhoto');
            if (removeBtn) removeBtn.style.display = 'none';
            var divider = document.getElementById('photoMgmtDivider');
            if (divider) divider.style.display = 'none';
          }
        })
        .catch(error => {
          if (spinner) spinner.style.display = 'none';
          alert('Delete failed');
        });
      }
    }
    document.addEventListener('keydown', function(e) {
      if (e.key === 'Escape') closePhotoMgmt();
    });
  </script>
</head>
<body>
  <x-navbar :hideSearch="true" />



  <div class="container pb-5 mb-5 mt-5">
    <div class="row">
      <!-- Sidebar -->
      <div class="col-12 col-lg-4 mb-4">
        
        <!-- Photo & Stats Card -->
        <div class="dash-card p-4">
          <div class="mb-4 text-center">

            {{-- ── Hidden forms ── --}}
            <form id="photoUploadForm" action="{{ route('profile.photo') }}" method="POST" enctype="multipart/form-data" style="display:none;">
              @csrf
              <input type="file" id="profilePhotoInput" name="profile_photo"
                     accept="image/jpeg,image/png,image/webp,image/gif"
                     onchange="previewAndSubmit(this)" />
              @error('profile_photo')
                <div class="text-danger small mt-2">{{ $message }}</div>
              @enderror
            </form>

            @if(auth()->user()->profile_photo)
            <form id="deletePhotoForm" action="{{ route('profile.photo.delete') }}" method="POST" style="display:none;">
              @csrf @method('DELETE')
            </form>
            @endif

            {{-- ── Avatar ── --}}
            <div class="profile-avatar-wrap mx-auto mb-3" onclick="openPhotoMgmt()" title="Manage profile photo">
              @if(auth()->user()->profile_photo)
                <img id="avatarPreview"
                     src="{{ asset('storage/' . auth()->user()->profile_photo) }}"
                     alt="Profile Photo" class="profile-avatar-img" />
              @else
                <img id="avatarPreview"
                     src="https://ui-avatars.com/api/?name={{ urlencode(substr(auth()->user()->name, 0, 2)) }}&background=ff8c00&color=000&size=200&bold=true"
                     alt="Profile Photo" class="profile-avatar-img" />
              @endif
              {{-- Hover overlay --}}
              <div class="profile-avatar-overlay">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round">
                  <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/>
                  <circle cx="12" cy="13" r="4"/>
                </svg>
                <span style="font-size:0.68rem;font-weight:700;letter-spacing:0.04em;margin-top:4px;">MANAGE</span>
              </div>
              {{-- Upload spinner overlay --}}
              <div id="photoUploadStatus" style="display:none;position:absolute;inset:0;background:rgba(0,0,0,0.65);align-items:center;justify-content:center;border-radius:50%;z-index:10;">
                <div class="spinner-border text-warning" role="status" style="width:2rem;height:2rem;"></div>
              </div>
            </div>

            {{-- ── Photo Management Modal Backdrop ── --}}
            <div id="photoMgmtBackdrop" class="photo-mgmt-backdrop" onclick="if(event.target===this) closePhotoMgmt();">
              <div class="photo-mgmt-panel">

                {{-- Header --}}
                <div class="photo-mgmt-header">
                  <div class="photo-mgmt-header-icon">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                      <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/>
                      <circle cx="12" cy="13" r="4"/>
                    </svg>
                  </div>
                  <div>
                    <p class="photo-mgmt-header-title">Profile Photo</p>
                    <p class="photo-mgmt-header-sub">Manage your profile picture</p>
                  </div>
                  <button class="photo-mgmt-close" onclick="closePhotoMgmt()" aria-label="Close">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                  </button>
                </div>


                {{-- Actions --}}
                <div class="photo-mgmt-actions">

                  <button type="button" class="photo-mgmt-btn photo-mgmt-btn--upload"
                          onclick="document.getElementById('profilePhotoInput').click();">
                    <span class="photo-mgmt-btn-icon">
                      <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                        <polyline points="17 8 12 3 7 8"/>
                        <line x1="12" y1="3" x2="12" y2="15"/>
                      </svg>
                    </span>
                    <span class="photo-mgmt-btn-text">
                      <span class="photo-mgmt-btn-label">Upload New Photo</span>
                      <span class="photo-mgmt-btn-desc">Replace with a new image</span>
                    </span>
                    <svg class="photo-mgmt-btn-arrow" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><polyline points="9 18 15 12 9 6"/></svg>
                  </button>

                  <hr class="photo-mgmt-divider" id="photoMgmtDivider" style="display: {{ auth()->user()->profile_photo ? 'block' : 'none' }};">
                  <button type="button" class="photo-mgmt-btn photo-mgmt-btn--remove" id="btnRemovePhoto"
                          style="display: {{ auth()->user()->profile_photo ? 'flex' : 'none' }};"
                          onclick="confirmRemovePhoto()">
                    <span class="photo-mgmt-btn-icon">
                      <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round">
                        <polyline points="3 6 5 6 21 6"/>
                        <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                        <path d="M10 11v6M14 11v6"/>
                        <path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/>
                      </svg>
                    </span>
                    <span class="photo-mgmt-btn-text">
                      <span class="photo-mgmt-btn-label">Remove Photo</span>
                      <span class="photo-mgmt-btn-desc">Revert to your initials avatar</span>
                    </span>
                    <svg class="photo-mgmt-btn-arrow" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><polyline points="9 18 15 12 9 6"/></svg>
                  </button>

                </div>
              </div>
            </div>

            {{-- User name below avatar --}}
            <div class="fw-bold text-white d-flex align-items-center justify-content-center gap-2 mb-1" style="font-size:1.3rem; letter-spacing:0.01em;">
              {{ auth()->user()->name }}
              @if(auth()->user()->is_verified)
                <div style="display:inline-flex; align-items:center; justify-content:center; background:#1da1f2; border-radius:50%; width:17px; height:17px; box-shadow:0 0 6px rgba(29,161,242,0.4);" title="Verified">
                  <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="20 6 9 17 4 12"></polyline>
                  </svg>
                </div>
              @endif
            </div>
            <div class="text-secondary mb-2" style="font-size:0.85rem;">{{ auth()->user()->email }}</div>
            <div>
              @if(auth()->user()->is_verified)
                <span class="badge" style="background-color:transparent; color:orange; border:1px solid orange; box-shadow:0 0 10px rgba(255,165,0,0.5); font-weight:600; padding:0.4em 0.8em; letter-spacing:0.5px;">
                  <svg width="14" height="14" class="me-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                  Verified User
                </span>
              @else
                <span class="badge" style="background-color:rgba(255,140,0,0.15); color:orange; border:1px solid rgba(255,140,0,0.3); font-weight:600; padding:0.4em 0.8em; letter-spacing:0.5px;">
                  <svg width="14" height="14" class="me-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                  Not Verified
                </span>
              @endif
            </div>
          </div>
          
          <div class="d-flex justify-content-around mb-3 py-2 profile-stats-divider">
            <div class="text-center">
              <div class="fw-bold text-light" style="font-size:1.05rem; line-height:1.2;">{{ number_format(auth()->user()->profile_views ?? 0) }}</div>
              <div class="text-secondary d-flex align-items-center justify-content-center gap-1" style="font-size:0.72rem;">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                Views
              </div>
            </div>
            <div class="profile-stats-vsep"></div>
            <div class="text-center">
              <div class="fw-bold text-light" style="font-size:1.05rem; line-height:1.2;">{{ number_format(auth()->user()->phone_calls ?? 0) }}</div>
              <div class="text-secondary d-flex align-items-center justify-content-center gap-1" style="font-size:0.72rem;">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                Calls
              </div>
            </div>
          </div>
          
          <a href="{{ route('profile.statistics') }}" class="btn btn-outline-warning w-100 fw-bold" style="border-radius:8px;">{{ __('View Statistics') }}</a>
        </div>

        <div class="side-nav-card">
          <div class="side-nav-title">My Account</div>

          <ul class="nav flex-column list-unstyled mb-0" role="tablist">

            {{-- Dashboard --}}
            <li role="presentation">
              <a href="{{ route('dashboard') }}" class="side-nav-link">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
                Dashboard
              </a>
            </li>

            {{-- Messages --}}
            <li role="presentation">
              <a href="{{ route('chat.index') }}" class="side-nav-link d-flex justify-content-between align-items-center">
                <span>
                  <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="me-2"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                  Messages
                </span>
                @php
                  $unreadCount = auth()->user()->messagesReceived()->where('is_read', false)->count();
                @endphp
                @if($unreadCount > 0)
                  <span class="badge bg-danger rounded-pill">{{ $unreadCount }}</span>
                @endif
              </a>
            </li>

            {{-- My Profile --}}
            <li role="presentation">
              <button class="side-nav-link active" id="profile-tab" data-bs-toggle="tab" data-bs-target="#tab-profile" type="button" role="tab" aria-controls="tab-profile" aria-selected="true">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>
                My Profile
              </button>
            </li>

            {{-- My Wallet --}}
            <li role="presentation">
              <button class="side-nav-link" id="wallet-tab" data-bs-toggle="tab" data-bs-target="#tab-wallet" type="button" role="tab" aria-controls="tab-wallet" aria-selected="false">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg>
                My Wallet
              </button>
            </li>

            {{-- My Membership --}}
            <li role="presentation">
              <button class="side-nav-link" id="membership-tab" data-bs-toggle="tab" data-bs-target="#tab-membership" type="button" role="tab" aria-controls="tab-membership" aria-selected="false">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2L15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2Z"/></svg>
                My Membership
              </button>
            </li>

            {{-- My Classifieds --}}
            <li role="presentation">
              <button class="side-nav-link" id="classifieds-tab" data-bs-toggle="tab" data-bs-target="#tab-classifieds" type="button" role="tab" aria-controls="tab-classifieds" aria-selected="false">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                My Classifieds
              </button>
            </li>

            {{-- Publish Photos & Videos --}}
            <li role="presentation">
              <button class="side-nav-link" id="publish-media-tab" data-bs-toggle="tab" data-bs-target="#tab-publish-media" type="button" role="tab" aria-controls="tab-publish-media" aria-selected="false">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                Publish Photos &amp; Videos
              </button>
            </li>

            {{-- My Settings --}}
            <li role="presentation">
              <button class="side-nav-link" id="settings-tab" data-bs-toggle="tab" data-bs-target="#tab-settings" type="button" role="tab" aria-controls="tab-settings" aria-selected="false">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
                My Settings
              </button>
            </li>

            {{-- Photo Verification --}}
            <li role="presentation">
              <button class="side-nav-link" id="verification-tab" data-bs-toggle="tab" data-bs-target="#tab-verification" type="button" role="tab" aria-controls="tab-verification" aria-selected="false">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><polyline points="9 12 11 14 15 10"/></svg>
                Photo Verification
              </button>
            </li>

          </ul>
        </div>
        
        <style>
          /* ── SIDEBAR NAV (matches wallet page) ── */
          .side-nav-card {
            background: rgba(17,17,17,0.85); backdrop-filter: blur(15px);
            border: 1px solid rgba(255,140,0,0.2); border-radius: 18px;
            padding: 1.25rem; box-shadow: 0 8px 32px rgba(0,0,0,0.5);
            margin-bottom: 1.5rem;
          }
          .side-nav-title {
            font-size: 0.7rem; font-weight: 800; letter-spacing: 2px;
            text-transform: uppercase; color: rgba(255,255,255,0.35);
            padding: 0 0.5rem 0.75rem; margin-bottom: 0.5rem;
            border-bottom: 1px solid rgba(255,140,0,0.12);
          }
          .side-nav-link {
            display: flex; align-items: center; gap: 0.75rem;
            width: 100%; padding: 0.7rem 0.85rem; border-radius: 10px;
            color: rgba(255,255,255,0.72); text-decoration: none;
            font-size: 0.92rem; font-weight: 500; font-family: "Outfit", sans-serif;
            background: transparent; border: none; text-align: left;
            transition: background 0.2s, color 0.2s;
            margin-bottom: 2px; cursor: pointer;
          }
          .side-nav-link:hover {
            background: rgba(255,140,0,0.1); color: orange;
          }
          .side-nav-link svg { flex-shrink: 0; opacity: 0.8; }
          .side-nav-link:hover svg { opacity: 1; }
          .side-nav-link.active {
            background: rgba(255,140,0,0.15) !important; color: orange !important;
            font-weight: 700;
          }
          .side-nav-link.active svg { opacity: 1; }
          [data-bs-theme="light"] .side-nav-card { background:#fff; border-color:rgba(255,140,0,0.3); }
          [data-bs-theme="light"] .side-nav-link { color:rgba(0,0,0,0.65); }
          [data-bs-theme="light"] .side-nav-link:hover { background:rgba(255,140,0,0.08); color:orange; }
        </style>

        {{-- â”€â”€ PHOTOS CARD â”€â”€ --}}
        @php
          $isVerified = auth()->user()->is_verified ?? false;
          $hasSub = $hasSubscription ?? false;
        @endphp
        @if(!$isVerified)
        <div class="dash-card p-4 photos-sidebar-card" style="margin-top:0;">
          <div class="d-flex align-items-center gap-2 mb-3">
            <div class="photos-icon-wrap">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="orange" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="3" width="18" height="18" rx="3" ry="3"/><circle cx="8.5" cy="8.5" r="1.5"/>
                <polyline points="21 15 16 10 5 21"/>
              </svg>
            </div>
            <span class="fw-bold text-white" style="font-size:1rem;">Photos</span>
            @if($isVerified)
              <span class="ms-auto" style="font-size:0.7rem;color:rgba(255,140,0,0.8);font-weight:600;">{{ $photos->count() }} uploaded</span>
            @endif
          </div>

          @if(!$isVerified)
            {{-- LOCKED STATE --}}
            <div class="photos-locked-state text-center py-2">
              <div class="lock-icon-wrap mx-auto mb-3">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="rgba(255,140,0,0.85)" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                  <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                </svg>
              </div>
              <p class="photos-locked-title mb-1">Only Verified Accounts</p>
              <p class="photos-locked-title mb-1">can Upload Photos.</p>
              <p class="photos-locked-sub mb-4">Kindly Verify Your Account.</p>
              <a href="{{ route('profile.edit') }}#tab-verification"
                 onclick="event.preventDefault(); window.location.href=this.href; setTimeout(()=>{ var el=document.getElementById('verification-tab'); if(el){ el.click(); el.scrollIntoView({behavior:'smooth'}); } },300);"
                 class="btn-verify-now w-100">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                Verify Now
              </a>
            </div>

          @elseif(!$hasSub)
            {{-- PLAN GATE STATE --}}
            <div class="text-center py-2">
              <div class="mx-auto mb-3" style="width:60px;height:60px;background:linear-gradient(135deg,rgba(255,140,0,0.15),rgba(255,200,0,0.05));border:1.5px solid rgba(255,140,0,0.35);border-radius:50%;display:flex;align-items:center;justify-content:center;">
                <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="orange" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
              </div>
              <p class="photos-locked-title mb-1" style="color:rgba(255,200,0,0.9);">Unlock Photo Uploads</p>
              <p class="photos-locked-sub mb-1">You're verified! Now choose a</p>
              <p class="photos-locked-sub mb-4">membership plan to start uploading.</p>
              <a href="{{ route('profile.edit') }}#tab-membership"
                 onclick="event.preventDefault(); window.location.href=this.href; setTimeout(()=>{ var el=document.getElementById('membership-tab'); if(el){ el.click(); el.scrollIntoView({behavior:'smooth'}); } },300);"
                 class="btn-verify-now w-100" style="margin-bottom:0.5rem;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                Subscribe Now
              </a>
              <a href="{{ route('profile.edit') }}#tab-membership"
                 onclick="event.preventDefault(); window.location.href=this.href; setTimeout(()=>{ var el=document.getElementById('membership-tab'); if(el){ el.click(); el.scrollIntoView({behavior:'smooth'}); } },300);"
                 style="font-size:0.75rem;color:rgba(255,140,0,0.6);text-decoration:none;">View all plans</a>
            </div>

          @else
            {{-- UPLOAD STATE --}}
            @if(session('photo_upload_success'))
              <div class="alert-photo-success mb-3">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><polyline points="20 6 9 17 4 12"/></svg>
                {{ session('photo_upload_success') }}
              </div>
            @endif

            {{-- Upload form --}}
            @if(auth()->user()->photos()->count() < auth()->user()->photo_limit)
              <form action="{{ route('user.photos.store') }}" method="POST" enctype="multipart/form-data" class="mb-3">
                @csrf
                <label for="photoUploadInput" class="media-upload-drop w-100" id="photoDropLabel">
                  <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="rgba(255,140,0,0.7)" stroke-width="1.8" stroke-linecap="round">
                    <rect x="3" y="3" width="18" height="18" rx="3" ry="3"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/>
                  </svg>
                  <span style="font-size:0.82rem;color:rgba(255,255,255,0.6);">Click to upload photos</span>
                  <span style="font-size:0.72rem;color:rgba(255,255,255,0.35);">JPG, PNG, WEBP â€” max 5MB</span>
                </label>
                <input type="file" id="photoUploadInput" name="photo" accept="image/jpeg,image/png,image/webp,image/gif" style="display:none;" onchange="this.closest('form').submit()">
                @error('photo')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
              </form>
            @else
              <div class="alert alert-warning py-2 small mb-3" style="background: rgba(255,140,0,0.1); border: 1px solid rgba(255,140,0,0.3); color: orange;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="me-1"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                You've reached your limit of {{ auth()->user()->photo_limit }} photos for your <strong>{{ ucfirst(auth()->user()->subscription_plan) }}</strong> plan.
              </div>
            @endif

            {{-- Photo grid --}}
            @if($photos->count())
              <div class="media-grid">
                @foreach($photos as $photo)
                  <div class="media-thumb-wrap">
                    <img src="{{ asset('storage/' . $photo->path) }}" alt="Photo" class="media-thumb">
                    <form action="{{ route('user.photos.destroy', $photo->id) }}" method="POST" class="media-delete-form">
                      @csrf @method('DELETE')
                      <button type="submit" class="media-delete-btn" title="Delete" onclick="return confirm('Delete this photo?')">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.5" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                      </button>
                    </form>
                  </div>
                @endforeach
              </div>
            @else
              <p class="text-secondary small text-center mb-0">No photos yet. Upload your first one!</p>
            @endif
          @endif
        </div>
        @endif

        <style>
          .photos-sidebar-card, .videos-sidebar-card {
            background: rgba(17,17,17,0.9);
            border: 1px solid rgba(255,140,0,0.18);
            border-radius: 18px;
          }
          .photos-icon-wrap, .videos-icon-wrap {
            width: 34px; height: 34px;
            background: rgba(255,140,0,0.1);
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
          }
          .lock-icon-wrap {
            width: 60px; height: 60px;
            background: rgba(255,140,0,0.07);
            border: 1.5px solid rgba(255,140,0,0.22);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
          }
          .photos-locked-title { font-size:0.88rem; font-weight:600; color:rgba(255,255,255,0.85); line-height:1.5; margin:0; }
          .photos-locked-sub { font-size:0.82rem; color:rgba(255,255,255,0.45); font-weight:400; }
          /* btn-verify-now styles handled by global button CSS */

          /* Upload drop zone */
          .media-upload-drop {
            display: flex; flex-direction: column; align-items: center; justify-content: center;
            gap: 0.4rem; padding: 1rem 0.5rem;
            border: 1.5px dashed rgba(255,140,0,0.35);
            border-radius: 10px; cursor: pointer;
            transition: border-color 0.2s, background 0.2s;
          }
          .media-upload-drop:hover { border-color: orange; background: rgba(255,140,0,0.05); }

          /* Thumbnail grid */
          .media-grid {
            display: grid; grid-template-columns: repeat(3, 1fr); gap: 0.4rem;
            margin-top: 0.5rem;
          }
          .media-thumb-wrap { position: relative; aspect-ratio: 1; border-radius: 8px; overflow: hidden; }
          .media-thumb { width: 100%; height: 100%; object-fit: cover; display: block; border-radius: 8px; }
          .media-delete-form { position: absolute; top: 3px; right: 3px; }
          .media-delete-btn {
            width: 20px; height: 20px; border-radius: 50%;
            background: rgba(220,53,69,0.85); border: none; cursor: pointer;
            display: flex; align-items: center; justify-content: center;
            opacity: 0; transition: opacity 0.2s;
          }
          .media-thumb-wrap:hover .media-delete-btn { opacity: 1; }

          /* Video thumb */
          .video-thumb { width:100%; border-radius:8px; aspect-ratio:16/9; object-fit:cover; display:block; }
          .media-video-wrap { position: relative; border-radius: 8px; overflow: hidden; margin-bottom: 0.5rem; }
          .media-video-wrap .media-delete-form { top: 4px; right: 4px; }
          .media-video-wrap .media-delete-btn { opacity: 1; }
        </style>

        {{-- â”€â”€ VIDEOS CARD â”€â”€ --}}
        @if(!$isVerified)
        <div class="dash-card p-4 videos-sidebar-card" style="margin-top:0;">
          <div class="d-flex align-items-center gap-2 mb-3">
            <div class="videos-icon-wrap">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="orange" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polygon points="23 7 16 12 23 17 23 7"/><rect x="1" y="5" width="15" height="14" rx="2" ry="2"/>
              </svg>
            </div>
            <span style="font-size:1rem;font-weight:700;color:#fff;">Videos</span>
            @if($isVerified && $hasSub)
              <span class="ms-auto" style="font-size:0.7rem;color:rgba(255,140,0,0.8);font-weight:600;">{{ $videos->count() }} uploaded</span>
            @endif
          </div>

          @if(!$isVerified)
            {{-- LOCKED STATE --}}
            <div class="text-center py-2">
              <div class="lock-icon-wrap mx-auto mb-3">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="rgba(255,140,0,0.85)" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                  <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                </svg>
              </div>
              <p class="photos-locked-title mb-1">Only Verified Accounts</p>
              <p class="photos-locked-title mb-1">can Upload Videos.</p>
              <p class="photos-locked-sub mb-4">Kindly Verify Your Account.</p>
              <a href="{{ route('profile.edit') }}#tab-verification"
                 onclick="event.preventDefault(); window.location.href=this.href; setTimeout(()=>{ var el=document.getElementById('verification-tab'); if(el){ el.click(); el.scrollIntoView({behavior:'smooth'}); } },300);"
                 class="btn-verify-now w-100">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                Verify Now
              </a>
            </div>

          @elseif(!$hasSub)
            {{-- PLAN GATE STATE --}}
            <div class="text-center py-2">
              <div class="mx-auto mb-3" style="width:60px;height:60px;background:linear-gradient(135deg,rgba(255,140,0,0.15),rgba(255,200,0,0.05));border:1.5px solid rgba(255,140,0,0.35);border-radius:50%;display:flex;align-items:center;justify-content:center;">
                <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="orange" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
              </div>
              <p class="photos-locked-title mb-1" style="color:rgba(255,200,0,0.9);">Unlock Video Uploads</p>
              <p class="photos-locked-sub mb-1">You're verified! Now choose a</p>
              <p class="photos-locked-sub mb-4">membership plan to start uploading.</p>
              <a href="{{ route('profile.edit') }}#tab-membership"
                 onclick="event.preventDefault(); window.location.href=this.href; setTimeout(()=>{ var el=document.getElementById('membership-tab'); if(el){ el.click(); el.scrollIntoView({behavior:'smooth'}); } },300);"
                 class="btn-verify-now w-100" style="margin-bottom:0.5rem;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                Subscribe Now
              </a>
              <a href="{{ route('profile.edit') }}#tab-membership"
                 onclick="event.preventDefault(); window.location.href=this.href; setTimeout(()=>{ var el=document.getElementById('membership-tab'); if(el){ el.click(); el.scrollIntoView({behavior:'smooth'}); } },300);"
                 style="font-size:0.75rem;color:rgba(255,140,0,0.6);text-decoration:none;">View all plans</a>
            </div>

          @else
            {{-- VIDEO UPLOAD STATE --}}
            @if(session('video_upload_success'))
              <div class="alert-photo-success mb-3">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><polyline points="20 6 9 17 4 12"/></svg>
                {{ session('video_upload_success') }}
              </div>
            @endif

            {{-- Upload form --}}
            @if(auth()->user()->videos()->count() < auth()->user()->video_limit)
              <form action="{{ route('user.videos.store') }}" method="POST" enctype="multipart/form-data" class="mb-3">
                @csrf
                <label for="videoUploadInput" class="media-upload-drop w-100">
                  <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="rgba(255,140,0,0.7)" stroke-width="1.8" stroke-linecap="round">
                    <polygon points="23 7 16 12 23 17 23 7"/><rect x="1" y="5" width="15" height="14" rx="2" ry="2"/>
                  </svg>
                  <span style="font-size:0.82rem;color:rgba(255,255,255,0.6);">Click to upload videos</span>
                  <span style="font-size:0.72rem;color:rgba(255,255,255,0.35);">MP4, MOV, WEBM â€” max 100MB</span>
                </label>
                <input type="file" id="videoUploadInput" name="video" accept="video/mp4,video/mov,video/avi,video/webm,video/x-matroska" style="display:none;" onchange="this.closest('form').submit()">
                @error('video')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
              </form>
            @else
              <div class="alert alert-warning py-2 small mb-3" style="background: rgba(255,140,0,0.1); border: 1px solid rgba(255,140,0,0.3); color: orange;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="me-1"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                You've reached your limit of {{ auth()->user()->video_limit }} videos for your <strong>{{ ucfirst(auth()->user()->subscription_plan) }}</strong> plan.
              </div>
            @endif

            {{-- Video list --}}
            @if($videos->count())
              @foreach($videos as $vid)
                <div class="media-video-wrap mb-2">
                  <video class="video-thumb" controls preload="none">
                    <source src="{{ asset('storage/' . $vid->path) }}">
                  </video>
                  <form action="{{ route('user.videos.destroy', $vid->id) }}" method="POST" class="media-delete-form">
                    @csrf @method('DELETE')
                    <button type="submit" class="media-delete-btn" title="Delete" onclick="return confirm('Delete this video?')">
                      <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.5" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                    </button>
                  </form>
                </div>
              @endforeach
            @else
              <p class="text-secondary small text-center mb-0">No videos yet. Upload your first one!</p>
            @endif
          @endif
        </div>
        @endif

      </div>

      <!-- Main Content -->
      <div class="col-12 col-lg-8">
        <div class="tab-content">
          <!-- Profile Tab -->
          <div class="tab-pane fade show active" id="tab-profile" role="tabpanel" aria-labelledby="profile-tab">
            @include('profile.partials.update-profile-information-form')

            {{-- My Photos & Videos has been moved to the Publish Photos & Videos tab --}}
            @include('profile.partials.delete-user-form')
          </div>

          {{-- â”€â”€ PUBLISH PHOTOS & VIDEOS TAB â”€â”€ --}}
          <div class="tab-pane fade" id="tab-publish-media" role="tabpanel" aria-labelledby="publish-media-tab">
            <div class="dash-card">
              <header class="mb-4">
                <h2 class="dash-card-title d-flex align-items-center gap-2">
                  <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="orange" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/>
                  </svg>
                  Publish Photos &amp; Videos
                </h2>
                <p class="dash-card-text">Upload and manage the photos and videos displayed on your public profile.</p>
              </header>

              @if(!$isVerified)
                {{-- STEP 1: Account not verified --}}
                <div class="text-center py-5 rounded" style="background:rgba(255,140,0,0.02);border:1.5px dashed rgba(255,140,0,0.22);">
                  <div class="mx-auto mb-4" style="width:72px;height:72px;background:rgba(255,140,0,0.07);border:1.5px solid rgba(255,140,0,0.25);border-radius:50%;display:flex;align-items:center;justify-content:center;">
                    <svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="rgba(255,140,0,0.85)" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                      <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                    </svg>
                  </div>
                  <h4 class="fw-bold mb-2" style="color:#fff;">Verification Required</h4>
                  <p style="font-size:0.9rem;color:rgba(255,255,255,0.5);max-width:380px;margin:0 auto 1.5rem;">Only verified accounts can publish photos and videos. Complete your photo verification to unlock this section.</p>
                  <a href="{{ route('profile.edit') }}#tab-verification"
                     onclick="event.preventDefault(); window.location.href=this.href; setTimeout(()=>{ var el=document.getElementById('verification-tab'); if(el){ el.click(); el.scrollIntoView({behavior:'smooth'}); } },300);"
                     class="btn-verify-now">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                    Verify My Account
                  </a>
                </div>

              @elseif(!$hasSub)
                {{-- STEP 2: Verified but no subscription --}}
                <div class="text-center py-5 rounded" style="background:rgba(255,140,0,0.02);border:1.5px dashed rgba(255,140,0,0.22);">
                  <div class="mx-auto mb-4" style="width:72px;height:72px;background:linear-gradient(135deg,rgba(255,140,0,0.15),rgba(255,200,0,0.05));border:1.5px solid rgba(255,140,0,0.35);border-radius:50%;display:flex;align-items:center;justify-content:center;">
                    <svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="orange" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                      <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                    </svg>
                  </div>
                  <h4 class="fw-bold mb-2" style="color:rgba(255,210,0,0.95);">Choose a Subscription to Unlock</h4>
                  <p style="font-size:0.9rem;color:rgba(255,255,255,0.5);max-width:420px;margin:0 auto 0.5rem;">Great â€” your account is verified! Select a membership plan to start publishing photos and videos to your public profile.</p>
                  <p style="font-size:0.8rem;color:rgba(255,140,0,0.6);margin-bottom:1.5rem;">Each plan includes different photo and video upload limits.</p>
                  <button onclick="document.getElementById('membership-tab').click(); document.getElementById('membership-tab').scrollIntoView({behavior:'smooth'});" class="btn-orange">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" class="me-1">
                      <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                    </svg>
                    View Subscription Plans
                  </button>
                </div>

              @else
                {{-- STEP 3: Verified + subscribed â€” show upload zones and galleries --}}

                {{-- Plan badge --}}
                <div class="d-flex align-items-center gap-2 mb-4 p-3 rounded" style="background:rgba(255,140,0,0.05);border:1px solid rgba(255,140,0,0.15);">
                  <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="orange" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                  <span style="font-size:0.85rem;color:rgba(255,255,255,0.75);">Active Plan: <strong style="color:orange;">{{ ucfirst(auth()->user()->subscription_plan) }}</strong></span>
                  <span class="ms-auto" style="font-size:0.78rem;color:rgba(255,255,255,0.4);">
                    Photos: {{ $photos->count() }}/{{ auth()->user()->photo_limit }} &nbsp;·&nbsp;
                    Videos: {{ $videos->count() }}/{{ auth()->user()->video_limit }}
                  </span>
                </div>

                <div class="row g-4">

                  {{-- ── PHOTOS COLUMN ── --}}
                  <div class="col-12 col-lg-6">
                    <div class="h-100 p-4 rounded" style="background:rgba(255,140,0,0.03);border:1px solid rgba(255,140,0,0.14);border-radius:16px;">
                      <h3 class="fs-5 fw-bold mb-1 d-flex align-items-center gap-2">
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="orange" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="3"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                        Publish Photo
                      </h3>
                      <p class="small mb-4" style="color:rgba(255,255,255,0.4);">{{ $photos->count() }} of {{ auth()->user()->photo_limit }} used</p>

                      @if(auth()->user()->photos()->count() < auth()->user()->photo_limit)
                        <form action="{{ route('user.photos.store') }}" method="POST" enctype="multipart/form-data" class="mb-2" id="publishPhotoForm">
                          @csrf
                          <label for="publishPhotoInput" id="publishPhotoLabel" class="w-100" style="display:flex;flex-direction:column;align-items:center;justify-content:center;gap:0.6rem;padding:2.2rem 1rem;border:2px dashed rgba(255,140,0,0.35);border-radius:12px;cursor:pointer;background:rgba(255,140,0,0.01);transition:border-color 0.2s,background 0.2s;"
                                 onmouseover="this.style.borderColor='orange';this.style.background='rgba(255,140,0,0.05)'"
                                 onmouseout="this.style.borderColor='rgba(255,140,0,0.35)';this.style.background='rgba(255,140,0,0.01)'">
                            <svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="rgba(255,140,0,0.7)" stroke-width="1.7" stroke-linecap="round">
                              <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/>
                            </svg>
                            <span style="font-size:0.88rem;font-weight:700;color:rgba(255,255,255,0.75);">Click to Select a Photo</span>
                            <span style="font-size:0.72rem;color:rgba(255,255,255,0.3);">JPG, PNG, WEBP — Max 5MB (1 photo per upload)</span>
                          </label>
                          <input type="file" id="publishPhotoInput" name="photo" accept="image/jpeg,image/png,image/webp,image/gif" style="display:none;" onchange="previewPhoto(this)">
                          <div id="photoPreviewContainer" style="display:none; margin-top:1rem; text-align:center;">
                            <img id="photoPreviewImg" src="#" style="max-width:100%; max-height:200px; border-radius:8px; margin-bottom:1rem; border:1px solid rgba(255,140,0,0.3);">
                            <button type="button" class="btn btn-outline-secondary w-100 mb-3" onclick="cancelPhotoUpload()" style="border-radius:8px;">Remove Selection</button>
                          </div>
                          
                          <button type="submit" class="btn btn-orange w-100 py-2 fw-bold mt-2" style="font-size:1.1rem; text-transform:uppercase; letter-spacing:1px; background:orange; color:#000; border:none; border-radius:8px; box-shadow:0 4px 15px rgba(255,165,0,0.3);">Publish Photo</button>
                          @error('photo')<div class="text-danger small mt-2">{{ $message }}</div>@enderror
                        </form>
                      @else
                        <div class="mb-2 py-2 px-3 rounded small" style="background:rgba(255,140,0,0.05);border:1px solid rgba(255,140,0,0.2);color:orange;">
                          You've reached the photo limit ({{ auth()->user()->photo_limit }}) for your <strong>{{ ucfirst(auth()->user()->subscription_plan) }}</strong> plan.
                          <a href="#" onclick="document.getElementById('membership-tab').click();" class="ms-2" style="color:rgba(255,200,0,0.8);text-decoration:underline;">Upgrade</a>
                        </div>
                      @endif
                    </div>
                  </div>

                  {{-- ── VIDEOS COLUMN ── --}}
                  <div class="col-12 col-lg-6">
                    <div class="h-100 p-4 rounded" style="background:rgba(255,140,0,0.03);border:1px solid rgba(255,140,0,0.14);border-radius:16px;">
                      <h3 class="fs-5 fw-bold mb-1 d-flex align-items-center gap-2">
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="orange" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="23 7 16 12 23 17 23 7"/><rect x="1" y="5" width="15" height="14" rx="2" ry="2"/></svg>
                        Publish Video
                      </h3>
                      <p class="small mb-4" style="color:rgba(255,255,255,0.4);">{{ $videos->count() }} of {{ auth()->user()->video_limit }} used</p>

                      @if(auth()->user()->videos()->count() < auth()->user()->video_limit)
                        <form action="{{ route('user.videos.store') }}" method="POST" enctype="multipart/form-data" class="mb-2" id="publishVideoForm">
                          @csrf
                          <label for="publishVideoInput" id="publishVideoLabel" class="w-100" style="display:flex;flex-direction:column;align-items:center;justify-content:center;gap:0.6rem;padding:2.2rem 1rem;border:2px dashed rgba(255,140,0,0.35);border-radius:12px;cursor:pointer;background:rgba(255,140,0,0.01);transition:border-color 0.2s,background 0.2s;"
                                 onmouseover="this.style.borderColor='orange';this.style.background='rgba(255,140,0,0.05)'"
                                 onmouseout="this.style.borderColor='rgba(255,140,0,0.35)';this.style.background='rgba(255,140,0,0.01)'">
                            <svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="rgba(255,140,0,0.7)" stroke-width="1.7" stroke-linecap="round">
                              <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/>
                            </svg>
                            <span style="font-size:0.88rem;font-weight:700;color:rgba(255,255,255,0.75);">Click to Select a Video</span>
                            <span style="font-size:0.72rem;color:rgba(255,255,255,0.3);">MP4, MOV, WEBM — Max 100MB</span>
                          </label>
                          <input type="file" id="publishVideoInput" name="video" accept="video/mp4,video/mov,video/avi,video/webm" style="display:none;" onchange="previewVideo(this)">
                          <div id="videoPreviewContainer" style="display:none; margin-top:1rem; text-align:center;">
                            <p id="videoFileName" class="text-light mb-2 fw-bold" style="font-size:0.9rem; padding:0.5rem; background:rgba(255,255,255,0.05); border-radius:6px; border:1px solid rgba(255,255,255,0.1);"></p>
                            <button type="button" class="btn btn-outline-secondary w-100 mb-3" onclick="cancelVideoUpload()" style="border-radius:8px;">Remove Selection</button>
                          </div>
                          
                          <button type="submit" class="btn btn-orange w-100 py-2 fw-bold mt-2" style="font-size:1.1rem; text-transform:uppercase; letter-spacing:1px; background:orange; color:#000; border:none; border-radius:8px; box-shadow:0 4px 15px rgba(255,165,0,0.3);">Publish Video</button>
                          @error('video')<div class="text-danger small mt-2">{{ $message }}</div>@enderror
                        </form>
                      @else
                        <div class="mb-2 py-2 px-3 rounded small" style="background:rgba(255,140,0,0.05);border:1px solid rgba(255,140,0,0.2);color:orange;">
                          You've reached the video limit ({{ auth()->user()->video_limit }}) for your <strong>{{ ucfirst(auth()->user()->subscription_plan) }}</strong> plan.
                          <a href="#" onclick="document.getElementById('membership-tab').click();" class="ms-2" style="color:rgba(255,200,0,0.8);text-decoration:underline;">Upgrade</a>
                        </div>
                      @endif
                    </div>
                  </div>

                </div>{{-- /row --}}

                {{-- ── NEW CARD: PUBLISHED MEDIA (Current Active Subscription Period) ── --}}
                <div class="mt-4 p-4 rounded" style="background:rgba(255,255,255,0.02);border:1px solid rgba(255,255,255,0.1);border-radius:16px;">
                  <div class="d-flex align-items-center justify-content-between mb-3 border-bottom pb-3" style="border-color:rgba(255,255,255,0.08) !important;">
                    <div>
                      <h3 class="fs-5 fw-bold mb-1 text-light d-flex align-items-center gap-2">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="orange" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        Published Media (Current Subscription Period)
                      </h3>
                      <p class="small mb-0 text-secondary">Active until {{ auth()->user()->subscription_expires_at ? auth()->user()->subscription_expires_at->format('M d, Y') : 'N/A' }}. Click any image to view in full screen.</p>
                    </div>
                    <span class="badge bg-outline-warning border border-warning text-warning px-3 py-2" style="border-radius:20px;">
                      {{ $photos->count() + $videos->count() }} Items Live
                    </span>
                  </div>

                  <div class="row g-3">
                    {{-- Published Photos --}}
                    @if($photos->count())
                      @foreach($photos as $photo)
                        <div class="col-6 col-sm-4 col-md-3">
                          <div class="published-photo-card" data-img-url="{{ asset('storage/' . $photo->path) }}" style="position:relative;aspect-ratio:1;border-radius:10px;overflow:hidden;border:{{ $photo->is_main ? '2.5px solid #ff8c00' : '1px solid rgba(255,255,255,0.15)' }};cursor:pointer;" onclick="openMediaModal('{{ asset('storage/' . $photo->path) }}', 'image')">
                            <img src="{{ asset('storage/' . $photo->path) }}" alt="Published Photo" style="width:100%;height:100%;object-fit:cover;display:block;transition:transform 0.3s ease;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                            <div style="position:absolute;inset:0;background:rgba(0,0,0,0.3);opacity:0;transition:opacity 0.2s;" onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0'" class="d-flex align-items-center justify-content-center">
                              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/><line x1="11" y1="8" x2="11" y2="14"/><line x1="8" y1="11" x2="14" y2="11"/></svg>
                            </div>
                            
                            {{-- Main Card Cover Badge / Button --}}
                            @if($photo->is_main)
                              <span class="btn-main-card-badge" style="position:absolute;top:6px;left:6px;z-index:2;">
                                ★ Main Card
                              </span>
                            @else
                              <form action="{{ route('user.photos.set-main', $photo->id) }}" method="POST" style="position:absolute;top:6px;left:6px;z-index:2;" onclick="event.stopPropagation();">
                                @csrf
                                <button type="submit" class="btn-set-main-card" title="Set as Main Listing Card Cover">
                                  Set as Main
                                </button>
                              </form>
                            @endif

                            <form action="{{ route('user.photos.destroy', $photo->id) }}" method="POST" style="position:absolute;top:6px;right:6px;z-index:2;" onclick="event.stopPropagation();">
                              @csrf @method('DELETE')
                              <button type="submit" onclick="return confirm('Delete this photo?')" style="width:26px;height:26px;border-radius:50%;background:rgba(220,53,69,0.9);border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;" title="Delete">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="3" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                              </button>
                            </form>
                          </div>
                        </div>
                      @endforeach
                    @endif

                    {{-- Published Videos --}}
                    @if($videos->count())
                      @foreach($videos as $vid)
                        <div class="col-12 col-md-6">
                          <div style="position:relative;border-radius:10px;overflow:hidden;background:#000;border:1px solid rgba(255,255,255,0.15);">
                            <video style="width:100%;display:block;border-radius:10px;aspect-ratio:16/9;object-fit:contain;" controls preload="none">
                              <source src="{{ asset('storage/' . $vid->path) }}">
                            </video>
                            <form action="{{ route('user.videos.destroy', $vid->id) }}" method="POST" style="position:absolute;top:8px;right:8px;z-index:2;">
                              @csrf @method('DELETE')
                              <button type="submit" onclick="return confirm('Delete this video?')" style="width:28px;height:28px;border-radius:50%;background:rgba(220,53,69,0.9);border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;" title="Delete">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="3" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                              </button>
                            </form>
                          </div>
                        </div>
                      @endforeach
                    @endif

                    @if(!$photos->count() && !$videos->count())
                      <div class="col-12 text-center py-4">
                        <p style="color:rgba(255,255,255,0.3);font-size:0.9rem;" class="mb-0">No photos or videos published for this period yet. Use the upload boxes above to publish.</p>
                      </div>
                    @endif
                  </div>
                </div>
              @endif
            </div>
          </div>


          <!-- Wallet Tab -->
          <div class="tab-pane fade" id="tab-wallet" role="tabpanel" aria-labelledby="wallet-tab">
            
            <div class="dash-card">
              <header class="mb-3">
                  <h2 class="dash-card-title mb-1" style="font-size: 1.05rem;">{{ __('Available Wallet Balance') }}</h2>
                  <p class="dash-card-text mb-0" style="font-size: 0.82rem;">{{ __('Check your current balance and add funds. Available for premium features & upgrades.') }}</p>
              </header>
              <div class="d-flex align-items-center justify-content-between p-3 rounded" style="background:rgba(255,140,0,0.05); border:1px solid rgba(255,140,0,0.2);">
                <div>
                  <div class="text-secondary fw-bold text-uppercase" style="font-size: 0.7rem; letter-spacing:1px;">{{ __('Balance') }}</div>
                  <div class="fw-bold text-light mt-1" style="font-size: 1.35rem;">KSh {{ number_format(auth()->user()->wallet_balance ?? 0, 2) }}</div>
                  <div class="text-secondary" style="font-size: 0.78rem; margin-top: 0.25rem;">Available for premium features & upgrades</div>
                </div>
                <a href="{{ route('wallet.add') }}" class="btn btn-sm btn-orange py-1.5 px-3" style="font-size: 0.82rem;">{{ __('Add Funds') }}</a>
              </div>
            </div>

            <div class="dash-card">
              <header class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
                <div>
                  <h2 class="dash-card-title mb-1">{{ __('Wallet History') }}</h2>
                  <p class="dash-card-text mb-0">{{ __('Review your recent wallet transactions.') }}</p>
                </div>
                @if(!$deposits->isEmpty())
                  <span style="color:orange; font-weight:700; font-size:0.85rem;">
                    {{ $deposits->total() }} Total {{ $deposits->total() == 1 ? 'Transaction' : 'Transactions' }}
                  </span>
                @endif
              </header>

              <div class="mt-3" id="walletHistoryContainer" style="transition: opacity 0.25s ease;">
                @include('profile.partials.wallet-history')
              </div>
            </div>

          </div>

          <!-- Membership Tab -->
          <div class="tab-pane fade" id="tab-membership" role="tabpanel" aria-labelledby="membership-tab">
            
            <!-- Available Wallet Balance -->
            <div class="dash-card mb-4">
              <header class="mb-3">
                  <h2 class="dash-card-title mb-1" style="font-size: 1.05rem;">{{ __('Available Wallet Balance') }}</h2>
                  <p class="dash-card-text mb-0" style="font-size: 0.82rem;">{{ __('Your available funds for membership upgrades and premium features.') }}</p>
              </header>
              <div class="d-flex align-items-center justify-content-between p-3 rounded" style="background:rgba(255,140,0,0.05); border:1px solid rgba(255,140,0,0.2);">
                <div>
                  <div class="text-secondary fw-bold text-uppercase" style="font-size: 0.7rem; letter-spacing:1px;">{{ __('Balance') }}</div>
                  <div class="fw-bold text-light mt-1" style="font-size: 1.35rem;">KSh {{ number_format(auth()->user()->wallet_balance ?? 0, 2) }}</div>
                </div>
                <a href="{{ route('wallet.add') }}" class="btn btn-sm btn-orange py-1.5 px-3" style="font-size: 0.82rem;">{{ __('Add Funds') }}</a>
              </div>
            </div>

            <!-- Current Subscription -->
            @if(auth()->user()->hasActiveSubscription())
              <div class="dash-card mb-4" style="border-color: orange; background: rgba(255,140,0,0.05);">
                <header>
                    <h2 class="dash-card-title text-warning d-flex align-items-center gap-2">
                      <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                      {{ __('Current Subscription') }}
                    </h2>
                </header>
                <div class="d-flex flex-column gap-2 mt-3">
                  <div class="fs-5 fw-bold text-light">
                    Plan: <span class="text-uppercase text-warning">{{ auth()->user()->subscription_plan }}</span>
                  </div>
                  @if(auth()->user()->subscription_expires_at)
                    <div class="text-secondary">Expires: {{ auth()->user()->subscription_expires_at->format('M d, Y h:i A') }}</div>
                  @else
                    <div class="text-secondary">Expires: Never</div>
                  @endif
                  
                  <div class="mt-3 text-light p-3 rounded" style="background: rgba(0,0,0,0.2); border: 1px solid rgba(255,255,255,0.05);">
                    <div class="mb-2 text-warning fw-bold small text-uppercase" style="letter-spacing: 1px;">Upload Limits</div>
                    <div class="d-flex gap-4">
                      <div>
                        <span class="text-secondary small">Photos:</span>
                        <span class="fw-bold">{{ auth()->user()->photos()->count() }} / {{ auth()->user()->photo_limit }}</span>
                      </div>
                      <div>
                        <span class="text-secondary small">Videos:</span>
                        <span class="fw-bold">{{ auth()->user()->videos()->count() }} / {{ auth()->user()->video_limit }}</span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            @endif

            <!-- Available Plans -->
            <div class="dash-card">
              <header>
                  <h2 class="dash-card-title">{{ __('Available Plans') }}</h2>
                  <p class="dash-card-text">{{ __('Upgrade your membership to unlock more features.') }}</p>
              </header>
              
              <div class="row">
              @foreach($membershipPlans as $plan)
                @php
                  $checkoutRoutes = [
                    'regular'   => 'membership.regular.checkout',
                    'prime'     => 'membership.prime.checkout',
                    'prime-vip' => 'membership.prime-vip.checkout',
                    'vip'       => 'membership.vip.checkout',
                  ];
                  $checkoutRoute = $checkoutRoutes[$plan->slug] ?? null;
                  $isPrimeVip = $plan->slug === 'prime-vip';
                  $minPrice = $plan->pricing ? min(array_values($plan->pricing)) : 0;
                @endphp
                <div class="col-12 col-md-6 mb-3">
                  <div class="p-4 rounded h-100 d-flex flex-column" style="{{ $isPrimeVip ? 'background:linear-gradient(135deg, rgba(255,165,0,0.1), rgba(255,140,0,0.05)); border:1px solid rgba(255,165,0,0.4); box-shadow:0 5px 15px rgba(255,165,0,0.15);' : 'background:rgba(255,255,255,0.03); border:1px solid rgba(255,255,255,0.1);' }} position:relative; overflow:hidden;">
                    
                    @if($isPrimeVip)
                      <div class="position-absolute top-0 end-0 bg-warning text-dark px-3 py-1 fw-bold small" style="border-bottom-left-radius:8px;">{{ __('BEST VALUE') }}</div>
                    @endif

                    <div class="mb-4">
                      <div class="fs-2 fw-bold text-light mt-1 mb-1">{{ strtoupper($plan->name) }}</div>
                      <div class="fs-5 text-warning fw-bold">From KSh {{ number_format($minPrice, 2) }}</div>
                    </div>

                    <ul class="list-unstyled text-secondary small mb-4 flex-grow-1" style="line-height:1.8;">
                      @if($plan->pricing)
                        @foreach($plan->pricing as $days => $price)
                          <li class="d-flex align-items-start gap-2 mb-2">
                            <svg class="mt-1 flex-shrink-0" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#28a745" stroke-width="3" stroke-linecap="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                            <span class="fw-medium text-light">{{ $days }} {{ (int)$days === 1 ? 'Day' : 'Days' }} Listing</span> = {{ number_format($price) }} Ksh
                          </li>
                        @endforeach
                      @endif
                      @if($plan->features)
                        @foreach($plan->features as $feature)
                          <li class="d-flex align-items-start gap-2 mb-2">
                            <svg class="mt-1 flex-shrink-0" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#28a745" stroke-width="3" stroke-linecap="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                            {{ $feature }}
                          </li>
                        @endforeach
                      @endif
                    </ul>

                    @if($checkoutRoute)
                      <a href="{{ route($checkoutRoute) }}" class="btn {{ $isPrimeVip ? 'btn-orange' : 'btn-outline-warning' }} w-100 fw-bold mt-auto" style="border-radius:8px;">{{ __('Sign Up Now') }}</a>
                    @endif
                  </div>
                </div>
              @endforeach
              </div>

            </div>
            
          </div>

          <!-- Classifieds Tab -->
          <div class="tab-pane fade" id="tab-classifieds" role="tabpanel" aria-labelledby="classifieds-tab" x-data="{ showCreate: false }">
            
            <div x-show="!showCreate">
            <!-- Available Wallet Balance -->
            <div class="dash-card mb-4">
              <header class="mb-3">
                  <h2 class="dash-card-title mb-1" style="font-size: 1.05rem;">{{ __('Available Wallet Balance') }}</h2>
                  <p class="dash-card-text mb-0" style="font-size: 0.82rem;">{{ __('Your available funds for classified listings and features. Available for premium features & upgrades.') }}</p>
              </header>
              <div class="d-flex align-items-center justify-content-between p-3 rounded" style="background:rgba(255,140,0,0.05); border:1px solid rgba(255,140,0,0.2);">
                <div>
                  <div class="text-secondary fw-bold text-uppercase" style="font-size: 0.7rem; letter-spacing:1px;">{{ __('Balance') }}</div>
                  <div class="fw-bold text-light mt-1" style="font-size: 1.35rem;">KSh {{ number_format(auth()->user()->wallet_balance ?? 0, 2) }}</div>
                  <div class="text-secondary" style="font-size: 0.78rem; margin-top: 0.25rem;">Available for premium features & upgrades</div>
                </div>
                <a href="{{ route('wallet.add') }}" class="btn btn-sm btn-orange py-1.5 px-3" style="font-size: 0.82rem;">{{ __('Add Funds') }}</a>
              </div>
            </div>

            <!-- Classifieds Stats -->
            <div class="dash-card">
              <header>
                  <div class="d-flex align-items-center justify-content-between mb-2">
                    <h2 class="dash-card-title mb-0">{{ __('Classifieds') }}</h2>
                    <button @click="showCreate = true" class="btn btn-orange btn-sm" style="font-size:0.8rem; padding:0.4rem 1rem;">{{ __('Post New') }}</button>
                  </div>
                  <p class="dash-card-text">{{ __('Manage and track the status of your classified listings.') }}</p>
              </header>
              
              <div class="row g-2 g-md-3">
                <div class="col-6 col-md-3">
                  <div class="p-2.5 py-3 rounded text-center h-100" style="background:rgba(255,255,255,0.03); border:1px solid rgba(255,255,255,0.1);">
                    <div class="fw-bold text-light mb-1" style="font-size:1.4rem; line-height:1;">{{ $classifiedsStats['unpublished'] ?? 0 }}</div>
                    <div class="text-secondary text-uppercase fw-bold" style="font-size:0.7rem; letter-spacing:0.5px;">Unpublished</div>
                  </div>
                </div>
                <div class="col-6 col-md-3">
                  <div class="p-2.5 py-3 rounded text-center h-100" style="background:rgba(255,193,7,0.05); border:1px solid rgba(255,193,7,0.2);">
                    <div class="fw-bold text-warning mb-1" style="font-size:1.4rem; line-height:1;">{{ $classifiedsStats['in_moderation'] ?? 0 }}</div>
                    <div class="text-warning text-uppercase fw-bold" style="font-size:0.7rem; letter-spacing:0.5px; opacity:0.85;">In Moderation</div>
                  </div>
                </div>
                <div class="col-6 col-md-3">
                  <div class="p-2.5 py-3 rounded text-center h-100" style="background:rgba(40,167,69,0.05); border:1px solid rgba(40,167,69,0.2);">
                    <div class="fw-bold text-success mb-1" style="font-size:1.4rem; line-height:1;">{{ $classifiedsStats['approved'] ?? 0 }}</div>
                    <div class="text-success text-uppercase fw-bold" style="font-size:0.7rem; letter-spacing:0.5px; opacity:0.85;">Approved</div>
                  </div>
                </div>
                <div class="col-6 col-md-3">
                  <div class="p-2.5 py-3 rounded text-center h-100" style="background:rgba(220,53,69,0.05); border:1px solid rgba(220,53,69,0.2);">
                    <div class="fw-bold text-danger mb-1" style="font-size:1.4rem; line-height:1;">{{ $classifiedsStats['rejected'] ?? 0 }}</div>
                    <div class="text-danger text-uppercase fw-bold" style="font-size:0.7rem; letter-spacing:0.5px; opacity:0.85;">Rejected</div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Classifieds History Table -->
            <div class="dash-card mt-4">
              <header class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
                <div>
                  <h2 class="dash-card-title mb-1">{{ __('Classifieds History') }}</h2>
                  <p class="dash-card-text mb-0">{{ __('Review your recent classified listings and their statuses.') }}</p>
                </div>
                @if(!$classifieds->isEmpty())
                  <span style="color:orange; font-weight:700; font-size:0.85rem;">
                    {{ $classifieds->total() }} Total {{ $classifieds->total() == 1 ? 'Listing' : 'Listings' }}
                  </span>
                @endif
              </header>

              <div class="mt-3" id="classifiedsHistoryContainer" style="transition: opacity 0.25s ease;">
                @include('profile.partials.classifieds-history')
              </div>
            </div>
            </div>

            <!-- Create View -->
            <div x-show="showCreate" style="display: none;" x-cloak>
              <div class="dash-card mb-4">
                <header class="d-flex align-items-center justify-content-between mb-4">
                    <h2 class="dash-card-title mb-0">{{ __('Create Classified Post') }}</h2>
                    <button @click="showCreate = false" class="btn btn-outline-secondary btn-sm">{{ __('Back') }}</button>
                </header>
                
                <form action="{{ route('membership.process') }}" method="POST" enctype="multipart/form-data" id="classified-form">
                  @csrf
                  <input type="hidden" name="plan_type" value="classified">
                  <input type="hidden" name="plan" value="0">
                  <div class="row g-3">
                    
                    <div class="col-md-6">
                      <label class="form-label">{{ __('Post Title') }}</label>
                      <input type="text" name="title" class="form-control" placeholder="Post Title" required>
                    </div>
                    
                    <div class="col-md-6">
                      <label class="form-label">{{ __('Category') }}</label>
                      <select name="category" class="form-select text-secondary" required>
                        <option value="">Select Category</option>
                        <option value="personals">Personals</option>
                        <option value="jobs">Job</option>
                        <option value="massage">Massage</option>
                        <option value="events">Events</option>
                      </select>
                    </div>

                    <div class="col-md-6">
                      <label class="form-label">{{ __('City or Neighbourhood') }}</label>
                      <input type="text" name="city" class="form-control" placeholder="City Or Neighbourhood">
                    </div>

                    <div class="col-md-6">
                      <label class="form-label">{{ __('Featured Image') }}</label>
                      <input type="file" name="image" class="form-control text-secondary" accept="image/*" required>
                    </div>

                    <div class="col-12">
                      <label class="form-label">{{ __('Description') }}</label>
                      <textarea name="description" class="form-control" rows="4"></textarea>
                    </div>

                    <div class="col-12">
                      <label class="form-label">{{ __('Gallery (Add Images)') }}</label>
                      <input type="file" name="gallery[]" class="form-control text-secondary" multiple>
                    </div>

                    <div class="col-md-6">
                      <div class="form-check mb-2 mt-3">
                        <input class="form-check-input" type="checkbox" id="showPhone" checked>
                        <label class="form-check-label text-light" for="showPhone">{{ __('Show my Phone Number') }}</label>
                      </div>
                      <label class="form-label">{{ __('Phone Number') }}</label>
                      <input type="text" name="phone" class="form-control" placeholder="Phone Number">
                    </div>

                    <div class="col-md-6">
                      <div class="form-check mb-2 mt-3">
                        <input class="form-check-input" type="checkbox" id="showName" checked>
                        <label class="form-check-label text-light" for="showName">{{ __('Show my Name') }}</label>
                      </div>
                      <label class="form-label">{{ __('Contact Name') }}</label>
                      <input type="text" name="contact_name" class="form-control" placeholder="Contact Name">
                    </div>
                  </div>

                  <hr class="my-4" style="border-color: rgba(255,255,255,0.1);">
                  
                  <h5 class="text-light fw-bold mb-3">{{ __('Payment Method') }}</h5>
                  
                  <div class="p-4 rounded mb-4" style="background:rgba(255,255,255,0.03); border:1px solid rgba(255,255,255,0.1);">
                    <div class="mb-4">
                      <select name="payment_method" class="form-select text-secondary" required>
                        <option value="mpesa">MPESA [Transaction Fee: 0% + 0]</option>
                        <option value="wallet">Available Wallet Balance (KSh {{ number_format(auth()->user()->wallet_balance ?? 0, 2) }})</option>
                      </select>
                    </div>
                    
                    <div class="d-flex justify-content-between mb-2 small text-secondary">
                      <span>{{ __('Post Price:') }}</span>
                      <span class="text-light fw-medium">KSh1,000.00</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2 small text-secondary">
                      <span>{{ __('Transaction Fee:') }}</span>
                      <span class="text-light fw-medium">KSh0.00</span>
                    </div>
                    <div class="d-flex justify-content-between pt-3 mt-3 border-top" style="border-color:rgba(255,255,255,0.1) !important;">
                      <span class="text-light fw-bold">{{ __('Total:') }}</span>
                      <span class="text-warning fw-bold fs-5">KSh1,000.00</span>
                    </div>
                  </div>

                  <button type="submit" class="btn btn-orange w-100 fw-bold py-2" style="border-radius:8px;">{{ __('Pay & Publish') }}</button>

                </form>
              </div>
            </div>

          </div>

          <!-- Hookups Tab -->
          <div class="tab-pane fade" id="tab-hookups" role="tabpanel" aria-labelledby="hookups-tab">
            @include('profile.partials.hookup-listing-form')
          </div>


          <!-- Settings Tab -->
          <div class="tab-pane fade" id="tab-settings" role="tabpanel" aria-labelledby="settings-tab">

            <!-- Available Wallet Balance -->
            <div class="dash-card mb-4 settings-wallet-card">
              <div class="d-flex align-items-center gap-2 mb-3">
                <div class="settings-section-icon">
                  <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="orange" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/>
                  </svg>
                </div>
                <span class="settings-section-label">Available Wallet Balance</span>
              </div>
              <div class="d-flex align-items-center justify-content-between p-3 rounded settings-balance-inner">
                <div>
                  <div class="text-uppercase fw-bold mb-1" style="font-size:0.72rem;letter-spacing:1.5px;color:rgba(255,140,0,0.8);">Current Balance</div>
                  <div class="fw-bold settings-balance-amount" style="font-size:1.5rem;line-height:1;">
                    KSh <span class="settings-balance-num">{{ number_format(auth()->user()->wallet_balance ?? 0, 2) }}</span>
                  </div>
                  <div class="settings-balance-sub" style="font-size:0.8rem;margin-top:0.3rem;">Available for premium features & upgrades</div>
                </div>
                <a href="{{ route('wallet.add') }}" class="btn-settings-fund btn-sm">
                  <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
                    <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                  </svg>
                  Add Funds
                </a>
              </div>
            </div>

            <!-- My Settings Form -->
            <div class="dash-card settings-form-card">
              <div class="d-flex align-items-center gap-2 mb-1">
                <div class="settings-section-icon">
                  <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="orange" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="3"/><path d="M19.07 4.93a10 10 0 0 1 0 14.14M4.93 4.93a10 10 0 0 0 0 14.14"/>
                  </svg>
                </div>
                <span class="settings-section-label">My Settings</span>
              </div>
              <p class="dash-card-text mb-4">Manage your privacy preferences, notifications, and account security.</p>

              <form class="mt-2" method="POST" action="{{ route('profile.update') }}">
                @csrf
                @method('patch')

                {{-- Privacy Settings --}}
                <div class="settings-group-label">
                  <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                  Privacy
                </div>

                <div class="row g-3 mb-4">
                  <div class="col-12 col-md-6">
                    <label class="settings-field-label">
                      Favorites are Visible to
                    </label>
                    <div class="settings-select-wrap">
                      <select class="form-select settings-select" name="favorites_visibility">
                        <option value="everybody" {{ old('favorites_visibility', auth()->user()->favorites_visibility) == 'everybody' ? 'selected' : '' }}>Everybody</option>
                        <option value="favourites" {{ old('favorites_visibility', auth()->user()->favorites_visibility) == 'favourites' ? 'selected' : '' }}>Favourites Only</option>
                        <option value="nobody" {{ old('favorites_visibility', auth()->user()->favorites_visibility) == 'nobody' ? 'selected' : '' }}>Nobody</option>
                      </select>
                      <div class="settings-select-current">{{ ucfirst(old('favorites_visibility', auth()->user()->favorites_visibility ?? 'everybody')) }}</div>
                    </div>
                  </div>
                  <div class="col-12 col-md-6">
                    <label class="settings-field-label">
                      Photos are Visible to
                    </label>
                    <div class="settings-select-wrap">
                      <select class="form-select settings-select" name="photos_visibility">
                        <option value="everybody" {{ old('photos_visibility', auth()->user()->photos_visibility) == 'everybody' ? 'selected' : '' }}>Everybody</option>
                        <option value="favourites" {{ old('photos_visibility', auth()->user()->photos_visibility) == 'favourites' ? 'selected' : '' }}>Favourites Only</option>
                        <option value="nobody" {{ old('photos_visibility', auth()->user()->photos_visibility) == 'nobody' ? 'selected' : '' }}>Nobody</option>
                      </select>
                      <div class="settings-select-current">{{ ucfirst(old('photos_visibility', auth()->user()->photos_visibility ?? 'everybody')) }}</div>
                    </div>
                  </div>
                </div>

                {{-- Notifications --}}
                <div class="settings-group-label">
                  <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                  Notifications
                </div>

                <div class="row g-3 mb-4">
                  <div class="col-12 col-md-6">
                    <label class="settings-field-label">Email Notifications</label>
                    <div class="settings-select-wrap">
                      <select class="form-select settings-select" name="email_notifications">
                        <option value="messages" {{ old('email_notifications', auth()->user()->email_notifications) == 'messages' ? 'selected' : '' }}>Messages</option>
                        <option value="none" {{ old('email_notifications', auth()->user()->email_notifications) == 'none' ? 'selected' : '' }}>None</option>
                      </select>
                      <div class="settings-select-current">{{ ucfirst(old('email_notifications', auth()->user()->email_notifications ?? 'messages')) }}</div>
                    </div>
                  </div>
                </div>

                {{-- Account --}}
                <div class="settings-group-label">
                  <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>
                  Account
                </div>

                <div class="row g-3 mb-4">
                  <div class="col-12 col-md-6">
                    <label class="settings-field-label">
                      Email Address
                      <span title="Email cannot be changed" style="margin-left:0.3rem;display:inline-flex;align-items:center;vertical-align:middle;opacity:0.45;cursor:default;">
                        <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                      </span>
                    </label>
                    <div class="settings-input-wrap" style="opacity:0.6; cursor:not-allowed;">
                      <svg class="settings-input-icon" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/>
                      </svg>
                      <input type="email" class="form-control settings-input" value="{{ auth()->user()->email ?? '' }}" readonly style="pointer-events:none; user-select:none;" />
                    </div>
                  </div>
                </div>

                {{-- Security --}}
                <div class="settings-group-label">
                  <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                  Change Password
                </div>

                <div class="row g-3 mb-4">
                  <div class="col-12 col-md-6">
                    <label class="settings-field-label">New Password</label>
                    <div class="settings-input-wrap">
                      <svg class="settings-input-icon" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                      </svg>
                      <input type="password" class="form-control settings-input" name="password" placeholder="Enter new password" />
                    </div>
                  </div>
                  <div class="col-12 col-md-6">
                    <label class="settings-field-label">Confirm Password</label>
                    <div class="settings-input-wrap">
                      <svg class="settings-input-icon" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                      </svg>
                      <input type="password" class="form-control settings-input" name="password_confirmation" placeholder="Repeat new password" />
                    </div>
                  </div>
                  <div class="col-12">
                    <label class="settings-field-label">Current Password <span style="color:rgba(255,140,0,0.8);">*</span></label>
                    <div class="settings-input-wrap" style="max-width:400px;">
                      <svg class="settings-input-icon" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                        <path d="M21 2l-2 2m-7.61 7.61a5.5 5.5 0 1 1-7.778 7.778 5.5 5.5 0 0 1 7.777-7.777zm0 0L15.5 7.5m0 0l3 3L22 7l-3-3m-3.5 3.5L19 4"/>
                      </svg>
                      <input type="password" class="form-control settings-input" name="current_password" placeholder="Required to save any changes" />
                    </div>
                    <div class="settings-help-text" style="font-size:0.78rem;margin-top:0.4rem;">You must enter your current password to apply any changes.</div>
                  </div>
                </div>

                {{-- Save --}}
                <div class="d-flex align-items-center justify-content-between pt-3 mt-2 settings-save-footer">
                  <span class="settings-help-text" style="font-size:0.8rem;">All changes are saved securely.</span>
                  <button type="submit" class="btn-save-settings">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
                      <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/>
                    </svg>
                    Save Changes
                  </button>
                </div>

              </form>
            </div>

            <!-- Active Sessions Card -->
            <div class="dash-card mt-4 settings-sessions-card">
              <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4">
                <div class="d-flex align-items-center gap-2">
                  <div class="settings-section-icon">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="orange" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                      <rect x="2" y="3" width="20" height="14" rx="2" ry="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/>
                    </svg>
                  </div>
                  <div>
                    <span class="settings-section-label d-block">Active Sessions</span>
                    <span style="font-size:0.8rem;color:rgba(255,255,255,0.45);">Manage and sign out of your active sessions on other browsers and devices.</span>
                  </div>
                </div>
                
                @if(isset($sessions) && count($sessions) > 1)
                  <form method="POST" action="{{ route('profile.sessions.terminate-others') }}">
                    @csrf
                    <button type="submit"
                      style="display:inline-flex;align-items:center;gap:0.4rem;padding:0.45rem 1rem;border-radius:8px;font-size:0.82rem;font-weight:700;font-family:'Outfit',sans-serif;cursor:pointer;transition:all 0.2s;background:transparent;border:1.5px solid rgba(220,53,69,0.6);color:#dc3545;"
                      onmouseover="this.style.background='rgba(220,53,69,0.12)'" onmouseout="this.style.background='transparent'"
                      onclick="return confirm('Sign out of all other devices? This cannot be undone.')">
                      <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                      Sign Out Other Devices
                    </button>
                  </form>
                @endif
              </div>



              <div class="list-group list-group-flush rounded border border-secondary" style="border-color: rgba(255,255,255,0.1) !important;">
                @if(isset($sessions) && count($sessions) > 0)
                  @foreach($sessions as $session)
                    <div class="list-group-item d-flex align-items-center justify-content-between p-3 flex-wrap gap-2" style="background: rgba(0,0,0,0.2); border-color: rgba(255,255,255,0.1); color: #fff;">
                      <div class="d-flex align-items-center gap-3">
                        <div class="session-device-icon" style="color: orange; background: rgba(255,140,0,0.1); padding: 0.6rem; border-radius: 8px;">
                          @if($session->device === 'Mobile')
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><rect x="5" y="2" width="14" height="20" rx="2" ry="2"/><line x1="12" y1="18" x2="12.01" y2="18"/></svg>
                          @elseif($session->device === 'Tablet')
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><rect x="4" y="2" width="16" height="20" rx="2" ry="2"/><line x1="12" y1="18" x2="12.01" y2="18"/></svg>
                          @else
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
                          @endif
                        </div>
                        <div>
                          <div class="d-flex align-items-center gap-2 flex-wrap">
                            <span class="fw-bold text-white">{{ $session->platform }} - {{ $session->browser }}</span>
                            @if($session->is_current_device)
                              <span class="badge bg-success text-white border-0 px-2 py-1" style="font-size: 0.7rem; font-weight: 600; background-color: #28a745 !important;">This device</span>
                            @endif
                          </div>
                          <div class="text-secondary" style="font-size: 0.8rem; margin-top: 2px;">
                            {{ $session->ip_address }} &bull; Last active {{ $session->last_active }}
                          </div>
                        </div>
                      </div>

                      @if(!$session->is_current_device)
                        <form method="POST" action="{{ route('profile.sessions.terminate', $session->id) }}">
                          @csrf
                          <button type="submit"
                            style="display:inline-flex;align-items:center;gap:0.35rem;padding:0.35rem 0.85rem;border-radius:7px;font-size:0.78rem;font-weight:700;font-family:'Outfit',sans-serif;cursor:pointer;transition:all 0.2s;background:transparent;border:1.5px solid rgba(220,53,69,0.5);color:#dc3545;"
                            onmouseover="this.style.background='rgba(220,53,69,0.1)'" onmouseout="this.style.background='transparent'"
                            onclick="return confirm('Sign out this session?')">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                            Sign Out
                          </button>
                        </form>
                      @endif
                    </div>
                  @endforeach
                @else
                  <div class="p-4 text-center text-secondary" style="background: rgba(0,0,0,0.2);">
                    No active sessions found.
                  </div>
                @endif
              </div>
            </div>

          </div>

          <style>
            /* Settings Tab Styles */
            .settings-wallet-card, .settings-form-card {
              background: rgba(17,17,17,0.9);
              border: 1px solid rgba(255,140,0,0.18);
              border-radius: 18px;
              padding: 1.8rem;
            }
            .settings-section-icon {
              width: 32px; height: 32px;
              background: rgba(255,140,0,0.1);
              border-radius: 8px;
              display: flex; align-items: center; justify-content: center;
              flex-shrink: 0;
            }
            .settings-section-label {
              font-size: 1.05rem;
              font-weight: 700;
              color: #fff;
            }
            .settings-balance-inner {
              background: rgba(255,140,0,0.04);
              border: 1px solid rgba(255,140,0,0.15);
              flex-wrap: wrap;
              gap: 1rem;
            }
            /* btn-settings-fund & btn-save-settings handled by global button CSS */
            .settings-group-label {
              display: flex; align-items: center; gap: 0.5rem;
              font-size: 0.75rem; font-weight: 700;
              text-transform: uppercase; letter-spacing: 1.2px;
              color: rgba(255,140,0,0.85);
              margin-bottom: 1rem; margin-top: 0.5rem;
              padding-bottom: 0.5rem;
              border-bottom: 1px solid rgba(255,140,0,0.1);
            }
            .settings-field-label {
              display: block;
              font-size: 0.82rem; font-weight: 600;
              color: rgba(255,255,255,0.75);
              margin-bottom: 0.45rem;
            }
            .settings-select-wrap { position: relative; }
            .settings-select {
              background: rgba(0,0,0,0.35) !important;
              border: 1px solid rgba(255,140,0,0.18) !important;
              color: #fff !important;
              border-radius: 9px !important;
              padding: 0.7rem 1rem !important;
              font-size: 0.9rem;
              transition: border-color 0.2s, box-shadow 0.2s;
            }
            .settings-select:focus {
              border-color: orange !important;
              box-shadow: 0 0 0 3px rgba(255,165,0,0.12) !important;
            }
            .settings-select option { background: #111; color: #fff; }
            .settings-input-wrap { position: relative; }
            .settings-input-icon {
              position: absolute; left: 0.85rem; top: 50%; transform: translateY(-50%);
              color: rgba(255,140,0,0.6); pointer-events: none; z-index: 2;
            }
            .settings-input {
              background: rgba(0,0,0,0.35) !important;
              border: 1px solid rgba(255,140,0,0.18) !important;
              color: #fff !important;
              border-radius: 9px !important;
              padding: 0.7rem 1rem 0.7rem 2.5rem !important;
              font-size: 0.9rem;
              transition: border-color 0.2s, box-shadow 0.2s;
            }
            .settings-input:focus {
              border-color: orange !important;
              box-shadow: 0 0 0 3px rgba(255,165,0,0.12) !important;
            }
            .settings-input::placeholder { color: rgba(255,255,255,0.25); }

            /* Active Sessions Styles */
            .settings-sessions-card {
              background: rgba(17,17,17,0.9);
              border: 1px solid rgba(255,140,0,0.18);
              border-radius: 18px;
              padding: 1.8rem;
            }
            .session-device-icon {
              display: flex;
              align-items: center;
              justify-content: center;
              width: 42px;
              height: 42px;
              background: rgba(255,140,0,0.08);
              border: 1px solid rgba(255,140,0,0.2);
              border-radius: 10px;
              color: orange;
            }
            .btn-outline-danger {
              color: #ff4d4d !important;
              border-color: rgba(255, 77, 77, 0.3) !important;
              background: transparent !important;
              transition: all 0.3s ease !important;
            }
            .btn-outline-danger:hover {
              color: #fff !important;
              background: #ff4d4d !important;
              border-color: #ff4d4d !important;
              box-shadow: 0 0 15px rgba(255, 77, 77, 0.4) !important;
            }
          </style>



          <!-- Photo Verification Tab -->
          <div class="tab-pane fade" id="tab-verification" role="tabpanel" aria-labelledby="verification-tab">
            
            <div class="mb-3">
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0" style="font-size:0.8rem;">
                  <li class="breadcrumb-item"><a href="#" class="text-warning text-decoration-none">{{ __('Home') }}</a></li>
                  <li class="breadcrumb-item active text-secondary" aria-current="page">{{ __('Photo Verification') }}</li>
                </ol>
              </nav>
            </div>

            <!-- Get Verified Hero -->
            <div class="dash-card mb-3 p-3" style="background: linear-gradient(135deg, rgba(255,140,0,0.15), rgba(17,17,17,0.9)); border: 1px solid rgba(255,140,0,0.4);">
              <header class="d-flex align-items-center gap-2 mb-2">
                  <div class="bg-orange text-dark rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 36px; height: 36px; background: orange;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                  </div>
                  <div>
                    <h2 class="dash-card-title mb-0 text-warning" style="font-size: 1.15rem;">{{ __('Get Verified') }}</h2>
                    <div class="badge bg-success text-dark fw-bold px-2 py-0.5" style="font-size:0.7rem;">{{ __('"REAL PHOTOS" BADGE') }}</div>
                  </div>
              </header>
              <p class="dash-card-text text-light mb-0" style="font-size: 0.85rem; line-height:1.5;">
                {{ __('If you want to get the "REAL PHOTOS" badge use our totally free photo verification service, you can build trust in your visitors and have much more clients as well.') }}
              </p>
            </div>

            <div class="row g-3">
              <div class="col-12 col-xl-7 mb-3">
                <!-- Upload Section -->
                <div class="dash-card h-100 p-3">
                  <header class="mb-3">
                      <h3 class="dash-card-title mb-1" style="font-size: 1.05rem;">{{ __('Real Photo') }}</h3>
                      <p class="dash-card-text mb-0" style="font-size: 0.82rem;">{{ __('Make a FULL BODY photo of yourself while showing this sign with your hand and upload it.') }}</p>
                  </header>
                  
                  <div class="d-flex flex-column align-items-center justify-content-center p-3 mb-3 rounded text-center" style="background: rgba(0,0,0,0.3); border: 1.5px dashed rgba(255,140,0,0.4);">
                    <div class="mb-1" style="font-size: 1.6rem; line-height: 1;">✋</div>
                    <h6 class="text-light fw-bold mb-0" style="font-size: 0.9rem;">{{ __('Show this sign') }}</h6>
                    <span class="text-secondary" style="font-size: 0.75rem;">{{ __('(Palm)') }}</span>
                  </div>

                  @if(session('verification_upload_success'))
                    <div class="alert alert-success text-white border-0 mb-3 p-2.5 px-3" style="font-size: 0.85rem; background: rgba(40, 167, 69, 0.2); border: 1px solid rgba(40,167,69,0.5) !important;">
                        {{ session('verification_upload_success') }}
                    </div>
                  @endif

                  @if(auth()->user()->is_verified)
                      <div class="alert alert-success text-white border-0 mb-3 text-center p-2.5 px-3" style="font-size: 0.85rem; background: rgba(40, 167, 69, 0.2); border: 1px solid rgba(40,167,69,0.5) !important;">
                          <strong>Verified!</strong><br>Your account has been verified. You can now upload photos and videos.
                      </div>
                  @elseif(isset($verificationSubmission) && $verificationSubmission->status === 'pending')
                      <div class="alert alert-warning text-center border-0 mb-3 p-2.5 px-3" style="font-size: 0.85rem; background: rgba(255, 193, 7, 0.1); color: #ffc107; border: 1px solid rgba(255,193,7,0.3) !important;">
                          <strong>Pending Review</strong><br>Your photo is currently being reviewed by our team. Please check back later.
                      </div>
                  @else
                      @if(isset($verificationSubmission) && $verificationSubmission->status === 'rejected')
                          <div class="alert alert-danger border-0 mb-3 text-center p-2.5 px-3" style="font-size: 0.85rem; background: rgba(220, 53, 69, 0.1); color: #ff6b6b; border: 1px solid rgba(220,53,69,0.3) !important;">
                              <strong>Rejected</strong><br>Your previous submission was rejected. Please carefully review the requirements and try again.
                          </div>
                      @endif

                      <form method="POST" action="{{ route('verification.submit') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                          <label class="form-label fw-bold" style="font-size: 0.85rem;">{{ __('Upload Photo') }}</label>
                          <input type="file" name="photo" class="form-control form-control-sm py-1.5" accept="image/jpeg,image/png,image/webp" required style="font-size: 0.82rem;" />
                          @error('photo')
                            <div class="text-danger small mt-1" style="font-size: 0.78rem;">{{ $message }}</div>
                          @enderror
                        </div>
                        <button type="submit" class="btn-orange w-100 fw-bold py-2" style="border-radius: 8px; font-size: 0.85rem;">{{ __('Submit for Verification') }}</button>
                      </form>
                  @endif
                </div>
              </div>

              <div class="col-12 col-xl-5 mb-3">
                <!-- Requirements Section -->
                <div class="dash-card h-100 p-3" style="background: rgba(255,255,255,0.03);">
                  <header class="mb-3">
                      <h4 class="dash-card-title text-success d-flex align-items-center gap-2 mb-0" style="font-size: 0.95rem;">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                        {{ __('Accepted Photos') }}
                      </h4>
                  </header>
                  <ul class="list-unstyled text-secondary mb-3" style="line-height: 1.5; font-size: 0.82rem;">
                    <li class="d-flex gap-2 mb-2">
                      <div class="text-success mt-1"><svg width="6" height="6" viewBox="0 0 8 8" fill="currentColor"><circle cx="4" cy="4" r="4"/></svg></div>
                      <div>{{ __('Showing this requested sign with hand.') }}</div>
                    </li>
                    <li class="d-flex gap-2 mb-2">
                      <div class="text-success mt-1"><svg width="6" height="6" viewBox="0 0 8 8" fill="currentColor"><circle cx="4" cy="4" r="4"/></svg></div>
                      <div>{{ __('We must see your FULL BODY without covering clothes (Lingerie Accepted).') }}</div>
                    </li>
                    <li class="d-flex gap-2 mb-2">
                      <div class="text-success mt-1"><svg width="6" height="6" viewBox="0 0 8 8" fill="currentColor"><circle cx="4" cy="4" r="4"/></svg></div>
                      <div>{{ __('Tattoo must be seen on the photo, if you have.') }}</div>
                    </li>
                    <li class="d-flex gap-2 mb-2">
                      <div class="text-success mt-1"><svg width="6" height="6" viewBox="0 0 8 8" fill="currentColor"><circle cx="4" cy="4" r="4"/></svg></div>
                      <div>{{ __('Please use makeup that helps us to compare the photos.') }}</div>
                    </li>
                  </ul>
                  
                  <hr class="my-3" style="border-color: rgba(255,255,255,0.1);">

                  <header class="mb-2">
                      <h4 class="dash-card-title text-danger d-flex align-items-center gap-2 mb-0" style="font-size: 0.95rem;">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
                        {{ __('Rejected Photos') }}
                      </h4>
                  </header>
                  <ul class="list-unstyled text-secondary mb-0" style="line-height: 1.5; font-size: 0.82rem;">
                    <li class="d-flex gap-2 mb-2">
                      <div class="text-danger mt-1"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="4" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></div>
                      <div>{{ __('Face not visible or covered.') }}</div>
                    </li>
                    <li class="d-flex gap-2 mb-2">
                      <div class="text-danger mt-1"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="4" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></div>
                      <div>{{ __('Not showing the requested hand sign.') }}</div>
                    </li>
                    <li class="d-flex gap-2 mb-2">
                      <div class="text-danger mt-1"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="4" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></div>
                      <div>{{ __('Heavily filtered or edited photos.') }}</div>
                    </li>
                  </ul>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
  
  <x-footer />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      // 1. Restore tab from hash on load
      if (window.location.hash) {
        var tabTarget = window.location.hash;
        var tabButton = document.querySelector('button[data-bs-target="' + tabTarget + '"]');
        if (tabButton) {
          // Add a tiny delay to ensure Bootstrap is fully initialized before showing
          setTimeout(function() {
            var tab = new bootstrap.Tab(tabButton);
            tab.show();
          }, 50);
        }
      }

      // 2. Update hash when a new tab is clicked
      var tabList = [].slice.call(document.querySelectorAll('button[data-bs-toggle="tab"]'));
      tabList.forEach(function(tabEl) {
        tabEl.addEventListener('shown.bs.tab', function (event) {
          var target = event.target.getAttribute('data-bs-target');
          if (target) {
            // Using window.location.hash ensures the browser explicitly tracks it for reloads
            if(history.replaceState) {
                history.replaceState(null, null, target);
            } else {
                window.location.hash = target;
            }
          }
        });
      });
      
      // 3. Auto-open Publish Media tab if there are media-related errors or success messages
      @if($errors->has('photo') || $errors->has('video') || session('photo_upload_success') || session('video_upload_success') || session('photo_delete_success') || session('video_delete_success'))
        var mediaTabBtn = document.querySelector('button[data-bs-target="#tab-publish-media"]');
        if (mediaTabBtn) {
            setTimeout(function() {
                var tab = new bootstrap.Tab(mediaTabBtn);
                tab.show();
                window.location.hash = '#tab-publish-media';
            }, 60);
        }
      @endif
    });

    // Preview functions for manual upload
    function previewPhoto(input) {
      if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
          document.getElementById('photoPreviewImg').src = e.target.result;
          document.getElementById('publishPhotoLabel').style.display = 'none';
          document.getElementById('photoPreviewContainer').style.display = 'block';
        }
        reader.readAsDataURL(input.files[0]);
      }
    }
    
    function cancelPhotoUpload() {
      document.getElementById('publishPhotoInput').value = '';
      document.getElementById('photoPreviewContainer').style.display = 'none';
      document.getElementById('photoPreviewImg').src = '#';
      document.getElementById('publishPhotoLabel').style.display = 'flex';
    }

    function previewVideo(input) {
      if (input.files && input.files[0]) {
        document.getElementById('videoFileName').innerText = input.files[0].name;
        document.getElementById('publishVideoLabel').style.display = 'none';
        document.getElementById('videoPreviewContainer').style.display = 'block';
      }
    }
    
    function cancelVideoUpload() {
      document.getElementById('publishVideoInput').value = '';
      document.getElementById('videoPreviewContainer').style.display = 'none';
      document.getElementById('videoFileName').innerText = '';
      document.getElementById('publishVideoLabel').style.display = 'flex';
    }
  </script>

  {{-- ── LIGHTBOX POPUP OVERLAY (global, outside all tab panes) ── --}}
  <style>
    .lb-overlay {
      position: fixed; inset: 0;
      background: rgba(0,0,0,0.93);
      z-index: 999999;
      display: none;
      align-items: center;
      justify-content: center;
      opacity: 0;
      transition: opacity 0.2s ease;
    }
    .lb-overlay.active { display: flex; opacity: 1; }
    .lb-img {
      max-width: 90vw; max-height: 82vh;
      width: auto; height: auto;
      object-fit: contain;
      border-radius: 10px;
      border: 1px solid rgba(255,255,255,0.18);
      box-shadow: 0 20px 60px rgba(0,0,0,0.95);
      display: block;
    }
    .lb-close {
      position: fixed; top: 20px; right: 25px;
      width: 44px; height: 44px; border-radius: 50%;
      background: rgba(255,255,255,0.12);
      border: 1px solid rgba(255,255,255,0.25);
      color: #fff; font-size: 26px; line-height: 1;
      display: flex; align-items: center; justify-content: center;
      cursor: pointer; transition: all 0.2s ease; z-index: 1000001;
    }
    .lb-close:hover { background: rgba(220,53,69,0.9); border-color: #dc3545; transform: scale(1.08); }
    .lb-arrow {
      position: fixed; top: 50%; transform: translateY(-50%);
      width: 50px; height: 50px; border-radius: 50%;
      background: rgba(20,20,25,0.88);
      border: 1px solid rgba(255,255,255,0.22);
      color: #fff; display: flex; align-items: center; justify-content: center;
      cursor: pointer; transition: all 0.2s ease; z-index: 1000001;
    }
    .lb-arrow:hover { background: orange; border-color: orange; color: #000; }
    .lb-arrow.prev { left: 20px; }
    .lb-arrow.next { right: 20px; }
    .lb-meta {
      position: fixed; bottom: 22px; left: 50%; transform: translateX(-50%);
      display: flex; align-items: center; gap: 10px;
      padding: 7px 18px;
      background: rgba(15,15,20,0.9);
      border: 1px solid rgba(255,255,255,0.13);
      border-radius: 20px; color: #fff; font-size: 0.87rem;
      z-index: 1000001; white-space: nowrap;
    }
  </style>

  <div id="lbOverlay" class="lb-overlay" onclick="lbClose(event)">
    <button class="lb-close" onclick="lbForceClose()" title="Close (Esc)">&times;</button>
    <button class="lb-arrow prev" onclick="lbNav(-1,event)">
      <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><polyline points="15 18 9 12 15 6"/></svg>
    </button>
    <img id="lbImg" class="lb-img" src="" alt="Photo">
    <button class="lb-arrow next" onclick="lbNav(1,event)">
      <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><polyline points="9 18 15 12 9 6"/></svg>
    </button>
    <div class="lb-meta">
      <span id="lbCounter">1 / 1</span>
      <span style="opacity:0.35">|</span>
      <span class="fw-bold" style="color:orange;">Published Photo</span>
    </div>
  </div>

  <script>
    var lbPhotos = [], lbIdx = 0;

    function openMediaModal(url, type) {
      if (type !== 'image') return;
      var cards = document.querySelectorAll('.published-photo-card');
      lbPhotos = Array.from(cards).map(function(c){ return c.getAttribute('data-img-url'); }).filter(Boolean);
      if (!lbPhotos.length) lbPhotos = [url];
      lbIdx = lbPhotos.indexOf(url);
      if (lbIdx < 0) lbIdx = 0;
      lbShow();
      var ov = document.getElementById('lbOverlay');
      ov.style.display = 'flex';
      setTimeout(function(){ ov.classList.add('active'); }, 10);
      document.body.style.overflow = 'hidden';
    }

    function lbShow() {
      document.getElementById('lbImg').src = lbPhotos[lbIdx] || '';
      document.getElementById('lbCounter').textContent = (lbIdx + 1) + ' / ' + lbPhotos.length;
      var prev = document.querySelector('.lb-arrow.prev');
      var next = document.querySelector('.lb-arrow.next');
                      <div>{{ __('Face not visible or covered.') }}</div>
                    </li>
                    <li class="d-flex gap-2 mb-2">
                      <div class="text-danger mt-1"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="4" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></div>
                      <div>{{ __('Not showing the requested hand sign.') }}</div>
                    </li>
                    <li class="d-flex gap-2 mb-2">
                      <div class="text-danger mt-1"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="4" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></div>
                      <div>{{ __('Heavily filtered or edited photos.') }}</div>
                    </li>
                  </ul>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
  
  <x-footer />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      // 1. Restore tab from hash on load
      if (window.location.hash) {
        var tabTarget = window.location.hash;
        var tabButton = document.querySelector('button[data-bs-target="' + tabTarget + '"]');
        if (tabButton) {
          // Add a tiny delay to ensure Bootstrap is fully initialized before showing
          setTimeout(function() {
            var tab = new bootstrap.Tab(tabButton);
            tab.show();
          }, 50);
        }
      }

      // 2. Update hash when a new tab is clicked
      var tabList = [].slice.call(document.querySelectorAll('button[data-bs-toggle="tab"]'));
      tabList.forEach(function(tabEl) {
        tabEl.addEventListener('shown.bs.tab', function (event) {
          var target = event.target.getAttribute('data-bs-target');
          if (target) {
            // Using window.location.hash ensures the browser explicitly tracks it for reloads
            if(history.replaceState) {
                history.replaceState(null, null, target);
            } else {
                window.location.hash = target;
            }
          }
        });
      });
      
      // 3. Auto-open Publish Media tab if there are media-related errors or success messages
      @if($errors->has('photo') || $errors->has('video') || session('photo_upload_success') || session('video_upload_success') || session('photo_delete_success') || session('video_delete_success'))
        var mediaTabBtn = document.querySelector('button[data-bs-target="#tab-publish-media"]');
        if (mediaTabBtn) {
            setTimeout(function() {
                var tab = new bootstrap.Tab(mediaTabBtn);
                tab.show();
                window.location.hash = '#tab-publish-media';
            }, 60);
        }
      @endif
    });

    // Preview functions for manual upload
    function previewPhoto(input) {
      if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
          document.getElementById('photoPreviewImg').src = e.target.result;
          document.getElementById('publishPhotoLabel').style.display = 'none';
          document.getElementById('photoPreviewContainer').style.display = 'block';
        }
        reader.readAsDataURL(input.files[0]);
      }
    }
    
    function cancelPhotoUpload() {
      document.getElementById('publishPhotoInput').value = '';
      document.getElementById('photoPreviewContainer').style.display = 'none';
      document.getElementById('photoPreviewImg').src = '#';
      document.getElementById('publishPhotoLabel').style.display = 'flex';
    }

    function previewVideo(input) {
      if (input.files && input.files[0]) {
        document.getElementById('videoFileName').innerText = input.files[0].name;
        document.getElementById('publishVideoLabel').style.display = 'none';
        document.getElementById('videoPreviewContainer').style.display = 'block';
      }
    }
    
    function cancelVideoUpload() {
      document.getElementById('publishVideoInput').value = '';
      document.getElementById('videoPreviewContainer').style.display = 'none';
      document.getElementById('videoFileName').innerText = '';
      document.getElementById('publishVideoLabel').style.display = 'flex';
    }
  </script>

  {{-- ── LIGHTBOX POPUP OVERLAY (global, outside all tab panes) ── --}}
  <style>
    .lb-overlay {
      position: fixed; inset: 0;
      background: rgba(0,0,0,0.93);
      z-index: 999999;
      display: none;
      align-items: center;
      justify-content: center;
      opacity: 0;
      transition: opacity 0.2s ease;
    }
    .lb-overlay.active { display: flex; opacity: 1; }
    .lb-img {
      max-width: 90vw; max-height: 82vh;
      width: auto; height: auto;
      object-fit: contain;
      border-radius: 10px;
      border: 1px solid rgba(255,255,255,0.18);
      box-shadow: 0 20px 60px rgba(0,0,0,0.95);
      display: block;
    }
    .lb-close {
      position: fixed; top: 20px; right: 25px;
      width: 44px; height: 44px; border-radius: 50%;
      background: rgba(255,255,255,0.12);
      border: 1px solid rgba(255,255,255,0.25);
      color: #fff; font-size: 26px; line-height: 1;
      display: flex; align-items: center; justify-content: center;
      cursor: pointer; transition: all 0.2s ease; z-index: 1000001;
    }
    .lb-close:hover { background: rgba(220,53,69,0.9); border-color: #dc3545; transform: scale(1.08); }
    .lb-arrow {
      position: fixed; top: 50%; transform: translateY(-50%);
      width: 50px; height: 50px; border-radius: 50%;
      background: rgba(20,20,25,0.88);
      border: 1px solid rgba(255,255,255,0.22);
      color: #fff; display: flex; align-items: center; justify-content: center;
      cursor: pointer; transition: all 0.2s ease; z-index: 1000001;
    }
    .lb-arrow:hover { background: orange; border-color: orange; color: #000; }
    .lb-arrow.prev { left: 20px; }
    .lb-arrow.next { right: 20px; }
    .lb-meta {
      position: fixed; bottom: 22px; left: 50%; transform: translateX(-50%);
      display: flex; align-items: center; gap: 10px;
      padding: 7px 18px;
      background: rgba(15,15,20,0.9);
      border: 1px solid rgba(255,255,255,0.13);
      border-radius: 20px; color: #fff; font-size: 0.87rem;
      z-index: 1000001; white-space: nowrap;
    }
  </style>

  <div id="lbOverlay" class="lb-overlay" onclick="lbClose(event)">
    <button class="lb-close" onclick="lbForceClose()" title="Close (Esc)">&times;</button>
    <button class="lb-arrow prev" onclick="lbNav(-1,event)">
      <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><polyline points="15 18 9 12 15 6"/></svg>
    </button>
    <img id="lbImg" class="lb-img" src="" alt="Photo">
    <button class="lb-arrow next" onclick="lbNav(1,event)">
      <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><polyline points="9 18 15 12 9 6"/></svg>
    </button>
    <div class="lb-meta">
      <span id="lbCounter">1 / 1</span>
      <span style="opacity:0.35">|</span>
      <span class="fw-bold" style="color:orange;">Published Photo</span>
    </div>
  </div>

  <script>
    var lbPhotos = [], lbIdx = 0;

    function openMediaModal(url, type) {
      if (type !== 'image') return;
      var cards = document.querySelectorAll('.published-photo-card');
      lbPhotos = Array.from(cards).map(function(c){ return c.getAttribute('data-img-url'); }).filter(Boolean);
      if (!lbPhotos.length) lbPhotos = [url];
      lbIdx = lbPhotos.indexOf(url);
      if (lbIdx < 0) lbIdx = 0;
      lbShow();
      var ov = document.getElementById('lbOverlay');
      ov.style.display = 'flex';
      setTimeout(function(){ ov.classList.add('active'); }, 10);
      document.body.style.overflow = 'hidden';
    }

    function lbShow() {
      document.getElementById('lbImg').src = lbPhotos[lbIdx] || '';
      document.getElementById('lbCounter').textContent = (lbIdx + 1) + ' / ' + lbPhotos.length;
      var prev = document.querySelector('.lb-arrow.prev');
      var next = document.querySelector('.lb-arrow.next');
      var show = lbPhotos.length > 1 ? 'flex' : 'none';
      if (prev) prev.style.display = show;
      if (next) next.style.display = show;
    }

    function lbNav(dir, e) {
      if (e) e.stopPropagation();
      if (lbPhotos.length <= 1) return;
      lbIdx = (lbIdx + dir + lbPhotos.length) % lbPhotos.length;
      lbShow();
    }

    function lbForceClose() {
      var ov = document.getElementById('lbOverlay');
      ov.classList.remove('active');
      setTimeout(function(){ ov.style.display = 'none'; document.body.style.overflow = ''; }, 200);
    }

    function lbClose(e) {
      if (e.target.id === 'lbOverlay') lbForceClose();
    }

    document.addEventListener('keydown', function(e) {
      var ov = document.getElementById('lbOverlay');
      if (!ov || !ov.classList.contains('active')) return;
      if (e.key === 'Escape') lbForceClose();
      else if (e.key === 'ArrowLeft') lbNav(-1, e);
      else if (e.key === 'ArrowRight') lbNav(1, e);
    });
  </script>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      var tabEls = document.querySelectorAll('button[data-bs-toggle="tab"].side-nav-link');
      var tabContentContainer = document.querySelector('.tab-content');
      
      tabEls.forEach(function(tabEl) {
        tabEl.addEventListener('shown.bs.tab', function (event) {
          if (window.innerWidth < 992 && tabContentContainer) {
            // Scroll to the top of the tab content container with an offset for the navbar
            var offset = 80;
            var topPos = tabContentContainer.getBoundingClientRect().top + window.scrollY - offset;
            window.scrollTo({ top: topPos, behavior: 'smooth' });
          }
        });
      });

      // Auto-activate tab if URL hash or pagination query parameter is present
      var searchParams = new URLSearchParams(window.location.search);
      var currentHash = window.location.hash;
      if (searchParams.has('classifieds_page') || currentHash === '#tab-classifieds') {
        var classifiedsTabBtn = document.getElementById('classifieds-tab');
        if (classifiedsTabBtn) {
          var bsTab = new bootstrap.Tab(classifiedsTabBtn);
          bsTab.show();
        }
      } else if (searchParams.has('deposits_page') || currentHash === '#tab-wallet') {
        var walletTabBtn = document.getElementById('wallet-tab');
        if (walletTabBtn) {
          var bsTab = new bootstrap.Tab(walletTabBtn);
          bsTab.show();
        }
      } else if (currentHash) {
        var targetTab = document.querySelector('button[data-bs-target="' + currentHash + '"]');
        if (targetTab) {
          var bsTab = new bootstrap.Tab(targetTab);
          bsTab.show();
        }
      }

      // Seamless AJAX Pagination for Wallet & Classifieds History
      document.addEventListener('click', function(e) {
        var link = e.target.closest('#walletHistoryContainer .pagination a, #classifiedsHistoryContainer .pagination a');
        if (!link) return;
        e.preventDefault();

        var href = link.getAttribute('href');
        if (!href) return;

        var container = link.closest('#classifiedsHistoryContainer') || link.closest('#walletHistoryContainer');
        if (container) {
          container.style.opacity = '0.4';
          container.style.pointerEvents = 'none';
        }

        fetch(href, {
          headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
          }
        })
        .then(function(r) { return r.json(); })
        .then(function(data) {
          if (container && data.html) {
            container.innerHTML = data.html;
            container.style.opacity = '1';
            container.style.pointerEvents = 'auto';
          }
        })
        .catch(function(err) {
          console.error('AJAX Pagination error:', err);
          if (container) {
            container.style.opacity = '1';
            container.style.pointerEvents = 'auto';
          }
        });
      });

      // Disallow Emojis on Inputs Real-time
      function stripEmojis(val) {
        if (!val) return val;
        try {
          return val.replace(/\p{Extended_Pictographic}/gu, '');
        } catch (e) {
          return val.replace(/[\u{1F600}-\u{1F64F}\u{1F300}-\u{1F5FF}\u{1F680}-\u{1F6FF}\u{1F700}-\u{1F77F}\u{1F780}-\u{1F7FF}\u{1F800}-\u{1F8FF}\u{1F900}-\u{1F9FF}\u{1FA00}-\u{1FA6F}\u{1FA70}-\u{1FAFF}\u{2600}-\u{26FF}\u{2700}-\u{27BF}\u{2300}-\u{23FF}]/gu, '');
        }
      }

      document.addEventListener('input', function(e) {
        var target = e.target;
        if (target && (target.tagName === 'INPUT' || target.tagName === 'TEXTAREA')) {
          if (target.type === 'file' || target.type === 'checkbox' || target.type === 'radio') return;
          var cur = target.value;
          var clean = stripEmojis(cur);
          if (cur !== clean) {
            target.value = clean;
          }
        }
      }, true);

      @if(session('success'))
      // Show a toast notification
      var toastEl = document.createElement('div');
      toastEl.innerHTML = `
        <div id="classifiedToast" style="
          position:fixed; top:80px; right:2rem; z-index:9999;
          background:linear-gradient(135deg,rgba(40,167,69,0.95),rgba(25,110,45,0.95));
          border:1px solid rgba(40,167,69,0.5);
          border-radius:12px; padding:1.25rem 1.5rem;
          color:#fff; font-family:'Outfit',sans-serif;
          font-size:0.95rem; font-weight:500;
          box-shadow:0 8px 24px rgba(0,0,0,0.4);
          display:flex; align-items:center; gap:0.75rem;
          max-width:360px;
          animation: slideInToast 0.4s ease;
        ">
          <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="flex-shrink:0;">
            <polyline points="20 6 9 17 4 12"></polyline>
          </svg>
          <span>{{ session('success') }}</span>
        </div>
      `;
      document.body.appendChild(toastEl);
      setTimeout(function() {
        var t = document.getElementById('classifiedToast');
        if (t) { t.style.opacity = '0'; t.style.transition = 'opacity 0.5s'; setTimeout(function(){ t.parentNode && t.parentNode.removeChild(t.parentNode); }, 500); }
      }, 4000);

      // Auto-activate classifieds tab if success from classified payment
      var classifiedsTabBtn = document.getElementById('classifieds-tab');
      if (classifiedsTabBtn) {
        var bsTab = new bootstrap.Tab(classifiedsTabBtn);
        bsTab.show();
      }
      @endif

    });
  </script>

  <style>
    @keyframes slideInToast {
      from { transform: translateX(100px); opacity: 0; }
      to   { transform: translateX(0);    opacity: 1; }
    }
  </style>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
