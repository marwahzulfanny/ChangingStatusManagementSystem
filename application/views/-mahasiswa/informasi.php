<?php $this->load->view(['title' => 'Informasi']); ?>
<form action="" method="post">
  <table class="table table-bordered table-stripped table-hover" border="2">
	<thead>
	  <tr>
	  
		<td><center><b>No</b></center></td>
		<td><center><b>Tanggal Update</b></center></td>
		<td><center><b>Isi Informasi</b></center></td>
	  </tr>                   
	</thead>
	<tbody>
		<?php
		$no = 0;
		foreach ($informasi->result() as $result):
		$no++ ?>
			  <tr>
				<td><?=$no?>
				<td><?=$result->tanggal_update?></td>
				<td><?=$result->isi_info?></td>
			  </tr>
	  <?php endforeach; ?>
	</tbody>
  </table>
</form>