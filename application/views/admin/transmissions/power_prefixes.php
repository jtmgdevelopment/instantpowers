<? if( ! count( $prefixes ) ): ?>
<div class="msg info">There are no power prefixes</div>
<? else: ?>
<table>
	<thead>
	<tr>
		<th>Power Prefix</th>
		<th>Power Amount</th>
		<th>Active</th>
	</tr>
	</thead>
	<tbody>
		<? foreach( $prefixes as $p ): ?>
			<tr>
				<td><?= $p[ 'prefix' ]; ?></td>
				<td><?= $p[ 'amount' ]; ?></td>
				<td>
					<?= $p['active'] ?>
				</td>
			</tr>
		<? endforeach; ?>
	</tbody>
</table>			
<? endif; ?>
<hr />
<h3>Add A Power Prefix</h3>
<?= form_open('/admin/transmissions/process_prefix_frm'); ?>
<section>
<fieldset>
	<legend>Credits Information</legend>
		<div class="col50">
		<?
		
			$opts = array(
				'name' 	=> 'prefix',
				'id'	=> 'prefix',
				'value'	=> set_value( 'prefix', 'BCIS' )
								
			);
			echo form_label('Power Prefix', 'prefix'); 
			echo form_input($opts);
		?>
		</div>
		<div class="col50">
		<?
		
			$opts = array(
				'name' 	=> 'amount',
				'id'	=> 'amount',
				'value'	=> set_value( 'amount', '$0.00' )
			);
			echo form_label('Power Amount', 'amount'); 
			echo form_input($opts);
		?>
		</div>
		<div class="clearfix"></div>

</fieldset>

<div class="t-right">
	<p>
		<input type="submit" class="white" value="Submit" />
		<button type="button" onClick="location.href = '/admin/manage_insurance/';"class="white">Cancel</button>
	</p>
</div>

</section>