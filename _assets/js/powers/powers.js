// JavaScript Document
(function( $, app, helper ){
	$.fx.speeds._default = 1000;	


	$(".zip").mask("99999");
	$(".phone").mask("(999) 999-9999");
    $(".ssn").mask("999-99-9999");

	$( "#dialog" ).dialog({
		autoOpen: false,
		show: "fold",
		hide: "explode",
		modal: true,
		buttons: {
			"OK": function() {
					$( this ).dialog( "close" );
			}
		}		
	});

	
	


	$('select#power_status').change(function(event){
		
		var obj 		= $( this ),
		selectedOption 	= obj.find('option:selected').val();
		$('.power-opts').slideUp('fast').find('input');
		$('#power_detail').slideDown('fast');
		
		
	
		$( '#' + selectedOption ).slideDown( 'fast' );
		

			
	});



	
})( jQuery, IP.app, IP.app.helpers.generic );