<?php

class report_line_stop_m extends CI_Model {

    private $tabel = 'TT_LINE_STOP_PROD';

    function __construct() {
        parent::__construct();
    }

    //Status Detail Line Stop
    function status_detail_line_stop_by_date_and_dept_and_work_center($date, $dept_id) {
        $period = intval($date);
        $stored_procedure = "EXEC MTE.zsp_get_detail_line_stop_machine_by_period_and_dept ?,?";
        $param = array(
            'periode' => $period,
            'dept' => $dept_id);

        $query = $this->db->query($stored_procedure, $param);

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return 0;
        }
    }
    
    //Status Detail Line Stop
    function select_data_available_machine_prod_by_period($period) {
        
        $stored_procedure = "EXEC MTE.zsp_get_data_available_machine_by_prod ?";
        $param = array(
            'periode' => $period);

        $query = $this->db->query($stored_procedure, $param);

        return $query->result();
    }
    
     //Status Detail Line Stop
    function select_data_available_machine_prod_by_period_excel($period) {
        
        $stored_procedure = "EXEC MTE.zsp_get_data_available_machine_by_prod_excel ?";
        $param = array(
            'periode' => $period);

        $query = $this->db->query($stored_procedure, $param);

        return $query->result();
    }
    
    
    //Summary available machine
    function select_summary_data_available_machine_by_period($period) {

        $stored_procedure = "EXEC MTE.zsp_get_summary_available_machine ?";
        $param = array(
            'period' => $period);

        $query = $this->db->query($stored_procedure, $param);

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return 0;
        }
    }
    
    //Data Detail Line Stop
    function select_data_detail_line_stop_by_date_and_dept_and_work_center($date, $dept_id) {
        $period = intval($date);
        $stored_procedure = "EXEC MTE.zsp_get_detail_line_stop_machine_by_period_and_dept ?,?";
        $param = array(
            'periode' => $period,
            'dept' => $dept_id);

        $query = $this->db->query($stored_procedure, $param);

        return $query->result();
    }

    
    //Excel Data Detail Line Stop
    function select_data_detail_line_stop_by_date_and_dept_and_work_center_excel($date, $dept_id) {
        $period = intval($date);

        $stored_procedure = "EXEC MTE.zsp_get_detail_line_stop_machine_by_period_and_dept ?,?";
        $param = array(
            'periode' => $period,
            'dept' => $dept_id);

        $query = $this->db->query($stored_procedure, $param);

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return 0;
        }
    }

    function select_data_line_stop_machine_by_period($date, $id_product_group){
        $stored_procedure = "EXEC MTE.zsp_get_detail_line_stop_machine ?, ?";
        $param = array(
            'date' => $date,
            'id_group' => $id_product_group
        );

        $query = $this->db->query($stored_procedure, $param)->result();

        return $query;
    }

    //----- UPDATE COMMENTS --- BY ANU 20190725 -----//
    function update_comments($data_row, $id){
        $this->db->where('INT_ID_LINE_STOP', $id);
        $this->db->update($this->tabel, $data_row);
    }
    //----- END -----//
    
    //MESIN
    function get_data_mtbf_by_year($year, $group_line) {
        $db_report = $this->load->database('db_report', TRUE);

        $param = array(
            'year' => $year,
            'group_line' => $group_line
        );

        $query = $db_report->query("EXEC zsp_get_data_mtbf ?,?" , $param);

        return $query->result();
    }

    function get_total_mtbf_by_year($year, $group_line){
        $db_report = $this->load->database('db_report', TRUE);

        if($group_line == 0){
            $group_line = '1,2,3,4,5';
        }

        $query = $db_report->query("SELECT LEFT(CHR_WORK_CENTER,4) CHR_WORK_CENTER, 
                ISNULL(SUM(WT01) / NULLIF(SUM(CLS01),0),0) COLUMN01, 
                ISNULL((SUM(WT02)+SUM(WT01)) / NULLIF((SUM(CLS02) + SUM(CLS01)),0),0) COLUMN02, 
                ISNULL((SUM(WT03)+SUM(WT02)+SUM(WT01)) / NULLIF((SUM(CLS03)+SUM(CLS02) + SUM(CLS01)),0),0) COLUMN03, 
                ISNULL((SUM(WT04)+SUM(WT03)+SUM(WT02)+SUM(WT01)) / NULLIF((SUM(CLS04)+SUM(CLS03)+SUM(CLS02) + SUM(CLS01)),0),0) COLUMN04, 
                ISNULL((SUM(WT05)+SUM(WT04)+SUM(WT03)+SUM(WT02)+SUM(WT01)) / NULLIF((SUM(CLS05)+SUM(CLS04)+SUM(CLS03)+SUM(CLS02) + SUM(CLS01)),0),0) COLUMN05, 
                ISNULL((SUM(WT06)+SUM(WT05)+SUM(WT04)+SUM(WT03)+SUM(WT02)+SUM(WT01)) / NULLIF((SUM(CLS06)+SUM(CLS05)+SUM(CLS04)+SUM(CLS03)+SUM(CLS02) + SUM(CLS01)),0),0) COLUMN06, 
                ISNULL((SUM(WT07)+SUM(WT06)+SUM(WT05)+SUM(WT04)+SUM(WT03)+SUM(WT02)+SUM(WT01)) / NULLIF((SUM(CLS07)+SUM(CLS06)+SUM(CLS05)+SUM(CLS04)+SUM(CLS03)+SUM(CLS02) + SUM(CLS01)),0),0) COLUMN07, 
                ISNULL((SUM(WT08)+SUM(WT07)+SUM(WT06)+SUM(WT05)+SUM(WT04)+SUM(WT03)+SUM(WT02)+SUM(WT01)) / NULLIF((SUM(CLS08)+SUM(CLS07)+SUM(CLS06)+SUM(CLS05)+SUM(CLS04)+SUM(CLS03)+SUM(CLS02) + SUM(CLS01)),0),0) COLUMN08, 
                ISNULL((SUM(WT09)+SUM(WT08)+SUM(WT07)+SUM(WT06)+SUM(WT05)+SUM(WT04)+SUM(WT03)+SUM(WT02)+SUM(WT01)) / NULLIF((SUM(CLS09)+SUM(CLS08)+SUM(CLS07)+SUM(CLS06)+SUM(CLS05)+SUM(CLS04)+SUM(CLS03)+SUM(CLS02) + SUM(CLS01)),0),0) COLUMN09, 
                ISNULL((SUM(WT10)+SUM(WT09)+SUM(WT08)+SUM(WT07)+SUM(WT06)+SUM(WT05)+SUM(WT04)+SUM(WT03)+SUM(WT02)+SUM(WT01)) / NULLIF((SUM(CLS10)+SUM(CLS09)+SUM(CLS08)+SUM(CLS07)+SUM(CLS06)+SUM(CLS05)+SUM(CLS04)+SUM(CLS03)+SUM(CLS02) + SUM(CLS01)),0),0) COLUMN10, 
                ISNULL((SUM(WT11)+SUM(WT10)+SUM(WT09)+SUM(WT08)+SUM(WT07)+SUM(WT06)+SUM(WT05)+SUM(WT04)+SUM(WT03)+SUM(WT02)+SUM(WT01)) / NULLIF((SUM(CLS11)+SUM(CLS10)+SUM(CLS09)+SUM(CLS08)+SUM(CLS07)+SUM(CLS06)+SUM(CLS05)+SUM(CLS04)+SUM(CLS03)+SUM(CLS02) + SUM(CLS01)),0),0) COLUMN11, 
                ISNULL((SUM(WT12)+SUM(WT11)+SUM(WT10)+SUM(WT09)+SUM(WT08)+SUM(WT07)+SUM(WT06)+SUM(WT05)+SUM(WT04)+SUM(WT03)+SUM(WT02)+SUM(WT01)) / NULLIF((SUM(CLS12)+SUM(CLS11)+SUM(CLS10)+SUM(CLS09)+SUM(CLS08)+SUM(CLS07)+SUM(CLS06)+SUM(CLS05)+SUM(CLS04)+SUM(CLS03)+SUM(CLS02) + SUM(CLS01)),0),0) COLUMN12
            FROM TR_MTBF WHERE INT_YEAR = '$year' AND CHR_GROUP_LINE IN ($group_line)
            GROUP BY LEFT(CHR_WORK_CENTER,4), CHR_GROUP_LINE");

        return $query->result();
    }

    function chart_mtbf_group_line_by_year($year) {
        $db_report = $this->load->database('db_report', TRUE);

        $query = $db_report->query("SELECT 
                CASE CHR_GROUP_LINE 
                    WHEN 1 THEN 'UNIT PARTS'
                    WHEN 2 THEN 'BODY PARTS'
                    WHEN 3 THEN 'DOOR LOCK'
                    WHEN 4 THEN 'DOOR FRAME' ELSE 'MANUFACTURE' END AS CHR_GROUP_LINE,
                ISNULL(SUM(WT01) / NULLIF(SUM(CLS01),0),0) COLUMN01, 
                ISNULL((SUM(WT02)+SUM(WT01)) / NULLIF((SUM(CLS02) + SUM(CLS01)),0),0) COLUMN02, 
                ISNULL((SUM(WT03)+SUM(WT02)+SUM(WT01)) / NULLIF((SUM(CLS03)+SUM(CLS02) + SUM(CLS01)),0),0) COLUMN03, 
                ISNULL((SUM(WT04)+SUM(WT03)+SUM(WT02)+SUM(WT01)) / NULLIF((SUM(CLS04)+SUM(CLS03)+SUM(CLS02) + SUM(CLS01)),0),0) COLUMN04, 
                ISNULL((SUM(WT05)+SUM(WT04)+SUM(WT03)+SUM(WT02)+SUM(WT01)) / NULLIF((SUM(CLS05)+SUM(CLS04)+SUM(CLS03)+SUM(CLS02) + SUM(CLS01)),0),0) COLUMN05, 
                ISNULL((SUM(WT06)+SUM(WT05)+SUM(WT04)+SUM(WT03)+SUM(WT02)+SUM(WT01)) / NULLIF((SUM(CLS06)+SUM(CLS05)+SUM(CLS04)+SUM(CLS03)+SUM(CLS02) + SUM(CLS01)),0),0) COLUMN06, 
                ISNULL((SUM(WT07)+SUM(WT06)+SUM(WT05)+SUM(WT04)+SUM(WT03)+SUM(WT02)+SUM(WT01)) / NULLIF((SUM(CLS07)+SUM(CLS06)+SUM(CLS05)+SUM(CLS04)+SUM(CLS03)+SUM(CLS02) + SUM(CLS01)),0),0) COLUMN07, 
                ISNULL((SUM(WT08)+SUM(WT07)+SUM(WT06)+SUM(WT05)+SUM(WT04)+SUM(WT03)+SUM(WT02)+SUM(WT01)) / NULLIF((SUM(CLS08)+SUM(CLS07)+SUM(CLS06)+SUM(CLS05)+SUM(CLS04)+SUM(CLS03)+SUM(CLS02) + SUM(CLS01)),0),0) COLUMN08, 
                ISNULL((SUM(WT09)+SUM(WT08)+SUM(WT07)+SUM(WT06)+SUM(WT05)+SUM(WT04)+SUM(WT03)+SUM(WT02)+SUM(WT01)) / NULLIF((SUM(CLS09)+SUM(CLS08)+SUM(CLS07)+SUM(CLS06)+SUM(CLS05)+SUM(CLS04)+SUM(CLS03)+SUM(CLS02) + SUM(CLS01)),0),0) COLUMN09, 
                ISNULL((SUM(WT10)+SUM(WT09)+SUM(WT08)+SUM(WT07)+SUM(WT06)+SUM(WT05)+SUM(WT04)+SUM(WT03)+SUM(WT02)+SUM(WT01)) / NULLIF((SUM(CLS10)+SUM(CLS09)+SUM(CLS08)+SUM(CLS07)+SUM(CLS06)+SUM(CLS05)+SUM(CLS04)+SUM(CLS03)+SUM(CLS02) + SUM(CLS01)),0),0) COLUMN10, 
                ISNULL((SUM(WT11)+SUM(WT10)+SUM(WT09)+SUM(WT08)+SUM(WT07)+SUM(WT06)+SUM(WT05)+SUM(WT04)+SUM(WT03)+SUM(WT02)+SUM(WT01)) / NULLIF((SUM(CLS11)+SUM(CLS10)+SUM(CLS09)+SUM(CLS08)+SUM(CLS07)+SUM(CLS06)+SUM(CLS05)+SUM(CLS04)+SUM(CLS03)+SUM(CLS02) + SUM(CLS01)),0),0) COLUMN11, 
                ISNULL((SUM(WT12)+SUM(WT11)+SUM(WT10)+SUM(WT09)+SUM(WT08)+SUM(WT07)+SUM(WT06)+SUM(WT05)+SUM(WT04)+SUM(WT03)+SUM(WT02)+SUM(WT01)) / NULLIF((SUM(CLS12)+SUM(CLS11)+SUM(CLS10)+SUM(CLS09)+SUM(CLS08)+SUM(CLS07)+SUM(CLS06)+SUM(CLS05)+SUM(CLS04)+SUM(CLS03)+SUM(CLS02) + SUM(CLS01)),0),0) COLUMN12
            FROM TR_MTBF WHERE INT_YEAR = '$year' 
            GROUP BY CHR_GROUP_LINE
        UNION ALL
            SELECT 'ALL' AS CHR_GROUP_LINE,
                ISNULL(SUM(WT01) / NULLIF(SUM(CLS01),0),0) COLUMN01, 
                ISNULL((SUM(WT02)+SUM(WT01)) / NULLIF((SUM(CLS02) + SUM(CLS01)),0),0) COLUMN02, 
                ISNULL((SUM(WT03)+SUM(WT02)+SUM(WT01)) / NULLIF((SUM(CLS03)+SUM(CLS02) + SUM(CLS01)),0),0) COLUMN03, 
                ISNULL((SUM(WT04)+SUM(WT03)+SUM(WT02)+SUM(WT01)) / NULLIF((SUM(CLS04)+SUM(CLS03)+SUM(CLS02) + SUM(CLS01)),0),0) COLUMN04, 
                ISNULL((SUM(WT05)+SUM(WT04)+SUM(WT03)+SUM(WT02)+SUM(WT01)) / NULLIF((SUM(CLS05)+SUM(CLS04)+SUM(CLS03)+SUM(CLS02) + SUM(CLS01)),0),0) COLUMN05, 
                ISNULL((SUM(WT06)+SUM(WT05)+SUM(WT04)+SUM(WT03)+SUM(WT02)+SUM(WT01)) / NULLIF((SUM(CLS06)+SUM(CLS05)+SUM(CLS04)+SUM(CLS03)+SUM(CLS02) + SUM(CLS01)),0),0) COLUMN06, 
                ISNULL((SUM(WT07)+SUM(WT06)+SUM(WT05)+SUM(WT04)+SUM(WT03)+SUM(WT02)+SUM(WT01)) / NULLIF((SUM(CLS07)+SUM(CLS06)+SUM(CLS05)+SUM(CLS04)+SUM(CLS03)+SUM(CLS02) + SUM(CLS01)),0),0) COLUMN07, 
                ISNULL((SUM(WT08)+SUM(WT07)+SUM(WT06)+SUM(WT05)+SUM(WT04)+SUM(WT03)+SUM(WT02)+SUM(WT01)) / NULLIF((SUM(CLS08)+SUM(CLS07)+SUM(CLS06)+SUM(CLS05)+SUM(CLS04)+SUM(CLS03)+SUM(CLS02) + SUM(CLS01)),0),0) COLUMN08, 
                ISNULL((SUM(WT09)+SUM(WT08)+SUM(WT07)+SUM(WT06)+SUM(WT05)+SUM(WT04)+SUM(WT03)+SUM(WT02)+SUM(WT01)) / NULLIF((SUM(CLS09)+SUM(CLS08)+SUM(CLS07)+SUM(CLS06)+SUM(CLS05)+SUM(CLS04)+SUM(CLS03)+SUM(CLS02) + SUM(CLS01)),0),0) COLUMN09, 
                ISNULL((SUM(WT10)+SUM(WT09)+SUM(WT08)+SUM(WT07)+SUM(WT06)+SUM(WT05)+SUM(WT04)+SUM(WT03)+SUM(WT02)+SUM(WT01)) / NULLIF((SUM(CLS10)+SUM(CLS09)+SUM(CLS08)+SUM(CLS07)+SUM(CLS06)+SUM(CLS05)+SUM(CLS04)+SUM(CLS03)+SUM(CLS02) + SUM(CLS01)),0),0) COLUMN10, 
                ISNULL((SUM(WT11)+SUM(WT10)+SUM(WT09)+SUM(WT08)+SUM(WT07)+SUM(WT06)+SUM(WT05)+SUM(WT04)+SUM(WT03)+SUM(WT02)+SUM(WT01)) / NULLIF((SUM(CLS11)+SUM(CLS10)+SUM(CLS09)+SUM(CLS08)+SUM(CLS07)+SUM(CLS06)+SUM(CLS05)+SUM(CLS04)+SUM(CLS03)+SUM(CLS02) + SUM(CLS01)),0),0) COLUMN11, 
                ISNULL((SUM(WT12)+SUM(WT11)+SUM(WT10)+SUM(WT09)+SUM(WT08)+SUM(WT07)+SUM(WT06)+SUM(WT05)+SUM(WT04)+SUM(WT03)+SUM(WT02)+SUM(WT01)) / NULLIF((SUM(CLS12)+SUM(CLS11)+SUM(CLS10)+SUM(CLS09)+SUM(CLS08)+SUM(CLS07)+SUM(CLS06)+SUM(CLS05)+SUM(CLS04)+SUM(CLS03)+SUM(CLS02) + SUM(CLS01)),0),0) COLUMN12
            FROM TR_MTBF WHERE INT_YEAR = '$year' 
        ");

        return $query->result();
    }

    function get_data_mttr_by_year($year, $group_line) {
        $db_report = $this->load->database('db_report', TRUE);

        $param = array(
            'year' => $year,
            'group_line' => $group_line

        );

        $query = $db_report->query("EXEC zsp_get_data_mttr ?, ?" , $param);

        return $query->result();
    }

    function get_total_mttr_by_year($year, $group_line){
        $db_report = $this->load->database('db_report', TRUE);

        if($group_line == 0){
            $group_line = '1,2,3,4,5';
        }

        $query = $db_report->query("SELECT LEFT(CHR_WORK_CENTER,4) CHR_WORK_CENTER, 
                ISNULL(SUM(WT01) / NULLIF(SUM(CLS01),0),0) COLUMN01, 
                ISNULL(SUM(WT02) / NULLIF(SUM(CLS02),0),0) COLUMN02, 
                ISNULL(SUM(WT03) / NULLIF(SUM(CLS03),0),0) COLUMN03, 
                ISNULL(SUM(WT04) / NULLIF(SUM(CLS04),0),0) COLUMN04, 
                ISNULL(SUM(WT05) / NULLIF(SUM(CLS05),0),0) COLUMN05, 
                ISNULL(SUM(WT06) / NULLIF(SUM(CLS06),0),0) COLUMN06, 
                ISNULL(SUM(WT07) / NULLIF(SUM(CLS07),0),0) COLUMN07, 
                ISNULL(SUM(WT08) / NULLIF(SUM(CLS08),0),0) COLUMN08, 
                ISNULL(SUM(WT09) / NULLIF(SUM(CLS09),0),0) COLUMN09, 
                ISNULL(SUM(WT10) / NULLIF(SUM(CLS10),0),0) COLUMN10, 
                ISNULL(SUM(WT11) / NULLIF(SUM(CLS11),0),0) COLUMN11, 
                ISNULL(SUM(WT12) / NULLIF(SUM(CLS12),0),0) COLUMN12
            FROM TR_MTTR WHERE INT_YEAR = '$year' AND CHR_GROUP_LINE IN ($group_line)
            GROUP BY LEFT(CHR_WORK_CENTER,4), CHR_GROUP_LINE");

        return $query->result();
    }

    function chart_mttr_group_line_by_year($year) {
        $db_report = $this->load->database('db_report', TRUE);

        $query = $db_report->query("	SELECT 
                CASE CHR_GROUP_LINE 
                    WHEN 1 THEN 'UNIT PARTS'
                    WHEN 2 THEN 'BODY PARTS'
                    WHEN 3 THEN 'DOOR LOCK'
                    WHEN 4 THEN 'DOOR FRAME' ELSE 'MANUFACTURE' END AS CHR_GROUP_LINE,
                ISNULL(SUM(WT01) / NULLIF(SUM(CLS01),0),0) COLUMN01, 
                ISNULL(SUM(WT02) / NULLIF(SUM(CLS02),0),0) COLUMN02, 
                ISNULL(SUM(WT03) / NULLIF(SUM(CLS03),0),0) COLUMN03, 
                ISNULL(SUM(WT04) / NULLIF(SUM(CLS04),0),0) COLUMN04, 
                ISNULL(SUM(WT05) / NULLIF(SUM(CLS05),0),0) COLUMN05, 
                ISNULL(SUM(WT06) / NULLIF(SUM(CLS06),0),0) COLUMN06, 
                ISNULL(SUM(WT07) / NULLIF(SUM(CLS07),0),0) COLUMN07, 
                ISNULL(SUM(WT08) / NULLIF(SUM(CLS08),0),0) COLUMN08, 
                ISNULL(SUM(WT09) / NULLIF(SUM(CLS09),0),0) COLUMN09, 
                ISNULL(SUM(WT10) / NULLIF(SUM(CLS10),0),0) COLUMN10, 
                ISNULL(SUM(WT11) / NULLIF(SUM(CLS11),0),0) COLUMN11, 
                ISNULL(SUM(WT12) / NULLIF(SUM(CLS12),0),0) COLUMN12
            FROM TR_MTTR WHERE INT_YEAR = '$year' 
            GROUP BY CHR_GROUP_LINE
        UNION ALL
            SELECT 'ALL' AS CHR_GROUP_LINE,
                ISNULL(SUM(WT01) / NULLIF(SUM(CLS01),0),0) COLUMN01, 
                ISNULL(SUM(WT02) / NULLIF(SUM(CLS02),0),0) COLUMN02, 
                ISNULL(SUM(WT03) / NULLIF(SUM(CLS03),0),0) COLUMN03, 
                ISNULL(SUM(WT04) / NULLIF(SUM(CLS04),0),0) COLUMN04, 
                ISNULL(SUM(WT05) / NULLIF(SUM(CLS05),0),0) COLUMN05, 
                ISNULL(SUM(WT06) / NULLIF(SUM(CLS06),0),0) COLUMN06, 
                ISNULL(SUM(WT07) / NULLIF(SUM(CLS07),0),0) COLUMN07, 
                ISNULL(SUM(WT08) / NULLIF(SUM(CLS08),0),0) COLUMN08, 
                ISNULL(SUM(WT09) / NULLIF(SUM(CLS09),0),0) COLUMN09, 
                ISNULL(SUM(WT10) / NULLIF(SUM(CLS10),0),0) COLUMN10, 
                ISNULL(SUM(WT11) / NULLIF(SUM(CLS11),0),0) COLUMN11, 
                ISNULL(SUM(WT12) / NULLIF(SUM(CLS12),0),0) COLUMN12
            FROM TR_MTTR WHERE INT_YEAR = '$year' 
        ");

        return $query->result();
    }

    //DIES/JIG
    function get_data_mtbf_dies_by_year($year, $group_line) {
        $db_report = $this->load->database('db_report', TRUE);

        $param = array(
            'year' => $year,
            'group_line' => $group_line

        );

        $query = $db_report->query("EXEC zsp_get_data_mtbf_dies ?, ?" , $param);

        return $query->result();
    }

    function get_total_mtbf_dies_by_year($year, $group_line){
        $db_report = $this->load->database('db_report', TRUE);

        if($group_line == 0){
            $group_line = '1,2,3,4,5';
        }

        $query = $db_report->query("SELECT LEFT(CHR_WORK_CENTER,4) CHR_WORK_CENTER, 
                ISNULL(SUM(WT01) / NULLIF(SUM(CLS01),0),0) COLUMN01, 
                ISNULL((SUM(WT02)+SUM(WT01)) / NULLIF((SUM(CLS02) + SUM(CLS01)),0),0) COLUMN02, 
                ISNULL((SUM(WT03)+SUM(WT02)+SUM(WT01)) / NULLIF((SUM(CLS03)+SUM(CLS02) + SUM(CLS01)),0),0) COLUMN03, 
                ISNULL((SUM(WT04)+SUM(WT03)+SUM(WT02)+SUM(WT01)) / NULLIF((SUM(CLS04)+SUM(CLS03)+SUM(CLS02) + SUM(CLS01)),0),0) COLUMN04, 
                ISNULL((SUM(WT05)+SUM(WT04)+SUM(WT03)+SUM(WT02)+SUM(WT01)) / NULLIF((SUM(CLS05)+SUM(CLS04)+SUM(CLS03)+SUM(CLS02) + SUM(CLS01)),0),0) COLUMN05, 
                ISNULL((SUM(WT06)+SUM(WT05)+SUM(WT04)+SUM(WT03)+SUM(WT02)+SUM(WT01)) / NULLIF((SUM(CLS06)+SUM(CLS05)+SUM(CLS04)+SUM(CLS03)+SUM(CLS02) + SUM(CLS01)),0),0) COLUMN06, 
                ISNULL((SUM(WT07)+SUM(WT06)+SUM(WT05)+SUM(WT04)+SUM(WT03)+SUM(WT02)+SUM(WT01)) / NULLIF((SUM(CLS07)+SUM(CLS06)+SUM(CLS05)+SUM(CLS04)+SUM(CLS03)+SUM(CLS02) + SUM(CLS01)),0),0) COLUMN07, 
                ISNULL((SUM(WT08)+SUM(WT07)+SUM(WT06)+SUM(WT05)+SUM(WT04)+SUM(WT03)+SUM(WT02)+SUM(WT01)) / NULLIF((SUM(CLS08)+SUM(CLS07)+SUM(CLS06)+SUM(CLS05)+SUM(CLS04)+SUM(CLS03)+SUM(CLS02) + SUM(CLS01)),0),0) COLUMN08, 
                ISNULL((SUM(WT09)+SUM(WT08)+SUM(WT07)+SUM(WT06)+SUM(WT05)+SUM(WT04)+SUM(WT03)+SUM(WT02)+SUM(WT01)) / NULLIF((SUM(CLS09)+SUM(CLS08)+SUM(CLS07)+SUM(CLS06)+SUM(CLS05)+SUM(CLS04)+SUM(CLS03)+SUM(CLS02) + SUM(CLS01)),0),0) COLUMN09, 
                ISNULL((SUM(WT10)+SUM(WT09)+SUM(WT08)+SUM(WT07)+SUM(WT06)+SUM(WT05)+SUM(WT04)+SUM(WT03)+SUM(WT02)+SUM(WT01)) / NULLIF((SUM(CLS10)+SUM(CLS09)+SUM(CLS08)+SUM(CLS07)+SUM(CLS06)+SUM(CLS05)+SUM(CLS04)+SUM(CLS03)+SUM(CLS02) + SUM(CLS01)),0),0) COLUMN10, 
                ISNULL((SUM(WT11)+SUM(WT10)+SUM(WT09)+SUM(WT08)+SUM(WT07)+SUM(WT06)+SUM(WT05)+SUM(WT04)+SUM(WT03)+SUM(WT02)+SUM(WT01)) / NULLIF((SUM(CLS11)+SUM(CLS10)+SUM(CLS09)+SUM(CLS08)+SUM(CLS07)+SUM(CLS06)+SUM(CLS05)+SUM(CLS04)+SUM(CLS03)+SUM(CLS02) + SUM(CLS01)),0),0) COLUMN11, 
                ISNULL((SUM(WT12)+SUM(WT11)+SUM(WT10)+SUM(WT09)+SUM(WT08)+SUM(WT07)+SUM(WT06)+SUM(WT05)+SUM(WT04)+SUM(WT03)+SUM(WT02)+SUM(WT01)) / NULLIF((SUM(CLS12)+SUM(CLS11)+SUM(CLS10)+SUM(CLS09)+SUM(CLS08)+SUM(CLS07)+SUM(CLS06)+SUM(CLS05)+SUM(CLS04)+SUM(CLS03)+SUM(CLS02) + SUM(CLS01)),0),0) COLUMN12
            FROM TR_MTBF_DIES WHERE INT_YEAR = '$year' AND CHR_GROUP_LINE IN ($group_line)
            GROUP BY LEFT(CHR_WORK_CENTER,4), CHR_GROUP_LINE");

        return $query->result();
    }

    function chart_mtbf_dies_group_line_by_year($year) {
        $db_report = $this->load->database('db_report', TRUE);

        $query = $db_report->query("SELECT 
                CASE CHR_GROUP_LINE 
                    WHEN 1 THEN 'UNIT PARTS'
                    WHEN 2 THEN 'BODY PARTS'
                    WHEN 3 THEN 'DOOR LOCK'
                    WHEN 4 THEN 'DOOR FRAME' ELSE 'MANUFACTURE' END AS CHR_GROUP_LINE,
                ISNULL(SUM(WT01) / NULLIF(SUM(CLS01),0),0) COLUMN01, 
                ISNULL((SUM(WT02)+SUM(WT01)) / NULLIF((SUM(CLS02) + SUM(CLS01)),0),0) COLUMN02, 
                ISNULL((SUM(WT03)+SUM(WT02)+SUM(WT01)) / NULLIF((SUM(CLS03)+SUM(CLS02) + SUM(CLS01)),0),0) COLUMN03, 
                ISNULL((SUM(WT04)+SUM(WT03)+SUM(WT02)+SUM(WT01)) / NULLIF((SUM(CLS04)+SUM(CLS03)+SUM(CLS02) + SUM(CLS01)),0),0) COLUMN04, 
                ISNULL((SUM(WT05)+SUM(WT04)+SUM(WT03)+SUM(WT02)+SUM(WT01)) / NULLIF((SUM(CLS05)+SUM(CLS04)+SUM(CLS03)+SUM(CLS02) + SUM(CLS01)),0),0) COLUMN05, 
                ISNULL((SUM(WT06)+SUM(WT05)+SUM(WT04)+SUM(WT03)+SUM(WT02)+SUM(WT01)) / NULLIF((SUM(CLS06)+SUM(CLS05)+SUM(CLS04)+SUM(CLS03)+SUM(CLS02) + SUM(CLS01)),0),0) COLUMN06, 
                ISNULL((SUM(WT07)+SUM(WT06)+SUM(WT05)+SUM(WT04)+SUM(WT03)+SUM(WT02)+SUM(WT01)) / NULLIF((SUM(CLS07)+SUM(CLS06)+SUM(CLS05)+SUM(CLS04)+SUM(CLS03)+SUM(CLS02) + SUM(CLS01)),0),0) COLUMN07, 
                ISNULL((SUM(WT08)+SUM(WT07)+SUM(WT06)+SUM(WT05)+SUM(WT04)+SUM(WT03)+SUM(WT02)+SUM(WT01)) / NULLIF((SUM(CLS08)+SUM(CLS07)+SUM(CLS06)+SUM(CLS05)+SUM(CLS04)+SUM(CLS03)+SUM(CLS02) + SUM(CLS01)),0),0) COLUMN08, 
                ISNULL((SUM(WT09)+SUM(WT08)+SUM(WT07)+SUM(WT06)+SUM(WT05)+SUM(WT04)+SUM(WT03)+SUM(WT02)+SUM(WT01)) / NULLIF((SUM(CLS09)+SUM(CLS08)+SUM(CLS07)+SUM(CLS06)+SUM(CLS05)+SUM(CLS04)+SUM(CLS03)+SUM(CLS02) + SUM(CLS01)),0),0) COLUMN09, 
                ISNULL((SUM(WT10)+SUM(WT09)+SUM(WT08)+SUM(WT07)+SUM(WT06)+SUM(WT05)+SUM(WT04)+SUM(WT03)+SUM(WT02)+SUM(WT01)) / NULLIF((SUM(CLS10)+SUM(CLS09)+SUM(CLS08)+SUM(CLS07)+SUM(CLS06)+SUM(CLS05)+SUM(CLS04)+SUM(CLS03)+SUM(CLS02) + SUM(CLS01)),0),0) COLUMN10, 
                ISNULL((SUM(WT11)+SUM(WT10)+SUM(WT09)+SUM(WT08)+SUM(WT07)+SUM(WT06)+SUM(WT05)+SUM(WT04)+SUM(WT03)+SUM(WT02)+SUM(WT01)) / NULLIF((SUM(CLS11)+SUM(CLS10)+SUM(CLS09)+SUM(CLS08)+SUM(CLS07)+SUM(CLS06)+SUM(CLS05)+SUM(CLS04)+SUM(CLS03)+SUM(CLS02) + SUM(CLS01)),0),0) COLUMN11, 
                ISNULL((SUM(WT12)+SUM(WT11)+SUM(WT10)+SUM(WT09)+SUM(WT08)+SUM(WT07)+SUM(WT06)+SUM(WT05)+SUM(WT04)+SUM(WT03)+SUM(WT02)+SUM(WT01)) / NULLIF((SUM(CLS12)+SUM(CLS11)+SUM(CLS10)+SUM(CLS09)+SUM(CLS08)+SUM(CLS07)+SUM(CLS06)+SUM(CLS05)+SUM(CLS04)+SUM(CLS03)+SUM(CLS02) + SUM(CLS01)),0),0) COLUMN12
            FROM TR_MTBF_DIES WHERE INT_YEAR = '$year' 
            GROUP BY CHR_GROUP_LINE
        UNION ALL
            SELECT 'ALL' AS CHR_GROUP_LINE,
                ISNULL(SUM(WT01) / NULLIF(SUM(CLS01),0),0) COLUMN01, 
                ISNULL((SUM(WT02)+SUM(WT01)) / NULLIF((SUM(CLS02) + SUM(CLS01)),0),0) COLUMN02, 
                ISNULL((SUM(WT03)+SUM(WT02)+SUM(WT01)) / NULLIF((SUM(CLS03)+SUM(CLS02) + SUM(CLS01)),0),0) COLUMN03, 
                ISNULL((SUM(WT04)+SUM(WT03)+SUM(WT02)+SUM(WT01)) / NULLIF((SUM(CLS04)+SUM(CLS03)+SUM(CLS02) + SUM(CLS01)),0),0) COLUMN04, 
                ISNULL((SUM(WT05)+SUM(WT04)+SUM(WT03)+SUM(WT02)+SUM(WT01)) / NULLIF((SUM(CLS05)+SUM(CLS04)+SUM(CLS03)+SUM(CLS02) + SUM(CLS01)),0),0) COLUMN05, 
                ISNULL((SUM(WT06)+SUM(WT05)+SUM(WT04)+SUM(WT03)+SUM(WT02)+SUM(WT01)) / NULLIF((SUM(CLS06)+SUM(CLS05)+SUM(CLS04)+SUM(CLS03)+SUM(CLS02) + SUM(CLS01)),0),0) COLUMN06, 
                ISNULL((SUM(WT07)+SUM(WT06)+SUM(WT05)+SUM(WT04)+SUM(WT03)+SUM(WT02)+SUM(WT01)) / NULLIF((SUM(CLS07)+SUM(CLS06)+SUM(CLS05)+SUM(CLS04)+SUM(CLS03)+SUM(CLS02) + SUM(CLS01)),0),0) COLUMN07, 
                ISNULL((SUM(WT08)+SUM(WT07)+SUM(WT06)+SUM(WT05)+SUM(WT04)+SUM(WT03)+SUM(WT02)+SUM(WT01)) / NULLIF((SUM(CLS08)+SUM(CLS07)+SUM(CLS06)+SUM(CLS05)+SUM(CLS04)+SUM(CLS03)+SUM(CLS02) + SUM(CLS01)),0),0) COLUMN08, 
                ISNULL((SUM(WT09)+SUM(WT08)+SUM(WT07)+SUM(WT06)+SUM(WT05)+SUM(WT04)+SUM(WT03)+SUM(WT02)+SUM(WT01)) / NULLIF((SUM(CLS09)+SUM(CLS08)+SUM(CLS07)+SUM(CLS06)+SUM(CLS05)+SUM(CLS04)+SUM(CLS03)+SUM(CLS02) + SUM(CLS01)),0),0) COLUMN09, 
                ISNULL((SUM(WT10)+SUM(WT09)+SUM(WT08)+SUM(WT07)+SUM(WT06)+SUM(WT05)+SUM(WT04)+SUM(WT03)+SUM(WT02)+SUM(WT01)) / NULLIF((SUM(CLS10)+SUM(CLS09)+SUM(CLS08)+SUM(CLS07)+SUM(CLS06)+SUM(CLS05)+SUM(CLS04)+SUM(CLS03)+SUM(CLS02) + SUM(CLS01)),0),0) COLUMN10, 
                ISNULL((SUM(WT11)+SUM(WT10)+SUM(WT09)+SUM(WT08)+SUM(WT07)+SUM(WT06)+SUM(WT05)+SUM(WT04)+SUM(WT03)+SUM(WT02)+SUM(WT01)) / NULLIF((SUM(CLS11)+SUM(CLS10)+SUM(CLS09)+SUM(CLS08)+SUM(CLS07)+SUM(CLS06)+SUM(CLS05)+SUM(CLS04)+SUM(CLS03)+SUM(CLS02) + SUM(CLS01)),0),0) COLUMN11, 
                ISNULL((SUM(WT12)+SUM(WT11)+SUM(WT10)+SUM(WT09)+SUM(WT08)+SUM(WT07)+SUM(WT06)+SUM(WT05)+SUM(WT04)+SUM(WT03)+SUM(WT02)+SUM(WT01)) / NULLIF((SUM(CLS12)+SUM(CLS11)+SUM(CLS10)+SUM(CLS09)+SUM(CLS08)+SUM(CLS07)+SUM(CLS06)+SUM(CLS05)+SUM(CLS04)+SUM(CLS03)+SUM(CLS02) + SUM(CLS01)),0),0) COLUMN12
            FROM TR_MTBF_DIES WHERE INT_YEAR = '$year' 
        ");

        return $query->result();
    }

    function get_data_mttr_dies_by_year($period, $group_line) {
        $db_report = $this->load->database('db_report', TRUE);

        $param = array(
            'period' => $period,
            'group_line' => $group_line
        );

        $query = $db_report->query("EXEC zsp_get_data_mttr_dies ?, ?" , $param);

        return $query->result();
    }

    function get_total_mttr_dies_by_year($year, $group_line) {
        $db_report = $this->load->database('db_report', TRUE);

        if($group_line == 0){
            $group_line = '1,2,3,4,5';
        }

        $query = $db_report->query("SELECT LEFT(CHR_WORK_CENTER,4) CHR_WORK_CENTER, 
            ISNULL(SUM(WT01) / NULLIF(SUM(CLS01),0),0) COLUMN01, 
            ISNULL(SUM(WT02) / NULLIF(SUM(CLS02),0),0) COLUMN02, 
            ISNULL(SUM(WT03) / NULLIF(SUM(CLS03),0),0) COLUMN03, 
            ISNULL(SUM(WT04) / NULLIF(SUM(CLS04),0),0) COLUMN04, 
            ISNULL(SUM(WT05) / NULLIF(SUM(CLS05),0),0) COLUMN05, 
            ISNULL(SUM(WT06) / NULLIF(SUM(CLS06),0),0) COLUMN06, 
            ISNULL(SUM(WT07) / NULLIF(SUM(CLS07),0),0) COLUMN07, 
            ISNULL(SUM(WT08) / NULLIF(SUM(CLS08),0),0) COLUMN08, 
            ISNULL(SUM(WT09) / NULLIF(SUM(CLS09),0),0) COLUMN09, 
            ISNULL(SUM(WT10) / NULLIF(SUM(CLS10),0),0) COLUMN10, 
            ISNULL(SUM(WT11) / NULLIF(SUM(CLS11),0),0) COLUMN11, 
            ISNULL(SUM(WT12) / NULLIF(SUM(CLS12),0),0) COLUMN12
        FROM TR_MTTR_DIES WHERE INT_YEAR = '$year' AND CHR_GROUP_LINE IN ($group_line)
        GROUP BY LEFT(CHR_WORK_CENTER,4), CHR_GROUP_LINE");

        return $query->result();
    }

    function chart_mttr_dies_group_line_by_year($year) {
        $db_report = $this->load->database('db_report', TRUE);

        $query = $db_report->query("	SELECT 
                CASE CHR_GROUP_LINE 
                    WHEN 1 THEN 'UNIT PARTS'
                    WHEN 2 THEN 'BODY PARTS'
                    WHEN 3 THEN 'DOOR LOCK'
                    WHEN 4 THEN 'DOOR FRAME' ELSE 'MANUFACTURE' END AS CHR_GROUP_LINE,
                ISNULL(SUM(WT01) / NULLIF(SUM(CLS01),0),0) COLUMN01, 
                ISNULL(SUM(WT02) / NULLIF(SUM(CLS02),0),0) COLUMN02, 
                ISNULL(SUM(WT03) / NULLIF(SUM(CLS03),0),0) COLUMN03, 
                ISNULL(SUM(WT04) / NULLIF(SUM(CLS04),0),0) COLUMN04, 
                ISNULL(SUM(WT05) / NULLIF(SUM(CLS05),0),0) COLUMN05, 
                ISNULL(SUM(WT06) / NULLIF(SUM(CLS06),0),0) COLUMN06, 
                ISNULL(SUM(WT07) / NULLIF(SUM(CLS07),0),0) COLUMN07, 
                ISNULL(SUM(WT08) / NULLIF(SUM(CLS08),0),0) COLUMN08, 
                ISNULL(SUM(WT09) / NULLIF(SUM(CLS09),0),0) COLUMN09, 
                ISNULL(SUM(WT10) / NULLIF(SUM(CLS10),0),0) COLUMN10, 
                ISNULL(SUM(WT11) / NULLIF(SUM(CLS11),0),0) COLUMN11, 
                ISNULL(SUM(WT12) / NULLIF(SUM(CLS12),0),0) COLUMN12
            FROM TR_MTTR_DIES WHERE INT_YEAR = '$year' 
            GROUP BY CHR_GROUP_LINE
        UNION ALL
            SELECT 'ALL' AS CHR_GROUP_LINE,
                ISNULL(SUM(WT01) / NULLIF(SUM(CLS01),0),0) COLUMN01, 
                ISNULL(SUM(WT02) / NULLIF(SUM(CLS02),0),0) COLUMN02, 
                ISNULL(SUM(WT03) / NULLIF(SUM(CLS03),0),0) COLUMN03, 
                ISNULL(SUM(WT04) / NULLIF(SUM(CLS04),0),0) COLUMN04, 
                ISNULL(SUM(WT05) / NULLIF(SUM(CLS05),0),0) COLUMN05, 
                ISNULL(SUM(WT06) / NULLIF(SUM(CLS06),0),0) COLUMN06, 
                ISNULL(SUM(WT07) / NULLIF(SUM(CLS07),0),0) COLUMN07, 
                ISNULL(SUM(WT08) / NULLIF(SUM(CLS08),0),0) COLUMN08, 
                ISNULL(SUM(WT09) / NULLIF(SUM(CLS09),0),0) COLUMN09, 
                ISNULL(SUM(WT10) / NULLIF(SUM(CLS10),0),0) COLUMN10, 
                ISNULL(SUM(WT11) / NULLIF(SUM(CLS11),0),0) COLUMN11, 
                ISNULL(SUM(WT12) / NULLIF(SUM(CLS12),0),0) COLUMN12
            FROM TR_MTTR_DIES WHERE INT_YEAR = '$year' 
        ");

        return $query->result();
    }

    function get_data_linestop_by_id($id){
       $query = $this->db->query("SELECT * FROM TT_LINE_STOP_PROD WHERE INT_ID_LINE_STOP = '$id'")->row();

        return $query;
    }

    function get_data_repair_by_id_ls($id){
        $query = $this->db->query(" SELECT LS.INT_ID_LINE_STOP, CHR_MACHINE, BR.CHR_PROBLEM,
        CHR_PROBLEM_DESC, CHR_CORRECTIVE_ACTION, INT_FLG_SPAREPART,
        INT_QTY, CHR_NOTE, LS.CHR_CREATED_DATE, CHR_LINE_CODE FROM TT_LINE_STOP_PROD LS 
        LEFT JOIN MTE.TT_REPAIR_BREAKDOWN BR 
        ON LS.INT_ID_LINE_STOP = BR.INT_ID_LINE_STOP 
        WHERE LS.INT_ID_LINE_STOP = '$id'")->row();

        return $query;
    }
}
?>

