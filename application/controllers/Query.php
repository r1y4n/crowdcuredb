<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Query extends CI_Controller {

	function __construct() {
   		parent::__construct();
   		$this->load->model( 'QueryModel', 'queryModel', TRUE );
        $this->load->library('session');
        $this->load->helper('url');
 	}

	public function create() {
		$data = array();
		if( $this->session->has_userdata('loggedIn') ) {
			$data['sessionData'] = $this->session->userdata('loggedIn');
			if( $data['sessionData']['usertypeid'] != 3 ) {
				redirect( 'dashboard', 'refresh' );
			} 
			$this->load->view( 'createquery', $data );			
		}
		else {
			redirect( 'login', 'refresh' );
		}
	}

	public function gettables() {
		$data = array();
		$tableData = $this->queryModel->getTables();
		if( $tableData == FALSE ) {
			$data['verdict'] = "failure";
			$data['content'] = NULL;
		}
		else {
			$data['verdict'] = "success";
			$data['content'] = $tableData;
		}
		echo json_encode( $data );
	}

	public function submit() {
		$qD = $_POST['qD'];
		$this->session->set_userdata( 'queryData', $qD );
		echo json_encode( $qD );
	}

	public function pending() {
		$data = array();
		if( $this->session->has_userdata('loggedIn') ) {
			$data['sessionData'] = $this->session->userdata('loggedIn');
			if( $data['sessionData']['usertypeid'] == 3 ) {
				$this->showPendingToUser( $data );
			} 
			else if( $data['sessionData']['usertypeid'] == 2 ) {
				$this->showPendingToAdmin( $data );
			} 
			else {
				$this->showPendingToExpert( $data );
			}
		}
		else {
			redirect( 'login', 'refresh' );
		}
	}

	private function showPendingToUser( $data ) {
		$data['queryData'] = $this->session->userdata('queryData');
		$this->load->view( 'pendingQueryUser', $data );
	}
}
