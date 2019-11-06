    <script src="<?php echo base_url().'assets/plugins/toastr/toastr.min.js';?>"></script>
	<script>
		toastr.options = {
			"closeButton" : true,
			"progressBar" : true,
			"positionClass" : "toast-bottom-right",
			"showDuration": "400",
			"hideDuration": "1000",
			"timeOut": "7000",
			"extendedTimeOut": "1000",
			"showEasing": "swing",
			"hideEasing": "linear",
			"showMethod": "fadeIn",
			"hideMethod": "fadeOut"
		}
	</script>
	<?php if($this->session->flashdata('success') !== NULL){ ?>
		<script type="text/javascript">
			toastr.success('<?php echo $this->session->flashdata("success");?>','Success!');
		</script>
	<?php } ?>
	<?php if($this->session->flashdata('error') !== NULL){ ?>
		<script type="text/javascript">
	        toastr.error('<?php echo $this->session->flashdata("error");?>','Error!');
		</script>
	<?php } ?>
	<?php if($this->session->flashdata('warning') !== NULL){ ?>	
		<script>
			toastr.warning('<?php echo $this->session->flashdata("warning");?>','Warning!');
		</script>
	<?php } ?>
	<?php if($this->session->flashdata('info') !== NULL){ ?>	
		<script>
			toastr.info('<?php echo $this->session->flashdata("info");?>','Information!');
		</script>
	<?php } ?>
