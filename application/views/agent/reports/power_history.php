<h3 class="tit">Below Are is the complete power history</h3>
<p>To view the power total history, click "View Detailed History"</p>



<? if( count( $history ) ): ?>



<p class="box">
	<a class="btn-list" href="<?= safe_url('/agent/reports', 'power_history', array( 'inventory' ) ); ?>"><span>View Inventory</span></a>
	<a class="btn-list" href="<?= safe_url('/agent/reports', 'power_history', array( 'voided' )); ?>"><span>View Voided</span></a>
	<a class="btn-list" href="<?= safe_url('/agent/reports', 'power_history', array( 'discharged' )); ?>"><span>View Discharged</span></a>
	<a class="btn-list" href="<?= safe_url('/agent/reports', 'power_history', array( 'executed' )); ?>"><span>View Executed</span></a>
	<a class="btn-list" href="<?= safe_url('/agent/reports', 'power_history', array( 'rewrite' )); ?>"><span>View Rewrite</span></a>
	<a class="btn-list" href="<?= safe_url('/agent/reports', 'power_history', array( 'transfer' )); ?>"><span>View Transfer</span></a>
</p>

	<table class="tablesorter">
		<thead>
			<tr>
				<th>Power Prefix</th>
				<th>Power Amount</th>
				<th>Power Number</th>
				<th>Defendant Name</th>
				<th>Current Power Status</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
			<? foreach( $history as $p ): ?>
			<tr>
				<td><?= $p['prefix']; ?></td>
				<td><?= $p['amount']; ?></td>
				<td><?= $p['pek']; ?></td>
				<td><?= $p['first_name'] . ' ' . $p[ 'last_name' ]; ?></td>
				<td><?= $p['status']; ?></td>
				<td>
					<a href="/agent/reports/view_detailed_agent_power_history/<?= $p['power_id']; ?>/<?= $mek; ?>" class="ico-info">View Detailed History</a>
					<? if( $p[ 'key' ] != 'inventory' ): ?>
						<a href="/agent/create_powers/print_power_copy/<?= $p['power_id']; ?>" class="ico-list">Print Power</a>
					<? endif; ?>	
				
				</td>
			</tr>
			<? endforeach; ?>
		</tbody>			
	</table>
	<? if( count( $history ) > 10 ) $this->load->view( 'includes/pager' ); ?>
	
	
<p class="box">
	<a href="/agent/power_inventory/" class="btn"><span>Clear Search</span></a>
</p>


<form action="/agent/power_inventory/search_inventory"  method="post">
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


<form action="/agent/power_inventory/search_inventory"  method="post">
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



<form action="/agent/power_inventory/search_inventory"  method="post">
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
	<div class="msg info"><p>This Agent does not have any powers</p></div>

<? endif; ?>