@extends('layouts.app')
@section('title', 'Empresas Recibidas')
@section('page-title', 'Empresas Recibidas')
@section('page-subtitle', 'Oportunidades de inversión enviadas directamente a ti')

@section('content')

@if($invitations->isEmpty())
<div class="card">
    <div class="empty-state">
        <div class="empty-state-icon"><i class="fas fa-inbox"></i></div>
        <div class="empty-state-title">No has recibido propuestas</div>
        <p>Los emprendedores pueden enviarte oportunidades de inversión directamente. Aparecerán aquí cuando lo hagan.</p>
    </div>
</div>
@else
<div class="grid-3">
    @foreach($invitations as $invitation)
    <div class="company-card" style="{{ $invitation->status === 'pending' ? 'border-color:var(--gold); box-shadow:0 0 15px rgba(201,168,76,0.1);' : '' }}">
        <div class="company-card-cover" style="height:140px;">
            <img src="{{ $invitation->company->cover_url }}" alt="{{ $invitation->company->name }}" class="company-card-cover-img">
            <div class="company-card-cover-overlay"></div>
            @if($invitation->status === 'pending')
                <span class="company-card-badge" style="background:var(--success); color:white;">Nueva Propuesta</span>
            @endif
        </div>
        <div class="company-card-body">
            <div class="company-card-meta">
                <img src="{{ $invitation->company->logo_url }}" alt="{{ $invitation->company->name }}" class="company-card-logo">
                <div>
                    <div class="company-card-name">{{ $invitation->company->name }}</div>
                    <div class="company-card-category">Enviado por: {{ $invitation->entrepreneur->name }}</div>
                </div>
            </div>
            
            @if($invitation->message)
            <div style="background:var(--dark-2); padding:0.75rem; border-radius:var(--radius-sm); border-left:2px solid var(--gold); margin-bottom:1rem; font-size:0.8rem; font-style:italic; color:var(--white-soft);">
                "{{ $invitation->message }}"
            </div>
            @endif
            
            <div class="company-card-stats" style="margin-bottom:1rem;">
                <div class="company-stat">
                    <div class="company-stat-label">Valor</div>
                    <div class="company-stat-value" style="font-size:0.85rem;">{{ $invitation->company->formatted_value }}</div>
                </div>
                <div class="company-stat text-right">
                    <div class="company-stat-label">% Ofrecido</div>
                    <div class="company-stat-value" style="font-size:0.85rem;">{{ $invitation->company->percentage_available }}%</div>
                </div>
            </div>
            
            <div style="display:flex; gap:0.5rem;">
                <a href="{{ route('companies.show', $invitation->company) }}" class="btn btn-outline-gold btn-sm btn-full" style="justify-content:center;">
                    Ver Empresa
                </a>
            </div>
        </div>
    </div>
    @endforeach
</div>
<div class="mt-4">
    {{ $invitations->links('vendor.pagination.custom') }}
</div>
@endif

@endsection
