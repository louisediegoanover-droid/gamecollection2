@extends('layouts.main')

@section('content')
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

.topbar-badge{
    background:linear-gradient(135deg,rgba(88,101,242,0.2),rgba(255,46,99,0.15));
    border:1px solid rgba(88,101,242,0.3);
    color:rgba(255,255,255,0.85);
    padding:6px 14px;border-radius:20px;
    font-size:0.8rem;font-weight:600;
    white-space:nowrap;
}

.content{
    flex:1;padding:28px 24px;
    display:flex;flex-direction:column;gap:20px;
}

.card{
    backdrop-filter:blur(20px);
    background:rgba(255,255,255,0.04);
    border:1px solid rgba(88,101,242,0.2);
    border-radius:18px;overflow:hidden;
    box-shadow:0 8px 30px rgba(0,0,0,0.2);
    animation:cardIn 0.5s ease both;
}

.card-header{
    background:linear-gradient(135deg,rgba(88,101,242,0.3),rgba(255,46,99,0.2));
    border-bottom:1px solid rgba(255,255,255,0.08);
    padding:14px 20px;
    display:flex;align-items:center;
    justify-content:space-between;gap:12px;
    flex-wrap:wrap;
}

.card-header h2{
    font-size:0.95rem;font-weight:700;
    color:#fff;letter-spacing:0.5px;
    text-transform:uppercase;
}

