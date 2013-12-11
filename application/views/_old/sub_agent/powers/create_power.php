<h3 class="tit">Required Power Information</h3>
<p><strong>Please Provide the general power information</strong></p>
<?= form_open('/sub_agent/powers/process_step_one'); ?>
<input type="hidden" name="pek" value="<?= $pek;?>" />
<input type="hidden" name="trans_id" value="<?= $trans_id;?>" />
<input type="hidden" name="power_amount" value="<?= preg_replace('/[\$,]/', '', $powers->amount); ?>" />
<input type="hidden" name="prefix_id" value="<?= $powers->prefix_id; ?>" />
<section>
<fieldset>
	<legend>Set Power Status</legend>
	<div class="col50">
			<?
				$power_status = array( 'executed' => 'Executed Bond' );
				
				echo form_label('Power Status', 'power_status'); 
				echo form_dropdown('power_status', $power_status,  '', 'id="power_status"  ');
			?>
		</div>
	<div class="col50">
		<?
			echo form_label('Current Status','current_status');		
		?>
		<p class="row"><strong><?= $powers->status;?></strong></p>
	</div>	
	
</fieldset>
<fieldset>
	<legend>Power Detail</legend>
	<div class="col50">
		<?
			$opts = array(
				'name' 	=> 'bond_amount',
				'id'	=> 'bond_amount',
				'value'	=> set_field( $power, 'bond_amount' )
								
			);
			echo form_label('Bond Amount*', 'bond_amount'); 
			echo form_input($opts);
		?>
	</div>
	<div id="executed" class="col50 power-opts">
		<?
			$opts = array(
				'name' 	=> 'execution_date',
				'id'	=> 'execution_date',
				'value'	=> set_field( $power, 'execution_date' ),
				'class'	=> 'datepicker'
								
			);
			echo form_label('Execution Date', 'execution_date'); 
			echo form_input($opts);
		?>
	</div>	
	<div id="discharged" class="col50 power-opts hide">
		<?
			$opts = array(
				'name' 	=> 'discharge_date',
				'id'	=> 'discharge_date',
				'value'	=> set_field( $power, 'discharge_date' ),
				'class'	=> 'datepicker'
								
			);
			echo form_label('Discharge Date', 'discharge_date'); 
			echo form_input($opts);
		?>


	</div>	
	<div id="voided" class="col50 power-opts hide">
		<?
			$opts = array(
				'name' 	=> 'voided_date',
				'id'	=> 'voided_date',
				'value'	=> set_field( $power, 'voided_date' ),
				'class'	=> 'datepicker'
								
			);
			echo form_label('Voided Date', 'voided_date'); 
			echo form_input($opts);
		?>
	</div>	
	<div id="rewrite" class="col50 power-opts hide">
		<?
			$opts = array(
				'name' 	=> 'rewrite_date',
				'id'	=> 'rewrite_date',
				'value'	=> set_field( $power, 'rewrite_date' ),
				'class'	=> 'datepicker'
								
			);
			echo form_label('Rewrite Date', '_date'); 
			echo form_input($opts);
		?>
	</div>	
	<div id="transfer" class="col50 power-opts hide">
		<?
			$opts = array(
				'name' 	=> 'requesting_agency',
				'id'	=> 'requesting_agency',
				'value'	=> set_field( $power, 'requesting_agency' )
								
			);
			echo form_label('Requesting Agency', 'Requesting Agency'); 
			echo form_input($opts);
		?>
		<div class="clearfix"></div>

		<?
			$opts = array(
				'name' 	=> 'transfer_date',
				'id'	=> 'transfer_date',
				'value'	=> set_field( $power, 'transfer_date' ),
				'class'	=> 'datepicker'
								
			);
			echo form_label('Transfer Date', 'transfer_date'); 
			echo form_input($opts);
		?>
	</div>	
