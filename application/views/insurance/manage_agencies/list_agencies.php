<section>
<table class="">
	<thead>
		<tr>
			<th>Agency Name</th>
			<th>Master Agent Name</th>
		</tr>
	</thead>
	<tbody>
		<? foreach( $agencies as $agency ): ?>
		<tr>
			<td><?= $agency[ 'agency_name' ]; ?></td>
			<td><?= $agency[ 'full_name' ]; ?></td>
		</tr>	
		<? endforeach; ?>
	</tbody>
</table>
</section>