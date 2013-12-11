<p class="box">
	<a href="<?= safe_url( '/master_agent/reports', 'transmit_master_report', array( $ins->insurance_agency_id ) ); ?>" class="btn-create"><span>Transmit to <?= $ins->agency_name; ?> Company</span></a>
	<a href="/master_agent/reports" class="btn-delete"><span>Cancel Transmit</span></a>
	
</p>