<? $this->load->view('email/header'); ?>

<h3>Your account at <?= SITE_NAME; ?> has been created</h3>
<p>Below you will find your login credentials.</p>

<table cellpadding="5" cellspacing="0" border="0">
	<tr>
		<td align="right"><strong>Username:</strong></td>
		<td><?= $email; ?></td>
	</tr>	
	<tr>
		<td align="right"><strong>Password:</strong></td>
		<td><?= $password; ?></td>
	</tr>	
</table>
<p>To login, please go to our login page found <a href="<?= base_url() . 'login'; ?>">here</a>.</p>

<? $this->load->view('email/footer'); ?>


