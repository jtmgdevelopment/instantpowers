<h3 class="tit">Upload Your Security Identity Photo</h3>
 <?= form_open_multipart('/master_agent/powers/process_indentity_frm'); ?>
<input type="hidden" name="pek" value="<?= $powers->pek;?>" />
<input type="hidden" name="trans_id" value="<?= $transmission->trans_id;?>" />
<section>
<p>Before you execute a power, you must set your indentity for power execution security. The Jail you choose will verify this image before acting on the executed power.</p>
<fieldset>
	<legend>Upload indentity Photo</legend>
	<div class="col50">
		<?
			$opts = array(
				'name' 	=> 'identity_image',
				'id'	=> 'identity_image',
				'value'	=> ''
								
			);
			echo form_label('Identity Photo*', 'identity_image'); 
			echo form_upload($opts);
		?>
	</div>
</fieldset>

</section>
<div class="t-right">
	<p>
		<input type="submit" value="Upload Identity Photo" class="white" />
		<button type="button" class="white" onClick="location.href = '/master_agent/powers/step_three/<?= $transmission->trans_id; ?>/<?= $powers->pek; ?>'">Cancel</button>
	</p>
</div>

<? form_close(); ?>