<?= form_open('/insurance/transmissions/process_create_frm'); ?>
<?= form_hidden( 'agent_id', set_value( 'agent_id' ) ); ?>
<section>
	<fieldset>
		<legend>General Transmission Information</legend>	
		<div class="col50">
			<?
				echo form_label('Bail Agency', 'bail_agency'); 
				if( ! isset( $agent ) )
				{
					$opts = array(
						'' => 'Select Bail Agency'				
					);
					echo form_dropdown('bail_agency', $agencies, set_value( 'bail_agency' ), 'id="bail_agency"');
					
				}
				else
				{
					echo '<h4>'  .  $agent->agency_name   .'</h4>';	
					echo form_hidden( 'bail_agency', $agent->bail_agency_id );
					
				}
			?>
		</div>
		<div class="col50">
			<?
				echo form_label('Bail Agent', 'bail_agent'); 
				if( ! isset( $agent ) )
				{	
					$opts = array(
						'name' 		=> 'agent',
						'id'		=> 'agent',
						'value'		=> 'Select Bail Agency First',
						'disabled'	=> 'true',
						'style'		=> 'background:#fff;border:none;border-radius:0px; font-size:16px; font-weight:bold; color:black; border-top:1px solid;'				
					);
					
					echo form_input( $opts );			
				}
				else
				{
					echo '<h4>'  .  $agent->full_name   . '</h4>';	
					echo form_hidden( 'agent_id', $agent->mek );
				}
			?>
		</div>
		<div class="clearfix"></div>
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
		<? /*
		<div class="clearfix"></div>
		<div class="col50"> 
			<?
				$opts = array(
					'name' 	=> 'power_start',
					'id'	=> 'power_start',
					'value'	=> set_value('power_start')
									
				);
				echo form_label('Power Start', 'power_start'); 
				echo form_input($opts);
			?>
		</div>
		<div class="col50"> 
			<?
				$opts = array(
					'name' 	=> 'power_end',
					'id'	=> 'power_end',
					'value'	=> set_value('power_end')
									
				);
				echo form_label('Power End', 'power_end'); 
				echo form_input($opts);
			?>
		</div>
		*/ ?>
	</fieldset>
	
	
	
	<div class="t-right">
		<p>
			<input type="submit" value="Submit" class="white" />
			<button type="button" class="white" onclick="window.location = '/insurance/transmissions/cancel';">Cancel</button>
		</p>
	</div>
</section>
</form>