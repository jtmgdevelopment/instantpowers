<div id="wrapper">
	<div class="container clearfix">
		<div id="content-fullwidth">
			<div class="breadcrumb-bar">
				<p class="breadcrumb-wrapper">
					<a href="/">Home</a> &nbsp; | &nbsp; <a class="active" href="#">
					<?= $title; ?>
					</a>
				</p>
				<ul class="bar-icons">
					<li><a href="#"><img src="/assets/images/icons/print-ico.png" alt="printer" /></a></li>
					<li><a href="#"><img src="/assets/images/icons/mail-ico.png" alt="mail" /></a></li>
					<li><a href="#"><img src="/assets/images/icons/phone-ico.png" alt="fax" /></a></li>
				</ul>
			</div>
			<h3 class="title">
				<?= $title; ?>
			</h3>
			<div class="form-wrapper">
				<div class="form-wrapper-head">
					<h3>Sign Up As Vendor Or Landlord</h3>
				</div>
				<p>
					Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla ligula risus, sodales sit amet ultrices sit amet, dignissim sit amet sem.
				</p>
				<form class="form" action="/process_sign_up" method="post">
					<div class="field-item">
						<label class="required" for="full_name">Full Name</label>
						<input type="text" id="full_name" name="full_name" value="" />
					</div>
					<div class="field-item">
						<label class="required" for="email">Email</label>
						<input type="text" id="email" name="email" value="" />
					</div>
					<div class="field-item">
						<label class="required" for="password">Password</label>
						<input type="password" id="password" name="password" value="" />
					</div>
					<div class="field-item">
						<label class="required" for="account_type">Account Type</label>
						<select id="account_type" name="account_type">
							<option value="">Choose Your Member Type</option>
							<option value="landlord">Landlord</option>
							<option value="vendor">Vendor</option>
						</select>
					</div>
					
					<div class="field-item">
						<input type="submit" value="Search" class="mc-button" />
					</div>
				</form>
			</div>
			<!-- ADVANCE SEARCH WRAPPER CLOSED --> 
			
		</div>
		<!-- CONTENT HOME CLOSED --> 
	</div>
	<!-- CONTAINER CLOSED --> 
</div>
<!-- WRAPPER....................................................................................................... CLOSED --> 
