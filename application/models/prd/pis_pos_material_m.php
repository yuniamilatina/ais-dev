<?php

class pis_pos_material_m extends CI_Model {

    private $tabel = 'PRD.TT_PIS_POS_MATERIAL';

    public function __construct() {
        parent::__construct();
    }

    function save($data) {
        $this->db->insert($this->tabel, $data);
    }

    function update($data, $id) {
        $this->db->where($id);
        $this->db->update($this->tabel, $data);
    }

    function delete($id) {
        $data = array('INT_FLG_DEL' => 1);

        $this->db->where('INT_ID', $id);
        $this->db->update($this->tabel, $data);
    }

    function get_data_pis_pos_material_by_id($id){
        $sql = "SELECT TOP 1 ISNULL(SUBSTRING(REPLACE(CHR_BACK_NO_SA,'#',','),1, LEN(REPLACE(CHR_BACK_NO_SA,'#',',')) - 1), CHR_BACK_NO_COMP) AS CHR_BACK_NO_COMPONEN, * FROM $this->tabel WHERE INT_ID = '$id'";

        return $this->db->query($sql)->row();
    }

    function get_img_fg_by_prod_order_no($id, $wc, $pos){

        $exist_unfinish = $this->db->query("SELECT COUNT(*) JUMLAH_FINISH FROM $this->tabel 
            WHERE CHR_WORK_CENTER = '$wc' AND CHR_POS_PRD = '$pos' AND INT_FLG_ACTIVE = 1  AND INT_FLG_FINISH = 0");

        if($exist_unfinish->num_rows() > 0){
            if($exist_unfinish->row()->JUMLAH_FINISH > 0){
                return false;
            }else{
                $query = $this->db->query("SELECT TOP 1 CHR_IMG_FG_URL FROM $this->tabel 
                    WHERE CHR_WORK_CENTER = '$wc' AND CHR_POS_PRD = '$pos' AND INT_FLG_ACTIVE = 1 
                    GROUP BY CHR_IMG_FG_URL");
    
                return $query->row();
            }
        }
    }

    function get_data_fg_by_line($pos, $wc){
        $query = $this->db->query("select distinct CHR_PART_NO_FG,CHR_PRD_ORDER_NO from PRD.TT_PIS_POS_MATERIAL where (INT_FLG_ACTIVE = 1) AND (CHR_POS_PRD = '$pos') and CHR_WORK_CENTER='$wc'");
    
        return $query->row();
    }

    function get_data_prod_order_no($pos, $wc){
        $query = $this->db->query("SELECT TOP 1 CHR_IMG_FG_URL FROM $this->tabel 
            WHERE CHR_WORK_CENTER = '$wc' AND CHR_POS_PRD = '$pos' AND INT_FLG_ACTIVE = 1 
            GROUP BY CHR_IMG_FG_URL");
    
        return $query->row();
    }

    function get_registrate_part_comp_in_sub_assy_member($partno, $work_center, $pos, $prd_order_no){

                $query = $this->db->query("SELECT D.CHR_PART_NO_SA FROM PRD.TM_POS_MATERIAL_DETAIL D INNER JOIN PRD.TT_PIS_POS_MATERIAL H 
                    ON H.CHR_PART_NO_COMP = D.CHR_PART_NO_COMP
                WHERE
                H.CHR_PRD_ORDER_NO = '$prd_order_no'
                AND H.CHR_WORK_CENTER = '$work_center'
                AND H.CHR_POS_PRD = '$pos'
                AND D.CHR_PART_NO_SA IN (
                
                    SELECT CHR_PART_NO_SA FROM PRD.TM_POS_MATERIAL_DETAIL 
                    WHERE CHR_PART_NO_COMP = '$partno' AND CHR_POS_PRD = '$pos' AND CHR_WORK_CENTER = '$work_center'
                    AND CHR_PART_NO_FG =  ( SELECT CHR_PART_NO FROM PRD.TT_SETUP_CHUTE WHERE CHR_PRD_ORDER_NO = '$prd_order_no' AND INT_FLG_DEL = 0 )
                    GROUP BY CHR_PART_NO_SA
                
                )
                AND D.CHR_PART_NO_FG = ( SELECT CHR_PART_NO FROM PRD.TT_SETUP_CHUTE WHERE CHR_PRD_ORDER_NO = '$prd_order_no' AND INT_FLG_DEL = 0)
                
                GROUP BY D.CHR_PART_NO_SA");

        return $query;
    }

    function generate_setup_chute_material($prd_order_no, $work_center, $pos, $part_no) {

        $stored_procedure = "EXEC PRD.zsp_generated_pis_pos_material ?,?,?";
        $param = array(
            'work_center' => $work_center,
            'pos' => $pos,
            'prd_order_no' => $prd_order_no);

        $query = $this->db->query($stored_procedure, $param);

        return $query->result();

    }

    function update_actual($partno_comp, $partno_sa, $work_center, $date, $pos, $prd_order_no){
        $datenow = date('Ymd');
        $timenow = date('His');
        $value_return = true; //sudah complete

        if($partno_sa == null || $partno_sa == ''){
            $this->db->query("UPDATE $this->tabel 
                SET INT_BOX_ACTUAL = INT_BOX_ACTUAL + 1, CHR_MODIFIED_BY = 'update_actual', CHR_MODIFIED_DATE = '$datenow', CHR_MODIFIED_TIME = '$timenow' 
                WHERE INT_FLG_DEL = 0
                AND CHR_POS_PRD = '$pos'
                AND CHR_WORK_CENTER = '$work_center'
                AND CHR_PART_NO_COMP = '$partno_comp'
                AND CHR_PRD_ORDER_NO = '$prd_order_no'");

            $completed_data = $this->db->query("SELECT * FROM $this->tabel WHERE INT_FLG_DEL = 0 
                AND CHR_POS_PRD = '$pos'
                AND CHR_WORK_CENTER = '$work_center' AND CHR_PRD_ORDER_NO = '$prd_order_no' 
                AND CHR_PART_NO_COMP = '$partno_comp' AND INT_BOX_PLAN <= INT_BOX_ACTUAL");

            if($completed_data->num_rows() > 0){
                $this->db->query("UPDATE $this->tabel 
                SET INT_FLG_FINISH = 1, CHR_MODIFIED_BY = 'update_actual_finish', CHR_MODIFIED_DATE = '$datenow', CHR_MODIFIED_TIME = '$timenow' 
                WHERE INT_FLG_DEL = 0 
                AND CHR_POS_PRD = '$pos'
                AND CHR_WORK_CENTER = '$work_center'
                AND CHR_PART_NO_COMP = '$partno_comp'
                AND CHR_PRD_ORDER_NO = '$prd_order_no'");
            }

            return $this->db->query("SELECT ISNULL(SUBSTRING(REPLACE(CHR_BACK_NO_SA,'#',','),1, LEN(REPLACE(CHR_BACK_NO_SA,'#',',')) - 1), CHR_BACK_NO_COMP) CHR_BACK_NO_COMP, CHR_IMG_COMP_URL, INT_BOX_PLAN, INT_BOX_ACTUAL
                FROM $this->tabel WHERE INT_FLG_DEL = 0 
                AND CHR_POS_PRD = '$pos'
                AND CHR_WORK_CENTER = '$work_center'
                AND CHR_PART_NO_COMP = '$partno_comp'
                AND CHR_PRD_ORDER_NO = '$prd_order_no'
                GROUP BY CHR_BACK_NO_SA, CHR_BACK_NO_COMP ,CHR_IMG_COMP_URL, INT_BOX_PLAN, INT_BOX_ACTUAL")->row();
        }else{
            $this->db->query("UPDATE $this->tabel 
                SET INT_BOX_ACTUAL = INT_BOX_ACTUAL + 1, CHR_MODIFIED_BY = 'update_actual', CHR_MODIFIED_DATE = '$datenow', CHR_MODIFIED_TIME = '$timenow' 
                WHERE INT_FLG_DEL = 0
                AND CHR_POS_PRD = '$pos'
                AND CHR_WORK_CENTER = '$work_center'
                AND CHR_PART_NO_SA = '$partno_sa'
                AND CHR_PRD_ORDER_NO = '$prd_order_no'");

            $completed_data = $this->db->query("SELECT * FROM $this->tabel WHERE INT_FLG_DEL = 0 
                AND CHR_POS_PRD = '$pos'
                AND CHR_WORK_CENTER = '$work_center' AND CHR_PRD_ORDER_NO = '$prd_order_no' 
                AND CHR_PART_NO_SA = '$partno_sa' AND INT_BOX_PLAN <= INT_BOX_ACTUAL");

            if($completed_data->num_rows() > 0){
                $this->db->query("UPDATE $this->tabel 
                SET INT_FLG_FINISH = 1, CHR_MODIFIED_BY = 'update_actual_finish', CHR_MODIFIED_DATE = '$datenow', CHR_MODIFIED_TIME = '$timenow' 
                WHERE INT_FLG_DEL = 0 
                AND CHR_POS_PRD = '$pos'
                AND CHR_WORK_CENTER = '$work_center'
                AND CHR_PART_NO_SA = '$partno_sa'
                AND CHR_PRD_ORDER_NO = '$prd_order_no'");
            }

            return $this->db->query("SELECT ISNULL(SUBSTRING(REPLACE(CHR_BACK_NO_SA,'#',','),1, LEN(REPLACE(CHR_BACK_NO_SA,'#',',')) - 1), CHR_BACK_NO_COMP) CHR_BACK_NO_COMP, CHR_IMG_COMP_URL, INT_BOX_PLAN, INT_BOX_ACTUAL
                FROM $this->tabel WHERE INT_FLG_DEL = 0 
                AND CHR_POS_PRD = '$pos'
                AND CHR_WORK_CENTER = '$work_center'
                AND CHR_PART_NO_SA = '$partno_sa'
                AND CHR_PRD_ORDER_NO = '$prd_order_no'
                GROUP BY CHR_BACK_NO_SA, CHR_BACK_NO_COMP ,CHR_IMG_COMP_URL, INT_BOX_PLAN, INT_BOX_ACTUAL")->row();
        }
        
    }

    function check_finish_actual_perpart($partno_comp, $partno_sa, $work_center, $date, $pos, $prd_order_no){
        $datenow = date('Ymd');
        $timenow = date('His');
        $value_return = true; //sudah complete

        if($partno_sa == null || $partno_sa == ''){
            $completed_data = $this->db->query("SELECT * FROM $this->tabel WHERE INT_FLG_DEL = 0  
                AND CHR_POS_PRD = '$pos'
                AND CHR_WORK_CENTER = '$work_center' 
                AND CHR_PRD_ORDER_NO = '$prd_order_no' 
                AND CHR_PART_NO_COMP = '$partno_comp' 
                AND INT_FLG_FINISH = 1");
        }else{
            $completed_data = $this->db->query("SELECT * FROM $this->tabel WHERE INT_FLG_DEL = 0  
                AND CHR_POS_PRD = '$pos'
                AND CHR_WORK_CENTER = '$work_center' 
                AND CHR_PRD_ORDER_NO = '$prd_order_no' 
                AND CHR_PART_NO_SA = '$partno_sa' 
                AND INT_FLG_FINISH = 1");
        }
        
        if($completed_data->num_rows() > 0){
            $value_return = false;
        }

        return $value_return;
    }

    function update_reset_dandori($work_center, $pos){
        $datenow = date('Ymd');
        $timenow = date('His');
        
        $data_pis_pos_material = $this->db->query("SELECT CHR_PRD_ORDER_NO, SUM(INT_BOX_ACTUAL) INT_BOX_ACTUAL, SUM(INT_BOX_PLAN) INT_BOX_PLAN
            FROM $this->tabel
            WHERE INT_FLG_FINISH = 0
            AND CHR_POS_PRD = '$pos'
            AND CHR_WORK_CENTER = '$work_center'
            AND INT_BOX_ACTUAL = 0
            GROUP BY CHR_PRD_ORDER_NO, CHR_WORK_CENTER, CHR_POS_PRD, INT_FLG_ACTIVE, INT_FLG_DANDORY");

        if($data_pis_pos_material->num_rows() > 0){
            $prd_order_no = $data_pis_pos_material->row()->CHR_PRD_ORDER_NO;
            if($data_pis_pos_material->row()->INT_BOX_ACTUAL == 0 && $data_pis_pos_material->row()->INT_BOX_PLAN > 0){

                 //comment this, for cannot skip dandori
                // $this->db->query(";WITH CTE_NO_DATA (CHR_PRD_ORDER_NO, INT_FLG_FINISH ) AS ( 
                //     SELECT CHR_PRD_ORDER_NO,  SUM(INT_FLG_FINISH) INT_FLG_FINISH
                //     FROM $this->tabel WHERE CHR_POS_PRD = '$pos' AND CHR_WORK_CENTER = '$work_center' 
                //     GROUP BY CHR_PRD_ORDER_NO 
                // )
                // DELETE $this->tabel WHERE 
                // CHR_POS_PRD = '$pos' AND CHR_WORK_CENTER = '$work_center' 
                // AND CHR_PRD_ORDER_NO IN ( SELECT CHR_PRD_ORDER_NO FROM CTE_NO_DATA WHERE INT_FLG_FINISH = 0)");

                //edited by toros 20190423 --uncomment this, for cannot skip dandori
                $this->db->query(";WITH CTE_NO_DATA (CHR_PRD_ORDER_NO, INT_FLG_FINISH ) AS ( 
                    SELECT CHR_PRD_ORDER_NO, INT_FLG_FINISH
                    FROM $this->tabel WHERE CHR_POS_PRD = '$pos' AND CHR_WORK_CENTER = '$work_center' 
                    AND INT_FLG_FINISH = 0
                )
                DELETE $this->tabel WHERE 
                CHR_POS_PRD = '$pos' AND CHR_WORK_CENTER = '$work_center' 
                AND CHR_PRD_ORDER_NO IN ( SELECT CHR_PRD_ORDER_NO FROM CTE_NO_DATA WHERE INT_FLG_FINISH = 0)");
            }else{
                $this->db->query("UPDATE $this->tabel 
                SET INT_FLG_ACTIVE = 0, INT_FLG_DANDORY = 0, 
                CHR_MODIFIED_BY = 'reset_dandori', CHR_MODIFIED_DATE = '$datenow', CHR_MODIFIED_TIME = '$timenow' 
                WHERE INT_FLG_DEL = 0 
                AND CHR_POS_PRD = '$pos'
                AND CHR_WORK_CENTER = '$work_center'");
            }
        }
    }

    //Error Code 1
    function get_data_ready_dandori($work_center, $date, $pos, $prd_order_no){
        $datenow = date('Ymd');
        $timenow = date('His');

        $this->db->query("UPDATE $this->tabel 
            SET INT_FLG_ACTIVE = 0,INT_FLG_DANDORY = 0, CHR_MODIFIED_BY = 'direct_dandori', CHR_MODIFIED_DATE = '$datenow', CHR_MODIFIED_TIME = '$timenow' 
            WHERE INT_FLG_DEL = 0 
            AND CHR_POS_PRD = '$pos'
            AND CHR_WORK_CENTER = '$work_center'
            AND CHR_PRD_ORDER_NO <> '$prd_order_no'");

        $this->db->query("UPDATE $this->tabel 
            SET INT_FLG_ACTIVE = 1,INT_FLG_DANDORY = 1, CHR_MODIFIED_BY = 'direct_dandori', CHR_MODIFIED_DATE = '$datenow', CHR_MODIFIED_TIME = '$timenow' 
            WHERE INT_FLG_DEL = 0 
            AND CHR_POS_PRD = '$pos'
            AND CHR_WORK_CENTER = '$work_center'
            AND CHR_PRD_ORDER_NO = '$prd_order_no'");

        $sql = "SELECT INT_ID, CHR_PRD_ORDER_NO, CHR_IMG_COMP_URL, CHR_BACK_NO_SA, CHR_PART_NO_SA, CHR_BACK_NO_COMP, CHR_PART_NO_FG, CHR_BACK_NO_FG, INT_BOX_PLAN, INT_BOX_ACTUAL, INT_FLG_FINISH FROM $this->tabel 
            WHERE INT_FLG_DEL = 0 
            AND CHR_POS_PRD = '$pos' AND CHR_WORK_CENTER = '$work_center' AND CHR_PRD_ORDER_NO = '$prd_order_no'
            GROUP BY  INT_ID, CHR_PRD_ORDER_NO, CHR_IMG_COMP_URL, CHR_BACK_NO_SA, CHR_PART_NO_SA, CHR_BACK_NO_COMP, INT_BOX_PLAN, INT_BOX_ACTUAL, INT_FLG_FINISH, CHR_PART_NO_FG, CHR_BACK_NO_FG
            ORDER BY CHR_BACK_NO_COMP ASC";

        return $this->db->query($sql);
    }

    function get_total_component_by_pos($pos, $prd_order_no){

        $sql = "SELECT * FROM $this->tabel WHERE INT_FLG_DEL = 0 AND CHR_POS_PRD = '$pos' AND CHR_PRD_ORDER_NO = '$prd_order_no'";

        return $this->db->query($sql)->num_rows();
    }

    function get_total_finish_component_by_pos($pos, $prd_order_no){

        $sql = "SELECT * FROM $this->tabel WHERE INT_FLG_FINISH = 1 AND INT_FLG_DEL = 0 AND CHR_POS_PRD = '$pos' AND CHR_PRD_ORDER_NO = '$prd_order_no'";

        return $this->db->query($sql)->num_rows();
    }

    function check_finished_dandori($work_center, $date, $pos, $prd_order_no){
        $query =  $this->db->query("SELECT PIS.INT_FLG_FINISH, POS.CHR_IMG_FILE_NAME  FROM $this->tabel PIS 
        INNER JOIN PRD.TM_POS POS 
        ON PIS.CHR_WORK_CENTER = POS.CHR_WORK_CENTER AND PIS.CHR_PART_NO_FG = POS.CHR_PART_NO AND PIS.CHR_POS_PRD = POS.CHR_POS_PRD
            WHERE PIS.INT_FLG_DEL = 0 AND POS.INT_FLG_DEL = 0 
            AND PIS.CHR_CREATED_DATE = '$date'
            AND PIS.CHR_POS_PRD = '$pos'
            AND PIS.CHR_PRD_ORDER_NO = '$prd_order_no'
            AND PIS.CHR_WORK_CENTER = '$work_center'
            AND PIS.INT_FLG_FINISH = 0
            GROUP BY PIS.INT_FLG_FINISH, POS.CHR_IMG_FILE_NAME");

        if($query->num_rows > 0){
            return false;
        }else{
            return true;
        }
    }

    function get_data_finished_dandori($work_center, $date, $pos, $prd_order_no){
        $query =  $this->db->query("SELECT INT_FLG_FINISH, CHR_IMG_FG_URL FROM $this->tabel
            WHERE INT_FLG_DEL = 0
            --AND CHR_DATE = '$date'
            AND CHR_POS_PRD = '$pos'
            AND CHR_PRD_ORDER_NO = '$prd_order_no'
            AND CHR_WORK_CENTER = '$work_center'
            -- AND INT_FLG_FINISH = 1
            GROUP BY INT_FLG_FINISH, CHR_IMG_FG_URL");

        if($query->num_rows() == 1){
            if($query->row()->INT_FLG_FINISH == 1){
                return $query->row();
            }
        }else{
            return false;
        }
    }

    function get_history_blockage_chute($work_center, $date, $pos){
        return $this->db->query("SELECT 
         '<button onclick=direct_dandori('+''''+ CHR_PRD_ORDER_NO +''''+'); class=button-prod value=' + CHR_BACK_NO_FG + '><span style=font-weight:600;color:white;>'+ CHR_BACK_NO_FG + '</span><br><span style=font-size:6pt;color:white;>  '  +  CHR_PRD_ORDER_NO  + ' </span></button>' CHR_BACK_NO
            FROM $this->tabel 
            WHERE INT_FLG_FINISH = 0
                AND INT_FLG_DEL = 0
                AND CHR_POS_PRD = '$pos'
                AND CHR_WORK_CENTER = '$work_center'
            GROUP BY INT_FLG_FINISH, CHR_PRD_ORDER_NO, CHR_BACK_NO_FG 
            ORDER BY CHR_PRD_ORDER_NO ASC");
    }

    function get_status_scan_komponen($prd_order_no, $pos){
        $sql = "SELECT CHR_PRD_ORDER_NO, INT_FLG_FINISH FROM PRD.TT_PIS_POS_MATERIAL 
            WHERE INT_FLG_DEL = 0 AND CHR_POS_PRD = '$pos' AND CHR_PRD_ORDER_NO = '$prd_order_no' AND INT_FLG_FINISH = 0
            GROUP BY CHR_PRD_ORDER_NO,INT_FLG_FINISH";

        return $this->db->query($sql);
    }

    function get_setup_chute_komponen($work_center, $pos){
        $stored_procedure = "EXEC PRD.zsp_get_setup_chute_component_non_node ?,?";
        $param = array(
                'work_center' => $work_center,
                'pos' => $pos
            );

        $query = $this->db->query($stored_procedure, $param);

        return $query;
    }

    function get_image_component_by_part_no_comp_and_pos($part_no, $back_no_comp, $work_center, $pos){
        $sql = "SELECT CHR_IMAGE_PIS_URL FROM PRD.TM_POS_MATERIAL WHERE 
            CHR_BACK_NO_COMP = '$back_no_comp' AND CHR_POS_PRD = '$pos' AND CHR_WORK_CENTER = '$work_center' 
            AND CHR_PART_NO_FG = '$part_no' GROUP BY CHR_IMAGE_PIS_URL";

        return $this->db->query($sql);
    }

    function check_existing_elina_by_wo($prd_order_no){
        $query =  $this->db->query("SELECT * FROM PRD.TT_ELINA_L WHERE CHR_PRD_ORDER_NO = '$prd_order_no'");

        return $query;
    }

    //20190507 sotor
    function get_detail_pos_material_data_recap($work_center, $pos, $prd_order_no){

        $sql = "SELECT INT_ID, CHR_PRD_ORDER_NO, CHR_IMG_COMP_URL, CHR_BACK_NO_SA, CHR_PART_NO_SA, CHR_BACK_NO_COMP, CHR_PART_NO_FG, CHR_BACK_NO_FG, INT_BOX_PLAN, INT_BOX_ACTUAL, INT_FLG_FINISH FROM $this->tabel 
            WHERE INT_FLG_DEL = 0 
            AND CHR_POS_PRD = '$pos' AND CHR_WORK_CENTER = '$work_center' AND CHR_PRD_ORDER_NO = '$prd_order_no'
            GROUP BY  INT_ID, CHR_PRD_ORDER_NO, CHR_IMG_COMP_URL, CHR_BACK_NO_SA, CHR_PART_NO_SA, CHR_BACK_NO_COMP, INT_BOX_PLAN, INT_BOX_ACTUAL, INT_FLG_FINISH, CHR_PART_NO_FG, CHR_BACK_NO_FG
            ORDER BY CHR_BACK_NO_COMP ASC";

        return $this->db->query($sql);
    }

    function get_list_material_by_part_no_comp($partno, $partno_sa, $work_center, $pos, $prd_order_no){

        $query = $this->db->query("SELECT * FROM PRD.TT_ELINA_L L INNER JOIN PRD.TT_PIS_POS_MATERIAL PPM 
            ON L.CHR_PRD_ORDER_NO = PPM.CHR_PRD_ORDER_NO AND L.CHR_PART_NO = PPM.CHR_PART_NO_COMP
            WHERE PPM.CHR_PRD_ORDER_NO = '$prd_order_no' AND L.CHR_PART_NO = '$partno' 
            AND PPM.CHR_POS_PRD = '$pos' AND PPM.CHR_WORK_CENTER = '$work_center'");

        if($query->num_rows() > 0){
            return $query;
        }else{
            return $query = $this->db->query("SELECT * FROM PRD.TM_POS_MATERIAL_DETAIL WHERE CHR_PART_NO_SA = (
                SELECT CHR_PART_NO_SA FROM PRD.TM_POS_MATERIAL_DETAIL 
                WHERE CHR_PART_NO_COMP = '$partno'  AND CHR_POS_PRD = '$pos' AND CHR_WORK_CENTER = '$work_center')
                AND CHR_PART_NO_FG = ( 
                SELECT CHR_PART_NO FROM PRD.TT_SETUP_CHUTE WHERE CHR_PRD_ORDER_NO = '$prd_order_no' AND INT_FLG_DEL = 0)");
        }

    }

    function get_data_pos_material_by_pos_material($work_center, $partno_comp, $partno_sa, $prd_order_no, $pos){

        if($partno_sa == null || $partno_sa == ''){
            $query = $this->db->query("SELECT TOP 1 * FROM PRD.TM_POS_MATERIAL WHERE INT_FLG_DEL = 0 AND CHR_WORK_CENTER = '$work_center' 
                AND CHR_PART_NO_COMP = '$partno_comp' AND CHR_POS_PRD = '$pos' 
                AND CHR_PART_NO_FG IN (SELECT CHR_PART_NO FROM PRD.TT_SETUP_CHUTE WHERE CHR_PRD_ORDER_NO = '$prd_order_no' AND INT_FLG_DEL = 0)");
        }else{
            $query = $this->db->query("SELECT TOP 1 * FROM PRD.TM_POS_MATERIAL WHERE INT_FLG_DEL = 0 AND CHR_WORK_CENTER = '$work_center' 
                AND CHR_PART_NO_SA = '$partno_sa' AND CHR_POS_PRD = '$pos' 
                AND CHR_PART_NO_FG IN (SELECT CHR_PART_NO FROM PRD.TT_SETUP_CHUTE WHERE CHR_PRD_ORDER_NO = '$prd_order_no' AND INT_FLG_DEL = 0)");
        }

        return $query;
    }

    
    function get_first_order_no($data){

        $wc = $data['CHR_WORK_CENTER']; 
        $pos = $data['CHR_POS_PRD']; 
        
        return $this->db->query(";WITH CTE_POS_MATERIAL (CHR_WORK_CENTER, CHR_POS_PRD, CHR_PART_NO) AS (
            SELECT CHR_WORK_CENTER, CHR_POS_PRD, CHR_PART_NO_FG FROM PRD.TM_POS_MATERIAL
            WHERE INT_FLG_DEL = 0 AND CHR_POS_PRD = '$pos' AND CHR_WORK_CENTER = '$wc'
            GROUP BY CHR_WORK_CENTER, CHR_POS_PRD, CHR_PART_NO_FG
        )
        
        SELECT TOP 1 SC.CHR_PRD_ORDER_NO
            FROM PRD.TT_SETUP_CHUTE SC 
            INNER JOIN CTE_POS_MATERIAL PM ON PM.CHR_PART_NO = SC.CHR_PART_NO AND PM.CHR_POS_PRD = '$pos' 
            WHERE 
            INT_FLG_DEL = 0 
            AND SC.INT_SEQUENCE <> 0
            AND SC.CHR_WORK_CENTER = '$wc' 
            AND INT_FLG_PRD <> 2  

        AND SC.CHR_PRD_ORDER_NO NOT IN 
        (SELECT CHR_PRD_ORDER_NO FROM PRD.TT_PIS_POS_MATERIAL WHERE CHR_WORK_CENTER = '$wc'
        AND CHR_POS_PRD = '$pos' GROUP BY CHR_PRD_ORDER_NO)
        ORDER BY CONVERT(INT, INT_SEQUENCE)
        ");
    }

    function get_history_setup_chute($work_center, $pos){
        $date = date('Ymd');

        return $this->db->query("SELECT 
         '<button class=button-prod><span style=font-weight:600;color:white;>'+ CHR_BACK_NO_FG + '</span><br><span style=font-size:8pt;color:white;>  '  +  '...' + SUBSTRING(CHR_PRD_ORDER_NO,7,13)  + ' </span></button>' CHR_BACK_NO
            FROM $this->tabel 
            WHERE INT_FLG_FINISH = 1
                AND INT_FLG_DEL = 0
                AND CHR_POS_PRD = '$pos'
                AND CHR_WORK_CENTER = '$work_center'
                AND CHR_CREATED_DATE = '$date'
            GROUP BY INT_FLG_FINISH, CHR_PRD_ORDER_NO, CHR_BACK_NO_FG, CHR_CREATED_DATE
            ORDER BY CHR_CREATED_DATE DESC");
    }

    function get_data_uncomplete_pos_material(){
        return $this->db->query("SELECT CHR_WORK_CENTER, CHR_POS_PRD, CHR_PRD_ORDER_NO, CHR_PART_NO_FG, CHR_BACK_NO_FG, CASE INT_FLG_ACTIVE WHEN 1 THEN 'On' ELSE 'Off' END AS FLG_ACTIVE FROM $this->tabel 
        WHERE INT_FLG_FINISH = 0 
        GROUP BY CHR_WORK_CENTER, CHR_POS_PRD, CHR_PRD_ORDER_NO, CHR_PART_NO_FG, CHR_BACK_NO_FG, INT_FLG_ACTIVE")->result();
    }

    function update_log_pos_material($work_center, $pos){
        $this->db->query("UPDATE $this->tabel SET CHR_NOTES = 'Manual',INT_BOX_ACTUAL = INT_BOX_PLAN, INT_FLG_FINISH = 1 WHERE INT_FLG_FINISH = 0 AND CHR_WORK_CENTER = '$work_center' AND CHR_POS_PRD = $pos");
    }
}
