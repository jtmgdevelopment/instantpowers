<!-- Button -->
<div class="btn-box">
	<div class="btn-top"></div>
	<div class="btn">
		<dl>
			<dt><a href="/agent/reports/power_history">Your Power History</a></dt>
			<dd>View Your power history here.</dd>
		</dl>
	</div>
	<!-- /btn -->
	<div class="btn-bottom"></div>
</div>

<!-- Button -->
<div class="btn-box">
	<div class="btn-top"></div>
	<div class="btn">
		<dl>
			<? if( $this->session->userdata( 'role' ) == 'master_agent'  ): ?>
				<dt><a href="/agent/reports/master_agent_report">Generate Master Agent Report</a></dt>
				<dd>Generate Master Agent Reports.</dd>
			<? else: ?>
				<dt><a href="/agent/reports/master_agent_report">Generate Sub Agent Report</a></dt>
				<dd>Generate Sub Agent Reports.</dd>
			<? endif; ?>	
		</dl>
	</div>
	<!-- /btn -->
	<div class="btn-bottom"></div>
</div>

<!-- /btn-box -->
<? if( $this->session->userdata( 'role' ) == 'master_agent'  ): ?>
<!-- Button -->
<div class="btn-box">
	<div class="btn-top"></div>
	<div class="btn">
		<dl>
			<dt><a href="/agent/reports/view_sub_agent_credit_usage">Sub Agent Credit Usage</a></dt>
			<dd>View Your Sub agent credit usage.</dd>
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
			<dt><a href="/agent/reports/sub_agent_power_history">Sub Agent Power History</a></dt>
			<dd>View your sub agent history here.</dd>
		</dl>
	</div>
	<!-- /btn -->
	<div class="btn-bottom"></div>
</div>
<!-- /btn-box -->

<div class="btn-box">
	<div class="btn-top"></div>
	<div class="btn">
		<dl>
			<dt><a href="/agent/reports/view_past_mar">Archived Master Agent Report</a></dt>
			<dd>View Past Master Agent Reports.</dd>
		</dl>
	</div>
	<!-- /btn -->
	<div class="btn-bottom"></div>
</div>

<div class="btn-box">
	<div class="btn-top"></div>
	<div class="btn">
		<dl>
			<dt><a href="/agent/reports/view_sub_agent_reports">View Sub Agent Reports</a></dt>
			<dd>View your sub agent reports here.</dd>
		</dl>
	</div>
	<!-- /btn -->
	<div class="btn-bottom"></div>
</div>


<!-- /btn-box -->
<? endif; ?>
