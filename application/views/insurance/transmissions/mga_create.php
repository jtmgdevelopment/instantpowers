<?= form_open('/insurance/transmissions/mga_process_create_frm'); ?>
<?= form_hidden( 'agent_id', set_value( 'agent_id' ) ); ?>
<section>
	<fieldset>
		<legend>General Transmission Information</legend>	
		<div class="col50">
			<?
				if( ! isset( $agent ) )
				{
					echo form_label('MGA Agency', 'mga_agency'); 
					echo form_dropdown('mga_agency', $mga, set_value( 'mga_agency' ), 'id="mga_agency"');
				}
				else
				{
					echo form_label('MGA Agency', 'mga_agency'); 
					echo '<h4>' . $agent . '</h4>';
					echo form_hidden( 'mga_agency', $agent_id );
				}
			?>
		</div>
		<div class="col50">

			<?
				echo form_label('Transmission Expiration Date', 'exp_date'); 
				if( ! isset( $agent ) )
				{
					$opts = array(
						'name' 	=> 'exp_date',
						'id'	=> 'exp_date',
						'class'	=> 'datepicker',
						'value'	=> set_value('exp_date')
										
					);
					echo form_input($opts);					
				}		
				else
				{
					echo '<h4>' . $exp_date . '</h4>';
					echo form_hidden( 'exp_date', $exp_date );
					
				}
			?>


		</div>
		<div class="clearfix"></div>	
	</fieldset>
	<fieldset>
		<legend>Power information</legend>
		<div class="col50">
			<?
				$opts = array(
					'' => 'Select Prefix'				
				);
				echo form_label('Power Prefix', 'power_prefix'); 
				echo form_dropdown('power_prefix', $prefixes, set_value('power_prefix'), 'id="power_prefix"');
			?>
		</div>

		<div class="col50"> 
			<?
				$opts = array(
					'name' 	=> 'power_amount',
					'id'	=> 'power_amount',
					'value'	=> set_value('power_amount')
									
				);
				echo form_label('Power Span', 'power_amount'); 
				echo form_input($opts);
			?>
		</div>

	</fieldset>
	
	
	
	<div class="t-right">
		<p>
			<input type="submit" value="Submit" class="white" />
			<button type="button" class="white" onclick="window.location = '/insurance/transmissions/cancel';">Cancel</button>
		</p>
	</div>
</section>
</form>