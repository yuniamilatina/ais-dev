<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class home_m extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    private $tm_role = 'TM_ROLE';

    function get_role($role) {
        $this->db->where('BIT_FLG_DEL', 0);
        $this->db->where('INT_ID_ROLE', $role);
        return $this->db->get($this->tm_role);
    }
	
	

}
?>
