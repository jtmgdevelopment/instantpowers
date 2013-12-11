<section>
<table class="">
	<thead>
		<tr>
			<th>MGA Company Name</th>
			<th>MGA Name</th>
		</tr>
	</thead>
	<tbody>
		<? foreach( $agencies as $agency ): ?>
		<tr>
			<td><?= $agency[ 'company_name' ]; ?></td>
			<td><?= $agency[ 'full_name' ]; ?></td>
		</tr>	
		<? endforeach; ?>
	</tbody>
</table>
</section>