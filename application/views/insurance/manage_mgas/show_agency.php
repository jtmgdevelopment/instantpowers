<h3 class="tit"><?= $agency->company_name; ?></h3>
<ul>
<li><?= $agency->full_name; ?></li>
<li><?= $agency->company_name; ?></li>
</ul>
<p class="box">
	<a class="btn-create" href="/insurance/manage_mgas/add_agency_to_insurance/<?= $agency->mek ?>"><span>Add Agency</span></a>
	<a class="btn" href="/insurance/manage_mgas/"><span>Cancel</span></a>
</p>