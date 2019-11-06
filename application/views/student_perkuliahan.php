<?php $this->load->view('parts/header'); ?>
<?php $activePage = basename($_SERVER['PHP_SELF'], ".php");?>
   <!-- Main content -->
    <section class="content">
      <div class="row">
			<div class="col-md-12">
				<?php if($this->session->role=='Student'||$this->session->role=='Alumni'){}else{
					include('/parts/menu_siswa.php');
				} ?>
					<!--div class="box-tools pull-right">
						<a class="btn btn-primary btn-sm" data-tooltip="tooltip" title="Add course enrolment" href="#<?php //echo base_url($this->uri->uri_string()).'/create';?>"><i class="fa fa-plus-circle"></i></a>
					</div-->
					<?php $forFooter['noSearch']=1; ?>
					<?php $forFooter['noSorting']=1; ?>
					<?php $forFooter['datatableRowGroupBy']=1; ?>
					<?php $forFooter['datatableNumCol']=7; ?>
		      <div class="box">
		      <div class="box-body">
					
						<table id="example" class="table data-table">
						<thead>
							<th>No</th>
							<th>Class</th>
							<th>Course</th>
							<th>Course Code</th>
							<th>Curriculum</th>
							<th>Credits</th>
							<th>Score</th>
						</thead>
						<tbody>
						<?php 
							if(!empty($data)){ $no=0; foreach($data as $a){ $no++; 	?>
						<tr>
							<td><?php echo $no;?></td>
							<td><?php echo $a['term'];?></td>					
							<td><?php 
							if($this->session->role!='Admin'&&$this->session->role!='SAA'&&$this->session->role!='Manager'&&$this->session->role!='Student'&&$this->session->role!='Finance'){
								echo $a['name'];
							}else{
								echo '<a title="see penyelenggaraan" href="'.base_url('penyelenggaraan2/index/read/'.$a['id']).'">'.$a['name'].'</a>';
							}
							?></td>					
							<td><?php echo $a['code'];?></td>					
							<td><?php echo $a['kurikulum'];?></td>					
							<td><?php echo $a['credits'];?></td>					
							<td><?php if($a['nilai']!=''){
								$t = $a['nilai'];
								if($t > 85){ $t .= ' (A)';
								}elseif($t > 80 && $t <= 85){ $t .= ' (A-)';
								}elseif($t > 75 && $t <= 80){ $t .= ' (B+)';
								}elseif($t > 70 && $t <= 75){ $t .= ' (B)';
								}elseif($t > 65 && $t <= 70){ $t .= ' (B-)';
								}elseif($t > 60 && $t <= 65){ $t .= ' (C+)';
								}elseif($t > 55 && $t <= 60){ $t .= ' (C)';
								}elseif($t > 40 && $t <= 55){ $t .= ' <span style="color:red">(D)</span>';
								}else{ $t .= ' <span style="color:red">(E)</span>';}
								// if($this->session->role!='Admin'&&$this->session->role!='SAA'&&$this->session->role!='Manager'&&$this->session->role!='Finance'){
									// echo $t;
								// }else{
									echo '<a title="see details" href="'.base_url('penyelenggaraan2/nilai/'.$a['id'].'?s='.$a['stuId']).'">'.$t.'</a>';
								// }
							}
								// echo $a['nilai'];
							?></td>					
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

	      </div>
  	</section>
		
<!--div class="modal inmodal" id="modalDelete" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content animated bounceInDown">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
				<span aria-hidden="true"><i class="fa fa-remove"></i></span><span class="sr-only">Close</span></button>
				<i class="fa fa-trash modal-icon"></i>
				<h4 class="modal-title">Delete Announcement</h4>
				<div>Remove Announcement from list.</div>
			</div>
			<form name="formdelete" action="<?php echo base_url().'dashboard/delete/announcement';?>" method="POST">
			<div class="modal-body">
				<input type="hidden" name="ann_id" id="item_id">
				<div class="msg"></div>
			</div>
			<div class="modal-footer">
				<input type="reset" name="reset" value="Cancel" class="btn btn-white" data-dismiss="modal">
				<input type="submit" name="move" value="Remove" class="btn btn-danger action">
			</div>
			</form>
		</div>	
	</div>
</div-->
		
<?php $this->load->view('parts/footer',$forFooter); ?>