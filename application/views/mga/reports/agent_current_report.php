<? if( count( $report ) ): ?>
<p><strong>Current Company Premium/BUF</strong></p>
<ul>
	<li>Company Premium: <?= $premium; ?>%</li>
	<li>BUF: <?= $buf; ?>%</li>
</ul>	
	
<h3 class="tit">
	Power Breakdown
</h3>
<table>
	<thead>
		<th>Power Definition</th>
		<th>Amount Executed</th>
	</thead>
	<tbody>		
		<? foreach( $groups as $g ): ?>
		<tr>
			<td><?= $g[ 'prefix' ]; ?></td>
			<td><?= $g[ 'grouping' ]; ?></td>
		</tr>		
		<? endforeach; ?>
	</tbody>
</table>	


<h3 class="tit">Master Agent Report Power Details</h3>
<p class="low small">Powers are ordered by power type/amount</p>
<table>
	<thead>
		<th>Power #</th>
		<th>Defendant</th>
		<th>Date</th>
		<th>Bond Amount</th>
		<th>Premium</th>
		<th>Company</th>
		<th>BUF</th>
	</thead>
	<tbody>		
		<? foreach( $report as $r ): ?>
			<tr>
				<td><?= $r[ 'power' ]; ?></td>
				<td><?= $r[ 'defendant' ]; ?></td>
				<? if( $r[ 'status' ] != 'executed' ): ?>
					<td><?= $r[ 'status' ]; ?></td>
				<? else: ?>
					<td><?= $r[ 'exec_date' ]; ?></td>
				<? endif; ?>	
				<td>$<?= $r[ 'amount' ]; ?></td>
				<? if( $r[ 'status' ] != 'executed' ): ?>
					<td>$0.00</td>	
					<td>$0.00</td>	
					<td>$0.00</td>	
				
				<? else: ?>
					<td>$<?= $r[ 'premium' ]; ?></td>
					<td>$<?= $r[ 'company' ]; ?></td>
					<td>$<?= $r[ 'buf' ]; ?></td>
				<? endif; ?>
			</tr>		
		<? endforeach; ?>	
	</tbody>
</table>	

<h3 class="tit">Master Agent Report Totals:</h3>
<table>
	<thead>
		<th>Total Powers Executed</th>
		<th>Total Bond Amount</th>
		<th>Total Premium</th>
		<th>Total Company</th>
		<th>Total BUF</th>
	</thead>
	<tbody>		
		<tr>
			<td><?= $totals[ 'total_powers' ]; ?> executed powers</td>
			<td>$<?= $totals[ 'bond_amount' ]; ?></td>
			<td>$<?= $totals[ 'premium' ]; ?></td>
			<td>$<?= $totals[ 'company' ]; ?></td>
			<td>$<?= $totals[ 'buf' ]; ?></td>
		</tr>		
	</tbody>
</table>	


<? else: ?>
<div class="msg info"><p>There are no powers to generate a report from</p></div>


<? endif; ?>