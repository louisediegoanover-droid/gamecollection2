@extends('layouts.main')

@section('content')
@php use Illuminate\Support\Facades\Storage; @endphp
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0;}

html,body{
    margin:0;padding:0;overflow-x:hidden;
    font-family:system-ui,-apple-system,sans-serif;
    background:#0a0e1a;
    color:rgba(255,255,255,0.9);
    min-height:100vh;
}

:root{
    --sidebar-w:260px;
    --topbar-h:65px;
    --accent:#5865F2;
    --pink:#FF2E63;
    --cyan:#08F7FE;
}

.dashboard{
    display:flex;
    min-height:100vh;
    background:
        radial-gradient(circle at top left,rgba(88,101,242,0.18),transparent 55%),
        radial-gradient(circle at bottom right,rgba(255,46,99,0.14),transparent 55%),
        #0a0e1a;
}

.sidebar{
    width:var(--sidebar-w);
    min-height:100vh;
    position:fixed;
    top:0;left:0;
    z-index:1000;
    backdrop-filter:blur(24px);
    background:rgba(15,23,42,0.97);
    border-right:1px solid rgba(88,101,242,0.25);
    display:flex;
    flex-direction:column;
    transition:transform 0.4s cubic-bezier(0.4,0,0.2,1);
    box-shadow:4px 0 30px rgba(0,0,0,0.4);
}

.sidebar-brand{
    padding:24px 20px 20px;
    border-bottom:1px solid rgba(255,255,255,0.07);
    display:flex;
    align-items:center;
    justify-content:space-between;
}

