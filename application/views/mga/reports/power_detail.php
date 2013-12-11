<h3 class="tit">Below Are is the complete history of this agent</h3>
<p>To view the power total history, click "View Detailed History"</p>


<? if( count( $power ) ): ?>
	<p class="box">
		<? if( $status != 'inventory' ): ?>
			<a class="btn-list" href="/mga/reports/view_power/<?= $power_details[ 'transmission_id' ] ?>/<?= $power_id; ?>"><span>View Power</span></a>

		<? endif; ?>
		<!--<a class="btn-delete" href="/mga/reports/void/<?= $power_id; ?>"><span>Void Power</span></a>-->
		<? if( $status != 'inventory' ): ?>

			<a class="btn" href="/defendant/manage/view/<?= $power_id; ?>"><span>View Defendant</span></a>
		
			<a target="_blank" class="btn-list" href="/mga/reports/print_power_copy/<?= $power_details[ 'transmission_id' ] ?>/<?= $power_id; ?>"><span>Print Power</span></a>
		<? endif; ?>
	</p>
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
<? if( ! isset( $hide ) ): ?>
<p class="box">
	<button onclick="javascript: history.go( -1 );" class="btn"><span>Back To Powers Listing</span></button>
</p>
<? endif; ?>