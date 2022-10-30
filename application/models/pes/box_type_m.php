<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Box_Type_m extends CI_Model {

	public function __construct() {
        parent::__construct();
        $sap = $this->load->database('zsap',TRUE);
    }

	public function GetCoba(){
		$data= $this->db->query('select*from coba');
		return $data->result_array();
	}

	public function InsertData($tablename,$data){
		$res = $this->db->insert($tablename,$data);
		return $res;
		}

	public function UpdateData($tablename,$data,$where){
		$res = $this->db->update($tablename,$data,$where);
		return $res;
	}

	public function DeleteData($tablename,$where){
		$res = $this->db->delete($tablename,$where);
		return $res;
	}

	public function findBySql($sql) {
       $sap = $this->load->database('zsap',TRUE);
       $query = $sap->query($sql);
       return $query->result();
    }

 

}
