<? if( strlen( $message ) ): ?>
	<div class="msg done"><p><?= $message; ?></p></div>

<? endif; ?>

<h3 class="tit">Below you will find your inventory Powers</h3>

<p>
	If you would like to transfer powers to a sub agent, please check the powers in the <strong>"Transfer"</strong> column. 
	You will then be asked to specify which <strong>Sub Agent</strong> you would like these powers to go to.
</p>
<? if( count( $inventory ) ): ?>
<?= form_open( '/master_agent/power_inventory/process_transfer_powers', array( 'id' => 'transfer_powers' ) ); ?>
<div class="t-right">
	<p class="box">
		<a class="btn-list" href="/master_agent/power_inventory/recoup_powers"><span>Recoup Powers From Agents</span></a>
		<input type="submit" value="Transfer Powers" class="white" />
	
	</p>
</div>
		<table class="tablesorter">
		<thead>
		<tr>
			<th>Transfer</th>
			<th class="header">Insurance Company</th>
			<th>Insurance Agent</th>
			<th>Power Prefix</th>
			<th>Power Number</th>
			<th>Exp. Date</th>
			<th>Actions</th>
		</tr>
		</thead>
		<tbody>
			<? foreach( $inventory as $i ): ?>
				<tr>
					<td width="30" align="center"><input  class="transfer" type="checkbox" name="transfer[]" value="<?= $i['prefix_id']; ?>-<?= $i['pek']; ?>" /></td>
					<td><?= $i['agency_name']; ?></td>
					<td><?= $i['full_name']; ?></td>
					<td><?= $i['prefix']; ?></td>
					<td><?= $i['pek']; ?></td>
					<td><?= $i['exp_date']; ?></td>
					<td><a href="/master_agent/powers/execute/<?= $i['transmission_id']; ?>/<?= $i['pek']; ?>" class="ico-settings">Execute Power</a></td>
				</tr>
			
			<? endforeach; ?>
		
		</tbody>
	</table>	
<? $this->load->view('includes/pager'); ?>
<div class="clearfix"></div>
	
<?= form_close(); ?>
<? else: ?>
<div class="msg info">You currently have no powers in your inventory</div>

<? endif; ?>
