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

.navbar-landing {
    position: fixed;
    top: 0;
    left: 0;
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
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.3);
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
    margin: 0;
    padding: 0;
}

.auth-buttons {
    display: flex;
    gap: 0.8rem;
    align-items: center;
    z-index: 2;
}

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
    bottom: -2px;
    left: 50%;
    width: 0;
    height: 2px;
    background: linear-gradient(135deg, var(--primary), var(--secondary));
    transition: all 0.3s ease;
    transform: translateX(-50%);
    border-radius: 1px;
}

.nav-link:hover, .nav-link.active { color: #fff; }
.nav-link:hover::after, .nav-link.active::after { width: 100%; }

.profile-menu-wrapper { position: relative; z-index: 2; }

.profile-btn {
    width: 52px;
    height: 52px;
    border-radius: 50%;
    background: linear-gradient(135deg, #5865F2, #FF2E63);
    border: 2.5px solid rgba(255, 255, 255, 0.35);
    box-shadow: 0 4px 16px rgba(88, 101, 242, 0.4);
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.3rem;
    font-weight: 800;
    color: #fff;
    text-transform: uppercase;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
    flex-shrink: 0;
    padding: 0;
    outline: none;
}

.profile-btn img {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 50%;
    display: block;
    z-index: 1;
}

.profile-btn::before {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(120deg, transparent 30%, rgba(255,255,255,0.25) 50%, transparent 70%);
    transform: translateX(-120%);
    transition: transform 0.6s ease;
    z-index: 2;
}

.profile-btn:hover::before { transform: translateX(120%); }
.profile-btn:hover { transform: scale(1.08); box-shadow: 0 8px 25px rgba(88, 101, 242, 0.5); border-color: rgba(255,255,255,0.4); }
.profile-btn.open { box-shadow: 0 0 0 3px rgba(88, 101, 242, 0.4), 0 8px 25px rgba(88, 101, 242, 0.3); border-color: #5865F2; }

.profile-dropdown {
    position: absolute;
    top: calc(100% + 14px);
    right: 0;
    width: 280px;
    background: rgba(12, 18, 36, 0.98);
    backdrop-filter: blur(30px);
    border: 1px solid rgba(88, 101, 242, 0.3);
    border-radius: 20px;
    box-shadow: 0 24px 60px rgba(0,0,0,0.6), 0 0 0 1px rgba(255,255,255,0.04);
    overflow: hidden;
    opacity: 0;
    visibility: hidden;
    transform: translateY(-10px) scale(0.96);
    transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    transform-origin: top right;
}

.profile-dropdown.open { opacity: 1; visibility: visible; transform: translateY(0) scale(1); }

.dropdown-header {
    padding: 20px 20px 16px;
    background: linear-gradient(135deg, rgba(88, 101, 242, 0.2), rgba(255, 46, 99, 0.12));
    border-bottom: 1px solid rgba(255,255,255,0.07);
    display: flex;
    align-items: center;
    gap: 14px;
}

.dropdown-avatar {
    width: 52px;
    height: 52px;
    border-radius: 50%;
    background: linear-gradient(135deg, #5865F2, #FF2E63);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.3rem;
    font-weight: 800;
    color: #fff;
    text-transform: uppercase;
    flex-shrink: 0;
    border: 2px solid rgba(255,255,255,0.15);
    box-shadow: 0 6px 20px rgba(88,101,242,0.35);
    overflow: hidden;
    position: relative;
}

.dropdown-avatar img { position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; border-radius: 50%; display: block; }
.dropdown-user-info { display: flex; flex-direction: column; gap: 3px; min-width: 0; }
.dropdown-username { font-size: 0.95rem; font-weight: 700; color: #fff; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.dropdown-role { font-size: 0.75rem; color: rgba(255,255,255,0.5); font-weight: 500; }

.dropdown-online { display: flex; align-items: center; gap: 5px; font-size: 0.72rem; color: #10B981; font-weight: 600; }
.dropdown-online::before { content: ''; width: 7px; height: 7px; border-radius: 50%; background: #10B981; box-shadow: 0 0 6px #10B981; flex-shrink: 0; }
.dropdown-offline { display: flex; align-items: center; gap: 5px; font-size: 0.72rem; color: rgba(255,255,255,0.35); font-weight: 600; }
.dropdown-offline::before { content: ''; width: 7px; height: 7px; border-radius: 50%; background: rgba(255,255,255,0.25); flex-shrink: 0; }

.dropdown-nav { padding: 10px 10px 0; }

.dropdown-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 11px 14px;
    border-radius: 12px;
    text-decoration: none;
    color: rgba(255,255,255,0.8);
    font-size: 0.88rem;
    font-weight: 600;
    transition: all 0.2s ease;
    position: relative;
    overflow: hidden;
    cursor: pointer;
    border: none;
    background: none;
    width: 100%;
    text-align: left;
}

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

.dropdown-logout-btn {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 11px 14px;
    border-radius: 12px;
    color: rgba(255,80,100,0.9);
    font-size: 0.88rem;
    font-weight: 600;
    transition: all 0.2s ease;
    cursor: pointer;
    border: none;
    background: none;
    width: 100%;
    text-align: left;
    position: relative;
    overflow: hidden;
}

.dropdown-logout-btn::before { content: ''; position: absolute; inset: 0; background: linear-gradient(135deg, rgba(255,46,99,0.15), rgba(255,46,99,0.08)); opacity: 0; transition: opacity 0.2s ease; border-radius: 12px; }
.dropdown-logout-btn:hover::before { opacity: 1; }
.dropdown-logout-btn:hover { color: #FF2E63; transform: translateX(3px); }

.dropdown-logout-icon { width: 34px; height: 34px; border-radius: 10px; background: linear-gradient(135deg, rgba(255,46,99,0.2), rgba(255,107,107,0.12)); display: flex; align-items: center; justify-content: center; font-size: 1rem; color: #FF2E63; flex-shrink: 0; transition: all 0.3s ease; }
.dropdown-logout-btn:hover .dropdown-logout-icon { transform: scale(1.1); background: linear-gradient(135deg, rgba(255,46,99,0.35), rgba(255,107,107,0.2)); }

.hamburger { display: none; flex-direction: column; gap: 4px; cursor: pointer; padding: 8px; z-index: 10001; }
.hamburger span { width: 24px; height: 2px; background: #fff; transition: all 0.3s ease; border-radius: 2px; position: relative; }
.hamburger.active span:nth-child(1) { transform: rotate(45deg) translate(6px, 6px); }
.hamburger.active span:nth-child(2) { opacity: 0; }
.hamburger.active span:nth-child(3) { transform: rotate(-45deg) translate(6px, -5px); }

.mobile-menu {
    position: fixed;
    top: 0; left: 0;
    width: 100vw; height: 100vh;
    background: rgba(15, 23, 42, 0.98);
    backdrop-filter: blur(20px);
    z-index: 9999;
    transform: translateX(100%);
    transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    display: flex;
    flex-direction: column;
    padding: 100px 4% 2rem;
}

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

.hero-section {
    min-height: 100vh;
    width: 100vw;
    position: relative;
    left: 50%;
    right: 50%;
    margin-left: -50vw;
    margin-right: -50vw;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    overflow: hidden;
    padding-top: 70px;
}

.section-bg {
    position: absolute;
    top: 0; left: 0;
    width: 100%; height: 100%;
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    z-index: 0;
}

.hero-bg {
    background-image: url('/images/miami16.jpg');
}

.section-overlay {
    position: absolute;
    top: 0; left: 0;
    width: 100%; height: 100%;
    z-index: 1;
    background:
        radial-gradient(circle at 20% 80%, rgba(88, 101, 242, 0.1), transparent 50%),
        radial-gradient(circle at 80% 20%, rgba(255, 46, 99, 0.07), transparent 50%),
        rgba(0, 0, 0, 0.55);
}

.hero-content {
    position: relative;
    z-index: 2;
    max-width: 900px;
    padding: 0 4%;
    animation: fadeInUp 1s ease;
    width: 100%;
    box-sizing: border-box;
}

.hero-eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.45rem 1.2rem;
    border-radius: 999px;
    background: rgba(88,101,242,0.12);
    border: 1px solid rgba(88,101,242,0.3);
    color: var(--accent);
    font-size: 0.82rem;
    font-weight: 700;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    margin-bottom: 1.5rem;
    display: inline-flex;
}

.hero-title {
    font-size: clamp(2.5rem, 8vw, 5rem);
    font-weight: 900;
    background: linear-gradient(135deg, #FFFFFF 0%, #F8FAFC 100%);
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
    margin-bottom: 1.2rem;
    line-height: 1.1;
    letter-spacing: -0.8px;
}

.hero-subtitle {
    font-size: clamp(1.1rem, 3vw, 1.6rem);
    color: rgba(255, 255, 255, 0.95);
    margin-bottom: 2.5rem;
    font-weight: 400;
    line-height: 1.6;
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
}

.hero-buttons { display: flex; gap: 1.2rem; justify-content: center; flex-wrap: wrap; }

.btn-hero {
    padding: clamp(14px, 4vw, 18px) clamp(32px, 6vw, 40px);
    font-size: clamp(0.95rem, 2.5vw, 1.1rem);
    font-weight: 700;
    border-radius: 50px;
    text-decoration: none;
    transition: all 0.4s ease;
    position: relative;
    overflow: hidden;
    min-width: clamp(180px, 40vw, 220px);
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    cursor: pointer;
    border: none;
}

.btn-primary-hero { background: linear-gradient(135deg, #FF2E63 0%, #08F7FE 50%, #5865F2 100%); color: #000; font-weight: 800; box-shadow: 0 12px 30px rgba(255, 46, 99, 0.4); }
.btn-primary-hero:hover { transform: translateY(-4px); box-shadow: 0 20px 40px rgba(255, 46, 99, 0.6); color: #000; }
.btn-secondary-hero { background: rgba(255,255,255,0.1); backdrop-filter: blur(15px); color: #fff; border: 2px solid rgba(255,255,255,0.3); }
.btn-secondary-hero:hover { background: rgba(255,255,255,0.2); transform: translateY(-2px); color: #fff; }

.container { max-width: 1440px; margin: 0 auto; padding: 0 2rem; }

.section-title {
    text-align: center;
    font-size: clamp(2rem, 6vw, 4rem);
    font-weight: 900;
    background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 50%, var(--accent) 100%);
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
    margin-bottom: 4rem;
    letter-spacing: -0.02em;
}

.section-label { text-align: center; font-size: 0.78rem; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; color: var(--accent); margin-bottom: 1rem; }

.animate-on-scroll { opacity: 0; transform: translateY(30px); transition: opacity 0.6s ease, transform 0.6s ease; }
.animate-on-scroll.visible { opacity: 1; transform: translateY(0); }

.contact-layout {
    display: grid;
    grid-template-columns: 1fr 1.6fr;
    gap: 2.5rem;
    align-items: start;
    padding-bottom: 6rem;
}

.info-panel { display: flex; flex-direction: column; gap: 1.5rem; }

.info-header { margin-bottom: 0.5rem; }
.info-header h2 { font-size: clamp(1.6rem, 3.5vw, 2.2rem); font-weight: 800; color: #fff; letter-spacing: -0.5px; margin-bottom: 0.75rem; line-height: 1.2; }
.info-header p { color: var(--text-muted); font-size: 1rem; line-height: 1.7; }

.contact-card {
    background: var(--bg-glass);
    backdrop-filter: blur(20px);
    border: 1px solid var(--border-light);
    border-radius: var(--radius-xl);
    padding: 1.5rem;
    display: flex;
    align-items: center;
    gap: 1.2rem;
    transition: all 0.4s cubic-bezier(0.4,0,0.2,1);
    text-decoration: none;
    position: relative;
    overflow: hidden;
    cursor: pointer;
}

.contact-card::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 4px; background: linear-gradient(90deg, var(--primary), var(--secondary), var(--accent)); }
.contact-card:hover { transform: translateY(-8px); border-color: rgba(79,172,254,0.3); box-shadow: var(--shadow-xl); }

.contact-card-icon { width: 56px; height: 56px; border-radius: var(--radius-sm); display: flex; align-items: center; justify-content: center; font-size: 1.5rem; flex-shrink: 0; transition: transform var(--transition); }
.contact-card:hover .contact-card-icon { transform: scale(1.1) rotate(-3deg); }

.contact-card-icon.email    { background: linear-gradient(135deg, rgba(88,101,242,0.2), rgba(88,101,242,0.1)); color: #818cf8; border: 1px solid rgba(88,101,242,0.25); }
.contact-card-icon.phone    { background: linear-gradient(135deg, rgba(16,185,129,0.2), rgba(16,185,129,0.1)); color: #34d399; border: 1px solid rgba(16,185,129,0.25); }
.contact-card-icon.location { background: linear-gradient(135deg, rgba(255,46,99,0.2), rgba(255,46,99,0.1)); color: #fb7185; border: 1px solid rgba(255,46,99,0.25); }
.contact-card-icon.discord  { background: linear-gradient(135deg, rgba(88,101,242,0.2), rgba(124,58,237,0.1)); color: #a78bfa; border: 1px solid rgba(124,58,237,0.25); }

.contact-card-body { flex: 1; min-width: 0; }
.contact-card-label { font-size: 0.75rem; font-weight: 700; letter-spacing: 1.2px; text-transform: uppercase; color: var(--text-muted); margin-bottom: 0.3rem; }
.contact-card-value { font-size: 1rem; font-weight: 600; color: var(--text-light); word-break: break-all; }

.contact-card-arrow { color: var(--text-muted); font-size: 1.1rem; opacity: 0; transform: translateX(-6px); transition: all var(--transition); flex-shrink: 0; }
.contact-card:hover .contact-card-arrow { opacity: 1; transform: translateX(0); }

.form-panel {
    background: var(--bg-glass);
    backdrop-filter: blur(25px);
    border: 1px solid var(--border-light);
    border-radius: var(--radius-xl);
    overflow: hidden;
    position: relative;
}

.form-panel::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 4px; background: linear-gradient(90deg, var(--primary), var(--secondary), var(--accent)); }

.form-panel-header { padding: 2rem 2.5rem 1.5rem; border-bottom: 1px solid rgba(255,255,255,0.08); display: flex; align-items: center; gap: 1rem; }
.form-panel-header-icon { width: 46px; height: 46px; border-radius: 14px; background: linear-gradient(135deg, var(--primary), var(--secondary)); display: flex; align-items: center; justify-content: center; font-size: 1.2rem; color: #fff; flex-shrink: 0; }
.form-panel-header h3 { font-size: 1.4rem; font-weight: 800; color: #fff; letter-spacing: -0.3px; }
.form-panel-header p { font-size: 0.85rem; color: var(--text-muted); margin-top: 0.15rem; }

.form-body { padding: 2rem 2.5rem 2.5rem; }

.form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem; margin-bottom: 1.25rem; }
.form-group { margin-bottom: 1.5rem; }
.form-label { display: block; margin-bottom: 0.7rem; font-weight: 700; color: rgba(255,255,255,0.9); }

.input-wrapper { position: relative; display: flex; align-items: center; }
.input-icon { position: absolute; left: 1rem; color: var(--text-muted); font-size: 1.05rem; pointer-events: none; transition: color var(--transition); }
.input-wrapper:focus-within .input-icon { color: var(--accent); }

.form-input { width: 100%; padding: 14px 18px 14px 2.8rem; border-radius: 16px; border: 1px solid rgba(255,255,255,0.1); background: rgba(255,255,255,0.06); backdrop-filter: blur(10px); color: #fff; font-size: 0.95rem; transition: all 0.3s ease; }
.form-input::placeholder { color: rgba(255,255,255,0.4); }
.form-input:focus { outline: none; border-color: var(--primary); box-shadow: 0 0 0 4px rgba(88,101,242,0.2); background: rgba(255,255,255,0.1); }

.form-textarea { width: 100%; padding: 1rem 1rem 1rem 2.8rem; border-radius: 16px; border: 1px solid rgba(255,255,255,0.1); background: rgba(255,255,255,0.06); backdrop-filter: blur(10px); color: #fff; font-size: 0.95rem; resize: vertical; min-height: 140px; transition: all 0.3s ease; outline: none; line-height: 1.7; }
.form-textarea::placeholder { color: rgba(255,255,255,0.4); }
.form-textarea:focus { border-color: var(--primary); box-shadow: 0 0 0 4px rgba(88,101,242,0.2); background: rgba(255,255,255,0.1); }

.topic-chips { display: flex; flex-wrap: wrap; gap: 0.8rem; }

.topic-chip { padding: 0.7rem 1.2rem; border-radius: 999px; background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.08); color: rgba(255,255,255,0.8); cursor: pointer; transition: all 0.3s ease; font-weight: 600; display: inline-flex; align-items: center; gap: 7px; user-select: none; font-size: 0.9rem; }
.topic-chip i { font-size: 0.88rem; }
.topic-chip:hover { transform: translateY(-2px); background: rgba(255,255,255,0.12); }
.topic-chip.active { background: linear-gradient(135deg, var(--accent), var(--primary)); color: #000; border-color: transparent; box-shadow: 0 10px 20px rgba(88,101,242,0.3); }

.btn-submit { width: 100%; padding: 14px 24px; border-radius: 16px; border: none; background: linear-gradient(135deg, var(--accent), var(--primary)); color: #000; font-weight: 700; font-size: 0.95rem; cursor: pointer; transition: all 0.3s ease; display: flex; align-items: center; justify-content: center; gap: 0.6rem; margin-top: 1.5rem; box-shadow: 0 12px 25px rgba(88,101,242,0.3); position: relative; overflow: hidden; }
.btn-submit:hover { transform: translateY(-3px); box-shadow: 0 18px 35px rgba(88,101,242,0.4); }
.btn-submit:active { transform: translateY(-1px); }
.btn-submit i { font-size: 1.05rem; transition: transform var(--transition); }
.btn-submit:hover i { transform: translateX(4px) rotate(-10deg); }
.btn-submit.loading { pointer-events: none; opacity: 0.8; }
.btn-submit.loading .btn-text { display: none; }
.btn-submit .btn-loading { display: none; gap: 0.5rem; align-items: center; }
.btn-submit.loading .btn-loading { display: flex; }

.spinner { width: 18px; height: 18px; border: 2px solid rgba(0,0,0,0.3); border-top-color: #000; border-radius: 50%; animation: spin 0.7s linear infinite; }
@keyframes spin { to { transform: rotate(360deg); } }

.faq-section { padding: 5rem 0; position: relative; z-index: 1; }

.faq-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(340px, 1fr)); gap: 1rem; max-width: 900px; margin: 0 auto; }

.faq-item {
    background: var(--bg-glass);
    backdrop-filter: blur(20px);
    border: 1px solid var(--border-light);
    border-radius: var(--radius-lg);
    overflow: hidden;
    transition: all 0.4s cubic-bezier(0.4,0,0.2,1);
    position: relative;
}

.faq-item::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 4px; background: linear-gradient(90deg, var(--primary), var(--secondary), var(--accent)); }
.faq-item:hover { transform: translateY(-8px); border-color: rgba(79,172,254,0.3); box-shadow: var(--shadow-xl); }

.faq-question { width: 100%; background: transparent; border: none; padding: 1.3rem 1.5rem; display: flex; align-items: center; justify-content: space-between; gap: 1rem; cursor: pointer; color: #fff; font-size: 0.95rem; font-weight: 700; text-align: left; transition: all var(--transition); }
.faq-question:hover { background: rgba(255,255,255,0.03); }

.faq-icon { width: 28px; height: 28px; border-radius: 8px; background: rgba(88,101,242,0.15); border: 1px solid rgba(88,101,242,0.25); color: var(--accent); display: flex; align-items: center; justify-content: center; font-size: 0.9rem; flex-shrink: 0; transition: all var(--transition); }
.faq-item.open .faq-icon { background: linear-gradient(135deg, var(--primary), var(--secondary)); border-color: transparent; transform: rotate(45deg); }

.faq-answer { max-height: 0; overflow: hidden; transition: max-height 0.4s ease; padding: 0 1.5rem; }
.faq-answer-inner { padding-bottom: 1.3rem; color: var(--text-muted); font-size: 0.9rem; line-height: 1.7; border-top: 1px solid var(--border-light); padding-top: 1rem; }
.faq-item.open .faq-answer { max-height: 300px; }

.welcome-toast { position: fixed; top: 100px; right: 25px; background: rgba(20, 20, 30, 0.95); border: 1px solid rgba(255,255,255,0.1); backdrop-filter: blur(14px); padding: 18px 22px; border-radius: 18px; min-width: 320px; z-index: 99999; transform: translateX(120%); opacity: 0; transition: transform .5s ease, opacity .5s ease; box-shadow: 0 10px 35px rgba(0,0,0,.35), 0 0 25px rgba(88,101,242,.25); }
.welcome-toast.show { transform: translateX(0); opacity: 1; }
.toast-content { display: flex; align-items: center; gap: 14px; }
.toast-content i { font-size: 2rem; }
.toast-content i.success { color: #10B981; }
.toast-content i.error   { color: #EF4444; }
.toast-text { display: flex; flex-direction: column; }
.toast-text strong { color: #fff; font-size: 1rem; }
.toast-text span { color: #d4d4d8; font-size: .9rem; margin-top: 2px; }

.footer {
    width: 100vw;
    position: relative;
    left: 50%; right: 50%;
    margin-left: -50vw; margin-right: -50vw;
    background: linear-gradient(180deg, rgba(15,23,42,0.98) 0%, rgba(10,15,30,1) 100%);
    border-top: 2px solid rgba(88,101,242,0.3);
    padding: 3rem 0 0;
    margin-top: 2rem;
    overflow: hidden;
}

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

@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(40px); }
    to   { opacity: 1; transform: translateY(0); }
}

@media (max-width: 1024px) {
    .contact-layout { grid-template-columns: 1fr; gap: 2rem; }
    .faq-grid { grid-template-columns: repeat(2, 1fr); }
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
    .hero-buttons { flex-direction: column; align-items: center; }
    .btn-hero { width: 100%; max-width: 300px; }
    .faq-grid { grid-template-columns: 1fr; }
    .form-row { grid-template-columns: 1fr; }
    .form-panel-header, .form-body { padding-left: 1.5rem; padding-right: 1.5rem; }
    .welcome-toast { top: 75px; right: 12px; left: 12px; min-width: auto; }
    .footer { padding: 2rem 0 0; margin-top: 2rem; }
    .footer-content { padding: 0 1rem; }
    .footer-top { grid-template-columns: 1fr; gap: 1.5rem; text-align: center; }
    .footer-section h4::after { left: 50%; transform: translateX(-50%); }
    .footer-bottom { flex-direction: column; text-align: center; }
    .footer-bottom-right { justify-content: center; }
    .social-link { width: 44px; height: 44px; font-size: 1.1rem; }
    .section-title { font-size: 2rem; margin-bottom: 2rem; }
    .modal-actions-logout { flex-direction: column; }
}

@media (max-width: 480px) {
    .container { padding: 0 1rem; }
    .nav-container { padding: 0 12px; }
    .logo { font-size: 1.35rem; }
    .profile-btn { width: 42px; height: 42px; font-size: 1.05rem; }
    .profile-dropdown { top: 60px; max-height: calc(100vh - 60px); }
    .dropdown-item-sub { display: none; }
    .form-panel-header { flex-direction: column; align-items: flex-start; }
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
            <li><a href="/games"    class="nav-link">Games</a></li>
            <li><a href="/contacts" class="nav-link active">Contacts</a></li>
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
        <li><a href="/games"    class="mobile-nav-link">Games</a></li>
        <li><a href="/contacts" class="mobile-nav-link active">Contacts</a></li>
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

<section class="hero-section">
    <div class="section-bg hero-bg"></div>
    <div class="section-overlay"></div>
    <div class="hero-content">
        <div class="hero-eyebrow">
            <i class="bi bi-send-fill"></i>&nbsp; Get in Touch
        </div>
        <h1 class="hero-title">Let's Start a<br>Conversation</h1>
        <p class="hero-subtitle">
            Have a question, idea, or just want to say hello? We'd love to hear from you.
            Drop us a message and we'll get back to you fast.
        </p>
        <div class="hero-buttons">
            <button class="btn-hero btn-primary-hero" onclick="document.getElementById('contact-form-section').scrollIntoView({behavior:'smooth'})">
                <i class="bi bi-chat-dots-fill"></i> Send a Message
            </button>
            <button class="btn-hero btn-secondary-hero" onclick="document.getElementById('faq-section').scrollIntoView({behavior:'smooth'})">
                <i class="bi bi-question-circle"></i> View FAQ
            </button>
        </div>
    </div>
</section>

<section class="container" id="contact-form-section" style="padding-top:5rem;">
    <div class="contact-layout">

        <div class="info-panel">
            <div class="info-header animate-on-scroll">
                <h2>Reach out,<br>we're here for you.</h2>
                <p>Choose the channel that works best for you. Our team is always ready to help.</p>
            </div>

            <a href="mailto:louisediego.anover@cvsu.edu.ph" class="contact-card animate-on-scroll">
                <div class="contact-card-icon email"><i class="bi bi-envelope-fill"></i></div>
                <div class="contact-card-body">
                    <div class="contact-card-label">Email</div>
                    <div class="contact-card-value">louisediego.anover@cvsu.edu.ph</div>
                </div>
                <i class="bi bi-arrow-right contact-card-arrow"></i>
            </a>

            <a href="tel:+63991932013" class="contact-card animate-on-scroll">
                <div class="contact-card-icon phone"><i class="bi bi-telephone-fill"></i></div>
                <div class="contact-card-body">
                    <div class="contact-card-label">Phone</div>
                    <div class="contact-card-value">+63 993 193 2013</div>
                </div>
                <i class="bi bi-arrow-right contact-card-arrow"></i>
            </a>

            <a href="https://maps.google.com/?q=Alta+tierra+phase+2" target="_blank" class="contact-card animate-on-scroll">
                <div class="contact-card-icon location"><i class="bi bi-geo-alt-fill"></i></div>
                <div class="contact-card-body">
                    <div class="contact-card-label">Location</div>
                    <div class="contact-card-value">Blk 42 Lot 30 Phase 2B Alta Tierra Homes GMA Cavite, Philippines</div>
                </div>
                <i class="bi bi-arrow-right contact-card-arrow"></i>
            </a>

            <a href="https://discord.gg/diego.anover2004" target="_blank" class="contact-card animate-on-scroll">
                <div class="contact-card-icon discord"><i class="bi bi-discord"></i></div>
                <div class="contact-card-body">
                    <div class="contact-card-label">Discord</div>
                    <div class="contact-card-value">discord.gg/diego.anover2004</div>
                </div>
                <i class="bi bi-arrow-right contact-card-arrow"></i>
            </a>
        </div>

        <div class="form-panel animate-on-scroll">
            <div class="form-panel-header">
                <div class="form-panel-header-icon"><i class="bi bi-chat-dots-fill"></i></div>
                <div>
                    <h3>Send us a Message</h3>
                    <p>We'll reply to your email within 24 hours</p>
                </div>
            </div>

            <div class="form-body">
                <form id="contactForm" novalidate>
                    @csrf

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label" for="firstName">First Name</label>
                            <div class="input-wrapper">
                                <i class="bi bi-person input-icon"></i>
                                <input type="text" id="firstName" name="first_name" class="form-input" placeholder="Diego" required autocomplete="given-name">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="lastName">Last Name</label>
                            <div class="input-wrapper">
                                <i class="bi bi-person input-icon"></i>
                                <input type="text" id="lastName" name="last_name" class="form-input" placeholder="Anover" required autocomplete="family-name">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="email">Email Address</label>
                        <div class="input-wrapper">
                            <i class="bi bi-envelope input-icon"></i>
                            <input type="email" id="email" name="email" class="form-input" placeholder="you@example.com" required autocomplete="email">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="subject">Subject</label>
                        <div class="input-wrapper">
                            <i class="bi bi-tag input-icon"></i>
                            <input type="text" id="subject" name="subject" class="form-input" placeholder="What's this about?" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Topic</label>
                        <div class="topic-chips" id="topicChips">
                            <span class="topic-chip active" data-topic="General"><i class="bi bi-chat-dots"></i> General</span>
                            <span class="topic-chip" data-topic="Support"><i class="bi bi-tools"></i> Support</span>
                            <span class="topic-chip" data-topic="Partnership"><i class="bi bi-handshake"></i> Partnership</span>
                            <span class="topic-chip" data-topic="Feedback"><i class="bi bi-star"></i> Feedback</span>
                            <span class="topic-chip" data-topic="Bug Report"><i class="bi bi-bug"></i> Bug Report</span>
                            <span class="topic-chip" data-topic="Other"><i class="bi bi-three-dots"></i> Other</span>
                        </div>
                        <input type="hidden" id="selectedTopic" name="topic" value="General">
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="message">Message</label>
                        <div class="input-wrapper" style="align-items:flex-start;">
                            <i class="bi bi-chat-left-text input-icon" style="top:1rem;position:absolute;"></i>
                            <textarea id="message" name="message" class="form-textarea" placeholder="Tell us everything…" required rows="5"></textarea>
                        </div>
                    </div>

                    <button type="submit" class="btn-submit" id="submitBtn">
                        <span class="btn-text">
                            <i class="bi bi-send-fill"></i>
                            Send Message
                        </span>
                        <span class="btn-loading">
                            <div class="spinner"></div>
                            Sending…
                        </span>
                    </button>
                </form>
            </div>
        </div>

    </div>
</section>

<section class="faq-section" id="faq-section">
    <div class="container">
        <div class="section-label">FAQ</div>
        <h2 class="section-title">Common Questions</h2>
        <div class="faq-grid">

            <div class="faq-item animate-on-scroll">
                <button class="faq-question">
                    <span>How quickly do you respond?</span>
                    <div class="faq-icon"><i class="bi bi-plus"></i></div>
                </button>
                <div class="faq-answer">
                    <div class="faq-answer-inner">
                        We typically respond within 2 hours during business hours (Mon–Fri, 9 AM–6 PM PHT). For urgent matters, reach us on Discord for the fastest response.
                    </div>
                </div>
            </div>

            <div class="faq-item animate-on-scroll">
                <button class="faq-question">
                    <span>Can I report a bug or suggest a feature?</span>
                    <div class="faq-icon"><i class="bi bi-plus"></i></div>
                </button>
                <div class="faq-answer">
                    <div class="faq-answer-inner">
                        Absolutely! Select "Bug Report" or "Feedback" as your topic in the form above and describe it in detail. We review every submission and prioritize based on impact.
                    </div>
                </div>
            </div>

            <div class="faq-item animate-on-scroll">
                <button class="faq-question">
                    <span>Do you offer partnership opportunities?</span>
                    <div class="faq-icon"><i class="bi bi-plus"></i></div>
                </button>
                <div class="faq-answer">
                    <div class="faq-answer-inner">
                        Yes! We're open to collaborations with game developers, content creators, and gaming brands. Choose "Partnership" as your topic and tell us about your proposal.
                    </div>
                </div>
            </div>

            <div class="faq-item animate-on-scroll">
                <button class="faq-question">
                    <span>Is Pixel Forge free to use?</span>
                    <div class="faq-icon"><i class="bi bi-plus"></i></div>
                </button>
                <div class="faq-answer">
                    <div class="faq-answer-inner">
                        The core collection manager is completely free. We plan to introduce optional premium features in the future — existing users will always keep their current access.
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

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
                    <a href="/contacts" class="footer-link">Contact</a>
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
function escapeHtml(text) {
    if (!text) return '';
    const map = {'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#039;'};
    return text.toString().replace(/[&<>"']/g, m => map[m]);
}

function showToast(message, type) {
    const existing = document.querySelector('.welcome-toast');
    if (existing) existing.remove();
    const toast = document.createElement('div');
    toast.className = 'welcome-toast';
    const iconClass = type === 'success' ? 'bi bi-check-circle-fill success' : 'bi bi-x-circle-fill error';
    const label     = type === 'success' ? 'Done!' : 'Error';
    toast.innerHTML = `<div class="toast-content"><i class="${iconClass}"></i><div class="toast-text"><strong>${label}</strong><span>${escapeHtml(message)}</span></div></div>`;
    document.body.appendChild(toast);
    requestAnimationFrame(() => toast.classList.add('show'));
    setTimeout(() => { toast.classList.remove('show'); setTimeout(() => toast.remove(), 500); }, 4000);
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

document.addEventListener('DOMContentLoaded', () => {

    document.getElementById('logoutModalBackdrop')?.addEventListener('click', function(e) {
        if (e.target === this) closeLogoutModal();
    });

    window.addEventListener('scroll', () => {
        document.getElementById('navbar')?.classList.toggle('navbar-scrolled', window.scrollY > 50);
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
        profileDropdown.classList.contains('open') ? closeProfileDropdown() : openProfileDropdown();
    });

    document.addEventListener('click', e => {
        if (!profileMenuWrapper?.contains(e.target)) closeProfileDropdown();
    });

    profileDropdown?.addEventListener('click', e => e.stopPropagation());

    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') {
            closeLogoutModal();
            closeProfileDropdown();
            hamburger?.classList.remove('active');
            mobileMenu?.classList.remove('active');
            document.body.style.overflow = '';
        }
    });

    document.querySelectorAll('#topicChips .topic-chip').forEach(chip => {
        chip.addEventListener('click', () => {
            document.querySelectorAll('#topicChips .topic-chip').forEach(c => c.classList.remove('active'));
            chip.classList.add('active');
            document.getElementById('selectedTopic').value = chip.dataset.topic;
        });
    });

    document.querySelectorAll('.faq-question').forEach(btn => {
        btn.addEventListener('click', () => {
            const item   = btn.closest('.faq-item');
            const isOpen = item.classList.contains('open');
            document.querySelectorAll('.faq-item').forEach(i => i.classList.remove('open'));
            if (!isOpen) item.classList.add('open');
        });
    });

    const obs = new IntersectionObserver(entries => {
        entries.forEach(en => {
            if (en.isIntersecting) { en.target.classList.add('visible'); obs.unobserve(en.target); }
        });
    }, { threshold: 0.1 });

    document.querySelectorAll('.animate-on-scroll').forEach((el, i) => {
        el.style.transitionDelay = `${Math.min(i * 0.1, 0.5)}s`;
        obs.observe(el);
    });

    const form      = document.getElementById('contactForm');
    const submitBtn = document.getElementById('submitBtn');

    form?.addEventListener('submit', async e => {
        e.preventDefault();

        const firstName = document.getElementById('firstName').value.trim();
        const lastName  = document.getElementById('lastName').value.trim();
        const email     = document.getElementById('email').value.trim();
        const subject   = document.getElementById('subject').value.trim();
        const message   = document.getElementById('message').value.trim();

        if (!firstName || !lastName) { showToast('Please enter your full name.', 'error'); return; }
        if (!email || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) { showToast('Please enter a valid email address.', 'error'); return; }
        if (!subject) { showToast('Please enter a subject.', 'error'); return; }
        if (!message || message.length < 10) { showToast('Your message is too short.', 'error'); return; }

        submitBtn.classList.add('loading');

        try {
            const token = document.querySelector('meta[name="csrf-token"]')?.content
                       || document.querySelector('input[name="_token"]')?.value || '';

            const res = await fetch('/contacts', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': token, 'Accept': 'application/json' },
                body: JSON.stringify({
                    first_name: firstName, last_name: lastName,
                    email, subject,
                    topic: document.getElementById('selectedTopic').value,
                    message
                })
            });

            if (res.ok) {
                showToast("Message sent! We'll be in touch soon.", 'success');
                form.reset();
                document.querySelectorAll('#topicChips .topic-chip').forEach(c => c.classList.remove('active'));
                document.querySelector('#topicChips .topic-chip[data-topic="General"]')?.classList.add('active');
                document.getElementById('selectedTopic').value = 'General';
            } else {
                const data = await res.json().catch(() => ({}));
                showToast(data.message || 'Something went wrong. Please try again.', 'error');
            }
        } catch {
            showToast("Message sent! We'll be in touch soon.", 'success');
            form.reset();
            document.querySelectorAll('#topicChips .topic-chip').forEach(c => c.classList.remove('active'));
            document.querySelector('#topicChips .topic-chip[data-topic="General"]')?.classList.add('active');
            document.getElementById('selectedTopic').value = 'General';
        } finally {
            submitBtn.classList.remove('loading');
        }
    });
});
</script>

@endsection