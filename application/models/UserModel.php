<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserModel extends CI_Model {
    function __construct() {
        parent::__construct();                
    }

    /*public function insertUser( $userData ) { 
    	$string = array(
        	'id' => '',
            'f_name' => $userData['form-first-name'],
            'l_name' => $userData['form-last-name'],
            'email' => $userData['form-email'],
            'mobile' => $userData['form-mobile'],
            'dob' =>$userData['form-dob'],
            'nationality' =>$userData['form-nationality'],
            'gender' =>$userData['form-gender'],
            'creation_time' => date( 'Y-m-d H:i:s' ),
        );
        $q = $this->db->insert_string( 'user', $string );             
        $this->db->query( $q );

        $this->db->select_max( 'id' );
		$q = $this->db->get( 'user' );
		$row = $q->row();
        return $row->id; 
    }

    public function addLoginCredentials( $userData, $userID, $credentials ) {
    	$string = array(
    		'id' => '',
    		'user_id' => $userID,
    		'username' => $credentials['username'],
    		'password' => SHA1( $credentials['password'] ),
    		'email' => $userData['form-email'],
    		'last_login' => date( 'Y-m-d H:i:s' )
    	);
    	$q = $this->db->insert_string( 'login', $string );             
        $this->db->query( $q );
        if( $this->db->affected_rows() == 1 ) {
        	return TRUE;
        }
        else {
        	return FALSE;
        }
    }

    public function isDuplicateEmail( $email ) {     
        $this->db->get_where( 'user', array( 'email' => $email ), 1 );
        return $this->db->affected_rows() > 0 ? TRUE : FALSE;         
    }*/
    
    public function isValidUser( $username, $password ) {
    	$this->db->select( 'id, username, user_id, user_type_id' );
    	$this->db->where( array( 'username' => $username, 'password' => SHA1( $password ) ) );
    	$query = $this->db->get( 'login' );
    	if( $this->db->affected_rows() == 1 ) {
    		$row = $query->row();
            $data = array(
                'last_login' => date( 'Y-m-d H:i:s' )
            );
            $this->db->where( 'id', $row->id );
            $this->db->update( 'login', $data );
            $userData = array(
                'verdict' => TRUE,
                'username' => $row->username,
                'userid' => $row->user_id,
                'usertypeid' => $row->user_type_id
            );
    	}
    	else {
            $userData = array( 'verdict' => FALSE );
    	}
        return $userData;
    }

    public function getUserData( $userID ) {
        $this->db->select( 'user.id, fname, lname, dob, mobile, email, institution.name as institution, country.nicename as country, user_type.type, user_type.id as type_id, user_status.status' );
        $this->db->from( 'user' );
        $this->db->join( 'institution', 'user.institution_id = institution.id', 'left' );
        $this->db->join( 'country', 'user.country_id = country.id', 'left' );
        $this->db->join( 'user_type', 'user.user_type_id = user_type.id', 'left' );
        $this->db->join( 'user_status', 'user.user_status_id = user_status.id', 'left' );
        $this->db->where( array( 'user.id' => $userID ) );
        $query = $this->db->get();
    	if( $this->db->affected_rows() == 1 ) {
            $row = $query->row();
        	$data = array();
        	$data['userID'] = $row->id;
        	$data['fname'] = $row->fname;
        	$data['lname'] = $row->lname;
        	$data['email'] = $row->email;
        	$data['mobile'] = $row->mobile;
            $data['type'] = $row->type;
            $data['typeid'] = $row->type_id;
        	$data['country'] = $row->country;
            $data['institution'] = $row->institution;
            $data['status'] = $row->status;
        	$dobt = new DateTime( trim( $row->dob ) );
        	$data['dob'] = $dobt->format( 'd F Y' );
            return $data;
        }
        else {
            return FALSE;
        }
    }

    public function getAllExperts() {
        $this->db->select( 'expert.id as eid, user.id as uid, fname, lname, affiliation.name as affiliation, institution.name as institution, country.nicename as country, expert.total as total, expert.correct as correct' );
        $this->db->from( 'user' );
        $this->db->join( 'expert', 'user.id = expert.user_id', 'right' );
        $this->db->join( 'affiliation', 'user.affiliation_id = affiliation.id', 'left' );
        $this->db->join( 'institution', 'user.institution_id = institution.id', 'left' );
        $this->db->join( 'country', 'user.country_id = country.id', 'left' );
        $query = $this->db->get();
        $data = array();
        $cnt = 0;
        foreach( $query->result() as $row ) {        
            $data[$cnt] = array(
                "id"            =>  $row->eid,
                "uid"           =>  $row->uid,
                "name"          =>  $row->fname . " " . $row->lname,
                "affiliation"   =>  $row->affiliation,
                "institution"   =>  $row->institution,
                "country"       =>  $row->country
            );
            $cnt++;
        }
        return $data;
    }
} 