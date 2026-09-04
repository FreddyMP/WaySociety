{{-- Contact Entrepreneur Modal --}}
<div class="modal-overlay" id="contactModal">
    <div class="modal modal-sm">
        <div class="modal-header">
            <h3 class="modal-title">Contactar Emprendedor</h3>
            <button class="modal-close" data-dismiss="modal"><i class="fas fa-times"></i></button>
        </div>
        
        <div class="modal-body">
            <div style="text-align:center; margin-bottom:1.5rem;">
                <div style="font-family:'Cormorant Garamond', serif; font-size:1.3rem; color:var(--white);" id="contactCompanyName">Nombre Empresa</div>
                <div style="font-size:0.8rem; color:var(--white-dim);">Selecciona un método de contacto para iniciar la negociación.</div>
            </div>
            
            <div class="contact-methods">
                <div class="contact-method-btn whatsapp active" data-method="whatsapp">
                    <i class="fab fa-whatsapp method-icon"></i>
                    WhatsApp
                </div>
                <div class="contact-method-btn phone" data-method="phone">
                    <i class="fas fa-phone-alt method-icon"></i>
                    Teléfono
                </div>
                <div class="contact-method-btn email" data-method="email">
                    <i class="fas fa-envelope method-icon"></i>
                    Correo
                </div>
            </div>
            
            <input type="hidden" id="contactPhoneData" value="">
            <input type="hidden" id="contactEmailData" value="">
            
            {{-- WhatsApp Form --}}
            <div id="waForm" class="contact-form" style="display:block;">
                <div class="form-group">
                    <label class="form-label">Mensaje Predefinido</label>
                    <textarea id="waMessage" class="form-control" rows="4">Hola, estoy interesado en invertir en su empresa. ¿Podríamos conversar más sobre la oportunidad?</textarea>
                </div>
                <div style="text-align:center; font-size:0.75rem; color:var(--white-dim); margin-bottom:1rem;">
                    Se abrirá WhatsApp Web con el número <span id="waPhone" style="color:var(--white);"></span>
                </div>
                <button type="button" class="btn btn-gold btn-full btn-lg" id="openWhatsAppBtn" style="background:#25D366; color:white; text-shadow:0 1px 2px rgba(0,0,0,0.2);">
                    <i class="fab fa-whatsapp" style="font-size:1.2rem;"></i> Abrir WhatsApp
                </button>
            </div>
            
            {{-- Phone Info --}}
            <div id="phoneInfo" class="contact-form" style="display:none; text-align:center; padding:2rem 0;">
                <div style="font-size:3rem; color:var(--gold); margin-bottom:1rem;"><i class="fas fa-phone-volume"></i></div>
                <div style="font-size:0.9rem; color:var(--white-dim); margin-bottom:0.5rem;">Llama directamente al emprendedor:</div>
                <div id="phoneDisplay" style="font-size:1.5rem; font-weight:700; color:var(--white); margin-bottom:1.5rem;"></div>
                <a href="#" id="phoneCallBtn" class="btn btn-gold btn-full">
                    <i class="fas fa-phone"></i> Llamar Ahora
                </a>
            </div>
            
            {{-- Email Info --}}
            <div id="emailInfo" class="contact-form" style="display:none; text-align:center; padding:2rem 0;">
                <div style="font-size:3rem; color:#6495ED; margin-bottom:1rem;"><i class="fas fa-envelope-open-text"></i></div>
                <div style="font-size:0.9rem; color:var(--white-dim); margin-bottom:0.5rem;">Envía un correo electrónico:</div>
                <div id="emailDisplay" style="font-size:1.2rem; font-weight:600; color:var(--white); margin-bottom:1.5rem;"></div>
                <a href="#" id="emailSendBtn" class="btn btn-full" style="background:#6495ED; color:white;">
                    <i class="fas fa-paper-plane"></i> Redactar Correo
                </a>
            </div>
        </div>
    </div>
</div>
