<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Agency PM')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <style>
        body { background:#f4f6fb; }
        .navbar-brand { font-weight:700; }
        .role-badge-content_creator { background:#ffe8cc; color:#b35900; }
        .role-badge-graphic_designer { background:#e0ccff; color:#5e17eb; }
        .role-badge-social_media_specialist { background:#cceeff; color:#006699; }
        .role-badge-owner { background:#d4f7dc; color:#1a7a33; }
        .task-card { border-left:4px solid #ccc; }
        .task-card.priority-high { border-left-color:#dc3545; }
        .task-card.priority-medium { border-left-color:#fd7e14; }
        .task-card.priority-low { border-left-color:#6c757d; }
        .kanban-col { min-height: 200px; }
    </style>
</head>
<body>
    @auth
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="{{ route('dashboard') }}"><i class="bi bi-kanban"></i> Agency PM</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('workspaces.index') }}">Workspace Saya</a></li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item"><span class="nav-link">{{ auth()->user()->name }}</span></li>
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="btn btn-sm btn-outline-light">Keluar</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    @endauth

    <div class="container pb-5">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
