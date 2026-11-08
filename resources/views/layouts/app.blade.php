<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard') &bull; Digital Agency SaaS</title>

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 & Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <style>
        :root {
            --app-bg-sidebar: #0e3746;
            --app-bg-sidebar-dark: #0a2935;
            --app-accent-teal: #08b89d;
            --app-accent-blue: #2f80ed;
            --app-text-main: #1e293b;
            --app-text-muted: #64748b;
            --app-glass-bg: rgba(255, 255, 255, 0.88);
            --app-glass-border: rgba(255, 255, 255, 0.7);
            --app-card-radius: 24px;
        }

        * {
            box-sizing: border-box;
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
        }

        body {
            margin: 0;
            padding: 24px;
            min-height: 100vh;
            background: 
                radial-gradient(at 0% 0%, #d8eaf7 0px, transparent 45%),
                radial-gradient(at 100% 0%, #ebe0fa 0px, transparent 40%),
                radial-gradient(at 95% 95%, #d6f5eb 0px, transparent 45%),
                radial-gradient(at 20% 90%, #d3e7f5 0px, transparent 40%),
                #ebf3f8;
            background-attachment: fixed;
            color: var(--app-text-main);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Outer Rounded Desktop Shell (matching the photo) */
        .app-window-frame {
            width: 100%;
            max-width: 1480px;
            min-height: calc(100vh - 48px);
            background: rgba(255, 255, 255, 0.45);
            backdrop-filter: blur(30px);
            -webkit-backdrop-filter: blur(30px);
            border: 2px solid rgba(255, 255, 255, 0.9);
            border-radius: 36px;
            box-shadow: 
                0 30px 70px -15px rgba(14, 55, 70, 0.12),
                0 0 0 1px rgba(255, 255, 255, 0.6) inset;
            display: flex;
            overflow: hidden;
            position: relative;
        }

        /* Left Sidebar: Sleek Dark Teal */
        .app-sidebar {
            width: 110px;
            min-width: 110px;
            background: linear-gradient(180deg, var(--app-bg-sidebar) 0%, var(--app-bg-sidebar-dark) 100%);
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 30px 12px;
            z-index: 10;
        }

        .sidebar-brand-pill {
            width: 52px;
            height: 52px;
            border-radius: 20px;
            background: linear-gradient(135deg, #00d2ff 0%, #3a7bd5 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            font-size: 24px;
            box-shadow: 0 8px 20px rgba(0, 210, 255, 0.35);
            margin-bottom: 40px;
            text-decoration: none;
            transition: transform 0.2s ease;
        }
        .sidebar-brand-pill:hover {
            transform: scale(1.06);
            color: #fff;
        }

        .sidebar-nav {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-direction: column;
            gap: 22px;
            width: 100%;
            align-items: center;
        }

        .sidebar-nav-item {
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .sidebar-nav-link {
            width: 56px;
            height: 56px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: rgba(255, 255, 255, 0.7);
            font-size: 22px;
            text-decoration: none;
            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
            position: relative;
        }

        .sidebar-nav-link:hover {
            background: rgba(255, 255, 255, 0.12);
            color: #ffffff;
            transform: translateY(-2px);
        }

        /* Active Nav Pill: Pure White floating pill with Dark Teal Icon */
        .sidebar-nav-link.active {
            background: #ffffff;
            color: var(--app-bg-sidebar);
            box-shadow: 0 10px 24px rgba(0, 0, 0, 0.25);
            transform: scale(1.05);
        }

        .sidebar-nav-label {
            font-size: 11px;
            font-weight: 600;
            color: rgba(255, 255, 255, 0.65);
            margin-top: 6px;
            text-align: center;
            letter-spacing: -0.2px;
        }

        .sidebar-nav-link.active + .sidebar-nav-label {
            color: #ffffff;
            font-weight: 700;
        }

        /* Main Workspace Canvas (Floating Frosted Glass over ambient aura) */
        .app-main-canvas {
            flex: 1;
            background: var(--app-glass-bg);
            backdrop-filter: blur(28px);
            -webkit-backdrop-filter: blur(28px);
            border-top-left-radius: 32px;
            border-bottom-left-radius: 32px;
            margin-left: -6px;
            padding: 34px 44px;
            overflow-y: auto;
            max-height: calc(100vh - 48px);
            border-left: 1px solid rgba(255, 255, 255, 0.95);
            display: flex;
            flex-direction: column;
        }

        /* Top Bar */
        .top-navbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
        }

        .top-brand-text {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .brand-logo-icon {
            width: 36px;
            height: 36px;
            border-radius: 12px;
            background: linear-gradient(135deg, #00c6ff 0%, #0072ff 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 17px;
            box-shadow: 0 4px 12px rgba(0, 114, 255, 0.25);
        }

        .brand-company-title {
            font-size: 16px;
            font-weight: 800;
            color: #0f2732;
            letter-spacing: -0.4px;
            line-height: 1.2;
            margin: 0;
        }

        .brand-company-sub {
            font-size: 11px;
            font-weight: 600;
            color: var(--app-text-muted);
            margin: 0;
        }

        .top-nav-controls {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .icon-circle-btn {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.9);
            border: 1px solid rgba(226, 232, 240, 0.8);
            color: #475569;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.2s ease;
            box-shadow: 0 2px 6px rgba(0,0,0,0.03);
            text-decoration: none;
        }
        .icon-circle-btn:hover {
            background: #ffffff;
            color: #0f172a;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.06);
        }

        .user-profile-pill {
            display: flex;
            align-items: center;
            gap: 10px;
            background: rgba(255, 255, 255, 0.9);
            border: 1px solid rgba(226, 232, 240, 0.9);
            padding: 4px 14px 4px 5px;
            border-radius: 30px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.03);
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s ease;
        }
        .user-profile-pill:hover {
            background: #ffffff;
            box-shadow: 0 4px 14px rgba(0,0,0,0.06);
        }

        .user-avatar-circle {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: linear-gradient(135deg, #0e3746 0%, #17546a 100%);
            color: #ffffff;
            font-size: 13px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Action Bar */
        .content-action-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
        }

        .page-subtitle-breadcrumb {
            font-size: 12px;
            font-weight: 700;
            color: var(--app-text-muted);
            text-transform: uppercase;
            letter-spacing: 0.6px;
            margin-bottom: 2px;
        }

        .page-main-heading {
            font-size: 28px;
            font-weight: 800;
            color: #0f2732;
            letter-spacing: -0.6px;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .btn-theme-primary {
            background: var(--app-bg-sidebar);
            color: #ffffff;
            border-radius: 14px;
            font-weight: 700;
            font-size: 13px;
            padding: 10px 20px;
            border: none;
            box-shadow: 0 6px 18px rgba(14, 55, 70, 0.25);
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            transition: all 0.2s ease;
        }
        .btn-theme-primary:hover {
            background: #092631;
            color: #ffffff;
            transform: translateY(-1px);
            box-shadow: 0 8px 22px rgba(14, 55, 70, 0.35);
        }

        /* Clean Glass Cards (as in photo) */
        .clean-glass-card {
            background: rgba(255, 255, 255, 0.95);
            border: 1px solid rgba(255, 255, 255, 0.9);
            border-radius: var(--app-card-radius);
            box-shadow: 
                0 10px 25px -5px rgba(15, 41, 56, 0.05),
                0 0 0 1px rgba(226, 232, 240, 0.6);
            padding: 24px;
            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
            position: relative;
            overflow: hidden;
        }
        .clean-glass-card:hover {
            transform: translateY(-3px);
            box-shadow: 
                0 18px 36px -10px rgba(15, 41, 56, 0.09),
                0 0 0 1px rgba(203, 213, 225, 0.8);
        }

        /* Colorful Gradient Thumbnail (as in photo) */
        .card-gradient-thumb {
            width: 72px;
            height: 72px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            font-size: 30px;
            flex-shrink: 0;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }
        .card-gradient-thumb.thumb-pink {
            background: linear-gradient(135deg, #f72585 0%, #b5179e 100%);
        }
        .card-gradient-thumb.thumb-teal {
            background: linear-gradient(135deg, #00b4d8 0%, #0077b6 100%);
        }
        .card-gradient-thumb.thumb-green {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        }
        .card-gradient-thumb.thumb-orange {
            background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
        }
        .card-gradient-thumb.thumb-purple {
            background: linear-gradient(135deg, #8b5cf6 0%, #6d28d9 100%);
        }
        .card-gradient-thumb.thumb-amber {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        }

        /* Small Grid Thumb */
        .card-thumb-sm {
            width: 26px;
            height: 26px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            color: #fff;
            flex-shrink: 0;
        }

        /* Step Progress Line (as in photo) */
        .step-progress-track {
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .step-progress-bar {
            height: 6px;
            flex: 1;
            background: #e2e8f0;
            border-radius: 10px;
            overflow: hidden;
            position: relative;
        }
        .step-progress-fill {
            height: 100%;
            background: var(--app-accent-teal);
            border-radius: 10px;
            transition: width 0.4s ease;
        }

        /* Overlapping Avatar Group (as in photo) */
        .avatar-group-overlap {
            display: flex;
            align-items: center;
        }
        .avatar-circle-mini {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            border: 2px solid #ffffff;
            font-size: 10px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-left: -6px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.06);
        }
        .avatar-circle-mini:first-child {
            margin-left: 0;
        }
        .avatar-c-blue { background: #e0f2fe; color: #0369a1; }
        .avatar-c-teal { background: #ccfbf1; color: #0f766e; }
        .avatar-c-amber { background: #fef3c7; color: #b45309; }
        .avatar-c-purple { background: #ede9fe; color: #6d28d9; }
        .avatar-c-gray { background: #f1f5f9; color: #475569; }

        /* Status Dot Indicator */
        .status-dot {
            width: 9px;
            height: 9px;
            border-radius: 50%;
            display: inline-block;
        }
        .status-dot.dot-green { background: #10b981; box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.2); }
        .status-dot.dot-amber { background: #f59e0b; box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.2); }
        .status-dot.dot-red { background: #ef4444; box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.2); }

        /* Role Badges matching modern palette */
        .role-pill {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: -0.2px;
        }
        .role-pill-owner { background: #dcfce7; color: #15803d; border: 1px solid #bbf7d0; }
        .role-pill-content_creator { background: #fef3c7; color: #b45309; border: 1px solid #fde68a; }
        .role-pill-graphic_designer { background: #f3e8ff; color: #7e22ce; border: 1px solid #e9d5ff; }
        .role-pill-social_media_specialist { background: #e0f2fe; color: #0369a1; border: 1px solid #bae6fd; }

        /* Custom Scrollbar */
        .app-main-canvas::-webkit-scrollbar {
            width: 7px;
        }
        .app-main-canvas::-webkit-scrollbar-track {
            background: transparent;
        }
        .app-main-canvas::-webkit-scrollbar-thumb {
            background: rgba(148, 163, 184, 0.4);
            border-radius: 10px;
        }

        @media (max-width: 992px) {
            body { padding: 8px; }
            .app-window-frame { flex-direction: column; border-radius: 24px; min-height: 100vh; }
            .app-sidebar { width: 100%; min-width: 100%; height: auto; flex-direction: row; justify-content: space-between; padding: 14px 20px; }
            .sidebar-nav { flex-direction: row; justify-content: center; width: auto; gap: 12px; }
            .sidebar-brand-pill { margin-bottom: 0; width: 44px; height: 44px; font-size: 18px; }
            .app-main-canvas { border-radius: 0; margin-left: 0; padding: 20px 16px; max-height: none; }
        }
    </style>
</head>
<body>

    <!-- Outer Window Frame Container -->
    <div class="app-window-frame">

        <!-- 1. Left Dark Slate/Teal Sidebar -->
        <aside class="app-sidebar">
            <!-- Brand Icon Pill -->
            <a href="{{ route('dashboard') }}" class="sidebar-brand-pill" title="Digital Agency Studio">
                <i class="bi bi-layers-fill"></i>
            </a>

            <!-- Vertical Navigation Icons -->
            <ul class="sidebar-nav">
                <!-- Dashboard -->
                <li class="sidebar-nav-item">
                    <a href="{{ route('dashboard') }}" class="sidebar-nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" title="Dashboard">
                        <i class="bi bi-grid-1x2-fill"></i>
                    </a>
                    <span class="sidebar-nav-label">Dashboard</span>
                </li>

                <!-- Workspaces -->
                <li class="sidebar-nav-item">
                    <a href="{{ route('workspaces.index') }}" class="sidebar-nav-link {{ request()->routeIs('workspaces.*') ? 'active' : '' }}" title="Workspace">
                        <i class="bi bi-collection-fill"></i>
                    </a>
                    <span class="sidebar-nav-label">Workspace</span>
                </li>

                <!-- Projects / Classes -->
                <li class="sidebar-nav-item">
                    @php
                        $firstWs = auth()->user()?->workspaceMembers()->first()?->workspace;
                    @endphp
                    @if ($firstWs)
                        <a href="{{ route('workspaces.show', $firstWs) }}" class="sidebar-nav-link {{ request()->routeIs('projects.*') ? 'active' : '' }}" title="Campaign / Proyek">
                            <i class="bi bi-briefcase-fill"></i>
                        </a>
                    @else
                        <a href="{{ route('workspaces.index') }}" class="sidebar-nav-link" title="Campaign / Proyek">
                            <i class="bi bi-briefcase-fill"></i>
                        </a>
                    @endif
                    <span class="sidebar-nav-label">Proyek</span>
                </li>

                <!-- Tasks / Discussions -->
                <li class="sidebar-nav-item">
                    <a href="{{ route('dashboard') }}#my-tasks-section" class="sidebar-nav-link {{ request()->routeIs('tasks.*') ? 'active' : '' }}" title="Tugas Saya">
                        <i class="bi bi-check2-square"></i>
                    </a>
                    <span class="sidebar-nav-label">Tugas</span>
                </li>
            </ul>

            <!-- Bottom Logout Button in Sidebar -->
            <div class="mt-auto pt-4">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="sidebar-nav-link" title="Keluar / Logout" style="border:none; background:transparent;">
                        <i class="bi bi-box-arrow-left"></i>
                    </button>
                </form>
            </div>
        </aside>

        <!-- 2. Main Content Canvas (Frosted Glass Panel) -->
        <main class="app-main-canvas">

            <!-- Top Header Navbar -->
            <header class="top-navbar">
                <div class="top-brand-text">
                    <div class="brand-logo-icon">
                        <i class="bi bi-rocket-takeoff-fill"></i>
                    </div>
                    <div>
                        <h1 class="brand-company-title">Digital Agency Studio</h1>
                        <p class="brand-company-sub">Project Management & Task Validation Platform</p>
                    </div>
                </div>

                <!-- Right Controls: Search, Notification, Quick Role Switcher, Profile -->
                <div class="top-nav-controls">
                    <!-- Quick Role Switcher Dropdown (Role.md) -->
                    <div class="dropdown">
                        <button class="btn btn-sm btn-light border rounded-pill px-3 py-1.5 d-flex align-items-center gap-2 shadow-xs" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="status-dot dot-green"></span>
                            <span class="small fw-bold">Ganti Role Demo</span>
                            <i class="bi bi-chevron-down small text-muted"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-4 p-2" style="min-width: 260px;">
                            <li class="dropdown-header small text-uppercase fw-bold text-muted px-3 py-1">Akun Kelompok (Role.md)</li>
                            <li>
                                <a class="dropdown-item rounded-3 py-2 px-3 d-flex align-items-center justify-content-between" href="{{ route('quick-login', 'raffi@agency.test') }}">
                                    <div>
                                        <div class="fw-bold small text-dark">Raffi</div>
                                        <div class="text-muted" style="font-size:11px;">raffi@agency.test</div>
                                    </div>
                                    <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill">Owner / PM</span>
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item rounded-3 py-2 px-3 d-flex align-items-center justify-content-between" href="{{ route('quick-login', 'rasya@agency.test') }}">
                                    <div>
                                        <div class="fw-bold small text-dark">Rasya Chaniago</div>
                                        <div class="text-muted" style="font-size:11px;">Graphic Designer</div>
                                    </div>
                                    <span class="badge bg-purple-subtle text-purple border border-purple-subtle rounded-pill" style="background:#f3e8ff; color:#7e22ce;">Member</span>
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item rounded-3 py-2 px-3 d-flex align-items-center justify-content-between" href="{{ route('quick-login', 'melda@agency.test') }}">
                                    <div>
                                        <div class="fw-bold small text-dark">Melda Munisa</div>
                                        <div class="text-muted" style="font-size:11px;">Content Creator</div>
                                    </div>
                                    <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle rounded-pill">Member</span>
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item rounded-3 py-2 px-3 d-flex align-items-center justify-content-between" href="{{ route('quick-login', 'popita@agency.test') }}">
                                    <div>
                                        <div class="fw-bold small text-dark">Popita Sari</div>
                                        <div class="text-muted" style="font-size:11px;">Sosmed Specialist</div>
                                    </div>
                                    <span class="badge bg-info-subtle text-info-emphasis border border-info-subtle rounded-pill">Member</span>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <!-- Search Button -->
                    <button class="icon-circle-btn" title="Cari Proyek atau Tugas">
                        <i class="bi bi-search"></i>
                    </button>

                    <!-- Notification Bell -->
                    <button class="icon-circle-btn position-relative" title="Notifikasi">
                        <i class="bi bi-bell"></i>
                        <span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle"></span>
                    </button>

                    <!-- Settings Button -->
                    <a href="{{ route('profile.edit') }}" class="icon-circle-btn" title="Pengaturan Profil">
                        <i class="bi bi-gear"></i>
                    </a>

                    <!-- User Profile Pill -->
                    <div class="dropdown">
                        <div class="user-profile-pill" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="user-avatar-circle">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            <div class="d-none d-sm-block text-start">
                                <div class="fw-bold text-dark" style="font-size: 13px; line-height: 1.1;">{{ auth()->user()->name }}</div>
                                <div class="text-muted" style="font-size: 11px;">
                                    @php
                                        $currMembership = auth()->user()->workspaceMembers()->first();
                                    @endphp
                                    {{ $currMembership ? ($currMembership->role === 'owner' ? 'Owner / PM' : $currMembership->jobTitleLabel()) : 'Member' }}
                                </div>
                            </div>
                            <i class="bi bi-chevron-down text-muted small ms-1"></i>
                        </div>
                        <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-4 p-2">
                            <li><a class="dropdown-item rounded-3 small" href="{{ route('profile.edit') }}"><i class="bi bi-person me-2"></i> Edit Profil</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button class="dropdown-item rounded-3 small text-danger" type="submit"><i class="bi bi-box-arrow-right me-2"></i> Keluar</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </header>

            <!-- Alerts: Flash Messages -->
            @if (session('success'))
                <div class="alert alert-success border-0 rounded-4 shadow-xs d-flex align-items-center gap-2 mb-4" role="alert" style="background:#dcfce7; color:#15803d;">
                    <i class="bi bi-check-circle-fill fs-5"></i>
                    <div class="fw-semibold small">{{ session('success') }}</div>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger border-0 rounded-4 shadow-xs d-flex align-items-center gap-2 mb-4" role="alert" style="background:#fee2e2; color:#b91c1c;">
                    <i class="bi bi-exclamation-triangle-fill fs-5"></i>
                    <div class="fw-semibold small">{{ session('error') }}</div>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger border-0 rounded-4 shadow-xs mb-4" style="background:#fee2e2; color:#b91c1c;">
                    <div class="fw-bold small mb-1">Periksa kembali data Anda:</div>
                    <ul class="mb-0 small ps-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Main Content Injected Here -->
            <div class="flex-grow-1">
                @yield('content')
            </div>

            <!-- Sleek Footer -->
            <footer class="pt-4 mt-5 border-top border-slate-200/60 d-flex flex-column flex-sm-row justify-content-between align-items-center text-muted small" style="font-size: 11px;">
                <div>Digital Agency Studio &bull; Platform Manajemen Proyek Pemrograman Web III</div>
                <div class="mt-2 mt-sm-0">Kelompok: Raffi (25781097), Rasya (25781093), Melda (25781091), Popita (25781096)</div>
            </footer>

        </main>
    </div>

    <!-- Bootstrap 5 Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
