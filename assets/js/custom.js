jQuery(document).ready(function(jQuery) {
    jQuery('#cfe_form').on('submit', function(e) {
        e.preventDefault();
        var form = jQuery(this);

        if (form[0].checkValidity() === false) {
            e.stopPropagation();
            form.addClass('was-validated');
            return;
        }

        jQuery('#cfe_loader').show(); // Show loader
        jQuery('#cfe_submit_btn').prop('disabled', true); // Disable submit button

        var formData = jQuery(this).serialize();
        jQuery.ajax({
            url: ajaxObj.ajaxurl,
            type: 'POST',
            data: {
                action: 'cfe_submit_form',
                data: formData
            },
            success: function(response) {
                jQuery('#cfe_loader').hide(); // Hide loader
                jQuery('#cfe_submit_btn').prop('disabled', false); // Enable submit button
                jQuery('#cfe_response').html('<div class="alert alert-success">' + response + '</div>');
                form[0].reset();
                form.removeClass('was-validated');
            },
            error: function() {
                jQuery('#cfe_loader').hide(); // Hide loader in case of error
                jQuery('#cfe_submit_btn').prop('disabled', false); // Enable submit button
                jQuery('#cfe_response').html('<div class="alert alert-danger">There was an error processing your request.</div>');
            }
        });
    });
});
