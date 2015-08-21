
// Saving OAuth credentials
jQuery(document).ready(function() {
    jQuery('#oauth-save-button').on('click', function(e) {
        e.preventDefault();
        var $btn = jQuery('#oauth-save-button').button('loading');

        jQuery.ajax({
            type: 'POST',
            url: '../wp-content/plugins/hashtag-wizard/functions/submit.php',
            data: jQuery('#oauth_settings_form').serialize()
        })
        .done(function() {
            $btn.button('Saved!').delay(1000).button('reset');
        });
    });
});
