<? if( ! count( $powers ) ): ?>
<div class="msg info"><p>There are no more available Inventory Powers left</p></div>
<? else: ?>
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
					<? if( $p[ 'key' ] != 'executed' ): ?>
					<tr>
						<td><?= $p['pek']; ?></td>
						<td><?= $p['prefix']; ?></td>
						<td><?= $p['amount']; ?></td>
						<td><?= $p['exp_date']; ?></td>
						<td><?= $p['status']; ?></td>
						<td align="center">
							<a href="/sub_agent/powers/view/<?= $trans_id; ?>/<?= $p['pek']; ?>" class="ico-settings">Add Power</a> 
						</td>		
					</tr>
					<? endif; ?>

				<? endif; ?>
			<? endforeach; ?>
		</tbody>
	</table>			
	
</fieldset>		
<p class="box"><a href="/sub_agent/powers/step_three/<?= $trans_id; ?>/<?= $pek; ?>" class="btn"><span>Return To Summary</span></a></p>

<? endif; ?>