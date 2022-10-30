<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Return_stamping_m extends CI_Model {

	public function __construct() {
        parent::__construct();
        $sap = $this->load->database('zsap',TRUE);
    }

	public function get()
	{
		$data= $this->db->query('select*from TT_PRODUCTION_RESULT');
	
		return $data->result_array();
		
	}
	 public function get_for($id){
        $sql= "select * from dbo.TT_PRODUCTION_RESULT where INT_NUMBER = '".$id. "'";
        return $this->db->query($sql)->row();
    }
     public function get_chr_ip($ip){
        $sql= "select * from dbo.TM_USER where CHR_IP = '".$ip. "'";
        return $this->db->query($sql)->row();
    }

	function UpdateFlag($data, $id) {	
		$sap = $this->load->database('zsap',TRUE);
       	$sap->where('INT_KANBAN_NO', $id);
        $sap->update('TM_KANBAN', $data);
		return $sap;
	}

	

	function UpdateSerial($data, $id) {	
		$sap = $this->load->database('zsap',TRUE);
       	$sap->where('INT_LAST_SERIAL', $id);
        $sap->update('TM_KANBAN', $data);
		return $sap;
	}
	function UpdateReturn($data, $id) {	
		$sap = $this->load->database('zsap',TRUE);
       	$sap->where('no', $id);
        $sap->update('TW_RETURN', $data);
		return $sap;
	}

	public function DeleteData($sql){
		$sap = $this->load->database('zsap',TRUE);
        $query = $sap->query($sql);
		return $query;
	}

	public function findBySql($sql) {
       $sap = $this->load->database('zsap',TRUE);
       $query = $sap->query($sql);
       return $query->result();
    }
    public function getData($sql) {
       $sap = $this->load->database('zsap',TRUE);
       $query = $sap->query($sql);
       return $query->result();
    }

 	function addProduct($data, $table){
        if (is_array($data)) {
            $sap = $this->load->database('zsap',TRUE);
            $sap->insert($table, $data);
        }

    }
    public function execute($option_query,$tbl='tm_area',$shift=false ){
     
		// check option & query is array 
   		if (is_array($option_query))
   		{
   			// extract option & query
   			foreach ($option_query as $option => $query) {
   				$this->db->$option($query);
   			}
   		}

		$q = $this->db->get($this->$tbl);

		$return = ($shift && @$q->num_rows() == 1)? array_shift($q->result()) : $q->result() ;  

		return ($return)? $return : false ;
	}
	public function screen_store($post='',$name){
		
		$session = $this->session->all_userdata();
		//print_r($session);
		// save data to tt_ng_record_l

		$record['CHR_SLOC_FROM'] = $post['CHR_SLOC_FROM'];
		//var_dump($record);
		foreach ($session[$name] as $key => $value) {
			$record['CHR_BACK_NO'] =  $value['CHR_BACK_NO'];
			$record['CHR_PART_NO'] = $value['CHR_PART_NO'];
			$record['INT_TOTAL_QTY'] = $value['INT_TOTAL_QTY'];

			$save = $this->db->insert($this->tt_ng_record_l, $record);
		}
		//print_r($data);
		//return $save;
	}
  	public function store_session($name, array $data)
	{
		
		$save[] = $data;
		$data_session = $this->session->userdata($name);
		if (!empty($data_session)) 
		{
			$save = array_merge($data_session,$save);
		}
		$this->session->set_userdata($name,$save);
	}
	

}
?>
