<? include( 'header.php' ); ?>
<h3>The following Bail Agent has joined <?= SITE_NAME; ?></h3>
<table cellpadding="5" cellspacing="0" border="0">
	<tr>
		<td align="right"><strong>Agent Name:</strong></td>
		<td><?= $full_name; ?></td>
	</tr>	
	<tr>
		<td align="right"><strong>Bail Agency:</strong></td>
		<td><?= $agency_name; ?></td>
	</tr>	
	<tr>
		<td align="right"><strong>Email:</strong></td>
		<td><?= $email; ?></td>
	</tr>	
	<tr>
		<td align="right"><strong>Agent License Number:</strong></td>
		<td><?= $agent_license_number; ?></td>
	</tr>	
	<tr>
		<td align="right"><strong>Address:</strong></td>
		<td><?= $address; ?></td>
	</tr>	
	<tr>
		<td align="right"><strong>City:</strong></td>
		<td><?= $city; ?></td>
	</tr>	
	<tr>
		<td align="right"><strong>State:</strong></td>
		<td><?= $state; ?></td>
	</tr>	
	<tr>
		<td align="right"><strong>Zip:</strong></td>
		<td><?= $zip; ?></td>
	</tr>	
	<tr>
		<td align="right"><strong>Phone:</strong></td>
		<td><?= $phone; ?></td>
	</tr>	

</table>
<? include( 'footer.php' ); ?>


