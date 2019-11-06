<?php 
// $at = basename($_SERVER['PHP_SELF'], ".php");
$at = $this->uri->segment(1);
$at2 = $this->uri->segment(2);
$ro=$this->session->role;
?>
<ul class="sidebar-menu">
		<li class="<?= ($at == 'dashboard') ? 'active':''; ?>"><a href="<?=base_url('dashboard');?>"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
		<!--li class="header">Menu <?php echo CI_VERSION; ?></li-->

		<?php if($ro=='Lecturer'){ ?>
		<li class="<?= ($at=='penyelenggaraan2') ? 'active':''; ?>"><a href="<?=base_url('penyelenggaraan2');?>"><i class="fa fa-dashboard"></i> <span>My Classes</span></a></li>
		<?php } ?>
		
		<?php if($ro=='Student'||$ro=='Alumni'){ ?>
		<li class="<?= (($at=='student'&&$at2=='perkuliahan')||$at=='penyelenggaraan2') ? 'active':''; ?>"><a href="<?=base_url('student/perkuliahan/'.$this->session->id);?>"><i class="fa fa-dashboard"></i> <span>Academic Performance</span></a></li>
		<li class="<?= (($at=='student'&&$at2=='index')) ? 'active':''; ?>"><a href="<?=base_url('student/index/read/'.$this->session->id);?>"><i class="fa fa-dashboard"></i> <span>Biodata</span></a></li>
		<li class="<?= (($at=='student'&&$at2=='pembayaran')) ? 'active':''; ?>"><a href="<?=base_url('student/pembayaran/'.$this->session->id);?>"><i class="fa fa-dashboard"></i> <span>Payments</span></a></li>
		<li class="<?= (($at=='student'&&$at2=='assignment')) ? 'active':''; ?>"><a href="<?=base_url('student/assignment/'.$this->session->id);?>"><i class="fa fa-dashboard"></i> <span>Assignments</span></a></li>
		<?php } ?>
		
		<?php if(in_array($ro,array('Admin','Manager','SAA'))){ ?>
		<li class="<?= ($at == 'rooms') ? 'active':''; ?>"><a href="<?php echo base_url().'rooms'?>"><i class="fa fa-building"></i><span>Rooms</span></a></li>
		<?php } ?>
		
		<?php if(in_array($ro,array('Admin','Manager','SAA','Marketing'))){ ?>
		<li class="treeview <?= ($at=='student'||$at == 'users') ? 'active':''; ?>"><a href="#"><i class="fa fa-user"></i><span>Users</span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>
			<ul class="treeview-menu">
				<!--li><a href="<?=base_url('users/all');?>"><i class="fa fa-group"></i>All Users</a></li-->
				<?php if($ro=='Manager'){ ?>
				<li><a href="<?=base_url('users');?>"><i class="fa fa-group"></i>Staffs</a></li>
				<?php } ?>
				<?php if($ro!='Marketing'){ ?>
				<li><a href="<?=base_url('users/dosen');?>"><i class="fa fa-group"></i>Lecturers</a></li>
				<li><a href="<?=base_url('student');?>"><i class="fa fa-user"></i>Students</a></li>
				<?php } ?>
				<li><a href="<?=base_url('users/candidate');?>"><i class="fa fa-user"></i>Student Candidate</a></li>
				<li><a href="<?=base_url('users/rep');?>"><i class="fa fa-user"></i>School Representative</a></li>
				<li><a href="<?=base_url('users/alumni');?>"><i class="fa fa-user"></i>Alumni</a></li>
			</ul>
		</li>
		<?php } ?>

		<?php if(in_array($ro,array('Admin','Manager','SAA','Finance'))){ ?>
		<li class="treeview <?= ($at=='timing') ? 'active':''; ?>"><a href="#"><i class="fa fa-calendar"></i><span>Semesters &amp; Dates</span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>
			<ul class="treeview-menu">
				<li><a href="<?=base_url('timing');?>"><i class="fa fa-calendar"></i>Semester's Dates</a></li>
				<li><a href="<?=base_url('timing/calendar');?>"><i class="fa fa-clipboard-list"></i>Master Calendar</a></li>
			</ul>
		</li>
		<?php } ?>
		
		<?php if(in_array($ro,array('Admin','Manager','SAA'))){ ?>
		<li class="<?= ($at == 'jurusan') ? 'active':''; ?>"><a href="<?php echo base_url().'jurusan'?>"><i class="fa fa-table"></i><span>Major</span></a></li>
		<li class="<?= ($at == 'kurikulum') ? 'active':''; ?>"><a href="<?php echo base_url().'kurikulum'?>"><i class="fa fa-table"></i><span>Curriculum</span></a></li>
		<li class="<?= ($at == 'courses') ? 'active':''; ?>"><a href="<?php echo base_url().'courses'?>"><i class="fa fa-table"></i><span>Courses</span></a></li>
		<li class="<?= ($at == 'penyelenggaraan2') ? 'active':''; ?>"><a href="<?php echo base_url().'penyelenggaraan2'?>"><i class="fa fa-table"></i><span>Classes</span></a></li>
		<?php } ?>
		
		<?php if(in_array($ro,array('Admin','Manager','SAA','Finance'))){ ?>
		<li class="treeview <?= ($at=='tagihan') ? 'active':''; ?>"><a href="#"><i class="fa fa-user"></i><span>Student's Duty</span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>
			<ul class="treeview-menu">
				<?php if(in_array($ro,array('Admin','Manager','Finance'))){ ?>
				<li><a href="<?=base_url('tagihan');?>"><i class="fa fa-money"></i>Fees</a></li>
				<?php }if(in_array($ro,array('Admin','Manager','SAA'))){ ?>
				<li><a href="<?=base_url('tagihan/tugas');?>"><i class="fa fa-tasks"></i>Assignments</a></li>
				<?php } ?>
			</ul>
		</li>
		<?php } ?>
		
		<?php if(in_array($ro,array('Admin','Manager','SAA'))){ ?>
		<li class="<?= ($at == 'status') ? 'active':''; ?>"><a href="<?php echo base_url().'status'?>"><i class="fa fa-arrows"></i><span>Permintaan Ubah Status</span></a></li>
		<li class="<?= ($at == 'status') ? 'active':''; ?>"><a href="<?php echo base_url().'status/index/add'?>"><i class="fa fa-arrows"></i><span>Ubah Status</span></a></li>
		<?php } ?>

		<li class="<?= ($at == 'panduan') ? 'active':''; ?>"><a href="<?=base_url('panduan');?>"><i class="fa fa-circle-o"></i> <span>User Manual</span></a></li> 

</ul>