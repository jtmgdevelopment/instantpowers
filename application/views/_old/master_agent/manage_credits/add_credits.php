<?= form_open('/master_agent/manage_credits/process_credits_frm'); ?>
<?= form_hidden( 'credit_amount', CREDIT_AMOUNT ); ?>
<section>
<fieldset>
	<legend>Credits Information</legend>
		<p><strong>Please add the number of credits you would like to purchase</strong>. There is a <strong>3% transaction fee</strong> that will be charged to your final total.</p>
		<div class="col50">
		<?
		
			$opts = array(
				'name' 	=> 'credits',
				'id'	=> 'credits',
				'value'	=> set_value( 'credits', 0 )
								
			);
			echo form_label('Credit Amount', 'credits'); 
			echo form_input($opts);
		?>
		</div>
	
		<div class="col50">
		<?
		
			$opts = array(
				'name' 	=> 'credit_cost',
				'id'	=> 'credit_cost',
				'value'	=> set_value( 'credit_cost', '$0.00' ),
				'disabled' => true,
				'style'	=> 'color:blue; background:white;font-weight:bold; border:none; border-top:1px solid; border-radius:0px;'
								
			);
			echo form_label('Credit Total Cost', 'credit_cost'); 
			echo form_input($opts);
		?>
		</div>
		<div class="clearfix"></div>
		<div class="col50">
		<?
		
			$opts = array(
				'name' 	=> 'transaction_fee',
				'id'	=> 'transaction_fee',
				'value'	=> set_value( 'transaction_fee', '$0.00' ),
				'disabled' => true,
				'style'	=> 'color:blue; background:white;font-weight:bold; border:none; border-top:1px solid; border-radius:0px;'
								
			);
			echo form_label('Transaction Fee 3%', 'transaction_fee'); 
			echo form_input($opts);
		?>
		</div>


		<div class="col50">
		<?
		
			$opts = array(
				'name' 	=> 'total',
				'id'	=> 'total',
				'value'	=> set_value( 'total', '$0.00' ),
				'disabled' => true,
				'style'	=> 'color:red; background:white;font-weight:bold; border:none; border-top:1px solid; border-radius:0px;'
								
			);
			echo form_label('Total Cost Of Transaction Charged To You', 'total'); 
			echo form_input($opts);
		?>
		</div>

		<div class="clearfix"></div>

</fieldset>


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
		<button type="button" onClick="location.href = '/admin/manage_insurance/';"class="white">Cancel</button>
	</p>
</div>

<?= form_close(); ?>
</section>
