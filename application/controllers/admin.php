<?php
class Admin extends CI_Controller {

	/*
	 * Constructor
	 */
	public function Admin() {
		parent::__construct();

		//load model
		$this -> load -> model('Admin_model');
		$this -> load -> model('Record_model');
	}

	/*
	 * default page
	 */
	public function index() {
		//load view
			$this -> load -> view('template/main', array('content' => 'admin/index', 'location' => 'Admin'));
	}

}
