<div class="page container clearfix">
	<div class="row">
		<div class="page-content full span12">
			<h3>Clerk of Court Registration</h3>
			<p>Complete the registration form below to set up your Instant Powers administration profile.</p>
			<br/>
			<form id="clerk-form" action="/front/process_clerks_frm" method="post">
				<fieldset class="demo-fieldset">
					<legend></legend>
					<div class="clearfix">
						<label for="court_name" class="is-required">Clerk of Court Name:</label>
						<div class="input">
							<input class="xlarge" id="court_name" name="court_name" size="30" type="text" value="<?= set_value('court_name'); ?>" />
						</div>
					</div>
					<!-- /clearfix -->
					<div class="clearfix">
						<label for="county" class="is-required">County:</label>
						<div class="input">
							<input class="xlarge" id="county" name="county" size="30" type="text"  value="<?= set_value('county'); ?>"/>
						</div>
					</div>
					<!-- /clearfix -->
					<div class="clearfix">
						<label for="clerk_name" class="is-required">Clerk Administrator:<br /><em>(Full Name)</em></label>
						<div class="input">
							<input class="xlarge" id="clerk_name" name="clerk_name" size="30" type="text"  value="<?= set_value('clerk_name'); ?>"/>
						</div>
					</div>
					<!-- /clearfix -->
					<div class="clearfix">
						<label for="email" class="is-required">Email Address:</label>
						<div class="input">
							<input class="xlarge" id="email" name="email" size="30" type="text"  value="<?= set_value('email'); ?>"/>
						</div>
					</div>
					<!-- /clearfix -->
					<div class="clearfix">
						<label for="physical_address" class="is-required">Physical Address:</label>
						<div class="input">
							<textarea class="xxlarge" id="physical_address" name="physical_address" rows="3"> <?= set_value('physical_address'); ?></textarea>
						</div>
					</div>
					<!-- /clearfix -->
					<div class="clearfix">
						<label for="mailing_address" class="is-required">Mailing Address:</label>
						<div class="input">
							<textarea class="xxlarge" id="mailing_address" name="mailing_address" rows="3"><?= set_value('mailing_address'); ?></textarea>
						</div>
					</div>
					<!-- /clearfix -->
					<div class="clearfix">
						<label for="phone" class="is-required">Phone Number:</label>
						<div class="input">
							<input class="xlarge" id="phone" name="phone" size="30" type="text"  value="<?= set_value('phone'); ?>"/>
						</div>
						<br clear="all" />
						<a id="submit-clerk-frm" class="small-btn orange rounded-2" href="#">Click Here To Submit Registration!</a> 
					</div>
					<!-- /clearfix -->
					
				</fieldset>
			</form>
		</div>
	</div>
</div>
