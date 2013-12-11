<? if( isset( $message ) ): ?>
<div class="msg done"><p>The powers have been recouped.</p></div>

<? endif; ?>

<? if( count( $inventory ) ): ?>

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
<br  />
<? endif; ?>


<h3 class="tit">Below you will find your inventory Powers</h3>
<p>
	If you would like to transfer powers to an agent, please check the powers in the <strong>"Transfer"</strong> column. 
	You will then be asked to specify which <strong>Agent</strong> you would like these powers to go to.
</p>

<? if( count( $inventory ) ): ?>



<?= form_open( '/mga/power_inventory/process_transfer_powers', array( 'id' => 'transfer_powers' ) ); ?>
<div class="t-right">
	<p class="box">
		<a class="btn-list" href="/mga/power_inventory/recoup_powers"><span>Recoup Powers From Agents</span></a>
		<a class="btn-list" href="/mga/power_inventory/initiate_transfer"><span>Transfer Powers</span></a>
	</p>
</div>
	<table class="tablesorter">
		<thead>
		<tr>
			<th>Power Prefix</th>
			<th>Power Number</th>
			<th>Exp. Date</th>
		</tr>
		</thead>
		<tbody>
			<? foreach( $inventory as $i ): ?>
				<tr>
					<td><?= $i['prefix']; ?></td>
					<td><?= $i['pek']; ?></td>
					<td><?= $i['exp_date']; ?></td>
				</tr>
			<? endforeach; ?>
		
		</tbody>
	</table>	
<? if( count( $inventory ) > 10 ) $this->load->view('includes/pager'); ?>
<div class="clearfix"></div>
	
<?= form_close(); ?>



<? else: ?>
<div class="msg info">You currently have no powers in your inventory</div>

<? endif; ?>
