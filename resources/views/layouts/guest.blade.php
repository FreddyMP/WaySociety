<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'INVESTA') — Conecta Ideas, Crece tu Futuro</title>
    <meta name="description" content="@yield('meta_description', 'INVESTA conecta emprendedores con inversionistas para hacer crecer los negocios del futuro.')">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    @stack('styles')
</head>
<body>

@if(session('success'))
<div class="toast-notification toast-success" id="globalToast">
    <i class="fas fa-check-circle"></i> {{ session('success') }}
</div>
@endif
@if(session('error'))
<div class="toast-notification toast-error" id="globalToast">
    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
</div>
@endif

<div class="guest-layout">
    <div class="guest-left">
        <div class="guest-left-bg"></div>
        <div class="guest-left-content">
            {{-- Golden particles decoration --}}
            <div class="guest-decoration" aria-hidden="true">
                <div class="deco-circle deco-1"></div>
                <div class="deco-circle deco-2"></div>
                <div class="deco-circle deco-3"></div>
            </div>
            <div class="mb-6">
                <span class="auth-logo" style="font-size:3rem;">INVESTA</span>
                <p style="font-size:0.8rem;letter-spacing:0.25em;color:var(--gold);text-transform:uppercase;margin-top:0.25rem;">Conecta Ideas · Crece tu Futuro</p>
            </div>
            <h2 style="font-size:2rem;max-width:380px;text-align:center;line-height:1.3;color:var(--white);margin-bottom:1.5rem;">
                Donde los <span style="color:var(--gold);">sueños empresariales</span> encuentran su capital
            </h2>
            <p style="color:var(--white-soft);max-width:340px;text-align:center;font-size:0.9rem;line-height:1.7;">
                La plataforma que conecta emprendedores con visión e inversionistas con experiencia para construir el futuro juntos.
            </p>

            <div style="display:flex;gap:2rem;margin-top:3rem;text-align:center;">
                <div>
                    <div style="font-family:'Cormorant Garamond',serif;font-size:2rem;font-weight:700;color:var(--gold);">500+</div>
                    <div style="font-size:0.72rem;color:var(--white-dim);text-transform:uppercase;letter-spacing:0.08em;">Empresas</div>
                </div>
                <div style="width:1px;background:rgba(201,168,76,0.2);"></div>
                <div>
                    <div style="font-family:'Cormorant Garamond',serif;font-size:2rem;font-weight:700;color:var(--gold);">200+</div>
                    <div style="font-size:0.72rem;color:var(--white-dim);text-transform:uppercase;letter-spacing:0.08em;">Inversionistas</div>
                </div>
                <div style="width:1px;background:rgba(201,168,76,0.2);"></div>
                <div>
                    <div style="font-family:'Cormorant Garamond',serif;font-size:2rem;font-weight:700;color:var(--gold);">RD$50M+</div>
                    <div style="font-size:0.72rem;color:var(--white-dim);text-transform:uppercase;letter-spacing:0.08em;">Invertidos</div>
                </div>
            </div>
        </div>
    </div>
    <div class="guest-right">
        @yield('content')
    </div>
</div>

<style>
.guest-decoration { position:absolute; inset:0; overflow:hidden; pointer-events:none; }
.deco-circle { position:absolute; border-radius:50%; border:1px solid rgba(201,168,76,0.08); }
.deco-1 { width:400px;height:400px; top:-100px;right:-100px; animation:rotateSlow 40s linear infinite; }
.deco-2 { width:250px;height:250px; bottom:50px;left:-50px; animation:rotateSlow 30s linear infinite reverse; }
.deco-3 { width:600px;height:600px; top:50%;left:50%;transform:translate(-50%,-50%); border-color:rgba(201,168,76,0.04); animation:rotateSlow 60s linear infinite; }
@keyframes rotateSlow { to { transform:rotate(360deg); } }
.deco-1,.deco-2 { transform-origin:center; }
.toast-notification {
    position:fixed; top:20px; right:20px; z-index:9999;
    padding:0.85rem 1.25rem; border-radius:10px;
    display:flex; align-items:center; gap:0.5rem;
    font-size:0.875rem; font-weight:500;
    animation:slideInRight 0.4s ease, fadeOut 0.5s ease 3.5s forwards;
    box-shadow:0 8px 32px rgba(0,0,0,0.4);
}
.toast-success { background:rgba(76,175,125,0.15); border:1px solid rgba(76,175,125,0.3); color:#4CAF7D; }
.toast-error   { background:rgba(224,92,92,0.15); border:1px solid rgba(224,92,92,0.3); color:#E05C5C; }
@keyframes slideInRight { from { transform:translateX(100%); opacity:0; } to { transform:translateX(0); opacity:1; } }
@keyframes fadeOut { to { opacity:0; transform:translateX(100%); } }
</style>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
@stack('scripts')
</body>
</html>
