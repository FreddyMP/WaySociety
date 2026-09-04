@extends('layouts.app')
@section('title', 'Nueva Empresa')
@section('page-title', 'Registrar Empresa')
@section('page-subtitle', 'Completa los 4 pasos para registrar tu empresa')

@section('content')

{{-- Wizard Steps --}}
<div class="wizard-steps" id="wizardSteps">
    <div class="wizard-step active" data-step="1" id="step-indicator-1">
        <div class="wizard-step-num">1</div>
        <div class="wizard-step-info">
            <div class="wizard-step-label">Paso 1</div>
            <div class="wizard-step-title">Información Básica</div>
        </div>
    </div>
    <div class="wizard-step-line"></div>
    <div class="wizard-step" data-step="2" id="step-indicator-2">
        <div class="wizard-step-num">2</div>
        <div class="wizard-step-info">
            <div class="wizard-step-label">Paso 2</div>
            <div class="wizard-step-title">Descripción & Productos</div>
        </div>
    </div>
    <div class="wizard-step-line"></div>
    <div class="wizard-step" data-step="3" id="step-indicator-3">
        <div class="wizard-step-num">3</div>
        <div class="wizard-step-info">
            <div class="wizard-step-label">Paso 3</div>
            <div class="wizard-step-title">Plan de Negocio</div>
        </div>
    </div>
    <div class="wizard-step-line"></div>
    <div class="wizard-step" data-step="4" id="step-indicator-4">
        <div class="wizard-step-num">4</div>
        <div class="wizard-step-info">
            <div class="wizard-step-label">Paso 4</div>
            <div class="wizard-step-title">Inversión & Acciones</div>
        </div>
    </div>
</div>

<form action="{{ route('entrepreneur.companies.store') }}" method="POST"
      enctype="multipart/form-data" id="companyWizardForm">
@csrf

