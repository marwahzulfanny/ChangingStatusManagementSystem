<div class="nav-tabs-custom">
	<ul class="nav nav-tabs">
	<?php $ar = $this->uri->segment_array(); 
		if($ar[2]=='index'){$pkey = $ar[4];}
		elseif($ar[2]=='perkuliahan'){$pkey = $ar[3];}
		elseif($ar[2]=='pembayaran'){$pkey = $ar[3];}
	?>
		<li class="<?= ($activePage == 'student/index/read/'.$pkey) ? 'active':''; ?>"><a href="<?=base_url('student/index/read/'.$pkey);?>">Biodata</a></li>
		<!--li class="<?= ($activePage == 'student/p_ringkasan/'.$pkey) ? 'active':''; ?>"><a href="<?=base_url('student/ringkasan/'.$pkey);?>" data-toggle="tab">Ringkasan</a></li-->
		<li class="<?= ($activePage == 'student/perkuliahan/'.$pkey) ? 'active':''; ?>"><a href="<?=base_url('student/perkuliahan/'.$pkey);?>">Academic Performance</a></li>
		<li class="<?= ($activePage == 'student/pembayaran/'.$pkey) ? 'active':''; ?>"><a href="<?=base_url('student/pembayaran/'.$pkey);?>">Payments</a></li>
		<li class="<?= ($activePage == 'student/assignment/'.$pkey) ? 'active':''; ?>"><a href="<?=base_url('student/assignment/'.$pkey);?>">Assignments</a></li>
		<!--li class="<?= ($activePage == 'student/statusAkademis/'.$pkey) ? 'active':''; ?>"><a href="<?=base_url('student/statusAkademis/'.$pkey);?>">Status Akademis</a></li-->
		<!--li class="<?= ($activePage == 'student/transkrip/'.$pkey) ? 'active':''; ?>"><a class="btn btn-primary" href="<?=base_url('student/transkrip/'.$pkey);?>">Transkrip</a></li-->
	</ul>
</div>
