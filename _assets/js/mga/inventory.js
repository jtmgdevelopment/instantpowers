// JavaScript Document
(function( $, app, helper ){

	var valueArray = [];


	$( 'input.recoup' ).click( function(){
		var 
		obj = $( this ),
		val = obj.val();
				
		
		
		if( obj.is( ':checked' ) ) valueArray.push( val );
		else valueArray.remove( val );
		
	});
	
	$( 'form#recoup_powers' ).submit(function(){
		
		if( valueArray.length == 0 ) 
		{
			alert( 'Please add at least one power' );
			location.href = '/mga/power_inventory/recoup_powers';
			return false;	
			
		}
		
		var options = {
				type 	: 'POST',
				url		: '/mga/power_inventory/process_recoup_powers',
				data	: { 'recoup' : valueArray.join() },
				success : function( data )
				{
					
					
					location.href = '/mga/power_inventory/index/message';
				},
				error : function( data )
				{
					
					
				}			
		}
		
		$.ajax( options );
		
		return false;
		
	});







	$( 'input.transfer' ).click( function(){
		var 
		obj = $( this ),
		val = obj.val();
				
		
		
		if( obj.is( ':checked' ) ) valueArray.push( val );
		else valueArray.remove( val );
		
	});
	
	$( 'form#transfer_powers' ).submit(function(){
		
		if( valueArray.length == 0 ) 
		{
			alert( 'Please add at least one power' );
			location.href = '/mga/power_inventory';
			return false;	
			
		}
		
		var options = {
				type 	: 'POST',
				url		: '/mga/power_inventory/process_transfer_powers',
				data	: { 'transfer' : valueArray.join() },
				success : function( data )
				{
					location.href = '/mga/power_inventory/choose_agent';
				},
				error : function( data )
				{
					
					
				}			
		}
		
		$.ajax( options );
		
		return false;
		
	});






	
})( jQuery, IP.app, IP.app.helpers.generic );