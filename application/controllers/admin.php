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

	/*
	 * reports page
	 */
	public function reports() {
		//validate dates
		$this -> form_validation -> set_rules('sdate', 'Start Date', 'trim|required|xss_clean');
		$this -> form_validation -> set_rules('edate', 'End Date', 'trim|required|xss_clean');

		if ($this -> form_validation -> run() == FALSE) {
			//load view
			$this -> load -> view('template/main', array('content' => 'admin/reports', 'location' => 'Admin / Reports'));
		} else {
			$sdate = $this->input->post('sdate');
			$edate = $this->input->post('edate');
			$result = $this -> Admin_model -> report($sdate, $edate);

			//load view
			//$this -> load -> view('template/main', array('content' => 'admin/reports', 'location' => 'Admin / Reports'));
		}
		
	}
	
	/*
	 * register new user
	 */
	public function register() {
		//define validation rules
		$this -> form_validation -> set_rules('username', 'Username', 'trim|xss_clean|required|callback_username_not_exist');
		$this -> form_validation -> set_rules('password', 'Password', 'trim|xss_clean|required');
		$this -> form_validation -> set_rules('password_conf', 'Confirm Password', 'trim||xss_clean|required|matches[password]');

		//check if form is not submitted or validation returns an error
		if ($this -> form_validation -> run() == FALSE) {
			//load view
			$this -> load -> view('template/main', array('content' => 'user/register', 'location' => 'User / Register'));
		} else {
			$username = $this -> input -> post('username');
			$password = $this -> input -> post('password');

			//try to save username password on database
			if ($this -> do_register($username, $password)) {
				$this -> session -> set_flashdata('prompt', '<div><span class="prompt">Registration successful.</span></div>');
				
				redirect('/admin/', 'refresh');
			} else {
				//throw an error when something goes wrong in saving username/password in database
				$this -> load -> view('template/main', array('content' => 'admin/register', 'location' => 'Admin / Register', 'error' => 'Registration failed. Please try again.'));
			}
		}
	}

	/*
	 * register user and insert in database
	 */
	private function do_register($username, $password) {
		$data = array('username' => $username, 'password' => $this -> _prep_password($password));
		$insert = $this -> db -> insert('igs_users', $data);

		if ($insert) {
			return true;
		}

		return false;
	}

	/*
	 * hash password with salt
	 */
	private function _prep_password($password) {
		return crypt($password, $this -> config -> item('encryption_key'));
	}

}
