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

	/*
	 * get user type of the provided username
	 */
	public function get_user_type($username) {
		$this -> db -> select('igs_user_types.label as user_type');
		$this -> db -> from('igs_users');
		$this -> db -> join('igs_user_types', 'igs_users.user_type_id = igs_user_types.user_type_id');
		$this -> db -> where('igs_users.username', $username);
		$query = $this -> db -> get();

		if ($query -> num_rows() == 1) {
			$row = $query -> row();
			return $row -> user_type;
		}
		return false;
	}

}
?>