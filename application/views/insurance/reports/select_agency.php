<?= form_open( $path ); ?>

<fieldset>
	<legend>Choose Agency</legend>
	<div class="col50">
	<?
		echo form_label('Agencies', 'agency'); 
		echo form_dropdown('agency', $agencies,  '', 'id="agency"');
	?>		
	</div>
</fieldset>	

<div class="clearfix"></div>
<div class="t-right">
	<p>
		<input type="submit" value="Select Agency" class="white" />
		<button type="button" class="white" onClick="location.href = '/insurance/reports'">Cancel</button>
	</p>
</div>


<?= form_close(); ?>