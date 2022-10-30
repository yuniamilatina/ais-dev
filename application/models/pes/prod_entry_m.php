<?php

class prod_entry_m extends CI_Model {
    /* -- define  -- */

    public $db_1;
    /* private $tbl_name = "PES_TM_PART";
      private $tbl_trans = "PES_TT_PROD_RESULT";
     */
    private $tbl_name = "TM_PES_PART";
    private $tbl_trans = "TT_PES_PROD_RESULT";
    private $tbl_name_toro = "TM_PROCESS_PARTS";

    /* private $tbl_trans_aiierp = "TT_PRODUCTION_RESULT";
      private $tbl_goodsmovement_aiierp = "TT_GOODS_MOVEMENT"; */

    /* private $tbl_temp = "so_temp_freeze";
      private   $tbl_lock = "so_freeze_lock"; */

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

    //add by toro project sampe jumat
    public function find_toro($select = '', $where = '', $order = '', $limit = '', $start = '0', $group = '', $join = '') {
        //$db_1 = $this->load->database();

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

        return $this->db->get($this->tbl_name_toro)->result();
    }

    //add by toro
    public function find_trans_toro($select = '', $where = '', $order = '', $limit = '', $start = '0', $group = '', $join = '') {
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

        return $this->db->get($this->tbl_name_toro)->result();
        //return $this->db_1->get($this->tbl_name)->result();
    }

    //add by toro
    function find_all_part_by_dept_and_shift_and_date($dept, $shift, $date) {
        $work_center = "'" . trim($dept) . "'";

        $query = $this->db->query("SELECT P.CHR_PART_NO, K.CHR_BACK_NO, PP.CHR_WORK_CENTER, P.CHR_PART_NAME, 
		PP.CHR_TYPE, PP.CHR_SLOC_TO, PP.CHR_FLAG_DELETE, PP.CHR_DATE, PR.CHR_SHIFT, 
		ISNULL(PR.INT_QTY_OK,0) AS INT_QTY_OK
                FROM TM_PARTS P 
                      INNER JOIN TM_KANBAN K ON K.CHR_PART_NO = P.CHR_PART_NO
                      INNER JOIN TM_PROCESS_PARTS PP ON PP.CHR_PART_NO = P.CHR_PART_NO
                      LEFT JOIN TT_PRODUCTION_RESULT PR ON PR.CHR_WORK_CENTER = PP.CHR_WORK_CENTER
                              AND PR.CHR_BACK_NO = K.CHR_BACK_NO AND PR.CHR_PART_NO = P.CHR_PART_NO
                WHERE PP.CHR_WORK_CENTER = $work_center 
                      AND PP.CHR_FLAG_DELETE='0' 
                      AND PR.CHR_SHIFT = $shift
                      AND PP.CHR_DATE = $date
                ORDER BY K.CHR_BACK_NO");

//        $query = $this->db->query("SELECT     TM_PES_PART.INT_NO, TM_PES_PART.CHR_PART_NO, TM_PES_PART.CHR_BACK_NO, TM_PES_PART.CHR_WCENTER, TM_PES_PART.CHR_PART_NAME, 
//						  TM_PES_PART.CHR_WCENTER_MN, TM_PES_PART.CHR_TYPE, TM_PES_PART.CHR_SLOC, TM_PES_PART.CHR_PART_NO_HYP, TM_PES_PART.CHR_PROD, TM_PES_PART.CHR_FLG_DELETE,
//						  TT_PES_PROD_RESULT.CHR_TGL_TRANS, TT_PES_PROD_RESULT.CHR_SHIFT, ISNULL(TT_PES_PROD_RESULT.INT_QTY_OK,0) AS INT_QTY_OK, 
//						  ISNULL(TT_PES_PROD_RESULT.INT_QTY_NG_PROSES,0) AS INT_QTY_NG_PROSES, ISNULL(TT_PES_PROD_RESULT.INT_QTY_NG_BTEST,0) AS INT_QTY_NG_BTEST, ISNULL(TT_PES_PROD_RESULT.INT_QTY_NG_SETUP,0) AS INT_QTY_NG_SETUP, 
//						  ISNULL(TT_PES_PROD_RESULT.INT_QTY_NG_TRIAL,0) AS INT_QTY_NG_TRIAL, TT_PES_PROD_RESULT.CHR_FLG_APPROVE_SPV,  TT_PES_PROD_RESULT.CHR_FLG_APPROVE_KADEPT, TT_PES_PROD_RESULT.CHR_FLG_APPROVE_GM
//						  FROM TM_PES_PART LEFT OUTER JOIN
//						  TT_PES_PROD_RESULT ON TM_PES_PART.CHR_PART_NO = TT_PES_PROD_RESULT.CHR_PART_NO AND TM_PES_PART.CHR_WCENTER_MN = TT_PES_PROD_RESULT.CHR_WCENTER_MN  AND TT_PES_PROD_RESULT.CHR_SHIFT = '" . $shift . "' AND TT_PES_PROD_RESULT.CHR_TGL_TRANS='" . $date . "' 
//						  WHERE TM_PES_PART.CHR_FLG_DELETE='0' AND CHR_PROD='" . $data['dept_crop'] . "'
//						  ORDER BY TM_PES_PART.CHR_BACK_NO");

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return 0;
        }
    }

