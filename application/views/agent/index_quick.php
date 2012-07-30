		<div class="clearFix"></div>
		<div class="contentBody">
			<div class="contentTitle">Quick Call</div>
			<div class="clearFix"></div>
			<div class="leftcontentBody">
				<ul>
					<li><a href="<?php echo base_url() . 'agent'; ?>">Home</a></li>
					<li><a href="<?php echo base_url().'agent/manual'; ?>">Manual Verification</a></li>
					<li><a href="<?php echo base_url().'agent/scripts'; ?>">Scripts</a></li>
					<li><a href="<?php echo base_url().'agent/quick'; ?>">Quick Call</a></li>
				</ul>
	        </div>
	        <div class="rightcontentBody">
        		<div class="frm_container">
		        	<form action="" method="post">
		        		<div class="frm_heading"><span>Search Quick Call Record</span></div>
		        		<div class="frm_inputs">
			        		<table class="form_tbl">
			        			<tr>
									<td>Call ID:</td>
									<td><input type="text" name="callid" value="<?php echo isset($_POST['callid']) ? $_POST['callid'] : ''; ?>" /></td>
								</tr>
								<tr>
									<td></td>
									<td><input type="submit" name="search" id="search" value="Search" /> - <a href="<?php echo base_url(); ?>agent/quick/record" class="button">Add new record</a></td>
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
			        				<th>Call ID</th>
			        				<th>Disposition</th>
			        				<th>Agent</th>
			        				<th>Date (Manila)</th>
			        				<th>Action</th>
			        			</tr>
			        		</thead>
			        		<tbody>
			        			<?php foreach($result->result_array() as $info): ?>
			        			<tr>
				        			<td><?php echo $info['call_record_id']; ?></td>
				        			<td><?php echo $this -> Record_model -> get_disposition($info['disposition_id']); ?></td>
				        			<td><?php echo $info['user_name']; ?></td>
				        			<td><?php echo $info['rdate']; ?></td>
				        			<td><a href="<?php echo base_url() . 'agent/quick/record/' . $info['record_id']; ?>">Modify</a></td>
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
        		<?php if($records_quick) : ?>
        		<div class="frm_container">
	        		<div class="frm_heading"><span>Previous Quick Call Records</span></div>
	        		<div class="frm_inputs">
	        			<table class="tablesorter" cellspacing="1">
			        		<thead>
			        			<tr>
			        				<th>Call ID</th>
			        				<th>Disposition</th>
			        				<th>Agent</th>
			        				<th>Date (Manila)</th>
			        				<th>Action</th>
			        			</tr>
			        		</thead>
			        		<tbody>
			        			<?php foreach($records_quick->result_array() as $record): ?>
			        			<tr>
				        			<td><?php echo $record['call_record_id']; ?></td>
				        			<td><?php echo $this -> Record_model -> get_disposition($record['disposition_id']); ?></td>
				        			<td><?php echo $record['user_name']; ?></td>
				        			<td><?php echo $record['rdate']; ?></td>
				        			<td><a href="<?php echo base_url() . 'agent/quick/record/' . $record['record_id']; ?>">Modify</a></td>
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