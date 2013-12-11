<!-- Button -->
<div class="btn-box">
	<div class="btn-top"></div>
	<div class="btn">
		<dl>
			<dt><a href="/admin/manage_jail/add_jail_admin">Add Jail Administrator</a></dt>
			<dd>Add Jail Admins here.</dd>
		</dl>
	</div>
	<!-- /btn -->
	<div class="btn-bottom"></div>
</div>
<!-- /btn-box -->
<div class="clearfix"></div>
<h3>Below you will find all the jail admins here</h3>
<? if( count( $jail_admins ) ): ?>
<table>
	<thead>
		<tr>
			<th>Jail Admin Name</th>
			<th>Jail Name</th>
			<th>Jail Email</th>
			<th>Date Joined</th>
			<th>Active</th>
			<th>Actions</th>
		</tr>
	</thead>
	<tbody>
		<?  foreach( $jail_admins as $admin ): ?>
		<tr>
			<td><?= $admin[ 'first_name' ] . ' ' . $admin[ 'last_name' ]; ?></td>
			<td><?= $admin[ 'jail_name' ]; ?></td>			
			<td><?= $admin[ 'email' ]; ?></td>			
			<td><?= $admin[ 'date_created' ]; ?></td>			
			<td>
				<? if( $admin['active'] == 'Not Active' ): ?>
					<span class="label label-01"><?= $admin[ 'active' ]; ?></span>
				<? else: ?>
					<span class="label label-02"><?= $admin[ 'active' ]; ?></span>
				<? endif; ?>	
	
				
			</td>
			<td>
				<a class="ico-edit" href="<?= safe_url( '/admin/manage_jail', 'edit_jail_admin', array( $admin['mek'] ) ); ?>">Edit</a> | 
				<? if( $admin['active'] == 'Not Active' ): ?>
					<a class="ico-done activate_user" data-id="<?= $admin['mek']; ?>" href="#">Activate</a>
				<? else: ?>
					<a class="ico-delete delete_user" data-id="<?= $admin['mek']; ?>" href="#">Deactivate</a>
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