<h3 class="tit">To accept this power, please press the "Accept Power Button"</h3>
<p>
You will be accepting this power for DEFENDANT
<strong><?= $power[ 'defendant_first_name' ] ?> <?= $power[ 'defendant_last_name' ]; ?></strong>
on this date: <strong><?= date( 'm/i/Y g:i A' ); ?></strong>.
<p class="box">
<a href="/jail/transmissions/process_accept/<?= $power[ 'power_id' ]; ?>" class="btn-create"><span>Accept Power</span></a>
<a href="/jail/transmissions/" class="btn-list"><span>Back to Listings</span></a>

</p>