<?php

class ng_m extends CI_Model {

    private $table_name = 'TT_NG_OTHER';

    public function __construct() {
        parent::__construct();
    }

    function get_data_ng_by_date_and_workcenter($date, $work_center){

        if($work_center == 'ALL'){
            $add_param = '';
        }else{
            $add_param = "AND PR.CHR_WORK_CENTER = '$work_center'";
        }

        $query = $this->db->query("SELECT PR.CHR_WORK_CENTER, NG.CHR_NG_CATEGORY, INT_QTY_NG, CHR_NOTES, OT.CHR_CREATED_BY, OT.CHR_CREATED_DATE, OT.CHR_CREATED_TIME
        FROM TT_NG_OTHER OT INNER JOIN TM_NG NG ON OT.CHR_NG_CATEGORY_CODE = NG.CHR_NG_CATEGORY_CODE
        INNER JOIN TT_PRODUCTION_RESULT PR ON PR.INT_NUMBER = OT.INT_ID_PRODUCTION_RESULT
        WHERE CHR_NOTES IS NOT NULL AND OT.CHR_CREATED_DATE = '$date' $add_param")->result();

        return $query;
    }

    function get_data_ng_by_period_and_workcenter($period, $work_center){

        if($work_center == 'ALL'){
            $add_param = '';
        }else{
            $add_param = "AND PR.CHR_WORK_CENTER = '$work_center'";
        }

        $query = $this->db->query("SELECT PR.CHR_WORK_CENTER, NG.CHR_NG_CATEGORY, INT_QTY_NG, CHR_NOTES, OT.CHR_CREATED_BY, OT.CHR_CREATED_DATE, OT.CHR_CREATED_TIME
        FROM TT_NG_OTHER OT INNER JOIN TM_NG NG ON OT.CHR_NG_CATEGORY_CODE = NG.CHR_NG_CATEGORY_CODE
        INNER JOIN TT_PRODUCTION_RESULT PR ON PR.INT_NUMBER = OT.INT_ID_PRODUCTION_RESULT
        WHERE CHR_NOTES IS NOT NULL AND LEFT(OT.CHR_CREATED_DATE,6) = '$period' $add_param")->result();

        return $query;
    }


    function get_data_ng_by_work_center_and_date($work_center, $date){

        $query = $this->db->query("SELECT INT_QTY_NG, D.CHR_NG_CATEGORY, ISNULL(CHR_NOTES,'-') CHR_NOTES, PR.CHR_BACK_NO,
        CASE M.CHR_CREATED_BY WHEN 'system' THEN 'System' ELSE 'Manual*' END AS CHR_CREATED_BY
        FROM TT_NG_OTHER M 
        INNER JOIN TM_NG D ON M.CHR_NG_CATEGORY_CODE = D.CHR_NG_CATEGORY_CODE
        INNER JOIN TT_PRODUCTION_RESULT PR ON PR.INT_NUMBER = M.INT_ID_PRODUCTION_RESULT
        WHERE M.CHR_CREATED_BY = 'system' AND PR.CHR_WORK_CENTER = '$work_center' AND PR.CHR_DATE ='$date'")->result();

        return $query;
    }

}