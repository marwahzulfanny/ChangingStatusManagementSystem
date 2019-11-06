<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kurikulummodel extends CI_Model {
	
	public function getAll() {
		$getAll = $this->db->get('kurikulum');
		return $getAll->result();
	}

	public function byId($id) {
		$byId = $this->db->get_where('kurikulum', ['id' => $id]);
		return $byId->row();
	}

	public function update($data, $id) {
		$this->db->set($data);
		$this->db->where('id', $id);
		$update = $this->db->update('kurikulum');
		return $update;
	}

	public function delete($id) {
		$this->db->where('id', $id);
		$delete = $this->db->delete('kurikulum');
		return $delete;
	}
}