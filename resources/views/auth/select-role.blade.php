@extends('layouts.guest')
@section('title', 'Selecciona tu Perfil')
@section('meta_description', 'Elige entre Emprendedor o Inversionista en WaySociety.')

@section('content')
<div class="auth-card" style="max-width:540px;">
    <div class="auth-card-header">
        <span class="auth-logo">WaySociety</span>
        <h2 style="font-size:1.6rem;color:var(--white);margin-bottom:0.25rem;">¿Cuál es tu perfil?</h2>
        <p style="font-size:0.85rem;color:var(--white-dim);">Selecciona el tipo que mejor te describe</p>
    </div>

    <form action="{{ route('register.role.store') }}" method="POST" id="roleForm">
        @csrf
        <div class="role-cards">
            <label class="role-card" id="cardEntrepreneur" for="roleEntrepreneur">
                <input type="radio" name="role" id="roleEntrepreneur" value="entrepreneur"
                       {{ old('role') === 'entrepreneur' ? 'checked' : '' }}>
                <div class="role-check"><i class="fas fa-check" style="font-size:0.6rem;"></i></div>
                <div class="role-icon">🚀</div>
                <div class="role-card-title">Soy Emprendedor</div>
                <div class="role-card-desc">
                    Registra tu empresa, presenta tu proyecto y conecta con inversionistas interesados en tu negocio.
                </div>
            </label>

            <label class="role-card" id="cardInvestor" for="roleInvestor">
                <input type="radio" name="role" id="roleInvestor" value="investor"
                       {{ old('role') === 'investor' ? 'checked' : '' }}>
                <div class="role-check"><i class="fas fa-check" style="font-size:0.6rem;"></i></div>
                <div class="role-icon">📈</div>
                <div class="role-card-title">Soy Inversionista</div>
                <div class="role-card-desc">
                    Descubre oportunidades de inversión, conecta con emprendedores y haz crecer tu portafolio.
                </div>
            </label>
        </div>
        @error('role')<div class="form-error" style="margin-bottom:1rem;">{{ $message }}</div>@enderror

        <button type="submit" class="btn btn-gold btn-full btn-lg" id="roleBtn" disabled>
            <i class="fas fa-arrow-right"></i> Continuar
        </button>
    </form>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    function updateSelection() {
        $('.role-card').removeClass('selected');
        $('input[name="role"]:checked').closest('.role-card').addClass('selected');
        $('#roleBtn').prop('disabled', !$('input[name="role"]').is(':checked'));
    }
    $('input[name="role"]').on('change', updateSelection);
    updateSelection();
    $('#roleForm').on('submit', function() {
        $('#roleBtn').html('<span class="spinner"></span> Configurando...').prop('disabled', true);
    });
});
</script>
@endpush
@endsection
