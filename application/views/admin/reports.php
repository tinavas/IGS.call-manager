		<div class="clearFix"></div>
		<div class="contentBody">
			<div class="contentTitle">Reports</div>
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
        			<form action="" method="post">
		        		<div class="frm_heading"><span>Enter Date Range</span></div>
		        		<div class="frm_inputs">
			        		<table class="form_tbl">
			        			<tr>
									<td>Start:</td>
									<td><input type="text" name="sdate" id="sdate" /></td>
								</tr>
								<tr>
									<td>End:</td>
									<td><input type="text" name="edate" id="edate" /></td>
								</tr>
								<tr>
									<td>Report Type:</td>
									<td><select name="rtype"><option value="1">Verification</option><option value="2">Manual Verification</option><option value="3">Quick Calls</option></select></td>
								</tr>
								<tr>
									<td></td>
									<td><input type="submit" name="search" id="search" value="Download" /></td>
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
	        </div>
	        <div class="clearFix"></div>
		</div>
		<script type="text/javascript">
		$(function() {
			$('#sdate').datetimepicker({ dateFormat: "yy-mm-dd" });
			$('#edate').datetimepicker({ dateFormat: "yy-mm-dd" });
		});
		</script>