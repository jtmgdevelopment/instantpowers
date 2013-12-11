<h3>Add A Power Prefix</h3>
<?= form_open('/insurance/power_prefix/process_prefix_frm'); ?>
<section>
<fieldset>
	<legend>Prefix Information</legend>
		<div class="col50">
		<?
		
			$opts = array(
				'name' 	=> 'prefix',
				'id'	=> 'prefix',
				'value'	=> set_value( 'prefix', '' )
								
			);
			echo form_label('Power Prefix', 'prefix'); 
			echo form_input($opts);
		?>
		<p class="low small">Notice, prefix will be in thousands EX P50 is a "Power 5000"</p>
		</div>
		<div class="col50">
		<?
		
			$opts = array(
				'name' 	=> 'amount',
				'id'	=> 'amount',
				'value'	=> set_value( 'amount', '0.00' )
			);
			echo form_label('Power Amount', 'amount'); 
			echo form_input($opts);
		?>
		</div>
		<div class="clearfix"></div>

</fieldset>
<fieldset>
	<legend>Power Number Start</legend>
		<div class="col50">
		<?
		
			$opts = array(
				'name' 	=> 'prefix_start',
				'id'	=> 'prefix_start',
				'value'	=> set_value( 'prefix_start', '1 ' ),
                'maxlength'   => '6'
								
			);
			echo form_label('Power Prefix Start', 'prefix_start'); 
			echo form_input($opts);
		?>
		<p class="low small">Use this field to change which number the power will start on for this prefix.</p>
		</div>
		
</fieldset>	
<div class="t-right">
	<p>
		<input type="submit" class="white" value="Submit" />
		<button type="button" onClick="location.href = '/insurance/power_prefix';"class="white">Cancel</button>
	</p>
</div>

</section>