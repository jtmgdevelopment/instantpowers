<? if( ! count( $transmissions ) ): ?>
	<div class="msg info">There are no transmissions on file</div>
<? else: ?>
<h3 class="tit">Below you can find your transmissions</h3>
<table>
	<thead>
		<tr>
			<th>Expiration Date</th>
			<th>Bail Agency Name</th>
			<th>Bail Agent</th>
			<th>Power Type</th>
			<th>Power Range</th>
			<th>Active</th>
			<th>Actions</th>
		</tr>
	</thead>
	<tbody>
		<? foreach( $transmissions as $t ): ?>
			<tr>
				<td><?= $t[ 'exp_date' ]; ?></td>	
				<td><?= $t[ 'agency_name' ]; ?></td>	
				<td><?= $t[ 'bail_agent' ]; ?></td>	
				<td><?= $t[ 'prefix' ]; ?></td>	
				<td><?= $t[ 'min_power' ] .  ' - ' . $t[ 'max_power' ]; ?></td>	
				<td><?= $t[ 'active' ]; ?></td>
				<td>
					<a href="##" onClick="alert( 'Feature Coming Soon'); return false;" class="ico-edit">Edit</a>
					<a href="##" onClick="alert( 'Feature Coming Soon'); return false;" class="ico-warning">Deactivate</a>
					<a href="##" onClick="alert( 'Feature Coming Soon'); return false;" class="ico-delete">Delete</a>
				</td>
			</tr>
		<? endforeach; ?>
	</tbody>
</table>
<p class="box">
	<a class="btn-create" href="/insurance/transmissions/create"><span>Create Transmission</span></a>
</p>


<? endif; ?>