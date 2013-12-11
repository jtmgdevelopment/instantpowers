<? if( count( $activity ) ): ?>
<h3 class="tit">Below you will find the power Activity for this agency</h3>
<table class="tablesorter">
	<thead>
		<tr>
			<th>Power</th>
			<th>Power Status</th>
		</tr>	
	</thead>
	<tbody>
		<? foreach( $activity as $a ): ?>
			<tr>
				<td><?= $a[ 'prefix' ]; ?><?= $a[ 'amount' ]; ?>-<?= $a[ 'pek' ]; ?></td>
				<td><?= $a[ 'status' ]; ?></td>			
			</tr>		
		<? endforeach; ?>
	</tbody>
</table>
<? if( count( $activity ) > 10 ) $this->load->view( 'includes/pager' ); ?>
<? else: ?>
	<div class="msg info"><p>This Agent does not have any powers</p></div>

<? endif; ?>
