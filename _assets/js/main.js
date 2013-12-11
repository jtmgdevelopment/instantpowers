// JavaScript Document
var IP = window.IP || {};
IP.app = IP.app || {};

IP.app.helpers = {};


Array.prototype.remove= function(){
    var what, a= arguments, L= a.length, ax;
    while(L && this.length){
        what= a[--L];
        while((ax= this.indexOf(what))!= -1){
            this.splice(ax, 1);
        }
    }
    return this;
}



IP.app.helpers.generic = {
	
	d : function(x)
	{
		console.log(x);
		return;	
	},
	setMessage : function( message, messageType )
	{
		var message = $( 'div#js-messages').addClass( messageType ).text( message );		
		
		message.slideDown('fast', function(){
				
				$( this ).delay( 3500 ).slideUp('fast');
			
			});  
		
	}
};



(function($, app){
	
///	$(".tabs > ul").tabs();
//	$("a.tip[title]").tooltip({predelay:500});






    $.fn.extend({
        center: function (options) {
            var options = $.extend({ // Default values
                inside: window,
                // element, center into window
                transition: 0,
                // millisecond, transition time
                minX: 0,
                // pixel, minimum left element value
                minY: 0,
                // pixel, minimum top element value
                vertical: true,
                // booleen, center vertical
                withScrolling: true,
                // booleen, take care of element inside scrollTop when minX < 0 and window is small or when window is big
                horizontal: true // booleen, center horizontal
				,offset: 0
            }, options);
            return this.each(function () {
                var props = {
                    position: 'absolute'
                };
                if (options.vertical) {
                    var top = ($(options.inside).height() - $(this).outerHeight()) / 2;
                    if (options.withScrolling) top += $(options.inside).scrollTop() || 0;
                    top = (top > options.minY ? top : options.minY);
                    $.extend(props, {
                        top: top + 'px'
                    });
                }
                if (options.horizontal) {
                    var left = ($(options.inside).width() - $(this).outerWidth()) / 2;
                    if (options.withScrolling) left += $(options.inside).scrollLeft() || 0;
                    left = (left > options.minX ? left : options.minX);
                    $.extend(props, {
                        left: left - options.offset + 'px'
                    });
                }
                if (options.transition > 0) $(this).animate(props, options.transition);
                else $(this).css(props);
                return $(this);
            });
        }
    });

	
	
})(jQuery, IP.app );


