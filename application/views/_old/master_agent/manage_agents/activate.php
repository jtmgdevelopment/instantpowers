<h3 class="tit">Are you sure you want to deactivate <?= $sub_agent->full_name; ?>? </h3>
<p class="box">
	<a href="/master_agent/manage_agents/process_activate/<?= $sub_agent->mek; ?>" class="btn-create"><span>Activate <?= $sub_agent->full_name; ?></span></a>
	<a href="/master_agent/manage_agents" class="btn"><span>Cancel, and Go Back</span></a>
</p>