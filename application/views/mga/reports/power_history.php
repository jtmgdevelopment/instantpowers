<h3 class="tit">Below Are is the complete power history</h3>
<p>To view the power total history, click "View Detailed History"</p>



<? if( count( $history ) ): ?>



<p class="box">
	<a class="btn-list" href="<?= safe_url('/mga/reports', 'list_power_history', array( $agency_id, 'inventory' ) ); ?>"><span>View Inventory</span></a>
	<a class="btn-list" href="<?= safe_url('/mga/reports', 'list_power_history', array( $agency_id,  'voided' )); ?>"><span>View Voided</span></a>
	<a class="btn-list" href="<?= safe_url('/mga/reports', 'list_power_history', array( $agency_id,  'discharged' )); ?>"><span>View Discharged</span></a>
	<a class="btn-list" href="<?= safe_url('/mga/reports', 'list_power_history', array(  $agency_id, 'executed' )); ?>"><span>View Executed</span></a>
	<a class="btn-list" href="<?= safe_url('/mga/reports', 'list_power_history', array(  $agency_id, 'rewrite' )); ?>"><span>View Rewrite</span></a>
	<a class="btn-list" href="<?= safe_url('/mga/reports', 'list_power_history', array( $agency_id,  'transfer' )); ?>"><span>View Transfer</span></a>
</p>

	<table class="tablesorter">
		<thead>
			<tr>
				<th>Power Prefix</th>
				<th>Power Amount</th>
				<th>Power Number</th>
				<th>Defendant Name</th>
				<th>Current Power Status</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
			<? foreach( $history as $p ): ?>
			<tr>
				<td><?= $p['prefix']; ?></td>
				<td><?= $p['amount']; ?></td>
				<td><?= $p['pek']; ?></td>
				<td><?= $p['first_name'] . ' ' . $p[ 'last_name' ]; ?></td>
				<td><?= $p['status']; ?></td>
				<td>
					<a href="/mga/reports/view_detailed_agent_power_history/<?= $p['power_id']; ?>/<?= $p[ 'mek' ]; ?>" class="ico-info">View Detailed History</a>
					<? if( $p[ 'key' ] != 'inventory' ): ?>
						<a href="/mga/reports/print_power_copy/<?= $p['power_id']; ?>" class="ico-list">Print Power</a>
					<? endif; ?>	
				
				</td>
			</tr>
			<? endforeach; ?>
		</tbody>			
	</table>
	<? if( count( $history ) > 10 ) $this->load->view( 'includes/pager' ); ?>
	
	
<? else: ?>
	<div class="msg info"><p>This Agent does not have any powers</p></div>

<? endif; ?>	