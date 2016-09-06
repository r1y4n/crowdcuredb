<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	function __construct() {
   		parent::__construct();
   		$this->load->model( 'UserModel', 'userModel', TRUE );
        $this->load->library('session');
        $this->load->helper('url');
 	}

	public function index() {
		$data = array();
		if( $this->session->has_userdata('loggedIn') ) {
			if( $this->session->has_userdata('msg') ){
				$data['msg'] = $this->session->userdata( 'msg' );
				$this->session->unset_userdata( 'msg' );
			}
			else {
				$data['msg'] = "";
			}
			$data['sessionData'] = $this->session->userdata('loggedIn');
			$data['userData'] = $this->userModel->getUserData( $data['sessionData']['userid'] );
			$data['userData']['username'] = $data['sessionData']['username'];
			$user_type_id = $data['sessionData']['usertypeid'];
			$this->load->view( 'dashboard', $data );
			/*if( $user_type_id == 1 ) {
				$this->load->view( 'expertuser', $data );
			}
			else if( $data['userData']['type_id'] == 2 ) {
				$this->load->view( 'adminuser', $data );
			}
			else {
				$this->load->view( 'generaluser', $data );
			}*/
		}
		else {
			redirect( 'login', 'refresh' );
		}
	}

	public function getAllExperts() {
		$data = $this->userModel->getAllExperts();
		if( $data == FALSE ) {
			$retData = array(
				"verdict" => "failure",
				"content" => ""
			);
		}
		else {
			$retData = array(
				"verdict" => "success",
				"content" => $data
			);
		}
		echo json_encode( $retData );
	}
}
