<?php
class Admin_model extends CI_Model {

	function __construct() {
		parent::__construct();
	}

	public function report($sdate, $edate) {
		$query = $this->db->query("
			SELECT a.user_name, a.agent_id, a.phone, a.account_no, a.customer_name, a.conf_1 as 'confirmation_no_1', a.conf_2 as 'confirmation_no_2', a.tpv_no, a.call_record_id, a.call_record_id2, a.call_record_id3, a.promo_code, b.`label` as 'disposition', c.`label` as 'flag_reason', a.flag_others as 'flag_other_reason', d.label as 'market', a.call_notes, a.rdate as 'date' 
			FROM igs_records a 
			LEFT JOIN igs_dispositions b 
			  ON a.disposition_id = b.disposition_id 
			LEFT JOIN igs_flag_reasons c 
			  ON a.flag_id = c.flag_id 
			LEFT JOIN igs_markets d 
			  ON a.market_id = d.market_id
			INNER JOIN (select max(record_id) as record_id from igs_records where rdate >= '{$sdate}' AND rdate <= '{$edate}' group by phone) e
			  ON a.record_id = e.record_id 
		");
		
		$this->load->helper('csv');
		query_to_csv($query, TRUE, 'IGS Report.csv');
	}
}
