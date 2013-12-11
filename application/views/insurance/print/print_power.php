
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
	width:800px;
	font-size:12px;
	color:#111;
	text-align:justify;
	text-justify:inter-word;
	float:left;
	border: 1px solid #0071ac;
	background: url(/_assets/power_assets/images/pattern_003.png);
	clear:both;	
	height:600px;
	background-repeat: no-repeat;
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
##power-amount{
	font-size: 15px;
	font-weight: bold;
	color: #0071AC;
	text-transform:uppercase;
}
##power-number{
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
<div style="margin:10px; width:800px; position:relative">
	<div class="power <?= $power[ 'key' ] ?>">
		<table width="100%">
			<tr>
				<td id="power-amount" align="center" width="140" nowrap> POWER AMOUNT<br />
					<?= $power[ 'amount' ] ?> </td>
				<td id="insurance-company" align="center"><span id="mid" style="font-size:13px;">POWER OF ATTORNEY</span><br>
					<span style="font-size:16px;"><strong>PALMETTO SURETY CORPORATION</strong></span><br>
					<span class="small" style=" padding:5px; font-size:11px;">126 Seven Farms Drive, Suite 170, Charleston, SC 29492</span></td>
				<td  id="power-number" align="right"><?= $power[ 'prefix' ] ?> <span style="color:red; font-size:15px;"><?= $power[ 'pek' ] ?></span></td>
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
		<div style="margin:10px; position:absolute; bottom:-30px; z-index:1000; right:0px;">
			<div style="width:350px; text-align:right;">
				<h1 style="color:red; font-weight:normal; font-size:20px; "> Expires <?= date( 'm/d/Y', strtotime($power[ 'exp_date' ])); ?></h1>
				<div style="margin-top:20px;"> <img src="http://instantpowers.com/_assets/power_assets/images/seal-signature.png" width="330" height="140" border="0"> </div>
			</div>
		</div>

	</div>

</div>
<!--end:fullwidth--> 
<br clear="all">
</div>
