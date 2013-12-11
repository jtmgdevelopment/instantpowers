<div class="page container clearfix">
<div class="row">
<div class="page-content full span12">
<form id="login-frm" action="/front/process_private_login" method="post">
<fieldset class="demo-fieldset">
<legend></legend>
<div class="clearfix">
	<div class="input"><br clear="all"><br>
		<select name="username" style="font-size:18px; height:50px; width:80%; padding:15px; text-transform:uppercase">
			<? foreach( $u as $m ): ?>
				<option style="padding:10px;" value="<?= $m[ 'username' ]; ?>"> <?= $m[ 'role' ]; ?> ~ <?= $m[ 'full_name' ]; ?> <?= $m[ 'username' ]; ?> - <?= $m[ 'agency_name' ] ?></option>
			
			<? endforeach; ?>
		</select>
	</div>
</div>

<div class="clearfix">
<br clear="all" />
<input type="submit" class="small-btn orange rounded-2" value="Sign In" />
</div>
<!-- /clearfix -->
</fieldset></form>
</div>
</div>
</div>
