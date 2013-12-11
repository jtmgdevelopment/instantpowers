<? include( 'header.php' ); ?>
<h3>The following Clerk Of Court would like to join <?= SITE_NAME; ?></h3>
<table cellpadding="5" cellspacing="0" border="0">
	<tr>
		<td align="right"><strong>Court Name:</strong></td>
		<td><?= $court_name; ?></td>
	</tr>	
	<tr>
		<td align="right"><strong>Court County:</strong></td>
		<td><?= $county; ?></td>
	</tr>	
	<tr>
		<td align="right"><strong>Clerk Administrator Name:</strong></td>
		<td><?= $clerk_name; ?></td>
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


