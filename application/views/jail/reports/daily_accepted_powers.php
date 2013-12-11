<h3 class="tit">Generate Today's Report</h3>
<p class="box">
	<a class="btn" href="/jail/reports/generate_daily_accepted_report"><span>Generate Today's Report</span></a>
</p>

<? if( ! count( $reports ) ): ?>
	<div class="msg info">There are no generated reports on file</div>
<? else: ?>
<h3 class="tit">Below you can find your daily accepted reports</h3>
<table class="tablesorter">
	<thead>
		<tr>
			<th class="header">Report ID</th>
			<th>Report Created Date</th>
			<th>View Accepted Powers</th>
			<th>Zip File Link</th>
		</tr>
	</thead>
	<tbody>
	<? foreach( $reports as $p ): ?>
			<tr>
				<td><?= $p['batch_report_id' ]; ?></td>
				<td><?= $p['createddatetime' ]; ?></td>
				<td><a class="ico-show" href="/jail/reports/view_accepted_powers/<?= $p['batch_report_id' ]; ?>">View Accepted Powers</a></td>
				<td>
					<? if( strlen( $p['zip_path' ] ) ): ?>					
						<a href="/uploads/downloads/<?= $p['zip_path' ]; ?>" class="ico-show">Zip File Of All Accepted Powers</a> 
					<? else: ?>						
						Zip File Will Be Available Soon					
					<? endif; ?>
				</td>
			</tr>
		<? endforeach; ?>
	</tbody>
</table>
<? if( count( $reports ) > 10 ) $this->load->view('includes/pager'); ?>
<? endif; ?>