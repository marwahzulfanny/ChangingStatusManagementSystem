<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth_model extends CI_CONTROLLER {
	public function update($data, $id)
    {
        $this->db->where($this->id, $id);
        $this->db->update($this->table, $data);
        return $this->db->affected_rows();
    }

    public function get_by_id($id)
    {
        $this->db->select('
            users.*, role.id AS id_role, tbl_role.name, tbl_role.description,
            ');
        $this->db->join('tbl_role', 'users.id_role = tbl_role.id');
        $this->db->from($this->table);
        $this->db->where($this->id, $id);
        $query = $this->db->get();
        return $query->row();
    }
}