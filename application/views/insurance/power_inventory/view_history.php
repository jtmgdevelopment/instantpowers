<h3 class="tit">Hstory Results</h3>
<table>
	<thead>
		<tr>
			<th>History Note</th>
			<th>Date Created</th>
		</tr>
	</thead>
	<tbody>
		<? foreach( $history as $h ): ?>
		<tr>
			<td><?= $h[ 'log' ]; ?></td>
			<td><?= $h[ 'date' ]; ?></td>
		</tr>							
		<? endforeach; ?>
	</tbody>
</table>		

<p class="box">
	<a class="btn" href="/insurance/power_inventory/process_bail_bonds_agency/inventory/<?= $bail_agency; ?>"><span>Back To Inventory</span></a>
</p>