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
				<td><a href="/mga/reports/view_agency_mar_report/<?= $r[ 'report_id' ]; ?>/<?= $agency_mek; ?>">View Report</a>
			</tr>

<? 
	
	$i++;
	endforeach; 
?>
		</tbody>			
	</table>
	<? if( count( $reports ) > 10 ) $this->load->view( 'includes/pager' ); ?>

<? endif; ?>
