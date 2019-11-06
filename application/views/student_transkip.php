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
							<th>Name</th>
							<th>Kurikulum</th>
							<th>Credits</th>
							<th>Teacher</th>
							<th>Course Scoring</th>
							<th>Score</th>
						</thead>
						<tbody>
						<?php 
							if(!empty($data)){ $no=0; foreach($data as $a){ $no++; 	?>
						<tr>
							<td><?php echo $no;?></td>
							<td><?php echo $a['name'];?></td>
							<td><?php echo $a['kurikulum'];?></td>					
							<td><?php echo $a['credits'];?></td>					
							<td><?php echo $a['teacher'];?></td>					
							<td><?php echo $a['course_scoring'];?></td>					
							<td><?php echo $a['score'];?></td>					
							<!--td><?php echo date('d M Y - H:i', strtotime($a['date_input']));?></td>
							<td><?php echo $a['expire_date'] !== '0000-00-00 00:00:00' ? date('d M Y - H:i', strtotime($a['expire_date'])) : 'No expired date';?></td-->
							<!--td>
								<span class="btn-group">
									<a href="<?php echo '#'.$a['id'];?>" class="btn btn-sm btn-default"><i class="fa fa-edit"></i></a>
									<a href="#" class="btn btn-sm btn-default"  data-toggle="modal" data-target="#modalX" onclick="return delete_article('<?php echo $a['id'];?>')"><i class="fa fa-trash"></i></a>
								</span>
							</td-->
						</tr>
						<?php }}?>
						</tbody>
						</table>
					</div>
					
	      </div>
  		</div>
  	</section>
		
<?php $this->load->view('parts/footer'); ?>