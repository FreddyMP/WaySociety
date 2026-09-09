$(document).ready(function() {
    // ─── Sidebar Toggle (Mobile) ─────────────────────────────
    $('#sidebarToggle').click(function() {
        $('#sidebar').toggleClass('open');
    });

    $(document).click(function(event) {
        if (!$(event.target).closest('#sidebar, #sidebarToggle').length) {
            $('#sidebar').removeClass('open');
        }
    });

    // ─── Global Modals ────────────────────────────────────────
    
    // Setup close buttons
    $('.modal-close, [data-dismiss="modal"]').click(function() {
        $(this).closest('.modal-overlay').removeClass('active');
        $('body').css('overflow', '');
    });

    // Close on overlay click
    $('.modal-overlay').click(function(e) {
        if (e.target === this) {
            $(this).removeClass('active');
            $('body').css('overflow', '');
        }
    });

    // Tabs logic inside modals or generic
    $('.tab-btn').click(function() {
        const target = $(this).data('target');
        const parent = $(this).closest('.modal, .card');
        
        parent.find('.tab-btn').removeClass('active');
        $(this).addClass('active');
        
        parent.find('.tab-pane').removeClass('active');
        $(target).addClass('active');
    });

    // ─── Contact Modal Logic ──────────────────────────────────
    window.openContactModal = function(companyId, companyName, phone, email) {
        $('#contactCompanyName').text(companyName);
        $('#contactPhoneData').val(phone);
        $('#contactEmailData').val(email);
        
        // Reset to WhatsApp by default
        $('.contact-method-btn').removeClass('active');
        $('.contact-method-btn.whatsapp').addClass('active');
        
        $('#waPhone').text(phone);
        $('#waForm').show();
        $('#phoneInfo, #emailInfo').hide();
        
        $('#contactModal').addClass('active');
        $('body').css('overflow', 'hidden');
    };

    $('.contact-method-btn').click(function() {
        $('.contact-method-btn').removeClass('active');
        $(this).addClass('active');
        
        const method = $(this).data('method');
        $('#waForm, #phoneInfo, #emailInfo').hide();
        
        if (method === 'whatsapp') {
            $('#waForm').show();
        } else if (method === 'phone') {
            $('#phoneInfo').show();
            $('#phoneDisplay').text($('#contactPhoneData').val());
            $('#phoneCallBtn').attr('href', 'tel:' + $('#contactPhoneData').val());
        } else if (method === 'email') {
            $('#emailInfo').show();
            $('#emailDisplay').text($('#contactEmailData').val());
            $('#emailSendBtn').attr('href', 'mailto:' + $('#contactEmailData').val());
        }
    });

    $('#openWhatsAppBtn').click(function() {
        const phone = $('#contactPhoneData').val().replace(/\D/g, '');
        const text = encodeURIComponent($('#waMessage').val());
        const url = `https://web.whatsapp.com/send/?phone=${phone}&text=${text}&type=phone_number&app_absent=0`;
        window.open(url, '_blank');
    });

    // ─── Send to Investor Modal ───────────────────────────────
    window.openSendInvestorModal = function(companyId, companyName) {
        $('#sendCompanyName').text(companyName);
        $('#sendInvestorForm').attr('action', '/entrepreneur/companies/' + companyId + '/send');
        $('#sendInvestorModal').addClass('active');
        $('body').css('overflow', 'hidden');
    };

    $(document).on('click', '.btn-send-company', function() {
        const companyId = $(this).data('company');
        const companyName = $(this).data('name');
        window.openSendInvestorModal(companyId, companyName);
    });

    $(document).on('submit', '#sendInvestorForm', function(e) {
        const action = $(this).attr('action');
        if (!action || action === '#' || action === '') {
            e.preventDefault();
            return false;
        }
        $('#btnSubmitSend').html('<span class="spinner"></span> Enviando...').prop('disabled', true);
    });
    
    // ─── Notifications Logic ──────────────────────────────────
    function fetchUnreadCount() {
        if (!$('#sidebarNotifBadge').length) return;
        
        $.get('/notifications/unread-count', function(data) {
            if (data.count > 0) {
                $('#sidebarNotifBadge, #navbarNotifBadge').text(data.count).removeClass('hidden');
            } else {
                $('#sidebarNotifBadge, #navbarNotifBadge').addClass('hidden');
            }
        });
    }
    
    // Check unread count on load if authenticated
    if ($('meta[name="csrf-token"]').length) {
        fetchUnreadCount();
        // Polling every 60s (optional)
        // setInterval(fetchUnreadCount, 60000);
    }
});
