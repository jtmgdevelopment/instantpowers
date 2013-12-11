
<!-- Button -->
<div class="btn-box">
	<div class="btn-top"></div>
	<div class="btn">
		<dl>	    
			<dt><a href="<?= safe_url('/members/manage_account/view_profile', 'index'); ?>">View Account Profile</a></dt>
			<dd>View Your Account Profile.</dd>
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
			<dt><a href="<?= safe_url( '/members/manage_account', 'edit_profile' ); ?>">Edit Account Information</a></dt>
			<dd>Edit Your Account.</dd>
		</dl>
	</div>
	<!-- /btn -->
	<div class="btn-bottom"></div>
</div>
<!-- /btn-box -->

<? if( in_array( $this->session->userdata( 'role' ), array( 'master_agent', 'mga' ) ) ): ?>
<!-- Button -->
<div class="btn-box">
	<div class="btn-top"></div>
	<div class="btn">
		<dl>
			<dt><a href="<?= safe_url( '/members/manage_account', 'view_premiums' ); ?>">View Premiums Information</a></dt>
			<dd>View Your Premiums.</dd>
		</dl>
	</div>
	<!-- /btn -->
	<div class="btn-bottom"></div>
</div>
<!-- /btn-box -->
<? endif; ?>


<? if( in_array( $this->session->userdata( 'role' ), array( 'master_agent' ) ) ): ?>

<!-- Button -->
<div class="btn-box">
	<div class="btn-top"></div>
	<div class="btn">
		<dl>
			<dt><a href="<?= safe_url('/agent/manage_agents', 'index'); ?>">Manage Sub Agents</a></dt>
			<dd>Manage Your Sub Agents Here.</dd>
		</dl>
	</div>
	<!-- /btn -->
	<div class="btn-bottom"></div>
</div>
<!-- /btn-box -->

<? endif; ?>