<?php
/*
Admin
Manager
SAA
Lecturer
Finance
School Representative
Student Candidate
Student
Alumni
*/

defined('BASEPATH') OR exit('No direct script access allowed');

class Status extends CI_CONTROLLER {
	public function __construct() {
		parent::__construct();
		$this->load->library('grocery_CRUD');
		if($this->session->login !== true) redirect(base_url('login'));
		$rl = $this->session->role;
	}
	public function index($op=''){
		$c = new grocery_CRUD();
		$output['title'] = 'Rekapitulasi Permintaan Perubahan Status Akademis';
		if($op=='add'){
			$output['title'] = 'Pengajuan Perubahan Status Akademis';
		}
		$c->set_table('stu_status');
		$c->set_relation('user','users','name');
		$c->set_relation('term','timing','year_start');
		
		$output['output'] = $c->render();
		$this->load->view('common_crud',$output);
	}
}