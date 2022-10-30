<?php

class prod_entry_m extends CI_Model {
    /* -- define  -- */

    public $db_1;
    /* private $tbl_name = "PES_TM_PART";
      private $tbl_trans = "PES_TT_PROD_RESULT";
     */
    private $tbl_name = "TM_PES_PART";
    private $tbl_trans = "TT_PES_PROD_RESULT";

    /* private $tbl_trans_aiierp = "TT_PRODUCTION_RESULT";
      private $tbl_goodsmovement_aiierp = "TT_GOODS_MOVEMENT"; */

    /* private $tbl_temp = "so_temp_freeze";
      private	$tbl_lock = "so_freeze_lock"; */

    /* -- define construct -- */

    public function __construct() {
        parent::__construct();
        //$dbmssql_pes = $this->load->database();
        //$this->db_x = $this->load->database('dbmssql_erp', TRUE);
        //$active_group = 'dbmssql_pes';
        //$active_record = TRUE;
    }

    public function activeRec() {
        $this->db_x->select("*", false);
        $this->db_x->where("CHR_PART_NO = 'MA13'");
        $this->db_x->ORDER_BY("CHR_PART_NO");
        $a = $this->db_x->get("TT_PURCHASE_ORDER_L")->result();
        return $a;
    }

    /* -- define method-method -- */

    public function findBySql($sql) {
        $db_1 = $this->load->database();

        $query = $this->db->query($sql);

        return $query->result();
    }

    public function exeBySql($sql) {
        $db_1 = $this->load->database();

        $query = $this->db->query($sql);

        //return $query->result();
    }

    /*
      public function find() {
      $this->db_1->select("*", false);

      if(!empty($where)) $this->db_1->where($where);
      if(!empty($order)) $this->db_1->order_by($order);
      if(!empty($limit)) $this->db_1->limit($limit,$start);
      if(!empty($group)) $this->db_1->group_by($group);

      if(!empty($join)&&is_array($join)){
      if(!empty($join['table']) && !empty($join['on'])) {
      $join = array($join);
      }

      foreach($join as $item){
      if(!empty($item['table']) && !empty($item['on'])) {
      if(!empty($item['pos'])){
      $this->db_1->join($item['table'],$item['on'],$item['pos']);
      }else{
      $this->db_1->join($item['table'],$item['on']);
      }
      }
      }
      }

      $a = $this->db_1->get($this->tbl_name)->result();

      return $a;
      }
     */

    public function find($select = '', $where = '', $order = '', $limit = '', $start = '0', $group = '', $join = '') {
        $db_1 = $this->load->database();

        if (!empty($select))
            $this->db->select($select, false);
        if (!empty($where))
            $this->db->where($where);
        if (!empty($order))
            $this->db->order_by($order);
        if (!empty($limit))
            $this->db->limit($limit, $start);
        if (!empty($group))
            $this->db->group_by($group);


        if (!empty($join) && is_array($join)) {
            if (!empty($join['table']) && !empty($join['on'])) {
                $join = array($join);
            }

            foreach ($join as $item) {
                if (!empty($item['table']) && !empty($item['on'])) {
                    if (!empty($item['pos'])) {
                        $this->db->join($item['table'], $item['on'], $item['pos']);
                    } else {
                        $this->db->join($item['table'], $item['on']);
                    }
                }
            }
        }

        return $this->db->get($this->tbl_name)->result();
    }

    function add($data) {
        if (is_array($data)) {
            return $this->db->insert($this->tbl_name, $data);
        }

        return false;
    }

    function batch_add($data) {
        if (is_array($data)) {
            return $this->db_1->insert_batch($this->tbl_name, $data);
        }

        return false;
    }

    public function is_exist($where = '') {
        $this->db_1->where($where);
        $this->db_1->limit('1');
        $q = $this->db_1->get($this->tbl_name);

        $data = $q->row();
        return !empty($data);
    }

    public function update($data, $where) {
        if (is_array($data)) {
            return $this->db->update($this->tbl_name, $data, $where);
        }

        return false;
    }

    public function delete($where) {
        return $this->db->delete($this->tbl_name, $where);

        return false;
    }

