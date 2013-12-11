<h3 class="tit"><?= $agency->agency_name; ?></h3>
<ul>
<li><?= $agency->full_name; ?></li>
<li><?= $agency->agency_name; ?></li>
<li><?= $agency->license_number; ?></li>
</ul>
<p class="box">
	<a class="btn-create" href="/insurance/manage_agencies/add_agency_to_insurance/<?= $agency->mek ?>"><span>Add Agency</span></a>
	<a class="btn" href="/insurance/manage_agencies/"><span>Cancel</span></a>
</p>