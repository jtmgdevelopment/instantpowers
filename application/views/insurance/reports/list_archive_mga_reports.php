
<? if( ! count( $archive ) ): ?>
<div class="msg info">
<p>There are currently no archived reports for this MGA agency for the <?= date( 'Y' ); ?> Year</p>

</div>
<? else: ?>
<table>
	<thead>
		<th>Report #</th>
		<th>MGA Agency</th>
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
			<td><?= $mga['company_name']; ?></td>
			<td><?= $a['date_created']; ?></td>
			<td>
				<a class="ico-show" href="<?= safe_url( '/insurance/reports', 'view_archived_mga', array( $a[ 'ins_id' ],  $mek, $a[ 'report_id' ], $a[ 'mga_id' ] ) ); ?>">View</a>
				<a class="ico-list" href="/_tasks/print_master_report.cfm?var1=<?= $a[ 'ins_id' ]; ?>&var2=<?= $mek; ?>&var3=<?= $a[ 'report_id' ]; ?>&var5=ins">Print</a>
			</td>			
		</tr>
	<? 
		$i++;
		endforeach; 
	?>
	</tbody>
</table>


<? endif; ?>