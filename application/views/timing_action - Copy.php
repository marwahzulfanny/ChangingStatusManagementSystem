<?php $this->load->view('parts/header'); ?>
<?php $activePage = basename($_SERVER['PHP_SELF'], ".php");?>
   <!-- Main content -->
    <section class="content">
      <div class="row">
	      <div class="col-md-3">
		      <div class="box box-info">
						<form action="<?php echo base_url('timing/doStartTerm'); ?>" method="post">
							<div class="box-header">
								<h3 class="box-title">Memulai Semester Berikutnya</h3>
							</div>
							<div class="box-body">
Langkah ini akan mengakhiri semester <code><?=$thisTermName?></code> dan memulai semester <code><?=$nextTermName?></code> untuk semua Batch di semua Major. <a href="<?=base_url('timing')?>">Salah?</a>.
<br>
<br>
Pastikan Subjek yang akan diselenggarakan telah disiapkan dengan ketentuan:
<ul>
	<li>jumlah dan porsi pengajar/para pengajar = 100%</li>
	<li>jumlah bobot komponen-komponen penilaian = 100%</li>
	<li>ruangan dan jadwal sudah ditentukan</li>
</ul>
Bila tidak yakin, harap <a href="<?=base_url('penyelenggaraan2')?>" target="_blank"><i class="fa fa-external-link"></i>cek</a>.

<!--check existing students-->
Siswa akan otomatis aktif di semester <code><?=$nextTermName?></code> bila:<ol>
<li>sudah melakukan pembayaran. <a href="<?=base_url('biaya')?>" target="_blank"><i class="fa fa-external-link"></i>Cek</a></li>
<li>sudah melunasi kewajiban akademik di semester ini. <a href="<?=base_url('syarat')?>" target="_blank"><i class="fa fa-external-link"></i>Cek</a></li>
<li>tidak memiliki status cuti atau overseas melebihi 30 hari dari awal <code><?=$nextTermName?></code></li>
</ol>
Siswa akan dienroll otomatis ke penyelenggaraan kelas yang ditetapkan pada kurikulum.

<!--
//check new students
//bila <code>semester berikutnya</code> adalah ganjil:
Siswa baru akan aktif di <code><?=$nextTermName?></code> bila:
- sudah melakukan pembayaran. <a href="<?=base_url('biaya')?>">Cek</a>
- sudah mengisi biodata minimal. <a href="<?=base_url('biodataClearance')?>">Cek</a>
- lulus ujian masuk. <a href="<?=base_url('syarat')?>">Cek</a>
assign batch ke new student
-->
								
							</div>
							<div class="box-footer">
								<button type="submit" class="btn btn-primary">Submit</button>
							</div>
						</form>
		      </div>
				</div>
	      <div class="col-md-9">
		      <div class="box box-info">
						<div class="box-header">
							<h3 class="box-title">Detil Rencana Semester <code><?=$nextTermName?></code></h3>
						</div>
						<div class="box-body">
