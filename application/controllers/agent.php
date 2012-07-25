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
			$prev_records = $this -> Record_model -> get_records($this->session->userdata('IGS.username'));
			//load view
			$this -> load -> view('template/main', array('content' => 'agent/index', 'location' => 'Agent / Search', 'records' => $prev_records, 'menu' => array('Logout' => 'user/logout', )));
		} else {
			$result = $this -> Record_model -> search($this -> input -> post('phone'));
			$prev_records = $this -> Record_model -> get_records($this->session->userdata('IGS.username'));
			//load view with results	
			$this -> load -> view('template/main', array('content' => 'agent/index', 'location' => 'Agent / Search', 'result' => $result, 'records' => $prev_records, 'menu' => array('Logout' => 'login/logout', )));
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
		$this -> form_validation -> set_rules('promo_code', 'Promo Code', 'trim|xss_clean');
		$this -> form_validation -> set_rules('channel', 'Channel', 'trim|xss_clean');
		$this -> form_validation -> set_rules('state', 'State', 'trim|xss_clean');
		$this -> form_validation -> set_rules('disposition_id', 'Disposition', 'trim|required|xss_clean');
		$this -> form_validation -> set_rules('flag_id', 'Flag Reason', 'trim|xss_clean');
		$this -> form_validation -> set_rules('flag_others', 'Flag Others', 'trim|xss_clean');
		$this -> form_validation -> set_rules('tpv_no', 'TPV Number', 'trim|xss_clean');
		$this -> form_validation -> set_rules('call_record_id', 'Call Record ID', 'trim|xss_clean');
		$this -> form_validation -> set_rules('call_record_id2', 'Call Record ID 2', 'trim|xss_clean');
		$this -> form_validation -> set_rules('call_record_id3', 'Call Record ID 3', 'trim|xss_clean');
		$this -> form_validation -> set_rules('call_notes', 'Call Notes', 'trim|xss_clean');
		$this -> form_validation -> set_rules('market_id', 'Market', 'trim|xss_clean');

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
			//get markets
			$markets = $this -> Record_model -> get_markets();

			//load view
			$this -> load -> view('template/main', array('content' => 'agent/add', 'location' => 'Agent / Add Record', 'dropdown' => array('channels' => $channels, 'channels_state' => $channels_state, 'dispositions' => $dispositions, 'flags' => $flags, 'markets' => $markets), 'menu' => array('Logout' => 'login/logout', )));
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
		$this -> form_validation -> set_rules('call_record_id2', 'Call Record ID 2', 'trim|xss_clean');
		$this -> form_validation -> set_rules('call_record_id3', 'Call Record ID 3', 'trim|xss_clean');
		$this -> form_validation -> set_rules('call_notes', 'Call Notes', 'trim|xss_clean');
		$this -> form_validation -> set_rules('market_id', 'Market', 'trim|xss_clean');

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
			//get markets
			$markets = $this -> Record_model -> get_markets();
			
			//load view
			$this -> load -> view('template/main', array('content' => 'agent/edit', 'location' => 'Agent / Edit Record', 'dropdown' => array('channels' => $channels, 'channels_state' => $channels_state, 'dispositions' => $dispositions, 'flags' => $flags, 'markets' => $markets), 'record' => $info, 'menu' => array('Logout' => 'login/logout', )));
		} else {
			if (isset($_POST['submit_record'])) {
				//destroy submit_borrower from the POST array
				unset($_POST['submit_record']);
				//add borrower
				$id = $this -> Record_model -> add($_POST);
				if ($id) {
					$this -> session -> set_flashdata('prompt', '<div><span class="prompt">Record updated.</span></div>');

					redirect('/agent/edit/' . $id, 'refresh');
				}
			}
		}

	}

}
