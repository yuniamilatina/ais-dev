<?php

class part_m extends CI_Model
{

    private $tabel = 'TM_KANBAN';
    private $tabel_parts = 'TM_PARTS';
    private $tabel_parts_tw = 'PRD.TW_PARTS_BOM';
    //20181107, Wildan denny ,  ambil data pos prod jika sebelumnya sudah pernah di setting
    private $tabel_pos_material = 'PRD.TM_POS_MATERIAL';

    public function __construct()
    {
        parent::__construct();
    }

    public function save_label_part($data){
        $this->db->insert('PRD.TM_INES_METHODS', $data);
    }

    public function delete_label_part($id){
        $this->db->where($id);
        $this->db->delete('PRD.TM_INES_METHODS');
    }
    
    // public function get_part_label(){
    //     return $this->db->query("SELECT SP.CHR_PART_NO, SP.CHR_CUS_PART_NO, LP.INT_FLG_METHODS FROM PRD.TM_INES_METHODS LP 
    //     INNER JOIN TM_SHIPPING_PARTS SP ON LP.CHR_PART_NO = SP.CHR_PART_NO
    //     GROUP BY SP.CHR_PART_NO, SP.CHR_CUS_PART_NO, LP.INT_FLG_METHODS ")->result();
    // }

    public function check_partno($part_no){
        $this->db->where('CHR_PART_NO', $part_no);
        $find_part = $this->db->get('PRD.TM_INES_METHODS');
        return $find_part->num_rows();
    }

    // function get_data_by_part_no($part_no){
    //     $query = $this->db->query("SELECT * FROM PRD.TM_INES_METHODS WHERE CHR_PART_NO = '$part_no'");

    //     if($query->num_rows() > 0){
    //         return 1;
    //     }else{
    //         return 0;
    //     }
    // }

    // function compare_part_no_with_part_cust_no($part_no, $cust_partno){
        
    //     $query = $this->db->query("SELECT SP.CHR_PART_NO, SP.CHR_CUS_PART_NO FROM PRD.TM_INES_METHODS LP 
    //     INNER JOIN TM_SHIPPING_PARTS SP ON LP.CHR_PART_NO = SP.CHR_PART_NO
    //     WHERE SP.CHR_PART_NO = '$part_no' AND SP.CHR_CUS_PART_NO = '$cust_partno'
    //     GROUP BY SP.CHR_PART_NO, SP.CHR_CUS_PART_NO");

    //     if($query->num_rows() > 0){
    //         return 1;
    //     }else{
    //         return 0;
    //     }
    // }

    public function save($data)
    {
        $this->db->insert($this->tabel_parts_tw, $data);
    }

    public function delete_by_ip($ip)
    {
        $session = $this->session->all_userdata();
        $user = $session['NPK'];
        $query = $this->db->query("DELETE $this->tabel_parts_tw WHERE CHR_IP = '$ip' AND CHR_CREATED_BY = '$user'");
    }

    public function get_data_part_mate()
    {
        return $this->db->query("SELECT * FROM $this->tabel WHERE CHR_SLOC_FROM = 'WP01'")->result();
    }

    public function get_data_part()
    {
        return $this->db->query("SELECT * FROM $this->tabel WHERE CHR_SLOC_FROM = 'WP01'")->result();
    }