</fieldset>
<fieldset id="extended">
	<legend>Extended Power Information</legend>
	<div class="col50"> 
		<?
			$opts = array(
				'name' 	=> 'court_date',
				'id'	=> 'court_date',
				'class'	=> 'datepicker',
				'value'	=>  set_field( $power, 'court_date' )
								
			);
			echo form_label('Court Date', 'court_date'); 
			echo form_input($opts);
		?>
	</div>
	<div class="col50"> 
		<?
			$opts = array(
				'name' 	=> 'court_time',
				'id'	=> 'court_time',
				'value'	=> set_field( $power, 'court_time' ),
				'class'	=> 'timepicker'
								
			);
			echo form_label('Court Time', 'court_time'); 
			echo form_input($opts);
		?>
	</div>
	<div class="clearfix"></div>
	<div class="col50"> 
		<?
			$opts = array(
				'name' 	=> 'court',
				'id'	=> 'court',
				'value'	=> set_field( $power, 'court' )
								
			);
			echo form_label('Court*', 'court'); 
			echo form_input($opts);
		?>
	</div>
	<div class="col50"> 
		<?
			$opts = array(
				'name' 	=> 'county',
				'id'	=> 'county',
				'value'	=> set_field( $power, 'county' )
								
			);
			echo form_label('County*', 'county'); 
			echo form_input($opts);
		?>
	</div>
	<div class="clearfix"></div>
	<div class="col50"> 
		<?
			$opts = array(
				'name' 	=> 'case_number',
				'id'	=> 'case_number',
				'value'	=> set_field( $power, 'case_number' )
								
			);
			echo form_label('Case Number*', 'case_number'); 
			echo form_input($opts);
		?>
	</div>
	<div class="col50"> 
		<?
			$opts = array(
				'name' 	=> 'charge',
				'id'	=> 'charge',
				'value'	=> set_field( $power, 'charge' )
								
			);
			echo form_label('Charge*', 'charge'); 
			echo form_input($opts);
		?>
	</div>

	<div class="clearfix"></div>
	<div class="col50"> 
		<?
			$opts = array(
				'name' 	=> 'city',
				'id'	=> 'city',
				'value'	=> set_field( $power, 'city' )
								
			);
			echo form_label('City*', 'city'); 
			echo form_input($opts);
		?>
	</div>
	<div class="col50"> 
		<?
			echo form_label('State*', 'state'); 
			echo state_dropdown('state', set_value('state'),set_field( $power, 'state' ));		
		?>
	</div>
	<div class="clearfix"></div>
	<div class="col50"> 
		<?
			$opts = array(
				'name' 	=> 'defendant_fname',
				'id'	=> 'defendant_fname',
				'value'	=> set_field( $power, 'defendant_fname' )
								
			);
			echo form_label('Defendant First Name*', 'defendant_fname'); 
			echo form_input($opts);
		?>
	</div>
	<div class="col50"> 
		<?
			$opts = array(
				'name' 	=> 'defendant_lname',
				'id'	=> 'defendant_lname',
				'value'	=> set_field( $power, 'defendant_lname' )
								
			);
			echo form_label('Defendant Last Name*', 'defendant_lname'); 
			echo form_input($opts);
		?>
	</div>
	<div class="clearfix"></div>
	<div class="col50"> 
		<?
			$opts = array(
				'name' 	=> 'executing_agent',
				'id'	=> 'executing_agent',
				'value'	=> set_field( $power, 'executing_agent' )
								
			);
			echo form_label('Executing Agent*', 'executing_agent'); 
			echo form_input($opts);
		?>
	</div>
	<div class="clearfix"></div>
	
	
</fieldset>
<div class="t-right">
	<p>
		<input type="submit" value="Complete Power and View Summary" class="white" />
		<input type="submit" value="Add Defendant Information" class="white" name="add_defendant" />
		<button type="button" class="white" onClick="location.href = '/sub_agent/powers/cancel_power/<?= $trans_id; ?>/<?= $pek ?>'">Cancel</button>
	</p>
</div>
</section>
<?= form_close(); ?>
