<p class="box">
	<a href="/insurance/reports/view_prior_years/<?= $ins_id; ?>/<?= $mek; ?>" class="btn"><span>See Reports From Prior Years</span></a>
</p>

<? if( ! count( $archive ) ): ?>
<div class="msg info">
<p>There are currently no archived reports for this bail agency for the <?= date( 'Y' ); ?> Year</p>

</div>
<? else: ?>
<table class="tablesorter">
	<thead>
		<th>Report #</th>
		<th>Bail Agency</th>
		<th>Date Submitted</th>
		<th>Actions</th>
	</thead>
	<tbody>	
	<? 
		$i = 1;
		foreach( $archive as $a ): 
	?>
		<tr>
			<td><?= $i; ?></td>
			<td><?= $a['agency_name']; ?></td>
			<td><?= $a['date_created']; ?></td>
			<td>
				<a class="ico-show" href="<?= safe_url( '/insurance/reports', 'view_archived_mar', array( $a[ 'ins_id' ], $a[ 'mek' ], $a[ 'report_id' ], $a[ 'bail_agency_id' ] ) ); ?>">View</a>
				<a class="ico-list" href="/_tasks/print_master_report.cfm?var1=<?= $ins_id; ?>&var2=<?= $a[ 'mek' ]; ?>&var3=<?= $a[ 'report_id' ]; ?>&var5=ins">Print</a>
			</td>			
		</tr>
	<? 
		$i++;
		endforeach; 
	?>
	</tbody>
</table>
<? if( count( $archive ) > 10 ) $this->load->view( 'includes/pager' ); ?>


<? endif; ?>