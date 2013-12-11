<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<meta name="description" content="<?= $meta_desc; ?>" />
<meta name="keywords" content="<?= $meta_keywords; ?>" />
<?= $_styles;?>
<title>
<?= $title ?>
| HUD Voucher</title>
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,400,700' rel='stylesheet' type='text/css'>
<link rel="stylesheet" type="text/css" media="all" href="/assets/css/style.css" />
<link rel="shortcut icon" href="favicon.ico" />
<!--[if gte IE 9]><style type="text/css">.gradient {filter: none;}</style><![endif]-->
 
</head>
<!--[if lt IE 7 ]> <body class="ie6"> <![endif]-->
<!--[if IE 7 ]>    <body class="ie7"> <![endif]-->
<!--[if IE 8 ]>    <body class="ie8"> <![endif]-->
<!--[if IE 9 ]>    <body class="ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<body>
<!--<![endif]-->

<body>
<? $this->load->view('includes/exterior/header.php'); ?>
<div id="wrapper">
	<div class="container clearfix">
		<div id="slider-wrapper">
			<div class="slider-container">
				<div class="thumbslider">
					<div id="thumb-nav"></div>
					<div id="thumb-slideshow"> <img src="/assets/images/slider1.jpg" height="360" width="560" alt="slider pic" /> <img src="/assets/images/slider2.jpg" height="360" width="560" alt="slider pic" /> <img src="/assets/images/slider3.jpg" height="360" width="560" alt="slider pic" /> <img src="/assets/images/slider4.jpg" height="360" width="560" alt="slider pic" /> <img src="/assets/images/slider5.jpg" height="360" width="560" alt="slider pic" /> </div>
				</div>
			</div>
			<!-- SLIDER CLOSED --> 
			
			<!-- SEARCH OPTIONS -->
			<div class="advancesearch-wrapper-home">
				<div class="search-options">
					<div class="advancesearch-head-home">
						<h3>Find Your Home</h3>
					</div>
					<form class="advance-search-form-home" action="#" method="get">
						<div class="option-bar">
							<label class="option-title">Property</label>
							<select name="select-type" id="select-type" class="search-select">
								<option value="Choice 1">--Select Type--</option>
								<option value="Choice 2">Homes</option>
								<option value="Choice 3">Apartments</option>
								<option value="Choice 4">Duplexes</option>
							</select>
						</div>
						<!-- end of #select1 -->
						<div class="option-bar">
							<label class="option-title">Price</label>
							<select name="select-prices" id="select-prices" class="search-select">
								<option value="Choice 1">--Select Price--</option>
								<option value="Choice 2">Price 1</option>
								<option value="Choice 3">Price 2</option>
								<option value="Choice 4">Price 3</option>
							</select>
						</div>
						<!-- end of #select1 -->
						<div class="option-bar">
							<label class="option-title">Region</label>
							<select name="select-region" id="select-region" class="search-select">
								<option value="Choice 1">--Select Region--</option>
								<option value="Choice 2">Region 1</option>
								<option value="Choice 3">Region 2</option>
								<option value="Choice 4">Region 3</option>
							</select>
						</div>
						<!-- end of #select2 -->
						<div class="option-bar">
							<label class="option-title">Rooms</label>
							<select name="select-location" id="select-location" class="search-select">
								<option value="Choice 1">--No. of  Rooms--</option>
								<option value="Choice 2">2 Bedroom</option>
								<option value="Choice 3">3 Bedroom</option>
								<option value="Choice 4">4 + Bedroom</option>
							</select>
						</div>
						<!-- end of #select3 -->
						<div id="search-box">
							<label class="option-title">Zip Code</label>
							<input type="text" id="as" name="s" value="" />
						</div>
						<div class="search-btn-wrapper">
							<input type="submit" value="Search" class="advance-search-btn" />
						</div>
					</form>
				</div>
			</div>
			<!-- ADVANCE SEARCH WRAPPER CLOSED --> 
		</div>
		<!-- SLIDER WRAPPER...................................................................................... CLOSED --> 
		
		<!-- Home Contents -->
		
		<div id="content">
			<h2 class="title list-title">Newest Listings</h2>
			<div class="new-property-wrapper">
				<ul class="property-list">
					<li>
						<h4><a href="#">Midway, FL</a></h4>
						<p class="sub-title">Listing ID: 29810002</p>
						<div class="property-detail-block">
							<div class="property-pic-wrapper"> <a href="#"><img src="/assets/images/news-pic2.jpg" alt="new-property" /></a> </div>
							<div class="freatures-wrapper"> <span class="size">1320 sf</span> <span class="bed">3 beds</span> <span class="bath">2 Baths</span> </div>
							<p></p>
						</div>
						<p>Aliquam erat volutpat. Duis blan augue ac orci laosds reet eget con dimentum magna venenatis.</p>
					</li>
					<li>
						<h4><a href="#">Quincy, FL</a></h4>
						<p class="sub-title">Listing ID: 52060300</p>
						<div class="property-detail-block">
							<div class="property-pic-wrapper"> <a href="#"><img src="/assets/images/news-pic1.jpg" alt="new-property" /></a> </div>
							<div class="freatures-wrapper"> <span class="size">1734 sf</span> <span class="bed">4 beds</span> <span class="bath">2.5 Baths</span> </div>
							<p></p>
						</div>
						<p>Aliquam erat volutpat. Duis blan augue ac orci laosds reet eget con dimentum magna venenatis.</p>
					</li>
				</ul>
				<hr />
				<ul class="property-list">
					<li>
						<h4><a href="#">Gainesville, FL</a></h4>
						<p class="sub-title">Listing ID: 39450015</p>
						<div class="property-detail-block">
							<div class="property-pic-wrapper"> <a href="#"><img src="/assets/images/news-pic3.jpg" alt="new-property" /></a> </div>
							<div class="freatures-wrapper"> <span class="size">2134 sf</span> <span class="bed">5 beds</span> <span class="bath">3 Baths</span> </div>
							<p></p>
						</div>
						<p>Aliquam erat volutpat. Duis blan augue ac orci laosds reet eget con dimentum magna venenatis.</p>
					</li>
					<li>
						<h4><a href="#">Tallahassee, FL</a></h4>
						<p class="sub-title">Listing ID: 48460012</p>
						<div class="property-detail-block">
							<div class="property-pic-wrapper"> <a href="#"><img src="/assets/images/news-pic.jpg" alt="new-property" /></a> </div>
							<div class="freatures-wrapper"> <span class="size">1987 sf</span> <span class="bed">4 beds</span> <span class="bath">3 Baths</span> </div>
							<p></p>
						</div>
						<p>Aliquam erat volutpat. Duis blan augue ac orci laosds reet eget con dimentum magna venenatis.</p>
					</li>
				</ul>
			</div>
		</div>
		<!-- CONTENT HOME CLOSED -->
		
		<div class="sidebar-home">
			<div class="side-widget">
				<div class="agent-container clearfix">
					<div class="agent-pic-wrapper"> <img src="/assets/images/avatar-image.png" alt="agent" /> </div>
					<h3>Call today for Assistance!</h3>
					<p>Call one of our professionals to lorem hud vouchers ipsum.</p>
				</div>
			</div>
			<div class="side-widget">
				<div class="featured-property">
					<h3 class="title">Featured Property</h3>
					<div class="property-view"> <a href="#"><img src="/assets/images/feature-listing.jpg" alt="featured property" /></a>
						<div class="featured-price-tag"> <small>Just Listed</small>
							<h5 class="price">$987.00/month</h5>
						</div>
					</div>
					<h4><a href="#">Orlando, FL Home</a></h4>
					<p class="sub-title">Listing ID: 32460006</p>
					<p>Aliquam erat volutpat. Duis blan augue ac orci lao reet eget con dimentum magna venenatis. Maecenas eget aure property.</p>
				</div>
			</div>
			<div class="side-widget">
				<h3 class="title">Newsletter Signup</h3>
				<p>Hud vouchers ipsum metus, sempehendrerit varius mattis,congue sit amet tellus.</p>
				<form class="subs-form" action="#" method="post">
					<p>
						<input type="text" value="E-mail address" id="subs-bar" class="input-subs" />
						<input type="submit" value="Sign Up" class="subs-btn"  />
					</p>
				</form>
			</div>
		</div>
		<!-- SIDEBAR HOME CLOSED --> 
	</div>
	<!-- CONTAINER CLOSED --> 
</div>
<!-- WRAPPER....................................................................................................... CLOSED -->
<? $this->load->view('includes/exterior/footer.php'); ?>


<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script> 
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js"></script> 
<script type="text/javascript" src="/assets/js/utils/underscore/underscore-min.js"></script> 
<script type="text/javascript" src="/assets/js/global.js"></script> 
<script type="text/javascript" src="/assets/js/jquery.easing.1.3.js"></script> 
<script type="text/javascript" src="/assets/js/jquery.selectbox-0.5.js"></script> 
<script type="text/javascript" src="/assets/js/jquery.cycle.all.js"></script> 
<script type="text/javascript" src="/assets/js/equalheights.js"></script> 
<script type="text/javascript" src="/assets/js/slider_accordion.js"></script> 
<script type="text/javascript" src="/assets/js/accordionImageMenu-0.4.js"></script> 
<script type="text/javascript" src="/assets/js/jquery.form.js"></script> 
<script type="text/javascript" src="/assets/js/jquery.validate.js"></script> 
<script type="text/javascript" src="/assets/js/script.js"></script>
<?= $_scripts; ?>
</body>
</html>
