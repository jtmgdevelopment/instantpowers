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
<script type="text/javascript">
$( document ).ready(function(e) {
	
	<? if( $role == 'sub_agent' ): ?>
		$( '#back' ).hide();
	<? endif; ?>
	$( '#print' ).click(function(){
		$( '#back' ).text( 'Home' );
		$( '#execute, #edit, #print' ).hide();	
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
		<? if( $role == 'master_agent' ): ?>
			<button id="back" onClick="location.href = '/agent/create_powers/summary/<?= $trans_id; ?>/<?= $power_id; ?>';">Back To Transmission</button>
		<? else: ?>
			<button id="back" onClick="location.href = '/agent/power_inventory';">Back To Transmission</button>
		
		<? endif; ?>
		<button id="edit" onClick="location.href = '/agent/create_powers/edit_powers_list/<?= $trans_id; ?>/<?= $power_id; ?>';">Edit Powers</button>

		<button id="execute" onClick="location.href = '/agent/create_powers/execute_power/<?= $trans_id; ?>/<?= $power_id; ?>';">Execute Power</button>
		<button id="print" onClick="window.open( '/agent/create_powers/print_power/<?= $trans_id; ?>/<?= $power_id; ?>/<?= $filename; ?>', '_blank' );">Print Power</button>
	</div>
	<p>
		<em>By <strong>PRINTING</strong> the powers you will be executing the powers as offline powers. </em>
	</p>
	
 	<? foreach( $parsed_powers as $p ): ?>
	
	<div id="fullwidth">
		<div class="inside-wrap">
			<h2>&nbsp;</h2>
		</div>
		<div id="power-top">
			The face of this document has a colored security background and microprinting
		</div>
		<div id="power" class="<?= $p[ 'power_status' ]; ?>">
			<div class="first">
				<span class="title">POWER AMOUNT<br />
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<?= $p[ 'power_amount' ]; ?>
				</span>
			</div>
			<div class="second">
				<strong>POWER OF ATTORNEY</strong><br />
				<span class="header">PALMETTO SURETY CORPORATION</span><br>
				<small>109 River Landing Dr., Suite 200, Charleston, SC 29492-7595</small>
			</div>
			<div class="third">
				<span class="title">
					<?= power_get_prefix( $p[ 'prefix_id' ] ); ?>
				</span> 
				<span class="number">
					<?= $p[ 'pek' ]; ?>
				</span>
			</div>
			<br clear="all">
			KNOW ALL MEN BY THESE PRESENTS: that PALMETTO SURETY CORPORATION, a corporation duly authorized and existing under the laws of the State of South Carolina does constitute and appoint the below named agent its true and lawful Attorney-In-Fact for it and in its name, place and stead, to execute, and deliver for and on its behalf, as surety, a bail bond only. <br />
			<span class="blue"> Authority of such Attorney-In-Fact is limited to appearance bonds. No authority is provided herein for the execution of surety immigration bonds or to gurantee alimony payments, fines, wage law claims or other payments of any kind on behalf of below named defendant. The named agent is appointed only to execute the bond consistent with the terms of this power of attorney. The agents is not authorized to act as agent for receipt of service of process in any criminal or civil action. This power is void if altered or erased or used in any combination with other powers of attorney of this company or any other company to obtain the release of the defendant named below or to satisfy any bond requirement in excess of the stated face amount of this power. This power can only be used once. The obligation of the company shall not exceed the sum of </span> <br />
			<br />
			<div style="text-transform:uppercase; color:#0071AC; text-align:center;">
			<?= convert_number_to_words( preg_replace("/[^0-9]/","", number_format( str_replace('$','', $p[ 'power_amount' ]  ) ) ) ); ?>
			(
			<?= $p[ 'power_amount' ]; ?>
			
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
				<?= $p[ 'bond_amount' ]; ?>
				</strong><br />
				<label style="width:120px; display:inline-block;">Defendant:</label>
				&nbsp;&nbsp; <strong>
				<?= $parsed_defendant['first_name'] . ' ' . $parsed_defendant['last_name']; ?>
				</strong><br />
				<label style="width:120px; display:inline-block;">Court:</label>
				&nbsp;&nbsp; <strong>
				<?= $p[ 'court' ]; ?>
				</strong><br />
				<label style="width:120px; display:inline-block;">Case #:</label>
				&nbsp;&nbsp; <strong>
				<?= $p[ 'case_number' ]; ?>
				</strong><br />
				<label style="width:120px; display:inline-block;">County:</label>
				&nbsp;&nbsp; <strong>
				<?= $p[ 'county' ]; ?>
				</strong><br>
				<label style="width:120px; display:inline-block;">City</label>
				&nbsp; &nbsp; <strong>
				<?= $p[ 'city' ]; ?>
				</strong><br>
				<label style="width:120px; display:inline-block;">State</label>
				&nbsp; &nbsp; <strong>
				<?= $p[ 'state' ]; ?>
				</strong><br>
				<label style="width:120px; display:inline-block;">Offense:</label>
				&nbsp; <strong>
				<?= $p[ 'charge' ]; ?>
				</strong><br />
				<label style="width:120px; display:inline-block;">Executing Agent:</label>
				&nbsp; <strong>
				<?= $sp[ 'executing_agent' ]; ?>
				</strong><br />
			</p>
		</div>
		<div class="one-half-three">
			<div id="expires">
				Expires
				<?= $transmission->exp_date ?>
			</div>
			<div style="margin-top:20px;">
				<img src="/_assets/power_assets/images/seal-signature.png" width="330" height="140" border="0">
			</div>
			<br clear="all">
		</div>
		
	</div>
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
				109 River Landing Dr., Suite 200<br />
				Charleston, SC 29492-7595</h2>
			<h4><strong>General Surety Appearance Bond</strong></h4>
			<p>
				POWER #&nbsp;&nbsp; <strong><?= power_get_prefix( $p[ 'prefix_id' ] ); ?><?= $p[ 'pek' ]; ?></strong>
				<br />
				ARREST #&nbsp; <strong><?= $p[ 'case_number' ]; ?></strong>
			</p>
		</div>
		<div class="one-half">
			<h2>For Further Action On This Bond Notify:</h2>
			<p>
				<strong><?= $agent->agency_name; ?></strong><br>

				<strong><?= $sp[ 'executing_agent' ]; ?></strong><br>
				<?= $agent->address; ?><br>
				<?= $agent->city; ?> <?= $agent->state; ?> <?= $agent->zip; ?><br />
				<?= $agent->phone; ?>
			</p>
			<br clear="all">
		</div>
		<div class="" style="clear:both;">
			<div style=" text-align:center;">
				<h4 style="font-size:20px;"><strong>STATE OF FLORIDA</strong></h4>
				<div style="font-size:16px;" style="text-align:center">VS</div>
				<h4 style="font-size:20px; margin-top:10px">
					<strong><?= $parsed_defendant['first_name'] . ' ' . $parsed_defendant['last_name']; ?></strong>
				</h4>
	
	
			</div>
		</div>
		<div class="">
			<div style=" font-size:13px;">
				IN THE <strong><?= $p[ 'court' ]; ?> Court</strong><br>
				<strong><?= $p[ 'county' ]; ?></strong> County, STATE OF FLORIDA
			</p>
			</div>
		</div>
		<div class="inside-wrap">
			<p>
				KNOW ALL MEN BY THESE PRESENT: That we the above named defendant as principal, and PALMETTO SURETY CORPORATION, a SOUTH CAROLINA CORPORATION, surety are held and firmly bound unto the Governor of the State of Florida, and his successors in office, the said principal, in the sum of $<strong><?= $p[ 'bond_amount' ]; ?></strong> and the said surety for the life amount, for the payment whereof well and truly to be made we bind ourselves, our heirs, executors, administrators and assigns firmly by these presents.
			</p>
			<p>
				Signed and sealed this <strong><?= date('jS'); ?> day of <?= date('F'); ?> A.D.. <?= date('Y'); ?></strong>
				<br />
				The condition of this obligation is such that if said principal shall appear on <strong><? if( strlen( $p[ 'court_date' ] ) ): ?><?= $p[ 'court_date' ]; ?><? else: ?>___________________<? endif; ?></strong>
				at the next Regular or Special term of the above court and shall submit to the said Court to answer a charge of: <strong><?= $p[ 'charge' ]; ?></strong>; and shall submit to orders and process of said court and not depart the same without leave, then this obligation to be void, else to remain in full force and virtue.
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
				By <strong><?= $sp[ 'executing_agent' ]; ?></strong>
				<br />
				<em>(Attorney in fact) (SURETY)</em> <br />
				Agent number or license number: <strong><?= $agent->license_number; ?></strong>

				<br />
				<strong><?= $agent->full_name; ?></strong>
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
				(Bondsman) <?= $sp[ 'executing_agent' ]; ?>
	
				<br />
				(Agency) <?= $agent->company; ?>

			</p>
		</div>
	</div>
	<!--end:fullwidth-->
	<br clear="all">
	<div style="border-top:3px dashed red; height:4px; width:70%; margin:0 auto;">
	</div>
	<br clear="all">
	<div id="fullwidth">
		<div class="inside-wrap">
			<h2 align="center">PALMETTO SURETY CORPORATION</h2>
			<table width="100%">
				<tr>
					<td align="center"><strong><?= $p[ 'power_amount' ] ?></strong></td><td  align="center"><strong>BAIL BOND DEPARTMENT</strong></td><td align="center"><strong><?= power_get_prefix( $p[ 'prefix_id' ] ); ?><?= $p[ 'pek' ]; ?></strong></td>
				</tr>
				<tr>
					<td align="center">&nbsp;</td><td  align="center">109 River Landing Dr., Suite 200, Charleston, SC 29492</td><td align="center">&nbsp;</td>
				</tr>
				<tr>
					<td colspan="3">&nbsp;</td>
				</tr>	
				<tr>
					<td colspan="3" align="center"><h1 style="font-size:24px;"><strong>CERTIFICATE OF DISCHARGE BOND</strong></h1></td>
				</tr>	
			</table>		
			<p>
				This is to certify that on or about the <strong><?= date('jS'); ?> day of <?= date('F'); ?> <?= date('Y'); ?></strong>, 
				
				I examined the records ____________________________________________________________ Court and found that the bond with corresponding power number above has been discharged of record by reason of the following disposition: 	
			</p>
			<table width="100%" align="center">
				<tr>
					<td align="center"><p>[  ]  Plead Guilty</p></td>
					<td align="center"><p>[  ]  Found Guilty</p></td>
					<td align="center"><p>[  ] Case Dismissed</p></td>
					<td align="center"><p>[  ] Forfeiture Paid</p></td>
				</tr>
			</table>	
			<p>
					Other ____________________________________________________________________________________________________________
					
					Date of Discharge _____________________________ <br />Person rendering decision _________________________________________
					
					Witness my hand and official seal this ____________________________________ day _______________________________ 
					
					of _____________________________________________________	   ________________________________________________________ Clerk of Court<br /><br />
					Bond Executed this <strong><?= date('jS'); ?> day of <?= date('F'); ?> <?= date('Y'); ?></strong>			
			</p>				   	     								
			<table width="50%" cellpadding="5">
				<tr>
					<td><p><strong>Bond Amount</strong></p></td><td><p><?= $p[ 'bond_amount' ]; ?></p></td>
				</tr>
				<tr>
					<td><p><strong>Appearance Date</strong></p></td><td><p></p></td>
				</tr>		

				<tr>
					<td><p><strong>Defendant</strong></p></td><td><p><?= $parsed_defendant['first_name'] . ' ' . $parsed_defendant['last_name']; ?></p></td>
				</tr>		
				<tr>
					<td><p><strong>Court</strong></p></td><td><p><?= $p[ 'court' ]; ?></p></td>
				</tr>		
				<tr>
					<td><p><strong>Case #</strong></p></td><td><p><?= $p[ 'case_number' ]; ?></p></td>
				</tr>		
				<tr>
					<td><p><strong>County/City,State</strong></p></td><td><p><?= $p[ 'county' ]; ?> - <?= $p[ 'city' ]; ?>, <?= $p[ 'state' ]; ?></p></td>
				</tr>		
				<tr>
					<td><p><strong>Offense</strong></p></td><td><p><?= $p[ 'charge' ]; ?></p></td>
				</tr>		
				<tr>
					<td><p><strong>Executing Agent</strong></p></td><td><p><?= $sp[ 'executing_agent' ]; ?></p></td>
				</tr>		
			</table>
		</div>		
	</div>	
	
	
	<? endforeach; ?>
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
