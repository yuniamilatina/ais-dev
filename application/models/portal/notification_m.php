<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class notification_m extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    private $tbl_name = "TT_PORTAL_NOTIFICATION";

    public function findBySql($sql) {
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function exeBySql($sql) {
        $query = $this->db->query($sql);
    }

    function get_notification($npk) {

        $query = $this->db->query("
            SELECT     a.INT_ID_NOTIF, a.CHR_NPK, a.INT_ID_APP, a.CHR_NOTIF_TITLE, a.CHR_NOTIF_DESC, a.CHR_LINK, b.CHR_ICON
            FROM TT_PORTAL_NOTIFICATION AS a INNER JOIN
            TM_APPLICATION AS b ON a.INT_ID_APP = b.INT_ID_APP
            WHERE (a.CHR_NPK = '" . $npk . "') AND (a.CHR_FLG_READ = '0' ) AND (a.INT_ID_APP <> '4')");

        return $query->result();
    }
    
    function get_notification_budget($npk) {

        $query = $this->db->query("
            SELECT     a.INT_ID_NOTIF, a.CHR_NPK, a.INT_ID_APP, a.CHR_NOTIF_TITLE, a.CHR_NOTIF_DESC, a.CHR_LINK, b.CHR_ICON
            FROM TT_PORTAL_NOTIFICATION AS a INNER JOIN
            TM_APPLICATION AS b ON a.INT_ID_APP = b.INT_ID_APP
            WHERE (a.CHR_NPK = '" . $npk . "') AND (a.CHR_FLG_READ = '0' ) AND (a.INT_ID_APP = '4')");

        return $query->result();
    }

    function get_notification_total($npk) {

        $query = $this->db->query("
            SELECT COUNT(CHR_NPK) AS TOTAL
            FROM TT_PORTAL_NOTIFICATION
            WHERE (CHR_NPK = '" . $npk . "')  AND (CHR_FLG_READ = '0') AND (INT_ID_APP <> '4')
            GROUP BY CHR_NPK");

        return $query->result();
    }
    
    function get_notification_budget_total($npk) {

        $query = $this->db->query("
            SELECT COUNT(CHR_NPK) AS TOTAL
            FROM TT_PORTAL_NOTIFICATION
            WHERE (CHR_NPK = '" . $npk . "')  AND (CHR_FLG_READ = '0')  AND (INT_ID_APP = '4')
            GROUP BY CHR_NPK");

        return $query->result();
    }
    
    function get_notif_by_id($id) {

        $query = $this->db->query("
            SELECT     a.INT_ID_NOTIF, a.CHR_NPK, a.INT_ID_APP, a.CHR_NOTIF_TITLE, a.CHR_NOTIF_DESC, a.CHR_LINK, b.CHR_ICON
            FROM TT_PORTAL_NOTIFICATION AS a INNER JOIN
            TM_APPLICATION AS b ON a.INT_ID_APP = b.INT_ID_APP
            WHERE a.INT_ID_NOTIF = $id AND a.CHR_FLG_READ = '0'");

        return $query->row();
    }

    function get_by_id($id) {
        $query = $this->db->query("SELECT     a.INT_ID_NEWS, a.CHR_NEWS_TITLE, a.CHR_NEWS_DESC, a.CHR_WRITTEN_BY, b.CHR_USERNAME, a.CHR_FLG_DEL
                                                    FROM         TT_PORTAL_NEWS AS a INNER JOIN
                                                                          TM_USER AS b ON a.CHR_WRITTEN_BY = b.CHR_NPK
                                                                          WHERE     (a.INT_ID_NEWS = '$id') ");
        return $query->result();
    }

    public function find($select = '', $where = '', $order = '', $limit = '', $start = '0', $group = '', $join = '') {
        $db_1 = $this->load->database();

        if (!empty($select))
            $this->db->select($select, false);
        if (!empty($where))
            $this->db->where($where);
        if (!empty($order))
            $this->db->order_by($order);
        if (!empty($limit))
            $this->db->limit($limit, $start);
        if (!empty($group))
            $this->db->group_by($group);


        if (!empty($join) && is_array($join)) {
            if (!empty($join['table']) && !empty($join['on'])) {
                $join = array($join);
            }

            foreach ($join as $item) {
                if (!empty($item['table']) && !empty($item['on'])) {
                    if (!empty($item['pos'])) {
                        $this->db->join($item['table'], $item['on'], $item['pos']);
                    } else {
                        $this->db->join($item['table'], $item['on']);
                    }
                }
            }
        }

        return $this->db->get($this->tbl_name)->result();
    }

    function add($data) {
        if (is_array($data)) {
            return $this->db->insert($this->tbl_name, $data);
        }

        return false;
    }

    public function update($data, $where) {
        if (is_array($data)) {
            return $this->db->update($this->tbl_name, $data, $where);
        }

        return false;
    }

    public function delete($where) {
        return $this->db->delete($this->tbl_name, $where);

        return false;
    }

    public function has_be_read($id) {
        $this->db->query("UPDATE TT_PORTAL_NOTIFICATION SET CHR_FLG_READ='1' WHERE INT_ID_NOTIF='$id'");
    }

    public function has_be_read_by_npk_and_function($npk, $function) {
        $this->db->query("UPDATE TT_PORTAL_NOTIFICATION SET CHR_FLG_READ='1' WHERE CHR_NPK = '$npk' AND INT_ID_FUNCTION = '$function'");
    }

    function generate_id() {
        return $this->db->query('select max(INT_ID_NOTIF) as a from TT_PORTAL_NOTIFICATION')->row()->a + 1;
    }

    function insert_notification($data) {
        $this->db->insert($this->tbl_name, $data);
    }


    function get_notification_total_by_npk_and_app($npk, $app){
        $query = $this->db->query("SELECT COUNT(CHR_NPK) TOTAL FROM TT_PORTAL_NOTIFICATION 
            WHERE CHR_NPK = '$npk' AND INT_ID_APP = '$app' AND CHR_FLG_READ = '0'
        GROUP BY CHR_NPK");

        if($query->num_rows()){
            return $query->row()->TOTAL;
        }else{
            return false;
        }
        
    }

    function get_notification_total_by_npk_and_module($npk, $module){
        $query = $this->db->query("SELECT COUNT(CHR_NPK) TOTAL FROM TT_PORTAL_NOTIFICATION 
            WHERE CHR_NPK = '$npk' AND INT_ID_MODULE = '$module' AND CHR_FLG_READ = '0'
        GROUP BY CHR_NPK");

        if($query->num_rows()){
            return $query->row()->TOTAL;
        }else{
            return false;
        }
        
    }

    function get_notification_total_by_npk_and_function($npk, $function){
        $query = $this->db->query("SELECT COUNT(CHR_NPK) TOTAL FROM TT_PORTAL_NOTIFICATION 
            WHERE CHR_NPK = '$npk' AND INT_ID_FUNCTION = '$function' AND CHR_FLG_READ = '0'
        GROUP BY CHR_NPK");

        if($query->num_rows()){
            return $query->row()->TOTAL;
        }else{
            return false;
        }
        
    }

    function get_notification_aorta($npk) {

        $query = $this->db->query("
            SELECT a.INT_ID_NOTIF, a.CHR_NPK, a.INT_ID_APP, a.CHR_NOTIF_TITLE, a.CHR_NOTIF_DESC, a.CHR_LINK, b.CHR_ICON
            FROM TT_PORTAL_NOTIFICATION AS a INNER JOIN
            TM_APPLICATION AS b ON a.INT_ID_APP = b.INT_ID_APP
            WHERE (a.CHR_NPK = '" . $npk . "') AND (a.CHR_FLG_READ = '0' ) AND (a.INT_ID_APP = '28')");

        return $query->result();
    }

    function get_notification_aorta_total($npk) {

        $query = $this->db->query("
            SELECT COUNT(CHR_NPK) AS TOTAL
            FROM TT_PORTAL_NOTIFICATION
            WHERE (CHR_NPK = '" . $npk . "')  AND (CHR_FLG_READ = '0')  AND (INT_ID_APP = '28')
            GROUP BY CHR_NPK");

        return $query->result();
    }
}

?>
