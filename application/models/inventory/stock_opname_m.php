<?php

class stock_opname_m extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function update($data, $id) {
        $db_infinity = $this->load->database('db_infinity', TRUE);
        $db_infinity->where($id);
        $db_infinity->update('STO_TT_STOCKOPNAME', $data);
    }

    function upt_print($data, $id) {
        $db_infinity = $this->load->database('db_infinity', TRUE);
        $db_infinity->where($id);
        $db_infinity->update('STO_TT_STOCKOPNAME', $data);
    }

    //grid table
    function select_data_stock_opname($chute) {
        // $stored_procedure = "EXEC INV.zsp_select_data_stock_opname";

        // $query = $this->db->query($stored_procedure);
        // return $query->result();

        $db_infinity = $this->load->database('db_infinity', TRUE);
        $hasil = $db_infinity->query("SELECT P_No
                ,P_Name
                ,B_No
                ,No_Seri
                ,REPLACE(No_Seri,' ','') + B_No AS ID
                ,S_Location
                ,Qty
                ,Multiplier
                ,(Qty * Multiplier) + ISNULL(Eceran,0) as sum_total
                ,ISNULL(Eceran,0) eceran
                ,'-' AS uom
                ,SUBAREA
                ,Chute
                ,Scanner_ID
                ,CAST(username AS VARCHAR(6)) username
                ,Tgl
                ,Waktu
                ,CAST(NPK_Update AS VARCHAR(6)) NPK_Update
                ,Tgl_Update
                ,Waktu_Update
                ,CHR_ID_DOC
            FROM STO_TT_STOCKOPNAME WHERE RIGHT(RTRIM(Chute),1) = '$chute' ");
        return $hasil->result();
    }

    //grid table
    function select_data_stock_opname_by_chute($chute_id) {
        $db_infinity = $this->load->database('db_infinity', TRUE);
        $hasil = $db_infinity->query("SELECT P_No
                ,P_Name
                ,B_No
                ,No_Seri
                ,REPLACE(No_Seri,' ','') + B_No AS ID
                ,S_Location
                ,Qty
                ,Multiplier
                ,(Qty * Multiplier) + ISNULL(Eceran,0) as sum_total
                ,ISNULL(Eceran,0) eceran
                ,'-' AS uom
                ,SUBAREA
                ,Chute
                ,Scanner_ID
                ,CAST(username AS VARCHAR(6))
                ,Tgl
                ,Waktu
                ,CAST(NPK_Update AS VARCHAR(6)) NPK_Update
                ,Tgl_Update
                ,Waktu_Update
                ,CHR_ID_DOC
            FROM STO_TT_STOCKOPNAME WHERE RIGHT(RTRIM(Chute),1) = '$chute_id'");
        return $hasil->result();
    }

    function data_id_sto_by_chute($chute_id) {
        $db_infinity = $this->load->database('db_infinity', TRUE);
        $hasil = $db_infinity->query("SELECT P_No
                ,P_Name
                ,B_No
                ,No_Seri
                ,REPLACE(No_Seri,' ','') + B_No AS ID
                ,S_Location
                ,Qty
                ,Multiplier
                ,(Qty * Multiplier) + ISNULL(Eceran,0) as sum_total
                ,ISNULL(Eceran,0) eceran
                ,'-' AS uom
                ,SUBAREA
                ,CHR_ID_DOC
                ,Chute
                ,Scanner_ID
                ,CAST(username AS VARCHAR(6))
                ,Tgl
                ,Waktu
                ,flag_spooling
                ,CAST(NPK_Update AS VARCHAR(6)) NPK_Update
                ,Tgl_Update
                ,Waktu_Update
            FROM STO_TT_STOCKOPNAME WHERE RIGHT(RTRIM(Chute),1) = '$chute_id' order by CHR_ID_DOC asc");
        return $hasil->result();
    }
    
    function select_data_stock_opname_by_id($seri, $partno){
        $db_infinity = $this->load->database('db_infinity', TRUE);
        $hasil = $db_infinity->query("SELECT P_No
                ,P_Name
                ,B_No
                ,No_Seri
                ,S_Location
                ,Qty
                ,Multiplier
                ,(Qty * Multiplier) + ISNULL(Eceran,0) as sum_total
                ,ISNULL(Eceran,0) eceran
                ,'-' AS uom
                ,SUBAREA
                ,Chute
                ,Scanner_ID
                ,CAST(username AS VARCHAR(6))
                ,Tgl
                ,Waktu
                ,CAST(NPK_Update AS VARCHAR(6)) NPK_Update
                ,Tgl_Update
                ,Waktu_Update
            FROM STO_TT_STOCKOPNAME WHERE No_Seri = '$seri' AND P_No = '$partno'");
        return $hasil->result();
    }

    // function select_acquired_date() {
    //     $query = $this->db->query("SELECT TOP 1 CHR_CREATED_DATE, CHR_CREATED_TIME 
    //                 FROM INV.TM_STOCK_OPNAME
    //                 ORDER BY CHR_CREATED_DATE DESC");

    //     if ($query->num_rows() > 0) {
    //         $acquired_date = $query->row_array();
    //         return date("j/F/Y", strtotime($acquired_date['CHR_CREATED_DATE'])) . ' ' . $acquired_date['CHR_CREATED_TIME'];
    //     } else {
    //         return 0;
    //     }
    // }

    //grid table
    function select_data_stock_opname_entry() {
        $stock_opname = $this->load->database('stock_opname', TRUE);

        return $stock_opname->query("SELECT `lso_back_no`,
		`lso_no_sap`,
		`lso_part_name`,
		`lso_sloc`,
		`lso_amount_pcs_in_box`,
		`lso_amount_box`,
		`lso_amount_pcs`,
		`lso_unit`,
                `lso_address`,
                `lso_page`,
                `no_of_page`,
		`lso_area`,
		`lso_area_sto`,
		`Iso_qty_box`,
		`Iso_qty_eceran`,
		`lso_acc_qty_box`,
		`lso_acc_qty_eceran`,
        (lso_amount_pcs_in_box * lso_acc_qty_box) + lso_acc_qty_eceran AS lso_acc_total,
		((lso_amount_pcs_in_box * lso_amount_box) + lso_amount_pcs) - ((lso_amount_pcs_in_box * lso_acc_qty_box) + lso_acc_qty_eceran) lso_acc_diff 
                FROM `so_tt_list_stock_opname`")->result();
    }

    function get_weekly_sto($date_from, $date_to) {
        $db_infinity = $this->load->database('db_infinity', TRUE);
        $hasil = $db_infinity->query("SELECT * FROM STO_TT_STOCKOPNAME where Tgl between '$date_from' and '$date_to' order by SUBAREA ");
        return $hasil->result();
    }

    function get_chute() {
        $db_infinity = $this->load->database('db_infinity', TRUE);
        $hasil = $db_infinity->query("SELECT Chute, RIGHT(RTRIM(Chute),1) Chute_id, 
            CASE WHEN  RIGHT(RTRIM(Chute),1) = 1 THEN 'RM'
            WHEN  RIGHT(RTRIM(Chute),1) = 2 THEN 'OH'
            WHEN  RIGHT(RTRIM(Chute),1) = 4 THEN 'CKD'
            WHEN  RIGHT(RTRIM(Chute),1) = 6 THEN 'FG'
            ELSE '' END AS chute_desc
        FROM STO_TT_STOCKOPNAME GROUP BY Chute, RIGHT(RTRIM(Chute),1) ORDER  BY Chute");
        return $hasil->result();
    }

    function get_top_chute() {
        $db_infinity = $this->load->database('db_infinity', TRUE);
        $hasil = $db_infinity->query("SELECT Chute, RIGHT(RTRIM(Chute),1) Chute_id FROM STO_TT_STOCKOPNAME GROUP BY Chute, RIGHT(RTRIM(Chute),1) ORDER  BY Chute");
        return $hasil->row()->Chute_id;
    }
}
?>

