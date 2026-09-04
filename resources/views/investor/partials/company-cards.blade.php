@if($companies->isEmpty())
<div class="empty-state">
    <div class="empty-state-icon"><i class="fas fa-search"></i></div>
    <div class="empty-state-title">No se encontraron empresas</div>
    <p>Prueba ajustando tus filtros o cambiando los términos de búsqueda.</p>
</div>
@else
<div class="grid-4 mb-6">
    @foreach($companies as $company)
    <div class="company-card" onclick="window.location.href='{{ route('companies.show', $company) }}'">
        <div class="company-card-cover">
            <img src="{{ $company->cover_url }}" alt="{{ $company->name }}" class="company-card-cover-img">
            <div class="company-card-cover-overlay"></div>
            <span class="tag {{ $company->sale_type === 'individual' ? 'tag-individual' : 'tag-complete' }}"
                  style="position:absolute; top:10px; right:10px; font-size:0.6rem;">
                {{ $company->sale_type === 'individual' ? 'Individual' : 'Completo' }}
            </span>
            @if($company->is_featured)
                <span class="company-card-badge" style="top:10px; left:10px;"><i class="fas fa-star"></i></span>
            @endif
        </div>
        <div class="company-card-body">
            <div class="company-card-meta">
                <img src="{{ $company->logo_url }}" alt="{{ $company->name }}" class="company-card-logo">
                <div>
                    <div class="company-card-name">{{ $company->name }}</div>
                    <div class="company-card-category">{{ $company->category }}</div>
                </div>
            </div>
            
            <p class="company-card-desc">{{ $company->description }}</p>
            
            <div class="company-card-stats" style="margin-bottom:0.5rem;">
                <div class="company-stat">
                    <div class="company-stat-label">Disponible</div>
                    <div class="company-stat-value" style="font-size:0.8rem;">{{ $company->percentage_available }}%</div>
                </div>
                <div class="company-stat text-right">
                    <div class="company-stat-label">Valor</div>
                    <div class="company-stat-value" style="font-size:0.8rem; color:var(--white);">{{ $company->formatted_value }}</div>
                </div>
            </div>
            
            <div class="company-stat">
                <div class="company-stat-label">Emprendedor</div>
                <div style="font-size:0.75rem; color:var(--white-soft); display:flex; align-items:center; gap:0.4rem; margin-top:2px;">
                    <img src="{{ $company->user->avatar_url }}" alt="avatar" style="width:16px; height:16px; border-radius:50%; object-fit:cover;">
                    {{ $company->user->name }}
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

<div class="mt-4">
    {{ $companies->links('vendor.pagination.custom') }}
</div>
@endif
