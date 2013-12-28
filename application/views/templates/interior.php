<?= '<?xml version="1.0"?>' ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en"><head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta http-equiv="content-language" content="en" />
	<meta http-equiv="X-UA-Compatible" content="chrome=1">
	<meta http-equiv="X-UA-Compatible" content="IE=10" />
	<meta name="robots" content="noindex,nofollow" />
	<link rel="stylesheet" media="screen,projection" type="text/css" href="/_assets/css/reset.css" /> 
	<link rel="stylesheet" media="screen,projection" type="text/css" href="/_assets/css/main.css" /> 
	<link rel="stylesheet" media="screen,projection" type="text/css" href="/_assets/css/1col.css" title="2col" /> 
	<link rel="alternate stylesheet" media="screen,projection" type="text/css" href="/_assets/css/1col.css" title="1col" /> 
	<!--[if lte IE 6]><link rel="stylesheet" media="screen,projection" type="text/css" href="/_assets/css/main-ie6.css" /><![endif]--> 
	<link rel="stylesheet" media="screen,projection" type="text/css" href="/_assets/css/style.css" /> 
	<link rel="stylesheet" media="screen,projection" type="text/css" href="/_assets/css/mystyle.css" /> 
	<link rel="stylesheet" media="screen,projection" type="text/css" href="/_assets/css/jquery-ui-1.8.12.custom.css" /> 
    <link rel="stylesheet" media="screen" type="text/css" href="/_assets/fancybox_v2/jquery.fancybox.css" />
	<?= $_styles;?>
	<title><?= $title ?> | Instant Powers</title>
	<!--[if gte IE 9]>  <style type="text/css">.gradient {filter: none;}</style><![endif]-->
	
</head>
<body>
<div id="main"> 
<? $this->load->view('includes/navigation_' . $this->session->userdata('role')); ?>
<!-- /header -->
<hr class="noscreen" />
<!-- Columns -->
<div id="cols" class="box">
	<!-- Aside (Left Column) -->
	<div id="aside" class="box">
		<div class="padding box">
			<!-- Logo (Max. width = 200px) -->
			<p id="logo">
				<a href="##">
				</a>
			</p>
			
		</div>
	</div>
	<!-- /aside -->
	<hr class="noscreen" />
		<!-- Content (Right Column) -->
	<div id="content" class="box">
	<h1><?= $title ?></h1>
	<h2><?= $sub_title ?></h2>
	<div id="js-messages" class="msg" style="display:none;"></div>
	<? if($this->session->flashdata('message')): ?>
		<div class="msg <?= $this->session->flashdata('message_type'); ?>">
			 <?= $this->session->flashdata('message'); ?>
		</div>
	<? endif; ?>
	
	<? if( $errors ): ?>
	
		<?=$errors?>
	
		<? endif; ?>
	
	<?= $content ?>
	</div>
	<!-- /content -->
</div>
<!-- /cols -->
<hr class="noscreen" />
<!-- Footer -->
<div id="footer" class="box">
	<p class="f-left">
		&copy; 2011
		<a href="#">
			Instant Powers
		</a>
		, All Rights Reserved &reg;

	<? if( ENVIRONMENT == 'development' ): ?>
		Template: <?= $this->session->userdata( 'template' ); ?>		
	<? endif; ?>

	</p> 
</div>
<!-- /footer -->
</div>

<? if($this->session->flashdata('show_notification')): ?>
<a class="fancybox" href="#box"></a>
<div style="display:none;" id="box">
<div>dsfadsf</div>
</div>
<? endif; ?>

<!-- /main --> 
<script src="https://code.jquery.com/jquery-1.10.1.min.js"></script>
<script src="https://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>

<script src="/_assets/js/libs/jquerytools/jquery.tools.min.js"></script>

<script type="text/javascript" src="/_assets/js/libs/jqueryUI/js/jquery-ui-1.8.12.custom.min.js"></script>
<script type="text/javascript" src="/_assets/js/libs/jqueryUI/js/jquery-ui-timepicker-addon.js"></script>
<script type="text/javascript" src="/_assets/js/main.js"></script>
<script type="text/javascript" src="/_assets/fancybox_v2/jquery.fancybox.pack.js"></script>
<?= $_scripts; ?>
<script type="text/javascript">
$(document).ready(function(){
	var CSS 			= {'position':'fixed','top':0,'left':0,'width':'100%','height':'100%','background-color':'#000','z-index':'100','display':'none','opacity': 0.5};
	var OVERLAY 		= $('<div id="overlay" style="z-index:1"></div>');
	var LOADINGIMAGE 	= $( '<div class="callout" style="z-index:1000;width:400px; margin-top:-150px;"><h3>Please Be Patient While This Request Processes</h3><img style="z-index:1000" src="/_assets/img/loader.gif" alt="Loading" /></div>' );

	$('form').submit(function(e){
		if( $( this ).hasClass( 'no-loading' ) ) return true;
		
		OVERLAY.appendTo( document.body ).css( CSS ).fadeIn();
		LOADINGIMAGE.center({offset: 200}).appendTo( document.body ).show();
	});	
	
	
	$(' a.load').click(function(e){
		OVERLAY.appendTo( document.body ).css( CSS ).fadeIn();
		LOADINGIMAGE.center({offset: 200}).appendTo( document.body ).show();
	});
	
	$( 'div#loading').css(CSS);
	$( ".datepicker" ).datepicker();
	$('.timepicker').timepicker({
		ampm: true
	});

	<? if($this->session->flashdata('show_notification')): ?>
		$(".fancybox").fancybox().click();
	<? endif; ?>


$(function( $ ){
				
				 function filterPath(string) {
				  return string
					.replace(/^\//,'')
					.replace(/(index|default).[a-zA-Z]{3,4}$/,'')
					.replace(/\/$/,'');
				  }
				  var locationPath = filterPath(location.pathname);
				  var scrollElem = scrollableElement('html', 'body');
				
				  $('a[href*=#]').each(function() {
					var thisPath = filterPath(this.pathname) || locationPath;
					if (  locationPath == thisPath
					&& (location.hostname == this.hostname || !this.hostname)
					&& this.hash.replace(/#/,'') ) {
					  var $target = $(this.hash), target = this.hash;
					  if (target) {
						var targetOffset = $target.offset().top;
						$(this).click(function(event) {
						  event.preventDefault();
						  $(scrollElem).animate({scrollTop: targetOffset}, 500, function() {
							location.hash = target;
						  });
						});
					  }
					}
				  });
				
				  function scrollableElement(els) {
					for (var i = 0, argLength = arguments.length; i <argLength; i++) {
					  var el = arguments[i],
						  $scrollElement = $(el);
					  if ($scrollElement.scrollTop()> 0) {
						return el;
					  } else {
						$scrollElement.scrollTop(1);
						var isScrollable = $scrollElement.scrollTop()> 0;
						$scrollElement.scrollTop(0);
						if (isScrollable) {
						  return el;
						}
					  }
					}
					return [];
				  }
										
			});		
});


</script>
</body></html>	