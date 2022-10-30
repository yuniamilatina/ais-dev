<?php

class fiscal_m extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    private $tm_fiscal = 'CPL.TM_FISCAL';

    function get_fiscal() {
        $this->db->where('BIT_FLG_DEL =', 0);
        return $this->db->get($this->tm_fiscal)->result();
    }

    function save($data) {
        $this->db->insert($this->tm_fiscal, $data);
    }

    function get_data_fiscal($id) {
        $this->db->where('INT_ID_FISCAL_YEAR', $id);
        $this->db->where('BIT_FLG_DEL', 0);
        return $this->db->get($this->tm_fiscal);
    }

    function update($data, $id) {
        $this->db->where('INT_ID_FISCAL_YEAR', $id);
        $this->db->update($this->tm_fiscal, $data);
    }

    function delete($id) {
        $session = $this->session->all_userdata();
        $data = array(
            'BIT_FLG_DEL' => '1',
            'CHR_MODI_BY' => $session['USERNAME'],
            'CHR_MODI_DATE' => date('Ymd'),
            'CHR_MODI_TIME' => date('His'));
        $this->db->where('INT_ID_FISCAL_YEAR', $id);
        $this->db->update($this->tm_fiscal, $data);
    }

    function select_fiscal_year($id) {
        $query = $this->db->query("select CHR_FISCAL_YEAR from CPL.TM_FISCAL where INT_ID_FISCAL_YEAR = '" . $id . "'")->row_array();
        $part_of = $query['CHR_FISCAL_YEAR'];
        return $part_of;
    }

    function select_id_fiscal_year() {
        $query = $this->db->query("select top 1 INT_ID_FISCAL_YEAR from CPL.TM_FISCAL where BIT_FLG_DEL =  0 order by INT_ID_FISCAL_YEAR desc")->row();
        $part_of = $query->INT_ID_FISCAL_YEAR;
        return $part_of;
    }

    function get_new_id_fiscal() {
        return $this->db->query('select max(INT_ID_FISCAL_YEAR) as a from CPL.TM_FISCAL')->row()->a + 1;
    }

    function get_id_fiscal_this_year() {
        $fiscal_data = $this->db->query('select INT_ID_FISCAL_YEAR, CHR_FISCAL_YEAR_END, 
                                         CHR_FISCAL_YEAR_START, CHR_MONTH_END, CHR_MONTH_START from CPL.TM_FISCAL')->result();
        $now = date('Ym');
        foreach ($fiscal_data as $value) {
            $ms = $value->CHR_MONTH_START;
            $me = $value->CHR_MONTH_END;
            if ($value->CHR_MONTH_START < 10) {
                $ms = '0' . $value->CHR_MONTH_START;
            }
            if ($value->CHR_MONTH_END < 10) {
                $me = '0' . $value->CHR_MONTH_START;
            }
            $a = $value->CHR_FISCAL_YEAR_START . $ms;
            $b = $value->CHR_FISCAL_YEAR_END . $me;
            if (($a <= $now) && ($now <= $b)) {
                return $value->INT_ID_FISCAL_YEAR;
            }
        }
    }

    function get_fiscal_this_year() {
        $id = $this->get_id_fiscal_this_year();
        return $this->db->query(" select INT_ID_FISCAL_YEAR, CHR_FISCAL_YEAR
                                    from CPL.TM_FISCAL
                                    where INT_ID_FISCAL_YEAR='$id' and BIT_FLG_DEL =0")->result();
    }

    function get_all_fiscal() {
        return $this->db->query(" select top 1 *
                                  from CPL.TM_FISCAL
                                  where BIT_FLG_DEL = 0 and BIT_FLG_ACTIVE = 1 order by CHR_FISCAL_YEAR_START desc ")->result();
    }

    function get_data_for_ddl($fiscal) {
        return $this->db->query("select CHR_FISCAL_YEAR_END, CHR_FISCAL_YEAR_START, CHR_MONTH_END, CHR_MONTH_START
                                from CPL.TM_FISCAL
                                where INT_ID_FISCAL_YEAR=$fiscal and BIT_FLG_DEL=0")->row();
    }

    //----------------------- EDITED BY ANP ----------------------------------//
    function get_all_fiscal_year() {
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        $all_fiscal = $bgt_aii->query("SELECT CHR_FISCAL_YEAR, 
                                              CHR_FISCAL_YEAR_START, 
                                              CHR_FISCAL_YEAR_END
                                       FROM BDGT_TM_FISCAL_YEAR
                                       WHERE CHR_FLG_DELETE = '0' 
                                            --AND CHR_FLG_DISABLE_ENTRY = '0'")->result();
        return $all_fiscal;
    }

    function get_all_fiscal_year_for_input() {
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        $all_fiscal = $bgt_aii->query("SELECT CHR_FISCAL_YEAR, 
                                              CHR_FISCAL_YEAR_START, 
                                              CHR_FISCAL_YEAR_END
                                       FROM BDGT_TM_FISCAL_YEAR
                                       WHERE CHR_FLG_DELETE = '0' 
                                            AND CHR_FLG_DISABLE_ENTRY = '0'")->result();
        return $all_fiscal;
    }

    function get_default_fiscal_year() {
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        $default_fiscal = $bgt_aii->query("SELECT TOP 1 CHR_FISCAL_YEAR, 
                                              CHR_FISCAL_YEAR_START, 
                                              CHR_FISCAL_YEAR_END
                                       FROM BDGT_TM_FISCAL_YEAR
                                       WHERE CHR_FLG_DELETE = '0' AND CHR_FLG_DISABLE_ENTRY = '0'
                                       ORDER BY CHR_FISCAL_YEAR_START DESC")->row();
        return $default_fiscal;
    }

    function get_selected_fiscal_year($fiscal_start) {
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        $get_fiscal = $bgt_aii->query("SELECT CHR_FISCAL_YEAR, 
                                              CHR_FISCAL_YEAR_START, 
                                              CHR_FISCAL_YEAR_END
                                       FROM BDGT_TM_FISCAL_YEAR
                                       WHERE CHR_FLG_DELETE = '0'
                                             AND CHR_FISCAL_YEAR_START = '$fiscal_start'
                                             --AND CHR_FLG_DISABLE_ENTRY = '0'")->row();
        return $get_fiscal;
    }

    function get_data_active_fiscal_year() {
        $query = $this->db->query("select TOP 1 INT_ID_FISCAL_YEAR, CHR_FISCAL_YEAR_END, CHR_FISCAL_YEAR_START, CHR_MONTH_END, CHR_MONTH_START
                                from CPL.TM_FISCAL where BIT_FLG_DEL=1 ORDER BY INT_ID_FISCAL_YEAR DESC")->row_array();
        return $query;
    }

}

?>
