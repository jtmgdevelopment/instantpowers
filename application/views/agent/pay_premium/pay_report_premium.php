<?= form_open('/agent/pay_premium/confirm_report_premium'); ?>
<?
	$data = array(
		'ins_id'  		=> $ins_id,
		'hidden_amount' => $amount,
		'is_mga'   		=> $is_mga
	);

echo form_hidden($data);
?>
<section>
<fieldset>
	<legend>Billing Information</legend>
		<div class="col50">
		<?
		
			$opts = array(
				'name' 	=> 'first_name',
				'id'	=> 'first_name',
				'value'	=> set_value( 'first_name' )
								
			);
			echo form_label('Card Holder First Name', 'first_name'); 
			echo form_input($opts);
		?>
		</div>
		<div class="col50">
		<?
			$opts = array(
				'name' 	=> 'last_name',
				'id'	=> 'last_name',
				'value'	=> set_value( 'last_name' )
								
			);
			echo form_label('Card Holder Last Name', 'last_name'); 
			echo form_input($opts);
		?>
		</div>
		<div class="clearfix"></div>
		<div class="col50">
		<?
		
			$opts = array(
				'name' 	=> 'address',
				'id'	=> 'address',
				'value'	=> set_value( 'address' )
								
			);
			echo form_label('address', 'address'); 
			echo form_input($opts);
		?>
		</div>
		<div class="col50">
		<?
		
			$opts = array(
				'name' 	=> 'city',
				'id'	=> 'city',
				'value'	=> set_value(  'city' )
								
			);
			echo form_label('city', 'city'); 
			echo form_input($opts);
		?>
		</div>
		<div class="clearfix"></div>
		<div class="col50">
		<?
		
			$opts = array(
				'name' 	=> 'state',
				'id'	=> 'state',
				'value'	=> set_value(  'state' )
								
			);
			echo form_label('state', 'state'); 
			echo form_input($opts);
		?>
		</div>
		<div class="col50">
		<?
		
			$opts = array(
				'name' 	=> 'zip',
				'id'	=> 'zip',
				'value'	=> set_value(  'zip' )
								
			);
			echo form_label('zip', 'zip'); 
			echo form_input($opts);
		?>
		</div>
		<div class="clearfix"></div>



</fieldset>
<fieldset>
	<legend>Payment Amount</legend>
		<div class="col50">
			<h3>Premium Owed: <strong>$<?= $amount; ?></strong></h3>
		</div>


</fieldset>
<fieldset>
	<legend>Credit Card Information</legend>
		<div class="col50">
		<?
		
			$opts = array(
				'name' 	=> 'creditcard',
				'id'	=> 'creditcard',
				'value'	=> set_value(  'creditcard', CREDITCARDNUMBER )
								
			);
			echo form_label('Credit Card Number', 'creditcard'); 
			echo form_input($opts);
		?>
		</div>
		<div class="col50">
		<?
		
			$opts = array(
				'name' 	=> 'securitycode',
				'id'	=> 'securitycode',
				'value'	=> set_value(  'securitycode' )
								
			);
			echo form_label('Security Code CVV', 'securitycode'); 
			echo form_input($opts);
		?>
		</div>
		<div class="clearfix"></div>

		<div class="col50">
		<?
		
			$opts = array(
				'name' 	=> 'exp_mth',
				'id'	=> 'exp_mth',
				'value'	=> set_value( 'exp_mth', date( 'm' ) )
								
			);
			echo form_label('Expiration Month', 'exp_mth'); 
			echo form_input($opts);
		?>
		</div>
		<div class="col50">
		<?
		
			$opts = array(
				'name' 	=> 'exp_yr',
				'id'	=> 'exp_yr',
				'value'	=> set_value( 'exp_yr', date( 'Y' ) )
								
			);
			echo form_label('Expiration Year', 'exp_yr'); 
			echo form_input($opts);
		?>
		</div>
		<div class="clearfix"></div>
	
	
	
</fieldset>	

<div class="t-right">
	<p>
		<input type="submit" class="white" value="Submit" />
		<button type="button" onClick="location.href = '/agent/transmissions/';"class="white">Cancel</button>
	</p>
</div>

<?= form_close(); ?>
</section>
