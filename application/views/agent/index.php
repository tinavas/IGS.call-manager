		<div class="clearFix"></div>
		<div class="contentBody">
			<div class="contentTitle">Search Record</div>
			<div class="clearFix"></div>
			<div class="leftcontentBody">
				<ul>
					<li><a href="<?php echo base_url().'agent'; ?>">Search</a></li>
					<li><a href="<?php echo base_url(); ?>user/logout">Logout</a></li>
				</ul>
	        </div>
	        <div class="rightcontentBody">
        		<div class="frm_container">
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
								<?php endif;?>
								<?php if (isset($error)) : ?>
								<tr>
									<td>
										
									</td>
									<td>
										<?php echo $error; ?>
									</td>
								</tr>
								<?php endif;?>
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
			        				<th>Date</th>
			        				<th>Action</th>
			        			</tr>
			        		</thead>
			        		<tbody>
			        			<tr>
				        			<td><?php echo $result['phone']; ?></td>
				        			<td><?php echo $result['user_name']; ?></td>
				        			<td><?php echo $result['rdate']; ?></td>
				        			<td><a href="<?php echo base_url().'agent/edit/'.$_POST['phone']; ?>">Modify</a></td>
			        			</tr>
			        		</tbody>
			        	</table>
	        		</div>
        		</div>
        			<?php else : ?>
        		<div class="frm_container">
	        		<div class="frm_heading"><span>Result - No record Found!</span></div>
	        		<div class="frm_inputs"></div>
        		</div>		
	        	<div class="manage_menu"><a href="<?php echo base_url().'agent/add/'.$_POST['phone']; ?>" class="button_add">Create new record</a></div>
        			<?php endif;?>
        		<?php endif;?>
        		<div class="clearFix"></div>
	        </div>
	        <div class="clearFix"></div>
		</div>