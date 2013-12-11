<?= form_open('/'); ?>
<section>
<fieldset>
	<legend>Defendant Information</legend>
		<div class="col50">
		<?
		
			$opts = array(
				'name' 	=> 'first_name',
				'id'	=> 'first_name',
				'value'	=> set_field( $agent, 'first_name' )
								
			);
			echo form_label('First Name', 'first_name'); 
			echo form_input($opts);
		?>
		</div>
		<div class="col50">
		<?
			$opts = array(
				'name' 	=> 'defendant_last_name',
				'id'	=> 'defendant_last_name',
				'value'	=> ( isset($power[0]['defendant_lname'] ) ? $power[0]['defendant_lname'] : set_value('defendant_last_name') )
								
			);
			echo form_label('First Name', 'defendant_first_name'); 
			echo form_input($opts);
		?>
		</div>
		<div class="clearfix"></div>

</fieldset>

<div class="t-right">
	<p>
		<input type="submit" class="white" value="Submit" />
		<button type="button" onClick="location.href = '/admin/manage_insurance/';"class="white">Cancel</button>
	</p>
</div>

<?= form_close(); ?>
</section>
