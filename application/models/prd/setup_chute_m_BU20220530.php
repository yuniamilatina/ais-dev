<?php

class setup_chute_m extends CI_Model
{

    private $tabel = 'PRD.TT_SETUP_CHUTE';
    private $elina_h = 'PRD.TT_ELINA_H';

    public function __construct()
    {
        parent::__construct();
    }

    function save($data)
    {
        $this->db->insert($this->tabel, $data);
    }

    function insert_special_order($data)
    {
        $this->db->insert($this->tabel, $data);
    }

    function delete($id, $date, $timenow, $user)
    {
        $data = array(
            'INT_SEQUENCE' => 0,
            'CHR_EDITED_BY' => $user,
            'CHR_EDITED_DATE' => $date,
            'CHR_EDITED_TIME' => $timenow,
            'INT_FLG_DEL' => 1
        );

        $this->db->where('INT_ID', $id);
        $this->db->update($this->tabel, $data);
    }

    function update_by_id($id, $data)
    {
        $this->db->where('INT_ID', $id);
        $this->db->update($this->tabel, $data);
    }

    function update_by_prod_order_no($prod_order_no, $data)
    {
        $this->db->where('CHR_PRD_ORDER_NO', $prod_order_no);
        $this->db->update($this->tabel, $data);
    }

    function get_setup_chute($work_center)
    {
        $sql = "SELECT INT_ID, INT_SEQUENCE, CHR_WORK_CENTER, CHR_PART_NO, CHR_PRD_ORDER_NO, INT_LOT_SIZE, INT_QTY_PER_BOX, INT_QTY_PCS, INT_LOT_SIZE_ACTUAL, CHR_DATE, INT_FLG_SO, INT_FLG_PRD FROM $this->tabel 
            WHERE CHR_WORK_CENTER = '$work_center' AND INT_FLG_DEL = '0' ORDER BY INT_SEQUENCE ASC";

        return $this->db->query($sql)->result();
    }

    function get_total_sequence($work_center)
    {
        $sql = "SELECT count(INT_ID) AS MAX_SEQ
                FROM $this->tabel 
                WHERE CHR_WORK_CENTER = '$work_center' AND INT_FLG_DEL = '0' AND INT_SEQUENCE <> '0'";

        return $this->db->query($sql)->row();
    }

    function get_setup_chute_open($work_center)
    {

        $sql = "SELECT a.INT_ID, a.INT_SEQUENCE, a.CHR_WORK_CENTER, a.CHR_PART_NO, a.CHR_PRD_ORDER_NO, a.INT_LOT_SIZE, a.INT_QTY_PER_BOX, 
                        a.INT_QTY_PCS, a.INT_LOT_SIZE_ACTUAL, a.CHR_DATE, a.INT_FLG_SO, a.INT_FLG_PRD, a.INT_STATUS_UNCOMPLETE, a.INT_FLG_DEL, 
                        a.CHR_MODIFIED_BY, a.INT_FLG_ADJUST_FINISH, b.CHR_FLAG, c.CHR_MATRIX_DANDORI, a.INT_FLG_RECOVERY, a.INT_QTY_PCS_ACTUAL,
                        a.CHR_PRD_ORDER_NO_REFF, a.INT_RECOVERY
                FROM PRD.TT_SETUP_CHUTE a
                LEFT JOIN PRD.TT_ELINA_H b ON a.CHR_PRD_ORDER_NO = b.CHR_PRD_ORDER_NO
                LEFT JOIN TM_PARTS c ON a.CHR_PART_NO = c.CHR_PART_NO
                WHERE a.CHR_WORK_CENTER = '$work_center' AND a.INT_FLG_DEL = '0' AND a.INT_SEQUENCE <> '0' AND INT_FLG_PRD <> '2'
                UNION
                SELECT a.INT_ID, a.INT_SEQUENCE, a.CHR_WORK_CENTER, a.CHR_PART_NO, a.CHR_PRD_ORDER_NO, a.INT_LOT_SIZE, a.INT_QTY_PER_BOX, 
                        a.INT_QTY_PCS, a.INT_LOT_SIZE_ACTUAL, a.CHR_DATE, a.INT_FLG_SO, a.INT_FLG_PRD, a.INT_STATUS_UNCOMPLETE, a.INT_FLG_DEL, 
                        a.CHR_MODIFIED_BY, a.INT_FLG_ADJUST_FINISH, b.CHR_FLAG, c.CHR_MATRIX_DANDORI , a.INT_FLG_RECOVERY, a.INT_QTY_PCS_ACTUAL,
                        a.CHR_PRD_ORDER_NO_REFF, a.INT_RECOVERY
                FROM PRD.TT_SETUP_CHUTE a
                LEFT JOIN PRD.TT_ELINA_H b ON a.CHR_PRD_ORDER_NO = b.CHR_PRD_ORDER_NO
                LEFT JOIN TM_PARTS c ON a.CHR_PART_NO = c.CHR_PART_NO
                WHERE a.CHR_WORK_CENTER = '$work_center' AND a.INT_FLG_DEL = '0' AND a.INT_SEQUENCE = '0' AND a.INT_FLG_PRD = '1' AND a.INT_STATUS_UNCOMPLETE = '1'
                ORDER BY a.INT_SEQUENCE ASC";

        return $this->db->query($sql)->result();
    }

    function get_setup_chute_close($work_center)
    {
        $sql = "SELECT TOP 50 sc.INT_ID, sc.INT_SEQUENCE, sc.CHR_WORK_CENTER, sc.CHR_PART_NO, sc.CHR_PRD_ORDER_NO, sc.INT_LOT_SIZE, sc.INT_QTY_PER_BOX, sc.INT_FLG_RECOVERY, sc.INT_QTY_PCS_ACTUAL,
        sc.INT_QTY_PCS, sc.INT_LOT_SIZE_ACTUAL, sc.CHR_DATE, sc.INT_FLG_SO, sc.INT_FLG_PRD, sc.CHR_MODIFIED_DATE, sc.INT_STATUS_UNCOMPLETE, sc.INT_FLG_DEL, sc.CHR_MODIFIED_TIME, sc.INT_FLG_ADJUST_FINISH, p.CHR_MATRIX_DANDORI,
        sc.CHR_PRD_ORDER_NO_REFF, sc.INT_RECOVERY, b.CHR_FLAG
        FROM $this->tabel sc 
        INNER JOIN TM_PARTS p ON p.CHR_PART_NO = sc.CHR_PART_NO
        LEFT JOIN PRD.TT_ELINA_H b ON sc.CHR_PRD_ORDER_NO = b.CHR_PRD_ORDER_NO
            WHERE sc.CHR_WORK_CENTER = '$work_center' AND sc.INT_FLG_DEL = '0' 
            AND sc.INT_SEQUENCE = '0' AND sc.INT_FLG_PRD = '2' AND sc.INT_STATUS_UNCOMPLETE = '0' 
            ORDER BY sc.CHR_MODIFIED_DATE DESC, sc.CHR_MODIFIED_TIME DESC";

        return $this->db->query($sql)->result();
    }

