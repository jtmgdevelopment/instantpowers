<!-- Button -->
<div class="btn-box">
	<div class="btn-top"></div>
	<div class="btn">
		<dl>
			<dt><a href="/admin/manage_bail" onclick="alert( 'Coming soon'); return false;">Add Bail Agents</a></dt>
			<dd>Add Bail Agents here.</dd>
		</dl>
	</div>
	<!-- /btn -->
	<div class="btn-bottom"></div>
</div>
<!-- /btn-box -->
<div class="clearfix"></div>
<h3>Below you will all the current bail agents/sub agents</h3>
<table>
	<thead>
		<tr>
			<th>Agent Name</th>
			<th>Bail Agency</th>			
			<th>License Number</th>
			<th>Is Sub Agent</th>
			<th>Date Joined</th>
			<th>Active</th>
			<th>Actions</th>
		</tr>
	</thead>
	<tbody>
		<? foreach( $agents as $agent ): ?>
		<tr>
			<td><?= $agent[ 'full_name' ]; ?></td>
			<td><?= $agent[ 'agency_name' ]; ?></td>
			<td><?= $agent[ 'license_number' ]; ?></td>
			<td><?= $agent[ 'is_sub_agent' ]; ?></td>
			<td><?= $agent[ 'date_created' ]; ?></td>			
			<td>
				<? if( $agent['active'] == 'Not Active' ): ?>
					<span class="label label-01"><?= $agent[ 'active' ]; ?></span>
				<? else: ?>
					<span class="label label-02"><?= $agent[ 'active' ]; ?></span>
				<? endif; ?>	
	
				
			</td>
			<td>
				<a class="ico-edit"  onclick="alert( 'Coming soon'); return false;" href="">Edit</a> | 
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