<?php
Class Record_model extends CI_Model {

	function Record_model() {
		parent::__construct();
	}

	/*
	 * Search record with same phone number
	 */
	public function search($phone) {
		
		$this->db->order_by('record_id', 'DESC');
		$query = $this -> db -> get_where('igs_records', array('phone' => $phone), 1);

		if ($query -> num_rows() == 1) {
			return $query->row_array();
		}
		return false;
	}

	public function get_channels($mode = 'utility') {
		$query = $this -> db -> get('igs_channels');
		$channels = array('' => '');

		foreach ($query->result_array() as $row) {
			if($mode == 'utility') {
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

	public function add($param = array()) {
		$this -> db -> set('rdate', 'NOW()', FALSE);

		$insert = $this -> db -> insert('igs_records', $param);

		if ($insert) {
			return $param['phone'];
		} else {
			return FALSE;
		}
	}

}