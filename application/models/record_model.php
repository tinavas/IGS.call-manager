<?php
Class Record_model extends CI_Model {

	function Record_model() {
		parent::__construct();
	}

	/*
	 * Search record with same phone number
	 */
	public function search($phone) {

		$this -> db -> order_by('record_id', 'DESC');
		$query = $this -> db -> get_where('igs_records', array('phone' => $phone), 1);

		if ($query -> num_rows() == 1) {
			return $query -> row_array();
		}
		return false;
	}

	public function get_channels($mode = 'utility') {
		$query = $this -> db -> get('igs_channels');
		$channels = array('' => '');

		foreach ($query->result_array() as $row) {
			if ($mode == 'utility') {
				$channels += array($row['channel_id'] => $row['utility']);
			} else {
				$channels += array($row['channel_id'] => $row['state']);
			}
		}

		return $channels;
	}

	public function get_dispositions() {
		$query = $this -> db -> get('igs_dispositions');
		$dispositions = array('' => '');

		foreach ($query->result_array() as $row) {
			$dispositions += array($row['disposition_id'] => $row['label']);
		}

		return $dispositions;
	}
	
	public function get_flag_reasons() {
		$query = $this -> db -> get('igs_flag_reasons');
		$flags = array('' => '');

		foreach ($query->result_array() as $row) {
			$flags += array($row['flag_id'] => $row['label']);
		}

		return $flags;
	}

	public function add($param = array()) {
		$this -> db -> set('rdate', 'NOW()', FALSE);

		//check if flag_id is 7, if not then assign NULL
		if ($param['flag_id'] != 7) {
			$param['flag_others'] = NULL;
		}
		
		$insert = $this -> db -> insert('igs_records', $param);

		if ($insert) {
			return $param['phone'];
		} else {
			return FALSE;
		}
	}

	public function get_disposition($disposition_id) {
		$query = $this -> db -> get_where('igs_dispositions', array('disposition_id' => $disposition_id));

		if ($query -> num_rows() == 1) {
			$row = $query -> row();
			return $row -> label;
		}
		return FALSE;
	}
	
	public function get_flag($flag_id) {
		$query = $this -> db -> get_where('igs_flag_reasons', array('flag_id' => $flag_id));

		if ($query -> num_rows() == 1) {
			$row = $query -> row();
			return $row -> label;
		}
		return FALSE;
	}

}
