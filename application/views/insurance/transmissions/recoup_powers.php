<? if( count( $powers ) ): ?> 
	<p class="box">
		<a href="/insurance/transmissions/process_recoup/<?= $trans_id; ?>" class="btn-delete"><span>Recoup These Powers?</span></a>
		<a href="/insurance/transmissions/" class="btn"><span>Cancel</span></a>
	</p>
	<table class="">
		<thead>
			<tr>
				<th>Power Number</th>
				<th>Prefix</th>
				<th>Amount</th>
				<th>Exp. Date</th>
				<th>Power Status</th>
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
				</tr>
			<? endforeach; ?>
		</tbody>
	</table>			

<? else: ?>
	<div class="msg info"><p>There was an error</p></div>

<? endif; ?>	
