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
        			<?php echo $this->session->flashdata('prompt'); ?>
	        		<div class="frm_heading"><span>Basic Info</span></div>
	        		<div class="frm_inputs">
	        			<table class="info_view">
		        			<tr>
		        				<td>Agent:</td>
		        				<td><?php echo $this->session->userdata('IGS.username'); ?></td>
		        			</tr>
		        			<tr>
		        				<td>Phone Number:</td>
		        				<td><?php echo $record['phone']; ?></td>
		        			</tr>
		        			<tr>
		        				<td>Last Modified Date:</td>
		        				<td><?php echo $record['rdate']; ?></td>
		        			</tr>
		        			<tr>
		        				<td>Last Modified by:</td>
		        				<td><?php echo $record['user_name']; ?></td>
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
			        				<td><input type="text" name="customer_name" value="<?php echo $record['customer_name']; ?>" /></td>
			        			</tr>
			        			<tr>
			        				<td>Account Number:</td>
			        				<td><input type="text" name="account_no" value="<?php echo $record['account_no']; ?>" /></td>
			        			</tr>
			        			<tr>
			        				<td>Agent ID:</td>
			        				<td><input type="text" name="agent_id" value="<?php echo $record['agent_id']; ?>" /></td>
			        			</tr>
			        			<tr>
			        				<td>Promo Code:</td>
			        				<td><input type="text" name="promo_code" value="<?php echo $record['promo_code']; ?>" /></td>
			        			</tr>
			        			<!-- 
			        			<tr>
			        				<td>Channel:</td>
			        				<td><?php echo form_dropdown('channel',$dropdown['channels'],$record['channel'],'id="channel"'); ?></td>
			        			</tr>
			        			<tr>
			        				<td>State:</td>
			        				<td><input type="text" name="state" id="state" readonly="readonly" value="<?php echo $record['state']; ?>" /></td>
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
			        				<td><?php echo form_dropdown('disposition_id',$dropdown['dispositions'],$record['disposition_id']); ?></td>
			        			</tr>
			        			<tr>
			        				<td>Flag Reason:</td>
			        				<td><?php echo form_dropdown('flag_id',$dropdown['flags'],$record['flag_id'],'id="flag_id"'); ?></td>
			        			</tr>
			        			<tr id="flag_others">
			        				<td>Flag Others:</td>
			        				<td><input type="text" name="flag_others" value="<?php echo $record['flag_others']; ?>" /></td>
			        			</tr>
			        			<tr>
			        				<td>Market:</td>
			        				<td><?php echo form_dropdown('market_id',$dropdown['markets'],$record['market_id']); ?></td>
			        			</tr>
			        			<tr>
			        				<td>Confirmation # 1:</td>
			        				<td><input type="text" name="conf_1" value="<?php echo $record['conf_1']; ?>" /></td>
			        			</tr>
			        			<tr>
			        				<td>Confirmation # 2:</td>
			        				<td><input type="text" name="conf_2" value="<?php echo $record['conf_2']; ?>" /></td>
			        			</tr>
			        			<tr>
			        				<td>TPV Number:</td>
			        				<td><input type="text" name="tpv_no" value="<?php echo $record['tpv_no']; ?>" /></td>
			        			</tr>
			        			<tr>
			        				<td>Call Record ID:</td>
			        				<td><input type="text" name="call_record_id" value="<?php echo $record['call_record_id']; ?>" /></td>
			        			</tr>
			        			<tr>
			        				<td>Call Record ID 2:</td>
			        				<td><input type="text" name="call_record_id2" value="<?php echo $record['call_record_id2']; ?>" /></td>
			        			</tr>
			        			<tr>
			        				<td>Call Record ID 3:</td>
			        				<td><input type="text" name="call_record_id3" value="<?php echo $record['call_record_id3']; ?>" /></td>
			        			</tr>
			        			<tr>
			        				<td>Call Notes:</td>
			        				<td><textarea rows="4" cols="50" name="call_notes"><?php echo $record['call_notes']; ?></textarea></td>
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
		        		<input type="hidden" name="phone" value="<?php echo $record['phone']; ?>" />
	        		</div>
        		</form>
	        </div>
	        <div class="clearFix"></div>
		</div>
		<script type="text/javascript">
			function check_flag_reason(value) {
				if(value == 7) {
					$("#flag_others").show("fast", function() {
						$(this).effect("highlight", {}, 2000);
					});
				} else {
					$("#flag_others").hide("fast");
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