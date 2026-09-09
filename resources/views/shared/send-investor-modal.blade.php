{{-- Send to Investor Modal --}}
<div class="modal-overlay" id="sendInvestorModal">
    <div class="modal modal-sm">
        <div class="modal-header">
            <h3 class="modal-title">Enviar a Inversionista</h3>
            <button class="modal-close" data-dismiss="modal"><i class="fas fa-times"></i></button>
        </div>
        
        <div class="modal-body">
            <form action="#" method="POST" id="sendInvestorForm">
                @csrf
                <p style="color:var(--white-soft); font-size:0.9rem; margin-bottom:1.5rem;">
                    Enviar <strong style="color:var(--gold);" id="sendCompanyName">Empresa</strong> a un inversionista para revisión.
                </p>
                
                <div class="form-group">
                    <label class="form-label" for="investor_id">Seleccionar Inversionista</label>
                    <select class="form-control" name="investor_id" id="investor_id" required>
                        <option value="">-- Seleccione Inversionista --</option>
                        @php
                            // In a real scenario, this might be loaded via AJAX for performance, 
                            // but for this implementation we can pass it to the view or load it here if needed.
                            // Assuming it's passed or available, if not, this will need a data-fetch approach.
                            $allInvestors = \App\Models\User::where('role', 'investor')->get();
                        @endphp
                        @foreach($allInvestors as $inv)
                            <option value="{{ $inv->id }}">{{ $inv->name }} ({{ $inv->city ?? 'N/A' }})</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="form-group">
                    <label class="form-label" for="message">Mensaje Opcional</label>
                    <textarea class="form-control" name="message" id="message" rows="3" placeholder="Ej: Hola, creo que mi empresa encaja perfectamente con su perfil de inversión..."></textarea>
                </div>
                
                <div style="display:flex; justify-content:flex-end; gap:1rem; margin-top:2rem;">
                    <button type="button" class="btn btn-dark" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-gold" id="btnSubmitSend">
                        <i class="fas fa-paper-plane"></i> Enviar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

