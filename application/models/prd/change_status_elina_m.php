<?php

class change_status_elina_m extends CI_Model {
    
    function __construct() {
        parent::__construct();
    }
    private $tbl = 'TT_PARTS_SLOC';
    private $tbl_part = 'PRD.TT_ELINA_L';
    
    function get_stat_order() {
        return $this->db->query("SELECT CHR_PRD_ORDER_NO, CHR_SEQ, CHR_WORK_CT, CHR_PART_NO, CHR_PART_NAME, CHR_BACK_NO, INT_QTY_PER_BOX, 
                                CHR_PREPARE_AREA, CHR_STORAGE, INT_ORDER_BOX, INT_ORDER_PCS
                                FROM PRD.TW_CHECK_STOCK_SETUP_CHUTE order by CHR_WORK_CT asc")->result();
    }

    // function get_stat_order() {
    //     return $this->db->query("select b.INT_ID,b.CHR_PRD_ORDER_NO, b.CHR_PART_NO, b.CHR_BACK_NO, b.CHR_PREPARE_AREA, b.INT_ORDER_BOX, b.INT_ORDER_PCS, a.CHR_DATE_ORDER, a.CHR_TIME_ORDER
    //                             from PRD.TT_ELINA_H a inner join PRD.TT_ELINA_L b on a.CHR_PRD_ORDER_NO=b.CHR_PRD_ORDER_NO
    //                             where (a.CHR_FLAG='1') and b.CHR_FLAG_STOCK='T' order by a.CHR_DATE_ORDER desc")->result();
    // }
    
    function get_data_by_id($prdno,$partno) {
        return $this->db->query("select a.*,b.INT_ID,c.INT_PART_QTY,c.CHR_SLOC from PRD.TT_ELINA_L a inner join PRD.TT_ELINA_H b on a.CHR_PRD_ORDER_NO=b.CHR_PRD_ORDER_NO
                                inner join TT_PARTS_SLOC c on c.CHR_PART_NO=a.CHR_PART_NO
                                where a.INT_ID='$prdno' and a.CHR_PART_NO='$partno' and c.CHR_SLOC=a.CHR_STORAGE")->row();
    }
    
    function update($data,$prod, $pno,$sloc,$wkctr) {
        $this->db->where('CHR_PART_NO', $pno);
        $this->db->where('CHR_SLOC', $sloc);
        $this->db->update($this->tbl, $data);
        
        $this->db->query("UPDATE PRD.TT_ELINA_L SET
                                         CHR_FLAG_STOCK = 'F'
                                    WHERE CHR_PRD_ORDER_NO='$prod'");
        
        $this->db->query("UPDATE PRD.TT_ELINA_H SET
                                    CHR_FLAG = 'X'
                               WHERE (CHR_FLAG = '1' or CHR_FLAG = '2') AND CHR_PRD_ORDER_NO='$prod'");
        // $this->db->query("UPDATE PRD.TT_ELINA_L set                                          
        //                                 CHR_FLAG_STOCK    = 'T'
        //                            where CHR_FLAG_STOCK    = 'F' and CHR_PART_NO='$pno'");        
        
        // $cek_data = $this->db->query("select * from PRD.TT_ELINA_L a inner join TT_PARTS_SLOC b on b.CHR_PART_NO=a.CHR_PART_NO
        //                                             inner join PRD.TT_ELINA_H c on c.CHR_PRD_ORDER_NO=a.CHR_PRD_ORDER_NO
        //                                             where b.INT_PART_QTY<=0 and b.CHR_SLOC=a.CHR_STORAGE and c.CHR_FLAG    = 'X'");
        // if ($cek_data->num_rows() > 0) {
        //     $cek_flagx = $this->db->query("select top 1 b.CHR_PRD_ORDER_NO from PRD.TT_ELINA_L a inner join PRD.TT_ELINA_H b on a.CHR_PRD_ORDER_NO=b.CHR_PRD_ORDER_NO
        //                                 inner join TT_PARTS_SLOC as c on c.CHR_PART_NO=a.CHR_PART_NO 
        //                                 where b.CHR_FLAG='X' and c.CHR_SLOC=a.CHR_STORAGE");
        //     if ($cek_flagx->num_rows() > 0) {
        //         $tt_prodno = $cek_flagx->result();
        //         foreach ($tt_prodno as $value){
        //             $prod_no = trim($value->CHR_PRD_ORDER_NO);

        //             $cek_flagz = $this->db->query("select top 1 b.CHR_PRD_ORDER_NO from PRD.TT_ELINA_L a inner join PRD.TT_ELINA_H b on a.CHR_PRD_ORDER_NO=b.CHR_PRD_ORDER_NO
        //                                         where b.CHR_FLAG='X' and a.CHR_FLAG_STOCK = 'F' and a.CHR_PRD_ORDER_NO='$prod_no'");
        //             if ($cek_flagz->num_rows() < 1) {
        //                 $this->db->query("update PRD.TT_ELINA_L set CHR_FLAG_STOCK='F' where CHR_PRD_ORDER_NO='$prod_no'");
        //                 $datax = $this->db->query("select * from PRD.TT_ELINA_L a inner join PRD.TT_ELINA_H b on a.CHR_PRD_ORDER_NO=b.CHR_PRD_ORDER_NO
        //                                     inner join TT_PARTS_SLOC as c on c.CHR_PART_NO=a.CHR_PART_NO 
        //                                     where b.CHR_FLAG='X' and c.CHR_SLOC=a.CHR_STORAGE and a.CHR_FLAG_STOCK = 'F' and a.CHR_PRD_ORDER_NO='$prod_no'");
        //                 if ($datax->num_rows() > 0) {
        //                     $this->db->query("update PRD.TT_ELINA_H set CHR_FLAG='0' where CHR_PRD_ORDER_NO='$prod_no'");
        //                 }
        //             }    
        //         }
        //     }    
        // } else {
        //     $this->db->query("UPDATE A set                                          
        //                                 A.CHR_FLAG_STOCK    = 'F'
        //                         FROM PRD.TT_ELINA_L AS A inner join
        //                         PRD.TT_ELINA_H AS B on A.CHR_PRD_ORDER_NO=B.CHR_PRD_ORDER_NO
        //                         inner join TT_PARTS_SLOC as c on c.CHR_PART_NO=a.CHR_PART_NO
        //                            where B.CHR_FLAG    = 'X' and c.CHR_SLOC=a.CHR_STORAGE and c.INT_PART_QTY>=a.INT_ORDER_PCS");
                                   
        //     $cek_flag = $this->db->query("select distinct b.CHR_PRD_ORDER_NO from PRD.TT_ELINA_L a inner join PRD.TT_ELINA_H b on a.CHR_PRD_ORDER_NO=b.CHR_PRD_ORDER_NO
        //                                 inner join TT_PARTS_SLOC as c on c.CHR_PART_NO=a.CHR_PART_NO 
        //                                 where b.CHR_FLAG='X' and c.CHR_SLOC=a.CHR_STORAGE and a.CHR_FLAG_STOCK = 'F' and c.INT_PART_QTY>=a.INT_ORDER_PCS");
        //     if ($cek_flag->num_rows() > 0) {
        //         $tt_kanban = $cek_flag->result();
        //         foreach ($tt_kanban as $value){
        //             $prod_no = trim($value->CHR_PRD_ORDER_NO);                       
        //             $this->db->query("UPDATE a set                                          
        //                                         CHR_FLAG    = '0'
        //                                 from PRD.TT_ELINA_H as a inner join PRD.TT_ELINA_L as b
        //                                 on a.CHR_PRD_ORDER_NO=b.CHR_PRD_ORDER_NO inner join TT_PARTS_SLOC as c
        //                                 on c.CHR_PART_NO=b.CHR_PART_NO
        //                                 where A.CHR_PRD_ORDER_NO    = '$prod_no'");
        //         }                    
        //     }                       
        // }
    }

    function get_result_explode_setup_chute() {
        return $this->db->query("SELECT A.CHR_PRD_ORDER_NO, A.CHR_SEQ, B.CHR_PART_NO AS PN_FG, B.CHR_BACK_NO AS BN_FG, B.INT_QTY_PCS, A.CHR_WORK_CT, A.CHR_PART_NO AS PN_COMP, A.CHR_PART_NAME, A.CHR_BACK_NO AS BN_COMP, A.INT_QTY_PER_BOX, 
                                A.CHR_PREPARE_AREA, A.CHR_STORAGE, A.INT_ORDER_BOX, A.INT_ORDER_PCS
                                FROM PRD.TW_CHECK_STOCK_SETUP_CHUTE A
                                LEFT JOIN PRD.TT_SETUP_CHUTE B ON A.CHR_PRD_ORDER_NO = B.CHR_PRD_ORDER_NO 
                                ORDER BY A.CHR_WORK_CT, A.CHR_SEQ, B.CHR_PRD_ORDER_NO ASC")->result();
    }

    function check_existing_period($month) {
        $mrp_d = $this->load->database("mrp_d", TRUE);
        return $mrp_d->query("SELECT * FROM TT_OPTIMIZE_CAPACITY WHERE CHR_MONTH = '$month'")->num_rows();
    }

    function update_flag_delete_list_part($month) {
        $mrp_d = $this->load->database("mrp_d", TRUE);
        $mrp_d->query("UPDATE TT_OPTIMIZE_CAPACITY SET INT_FLG_DELETE = '1'  WHERE CHR_MONTH = '$month'");
    }

    function insert_overstock_parts($data_parts) {
		$mrp_d = $this->load->database("mrp_d", TRUE);
		$mrp_d->insert('TT_OPTIMIZE_CAPACITY', $data_parts);
	}
}