    //add by toro
    function find_part_by_work_center_and_shift_and_date($w_center, $shift, $date) {
        $work_center = "'" . trim($w_center) . "'";

        $query = $this->db->query("SELECT P.CHR_PART_NO, K.CHR_BACK_NO, PP.CHR_WORK_CENTER, P.CHR_PART_NAME, 
		PP.CHR_TYPE, PP.CHR_SLOC_TO, PP.CHR_FLAG_DELETE, PP.CHR_DATE, PR.CHR_SHIFT, 
		ISNULL(PR.INT_QTY_OK,0) AS INT_QTY_OK
                FROM TM_PARTS P 
                      INNER JOIN TM_KANBAN K ON K.CHR_PART_NO = P.CHR_PART_NO
                      INNER JOIN TM_PROCESS_PARTS PP ON PP.CHR_PART_NO = P.CHR_PART_NO
                      LEFT JOIN TT_PRODUCTION_RESULT PR ON PR.CHR_WORK_CENTER = PP.CHR_WORK_CENTER
                              AND PR.CHR_BACK_NO = K.CHR_BACK_NO AND PR.CHR_PART_NO = P.CHR_PART_NO
                WHERE PP.CHR_WORK_CENTER = $work_center 
                      AND PP.CHR_FLAG_DELETE='0' 
                      AND PR.CHR_SHIFT = $shift
                      AND PP.CHR_DATE = $date
                ORDER BY K.CHR_BACK_NO");

        //SELECT     TM_PES_PART.INT_NO, TM_PES_PART.CHR_PART_NO, TM_PES_PART.CHR_BACK_NO, TM_PES_PART.CHR_WCENTER, TM_PES_PART.CHR_PART_NAME, 
//						  TM_PES_PART.CHR_WCENTER_MN, TM_PES_PART.CHR_TYPE, TM_PES_PART.CHR_SLOC, TM_PES_PART.CHR_PART_NO_HYP, TM_PES_PART.CHR_PROD, TM_PES_PART.CHR_FLG_DELETE,
//						  TT_PES_PROD_RESULT.CHR_TGL_TRANS, TT_PES_PROD_RESULT.CHR_SHIFT, ISNULL(TT_PES_PROD_RESULT.INT_QTY_OK,0) AS INT_QTY_OK, 
//						  ISNULL(TT_PES_PROD_RESULT.INT_QTY_NG_PROSES,0) AS INT_QTY_NG_PROSES, ISNULL(TT_PES_PROD_RESULT.INT_QTY_NG_BTEST,0) AS INT_QTY_NG_BTEST, ISNULL(TT_PES_PROD_RESULT.INT_QTY_NG_SETUP,0) AS INT_QTY_NG_SETUP, 
//						  ISNULL(TT_PES_PROD_RESULT.INT_QTY_NG_TRIAL,0) AS INT_QTY_NG_TRIAL, TT_PES_PROD_RESULT.CHR_FLG_APPROVE_SPV,  TT_PES_PROD_RESULT.CHR_FLG_APPROVE_KADEPT, TT_PES_PROD_RESULT.CHR_FLG_APPROVE_GM 
//						  FROM TM_PES_PART LEFT OUTER JOIN
//						  TT_PES_PROD_RESULT ON TM_PES_PART.CHR_PART_NO = TT_PES_PROD_RESULT.CHR_PART_NO AND TM_PES_PART.CHR_WCENTER_MN = TT_PES_PROD_RESULT.CHR_WCENTER_MN AND TT_PES_PROD_RESULT.CHR_SHIFT = '" . $shift . "' AND TT_PES_PROD_RESULT.CHR_TGL_TRANS='" . $date . "' 
//						  WHERE TM_PES_PART.CHR_WCENTER_MN = '" . $w_center . "' AND TM_PES_PART.CHR_FLG_DELETE='0' 
//						  ORDER BY TM_PES_PART.CHR_BACK_NO

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return 0;
        }
    }

