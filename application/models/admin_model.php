<?php
class Admin_model extends CI_Model {

	function __construct() {
		parent::__construct();
	}

	public function report($sdate, $edate) {
		$query = $this->db->get_where('igs_records', array('rdate >=' => $sdate, 'rdate <=' => $edate));
		
		$this->load->helper('csv');
		query_to_csv($query, TRUE, 'toto.csv');
	}
}
