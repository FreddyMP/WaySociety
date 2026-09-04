@extends('layouts.guest')
@section('title', 'Iniciar Sesión')
@section('meta_description', 'Accede a tu cuenta INVESTA y conecta con el futuro empresarial.')

@section('content')
<div class="auth-card">
    <div class="auth-card-header">
        <span class="auth-logo">INVESTA</span>
        <h2 style="font-size:1.6rem;color:var(--white);margin-bottom:0.25rem;">Bienvenido de vuelta</h2>
        <p style="font-size:0.85rem;color:var(--white-dim);">Ingresa tus credenciales para continuar</p>
    </div>

    <form action="{{ route('login') }}" method="POST" id="loginForm">
        @csrf
        <div class="form-group">
            <label class="form-label" for="email">Correo Electrónico</label>
            <div class="input-group">
                <span class="input-prefix"><i class="fas fa-envelope"></i></span>
                <input type="email"
                       class="form-control"
                       id="email"
                       name="email"
                       value="{{ old('email') }}"
                       placeholder="tu@email.com"
                       autocomplete="email"
                       required>
            </div>
            @error('email')<div class="form-error">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label class="form-label" for="password">Contraseña</label>
            <div class="input-group">
                <span class="input-prefix"><i class="fas fa-lock"></i></span>
                <input type="password"
                       class="form-control"
                       id="password"
                       name="password"
                       placeholder="••••••••"
                       autocomplete="current-password"
                       required
                       style="padding-left:2.5rem;padding-right:2.75rem;">
                <button type="button" id="togglePassword"
                        style="position:absolute;right:0.9rem;top:50%;transform:translateY(-50%);background:none;border:none;color:var(--white-dim);cursor:pointer;font-size:0.9rem;">
                    <i class="fas fa-eye"></i>
                </button>
            </div>
            @error('password')<div class="form-error">{{ $message }}</div>@enderror
        </div>

        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.5rem;">
            <label style="display:flex;align-items:center;gap:0.5rem;cursor:pointer;font-size:0.83rem;color:var(--white-soft);">
                <input type="checkbox" name="remember" id="remember" style="accent-color:var(--gold);">
                Recordarme
            </label>
        </div>

        <button type="submit" class="btn btn-gold btn-full btn-lg" id="loginBtn">
            <i class="fas fa-sign-in-alt"></i>
            Iniciar Sesión
        </button>
    </form>

    <div class="auth-divider">o</div>

    <div style="text-align:center;">
        <p style="font-size:0.85rem;color:var(--white-soft);">
            ¿No tienes cuenta?
            <a href="{{ route('register') }}" style="color:var(--gold);font-weight:600;transition:color 0.2s;" onmouseover="this.style.color='var(--gold-light)'" onmouseout="this.style.color='var(--gold)'">
                Regístrate aquí
            </a>
        </p>
    </div>
</div>

@push('scripts')
<script>
$('#togglePassword').on('click', function() {
    const input = $('#password');
    const icon = $(this).find('i');
    if (input.attr('type') === 'password') {
        input.attr('type', 'text');
        icon.removeClass('fa-eye').addClass('fa-eye-slash');
    } else {
        input.attr('type', 'password');
        icon.removeClass('fa-eye-slash').addClass('fa-eye');
    }
});
$('#loginForm').on('submit', function() {
    $('#loginBtn').html('<span class="spinner"></span> Ingresando...').prop('disabled', true);
});
</script>
@endpush
@endsection