    //add by toro
    function find_total_part_by_work_center_and_shift_and_date($w_center, $shift, $date) {
        $work_center = "'" . $w_center . "'";

        $query = $this->db->query("SELECT SUM(ISNULL(PR.INT_QTY_OK,0)) AS INT_QTY_OK
                    --SUM(ISNULL(PR.INT_QTY_NG_PROSES,0)) AS INT_QTY_NG_PROSES,
                    --SUM(ISNULL(PR.INT_QTY_NG_BTEST,0)) AS INT_QTY_NG_BTEST,
                    --SUM(ISNULL(PR.INT_QTY_NG_SETUP,0)) AS INT_QTY_NG_SETUP,
                    --SUM(ISNULL(PR.INT_QTY_NG_TRIAL,0)) AS INT_QTY_NG_TRIAL,
                FROM TM_PARTS P INNER JOIN TM_PROCESS_PARTS PP ON PP.CHR_PART_NO = P.CHR_PART_NO 
                LEFT JOIN TT_PRODUCTION_RESULT PR ON PR.CHR_WORK_CENTER = PP.CHR_WORK_CENTER 
                AND PR.CHR_PART_NO = P.CHR_PART_NO WHERE PP.CHR_WORK_CENTER = 'ASDF01' 
                AND PP.CHR_FLAG_DELETE='0' 
                --AND PR.CHR_SHIFT = $shift AND PP.CHR_DATE = $date");

        //query ngambilnya dari mana??
//        $query = $this->db->query(("SELECT  SUM(ISNULL(TT_PES_PROD_RESULT.INT_QTY_OK,0)) AS INT_QTY_OK,  "
//                . "SUM(ISNULL(TT_PES_PROD_RESULT.INT_QTY_NG_PROSES,0)) AS INT_QTY_NG_PROSES, "
//                . "SUM(ISNULL(TT_PES_PROD_RESULT.INT_QTY_NG_BTEST,0)) AS INT_QTY_NG_BTEST, "
//                . "SUM(ISNULL(TT_PES_PROD_RESULT.INT_QTY_NG_SETUP,0)) AS INT_QTY_NG_SETUP, "
//                . "SUM(ISNULL(TT_PES_PROD_RESULT.INT_QTY_NG_TRIAL,0)) AS INT_QTY_NG_TRIAL "
//                . "FROM TM_PES_PART LEFT OUTER JOIN TT_PES_PROD_RESULT "
//                . "ON TM_PES_PART.CHR_PART_NO = TT_PES_PROD_RESULT.CHR_PART_NO "
//                . "AND TM_PES_PART.CHR_WCENTER_MN = TT_PES_PROD_RESULT.CHR_WCENTER_MN "
//                . "AND TT_PES_PROD_RESULT.CHR_SHIFT= $shift  "
//                . "AND TT_PES_PROD_RESULT.CHR_TGL_TRANS= $date "
//                . "WHERE TM_PES_PART.CHR_WCENTER_MN = $work_center "
//                . "AND TM_PES_PART.CHR_FLG_DELETE=0");

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return 0;
        }
    }

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
        //var_dump($this->tbl_name);die();
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

