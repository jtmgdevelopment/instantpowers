<div class="clearfix"></div>
<? if( ! count( $offline ) ): ?>
	<div class="msg info">There are no transmissions on file</div>

<? else: ?>
	<h3 class="tit">Below you can find your OFFLINE transmissions</h3>
	<table class="tablesorter">
		<thead>
			<tr>
				<th class="header">Power</th>
				<th>Bond Amount</th>
				<th>Bail Agency Name</th>
				<th>Bail Agent</th>
				<th>Defendant Name</th>
				<th>Security Photo</th>
				<th>Powers</th>
				
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
		<? foreach( $offline as $o ): ?>
				<tr>
					<td><?= $o['prefix'] . ' ' . $o['pek']; ?></td>
					<td><?= $o['amount' ]; ?></td>
					<td><?= $o['agency_name' ]; ?></td>
					<td><?= $o['full_name' ]; ?></td>
					<td><?= $o['defendant_name']; ?></td>
					<td valign="top" align="center">
						<a class="fancybox ico-user-01" title="Agent: <?= $o['full_name' ]; ?>" href="/uploads/images/<?= end( explode( '\\', $o[ 'photo' ] ) ); ?>" >Security Image</a>
					</td>
					<td valign="top">
						<?
							$powers = explode( ',' , $o[ 'power' ] );
							foreach( $powers as $t => $i ): 					
						?>	
							<? $t++; ?>
							<a class="ico-list" href="/uploads/pdf/<?= end( explode( '\\', $i ) ); ?>">power <?= $t; ?></a><br />
						
						<? endforeach; ?>
					</td>
					
					<td>
					
						<a href="<?= safe_url( '/jail/transmissions', 'print_offline_power', array( $o['offline_power_id'] ) ); ?>" class="ico-list">Print Power</a>
					</td>
				</tr>
			<? endforeach; ?>
		</tbody>
	</table>
	<? if( count( $offline ) > 10 ) $this->load->view('includes/pager'); ?>

<? endif; ?>
