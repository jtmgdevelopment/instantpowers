<h3 class="tit">You are about to transfer <?= count( $transfer ); ?> powers</h3>
<p>Please choose the Sub Agent that you would like these powers be transferred to</p>
<?= form_open( '/master_agent/power_inventory/process_sub_agent_transfers_powers' ); ?>

<div class="col50">
<?
	echo form_label('Sub Agent', 'sub_agent'); 
	echo form_dropdown('sub_agent', $sub_agents,  '', 'id="sub_agent"  ');
?>


</div>
<div class="clearfix"></div>
<div class="t-right">
	<p>
		<input type="submit" value="Transfer Powers To Agent" class="white" />
		<button type="button" class="white" onClick="location.href = '/master_agent/power_inventory/'">Cancel</button>
	</p>
</div>





<? form_close(); ?>