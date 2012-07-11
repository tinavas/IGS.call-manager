		<div class="clearFix"></div>
		<div class="contentBody">
			<div class="contentTitle">Register User</div>
			<div class="clearFix"></div>
			<div class="leftcontentBody">
				<ul>
					<li><a href="<?php echo base_url().'admin/'; ?>">Home</a></li>
					<li><a href="<?php echo base_url().'admin/register'; ?>">Register User</a></li>
					<li><a href="<?php echo base_url().'admin/reports'; ?>">Reports</a></li>
					
				</ul>
	        </div>
	        <div class="rightcontentBody">
        		<div class="frm_container">
        			<form action="" method="post">
						<table width="100%" border="0" cellpadding="5">
							<tr>
								<td width="110">Username:</td>
								<td><input type="text" value="<?php echo isset($_POST['username']) ? $_POST['username'] : ''; ?>" name="username" /></td>
							</tr>
							<tr>
								<td>Password:</td>
								<td><input type="password" value="" name="password" /></td>
							</tr>
							<tr>
								<td>Password Confirm:</td>
								<td><input type="password" value="" name="password_conf" /></td>
							</tr>
							<tr>
								<td></td>
								<td><input type="submit" value="Submit" name="submit_register" /></td>
							</tr>
							<?php if (validation_errors()) :
							?>
							<tr>
								<td></td>
								<td><?php echo validation_errors(); ?></td>
							</tr>
							<?php endif; ?>
							<?php if (isset($error)) :
							?>
							<tr>
								<td></td>
								<td><?php echo $error; ?></td>
							</tr>
							<?php endif; ?>
						</table>
					</form>
        		</div>
	        </div>
	        <div class="clearFix"></div>
		</div>