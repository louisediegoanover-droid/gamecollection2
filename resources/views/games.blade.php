@extends('layouts.main')

@section('content')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
<style>
*,
*::before,
*::after {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

:root {
    --primary: #5865F2;
    --secondary: #FF2E63;
    --accent: #08F7FE;
    --bg-dark: rgba(15, 23, 42, 0.96);
    --bg-glass: rgba(255,255,255,0.08);
    --border-light: rgba(255,255,255,0.12);
    --border-primary: rgba(88,101,242,0.28);
    --text-light: rgba(255,255,255,0.9);
    --text-muted: rgba(255,255,255,0.7);
    --radius-sm: 12px;
    --radius-md: 16px;
    --radius-lg: 22px;
    --radius-xl: 28px;
    --transition: 0.3s cubic-bezier(0.4,0,0.2,1);
    --nav-height: 70px;
    --shadow-lg: 0 25px 50px -12px rgba(0,0,0,0.25);
    --shadow-xl: 0 35px 60px -12px rgba(0,0,0,0.3);
}

html, body {
    margin: 0;
    padding: 0;
    overflow-x: hidden;
    scroll-behavior: smooth;
    font-family: system-ui, -apple-system, sans-serif;
    background: #0a0e1a;
    color: var(--text-light);
    width: 100%;
}

/* ── Navbar ── */
.navbar-landing {
    position: fixed;
    top: 0; left: 0;
    width: 100vw;
    height: 70px;
    backdrop-filter: blur(20px);
    background: rgba(15, 23, 42, 0.95);
    border-bottom: 1px solid rgba(88, 101, 242, 0.25);
    z-index: 10000;
    transition: all 0.3s ease;
}

.navbar-scrolled {
    height: 65px;
    background: rgba(15, 23, 42, 0.98);
    box-shadow: 0 8px 30px rgba(0,0,0,0.3);
}

.nav-container {
    max-width: 1400px;
    margin: 0 auto;
    height: 100%;
    padding: 0 20px;
    position: relative;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.logo {
    font-size: clamp(1.4rem, 3vw, 1.6rem);
    font-weight: 800;
    background: linear-gradient(135deg, #5865F2 0%, #FF2E63 50%, #08F7FE 100%);
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
    letter-spacing: -0.3px;
    z-index: 2;
    text-decoration: none;
    cursor: pointer;
}

.nav-links {
    position: absolute;
    left: 50%;
    transform: translateX(-50%);
    display: flex;
    gap: clamp(1.2rem, 3vw, 2rem);
    list-style: none;
    margin: 0; padding: 0;
}

.auth-buttons { display: flex; gap: 0.8rem; align-items: center; z-index: 2; }

.nav-link {
    color: var(--text-light);
    text-decoration: none;
    font-weight: 500;
    font-size: clamp(0.85rem, 2vw, 0.9rem);
    padding: 8px 0;
    position: relative;
    transition: all 0.3s ease;
    white-space: nowrap;
}

.nav-link::after {
    content: '';
    position: absolute;
    bottom: -2px; left: 50%;
    width: 0; height: 2px;
    background: linear-gradient(135deg, var(--primary), var(--secondary));
    transition: all 0.3s ease;
    transform: translateX(-50%);
    border-radius: 1px;
}

.nav-link:hover, .nav-link.active { color: #fff; }
.nav-link:hover::after, .nav-link.active::after { width: 100%; }

/* ── Profile dropdown ── */
.profile-menu-wrapper { position: relative; z-index: 2; }

.profile-btn {
    width: 52px; height: 52px;
    border-radius: 50%;
    background: linear-gradient(135deg, #5865F2, #FF2E63);
    border: 2.5px solid rgba(255,255,255,0.35);
    box-shadow: 0 4px 16px rgba(88,101,242,0.4);
    cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.3rem; font-weight: 800;
    color: #fff; text-transform: uppercase;
    transition: all 0.3s ease;
    position: relative; overflow: hidden;
    flex-shrink: 0; padding: 0; outline: none;
}

.profile-btn img { position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; border-radius: 50%; display: block; z-index: 1; }
.profile-btn::before { content: ''; position: absolute; inset: 0; background: linear-gradient(120deg, transparent 30%, rgba(255,255,255,0.25) 50%, transparent 70%); transform: translateX(-120%); transition: transform 0.6s ease; z-index: 2; }
.profile-btn:hover::before { transform: translateX(120%); }
.profile-btn:hover { transform: scale(1.08); box-shadow: 0 8px 25px rgba(88,101,242,0.5); border-color: rgba(255,255,255,0.4); }
.profile-btn.open { box-shadow: 0 0 0 3px rgba(88,101,242,0.4), 0 8px 25px rgba(88,101,242,0.3); border-color: #5865F2; }

.profile-dropdown {
    position: absolute;
    top: calc(100% + 14px); right: 0;
    width: 280px;
    background: rgba(12,18,36,0.98);
    backdrop-filter: blur(30px);
    border: 1px solid rgba(88,101,242,0.3);
    border-radius: 20px;
    box-shadow: 0 24px 60px rgba(0,0,0,0.6), 0 0 0 1px rgba(255,255,255,0.04);
    overflow: hidden;
    opacity: 0; visibility: hidden;
    transform: translateY(-10px) scale(0.96);
    transition: all 0.3s cubic-bezier(0.34,1.56,0.64,1);
    transform-origin: top right;
}

.profile-dropdown.open { opacity: 1; visibility: visible; transform: translateY(0) scale(1); }

.dropdown-header { padding: 20px 20px 16px; background: linear-gradient(135deg, rgba(88,101,242,0.2), rgba(255,46,99,0.12)); border-bottom: 1px solid rgba(255,255,255,0.07); display: flex; align-items: center; gap: 14px; }
.dropdown-avatar { width: 52px; height: 52px; border-radius: 50%; background: linear-gradient(135deg, #5865F2, #FF2E63); display: flex; align-items: center; justify-content: center; font-size: 1.3rem; font-weight: 800; color: #fff; text-transform: uppercase; flex-shrink: 0; border: 2px solid rgba(255,255,255,0.15); box-shadow: 0 6px 20px rgba(88,101,242,0.35); overflow: hidden; position: relative; }
.dropdown-avatar img { position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; border-radius: 50%; display: block; }
.dropdown-user-info { display: flex; flex-direction: column; gap: 3px; min-width: 0; }
.dropdown-username { font-size: 0.95rem; font-weight: 700; color: #fff; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.dropdown-role { font-size: 0.75rem; color: rgba(255,255,255,0.5); font-weight: 500; }
.dropdown-online { display: flex; align-items: center; gap: 5px; font-size: 0.72rem; color: #10B981; font-weight: 600; }
.dropdown-online::before { content: ''; width: 7px; height: 7px; border-radius: 50%; background: #10B981; box-shadow: 0 0 6px #10B981; flex-shrink: 0; }
.dropdown-offline { display: flex; align-items: center; gap: 5px; font-size: 0.72rem; color: rgba(255,255,255,0.35); font-weight: 600; }
.dropdown-offline::before { content: ''; width: 7px; height: 7px; border-radius: 50%; background: rgba(255,255,255,0.25); flex-shrink: 0; }
.dropdown-nav { padding: 10px 10px 0; }

.dropdown-item { display: flex; align-items: center; gap: 12px; padding: 11px 14px; border-radius: 12px; text-decoration: none; color: rgba(255,255,255,0.8); font-size: 0.88rem; font-weight: 600; transition: all 0.2s ease; position: relative; overflow: hidden; cursor: pointer; border: none; background: none; width: 100%; text-align: left; }
.dropdown-item::before { content: ''; position: absolute; inset: 0; background: linear-gradient(135deg, rgba(88,101,242,0.12), rgba(255,46,99,0.06)); opacity: 0; transition: opacity 0.2s ease; border-radius: 12px; }
.dropdown-item:hover::before { opacity: 1; }
.dropdown-item:hover { color: #fff; transform: translateX(3px); }
.dropdown-item-icon { width: 34px; height: 34px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1rem; flex-shrink: 0; transition: all 0.3s ease; }
.dropdown-item:hover .dropdown-item-icon { transform: scale(1.1); }
.dropdown-item-icon.profile-icon   { background: linear-gradient(135deg, rgba(88,101,242,0.25), rgba(139,92,246,0.2)); color: #818CF8; }
.dropdown-item-icon.analytics-icon { background: linear-gradient(135deg, rgba(255,46,99,0.2), rgba(255,107,107,0.15)); color: #FF6B6B; }
.dropdown-item-icon.dashboard-icon { background: linear-gradient(135deg, rgba(8,247,254,0.2), rgba(0,201,167,0.15)); color: #08F7FE; }
.dropdown-item-text { display: flex; flex-direction: column; gap: 1px; }
.dropdown-item-label { font-size: 0.88rem; font-weight: 600; color: inherit; }
.dropdown-item-sub { font-size: 0.72rem; color: rgba(255,255,255,0.4); font-weight: 400; }
.dropdown-item:hover .dropdown-item-sub { color: rgba(255,255,255,0.6); }
.dropdown-item-arrow { margin-left: auto; font-size: 0.75rem; color: rgba(255,255,255,0.25); transition: all 0.2s ease; flex-shrink: 0; }
.dropdown-item:hover .dropdown-item-arrow { color: rgba(255,255,255,0.6); transform: translateX(2px); }
.dropdown-divider { height: 1px; background: rgba(255,255,255,0.07); margin: 10px 10px; }
.dropdown-footer { padding: 0 10px 10px; }

.dropdown-logout-btn { display: flex; align-items: center; gap: 12px; padding: 11px 14px; border-radius: 12px; color: rgba(255,80,100,0.9); font-size: 0.88rem; font-weight: 600; transition: all 0.2s ease; cursor: pointer; border: none; background: none; width: 100%; text-align: left; position: relative; overflow: hidden; }
.dropdown-logout-btn::before { content: ''; position: absolute; inset: 0; background: linear-gradient(135deg, rgba(255,46,99,0.15), rgba(255,46,99,0.08)); opacity: 0; transition: opacity 0.2s ease; border-radius: 12px; }
.dropdown-logout-btn:hover::before { opacity: 1; }
.dropdown-logout-btn:hover { color: #FF2E63; transform: translateX(3px); }
.dropdown-logout-icon { width: 34px; height: 34px; border-radius: 10px; background: linear-gradient(135deg, rgba(255,46,99,0.2), rgba(255,107,107,0.12)); display: flex; align-items: center; justify-content: center; font-size: 1rem; color: #FF2E63; flex-shrink: 0; transition: all 0.3s ease; }
.dropdown-logout-btn:hover .dropdown-logout-icon { transform: scale(1.1); background: linear-gradient(135deg, rgba(255,46,99,0.35), rgba(255,107,107,0.2)); }

/* ── Mobile menu ── */
.hamburger { display: none; flex-direction: column; gap: 4px; cursor: pointer; padding: 8px; z-index: 10001; }
.hamburger span { width: 24px; height: 2px; background: #fff; transition: all 0.3s ease; border-radius: 2px; position: relative; }
.hamburger.active span:nth-child(1) { transform: rotate(45deg) translate(6px, 6px); }
.hamburger.active span:nth-child(2) { opacity: 0; }
.hamburger.active span:nth-child(3) { transform: rotate(-45deg) translate(6px, -5px); }

.mobile-menu { position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background: rgba(15,23,42,0.98); backdrop-filter: blur(20px); z-index: 9999; transform: translateX(100%); transition: transform 0.4s cubic-bezier(0.4,0,0.2,1); display: flex; flex-direction: column; padding: 100px 4% 2rem; }
.mobile-menu.active { transform: translateX(0); }
.mobile-nav-links { list-style: none; margin: 0; padding: 0; flex: 1; display: flex; flex-direction: column; gap: 1.5rem; align-items: center; justify-content: center; }
.mobile-nav-link { color: rgba(255,255,255,0.95); text-decoration: none; font-weight: 600; font-size: clamp(1.1rem, 4vw, 1.3rem); padding: 12px 0; transition: all 0.3s ease; }
.mobile-nav-link:hover, .mobile-nav-link.active { color: #fff; transform: translateX(10px); }
.mobile-profile-section { width: 100%; max-width: 340px; margin: 0 auto 2rem auto; display: flex; flex-direction: column; gap: 8px; }
.mobile-profile-header { display: flex; align-items: center; gap: 14px; padding: 16px 20px; background: linear-gradient(135deg, rgba(88,101,242,0.2), rgba(255,46,99,0.12)); border: 1px solid rgba(88,101,242,0.25); border-radius: 18px; margin-bottom: 4px; }
.mobile-profile-avatar { width: 48px; height: 48px; border-radius: 50%; background: linear-gradient(135deg, #5865F2, #FF2E63); display: flex; align-items: center; justify-content: center; font-size: 1.2rem; font-weight: 800; color: #fff; text-transform: uppercase; flex-shrink: 0; border: 2px solid rgba(255,255,255,0.15); overflow: hidden; position: relative; }
.mobile-profile-avatar img { position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; border-radius: 50%; display: block; }
.mobile-profile-info { display: flex; flex-direction: column; gap: 3px; }
.mobile-profile-name { font-size: 1rem; font-weight: 700; color: #fff; }
.mobile-profile-status { display: flex; align-items: center; gap: 5px; font-size: 0.75rem; color: #10B981; font-weight: 600; }
.mobile-profile-status::before { content: ''; width: 7px; height: 7px; border-radius: 50%; background: #10B981; box-shadow: 0 0 6px #10B981; }
.mobile-profile-status.offline { color: rgba(255,255,255,0.35); }
.mobile-profile-status.offline::before { background: rgba(255,255,255,0.25); box-shadow: none; }
.mobile-menu-item { display: flex; align-items: center; gap: 14px; padding: 13px 18px; background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.07); border-radius: 14px; text-decoration: none; color: rgba(255,255,255,0.8); font-size: 0.92rem; font-weight: 600; transition: all 0.2s ease; cursor: pointer; width: 100%; text-align: left; }
.mobile-menu-item:hover { background: rgba(88,101,242,0.15); border-color: rgba(88,101,242,0.3); color: #fff; transform: translateX(4px); }
.mobile-menu-item.logout-item { color: rgba(255,80,100,0.9); border-color: rgba(255,46,99,0.15); background: rgba(255,46,99,0.06); }
.mobile-menu-item.logout-item:hover { background: rgba(255,46,99,0.15); border-color: rgba(255,46,99,0.3); color: #FF2E63; }
.mobile-menu-icon { width: 32px; height: 32px; border-radius: 9px; display: flex; align-items: center; justify-content: center; font-size: 0.95rem; flex-shrink: 0; }
.mobile-menu-icon.p { background: linear-gradient(135deg, rgba(88,101,242,0.25), rgba(139,92,246,0.2)); color: #818CF8; }
.mobile-menu-icon.a { background: linear-gradient(135deg, rgba(255,46,99,0.2), rgba(255,107,107,0.15)); color: #FF6B6B; }
.mobile-menu-icon.d { background: linear-gradient(135deg, rgba(8,247,254,0.2), rgba(0,201,167,0.15)); color: #08F7FE; }
.mobile-menu-icon.l { background: linear-gradient(135deg, rgba(255,46,99,0.2), rgba(255,107,107,0.12)); color: #FF2E63; }

/* ── Logout modal ── */
.modal-backdrop { position: fixed; inset: 0; z-index: 20000; background: rgba(5,8,20,0.82); backdrop-filter: blur(14px); display: flex; align-items: center; justify-content: center; opacity: 0; visibility: hidden; transition: opacity 0.3s ease, visibility 0.3s ease; }
.modal-backdrop.active { opacity: 1; visibility: visible; }
.modal-box { background: rgba(15,23,42,0.98); border: 1px solid rgba(88,101,242,0.35); border-radius: 22px; max-width: 400px; width: calc(100% - 32px); box-shadow: 0 24px 64px rgba(0,0,0,0.6); transform: scale(0.92) translateY(16px); transition: transform 0.35s cubic-bezier(0.34,1.56,0.64,1), opacity 0.3s ease; opacity: 0; overflow: hidden; }
.modal-backdrop.active .modal-box { transform: scale(1) translateY(0); opacity: 1; }
.modal-head { padding: 16px 20px; border-bottom: 1px solid rgba(255,255,255,0.08); display: flex; align-items: center; justify-content: space-between; }
.modal-head.logout-head { background: linear-gradient(135deg, rgba(255,46,99,0.35), rgba(8,247,254,0.2)); }
.modal-head h3 { font-size: 0.95rem; font-weight: 700; color: #fff; text-transform: uppercase; letter-spacing: 0.5px; }
.modal-x { background: none; border: none; color: rgba(255,255,255,0.6); font-size: 1.3rem; cursor: pointer; width: 34px; height: 34px; border-radius: 8px; display: flex; align-items: center; justify-content: center; transition: all 0.2s; flex-shrink: 0; }
.modal-x:hover { background: rgba(255,255,255,0.1); color: #fff; transform: rotate(90deg); }
.modal-body-inner { padding: 28px 24px 10px; text-align: center; }
.modal-title-inner { font-size: 1.05rem; font-weight: 800; color: #fff; margin-bottom: 8px; }
.modal-desc-inner { font-size: 0.85rem; color: rgba(255,255,255,0.55); line-height: 1.6; margin-bottom: 4px; }
.modal-sub { font-size: 0.78rem; color: rgba(255,255,255,0.35); display: block; margin-top: 4px; }
.modal-actions-logout { display: flex; gap: 10px; padding: 18px 24px 24px; }
.btn-modal { flex: 1; padding: 12px; border: none; border-radius: 12px; font-weight: 700; font-size: 0.86rem; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 7px; transition: all 0.25s; }
.btn-modal-cancel { background: rgba(255,255,255,0.07); border: 1.5px solid rgba(255,255,255,0.12); color: rgba(255,255,255,0.8); }
.btn-modal-cancel:hover { background: rgba(255,255,255,0.12); color: #fff; transform: translateY(-1px); }
.btn-modal-logout { background: linear-gradient(135deg,#FF2E63,#08F7FE); color: #000; box-shadow: 0 4px 16px rgba(255,46,99,0.3); }
.btn-modal-logout:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(255,46,99,0.45); }

/* ── Floating action buttons ── */
.floating-add-btn, .floating-delete-all-btn { position: fixed; bottom: 30px; width: 70px; height: 70px; border: none; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 2rem; box-shadow: var(--shadow-xl); cursor: pointer; z-index: 1000; transition: all 0.4s cubic-bezier(0.4,0,0.2,1); }
.floating-add-btn { right: 30px; background: linear-gradient(135deg, var(--accent), var(--primary)); color: #000; animation: float 6s ease-in-out infinite; }
.floating-delete-all-btn { right: 115px; background: linear-gradient(135deg, #ef4444, #ff6b6b); color: #fff; animation: float 6s ease-in-out infinite; animation-delay: 0.5s; }
.floating-add-btn:hover { transform: translateY(-8px) scale(1.1); box-shadow: 0 30px 60px rgba(79,172,254,0.5); animation-play-state: paused; }
.floating-delete-all-btn:hover { transform: translateY(-8px) scale(1.1); box-shadow: 0 30px 60px rgba(239,68,68,0.5); animation-play-state: paused; }
.floating-add-btn:active, .floating-delete-all-btn:active { transform: scale(0.95); }

@keyframes float { 0%, 100% { transform: translateY(0px); } 50% { transform: translateY(-10px); } }

/* ── Hero ── */
.hero-section { min-height: 100vh; width: 100vw; position: relative; left: 50%; right: 50%; margin-left: -50vw; margin-right: -50vw; display: flex; align-items: center; justify-content: center; text-align: center; overflow: hidden; padding-top: 70px; }
.section-bg { position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-size: cover; background-position: center; image-rendering: auto; z-index: 0; }
.hero-bg { background-image: url('/images/miami12.jpg'); background-size: cover; background-position: center; background-repeat: no-repeat; }
.section-overlay { position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 1; background: radial-gradient(circle at 20% 80%, rgba(88,101,242,0.1), transparent 50%), radial-gradient(circle at 80% 20%, rgba(255,46,99,0.07), transparent 50%), rgba(10,15,30,0.45); }
.hero-content { position: relative; z-index: 2; max-width: 900px; padding: 0 4%; animation: fadeInUp 1s ease; width: 100%; box-sizing: border-box; }
.hero-title { font-size: clamp(2.5rem, 8vw, 5rem); font-weight: 900; background: linear-gradient(135deg, #FFFFFF 0%, #F8FAFC 100%); -webkit-background-clip: text; background-clip: text; color: transparent; margin-bottom: 1.2rem; line-height: 1.1; letter-spacing: -0.8px; }
.hero-subtitle { font-size: clamp(1.1rem, 3vw, 1.6rem); color: rgba(255,255,255,0.95); margin-bottom: 2.5rem; font-weight: 400; line-height: 1.6; max-width: 600px; margin-left: auto; margin-right: auto; }
.hero-buttons { display: flex; gap: 1.2rem; justify-content: center; flex-wrap: wrap; }
.btn-hero { padding: clamp(14px, 4vw, 18px) clamp(32px, 6vw, 40px); font-size: clamp(0.95rem, 2.5vw, 1.1rem); font-weight: 700; border-radius: 50px; text-decoration: none; transition: all 0.4s ease; position: relative; overflow: hidden; min-width: clamp(180px, 40vw, 220px); display: inline-flex; align-items: center; justify-content: center; gap: 8px; }
.btn-primary-hero { background: linear-gradient(135deg, #FF2E63 0%, #08F7FE 50%, #5865F2 100%); color: #000; font-weight: 800; box-shadow: 0 12px 30px rgba(255,46,99,0.4); }
.btn-primary-hero:hover { transform: translateY(-4px); box-shadow: 0 20px 40px rgba(255,46,99,0.6); color: #000; }
.btn-secondary-hero { background: rgba(255,255,255,0.1); backdrop-filter: blur(15px); color: #fff; border: 2px solid rgba(255,255,255,0.3); }
.btn-secondary-hero:hover { background: rgba(255,255,255,0.2); transform: translateY(-2px); color: #fff; }

/* ── Layout ── */
.container { max-width: 1440px; margin: 0 auto; padding: 0 2rem; }

.section-title { text-align: center; font-size: clamp(2.5rem, 6vw, 4rem); font-weight: 900; background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 50%, var(--accent) 100%); -webkit-background-clip: text; background-clip: text; color: transparent; margin-bottom: 4rem; letter-spacing: -0.02em; }

.animate-on-scroll { opacity: 0; transform: translateY(30px); transition: opacity 0.6s ease, transform 0.6s ease; }
.animate-on-scroll.visible { opacity: 1; transform: translateY(0); }

/* ── Stats section ── */
.analytics-section { padding: 5rem 0; }
.analytics-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 2rem; }

.stat-card { background: var(--bg-glass); backdrop-filter: blur(20px); border: 1px solid var(--border-light); border-radius: var(--radius-xl); padding: 2.5rem; text-align: center; transition: all 0.4s cubic-bezier(0.4,0,0.2,1); position: relative; overflow: hidden; }
.stat-card::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 4px; background: linear-gradient(90deg, var(--primary), var(--secondary), var(--accent)); }
.stat-card:hover { transform: translateY(-8px); border-color: rgba(79,172,254,0.3); box-shadow: var(--shadow-xl); }
.stat-icon { font-size: 3rem; margin-bottom: 1rem; display: block; background: linear-gradient(135deg, var(--primary), var(--secondary)); -webkit-background-clip: text; background-clip: text; color: transparent; }
.stat-value { font-size: 3rem; font-weight: 900; background: linear-gradient(135deg, var(--accent), var(--primary)); -webkit-background-clip: text; background-clip: text; color: transparent; margin-bottom: 0.5rem; }
.stat-label { color: var(--text-muted); font-size: 1.1rem; font-weight: 600; }

/* ── Categories section ── */
.categories-section { padding: 5rem 0; }
.categories-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 2rem; }

.category-card { background: var(--bg-glass); backdrop-filter: blur(20px); border: 1px solid var(--border-light); border-radius: var(--radius-xl); padding: 2.5rem; text-align: center; transition: all 0.4s cubic-bezier(0.4,0,0.2,1); cursor: pointer; position: relative; overflow: hidden; }
.category-card::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 4px; background: linear-gradient(90deg, var(--primary), var(--secondary), var(--accent)); }
.category-card:hover { transform: translateY(-12px); border-color: rgba(79,172,254,0.3); box-shadow: var(--shadow-xl); }
.category-card.active { border-color: rgba(79,172,254,0.5); box-shadow: 0 20px 40px rgba(79,172,254,0.2); }

.category-icon-wrapper { width: 110px; height: 110px; margin: 0 auto 1.5rem; border-radius: var(--radius-lg); display: flex; align-items: center; justify-content: center; position: relative; overflow: hidden; box-shadow: 0 15px 35px rgba(0,0,0,0.3); transition: all 0.4s ease; }
.category-card:hover .category-icon-wrapper { transform: scale(1.08) rotate(3deg); }
.category-icon-wrapper::before { content: ''; position: absolute; inset: 0; opacity: 0.9; }
.category-icon-wrapper.all::before      { background: linear-gradient(135deg, #4facfe, #00f2fe); }
.category-icon-wrapper.action::before   { background: linear-gradient(135deg, #ff512f, #dd2476); }
.category-icon-wrapper.rpg::before      { background: linear-gradient(135deg, #7f00ff, #e100ff); }
.category-icon-wrapper.shooter::before  { background: linear-gradient(135deg, #fc466b, #3f5efb); }
.category-icon-wrapper.adventure::before{ background: linear-gradient(135deg, #11998e, #38ef7d); }
.category-icon-wrapper.sports::before   { background: linear-gradient(135deg, #ff6b6b, #ffa500); }
.category-icon-wrapper.horror::before   { background: linear-gradient(135deg, #8b0000, #ff4500); }
.category-icon { position: relative; z-index: 2; font-size: 3.5rem; color: white; }
.category-title { font-size: 1.5rem; font-weight: 800; margin-bottom: 1rem; }
.category-count { color: var(--text-muted); font-size: 1.1rem; font-weight: 600; }

/* ── Games section ── */
.games-section { padding: 5rem 0; }
.games-tabs { display: flex; gap: 1rem; justify-content: center; margin-bottom: 3rem; flex-wrap: wrap; }
.tab-btn { padding: 0.75rem 2rem; border: 2px solid var(--border-light); background: var(--bg-glass); backdrop-filter: blur(15px); color: var(--text-muted); border-radius: 50px; font-weight: 600; font-size: 0.95rem; cursor: pointer; transition: all 0.3s ease; }
.tab-btn.active { background: linear-gradient(135deg, var(--accent), var(--primary)); color: #000; border-color: rgba(79,172,254,0.5); box-shadow: 0 10px 30px rgba(79,172,254,0.3); }

.games-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(340px, 1fr)); gap: 2rem; }

/* ── Search bar ── */
.search-wrapper {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    max-width: 560px;
    margin: 0 auto 2.5rem;
    background: rgba(255,255,255,0.06);
    border: 1.5px solid rgba(255,255,255,0.12);
    border-radius: 50px;
    padding: 0 1.25rem;
    transition: border-color 0.3s ease, box-shadow 0.3s ease;
}

.search-wrapper:focus-within {
    border-color: var(--primary);
    box-shadow: 0 0 0 4px rgba(88,101,242,0.18);
    background: rgba(255,255,255,0.09);
}

.search-icon {
    color: rgba(255,255,255,0.4);
    font-size: 1.1rem;
    flex-shrink: 0;
    transition: color 0.3s ease;
}

.search-wrapper:focus-within .search-icon {
    color: var(--primary);
}

.search-input {
    flex: 1;
    background: none;
    border: none;
    outline: none;
    color: #fff;
    font-size: 0.95rem;
    font-weight: 500;
    padding: 14px 0;
    font-family: inherit;
}

.search-input::placeholder {
    color: rgba(255,255,255,0.35);
}

.search-clear {
    display: none;
    align-items: center;
    justify-content: center;
    width: 26px; height: 26px;
    border-radius: 50%;
    background: rgba(255,255,255,0.1);
    border: none;
    color: rgba(255,255,255,0.6);
    font-size: 0.85rem;
    cursor: pointer;
    flex-shrink: 0;
    transition: background 0.2s, color 0.2s;
}

.search-clear:hover {
    background: rgba(255,46,99,0.25);
    color: #FF2E63;
}

.search-wrapper.has-text .search-clear {
    display: flex;
}

/* ── No results state ── */
.no-results-state {
    display: none;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    text-align: center;
    padding: 5rem 2rem;
    grid-column: 1 / -1;
}

.no-results-icon {
    width: 110px; height: 110px;
    border-radius: 28px;
    background: linear-gradient(135deg, rgba(88,101,242,0.15), rgba(255,46,99,0.1));
    border: 1px solid rgba(88,101,242,0.2);
    display: flex; align-items: center; justify-content: center;
    font-size: 3rem;
    margin-bottom: 1.75rem;
    animation: pulse 2.4s ease-in-out infinite;
}

@keyframes pulse {
    0%, 100% { box-shadow: 0 0 0 0 rgba(88,101,242,0.3); }
    50%       { box-shadow: 0 0 0 14px rgba(88,101,242,0); }
}

.no-results-title {
    font-size: 1.6rem;
    font-weight: 800;
    color: #fff;
    margin-bottom: 0.6rem;
}

.no-results-desc {
    color: rgba(255,255,255,0.5);
    font-size: 1rem;
    line-height: 1.6;
    max-width: 380px;
    margin-bottom: 1.5rem;
}

.no-results-term {
    color: var(--accent);
    font-weight: 700;
}

.no-results-btn {
    padding: 12px 28px;
    border-radius: 50px;
    border: none;
    background: linear-gradient(135deg, var(--primary), var(--secondary));
    color: #fff;
    font-weight: 700;
    font-size: 0.9rem;
    cursor: pointer;
    transition: transform 0.25s ease, box-shadow 0.25s ease;
    box-shadow: 0 8px 20px rgba(88,101,242,0.3);
}

.no-results-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 14px 30px rgba(88,101,242,0.45);
}

/* ── Game cards ── */
.game-card { background: var(--bg-glass); backdrop-filter: blur(25px); border: 1px solid var(--border-light); border-radius: var(--radius-xl); overflow: hidden; transition: all 0.4s cubic-bezier(0.4,0,0.2,1); cursor: pointer; height: 100%; display: flex; flex-direction: column; position: relative; }
.game-card:hover { transform: translateY(-10px); box-shadow: var(--shadow-xl); }
.game-cover { width: 100%; height: 220px; object-fit: cover; transition: transform 0.4s ease; }
.game-card:hover .game-cover { transform: scale(1.05); }
.game-content { padding: 2rem; flex: 1; display: flex; flex-direction: column; }
.game-title { font-size: 1.4rem; font-weight: 800; margin-bottom: 0.75rem; line-height: 1.3; }
.game-meta { display: flex; gap: 0.5rem; margin-bottom: 0.75rem; flex-wrap: wrap; align-items: center; }

/* ── Platform tags ── */
.platform-tag { display: inline-flex; align-items: center; gap: 5px; padding: 0.35rem 0.85rem; border-radius: 20px; font-size: 0.78rem; font-weight: 700; letter-spacing: 0.3px; }
.platform-tag.pc     { background: rgba(0,178,255,0.18); color: #00b2ff; border: 1px solid rgba(0,178,255,0.3); }
.platform-tag.ps5    { background: rgba(0,119,203,0.18); color: #4da6ff; border: 1px solid rgba(0,119,203,0.3); }
.platform-tag.ps4    { background: rgba(0,70,160,0.18);  color: #6690e0; border: 1px solid rgba(0,70,160,0.3); }
.platform-tag.xbox   { background: rgba(16,124,16,0.18); color: #52c552; border: 1px solid rgba(16,124,16,0.3); }
.platform-tag.switch { background: rgba(230,0,18,0.18);  color: #ff6070; border: 1px solid rgba(230,0,18,0.3); }
.platform-tag.mobile { background: rgba(255,149,0,0.18); color: #ffa040; border: 1px solid rgba(255,149,0,0.3); }
.platform-tag.default{ background: rgba(102,126,234,0.2); color: #fff; border: 1px solid rgba(102,126,234,0.3); }
.platform-tag svg { flex-shrink: 0; }

/* ── Category badges ── */
.game-categories { display: flex; gap: 0.4rem; margin-bottom: 1.2rem; flex-wrap: wrap; }

.cat-badge { display: inline-flex; align-items: center; gap: 5px; padding: 0.28rem 0.75rem; border-radius: 999px; font-size: 0.72rem; font-weight: 700; letter-spacing: 0.3px; text-transform: uppercase; }
.cat-badge.action    { background: rgba(255,81,47,0.18);  color: #ff8c6b; border: 1px solid rgba(255,81,47,0.35); }
.cat-badge.rpg       { background: rgba(127,0,255,0.18);  color: #c97fff; border: 1px solid rgba(127,0,255,0.35); }
.cat-badge.shooter   { background: rgba(252,70,107,0.18); color: #ff8faa; border: 1px solid rgba(252,70,107,0.35); }
.cat-badge.adventure { background: rgba(17,153,142,0.18); color: #56e0d6; border: 1px solid rgba(17,153,142,0.35); }
.cat-badge.sports    { background: rgba(255,165,0,0.18);  color: #ffc04d; border: 1px solid rgba(255,165,0,0.35); }
.cat-badge.horror    { background: rgba(139,0,0,0.25);    color: #ff6b6b; border: 1px solid rgba(139,0,0,0.45); }
.cat-badge i { font-size: 0.68rem; }

/* ── Card stats row ── */
.game-stats { display: flex; gap: 1.5rem; margin-top: auto; }
.stat-item { display: flex; flex-direction: column; align-items: center; flex: 1; }
.stat-item .stat-value { font-size: 1.2rem; font-weight: 800; color: var(--text-light); background: none; -webkit-background-clip: unset; background-clip: unset; -webkit-text-fill-color: unset; margin-bottom: 0; }
.stat-item .stat-label { font-size: 0.8rem; color: var(--text-muted); margin-top: 0.25rem; }

/* ── Card actions ── */
.game-actions { display: flex; gap: 0.75rem; margin-top: 1rem; opacity: 0; transform: translateY(10px); transition: all 0.3s cubic-bezier(0.4,0,0.2,1); }
.game-card:hover .game-actions { opacity: 1; transform: translateY(0); }
.btn-action { flex: 1; padding: 0.75rem; border-radius: var(--radius-sm); font-weight: 600; font-size: 0.85rem; border: none; cursor: pointer; transition: all 0.3s ease; display: flex; align-items: center; justify-content: center; gap: 0.5rem; }
.btn-edit   { background: rgba(34,197,94,0.2); color: #22c55e; border: 1px solid rgba(34,197,94,0.3); }
.btn-edit:hover   { background: rgba(34,197,94,0.3); transform: translateY(-1px); }
.btn-delete { background: rgba(239,68,68,0.2); color: #ef4444; border: 1px solid rgba(239,68,68,0.3); }
.btn-delete:hover { background: rgba(239,68,68,0.3); transform: translateY(-1px); }

/* ── Add/Edit game modal ── */
.add-game-modal, .confirm-delete-modal, .confirm-delete-all-modal { position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background: rgba(0,0,0,0.8); backdrop-filter: blur(15px); z-index: 10001; display: flex; align-items: center; justify-content: center; opacity: 0; visibility: hidden; transition: all 0.4s cubic-bezier(0.4,0,0.2,1); }
.add-game-modal.active, .confirm-delete-modal.active, .confirm-delete-all-modal.active { opacity: 1; visibility: visible; }

.modal-content, .confirm-modal-content { background: rgba(15,23,42,0.98); backdrop-filter: blur(40px); border: 1px solid var(--border-light); border-radius: var(--radius-xl); max-width: 90vw; max-height: 90vh; width: 600px; transform: scale(0.8) translateY(30px); transition: all 0.4s cubic-bezier(0.4,0,0.2,1); overflow: hidden; }
.add-game-modal.active .modal-content, .confirm-delete-modal.active .confirm-modal-content, .confirm-delete-all-modal.active .confirm-modal-content { transform: scale(1) translateY(0); }

.modal-header { display: flex; align-items: center; justify-content: space-between; padding: 2rem 2rem 1rem; border-bottom: 1px solid rgba(255,255,255,0.08); }
.modal-title { font-size: 1.8rem; font-weight: 800; background: linear-gradient(135deg, var(--primary), var(--secondary), var(--accent)); -webkit-background-clip: text; background-clip: text; color: transparent; }
.modal-close { width: 42px; height: 42px; border: none; border-radius: 12px; background: rgba(255,255,255,0.08); color: #fff; font-size: 1.5rem; cursor: pointer; transition: all 0.3s ease; }
.modal-close:hover { background: rgba(255,255,255,0.15); transform: rotate(90deg); }
.modal-body { padding: 2rem; max-height: 70vh; overflow-y: auto; }
.form-group { margin-bottom: 1.5rem; }
.form-label { display: block; margin-bottom: 0.7rem; font-weight: 700; color: rgba(255,255,255,0.9); }
.form-input { width: 100%; padding: 14px 18px; border-radius: 16px; border: 1px solid rgba(255,255,255,0.1); background: rgba(255,255,255,0.06); backdrop-filter: blur(10px); color: #fff; font-size: 0.95rem; transition: all 0.3s ease; }
.form-input::placeholder { color: rgba(255,255,255,0.4); }
.form-input:focus { outline: none; border-color: var(--primary); box-shadow: 0 0 0 4px rgba(88,101,242,0.2); background: rgba(255,255,255,0.1); }

/* ── Chips (platforms & categories) ── */
.category-chips, .platform-chips { display: flex; flex-wrap: wrap; gap: 0.8rem; }

.chip { padding: 0.7rem 1.2rem; border-radius: 999px; background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.08); color: rgba(255,255,255,0.8); cursor: pointer; transition: all 0.3s ease; font-weight: 600; display: inline-flex; align-items: center; gap: 7px; user-select: none; }
.chip:hover { transform: translateY(-2px); background: rgba(255,255,255,0.12); }
.chip.active { background: linear-gradient(135deg, var(--accent), var(--primary)); color: #000; border-color: transparent; box-shadow: 0 10px 20px rgba(88,101,242,0.3); }

.chip[data-category="action"].active   { background: linear-gradient(135deg, #ff512f, #dd2476); color: #fff; border-color: transparent; }
.chip[data-category="rpg"].active      { background: linear-gradient(135deg, #7f00ff, #e100ff); color: #fff; border-color: transparent; }
.chip[data-category="shooter"].active  { background: linear-gradient(135deg, #fc466b, #3f5efb); color: #fff; border-color: transparent; }
.chip[data-category="adventure"].active{ background: linear-gradient(135deg, #11998e, #38ef7d); color: #000; border-color: transparent; }
.chip[data-category="sports"].active   { background: linear-gradient(135deg, #ff6b6b, #ffa500); color: #000; border-color: transparent; }
.chip[data-category="horror"].active   { background: linear-gradient(135deg, #8b0000, #ff4500); color: #fff; border-color: transparent; }

.chip[data-platform="PC"].active     { background: linear-gradient(135deg, #00b2ff, #0066cc); color: #fff; }
.chip[data-platform="PS5"].active    { background: linear-gradient(135deg, #4da6ff, #0077cb); color: #fff; }
.chip[data-platform="PS4"].active    { background: linear-gradient(135deg, #6690e0, #0046a0); color: #fff; }
.chip[data-platform="Xbox"].active   { background: linear-gradient(135deg, #52c552, #107c10); color: #fff; }
.chip[data-platform="Switch"].active { background: linear-gradient(135deg, #ff6070, #e60012); color: #fff; }
.chip[data-platform="Mobile"].active { background: linear-gradient(135deg, #ffa040, #ff9500); color: #000; }
.chip svg { flex-shrink: 0; }

.form-hint { font-size: 0.75rem; color: rgba(255,255,255,0.35); margin-top: 0.5rem; }

.modal-actions { display: flex; justify-content: flex-end; gap: 1rem; padding: 1.5rem 2rem 2rem; border-top: 1px solid rgba(255,255,255,0.08); }
.btn-primary, .btn-secondary { padding: 14px 24px; border-radius: 16px; border: none; font-weight: 700; cursor: pointer; transition: all 0.3s ease; font-size: 0.95rem; }
.btn-primary { background: linear-gradient(135deg, var(--accent), var(--primary)); color: #000; box-shadow: 0 12px 25px rgba(88,101,242,0.3); }
.btn-primary:hover { transform: translateY(-3px); box-shadow: 0 18px 35px rgba(88,101,242,0.4); }
.btn-secondary { background: rgba(255,255,255,0.08); color: #fff; border: 1px solid rgba(255,255,255,0.1); }
.btn-secondary:hover { background: rgba(255,255,255,0.12); transform: translateY(-2px); }
.modal-body::-webkit-scrollbar { width: 8px; }
.modal-body::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.15); border-radius: 10px; }

/* ── Delete confirmation modal ── */
.confirm-modal-content { width: 420px; padding: 2.5rem; text-align: center; box-shadow: 0 25px 50px rgba(0,0,0,0.4), 0 0 0 1px rgba(255,255,255,0.03); position: relative; }
.confirm-modal-content::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 4px; background: linear-gradient(90deg, #ef4444, #ff6b6b, #ff9966); }
.confirm-icon { width: 90px; height: 90px; margin: 0 auto 1.5rem; border-radius: 24px; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, rgba(239,68,68,0.2), rgba(255,107,107,0.15)); border: 1px solid rgba(239,68,68,0.25); box-shadow: 0 20px 40px rgba(239,68,68,0.15); }
.confirm-icon i { font-size: 3rem; color: #ef4444; }
.confirm-title { font-size: 2rem; font-weight: 800; color: #fff; margin-bottom: 1rem; }
.confirm-text { color: rgba(255,255,255,0.7); line-height: 1.7; margin-bottom: 2rem; font-size: 1rem; }
.confirm-game-title { color: #fff; font-weight: 800; }
#confirmDelete, #confirmDeleteAll { background: linear-gradient(135deg, #ef4444, #ff6b6b); color: white; border: none; box-shadow: 0 15px 30px rgba(239,68,68,0.3); }
#confirmDelete:hover, #confirmDeleteAll:hover { transform: translateY(-3px); box-shadow: 0 20px 40px rgba(239,68,68,0.45); }

/* ── Toast ── */
.welcome-toast { position: fixed; top: 100px; right: 25px; background: rgba(20,20,30,0.95); border: 1px solid rgba(255,255,255,0.1); backdrop-filter: blur(14px); padding: 18px 22px; border-radius: 18px; min-width: 320px; z-index: 99999; transform: translateX(120%); opacity: 0; transition: transform .5s ease, opacity .5s ease; box-shadow: 0 10px 35px rgba(0,0,0,.35), 0 0 25px rgba(88,101,242,.25); }
.welcome-toast.show { transform: translateX(0); opacity: 1; }
.toast-content { display: flex; align-items: center; gap: 14px; }
.toast-content i { font-size: 2rem; }
.toast-content i.success { color: #10B981; }
.toast-content i.error   { color: #EF4444; }
.toast-text { display: flex; flex-direction: column; }
.toast-text strong { color: #fff; font-size: 1rem; }
.toast-text span { color: #d4d4d8; font-size: .9rem; margin-top: 2px; }

/* ── Animations ── */
.game-card.removing { animation: slideOut 0.4s cubic-bezier(0.4,0,0.2,1) forwards; }
@keyframes slideOut { 0% { opacity: 1; transform: translateY(0) scale(1); } 100% { opacity: 0; transform: translateY(-20px) scale(0.95); } }
@keyframes fadeInUp { from { opacity: 0; transform: translateY(40px); } to { opacity: 1; transform: translateY(0); } }

/* ── Footer ── */
.footer { width: 100vw; position: relative; left: 50%; right: 50%; margin-left: -50vw; margin-right: -50vw; background: linear-gradient(180deg, rgba(15,23,42,0.98) 0%, rgba(10,15,30,1) 100%); backdrop-filter: blur(20px); border-top: 2px solid rgba(88,101,242,0.3); padding: 3rem 0 0; margin-top: 2rem; overflow: hidden; }
.footer::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 1px; background: linear-gradient(90deg, transparent, var(--primary), var(--secondary), var(--accent), transparent); }
.footer-content { max-width: 1400px; margin: 0 auto; padding: 0 2rem; position: relative; z-index: 2; }
.footer-top { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 2rem; margin-bottom: 2rem; }
.footer-brand { display: flex; flex-direction: column; gap: 1rem; }
.footer-brand h3 { font-size: clamp(1.6rem, 4vw, 2rem); font-weight: 900; background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 50%, var(--accent) 100%); -webkit-background-clip: text; background-clip: text; color: transparent; margin: 0 0 0.5rem 0; letter-spacing: -0.5px; }
.footer-brand p { color: rgba(255,255,255,0.85); line-height: 1.7; font-size: clamp(0.95rem, 2.2vw, 1.05rem); margin: 0; }
.newsletter-input { width: 100%; padding: 14px 20px; background: rgba(255,255,255,0.06); backdrop-filter: blur(20px); border: 2px solid rgba(255,255,255,0.12); border-radius: var(--radius-md); color: #fff; font-size: 0.95rem; font-weight: 500; transition: all 0.3s cubic-bezier(0.4,0,0.2,1); margin-top: 1rem; }
.newsletter-input::placeholder { color: rgba(255,255,255,0.5); }
.newsletter-input:focus { outline: none; border-color: var(--primary); background: rgba(255,255,255,0.1); box-shadow: 0 0 0 4px rgba(88,101,242,0.15); transform: translateY(-1px); }
.footer-section h4 { color: #fff; font-weight: 800; font-size: clamp(1.05rem, 2.5vw, 1.2rem); margin: 0 0 1.5rem 0; padding-bottom: 0.5rem; position: relative; }
.footer-section h4::after { content: ''; position: absolute; bottom: 0; left: 0; width: 40px; height: 2px; background: linear-gradient(90deg, var(--primary), var(--secondary)); border-radius: 1px; }
.footer-links { display: flex; flex-direction: column; gap: 0.75rem; list-style: none; padding: 0; margin: 0; }
.footer-link { color: rgba(255,255,255,0.85); text-decoration: none; font-weight: 500; font-size: 0.95rem; padding: 8px 0 8px 4px; transition: all 0.3s ease; position: relative; border-radius: 8px; display: block; }
.footer-link::before { content: ''; position: absolute; left: 0; top: 50%; width: 0; height: 2px; background: linear-gradient(90deg, var(--primary), var(--secondary)); transition: width 0.3s ease; transform: translateY(-50%); border-radius: 1px; }
.footer-link:hover { color: #fff; padding-left: 12px; background: rgba(255,255,255,0.05); }
.footer-link:hover::before { width: 6px; }
.footer-bottom { border-top: 1px solid rgba(255,255,255,0.08); padding: 1.5rem 0; display: flex; flex-direction: column; align-items: center; gap: 1rem; text-align: center; }
.footer-bottom-left { color: rgba(255,255,255,0.6); font-size: 0.9rem; font-weight: 500; margin: 0; letter-spacing: 0.5px; }
.footer-bottom-right { display: flex; gap: 1rem; margin: 0; padding: 0; }
.social-link { width: 48px; height: 48px; border-radius: 16px; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; color: #fff; transition: all 0.3s cubic-bezier(0.4,0,0.2,1); box-shadow: 0 8px 25px rgba(0,0,0,0.3); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.1); flex-shrink: 0; }
.social-link.fb { background: linear-gradient(135deg, #1877F2, #0E5A8A); }
.social-link.ig { background: linear-gradient(135deg, #E4405F, #F77737, #8338EC); }
.social-link.x  { background: linear-gradient(135deg, #000000, #1D9BF0); }
.social-link.tg { background: linear-gradient(135deg, #0088CC, #00BFFF); }
.social-link:hover { transform: translateY(-4px) scale(1.08); box-shadow: 0 15px 35px rgba(88,101,242,0.4); border-color: rgba(88,101,242,0.3); }

/* ── Responsive ── */
@media (max-width: 1024px) {
    .games-grid { grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 1.5rem; }
    .analytics-grid, .categories-grid { grid-template-columns: repeat(2, 1fr); gap: 1.5rem; }
    .profile-dropdown { position: fixed; top: 65px; right: 0; left: 0; width: 100vw; border-radius: 0 0 20px 20px; border-top: none; transform-origin: top center; max-height: calc(100vh - 65px); overflow-y: auto; }
}

@media (max-width: 768px) {
    .navbar-landing { padding: 0 3%; height: 65px; }
    .navbar-scrolled { height: 60px; }
    .nav-links { display: none; }
    .hamburger { display: flex; }
    .auth-buttons { display: flex; align-items: center; margin-left: auto; margin-right: 0.5rem; }
    .nav-container { justify-content: space-between; gap: 0; }
    .profile-btn { width: 46px; height: 46px; font-size: 1.15rem; }
    .profile-dropdown { position: fixed; top: 65px; right: 0; left: 0; width: 100vw; border-radius: 0 0 20px 20px; border-top: none; transform-origin: top center; max-height: calc(100vh - 65px); overflow-y: auto; }
    .dropdown-header { padding: 16px 20px; }
    .dropdown-avatar { width: 44px; height: 44px; font-size: 1.1rem; }
    .dropdown-nav { padding: 6px 10px 0; }
    .dropdown-footer { padding: 0 10px 10px; }
    .mobile-profile-section { display: none; }
    .games-grid, .categories-grid, .analytics-grid { grid-template-columns: 1fr; gap: 1.5rem; }
    .games-tabs { flex-direction: column; align-items: center; }
    .tab-btn { width: 100%; max-width: 300px; justify-content: center; }
    .search-wrapper { max-width: 100%; }
    .welcome-toast { top: 75px; right: 12px; left: 12px; min-width: auto; }
    .game-actions { flex-direction: column; opacity: 1; transform: translateY(0); }
    .btn-action { padding: 1rem; font-size: 1rem; }
    .floating-add-btn { bottom: 20px; right: 20px; width: 60px; height: 60px; font-size: 1.8rem; }
    .floating-delete-all-btn { bottom: 20px; right: 95px; width: 60px; height: 60px; font-size: 1.6rem; }
    .modal-content { width: 95vw; max-height: 90vh; }
    .modal-header, .modal-body, .modal-actions { padding-left: 1.2rem; padding-right: 1.2rem; }
    .modal-actions { flex-direction: column; }
    .btn-primary, .btn-secondary { width: 100%; }
    .confirm-modal-content { width: 95vw; padding: 2rem 1.5rem; }
    .footer { padding: 2rem 0 0; margin-top: 1rem; }
    .footer-content { padding: 0 1rem; }
    .footer-top { grid-template-columns: 1fr; gap: 1.5rem; text-align: center; }
    .footer-section h4::after { left: 50%; transform: translateX(-50%); }
    .footer-bottom-right { justify-content: center; }
    .social-link { width: 44px; height: 44px; font-size: 1.1rem; }
    .hero-buttons { flex-direction: column; align-items: center; }
    .btn-hero { width: 100%; max-width: 300px; }
    .modal-actions-logout { flex-direction: column; }
}

@media (max-width: 480px) {
    .container { padding: 0 1rem; }
    .section-title { font-size: 2rem; margin-bottom: 2rem; }
    .hero-title { font-size: clamp(2rem, 10vw, 3rem); }
    .hero-subtitle { font-size: 1.2rem; }
    .category-card { padding: 2rem 1.5rem; }
    .game-content { padding: 1.5rem; }
    .stat-card { padding: 2rem 1.5rem; }
    .nav-container { padding: 0 12px; }
    .logo { font-size: 1.35rem; }
    .profile-btn { width: 42px; height: 42px; font-size: 1.05rem; }
    .profile-dropdown { top: 60px; max-height: calc(100vh - 60px); }
    .dropdown-item-sub { display: none; }
    .footer { padding: 1.5rem 0 0; }
    .footer-top { gap: 1rem; }
}
</style>

<div class="modal-backdrop" id="logoutModalBackdrop">
    <div class="modal-box">
        <div class="modal-head logout-head">
            <h3>Confirm Logout</h3>
            <button class="modal-x" onclick="closeLogoutModal()">&#10005;</button>
        </div>
        <div class="modal-body-inner">
            <div style="width:68px;height:68px;border-radius:50%;margin:0 auto 16px;display:flex;align-items:center;justify-content:center;">
                <i class="bi bi-box-arrow-left" style="font-size:2.8rem;background:linear-gradient(135deg,#FF2E63,#08F7FE);-webkit-background-clip:text;background-clip:text;color:transparent;"></i>
            </div>
            <div class="modal-title-inner">Log out of Pixel Forge?</div>
            <div class="modal-desc-inner">Are you sure you want to log out?</div>
            <span class="modal-sub">You will need to sign in again to access your account.</span>
        </div>
        <div class="modal-actions-logout">
            <button class="btn-modal btn-modal-cancel" onclick="closeLogoutModal()" type="button">Stay</button>
            <button class="btn-modal btn-modal-logout" onclick="document.getElementById('logoutForm').submit()" type="button">
                <i class="bi bi-box-arrow-left"></i> Logout
            </button>
        </div>
    </div>
</div>

<form method="POST" action="{{ route('logout') }}" id="logoutForm" style="display:none;">
    @csrf
</form>

<nav class="navbar-landing" id="navbar">
    <div class="nav-container">
        <a href="/landing" class="logo">Pixel Forge</a>
        <ul class="nav-links">
            <li><a href="/landing"  class="nav-link">Home</a></li>
            <li><a href="/about"    class="nav-link">About</a></li>
            <li><a href="/games"    class="nav-link active">Games</a></li>
            <li><a href="/contacts" class="nav-link">Contacts</a></li>
        </ul>
        <div class="auth-buttons">
            <div class="profile-menu-wrapper" id="profileMenuWrapper">
                <button class="profile-btn" id="profileBtn" type="button" aria-label="Profile menu" aria-expanded="false">
                    @if(auth()->user()->avatar)
                        <img src="{{ str_starts_with(auth()->user()->avatar, 'http') ? auth()->user()->avatar : asset('storage/uploads/' . auth()->user()->avatar) }}" alt="{{ auth()->user()->name }}">
                    @else
                        {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                    @endif
                </button>
                <div class="profile-dropdown" id="profileDropdown" role="menu">
                    <div class="dropdown-header">
                        <div class="dropdown-avatar">
                            @if(auth()->user()->avatar)
                                <img src="{{ str_starts_with(auth()->user()->avatar, 'http') ? auth()->user()->avatar : asset('storage/uploads/' . auth()->user()->avatar) }}" alt="{{ auth()->user()->name }}">
                            @else
                                {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                            @endif
                        </div>
                        <div class="dropdown-user-info">
                            <span class="dropdown-username">{{ auth()->user()->name ?? 'User' }}</span>
                            <span class="dropdown-role">{{ auth()->user()->email ?? '' }}</span>
                            @if(auth()->user()->isOnline())
                                <span class="dropdown-online">Online</span>
                            @else
                                <span class="dropdown-offline">Offline</span>
                            @endif
                        </div>
                    </div>
                    <div class="dropdown-nav">
                        <a href="/profile" class="dropdown-item" role="menuitem">
                            <span class="dropdown-item-icon profile-icon"><i class="bi bi-person-circle"></i></span>
                            <span class="dropdown-item-text">
                                <span class="dropdown-item-label">Profile</span>
                                <span class="dropdown-item-sub">View &amp; edit your profile</span>
                            </span>
                            <i class="bi bi-chevron-right dropdown-item-arrow"></i>
                        </a>
                        <a href="/analytics" class="dropdown-item" role="menuitem">
                            <span class="dropdown-item-icon analytics-icon"><i class="bi bi-bar-chart-line"></i></span>
                            <span class="dropdown-item-text">
                                <span class="dropdown-item-label">Analytics</span>
                                <span class="dropdown-item-sub">Your gaming insights</span>
                            </span>
                            <i class="bi bi-chevron-right dropdown-item-arrow"></i>
                        </a>
                        <a href="/dashboard" class="dropdown-item" role="menuitem">
                            <span class="dropdown-item-icon dashboard-icon"><i class="bi bi-grid-1x2"></i></span>
                            <span class="dropdown-item-text">
                                <span class="dropdown-item-label">Dashboard</span>
                                <span class="dropdown-item-sub">Overview &amp; quick actions</span>
                            </span>
                            <i class="bi bi-chevron-right dropdown-item-arrow"></i>
                        </a>
                    </div>
                    <div class="dropdown-divider"></div>
                    <div class="dropdown-footer">
                        <button class="dropdown-logout-btn" type="button" onclick="closeProfileDropdown(); openLogoutModal();" role="menuitem">
                            <span class="dropdown-logout-icon"><i class="bi bi-box-arrow-left"></i></span>
                            <span class="dropdown-item-text">
                                <span class="dropdown-item-label">Logout</span>
                                <span class="dropdown-item-sub" style="color:rgba(255,80,100,0.5);">Sign out of your account</span>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="hamburger" id="hamburger">
            <span></span><span></span><span></span>
        </div>
    </div>
</nav>

<div class="mobile-menu" id="mobileMenu">
    <ul class="mobile-nav-links">
        <li><a href="/landing"  class="mobile-nav-link">Home</a></li>
        <li><a href="/about"    class="mobile-nav-link">About</a></li>
        <li><a href="/games"    class="mobile-nav-link active">Games</a></li>
        <li><a href="/contacts" class="mobile-nav-link">Contacts</a></li>
    </ul>
    <div class="mobile-profile-section">
        <div class="mobile-profile-header">
            <div class="mobile-profile-avatar">
                @if(auth()->user()->avatar)
                    <img src="{{ str_starts_with(auth()->user()->avatar, 'http') ? auth()->user()->avatar : asset('storage/uploads/' . auth()->user()->avatar) }}" alt="{{ auth()->user()->name }}">
                @else
                    {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                @endif
            </div>
            <div class="mobile-profile-info">
                <span class="mobile-profile-name">{{ auth()->user()->name ?? 'User' }}</span>
                @if(auth()->user()->isOnline())
                    <span class="mobile-profile-status">Online</span>
                @else
                    <span class="mobile-profile-status offline">Offline</span>
                @endif
            </div>
        </div>
        <a href="/profile" class="mobile-menu-item">
            <span class="mobile-menu-icon p"><i class="bi bi-person-circle"></i></span>
            Profile
        </a>
        <a href="/analytics" class="mobile-menu-item">
            <span class="mobile-menu-icon a"><i class="bi bi-bar-chart-line"></i></span>
            Analytics
        </a>
        <a href="/dashboard" class="mobile-menu-item">
            <span class="mobile-menu-icon d"><i class="bi bi-grid-1x2"></i></span>
            Dashboard
        </a>
        <button type="button" class="mobile-menu-item logout-item" onclick="openLogoutModal()">
            <span class="mobile-menu-icon l"><i class="bi bi-box-arrow-left"></i></span>
            Logout
        </button>
    </div>
</div>

<button class="floating-delete-all-btn" id="deleteAllBtn" title="Delete All Games">
    <i class="bi bi-trash3-fill"></i>
</button>
<button class="floating-add-btn" id="addGameBtn" title="Add New Game">
    <i class="bi bi-plus-lg"></i>
</button>

<section class="hero-section">
    <div class="section-bg hero-bg"></div>
    <div class="section-overlay"></div>
    <div class="hero-content">
        <h1 class="hero-title">Your Ultimate Game Collection</h1>
        <p class="hero-subtitle">
            Track your gaming journey, discover new titles, and showcase your achievements
            with the most beautiful game collection manager.
        </p>
        <div class="hero-buttons">
            <a href="#games" class="btn-hero btn-primary-hero">See Games</a>
            <a href="#categories" class="btn-hero btn-secondary-hero">Browse Categories</a>
        </div>
    </div>
</section>

<section class="analytics-section">
    <div class="container">
        <h2 class="section-title animate-on-scroll">Your Stats</h2>
        <div class="analytics-grid">
            <div class="stat-card animate-on-scroll">
                <i class="bi bi-trophy stat-icon"></i>
                <div class="stat-value" id="totalGames">0</div>
                <div class="stat-label">Total Games</div>
            </div>
            <div class="stat-card animate-on-scroll">
                <i class="bi bi-check-circle stat-icon"></i>
                <div class="stat-value" id="completedGames">0</div>
                <div class="stat-label">Completed</div>
            </div>
            <div class="stat-card animate-on-scroll">
                <i class="bi bi-clock stat-icon"></i>
                <div class="stat-value" id="totalPlaytime">0h</div>
                <div class="stat-label">Days Played</div>
            </div>
            <div class="stat-card animate-on-scroll">
                <i class="bi bi-star-fill stat-icon"></i>
                <div class="stat-value" id="avgRating">0.0</div>
                <div class="stat-label">Avg Rating</div>
            </div>
        </div>
    </div>
</section>

<section class="categories-section" id="categories">
    <div class="container">
        <div class="categories-grid" id="categoriesGrid">
            <div class="category-card animate-on-scroll active" data-category="all">
                <div class="category-icon-wrapper all"><i class="bi bi-grid-fill category-icon"></i></div>
                <h3 class="category-title">All Games</h3>
                <div class="category-count" data-count="all">0 games</div>
            </div>
            <div class="category-card animate-on-scroll" data-category="action">
                <div class="category-icon-wrapper action"><i class="bi bi-lightning-charge-fill category-icon"></i></div>
                <h3 class="category-title">Action</h3>
                <div class="category-count" data-count="action">0 games</div>
            </div>
            <div class="category-card animate-on-scroll" data-category="rpg">
                <div class="category-icon-wrapper rpg"><i class="bi bi-shield-fill category-icon"></i></div>
                <h3 class="category-title">RPG</h3>
                <div class="category-count" data-count="rpg">0 games</div>
            </div>
            <div class="category-card animate-on-scroll" data-category="shooter">
                <div class="category-icon-wrapper shooter"><i class="bi bi-bullseye category-icon"></i></div>
                <h3 class="category-title">Shooter</h3>
                <div class="category-count" data-count="shooter">0 games</div>
            </div>
            <div class="category-card animate-on-scroll" data-category="adventure">
                <div class="category-icon-wrapper adventure"><i class="bi bi-globe-americas category-icon"></i></div>
                <h3 class="category-title">Adventure</h3>
                <div class="category-count" data-count="adventure">0 games</div>
            </div>
            <div class="category-card animate-on-scroll" data-category="sports">
                <div class="category-icon-wrapper sports"><i class="bi bi-basket-fill category-icon"></i></div>
                <h3 class="category-title">Sports</h3>
                <div class="category-count" data-count="sports">0 games</div>
            </div>
            <div class="category-card animate-on-scroll" data-category="horror">
                <div class="category-icon-wrapper horror"><i class="bi bi-moon-stars-fill category-icon"></i></div>
                <h3 class="category-title">Horror</h3>
                <div class="category-count" data-count="horror">0 games</div>
            </div>
        </div>
    </div>
</section>

<section class="games-section" id="games">
    <div class="container">
        <div class="games-tabs" id="gamesTabs">
            <button class="tab-btn active" data-tab="all">All Games</button>
            <button class="tab-btn" data-tab="action">Action</button>
            <button class="tab-btn" data-tab="rpg">RPG</button>
            <button class="tab-btn" data-tab="shooter">Shooter</button>
            <button class="tab-btn" data-tab="adventure">Adventure</button>
            <button class="tab-btn" data-tab="sports">Sports</button>
            <button class="tab-btn" data-tab="horror">Horror</button>
        </div>
        <div class="search-wrapper" id="searchWrapper">
            <i class="bi bi-search search-icon"></i>
            <input
                type="text"
                class="search-input"
                id="gameSearchInput"
                placeholder="Search your games…"
                autocomplete="off"
                spellcheck="false"
            >
            <button class="search-clear" id="searchClearBtn" type="button" aria-label="Clear search">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
        <div class="games-grid" id="gamesGrid"></div>
        <div class="no-results-state" id="noResultsState">
            <div class="no-results-icon">
                <i class="bi bi-controller" style="background:linear-gradient(135deg,var(--primary),var(--secondary));-webkit-background-clip:text;background-clip:text;color:transparent;"></i>
            </div>
            <h3 class="no-results-title">No games found</h3>
            <p class="no-results-desc">
                We couldn't find any games matching
                "<span class="no-results-term" id="noResultsTerm"></span>".
                Try a different search term or clear the filter.
            </p>
            <button class="no-results-btn" id="noResultsClearBtn" type="button">
                <i class="bi bi-arrow-counterclockwise"></i> Show all games
            </button>
        </div>
    </div>
</section>

<div class="add-game-modal" id="addGameModal">
    <div class="modal-content">
        <div class="modal-header">
            <h2 class="modal-title" id="modalTitle">Add New Game</h2>
            <button class="modal-close" id="closeAddModal">&times;</button>
        </div>
        <div class="modal-body">
            <form id="addGameForm">
                <div class="form-group">
                    <label class="form-label">Game Title</label>
                    <input type="text" class="form-input" id="gameTitle" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Cover Image URL</label>
                    <input type="url" class="form-input" id="gameCover" placeholder="https://...">
                </div>
                <div class="form-group">
                    <label class="form-label">Platforms</label>
                    <div class="platform-chips" id="platformChips">
                        <span class="chip" data-platform="PC"><svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M20 18c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2H4c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2H0v2h24v-2h-4zM4 6h16v10H4V6z"/></svg>PC</span>
                        <span class="chip" data-platform="PS5"><svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M9.5 15.5v-7l9.5 3.5-9.5 3.5zm-3 2.5V6l2 .7v4.3L5 10.5V8l-2-.7V18l3.5-2zm14.5-1l-3 1.1V6.9L21 8v9z"/></svg>PS5</span>
                        <span class="chip" data-platform="PS4"><svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M9.5 15.5v-7l9.5 3.5-9.5 3.5zm-3 2.5V6l2 .7v4.3L5 10.5V8l-2-.7V18l3.5-2zm14.5-1l-3 1.1V6.9L21 8v9z"/></svg>PS4</span>
                        <span class="chip" data-platform="Xbox"><svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M4.1 4.1C5.9 2.4 8.3 1.3 11 1.1c-1.5 1.4-2.8 3.2-3.8 5.2C5.7 7.4 4.8 8.9 4.1 10c-.9-2-.8-4.2 0-5.9zm15.8 0c.8 1.7.9 3.9 0 5.9-.7-1.1-1.6-2.6-3.1-3.7-1-2-2.3-3.8-3.8-5.2 2.7.2 5.1 1.3 6.9 3zm-11 16.9c-2.3-1.6-4.5-4.2-5.4-7.3.5.7 1.1 1.4 1.9 2.1 1.4 1.2 2.9 2.1 4.5 2.7l-1 2.5zm6.2 0l-1-2.5c1.6-.6 3.1-1.5 4.5-2.7.8-.7 1.4-1.4 1.9-2.1-.9 3.1-3.1 5.7-5.4 7.3zM12 7c-1.7 0-5 4.1-5 8s2.2 5 5 5 5-1.1 5-5-3.3-8-5-8z"/></svg>Xbox</span>
                        <span class="chip" data-platform="Switch"><svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M14.176 24H17.5A6.5 6.5 0 0 0 24 17.5v-11A6.5 6.5 0 0 0 17.5 0H14.176v24zM18 10.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zM6.5 0A6.5 6.5 0 0 0 0 6.5v11A6.5 6.5 0 0 0 6.5 24H9.824V0H6.5zM7.5 16a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z"/></svg>Switch</span>
                        <span class="chip" data-platform="Mobile"><svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M17 1.01L7 1c-1.1 0-2 .9-2 2v18c0 1.1.9 2 2 2h10c1.1 0 2-.9 2-2V3c0-1.1-.9-1.99-2-1.99zM17 19H7V5h10v14z"/></svg>Mobile</span>
                    </div>
                    <input type="hidden" id="selectedPlatforms" value="">
                </div>
                <div class="form-group">
                    <label class="form-label">Categories <span style="color:rgba(255,255,255,0.4);font-weight:400;">(select one or more)</span></label>
                    <div class="category-chips" id="categoryChips">
                        <span class="chip" data-category="action"><i class="bi bi-lightning-charge-fill"></i> Action</span>
                        <span class="chip" data-category="rpg"><i class="bi bi-shield-fill"></i> RPG</span>
                        <span class="chip" data-category="shooter"><i class="bi bi-bullseye"></i> Shooter</span>
                        <span class="chip" data-category="adventure"><i class="bi bi-globe-americas"></i> Adventure</span>
                        <span class="chip" data-category="sports"><i class="bi bi-basket-fill"></i> Sports</span>
                        <span class="chip" data-category="horror"><i class="bi bi-moon-stars-fill"></i> Horror</span>
                    </div>
                    <input type="hidden" id="selectedCategories" value="">
                    <div class="form-hint">Tap multiple categories to tag this game with all that apply.</div>
                </div>
                <div class="form-group">
                    <label class="form-label">Days Played</label>
                    <input type="text" class="form-input" id="gamePlaytime" placeholder="127h">
                </div>
                <div class="form-group">
                    <label class="form-label">Progress</label>
                    <input type="text" class="form-input" id="gameProgress" placeholder="95%">
                </div>
                <div class="form-group">
                    <label class="form-label">Rating (0–10)</label>
                    <input type="number" class="form-input" id="gameRating" min="0" max="10" step="0.1" placeholder="9.2">
                </div>
            </form>
        </div>
        <div class="modal-actions">
            <button type="button" class="btn-secondary" id="cancelAddGame">Cancel</button>
            <button type="submit" class="btn-primary" id="submitGameBtn" form="addGameForm">Add Game</button>
        </div>
    </div>
</div>

<div class="confirm-delete-modal" id="confirmDeleteModal">
    <div class="confirm-modal-content">
        <div class="confirm-icon"><i class="bi bi-exclamation-triangle"></i></div>
        <h2 class="confirm-title">Delete Game?</h2>
        <p class="confirm-text">Are you sure you want to delete <span class="confirm-game-title" id="confirmGameTitle"></span> from your collection? This action cannot be undone.</p>
        <div style="display:flex;gap:1rem;">
            <button class="btn-secondary" id="cancelDelete" style="flex:1;">Cancel</button>
            <button class="btn-primary"   id="confirmDelete" style="flex:1;">Delete Game</button>
        </div>
    </div>
</div>

<div class="confirm-delete-all-modal" id="confirmDeleteAllModal">
    <div class="confirm-modal-content">
        <div class="confirm-icon"><i class="bi bi-trash3-fill"></i></div>
        <h2 class="confirm-title">Delete All?</h2>
        <p class="confirm-text">This will permanently remove <strong id="deleteAllCount">all</strong> games from your collection. This cannot be undone.</p>
        <div style="display:flex;gap:1rem;">
            <button class="btn-secondary" id="cancelDeleteAll" style="flex:1;">Cancel</button>
            <button class="btn-primary"   id="confirmDeleteAll" style="flex:1;">Delete All</button>
        </div>
    </div>
</div>

<footer class="footer">
    <div class="footer-content">
        <div class="footer-top">
            <div class="footer-brand">
                <h3>Pixel Forge</h3>
                <p>Level up your gaming life. Track, discover, and share your journey with the world's best game collection manager.</p>
                <input type="email" class="newsletter-input" placeholder="Get product updates">
            </div>
            <div class="footer-section">
                <h4>Product</h4>
                <div class="footer-links">
                    <a href="#" class="footer-link">Features</a>
                    <a href="#" class="footer-link">Pricing</a>
                    <a href="#" class="footer-link">Games Library</a>
                    <a href="#" class="footer-link">API</a>
                </div>
            </div>
            <div class="footer-section">
                <h4>Company</h4>
                <div class="footer-links">
                    <a href="#" class="footer-link">About</a>
                    <a href="#" class="footer-link">Careers</a>
                    <a href="#" class="footer-link">Press</a>
                    <a href="#" class="footer-link">Contact</a>
                </div>
            </div>
            <div class="footer-section">
                <h4>Support</h4>
                <div class="footer-links">
                    <a href="#" class="footer-link">Help Center</a>
                    <a href="#" class="footer-link">Documentation</a>
                    <a href="#" class="footer-link">Status</a>
                    <a href="#" class="footer-link">Privacy</a>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="footer-bottom-left">© 2026 Pixel Forge Studios. All rights reserved.</div>
            <div class="footer-bottom-right">
                <a href="https://www.facebook.com/rulesofsurvival2004" target="_blank" rel="noopener" class="social-link fb" title="Facebook"><svg viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg></a>
                <a href="https://www.instagram.com/diegzzz_0/" target="_blank" rel="noopener" class="social-link ig" title="Instagram"><svg viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><circle cx="12" cy="12" r="4"/><circle cx="18" cy="6" r="1"/></svg></a>
                <a href="https://x.com/Diego_Anover" target="_blank" rel="noopener" class="social-link x" title="X (Twitter)"><svg viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.3L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg></a>
                <a href="http://t.me/diegzzz_0" target="_blank" rel="noopener" class="social-link tg" title="Telegram"><svg viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><path d="M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0a12 12 0 0 0-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 0 1 .171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.48.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z"/></svg></a>
            </div>
        </div>
    </div>
</footer>

<script>
const PLATFORM_ICONS = {
    'PC':     `<svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor"><path d="M20 18c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2H4c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2H0v2h24v-2h-4zM4 6h16v10H4V6z"/></svg>`,
    'PS5':    `<svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor"><path d="M9.5 15.5v-7l9.5 3.5-9.5 3.5zm-3 2.5V6l2 .7v4.3L5 10.5V8l-2-.7V18l3.5-2zm14.5-1l-3 1.1V6.9L21 8v9z"/></svg>`,
    'PS4':    `<svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor"><path d="M9.5 15.5v-7l9.5 3.5-9.5 3.5zm-3 2.5V6l2 .7v4.3L5 10.5V8l-2-.7V18l3.5-2zm14.5-1l-3 1.1V6.9L21 8v9z"/></svg>`,
    'Xbox':   `<svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor"><path d="M4.1 4.1C5.9 2.4 8.3 1.3 11 1.1c-1.5 1.4-2.8 3.2-3.8 5.2C5.7 7.4 4.8 8.9 4.1 10c-.9-2-.8-4.2 0-5.9zm15.8 0c.8 1.7.9 3.9 0 5.9-.7-1.1-1.6-2.6-3.1-3.7-1-2-2.3-3.8-3.8-5.2 2.7.2 5.1 1.3 6.9 3zm-11 16.9c-2.3-1.6-4.5-4.2-5.4-7.3.5.7 1.1 1.4 1.9 2.1 1.4 1.2 2.9 2.1 4.5 2.7l-1 2.5zm6.2 0l-1-2.5c1.6-.6 3.1-1.5 4.5-2.7.8-.7 1.4-1.4 1.9-2.1-.9 3.1-3.1 5.7-5.4 7.3zM12 7c-1.7 0-5 4.1-5 8s2.2 5 5 5 5-1.1 5-5-3.3-8-5-8z"/></svg>`,
    'Switch': `<svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor"><path d="M14.176 24H17.5A6.5 6.5 0 0 0 24 17.5v-11A6.5 6.5 0 0 0 17.5 0H14.176v24zM18 10.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zM6.5 0A6.5 6.5 0 0 0 0 6.5v11A6.5 6.5 0 0 0 6.5 24H9.824V0H6.5zM7.5 16a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z"/></svg>`,
    'Mobile': `<svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor"><path d="M17 1.01L7 1c-1.1 0-2 .9-2 2v18c0 1.1.9 2 2 2h10c1.1 0 2-.9 2-2V3c0-1.1-.9-1.99-2-1.99zM17 19H7V5h10v14z"/></svg>`
};

const PLATFORM_CLASS = { 'PC':'pc','PS5':'ps5','PS4':'ps4','Xbox':'xbox','Switch':'switch','Mobile':'mobile' };

const CAT_META = {
    action:    { icon: 'bi-lightning-charge-fill', label: 'Action' },
    rpg:       { icon: 'bi-shield-fill',           label: 'RPG' },
    shooter:   { icon: 'bi-bullseye',              label: 'Shooter' },
    adventure: { icon: 'bi-globe-americas',        label: 'Adventure' },
    sports:    { icon: 'bi-basket-fill',            label: 'Sports' },
    horror:    { icon: 'bi-moon-stars-fill',        label: 'Horror' }
};

function getPlatformTag(p) {
    const cls  = PLATFORM_CLASS[p] || 'default';
    const icon = PLATFORM_ICONS[p] || '';
    return `<span class="platform-tag ${cls}">${icon}${escapeHtml(p)}</span>`;
}

function getCatBadge(cat) {
    const m = CAT_META[cat];
    if (!m) return '';
    return `<span class="cat-badge ${cat}"><i class="bi ${m.icon}"></i>${m.label}</span>`;
}

function escapeHtml(text) {
    if (!text) return '';
    const map = {'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#039;'};
    return text.toString().replace(/[&<>"']/g, m => map[m]);
}

function openProfileDropdown() {
    document.getElementById('profileBtn')?.classList.add('open');
    document.getElementById('profileDropdown')?.classList.add('open');
    document.getElementById('profileBtn')?.setAttribute('aria-expanded', 'true');
}

function closeProfileDropdown() {
    document.getElementById('profileBtn')?.classList.remove('open');
    document.getElementById('profileDropdown')?.classList.remove('open');
    document.getElementById('profileBtn')?.setAttribute('aria-expanded', 'false');
}

function openLogoutModal() {
    document.getElementById('logoutModalBackdrop').classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeLogoutModal() {
    document.getElementById('logoutModalBackdrop').classList.remove('active');
    document.body.style.overflow = '';
}

function showToast(message, type) {
    const existing = document.querySelector('.welcome-toast');
    if (existing) existing.remove();

    const toast = document.createElement('div');
    toast.className = 'welcome-toast';
    const iconClass = type === 'success' ? 'bi bi-check-circle-fill success' : 'bi bi-x-circle-fill error';
    const label     = type === 'success' ? 'Done!' : 'Error';

    toast.innerHTML = `<div class="toast-content">
        <i class="${iconClass}"></i>
        <div class="toast-text">
            <strong>${label}</strong>
            <span>${escapeHtml(message)}</span>
        </div>
    </div>`;

    document.body.appendChild(toast);
    requestAnimationFrame(() => toast.classList.add('show'));

    setTimeout(() => {
        toast.classList.remove('show');
        setTimeout(() => toast.remove(), 500);
    }, 4000);
}

class GameVault {
    constructor() {
        const raw = JSON.parse(localStorage.getItem('games') || '[]');
        this.games = raw
            .filter(g => g && g.id && g.title)
            .map(g => ({ ...g, id: Number(g.id) }));

        this.currentTab  = 'all';
        this.editingId   = null;
        this.deleteId    = null;
        this.searchQuery = '';

        this.init();
    }

    init() {
        this.save();
        this.bindEvents();
        this.updateAll();
        this.initAnimations();
    }

    save() {
        localStorage.setItem('games', JSON.stringify(this.games));
    }

    bindEvents() {
        window.addEventListener('scroll', () => {
            document.getElementById('navbar')
                ?.classList.toggle('navbar-scrolled', window.scrollY > 50);
        });

        const hamburger          = document.getElementById('hamburger');
        const mobileMenu         = document.getElementById('mobileMenu');
        const profileBtn         = document.getElementById('profileBtn');
        const profileDropdown    = document.getElementById('profileDropdown');
        const profileMenuWrapper = document.getElementById('profileMenuWrapper');

        hamburger?.addEventListener('click', e => {
            e.stopPropagation();
            hamburger.classList.toggle('active');
            mobileMenu.classList.toggle('active');
            document.body.style.overflow = mobileMenu.classList.contains('active') ? 'hidden' : '';
        });

        document.querySelectorAll('.mobile-nav-link').forEach(link => {
            link.addEventListener('click', () => {
                hamburger?.classList.remove('active');
                mobileMenu?.classList.remove('active');
                document.body.style.overflow = '';
            });
        });

        profileBtn?.addEventListener('click', e => {
            e.stopPropagation();
            profileDropdown.classList.contains('open')
                ? closeProfileDropdown()
                : openProfileDropdown();
        });

        document.addEventListener('click', e => {
            if (!profileMenuWrapper?.contains(e.target)) closeProfileDropdown();
            this.handleClick(e);
        });

        profileDropdown?.addEventListener('click', e => e.stopPropagation());

        document.getElementById('addGameForm')
            ?.addEventListener('submit', e => { e.preventDefault(); this.saveGame(); });

        document.querySelectorAll('.add-game-modal, .confirm-delete-modal, .confirm-delete-all-modal')
            .forEach(m => m.addEventListener('click', e => {
                if (e.target === m) this.closeAllModals();
            }));

        document.getElementById('logoutModalBackdrop')
            ?.addEventListener('click', function(e) {
                if (e.target === this) closeLogoutModal();
            });

        document.getElementById('closeAddModal')   ?.addEventListener('click', () => this.closeAddModal());
        document.getElementById('cancelAddGame')   ?.addEventListener('click', () => this.closeAddModal());
        document.getElementById('cancelDelete')    ?.addEventListener('click', () => this.closeDeleteModal());
        document.getElementById('confirmDelete')   ?.addEventListener('click', () => this.deleteGame());
        document.getElementById('addGameBtn')      ?.addEventListener('click', () => this.openAddModal());
        document.getElementById('deleteAllBtn')    ?.addEventListener('click', () => this.openDeleteAllModal());
        document.getElementById('cancelDeleteAll') ?.addEventListener('click', () => this.closeDeleteAllModal());
        document.getElementById('confirmDeleteAll')?.addEventListener('click', () => this.deleteAllGames());

        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) window.scrollTo({ top: target.offsetTop - 80, behavior: 'smooth' });
            });
        });

        document.addEventListener('keydown', e => {
            if (e.key === 'Escape') {
                this.closeAllModals();
                closeLogoutModal();
                closeProfileDropdown();
                hamburger?.classList.remove('active');
                mobileMenu?.classList.remove('active');
                document.body.style.overflow = '';
            }
        });

        const searchInput   = document.getElementById('gameSearchInput');
        const searchWrapper = document.getElementById('searchWrapper');
        const clearBtn      = document.getElementById('searchClearBtn');

        searchInput?.addEventListener('input', () => {
            const val = searchInput.value;
            searchWrapper.classList.toggle('has-text', val.length > 0);
            this.searchQuery = val.trim().toLowerCase();
            this.renderGames();
        });

        clearBtn?.addEventListener('click', () => {
            this.clearSearch();
        });

        document.getElementById('noResultsClearBtn')
            ?.addEventListener('click', () => {
                this.clearSearch();
            });
    }

    clearSearch() {
        const searchInput   = document.getElementById('gameSearchInput');
        const searchWrapper = document.getElementById('searchWrapper');
        if (searchInput)   searchInput.value = '';
        searchWrapper?.classList.remove('has-text');
        this.searchQuery = '';
        this.renderGames();
    }

    handleClick(e) {
        const tabBtn = e.target.closest('.tab-btn');
        if (tabBtn) { this.setActiveTab(tabBtn.dataset.tab); return; }

        const catCard = e.target.closest('.category-card');
        if (catCard) { this.setActiveTab(catCard.dataset.category); return; }

        const catChip = e.target.closest('#categoryChips .chip');
        if (catChip) {
            catChip.classList.toggle('active');
            this.syncCategoryInput();
            return;
        }

        const platChip = e.target.closest('.platform-chips .chip');
        if (platChip) { platChip.classList.toggle('active'); this.syncPlatformInput(); return; }

        const editBtn = e.target.closest('.btn-edit');
        if (editBtn) {
            const card = editBtn.closest('.game-card');
            if (card) this.editGame(Number(card.dataset.id));
            return;
        }

        const deleteBtn = e.target.closest('.btn-delete');
        if (deleteBtn) {
            const card = deleteBtn.closest('.game-card');
            if (card) this.openDeleteModal(Number(card.dataset.id));
            return;
        }
    }

    syncPlatformInput() {
        const active = [...document.querySelectorAll('.platform-chips .chip.active')]
            .map(c => c.dataset.platform);
        document.getElementById('selectedPlatforms').value = active.join(',');
    }

    syncCategoryInput() {
        const active = [...document.querySelectorAll('#categoryChips .chip.active')]
            .map(c => c.dataset.category);
        document.getElementById('selectedCategories').value = active.join(',');
    }

    setActiveTab(tab) {
        if (!tab || tab === this.currentTab) return;
        this.currentTab = tab;

        document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
        document.querySelector(`[data-tab="${tab}"]`)?.classList.add('active');

        document.querySelectorAll('.category-card').forEach(c => c.classList.remove('active'));
        document.querySelector(`[data-category="${tab}"]`)?.classList.add('active');

        this.renderGames();
    }

    updateAll() {
        this.updateAnalytics();
        this.updateCategories();
        this.renderGames();
    }

    updateAnalytics() {
        const total     = this.games.length;
        const completed = this.games.filter(g => (g.progress || '').trim() === '100%').length;

        const totalH = this.games.reduce((s, g) => {
            const m = (g.playtime || '').match(/(\d+)/);
            return s + (m ? parseFloat(m[1]) : 0);
        }, 0);

        const ratings = this.games.map(g => parseFloat(g.rating)).filter(r => !isNaN(r) && r > 0);
        const avg     = ratings.length
            ? (ratings.reduce((a, b) => a + b, 0) / ratings.length).toFixed(1)
            : '0.0';

        document.getElementById('totalGames').textContent     = total;
        document.getElementById('completedGames').textContent = completed;
        document.getElementById('totalPlaytime').textContent  = `${Math.round(totalH)}`;
        document.getElementById('avgRating').textContent      = avg;
    }

    updateCategories() {
        const counts = { all: this.games.length, action: 0, rpg: 0, shooter: 0, adventure: 0, sports: 0, horror: 0 };

        this.games.forEach(g => {
            const cats = Array.isArray(g.categories) ? g.categories : (g.category ? [g.category] : []);
            cats.forEach(cat => { if (counts[cat] !== undefined) counts[cat]++; });
        });

        document.querySelectorAll('.category-count').forEach(el => {
            const n = counts[el.dataset.count] || 0;
            el.textContent = `${n} ${n === 1 ? 'game' : 'games'}`;
        });
    }

    renderGames() {
        const grid          = document.getElementById('gamesGrid');
        const noResultsEl   = document.getElementById('noResultsState');
        const noResultsTerm = document.getElementById('noResultsTerm');
        if (!grid) return;

        let list = this.currentTab === 'all'
            ? this.games
            : this.games.filter(g => {
                const cats = Array.isArray(g.categories) ? g.categories : (g.category ? [g.category] : []);
                return cats.includes(this.currentTab);
            });

        if (this.searchQuery) {
            const q = this.searchQuery;
            list = list.filter(g => {
                const title     = (g.title || '').toLowerCase();
                const cats      = (Array.isArray(g.categories) ? g.categories : (g.category ? [g.category] : [])).join(' ').toLowerCase();
                const platforms = (Array.isArray(g.platforms) ? g.platforms : []).join(' ').toLowerCase();
                return title.includes(q) || cats.includes(q) || platforms.includes(q);
            });
        }

        if (list.length === 0 && this.searchQuery) {
            grid.innerHTML = '';
            noResultsEl.style.display = 'flex';
            if (noResultsTerm) noResultsTerm.textContent = this.searchQuery;
        } else {
            noResultsEl.style.display = 'none';

            grid.innerHTML = list.map(game => {
                const platforms  = Array.isArray(game.platforms) && game.platforms.length
                    ? game.platforms : ['PC'];
                const categories = Array.isArray(game.categories) && game.categories.length
                    ? game.categories
                    : (game.category ? [game.category] : []);

                const tagHtml = platforms.map(getPlatformTag).join('');
                const catHtml = categories.map(getCatBadge).join('');

                return `
                <div class="game-card animate-on-scroll" data-id="${game.id}">
                    <img src="${escapeHtml(game.cover || '')}"
                         alt="${escapeHtml(game.title)}"
                         class="game-cover"
                         loading="lazy"
                         onerror="this.src='https://images.unsplash.com/photo-1592879190164-7fb068e408b4?auto=format&fit=crop&w=500&q=80'">
                    <div class="game-content">
                        <h3 class="game-title">${escapeHtml(game.title)}</h3>
                        <div class="game-meta">${tagHtml}</div>
                        <div class="game-categories">${catHtml}</div>
                        <div class="game-stats">
                            <div class="stat-item">
                                <div class="stat-value">${escapeHtml(game.playtime || '0h')}</div>
                                <div class="stat-label">Days Played</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-value">${escapeHtml(game.progress || '0%')}</div>
                                <div class="stat-label">${(game.progress || '0%') === '100%' ? 'Completed' : 'Progress'}</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-value">${isNaN(parseFloat(game.rating)) ? '0' : parseFloat(game.rating).toFixed(1)}</div>
                                <div class="stat-label">Rating</div>
                            </div>
                        </div>
                        <div class="game-actions">
                            <button class="btn-action btn-edit"   type="button"><i class="bi bi-pencil"></i> Edit</button>
                            <button class="btn-action btn-delete" type="button"><i class="bi bi-trash"></i> Delete</button>
                        </div>
                    </div>
                </div>`;
            }).join('');

            this.triggerAnimations();
        }
    }

    initAnimations() {
        const obs = new IntersectionObserver(entries => {
            entries.forEach(en => { if (en.isIntersecting) en.target.classList.add('visible'); });
        }, { threshold: 0.1 });

        document.querySelectorAll('.animate-on-scroll').forEach((el, i) => {
            el.style.transitionDelay = `${Math.min(i * 0.1, 0.5)}s`;
            obs.observe(el);
        });
    }

    triggerAnimations() {
        const obs = new IntersectionObserver(entries => {
            entries.forEach(en => {
                if (en.isIntersecting) {
                    en.target.classList.add('visible');
                    obs.unobserve(en.target);
                }
            });
        }, { threshold: 0.1 });

        document.querySelectorAll('.games-grid .animate-on-scroll').forEach((el, i) => {
            el.style.transitionDelay = `${i * 0.1}s`;
            obs.observe(el);
        });
    }

    saveGame() {
        const titleEl = document.getElementById('gameTitle');
        const title   = titleEl?.value.trim();
        if (!title) { showToast('Please enter a game title!', 'error'); titleEl?.focus(); return; }

        const platInput = document.getElementById('selectedPlatforms').value;
        const platforms = platInput ? platInput.split(',').filter(Boolean) : ['PC'];

        const catInput   = document.getElementById('selectedCategories').value;
        const categories = catInput ? catInput.split(',').filter(Boolean) : [];
        if (!categories.length) { showToast('Please select at least one category!', 'error'); return; }

        const gameData = {
            id:         this.editingId || Date.now(),
            title,
            cover:      document.getElementById('gameCover')?.value.trim() ||
                        'https://images.unsplash.com/photo-1592879190164-7fb068e408b4?auto=format&fit=crop&w=500&q=80',
            platforms,
            categories,
            playtime:   document.getElementById('gamePlaytime')?.value.trim() || '0h',
            progress:   document.getElementById('gameProgress')?.value.trim()  || '0%',
            rating:     parseFloat(document.getElementById('gameRating')?.value) || 0
        };

        const dup = this.games.find(g =>
            g.title.toLowerCase() === gameData.title.toLowerCase() && g.id !== gameData.id
        );
        if (dup) { showToast('This game already exists!', 'error'); return; }

        const idx = this.games.findIndex(g => g.id === gameData.id);
        if (idx !== -1) {
            this.games[idx] = gameData;
            showToast('Game updated successfully!', 'success');
        } else {
            this.games.unshift(gameData);
            showToast('Game added successfully!', 'success');
        }

        this.save();
        this.updateAll();
        this.closeAddModal();
    }

    openAddModal() {
        this.editingId = null;
        document.getElementById('addGameForm')?.reset();

        document.querySelectorAll('.platform-chips .chip').forEach(c => c.classList.remove('active'));
        document.getElementById('selectedPlatforms').value = '';
        document.querySelectorAll('#categoryChips .chip').forEach(c => c.classList.remove('active'));
        document.getElementById('selectedCategories').value = '';

        document.getElementById('modalTitle').textContent    = 'Add New Game';
        document.getElementById('submitGameBtn').textContent = 'Add Game';
        document.getElementById('addGameModal')?.classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    editGame(id) {
        const game = this.games.find(g => g.id === id);
        if (!game) return;
        this.editingId = id;

        document.getElementById('gameTitle').value    = game.title    || '';
        document.getElementById('gameCover').value    = game.cover    || '';
        document.getElementById('gamePlaytime').value = game.playtime || '';
        document.getElementById('gameProgress').value = game.progress || '';
        document.getElementById('gameRating').value   = game.rating   || '';

        const plats = Array.isArray(game.platforms) ? game.platforms : [];
        document.querySelectorAll('.platform-chips .chip').forEach(c => {
            c.classList.toggle('active', plats.includes(c.dataset.platform));
        });
        document.getElementById('selectedPlatforms').value = plats.join(',');

        const cats = Array.isArray(game.categories) && game.categories.length
            ? game.categories
            : (game.category ? [game.category] : []);
        document.querySelectorAll('#categoryChips .chip').forEach(c => {
            c.classList.toggle('active', cats.includes(c.dataset.category));
        });
        document.getElementById('selectedCategories').value = cats.join(',');

        document.getElementById('modalTitle').textContent    = 'Edit Game';
        document.getElementById('submitGameBtn').textContent = 'Update Game';
        document.getElementById('addGameModal')?.classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    openDeleteModal(id) {
        const game = this.games.find(g => g.id === id);
        if (!game) { showToast('Game not found.', 'error'); return; }
        this.deleteId = id;
        document.getElementById('confirmGameTitle').textContent = game.title;
        document.getElementById('confirmDeleteModal')?.classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    deleteGame() {
        if (this.deleteId === null) { this.closeDeleteModal(); return; }
        this.games = this.games.filter(g => g.id !== this.deleteId);
        this.save();
        this.updateAll();
        showToast('Game deleted!', 'success');
        this.closeDeleteModal();
        this.deleteId = null;
    }

    openDeleteAllModal() {
        if (!this.games.length) { showToast('No games to delete.', 'error'); return; }
        document.getElementById('deleteAllCount').textContent = `all ${this.games.length}`;
        document.getElementById('confirmDeleteAllModal')?.classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    deleteAllGames() {
        this.games = [];
        this.save();
        this.updateAll();
        showToast('All games deleted!', 'success');
        this.closeDeleteAllModal();
    }

    closeAddModal() {
        document.getElementById('addGameModal')?.classList.remove('active');
        document.body.style.overflow = '';
        this.editingId = null;
    }

    closeDeleteModal() {
        document.getElementById('confirmDeleteModal')?.classList.remove('active');
        document.body.style.overflow = '';
        this.deleteId = null;
    }

    closeDeleteAllModal() {
        document.getElementById('confirmDeleteAllModal')?.classList.remove('active');
        document.body.style.overflow = '';
    }

    closeAllModals() {
        this.closeAddModal();
        this.closeDeleteModal();
        this.closeDeleteAllModal();
    }
}

document.addEventListener('DOMContentLoaded', () => new GameVault());
</script>

@endsection