    function get_setup_chute_uncomplete($work_center)
    {
        $sql = "SELECT TOP 50 a.INT_ID, a.INT_SEQUENCE, a.CHR_WORK_CENTER, a.CHR_PART_NO, a.CHR_PRD_ORDER_NO, a.INT_LOT_SIZE, 
            a.INT_QTY_PER_BOX, a.INT_QTY_PCS, a.INT_LOT_SIZE_ACTUAL, a.CHR_DATE, a.INT_FLG_SO, a.INT_FLG_PRD, 
            a.CHR_MODIFIED_DATE, a.INT_STATUS_UNCOMPLETE, a.INT_FLG_DEL, a.CHR_MODIFIED_TIME, a.INT_FLG_ADJUST_FINISH, b.CHR_FLAG,
            p.CHR_MATRIX_DANDORI, a.INT_FLG_RECOVERY, a.INT_QTY_PCS_ACTUAL, a.CHR_PRD_ORDER_NO_REFF, a.INT_RECOVERY
            FROM $this->tabel a
            INNER JOIN TM_PARTS p ON p.CHR_PART_NO = a.CHR_PART_NO
            LEFT JOIN PRD.TT_ELINA_H b ON a.CHR_PRD_ORDER_NO = b.CHR_PRD_ORDER_NO
            WHERE a.CHR_WORK_CENTER = '$work_center' AND a.INT_FLG_DEL = '0' AND a.INT_SEQUENCE = '0' AND a.INT_FLG_PRD = '2' AND a.INT_STATUS_UNCOMPLETE = '1' 
            ORDER BY a.CHR_MODIFIED_DATE DESC, a.CHR_MODIFIED_TIME DESC";

        return $this->db->query($sql)->result();
    }

    function get_detail_setup_chute_by_id($id)
    {
        $sql = "SELECT INT_ID, INT_SEQUENCE, CHR_WORK_CENTER, CHR_PART_NO, CHR_PRD_ORDER_NO, INT_LOT_SIZE, INT_QTY_PER_BOX, INT_QTY_PCS, CHR_DATE, CHR_NOTES, CHR_STATUS_BOM, INT_FLG_ADJUST_FINISH, CHR_NOTES_UNCOMPLETE, INT_FLG_PRD FROM $this->tabel 
            WHERE INT_ID = '$id'";

        return $this->db->query($sql)->row();
    }

    function get_setup_chute_by_period($period, $work_center)
    {
        $sql = "SELECT INT_ID, INT_SEQUENCE, CHR_WORK_CENTER, CHR_PART_NO, INT_LOT_SIZE, INT_QTY_PER_BOX, INT_QTY_PCS, CHR_DATE FROM $this->tabel 
            WHERE CHR_DATE LIKE '$period%' AND CHR_WORK_CENTER = '$work_center' AND INT_FLG_PRD = '0' AND INT_FLG_DEL = '0' ORDER BY INT_SEQUENCE ASC";
        return $this->db->query($sql)->result();
    }

    function get_setup_chute_by_work_center_and_date($work_center, $date)
    {
        $sql = "SELECT INT_ID, INT_SEQUENCE, CHR_WORK_CENTER, CHR_PART_NO, INT_LOT_SIZE, INT_QTY_PER_BOX, INT_QTY_PCS, CHR_DATE FROM $this->tabel 
            WHERE CHR_DATE = '$date' 
            AND CHR_WORK_CENTER = '$work_center' AND INT_FLG_PRD = '0' AND INT_FLG_DEL = '0' ORDER BY INT_SEQUENCE ASC";

        return $this->db->query($sql)->result();
    }

