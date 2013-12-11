<? $this->load->view('email/header'); ?>
	<h3>Low Credit Alert!</h3>
	<p>
		You are currently at <?= $credit;?> credits. Please login to replenish your credits to avoid rejection of power execution.
		Login to <?= SITE_NAME; ?> to find out more details. Login <a href="<?= base_url(); ?>">here</a>.

	</p>
	
<? $this->load->view('email/footer'); ?>


