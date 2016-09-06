<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class QueryModel extends CI_Model {
    function __construct() {
        parent::__construct();                
    }
    public function getTables() {
    	$this->db->select( 'name, display_name as display, search_keys as keys, description' );
    	$this->db->from( 'cctable' );
    	$query = $this->db->get();
    	$tableData = array();
    	$tc = 0;
    	$fileContent = file_get_contents( 'files/json/table.json' );
		$jsonContent = json_decode( $fileContent, true );
		//echo "<pre>".print_r($jsonContent,true)."</pre>";
    	foreach( $query->result() as $row ) {
    		$tableData[$tc] = array(
				'tablename'		=>	$row->name,
				'displayname'	=>	$row->display,
				'searchkeys'	=>	$row->keys,
				'description'	=>	$row->description,
				'columnnames'	=>	array()
			);
			$tmp = 0;
			foreach( $jsonContent[$row->name]['columns'] as $col ) {
				$tableData[$tc]['columnnames'][$tmp]['cdname'] = $col['cdname'];
				$tableData[$tc]['columnnames'][$tmp]['cname'] = $col['cname'];
				$tmp++;
			}
			
			$tc++;
		}
		//echo "<pre>".print_r($tableData,true)."</pre>";
		if( $tc == 0 ) {
			return FALSE;
		}
		else {
			return $tableData;
		}
    }
}