<?php $this->load->view('parts/header'); ?>
<?php $activePage = basename($_SERVER['PHP_SELF'], ".php");?>
   <!-- Main content -->
    <section class="content">
      <div class="row">
			
	      <div class="col-md-3">
		      <div class="box box-info">
						<form action="<?php echo $filterForm['actionUrl']; ?>" method="post">
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
					<div class="box box-body">
						<form name="formAbsen" action="<?=base_url('penyelenggaraan2/absensi/'.$penyelenggaraanId.'/doSave')?>" method="post">
						<input type="hidden" name="editAbsenPenyelenggaraan" value="<?=$penyelenggaraanId?>">
						<input type="hidden" name="editAbsenTgl" value="<?=$day?>">
						
						<?php if(count($teachers)==1){ ?>
							<input type="hidden" name="teacher" value="<?=$teachers[0]['uid']?>">
						<?php }else{ ?>
							<!--select name="teacher">
								<option>-- Select Teacher --</option>
								<?php foreach($teachers as $t){ ?>
									<option value="<?=$t['uid']?>" <?php if(isset($theTeacher)&&$t['id']==$theTeacher){echo selected;}?>><?php
									$tx='';
									if($t['title_front']!=''){ $tx.=$t['title_front'].' ';};
									$tx.=$t['name'];
									if($t['title_back']!=''){ $tx.=', '.$t['title_back'];};
									echo $tx;
									?></option>
								<?php } ?>
							</select-->
						<?php } ?>
						
						<?php $forFooter['noSearch']=1; ?>
						<?php $forFooter['noSorting']=1; ?>
						<?php $forFooter['datatableRowGroupBy']=1; ?>
						<?php $forFooter['datatableNumCol']=6; ?>
						<?php $forFooter['noPaginate']=1; ?>
						<?php $forFooter['noLengthChange']=1; ?>
						<?php $forFooter['noInfo']=1; ?>
						
						<table id="example" class="table data-table">
							<thead>
								<th>No</th>
								<th>Jenis User</th>
								<th>NPM</th>
								<th>Name</th>
								<th><?=$day?></th>
								<th>Note</th>
							</thead>
							
							<tbody>
								<!--tr><td colspan="5">Teachers</td></td-->
							<?php $noT=1;foreach($teachers as $t){ ?>
								<tr>
									<td><?=$noT?></td>
									<td>Teachers</td>
									<td><?=$t['NIP_NPM']?></td>
									<td><?php
										$tx='';
										if($t['title_front']!=''){ $tx.=$t['title_front'].' ';};
										$tx.=$t['name'];
										if($t['title_back']!=''){ $tx.=', '.$t['title_back'];};
										echo $tx;
										$noT++;
									?></td>
									
									<?php 
									$ketemu1 = 0;
									if(isset($attendanceData)){
									foreach($attendanceData as $data){
										if($data->user == $t['uid']){
											$ketemu1 = 1;
									?>
									<td>
										<label><input type="radio" <?php if(!$canEdit){ ?>disabled<?php } ?> name="user[<?=$t['uid']?>]" value="1" <?php if($data->attendCode==1){ ?> checked="checked" <?php } ?>>Hadir</label>
										<label><input type="radio" <?php if(!$canEdit){ ?>disabled<?php } ?> name="user[<?=$t['uid']?>]" value="0" <?php if($data->attendCode==0){ ?> checked="checked" <?php } ?>>Tidak hadir</label>
									</td>
									<td><input type="text" <?php if(!$canEdit){ ?>disabled<?php } ?> name="note[<?=$t['uid']?>]" value="<?=$data->note?>"></td>
									<?php }}} if($ketemu1==0){ ?>
									<td>
										<label><input type="radio" <?php if(!$canEdit){ ?>disabled<?php }else{ ?> checked="checked" <?php } ?> name="user[<?=$t['uid']?>]" value="1">Hadir</label>
										<label><input type="radio" <?php if(!$canEdit){ ?>disabled<?php } ?> name="user[<?=$t['uid']?>]" value="0">Tidak hadir</label>
									</td>
									<td><input type="text" <?php if(!$canEdit){ ?>disabled<?php } ?> name="note[<?=$t['uid']?>]" value=""></td>
									<?php } ?>
								</tr>
							<?php } ?>
							
								<!--tr><td colspan="5">Students</td></td-->
							<?php if(!empty($students)){
								$numStu = count($students);
								for($no=1; $no<=$numStu; $no++){
									$s = array_shift($students); ?>
								<tr>
									<td><?php echo $no;?></td>
									<td>Students</td>
									<td><?php echo $s->NIP_NPM;?></td>
									<td><?php echo $s->name;?></td>
									<?php 
									$ketemu = 0;
									if(isset($attendanceData)){
									foreach($attendanceData as $data){
										if($data->user == $s->uid){
											$ketemu = 1;
									?>
									<td>
										<label><input type="radio" <?php if(!$canEdit){ ?>disabled<?php } ?> name="user[<?=$s->uid?>]" value="1" <?php if($data->attendCode==1){ ?> checked="checked" <?php } ?>>Hadir</label>
										<label><input type="radio" <?php if(!$canEdit){ ?>disabled<?php } ?> name="user[<?=$s->uid?>]" value="0" <?php if($data->attendCode==0){ ?> checked="checked" <?php } ?>>Bolos</label>
										<label><input type="radio" <?php if(!$canEdit){ ?>disabled<?php } ?> name="user[<?=$s->uid?>]" value="2" <?php if($data->attendCode==2){ ?> checked="checked" <?php } ?>>Surat</label>
									</td>
									<td><input type="text" <?php if(!$canEdit){ ?>disabled<?php } ?> name="note[<?=$s->uid?>]" value="<?=$data->note?>"></td>
									<?php }}} if($ketemu==0){ ?>
									<td>
										<label><input type="radio" <?php if(!$canEdit){ ?>disabled<?php }else{ ?> checked="checked" <?php } ?> name="user[<?=$s->uid?>]" value="1">Hadir</label>
										<label><input type="radio" <?php if(!$canEdit){ ?>disabled<?php } ?> name="user[<?=$s->uid?>]" value="0">Bolos</label>
										<label><input type="radio" <?php if(!$canEdit){ ?>disabled<?php } ?> name="user[<?=$s->uid?>]" value="2">Surat</label>
									</td>
									<td><input type="text" <?php if(!$canEdit){ ?>disabled<?php } ?> name="note[<?=$s->uid?>]" value=""></td>
									<?php } ?>
								</tr>
							<?php }}?>
							</tbody>
						</table><br>
						<input class="btn btn-primary" type="submit" <?php if(!$canEdit){ ?>disabled<?php } ?> value="Save">
						</form>
					</div>
				</div>
					
					
					
	      </div>
  		</div>
  	</section>
		
<?php $this->load->view('parts/footer',$forFooter); ?>