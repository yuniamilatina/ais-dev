<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class log_m extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get_ip_client() {
        if (!empty($_SERVER["HTTP_CLIENT_IP"])) {
            //check for ip from share internet
            $ip = $_SERVER["HTTP_CLIENT_IP"];
        } elseif (!empty($_SERVER["HTTP_X_FORWARDED_FOR"])) {
            // Check for the Proxy User
            $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
        } else {
            $ip = $_SERVER["REMOTE_ADDR"];
        }

        // This will print user's real IP Address
        // does't matter if user using proxy or not.
        return $ip;
    }

    public function add_log($activity, $object) {
        $session = $this->session->all_userdata();
        if ($session['ROLE'] == '') {
            redirect('login_c');
        }
        
        $log = array(
            'CHR_TIME' => date('ymdHis'),
            'CHR_NPK' => $session['NPK'],
            'INT_ID_ACTIVITY' => $activity,
            'CHR_OBJECT' => $object,
            'CHR_CPU' => $this->get_ip_client()
        );
        $this->db->insert('TT_LOG', $log);
    }
     public function add_log_login($activity, $npk) {
        $log = array(
            'CHR_TIME' => date('ymdHis'),
            'CHR_NPK' => $npk,
            'INT_ID_ACTIVITY' => $activity,
            'CHR_OBJECT' => NULL,
            'CHR_CPU' => $this->get_ip_client()
        );

        $this->db->insert('TT_LOG', $log);
    }

    public function get_last_logs() {
        $this->db->limit(7);
        $this->db->order_by('CHR_TIME', 'desc');
        return $this->db->get('TT_LOG')->result();
    }
    
    function get_last_month_logs(){
        $m=date('ymdHis')-100000000;
        return $this->db->query("select LO.CHR_TIME, U.CHR_USERNAME, ION.CHR_ACTION, DA.CHR_DATA, LO.CHR_OBJECT, LO.CHR_CPU, APP.CHR_APP 
                            from TT_LOG LO
                            INNER JOIN TM_USER U ON U.CHR_NPK = LO.CHR_NPK
                            LEFT JOIN TT_ACTIVITY ACT ON ACT.INT_ID_ACTIVITY = LO.INT_ID_ACTIVITY 
                            LEFT JOIN TM_ACTION ION ON ION.INT_ID_ACTION = ACT.INT_ID_ACTION
                            LEFT JOIN TM_DATA DA ON DA.INT_ID_DATA = ACT.INT_ID_DATA
                            LEFT JOIN TM_APPLICATION APP ON APP.INT_ID_APP = DA.INT_ID_APP 
                            WHERE LO.CHR_TIME > $m
                             order by LO.CHR_TIME desc" )->result();
    }

}

?>
