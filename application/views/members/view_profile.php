<p class="box">
	<a class="btn-list" href="<?= safe_url( '/members/manage_account', 'edit_profile' ); ?>"><span>Edit Account</span></a>

</p>

<fieldset>
	<legend>Account Profile</legend>
		<div class="col50">
			<label>Full Name</label>
			<p class="row">
				<?= $member->full_name; ?>
			</p>
		</div>
		<div class="col50">
			<label>Email</label>
			<p class="row">
				<?= $member->email; ?>
			</p>
		</div>
		<div class="clearfix"></div>

		<div class="col50">
			<label>First Name</label>
			<p class="row">
				<?= $member->first_name; ?>
			</p>
		</div>
		<div class="col50">
			<label>Last Name</label>
			<p class="row">
				<?= $member->last_name; ?>
			</p>
		</div>
		<div class="clearfix"></div>
		<div class="col50">
			<label>Address</label>
			<p class="row">
				<?= $member->address; ?>
			</p>
		</div>
		<div class="col50">
			<label>City</label>
			<p class="row">
				<?= $member->city; ?>
			</p>
		</div>
		<div class="clearfix"></div>

		<div class="col50">
			<label>State</label>
			<p class="row">
				<?= $member->state; ?>
			</p>
		</div>
		<div class="col50">
			<label>Zip</label>
			<p class="row">
				<?= $member->zip; ?>
			</p>
		</div>
		<div class="clearfix"></div>

		<div class="col50">
			<label>Phone</label>
			<p class="row">
				<?= $member->phone; ?>
			</p>
		</div>
		<div class="clearfix"></div>
</fieldset>	


<fieldset>
	<legend>Login Information</legend>
	<div class="col50">
		<label>Username</label>
		<p class="row">
			<?= $member->username; ?>
		</p>	
		<p class="smaller low">Your email doubles as your username. If you change your email address, your username will be changed to this as well.</p>
	</div>
	<div class="col50">
		<label>Password</label>
		<p class="row">
			*******************************************		
		</p>
		<p class="smaller low">Your password is encrypted for ensured security. Passwords can only be reset and not retrieved.</p>
	</div>
	<div class="clearfix"></div>
		
</fieldset>

