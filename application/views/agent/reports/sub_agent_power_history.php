<?= form_open( '/agent/reports/process_sub_agent_history' ); ?>
<div class="col50">
<?
	echo form_label('Sub Agent', 'sub_agent'); 
	echo form_dropdown('sub_agent', $agents,  '', 'id="sub_agent"  ');
?>


</div>
<div class="clearfix"></div>
<div class="t-right">
	<p>
		<input type="submit" value="Select Agent" class="white" />
		<button type="button" class="white" onClick="location.href = '/agent/reports'">Cancel</button>
	</p>
</div>





<? form_close(); ?>