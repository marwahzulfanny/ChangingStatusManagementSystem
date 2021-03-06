<?php $this->load->view('parts/header'); ?>
<?php $activePage = basename($_SERVER['PHP_SELF'], ".php");?>
   <!-- Main content -->
    <section class="content">
      <div class="row">
	      <div class="col-md-12">
		      <div class="box box-info">
						<div class="box-header">
							<h3 class="box-title">Plan for <code><?=$nextTermName?></code></h3>
						</div>
						<div class="box-body">
						
<div class="alert alert-info">
  <strong>Done.</strong> Now each Class must be manually edited for schedule (room, day, time), and teacher!<!--br><span style="color:red">Bugs:<br>- set course_teachings.start_date and end_date according to semester's setting.</span-->
</div>

<?php
foreach($allMajor as $aMajor){
	echo '<h3><span class="label label-default">'.$aMajor->name.'</span></h3>';
	// $activeStudents = $this->db->query("select u.name, u.batch, u.jalur, u.id, u.role, u.major from stu_status ss join users u on ss.user=u.id where ss.status='Aktif' and ss.action='Disetujui' and u.status='Active' and u.role='Student' and ss.term=$nextTermId and u.major=$aMajor->id")->result(); //get students yg aktif di semeter ini
	// $jalurOfActiveStudents = $this->db->query("select distinct u.jalur from stu_status ss join users u on ss.user=u.id where ss.status='Aktif' and ss.action='Disetujui' and u.status='Active' and u.role='Student' and ss.term=$nextTermId and u.major=$aMajor->id")->result();
	// // echo 'Active students in this major: ';
	// $arrStu = array();
	// $activeBatches = $this->db->query("select distinct u.batch from stu_status ss join users u on ss.user=u.id where ss.status='Aktif' and ss.action='Disetujui' and u.status='Active' and u.role='Student' and ss.term=$nextTermId and u.major=$aMajor->id")->result();
	// if(count($activeBatches)>0){foreach($activeBatches as $aBatch){
	// 	// echo '<br>'.$aBatch->batch.':<br>';
	// 	$activeStudents = $this->db->query("select u.name, u.batch, u.id, u.role, u.major from stu_status ss join users u on ss.user=u.id where ss.status='Aktif' and ss.action='Disetujui' and u.status='Active' and u.role='Student' and ss.term=$nextTermId and u.major=$aMajor->id and u.batch='$aBatch->batch'")->result(); //get students yg aktif di semeter ini
	// 	$tmp = array();
	// 	if(count($activeStudents)>0){foreach($activeStudents as $aStu){
	// 		// echo $aStu->name.', ';
	// 		array_push($tmp,$aStu);
	// 	}}
	// 	$arrStu[$aBatch->batch] = $tmp;
	// }}
	// // echo '<pre>';print_r($arrStu);echo '</pre>';
	// // echo '<br>';
	
	$kur = $this->db->query("select nama, id from kurikulum where major = $aMajor->id and mulai_berlaku <= CURRENT_TIMESTAMP and akhir_berlaku >= CURRENT_TIMESTAMP limit 1")->row();
	if(count($kur)>0){
		// echo '<br>'.$kur->id.'<br>';
		$semesters = '1 or semester=3';
		if($nextTermGanjilGenap=='Genap'){ $semesters = '2 or semester=4';}
		$courses = $this->db->query("select * from courses where kurikulum=$kur->id and (semester=$semesters)")->result();
		
		if(count($courses)>0){
			foreach($courses as $aCourse){
				echo '<br><b>'.$aCourse->name.'</b>'.' ('.$aCourse->code.', '.$aCourse->credits.' SKS, jenis: '.$aCourse->type.') untuk semester '.$aCourse->semester; // echo '<br>Utk thn '.substr($nextTermName,0,4).', sem '.$nextTermGanjilGenap.' -- '.$aCourse->name.' adalah MK utk sem '.$aCourse->semester.'<br>';
				
if($op=='renew'){
				
				$tmpName='1'.$aMajor->code;
				if($nextTermGanjilGenap=='Genap'){$tmpName='2'.$aMajor->code;}
				//code = term now + major code + class id ??
				
				$minBatch = (int)date('Y')-1; //cari mhs aktif yg blm lulus course ini, minimal yg batch nya adalah thn kemarin.
				if($aCourse->semester <= 2){ //ini course untuk thn 1
					$minBatch = (int)date('Y'); //cari mhs aktif yg blm lulus course ini, minimal yg batch nya adalah thn ini.
				}
				
				//obtain list of eligible students
				// $activeStudents = $this->db->query("select u.name, u.jalur, u.id, u.role, u.major from stu_status ss join users u on ss.user=u.id where ss.status='Aktif' and ss.action='Disetujui' and u.status='Active' and u.role='Student' and ss.term=$nextTermId and u.major=$aMajor->id and u.batch >= $minBatch")->result(); //get students yg aktif di semeter ini
				$activeStudents = $this->db->query("select u.id from stu_status ss join users u on ss.user=u.id where ss.status='Aktif' and ss.action='Disetujui' and u.status='Active' and u.role='Student' and ss.term=$nextTermId and u.major=$aMajor->id and u.batch >= $minBatch order by u.jalur asc")->result(); //get students yg aktif di semeter ini
				if(count($activeStudents)==0 ||
				!isset($activeStudents) ||
				$activeStudents==''){ echo 'No eligible students.<br>';continue; } //skip to next course when there is no active students
				$eligibleStu = array();
				foreach($activeStudents as $aStu){
					$totNilai = 0;
					$totNilai = $this->db->query("select format(sum(score * weight/100),2) as totNilai from student_course_score scs join course_scoring cs on scs.course_scoring = cs.id where cs.course_teaching = ".$aCourse->id." and scs.student = ".$aStu->id)->row();
					if(isset($totNilai)){
						if($totNilai->totNilai >= MIN_PASS_SCORE){ continue; } //skip this student because he has passed this course successfully
					}
					array_push($eligibleStu, $aStu->id);
				}
				
				if(count($eligibleStu) > $stuPerBatch){
					$jmlPenyelenggaraan = ceil(count($eligibleStu)/$stuPerBatch);
					$sisa = count($eligibleStu) % $jmlPenyelenggaraan ;
					$jalurs = $this->db->query("select jalur,count(*) as numStu from users where id in (".implode(',',$eligibleStu).") group by jalur order by numStu desc")->result();
					// if(count($jalurs)==1){ //create "normal" grouping
						// $jmlStuDiPenyelenggaraan = array();
					$offset=0;
					$length=$stuPerBatch;
					for($i=1;$i<=$jmlPenyelenggaraan;$i++){
						$jmlStuDiPenyelenggaraan = floor(count($eligibleStu) / $jmlPenyelenggaraan);
						if($sisa>0){ $jmlStuDiPenyelenggaraan++; $sisa--; }
						//------ ga usah: assign student to group @ table student_grouping -------//
						//create penyelenggaraan & assign students
						// if($op=='renew'){
						$groupName = $tmpName.$i.'_'.date('y');
						$tmp1 = $this->db->query("select id from course_teachings ct where course=$aCourse->id and timing=$nextTermId and ct.group='$groupName'")->result();
						if(count($tmp1)>0){
							$this->db->delete('course_teachings', array('course' => $aCourse->id, 'timing' => $nextTermId, 'course_teachings.group' => $groupName)); //delete all of them
							foreach($tmp1 as $t){
								// $this->db->delete('course_scoring', array('course_teaching'=>$t->id)); $this->db->delete('course_teachers', array('course_teaching'=>$t->id)); $this->db->delete('student_course', array('course_teaching'=>$t->id));
								$this->db->delete(array('course_scoring', 'course_teachers', 'student_course'), array('course_teaching'=>$t->id));
							}
						}
						if($aCourse->type=='semester'){
							$this->db->query("INSERT INTO course_teachings (course,timing,course_teachings.group,date_start,date_end) VALUES ($aCourse->id,$nextTermId,'$groupName','$termStartDates','$termEndDates')"); //insert new one  --> autocreate ketauan karena harinya Minggu.
						}else{
							$this->db->query("INSERT INTO course_teachings (course,timing,course_teachings.group) VALUES ($aCourse->id,$nextTermId,'$groupName')"); //insert new one  --> autocreate ketauan karena harinya Minggu.
						}
						$ctId = $this->db->query("select id from course_teachings ct where course=$aCourse->id and timing=$nextTermId and ct.group='$groupName'")->row()->id; //get its ID
						// if(isset($arrStu[$aBatch->batch])){echo '<b>_isset</b>';}
						// if(count($arrStu[$aBatch->batch])>0){echo '<b>_notZero</b>';}
						
						$length = $jmlStuDiPenyelenggaraan;
						$arrStu = array_slice($eligibleStu, $offset, $length);
						$offset += $length;
						$stuToAdd = array();
						foreach($arrStu as $aStu){
							array_push($stuToAdd, array('student' => $aStu, 'course_teaching' => $ctId ));
						} // echo '<pre>';print_r($stuToAdd);echo '</pre>';
						$this->db->insert_batch('student_course', $stuToAdd); //add students from this batch
						// }
					}
					// }else{ //create jalur-aware grouping
					// 	foreach($jalurs as $jalur){ //dari jalur yg jml siswanya terbanyak
					// 		if($jalur->numStu < $stuPerBatch-$stuPerBatchTolerance){ //num of students in this jalur is smallr than ukuran kelas terkecil
					// 			//merge with others
					// 		}elseif($jalur->numStu > $stuPerBatch+$stuPerBatchTolerance){
					// 			//split
					// 		}else{
					// 			//set as one batch
					// 		}
					// 	}
					// 	//create penyelenggaraan
					// 	//assign students
					// }
				}else{ //else, put all students in one penyelenggaraan
					// if($op=='renew'){
					$groupName = $tmpName.'1_'.date('y');
					$tmp1 = $this->db->query("select id from course_teachings ct where course=$aCourse->id and timing=$nextTermId and ct.group='$groupName'")->result();
					if(count($tmp1)>0){
						$this->db->delete('course_teachings', array('course' => $aCourse->id, 'timing' => $nextTermId, 'course_teachings.group' => $groupName)); //delete all of them
						foreach($tmp1 as $t){
							$this->db->delete(array('course_scoring', 'course_teachers', 'student_course'), array('course_teaching'=>$t->id));
					} }
					if($aCourse->type=='semester'){
						$this->db->query("INSERT INTO course_teachings (course,timing,course_teachings.group,date_start,date_end) VALUES ($aCourse->id,$nextTermId,'$groupName','$termStartDates','$termEndDates')"); //insert new one  --> autocreate ketauan karena harinya Minggu.
					}else{
						$this->db->query("INSERT INTO course_teachings (course,timing,course_teachings.group) VALUES ($aCourse->id,$nextTermId,'$groupName')"); //insert new one  --> autocreate ketauan karena harinya Minggu.
					}
					$ctId = $this->db->query("select id from course_teachings where course=$aCourse->id and timing=$nextTermId and course_teachings.group='$groupName'")->row()->id; //get its ID
					$stuToAdd = array();
					foreach($eligibleStu as $aStu){
						array_push($stuToAdd, array('student' => $aStu, 'course_teaching' => $ctId ));
					} // echo '<pre>';print_r($stuToAdd);echo '</pre>';
					$this->db->insert_batch('student_course', $stuToAdd); //add students from this batch
					// }
				}
}

				
				
				$penyelenggaraans = $this->db->query("select ct.id,ct.course,ct.group,r.name,ct.day,ct.time_start,ct.timing from course_teachings ct join room r on r.id = ct.room where ct.timing=$nextTermId and ct.course=$aCourse->id")->result();
				if(count($penyelenggaraans)>0){
					foreach($penyelenggaraans as $penyelenggaraan){
						echo '<br>- <a href="'.base_url('penyelenggaraan2/index/read/'.$penyelenggaraan->id).'" target="_blank">Group '.$penyelenggaraan->group.'</a><br>'; //@'.$penyelenggaraan->name.' '.$penyelenggaraan->day.' '.$penyelenggaraan->time_start.'<br>';
						$studentsInPenyelenggaraan = $this->Coursesmodel->getMhsInPenyelenggaraan($penyelenggaraan->id);
						if(count($studentsInPenyelenggaraan)>0){
							$no=0;
							echo '<table border="1">
							<tr>
								<td><b>No.  </b></td>
								<td><b>NPM  </b></td>
								<td><b>Name </b></td>
								<td><b>Batch</b></td>
								<td><b>Jalur</b></td>
							</tr>';
							foreach($studentsInPenyelenggaraan as $aStu){
								$no++;
								echo '<tr><td>'.$no.'</td><td>'.$aStu->NIP_NPM.'</td><td>'.$aStu->name.'</td><td>'.$aStu->batch.'</td><td>'.$aStu->jalur.'</td></tr>';
							}
							echo '</table>';
						}else{echo 'No student eligible to take this class.<br>';}
						
						//cek jml student, jml komponen nilai, total persentase komponen nilai, jml dosen, total persentase dosen, total jam kelas
						//cek ruangan bentrok
						//cek dosen bentrok
						//cek mhs bentrok
					}
				}else{ echo '<br>&nbsp;&nbsp;Tidak ada penyelenggaraan karena tidak ada student.';}
			}
		}else{echo 'Tidak ada subjek.<br>';}
	}else{ echo '&nbsp;&nbsp;No active curriculum.'; }
}
?>
						</div>
					</div>
				</div>
				
			
  		</div>
  	</section>
<?php $this->load->view('parts/footer'); ?>

