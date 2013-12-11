<? if( count( $premiums) ): ?>
	
	
	<h3 class="tit">Below you will find <?= $agent->full_name; ?> Premiums for this transmitting company</h3>	
	
	<p><strong>Premium:</strong> <?= $premiums[0][ 'premium' ]; ?>, <strong>BUF:</strong> <?= $premiums[0][ 'buf' ]; ?></p>

	<p class="box">
		<a href="/agent/manage_agents/edit_premiums/<?= $agent->mek; ?>/<?= $premiums[0][ 'premium_id' ]?>/<?= $vars[ 'transmitter_id' ]; ?>" class="btn"><span>Edit Premium</span></a>
		<a href="/agent/manage_agents" class="btn"><span>Cancel</span></a>
	</p>
	
<? else: ?>

<div class="msg info"><p><?= $agent->full_name; ?> does not have premiums with this Transmitting Company</p></div>

<p class="box">
	<a href="/agent/manage_agents/add_premiums/<?= $agent->mek; ?>/<?= $vars[ 'transmitter_id' ]; ?>"  class="btn"><span>Add Premium</span></a>
	<a href="/agent/manage_agents" class="btn"><span>Cancel</span></a>
</p>

<? endif; ?>