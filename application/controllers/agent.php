<?php
class Agent extends CI_Controller {

	/*
	 * Constructor
	 */
	public function Agent() {
		parent::__construct();

		//load model
		$this -> load -> model('Agent_model');
		$this -> load -> model('Record_model');
	}

	/*
	 * default page
	 */
	public function index() {
		//check if search button was pressed
		$this -> form_validation -> set_rules('phone', 'Phone', 'trim|required|numeric|xss_clean');

		if ($this -> form_validation -> run() == FALSE) {
			//load view
			$this -> load -> view('template/main', array('content' => 'agent/index', 'location' => 'Agent / Search', 'menu' => array('Logout' => 'user/logout', )));
		} else {
			$result = $this -> Record_model -> search($this -> input -> post('phone'));

			//load view with results
			$this -> load -> view('template/main', array('content' => 'agent/index', 'location' => 'Agent / Search', 'result' => $result, 'menu' => array('Logout' => 'login/logout', )));
		}
	}

	/*
	 * add record
	 */
	public function add() {

		//validation
		$this -> form_validation -> set_rules('user_name', 'User Name', 'trim|required|xss_clean');
		$this -> form_validation -> set_rules('phone', 'Phone Number', 'trim|required|xss_clean');
		$this -> form_validation -> set_rules('customer_name', 'Customer Name', 'trim|required|xss_clean');
		$this -> form_validation -> set_rules('account_no', 'Account Number', 'trim|required|xss_clean');
		$this -> form_validation -> set_rules('channel', 'Channel', 'trim|required|xss_clean');
		$this -> form_validation -> set_rules('state', 'State', 'trim|xss_clean');
		$this -> form_validation -> set_rules('disposition_id', 'Disposition', 'trim|xss_clean');
		$this -> form_validation -> set_rules('flag_id', 'Flag Reason', 'trim|xss_clean');
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

			//load view
			$this -> load -> view('template/main', array('content' => 'agent/add', 'location' => 'Agent / Add Record', 'dropdown' => array('channels' => $channels, 'channels_state' => $channels_state, 'dispositions' => $dispositions), 'menu' => array('Logout' => 'login/logout', )));
		} else {
			if (isset($_POST['submit_record'])) {
				//destroy submit_borrower from the POST array
				unset($_POST['submit_record']);
				//add borrower
				$insert_id = $this -> Record_model -> add($_POST);
				if ($insert_id) {
					$this -> session -> set_flashdata('prompt', '<div><span class="prompt">Record added.</span></div>');

					redirect('/agent/edit/' . $insert_id, 'refresh');
				}
			}
		}

	}

	/*
	 * edit record
	 */
	public function edit($phone = NULL) {

		//validation
		$this -> form_validation -> set_rules('user_name', 'User Name', 'trim|required|xss_clean');
		$this -> form_validation -> set_rules('phone', 'Phone Number', 'trim|required|xss_clean');
		$this -> form_validation -> set_rules('customer_name', 'Customer Name', 'trim|required|xss_clean');
		$this -> form_validation -> set_rules('account_no', 'Account Number', 'trim|required|xss_clean');
		$this -> form_validation -> set_rules('channel', 'Channel', 'trim|required|xss_clean');
		$this -> form_validation -> set_rules('state', 'State', 'trim|xss_clean');
		$this -> form_validation -> set_rules('disposition_id', 'Disposition', 'trim|xss_clean');
		$this -> form_validation -> set_rules('flag_id', 'Flag Reason', 'trim|xss_clean');
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
			//get existing record info
			$info = $this -> Record_model -> search($phone);

			//load view
			$this -> load -> view('template/main', array('content' => 'agent/edit', 'location' => 'Agent / Edit Record', 'dropdown' => array('channels' => $channels, 'channels_state' => $channels_state, 'dispositions' => $dispositions), 'record' => $info, 'menu' => array('Logout' => 'login/logout', )));
		} else {
			if (isset($_POST['submit_record'])) {
				//destroy submit_borrower from the POST array
				unset($_POST['submit_record']);
				//add borrower
				$phone = $this -> Record_model -> add($_POST);
				if ($phone) {
					$this -> session -> set_flashdata('prompt', '<div><span class="prompt">Record updated.</span></div>');

					redirect('/agent/edit/' . $phone, 'refresh');
				}
			}
		}

	}

}
