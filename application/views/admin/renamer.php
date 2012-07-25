		<div class="clearFix"></div>
		<div class="contentBody">
			<div class="contentTitle">Renamer</div>
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
									<td><input type="text" name="sdate" id="sdate" value="<?php echo isset($_POST['sdate'])?$_POST['sdate']:''; ?>" /></td>
								</tr>
								<tr>
									<td>End:</td>
									<td><input type="text" name="edate" id="edate" value="<?php echo isset($_POST['edate'])?$_POST['edate']:''; ?>"/></td>
								</tr>
								<tr>
									<td></td>
									<td><input type="submit" value="Rename" name="submit_rename" /> (Press to start renaming)</td>
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
							</table>
						</div>
					</form>
        		</div>
        		<?php if(isset($result)) : ?>
        		<div class="frm_container">
	        		<div class="frm_heading"><span>Result</span></div>
	        		<div class="frm_inputs">
	        			<?php if(count($result['error']) > 0): ?>
	        				<?php foreach($result['error'] as $error): ?>
    							<?php echo $error;?>
    						<?php endforeach;?>
	        			<?php else: ?>
	        			<div id="result">
	        				<div class="sub_result">
	        					<div class="total_result">Total Files: <strong><?php echo count($result['total']); ?></strong></div>
	        					<div class="files_result">
	        						<ul>
	        						<?php foreach($result['total'] as $file): ?>
	        							<li><?php echo $file;?></li>
	        						<?php endforeach;?>
	        						</ul>
	        					</div>
	        				</div>
	        				<div class="sub_result">
	        					<div class="total_result">Renamed Files: <strong><?php echo count($result['rename']); ?></strong></div>
	        					<div class="files_result">
	        						<ul>
	        						<?php foreach($result['rename'] as $file): ?>
	        							<li><?php echo $file;?></li>
	        						<?php endforeach;?>
	        						</ul>
	        					</div>
	        				</div>
	        				<div class="sub_result">
	        					<div class="total_result">Invalid Files: <strong><?php echo count($result['invalid']); ?></strong></div>
	        					<div class="files_result">
	        						<ul>
	        						<?php foreach($result['invalid'] as $file): ?>
	        							<li><?php echo $file;?></li>
	        						<?php endforeach;?>
	        						</ul>
	        					</div>
	        				</div>
	        				<div class="sub_result">
	        					<div class="total_result">Not Found in Call Manager: <strong><?php echo count($result['not_found']); ?></strong></div>
	        					<div class="files_result">
	        						<ul>
	        						<?php foreach($result['not_found'] as $file): ?>
	        							<li><?php echo $file;?></li>
	        						<?php endforeach;?>
	        						</ul>
	        					</div>
	        				</div>
	        			</div>
	        			<?php endif; ?>
	        		</div>
        		</div>
        		<?php endif; ?>
	        </div>
	        <div class="clearFix"></div>
		</div>
		<script type="text/javascript">
		$(function() {
			$('.total_result').click(function()
		  	{
		    	$(this).parent().children('.files_result').slideToggle(600);
		  	});
		  	
		  	$('#sdate').datetimepicker({ dateFormat: "yy-mm-dd" });
			$('#edate').datetimepicker({ dateFormat: "yy-mm-dd" });
		});
		</script>