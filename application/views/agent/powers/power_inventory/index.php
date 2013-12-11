<? if( strlen( $message ) ): ?>
	<div class="msg done"><p><?= $message; ?></p></div>

<? endif; ?>



<? if( count( $inventory )  && isset( $power_breakdown ) ): ?>

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
<? if( $role == 'master_agent' ): ?>
<p>
	If you would like to transfer powers to a sub agent, please check the powers in the <strong>"Transfer"</strong> column. 
	You will then be asked to specify which <strong>Sub Agent</strong> you would like these powers to go to.
</p>
<? endif; ?>


<? if( count( $inventory ) ): ?>

<?= form_open( '/agent/power_inventory/process_transfer_powers', array( 'id' => 'transfer_powers' ) ); ?>
<div class="t-right">
	<? if( $role == 'master_agent' ): ?>
	<p class="box">
		<a class="btn-list" href="/agent/power_inventory/recoup_powers"><span>Recoup Powers From Agents</span></a>
		<a class="btn-list" href="/agent/power_inventory/initiate_transfer"><span>Transfer Powers</span></a>
	</p>
	<? endif; ?>
</div>
		<table class="tablesorter">
		<thead>
		<tr>
			<th class="header">Insurance Company</th>
			<th>Ins. Co. Rep</th>
			<th>Power Prefix</th>
			<th>Power Number</th>
			<th>Exp. Date</th>
			<th>Actions</th>
		</tr>
		</thead>
		<tbody>
			<? foreach( $inventory as $i ): ?>
				<tr>
					<td><?= $i['agency_name']; ?></td>
					<td><?= $i['full_name']; ?></td>
					<td><?= $i['prefix']; ?></td>
					<td><?= $i['pek']; ?></td>
					<td><?= $i['exp_date']; ?></td>
					<td>
						<? if( isset( $history ) ): ?>
							<a target="_blank" href="/agent/reports/view_detailed_agent_power_history/<?= $i['power_id']; ?>/<?= $mek; ?>/hide" class="ico-settings">View History</a>						
						<? endif; ?>
						<? if( $i[ 'key' ] == 'inventory' ): ?>
							<a href="/agent/create_powers/execute/<?= $i['transmission_id']; ?>/<?= $i['power_id']; ?>" class="ico-settings">Execute Power</a>
						<? endif; ?>	
					</td>
				</tr>
			
			<? endforeach; ?>
		
		</tbody>
	</table>	
<? if( count( $inventory ) > 10 ) $this->load->view('includes/pager'); ?>
<div class="clearfix"></div>
	
<?= form_close(); ?>



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
<div class="msg info">You currently have no powers in your inventory</div>

<? endif; ?>
