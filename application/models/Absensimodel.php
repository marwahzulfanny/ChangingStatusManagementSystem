<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Absensimodel extends CI_Model {
	
	function getQueryAbsen(){		
		$getData = $this->db->query("SELECT users.NIP_NPM, users.name from users join student_course on student_course.student = users.NIP_NPM");
		return $getData->result();
	}
}