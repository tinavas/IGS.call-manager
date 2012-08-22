<?php
class Agent extends CI_Controller {

	/*
	 * Constructor
	 */
	public function Agent() {
		parent::__construct();
		
		if($this -> session -> userdata('IGS.user_type') == 1) {
			
		} elseif($this -> session -> userdata('IGS.user_type') == 9) {
			//redirect if not agent
			redirect('/admin/');
		}
		
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
			$prev_records = $this -> Record_model -> get_records($this -> session -> userdata('IGS.username'));
			//load view
			$this -> load -> view('template/main', array('content' => 'agent/index', 'location' => 'Agent / Home', 'records' => $prev_records, 'menu' => array('Logout' => 'user/logout', )));
		} else {
			$result = $this -> Record_model -> search($this -> input -> post('phone'));
			$prev_records = $this -> Record_model -> get_records($this -> session -> userdata('IGS.username'));
			//load view with results
			$this -> load -> view('template/main', array('content' => 'agent/index', 'location' => 'Agent / Home', 'result' => $result, 'records' => $prev_records, 'menu' => array('Logout' => 'login/logout', )));
		}
	}

	/*
	 * add record
	 */
	public function add() {

		//validation
		if($this->input->post('disposition_id') == 24 OR $this->input->post('disposition_id') == 2) {
			$this -> form_validation -> set_rules('sub_disposition_id', 'Sub-Disposition', 'trim|required|xss_clean');
		} else {
			$this -> form_validation -> set_rules('sub_disposition_id', 'Sub-Disposition', 'trim|xss_clean');
		}

		if($this->input->post('flag_id') == 7) {
			$this -> form_validation -> set_rules('flag_others', 'Flag Others', 'trim|required|xss_clean');
		} else {
			$this -> form_validation -> set_rules('flag_others', 'Flag Others', 'trim|xss_clean');
		}
		
		$this -> form_validation -> set_rules('user_name', 'User Name', 'trim|required|xss_clean');
		$this -> form_validation -> set_rules('phone', 'Phone Number', 'trim|required|xss_clean');
		$this -> form_validation -> set_rules('customer_name', 'Customer Name', 'trim|required|xss_clean');
		$this -> form_validation -> set_rules('account_no', 'Account Number', 'trim|required|xss_clean');
		$this -> form_validation -> set_rules('promo_code', 'Promo Code', 'trim|xss_clean');
		$this -> form_validation -> set_rules('channel', 'Channel', 'trim|xss_clean');
		$this -> form_validation -> set_rules('state', 'State', 'trim|xss_clean');
		$this -> form_validation -> set_rules('disposition_id', 'Disposition', 'trim|required|xss_clean');
		//$this -> form_validation -> set_rules('sub_disposition_id', 'Sub-Disposition', 'trim|xss_clean');
		$this -> form_validation -> set_rules('flag_id', 'Flag Reason', 'trim|xss_clean');
		//$this -> form_validation -> set_rules('flag_others', 'Flag Others', 'trim|xss_clean');
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
			//get dispositions/sub-dispositions
			$dispositions = $this -> Record_model -> get_dispositions(array('active' => 1, 'sub' => 0));
			$dispo_filter = array('' => '');
			foreach($dispositions as $data) {
				$dispo_filter += array($data['disposition_id'] => $data['label']);
			}
			$sub_dispositions_24 = $this -> Record_model -> get_dispositions(array('active' => 1, 'sub' => 1, 'sub_dispo_id' => 24));
			$sub_dispo_filter_24 = array('' => '');
			foreach($sub_dispositions_24 as $data) {
				$sub_dispo_filter_24 += array($data['disposition_id'] => $data['label']);
			}
			$sub_dispositions_2 = $this -> Record_model -> get_dispositions(array('active' => 1, 'sub' => 1, 'sub_dispo_id' => 2));
			$sub_dispo_filter_2 = array('' => '');
			foreach($sub_dispositions_2 as $data) {
				$sub_dispo_filter_2 += array($data['disposition_id'] => $data['label']);
			}
			//get flag reasons
			$flags = $this -> Record_model -> get_flag_reasons();
			//get markets
			$markets = $this -> Record_model -> get_markets();

			//load view
			$this -> load -> view('template/main', array('content' => 'agent/add', 'location' => 'Agent / Add Record', 'dropdown' => array('channels' => $channels, 'channels_state' => $channels_state, 'dispositions' => $dispo_filter, 'sub_dispositions_24' => $sub_dispo_filter_24, 'sub_dispositions_2' => $sub_dispo_filter_2, 'flags' => $flags, 'markets' => $markets), 'menu' => array('Logout' => 'login/logout', )));
		} else {
			if (isset($_POST['submit_record'])) {
				//destroy submit_borrower or sub_disposition_id_not_selected from the POST array
				unset($_POST['submit_record']);
				unset($_POST['sub_disposition_id_not_selected']);
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
		if($this->input->post('disposition_id') == 24 OR $this->input->post('disposition_id') == 2) {
			$this -> form_validation -> set_rules('sub_disposition_id', 'Sub-Disposition', 'trim|required|xss_clean');
		} else {
			$this -> form_validation -> set_rules('sub_disposition_id', 'Sub-Disposition', 'trim|xss_clean');
		}

		if($this->input->post('flag_id') == 7) {
			$this -> form_validation -> set_rules('flag_others', 'Flag Others', 'trim|required|xss_clean');
		} else {
			$this -> form_validation -> set_rules('flag_others', 'Flag Others', 'trim|xss_clean');
		}
		
		$this -> form_validation -> set_rules('user_name', 'User Name', 'trim|required|xss_clean');
		$this -> form_validation -> set_rules('phone', 'Phone Number', 'trim|required|xss_clean');
		$this -> form_validation -> set_rules('customer_name', 'Customer Name', 'trim|required|xss_clean');
		$this -> form_validation -> set_rules('account_no', 'Account Number', 'trim|required|xss_clean');
		$this -> form_validation -> set_rules('promo_code', 'Promo Code', 'trim|xss_clean');
		$this -> form_validation -> set_rules('channel', 'Channel', 'trim|xss_clean');
		$this -> form_validation -> set_rules('state', 'State', 'trim|xss_clean');
		$this -> form_validation -> set_rules('disposition_id', 'Disposition', 'trim|required|xss_clean');
		//$this -> form_validation -> set_rules('sub_disposition_id', 'Sub-Disposition', 'trim|xss_clean');
		$this -> form_validation -> set_rules('flag_id', 'Flag Reason', 'trim|xss_clean');
		//$this -> form_validation -> set_rules('flag_others', 'Flag Others', 'trim|xss_clean');
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
			$dispositions = $this -> Record_model -> get_dispositions(array('active' => 1, 'sub' => 0));
			$dispo_filter = array('' => '');
			foreach($dispositions as $data) {
				$dispo_filter += array($data['disposition_id'] => $data['label']);
			}
			$sub_dispositions_24 = $this -> Record_model -> get_dispositions(array('active' => 1, 'sub' => 1, 'sub_dispo_id' => 24));
			$sub_dispo_filter_24 = array('' => '');
			foreach($sub_dispositions_24 as $data) {
				$sub_dispo_filter_24 += array($data['disposition_id'] => $data['label']);
			}
			$sub_dispositions_2 = $this -> Record_model -> get_dispositions(array('active' => 1, 'sub' => 1, 'sub_dispo_id' => 2));
			$sub_dispo_filter_2 = array('' => '');
			foreach($sub_dispositions_2 as $data) {
				$sub_dispo_filter_2 += array($data['disposition_id'] => $data['label']);
			}
			//get flag reasons
			$flags = $this -> Record_model -> get_flag_reasons();
			//get existing record info
			$info = $this -> Record_model -> search(NULL, array('record_id' => $record_id));
			//get markets
			$markets = $this -> Record_model -> get_markets();

			//load view
			$this -> load -> view('template/main', array('content' => 'agent/edit', 'location' => 'Agent / Edit Record', 'dropdown' => array('channels' => $channels, 'channels_state' => $channels_state, 'dispositions' => $dispo_filter, 'sub_dispositions_24' => $sub_dispo_filter_24, 'sub_dispositions_2' => $sub_dispo_filter_2, 'flags' => $flags, 'markets' => $markets), 'record' => $info, 'menu' => array('Logout' => 'login/logout', )));
		} else {
			if (isset($_POST['submit_record'])) {
				//destroy submit_borrower or sub_disposition_id_not_selected from the POST array
				unset($_POST['submit_record']);
				unset($_POST['sub_disposition_id_not_selected']);
				//add record
				$id = $this -> Record_model -> add($_POST);
				
				if ($id) {
					$this -> session -> set_flashdata('prompt', '<div><span class="prompt">Record updated.</span></div>');

					redirect('/agent/edit/' . $id, 'refresh');
				}
			}
		}
	}

	public function manual($action = 'home', $record_id = NULL) {

		//check what type of action perform
		if ($action == 'home') {
			//validation
			$this -> form_validation -> set_rules('phone', 'Phone', 'trim|required|xss_clean');
			if ($this -> form_validation -> run() == FALSE) {
				$prev_records_manual = $this -> Record_model -> get_records_manual($this -> session -> userdata('IGS.username'));
				$this -> load -> view('template/main', array('content' => 'agent/index_manual', 'records_manual' => $prev_records_manual, 'location' => 'Agent / Home'));
			} else {
				$result = $this -> Record_model -> search_manual($this -> input -> post('phone'), $this -> session -> userdata('IGS.username'));
				$prev_records_manual = $this -> Record_model -> get_records_manual($this -> session -> userdata('IGS.username'));
				//load view with results
				$this -> load -> view('template/main', array('content' => 'agent/index_manual', 'location' => 'Agent / Home', 'result' => $result, 'records_manual' => $prev_records_manual));
			}
		} elseif ($action == 'record') {
			//validation
			$this -> form_validation -> set_rules('phone', 'Phone', 'trim|required|xss_clean');
			$this -> form_validation -> set_rules('first_name', 'First Name', 'trim|required|xss_clean');
			$this -> form_validation -> set_rules('last_name', 'Last Name', 'trim|required|xss_clean');
			$this -> form_validation -> set_rules('service_address', 'Service Address', 'trim|xss_clean');
			$this -> form_validation -> set_rules('billing_address', 'Billing Address', 'trim|xss_clean');
			$this -> form_validation -> set_rules('service_city', 'Service City', 'trim|xss_clean');
			$this -> form_validation -> set_rules('state', 'State', 'trim|xss_clean');
			$this -> form_validation -> set_rules('zip_code', 'Zip Code', 'trim|xss_clean');
			$this -> form_validation -> set_rules('email', 'Email', 'trim|xss_clean');
			$this -> form_validation -> set_rules('sales_channel', 'Sales Channel', 'trim|xss_clean');
			$this -> form_validation -> set_rules('gas_utility', 'Gas Utility', 'trim|xss_clean');
			$this -> form_validation -> set_rules('electric_utility', 'Electric Utility', 'trim|xss_clean');
			$this -> form_validation -> set_rules('residential_commercial', 'Residential/Commercial', 'trim|xss_clean');
			$this -> form_validation -> set_rules('rate_term', 'Rate And Term', 'trim|xss_clean');
			$this -> form_validation -> set_rules('account_no', 'Account # /SDI # /POD #', 'trim|xss_clean');
			$this -> form_validation -> set_rules('confirmation_no', 'Confirmation #', 'trim|xss_clean');
			$this -> form_validation -> set_rules('promo_code', 'Promo Code', 'trim|xss_clean');
			$this -> form_validation -> set_rules('referral_code', 'Referral Code /Broker ID /Order ID', 'trim|xss_clean');
			$this -> form_validation -> set_rules('action', 'Action/Follow-up', 'trim|xss_clean');

			if ($this -> form_validation -> run() == FALSE) {
				//change validation error delimiters
				$this -> form_validation -> set_error_delimiters('<div class="error">', '</div>');

				//get info if record_id was given
				if ($record_id != NULL) {
					$info = $this -> Record_model -> get_info_manual($record_id);
					//load view
					$this -> load -> view('template/main', array('content' => 'agent/manual_edit', 'location' => 'Agent / Manual Verification', 'record' => $info));
				} else {
					//load view
					$this -> load -> view('template/main', array('content' => 'agent/manual_add', 'location' => 'Agent / Manual Verification'));
				}
			} else {
				if (isset($_POST['submit_record'])) {
					//destroy submit_record from the POST array
					unset($_POST['submit_record']);
					//add/update record
					$id = $record_id != NULL ? $this -> Record_model -> update_manual($record_id, $_POST) : $this -> Record_model -> add_manual($_POST);
					if ($id) {
						$this -> session -> set_flashdata('prompt', '<div><span class="prompt">Record updated.</span></div>');

						redirect('/agent/manual/record/' . $id, 'refresh');
					}
				}
			}
		}
	}

	/*
	 * Show list of scripts for manual verification
	*/
	public function scripts() {
		//load view
		$this -> load -> view('template/main', array('content' => 'agent/scripts', 'location' => 'Agent / Scripts'));
	}

	/*
	 * Show list of scripts for manual verification
	*/
	public function quick($action = 'home', $record_id = NULL) {

		//check what type of action perform
		if ($action == 'home') {
			//validation
			$this -> form_validation -> set_rules('callid', 'Call ID', 'trim|required|xss_clean');
			if ($this -> form_validation -> run() == FALSE) {
				$prev_records_quick = $this -> Record_model -> get_records_quick($this -> session -> userdata('IGS.username'));
				$this -> load -> view('template/main', array('content' => 'agent/index_quick', 'records_quick' => $prev_records_quick, 'location' => 'Agent / Quick Call'));
			} else {
				$result = $this -> Record_model -> search_quick($this -> input -> post('callid'), $this -> session -> userdata('IGS.username'));
				$prev_records_quick = $this -> Record_model -> get_records_quick($this -> session -> userdata('IGS.username'));
				//load view with results
				$this -> load -> view('template/main', array('content' => 'agent/index_quick', 'location' => 'Agent / Home', 'result' => $result, 'records_quick' => $prev_records_quick));
			}
		} elseif ($action == 'record') {
			//validation
			$this -> form_validation -> set_rules('user_name', 'Agent', 'trim|required|xss_clean');
			$this -> form_validation -> set_rules('did', 'DID/TFN', 'trim|required|xss_clean');
			$this -> form_validation -> set_rules('call_record_id', 'Call ID', 'trim|required|xss_clean');
			$this -> form_validation -> set_rules('disposition_id', 'Disposition', 'trim|required|xss_clean');

			if ($this -> form_validation -> run() == FALSE) {
				//change validation error delimiters
				$this -> form_validation -> set_error_delimiters('<div class="error">', '</div>');

				//get info if record_id was given
				if ($record_id != NULL) {
					//get dispositions
					$dispositions = $this -> Record_model -> get_dispositions(array('active' => 1, 'sub' => 1, 'sub_dispo_id' => 24));
					$dispo_filter = array('' => '');
					foreach($dispositions as $data) {
						$dispo_filter += array($data['disposition_id'] => $data['label']);
					}
					$info = $this -> Record_model -> get_info_quick($record_id);
					//load view
					$this -> load -> view('template/main', array('content' => 'agent/quick_edit', 'dropdown' => array('dispositions' => $dispo_filter), 'location' => 'Agent / Quick Call', 'record' => $info));
				} else {
					//get dispositions
					$dispositions = $this -> Record_model -> get_dispositions(array('active' => 1, 'sub' => 1, 'sub_dispo_id' => 24));
					$dispo_filter = array('' => '');
					foreach($dispositions as $data) {
						$dispo_filter += array($data['disposition_id'] => $data['label']);
					}
					//load view
					$this -> load -> view('template/main', array('content' => 'agent/quick_add', 'dropdown' => array('dispositions' => $dispo_filter), 'location' => 'Agent / Quick Call'));
				}
			} else {
				if (isset($_POST['submit_record'])) {
					//destroy submit_record from the POST array
					unset($_POST['submit_record']);
					//add/update record
					$id = $record_id != NULL ? $this -> Record_model -> update_quick($record_id, $_POST) : $this -> Record_model -> add_quick($_POST);
					if ($id) {
						$this -> session -> set_flashdata('prompt', '<div><span class="prompt">Record updated.</span></div>');

						redirect('/agent/quick/record/' . $id, 'refresh');
					}
				}
			}
		}
	}
}