{{-- ─── STEP 1: Información Básica ────────────────────────── --}}
<div class="wizard-pane active card" id="pane-1">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-info-circle" style="color:var(--gold);"></i> Información Básica</h3>
        <span class="tag tag-gold">Paso 1 de 4</span>
    </div>

    <div class="form-row">
        <div class="form-group">
            <label class="form-label" for="name">Nombre de la Empresa *</label>
            <input type="text" class="form-control" id="name" name="name"
                   value="{{ old('name') }}" placeholder="Ej: EcoLife RD" required>
        </div>
        <div class="form-group">
            <label class="form-label" for="category">Categoría / Industria</label>
            <select class="form-control" id="category" name="category">
                <option value="">Seleccionar categoría</option>
                <option {{ old('category') === 'Tecnología' ? 'selected' : '' }}>Tecnología</option>
                <option {{ old('category') === 'Salud y Bienestar' ? 'selected' : '' }}>Salud y Bienestar</option>
                <option {{ old('category') === 'Alimentación' ? 'selected' : '' }}>Alimentación</option>
                <option {{ old('category') === 'Educación' ? 'selected' : '' }}>Educación</option>
                <option {{ old('category') === 'Finanzas' ? 'selected' : '' }}>Finanzas</option>
                <option {{ old('category') === 'Energía Renovable' ? 'selected' : '' }}>Energía Renovable</option>
                <option {{ old('category') === 'Moda y Textil' ? 'selected' : '' }}>Moda y Textil</option>
                <option {{ old('category') === 'Turismo' ? 'selected' : '' }}>Turismo</option>
                <option {{ old('category') === 'Logística' ? 'selected' : '' }}>Logística</option>
                <option {{ old('category') === 'Agricultura' ? 'selected' : '' }}>Agricultura</option>
                <option {{ old('category') === 'Construcción' ? 'selected' : '' }}>Construcción</option>
                <option {{ old('category') === 'Comercio' ? 'selected' : '' }}>Comercio</option>
                <option {{ old('category') === 'Servicios' ? 'selected' : '' }}>Servicios</option>
                <option {{ old('category') === 'Entretenimiento' ? 'selected' : '' }}>Entretenimiento</option>
                <option value="Otro" {{ old('category') === 'Otro' ? 'selected' : '' }}>Otro</option>
            </select>
        </div>
    </div>

    <div class="form-row-3">
        <div class="form-group">
            <label class="form-label" for="location">Ubicación</label>
            <div class="input-group">
                <span class="input-prefix"><i class="fas fa-map-marker-alt"></i></span>
                <input type="text" class="form-control" id="location" name="location"
                       value="{{ old('location') }}" placeholder="Santo Domingo, RD">
            </div>
        </div>
        <div class="form-group">
            <label class="form-label" for="year_founded">Año de Fundación</label>
            <div class="input-group">
                <span class="input-prefix"><i class="fas fa-calendar"></i></span>
                <input type="number" class="form-control" id="year_founded" name="year_founded"
                       value="{{ old('year_founded') }}" placeholder="{{ date('Y') }}" min="1900" max="{{ date('Y') }}">
            </div>
        </div>
        <div class="form-group">
            <label class="form-label" for="website">Sitio Web</label>
            <div class="input-group">
                <span class="input-prefix"><i class="fas fa-globe"></i></span>
                <input type="url" class="form-control" id="website" name="website"
                       value="{{ old('website') }}" placeholder="https://tuempresa.com">
            </div>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group">
            <label class="form-label" for="contact_email">Correo de Contacto *</label>
            <div class="input-group">
                <span class="input-prefix"><i class="fas fa-envelope"></i></span>
                <input type="email" class="form-control" id="contact_email" name="contact_email"
                       value="{{ old('contact_email', auth()->user()->email) }}" placeholder="contacto@empresa.com">
            </div>
        </div>
        <div class="form-group">
            <label class="form-label" for="contact_phone">Teléfono de Contacto *</label>
            <div class="input-group">
                <span class="input-prefix"><i class="fas fa-phone"></i></span>
                <input type="tel" class="form-control" id="contact_phone" name="contact_phone"
                       value="{{ old('contact_phone', auth()->user()->phone) }}" placeholder="809-000-0000">
            </div>
        </div>
    </div>

    {{-- Images --}}
    <div class="form-row">
        <div class="form-group">
            <label class="form-label">Logo de la Empresa</label>
            <div class="upload-area" id="logoUploadArea">
                <input type="file" name="logo" id="logo" accept="image/*">
                <div class="upload-icon"><i class="fas fa-image"></i></div>
                <div class="upload-text">Haz clic o arrastra el logo<br><span style="font-size:0.72rem;color:var(--white-dim);">PNG, JPG — máx. 2MB</span></div>
                <img class="upload-preview" id="logoPreview" alt="Logo preview">
            </div>
        </div>
        <div class="form-group">
            <label class="form-label">Imagen de Portada</label>
            <div class="upload-area" id="coverUploadArea">
                <input type="file" name="cover_image" id="cover_image" accept="image/*">
                <div class="upload-icon"><i class="fas fa-panorama"></i></div>
                <div class="upload-text">Haz clic o arrastra la portada<br><span style="font-size:0.72rem;color:var(--white-dim);">PNG, JPG — máx. 4MB</span></div>
                <img class="upload-preview" id="coverPreview" alt="Cover preview">
            </div>
        </div>
    </div>

    <div style="display:flex;justify-content:flex-end;margin-top:1.5rem;">
        <button type="button" class="btn btn-gold btn-lg" id="nextStep1">
            Siguiente <i class="fas fa-arrow-right"></i>
        </button>
    </div>
</div>

{{-- ─── STEP 2: Descripción & Productos ────────────────────── --}}
<div class="wizard-pane card" id="pane-2">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-layer-group" style="color:var(--gold);"></i> Descripción & Productos</h3>
        <span class="tag tag-gold">Paso 2 de 4</span>
    </div>

    <div class="form-group">
        <label class="form-label" for="description">Descripción del Negocio</label>
        <textarea class="form-control" id="description" name="description"
                  rows="4" placeholder="Describe en qué consiste tu empresa, qué problema resuelve...">{{ old('description') }}</textarea>
        <div class="form-hint">Una buena descripción atrae más inversionistas.</div>
    </div>

    <div class="form-group">
        <label class="form-label" for="target_audience">Público Objetivo de la Empresa</label>
        <textarea class="form-control" id="target_audience" name="target_audience"
                  rows="3" placeholder="¿A quién va dirigido tu negocio? Describe tu cliente ideal...">{{ old('target_audience') }}</textarea>
    </div>

    {{-- Products Section --}}
    <div style="border-top:1px solid rgba(201,168,76,0.1);margin:1.5rem 0;padding-top:1.5rem;">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1rem;">
            <h4 style="font-family:'Cormorant Garamond',serif;color:var(--white);">
                <i class="fas fa-boxes" style="color:var(--gold);margin-right:0.5rem;"></i>
                Productos / Servicios
            </h4>
            <button type="button" class="btn btn-outline-gold btn-sm" id="addProduct">
                <i class="fas fa-plus"></i> Agregar Producto
            </button>
        </div>
        <div id="productsContainer">
            {{-- Products will be added dynamically --}}
            <div class="empty-state" id="noProductsMsg" style="padding:2rem;">
                <div style="font-size:2rem;opacity:0.3;margin-bottom:0.5rem;">📦</div>
                <div style="font-size:0.9rem;color:var(--white-dim);">
                    Agrega los productos o servicios que ofrece tu empresa (opcional)
                </div>
            </div>
        </div>
    </div>

    <div style="display:flex;justify-content:space-between;margin-top:1.5rem;">
        <button type="button" class="btn btn-dark btn-lg" id="prevStep2">
            <i class="fas fa-arrow-left"></i> Anterior
        </button>
        <button type="button" class="btn btn-gold btn-lg" id="nextStep2">
            Siguiente <i class="fas fa-arrow-right"></i>
        </button>
    </div>
