<?php $this->load->view('parts/header'); ?>
<?php $activePage = basename($_SERVER['PHP_SELF'], ".php");?>
   <!-- Main content -->
    <section class="content">
      <div class="row">
	      <div class="col-md-12">
					<?php if($this->session->role=='Student'||$this->session->role=='Alumni'){}else{
						include('/parts/menu_siswa.php');
					} ?>
		      <div class="box">
		      	<div class="box-body">
						<?php echo $output->output; ?>
						</div>
					</div>
				
					
					<!--<div class="nav-tabs-custom">
						<ul class="nav nav-tabs">
						  <li class="<?= ($activePage == 'student/index/read/'.$pkey) ? 'active':''; ?>"><a href="<?=base_url('student/index/read/'.$pkey);?> data-toggle="tab">Biodata</a></li>
						  <li class="<?= ($activePage == 'student/index/read/'.$pkey) ? 'active':''; ?>"><a href="<?=base_url('student/index/read/'.$pkey);?> data-toggle="tab"><a href="#ringkasan" data-toggle="tab">Ringkasan</a></li>
						  <li class="<?= ($activePage == 'student/index/read/'.$pkey) ? 'active':''; ?>"><a href="<?=base_url('student/index/read/'.$pkey);?> data-toggle="tab">Perkuliahan</a></li>
						  <li><a href="#pembayaran" data-toggle="tab">Pembayaran</a></li>
						  <li><a href="#statusAkademis" data-toggle="tab">Status Akademis</a></li>
						  <li><a href="#transkrip" data-toggle="tab">Transkrip</a></li>
						</ul>
						<div class="tab-content no-padding">
							<div class="tab-pane active" id="biodata">
								<div class="box-body">
									<div class="btn-group">
										<a class="btn btn-primary" href="#">Edit</a>
										<a class="btn btn-primary" href="#">Print</a>
									</div>
									<?php echo $output->output; ?>
								</div>
							</div>
							<div class="tab-pane" id="ringkasan">
								ringkasan
							</div>
							<div class="tab-pane" id="perkuliahan">
								perkuliahan
							</div>
							<div class="tab-pane" id="pembayaran">
								pembayaran
							</div>
							<div class="tab-pane" id="statusAkademis">
								statusAkademis
							</div>
							<div class="tab-pane" id="transkrip">
								transkrip
							</div>
						</div>
					</div> -->
					
	      </div>
  		</div>
  	</section>
<?php $this->load->view('parts/footer'); ?>
