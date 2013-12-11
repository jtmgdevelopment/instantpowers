<h3 class="tit">Defendant/Indemnitor/Collateral Information</h3>
<?= form_open('/sub_agent/powers/process_step_two'); ?>
<input type="hidden" name="pek" value="<?= $pek;?>" />
<input type="hidden" name="trans_id" value="<?= $trans_id;?>" />
<section>
<fieldset>
	<legend>Defendant Information</legend>
		<div class="col50">
		<?
		
			$opts = array(
				'name' 	=> 'defendant_first_name',
				'id'	=> 'defendant_first_name',
				'value'	=> $sp[0]->defendant->first_name
								
			);
			echo form_label('First Name', 'defendant_first_name'); 
			echo form_input($opts);
		?>
		</div>
		<div class="col50">
		<?
			$opts = array(
				'name' 	=> 'defendant_last_name',
				'id'	=> 'defendant_last_name',
				'value'	=> $sp[0]->defendant->last_name
								
			);
			echo form_label('First Name', 'defendant_first_name'); 
			echo form_input($opts);
		?>
		</div>
		<div class="clearfix"></div>
		<div class="col50">
		<?
			$opts = array(
				'name' 	=> 'defendant_email',
				'id'	=> 'defendant_email',
				'value'	=> ''
								
			);
			echo form_label('Email', 'defendant_email'); 
			echo form_input($opts);
		?>
		</div>
		<div class="col50">
		<?
			$opts = array(
				'name' 	=> 'defendant_social_security_number',
				'id'	=> 'defendant_social_security_number',
				'value'	=> '',
				'class'	=> 'ssn'
								
			);
			echo form_label('Social Security Number', 'defendant_social_security_number'); 
			echo form_input($opts);
		?>
		</div>
		<div class="clearfix"></div>
		<div class="col50">
		<?
			$opts = array(
				'name' 	=> 'defendant_dl',
				'id'	=> 'defendant_dl',
				'value'	=> ''
								
			);
			echo form_label('Drivers License', 'defendant_dl'); 
			echo form_input($opts);
		?>
		</div>
		<div class="col50">
		<?
			$opts = array(
				'name' 	=> 'defendant_dob',
				'id'	=> 'defendant_dob',
				'value'	=> '',
				'class'	=> 'datepicker'
								
			);
			echo form_label('DOB', 'defendant_dob'); 
			echo form_input($opts);
		?>
		</div>
		<div class="clearfix"></div>
		<div class="col50">
		<?
			$opts = array(
				'name' 	=> 'defendant_address',
				'id'	=> 'defendant_address',
				'value'	=> ''
								
			);
			echo form_label('Address', 'defendant_address'); 
			echo form_input($opts);
		?>
		</div>
		<div class="col50">
		<?
			$opts = array(
				'name' 	=> 'defendant_city',
				'id'	=> 'defendant_city',
				'value'	=> ''
								
			);
			echo form_label('City', 'defendant_city'); 
			echo form_input($opts);
		?>
		</div>
		<div class="clearfix"></div>
		<div class="col50">
		<?
			$opts = array(
				'name' 	=> 'defendant_state',
				'id'	=> 'defendant_state',
				'value'	=> ''
								
			);
			echo form_label('Address', 'defendant_state'); 
			echo form_input($opts);
		?>
		</div>
		<div class="col50">
		<?
			$opts = array(
				'name' 	=> 'defendant_zip',
				'id'	=> 'defendant_zip',
				'value'	=> '',
				'class'	=> 'zip'
								
			);
			echo form_label('Zip', 'defendant_zip'); 
			echo form_input($opts);
		?>
		</div>
		<div class="clearfix"></div>
		<div class="col50">
		<?
			$opts = array(
				'name' 	=> 'defendant_phone',
				'id'	=> 'defendant_phone',
				'value'	=> '',
				'class'	=> 'phone'
								
			);
			echo form_label('Phone', 'defendant_phone'); 
			echo form_input($opts);
		?>
		</div>
		<div class="clearfix"></div>

</fieldset>

