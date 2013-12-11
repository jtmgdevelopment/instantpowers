<h3 class="tit">Below Are is the complete history of your powers</h3>
<p>To view the power total history, click "View Detailed History"</p>

<? if( count( $powers ) ): ?>
	<table class="tablesorter">
		<thead>
			<tr>
				<th>Power Prefix</th>
				<th>Power Amount</th>
				<th>Power Number</th>
				<th>Current Power Status</th>
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
				<td><a href="/sub_agent/reports/view_detailed_sub_agent_power_history/<?= $p['pek']; ?>/<?= $p['prefix_id']; ?>/<?= $sub_mek; ?>" class="ico-info">View Detailed History</a></td>
			</tr>
			<? endforeach; ?>
		</tbody>			
	</table>
	<? if( count( $powers ) > 10 ) $this->load->view( 'includes/pager' ); ?>
<? else: ?>
	<div class="msg info"><p>This Sub Agent does not have any powers</p></div>

<? endif; ?>