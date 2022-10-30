<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class login_m extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    private $tm_user = 'TM_USER';

    function load_user($npk) {
        $this->db->where('CHR_NPK', $npk);
        return $this->db->get($this->tm_user);
    }

    public function check_if_exist($npk) {
        $query = $this->load_user($npk);
        if ($query->num_rows() == 1) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function check_if_deleted($npk) {
        $row = $this->load_user($npk)->row();
        if ($row->BIT_FLG_DEL == '1') {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function check_if_on($npk) {
        $row = $this->load_user($npk)->row();
        if ($row->BIT_STATUS == '1') {

            $ip = $this->get_ip_client();
            if (trim($ip) == trim($row->CHR_IP)) {
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            return TRUE;
        }
    }
    public function check_if_not_active($npk) {
        $row = $this->load_user($npk)->row();
        if ($row->BIT_FLG_ACTIVE == '0') {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function check_email($npk) {
        $row = $this->load_user($npk)->row();
        if (($row->CHR_EMAIL == '') or ($row->CHR_EMAIL == '-')) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function check_password($npk, $pass) {
        $row = $this->load_user($npk)->row();
        //echo trim(md5($pass . $row->CHR_REGIS_DATE)).'-';
        //echo $row->CHR_PASS;
        //exit();
//var_dump(trim(md5(trim($pass) . trim($row->CHR_REGIS_DATE))));die();
        if (trim(md5(trim($pass) . trim($row->CHR_REGIS_DATE))) == trim($row->CHR_PASS)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function check_if_exp_password($npk) {
        $row = $this->load_user($npk)->row();
        $now = date('Ymd');
        if ($row->CHR_EXP_DATE < $now) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function set_session($npk) {
        $row = $this->load_user($npk)->row();
        $user_session = array(
            'NPK' => $npk,
            'USERNAME' => trim($row->CHR_USERNAME),
            'COMPANY' => $row->INT_ID_COMPANY,
            'DIVISION' => $row->INT_ID_DIVISION,
            'GROUPDEPT' => $row->INT_ID_GROUP_DEPT,
            'DEPT' => $row->INT_ID_DEPT,
            'SECTION' => $row->INT_ID_SECTION,
            'SUBSECTION' => $row->INT_ID_SUB_SECTION,
            'ROLE' => $row->INT_ID_ROLE,
            'CHR_EXP_DATE' => $row->CHR_EXP_DATE,
            'VAL' => true
        );
        $this->session->set_userdata($user_session);
    }

    public function update_user_login($npk, $data) {
        $this->db->where('CHR_NPK', $npk);
        $this->db->update($this->tm_user, $data);
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

    public function generate_code($length = 22) {
        $characters = '012fghi3O789abcdesjklryzAmBM456JKLSNQRCFtTUVunDEIopqvwxGHPWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function insert_code($data, $npk) {
        $this->db->where('CHR_NPK', $npk);
        $this->db->update($this->tm_user, $data);
    }

    public function compare_code($code) {
        $user_session = $this->session->all_userdata();
        $this->db->where('CHR_NPK', $user_session['NPK']);
        $this->db->where('CHR_CODE', $code);
        $x = $this->db->get($this->tm_user);
        if ($x->num_rows() == 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function check_code_null() {
        $user_session = $this->session->all_userdata();
        $x = $this->load_user($user_session['NPK'])->row();
        if ($x->CHR_CODE == NULL) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function pass_validation($str) {
        if (!preg_match('/[A-Z]/', $str)) {
            return FALSE;
        } if (!preg_match('/[a-z]/', $str)) {
            return FALSE;
        } if (!preg_match('/[0-9]/', $str)) {
            return FALSE;
        } if (!preg_match('/[!._@#$%`~*&^%$(){}?]/', $str)) {
            return FALSE;
        } else {
            return TRUE;
        }

//
//
//        if (preg_match("^(?=.*[A-Za-z])(?=.*\d)(?=.*[$@$!%*#?&])[A-Za-z\d$@$!%*#?&]{8,}$^", $str)) {
//            //echo '<script>alert("You Have Successfully updated this Record!");</script>';
//            return TRUE;
//        }
//        //echo '<script>alert("You d!");</script>';
//        return FALSE;
    }

}

?>
