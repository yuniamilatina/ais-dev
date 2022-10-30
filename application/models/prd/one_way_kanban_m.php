<?php

class one_way_kanban_m extends CI_Model
{

    private $tabel = 'PRD.TT_ONE_WAY_KANBAN';

    public function __construct()
    {
        parent::__construct();
    }

    function save($data)
    {
        $this->db->insert($this->tabel, $data);
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

    function update_printed_one_way_kanban($work_center, $prod_order_no, $serial)
    {

        $date = date('Ymd');
        $time = date('His');

        $data = array(
            'INT_FLG_PRINT' => 1,
            'CHR_MODIFIED_BY' => 'update_printed_one_way_kanban',
            'CHR_MODIFIED_DATE' => $date,
            'CHR_MODIFIED_TIME' => $time
        );

        $this->db->where('CHR_WORK_CENTER', $work_center);
        $this->db->where('CHR_SERIAL', $serial);
        $this->db->where('CHR_PRD_ORDER_NO', $prod_order_no);

        $this->db->update($this->tabel, $data);
    }

    // function get_data_one_way_kanban() {
    //     $sql = "SELECT INT_SEQUENCE, CHR_WORK_CENTER, CHR_PART_NO, INT_LOT_SIZE, CHR_DATE FROM $this->table 
    //         WHERE INT_FLG_DEL = 0";

    //     return $this->db->query($sql)->result();
    // }

    function get_detail_one_way_kanban_by_date_and_work_center($work_center, $date)
    {
        $sql = "SELECT * FROM $this->tabel
             WHERE CHR_WORK_CENTER = '$work_center' 
             AND CHR_PRD_ORDER_NO LIKE '%" . $date . "%'";
             //AND CHR_CREATED_DATE = '$date'";            

        return $this->db->query($sql)->result();
    }


    function get_serial_by_order_no($prod_order_no)
    {
        $sql = "SELECT * FROM PRD.TT_ONE_WAY_KANBAN 
        WHERE CHR_PRD_ORDER_NO = '$prod_order_no'";

        return $this->db->query($sql)->num_rows();
    }

    //loop3r 20220630
    function getLastOrderNo($prod_order_no)
    {
        $sql = $this->db->query("SELECT TOP 1 * FROM PRD.TT_ONE_WAY_KANBAN  WHERE CHR_PRD_ORDER_NO = '$prod_order_no' 
        AND INT_FLG_PRINT = 1 ORDER BY CONVERT(INT,CHR_SERIAL) DESC");

        if($sql->num_rows() > 0){
            return $sql->row();
        }else{
            return false;
        }
    }

    function get_new_data_one_way_kanban($prod_order_no)
    {
        $sql = "SELECT TOP 1 * FROM PRD.TT_ONE_WAY_KANBAN WHERE CHR_PRD_ORDER_NO = '$prod_order_no' AND INT_FLG_PRINT = 0 ORDER BY CONVERT(INT,CHR_SERIAL) ASC";

        return $this->db->query($sql);
    }

    function get_id_by_serial_and_order_no($prod_order_no, $serial)
    {
        $sql = "SELECT INT_ID, CHR_PRD_ORDER_NO FROM PRD.TT_ONE_WAY_KANBAN WHERE CHR_PRD_ORDER_NO = '$prod_order_no' AND CHR_SERIAL = '$serial'";

        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }

    function get_one_way_kanban_data_by_order_no($prod_order_no, $work_center)
    {

        $query = $this->db->query("SELECT TOP 1 A.CHR_SERIAL, A.CHR_PART_NO, A.CHR_BACK_NO, A.INT_LOT_SIZE, A.INT_QTY_PER_BOX, A.INT_QTY_PCS, 
                    B.CHR_BOX_TYPE, B.CHR_SLOC_FROM, B.CHR_SLOC_TO, B.CHR_RAKNO,
                    C.CHR_PART_NAME,
                    D.CHR_CUS_PART_NO, D.CHR_CUS_NO
                FROM PRD.TT_ONE_WAY_KANBAN A 
                LEFT JOIN TM_KANBAN B ON A.CHR_PART_NO = B.CHR_PART_NO AND A.CHR_BACK_NO = B.CHR_BACK_NO
                LEFT JOIN TM_PARTS C ON A.CHR_PART_NO = C.CHR_PART_NO
                LEFT JOIN TM_SHIPPING_PARTS D ON A.CHR_PART_NO = D.CHR_PART_NO
                WHERE A.CHR_WORK_CENTER = '$work_center' AND A.CHR_PRD_ORDER_NO = '$prod_order_no' 
                AND A.INT_FLG_PRINT = '1' AND B.CHR_KANBAN_TYPE IN ('1','5')
                ORDER BY CONVERT(INT,CHR_SERIAL) DESC, B.CHR_KANBAN_TYPE DESC");

        if ($query->num_rows() > 0) {

            $data = $query->row();
        } else {
            $query = $this->db->query("SELECT TOP 1 A.CHR_SERIAL, A.CHR_PART_NO, A.CHR_BACK_NO, A.INT_LOT_SIZE, A.INT_QTY_PER_BOX, A.INT_QTY_PCS, 
                    B.CHR_BOX_TYPE, B.CHR_SLOC_FROM, B.CHR_SLOC_TO, B.CHR_RAKNO,
                    C.CHR_PART_NAME,
                    D.CHR_CUS_PART_NO, D.CHR_CUS_NO
                FROM PRD.TT_ONE_WAY_KANBAN A 
                LEFT JOIN TM_KANBAN B ON A.CHR_PART_NO = B.CHR_PART_NO AND A.CHR_BACK_NO = B.CHR_BACK_NO
                LEFT JOIN TM_PARTS C ON A.CHR_PART_NO = C.CHR_PART_NO
                LEFT JOIN TM_SHIPPING_PARTS D ON A.CHR_PART_NO = D.CHR_PART_NO
                WHERE A.CHR_WORK_CENTER = '$work_center' AND A.CHR_PRD_ORDER_NO = '$prod_order_no' 
                ORDER BY CONVERT(INT,CHR_SERIAL) ASC");

            $data = $query->row();
        }
        return $data;
    }

    function get_verification_prd_order_no_by_kanban($no_kanban, $serial, $prod_order_no)
    {
        $query = $this->db->query("SELECT CHR_BACK_NO,  CHR_PRD_ORDER_NO FROM PRD.TT_ONE_WAY_KANBAN 
        WHERE INT_ID = '$no_kanban' AND CHR_SERIAL = '$serial' AND CHR_PRD_ORDER_NO = '$prod_order_no' ");

        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function get_verification_prd_order_no_by_orderno($prod_order_no, $serial)
    {
        $query = $this->db->query("SELECT CHR_BACK_NO,  CHR_PRD_ORDER_NO FROM PRD.TT_ONE_WAY_KANBAN 
        WHERE CHR_SERIAL = '$serial' AND CHR_PRD_ORDER_NO = '$prod_order_no' ");

        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function get_history_scan_kanban($id, $serial)
    {
        $query = $this->db->query("SELECT * FROM  PRD.TT_ONE_WAY_KANBAN 
            WHERE INT_ID = $id AND CHR_SERIAL = '$serial' AND INT_FLG_SCANNED = 0");

        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function get_history_scan_kanban_by_order_no($prod_order_no, $serial)
    {

        $query = $this->db->query("SELECT * FROM  PRD.TT_ONE_WAY_KANBAN 
            WHERE CHR_PRD_ORDER_NO = '$prod_order_no' AND CHR_SERIAL = '$serial' AND INT_FLG_SCANNED = 0");

        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function get_history_scan_orderno($prod_order_no, $serial)
    {
        $query = $this->db->query("SELECT * FROM  PRD.TT_ONE_WAY_KANBAN 
            WHERE CHR_PRD_ORDER_NO = '$prod_order_no' AND CHR_SERIAL = '$serial' AND INT_FLG_SCANNED = 0");

        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function get_one_way_kanban_printed_by_prd_order($prod_order_no)
    {
        $query = $this->db->query("SELECT TOP 1 * FROM $this->tabel WHERE CHR_PRD_ORDER_NO = '$prod_order_no' AND INT_FLG_PRINT = 1 ORDER BY INT_ID ASC");

        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }

    function get_label_one_way_by_id_setup_chute($id)
    {
        return $this->db->query("SELECT OWK.CHR_SERIAL, SC.CHR_PRD_ORDER_NO, OWK.CHR_PART_NO, 
        CASE WHEN OWK.CHR_ERROR_MESSAGE IS NULL THEN 
        '<button onclick=printSerial('+ CONVERT(VARCHAR(200),OWK.INT_ID) + ') class=button-serial ><div style=font-size:12px;>'+ CHR_SERIAL+'</div> </button>' 
        ELSE
        '<button onclick=printSerial('+ CONVERT(VARCHAR(200),OWK.INT_ID) + ') class=button-serial style=background:#FE385B;color:#FFFFFF;><div style=font-size:12px;>'+ CHR_SERIAL+'</div> </button>' 
		END AS CHR_SERIAL
        FROM PRD.TT_ONE_WAY_KANBAN OWK 
        INNER JOIN PRD.TT_SETUP_CHUTE SC ON SC.CHR_PRD_ORDER_NO = OWK.CHR_PRD_ORDER_NO AND SC.INT_FLG_DEL = 0
        WHERE SC.INT_ID = '$id' AND OWK.CHR_ERROR_MESSAGE IS NOT NULL ORDER BY OWK.CHR_SERIAL
        ");
    }

    function get_one_way_kanban_data_by_id($id)
    {

        $query = $this->db->query("SELECT A.CHR_PRD_ORDER_NO, A.CHR_SERIAL, A.CHR_PART_NO, A.CHR_BACK_NO, A.INT_LOT_SIZE, A.INT_QTY_PER_BOX, A.INT_QTY_PCS, 
                    B.CHR_BOX_TYPE, B.CHR_SLOC_FROM, B.CHR_SLOC_TO, B.CHR_RAKNO,
                    C.CHR_PART_NAME,
                    D.CHR_CUS_PART_NO, D.CHR_CUS_NO
                FROM PRD.TT_ONE_WAY_KANBAN A 
                LEFT JOIN TM_KANBAN B ON A.CHR_PART_NO = B.CHR_PART_NO AND A.CHR_BACK_NO = B.CHR_BACK_NO
                LEFT JOIN TM_PARTS C ON A.CHR_PART_NO = C.CHR_PART_NO
                LEFT JOIN TM_SHIPPING_PARTS D ON A.CHR_PART_NO = D.CHR_PART_NO
                WHERE A.INT_ID = '$id'");

        if ($query->num_rows() > 0) {
            $data = $query->row();
        } else {
            $data = false;
        }
        return $data;
    }

    function checkExisting($prod_order_no)
    {
        $sql = $this->db->query("SELECT TOP 1 * FROM PRD.TT_ONE_WAY_KANBAN  WHERE CHR_PRD_ORDER_NO = '$prod_order_no' ORDER BY CONVERT(INT,CHR_SERIAL) DESC");

        if($sql->num_rows() > 0){
            return $sql->row();
        }else{
            return false;
        }
    }
}
