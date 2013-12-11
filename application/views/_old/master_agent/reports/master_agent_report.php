<h3 class="tit">Choose the insurance company in which you would like to generate the Master Agent Report</h3>
<?= form_open( '/agent/reports/process_ins_company_frm' ); ?>


<fieldset>
	<legend>Choose Insurance Company</legend>
<div class="col50">

<?
	echo form_label('Insurance Companies', 'ins_company'); 
	echo form_dropdown('ins_company', $ins,  '', 'id="ins_company"  ');
?>


</div>
</fieldset>

<div class="clearfix"></div>
<div class="t-right">
	<p>
		<input type="submit" value="Select Insurance Company" class="white" />
		<button type="button" class="white" onClick="location.href = '/agent/reports'">Cancel</button>
	</p>
</div>

<?= form_close(); ?>