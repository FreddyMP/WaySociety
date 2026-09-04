@extends('layouts.app')
@section('title', 'Mis Inversiones')
@section('page-title', 'Mis Inversiones')
@section('page-subtitle', 'Gestiona tu portafolio de inversión')

@section('content')

<div class="stats-grid mb-6">
    <div class="stat-card">
        <div class="stat-card-icon"><i class="fas fa-wallet"></i></div>
        <div class="stat-card-value">RD${{ number_format($totalInvested, 0) }}</div>
        <div class="stat-card-label">Total Invertido</div>
    </div>
    <div class="stat-card">
        <div class="stat-card-icon"><i class="fas fa-chart-line"></i></div>
        <div class="stat-card-value">{{ $investments->total() }}</div>
        <div class="stat-card-label">Inversiones Activas</div>
    </div>
</div>

<div class="card p-0" style="overflow:hidden;">
    <div class="table-wrap" style="border:none;">
        <table>
            <thead>
                <tr>
                    <th>Empresa</th>
                    <th>Emprendedor</th>
                    <th>Porcentaje Adquirido</th>
                    <th>Monto Invertido</th>
                    <th>Fecha</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($investments as $investment)
                <tr>
                    <td>
                        <div style="display:flex; align-items:center; gap:0.75rem;">
                            <img src="{{ $investment->company->logo_url }}" alt="{{ $investment->company->name }}" style="width:36px; height:36px; border-radius:8px; object-fit:contain; background:var(--dark-3);">
                            <div>
                                <div style="font-weight:600; color:var(--white);">{{ $investment->company->name }}</div>
                                <div style="font-size:0.75rem; color:var(--white-dim);">{{ $investment->company->category }}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div style="font-size:0.85rem; color:var(--white-soft);">{{ $investment->company->user->name }}</div>
                        <div style="font-size:0.75rem; color:var(--gold);">
                            <a href="#" onclick="openContactModal({{ $investment->company->id }}, '{{ addslashes($investment->company->name) }}', '{{ $investment->company->contact_phone }}', '{{ $investment->company->contact_email }}'); return false;">
                                Contactar
                            </a>
                        </div>
                    </td>
                    <td>
                        <span style="font-weight:700; color:var(--white);">{{ $investment->percentage_acquired }}%</span>
                    </td>
                    <td>
                        <span style="font-weight:600; color:var(--gold);">RD${{ number_format($investment->amount_invested, 0) }}</span>
                    </td>
                    <td>
                        <span style="font-size:0.8rem; color:var(--white-soft);">{{ $investment->created_at->format('d M, Y') }}</span>
                    </td>
                    <td>
                        <a href="{{ route('companies.show', $investment->company) }}" class="btn btn-outline-gold btn-sm">Ver Empresa</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center" style="padding:4rem 2rem;">
                        <div style="font-size:3rem; color:var(--white-dim); opacity:0.3; margin-bottom:1rem;"><i class="fas fa-folder-open"></i></div>
                        <div style="font-size:1.1rem; color:var(--white-soft); margin-bottom:0.5rem;">Tu portafolio está vacío</div>
                        <p style="color:var(--white-dim); margin-bottom:1.5rem;">Descubre empresas y comienza a invertir para ver tus activos aquí.</p>
                        <a href="{{ route('investor.search') }}" class="btn btn-gold"><i class="fas fa-search"></i> Buscar Oportunidades</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-4">
    {{ $investments->links('vendor.pagination.custom') }}
</div>

@endsection
