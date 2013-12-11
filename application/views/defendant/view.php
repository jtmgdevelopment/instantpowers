<section>
<? if( ! count( $defendant ) ): ?>
<div class="msg info">
	<p>There currently is no defendant information</p>
</div>
<? else: ?>
<h3 class="tit"><?= $defendant[ 'defendant_name' ]; ?> information is below</h3>
<p class="box">
	<a class="btn" href="/defendant/manage/edit/<?= $power_id; ?>"><span>Edit This Information</span></a>
	<a class="btn" href="/agent/reports/power_history"><span>Back To Power History</span></a>
</p>
<fieldset>
	<legend>Defendant Information</legend>
		<div class="col50">
			<label>First Name</label>
			<p class="row"><?= $defendant[ 'defendant_fname'] ?></p>
		</div>
		<div class="col50">
			<label>Last Name</label>
			<p class="row"><?= $defendant[ 'defendant_lname'] ?></p>
		</div>
		<div class="clearfix"></div>

		<div class="col50">
			<label>Address</label>
			<p class="row"><?= $defendant[ 'defendant_address'] ?></p>
		</div>
		<div class="col50">
			<label>City</label>
			<p class="row"><?= $defendant[ 'defendant_city'] ?></p>
		</div>
		<div class="clearfix"></div>

		<div class="col50">
			<label>State</label>
			<p class="row"><?= $defendant[ 'defendant_state'] ?></p>
		</div>
		<div class="col50">
			<label>Zip</label>
			<p class="row"><?= $defendant[ 'defendant_zip'] ?></p>
		</div>
		<div class="clearfix"></div>

		<div class="col50">
			<label>First Name</label>
			<p class="row"><?= $defendant[ 'defendant_ssn'] ?></p>
		</div>
		<div class="col50">
			<label>Last Name</label>
			<p class="row"><?= $defendant[ 'defendant_phone'] ?></p>
		</div>
		<div class="clearfix"></div>
		<div class="col50">
			<label>DL</label>
			<p class="row"><?= $defendant[ 'defendant_dl'] ?></p>
		</div>
		<div class="col50">
			<label>Email</label>
			<p class="row"><?= $defendant[ 'defendant_email'] ?></p>
		</div>
		
		<div class="clearfix"></div>

</fieldset>

<fieldset>
	<legend>Indemnitor Information</legend>
		<div class="col50">
			<label>First Name</label>
			<p class="row"><?= $defendant[ 'indemnitor_fname'] ?></p>
		</div>
		<div class="col50">
			<label>Last Name</label>
			<p class="row"><?= $defendant[ 'indemnitor_lname'] ?></p>
		</div>
		<div class="clearfix"></div>

		<div class="col50">
			<label>Address</label>
			<p class="row"><?= $defendant[ 'indemnitor_address'] ?></p>
		</div>
		<div class="col50">
			<label>City</label>
			<p class="row"><?= $defendant[ 'indemnitor_city'] ?></p>
		</div>
		<div class="clearfix"></div>

		<div class="col50">
			<label>State</label>
			<p class="row"><?= $defendant[ 'indemnitor_state'] ?></p>
		</div>
		<div class="col50">
			<label>Zip</label>
			<p class="row"><?= $defendant[ 'indemnitor_zip'] ?></p>
		</div>
		<div class="clearfix"></div>

		<div class="col50">
			<label>First Name</label>
			<p class="row"><?= $defendant[ 'indemnitor_ssn'] ?></p>
		</div>
		<div class="col50">
			<label>Last Name</label>
			<p class="row"><?= $defendant[ 'indemnitor_phone'] ?></p>
		</div>
		<div class="clearfix"></div>
		<div class="col50">
			<label>DL</label>
			<p class="row"><?= $defendant[ 'indemnitor_dl'] ?></p>
		</div>
		<div class="col50">
			<label>Email</label>
			<p class="row"><?= $defendant[ 'indemnitor_email'] ?></p>
		</div>
		<div class="clearfix"></div>
</fieldset>




<fieldset>
	<legend>Collateral Information</legend>
		<div class="col50">
			<label>Collateral Type</label>
			<p class="row"><?= $defendant[ 'type'] ?></p>
		</div>
		<div class="col50">
			<label>Owner</label>
			<p class="row"><?= $defendant[ 'owner'] ?></p>
		</div>
		<div class="clearfix"></div>

		<div class="col50">
			<label>Amount</label>
			<p class="row"><?= $defendant[ 'amount'] ?></p>
		</div>
		<div class="col50">
			<label>Description</label>
			<p class="row"><?= $defendant[ 'desc'] ?></p>
		</div>
		<div class="clearfix"></div>



</fieldset>

<? endif; ?>


</section>