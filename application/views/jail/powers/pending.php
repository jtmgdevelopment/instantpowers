<? if( ! count( $powers ) ): ?>
	<div class="msg info">There are no transmissions on file</div>
<? else: ?>
<h3 class="tit">Below you can find your transmissions</h3>
<table class="tablesorter">
	<thead>
		<tr>
			<th class="header">Bail Agency Name</th>
			<th>Bail Agent</th>
			<th>Defendant Name</th>
			<th>Charge</th>
			<th>Execution Date</th>
			
			<th>Actions</th>
		</tr>
	</thead>
	<tbody>
	<? foreach( $powers as $p ): ?>
			<tr>
				<td><?= $p['agency_name' ]; ?></td>
				<td><?= $p['full_name' ]; ?></td>
				<td><?= $p['first_name' ]; ?> <?= $p['last_name' ]; ?></td>
				<td><?= $p[ 'charge' ]; ?></td>
				<td><?= $p[ 'execution_date' ]; ?></td>				
				<td>
					<a href="/jail/transmissions/view_power/<?= $p[ 'power_id' ] ?>/pending" class="ico-show">View Power Details</a> |
					<a href="/jail/transmissions/accept_power/<?= $p[ 'power_id' ] ?>" class="ico-done">Accept Power</a> |
					<a href="/jail/transmissions/void_power/<?= $p[ 'power_id' ] ?>"  class="ico-delete">Void Power</a>
				</td>
			</tr>
		<? endforeach; ?>
	</tbody>
</table>
<? if( count( $powers ) > 10 ) $this->load->view('includes/pager'); ?>
<? endif; ?>
