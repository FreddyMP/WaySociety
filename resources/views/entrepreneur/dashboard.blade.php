@extends('layouts.app')
@section('title', 'Dashboard')
@section('page-title', 'Mis Empresas')
@section('page-subtitle', 'Gestiona y crece tu portafolio empresarial')

@section('content')
{{-- Stats --}}
<div class="stats-grid mb-8">
    <div class="stat-card">
        <div class="stat-card-icon"><i class="fas fa-building"></i></div>
        <div class="stat-card-value">{{ $companies->count() }}</div>
        <div class="stat-card-label">Empresas Registradas</div>
    </div>
    <div class="stat-card">
        <div class="stat-card-icon"><i class="fas fa-chart-pie"></i></div>
        <div class="stat-card-value">{{ $companies->sum('investments_count') }}</div>
        <div class="stat-card-label">Inversiones Activas</div>
    </div>
    <div class="stat-card">
        <div class="stat-card-icon"><i class="fas fa-boxes"></i></div>
        <div class="stat-card-value">{{ $companies->sum('products_count') }}</div>
        <div class="stat-card-label">Productos / Servicios</div>
    </div>
    <div class="stat-card">
        <div class="stat-card-icon"><i class="fas fa-envelope-open-text"></i></div>
        <div class="stat-card-value">{{ auth()->user()->sentInvitations()->count() }}</div>
        <div class="stat-card-label">Propuestas Enviadas</div>
    </div>
</div>

{{-- Section Header --}}
<div class="section-header mb-6">
    <h2 class="section-title"><i class="fas fa-building" style="color:var(--gold);font-size:1.1rem;"></i> Mis Empresas</h2>
    <a href="{{ route('entrepreneur.companies.create') }}" class="btn btn-gold">
        <i class="fas fa-plus"></i> Nueva Empresa
    </a>
</div>

@if($companies->isEmpty())
<div class="card">
    <div class="empty-state">
        <div class="empty-state-icon">🏢</div>
        <div class="empty-state-title">Aún no tienes empresas registradas</div>
        <p style="margin-bottom:1.5rem;">Registra tu primera empresa y conecta con inversionistas interesados en tu proyecto.</p>
        <a href="{{ route('entrepreneur.companies.create') }}" class="btn btn-gold btn-lg">
            <i class="fas fa-plus"></i> Registrar Primera Empresa
        </a>
    </div>
</div>
@else
<div class="grid-3" id="companiesGrid">
    @foreach($companies as $company)
    <div class="company-card" data-id="{{ $company->id }}">
        <div class="company-card-cover" style="position:relative;">
            <img src="{{ $company->cover_url }}"
                 alt="{{ $company->name }}"
                 class="company-card-cover-img"
                 onerror="this.style.display='none'">
            <div class="company-card-cover-overlay"></div>
            @if($company->is_featured)
                <span class="company-card-badge">⭐ Destacada</span>
            @endif
            <span class="tag {{ $company->sale_type === 'individual' ? 'tag-individual' : 'tag-complete' }}"
                  style="position:absolute;bottom:10px;right:10px;font-size:0.62rem;">
                {{ $company->sale_type === 'individual' ? 'Acciones Individuales' : 'Porcentaje Completo' }}
            </span>
        </div>
        <div class="company-card-body">
            <div class="company-card-meta">
                <img src="{{ $company->logo_url }}" alt="{{ $company->name }}" class="company-card-logo"
                     onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($company->name) }}&background=3D2B1F&color=C9A84C&bold=true'">
                <div>
                    <div class="company-card-name">{{ $company->name }}</div>
                    <div class="company-card-category">{{ $company->category ?? 'Sin categoría' }}</div>
                </div>
            </div>
            <p class="company-card-desc">{{ $company->description ?? 'Sin descripción.' }}</p>
            <div class="company-card-stats">
                <div class="company-stat">
                    <div class="company-stat-label">Disponible</div>
                    <div class="company-stat-value">{{ $company->percentage_available }}%</div>
                </div>
                <div class="company-stat">
                    <div class="company-stat-label">Valor empresa</div>
                    <div class="company-stat-value" style="font-size:0.75rem;">{{ $company->formatted_value }}</div>
                </div>
                <div class="company-stat">
                    <div class="company-stat-label">Inversiones</div>
                    <div class="company-stat-value">{{ $company->investments_count }}</div>
                </div>
            </div>
            <div style="display:flex;gap:0.5rem;margin-top:0.85rem;">
                <a href="{{ route('companies.show', $company) }}" class="btn btn-outline-gold btn-sm" style="flex:1;justify-content:center;">
                    <i class="fas fa-eye"></i> Ver
                </a>
                <a href="{{ route('entrepreneur.companies.edit', $company) }}" class="btn btn-dark btn-sm" style="flex:1;justify-content:center;">
                    <i class="fas fa-pen"></i> Editar
                </a>
                <button class="btn btn-dark btn-sm btn-send-company"
                        data-company="{{ $company->id }}"
                        data-name="{{ $company->name }}"
                        title="Enviar a inversionista">
                    <i class="fas fa-paper-plane" style="color:var(--gold);"></i>
                </button>
                <form action="{{ route('entrepreneur.companies.destroy', $company) }}" method="POST"
                      onsubmit="return confirm('¿Eliminar empresa {{ $company->name }}?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm" title="Eliminar">
                        <i class="fas fa-trash"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endif

@push('scripts')
<script>
// Send to investor button
$('.btn-send-company').on('click', function() {
    const companyId = $(this).data('company');
    const companyName = $(this).data('name');
    openSendInvestorModal(companyId, companyName);
});
</script>
@endpush
@endsection
