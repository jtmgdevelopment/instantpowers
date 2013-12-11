<h3 class="tit">Void This Power Below</h3>
 <?= form_open('/master_agent/powers/process_void_frm'); ?>
<input type="hidden" name="pek" value="<?= $powers->pek;?>" />
<input type="hidden" name="trans_id" value="<?= $transmission->trans_id;?>" />
<input type="hidden" name="prefix_id" value="<?= $powers->prefix_id; ?>" />

<section>
<p>By voiding the power, the status of the power will be changed to <strong>Void</strong>.</p>
<fieldset>
	<legend>Void Power</legend>
	<div class="col50">
		<?
			$opts = array(
				'name' 	=> 'void_date',
				'id'	=> 'void_date',
				'value'	=> date('m/d/Y'),
				'class'	=> 'datepicker'
								
			);
			echo form_label('Void Date*', 'void_date'); 
			echo form_input($opts);
		?>
	</div>
</fieldset>

</section>
<div class="t-right">
	<p>
		<input type="submit" value="Void Power" class="white" />
		<button type="button" class="white" onClick="location.href = '/master_agent/transmissions/view/<?= $transmission->trans_id; ?>'">Cancel</button>
	</p>
</div>

<? form_close(); ?>