</div>

{{-- ─── STEP 3: Plan de Negocio ─────────────────────────────── --}}
<div class="wizard-pane card" id="pane-3">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-clipboard-list" style="color:var(--gold);"></i> Plan de Negocio</h3>
        <span class="tag tag-gold">Paso 3 de 4</span>
    </div>

    <div class="alert alert-gold">
        <i class="fas fa-lightbulb"></i>
        Un plan de negocio sólido aumenta significativamente la confianza de los inversionistas.
    </div>

    <div class="form-group">
        <label class="form-label" for="business_plan">Plan de Negocio</label>
        <textarea class="form-control" id="business_plan" name="business_plan"
                  rows="14" style="min-height:350px;"
                  placeholder="Describe tu plan de negocio:

• Modelo de negocio (¿cómo generas ingresos?)
• Mercado objetivo y tamaño del mercado
• Propuesta de valor única
• Estrategia de ventas y marketing
• Proyecciones financieras
• Equipo de trabajo
• Competencia y diferenciadores
• Riesgos y cómo mitigarlos
• Uso de los fondos de inversión
• Plan de retorno para inversionistas">{{ old('business_plan') }}</textarea>
        <div class="form-hint">
            <span id="businessPlanCount">0</span> caracteres escritos
        </div>
    </div>

    <div style="display:flex;justify-content:space-between;margin-top:1.5rem;">
        <button type="button" class="btn btn-dark btn-lg" id="prevStep3">
            <i class="fas fa-arrow-left"></i> Anterior
        </button>
        <button type="button" class="btn btn-gold btn-lg" id="nextStep3">
            Siguiente <i class="fas fa-arrow-right"></i>
        </button>
    </div>
</div>

