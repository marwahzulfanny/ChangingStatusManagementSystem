<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Calendarmodel extends CI_Model {
	// public function login($data) {
	// 	$username = $data['username'];
	// 	$password = md5($data['password']);
	// 	$dologin = $this->db->query("select * from users where (username = '$username' or email = '$username') and password = '$password' and status = 'active'");
	// 	return $dologin;
	// }

	// public function register($data) {
	// 	$doregister = $this->db->insert('users', $data);
	// 	$user = $this->db->get_where('users', ['id' => $this->db->insert_id()]);
	// 	return $user;
	// }

	public function getAll() {
		$getAll = $this->db->select('title,start,end')->get('bookings');
		return $getAll->result();
	}

	// public function checkUsername($username) {
	// 	$checkUsername = $this->db->get_where('users', ['username' => $username])->num_rows();
	// 	return $checkUsername;
	// }

	public function byId($id) {
		$byId = $this->db->get_where('rooms', ['id' => $id]);
		return $byId->row();
	}

	public function update($data, $id) {
		$this->db->set($data);
		$this->db->where('id', $id);
		$update = $this->db->update('rooms');
		return $update;
	}

	public function delete($id) {
		$this->db->where('id', $id);
		$delete = $this->db->delete('rooms');
		return $delete;
	}
}