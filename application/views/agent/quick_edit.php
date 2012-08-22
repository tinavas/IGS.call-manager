		<div class="clearFix"></div>
		<div class="contentBody">
			<div class="contentTitle">Add Record</div>
			<div class="clearFix"></div>
			<div class="leftcontentBody">
				<ul>
					<li><a href="<?php echo base_url().'agent'; ?>">Home</a></li>
					<li><a href="<?php echo base_url().'agent/manual'; ?>">Manual Verification</a></li>
					<li><a href="<?php echo base_url().'agent/scripts'; ?>">Scripts</a></li>
					<li><a href="<?php echo base_url().'agent/quick'; ?>">Quick Call</a></li>
				</ul>
	        </div>
	        <div class="rightcontentBody">
	        	<?php if($record == FALSE) : ?>
	        		No record found.
	        	<?php else : ?>
	        	<form action="" method="post">
	        		<div class="frm_container">
	        			<?php echo $this->session->flashdata('prompt'); ?>
		        		<div class="frm_heading"><span>Customer Info</span></div>
		        		<div class="frm_inputs">
		        			<table class="form_tbl">
		        				<tr>
			        				<td>Agent:</td>
			        				<td><input type="text" name="user_name" readonly="readonly" value="<?php echo $record['user_name']; ?>" /></td>
			        			</tr>
			        			<tr>
			        				<td>DID/TFN:</td>
			        				<td><input type="text" name="did" value="<?php echo $record['did']; ?>" /></td>
			        			</tr>
		        				<tr>
			        				<td>Call ID:</td>
			        				<td><input type="text" name="call_record_id" value="<?php echo $record['call_record_id']; ?>" /></td>
			        			</tr>
			        			<tr>
			        				<td>Disposition:</td>
			        				<td><?php echo form_dropdown('disposition_id',$dropdown['dispositions'],$record['disposition_id']); ?></td>
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
	        		</div>
        		</form>
	        	<?php endif; ?>
	        </div>
	        <div class="clearFix"></div>
		</div>