		<div class="clearFix"></div>
		<div class="contentBody">
			<div class="contentTitle">Admin Page</div>
			<div class="clearFix"></div>
			<div class="leftcontentBody">
				<ul>
					<li><a href="<?php echo base_url().'admin/'; ?>">Home</a></li>
					<li><a href="<?php echo base_url().'admin/register'; ?>">Register User</a></li>
					<li><a href="<?php echo base_url().'admin/reports'; ?>">Reports</a></li>
					<li><a href="<?php echo base_url().'admin/stats'; ?>">Hourly Stats</a></li>
					<li><a href="<?php echo base_url().'admin/disposition'; ?>">Disposition</a></li>
					<li><a href="<?php echo base_url().'admin/renamer'; ?>">Renamer</a></li>
				</ul>
	        </div>
	        <div class="rightcontentBody">
        		<div class="frm_container">
        			<?php echo $this->session->flashdata('prompt'); ?>
		        	<form action="" method="post">
		        		<div class="frm_heading"><span>Search Record</span></div>
		        		<div class="frm_inputs">
			        		<table class="form_tbl">
			        			<tr>
									<td>Phone:</td>
									<td><input type="text" name="phone" value="<?php echo isset($_POST['phone']) ? $_POST['phone'] : ''; ?>" /></td>
								</tr>
								<tr>
									<td></td>
									<td><input type="submit" name="search" id="search" value="Search" /></td>
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
			        				<th class="{sorter: false}">Phone</th>
			        				<th>Agent</th>
			        				<th>Disposition</th>
			        				<th>Last Update Date (Manila)</th>
			        				<th>Action</th>
			        			</tr>
			        		</thead>
			        		<tbody>
			        			<?php foreach($result->result_array() as $info) : ?>
			        			<tr>
				        			<td><?php echo $info['phone']; ?></td>
				        			<td><?php echo $info['user_name']; ?></td>
				        			<td><?php echo $this -> Record_model -> get_disposition($info['disposition_id']); ?></td>
				        			<td><?php echo $info['rdate']; ?></td>
				        			<td><a href="<?php echo base_url() . 'admin/edit/' . $info['record_id']; ?>">Modify</a></td>
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
	        </div>
	        <div class="clearFix"></div>
		</div>