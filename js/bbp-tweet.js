// jQuery = jQuery; // Fixing for wardpress



jQuery(document).ready(function() {
    jQuery(".dropdown-menu li a").click(function(){
        var selText = jQuery(this).text();
        jQuery(this).parents('.btn-group').find('.dropdown-toggle').html(selText+' <span class="caret"></span>');
    });
});


jQuery(document).ready(function() {
    jQuery('.selectpicker').selectpicker({
        // style: 'btn-info',
        // size: 4
    });
});


jQuery(document).ready(function() {
    jQuery('.num-input').keypress(function(e) {
        var a = [];
        var k = e.which;

        for (i = 48; i < 58; i++) {
            a.push(i);
        }

        if (!(a.indexOf(k)>=0)) {
            e.preventDefault();
        }
    });
});

/*
// Saving OAuth credentials
jQuery(document).ready(function() {
    jQuery('#oauth_save_button').on('click', function(e) {
        e.preventDefault();
        var $btn = jQuery('#oauth_save_button').button('loading');

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
*/
