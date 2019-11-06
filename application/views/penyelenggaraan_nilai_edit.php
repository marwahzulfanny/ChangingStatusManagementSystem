<?php $this->load->view('parts/header'); ?>
<?php $activePage = basename($_SERVER['PHP_SELF'], ".php");
	$stuId = substr($stuId,3);
?>
   <!-- Main content -->
    <section class="content">
      <div class="row">
			<?php if(empty($komponen)){ echo 'Please add scoring components!';}else{ ?>
			
				<form method="post" action="<?php echo base_url('penyelenggaraan2/nilai/'.$ctId.'/doEdit?h_key='.$h_key); ?>">
				<div class="col-md-12">
				<div class="box">
					<div class="box-body">
						<table class="table table-striped table-hover">
						<thead>
							<th>No</th>
							<th>NPM</th>
							<th>Name</th>
							<?php foreach($komponen as $k){ echo '<th>'.$k->name.' ('.$k->weight.'%)</th>'; } ?>
						</thead>
						<tbody>
							<?php 
							if(!empty($students)){
								$studentsWithScore = array_column($stuScores,'student_id');
								$numStu = count($students);
								for($no=1; $no<=$numStu; $no++){
									$s = array_shift($students);
									if($stuId!='' && $s->uid!=$stuId){continue;}
									?>
								<tr>
									<td><?php if($stuId==''){echo $no;}else{echo '1';}?></td>
									<td><?php echo $s->NIP_NPM;?></td>
									<td><?php echo $s->name;?></td>
									<?php foreach($komponen as $k){
									 if(in_array($s->uid,$studentsWithScore)){ //bila student ini sudah punya nilai (minimal di satu komponen)
										$score = $stuScores[$s->uid];
										// $score = array_map(function($m) use ($stuScores){return $stuScores[$m];}, $keys);
										if(array_key_exists($k->name,$score)){
											echo '<td><input name="s[]" maxlength="5" type="number" step="0.01" min="0" max="100" value="'.$score[$k->name] .'" >
											<input type="hidden" name="stuId[]" value="'.$score['student_id'].'"><input type="hidden" name="csId[]" value="'.$k->id.'">
											<input type="hidden" name="scsId[]" value="'.$score[$k->name.'_id'].'">
											</td>';
										}else{
											echo '<td><input name="s[]" maxlength="5" type="number" step="0.01" min="0" max="100" value="" >
											<input type="hidden" name="stuId[]" value="'.$score['student_id'].'"><input type="hidden" name="csId[]"  value="'.$k->id.'">
											<input type="hidden" name="scsId[]" value="0">
											</td>';
										}
									 }else{
										 echo '<td><input name="s[]" maxlength="5" type="number" step="0.01" min="0" max="100" value="" >
										 <input type="hidden" name="stuId[]" value="'.$s->uid.'"><input type="hidden" name="csId[]"  value="'.$k->id.'">
										 <input type="hidden" name="scsId[]" value="0">
										 </td>';
									 }
									} ?>
								</tr>
							<?php }}?>
						</tbody>
						</table>
						<input type="hidden" name="h" value="<?=$h?>">
						<input type="hidden" name="vId" value="<?=$vId?>">
						<input type="submit" value="Save" class="btn btn-success">
					</div>
				</div>
				</div>
				</form>
			<?php } ?>
	    </div>
  	</section>
		
<?php $this->load->view('parts/footer'); ?>