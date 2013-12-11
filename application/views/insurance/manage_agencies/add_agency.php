<h3 class="tit">Enter The Master Agents License ID</h3>
<?= form_open('/insurance/manage_agencies/process_add_agency_frm'); ?>
<section>
<fieldset>
	<legend>Master Agent License Number</legend>
	<div class="col50">
		<?
			$opts = array(
				'name' 	=> 'license_number',
				'id'	=> 'license_number',
				'value'	=> ''
			);
			echo form_label('License Number*', 'license_number'); 
			echo form_input($opts);
		?>
	</div>
</fieldset>
</section>
<div class="t-right">
	<p>
		<input type="submit" value="Search Agency" class="white" />
		<button type="button" class="white" onClick="location.href = '/insurance/manage_agencies/'">Cancel</button>
	</p>
</div>
<? form_close(); ?>