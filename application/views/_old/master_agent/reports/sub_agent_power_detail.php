<h3 class="tit">Below Are is the complete history of this agent</h3>
<p>To view the power total history, click "View Detailed History"</p>


<p class="box">
	<? if( $status != 'inventory' ): ?>
		<a target="_blank" href="<?= safe_url( '/master_agent/power_print', 'print_copy', array( $power[0][ 'pek' ], $power[0][ 'transmission_id' ], $power[0][ 'prefix_id' ], $power[0]['mek'] ) ); ?>" class="btn-list"><span>Print Copy Of Power</span></a>
	<? endif; ?>
</p>


<? if( count( $power ) ): ?>
	<table class="tablesorter">
		<thead>
			<tr>
				<th>Power Prefix</th>
				<th>Power Amount</th>
				<th>Power Number</th>
				<th>Detailed Power Information</th>
				<th>Date Power Altered</th>
			</tr>
		</thead>
		<tbody>
			<? foreach( $power as $p ): ?>
			<tr>
				<td><?= $p['prefix']; ?></td>
				<td><?= $p['amount']; ?></td>
				<td><?= $p['pek']; ?></td>
				<td><?= $p['log']; ?></td>
				<td><?= $p['created_date']; ?></td>
			</tr>
			<? endforeach; ?>
		</tbody>			
	</table>
	<? if( count( $power ) > 10 ) $this->load->view( 'includes/pager' ); ?>
<? else: ?>
	<div class="msg info"><p>This Sub Agent does not have any powers</p></div>

<? endif; ?>

<p class="box">
	<button onclick="javascript: history.go( -1 );" class="btn"><span>Back To Powers Listing</span></button>
</p>