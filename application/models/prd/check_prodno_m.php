<?php

class check_prodno_m extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }
    private $tbl = 'PRD.TT_ELINA_L';
    // private $tbl_part = 'PRD.TT_ELINA_L';

    function get_data_prodno($startdate, $finishdate)
    {
        return $this->db->query("select distinct a.INT_ID,a.CHR_PRD_ORDER_NO,a.CHR_PART_NO_FG,a.CHR_BACK_NO_FG,a.INT_QTY_FG,a.CHR_WORK_CENTER,a.CHR_DATE_ORDER,a.CHR_TIME_ORDER,b.CHR_PREPARE_AREA,b.CHR_FLAG_SPOOLING
                                from PRD.TT_ELINA_H a inner join PRD.TT_ELINA_L b on a.CHR_PRD_ORDER_NO=b.CHR_PRD_ORDER_NO
                                where (a.CHR_DATE_ORDER between '$startdate' and '$finishdate')
                                and (a.CHR_FLAG between '1' and '4')  
                                order by a.CHR_DATE_ORDER desc, a.CHR_TIME_ORDER desc")->result();
    }

    function get_data_by_id($id, $area)
    {
        return $this->db->query("select distinct a.INT_ID,a.CHR_PRD_ORDER_NO,a.CHR_PART_NO_FG,a.CHR_BACK_NO_FG,a.CHR_WORK_CENTER,b.CHR_PREPARE_AREA
                                from PRD.TT_ELINA_H a inner join PRD.TT_ELINA_L b on a.CHR_PRD_ORDER_NO=b.CHR_PRD_ORDER_NO
                                where a.INT_ID='$id' and b.CHR_PREPARE_AREA='$area'")->row();
    }

    function update($data, $prodno, $area)
    {
        // $this->db->where('CHR_PART_NO', $pno);
        $this->db->where('CHR_PRD_ORDER_NO', $prodno);
        $this->db->where('CHR_PREPARE_AREA', $area);
        $this->db->update($this->tbl, $data);
        // $this->db->query("UPDATE PRD.TT_ELINA_L set                                          
        //                                 CHR_FLAG_STOCK    = 'T'
        //                            where CHR_PRD_ORDER_NO    = '$prod' and CHR_PART_NO='$pno'");

        // $cek_data = $this->db->query("select * from PRD.TT_ELINA_L a inner join TT_PARTS_SLOC b on b.CHR_PART_NO=a.CHR_PART_NO
        //                                              where a.CHR_PRD_ORDER_NO ='$prod' and b.INT_PART_QTY<=0 and b.CHR_SLOC=a.CHR_STORAGE");
        // if ($cek_data->num_rows() > 0) {

        // } else {
        //     $this->db->query("UPDATE PRD.TT_ELINA_L set                                          
        //                                 CHR_FLAG_STOCK    = 'F'
        //                            where CHR_PRD_ORDER_NO    = '$prod'");
        //     $this->db->query("UPDATE PRD.TT_ELINA_H set                                          
        //                                 CHR_FLAG    = '0'
        //                            where CHR_PRD_ORDER_NO    = '$prod'");
        // }
    }

    function update1($data, $id, $area)
    {
        $this->db->where('INT_ID', $id);
        $this->db->where('CHR_PREPARE_AREA', $area);
        $this->db->update($this->tbl, $data);
    }
}
