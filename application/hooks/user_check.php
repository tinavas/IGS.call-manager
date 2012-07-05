<?php
class User_check
{
	function is_login()
	{
		$CI = &get_instance();
		if ($CI->router->class == 'user')
			return TRUE;
		
		$sess_id = $CI->session->userdata('lend_user');
		if (!$sess_id) {
			show_error('You must <a href="'.base_url().'user/login/?url='.urlencode($_SERVER["REQUEST_URI"]).'">login</a> first to continue.', 500, $heading = 'Login First');
		}
	}
}