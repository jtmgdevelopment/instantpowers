// JavaScript Document
$( function(){


$( 'a#todo_form' )
	.click(
		function(event)
		{
		
			$('div.todo_form').slideToggle('slow','easeOutCirc');
			event.preventDefault();
		}
	);

$( 'p.ind-todo' )
	.hover(
		function(event)
		{
			$( this ).css('background-color','#eee').find('span.tools').show();
		
		},
		function(event)
		{
			$( this ).css('background-color','#fff').find('span.tools').hide();
			
			
		}
	).css({'min-height':'20px','padding':'10px'});


$( 'input.todo_checkbox' )
	.click( 
		function( event )
		{
			var $this = $( this );
		
			window.location = '/to_do_list/complete_item/' + $this.attr('id');
		
		}
	);

$( 'input.todo_checkbox_completed' )
	.click( 
		function( event )
		{
			var $this = $( this );
		
			window.location = '/to_do_list/un_complete_item/' + $this.attr('id');
		
		}
	);
	
	
});