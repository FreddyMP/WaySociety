@extends('layouts.app')
@section('title', 'Dashboard Inversionista')
@section('page-title', 'Descubre Oportunidades')
@section('page-subtitle', 'Invierte en el futuro empresarial')

@section('content')

{{-- Search Bar Section --}}
<div class="card mb-6" style="background:linear-gradient(135deg, rgba(201,168,76,0.08), rgba(20,20,20,0.9)); border-color:rgba(201,168,76,0.15);">
    <h2 style="font-family:'Cormorant Garamond', serif; font-size:1.8rem; color:var(--white); margin-bottom:1.5rem;">
        Descubre oportunidades<br>
        <span style="color:var(--gold); font-size:2.2rem;">invierte en el futuro</span>
    </h2>
    
    <form id="searchForm" action="{{ route('investor.search') }}" method="GET">
        <div style="display:flex; gap:1rem; align-items:center; flex-wrap:wrap;">
            <div class="search-bar" style="flex:1; min-width:300px;">
                <i class="fas fa-search search-icon"></i>
                <input type="text" name="search" id="searchInput" placeholder="Buscar empresas, productos, industrias..." value="{{ request('search') }}">
            </div>
            
            <div class="search-filters">
                <div style="display:flex; flex-direction:column; gap:0.25rem;">
                    <label style="font-size:0.65rem; color:var(--white-dim); text-transform:uppercase; letter-spacing:0.05em; padding-left:0.5rem;">Tipo de porcentaje</label>
                    <select name="sale_type" id="saleTypeFilter" class="filter-select">
                        <option value="all">Todos</option>
                        <option value="individual">Acciones Individuales</option>
                        <option value="complete">Porcentaje Completo</option>
                    </select>
                </div>
                
                <div style="display:flex; flex-direction:column; gap:0.25rem;">
                    <label style="font-size:0.65rem; color:var(--white-dim); text-transform:uppercase; letter-spacing:0.05em; padding-left:0.5rem;">Categoría</label>
                    <select name="category" id="categoryFilter" class="filter-select">
                        <option value="all">Todas</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}">{{ $cat }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            
            <button type="submit" class="btn btn-gold" style="align-self:flex-end; padding:0.65rem 2rem;">
                Buscar
            </button>
        </div>
    </form>
</div>

