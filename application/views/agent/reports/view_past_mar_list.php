<? if( isset( $sub_agent_current ) ): ?>
<p class="box">
	<a href="/agent/reports/generate_master_report/<?= $ins_id; ?>/<?= $sub_mek; ?>" class="btn"><span>View Agent's Current Report</span></a>
	<a href="/agent/reports/view_report_totals_by_date/<?= $ins_id; ?>/<?= $sub_mek; ?>" class="btn"><span>View Agent's Total Premiums By Date Span</span></a>
</p>
<? endif; ?>


<? if( ! count( $reports ) ):?>
<div class="msg info"><p>There are currently no archived agent reports available at this time</p></div>

<? else: ?>
	<table class="tablesorter">
		<thead>
			<tr>
				<th>Report Number</th>
				<th>Report Date</th>
				<th>Payment Type</th>
				<th>Transaction ID</th>
				<th>Amount Paid</th>
				<th>View Report</th>
			</tr>
		</thead>
		<tbody>

<? 
	$i = 1;
	foreach( $reports as $r  ): 
?>
			<tr>
				<td><?= $i; ?></td>
				<td><?= $r[ 'date_created' ]; ?></td>
				<td><?= $r[ 'payment_type' ]; ?></td>
				<td><?= strlen( $r[ 'transaction_id' ] ) > 0 ? $r[ 'transaction_id' ] : 'N/A' ; ?></td>
				<td><?= ! is_null( $r[ 'amount' ] ) ? $r[ 'amount' ] : 'N/A' ; ?></td>
				<td><a href="/agent/reports/view_mar_report/<?= $r[ 'report_id' ]; ?>/<?= $r[ 'ins_id' ]; ?>/<?= $i; ?>/<?= $sub_mek; ?>">View Report</a>
			</tr>

<? 
	
	$i++;
	endforeach; 
?>
		</tbody>			
	</table>
	<? if( count( $reports ) > 10 ) $this->load->view( 'includes/pager' ); ?>

<? endif; ?>
