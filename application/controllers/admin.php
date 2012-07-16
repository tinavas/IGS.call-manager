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
	
	/*
	 * recordings renamer
	 */
	function renamer() {
		//load helper
		$this->load->helper('file');
		
		//get all files
		$files = get_filenames('igs-recordings');
		
		//prompt array which contains all the messages
		$prompt = array();
		$prompt['rename'] = array();
		$prompt['not_found'] = array();
		$prompt['invalid'] = array();
		$prompt['error'] = array();

		if(!empty($files)) {
			//loop on all files
			foreach($files as $file) {
				//check if wav file was valid recording format
				if(preg_match("/([0-9]{8,})_([0-9]{10})_([0-9]{8}).wav/", $file)) {
					//get phone part
					$file_part = explode('_', $file);
					$phone = $file_part[0];
					
					//search phone in database
					$info = $this->Record_model->get_info($phone);
					if($info) {
						//check if sale
						$dispo = $info->disposition_id == 1 ? 'Sale':'NoSale';
						//get confirmation number
						$confirmation_no = $info->tpv_no;
						//get_date and convert it from MANILA to EST
						$date = date('YmdHi',strtotime($info->rdate)-43200);
						
						$new_filename = $dispo.'_'.$confirmation_no.'_'.$date;
						
						//rename
						$wav = getcwd().'\igs-recordings\\'.$file;
						$mp3 = getcwd().'\igs-recordings\\'.$new_filename.'.mp3';
						//rename($wav, $new_file);
						
						//convert from wav to mp3
						exec("C:/ffmpeg -i $wav -ar 22050 $mp3");
						//delete wav
						unlink($wav);
						
						array_push($prompt['rename'],$file);
					} else {
						//phone not found in database
						array_push($prompt['not_found'],$file);
					}
				} else {
					//invalid format
					array_push($prompt['invalid'],$file);
				}
			}	
		} else {
			//empty folder
			array_push($prompt['error'],'No files in folder');
		}
		
		//var_dump($prompt);		
		//load view
		$this -> load -> view('template/main', array('content' => 'admin/renamer', 'location' => 'Admin / Renamer'));
	}

}