<?php
foreach($allMajor as $aMajor){
	echo '<h4>'.$aMajor->name.'</h4>';
	
	// echo 'Active students in this major: ';
	$arrStu = array();
	$activeBatches = $this->db->query("select distinct u.batch from stu_status ss join users u on ss.user=u.id where ss.status='Aktif' and ss.action='Disetujui' and u.status='Active' and u.role='Student' and ss.term=$nextTermId and u.major=$aMajor->id")->result();
	if(count($activeBatches)>0){foreach($activeBatches as $aBatch){
		// echo '<br>'.$aBatch->batch.':<br>';
		$activeStudents = $this->db->query("select u.name, u.batch, u.id, u.role, u.major from stu_status ss join users u on ss.user=u.id where ss.status='Aktif' and ss.action='Disetujui' and u.status='Active' and u.role='Student' and ss.term=$nextTermId and u.major=$aMajor->id and u.batch='$aBatch->batch'")->result(); //get students yg aktif di semeter ini
		$tmp = array();
		if(count($activeStudents)>0){foreach($activeStudents as $aStu){
			// echo $aStu->name.', ';
			array_push($tmp,$aStu);
		}}
		$arrStu[$aBatch->batch] = $tmp;
	}}
	// echo '<pre>';print_r($arrStu);echo '</pre>';
	// echo '<br>';
	
	$kur = $this->db->query("select nama, id from kurikulum where major = $aMajor->id and mulai_berlaku <= CURRENT_TIMESTAMP and akhir_berlaku >= CURRENT_TIMESTAMP limit 1")->row();
	if(count($kur)>0){
		// echo '<br>'.$kur->id.'<br>';
		$semesters = '1 or semester=3';
		if($nextTermGanjilGenap=='Genap'){ $semesters = '2 or semester=4';  }
		$courses = $this->db->query("select * from courses where kurikulum=$kur->id and (semester=$semesters)")->result();
		
		if(count($courses)>0){
			foreach($courses as $aCourse){
				// echo '<br>Utk thn '.substr($nextTermName,0,4).', sem '.$nextTermGanjilGenap.' -- '.$aCourse->name.' adalah MK utk sem '.$aCourse->semester.'<br>';
				echo '<br><b>'.$aCourse->name.'</b>';
				foreach($activeBatches as $aBatch){
					if($aCourse->semester <= 2){ //student yg mau dienrol ke MK ini adalah student yg masuk tahun ini (batch thn ini)
						if( (int)substr($aBatch->batch,0,4) ==  (int)substr($nextTermName,0,4) ){
							// echo '<u>'.$aBatch->batch.'</u>, ';
							if($op=='renew'){
								$tmp1 = $this->db->query("select id from course_teachings where course=$aCourse->id and timing=$nextTermId and batch='$aBatch->batch'")->result();
								if(count($tmp1)>0){
									$this->db->delete('course_teachings', array('course' => $aCourse->id, 'timing' => $nextTermId, 'batch' => $aBatch->batch)); //delete all of them
									foreach($tmp1 as $t){
										// $this->db->delete('course_scoring', array('course_teaching'=>$t->id)); $this->db->delete('course_teachers', array('course_teaching'=>$t->id)); $this->db->delete('student_course', array('course_teaching'=>$t->id));
										$this->db->delete(array('course_scoring', 'course_teachers', 'student_course'), array('course_teaching'=>$t->id));
									}
								}
								$this->db->query("INSERT INTO course_teachings (course,timing,batch) VALUES ($aCourse->id,$nextTermId,'$aBatch->batch')"); //insert new one  --> autocreate ketauan karena harinya Minggu.
								$ctId = $this->db->query("select id from course_teachings where course=$aCourse->id and timing=$nextTermId and batch='$aBatch->batch'")->row()->id; //get its ID
								$stuToAdd = array();
								// if(isset($arrStu[$aBatch->batch])){echo '<b>_isset</b>';}
								// if(count($arrStu[$aBatch->batch])>0){echo '<b>_notZero</b>';}
								foreach($arrStu[$aBatch->batch] as $aStu){
									array_push($stuToAdd, array('student' => $aStu->id, 'course_teaching' => $ctId ));
								} // echo '<pre>';print_r($stuToAdd);echo '</pre>';
								$this->db->insert_batch('student_course', $stuToAdd); //add students from this batch
							}
						}
					}else{  //student yg mau dienrol ke MK ini adalah student yg masuk tahun lalu (batch thn lalu)
						if( (int)substr($aBatch->batch,0,4) ==  (int)substr($nextTermName,0,4)-1 ){
							if($op=='renew'){
								$tmp1 = $this->db->query("select id from course_teachings where course=$aCourse->id and timing=$nextTermId and batch='$aBatch->batch'")->result();
								if(count($tmp1)>0){
									$this->db->delete('course_teachings', array('course' => $aCourse->id, 'timing' => $nextTermId, 'batch' => $aBatch->batch)); //delete all of them
									foreach($tmp1 as $t){
										// $this->db->delete('course_scoring', array('course_teaching'=>$t->id)); $this->db->delete('course_teachers', array('course_teaching'=>$t->id)); $this->db->delete('student_course', array('course_teaching'=>$t->id));
										$this->db->delete(array('course_scoring', 'course_teachers', 'student_course'), array('course_teaching'=>$t->id));
									}
								}
								$this->db->query("INSERT INTO course_teachings (course,timing,batch) VALUES ($aCourse->id,$nextTermId,'$aBatch->batch')"); //insert new one  --> autocreate ketauan karena harinya Minggu.
								$ctId = $this->db->query("select id from course_teachings where course=$aCourse->id and timing=$nextTermId and batch='$aBatch->batch'")->row()->id; //get its ID
								$stuToAdd = array();
								// if(isset($arrStu[$aBatch->batch])){echo '<b>_isset</b>';}
								// if(count($arrStu[$aBatch->batch])>0){echo '<b>_notZero</b>';}
								foreach($arrStu[$aBatch->batch] as $aStu){
									array_push($stuToAdd, array('student' => $aStu->id, 'course_teaching' => $ctId ));
								} // echo '<pre>';print_r($stuToAdd);echo '</pre>';
								$this->db->insert_batch('student_course', $stuToAdd); //add students from this batch
							}
						}
					}
				}
				if(count($activeBatches)<1){echo 'No eligible students.<br>';}
				
				
				$penyelenggaraans = $this->db->query("select * from course_teachings where timing=$nextTermId and course=$aCourse->id")->result();
				if(count($penyelenggaraans)>0){
					foreach($penyelenggaraans as $penyelenggaraan){
						echo '<br>- <a href="'.base_url('penyelenggaraan2/index/read/'.$penyelenggaraan->id).'" target="_blank">'.$aCourse->name.' ('.$aCourse->code.', '.$aCourse->credits.' SKS) untuk '.$penyelenggaraan->batch.'</a>: '.$penyelenggaraan->room.' '.$penyelenggaraan->day.' '.$penyelenggaraan->time_start.'<br>';
						$studentsInPenyelenggaraan = $this->Coursesmodel->getMhsInPenyelenggaraan($penyelenggaraan->id);
						if(count($studentsInPenyelenggaraan)>0){
							foreach($studentsInPenyelenggaraan as $aStu){
								echo $aStu->name.', ';
							}
						}else{echo 'No student eligible to take this class.<br>';}
						
						//cek jml student, jml komponen nilai, total persentase komponen nilai, jml dosen, total persentase dosen, total jam kelas
						//cek ruangan bentrok
						//cek dosen bentrok
						//cek mhs bentrok
					}
				}else{
					// $this->db->query("INSERT INTO course_teachings (course,timing) VALUES ($aCourse->id,$nextTermId)"); //create penyelenggaraan sebanyak batch yg memerlukan ??

					// select student yg MK ini belum lulus
					//add student
					//kasih tombol buat delete (in new window)
					
				}
			}
		}else{echo 'Tidak ada subjek.<br>';}
	}else{ echo ' No active curriculum.'; }
}
?>
						</div>
					</div>
				</div>
				
			
  		</div>
  	</section>
<?php $this->load->view('parts/footer'); ?>

