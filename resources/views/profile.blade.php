@extends('layouts.main')

@section('content')
@php
    use Illuminate\Support\Facades\Storage;
    $user = auth()->user();
@endphp
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
}

.dashboard{
    display:flex;min-height:100vh;
    background:
        radial-gradient(circle at top left,rgba(88,101,242,0.18),transparent 55%),
        radial-gradient(circle at bottom right,rgba(255,46,99,0.14),transparent 55%),
        #0a0e1a;
}

.sidebar{
    width:var(--sidebar-w);min-height:100vh;
    position:fixed;top:0;left:0;z-index:1000;
    backdrop-filter:blur(24px);
    background:rgba(15,23,42,0.97);
    border-right:1px solid rgba(88,101,242,0.25);
    display:flex;flex-direction:column;
    transition:transform 0.4s cubic-bezier(0.4,0,0.2,1);
    box-shadow:4px 0 30px rgba(0,0,0,0.4);
}

.sidebar-brand{
    padding:24px 20px 20px;
    border-bottom:1px solid rgba(255,255,255,0.07);
    display:flex;align-items:center;justify-content:space-between;
}

.sidebar-logo{
    font-size:1.5rem;font-weight:900;
    background:linear-gradient(135deg,#5865F2 0%,#FF2E63 50%,#08F7FE 100%);
    -webkit-background-clip:text;background-clip:text;color:transparent;
    letter-spacing:-0.3px;
}

.sidebar-close{
    display:none;background:none;border:none;
    color:rgba(255,255,255,0.6);font-size:1.4rem;cursor:pointer;
    width:36px;height:36px;border-radius:10px;
    align-items:center;justify-content:center;transition:all 0.2s;
}

.sidebar-close:hover{background:rgba(255,255,255,0.08);color:#fff;}

.sidebar-nav{
    flex:1;padding:16px 12px;
    display:flex;flex-direction:column;gap:4px;overflow-y:auto;
}

.sidebar-nav a{
    display:flex;align-items:center;gap:12px;
    padding:12px 16px;border-radius:12px;
    color:rgba(255,255,255,0.75);text-decoration:none;
    font-weight:500;font-size:0.92rem;
    transition:all 0.25s ease;position:relative;overflow:hidden;
}

.sidebar-nav a i{font-size:1.15rem;flex-shrink:0;transition:transform 0.25s ease;}
.sidebar-nav a:hover{color:#fff;background:rgba(88,101,242,0.12);transform:translateX(4px);}
.sidebar-nav a:hover i{transform:scale(1.15);}

.sidebar-nav a.active{
    color:#fff;
    background:linear-gradient(135deg,rgba(88,101,242,0.25),rgba(255,46,99,0.15));
    border-left:3px solid #FF2E63;padding-left:13px;
    box-shadow:0 4px 20px rgba(88,101,242,0.2);
}

.sidebar-footer{
    padding:16px 12px 20px;
    border-top:1px solid rgba(255,255,255,0.07);
}

.logout-btn{
    width:100%;
    background:linear-gradient(135deg,#FF2E63 0%,#08F7FE 100%);
    border:none;border-radius:12px;padding:13px;
    font-weight:700;font-size:0.88rem;color:#000;cursor:pointer;
    display:flex;align-items:center;justify-content:center;gap:8px;
    transition:all 0.3s ease;box-shadow:0 6px 20px rgba(255,46,99,0.3);
}

.logout-btn:hover{transform:translateY(-2px);box-shadow:0 10px 28px rgba(255,46,99,0.45);}

.main{
    flex:1;margin-left:var(--sidebar-w);
    display:flex;flex-direction:column;min-height:100vh;
    transition:margin-left 0.4s cubic-bezier(0.4,0,0.2,1);
}

.topbar{
    position:sticky;top:0;z-index:500;height:var(--topbar-h);
    backdrop-filter:blur(20px);background:rgba(15,23,42,0.95);
    border-bottom:1px solid rgba(88,101,242,0.2);
    display:flex;align-items:center;padding:0 24px;gap:16px;
    box-shadow:0 4px 20px rgba(0,0,0,0.25);
}

.hamburger{
    display:none;flex-direction:column;gap:5px;
    cursor:pointer;padding:8px;border-radius:10px;border:none;
    background:rgba(255,255,255,0.06);transition:background 0.2s;
}

.hamburger:hover{background:rgba(255,255,255,0.1);}
.hamburger span{width:22px;height:2px;background:#fff;border-radius:2px;transition:all 0.3s ease;display:block;}
.hamburger.active span:nth-child(1){transform:rotate(45deg) translate(5px,5px);}
.hamburger.active span:nth-child(2){opacity:0;}
.hamburger.active span:nth-child(3){transform:rotate(-45deg) translate(5px,-5px);}

.topbar-title{font-size:1.1rem;font-weight:700;color:#fff;flex:1;}

.topbar-badge{
    background:linear-gradient(135deg,rgba(88,101,242,0.2),rgba(255,46,99,0.15));
    border:1px solid rgba(88,101,242,0.3);
    color:rgba(255,255,255,0.85);padding:6px 14px;
    border-radius:20px;font-size:0.8rem;font-weight:600;
}

.content{flex:1;padding:28px 24px;display:flex;flex-direction:column;gap:20px;}

.card{
    backdrop-filter:blur(20px);background:rgba(255,255,255,0.04);
    border:1px solid rgba(88,101,242,0.2);border-radius:18px;
    overflow:hidden;box-shadow:0 8px 30px rgba(0,0,0,0.2);
    animation:cardIn 0.5s ease both;
}

.card-header{
    background:linear-gradient(135deg,rgba(88,101,242,0.3),rgba(255,46,99,0.2));
    border-bottom:1px solid rgba(255,255,255,0.08);
    padding:14px 20px;display:flex;align-items:center;gap:10px;
}

.card-header h2{font-size:0.95rem;font-weight:700;color:#fff;text-transform:uppercase;letter-spacing:0.5px;}

.profile-wrap{display:flex;gap:0;min-height:500px;}

.profile-left{
    width:280px;flex-shrink:0;
    border-right:1px solid rgba(255,255,255,0.07);
    padding:32px 24px;
    display:flex;flex-direction:column;align-items:center;gap:20px;
}

.avatar-ring{
    width:130px;height:130px;border-radius:50%;
    background:linear-gradient(135deg,#5865F2,#FF2E63,#08F7FE);
    padding:3px;flex-shrink:0;
    box-shadow:0 8px 30px rgba(88,101,242,0.3);
    transition:box-shadow 0.3s;
}

.avatar-ring:hover{box-shadow:0 12px 40px rgba(88,101,242,0.5);}

.profile-img{
    width:100%;height:100%;
    border-radius:50%;object-fit:cover;
    border:3px solid rgba(15,23,42,0.9);
    display:block;
    transition:transform 0.3s ease;
}

.avatar-ring:hover .profile-img{transform:scale(1.04);}

.user-display-name{font-size:1.1rem;font-weight:700;color:#fff;text-align:center;}

.user-display-role{
    font-size:0.78rem;font-weight:600;text-transform:uppercase;letter-spacing:0.8px;
    background:linear-gradient(135deg,rgba(88,101,242,0.25),rgba(255,46,99,0.15));
    border:1px solid rgba(88,101,242,0.3);
    color:rgba(255,255,255,0.7);padding:5px 14px;border-radius:20px;
}

.file-upload-area{width:100%;text-align:center;}

.file-label{
    display:inline-flex;align-items:center;gap:8px;
    background:rgba(255,255,255,0.06);
    border:1.5px dashed rgba(255,255,255,0.2);
    border-radius:12px;padding:10px 18px;
    cursor:pointer;font-size:0.82rem;
    color:rgba(255,255,255,0.75);
    transition:all 0.25s;width:100%;justify-content:center;
}

.file-label:hover{background:rgba(88,101,242,0.12);border-color:#5865F2;color:#fff;}

.file-name-display{
    margin-top:6px;font-size:0.75rem;
    color:rgba(255,255,255,0.45);text-align:center;
}

.photo-btns{width:100%;display:flex;flex-direction:column;gap:8px;}

.btn-photo{
    width:100%;padding:11px;border:none;border-radius:12px;
    font-weight:600;font-size:0.84rem;cursor:pointer;
    transition:all 0.3s;display:flex;align-items:center;justify-content:center;gap:8px;
}

.btn-photo-save{
    background:linear-gradient(135deg,#5865F2,#08F7FE);color:#000;
    box-shadow:0 4px 16px rgba(88,101,242,0.3);
}

.btn-photo-save:hover{transform:translateY(-2px);box-shadow:0 8px 24px rgba(88,101,242,0.45);}
.btn-photo-save:disabled{opacity:0.45;cursor:not-allowed;transform:none;box-shadow:none;}

.btn-photo-reset{
    background:rgba(255,255,255,0.06);color:rgba(255,255,255,0.75);
    border:1.5px solid rgba(255,255,255,0.12);
}

.btn-photo-reset:hover{background:rgba(239,68,68,0.15);border-color:#ef4444;color:#fff;transform:translateY(-2px);}

.profile-right{flex:1;padding:32px 28px;}

.section-label{
    font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:1px;
    color:rgba(255,255,255,0.4);margin-bottom:14px;margin-top:4px;
    display:flex;align-items:center;gap:8px;
}

.section-label::after{
    content:'';flex:1;height:1px;
    background:rgba(255,255,255,0.07);
}

.form-row{display:flex;gap:14px;margin-bottom:0;}
.form-row .field{flex:1;min-width:0;}

.field{margin-bottom:14px;}

.field label{
    display:block;font-size:0.78rem;font-weight:600;
    color:rgba(255,255,255,0.5);margin-bottom:6px;letter-spacing:0.3px;
}

.field input,
.field textarea{
    width:100%;padding:12px 16px;
    background:rgba(255,255,255,0.06);
    border:1.5px solid rgba(255,255,255,0.1);
    border-radius:12px;color:#fff;font-size:0.88rem;
    transition:all 0.25s;resize:none;
    font-family:inherit;
}

.field input::placeholder,
.field textarea::placeholder{color:rgba(255,255,255,0.3);}

.field input:focus,
.field textarea:focus{
    outline:none;
    border-color:#5865F2;
    background:rgba(88,101,242,0.08);
    box-shadow:0 0 0 4px rgba(88,101,242,0.12);
}

.field input.input-error{border-color:#ef4444;background:rgba(239,68,68,0.06);}

.error-hint{font-size:0.75rem;color:#f87171;margin-top:4px;display:none;}
.error-hint.show{display:block;}

.btn-save{
    width:100%;padding:14px;
    background:linear-gradient(135deg,#FF2E63,#08F7FE);
    border:none;border-radius:12px;
    font-weight:700;font-size:0.92rem;color:#000;
    cursor:pointer;transition:all 0.3s;
    box-shadow:0 6px 20px rgba(255,46,99,0.3);
    display:flex;align-items:center;justify-content:center;gap:8px;
    margin-top:6px;
}

.btn-save:hover{transform:translateY(-2px);box-shadow:0 10px 28px rgba(255,46,99,0.45);}

.overlay{
    display:none;position:fixed;inset:0;
    background:rgba(0,0,0,0.75);backdrop-filter:blur(8px);
    z-index:999;opacity:0;transition:opacity 0.35s ease;
}

.overlay.active{display:block;}
.overlay.visible{opacity:1;}

.modal-backdrop{
    position:fixed;inset:0;z-index:2000;
    background:rgba(5,8,20,0.82);backdrop-filter:blur(14px);
    display:flex;align-items:center;justify-content:center;
    opacity:0;visibility:hidden;
    transition:opacity 0.3s ease,visibility 0.3s ease;
}

.modal-backdrop.active{opacity:1;visibility:visible;}

.modal-box{
    background:rgba(15,23,42,0.98);
    border:1px solid rgba(88,101,242,0.35);
    border-radius:22px;
    max-width:400px;width:calc(100% - 32px);
    box-shadow:0 24px 64px rgba(0,0,0,0.6);
    transform:scale(0.92) translateY(16px);
    transition:transform 0.35s cubic-bezier(0.34,1.56,0.64,1),opacity 0.3s ease;
    opacity:0;overflow:hidden;
}

.modal-backdrop.active .modal-box{transform:scale(1) translateY(0);opacity:1;}

.modal-head{
    padding:16px 20px;
    border-bottom:1px solid rgba(255,255,255,0.08);
    display:flex;align-items:center;justify-content:space-between;
}

.modal-head.reset-head{
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

.modal-body-inner{padding:28px 24px 10px;text-align:center;}

.modal-icon{
    width:68px;height:68px;border-radius:50%;margin:0 auto 16px;
    display:flex;align-items:center;justify-content:center;font-size:1.8rem;
}

.modal-icon.reset-icon{
    background:linear-gradient(135deg,rgba(239,68,68,0.2),rgba(255,46,99,0.15));
    border:1.5px solid rgba(239,68,68,0.3);color:#f87171;
}

.modal-icon.logout-icon-wrap{
    background:linear-gradient(135deg,rgba(255,46,99,0.2),rgba(8,247,254,0.15));
    border:1.5px solid rgba(255,46,99,0.3);
    font-size:2.4rem;
    background:linear-gradient(135deg,#FF2E63,#08F7FE);
    -webkit-background-clip:text;background-clip:text;color:transparent;
    border:none;
}

.logout-icon-wrap i{
    background:linear-gradient(135deg,#FF2E63,#08F7FE);
    -webkit-background-clip:text;background-clip:text;color:transparent;
    font-size:2.8rem;
}

.modal-title{font-size:1.05rem;font-weight:800;color:#fff;margin-bottom:8px;}
.modal-desc{font-size:0.85rem;color:rgba(255,255,255,0.55);line-height:1.6;margin-bottom:4px;}
.modal-sub{font-size:0.78rem;color:rgba(255,255,255,0.35);display:block;margin-top:4px;}

.modal-actions{
    display:flex;gap:10px;padding:18px 24px 24px;
}

.btn-modal{
    flex:1;padding:12px;border:none;border-radius:12px;
    font-weight:700;font-size:0.86rem;cursor:pointer;
    display:flex;align-items:center;justify-content:center;gap:7px;
    transition:all 0.25s;
}

.btn-modal-cancel{
    background:rgba(255,255,255,0.07);
    border:1.5px solid rgba(255,255,255,0.12);
    color:rgba(255,255,255,0.8);
}

.btn-modal-cancel:hover{background:rgba(255,255,255,0.12);color:#fff;transform:translateY(-1px);}

.btn-modal-danger{
    background:linear-gradient(135deg,#EF4444,#FF2E63);
    color:#fff;box-shadow:0 4px 16px rgba(239,68,68,0.35);
}

.btn-modal-danger:hover{transform:translateY(-2px);box-shadow:0 8px 24px rgba(239,68,68,0.5);}

.btn-modal-logout{
    background:linear-gradient(135deg,#FF2E63,#08F7FE);
    color:#000;box-shadow:0 4px 16px rgba(255,46,99,0.3);
}

.btn-modal-logout:hover{transform:translateY(-2px);box-shadow:0 8px 24px rgba(255,46,99,0.45);}

.welcome-toast{
    position:fixed;top:84px;right:20px;
    background:rgba(15,23,42,0.97);
    border:1px solid rgba(88,101,242,0.3);
    backdrop-filter:blur(16px);padding:16px 20px;
    border-radius:16px;min-width:300px;z-index:99999;
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

@media(max-width:900px){
    .profile-wrap{flex-direction:column;}
    .profile-left{width:100%;border-right:none;border-bottom:1px solid rgba(255,255,255,0.07);padding:28px 24px;}
    .profile-right{padding:24px;}
}

@media(max-width:768px){
    .sidebar{transform:translateX(-100%);}
    .sidebar.open{transform:translateX(0);}
    .sidebar-close{display:flex;}
    .main{margin-left:0;}
    .hamburger{display:flex;}
    .content{padding:16px 14px;}
    .form-row{flex-direction:column;gap:0;}
    .welcome-toast{top:76px;right:12px;left:12px;min-width:auto;}
    .topbar{padding:0 14px;}
    .modal-actions{flex-direction:column;}
    .btn-modal{width:100%;}
}
</style>

<div class="modal-backdrop" id="resetModalBackdrop">
    <div class="modal-box">
        <div class="modal-head reset-head">
            <h3>Reset Profile Photo</h3>
            <button class="modal-x" onclick="closeResetModal()">&#10005;</button>
        </div>
        <div class="modal-body-inner">
            <div class="modal-icon reset-icon"><i class="bi bi-arrow-counterclockwise"></i></div>
            <div class="modal-title">Remove your photo?</div>
            <div class="modal-desc">Your current photo will be removed and replaced with the default avatar. This action cannot be undone.</div>
        </div>
        <div class="modal-actions">
            <button class="btn-modal btn-modal-cancel" onclick="closeResetModal()" type="button">
                <i class="bi bi-x-lg"></i> Cancel
            </button>
            <button class="btn-modal btn-modal-danger" id="confirmResetBtn" type="button">
                <i class="bi bi-arrow-counterclockwise"></i> Reset
            </button>
        </div>
    </div>
</div>

<div class="modal-backdrop" id="logoutModalBackdrop">
    <div class="modal-box">
        <div class="modal-head logout-head">
            <h3>Confirm Logout</h3>
            <button class="modal-x" onclick="closeLogoutModal()">&#10005;</button>
        </div>
        <div class="modal-body-inner">
            <div class="modal-icon" style="width:68px;height:68px;border-radius:50%;margin:0 auto 16px;display:flex;align-items:center;justify-content:center;">
                <i class="bi bi-box-arrow-left" style="font-size:2.8rem;background:linear-gradient(135deg,#FF2E63,#08F7FE);-webkit-background-clip:text;background-clip:text;color:transparent;"></i>
            </div>
            <div class="modal-title">Log out of Pixel Forge?</div>
            <div class="modal-desc">Are you sure you want to log out?</div>
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

<form method="POST" action="{{ route('profile.photo.remove') }}" id="resetPhotoForm" style="display:none;">
    @csrf
    @method('DELETE')
</form>

<form method="POST" action="{{ route('logout') }}" id="logoutForm" style="display:none;">
    @csrf
</form>

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
            <a href="/profile" class="active">
                <i class="bi bi-person-circle"></i>
                <span>Profile</span>
            </a>
            <a href="/analytics">
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
            <span class="topbar-title">My Profile</span>
            <span class="topbar-badge">{{ ucfirst($user->role ?? 'User') }}</span>
        </header>

        <div class="content">
            <div class="card">
                <div class="card-header">
                    <h2>Profile Settings</h2>
                </div>

                <div class="profile-wrap">
                    <div class="profile-left">
                        @php
                            $avatarFile    = !empty($user->avatar) ? 'uploads/' . $user->avatar : null;
                            $hasAvatar     = $avatarFile && Storage::disk('public')->exists($avatarFile);
                            $avatar        = $hasAvatar
                                ? asset('storage/' . $avatarFile) . '?v=' . Storage::disk('public')->lastModified($avatarFile)
                                : asset('images/blankpfp.jpg');
                            $defaultAvatar = asset('images/blankpfp.jpg');
                        @endphp

                        <div class="avatar-ring">
                            <img id="preview" class="profile-img" src="{{ $avatar }}" alt="Profile Photo">
                        </div>

                        <div>
                            <div class="user-display-name">{{ $user->name }}</div>
                            <div class="user-display-role" style="margin-top:8px;text-align:center;">{{ ucfirst($user->role ?? 'User') }}</div>
                        </div>

                        <form method="POST" action="{{ route('profile.photo.update') }}" enctype="multipart/form-data" id="photoForm" style="width:100%;">
                            @csrf
                            <input type="file" id="avatarInput" name="avatar" accept="image/*" style="display:none;">

                            <div class="file-upload-area">
                                <label for="avatarInput" class="file-label">
                                    <i class="bi bi-image"></i> Choose Photo
                                </label>
                                <div class="file-name-display" id="fileName">No file chosen</div>
                            </div>

                            <div class="photo-btns" style="margin-top:12px;">
                                <button type="submit" class="btn-photo btn-photo-save" id="btnUpdatePhoto" disabled>
                                    <i class="bi bi-cloud-upload"></i> Update Photo
                                </button>
                            </div>
                        </form>

                        <button type="button" class="btn-photo btn-photo-reset" onclick="openResetModal()" style="width:100%;">
                            <i class="bi bi-arrow-counterclockwise"></i> Reset Photo
                        </button>
                    </div>

                    <div class="profile-right">
                        <form method="POST" action="{{ route('profile.update') }}" id="profileForm">
                            @csrf
                            @method('PUT')

                            <div class="section-label">Personal Information</div>

                            <div class="form-row">
                                <div class="field">
                                    <label>Full Name</label>
                                    <input type="text" name="name" value="{{ old('name', $user->name) }}" placeholder="Full Name" required>
                                </div>
                                <div class="field">
                                    <label>Email Address</label>
                                    <input type="email" name="email" value="{{ old('email', $user->email) }}" placeholder="Email" required>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="field">
                                    <label>Phone Number</label>
                                    <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="Phone Number">
                                </div>
                                <div class="field">
                                    <label>Address</label>
                                    <input type="text" name="address" value="{{ old('address', $user->address) }}" placeholder="Address">
                                </div>
                            </div>

                            <div class="field">
                                <label>Short Bio</label>
                                <textarea name="bio" rows="3" placeholder="Write something about yourself...">{{ old('bio', $user->bio) }}</textarea>
                            </div>

                            <div class="section-label" style="margin-top:8px;">Change Password</div>

                            <div class="field">
                                <label>Current Password</label>
                                <input type="password" name="current_password" id="currentPassword" placeholder="Enter current password" autocomplete="current-password">
                                <div class="error-hint" id="currentPasswordError">
                                    @error('current_password') {{ $message }} @enderror
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="field">
                                    <label>New Password</label>
                                    <input type="password" name="new_password" id="newPassword" placeholder="New password (min 8 chars)" autocomplete="new-password">
                                    <div class="error-hint" id="newPasswordError">
                                        @error('new_password') {{ $message }} @enderror
                                    </div>
                                </div>
                                <div class="field">
                                    <label>Confirm New Password</label>
                                    <input type="password" name="new_password_confirmation" id="confirmPassword" placeholder="Confirm new password" autocomplete="new-password">
                                    <div class="error-hint" id="confirmPasswordError"></div>
                                </div>
                            </div>

                            <button type="submit" class="btn-save">
                                <i class="bi bi-check-lg"></i> Save Changes
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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
    overlay?.addEventListener('click', closeSidebar);

    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') {
            closeSidebar();
            closeResetModal();
            closeLogoutModal();
        }
    });

    document.getElementById('resetModalBackdrop')?.addEventListener('click', function(e) {
        if (e.target === this) closeResetModal();
    });

    document.getElementById('logoutModalBackdrop')?.addEventListener('click', function(e) {
        if (e.target === this) closeLogoutModal();
    });

    const avatarInput = document.getElementById('avatarInput');
    const preview     = document.getElementById('preview');
    const fileName    = document.getElementById('fileName');
    const btnUpdate   = document.getElementById('btnUpdatePhoto');

    avatarInput?.addEventListener('change', function () {
        const file = this.files[0];
        if (file) {
            fileName.textContent = file.name;
            btnUpdate.disabled   = false;
            const reader = new FileReader();
            reader.onload = e => { preview.src = e.target.result; };
            reader.readAsDataURL(file);
        } else {
            fileName.textContent = 'No file chosen';
            btnUpdate.disabled   = true;
        }
    });

    const defaultAvatar = @json($defaultAvatar);

    document.getElementById('confirmResetBtn')?.addEventListener('click', function () {
        preview.src          = defaultAvatar;
        avatarInput.value    = '';
        fileName.textContent = 'No file chosen';
        btnUpdate.disabled   = true;
        closeResetModal();
        setTimeout(() => document.getElementById('resetPhotoForm').submit(), 320);
    });

    const newPassword     = document.getElementById('newPassword');
    const confirmPassword = document.getElementById('confirmPassword');
    const confirmError    = document.getElementById('confirmPasswordError');

    function checkPasswordMatch() {
        if (confirmPassword.value && newPassword.value !== confirmPassword.value) {
            confirmError.textContent = 'Passwords do not match.';
            confirmError.classList.add('show');
            confirmPassword.classList.add('input-error');
        } else {
            confirmError.classList.remove('show');
            confirmPassword.classList.remove('input-error');
        }
    }

    newPassword?.addEventListener('input', checkPasswordMatch);
    confirmPassword?.addEventListener('input', checkPasswordMatch);

    document.getElementById('profileForm')?.addEventListener('submit', function (e) {
        if (newPassword.value && newPassword.value !== confirmPassword.value) {
            e.preventDefault();
            confirmError.textContent = 'Passwords do not match.';
            confirmError.classList.add('show');
            confirmPassword.classList.add('input-error');
            confirmPassword.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    });

    @if($errors->has('current_password'))
        document.getElementById('currentPasswordError')?.classList.add('show');
        document.getElementById('currentPassword')?.classList.add('input-error');
    @endif

    @if($errors->has('new_password'))
        document.getElementById('newPasswordError')?.classList.add('show');
        document.getElementById('newPassword')?.classList.add('input-error');
    @endif

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

    @if(session('success'))
        showToast('success', 'Success', @json(session('success')));
    @endif

    @if(session('error'))
        showToast('error', 'Error', @json(session('error')));
    @endif

    @if($errors->any() && !session('success'))
        showToast('error', 'Error', @json($errors->first()));
    @endif
});

function openResetModal() {
    document.getElementById('resetModalBackdrop').classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeResetModal() {
    document.getElementById('resetModalBackdrop').classList.remove('active');
    document.body.style.overflow = '';
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