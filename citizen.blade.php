<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'SEMARH Fiscaliza - Portal do Cidadão')</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @livewireStyles
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-success">
            <div class="container">
                <a class="navbar-brand" href="/">
                    <img src="https://via.placeholder.com/150x40.png?text=SEMARH+Fiscaliza" alt="Logo SEMARH Fiscaliza" style="height: 40px;">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Início</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('citizen.license.application') ? 'active' : '' }}" href="{{ route('citizen.license.application') }}">Solicitar Licença</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('citizen.process.search') ? 'active' : '' }}" href="{{ route('citizen.process.search') }}">Consultar Processo</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('citizen.complaint.create') ? 'active' : '' }}" href="{{ route('citizen.complaint.create') }}">Denúncias</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-light" href="#">Login GOV.BR</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main class="container my-4">
        {{ $slot }}
    </main>

    <footer class="bg-light text-center text-lg-start mt-auto">
        <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.05);">
            © 2026 RAZGO Tecnologia. Todos os direitos reservados. | Goiânia - GO | (62) 99646-6033
            <br>
            <small class="text-muted">SEMARH Fiscaliza® é uma marca e plataforma tecnológica desenvolvida e mantida pela RAZGO TECNOLOGIA LTDA.</small>
        </div>
    </footer>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @livewireScripts
</body>
</html>