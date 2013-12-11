<div class="page container clearfix">
	<div class="row">
		<div class="page-content span12">
			<h3>Contact a representative for assistance!</h3>
			<p>Have a question? Use the form below to contact us, we will respond to your question with in 48 hours.</p>
			<div id="form-container">
				<form id="contact-form" name="contact-form" method="post" action="/front/process_contact_frm">
					<table width="100%" border="0" cellspacing="0" cellpadding="5">
						<tr>
							<td width="15%">
								<label for="name">Name</label>
							</td>
							<td width="70%">
								<input type="text" class="validate[required,custom[onlyLetter]]" name="name" id="name" value="" />
							</td>
							<td width="15%" id="errOffset">&nbsp;</td>
						</tr>
						<tr>
							<td>
								<label for="email">Email</label>
							</td>
							<td>
								<input type="text" class="validate[required,custom[email]]" name="email" id="email" value="" />
							</td>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td>
								<label for="subject">Subject</label>
							</td>
							<td>
								<select name="subject" id="subject">
									<option value="" selected="selected"> - Choose -</option>
									<option value="Question">Question</option>
									<option value="Bail Agents">Bail Agents</option>
									<option value="Court Clerks">Court Clerks</option>
									<option value="Insurance Companies">Insurance Companies</option>
									<option value="Jail Administrator">Jail Administrator</option>
								</select>
							</td>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td valign="top">
								<label for="message">Message</label>
							</td>
							<td>
								<textarea name="message" id="message" class="validate[required]" cols="35" style="width: 400px;" rows="8"></textarea>
							</td>
							<td valign="top">&nbsp;</td>
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
