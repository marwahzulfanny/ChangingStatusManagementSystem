<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Majormodel extends CI_Model {
	
	public function getAll() {
		$getAll = $this->db->get('major');
		return $getAll->result();
	}

	public function byId($id) {
		$byId = $this->db->get_where('major', ['id' => $id]);
		return $byId->row();
	}

	public function update($data, $id) {
		$this->db->set($data);
		$this->db->where('id', $id);
		$update = $this->db->update('major');
		return $update;
	}

	public function delete($id) {
		$this->db->where('id', $id);
		$delete = $this->db->delete('major');
		return $delete;
	}
}