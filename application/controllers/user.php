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
		//define validation rules
		$this -> form_validation -> set_rules('username', 'Username', 'trim|xss_clean|required');
		$this -> form_validation -> set_rules('password', 'Password', 'trim|xss_clean|required');

		//check if form is not submitted or validation returns an error
		if ($this -> form_validation -> run() == FALSE) {
			//load view
			$this -> load -> view('template/main', array('content' => 'user/login', 'location' => 'User / Login'));

		} else {
			$username = $this -> input -> post('username');
			$password = $this -> input -> post('password');
			
			//check if username/password do exist
			if($this -> check_login($username, $password)) {
				redirect('/agent/', 'refresh');
			} else {
				//throw an error if login failed
				$this -> load -> view('template/main', array('content' => 'user/login', 'location' => 'User / Login', 'error' => 'Invalid username/password'));
			}
		}

	}

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
			if($this -> do_register($username, $password)) {
				redirect('/user/login', 'refresh');
			} else {
				//throw an error when something goes wrong in saving username/password in database
				$this -> load -> view('template/main', array('content' => 'user/register', 'location' => 'User / Register', 'error' => 'Registration failed. Please try again.'));
			}
		}
	}

	/*
	 * callback validation.
	 * use to check if username already exist in the database
	 *
	 */
	function username_not_exist($username) {
		$this -> form_validation -> set_message('username_not_exist', 'That username is not available.');
		if ($this -> User_model -> check_username_exist($username)) {
			return FALSE;
		} else {
			return TRUE;
		}
	}

	/*
	 * hash password with salt
	 */
	private function _prep_password($password) {
		return crypt($password, $this -> config -> item('encryption_key'));
	}

	/*
	 * check login credentials
	 */
	private function check_login($username, $password) {

		$this -> db -> where('username', $username);
		$this -> db -> where('password', $this -> _prep_password($password));

		$query = $this -> db -> get('igs_users', 1);

		if ($query -> num_rows() == 1) {
			//set sessions
			$this->session->set_userdata('IGS.username', $username);
			$this->session->set_userdata('IGS.login', 1);
			
			return true;
		}

		return false;
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
	 * Logout 
	 */
	function logout()
	{
		$this->session->set_userdata('IGS.username', NULL);
		$this->session->set_userdata('IGS.login', NULL);
		
		redirect(base_url().'user', 'refresh');
	}

}
?>