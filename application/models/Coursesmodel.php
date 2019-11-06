<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Coursesmodel extends CI_Model {
	public function getPrereq($c) { //input must be course object
		$getAll = $this->db->query('SELECT c.id, c.name, c.code, c.credits
			FROM prerequisites p
			join courses c on c.id=p.required_course
			where p.course = '.$c->id.' and p.kurikulum = '.$c->kurikulum);
		return $getAll->result();
	}
	public function getByCurriculum($kurId){  //Ruki 4/7/2019-6:55
		$q = $this->db->query('SELECT c.id, c.name, c.code, c.credits, c.type
			FROM courses c
			where c.kurikulum = '.$kurId);
		return $q->result();
	}
	public function getPrereqById($courseId){
		$q = $this->db->query('SELECT kurikulum from courses where id = '.$courseId);
		$row = $q->row();
		
		$q = $this->db->query('SELECT c.id, c.name, c.code, c.credits
			FROM prerequisites p
			join courses c on c.id=p.required_course
			where p.course = '.$courseId.' and p.kurikulum = '.$row->kurikulum);
		return $q->result();
	}
	public function getNameAndCode($courseId){ //course name and kurikulum code
		$getAll = $this->db->query('SELECT c.name, k.kode
			FROM courses c
			join kurikulum k on k.id=c.kurikulum
			where c.id = '.$courseId);
		$row = $getAll->row();
		$nameAndCode = $row->name.' ('.$row->kode.')';
		return $nameAndCode;
	}
	public function getKurikulum($courseId){
		$q = $this->db->query('SELECT k.id, k.nama FROM courses c JOIN kurikulum k ON k.id = c.kurikulum where c.id = '.$courseId);
		return $q->row();
	}
	public function getPenyelenggaraanById($courseId){ //get all penyelenggaraan of a course by course id
		$q = $this->db->query("select t.id,CONCAT(tm.year_start, '/' ,tm.year_start+1 , ' ' , tm.semester) AS term,t.day,t.time_start,r.name as room,r.id as room_id from course_teachings t 
		join room r on r.id = t.room 
		join timing tm on t.timing = tm.id 
		where t.course = ".$courseId." 
		order by tm.year_start asc, tm.semester desc");
		$r = array();
		$i = 0;
		foreach($q->result() as $penyelenggaraan){
			$r[$i]['id']=$penyelenggaraan->id;
			$r[$i]['term']=$penyelenggaraan->term;
			$r[$i]['room']=$penyelenggaraan->room;
			$r[$i]['room_id']=$penyelenggaraan->room_id;
			$r[$i]['day']=$penyelenggaraan->day;
			$r[$i]['time_start']=$penyelenggaraan->time_start;
			$r[$i]['teachers']=array();
			$q = $this->db->query('select u.name, u.title_front, u.title_back, t.load, t.id, u.id as uid, u.email
				from course_teachers t
				join users u on u.id = t.teacher
				where course_teaching = '.$penyelenggaraan->id
			);
			$ii=0;
			foreach($q->result() as $teacher){
				$r[$i]['teachers'][$ii]['name']=$teacher->name;
				$r[$i]['teachers'][$ii]['title_front']=$teacher->title_front;
				$r[$i]['teachers'][$ii]['title_back']=$teacher->title_back;
				$r[$i]['teachers'][$ii]['load']=$teacher->load;
				$r[$i]['teachers'][$ii]['teacher_id']=$teacher->id;
				$r[$i]['teachers'][$ii]['uid']=$teacher->uid;
				$r[$i]['teachers'][$ii]['email']=$teacher->email;
				$ii++;
			}
			$i++;
		}
		return $r;
	}
	public function getTeachersInPenyelenggaraan($pId){
		$q = $this->db->query('select u.name, u.title_front, u.title_back, t.load, t.id, u.email, u.id as uid, u.NIP_NPM
			from course_teachers t
			join users u on u.id = t.teacher
			where course_teaching = '.$pId
		);
		$ii=0;
		$r = array();
		foreach($q->result() as $teacher){
			$r[$ii]['name']=$teacher->name;
			$r[$ii]['uid']=$teacher->uid;
			$r[$ii]['title_front']=$teacher->title_front;
			$r[$ii]['title_back']=$teacher->title_back;
			$r[$ii]['load']=$teacher->load;
			$r[$ii]['teacher_id']=$teacher->id;
			$r[$ii]['email']=$teacher->email;
			$r[$ii]['NIP_NPM']=$teacher->NIP_NPM;
			$ii++;
		}
		return $r;
	}
	public function countMhsByPenyelenggaraan($pId,$op='all',$batch=0){ //all, failed, pass
		return $this->db->where('course_teaching',$pId)->count_all_results('student_course');
	}
	public function getMhsInPenyelenggaraan($pId){
		$q = $this->db->query('select sc.id as sc_id, u.id as uid, u.name, u.NIP_NPM, u.batch, u.jalur, u.major, u.photo, u.gender, u.email
			from student_course sc
			join users u on u.id = sc.student
			where course_teaching = '.$pId.'
			order by u.batch asc, u.id asc'
		);
		return $q->result(); 
	}
	
	//matakuliah yang diambil student A, beserta nilai akhirnya
	public function getCoursesAndScoresByStuIdOld($stuId){
		$sql = "select ct.id, CONCAT(tm.year_start, '/' ,tm.year_start+1 , ' ' , tm.semester) AS term, c.name, k.kode as kurikulum, c.code, c.credits, c.type
			from student_course sc
			join course_teachings ct on sc.course_teaching = ct.id
			join courses c on ct.course = c.id
			join timing tm on tm.id = ct.timing
			join kurikulum k on k.id = c.kurikulum
			where sc.student = ".$stuId;
		return $this->db->query($sql)->result_array();
	}
	public function getCoursesAndScoresByStuId($stuId){
		$sql = "select ct.id, CONCAT(tm.year_start, '/' ,tm.year_start+1 , ' ' , tm.semester) AS term, CONCAT(c.name,' - class: ',ct.group) as name, c.id as cId, k.kode as kurikulum, c.code, c.credits, c.type, sc.student as stuId
			from student_course sc
			join course_teachings ct on sc.course_teaching = ct.id
			join courses c on ct.course = c.id
			join timing tm on tm.id = ct.timing
			join kurikulum k on k.id = c.kurikulum
			where sc.student = ".$stuId;
		$mks = $this->db->query($sql)->result_array();
		$i=0;
		foreach($mks as $mk){
			$q = $this->db->query("select format(sum(score * weight/100),2) as totNilai from student_course_score scs join course_scoring cs on scs.course_scoring = cs.id where cs.course = ".$mk['cId']." and scs.student = ".$mk['stuId']);
			$mks[$i]['nilai'] = $q->row()->totNilai; //potong, nilai huruf ??
			$i++;
		}
		return $mks;
	}
	
	
	public function getKomponenByCourseId($idPenyelenggaraan){
		$q = $this->db->query("SELECT c.id, c.name, c.weight, c.passing_score
			FROM course_scoring c
			where c.course = (select course from course_teachings where id=$idPenyelenggaraan)");
			
		return $q->result();
	}
	
	
	public function getAllMajor(){
		$q = $this->db->query('SELECT id, name, code FROM major');
		return $q->result();
	}
	public function getAllKurikulum($major=''){
		if($major!=''){
			$q = $this->db->query('SELECT id, nama, kode, FROM kurikulum WHERE major = '.$major);
		}else{
			$q = $this->db->query('SELECT id, nama, kode, major FROM kurikulum');
		}
		return $q->result();
	}
	public function getAllTerms($id=''){
		$txt = "SELECT id, CONCAT(year_start, '/' ,year_start+1 , ' ' , semester) AS term from timing ";
		if($id!=''){
			$txt .= " WHERE id in (".implode(',',$id).") ";
		}
		$q = $this->db->query($txt." ORDER BY year_start ASC, semester DESC");
		// $q = $this->db->query('SELECT distinct(term) FROM course_teachings ORDER BY term ASC');
		return $q->result();
	}
	public function getAllRoomsInPenyelenggaraan(){
		$q = $this->db->query('SELECT id,name FROM room WHERE id IN (SELECT distinct(room) FROM course_teachings)');
		return $q->result();
	}
	public function getAllTeachersInPenyelenggaraan(){
		$q = $this->db->query("SELECT id,name FROM users WHERE status = 'Active' AND role = 'Lecturer'");
		return $q->result();
	}
	public function getTeachingsByMajor($major){
		// $q = $this->db->query("select id from course_teachings where course in (select id from courses where kurikulum in (select id from kurikulum where major = $major))");
		// return $q->result();
		$q = $this->db->query("select GROUP_CONCAT(id) as id from course_teachings where course in (select id from courses where kurikulum in (select id from kurikulum where major = $major))");
		return $q->row();
	}
	public function getNilaiByPenyelenggaraan($idPenyelenggaraan, $stuId=''){
		$q = $this->db->query("select id, name, weight, passing_score from course_scoring where course = (select course from course_teachings where id=$idPenyelenggaraan)");
		$komponens = $q->result();
		
		$tx = "select scs.id as student_course_score_id, scs.score, scs.student as student_id, cs.name as komponen, cs.weight, cs.passing_score, u.name, u.NIP_NPM as npm
			from student_course_score scs
			join course_scoring cs on scs.course_scoring = cs.id
			join users u on u.id = scs.student
			where cs.course = (select course from course_teachings where id=$idPenyelenggaraan) ";
		if($stuId!=''){
			$tx.=" and u.id = $stuId ";
		}
		$q = $this->db->query($tx."order by student_id, scs.course_scoring asc");
		$res = $q->result();
		$r = array();
		foreach($komponens as $komp){
			foreach($res as $stuScore){
				$r[$stuScore->student_id]['student_id']=$stuScore->student_id;
				$r[$stuScore->student_id]['npm']=$stuScore->npm;
				$r[$stuScore->student_id]['name']=$stuScore->name;
				// $r[$stuScore->student_id]['student_course_score_id']=$stuScore->student_course_score_id;
				// $r[$stuScore->student_id]['course_scoring_id']=$stuScore->course_scoring_id;
				if($komp->name == $stuScore->komponen){
					$r[$stuScore->student_id][$komp->name.'_id'] = $stuScore->student_course_score_id;
					$r[$stuScore->student_id][$komp->name] = $stuScore->score;
					if(array_key_exists('tot',$r[$stuScore->student_id])){
						$r[$stuScore->student_id]['tot'] += $stuScore->score * $komp->weight / 100;
					}else{
						$r[$stuScore->student_id]['tot'] = $stuScore->score * $komp->weight / 100;
					}
					// echo 'stuId: '.$stuScore->student_id .'<br>Score '.$komp->name.': '.$stuScore->score.' x '.$komp->weight.' / 100 = '.$stuScore->score * $komp->weight / 100 .'<br>';
				}
			}
		}
		// die();
		return $r;
	}
	public function getCourseNameAndWhenItIsHeldByPenyelenggaraanId($pId){
		$q = $this->db->query("select code, name, nama as kurikulum, CONCAT(tm.year_start, '/' ,tm.year_start+1 , ' ' , tm.semester) AS term
					from course_teachings 
					join courses on courses.id = course_teachings.course 
					join kurikulum on kurikulum.id = courses.kurikulum
					join timing tm on tm.id = course_teachings.timing
					where course_teachings.id = $pId");
		$r = $q->row();
		return $r->name.' - '.$r->code.' ('.$r->kurikulum.') @ '.$r->term;
	}
	
	public function canThisUserEditNilai ($ses, $penyelenggaraanId){
		$q = $this->db->query("select * from users where
					username = '$ses->username' and
					name = '$ses->name' and
					id = $ses->id and
					role = '$ses->role' and
					email = '$ses->email' and
					photo = '$ses->photo'
					");
		if($q->num_rows() == 1){
			$res = $q->result();
			foreach($res as $r){
				if($r->status != 'Active'){ return 0; }
				if($r->role == 'Admin' || $r->role == 'SAA'){ return 1; }
				if($r->role == 'Lecturer'){
					$z = $this->db->query("select id from course_teachers where teacher = $r->id and course_teaching = $penyelenggaraanId");
					if($z->num_rows() == 1){ return 1 ;}else{ return 0; }
				}else{ return 0; }
			}
		}else{
			return 0;
		}
	}
	public function doEditNilai ($s, $stuId, $csId, $scsId, $log){
		$this->db->trans_start();
		for($i=0;$i<count($s);$i++){
			if($scsId[$i] == 0){
				if($s[$i]!=''){
					$this->db->query("INSERT INTO `student_course_score` (`student`, `course_scoring`, `score`, `date_modified`, `edit_log`) VALUES ($stuId[$i], $csId[$i], $s[$i], '".date('Y-m-d h:i:s')."', '$log');");
				}
			}else{
				$this->db->query("UPDATE `student_course_score` SET `score` = $s[$i], `date_modified` = '".date('Y-m-d h:i:s')."', `edit_log` = '$log' WHERE `student` = $stuId[$i] AND `course_scoring` = $csId[$i];");
			}
		}
		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE){
			return false; //transaction failed
		}else{
			return true;
		}
	}
	public function getDaysOfPenyelenggaraan($penyelenggaraanId){
		$type = $this->db->query("select type from courses c join course_teachings ct on ct.course = c.id where ct.id=$penyelenggaraanId")->row()->type;
		$workDays = array('0000-00-00');
		if($type=='quarter'){
			$r0 = $this->db->query("select date_start, date_end from course_teachings where id=$penyelenggaraanId")->row();
			$r1 = $this->db->query("select id,day,time_start,time_end,room from course_teachings_quarter ctq where course_teaching=$penyelenggaraanId")->result();
			$libur = $this->db->query("select * from calendar where no_class='Yes' and ((date_start between '$r0->date_start' and '$r0->date_end') or (date_end between '$r0->date_start' and '$r0->date_end'))")->result(); //event liburan yang beririsan
			$days = array();
			$freeDays = array();
			foreach($r1 as $r){
				switch($r->day){
					case 'Selasa': $d = 'Tuesday'; break;
					case 'Rabu': $d = 'Wednesday'; break;
					case 'Kamis': $d = 'Thursday'; break;
					case 'Jumat': $d = 'Friday'; break;
					case 'Sabtu': $d = 'Saturday'; break;
					case 'Minggu': $d = 'Sunday'; break;
					default: $d = 'Monday';
				}
				for($i = strtotime($d, strtotime($r0->date_start)); $i <= strtotime($r0->date_end); $i = strtotime('+1 week', $i)){
					array_push($days, date('Y-m-d', $i));
				}
				foreach($libur as $l){
					for($i = strtotime($d, strtotime($l->date_start)); $i <= strtotime($l->date_end); $i = strtotime('+1 week', $i)){
						array_push($freeDays, date('Y-m-d', $i));
					}
				}
			}
			$workDays = array_diff($days,$freeDays);
			asort($workDays);
		}elseif($type=='semester'){
			$r = $this->db->query("select day, start_date, end_date from course_teachings join timing on timing.id = course_teachings.timing where course_teachings.id=$penyelenggaraanId")->row();
			switch($r->day){
				case 'Selasa': $d = 'Tuesday'; break;
				case 'Rabu': $d = 'Wednesday'; break;
				case 'Kamis': $d = 'Thursday'; break;
				case 'Jumat': $d = 'Friday'; break;
				case 'Sabtu': $d = 'Saturday'; break;
				case 'Minggu': $d = 'Sunday'; break;
				default: $d = 'Monday';
			}
			$days = array();
			for($i = strtotime($d, strtotime($r->start_date)); $i <= strtotime($r->end_date); $i = strtotime('+1 week', $i)){
				array_push($days, date('Y-m-d', $i));
			}
			$libur = $this->db->query("select * from calendar where no_class='Yes' and ((date_start between '$r->start_date' and '$r->end_date') or (date_end between '$r->start_date' and '$r->end_date'))")->result(); //event liburan yang beririsan
			$freeDays = array();
			foreach($libur as $l){
				for($i = strtotime($d, strtotime($l->date_start)); $i <= strtotime($l->date_end); $i = strtotime('+1 week', $i)){
					array_push($freeDays, date('Y-m-d', $i));
				}
			}
			$workDays = array_diff($days,$freeDays);  //e.g.: '2000-02-13','2000-02-14'
		}
		// echo '<pre>';print_r($days);print_r($freeDays);print_r($workDays);echo '</pre>';die();
		return $workDays;
	}
	// public function saveAbsensi($penyelenggaraanId, $tgl, $uids, $notes, $teacher){
	public function saveAbsensi($penyelenggaraanId, $tgl, $uids, $notes){
		$usrIds = array_keys($uids); 
		$numUsr = count($uids);
		//students
		for($i=0;$i<$numUsr;$i++){
			$q = $this->db->query("select id from attendance where course_teaching = ".$penyelenggaraanId." and date = '".$tgl."' and user = ".$usrIds[$i])->row(); //cek apakah sudah ada absennya atau blm
			if(isset($q->id)){ //jika sudah: update
				$res = $this->db->query("UPDATE attendance SET attendCode = ".$uids[$usrIds[$i]].", note = '".$notes[$usrIds[$i]]."' WHERE id = $q->id");
				if(!$res){ $e='Error when updating absensi at instance: '.$q->id;break; }
			}else{ //jika belum: insert
				$res = $this->db->query("INSERT INTO attendance (course_teaching, date, user, attendCode, note) VALUES ($penyelenggaraanId, '$tgl', ".$usrIds[$i].", ".$uids[$usrIds[$i]].", '".$notes[$usrIds[$i]]."');");
				if(!$res){ $e='Error when saving absensi at instance: '.$penyelenggaraanId.'_'.$tgl.'_'.$usrIds[$i]; break; }
			}
		}
		//teachers
		// $q = $this->db->query("select id from attendance where course_teaching = ".$penyelenggaraanId." and date = '".$tgl."' and user = ".$teacher; //cek apakah sudah ada absennya atau blm
		// if(isset($q->id)){ //jika sudah: update
		// 	$res = $this->db->query("UPDATE attendance SET attendCode = ".$uids[$usrIds[$i]].", note = '".$notes[$usrIds[$i]]."' WHERE id = $q->id");
		// 	if(!$res){ $e='Error when updating absensi at instance: '.$q->id;break; }
		// }else{ //jika belum: insert
		// 	$res = $this->db->query("INSERT INTO attendance (course_teaching, date, user, attendCode, note) VALUES ($penyelenggaraanId, '$tgl', ".$usrIds[$i].", ".$uids[$usrIds[$i]].", '".$notes[$usrIds[$i]]."');");
		// 	if(!$res){ $e='Error when saving absensi at instance: '.$penyelenggaraanId.'_'.$tgl.'_'.$usrIds[$i]; break; }
		// }
		
		if(isset($e)){
			return $e;
		}else{
			return true;
		}
	}
	public function getAttendancePerPenyelenggaraan($penyelenggaraanId, $date){
		$q = $this->db->query("select user, attendCode, note from attendance where course_teaching = $penyelenggaraanId and date = '$date'");
		return $q->result();
	}
	public function getTeachingsByKurikulum($kurId){
		$q = $this->db->query("select group_concat(id) as id from course_teachings where course in (select id from courses where kurikulum = $kurId)");
		return $q->row();
	}
	public function getViewPenyelenggaraan($major="", $kurikulum="", $room="", $term="", $teacher=""){
		$queryString = "
			select 
			ct.id as ctId,
			c.type,
			ct.course as courseId,
			ct.room as roomId,
			ct.day,
			ct.time_start,
			ct.date_start,
			ct.date_end,
			ct.group as class,
			ct.timing as termId,
			(SELECT GROUP_CONCAT(name) FROM users where id in (select teacher from course_teachers where course_teaching = ct.id)) as teacher,
			(SELECT count(*) FROM student_course where course_teaching = ct.id) as student,
			concat(c.code,' - ',c.name,' (',c.credits,' SKS)') as course,
			concat(t.year_start,'/',t.year_start+1 ,' ',t.semester) as term,
			concat(r.name,' (capacity: ',r.capacity,')') as room
			from course_teachings ct
			join courses c on c.id = ct.course
			join timing t on t.id = ct.timing
			join room r on r.id = ct.room
			join course_teachers ctr on ct.id=ctr.course_teaching
		";
		if($major!="" || $kurikulum!="" || $room!="" || $term!="" || $teacher!="" ){
			$queryString .= " where ";
			$tmp = array();
			if($major!=""){
				$maj = $this->getTeachingsByMajor($major)->id;
				if($maj==""){$maj=0;}
				array_push($tmp," ct.id in (".$maj.") ");
			}
			if($kurikulum!=""){
				$kur = $this->getTeachingsByKurikulum($kurikulum)->id;
				if($kur==""){$kur=0;}
				array_push($tmp," ct.id in (".$kur.") ");
			}
			if($room!=""){
				array_push($tmp," r.id = ".$room." ");
			}
			if($term!=""){
				array_push($tmp," t.id = ".$term." ");
			}
			if($teacher!=""){
				array_push($tmp," ctr.teacher = ".$teacher." ");
			}
			$queryString .= join(" and ",$tmp);
		}
		
		// if($major!="" && $kurikulum!=""){
		// 	$kur = $this->getTeachingsByKurikulum($kurikulum)->id;
		// 	if($kur==""){$kur=0;}
		// 	$maj = $this->getTeachingsByMajor($major)->id;
		// 	if($maj==""){$maj=0;}
		// 	$queryString .= " where ct.id in (".$maj.") and ct.id in (".$kur.") ";
		// }elseif($major!=""){
		// 	$maj = $this->getTeachingsByMajor($major)->id;
		// 	if($maj==""){$maj=0;}
		// 	$queryString .= " where ct.id in (".$maj.") ";
		// }elseif($kurikulum!=""){
		// 	$kur = $this->getTeachingsByKurikulum($kurikulum)->id;
		// 	if($kur==""){$kur=0;}
		// 	$queryString .= " where ct.id in (".$kur.") ";
		// }
		
		$q = $this->db->query($queryString);
		$res = $q->result(); // echo '<pre>'; print_r($res); die();
		return $res;
	}
	public function getCurrentTerm(){
		$q = $this->db->query("select *,concat(year_start,'/',year_start+1 ,' ',semester) as name from timing where start_date <= CURRENT_TIMESTAMP and end_date >= CURRENT_TIMESTAMP limit 1");
		$r1 = $q->row();
		if(count($r1)==0){
			$q = $this->db->query("select *,concat(year_start,'/',year_start+1 ,' ',semester) as name from timing where end_date <= CURRENT_TIMESTAMP order by end_date desc limit 1");
			$r1 = $q->row();
		}
		return $r1;
	}
	public function getLastTerm(){
		$q = $this->db->query("select * from timing where end_date < CURRENT_TIMESTAMP order by end_date desc limit 1");
		return $q->row();
	}
	public function getNextTerm(){
		$q = $this->db->query("select *,concat(year_start,'/',year_start+1 ,' ',semester) as name from timing where start_date >= CURRENT_TIMESTAMP order by start_date asc limit 1");
		return $q->row();
	}
	public function getLatestKurIdInMajor($major){
		$q = $this->db->query("SELECT id from kurikulum where major=$major order by id desc limit 1");
		$r = $q->row();
		if(count($r)>0){
			return $r->id;
		}else{
			return 0;
		}
		// echo '<pre>';
		// print_r($r->id);
		// die();
	}
	// public function getViewKurikulum($major="",$term=""){
	// 	$queryString = "
	// 		select 
	// 		ct.id as ctId,
	// 		ct.course as courseId,
	// 		ct.room as roomId,
	// 		ct.day,
	// 		ct.time_start,
	// 		ct.timing as termId,
	// 		(SELECT GROUP_CONCAT(name) FROM users where id in (select teacher from course_teachers where course_teaching = ct.id)) as teacher,
	// 		(SELECT count(*) FROM student_course where course_teaching = ct.id) as student,
	// 		concat(c.code,' - ',c.name,' (',c.credits,' SKS, ',c.type,')') as course,
	// 		concat(t.year_start,'/',t.year_start+1 ,' ',t.semester) as term,
	// 		concat(r.name,' (kapasitas: ',r.capacity,' orang)') as room
	// 		from course_teachings ct
	// 		join courses c on c.id = ct.course
	// 		join timing t on t.id = ct.timing
	// 		join room r on r.id = ct.room
	// 	";
	// 	if($major!="" && $term!=""){
	// 		$kur = $this->getTeachingsByKurikulum($term)->id;
	// 		if($kur==""){$kur=0;}
	// 		$maj = $this->getTeachingsByMajor($major)->id;
	// 		if($maj==""){$maj=0;}
	// 		$queryString .= " where ct.id in (".$maj.") and ct.id in (".$kur.") ";
	// 	}elseif($major!=""){
	// 		$maj = $this->getTeachingsByMajor($major)->id;
	// 		if($maj==""){$maj=0;}
	// 		$queryString .= " where ct.id in (".$maj.") ";
	// 	}elseif($term!=""){
	// 		$kur = $this->getTeachingsByKurikulum($term)->id;
	// 		if($kur==""){$kur=0;}
	// 		$queryString .= " where ct.id in (".$kur.") ";
	// 	}
	// 	
	// 	$q = $this->db->query($queryString);
	// 	$res = $q->result(); // echo '<pre>'; print_r($res); die();
	// 	return $res;
	// }
	
	public function getRingkasan($stuId){
		$sql = 'select sc.student, ct.course, c.name, c.kurikulum, c.type
			from student_course sc 
			join course_teachings ct on ct.id = sc.id
			join courses c on ct.course = c.id
			where sc.student = '.$stuId;
		return $this->db->query($sql)->result_array();
	}
	// public function getTranskip($stuId){
	// 	$sql = 'select scs.id, c.name, c.kurikulum, c.credits, ct.teacher, scs.course_scoring, scs.score
	// 		from student_course_score scs
	// 		join course_teachers ct on ct.id = scs.id
	// 		join courses c on c.id = scs.id
	// 		where scs.student = '.$stuId;
	// 	return $this->db->query($sql)->result_array();
	// }
	public function getStatusAkademik($stuId){
		$sql = 'select u.photo, u.name, u.NIP_NPM, u.role, u.status, m.name
			from users u 
			join major m on m.id = u.major
			where u.id ='.$stuId;
		return $this->db->query($sql)->result_array();
	}
	/*public function getPembayaran($stuId){
		$sql = ' '.$stuId;
		return $this->db->query($sql)->result_array();
	}*/

	public function getCoursesforStudent($stuId){
		$sql = 'select ct.id, ct.term, ct.year, c.name, c.kurikulum, c.code, c.credits, c.type
			from student_course sc
			join course_teachings ct on sc.course_teaching = ct.id
			join courses c on ct.course = c.id
			where sc.student = '.$stuId;
		return $this->db->query($sql)->result_array();
	}
	// public function getCoursesInKurikulum($kurId){
	// 	$sql = 'select ct.id, ct.term, ct.year, c.name, c.kurikulum, c.code, c.credits, c.type
	// 		from student_course sc
	// 		join course_teachings ct on sc.course_teaching = ct.id
	// 		join courses c on ct.course = c.id
	// 		where sc.student = '.$stuId;
	// 	return $this->db->query($sql)->result_array();
	// }
	
	////canEditScore: apakah orang ini bisa ngedit nilai di class cId jika wkt yg diperbolehkan adalah max 14 hari setelah akhir masa perkuliahan?
	public function canEditScore($ctId,$teacherId,$dayLimit=-1){ //dayLimit: berapa hari setelah date_end yang masih diperbolehkan untuk edit nilai. -1 bila tidak ada limit
		if($dayLimit>0){
			$miliknya = $this->db->query("select ct.id from course_teachers ctr join course_teachings ct on ct.id = ctr.course_teaching where ctr.teacher=$teacherId and date_start < CURRENT_TIMESTAMP and date_end > CURRENT_TIMESTAMP+$dayLimit;")->result_array();
		}else{
			$miliknya = $this->db->query("select course_teaching from course_teachers where teacher=$teacherId")->result_array();
		}
		if(in_array($ctId,array_column($miliknya,'course_teaching'))){
			return true;
		}else{
			return false;
		}
	}
	public function gClassEndDate($classId){ //g for get
		return strtotime($this->db->query("select date_end from course_teachings where id=$classId")->row()->date_end);
	}
}