<div class="grid-3" style="grid-template-columns: 2fr 1fr; gap:1.5rem;">
    {{-- Main Left Column --}}
    <div>
        {{-- Featured Companies --}}
        @if($featuredCompanies->count() > 0)
        <div class="section-header">
            <h3 class="section-title">Empresas Destacadas</h3>
            <a href="{{ route('investor.search') }}" class="btn btn-dark btn-sm">Ver todas</a>
        </div>
        <div class="grid-2 mb-6" id="featuredGrid">
            @foreach($featuredCompanies as $company)
            <div class="company-card" onclick="window.location.href='{{ route('companies.show', $company) }}'">
                <div class="company-card-cover" style="height:140px;">
                    <img src="{{ $company->cover_url }}" alt="{{ $company->name }}" class="company-card-cover-img">
                    <div class="company-card-cover-overlay"></div>
                    <span class="company-card-badge">Destacada</span>
                </div>
                <div class="company-card-body">
                    <div class="company-card-name">{{ $company->name }}</div>
                    <div class="company-card-category">{{ $company->category }}</div>
                    <p class="company-card-desc" style="font-size:0.75rem;">{{ $company->description }}</p>
                    <div class="company-card-stats" style="padding-top:0.5rem; margin-top:0.5rem;">
                        <div class="company-stat">
                            <div class="company-stat-label">Porcentaje</div>
                            <div class="company-stat-value" style="font-size:0.8rem;">{{ $company->percentage_available }}%</div>
                        </div>
                        <div class="company-stat text-right">
                            <div class="company-stat-label">Valor empresa</div>
                            <div class="company-stat-value" style="font-size:0.8rem; color:var(--white);">{{ $company->formatted_value }}</div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif

        {{-- Recent Companies Table --}}
        <div class="section-header mb-4" style="margin-top:2rem;">
            <h3 class="section-title">Empresas Recientes</h3>
        </div>
        <div class="card p-0" style="padding:0; overflow:hidden;">
            <div class="table-wrap" style="border:none;">
                <table id="recentCompaniesTable">
                    <thead>
                        <tr>
                            <th>Empresa</th>
                            <th>Categoría</th>
                            <th>Tipo de venta</th>
                            <th>Porcentaje</th>
                            <th>Valor empresa</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentCompanies as $company)
                        <tr>
                            <td>
                                <div style="display:flex; align-items:center; gap:0.5rem;">
                                    <img src="{{ $company->logo_url }}" alt="{{ $company->name }}" style="width:24px; height:24px; border-radius:4px; object-fit:contain; background:var(--dark-3);">
                                    <span style="font-weight:600; color:var(--white);">{{ $company->name }}</span>
                                </div>
                            </td>
                            <td><span style="font-size:0.75rem; color:var(--white-dim);">{{ $company->category }}</span></td>
                            <td>
                                <span class="tag {{ $company->sale_type === 'individual' ? 'tag-individual' : 'tag-complete' }}">
                                    {{ $company->sale_type === 'individual' ? 'Individual' : 'Completo' }}
                                </span>
                            </td>
                            <td style="font-weight:600; color:var(--gold);">{{ $company->percentage_available }}%</td>
                            <td style="font-size:0.8rem;">{{ $company->formatted_value }}</td>
                            <td>
                                <a href="{{ route('companies.show', $company) }}" class="btn btn-outline-gold btn-sm" style="padding:0.25rem 0.75rem; font-size:0.75rem;">Ver</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center" style="padding:2rem;">
                                No hay empresas disponibles actualmente.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        {{ $recentCompanies->links('vendor.pagination.custom') }}
    </div>

    {{-- Right Column (Profile & Investments) --}}
    <div>
        {{-- Profile Mini Card --}}
        <div class="card mb-6" style="text-align:center; padding:2rem 1.5rem;">
            <h3 style="font-size:0.9rem; color:var(--white-dim); text-transform:uppercase; letter-spacing:0.1em; text-align:left; margin-bottom:1rem; border-bottom:1px solid rgba(201,168,76,0.1); padding-bottom:0.5rem;">Mi Perfil</h3>
            <img src="{{ auth()->user()->avatar_url }}" alt="Avatar" style="width:80px; height:80px; border-radius:50%; border:2px solid var(--gold); margin:0 auto 1rem; object-fit:cover;">
            <h4 style="font-family:'Cormorant Garamond', serif; font-size:1.3rem; margin-bottom:0.25rem;">{{ auth()->user()->name }}</h4>
            <div style="font-size:0.75rem; color:var(--white-dim); margin-bottom:1.5rem;">
                <i class="fas fa-map-marker-alt" style="color:var(--gold);"></i> {{ auth()->user()->city ?? 'Sin ubicación' }}
            </div>
            
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:0.5rem; text-align:left; background:var(--dark-2); padding:1rem; border-radius:var(--radius-sm); margin-bottom:1.5rem;">
                <div>
                    <div style="font-size:0.65rem; color:var(--white-dim); text-transform:uppercase;">Inversiones Activas</div>
                    <div style="font-size:1.2rem; font-weight:700; color:var(--white);">{{ $activeInvestments }}</div>
                </div>
                <div>
                    <div style="font-size:0.65rem; color:var(--white-dim); text-transform:uppercase;">Total Invertido</div>
                    <div style="font-size:1.2rem; font-weight:700; color:var(--gold);">RD${{ number_format($totalInvested, 0) }}</div>
                </div>
            </div>
            
            <a href="{{ route('investor.profile', auth()->user()) }}" class="btn btn-outline-gold btn-full">
                Ver mi perfil público
            </a>
        </div>

        {{-- My Investments List --}}
        <div class="card" style="padding:1.5rem 1rem;">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1rem; padding:0 0.5rem;">
                <h3 style="font-size:0.9rem; color:var(--white-dim); text-transform:uppercase; letter-spacing:0.1em;">Mis Inversiones</h3>
                <a href="{{ route('investor.investments') }}" style="font-size:0.75rem; color:var(--gold);">Ver todas</a>
            </div>
            
            <div style="display:flex; flex-direction:column; gap:0.5rem;">
                @forelse($myInvestments as $investment)
                <a href="{{ route('companies.show', $investment->company) }}" style="display:flex; align-items:center; gap:0.75rem; padding:0.75rem; border-radius:var(--radius-sm); transition:var(--trans); border:1px solid transparent;" onmouseover="this.style.background='var(--dark-2)'; this.style.borderColor='rgba(201,168,76,0.1)'" onmouseout="this.style.background='transparent'; this.style.borderColor='transparent'">
                    <img src="{{ $investment->company->logo_url }}" alt="Logo" style="width:32px; height:32px; border-radius:6px; object-fit:contain; background:var(--dark-3);">
                    <div style="flex:1; min-width:0;">
                        <div style="font-size:0.85rem; font-weight:600; color:var(--white); white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">{{ $investment->company->name }}</div>
                        <div style="font-size:0.7rem; color:var(--white-dim);">{{ $investment->percentage_acquired }}% Adquirido</div>
                    </div>
                    <div style="text-align:right;">
                        <div style="font-size:0.8rem; font-weight:700; color:var(--gold);">RD${{ number_format($investment->amount_invested, 0) }}</div>
                    </div>
                </a>
                @empty
                <div class="text-center" style="padding:2rem 1rem; color:var(--white-dim); font-size:0.8rem;">
                    Aún no tienes inversiones registradas.
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Live search via AJAX
$(document).ready(function() {
    let searchTimer;
    
    $('#searchInput, #saleTypeFilter, #categoryFilter').on('input change', function() {
        clearTimeout(searchTimer);
        
        // Only run AJAX if we are on the /search page, otherwise let the form submit normally
        if (window.location.pathname !== '{{ route('investor.search', [], false) }}') {
            return;
        }
        
        const form = $('#searchForm');
        searchTimer = setTimeout(function() {
            $.ajax({
                url: form.attr('action'),
                data: form.serialize(),
                headers: { 'X-Requested-With': 'XMLHttpRequest' },
                success: function(response) {
                    if (response.html) {
                        $('#searchResults').html(response.html);
                    }
                }
            });
        }, 400);
    });
});
</script>
@endpush
@endsection
