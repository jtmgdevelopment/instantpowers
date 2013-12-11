<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Power</title>
<meta name="viewport" content="width=device-width; initial-scale=1.0" />
<link href="/_assets/power_assets/css/style.css" type="text/css" rel="stylesheet" media="screen" />
<!-- General style -->

<!-- Fonts
================================================== -->
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,400,700' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Kreon:400,700,300' rel='stylesheet' type='text/css'>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.js"></script>
<style type="text/css">
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
	<div align="center">
		<? if( ! isset( $hide ) ): ?><button onClick="location.href = '/insurance/power_inventory/process_bail_bonds_agency/inventory/<?= $bail_agency; ?>';">Back To Inventory</button><? endif; ?>
	</div>
	<div id="fullwidth">
		<div class="inside-wrap">
			<h2>&nbsp;</h2>
		</div>
		<div id="power-top">
			The face of this document has a colored security background and microprinting
		</div>
		<div id="power" class="<?= $power[ 'key' ]; ?>">
			<div class="first">
				<span class="title">POWER AMOUNT<br />
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<?= $power[ 'power_amount' ]; ?>
				</span>
			</div>
			<div class="second">
				<strong>POWER OF ATTORNEY</strong><br />
				<span class="header">PALMETTO SURETY CORPORATION</span><br>
				<small>126 Seven Farms Drive, Suite 170, Charleston, SC 29492</small>
			</div>
			<div class="third">
				<span class="title">
					<?= $power[ 'prefix' ]; ?>
				</span> 
				<span class="number">
					<?= $power[ 'pek' ]; ?>
				</span>
			</div>
			<br clear="all">
			KNOW ALL MEN BY THESE PRESENTS: that PALMETTO SURETY CORPORATION, a corporation duly authorized and existing under the laws of the State of South Carolina does constitute and appoint the below named agent its true and lawful Attorney-In-Fact for it and in its name, place and stead, to execute, and deliver for and on its behalf, as surety, a bail bond only. <br />
			<span class="blue"> Authority of such Attorney-In-Fact is limited to appearance bonds. No authority is provided herein for the execution of surety immigration bonds or to gurantee alimony payments, fines, wage law claims or other payments of any kind on behalf of below named defendant. The named agent is appointed only to execute the bond consistent with the terms of this power of attorney. The agents is not authorized to act as agent for receipt of service of process in any criminal or civil action. This power is void if altered or erased or used in any combination with other powers of attorney of this company or any other company to obtain the release of the defendant named below or to satisfy any bond requirement in excess of the stated face amount of this power. This power can only be used once. The obligation of the company shall not exceed the sum of </span> <br />
			<br />
			<div style="text-transform:uppercase; color:#0071AC; text-align:center;">
			<?= convert_number_to_words( preg_replace("/[^0-9]/","", number_format( str_replace('$','', $power[ 'power_amount' ]  ) ) ) ); ?>
			(
			<?= $power[ 'power_amount' ]; ?>
			
			) DOLLARS <br />
			</div> and provided this Power-Of-Attorney is filed with the bond and retained as a part of the court records. The said Attorney-In-Fact is hereby authorized to insert in this Power-Of-Attorney the name of the person on whose behalf this bond was given. <br />
			IN WITNESS WHEREOF, PALMETTO SURETY CORPORATION has caused these presents to be signed by it's duly authorized officer, proper for the purpose and its corporate seal to be hereunto affixed this <span class="blue">
			<?= date('jS'); ?>
			</span> day of <span class="blue">
			<?= date('F'); ?>
			</span>.
		</div>
		<div class="one-half-two first">
			<p>
				<label style="width:120px; display:inline-block;">Bond Amount:</label>
				&nbsp;&nbsp; <strong>$
				<?= $power[ 'bond_amount' ]; ?>
				</strong><br />
				<label style="width:120px; display:inline-block;">Defendant:</label>
				&nbsp;&nbsp; <strong>
				<?= $power['defendant_first_name'] . ' ' . $power['defendant_last_name']; ?>
				</strong><br />
				<label style="width:120px; display:inline-block;">Court:</label>
				&nbsp;&nbsp; <strong>
				<?= $power[ 'court' ]; ?>
				</strong><br />
				<label style="width:120px; display:inline-block;">Case #:</label>
				&nbsp;&nbsp; <strong>
				<?= $power[ 'case_number' ]; ?>
				</strong><br />
				<label style="width:120px; display:inline-block;">County:</label>
				&nbsp;&nbsp; <strong>
				<?= $power[ 'county' ]; ?>
				</strong><br>
				<label style="width:120px; display:inline-block;">City</label>
				&nbsp; &nbsp; <strong>
				<?= $power[ 'city' ]; ?>
				</strong><br>
				<label style="width:120px; display:inline-block;">State</label>
				&nbsp; &nbsp; <strong>
				<?= $power[ 'state' ]; ?>
				</strong><br>
				<label style="width:120px; display:inline-block;">Offense:</label>
				&nbsp; <strong>
				<?= $power[ 'charge' ]; ?>
				</strong><br />
				<label style="width:120px; display:inline-block;">Executing Agent:</label>
				&nbsp; <strong>
				<?= $power[ 'executing_agent' ]; ?>
				</strong><br />
			</p>
		</div>
		<div class="one-half-three">
			<div id="expires">
				Expires
				<?= $power[ 'exp_date' ] ?>
			</div>
			<div style="margin-top:20px;">
				<img src="/_assets/power_assets/images/seal-signature.png" width="330" height="140" border="0">
			</div>
			<br clear="all">
		</div>
		
	</div>
	<? if( ! isset( $hide ) ): ?>
	<br clear="all">
	<div style="border-top:3px dashed red; height:4px; width:70%; margin:0 auto;"></div>
	<!--end:fullwidth--> 
	<br clear="all" />
	<div id="fullwidth">
		<div class="inside-wrap">
			<h2>&nbsp;</h2>
		</div>
		<div class="one-half first">
			<h2>Palmetto Surety Corporation<br />
				126 Seven Farms Drive, Suite 170<br />
				Charleston, SC 29492</h2>
			<h4><strong>General Surety Appearance Bond</strong></h4>
			<p>
				POWER #&nbsp;&nbsp; <strong><?= power_get_prefix( $power[ 'prefix_id' ] ); ?><?= $power[ 'amount' ] ?> <?= $power[ 'pek' ]; ?></strong>
				<br />
				ARREST #&nbsp; <strong><?= $power[ 'case_number' ]; ?></strong>
			</p>
		</div>
		<div class="one-half">
			<h2>For Further Action On This Bond Notify:</h2>
			<p>
				<strong><?= $power[ 'agency_name' ]; ?></strong><br>

				<strong><?= $power[ 'agent_first_name' ] . ' ' . $power[ 'agent_last_name' ]; ?></strong><br>
				<?= $power[ 'address' ]; ?><br>
				<?= $power[ 'city' ]; ?> <?= $power[ 'state' ]; ?> <?= $power[ 'zip' ]; ?>
			</p>
			<br clear="all">
		</div>
		<div class="" style="clear:both;">
			<div style=" text-align:center;">
				<h4 style="font-size:20px;"><strong>STATE OF FLORIDA</strong></h4>
				<div style="font-size:16px;" style="text-align:center">VS</div>
				<h4 style="font-size:20px; margin-top:10px">
					<strong><?= $power['defendant_first_name'] . ' ' . $power['defendant_last_name']; ?></strong>
				</h4>
	
	
			</div>
		</div>
		<div class="">
			<div style=" font-size:13px;">
				IN THE <strong><?= $power[ 'court' ]; ?> Court</strong><br>
				<strong><?= $power[ 'county' ]; ?></strong> County, STATE OF FLORIDA
			</p>
			</div>
		</div>
		<div class="inside-wrap">
			<p>
				KNOW ALL MEN BY THESE PRESENT: That we the above named defendant as principal, and PALMETTO SURETY CORPORATION, a SOUTH CAROLINA CORPORATION, surety are held and firmly bound unto the Governor of the State of Florida, and his successors in office, the said principal, in the sum of $<strong><?= $power[ 'bond_amount' ]; ?></strong> and the said surety for the life amount, for the payment whereof well and truly to be made we bind ourselves, our heirs, executors, administrators and assigns firmly by these presents.
			</p>
			<p>
				Signed and sealed this <strong><?= date('jS'); ?> day of <?= date('F'); ?> A.D.. <?= date('Y'); ?></strong>
				<br />
				The condition of this obligation is such that if said principal shall appear on <strong><? if( strlen( $power[ 'court_date' ] ) ): ?><?= $power[ 'court_date' ]; ?><? else: ?>___________________<? endif; ?></strong>
				at the next Regular or Special term of the above court and shall submit to the said Court to answer a charge of: <strong><?= $power[ 'charge' ]; ?></strong>; and shall submit to orders and process of said court and not depart the same without leave, then this obligation to be void, else to remain in full force and virtue.
			</p>
		</div>
		<div class="one-half first">
			<h4>Taken Before Me And Approved By Me:</h4>
			<p>
				By _________________________________________ <br>
				<em>Sheriff</em>
			</p>
			<p>
				By _________________________________________ <br>
				<em>D.S</em>
			</p>
		</div>
		<div class="one-half" style="background-image:url(/_assets/power_assets/images/bg-seal-palmetto.png);">
			<p>
				_________________________________________ (L.S.)<br>
				<em>(Principal) PALMETTO SURETY CORPORATION</em> <br />
				By <strong><?= $power[ 'agent_first_name' ] . ' ' . $power[ 'agent_last_name' ]; ?></strong>
				<br />
				<em>(Attorney in fact) (SURETY)</em> <br />
				Agent number or license number: <strong><?= $power[ 'license_number' ]; ?></strong>

				<br />
				<strong><?= $power[ 'agent_first_name' ] . ' ' . $power[ 'agent_last_name' ]; ?></strong>
				<br />
			</p>
		</div>
		<div class="inside-wrap-three" style="border: 2px solid #0073a0; padding:10px 5px 10px 5px; text-align:center; font-size:14px; font-weight:bold; color:#0073a0;">
			This bond not valid for deferred sentence, fines, pre-sentence investigation, pre-trial intervention programs or appeals.
		</div>
		<div class="inside-wrap-two" style="text-align:center;">
			<h4>STATEMENT<br />
				The Undersigned </h4>
		</div>
		<div class="inside-wrap">
			<p>
				I,
				______________________________________
				am a duly licensed bail bondsman pursuant to Chapter 903, Florida Statue, or a duly licensed general lines agent pursuant to part 11 Chapter 626, Florida Statute, and have registered for the current year with the office of the Sheriff and Clerk of the Circuit Court of the aforesaid county and have filed A certified copy of my appointment by Power of Attorney for the surety with office of the Sheriff and Clerk of the Circuit Court of the aforementioned County that the principal named in the foregoing bond, a Address:<br />

				____________________________________________________________________________<br>
				____________________________________________________________________________<br>
				____________________________________________________________________________
				<br /><br>
				has (given or promised to give) the sum of ______________________________________ ______________________________________ 
				

				together with the (promise or receipt) of security belonging to: ______________________________________

				<br />
				As follows. (Detail description of Property)

				____________________________________________________________________________<br>
				____________________________________________________________________________<br>
				____________________________________________________________________________<br>
				<br />
				That a duly signed receipt has been given to the said principal for the consideration given and/or that the said indemnitor has (also been) given a receipt for the security described above.
			</p>
			<p>
				(Bondsman)
				______________________________________
	
				<br />
				(Agency) ______________________________________

			</p>
		</div>
	</div>
	<? endif; ?>
	<!--end:fullwidth-->
	<br clear="all">
	<div style="border-top:3px dashed red; height:4px; width:70%; margin:0 auto;">
	</div>
</div>
<!--end:page_wrap-->

<footer>
	<div id="footer_wrap">
		<div class="copy_right">
			<p>
				Palmetto Surety Corporation | Bail Commerce
			</p>
		</div>
	</div>
	<!--end:footer_wrap--> 
</footer>
<!--end:footer-->
</body>
</html>
