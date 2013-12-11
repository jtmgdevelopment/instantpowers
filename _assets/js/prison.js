// JavaScript Document
(function( $, app, helper ){
	
	
	$('.accept-power').click(function(e){
		
		var c 	= confirm('Are you sure you are ready to accept this power?'),
		id		= parseInt( $( this ).attr( 'id' ) );
		
		if( c ) window.location = '/prison_cpanel/accept_power/' + id;
		
		e.preventDefault();
	});
	


	
})( jQuery, IP.app, IP.app.helpers.generic );