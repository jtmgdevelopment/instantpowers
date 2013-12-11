<h3 class="tit">Void This Power Below</h3>
 <?= form_open('/agent/create_powers/process_void_frm'); ?>
<input type="hidden" name="power_id" value="<?= $power_id;?>" />
<input type="hidden" name="trans_id" value="<?= $trans_id;?>" />
<input type="hidden" name="void_date" value="<?= date( 'Y-m-d H:i:s');?>" />
<? if( isset( $power_details ) ): ?>
	<input type="hidden" name="redirect" value="redirect" />
<? endif; ?>

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
				'class'	=> 'datepicker',
				'disabled' => 'disabled'
								
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
		<button type="button" class="white" onClick="location.href = '/agent/transmissions/view/<?= $trans_id; ?>'">Cancel</button>
	</p>
</div>

<? form_close(); ?>