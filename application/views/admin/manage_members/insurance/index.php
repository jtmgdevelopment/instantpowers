<!-- Button -->
<div class="btn-box">
	<div class="btn-top"></div>
	<div class="btn">
		<dl>
			<dt><a href="/admin/manage_insurance/add_agent">Add Insurance Agents</a></dt>
			<dd>Add Insurance Agents here.</dd>
		</dl>
	</div>
	<!-- /btn -->
	<div class="btn-bottom"></div>
</div>
<!-- /btn-box -->
<div class="clearfix"></div>
<h3>Below you will find all the current bail agents/sub agents</h3>
<? if( count( $agents ) ): ?>
<table>
	<thead>
		<tr>
			<th>Agent Name</th>
			<th>Insurance Company</th>			
			<th>Date Joined</th>
			<th>Active</th>
			<th>Actions</th>
		</tr>
	</thead>
	<tbody>
		<?  foreach( $agents as $agent ): ?>
		<tr>
			<td><?= $agent[ 'first_name' ] . ' ' . $agent[ 'last_name' ]; ?></td>
			<td><?= $agent[ 'agency_name' ]; ?></td>
			<td><?= $agent[ 'date_created' ]; ?></td>			
			<td>
				<? if( $agent['active'] == 'Not Active' ): ?>
					<span class="label label-01"><?= $agent[ 'active' ]; ?></span>
				<? else: ?>
					<span class="label label-02"><?= $agent[ 'active' ]; ?></span>
				<? endif; ?>	
	
				
			</td>
			<td>
				<a class="ico-edit" href="<?= safe_url( '/admin/manage_insurance', 'edit_ins_admin', array( $agent[ 'mek' ] ) ); ?>">Edit</a> | 
				<? if( $agent['active'] == 'Not Active' ): ?>
					<a class="ico-done activate_user" data-id="<?= $agent['mek']; ?>" href="#">Activate</a>
				<? else: ?>
					<a class="ico-delete delete_user" data-id="<?= $agent['mek']; ?>" href="#">Deactivate</a>
				<? endif; ?>	
			</td>
		</tr>		
		<? endforeach; ?>
	</tbody>	
</table>	
<? else: ?>
<div class="msg warning">
There are currently no insurance agents</div>
</div>				
<? endif;?>