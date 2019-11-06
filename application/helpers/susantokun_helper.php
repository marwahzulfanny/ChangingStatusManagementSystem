<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class susantokun_helper extends CI_CONTROLLER {
	function konfigurasi($title, $c_des=null)
	{
		$CI = get_instance();
		$CI->load->model('Auth_model');
		$site = $CI->Auth_model->listing();
		$data = array(
		  'title'        => $title.' | '.$site['nama_website'],
		  'logo'         => $site['logo'],
		  'favicon'      => $site['favicon'],
		  'email'        => $site['email'],
		  'no_telp'      => $site['no_telp'],
		  'alamat'       => $site['alamat'],
		  'facebook'     => $site['facebook'],
		  'instagram'    => $site['instagram'],
		  'keywords'     => $site['keywords'],
		  'metatext'     => $site['metatext'],
		  'about'        => $site['about'],
		  'site'         => $site,
		  'c_judul'      => $title,
		  'c_des'        => $c_des,
		);
		return $data;
	}
}