// JavaScript Document


Number.prototype.formatMoney = function(c, d, t){
var n = this, c = isNaN(c = Math.abs(c)) ? 2 : c, d = d == undefined ? "," : d, t = t == undefined ? "." : t, s = n < 0 ? "-" : "", i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "", j = (j = i.length) > 3 ? j % 3 : 0;
   return '$' + s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
 };


(function( $, app, helper ){
	
	var	
	creditCost 		= $( 'input[name="credit_amount"]' ).val(),
	credits			= parseInt( $( '#credits' ).val() ),
	transaction_fee = .03;
	
	if( ! isNaN( credits ) || value > 1 ) 
	{
		credits = Math.ceil( credits );
		
		var  price = credits * creditCost;
		
		var fee = price * transaction_fee;
		
		var total = price + fee;
		
		
		$( '#credit_cost' ).val( price.formatMoney(2, '.', ',') );
		$( '#transaction_fee' ).val( fee.formatMoney( 2, '.', ',' ) );
		$( '#total' ).val( total.formatMoney( 2, '.', ',' ) );
		
	}	
	

	
	$( '#credits' ).blur( function(event ){
		
		var 
		creditCost 	= $( 'input[name="credit_amount"]' ).val(),
		obj			= $( this ),
		value		= parseInt( obj.val() ),
		price		= 0,
		transaction_fee = .03;
		
		if( isNaN( value ) || value < 1)
		{
			 alert( 'Please provide only numbers' );
			 return false;	
		}
		
		value = Math.ceil( value );
		
		price = value * creditCost;
		
		var fee = price * transaction_fee;
		
		var total = price + fee;
		
		$( '#credit_cost' ).val( price.formatMoney(2, '.', ',') );
		$( '#transaction_fee' ).val( fee.formatMoney( 2, '.', ',' ) );
		$( '#total' ).val( total.formatMoney( 2, '.', ',' ) );
		
		
		
		
	});



	
})( jQuery, IP.app, IP.app.helpers.generic );