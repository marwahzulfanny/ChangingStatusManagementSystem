<?php $this->load->view('parts/header-copy', ['title' => 'Dashboard']); ?>
    <!-- Main content -->
    <section class="content">
      <!-- Info boxes -->
      <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-university"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">SKS Program</span>
              <span class="info-box-number">144</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="fa fa-mortar-board"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">SKS Tempuh</span>
              <span class="info-box-number">20</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-money"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Informasi Tagihan</span>
              <span class="info-box-number">Rp. 0</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-red"><i class="fa fa-envelope-o"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Pesan Dibalas</span>
              <span class="info-box-number">0 Pesan</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->

      </div>
      <!-- /.row -->

      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Papan Informasi</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>

            </div>
			
            <!-- /.box-header -->
			<div class="box-body">
                
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