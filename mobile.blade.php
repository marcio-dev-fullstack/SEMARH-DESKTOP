<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>@yield('title', 'SEMARH Fiscaliza') - App do Agente</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    @livewireStyles

    <style>
        body {
            padding-bottom: 70px; /* Space for the fixed bottom navbar */
        }
        .bottom-nav {
            box-shadow: 0 -2px 5px rgba(0,0,0,0.1);
        }
        .bottom-nav .nav-link {
            display: flex;
            flex-direction: column;
            align-items: center;
            font-size: 0.75rem;
        }
        .bottom-nav .nav-link i {
            font-size: 1.5rem;
        }
    </style>
</head>
<body>
    <header class="p-3 bg-success text-white shadow-sm">
        <h1 class="h5 mb-0">@yield('title', 'Dashboard')</h1>
    </header>

    <main class="container-fluid my-3">
        {{ $slot }}
    </main>

    <nav class="navbar navbar-light bg-light fixed-bottom bottom-nav">
        <div class="container-fluid d-flex justify-content-around">
            <a class="nav-link {{ request()->routeIs('mobile.dashboard') ? 'text-success' : 'text-secondary' }}" href="{{ route('mobile.dashboard') }}">
                <i class="bi bi-speedometer2"></i>
                <span>Dashboard</span>
            </a>
            <a class="nav-link {{ request()->routeIs('mobile.tasks') ? 'text-success' : 'text-secondary' }}" href="{{ route('mobile.tasks') }}">
                <i class="bi bi-list-task"></i>
                <span>Minhas Tarefas</span>
            </a>
            <a class="nav-link text-secondary" href="#">
                <i class="bi bi-arrow-repeat"></i>
                <span>Sincronizar</span>
            </a>
        </div>
    </nav>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @livewireScripts
</body>
</html>