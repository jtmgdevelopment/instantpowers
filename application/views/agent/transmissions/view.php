<h3 class="tit">Detailed transmission information</h3>
<fieldset>
	<legend>Transmission Information</legend>	
	<div class="col50">
		<label>Creation Date</label>
		<p class="row"><?= $transmission->created_date ?></p>
	</div>
	<div class="col50">
		<label>Expiration Date</label>
		<p class="row"><?= $transmission->exp_date ?></p>
	</div>
	<div class="col50">
		<label>Transmission Status</label>
		<p class="row"><?= $transmission->status ?></p>
	</div>		
</fieldset>

<fieldset>
	<legend>Assigned Agent</legend>
	<div class="col50">
		<label>Agent Name</label>
		<p class="row"><?= $transmission->bail_agent; ?></p>
	</div>
	<div class="col50">
		<label>Agent Email</label>
		<p class="row"><?= $transmission->email; ?></p>
	</div>
</fieldset>		

<fieldset>
	<legend>Transmission Powers</legend>
<p class="box">
	<a class="btn-list" href="<?= safe_url('/agent/transmissions', 'view', array( $transmission->trans_id,  'inventory' ) ); ?>"><span>View Inventory</span></a>
	<a class="btn-list" href="<?= safe_url('/agent/transmissions', 'view', array( $transmission->trans_id,  'voided' )); ?>"><span>View Voided</span></a>
	<a class="btn-list" href="<?= safe_url('/agent/transmissions', 'view', array( $transmission->trans_id,  'discharged' )); ?>"><span>View Discharged</span></a>
	<a class="btn-list" href="<?= safe_url('/agent/transmissions', 'view', array( $transmission->trans_id, 'executed' )); ?>"><span>View Executed</span></a>
	<a class="btn-list" href="<?= safe_url('/agent/transmissions', 'view', array( $transmission->trans_id, 'rewrite' )); ?>"><span>View Rewrite</span></a>
	<a class="btn-list" href="<?= safe_url('/agent/transmissions', 'view', array( $transmission->trans_id, 'transfer' )); ?>"><span>View Transfer</span></a>
</p>
<? if( count( $powers ) ): ?> 
	<table class="tablesorter">
		<thead>
			<tr>
				<th>Power Number</th>
				<th>Prefix</th>
				<th>Amount</th>
				<th>Exp. Date</th>
				<th>Power Status</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
			<? foreach( $powers as $p ): ?>
				<tr>
					<td><?= $p['pek']; ?></td>
					<td><?= $p['prefix']; ?></td>
					<td><?= $p['amount']; ?></td>
					<td><?= $p['exp_date']; ?></td>
					<td><?= $p['status']; ?></td>
					<td>
						<? if( $p[ 'key' ] == 'executed' ): ?>
							<a href="<?= safe_url('/agent/create_powers', 'discharge', array( $transmission->trans_id, $p[ 'power_id' ] ) ); ?>" class="ico-settings">Discharge Power</a> 
							| 
							<a href="<?= safe_url('/agent/create_powers', 'void', array( $transmission->trans_id, $p[ 'power_id' ] ) ); ?>" class="ico-warning">Void Power</a>
						
						
						<? elseif( $p[ 'key' ] == 'inventory' ): ?>
							<a href="<?= safe_url('/agent/create_powers', 'execute', array( $transmission->trans_id, $p[ 'power_id' ] ) ); ?>" class="ico-settings">Execute Power</a> 
							| 
							<a href="<?= safe_url('/agent/create_powers', 'void', array( $transmission->trans_id, $p[ 'power_id' ] ) ); ?>" class="ico-warning">Void Power</a>

						<? elseif( $p[ 'key' ] == 'discharged' ): ?>
							
							<a href="<?= safe_url('/agent/create_powers', 'void', array( $transmission->trans_id, $p[ 'power_id' ]  ) ); ?>" class="ico-warning">Void Power</a>
						<? elseif( $p[ 'key' ] == 'voided' ): ?>
						
						<? endif; ?>
						<? if(  $p[ 'key' ] != 'inventory' ): ?>
							|
							<a class="ico-show" href="/_tasks/<?= strtolower( str_replace(' ', '_', $transmission->agency_name ) ); ?>_print_power.cfm?powers=<?= $p[ 'power_id' ]; ?>&mek=<?= $mek; ?>">Print Power</a>
						<? endif; ?>	
							| 
							<a class="ico-show" href="<?= safe_url('/agent/create_powers', 'view_history', array( $p[ 'power_id' ] ) ); ?>">View History</a>
					</td>		
				</tr>
			<? endforeach; ?>
		</tbody>
	</table>			
<? $this->load->view('includes/pager'); ?>
<? else: ?>
<div class="msg info"><p>There are currently no powers of this status</p></div>

<? endif; ?>	
</fieldset>		


