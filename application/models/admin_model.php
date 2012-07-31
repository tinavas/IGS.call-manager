<?php
class Admin_model extends CI_Model {

	function __construct() {
		parent::__construct();
	}

	public function report($sdate, $edate, $type) {
		if($type == 1) {
			$query = $this->db->query("
				SELECT a.user_name, a.agent_id, a.phone, a.account_no, a.account_no_gas, a.account_no_elec, a.customer_name, a.conf_1 as 'confirmation_no_1', a.conf_2 as 'confirmation_no_2', a.tpv_no, a.tpv_no2, a.call_record_id, a.call_record_id2, a.call_record_id3, a.promo_code, b.`label` as 'disposition', e.`label` as 'sub-disposition', c.`label` as 'flag_reason', a.flag_others as 'flag_other_reason', d.label as 'market', a.call_notes, a.rdate as 'date' 
				FROM igs_records a 
				LEFT JOIN igs_dispositions b 
				  ON a.disposition_id = b.disposition_id 
				LEFT JOIN igs_flag_reasons c 
				  ON a.flag_id = c.flag_id 
				LEFT JOIN igs_markets d 
				  ON a.market_id = d.market_id
				LEFT JOIN igs_dispositions e 
				  ON a.sub_disposition_id = e.disposition_id
				INNER JOIN (select max(record_id) as record_id from igs_records where rdate >= '{$sdate}' AND rdate <= '{$edate}' group by phone) e
				  ON a.record_id = e.record_id 
			");
			$filename = 'IGS Verification Report.csv';
		} elseif($type == 2) {
			$query = $this->db->query("
				SELECT sales_channel as 'Sales Channel', zip_code as 'Zip Code', gas_utility as 'Gas Utility', electric_utility as 'Electric Utility', residential_commercial as 'Residential/Commercial', promo_code as 'Promo Code', rate_term as 'Rate & Term', account_no as 'Account #/SDI #/POD#', service_address as 'Service Address', billing_address as 'Billing Address', service_city as 'Service City', state as 'State', first_name as 'First Name', last_name as 'Last Name', email as 'Email', phone as 'Phone', referral_code as 'Referral Code/Broker ID/Order ID', confirmation_no as 'Confirmation #', action as 'Action/Follow-up', user_name as 'agent', DATE_ADD(rdate,INTERVAL '-12' HOUR) as 'date'
				FROM igs_records_manual
				WHERE rdate >= '{$sdate}' AND rdate <= '{$edate}'
			");
			$filename = 'IGS Manual Verification Report.csv';
		} elseif($type == 3) {
			$query = $this->db->query("
				SELECT a.call_record_id as 'call_id', a.user_name as 'agent', b.`label` as 'disposition', a.rdate as 'date'
				FROM igs_records_quick a
				LEFT JOIN igs_dispositions b
				  ON a.disposition_id = b.disposition_id
				WHERE rdate >= '{$sdate}' AND rdate <= '{$edate}'
			");
			$filename = 'IGS Quick Call Report.csv';
		}
		
		$this->load->helper('csv');
		query_to_csv($query, TRUE, $filename);
	}
}
