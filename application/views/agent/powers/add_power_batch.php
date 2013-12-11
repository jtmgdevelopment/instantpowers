
<fieldset>
	<legend>Transmission Powers</legend>
	<table class="tablesorter">
		<thead>
			<tr>
				<th>Power Number</th>
				<th>Prefix</th>
				<th>Amount</th>
				<th>Exp. Date</th>
				<th>Power Status</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
			<? foreach( $powers as $p ): ?>			
					<tr>
						<td><?= $p['pek']; ?></td>
						<td><?= $p['prefix']; ?></td>
						<td><?= $p['amount']; ?></td>
						<td><?= $p['exp_date']; ?></td>
						<td><?= $p['status']; ?></td>
						<td align="center">
							<a href="/agent/create_powers/execute/<?= $p[ 'transmission_id' ]; ?>/<?= $p['power_id']; ?>" class="ico-settings">Add Power</a>
						</td>		
					</tr>
			<? endforeach; ?>
		</tbody>
	</table>			
	<? if( count( $powers ) > 10 ) $this->load->view('includes/pager'); ?>
	
</fieldset>		