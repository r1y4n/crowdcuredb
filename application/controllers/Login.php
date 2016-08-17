<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	function __construct() {
   		parent::__construct();
   		//$this->load->model( 'UserModel', 'userModel', TRUE );
        //$this->load->library('form_validation');
        //$this->load->library('session');
        $this->load->helper(array('form', 'url', 'captcha'));
        //$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
 	}

	public function index() {
		$this->load->view('login');
	}

	public function verifyUser() {
		redirect( 'dashboard', 'refresh' );
	}
}
