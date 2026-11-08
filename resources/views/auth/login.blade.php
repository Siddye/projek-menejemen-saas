<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masuk · Digital Agency Studio</title>

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Plus Jakarta Sans', system-ui, sans-serif; }

        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px 16px;
            background:
                radial-gradient(ellipse at 10% 5%,  rgba(141, 211, 243, 0.55) 0%, transparent 42%),
                radial-gradient(ellipse at 90% 5%,  rgba(195, 174, 243, 0.45) 0%, transparent 42%),
                radial-gradient(ellipse at 90% 95%, rgba(146, 231, 206, 0.45) 0%, transparent 42%),
                radial-gradient(ellipse at 10% 95%, rgba(141, 206, 243, 0.4)  0%, transparent 40%),
                #e9f3f9;
            background-attachment: fixed;
        }

        /* ========= WINDOW FRAME ========= */
        .login-window {
            width: 100%;
            max-width: 1060px;
            min-height: 580px;
            display: flex;
            border-radius: 36px;
            overflow: hidden;
            box-shadow:
                0 32px 80px -16px rgba(14, 55, 70, 0.14),
                0 0 0 1.5px rgba(255,255,255,0.75) inset;
            background: rgba(255,255,255,0.35);
            backdrop-filter: blur(28px);
            -webkit-backdrop-filter: blur(28px);
            border: 1.5px solid rgba(255,255,255,0.75);
        }

        /* ========= LEFT PANEL: Sidebar Hero ========= */
        .login-left {
            width: 320px;
            min-width: 300px;
            background: linear-gradient(170deg, #0e3746 0%, #0a2935 100%);
            padding: 44px 36px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
            overflow: hidden;
        }
        .login-left::before {
            content: '';
            position: absolute;
            top: -60px; right: -60px;
            width: 240px; height: 240px;
            border-radius: 50%;
            background: rgba(8, 184, 157, 0.1);
        }
        .login-left::after {
            content: '';
            position: absolute;
            bottom: -40px; left: -40px;
            width: 180px; height: 180px;
            border-radius: 50%;
            background: rgba(47, 128, 237, 0.08);
        }

        .left-brand-pill {
            width: 54px; height: 54px;
            border-radius: 20px;
            background: linear-gradient(135deg, #00d2ff, #3a7bd5);
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-size: 26px;
            box-shadow: 0 10px 24px rgba(0,210,255,0.35);
            margin-bottom: 28px;
        }
        .left-title {
            font-size: 26px; font-weight: 800; color: #fff;
            letter-spacing: -0.6px; line-height: 1.25; margin-bottom: 10px;
        }
        .left-desc {
            font-size: 13px; color: rgba(255,255,255,0.6);
            line-height: 1.65; margin-bottom: 32px;
        }

        .left-nav-items {
            display: flex; flex-direction: column; gap: 12px;
            position: relative; z-index: 1;
        }
        .left-nav-item {
            display: flex; align-items: center; gap: 12px;
            padding: 10px 14px; border-radius: 14px;
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.08);
            transition: all 0.2s;
        }
        .left-nav-icon {
            width: 32px; height: 32px; border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 15px; color: #fff; flex-shrink: 0;
        }
        .left-nav-text { font-size: 13px; color: rgba(255,255,255,0.8); font-weight: 600; }
        .left-nav-sub  { font-size: 11px; color: rgba(255,255,255,0.45); }

        .left-footer-text {
            font-size: 11px; color: rgba(255,255,255,0.35);
            position: relative; z-index: 1;
        }

        /* ========= RIGHT PANEL: Login Form ========= */
        .login-right {
            flex: 1;
            background: rgba(255,255,255,0.88);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            padding: 44px 48px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .form-eyebrow {
            font-size: 11px; font-weight: 700; color: #64748b;
            text-transform: uppercase; letter-spacing: 0.8px;
            margin-bottom: 6px;
        }
        .form-title {
            font-size: 28px; font-weight: 800; color: #0f2732;
            letter-spacing: -0.6px; margin-bottom: 6px;
        }
        .form-subtitle { font-size: 13px; color: #64748b; margin-bottom: 32px; }

        .input-group-custom { margin-bottom: 18px; }
        .input-label {
            display: block; font-size: 12px; font-weight: 700;
            color: #374151; margin-bottom: 7px;
        }
        .input-field {
            width: 100%; padding: 11px 15px;
            border: 1.5px solid #e2e8f0;
            border-radius: 12px;
            font-size: 14px; font-family: inherit; color: #0f2732;
            background: #fff;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        .input-field:focus {
            border-color: #08b89d;
            box-shadow: 0 0 0 4px rgba(8,184,157,0.12);
        }
        .input-field::placeholder { color: #94a3b8; }

        .remember-row {
            display: flex; align-items: center; justify-content: space-between;
            margin-bottom: 24px;
        }
        .remember-label {
            display: flex; align-items: center; gap: 8px;
            font-size: 13px; color: #475569; cursor: pointer;
        }
        .btn-login {
            width: 100%; padding: 13px 20px;
            background: #0e3746; color: #fff;
            border: none; border-radius: 14px;
            font-size: 15px; font-weight: 700; font-family: inherit;
            cursor: pointer; letter-spacing: -0.2px;
            box-shadow: 0 8px 22px rgba(14,55,70,0.28);
            transition: all 0.2s ease;
            display: flex; align-items: center; justify-content: center; gap: 8px;
        }
        .btn-login:hover {
            background: #082431;
            transform: translateY(-1px);
            box-shadow: 0 12px 28px rgba(14,55,70,0.35);
        }

        /* ========= QUICK LOGIN GRID ========= */
        .quick-login-section { margin-top: 28px; padding-top: 24px; border-top: 1px solid #e2e8f0; }
        .quick-label {
            font-size: 11px; font-weight: 700; text-transform: uppercase;
            letter-spacing: 0.7px; color: #94a3b8; text-align: center; margin-bottom: 14px;
        }
        .quick-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
        .quick-tile {
            display: block; padding: 12px 14px;
            border-radius: 14px; text-decoration: none;
            border: 1.5px solid transparent;
            transition: all 0.2s ease;
            position: relative; overflow: hidden;
        }
        .quick-tile::before {
            content: ''; position: absolute; inset: 0;
            opacity: 0; transition: opacity 0.2s;
        }
        .quick-tile:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(0,0,0,0.08); }
        .quick-tile-owner   { background: #f0fdf4; border-color: #bbf7d0; }
        .quick-tile-owner:hover { border-color: #4ade80; }
        .quick-tile-purple  { background: #faf5ff; border-color: #e9d5ff; }
        .quick-tile-purple:hover { border-color: #c084fc; }
        .quick-tile-amber   { background: #fffbeb; border-color: #fde68a; }
        .quick-tile-amber:hover { border-color: #fbbf24; }
        .quick-tile-blue    { background: #eff6ff; border-color: #bfdbfe; }
        .quick-tile-blue:hover { border-color: #60a5fa; }

        .quick-tile-name { font-size: 13px; font-weight: 700; display: block; margin-bottom: 2px; }
        .quick-tile-role { font-size: 11px; display: block; }
        .quick-tile-owner .quick-tile-name   { color: #15803d; }
        .quick-tile-owner .quick-tile-role   { color: #22c55e; }
        .quick-tile-purple .quick-tile-name  { color: #7e22ce; }
        .quick-tile-purple .quick-tile-role  { color: #a855f7; }
        .quick-tile-amber .quick-tile-name   { color: #b45309; }
        .quick-tile-amber .quick-tile-role   { color: #f59e0b; }
        .quick-tile-blue .quick-tile-name    { color: #1d4ed8; }
        .quick-tile-blue .quick-tile-role    { color: #3b82f6; }

        .quick-badge {
            display: inline-block; padding: 2px 7px; border-radius: 20px;
            font-size: 10px; font-weight: 700; margin-bottom: 4px;
        }
        .badge-owner  { background: #dcfce7; color: #15803d; }
        .badge-member { background: #f1f5f9; color: #475569; }

        .quick-hint { font-size: 11px; color: #94a3b8; text-align: center; margin-top: 10px; }

        @media (max-width: 700px) {
            .login-left { display: none; }
            .login-right { padding: 32px 24px; }
            .quick-grid { grid-template-columns: 1fr 1fr; }
        }
    </style>
</head>
<body>

    <div class="login-window">

        <!-- ===== LEFT HERO PANEL ===== -->
        <div class="login-left">
            <div>
                <div class="left-brand-pill">
                    <i class="bi bi-layers-fill"></i>
                </div>
                <h2 class="left-title">Digital Agency<br>Studio</h2>
                <p class="left-desc">
                    Platform manajemen proyek &amp; validasi tugas tim agensi digital berbasis peran.
                </p>

                <div class="left-nav-items">
                    <div class="left-nav-item">
                        <div class="left-nav-icon" style="background: rgba(8,184,157,0.25);">
                            <i class="bi bi-grid-1x2-fill" style="color:#08b89d;"></i>
                        </div>
                        <div>
                            <div class="left-nav-text">Dashboard Proyek</div>
                            <div class="left-nav-sub">Pantau semua kampanye klien</div>
                        </div>
                    </div>
                    <div class="left-nav-item">
                        <div class="left-nav-icon" style="background: rgba(47,128,237,0.25);">
                            <i class="bi bi-check2-square" style="color:#60a5fa;"></i>
                        </div>
                        <div>
                            <div class="left-nav-text">Manajemen Tugas</div>
                            <div class="left-nav-sub">Assign berdasarkan spesialisasi</div>
                        </div>
                    </div>
                    <div class="left-nav-item">
                        <div class="left-nav-icon" style="background: rgba(245,158,11,0.2);">
                            <i class="bi bi-shield-check" style="color:#fbbf24;"></i>
                        </div>
                        <div>
                            <div class="left-nav-text">Validasi Owner</div>
                            <div class="left-nav-sub">Approve atau minta revisi</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="left-footer-text">
                Pemrograman Web III · Kelompok: Raffi, Rasya, Melda, Popita
            </div>
        </div>

        <!-- ===== RIGHT FORM PANEL ===== -->
        <div class="login-right">
            <div class="form-eyebrow">Platform Manajemen Agensi</div>
            <div class="form-title">Selamat Datang 👋</div>
            <div class="form-subtitle">Masuk ke akun Anda untuk mulai mengelola proyek dan tugas tim.</div>

            <!-- Session Status -->
            @if (session('status'))
                <div style="padding: 10px 14px; background: #dcfce7; border: 1px solid #bbf7d0; border-radius: 10px; color: #15803d; font-size: 13px; font-weight: 600; margin-bottom: 20px;">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div style="padding: 10px 14px; background: #fee2e2; border: 1px solid #fecaca; border-radius: 10px; color: #b91c1c; font-size: 13px; font-weight: 600; margin-bottom: 20px;">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="input-group-custom">
                    <label for="email" class="input-label">Alamat Email</label>
                    <input id="email" type="email" name="email" class="input-field"
                           value="{{ old('email') }}" required autofocus autocomplete="username"
                           placeholder="nama@agency.test">
                </div>

                <div class="input-group-custom">
                    <label for="password" class="input-label">Password</label>
                    <input id="password" type="password" name="password" class="input-field"
                           required autocomplete="current-password"
                           placeholder="••••••••">
                </div>

                <div class="remember-row">
                    <label class="remember-label">
                        <input type="checkbox" name="remember" id="remember_me" style="accent-color: #08b89d; width:15px; height:15px;">
                        <span>Ingat saya</span>
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" style="font-size:13px; color: #0e3746; font-weight:600; text-decoration:none;">
                            Lupa password?
                        </a>
                    @endif
                </div>

                <button type="submit" class="btn-login">
                    <i class="bi bi-box-arrow-in-right"></i> Masuk ke Dashboard
                </button>
            </form>

            <!-- Quick Login Demo Section -->
            <div class="quick-login-section">
                <div class="quick-label">⚡ Uji Coba Cepat — Akun Studi Kasus (Role.md)</div>
                <div class="quick-grid">
                    <a href="{{ route('quick-login', 'raffi@agency.test') }}" class="quick-tile quick-tile-owner">
                        <span class="quick-badge badge-owner">Owner / PM</span>
                        <span class="quick-tile-name">Raffi</span>
                        <span class="quick-tile-role">raffi@agency.test</span>
                    </a>
                    <a href="{{ route('quick-login', 'rasya@agency.test') }}" class="quick-tile quick-tile-purple">
                        <span class="quick-badge badge-member">Member</span>
                        <span class="quick-tile-name">Rasya Chaniago</span>
                        <span class="quick-tile-role">Graphic Designer</span>
                    </a>
                    <a href="{{ route('quick-login', 'melda@agency.test') }}" class="quick-tile quick-tile-amber">
                        <span class="quick-badge badge-member">Member</span>
                        <span class="quick-tile-name">Melda Munisa</span>
                        <span class="quick-tile-role">Content Creator</span>
                    </a>
                    <a href="{{ route('quick-login', 'popita@agency.test') }}" class="quick-tile quick-tile-blue">
                        <span class="quick-badge badge-member">Member</span>
                        <span class="quick-tile-name">Popita Sari</span>
                        <span class="quick-tile-role">Sosmed Specialist</span>
                    </a>
                </div>
                <p class="quick-hint">Password semua akun: <code style="font-weight:700; color:#0e3746;">password</code></p>
            </div>
        </div>

    </div>

</body>
</html>
