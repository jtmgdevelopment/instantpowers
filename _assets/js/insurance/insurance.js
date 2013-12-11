$( document ).ready(function(e) {
	
	$( '#bail_agency' ).change( function( event ){
		var
		obj = $( this ),
		value = obj.find( 'option:selected' ).val(),
		options = {
			'url' 	: '/insurance/transmissions/get_agent/' + value,
			'type'	: 'GET',
			'dataType'	: 'json',
			'success': function( data )
			{	
				$( '#agent' ).val( data.name );
				$( 'input[ name="agent_id" ]' ).val( data.mek );	
			}	
		};
	
		$.ajax( options );	
		
			
		
	})
	
	$( '#power_prefix' ).change( function( event ){
		
		var
		obj = $( this ),
		value = obj.find( 'option:selected' ).val(),
		options = {
			'url' 	: '/insurance/transmissions/get_max_power/' + value,
			'type'	: 'GET',
			'dataType'	: 'json',
			'success': function( data )
			{	
				$( '#power_start' ).val( data.power );
			}	
		};
	
		$.ajax( options );	
			
		
	});
	
});
