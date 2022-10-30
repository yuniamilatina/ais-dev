<?php

class inspection_m extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    private $tabel = 'TM_PART_SUBCONT_RM';
    private $tbl_dev = 'TM_DEVICE';
    private $tabel1 = 'TM_INSPECTION_PLAN_H';

    function select_data_all()
    {
        $dbqua = $this->load->database("dbqua", TRUE);
        return $dbqua->query("select *
                                from TM_INSPECTION_PLAN_H 
                                order by CHR_DOC_ID asc")->result();
    }

    function get_data_dev()
    {
        $dbqua = $this->load->database("dbqua", TRUE);
        return $dbqua->query("select *
                                from TM_DEVICE 
                                order by CHR_DEVICE_ID asc")->result();
    }

    function select_data_by_wc($work_center)
    {
        $dbqua = $this->load->database("dbqua", TRUE);
        return $dbqua->query("select CHR_DOC_ID,CHR_WORK_CTR,CHR_PARTNO,CHR_STAT_LIST,CHR_BACKNO,CHR_PART_NM,CHR_MODEL_NM,CHR_DRAWING_LOC,CHR_EXEC_BY,
                                CHR_INSPEC_TYPE,CHR_ISSUE_DATE,CHR_REVISED_DATE,CHR_CREATE_DATE,CHR_CHANGE_DATE,CHR_CHANGE_BY,CHR_STAT_DEL
                                from TM_INSPECTION_PLAN_H 
                                where CHR_WORK_CTR='$work_center'
                                order by CHR_DOC_ID asc")->result();
    }

    function select_data_by_id($id)
    {
        $dbqua = $this->load->database("dbqua", TRUE);
        return $dbqua->query("select *
                                from TM_INSPECTION_PLAN_L 
                                where CHR_DOC_ID = '$id'
                                order by CHR_SEQ asc")->result();
    }

    function check_data($partno, $line)
    {
        $dbqua = $this->load->database("dbqua", TRUE);
        $query = $dbqua->query("SELECT top 1 * FROM TM_INSPECTION_PLAN_H WHERE CHR_PARTNO = '$partno' and CHR_WORK_CTR='$line'");

        if ($query->num_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    function check_dev($devid)
    {
        $dbqua = $this->load->database("dbqua", TRUE);
        $query = $dbqua->query("SELECT top 1 * FROM TM_DEVICE WHERE CHR_DEVICE_ID = '$devid'");

        if ($query->num_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    function check_list($doc_id, $noseq)
    {
        $dbqua = $this->load->database("dbqua", TRUE);
        $query = $dbqua->query("SELECT top 1 * FROM TM_INSPECTION_PLAN_L WHERE CHR_DOC_ID = '$doc_id' and CHR_SEQ='$noseq'");

        if ($query->num_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    function cek_seq($doc_id)
    {
        $dbqua = $this->load->database("dbqua", TRUE);
        $query = $dbqua->query("SELECT max(cast(CHR_SEQ as int)) as seq_d FROM TM_INSPECTION_PLAN_L WHERE CHR_DOC_ID = '$doc_id'");

        if ($query->num_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    function cek_seq1($doc_id)
    {
        $dbqua = $this->load->database("dbqua", TRUE);
        $query = $dbqua->query("SELECT max(cast(CHR_SEQ as int)) as seq_d FROM TM_INSPECTION_PLAN_L WHERE CHR_DOC_ID = '$doc_id'");

        if ($query->num_rows() > 0) {
            $data = $query->row_array();
            $seq_d = $data['seq_d'];
            return $seq_d;
        } else {
            return 0;
        }
    }

    function save_data($data)
    {
        $dbqua = $this->load->database("dbqua", TRUE);
        $dbqua->insert($this->tabel1, $data);
    }

    function save_dev($data)
    {
        $dbqua = $this->load->database("dbqua", TRUE);
        $dbqua->insert('TM_DEVICE', $data);
    }

    function save_list($data, $id)
    {
        $dbqua = $this->load->database("dbqua", TRUE);
        $dbqua->insert('TM_INSPECTION_PLAN_L', $data);
        $dbqua->query("UPDATE TM_INSPECTION_PLAN_H SET CHR_STAT_LIST = 'T' WHERE CHR_DOC_ID='$id' and CHR_STAT_LIST = 'F'");
    }

    function delete_device($int_id)
    {
        $dbqua = $this->load->database("dbqua", TRUE);
        $data = array(
            'CHR_STAT_DEL' => 'T',
        );

        $dbqua->where('INT_ID', $int_id);
        $dbqua->update($this->tbl_dev, $data);
    }

    function del_plan_h($doc_id)
    {
        $dbqua = $this->load->database("dbqua", TRUE);
        $data = array(
            'CHR_STAT_DEL' => 'T',
        );

        $dbqua->where('CHR_DOC_ID', $doc_id);
        $dbqua->update('TM_INSPECTION_PLAN_H', $data);
    }

    function delete_list_plan($doc_id, $seq)
    {
        $dbqua = $this->load->database("dbqua", TRUE);
        $data = array(
            'CHR_STAT_DEL' => 'T',
        );

        $dbqua->where('CHR_DOC_ID', $doc_id);
        $dbqua->where('CHR_SEQ', $seq);
        $dbqua->update('TM_INSPECTION_PLAN_L', $data);
    }

    function undelete_device($int_id)
    {
        $dbqua = $this->load->database("dbqua", TRUE);
        $data = array(
            'CHR_STAT_DEL' => 'F',
        );

        $dbqua->where('INT_ID', $int_id);
        $dbqua->update($this->tbl_dev, $data);
    }

    function undel_plan_h($doc_id)
    {
        $dbqua = $this->load->database("dbqua", TRUE);
        $data = array(
            'CHR_STAT_DEL' => 'F',
        );

        $dbqua->where('CHR_DOC_ID', $doc_id);
        $dbqua->update('TM_INSPECTION_PLAN_H', $data);
    }

    function undelete_list_plan($doc_id, $seq)
    {
        $dbqua = $this->load->database("dbqua", TRUE);
        $data = array(
            'CHR_STAT_DEL' => 'F',
        );

        $dbqua->where('CHR_DOC_ID', $doc_id);
        $dbqua->where('CHR_SEQ', $seq);
        $dbqua->update('TM_INSPECTION_PLAN_L', $data);
    }

    function get_list_qcwis_by_part($partno)
    {
        $dbqua = $this->load->database("dbqua", TRUE);
        $query = $dbqua->query("select distinct b.*
                    from  TM_INSPECTION_PLAN_H a inner join TM_INSPECTION_PLAN_L b
                    on a.CHR_DOC_ID=b.CHR_DOC_ID
                    where a.CHR_PARTNO='$partno'");
        return $query->result();
    }

    function get_partnm($partno)
    {
        $query = $this->db->query("select distinct CHR_PART_NAME
                                from TM_PARTS
                                where CHR_PART_NO='$partno'");
        if ($query->num_rows() > 0) {
            $data = $query->row_array();
            $partnm = $data['CHR_PART_NAME'];
            return $partnm;
        } else {
            return 0;
        }
    }

    function get_backno($partno)
    {
        $query = $this->db->query("select distinct CHR_BACK_NO
                                from TM_KANBAN
                                where CHR_PART_NO='$partno'");
        if ($query->num_rows() > 0) {
            $data = $query->row_array();
            $backno = $data['CHR_BACK_NO'];
            return $backno;
        } else {
            return 0;
        }
    }

    function get_data($id)
    {
        $dbqua = $this->load->database("dbqua", TRUE);
        $query = $dbqua->query("SELECT TOP(1) * FROM TM_INSPECTION_PLAN_H WHERE CHR_DOC_ID = '$id'");

        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return 0;
        }
    }

    function get_id_dev($id)
    {
        $dbqua = $this->load->database("dbqua", TRUE);
        $query = $dbqua->query("SELECT TOP(1) * FROM TM_DEVICE WHERE INT_ID = '$id'");

        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return 0;
        }
    }

    function get_list_data($id, $seq)
    {
        $dbqua = $this->load->database("dbqua", TRUE);
        $query = $dbqua->query("SELECT TOP(1) * FROM TM_INSPECTION_PLAN_L WHERE CHR_DOC_ID = '$id' and CHR_SEQ='$seq'");

        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return 0;
        }
    }

    function edit_data($data, $id)
    {
        $dbqua = $this->load->database("dbqua", TRUE);
        $dbqua->where('CHR_DOC_ID', $id);
        $dbqua->update('TM_INSPECTION_PLAN_H', $data);
    }

    function edit_dev($data, $id)
    {
        $dbqua = $this->load->database("dbqua", TRUE);
        $dbqua->where('INT_ID', $id);
        $dbqua->update('TM_DEVICE', $data);
    }

    function edit_list_data($data, $id, $seq)
    {
        $dbqua = $this->load->database("dbqua", TRUE);
        $dbqua->where('CHR_DOC_ID', $id);
        $dbqua->where('CHR_SEQ', $seq);
        $dbqua->update('TM_INSPECTION_PLAN_L', $data);
    }

    function get_uom()
    {
        $dbqua = $this->load->database("dbqua", TRUE);
        $query = $dbqua->query("SELECT CHR_UOM FROM TM_UOM ORDER BY INT_ID ASC");
        return $query->result();
    }

    function get_device()
    {
        $dbqua = $this->load->database("dbqua", TRUE);
        $query = $dbqua->query("SELECT INT_ID,CHR_DEVICE_ID,CHR_DEVICE_NAME FROM TM_DEVICE where CHR_STAT_DEL='F'");
        return $query->result();
    }

    function get_act_fg($part_no, $mon_now)
    {
        // $dbqua = $this->load->database("dbqua", TRUE);
        $sql = "select a.CHR_PART_NO,sum(a.INT_TOTAL_QTY) as INT_TOTAL_QTY,sum(a.INT_ACTUAL_DEL) as INT_ACTUAL_DEL
                FROM TT_DELIVERY_ITEM a 
                inner join TT_DELIVERY b on a.CHR_DEL_NO=b.CHR_DEL_NO
                WHERE (a.CHR_PART_NO = '$part_no') and b.CHR_CREATE_DATE like 'mon_now%' 
                and a.CHR_DELETE_FLAG is null group by a.CHR_PART_NO";

        return $this->db->query($sql)->row();
    }

    function get_month()
    {
        $query = $this->db->query("select distinct CHR_MONTH from TT_WO_CUST");
        return $query->result();
    }

    public function get_data_all_wo($FILTER)
    {
        $mrp_d = $this->load->database("mrp_d", TRUE);
        $query = $mrp_d->query("SELECT * FROM TT_WO_CUST where CHR_MONTH like '%" . $FILTER . "%' or CHR_PARTNO_CUST like '%" . $FILTER . "%' or CHR_PARTNO_AII like '%" . $FILTER . "%' or CHR_PART_NAME like '%" . $FILTER . "%' or CHR_CUST_NAME like '%" . $FILTER . "%'");
        return $query->result();
    }

    public function get_data_wo($partno, $mon_now)
    {
        $query = $this->db->query("SELECT * FROM TT_WO_CUST where CHR_MONTH like '%" . $mon_now . "%' and CHR_PARTNO_AII like '%" . $partno . "%' ");
        return $query->result();
    }

    public function get_data_all_wo_per_month($CHR_MONTH, $CHR_VERSION, $FILTER)
    {
        $mrp_d = $this->load->database("mrp_d", TRUE);
        $query = $mrp_d->query("SELECT * FROM TT_WO_CUST 
                where CHR_MONTH='$CHR_MONTH' and CHR_VERSION='$CHR_VERSION' and 
                (CHR_PARTNO_CUST like '%" . $FILTER . "%' or CHR_PARTNO_AII like '%" . $FILTER . "%' 
                or CHR_PART_NAME like '%" . $FILTER . "%' or CHR_CUST_NAME like '%" . $FILTER . "%')");
        return $query->result();
    }

    public function get_all_part_cust($month)
    {
        // $mssql = $this->load->database("mssql", TRUE);
        // $query = $this->db->query("SELECT a.*,b.CHR_PART_NAME,c.CHR_CUST_NAME FROM TM_SHIPPING_PARTS a inner join TM_PARTS b on a.CHR_PART_NO=b.CHR_PART_NO 
        //                         inner join TM_CUST c on c.CHR_CUST_NO=a.CHR_CUS_NO where c.CHR_DIS_CHANNEL=a.CHR_DIS_CHANNEL and (a.CHR_PART_NO like '%321%' or a.CHR_PART_NO like '%312%') order by a.CHR_CUS_NO asc");
        $query = $this->db->query("SELECT distinct a.CHR_DIS_CHANNEL,a.CHR_CUS_NO,a.CHR_PART_NO,d.CHR_BACK_NO,a.CHR_CUS_PART_NO,b.CHR_PART_NAME,
                                    c.CHR_CUST_NAME,e.INT_N,e.INT_N1,e.INT_N2,e.INT_N3,e.INT_N4,e.INT_N5,e.INT_N6,e.INT_TOTAL,h.INT_TOTAL_QTY,h.INT_ACTUAL_DEL,i.AKTUAL_PROD  
                                    FROM TM_SHIPPING_PARTS a inner join TM_PARTS b on a.CHR_PART_NO=b.CHR_PART_NO 
                                    inner join TM_CUST c on c.CHR_CUST_NO=a.CHR_CUS_NO 
                                    inner join TM_KANBAN d on d.CHR_PART_NO=b.CHR_PART_NO
                                    inner join TT_WO_CUST e on e.CHR_PARTNO_AII=a.CHR_PART_NO
                                    inner join (select f.CHR_PART_NO,sum(f.INT_TOTAL_QTY) as INT_TOTAL_QTY,sum(f.INT_ACTUAL_DEL) as INT_ACTUAL_DEL 
                                                FROM TT_DELIVERY_ITEM f inner join TT_DELIVERY g on f.CHR_DEL_NO=g.CHR_DEL_NO
                                                WHERE g.CHR_CREATE_DATE like '$month%' and f.CHR_DELETE_FLAG is null
                                                group by f.CHR_PART_NO) h on h.CHR_PART_NO=a.CHR_PART_NO
                                    inner join (select CHR_PART_NO,sum(INT_TOTAL_QTY) as AKTUAL_PROD from TT_PRODUCTION_RESULT 
			                                    where CHR_DATE like '$month%' group by CHR_PART_NO) i on i.CHR_PART_NO=a.CHR_PART_NO
                                    where a.CHR_CUS_PART_NO<>'' and c.CHR_DIS_CHANNEL=a.CHR_DIS_CHANNEL 
                                    and (a.CHR_PART_NO like '321%' or a.CHR_PART_NO like '-321%' or a.CHR_PART_NO like '312%' or a.CHR_PART_NO like '-312%') 
                                    and d.CHR_KANBAN_TYPE='5' and c.CHR_CUST_NAME not like 'other%' and a.CHR_CUS_NO not like '01%' order by a.CHR_CUS_NO asc");
        return $query->result();
    }

    function select_data_by_dept_and_work_center($startdate, $finishdate, $workctr)
    {
        $stored_procedure = "EXEC PPC.zsp_get_stock_kanban_fg ?,?,?";
        $param = array(
            'workctr' => $workctr,
            'date_awal' => $startdate,
            'date_akhir' => $finishdate
        );

        $query = $this->db->query($stored_procedure, $param);

        return $query->result();
        //        return $this->db->query("select a.CHR_PART_NO,a.CHR_BACK_NO,COUNT(a.CHR_BACK_NO) as scan_ord,a.CHR_DATE_ENTRY,
        //                                    a.CHR_PROD_LINE,a.CHR_LAST_TIME,b.INT_QTY_PER_BOX 
        //                                    from TT_SETUP_CHUTE_L AS a inner join TM_KANBAN as b on a.CHR_ID_KBN=b.INT_KANBAN_NO
        //                                    where a.CHR_DATE_ENTRY between '$startdate' and '$finishdate' and a.CHR_PROD_LINE='$workctr'
        //                                    group by a.CHR_PART_NO,a.CHR_BACK_NO,a.CHR_DATE_ENTRY,a.CHR_PROD_LINE,a.CHR_LAST_TIME,b.INT_QTY_PER_BOX
        //                                    order by a.CHR_LAST_TIME asc")->result();
    }

    function get_all_work_center_by_dept($dept_crop)
    {
        if ($dept_crop == '011' || $dept_crop == '012' || $dept_crop == '013' || $dept_crop == '014') {
            $query = $this->db->query("select DISTINCT(CHR_WORK_CENTER) FROM TM_PROCESS_PARTS WHERE CHR_PERSON_RESPONSIBLE = $dept_crop ORDER BY CHR_WORK_CENTER");
        } else {
            $query = $this->db->query("select DISTINCT(CHR_WORK_CENTER) FROM TM_PROCESS_PARTS ORDER BY CHR_WORK_CENTER");
        }

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return 0;
        }
    }

    function get_top_work_center_by_dept($dept_crop)
    {
        if ($dept_crop == '011' || $dept_crop == '012' || $dept_crop == '013' || $dept_crop == '014') {
            $query = $this->db->query("select TOP(1) PR.CHR_WORK_CENTER from  TT_PRODUCTION_RESULT PR INNER JOIN 
					TM_PROCESS_PARTS PP ON PR.CHR_WORK_CENTER = PP.CHR_WORK_CENTER AND PR.CHR_PART_NO = PP.CHR_PART_NO AND PP.CHR_PERSON_RESPONSIBLE = $dept_crop
					ORDER BY PR.CHR_WORK_CENTER");
        } else {
            $query = $this->db->query("select TOP(1) PR.CHR_WORK_CENTER from  TT_PRODUCTION_RESULT PR INNER JOIN 
					TM_PROCESS_PARTS PP ON PR.CHR_WORK_CENTER = PP.CHR_WORK_CENTER AND PR.CHR_PART_NO = PP.CHR_PART_NO
					ORDER BY PR.CHR_WORK_CENTER");
        }

        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return 0;
        }
    }

    function delete_backno_subcont($id)
    {
        $data = array(
            'BIT_FLG_DEL' => 1,
        );

        $this->db->where('INT_ID', $id);
        $this->db->update($this->tabel, $data);
    }

    function truncate_temp_data()
    {
        $this->db->query("truncate table TW_REPORT_WH00");
    }

    function get_temp_data_upload_result_raw_material_by_date($date)
    {
        $query = $this->db->query("select CHR_PART_NUMBER,
                                CHR_PERIODE,
                                LEFT(CHR_PERIODE,6) as CHR_PERIODE_TT,
                                CHR_AREA,
                                CASE $date 
                                        WHEN 1 THEN INT_GR_RM_1
                                        WHEN 2 THEN INT_GR_RM_2
                                        WHEN 3 THEN INT_GR_RM_3
                                        WHEN 4 THEN INT_GR_RM_4
                                        WHEN 5 THEN INT_GR_RM_5
                                        WHEN 6 THEN INT_GR_RM_6
                                        WHEN 7 THEN INT_GR_RM_7
                                        WHEN 8 THEN INT_GR_RM_8
                                        WHEN 9 THEN INT_GR_RM_9
                                        WHEN 10 THEN INT_GR_RM_10
                                        WHEN 11 THEN INT_GR_RM_11
                                        WHEN 12 THEN INT_GR_RM_12
                                        WHEN 13 THEN INT_GR_RM_13
                                        WHEN 14 THEN INT_GR_RM_14
                                        WHEN 15 THEN INT_GR_RM_15
                                        WHEN 16 THEN INT_GR_RM_16
                                        WHEN 17 THEN INT_GR_RM_17
                                        WHEN 18 THEN INT_GR_RM_18
                                        WHEN 19 THEN INT_GR_RM_19
                                        WHEN 20 THEN INT_GR_RM_20
                                        WHEN 21 THEN INT_GR_RM_21
                                        WHEN 22 THEN INT_GR_RM_22
                                        WHEN 23 THEN INT_GR_RM_23
                                        WHEN 24 THEN INT_GR_RM_24
                                        WHEN 25 THEN INT_GR_RM_25
                                        WHEN 26 THEN INT_GR_RM_26
                                        WHEN 27 THEN INT_GR_RM_27
                                        WHEN 28 THEN INT_GR_RM_28
                                        WHEN 29 THEN INT_GR_RM_29
                                        WHEN 30 THEN INT_GR_RM_30
                                        ELSE INT_GR_RM_31 END AS INT_GR_RM,
                                CASE $date	
                                        WHEN 1 THEN INT_MOVE_RM_1
                                        WHEN 2 THEN INT_MOVE_RM_2
                                        WHEN 3 THEN INT_MOVE_RM_3
                                        WHEN 4 THEN INT_MOVE_RM_4
                                        WHEN 5 THEN INT_MOVE_RM_5
                                        WHEN 6 THEN INT_MOVE_RM_6
                                        WHEN 7 THEN INT_MOVE_RM_7
                                        WHEN 8 THEN INT_MOVE_RM_8
                                        WHEN 9 THEN INT_MOVE_RM_9
                                        WHEN 10 THEN INT_MOVE_RM_10
                                        WHEN 11 THEN INT_MOVE_RM_11
                                        WHEN 12 THEN INT_MOVE_RM_12
                                        WHEN 13 THEN INT_MOVE_RM_13
                                        WHEN 14 THEN INT_MOVE_RM_14
                                        WHEN 15 THEN INT_MOVE_RM_15
                                        WHEN 16 THEN INT_MOVE_RM_16
                                        WHEN 17 THEN INT_MOVE_RM_17
                                        WHEN 18 THEN INT_MOVE_RM_18
                                        WHEN 19 THEN INT_MOVE_RM_19
                                        WHEN 20 THEN INT_MOVE_RM_20
                                        WHEN 21 THEN INT_MOVE_RM_21
                                        WHEN 22 THEN INT_MOVE_RM_22
                                        WHEN 23 THEN INT_MOVE_RM_23
                                        WHEN 24 THEN INT_MOVE_RM_24
                                        WHEN 25 THEN INT_MOVE_RM_25
                                        WHEN 26 THEN INT_MOVE_RM_26
                                        WHEN 27 THEN INT_MOVE_RM_27
                                        WHEN 28 THEN INT_MOVE_RM_28
                                        WHEN 29 THEN INT_MOVE_RM_29
                                        WHEN 30 THEN INT_MOVE_RM_30
                                        ELSE INT_MOVE_RM_31 END AS INT_MOVE_RM,
                                INT_SALDO_AKHIR_RM 
                            from TW_REPORT_WH00");
        return $query->result();
    }

    function check_existence_temp_data()
    {
        $query = $this->db->query("select top 1 1
                                    from TW_REPORT_WH00");

        if ($query->num_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    function check_existence_data_temp_raw_material_by_period($period)
    {
        $query = $this->db->query("select 1
                                    from TW_REPORT_WH00
                                    where CHR_PERIODE = $period");

        if ($query->num_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    function check_existence_part_number_raw_material_by_part_number($part_no)
    {
        $part_number_string = "'" . $part_no . "'";

        $query = $this->db->query("select 1
                            from TW_REPORT_WH00
                            where CHR_PART_NUMBER = $part_number_string");

        if ($query->num_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    function check_existence_data_raw_material_by_period_and_part_no($period, $part_no)
    {
        $part_number_string = "'" . $part_no . "'";

        $query = $this->db->query("select top 1 1
                            from TT_REPORT_WH00
                            where CHR_PART_NUMBER = $part_number_string AND CHR_PERIODE = $period");

        if ($query->num_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    function check_existence_data_raw_material_by_period_and_part_no_and_date($period, $part_no, $date)
    {
        $part_number_string = "'" . $part_no . "'";

        $query = $this->db->query("select INT_ID_WH00, INT_GR_RM_$date as INT_GR_RM, INT_MOVE_RM_$date as INT_MOVE_RM, INT_SALDO_AKHIR_RM
                            from TT_REPORT_WH00
                            where CHR_PART_NUMBER = $part_number_string AND CHR_PERIODE = $period");

        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return 0;
        }
    }

    //    function update_qty_data_raw_material_by_id_and_period_and_part_no_and_date($id, $gr_rm, $move_rm, $period, $part_no, $date){
    //        $this->db->query("UPDATE TT_REPORT_WH00
    //                        SET INT_GR_RM_$date = $gr_rm, INT_MOVE_RM_$date = $move_rm
    //                        FROM TT_REPORT_WH00 WHERE INT_ID_WH00 = $id AND CHR_PERIODE = $period AND CHR_PART_NUMBER = $part_no");
    //    }
    //update tabel tt report wh00
    function update_qty_data_raw_material_by_id_and_period_and_part_number_and_date($id, $period, $part_no, $qty_gr_rm, $qty_move_rm, $qty_saldo_rm, $date)
    {
        $part_number_string = "'" . $part_no . "'";

        $query = $this->db->query("UPDATE TT_REPORT_WH00
                        SET INT_GR_RM_$date = $qty_gr_rm, INT_MOVE_RM_$date = $qty_move_rm, INT_SALDO_AKHIR_RM = $qty_saldo_rm
                        FROM TT_REPORT_WH00 WHERE INT_ID_WH00 = $id AND CHR_PERIODE = $period AND CHR_PART_NUMBER = $part_number_string");

        if ($query == 1) {
            return 1;
        } else {
            return 0;
        }
    }

    function save_temp_data_to_data_raw_material($data)
    {
        $query = $this->db->insert('TT_REPORT_WH00', $data);

        if ($query == 1) {
            return 1;
        } else {
            return 0;
        }
    }

    function save_temp_data_raw_material($data)
    {
        $query = $this->db->insert('TW_REPORT_WH00', $data);

        $this->db->_error_message();
        $this->db->_error_number();

        if ($query == 1) {
            return 1;
        } else {
            return 0;
        }
    }

    function merge_report_raw_material_by_period($date)
    {
        $query_check_exist = $this->db->query("SELECT TOP 1 1 
                                                        FROM TT_REPORT_WH00 TT INNER JOIN TW_REPORT_WH00 TW 
                                                        ON TT.CHR_PERIODE = LEFT(TW.CHR_PERIODE,6) AND TT.CHR_PART_NUMBER = TW.CHR_PART_NUMBER");

        if ($query_check_exist->num_rows() > 0) {
            $date_if = explode('.', $date);
            $date_if_if = intval($date_if[2]);

            $this->db->query("UPDATE TT 
							SET	TT.INT_GR_RM_$date_if_if = TW.INT_GR_RM_$date_if_if, TT.INT_MOVE_RM_$date_if_if = TW.INT_MOVE_RM_$date_if_if 
							FROM TT_REPORT_WH00 TT INNER JOIN TW_REPORT_WH00 TW 
								ON TT.CHR_PERIODE = LEFT(TW.CHR_PERIODE,6) AND TT.CHR_PART_NUMBER = TW.CHR_PART_NUMBER");
        } else {
            $this->db->query("INSERT INTO TT_REPORT_WH00 (CHR_PART_NUMBER, CHR_PERIODE, CHR_SLOC, CHR_AREA, 
												INT_GR_RM_1,
												INT_GR_RM_2,
												INT_GR_RM_3,
												INT_GR_RM_4,
												INT_GR_RM_5,
												INT_GR_RM_6,
												INT_GR_RM_7,
												INT_GR_RM_8,
												INT_GR_RM_9,
												INT_GR_RM_10,
												INT_GR_RM_11,
												INT_GR_RM_12,
												INT_GR_RM_13,
												INT_GR_RM_14,
												INT_GR_RM_15,
												INT_GR_RM_16,
												INT_GR_RM_17,
												INT_GR_RM_18,
												INT_GR_RM_19,
												INT_GR_RM_20,
												INT_GR_RM_21,
												INT_GR_RM_22,
												INT_GR_RM_23,
												INT_GR_RM_24,
												INT_GR_RM_25,
												INT_GR_RM_26,
												INT_GR_RM_27,
												INT_GR_RM_28,
												INT_GR_RM_29,
												INT_GR_RM_30,
												INT_GR_RM_31,
												INT_MOVE_RM_1,
												INT_MOVE_RM_2,
												INT_MOVE_RM_3,
												INT_MOVE_RM_4,
												INT_MOVE_RM_5,
												INT_MOVE_RM_6,
												INT_MOVE_RM_7,
												INT_MOVE_RM_8,
												INT_MOVE_RM_9,
												INT_MOVE_RM_10,
												INT_MOVE_RM_11,
												INT_MOVE_RM_12,
												INT_MOVE_RM_13,
												INT_MOVE_RM_14,
												INT_MOVE_RM_15,
												INT_MOVE_RM_16,
												INT_MOVE_RM_17,
												INT_MOVE_RM_18,
												INT_MOVE_RM_19,
												INT_MOVE_RM_20,
												INT_MOVE_RM_21,
												INT_MOVE_RM_22,
												INT_MOVE_RM_23,
												INT_MOVE_RM_24,
												INT_MOVE_RM_25,
												INT_MOVE_RM_26,
												INT_MOVE_RM_27,
												INT_MOVE_RM_28,
												INT_MOVE_RM_29,
												INT_MOVE_RM_30,
												INT_MOVE_RM_31,
												INT_SALDO_AKHIR_RM
											)
											SELECT CHR_PART_NUMBER, LEFT(CHR_PERIODE, 6) , CHR_SLOC, CHR_AREA, 
												INT_GR_RM_1,
												INT_GR_RM_2,
												INT_GR_RM_3,
												INT_GR_RM_4,
												INT_GR_RM_5,
												INT_GR_RM_6,
												INT_GR_RM_7,
												INT_GR_RM_8,
												INT_GR_RM_9,
												INT_GR_RM_10,
												INT_GR_RM_11,
												INT_GR_RM_12,
												INT_GR_RM_13,
												INT_GR_RM_14,
												INT_GR_RM_15,
												INT_GR_RM_16,
												INT_GR_RM_17,
												INT_GR_RM_18,
												INT_GR_RM_19,
												INT_GR_RM_20,
												INT_GR_RM_21,
												INT_GR_RM_22,
												INT_GR_RM_23,
												INT_GR_RM_24,
												INT_GR_RM_25,
												INT_GR_RM_26,
												INT_GR_RM_27,
												INT_GR_RM_28,
												INT_GR_RM_29,
												INT_GR_RM_30,
												INT_GR_RM_31,
												INT_MOVE_RM_1,
												INT_MOVE_RM_2,
												INT_MOVE_RM_3,
												INT_MOVE_RM_4,
												INT_MOVE_RM_5,
												INT_MOVE_RM_6,
												INT_MOVE_RM_7,
												INT_MOVE_RM_8,
												INT_MOVE_RM_9,
												INT_MOVE_RM_10,
												INT_MOVE_RM_11,
												INT_MOVE_RM_12,
												INT_MOVE_RM_13,
												INT_MOVE_RM_14,
												INT_MOVE_RM_15,
												INT_MOVE_RM_16,
												INT_MOVE_RM_17,
												INT_MOVE_RM_18,
												INT_MOVE_RM_19,
												INT_MOVE_RM_20,
												INT_MOVE_RM_21,
												INT_MOVE_RM_22,
												INT_MOVE_RM_23,
												INT_MOVE_RM_24,
												INT_MOVE_RM_25,
												INT_MOVE_RM_26,
												INT_MOVE_RM_27,
												INT_MOVE_RM_28,
												INT_MOVE_RM_29,
												INT_MOVE_RM_30,
												INT_MOVE_RM_31,
												INT_SALDO_AKHIR_RM 
											FROM TW_REPORT_WH00");
        }
    }

    function get_temp_data_period()
    {
        $query = $this->db->query("select CHR_PERIODE
                                    from TW_REPORT_WH00");

        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return 0;
        }
    }

    function select_data_report_wh00_part_by_period($period)
    {

        $query = $this->db->query("select 
	WH00.INT_GR_RM_1 - WH00.INT_GR_SAP_1 as INT_GR_DIFF_1, 
	WH00.INT_GR_RM_2 - WH00.INT_GR_SAP_2 as INT_GR_DIFF_2, 
	WH00.INT_GR_RM_3 - WH00.INT_GR_SAP_3 as INT_GR_DIFF_3, 
	WH00.INT_GR_RM_4 - WH00.INT_GR_SAP_4 as INT_GR_DIFF_4, 
	WH00.INT_GR_RM_5 - WH00.INT_GR_SAP_5 as INT_GR_DIFF_5, 
	WH00.INT_GR_RM_6 - WH00.INT_GR_SAP_6 as INT_GR_DIFF_6, 
	WH00.INT_GR_RM_7 - WH00.INT_GR_SAP_7 as INT_GR_DIFF_7, 
	WH00.INT_GR_RM_8 - WH00.INT_GR_SAP_8 as INT_GR_DIFF_8, 
	WH00.INT_GR_RM_9 - WH00.INT_GR_SAP_9 as INT_GR_DIFF_9, 
	WH00.INT_GR_RM_10 - WH00.INT_GR_SAP_10 as INT_GR_DIFF_10, 
	WH00.INT_GR_RM_11 - WH00.INT_GR_SAP_11 as INT_GR_DIFF_11, 
	WH00.INT_GR_RM_12 - WH00.INT_GR_SAP_12 as INT_GR_DIFF_12, 
	WH00.INT_GR_RM_13 - WH00.INT_GR_SAP_13 as INT_GR_DIFF_13, 
	WH00.INT_GR_RM_14 - WH00.INT_GR_SAP_14 as INT_GR_DIFF_14, 
	WH00.INT_GR_RM_15 - WH00.INT_GR_SAP_15 as INT_GR_DIFF_15, 
	WH00.INT_GR_RM_16 - WH00.INT_GR_SAP_16 as INT_GR_DIFF_16, 
	WH00.INT_GR_RM_17 - WH00.INT_GR_SAP_17 as INT_GR_DIFF_17, 
	WH00.INT_GR_RM_18 - WH00.INT_GR_SAP_18 as INT_GR_DIFF_18, 
	WH00.INT_GR_RM_19 - WH00.INT_GR_SAP_19 as INT_GR_DIFF_19, 
	WH00.INT_GR_RM_20 - WH00.INT_GR_SAP_20 as INT_GR_DIFF_20, 
	WH00.INT_GR_RM_21 - WH00.INT_GR_SAP_21 as INT_GR_DIFF_21, 
	WH00.INT_GR_RM_22 - WH00.INT_GR_SAP_22 as INT_GR_DIFF_22, 
	WH00.INT_GR_RM_23 - WH00.INT_GR_SAP_23 as INT_GR_DIFF_23, 
	WH00.INT_GR_RM_24 - WH00.INT_GR_SAP_24 as INT_GR_DIFF_24, 
	WH00.INT_GR_RM_25 - WH00.INT_GR_SAP_25 as INT_GR_DIFF_25, 
	WH00.INT_GR_RM_26 - WH00.INT_GR_SAP_26 as INT_GR_DIFF_26, 
	WH00.INT_GR_RM_27 - WH00.INT_GR_SAP_27 as INT_GR_DIFF_27, 
	WH00.INT_GR_RM_28 - WH00.INT_GR_SAP_28 as INT_GR_DIFF_28, 
	WH00.INT_GR_RM_29 - WH00.INT_GR_SAP_29 as INT_GR_DIFF_29, 
	WH00.INT_GR_RM_30 - WH00.INT_GR_SAP_30 as INT_GR_DIFF_30, 
	WH00.INT_GR_RM_31 - WH00.INT_GR_SAP_31 as INT_GR_DIFF_31, 
	
	WH00.INT_MOVE_RM_1 - WH00.INT_MOVE_SAP_1 as INT_MOVE_DIFF_1, 
	WH00.INT_MOVE_RM_2 - WH00.INT_MOVE_SAP_2 as INT_MOVE_DIFF_2, 
	WH00.INT_MOVE_RM_3 - WH00.INT_MOVE_SAP_3 as INT_MOVE_DIFF_3, 
	WH00.INT_MOVE_RM_4 - WH00.INT_MOVE_SAP_4 as INT_MOVE_DIFF_4, 
	WH00.INT_MOVE_RM_5 - WH00.INT_MOVE_SAP_5 as INT_MOVE_DIFF_5, 
	WH00.INT_MOVE_RM_6 - WH00.INT_MOVE_SAP_6 as INT_MOVE_DIFF_6, 
	WH00.INT_MOVE_RM_7 - WH00.INT_MOVE_SAP_7 as INT_MOVE_DIFF_7, 
	WH00.INT_MOVE_RM_8 - WH00.INT_MOVE_SAP_8 as INT_MOVE_DIFF_8, 
	WH00.INT_MOVE_RM_9 - WH00.INT_MOVE_SAP_9 as INT_MOVE_DIFF_9, 
	WH00.INT_MOVE_RM_10 - WH00.INT_MOVE_SAP_10 as INT_MOVE_DIFF_10, 
	WH00.INT_MOVE_RM_11 - WH00.INT_MOVE_SAP_11 as INT_MOVE_DIFF_11, 
	WH00.INT_MOVE_RM_12 - WH00.INT_MOVE_SAP_12 as INT_MOVE_DIFF_12, 
	WH00.INT_MOVE_RM_13 - WH00.INT_MOVE_SAP_13 as INT_MOVE_DIFF_13, 
	WH00.INT_MOVE_RM_14 - WH00.INT_MOVE_SAP_14 as INT_MOVE_DIFF_14, 
	WH00.INT_MOVE_RM_15 - WH00.INT_MOVE_SAP_15 as INT_MOVE_DIFF_15, 
	WH00.INT_MOVE_RM_16 - WH00.INT_MOVE_SAP_16 as INT_MOVE_DIFF_16, 
	WH00.INT_MOVE_RM_17 - WH00.INT_MOVE_SAP_17 as INT_MOVE_DIFF_17, 
	WH00.INT_MOVE_RM_18 - WH00.INT_MOVE_SAP_18 as INT_MOVE_DIFF_18, 
	WH00.INT_MOVE_RM_19 - WH00.INT_MOVE_SAP_19 as INT_MOVE_DIFF_19, 
	WH00.INT_MOVE_RM_20 - WH00.INT_MOVE_SAP_20 as INT_MOVE_DIFF_20, 
	WH00.INT_MOVE_RM_21 - WH00.INT_MOVE_SAP_21 as INT_MOVE_DIFF_21, 
	WH00.INT_MOVE_RM_22 - WH00.INT_MOVE_SAP_22 as INT_MOVE_DIFF_22, 
	WH00.INT_MOVE_RM_23 - WH00.INT_MOVE_SAP_23 as INT_MOVE_DIFF_23, 
	WH00.INT_MOVE_RM_24 - WH00.INT_MOVE_SAP_24 as INT_MOVE_DIFF_24, 
	WH00.INT_MOVE_RM_25 - WH00.INT_MOVE_SAP_25 as INT_MOVE_DIFF_25, 
	WH00.INT_MOVE_RM_26 - WH00.INT_MOVE_SAP_26 as INT_MOVE_DIFF_26, 
	WH00.INT_MOVE_RM_27 - WH00.INT_MOVE_SAP_27 as INT_MOVE_DIFF_27, 
	WH00.INT_MOVE_RM_28 - WH00.INT_MOVE_SAP_28 as INT_MOVE_DIFF_28, 
	WH00.INT_MOVE_RM_29 - WH00.INT_MOVE_SAP_29 as INT_MOVE_DIFF_29, 
	WH00.INT_MOVE_RM_30 - WH00.INT_MOVE_SAP_30 as INT_MOVE_DIFF_30, 
	WH00.INT_MOVE_RM_31 - WH00.INT_MOVE_SAP_31 as INT_MOVE_DIFF_31, 
	WH00.INT_SALDO_AKHIR_RM - WH00.INT_SALDO_AKHIR_SAP as INT_SALDO_AKHIR_DIFF,
	   WH00.*, RM.INT_CONS_1, RM.INT_CONS_2, RM.INT_CONS_3, RM.INT_CONS_4, RM.INT_CONS_5, RM.INT_CONS_6, RM.INT_CONS_7,
			   RM.INT_CONS_8, RM.INT_CONS_9, RM.INT_CONS_10, RM.INT_CONS_11, RM.INT_CONS_12, RM.INT_CONS_13, RM.INT_CONS_14,
			   RM.INT_CONS_15, RM.INT_CONS_16, RM.INT_CONS_17, RM.INT_CONS_18, RM.INT_CONS_19, RM.INT_CONS_20, RM.INT_CONS_21,
			   RM.INT_CONS_22, RM.INT_CONS_23, RM.INT_CONS_24, RM.INT_CONS_25, RM.INT_CONS_26, RM.INT_CONS_27, RM.INT_CONS_28,
			   RM.INT_CONS_29, RM.INT_CONS_30, RM.INT_CONS_31
			   
	from TT_REPORT_WH00 WH00 
	inner join TT_REPORT_MOVEMENT RM 
	on WH00.CHR_PERIODE = RM.CHR_PERIODE and WH00.CHR_PART_NUMBER = RM.CHR_PART_NUMBER
                                    where WH00.CHR_PERIODE = $period");

        return $query->result();
    }
}
