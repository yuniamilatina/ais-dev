<?php

class for_ng extends CI_Model {
	private $tt_ng_record_h = 'TT_NG_RECORD_H';
	private $tt_ng_record_l = 'TT_NG_RECORD_L';
	

	public function __construct() {
        parent::__construct();
    }

    public function find($option_query,$tbl='tm_area'){
     
		// check option & query is array 
   		if (is_array($option_query))
   		{
   			// extract option & query
   			foreach ($option_query as $option => $query) {
   				$this->db->$option($query);
   			}
   		}
		
		return $this->db->get($this->$tbl)->result();
	}

	 function save(Array $data,$table = NULL) {

    	if ($table !== NULL ) {
        	$table = $this->$table;
        } else {
        	$table = $this->purchase;
        }

        if ($this->db->insert($table, $data)) {
            return true;
        } else {
            return false;
        } 
    }
}