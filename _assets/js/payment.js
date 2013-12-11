// JavaScript Document
(function( $, app, helper ){
	
	$('#process_payment').click(function(){
		
		var c = confirm('Are you sure you would like to purchase this transmission?');
		
		if( c )
		{
			return true;	
		}	
		window.location = '/bail_cpanel';	
		return false;
	});

	
})( jQuery, IP.app, IP.app.helpers.generic );