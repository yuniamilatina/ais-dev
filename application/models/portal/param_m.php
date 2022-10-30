<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class param_m extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    private $tm_param = 'TM_PORTAL_PARAM';
    private $tm_user = 'TM_USER';
    private $tt_news = 'TT_PORTAL_NEWS';
    private $tt_tickets = 'MIS.TT_HELPDESK_TICKET';

    function get_params() {
        $this->db->where('INT_ID_APP', 1);
        return $this->db->get($this->tm_param)->result();
    }
    
    function get_tot_user() {
        $this->db->select("COUNT(*) AS TOT_USER", false);
        $this->db->where('BIT_FLG_DEL', False);
        return $this->db->get($this->tm_user)->result();
    }
    
    function get_tot_thread() {
        $this->db->select("COUNT(*) AS TOT_THREAD", false);
        $this->db->where('CHR_FLG_DEL', 0);
        return $this->db->get($this->tt_news)->result();
    }
    
    function get_tot_tickets() {
        $this->db->select("COUNT(*) AS TOT_TICKETS", false);
        $this->db->where('BIT_FLG_DEL', False);
        return $this->db->get($this->tt_tickets)->result();
    }

}

?>
