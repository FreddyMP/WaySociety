@extends('layouts.app')
@section('title', 'Buscador de Empresas')
@section('page-title', 'Explorar Empresas')
@section('page-subtitle', 'Filtra y encuentra tu próxima inversión')

@section('content')

<div class="card mb-6" style="padding:1.5rem;">
    <form id="searchForm" action="{{ route('investor.search') }}" method="GET">
        <div style="display:flex; gap:1.5rem; align-items:center; flex-wrap:wrap;">
            <div class="search-bar" style="flex:1; min-width:300px; padding:0.6rem 1.25rem;">
                <i class="fas fa-search search-icon"></i>
                <input type="text" name="search" id="searchInput" placeholder="Buscar por nombre, categoría, descripción..." value="{{ request('search') }}">
            </div>
            
            <div style="display:flex; gap:1.5rem; flex-wrap:wrap;">
                <div>
                    <label style="font-size:0.65rem; color:var(--white-dim); text-transform:uppercase; letter-spacing:0.05em; padding-left:0.5rem; margin-bottom:0.25rem; display:block;">Tipo de Venta</label>
                    <select name="sale_type" id="saleTypeFilter" class="filter-select" style="min-width:180px;">
                        <option value="all" {{ request('sale_type') == 'all' ? 'selected' : '' }}>Todos los tipos</option>
                        <option value="individual" {{ request('sale_type') == 'individual' ? 'selected' : '' }}>Acciones Individuales</option>
                        <option value="complete" {{ request('sale_type') == 'complete' ? 'selected' : '' }}>Porcentaje Completo</option>
                    </select>
                </div>
                
                <div>
                    <label style="font-size:0.65rem; color:var(--white-dim); text-transform:uppercase; letter-spacing:0.05em; padding-left:0.5rem; margin-bottom:0.25rem; display:block;">Industria</label>
                    <select name="category" id="categoryFilter" class="filter-select" style="min-width:180px;">
                        <option value="all">Todas las industrias</option>
                        {{-- Needs to be passed if categories exist, assuming they are available via AJAX/Controller --}}
                        <option value="Tecnología" {{ request('category') == 'Tecnología' ? 'selected' : '' }}>Tecnología</option>
                        <option value="Salud y Bienestar" {{ request('category') == 'Salud y Bienestar' ? 'selected' : '' }}>Salud y Bienestar</option>
                        <option value="Alimentación" {{ request('category') == 'Alimentación' ? 'selected' : '' }}>Alimentación</option>
                        <option value="Educación" {{ request('category') == 'Educación' ? 'selected' : '' }}>Educación</option>
                        <option value="Turismo" {{ request('category') == 'Turismo' ? 'selected' : '' }}>Turismo</option>
                        <option value="Energía Renovable" {{ request('category') == 'Energía Renovable' ? 'selected' : '' }}>Energía Renovable</option>
                        <option value="Logística" {{ request('category') == 'Logística' ? 'selected' : '' }}>Logística</option>
                    </select>
                </div>
            </div>
            
            <button type="submit" class="btn btn-gold" style="align-self:flex-end; padding:0.75rem 2rem; height:44px;">
                <i class="fas fa-filter"></i> Filtrar
            </button>
        </div>
    </form>
</div>

<div id="searchResults">
    @include('investor.partials.company-cards', ['companies' => $companies])
</div>

@push('scripts')
<script>
$(document).ready(function() {
    let searchTimer;
    
    function fetchResults(url) {
        $('#searchResults').html('<div style="text-align:center; padding:3rem;"><span class="spinner" style="width:40px; height:40px; border-width:3px;"></span></div>');
        
        $.ajax({
            url: url,
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
            success: function(response) {
                if (response.html) {
                    $('#searchResults').html(response.html);
                }
            }
        });
    }

    $('#searchInput, #saleTypeFilter, #categoryFilter').on('input change', function() {
        clearTimeout(searchTimer);
        const form = $('#searchForm');
        const url = form.attr('action') + '?' + form.serialize();
        
        // Update URL without reload
        window.history.pushState({}, '', url);
        
        searchTimer = setTimeout(function() {
            fetchResults(url);
        }, 500);
    });
    
    // AJAX Pagination
    $(document).on('click', '.pagination a', function(e) {
        e.preventDefault();
        const url = $(this).attr('href');
        window.history.pushState({}, '', url);
        fetchResults(url);
    });
});
</script>
@endpush
@endsection
