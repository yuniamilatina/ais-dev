<?php

class Nolocking_m extends CI_Model {
	//
	private $tm_user = 'TM_USER';
	private $tm_area = 'TM_AREA';
	private $tm_ng = 'TM_NG';
	private $tm_parts = 'TM_PARTS';
	private $tm_damage = 'TM_DAMAGE';
	private $tm_reject = 'TM_REJECT';
	private $tt_ng_record_h = 'TT_NG_RECORD_H';
	private $tt_ng_record_l = 'TT_NG_RECORD_L'; 
	private $tt_movement_h = 'TT_GOODS_MOVEMENT_H';
	private $tt_movement_l = 'TT_GOODS_MOVEMENT_L';
	private $tt_scrapping_h = 'TT_SCRAPPING_H';
	private $tt_scrapping_l = 'TT_SCRAPPING_L';
	private $tm_process = 'TM_PROCESS';
	private $tm_process_parts = 'TM_PROCESS_PARTS';

	public function __construct() {
        parent::__construct();
        $this->load->library('kb_session');
    }

    public function execute($option_query,$tbl='tm_area',$shift=false ){
     
		// check option & query is array 
   		if (is_array($option_query))
   		{
   			// extract option & query
   			foreach ($option_query as $option => $query) {
   				if ($option == "join" || $option == "Join" || $option == "JOIN")
   				{
   					if (!is_array($query)) continue;
   					$this->db->join(@$query[0],@$query[1],@$query[2]);
   				} else {//$this->db->limit(10);
   					$this->db->$option($query); 
   				}
   			}
   		}

		$q = $this->db->get($this->$tbl);

		//$return = ($shift && @$q->num_rows() == 1 )? array_shift($q->result()) : $q->result() ;  

		return ($q)? ($shift)? array_shift($q->result()) :  $q->result() : false ;
	}
	public function screen_table($area, $name)
	{	
		$result = $this->execute(array('where' => "CHR_AREA = '".$area->CHR_AREA."' AND CHR_VALIDATE_LEADER IS NULL AND CHR_DEL_FLG IS NULL"),'tt_ng_record_l');
		$data = $this->kb_session->get($name);
		$count = ($data)? count($data) : 0 ;
		//print_r($result);die();
		if ($result) {
			foreach ($result as $key => $value) {
				$part = $this->nolocking->execute(array('where' => array('CHR_PART_NO'=> $value->CHR_PART_NO)),'tm_parts',true);
				$reject = $this->nolocking->execute(array('where' => array('CHR_REJECT_CODE'=> $value->CHR_REJECT_CODE)),'tm_reject',true);
				$ng = $this->nolocking->execute(array('where' => array('CHR_NG_CATEGORY_CODE'=> $value->CHR_NG_CATEGORY_CODE)),'tm_ng',true);
				$damage = $this->nolocking->execute(array('where' => array('CHR_DAMAGE_CODE'=> $value->CHR_DAMAGE_CODE)),'tm_damage',true);
				//var_dump($part);die();
				$data[$count+$key+1]['NO'] = $count + $key + 1;
				$data[$count+$key+1]['CHR_BACK_NO'] = @$value->CHR_BACK_NO;
				$data[$count+$key+1]['CHR_PART_NO'] = @$value->CHR_PART_NO;
				$data[$count+$key+1]['CHR_PART_NAME'] = @$part->CHR_PART_NAME;
				$data[$count+$key+1]['CHR_REJECT_CODE'] = @$reject->CHR_REJECT_TYPE;
				$data[$count+$key+1]['CHR_NG_CATEGORY_CODE'] = @$ng->CHR_NG_CATEGORY;
				$data[$count+$key+1]['CHR_DAMAGE_CODE'] = @$damage->CHR_DAMAGE_DESC;
				$data[$count+$key+1]['INT_TOTAL_QTY'] = @$value->INT_TOTAL_QTY;
				$data[$count+$key+1]['CHR_PART_UOM'] = @$part->CHR_PART_UOM;
			}
		}
		return $data;
	}
	public function screen_store($post='',$name)
	{
		$check = $this->execute(array('where' => "CHR_AREA = '".$post['CHR_AREA']."' AND CHR_VALIDATE_MSU IS NULL AND CHR_VALIDATE_LEADER IS NULL AND CHR_LKB_NO IS NULL", 'limit' => 1, 'order_by' => 'INT_NUMBER DESC'),'tt_ng_record_h',true);
		if (empty($check))
		{
			$record_h['CHR_PLANT'] = '600';
			$record_h['CHR_AREA'] = $post['CHR_AREA'];
			$record_h['CHR_PRINT_STATUS'] = '0';
			$this->db->insert($this->tt_ng_record_h, $record_h);
			$number = $this->db->insert_id();
		} else {
			$number = $check->INT_NUMBER;
		}
		// get session data
		$session = $this->session->all_userdata();
		$data = $this->kb_session->get($name);

		// edit 06032016 - sella request
		// change int_number_1 on record_l 
		/*$record_l_num = $this->execute(array('select' => 'COUNT(DISTINCT INT_NUMBER_1)','where' => array('INT_NUMBER' => $number)),'tt_ng_record_l');
		print_r($result_l_num);die()*/
		//print_r($session);
		// save data to tt_ng_record_l

		$record['CHR_PLANT'] = '600';
		$record['INT_NUMBER'] = $number;
		$record['CHR_AREA'] = $post['CHR_AREA'];
		$record['INT_NPK'] = $session['NPK'];
		$record['CHR_IP'] = $this->get_ip_client();
		$record['CHR_USER'] = $session['USERNAME'];
		$record['CHR_DATE_UPLOAD'] = date('Ymd');
		$record['CHR_TIME_UPLOAD'] = date('His');
		$record['CHR_SLOC_FROM'] = $post['CHR_SLOC_FROM'];
		$record['CHR_SLOC_TO'] = 'RE01';
		if(isset($post['CHR_WORK_CENTER'])){$record['CHR_WORK_CENTER'] = $post['CHR_WORK_CENTER'];}		
		//var_dump($record);
		$this->db->trans_begin();
		foreach ($data as $key => $value) {
			$record['CHR_BACK_NO'] =  @$value['CHR_BACK_NO'];
			$record['CHR_PART_NO'] = @$value['CHR_PART_NO'];
			$record['INT_TOTAL_QTY'] = @$value['INT_TOTAL_QTY'];
			$record['CHR_REJECT_CODE'] = @$this->get_id($value['CHR_REJECT_CODE']);
			$record['CHR_NG_CATEGORY_CODE'] = @$this->get_id($value['CHR_NG_CATEGORY_CODE']);
			$record['CHR_DAMAGE_CODE'] = @$this->get_id($value['CHR_DAMAGE_CODE']);

			$save = $this->db->insert($this->tt_ng_record_l, $record);
		}
		if ($this->db->trans_status() === FALSE) {
		    $this->db->trans_rollback();
		    return false;
		} else {
		    $this->db->trans_commit();
		    return true;
		}
		//print_r($data);
		//return $save;
	}

