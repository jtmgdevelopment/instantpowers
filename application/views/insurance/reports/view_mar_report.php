<p class="box">
<? if( ! isset( $archived ) ): ?>	
	<a class="btn-list" href="<?= safe_url( '/insurance/reports', 'view_past_mar_reports', array( $ins_id, $mek ) ); ?>"><span>View Past Reports for this <?= $agent->agency_name; ?></span></a>
<? endif; ?>
<? if( count( $report ) ): ?>
	<a target="_blank" href="/_tasks/print_master_report.cfm?var1=<?= $ins_id; ?>&var2=<?= $mek; ?>&var3=<?= $report_id; ?>" class="btn-list"><span>Print Report</span></a>
	<? if( $report_id > 0 ): ?>
		<a id="print-all-copies" class="btn-create" data-report_id="<?= $report_id; ?>" data-mek="<?= $agent->mek; ?>"><span>Download All Copies</span></a>
		<br />	
	
    <? endif; ?>
<? endif; ?>
</p>
<? if( count( $report ) ): ?>

<p><strong>Current Company Premium/BUF</strong></p>
<ul>
	<li>Company Premium: <?= $premium; ?>%</li>
	<li>BUF: <?= $buf; ?>%</li>
</ul>	
	
<h3 class="tit">Master Agent Report Totals for <?= $agent->agency_name; ?>:</h3>
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
	<the
	ad>
		<th>Power #</th>
		<th>Defendant</th>
		<th>County</th>
		<th>Date</th>
		<th>Bond Amount</th>
		<th>Premium</th>
		<th>Company</th>
		<th>BUF</th>
		<th>View/Print</th>
	</thead>
	<tbody>		
		<? foreach( $report as $r ): ?>
			<tr>
				<td><?= $r[ 'power' ]; ?></td>
				<td><?= $r[ 'defendant' ]; ?></td>
				<td><?= $r[ 'county' ]; ?></td>
				<? if( $r[ 'status' ] != 'executed' ): ?>
					<td><?= $r[ 'status' ]; ?></td>
				<? else: ?>
					<td><?= $r[ 'exec_date' ]; ?></td>				
				<? endif; ?>


				<? if( $r[ 'status' ] != 'executed' ): ?>

					<td>$<?= $r[ 'amount' ]; ?></td>
					<td>$0.00</td>
					<td>$0.00</td>
					<td>$0.00</td>
				<? else: ?>
					<td>$<?= $r[ 'amount' ]; ?></td>
					<td>$<?= $r[ 'premium' ]; ?></td>
					<td>$<?= $r[ 'company' ]; ?></td>
					<td>$<?= $r[ 'buf' ]; ?></td>
				
				<? endif; ?>
				<td><a target="_blank" href="/insurance/power_inventory/view_power/<?= $r[ 'power_id' ]; ?>/<?= $agent->bail_agency_id; ?>/hide">View</a> | 
				<a target="_blank" href="/insurance/reports/print_power/<?= $r[ 'power_id' ]; ?>/<?= $agent->mek; ?>/hide">Print</a></td>
			</tr>		
		<? endforeach; ?>	
	</tbody>
</table>	



<? else: ?>
<div class="msg info"><p>There are no powers to generate a report from</p></div>


<? endif; ?>