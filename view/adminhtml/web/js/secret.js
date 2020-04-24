require([
    'jquery'
], function ($) {
    'use strict';

    $(document).ready(function(){
		if (!jQuery("#cmi_toggle_SLKSecretkey").length) {
			jQuery( "input[data-ui-id='password-groups-cmiecom-fields-secretkey-value']" ).attr('id', 'cmi_SLKSecretkey');
			jQuery( "input[data-ui-id='password-groups-cmiecom-fields-secretkey-value']" ).after( '<span toggle="#cmi_SLKSecretkey"  id="cmi_toggle_SLKSecretkey" class="fa fa-fw fa-eye field-icon toggle-password"></span>' );
		}
		if (!jQuery("#cmi_toggle_passwordapi").length) {
			jQuery( "input[data-ui-id='password-groups-cmiecom-fields-passwordapi-value']" ).attr('id', 'cmi_passwordapi');
			jQuery( "input[data-ui-id='password-groups-cmiecom-fields-passwordapi-value']" ).after( '<span toggle="#cmi_passwordapi" id="cmi_toggle_passwordapi" class="fa fa-fw fa-eye field-icon toggle-password"></span>' );
		}
		jQuery(".toggle-password").click(function() {
			jQuery(this).toggleClass("fa-eye fa-eye-slash");
			var input = jQuery(jQuery(this).attr("toggle"));
			if (input.attr("type") == "password") {
				input.attr("type", "text");
			} else {
				input.attr("type", "password");
			}
		});
    });

});