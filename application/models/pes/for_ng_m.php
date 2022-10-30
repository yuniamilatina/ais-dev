<?php
/**
*  NG NO LOCKING
*  @author kb.hartanto@gmail.com
*/
class For_ng_m extends CI_Model {
	  private $TT_NG_RECORD_H = 'TT_NG_RECORD_H';
	  private $TT_NG_RECORD_L = 'TT_NG_RECORD_L';
    private $TT_GOODS_MOVEMENT_H = 'TT_GOODS_MOVEMENT_H';
    private $TT_GOODS_MOVEMENT_L = 'TT_GOODS_MOVEMENT_L';
    private $TM_AREA = 'TM_AREA';
    private $TT_PRODUCTION_REPAIR='TT_PRODUCTION_REPAIR';
    private $TT_PRODUCTION_RESULT ='TT_PRODUCTION_RESULT';
    private $TM_PROCESS_PARTS ='TM_PROCESS_PARTS';
	private $TM_PARTS = 'TM_PARTS';
    private $TM_REJECT = 'TM_REJECT';

	public function __construct() {
        parent::__construct();
    }

    public function find($option_query,$tbl='tm_area'){
     
		// check option & query is array 
   		if (is_array($option_query))
   		{
   			// extract option & query
   			foreach ($option_query as $option => $query) {
   				$this->db->$option($query);
   			}
   		}
		
		return $this->db->get($this->$tbl)->result();
	}

	 function save(Array $data,$table = NULL) {
    	if ($table !== NULL ) {
        	$table = $this->$table;
        } else {
        	$table = $this->TT_NG_RECORD_H;
        }

        if ($this->db->insert($table, $data)) {
            return true;
        } else {
            return false;
        } 
    }
    function save_repair(Array $repair,$table = NULL) {
        if ($table !== NULL ) {
            $table = $this->$table;
        } else {
            $table = $this->TT_PRODUCTION_REPAIR;
        }

        if ($this->db->insert($table, $repair)) {
            return true;
        } else {
            return false;
        } 
    }
    function save_ir(Array $repairupdate2,$table = NULL) {
        if ($table !== NULL ) {
            $table = $this->$table;
        } else {
            $table = $this->TT_PRODUCTION_REPAIR;
        }

        if ($this->db->insert($table, $repairupdate2)) {
            return true;
        } else {
            return false;
        } 
    }

    function save_ttproductionresault(Array $update,$table = NULL) {
      if ($table !== NULL ) {
          $table = $this->$table;
        } else {
          $table = $this->TT_PRODUCTION_RESULT;
        }

        if ($this->db->insert($table, $update)) {
            return true;
        } else {
            return false;
        } 
    }
     function save_resault(Array $repairupdate1,$table = NULL) {
      if ($table !== NULL ) {
          $table = $this->$table;
        } else {
          $table = $this->TT_PRODUCTION_RESULT;
        }

        if ($this->db->insert($table, $repairupdate1)) {
            return true;
        } else {
            return false;
        } 
    }

    function save_movement_h($data,$table = NULL) {
      if ($table !== NULL ) {
          $table = $this->$table;
        } else {
          $table = $this->TT_GOODS_MOVEMENT_H;
        }
        if($this->db->insert($table, $data)) {
            return true;
        } else {
            return false;
        } 
    }
     function save_move($move,$table = NULL) {
      if ($table !== NULL ) {
          $table = $this->$table;
        } else {
          $table = $this->TT_GOODS_MOVEMENT_L;
        }
        if($this->db->insert($table, $move)) {
            return true;
        } else {
            return false;
        } 
    }

    function save_Record_L(Array $param,$table = NULL) {
      if ($table !== NULL ) {
          $table = $this->$table;
        } else {
          $table = $this->TT_NG_RECORD_L;
        }

        if ($this->db->insert($table, $param)) {
            return true;
        } else {
            return false;
        } 
    }
    function save_go_h(Array $GO,$table = NULL) {
      if ($table !== NULL ) {
          $table = $this->$table;
        } else {
          $table = $this->TT_GOODS_MOVEMENT_H;
        }

        if ($this->db->insert($table, $GO)) {
            return true;
        } else {
            return false;
        } 
    }
    
