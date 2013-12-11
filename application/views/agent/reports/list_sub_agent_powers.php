<h3 class="tit">Below Are is the complete history of this agent</h3>
<p>To view the power total history, click "View Detailed History"</p>
<p class="box">
	<a href="/agent/reports/sub_agent_power_history" class="btn"><span>Back To Sub Agents Listing</span></a>
</p>

<? if( count( $powers ) ): ?>
	
	

<p class="box">
	<a class="btn-list" href="<?= safe_url('/agent/reports', 'view_sub_agent_history', array( $sub_mek, 'inventory' ) ); ?>"><span>View Inventory</span></a>
	<a class="btn-list" href="<?= safe_url('/agent/reports', 'view_sub_agent_history', array( $sub_mek,'voided' )); ?>"><span>View Voided</span></a>
	<a class="btn-list" href="<?= safe_url('/agent/reports', 'view_sub_agent_history', array( $sub_mek,'discharged' )); ?>"><span>View Discharged</span></a>
	<a class="btn-list" href="<?= safe_url('/agent/reports', 'view_sub_agent_history', array( $sub_mek,'executed' )); ?>"><span>View Executed</span></a>
	<a class="btn-list" href="<?= safe_url('/agent/reports', 'view_sub_agent_history', array( $sub_mek,'rewrite' )); ?>"><span>View Rewrite</span></a>
	<a class="btn-list" href="<?= safe_url('/agent/reports', 'view_sub_agent_history', array( $sub_mek,'transfer' )); ?>"><span>View Transfer</span></a>
</p>
	
	<table class="tablesorter">
		<thead>
			<tr>
				<th>Power Prefix</th>
				<th>Power Amount</th>
				<th>Power Number</th>
				<th>Current Power Status</th>
				<th>Sub Agent Controlled</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
			<? foreach( $powers as $p ): ?>
			<tr>
				<td><?= $p['prefix']; ?></td>
				<td><?= $p['amount']; ?></td>
				<td><?= $p['pek']; ?></td>
				<td><?= $p['status']; ?></td>
				<td><?= $p['recouped']; ?></td>
				<td><a href="/agent/reports/view_detailed_agent_power_history/<?= $p['power_id']; ?>/<?= $sub_mek; ?>" class="ico-info">View Detailed History</a></td>
			</tr>
			<? endforeach; ?>
		</tbody>			
	</table>
	<? if( count( $powers ) > 10 ) $this->load->view( 'includes/pager' ); ?>
<? else: ?>
	<div class="msg info"><p>This Sub Agent does not have any powers</p></div>
	<a href="/agent/reports/view_sub_agent_history/<?= $sub_mek; ?>" class="btn"><span>Refresh Results</span></a>

<? endif; ?>