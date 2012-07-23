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
        			<form action="" method="post">
	        		<div class="frm_heading"><span>Rename Disposition</span></div>
	        		<div class="frm_inputs">
	        			<table class="form_tbl">
		        			<tr>
								<td><input type="text" name="disposition" value="<?php echo $this -> Record_model -> get_disposition($disposition_id); ?>" /></td>
								<td><input type="submit" name="update" value="Update" /><input type="submit" name="cancel" value="Cancel" /></td>
							</tr>
		        		</table>
	        		</div>
	        		</form>
        		</div>
	        </div>
	        <div class="clearFix"></div>
		</div>