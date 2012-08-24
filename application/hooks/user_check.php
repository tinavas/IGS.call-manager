<?php
class User_check
{
	function is_login()
	{
		$CI = &get_instance();
		if ($CI->router->class == 'user' OR $CI->router->class == 'did')
			return TRUE;
		
		$sess_id = $CI->session->userdata('IGS.login');
		if ($sess_id !== 1) {
			show_error('You must <a href="'.base_url().'user/login/?url='.urlencode($_SERVER["REQUEST_URI"]).'">login</a> first to continue.', 500, $heading = 'Login First');
		}
	}
}