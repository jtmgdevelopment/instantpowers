<? if( ! count( $transmissions ) ): ?>
	<div class="msg info">There are no transmissions on file</div>
<p class="box">
	<a class="btn-create" href="/insurance/transmissions/create"><span>Create Transmission</span></a>
	<a class="btn" href="/insurance/transmissions/view_mga_transmissions"><span>View MGA Transmission</span></a>
</p>

<? else: ?>
<h3 class="tit">Below you can find your transmissions</h3>
<p class="box">
	<a class="btn-create" href="/insurance/transmissions/choose"><span>Create Transmission</span></a>
	<a class="btn" href="/insurance/transmissions/view_mga_transmissions"><span>View MGA Transmission</span></a>
</p>


<? foreach( $transmissions as $trans ): ?>
<hr  />
<p><strong>Transmission for: <?= $trans[ 'agency_name' ] . ' ' . $trans[ 'full_name' ]; ?></strong><br />
<em>Transmission Status: <?= $trans[ 'active' ]; ?>; Transmission Expiration Date: <?= $trans[ 'exp_date' ]; ?></em></p>
<? if( $trans[ 'recouped' ] == 'RECOUPED TRANSMISSION' ): ?>
<p>This Transmission has been recouped on the following date: <?= $trans[ 'recoup_date' ]; ?>
<? else: ?>
	<a href="/insurance/transmissions/recoup/<?= $trans[ 'transmission_id' ] ?>" class="ico-delete">Recoup Transmission/Powers?</a>
<? endif; ?>
</p>
<table>
	<thead>
		<tr>
			<th>Expiration Date</th>
			<th>Power Type</th>
			<th>Power Range</th>
			<th>Breakdown</th>
			<th>Active</th>
			<th>Transmission Status</th>
		</tr>
	</thead>
	<tbody>
		<? foreach( $trans[ 'power_group' ] as $t ):?>
			<tr>
				<td><?= $trans[ 'exp_date' ]; ?></td>	
				<td><?= $t[ 'prefix' ]; ?></td>	
				<td><?= $t[ 'min_power' ] .  ' - ' . $t[ 'max_power' ]; ?></td>
				<td> <?= ( intval( $t[ 'max_power' ] ) - intval( $t[ 'min_power' ] ) ) + 1; ?> (<?= number_format( $t[ 'amount' ]  ) ?>'s)</td>	
				<td><?= $trans[ 'active' ]; ?></td>
				<td>
					<? if( $trans[ 'recouped' ] != 'RECOUPED TRANSMISSION' ): ?>ACTIVE TRANSMISSION<? else: ?> <?= $trans[ 'recouped' ]; ?><? endif; ?>
				</td>
			</tr>
		<? endforeach; ?>
	</tbody>
</table>
<? endforeach; ?>


<? endif; ?>
