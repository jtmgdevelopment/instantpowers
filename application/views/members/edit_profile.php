<?= form_open( '/members/manage_account/process_update_frm'); ?>
<input type="hidden" name="current_email" value="<?= $member->email; ?>" />
<input type="hidden" name="current_username" value="<?= $member->username; ?>" />
<fieldset>
	<legend>Profile Information</legend>
	<div class="col50">
		<?
			$opts = array(
				'name' 	=> 'first_name',
				'id'	=> 'first_name',
				'value'	=> set_field( $member, 'first_name')							
			);
			
			echo form_label('First Name*', 'first_name'); 
			echo form_input($opts);
		?>

	</div>
	<div class="col50">
		<?
			$opts = array(
				'name' 	=> 'last_name',
				'id'	=> 'last_name',
				'value'	=> set_field( $member, 'last_name')							
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
				'id'	=> 'email',
				'value'	=> set_field( $member, 'email')							
			);
			
			echo form_label('Email*', 'email'); 
			echo form_input($opts);
		?>
		<p class="smaller low">
			Email doubles for your username. This email address has be to unique to our system. All
			email notifications will be sent to this account.
		</p>	
			
	</div>
	<div class="col50">
		<?
			$opts = array(
				'name' 	=> 'address',
				'id'	=> 'address',
				'value'	=> set_field( $member, 'address')							
			);
			
			echo form_label('Address', 'address'); 
			echo form_input($opts);
		?>

	</div>

	<div class="clearfix"></div>	

	<div class="col50">
		<?
			$opts = array(
				'name' 	=> 'city',
				'id'	=> 'city',
				'value'	=> set_field( $member, 'city')							
			);
			
			echo form_label('City', 'city'); 
			echo form_input($opts);
		?>

	</div>
	<div class="col50">
		<?
			echo form_label('state', 'state'); 
			echo state_dropdown('state', set_value('state'), set_field( $member, 'state' ));		
			
		?>

	</div>

	<div class="clearfix"></div>	

	<div class="col50">
		<?
			$opts = array(
				'name' 	=> 'zip',
				'id'	=> 'zip',
				'value'	=> set_field( $member, 'zip'),
				'class'	=> 'zip'													
			);
			
			echo form_label('zip', 'zip'); 
			echo form_input($opts);
		?>

	</div>
	<div class="col50">
		<?
			$opts = array(
				'name' 	=> 'phone',
				'id'	=> 'phone',
				'value'	=> set_field( $member, 'phone'),
				'class'	=> 'phone'							
				
			);
			
			echo form_label('phone', 'phone'); 
			echo form_input($opts);
		?>

	</div>
	<div class="clearfix"></div>
		<div class="clearfix"></div>
		<div class="col50">
		<?
		
			$opts = array(
				'name' 	=> 'company',
				'id'	=> 'company',
				'value'	=> set_field( $member, 'company' )
								
			);
			echo form_label('company', 'company'); 
			echo form_input($opts);
		?>
		</div>
		<div class="clearfix"></div>
		
</fieldset>

<fieldset>
	<legend>Security Information</legend>
	<div class="col50">
		<?
			$opts = array(
				'name' 	=> 'username',
				'id'	=> 'username',
				'value'	=> set_field( $member, 'username')						
			);
			
			echo form_label('username*', 'username'); 
			echo form_input($opts);
		?>

	</div>

	<div class="clearfix"></div>	
	<div class="col50">
		<?
			$opts = array(
				'name' 	=> 'password',
				'id'	=> 'password',
				'value'	=> set_value( 'password' )
			);
			
			echo form_label('password', 'password'); 
			echo form_password($opts);
		?>

	</div>
	<div class="col50">
		<?
			$opts = array(
				'name' 	=> 'confirm_password',
				'id'	=> 'confirm_password',
				'value'	=> ''
			);
			
			echo form_label('confirm Password', 'confirm_password'); 
			echo form_password($opts);
		?>

	</div>
</fieldset>
<div class="t-right">
	<p>
		<button type="button" onClick="location.href = '/members/manage_account';"class="white">Cancel</button>
		<input type="submit" class="white" value="Update Account" />
	</p>
</div>

<?= form_close(); ?>