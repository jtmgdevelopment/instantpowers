<? if( isset( $show_message ) ): ?>
	<div class="msg done">You purchased a transmission! 2 credits have been deducted from your credit wallet.</div>
<? endif; ?>

<? if( ! count( $transmissions ) ): ?>
	<div class="msg info"><p>You currently have no transmissions</p></div>
<? else: ?>
	<h3 class="tit">Your Transmissions</h3>

	<? foreach( $transmissions as $trans ): ?>
		<hr />
		<p><strong>Transmission From <?= $trans[ 'agency_name' ] . ' ' .  $trans[ 'ins_agent' ]; ?></strong><br />
			<em>
				Transmission Expiration Date: <?= $trans[ 'exp_date' ]; ?>; 
				Transmission Status: <?= $trans[ 'status' ] ?>/
				<? if( $trans['paid'] == 'Not Paid' && $trans[ 'active' ] == 'Active' ): ?>
					<span style=" color:red; font-weight:bold; float:none; text-transform:uppercase;" >Not Paid</span>&nbsp;<a href="#" class="ico-info purchase-transmission" data-trans-id="<?= $trans[ 'trans_id' ]; ?>">PURCHASE TRANSMISSION</a>
				<? elseif( $trans['paid'] == 'Paid'  && $trans[ 'active' ] == 'Active' ): ?>
					<span style=" color:green; font-weight:bold; float:none; text-transform:uppercase;">Paid</span>&nbsp;
					<a href="<?= safe_url('/master_agent/transmissions', 'view', array( $trans['trans_id'])); ?>" class="ico-show">VIEW</a>
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
				</tr>
			</thead>
			<tbody>
				<? foreach( $trans['power_group'] as $t ): ?>
					<tr>
						<td><?= $trans[ 'exp_date' ]; ?></td>	
						<td><?= $t[ 'prefix' ]; ?><?= $t[ 'amount' ]; ?></td>	
						<td><?= $t[ 'min_power' ] .  ' - ' . $t[ 'max_power' ]; ?></td>	
						<td>
							<span class="label <? if( $trans['active'] == 'Not Active' ): ?>label-red <? else: ?> label-green<? endif; ?>"><?= $trans[ 'active']; ?></span>
											
						</td>
					</tr>
				<? endforeach; ?>
			</tbody>
		</table>
	
	
	<? endforeach; ?>
	
	
	



	<div id="trans-modal" title="Basic modal dialog">
		<div id="errors" class="msg error" style="display:none"></div>
		<p>You will be charge 2 credits to purchase this transmission. If you agree, please click "Purchase Transmission" below.</p>
	</div>

	
<? endif; ?>