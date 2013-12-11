<h3 class="tit">Power Summary - Total Powers: <?= count( $sp ); ?></h3>
<p>Below you will find a summary of the power you just created. You have options available to you:</p>
<ol>
	<li><strong>Create a new power to be batch together with this power</strong></li>
	<li><strong>View Power/s and print power </strong></li>
	<li><strong>Save and Execute this power</strong></li>
	<li><strong>Discharge Powers/s</strong></li>
</ol>	
<p class="box">
	<a class="btn-create" href="/sub_agent/powers/batch_powers/<?= $trans_id; ?>/<?= $pek ?>"><span>Add Power <em>(Batch Multiple Powers)</em></span></a>
	<a class="btn-info" href="/sub_agent/powers/view_power/<?= $trans_id; ?>/<?= $pek ?>"><span>View/Print Power</em></span></a>
	<a class="btn-list" href="/sub_agent/powers/execute_power/<?= $trans_id; ?>/<?= $pek ?>"><span>Execute Power/s <em>(<?= count( $sp ); ?> Power/s)</em></span></a>
	<a class="btn-delete" href="/sub_agent/powers/cancel_power/<?= $trans_id; ?>/<?= $pek ?>"><span>Start Over</span></a>
	<br /><br clear="all" /><em class="red">*"<strong>Start Over Button</strong>" This will clear all data you have entered so far.</em>

<?php /*?>	<a class="btn-delete" href="/sub_agent/powers/discharge_power"><span>Discharge Power/s <em>(<?= count( $sp ); ?> Power/s)</em></span></a>
<?php */?>
</p>