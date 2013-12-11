<style>
div.row{
	background: #eee;
	padding:10px;
	margin:10px;
	border: 1px solid #ccc;
	border-radius: 4px;
}

div.row:nth-child(even){
	background: #f8f8f8;
	
}
</style>
<? if( isset( $show_message ) ): ?>
	<div class="msg done">You purchased a transmission! 8 credits have been deducted from your credit wallet.</div>
<? endif; ?>



<? if( ! count( $transmissions ) ): ?>
	<div class="msg info">There are no transmissions on file</div>

<? else: ?>
<h3 class="tit">Below you can find your transmissions</h3>
<p class="box">
	<a class="btn" href="/mga/power_inventory"><span>View Inventory</span></a>
</p>
<? foreach( $transmissions as $trans ): ?>
<div class="row">
<hr  />
<p>
<em>Transmission Status: <?= $trans[ 'active' ]; ?>; Transmission Expiration Date: <?= $trans[ 'exp_date' ]; ?></em>
<br /><em>Transmission Created Date: <?= $trans[ 'created_date' ]; ?></em>
</p>
<? if( $trans[ 'paid' ] == 'Paid' ): ?>	

	<? if( $trans[ 'recouped' ] == 'RECOUPED TRANSMISSION' ): ?>
		<p>This Transmission has been recouped on the following date: <?= $trans[ 'recoup_date' ]; ?></p>
	<? else: ?>
			<? if( strlen( $trans[ 'bail_agent_id' ] ) && $trans[ 'mga_accepted' ] == 'accepted' ): ?>
				<p>You have transferred this transmission to <?= $trans[ 'agency_name' ]; ?> ~ <?= $trans[ 'agent_name' ]; ?></p>
				<p class="box"><a class="btn" href="/mga/transmissions/recoup/<?= $trans[ 'transmission_id' ]; ?>"><span>Recoup Transmission From Agent?</span></a></p>
			<? elseif( $trans[ 'mga_accepted' ] == 'accepted' ): ?>
			<? else: ?>
				<p class="box"><a class="btn" href="/mga/transmissions/accept_transmission/<?= $trans[ 'transmission_id' ]; ?>"><span>Accept Transmission?</span></a></p>	
			<? endif; ?>	
	<? endif; ?>
<? endif; ?>

<p>
<em>
	Transmission Expiration Date: <?= $trans[ 'exp_date' ]; ?>; 
	Transmission Status: <?= $trans[ 'status' ] ?>/
	<? if( $trans['paid'] == 'Not Paid' && $trans[ 'active' ] == 'Active' ): ?>
		<span style=" color:red; font-weight:bold; float:none; text-transform:uppercase;" >Not Paid</span>&nbsp;<a href="#" class="ico-info purchase-transmission" data-trans-id="<?= $trans[ 'trans_id' ]; ?>">PURCHASE TRANSMISSION</a>
	<? elseif( $trans['paid'] == 'Paid'  && $trans[ 'active' ] == 'Active' ): ?>
		<span style=" color:green; font-weight:bold; float:none; text-transform:uppercase;">Paid</span>&nbsp;
	<? else: ?>				
		<? if( $trans['active'] == 'Not Active' ): ?><span style=" color:red; font-weight:bold; float:none; text-transform:uppercase;">Expired</span> <? endif; ?>
	<? endif; ?>
</em>
</p>
<table>
	<thead>
		<tr>
			<th>Expiration Date</th>
			<th>Power Type</th>
			<th>Power Range</th>
			<th>Active</th>
			<th>Transmission Status</th>
		</tr>
	</thead>
	<tbody>
		<? foreach( $trans[ 'power_group' ] as $t ):?>
			<tr>
				<td><?= $trans[ 'exp_date' ]; ?></td>	
				<td><?= $t[ 'prefix' ]; ?></td>	
				<td><?= $t[ 'min_power' ] .  ' - ' . $t[ 'max_power' ]; ?></td>	
				<td><?= $trans[ 'active' ]; ?></td>
				<td>
					<? if( $trans[ 'recouped' ] != 'RECOUPED TRANSMISSION' ): ?>ACTIVE<? else: ?> <?= $trans[ 'recouped' ]; ?><? endif; ?>
				</td>
			</tr>
		<? endforeach; ?>
	</tbody>
</table>
</div>
<? endforeach; ?>

	<div id="trans-modal" title="Basic modal dialog">
		<div id="errors" class="msg error" style="display:none"></div>
		<p>You will be charge 8 credits to purchase this transmission. If you agree, please click "Purchase Transmission" below.</p>
	</div>

<? endif; ?>
