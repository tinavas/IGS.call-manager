<div class="clearFix"></div>
<div class="contentBody w400">
	<div class="contentTitle">
		Login
	</div>
	<div class="clearFix"></div>
	<div class="midcontentBody">
		<form action="" method="post">
			<table width="100%" border="0" cellpadding="5">
				<tr>
					<td width="10%"> Username: </td>
					<td width="80%">
					<input type="text" value="<?php echo isset($_POST['username']) ? $_POST['username'] : ''; ?>" name="username" />
					</td>
				</tr>
				<tr>
					<td> Password: </td>
					<td>
					<input type="password" value="" name="password" />
					</td>
				</tr>
				<tr>
					<td></td>
					<td>
					<input type="submit" value="Submit" name="submit_login" />
					</td>
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