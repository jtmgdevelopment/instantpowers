$( document ).ready(function(e) {

	$( '#print-all-copies' ).click( function( event ){
		
		var c,  obj = $( this ), data = obj.data(), options;
		
		options = {
			url 	: '/insurance/reports/print_power_copies',
			data	: {
				mek	: data.mek,
				report_id : data.report_id
			},
			type	: 'POST',
			success	: successCallback,
			error	: errorCallback
		};
		
		c = confirm( 'An email will be sent to you as soon as we compile all PDF(s), please confirm this.');
		
		if( c ) $.ajax( options );
		
		var successCallback = function()
		{
			alert( 'success' );
			
		}
		var errorCallback = function()
		{
			alert( 'error' );
			
		}
		
				
		
	});
	
});
