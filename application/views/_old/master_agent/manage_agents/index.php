<!-- Button -->
<div class="btn-box">
	<div class="btn-top"></div>
	<div class="btn">
		<dl>
			<dt><a href="/master_agent/manage_agents/add">Add Bail Agents</a></dt>
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
			<th>Agent Email</th>
			<th>Date Joined</th>
			<th>Active</th>
			<th>Actions</th>
		</tr>
	</thead>
	<tbody>
		<? foreach( $sub_agents as $agent ): ?>
		<tr>
			<td><?= $agent[ 'full_name' ]; ?></td>
			<td><?= $agent[ 'email' ]; ?></td>
			<td><?= $agent[ 'created' ]; ?></td>
			<td>
				<? if( $agent['active'] == 'Not Active' ): ?>
					<span class="label label-01"><?= $agent[ 'active' ]; ?></span>
				<? else: ?>
					<span class="label label-02"><?= $agent[ 'active' ]; ?></span>
				<? endif; ?>	
			</td>
			<td>
				<a class="ico-edit" href="/master_agent/manage_agents/edit/<?= $agent['mek']; ?>">Edit</a> | 
				<? if( $agent['active'] == 'Not Active' ): ?>
					<a class="ico-done activate_user"  href="/master_agent/manage_agents/activate/<?= $agent['mek']; ?>">Activate</a>
				<? else: ?>
					<a class="ico-delete delete_user"  href="/master_agent/manage_agents/deactivate/<?= $agent['mek']; ?>">Deactivate</a>
				<? endif; ?>	
			</td>
		</tr>		
		<? endforeach; ?>
	</tbody>	
</table>					