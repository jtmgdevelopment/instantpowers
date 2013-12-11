// JavaScript Document
(function( $, app, helper ){
	
	$('.delete_user').click(function(e){
		
		var c 	= confirm('Are you sure you want to deactivate this user?'),
		id		= $( this ).data( 'id' );
		
		if( c ) window.location = '/admin/manage_clerk/deactivate_clerk/' + id;
		
		e.preventDefault();
	});

	$('.activate_user').click(function(e){
		
		var c 	= confirm('Are you sure you want to activate this user?'),
		id		= $( this ).data( 'id' );
		
		if( c ) window.location = '/admin/manage_clerk/activate_clerk/' + id;
		
		e.preventDefault();
	});
	


	
})( jQuery, IP.app, IP.app.helpers.generic );