    function compareOrderNoRunning($prod_order_no)
    {
        $query = $this->db->query("SELECT * FROM PRD.TT_SETUP_CHUTE 
        WHERE CHR_PRD_ORDER_NO = '$prod_order_no' AND INT_SEQUENCE = 0 AND INT_FLG_DEL = 0 AND INT_STATUS_UNCOMPLETE = 1 ");

        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function get_setup_chute_for_one_way_kanban($work_center, $prod_order_no)
    {
        return $this->db->query("SELECT TOP 1 A.INT_SEQUENCE, A.CHR_PART_NO, A.CHR_BACK_NO, A.INT_LOT_SIZE, A.INT_QTY_PER_BOX, A.INT_QTY_PCS,
                         B.CHR_BOX_TYPE, B.CHR_SLOC_FROM, B.CHR_SLOC_TO, B.CHR_RAKNO,
                         C.CHR_PART_NAME,
                         D.CHR_CUS_PART_NO, D.CHR_CUS_NO
                     FROM PRD.TT_SETUP_CHUTE A
                     LEFT JOIN TM_KANBAN B ON A.CHR_PART_NO = B.CHR_PART_NO AND A.CHR_BACK_NO = B.CHR_BACK_NO
                     LEFT JOIN TM_PARTS C ON A.CHR_PART_NO = C.CHR_PART_NO
                     LEFT JOIN TM_SHIPPING_PARTS D ON A.CHR_PART_NO = D.CHR_PART_NO
                     WHERE A.CHR_WORK_CENTER = '$work_center' AND A.CHR_PRD_ORDER_NO = '$prod_order_no' AND A.INT_FLG_DEL = '0'
                     AND B.CHR_KANBAN_TYPE IN ('1','5') ORDER BY B.CHR_KANBAN_TYPE DESC")->row();
    }

    function get_setup_chute_for_one_way_kanban_update($work_center, $prod_order_no, $serial)
    {
        return $this->db->query("SELECT TOP 1 A.CHR_SERIAL, A.CHR_PART_NO, A.CHR_BACK_NO, A.INT_LOT_SIZE, A.INT_QTY_PER_BOX, A.INT_QTY_PCS, 
                        B.CHR_BOX_TYPE, B.CHR_SLOC_FROM, B.CHR_SLOC_TO, B.CHR_RAKNO,
                        C.CHR_PART_NAME,
                        D.CHR_CUS_PART_NO, D.CHR_CUS_NO
                    FROM PRD.TT_ONE_WAY_KANBAN A 
                    LEFT JOIN TM_KANBAN B ON A.CHR_PART_NO = B.CHR_PART_NO AND A.CHR_BACK_NO = B.CHR_BACK_NO
                    LEFT JOIN TM_PARTS C ON A.CHR_PART_NO = C.CHR_PART_NO
                    LEFT JOIN TM_SHIPPING_PARTS D ON A.CHR_PART_NO = D.CHR_PART_NO
                    WHERE A.CHR_WORK_CENTER = '$work_center' AND A.CHR_PRD_ORDER_NO = '$prod_order_no' 
                    AND A.CHR_SERIAL = '$serial' AND B.CHR_KANBAN_TYPE IN ('1','5')  --AND INT_FLG_PRINT = '0' 
                    ORDER BY CHR_SERIAL ASC, B.CHR_KANBAN_TYPE DESC
                    ");
    }

    function update_sequence_smaller($work_center, $old_seq, $new_seq, $date, $time, $user)
    {
        $datenow = date('Ymd');
        $timenow = date('his');

        $sql = $this->db->query("UPDATE $this->tabel SET INT_SEQUENCE = (INT_SEQUENCE + 1), CHR_EDITED_BY = '$user', CHR_EDITED_DATE = '$date', 
                CHR_EDITED_TIME = '$time', CHR_MODIFIED_BY = 'update_sequence_smaller', CHR_MODIFIED_DATE = '$datenow ', CHR_MODIFIED_TIME = '$timenow'
                WHERE CHR_WORK_CENTER = '$work_center' AND INT_SEQUENCE >= '$new_seq' AND INT_SEQUENCE < '$old_seq' AND INT_FLG_DEL = '0' AND INT_FLG_PRD <> 2
                AND INT_STATUS_UNCOMPLETE = 1 /*AND INT_FLG_ADJUST_FINISH = 0*/");
    }

    function update_sequence_bigger($work_center, $old_seq, $new_seq, $date, $time, $user)
    {
        $datenow = date('Ymd');
        $timenow = date('his');

        $sql = $this->db->query("UPDATE $this->tabel SET INT_SEQUENCE = (INT_SEQUENCE - 1), CHR_EDITED_BY = '$user', CHR_EDITED_DATE = '$date', 
                CHR_EDITED_TIME = '$time', CHR_MODIFIED_BY = 'update_sequence_bigger', CHR_MODIFIED_DATE = '$datenow', CHR_MODIFIED_TIME = '$timenow'
                WHERE CHR_WORK_CENTER = '$work_center' AND INT_SEQUENCE > '$old_seq' AND INT_SEQUENCE <= '$new_seq' AND INT_FLG_DEL = '0' AND INT_FLG_PRD <> 2
                AND INT_STATUS_UNCOMPLETE = 1 /*AND INT_FLG_ADJUST_FINISH = 0*/");
    }

    function update_sequence_after_so($work_center, $new_seq, $date, $time, $user)
    {
        $datenow = date('Ymd');
        $timenow = date('his');

        $sql = $this->db->query("UPDATE $this->tabel SET INT_SEQUENCE = (INT_SEQUENCE + 1), CHR_EDITED_BY = '$user', CHR_EDITED_DATE = '$date', 
                CHR_EDITED_TIME = '$time', CHR_MODIFIED_BY = 'update_sequence_after_so', CHR_MODIFIED_DATE = '$datenow', CHR_MODIFIED_TIME = '$timenow'
                WHERE CHR_WORK_CENTER = '$work_center' AND INT_SEQUENCE >= '$new_seq' AND INT_FLG_DEL = '0' AND INT_FLG_PRD <> 2
                AND INT_STATUS_UNCOMPLETE = 1 /*AND INT_FLG_ADJUST_FINISH = 0*/");
    }

    function update_sequence_other_from_zero($work_center, $old_seq, $new_seq, $date, $time, $user)
    {
        $datenow = date('Ymd');
        $timenow = date('his');

        $sql = $this->db->query("UPDATE $this->tabel SET INT_SEQUENCE = (INT_SEQUENCE + 1), CHR_EDITED_BY = '$user', CHR_EDITED_DATE = '$date', 
                CHR_EDITED_TIME = '$time', CHR_MODIFIED_BY = 'update_sequence_other_from_zero', CHR_MODIFIED_DATE = '$datenow', CHR_MODIFIED_TIME = '$timenow'
                WHERE CHR_WORK_CENTER = '$work_center' AND INT_SEQUENCE >= '$new_seq' AND INT_FLG_DEL = '0' AND INT_FLG_PRD <> 2
                AND INT_STATUS_UNCOMPLETE = 1 /*AND INT_FLG_ADJUST_FINISH = 0*/");
    }

    function update_sequence_after_delete($work_center, $seq, $date, $time, $user)
    {
        $datenow = date('Ymd');
        $timenow = date('his');

        $sql = $this->db->query("UPDATE $this->tabel SET INT_SEQUENCE = (INT_SEQUENCE - 1), CHR_EDITED_BY = '$user', CHR_EDITED_DATE = '$date', 
                CHR_EDITED_TIME = '$time', CHR_MODIFIED_BY = 'update_sequence_after_delete', CHR_MODIFIED_DATE = '$datenow ', CHR_MODIFIED_TIME = '$timenow'
                WHERE CHR_WORK_CENTER = '$work_center' AND INT_SEQUENCE > '$seq' AND INT_FLG_DEL = '0' AND INT_FLG_PRD <> 2
                AND INT_STATUS_UNCOMPLETE = 1 /*AND INT_FLG_ADJUST_FINISH = 0*/");
    }

    function update_sequence($new_seq, $id, $date, $time, $user)
    {
        $datenow = date('Ymd');
        $timenow = date('his');

        $sql = $this->db->query("UPDATE $this->tabel SET INT_SEQUENCE = '$new_seq', CHR_EDITED_BY = '$user', CHR_EDITED_DATE = '$date', 
                CHR_EDITED_TIME = '$time', CHR_MODIFIED_BY = 'update_sequence', CHR_MODIFIED_DATE = '$datenow ', CHR_MODIFIED_TIME = '$timenow'
                WHERE INT_ID = '$id' AND INT_FLG_DEL = '0'");
    }

    //===== Update sequence lot 1-5 and shortage =====//
    function update_sequence_shortage($new_seq, $id, $date, $time, $user, $flg_stock, $flg_shortage, $notes, $flg_prd)
    {
        $datenow = date('Ymd');
        $timenow = date('his');

        // $sql = $this->db->query("UPDATE $this->tabel SET INT_SEQUENCE = '$new_seq', CHR_STATUS_BOM = '$flg_stock', INT_FLG_SHORTAGE = '$flg_shortage', INT_FLG_PRD = '$flg_prd', CHR_NOTES = '$notes', CHR_EDITED_BY = '$user', CHR_EDITED_DATE = '$date',
        $sql = $this->db->query("UPDATE $this->tabel SET INT_SEQUENCE = '$new_seq', INT_FLG_SHORTAGE = '$flg_shortage', INT_FLG_PRD = '$flg_prd', CHR_NOTES = '$notes', CHR_EDITED_BY = '$user', CHR_EDITED_DATE = '$date',  
                CHR_EDITED_TIME = '$time', CHR_MODIFIED_BY = 'update_sequence_shortage', CHR_MODIFIED_DATE = '$datenow ', CHR_MODIFIED_TIME = '$timenow'
                WHERE INT_ID = '$id' AND INT_FLG_DEL = '0'");
    }

    function check_prepare_elina($prod_order_no)
    {
        $check_elina = $this->db->query("SELECT CHR_FLAG_SCAN FROM PRD.TT_ELINA_L WHERE CHR_PRD_ORDER_NO = '$prod_order_no' AND CHR_FLAG_SCAN = 'T'");
        return $check_elina;
    }

    function delete_data_elina($prod_order_no)
    {
        $sql_elina_h = $this->db->query("DELETE FROM PRD.TT_ELINA_H WHERE CHR_PRD_ORDER_NO = '$prod_order_no'");
        $sql_elina_l = $this->db->query("DELETE FROM PRD.TT_ELINA_L WHERE CHR_PRD_ORDER_NO = '$prod_order_no'");
    }

    function get_sequence_six_up($work_center)
    {
        $six_up = $this->db->query("SELECT INT_ID, CHR_PRD_ORDER_NO FROM PRD.TT_SETUP_CHUTE WHERE CHR_WORK_CENTER = '$work_center' AND INT_SEQUENCE >= '6' AND CHR_STATUS_BOM = '1' AND INT_FLG_DEL = '0'");
        return $six_up;
    }

    function update_status_bom_six_up($id)
    {
        $sql = $this->db->query("UPDATE PRD.TT_SETUP_CHUTE SET CHR_STATUS_BOM = '0' WHERE INT_ID = '$id'");
    }
    //===== End update sequence lot 1-5 and shortage =====//

    function get_all_part_no_by_wc($wc)
    {
        $sql = "SELECT DISTINCT CHR_PART_NO FROM TM_PROCESS_PARTS
            WHERE CHR_WORK_CENTER = '$wc' 
            --AND CHR_PV = '0001' 
            ORDER BY CHR_PART_NO ASC";

        return $this->db->query($sql)->result();
    }

    function get_all_back_no_by_wc($wc)
    {
        $sql = "SELECT DISTINCT A.CHR_PART_NO, B.CHR_BACK_NO
        FROM TM_PROCESS_PARTS A
        LEFT JOIN TM_KANBAN B ON A.CHR_PART_NO = B.CHR_PART_NO
        WHERE A.CHR_WORK_CENTER = '$wc' 
        --AND A.CHR_PV = '0001' 
        AND B.CHR_BACK_NO IS NOT NULL
        ORDER BY B.CHR_BACK_NO ASC";

        return $this->db->query($sql)->result();
    }

    function get_back_no_by_part_no($part_no)
    {
        $sql = "SELECT DISTINCT CHR_BACK_NO FROM TM_KANBAN
            WHERE CHR_PART_NO = '$part_no'";

        return $this->db->query($sql)->row();
    }

    function get_last_recovery_no($prd_order_no)
    {
        $sql = "SELECT TOP 1 INT_RECOVERY FROM PRD.TT_SETUP_CHUTE
            WHERE CHR_PRD_ORDER_NO_REFF LIKE '$prd_order_no%' ORDER BY INT_RECOVERY DESC";

        return $this->db->query($sql);
    }

    function get_last_wo_no($wc, $date)
    {
        $sql = "SELECT TOP 1 CHR_PRD_ORDER_NO FROM PRD.TT_SETUP_CHUTE
            WHERE CHR_DATE = '$date' AND CHR_WORK_CENTER = '$wc' ORDER BY INT_ID DESC";

        return $this->db->query($sql)->row();
    }

    function update_setup_chute_ready_to_use($work_center, $date)
    {
        $datenow = date('Ymd');
        $timenow = date('His');

        $data = array(
            'CHR_MODIFIED_BY' => gethostbyaddr($_SERVER['REMOTE_ADDR']),
            'CHR_MODIFIED_DATE' => $datenow,
            'CHR_MODIFIED_TIME' => $timenow,
            'INT_FLG_PRD' => 1
        );

        $this->db->where('INT_STATUS_UNCOMPLETE', 1);
        $this->db->where('CHR_WORK_CENTER', $work_center);
        $this->db->where('INT_FLG_PRD', 0);
        $this->db->update($this->tabel, $data);

        return $this->db->query("SELECT TOP 1 * FROM $this->tabel WHERE CHR_WORK_CENTER = '$work_center' AND INT_FLG_PRD = '1' 
            AND INT_FLG_DEL = '0' ORDER BY INT_SEQUENCE ASC");
    }

    function update_setup_chute_not_use($work_center, $prod_order_no)
    {
        $datenow = date('Ymd');
        $timenow = date('His');

        //reset lot size when error
        $this->db->query("UPDATE $this->tabel SET INT_LOT_SIZE_ACTUAL = INT_LOT_SIZE - (INT_QTY_PCS_ACTUAL/INT_QTY_PER_BOX) 
                WHERE CHR_PRD_ORDER_NO = '$prod_order_no'");

        $data_sequence = $this->db->query("SELECT * FROM $this->tabel WHERE INT_STATUS_UNCOMPLETE = 1 AND
                CHR_WORK_CENTER = '$work_center' AND INT_FLG_PRD <> '2' AND INT_FLG_DEL = '0' ORDER BY INT_SEQUENCE ASC")->result();

        $y = 1;
        foreach ($data_sequence as $isi) {

            $this->db->query("UPDATE $this->tabel SET INT_SEQUENCE = $y, INT_FLG_PRD = '0', --CHR_STATUS_BOM = '1',
                CHR_MODIFIED_BY = 'Origin', CHR_MODIFIED_DATE = '$datenow', CHR_MODIFIED_TIME = '$timenow'
                WHERE INT_STATUS_UNCOMPLETE = 1 AND CHR_WORK_CENTER = '$work_center' AND INT_FLG_PRD = '1' AND INT_FLG_DEL = '0' 
                AND INT_SEQUENCE = '$isi->INT_SEQUENCE'");

            $y++;
        }
    }

    function updateSetupChuteNotUse($work_center)
    {
        $datenow = date('Ymd');
        $timenow = date('His');

        $data_sequence = $this->db->query("SELECT * FROM $this->tabel WHERE INT_STATUS_UNCOMPLETE = 1 AND
                CHR_WORK_CENTER = '$work_center' AND INT_FLG_PRD <> '2' AND INT_FLG_DEL = '0' ORDER BY INT_SEQUENCE ASC")->result();

        $y = 1;
        foreach ($data_sequence as $isi) {

            $this->db->query("UPDATE $this->tabel SET INT_SEQUENCE = $y, INT_FLG_PRD = '0', --CHR_STATUS_BOM = '1',
                CHR_MODIFIED_BY = 'Origin', CHR_MODIFIED_DATE = '$datenow', CHR_MODIFIED_TIME = '$timenow'
                WHERE INT_STATUS_UNCOMPLETE = 1 AND CHR_WORK_CENTER = '$work_center' AND INT_FLG_PRD = '1' AND INT_FLG_DEL = '0' 
                AND INT_SEQUENCE = '$isi->INT_SEQUENCE'");

            $y++;
        }
    }

    function update_dandori_setup_chute($work_center, $date, $prod_order_no)
    {
        $datenow = date('Ymd');
        $timenow = date('His');

        $chute_dandory_uncomplete = $this->db->query("SELECT * FROM $this->tabel WHERE CHR_WORK_CENTER = '$work_center' AND INT_FLG_PRD = 1 AND INT_SEQUENCE = 0 AND INT_FLG_DEL = 0");

        //===== Update for check phantom  status --- by ANU 20211216 =====//
        //===== START
        $phantom = 0;
        $check_phantom = $this->db->query("SELECT * FROM PRD.TM_WORK_CENTER_PHANTOM_ELINA WHERE CHR_WORK_CENTER = '$work_center' AND INT_FLG_DELETE = '0'");
        if ($check_phantom->num_rows() > 0) {
            $phantom = 1;
        }
        //===== END
        //===== Update for check phantom  status --- by ANU 20211216 =====//

        if ($chute_dandory_uncomplete->num_rows() > 0) {
            if ($chute_dandory_uncomplete->row()->INT_STATUS_UNCOMPLETE == 1) {
                $data_uncompleted = array(
                    'CHR_STATUS_INLINE' => 'I am Uncompleted insert',
                    'CHR_INLINE_DATE' => $datenow,
                    'CHR_INLINE_TIME' => $timenow,
                    'INT_STATUS_UNCOMPLETE' => 1,
                    'INT_FLG_PRD' => 2
                );

                $this->db->where('INT_ID', $chute_dandory_uncomplete->row()->INT_ID);
                $this->db->where('INT_FLG_DEL', 0);
                $this->db->update($this->tabel, $data_uncompleted);

                if ($phantom == 0) {  //===== Update for check phantom  status --- by ANU 20211216 =====// 

                    //flag uncomplete production
                    $data_uncompleted_elina = array(
                        'CHR_FLAG' => '8'
                    );

                    $this->db->where('CHR_PRD_ORDER_NO', $chute_dandory_uncomplete->row()->CHR_PRD_ORDER_NO);
                    $this->db->update($this->elina_h, $data_uncompleted_elina);
                } //===== Update for check phantom  status --- by ANU 20211216 =====//
            } else {
                $data_completed = array(
                    'CHR_STATUS_INLINE' => 'I am Completed insert',
                    'CHR_INLINE_DATE' => $datenow,
                    'CHR_INLINE_TIME' => $timenow,
                    'INT_STATUS_UNCOMPLETE' => 0,
                    'INT_FLG_PRD' => 2
                );

                $this->db->where('INT_ID', $chute_dandory_uncomplete->row()->INT_ID);
                $this->db->where('INT_FLG_DEL', 0);
                $this->db->update($this->tabel, $data_completed);

                if ($phantom == 0) {  //===== Update for check phantom ELINA status --- by ANU 20211216 =====//

                    //flag complete production
                    $data_uncompleted_elina = array(
                        'CHR_FLAG' => '7'
                    );

                    $this->db->where('CHR_PRD_ORDER_NO', $chute_dandory_uncomplete->row()->CHR_PRD_ORDER_NO);
                    $this->db->update($this->elina_h, $data_uncompleted_elina);
                } //===== Update for check phantom ELINA status --- by ANU 20211216 =====//
            }
        }

        //flag ready to produce
        $data = array(
            'CHR_STATUS_INLINE' => 'My Turn insert',
            'CHR_INLINE_DATE' => $datenow,
            'CHR_INLINE_TIME' => $timenow,
            //'CHR_STATUS_BOM' => 0,
            'INT_SEQUENCE' => 0,
            'INT_FLG_PRD' => 1
        );

        $this->db->where('CHR_PRD_ORDER_NO', $prod_order_no); //===== Update by ANU 20190228
        // $this->db->where('CHR_WORK_CENTER', $work_center);
        // $this->db->where('INT_SEQUENCE', 1);
        $this->db->where('INT_FLG_PRD', 1);
        $this->db->where('INT_FLG_DEL', 0);
        $this->db->update($this->tabel, $data);

        if ($phantom == 0) {  //===== Update after check phantom ELINA status --- by ANU 20211216 =====//
            //flag on progress production
            //change CHR_PRD_ORDER_NO = $prod_order_no
            $this->db->query("UPDATE $this->elina_h SET CHR_FLAG = '6' WHERE CHR_FLAG = '5' AND CHR_PRD_ORDER_NO =  
            (SELECT TOP 1 CHR_PRD_ORDER_NO FROM $this->tabel 
            WHERE CHR_WORK_CENTER = '$work_center' AND INT_SEQUENCE = 0 AND INT_FLG_PRD = 1 AND INT_FLG_DEL = 0)");
        } //===== Update after check phantom ELINA status --- by ANU 20211216 =====//

        //update other sequence
        $data_sequence =  $this->db->query("SELECT * FROM $this->tabel WHERE
                CHR_WORK_CENTER = '$work_center' AND INT_FLG_PRD = '1' AND INT_SEQUENCE <> '0' AND INT_FLG_DEL = '0' 
                ORDER BY INT_SEQUENCE ASC")->result();

        $y = 1;
        foreach ($data_sequence as $isi) {

            if ($y >= 1 && $y <= 4) {
                $this->db->query("UPDATE $this->tabel SET INT_SEQUENCE = $y, --CHR_STATUS_BOM = '0',
                    CHR_STATUS_INLINE = 'Dandori machine', CHR_INLINE_DATE = '$datenow', CHR_INLINE_TIME = '$timenow'
                    WHERE INT_ID = '$isi->INT_ID' AND INT_FLG_DEL = 0");
            } else {
                $this->db->query("UPDATE $this->tabel SET INT_SEQUENCE = $y, --CHR_STATUS_BOM = '1',
                    CHR_STATUS_INLINE = 'Dandori machine', CHR_INLINE_DATE = '$datenow', CHR_INLINE_TIME = '$timenow'
                    WHERE INT_ID = '$isi->INT_ID' AND INT_FLG_DEL = 0");
            }
            $y++;
        }
    }

    function update_uncomplete_lot_to_on_prod($date, $work_center,  $prod_order_no)
    {
        $datenow = date('Ymd');
        $timenow = date('His');

        //ordering normally
        $data_sequence =  $this->db->query("SELECT * FROM $this->tabel WHERE 
                CHR_WORK_CENTER = '$work_center' AND INT_FLG_PRD = '1' AND INT_SEQUENCE <> '0' AND INT_FLG_DEL = '0' ORDER BY INT_SEQUENCE ASC")->result();

        $y = 2;
        foreach ($data_sequence as $isi) {

            if ($y >= 2 && $y <= 4) {
                $this->db->query("UPDATE $this->tabel SET INT_SEQUENCE = $y, --CHR_STATUS_BOM = '0',
                    CHR_STATUS_INLINE = 'Victim', CHR_INLINE_DATE = '$datenow', CHR_INLINE_TIME = '$timenow'
                    WHERE INT_ID = '$isi->INT_ID'");
            } else {
                $this->db->query("UPDATE $this->tabel SET INT_SEQUENCE = $y, --CHR_STATUS_BOM = '1',
                    CHR_STATUS_INLINE = 'Victim', CHR_INLINE_DATE = '$datenow', CHR_INLINE_TIME = '$timenow'
                    WHERE INT_ID = '$isi->INT_ID'");
            }
            $y++;
        }

        //flag ready to produce
        $data = array(
            'CHR_STATUS_INLINE' => 'Suspect',
            'CHR_INLINE_DATE' => $datenow,
            'CHR_INLINE_TIME' => $timenow,
            //'CHR_STATUS_BOM' => '0',
            'INT_SEQUENCE' => 1,
            'INT_FLG_PRD' => 1
        );

        $this->db->where('CHR_PRD_ORDER_NO', $prod_order_no);
        $this->db->where('INT_FLG_DEL', 0);
        $this->db->update($this->tabel, $data);
    }

    function get_setup_chute_by_order_no($prod_order_no)
    {

        $sql = "SELECT TOP 1 SC.INT_ID, SC.INT_SEQUENCE, SC.CHR_PRD_ORDER_NO, SC.CHR_WORK_CENTER, SC.CHR_PART_NO, SC.CHR_BACK_NO, SC.INT_LOT_SIZE, SC.INT_LOT_SIZE_ACTUAL, 
                SC.INT_QTY_PER_BOX, SC.INT_QTY_PCS, SC.CHR_DATE, PP.CHR_SLOC_TO, ISNULL(PP.INT_CYCLE_TIME,0) INT_CYCLE_TIME, P.CHR_PART_NAME, PP.CHR_PV, P.CHR_PART_UOM, SC.INT_STATUS_UNCOMPLETE
            FROM $this->tabel SC INNER JOIN TM_PROCESS_PARTS PP ON PP.CHR_PART_NO = SC.CHR_PART_NO
            INNER JOIN TM_PARTS P ON P.CHR_PART_NO = SC.CHR_PART_NO
            WHERE SC.CHR_PRD_ORDER_NO = '$prod_order_no' 
            AND SC.INT_FLG_DEL = '0' --AND SC.INT_SEQUENCE = 1
            ORDER BY SC.INT_SEQUENCE ASC";

        return $this->db->query($sql);
    }

    function get_top_1_setup_chute_by_work_center_and_date($work_center)
    {

        $sql = "SELECT TOP 1 SC.INT_ID, SC.INT_SEQUENCE, SC.CHR_PRD_ORDER_NO, LEFT(RTRIM(SC.CHR_PRD_ORDER_NO_REFF),19) AS CHR_PRD_ORDER_NO_REFF, SC.CHR_WORK_CENTER, SC.CHR_PART_NO, SC.CHR_BACK_NO, 
                SC.INT_LOT_SIZE, SC.INT_LOT_SIZE_ACTUAL, SC.INT_QTY_PCS_ACTUAL,
                SC.INT_QTY_PER_BOX, SC.INT_QTY_PCS, SC.CHR_DATE, PP.CHR_SLOC_TO, 
                ISNULL(PP.INT_CYCLE_TIME,0) INT_CYCLE_TIME, P.CHR_PART_NAME, PP.CHR_PV, P.CHR_PART_UOM, SC.INT_STATUS_UNCOMPLETE,
                SC.INT_QTY_PER_BOX * SC.INT_LOT_SIZE_ACTUAL - (SC.INT_QTY_PCS - SC.INT_QTY_PCS_ACTUAL) AS INT_ACTUAL_PCS,
                SC.INT_LOT_SIZE - SC.INT_LOT_SIZE_ACTUAL AS INT_ACTUAL_KANBAN
            FROM $this->tabel SC 
            INNER JOIN TM_PROCESS_PARTS PP ON PP.CHR_PART_NO = SC.CHR_PART_NO
            AND PP.CHR_WORK_CENTER = SC.CHR_WORK_CENTER --add by toro 20190728
            INNER JOIN TM_PARTS P ON P.CHR_PART_NO = SC.CHR_PART_NO
            WHERE SC.CHR_WORK_CENTER = '$work_center' 
            AND SC.INT_FLG_PRD = '1' AND SC.INT_FLG_DEL = '0' AND SC.INT_SEQUENCE = 1
            ORDER BY SC.INT_SEQUENCE ASC";

        return $this->db->query($sql);
    }

    function get_cavity_setup_chute_by_work_center_and_date($work_center)
    {
        $sql = "SELECT SC.INT_ID, SC.INT_SEQUENCE, SC.CHR_PRD_ORDER_NO, LEFT(RTRIM(SC.CHR_PRD_ORDER_NO_REFF),19) AS CHR_PRD_ORDER_NO_REFF, SC.CHR_WORK_CENTER, SC.CHR_PART_NO, SC.CHR_BACK_NO, 
                SC.INT_LOT_SIZE, SC.INT_LOT_SIZE_ACTUAL, SC.INT_QTY_PCS_ACTUAL,
                SC.INT_QTY_PER_BOX, SC.INT_QTY_PCS, SC.CHR_DATE, PP.CHR_SLOC_TO, 
                ISNULL(PP.INT_CYCLE_TIME,0) INT_CYCLE_TIME, P.CHR_PART_NAME, PP.CHR_PV, P.CHR_PART_UOM, SC.INT_STATUS_UNCOMPLETE,
                SC.INT_QTY_PER_BOX * SC.INT_LOT_SIZE_ACTUAL - (SC.INT_QTY_PCS - SC.INT_QTY_PCS_ACTUAL) AS INT_ACTUAL_PCS,
                SC.INT_LOT_SIZE - SC.INT_LOT_SIZE_ACTUAL AS INT_ACTUAL_KANBAN
            FROM $this->tabel SC 
            INNER JOIN TM_PROCESS_PARTS PP ON PP.CHR_PART_NO = SC.CHR_PART_NO AND PP.CHR_WORK_CENTER = SC.CHR_WORK_CENTER
            INNER JOIN TM_PARTS P ON P.CHR_PART_NO = SC.CHR_PART_NO
            WHERE 
            --INT_ID_CAVITY = (SELECT TOP 1 INT_ID FROM FROM $this->tabel WHERE SC.CHR_WORK_CENTER = '$work_center' AND SC.INT_FLG_PRD = '1' AND SC.INT_FLG_DEL = '0' AND SC.INT_SEQUENCE = 1)
            SC.CHR_WORK_CENTER = '$work_center' AND SC.INT_FLG_PRD = '1' AND SC.INT_FLG_DEL = '0' AND SC.INT_SEQUENCE = 1
            ORDER BY SC.INT_SEQUENCE ASC";

        return $this->db->query($sql);
    }

    function get_next_setup_chute($work_center, $date, $pos)
    {
        $datenow = date('Ymd');
        $timenow = date('His');

        return $this->db->query("SELECT TOP 1 * FROM $this->tabel SC
        INNER JOIN PRD.TM_POS_MATERIAL PM 
        ON PM.CHR_PART_NO_FG = SC.CHR_PART_NO
        AND SC.CHR_WORK_CENTER = PM.CHR_WORK_CENTER
         WHERE 
            SC.CHR_WORK_CENTER = '$work_center' 
            AND SC.INT_FLG_DEL = '0' 
            AND PM.INT_FLG_DEL = '0' 
            AND INT_SEQUENCE <> 0
            AND INT_FLG_PRD <> 2
            AND PM.CHR_POS_PRD = '$pos'
            AND CHR_PRD_ORDER_NO NOT IN (SELECT CHR_PRD_ORDER_NO FROM PRD.TT_PIS_POS_MATERIAL WHERE CHR_POS_PRD = '$pos' 
            AND CHR_WORK_CENTER = '$work_center' GROUP BY CHR_PRD_ORDER_NO)
            ORDER BY INT_SEQUENCE ASC");
    }

    function get_uncomplete_lot_data($date, $work_center)
    {
        $sql = "SELECT 
            '<button onclick=direct_dandori('+''''+ CHR_PRD_ORDER_NO +''''+'); class=button-prod value='+ CHR_BACK_NO + '><span style=font-weight:300>'+ CHR_BACK_NO+'</span><br>  '+ CONVERT(VARCHAR(10),INT_LOT_SIZE_ACTUAL) + ' </button>' CHR_BACK_NO
            FROM $this->tabel
            WHERE 
            CHR_WORK_CENTER = '$work_center' 
            AND INT_FLG_DEL = '0' AND INT_LOT_SIZE_ACTUAL <> 0 AND INT_FLG_PRD = 2 AND INT_SEQUENCE = '0' AND INT_STATUS_UNCOMPLETE = 1
            ORDER BY CHR_MODIFIED_DATE ASC, CHR_MODIFIED_TIME ASC";

        return $this->db->query($sql);
    }

    function get_uncomplete_lot_data_new($work_center)
    {
        $sql = "SELECT TOP 1 sc.CHR_PRD_ORDER_NO, sc.CHR_PART_NO, sc.CHR_BACK_NO, sc.INT_LOT_SIZE_ACTUAL, sc.INT_LOT_SIZE, sc.INT_QTY_PER_BOX, sc.INT_QTY_PCS, sc.INT_QTY_PCS_ACTUAL, sc.INT_FLG_RECOVERY, sc.INT_RECOVERY, sc.CHR_PRD_ORDER_NO_REFF, p.CHR_PART_NAME
            FROM $this->tabel sc
            LEFT JOIN TM_PARTS p ON sc.CHR_PART_NO = p.CHR_PART_NO
            WHERE 
            sc.CHR_WORK_CENTER = '$work_center' 
            AND sc.INT_FLG_DEL = '0' AND sc.INT_FLG_PRD = '1' AND sc.INT_SEQUENCE = '0' AND sc.INT_STATUS_UNCOMPLETE = 1 
            AND sc.INT_FLG_ADJUST_FINISH = '0'";

        return $this->db->query($sql);
    }

    function get_outstd_qty_uncomplete($prod_order_no)
    {
        $sql = "SELECT SUM(TEMP.INT_QTY_PCS_ACTUAL) AS INT_QTY_PCS_ACTUAL_TOTAL, SC.CHR_PRD_ORDER_NO, SC.INT_LOT_SIZE, SC.INT_QTY_PER_BOX, SC.INT_QTY_PCS
            FROM PRD.TT_SETUP_CHUTE SC
            LEFT JOIN 
            (
            SELECT INT_QTY_PCS_ACTUAL, CHR_PRD_ORDER_NO FROM PRD.TT_SETUP_CHUTE WHERE CHR_PRD_ORDER_NO = '$prod_order_no'
            UNION
            SELECT INT_QTY_PCS_ACTUAL, SUBSTRING(CHR_PRD_ORDER_NO_REFF,1,19) AS CHR_PRD_ORDER_NO FROM PRD.TT_SETUP_CHUTE WHERE SUBSTRING(CHR_PRD_ORDER_NO_REFF,1,19) = '$prod_order_no'
            ) TEMP ON SC.CHR_PRD_ORDER_NO = TEMP.CHR_PRD_ORDER_NO
            WHERE SC.CHR_PRD_ORDER_NO = '$prod_order_no'
            GROUP BY SC.CHR_PRD_ORDER_NO, SC.INT_LOT_SIZE, SC.INT_QTY_PER_BOX, SC.INT_QTY_PCS";

        return $this->db->query($sql);
    }
    //===== End Update Input Uncomplete Part =====================//

    function get_id_setup_chute($prod_order_no)
    {

        $query = $this->db->query("SELECT INT_ID FROM $this->tabel WHERE CHR_PRD_ORDER_NO = '$prod_order_no' AND INT_FLG_DEL = 0");

        if ($query->num_rows() > 0) {
            return $query->row()->INT_ID;
        } else {
            return '-';
        }
    }


    //==================================================================//
    // Update by    : IJA
    // Date         : 14.11.2018
    // Function     : Generate QR code from Setup Chute
    //==================================================================//
    // START
    function get_flag_qr()
    {
        $sql = $this->db->query("SELECT * FROM PRD.TT_SETUP_CHUTE WHERE INT_FLG_GENERATE_QR = '0'");
        return $sql;
    }

    function update_flag_qr($prod_order_no)
    {
        $sql = $this->db->query("UPDATE $this->tabel SET INT_FLG_GENERATE_QR = '1' WHERE CHR_PRD_ORDER_NO = '$prod_order_no'");
    }
    // FINISH

    //===== Get default Prod Order No --- by ANU 20190214 =====//
    // function get_ready_prod(){
    //     $get_chute = $this->db->query("SELECT TOP 1 CHR_PRD_ORDER_NO FROM PRD.TT_SETUP_CHUTE 
    //                         WHERE INT_FLG_DEL = '0' AND INT_SEQUENCE = '1' AND INT_FLG_PRD = '1' AND INT_STATUS_UNCOMPLETE = '1'")->row();
    //     return $get_chute;
    // }

    // //===== YOKOTEN ELISANATA --- ANU 20190703 ==============//
    function get_ready_prod($work_center)
    {
        $get_chute = $this->db->query("SELECT TOP 1 CHR_PRD_ORDER_NO FROM PRD.TT_SETUP_CHUTE 
                            WHERE CHR_WORK_CENTER = '$work_center' AND INT_FLG_DEL = '0' AND INT_SEQUENCE = '1' AND INT_FLG_PRD = '1' AND INT_STATUS_UNCOMPLETE = '1'")->row();
        return $get_chute;
    }

    // function get_on_progress_prod(){
    //     $get_chute = $this->db->query("SELECT TOP 1 CHR_PRD_ORDER_NO FROM PRD.TT_SETUP_CHUTE 
    //                         WHERE INT_FLG_DEL = '0' AND INT_SEQUENCE = '0' AND INT_FLG_PRD = '1' AND INT_STATUS_UNCOMPLETE = '1'")->row();
    //     return $get_chute;
    // }

    // //===== YOKOTEN ELISANATA --- ANU 20190703 ==============//
    function get_on_progress_prod($work_center)
    {
        $get_chute = $this->db->query("SELECT TOP 1 CHR_PRD_ORDER_NO FROM PRD.TT_SETUP_CHUTE 
                            WHERE CHR_WORK_CENTER = '$work_center' AND INT_FLG_DEL = '0' AND INT_SEQUENCE = '0' AND INT_FLG_PRD = '1' AND INT_STATUS_UNCOMPLETE = '1'")->row();
        return $get_chute;
    }

    //===== END --- Get default Prod Order No --- by ANU 20190214 =====//

    function get_all_setup_chute_open($work_center)
    {
        $get_chute = $this->db->query("SELECT INT_ID, INT_SEQUENCE FROM PRD.TT_SETUP_CHUTE 
                            WHERE CHR_WORK_CENTER = '$work_center' AND INT_FLG_DEL = '0' AND INT_SEQUENCE <> '0' AND INT_FLG_PRD <> '2' AND INT_STATUS_UNCOMPLETE = '1'
                            ORDER BY INT_SEQUENCE ASC");
        return $get_chute;
    }

    function rearrange_chute($id, $seq)
    {
        $update_chute = $this->db->query("UPDATE PRD.TT_SETUP_CHUTE SET INT_SEQUENCE = '$seq' 
                            WHERE INT_ID = '$id' AND INT_FLG_DEL = '0' AND INT_SEQUENCE <> '0' AND INT_FLG_PRD <> '2'");
        return $update_chute;
    }

    function get_actual_setup_chute_kanban($prod_order_no)
    {
        $query = $this->db->query("SELECT (INT_LOT_SIZE - INT_LOT_SIZE_ACTUAL) * INT_QTY_PER_BOX AS INT_QTY_PCS_ACTUAL ,
            INT_LOT_SIZE - INT_LOT_SIZE_ACTUAL AS ACTUAL_KANBAN,
            INT_QTY_PER_BOX AS ACTUAL_PART FROM PRD.TT_SETUP_CHUTE WHERE CHR_PRD_ORDER_NO = '$prod_order_no' AND INT_FLG_DEL = 0");

        return $query->row();
    }

    function get_actual_setup_chute($prod_order_no)
    {
        $query = $this->db->query("SELECT CASE WHEN INT_LOT_SIZE = INT_LOT_SIZE_ACTUAL THEN INT_QTY_PCS_ACTUAL 
        WHEN INT_LOT_SIZE_ACTUAL = 0 THEN INT_QTY_PER_BOX
        ELSE INT_QTY_PCS_ACTUAL - ((INT_LOT_SIZE - INT_LOT_SIZE_ACTUAL) * INT_QTY_PER_BOX)  END AS ACTUAL_PART ,
            INT_LOT_SIZE - INT_LOT_SIZE_ACTUAL AS ACTUAL_KANBAN, * FROM PRD.TT_SETUP_CHUTE WHERE CHR_PRD_ORDER_NO = '$prod_order_no' AND INT_FLG_DEL = 0");

        return $query->row();
    }

    function update_actual_lot($work_center, $prod_order_no)
    {
        $datenow = date('Ymd');
        $timenow = date('His');

        $this->db->query("UPDATE $this->tabel SET INT_LOT_SIZE_ACTUAL = INT_LOT_SIZE_ACTUAL - 1, INT_QTY_PCS_ACTUAL = INT_QTY_PCS_ACTUAL + INT_QTY_PER_BOX,
            INT_STATUS_UNCOMPLETE = 1, CHR_STATUS_INLINE = 'Lot Takers', CHR_INLINE_DATE = '$datenow', CHR_INLINE_TIME = '$timenow'
            WHERE CHR_WORK_CENTER = '$work_center' AND INT_FLG_DEL = '0' AND INT_SEQUENCE = 0 AND CHR_PRD_ORDER_NO = '$prod_order_no'");

        $data_sequence =  $this->db->query("SELECT TOP 1 * FROM $this->tabel WHERE CHR_WORK_CENTER = '$work_center' AND CHR_PRD_ORDER_NO = '$prod_order_no' AND INT_FLG_DEL = '0'")->row();

        if ($data_sequence->INT_LOT_SIZE_ACTUAL == 0) {
            $this->db->query("UPDATE $this->tabel SET INT_FLG_PRD = '2', INT_STATUS_UNCOMPLETE = 0, CHR_STATUS_INLINE = 'I am Completed', CHR_INLINE_DATE = '$datenow', CHR_INLINE_TIME = '$timenow'
            WHERE CHR_WORK_CENTER = '$work_center' AND INT_FLG_DEL = '0' AND INT_SEQUENCE = 0 AND CHR_PRD_ORDER_NO = '$prod_order_no'");

            //flag on progress production
            $this->db->query("UPDATE $this->elina_h SET CHR_FLAG = '7' WHERE CHR_PRD_ORDER_NO =  '$prod_order_no'");
        }
    }

    function update_actual_lot_product($work_center, $prod_order_no)
    {
        $datenow = date('Ymd');
        $timenow = date('His');

        $this->db->query("UPDATE $this->tabel SET INT_LOT_SIZE_ACTUAL = INT_LOT_SIZE_ACTUAL - 1, 
            INT_STATUS_UNCOMPLETE = 1, CHR_STATUS_INLINE = 'Lot Takers', CHR_INLINE_DATE = '$datenow', CHR_INLINE_TIME = '$timenow'
            WHERE CHR_WORK_CENTER = '$work_center' AND INT_FLG_DEL = '0' AND INT_SEQUENCE = 0 AND CHR_PRD_ORDER_NO = '$prod_order_no'");

        $data_sequence =  $this->db->query("SELECT TOP 1 * FROM $this->tabel WHERE CHR_WORK_CENTER = '$work_center' AND CHR_PRD_ORDER_NO = '$prod_order_no' AND INT_FLG_DEL = '0'")->row();

        if ($data_sequence->INT_LOT_SIZE_ACTUAL == 0) {
            $this->db->query("UPDATE $this->tabel SET INT_FLG_PRD = '2', INT_STATUS_UNCOMPLETE = 0, CHR_STATUS_INLINE = 'I am Completed', CHR_INLINE_DATE = '$datenow', CHR_INLINE_TIME = '$timenow'
            WHERE CHR_WORK_CENTER = '$work_center' AND INT_FLG_DEL = '0' AND INT_SEQUENCE = 0 AND CHR_PRD_ORDER_NO = '$prod_order_no'");

            //flag on progress production
            $this->db->query("UPDATE $this->elina_h SET CHR_FLAG = '7' WHERE CHR_PRD_ORDER_NO =  '$prod_order_no'");
        }
    }

    function update_actual_pcs($prod_order_no)
    {
        $this->db->query("UPDATE $this->tabel SET INT_QTY_PCS_ACTUAL = INT_QTY_PCS_ACTUAL + 1 WHERE INT_FLG_DEL = '0' AND INT_SEQUENCE = 0 AND CHR_PRD_ORDER_NO = '$prod_order_no'");
    }

    function update_eceran_setup_chute($prod_order_no, $qty_eceran)
    {

        $query = $this->db->query("SELECT TOP 1 * FROM PRD.TT_ONE_WAY_KANBAN O 
        INNER JOIN TT_HISTORY_IN_LINE_SCAN H ON O.CHR_PRD_ORDER_NO = H.CHR_PRD_ORDER_NO 
        AND H.CHR_BARCODE_KANBAN = O.CHR_PRD_ORDER_NO + ' ' + CHR_SERIAL
        WHERE O.CHR_PRD_ORDER_NO = '$prod_order_no' 
        AND H.CHR_STATUS_DATA = 'ECERAN' ORDER BY O.INT_ID DESC ");

        if ($query->num_rows() > 0) {
            $lot_size = 0;
        } else {
            $lot_size = 1;
        }

        $this->db->query("UPDATE $this->tabel SET INT_QTY_PCS_ACTUAL = INT_QTY_PCS_ACTUAL + $qty_eceran  
        --,INT_LOT_SIZE_ACTUAL = INT_LOT_SIZE_ACTUAL - $lot_size
        WHERE INT_FLG_DEL = '0' AND INT_SEQUENCE = 0 AND CHR_PRD_ORDER_NO = '$prod_order_no'");

        return $lot_size;
    }

    function get_uncomplete_prod_no($wcenter, $part_no)
    {
        $query = $this->db->query("SELECT CHR_PRD_ORDER_NO, INT_LOT_SIZE, INT_QTY_PER_BOX, INT_QTY_PCS, INT_QTY_PCS_ACTUAL FROM PRD.TT_SETUP_CHUTE WHERE CHR_WORK_CENTER = '$wcenter' AND CHR_PART_NO = '$part_no'
                AND INT_FLG_PRD = '2' AND INT_STATUS_UNCOMPLETE = '1' ORDER BY CHR_MODIFIED_DATE DESC");
        return $query;
    }

    function get_data_uncomplete_by_id($id)
    {
        $query = $this->db->query("SELECT * FROM PRD.TT_SETUP_CHUTE WHERE INT_ID = '$id'");
        return $query;
    }

    function get_last_sequence($wc, $date)
    {
        $sql = "SELECT TOP 1 INT_SEQUENCE FROM PRD.TT_SETUP_CHUTE
            WHERE /*CHR_DATE = '$date' AND*/ CHR_WORK_CENTER = '$wc' ORDER BY INT_SEQUENCE DESC";

        return $this->db->query($sql)->row();
    }

    function get_status_recovery_by_prod_no($prod_order_no)
    {
        $sql = "SELECT TOP 1 INT_FLG_RECOVERY, CHR_PRD_ORDER_NO_REFF FROM PRD.TT_SETUP_CHUTE
            WHERE CHR_PRD_ORDER_NO = '$prod_order_no'";

        return $this->db->query($sql)->row();
    }

    function get_additional_info_kanban($part_no)
    {
        $query = $this->db->query("SELECT CHR_KANBAN_ADDITIONAL_INFO FROM PRD.TM_KANBAN_ADDITIONAL_INFO WHERE CHR_PART_NO = '$part_no' AND INT_FLAG_DELETE <> '1'");
        return $query;
    }

    function check_work_center_phantom_elina($work_center)
    {
        $query = $this->db->query("SELECT * FROM PRD.TM_WORK_CENTER_PHANTOM_ELINA WHERE CHR_WORK_CENTER = '$work_center' AND INT_FLG_DELETE = '0'");
        return $query;
    }

    function check_phantom_elina($work_center)
    {
        $sql = "SELECT * FROM PRD.TM_WORK_CENTER_PHANTOM_ELINA WHERE CHR_WORK_CENTER = '$work_center' AND INT_FLG_DELETE = '0'";

        if($this->db->query($sql)->num_rows() > 0){
            return '1';
        } else {
            return '0';
        }
        
    }
}
