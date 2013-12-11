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

	
	
	$('.discharge-power').click(function(e){
		
		var c = confirm('Are you sure you are ready to discharge this bond?');
		
		if( c ) window.location = '/powers/process_discharge/' + $( this ).attr('id');
		
		return true;	
		e.preventDefault();
	});
	
	
	$( 'select#bail_agency' ).change(function(){
		var obj 		= $( this ),
		selectedOption 	= obj.find('option:selected').val(),
		opts			= {
				type	: 'GET',
				url		: '/powers/get_agents/' + parseInt(selectedOption),
				success	: loadAgents,
				error	: function()
				{
					helper.setMessage('Something went wrong.', 'error');	
				}				
			
			};
		
		$.ajax(opts);
	});

	$('.nogo').click(function(e){
		e.preventDefault();
		$( "#dialog" ).dialog( "open" );
	
		
	});


	$('.delete-transmission').click( function( event ){
		
		var conf	= confirm('Are you sure you want to delete this transmission? There is no going back once this is done'),
		obj			= $( this ),
		id			= parseInt( obj.attr('id') ),
		opts		= {
			url	: '/powers/delete_transmission/' + id,
			type: 'GET',
			success: function(data)
			{
				obj.parents('tr').slideUp('fast');
				helper.setMessage('Transmission and all of its powers have been deleted.','done');	
				return;
			},
			error: function()
			{
				helper.setMessage('Something unexpected went wrong. Instant Powers has been notified of this error.','error');	
				return;
			}
			
		};
		
		if( conf )
		{
			$.ajax(opts);			
		}
		
		event.preventDefault();
	});

	$('.delete-power').click(function( event ){
		
		var obj = $( this ),
		id		= parseInt( obj.attr('id') );
		
		$('#' + id + '_power' ).remove();
		
		obj.parents('tr').slideUp('fast');
		
		
		
		event.preventDefault();
	
	});

	$('.delete-active-power').click(function( event ){
		

		var conf	= confirm('Are you sure you want to delete this power? There is no going back once this is done'),
		obj			= $( this ),
		id			= parseInt( obj.attr('id') ),
		opts		= {
			url	: '/powers/delete_power/' + id,
			type: 'GET',
			success: function(data)
			{
				obj.parents('tr').slideUp('fast');
				helper.setMessage('Power and all of its powers have been deleted.','done');	
				return;
			},
			error: function()
			{
				helper.setMessage('Something unexpected went wrong. Instant Powers has been notified of this error.','error');	
				return;
			}
			
		};
		
		if( conf )
		{
			$.ajax(opts);			
		}
		
		event.preventDefault();

		
	});

	$('select#power_status').change(function(event){
		
		var obj 		= $( this ),
		selectedOption 	= obj.find('option:selected').val();
		$('.power-opts').slideUp('fast').find('input');
		$('#power_detail').slideDown('fast');
		
		if( parseInt(selectedOption) != 4 )
		{

			$('#extended').slideDown('fast');
			$('#bond_amount').attr('disabled',false);
		}
		
		switch(parseInt(selectedOption))
		{
			case 1:
				$('.power-opts').slideUp('fast');
			break;	
			case 2:
				$('#execution').slideDown('fast');
			break;	
			case 3:
				$('#forfeiture').slideDown('fast');
			break;	
			case 4:
				$('#discharge').slideDown('fast');
			break;	
			case 5:
				$('#voided').slideDown('fast');
				$('#extended').slideUp('fast');
				$('#bond_amount').val('0').attr('disabled',true);
			break;	
			case 6:
				$('#transfer').slideDown('fast');
			break;	
			case 7:
				$('#rewrite').slideDown('fast');
			break;	
			default:
				$('.power-opts').slideUp('fast').find('input');
			break;
		}
			
	});

	function loadAgents( data )
	{
		var drop 	= $( '#bail_agent' ), 
		i			= 0,
		json 		= $.parseJSON( data );
		
		if( json.length )
		{
			drop.empty().attr('disabled',false);

			$.each( json, function(index, obj ){
				
				drop.append( $('<option />' )
					.attr(
						'value', obj['member_external_key']).text(obj['name']) 
					);
			});
			
		}
	}
	

	
})( jQuery, IP.app, IP.app.helpers.generic );