<h3 class="tit">Below you will find the powers in this batch</h3>

<ul>
	<? foreach( $powers as $i => $p ): ?>
	<li><a href="/agent/create_powers/execute/<?= $trans_id; ?>/<?= $power_id; ?>/true/<?= $i; ?>"><?= $p[ 'prefix_name' ] ?> <?= $p[ 'pek' ]; ?></a></li>
	<? endforeach; ?>
</ul>	
<p class="box">
	<a class="btn" href="/agent/create_powers/summary/<?= $trans_id; ?>/<?= $power_id; ?>"><span>Back</span></a>
</p>