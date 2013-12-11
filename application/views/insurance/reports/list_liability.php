<? if( count( $list ) ): ?> 

<?
$sum = 0; 
foreach( $total as $p )
{
	$sum += $p[ 'total_bond' ];
} 	
?>


<h3 class="tit">Total Liability ~ $<?= number_format($sum, 2, '.', ','); ?></h3>
	<table >
		<thead>
			<tr>
				<th>Total Bond Amount</th>
				<th>Power Type</th>
				<th>#of Powers</th>
			</tr>
		</thead>
		<tbody>
			<? foreach( $total as $p ): ?>
			<tr>
				<td>$<?= number_format( $p[ 'total_bond' ], 2, '.', ',' ); ?></td>
				<td><?= $p[ 'prefix' ]; ?></td>
				<td><?= $p[ 'power_count' ]; ?></td>
			</tr>
			<? endforeach; ?>
		</tbody>	
	</table>	
	
<h3 class="tit">Liability Per Power</h3>
	
	<table class="tablesorter">
		<thead>
			<tr>
				<th>Bond Amount</th>
				<th>Power</th>
				<th>Execution Date</th>
				<th>Case Number</th>
				<th>Power Status</th>
			</tr>
		</thead>
		<tbody>
			<? foreach( $list as $p ): ?>
				<tr>
					<td><?= $p['prefix']; ?><?= $p['pek']; ?> </td>
					<td>$<?= number_format($p['bond_amount'], 2, '.', ','); ?></td>
					<td><?= date( 'm/d/Y', strtotime( $p['execution_date'] ) ); ?></td>
					<td><?= $p['case_number']; ?></td>
					<td><?= $p['status']; ?></td>
				</tr>
			<? endforeach; ?>
		</tbody>
	</table>			
	<? if( count( $list	 ) > 10 ) $this->load->view('includes/pager'); ?>

<? else: ?>
<div class="msg info">
	<p>There are currently no powers for liability</p>
</div>

<? endif; ?>
