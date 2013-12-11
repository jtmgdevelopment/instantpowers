<h3 class="tit">To void this power, please press the "Void Power Button"</h3>
<p>
You will be voiding this power for 
<strong><?= $power[ 'defendant_first_name' ]; ?> <?= $power[ 'defendant_last_name' ]; ?></strong>
on this date: <strong><?= date( 'm/i/Y g:i A' ); ?></strong>.
<?= form_open('/jail/transmissions/process_void/'); ?>
<input type="hidden" name="power_id" value="<?= $power[ 'power_id' ]; ?>" />
	<fieldset>
    	<legend>Would you like to give a reason</legend>
        <div class="col50">
			<?
				$opts = array(
					'name' 		=> 'reason',
					'id'		=> 'reason',
					'value'		=> ''
				);
				
				echo form_label('Your Reason', 'reason'); 
				echo form_textarea( $opts );			
			?>			        
        </div>
	</fieldset>
	<div class="t-right">
		<p>
			<input type="submit" value="Void Power" class="white" />
			<button class="white" onclick="window.location = '/jail/transmissions';">Cancel</button>
		</p>
	</div>
    
<?= form_close(); ?>


