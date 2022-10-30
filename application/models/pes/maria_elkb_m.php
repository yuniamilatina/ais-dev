<?php

class maria_elkb_m extends CI_Model
{

    private $tabel1 = 'PRD.TM_TROLLEY_NG';
    private $tb_lkb_h = 'dbo.TT_RESERVASI_ELKB_H';

    public function __construct()
    {
        parent::__construct();
    }

    function trolley_rsvn()
    {
        $data =  $this->db->query("SELECT distinct CHR_TROLLEY_ID FROM $this->tb_lkb_h order by CHR_TROLLEY_ID asc")->result();
        return $data;
    }
    function trolley_aktif()
    {
        $data =  $this->db->query("SELECT CHR_TROLLEY_ID FROM $this->tabel1 where CHR_TROLLEY_ID not in (select CHR_TROLLEY_ID from $this->tb_lkb_h where CHR_STAT_FINISH='F') order by CHR_AREA asc")->result();
        return $data;
    }

    function reserv_trolley_h()
    {
        $data =  $this->db->query("SELECT * FROM $this->tb_lkb_h where CHR_STAT_FINISH='F' order by CHR_ID_ELKB asc")->result();
        return $data;
    }

    function save_rsvn_lkb($data_tr)
    {
        $this->db->insert($this->tb_lkb_h, $data_tr);
    }

    function select_data_part()
    {
        $this->db->select("A.CHR_PART_NO,C.CHR_PART_NAME,A.CHR_BACK_NO,B.INT_QTY_PER_BOX,A.CHR_WORK_CTR,A.CHR_CAT,A.CHR_FLAG_STATUS 
                            FROM PRD.TM_PART_PER_LINE A 
                            INNER JOIN TM_KANBAN B 
                            ON A.CHR_PART_NO = B.CHR_PART_NO  
                            INNER JOIN TM_PARTS C
                            ON C.CHR_PART_NO = A.CHR_PART_NO");
        $this->db->where("B.CHR_KANBAN_TYPE='0'");
        $query = $this->db->get();
        return $query->result();
    }

    function save()
    {

        $stored_procedure = "EXEC PRD.zsp_merge_part_per_line";

        $this->db->query($stored_procedure);
    }

    function delete($id)
    {
        $data = array('INT_FLG_DEL' => 1);

        $this->db->where('INT_ID', $id);
        $this->db->update($this->tabel, $data);
    }

    function update($data, $pno, $bno)
    {
        $this->db->where('CHR_PART_NO', $pno);
        $this->db->where('CHR_BACK_NO', $bno);
        $this->db->update($this->tabel, $data);
    }

    function get_data_by_id($pno, $bno)
    {
        return $this->db->query("SELECT * FROM $this->tabel WHERE CHR_PART_NO = '$pno' AND CHR_BACK_NO='$bno'")->row();
    }

    function get_trolley_id($id)
    {
        return $this->db->query("SELECT * FROM $this->tabel1 WHERE CHR_TROLLEY_ID = '$id'")->row();
    }

    function get_data_elina()
    {
        $data =  $this->db->query("SELECT * FROM PRD.TT_ELINA_H WHERE (CHR_FLAG = '1') order by CHR_DATE_ORDER desc, CHR_TIME_ORDER desc")->result();
        return $data;
    }

    function reexplode($id, $prdno)
    {
        $del_h = "DELETE FROM PRD.TT_ELINA_H WHERE INT_ID = '$id'";
        $this->db->query($del_h);
        $del_l = "DELETE FROM PRD.TT_ELINA_L WHERE CHR_PRD_ORDER_NO = '$prdno'";
        $this->db->query($del_l);

        $data = array(
            'CHR_STATUS_BOM' => '0',
        );

        $this->db->where('CHR_PRD_ORDER_NO', $prdno);
        $this->db->update('PRD.TT_SETUP_CHUTE', $data);
    }

    function get_data_temp()
    {
        return $this->db->query("SELECT * FROM $this->temp_tabel WHERE CHR_FLAG_STATUS = 'F'")->result();
    }

    function get_status_data_temp()
    {
        $status = $this->db->query("SELECT * FROM $this->temp_tabel");

        if ($status->num_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    function save_temp($data)
    {
        $this->db->insert($this->temp_tabel, $data);
    }

    function save_troll($data_tr)
    {
        $this->db->insert($this->tabel1, $data_tr);
    }

    function truncate_temp_data()
    {
        $this->db->query("truncate table $this->temp_tabel");
    }

    function get_all_partno()
    {
        return $query = $this->db->query("SELECT DISTINCT CHR_PART_NO FROM TM_KANBAN WHERE CHR_KANBAN_TYPE='0' ORDER BY CHR_PART_NO ASC")->result();
    }

    function get_all_backno()
    {
        return $query = $this->db->query("SELECT DISTINCT CHR_BACK_NO FROM TM_KANBAN WHERE CHR_KANBAN_TYPE='0' ORDER BY CHR_BACK_NO ASC")->result();
    }

    function save_dt($data)
    {
        $this->db->insert($this->tabel, $data);

        //        $feedback = $data['CHR_FEEDBACK'];
        //        $created_date = $data['CHR_CREATED_DATE'];
        //        $created_time = date('H:i:s');
        //        $creator = strtoupper($data['CHR_CREATED_BY']);
        //        $wo_no = $data['CHR_WO_NUMBER'];
        //        $work_center = substr($wo_no, 0, 6);
        //        $name = explode(" ", $creator);
        //        
        //        $db_display = $this->get_db_display($work_center);
        //        
        //        $db_display->query("INSERT INTO tt_comment 
        //            (CHR_COMMENT, CHR_WO_NUMBER, CHR_USERNAME, CHR_CREATED_DATE, CHR_CREATED_TIME)
        //            VALUES
        //            ('$feedback', '$wo_no', '$name[0]', '$created_date', '$created_time' )");
    }

    function select_data_part_by($sloc)
    {
        $this->db->select("A.CHR_PART_NO,C.CHR_PART_NAME,A.CHR_BACK_NO,B.INT_QTY_PER_BOX,A.CHR_WORK_CTR,A.CHR_CAT,A.CHR_FLAG_STATUS 
                            FROM PRD.TM_PART_PER_LINE A 
                            INNER JOIN TM_KANBAN B 
                            ON A.CHR_PART_NO = B.CHR_PART_NO  
                            INNER JOIN TM_PARTS C
                            ON C.CHR_PART_NO = A.CHR_PART_NO");
        $this->db->where("B.CHR_KANBAN_TYPE='0'");
        $this->db->where_in('A.CHR_CAT', $sloc);
        $query = $this->db->get();
        return $query->result();
    }
}
