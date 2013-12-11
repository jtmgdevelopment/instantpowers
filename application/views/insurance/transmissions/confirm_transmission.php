<div id="top"></div>
<p class="box">
	<? if( isset( $mga ) ): ?>
		<a href="/insurance/transmissions/save_mga_transmissions/" class="btn-create"><span>Transmit Transmission</span></a>
	<? else: ?>
		<a href="/insurance/transmissions/save_transmissions/" class="btn-create"><span>Transmit Transmission</span></a>
	<? endif; ?>	

	<? if( isset( $mga ) ): ?>
		<a href="/insurance/transmissions/create_mga" class="btn-list"><span>Add To Transmission</span></a>
	<? else: ?>
		<a href="/insurance/transmissions/create" class="btn-list"><span>Add To Transmission</span></a>
	<? endif; ?>	


	<a href="/insurance/transmissions/cancel" class="btn-delete"><span>Cancel &amp; Trash Transmission</span></a>
</p>
<h3 class="tit">Below you will find your current transmissions</h3>
<ul>
<? foreach( $temp_batch as $batch ): ?>
<li><a href="#<?= preg_replace("![^a-z0-9]+!i", "-", $batch['prefix'] ); ?>"><strong>Transmission:</strong> <?= $batch['prefix']; ?> ~ <?= $batch['power_start']; ?> - <?= $batch['power_end']; ?></a></li>

<? endforeach; ?>
</ul>
<p>Listed powers by transmission below</p>
<? foreach( $temp_batch as $batch ): ?>
<div id="<?= preg_replace("![^a-z0-9]+!i", "-", $batch['prefix'] ); ?>">
<p><strong>Transmission:</strong> <?= $batch['prefix']; ?> ~ <?= $batch['power_start']; ?> - <?= $batch['power_end']; ?></p>
<p><a href="#top">Back To Top</a></p>
<hr />
<table>
	<thead>
	<tr>
		<th>Agency Name</th>
		<th>Agent Name</th>
		<th>Power Prefix</th>
		<th>Exp. Date</th>
		<th>Power Number</th>
	</tr>
	</thead>
	<tbody>
		<? for( $i = $batch['power_start']; $i <= $batch['power_end']; $i++ ): ?>
			<tr>
				<td><?= $batch[ 'bail_agency_name']; ?></td>
				<td><?= $batch[ 'agent_name']; ?></td>
				<td><?= $batch[ 'prefix']; ?></td>
				<td><?= $batch[ 'exp_date']; ?></td>
				<td><?= $i; ?></td>
			</tr>
		<? endfor; ?>	

	</tbody>
</table>	
</div> 
<p><a href="#top">Back To Top</a></p>
<? endforeach; ?>