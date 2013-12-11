<?= form_open('/admin/manage_clerks/process_clerk_frm'); ?>
<section>
<fieldset>
	<legend>Clerk Of Courts Information</legend>
		<div class="col50">
		<?
		
			$opts = array(
				'name' 	=> 'first_name',
				'id'	=> 'first_name',
				'value'	=> set_field( $clerk, 'first_name' )
								
			);
			echo form_label('First Name*', 'first_name'); 
			echo form_input($opts);
			echo form_hidden('mek', set_field( $clerk , 'mek' ));
		?>
		</div>
		<div class="col50">
		<?
		
			$opts = array(
				'name' 	=> 'last_name',
				'id'	=> 'last_name',
				'value'	=> set_field( $clerk, 'last_name' )
								
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
				'value'	=> set_field( $clerk, 'email' )
								
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
				'value'	=> set_value( 'phone' )
								
			);
			echo form_label('phone', 'phone'); 
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
				'name' 	=> 'address',
				'id'	=> 'address',
				'value'	=> set_field( $clerk, 'address' )
								
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
				'value'	=> set_field( $clerk, 'city' )
								
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
				'value'	=> set_field( $clerk, 'state' )
								
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
				'value'	=> set_field( $clerk, 'zip' )
								
			);
			echo form_label('zip', 'zip'); 
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
