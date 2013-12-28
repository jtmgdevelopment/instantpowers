<? if( ! count( $transmissions ) ): ?>
	<div class="msg info">There are no transmissions on file</div>
<p class="box">
	<a class="btn-create" href="/insurance/transmissions/create_mga"><span>Create Transmission</span></a>
	<a class="btn" href="/insurance/transmissions/index"><span>View Agent Transmission</span></a>
</p>

<? else: ?>
<h3 class="tit">Below you can find your transmissions</h3>
<p class="box">
	<a class="btn-create" href="/insurance/transmissions/choose"><span>Create Transmission</span></a>
	<a class="btn" href="/insurance/transmissions/index"><span>View Agent Transmission</span></a>
</p>


<? foreach( $transmissions as $trans ): ?>
<hr  />
<p><strong>Transmission (<?= $trans[ 'transmission_id' ]; ?>) for: <?= $trans[ 'company_name' ] . ' ' . $trans[ 'full_name' ]; ?></strong><br />
<em>Transmission Status: <?= $trans[ 'active' ]; ?>; Created: <?= $trans[ 'created_date' ]; ?>; Transmission Expiration Date: <?= $trans[ 'exp_date' ]; ?></em></p>
<? if( $trans[ 'recouped' ] == 'RECOUPED TRANSMISSION' ): ?>
<p>This Transmission has been recouped on the following date: <?= $trans[ 'recoup_date' ]; ?></p>
<? else: ?>
	<a href="/insurance/transmissions/recoup/<?= $trans[ 'transmission_id' ] ?>" class="ico-delete">Recoup Transmission/Powers</a>
<? endif; ?>
<table>
	<thead>
		<tr>
			<th>Expiration Date</th>
			<th>Power Type</th>
			<th>Power Range</th>
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
				<td><?= $trans[ 'active' ]; ?></td>
				<td>
					<? if( $trans[ 'recouped' ] != 'RECOUPED TRANSMISSION' ): ?>ACTIVE<? else: ?> <?= $trans[ 'recouped' ]; ?><? endif; ?>
				</td>
			</tr>
		<? endforeach; ?>
	</tbody>
</table>
<? endforeach; ?>


<? endif; ?>
