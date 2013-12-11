<h3 class="tit">Confirm The Powers To be Transferred: <?= $agent->agency_name; ?></h3>
<p class="box">
	<a href="/mga/power_inventory/complete_transfer" class="btn-create"><span>Transfer Powers</span></a>
	<a href="/mga/power_inventory" class="btn-delete"><span>Cancel</span></a>
</p>
<table>
	<thead>
		<tr>
			<th>Power</th>
			<th>Power Number</th>
		</tr>
	</thead>		
	<tbody>
<? foreach( $powers as $p ): ?>
	<? foreach( $p as $trans ): ?>
		<tr>
			<td><?= $trans[ 'prefix' ]; ?></td>
			<td><?= $trans[ 'pek' ]; ?></td>
		</tr>
	<? endforeach; ?>
<? endforeach; ?>
	</tbody>
</table>	