    public function find_trans($select = '', $where = '', $order = '', $limit = '', $start = '0', $group = '', $join = '') {
        $db_1 = $this->load->database();

        if (!empty($select))
            $this->db->select($select, false);
        if (!empty($where))
            $this->db->where($where);
        if (!empty($order))
            $this->db->order_by($order);
        if (!empty($limit))
            $this->db->limit($limit, $start);
        if (!empty($group))
            $this->db->group_by($group);

        if (!empty($join) && is_array($join)) {
            if (!empty($join['table']) && !empty($join['on'])) {
                $join = array($join);
            }

            foreach ($join as $item) {
                if (!empty($item['table']) && !empty($item['on'])) {
                    if (!empty($item['pos'])) {
                        $this->db->join($item['table'], $item['on'], $item['pos']);
                    } else {
                        $this->db->join($item['table'], $item['on']);
                    }
                }
            }
        }

        return $this->db->get($this->tbl_trans)->result();
        //return $this->db_1->get($this->tbl_name)->result();
    }

    function add_trans($data) {
        $db_1 = $this->load->database();

        if (is_array($data)) {
            return $this->db->insert($this->tbl_trans, $data);
        }

        return false;
    }

    public function update_trans($data, $where) {
        $db_1 = $this->load->database();


        if (is_array($data)) {
            return $this->db->update($this->tbl_trans, $data, $where);
        }

        return false;
    }

    function add_trans_aiierp($data) {
        if (is_array($data)) {
            return $this->db_x->insert($this->tbl_trans_aiierp, $data);
        }

        return false;
    }

    public function update_trans_aiierp($data, $where) {
        if (is_array($data)) {
            return $this->db_x->update($this->tbl_trans_aiierp, $data, $where);
        }

        return false;
    }

    function add_goodsmovement_aiierp($data) {
        if (is_array($data)) {
            return $this->db_x->insert($this->tbl_goodsmovement_aiierp, $data);
        }

        return false;
    }

    public function update_goodsmovement_aiierp($data, $where) {
        if (is_array($data)) {
            return $this->db_x->update($this->tbl_goodsmovement_aiierp, $data, $where);
        }

        return false;
    }

    public function exeBySqlAIIERP($sql) {
        $query = $this->db_x->query($sql);

        //return $query->result();
    }

    public function find_trans_aiierp($select = '', $where = '', $order = '', $limit = '', $start = '0', $group = '', $join = '') {
        if (!empty($select))
            $this->db_1->select($select, false);
        if (!empty($where))
            $this->db_1->where($where);
        if (!empty($order))
            $this->db_1->order_by($order);
        if (!empty($limit))
            $this->db_1->limit($limit, $start);
        if (!empty($group))
            $this->db_1->group_by($group);

        if (!empty($join) && is_array($join)) {
            if (!empty($join['table']) && !empty($join['on'])) {
                $join = array($join);
            }

            foreach ($join as $item) {
                if (!empty($item['table']) && !empty($item['on'])) {
                    if (!empty($item['pos'])) {
                        $this->db_1->join($item['table'], $item['on'], $item['pos']);
                    } else {
                        $this->db_1->join($item['table'], $item['on']);
                    }
                }
            }
        }

        return $this->db_x->get($this->tbl_trans_aiierp)->result();
        //return $this->db_1->get($this->tbl_name)->result();
    }

