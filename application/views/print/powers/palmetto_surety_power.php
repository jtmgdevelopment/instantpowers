<link href="/_assets/power_assets/css/style.css" type="text/css" rel="stylesheet" media="screen" />
<style type="text/css">
@import url(http://fonts.googleapis.com/css?family=Open+Sans:400italic,400,700);

.page { page-break-before:always; }

*{
	font-family:"Open Sans", Arial, Helvetica, sans-serif;
	color:#000;	
	line-height:20px;
}
div.power{
	margin-bottom:32px;
	padding:10px;
	width:100%;
	font-size:12px;
	color:#111;
	text-align:justify;
	text-justify:inter-word;
	float:left;
	border: 1px solid #0071ac;
	background: url(/_assets/power_assets/images/pattern_003.png) o o repeat;
	clear:both;	
	height:500px;
	background-color: #c9e1eb;
}

div.executed{
	background: url(/_assets/power_assets/images/pattern_003.png) !important;
}

div.transfer{
	background:url(/_assets/power_assets/images/watermark-pattern-transfer.png) !important;	
}
div.void{
	background:url(/_assets/power_assets/images/watermark-pattern-void.png) !important;	
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

table{
	border:none;
	border-collapse:collapse;	
}
#power-amount{
	font-size: 15px;
	font-weight: bold;
	color: #0071AC;
	text-transform:uppercase;
}
#power-number{
	font-size: 15px;
	font-weight: bold;
	color: #0071AC;

}
##large{
	font-size:20px;	
}

.content{
	font-size:12px;	
}
p{
	line-height:17px;
	font-size:12px;	
}
p.blue{
	color:#0071AC;	
}
.stats{
	font-size:12px;	
}
</style>

<p align="right">
	<em><u>Power Document - <?= $power[ 'prefix' ] ?> <?= $power[ 'pek' ] ?></u></em>
</p>
<div style="margin:10px; height:550px;">
	<div class="power <?= $power[ 'key' ] ?>">
		<table width="100%">
			<tr>
				<td width="20%" id="power-amount" align="left"nowrap> 
					POWER AMOUNT<br />
					<?= $power[ 'amount' ] ?> 
				</td>
				<td width="60%" id="insurance-company" align="center" style="text-align:center;">
				
					<span id="mid" style="font-size:13px;">POWER OF ATTORNEY</span><br>
					<span style="font-size:16px;"><strong>PALMETTO SURETY CORPORATION</strong></span><br>
					<span class="small" style=" padding:5px; font-size:11px;">126 Seven Farms Drive, Suite 170, Charleston, SC 29492</span>
				</td>
				<td width="20%"  id="power-number" align="right">
					<?= $power[ 'prefix' ] ?> <span style="color:red; font-size:15px;"><?= $power[ 'pek' ] ?></span>
				</td>
			</tr>
		</table>
		<div class="content">
			<p>
				KNOW ALL MEN BY THESE PRESENTS: that PALMETTO SURETY CORPORATION, a corporation duly authorized and existing under the laws of the State of South Carolina does constitute and appoint the below named agent its true and lawful Attorney-In-Fact for it and in its name, place and stead, to execute, and deliver for and on its behalf, as surety, a bail bond only.
			</p>
			<p class="blue">
				Authority of such Attorney-In-Fact is limited to appearance bonds. No authority is provided herein for the execution of surety immigration bonds or to guarantee alimony payments, fines, wage law claims or other payments of any kind on behalf of below named defendant. The named agent is appointed only to execute the bond consistent with the terms of this power of attorney. The agents is not authorized to act as agent for receipt of service of process in any criminal or civil action. This power is void if altered or erased or used in any combination with other powers of attorney of this company or any other company to obtain the release of the defendant named below or to satisfy any bond requirement in excess of the stated face amount of this power. This power can only be used once. The obligation of the company shall not exceed the sum of
			</p>
			<p class="blue" style="text-align:center; font-size:13px; font-weight:bold">
				 (<?= "$ ".number_format($power[ 'amount' ], 2); ?>) DOLLARS
			</p>
			<p>
				and provided this Power-Of-Attorney is filed with the bond and retained as a part of the court records. The said Attorney-In-Fact is hereby authorized to insert in this Power-Of-Attorney the name of the person on whose behalf this bond was given.
			</p>
			<p>
				IN WITNESS WHEREOF, PALMETTO SURETY CORPORATION has caused these presents to be signed by it's duly authorized officer, proper for the purpose and its corporate seal to be hereunto affixed this <?= date('l'); ?>, <?= date('F'); ?> <?= date('Y'); ?> day of <?= date('m/d/Y'); ?>.
			</p>
		</div>
	</div>
		
</div>

<br clear="all" />


