<?= form_open('/admin/manage_mga/process_mga_admin_frm'); ?>
<input type="hidden" name="existing_username" value="<?= set_field( $mga_admin, 'email' ); ?>" />
<input type="hidden" name="existing_email" value="<?= set_field( $mga_admin, 'email' ); ?>" />
<input type="hidden" name="update" value="<? $update; ?>" />
<section>
<fieldset>
	<legend>MGA Administrator Information</legend>
		<div class="col50">
		<?
		
			$opts = array(
				'name' 	=> 'first_name',
				'id'	=> 'first_name',
				'value'	=> set_field( $mga_admin, 'first_name' )
								
			);
			echo form_label('First Name*', 'first_name'); 
			echo form_input($opts);
			echo form_hidden('mek', set_field( $mga_admin , 'mek' ));
		?>
		</div>
		<div class="col50">
		<?
		
			$opts = array(
				'name' 	=> 'last_name',
				'id'	=> 'last_name',
				'value'	=> set_field( $mga_admin, 'last_name' )
								
			);
			echo form_label('Last Name*', 'last_name'); 
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

</fieldset>
<fieldset>
	<legend>MGA Information</legend>	
		<div class="col50">
		<?
		
			$opts = array(
				'name' 	=> 'email',
				'id'	=> 'email',
				'value'	=> set_field( $mga_admin, 'email' )
								
			);
			echo form_label('MGA email*', 'email'); 
			echo form_input($opts);
			echo '<br /><span class="smaller low">All Powers will be sent to this address.<br /> <strong>This will also be the Jail Admin&rsquo;s USERNAME</strong></span>';
		?>
		</div>

		<div class="col50">
		<?
		
			$opts = array(
				'name' 	=> 'company_name',
				'id'	=> 'company_name',
				'value'	=> set_field( $mga_admin, 'company_name' )
								
			);
			echo form_label('Company Name*', 'company_name'); 
			echo form_input($opts);
			echo '<br /><span class="smaller low">This needs to be the exact name of the jail.<br />Agents will use this jain name for sending of powers</span>';
		?>
		</div>
		<div class="clearfix"></div>
		<div class="col50">
		<?
		
			$opts = array(
				'name' 	=> 'address',
				'id'	=> 'address',
				'value'	=> set_field( $mga_admin, 'address' )
								
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
				'value'	=> set_field( $mga_admin, 'city' )
								
			);
			echo form_label('city', 'city'); 
			echo form_input($opts);
		?>
		</div>
		<div class="clearfix"></div>
		<div class="col50">
		<?
			echo form_label('state', 'state'); 
			echo state_dropdown('state', set_value('state'), set_field( $mga_admin, 'state' ));		
			
		?>
		</div>
		<div class="col50">
		<?
		
			$opts = array(
				'name' 	=> 'zip',
				'id'	=> 'zip',
				'value'	=> set_field( $mga_admin, 'zip' )
								
			);
			echo form_label('zip', 'zip'); 
			echo form_input($opts);
		?>
		</div>
		<div class="clearfix"></div>
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

</fieldset>
<div class="t-right">
	<p>
		<button type="button" onClick="location.href = '/admin/manage_mga/';"class="white">Cancel</button>
		<input type="submit" class="white" value="Submit" />
	</p>
</div>

<?= form_close(); ?>
</section>
