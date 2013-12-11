// JavaScript Document
(function( $, app, helper ){
	
	
	$( 'a.purchase-transmission' ).click( function( event ){
		
		var 
		obj 		= $( this );

		$( '#errors' ).empty().hide();
		
		$( '#trans-modal' ).dialog({
			modal 		: true,
			autoOpen	: false,
			width		: 500,
			buttons		: {
					'Purchase Transmission' : function()
					{
						var 
						obj 		= $( this ).data( 'link' ),
						trans_id 	= obj.data( 'trans-id' ),
						trans_url	= '/agent/transmissions/purchase/' + parseInt( trans_id ),
						options		= {
							'url'		: trans_url,
							'type'		: 'POST',
							'data'		: { tid : trans_id },
							'dataType'	: 'JSON',
							'success'	: function( data )
							{
								if( data.error )
								{
									$( '#errors' ).text( data.message ).show();	
									return false;
								}
								else
								{
									location.href = '/agent/transmissions/index/show_paid_message';	
								}
								
								
									
							}
						};
											
						$.ajax( options );																
						
						
					},
					'Cancel' : function()
					{
						$( '#errors' ).empty().hide();

						$( this ).dialog( 'close' );	
					}
				
			}
		});


		
		$( '#trans-modal' )
		.data('link' , obj  )
		.dialog( 'open' );
		event.preventDefault();
	
	});
	
	function get_trans_id()
	{
		
		return trans_id;	
	}

	
})( jQuery, IP.app, IP.app.helpers.generic );