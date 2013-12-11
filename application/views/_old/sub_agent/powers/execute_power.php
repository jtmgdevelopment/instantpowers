<p>
	Once form is complete, a notification will be sent to the select prison. This will notify the prison that the power is available for download. Once the prison accepts the power, you will be notified by email. 
</p>
<?= form_open('/sub_agent/powers/process_execute_power_frm'); ?>
<input type="hidden" name="pek" value="<?= $pek;?>" />
<input type="hidden" name="trans_id" value="<?= $trans_id;?>" />
<fieldset>
	<legend>Power/s Information</legend>
	<div class="col50">
		<label>Power/s</label>
		<p class="row"><?= $powers->prefix; ?>: <?= $batch; ?></p>
	</div>
	<div class="col50">
		<label>Bond Amounts</label>
		<p class="row">
			<? foreach( $sp as $val ): ?>
				<?= $val->power->bond_amount; ?> 
			<? endforeach; ?>
		
		</p>
	</div>
	<div class="clearFix"></div>	
	<div class="col50">
		<label>Defendant Name</label>
		<p class="row"><?= $sp[0]->defendant->first_name; ?> <?= $sp[0]->defendant->last_name; ?></p>
	</div>
	<div class="col50">
		<label>Defendant Email</label>
		<p class="row"><? if( isset( $sp[0]->defendant->email ) ): ?><?= $sp[0]->defendant->email; ?><? else: ?> N/A<? endif; ?></p>
	</div>
	<div class="clearFix"></div>	
</fieldset>	

<fieldset>
	<legend>Choose Jail</legend>
	<div class="col50">
			<?
				
				echo form_label('Jail Name', 'jail_name'); 
				echo form_dropdown('jail_name', $jails,  '', 'id="jail_name"');
			?>
	
	</div>
	<Div class="clearfix"></Div>
</fieldset>	

<div class="t-right">
	<p>
		<input type="submit" value="Execute Power/s" class="white" />
		<button type="button" class="white" onClick="location.href = '/sub_agent/powers/step_three/<?= $trans_id; ?>/<?= $pek ?>'">Cancel</button>
	</p>
</div>
<?= form_close(); ?>

