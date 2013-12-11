<? $this->load->view('email/header'); ?>
<h2><?= $jail_name; ?> has VOIDED your offline power</h2>
<p>
	The following power for defendant <?= $defendant_name; ?> has been VOIDED.
</p>
<ul>
	<li>Power Number: <?= $prefix; ?> <?= $pek; ?></li>
	<li>Copy Of Power: <a href="<? base_url() . 'uploads/pdf/' . $power; ?>">Download Power</a></li>
</ul>


<? $this->load->view('email/footer'); ?>
