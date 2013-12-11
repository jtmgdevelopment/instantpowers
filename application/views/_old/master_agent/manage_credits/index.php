
<!-- Button -->
<div class="btn-box">
	<div class="btn-top"></div>
	<div class="btn">
		<dl>
			<dt><a href="/master_agent/manage_credits/add_credits">Purchase Credits</a></dt>
			<dd>Purchase Credits Here.</dd>
		</dl>
	</div>
	<!-- /btn -->
	<div class="btn-bottom"></div>
</div>
<!-- /btn-box -->
<div class="clearfix"></div>

<? if( ! count( $credits ) ): ?>
	<div class="msg warning">
		<p>You currently have no credits. You need to purchase credits before you can transmit powers</p>
	</div>
<? else: ?>

<h3>Current Available Credits: <?= $credits->credit_count; ?> </h3>
<hr />

	<? if( count( $transactions ) ): ?>
	<h3>Credit Transactions</h3>
	<table>
		<thead>
			<tr>
				<th>Amount Of Credits</th>
				<th>Cost</th>
				<th>Date Purchased</th>			
			</tr>
		</thead>
		<tbody>
			<?  foreach( $transactions as $t ): ?>
			<tr>
				<td><?= $t[ 'credits' ]; ?></td>
				<td><?= $t[ 'amount' ]; ?></td>
				<td><?= $t[ 'modified_date' ]; ?></td>
			</tr>		
			<? endforeach; ?>
		</tbody>	
	</table>	
	
	<? else: ?>
		<div class="msg info"><p>You currently have no recent transactions</p></div>
	<? endif; ?>

<? endif; ?>
