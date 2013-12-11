<h3 class="tit">You can print this power below</h3>
<p class="box">
	<ul>
	<? foreach( explode( ',', $power->power ) as $p ): ?>

		<?
			$pdf = explode( "\\" , $p );
		?>
	
	
		<li><a href="/uploads/pdf/<?= end( $pdf ); ?>">Print PDF</a></li>
	
	<? endforeach; ?>
	</ul>

	<a class="btn" href="/jail/transmissions/pending_offline"><span>Return To Offline Powers</span></a>
</p>