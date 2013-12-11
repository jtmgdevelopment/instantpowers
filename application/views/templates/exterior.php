<!DOCTYPE html>
<html>
<head>
<link href="/assets/css/framework/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="/assets/css/framework/reset.css" rel="stylesheet" type="text/css" />
<link href="/assets/css/framework/normalize.css" rel="stylesheet" type="text/css" />
<link href="/assets/css/main_style.css" rel="stylesheet" type="text/css" />
<link href="/assets/css/superfish.css" rel="stylesheet" type="text/css" />
<link href="/assets/css/buttons/btn.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/assets/js/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="/assets/js/jquery.cycle.all.js"></script>
<script type="text/javascript" src="/assets/js/jquery.easing.1.3.js"></script>
<script type="text/javascript" src="/assets/js/twitter.js"></script>
<script type="text/javascript" src="/assets/js/hoverIntent.js"></script>
<script type="text/javascript" src="/assets/js/supersubs.js"></script>
<script type="text/javascript" src="/assets/js/superfish.js"></script>
<script type="text/javascript" src="/assets/js/script.js"></script>
<script type="text/javascript" src="/assets/js/global.js"></script>
<link rel="shortcut icon" href="/assets/images/favicon.ico"/>
<title>Instant Powers | Powered by Bail Commerce</title>
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-28170280-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
<meta charset="UTF-8">
</head>

<body>
<? $this->load->view('includes/exterior/header.php'); ?>
<? if($this->session->flashdata('message')): ?>
<div class="mc-msg <?= $this->session->flashdata('message_type'); ?>">
	<?= $this->session->flashdata('message'); ?>
</div>
<? endif; ?>
<?=$errors?>
<?= $content; ?>
<? $this->load->view('includes/exterior/footer.php'); ?>
