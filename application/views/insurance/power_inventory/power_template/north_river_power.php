<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Power</title>
<meta name="viewport" content="width=device-width; initial-scale=1.0" />
<link href="/_assets/power_assets/css/north_river.css" type="text/css" rel="stylesheet" media="screen" />
<!-- General style -->

<!-- Fonts
================================================== -->
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,400,700' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Kreon:400,700,300' rel='stylesheet' type='text/css'>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.js"></script>
<script type="text/javascript">
$( document ).ready(function(e) {
	
	<? if( $role == 'sub_agent' ): ?>
		$( '#back' ).hide();
	<? endif; ?>
	$( '#print' ).click(function(){
		
		$( '#execute' ).hide();	
	<? if( $role == 'sub_agent' ): ?>
		$( '#back' ).show();
	<? endif; ?>
		
	});
});

</script>
<style>
div.executed{
	background: url(/_assets/power_assets/images/pattern_003.png) !important;
}

div.transfer{
	background:url(/_assets/power_assets/images/watermark-pattern-transfer.png) !important;	
}
div.rewrite{
	background:url(/_assets/power_assets/images/watermark-pattern-rewrite.png) !important;	
}
div.discharged{
	background:url(/_assets/power_assets/images/watermark-pattern-discharged.png) !important;	
}
div.judgement{
	background:url(/_assets/power_assets/images/watermark-pattern-judgement.png) !important;	
}
div.expired{
	background:url(/_assets/power_assets/images/watermark-pattern-expired.png) !important;	
}
div.forfeited{
	background:url(/_assets/power_assets/images/watermark-pattern-forfeited.png) !important;	
}

#appearance-wrapper{
	width:960px;
	margin: 30px auto;	
}
#appearance-wrapper .row{
	width:100%;
	margin:20px 0;
	clear: both;
	height: 100%;
	
}
#appearance-wrapper .col{
	float:left;
	width:45%;
	margin:0 10px;
}
#appearance-wrapper .col.last{
	float:right;
	text-align: right;	
}

#appearance-wrapper .col.last table{
	text-align: left;
}
#appearance-wrapper .col.center{
	margin:30px auto;
	float: none;
	text-align: center;
}

#appearance-wrapper p{
	padding-left:10px;
}
#appearance-wrapper td{
	padding:2px 0 2px 10px;
	font-size: 13px;
	text-transform: capitalize;
	
}
#appearance-wrapper h2{
	font-size:18px;
}
#appearance-wrapper h3{
	font-size:18px;
	line-height: 25px;
	margin: 20px 0;
}