    public function updateRes($arr, $id) {
        return $this->db
                        ->where('INT_NUMBER', $id)
                        ->update('TT_PRODUCTION_RESULT', $arr);
    }

    public function updateResult($data, $where) {
        if (is_array($data)) {
            return $this->db->update('TT_PRODUCTION_RESULT', $data, $where);
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

    public function findBySql_trans($sql) {
        $db_1 = $this->load->database();

        $query = $this->db->query($sql);

        return $query->result();
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

    function get_work_center() {
        $sql = "SELECT CHR_WORK_CENTER from TM_PROCESS";
        return $this->db->query($sql);
    }

    function exist_work_center() {
        $sql = "SELECT CHR_WORK_CENTER from TM_PROCESS where ";
        return $this->db->query($sql);
    }

    public function isExist($work_order) {
        $sql = "SELECT CHR_WO_NUMBER FROM TT_PRODUCTION_WO WHERE CHR_WO_NUMBER='" . $work_order . "'";
        //var_dump($sql);die();
        return $this->db->query($sql)->result();
        // return $this->ExecuteScalar("SELECT CHR_WO_NUMBER FROM TT_PRODUCTION_WO WHERE CHR_WO_NUMBER =?", array($work_order));
    }

    function get_chr_shift() {
        $sql = "SELECT distinct(CHR_WORK_SHIFT) from  TM_WORK_TIME";
        return $this->db->query($sql);
    }

    public function GetRow() {
        $sql = "SELECT CHR_WORK_CENTER from  TM_PROCESS";
        return $this->db->query($sql);
    }

    public function GetWorkOrder($startdate, $enddate) {
        $sql = "SELECT DISTINCT * from TT_PRODUCTION_WO where CHR_DATE between '" . $startdate . "' and '" . $enddate . "' ORDER BY CHR_DATE ";
        return $this->db->query($sql)->result();
    }

    public function GetWorkOrderRole($startdate, $enddate, $respon) {
        $sql = "SELECT DISTINCT b.*
                FROM TM_PROCESS AS a INNER JOIN
                TT_PRODUCTION_WO AS b ON a.CHR_WORK_CENTER = b.CHR_WORK_CENTER
                WHERE     a.CHR_PERSON_RESPONSIBLE = '" . $respon . "'  ORDER BY CHR_DATE"; //dilepas sementara req pak ilham 12/05/2016
        // WHERE     a.CHR_PERSON_RESPONSIBLE = '".$respon."' and b.CHR_DATE between '".$startdate."' and '".$enddate."' ORDER BY CHR_DATE";
        return $this->db->query($sql)->result();
    }

    public function saveWo($tablename, $data) {
        $res = $this->db->insert($tablename, $data);
        return $res;
    }

    public function submitRes($arr) {
        $this->db->insert('users', $arr);
        return $this->db->insert_id();
    }

    public function InsertData($tablename, $data) {
        $this->db->insert($tablename, $data);
        return $this->db->insert_id();
    }

    public function GetRejectStatus() {
        $sql = "SELECT * from TM_REJECT where CHR_FLAG_DELETE !='X' or CHR_FLAG_DELETE is null ";
        return $this->db->query($sql)->result();
    }

    public function GetNGStatus() {
        $sql = "SELECT * from TM_NG where CHR_FLAG_DELETE !='X' or CHR_FLAG_DELETE is null  ";
        return $this->db->query($sql)->result();
    }

    public function GetWorkOrderByid($id) {
        $sql = "SELECT DISTINCT TM_PROCESS.CHR_WORK_CENTER AS Expr1, TT_PRODUCTION_WO.*, TM_PROCESS.CHR_AREA, TM_AREA.CHR_AREA AS Expr2, TM_PROCESS.CHR_PERSON_RESPONSIBLE, 
                         TM_AREA.CHR_DESC_AREA
FROM            TT_PRODUCTION_WO INNER JOIN
                         TM_PROCESS ON TT_PRODUCTION_WO.CHR_WORK_CENTER = TM_PROCESS.CHR_WORK_CENTER INNER JOIN
                         TM_AREA ON TM_PROCESS.CHR_AREA = TM_AREA.CHR_AREA
WHERE        (TT_PRODUCTION_WO.CHR_WO_NUMBER = '" . $id . "')";
        return $this->db->query($sql)->row();

        // return $this->ExecuteScalar("SELECT CHR_WO_NUMBER FROM TT_PRODUCTION_WO WHERE CHR_WO_NUMBER =?", array($work_order));
        //SELECT a.*,b.INT_PV FROM TT_PRODUCTION_WO a
        //JOIN TM_PROCESS_PARTS b on a.CHR_WORK_CENTER=b.CHR_WORK_CENTER
    }

    public function getBackNoattribute($id) {
        // $sql = "SELECT DISTINCT a.CHR_BACK_NO,b.CHR_PART_NAME,b.CHR_PART_NO,c.CHR_TYPE,b.CHR_PART_UOM from TM_KANBAN a
        //  INNER JOIN TM_PARTS b on a.CHR_PART_NO = b.CHR_PART_NO
        //  LEFT JOIN TM_PES_PART c on c.CHR_PART_NO=b.CHR_PART_NO
        //  WHERE a.CHR_BACK_NO='".$id."'";
        $sql = "SELECT DISTINCT a.CHR_BACK_NO,b.CHR_PART_NAME,b.CHR_PART_NO,
                 c.CHR_TYPE,b.CHR_PART_UOM,d.CHR_PV 
                 from TM_KANBAN a INNER JOIN TM_PARTS b on a.CHR_PART_NO = b.CHR_PART_NO
                 INNER JOIN TM_PES_PART c on c.CHR_PART_NO=b.CHR_PART_NO 
                 INNER JOIN TM_PROCESS_PARTS d on c.CHR_PART_NO = d.CHR_PART_NO
                WHERE a.CHR_BACK_NO='" . $id . "' AND ( a.CHR_KANBAN_TYPE = '1' OR a.CHR_KANBAN_TYPE = '5')"; //edit, req pak wildan 03/05/2014
        return $this->db->query($sql)->row();

        // return $this->ExecuteScalar("SELECT CHR_WO_NUMBER FROM TT_PRODUCTION_WO WHERE CHR_WO_NUMBER =?", array($work_order));
    }

    public function GetChrBack() {
        $sql = "SELECT DISTINCT (CHR_BACK_NO) from TM_KANBAN  ";
        return $this->db->query($sql)->result();
        ;
    }

    public function GetChrLineStop() {
        $sql = "SELECT DISTINCT(CHR_LINE_STOP),CHR_LINE_CODE,CHR_LINE_CAT FROM TM_LINE_STOP where CHR_FLAG_DELETE !='X' or CHR_FLAG_DELETE is null ";
        return $this->db->query($sql)->result();
    }

    public function GetTmArea() {
        $sql = "SELECT * FROM TM_AREA where CHR_FLAG_DELETE !='X' or CHR_FLAG_DELETE is null ";
        return $this->db->query($sql)->result();
    }

    public function GetArea($work_center) {
        $sql = "SELECT DISTINCT TM_PROCESS.CHR_AREA, TM_AREA.CHR_DESC_AREA, TM_AREA.CHR_FLAG_DELETE, TM_PROCESS.CHR_FLAG_DELETE AS Expr1, 
       TM_PROCESS.CHR_WORK_CENTER
       FROM TM_PROCESS INNER JOIN
       TM_AREA ON TM_PROCESS.CHR_AREA = TM_AREA.CHR_AREA
       WHERE (TM_AREA.CHR_FLAG_DELETE <> 'X') AND (TM_PROCESS.CHR_FLAG_DELETE <> 'X') AND (TM_PROCESS.CHR_WORK_CENTER = '" . $work_center . "') OR
       (TM_AREA.CHR_FLAG_DELETE IS NULL) AND (TM_PROCESS.CHR_FLAG_DELETE IS NULL)";

        return $this->db->query($sql)->result();
    }

    public function getProductionResult($id) {
        $sql = "SELECT * from TT_PRODUCTION_RESULT where INT_NUMBER ='" . $id . "'";
        return $this->db->query($sql)->row();
    }

    public function getTmProcessPart($work_center, $chr_part_no) {
        $sql = "select * from TM_PROCESS_PARTS where CHR_WORK_CENTER='" . $work_center . "' and CHR_PART_NO='" . $chr_part_no . "'";
        return $this->db->query($sql)->row();
    }

    public function getPart($chr_part_no) {
        $sql = "select * from TM_PARTS where CHR_PART_NO ='" . $chr_part_no . "'";
        return $this->db->query($sql)->row();
    }

    public function getRumus($chr_work_shift, $chr_work_day, $chr_work_start, $int_bln, $int_thn, $work_center, $work_order) {
        //public function getRumus(){
        $sql = " SELECT 
                    (SELECT INT_WORK_HOUR FROM TM_WORK_TIME 
                    WHERE CHR_WORK_SHIFT ='" . $chr_work_shift . "'  AND CHR_WORK_DAY =  '" . $chr_work_day . "'
                    AND CHR_WORK_TIME_START ='" . $chr_work_start . "') as work_time,
                    (SELECT SUM(INT_MENIT)  from TT_PRODUCTION_LINE_STOP
                    WHERE CHR_IND_LINE_STOP='X' AND INT_NUMBER in(select INT_NUMBER from TT_PRODUCTION_RESULT where CHR_WO_NUMBER='" . $work_order . "'
                    and CHR_WORK_TIME_START='" . $chr_work_start . "') ) as plan_line_stop,
                    (SELECT INT_CT  FROM TM_TARGET_PRODUCTION
                    WHERE INT_BULAN = '" . $int_bln . "' 
                    AND INT_TAHUN = '" . $int_thn . "' AND CHR_WORK_CENTER = '" . $work_center . "')
                    as INT_CT,
                    (select SUM(INT_TOTAL_QTY) from TT_PRODUCTION_RESULT
                    where CHR_WO_NUMBER='" . $work_order . "'
                    and CHR_WORK_TIME_START='" . $chr_work_start . "' ) as ACTUAL_JAM
                    ,
                    (select SUM(INT_MENIT) from TT_PRODUCTION_LINE_STOP where INT_NUMBER in(select INT_NUMBER from TT_PRODUCTION_RESULT where CHR_WO_NUMBER='" . $work_order . "'
                    and CHR_WORK_TIME_START='" . $chr_work_start . "') )as TOTAL_LINE_STOP

                    ";

        //var_dump($sql);die();
        return $this->db->query($sql)->row();
    }

    public function getCgo() {
        $sql = "select TOP 500 * from TT_PRODUCTION_RESULT
                where CHR_UPLOAD ='X' AND CHR_MESSAGE <> 'Please enter a quantity to be confirmed or a scrap quantity' AND CHR_STATUS not in ('S',' ','X') ORDER BY INT_NUMBER DESC";
        return $this->db->query($sql)->result();
    }

    public function getResultByid($id) {
        $sql = "select * from TT_PRODUCTION_RESULT where INT_NUMBER ='" . $id . "'";
        return $this->db->query($sql)->row();
    }

    public function getResultExist($id, $back_no, $chr_start) {
        $sql = "select INT_NUMBER from TT_PRODUCTION_RESULT where CHR_WO_NUMBER ='" . $id . "' AND CHR_BACK_NO='" . $back_no . "' AND CHR_WORK_TIME_START='" . $chr_start . "'";

        return $this->db->query($sql)->row();
    }

    public function deleteRecord($table, $id) {
        return $this->db->delete($table, array('INT_NUMBER' => $id));
    }

    public function getMovementHexist($id) {
        $sql = "SELECT INT_NUMBER FROM TT_GOODS_MOVEMENT_H WHERE INT_NUMBER_PROD='" . $id . "'";
        return $this->db->query($sql)->row();
    }

    public function getNgHexist($id) {
        $sql = "SELECT INT_NUMBER FROM TT_NG_RECORD_H WHERE INT_NUMBER_PROD='" . $id . "'";
        return $this->db->query($sql)->row();
    }

    public function getLineHexist($id) {
        $sql = "SELECT CHR_NUMBER_LS FROM TT_PRODUCTION_LINE_STOP WHERE INT_NUMBER='" . $id . "'";
        return $this->db->query($sql)->row();
    }

    public function deleteRecordMvNG($table, $id) {
        return $this->db->delete($table, array('INT_NUMBER_PROD' => $id));
    }

    public function getAllData($chr_wo_num, $chr_back_no, $CHR_WORK_TIME_START) {
        //$sql = "SELECT INT_NUMBER FROM TT_NG_RECORD_H WHERE INT_NUMBER_PROD='".$id."'";
        $sql = "select *,b.CHR_PERSON_RESPONSIBLE FROM TT_PRODUCTION_RESULT a
                inner join TM_PROCESS b on a.CHR_WORK_CENTER=b.CHR_WORK_CENTER
                where a.CHR_WO_NUMBER ='" . $chr_wo_num . "' AND a.CHR_BACK_NO='" . $chr_back_no . "'
                AND a.CHR_WORK_TIME_START='" . $CHR_WORK_TIME_START . "'";
        return $this->db->query($sql)->row();
    }

    public function getRepair($id) {
        $sql = "select * FROM TT_PRODUCTION_REPAIR WHERE INT_NUMBER='" . $id . "'";

        return $this->db->query($sql)->result();
    }

    public function getNG_H($id) {
        $sql = "select * FROM TT_NG_RECORD_H WHERE INT_NUMBER_PROD='" . $id . "'";

        return $this->db->query($sql)->row();
    }

    public function getMV_H($id) {
        $sql = "select * FROM TT_GOODS_MOVEMENT_H WHERE INT_NUMBER_PROD='" . $id . "'";

        return $this->db->query($sql)->row();
    }

    public function getNG_L($idNg) {
        $sql = "select * FROM TT_NG_RECORD_L WHERE INT_NUMBER='" . $idNg . "'";

        return $this->db->query($sql)->result();
    }

    public function getMV_L($idMv) {
        $sql = "select * FROM TT_GOODS_MOVEMENT_L WHERE INT_NUMBER='" . $idMv . "'";

        return $this->db->query($sql)->result();
    }

    public function getLine($id) {
        $sql = "select CHR_LINE_CODE,INT_MENIT,CHR_REMARKS from TT_PRODUCTION_LINE_STOP WHERE INT_NUMBER='" . $id . "'";

        return $this->db->query($sql)->result();
    }

    public function existTarget($id, $int_bln, $int_tahun) {
        $sql = "select * from TM_TARGET_PRODUCTION WHERE INT_BULAN='" . $int_tahun . "' AND INT_TAHUN='" . $int_bln . "' AND CHR_WORK_CENTER='" . $id . "'";


        return $this->db->query($sql)->result();
    }

}

/* End of file freeze_model.php */
/* Location : application/models/freeze_model.php */