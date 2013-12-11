<?= form_open('/admin/credits/process_credits_frm'); ?>
<section>
<fieldset>
	<legend>Credits Information</legend>
		<div class="col50">
		<?
		
			$opts = array(
				'name' 	=> 'bail_agent',
				'id'	=> 'bail_agent',
				'value'	=> set_value( 'bail_agent', '' )
								
			);
			echo form_label('Bail Agent', 'bail_agent'); 
			echo form_dropdown('bail_agent', $agents,  '', 'id="bail_agent"  ');
		?>
		</div>
		<div class="col50">
		<?
		
			$opts = array(
				'name' 	=> 'amount',
				'id'	=> 'amount',
				'value'	=> set_value( 'amount', '0' )
			);
			echo form_label('Power Amount', 'amount'); 
			echo form_input($opts);
		?>
		</div>
		<div class="clearfix"></div>

</fieldset>

<div class="t-right">
	<p>
		<input type="submit" class="white" value="Submit" />
		<button type="button" onClick="location.href = '/admin/index';"class="white">Cancel</button>
	</p>
</div>

</section>