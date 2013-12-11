<h3 class="tit">Your Power Breakdown</h3>
<table>
<thead>
	<tr>
		<th>Power</th>
		<th>Amount Available</th>
	</tr>	
</thead>
<tbody>
	<? foreach( $power_breakdown as $p ): ?>
		<tr>
			<td><?= $p[ 'prefix' ] ?></td>
			<td><?= $p[ 'power_count' ] ?></td>		
		</tr>	
	<? endforeach; ?>
</tbody>
</table>


<h3 class="tit">Transfer Powers Below</h3>
<p>Enter The amount of powers you would like to transfer</p>
<?= form_open( '/agent/power_inventory/process_transfer_powers' ); ?>
<? foreach( $power_breakdown as $p ): ?>
	<p>
		<input name="<?= $p[ 'prefix' ] ?>" type="text" disabled="disabled" value="<?= $p[ 'prefix' ] ?>" />
		<input type="text" name="<?= $p[ 'prefix' ] ?>_amount" value="0" />
	</p>
<? endforeach; ?>
<div class="col50">
<?
	echo form_label('Sub Agent', 'sub_agent'); 
	echo form_dropdown('subagent', $sub_agents,  '', 'id="subagent"  ');
?>


</div>
<div class="clearfix"></div>
<div class="t-right">
	<p>
		<input type="submit" value="Transfer Powers To Agent" class="white" />
		<button type="button" class="white" onClick="location.href = '/agent/power_inventory/'">Cancel</button>
	</p>
</div>





<? form_close(); ?>