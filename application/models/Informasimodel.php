<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Informasimodel extends CI_Model {
	
	public function getAll() {
		return $this->db->get('informasi');
	}
}