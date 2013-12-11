<?= form_open('/agent/manage_agents/process_ins_contracts_frm'); ?>

<section>
<fieldset>
	<legend>Choose Transmitting Company</legend>
	<input type="hidden" name="mek" value="<?= $mek; ?>" />
<div class="col50">
<?
	echo form_label('Transmitting Company', 'ins_agency'); 
	echo form_dropdown('ins_agency', $ins,  '', 'id="ins_agency"  ');
?>


</div>



</fieldset>

<div class="t-right">
	<p>
		<button type="button" onClick="location.href = '/agent/manage_agents';"class="white">Cancel</button>
		<input type="submit" class="white" value="Submit" />
	</p>
</div>

<?= form_close(); ?>

</section>