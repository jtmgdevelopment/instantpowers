

<? if( ! count( $offline ) ): ?>
	<div class="msg info">There are no offline transmissions on file</div>
<? else: ?>
<h3 class="tit">Below you can find your pending offline transmissions</h3>

<table class="tablesorter">
	<thead>
		<tr>
			<th class="header">Bail Agency Name</th>
			<th>Bail Agent</th>
			<th>Defendant Name</th>
			<th>Security Photo</th>
			<th>Powers</th>
			<th>Actions</th>
		</tr>
	</thead>
	<tbody>
	<? foreach( $offline as $p ): ?>
			<tr>
				<td valign="top"><?= $p['agency_name' ]; ?></td>
				<td valign="top"><?= $p['full_name' ]; ?></td>
				<td valign="top"><?= $p['defendant_name']; ?></td>
				<td valign="top" align="center">
					<a class="fancybox ico-user-01" title="Agent: <?= $p['full_name' ]; ?>" href="/uploads/images/<?= end( explode( '\\', $p[ 'photo' ] ) ); ?>" >Security Image</a>
				</td>
				<td valign="top">
					<?
						$powers = explode( ',' , $p[ 'power' ] );
						foreach( $powers as $t => $i ): 					
					?>	
						<? $t++; ?>
						<a class="ico-list" href="/uploads/pdf/<?= end( explode( '\\', $i ) ); ?>">power <?= $t; ?></a><br />
					
					<? endforeach; ?>
				</td>
				<td valign="top">
					<a class="ico-done" href="<?= safe_url('/jail/transmissions', 'accept_offline_power', array( $p['offline_power_id'] ) ); ?>">Accept Power</a> | 
					<a class="ico-delete" href="<?= safe_url('/jail/transmissions', 'void_offline_power', array( $p['offline_power_id'] ) );  ?>">Void Power</a>
				</td>
			</tr>
		<? endforeach; ?>
	</tbody>
</table>
<? if( count( $offline ) > 10 ) $this->load->view('includes/pager'); ?>
<? endif; ?>
