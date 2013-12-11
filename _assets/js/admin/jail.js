// JavaScript Document
(function( $, app, helper ){

	$(".zip").mask("99999");
	$(".phone").mask("(999) 999-9999");
    $(".ssn").mask("999-99-9999");
	
	$('.delete_user').click(function(e){
		
		var c 	= confirm('Are you sure you want to deactivate this user?'),
		id		= $( this ).data( 'id' );
		
		if( c ) window.location = '/admin/manage_jail/deactivate_jail_admin/' + id;
		
		e.preventDefault();
	});

	$('.activate_user').click(function(e){
		
		var c 	= confirm('Are you sure you want to activate this user?'),
		id		= $( this ).data( 'id' );
		
		if( c ) window.location = '/admin/manage_jail/activate__jail_admin/' + id;
		
		e.preventDefault();
	});
	


	
})( jQuery, IP.app, IP.app.helpers.generic );