<?= form_open( '/insurance/activity/process_choose_agency_frm' ); ?>

<fieldset>
	<legend>Choose Agency</legend>
	<div class="col50">
	<?
		echo form_label('Bail Agencies', 'bail_agency'); 
		echo form_dropdown('bail_agency', $agencies,  '', 'id="bail_agency"');
	?>		
	</div>
</fieldset>	

<div class="clearfix"></div>
<div class="t-right">
	<p>
		<input type="submit" value="Select Bail Agency" class="white" />
		<button type="button" class="white" onClick="location.href = '/insurance/reports'">Cancel</button>
	</p>
</div>


<?= form_close(); ?>