<?php 
$data = ['simple' => true, 'add_body_class' => 'login-page', 'title' => 'Login'];
$this->load->view('parts/header', $data); ?>
<div class="login-box">
  <div class="login-logo">
    <a href="../../index2.html"><b>ABC</b>IS</a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Sign in to start your session
		<br><?php echo $err; ?>
		</p>
<?php // echo form_open(); ?>
<?php // echo $math_captcha_question;?>
<?php // echo form_input('math_captcha');?>
<?php // echo form_submit('submit', 'Submit'); ?>
<?php // echo form_close();?>

		
    <form action="<?=base_url('login');?>" method="post" id="login">
      <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="Email or username" name="username">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" placeholder="Password" name="password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
				<div id="q"><?php echo $math_captcha_question;?></div>
				<input type="password" class="form-control" placeholder="?" name="date">
      </div>
      <div class="row">
        <div class="col-xs-8">
          <!--div class="checkbox icheck">
            <label>
              <input type="checkbox" name="remember_me"> Remember Me
            </label>
          </div-->
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <input type="submit" class="btn btn-primary btn-block btn-flat" value="Sign In">
        </div>
        <!-- /.col -->
      </div>
    </form>

    <!--div class="social-auth-links text-center">
      <p>- OR -</p>
      <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign in using
        Facebook</a>
      <a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Sign in using
        Google+</a>
    </div-->
    <!-- /.social-auth-links -->

    <!--a href="#">I forgot my password</a><br>
    <a href="<?=base_url('register');?>" class="text-center">Register a new membership</a-->

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->
<?php 
$data = ['add' => ''];
$this->load->view('parts/footer', $data); ?>