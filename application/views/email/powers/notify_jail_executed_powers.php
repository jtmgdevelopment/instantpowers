<? $this->load->view('email/header'); ?>
	<h3>A transmission has been created for Defendant <?= $defendant_name; ?></h3>
	<p><?= $bail_name; ?> from <?= $agency_name; ?> has created these power/s for the defendant <strong><?= $defendant_name; ?> </strong></p>
	<p>Please login to <?= SITE_NAME; ?> here, <a href="<?= base_url() . 'login'; ?>">Login To Instant Powers</a>.
		Once you are logged in, you can either accept this power/s or decline it. If you have any trouble at all please don't hesistate to 
		contact <a href="mailto:ddanzy@bailcommerce.com">Support</a>.
	</p>
	

<? $this->load->view('email/footer'); ?>


