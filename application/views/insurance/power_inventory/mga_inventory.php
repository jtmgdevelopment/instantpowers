<h3 class="tit">Choose the MGA agency in which you would like to view their power inventory</h3>
<p class="box">
<a href="/insurance/power_inventory/" class="btn"><span>View Agent Inventory</span></a>
</p>
<?= form_open( '/insurance/power_inventory/process_mga' ); ?>


<fieldset>
	<legend>Choose Bail Agency</legend>
<div class="col50">

<?
	echo form_label('MGA', 'mga'); 
	echo form_dropdown('mga', $agencies,  '', 'id="mga"  ');
?>


</div>
</fieldset>

<div class="clearfix"></div>
<div class="t-right">
	<p>
		<input type="submit" value="Select Bail Agency" class="white" />
		<button type="button" class="white" onClick="location.href = '/insurance/cpanel'">Cancel</button>
	</p>
</div>

<?= form_close(); ?>