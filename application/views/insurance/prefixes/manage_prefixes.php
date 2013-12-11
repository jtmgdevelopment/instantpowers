<? if( count( $prefixes ) ): ?>
<table>
	<thead>
	<tr>
		<th>Power Prefix</th>
		<th>Power Amount</th>
		<th>Active</th>
		<th>Actions</th>
	</tr>
	</thead>
	<tbody>
		<? foreach( $prefixes as $p ): ?>
			<tr>
				<td><?= $p[ 'prefix' ]; ?></td>
				<td><?= $p[ 'amount' ]; ?></td>
				<td id="<?= $p[ 'prefix_id' ]; ?>_status">
					<?= $p['active'] ?>
				</td>
				<td>
					<? if( $p['active'] == 'Active' ): ?> 
						<a id="change-status" href="#" data-status="deactivate" data-prefix_id="<?= $p[ 'prefix_id' ]; ?>">Deactivate?</a>
					<? else: ?>
						<a id="change-status" href="#" data-status="activate" data-prefix_id="<?= $p[ 'prefix_id' ]; ?>">Activate?</a>
					<? endif; ?>	
				</td>
			</tr>
		<? endforeach; ?>
	</tbody>
</table>	

<? else: ?>
<div class="msg info"><p>You currently have not created a prefix yet</p></div>
<? endif; ?>
<p class="box">
	<a href="/insurance/power_prefix/create" class="btn-create"><span>Create New Prefix</span></a>
</p>
