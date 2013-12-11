<h3 class="tit">Choose the bail bonds agency in which you would like to transfer this transmission to</h3>
<?= form_open( '/mga/transmissions/process_transfer' ); ?>
<input type="hidden" name="trans_id" value="<?= $trans_id; ?>" />


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