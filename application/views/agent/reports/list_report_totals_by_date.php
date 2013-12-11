<h3 class="tit">Below you will find the totals from <?= $start_date; ?> to <?= $end_date; ?></h3>
	<table> 
		<thead>
			<tr>
				<th>Premium Total</th>
				<th>Agent Premium Take <em>(company)</em></th>
				<th>BUF</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td><?= $report_totals['premium_total']; ?></td>
				<td><?= $report_totals[ 'company' ]; ?></td>
				<td><?= $report_totals['buf']; ?></td>
			</tr>
		</tbody>			
	</table>

<p class="box">
	<button onclick="javascript: history.go( -1 );" class="btn"><span>Back</span></button>
</p>