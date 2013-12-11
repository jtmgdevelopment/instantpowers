<? include( 'header.php' ); ?>
<h3>The following Jail would like to join <?= SITE_NAME; ?></h3>
<table cellpadding="5" cellspacing="0" border="0">
	<tr>
		<td align="right"><strong>Jail Name:</strong></td>
		<td><?= $jail_name; ?></td>
	</tr>	
	<tr>
		<td align="right"><strong>Jail Administrator:</strong></td>
		<td><?= $jail_admin; ?></td>
	</tr>	
	<tr>
		<td align="right"><strong>Email:</strong></td>
		<td><?= $email; ?></td>
	</tr>	
	<tr>
		<td align="right"><strong>Physical Address:</strong></td>
		<td><?= $physical_address; ?></td>
	</tr>	
	<tr>
		<td align="right"><strong>Mailing Address:</strong></td>
		<td><?= $mailing_address; ?></td>
	</tr>	
	<tr>
		<td align="right"><strong>Phone:</strong></td>
		<td><?= $phone; ?></td>
	</tr>	

</table>
<? include( 'footer.php' ); ?>


