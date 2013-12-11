<p class="box"><a href="/mga/reports/choose_ins_company" class="btn"><span>View Past Reports</span></a></p>
<?= form_open( $process_url ); ?>


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
		<button type="button" class="white" onClick="location.href = '/mga/reports'">Cancel</button>
	</p>
</div>

<?= form_close(); ?>