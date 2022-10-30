<?php

class coordinate_m extends CI_Model {

    private $master_coordinate = 'TM_WI_COORDINATE';
    private $trans_coordinate = 'TT_WI_COORDINATE';

    public function __construct() {
        parent::__construct();
    }

    function getDataCoordinate() {

        return $this->db->query("SELECT * FROM $this->master_coordinate WHERE INT_FLG_DELETE = 0")->result();

    }

    function update_dandori_board($work_center,  $part_no){
        
        $data_pos = $this->db->query("SELECT TOP 1 CHR_WORK_CENTER, CHR_PART_NO, CHR_POS_PRD, CHR_IMG_FILE_NAME AS CHR_IMG_URL FROM PRD.TM_POS 
        WHERE CHR_PART_NO = '$part_no' AND INT_FLG_DEL = 0 ORDER BY CONVERT(INT, CHR_POS_PRD) DESC");

        if($data_pos->num_rows() > 0){
            $img_pos = $data_pos->row()->CHR_IMG_URL;
        }else{
            $img_pos ='assets/img/wi/no-image-available.jpg';
        }

        $data = array(
            'CHR_PART_NO' => $part_no,
            'CHR_WORK_CENTER' => $work_center,
            'CHR_IMG_URL' => $img_pos
        );

        $data_board = $this->db->query("SELECT * FROM $this->master_coordinate WHERE CHR_WORK_CENTER = '$work_center'");

        if($data_board->num_rows() > 0){
            $this->db->where('CHR_WORK_CENTER', $work_center);
            $this->db->update($this->master_coordinate, $data);
        }else{
            $this->db->insert($this->master_coordinate, $data);
        }

    }

    function delete($work_center){
        $this->db->query("DELETE $this->trans_coordinate  WHERE CHR_WORK_CENTER = '$work_center'");
    }

}
