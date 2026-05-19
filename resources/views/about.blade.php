@extends('layouts.main')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<style>
*,
*::before,
*::after {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

html, body {
    margin: 0;
    padding: 0;
    overflow-x: hidden;
    scroll-behavior: smooth;
    font-family: system-ui, -apple-system, sans-serif;
    background: #0a0e1a;
    color: rgba(255, 255, 255, 0.9);
}

body {
    width: 100vw;
    position: relative;
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
    color: rgba(255, 255, 255, 0.9);
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
    background: linear-gradient(135deg, #5865F2, #FF2E63);
    transition: all 0.3s ease;
    transform: translateX(-50%);
    border-radius: 1px;
}

.nav-link:hover,
.nav-link.active {
    color: #fff;
}

.nav-link:hover::after,
.nav-link.active::after {
    width: 100%;
}

.profile-menu-wrapper {
    position: relative;
    z-index: 2;
}

.profile-btn {
    width: 52px;
    height: 52px;
    border-radius: 50%;
    background: linear-gradient(135deg, #5865F2, #FF2E63);
    border: 2.5px solid rgba(255, 255, 255, 0.35);
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
    box-shadow: 0 4px 16px rgba(88, 101, 242, 0.4);
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

.profile-btn:hover::before {
    transform: translateX(120%);
}

.profile-btn:hover {
    transform: scale(1.08);
    box-shadow: 0 8px 28px rgba(88, 101, 242, 0.6);
    border-color: rgba(255,255,255,0.6);
}

.profile-btn.open {
    box-shadow: 0 0 0 4px rgba(88, 101, 242, 0.45), 0 8px 28px rgba(88, 101, 242, 0.4);
    border-color: #5865F2;
}

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

.profile-dropdown.open {
    opacity: 1;
    visibility: visible;
    transform: translateY(0) scale(1);
}

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

.dropdown-avatar img {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 50%;
    display: block;
}

.dropdown-user-info {
    display: flex;
    flex-direction: column;
    gap: 3px;
    min-width: 0;
}

.dropdown-username {
    font-size: 0.95rem;
    font-weight: 700;
    color: #fff;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.dropdown-role {
    font-size: 0.75rem;
    color: rgba(255,255,255,0.5);
    font-weight: 500;
}

.dropdown-online {
    display: flex;
    align-items: center;
    gap: 5px;
    font-size: 0.72rem;
    color: #10B981;
    font-weight: 600;
}

.dropdown-online::before {
    content: '';
    width: 7px;
    height: 7px;
    border-radius: 50%;
    background: #10B981;
    box-shadow: 0 0 6px #10B981;
    flex-shrink: 0;
}

.dropdown-offline {
    display: flex;
    align-items: center;
    gap: 5px;
    font-size: 0.74rem;
    color: rgba(255,255,255,0.35);
    font-weight: 600;
}

.dropdown-offline::before {
    content: '';
    width: 7px;
    height: 7px;
    border-radius: 50%;
    background: rgba(255,255,255,0.25);
    flex-shrink: 0;
}

.dropdown-nav {
    padding: 10px 10px 0;
}

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

.dropdown-item::before {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, rgba(88, 101, 242, 0.12), rgba(255, 46, 99, 0.06));
    opacity: 0;
    transition: opacity 0.2s ease;
    border-radius: 12px;
}

.dropdown-item:hover::before {
    opacity: 1;
}

.dropdown-item:hover {
    color: #fff;
    transform: translateX(3px);
}

.dropdown-item-icon {
    width: 34px;
    height: 34px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
    flex-shrink: 0;
    transition: all 0.3s ease;
}

.dropdown-item:hover .dropdown-item-icon {
    transform: scale(1.1);
}

.dropdown-item-icon.profile-icon { background: linear-gradient(135deg, rgba(88,101,242,0.25), rgba(139,92,246,0.2)); color: #818CF8; }
.dropdown-item-icon.analytics-icon { background: linear-gradient(135deg, rgba(255,46,99,0.2), rgba(255,107,107,0.15)); color: #FF6B6B; }
.dropdown-item-icon.dashboard-icon { background: linear-gradient(135deg, rgba(8,247,254,0.2), rgba(0,201,167,0.15)); color: #08F7FE; }

.dropdown-item-text {
    display: flex;
    flex-direction: column;
    gap: 1px;
}

.dropdown-item-label {
    font-size: 0.88rem;
    font-weight: 600;
    color: inherit;
}

.dropdown-item-sub {
    font-size: 0.72rem;
    color: rgba(255,255,255,0.4);
    font-weight: 400;
}

.dropdown-item:hover .dropdown-item-sub {
    color: rgba(255,255,255,0.6);
}

.dropdown-item-arrow {
    margin-left: auto;
    font-size: 0.75rem;
    color: rgba(255,255,255,0.25);
    transition: all 0.2s ease;
    flex-shrink: 0;
}

.dropdown-item:hover .dropdown-item-arrow {
    color: rgba(255,255,255,0.6);
    transform: translateX(2px);
}

.dropdown-divider {
    height: 1px;
    background: rgba(255,255,255,0.07);
    margin: 10px 10px;
}

.dropdown-footer {
    padding: 0 10px 10px;
}

.dropdown-logout-btn {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 11px 14px;
    border-radius: 12px;
    color: rgba(255, 80, 100, 0.9);
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

.dropdown-logout-btn::before {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, rgba(255,46,99,0.15), rgba(255,46,99,0.08));
    opacity: 0;
    transition: opacity 0.2s ease;
    border-radius: 12px;
}

.dropdown-logout-btn:hover::before {
    opacity: 1;
}

.dropdown-logout-btn:hover {
    color: #FF2E63;
    transform: translateX(3px);
}

.dropdown-logout-icon {
    width: 34px;
    height: 34px;
    border-radius: 10px;
    background: linear-gradient(135deg, rgba(255,46,99,0.2), rgba(255,107,107,0.12));
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
    color: #FF2E63;
    flex-shrink: 0;
    transition: all 0.3s ease;
}

.dropdown-logout-btn:hover .dropdown-logout-icon {
    transform: scale(1.1);
    background: linear-gradient(135deg, rgba(255,46,99,0.35), rgba(255,107,107,0.2));
}

.mobile-menu {
    position: fixed;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    background: rgba(15, 23, 42, 0.98);
    backdrop-filter: blur(20px);
    z-index: 9999;
    transform: translateX(100%);
    transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    display: flex;
    flex-direction: column;
    padding: 100px 4% 2rem;
}

.mobile-menu.active {
    transform: translateX(0);
}

.mobile-nav-links {
    list-style: none;
    margin: 0;
    padding: 0;
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
    align-items: center;
    justify-content: center;
}

.mobile-nav-link {
    color: rgba(255, 255, 255, 0.95);
    text-decoration: none;
    font-weight: 600;
    font-size: clamp(1.1rem, 4vw, 1.3rem);
    padding: 12px 0;
    transition: all 0.3s ease;
}

.mobile-nav-link:hover,
.mobile-nav-link.active {
    color: #fff;
    transform: translateX(10px);
}

.mobile-profile-section {
    width: 100%;
    max-width: 340px;
    margin: 0 auto 2rem auto;
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.mobile-profile-header {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 16px 20px;
    background: linear-gradient(135deg, rgba(88,101,242,0.2), rgba(255,46,99,0.12));
    border: 1px solid rgba(88,101,242,0.25);
    border-radius: 18px;
    margin-bottom: 4px;
}

.mobile-profile-avatar {
    width: 56px;
    height: 56px;
    border-radius: 50%;
    background: linear-gradient(135deg, #5865F2, #FF2E63);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.4rem;
    font-weight: 800;
    color: #fff;
    text-transform: uppercase;
    flex-shrink: 0;
    border: 2.5px solid rgba(255,255,255,0.25);
    overflow: hidden;
    position: relative;
    box-shadow: 0 4px 16px rgba(88,101,242,0.4);
}

.mobile-profile-avatar img {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 50%;
    display: block;
}

.mobile-profile-info {
    display: flex;
    flex-direction: column;
    gap: 3px;
}

.mobile-profile-name {
    font-size: 1rem;
    font-weight: 700;
    color: #fff;
}

.mobile-profile-status {
    display: flex;
    align-items: center;
    gap: 5px;
    font-size: 0.75rem;
    color: #10B981;
    font-weight: 600;
}

.mobile-profile-status::before {
    content: '';
    width: 7px;
    height: 7px;
    border-radius: 50%;
    background: #10B981;
    box-shadow: 0 0 6px #10B981;
}

.mobile-profile-status.offline {
    color: rgba(255,255,255,0.35);
}

.mobile-profile-status.offline::before {
    background: rgba(255,255,255,0.25);
    box-shadow: none;
}

.mobile-menu-item {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 13px 18px;
    background: rgba(255,255,255,0.04);
    border: 1px solid rgba(255,255,255,0.07);
    border-radius: 14px;
    text-decoration: none;
    color: rgba(255,255,255,0.8);
    font-size: 0.92rem;
    font-weight: 600;
    transition: all 0.2s ease;
    cursor: pointer;
    width: 100%;
    text-align: left;
}

.mobile-menu-item:hover {
    background: rgba(88,101,242,0.15);
    border-color: rgba(88,101,242,0.3);
    color: #fff;
    transform: translateX(4px);
}

.mobile-menu-item.logout-item {
    color: rgba(255,80,100,0.9);
    border-color: rgba(255,46,99,0.15);
    background: rgba(255,46,99,0.06);
}

.mobile-menu-item.logout-item:hover {
    background: rgba(255,46,99,0.15);
    border-color: rgba(255,46,99,0.3);
    color: #FF2E63;
}

.mobile-menu-icon {
    width: 32px;
    height: 32px;
    border-radius: 9px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.95rem;
    flex-shrink: 0;
}

.mobile-menu-icon.p { background: linear-gradient(135deg, rgba(88,101,242,0.25), rgba(139,92,246,0.2)); color: #818CF8; }
.mobile-menu-icon.a { background: linear-gradient(135deg, rgba(255,46,99,0.2), rgba(255,107,107,0.15)); color: #FF6B6B; }
.mobile-menu-icon.d { background: linear-gradient(135deg, rgba(8,247,254,0.2), rgba(0,201,167,0.15)); color: #08F7FE; }
.mobile-menu-icon.l { background: linear-gradient(135deg, rgba(255,46,99,0.2), rgba(255,107,107,0.12)); color: #FF2E63; }

.hamburger {
    display: none;
    flex-direction: column;
    gap: 4px;
    cursor: pointer;
    padding: 8px;
    z-index: 10001;
}

.hamburger span {
    width: 24px;
    height: 2px;
    background: #fff;
    transition: all 0.3s ease;
    border-radius: 2px;
}

.hamburger.active span:nth-child(1) {
    transform: rotate(45deg) translate(6px, 6px);
}

.hamburger.active span:nth-child(2) {
    opacity: 0;
}

.hamburger.active span:nth-child(3) {
    transform: rotate(-45deg) translate(6px, -5px);
}

.hero-section, .timeline-section, .values-section, .testimonials-section, .stats-section {
    position: relative;
    overflow: hidden;
    width: 100vw;
    left: 50%;
    right: 50%;
    margin-left: -50vw;
    margin-right: -50vw;
    padding: 0 !important;
}

.hero-section {
    min-height: 100vh;
    padding-top: 70px;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
}

section {
    width: 100%;
    position: relative;
}

.section-bg {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-size: cover;
    background-position: center;
    image-rendering: auto;
    z-index: 0;
}

.hero-bg {
    background-image: url('/images/MIAMI.jpg');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
}

.timeline-bg {
    background-image: url('https://images.unsplash.com/photo-1558618047-3c8c76bbb17e?auto=format&fit=crop&w=2070&q=80');
}

.timeline-logo {
    width: 90px;
    height: 90px;
    margin: 0 auto 20px;
    border-radius: 22px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(255,255,255,0.08);
    border: 1px solid rgba(255,255,255,0.12);
    font-size: 42px;
    transition: 0.4s ease;
}

.values-bg {
    background-image: url('/images/city.jpg');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
}

.values-section .section-overlay {
    background:
        radial-gradient(circle at 20% 80%, rgba(88, 101, 242, 0.08), transparent 50%),
        radial-gradient(circle at 80% 20%, rgba(255, 46, 99, 0.05), transparent 50%),
        rgba(5, 8, 18, 0.18);
}

.stats-bg {
    background-image: url('https://images.unsplash.com/photo-1518709268805-4e9042af2176?auto=format&fit=crop&w=2070&q=80');
}

.testimonials-bg {
    background-image: url('https://images.unsplash.com/photo-1517457373958-b7bdd4587206?auto=format&fit=crop&w=2070&q=80');
}

.section-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 1;
    background:
        radial-gradient(circle at 20% 80%, rgba(88, 101, 242, 0.1), transparent 50%),
        radial-gradient(circle at 80% 20%, rgba(255, 46, 99, 0.07), transparent 50%),
        rgba(10, 15, 30, 0.45);
}

.hero-content {
    max-width: 900px;
    animation: fadeInUp 1s ease;
    position: relative;
    z-index: 2;
    width: 100%;
    padding: 0 4%;
    box-sizing: border-box;
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

.hero-buttons {
    display: flex;
    gap: 1.2rem;
    justify-content: center;
    flex-wrap: wrap;
}

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
}

.btn-primary-hero {
    background: linear-gradient(135deg, #FF2E63 0%, #08F7FE 50%, #5865F2 100%);
    color: #000;
    box-shadow: 0 12px 30px rgba(255, 46, 99, 0.4);
}

.btn-primary-hero:hover {
    transform: translateY(-4px);
    box-shadow: 0 20px 40px rgba(255, 46, 99, 0.6);
}

.btn-secondary-hero {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(15px);
    color: #fff;
    border: 2px solid rgba(255, 255, 255, 0.3);
}

.btn-secondary-hero:hover {
    background: rgba(255, 255, 255, 0.2);
    transform: translateY(-2px);
}

.timeline-section {
    padding: clamp(100px, 15vw, 140px) 0 clamp(80px, 12vw, 120px) 0 !important;
}

.stats-section {
    padding: clamp(100px, 15vw, 140px) 0 50px 0 !important;
    margin-bottom: 0 !important;
}

.stats-inner {
    padding-bottom: 0 !important;
    margin-bottom: 0 !important;
}

.footer {
    margin-top: 0 !important;
}

.values-section {
    padding: clamp(100px, 15vw, 140px) 0 !important;
    text-align: center;
    position: relative;
}

.testimonials-section {
    padding: clamp(100px, 15vw, 140px) 0 !important;
    position: relative;
}

.timeline-inner, .stats-inner, .values-inner, .testimonials-inner {
    max-width: 1400px;
    margin: 0 auto;
    padding: 0 4%;
    position: relative;
    z-index: 2;
}

.section-title {
    text-align: center;
    font-size: clamp(2rem, 6vw, 3.5rem);
    font-weight: 800;
    background: linear-gradient(135deg, #5865F2 0%, #FF2E63 50%, #08F7FE 100%);
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
    margin-bottom: clamp(3rem, 8vw, 4rem);
    letter-spacing: -0.3px;
}

.timeline-grid, .stats-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    grid-template-rows: repeat(2, 1fr);
    gap: clamp(1.5rem, 4vw, 2.5rem);
    max-width: 1200px;
    margin: 0 auto;
}

.feature-card {
    background: rgba(255, 255, 255, 0.05);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 24px;
    padding: clamp(1.8rem, 5vw, 2.2rem);
    text-align: center;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
    height: 100%;
    cursor: pointer;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.feature-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #5865F2, #FF2E63, #08F7FE);
    border-radius: 24px 24px 0 0;
    transition: all 0.3s ease;
}

.feature-card:hover {
    transform: translateY(-8px);
    background: rgba(255, 255, 255, 0.08);
    border-color: rgba(88, 101, 242, 0.3);
    box-shadow: 0 25px 50px rgba(0, 0, 0, 0.3);
}

.feature-card.clicked {
    transform: scale(0.95);
    background: rgba(88, 101, 242, 0.15);
}

.feature-icon {
    font-size: clamp(3rem, 10vw, 3.8rem);
    margin-bottom: 1.2rem;
    display: block;
    filter: drop-shadow(0 8px 16px rgba(88, 101, 242, 0.3));
    transition: all 0.3s ease;
}

.timeline-grid .feature-card:nth-child(1) .timeline-logo,
.stats-grid .feature-card:nth-child(1) .feature-icon {
    color: #00E5FF;
    background: linear-gradient(135deg, #00E5FF, #0099FF);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.timeline-grid .feature-card:nth-child(2) .timeline-logo,
.stats-grid .feature-card:nth-child(2) .feature-icon {
    color: #FF2E63;
    background: linear-gradient(135deg, #FF2E63, #FF7B54);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.timeline-grid .feature-card:nth-child(3) .timeline-logo,
.stats-grid .feature-card:nth-child(3) .feature-icon {
    color: #7C4DFF;
    background: linear-gradient(135deg, #7C4DFF, #B388FF);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.timeline-grid .feature-card:nth-child(4) .timeline-logo,
.stats-grid .feature-card:nth-child(4) .feature-icon {
    color: #00C853;
    background: linear-gradient(135deg, #00C853, #69F0AE);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.timeline-grid .feature-card:nth-child(5) .timeline-logo,
.stats-grid .feature-card:nth-child(5) .feature-icon {
    color: #FFD600;
    background: linear-gradient(135deg, #FFD600, #FF9100);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.timeline-grid .feature-card:nth-child(6) .timeline-logo,
.stats-grid .feature-card:nth-child(6) .feature-icon {
    color: #FF4081;
    background: linear-gradient(135deg, #FF4081, #F50057);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.feature-card:hover .timeline-logo,
.feature-card:hover .feature-icon {
    transform: scale(1.12) rotate(6deg);
    filter: drop-shadow(0 10px 20px rgba(255, 255, 255, 0.25));
}

.feature-title {
    font-size: clamp(1.2rem, 3.5vw, 1.4rem);
    font-weight: 700;
    margin-bottom: 1rem;
    color: #fff;
    line-height: 1.3;
}

.feature-desc {
    color: rgba(255, 255, 255, 0.85);
    line-height: 1.6;
    font-size: clamp(0.9rem, 2.2vw, 0.95rem);
}

.founder-testimonial {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: clamp(2rem, 6vw, 3rem);
    align-items: stretch;
    max-width: 1200px;
    margin: 0 auto;
}

.founder-content, .map-card {
    background: rgba(255, 255, 255, 0.05);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 24px;
    padding: clamp(2rem, 6vw, 2.5rem);
    position: relative;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    overflow: hidden;
    height: 100%;
    cursor: pointer;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    text-align: center;
}

.founder-content::before, .map-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #5865F2, #FF2E63, #08F7FE);
    border-radius: 24px 24px 0 0;
}

.founder-content:hover, .map-card:hover {
    transform: translateY(-12px);
    background: rgba(255, 255, 255, 0.08);
    border-color: rgba(88, 101, 242, 0.3);
    box-shadow: 0 25px 50px rgba(0, 0, 0, 0.3);
}

.founder-header {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1.5rem;
    width: 100%;
}

.founder-avatar {
    width: 110px;
    height: 110px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid rgba(255, 255, 255, 0.2);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
}

.founder-meta h3 {
    color: #fff;
    font-weight: 700;
    font-size: clamp(1.2rem, 3.5vw, 1.4rem);
    margin: 0 0 0.2rem 0;
    letter-spacing: -0.3px;
}

.founder-meta p {
    color: rgba(255, 255, 255, 0.85);
    font-size: 0.95rem;
    margin: 0;
    font-weight: 500;
}

.founder-content-text {
    color: rgba(255, 255, 255, 0.95);
    font-size: clamp(1rem, 2.5vw, 1.15rem);
    line-height: 1.6;
    font-style: italic;
    margin-bottom: 1.5rem;
    flex: 1;
}

.founder-preview {
    font-size: 0.95rem;
    color: rgba(255, 255, 255, 0.75);
    font-weight: 600;
    transition: all 0.3s ease;
}

.map-title {
    font-size: clamp(1.2rem, 3.5vw, 1.4rem);
    font-weight: 700;
    color: #fff;
    margin-bottom: 1rem;
    letter-spacing: -0.3px;
}

.map-subtitle {
    font-size: 1rem;
    color: rgba(255, 255, 255, 0.85);
    margin-bottom: 2rem;
    font-weight: 500;
}

.map-iframe-wrapper {
    position: relative;
    width: 100%;
    height: 0;
    padding-bottom: 55%;
    border-radius: 20px;
    overflow: hidden;
    border: 1px solid rgba(255, 255, 255, 0.15);
    flex-shrink: 0;
}

.map-iframe {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    border: none;
    border-radius: 18px;
}

.cta-content {
    max-width: 700px;
    margin: 0 auto;
}

.cta-title {
    font-size: clamp(2.2rem, 7vw, 4rem);
    font-weight: 900;
    background: linear-gradient(135deg, #FFFFFF 0%, #F8FAFC 100%);
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
    margin-bottom: 1.2rem;
}

.cta-text {
    font-size: clamp(1rem, 2.5vw, 1.3rem);
    color: rgba(255, 255, 255, 0.9);
    margin-bottom: 2.5rem;
    line-height: 1.6;
}

.values-stats {
    display: flex;
    gap: 1.2rem;
    justify-content: center;
    flex-wrap: wrap;
}

.values-stat {
    background: rgba(255, 255, 255, 0.12);
    backdrop-filter: blur(20px);
    padding: 1.5rem 2rem;
    border-radius: 24px;
    border: 1px solid rgba(255, 255, 255, 0.25);
    text-align: center;
    min-width: 150px;
    transition: all 0.3s ease;
}

.values-stat:hover {
    transform: translateY(-4px);
    box-shadow: 0 15px 35px rgba(88, 101, 242, 0.3);
}

.values-stat strong {
    display: block;
    font-size: clamp(1.8rem, 5vw, 2.2rem);
    font-weight: 800;
    color: #fff;
    margin-bottom: 0.5rem;
    letter-spacing: -0.3px;
}

.values-stat span {
    color: rgba(255, 255, 255, 0.9);
    font-size: 0.9rem;
    font-weight: 500;
}

.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    background: rgba(0, 0, 0, 0.85);
    backdrop-filter: blur(10px);
    z-index: 10001;
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    visibility: hidden;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}

.modal-overlay.active {
    opacity: 1;
    visibility: visible;
}

.modal-content {
    background: rgba(15, 23, 42, 0.98);
    backdrop-filter: blur(30px);
    border: 1px solid rgba(255, 255, 255, 0.15);
    border-radius: 24px;
    max-width: 90vw;
    max-height: 90vh;
    width: 600px;
    padding: 2.5rem;
    position: relative;
    transform: scale(0.7) translateY(50px);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    overflow-y: auto;
}

.modal-overlay.active .modal-content {
    transform: scale(1) translateY(0);
}

.modal-close {
    position: absolute;
    top: 1.5rem;
    right: 1.5rem;
    background: none;
    border: none;
    font-size: 2rem;
    color: rgba(255, 255, 255, 0.7);
    cursor: pointer;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
}

.modal-close:hover {
    background: rgba(255, 255, 255, 0.1);
    color: #fff;
    transform: rotate(90deg);
}

.modal-icon {
    font-size: 4.5rem;
    margin-bottom: 1.5rem;
    display: block;
    transition: all 0.3s ease;
}

.modal-icon.blue { background: linear-gradient(135deg, #00E5FF, #0099FF); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
.modal-icon.pink { background: linear-gradient(135deg, #FF2E63, #FF7B54); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
.modal-icon.purple { background: linear-gradient(135deg, #7C4DFF, #B388FF); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
.modal-icon.green { background: linear-gradient(135deg, #00C853, #69F0AE); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
.modal-icon.yellow { background: linear-gradient(135deg, #FFD600, #FF9100); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
.modal-icon.red { background: linear-gradient(135deg, #FF4081, #F50057); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }

.modal-title {
    font-size: 2rem;
    font-weight: 800;
    margin-bottom: 1rem;
    background: linear-gradient(135deg, #5865F2, #FF2E63);
    -webkit-background-clip: text;
    background-clip: text;
    -webkit-text-fill-color: transparent;
    color: transparent;
}

.modal-desc {
    color: rgba(255, 255, 255, 0.9);
    line-height: 1.8;
    font-size: 1.1rem;
    margin-bottom: 2rem;
}

.modal-features {
    list-style: none;
    padding: 0;
}

.modal-features li {
    padding: 0.8rem 0;
    color: rgba(255, 255, 255, 0.85);
    border-left: 3px solid rgba(88, 101, 242, 0.5);
    padding-left: 1.5rem;
    margin-bottom: 0.5rem;
}

.modal-backdrop {
    position: fixed;
    inset: 0;
    z-index: 20000;
    background: rgba(5, 8, 20, 0.82);
    backdrop-filter: blur(14px);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    visibility: hidden;
    transition: opacity 0.3s ease, visibility 0.3s ease;
}

.modal-backdrop.active { opacity: 1; visibility: visible; }

.modal-box {
    background: rgba(15, 23, 42, 0.98);
    border: 1px solid rgba(88, 101, 242, 0.35);
    border-radius: 22px;
    max-width: 400px;
    width: calc(100% - 32px);
    box-shadow: 0 24px 64px rgba(0, 0, 0, 0.6);
    transform: scale(0.92) translateY(16px);
    transition: transform 0.35s cubic-bezier(0.34, 1.56, 0.64, 1), opacity 0.3s ease;
    opacity: 0;
    overflow: hidden;
}

.modal-backdrop.active .modal-box { transform: scale(1) translateY(0); opacity: 1; }

.modal-head {
    padding: 16px 20px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.08);
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.modal-head.logout-head {
    background: linear-gradient(135deg, rgba(255, 46, 99, 0.35), rgba(8, 247, 254, 0.2));
}

.modal-head h3 { font-size: 0.95rem; font-weight: 700; color: #fff; text-transform: uppercase; letter-spacing: 0.5px; }

.modal-x {
    background: none;
    border: none;
    color: rgba(255, 255, 255, 0.6);
    font-size: 1.3rem;
    cursor: pointer;
    width: 34px;
    height: 34px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s;
    flex-shrink: 0;
}

.modal-x:hover { background: rgba(255, 255, 255, 0.1); color: #fff; transform: rotate(90deg); }

.modal-body-inner { padding: 28px 24px 10px; text-align: center; }

.modal-title-inner { font-size: 1.05rem; font-weight: 800; color: #fff; margin-bottom: 8px; }
.modal-desc-inner { font-size: 0.85rem; color: rgba(255, 255, 255, 0.55); line-height: 1.6; margin-bottom: 4px; }
.modal-sub { font-size: 0.78rem; color: rgba(255, 255, 255, 0.35); display: block; margin-top: 4px; }

.modal-actions { display: flex; gap: 10px; padding: 18px 24px 24px; }

.btn-modal {
    flex: 1;
    padding: 12px;
    border: none;
    border-radius: 12px;
    font-weight: 700;
    font-size: 0.86rem;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 7px;
    transition: all 0.25s;
}

.btn-modal-cancel {
    background: rgba(255, 255, 255, 0.07);
    border: 1.5px solid rgba(255, 255, 255, 0.12);
    color: rgba(255, 255, 255, 0.8);
}

.btn-modal-cancel:hover { background: rgba(255, 255, 255, 0.12); color: #fff; transform: translateY(-1px); }

.btn-modal-logout {
    background: linear-gradient(135deg, #FF2E63, #08F7FE);
    color: #000;
    box-shadow: 0 4px 16px rgba(255, 46, 99, 0.3);
}

.btn-modal-logout:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(255, 46, 99, 0.45); }

.footer {
    width: 100vw;
    position: relative;
    left: 50%;
    right: 50%;
    margin-left: -50vw;
    margin-right: -50vw;
    background: linear-gradient(180deg, rgba(15,23,42,0.98) 0%, rgba(10,15,30,1) 100%);
    backdrop-filter: blur(20px);
    border-top: 2px solid rgba(88, 101, 242, 0.3);
    padding: 3rem 0 0;
    margin-top: 2rem;
    overflow: hidden;
}

.footer::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 1px;
    background: linear-gradient(90deg, transparent, #5865F2, #FF2E63, #08F7FE, transparent);
}

.footer-content {
    max-width: 1400px;
    margin: 0 auto;
    padding: 0 2rem;
    position: relative;
    z-index: 2;
}

.footer-top {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 2rem;
    margin-bottom: 2rem;
}

.footer-brand {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.footer-brand h3 {
    font-size: clamp(1.6rem, 4vw, 2rem);
    font-weight: 900;
    background: linear-gradient(135deg, #5865F2 0%, #FF2E63 50%, #08F7FE 100%);
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
    margin: 0 0 0.5rem 0;
    letter-spacing: -0.5px;
}

.footer-brand p {
    color: rgba(255, 255, 255, 0.85);
    line-height: 1.7;
    font-size: clamp(0.95rem, 2.2vw, 1.05rem);
    margin: 0;
}

.newsletter-input {
    width: 100%;
    padding: 14px 20px;
    background: rgba(255, 255, 255, 0.06);
    backdrop-filter: blur(20px);
    border: 2px solid rgba(255, 255, 255, 0.12);
    border-radius: 16px;
    color: #fff;
    font-size: 0.95rem;
    font-weight: 500;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    margin-top: 1rem;
}

.newsletter-input::placeholder { color: rgba(255, 255, 255, 0.5); }

.newsletter-input:focus {
    outline: none;
    border-color: #5865F2;
    background: rgba(255, 255, 255, 0.1);
    box-shadow: 0 0 0 4px rgba(88, 101, 242, 0.15);
    transform: translateY(-1px);
}

.footer-section h4 {
    color: #fff;
    font-weight: 800;
    font-size: clamp(1.05rem, 2.5vw, 1.2rem);
    margin: 0 0 1.5rem 0;
    padding-bottom: 0.5rem;
    position: relative;
}

.footer-section h4::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 40px;
    height: 2px;
    background: linear-gradient(90deg, #5865F2, #FF2E63);
    border-radius: 1px;
}

.footer-links {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
    list-style: none;
    padding: 0;
    margin: 0;
}

.footer-link {
    color: rgba(255, 255, 255, 0.85);
    text-decoration: none;
    font-weight: 500;
    font-size: 0.95rem;
    padding: 8px 0 8px 4px;
    transition: all 0.3s ease;
    position: relative;
    border-radius: 8px;
    display: block;
}

.footer-link::before {
    content: '';
    position: absolute;
    left: 0;
    top: 50%;
    width: 0;
    height: 2px;
    background: linear-gradient(90deg, #5865F2, #FF2E63);
    transition: width 0.3s ease;
    transform: translateY(-50%);
    border-radius: 1px;
}

.footer-link:hover { color: #fff; padding-left: 12px; background: rgba(255, 255, 255, 0.05); }
.footer-link:hover::before { width: 6px; }

.footer-bottom {
    border-top: 1px solid rgba(255, 255, 255, 0.08);
    padding: 1.5rem 0;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 1rem;
    text-align: center;
}

.footer-bottom-left {
    color: rgba(255, 255, 255, 0.6);
    font-size: 0.9rem;
    font-weight: 500;
    margin: 0;
    letter-spacing: 0.5px;
}

.footer-bottom-right { display: flex; gap: 1rem; margin: 0; padding: 0; }

.social-link {
    width: 48px;
    height: 48px;
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
    color: #fff;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.1);
    flex-shrink: 0;
}

.social-link.fb { background: linear-gradient(135deg, #1877F2, #0E5A8A); }
.social-link.ig { background: linear-gradient(135deg, #E4405F, #F77737, #8338EC); }
.social-link.x  { background: linear-gradient(135deg, #000000, #1D9BF0); }
.social-link.tg { background: linear-gradient(135deg, #0088CC, #00BFFF); }

.social-link:hover {
    transform: translateY(-4px) scale(1.08);
    box-shadow: 0 15px 35px rgba(88, 101, 242, 0.4);
    border-color: rgba(88, 101, 242, 0.3);
}

@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(40px); }
    to { opacity: 1; transform: translateY(0); }
}

@keyframes fadeInDown {
    from { opacity: 0; transform: translateY(-30px); }
    to { opacity: 1; transform: translateY(0); }
}

@keyframes fadeInLeft {
    from { opacity: 0; transform: translateX(-40px); }
    to { opacity: 1; transform: translateX(0); }
}

@keyframes fadeInScale {
    from { opacity: 0; transform: scale(0.85); }
    to { opacity: 1; transform: scale(1); }
}

.animate-on-scroll {
    opacity: 0;
    transform: translateY(30px);
    transition: opacity 0.6s ease, transform 0.6s ease;
}

.animate-on-scroll.visible {
    opacity: 1;
    transform: translateY(0);
}

.values-title-anim {
    opacity: 0;
    transform: translateY(-30px);
    transition: opacity 0.7s cubic-bezier(0.4,0,0.2,1), transform 0.7s cubic-bezier(0.4,0,0.2,1);
}

.values-title-anim.visible {
    opacity: 1;
    transform: translateY(0);
}

.values-text-anim {
    opacity: 0;
    transform: translateY(20px);
    transition: opacity 0.7s cubic-bezier(0.4,0,0.2,1) 0.15s, transform 0.7s cubic-bezier(0.4,0,0.2,1) 0.15s;
}

.values-text-anim.visible {
    opacity: 1;
    transform: translateY(0);
}

.values-stat-anim {
    opacity: 0;
    transform: scale(0.82) translateY(24px);
    transition: opacity 0.6s cubic-bezier(0.34,1.56,0.64,1), transform 0.6s cubic-bezier(0.34,1.56,0.64,1);
}

.values-stat-anim.visible {
    opacity: 1;
    transform: scale(1) translateY(0);
}

@media (max-width: 1024px) {
    .timeline-grid, .stats-grid { grid-template-columns: repeat(2, 1fr); gap: 2rem; }
    .founder-testimonial { grid-template-columns: 1fr; gap: 2.5rem; }
    .profile-dropdown {
        position: fixed;
        top: 65px;
        right: 0;
        left: 0;
        width: 100vw;
        border-radius: 0 0 20px 20px;
        border-top: none;
        transform-origin: top center;
        max-height: calc(100vh - 65px);
        overflow-y: auto;
    }
}

@media (max-width: 768px) {
    .navbar-landing { padding: 0 3%; height: 65px; }
    .navbar-scrolled { height: 60px; }
    .hero-section { padding-top: 65px; }
    .nav-links { display: none; }
    .hamburger { display: flex; }
    .auth-buttons {
        display: flex;
        align-items: center;
        margin-left: auto;
        margin-right: 0.5rem;
    }
    .nav-container {
        justify-content: space-between;
        gap: 0;
    }
    .profile-btn { width: 46px; height: 46px; font-size: 1.15rem; }
    .profile-dropdown {
        position: fixed;
        top: 65px;
        right: 0;
        left: 0;
        width: 100vw;
        border-radius: 0 0 20px 20px;
        border-top: none;
        transform-origin: top center;
        max-height: calc(100vh - 65px);
        overflow-y: auto;
    }
    .dropdown-header { padding: 18px 20px; }
    .dropdown-avatar { width: 58px; height: 58px; font-size: 1.4rem; }
    .dropdown-nav { padding: 6px 10px 0; }
    .dropdown-footer { padding: 0 10px 10px; }
    .mobile-profile-section { display: none; }
    .timeline-grid, .stats-grid { grid-template-columns: 1fr; gap: 1.5rem; }
    .hero-buttons { flex-direction: column; align-items: center; }
    .btn-hero { width: 100%; max-width: 300px; }
    .timeline-inner, .values-inner, .testimonials-inner, .stats-inner { padding: 0 3%; }
    .founder-testimonial { gap: 2rem; }
    .founder-content, .map-card { padding: 2rem; }
    .modal-content { width: 95vw; padding: 2rem; margin: 1rem; }
    .footer { padding: 2rem 0 0; margin-top: 1rem; }
    .footer-content { padding: 0 1rem; }
    .footer-top { grid-template-columns: 1fr; gap: 1.5rem; text-align: center; }
    .footer-section h4::after { left: 50%; transform: translateX(-50%); }
    .footer-bottom-right { justify-content: center; }
    .values-stats { flex-direction: column; align-items: center; gap: 1rem; }
    .values-stat { min-width: 280px; }
    .modal-actions { flex-direction: column; }
    .btn-modal { width: 100%; }
}

@media (max-width: 480px) {
    .timeline-inner, .values-inner, .testimonials-inner, .stats-inner { padding: 0 2.5%; }
    .nav-container { padding: 0 12px; }
    .profile-btn { width: 42px; height: 42px; font-size: 1.05rem; }
    .profile-dropdown { top: 60px; max-height: calc(100vh - 60px); }
    .dropdown-item-sub { display: none; }
    .footer { padding: 1.5rem 0 0; }
    .footer-content { padding: 0 1rem; }
    .footer-top { gap: 1rem; }
    .hero-title { font-size: clamp(2rem, 10vw, 3rem); }
    .section-title { font-size: clamp(1.8rem, 7vw, 2.5rem); }
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
        <div class="modal-actions">
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
        <div class="logo">Pixel Forge</div>

        <ul class="nav-links">
            <li><a href="/landing" class="nav-link">Home</a></li>
            <li><a href="/about" class="nav-link active">About</a></li>
            <li><a href="/games" class="nav-link">Games</a></li>
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
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
</nav>

<div class="mobile-menu" id="mobileMenu">
    <ul class="mobile-nav-links">
        <li><a href="/landing" class="mobile-nav-link">Home</a></li>
        <li><a href="/about" class="mobile-nav-link active">About</a></li>
        <li><a href="/games" class="mobile-nav-link">Games</a></li>
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

<section id="hero" class="hero-section">
    <div class="section-bg hero-bg"></div>
    <div class="section-overlay"></div>
    <div class="hero-content">
        <h1 class="hero-title">Forged in Pixels, Built for Players</h1>
        <p class="hero-subtitle">
            Since 2021, we've crafted 50+ unforgettable games played by 1K+ gamers worldwide.
            This is our story.
        </p>
        <div class="hero-buttons">
            <a href="#timeline" class="btn-hero btn-primary-hero">Our Journey</a>
            <a href="#values" class="btn-hero btn-secondary-hero">Our Values</a>
        </div>
    </div>
</section>

<section id="timeline" class="timeline-section">
    <div class="section-bg timeline-bg"></div>
    <div class="section-overlay"></div>
    <div class="timeline-inner">
        <h2 class="section-title">My Journey Building Pixel Forge</h2>
        <div class="timeline-grid">
            <div class="feature-card" data-modal="start">
                <div class="timeline-logo"><i class="bi bi-code-slash"></i></div>
                <h3 class="feature-title">2021 - Learning Game Development</h3>
                <p class="feature-desc">Started learning programming and game design in General Mariano Alvarez, Cavite. Built small projects using free tools and online tutorials while studying.</p>
            </div>
            <div class="feature-card" data-modal="freelance">
                <div class="timeline-logo"><i class="bi bi-laptop"></i></div>
                <h3 class="feature-title">2022 - First Client Projects</h3>
                <p class="feature-desc">Created simple websites, UI concepts, and small game prototypes for friends and local clients to improve experience and portfolio quality.</p>
            </div>
            <div class="feature-card" data-modal="forge">
                <div class="timeline-logo"><i class="bi bi-controller"></i></div>
                <h3 class="feature-title">2023 - Building Pixel Forge</h3>
                <p class="feature-desc">Officially started Pixel Forge as an independent creative studio focused on modern web experiences, digital art, and indie game concepts.</p>
            </div>
            <div class="feature-card" data-modal="skills">
                <div class="timeline-logo"><i class="bi bi-palette"></i></div>
                <h3 class="feature-title">2024 - Expanding Skills</h3>
                <p class="feature-desc">Learned Laravel, UI/UX design, animation, and responsive frontend development to create more professional and interactive projects.</p>
            </div>
            <div class="feature-card" data-modal="community">
                <div class="timeline-logo"><i class="bi bi-people"></i></div>
                <h3 class="feature-title">2025 - Growing Online Presence</h3>
                <p class="feature-desc">Shared projects online, connected with developers and gamers, and continued improving Pixel Forge through feedback and collaboration.</p>
            </div>
            <div class="feature-card" data-modal="future">
                <div class="timeline-logo"><i class="bi bi-stars"></i></div>
                <h3 class="feature-title">2026 - Future Vision</h3>
                <p class="feature-desc">At 21 years old, continuing to grow Pixel Forge into a creative brand capable of building games, applications, and immersive digital experiences.</p>
            </div>
        </div>
    </div>
</section>

<section id="values" class="values-section">
    <div class="section-bg values-bg"></div>
    <div class="section-overlay"></div>
    <div class="values-inner">
        <div class="cta-content">
            <h2 class="cta-title values-title-anim">Player-First, Always</h2>
            <p class="cta-text values-text-anim">We don't chase trends. We create moments that stick with players for years. Every line of code serves the player experience.</p>
            <div class="values-stats">
                <div class="values-stat values-stat-anim" style="transition-delay:0.25s;">
                    <strong>1000+</strong><span>Players Served</span>
                </div>
                <div class="values-stat values-stat-anim" style="transition-delay:0.4s;">
                    <strong>No 1.</strong><span>Game Website in the Philippines</span>
                </div>
                <div class="values-stat values-stat-anim" style="transition-delay:0.55s;">
                    <strong>9.3</strong><span>Average Rating</span>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="testimonials" class="testimonials-section">
    <div class="section-bg testimonials-bg"></div>
    <div class="section-overlay"></div>
    <div class="testimonials-inner">
        <h2 class="section-title">What Our Founder Says</h2>
        <div class="founder-testimonial">
            <div class="founder-content" data-modal="founder">
                <div class="founder-header">
                    <img src="images/ito.jpg" alt="Founder" class="founder-avatar">
                    <div class="founder-meta">
                        <h3>Louise Diego L. Añover</h3>
                        <p>Founder And CEO</p>
                    </div>
                </div>
                <div class="founder-content-text">
                    "We started with nothing but passion. Today, 1000+ players trust us to deliver unforgettable experiences. This is just the beginning."
                </div>
                <div class="founder-preview">Read full story →</div>
            </div>
            <div class="map-card" data-modal="map">
                <h3 class="map-title">Worldwide Studio</h3>
                <p class="map-subtitle">Remote-first team serving players globally</p>
                <div class="map-iframe-wrapper">
                    <iframe class="map-iframe" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7674.271819695169!2d121.01187662378508!3d14.316073831937022!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397d7775e12b6ab%3A0x3d3c7f3f40cc1e3c!2sAlta%20tierra%20phase%202!5e1!3m2!1sen!2sph!4v1778466089349!5m2!1sen!2sph" allowfullscreen="" loading="lazy"></iframe>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="stats" class="stats-section">
    <div class="section-bg stats-bg"></div>
    <div class="section-overlay"></div>
    <div class="stats-inner">
        <h2 class="section-title">By The Numbers</h2>
        <div class="stats-grid">
            <div class="feature-card" data-modal="platforms">
                <span class="feature-icon"><i class="bi bi-phone"></i></span>
                <h3 class="feature-title">Platforms Supported</h3>
                <p class="feature-desc">Games available on web, PC, and mobile devices for a wide range of players.</p>
            </div>
            <div class="feature-card" data-modal="global">
                <span class="feature-icon"><i class="bi bi-globe"></i></span>
                <h3 class="feature-title">Global Players</h3>
                <p class="feature-desc">Our games have reached players in over 20 countries, with localized content in 3 languages.</p>
            </div>
            <div class="feature-card" data-modal="uptime">
                <span class="feature-icon"><i class="bi bi-lightning-charge"></i></span>
                <h3 class="feature-title">Reliable Servers</h3>
                <p class="feature-desc">Our multiplayer features maintain stable performance with minimal downtime.</p>
            </div>
            <div class="feature-card" data-modal="bootstrapped">
                <span class="feature-icon"><i class="bi bi-cash-coin"></i></span>
                <h3 class="feature-title">Independently Funded</h3>
                <p class="feature-desc">Operated without external investors, focusing on sustainable growth and player experience.</p>
            </div>
            <div class="feature-card" data-modal="teamSize">
                <span class="feature-icon"><i class="bi bi-people"></i></span>
                <h3 class="feature-title">Team Members</h3>
                <p class="feature-desc">A small, dedicated team of 5–10 developers and artists, collaborating remotely.</p>
            </div>
            <div class="feature-card" data-modal="retention">
                <span class="feature-icon"><i class="bi bi-bar-chart-line"></i></span>
                <h3 class="feature-title">Player Engagement</h3>
                <p class="feature-desc">Many players return for updates and new releases, showing steady engagement over time.</p>
            </div>
        </div>
    </div>
</section>

<div id="modal-template" class="modal-overlay">
    <div class="modal-content">
        <button class="modal-close">&times;</button>
        <span class="modal-icon" id="modal-icon"></span>
        <h2 class="modal-title" id="modal-title"></h2>
        <p class="modal-desc" id="modal-desc"></p>
        <ul class="modal-features" id="modal-features"></ul>
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
            <div class="footer-bottom-left">&copy; 2026 Pixel Forge Studios. All rights reserved.</div>
            <div class="footer-bottom-right">
                <a href="https://www.facebook.com/rulesofsurvival2004" target="_blank" rel="noopener" class="social-link fb" title="Facebook">
                    <svg viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                </a>
                <a href="https://www.instagram.com/diegzzz_0/" target="_blank" rel="noopener" class="social-link ig" title="Instagram">
                    <svg viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><circle cx="12" cy="12" r="4"/><circle cx="18" cy="6" r="1"/></svg>
                </a>
                <a href="https://x.com/Diego_Anover" target="_blank" rel="noopener" class="social-link x" title="X (Twitter)">
                    <svg viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.3L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                </a>
                <a href="http://t.me/diegzzz_0" target="_blank" rel="noopener" class="social-link tg" title="Telegram">
                    <svg viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><path d="M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0a12 12 0 0 0-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 0 1 .171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.48.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z"/></svg>
                </a>
            </div>
        </div>
    </div>
</footer>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const navbar = document.getElementById('navbar');
    const hamburger = document.getElementById('hamburger');
    const mobileMenu = document.getElementById('mobileMenu');
    const profileBtn = document.getElementById('profileBtn');
    const profileDropdown = document.getElementById('profileDropdown');
    const profileMenuWrapper = document.getElementById('profileMenuWrapper');

    const revealObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                revealObserver.unobserve(entry.target);
            }
        });
    }, { threshold: 0.12 });

    document.querySelectorAll('.feature-card, .founder-content, .map-card, .section-title').forEach((el, i) => {
        el.classList.add('animate-on-scroll');
        el.style.transitionDelay = `${(i % 6) * 0.08}s`;
        revealObserver.observe(el);
    });

    document.querySelectorAll('.values-title-anim, .values-text-anim, .values-stat-anim').forEach(el => {
        revealObserver.observe(el);
    });

    window.addEventListener('scroll', () => {
        navbar.classList.toggle('navbar-scrolled', window.scrollY > 50);
    });

    profileBtn?.addEventListener('click', (e) => {
        e.stopPropagation();
        const isOpen = profileDropdown.classList.contains('open');
        if (isOpen) {
            closeProfileDropdown();
        } else {
            openProfileDropdown();
        }
    });

    document.addEventListener('click', (e) => {
        if (!profileMenuWrapper?.contains(e.target)) {
            closeProfileDropdown();
        }
    });

    profileDropdown?.addEventListener('click', (e) => {
        e.stopPropagation();
    });

    hamburger?.addEventListener('click', () => {
        hamburger.classList.toggle('active');
        mobileMenu.classList.toggle('active');
        document.body.style.overflow = mobileMenu.classList.contains('active') ? 'hidden' : '';
    });

    document.querySelectorAll('.mobile-nav-link').forEach(link => {
        link.addEventListener('click', () => {
            hamburger.classList.remove('active');
            mobileMenu.classList.remove('active');
            document.body.style.overflow = '';
        });
    });

    mobileMenu?.addEventListener('click', (e) => {
        if (e.target === mobileMenu) {
            hamburger.classList.remove('active');
            mobileMenu.classList.remove('active');
            document.body.style.overflow = '';
        }
    });

    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                window.scrollTo({ top: target.offsetTop - 80, behavior: 'smooth' });
            }
        });
    });

    const modalTemplate = document.getElementById('modal-template');
    const modalIcon = document.getElementById('modal-icon');
    const modalTitle = document.getElementById('modal-title');
    const modalDesc = document.getElementById('modal-desc');
    const modalFeatures = document.getElementById('modal-features');

    const modals = {
        start: { icon: '<i class="bi bi-code-slash"></i>', title: '2021 - Learning Game Development', desc: 'Started learning programming and game design in GMA Cavite.', features: ['HTML & CSS', 'JavaScript basics', 'Game concepts', 'Self learning'] },
        freelance: { icon: '<i class="bi bi-laptop"></i>', title: '2022 - First Client Projects', desc: 'Created simple websites and UI projects for local clients.', features: ['Portfolio projects', 'Responsive websites', 'UI design', 'Freelance experience'] },
        forge: { icon: '<i class="bi bi-controller"></i>', title: '2023 - Building Pixel Forge', desc: 'Started Pixel Forge as an indie creative studio.', features: ['Brand creation', 'Game concepts', 'Creative direction', 'Independent studio'] },
        skills: { icon: '<i class="bi bi-palette"></i>', title: '2024 - Expanding Skills', desc: 'Focused on Laravel, UI/UX, and frontend development.', features: ['Laravel', 'Responsive UI', 'Animations', 'Modern web design'] },
        community: { icon: '<i class="bi bi-people"></i>', title: '2025 - Growing Online Presence', desc: 'Connected with developers and shared projects online.', features: ['Community growth', 'Project sharing', 'Networking', 'Collaboration'] },
        future: { icon: '<i class="bi bi-stars"></i>', title: '2026 - Future Vision', desc: 'Continuing to grow Pixel Forge into a creative gaming brand.', features: ['Future games', 'Creative projects', 'Web applications', 'Digital experiences'] },
        founder: { icon: '<i class="bi bi-person-badge"></i>', title: 'Founder Story', desc: 'The journey of building Pixel Forge from passion and creativity.', features: ['Self taught', 'Creative vision', 'Independent development', 'Future ambitions'] },
        map: { icon: '<i class="bi bi-globe"></i>', title: 'Worldwide Studio', desc: 'Remote-first setup serving players globally.', features: ['Remote work', 'Global audience', 'Online collaboration', 'Digital creativity'] },
        platforms: { icon: '<i class="bi bi-phone"></i>', title: 'Platforms Mastered', desc: 'iOS, Android, Steam, consoles, web. We ship everywhere players are.', features: ['iOS', 'Android', 'Steam', 'Web', 'Consoles'] },
        global: { icon: '<i class="bi bi-globe"></i>', title: 'Global Reach', desc: 'Players in 150+ countries. 12 languages supported natively.', features: ['20 countries', '3 languages', 'Global community'] },
        uptime: { icon: '<i class="bi bi-lightning-charge"></i>', title: '99.9% Uptime', desc: 'Our multiplayer games never go down. Battle-tested infrastructure.', features: ['Reliable servers', 'Optimized infrastructure', '99.9% uptime'] },
        bootstrapped: { icon: '<i class="bi bi-cash-coin"></i>', title: 'Bootstrapped', desc: 'Profitable since year 1. No VC. Pure focus on players.', features: ['Independent', 'Profitable', 'Player-first'] },
        teamSize: { icon: '<i class="bi bi-people"></i>', title: '25 Creators', desc: 'Lean team of AAA veterans. Remote-first, results-driven.', features: ['5-10 Developers', 'AAA experience', 'Remote-first', 'Results-driven'] },
        retention: { icon: '<i class="bi bi-bar-chart-line"></i>', title: '65% Retention', desc: 'Day 30 retention beats industry average by 2x. Players keep coming back.', features: ['High retention', 'Player engagement', 'Industry-leading'] }
    };

    const colorMap = {
        start: 'blue', freelance: 'pink', forge: 'purple',
        skills: 'green', community: 'yellow', future: 'red',
        founder: 'pink', map: 'blue',
        platforms: 'blue', global: 'purple', uptime: 'yellow',
        bootstrapped: 'green', teamSize: 'pink', retention: 'red'
    };

    function openModal(key) {
        const data = modals[key];
        if (!data) return;
        modalIcon.innerHTML = data.icon;
        modalIcon.className = `modal-icon ${colorMap[key] || 'blue'}`;
        modalTitle.textContent = data.title;
        modalDesc.textContent = data.desc;
        modalFeatures.innerHTML = '';
        data.features.forEach(feature => {
            const li = document.createElement('li');
            li.textContent = feature;
            modalFeatures.appendChild(li);
        });
        modalTemplate.classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    document.querySelectorAll('.feature-card, .founder-content, .map-card').forEach(card => {
        card.addEventListener('click', () => openModal(card.dataset.modal));
    });

    function closeModal() {
        modalTemplate.classList.remove('active');
        document.body.style.overflow = '';
    }

    document.querySelector('.modal-close')?.addEventListener('click', closeModal);

    modalTemplate?.addEventListener('click', (e) => {
        if (e.target === modalTemplate) closeModal();
    });

    document.getElementById('logoutModalBackdrop')?.addEventListener('click', function(e) {
        if (e.target === this) closeLogoutModal();
    });

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            closeModal();
            closeLogoutModal();
            closeProfileDropdown();
            hamburger.classList.remove('active');
            mobileMenu.classList.remove('active');
            document.body.style.overflow = '';
        }
    });
});

function openProfileDropdown() {
    const btn = document.getElementById('profileBtn');
    const dropdown = document.getElementById('profileDropdown');
    btn?.classList.add('open');
    dropdown?.classList.add('open');
    btn?.setAttribute('aria-expanded', 'true');
}

function closeProfileDropdown() {
    const btn = document.getElementById('profileBtn');
    const dropdown = document.getElementById('profileDropdown');
    btn?.classList.remove('open');
    dropdown?.classList.remove('open');
    btn?.setAttribute('aria-expanded', 'false');
}

function openLogoutModal() {
    document.getElementById('logoutModalBackdrop').classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeLogoutModal() {
    document.getElementById('logoutModalBackdrop').classList.remove('active');
    document.body.style.overflow = '';
}
</script>
@endsection