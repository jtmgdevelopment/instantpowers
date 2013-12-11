
<fieldset>
	<legend>Transmission Powers</legend>
	<table>
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
				<? if( ! in_array( $p['pek'], $batch )  ): ?>
					<? if( $p[ 'key' ] == 'inventory' ): ?>
					<tr>
						<td><?= $p['pek']; ?></td>
						<td><?= $p['prefix']; ?></td>
						<td><?= $p['amount']; ?></td>
						<td><?= $p['exp_date']; ?></td>
						<td><?= $p['status']; ?></td>
						<td align="center">
							<a href="/master_agent/powers/view/<?= $transmission->trans_id; ?>/<?= $p['pek']; ?>/<?= $p[ 'prefix_id' ]; ?>" class="ico-settings">Add Power</a> 
						</td>		
					</tr>
					<? endif; ?>

				<? endif; ?>
			<? endforeach; ?>
		</tbody>
	</table>			
	
</fieldset>		