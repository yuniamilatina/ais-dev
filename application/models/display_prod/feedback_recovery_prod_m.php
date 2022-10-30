<?php

class feedback_recovery_prod_m extends CI_Model {

    private $tabel = "PRD.TT_PROBLEM_AND_CORRECTIVE";

    public function __construct() {
        parent::__construct();
    }

    function get_all_data_problem_and_recovery($date) {
                        return $query = $this->db->query("SELECT  CHR_WO_NUMBER, CHR_PROBLEM, CHR_CORRECTIVE_ACTION, CHR_START, CHR_END, CHR_CREATED_BY, CHR_CREATED_DATE,
                        ISNULL(
                            SUBSTRING(
                            CONVERT(VARCHAR,CONVERT(DATETIME,(CHR_CREATED_DATE + ' ' +SUBSTRING(CAST(REPLACE(CHR_END, ':', '') AS VARCHAR(20)), 0, 3) + ':' + SUBSTRING(CAST(REPLACE(CHR_END, ':', '') AS VARCHAR(20)), 3, 2) + ':' + SUBSTRING(CAST(REPLACE(CHR_END, ':', '') AS VARCHAR(20)), 5, 2)),126)
                            - CONVERT(DATETIME,(CHR_CREATED_DATE + ' ' + SUBSTRING(CAST(REPLACE(CHR_START, ':', '') AS VARCHAR(20)), 0, 3) + ':' + SUBSTRING(CAST(REPLACE(CHR_START, ':', '') AS VARCHAR(20)), 3, 2) + ':' + SUBSTRING(CAST(REPLACE(CHR_START, ':', '') AS VARCHAR(20)), 5, 2)),126),108) 
                            ,1,2) * 60
                            +
                            SUBSTRING(
                            CONVERT(VARCHAR,CONVERT(DATETIME,(CHR_CREATED_DATE + ' ' +SUBSTRING(CAST(REPLACE(CHR_END, ':', '') AS VARCHAR(20)), 0, 3) + ':' + SUBSTRING(CAST(REPLACE(CHR_END, ':', '') AS VARCHAR(20)), 3, 2) + ':' + SUBSTRING(CAST(REPLACE(CHR_END, ':', '') AS VARCHAR(20)), 5, 2)),126)
                            - CONVERT(DATETIME,(CHR_CREATED_DATE + ' ' + SUBSTRING(CAST(REPLACE(CHR_START, ':', '') AS VARCHAR(20)), 0, 3) + ':' + SUBSTRING(CAST(REPLACE(CHR_START, ':', '') AS VARCHAR(20)), 3, 2) + ':' + SUBSTRING(CAST(REPLACE(CHR_START, ':', '') AS VARCHAR(20)), 5, 2)),126),108) 
                            ,4,2) 
                        ,0)
                        AS DURATION
                    FROM $this->tabel WHERE INT_FLG_DEL = 0 AND SUBSTRING(CHR_WO_NUMBER,8,8) =  $date ORDER BY 
                    ISNULL(
                            SUBSTRING(
                            CONVERT(VARCHAR,CONVERT(DATETIME,(CHR_CREATED_DATE + ' ' +SUBSTRING(CAST(REPLACE(CHR_END, ':', '') AS VARCHAR(20)), 0, 3) + ':' + SUBSTRING(CAST(REPLACE(CHR_END, ':', '') AS VARCHAR(20)), 3, 2) + ':' + SUBSTRING(CAST(REPLACE(CHR_END, ':', '') AS VARCHAR(20)), 5, 2)),126)
                            - CONVERT(DATETIME,(CHR_CREATED_DATE + ' ' + SUBSTRING(CAST(REPLACE(CHR_START, ':', '') AS VARCHAR(20)), 0, 3) + ':' + SUBSTRING(CAST(REPLACE(CHR_START, ':', '') AS VARCHAR(20)), 3, 2) + ':' + SUBSTRING(CAST(REPLACE(CHR_START, ':', '') AS VARCHAR(20)), 5, 2)),126),108) 
                            ,1,2) * 60
                            +
                            SUBSTRING(
                            CONVERT(VARCHAR,CONVERT(DATETIME,(CHR_CREATED_DATE + ' ' +SUBSTRING(CAST(REPLACE(CHR_END, ':', '') AS VARCHAR(20)), 0, 3) + ':' + SUBSTRING(CAST(REPLACE(CHR_END, ':', '') AS VARCHAR(20)), 3, 2) + ':' + SUBSTRING(CAST(REPLACE(CHR_END, ':', '') AS VARCHAR(20)), 5, 2)),126)
                            - CONVERT(DATETIME,(CHR_CREATED_DATE + ' ' + SUBSTRING(CAST(REPLACE(CHR_START, ':', '') AS VARCHAR(20)), 0, 3) + ':' + SUBSTRING(CAST(REPLACE(CHR_START, ':', '') AS VARCHAR(20)), 3, 2) + ':' + SUBSTRING(CAST(REPLACE(CHR_START, ':', '') AS VARCHAR(20)), 5, 2)),126),108) 
                            ,4,2) 
                        ,0) DESC")->result();
    }

    function get_data_problem_and_recovery($date) {
        return $query = $this->db->query("SELECT * from $this->tabel WHERE INT_FLG_DEL = 0 AND LEFT(CHR_CREATED_DATE,6) =  '$date' ORDER BY CHR_CREATED_DATE DESC, CHR_CREATED_TIME DESC" )->result();
    }

    //additional
    function get_all_work_center_by_dept($id_dept) {
        return $query = $this->db->query("SELECT CHR_WORK_CENTER FROM TM_INLINE_SCAN WHERE INT_ID_DEPT = $id_dept AND CHR_WORK_CENTER <> 'OTHER' GROUP BY CHR_WORK_CENTER")->result();
    }

    function get_all_work_center() {
        return $query = $this->db->query("SELECT CHR_WORK_CENTER FROM TM_INLINE_SCAN GROUP BY CHR_WORK_CENTER")->result();
    }

    function get_data_by_workcenter_and_date($work_center, $date){

        $wo = $work_center.'/'.$date;

        return $query = $this->db->query("SELECT  CHR_WO_NUMBER, CHR_PROBLEM, CHR_CORRECTIVE_ACTION, CHR_START, CHR_END, CHR_CREATED_BY, CHR_CREATED_DATE,
                ISNULL(
                    SUBSTRING(
                    CONVERT(VARCHAR,CONVERT(DATETIME,(CHR_CREATED_DATE + ' ' +SUBSTRING(CAST(REPLACE(CHR_END, ':', '') AS VARCHAR(20)), 0, 3) + ':' + SUBSTRING(CAST(REPLACE(CHR_END, ':', '') AS VARCHAR(20)), 3, 2) + ':' + SUBSTRING(CAST(REPLACE(CHR_END, ':', '') AS VARCHAR(20)), 5, 2)),126)
                    - CONVERT(DATETIME,(CHR_CREATED_DATE + ' ' + SUBSTRING(CAST(REPLACE(CHR_START, ':', '') AS VARCHAR(20)), 0, 3) + ':' + SUBSTRING(CAST(REPLACE(CHR_START, ':', '') AS VARCHAR(20)), 3, 2) + ':' + SUBSTRING(CAST(REPLACE(CHR_START, ':', '') AS VARCHAR(20)), 5, 2)),126),108) 
                    ,1,2) * 60
                    +
                    SUBSTRING(
                    CONVERT(VARCHAR,CONVERT(DATETIME,(CHR_CREATED_DATE + ' ' +SUBSTRING(CAST(REPLACE(CHR_END, ':', '') AS VARCHAR(20)), 0, 3) + ':' + SUBSTRING(CAST(REPLACE(CHR_END, ':', '') AS VARCHAR(20)), 3, 2) + ':' + SUBSTRING(CAST(REPLACE(CHR_END, ':', '') AS VARCHAR(20)), 5, 2)),126)
                    - CONVERT(DATETIME,(CHR_CREATED_DATE + ' ' + SUBSTRING(CAST(REPLACE(CHR_START, ':', '') AS VARCHAR(20)), 0, 3) + ':' + SUBSTRING(CAST(REPLACE(CHR_START, ':', '') AS VARCHAR(20)), 3, 2) + ':' + SUBSTRING(CAST(REPLACE(CHR_START, ':', '') AS VARCHAR(20)), 5, 2)),126),108) 
                    ,4,2) 
                ,0)
                AS DURATION
            FROM PRD.TT_PROBLEM_AND_CORRECTIVE WHERE INT_FLG_DEL = 0 AND CHR_WO_NUMBER LIKE '$wo%' ORDER BY 
            ISNULL(
                    SUBSTRING(
                    CONVERT(VARCHAR,CONVERT(DATETIME,(CHR_CREATED_DATE + ' ' +SUBSTRING(CAST(REPLACE(CHR_END, ':', '') AS VARCHAR(20)), 0, 3) + ':' + SUBSTRING(CAST(REPLACE(CHR_END, ':', '') AS VARCHAR(20)), 3, 2) + ':' + SUBSTRING(CAST(REPLACE(CHR_END, ':', '') AS VARCHAR(20)), 5, 2)),126)
                    - CONVERT(DATETIME,(CHR_CREATED_DATE + ' ' + SUBSTRING(CAST(REPLACE(CHR_START, ':', '') AS VARCHAR(20)), 0, 3) + ':' + SUBSTRING(CAST(REPLACE(CHR_START, ':', '') AS VARCHAR(20)), 3, 2) + ':' + SUBSTRING(CAST(REPLACE(CHR_START, ':', '') AS VARCHAR(20)), 5, 2)),126),108) 
                    ,1,2) * 60
                    +
                    SUBSTRING(
                    CONVERT(VARCHAR,CONVERT(DATETIME,(CHR_CREATED_DATE + ' ' +SUBSTRING(CAST(REPLACE(CHR_END, ':', '') AS VARCHAR(20)), 0, 3) + ':' + SUBSTRING(CAST(REPLACE(CHR_END, ':', '') AS VARCHAR(20)), 3, 2) + ':' + SUBSTRING(CAST(REPLACE(CHR_END, ':', '') AS VARCHAR(20)), 5, 2)),126)
                    - CONVERT(DATETIME,(CHR_CREATED_DATE + ' ' + SUBSTRING(CAST(REPLACE(CHR_START, ':', '') AS VARCHAR(20)), 0, 3) + ':' + SUBSTRING(CAST(REPLACE(CHR_START, ':', '') AS VARCHAR(20)), 3, 2) + ':' + SUBSTRING(CAST(REPLACE(CHR_START, ':', '') AS VARCHAR(20)), 5, 2)),126),108) 
                    ,4,2) 
                ,0) DESC")->result();
    }

    function get_data_line_stop_by_workcenter_and_date($work_center, $date){
        $wo = $work_center.'/'.$date;
        return $query = $this->db->query("SELECT A.CHR_LINE_CODE, B.CHR_LINE_STOP, SUM(INT_DURASI_LS) AS TOTAL_LINE_STOP
                                        FROM TT_LINE_STOP_PROD A
                                        LEFT JOIN TM_LINE_STOP B ON A.CHR_LINE_CODE = B.CHR_LINE_CODE
                                        WHERE CHR_WO_NUMBER LIKE '$wo%'
                                        GROUP BY A.CHR_LINE_CODE, B.CHR_LINE_STOP")->result();
    }

    function save($data) {
        $this->db->insert($this->tabel, $data);
    }

    function delete($id) {
        $data = array('INT_FLG_DEL' => 1);

        $this->db->where('INT_ID', $id);
        $this->db->update($this->tabel, $data);
    }

    function update_time($data, $id){
        $this->db->where('INT_ID', $id);
        $this->db->update($this->tabel, $data);
    }

    function update($data, $id) {
        $this->db->where('INT_ID', $id);
        $this->db->update($this->tabel, $data);

        $problem = $data['CHR_FEEDBACK'];
        $wo_no = $data['CHR_WO_NUMBER'];
        $work_center = substr($wo_no, 0, 6);

        $db_display = $this->get_db_display($work_center);

        $db_display->query("UPDATE `disp_ops_master` SET `chr_feedback` = '$problem' WHERE chr_doc_id = '$wo_no' ");
    }

    function get_data_problem_and_recovery_by_id($id) {
        $query = $this->db->query("SELECt  LEFT(CHR_WO_NUMBER,6) AS CHR_WORK_CENTER,
            LEFT(CHR_START,2) JAM_START, SUBSTRING(CHR_START,4,2) MENIT_START,
            LEFT(CHR_END,2) JAM_END, SUBSTRING(CHR_END,4,2) MENIT_END, * from PRD.TT_PROBLEM_AND_CORRECTIVE WHERE INT_ID = $id");

        return $query;
    }

    function get_chart_percentage_per_work_center($work_center, $date){

        $wo = trim($work_center) .'/'. $date .'/';

        $query = $this->db->query("DECLARE
        @wo_number VARCHAR(22) = '$wo',
        @eff float,
        @plannning int,
        @ct int
        
        SELECT @plannning = CONVERT(FLOAT,SUM(INT_PLAN_CT)) , @eff = CONVERT(FLOAT,SUM(INT_ACTUAL)) / CONVERT(FLOAT,SUM(INT_PLAN_CT)) * 100 
        FROM PRD.TM_PRODUCTION_ACTIVITY 
        WHERE LEFT(CHR_WO_NUMBER,16) = LEFT(@wo_number,16) AND CHR_WORK_CENTER = LEFT(@wo_number,6)
        
        --SELECT @ct = AVG(PP.INT_CYCLE_TIME) FROM TT_PRODUCTION_RESULT PR INNER JOIN TM_PROCESS_PARTS PP ON PP.CHR_PART_NO = PR.CHR_PART_NO
        --WHERE LEFT(CHR_WO_NUMBER,16) = LEFT(@wo_number,16) AND PR.CHR_WORK_CENTER = LEFT(@wo_number,6)
        --GROUP BY PR.CHR_WORK_CENTER

        -- Update by ANU 20191129 --
        SELECT @ct = AVG(INT_CYCLE_TIME)FROM TM_PROCESS_PARTS
        WHERE CHR_WORK_CENTER = LEFT(@wo_number,6)
        GROUP BY CHR_WORK_CENTER
        -- End Update by ANU 20191129 --
        
        SELECT 'Productivity' CHR_CATEGORY , ROUND(@eff,2) AS CHR_PERC
        UNION ALL
        SELECT S.CHR_LINE_STOP, ROUND(CONVERT(FLOAT,SUM(INT_DURASI_LS) * 60 ) / @ct / @plannning * 100,2) AS CHR_PERC
        FROM TT_LINE_STOP_PROD LS INNER JOIN TM_LINE_STOP S ON S.CHR_LINE_CODE = LS.CHR_LINE_CODE
         WHERE LEFT(CHR_WO_NUMBER,16) = LEFT(@wo_number,16) 
         AND INT_DURASI_LS IS NOT NULL AND INT_DURASI_LS <> 0
         -- Update by ANU 20191129 --
         AND LS.CHR_LINE_CODE NOT IN ('LS14')
         -- End Update by ANU 20191129 --
        GROUP BY S.CHR_LINE_STOP
        ORDER BY CHR_PERC ASC
        
        ");

        return $query->result();
    }

    //add display connection base on work center
    function get_db_display($work_center) {
        if ($work_center == 'ASCC01') {
            $db_display = $this->load->database('ASCC01', TRUE);
        } else
        if ($work_center == 'ASCC02') {
            $db_display = $this->load->database('ASCC02', TRUE);
        } else if ($work_center == 'ASCC03') {
            $db_display = $this->load->database('ASCC03', TRUE);
        } else if ($work_center == 'ASCC04') {
            $db_display = $this->load->database('ASCC04', TRUE);
        } else if ($work_center == 'ASCC05') {
            $db_display = $this->load->database('ASCC05', TRUE);
        } else if ($work_center == 'ASCD01') {
            $db_display = $this->load->database('ASCD01', TRUE);
        } else if ($work_center == 'ASCD02') {
            $db_display = $this->load->database('ASCD02', TRUE);
        } else if ($work_center == 'ASCD03') {
            $db_display = $this->load->database('ASCD03', TRUE);
        } else if ($work_center == 'ASCH01') {
            $db_display = $this->load->database('ASCH01', TRUE);
        } else if ($work_center == 'ASDL01') {
            $db_display = $this->load->database('ASDL01', TRUE);
        } else if ($work_center == 'ASDL02') {
            $db_display = $this->load->database('ASDL02', TRUE);
        } else if ($work_center == 'ASDL03') {
            $db_display = $this->load->database('ASDL03', TRUE);
        } else if ($work_center == 'ASDL04') {
            $db_display = $this->load->database('ASDL04', TRUE);
        } else if ($work_center == 'ASDL05') {
            $db_display = $this->load->database('ASDL05', TRUE);
        } else if ($work_center == 'ASDL07') {
            $db_display = $this->load->database('ASDL07', TRUE);
        } else if ($work_center == 'ASDL08') {
            $db_display = $this->load->database('ASDL08', TRUE);
        } 
        else if ($work_center == 'ASDL09') {
            $db_display = $this->load->database('ASDL09', TRUE);
        } 
        else if ($work_center == 'ASDL10') {
            $db_display = $this->load->database('ASDL10', TRUE);
        } else if ($work_center == 'ASIM01') {
            $db_display = $this->load->database('ASIM01', TRUE);
        } else if ($work_center == 'ASIM02') {
            $db_display = $this->load->database('ASIM02', TRUE);
        } else if ($work_center == 'ASIM03') {
            $db_display = $this->load->database('ASIM03', TRUE);
        } else if ($work_center == 'ASDH01') {
            $db_display = $this->load->database('ASDH01', TRUE);
        } else if ($work_center == 'ASDH02') {
            $db_display = $this->load->database('ASDH02', TRUE);
        } else if ($work_center == 'ASHL01') {
            $db_display = $this->load->database('ASHL01', TRUE);
        } else if ($work_center == 'ASHL02') {
            $db_display = $this->load->database('ASHL02', TRUE);
        } else if ($work_center == 'ASCA01') {
            $db_display = $this->load->database('ASCA01', TRUE);
        } else if ($work_center == 'ASCA02') {
            $db_display = $this->load->database('ASCA02', TRUE);
        } else if ($work_center == 'ASRH01') {
            $db_display = $this->load->database('ASRH01', TRUE);
        } else if ($work_center == 'ASDF01') {
            $db_display = $this->load->database('ASDF01', TRUE);
        } else if ($work_center == 'ASDF02') {
            $db_display = $this->load->database('ASDF02', TRUE);
        } else if ($work_center == 'ASDF03') {
            $db_display = $this->load->database('ASDF03', TRUE);
        } else if ($work_center == 'ASDF04') {
            $db_display = $this->load->database('ASDF04', TRUE);
        } else if ($work_center == 'ASDF05') {
            $db_display = $this->load->database('ASDF05', TRUE);
        } else if ($work_center == 'ASDF06') {
            $db_display = $this->load->database('ASDF06', TRUE);
        } else if ($work_center == 'ASDF07') {
            $db_display = $this->load->database('ASDF07', TRUE);
        } else if ($work_center == 'ASDF08') {
            $db_display = $this->load->database('ASDF08', TRUE);
        } else if ($work_center == 'ASDF09') {
            $db_display = $this->load->database('ASDF09', TRUE);
        } else if ($work_center == 'ASDF10') {
            $db_display = $this->load->database('ASDF10', TRUE);
        } else if ($work_center == 'ASDF11') {
            $db_display = $this->load->database('ASDF11', TRUE);
        } else if ($work_center == 'ASIM04') {
            $db_display = $this->load->database('ASIM04', TRUE);
        } else if ($work_center == 'ASDL12') {
            $db_display = $this->load->database('ASDL12', TRUE);
        } else if ($work_center == 'ASDL13') {
            $db_display = $this->load->database('ASDL13', TRUE);
        } else if ($work_center == 'PC003A') {
            $db_display = $this->load->database('PC003A', TRUE);
        } else if ($work_center == 'PC003B') {
            $db_display = $this->load->database('PC003B', TRUE);
        } else if ($work_center == 'PC003C') {
            $db_display = $this->load->database('PC003C', TRUE);
        } else if ($work_center == 'PC003D') {
            $db_display = $this->load->database('PC003D', TRUE);
        } else if ($work_center == 'PC003E') {
            $db_display = $this->load->database('PC003E', TRUE);
        } else if ($work_center == 'PC003F') {
            $db_display = $this->load->database('PC003F', TRUE);
        } else if ($work_center == 'PC003G') {
            $db_display = $this->load->database('PC003G', TRUE);
        } else if ($work_center == 'PC003I') {
            $db_display = $this->load->database('PC003I', TRUE);
        } else if ($work_center == 'PC001A') {
            $db_display = $this->load->database('PC001A', TRUE);
        } else if ($work_center == 'PC001B') {
            $db_display = $this->load->database('PC001B', TRUE);
        } else if ($work_center == 'PC001C') {
            $db_display = $this->load->database('PC001C', TRUE);
        } else if ($work_center == 'PC001D') {
            $db_display = $this->load->database('PC001D', TRUE);
        } else if ($work_center == 'PK0002') {
            $db_display = $this->load->database('PK0002', TRUE);
        } else if ($work_center == 'PR001A') {
            $db_display = $this->load->database('PR001A', TRUE);
        } else if ($work_center == 'PR001B') {
            $db_display = $this->load->database('PR001B', TRUE);
        } else if ($work_center == 'PR002A') {
            $db_display = $this->load->database('PR002A', TRUE);
        } else if ($work_center == 'PR002B') {
            $db_display = $this->load->database('PR002B', TRUE);
        } else if ($work_center == 'PR002C') {
            $db_display = $this->load->database('PR002C', TRUE);
        } else if ($work_center == 'PR002D') {
            $db_display = $this->load->database('PR002D', TRUE);
        } else if ($work_center == 'PR002E') {
            $db_display = $this->load->database('PR002E', TRUE);
        } 
        else if ($work_center == 'PR003A') {
            $db_display = $this->load->database('PR003A', TRUE);
        } else if ($work_center == 'PR003B') {
            $db_display = $this->load->database('PR003B', TRUE);
        } else if ($work_center == 'PR003C') {
            $db_display = $this->load->database('PR003C', TRUE);
        } 
        else if ($work_center == 'PR005B') {
            $db_display = $this->load->database('PR005B', TRUE);
        } else if ($work_center == 'PR004C') {
            $db_display = $this->load->database('PR004C', TRUE);
        } else if ($work_center == 'PR006Q') {
            $db_display = $this->load->database('PR006Q', TRUE);
        } else if ($work_center == 'PR006I') {
            $db_display = $this->load->database('PR006I', TRUE);
        } else if ($work_center == 'PR007C') {
            $db_display = $this->load->database('PR007C', TRUE);
        } else if ($work_center == 'PR008B') {
            $db_display = $this->load->database('PR008B', TRUE);
        } else if ($work_center == 'PR009B') {
            $db_display = $this->load->database('PR009B', TRUE);
        } else if ($work_center == 'MADS01') {
            $db_display = $this->load->database('MADS01', TRUE);
        } else if ($work_center == 'MADS02') {
            $db_display = $this->load->database('MADS02', TRUE);
        } else if ($work_center == 'MADS03') {
            $db_display = $this->load->database('MADS03', TRUE);
        } else if ($work_center == 'MADS04') {
            $db_display = $this->load->database('MADS04', TRUE);
        } else {
            $db_display = $this->load->database('display', TRUE);
        } 

        return $db_display;
    }

}
