<fieldset>
	<legend>Billing Information</legend>	
	<div class="col50">
		<label>Name</label>
		<p class="row"><?= $first_name; ?> <?= $last_name; ?></p>
	</div>
	<div class="col50">
		<label>Address</label>
		<p class="row">
			<?= $address; ?><br />
			<?= $city; ?>, <?= $state; ?> <?= $zip; ?>
		</p>
	</div>
</fieldset>

<fieldset>
	<legend>Payment Amount</legend>
	<div class="col50">
		<label>Amount</label>
		<p class="row"><?= $amount; ?></p>
	</div>
</fieldset>		

<fieldset>
	<legend>Credit Card Information</legend>
	<div class="col50">
		<label>Card Number</label>
		<p class="row"><?= $creditcard; ?></p>
	</div>
	<div class="col50">
		<label>Expiration</label>
		<p class="row"><?= $exp_mth; ?>/<?= $exp_yr; ?></p>
	</div>
</fieldset>		
<?= form_open('/agent/pay_premium/process'); ?>

<input type="hidden" name="first_name" value="<?= $first_name ?>" />
<input type="hidden" name="last_name" value="<?= $last_name ?>" />
<input type="hidden" name="address" value="<?= $address ?>" />
<input type="hidden" name="city" value="<?= $city ?>" />
<input type="hidden" name="state" value="<?= $state ?>" />
<input type="hidden" name="zip" value="<?= $zip ?>" />
<input type="hidden" name="amount" value="<?= $amount ?>" />
<input type="hidden" name="creditcard" value="<?= $creditcard ?>" />
<input type="hidden" name="exp_mth" value="<?= $exp_mth ?>" />
<input type="hidden" name="exp_yr" value="<?= $exp_yr ?>" />
<input type="hidden" name="securitycode" value="<?= $securitycode ?>" />

<div class="t-right">
	<p>
		<input type="submit" class="white" value="Submit Payment" />
		<button type="button" onClick="location.href = '/agent/transmissions/';"class="white">Cancel</button>
	</p>
</div>
<?= form_close(); ?>
