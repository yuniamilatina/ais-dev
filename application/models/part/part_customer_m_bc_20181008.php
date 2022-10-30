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
        WHERE 
        PP.CHR_WORK_CENTER = 'PK0002' AND (
        SP.CHR_PART_NO LIKE '%P1%' OR SP.CHR_PART_NO LIKE '%V0%' OR
        SP.CHR_PART_NO LIKE '%P0%' OR SP.CHR_PART_NO LIKE '%V1%' )
        GROUP BY SP.CHR_CUS_PART_NO,SP.CHR_PART_NO");

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
        PP.CHR_WORK_CENTER = 'PK0002' AND (
        SP.CHR_PART_NO LIKE '%P1%' OR SP.CHR_PART_NO LIKE '%V0%' OR
        SP.CHR_PART_NO LIKE '%P0%' OR SP.CHR_PART_NO LIKE '%V1%' )
        GROUP BY SP.CHR_CUS_PART_NO,SP.CHR_PART_NO");

        return $query->row()->CHR_CUS_PART_NO;
    }

    public function get_data_part_aisin_by_part_cust_no($cust_partno){

        $query = $this->db->query("SELECT SP.CHR_PART_NO, SP.CHR_CUS_PART_NO FROM TM_SHIPPING_PARTS SP INNER JOIN TM_PROCESS_PARTS PP ON 
        PP.CHR_PART_NO = SP.CHR_PART_NO
        WHERE 
        SP.CHR_CUS_PART_NO = '$cust_partno' AND
        PP.CHR_WORK_CENTER = 'PK0002' AND (
        SP.CHR_PART_NO LIKE '%P1%' OR SP.CHR_PART_NO LIKE '%V0%' OR
        SP.CHR_PART_NO LIKE '%P0%' OR SP.CHR_PART_NO LIKE '%V1%' )
        GROUP BY SP.CHR_CUS_PART_NO, SP.CHR_PART_NO");

        return $query->result();
    }

    public function get_top_part_aisin_by_part_cust_no($cust_partno){
        $query = $this->db->query("SELECT TOP 1 SP.CHR_PART_NO, SP.CHR_CUS_PART_NO FROM TM_SHIPPING_PARTS SP INNER JOIN TM_PROCESS_PARTS PP ON 
        PP.CHR_PART_NO = SP.CHR_PART_NO
        WHERE 
        SP.CHR_CUS_PART_NO = '$cust_partno' AND
        PP.CHR_WORK_CENTER = 'PK0002' AND (
        SP.CHR_PART_NO LIKE '%P1%' OR SP.CHR_PART_NO LIKE '%V0%' OR
        SP.CHR_PART_NO LIKE '%P0%' OR SP.CHR_PART_NO LIKE '%V1%' )
        GROUP BY SP.CHR_CUS_PART_NO,SP.CHR_PART_NO");

        return $query->row()->CHR_PART_NO;
    }

    function get_part_coordinate_by_cust_part_no($cust_partno, $part_no){


        $query = $this->db->query("SELECT TW.INT_ID, RTRIM(SP.CHR_PART_NO) CHR_PART_NO, SP.CHR_CUS_PART_NO, K.CHR_BACK_NO , 
        TW.CHR_WIDTH, TW.CHR_HEIGHT, RTRIM(WI.CHR_IMG_FILE_NAME) CHR_IMG_FILE_NAME
        FROM TM_SHIPPING_PARTS SP 
        INNER JOIN TM_WI_COORDINATE WI ON WI.CHR_CUS_PART_NO = SP.CHR_CUS_PART_NO
        INNER JOIN TT_WI_COORDINATE TW ON TW.CHR_CUS_PART_NO = WI.CHR_CUS_PART_NO
        INNER JOIN TM_PARTS P ON SP.CHR_PART_NO = P.CHR_PART_NO 
        INNER JOIN TM_KANBAN K ON P.CHR_PART_NO = K.CHR_PART_NO
        WHERE SP.CHR_DIS_CHANNEL = 'C2' AND REPLACE(SP.CHR_CUS_PART_NO,'-','') = '$cust_partno' AND SP.CHR_PART_NO = '$part_no' AND (
        SP.CHR_PART_NO LIKE '%P1%' OR SP.CHR_PART_NO LIKE '%V0%' OR
        SP.CHR_PART_NO LIKE '%P0%' OR SP.CHR_PART_NO LIKE '%V1%' )
        GROUP BY TW.INT_ID, SP.CHR_PART_NO, SP.CHR_CUS_PART_NO, K.CHR_BACK_NO, TW.CHR_WIDTH, TW.CHR_HEIGHT, WI.CHR_IMG_FILE_NAME");

        return $query;
    }

    function get_part_coordinate_by_part_no($part_no){

        $query = $this->db->query("SELECT TW.INT_ID, RTRIM(SP.CHR_PART_NO) CHR_PART_NO, SP.CHR_CUS_PART_NO, K.CHR_BACK_NO , 
        TW.CHR_WIDTH, TW.CHR_HEIGHT, RTRIM(WI.CHR_IMG_FILE_NAME) CHR_IMG_FILE_NAME
        FROM TM_SHIPPING_PARTS SP 
        INNER JOIN TM_WI_COORDINATE WI ON WI.CHR_CUS_PART_NO = SP.CHR_CUS_PART_NO
        INNER JOIN TT_WI_COORDINATE TW ON TW.CHR_CUS_PART_NO = WI.CHR_CUS_PART_NO
        INNER JOIN TM_PARTS P ON SP.CHR_PART_NO = P.CHR_PART_NO 
        INNER JOIN TM_KANBAN K ON P.CHR_PART_NO = K.CHR_PART_NO
        WHERE SP.CHR_DIS_CHANNEL = 'C2' AND SP.CHR_PART_NO = '$part_no' AND (
        SP.CHR_PART_NO LIKE '%P1%' OR SP.CHR_PART_NO LIKE '%V0%' OR
        SP.CHR_PART_NO LIKE '%P0%' OR SP.CHR_PART_NO LIKE '%V1%' )
        AND CHR_CUS_NO NOT IN ('0010-','0010-01','0010-02','0010-03','0010-04','0010-05','0010-06','0011-','0011-01')
        GROUP BY TW.INT_ID, SP.CHR_PART_NO, SP.CHR_CUS_PART_NO, K.CHR_BACK_NO, TW.CHR_WIDTH, TW.CHR_HEIGHT, WI.CHR_IMG_FILE_NAME");

        return $query;
    }

    //get just TMMIN 
    function get_exsting_wi_by_backno($partno){

        $query = $this->db->query("SELECT TOP 1 RTRIM(SP.CHR_PART_NO) CHR_PART_NO, SP.CHR_CUS_PART_NO 
        FROM TM_SHIPPING_PARTS SP 
        INNER JOIN TM_WI_COORDINATE WI ON WI.CHR_CUS_PART_NO = SP.CHR_CUS_PART_NO
        INNER JOIN TT_WI_COORDINATE TW ON TW.CHR_CUS_PART_NO = WI.CHR_CUS_PART_NO
        INNER JOIN TM_PARTS P ON SP.CHR_PART_NO = P.CHR_PART_NO 
        WHERE SP.CHR_DIS_CHANNEL = 'C2' AND WI.INT_FLG_DELETE = 0 AND P.CHR_PART_NO = '$partno' AND (
        SP.CHR_PART_NO LIKE '%P1%' OR SP.CHR_PART_NO LIKE '%V0%' OR
        SP.CHR_PART_NO LIKE '%P0%' OR SP.CHR_PART_NO LIKE '%V1%' )
        AND CHR_CUS_NO IN ('0010-','0010-01','0010-02','0010-03','0010-04','0010-05','0010-06','0011-','0011-01')
        GROUP BY SP.CHR_PART_NO, SP.CHR_CUS_PART_NO");

        return $query;
    }
    
    function get_exsting_wi_by_backno_additional($partno){

        $query = $this->db->query("SELECT TOP 1 RTRIM(SP.CHR_PART_NO) CHR_PART_NO, SP.CHR_CUS_PART_NO 
        FROM TM_SHIPPING_PARTS SP 
        INNER JOIN TM_WI_COORDINATE WI ON WI.CHR_CUS_PART_NO = SP.CHR_CUS_PART_NO
        INNER JOIN TT_WI_COORDINATE TW ON TW.CHR_CUS_PART_NO = WI.CHR_CUS_PART_NO
        INNER JOIN TM_PARTS P ON SP.CHR_PART_NO = P.CHR_PART_NO 
        WHERE SP.CHR_DIS_CHANNEL = 'C2' AND WI.INT_FLG_DELETE = 0 AND P.CHR_PART_NO = '$partno' AND (
        SP.CHR_PART_NO LIKE '%P1%' OR SP.CHR_PART_NO LIKE '%V0%' OR
        SP.CHR_PART_NO LIKE '%P0%' OR SP.CHR_PART_NO LIKE '%V1%' )
        GROUP BY SP.CHR_PART_NO, SP.CHR_CUS_PART_NO");

        return $query;
    }

    public function get_data_part_customer_wi(){
        $query = $this->db->query("SELECT WI.INT_ID, WI.CHR_CUS_PART_NO , K.CHR_BACK_NO, SP.CHR_PART_NO,P.CHR_PART_NAME, WI.INT_FLG_MODIFIED, INT_FLG_DELETE,
        CASE WI.INT_FLG_DELETE WHEN 0 THEN 'AKTIF' ELSE 'NON-AKTIF' END AS INT_FLG_DELETE_DESC
        FROM TM_WI_COORDINATE WI
        LEFT JOIN TM_SHIPPING_PARTS SP ON WI.CHR_CUS_PART_NO = SP.CHR_CUS_PART_NO
        LEFT JOIN TM_PARTS P ON SP.CHR_PART_NO = P.CHR_PART_NO 
        LEFT JOIN TM_KANBAN K ON P.CHR_PART_NO = K.CHR_PART_NO
        WHERE SP.CHR_DIS_CHANNEL = 'C2' AND (
        SP.CHR_PART_NO LIKE '%P1%' OR SP.CHR_PART_NO LIKE '%V0%' OR
        SP.CHR_PART_NO LIKE '%P0%' OR SP.CHR_PART_NO LIKE '%V1%' ) 
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
        WHERE SP.CHR_DIS_CHANNEL = 'C2' AND WI.INT_FLG_DELETE = 0 AND (
        SP.CHR_PART_NO LIKE '%P1%' OR SP.CHR_PART_NO LIKE '%V0%' OR
        SP.CHR_PART_NO LIKE '%P0%' OR SP.CHR_PART_NO LIKE '%V1%' )
        GROUP BY WI.INT_ID, SP.CHR_PART_NO, SP.CHR_CUS_PART_NO, K.CHR_BACK_NO, TW.CHR_WIDTH, TW.CHR_HEIGHT, P.CHR_PART_NAME");

        return $query->result();
    }

    function get_detail_part_customer_by_part_cust_no($part_cust_no){

        //$part_cust_no = '68720-0K020';

        $query = $this->db->query("SELECT CHR_CUS_PART_NO,CHR_IMG_FILE_NAME FROM TM_WI_COORDINATE 
        WHERE CHR_CUS_PART_NO = '$part_cust_no' GROUP BY CHR_IMG_FILE_NAME,CHR_CUS_PART_NO");

        return $query->row();
    }

    function get_coordinate_part_customer_by_part_cust_no($part_cust_no){
        //$part_cust_no = '68720-0K020';

        $query = $this->db->query("SELECT * FROM TT_WI_COORDINATE WHERE CHR_CUS_PART_NO = '$part_cust_no'");

        return $query->result();
    }

    function get_data_part_customer_by_id($part_cust_no){

        $query = $this->db->query("SELECT WI.INT_ID, RTRIM(SP.CHR_PART_NO) CHR_PART_NO, SP.CHR_CUS_PART_NO, K.CHR_BACK_NO , 
        TW.CHR_WIDTH, TW.CHR_HEIGHT, RTRIM(K.CHR_BACK_NO) + '.JPG' CHR_URL_PICTURE, P.CHR_PART_NAME
        FROM TM_SHIPPING_PARTS SP 
        INNER JOIN TM_WI_COORDINATE WI ON WI.CHR_CUS_PART_NO = SP.CHR_CUS_PART_NO
        INNER JOIN TT_WI_COORDINATE TW ON TW.CHR_CUS_PART_NO = WI.CHR_CUS_PART_NO
        INNER JOIN TM_PARTS P ON SP.CHR_PART_NO = P.CHR_PART_NO 
        INNER JOIN TM_KANBAN K ON P.CHR_PART_NO = K.CHR_PART_NO
        WHERE SP.CHR_DIS_CHANNEL = 'C2' AND WI.CHR_CUS_PART_NO = '$part_cust_no' AND (
        SP.CHR_PART_NO LIKE '%P1%' OR SP.CHR_PART_NO LIKE '%V0%' OR
        SP.CHR_PART_NO LIKE '%P0%' OR SP.CHR_PART_NO LIKE '%V1%' ) 
        GROUP BY WI.INT_ID, SP.CHR_PART_NO, SP.CHR_CUS_PART_NO, K.CHR_BACK_NO, TW.CHR_WIDTH, TW.CHR_HEIGHT, P.CHR_PART_NAME");

        return $query->result();
    }

    function get_existing_wi_part_cust_no($part_cust_no){

        $query = $this->db->query("SELECT TOP 1 CHR_CUS_PART_NO  FROM $this->tabel WHERE CHR_CUS_PART_NO = '$part_cust_no'
        GROUP BY CHR_CUS_PART_NO ORDER BY CHR_CUS_PART_NO");

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

    function flag_data_wi_by_coordinate($id_coordinate, $part_cust_no, $partno){

        $data = array('INT_FLG_USED' => 1);

        $this->db->where('INT_ID', $id_coordinate);
        $this->db->where('INT_FLG_USED', 0);
        $this->db->update($this->tabel_detail, $data);

        $query = $this->db->query("SELECT TM.CHR_PART_NO, TT.CHR_CUS_PART_NO, TT.INT_FLG_USED, TT.CHR_HEIGHT, TT.CHR_WIDTH, TT.INT_ID
            FROM TM_SHIPPING_PARTS TM INNER JOIN $this->tabel_detail TT ON TT.CHR_CUS_PART_NO = TM.CHR_CUS_PART_NO
            WHERE TM.CHR_PART_NO = '$partno' 
            AND TT.INT_FLG_USED = 0 
            AND TT.CHR_CUS_PART_NO = (SELECT CHR_CUS_PART_NO FROM TT_WI_COORDINATE WHERE INT_ID = '$id_coordinate')
            GROUP BY TM.CHR_PART_NO, TT.CHR_CUS_PART_NO, TT.INT_FLG_USED, TT.CHR_HEIGHT, TT.CHR_WIDTH, TT.INT_ID ");

        if($query->num_rows() > 0){
            return 0;
        }else{
            return 1;
        }
    }

    function update_default_wi_coordinate($partno){

        $query = $this->db->query("UPDATE TT SET INT_FLG_USED = 0 FROM TT_WI_COORDINATE TT INNER JOIN TM_SHIPPING_PARTS TM 
        ON TT.CHR_CUS_PART_NO = TM.CHR_CUS_PART_NO
        WHERE TM.CHR_PART_NO = '$partno' ");
    }

    // function update_default_wi_coordinate_by_partno($partno){

    //     $query = $this->db->query("UPDATE TT SET INT_FLG_USED = 0 FROM TT_WI_COORDINATE TT INNER JOIN TM_SHIPPING_PARTS TM 
    //         ON TT.CHR_CUS_PART_NO = TM.CHR_CUS_PART_NO
    //         WHERE TM.CHR_PART_NO = '$partno' ");
    // }

}
