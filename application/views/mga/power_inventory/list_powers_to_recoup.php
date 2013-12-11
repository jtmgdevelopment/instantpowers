<h3 class="tit">Below you will find The Agents inventory Powers</h3>
<p>
	Please check the powers you would like to recoup. 
</p>


<? if( count( $recoup ) ): ?>

<?= form_open( '/mga/power_inventory/process_recoup_powers', array( 'id' => 'recoup_powers' ) ); ?>
<div class="t-right">
	<p class="box">
		<input type="submit" value="Recoup Powers" class="white" />
	</p>
</div>
	<table class="tablesorter">
		<thead>
		<tr>
			<th>Recoup</th>
			<th>Power Prefix</th>
			<th>Power Number</th>
			<th>Exp. Date</th>
		</tr>
		</thead>
		<tbody>
			<? foreach( $recoup as $i ): ?>
				<tr>
					<td width="30" align="center"><input  class="recoup" type="checkbox" name="transfer[]" value="<?= $i['power_id']; ?>" /></td>
					<td><?= $i['prefix']; ?></td>
					<td><?= $i['pek']; ?></td>
					<td><?= $i['exp_date']; ?></td>
				</tr>
			<? endforeach; ?>
		
		</tbody>
	</table>	
<? if( count( $recoup ) > 10 ) $this->load->view('includes/pager'); ?>
<div class="clearfix"></div>
	
<?= form_close(); ?>



<? else: ?>
<div class="msg info">You currently have no powers in your inventory</div>

<? endif; ?>