<div style="width:800px; margin:10px; height:300px;">
	<div style="float:left;width:550px">
	<table border="0" cellpadding="5">
		<tr>
			<td>
				Bond Amount:
			</td>
			<td>
				<strong>$<?= $power[ 'bond_amount' ]; ?></strong>
			</td>
		</tr>
		<tr>
			<td>
				Defendant:
			</td>
			<td>
				<strong><?= $power['defendant_first_name'] . ' ' . $power['defendant_last_name']; ?></strong>
			</td>
		</tr>
		<tr>
			<td>
				Court:
			</td>
			<td>
				<strong><?= $power[ 'court' ]; ?></strong>
			</td>
		</tr>
		<tr>
			<td>
				Case Number:
			</td>
			<td>
				<strong><?= $power[ 'case_number' ]; ?></strong>
			</td>
		</tr>
		<tr>
			<td>
				County:
			</td>
			<td>
				<strong><?= $power[ 'county' ]; ?></strong>
			</td>
		</tr>
		<tr>
			<td>
				City:
			</td>
			<td>
				<strong><?= $power[ 'power_city' ]; ?></strong>
			</td>
		</tr>
		<tr>
			<td>
				State:
			</td>
			<td>
				<strong><?= $power[ 'power_state' ]; ?></strong>
			</td>
		</tr>
		<tr>
			<td>
				Charge:
			</td>
			<td>
				<strong><?= $power[ 'charge' ]; ?></strong>
			</td>
		</tr>
		<tr>
			<td>
				Executing Agent:
			</td>
			<td>
				<strong><?= $power[ 'executing_agent' ]; ?></strong>
			</td>
		</tr>
	</table>
	</div>
	<div style="margin:10px; float:left;">
		<div style="width:350px; text-align:right;">
			<h1 style="color:red; font-weight:normal; font-size:20px; "> Expires <?= date( 'm/d/Y', strtotime($power[ 'exp_date' ])); ?></h1>
			<div style="margin-top:20px;"> <img src="http://instantpowers.com/_assets/power_assets/images/seal-signature.png" width="330" height="140" border="0"> </div>
		</div>
	</div>
	<br clear="all" />
	
</div>
<div class="page"></div>
<div style="width:100%; height:180px;">	
	<div style="width:50%;float:left">
		<h2 style="line-height:20px; font-size:15px;">Palmetto Surety Corporation<br />
			126 Seven Farms Drive, Suite 170<br />
			Charleston, SC 29492</h2>
		<p><strong>General Surety Appearance Bond</strong><br />
		
			POWER # <strong><?= power_get_prefix( $power[ 'prefix_id' ] ); ?><?= $power[ 'pek' ]; ?></strong>
			<br />
			ARREST # <strong><?= $power[ 'case_number' ]; ?></strong>
		</p>
	</div>
	<div style="width:50%;float:left">
		<h2  style="line-height:20px; font-size:15px;">For Further Action On This Bond Notify:</h2>
		<p>
			<strong><?= $power[ 'agency_name' ]; ?></strong><br>
		
			<strong><?= $power[ 'executing_agent' ]; ?></strong><br>
			<?= $power[ 'address']; ?><br>
			<?= $power[ 'city' ]; ?> <?= $power[ 'state']; ?> <?= $power[ 'zip']; ?>
		</p>
	</div>
</div>
<div style="width:80%; height:130px; text-align:center;">	
	<div style="width:50%;float:left;">

		<h4 style="text-align:center;font-size:18px; line-height:26px;">
			<strong>STATE OF FLORIDA
			<br /><br />
			VS
			<br /><br />
			<?= $power['defendant_first_name'] . ' ' . $power['defendant_last_name']; ?></strong>
		</h4>

	</div>
	<div style="width:50%;float:left; text-align:center;">
		<h4 style="font-size:18px; line-height:23px;">
		IN THE <strong><?= $power[ 'court' ]; ?> Court</strong><br>
		<strong><?= $power[ 'county' ]; ?></strong> County, STATE OF FLORIDA
		</h4>
	</div>
</div>
<div style="width:100%; margin:10px; height:120px;">

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
<br />
<div style="width:100%; margin:10px; height:110px;">
	<div style="width:50%;float:left;">
			<h4 style="font-size:14px; line-height:23px;">Taken Before Me And Approved By Me:</h4>
			<p>
				By _________________________________________ <br>
				<em>Sheriff</em>
			</p>
			<p>
				By _________________________________________ <br>
				<em>D.S</em>
			</p>
	</div>
	<div style="width:50%;float:left;">
		<p>
			_________________________________________ (L.S.)<br>
			<em>(Principal) PALMETTO SURETY CORPORATION</em> <br />
			By <strong><?= $power[ 'executing_agent' ]; ?></strong>
			<br />
			<em>(Attorney in fact) (SURETY)</em> <br />
			Agent number or license number: <strong><?= $power[ 'license_number' ]; ?></strong>
		</p>
	</div>
</div>
<br clear="all" />
<div style="width:100%; margin:10px; height:35px;">
	<h4 style="font-size:14px; line-height:23px;">STATEMENT - The Undersigned </h4>
</div>

<div style="width:100%; margin:15px; height:150px;">
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
	<br />
	(Bondsman) <strong><?= $power[ 'executing_agent' ]; ?></strong> ~ (Agency) <strong><?= $power[ 'agency_name' ]; ?></strong>
</p>
</div>
	



	
	
