<!-- Button -->
<div class="btn-box">
	<div class="btn-top"></div>
	<div class="btn">
		<dl>	    
			<dt><a href="<?= safe_url('/master_agent/transmissions', 'index'); ?>">View Transmissions</a></dt>
			<dd>View All Of Your Transmissions Here.</dd>
		</dl>
	</div>
	<!-- /btn -->
	<div class="btn-bottom"></div>
</div>
<!-- /btn-box -->

<!-- Button -->
<div class="btn-box">
	<div class="btn-top"></div>
	<div class="btn">
		<dl>
			<dt><a href="/photo/take_photo.html?role=<?=$this->session->userdata( 'role' ); ?>">Offline Powers</a></dt>
			<dd>Submit Offline Powers To Jail.</dd>
		</dl>
	</div>
	<!-- /btn -->
	<div class="btn-bottom"></div>
</div>
<!-- /btn-box -->
<!-- Button -->
<div class="btn-box">
	<div class="btn-top"></div>
	<div class="btn">
		<dl>
			<dt><a href="<?= safe_url('/master_agent/power_inventory', 'index'); ?>">Powers Inventory</a></dt>
			<dd>View Your Power Inventory.</dd>
		</dl>
	</div>
	<!-- /btn -->
	<div class="btn-bottom"></div>
</div>
<!-- /btn-box -->
<!-- Button -->
<div class="btn-box">
	<div class="btn-top"></div>
	<div class="btn">
		<dl>
			<dt><a href="<?= safe_url('/master_agent/reports', 'index'); ?>">Reports</a></dt>
			<dd>View Instant Powers Reports Here.</dd>
		</dl>
	</div>
	<!-- /btn -->
	<div class="btn-bottom"></div>
</div>
<!-- /btn-box -->


<!-- Button -->
<div class="btn-box">
	<div class="btn-top"></div>
	<div class="btn">
		<dl>
			<dt><a href="<?= safe_url('/master_agent/manage_credits', 'index'); ?>">Manage Credit Wallet</a></dt>
			<dd>Manage, View Or Purchase Credits Here.</dd>
		</dl>
	</div>
	<!-- /btn -->
	<div class="btn-bottom"></div>
</div>
<!-- /btn-box -->


<!-- Button -->
<div class="btn-box">
	<div class="btn-top"></div>
	<div class="btn">
		<dl>
			<dt><a href="<?= safe_url('/master_agent/manage_agents', 'index'); ?>">Manage Sub Agents</a></dt>
			<dd>Manage Your Sub Agents Here.</dd>
		</dl>
	</div>
	<!-- /btn -->
	<div class="btn-bottom"></div>
</div>
<!-- /btn-box -->

