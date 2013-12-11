<? $this->load->view('email/header'); ?>

<h3>A new transmission from <?= SITE_NAME; ?> has been created</h3>
<p>To view and accept this transmission, please go to our login page found <a href="<?= base_url() . 'login'; ?>">here</a>.</p>

<? $this->load->view('email/footer'); ?>


