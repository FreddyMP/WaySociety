@extends('layouts.app')
@section('title', 'Directorio de Inversionistas')
@section('page-title', 'Inversionistas')
@section('page-subtitle', 'Conecta con perfiles interesados en tu industria')

@section('content')

    <div class="card mb-6" style="padding:1.5rem; background:linear-gradient(135deg, var(--dark-2), var(--dark-3));">
        <div style="display:flex; align-items:center; gap:1.5rem;">
            <div style="font-size:3rem; color:var(--gold);"><i class="fas fa-network-wired"></i></div>
            <div>
                <h3
                    style="font-family:'Cormorant Garamond', serif; font-size:1.4rem; color:var(--white); margin-bottom:0.25rem;">
                    Haz crecer tu red de contactos</h3>
                <p style="color:var(--white-soft); font-size:0.9rem;">Explora los perfiles de los inversionistas registrados
                    en WaySociety. Revisa su historial de inversiones y envíales tus propuestas directamente.</p>
            </div>
        </div>
    </div>

    <div class="grid-3" id="investorsGrid">
        @foreach($investors as $investor)
            <div class="investor-card" style="flex-direction:column; align-items:stretch; text-align:center;">
                <img src="{{ $investor->avatar_url }}" alt="{{ $investor->name }}"
                    style="width:72px; height:72px; border-radius:50%; border:2px solid var(--gold); margin:0 auto 1rem; object-fit:cover;">

                <h4
                    style="font-family:'Cormorant Garamond', serif; font-size:1.2rem; color:var(--white); margin-bottom:0.25rem;">
                    {{ $investor->name }}</h4>
                <div style="font-size:0.8rem; color:var(--white-dim); margin-bottom:1rem;">
                    <i class="fas fa-map-marker-alt" style="color:var(--gold);"></i>
                    {{ $investor->city ?: 'Ubicación no especificada' }}
                </div>

                <div style="background:var(--dark-3); padding:0.75rem; border-radius:var(--radius-sm); margin-bottom:1.5rem;">
                    <div
                        style="font-size:0.75rem; color:var(--white-dim); text-transform:uppercase; letter-spacing:0.05em; margin-bottom:4px;">
                        Inversiones Activas</div>
                    <div style="font-size:1.2rem; font-weight:700; color:var(--gold);">{{ $investor->investments_count }}</div>
                </div>

                <a href="{{ route('investor.profile', $investor) }}" class="btn btn-outline-gold btn-full btn-sm">
                    Ver Perfil
                </a>
            </div>
        @endforeach
    </div>

    <div class="mt-6">
        {{ $investors->links('vendor.pagination.custom') }}
    </div>

@endsection