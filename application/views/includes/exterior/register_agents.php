<div class="page container clearfix">
	<div class="row">
		<div class="page-content full span12">
			<h3>Agency / Master Agent Registration</h3>
			<p>Complete the registration form below to set up your Instant Powers administration profile.</p>
			<br/>
			<form id="agent-form" method="post" action="/front/process_agent_frm">
				<fieldset class="demo-fieldset">
					<legend></legend>
					<div class="clearfix">
						<label for="full_name" class="is-required">Agent Name:</label>
						<div class="input">
							<input class="xlarge" id="full_name" name="full_name" size="30" type="text" value="<?= set_value('full_name');?>" />
						</div>
					</div>
					<!-- /clearfix -->
					<div class="clearfix">
						<label for="email" class="is-required">Agent Email Address:</label>
						<div class="input">
							<input class="xlarge" id="email" name="email" size="30" type="text" value="<?= set_value('email');?>" />
						</div>
					</div>
					<!-- /clearfix -->
					<div class="clearfix">
						<label for="password" class="is-required">Password:</label>
						<div class="input">
							<input class="xlarge" id="password" name="password" size="30" type="password" value="<?= set_value('password');?>" />
						</div>
					</div>
					<!-- /clearfix -->
					<div class="clearfix">
						<label for="co_password" class="is-required">Confirm Password:</label>
						<div class="input">
							<input class="xlarge" id="co_password" name="co_password" size="30" type="password" value="<?= set_value('co_password');?>" />
						</div>
					</div>
					
					<!-- /clearfix -->
					<div class="clearfix">
						<label for="agent_license_number" class="is-required">Agent License Number:</label>
						<div class="input">
							<input class="xlarge" id="xlInput" name="agent_license_number" size="30" type="text" value="<?= set_value('agent_license_number');?>" />
						</div>
					</div>
					<!-- /clearfix -->
					<div class="clearfix">
						<label for="agency_name" class="is-required">Agency Name:</label>
						<div class="input">
							<input class="xlarge" id="agency_name" name="agency_name" size="30" type="text" value="<?= set_value('agency_name');?>" />
						</div>
					</div>
					
					<!-- /clearfix -->
					<div class="clearfix">
						<label for="address" class="is-required">Agency Address:</label>
						<div class="input">
							<input class="xlarge" id="address" name="address" size="30" type="text" value="<?= set_value('address');?>" />
						</div>
					</div>
					<!-- /clearfix -->
					<div class="clearfix">
						<label for="city" class="is-required">Agency City:</label>
						<div class="input">
							<input class="xlarge" id="city" name="city" size="30" type="text" value="<?= set_value('city');?>" />
						</div>
					</div>
					<!-- /clearfix -->
					<div class="clearfix">
						<label for="state" class="is-required">Agency State:</label>
						<div class="input">
							<input class="xlarge" id="state" name="state" size="30" type="text" value="<?= set_value('state');?>" />
						</div>
					</div>
					<!-- /clearfix -->
					<div class="clearfix">
						<label for="address" class="is-required">Agency Zip:</label>
						<div class="input">
							<input class="xlarge" id="zip" name="zip" size="30" type="text" value="<?= set_value('zip');?>" />
						</div>
					</div>
					<!-- /clearfix -->
					<div class="clearfix">
						<label for="phone" class="is-required">Agency Phone Number:</label>
						<div class="input">
							<input class="xlarge" id="phone" name="phone" size="30" type="text" value="<?= set_value('phone');?>" />
						</div>
					</div>
					<!-- /clearfix -->
					<? /*
					<div>
						<p>
						<h6>**These figures are used to generate an agent report.</h6>
						</p>
					</div>
					<div class="clearfix">
						<label>1. Commision Profile:</label>
						<div class="input">
							<div class="inline-inputs">
								<input class="medium" type="text" value="Insurance Company" />
								<input class="medium" type="text" value="Agent" />
								<input class="medium" type="text" value="BUF Account" />
								<input class="small" type="text" style="color:#CB4B16;" value="TOTAL 100%" />
							</div>
						</div>
					</div>
					<!-- /clearfix -->
					<div class="clearfix">
						<label>2. Commision Profile:</label>
						<div class="input">
							<div class="inline-inputs">
								<input class="medium" type="text" value="Insurance Company" />
								<input class="medium" type="text" value="Agent" />
								<input class="medium" type="text" value="BUF Account" />
								<input class="small" type="text" style="color:#CB4B16;" value="TOTAL 100%" />
							</div>
						</div>
					</div>
					<!-- /clearfix -->
					<div class="clearfix">
						<label>3. Commision Profile:</label>
						<div class="input">
							<div class="inline-inputs">
								<input class="medium" type="text" value="Insurance Company" />
								<input class="medium" type="text" value="Agent" />
								<input class="medium" type="text" value="BUF Account" />
								<input class="small" type="text" style="color:#CB4B16;" value="TOTAL 100%" />
							</div>
						</div>
					</div>
					<!-- /clearfix -->
					*/?>
				</fieldset>
			<!--
			<div>
				<h3>Sub Agents Registration</h3>
				<p>List your sub agents below. <em>*<strong>Note</strong>, Please check the <strong>"Add Sub Agent"</strong> checkbox to add the sub agent to the registration form.</em></p>
					<fieldset class="demo-fieldset">
						<ul class="breadcrumb<? if( array_key_exists('sub_agent_active_1', $_POST ) && $_POST['sub_agent_active_1'] == 1 ): ?> is-highlight <? endif; ?>">
							<li class="active"><input <? if( array_key_exists('sub_agent_active_1', $_POST ) && $_POST['sub_agent_active_1'] == 1 ): ?> checked="checked" <? endif; ?> type="checkbox" name="sub_agent_active_1" value="1" /> <strong>Add Sub Agent 1</strong> </li>
						</ul>
						<div class="clearfix">
							<label>Agent Profile:</label>
							<div class="input">
								<div class="inline-inputs">
									<input class="large remove-text" type="text" name="sub_agent_name_1" data-title="Agent Name" value="<?= set_value('sub_agent_name_1') != 'Agent Name' ? set_value('sub_agent_name_1' ) : 'Agent Name'; ?>" />
									<input class="large remove-text" type="text" name="sub_agent_license_number_1" value="<?= set_value('sub_agent_license_number_1') != 'Agent License Number' ? set_value('sub_agent_license_number_1' ) : 'Agent License Number'; ?>" />
									<input class="large remove-text" type="text" name="sub_agent_email_1" data-title="<?= set_value('sub_agent_email_1') != 'Email Address' ? set_value('sub_agent_email_1' ) : 'Email Address'; ?>" value="<?= set_value('sub_agent_email_1') != 'Email Address' ? set_value('sub_agent_email_1' ) : 'Email Address'; ?>" />
								</div>
							</div>
						</div>
						<? /*
						<!-- /clearfix -->
						<div class="clearfix">
							<label>Commision Profile:</label>
							<div class="input">
								<div class="inline-inputs">
									<select name="" class="medium"></select>
									<input class="medium" type="text" value="Agent" />
									<input class="medium" type="text" value="BUF Account" />
									<input class="small" type="text" style="color:#CB4B16;" value="TOTAL 100%" />
								</div>
							</div>
						</div>
						<!-- /clearfix -->
						*/ ?>
						<ul class="breadcrumb<? if( array_key_exists('sub_agent_active_2', $_POST ) && $_POST['sub_agent_active_2'] == 1 ): ?> is-highlight <? endif; ?>">
							<li class="active"><input <? if( array_key_exists('sub_agent_active_2', $_POST ) && $_POST['sub_agent_active_2'] == 1 ): ?> checked="checked" <? endif; ?> type="checkbox" name="sub_agent_active_2" value="1" /> <strong>Add Sub Agent 2</strong> </li>
						</ul>
						<div class="clearfix">
							<label>Agent Profile:</label>
							<div class="input">
								<div class="inline-inputs">
									<input class="large remove-text" type="text" name="sub_agent_name_2" data-title="Agent Name" value="<?= set_value('sub_agent_name_2') != 'Agent Name' ? set_value('sub_agent_name_2' ) : 'Agent Name'; ?>" />
									<input class="large remove-text" type="text" name="sub_agent_license_number_2" data-title="Agent License Number" value="<?= set_value('sub_agent_license_number_2') != 'Agent License Number' ? set_value('sub_agent_license_number_2' ) : 'Agent License Number'; ?>" />
									<input class="large remove-text" type="text" name="sub_agent_email_2" data-title="<?= set_value('sub_agent_email_1') != 'Email Address' ? set_value('sub_agent_email_2' ) : 'Email Address'; ?>" value="<?= set_value('sub_agent_email_2') != 'Email Address' ? set_value('sub_agent_email_2' ) : 'Email Address'; ?>" />
								</div>
							</div>
						</div>
						<? /*
						<!-- /clearfix -->
						<div class="clearfix">
							<label>Commision Profile:</label>
							<div class="input">
								<div class="inline-inputs">
									<input class="medium" type="text" value="Insurance Company" />
									<input class="medium" type="text" value="Agent" />
									<input class="medium" type="text" value="BUF Account" />
									<input class="small" type="text" style="color:#CB4B16;" value="TOTAL 100%" />
								</div>
							</div>
						</div>
						<!-- /clearfix -->
						*/ ?>
						<ul class="breadcrumb<? if( array_key_exists('sub_agent_active_3', $_POST ) && $_POST['sub_agent_active_3'] == 1 ): ?> is-highlight <? endif; ?>">
							<li class="active"><input <? if( array_key_exists('sub_agent_active_3', $_POST ) && $_POST['sub_agent_active_3'] == 1 ): ?> checked="checked" <? endif; ?> type="checkbox" name="sub_agent_active_3" value="1" /> <strong>Add Sub Agent 3</strong> </li>
						</ul>
						<div class="clearfix">
							<label>Agent Profile:</label>
							<div class="input">
								<div class="inline-inputs">
									<input class="large remove-text" type="text" name="sub_agent_name_3" data-title="Agent Name" value="<?= set_value('sub_agent_name_3') != 'Agent Name' ? set_value('sub_agent_name_3' ) : 'Agent Name'; ?>" />
									<input class="large remove-text" type="text" name="sub_agent_license_number_3" data-title="Agent License Number" value="<?= set_value('sub_agent_license_number_3') != 'Agent License Number' ? set_value('sub_agent_license_number_3' ) : 'Agent License Number'; ?>" />
									<input class="large remove-text" type="text" name="sub_agent_email_3" data-title="<?= set_value('sub_agent_email_1') != 'Email Address' ? set_value('sub_agent_email_1' ) : 'Email Address'; ?>" value="<?= set_value('sub_agent_email_3') != 'Email Address' ? set_value('sub_agent_email_3' ) : 'Email Address'; ?>" />
								</div>
							</div>
						</div>
						<ul class="breadcrumb<? if( array_key_exists('sub_agent_active_4', $_POST ) && $_POST['sub_agent_active_4'] == 1 ): ?> is-highlight <? endif; ?>">
							<li class="active"><input <? if( array_key_exists('sub_agent_active_4', $_POST ) && $_POST['sub_agent_active_4'] == 1 ): ?> checked="checked" <? endif; ?> type="checkbox" name="sub_agent_active_4" value="1" /> <strong>Add Sub Agent 4</strong></li>
						</ul>
						<div class="clearfix">
							<label>Agent Profile:</label>
							<div class="input">
								<div class="inline-inputs">
									<input class="large remove-text" type="text" name="sub_agent_name_4" data-title="Agent Name" value="<?= set_value('sub_agent_name_4') != 'Agent Name' ? set_value('sub_agent_name_4' ) : 'Agent Name'; ?>" />
									<input class="large remove-text" type="text" name="sub_agent_license_number_4" data-title="<?= set_value('sub_agent_license_number_1') != 'Agent License Number' ? set_value('sub_agent_license_number_1' ) : 'Agent License Number'; ?>" value="<?= set_value('sub_agent_license_number_4') != 'Agent License Number' ? set_value('sub_agent_license_number_4' ) : 'Agent License Number'; ?>" />
									<input class="large remove-text" type="text" name="sub_agent_email_4" data-title="<?= set_value('sub_agent_email_1') != 'Email Address' ? set_value('sub_agent_email_1' ) : 'Email Address'; ?>" value="<?= set_value('sub_agent_email_4') != 'Email Address' ? set_value('sub_agent_email_4' ) : 'Email Address'; ?>" />
								</div>
							</div>
						</div>
						<ul class="breadcrumb<? if( array_key_exists('sub_agent_active_5', $_POST ) && $_POST['sub_agent_active_5'] == 1 ): ?> is-highlight <? endif; ?>">
							<li class="active"><input <? if( array_key_exists('sub_agent_active_5', $_POST ) && $_POST['sub_agent_active_5'] == 1 ): ?> checked="checked" <? endif; ?> type="checkbox" name="sub_agent_active_5" value="1" /> <strong>Add Sub Agent 5</strong> </li>
						</ul>
						<div class="clearfix">
							<label>Agent Profile:</label>
							<div class="input">
								<div class="inline-inputs">
									<input class="large remove-text" type="text" name="sub_agent_name_5" data-title="Agent Name" value="<?= set_value('sub_agent_name_5') != 'Agent Name' ? set_value('sub_agent_name_5' ) : 'Agent Name'; ?>" />
									<input class="large remove-text" type="text" name="sub_agent_license_number_5" data-title="<?= set_value('sub_agent_license_number_1') != 'Agent License Number' ? set_value('sub_agent_license_number_1' ) : 'Agent License Number'; ?>" value="<?= set_value('sub_agent_license_number_5') != 'Agent License Number' ? set_value('sub_agent_license_number_5' ) : 'Agent License Number'; ?>" />
									<input class="large remove-text" type="text" name="sub_agent_email_5" data-title="<?= set_value('sub_agent_email_1') != 'Email Address' ? set_value('sub_agent_email_1' ) : 'Email Address'; ?>" value="<?= set_value('sub_agent_email_5') != 'Email Address' ? set_value('sub_agent_email_5' ) : 'Email Address'; ?>" />
								</div>
							</div>
						</div>
						<? /*
						<!-- /clearfix -->
						<div class="clearfix">
							<label>Commision Profile:</label>
							<div class="input">
								<div class="inline-inputs">
									<input class="medium" type="text" value="Insurance Company" />
									<input class="medium" type="text" value="Agent" />
									<input class="medium" type="text" value="BUF Account" />
									<input class="small" type="text" style="color:#CB4B16;" value="TOTAL 100%" />
								</div>
							</div>
							<br clear="all" />
							<a class="small-btn orange rounded-2" href="#">Click Here To Submit Registration!</a> </div>
						<!-- /clearfix -->
						*/ ?>
						<div id="more-sub-agents" style="display:none">
							<ul class="breadcrumb<? if( array_key_exists('sub_agent_active_6', $_POST ) && $_POST['sub_agent_active_6'] == 1 ): ?> is-highlight <? endif; ?>">
								<li class="active"><input <? if( array_key_exists('sub_agent_active_6', $_POST ) && $_POST['sub_agent_active_6'] == 1 ): ?> checked="checked" <? endif; ?> type="checkbox" name="sub_agent_active_6" value="1" /> <strong>Add Sub Agent 6</strong> </li>
							</ul>
							<div class="clearfix">
								<label>Agent Profile:</label>
								<div class="input">
									<div class="inline-inputs">
										<input class="large remove-text" type="text" name="sub_agent_name_6" data-title="Agent Name" value="<?= set_value('sub_agent_name_6') != 'Agent Name' ? set_value('sub_agent_name_6' ) : 'Agent Name'; ?>" />
										<input class="large remove-text" type="text" name="sub_agent_license_number_6" data-title="<?= set_value('sub_agent_license_number_1') != 'Agent License Number' ? set_value('sub_agent_license_number_1' ) : 'Agent License Number'; ?>" value="<?= set_value('sub_agent_license_number_6') != 'Agent License Number' ? set_value('sub_agent_license_number_6' ) : 'Agent License Number'; ?>" />
										<input class="large remove-text" type="text" name="sub_agent_email_6" data-title="<?= set_value('sub_agent_email_1') != 'Email Address' ? set_value('sub_agent_email_1' ) : 'Email Address'; ?>" value="<?= set_value('sub_agent_email_6') != 'Email Address' ? set_value('sub_agent_email_6' ) : 'Email Address'; ?>" />
									</div>
								</div>
							</div>
							<? /*
						<!-- /clearfix -->
						<div class="clearfix">
							<label>Commision Profile:</label>
							<div class="input">
								<div class="inline-inputs">
									<select name="" class="medium"></select>
									<input class="medium" type="text" value="Agent" />
									<input class="medium" type="text" value="BUF Account" />
									<input class="small" type="text" style="color:#CB4B16;" value="TOTAL 100%" />
								</div>
							</div>
						</div>
						<!-- /clearfix -->
						*/ ?>
							<ul class="breadcrumb<? if( array_key_exists('sub_agent_active_7', $_POST ) && $_POST['sub_agent_active_7'] == 1 ): ?> is-highlight <? endif; ?>">
								<li class="active "><input <? if( array_key_exists('sub_agent_active_7', $_POST ) && $_POST['sub_agent_active_7'] == 1 ): ?> checked="checked" <? endif; ?> type="checkbox" name="sub_agent_active_7" value="1" /> <strong>Add Sub Agent 7</strong> </li>
							</ul>
							<div class="clearfix">
								<label>Agent Profile:</label>
								<div class="input">
									<div class="inline-inputs">
										<input class="large remove-text" type="text" name="sub_agent_name_7" data-title="Agent Name" value="<?= set_value('sub_agent_name_7') != 'Agent Name' ? set_value('sub_agent_name_7' ) : 'Agent Name'; ?>" />
										<input class="large remove-text" type="text" name="sub_agent_license_number_7" data-title="<?= set_value('sub_agent_license_number_1') != 'Agent License Number' ? set_value('sub_agent_license_number_1' ) : 'Agent License Number'; ?>" value="<?= set_value('sub_agent_license_number_7') != 'Agent License Number' ? set_value('sub_agent_license_number_7' ) : 'Agent License Number'; ?>" />
										<input class="large remove-text" type="text" name="sub_agent_email_7" data-title="<?= set_value('sub_agent_email_1') != 'Email Address' ? set_value('sub_agent_email_1' ) : 'Email Address'; ?>" value="<?= set_value('sub_agent_email_7') != 'Email Address' ? set_value('sub_agent_email_7' ) : 'Email Address'; ?>" />
									</div>
								</div>
							</div>
							<? /*
						<!-- /clearfix -->
						<div class="clearfix">
							<label>Commision Profile:</label>
							<div class="input">
								<div class="inline-inputs">
									<input class="medium" type="text" value="Insurance Company" />
									<input class="medium" type="text" value="Agent" />
									<input class="medium" type="text" value="BUF Account" />
									<input class="small" type="text" style="color:#CB4B16;" value="TOTAL 100%" />
								</div>
							</div>
						</div>
						<!-- /clearfix -->
						*/ ?>
							<ul class="breadcrumb<? if( array_key_exists('sub_agent_active_8', $_POST ) && $_POST['sub_agent_active_8'] == 1 ): ?> is-highlight <? endif; ?>">
								<li class="active"><input <? if( array_key_exists('sub_agent_active_8', $_POST ) && $_POST['sub_agent_active_8'] == 1 ): ?> checked="checked" <? endif; ?> type="checkbox" name="sub_agent_active_8" value="1" /> <strong>Add Sub Agent 8</strong> </li>
							</ul>
							<div class="clearfix">
								<label>Agent Profile:</label>
								<div class="input">
									<div class="inline-inputs">
										<input class="large remove-text" type="text" name="sub_agent_name_8" data-title="Agent Name" value="<?= set_value('sub_agent_name_8') != 'Agent Name' ? set_value('sub_agent_name_8' ) : 'Agent Name'; ?>" />
										<input class="large remove-text" type="text" name="sub_agent_license_number_8" data-title="<?= set_value('sub_agent_license_number_1') != 'Agent License Number' ? set_value('sub_agent_license_number_1' ) : 'Agent License Number'; ?>" value="<?= set_value('sub_agent_license_number_8') != 'Agent License Number' ? set_value('sub_agent_license_number_8' ) : 'Agent License Number'; ?>" />
										<input class="large remove-text" type="text" name="sub_agent_email_8" data-title="<?= set_value('sub_agent_email_1') != 'Email Address' ? set_value('sub_agent_email_1' ) : 'Email Address'; ?>" value="<?= set_value('sub_agent_email_8') != 'Email Address' ? set_value('sub_agent_email_8' ) : 'Email Address'; ?>" />
									</div>
								</div>
							</div>
							<ul class="breadcrumb<? if( array_key_exists('sub_agent_active_9', $_POST ) && $_POST['sub_agent_active_9'] == 1 ): ?> is-highlight <? endif; ?>">
								<li class="active"><input <? if( array_key_exists('sub_agent_active_9', $_POST ) && $_POST['sub_agent_active_9'] == 1 ): ?> checked="checked" <? endif; ?> type="checkbox" name="sub_agent_active_9" value="1" /> <strong>Add Sub Agent 9</strong> </li>
							</ul>
							<div class="clearfix">
								<label>Agent Profile:</label>
								<div class="input">
									<div class="inline-inputs">
										<input class="large remove-text" type="text" name="sub_agent_name_9" data-title="Agent Name" value="<?= set_value('sub_agent_name_9') != 'Agent Name' ? set_value('sub_agent_name_9' ) : 'Agent Name'; ?>" />
										<input class="large remove-text" type="text" name="sub_agent_license_number_9" data-title="<?= set_value('sub_agent_license_number_1') != 'Agent License Number' ? set_value('sub_agent_license_number_1' ) : 'Agent License Number'; ?>" value="<?= set_value('sub_agent_license_number_9') != 'Agent License Number' ? set_value('sub_agent_license_number_9' ) : 'Agent License Number'; ?>" />
										<input class="large remove-text" type="text" name="sub_agent_email_9" data-title="<?= set_value('sub_agent_email_1') != 'Email Address' ? set_value('sub_agent_email_1' ) : 'Email Address'; ?>" value="<?= set_value('sub_agent_email_9') != 'Email Address' ? set_value('sub_agent_email_9' ) : 'Email Address'; ?>" />
									</div>
								</div>
							</div>
							<ul class="breadcrumb<? if( array_key_exists('sub_agent_active_10', $_POST ) && $_POST['sub_agent_active_10'] == 1 ): ?> is-highlight <? endif; ?>">
								<li class="active"><input <? if( array_key_exists('sub_agent_active_10', $_POST ) && $_POST['sub_agent_active_10'] == 1 ): ?> checked="checked" <? endif; ?> type="checkbox" name="sub_agent_active_10" value="1" /> <strong>Add Sub Agent 10</strong> </li>
							</ul>
							<div class="clearfix">
								<label>Agent Profile:</label>
								<div class="input">
									<div class="inline-inputs">
										<input class="large remove-text" type="text" name="sub_agent_name_10" data-title="Agent Name" value="<?= set_value('sub_agent_name_10') != 'Agent Name' ? set_value('sub_agent_name_10' ) : 'Agent Name'; ?>" />
										<input class="large remove-text" type="text" name="sub_agent_license_number_10" data-title="<?= set_value('sub_agent_license_number_10') != 'Agent License Number' ? set_value('sub_agent_license_number_10' ) : 'Agent License Number'; ?>" value="<?= set_value('sub_agent_license_number_10') != 'Agent License Number' ? set_value('sub_agent_license_number_10' ) : 'Agent License Number'; ?>" />
										<input class="large remove-text" type="text" name="sub_agent_email_10" data-title="<?= set_value('sub_agent_email_10') != 'Email Address' ? set_value('sub_agent_email_10' ) : 'Email Address'; ?>" value="<?= set_value('sub_agent_email_10') != 'Email Address' ? set_value('sub_agent_email_10' ) : 'Email Address'; ?>" />
									</div>
								</div>
							</div>
						</div>
						-->
						<div class="clearfix"> <a id="submit-agent-frm" class="small-btn orange rounded-2" href="#">Click Here To Submit Registration!</a> </div>
					</fieldset>
				</form>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