    public function get_data_part_by_work_center($work_center)
    {
        return $this->db->query("SELECT P.CHR_PART_NO FROM $this->tabel_parts P INNER JOIN TM_PROCESS_PARTS PP
        ON P.CHR_PART_NO = PP.CHR_PART_NO AND PP.CHR_WORK_CENTER = '$work_center'
        GROUP BY P.CHR_PART_NO")->result();
    }

    public function get_top_part_by_work_center($work_center)
    {
        $query = $this->db->query("SELECT TOP 1 * FROM $this->tabel_parts P INNER JOIN TM_PROCESS_PARTS PP
        ON P.CHR_PART_NO = PP.CHR_PART_NO AND PP.CHR_WORK_CENTER = '$work_center'");

        return $query->row()->CHR_PART_NO;
    }

    public function get_data_part_kanban_by_work_center($work_center)
    {
        $query = $this->db->query("SELECT TOP 1000 RTRIM(P.CHR_PART_NO) CHR_PART_NO, RTRIM(K.CHR_BACK_NO) CHR_BACK_NO, ISNULL(P.INT_LOT_SIZE,0) INT_LOT_SIZE,
                    RTRIM(K.INT_QTY_PER_BOX) INT_QTY_PER_BOX, RTRIM(K.CHR_KANBAN_TYPE) CHR_KANBAN_TYPE
                    FROM TM_PARTS P
                    INNER JOIN TM_PROCESS_PARTS PP ON PP.CHR_PART_NO = P.CHR_PART_NO
                    INNER JOIN TM_KANBAN K ON K.CHR_PART_NO = P.CHR_PART_NO
                WHERE K.CHR_KANBAN_TYPE  = 5 AND PP.CHR_WORK_CENTER = '$work_center'
                GROUP BY P.CHR_PART_NO, P.INT_LOT_SIZE,
                    K.INT_QTY_PER_BOX, K.CHR_KANBAN_TYPE, K.CHR_BACK_NO
                ORDER BY P.CHR_PART_NO")->result();

        return $query;
    }

    public function get_data_part_kanban_by_work_center_for_lot_size($work_center)
    {
        if(substr($work_center,0,2) == 'AS'){
            $query = $this->db->query("SELECT TOP 1000 RTRIM(P.CHR_PART_NO) CHR_PART_NO, RTRIM(K.CHR_BACK_NO) CHR_BACK_NO, ISNULL(P.INT_LOT_SIZE,0) INT_LOT_SIZE,
                    RTRIM(K.INT_QTY_PER_BOX) INT_QTY_PER_BOX, RTRIM(K.CHR_KANBAN_TYPE) CHR_KANBAN_TYPE
                    FROM TM_PARTS P
                    INNER JOIN TM_PROCESS_PARTS PP ON PP.CHR_PART_NO = P.CHR_PART_NO
                    INNER JOIN TM_KANBAN K ON K.CHR_PART_NO = P.CHR_PART_NO
                WHERE K.CHR_KANBAN_TYPE  = '5' AND PP.CHR_WORK_CENTER = '$work_center'
                GROUP BY P.CHR_PART_NO, P.INT_LOT_SIZE,
                    K.INT_QTY_PER_BOX, K.CHR_KANBAN_TYPE, K.CHR_BACK_NO
                ORDER BY P.CHR_PART_NO")->result();
        } else {
            $query = $this->db->query("SELECT TOP 1000 RTRIM(P.CHR_PART_NO) CHR_PART_NO, RTRIM(K.CHR_BACK_NO) CHR_BACK_NO, ISNULL(P.INT_LOT_SIZE,0) INT_LOT_SIZE,
                    RTRIM(K.INT_QTY_PER_BOX) INT_QTY_PER_BOX, RTRIM(K.CHR_KANBAN_TYPE) CHR_KANBAN_TYPE
                    FROM TM_PARTS P
                    INNER JOIN TM_PROCESS_PARTS PP ON PP.CHR_PART_NO = P.CHR_PART_NO
                    INNER JOIN TM_KANBAN K ON K.CHR_PART_NO = P.CHR_PART_NO
                WHERE K.CHR_KANBAN_TYPE = '1' AND PP.CHR_WORK_CENTER = '$work_center'
                GROUP BY P.CHR_PART_NO, P.INT_LOT_SIZE,
                    K.INT_QTY_PER_BOX, K.CHR_KANBAN_TYPE, K.CHR_BACK_NO
                ORDER BY P.CHR_PART_NO")->result();
        }        

        return $query;
    }

    public function get_detail_part_no($parno)
    {
        $query = $this->db->query("SELECT *
                    FROM TM_PARTS
                    WHERE CHR_PART_NO = '$parno'")->result();

        return $query;
    }

    public function get_part_no_by_backno($back_no){
        $query = $this->db->query("SELECT TOP 1 *
        FROM TM_KANBAN
        WHERE CHR_BACK_NO = '$back_no'");

        if($query->num_rows() > 0){
            return $query->row()->CHR_PART_NO;
        }else{
            return '';
        }

        return $query;
    }

    public function update($data, $id)
    {
        $this->db->where($id);
        $this->db->update($this->tabel_parts, $data);
    }

    public function check_existing_part_no($part_no)
    {
        $query = $this->db->query("SELECT TOP 1 * FROM TM_PARTS  WHERE CHR_PART_NO = '$part_no'");

        return $query->result();
    }

    public function check_routing_part_no($work_center, $part_no)
    {
        $query = $this->db->query("SELECT RTRIM(P.CHR_PART_NO) CHR_PART_NO, RTRIM(K.CHR_BACK_NO) CHR_BACK_NO, ISNULL(P.INT_LOT_SIZE,0) INT_LOT_SIZE,
                    RTRIM(K.INT_QTY_PER_BOX) INT_QTY_PER_BOX, RTRIM(K.CHR_KANBAN_TYPE) CHR_KANBAN_TYPE
                    FROM TM_PARTS P
                    INNER JOIN TM_PROCESS_PARTS PP ON PP.CHR_PART_NO = P.CHR_PART_NO
                    INNER JOIN TM_KANBAN K ON K.CHR_PART_NO = P.CHR_PART_NO
                WHERE PP.CHR_WORK_CENTER = '$work_center' AND P.CHR_PART_NO = '$part_no'
                GROUP BY P.CHR_PART_NO, P.INT_LOT_SIZE,
                    K.INT_QTY_PER_BOX, K.CHR_KANBAN_TYPE, K.CHR_BACK_NO
                ORDER BY P.CHR_PART_NO")->result();

        return $query;
    }

    public function check_exist_kanban_part_no($work_center, $part_no)
    {
        $query = $this->db->query("SELECT RTRIM(P.CHR_PART_NO) CHR_PART_NO, RTRIM(K.CHR_BACK_NO) CHR_BACK_NO, ISNULL(P.INT_LOT_SIZE,0) INT_LOT_SIZE,
                    RTRIM(K.INT_QTY_PER_BOX) INT_QTY_PER_BOX, RTRIM(K.CHR_KANBAN_TYPE) CHR_KANBAN_TYPE
                    FROM TM_PARTS P
                    INNER JOIN TM_PROCESS_PARTS PP ON PP.CHR_PART_NO = P.CHR_PART_NO
                    INNER JOIN TM_KANBAN K ON K.CHR_PART_NO = P.CHR_PART_NO
                WHERE K.CHR_KANBAN_TYPE  = 5 AND PP.CHR_WORK_CENTER = '$work_center' AND P.CHR_PART_NO = '$part_no'
                GROUP BY P.CHR_PART_NO, P.INT_LOT_SIZE,
                    K.INT_QTY_PER_BOX, K.CHR_KANBAN_TYPE, K.CHR_BACK_NO
                ORDER BY P.CHR_PART_NO")->result();

        return $query;
    }

    public function check_exist_kanban_part_no_for_schedule_kanban($work_center, $part_no)
    {
        $query = $this->db->query("SELECT RTRIM(P.CHR_PART_NO) CHR_PART_NO, RTRIM(K.CHR_BACK_NO) CHR_BACK_NO, ISNULL(P.INT_LOT_SIZE,0) INT_LOT_SIZE,
                    RTRIM(K.INT_QTY_PER_BOX) INT_QTY_PER_BOX, RTRIM(K.CHR_KANBAN_TYPE) CHR_KANBAN_TYPE
                    FROM TM_PARTS P
                    INNER JOIN TM_PROCESS_PARTS PP ON PP.CHR_PART_NO = P.CHR_PART_NO
                    INNER JOIN TM_KANBAN K ON K.CHR_PART_NO = P.CHR_PART_NO
                WHERE K.CHR_KANBAN_TYPE  IN ('1','5','6') AND PP.CHR_WORK_CENTER = '$work_center' AND P.CHR_PART_NO = '$part_no'
                GROUP BY P.CHR_PART_NO, P.INT_LOT_SIZE,
                    K.INT_QTY_PER_BOX, K.CHR_KANBAN_TYPE, K.CHR_BACK_NO
                ORDER BY P.CHR_PART_NO")->result();

        return $query;
    }

    public function get_data_detail_part($part_no)
    {
        $query = $this->db->query("SELECT TOP 1 * FROM TM_PARTS WHERE CHR_PART_NO = '$part_no'")->row();

        return $query;
    }

    public function get_data_part_component_by_part($matnr, $werks, $emeng, $capid)
    {
        // ZFM_RCS12001
        $this->sapconn->new_function('ZFM_RCS12001');
        $this->sapconn->import('PA_MATNR', $matnr); //part number
        $this->sapconn->import('PA_WERKS', $werks); //plant
        $this->sapconn->import('PA_EMENG', $emeng); //qty required
        $this->sapconn->import('PA_CAPID', $capid); //BOM application
        $this->sapconn->call();
        $data['detail'] = $this->sapconn->fetch('GI_OUTPUT');

        $_header = $this->sapconn->fetch('GI_HEADER');

        $data['header'] = array();
        if (count($_header) > 0) {
            foreach ($_header as $_k => &$_d) {
                $data['header'][trim($_d['KEY'])] = $_d['INFO'];
            }
        }
        unset($_data);
        return $data;
    }

    public function get_OUM_by_part($partno)
    {
        $sql = "SELECT CHR_PART_UOM FROM TM_PARTS WHERE CHR_PART_NO='$partno' GROUP BY CHR_PART_UOM";
        return $this->db->query($sql);
    }

    public function check_process_part_no($work_center, $part_no)
    {
        $query = $this->db->query("SELECT 1  FROM TM_PROCESS_PARTS WHERE CHR_WORK_CENTER = '$work_center' AND CHR_PART_NO = '$part_no'")->result();

        return $query;
    }

    //20181107, Wildan denny ,  ambil data pos prod jika sebelumnya sudah pernah di setting
    public function check_pos_material($part_no_fg, $part_no_comp, $work_center)
    {
        $query = $this->db->query("SELECT CHR_POS_PRD, INT_FLG_IGNORE_SCAN FROM $this->tabel_pos_material
         WHERE CHR_WORK_CENTER = '$work_center' AND CHR_PART_NO_FG = '$part_no_fg' AND CHR_PART_NO_COMP = '$part_no_comp'")->row();
        return $query;
    }

    public function check_pos_material_non_sa($part_no_fg, $part_no_comp, $work_center)
    {
        $query = $this->db->query("SELECT CHR_POS_PRD, INT_FLG_IGNORE_SCAN FROM $this->tabel_pos_material
         WHERE CHR_WORK_CENTER = '$work_center' AND CHR_PART_NO_FG = '$part_no_fg' AND CHR_PART_NO_COMP = '$part_no_comp' AND CHR_PART_NO_SA IS NULL")->row();
        return $query;
    }

    public function get_part_sa($work_center, $part_no)
    {
        $query = $this->db->query("SELECT B.INT_FLG_IGNORE_SCAN, A.CHR_PART_NO_COMP,  A.CHR_BACK_NO_COMP,  A.CHR_PART_NO_SA,   A.CHR_BACK_NO_SA,  A.CHR_POS_PRD, B.CHR_DESC_SA , B.CHR_IMAGE_PIS_URL
                    FROM PRD.TM_POS_MATERIAL_DETAIL  AS A
                    INNER JOIN PRD.TM_POS_MATERIAL AS B ON
                    A.CHR_PART_NO_SA = B.CHR_PART_NO_SA AND A.CHR_POS_PRD = B.CHR_POS_PRD AND A.CHR_WORK_CENTER = B.CHR_WORK_CENTER
                    WHERE B.CHR_WORK_CENTER = '$work_center' AND B.CHR_PART_NO_FG = '$part_no'  
                    AND B.CHR_PART_NO_FG = A.CHR_PART_NO_FG
                    ORDER by A.CHR_PART_NO_SA ASC ")->result();
        return $query;
    }

    public function get_part_sa_tw($work_center, $part_no)
    {
        $ip = gethostbyaddr($_SERVER['REMOTE_ADDR']);
        $session = $this->session->all_userdata();
        $user = $session['NPK'];
        $query = $this->db->query("SELECT * FROM PRD.TW_PARTS_BOM
        WHERE CHR_WORK_CENTER = '$work_center' and  CHR_PART_NO = '$part_no' and CHR_PART_NO_SA <> '' and CHR_IP = '$ip'")->result();
        return $query;
    }

    public function get_data_existing_bom($part_no_comp)
    {
        $session = $this->session->all_userdata();
        $user = $session['NPK'];
        $ip = gethostbyaddr($_SERVER['REMOTE_ADDR']);
        $query = $this->db->query("select CHR_PART_NAME , CHR_LEVEL , INT_QTY , CHR_FLG_PHANTOM from PRD.TW_PARTS_BOM where CHR_IP = '$ip' and  "
            . "CHR_PART_NO_COMP = '$part_no_comp'")->row();
        return $query;
    }

    public function get_data_bom_sa_by_ip($ip)
    {
        $session = $this->session->all_userdata();
        $user = $session['NPK'];
        return $this->db->query("SELECT * FROM $this->tabel_parts_tw WHERE CHR_IP = '$ip' AND CHR_CREATED_BY = '$user' AND CHR_PART_NO_SA IS NOT NULL order by CHR_PART_NO_SA , INT_QTY asc")->result();
    }

    public function delete_material_sa($part_no_fg, $work_center, $part_no_sa)
    {
        $this->db->query("delete from $this->tabel_parts_tw where CHR_PART_NO = '$part_no_fg' and CHR_WORK_CENTER = '$work_center' and CHR_PART_NO_SA = '$part_no_sa'");
    }

    public function get_data_bom_by_ip($ip)
    {
        $session = $this->session->all_userdata();
        $npk = $session['NPK'];
        return $this->db->query("SELECT * FROM $this->tabel_parts_tw WHERE CHR_IP = '$ip' and CHR_PART_NO_SA IS NULL AND CHR_CREATED_BY = '$npk'")->result();
    }

    public function get_data_part_kanban_by_work_center_and_part_no($work_center, $part_no)
    {
        $query = $this->db->query("SELECT RTRIM(P.CHR_PART_NO) CHR_PART_NO, RTRIM(K.CHR_BACK_NO) CHR_BACK_NO, ISNULL(P.INT_LOT_SIZE,0) INT_LOT_SIZE,
                    RTRIM(K.INT_QTY_PER_BOX) INT_QTY_PER_BOX, RTRIM(K.CHR_KANBAN_TYPE) CHR_KANBAN_TYPE
                    FROM TM_PARTS P
                    INNER JOIN TM_PROCESS_PARTS PP ON PP.CHR_PART_NO = P.CHR_PART_NO
                    INNER JOIN TM_KANBAN K ON K.CHR_PART_NO = P.CHR_PART_NO
                WHERE K.CHR_KANBAN_TYPE = 5 AND PP.CHR_WORK_CENTER = '$work_center' AND P.CHR_PART_NO = '$part_no'
                GROUP BY P.CHR_PART_NO, P.INT_LOT_SIZE,
                    K.INT_QTY_PER_BOX, K.CHR_KANBAN_TYPE, K.CHR_BACK_NO
                ORDER BY P.CHR_PART_NO")->result();

        return $query;
    }

    public function get_data_part_kanban_by_work_center_and_part_no_for_lot_size($work_center, $part_no)
    {
        if(substr($work_center,0,2) == 'AS'){ //Assy line
            $query = $this->db->query("SELECT RTRIM(P.CHR_PART_NO) CHR_PART_NO, RTRIM(K.CHR_BACK_NO) CHR_BACK_NO, ISNULL(P.INT_LOT_SIZE,0) INT_LOT_SIZE,
                        RTRIM(K.INT_QTY_PER_BOX) INT_QTY_PER_BOX, RTRIM(K.CHR_KANBAN_TYPE) CHR_KANBAN_TYPE
                        FROM TM_PARTS P
                        INNER JOIN TM_PROCESS_PARTS PP ON PP.CHR_PART_NO = P.CHR_PART_NO
                        INNER JOIN TM_KANBAN K ON K.CHR_PART_NO = P.CHR_PART_NO
                    WHERE K.CHR_KANBAN_TYPE = 5 AND PP.CHR_WORK_CENTER = '$work_center' AND P.CHR_PART_NO = '$part_no'
                    GROUP BY P.CHR_PART_NO, P.INT_LOT_SIZE,
                        K.INT_QTY_PER_BOX, K.CHR_KANBAN_TYPE, K.CHR_BACK_NO
                    ORDER BY P.CHR_PART_NO ASC, K.CHR_KANBAN_TYPE DESC")->result();
        } else {
            $query = $this->db->query("SELECT RTRIM(P.CHR_PART_NO) CHR_PART_NO, RTRIM(K.CHR_BACK_NO) CHR_BACK_NO, ISNULL(P.INT_LOT_SIZE,0) INT_LOT_SIZE,
                        RTRIM(K.INT_QTY_PER_BOX) INT_QTY_PER_BOX, RTRIM(K.CHR_KANBAN_TYPE) CHR_KANBAN_TYPE
                        FROM TM_PARTS P
                        INNER JOIN TM_PROCESS_PARTS PP ON PP.CHR_PART_NO = P.CHR_PART_NO
                        INNER JOIN TM_KANBAN K ON K.CHR_PART_NO = P.CHR_PART_NO
                    WHERE K.CHR_KANBAN_TYPE = 1 AND PP.CHR_WORK_CENTER = '$work_center' AND P.CHR_PART_NO = '$part_no'
                    GROUP BY P.CHR_PART_NO, P.INT_LOT_SIZE,
                        K.INT_QTY_PER_BOX, K.CHR_KANBAN_TYPE, K.CHR_BACK_NO
                    ORDER BY P.CHR_PART_NO ASC, K.CHR_KANBAN_TYPE DESC")->result();
        }

        return $query;
    }

    public function get_sa_detail($work_center,$part_no,$part_no_sa )
    {
        $session = $this->session->all_userdata();
        $user = $session['NPK'];
        $upload_date = date('Ymd');
        $upload_time = date('His');
        $ip = gethostbyaddr($_SERVER['REMOTE_ADDR']);

        $query = $this->db->query("select * from PRD.TW_PARTS_BOM WHERE CHR_IP = '$ip' and CHR_WORK_CENTER = '$work_center' and 
        CHR_PART_NO = '$part_no' and CHR_PART_NO_SA = '$part_no_sa'")->result();
        return $query;
    }
}
