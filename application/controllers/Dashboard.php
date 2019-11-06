<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->session->set_userdata($this->session->userdata()); //extend cookie expiration
		if($this->session->login !== true) redirect(base_url('login'));
	}

	public function index() {
		$this->load->view('dashboard');
		// if($this->session->userdata('role')=='Admin' || $this->session->userdata('role')=='SAA'){
		// }
		// else if($this->session->userdata('role')=='Lecturer'){
		//   $this->load->view('dashboardDosen');
		// }
		// else if($this->session->userdata('role')=='Student'){
		//   $this->load->view('mahasiswa/dashboardMahasiswa');
		// }
		// else if($this->session->userdata('role')=='Alumni'){
		//   $this->load->view('dashboardAlumni');
		// }
		// else if($this->session->userdata('role')=='Pensiunan'){
		//   $this->load->view('dashboardPensiunan');
		// }
		// else if($this->session->userdata('role')=='Finance'){
		//   $this->load->view('dashboardPegawai');
		// }
		// else if($this->session->userdata('role')=='Manager'){
		//   $this->load->view('dashboardManajer');
		// }
		// else if($this->session->userdata('role')=='School Representative' || $this->session->userdata('role')=='Student Candidate'){
		//   redirect(base_url('penerimaan/manage'));
		// }
		// else {
		// 	$this->load->view('login');
		// }
		
	}
}

/*
reminder dosen yg belum isi nilai:

pelaksanaan course di semester ini:
select * from course_teachings where timing = (select id from timing where start_date <= CURRENT_TIMESTAMP and end_date >= CURRENT_TIMESTAMP limit 1)

utk setiap pelaksanaan:
cek siapa saja student yg teregister:
select id from users where id in (select student from student_course where course_teaching = $course_teaching)
count this

cek komponen nilai nya ada apa saja:
select * from course_scoring where course_teaching = $course_teaching

select * from student_course_score where student = ?? and course_scoring = ?? --> count nya harus == 1
kalo 0 --> catat di $nilaiYgBelum[pelaksanaan][komponen][student]


==================

setelah UTS: penyelenggaraan atas kuliah2 yg seharusny ada di semester selanjutnya akan dibikin otomatis, utk semua batch (SAA tinggal set pengajar & ruang)
setelah ujian masuk & periode pembayaran, dan sebelum mulai semester baru: cek mhs baru utk dimasukkan ke batch
setelah semua peserta dapet batch: peserta otomatis ter enrol

periode perubahan status siswa
	max pengajuan cuti
	pembayaran
	
pemasukan nilai

perkuliahan 





*/
