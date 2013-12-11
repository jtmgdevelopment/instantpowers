<? $this->load->view('email/header'); ?>
<h2>Password Reset</h2>
<p>Your new password is: <strong><?= $password; ?></strong>. Click <a href="<?= base_url(); ?>">here</a> to login.</p>

<? $this->load->view('email/footer'); ?>
