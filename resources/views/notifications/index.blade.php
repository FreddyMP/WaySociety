@extends('layouts.app')
@section('title', 'Notificaciones')
@section('page-title', 'Centro de Notificaciones')
@section('page-subtitle', 'Mantente al tanto de la actividad en tu cuenta')

@section('content')

<div class="card" style="max-width:800px; padding:0; overflow:hidden;">
    @if($notifications->isEmpty())
    <div class="empty-state" style="padding:4rem 2rem;">
        <div class="empty-state-icon"><i class="far fa-bell-slash"></i></div>
        <div class="empty-state-title">No tienes notificaciones</div>
        <p>Cuando haya actividad relevante en tu cuenta, la verás aquí.</p>
    </div>
    @else
    <div style="display:flex; flex-direction:column;">
        @foreach($notifications as $notification)
        <div class="notif-item {{ is_null($notification->read_at) ? 'unread' : '' }}" style="padding:1.25rem 1.5rem; border-bottom:1px solid rgba(255,255,255,0.05); border-radius:0;">
            <div class="notif-icon-wrap" style="background:var(--dark-3); border:1px solid rgba(201,168,76,0.2);">
                @if($notification->type === 'company_invitation')
                    <i class="fas fa-handshake"></i>
                @elseif($notification->type === 'new_investment')
                    <i class="fas fa-coins"></i>
                @else
                    <i class="fas fa-bell"></i>
                @endif
            </div>
            <div style="flex:1;">
                <div class="notif-title">{{ $notification->title }}</div>
                <div class="notif-body">{{ $notification->body }}</div>
                <div class="notif-time">{{ $notification->created_at->diffForHumans() }}</div>
                
                @if($notification->type === 'company_invitation' && isset($notification->data['company_id']))
                    <div style="margin-top:0.75rem;">
                        <a href="{{ route('companies.show', $notification->data['company_id']) }}" class="btn btn-outline-gold btn-sm" style="padding:0.3rem 0.75rem; font-size:0.75rem;">
                            Ver Propuesta
                        </a>
                    </div>
                @endif
            </div>
            @if(is_null($notification->read_at))
                <div class="notif-dot"></div>
            @endif
        </div>
        @endforeach
    </div>
    
    <div style="padding:1rem 1.5rem;">
        {{ $notifications->links('vendor.pagination.custom') }}
    </div>
    @endif
</div>

@push('scripts')
<script>
$(document).ready(function() {
    // Optionally mark notifications as read dynamically if needed,
    // though the controller marks them as read when viewing the index page.
    $('#sidebarNotifBadge, #navbarNotifBadge').addClass('hidden').text('0');
});
</script>
@endpush
@endsection
