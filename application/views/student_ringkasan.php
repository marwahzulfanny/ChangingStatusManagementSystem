<?php $this->load->view('parts/header'); ?>
<?php $activePage = basename($_SERVER['PHP_SELF'], ".php");?>
   <!-- Main content -->
    <section class="content">
      <div class="row">
			<div class="col-md-12">
				<?php include('/parts/menu_siswa.php') ?>
			</div>
					<div class="box-body">
					
						<table  class="table table-striped table-hover data-table">
						<thead>
							<th>No</th>
							<th>Student</th>
							<th>Course</th>
							<th>Matkul</th>
							<th>Kurikulum</th>
							<th>Type</th>
						</thead>
						<tbody>
						<?php 
							if(!empty($data)){ $no=0; foreach($data as $a){ $no++; 	?>
						<tr>
							<td><?php echo $no;?></td>
							<td><?php echo $a['student'];?></td>
							<td><?php echo $a['course'];?></td>					
							<td><?php echo $a['name'];?></td>					
							<td><?php echo $a['kurikulum'];?></td>					
							<td><?php echo $a['type'];?></td>					
							
						</tr>
						<?php }}?>
						</tbody>
						</table>
					</div>
					
	      </div>
  		</div>
  	</section>	
<?php $this->load->view('parts/footer'); ?>