#appearance-wrapper td:first-child{
	padding-left:0px;
}
.clr{ clear: both;}
</style>
</head>
<body>
<!---->
<div id="page_wrap">
	<div style="margin-top:8px;">
		<img src="/_assets/power_assets/images/logo.gif" width="270" height="44" border="0">
	</div>
	<div id="nav">
	</div>
	<br>
	<br>
	
	<div id="fullwidth">
		<div class="inside-wrap">
			<h2>&nbsp;</h2>
		</div>
		<div id="power" class="<?= $p[ 'power_status' ]; ?>">
			<div class="first">
				<small><strong>THE NORTH RIVER INSURANCE COMPANY</strong><br>
				10350 Richmond Ave., Suite 300 •&nbsp;Houston, TX 77042<br>
				P.O. Box 2807 • Houston, Texas 77252-2807<br>
				(713) 954-8100 &nbsp;&nbsp;&nbsp;&nbsp; (713) 954-8389 FAX</small>
			</div>
			
			<div class="second">
				<span class="header">POWER OF ATTORNEY</span>
			</div>
			
			<div class="third">
			<strong>POWER NO.</strong> <?= power_get_prefix( $p[ 'prefix_id' ] ); ?> <?= $p[ 'pek' ]; ?>
			<br>
			<strong>POWER AMMOUNT $</strong> <?= $p[ 'power_amount' ]; ?>
			</div><br clear="all">
			The Power of Attorney is granted pursuant to Article V of the By-Laws of THE NORTH RIVER INSURANCE COMPANY as now in full force and effect. Article V, Execution of Instruments- Except as the Board of Directors may authorize by resolution, the Chairman of the Board, President, any Vice-President, any Assistant Vice President, the Secretary, or any Assistant Secretary, or any Assistant Secretary shall have power on behalf of the Corporation: (a) to execute, affix the corporate seal manually or by facsimile to, acknowledge, verify and deliver any contracts, obligations, instruments and documents whatsoever in connection with its business, including, without limiting the foregoing, any bonds, guarantees, undertakings, recognizances, powers of attorney or revocations of any powers of attorney, stipulations, policies of insurance, deeds, leases, mortgages, releases, satisfactions and agency agreements; (b) to appoint, in writing, one or more persons for any or all of the purposes mentioned in the preceding paragraph (a), including affixing the seal of the Corporation. Authority of such Attorney-In-Fact is limited to appearance bonds and cannot be construed to guarantee defendant's future lawful conduct, adherence to travel limitation, fines, restitution, payments or penalties, or any other condition imposed by a court not specifically related to court appearance.<br>
			<br>
			
			<div class="note">
			This Power of Attorney is for use with Bail Bonds only. Not valid if used in connection with Federal Bonds or Immigration Bonds. The power void if altered or erased, void if used with other powers of this Company or in combination with powers from any other surety company, void if used to furnish bail in excess of the stated face amount of this power, and can only be used once.<br>
			<span class="blue">The obligation of the Company shall not exceed the sum of</span> &nbsp;<strong> <?= convert_number_to_words( preg_replace("/[^0-9]/","", number_format( str_replace('$','', $p[ 'power_amount' ]  ) ) ) ); ?> (
			<?= $p[ 'power_amount' ]; ?>
			
			) DOLLARS</strong><br>
			and provided this Power of Attorney is filed with the bond retained as a part of the court records. The said Attorney-In-Fact is hereby authorized to insert in this Power of Attorney the name of the person on whose behalf this bond was given.
			</div><br>
			IN WITNESS WHEREOF, THE NORTH RIVER INSURANCE COMPANY has caused these presents to be signed by it's duly authorized officer, proper for the purpose and its corporate seal to be hereunto affixed this <?= date('jS'); ?> day of <?= date('F'); ?>, <?= date('Y'); ?>.<br>
			
			<div class="fourth">
			Bond Amount $ &nbsp;&nbsp; <strong><?= $p[ 'bond_amount' ]; ?></strong> &nbsp;&nbsp;<br>
			Defendant: &nbsp;&nbsp; <strong><?= $p['defendant_first_name'] . ' ' . $p['defendant_last_name']; ?></strong><br>
			Charges &nbsp;&nbsp; <strong><?= $p[ 'charge' ]; ?></strong><br>
			Court &nbsp;&nbsp; <strong><?= $p[ 'court' ]; ?></strong><br>
			Case # &nbsp;&nbsp; <strong><?= $p[ 'case_number' ]; ?></strong><br>
			County &nbsp;&nbsp; &nbsp; <strong><?= $p[ 'county' ]; ?></strong> City &nbsp; <strong><?= $p[ 'city' ]; ?></strong> &nbsp; State &nbsp; <strong><?= $p[ 'state' ]; ?></strong> &nbsp;<br>
			Executing Agent &nbsp; <strong><?= $p[ 'executing_agent' ]; ?></strong>
			</div>
			
			<div class="fifth">
			<div id="expires-off">
			<small>Expiration Date: <strong><?= $p[ 'exp_date'] ?></small></strong><br>
			</div>
			
			<div style="margin-top:20px;"><img src="/_assets/power_assets/images/north-river-seal-signature.png" width="390" border="0"></div>
			</div>
			
		</div>
	</div>	
</div>
<!--end:page_wrap-->

<footer>
	<div id="footer_wrap">
		<div class="copy_right">
			<p>
				North River Corporation | Bail Commerce
			</p>
		</div>
	</div>
	<!--end:footer_wrap--> 
</footer>
<!--end:footer-->
</body>
</html>




	
	
	
	
	
	
	
	
