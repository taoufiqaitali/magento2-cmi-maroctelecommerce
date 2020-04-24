require([
    'jquery'
], function ($) {
    'use strict';

    $(document).ready(function(){
		$( "input[data-ui-id='text-groups-cmiecom-fields-apigateway-value']" ).parent().parent().find('td').hide();
		$( "input[data-ui-id='text-groups-cmiecom-fields-apigateway-value']" ).parent().parent().find('td').hide();
		$( "input[data-ui-id='password-groups-cmiecom-fields-passwordapi-value']" ).parent().parent().find('td').hide();
		$("input[data-ui-id='text-groups-cmiecom-fields-apigateway-value']").removeAttr("required");
		$("input[data-ui-id='text-groups-cmiecom-fields-usernameapi-value']").removeAttr("required");
		$("input[data-ui-id='password-groups-cmiecom-fields-passwordapi-value']").removeAttr("required");
		if( $("select[data-ui-id='select-groups-cmiecom-fields-callback-mode-value']").val() == "0"){
			  $( "select[data-ui-id='select-groups-cmiecom-fields-confirmation-mode-value']" ).parent().parent().find('td').show();
			  $( "input[data-ui-id='text-groups-cmiecom-fields-apigateway-value']" ).parent().parent().find('td').hide();
			  $( "input[data-ui-id='text-groups-cmiecom-fields-usernameapi-value']" ).parent().parent().find('td').hide();
				$( "input[data-ui-id='password-groups-cmiecom-fields-passwordapi-value']" ).parent().parent().find('td').hide();
			  $("input[data-ui-id='text-groups-cmiecom-fields-apigateway-value']").removeAttr("required");
			  $("input[data-ui-id='text-groups-cmiecom-fields-usernameapi-value']").removeAttr("required");
			  $("input[data-ui-id='password-groups-cmiecom-fields-passwordapi-value']").removeAttr("required");
		  } else if( $("select[data-ui-id='select-groups-cmiecom-fields-callback-mode-value']").val() == "1") {
			  $( "select[data-ui-id='select-groups-cmiecom-fields-confirmation-mode-value']" ).parent().parent().find('td').hide();
			  $("input[data-ui-id='text-groups-cmiecom-fields-apigateway-value']").prop("required",true);
			  $("input[data-ui-id='text-groups-cmiecom-fields-usernameapi-value']").prop("required",true);
			  $("input[data-ui-id='password-groups-cmiecom-fields-passwordapi-value']").prop("required",true);
			  $( "input[data-ui-id='text-groups-cmiecom-fields-apigateway-value']" ).parent().parent().find('td').show();
			  $( "input[data-ui-id='text-groups-cmiecom-fields-usernameapi-value']" ).parent().parent().find('td').show();
				$( "input[data-ui-id='password-groups-cmiecom-fields-passwordapi-value']" ).parent().parent().find('td').show();
		  }
		$("select[data-ui-id='select-groups-cmiecom-fields-callback-mode-value']").on("change", function() {
		  if( this.value == "0"){
			  $( "select[data-ui-id='select-groups-cmiecom-fields-confirmation-mode-value']" ).parent().parent().find('td').show();
			  $("input[data-ui-id='text-groups-cmiecom-fields-apigateway-value']").removeAttr("required");
			  $("input[data-ui-id='text-groups-cmiecom-fields-usernameapi-value']").removeAttr("required");
			  $("input[data-ui-id='password-groups-cmiecom-fields-passwordapi-value']").removeAttr("required");
			  $("input[data-ui-id='password-groups-cmiecom-fields-passwordapi-value']").removeAttr("required");
			  $( "input[data-ui-id='text-groups-cmiecom-fields-apigateway-value']" ).parent().parent().find('td').hide();
			  $( "input[data-ui-id='text-groups-cmiecom-fields-usernameapi-value']" ).parent().parent().find('td').hide();
				$( "input[data-ui-id='password-groups-cmiecom-fields-passwordapi-value']" ).parent().parent().find('td').hide();
		  } else if( this.value == "1") {
			  $( "select[data-ui-id='select-groups-cmiecom-fields-confirmation-mode-value']" ).parent().parent().find('td').hide();
			  $("input[data-ui-id='text-groups-cmiecom-fields-apigateway-value']").prop("required",true);
			  $("input[data-ui-id='text-groups-cmiecom-fields-usernameapi-value']").prop("required",true);
			  $("input[data-ui-id='password-groups-cmiecom-fields-passwordapi-value']").prop("required",true);
			  $( "input[data-ui-id='text-groups-cmiecom-fields-apigateway-value']" ).parent().parent().find('td').show();
			  $( "input[data-ui-id='text-groups-cmiecom-fields-usernameapi-value']" ).parent().parent().find('td').show();
				$( "input[data-ui-id='password-groups-cmiecom-fields-passwordapi-value']" ).parent().parent().find('td').show();
		  }
		});
    });

});