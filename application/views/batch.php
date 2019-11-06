<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<h4 class="modal-title" id="myModalLabel"><?php echo $title; ?></h4>
</div>
<div class="modal-body">
						<div class="box-body">
							<table class="table table-striped table-hover data-table">
							<thead>
								<th>No</th>
								<?php foreach($data_fields as $f){echo '<th>'.ucwords($f).'</th>';}?>
								<th></th>
							</thead>
							<tbody>
								<?php if(!empty($data)){ $no=0;
								foreach($data as $d){ $no++; ?>
								<tr>
									<td><?=$no;?></td>
									<?php foreach($data_fields as $f){echo '<td>'.$d[$f].'</td>';}?>
									<td><a href="<?php echo base_url('student/index?batch='.$d['batch']);?>">See students</a></td>
								</tr>
								<?php }} ?>
							</tbody>
							</table>
						</div>
</div>