.sidebar-logo{
    font-size:1.5rem;
    font-weight:900;
    background:linear-gradient(135deg,#5865F2 0%,#FF2E63 50%,#08F7FE 100%);
    -webkit-background-clip:text;
    background-clip:text;
    color:transparent;
    letter-spacing:-0.3px;
}

.sidebar-close{
    display:none;
    background:none;
    border:none;
    color:rgba(255,255,255,0.6);
    font-size:1.4rem;
    cursor:pointer;
    width:36px;height:36px;
    border-radius:10px;
    align-items:center;justify-content:center;
    transition:all 0.2s;
}

.sidebar-close:hover{background:rgba(255,255,255,0.08);color:#fff;}

.sidebar-nav{
    flex:1;
    padding:16px 12px;
    display:flex;
    flex-direction:column;
    gap:4px;
    overflow-y:auto;
}

.sidebar-nav a{
    display:flex;
    align-items:center;
    gap:12px;
    padding:12px 16px;
    border-radius:12px;
    color:rgba(255,255,255,0.75);
    text-decoration:none;
    font-weight:500;
    font-size:0.92rem;
    transition:all 0.25s ease;
    position:relative;
    overflow:hidden;
}

.sidebar-nav a i{font-size:1.15rem;flex-shrink:0;transition:transform 0.25s ease;}

.sidebar-nav a:hover{color:#fff;background:rgba(88,101,242,0.12);transform:translateX(4px);}
.sidebar-nav a:hover i{transform:scale(1.15);}

.sidebar-nav a.active{
    color:#fff;
    background:linear-gradient(135deg,rgba(88,101,242,0.25),rgba(255,46,99,0.15));
    border-left:3px solid #FF2E63;
    padding-left:13px;
    box-shadow:0 4px 20px rgba(88,101,242,0.2);
}

.sidebar-footer{
    padding:16px 12px 20px;
    border-top:1px solid rgba(255,255,255,0.07);
}

.logout-btn{
    width:100%;
    background:linear-gradient(135deg,#FF2E63 0%,#08F7FE 100%);
    border:none;border-radius:12px;
    padding:13px;font-weight:700;font-size:0.88rem;
    color:#000;cursor:pointer;
    display:flex;align-items:center;justify-content:center;gap:8px;
    transition:all 0.3s ease;
    box-shadow:0 6px 20px rgba(255,46,99,0.3);
}

.logout-btn:hover{transform:translateY(-2px);box-shadow:0 10px 28px rgba(255,46,99,0.45);}

.main{
    flex:1;
    margin-left:var(--sidebar-w);
    display:flex;
    flex-direction:column;
    min-height:100vh;
    transition:margin-left 0.4s cubic-bezier(0.4,0,0.2,1);
}

.topbar{
    position:sticky;top:0;z-index:500;
    height:var(--topbar-h);
    backdrop-filter:blur(20px);
    background:rgba(15,23,42,0.95);
    border-bottom:1px solid rgba(88,101,242,0.2);
    display:flex;align-items:center;
    padding:0 24px;gap:16px;
    box-shadow:0 4px 20px rgba(0,0,0,0.25);
}

.hamburger{
    display:none;
    flex-direction:column;gap:5px;
    cursor:pointer;padding:8px;
    border-radius:10px;border:none;
    background:rgba(255,255,255,0.06);
    transition:background 0.2s;
}

.hamburger:hover{background:rgba(255,255,255,0.1);}

.hamburger span{
    width:22px;height:2px;
    background:#fff;border-radius:2px;
    transition:all 0.3s ease;display:block;
}

.hamburger.active span:nth-child(1){transform:rotate(45deg) translate(5px,5px);}
.hamburger.active span:nth-child(2){opacity:0;}
.hamburger.active span:nth-child(3){transform:rotate(-45deg) translate(5px,-5px);}

.topbar-title{font-size:1.1rem;font-weight:700;color:#fff;flex:1;}

.topbar-actions{display:flex;gap:8px;align-items:center;}

.btn-topbar{
    background:linear-gradient(135deg,rgba(88,101,242,0.2),rgba(255,46,99,0.15));
    border:1px solid rgba(88,101,242,0.3);
    border-radius:10px;padding:8px 16px;
    font-weight:600;font-size:0.8rem;
    color:#fff;cursor:pointer;
    display:flex;align-items:center;gap:6px;
    transition:all 0.25s;white-space:nowrap;
}

.btn-topbar:hover{background:linear-gradient(135deg,rgba(88,101,242,0.35),rgba(255,46,99,0.25));transform:translateY(-1px);}

.content{
    flex:1;padding:28px 24px;
    display:flex;flex-direction:column;gap:20px;
}

.stats-grid{
    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:16px;
}

.stat-card{
    backdrop-filter:blur(20px);
    background:rgba(255,255,255,0.04);
    border:1px solid rgba(88,101,242,0.2);
    border-radius:18px;padding:22px 20px;
    display:flex;align-items:center;gap:16px;
    transition:all 0.35s ease;
    animation:cardIn 0.5s ease both;
    box-shadow:0 8px 30px rgba(0,0,0,0.2);
    position:relative;overflow:hidden;
}

.stat-card::before{
    content:'';position:absolute;top:0;left:0;right:0;height:3px;
    border-radius:18px 18px 0 0;
}

.stat-card:nth-child(1)::before{background:linear-gradient(90deg,#5865F2,#8B5CF6);}
.stat-card:nth-child(2)::before{background:linear-gradient(90deg,#10B981,#34D399);}
.stat-card:nth-child(3)::before{background:linear-gradient(90deg,#F59E0B,#FBBF24);}
.stat-card:nth-child(4)::before{background:linear-gradient(90deg,#EF4444,#F87171);}

.stat-card:hover{transform:translateY(-5px);box-shadow:0 20px 40px rgba(0,0,0,0.3);}

.stat-card:nth-child(1){animation-delay:0.05s;}
.stat-card:nth-child(2){animation-delay:0.1s;}
.stat-card:nth-child(3){animation-delay:0.15s;}
.stat-card:nth-child(4){animation-delay:0.2s;}

.stat-icon-wrap{
    width:54px;height:54px;
    border-radius:14px;
    display:flex;align-items:center;justify-content:center;
    font-size:1.4rem;flex-shrink:0;
}

.stat-icon-wrap.blue{background:linear-gradient(135deg,rgba(88,101,242,0.25),rgba(139,92,246,0.2));color:#818CF8;}
.stat-icon-wrap.green{background:linear-gradient(135deg,rgba(16,185,129,0.25),rgba(52,211,153,0.2));color:#34D399;}
.stat-icon-wrap.yellow{background:linear-gradient(135deg,rgba(245,158,11,0.25),rgba(251,191,36,0.2));color:#FBBF24;}
.stat-icon-wrap.red{background:linear-gradient(135deg,rgba(239,68,68,0.25),rgba(248,113,113,0.2));color:#F87171;}

.stat-info{flex:1;min-width:0;}

.stat-number{
    font-size:1.8rem;font-weight:900;
    background:linear-gradient(135deg,#fff,rgba(255,255,255,0.8));
    -webkit-background-clip:text;background-clip:text;color:transparent;
    line-height:1.1;margin-bottom:4px;
}

.stat-label{
    color:rgba(255,255,255,0.55);
    font-size:0.78rem;font-weight:600;
    text-transform:uppercase;letter-spacing:0.8px;
}

.charts-row{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:20px;
}

.users-row{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:20px;
}

.card{
    backdrop-filter:blur(20px);
    background:rgba(255,255,255,0.04);
    border:1px solid rgba(88,101,242,0.2);
    border-radius:18px;overflow:hidden;
    box-shadow:0 8px 30px rgba(0,0,0,0.2);
    animation:cardIn 0.5s ease both;
}

.card:nth-child(1){animation-delay:0.25s;}
.card:nth-child(2){animation-delay:0.3s;}

.card-header{
    background:linear-gradient(135deg,rgba(88,101,242,0.25),rgba(255,46,99,0.15));
    border-bottom:1px solid rgba(255,255,255,0.08);
    padding:14px 20px;
    display:flex;align-items:center;gap:10px;
}

.card-header h3{font-size:0.88rem;font-weight:700;color:#fff;text-transform:uppercase;letter-spacing:0.5px;}

.card-header i{font-size:1rem;color:rgba(255,255,255,0.7);}

.chart-wrap{padding:20px;height:280px;position:relative;}

.users-list{max-height:300px;overflow-y:auto;}

.users-list::-webkit-scrollbar{width:4px;}
.users-list::-webkit-scrollbar-track{background:transparent;}
.users-list::-webkit-scrollbar-thumb{background:rgba(88,101,242,0.4);border-radius:4px;}

.user-item{
    display:flex;align-items:center;gap:14px;
    padding:13px 20px;
    border-bottom:1px solid rgba(255,255,255,0.05);
    transition:background 0.2s;
}

.user-item:hover{background:rgba(88,101,242,0.07);}
.user-item:last-child{border-bottom:none;}

.user-avatar{
    width:38px;height:38px;border-radius:10px;
    flex-shrink:0;overflow:hidden;
    display:flex;align-items:center;justify-content:center;
    font-size:1rem;font-weight:700;color:#fff;
    position:relative;
}

.user-avatar img{
    width:100%;height:100%;
    object-fit:cover;border-radius:10px;
    display:block;
}

.user-avatar.active-av{
    background:linear-gradient(135deg,rgba(16,185,129,0.3),rgba(52,211,153,0.2));
    border:1px solid rgba(16,185,129,0.3);
}

.user-avatar.inactive-av{
    background:linear-gradient(135deg,rgba(239,68,68,0.3),rgba(248,113,113,0.2));
    border:1px solid rgba(239,68,68,0.3);
}

.user-info{flex:1;min-width:0;}

.user-name{font-size:0.88rem;font-weight:600;color:#fff;margin-bottom:2px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;}

.user-meta{font-size:0.75rem;color:rgba(255,255,255,0.5);}

.status-dot{
    width:8px;height:8px;border-radius:50%;flex-shrink:0;
}

.status-dot.active{background:#10B981;box-shadow:0 0 6px rgba(16,185,129,0.6);}
.status-dot.inactive{background:#EF4444;box-shadow:0 0 6px rgba(239,68,68,0.6);}

.empty-state{
    padding:36px 20px;
    text-align:center;
    color:rgba(255,255,255,0.35);
    font-size:0.88rem;
}

.empty-state i{font-size:2rem;display:block;margin-bottom:8px;opacity:0.4;}

.overlay{
    display:none;position:fixed;inset:0;
    background:rgba(0,0,0,0.75);
    backdrop-filter:blur(8px);
    z-index:999;opacity:0;
    transition:opacity 0.35s ease;
}

.overlay.active{display:block;}
.overlay.visible{opacity:1;}

.modal{
    display:none;position:fixed;inset:0;
    z-index:1500;
    align-items:center;justify-content:center;
    padding:16px;
    overflow-y:auto;
}

.modal.active{display:flex;}

.modal-box{
    backdrop-filter:blur(24px);
    background:rgba(15,23,42,0.98);
    border:1px solid rgba(88,101,242,0.3);
    border-radius:20px;
    width:100%;max-width:420px;
    max-height:92vh;
    overflow-y:auto;
    box-shadow:0 30px 80px rgba(0,0,0,0.6),0 0 40px rgba(88,101,242,0.2);
    transform:scale(0.85) translateY(30px);
    opacity:0;
    transition:all 0.4s cubic-bezier(0.4,0,0.2,1);
    margin:auto;
}

.modal-box.open{transform:scale(1) translateY(0);opacity:1;}

.modal-head{
    padding:16px 20px;
    border-bottom:1px solid rgba(255,255,255,0.08);
    display:flex;align-items:center;justify-content:space-between;
    position:sticky;top:0;z-index:1;
}

.modal-head.logout-head{
    background:linear-gradient(135deg,rgba(255,46,99,0.35),rgba(8,247,254,0.2));
}

.modal-head h3{font-size:0.95rem;font-weight:700;color:#fff;text-transform:uppercase;letter-spacing:0.5px;}

.modal-x{
    background:none;border:none;
    color:rgba(255,255,255,0.6);
    font-size:1.3rem;cursor:pointer;
    width:34px;height:34px;border-radius:8px;
    display:flex;align-items:center;justify-content:center;
    transition:all 0.2s;flex-shrink:0;
}

.modal-x:hover{background:rgba(255,255,255,0.1);color:#fff;transform:rotate(90deg);}

.modal-body{padding:22px 20px;}

.modal-actions{
    display:flex;gap:10px;margin-top:4px;
    flex-wrap:wrap;
}

.btn-cancel{
    flex:1;min-width:120px;
    background:rgba(255,255,255,0.06);
    border:1.5px solid rgba(255,255,255,0.12);
    border-radius:12px;padding:13px;
    font-weight:700;font-size:0.88rem;
    color:rgba(255,255,255,0.8);
    cursor:pointer;transition:all 0.3s;
}

.btn-cancel:hover{background:rgba(255,255,255,0.1);color:#fff;}

.btn-logout-confirm{
    flex:1;min-width:120px;
    background:linear-gradient(135deg,#FF2E63,#08F7FE);
    border:none;border-radius:12px;
    padding:13px;font-weight:700;
    font-size:0.88rem;color:#000;
    cursor:pointer;transition:all 0.3s;
    box-shadow:0 4px 16px rgba(255,46,99,0.3);
    display:flex;align-items:center;justify-content:center;gap:6px;
}

.btn-logout-confirm:hover{transform:translateY(-2px);box-shadow:0 8px 24px rgba(255,46,99,0.45);}

.logout-warning{
    text-align:center;padding:12px 0 20px;
}

.logout-warning .logout-icon{
    font-size:3rem;
    background:linear-gradient(135deg,#FF2E63,#08F7FE);
    -webkit-background-clip:text;
    background-clip:text;
    color:transparent;
    display:block;
    margin-bottom:14px;
}

.logout-warning p{color:rgba(255,255,255,0.85);line-height:1.6;font-size:0.92rem;}
.logout-warning small{color:rgba(255,255,255,0.45);font-size:0.8rem;display:block;margin-top:6px;}

.welcome-toast{
    position:fixed;top:84px;right:20px;
    background:rgba(15,23,42,0.97);
    border:1px solid rgba(88,101,242,0.3);
    backdrop-filter:blur(16px);
    padding:16px 20px;border-radius:16px;
    min-width:300px;z-index:99999;
    transform:translateX(120%);opacity:0;
    transition:transform 0.5s cubic-bezier(0.4,0,0.2,1),opacity 0.5s ease;
    box-shadow:0 12px 40px rgba(0,0,0,0.4),0 0 24px rgba(88,101,242,0.2);
}

.welcome-toast.show{transform:translateX(0);opacity:1;}
.toast-content{display:flex;align-items:center;gap:14px;}
.toast-content i{font-size:1.8rem;}
.toast-text{display:flex;flex-direction:column;gap:2px;}
.toast-text strong{color:#fff;font-size:0.95rem;}
.toast-text span{color:rgba(255,255,255,0.65);font-size:0.85rem;}
.toast-success-icon{color:#10B981;}

@keyframes cardIn{from{opacity:0;transform:translateY(16px);}to{opacity:1;transform:translateY(0);}}

@media(max-width:1200px){
    .stats-grid{grid-template-columns:repeat(2,1fr);}
}

@media(max-width:900px){
    .charts-row,.users-row{grid-template-columns:1fr;}
}

@media(max-width:768px){
    .sidebar{transform:translateX(-100%);}
    .sidebar.open{transform:translateX(0);}
    .sidebar-close{display:flex;}
    .main{margin-left:0;}
    .hamburger{display:flex;}
    .content{padding:16px 14px;}
    .stats-grid{grid-template-columns:repeat(2,1fr);gap:12px;}
    .stat-number{font-size:1.4rem;}
    .welcome-toast{top:76px;right:12px;left:12px;min-width:auto;}
    .topbar{padding:0 14px;}
    .topbar-actions .btn-topbar span{display:none;}
    .modal{padding:12px;align-items:flex-end;}
    .modal-box{max-width:100%;border-radius:20px 20px 16px 16px;max-height:88vh;}
    .modal-actions{flex-direction:column;}
    .btn-cancel,.btn-logout-confirm{min-width:unset;width:100%;}
}

@media(max-width:480px){
    .stats-grid{grid-template-columns:1fr;}
}
</style>

<div class="overlay" id="overlay"></div>

<div class="dashboard">
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <span class="sidebar-logo">Pixel Forge</span>
            <button class="sidebar-close" id="sidebarClose" aria-label="Close menu">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>

        <nav class="sidebar-nav">
               <a href="/landing">
               <i class="bi bi-house-door-fill"></i>
               <span>Home</span>
               </a>
            <a href="/profile">
                <i class="bi bi-person-circle"></i>
                <span>Profile</span>
            </a>
            <a href="/analytics" class="active">
                <i class="bi bi-bar-chart-line"></i>
                <span>Analytics</span>
            </a>
            <a href="/dashboard">
                <i class="bi bi-speedometer2"></i>
                <span>Dashboard</span>
            </a>
        </nav>
    </aside>

    <div class="main" id="mainContent">
        <header class="topbar">
            <button class="hamburger" id="hamburger" aria-label="Toggle menu">
                <span></span><span></span><span></span>
            </button>
            <span class="topbar-title">Analytics</span>
            <div class="topbar-actions">
                <button class="btn-topbar" onclick="window.print()">
                    <i class="bi bi-download"></i>
                    <span>Export</span>
                </button>
                <button class="btn-topbar" onclick="location.reload()">
                    <i class="bi bi-arrow-clockwise"></i>
                    <span>Refresh</span>
                </button>
            </div>
        </header>

        <div class="content">
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon-wrap blue"><i class="bi bi-people-fill"></i></div>
                    <div class="stat-info">
                        <div class="stat-number">{{ $totalUsers }}</div>
                        <div class="stat-label">Total Users</div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon-wrap green"><i class="bi bi-person-check-fill"></i></div>
                    <div class="stat-info">
                        <div class="stat-number">{{ $activeCount }}</div>
                        <div class="stat-label">Active Users</div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon-wrap yellow"><i class="bi bi-shield-fill"></i></div>
                    <div class="stat-info">
                        <div class="stat-number">{{ $adminCount }}</div>
                        <div class="stat-label">Admins</div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon-wrap red"><i class="bi bi-person-x-fill"></i></div>
                    <div class="stat-info">
                        <div class="stat-number">{{ $inactiveCount }}</div>
                        <div class="stat-label">Inactive Users</div>
                    </div>
                </div>
            </div>

            <div class="charts-row">
                <div class="card">
                    <div class="card-header">
                        <i class="bi bi-pie-chart-fill"></i>
                        <h3>User Roles Distribution</h3>
                    </div>
                    <div class="chart-wrap">
                        <canvas id="rolesChart"></canvas>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <i class="bi bi-bar-chart-fill"></i>
                        <h3>Active vs Inactive</h3>
                    </div>
                    <div class="chart-wrap">
                        <canvas id="statusChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="users-row">
                <div class="card">
                    <div class="card-header">
                        <i class="bi bi-person-check-fill" style="color:#10B981;"></i>
                        <h3>Active Users</h3>
                    </div>
                    <div class="users-list">
                        @forelse($activeUsers as $u)
                        @php
                            $avatarFile = !empty($u->avatar) ? 'uploads/' . $u->avatar : null;
                            $hasAvatar  = $avatarFile && Storage::disk('public')->exists($avatarFile);
                            $avatarSrc  = $hasAvatar
                                ? asset('storage/' . $avatarFile) . '?v=' . Storage::disk('public')->lastModified($avatarFile)
                                : asset('images/blankpfp.jpg');
                            $initial    = strtoupper(substr($u->name, 0, 1));
                        @endphp
                        <div class="user-item">
                            <div class="user-avatar active-av" id="av-active-{{ $u->id }}">
                                <img src="{{ $avatarSrc }}"
                                     alt="{{ $u->name }}"
                                     onerror="this.remove(); document.getElementById('av-active-{{ $u->id }}').textContent='{{ $initial }}'">
                            </div>
                            <div class="user-info">
                                <div class="user-name">{{ $u->name }}</div>
                                <div class="user-meta">{{ ucfirst($u->role) }} · {{ $u->email }}</div>
                            </div>
                            <div class="status-dot active"></div>
                        </div>
                        @empty
                        <div class="empty-state">
                            <i class="bi bi-person-slash"></i>
                            No active users
                        </div>
                        @endforelse
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <i class="bi bi-person-x-fill" style="color:#EF4444;"></i>
                        <h3>Inactive Users</h3>
                    </div>
                    <div class="users-list">
                        @forelse($inactiveUsers as $u)
                        @php
                            $avatarFile = !empty($u->avatar) ? 'uploads/' . $u->avatar : null;
                            $hasAvatar  = $avatarFile && Storage::disk('public')->exists($avatarFile);
                            $avatarSrc  = $hasAvatar
                                ? asset('storage/' . $avatarFile) . '?v=' . Storage::disk('public')->lastModified($avatarFile)
                                : asset('images/blankpfp.jpg');
                            $initial    = strtoupper(substr($u->name, 0, 1));
                        @endphp
                        <div class="user-item">
                            <div class="user-avatar inactive-av" id="av-inactive-{{ $u->id }}">
                                <img src="{{ $avatarSrc }}"
                                     alt="{{ $u->name }}"
                                     onerror="this.remove(); document.getElementById('av-inactive-{{ $u->id }}').textContent='{{ $initial }}'">
                            </div>
                            <div class="user-info">
                                <div class="user-name">{{ $u->name }}</div>
                                <div class="user-meta">{{ ucfirst($u->role) }} · {{ $u->email }}</div>
                            </div>
                            <div class="status-dot inactive"></div>
                        </div>
                        @empty
                        <div class="empty-state">
                            <i class="bi bi-check-circle"></i>
                            No inactive users
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="logoutModal">
    <div class="modal-box" id="logoutBox">
        <div class="modal-head logout-head">
            <h3>Confirm Logout</h3>
            <button class="modal-x" onclick="closeLogoutModal()">&#10005;</button>
        </div>
        <div class="modal-body">
            <div class="logout-warning">
                <i class="bi bi-box-arrow-left logout-icon"></i>
                <p>Are you sure you want to log out of <strong>Pixel Forge</strong>?</p>
                <small>You will need to sign in again to access your account.</small>
            </div>
            <form method="POST" action="{{ route('logout') }}" id="logoutForm">
                @csrf
            </form>
            <div class="modal-actions">
                <button type="button" class="btn-cancel" onclick="closeLogoutModal()">Stay</button>
                <button type="button" class="btn-logout-confirm" onclick="document.getElementById('logoutForm').submit()">
                    <i class="bi bi-box-arrow-left"></i>Logout
                </button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const hamburger    = document.getElementById('hamburger');
    const sidebar      = document.getElementById('sidebar');
    const sidebarClose = document.getElementById('sidebarClose');
    const overlay      = document.getElementById('overlay');

    function openSidebar() {
        sidebar.classList.add('open');
        hamburger.classList.add('active');
        overlay.classList.add('active');
        document.body.style.overflow = 'hidden';
        requestAnimationFrame(() => overlay.classList.add('visible'));
    }

    function closeSidebar() {
        sidebar.classList.remove('open');
        hamburger.classList.remove('active');
        overlay.classList.remove('visible');
        document.body.style.overflow = '';
        setTimeout(() => overlay.classList.remove('active'), 350);
    }

    hamburger?.addEventListener('click', () => sidebar.classList.contains('open') ? closeSidebar() : openSidebar());
    sidebarClose?.addEventListener('click', closeSidebar);

    overlay?.addEventListener('click', () => {
        closeSidebar();
        closeLogoutModal();
    });

    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') { closeSidebar(); closeLogoutModal(); }
    });

    Chart.defaults.color = 'rgba(255,255,255,0.7)';
    Chart.defaults.font  = { family: 'system-ui, sans-serif', size: 12 };

    const rolesCtx = document.getElementById('rolesChart');
    if (rolesCtx) {
        new Chart(rolesCtx, {
            type: 'doughnut',
            data: {
                labels: ['Admin', 'User'],
                datasets: [{
                    data: [{{ $adminCount }}, {{ $userCount }}],
                    backgroundColor: ['rgba(245,158,11,0.85)', 'rgba(88,101,242,0.85)'],
                    borderColor: ['#F59E0B', '#5865F2'],
                    borderWidth: 2,
                    hoverOffset: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '65%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { padding: 16, usePointStyle: true, pointStyleWidth: 10 }
                    }
                }
            }
        });
    }

    const statusCtx = document.getElementById('statusChart');
    if (statusCtx) {
        new Chart(statusCtx, {
            type: 'bar',
            data: {
                labels: ['Active', 'Inactive'],
                datasets: [{
                    label: 'Users',
                    data: [{{ $activeCount }}, {{ $inactiveCount }}],
                    backgroundColor: ['rgba(16,185,129,0.75)', 'rgba(239,68,68,0.75)'],
                    borderColor: ['#10B981', '#EF4444'],
                    borderWidth: 2,
                    borderRadius: 10,
                    borderSkipped: false
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    x: {
                        grid: { color: 'rgba(255,255,255,0.06)' },
                        ticks: { color: 'rgba(255,255,255,0.6)' }
                    },
                    y: {
                        grid: { color: 'rgba(255,255,255,0.06)' },
                        ticks: { color: 'rgba(255,255,255,0.6)', stepSize: 1, precision: 0 },
                        beginAtZero: true
                    }
                }
            }
        });
    }

    @if(session('success'))
    (function() {
        const toast = document.createElement('div');
        toast.className = 'welcome-toast';
        toast.innerHTML = `<div class="toast-content"><i class="bi bi-check-circle-fill toast-success-icon"></i><div class="toast-text"><strong>Success</strong><span>{{ session('success') }}</span></div></div>`;
        document.body.appendChild(toast);
        requestAnimationFrame(() => toast.classList.add('show'));
        setTimeout(() => { toast.classList.remove('show'); setTimeout(() => toast.remove(), 500); }, 4000);
    })();
    @endif
});

function openLogoutModal() {
    const modal = document.getElementById('logoutModal');
    const box   = document.getElementById('logoutBox');
    modal.classList.add('active');
    document.body.style.overflow = 'hidden';
    const overlay = document.getElementById('overlay');
    overlay.classList.add('active');
    requestAnimationFrame(() => {
        overlay.classList.add('visible');
        requestAnimationFrame(() => box.classList.add('open'));
    });
}

function closeLogoutModal() {
    const modal   = document.getElementById('logoutModal');
    const box     = document.getElementById('logoutBox');
    const overlay = document.getElementById('overlay');
    box.classList.remove('open');
    overlay.classList.remove('visible');
    setTimeout(() => {
        modal.classList.remove('active');
        overlay.classList.remove('active');
        document.body.style.overflow = '';
    }, 400);
}
</script>
@endsection