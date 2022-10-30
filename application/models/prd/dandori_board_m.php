<?php

class dandori_board_m extends CI_Model
{

    private $tabel = 'PRD.TW_DANDORI_BOARD';
    private $tabel_history = 'PRD.TT_DANDORI_HISTORY_CHECK';

    public function __construct()
    {
        parent::__construct();
    }

    function update_dandori_board($prod_order_no, $work_center,  $part_no)
    {

        $data_pos = $this->db->query("SELECT TOP 1 CHR_WORK_CENTER, CHR_PART_NO, CHR_POS_PRD, CHR_IMG_FILE_NAME AS CHR_IMG_URL FROM PRD.TM_POS 
        WHERE CHR_PART_NO = '$part_no' AND INT_FLG_DEL = 0 ORDER BY CONVERT(INT, CHR_POS_PRD) DESC");

        if ($data_pos->num_rows() > 0) {
            $img_pos = $data_pos->row()->CHR_IMG_URL;
        } else {
            $img_pos = 'assets/img/wi/no-image-available.jpg';
        }

        $data = array(
            'CHR_PART_NO' => $part_no,
            'CHR_WORK_CENTER' => $work_center,
            'CHR_PRD_ORDER_NO' => $prod_order_no,
            'CHR_IMG_URL' => $img_pos
        );

        $data_board = $this->db->query("SELECT * FROM $this->tabel WHERE CHR_WORK_CENTER = '$work_center'");

        if ($data_board->num_rows() > 0) {
            $this->db->where('CHR_WORK_CENTER', $work_center);
            $this->db->update($this->tabel, $data);
        } else {
            $this->db->insert($this->tabel, $data);
        }
    }

    function delete($work_center)
    {
        $this->db->query("DELETE $this->tabel  WHERE CHR_WORK_CENTER = '$work_center'");
    }

    public function generateCheckPointDandori($prd_order_no, $work_center, $part_no)
    {
        $this->db->query("INSERT INTO $this->tabel_history (CHR_PART_NO, CHR_IMG_FILE_NAME, CHR_WORK_CENTER, CHR_POS_PRD, CHR_PRD_ORDER_NO, INT_COOR_X, INT_COOR_Y, CHR_KEY_POINT)
        SELECT P.CHR_PART_NO, P.CHR_IMG_FILE_NAME, P.CHR_WORK_CENTER, P.CHR_POS_PRD, '$prd_order_no' AS CHR_PRD_ORDER_NO, PC.INT_COOR_X,PC.INT_COOR_Y, PC.CHR_KEY_POINT FROM PRD.TM_POS P 
        LEFT JOIN PRD.TM_POS_COORDINATE PC ON P.INT_ID = PC.INT_ID_POS 
        WHERE P.INT_FLG_DEL = 0 AND P.CHR_WORK_CENTER = '$work_center' AND P.CHR_PART_NO = '$part_no' AND CHR_POS_PRD = 
        (SELECT TOP 1 CHR_POS_PRD FROM PRD.TM_POS WHERE INT_FLG_DEL = 0 AND CHR_WORK_CENTER = '$work_center' 
        AND CHR_PART_NO = '$part_no' GROUP BY CHR_POS_PRD ORDER BY CHR_POS_PRD DESC)");
    }

    public function getActiveDandoriCheck($work_center)
    {
        return $this->db->query("SELECT * FROM $this->tabel WHERE CHR_WORK_CENTER = '$work_center'")->row();
    }

    public function getDandoriCheckPoint($work_center)
    {
        return $this->db->query("SELECT DHC.INT_ID, DHC.INT_COOR_X, DHC.INT_COOR_Y
        FROM $this->tabel_history DHC 
        INNER JOIN $this->tabel DB 
        ON DHC.CHR_WORK_CENTER = DB.CHR_WORK_CENTER AND DHC.CHR_PART_NO = DB.CHR_PART_NO
        WHERE DB.CHR_WORK_CENTER = '$work_center' AND CHR_CREATED_TIME = 
		(SELECT TOP 1 CHR_CREATED_TIME FROM $this->tabel_history WHERE CHR_WORK_CENTER = '$work_center' ORDER BY INT_ID DESC)");
    }

    public function updateChecked($id)
    {
        $data = array('INT_FLG_CHECKED' => 1);

        $this->db->where('INT_ID', $id);
        $this->db->where('INT_FLG_CHECKED', 0);
        $this->db->update($this->tabel_history, $data);
    }
}
