<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Email extends CI_Controller {
    function __construct() {
        parent::__construct();
//            jika belum login redirect ke login
        if ($this->session->userdata('logged') <> 1) {
            redirect(site_url('auth'));
        }
    }
    function sendMail() {
        $ci = get_instance();
        $ci->load->library('email');
        $config['protocol'] = "smtp";
        $config['smtp_host'] = "ssl://smtp.gmail.com";
        $config['smtp_port'] = "465";
        $config['smtp_user'] = "marwahzulfannya@gmail.com";
        $config['smtp_pass'] = "mrngglry4675";
        $config['charset'] = "utf-8";
        $config['mailtype'] = "html";
        $config['newline'] = "\r\n";
        $ci->email->initialize($config);
        $ci->email->from('marwahzulfannya@gmail.com', 'Fanny');
        $list = array('marwahzulfannya@gmail.com');
        $ci->email->to($list);
        $ci->email->subject('tes email');
        $ci->email->message('email ini dikirim dengan php');
        if ($this->email->send()) {
            echo 'Email sent.';
        } else {
            show_error($this->email->print_debugger());
        }
    }
}