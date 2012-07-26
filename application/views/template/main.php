<?php 
	//initialization
	$location = isset($location) ? $location : NULL;
	$menu = isset($menu) ? $menu : array();
	$content = isset($content) ? $content : NULL;

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>IGS Call Manager</title>
<!-- Favicon -->
<link rel="shortcut icon" href="<?php echo base_url(); ?>fav.ico" />

<!-- General CSS -->
<link type="text/css" href="<?php echo base_url(); ?>styles/css/style.css" rel="stylesheet" />

<!-- jQuery -->
<script type="text/javascript" src="<?php echo base_url() ?>scripts/jquery/jquery-1.7.2-min.js"></script>

<!-- jQuery-UI -->
<link type="text/css" href="<?php echo base_url(); ?>styles/css/jquery-ui/jquery-ui-1.8.21.custom.css" rel="stylesheet" />
<script type="text/javascript" src="<?php echo base_url() ?>scripts/jquery/jquery-ui-1.8.21.custom.min.js"></script>

<!-- jQuery DateTime Picker -->
<script type="text/javascript" src="<?php echo base_url() ?>scripts/jquery/plugins/jquery-ui-timepicker-addon.js"></script>

<!-- Table Sorter -->
<link type="text/css" href="<?php echo base_url(); ?>styles/css/tablesorter/style.css" rel="stylesheet" />
<script type="text/javascript" src="<?php echo base_url() ?>scripts/jquery/plugins/jquery.tablesorter.min.js"></script>

<!-- Custom Scripts-->
<script>
	$(function() {
		$("input:submit").button();
		$('input:text, input:password').button().css({
			'font' : 'inherit',
			'color' : 'inherit',
			'text-align' : 'left',
			'outline' : 'none',
			'cursor' : 'text',
			'background' : 'none',
			'border-radius' : '0'
		});
	});
</script>
</head>
<body>
	<div id="content">
		<div id="contentHeader">
			<div style="width: 820px; margin-left: 200px;">
				<div id="nslogo"></div>
				<div id="appTitle">IGS Call Manager</div>
				<?php $this -> session -> userdata('IGS.username') ? $this->load->view('template/top-menu') : FALSE; //load top menus on user login ?>
			</div>
		</div>
		<div id="navMenu">
			<?php $this->load->view('template/location', array('location' => $location)); //load location ?>
		</div>
		
		<?php isset($data) ? $this->load->view($content, $data) : $this->load->view($content); //load page content ?>
		<div class="clearFix"></div>
		<div id="contentFooter">Copyright 2012. Northstar Solutions, Inc. All
			Rights Reserved.
		</div>
	</div>
</body>
</html>
