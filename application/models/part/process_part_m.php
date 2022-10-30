<?php

class process_part_m extends CI_Model
{

    private $tabel = 'TM_PROCESS_PARTS';

    public function __construct()
    {
        parent::__construct();
    }

    function save($data)
    {
        $this->db->insert($this->tabel, $data);
    }

    function saveCycleTime($data){
        $this->db->insert('PRD.TT_PART_CYCLETIME', $data);
    }

    function update($data, $id)
    {
        $this->db->where($id);
        $this->db->update($this->tabel, $data);
    }

    function delete($id)
    {
        $data = array('INT_FLG_DEL' => 1);

        $this->db->where('INT_ID', $id);
        $this->db->update($this->tabel, $data);
    }

    function get_data_process_part()
    {
        $sql = "SELECT INT_ID,INT_SEQUENCE, CHR_WORK_CENTER, CHR_PART_NO, INT_LOT_SIZE, CHR_DATE FROM $this->tabel WHERE INT_FLG_DEL = 0";
        return $this->db->query($sql)->result();
    }

    function get_detail_process_part_by_id($id)
    {
        $sql = "SELECT INT_ID, INT_SEQUENCE, CHR_WORK_CENTER, CHR_PART_NO, INT_LOT_SIZE, INT_QTY_PER_BOX, CHR_DATE FROM $this->tabel 
            WHERE INT_FLG_DEL = 0 AND INT_ID = '$id'";
        return $this->db->query($sql)->row();
    }

    function get_data_process_part_by_work_center($work_center)
    {

        $sql = "SELECT PP.CHR_WORK_CENTER, ISNULL(PP.INT_CYCLE_TIME,0) INT_CYCLE_TIME, PP.CHR_PART_NO FROM $this->tabel PP INNER JOIN TM_PARTS P
        ON P.CHR_PART_NO = PP.CHR_PART_NO
        WHERE PP.CHR_WORK_CENTER = '$work_center'
        GROUP BY  PP.CHR_WORK_CENTER, ISNULL(PP.INT_CYCLE_TIME,0), PP.CHR_PART_NO 
        ORDER BY PP.CHR_PART_NO ASC";

        return $this->db->query($sql)->result();
    }

    function downloadDataProcessPart($work_center)
    {
        if ($work_center == 'ALL') {
            $query = ";WITH CTE (CHR_PART_NO, CHR_BACK_NO) AS (
                SELECT CHR_PART_NO, CHR_BACK_NO FROM TM_KANBAN GROUP BY CHR_PART_NO, CHR_BACK_NO
            )

            SELECT PP.CHR_WORK_CENTER, PP.CHR_PART_NO AS PART_NO,
            REPLACE(ISNULL(PP.INT_CYCLE_TIME,PP.INT_CYCLE_TIME),'.',',') INT_CYCLE_TIME, 
			REPLACE(ISNULL(PC.INT_MP,PP.INT_MP),'.',',') INT_MP, 
			''''+PP.CHR_PART_NO CHR_PART_NO, 
            K.CHR_BACK_NO
            FROM TM_PROCESS_PARTS PP 
            INNER JOIN CTE K ON K.CHR_PART_NO = PP.CHR_PART_NO
			LEFT JOIN PRD.TT_PART_CYCLETIME PC ON PC.CHR_PART_NO = PP.CHR_PART_NO AND PC.CHR_WORK_CENTER = PP.CHR_WORK_CENTER 
            GROUP BY PP.CHR_WORK_CENTER, PP.INT_CYCLE_TIME, PP.CHR_PART_NO, K.CHR_BACK_NO, PP.INT_MP, PC.INT_CYCLE_TIME, PC.INT_MP
            ORDER BY PP.CHR_PART_NO ASC";
        } else {
            $query = ";WITH CTE (CHR_PART_NO, CHR_BACK_NO) AS (
                SELECT CHR_PART_NO, CHR_BACK_NO FROM TM_KANBAN GROUP BY CHR_PART_NO, CHR_BACK_NO
            )

            SELECT PP.CHR_WORK_CENTER, PP.CHR_PART_NO AS PART_NO,
            REPLACE(ISNULL(PP.INT_CYCLE_TIME,PP.INT_CYCLE_TIME),'.',',') INT_CYCLE_TIME, 
			REPLACE(ISNULL(PC.INT_MP,PP.INT_MP),'.',',') INT_MP, 
			''''+PP.CHR_PART_NO CHR_PART_NO, 
            K.CHR_BACK_NO
            FROM TM_PROCESS_PARTS PP  
            INNER JOIN CTE K ON K.CHR_PART_NO = PP.CHR_PART_NO
			LEFT JOIN PRD.TT_PART_CYCLETIME PC ON PC.CHR_PART_NO = PP.CHR_PART_NO AND PC.CHR_WORK_CENTER = PP.CHR_WORK_CENTER 
            WHERE PP.CHR_WORK_CENTER = '$work_center'
            GROUP BY PP.CHR_WORK_CENTER, PP.INT_CYCLE_TIME, PP.CHR_PART_NO, K.CHR_BACK_NO, PP.INT_MP, PC.INT_CYCLE_TIME, PC.INT_MP
            ORDER BY PP.CHR_PART_NO ASC";
        }

