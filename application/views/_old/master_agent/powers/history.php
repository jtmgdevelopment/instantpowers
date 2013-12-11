<h3 class="tit">Hstory Results</h3>
<table>
	<thead>
		<tr>
			<th>History Note</th>
			<th>Date Created</th>
		</tr>
	</thead>
	<tbody>
		<? foreach( $history as $h ): ?>
		<tr>
			<td><?= $h[ 'log' ]; ?></td>
			<td><?= $h[ 'date' ]; ?></td>
		</tr>							
		<? endforeach; ?>
	</tbody>
</table>		