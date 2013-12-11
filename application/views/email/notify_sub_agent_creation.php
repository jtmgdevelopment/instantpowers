<? include( 'header.php' ); ?>
<h3><?= $bail_agency; ?> has made you a sub agent in the Instant Powers Management Application</h3>
<p>Below you will find your login information.</p>
<table cellpadding="5" cellspacing="0" border="0">
	<tr>
		<td align="right"><strong>Username:</strong></td>
		<td><?= $username; ?></td>
	</tr>	
	<tr>
		<td align="right"><strong>Password:</strong></td>
		<td><?= $password; ?></td>
	</tr>	
</table>
<p>To get started, please login here, <a href="<?= base_url() . 'login'; ?>">Login To Instant Powers</a>.</p>
<? include( 'footer.php' ); ?>


