<h3 class="tit">View/Print your accepted powers</h3>
<? if( ! count( $powers ) ): ?>
	<div class="msg info">There are no transmissions on file</div>
<? else: ?>
<table class="tablesorter">
	<thead>
		<tr>
			<th>Bail Agency Name</th>
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
				<td><?= $p[ 'first_name' ]; ?> <?= $p[ 'last_name' ]; ?></td>
				<td><?= $p[ 'charge' ]; ?></td>
				<td><?= $p[ 'execution_date' ]; ?></td>
				<td>
					<a href="/jail/transmissions/view_power/<?= $p[ 'power_id' ]; ?>/accepted_powers" class="ico-show">View Power Details</a> |
					<a href="/jail/transmissions/print_powers/<?= $p[ 'power_id' ]; ?>" class="ico-list">Print Power</a> 
				</td>
			</tr>
		<? endforeach; ?>
	</tbody>
</table>

<? if( count( $powers ) > 10 ) $this->load->view('includes/pager'); ?>


<? /*
<p class="box">
	<a class="btn-create" href="/insurance/transmissions/create"><span>Create Transmission</span></a>
</p>
*/ ?>

<? endif; ?>