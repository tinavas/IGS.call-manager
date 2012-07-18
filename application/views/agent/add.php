		
		
		
		<div class="clearFix"></div>
		<div class="contentBody">
			<div class="contentTitle">Add Record</div>
			<div class="clearFix"></div>
			<div class="leftcontentBody">
				<ul>
					<li><a href="<?php echo base_url().'agent'; ?>">Search</a></li>
					
				</ul>
	        </div>
	        <div class="rightcontentBody">
        		<div class="frm_container">
	        		<div class="frm_heading"><span>Basic Info</span></div>
	        		<div class="frm_inputs">
	        			<table class="info_view">
		        			<tr>
		        				<td>Agent:</td>
		        				<td><?php echo $this->session->userdata('IGS.username'); ?></td>
		        			</tr>
		        			<tr>
		        				<td>Phone Number</td>
		        				<td><?php echo $this->uri->segment(3); ?></td>
		        			</tr>
		        		</table>
	        		</div>
        		</div>
	        	<form action="" method="post">
	        		<div class="frm_container">
		        		<div class="frm_heading"><span>Customer Info</span></div>
		        		<div class="frm_inputs">
		        			<table class="form_tbl">
			        			<tr>
			        				<td>Customer Name:</td>
			        				<td><input type="text" name="customer_name" value="<?php echo set_value('customer_name'); ?>" /></td>
			        			</tr>
			        			<tr>
			        				<td>Account Number:</td>
			        				<td><input type="text" name="account_no" value="<?php echo set_value('account_no'); ?>" /></td>
			        			</tr>
			        			<tr>
			        				<td>Agent ID:</td>
			        				<td><input type="text" name="agent_id" value="<?php echo set_value('agent_id'); ?>" /></td>
			        			</tr>
			        			<tr>
			        				<td>Promo Code:</td>
			        				<td><input type="text" name="promo_code" value="<?php echo set_value('promo_code'); ?>" /></td>
			        			</tr>
			        			<!-- 
			        			<tr>
			        				<td>Channel:</td>
			        				<td><?php echo form_dropdown('channel',$dropdown['channels'],set_value('channel'),'id="channel"'); ?></td>
			        			</tr>
			        			<tr>
			        				<td>State:</td>
			        				<td><input type="text" name="state" id="state" readonly="readonly" value="<?php echo set_value('state'); ?>" /></td>
			        			</tr>
			        			-->
			        		</table>
		        		</div>
	        		</div>
	        		<div class="frm_container">
		        		<div class="frm_heading"><span>Other Info</span></div>
		        		<div class="frm_inputs">
		        			<table class="form_tbl">
		        				<tr>
			        				<td>Disposition:</td>
			        				<td><?php echo form_dropdown('disposition_id',$dropdown['dispositions'],set_value('disposition_id')); ?></td>
			        			</tr>
			        			<tr>
			        				<td>Flag Reason:</td>
			        				<td><?php echo form_dropdown('flag_id',$dropdown['flags'],set_value('flag_id'),'id="flag_id"'); ?></td>
			        			</tr>
			        			<tr id="flag_others">
			        				<td>Flag Others:</td>
			        				<td><input type="text" name="flag_others" value="<?php echo set_value('flag_others'); ?>" /></td>
			        			</tr>
			        			<tr>
			        				<td>Confirmation # (electric):</td>
			        				<td><input type="text" name="conf_el" value="<?php echo set_value('conf_el'); ?>" /></td>
			        			</tr>
			        			<tr>
			        				<td>Confirmation # (gas):</td>
			        				<td><input type="text" name="conf_gas" value="<?php echo set_value('conf_gas'); ?>" /></td>
			        			</tr>
			        			<tr>
			        				<td>TPV Number:</td>
			        				<td><input type="text" name="tpv_no" value="<?php echo set_value('tpv_no'); ?>" /></td>
			        			</tr>
			        			<tr>
			        				<td>Call Record ID:</td>
			        				<td><input type="text" name="call_record_id" value="<?php echo set_value('call_record_id'); ?>" /></td>
			        			</tr>
			        			<tr>
			        				<td>Call Notes:</td>
			        				<td><textarea rows="4" cols="50" name="call_notes"><?php echo set_value('call_notes'); ?></textarea></td>
			        			</tr>
			        			<tr>
			        				<td></td>
			        				<td><input type="submit" name="submit_record" value="Submit" /></td>
			        			</tr>
			        			<?php if (validation_errors()) : ?>
								<tr>
									<td>
									</td>
									<td>
										<?php echo validation_errors(); ?>
									</td>
								</tr>
								<?php endif; ?>
			        		</table>
		        		</div>
	        		</div>
	        		<div>
		        		<input type="hidden" name="user_name" value="<?php echo $this->session->userdata('IGS.username'); ?>" />
		        		<input type="hidden" name="phone" value="<?php echo $this->uri->segment(3); ?>" />
	        		</div>
        		</form>
	        </div>
	        <div class="clearFix"></div>
		</div>
		<script type="text/javascript">
			function check_flag_reason(value) {
				if(value == 7) {
					$("#flag_others").show("slow", function() {
						$(this).effect("highlight", {}, 3000);
					});
				} else {
					$("#flag_others").hide("slow");
				}
				
			}
			
			init_flag_id = $("#flag_id").val();
			check_flag_reason(init_flag_id);
			
			$("#flag_id").change(function(){
				selected = $(this).val();
				check_flag_reason(selected);
			});
			
			
			$("#channel").change(function(){
				channels = <?php echo json_encode($dropdown['channels_state']); ?>;

				selected = $(this).val();
				
				$("#state").val(channels[selected]);
			});
		</script>