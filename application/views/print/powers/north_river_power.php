
<style type="text/css">
@import url(http://fonts.googleapis.com/css?family=Open+Sans:400italic,400,700);

*{
	font-family:"Open Sans", Arial, Helvetica, sans-serif;
	color:#000;	
	line-height:20px;
}
div.power{
	margin-bottom:32px;
	padding:10px;
	font-size:12px;
	color:#111;
	text-align:justify;
	text-justify:inter-word;
	float:left;
	border: 1px solid #0071ac;
	background: url(/_assets/power_assets/images/pattern_003.png) 0 0;
	clear:both;	
	height:600px;
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
.large{
	font-size:20px;	
}

.content{
	font-size:12px;	
}
p{
	line-height:18px;	
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
<div style="margin:10px; width:100%; position:relative">
	<div class="power <?= $power[ 'key' ] ?>">
		<table width="100%">
			<tr>
				<td align="left">
		            <small style="font-size:10px;">
		            <strong>THE NORTH RIVER INSURANCE COMPANY</strong><br />
		            10350 Richmond Ave., Suite 300  Houston, TX 77042<br />P.O. Box 2807  Houston, Texas 77252-2807<br />
		            (713) 954-8100 &nbsp;&nbsp;&nbsp;&nbsp; (713) 954-8389 FAX
		            </small>
				</td>
				<td class="power-amount large" align="center">
					<strong>POWER OF ATTORNEY</strong>
				</td>
				<td align="right" id="power-number">
					POWER # <?= $power[ 'prefix' ] ?>  <?= $power[ 'pek' ] ?> 
					<br />
					POWER AMOUNT $ <?= $power[ 'amount' ] ?>					
				</td>
			</tr>
		</table>
		<div class="content">
			<p>
				The Power of Attorney is granted pursuant to Article V of the By-Laws of THE NORTH RIVER INSURANCE COMPANY as now in full force and effect. Article V, Execution of Instruments- Except as the Board of Directors may authorize by resolution, the Chairman of the Board, President, any Vice-President, any Assistant Vice President, the Secretary, or any Assistant Secretary, or any Assistant Secretary shall have power on behalf of the Corporation: (a) to execute, affix the corporate seal manually or by facsimile to, acknowledge, verify and deliver any contracts, obligations, instruments and documents whatsoever in connection with its business, including, without limiting the foregoing, any bonds, guarantees, undertakings, recognizances, powers of attorney or revocations of any powers of attorney, stipulations, policies of insurance, deeds, leases, mortgages, releases, satisfactions and agency agreements; (b) to appoint, in writing, one or more persons for any or all of the purposes mentioned in the preceding paragraph (a), including affixing the seal of the Corporation. Authority of such Attorney-In-Fact is limited to appearance bonds and cannot be construed to guarantee defendant's future lawful conduct, adherence to travel limitation, fines, restitution, payments or penalties, or any other condition imposed by a court not specifically related to court appearance. 
			</p>
			
			<p style="background:#fff; padding:10px; border: 1px solid blue;">
				This Power of Attorney is for use with Bail Bonds only. Not valid if used in connection with Federal Bonds or Immigration Bonds. The power void if altered or erased, void if used with other powers of this Company or in combination with powers from any other surety company, void if used to furnish bail in excess of the stated face amount of this power, and can only be used once. 
				<br />
				<span class="blue large" style="display:block; text-align:center; font-size:13px; font-weight:bold">
					The obligation of the Company shall not exceed the sum of  (<?= "$ ".number_format($power[ 'amount' ], 2); ?>) DOLLARS
				</span>
			</p>
			<p>
				IN WITNESS WHEREOF, NORTH RIVER INSURANCE COMPANY has caused these presents to be signed by it's duly authorized officer, proper for the purpose and its corporate seal to be hereunto affixed this <?= date('l'); ?>, <?= date('F'); ?> <?= date('Y'); ?> day of <?= date('m/d/Y'); ?>.
			</p>
		</div>
		<div style="height:300px;">
			<div style="width:350px; float:right; text-align:right;">
				<h1 style="color:red; font-weight:normal; font-size:20px; "> Expires <?= date( 'm/d/Y', strtotime($power[ 'exp_date' ])); ?></h1>
				<div style="margin-top:20px;"> <img src="http://instantpowers.com/_assets/power_assets/images/north-river-seal-signature.png" border="0"> </div>
			</div>
		</div>
	</div>
	<div style="clear:both"></div>
</div>
<!--end:fullwidth--> 
<br clear="all">
</div>
