@extends('layouts.app')
@section('title', 'Perfil de ' . $user->name)
@section('page-title', 'Perfil Público')
@section('page-subtitle', 'Información de inversionista')

@section('content')

<div class="grid-3" style="grid-template-columns: 1fr 2fr; gap:2rem;">
    
    {{-- Sidebar Profile --}}
    <div>
        <div class="profile-card">
            <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="profile-avatar">
            <div class="profile-name">{{ $user->name }}</div>
            <div style="margin-bottom:1.5rem;">
                <span class="profile-role-badge"><i class="fas fa-chart-pie"></i> Inversionista</span>
            </div>
            
            <p style="color:var(--white-soft); font-size:0.9rem; line-height:1.7; margin-bottom:1.5rem;">
                {{ $user->bio ?: 'Este inversionista aún no ha agregado una biografía.' }}
            </p>
            
            <div style="text-align:left; background:rgba(0,0,0,0.2); padding:1rem; border-radius:var(--radius-sm); border:1px solid rgba(255,255,255,0.05);">
                <div style="display:flex; align-items:center; gap:0.75rem; margin-bottom:0.75rem; font-size:0.85rem;">
                    <i class="fas fa-map-marker-alt" style="color:var(--gold); width:16px;"></i>
                    <span style="color:var(--white);">{{ $user->city ?: 'Ubicación no especificada' }}</span>
                </div>
                <div style="display:flex; align-items:center; gap:0.75rem; font-size:0.85rem;">
                    <i class="fas fa-calendar-alt" style="color:var(--gold); width:16px;"></i>
                    <span style="color:var(--white-dim);">Miembro desde {{ $user->created_at->format('M, Y') }}</span>
                </div>
            </div>
            
            <div class="profile-stats">
                <div>
                    <div class="profile-stat-value">{{ $investments->count() }}</div>
                    <div class="profile-stat-label">Inversiones</div>
                </div>
                <div style="grid-column: span 2;">
                    <div class="profile-stat-value">RD${{ number_format($totalInvested, 0) }}</div>
                    <div class="profile-stat-label">Total Invertido</div>
                </div>
            </div>
        </div>
    </div>
    
    {{-- Main Content --}}
    <div>
        <div class="card p-0" style="overflow:hidden;">
            <div class="card-header" style="padding:1.5rem; margin-bottom:0; background:var(--dark-2);">
                <h3 class="card-title">Portafolio de Inversión</h3>
            </div>
            
            @if($investments->isEmpty())
            <div class="empty-state" style="padding:4rem 2rem;">
                <div class="empty-state-icon"><i class="fas fa-briefcase"></i></div>
                <div class="empty-state-title">Portafolio Vacío</div>
                <p>Este inversionista aún no ha realizado inversiones en la plataforma.</p>
            </div>
            @else
            <div class="table-wrap" style="border:none; border-radius:0;">
                <table>
                    <thead>
                        <tr>
                            <th>Empresa</th>
                            <th>Industria</th>
                            <th>Participación</th>
                            <th>Monto (RD$)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($investments as $investment)
                        <tr>
                            <td>
                                <div style="display:flex; align-items:center; gap:0.75rem;">
                                    <img src="{{ $investment->company->logo_url }}" alt="Logo" style="width:32px; height:32px; border-radius:6px; background:var(--dark-3); object-fit:contain;">
                                    <a href="{{ route('companies.show', $investment->company) }}" style="font-weight:600; color:var(--white); transition:color 0.2s;" onmouseover="this.style.color='var(--gold)'" onmouseout="this.style.color='var(--white)'">
                                        {{ $investment->company->name }}
                                    </a>
                                </div>
                            </td>
                            <td><span style="font-size:0.75rem; color:var(--white-dim);">{{ $investment->company->category }}</span></td>
                            <td style="font-weight:700; color:var(--gold);">{{ $investment->percentage_acquired }}%</td>
                            <td style="font-weight:600; color:var(--white-soft);">{{ number_format($investment->amount_invested, 0) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>
    </div>
    
</div>

@endsection
