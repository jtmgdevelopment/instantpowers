<? $this->load->view('email/header'); ?>
	<h3><?= $jail_name; ?> has declined a power for <?= $defendant_name; ?></h3>
	<p>
		The power <?= $prefix; ?> - <?= $amount; ?> #<?= $pek; ?> for <?= $defendant_name; ?> has been declined by <?= $jail_name; ?>.
		Login to <?= SITE_NAME; ?> to find out more details. Login <a href="<?= base_url(); ?>">here</a>.
	</p>
    <? if( strlen( $reason ) ): ?>
    	<h3>Reason</h3>
        <p><?= $reason; ?></p>
    <? endif; ?>

<? $this->load->view('email/footer'); ?>


