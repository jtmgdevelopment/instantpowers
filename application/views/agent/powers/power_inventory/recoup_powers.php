<h3 class="tit">Below you can recoup your powers from sub agents</h3>
<p>Below you can recoup your powers from sub agents. Please check the powers you would like to recoup</p>
<? if( count( $transfers ) ): ?>
<?= form_open( '/agent/power_inventory/process_recoup_powers', array( 'id' => 'recoup_powers' ) ); ?>
<input type="hidden" name="recoup_powers" value="" />
<div class="t-right">
	<p class="box">
		<a href="/agent/power_inventory" class="btn-list"><span>Back To Inventory</span></a>
		<input type="submit" value="Recoup Powers" class="white" />
	</dp>
</div>

<table class="tablesorter">
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
				<td><input class="recoup" type="checkbox" name="recoup[]" value="<?= $t['power_id']; ?>-<?= $t['mek']; ?>" /></td>		
				<td><?= $t['full_name']; ?></td>		
				<td><?= $t['pek']; ?></td>		
				<td><?= $t['full_prefix']; ?></td>		
				<td><?= $t['exp_date']; ?></td>		
				<td><?= $t['status']; ?></td>		
			</tr>		
		<? endforeach; ?>
	</tbody>
</table>
<? if( count( $transfers ) > 10 ) $this->load->view('includes/pager'); ?>

<div class="clearfix"></div>
<?= form_close(); ?>
<? else: ?>
<div class="msg info">There are currently no transferred powers</div>
<p class="box">
	<a href="/agent/power_inventory" class="btn-list"><span>Back To Inventory</span></a>
</p>
<? endif; ?>
