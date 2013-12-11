( function( $ ){

        /*

            FN defaultValue Plugin
            sets the default value for an input/password/textarea
            This will reset the field on focus and set the default text if the field is blank on blur
        */

        $.fn.defaultValue = function(text){
            return this.each(function(){

                if(this.type != 'text' && this.type != 'password' && this.type != 'textarea') return;
                var self = this,
                obj = $( this );
				
                if( self.value=='' )	this.value = text;
                //else return false;
				
				
                obj.focus(function() {
		
				    if( this.value == text || this.value == '' ) this.value='';
                });

                obj.blur(function() {
                    if(this.value==text || this.value=='') this.value=text;
                });

                obj.parents("form").each(function() {
                    $(this).submit(function() {
                       if( self.value== text ) self.value='';
                    });
                });
            });
        };
	



$(document).ready(function(e) {
		

		
	/*
		add more sub agent fields
	*/
	$( '#add-more-subs' ).click( function(event){
		
		$( '#more-sub-agents' ).slideDown();	
		event.preventDefault();
		
	});
	
	
	/*
		clerks form
	*/
	
	$( 'a#submit-clerk-frm' ).click( function( event ){
		
		$( 'form#clerk-form' ).submit();
		event.preventDefault();	
	});


	/*
		ins form
	*/
	
	$( 'a#submit-ins-frm' ).click( function( event ){
		
		$( 'form#ins-form' ).submit();
		event.preventDefault();	
	});


	/*
		jail form
	*/
	
	$( 'a#submit-jail-frm' ).click( function( event ){
		
		$( 'form#jail-form' ).submit();
		event.preventDefault();	
	});

	/*
		agent form
	*/
	
	$( 'a#submit-agent-frm' ).click( function( event ){
		
		$( 'form#agent-form' ).submit();
		event.preventDefault();	
	});

	/*
		login form
	*/
	
	$( 'a#submit-login-frm' ).click( function( event ){
	
		$( 'form#login-frm' ).submit();
		event.preventDefault();	
	});
	
	
	/*
		highlight sub agents
	*/
	
	
	
	$( 'ul.breadcrumb input[type="checkbox"]' ).click(function(event){
		
		var 
		obj		= $( this ),
		parent 	= obj.parents( 'ul' );
		if( obj.is( ':checked' ) ) parent.addClass('is-highlight' );
		else parent.removeClass( 'is-highlight');
		
		
	});
	
	//$( 'ul.breadcrumb input[type="checkbox"]' ).is(':checked').hide();	
		
});
})( jQuery );