$(document).ready(function() {
    let currentStep = 1;
    const maxSteps = 4;

    function showStep(step) {
        $('.wizard-pane').removeClass('active');
        $('#pane-' + step).addClass('active');

        $('.wizard-step').removeClass('active done');
        for (let i = 1; i <= maxSteps; i++) {
            if (i < step) {
                $('#step-indicator-' + i).addClass('done');
            } else if (i === step) {
                $('#step-indicator-' + i).addClass('active');
            }
        }

        // Scroll to top of wizard
        $('html, body').animate({
            scrollTop: $("#wizardSteps").offset().top - 100
        }, 300);
    }

    // Step Validation Functions
    function validateStep1() {
        let valid = true;
        const name = $('#name').val().trim();
        const email = $('#contact_email').val().trim();
        const phone = $('#contact_phone').val().trim();

        if (!name) { alert('El nombre de la empresa es obligatorio.'); valid = false; }
        else if (!email) { alert('El correo de contacto es obligatorio.'); valid = false; }
        else if (!phone) { alert('El teléfono de contacto es obligatorio.'); valid = false; }
        
        return valid;
    }

    // Navigation Events
    $('#nextStep1').click(function() {
        if (validateStep1()) { currentStep = 2; showStep(currentStep); }
    });
    
    $('#prevStep2').click(function() { currentStep = 1; showStep(currentStep); });
    $('#nextStep2').click(function() { currentStep = 3; showStep(currentStep); });
    
    $('#prevStep3').click(function() { currentStep = 2; showStep(currentStep); });
    $('#nextStep3').click(function() { currentStep = 4; showStep(currentStep); });
    
    $('#prevStep4').click(function() { currentStep = 3; showStep(currentStep); });

    // File Upload Previews
    function setupImagePreview(inputId, previewId) {
        $('#' + inputId).on('change', function(e) {
            if (e.target.files && e.target.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#' + previewId).attr('src', e.target.result).show();
                    $('#' + inputId).siblings('.upload-icon, .upload-text').hide();
                }
                reader.readAsDataURL(e.target.files[0]);
            }
        });
    }
    
    setupImagePreview('logo', 'logoPreview');
    setupImagePreview('cover_image', 'coverPreview');

    // Dynamic Products
    let productCount = window.productCount || 0;
    
    $('#addProduct').click(function() {
        $('#noProductsMsg').hide();
        const index = productCount++;
        
        const productHtml = `
            <div class="product-item" id="product-${index}">
                <div class="product-item-header">
                    <span class="product-number">Producto #${index + 1}</span>
                    <button type="button" class="btn btn-danger btn-sm remove-product" data-id="${index}">
                        <i class="fas fa-trash"></i> Eliminar
                    </button>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Nombre del Producto *</label>
                        <input type="text" class="form-control" name="products[${index}][name]" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Público Objetivo</label>
                        <input type="text" class="form-control" name="products[${index}][target_audience]">
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Descripción Breve</label>
                    <textarea class="form-control" name="products[${index}][description]" rows="2"></textarea>
                </div>
            </div>
        `;
        
        $('#productsContainer').append(productHtml);
    });
    
    $(document).on('click', '.remove-product', function() {
        const id = $(this).data('id');
        $('#product-' + id).remove();
        if ($('#productsContainer .product-item').length === 0) {
            $('#noProductsMsg').show();
        }
    });

    // Business Plan Character Count
    $('#business_plan').on('input', function() {
        $('#businessPlanCount').text($(this).val().length);
    });

    // Sale Type Toggle & Summary Calculator
    function updateInvestmentSummary() {
        const saleType = $('input[name="sale_type"]:checked').val();
        const percentage = parseFloat($('#percentage_available').val()) || 0;
        const companyValue = parseFloat($('#company_value').val()) || 0;
        const pricePerShare = parseFloat($('#price_per_share').val()) || 0;
        const totalShares = parseInt($('#total_shares').val()) || 0;
        
        if (saleType === 'complete') {
            $('#sharesSection').hide();
            $('#cardComplete').addClass('selected');
            $('#cardIndividual').removeClass('selected');
            
            // Calculate investment value for complete sale (percentage of company value)
            const investmentValue = companyValue * (percentage / 100);
            
            $('#sumPercent').text(percentage + '%');
            $('#sumSaleType').text('Porcentaje Completo');
            $('#sumInvestValue').text(investmentValue > 0 ? 'RD$ ' + investmentValue.toLocaleString() : '—');
            
        } else {
            $('#sharesSection').show();
            $('#cardIndividual').addClass('selected');
            $('#cardComplete').removeClass('selected');
            
            $('#sumPercent').text(percentage + '%');
            $('#sumSaleType').text('Acciones Individuales');
            $('#sumInvestValue').text(pricePerShare > 0 ? 'RD$ ' + pricePerShare.toLocaleString() + ' /acción' : '—');
        }
    }
    
    $('input[name="sale_type"], #percentage_available, #company_value, #price_per_share').on('change input', updateInvestmentSummary);
    updateInvestmentSummary();

    // Form Submit Loader
    $('#companyWizardForm').on('submit', function() {
        $('#submitWizard').html('<span class="spinner"></span> Guardando...').prop('disabled', true);
    });
});
