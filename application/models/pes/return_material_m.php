<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Return_material_m extends CI_Model {

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
  function UpdateReturn($data, $id, $id1) { 
    $sap = $this->load->database('zsap',TRUE);
        $sap->where('id', $id);
        $sap->where('CHR_NPK', $id1);
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

    function cekData($id) {
       $sap = $this->load->database('zsap',TRUE);
        $find_id = $sap->query("SELECT TOP 1 no FROM TW_RETURN WHERE CHR_NPK='" . $id . "' order by no DESC ");
        if ($find_id->num_rows() > 0) {
            return $find_id->result();
        }
        return false;
    }

  function addProduct($data, $table){
        if (is_array($data)) {
            $sap = $this->load->database('zsap',TRUE);
            $sap->insert($table, $data);
        }

    }
    function check_backno($id) {
        $sap = $this->load->database('zsap',TRUE);
        $find_id = $sap->query("SELECT CHR_BACK_NO from TM_PARTS where CHR_BACK_NO = '" . $id . "'");
        if ($find_id->num_rows() > 0) {
            return $find_id->result();
        }
        return false;
    }
    function checkUom($id) {
        $sap = $this->load->database('zsap',TRUE);
        $find_id = $sap->query("SELECT CHR_PART_UOM FROM TM_PARTS WHERE CHR_BACK_NO = '" . $id . "'");
        if ($find_id->num_rows() > 0) {
            return $find_id->result();
        }
        return false;
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
  public function search($delivery){
        $sap = $this->load->database('zsap',TRUE);
        $sap->like('CHR_BACK_NO', $delivery, 'both');

        return $sap->get('TM_PARTS')->result();
    }
  

}
?>
