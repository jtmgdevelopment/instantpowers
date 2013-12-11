<h3 class="tit">Power Summary - Total Powers: <?= count( $sp ); ?></h3>
<p>Below you will find a summary of the power you just created. You have options available to you:</p>
<ol>
	<li><strong>Create a new power to be batch together with this power</strong></li>
	<li><strong>View Power/s and print power </strong></li>
	<li><strong>Save and Execute this power</strong></li>
	<li><strong>Discharge Powers/s</strong></li>
</ol>	
<p class="box">
	<a class="btn-create" href="/master_agent/powers/batch_powers/<?= $transmission->trans_id; ?>/<?= $powers->pek ?>/<?= $powers->prefix_id ?>"><span>Add Power <em>(Batch Multiple Powers)</em></span></a>
	<a class="btn-info" href="/master_agent/powers/view_power/<?= $transmission->trans_id; ?>/<?= $powers->pek ?>/<?= $powers->prefix_id ?>"><span>View Power</em></span></a>
	<a class="btn-list" href="/master_agent/powers/execute_power/<?= $transmission->trans_id; ?>/<?= $powers->pek ?>/<?= $powers->prefix_id ?>"><span>Execute Power/s <em>(<?= count( $sp ); ?> Power/s)</em></span></a>
	<a class="btn-delete" href="/master_agent/powers/cancel_power/<?= $transmission->trans_id; ?>/<?= $powers->pek ?>/<?= $powers->prefix_id ?>"><span>Start Over</span></a>
	<br /><br clear="all" /><em class="red">*"<strong>Start Over Button</strong>" This will clear all data you have entered so far.</em>

<?php /*?>	<a class="btn-delete" href="/master_agent/powers/discharge_power"><span>Discharge Power/s <em>(<?= count( $sp ); ?> Power/s)</em></span></a>
<?php */?>
</p>