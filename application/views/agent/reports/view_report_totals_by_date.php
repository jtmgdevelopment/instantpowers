<?= form_open( '/agent/reports/process_report_totals_by_date' ); ?>
<input type="hidden" name="mek" value="<?= $mek; ?>" />
<input type="hidden" name="ins_id" value="<?= $ins_id; ?>" />

<h3 class="tit">Choose the dates you would like to the report to query on</h3>
<fieldset>
	<legend>Search By Dates</legend>

	<div class="col50">
		<?
			$opts = array(
				'name' 	=> 'start_date',
				'id'	=> 'start_date',
				'value'	=> '1/01/' . date('Y'),
				'class'	=> 'datepicker'
								
			);
			echo form_label('Start Date', 'start_date'); 
			echo form_input($opts);
		?>
	</div>	
	<div class="col50">
		<?
			$opts = array(
				'name' 	=> 'end_date',
				'id'	=> 'end_date',
				'value'	=> '12/31/' . date( 'Y' ),
				'class'	=> 'datepicker'
								
			);
			echo form_label('End Date', 'end_date'); 
			echo form_input($opts);
		?>


	</div>	
	
	
</fieldset>	
<div class="t-right">
	<p>
		<input type="submit" value="Generate Report" class="white" />
		<button type="button" class="white" onClick="location.href = '/agent/reports/'">Cancel</button>
	</p>
</div>

<?= form_close(); ?>