        return $this->db->query($query)->result();
    }

    function get_data_to_download_process_part_by_work_center($work_center)
    {

        $sql = ";WITH CTE (CHR_PART_NO, CHR_BACK_NO) AS (
            SELECT CHR_PART_NO, CHR_BACK_NO FROM TM_KANBAN GROUP BY CHR_PART_NO, CHR_BACK_NO
        )
        SELECT PP.CHR_WORK_CENTER, PP.CHR_PART_NO AS PART_NO,
        REPLACE(ISNULL(PP.INT_CYCLE_TIME,0),'.',',') INT_CYCLE_TIME, ''''+PP.CHR_PART_NO CHR_PART_NO, 
        K.CHR_BACK_NO, INT_MP
        FROM TM_PROCESS_PARTS PP 
        INNER JOIN CTE K ON K.CHR_PART_NO = PP.CHR_PART_NO
        WHERE PP.CHR_WORK_CENTER = '$work_center' 
        GROUP BY PP.CHR_WORK_CENTER, 
        ISNULL(PP.INT_CYCLE_TIME,0), PP.CHR_PART_NO, K.CHR_BACK_NO, INT_MP
        ORDER BY PP.CHR_PART_NO ASC";

        return $this->db->query($sql)->result();
    }

    function get_remaining_count_by_seq($old_seq, $new_seq, $date, $work_center)
    {
        $stored_procedure = "EXEC PRD.zsp_get_sequence_process_part ?, ?, ?, ?";
        $param = array(
            'seq_old' => $old_seq,
            'seq_new' => $new_seq,
            'date' => $date,
            'work_center' => $work_center
        );

        $query = $this->db->query($stored_procedure, $param);

        return $query->num_rows();
    }

    function get_data_remaining_by_seq($old_seq, $new_seq, $date, $work_center)
    {
        $stored_procedure = "EXEC PRD.zsp_get_sequence_process_part ?, ?, ?, ?";
        $param = array(
            'seq_old' => $old_seq,
            'seq_new' => $new_seq,
            'date' => $date,
            'work_center' => $work_center
        );

        $query = $this->db->query($stored_procedure, $param);

        return $query->result();
    }

    function get_data_by_sequence($date, $work_center, $id)
    {
        $sql = "SELECT TOP 1 * FROM $this->tabel 
            WHERE INT_FLG_DEL = 0 AND CHR_DATE = '$date' AND CHR_WORK_CENTER = '$work_center' AND INT_ID = $id";

        return $this->db->query($sql)->row();
    }

    function get_data_detail_part($part_no)
    {
        $query =  $this->db->query("SELECT TOP 1 * FROM TM_KANBAN WHERE CHR_PART_NO = '$part_no' AND CHR_KANBAN_TYPE = '5'")->row();

        return $query;
    }

    function get_data_part_by_work_center_and_part($work_center, $part_no)
    {
        return $this->db->query("SELECT TOP 1 CHR_WORK_CENTER, CHR_PART_NO, CHR_PV, CHR_SLOC_TO,
             CONVERT(INT,CEILING(INT_CYCLE_TIME)) AS INT_CYCLE_TIME FROM $this->tabel 
            WHERE CHR_WORK_CENTER='$work_center' AND
            CHR_PART_NO='$part_no' AND (CHR_FLAG_DELETE IS NULL OR CHR_FLAG_DELETE = '')");
    }

    function get_detail_process_part($work_center, $part_no)
    {
        $sql = "SELECT CHR_WORK_CENTER, CHR_PART_NO, CHR_PV, CHR_SLOC_TO, CHR_DATE, CHR_PERSON_RESPONSIBLE,
                CHR_AREA, CHR_TYPE, CONVERT(INT,CEILING(INT_CYCLE_TIME)) AS INT_CYCLE_TIME FROM $this->tabel 
                WHERE CHR_WORK_CENTER='$work_center' AND
                CHR_PART_NO='$part_no' AND (CHR_FLAG_DELETE IS NULL OR CHR_FLAG_DELETE = '')";
        return $this->db->query($sql);
    }

    function get_part_by_wo($date, $id_dept, $shift, $work_center)
    {

        $query = $this->db->query("SELECT PR.INT_NUMBER , PR.CHR_PART_NO ,PR.CHR_DATE , PR.CHR_SHIFT, PR.CHR_WORK_CENTER , PR.CHR_BACK_NO , PR.CHR_PART_NAME ,
        PR.CHR_DATE_ENTRY ,PR.CHR_TIME_ENTRY , PR.INT_TOTAL_QTY , PR.INT_NG_BRKNTEST , PR.INT_NG_PRC , PR.INT_NG_SETUP, 
        PR.INT_TOTAL_NG,PR.INT_NG_TRIAL, ISNULL(PP.CHR_TYPE, 0) AS CHR_TYPE 
        FROM TT_PRODUCTION_RESULT PR 
        INNER JOIN TM_PROCESS_PARTS PP ON PR.CHR_PART_NO = PP.CHR_PART_NO AND PP.CHR_WORK_CENTER = PR.CHR_WORK_CENTER
        INNER JOIN TM_DIRECT_BACKFLUSH_GENERAL D ON D.CHR_WCENTER = PR.CHR_WORK_CENTER 
        --AND PP.CHR_PERSON_RESPONSIBLE = D.CHR_PERSON_RESPONSIBLE
        WHERE 
        ((PP.CHR_FLAG_DELETE IS NULL) OR (PP.CHR_FLAG_DELETE <> '1')) 
        AND PR.CHR_DATE = '$date' AND PR.CHR_WORK_CENTER = '$work_center' AND PR.CHR_SHIFT = '$shift' AND D.INT_DEPT = '$id_dept'
        ORDER BY PR.CHR_BACK_NO ASC");

        return $query->result();
    }

    function get_part_by_wo_exclude($date, $id_dept, $shift, $work_center)
    {

        $query = $this->db->query("SELECT PP.CHR_PART_NO, K.CHR_BACK_NO  FROM TM_PROCESS_PARTS PP 
		INNER JOIN TM_KANBAN K ON K.CHR_PART_NO = PP.CHR_PART_NO
		INNER JOIN TM_DIRECT_BACKFLUSH_GENERAL D ON D.CHR_WCENTER = PP.CHR_WORK_CENTER 
		WHERE 
		PP.CHR_WORK_CENTER = '$work_center' 
		AND D.INT_DEPT = '$id_dept'
		AND K.CHR_BACK_NO NOT IN 
        (SELECT CHR_BACK_NO FROM TT_PRODUCTION_RESULT WHERE CHR_DATE = '$date' 
        AND CHR_WORK_CENTER = '$work_center' AND CHR_SHIFT = '$shift')
        GROUP BY PP.CHR_PART_NO, K.CHR_BACK_NO 
        ORDER BY K.CHR_BACK_NO");

        return $query->result();
    }

    function get_data_part_by_back_no($back_no, $work_center)
    {
        $query = $this->db->query("SELECT TOP 1 K.CHR_BACK_NO, P.CHR_PART_NAME, PP.CHR_PART_NO, PP.CHR_PV FROM TM_KANBAN K 
		INNER JOIN TM_PROCESS_PARTS PP ON K.CHR_PART_NO = PP.CHR_PART_NO
		LEFT JOIN TM_PARTS P ON P.CHR_PART_NO = PP.CHR_PART_NO
		WHERE K.CHR_BACK_NO =  '$back_no' AND PP.CHR_WORK_CENTER = '$work_center'
        AND PP.CHR_FLAG_DELETE IS NULL
		GROUP BY K.CHR_BACK_NO, P.CHR_PART_NAME, PP.CHR_PART_NO, PP.CHR_PV ");

        return $query->row();
    }

    function get_work_center_manual()
    {
        $query = $this->db->query("SELECT RTRIM(CHR_WCENTER) CHR_WORK_CENTER, INT_LIVE 
            FROM TM_DIRECT_BACKFLUSH_GENERAL 
            WHERE  CHR_WCENTER NOT IN (SELECT CHR_WORK_CENTER FROM TM_INLINE_SCAN GROUP BY CHR_WORK_CENTER) AND 
            INT_LIVE = 1
            GROUP BY CHR_WCENTER, INT_LIVE
            ORDER BY CHR_WCENTER ASC");

        return $query->result();
    }

    function get_top_work_center_manual()
    {
        $query = $this->db->query("SELECT TOP 1 RTRIM(CHR_WCENTER) CHR_WORK_CENTER, INT_LIVE 
            FROM TM_DIRECT_BACKFLUSH_GENERAL 
            WHERE CHR_WCENTER NOT IN (SELECT CHR_WORK_CENTER FROM TM_INLINE_SCAN GROUP BY CHR_WORK_CENTER) AND 
            INT_LIVE = 1
            GROUP BY CHR_WCENTER, INT_LIVE
            ORDER BY CHR_WCENTER ASC");

        return $query->row();
    }

    function get_part_by_wo_manual($date, $shift, $work_center)
    {
        $query = $this->db->query("SELECT TM_PROCESS_PARTS.CHR_PLANT, TM_PROCESS_PARTS.CHR_WORK_CENTER, TM_PROCESS_PARTS.CHR_TYPE , TM_PROCESS_PARTS.CHR_PART_NO, 
        TM_PROCESS_PARTS.CHR_PV, TM_PROCESS_PARTS.CHR_SLOC_TO, TM_PARTS.CHR_PART_NAME, TM_PARTS.CHR_PART_UOM, 
        ISNULL(TM_KANBAN.CHR_BACK_NO, 'Empty') AS CHR_BACK_NO, 
        CASE WHEN TM_OLD_BACKNO.CHR_OLD_BACKNO = '-' THEN '-' WHEN TM_OLD_BACKNO.CHR_OLD_BACKNO IS NULL 
        THEN '-' ELSE TM_OLD_BACKNO.CHR_OLD_BACKNO END AS CHR_BACK_NO_OLD, CASE WHEN TM_KANBAN.CHR_BACK_NO = '-' 
        THEN 'z' WHEN TM_KANBAN.CHR_BACK_NO IS NULL THEN 'z' ELSE TM_KANBAN.CHR_BACK_NO END AS CHR_BACK_NO2, 
        ISNULL(TT_PRODUCTION_RESULT.CHR_SHIFT, 0) AS SHIFT, ISNULL(TT_PRODUCTION_RESULT.CHR_DATE, 0) AS DATE_ENTRY, 
        ISNULL(TT_PRODUCTION_RESULT.INT_ACTUAL, 0) AS INT_ACTUAL, ISNULL(TT_PRODUCTION_RESULT.INT_TOTAL_QTY, 0) AS TOTAL_QTY , 
        ISNULL(TT_PRODUCTION_RESULT.INT_NG_PRC, 0) AS INT_NG_PRC, ISNULL(TT_PRODUCTION_RESULT.INT_NG_BRKNTEST, 0) AS INT_NG_BRKNTEST, 
        ISNULL(TT_PRODUCTION_RESULT.INT_NG_SETUP, 0) AS INT_NG_SETUP, ISNULL(TT_PRODUCTION_RESULT.INT_NG_TRIAL, 0) AS INT_NG_TRIAL, 
        TM_PROCESS_PARTS.CHR_FLAG_DELETE 
        
        FROM TM_PROCESS_PARTS INNER JOIN TM_PARTS ON TM_PROCESS_PARTS.CHR_PART_NO = TM_PARTS.CHR_PART_NO 
        INNER JOIN TM_DIRECT_BACKFLUSH_GENERAL D ON D.CHR_WCENTER = TM_PROCESS_PARTS.CHR_WORK_CENTER
        LEFT OUTER JOIN TM_KANBAN ON TM_PROCESS_PARTS.CHR_PART_NO = TM_KANBAN.CHR_PART_NO AND (TM_KANBAN.CHR_KANBAN_TYPE = '1' OR TM_KANBAN.CHR_KANBAN_TYPE = '5') 
        LEFT OUTER JOIN TT_PRODUCTION_RESULT ON TM_PROCESS_PARTS.CHR_PART_NO = TT_PRODUCTION_RESULT.CHR_PART_NO AND TM_PROCESS_PARTS.CHR_WORK_CENTER = TT_PRODUCTION_RESULT.CHR_WORK_CENTER 
        AND TT_PRODUCTION_RESULT.CHR_DATE = '$date' AND TT_PRODUCTION_RESULT.CHR_SHIFT = '$shift' 
        left outer join TM_OLD_BACKNO on TM_PROCESS_PARTS.CHR_PART_NO = TM_OLD_BACKNO.CHR_PARTNO 
        WHERE 
        (TM_PROCESS_PARTS.CHR_WORK_CENTER = '$work_center') 
        and ((TM_PROCESS_PARTS.CHR_FLAG_DELETE IS NULL) 
        OR (TM_PROCESS_PARTS.CHR_FLAG_DELETE <> '1')) 
        order by CHR_BACK_NO2 ASC");

        return $query->result();
    }

    function check_part_no($part_number)
    {
        $query = $this->db->query("SELECT * FROM TM_PHANTOM WHERE CHR_PART_NO = '$part_number'");

        if ($query->num_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    function get_data_part_customer_by_work_center($part_no, $work_center)
    {
        $query = $this->db->query("SELECT TOP 1 SP.CHR_PART_NO, SP.CHR_CUS_PART_NO FROM TM_PROCESS_PARTS PP 
            INNER JOIN TM_SHIPPING_PARTS SP ON PP.CHR_PART_NO = SP.CHR_PART_NO
            WHERE SP.CHR_PART_NO = '$part_no' AND PP.CHR_WORK_CENTER = '$work_center'
            AND PP.INT_FLG_METHODS = 1
            GROUP BY SP.CHR_PART_NO, SP.CHR_CUS_PART_NO");

        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function get_data_part_by_work_center($work_center)
    {
        return $this->db->query("SELECT PP.CHR_WORK_CENTER, SP.CHR_PART_NO, KB.CHR_BACK_NO, SP.CHR_CUS_PART_NO, PP.INT_FLG_METHODS, PP.CHR_WORK_CENTER, P.CHR_PART_NAME 
            FROM TM_PROCESS_PARTS PP 
            INNER JOIN TM_SHIPPING_PARTS SP ON PP.CHR_PART_NO = SP.CHR_PART_NO
            LEFT JOIN TM_PARTS P ON PP.CHR_PART_NO = P.CHR_PART_NO
            LEFT JOIN TM_KANBAN KB ON PP.CHR_PART_NO = KB.CHR_PART_NO
            WHERE PP.CHR_WORK_CENTER = '$work_center'
            GROUP BY PP.CHR_WORK_CENTER, SP.CHR_PART_NO, KB.CHR_BACK_NO, SP.CHR_CUS_PART_NO, PP.INT_FLG_METHODS, P.CHR_PART_NAME ")->result();
    }

    function update_methods($data, $id)
    {
        $this->db->where($id);
        $this->db->update($this->tabel, $data);
    }

    function get_data_process_part_by_partno($part_no, $work_center)
    {
        $data_method = $this->db->query("SELECT TOP 1 * FROM TM_PROCESS_PARTS WHERE CHR_PART_NO = '$part_no' AND CHR_WORK_CENTER = '$work_center'")->row();

        return $data_method->INT_FLG_METHODS;
    }

    // process part target --> models
    function get_data_process_part_target_by_group_and_period($group, $period)
    {

        $sql = "SELECT PP.CHR_WORK_CENTER, PP.CHR_PART_NO, PP.CHR_PV, P.INT_TARGET_PRODUCTION FROM $this->tabel PP
            INNER JOIN TM_DIRECT_BACKFLUSH_GENERAL DBG ON DBG.CHR_WCENTER = PP.CHR_WORK_CENTER AND DBG.INT_LIVE = 1
            INNER JOIN TT_PROCESS_PART_TARGET P ON P.CHR_WORK_CENTER = PP.CHR_WORK_CENTER AND P.CHR_PART_NO = PP.CHR_PART_NO AND P.CHR_PV = PP.CHR_PV
            WHERE DBG.INT_PRODUCT_CODE = $group AND P.CHR_PERIOD = '$period'
            ORDER BY PP.CHR_WORK_CENTER, PP.CHR_PART_NO ASC";

        return $this->db->query($sql)->result();
    }

    function get_data_to_download_process_part_by_group_and_period($group)
    {

        $sql = "SELECT PP.CHR_WORK_CENTER, ''''+PP.CHR_PART_NO CHR_PART_NO, ''''+PP.CHR_PV CHR_PV
            FROM TM_PROCESS_PARTS PP 
            INNER JOIN TM_DIRECT_BACKFLUSH_GENERAL DBG ON DBG.CHR_WCENTER = PP.CHR_WORK_CENTER AND DBG.INT_LIVE = 1
            WHERE DBG.INT_PRODUCT_CODE = $group
            GROUP BY PP.CHR_WORK_CENTER, PP.CHR_PART_NO , PP.CHR_PV
            ORDER BY PP.CHR_WORK_CENTER, PP.CHR_PART_NO ASC";

        return $this->db->query($sql)->result();
    }

    function merge_part_target($data)
    {

        $stored_procedure = "EXEC PPC.zsp_merge_target_part ?, ?, ?, ?, ?, ?";
        $param = array(
            'period' => $data['CHR_PERIOD'],
            'part_no' => $data['CHR_PART_NO'],
            'pv' => $data['CHR_PV'],
            'work_center' => $data['CHR_WORK_CENTER'],
            'target' => (int)$data['INT_TARGET_PRODUCTION'],
            'created_by' => $data['CHR_CREATED_BY']
        );

        $query = $this->db->query($stored_procedure, $param);

        return $query->result();
    }

    function update_target_part($data, $id)
    {
        $this->db->where($id);
        $this->db->update('TT_PROCESS_PART_TARGET', $data);
    }

    function get_data_part_by_workcenter($work_center)
    {
        $sql = "SELECT LEFT(CHR_PART_NO,11) AS CHR_PART_NO FROM $this->tabel WHERE  CHR_WORK_CENTER = '$work_center' GROUP BY LEFT(CHR_PART_NO,11)";
        return $this->db->query($sql)->result();
    }

    function get_data_line_phantom_elina($work_center)
    {
        $sql = "SELECT TOP 1 CHR_WORK_CENTER FROM PRD.TM_WORK_CENTER_PHANTOM_ELINA WHERE  CHR_WORK_CENTER = '$work_center'";
        return $this->db->query($sql)->result();
    }

    //20211216
    function get_master_mp_by_part($work_center, $part_no)
    {
        $sql = "SELECT INT_MP FROM PRD.TT_PART_CYCLETIME WHERE CHR_PART_NO = '$part_no' AND CHR_WORK_CENTER ='$work_center' AND INT_FLG_DEL = 0";
        return $this->db->query($sql)->result();
    }

    //20211216
    function get_master_ct_by_mppart($work_center, $part_no, $man_power)
    {
        $query = $this->db->query("SELECT TOP 1 INT_CYCLE_TIME FROM PRD.TT_PART_CYCLETIME 
        WHERE CHR_PART_NO = '$part_no' AND CHR_WORK_CENTER ='$work_center' 
        AND INT_MP = '$man_power' AND INT_FLG_DEL = 0");
        
        if ($query->num_rows() > 0) {
            return $query->row()->INT_CYCLE_TIME;
        } else {
            return 0;
        }
        
    }

    function getPartByWoExclude($date, $shift, $work_center)
    {
        $query = $this->db->query("SELECT PP.CHR_PART_NO, K.CHR_BACK_NO  FROM TM_PROCESS_PARTS PP 
		INNER JOIN TM_KANBAN K ON K.CHR_PART_NO = PP.CHR_PART_NO
		INNER JOIN TM_DIRECT_BACKFLUSH_GENERAL D ON D.CHR_WCENTER = PP.CHR_WORK_CENTER 
		WHERE  PP.CHR_WORK_CENTER = '$work_center' AND K.CHR_BACK_NO NOT IN 
        (SELECT CHR_BACK_NO FROM TT_PRODUCTION_RESULT WHERE CHR_DATE = '$date' 
        AND CHR_WORK_CENTER = '$work_center' AND CHR_SHIFT = '$shift')
        GROUP BY PP.CHR_PART_NO, K.CHR_BACK_NO 
        ORDER BY K.CHR_BACK_NO");

        return $query->result();
    }

    function getPartByWo($date, $shift, $work_center)
    {

        $query = $this->db->query("SELECT PR.INT_NUMBER , PR.CHR_PART_NO ,PR.CHR_DATE , PR.CHR_SHIFT, PR.CHR_WORK_CENTER , PR.CHR_BACK_NO , PR.CHR_PART_NAME ,
        PR.CHR_DATE_ENTRY ,PR.CHR_TIME_ENTRY , PR.INT_TOTAL_QTY , PR.INT_NG_BRKNTEST , PR.INT_NG_PRC , PR.INT_NG_SETUP, 
        PR.INT_TOTAL_NG,PR.INT_NG_TRIAL, ISNULL(PP.CHR_TYPE, 0) AS CHR_TYPE 
        FROM TT_PRODUCTION_RESULT PR 
        INNER JOIN TM_PROCESS_PARTS PP ON PR.CHR_PART_NO = PP.CHR_PART_NO AND PP.CHR_WORK_CENTER = PR.CHR_WORK_CENTER
        INNER JOIN TM_DIRECT_BACKFLUSH_GENERAL D ON D.CHR_WCENTER = PR.CHR_WORK_CENTER 
        WHERE 
        ((PP.CHR_FLAG_DELETE IS NULL) OR (PP.CHR_FLAG_DELETE <> '1')) 
        AND PR.INT_QTY_OK <> 0
        AND PR.CHR_DATE = '$date' AND PR.CHR_WORK_CENTER = '$work_center' AND PR.CHR_SHIFT = '$shift' 
        ORDER BY PR.CHR_BACK_NO ASC");

        return $query->result();
    }
}
