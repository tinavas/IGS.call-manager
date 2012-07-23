		<div class="clearFix"></div>
		<div class="contentBody">
			<div class="contentTitle">Disposition Management</div>
			<div class="clearFix"></div>
			<div class="leftcontentBody">
				<ul>
					<li><a href="<?php echo base_url().'admin/'; ?>">Home</a></li>
					<li><a href="<?php echo base_url().'admin/register'; ?>">Register User</a></li>
					<li><a href="<?php echo base_url().'admin/reports'; ?>">Reports</a></li>
					<li><a href="<?php echo base_url().'admin/renamer'; ?>">Renamer</a></li>
				</ul>
	        </div>
	        <div class="rightcontentBody">
        		<div class="frm_container">
	        		<div class="frm_heading"><span>Dispositions</span></div>
	        		<div class="frm_inputs">
	        			<table class="tablesorter" cellspacing="1" style="width: 450px;">
			        		<thead>
			        			<tr>
			        				<th>Dispositions</th>
			        				<th>Active</th>
			        				<th>Action</th>
			        			</tr>
			        		</thead>
			        		<tbody>
			        			<?php foreach($dispositions as $disposition_id=>$info) : ?>
			        			<tr>
				        			<td><?php echo $info['label']; ?></td>
				        			<td><?php echo $info['active'] == 1 ? 'Yes' : 'No'; ?></td>
				        			<td><?php echo $info['active'] == 1 ? '<a href="'.base_url().'admin/disposition/deactivate/'.$disposition_id.'">deactivate</a>' : '<a href="'.base_url().'admin/disposition/activate/'.$disposition_id.'">activate</a>'; ?> | <a href="<?php echo base_url(); ?>admin/disposition/rename/<?php echo $disposition_id; ?>">rename</a> | <a href="<?php echo base_url(); ?>admin/disposition/add/">add</a></td>
			        			</tr>
			        			<?php endforeach; ?>
			        		</tbody>
			        	</table>
	        		</div>
        		</div>
	        </div>
	        <div class="clearFix"></div>
		</div>