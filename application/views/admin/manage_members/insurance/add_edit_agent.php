<?= form_open('/admin/manage_insurance/process_agent_frm'); ?>
<input type="hidden" name="existing_username" value="<?= set_field( $agent, 'email' ); ?>" />
<input type="hidden" name="existing_email" value="<?= set_field( $agent, 'email' ); ?>" />
<input type="hidden" name="update" value="<? $update; ?>" />
<section>
<fieldset>
	<legend>Agent Information</legend>
		<div class="col50">
		<?
		
			$opts = array(
				'name' 	=> 'first_name',
				'id'	=> 'first_name',
				'value'	=> set_field( $agent, 'first_name' )
								
			);
			echo form_label('First Name*', 'first_name'); 
			echo form_input($opts);
			echo form_hidden('mek', set_field( $agent , 'mek' ));
		?>
		</div>
		<div class="col50">
		<?
		
			$opts = array(
				'name' 	=> 'last_name',
				'id'	=> 'last_name',
				'value'	=> set_field( $agent, 'last_name' )
								
			);
			echo form_label('Last Name*', 'last_name'); 
			echo form_input($opts);
		?>
		</div>
		<div class="clearfix"></div>
		<div class="col50">
		<?
		
			$opts = array(
				'name' 	=> 'email',
				'id'	=> 'email*',
				'value'	=> set_field( $agent, 'email' )
								
			);
			echo form_label('email', 'email'); 
			echo form_input($opts);
		?>
		</div>
		<div class="col50">
		<?
		
			$opts = array(
				'name' 	=> 'phone',
				'id'	=> 'phone',
				'value'	=> set_value( 'phone' ),
				'class'	=> 'phone'
								
			);
			echo form_label('phone', 'phone'); 
			echo form_input($opts);
		?>
		</div>


		<div class="clearfix"></div>
		<div class="col50">
		<?
			if( $no_pass ) $password = '';
			else $password = generate_password();
			
			$opts = array(
				'name' 	=> 'password',
				'id'	=> 'password',
				'value'	=> $password
								
			);
			echo form_label('password*', 'password'); 
			echo form_password($opts);
			if( ! $no_pass ) echo '<br /><span class="smaller low clearfix">Password is automatically generated.</span>';
			else echo '<br /><span class="smaller low clearfix">If you would like to change the password, please add it in. If not, then please leave this field blank.</span>';
		?>
		</div>
		<div class="col50">
		<?
		
			$opts = array(
				'name' 	=> 'confirm_password',
				'id'	=> 'confirm_password',
				'value'	=> $password
								
			);
			echo form_label('confirm password*', 'confirm_password'); 
			echo form_password($opts);
			if( ! $no_pass ) echo '<br /><span class="smaller low clearfix">Password is automatically generated.</span>';
			else echo '<br /><span class="smaller low clearfix">If you would like to change the password, please add it in. If not, then please leave this field blank.</span>';
		?>
		</div>
		<div class="clearfix"></div>


		<div class="col50">
		<?
		
			$opts = array(
				'name' 	=> 'address',
				'id'	=> 'address',
				'value'	=> set_field( $agent, 'address' )
								
			);
			echo form_label('address', 'address'); 
			echo form_input($opts);
		?>
		</div>
		<div class="col50">
		<?
		
			$opts = array(
				'name' 	=> 'city',
				'id'	=> 'city',
				'value'	=> set_field( $agent, 'city' )
								
			);
			echo form_label('city', 'city'); 
			echo form_input($opts);
		?>
		</div>
		<div class="clearfix"></div>
		<div class="col50">
		<?
		
			$opts = array(
				'name' 	=> 'state',
				'id'	=> 'state',
				'value'	=> set_field( $agent, 'state' )
								
			);
			echo form_label('state', 'state'); 
			echo form_input($opts);
		?>
		</div>
		<div class="col50">
		<?
		
			$opts = array(
				'name' 	=> 'zip',
				'id'	=> 'zip',
				'value'	=> set_field( $agent, 'zip' ),
				'class'	=> 'zip'
								
			);
			echo form_label('zip', 'zip'); 
			echo form_input($opts);
		?>
		</div>
		<div class="clearfix"></div>

</fieldset>

<fieldset>
	<legend>Company Information</legend>
		<div class="col50">
		<?
		
			$opts = array(
				'name' 	=> 'agency_name',
				'id'	=> 'agency_name',
				'value'	=> set_field( $agent, 'agency_name' )
								
			);
			echo form_label('Company Name*', 'agency_name'); 
			echo form_input($opts);
		?>
		</div>

		<div class="col50">
		<?
		
			$opts = array(
				'name' 	=> 'agency_email',
				'id'	=> 'email',
				'value'	=> set_field( $agent, 'agency_email' )
								
			);
			echo form_label('email', 'agency_email'); 
			echo form_input($opts);
		?>
		</div>
		<div class="clearfix"></div>
			<div class="col50">
		<?
		
			$opts = array(
				'name' 	=> 'agency_address',
				'id'	=> 'agency_address',
				'value'	=> set_field( $agent, 'agency_address' )
								
			);
			echo form_label('address', 'agency_address'); 
			echo form_input($opts);
		?>
		</div>
		<div class="col50">
		<?
		
			$opts = array(
				'name' 	=> 'agency_city',
				'id'	=> 'agency_city',
				'value'	=> set_field( $agent, 'agency_city' )
								
			);
			echo form_label('city', 'agency_city'); 
			echo form_input($opts);
		?>
		</div>
		<div class="clearfix"></div>
		<div class="col50">
		<?
		
			echo form_label('agency state', 'agency_state'); 
			echo state_dropdown('agency_state', set_value('agency_state'), set_field( $agent, 'agency_state' ));		
			
		?>
		</div>
		<div class="col50">
		<?
		
			$opts = array(
				'name' 	=> 'agency_zip',
				'id'	=> 'agency_zip',
				'value'	=> set_field( $agent, 'agency_zip' ),
				'class'	=> 'zip'
								
			);
			echo form_label('zip', 'agency_zip'); 
			echo form_input($opts);
		?>
		</div>
		<div class="clearfix"></div>
		<div class="col50">
		<?
		
			$opts = array(
				'name' 	=> 'agency_phone',
				'id'	=> 'agency_phone',
				'value'	=> set_field( $agent, 'agency_phone' ),
				'class'	=> 'phone'
								
			);
			echo form_label('phone', 'agency_phone'); 
			echo form_input($opts);
		?>
		</div>
		<div class="clearfix"></div>

</fieldset>

<div class="t-right">
	<p>
		<button type="button" onClick="location.href = '/admin/manage_insurance/';"class="white">Cancel</button>
		<input type="submit" class="white" value="Submit" />
	</p>
</div>

<?= form_close(); ?>
</section>
