<? if( count( $report ) ): ?>
<p class="box">
	<a href="<?= safe_url( '/master_agent/reports', 'submit_master_agent_report', array( $ins->insurance_agency_id ) ); ?>" class="btn-create"><span>Submit Report To <?= $ins->agency_name; ?></span></a>
	<a target="_blank" href="/_tasks/print_master_report.cfm?var1=<?= $ins->insurance_agency_id; ?>&var2=<?= $this->session->userdata( 'mek' ); ?>" class="btn-list"><span>Print Report</span></a>
</p>
<p><strong>Current Company Premium/BUF</strong></p>
<ul>
	<li>Company Premium: <?= $premium; ?>%</li>
	<li>BUF: <?= $buf; ?>%</li>
</ul>	
	
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
				<td><?= $r[ 'exec_date' ]; ?></td>
				<td>$<?= $r[ 'amount' ]; ?></td>
				<td>$<?= $r[ 'premium' ]; ?></td>
				<td>$<?= $r[ 'company' ]; ?></td>
				<td>$<?= $r[ 'buf' ]; ?></td>
			</tr>		
		<? endforeach; ?>	
	</tbody>
</table>	



<? else: ?>
<div class="msg info"><p>There are no powers to generate a report from</p></div>


<? endif; ?>