{{-- ─── STEP 4: Inversión & Acciones ───────────────────────── --}}
<div class="wizard-pane card" id="pane-4">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-chart-pie" style="color:var(--gold);"></i> Inversión & Acciones</h3>
        <span class="tag tag-gold">Paso 4 de 4</span>
    </div>

    {{-- Sale Type --}}
    <div class="form-group">
        <label class="form-label">Tipo de Venta de Acciones *</label>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-top:0.5rem;">
            <label class="role-card" id="cardIndividual" for="saleIndividual" style="padding:1.25rem;">
                <input type="radio" name="sale_type" id="saleIndividual" value="individual"
                       {{ old('sale_type', 'individual') === 'individual' ? 'checked' : '' }}>
                <div class="role-check"><i class="fas fa-check" style="font-size:0.6rem;"></i></div>
                <div style="font-size:1.8rem;margin-bottom:0.5rem;">🧩</div>
                <div class="role-card-title" style="font-size:1rem;">Acciones Individuales</div>
                <div class="role-card-desc" style="font-size:0.78rem;">Múltiples inversionistas pueden comprar acciones independientes</div>
            </label>
            <label class="role-card" id="cardComplete" for="saleComplete" style="padding:1.25rem;">
                <input type="radio" name="sale_type" id="saleComplete" value="complete"
                       {{ old('sale_type') === 'complete' ? 'checked' : '' }}>
                <div class="role-check"><i class="fas fa-check" style="font-size:0.6rem;"></i></div>
                <div style="font-size:1.8rem;margin-bottom:0.5rem;">🎯</div>
                <div class="role-card-title" style="font-size:1rem;">Porcentaje Completo</div>
                <div class="role-card-desc" style="font-size:0.78rem;">Un único inversionista adquiere todo el porcentaje disponible</div>
            </label>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group">
            <label class="form-label" for="percentage_available">% Disponible para Inversión *</label>
            <div class="input-group">
                <span class="input-prefix"><i class="fas fa-percent"></i></span>
                <input type="number" class="form-control" id="percentage_available"
                       name="percentage_available" value="{{ old('percentage_available', 20) }}"
                       min="1" max="100" step="0.5" required>
            </div>
            <div class="form-hint">Porcentaje de la empresa que estás dispuesto a ceder</div>
        </div>
        <div class="form-group">
            <label class="form-label" for="company_value">Valor Total de la Empresa (RD$)</label>
            <div class="input-group">
                <span class="input-prefix" style="left:0.7rem;font-size:0.75rem;font-weight:700;color:var(--gold);">RD$</span>
                <input type="number" class="form-control" id="company_value" name="company_value"
                       value="{{ old('company_value') }}" min="0" step="1000"
                       placeholder="15,000,000" style="padding-left:3rem;">
            </div>
        </div>
    </div>

    <div class="form-row" id="sharesSection">
        <div class="form-group">
            <label class="form-label" for="price_per_share">Precio por Acción (RD$)</label>
            <div class="input-group">
                <span class="input-prefix" style="left:0.7rem;font-size:0.75rem;font-weight:700;color:var(--gold);">RD$</span>
                <input type="number" class="form-control" id="price_per_share" name="price_per_share"
                       value="{{ old('price_per_share') }}" min="0" step="100"
                       placeholder="50,000" style="padding-left:3rem;">
            </div>
        </div>
        <div class="form-group">
            <label class="form-label" for="total_shares">Total de Acciones Disponibles</label>
            <div class="input-group">
                <span class="input-prefix"><i class="fas fa-coins"></i></span>
                <input type="number" class="form-control" id="total_shares" name="total_shares"
                       value="{{ old('total_shares') }}" min="0" step="1" placeholder="300">
            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="form-label" for="minimum_investment">Inversión Mínima (RD$)</label>
        <div class="input-group">
            <span class="input-prefix" style="left:0.7rem;font-size:0.75rem;font-weight:700;color:var(--gold);">RD$</span>
            <input type="number" class="form-control" id="minimum_investment" name="minimum_investment"
                   value="{{ old('minimum_investment') }}" min="0" step="1000"
                   placeholder="200,000" style="padding-left:3rem;">
        </div>
    </div>

    {{-- Investment Summary --}}
    <div class="card card-gold-border" id="investmentSummary" style="background:var(--dark-2);margin-top:0.5rem;">
        <h4 style="font-family:'Cormorant Garamond',serif;color:var(--gold);margin-bottom:1rem;font-size:1.1rem;">
            <i class="fas fa-calculator"></i> Resumen de Inversión
        </h4>
        <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:1rem;text-align:center;">
            <div>
                <div style="font-size:0.65rem;color:var(--white-dim);text-transform:uppercase;letter-spacing:0.08em;margin-bottom:4px;">% Disponible</div>
                <div style="font-size:1.4rem;font-weight:700;color:var(--gold);" id="sumPercent">—</div>
            </div>
            <div>
                <div style="font-size:0.65rem;color:var(--white-dim);text-transform:uppercase;letter-spacing:0.08em;margin-bottom:4px;">Valor a Invertir</div>
                <div style="font-size:1.4rem;font-weight:700;color:var(--white);" id="sumInvestValue">—</div>
            </div>
            <div>
                <div style="font-size:0.65rem;color:var(--white-dim);text-transform:uppercase;letter-spacing:0.08em;margin-bottom:4px;">Tipo de Venta</div>
                <div style="font-size:1rem;font-weight:600;color:var(--white-soft);" id="sumSaleType">—</div>
            </div>
        </div>
    </div>

    <div style="display:flex;justify-content:space-between;margin-top:2rem;gap:1rem;">
        <button type="button" class="btn btn-dark btn-lg" id="prevStep4">
            <i class="fas fa-arrow-left"></i> Anterior
        </button>
        <button type="submit" class="btn btn-gold btn-lg" id="submitWizard">
            <i class="fas fa-save"></i> Guardar Empresa
        </button>
    </div>
</div>

</form>

@push('scripts')
<script src="{{ asset('js/wizard.js') }}"></script>
@endpush
@endsection
