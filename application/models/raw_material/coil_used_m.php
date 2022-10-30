<?php

class coil_used_m extends CI_Model {

    private $tabel = 'PRD.TT_COIL_USED';

    public function __construct() {
        parent::__construct();
    }

    function get_coil_used() {
        $hasil = $this->db->query("SELECT INT_ID, CHR_WO_NUMBER
        ,CHR_PART_NO_RM
        ,CHR_PART_NO
        ,CHR_PART_NO_MATE
        ,CHR_WORK_CENTER
        ,CHR_PDS_NO
        ,CHR_SERIAL_NO
        ,CHR_BATCH
        ,INT_WEIGHT_TOTAL
        ,CHR_DATE_KANBAN
        ,CAST(INT_WEIGHT/1000 AS INT) AS INT_WEIGHT
        ,INT_WEIGHT_ACTUAL/1000 AS INT_WEIGHT_ACTUAL
        ,CHR_SLOC
        ,INT_STATUS
        ,INT_RECOVERY
        ,CHR_CREATED_BY
        ,CHR_CREATED_DATE
        ,CHR_CREATED_TIME
        ,CHR_MODIFIED_BY
        ,CHR_MODIFIED_DATE
        ,CHR_MODIFIED_TIME
        ,INT_FLG_DEL
        ,INT_FLG_READ FROM $this->tabel ");

        return $hasil->result();
    }

    function get_data_coil_used_by_id($id) {
        $sql = "SELECT INT_ID, CHR_WO_NUMBER
        ,CHR_PART_NO_RM
        ,CHR_PART_NO
        ,CHR_PART_NO_MATE
        ,CHR_WORK_CENTER
        ,CHR_PDS_NO
        ,CHR_SERIAL_NO
        ,CHR_BATCH
        ,CAST(INT_WEIGHT_TOTAL/1000 AS INT) AS INT_WEIGHT_TOTAL
        ,CHR_DATE_KANBAN
        ,CAST(INT_WEIGHT/1000 AS INT) AS INT_WEIGHT
        ,INT_WEIGHT_ACTUAL/1000 AS INT_WEIGHT_ACTUAL
        ,CHR_SLOC
        ,INT_STATUS
        ,INT_RECOVERY
        ,CHR_CREATED_BY
        ,CHR_CREATED_DATE
        ,CHR_CREATED_TIME
        ,CHR_MODIFIED_BY
        ,CHR_MODIFIED_DATE
        ,CHR_MODIFIED_TIME
        ,INT_FLG_DEL
        ,INT_FLG_READ
                FROM $this->tabel
                WHERE INT_ID = '$id'";

        return $this->db->query($sql)->row();
    }

    function get_history_coil_used($date_from, $date_to) {
        // $hasil = $this->db->query("SELECT INT_ID, CHR_WO_NUMBER
        // ,CHR_PART_NO_RM
        // ,CHR_PART_NO
        // ,CHR_PART_NO_MATE
        // ,CHR_WORK_CENTER
        // ,CHR_PDS_NO
        // ,CASE 
        // WHEN CHR_PDS_NO = 'nopds' 
        // THEN CHR_SERIAL_NO +' '+ CHR_PART_NO_RM +' '+ CONVERT(VARCHAR(100),CAST(INT_WEIGHT_TOTAL/1000 AS INT)) +' '+ CHR_DATE_KANBAN +' '+ CHR_BATCH +' '+ '' ELSE 
        // CHR_SERIAL_NO +' '+ CHR_PART_NO_RM +' '+ CONVERT(VARCHAR(100),CAST(INT_WEIGHT_TOTAL/1000 AS INT)) +' '+ CHR_DATE_KANBAN +' '+ CHR_BATCH +' '+ CHR_PDS_NO 
        // END AS BARCODE
        // ,CHR_SERIAL_NO
        // ,CHR_BATCH
        // ,CAST(INT_WEIGHT_TOTAL/1000 AS INT) AS INT_WEIGHT_TOTAL
        // ,CHR_DATE_KANBAN
        // ,CAST(INT_WEIGHT/1000 AS INT) AS INT_WEIGHT
        // ,INT_WEIGHT_ACTUAL/1000 AS INT_WEIGHT_ACTUAL
        // ,CHR_SLOC
        // ,INT_STATUS
        // ,INT_RECOVERY
        // ,CHR_CREATED_BY
        // ,CHR_CREATED_DATE
        // ,CHR_CREATED_TIME
        // ,CHR_MODIFIED_BY
        // ,CHR_MODIFIED_DATE
        // ,CHR_MODIFIED_TIME
        // ,INT_FLG_DEL
        // ,INT_FLG_READ FROM $this->tabel where CHR_MODIFIED_BY  = 'Return to WH00' AND CHR_MODIFIED_DATE between '$date_from' and '$date_to' AND ((INT_STATUS = '1' AND INT_WEIGHT < 0)  OR INT_STATUS = '3')");
        // return $hasil->result();

        $stored_procedure = "EXEC PRD.zsp_get_coil_used ?,?";
        $param = array(
            'start_date' => $date_from,
            'end_date' => $date_to);

        $query = $this->db->query($stored_procedure, $param);

        return $query->result();
    }

    function get_new_coil_used($period) {
        $hasil = $this->db->query(";WITH cte AS
    (
        SELECT *,
              ROW_NUMBER() OVER (PARTITION BY [CHR_PART_NO_RM] , [CHR_PDS_NO] , [CHR_SERIAL_NO] , [CHR_BATCH]    ORDER BY CHR_CREATED_DATE) AS rn
        FROM PRD.TT_COIL_USED where INT_FLG_READ = '0' AND INT_STATUS = '3' AND CHR_MODIFIED_BY  = 'Return to WH00' AND LEFT(CHR_MODIFIED_DATE,6) = '$period'
    )
    SELECT INT_ID, CHR_WO_NUMBER
    ,CHR_PART_NO_RM
    ,CHR_PART_NO
    ,CHR_PART_NO_MATE
    ,CHR_WORK_CENTER
    ,CHR_PDS_NO
    ,CHR_SERIAL_NO
    ,CHR_BATCH
    ,CAST(INT_WEIGHT_TOTAL/1000 AS INT) AS INT_WEIGHT_TOTAL
    ,CHR_DATE_KANBAN
    ,CAST(INT_WEIGHT/1000 AS INT) AS INT_WEIGHT
    ,INT_WEIGHT_ACTUAL/1000 AS INT_WEIGHT_ACTUAL
    ,CHR_SLOC
    ,INT_STATUS
    ,INT_RECOVERY
    ,CHR_CREATED_BY
    ,CHR_CREATED_DATE
    ,CHR_CREATED_TIME
    ,CHR_MODIFIED_BY
    ,CHR_MODIFIED_DATE
    ,CHR_MODIFIED_TIME
    ,INT_FLG_DEL
    ,INT_FLG_READ
    FROM cte
    WHERE rn = 1 
    ORDER BY CHR_CREATED_DATE DESC, CHR_CREATED_TIME DESC");

        return $hasil->result();
    }

    function save($data) {
        $this->db->insert($this->tabel, $data);
        return $this->db->insert_id();
    }

    function update($data, $id) {
        $this->db->where($id);
        $this->db->update($this->tabel, $data);
    }

    function update_actual($data, $id) {
        $weight = $data['INT_WEIGHT_ACTUAL'];

        return $this->db->query("UPDATE $this->tabel SET INT_WEIGHT_ACTUAL = $weight WHERE INT_ID = $id");
    }

    //INES
    function get_detail_kanban_komp($part_komponen, $work_center, $pds, $batch, $serial) {
        $sql = "SELECT TOP 1 INT_ID, CHR_WO_NUMBER, CHR_PART_NO_RM, CHR_PART_NO, CHR_WORK_CENTER, CHR_PDS_NO, CHR_SERIAL_NO, CHR_BATCH, CHR_SLOC,
                      INT_WEIGHT_TOTAL, INT_WEIGHT, INT_STATUS, INT_RECOVERY
                FROM $this->tabel
                WHERE CHR_PART_NO_RM = '$part_komponen' AND CHR_WORK_CENTER = '$work_center' AND CHR_PDS_NO = '$pds' AND CHR_SERIAL_NO = '$serial' 
                AND CHR_BATCH = '$batch'
                ORDER BY INT_ID DESC";

        return $this->db->query($sql);
    }

    function get_detail_last_used_komp($work_center) {
        $sql = "SELECT TOP 1 INT_ID, CHR_PART_NO_RM, CHR_PART_NO, INT_WEIGHT_TOTAL, INT_WEIGHT, CHR_PDS_NO, CHR_SERIAL_NO, CHR_BATCH, INT_STATUS
                FROM $this->tabel 
                WHERE CHR_WORK_CENTER = '$work_center' ORDER BY INT_ID DESC";

        return $this->db->query($sql);
    }

    function get_last_kanban_coil($wo) {
        $sql = "SELECT TOP 1 * FROM PRD.TT_HISTORY_SCAN_KANBAN_KOMPONEN WHERE CHR_WO_NUMBER = '$wo' ORDER BY INT_ID DESC";

        return $this->db->query($sql);
    }

}
