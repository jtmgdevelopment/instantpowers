<h3 class="tit">Below you will find your inventory Powers</h3>
<p class="box">
	<a class="btn-list" href="/sub_agent/power_inventory/index/inventory"><span>View Inventory</span></a>
	<a class="btn-list" href="/sub_agent/power_inventory/index/executed"><span>View Executed</span></a>
	<a class="btn-list" href="/sub_agent/power_inventory/index/discharged"><span>View Discharged</span></a>
	<a class="btn-list" href="/sub_agent/power_inventory/index/voided"><span>View Voided</span></a>
</p>
<? if( count( $inventory ) ): ?>
<?= form_open( '/master_agent/power_inventory/process_transfer_powers' ); ?>
	<table class="tablesorter">
		<thead>
		<tr>
			<th>Power Prefix</th>
			<th>Power Number</th>
			<th>Exp. Date</th>
			<th>Status</th>
			<th>Actions</th>
		</tr>
		</thead>
		<tbody>
			<? foreach( $inventory as $i ): ?>
				<tr>
					<td><?= $i['prefix']; ?></td>
					<td><?= $i['pek']; ?></td>
					<td><?= $i['exp_date']; ?></td>
					<td><?= $i['status']; ?></td>
					<td align="center">
					
						<? if( $type == 'inventory' ): ?>
							<a href="/sub_agent/powers/view/<?= $i['transmission_id']; ?>/<?= $i['pek']; ?>" class="ico-settings">Execute Power</a>
							<a href="/sub_agent/powers/void/<?= $i['transmission_id']; ?>/<?= $i['pek']; ?>" class="ico-delete">Void Power</a>
						<? elseif( $type == 'executed' ): ?>
							<a href="/sub_agent/powers/void/<?= $i['transmission_id']; ?>/<?= $i['pek']; ?>" class="ico-delete">Void Power</a>
							<a href="/sub_agent/powers/discharge/<?= $i['transmission_id']; ?>/<?= $i['pek']; ?>" class="ico-settings">Discharge Power</a>
						<? elseif( $type == 'discharged' ): ?>
							<a href="/sub_agent/powers/void/<?= $i['transmission_id']; ?>/<?= $i['pek']; ?>" class="ico-delete">Void Power</a>

						<? elseif( $type == 'voided' ): ?>
												
						<? 	endif; ?>					
						<a href="/sub_agent/powers/view_history/<?= $i['pek']; ?>/<?= $i['prefix_id']; ?>" class="ico-show">View History</a>
					
					</td>
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
