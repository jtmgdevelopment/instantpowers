<div class="page container clearfix">
	<div class="row">
		<div class="page-content full span12">
			<h3>Insurance Company Registration</h3>
			<p>Complete the registration form below to set up your Instant Powers administration profile.</p>
			<br/>
			<form id="ins-form" action="/front/process_insurance_frm" method="post">
				<fieldset class="demo-fieldset">
					<legend></legend>
					<div class="clearfix">
						<label for="company_name" class="is-required">Insurance Company:</label>
						<div class="input">
							<input class="xlarge" id="company_name" name="company_name" value="<?= set_value( 'company_name' ); ?>" size="30" type="text" />
						</div>
					</div>
					<!-- /clearfix -->
					<div class="clearfix">
						<label for="agent_name" class="is-required">Insurance Agent:</label>
						<div class="input">
							<input class="xlarge" id="agent_name" name="agent_name" value="<?= set_value( 'agent_name' ); ?>" size="30" type="text" />
						</div>
					</div>
					<!-- /clearfix -->
					<div class="clearfix">
						<label for="email" class="is-required">Email Address:</label>
						<div class="input">
							<input class="xlarge" id="email" name="email" value="<?= set_value( 'email' ); ?>" size="30" type="text" />
						</div>
					</div>
					<!-- /clearfix -->
					<div class="clearfix">
						<label for="physical_address" class="is-required">Physical Address:</label>
						<div class="input">
							<textarea class="xxlarge" id="physical_address" name="physical_address" rows="3"><?= set_value( 'physical_address' ); ?></textarea>
						</div>
					</div>
					<!-- /clearfix -->
					<div class="clearfix">
						<label for="mailing_address" class="is-required">Mailing Address:</label>
						<div class="input">
							<textarea class="xxlarge" id="mailing_address" name="mailing_address" rows="3"><?= set_value( 'mailing_address' ); ?></textarea>
						</div>
					</div>
					<!-- /clearfix -->
					<div class="clearfix">
						<label for="phone" class="is-required">Phone Number:</label>
						<div class="input">
							<input class="xlarge" id="phone" name="phone" value="<?= set_value( 'phone' ); ?>" size="30" type="text" />
						</div>
						<br clear="all" />
						<a id="submit-ins-frm" class="small-btn orange rounded-2" href="#">Click Here To Submit Registration!</a> </div>
					<!-- /clearfix -->
					
				</fieldset>
			</form>
		</div>
	</div>
</div>
