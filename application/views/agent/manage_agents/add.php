<?= form_open('/agent/manage_agents/process_add'); ?>

<? //dd( $_POST ); ?>
<section>
<fieldset>
	<legend>Agent Information</legend>
		<div class="col50">
		<?
			$opts = array(
				'name' 	=> 'full_name',
				'id'	=> 'full_name',
				'value'	=> set_field( $agent, 'full_name' )
								
			);
			echo form_label('Full Name*', 'full_name'); 
			echo form_input($opts);
		?>
		</div>
		<div class="col50">
		<?
			$opts = array(
				'name' 	=> 'license_number',
				'id'	=> 'license_number',
				'value'	=> set_field( $agent, 'license_number' )
								
			);
			echo form_label('License Number*', 'license_number'); 
			echo form_input($opts);
		?>
		</div>
		<div class="clearfix"></div>

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
			$password = generate_password();
			
			$opts = array(
				'name' 	=> 'password',
				'id'	=> 'password',
				'value'	=> $password
								
			);
			echo form_label('password*', 'password'); 
			echo form_password($opts);
			echo '<br /><span class="smaller low clearfix">Password is automatically generated.</span>';
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
			echo '<br /><span class="smaller low">Password is automatically generated.</span>';
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
			echo form_label('email*', 'email'); 
			echo form_input($opts);
		?>
		</div>
		<div class="col50">
		<?
		
			$opts = array(
				'name' 	=> 'phone',
				'id'	=> 'phone',
				'class'	=> 'phone',
				'value'	=> set_field( $agent, 'phone' )
								
			);
			echo form_label('phone', 'phone'); 
			echo form_input($opts);
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
			echo form_label('state', 'state'); 
			echo state_dropdown('state', set_value('state'), set_field( $agent, 'state' ));		
			
		?>
		</div>
		<div class="col50">
		<?
		
			$opts = array(
				'name' 	=> 'zip',
				'id'	=> 'zip',
				'class'	=> 'zip',
				'value'	=> set_field( $agent, 'zip' )
								
			);
			echo form_label('zip', 'zip'); 
			echo form_input($opts);
		?>
		</div>
		<div class="clearfix"></div>
		<div class="col50">
		<?
		
			$opts = array(
				'name' 	=> 'company',
				'id'	=> 'company',
				'value'	=> set_field( $agent, 'company' )
								
			);
			echo form_label('company', 'company'); 
			echo form_input($opts);
		?>
		</div>
		<div class="clearfix"></div>

</fieldset>


<div class="t-right">
	<p>
		<button type="button" onClick="location.href = '/agent/cpanel';"class="white">Cancel</button>
		<input type="submit" class="white" value="Submit" />
	</p>
</div>

<?= form_close(); ?>
</section>
