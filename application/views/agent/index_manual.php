		<div class="clearFix"></div>
		<div class="contentBody">
			<div class="contentTitle">Home</div>
			<div class="clearFix"></div>
			<div class="leftcontentBody">
				<ul>
					<li><a href="<?php echo base_url() . 'agent'; ?>">Home</a></li>
					<li><a href="<?php echo base_url().'agent/manual'; ?>">Manual Verification</a></li>
					<li><a href="<?php echo base_url().'agent/scripts'; ?>">Scripts</a></li>
				</ul>
	        </div>
	        <div class="rightcontentBody">
        		<div class="frm_container">
		        	<form action="" method="post">
		        		<div class="frm_heading"><span>Search Manual Verification Record</span></div>
		        		<div class="frm_inputs">
			        		<table class="form_tbl">
			        			<tr>
									<td>Phone:</td>
									<td><input type="text" name="phone" value="<?php echo isset($_POST['phone']) ? $_POST['phone'] : ''; ?>" /></td>
								</tr>
								<tr>
									<td></td>
									<td><input type="submit" name="search" id="search" value="Search" /> - <a href="<?php echo base_url(); ?>agent/manual/record" class="button">Add new record</a></td>
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
								<?php if (isset($error)) : ?>
								<tr>
									<td>
										
									</td>
									<td>
										<?php echo $error; ?>
									</td>
								</tr>
								<?php endif; ?>
			        		</table>
		        		</div>
		        	</form>
        		</div>
        		<?php if(isset($result)) : ?>
        			<?php if($result) : ?>
        		<div class="frm_container">
	        		<div class="frm_heading"><span>Result - Record Found!</span></div>
	        		<div class="frm_inputs">
	        			<table class="tablesorter" cellspacing="1">
			        		<thead>
			        			<tr>
			        				<th>Phone</th>
			        				<th>Customer Name</th>
			        				<th>Agent</th>
			        				<th>Date (Manila)</th>
			        				<th>Action</th>
			        			</tr>
			        		</thead>
			        		<tbody>
			        			<?php foreach($result->result_array() as $info): ?>
			        			<tr>
				        			<td><?php echo $info['phone']; ?></td>
				        			<td><?php echo $info['first_name'].' '.$info['last_name']; ?></td>
				        			<td><?php echo $info['user_name']; ?></td>
				        			<td><?php echo $info['rdate']; ?></td>
				        			<td><a href="<?php echo base_url() . 'agent/manual/record/' . $info['record_id']; ?>">Modify</a></td>
			        			</tr>
			        			<?php endforeach; ?>
			        		</tbody>
			        	</table>
	        		</div>
        		</div>
        			<?php else : ?>
        		<div class="frm_container">
	        		<div class="frm_heading"><span>Result - No Record Found!</span></div>
	        		<div class="frm_inputs"></div>
        		</div>		
	        	<div class="clearFix"></div>
        			<?php endif; ?>
        		<?php endif; ?>
        		<div class="clearFix"></div>
        		<?php if($records_manual) : ?>
        		<div class="frm_container">
	        		<div class="frm_heading"><span>Previous Manual Verification Records</span></div>
	        		<div class="frm_inputs">
	        			<table class="tablesorter" cellspacing="1">
			        		<thead>
			        			<tr>
			        				<th>Phone</th>
			        				<th>Customer Name</th>
			        				<th>Agent</th>
			        				<th>Date (Manila)</th>
			        				<th>Action</th>
			        			</tr>
			        		</thead>
			        		<tbody>
			        			<?php foreach($records_manual->result_array() as $record): ?>
			        			<tr>
				        			<td><?php echo $record['phone']; ?></td>
				        			<td><?php echo $record['first_name'].' '.$record['last_name']; ?></td>
				        			<td><?php echo $record['user_name']; ?></td>
				        			<td><?php echo $record['rdate']; ?></td>
				        			<td><a href="<?php echo base_url() . 'agent/manual/record/' . $record['record_id']; ?>">Modify</a></td>
			        			</tr>
			        			<?php endforeach; ?>
			        		</tbody>
			        	</table>
	        		</div>
        		</div>
        		<?php else : ?>
        		<?php endif; ?>
        		<div class="clearFix"></div>
	        </div>
	        <div class="clearFix"></div>
		</div>