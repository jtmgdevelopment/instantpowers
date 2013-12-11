<?= form_open( '/insurance/reports/process_mga_choose_agency_frm' ); ?>

<fieldset>
	<legend>Choose MGA</legend>
	<div class="col50">
	<?
		echo form_label('MGAs', 'mga_agency'); 
		echo form_dropdown('mga_agency', $mga,  '', 'id="mga_agency"');
	?>		
	</div>
</fieldset>	

<div class="clearfix"></div>
<div class="t-right">
	<p>
		<input type="submit" value="Select MGA Agency" class="white" />
		<button type="button" class="white" onClick="location.href = '/insurance/reports'">Cancel</button>
	</p>
</div>


<?= form_close(); ?>