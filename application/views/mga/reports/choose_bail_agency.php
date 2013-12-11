<?= form_open( '/mga/reports/get_bail_agency_reports' ); ?>


<fieldset>
	<legend>Choose Bail Agencies</legend>
<div class="col50">

<?
	echo form_label('Bail Agencies', 'bail_agencies'); 
	echo form_dropdown('bail_agencies', $agencies,  '', 'id="bail_agencies"  ');
?>


</div>
</fieldset>

<div class="clearfix"></div>
<div class="t-right">
	<p>
		<input type="submit" value="Select Bail Agencies" class="white" />
		<button type="button" class="white" onClick="location.href = '/mga/reports'">Cancel</button>
	</p>
</div>

<?= form_close(); ?>