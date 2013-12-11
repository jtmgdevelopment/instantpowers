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
				<a href="/jail/cpanel">
					<span>Control Panel</span>
				</a>
			</div>
		</li>
		<li onmouseover="this.className = 'dropdown-on'" onmouseout="this.className = 'dropdown-off'">
			<div>
				<a href="/jail/transmissions">
					<span>Transmissions</span>
				</a>
			</div>
		</li>
		<li onmouseover="this.className = 'dropdown-on'" onmouseout="this.className = 'dropdown-off'">
			<div>
				<a href="/jail/transmissions/pending/">
					<span>Pending Online Transmissions</span>
				</a>
			</div>
		</li>
		<li onmouseover="this.className = 'dropdown-on'" onmouseout="this.className = 'dropdown-off'">
			<div>
				<a href="/jail/transmissions/pending_offline/">
					<span>Pending Offline</span>
				</a>
			</div>
		</li>
		<li onmouseover="this.className = 'dropdown-on'" onmouseout="this.className = 'dropdown-off'">
			<div>
				<a href="/jail/transmissions/accepted_powers/">
					<span>Accepted Online</span>
				</a>
			</div>
		</li>
		<li onmouseover="this.className = 'dropdown-on'" onmouseout="this.className = 'dropdown-off'">
			<div>
				<a href="/jail/transmissions/offline_powers/">
					<span>Accepted Offline</span>
				</a>
			</div>
		</li>
		<li onmouseover="this.className = 'dropdown-on'" onmouseout="this.className = 'dropdown-off'">
			<div>
				<a href="/jail/reports/">
					<span>Reports</span>
				</a>
			</div>
		</li>
		
		


		<!--
		<li onmouseover="this.className = 'dropdown-on'" onmouseout="this.className = 'dropdown-off'">
			<div>
				<a href="/powers/create">
					<span>Create Transmission</span>
				</a>
			</div>
		</li>
		<li onmouseover="this.className = 'dropdown-on'" onmouseout="this.className = 'dropdown-off'">
			<div>
				<a href="/powers">
					<span>Instant Powers</span>
				</a>
				<div class="drop">
					<ul class="box">
						<li>
							<a href="/powers/search">
								Search Transmissions
							</a>
						</li>	
						<li>
							<a href="/powers/manage">
								Manage Instant Powers
							</a>
						</li>
					</ul>
				</div> 
				
			</div>
		</li>

		<li onmouseover="this.className = 'dropdown-on'" onmouseout="this.className = 'dropdown-off'">
			<div>
			<a href="/reports">
				<span>Reports</span>
			</a>
			</div>	
		</li>
		<li onmouseover="this.className = 'dropdown-on'" onmouseout="this.className = 'dropdown-off'">
			<div>
				<a href="/manage">
					<span>Manage Site</span>
				</a>
				<div class="drop">
					<ul class="box">
						<li>
							<a href="/manage/add_user">
								Add Members
							</a>
						</li>	
						<li>
							<a href="/manage/view">
								View Members
							</a>
						</li>	
						<li>
							<a href="/manage/add_prefix">
								Add Power Prefix
							</a> 
						</li>	

					</ul>
				</div> 
			</div>
		</li>
		-->
	</ul>
</div>
