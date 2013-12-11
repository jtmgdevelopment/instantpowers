<h3 class="tit">Pleae add your premium/BUF Points</h3>
<?= form_open( '/members/manage_account/process_premium_pts_frm' ); ?>
<input type="hidden" name="ins" value="<?= $ins; ?>" />
<input type="hidden" name="premium_id" value="<?= $premium_id; ?>" />

<fieldset>
	<legend>Premium/BUF Points</legend>
		<p>Please enter numbers as percentage value. <strong>Example 10.5%</strong></p>
		<div class="col50">
		<?
			$opts = array(
				'name' 	=> 'premium',
				'id'	=> 'premium',
				'value'	=> set_field( $premium[0], 'premium' )
								
			);
			echo form_label('Premium Points', 'premium'); 
			echo form_input($opts) . '<span style="font-size:22px;">%</span>';
		?>
		</div>
		<div class="col50">
		<?
			$opts = array(
				'name' 	=> 'buf',
				'id'	=> 'buf',
				'value'	=> set_field( $premium[0], 'buf' )
								
			);
			echo form_label('BUF Points', 'buf'); 
			echo form_input($opts) . '<span style="font-size:22px;">%</span>';
		?>
		</div>
		<div class="clearfix"></div>
</fieldset>

<div class="clearfix"></div>
<div class="t-right">
	<p>
		<input type="submit" value="Set Premium/BUF" class="white" />
		<button type="button" class="white" onClick="location.href = '/members/manage_account'">Cancel</button>
	</p>
</div>

<?= form_close(); ?>