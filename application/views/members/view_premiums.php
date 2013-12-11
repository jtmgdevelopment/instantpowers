<h3 class="tit">Below you can manage your different premiums at your selected Transmitting Companies</h3>
<p class="box">
	<a class="btn-create" href="<?= safe_url( '/members/manage_account', 'add_premium' ); ?>"><span>Add Premium</span></a>
</p>

<? if( count( $premiums ) ): ?>
	<table>
		<thead>	
			<tr>
				<th>Transmitting Company</th>
				<th>Premium</th>
				<th>BUF</th>
				<th>Actions</th>
			</tr>	
		</thead>
		<tbody>
			<? foreach( $premiums as $p ): ?>
			
				<tr>
					<td><?= $p['agency_name']; ?></td>
					<td><?= $p['premium']; ?></td>
					<td><?= $p['buf']; ?></td>
					<td>
						<a class="ico-edit" href="<?= safe_url('/members/manage_account', 'edit_premium', array( $p[ 'premium_id' ] ) ); ?>">Edit</a>
					</td>
				</tr>			
			<? endforeach; ?>	
		</tbody>
	</table>	
<? else: ?>
<div class="msg info"><p>You currently don't have any premiums</p></div>

<? endif; ?>