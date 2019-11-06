<?php $this->load->view('parts/header'); ?>
<?php $activePage = basename($_SERVER['PHP_SELF'], ".php");?>
   <!-- Main content -->
    <section class="content">
			<div class="row">
				<div class="col-md-12">
					<?php if(isset($topMenu)){include($topMenu);} ?>
				</div>
			</div>
			<div class="row">
			
			<?php if(isset($filterForm)){ //show 2 columns when there is filterForm  //Ruki 4/7/2019-6:55 ?>
	      <div class="col-md-3">
		      <div class="box box-info">
						<form action="<?php if(isset($filterForm['actionUrl'])){echo $filterForm['actionUrl'];} ?>" method="<?php if(isset($filterForm['method'])){echo $filterForm['method'];}else{echo 'get';}?>" <?php if(isset($filterForm['isUpload'])){echo ' enctype="multipart/form-data" ';}?>>
							<div class="box-header">
								<h3 class="box-title"><?php echo $filterForm['title']; ?></h3>
							</div>
							<div class="box-body">
								<?php echo $filterForm['content']; ?>
							</div>
							<?php if(isset($filterForm['actionUrl'])){ ?>
							<div class="box-footer">
								<button type="submit" class="btn btn-primary">Submit</button>
							</div>
							<?php } ?>
						</form>
		      </div>
				</div>
	      <div class="col-md-9">
			<?php }else{ ?>
	      <div class="col-md-12">
			<?php } ?>
		      <div class="box">
		      	<div class="box-body">
							<?php if(isset($back_to_parrent)){echo $back_to_parrent;} ?>
							<?php echo $output->output; ?>
		      	</div>
		      </div>
	      </div>
				
  		</div>
  	</section>
		
		<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<?php if(isset($showModal)){echo $showModal['content'];}else{echo 'Loading...';} ?>
				</div>
			</div>
		</div>
		
		<script type="text/javascript">
			var myModalContent = '';
			$('button.close').on('click',function(e) {$('#myModal').modal('hide');})
			// $("#myModal .close").click(function(){$("#myModal").hide();});
			$('[data-load-remote]').on('click',function(e) {
					e.preventDefault();
					var $this = $(this);
					var remote = $this.data('load-remote');
					if(remote) {
						if(myModalContent != remote){ //update only when the URL is different
							$($this.data('remote-target')).html('<div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button><h4 class="modal-title" id="myModalLabel">Loading...</h4></div>');
							myModalContent = remote;
							$($this.data('remote-target')).load(remote);
							if($this.data('manual-toggle')){
								setTimeout(function(){$('#myModal').modal('show');},2000);
								// alert('a');
								// setTimeout(function(){alert('a');},2000);
								//
							}
						}
					}
			});
		</script>

<?php $this->load->view('parts/footer'); ?>
