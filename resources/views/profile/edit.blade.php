@extends('layouts.app')
@section('title', 'Mi Perfil')
@section('page-title', 'Configuración de Perfil')
@section('page-subtitle', 'Actualiza tu información personal')

@section('content')

<div class="card" style="max-width:800px;">
    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div style="display:flex; gap:2rem; align-items:center; margin-bottom:2.5rem; padding-bottom:1.5rem; border-bottom:1px solid rgba(201,168,76,0.1);">
            <div style="position:relative;">
                <img src="{{ $user->avatar_url }}" alt="Avatar" id="profileAvatarPreview" style="width:100px; height:100px; border-radius:50%; border:3px solid var(--gold); object-fit:cover;">
                <label for="avatar" style="position:absolute; bottom:0; right:0; width:32px; height:32px; background:var(--gold); color:var(--black); border-radius:50%; display:flex; align-items:center; justify-content:center; cursor:pointer; font-size:0.9rem; border:2px solid var(--dark-card); transition:var(--trans);">
                    <i class="fas fa-camera"></i>
                </label>
                <input type="file" id="avatar" name="avatar" accept="image/*" style="display:none;" onchange="previewAvatar(this)">
            </div>
            <div>
                <h3 style="font-family:'Cormorant Garamond', serif; font-size:1.5rem; color:var(--white); margin-bottom:0.25rem;">{{ $user->name }}</h3>
                <div style="font-size:0.85rem; color:var(--gold); text-transform:uppercase; letter-spacing:0.05em; font-weight:600;">
                    {{ $user->isEntrepreneur() ? 'Emprendedor' : 'Inversionista' }}
                </div>
                @error('avatar')<div class="form-error">{{ $message }}</div>@enderror
            </div>
        </div>
        
        <div class="form-row">
            <div class="form-group">
                <label class="form-label" for="name">Nombre Completo *</label>
                <div class="input-group">
                    <span class="input-prefix"><i class="fas fa-user"></i></span>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                </div>
                @error('name')<div class="form-error">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label class="form-label" for="email">Correo Electrónico (No modificable)</label>
                <div class="input-group">
                    <span class="input-prefix"><i class="fas fa-envelope"></i></span>
                    <input type="email" class="form-control" value="{{ $user->email }}" disabled style="opacity:0.6;">
                </div>
            </div>
        </div>
        
        <div class="form-row">
            <div class="form-group">
                <label class="form-label" for="phone">Teléfono de Contacto *</label>
                <div class="input-group">
                    <span class="input-prefix"><i class="fas fa-phone"></i></span>
                    <input type="tel" class="form-control" id="phone" name="phone" value="{{ old('phone', $user->phone) }}" required>
                </div>
                @error('phone')<div class="form-error">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label class="form-label" for="city">Ciudad</label>
                <div class="input-group">
                    <span class="input-prefix"><i class="fas fa-map-marker-alt"></i></span>
                    <input type="text" class="form-control" id="city" name="city" value="{{ old('city', $user->city) }}" placeholder="Ej: Santo Domingo">
                </div>
                @error('city')<div class="form-error">{{ $message }}</div>@enderror
            </div>
        </div>
        
        <div class="form-group">
            <label class="form-label" for="bio">Biografía / Perfil Profesional</label>
            <textarea class="form-control" id="bio" name="bio" rows="4" placeholder="Cuéntanos un poco sobre ti, tu experiencia y tus objetivos...">{{ old('bio', $user->bio) }}</textarea>
            @error('bio')<div class="form-error">{{ $message }}</div>@enderror
        </div>
        
        <h4 style="font-family:'Cormorant Garamond', serif; font-size:1.3rem; color:var(--white); margin:2rem 0 1.5rem; padding-bottom:0.75rem; border-bottom:1px solid rgba(255,255,255,0.05);">Cambiar Contraseña</h4>
        
        <div class="form-row">
            <div class="form-group">
                <label class="form-label" for="password">Nueva Contraseña</label>
                <div class="input-group">
                    <span class="input-prefix"><i class="fas fa-lock"></i></span>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Mínimo 8 caracteres">
                </div>
                <div class="form-hint">Déjalo en blanco si no deseas cambiarla.</div>
                @error('password')<div class="form-error">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label class="form-label" for="password_confirmation">Confirmar Contraseña</label>
                <div class="input-group">
                    <span class="input-prefix"><i class="fas fa-lock"></i></span>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Repite la nueva contraseña">
                </div>
            </div>
        </div>
        
        <div style="display:flex; justify-content:flex-end; margin-top:2rem;">
            <button type="submit" class="btn btn-gold btn-lg">
                <i class="fas fa-save"></i> Guardar Cambios
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
function previewAvatar(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#profileAvatarPreview').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush
@endsection
