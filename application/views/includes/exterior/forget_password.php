<div class="page container clearfix">
	<div class="row">
		<div class="page-content span12">
			<h3>Reset Your Password</h3>
			<p>Please enter your username that is associated with Instant Powers. A new password will be sent to your address on file.</p>
			<div id="form-container">
				<form id="contact-form" name="contact-form" method="post" action="/front/process_password_frm">
					<table width="100%" border="0" cellspacing="0" cellpadding="5">
						<tr>
							<td width="15%">
								<label for="name">Username</label>
							</td>
							<td width="70%">
								<input type="text" class="validate[required]" name="username" id="username" value="" />
							</td>
							<td width="15%" id="errOffset">&nbsp;</td>
						</tr>
						<tr>
							<td valign="top">&nbsp;</td>
							<td colspan="2">
								<input type="submit" id="button" class="rounded-1" style="padding: 5px 10px" value="Submit" />
								<input type="reset" id="button2" class="rounded-1" style="padding: 5px 10px" value="Reset" />
							</td>
						</tr>
					</table>
				</form>
			</div>
		</div>
		<div class="span4 sidebar">
			<ul class="widgets">
				<li class="widget category-widget clearfix">
					<h3>Register Area</h3>
					<ul class="clearfix">
						<li><a href="/register_agents">Bail Agents</a></li>
						<li><a href="/register_clerks">Court Clerks</a></li>
						<li><a href="/register_insurance">Insurance Companies</a></li>
						<li><a href="/register_jail">Jail Administrator</a></li>
					</ul>
				</li>
			</ul>
		</div>
	</div>
</div>
