<!-- Tray -->
<div id="tray" class="box">
	<p class="f-left box">
		<!-- Switcher 
		<span class="f-left" id="switcher">
		<a href="##" rel="1col" class="styleswitch ico-col1" title="Display one column">
			<img src="/_assets/design/switcher-1col.gif" alt="1 Column" />
		</a>
		<a href="##" rel="2col" class="styleswitch ico-col2" title="Display two columns">
			<img src="/_assets/design/switcher-2col.gif" alt="2 Columns" />
		</a>
		</span> <strong id="switcher-text">Open Sidebar</strong>
		-->
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
				<a href="/mga/cpanel">
					<span>Control Panel</span>
				</a>
			</div>
		</li>
		<li onmouseover="this.className = 'dropdown-on'" onmouseout="this.className = 'dropdown-off'">
			<div>
				<a href="/mga/transmissions">
					<span>Manage Transmissions</span>
				</a>
			</div>
		</li>
		<li onmouseover="this.className = 'dropdown-on'" onmouseout="this.className = 'dropdown-off'">
			<div>
				<a href="/mga/power_inventory">
					<span>Powers Inventory</span>
				</a>
			</div>
			
		</li>
		<li onmouseover="this.className = 'dropdown-on'" onmouseout="this.className = 'dropdown-off'">
			<div>
				<a href="/mga/reports">
					<span>Reports</span>
				</a>
			</div>
			
		</li>
		<li onmouseover="this.className = 'dropdown-on'" onmouseout="this.className = 'dropdown-off'">
			<div>
				<a href="/mga/manage_credits">
					<span>Manage Credits Wallet</span>
				</a>
			</div>
		</li>
		
	</ul>
</div>