    //get all part
    function get_all_part($date, $responsibility, $shift, $w_center) {
        // if ($w_center == 'ALL') {
        //     $query = $this->db->query("SELECT TM_PROCESS_PARTS.CHR_PLANT, TM_PROCESS_PARTS.CHR_WORK_CENTER, TM_PROCESS_PARTS.CHR_TYPE , TM_PROCESS_PARTS.CHR_PART_NO, TM_PROCESS_PARTS.CHR_PV, 
        //               TM_PROCESS_PARTS.CHR_SLOC_TO, TM_PARTS.CHR_PART_NAME, TM_PARTS.CHR_PART_UOM, 
        //               ISNULL(TM_KANBAN.CHR_BACK_NO, 'Empty') AS CHR_BACK_NO,
        //               CASE 
		// 				WHEN TM_OLD_BACKNO.CHR_OLD_BACKNO = '-' THEN '-'  
		// 				WHEN TM_OLD_BACKNO.CHR_OLD_BACKNO IS NULL THEN '-' 
		// 				ELSE TM_OLD_BACKNO.CHR_OLD_BACKNO 
		// 			  END AS CHR_BACK_NO_OLD,
        //              CASE 
		// 				WHEN TM_KANBAN.CHR_BACK_NO = '-' THEN 'z'  
		// 				WHEN TM_KANBAN.CHR_BACK_NO IS NULL THEN 'z' 
		// 				ELSE TM_KANBAN.CHR_BACK_NO
		// 			  END AS CHR_BACK_NO2,
        //               ISNULL(TT_PRODUCTION_RESULT.CHR_SHIFT, 0) AS SHIFT, ISNULL(TT_PRODUCTION_RESULT.CHR_DATE, 0) AS DATE_ENTRY, 
        //               ISNULL(TT_PRODUCTION_RESULT.INT_ACTUAL, 0) AS INT_ACTUAL, ISNULL(TT_PRODUCTION_RESULT.INT_TOTAL_QTY, 0) AS TOTAL_QTY ,
        //               ISNULL(TT_PRODUCTION_RESULT.INT_NG_PRC, 0) AS INT_NG_PRC, ISNULL(TT_PRODUCTION_RESULT.INT_NG_BRKNTEST, 0) AS INT_NG_BRKNTEST,
        //               ISNULL(TT_PRODUCTION_RESULT.INT_NG_SETUP, 0) AS INT_NG_SETUP, ISNULL(TT_PRODUCTION_RESULT.INT_NG_TRIAL, 0) AS INT_NG_TRIAL,
        //               TM_PROCESS_PARTS.CHR_FLAG_DELETE
        //               FROM TM_PROCESS_PARTS INNER JOIN
        //               TM_PARTS ON TM_PROCESS_PARTS.CHR_PART_NO = TM_PARTS.CHR_PART_NO LEFT OUTER JOIN
        //               TM_KANBAN ON TM_PROCESS_PARTS.CHR_PART_NO = TM_KANBAN.CHR_PART_NO AND
        //               (TM_KANBAN.CHR_KANBAN_TYPE = '1' OR TM_KANBAN.CHR_KANBAN_TYPE = '5')
        //               LEFT OUTER JOIN
        //               TT_PRODUCTION_RESULT ON TM_PROCESS_PARTS.CHR_PART_NO = TT_PRODUCTION_RESULT.CHR_PART_NO AND 
        //               TM_PROCESS_PARTS.CHR_WORK_CENTER = TT_PRODUCTION_RESULT.CHR_WORK_CENTER
        //               AND TT_PRODUCTION_RESULT.CHR_DATE = '$date' AND TT_PRODUCTION_RESULT.CHR_SHIFT = '$shift'
        //                   left outer join TM_OLD_BACKNO
        //               on TM_PROCESS_PARTS.CHR_PART_NO = TM_OLD_BACKNO.CHR_PARTNO
        //               WHERE (TM_PROCESS_PARTS.CHR_PERSON_RESPONSIBLE = '01" . $responsibility . "')  and  ((TM_PROCESS_PARTS.CHR_FLAG_DELETE IS NULL) OR (TM_PROCESS_PARTS.CHR_FLAG_DELETE <> '1'))
        //               order by CHR_BACK_NO2 ASC ");
        // } else {
            $query = $this->db->query("SELECT TM_PROCESS_PARTS.CHR_PLANT, TM_PROCESS_PARTS.CHR_WORK_CENTER, TM_PROCESS_PARTS.CHR_TYPE , TM_PROCESS_PARTS.CHR_PART_NO, TM_PROCESS_PARTS.CHR_PV, 
                      TM_PROCESS_PARTS.CHR_SLOC_TO, TM_PARTS.CHR_PART_NAME, TM_PARTS.CHR_PART_UOM, 
                      ISNULL(TM_KANBAN.CHR_BACK_NO, 'Empty') AS CHR_BACK_NO,
                      CASE 
						WHEN TM_OLD_BACKNO.CHR_OLD_BACKNO = '-' THEN '-'  
						WHEN TM_OLD_BACKNO.CHR_OLD_BACKNO IS NULL THEN '-' 
						ELSE TM_OLD_BACKNO.CHR_OLD_BACKNO 
					  END AS CHR_BACK_NO_OLD,
                         CASE 
						WHEN TM_KANBAN.CHR_BACK_NO = '-' THEN 'z'  
						WHEN TM_KANBAN.CHR_BACK_NO IS NULL THEN 'z' 
						ELSE TM_KANBAN.CHR_BACK_NO
					  END AS CHR_BACK_NO2,
                      ISNULL(TT_PRODUCTION_RESULT.CHR_SHIFT, 0) AS SHIFT, ISNULL(TT_PRODUCTION_RESULT.CHR_DATE, 0) AS DATE_ENTRY, 
                      ISNULL(TT_PRODUCTION_RESULT.INT_ACTUAL, 0) AS INT_ACTUAL, ISNULL(TT_PRODUCTION_RESULT.INT_TOTAL_QTY, 0) AS TOTAL_QTY ,
                      ISNULL(TT_PRODUCTION_RESULT.INT_NG_PRC, 0) AS INT_NG_PRC, ISNULL(TT_PRODUCTION_RESULT.INT_NG_BRKNTEST, 0) AS INT_NG_BRKNTEST,
                      ISNULL(TT_PRODUCTION_RESULT.INT_NG_SETUP, 0) AS INT_NG_SETUP, ISNULL(TT_PRODUCTION_RESULT.INT_NG_TRIAL, 0) AS INT_NG_TRIAL,
                      TM_PROCESS_PARTS.CHR_FLAG_DELETE 
                      FROM TM_PROCESS_PARTS INNER JOIN
                      TM_PARTS ON TM_PROCESS_PARTS.CHR_PART_NO = TM_PARTS.CHR_PART_NO LEFT OUTER JOIN
                      TM_KANBAN ON TM_PROCESS_PARTS.CHR_PART_NO = TM_KANBAN.CHR_PART_NO AND
                      (TM_KANBAN.CHR_KANBAN_TYPE = '1' OR TM_KANBAN.CHR_KANBAN_TYPE = '5')
                      LEFT OUTER JOIN
                      TT_PRODUCTION_RESULT ON TM_PROCESS_PARTS.CHR_PART_NO = TT_PRODUCTION_RESULT.CHR_PART_NO AND 
                      TM_PROCESS_PARTS.CHR_WORK_CENTER = TT_PRODUCTION_RESULT.CHR_WORK_CENTER
                      AND TT_PRODUCTION_RESULT.CHR_DATE = '$date' AND TT_PRODUCTION_RESULT.CHR_SHIFT = '$shift'
                          left outer join TM_OLD_BACKNO
                      on TM_PROCESS_PARTS.CHR_PART_NO = TM_OLD_BACKNO.CHR_PARTNO
                      WHERE (TM_PROCESS_PARTS.CHR_PERSON_RESPONSIBLE = '01" . $responsibility . "') AND (TM_PROCESS_PARTS.CHR_WORK_CENTER = '$w_center')  and  ((TM_PROCESS_PARTS.CHR_FLAG_DELETE IS NULL) OR (TM_PROCESS_PARTS.CHR_FLAG_DELETE <> '1'))
                      order by CHR_BACK_NO2 ASC ");
        //}

        return $query->result();
    }

    //get all wc
    function get_all_wc($responsibility) {
        $get_inline_scan_num = $this->db->query("select CHR_WORK_CENTER from TM_INLINE_SCAN WHERE INT_ID_DEPT like '%$responsibility' AND BIT_FLG_ACTIVE = 1 group by CHR_WORK_CENTER")->num_rows();
        $get_inline_scan = $this->db->query("select CHR_WORK_CENTER from TM_INLINE_SCAN WHERE INT_ID_DEPT like '%$responsibility' AND BIT_FLG_ACTIVE = 1 group by CHR_WORK_CENTER")->result();

        $query = "SELECT DISTINCT CHR_WORK_CENTER from TM_PROCESS_PARTS where CHR_PERSON_RESPONSIBLE = '01" . $responsibility . "' 
		AND CHR_WORK_CENTER NOT IN 
                (";
        if (count($get_inline_scan) > 0) {
            $i = 1;
            foreach ($get_inline_scan as $value_inline_scan) {
                $query .= "'$value_inline_scan->CHR_WORK_CENTER'";
                if ($i <> $get_inline_scan_num) {
                    $query .= " , ";
                }
                $i++;
            }
            $query .= " , 'SADL01', 'SADL02', 'SADL03', 'SADL04','SADL05', 'SADL07', 'PRDF03', 'MFDF01','SACD01','SACD02','SACD03'"
                    . ",'SACD04','SACD05','SACD06','SACD07','SASP01' , 'PK0004', 'SACC01', 'SACC02', 'SACC03', 'SACC04', 'PRDS01') Order BY CHR_WORK_CENTER asc";
        } else {
            $query .= "'SADL01', 'SADL02', 'SADL03', 'SADL04','SADL05', 'SADL07', 'PRDF03', 'MFDF01','SACD01','SACD02','SACD03'"
                    . ",'SACD04','SACD05','SACD06','SACD07','SASP01' , 'PK0004', 'SACC01', 'SACC02', 'SACC03', 'SACC04', 'PRDS01') Order BY CHR_WORK_CENTER asc";
        }

        $query = $this->db->query($query);

        return $query->result();
    }

    //get all ng
    function get_all_ng() {
        $query = $this->db->query("SELECT CHR_NG_CATEGORY_CODE, CHR_NG_CATEGORY, CHR_FLAG_DELETE FROM TM_NG order by CHR_NG_CATEGORY asc");

        return $query->result();
    }

    //get all line stop
    function get_all_line_stop($w_center, $date, $shift) {
        $query = $this->db->query("SELECT TM_LINE_STOP.* , ISNULL(TT_LINE_STOP_PROD.INT_DURASI_LS , '0') AS TIME
            FROM  TM_LINE_STOP
            LEFT JOIN TT_LINE_STOP_PROD ON TM_LINE_STOP.CHR_LINE_CODE = TT_LINE_STOP_PROD.CHR_LINE_CODE and
            TT_LINE_STOP_PROD.CHR_WORK_CENTER = '$w_center' AND  TT_LINE_STOP_PROD.CHR_DATE = '$date' AND TT_LINE_STOP_PROD.CHR_SHIFT =  '$shift'");

        return $query->result();
    }

    function save_history($data) {
        $this->db->insert('TT_PRODUCTION_RESULT_HISTORY', $data);
    }

    function save_prod_result($data) {
        $this->db->insert('TT_PRODUCTION_RESULT', $data);
    }

    function get_data_by_part($date, $shift, $wcenter, $part_number, $int_number) {
        $query = $this->db->query("SELECT INT_NUMBER, CHR_WO_NUMBER, CHR_DATE, CHR_PLANT, CHR_BACK_NO, CHR_PART_NO, CHR_PART_NAME, CHR_WORK_CENTER, INT_BULAN, 
                      INT_TAHUN, CHR_PV, CHR_TYPE, CHR_SHIFT, CHR_WORK_DAY, CHR_WORK_TIME_START, INT_MP, INT_TARGET, INT_ACTUAL, INT_QTY_OK, INT_TOTAL_QTY, 
                      CHR_UOM, INT_CHOKOTEI, CHR_IP, CHR_USER, INT_NPK, CHR_VALIDATE, CHR_NPK_VALIDATE, CHR_IPUP, CHR_USERUP, CHR_DATE_UPLOAD, 
                      CHR_TIME_UPLOAD, CHR_UPLOAD, CHR_STATUS, CHR_MESSAGE, CHR_MATDOC, CHR_STATUS_MOBILE, CHR_UPDATE_REPAIR, INT_NUMBER_REVERSED, 
                      CHR_PROCESS_PROD_COUNTER, CHR_REVERSE, CHR_COMPLETE, INT_QTY_PLAN, CHR_DATE_ENTRY, CHR_TIME_ENTRY, INT_NG_PRC, INT_NG_BRKNTEST, 
                      INT_NG_SETUP, INT_NG_TRIAL
                      FROM         TT_PRODUCTION_RESULT
                      WHERE     (CHR_DATE = '$date') AND (CHR_SHIFT = '$shift') AND (CHR_WORK_CENTER = '$wcenter') AND (CHR_PART_NO = '$part_number') and INT_NUMBER = '$int_number'");

        return $query->result();
    }

    function check_status_interface_by_wo($date, $shift, $work_center) {
        $query = $this->db->query("SELECT * FROM TT_PRODUCTION_RESULT WHERE CHR_DATE = '$date' AND CHR_SHIFT = '$shift' AND CHR_WORK_CENTER = '$work_center' AND (CHR_STATUS = '5' or CHR_STATUS_NG = '5')");

        if ($query->num_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    //adding by Ilham 26.05.2017 for Standardization Routing Project * ACTIVED
    //Phase 1: HTDS *ACTIVED 16.10.2017
    function check_part_no($part_number) {
        $query = $this->db->query("SELECT * FROM TM_PHANTOM WHERE CHR_PART_NO = '$part_number'");
        
        if ($query->num_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
    }

}

/* End of file freeze_model.php */
/* Location : application/models/freeze_model.php */