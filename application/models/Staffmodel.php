<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Staffmodel extends CI_Model {
	public function read($role) {
		$readstaff = $this->db->query("select * from users where role='Admin','Lecturer','Finance','Manager','SAA'");
		if($readstaff->num_rows()>0){
			foreach ($readstaff->result() as $data){
				$hasil=array(
				'name' => $data->name.
				'username' => $data->username.
				'role' => $data->role.
			);
		}
		return $hasil;
	}
	
	public function docreate($data) {
		$docreate = $this->db->insert('users', $data);
		$user = $this->db->get_where('users', ['id' => $this->db->insert_id()]);
		return $user;
	}

	public function byId($id) {
		$byId = $this->db->get_where('users', ['id' => $id]);
		return $byId->row();
	}

	public function update($data, $id) {
		$this->db->set($data);
		$this->db->where('id', $id);
		$update = $this->db->update('users');
		return $update;
	}

	public function delete($id) {
		$this->db->where('id', $id);
		$delete = $this->db->delete('users');
		return $delete;
	}
}