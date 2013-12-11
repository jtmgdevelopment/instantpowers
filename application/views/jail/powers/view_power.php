<h3 class="tit">Below is the detailed power information</h3>
<? if( $power->accepted ): ?>
<div class="t-right">
	<p class="box">
		<a class="btn-list" href="/jail/transmissions/"><span>Print Power</span></a>
	</p>
</div>


<? endif; ?>
<fieldset>
	<legend>Power Details</legend>
	<div class="col50">
		<label>Power Prefix</label>
		<p class="row"><?= $power->prefix; ?></p>
	</div>
	<div class="col50">
		<label>Power Amount</label>
		<p class="row"><?= $power->amount; ?></p>
	</div>
	<div class="clearfix"></div>
	<div class="col50">
		<label>Power Number</label>
		<p class="row"><?= $power->pek; ?></p>
	</div>
	<div class="col50">
		<label>Expiration Date</label>
		<p class="row"><?= $power->exp_date; ?></p>
	</div>		
	<div class="clearfix"></div>
	<div class="col50">
		<label>Bond Amount</label>
		<p class="row"><?= $power_detail->power->bond_amount; ?></p>
	</div>		
	<div class="clearfix"></div>

</fieldset>	
	
<fieldset>
	<legend>Defendant Details</legend>	
	<div class="col50">
		<label>Defendant Name</label>
		<p class="row"><?= $power_detail->defendant->first_name; ?> <?= $power_detail->defendant->last_name; ?></p>
	</div>
	<div class="col50">
		<label>Court Name</label>
		<p class="row"><?= $power_detail->power->court; ?></p>
	</div>
	<div class="clearfix"></div>

	<div class="col50">
		<label>Court Date</label>
		<p class="row"><?= $power_detail->power->court_date; ?></p>
	</div>
	<div class="col50">
		<label>Court Time</label>
		<p class="row"><?= $power_detail->power->court_time; ?></p>
	</div>
	<div class="clearfix"></div>

	<div class="col50">
		<label>Court County</label>
		<p class="row"><?= $power_detail->power->county; ?></p>
	</div>
	<div class="col50">
		<label>Court City/State</label>
		<p class="row"><?= $power_detail->power->city; ?>, <?= $power_detail->power->state; ?></p>
	</div>
	<div class="clearfix"></div>

	<div class="col50">
		<label>Charge</label>
		<p class="row"><?= $power_detail->power->charge; ?></p>
	</div>
	<div class="col50">
		<label>Case Number</label>
		<p class="row"><?= $power_detail->power->case_number; ?></p>
	</div>
	<div class="clearfix"></div>

	<div class="col50">
		<label>Executing Agent</label>
		<p class="row"><?= $power_detail->power->executing_agent; ?></p>
	</div>
	<div class="clearfix"></div>
</fieldset>	

<? if( ! $power->accepted ): ?>
<div class="t-right">
	<p class="box">
		<a class="btn-create" href="/jail/transmissions/accept_power/<?= $power->pek; ?>/<?= $power->prefix_id; ?>"><span>Accept Power Transmission</span></a>
		<a class="btn-delete" href="/jail/transmissions/void_power/<?= $power->pek; ?>/<?= $power->prefix_id; ?>"><span>Decline Power Transmission</span></a>
		<a class="btn-list" href="/jail/transmissions/"><span>Back To Listings</span></a>
	</p>
</div>
<? else: ?>
<div class="t-right">
	<p class="box">
		<a class="btn-list" href="/jail/transmissions/"><span>Print Power</span></a>
	</p>
</div>


<? endif; ?>