     function get($where = NULL,$table = NULL,$single=NULL) {
        if ($where !== NULL) {
            if (is_array($where)) {
                foreach ($where as $field=>$value) {
                    $this->db->where($field, $value);
                }
            } else {
                $this->db->where($this->pri_index, $where);
            }
        }
        
        if ($table !== NULL ) {
            $table = $this->$table;
        } else {
            $table = $this->TM_AREA;
        }

        $result = $this->db->get($table)->result();
        if ($result) {
            if ($single !== NULL) {
                return array_shift($result);
            } else {
                return $result;
            }
        } else {
            return false;
        }
    }
     function get_tm_reject($where = NULL,$table = NULL,$single=NULL) {
        if ($where !== NULL) {
            if (is_array($where)) {
                foreach ($where as $field=>$value) {
                    $this->db->where($field, $value);
                }
            } else {
                $this->db->where($this->pri_index, $where);
            }
        }
        
        if ($table !== NULL ) {
            $table = $this->$table;
        } else {
            $table = $this->TM_REJECT;
        }

        $result = $this->db->get($table)->result();
        if ($result) {
            if ($single !== NULL) {
                return array_shift($result);
            } else {
                return $result;
            }
        } else {
            return false;
        }
    }

    function get_tmPart($where = NULL,$table = NULL,$single=NULL) {
        if ($where !== NULL) {
            if (is_array($where)) {
                foreach ($where as $field=>$value) {
                    $this->db->where($field, $value);
                }
            } else {
                $this->db->where($this->pri_index, $where);
            }
        }
        
        if ($table !== NULL ) {
            $table = $this->$table;
        } else {
            $table = $this->TM_PARTS;
        }

        $result = $this->db->get($table)->result();
        if ($result) {
            if ($single !== NULL) {
                return array_shift($result);
            } else {
                return $result;
            }
        } else {
            return false;
        }
    }

    function get_production_repair($where = NULL,$table = NULL,$single=NULL) {
        if ($where !== NULL) {
            if (is_array($where)) {
                foreach ($where as $field=>$value) {
                    $this->db->where($field, $value);
                }
            } else {
                $this->db->where($this->pri_index, $where);
            }
        }
        
        if ($table !== NULL ) {
            $table = $this->$table;
        } else {
            $table = $this->TT_PRODUCTION_REPAIR;
        }

        $result = $this->db->get($table)->result();
        if ($result) {
            if ($single !== NULL) {
                return array_shift($result);
            } else {
                return $result;
            }
        } else {
            return false;
        }
    }

    function get_work_center($where = NULL,$table = NULL,$single=NULL) {
        if ($where !== NULL) {
            if (is_array($where)) {
                foreach ($where as $field=>$value) {
                    $this->db->where($field, $value);
                }
            } else {
                $this->db->where($this->pri_index, $where);
            }
        }
        
        if ($table !== NULL ) {
            $table = $this->$table;
        } else {
            $table = $this->TM_PROCESS_PARTS;
        }

        $result = $this->db->get($table)->result();
        if ($result) {
            if ($single !== NULL) {
                return array_shift($result);
            } else {
                return $result;
            }
        } else {
            return false;
        }
    }

    function get_area($where = NULL,$table = NULL,$single=NULL) {
        if ($where !== NULL) {
            if (is_array($where)) {
                foreach ($where as $field=>$value) {
                    $this->db->where($field, $value);
                }
            } else {
                $this->db->where($this->pri_index, $where);
            }
        }
        
        if ($table !== NULL ) {
            $table = $this->$table;
        } else {
            $table = $this->TM_AREA;
        }

        $result = $this->db->get($table)->result();
        if ($result) {
            if ($single !== NULL) {
                return array_shift($result);
            } else {
                return $result;
            }
        } else {
            return false;
        }
    }

