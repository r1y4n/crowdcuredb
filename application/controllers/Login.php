<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	function __construct() {
   		parent::__construct();
   		$this->load->model( 'UserModel', 'userModel', TRUE );
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->helper(array('form', 'url', 'captcha'));
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
 	}

	public function index() {
		$data = array();
		if( $this->session->has_userdata('msg') ){
			$data['msg'] = $this->session->userdata( 'msg' );
			$this->session->unset_userdata( 'msg' );
		}
		else {
			$data['msg'] = "";
		}
		$this->load->view( 'login', $data );
	}

	public function createSession() {
		$this->form_validation->set_rules('username', "Username", 'required');
		$this->form_validation->set_rules('password', "Password", 'required|callback_checkCredentials');
    	if( $this->form_validation->run() == TRUE ) {
    		$msg = 'You are successfully logged in.';
    		$this->session->set_userdata( 'msg', $msg );
    		//redirect( 'dashboard', 'refresh' );
    		echo "true";
    	}
    	else {
    		$msg = '<div class="alert alert-error hide" style="display: block;">
						<button class="close" data-dismiss="alert"></button>
						<span>Sorry! Your credentials do not match.</span>
					</div>';
    		$this->session->set_userdata( 'msg', $msg );
			redirect( 'login' );
    	}
		//redirect( 'dashboard', 'refresh' );
	}

	public function checkCredentials( $password ) {
		$username = $this->input->post( 'username' );
		$userData = $this->userModel->isValidUser( $username, $password );
		if( $userData['verdict'] != FALSE ) {
			$sessionData = $this->userModel->getUserData( $userData['user_id'] );
			$sessionData['username'] = $username;
			$this->session->set_userdata( 'loggedIn', $sessionData );
			return TRUE;
		}
		else {
			return FALSE;
		}
	}

	public function killSession() {
    	$this->session->unset_userdata( 'loggedIn' );
    	redirect( 'login', 'refresh' );
    }
}
