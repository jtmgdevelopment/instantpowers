$( document ).ready(function(e) {
	
	
	$( 'a#change-status' ).click( function( event ){
		event.preventDefault();
		var obj = $( event.currentTarget ), c, data = obj.data();
		c = confirm( 'Are you sure you want to change the status of this prefix?' );
		if( c )
		{
			changeStatus( data.status, data.prefix_id )
			if( data.status == 'deactivate' )
			{
				obj.data( 'status' , 'activate' );
				obj.text( 'Activate?' );	
				$( '#' + data.prefix_id + '_status').text( 'Not Active' );			
			}
			else
			{
				obj.data( 'status' , 'deactivate' );
				obj.text( 'Deactivate?' );				
				$( '#' + data.prefix_id + '_status').text( 'Active' );
			}
		}
	});
	
	function changeStatus( status, prefix_id )
	{
		var options = {
			url 	: '/insurance/power_prefix/change_status/' + status,
			data	: {
				prefix_id : prefix_id
			},
			type	: 'POST',
			error	: errorCallback,
			success	: successCallback		
		}	
		
		$.ajax( options );
		
		var errorCallback = function()
		{
			
			alert( 'error' );
		}
		
		var successCallback = function()
		{
			
			alert( 'succes' );
		}
	}
		
});
