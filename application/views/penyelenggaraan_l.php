<?php $this->load->view('parts/header'); ?>
<?php $activePage = basename($_SERVER['PHP_SELF'], ".php");?>
   <!-- Main content -->
    <section class="content">
			<div class="row">
			
			<?php if(isset($filterForm)){ //show 2 columns when there is filterForm  //Ruki 4/7/2019-6:55 ?>
	      <div class="col-md-3">
		      <div class="box box-info">
						<form action="<?php echo $filterForm['actionUrl']; ?>" method="get">
							<div class="box-header">
								<h3 class="box-title"><?php echo $filterForm['title']; ?></h3>
							</div>
							<div class="box-body">
								<?php echo $filterForm['content']; ?>
							</div>
							<div class="box-footer">
								<button type="submit" class="btn btn-primary">Submit</button>
							</div>
						</form>
		      </div>
				</div>
	      <div class="col-md-9">
			<?php }else{ ?>
	      <div class="col-md-12">
			<?php } ?>
		      <div class="box">
						<div class="box-body">
							<table class="table table-striped table-hover data-table">
							<thead>
								<th>No</th>
								<th>Term</th>
								<th>Course</th>
								<th>Class</th>
								<th>Schedule</th>
								<th>Room</th>
								<th>Teacher</th>
								<th>Student</th>
							</thead>
							<tbody>
							<?php if(!empty($data)){
								$no=0;
								foreach($data as $d){
									$no++;
								?>
								<tr>
									<td><?=$no;?></td>
									<?php if(in_array($this->session->role,array('Admin','Manager','SAA'))){ ?>
										<td><?php echo '<a href="'.base_url('timing/index/read/'.$d->termId).'">'.$d->term.'</a>';?></td>
									<?php }else{ ?>
										<td><?=$d->term?></td>
									<?php } ?>
									<td><?php echo '<a href="'.base_url('courses/index/read/'.$d->courseId).'">'.$d->course.'</a>';?></td>
									<td><a href="<?=base_url('penyelenggaraan2/index/read/'.$d->ctId);?>"><?=$d->class?></a></td>
									<td><?php 
										if($d->type=='quarter'){
											echo substr($d->date_start,0,10).' - '.substr($d->date_end,0,10);
										}else{echo $d->day.' '.$d->time_start;}
									?></td>
									<td><?=$d->room;?></td>
									<td><?=$d->teacher;?></td>
									<td><?=$d->student;?></td>
								</tr>
								<?php }}
								?>
							</tbody>
							</table>
						</div>
		      </div>
	      </div>
				
  		</div>
  	</section>
		
<?php $this->load->view('parts/footer'); ?>