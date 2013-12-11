<h3 class="tit">Defendant/Indemnitor/Collateral Information</h3>
<?= form_open('/defendant/manage/save'); ?>
<input type="hidden" name="power_id" value="<?= $power_id; ?>" />

<section>
<fieldset>
	<legend>Defendant Information</legend>
		<div class="col50">
		<?
		
			$opts = array(
				'name' 	=> 'defendant_fname',
				'id'	=> 'defendant_first_name',
				'value'	=> set_field( $defendant , 'defendant_fname' )
								
			);
			echo form_label('First Name', 'defendant_first_name'); 
			echo form_input($opts);
		?>
		</div>
		<div class="col50">
		<?
			$opts = array(
				'name' 	=> 'defendant_lname',
				'id'	=> 'defendant_last_name',
				'value'	=> set_field( $defendant , 'defendant_lname' )
								
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
				'value'	=> set_field( $defendant , 'defendant_email' )
								
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
				'value'	=> set_field( $defendant , 'defendant_ssn' ),
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
				'value'	=> set_field( $defendant , 'defendant_dl' )
								
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
				'value'	=> set_field( $defendant , 'defendant_dob' ),
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
				'value'	=> set_field( $defendant , 'defendant_address' )
								
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
				'value'	=> set_field( $defendant , 'defendant_city' )
								
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
				'value'	=> set_field( $defendant , 'defendant_state' )
								
			);
			echo form_label('State', 'defendant_state'); 
			echo state_dropdown( 'defendant_state', '', 'defendant_state');
		?>
		</div>
		<div class="col50">
		<?
			$opts = array(
				'name' 	=> 'defendant_zip',
				'id'	=> 'defendant_zip',
				'value'	=> set_field( $defendant , 'defendant_zip' ),
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
				'value'	=> set_field( $defendant , 'defendant_phone' ),
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
				'value'	=> set_field( $defendant , 'indemnitor_fname' )
								
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
				'value'	=> set_field( $defendant , 'indemnitor_lname' )
								
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
				'value'	=> set_field( $defendant , 'indemnitor_email' )
								
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
				'value'	=> set_field( $defendant , 'indemnitor_ssn' ),
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
				'value'	=> set_field( $defendant , 'indemnitor_dl' )
								
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
				'value'	=> set_field( $defendant , 'indemnitor_dob' ),
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
				'value'	=> set_field( $defendant , 'indemnitor_address' )
								
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
				'value'	=> set_field( $defendant , 'indemnitor_city' )
								
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
				'value'	=> set_field( $defendant , 'indemnitor_state' )
								
			);
			echo form_label('State', 'indemnitor_state'); 
			echo state_dropdown( 'indemnitor_state', '', 'indemnitor_state');
		?>
		</div>
		<div class="col50">
		<?
			$opts = array(
				'name' 	=> 'indemnitor_zip',
				'id'	=> 'indemnitor_zip',
				'value'	=> set_field( $defendant , 'indemnitor_zip' ),
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
				'value'	=> set_field( $defendant , 'indemnitor_phone' ),
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
				'value'	=> set_field( $defendant , 'amount' )
								
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
				'value'	=> set_field( $defendant , 'desc' )
								
			);
			echo form_label('Description', 'collateral_description'); 
			echo form_textarea($opts);
		?>
		</div>

</fieldset>
<div class="t-right">
	<p>
		<input type="submit" value="Save Defendant Information" class="white" />
		<button type="button" class="white" onClick="location.href = ''">Cancel</button>
	</p>
</div>

<?= form_close(); ?>
</section>
