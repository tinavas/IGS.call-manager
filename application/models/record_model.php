<?php
Class Record_model extends CI_Model {

	function Record_model() {
		parent::__construct();
	}

	/*
	 * Search record with same phone number
	 */
	public function search($phone, $param = array()) {

		if (count($param) > 0) {
			$query = $this -> db -> get_where('igs_records', $param, 1);

			if ($query -> num_rows() == 1) {
				return $query -> row_array();
			}
		} else {
			/*
			 $this -> db -> order_by('record_id', 'DESC');
			 $query = $this -> db -> get_where('igs_records', array('phone' => $phone), 1);
			 */
			$query = $this -> db -> query("
				SELECT *
				FROM igs_records
				WHERE record_id in (
				  SELECT max(record_id)
				  FROM igs_records 
				  WHERE phone = '{$phone}'
				  GROUP BY date(DATE_ADD(rdate,INTERVAL '-12' HOUR))
				  order BY rdate
				)
			");

			if ($query -> num_rows() > 0) {
				return $query;
			}
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

	public function get_markets() {
		$query = $this -> db -> get('igs_markets');
		$markets = array('' => '');

		foreach ($query->result_array() as $row) {
			$markets += array($row['market_id'] => $row['label']);
		}

		return $markets;
	}

	public function get_records($agent_name) {

		$query = $this -> db -> query("
			SELECT a.*
			FROM igs_records a
			INNER JOIN (select max(record_id) as record_id from igs_records where user_name = '{$agent_name}' group by phone, date(DATE_ADD(rdate,INTERVAL '-12' HOUR))) b
			ON a.record_id = b.record_id
			ORDER BY a.record_id DESC
			LIMIT 0,20
		");

		if ($query -> num_rows() > 0) {
			return $query;
		}
		return false;
	}

	public function get_dispositions($filter = array()) {
		
		//test if filter was set
		if(count($filter) > 0) {
			$query = $this -> db -> get_where('igs_dispositions', $filter);
		} else {
			$query = $this -> db -> get('igs_dispositions');
		}
		
		$dispositions = array();

		foreach ($query->result_array() as $row) {
			$dispositions[] = $row;
		}
		
		return $dispositions;
	}

	public function change_state_dispo($dispo_id, $state = 1) {
		$update = $this -> db -> update('igs_dispositions', array('active' => $state), array('disposition_id' => $dispo_id));
	}

	public function rename_dispo($dispo_id, $label) {
		$update = $this -> db -> update('igs_dispositions', array('label' => $label), array('disposition_id' => $dispo_id));
	}

	public function add_dispo($label) {
		$add = $this -> db -> insert('igs_dispositions', array('label' => $label));
	}

	public function get_flag_reasons() {
		$query = $this -> db -> get('igs_flag_reasons');
		$flags = array('' => '');

		foreach ($query->result_array() as $row) {
			$flags += array($row['flag_id'] => $row['label']);
		}

		return $flags;
	}

	public function get_user_types() {
		$query = $this -> db -> get('igs_user_types');
		$types = array('' => '');

		foreach ($query->result_array() as $row) {
			$types += array($row['user_type_id'] => $row['label']);
		}

		return $types;
	}

	public function add($param = array()) {
		$this -> db -> set('rdate', 'NOW()', FALSE);

		//check if flag_id is 7, if not then assign NULL
		if ($param['flag_id'] != 7) {
			$param['flag_others'] = NULL;
		}
		
		//check if disposition_id is 24, if not then assign NULL
		if ($param['disposition_id'] != 24) {
			$param['sub_disposition_id'] = NULL;
		}

		$insert = $this -> db -> insert('igs_records', $param);

		if ($insert) {
			return $this -> db -> insert_id();
		} else {
			return FALSE;
		}
	}

	public function update($record_id, $param = array()) {
		//$this -> db -> set('rdate', 'NOW()', FALSE);

		//check if flag_id is 7, if not then assign NULL
		if ($param['flag_id'] != 7) {
			$param['flag_others'] = NULL;
		}
		
		//check if disposition_id is 24, if not then assign NULL
		if ($param['disposition_id'] != 24) {
			$param['sub_disposition_id'] = NULL;
		}

		$update = $this -> db -> update('igs_records', $param, array('record_id' => $record_id));

		if ($update) {
			return $record_id;
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

	public function get_info($phone, $call_id, $sdate, $edate) {
		$this -> db -> order_by('record_id', 'DESC');
		$query = $this -> db -> get_where('igs_records', array('phone' => $phone, 'rdate >=' => $sdate, 'rdate <=' => $edate), 1);

		if ($query -> num_rows() == 1) {
			$row = $query -> row();
			return $row;
		} else {
			$this -> db -> order_by('record_id', 'DESC');
			
			$this->db->where("rdate >= '{$sdate}' AND rdate <= '{$edate}' AND (call_record_id LIKE '%{$call_id}%' OR call_record_id2 LIKE '%{$call_id}%' OR call_record_id3 LIKE '%{$call_id}%')");  
			
			//$this -> db -> like('call_record_id', $call_id)->or_like('call_record_id2', $call_id)->or_like('call_record_id3', $call_id);
			//$this -> db -> where(array('rdate >=' => $sdate, 'rdate <=' => $edate));
			$query2 = $this -> db -> get('igs_records', 1);

			if ($query2 -> num_rows() == 1) {
				$row = $query2 -> row();
				return $row;
			}
		}
		return FALSE;
	}

	///////////////////
	//	functions for manual verification
	///////////////////

	/*
	 * fetch info of manual verif record
	 */
	public function get_info_manual($record_id) {
		$query = $this -> db -> get_where('igs_records_manual', array('record_id' => $record_id), 1);

		if ($query -> num_rows() == 1) {
			$row = $query -> row_array();
			return $row;
		}
		return FALSE;
	}

	/*
	 * add info of manual verif record
	 */
	public function add_manual($param = array()) {
		$insert = $this -> db -> insert('igs_records_manual', $param);

		if ($insert) {
			return $this -> db -> insert_id();
		}
		return FALSE;
	}

	/*
	 * update info of manual verif record
	 */
	public function update_manual($record_id, $param = array()) {
		$update = $this -> db -> update('igs_records_manual', $param, array('record_id' => $record_id));

		if ($update) {
			return $record_id;
		}
		return FALSE;
	}

	/*
	 * get recent records per user
	 */
	public function get_records_manual($agent_name) {
		$this -> db -> order_by('record_id', 'DESC');
		$query = $this -> db -> get_where('igs_records_manual', array('user_name' => $agent_name), 20);

		if ($query -> num_rows() > 0) {
			return $query;
		}
		return false;
	}

	/*
	 * Search manual verif record with same phone number
	 */
	public function search_manual($phone, $user_name) {
		$query = $this -> db -> get_where('igs_records_manual', array('phone' => $phone, 'user_name' => $user_name), 1);

		if ($query -> num_rows() == 1) {
			return $query;
		}
		return false;
	}
	
	/*
	 * get recent records per user
	 */
	public function get_records_quick($agent_name) {
		$this -> db -> order_by('record_id', 'DESC');
		$query = $this -> db -> get_where('igs_records_quick', array('user_name' => $agent_name), 20);

		if ($query -> num_rows() > 0) {
			return $query;
		}
		return false;
	}
	
	/*
	 * add info of manual verif record
	 */
	public function add_quick($param = array()) {
		$insert = $this -> db -> insert('igs_records_quick', $param);

		if ($insert) {
			return $this -> db -> insert_id();
		}
		return FALSE;
	}

	/*
	 * update info of manual verif record
	 */
	public function update_quick($record_id, $param = array()) {
		$update = $this -> db -> update('igs_records_quick', $param, array('record_id' => $record_id));

		if ($update) {
			return $record_id;
		}
		return FALSE;
	}
	
	/*
	 * fetch info of manual verif record
	 */
	public function get_info_quick($record_id) {
		$query = $this -> db -> get_where('igs_records_quick', array('record_id' => $record_id), 1);

		if ($query -> num_rows() == 1) {
			$row = $query -> row_array();
			return $row;
		}
		return FALSE;
	}
	
	/*
	 * Search manual verif record with same phone number
	 */
	public function search_quick($callid, $user_name) {
		$query = $this -> db -> get_where('igs_records_quick', array('call_record_id' => $callid, 'user_name' => $user_name));

		if ($query -> num_rows() == 1) {
			return $query;
		}
		return false;
	}

}
