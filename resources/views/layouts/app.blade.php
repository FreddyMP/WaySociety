<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') — WaySociety</title>
    <meta name="description" content="@yield('meta_description', 'Panel de control WaySociety')">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    @stack('styles')
</head>

<body>

    <div class="layout-auth">

        {{-- ═══ SIDEBAR ════════════════════════════════════════ --}}
        <aside class="sidebar" id="sidebar">
            {{-- Logo --}}
            <div class="sidebar-logo">
                <div class="sidebar-logo-icon">W</div>
                <div>
                    <div class="sidebar-logo-text">WaySociety</div>
                    <div class="sidebar-logo-sub">Plataforma de Inversión</div>
                </div>
            </div>

            {{-- Navigation --}}
            <nav class="sidebar-nav">
                @if(auth()->user()->isEntrepreneur())
                    <div class="sidebar-section-label">Principal</div>
                    <a href="{{ route('dashboard') }}"
                        class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <span class="icon"><i class="fas fa-home"></i></span>
                        Inicio
                    </a>
                    <a href="{{ route('entrepreneur.companies') }}"
                        class="sidebar-link {{ request()->routeIs('entrepreneur.companies*') ? 'active' : '' }}">
                        <span class="icon"><i class="fas fa-building"></i></span>
                        Mis Empresas
                    </a>
                    <a href="{{ route('entrepreneur.companies.create') }}"
                        class="sidebar-link {{ request()->routeIs('entrepreneur.companies.create') ? 'active' : '' }}">
                        <span class="icon"><i class="fas fa-plus-circle"></i></span>
                        Nueva Empresa
                    </a>

                    <div class="sidebar-section-label">Conexiones</div>
                    <a href="{{ route('entrepreneur.investors') }}"
                        class="sidebar-link {{ request()->routeIs('entrepreneur.investors') ? 'active' : '' }}">
                        <span class="icon"><i class="fas fa-users"></i></span>
                        Inversionistas
                    </a>

                @else
                    <div class="sidebar-section-label">Principal</div>
                    <a href="{{ route('investor.dashboard') }}"
                        class="sidebar-link {{ request()->routeIs('investor.dashboard') ? 'active' : '' }}">
                        <span class="icon"><i class="fas fa-home"></i></span>
                        Inicio
                    </a>
                    <a href="{{ route('investor.search') }}"
                        class="sidebar-link {{ request()->routeIs('investor.search') ? 'active' : '' }}">
                        <span class="icon"><i class="fas fa-search"></i></span>
                        Buscar Empresas
                    </a>
                    <a href="{{ route('investor.investments') }}"
                        class="sidebar-link {{ request()->routeIs('investor.investments') ? 'active' : '' }}">
                        <span class="icon"><i class="fas fa-chart-line"></i></span>
                        Mis Inversiones
                    </a>
                    <a href="{{ route('investor.companies') }}"
                        class="sidebar-link {{ request()->routeIs('investor.companies') ? 'active' : '' }}">
                        <span class="icon"><i class="fas fa-envelope-open"></i></span>
                        Empresas Recibidas
                        @php
                            $pendingCount = auth()->user()->receivedInvitations()->where('status', 'pending')->count();
                        @endphp
                        @if($pendingCount > 0)
                            <span class="badge-count">{{ $pendingCount }}</span>
                        @endif
                    </a>
                @endif

                <div class="sidebar-section-label">Cuenta</div>
                <a href="{{ route('notifications.index') }}"
                    class="sidebar-link {{ request()->routeIs('notifications.*') ? 'active' : '' }}"
                    id="sidebarNotifLink">
                    <span class="icon"><i class="fas fa-bell"></i></span>
                    Notificaciones
                    <span class="badge-count hidden" id="sidebarNotifBadge">0</span>
                </a>
                <a href="{{ route('profile.edit') }}"
                    class="sidebar-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                    <span class="icon"><i class="fas fa-user-circle"></i></span>
                    Mi Perfil
                </a>
                <form action="{{ route('logout') }}" method="POST" style="margin:0;">
                    @csrf
                    <button type="submit" class="sidebar-link"
                        style="width:100%;background:none;text-align:left;border:none;border-left:3px solid transparent;">
                        <span class="icon"><i class="fas fa-sign-out-alt"></i></span>
                        Cerrar Sesión
                    </button>
                </form>
            </nav>

            {{-- User Footer --}}
            <div class="sidebar-footer">
                <a href="{{ route('profile.edit') }}" class="sidebar-user">
                    <img src="{{ auth()->user()->avatar_url }}" alt="{{ auth()->user()->name }}"
                        class="sidebar-user-avatar"
                        onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=C9A84C&color=000&bold=true'">
                    <div style="min-width:0;">
                        <div class="sidebar-user-name">{{ auth()->user()->name }}</div>
                        <div class="sidebar-user-role">
                            <i class="fas {{ auth()->user()->isEntrepreneur() ? 'fa-rocket' : 'fa-chart-pie' }}"
                                style="font-size:0.6rem;"></i>
                            {{ auth()->user()->isEntrepreneur() ? 'Emprendedor' : 'Inversionista' }}
                        </div>
                    </div>
                    <i class="fas fa-chevron-right"
                        style="color:var(--white-dim);font-size:0.7rem;margin-left:auto;flex-shrink:0;"></i>
                </a>
            </div>
        </aside>

        {{-- ═══ MAIN CONTENT ═══════════════════════════════════ --}}
        <div class="main-content">

            {{-- Navbar --}}
            <header class="navbar">
                <div class="navbar-left">
                    <button class="navbar-icon-btn" id="sidebarToggle" style="display:none;">
                        <i class="fas fa-bars"></i>
                    </button>
                    <div>
                        <div class="navbar-title">@yield('page-title', 'Dashboard')</div>
                        @hasSection('page-subtitle')
                            <div style="font-size:0.72rem;color:var(--white-dim);">@yield('page-subtitle')</div>
                        @endif
                    </div>
                </div>
                <div class="navbar-right">
                    <a href="{{ route('notifications.index') }}" class="navbar-icon-btn" id="navbarNotifBtn"
                        title="Notificaciones">
                        <i class="fas fa-bell"></i>
                        <span class="notif-badge hidden" id="navbarNotifBadge">0</span>
                    </a>
                    <a href="{{ route('profile.edit') }}" class="navbar-profile" id="navbarProfile">
                        <img src="{{ auth()->user()->avatar_url }}" alt="{{ auth()->user()->name }}"
                            class="navbar-profile-img"
                            onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=C9A84C&color=000&bold=true&size=60'">
                        <div>
                            <div class="navbar-profile-name">{{ auth()->user()->name }}</div>
                            <div class="navbar-profile-role">
                                {{ auth()->user()->isEntrepreneur() ? 'Emprendedor' : 'Inversionista' }}</div>
                        </div>
                        <i class="fas fa-chevron-down" style="color:var(--white-dim);font-size:0.7rem;"></i>
                    </a>
                </div>
            </header>

            {{-- Alerts --}}
            @if(session('success'))
                <div style="padding:1rem 2rem 0;">
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i> {{ session('success') }}
                        <button onclick="this.parentElement.remove()"
                            style="margin-left:auto;background:none;border:none;color:inherit;cursor:pointer;font-size:1rem;">&times;</button>
                    </div>
                </div>
            @endif
            @if(session('error'))
                <div style="padding:1rem 2rem 0;">
                    <div class="alert alert-error">
                        <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                        <button onclick="this.parentElement.remove()"
                            style="margin-left:auto;background:none;border:none;color:inherit;cursor:pointer;font-size:1rem;">&times;</button>
                    </div>
                </div>
            @endif
            @if($errors->any())
                <div style="padding:1rem 2rem 0;">
                    <div class="alert alert-error">
                        <i class="fas fa-exclamation-circle"></i>
                        <div>
                            @foreach($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                        <button onclick="this.parentElement.remove()"
                            style="margin-left:auto;background:none;border:none;color:inherit;cursor:pointer;font-size:1rem;">&times;</button>
                    </div>
                </div>
            @endif

            {{-- Page Content --}}
            <main class="page-content">
                @yield('content')
            </main>
        </div>
    </div>

    {{-- Contact Modal --}}
    @include('shared.contact-modal')

    {{-- Send to Investor Modal --}}
    @include('shared.send-investor-modal')

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    @stack('scripts')
</body>

</html>