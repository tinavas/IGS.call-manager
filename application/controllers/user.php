<?php
class User extends CI_Controller {

	/*
	 * Constructor
	 */
	public function User() {
		parent::__construct();

		//load model
		$this -> load -> model('User_model');
	}
	
	/*
	 * default redirection
	*/
	public function index() {
		redirect('/user/login', 'refresh');
	}

	/*
	 * load login interface page
	 */
	public function login() {
		//load view
		$this -> load -> view('template/main', array('content' => 'user/login', 'location' => 'User / Login'));
	}

}
?>