<? $this->load->view('email/header'); ?>
	<h3><?= $jail_name; ?> has accepted a power for <?= $defendant_name; ?></h3>
	<p>
		The power <?= $prefix; ?> - <?= $amount; ?> #<?= $pek; ?> for <?= $defendant_name; ?> has been accepted by <?= $jail_name; ?>.
		Login to <?= SITE_NAME; ?> to find out more details. Login <a href="<?= base_url(); ?>">here</a>.
	</p>

<? $this->load->view('email/footer'); ?>


