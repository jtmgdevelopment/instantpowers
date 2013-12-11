<!-- Tray -->
<div id="tray" class="box">
	<p class="f-left box">
	</p>
	<p class="f-right">
		User: <strong>
			<span class="caps"><?= $this->session->userdata('username') ?></span>
			<a href="/members/manage_account" class="ico-user-03">EDIT ACCOUNT</a>
				
		</strong>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<strong>
		<a href="/logout" id="logout">
			Log out
		</a>
		</strong>
	</p>
</div>
<!--  /tray -->
<hr class="noscreen" />
<!-- Menu -->
<div id="menu" class="box">
	<ul class="box f-right">
		<li>
			<img src="/assets/images/logo.png" height="35" />
		</li>
	</ul>
	<ul class="box">
		<li onmouseover="this.className = 'dropdown-on'" onmouseout="this.className = 'dropdown-off'">
			<div>
				<a href="/agent/cpanel">
					<span>Control Panel</span>
				</a>
			</div>
		</li>
		<li onmouseover="this.className = 'dropdown-on'" onmouseout="this.className = 'dropdown-off'">
			<div>
				<a href="/agent/power_inventory">
					<span>Power Inventory</span>
				</a>
			</div>
		</li>
		<li onmouseover="this.className = 'dropdown-on'" onmouseout="this.className = 'dropdown-off'">
			<div>
				<a href="/photo/take_photo.html?role=<?=$this->session->userdata( 'role' ); ?>">
					<span>Offline Power</span>
				</a>
			</div>
		</li>

		<li onmouseover="this.className = 'dropdown-on'" onmouseout="this.className = 'dropdown-off'">
			<div>
				<a href="/agent/reports">
					<span>Reports</span>
				</a>
			</div>
		</li>
		<? if( $this->session->userdata( 'danzymember' ) ): ?>
			<li onmouseover="this.className = 'dropdown-on'" onmouseout="this.className = 'dropdown-off'">
				<div>
					<a href="/agent/pay_premium">
						<span>Send Payment</span>
					</a>
				</div>
			</li>
		<? endif; ?>

	</ul>
</div>
