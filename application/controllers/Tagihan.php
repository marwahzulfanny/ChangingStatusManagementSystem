<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tagihan extends CI_CONTROLLER {
	public function __construct() {
		parent::__construct();
		$this->load->library('grocery_CRUD');
		$this->load->model('Coursesmodel');
		if($this->session->login !== true) redirect(base_url('login'));
	}

	public function index($op=''){
		// if($this->session->role==''){redirect('dashboard');}
		$rl = $this->session->role;
		if(!in_array($rl,array('Admin','Manager','SAA','Finance'))){redirect('dashboard');}
		$output['title'] = 'Student Fees';
		$output['session'] = $this->session;
		
		$c = new grocery_CRUD();
		$c->set_table('tagihan');
		//sidebar filter: major, date, status ??
		if(in_array($rl,array('Manager','SAA'))){
			$c->unset_edit()->unset_delete()->unset_add();
		}
		
		$c->columns('user','description','amount','date_bill','date_paid','note','payment_proof','status');
		$c->display_as('user','Student');
		$c->display_as('description','Bill description');
		$c->display_as('date_bill','Issued date');
		$c->callback_read_field('amount',function($v,$ky){return 'Rp '.number_format($v,0,",",".").',-';});
		$c->callback_column('amount',function($v,$ky){return 'Rp '.number_format($v,0,",",".").',-';});
		// $c->set_relation('batch','users','batch');
		// $c->callback_column('major',array($this,'_callback_column_major'));
		// $c->callback_column('batch',array($this,'_callback_column_batch'));
		$c->callback_edit_field('note',array($this,'_callback_edit_field_note'));
		$c->unset_read();
		$c->unset_clone();
		$c->callback_before_update(array($this,'_append_note'));
		$c->unset_texteditor('note');
		if($op=='edit'){
			$c->field_type('last_status_change','readonly');
		}elseif($op=='update'){
			$c->field_type('last_status_change','hidden');
		}

		
		$c->set_field_upload('payment_proof','assets/uploads/payment_proof');
		
		
		//kalo sekretariat ke atas:
		$c->set_relation('user','users','name',array('role'=>'Student'));
		$c->callback_column('role',array($this,'_role'));
		$c->field_type('date_bill','hidden',date('Y-m-d h:i:s'));
		$c->field_type('payment_proof','readonly');
		if($op=='add'||$op=='insert'){
			$c->field_type('status','hidden','Waiting payment');
		}
		if($op=='edit'||$op=='update'){
			$c->field_type('user','readonly');
		}
		$c->field_type('payment_proof_date','readonly');
		// callback_after_update, bila statusnya berubah --> update last_status_change ??
		// tambah tagihan per major, lalu bisa tambah tagihan ke multiple batch --> lalu muncul halaman klarifikasi (atau add (dari batch lain) & exclude students (dari batch yg sudah dipilih)) ??

		$output['output'] = $c->render();
		$this->load->view('common_crud',$output);
	}
	function _callback_column_batch($val,$row){return $this->db->select('batch')->where('id',$row->user)->get('users')->row()->batch;}
	function _update_upload_time($post_array, $primary_key){
		$this->db->update('tagihan',array('payment_proof_date'=>date('Y-m-d h:i:s')),'id='.$primary_key);
		return true;
	}
	function _append_note($post_array, $primary_key){
		$existingStatus = $this->db->select('status')->get('tagihan')->row()->status;
		if($existingStatus != $post_array['status']){
			$post_array['last_status_change'] = date('Y-m-d h:i:s');
		}
		$r = $this->db->select('note')->where('id',$primary_key)->get('tagihan')->row();
		if($post_array['note']!=''){
			if($r->note!=''){
				$post_array['note'] = $r->note.'; '.$this->session->name.' ('.date('Y-m-d h:i:s').'): '.$post_array['note'];
			}else{
				$post_array['note'] = $this->session->name.' ('.date('Y-m-d h:i:s').'): '.$post_array['note'];
			}
		}
		return $post_array;
	}
	function _callback_edit_field_note($v, $primary_key){
		$r = $this->db->select('note')->where('id',$primary_key)->get('tagihan')->row()->note;
		return str_replace(';','<br>',$r).'<br><input name="note" type="text">';
	}
	function _role($v,$r){
		return $this->db->select('role')->where('id',$r->user)->get('users')->row()->role;
	}
	
	public function addBatchTugas(){
		
	}
	public function tugas($op=''){
		$rl = $this->session->role;
		if(!in_array($rl,array('Admin','Manager','SAA','Finance'))){redirect('dashboard');}
		$output['title'] = 'Assignments';
		$output['session'] = $this->session;
		
		$c = new grocery_CRUD();
		$c->set_table('tagihan_tugas');
		if(in_array($rl,array('Manager','Finance'))){
			$c->unset_edit()->unset_delete()->unset_add();
		}
		
		$rs = $this->db->query("select id,NIP_NPM,name,major,batch,jalur from users u where u.status='Active' and u.role='Student'")->result();
		$text_stu = "";
		foreach($rs as $r){
			$text_stu .= '<option value="">'.$r->name.'('.$r->NIP_NPM.'), Batch: '.$r->batch.', Major: '.$r->major.', Jalur: '.$r->jalur.'</option>';
		}
		// $output['filterForm'] = array(
		// 	'title' => 'Batch create',
		// 	'actionUrl' => base_url('tagihan/addBatchTugas'),
		// 	'content' => '
		// 		Assignment name:
		// 		<div class="form-group">
		// 			<input name="name" type="text" placeholder="Nama tugas">
		// 		</div>
		// 		Description/Note:
		// 		<div class="form-group">
		// 			<input name="note" type="text" placeholder="Nama tugas">
		// 		</div>
		// 		Select student(s):
		// 		<div class="form-group">
		// 			<select name="students" class="form-control form-control-lg" multiple>'.$text_stu.'</select>
		// 		</div>
		// 		'
		// );
		
		$output['output'] = $c->render();
		$this->load->view('common_crud',$output);
	}
}

// bila sudah bayar atau lulus ujian, otomatis tambahkan ke tabel stu_status (kalo dari maba, users.status nya diubah dulu jd mhs