<?php $this->load->view('parts/header', ['title' => 'Dashboard']); ?>
    <!-- Main content -->
    <section class="content">
      <!-- Info boxes -->
		 <!--div class="row">
			<div class="col-md-3 col-sm-6 col-xs-12">
				<div class="small-box bg-aqua">
					<div class="inner">
					  <h3>0</h3>
						<p>Pesan Masuk</p>
					</div>
					<div class="icon">
						<i class="fa fa-inbox"></i>
					</div>
					<a href="<?php echo base_url().'messages'?>" class="small-box-footer">Lihat Pesan <i class="fa fa-arrow-circle-right"></i></a>
				</div>
			</div>
			
			<div class="col-md-3 col-sm-6 col-xs-12">
				<div class="small-box bg-yellow">
					<div class="inner">
					  <h3>0</h3>
						<p>User Registration</p>
					</div>
					<div class="icon">
						<i class="ion ion-person-add"></i>
					</div>
					<a href="#" class="small-box-footer">More Info<i class="fa fa-arrow-circle-right"></i></a>
				</div>
			</div>
		</div-->

      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Summary</h3>

				<div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                
				</div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="row">
                
              </div>
              <!-- /.row -->
            </div>
            <!-- ./box-body -->
            <!-- /.box-footer -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

    </section>
    <!-- /.content -->
<?php 
$data = ["add" => "<!-- ChartJS 1.0.1 -->
<script src='".asset_url('plugins/chartjs/Chart.min.js')."'></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src='".asset_url('dist/js/pages/dashboard2.js')."'></script>"];
$this->load->view('parts/footer',$data); ?>
