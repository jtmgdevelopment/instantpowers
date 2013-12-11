// JavaScript Document
function scrollWin(){
$('html, body').animate({
scrollTop: 0
}, 800);
}
jQuery.validator.addMethod("ziprange", function(value, element) {
	return this.optional(element) || /^\d{5}([\-]\d{4})?$/.test(value);
}, "Your ZIP-code must be in the range 902xx to 902xx-xxxx");

// Validate for 2 decimal for money
jQuery.validator.addMethod("money", function(value, element) {
    return this.optional(element) || /^(\d{1,10})(\.\d{1,2})?$/.test(value);
}, "Must be in US currency format 0.99. Please do not use a dollar sign ($)");

$().ready(function() {
	var container = $('div.error');
	// validate the form when it is submitted
	var validator = $("#validate").validate({
		errorContainer: container,
		errorLabelContainer: $("ul", container),
		wrapper: 'li',
		meta: "validate",
		invalidHandler: function( form , validator ){
			scrollWin();	
		}
	});


	


	$(".cancel").click(function() {
		validator.resetForm();
	});
});
