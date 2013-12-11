<h3 class="tit"><?= $agency->agency_name; ?></h3>
<ul>
<li><?= $agency->full_name; ?></li>
<li><?= $agency->agency_name; ?></li>
<li><?= $agency->license_number; ?></li>
</ul>


<?= form_open( '/mga/manage_agencies/add_agency_to_insurance/' ); ?>
<input type="hidden" name="agency" value="<?= $agency->mek ?>" />

<fieldset>
	<legend>Choose Insurance Company</legend>
<div class="col50">

<?
	echo form_label('Insurance Company', 'company'); 
	echo form_dropdown('company', $ins_drop,  '', 'id="company"  ');
?>


</div>
</fieldset>

<div class="clearfix"></div>
<div class="t-right">
	<p>
		<input type="submit" value="Add Agency" class="white" />
		<button type="button" class="white" onClick="location.href = '/mga/manage_agencies'">Cancel</button>
	</p>
</div>

<?= form_close(); ?>
