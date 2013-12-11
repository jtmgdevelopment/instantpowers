<p class="box">
	<a href="<?= safe_url( '/mga/reports', 'transmit_mga_report', array( $ins_id ) ); ?>" class="btn-create">
			<span>Transmit to <?= $ins[ 'agency_name' ]; ?> Company</span>
	</a>
	<a href="/agent/reports" class="btn-delete"><span>Cancel Transmit</span></a>
	
</p>