.btn-add{
    background:linear-gradient(135deg,#FF2E63,#08F7FE);
    border:none;border-radius:10px;
    padding:9px 18px;font-weight:700;
    font-size:0.82rem;color:#000;cursor:pointer;
    transition:all 0.3s ease;
    display:flex;align-items:center;gap:6px;
    white-space:nowrap;
    box-shadow:0 4px 14px rgba(255,46,99,0.3);
}

.btn-add:hover{transform:translateY(-2px);box-shadow:0 8px 22px rgba(255,46,99,0.45);}

.table-wrap{overflow-x:auto;-webkit-overflow-scrolling:touch;}

table{width:100%;border-collapse:collapse;min-width:580px;}

table thead tr{border-bottom:1px solid rgba(255,255,255,0.08);}

table th{
    padding:13px 14px;
    background:rgba(88,101,242,0.1);
    color:rgba(255,255,255,0.7);
    font-size:0.78rem;font-weight:700;
    text-transform:uppercase;letter-spacing:0.6px;
    text-align:center;white-space:nowrap;
}

table td{
    padding:13px 14px;
    text-align:center;
    color:rgba(255,255,255,0.85);
    font-size:0.88rem;
    border-bottom:1px solid rgba(255,255,255,0.05);
    transition:background 0.2s;
}

table tbody tr{animation:rowIn 0.4s ease both;}
table tbody tr:nth-child(1){animation-delay:0.05s;}
table tbody tr:nth-child(2){animation-delay:0.1s;}
table tbody tr:nth-child(3){animation-delay:0.15s;}
table tbody tr:nth-child(4){animation-delay:0.2s;}
table tbody tr:nth-child(5){animation-delay:0.25s;}
table tbody tr:nth-child(n+6){animation-delay:0.3s;}

table tbody tr:hover td{background:rgba(88,101,242,0.07);}

.badge{
    padding:5px 12px;border-radius:20px;
    font-size:0.75rem;font-weight:700;
    letter-spacing:0.3px;display:inline-block;
}

.badge-active{background:linear-gradient(135deg,#10B981,#059669);color:#fff;}
.badge-inactive{background:linear-gradient(135deg,#ef4444,#dc2626);color:#fff;}
.badge-admin{background:linear-gradient(135deg,#f59e0b,#d97706);color:#fff;}
.badge-user{background:linear-gradient(135deg,#6b7280,#4b5563);color:#fff;}

.btn-edit{
    background:linear-gradient(135deg,#5865F2,#8B5CF6);
    border:none;border-radius:8px;
    padding:7px 14px;font-weight:700;
    font-size:0.78rem;color:#fff;cursor:pointer;
    transition:all 0.25s;margin:2px;
}

.btn-edit:hover{transform:translateY(-2px);box-shadow:0 5px 14px rgba(88,101,242,0.45);}

.btn-del{
    background:linear-gradient(135deg,#ef4444,#dc2626);
    border:none;border-radius:8px;
    padding:7px 14px;font-weight:700;
    font-size:0.78rem;color:#fff;cursor:pointer;
    transition:all 0.25s;margin:2px;
}

.btn-del:hover{transform:translateY(-2px);box-shadow:0 5px 14px rgba(239,68,68,0.45);}

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
    width:100%;max-width:460px;
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
    background:linear-gradient(135deg,rgba(88,101,242,0.35),rgba(255,46,99,0.25));
    padding:16px 20px;
    border-bottom:1px solid rgba(255,255,255,0.08);
    display:flex;align-items:center;justify-content:space-between;
    position:sticky;top:0;z-index:1;
}

.modal-head.danger-head{
    background:linear-gradient(135deg,rgba(239,68,68,0.35),rgba(220,38,38,0.25));
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

.field-group{position:relative;margin-bottom:12px;}

.field-group input,
.field-group select{
    background:rgba(255,255,255,0.07);
    border:1.5px solid rgba(255,255,255,0.12);
    border-radius:12px;
    padding:12px 46px 12px 16px;
    width:100%;
    color:#fff;
    font-size:0.88rem;
    transition:all 0.25s;
    appearance:none;
    -webkit-appearance:none;
    font-family:inherit;
    autocomplete:off;
}

.plain-input{
    background:rgba(255,255,255,0.07);
    border:1.5px solid rgba(255,255,255,0.12);
    border-radius:12px;
    padding:12px 16px;
    width:100%;
    color:#fff;
    font-size:0.88rem;
    transition:all 0.25s;
    appearance:none;
    -webkit-appearance:none;
    font-family:inherit;
    margin-bottom:12px;
    display:block;
}

.plain-select{
    background:rgba(255,255,255,0.07);
    border:1.5px solid rgba(255,255,255,0.12);
    border-radius:12px;
    padding:12px 16px;
    width:100%;
    color:#fff;
    font-size:0.88rem;
    transition:all 0.25s;
    appearance:none;
    -webkit-appearance:none;
    font-family:inherit;
    margin-bottom:12px;
    display:block;
}

.plain-input::placeholder{color:rgba(255,255,255,0.4);}

.plain-input:focus,
.plain-select:focus,
.field-group input:focus{
    outline:none;
    border-color:#5865F2;
    background:rgba(88,101,242,0.1);
    box-shadow:0 0 0 4px rgba(88,101,242,0.15);
}

.plain-select option,.field-group select option{background:#0f172a;color:#fff;}

.toggle-pw{
    position:absolute;
    right:14px;top:50%;transform:translateY(-50%);
    background:none;border:none;
    color:rgba(255,255,255,0.45);
    cursor:pointer;font-size:1rem;
    padding:4px;
    display:flex;align-items:center;justify-content:center;
    transition:color 0.2s;
    line-height:1;
}

.toggle-pw:hover{color:rgba(255,255,255,0.85);}

.modal-actions{
    display:flex;gap:10px;margin-top:4px;
    flex-wrap:wrap;
}

.btn-save{
    flex:1;min-width:120px;
    background:linear-gradient(135deg,#5865F2,#FF2E63);
    border:none;border-radius:12px;
    padding:13px;font-weight:700;
    font-size:0.88rem;color:#fff;
    cursor:pointer;transition:all 0.3s;
    box-shadow:0 4px 16px rgba(88,101,242,0.3);
}

.btn-save:hover{transform:translateY(-2px);box-shadow:0 8px 24px rgba(88,101,242,0.45);}

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

.btn-danger-confirm{
    flex:1;min-width:120px;
    background:linear-gradient(135deg,#ef4444,#dc2626);
    border:none;border-radius:12px;
    padding:13px;font-weight:700;
    font-size:0.88rem;color:#fff;
    cursor:pointer;transition:all 0.3s;
    box-shadow:0 4px 16px rgba(239,68,68,0.3);
}

.btn-danger-confirm:hover{transform:translateY(-2px);box-shadow:0 8px 24px rgba(239,68,68,0.45);}

.btn-logout-confirm{
    flex:1;min-width:120px;
    background:linear-gradient(135deg,#FF2E63,#08F7FE);
    border:none;border-radius:12px;
    padding:13px;font-weight:700;
    font-size:0.88rem;color:#000;
    cursor:pointer;transition:all 0.3s;
    box-shadow:0 4px 16px rgba(255,46,99,0.3);
}

.btn-logout-confirm:hover{transform:translateY(-2px);box-shadow:0 8px 24px rgba(255,46,99,0.45);}

.delete-warning{
    text-align:center;padding:8px 0 18px;
}

.delete-warning p{color:rgba(255,255,255,0.85);margin-bottom:8px;line-height:1.6;}
.delete-warning .warn-name{color:#fff;font-weight:700;}
.delete-warning small{color:#ff6b6b;font-size:0.8rem;}

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
.toast-error-icon{color:#EF4444;}

@keyframes cardIn{from{opacity:0;transform:translateY(16px);}to{opacity:1;transform:translateY(0);}}
@keyframes rowIn{from{opacity:0;transform:translateX(-8px);}to{opacity:1;transform:translateX(0);}}

@media(max-width:768px){
    .sidebar{transform:translateX(-100%);}
    .sidebar.open{transform:translateX(0);}
    .sidebar-close{display:flex;}
    .main{margin-left:0;}
    .hamburger{display:flex;}
    .content{padding:16px 12px;}
    .welcome-toast{top:76px;right:12px;left:12px;min-width:auto;}
    .topbar{padding:0 14px;}
    .modal{padding:12px;align-items:flex-end;}
    .modal-box{max-width:100%;border-radius:20px 20px 16px 16px;max-height:88vh;}
    .modal-actions{flex-direction:column;}
    .btn-save,.btn-cancel,.btn-danger-confirm,.btn-logout-confirm{min-width:unset;width:100%;}
    table th,table td{padding:10px 10px;font-size:0.8rem;}
    .btn-edit,.btn-del{padding:6px 10px;font-size:0.75rem;}
}

@media(max-width:480px){
    .topbar-badge{display:none;}
    .card-header h2{font-size:0.85rem;}
    .btn-add{padding:8px 12px;font-size:0.78rem;}
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
            <a href="/analytics">
                <i class="bi bi-bar-chart-line"></i>
                <span>Analytics</span>
            </a>
            <a href="/dashboard" class="active">
                <i class="bi bi-speedometer2"></i>
                <span>Dashboard</span>
            </a>
        </nav>
    </aside>

    <div class="main" id="mainContent">
        <header class="topbar" data-auth-id="{{ auth()->id() }}">
            <button class="hamburger" id="hamburger" aria-label="Toggle menu">
                <span></span><span></span><span></span>
            </button>
            <span class="topbar-title">User Management</span>
            <span class="topbar-badge">Admin Panel</span>
        </header>

        <div class="content">
            <div class="card">
                <div class="card-header">
                    <h2>Pixel Forge Users</h2>
                    <button class="btn-add" onclick="openAddModal()">
                        <i class="bi bi-plus-lg"></i> Add New User
                    </button>
                </div>
                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Gender</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @if($user->gender == 'male')
                                        <span class="badge" style="background:linear-gradient(135deg,#3b82f6,#1d4ed8);color:#fff;">Male</span>
                                    @elseif($user->gender == 'female')
                                        <span class="badge" style="background:linear-gradient(135deg,#ec4899,#db2777);color:#fff;">Female</span>
                                    @elseif($user->gender == 'other')
                                        <span class="badge" style="background:linear-gradient(135deg,#8b5cf6,#6d28d9);color:#fff;">Other</span>
                                    @else
                                        <span class="badge" style="background:rgba(255,255,255,0.1);color:rgba(255,255,255,0.45);">N/A</span>
                                    @endif
                                </td>
                                <td>
                                    @if($user->role == 'admin')
                                        <span class="badge badge-admin">Admin</span>
                                    @else
                                        <span class="badge badge-user">User</span>
                                    @endif
                                </td>
                                <td>
                                    @if($user->status == 'active')
                                        <span class="badge badge-active">Active</span>
                                    @else
                                        <span class="badge badge-inactive">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    <button class="btn-edit"
                                        data-id="{{ $user->id }}"
                                        data-name="{{ $user->name }}"
                                        data-email="{{ $user->email }}"
                                        data-gender="{{ $user->gender ?? '' }}"
                                        data-role="{{ $user->role ?? 'user' }}"
                                        data-status="{{ $user->status ?? 'active' }}"
                                        onclick="openEditModal(this)">Edit</button>
                                    <button class="btn-del"
                                        data-user-id="{{ $user->id }}"
                                        data-user-name="{{ $user->name }}"
                                        onclick="openDeleteModal(this)">Delete</button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" style="padding:32px;color:rgba(255,255,255,0.4);">No users found</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="addModal">
    <div class="modal-box" id="addBox">
        <div class="modal-head">
            <h3>Add New User</h3>
            <button class="modal-x" onclick="closeModal('addModal','addBox')">&#10005;</button>
        </div>
        <div class="modal-body">
            <form method="POST" action="{{ route('users.store') }}" id="addForm" autocomplete="off">
                @csrf
                <input type="text" name="name" class="plain-input" placeholder="Full Name *" required autocomplete="off">
                <input type="email" name="email" class="plain-input" placeholder="Email Address *" required autocomplete="off">
                <div class="field-group">
                    <input type="password" name="password" id="addPassword" placeholder="Password *" required autocomplete="new-password" style="padding-right:46px;">
                    <button type="button" class="toggle-pw" onclick="togglePw('addPassword',this)">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
                <div class="field-group">
                    <input type="password" name="password_confirmation" id="addPasswordConfirm" placeholder="Confirm Password *" required autocomplete="new-password" style="padding-right:46px;">
                    <button type="button" class="toggle-pw" onclick="togglePw('addPasswordConfirm',this)">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
                <select name="gender" class="plain-select" required>
                    <option value="">Select Gender *</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="other">Other</option>
                </select>
                <select name="role" class="plain-select" required>
                    <option value="">Select Role *</option>
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                </select>
                <select name="status" class="plain-select" required>
                    <option value="">Select Status *</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
                <div class="modal-actions">
                    <button type="submit" class="btn-save">Save</button>
                    <button type="button" class="btn-cancel" onclick="closeModal('addModal','addBox')">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal" id="editModal">
    <div class="modal-box" id="editBox">
        <div class="modal-head">
            <h3>Edit User</h3>
            <button class="modal-x" onclick="closeModal('editModal','editBox')">&#10005;</button>
        </div>
        <div class="modal-body">
            <form method="POST" action="" id="editForm" autocomplete="off">
                @csrf
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" name="user_id" id="editUserId">
                <input type="text" name="name" id="editName" class="plain-input" placeholder="Full Name *" required autocomplete="off">
                <input type="email" name="email" id="editEmail" class="plain-input" placeholder="Email Address *" required autocomplete="off">
                <div class="field-group">
                    <input type="password" name="password" id="editPassword" placeholder="New password (leave blank to keep)" autocomplete="new-password" style="padding-right:46px;">
                    <button type="button" class="toggle-pw" onclick="togglePw('editPassword',this)">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
                <div class="field-group">
                    <input type="password" name="password_confirmation" id="editPasswordConfirm" placeholder="Confirm new password" autocomplete="new-password" style="padding-right:46px;">
                    <button type="button" class="toggle-pw" onclick="togglePw('editPasswordConfirm',this)">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
                <select name="gender" id="editGender" class="plain-select" required>
                    <option value="">Select Gender *</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="other">Other</option>
                </select>
                <select name="role" id="editRole" class="plain-select" required>
                    <option value="">Select Role *</option>
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                </select>
                <select name="status" id="editStatus" class="plain-select" required>
                    <option value="">Select Status *</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
                <div class="modal-actions">
                    <button type="submit" class="btn-save">Update</button>
                    <button type="button" class="btn-cancel" onclick="closeModal('editModal','editBox')">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal" id="deleteModal">
    <div class="modal-box" id="deleteBox">
        <div class="modal-head danger-head">
            <h3>Delete User</h3>
            <button class="modal-x" onclick="closeModal('deleteModal','deleteBox')">&#10005;</button>
        </div>
        <div class="modal-body">
            <div class="delete-warning">
                <p>Are you sure you want to delete <span class="warn-name" id="deleteUserName"></span>?</p>
                <small>This action cannot be undone!</small>
            </div>
            <form method="POST" action="" id="deleteForm">
                @csrf
                @method('DELETE')
                <input type="hidden" name="user_id" id="deleteUserId">
            </form>
            <div class="modal-actions">
                <button type="button" class="btn-cancel" onclick="closeModal('deleteModal','deleteBox')">Cancel</button>
                <button type="button" class="btn-danger-confirm" onclick="document.getElementById('deleteForm').submit()">Delete</button>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="logoutModal">
    <div class="modal-box" id="logoutBox">
        <div class="modal-head logout-head">
            <h3>Confirm Logout</h3>
            <button class="modal-x" onclick="closeModal('logoutModal','logoutBox')">&#10005;</button>
        </div>
        <div class="modal-body">
            <div class="logout-warning">
                <i class="bi bi-box-arrow-left logout-icon"></i>
                <p>Are you sure you want to log out of <strong>Pixel Forge</strong>?</p>
                <small>You will need to sign in again to access the dashboard.</small>
            </div>
            <form method="POST" action="{{ route('logout') }}" id="logoutForm">
                @csrf
            </form>
            <div class="modal-actions">
                <button type="button" class="btn-cancel" onclick="closeModal('logoutModal','logoutBox')">Stay</button>
                <button type="button" class="btn-logout-confirm" onclick="document.getElementById('logoutForm').submit()">
                    <i class="bi bi-box-arrow-left" style="margin-right:6px;"></i>Logout
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function showToast(type, title, message) {
    const old = document.querySelector('.welcome-toast');
    if (old) old.remove();
    const toast = document.createElement('div');
    toast.className = 'welcome-toast';
    const iconClass = type === 'success'
        ? 'bi bi-check-circle-fill toast-success-icon'
        : 'bi bi-x-circle-fill toast-error-icon';
    toast.innerHTML = `<div class="toast-content"><i class="${iconClass}"></i><div class="toast-text"><strong>${title}</strong><span>${message}</span></div></div>`;
    document.body.appendChild(toast);
    requestAnimationFrame(() => toast.classList.add('show'));
    setTimeout(() => { toast.classList.remove('show'); setTimeout(() => toast.remove(), 500); }, 4000);
}

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

    hamburger?.addEventListener('click', () => {
        sidebar.classList.contains('open') ? closeSidebar() : openSidebar();
    });

    sidebarClose?.addEventListener('click', closeSidebar);

    overlay?.addEventListener('click', () => {
        closeSidebar();
        closeAllModals();
    });

    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') { closeSidebar(); closeAllModals(); }
    });

    const successMessage = @json(session('success'));
    const errorMessage   = @json($errors->first());

    if (successMessage) showToast('success', 'Success', successMessage);
    else if (errorMessage) showToast('error', 'Error', errorMessage);
});

function togglePw(inputId, btn) {
    const input = document.getElementById(inputId);
    const icon  = btn.querySelector('i');
    if (input.type === 'password') {
        input.type = 'text';
        icon.className = 'bi bi-eye-slash';
    } else {
        input.type = 'password';
        icon.className = 'bi bi-eye';
    }
}

function resetPwField(inputId) {
    const input = document.getElementById(inputId);
    if (input) {
        input.value = '';
        input.type = 'password';
        const icon = input.parentElement.querySelector('.toggle-pw i');
        if (icon) icon.className = 'bi bi-eye';
    }
}

function openModal(modalId, boxId) {
    const modal = document.getElementById(modalId);
    const box   = document.getElementById(boxId);
    modal.classList.add('active');
    document.body.style.overflow = 'hidden';
    requestAnimationFrame(() => requestAnimationFrame(() => box.classList.add('open')));
}

function closeModal(modalId, boxId) {
    const modal = document.getElementById(modalId);
    const box   = document.getElementById(boxId);
    box.classList.remove('open');
    setTimeout(() => { modal.classList.remove('active'); document.body.style.overflow = ''; }, 400);
}

function closeAllModals() {
    [['addModal','addBox'],['editModal','editBox'],['deleteModal','deleteBox'],['logoutModal','logoutBox']].forEach(([m,b]) => {
        if (document.getElementById(m).classList.contains('active')) closeModal(m, b);
    });
}

function openAddModal() {
    document.getElementById('addForm').reset();
    resetPwField('addPassword');
    resetPwField('addPasswordConfirm');
    openModal('addModal', 'addBox');
}

function openEditModal(btn) {
    document.getElementById('editUserId').value  = btn.dataset.id;
    document.getElementById('editName').value    = btn.dataset.name;
    document.getElementById('editEmail').value   = btn.dataset.email;
    document.getElementById('editGender').value  = btn.dataset.gender;
    document.getElementById('editRole').value    = btn.dataset.role;
    document.getElementById('editStatus').value  = btn.dataset.status;
    document.getElementById('editForm').action   = `/users/${btn.dataset.id}`;
    resetPwField('editPassword');
    resetPwField('editPasswordConfirm');
    openModal('editModal', 'editBox');
}

function openDeleteModal(btn) {
    const authId = parseInt(document.querySelector('.topbar').dataset.authId);
    const userId = parseInt(btn.dataset.userId);
    if (userId === authId) {
        showToast('error', 'Action Denied', 'You cannot delete your own account.');
        return;
    }
    document.getElementById('deleteUserId').value         = btn.dataset.userId;
    document.getElementById('deleteUserName').textContent = btn.dataset.userName;
    document.getElementById('deleteForm').action          = `/users/${btn.dataset.userId}`;
    openModal('deleteModal', 'deleteBox');
}

function openLogoutModal() {
    openModal('logoutModal', 'logoutBox');
}
</script>
@endsection