<?php
include '../lib/database.php';
include '../lib/session.php';
Session::checkLogin();
include '../helpers/format.php';
?>
<?php

/**
 * summary
 */
class adminLogin {
	/**
	 * summary
	 */
	private $db; //private chi sai duoc trong class nay thoi
	private $fm;

	public function __construct() {
		$this->db = new Database();
		$this->fm = new Format();

	}
	public function Loginadmin($userad, $passad) {
		$userad = $this->fm->validation($userad); //kt du lieu hop le:Không có khoảng trống....
		$passad = $this->fm->validation($passad);
		//Hai dong sau dung de kn du lieu
		$userad = mysqli_real_escape_string($this->db->link, $userad);
		$passad = mysqli_real_escape_string($this->db->link, $passad);

		if (empty($userad) || empty($passad)) {
			$alert = "User va pass không được để trống";
			return $alert;
		} else {
			$query = "SELECT * FROM tbl_admin WHERE adminUser='$userad' AND adminpass='$passad'";
			$result = $this->db->select($query);

			if ($result != false) {
				$value = $result->fetch_assoc();
				Session::set('adminlogin', true);
				Session::set('adminID', $value['adminid']);
				Session::set('adminUser', $value['adminUser']);
				Session::set('adminpass', $value['adminpass']);
				Session::set('adminName', $value['adminName']);
				header('Location:index.php');
			} else {
				$alert = "Tài khoản không đúng";
				return $alert;
			}
		}
	}
}

?>