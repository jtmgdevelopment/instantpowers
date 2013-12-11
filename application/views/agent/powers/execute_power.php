<p>
	The cost to send this power electronically is: <strong>1 Credit</strong>. 
	Once form is complete, a notification will be sent to the select prison. This will notify the prison that the power is available for download. Once the prison accepts the power, you will be notified by email. 
</p>
<?= form_open('/agent/create_powers/process_execute_power_frm'); ?>
<input type="hidden" name="power_id" value="<?= $power_id;?>" />
<input type="hidden" name="trans_id" value="<?= $trans_id;?>" />
<fieldset>
	<legend>Defendant Information</legend>
	<div class="clearFix"></div>	
	<div class="col50">
		<label>Defendant Name</label>
		<p class="row"><?= $parsed_defendant[ 'first_name' ]; ?> <?= $parsed_defendant[ 'last_name' ]; ?></p>
	</div>
	<div class="col50">
		<label>Defendant Email</label>
		<p class="row"><? if( isset( $parsed_defendant[ 'data' ][ 'defendant_email' ] ) ): ?><?= $parsed_defendant[ 'data' ][ 'defendant_email' ]; ?><? else: ?> N/A<? endif; ?></p>
	</div>
	<div class="clearFix"></div>	
	<div class="col50">
		<p><a href="/agent/create_powers/view_power/<?= $trans_id; ?>/<?= $power_id ?>" class="btn-create" target="_blank"><span>View Powers</span></a></p>
	
	</div>
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
		<button type="button" class="white" onClick="location.href = '/agent/create_powers/summary/<?= $trans_id; ?>/<?= $power_id ?>'">Cancel</button>
	</p>
</div>
<?= form_close(); ?>

