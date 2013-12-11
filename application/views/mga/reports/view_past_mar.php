<? if( ! count( $reports ) ):?>
<div class="msg info"><p>There are currently no archived agent reports available at this time</p></div>

<? else: ?>
	<table class="tablesorter">
		<thead>
			<tr>
				<th>Report Number</th>
				<th>Report Date</th>
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
				<td><a href="/mga/reports/view_mar_report/<?= $r[ 'report_id' ]; ?>/<?= $r[ 'ins_id' ]; ?>/<?= $i; ?>">View Report</a>
			</tr>

<? 
	
	$i++;
	endforeach; 
?>
		</tbody>			
	</table>
	<? if( count( $reports ) > 10 ) $this->load->view( 'includes/pager' ); ?>

<? endif; ?>
