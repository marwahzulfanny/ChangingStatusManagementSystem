<?php $this->load->view('parts/header'); ?>
<?php $activePage = basename($_SERVER['PHP_SELF'], ".php");?>
   <!-- Main content -->
    <section class="content">
      <div class="row">
				<div class="col-md-12">
				<div class="box">
					<div class="box-body">
						<table class="table data-table">
						<thead>
						<tr>
							<?php if($this->session->role!='Student'&&$this->session->role!='Alumni'){ ?>
							<th>No</th>
							<th>NPM</th>
							<th>Name</th>
							<?php } ?>
							<?php if(!empty($komponen)){foreach($komponen as $k){
								echo '<th>'.$k->name.' ('.$k->weight.'%)</th>';
							} } ?>
							<th>Final Score</th>
						</tr>
						</thead>
						<tbody>
						<?php if(!empty($stuScores)){
						$sizestuScores = count($stuScores);
						for($no=1; $no<=$sizestuScores; $no++){
						$score = array_shift($stuScores); 
						?>
						
						<tr>
							<?php if($this->session->role!='Student'&&$this->session->role!='Alumni'){ ?>
							<td><?php echo $no;?></td>
							<td><?php echo $score['npm'];?></td>
							<td><?php echo $score['name'];?></td>
							<?php } ?>
							<?php if(!empty($komponen)){foreach($komponen as $k){
								if(array_key_exists($k->name,$score)){
									echo '<td>'.$score[$k->name] .'</td>';
								}else{
									echo '<td>-</td>';
								}
							} } ?>
							<td><?php 
								$t = $score['tot'];
								if($t > 85){ $t .= ' (A)';
								}elseif($t > 80 && $t <= 85){ $t .= ' (A-)';
								}elseif($t > 75 && $t <= 80){ $t .= ' (B+)';
								}elseif($t > 70 && $t <= 75){ $t .= ' (B)';
								}elseif($t > 65 && $t <= 70){ $t .= ' (B-)';
								}elseif($t > 60 && $t <= 65){ $t .= ' (C+)';
								}elseif($t > 55 && $t <= 60){ $t .= ' (C)';
								}elseif($t > 40 && $t <= 55){ $t .= ' <span style="color:red">(D)</span>';
								}else{ $t .= ' <span style="color:red">(E)</span>';}
								echo $t;
							?></td>
						</tr>
						<?php }}
						?>
						
						</tbody>
						</table>
							<a class="btn btn-default" href="javascript:window.history.back()"><i class="fa fa-angle-left"></i> Back</a>
						<?php if($showEditButton){ ?>
							<a class="btn btn-warning" href="<?php echo base_url('penyelenggaraan2/nilai/'.$penyelenggaraanId.'/edit'.$stuId);?>"><i class="fa fa-pencil"></i> Edit scoring</a>
						<?php } ?>
					</div>
					
	      </div>
	      </div>
  		</div>
  	</section>
		
<?php 
$this->load->view('parts/footer'); 
?>