	<? if( $this->session->userdata( 'danzymember' ) && ! is_null( $amount ) ): ?>
		<fieldset>
			<legend>Online Premium Payment</legend>
			<p>By using this service you are agreeing to pay the following premium as an <strong><u>ONLINE</u></strong> transaction</p>
			<p><strong>$<?= $amount; ?></strong></p>

			<a href="<?= safe_url( '/agent/pay_premium', 'pay_report_premium', array( $ins_id, $ins[ 'is_mga' ], $amount ) ); ?>" class="btn-create">
				<? if( $sub_agent ): ?>
					<span>Pay Premium/Transmit to Master Agent </span>
				<? else: ?>
					<span>Pay Premium/Transmit to <?= $ins[ 'agency_name' ]; ?> Company</span>
				<? endif; ?>
			</a>
		</fieldset>
		<fieldset>
			<legend>Offline Premium Payment</legend>
			<p>By using this service you are agreeing to pay the following premium as an <strong><u>OFFLINE</u></strong> transaction</p>
			<p><strong>$<?= $amount; ?></strong></p>


			<a href="<?= safe_url( '/agent/reports', 'transmit_master_report', array( $ins_id, $ins[ 'is_mga' ] ) ); ?>" class="btn-create">
				<? if( $sub_agent ): ?>
					<span>Transmit to Master Agent As Offline Payment</span>
				<? else: ?>
					<span>Transmit to <?= $ins[ 'agency_name' ]; ?> Company  As Offline Payment</span>
				<? endif; ?>
			</a>
		</fieldset>
		
		<div class="clearfix"></div>
		<div class="t-right">
		<p>
			<a href="/agent/reports" class="btn-delete"><span>Cancel Transmit</span></a>
		</p>
		</div>
		

	<? else: ?>
		<p class="box">
			<a href="<?= safe_url( '/agent/reports', 'transmit_master_report', array( $ins_id, $ins[ 'is_mga' ] ) ); ?>" class="btn-create">
				<? if( $sub_agent ): ?>
					<span>Transmit to Master Agent</span>
				<? else: ?>
					<span>Transmit to <?= $ins[ 'agency_name' ]; ?> Company</span>
				<? endif; ?>
			</a>
			<a href="/agent/reports" class="btn-delete"><span>Cancel Transmit</span></a>
		</p>
	<? endif; ?>	
