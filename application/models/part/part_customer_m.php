<?php

class part_customer_m extends CI_Model {

    private $tabel = 'TM_WI_COORDINATE';
    private $tabel_detail = 'TT_WI_COORDINATE';

    public function __construct() {
        parent::__construct();
    }
    
    public function get_part_no_cust(){
        $query = $this->db->query("SELECT SP.CHR_PART_NO, SP.CHR_CUS_PART_NO FROM TM_SHIPPING_PARTS SP INNER JOIN TM_PROCESS_PARTS PP ON 
        PP.CHR_PART_NO = SP.CHR_PART_NO
        WHERE PP.CHR_WORK_CENTER IN ('PK0002','PK0003')
        AND SP.CHR_CUS_PART_NO <> ' '
        AND
        (
            SP.CHR_PART_NO LIKE '%P0%' OR 
            SP.CHR_PART_NO LIKE '%P1%' OR
            SP.CHR_PART_NO LIKE '%P2%' OR
            SP.CHR_PART_NO LIKE '%V0%' OR 
            SP.CHR_PART_NO LIKE '%V1%' 
        )
        GROUP BY SP.CHR_CUS_PART_NO,SP.CHR_PART_NO");

        return $query->result();
    }

    public function get_part_no_cust_by_workcenter($workcenter){
        $query = $this->db->query("SELECT SP.CHR_PART_NO, SP.CHR_CUS_PART_NO FROM TM_SHIPPING_PARTS SP 
        INNER JOIN TM_PROCESS_PARTS PP ON PP.CHR_PART_NO = SP.CHR_PART_NO
        WHERE PP.CHR_WORK_CENTER = '$workcenter'
        GROUP BY SP.CHR_CUS_PART_NO,SP.CHR_PART_NO
        ORDER BY SP.CHR_PART_NO ");

        return $query->result();
    }

    function get_data_shiping_parts() {
        $query = $this->db->query("SELECT DISTINCT TM_SHIPPING_PARTS.CHR_PART_NO,TM_SHIPPING_PARTS.CHR_CUS_PART_NO, C.CHR_CUST_NAME,
                TM_PARTS.CHR_PART_NAME,
                CASE TM_KANBAN.CHR_KANBAN_TYPE WHEN '5' THEN 'PICKUP'
                WHEN '0' THEN 'ORDER'
                ELSE '-' END AS [TYPE_KANBAN],
                CASE WHEN TM_KANBAN.CHR_BACK_NO IS NULL THEN 'NO KANBAN'
                ELSE TM_KANBAN.CHR_BACK_NO END AS [CHR_BACK_NO]

                FROM TM_SHIPPING_PARTS
                FULL JOIN TM_KANBAN ON TM_KANBAN.CHR_PART_NO = TM_SHIPPING_PARTS.CHR_PART_NO
                FULL JOIN TM_PARTS ON TM_PARTS.CHR_PART_NO = TM_SHIPPING_PARTS.CHR_PART_NO
                LEFT JOIN TM_CUST C ON C.CHR_CUST_NO = TM_SHIPPING_PARTS.CHR_CUS_NO
                WHERE TM_SHIPPING_PARTS.CHR_PART_NO IS NOT NULL
                ORDER BY TM_SHIPPING_PARTS.CHR_CUS_PART_NO DESC ");
        return $query->result();
    }

    function get_top_part_no_cust(){
        $query = $this->db->query("SELECT TOP 1 SP.CHR_PART_NO, SP.CHR_CUS_PART_NO FROM TM_SHIPPING_PARTS SP INNER JOIN TM_PROCESS_PARTS PP ON 
        PP.CHR_PART_NO = SP.CHR_PART_NO
        WHERE 
        PP.CHR_WORK_CENTER IN ('PK0002','PK0003') AND (
            SP.CHR_PART_NO LIKE '%P0%' OR 
            SP.CHR_PART_NO LIKE '%P1%' OR
            SP.CHR_PART_NO LIKE '%P2%' OR
            SP.CHR_PART_NO LIKE '%V0%' OR 
            SP.CHR_PART_NO LIKE '%V1%' 
        )
        GROUP BY SP.CHR_CUS_PART_NO,SP.CHR_PART_NO");

        return $query->row()->CHR_CUS_PART_NO;
    }

    function get_top_part_no_cust_by_workcenter($workcenter){

        $query = $this->db->query("SELECT TOP 1 SP.CHR_PART_NO, SP.CHR_CUS_PART_NO 
        FROM TM_SHIPPING_PARTS SP INNER JOIN TM_PROCESS_PARTS PP ON PP.CHR_PART_NO = SP.CHR_PART_NO
        WHERE PP.CHR_WORK_CENTER = '$workcenter'
        GROUP BY SP.CHR_CUS_PART_NO,SP.CHR_PART_NO 
        ORDER BY SP.CHR_PART_NO ASC");

        return $query->row()->CHR_CUS_PART_NO;
    }

    function get_top_part_no_by_workcenter($workcenter){

        $query = $this->db->query("SELECT TOP 1 SP.CHR_PART_NO, SP.CHR_CUS_PART_NO 
        FROM TM_SHIPPING_PARTS SP INNER JOIN TM_PROCESS_PARTS PP ON PP.CHR_PART_NO = SP.CHR_PART_NO
        WHERE PP.CHR_WORK_CENTER = '$workcenter'
        GROUP BY SP.CHR_CUS_PART_NO,SP.CHR_PART_NO 
        ORDER BY SP.CHR_PART_NO ASC");

        return $query->row()->CHR_PART_NO;
    }

    function get_top_cus_no($cust_partno){
        $query = $this->db->query("SELECT TOP 1 SP.CHR_CUS_NO, CHR_CUST_NAME FROM TM_SHIPPING_PARTS Sp INNER JOIN TM_CUST C ON SP.CHR_CUS_NO = C.CHR_CUST_NO
        WHERE SP.CHR_CUS_PART_NO = '$cust_partno'
        GROUP BY SP.CHR_CUS_NO, CHR_CUST_NAME
        ORDER BY SP.CHR_CUS_NO ASC");

        return $query->row()->CHR_CUS_NO;
    }

    function get_cus_no($cust_partno){
        $query = $this->db->query("SELECT  SP.CHR_CUS_NO, CHR_CUST_NAME FROM TM_SHIPPING_PARTS Sp INNER JOIN TM_CUST C ON SP.CHR_CUS_NO = C.CHR_CUST_NO
        WHERE SP.CHR_CUS_PART_NO = '$cust_partno'
        GROUP BY SP.CHR_CUS_NO, CHR_CUST_NAME
        ORDER BY SP.CHR_CUS_NO ASC");

        return $query->result();
    }

    public function get_data_wi_by_part_no_cust($cust_partno){

        $query = $this->db->query("SELECT * FROM TM_WI_COORDINATE WHERE CHR_CUS_PART_NO = '$cust_partno'");

        return $query->row();
    }

    public function get_cust_by_cust_no($cust_partno){

        $query = $this->db->query("SELECT CHR_CUST_NO,CHR_CUST_NAME FROM TM_SHIPPING_PARTS SP INNER JOIN TM_CUST C ON SP.CHR_CUS_NO = C.CHR_CUST_NO
        WHERE SP.CHR_CUS_PART_NO = '$cust_partno' GROUP BY CHR_CUST_NO,CHR_CUST_NAME");

        return $query->result();
    }

    public function get_data_part_aisin_by_part_cust_no($cust_partno){

        $query = $this->db->query("SELECT SP.CHR_PART_NO, SP.CHR_CUS_PART_NO FROM TM_SHIPPING_PARTS SP INNER JOIN TM_PROCESS_PARTS PP ON 
        PP.CHR_PART_NO = SP.CHR_PART_NO
        WHERE 
        SP.CHR_CUS_PART_NO = '$cust_partno' AND
        SP.CHR_CUS_PART_NO <> ' ' AND
        PP.CHR_WORK_CENTER IN ('PK0002','PK0003') AND (
            SP.CHR_PART_NO LIKE '%P0%' OR 
            SP.CHR_PART_NO LIKE '%P1%' OR
            SP.CHR_PART_NO LIKE '%P2%' OR
            SP.CHR_PART_NO LIKE '%V0%' OR 
            SP.CHR_PART_NO LIKE '%V1%' 
        )
        GROUP BY SP.CHR_CUS_PART_NO, SP.CHR_PART_NO");

        return $query->result();
    }

    public function get_top_part_aisin_by_part_cust_no($cust_partno){
        $query = $this->db->query("SELECT TOP 1 SP.CHR_PART_NO, SP.CHR_CUS_PART_NO FROM TM_SHIPPING_PARTS SP INNER JOIN TM_PROCESS_PARTS PP ON 
        PP.CHR_PART_NO = SP.CHR_PART_NO
        WHERE 
        SP.CHR_CUS_PART_NO = '$cust_partno' AND
        PP.CHR_WORK_CENTER IN ('PK0002','PK0003') AND (
            SP.CHR_PART_NO LIKE '%P0%' OR 
            SP.CHR_PART_NO LIKE '%P1%' OR
            SP.CHR_PART_NO LIKE '%P2%' OR
            SP.CHR_PART_NO LIKE '%V0%' OR 
            SP.CHR_PART_NO LIKE '%V1%' 
        )
        GROUP BY SP.CHR_CUS_PART_NO,SP.CHR_PART_NO");

        return $query->row()->CHR_PART_NO;
    }

    function get_data_part_aisin_by_part_cust_no_by_workcenter($cust_partno, $workcenter){

        $query = $this->db->query("SELECT SP.CHR_PART_NO, SP.CHR_CUS_PART_NO  FROM TM_SHIPPING_PARTS SP 
        INNER JOIN TM_PROCESS_PARTS PP ON  PP.CHR_PART_NO = SP.CHR_PART_NO
        WHERE SP.CHR_CUS_PART_NO = '$cust_partno' AND  PP.CHR_WORK_CENTER = '$workcenter'
        GROUP BY SP.CHR_CUS_PART_NO, SP.CHR_PART_NO");

        return $query->result();
    }

    function get_data_part_aisin_by_part_no_by_workcenter($partno, $workcenter){

        $query = $this->db->query("SELECT SP.CHR_PART_NO, SP.CHR_CUS_PART_NO 
        FROM TM_SHIPPING_PARTS SP INNER JOIN TM_PROCESS_PARTS PP ON 
        PP.CHR_PART_NO = SP.CHR_PART_NO
        WHERE SP.CHR_PART_NO = '$partno' AND  PP.CHR_WORK_CENTER = '$workcenter'
        GROUP BY SP.CHR_CUS_PART_NO, SP.CHR_PART_NO");

        return $query->result();
    }

    public function get_top_part_aisin_by_part_cust_no_and_workcenter($cust_partno, $workcenter){
        $query = $this->db->query("SELECT TOP 1 SP.CHR_PART_NO, SP.CHR_CUS_PART_NO FROM TM_SHIPPING_PARTS SP INNER JOIN TM_PROCESS_PARTS PP ON 
        PP.CHR_PART_NO = SP.CHR_PART_NO
        WHERE 
        SP.CHR_CUS_PART_NO = '$cust_partno' AND
        PP.CHR_WORK_CENTER = '$workcenter'
        GROUP BY SP.CHR_CUS_PART_NO,SP.CHR_PART_NO");

        if($query->num_rows() > 0){
            return $query->row()->CHR_PART_NO;
        }else{
            return array();
        }
    }

    public function get_data_part_customer_wi(){
        $query = $this->db->query("SELECT WI.INT_ID, WI.CHR_CUS_PART_NO , K.CHR_BACK_NO, SP.CHR_PART_NO,P.CHR_PART_NAME, WI.INT_FLG_MODIFIED, INT_FLG_DELETE,
        CASE WI.INT_FLG_DELETE WHEN 0 THEN 'AKTIF' ELSE 'NON-AKTIF' END AS INT_FLG_DELETE_DESC
        FROM TM_WI_COORDINATE WI
        LEFT JOIN TM_SHIPPING_PARTS SP ON WI.CHR_CUS_PART_NO = SP.CHR_CUS_PART_NO
        LEFT JOIN TM_PARTS P ON SP.CHR_PART_NO = P.CHR_PART_NO 
        LEFT JOIN TM_KANBAN K ON P.CHR_PART_NO = K.CHR_PART_NO
        WHERE
        (
            SP.CHR_PART_NO LIKE '%P0%' OR 
            SP.CHR_PART_NO LIKE '%P1%' OR
            SP.CHR_PART_NO LIKE '%P2%' OR
            SP.CHR_PART_NO LIKE '%V0%' OR 
            SP.CHR_PART_NO LIKE '%V1%' 
        )
        GROUP BY  WI.CHR_CUS_PART_NO, K.CHR_BACK_NO, SP.CHR_PART_NO, P.CHR_PART_NAME, WI.INT_FLG_MODIFIED, WI.INT_FLG_DELETE,  WI.INT_ID
        ORDER BY WI.INT_ID DESC");

        return $query->result();
    }

    public function get_data_part_customer(){
        $query = $this->db->query("SELECT WI.INT_ID, RTRIM(SP.CHR_PART_NO) CHR_PART_NO, SP.CHR_CUS_PART_NO, K.CHR_BACK_NO , 
        TW.CHR_WIDTH, TW.CHR_HEIGHT, RTRIM(K.CHR_BACK_NO) + '.JPG' CHR_URL_PICTURE, P.CHR_PART_NAME
        FROM TM_SHIPPING_PARTS SP 
        INNER JOIN TM_WI_COORDINATE WI ON WI.CHR_CUS_PART_NO = SP.CHR_CUS_PART_NO
        INNER JOIN TT_WI_COORDINATE TW ON TW.CHR_CUS_PART_NO = WI.CHR_CUS_PART_NO
        INNER JOIN TM_PARTS P ON SP.CHR_PART_NO = P.CHR_PART_NO 
        INNER JOIN TM_KANBAN K ON P.CHR_PART_NO = K.CHR_PART_NO
        WHERE 
        WI.INT_FLG_DELETE = 0 AND (
            SP.CHR_PART_NO LIKE '%P0%' OR 
            SP.CHR_PART_NO LIKE '%P1%' OR
            SP.CHR_PART_NO LIKE '%P2%' OR
            SP.CHR_PART_NO LIKE '%V0%' OR 
            SP.CHR_PART_NO LIKE '%V1%' 
        )
        GROUP BY WI.INT_ID, SP.CHR_PART_NO, SP.CHR_CUS_PART_NO, K.CHR_BACK_NO, TW.CHR_WIDTH, TW.CHR_HEIGHT, P.CHR_PART_NAME");

        return $query->result();
    }

    function get_detail_part_customer_by_part_cust_no($part_cust_no){
        $query = $this->db->query("SELECT CHR_CUS_PART_NO, CHR_IMG_FILE_NAME, 'http://192.168.0.231/image/wi/' + CHR_IMG_FILE_NAME AS IMG_FILE FROM TM_WI_COORDINATE 
        WHERE CHR_CUS_PART_NO = '$part_cust_no' GROUP BY CHR_IMG_FILE_NAME, CHR_CUS_PART_NO");

        return $query->row();
    }

    function get_coordinate_part_customer_by_part_cust_no($part_cust_no){
        $query = $this->db->query("SELECT * FROM TT_WI_COORDINATE WHERE CHR_CUS_PART_NO = '$part_cust_no'");

        return $query->result();
    }

    public function get_exsting_wi_by_custno_and_cust_no($cust_partno, $cus_no){
        $query = $this->db->query("SELECT TW.INT_ID, WI.CHR_CUS_PART_NO, TW.CHR_WIDTH, TW.CHR_HEIGHT, RTRIM(WI.CHR_IMG_FILE_NAME) CHR_IMG_FILE_NAME
        FROM TM_WI_COORDINATE WI INNER JOIN TT_WI_COORDINATE TW ON TW.CHR_CUS_PART_NO = WI.CHR_CUS_PART_NO
        WHERE REPLACE(WI.CHR_CUS_PART_NO,'-','') = '$cust_partno' 
        AND '$cus_no' IN ('0010-','0010-01','0010-02','0010-03','0010-04','0010-05','0010-06','0011-','0011-01','0020-')
        GROUP BY TW.INT_ID, WI.CHR_CUS_PART_NO, TW.CHR_WIDTH, 
        TW.CHR_HEIGHT, WI.CHR_IMG_FILE_NAME");

        return $query;
    }

    public function get_exsting_wi_by_custno_and_cust_no_additional($cust_partno, $cus_no){
        $query = $this->db->query("SELECT TW.INT_ID, WI.CHR_CUS_PART_NO, TW.CHR_WIDTH, TW.CHR_HEIGHT, RTRIM(WI.CHR_IMG_FILE_NAME) CHR_IMG_FILE_NAME
        FROM TM_WI_COORDINATE WI INNER JOIN TT_WI_COORDINATE TW ON TW.CHR_CUS_PART_NO = WI.CHR_CUS_PART_NO
        WHERE REPLACE(WI.CHR_CUS_PART_NO,'-','') = '$cust_partno' 
        GROUP BY TW.INT_ID, WI.CHR_CUS_PART_NO, TW.CHR_WIDTH, 
        TW.CHR_HEIGHT, WI.CHR_IMG_FILE_NAME");

        return $query;
    }

    public function get_detail_wi_by_label($cust_partno, $part_no, $id_kanban, $serial){

        if(strlen(trim($cust_partno)) == 12){
            $cust_partno = substr(trim($cust_partno), -11);
        }

        $query = $this->db->query("SELECT TW.INT_ID, WI.CHR_CUS_PART_NO, TW.CHR_WIDTH, TW.CHR_HEIGHT, RTRIM(WI.CHR_IMG_FILE_NAME) CHR_IMG_FILE_NAME
        FROM TM_SHIPPING_PARTS SP 
        INNER JOIN TM_WI_COORDINATE WI ON WI.CHR_CUS_PART_NO = SP.CHR_CUS_PART_NO AND SP.CHR_PART_NO = WI.CHR_PART_NO 
        INNER JOIN TT_WI_COORDINATE TW ON TW.CHR_CUS_PART_NO = WI.CHR_CUS_PART_NO
        INNER JOIN TM_KANBAN_SERIAL KS ON KS.CHR_CUS_PART_NO = TW.CHR_CUS_PART_NO
        WHERE WI.INT_FLG_DELETE = 0 
        AND KS.INT_KANBAN_NO = $id_kanban 
        AND KS.INT_NUM_SERIAL = '$serial'
        AND SP.CHR_PART_NO = '$part_no'
        AND REPLACE(WI.CHR_CUS_PART_NO,'-','') LIKE '%$cust_partno'
        AND (
            SP.CHR_PART_NO LIKE '%P0%' OR 
            SP.CHR_PART_NO LIKE '%P1%' OR
            SP.CHR_PART_NO LIKE '%P2%' OR
            SP.CHR_PART_NO LIKE '%V0%' OR 
            SP.CHR_PART_NO LIKE '%V1%' 
        )
        AND KS.CHR_CUS_NO IN ('0010-','0010-01','0010-02','0010-03','0010-04','0010-05','0010-06','0011-','0011-01','0020-')
        GROUP BY TW.INT_ID, WI.CHR_CUS_PART_NO, TW.CHR_WIDTH, TW.CHR_HEIGHT, WI.CHR_IMG_FILE_NAME
        ORDER BY REPLACE(WI.CHR_CUS_PART_NO,'-','') DESC");
        
        return $query;
        
    }

    public function get_existing_master_label($part_no, $id_kanban, $serial){
        
        $query = $this->db->query("SELECT TOP 1 RTRIM(SP.CHR_PART_NO) CHR_PART_NO, SP.CHR_CUS_PART_NO 
            FROM TM_SHIPPING_PARTS SP 
            INNER JOIN TM_WI_COORDINATE WI ON WI.CHR_CUS_PART_NO = SP.CHR_CUS_PART_NO
            INNER JOIN TT_WI_COORDINATE TW ON TW.CHR_CUS_PART_NO = WI.CHR_CUS_PART_NO
            INNER JOIN TM_KANBAN_SERIAL KS ON SP.CHR_CUS_PART_NO = WI.CHR_CUS_PART_NO
            WHERE  WI.INT_FLG_DELETE = 0        
            AND KS.INT_KANBAN_NO = $id_kanban   
            AND KS.INT_NUM_SERIAL = '$serial'   
            AND SP.CHR_PART_NO = '$part_no'    
            AND (                               
                SP.CHR_PART_NO LIKE '%P0%' OR
                SP.CHR_PART_NO LIKE '%P1%' OR
                SP.CHR_PART_NO LIKE '%P2%' OR
                SP.CHR_PART_NO LIKE '%V0%' OR
                SP.CHR_PART_NO LIKE '%V1%' 
            )
            AND KS.CHR_CUS_NO IN ('0010-','0010-01','0010-02','0010-03','0010-04','0010-05','0010-06','0011-','0011-01','0020-') 
            GROUP BY SP.CHR_PART_NO, SP.CHR_CUS_PART_NO");

        if($query->num_rows() > 0){
            return true;
        }else{
            return false;
        }
    }

    public function get_master_wi($part_no, $cust_no){

        if($cust_no == '' || $cust_no == NULL){
            $query = $this->db->query("SELECT TW.INT_ID, SP.CHR_CUS_PART_NO, TW.CHR_WIDTH, TW.CHR_HEIGHT, RTRIM(WI.CHR_IMG_FILE_NAME) CHR_IMG_FILE_NAME
            FROM TM_SHIPPING_PARTS SP 
            INNER JOIN TM_WI_COORDINATE WI ON WI.CHR_CUS_PART_NO = SP.CHR_CUS_PART_NO
            INNER JOIN TT_WI_COORDINATE TW ON TW.CHR_CUS_PART_NO = WI.CHR_CUS_PART_NO
            WHERE 
            WI.INT_FLG_DELETE = 0 
            AND SP.CHR_PART_NO = '$part_no' AND (
                SP.CHR_PART_NO LIKE '%P1%' OR 
                SP.CHR_PART_NO LIKE '%V0%' OR 
                SP.CHR_PART_NO LIKE '%P2%' OR 
                SP.CHR_PART_NO LIKE '%P0%' OR 
                SP.CHR_PART_NO LIKE '%V1%' 
            ) 
            --AND SP.CHR_CUS_NO = '$cust_no'
            GROUP BY TW.INT_ID, SP.CHR_CUS_PART_NO, TW.CHR_WIDTH, TW.CHR_HEIGHT, WI.CHR_IMG_FILE_NAME");
        }else{
            $query = $this->db->query("SELECT TW.INT_ID, SP.CHR_CUS_PART_NO, TW.CHR_WIDTH, TW.CHR_HEIGHT, RTRIM(WI.CHR_IMG_FILE_NAME) CHR_IMG_FILE_NAME
            FROM TM_SHIPPING_PARTS SP 
            INNER JOIN TM_WI_COORDINATE WI ON WI.CHR_CUS_PART_NO = SP.CHR_CUS_PART_NO
            INNER JOIN TT_WI_COORDINATE TW ON TW.CHR_CUS_PART_NO = WI.CHR_CUS_PART_NO
            WHERE 
            WI.INT_FLG_DELETE = 0 
            AND SP.CHR_PART_NO = '$part_no' AND (
                SP.CHR_PART_NO LIKE '%P1%' OR 
                SP.CHR_PART_NO LIKE '%V0%' OR 
                SP.CHR_PART_NO LIKE '%P2%' OR 
                SP.CHR_PART_NO LIKE '%P0%' OR 
                SP.CHR_PART_NO LIKE '%V1%' 
            ) 
            AND SP.CHR_CUS_NO = '$cust_no'
            GROUP BY TW.INT_ID, SP.CHR_CUS_PART_NO, TW.CHR_WIDTH, TW.CHR_HEIGHT, WI.CHR_IMG_FILE_NAME");
        }

        return $query;
    }

    function get_existing_wi_part_cust_no($part_cust_no){

        $query = $this->db->query("SELECT TOP 1 CHR_CUS_PART_NO  FROM $this->tabel WHERE CHR_CUS_PART_NO = '$part_cust_no' GROUP BY CHR_CUS_PART_NO ORDER BY CHR_CUS_PART_NO");

        if($query->num_rows() > 0){
            return 1;
        }else{
            return 0;
        }
    }

    function save_wi($data){
        $this->db->insert($this->tabel, $data);
    }

    function update_wi($data, $part_cust_no){
        $this->db->where('CHR_CUS_PART_NO', $part_cust_no);
        $this->db->update($this->tabel, $data);
    }

    function update_wi_by_id($data, $id){
        $this->db->where('INT_ID', $id);
        $this->db->update($this->tabel, $data);
    }

    function delete_wi($part_cust_no){
        $data = array('INT_FLG_DELETE' => 1);
        $this->db->where('CHR_CUS_PART_NO', $part_cust_no);
        $this->db->update($this->tabel, $data);
    }

    function undelete_wi($part_cust_no){
        $data = array('INT_FLG_DELETE' => 0);
        $this->db->where('CHR_CUS_PART_NO', $part_cust_no);
        $this->db->update($this->tabel, $data);
    }

    function save_coordinate($data){
        $this->db->insert($this->tabel_detail, $data);

        $this->db->query(";WITH CTE_COORDINATE_DOUBLE (NOROW, INT_ID) AS (
            SELECT ROW_NUMBER() over (PARTITION BY CHR_CUS_PART_NO, CHR_WIDTH, CHR_HEIGHT ORDER BY INT_ID) AS NOROW, 
                INT_ID FROM TT_WI_COORDINATE WHERE CHR_CUS_PART_NO IN (
                SELECT CHR_CUS_PART_NO FROM TT_WI_COORDINATE
                GROUP BY CHR_CUS_PART_NO, CHR_WIDTH, CHR_HEIGHT
                HAVING COUNT(CHR_CUS_PART_NO) > 1
            )
        )
        DELETE FROM TT_WI_COORDINATE WHERE INT_ID IN (
            SELECT INT_ID FROM CTE_COORDINATE_DOUBLE WHERE NOROW >= 2
        )");
    }

    function delete_coordinate($data){
        $this->db->delete($this->tabel_detail, $data);
    }

    function check_exist_coordinate_by_id($part_cust_no){
        $query = $this->db->get_where($this->tabel_detail,  array('CHR_CUS_PART_NO' => $part_cust_no));
        if($query->num_rows() > 0){
            return 1;
        }else{
            return 0;
        }
    }

    function get_cust_no_by_part_cust_no($part_cust_no){
        $query = $this->db->query("SELECT TOP 1 CHR_CUS_NO FROM TM_SHIPPING_PARTS WHERE CHR_CUS_PART_NO = '$part_cust_no' GROUP BY CHR_CUS_NO");
        return $query->row()->CHR_CUS_NO;
    }

    function checklist_coordinate($id){
        $data = array('INT_FLG_USED' => 1);
        $this->db->where('INT_ID', $id);
        $this->db->where('INT_FLG_USED', 0);
        $this->db->update($this->tabel_detail, $data);

        $query = $this->db->query("SELECT CHR_CUS_PART_NO, INT_FLG_USED, CHR_HEIGHT, CHR_WIDTH, INT_ID FROM $this->tabel_detail WHERE INT_FLG_USED = 0 AND CHR_CUS_PART_NO = 
            (SELECT CHR_CUS_PART_NO FROM $this->tabel_detail WHERE INT_ID = '$id')");

        if($query->num_rows() > 0){
            return false;
        }else{
            return true;
        }
    }
    
    //delete
    function flag_data_wi_by_coordinate($id_coordinate){

        $data = array('INT_FLG_USED' => 1);

        $this->db->where('INT_ID', $id_coordinate);
        $this->db->where('INT_FLG_USED', 0);
        $this->db->update($this->tabel_detail, $data);

        $query = $this->db->query("SELECT CHR_CUS_PART_NO, INT_FLG_USED, CHR_HEIGHT, CHR_WIDTH, INT_ID
            FROM $this->tabel_detail WHERE INT_FLG_USED = 0 AND CHR_CUS_PART_NO = 
            (SELECT CHR_CUS_PART_NO FROM $this->tabel_detail WHERE INT_ID = '$id_coordinate')");

        if($query->num_rows() > 0){
            return 0;
        }else{
            return 1;
        }
    }

    function reset_coordinate_image($partno){

        $query = $this->db->query("UPDATE $this->tabel_detail SET INT_FLG_USED = 0");
    }

    public function get_part_cust_by_part_no($part_no, $work_center){
        $query = $this->db->query("SELECT SP.CHR_PART_NO, SP.CHR_CUS_PART_NO 
        FROM TM_SHIPPING_PARTS SP 
        INNER JOIN TM_PROCESS_PARTS PP ON PP.CHR_PART_NO = SP.CHR_PART_NO
        WHERE SP.CHR_PART_NO = '$part_no' AND PP.CHR_WORK_CENTER = '$work_center'
        GROUP BY SP.CHR_CUS_PART_NO,SP.CHR_PART_NO")->num_rows();

        if($query > 0){
            return true;
        }else{
            return false;
        }
    }

    public function get_top_part_cust_by_part_no($part_no, $work_center){
        $query = $this->db->query("SELECT TOP 1 SP.CHR_PART_NO, SP.CHR_CUS_PART_NO 
        FROM TM_SHIPPING_PARTS SP 
        INNER JOIN TM_PROCESS_PARTS PP ON PP.CHR_PART_NO = SP.CHR_PART_NO
        WHERE SP.CHR_PART_NO = '$part_no' AND PP.CHR_WORK_CENTER = '$work_center'
        GROUP BY SP.CHR_CUS_PART_NO,SP.CHR_PART_NO");

        if($query->num_rows() > 0){
            return $query->row()->CHR_CUS_PART_NO;
        }else{
            return 'No Part Customer';
        }
    }

    function verify_part_no_with_customer($part_no, $cust_partno){
        $match_flag = $this->db->query("SELECT TOP 1 SP.CHR_PART_NO, SP.CHR_CUS_PART_NO FROM TM_PROCESS_PARTS PP 
            INNER JOIN TM_SHIPPING_PARTS SP ON PP.CHR_PART_NO = SP.CHR_PART_NO
            WHERE SP.CHR_PART_NO = '$part_no' AND REPLACE(SP.CHR_CUS_PART_NO,'-','') = '$cust_partno'
            GROUP BY SP.CHR_PART_NO, SP.CHR_CUS_PART_NO");

        if($match_flag->num_rows() > 0){
            return true;
        }else{
            return false;
        }
    }

}
