<h3 class="tit">Below Are is the credit usage report for each of your sub agents</h3>
<p>This report is grouped by instant power types.
Report generated from the <strong><?= $start_date; ?></strong> to <strong><?= $end_date; ?></strong>.

</p>
<p class="box">
	<a href="/agent/reports/view_sub_agent_credit_usage" class="btn"><span>Back To "Search By Date" Form</span></a>

</p>
<? if( count( $credits ) ): ?>
<?= form_open( '/agent/reports/process_sub_agents_clear_credits' ); ?>
	<table class="tablesorter">
		<thead>
			<tr>
				<th>Sub Agent</th>
				<th>Credit Total</th>
				<th>Credit Cost</th>
				<th>Clear Credits</th>
			</tr>
		</thead>
		<tbody>
			<? foreach( $credits as $c ): ?>
			<tr>
				<td><?= $c['full_name']; ?></td>
				<td class="red"><?= $c['credit_count']; ?></td>
				<td>$<?= number_format( $c['cost'], 2, '.', ',' ); ?></td>
				<td ><input type="checkbox" name="clear[]" value="<?= $c['mek']; ?>" /></td>
			</tr>
			<? endforeach; ?>
		</tbody>			
	</table>
	<? if( count( $credits ) > 10 ) $this->load->view( 'includes/pager' ); ?>
<div class="clearfix"></div>
<div class="t-right">
<p>
	<input type="submit" class="white" value="Clear Sub Agent Credits" />
</p>
</div>
<?= form_close(); ?>
<? else: ?>
	<div class="msg info"><p>There are no results for this date span, please try again. </p></div>

<? endif; ?>
