		<div class="clearFix"></div>
		<div class="contentBody">
			<div class="contentTitle">Add Record</div>
			<div class="clearFix"></div>
			<div class="leftcontentBody">
				<ul>
					<li><a href="<?php echo base_url().'agent'; ?>">Home</a></li>
					<li><a href="<?php echo base_url().'agent/manual'; ?>">Manual Verification</a></li>
					<li><a href="<?php echo base_url().'agent/scripts'; ?>">Scripts</a></li>
				</ul>
	        </div>
	        <div class="rightcontentBody">
	        	<?php if($record == FALSE) : ?>
	        		No record found.
	        	<?php else : ?>
	        	<form action="" method="post">
	        		<div class="frm_container">
		        		<div class="frm_heading"><span>Customer Info</span></div>
		        		<div class="frm_inputs">
		        			<table class="form_tbl">
		        				<tr>
			        				<td>Phone:</td>
			        				<td><input type="text" name="phone" value="<?php echo $record['phone']; ?>" /></td>
			        			</tr>
			        			<tr>
			        				<td>First Name:</td>
			        				<td><input type="text" name="first_name" value="<?php echo $record['first_name']; ?>" /></td>
			        			</tr>
			        			<tr>
			        				<td>Last Name:</td>
			        				<td><input type="text" name="last_name" value="<?php echo $record['last_name']; ?>" /></td>
			        			</tr>
			        			<tr>
			        				<td>Service Address:</td>
			        				<td><input type="text" name="service_address" value="<?php echo $record['service_address']; ?>" /></td>
			        			</tr>
			        			<tr>
			        				<td>Billing Address:</td>
			        				<td><input type="text" name="billing_address" value="<?php echo $record['billing_address']; ?>" /></td>
			        			</tr>
			        			<tr>
			        				<td>Service City:</td>
			        				<td><input type="text" name="service_city" value="<?php echo $record['service_city']; ?>" /></td>
			        			</tr>
			        			<tr>
			        				<td>State:</td>
			        				<td><input type="text" name="state" value="<?php echo $record['state']; ?>" /></td>
			        			</tr>
			        			<tr>
			        				<td>Zip Code:</td>
			        				<td><input type="text" name="zip_code" value="<?php echo $record['zip_code']; ?>" /></td>
			        			</tr>
			        			<tr>
			        				<td>Email:</td>
			        				<td><input type="text" name="email" value="<?php echo $record['email']; ?>" /></td>
			        			</tr>
			        		</table>
		        		</div>
	        		</div>
	        		<div class="frm_container">
		        		<div class="frm_heading"><span>Account Info</span></div>
		        		<div class="frm_inputs">
		        			<table class="form_tbl">
		        				<tr>
			        				<td>Sales Channel:</td>
			        				<td><input type="text" name="sales_channel" value="<?php echo $record['sales_channel']; ?>" /></td>
			        			</tr>
			        			<tr>
			        				<td>Gas Utility:</td>
			        				<td><input type="text" name="gas_utility" value="<?php echo $record['gas_utility']; ?>" /></td>
			        			</tr>
			        			<tr>
			        				<td>Electric Utility:</td>
			        				<td><input type="text" name="electric_utility" value="<?php echo $record['electric_utility']; ?>" /></td>
			        			</tr>
			        			<tr>
			        				<td>Residential/Commercial:</td>
			        				<td><input type="text" name="residential_commercial" value="<?php echo $record['residential_commercial']; ?>" /></td>
			        			</tr>
			        			<tr>
			        				<td>Rate and Term:</td>
			        				<td><input type="text" name="rate_term" value="<?php echo $record['rate_term']; ?>" /></td>
			        			</tr>
			        			<tr>
			        				<td>Account # /SDI # /POD #:</td>
			        				<td><input type="text" name="account_no" value="<?php echo $record['account_no']; ?>" /></td>
			        			</tr>
			        			<tr>
			        				<td>Confirmation #:</td>
			        				<td><input type="text" name="confirmation_no" value="<?php echo $record['confirmation_no']; ?>" /></td>
			        			</tr>
			        			<tr>
			        				<td>Promo Code:</td>
			        				<td><input type="text" name="promo_code" value="<?php echo $record['promo_code']; ?>" /></td>
			        			</tr>
			        			<tr>
			        				<td>Referral Code /Broker ID /Order ID:</td>
			        				<td><input type="text" name="referral_code" value="<?php echo $record['referral_code']; ?>" /></td>
			        			</tr>
			        			<tr>
			        				<td>Action/Follow-up:</td>
			        				<td>
			        					<textarea rows="4" cols="50" name="action" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" style="font: inherit; color: inherit; text-align: left; outline: medium none; cursor: text; background: none repeat scroll 0% 0% transparent; border-radius: 0px 0px 0px 0px;"><?php echo $record['action']; ?></textarea>
			        				</td>
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
	        		</div>
        		</form>
	        	<?php endif; ?>
	        </div>
	        <div class="clearFix"></div>
		</div>