<h3 class="tit">Choose the transmitting company in which you would like to add a premium/BUF</h3>
<?= form_open( '/members/manage_account/process_ins_choose_frm' ); ?>


<fieldset>
	<legend>Choose Transmitting Company</legend>
<div class="col50">

<?
	echo form_label('Transmitting Companies', 'ins_company'); 
	echo form_dropdown('ins_company', $ins,  '', 'id="ins_company"  ');
?>


</div>
</fieldset>

<div class="clearfix"></div>
<div class="t-right">
	<p>
		<input type="submit" value="Choose Transmitting Company" class="white" />
		<button type="button" class="white" onClick="location.href = '/members/manage_account'">Cancel</button>
	</p>
</div>

<?= form_close(); ?>