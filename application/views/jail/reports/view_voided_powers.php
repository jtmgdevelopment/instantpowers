<? if( ! count( $voided_powers ) ): ?>
	<div class="msg info">There are no voided powers reports on file</div>
<? else: ?>
<h3 class="tit">Below you can find your daily accepted reports</h3>
<table class="tablesorter">
	<thead>
		<tr>
			<th class="header">Power</th>
			<th>Bond Amount</th>
			<th>Defendant</th>
			<th>Charge</th>
			<th>Executing Agent</th>
			<th>Power Status</th>
		</tr>
	</thead>
	<tbody>
	<? foreach( $voided_powers as $p ): ?>
			<tr>
				<td><?= $p['prefix' ]; ?>-<?= $p['pek' ]; ?></td>
				<td><?= $p['amount' ]; ?></td>
				<td><?= $p['first_name' ]; ?> <?= $p['last_name' ]; ?></td>
				<td><?= $p['charge' ]; ?></td>
				<td><?= $p['executing_agent' ]; ?></td>
				<td><?= $p['status' ]; ?></td>
			</tr>
		<? endforeach; ?>
	</tbody>
</table>
<? if( count( $voided_powers ) > 10 ) $this->load->view('includes/pager'); ?>
<? endif; ?>