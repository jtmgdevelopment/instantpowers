<h3 class="tit">Enter The MGA Email Address</h3>
<?= form_open('/insurance/manage_mgas/process_add_agency_frm'); ?>
<section>
<fieldset>
	<legend>MGA Email Address</legend>
	<div class="col50">
		<?
			$opts = array(
				'name' 	=> 'email',
				'id'	=> 'email',
				'value'	=> ''
			);
			echo form_label('Email*', 'email'); 
			echo form_input($opts);
		?>
	</div>
</fieldset>
</section>
<div class="t-right">
	<p>
		<input type="submit" value="Search MGAs" class="white" />
		<button type="button" class="white" onClick="location.href = '/insurance/manage_mgas/'">Cancel</button>
	</p>
</div>
<? form_close(); ?>