    function get_proses_part($where = NULL,$table = NULL,$single=NULL) {
        if ($where !== NULL) {
            if (is_array($where)) {
                foreach ($where as $field=>$value) {
                    $this->db->where($field, $value);
                }
            } else {
                $this->db->where($this->pri_index, $where);
            }
        }
        
        if ($table !== NULL ) {
            $table = $this->$table;
        } else {
            $table = $this->TM_PROCESS_PARTS;
        }

        $result = $this->db->get($table)->result();
        if ($result) {
            if ($single !== NULL) {
                return array_shift($result);
            } else {
                return $result;
            }
        } else {
            return false;
        }
    }

     function get_result($where = NULL,$table = NULL,$single=NULL) {
        if ($where !== NULL) {
            if (is_array($where)) {
                foreach ($where as $field=>$value) {
                    $this->db->where($field, $value);
                }
            } else {
                $this->db->where($this->pri_index, $where);
            }
        }
        
        if ($table !== NULL ) {
            $table = $this->$table;
        } else {
            $table = $this->TT_PRODUCTION_RESULT;
        }

        $result = $this->db->get($table)->result();
        if ($result) {
            if ($single !== NULL) {
                return array_shift($result);
            } else {
                return $result;
            }
        } else {
            return false;
        }
    }
    function select($where=NULL,$table=NULL,$select=NULL,$select_option=FALSE)
  {
    if ( $select !== NULL )
    {
      $this->db->select($select,$select_option);
    }
    return $this->get($where,$table);
  }

  function update(Array $pus, $where = array(),$table=NULL) {
      
      if ($table !== NULL ) {
          $table = $this->$table;
        } else {
          $table = $this->TT_PRODUCTION_RESULT;
        }

        if (!is_array($where)) {
            $where = array($this->pri_index => $where);
        }
        
        $this->db->update($table, $pus, $where);
        $update = $this->db->affected_rows();
        if(!empty($update))
        {
            return true;
        } else {
            return false;
        }
    }
    // function result()
    // {
    //     // 'No', 'Date', 'Part Number', 'Back No','Part Name & Model','Work Center','Quantity NG','Jenis Reject','Fg Scrap','component Scrap'
    //         $res=array();
    //      $productionresult= $this->select(array(),'TT_PRODUCTION_RESULT');
    //         if(!empty($productionresult)){
    //             foreach ($productionresult as $key => $value)
    //              {
    //                 $getrepair = $this->get_production_repair(array("INT_NUMBER"=>$value->INT_NUMBER),'TT_PRODUCTION_REPAIR');
    //                $inttotalng = $getrepair[0]->INT_TOTAL_QTY_NG;
    //                //$//count = count($inttotalng);
    //                //print_r($count); die();
    //                 foreach ($value as $k => $v) {  
    //                 switch ($k) {
    //                     case 'INT_NUMBER':
    //                        $res[$key][$k] = @$value->INT_NUMBER;
    //                        //$history[$key][$k] = $value->no_part;
    //                         break;
    //                     case 'CHR_DATE':
    //                        $res[$key][$k] = @$value->CHR_DATE;
    //                         break;
    //                         case 'CHR_BACK_NO':
    //                                 $res[$key][$k] = @$value->CHR_BACK_NO;
    //                         break;
    //                         case 'CHR_PART_NO':
    //                             $res[$key][$k] = @$value->CHR_PART_NO;
    //                             break;
    //                         case 'CHR_PART_NAME':
    //                             $res[$key][$k] = $value->CHR_PART_NAME;
    //                             break;
    //                         case 'CHR_WORK_CENTER':
    //                             $res[$key][$k] = $value->CHR_WORK_CENTER;
    //                             break;
    //                         case 'INT_QTY_OKE':
    //                             $res[$key][$k] =  count($inttotalng);
    //                             break;
    //                     default:
    //                         break;
    //                 }
    //        }
                
    //             //print_r($res); die();
    //         }
    //         }
    //         return $res;
    // }
}