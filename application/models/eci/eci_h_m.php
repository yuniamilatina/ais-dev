<?php

class eci_h_m extends CI_Model {

    private $tbl_trans = "TT_ECI_H";
    private $tbl_trans_l = "TT_ECI_L";

    public function __construct() {
        parent::__construct();
    }
    
    public function get_master_eci(){
        $query = $this->db->query("select * from TT_ECI_H where CHR_ID_ECI <> '0' order by CHR_ID_ECI,INT_REV");
        return $query->result();
    }

    function find_trans($select = '', $where = '', $order = '', $limit = '', $start = '0', $group = '', $join = '') {
        $db_1 = $this->load->database();
        if (!empty($select))
            $this->db->select($select, false);
        if (!empty($where))
            $this->db->where($where);
        if (!empty($order))
            $this->db->order_by("CHR_ID_ECI", "DESC");
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
        return $this->db->get($this->tbl_trans)->result();
    }

    function add_trans($data) {
        $db_1 = $this->load->database();
        $start_date = date('Ymd', strtotime($data['CHR_START_DATE']));
        $end_date = date('Ymd', strtotime("+7 day",strtotime($data['CHR_START_DATE'])));
        if (is_array($data)) {
            $this->db->insert($this->tbl_trans, $data);
            $id_eci = $this->db->query("SELECT MAX(CHR_ID_ECI) as a FROM TT_ECI_H")->row()->a;
            if($data['INT_TYPE']=="ECI")
            {
                $sql = "SELECT INT_ID_ACTIVITY, CHR_ACTIVITY_NAME,INT_ID_DEPENDEN, INT_FLG_MANDATORY, CHR_DEPT FROM TM_ECI_ACTIVITY WHERE INT_FLG_MANDATORY>=1 
    ORDER BY  INT_FLG_MANDATORY ASC";
                $type_project = 0;
            }
            else
            {
                $sql = "SELECT INT_ID_ACTIVITY, CHR_ACTIVITY_NAME,INT_ID_DEPENDEN_PROJECT, INT_FLG_MANDATORY_PROJECT, CHR_DEPT FROM TM_ECI_ACTIVITY WHERE INT_FLG_MANDATORY_PROJECT>=1 
ORDER BY  INT_FLG_MANDATORY_PROJECT ASC";
                $type_project = 1;
            }
            $query = $this->db->query($sql);
            if($query->num_rows() > 0){
               
                $result_eci = $this->get_eci_h_by_id($id_eci);
                $int_rev = $result_eci->INT_REV;
                $dependen=0;
                $id_line_parent = 0;
                $temp_seq = 1;
                $temp_mandatory = 0;
                $temp_dependen = 0;
                foreach($query->result() as $activity){
                     $id_line = $this->generate_id_line($id_eci);

                     if($type_project == 0)
                     {
                         if($activity->INT_FLG_MANDATORY == 1)
                         {
                            $temp_mandatory = $activity->INT_FLG_MANDATORY; 
                         }
                         else if($activity->INT_ID_DEPENDEN >0 && $dependen==0)
                         {
                            
                            $id_line_parent = $id_line-1;
                            $dependen=1;
                         }
                         else if($activity->INT_ID_DEPENDEN == null)
                         {

                            $temp_mandatory = $temp_mandatory + 1;
                            $temp_seq = $temp_mandatory;
                            $dependen=0;
                            $id_line_parent = 0;
                            $temp_dependen = 0;
                         }
                     }
                     else
                     {
                        if($activity->INT_FLG_MANDATORY_PROJECT == 1)
                         {
                            $temp_mandatory = $activity->INT_FLG_MANDATORY_PROJECT; 
                         }
                         else if($activity->INT_ID_DEPENDEN_PROJECT >0 && $dependen==0)
                         {
                            
                            $id_line_parent = $id_line-1;
                            $dependen=1;
                         }
                         else if($activity->INT_ID_DEPENDEN_PROJECT == null)
                         {

                            $temp_mandatory = $temp_mandatory + 1;
                            $temp_seq = $temp_mandatory;
                            $dependen=0;
                            $id_line_parent = 0;
                            $temp_dependen = 0;
                         }
                     }
                     if($dependen==1)
                     {
                        $temp_dependen = $temp_dependen + 1;
                        $temp_seq = $temp_dependen;
                     }
                     $data = array(
                        'CHR_ID_ECI' => $id_eci,
                        'INT_ID_ECI_LINE' => $id_line,
                        'INT_REV' => $int_rev,
                        'INT_ID_ACTIVITY' => $activity->INT_ID_ACTIVITY,
                        'CHR_ACTIVITY_NAME' => $activity->CHR_ACTIVITY_NAME,
                        'INT_DURATION' => 0,
                        'INT_SEQ' => $temp_seq,
                        'CHR_START_DATE' => $start_date,
                        'CHR_DUE_DATE' => $end_date,
                        //'CHR_START_DATE' => date('Ymd'),
                        //'CHR_DUE_DATE' => date('Ymd'),
                        'CHR_PIC_DEPT' => $activity->CHR_DEPT,
                        'CHR_FLG_PUBLISH' => "1",
                        'CHR_ID_DEPENDEN' => $id_line_parent,
                        'CHR_DATE_ENTRY' => date('Ymd'),
                        'CHR_TIME_ENTRY' => date('his'),
                        'INT_STATUS_COLOR' => 1 //Status 1 = Ready to start
                    );
                    $this->db->insert($this->tbl_trans_l, $data);
                }
            }

            return true;
        }
        return false;
    }
    function generate_id_line($id) {
        return $this->db->query("select max(INT_ID_ECI_LINE) as a from TT_ECI_L where CHR_ID_ECI  = " . $id . "")->row()->a + 1;
    }
    function generate_id_line_child($id) {
        return $this->db->query("select max(INT_ID_ECI_LINE) as a from TT_ECI_L where CHR_ID_DEPENDEN  = " . $id . "")->row()->a + 1;
    }

    function update_trans_h($data, $where) {
        $db_1 = $this->load->database();
        if (is_array($data)) {
            return $this->db->update($this->tbl_trans, $data, $where);
        }
        return false;
    }

    function update_trans_l($data, $where) {
        $db_1 = $this->load->database();
        if (is_array($data)) {
            return $this->db->update($this->tbl_trans_l, $data, $where);
        }
        return false;
    }

    function delete_trans_h($id) {
        $this->db->where('CHR_ID_ECI', $id);
        $this->db->delete($this->tbl_trans);
    }

    function delete_trans_l($id) {
        $this->db->where('CHR_ID_ECI', $id);
        $this->db->delete($this->tbl_trans_l);
    }

    function generate_id_eci() {
        return $this->db->query('select max(CHR_ID_ECI) as a from TT_ECI_H')->row()->a + 1;
    }

    function check_id($id) {
        $find_id = $this->db->query("select * from TT_ECI_H where CHR_NAME = '" . $id . "'");
        if ($find_id->num_rows() > 0) {
            return $find_id->result();
        }
        return false;
    }

    function get_eci_h_by_id($id) {
        return $this->db->query("select * from TT_ECI_H where CHR_ID_ECI = $id")->row();
    }

    function update_eci_h($data, $id) {
        $this->db->where('CHR_ID_ECI', $id);
        $this->db->update($this->tbl_trans, $data);
    }

}