$( document ).ready(function(e) {

	
	$( 'input[ name="sub_agent_name_1"],input[ name="sub_agent_name_2"],input[ name="sub_agent_name_3"],input[ name="sub_agent_name_4"],input[ name="sub_agent_name_5"],input[ name="sub_agent_name_6"],input[ name="sub_agent_name_7"],input[ name="sub_agent_name_8"],input[ name="sub_agent_name_9"],input[ name="sub_agent_name_10"]' ).defaultValue('Agent Name');

	$( 'input[ name="sub_agent_license_number_1"],input[ name="sub_agent_license_number_2"],input[ name="sub_agent_license_number_3"],input[ name="sub_agent_license_number_4"],input[ name="sub_agent_license_number_5"],input[ name="sub_agent_license_number_6"],input[ name="sub_agent_license_number_7"],input[ name="sub_agent_license_number_8"],input[ name="sub_agent_license_number_9"],input[ name="sub_agent_license_number_10"]' ).defaultValue('Agent License Number');

	$( 'input[ name="sub_agent_email_1"],input[ name="sub_agent_email_2"],input[ name="sub_agent_email_3"],input[ name="sub_agent_email_4"],input[ name="sub_agent_email_5"],input[ name="sub_agent_email_6"],input[ name="sub_agent_email_7"],input[ name="sub_agent_email_8"],input[ name="sub_agent_email_9"],input[ name="sub_agent_email_10"]' ).defaultValue('Email Address');

});


</script>