@extends('layouts.main')
@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
<style>
body {
    background:
        radial-gradient(circle at top, rgba(88,101,242,0.25), transparent 50%),
        radial-gradient(circle at bottom, rgba(255,46,99,0.2), transparent 60%),
        linear-gradient(135deg, rgba(11,15,25,0.85), rgba(5,5,5,0.9)),
        url("{{ asset('images/1111111111.jpg') }}") no-repeat center center/cover;

    min-height: 100vh;
    margin: 0;
    font-family: 'Poppins', sans-serif;
}

.auth-wrapper {
    min-height: calc(100vh - 70px);
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 20px;
}

.auth-card {
    width: 100%;
    max-width: 420px; 
    backdrop-filter: blur(22px);
    -webkit-backdrop-filter: blur(22px);
    background: rgba(255,255,255,0.06);
    border: 1px solid rgba(88,101,242,0.3);
    border-radius: 18px;
    color: #fff;
    box-shadow:
        0 0 25px rgba(88,101,242,0.2),
        0 0 40px rgba(255,46,99,0.1);
    overflow: hidden;
    animation: fadeIn 0.6s ease-in-out;
}

.auth-header {
    background: linear-gradient(135deg, #5865F2, #FF2E63);
    padding: 14px;
    text-align: center;
    font-weight: bold;
    letter-spacing: 1px;
    text-transform: uppercase;
}

.form-control {
    background: rgba(255,255,255,0.9);
    border: none;
    border-radius: 10px;
    font-size: 15px;   
    padding: 10px; 
    transition: 0.3s;
}
.auth-card .p-3 {
    padding: 22px !important;
}
.auth-card {
    transform: scale(1.03);
}
.form-control:focus {
    box-shadow: 0 0 12px rgba(88,101,242,0.6);
    transform: scale(1.02);
}

/* Button */
.btn-login {
    background: linear-gradient(135deg, #08F7FE, #FF2E63);
    border: none;
    border-radius: 10px;
    padding: 9px;
    font-weight: bold;
    color: #000;
    transition: 0.3s;
}

.btn-login:hover {
    transform: translateY(-2px);
    box-shadow: 0 0 20px rgba(8,247,254,0.4);
}

/* Footer */
.auth-footer {
    text-align: center;
    padding: 10px;
    font-size: 13px;
    color: #A1A1AA;
}

.auth-footer a {
    color: #08F7FE;
    font-weight: bold;
    text-decoration: none;
}

.auth-footer a:hover {
    text-decoration: underline;
}
.welcome-toast{
    position: fixed;
    top: 90px;
    right: 25px;
    background: rgba(20,20,30,0.95);
    border: 1px solid rgba(255,255,255,0.1);
    backdrop-filter: blur(14px);
    padding: 18px 22px;
    border-radius: 18px;
    min-width: 320px;
    z-index: 99999;

    transform: translateX(120%);
    opacity: 0;

    transition:
        transform .5s ease,
        opacity .5s ease;

    box-shadow:
        0 10px 35px rgba(0,0,0,.35),
        0 0 25px rgba(88,101,242,.25);
}

.welcome-toast.show{
    transform: translateX(0);
    opacity: 1;
}

.toast-content{
    display:flex;
    align-items:center;
    gap:14px;
}

.toast-content i{
    font-size:2rem;
}

.toast-success-icon{
    color:#10B981;
}

.toast-error-icon{
    color:#EF4444;
}

.toast-text{
    display:flex;
    flex-direction:column;
}

.toast-text strong{
    color:#fff;
    font-size:1rem;
}
.toast-success-icon{
    color:#10B981;
}

.toast-error-icon{
    color:#EF4444;
}

.toast-text span{
    color:#d4d4d8;
    font-size:.9rem;
    margin-top:2px;
}

@media(max-width:768px){
    .welcome-toast{
        top:80px;
        right:15px;
        left:15px;
        min-width:auto;
    }
}

@keyframes fadeIn {
    from {opacity: 0; transform: translateY(20px);}
    to {opacity: 1; transform: translateY(0);}
}

</style>

<div class="auth-wrapper">

    <div class="auth-card">

        <div class="auth-header">
            Pixel Forge Login
        </div>

        <div class="p-3">
            <form method="POST" action="{{ route('login.store') }}">
                @csrf

                <div class="mb-2">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>

                <div class="mb-2">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-login w-100">
                    LOGIN
                </button>

            </form>

        </div>

        <div class="auth-footer">
            Don’t have an account?
            <a href="/register">Create one</a>
        </div>

    </div>

</div>


<script>

document.addEventListener('DOMContentLoaded', () => {

    const successMessage = @json(session('success'));
    const errorMessage = @json($errors->first());

    function showToast(type, title, message) {

        // remove existing toast (prevents duplicates)
        const oldToast = document.querySelector('.welcome-toast');
        if (oldToast) oldToast.remove();

        const toast = document.createElement('div');
        toast.className = 'welcome-toast';

        const iconClass =
    type === 'success'
    ? 'bi bi-check-circle-fill toast-success-icon'
    : 'bi bi-x-circle-fill toast-error-icon';

toast.innerHTML = `
    <div class="toast-content">
        <i class="${iconClass}"></i>

        <div class="toast-text">
            <strong>${title}</strong>
            <span>${message}</span>
        </div>
    </div>
`;

        document.body.appendChild(toast);


        requestAnimationFrame(() => {
            toast.classList.add('show');
        });

        // auto remove
        setTimeout(() => {

            toast.classList.remove('show');

            setTimeout(() => {
                toast.remove();
            }, 500);

        }, 4000);
    }

    
    if (successMessage) {

        showToast(
            'success',
            'Success',
            successMessage
        );

    } else if (errorMessage) {

        showToast(
            'error',
            'Login Failed',
            errorMessage
        );
    }

});

</script>
@endsection