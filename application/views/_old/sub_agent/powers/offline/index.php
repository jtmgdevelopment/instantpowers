<h3 class="tit">Upload Your Offline Power</h3>
<?= form_open_multipart('/sub_agent/offline_powers/process_offline_frm'); ?>
<section>
<?php /*?><p>Before you execute a power, you must set your indentity for power execution security. The Jail you choose will verify this image before acting on the executed power.</p>
<?php */?><p>
	Once form is complete, a notification will be sent to the select prison. This will notify the prison that the power is available for download. Once the prison accepts the power, you will be notified by email. 
</p>

<fieldset>
	<legend>Offline Power</legend>
	<div class="col50">
			<?
				
				echo form_label('Jail Name', 'jail_name'); 
				echo form_dropdown('jail_name', $jails,  set_value( 'jail_name' ), 'id="jail_name"');
			?>
	
	</div>
	<div class="col50">
	<?
	
		$opts = array(
			'name' 	=> 'defendant_name',
			'id'	=> 'defendant_name',
			'value'	=> set_value( 'defendant_name' )
							
		);
		echo form_label('Defendant Full Name*', 'defendant_name'); 
		echo form_input($opts);
	?>
	</div>
	<div class="clearfix"></div>
	<div class="col50">
		<?
			$opts = array(
				'name' 	=> 'offline_power',
				'id'	=> 'offline_power',
				'value'	=> ''
								
			);
			echo form_label('Offline Power*', 'offline_power'); 
			echo form_upload($opts);
		?>
	</div>
	<div class="col50">
	<?
	
		$opts = array(
			'name' 	=> 'prefix',
			'id'	=> 'prefix',
			'value'	=> set_value( 'prefix' )
							
		);
		echo form_label('Power Prefix*', 'prefix'); 
		echo form_input($opts);
	?>
	</div>
	<div class="clearfix"></div>
	
	<div class="col50">
	<?
	
		$opts = array(
			'name' 	=> 'amount',
			'id'	=> 'amount',
			'value'	=> set_value( 'amount' )
							
		);
		echo form_label('Power Amount*', 'amount'); 
		echo form_input($opts);
	?>
	</div>

	<div class="col50">
	<?
	
		$opts = array(
			'name' 	=> 'pek',
			'id'	=> 'pek',
			'value'	=> set_value( 'pek' )
							
		);
		echo form_label('Power Number*', 'pek'); 
		echo form_input($opts);
	?>
	</div>
	
<?php /*?>	<div class="col50">
		<?
			$opts = array(
				'name' 	=> 'identity_image',
				'id'	=> 'identity_image',
				'value'	=> ''
								
			);
			echo form_label('Identity Photo*', 'identity_image'); 
			echo form_upload($opts);
		?>
	
	</div>
<?php */?></fieldset>

</section>
<div class="t-right">
	<p>
		<input type="submit" value="Upload Power" class="white" />
		<button type="button" class="white" onClick="location.href = '/master_agent/cpanel'">Cancel</button>
	</p>
</div>

<? form_close(); ?>