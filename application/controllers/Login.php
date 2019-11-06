<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('usersmodel');
		$this->load->library('form_validation');
		$this->load->library('mathcaptcha');
		$this->mathcaptcha->init();
	}
	public function index(){
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$captcha = $this->input->post('date');
		$output['err']='';
		if($username==''&& $password=='' && $captcha==''){ //newly opened
			$output['math_captcha_question'] = $this->mathcaptcha->get_question();
			$this->load->view('login', $output);
		}elseif($this->session->flashdata('mathcaptcha_answer') != $captcha){ //wrong captcha
			$output['math_captcha_question'] = $this->mathcaptcha->get_question();
			$output['err']='Wrong input';
			$this->load->view('login', $output);
		}else{
			$data = [
				'username' => $username,
				'password' => $password
			];
			$dologin = $this->usersmodel->login($data);
			$logged_in = $dologin->row();
			if($dologin->num_rows() > 0) {
				$data=$dologin->row_array();
				$data_session = [
					'username' => $username,
					'name' => $logged_in->name,
					'id' => $logged_in->id,
					'role' => $logged_in->role,
					'email' => $logged_in->email,
					'photo' => $logged_in->photo,
					'login' => true	
				];
				$this->session->set_userdata($data_session);
				// if($this->input->post('remember_me')) {
				// 	$this->load->helper('cookie');
				// 	$cookie = $this->input->cookie('ci_session');
				// 	$this->input->set_cookie('ci_session', $cookie, '31557600');
				// }
				redirect('dashboard');
			}else{
				$output['math_captcha_question'] = $this->mathcaptcha->get_question();
				$output['err']='Wrong input';
				$this->load->view('login', $output);
			}
		}
	}
	
	public function indexOld() { //show login form
		if($this->session->userdata('login') == true) { redirect(base_url('dashboard')); }
		$this->load->view('login');
	}
	public function dologin() { //executed when login form is submitted
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$data = [
			'username' => $username,
			'password' => $password
		];
		$dologin = $this->usersmodel->login($data);
		$logged_in = $dologin->row();
		if($dologin->num_rows() > 0) {
			$data=$dologin->row_array();
			$data_session = [
				'username' => $username,
				'name' => $logged_in->name,
				'id' => $logged_in->id,
				'role' => $logged_in->role,
				'email' => $logged_in->email,
				'photo' => $logged_in->photo,
				'login' => true	
			];
			$this->session->set_userdata($data_session);
			if($this->input->post('remember_me')) {
			  $this->load->helper('cookie');
			  $cookie = $this->input->cookie('ci_session');
			  $this->input->set_cookie('ci_session', $cookie, '31557600');
			}
			echo json_encode(['success' => true]);
		}else{
			echo json_encode(['success' => false]);
		}
	}
	public function logout() { //executed when user click logout button
		$this->session->sess_destroy();
		redirect(base_url('login'));
	}
	public function register(){
		if($this->session->userdata('login') == true) { redirect(base_url('dashboard')); }
		$this->load->view('register');
	}
	public function forgot() {
		if($this->session->userdata('login') == true) { redirect(base_url('dashboard')); }
		redirect(base_url('forgot'));
	}
	
	//
	//public function doRegister() {
	//		$this->form_validation->set_rules('first_name', 'First Name', 'required');
	//		$this->form_validation->set_rules('last_name', 'Last Name', 'required');
	//		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[users.email]');
	//		// $this->form_validation->set_rules('contact_no', 'Contact No', 'required|regex_match[/^[0-9]{10}$/]');
	//		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[8]');
	//		$this->form_validation->set_rules('confirm_password', 'Password Confirmation', 'trim|required|matches[password]');
	//		$this->form_validation->set_rules('address', 'Address', 'required');
	//		$this->form_validation->set_rules('dob', 'Date of Birth(DD-MM-YYYY)', 'required');
  //
	//		if ($this->form_validation->run() == FALSE) {
	//				$this->register($this->input->post());
	//		} else {
	//				$firstName = $this->input->post('first_name');
	//				$lastName = $this->input->post('last_name');
	//				$email = $this->input->post('email');
	//				$password = $this->input->post('password');
	//				$contactNo = $this->input->post('contact_no');
	//				$dob = $this->input->post('dob');
	//				$address = $this->input->post('address');
	//				$timeStamp = time();
	//				$status = 0;
	//				$verificationCode = uniqid();
	//				$verificationLink = site_url() . 'signin?usid=' . urlencode(base64_encode($verificationCode));
	//				$userName = $this->mail->generateUnique('users', trim($firstName . $lastName), 'user_name', NULL, NULL);
	//				$this->auth->setUserName($userName);
	//				$this->auth->setFirstName(trim($firstName));
	//				$this->auth->setLastName(trim($lastName));
	//				$this->auth->setEmail($email);
	//				$this->auth->setPassword($password);
	//				$this->auth->setContactNo($contactNo);
	//				$this->auth->setAddress($address);
	//				$this->auth->setDOB($dob);
	//				$this->auth->setVerificationCode($verificationCode);
	//				$this->auth->setTimeStamp($timeStamp);
	//				$this->auth->setStatus($status);
	//				$chk = $this->auth->create();
	//				if ($chk === TRUE) {
	//						$this->load->library('encrypt');
	//						$mailData = array('topMsg' => 'Hi', 'bodyMsg' => 'Congratulations, Your registration has been successfully submitted.', 'thanksMsg' => SITE_DELIMETER_MSG, 'delimeter' => SITE_DELIMETER, 'verificationLink' => $verificationLink);
	//						$this->mail->setMailTo($email);
	//						$this->mail->setMailFrom(MAIL_FROM);
	//						$this->mail->setMailSubject('User Registeration!');
	//						$this->mail->setMailContent($mailData);
	//						$this->mail->setTemplateName('verification');
	//						$this->mail->setTemplatePath('mailTemplate/');
	//						$chkStatus = $this->mail->sendMail(MAILING_SERVICE_PROVIDER);
	//						if ($chkStatus === TRUE) {
	//								redirect('signin');
	//						} else {
	//								echo 'Error';
	//						}
	//				} else {
	//						
	//				}
	//		}
	//}
  //
  //  public function actionChangePwd() {
  //      $this->form_validation->set_rules('change_pwd_password', 'Password', 'trim|required|min_length[8]');
  //      $this->form_validation->set_rules('change_pwd_confirm_password', 'Password Confirmation', 'trim|required|matches[change_pwd_password]');
  //      if ($this->form_validation->run() == FALSE) {
  //          $this->changepwd();
  //      } else {
  //          $change_pwd_password = $this->input->post('change_pwd_password');
  //          $sessionArray = $this->session->userdata('ci_seesion_key');
  //          $this->auth->setUserID($sessionArray['user_id']);
  //          $this->auth->setPassword($change_pwd_password);
  //          $status = $this->auth->changePassword();
  //          if ($status == TRUE) {
  //              redirect('profile');
  //          }
  //      }
  //  }
  //
  //  //action forgot password method
  //  public function actionForgotPassword() {
  //      $this->form_validation->set_rules('forgot_email', 'Your Email', 'trim|required|valid_email');
  //      if ($this->form_validation->run() == FALSE) {
  //          //Field validation failed.  User redirected to Forgot Password page
  //          $this->forgotpassword();
  //      } else {
  //          $login = site_url() . 'signin';
  //          $email = $this->input->post('forgot_email');
  //          $this->auth->setEmail($email);
  //          $pass = $this->generateRandomPassword(8);
  //          $this->auth->setPassword($pass);
  //          $status = $this->auth->updateForgotPassword();
  //          if ($status == TRUE) {
  //              $this->load->library('encrypt');
  //              $mailData = array('topMsg' => 'Hi', 'bodyMsg' => 'Your password has been reset successfully!.', 'thanksMsg' => SITE_DELIMETER_MSG, 'delimeter' => SITE_DELIMETER, 'loginLink' => $login, 'pwd' => $pass, 'username' => $email);
  //              $this->mail->setMailTo($email);
  //              $this->mail->setMailFrom(MAIL_FROM);
  //              $this->mail->setMailSubject('Forgot Password!');
  //              $this->mail->setMailContent($mailData);
  //              $this->mail->setTemplateName('sendpwd');
  //              $this->mail->setTemplatePath('mailTemplate/');
  //              $chkStatus = $this->mail->sendMail(MAILING_SERVICE_PROVIDER);
  //              if ($chkStatus === TRUE) {
  //                  redirect('forgotpwd?msg=2');
  //              } else {
  //                  redirect('forgotpwd?msg=1');
  //              }
  //          } else {
  //              redirect('forgotpwd?msg=1');
  //          }
  //      }
  //  }
  //
  //  //generate random password
  //  public function generateRandomPassword($length = 10) {
  //      $alphabets = range('a', 'z');
  //      $numbers = range('0', '9');
  //      $final_array = array_merge($alphabets, $numbers);
  //      $password = '';
  //      while ($length--) {
  //          $key = array_rand($final_array);
  //          $password .= $final_array[$key];
  //      }
  //      return $password;
  //  }
	function _check_math_captcha($str){
		if($this->session->flashdata('mathcaptcha_answer') == $str){
			return TRUE;
		}else{ return FALSE; }
		
		
    // if ($this->mathcaptcha->check_answer($str)){
		// 	return TRUE;
    // }else{
		// 	$this->form_validation->set_message('_check_math_captcha', 'Wrong input.');
		// 	return FALSE;
    // }
	}


	
}