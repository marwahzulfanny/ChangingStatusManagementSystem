<?php $this->load->view('parts/header'); ?>
<?php $activePage = basename($_SERVER['PHP_SELF'], ".php");?>
   <!-- Main content -->
    <section class="content">
      <div class="row">
			<div class="col-md-12">
				<?php include('/parts/menu_siswa.php') ?>
			</div>
					<div class="box-tools pull-right">
						<a class="btn btn-primary btn-sm" data-tooltip="tooltip" title="Add course enrolment" href="#<?php //echo base_url($this->uri->uri_string()).'/create';?>"><i class="fa fa-plus-circle"></i></a>
					</div>
					<div class="box-body">
					
						<table  class="table table-striped table-hover data-table">
						<thead>
							<th>No</th>
							<th>Photo</th>
							<!--<th>Name</th>-->
							<th>NPM</th>
							<th>Role</th>
							<th>Status Student</th>
							<th>Jurusan</th>
						</thead>
						<tbody>
						<?php 
							if(!empty($data)){ $no=0; foreach($data as $a){ $no++; 	?>
						<tr>
							<td><?php echo $no;?></td>
							<td><?php echo $a['photo'];?></td>
							<!--<td><?php echo $a['name.users'];?></td>		-->							
							<td><?php echo $a['NIP_NPM'];?></td>					
							<td><?php echo $a['role'];?></td>					
							<td><?php echo $a['status'];?></td>					
							<td><?php echo $a['name'];?></td>					
							
						</tr>
						<?php }}?>
						</tbody>
						</table>
					</div>
					
	      </div>
  		</div>
  	</section>	
<?php $this->load->view('parts/footer'); ?>