// JavaScript Document
$(document).ready(function() { 
	$(function() {

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

		
		$('#offline_power').uploadify({
			'onCancel' 			: onCancel,
			onUploadCancel 		: onUploadCancel,
			onUploadSuccess 	: onUpload,
			auto     			: false,
			removeCompleted 	: true,
			swf      			: '/_assets/uploadify/uploadify.swf',
			uploader 			: '/_assets/uploadify/uploadify.php',
			onClearQueue		: queueCleared
		});


		function queueCleared( f )
		{
			alert( 'All powers not uploaded have been removed from this transmission.' );	
		}
		
		
		function onUploadCancel( file )
		{
			console.log( file );	
		}
		
		function onCancel( file )
		{
			var files = _.compact( $( '#files' ).val().split( ',' ) );
			
			files.remove( file.name );
			
			$( '#files' ).val( files );
			
			console.log( files );
		}

		function onUpload( file, data, response )
		{		
			var 
			files = $( '#files' ).val();			
			files = files + ',' + file.name;			
			$( '#files' ).val( files );
			
			files = _.compact( files.split( ',' ) );
			
			$( 'ul#uploaded-files' ).empty();
			
			console.log( 'hi' );
			_.each( files, function( obj )
			{
				$( 'ul#uploaded-files' ).append( $( '<li />' ).text( obj ) );

			},this );			
		}


	});
}); 			
