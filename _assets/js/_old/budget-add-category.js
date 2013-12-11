// JavaScript Document
$( function( $ ){
var speed = 500;
var rowTemplate = '<tr id="{4}_row"><td class="t-center">{0}</td><td>{1}</td><td class="t-right high-bg">{2}</td><td class="t-center">{3}</td><td class="t-center"><a class="edit" id="{4}_edit" href="##"><img src="/secure/_assets/design/ico-edit.gif" class="ico" alt="Edit" /></a><a class="delete" id="{4}_delete" href="##"><img src="/secure/_assets/design/ico-delete.gif" class="ico" alt="Delete" /></a></td></tr>';
var checkMark =  '<img src="/secure/_assets/design/ico-done.gif" alt="Recuring Category" />';
$( 'table#category' ).tablesorter(); 
//show/hide form
$( 'a#show-form' )
	.toggle( function( event ){
								   
		$( 'div#ajax-form' ).slideDown( speed );
		$( 'div#notice' ).slideUp( speed );

	},function( event ){
		
		$( 'div#ajax-form' ).slideUp( speed );
		
	}
);

$( 'a#past-budgets' )
	.toggle( function( event ){
								   
		$( 'div#month-form' ).slideDown( speed );
		

	},function( event ){
		
		$( 'div#month-form' ).slideUp( speed );
		
	}
);

String.prototype.format = function(){
    var s = this,
        i = arguments.length;

    while (i--) {
        s = s.replace(new RegExp('\\{' + i + '\\}', 'gm'), arguments[i]);
    }
    return s;
};

var ajax_container = $( 'div#ajax-form' ).css( 'position','relative' );
var css = { 
	'position': 'absolute', 
	'top': '0px', 
	'left': 0, 
	'background': '#000', 
	'width': '100%', 
	'height': '100%', 
	'opacity': '.5', 
	'filter': 
	'alpha(opacity=50)', 
	'-moz-opacity': '.5',
	'z-index':1000
	};
var overlay = $( '<div />' ).attr( 'id' , 'overlay' ).css(css).prependTo( 'body').hide();

var loader = jQuery('<div id="loader"><img src="/secure/_assets/img/loading.gif" alt="loading..." /></div>')
	.css({position: "absolute", top: ".5em", left: "30em", 'z-index':1000})
	.appendTo(ajax_container)
	.hide();


$().ajaxStart(function() {
	overlay.fadeIn();
	loader.show();
}).ajaxStop(function() {
	loader.hide();
	overlay.fadeOut();
}).ajaxError(function(a, b, e) {
	alert( e );
	throw e;
});

var container = $('div.error');
var ajax_validator = $("#ajax-validate").validate({
	errorContainer: container,
	errorLabelContainer: $("ul", container),
	wrapper: 'li',
	meta: "validate",
	invalidHandler: function( form , validator ){
		scrollWin();	
	},
	submitHandler:function( form ){
		

		options = {
			type: 'GET',
			url: '_resources/script_budget_gateway.cfm',
			data: {
				traffic: $( 'input[ name="traffic" ]' ).val(),
				category_name: $( 'input[ name="category_name" ]' ).val(),
				category_desc: $( 'input[ name="category_desc" ]' ).val(),
				amount:$( 'input[ name="amount" ]' ).val(),
				recurring:( $( 'input[ name="recurring" ]:checked' ).val() ? 1 : 0 ),
				type: $( 'input[ name="type2" ]' ).val(),
				id: $( 'input[ name="id" ]' ).val()
			},
			error:function(){
				
				alert( 'There was an un-expected error' );	
			},
			success:function(data){
				
				var formFields = {
					amount: $( 'input[ name="amount" ]' ),
					categoryName: $( 'input[ name="category_name" ]' ),
					categoryDescription: $( 'input[ name="category_desc" ]' ),
					recurring: ( $( 'input[ name="recurring" ]:checked' ).val() ? checkMark : '' ),
					catID: data
					
				};
				
		
				setTimeout(function(){
					$( 'table#category tr#example' ).fadeOut( function(){ $( this ).remove(); });
				},1000);
				
				
				$( 'table#category tbody' )
					.prepend( 
							rowTemplate.format( 
											   formFields.categoryName.val(), 
											   formFields.categoryDescription.val(), 
											   formFields.amount.val(), 
											   formFields.recurring, 
											   formFields.catID
											   )
							);
													

				$( 'input[ name="category_name" ]' ).val( '' );
				$( 'input[ name="category_desc" ]' ).val( '' );
				$( 'input[ name="amount" ]' ).val( '' );

				$( 'table' ).trigger( 'update' ); 
				$( 'input[ name="traffic" ]' ).val( 'add_category' );
				$( 'span#originalAmount' ).text( '' );
				getTotals();
			
			}
		};


		$.ajax( options );
		return false;	
	}
});

var ajax_validator = $("#save").validate({
	errorContainer: container,
	errorLabelContainer: $("ul", container),
	wrapper: 'li',
	meta: "validate",
	invalidHandler: function( form , validator ){
		scrollWin();	
	},
	submitHandler:function( form ){
		

		options = {
				type: 'GET',
				url: '_resources/script_budget_gateway.cfm',
				data: {
					traffic: $( 'input[ name="traffic" ]' ).val(),
					savingsAmount: $( 'input[ name="savings" ]' ).val()
				},
				error:function(){
					
					alert( 'There was an un-expected error' );	
				},
				success:function(data){
					
					if( data ){
						$( 'div#ajax-form' ).slideUp( speed );
						$( 'div#notice' ).slideDown( speed );
					}
					else{
						
						
					}
				}
		};

		$.ajax( options );
		return false;	
	}
});


$( 'a.delete' )
	.live( 'click', function( event ){
		
		row = $( this ).closest( 'tr' );
		rowID = parseInt( row.attr( 'id' ) );
		
		//call method to delete
		
		options = {
			type: 'GET',
			url: '_resources/script_budget_gateway.cfm',
			data: {
				traffic: 'delete_category',
				id: rowID
			},
			error:function(){
				
				alert( 'There was an un-expected error' );	
			},
			success:function(){
				row.closest( 'tr' ).fadeOut( speed ).remove();	
				getTotals();
			}
			
		};
		
		$.ajax( options );


		event.preventDefault();							
	}
);

$( 'a.edit' )
	.live( 'click', function( event ){
		$( 'div#ajax-form' ).slideDown( speed );
		var row = $( this ).closest( 'tr' );
		var rowID = parseInt( row.attr( 'id' ) );
		var cells = row.find( 'td' );
		var recurring = $.trim( cells[ 3 ].innerHTML );
		var amount = $.trim( cells[ 2 ].innerHTML ).replace(/\$/g, '');
		
		$( 'input[ name="category_name" ]' ).val( $.trim( cells[ 0 ].innerHTML ) );
		$( 'input[ name="category_desc" ]' ).val( $.trim( cells[ 1 ].innerHTML ) );
		$( 'input[ name="originalValue" ]' ).val( amount );
		$( 'span#originalAmount' ).text( 'Original Amount: $' + amount ); 
		//$( 'input[ name="amount" ]' ).val( amount );
		if( recurring.length ) $( 'input[ name="recurring" ]' ).attr( 'checked', true );
		else $( 'input[ name="recurring" ]' ).attr( 'checked', false );
		$( 'input[ name="traffic" ]' ).val( 'update_category' );
		$( 'input[ name="id" ]' ).val( rowID );

		$('html, body').animate({scrollTop: 100}, 800);
		row.closest( 'tr' ).fadeOut( speed ).remove();	
		

		event.preventDefault();							
	}
);


function getTotals( newAmount, operator ){

		

		options = {
			type: 'GET',
			url: '_resources/script_budget_gateway.cfm',
			data: {
				traffic: 'get_totals',
				type: $( 'input[ name="type2" ]' ).val(),
				month: $( 'input[ name="month" ]' ).val(),
				year: $( 'input[ name="year" ]' ).val()
			},
			error:function(){
				
				alert( 'There was an un-expected error' );	
			},
			success:function(data){
				
				
				var total = parseFloat( data );
				$( 'span#total' ).text( total.toFixed(2) );
				

			}
			
		};

		$.ajax( options );

}
});