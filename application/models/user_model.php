<?php
class User_model extends CI_Model {

	function __construct() {
		parent::__construct();
	}

	/*
	 * check if username already exist
	 */
	public function check_username_exist($username) {
		$query = $this -> db -> get_where('igs_users', array('username' => $username));

		if ($query -> num_rows() == 1) {
			return true;
		}
		return false;
	}

}
?>