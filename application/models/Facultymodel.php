<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Facultymodel extends CI_Model {
	public function read($role) {
		$readstaff = $this->db->query("select * from course_teachers");
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
		$docreate = $this->db->insert('course_teachers', $data);
		$user = $this->db->get_where('course_teachers', ['id' => $this->db->insert_id()]);
		return $user;
	}

	public function byId($id) {
		$byId = $this->db->get_where('course_teachers', ['id' => $id]);
		return $byId->row();
	}

	public function update($data, $id) {
		$this->db->set($data);
		$this->db->where('id', $id);
		$update = $this->db->update('course_teachers');
		return $update;
	}

	public function delete($id) {
		$this->db->where('id', $id);
		$delete = $this->db->delete('course_teachers');
		return $delete;
	}
}