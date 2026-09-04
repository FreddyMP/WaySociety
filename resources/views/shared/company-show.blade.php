@extends('layouts.app')
@section('title', $company->name)
@section('page-title', 'Detalle de la Empresa')
@section('page-subtitle', 'Explora esta oportunidad de inversión')

@section('content')
<div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:1.5rem;">
    <a href="{{ url()->previous() }}" class="btn btn-dark btn-sm">
        <i class="fas fa-arrow-left"></i> Volver
    </a>
</div>

<div class="card p-0" style="overflow:hidden;">
    {{-- Header Section --}}
    <div style="padding:2.5rem; background:linear-gradient(to bottom, rgba(201,168,76,0.05), transparent); border-bottom:1px solid rgba(201,168,76,0.1); display:flex; gap:2rem; align-items:flex-start; flex-wrap:wrap;">
        <img src="{{ $company->logo_url }}" alt="{{ $company->name }}" style="width:120px; height:120px; border-radius:16px; object-fit:contain; background:var(--dark-3); border:2px solid rgba(201,168,76,0.2); box-shadow:var(--shadow-gold);">
        
        <div style="flex:1; min-width:300px;">
            <div style="display:flex; justify-content:space-between; align-items:flex-start;">
                <div>
                    <h1 style="font-family:'Cormorant Garamond', serif; font-size:2.5rem; color:var(--white); margin-bottom:0.25rem;">{{ $company->name }}</h1>
                    <div style="font-size:1rem; color:var(--white-soft); margin-bottom:0.75rem;">{{ $company->category }}</div>
                    
                    <div style="display:flex; gap:1.5rem; color:var(--white-dim); font-size:0.85rem; margin-bottom:1rem;">
                        @if($company->location)
                        <span><i class="fas fa-map-marker-alt" style="color:var(--gold);"></i> {{ $company->location }}</span>
                        @endif
                        @if($company->year_founded)
                        <span><i class="fas fa-calendar" style="color:var(--gold);"></i> Fundada en {{ $company->year_founded }}</span>
                        @endif
                        @if($company->website)
                        <a href="{{ $company->website }}" target="_blank" style="color:var(--gold);"><i class="fas fa-globe"></i> Sitio Web</a>
                        @endif
                    </div>
                </div>
                
                @if($company->is_featured)
                <span class="tag tag-gold" style="font-size:0.85rem; padding:6px 16px;"><i class="fas fa-star"></i> Empresa Destacada</span>
                @endif
            </div>
            
            <div style="display:flex; gap:1rem; margin-top:1rem;">
                @if(auth()->user()->isInvestor())
                <button type="button" class="btn btn-gold btn-lg" onclick="openContactModal({{ $company->id }}, '{{ addslashes($company->name) }}', '{{ $company->contact_phone }}', '{{ $company->contact_email }}')">
                    <i class="fas fa-handshake"></i> Contactar Emprendedor
                </button>
                <button type="button" class="btn btn-outline-gold btn-lg">
                    Enviar Propuesta
                </button>
                @elseif(auth()->user()->id === $company->user_id)
                <a href="{{ route('entrepreneur.companies.edit', $company) }}" class="btn btn-dark btn-lg">
                    <i class="fas fa-pen"></i> Editar Empresa
                </a>
                @endif
            </div>
        </div>
    </div>
    
    {{-- Tabs Navigation --}}
    <div class="tabs" style="padding:0 2.5rem; background:var(--dark-2);">
        <button type="button" class="tab-btn active" data-target="#tab-resumen">Resumen</button>
        @if($company->products->count() > 0)
        <button type="button" class="tab-btn" data-target="#tab-productos">Producto / Servicio</button>
        @endif
        @if($company->business_plan)
        <button type="button" class="tab-btn" data-target="#tab-plan">Plan de Negocio</button>
        @endif
        <button type="button" class="tab-btn" data-target="#tab-financiera">Información Financiera</button>
    </div>
    
    {{-- Tabs Content --}}
    <div style="padding:2.5rem;">
        
        {{-- TAB 1: Resumen --}}
        <div class="tab-pane active" id="tab-resumen">
            <h3 style="font-family:'Cormorant Garamond', serif; font-size:1.4rem; color:var(--white); margin-bottom:1rem;">Descripción del Negocio</h3>
            <p style="color:var(--white-soft); font-size:0.95rem; line-height:1.8; margin-bottom:2rem; white-space:pre-line;">{{ $company->description ?: 'No se proporcionó una descripción.' }}</p>
            
            @if($company->target_audience)
            <h3 style="font-family:'Cormorant Garamond', serif; font-size:1.4rem; color:var(--white); margin-bottom:1rem;">Público Objetivo</h3>
            <p style="color:var(--white-soft); font-size:0.95rem; line-height:1.8; margin-bottom:2rem;">{{ $company->target_audience }}</p>
            @endif
            
            <div style="background:var(--dark-2); border:1px solid rgba(201,168,76,0.1); border-radius:var(--radius-lg); padding:2rem; margin-top:3rem;">
                <h3 style="font-family:'Cormorant Garamond', serif; font-size:1.4rem; color:var(--gold); margin-bottom:1.5rem; text-align:center;">Resumen de Inversión</h3>
                
                <div class="grid-4" style="text-align:center;">
                    <div>
                        <div style="font-size:0.75rem; color:var(--white-dim); text-transform:uppercase; letter-spacing:0.1em; margin-bottom:0.5rem;">Tipo de Venta</div>
                        <div style="font-size:1.1rem; color:var(--white-soft); font-weight:600;">{{ $company->sale_type === 'individual' ? 'Acciones Individuales' : 'Porcentaje Completo' }}</div>
                    </div>
                    <div>
                        <div style="font-size:0.75rem; color:var(--white-dim); text-transform:uppercase; letter-spacing:0.1em; margin-bottom:0.5rem;">Porcentaje Disponible</div>
                        <div style="font-size:1.5rem; color:var(--gold); font-weight:700;">{{ $company->percentage_available }}%</div>
                    </div>
                    <div>
                        <div style="font-size:0.75rem; color:var(--white-dim); text-transform:uppercase; letter-spacing:0.1em; margin-bottom:0.5rem;">Valor de la Empresa</div>
                        <div style="font-size:1.2rem; color:var(--white); font-weight:600;">{{ $company->formatted_value }}</div>
                    </div>
                    <div>
                        <div style="font-size:0.75rem; color:var(--white-dim); text-transform:uppercase; letter-spacing:0.1em; margin-bottom:0.5rem;">Mínimo de Inversión</div>
                        <div style="font-size:1.2rem; color:var(--white); font-weight:600;">{{ $company->minimum_investment ? 'RD$'.number_format($company->minimum_investment,0) : 'No especificado' }}</div>
                    </div>
                </div>
            </div>
        </div>
        
        {{-- TAB 2: Productos --}}
        @if($company->products->count() > 0)
        <div class="tab-pane" id="tab-productos">
            <div class="grid-2">
                @foreach($company->products as $product)
                <div style="background:var(--dark-2); border:1px solid rgba(255,255,255,0.05); border-radius:var(--radius); padding:1.5rem;">
                    @if($product->image)
                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" style="width:100%; height:200px; object-fit:cover; border-radius:var(--radius-sm); margin-bottom:1rem;">
                    @endif
                    <h4 style="font-size:1.2rem; color:var(--white); margin-bottom:0.5rem;">{{ $product->name }}</h4>
                    <p style="color:var(--white-soft); font-size:0.9rem; margin-bottom:1rem;">{{ $product->description }}</p>
                    @if($product->target_audience)
                    <div style="font-size:0.8rem; color:var(--gold);"><i class="fas fa-users"></i> Público: {{ $product->target_audience }}</div>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
        @endif
        
        {{-- TAB 3: Plan de Negocio --}}
        @if($company->business_plan)
        <div class="tab-pane" id="tab-plan">
            <div style="background:var(--dark-2); border:1px solid rgba(201,168,76,0.1); border-radius:var(--radius); padding:2rem;">
                <div style="font-size:0.95rem; line-height:1.8; color:var(--white-soft); white-space:pre-line;">
                    {{ $company->business_plan }}
                </div>
            </div>
        </div>
        @endif
        
        {{-- TAB 4: Info Financiera --}}
        <div class="tab-pane" id="tab-financiera">
            <div class="grid-2">
                <div style="background:var(--dark-2); border-left:3px solid var(--gold); border-radius:var(--radius); padding:2rem;">
                    <h4 style="font-family:'Cormorant Garamond', serif; font-size:1.3rem; color:var(--white); margin-bottom:1.5rem;">Estructura de Capital</h4>
                    
                    <div style="display:flex; justify-content:space-between; margin-bottom:1rem; padding-bottom:1rem; border-bottom:1px solid rgba(255,255,255,0.05);">
                        <span style="color:var(--white-dim);">Valoración Total</span>
                        <span style="color:var(--white); font-weight:600;">{{ $company->formatted_value }}</span>
                    </div>
                    <div style="display:flex; justify-content:space-between; margin-bottom:1rem; padding-bottom:1rem; border-bottom:1px solid rgba(255,255,255,0.05);">
                        <span style="color:var(--white-dim);">Porcentaje en Oferta</span>
                        <span style="color:var(--gold); font-weight:700; font-size:1.2rem;">{{ $company->percentage_available }}%</span>
                    </div>
                    
                    @if($company->sale_type === 'individual')
                    <div style="display:flex; justify-content:space-between; margin-bottom:1rem; padding-bottom:1rem; border-bottom:1px solid rgba(255,255,255,0.05);">
                        <span style="color:var(--white-dim);">Acciones Totales Ofertadas</span>
                        <span style="color:var(--white); font-weight:600;">{{ $company->total_shares ?: 'N/A' }}</span>
                    </div>
                    <div style="display:flex; justify-content:space-between;">
                        <span style="color:var(--white-dim);">Precio por Acción</span>
                        <span style="color:var(--white); font-weight:600;">{{ $company->formatted_price }}</span>
                    </div>
                    @else
                    <div style="display:flex; justify-content:space-between;">
                        <span style="color:var(--white-dim);">Valor de la Inversión Solicitada</span>
                        <span style="color:var(--white); font-weight:600;">RD${{ number_format($company->company_value * ($company->percentage_available / 100), 0) }}</span>
                    </div>
                    @endif
                </div>
                
                <div>
                    {{-- Future charts or additional financial data can go here --}}
                    <div class="empty-state" style="padding:2rem;">
                        <div class="empty-state-icon"><i class="fas fa-chart-line"></i></div>
                        <div style="color:var(--white-dim); font-size:0.9rem;">El emprendedor compartirá proyecciones financieras detalladas durante el proceso de negociación.</div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>
@endsection
