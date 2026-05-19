<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
/* 🎮 CYBERPUNK NAVBAR */
.navbar-glass {
    background: rgba(5, 5, 5, 0.75);
    backdrop-filter: blur(14px);
    -webkit-backdrop-filter: blur(14px);

    border-bottom: 1px solid rgba(88,101,242,0.4);

    height: 70px;

    box-shadow:
        0 0 15px rgba(88,101,242,0.2),
        0 0 25px rgba(255,46,99,0.1);
}

/* prevent overlap */
body {
    padding-top: 80px;
    background: #0B0F19;
}

/* Logo */
.navbar-brand img {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    object-fit: cover;
}

/* Brand text */
.navbar-brand span {
    font-size: 18px;
    letter-spacing: 1px;
    color: #ffffff;
}

/* Nav buttons (gaming style) */
.navbar-glass .btn {
    transition: 0.3s;
    border-radius: 8px;
}

/* Login/Register buttons */
.navbar-glass .btn-outline-light {
    border: 1px solid #08F7FE;
    color: #08F7FE;
}

.navbar-glass .btn-outline-light:hover {
    background: #08F7FE;
    color: #000;
    box-shadow: 0 0 10px #08F7FE;
}

.navbar-glass .btn-light {
    background: linear-gradient(135deg, #FF2E63, #08F7FE);
    border: none;
    color: #000;
}

.navbar-glass .btn-light:hover {
    box-shadow: 0 0 15px rgba(255,46,99,0.4);
    transform: scale(1.05);
}

/* toggler */
.navbar-toggler {
    border: none;
}

.navbar-toggler:focus {
    box-shadow: none;
}

/* mobile fix */
@media (max-width: 992px) {
    .navbar-glass {
        height: auto;
    }

    body {
        padding-top: 90px;
    }
}
</style>

<nav class="navbar navbar-expand-lg navbar-glass shadow-sm fixed-top">

    <div class="container-fluid">

        <!-- Brand -->
        <a class="navbar-brand d-flex align-items-center gap-2" href="/">
            <img src="{{ asset('images/44444444444444.png') }}" alt="Logo">
            <span class="fw-bold">Pixel Forge</span>
        </a>

        <!-- Toggle -->
        <button class="navbar-toggler text-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Menu -->
        <div class="collapse navbar-collapse" id="navbarNav">

            <div class="ms-auto d-flex gap-2 flex-column flex-lg-row mt-3 mt-lg-0">

                
            </div>

        </div>

    </div>

</nav>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>