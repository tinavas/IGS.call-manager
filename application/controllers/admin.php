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
		
		//set maximum execution file to infinite
		ini_set('MAX_EXECUTION_TIME', -1);
	}

	/*
	 * default page
	 */
	public function index() {
		//check if search button was pressed
		$this -> form_validation -> set_rules('phone', 'Phone', 'trim|required|numeric|xss_clean');

		if ($this -> form_validation -> run() == FALSE) {
			$prev_records = $this -> Record_model -> get_records($this->session->userdata('IGS.username'));
			//load view
			$this -> load -> view('template/main', array('content' => 'admin/index', 'location' => 'Admin / Search', 'records' => $prev_records, 'menu' => array('Logout' => 'user/logout', )));
		} else {
			$result = $this -> Record_model -> search($this -> input -> post('phone'));
			//load view with results	
			$this -> load -> view('template/main', array('content' => 'admin/index', 'location' => 'Admin / Search', 'result' => $result, 'menu' => array('Logout' => 'login/logout', )));
		}
	}

	/*
	 * edit record
	 */
	public function edit($record_id = NULL) {

		//validation
		$this -> form_validation -> set_rules('user_name', 'User Name', 'trim|required|xss_clean');
		$this -> form_validation -> set_rules('phone', 'Phone Number', 'trim|required|xss_clean');
		$this -> form_validation -> set_rules('customer_name', 'Customer Name', 'trim|required|xss_clean');
		$this -> form_validation -> set_rules('account_no', 'Account Number', 'trim|required|xss_clean');
		$this -> form_validation -> set_rules('promo_code', 'Promo Code', 'trim|xss_clean');
		$this -> form_validation -> set_rules('channel', 'Channel', 'trim|xss_clean');
		$this -> form_validation -> set_rules('state', 'State', 'trim|xss_clean');
		$this -> form_validation -> set_rules('disposition_id', 'Disposition', 'trim|required|xss_clean');
		$this -> form_validation -> set_rules('flag_id', 'Flag Reason', 'trim|xss_clean');
		$this -> form_validation -> set_rules('flag_others', 'Flag Others', 'trim|xss_clean');
		$this -> form_validation -> set_rules('tpv_no', 'TPV Number', 'trim|xss_clean');
		$this -> form_validation -> set_rules('call_record_id', 'Call Record ID', 'trim|xss_clean');
		$this -> form_validation -> set_rules('call_notes', 'Call Notes', 'trim|xss_clean');

		if ($this -> form_validation -> run() == FALSE) {
			//change validation error delimiters
			$this -> form_validation -> set_error_delimiters('<div class="error">', '</div>');

			//get channels per utility
			$channels = $this -> Record_model -> get_channels();
			//get channels per state
			$channels_state = $this -> Record_model -> get_channels('state');
			//get dispositions
			$dispositions = $this -> Record_model -> get_dispositions();
			//get flag reasons
			$flags = $this -> Record_model -> get_flag_reasons();
			//get existing record info
			$info = $this -> Record_model -> search(NULL, array('record_id' => $record_id));

			//load view
			$this -> load -> view('template/main', array('content' => 'admin/edit', 'location' => 'Admin / Edit Record', 'dropdown' => array('channels' => $channels, 'channels_state' => $channels_state, 'dispositions' => $dispositions, 'flags' => $flags), 'record' => $info, 'menu' => array('Logout' => 'login/logout', )));
		} else {
			if (isset($_POST['submit_record'])) {
				//destroy submit_borrower from the POST array
				unset($_POST['submit_record']);
				//add borrower
				$return = $this -> Record_model -> update($record_id, $_POST);
				if ($return) {
					$this -> session -> set_flashdata('prompt', '<div><span class="prompt">Record updated.</span></div>');

					redirect('/admin/edit/' . $return, 'refresh');
				}
			}
		}

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
			$this -> load -> view('template/main', array('content' => 'admin/register', 'location' => 'User / Register'));
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
		//test if submit button is pressed
		if(isset($_POST['submit_rename'])) {
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
			$prompt['total'] = array();
	
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
							//check if disposed as sale and put in dispo part of filename
							$dispo = ($info->disposition_id == 1 OR $info->disposition_id == 3) ? 'Sale':'NoSale';
							
							if($dispo == 'Sale') {
								//get confirmation numbers and put in mid part of filename
								$conf_1 = strlen(trim($info->conf_1) > 0) ? $info->conf_1.'-':'';
								$conf_2 = strlen(trim($info->conf_2) > 0) ? $info->conf_2:'';
								$mid = $this->sanitize($conf_1.$conf_2);
							} else {
								//get phone number and put in mid part of filename
								$mid = $info->phone;
							}
							
							//get_date and convert it from MANILA to EST
							$date = date('YmdHi',strtotime($info->rdate)-43200);
							
							//generate new filename
							$new_filename = $dispo.'_'.$mid.'_'.$date;
							
							//get directory string
							$dir = getcwd().'\igs-recordings\\';
							
							//rename
							$wav = $dir.$file;
							$mp3 = $dir.$new_filename.'.mp3';
							
							//check if the new filename already exist
							$ii = 1;
							$file_name_temp = $mp3;
							while(file_exists($file_name_temp)) {
								//get again the non appended filename
								$file_name_temp = $dir.$new_filename;
								$file_name_temp .= '_'.++$ii.'.mp3';
							}
							$new_filename = $ii>1?$new_filename.'_'.$ii.'.mp3':$new_filename.'.mp3';
							
							//convert from wav to mp3
							exec("C:/ffmpeg -i $wav -ar 22050 $file_name_temp");
							//delete wav
							unlink($wav);
							
							array_push($prompt['rename'],$file. ' -> '.$new_filename);
						} else {
							//phone not found in database
							array_push($prompt['not_found'],$file);
						}
					} else {
						//invalid format
						array_push($prompt['invalid'],$file);
					}
					
					//push total files
					array_push($prompt['total'],$file);
				}	
			} else {
				//empty folder
				array_push($prompt['error'],'No files in folder');
			}
			
			
			//load view
			$this -> load -> view('template/main', array('content' => 'admin/renamer', 'result' => $prompt, 'location' => 'Admin / Renamer'));
		} else {
			//load view
			$this -> load -> view('template/main', array('content' => 'admin/renamer', 'location' => 'Admin / Renamer'));
		}
	}

	/**
	 * Function: sanitize
	 * Returns a sanitized string, typically for URLs.
	 *
	 * Parameters:
	 *     $string - The string to sanitize.
	 *     $force_lowercase - Force the string to lowercase?
	 *     $anal - If set to *true*, will remove all non-alphanumeric characters.
	 */
	private function sanitize($string, $force_lowercase = true, $anal = false) {
	    $strip = array("~", "`", "!", "@", "#", "$", "%", "^", "&", "*", "(", ")", "_", "=", "+", "[", "{", "]",
	                   "}", "\\", "|", ";", ":", "\"", "'", "&#8216;", "&#8217;", "&#8220;", "&#8221;", "&#8211;", "&#8212;",
	                   "—", "–", ",", "<", ".", ">", "/", "?");
	    $clean = trim(str_replace($strip, "", strip_tags($string)));
	    $clean = preg_replace('/\s+/', "-", $clean);
	    $clean = ($anal) ? preg_replace("/[^a-zA-Z0-9]/", "", $clean) : $clean ;
	    return ($force_lowercase) ?
	        (function_exists('mb_strtolower')) ?
	            mb_strtolower($clean, 'UTF-8') :
	            strtolower($clean) :
	        $clean;
	}


}
