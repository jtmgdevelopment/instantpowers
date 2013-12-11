<h3 class="tit">Are you sure you want to activate <?= $sub_agent->full_name; ?>? </h3>
<p class="box">
	<a href="/agent/manage_agents/process_deactivate/<?= $sub_agent->mek; ?>" class="btn-delete"><span>Deactivate <?= $sub_agent->full_name; ?></span></a>
	<a href="/agent/manage_agents" class="btn"><span>Cancel, and Go Back</span></a>
</p>