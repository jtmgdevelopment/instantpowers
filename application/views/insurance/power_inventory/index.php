<h3 class="tit">Choose the bail bonds agency/MGA in which you would like to view their power inventory</h3>
<?= form_open( '/insurance/power_inventory/process_bail_bonds_agency' ); ?>


<fieldset>
	<legend>Choose Bail Agency/MGA</legend>
<div class="col50">

<?
	echo form_label('Bail Agencies/MGA', 'bail_agency'); 
	echo form_dropdown('bail_agency', $agencies,  '', 'id="bail_agency"  ');
?>


</div>
</fieldset>

<div class="clearfix"></div>
<div class="t-right">
	<p>
		<input type="submit" value="Select Agency" class="white" />
		<button type="button" class="white" onClick="location.href = '/insurance/cpanel'">Cancel</button>
	</p>
</div>

<?= form_close(); ?>