	public function validation($data='')
	{
		if (empty($data)):
			$post = $_POST;
			if (empty($post['CHR_AREA'])) return array('status' => 'error', 'message' => 'Field area harus di isi.');
			$query = (!empty($post['CHR_LKB_NO']))? array('where' => "CHR_AREA = '".$this->get_id($post['CHR_AREA'])."' AND CHR_LKB_NO = '".$post['CHR_LKB_NO']."' AND CHR_VALIDATE_MSU IS NULL", 'order_by' => 'INT_NUMBER DESC') : array('where' => "CHR_AREA = '".$this->get_id($post['CHR_AREA'])."' AND CHR_VALIDATE_MSU IS NULL AND CHR_LKB_NO IS NULL AND CHR_VALIDATE_LEADER IS NULL", 'order_by' => 'INT_NUMBER DESC');
			$check = $this->execute($query,'tt_ng_record_h');
				if ($check):
					// get int number from h for search with select where in
					$int_number = '';$plant = ''; $int_number_check = array(); $plant_check = array();
					foreach ($check as $key => $c_record_h) {
							$int_number_check[$key] = $c_record_h->INT_NUMBER;
							$int_number .= "'".$c_record_h->INT_NUMBER."'";
						if (($key+1) < count($check)){ $int_number .= ", "; $plant .= ", ";}
					}

				// get validation data
				$result = @$this->execute(array('where' => "INT_NUMBER IN (".$int_number.") AND CHR_AREA = '".$this->get_id($post['CHR_AREA'])."' AND CHR_DEL_FLG IS NULL"),'tt_ng_record_l');
				if (@$result){
					foreach ($result as $key => $value) {
							$part_search = (@$value->CHR_PART_NO)? array('CHR_PART_NO' => $value->CHR_PART_NO) : array('CHR_BACK_NO' => $value->CHR_BACK_NO);
							$part = @$this->nolocking->execute(array('select' => 'CHR_PART_NAME, CHR_PART_UOM','where' => $part_search),'tm_parts',true);
							$data['table'][$key]['No'] = $key + 1;
							$data['table'][$key]['CHR_BACK_NO'] =  @$value->CHR_BACK_NO;
							$data['table'][$key]['CHR_PART_NO'] = @$value->CHR_PART_NO;
							$data['table'][$key]['CHR_PART_NAME'] = @$part->CHR_PART_NAME;
							$data['table'][$key]['CHR_REJECT_CODE'] = @$this->nolocking->execute(array('where' => array('CHR_REJECT_CODE'=> $value->CHR_REJECT_CODE)),'tm_reject',true)->CHR_REJECT_TYPE;
							$data['table'][$key]['CHR_NG_CATEGORY_CODE'] = @$this->nolocking->execute(array('where' => array('CHR_NG_CATEGORY_CODE'=> $value->CHR_NG_CATEGORY_CODE)),'tm_ng',true)->CHR_NG_CATEGORY;
							$data['table'][$key]['CHR_DAMAGE_CODE'] = $value->CHR_DAMAGE_CODE;
							$data['table'][$key]['INT_TOTAL_QTY'] = '<input id="num" type="text" name="INT_TOTAL_QTY[]" value="'.$value->INT_TOTAL_QTY.'" class="form-control" onKeyPress="return check(event,value)" onInput="checkLength()"></input><input type="hidden" name="INT_NUMBER_1[]" value="'.$value->INT_NUMBER_1.'" class="form-control"></input><input type="hidden" name="INT_NUMBER[]" value="'.$value->INT_NUMBER.'" class="form-control"></input>';
							$data['table'][$key]['CHR_PART_UOM'] = @$part->CHR_PART_UOM;
							$data['table'][$key]['CHR_VALIDATE_LEADER'] = '<input id="area" type="checkbox" name="CHR_VALIDATE_LEADER['.$key.']" class="form-control"></input>';
					}
					return $data;
				} else {
					return array('status' => 'error', 'message' => 'Tidak Ada Component NG di AREA');
				}
			else: 
				return array('status' => 'error', 'message' => 'RECORD data tidak ditemukan.');
			endif;

		else:
			$post = $data; $return = true;
			$lkb_no = $this->execute(array('select' => 'CASE WHEN COUNT(CHR_LKB_NUM) > 0 THEN MAX(CAST(CHR_LKB_NUM AS INT))+1 ELSE 1
			END AS CHR_LKB_NUM' , 'where' => 'CHR_LKB_NUM IS NOT NULL AND CHR_LKB_DATE ="'. date('ym').'"', 'limit'=>1,'order_by' =>		
			'CHR_LKB_NUM DESC' ),'tt_ng_record_h',true)->CHR_LKB_NUM;
			// use validate lkb number and if not exist
			$record_h['CHR_LKB_DATE'] = date('ym');
			$record_h['CHR_LKB_NO'] = (!empty($post['CHR_LKB_NO']))? $post['CHR_LKB_NO'] : date('ym').str_pad($lkb_no, 6, "0", STR_PAD_LEFT) ;
			$record_h['CHR_LKB_NUM'] = $lkb_no;
			$record_h['CHR_VALIDATE_LEADER'] = 'X';
			$record_l['CHR_LKB_NO'] = $record_h['CHR_LKB_NO'];
			$array_int_num = array();
			// SET TRANSACTION
				if (isset($post['INT_TOTAL_QTY'])):
			$this->db->trans_begin();
					foreach ($post['INT_TOTAL_QTY'] as $key => $value) {
						// check validate
						if (isset($post['CHR_VALIDATE_LEADER'][$key])){
							$record['CHR_VALIDATE_LEADER'] = 'X';
						} else {
							$return = false;
							continue; 
						}
						if (!in_array($post['INT_NUMBER'][$key],$array_int_num)) array_push($array_int_num,$post['INT_NUMBER'][$key]);
						$record['INT_TOTAL_QTY'] = $post['INT_TOTAL_QTY'][$key];
						$record['CHR_NPK_LEADER'] =  $this->session->userdata('NPK');
						$record['CHR_IP_LEADER'] = $this->get_ip_client();
						$record['CHR_USER_LEADER'] = $this->session->userdata('USERNAME');
						$record['CHR_VALIDATE_DATE_LEADER'] = date('Ymd');
						$record['CHR_VALIDATE_TIME_LEADER'] = date('His');
						if ( $record['INT_TOTAL_QTY'] > 0) { 
							$this->db->where('INT_NUMBER_1',$post['INT_NUMBER_1'][$key]);
							$this->db->update($this->tt_ng_record_l,$record); } // setelah itu update ke record l
						else {
							$record['CHR_DEL_FLG'] = 'X';							
							$this->db->where('INT_NUMBER_1',$post['INT_NUMBER_1'][$key]);
							$this->db->update($this->tt_ng_record_l,$record);
						}
						unset($record['CHR_DEL_FLG']);
					}
				if ( $return )
				{
					// update lkb_no if all validate
					foreach ($post['INT_NUMBER_1'] as $key => $value) {
						$this->db->where('INT_NUMBER_1',$post['INT_NUMBER_1'][$key]);
						$this->db->update($this->tt_ng_record_l,$record_l); // update ke record l
					}
					// update lkb_no on ng_record_h
					foreach ($array_int_num as $int_number_update) {
						$this->db->where('INT_NUMBER',$int_number_update);
						$this->db->update($this->tt_ng_record_h,$record_h); // update ke record h
					}
				}
			if ($this->db->trans_status() === FALSE) {
			    $this->db->trans_rollback();
			} else {
			    $this->db->trans_commit();
			    if(!$return) return false;
				else return $record_h;
			}

				endif;
		endif;
	}
	public function check_record_h($area)
	{
		$check = $this->execute(array('where' => "CHR_AREA = '".$this->get_id($area)."' AND CHR_VALIDATE_MSU IS NULL", 'limit' => 1, 'order_by' => 'INT_NUMBER DESC'),'tt_ng_record_h',true);
		return $check;
	}
	public function generate_print($post='', $update=false)
	{
		$check = $this->execute(array('where' => "CHR_LKB_NO = '".$this->get_id($post['CHR_LKB_NO'])."'", 'limit' => 1, 'order_by' => 'INT_NUMBER DESC'),'tt_ng_record_h',true);
		if ($update) {
			$record_h['CHR_PRINT_STATUS'] = ($check->CHR_PRINT_STATUS=="X" || empty($check->CHR_PRINT_STATUS) || $check->CHR_PRINT_STATUS == NULL)? '1' : $check->CHR_PRINT_STATUS+1;
			$this->db->where('INT_NUMBER',$check->INT_NUMBER);
			$this->db->update($this->tt_ng_record_h,$record_h);
			return;
		}

		if ($check):
			$result = $this->execute(array('where' => "CHR_LKB_NO = '".$this->get_id($post['CHR_LKB_NO'])."' AND CHR_VALIDATE_LEADER IS NOT NULL AND CHR_DEL_FLG IS NULL"),'tt_ng_record_l');
			return $result;
		else: 
			return array('status' => 'error', 'message' => "Data record print tidak ditemukan, silahkan coba kembali.");
		endif;
	}
	public function generate_history($query='', $return=false)
	{
		if ($return){
			$check = $this->execute($query,'tt_ng_record_l');
			return $check;
		} else {
			$check = $this->execute(array('where' => "CHR_LKB_NO = '".$query."'", 'limit' => 1, 'order_by' => 'INT_NUMBER DESC'),'tt_ng_record_h',true);			
		}
		if ($check):
			// get validation data & update print status
			$result = $this->execute(array('select' => 'TT_NG_RECORD_L.*, CASE WHEN TT_NG_RECORD_H.CHR_VALIDATE_MSU IS NULL THEN "PROGRESS" WHEN TT_NG_RECORD_H.CHR_VALIDATE_MSU IS NOT NULL AND TT_NG_RECORD_L.CHR_DEL_FLG IS NOT NULL THEN "DELETED" WHEN TT_NG_RECORD_H.CHR_VALIDATE_MSU IS NOT NULL AND TT_NG_RECORD_L.CHR_REJECT IS NOT NULL THEN "REJECT" WHEN TT_NG_RECORD_H.CHR_VALIDATE_MSU IS NOT NULL AND TT_NG_RECORD_L.CHR_DEL_FLG IS NULL THEN "COMPLETED" END AS STATUS', 'where' => "TT_NG_RECORD_L.CHR_AREA = '".$check->CHR_AREA."' AND TT_NG_RECORD_L.CHR_LKB_NO = '".$this->get_id($check->CHR_LKB_NO)."'", 'join' => array('TT_NG_RECORD_H','TT_NG_RECORD_H.INT_NUMBER=TT_NG_RECORD_L.INT_NUMBER')),'tt_ng_record_l');
		
			return $result;
		else: 
			return array('status' => 'error', 'message' => "Data record print tidak ditemukan, silahkan coba kembali.");
		endif;
	}
	public function generate_msu($update='',$msu=true)
	{
		if (!$update):
			$check = $this->execute(array('where' => "CHR_LKB_NO = '".$this->get_id($this->input->post('CHR_LKB_NO'))."' ", 'limit' => 1, 'order_by' => 'INT_NUMBER DESC'),'tt_ng_record_h',true);
			if ($check && empty($check->CHR_VALIDATE_MSU)):
				// get validation data
				$result = $this->execute(array('where' => "CHR_AREA = '".$check->CHR_AREA."' AND CHR_LKB_NO = '".$this->get_id($this->input->post('CHR_LKB_NO'))."' AND CHR_VALIDATE_LEADER IS NOT NULL AND CHR_DEL_FLG IS NULL"),'tt_ng_record_l');
				return $result;
			elseif ($check && !empty($check->CHR_VALIDATE_MSU)): 
				return array('status' => 'error', 'message' => "NG Component Sudah diterima oleh MSU");
			else:
				return array('status' => 'error', 'message' => "Tidak Ada Data NG Component");
			endif;
		else:
			$session = $this->session->all_userdata();
			$LKB_NO = $this->input->post('CHR_LKB_NO');
			$result_h = $this->execute(array('where' => array('CHR_LKB_NO' => $LKB_NO)),'tt_ng_record_h',true);
			// check
			if ( empty($LKB_NO)) return array('status' => 'error', 'message' => "Tidak ada data NG Komponen.");
			if (!empty($result_h->CHR_VALIDATE_MSU)) return array('status' => 'error', 'message' => "NG Component Sudah diterima oleh MSU");

			//start record
			$record_h['INT_NPK_MSU'] = $session['NPK'];
			$record_h['CHR_VALIDATE_MSU'] = 'X';
			$record_h['CHR_IP_MSU'] = $this->get_ip_client();
			$record_h['CHR_USER_MSU'] = $session['USERNAME'];
			$record_h['CHR_VALIDATE_DATE_MSU'] = date('Ymd');
			$record_h['CHR_VALIDATE_TIME_MSU'] = date('His');

			// start transaction manual
			$this->db->trans_begin();

			// update all record h
			$this->db->where('CHR_LKB_NO',$this->input->post('CHR_LKB_NO'));
			$this->db->update($this->tt_ng_record_h,$record_h);
			

			if ($msu) {

			$result_l = $this->execute(array('select' =>'TT_NG_RECORD_L.*, TT_NG_RECORD_H.INT_NUMBER_PROD','join' => array('TT_NG_RECORD_H','TT_NG_RECORD_H.INT_NUMBER=TT_NG_RECORD_L.INT_NUMBER'),'where' => "TT_NG_RECORD_L.CHR_LKB_NO = '".$LKB_NO."' AND CHR_DEL_FLG IS NULL"),'tt_ng_record_l');


			if (!$result_l)  return array('status' => 'error', 'message' => "Tidak ada data NG Komponen.");

			$movement_h['CHR_PLANT'] = '600';
			$movement_h['CHR_DATE'] = date('Ymd');
			$movement_h['CHR_TYPE_TRANS'] = 'STNG';
			$movement_h['CHR_VALIDATE'] = 'X';
			$movement_h['CHR_REMARKS'] = $LKB_NO;
			$movement_h['CHR_DOCUMENT_DATE'] = date('Ymd');
			$movement_h['CHR_MVMT_TYPE'] = '311';
			$movement_h['CHR_NPK'] = $session['NPK'];
			$movement_h['CHR_IP'] = $this->get_ip_client();
			$movement_h['CHR_USER'] = $session['USERNAME'];
			$movement_h['CHR_DATE_ENTRY'] = date('Ymd');
			$movement_h['CHR_TIME_ENTRY'] = date('His');

			$result_l_sloc = $result_l;
			$mvmt_type = array_shift($result_l_sloc); 
			
			$scrapping_h['CHR_PLANT'] = '600';
			$scrapping_h['INT_NUMBER'] = $result_h->INT_NUMBER;
			$scrapping_h['CHR_LKB_NO'] = $LKB_NO;
			$scrapping_h['CHR_DATE'] = date('Ymd');
			$scrapping_h['CHR_MVMT_TYPE'] = (str_replace(" ", "", $mvmt_type->CHR_SLOC_FROM) === "EN01" )? 'ZT1' : 'Z51';
			$scrapping_h['CHR_IP'] = $this->get_ip_client();
			$scrapping_h['CHR_USER'] = $session['USERNAME'];
			$scrapping_h['INT_NPK'] = $session['NPK'];
			$scrapping_h['CHR_DATE_ENTRY'] = date('Ymd');
			$scrapping_h['CHR_TIME_ENTRY'] = date('His');
			$scrapping_h['CHR_UPLOAD'] = '0';

			//upddate movement h
			$this->db->insert($this->tt_movement_h,$movement_h);
			$movement_h_no = $this->db->insert_id();
			// save data record h			
			//update srcapping
			$this->db->insert($this->tt_scrapping_h,$scrapping_h);
			$scrapping_h_no = $result_h->INT_NUMBER;

			$movement_l = array();
			$scrapping_l = array();
				foreach ($result_l as $key => $value) {
					$part= @$this->nolocking->execute(array('where' => array('CHR_PART_NO' => $value->CHR_PART_NO)),'tm_parts',true);

					// edit sella 06-03-2016
					//$movement_l['CHR_DATE'] = date('Ymd');
					//$movement_l['CHR_PLANT'] = '600';
					$movement_l[$key]['INT_NUMBER'] = @$movement_h_no;
					$movement_l[$key]['CHR_PART_NO'] = $value->CHR_PART_NO;
					$movement_l[$key]['CHR_PART_NAME'] = $part->CHR_PART_NAME;
					$movement_l[$key]['CHR_PART_NO_DASH'] = $part->CHR_PART_NO_DASH;
					$movement_l[$key]['CHR_SLOC_FROM'] = (str_replace(" ", "", $value->CHR_SLOC_TO) == "RE01")? $value->CHR_SLOC_FROM : $value->CHR_SLOC_TO;
					$movement_l[$key]['CHR_SLOC_TO'] = "RE01";//$value->CHR_SLOC_TO;
					$movement_l[$key]['INT_TOTAL_QTY'] = $value->INT_TOTAL_QTY;
					$movement_l[$key]['CHR_IP'] = $this->get_ip_client();
					$movement_l[$key]['CHR_USER'] =  $session['USERNAME'];
					$movement_l[$key]['CHR_DATE_ENTRY'] = date('Ymd');
					$movement_l[$key]['CHR_TIME_ENTRY'] = date('His');

					//$scrapping_l['CHR_PLANT'] = '600';
					//$scrapping_l['CHR_DATE'] = date('Ymd');
					$scrapping_l[$key]['INT_NUMBER'] = @$scrapping_h_no;
					$scrapping_l[$key]['CHR_PART_NO'] = $value->CHR_PART_NO;
					$scrapping_l[$key]['CHR_PART_NAME'] = $part->CHR_PART_NAME;
					$scrapping_l[$key]['INT_QTY'] = $value->INT_TOTAL_QTY;
					$scrapping_l[$key]['CHR_SLOC_FROM'] = (str_replace(" ", "", $value->CHR_SLOC_TO) == "RE01")? $value->CHR_SLOC_FROM : $value->CHR_SLOC_TO;
					$scrapping_l[$key]['CHR_SLOC'] = "RE01"; //$value->CHR_SLOC_TO;
					$scrapping_l[$key]['CHR_IP'] = $this->get_ip_client();
					$scrapping_l[$key]['CHR_USER'] =  $session['USERNAME'];
					$scrapping_l[$key]['CHR_DATE_ENTRY'] = date('Ymd');
					$scrapping_l[$key]['CHR_TIME_ENTRY'] = date('His');
					$scrapping_l[$key]['CHR_WORK_CENTER'] = (str_replace(" ", "", $value->CHR_WORK_CENTER))? $value->CHR_WORK_CENTER : $value->CHR_WORK_CENTER;
					/*print_r($movement_l);
					print_r($scrapping_h);*/
					$this->db->insert($this->tt_movement_l,$movement_l[$key]);
					$this->db->insert($this->tt_scrapping_l,$scrapping_l[$key]);
						
				}
			} else {
				$record_l['CHR_REJECT'] = 'X';
				$this->db->where('CHR_LKB_NO',$this->input->post('CHR_LKB_NO'));
				$this->db->update($this->tt_ng_record_l,$record_l);
			}
			//die();
			if ($this->db->trans_status() === FALSE) {
			    $this->db->trans_rollback();
			    return array('status' => 'error','message' => 'Data tidak bisa di simpan, coba lagi.');
			} else {
			    $this->db->trans_commit();
			    return array('status' => 'error','message' => 'Penerimaan LKB Berhasil.');
			}
		endif;
	}
	/*********************** Method ************************************/
	// session model for adding display and get count data
	public function store_session($name, array $data)
	{
		
		$save[] = $data;

		$data_session = $this->kb_session->get($name);
		if (!empty($data_session)) 
		{
			$save = array_merge($data_session,$save);
		}
		$this->kb_session->set($name,$save);
	}
	public function display_session($name)
	{
		return $this->kb_session->get($name);
	}
	public function total_items($name)
	{
		return ($this->kb_session->get($name))? count($this->kb_session->get($name)) : 0 ;
	}
	public function clear_session()
	{
		return $this->kb_session->clear();
	}
	public function get_id($data='')
	{
		$explode = explode(',', $data);
		return ($explode[0])? $explode[0] : ' ';
	}
	// other method need for adding data
	private function get_ip_client() {
        if (!empty($_SERVER["HTTP_CLIENT_IP"])) {
            //check for ip from share internet
            $ip = $_SERVER["HTTP_CLIENT_IP"];
        } elseif (!empty($_SERVER["HTTP_X_FORWARDED_FOR"])) {
            // Check for the Proxy User
            $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
        } else {
            $ip = $_SERVER["REMOTE_ADDR"];
        }

        // This will print user's real IP Address
        // does't matter if user using proxy or not.
        return $ip;
    }
	//add by reza
	public function findBySql($sql) {
		$query = $this->db->query($sql);
        return $query->result();
	}
	//end

}