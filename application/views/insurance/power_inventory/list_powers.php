
<fieldset>
	<legend>Agency Powers ~ <?= count( $powers ); ?> Total Powers</legend>



<p class="box">
	<a href="/insurance/power_inventory/process_bail_bonds_agency/<?= (!$status ? 'inventory' : $status ); ?>/<?= $bail_agency; ?>" class="btn"><span>Clear Search</span></a>
</p>

<p class="box">
	<a class="btn-list" href="<?= safe_url( $controller, $method, array( 'inventory', $bail_agency ) ); ?>"><span>View Inventory NE</span></a>
	<a class="btn-list" href="<?= safe_url( $controller, $method, array( 'voided', $bail_agency ) ); ?>"><span>View Voided</span></a>
	<a class="btn-list" href="<?= safe_url( $controller, $method, array( 'discharged', $bail_agency ) ); ?>"><span>View Discharged</span></a>
	<a class="btn-list" href="<?= safe_url( $controller, $method, array( 'executed', $bail_agency ) ); ?>"><span>View Executed NR</span></a>
	<a class="btn-list" href="<?= safe_url( $controller, $method, array( 'rewrite', $bail_agency ) ); ?>"><span>View Rewrite</span></a>
	<a class="btn-list" href="<?= safe_url( $controller, $method, array( 'transfer', $bail_agency ) ); ?>"><span>View Transfer</span></a>
</p>
<p class="smaller low">Filter powers by the above power status</p>

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
						<? if( $p[ 'key' ] == 'inventory' ): ?>
						<a href="/insurance/power_inventory/void_power/<?= $p[ 'power_id' ]; ?>/<?= $bail_agency; ?>" class="ico-delete">Void/Recoup Power</a>
						<? else: ?>
							<a href="/insurance/power_inventory/view_power/<?= $p[ 'power_id' ]; ?>/<?= $bail_agency; ?>" class="ico-show">View Power</a>						
						<? endif; ?>
						<a href="/insurance/power_inventory/view_history/<?= $p[ 'power_id' ]; ?>/<?= $bail_agency; ?>" class="ico-list">View History</a>
					</td>		
				</tr>
			<? endforeach; ?>
		</tbody>
	</table>			
<? if( count( $powers ) > 10 ) $this->load->view('includes/pager'); ?>

<form action="/insurance/power_inventory/process_bail_bonds_agency"  method="post">
<input type="hidden" name="bail_agency" value="<?= $bail_agency; ?>" />
<fieldset>
	<legend>Search By Power Number</legend>
		<div class="col50"> 
		<label>Prefix</label>
		<select name="prefix">
		<? foreach($prefixes as $p ): ?>
			<option value="<?= $p[ 'prefix_id']; ?>"><?= $p[ 'prefix' ]; ?></option>
		<? endforeach; ?> 
		</select>
 		</div>
		<div class="col50">
		<label>Power Number</label>
		<input type="text" name="search" value="<?= set_value('search') ?>" />
		</div>
</fieldset>
		<div class="t-right">
		<input type="submit" value="search Powers">
		</div>
</form> 


<form action="/insurance/power_inventory/process_bail_bonds_agency"  method="post">
<input type="hidden" name="bail_agency" value="<?= $bail_agency; ?>" />
<fieldset>
	<legend>Search By Defendant Name</legend>
		<div class="col50"> 
		<label>Defendant First Name</label>
			<input type="text" name="defendant_first" value="" />
		</div>
		<div class="col50"> 
		<label>Defendant Last Name</label>
			<input type="text" name="defendant_last" value="" />
		</div>
</fieldset>
		<div class="t-right">
		<input type="submit" value="search Powers">
		</div>
</form> 



<form action="/insurance/power_inventory/process_bail_bonds_agency"  method="post">
<input type="hidden" name="bail_agency" value="<?= $bail_agency; ?>" />

<fieldset>
	<legend>Search By Expiration Dates</legend>

	<div class="col50">
		<?
			$opts = array(
				'name' 	=> 'exp_start_date',
				'id'	=> 'exp_start_date',
				'value'	=> '',
				'class'	=> 'datepicker'
								
			);
			echo form_label('Start Date', 'exp_start_date'); 
			echo form_input($opts);
		?>
	</div>	
	<div class="col50">
		<?
			$opts = array(
				'name' 	=> 'exp_end_date',
				'id'	=> 'exp_end_date',
				'value'	=> '',
				'class'	=> 'datepicker'
								
			);
			echo form_label('End Date', 'exp_end_date'); 
			echo form_input($opts);
		?>


	</div>	
	
	
</fieldset>	
<div class="t-right">
	<p>
		<input type="submit" value="Search By EXP. Date" class="white" />
	</p>


</div>

</form>

<form action="/insurance/power_inventory/process_bail_bonds_agency"  method="post">
<input type="hidden" name="bail_agency" value="<?= $bail_agency; ?>" />

<fieldset>
	<legend>Search By Dates</legend>

	<div class="col50">
		<?
			$opts = array(
				'name' 	=> 'start_date',
				'id'	=> 'start_date',
				'value'	=> '',
				'class'	=> 'datepicker'
								
			);
			echo form_label('Start Date', 'start_date'); 
			echo form_input($opts);
		?>
	</div>	
	<div class="col50">
		<?
			$opts = array(
				'name' 	=> 'end_date',
				'id'	=> 'end_date',
				'value'	=> '',
				'class'	=> 'datepicker'
								
			);
			echo form_label('End Date', 'end_date'); 
			echo form_input($opts);
		?>


	</div>	
	
	
</fieldset>	
<div class="t-right">
	<p>
		<input type="submit" value="Search By Date" class="white" />
	</p>


</div>
</form>
<fieldset>




<? else: ?>
<div class="msg info"><p>There are currently no powers of this status</p></div>

<? endif; ?>	
</fieldset>		


