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

.polaroid {
  position: relative;
  width: 220px;
  z-index: 1000;

}
 
.polaroid img {
  border: 10px solid #fff;
  border-bottom: 85px solid #fff;
-moz-box-shadow: 0 0 5px 5px #888;
-webkit-box-shadow: 0 0 5px 5px#888;
box-shadow: 0 0 5px 5px #888;
}
 
.polaroid h3 {
  position: absolute;
  text-align: center;
  width: 100%;
  bottom: 30px;
  font: 400 24px/1 'Kreon', cursive;
  color: #888;
  line-height:25px;
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
		<img src="/_assets/power_assets/images/logo.gif" width="270" height="44" border="0" >
	</div>
	<div id="nav">
	</div>
	<br>
	<br>
	<div align="center">
		<button onClick="location.href = '/jail/transmissions/<?= $view; ?>';">Back To Inventory</button>
	</div>
	<div align="center" style="position:fixed; top:0; right:30px; z-index:-1">
		<div class="polaroid">
		  	<h3>AGENT PHOTO: <br><?= $agent['full_name']; ?></h3>
			<img src="/uploads/images/<?= $power[ 'photo' ]; ?>" border="0" class="photo" />
		</div>
	</div>
	


	
	<div id="fullwidth">
		<div class="inside-wrap">
			<h2>&nbsp;</h2>
		</div>
		<div id="power" class="<?= $power[ 'key' ]; ?>">
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
			<strong>POWER NO.</strong> <?= power_get_prefix( $power[ 'prefix_id' ] ); ?> <?= $power[ 'pek' ]; ?>
			<br>
			<strong>POWER AMMOUNT $</strong> <?= $power[ 'power_amount' ]; ?>
			</div><br clear="all">
			The Power of Attorney is granted pursuant to Article V of the By-Laws of THE NORTH RIVER INSURANCE COMPANY as now in full force and effect. Article V, Execution of Instruments- Except as the Board of Directors may authorize by resolution, the Chairman of the Board, President, any Vice-President, any Assistant Vice President, the Secretary, or any Assistant Secretary, or any Assistant Secretary shall have power on behalf of the Corporation: (a) to execute, affix the corporate seal manually or by facsimile to, acknowledge, verify and deliver any contracts, obligations, instruments and documents whatsoever in connection with its business, including, without limiting the foregoing, any bonds, guarantees, undertakings, recognizances, powers of attorney or revocations of any powers of attorney, stipulations, policies of insurance, deeds, leases, mortgages, releases, satisfactions and agency agreements; (b) to appoint, in writing, one or more persons for any or all of the purposes mentioned in the preceding paragraph (a), including affixing the seal of the Corporation. Authority of such Attorney-In-Fact is limited to appearance bonds and cannot be construed to guarantee defendant's future lawful conduct, adherence to travel limitation, fines, restitution, payments or penalties, or any other condition imposed by a court not specifically related to court appearance.<br>
			<br>
			
			<div class="note">
			This Power of Attorney is for use with Bail Bonds only. Not valid if used in connection with Federal Bonds or Immigration Bonds. The power void if altered or erased, void if used with other powers of this Company or in combination with powers from any other surety company, void if used to furnish bail in excess of the stated face amount of this power, and can only be used once.<br>
			<span class="blue">The obligation of the Company shall not exceed the sum of</span> &nbsp;<strong> <?= convert_number_to_words( preg_replace("/[^0-9]/","", number_format( str_replace('$','', $power[ 'power_amount' ]  ) ) ) ); ?> (
			<?= $power[ 'power_amount' ]; ?>
			
			) DOLLARS</strong><br>
			and provided this Power of Attorney is filed with the bond retained as a part of the court records. The said Attorney-In-Fact is hereby authorized to insert in this Power of Attorney the name of the person on whose behalf this bond was given.
			</div><br>
			IN WITNESS WHEREOF, THE NORTH RIVER INSURANCE COMPANY has caused these presents to be signed by it's duly authorized officer, proper for the purpose and its corporate seal to be hereunto affixed this <?= date('jS'); ?> day of <?= date('F'); ?>, <?= date('Y'); ?>.<br>
			
			<div class="fourth">
			Bond Amount $ &nbsp;&nbsp; <strong><?= $power[ 'bond_amount' ]; ?></strong> &nbsp;&nbsp; <br>
			Defendant: &nbsp;&nbsp; <strong><?= $power['defendant_first_name'] . ' ' . $power['defendant_last_name']; ?></strong><br>
			Charges &nbsp;&nbsp; <strong><?= $power[ 'charge' ]; ?></strong><br>
			Court &nbsp;&nbsp; <strong><?= $power[ 'court' ]; ?></strong><br>
			Case # &nbsp;&nbsp; <strong><?= $power[ 'case_number' ]; ?></strong><br>
			County &nbsp;&nbsp; &nbsp; <strong><?= $power[ 'county' ]; ?></strong> City &nbsp; <strong><?= $power[ 'city' ]; ?></strong> &nbsp; State &nbsp; <strong><?= $power[ 'state' ]; ?></strong> &nbsp;<br>
			Executing Agent &nbsp; <strong><?= $power[ 'executing_agent' ]; ?></strong>
			</div>
			
			<div class="fifth">
			<div id="expires-off">
			<small>Expiration Date: <strong><?= $power['exp_date'] ?></strong></small><br>
			</div>
			
			<div style="margin-top:20px;"><img src="/_assets/power_assets/images/north-river-seal-signature.png" width="390" border="0"></div>
			</div>
			
			
			
		</div>
	</div>	


	<div class="inside-wrap">
		<h2>&nbsp;</h2>
	</div>
	
	
	
	<div id="appearance-wrapper">
		<div class="row">
			<div class="col">
				<h2>APPEARANCE BOND</h2>
				<table>
					<tr>
						<td>POWER:</td>
						<td><strong><?= power_get_prefix( $power[ 'prefix_id' ] ); ?> <?= $power[ 'pek' ]; ?></strong></td>
					</tr>
					<tr>
						<td>ARREST:</td>
						<td><strong><?= $power[ 'case_number' ]; ?></strong></td>						
					</tr>
				</table>		
			</div>
			<div class="col last" style="width:266px">
				<h2>SEND ALL COURT NOTICES TO:</h2>
				<table>
					<tr>
						<td>				
							<strong><?= $power[ 'executing_agent' ]; ?></strong><br>
							<?= $agent['address']; ?><br>
							<?= $agent['city']; ?> <?= $agent['state']; ?> <?= $agent['zip']; ?>						
						</td>
					</tr>
				</table>						
			</div>
		</div>
		<div class="clr"></div>
		<div class="row">
			<div class="col center">
			<h3>
				STATE OF FLORIDA<br />
				VS<br />
				<?= $power['defendant_first_name'] . ' ' . $power['defendant_last_name']; ?>
			</h3>
			</div>		
		</div>
				<div class="clr"></div>

		<div class="row">
			<div class="col">
				<table>
					<tr>
						<td><?= $power[ 'court' ]; ?></strong> COURT</td>
					</tr>
					<tr>							
						<td><?= $power[ 'county' ]; ?></strong> COUNTY</td>
					</tr>
					<tr>
						<td>STATE OF FLORIDA</td>
					</tr>	
				</table>			
			</div>
			<div class="col last" style="width:266px">
				<table>
					<tr>
						<td nowrap="">Court Room:</td>
						<td>_______________________</td>
					</tr>
					<tr>
						<td>Time:</td>
						<td>_______________________</td>
					</tr>	
				</table>
			</div>
		</div>
				<div class="clr"></div>

		<div class="row">
			<p><strong>KNOW ALL MEN BY THESE PRESENTS:</strong> That we the above named defendant as principals, and The North River Insurance Company, a New Jersey Corporation, surety are held and firmly bound unto the Governor of the State of Florida, and his successors in office, the said principal, in the sum of <br />$ _________________ and the said surety for the life amount, for the payment whereof well and truly to be made we bind ourselves, our heirs, executors, administrators and assigns firmly by these presents.
			</p>
		
			<p>
			Signed and sealed this ___________________________________ day of ___________________________________ A.D.. ___________________________________<br />
			The condition of this obligation is such that if said principal shall appear on ___________________________________ at the next Regular or Special term of the above court and shall submit to the said Court to answer a charge of:<br />
			___________________________________<br />
			and shall submit to orders and process of said court and not depart the same without leave, then this obligation to be void, else to remain in full force and virtue.
			
			</p>
		</div>
		<div class="row">
			<div class="col">
				<table>
					<tr>
						<td colspan="2">
							<h3>TAKEN BEFORE ME AND APPROVED BY ME:</h3>			
						</td>		
					</tr>
					<tr>
						<td>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							_____________________________ Sheriff
						</td>	
					</tr>
					<tr><td><br /></td></tr>
					<tr>
						<td colspan="2">
							By _____________________________ D.S		
						</td>
					</tr>
					<tr><td><br /></td></tr>
					<tr>
						<td colspan="2">
						
							<div style="float:left;text-align:center; font-size: 13px; line-height:14px;">
								<small>
								<strong>THE NORTH RIVER INSURANCE COMPANY</strong><br />
								10350 Richmond Ave., Suite 300 • Houston, TX 77042<br />P.O. Box 2807 • Houston, Texas 77252-2807<br />
								(713) 954-8100 &nbsp;&nbsp;&nbsp;&nbsp; (713) 954-8389 FAX
								</small>
							</div>
						
						</td>
					</tr>
				</table>	
			</div>
			<div class="col last" style="width:266px">
				<table>
					<tr>
						<td colspan="2">
							<h3>&nbsp;</h3>			
						</td>		
					</tr>
					<tr>
						<td>___________________________________ (L.S.)</td>
					</tr>
					<tr>
						<td colspan="2"><span>(Principal) <strong>THE NORTH RIVER INSURANCE COMPANY</strong></span></td>
					</tr>	
										<tr><td colspan="2"><br /></td></tr>

					<tr>
						<td>___________________________________ (L.S.)</td>
					</tr>
					<tr>
						<td colspan="2"><span>(ATTORNEY-IN-FACT SURETY)</span></td>
					</tr>	
					<tr><td colspan="2ds"><br /></td></tr>
					<tr>
						<td>
							Agent number or license number:
						</td>
						<td>
							 <strong><?= $power[ 'license_number' ]; ?></strong><br />
						</td>
					</tr>
					<tr>
						<td>	
							Print agent name: 
						</td>
						<td>	
							<strong><?= $power[ 'executing_agent' ]; ?></strong><br />
						</td>
					</tr>	
				</table>
			</div>
		</div>
		<div class="clr"></div>
		<br clear="all"/>
		<div class="row">
			<div style="border: 2px solid #0073a0; padding:10px 5px 10px 5px; text-align:center; font-size:38px; font-weight:bold; color:#0073a0;">
				COURT COPY
			</div>
		</div>
	</div>
	
	
	
	
	
	
	
	
	
	
	
	<div class="one-half first">
		<h2>SEND TO:</h2>
		<p>
				<strong><?= $power[ 'executing_agent' ]; ?></strong><br>
				<?= $agent['address']; ?><br>
				<?= $agent['city']; ?> <?= $agent['state']; ?> <?= $agent['zip']; ?>
		</p>
	</div>

	<div class="one-half" style="text-align:center; font-size: 14px; line-height:15px;">
		<small>
		<strong>THE NORTH RIVER INSURANCE COMPANY</strong><br />
		10350 Richmond Ave., Suite 300 • Houston, TX 77042<br />P.O. Box 2807 • Houston, Texas 77252-2807<br />
		(713) 954-8100 &nbsp;&nbsp;&nbsp;&nbsp; (713) 954-8389 FAX
		</small>
	</div>


	<div class="inside-wrap-two" style="text-align:center; font-size:21px; font-weight:700;">
		CERTIFICATE OF DISCHARGE OF BOND
	</div>
	
	<div class="inside-wrap">
	
		<p>Case Number <?= $power[ 'case_number' ]; ?>&nbsp; Bond Amount &nbsp; <?= $power[ 'bond_amount' ]; ?>&nbsp; Power No. &nbsp; <?= power_get_prefix( $power[ 'prefix_id' ] ); ?> <?= $power[ 'pek' ]; ?><br />
			Defendant &nbsp; ___________________________________ &nbsp; court<br />
			This is to certify that on or about the Power No. &nbsp; <?= power_get_prefix( $power[ 'prefix_id' ] ); ?> <?= $power[ 'pek' ]; ?>&nbsp; day of &nbsp; ___________________________________ &nbsp; I examined the records of &nbsp; Power No. &nbsp; <?= power_get_prefix( $power[ 'prefix_id' ] ); ?> <?= $power[ 'pek' ]; ?> &nbsp; and found that the bond with corresponding power number has been discharged of record by reason of the following disposition &nbsp; ___________________________________ &nbsp; Person rendering decision &nbsp; ___________________________________ &nbsp; Date of Discharge &nbsp; 
			___________________________________ , &nbsp; Witness my hand and official seal this day &nbsp; ___________________________________ , &nbsp; ___________________________________ &nbsp; Title &nbsp; ___________________________________
		</p>
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
