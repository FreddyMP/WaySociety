@extends('layouts.guest')
@section('title', 'Crear Cuenta')
@section('meta_description', 'Únete a WaySociety y conecta con emprendedores e inversionistas.')

@section('content')
    <div class="auth-card" style="max-width:500px;">
        <div class="auth-card-header">
            <span class="auth-logo">WaySociety</span>
            <h2 style="font-size:1.6rem;color:var(--white);margin-bottom:0.25rem;">Crear cuenta</h2>
            <p style="font-size:0.85rem;color:var(--white-dim);">Únete a la plataforma líder de inversión</p>
        </div>

        <form action="{{ route('register') }}" method="POST" id="registerForm">
            @csrf

            <div class="form-group">
                <label class="form-label" for="name">Nombre Completo</label>
                <div class="input-group">
                    <span class="input-prefix"><i class="fas fa-user"></i></span>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}"
                        placeholder="Juan Pérez" required>
                </div>
                @error('name')
                <div class="form-error">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="email">Correo Electrónico</label>
                <div class="input-group">
                    <span class="input-prefix"><i class="fas fa-envelope"></i></span>
                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}"
                        placeholder="tu@email.com" required>
                </div>
                @error('email')
                <div class="form-error">{{ $message }}</div>@enderror
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="phone">Teléfono de Contacto</label>
                    <div class="input-group">
                        <span class="input-prefix"><i class="fas fa-phone"></i></span>
                        <input type="tel" class="form-control" id="phone" name="phone" value="{{ old('phone') }}"
                            placeholder="809-000-0000" required>
                    </div>
                    @error('phone')
                    <div class="form-error">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label" for="city">Ciudad</label>
                    <div class="input-group">
                        <span class="input-prefix"><i class="fas fa-map-marker-alt"></i></span>
                        <input type="text" class="form-control" id="city" name="city" value="{{ old('city') }}"
                            placeholder="Santo Domingo">
                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="password">Contraseña</label>
                    <div class="input-group">
                        <span class="input-prefix"><i class="fas fa-lock"></i></span>
                        <input type="password" class="form-control" id="password" name="password"
                            placeholder="Mínimo 8 caracteres" required>
                    </div>
                    @error('password')
                    <div class="form-error">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label" for="password_confirmation">Confirmar</label>
                    <div class="input-group">
                        <span class="input-prefix"><i class="fas fa-lock"></i></span>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
                            placeholder="Repite la contraseña" required>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-gold btn-full btn-lg" id="registerBtn">
                <i class="fas fa-user-plus"></i> Crear Cuenta
            </button>
        </form>

        <div class="auth-divider">o</div>
        <div style="text-align:center;">
            <p style="font-size:0.85rem;color:var(--white-soft);">
                ¿Ya tienes cuenta?
                <a href="{{ route('login') }}" style="color:var(--gold);font-weight:600;">
                    Inicia sesión
                </a>
            </p>
        </div>
    </div>

    @push('scripts')
        <script>
            $('#registerForm').on('submit', function () {
                $('#registerBtn').html('<span class="spinner"></span> Creando cuenta...').prop('disabled', true);
            });
        </script>
    @endpush
@endsection