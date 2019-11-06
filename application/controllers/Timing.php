<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Timing extends CI_CONTROLLER {
	public function __construct() {
		parent::__construct();
		$this->session->set_userdata($this->session->userdata()); //extend cookie expiration
		$this->load->library('grocery_CRUD');
		$this->load->model('Usersmodel');
		$this->load->model('Coursesmodel');
		if($this->session->login !== true) redirect(base_url('login'));
		$ro=$this->session->role;
		if($ro!='Admin'&&$ro!='Manager'&&$ro!='Finance'&&$ro!='SAA'){redirect('dashboard');}
	}
	public function index($op3='') {
		$output['title'] = 'Semesters &amp; Dates';
		$output['session']=$this->session;
		$c = new grocery_CRUD();
		$c->set_table('timing');
		$output['output'] = $c->render();
		
		$nextTermName = $this->Coursesmodel->getNextTerm()->name;
		if($op3==''){
		$output['filterForm'] = array(
			'title' => 'Preparing the next semester',
			'method' => 'post',
			'actionUrl' => base_url('timing/action/renew'),
			'content' => '
				Clicking the button below will:
				<ol>
				 <li>For each Major, each Course in the Curriculum that is active in semester (<code>'.$nextTermName.'</code>) will be realized into <u data-toggle="tooltip" data-html="true" title="In each semester, a <b>Course</b> can be implemented into <i>n</i> <b>class(es)</b>, each of which is for specific student group.">Class(es)</u> <b>if</b> there are student(s) <u data-toggle="tooltip" data-html="true" title="...for example, those who has completed their minimum payment and assignment duties, etc.">eligible</u> to take the said course.</li>
				 <li>Student grouping will be done automatically based on their <u data-toggle="tooltip" data-html="true" title="the <b>jalur</b> column in Students page">jalur</u> and the maximum capacity in each class.</li>
				</ol>
				You <i>cannot undo</i> this step, but you can repeat the step (the latest one will be counted).
				<br><br>Maximum number of students per class:
				<div class="form-group">
					<input type="number" class="form-control form-control-lg" name="stuPerBatch" value="25">
				</div>
				Tolerance:
				<div class="form-group">
					<input type="number" class="form-control form-control-lg" name="stuPerBatchTolerance" value="2">
				</div>
			'
		);
		}
		
		$this->load->view('common_crud',$output);
	}
	public function action($op=''){ //to renew, set $op='renew'
		$o['stuPerBatch'] = $this->input->post('stuPerBatch');
		$o['stuPerBatchTolerance'] = $this->input->post('stuPerBatchTolerance');
		$major     = $this->input->get('major');
		$batch     = $this->input->get('batch');
		$allMajor = $this->Coursesmodel->getAllMajor();
		$text_major = '';
		foreach($allMajor as $m){
			$selected = $major==$m->id? 'selected' : '';
			$text_major .= '<option value='.$m->id.' '.$selected.'>'.$m->name.'</option>';
		}
		// $this->db->select('id,name');
		// if($major!=''){$this->db->where('major',$major);}
		// $batches = $this->db->order_by('major asc','start_term asc')->get('batches')->result();
		// $text_batch = '';
		// foreach($batches as $m){
		// 	$selected = $batch==$m->id? 'selected' : '';
		// 	$text_batch .= '<option value='.$m->id.' '.$selected.'>'.$m->name.'</option>';
		// }
		$output['filterForm'] = array(
			'title' => 'Action',
			'method' => 'post',
			'actionUrl' => base_url('biaya'),
			'content' => '
				<div class="form-group">
					<select class="form-control form-control-lg" name="major"><option value="">Select Major</option>'.$text_major.'</select>
				</div>
			'
		);
		
		$o['op'] = $op;
		$o['title'] = 'Semesters &amp; Dates';
		$o['session'] = $this->session;
		$thisTermName = $this->Coursesmodel->getCurrentTerm()->name;
		$o['thisTermName'] = $thisTermName==''?'None':$thisTermName;
		$nextTermName = $this->Coursesmodel->getNextTerm()->name;
		$o['termEndDates'] = $this->Coursesmodel->getNextTerm()->end_date;
		$o['termStartDates'] = $this->Coursesmodel->getNextTerm()->start_date;
		$o['nextTermName'] = $nextTermName==''?'None':$nextTermName;
		$o['nextTermGanjilGenap'] = $this->Coursesmodel->getNextTerm()->semester;
		$o['nextTermId'] = $this->Coursesmodel->getNextTerm()->id;
		$o['allMajor'] = $this->Coursesmodel->getAllMajor();
		
		$this->load->view('timing_action',$o);
	}
	public function doStartTerm(){
		if($this->session->role=='Manager'||$this->session->role=='Admin'){
			
		}else{redirect('login/logout');}
	}
	public function calendar(){
		$output['title'] = 'Master Calendar';
		$output['session']=$this->session;
		$c = new grocery_CRUD();
		$c->set_table('calendar');
		$c->unset_delete();
		$output['output'] = $c->render();
		$this->load->view('common_crud',$output);
	}
	//set sk kelulusan semester ??
	//set sk kelulusan akhir ??
	//generate tagihan ??
}