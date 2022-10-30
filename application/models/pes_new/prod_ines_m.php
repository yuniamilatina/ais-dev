<?php

class prod_ines_m extends CI_Model {

    public $db_1;
    private $tbl_name = "TM_PES_PART";
    private $tbl_trans = "TT_PES_PROD_RESULT";

    public function __construct() {
        parent::__construct();
    }

    public function activeRec() {
        $this->db_x->select("*", false);
        $this->db_x->where("CHR_PART_NO = 'MA13'");
        $this->db_x->ORDER_BY("CHR_PART_NO");
        $a = $this->db_x->get("TT_PURCHASE_ORDER_L")->result();
        return $a;
    }

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

        $query = $this->db->query("SELECT TT_PRODUCTION_RESULT.INT_NUMBER , TT_PRODUCTION_RESULT.CHR_PART_NO ,TT_PRODUCTION_RESULT.CHR_DATE , 
            TT_PRODUCTION_RESULT.CHR_SHIFT, TT_PRODUCTION_RESULT.CHR_WORK_CENTER  , TT_PRODUCTION_RESULT.CHR_BACK_NO , TT_PRODUCTION_RESULT.CHR_PART_NAME , 
            TT_PRODUCTION_RESULT.CHR_DATE_ENTRY ,TT_PRODUCTION_RESULT.CHR_TIME_ENTRY ,
            TT_PRODUCTION_RESULT.INT_TOTAL_QTY ,  TT_PRODUCTION_RESULT.INT_NG_BRKNTEST , TT_PRODUCTION_RESULT.INT_NG_PRC ,
            TT_PRODUCTION_RESULT.INT_NG_SETUP, TT_PRODUCTION_RESULT.INT_NG_OTHERS , TT_PRODUCTION_RESULT.INT_TOTAL_NG,TT_PRODUCTION_RESULT.INT_NG_TRIAL, 
            ISNULL(TM_PROCESS_PARTS.CHR_TYPE, 0) AS CHR_TYPE FROM
            TT_PRODUCTION_RESULT
            INNER JOIN
            TM_PROCESS_PARTS
            ON
            TT_PRODUCTION_RESULT.CHR_PART_NO = TM_PROCESS_PARTS.CHR_PART_NO AND TM_PROCESS_PARTS.CHR_WORK_CENTER = TT_PRODUCTION_RESULT.CHR_WORK_CENTER
            WHERE (TM_PROCESS_PARTS.CHR_PERSON_RESPONSIBLE = '01$responsibility')  and  ((TM_PROCESS_PARTS.CHR_FLAG_DELETE IS NULL) OR (TM_PROCESS_PARTS.CHR_FLAG_DELETE <> '1'))
            AND  TT_PRODUCTION_RESULT.CHR_DATE = '$date' AND TT_PRODUCTION_RESULT.CHR_WORK_CENTER = '$w_center'   AND TT_PRODUCTION_RESULT.CHR_SHIFT = '$shift'  order by TT_PRODUCTION_RESULT.CHR_BACK_NO ASC");

        return $query->result();
    }

    //get all wc
    // function get_all_wc($responsibility) {
    //     $get_inline_scan_query = $this->db->query("select * from TM_INLINE_SCAN where INT_ID_DEPT like '%$responsibility'");
    //     $get_inline_scan_num = $this->db->query("select * from TM_INLINE_SCAN where INT_ID_DEPT like '%$responsibility'")->num_rows();
    //     $get_inline_scan = $this->db->query("select * from TM_INLINE_SCAN where INT_ID_DEPT like '%$responsibility'")->result();
    //     $query = "select distinct CHR_WORK_CENTER from TM_PROCESS_PARTS where CHR_PERSON_RESPONSIBLE = '01" . $responsibility . "' 
	// 	AND CHR_WORK_CENTER IN 
    //             (";
    //     $i = 1;
    //     foreach ($get_inline_scan as $value_inline_scan) {
    //         $query .= "'$value_inline_scan->CHR_WORK_CENTER'";
    //         if ($i <> $get_inline_scan_num) {
    //             $query .= " , ";
    //         }
    //         $i++;
    //     }
    //     $query .= ")";
    //     $query = $this->db->query($query); //Edit Ilham 07.10.2016
    //     return $query->result();
    // }

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

    function get_all_part_by_workcenter($date, $responsibility, $shift, $w_center) {
        $query = $this->db->query("SELECT DISTINCT PP.CHR_PART_NO, K.CHR_BACK_NO  FROM TM_PROCESS_PARTS PP 
		INNER JOIN TM_KANBAN K ON K.CHR_PART_NO = PP.CHR_PART_NO
		WHERE PP.CHR_WORK_CENTER = '$w_center' AND PP.CHR_PERSON_RESPONSIBLE = '01$responsibility'
		AND K.CHR_BACK_NO NOT IN 
	(SELECT CHR_BACK_NO FROM TT_PRODUCTION_RESULT WHERE CHR_DATE = '$date' AND CHR_WORK_CENTER = '$w_center' AND CHR_SHIFT = '$shift')");

        return $query->result();
    }

    function get_data_part($back_no) {
        $query = $this->db->query("SELECT K.CHR_BACK_NO, P.CHR_PART_NAME, PP.CHR_PART_NO, PP.CHR_PV FROM TM_KANBAN K 
		INNER JOIN TM_PROCESS_PARTS PP ON K.CHR_PART_NO = PP.CHR_PART_NO
		LEFT JOIN TM_PARTS P ON P.CHR_PART_NO = PP.CHR_PART_NO
		WHERE K.CHR_BACK_NO =  '$back_no'
		GROUP BY K.CHR_BACK_NO, P.CHR_PART_NAME, PP.CHR_PART_NO, PP.CHR_PV ");

        return $query->row();
    }

    function add_part_to_list($data) {
        $this->db->insert('TT_PRODUCTION_RESULT', $data);
    }

    function save_history($data) {
        $this->db->insert('TT_PRODUCTION_RESULT_HISTORY', $data);
    }
    
    function save_prod_result($data){
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

    function check_status_interface_by_wo($date, $shift, $work_center){
        $query = $this->db->query("SELECT * FROM TT_PRODUCTION_RESULT WHERE CHR_DATE = '$date' AND CHR_SHIFT = '$shift' AND CHR_WORK_CENTER = '$work_center' AND (CHR_STATUS = '5' or CHR_STATUS_NG = '5')");

        if ($query->num_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
    }
}