<fieldset>
	<legend>Indemnitor Information</legend>
		<div class="col50">
		<?
			$opts = array(
				'name' 	=> 'indemnitor_first_name',
				'id'	=> 'indemnitor_first_name',
				'value'	=> ''
								
			);
			echo form_label('First Name', 'indemnitor_first_name'); 
			echo form_input($opts);
		?>
		</div>
		<div class="col50">
		<?
			$opts = array(
				'name' 	=> 'indemnitor_last_name',
				'id'	=> 'indemnitor_last_name',
				'value'	=> ''
								
			);
			echo form_label('First Name', 'indemnitor_first_name'); 
			echo form_input($opts);
		?>
		</div>
		<div class="clearfix"></div>
		<div class="col50">
		<?
			$opts = array(
				'name' 	=> 'indemnitor_email',
				'id'	=> 'indemnitor_email',
				'value'	=> ''
								
			);
			echo form_label('Email', 'indemnitor_email'); 
			echo form_input($opts);
		?>
		</div>
		<div class="col50">
		<?
			$opts = array(
				'name' 	=> 'indemnitor_social_security_number',
				'id'	=> 'indemnitor_social_security_number',
				'value'	=> '',
				'class'	=> 'ssn'
								
			);
			echo form_label('Social Security Number', 'indemnitor_social_security_number'); 
			echo form_input($opts);
		?>
		</div>
		<div class="clearfix"></div>
		<div class="col50">
		<?
			$opts = array(
				'name' 	=> 'indemnitor_dl',
				'id'	=> 'indemnitor_dl',
				'value'	=> ''
								
			);
			echo form_label('Drivers License', 'indemnitor_dl'); 
			echo form_input($opts);
		?>
		</div>
		<div class="col50">
		<?
			$opts = array(
				'name' 	=> 'indemnitor_dob',
				'id'	=> 'indemnitor_dob',
				'value'	=> '',
				'class'	=> 'datepicker'
								
			);
			echo form_label('DOB', 'indemnitor_dob'); 
			echo form_input($opts);
		?>
		</div>
		<div class="clearfix"></div>
		<div class="col50">
		<?
			$opts = array(
				'name' 	=> 'indemnitor_address',
				'id'	=> 'indemnitor_address',
				'value'	=> ''
								
			);
			echo form_label('Address', 'indemnitor_address'); 
			echo form_input($opts);
		?>
		</div>
		<div class="col50">
		<?
			$opts = array(
				'name' 	=> 'indemnitor_city',
				'id'	=> 'indemnitor_city',
				'value'	=> ''
								
			);
			echo form_label('City', 'indemnitor_city'); 
			echo form_input($opts);
		?>
		</div>
		<div class="clearfix"></div>
		<div class="col50">
		<?
			$opts = array(
				'name' 	=> 'indemnitor_state',
				'id'	=> 'indemnitor_state',
				'value'	=> ''
								
			);
			echo form_label('Address', 'indemnitor_state'); 
			echo form_input($opts);
		?>
		</div>
		<div class="col50">
		<?
			$opts = array(
				'name' 	=> 'indemnitor_zip',
				'id'	=> 'indemnitor_zip',
				'value'	=> '',
				'class'	=> 'zip'
								
			);
			echo form_label('Zip', 'indemnitor_zip'); 
			echo form_input($opts);
		?>
		</div>
		<div class="clearfix"></div>
		<div class="col50">
		<?
			$opts = array(
				'name' 	=> 'indemnitor_phone',
				'id'	=> 'indemnitor_phone',
				'value'	=> '',
				'class' => 'phone'
								
			);
			echo form_label('Phone', 'indemnitor_phone'); 
			echo form_input($opts);
		?>
		</div>
		<div class="clearfix"></div>

</fieldset>


<fieldset>
	<legend>Collateral Information</legend>
		<div class="col50">
		<?
			$opts = array(
				'' => 'select one',
				'1' => 'Currency'				
			);
			echo form_label('Collateral Type', 'collateral_type'); 
			echo form_dropdown('collateral_type', $opts);
		?>
		</div>
		<div class="col50">
		<?
			$opts = array(
				'' => 'select one',
				'1'=> 'Defendant'
			);
			echo form_label('Collateral Owner', 'colleteral_owner'); 
			echo form_dropdown('collateral_owner', $opts);
		?>
		</div>
		<div class="clearfix"></div>
		<div class="col50">
		<?
			$opts = array(
				'name' 	=> 'collateral_amount',
				'id'	=> 'collateral_amount',
				'value'	=> ''
								
			);
			echo form_label('Collateral Amount', 'collateral_amount'); 
			echo form_input($opts);
		?>
		</div>
		<div class="col50">
		<?
			$opts = array(
				'name' 	=> 'collateral_description',
				'id'	=> 'collateral_description',
				'value'	=> set_value( 'collateral_description' )
								
			);
			echo form_label('Description', 'collateral_description'); 
			echo form_textarea($opts);
		?>
		</div>

</fieldset>
<div class="t-right">
	<p>
		<input type="submit" value="Complete Power And View Summary" class="white" />
		<button type="button" class="white" onClick="location.href = '/master_agent/powers/cancel_power/<?= $trans_id; ?>/<?= $pek ?>'">Cancel</button>
	</p>
</div>

<?= form_close(); ?>
</section>
