<h3 class="tit">Power Summary - Total Powers: <?= $power_count; ?></h3>
<p>Below you will find a summary of the power you just created. You have options available to you:</p>
<ol>
	<li><strong>Create a new power to be batch together with this power</strong></li>
	<li><strong>View Power/s and print power </strong></li>
	<li><strong>Save and Execute this power</strong></li>
	<li><strong>Discharge Powers/s</strong></li>
</ol>	
<p class="box">
	<a class="btn-create" href="/agent/create_powers/batch_powers/<?= $trans_id; ?>/<?= $power_id ?>"><span>Add Power <em>(Batch Multiple Powers)</em></span></a>
	<a class="btn-info" href="/agent/create_powers/view_power/<?= $trans_id; ?>/<?= $power_id ?>"><span>View Power</em></span></a>
	<a class="btn-list" href="/agent/create_powers/execute_power/<?= $trans_id; ?>/<?= $power_id ?>"><span>Execute Power/s <em>(<?= $power_count; ?> Power/s)</em></span></a>
	<a class="btn" href="/agent/create_powers/edit_powers_list/<?= $trans_id; ?>/<?= $power_id; ?>"><span>Edit Powers</span></a>
	<a class="btn-delete" href="/agent/create_powers/cancel_power/<?= $trans_id; ?>/<?= $power_id ?>"><span>Start Over</span></a>
	
	<br /><br clear="all" /><em class="red">*"<strong>Start Over Button</strong>" This will clear all data you have entered so far.</em>

<?php /*?>	<a class="btn-delete" href="/master_agent/powers/discharge_power"><span>Discharge Power/s <em>(<?= count( $sp ); ?> Power/s)</em></span></a>
<?php */?>
</p>