<?php

class spare_parts_rack_m extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database("samanta", TRUE);
    }

    private $table_master_routing = 'TM_SPARE_PARTS_ROUTING';

    //Get data rack spare parts
    function get_all_rack() {
        $db_samanta = $this->load->database("samanta", TRUE);
        $query = $db_samanta->query("SELECT A.*, B.CHR_SPECIFICATION FROM TM_SPARE_PARTS_ROUTING A
        INNER JOIN TM_SPARE_PARTS B ON B.CHR_PART_NO = A.CHR_PART_NO ORDER BY A.CHR_RACK_NO");
        return $query->result();
    }

    //Get data rack spare parts with filter (original)
    function get_rack_filter($FILTER) {
        $db_samanta = $this->load->database("samanta", TRUE);
        $query = $db_samanta->query("SELECT DISTINCT TOP 1000 A.*, B.CHR_SPECIFICATION FROM TM_SPARE_PARTS_ROUTING A
                                INNER JOIN TM_SPARE_PARTS B ON B.CHR_PART_NO = A.CHR_PART_NO
                                WHERE A.CHR_RACK_NO like '%".$FILTER."%' or B.CHR_SPECIFICATION like '%".$FILTER."%' or B.CHR_BACK_NO like '%".$FILTER."%' or B.CHR_PART_NO like '%".$FILTER."%'
                                ORDER BY A.CHR_RACK_NO");
        return $query->result();
    }

    //Get data rack spare parts with filter date (untuk yang request difilter khusus tanggal uploadnya)
    // function get_rack_filter($FILTER) {
    //     $db_samanta = $this->load->database("samanta", TRUE);
    //     $query = $db_samanta->query("SELECT DISTINCT TOP 1000 A.*, B.CHR_SPECIFICATION FROM TM_SPARE_PARTS_ROUTING A
    //                             INNER JOIN TM_SPARE_PARTS B ON B.CHR_PART_NO = A.CHR_PART_NO
    //                             WHERE (A.CHR_RACK_NO like '%".$FILTER."%' or B.CHR_SPECIFICATION like '%".$FILTER."%') AND A.CHR_CREATED_DATE = '20200221'
    //                             ORDER BY A.CHR_PART_NO");
    //     return $query->result();
    // }

    // Get data rack spare parts per area
    function get_data_all_rack_per_area($area, $FILTER) {
        $db_samanta = $this->load->database("samanta", TRUE);
        $query = $db_samanta->query("SELECT DISTINCT TOP 1000 A.*, B.CHR_SPECIFICATION FROM TM_SPARE_PARTS_ROUTING A
                                    INNER JOIN TM_SPARE_PARTS B ON B.CHR_PART_NO = A.CHR_PART_NO
                                    INNER JOIN TT_SPARE_PARTS_SLOC C ON C.CHR_PART_NO = A.CHR_PART_NO
                                    WHERE C.CHR_SLOC = '$area' AND (A.CHR_RACK_NO like '%".$FILTER."%' or A.CHR_BACK_NO like '%".$FILTER."%' or B.CHR_SPECIFICATION like '%".$FILTER."%')
                                    ORDER BY A.CHR_RACK_NO");
        return $query->result();
    }


    function get_all_rack_req() {
        $db_samanta = $this->load->database("samanta", TRUE);
        $query = $db_samanta->query("SELECT A.*, B.CHR_SPECIFICATION FROM TM_SPARE_PARTS_ROUTING A
        INNER JOIN TM_SPARE_PARTS B ON B.CHR_PART_NO = A.CHR_PART_NO 
        INNER JOIN TT_SPARE_PARTS_SLOC C ON C.CHR_PART_NO = A.CHR_PART_NO WHERE C.CHR_SLOC = 'MT03'
        ORDER BY A.CHR_RACK_NO ASC");
        return $query->result();
    }

    //Get data rack spare parts
    function get_spare_part_no() {
        $db_samanta = $this->load->database("samanta", TRUE);
        $query = $db_samanta->query("SELECT DISTINCT CHR_PART_NO, CHR_SPECIFICATION FROM TM_SPARE_PARTS");
        return $query->result();
    }

    function get_detil_spare_parts_route($part_no, $rack_no) {    
        $db_samanta = $this->load->database("samanta", TRUE);    
        $query = $db_samanta->query("SELECT * FROM TM_SPARE_PARTS_ROUTING WHERE CHR_PART_NO = '$part_no' AND CHR_RACK_NO = '$rack_no'");
        return $query;
    }

    function get_detil_back_no($part_no) {
        $db_samanta = $this->load->database("samanta", TRUE);
        $query = $db_samanta->query("SELECT CHR_BACK_NO FROM TM_SPARE_PARTS WHERE CHR_PART_NO = '$part_no'");
        return $query;
    }

    function save_sp($data) {
        $db_samanta = $this->load->database("samanta", TRUE);
        $db_samanta->insert($this->table_master_routing, $data);
    }

    function get_data_rack($id) {
        $db_samanta = $this->load->database("samanta", TRUE);
        $query = $db_samanta->query("SELECT * FROM TM_SPARE_PARTS_ROUTING WHERE INT_ID = '$id'");
        return $query;
    }

    function update_rack($data, $id) {
        $db_samanta = $this->load->database("samanta", TRUE);
        $db_samanta->where('INT_ID', $id);
        $db_samanta->update($this->table_master_routing, $data);
    }

    function delete_rack($id) {
        $db_samanta = $this->load->database("samanta", TRUE);
        $query = $db_samanta->query("DELETE FROM TM_SPARE_PARTS_ROUTING WHERE INT_ID = '$id'");
    }


    // =================================
    // improvement filter data sparepart 
    // start
    function get_data_rack_per_area($area) {
        $db_samanta = $this->load->database("samanta", TRUE);
        $query = $db_samanta->query("SELECT A.INT_ID, A.CHR_PART_NO, A.CHR_BACK_NO, B.CHR_SPECIFICATION FROM TM_SPARE_PARTS_ROUTING A
                                    INNER JOIN TM_SPARE_PARTS B ON B.CHR_PART_NO = A.CHR_PART_NO
                                    INNER JOIN TT_SPARE_PARTS_SLOC C ON C.CHR_PART_NO = A.CHR_PART_NO
                                    WHERE C.CHR_SLOC = '$area'
                                    ORDER BY A.CHR_RACK_NO");
        return $query->result();
    }
    // end
}