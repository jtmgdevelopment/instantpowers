<h3 class="tit">Below you can recoup your powers from sub agents</h3>
<p>Below you can recoup your powers from sub agents. Please check the powers you would like to recoup</p>
<? if( count( $transfers ) ): ?>
<?= form_open( '/master_agent/power_inventory/process_recoup_powers' ); ?>

<table>
	<thead>
	<tr>
		<th>Recoup</th>
		<th>Sub Agent Name</th>
		<th>Power Number</th>
		<th>Power Prefix</th>
		<th>Exp Date</th>
		<th>Status</th>
	</tr>	
	</thead>
	<tbody>
		<? foreach( $transfers as $t ): ?>
			<tr>
				<td><input type="checkbox" name="recoup[]" value="<?= $t['pek']; ?>" /></td>		
				<td><?= $t['full_name']; ?></td>		
				<td><?= $t['pek']; ?></td>		
				<td><?= $t['full_prefix']; ?></td>		
				<td><?= $t['exp_date']; ?></td>		
				<td><?= $t['status']; ?></td>		
			</tr>		
		<? endforeach; ?>
	</tbody>
</table>
<div class="clearfix"></div>
<div class="t-right">
	<p class="box">
		<input type="submit" value="Recoup Powers" class="white" />
	</p>
</div>
<?= form_close(); ?>
<? else: ?>
<div class="msg info">There are currently no transferred powers</div>


<? endif; ?>