
<?= form_open( '/mga/power_inventory/get_powers_to_recoup' ); ?>


<fieldset>
	<legend>Choose Bail Agency</legend>
<div class="col50">

<?
	echo form_label('Bail Agencies', 'bail_agency'); 
	echo form_dropdown('bail_agency', $agents,  '', 'id="bail_agency"  ');
?>


</div>
</fieldset>

<div class="clearfix"></div>
<div class="t-right">
	<p>
		<input type="submit" value="Select Bail Agency" class="white" />
		<button type="button" class="white" onClick="location.href = '/mga/cpanel'">Cancel</button>
	</p>
</div>

<?= form_close(); ?>