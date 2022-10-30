<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kanban_master_m extends CI_Model {

    public function __construct() {
        parent::__construct();
        $sap = $this->load->database('zsap',TRUE);
    }

    public function GetCoba(){
        $data= $this->db->query('select*from coba');
        return $data->result_array();
    }
    public function selectresult(){
        $data = $this->db->query("SELECT B.CHR_DATE,B.CHR_WORK_CENTER,B.CHR_PART_NO,B.CHR_BACK_NO,B.CHR_PART_NAME,A.INT_NUMBER,SUM(A.INT_TOTAL_QTY_NG) AS QTY_NG,MAX(A.CHR_REJECT_CODE) AS REJECT_CODE FROM TT_PRODUCTION_REPAIR A INNER JOIN TT_PRODUCTION_RESULT B ON A.INT_NUMBER = B.INT_NUMBER WHERE A.INT_NUMBER IN (SELECT INT_NUMBER FROM TT_PRODUCTION_RESULT WHERE CHR_VALIDATE = 'X' AND CHR_UPDATE_REPAIR IS NULL) GROUP BY A.INT_NUMBER,B.CHR_DATE,B.CHR_WORK_CENTER,B.CHR_PART_NO,B.CHR_BACK_NO,B.CHR_PART_NAME");//query
        return $data->result_array();
    }
    public function selectresultrole($respon){      
        $data = $this->db->query("SELECT B.CHR_DATE,B.CHR_WORK_CENTER,B.CHR_PART_NO,B.CHR_BACK_NO,B.CHR_PART_NAME,A.INT_NUMBER,SUM(A.INT_TOTAL_QTY_NG) AS QTY_NG,MAX(A.CHR_REJECT_CODE) AS REJECT_CODE FROM TT_PRODUCTION_REPAIR A INNER JOIN TT_PRODUCTION_RESULT B ON A.INT_NUMBER = B.INT_NUMBER INNER JOIN
                        TM_PROCESS ON B.CHR_WORK_CENTER = TM_PROCESS.CHR_WORK_CENTER
                        WHERE A.INT_NUMBER IN (SELECT INT_NUMBER FROM TT_PRODUCTION_RESULT WHERE CHR_VALIDATE = 'X' AND CHR_UPDATE_REPAIR IS NULL) GROUP BY A.INT_NUMBER,B.CHR_DATE,B.CHR_WORK_CENTER,B.CHR_PART_NO,B.CHR_BACK_NO,B.CHR_PART_NAME, TM_PROCESS.CHR_PERSON_RESPONSIBLE
                        HAVING      (TM_PROCESS.CHR_PERSON_RESPONSIBLE = '$respon')");//query       
        return $data->result_array();
    }

    public function get(){
        $data= $this->db->query('select*from dbo.TT_PRODUCTION_RESULT');
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
    function InsertData($tablename,$data){
        $res = $this->db->insert($tablename,$data);
        return $res;
    }

    function UpdateData($data, $id) {   
        $sap = $this->load->database('zsap',TRUE);
        $sap->where('INT_KANBAN_NO', $id);
        $sap->update('TM_KANBAN', $data);
        return $sap;
    }

    function UpdateBackno($data, $id) {   
        $sap = $this->load->database('zsap',TRUE);
        $sap->where('CHR_PART_NO', $id);
        $sap->update('TM_KANBAN', $data);
        return $sap;
    }   
    
    function UpdateBackno_All_STO($data, $id) {   
        $sap = $this->load->database('zsap',TRUE);
        $sap->where('CHR_ID_PART', $id);
        $sap->update('TM_STO', $data);
        return $sap;
    }  

    function UpdateBackno_TM_STO($data, $id, $id2) {   
        $sap = $this->load->database('zsap',TRUE);
        $sap->where('CHR_ID_PART', $id);
        $sap->where('CHR_KODE_VENDOR', $id2);
        $sap->update('TM_STO', $data);
        return $sap;
    }

    function UpdateDataOr($data, $id, $id1,$id2) {   
        $sap = $this->load->database('zsap',TRUE);
        $sap->where('CHR_PART_NO', $id);
        $sap->where('CHR_KANBAN_TYPE', $id1);
        $sap->where('CHR_WC_VENDOR', $id2);
        $sap->update('TM_KANBAN', $data);
        return $sap;
    } 
    function UpdateDataPass($data, $id, $id1) {   
        $sap = $this->load->database('zsap',TRUE);
        $sap->where('CHR_PART_NO', $id);
        $sap->where('CHR_SLOC_TO', $id1);
        $sap->update('TM_KANBAN', $data);
        return $sap;
    }   

    function UpdateDataPass2($data, $id, $id1, $id2, $id3) {   
        $sap = $this->load->database('zsap',TRUE);
        $sap->where('CHR_PART_NO', $id);
        $sap->where('CHR_SLOC_TO', $id1);
        $sap->where('CHR_SLOC_FROM', $id2);
        $sap->where('CHR_KANBAN_TYPE', $id3);
        $sap->update('TM_KANBAN', $data);
        return $sap;
    } 

    function UpdateData2($data, $id, $id1) {   
        $sap = $this->load->database('zsap',TRUE);
        $sap->where('CHR_PART_NO', $id AND 'CHR_WC_VENDOR', $id1);
        $sap->update('TM_KANBAN', $data);
        return $sap;
    }   

    function UpdateBox($data, $id) {    
        $sap = $this->load->database('zsap',TRUE);
        $sap->where('CHR_BOX_TYPE', $id);
        $sap->update('TM_BOX_TYPE', $data);
        return $sap;
    }

    function updateTMParts($data, $id) {    
        $sap = $this->load->database('zsap',TRUE);
        $sap->where('CHR_PART_NO', $id);
        $sap->update('TM_PARTS', $data);
        return $sap;
    }

    function UpdateFlag($data, $id) {   
        $sap = $this->load->database('zsap',TRUE);
        $sap->where('CHR_PART_NO', $id);
        $sap->update('TM_KANBAN', $data);
        return $sap;
    }

    function UpdateFlagSts($data, $id, $idsp) {   
        $sap = $this->load->database('zsap',TRUE);
        $sap->where('CHR_PART_NO', $id);
        $sap->where('CHR_WC_VENDOR', $idsp);
        $sap->update('TM_KANBAN', $data);
        return $sap;
    }

    function UpdateFlagStsUp($data, $id, $idslt) {   
        $sap = $this->load->database('zsap',TRUE);
        $sap->where('CHR_PART_NO', $id);
        $sap->where('CHR_SLOC_TO', $idslt);
        $sap->update('TM_KANBAN', $data);
        return $sap;
    }

     public function DeleteDataKanban($id, $idsp){
        $sap = $this->load->database('zsap',TRUE);
        $sap->where('CHR_PART_NO', $id);
        $sap->where('CHR_WC_VENDOR', $idsp);
        $sap->delete('TM_KANBAN');
        return $sap;
    }

    public function DeleteDataKanbanUp($id, $idslt){
        $sap = $this->load->database('zsap',TRUE);
        $sap->where('CHR_PART_NO', $id);
        $sap->where('CHR_SLOC_TO', $idslt);
        $sap->delete('TM_KANBAN');
        return $sap;
    }
    
    function DeleteTMSTO($data, $id) {   
        $sap = $this->load->database('zsap',TRUE);
        $sap->where('CHR_PART_NO', $id);
        $sap->update('TM_KANBAN', $data);
        return $sap;
    }

    function UpdateSerial($data, $id) { 
        $sap = $this->load->database('zsap',TRUE);
        $sap->where('INT_LAST_SERIAL', $id);
        $sap->update('TM_KANBAN', $data);
        return $sap;
    }

    function UpdateLastSerial($data, $id) { 
        $sap = $this->load->database('zsap',TRUE);
        $sap->where('INT_KANBAN_NO', $id);
        $sap->update('TM_KANBAN', $data);
        return $sap;
    }
    public function DeleteData($tablename,$where){
        $sap = $this->load->database('zsap',TRUE);
        $sap->delete($tablename,$where);
    
    }

    public function findBySql($sql) {
       $sap = $this->load->database('zsap',TRUE);
       $query = $sap->query($sql);
       return $query->result();
    }

    function check($id) {
        $sap = $this->load->database('zsap',TRUE);
        $find_id = $sap->query("SELECT DISTINCT CHR_CUS_PART_NO FROM TM_SHIPPING_PARTS WHERE CHR_PART_NO ='" . $id . "'");
        if ($find_id->num_rows() > 0) {
            return $find_id->result();
        }
        return false;
    }

    function checkFlagpr($id) {
        $sap = $this->load->database('zsap',TRUE);
        $find_id = $sap->query("SELECT CHR_FLAG_DELETE FROM TM_KANBAN WHERE CHR_PART_NO = '" . $id . "' AND CHR_KANBAN_TYPE = '1'");
        if ($find_id->num_rows() > 0) {
            return true;
        }
        return false;
    }
    function checkFlagor($id) {
        $sap = $this->load->database('zsap',TRUE);
        $find_id = $sap->query("SELECT CHR_FLAG_DELETE FROM TM_KANBAN WHERE CHR_PART_NO = '" . $id . "' AND CHR_KANBAN_TYPE = '0'");        
        if ($find_id->num_rows() > 0) {
            return true;
        }
        return false;
    }
    function checkFlagsp($id) {
        $sap = $this->load->database('zsap',TRUE);
        $find_id = $sap->query("SELECT CHR_FLAG_DELETE FROM TM_KANBAN WHERE CHR_PART_NO = '" . $id . "' AND CHR_KANBAN_TYPE = '4'");
        if ($find_id->num_rows() > 0) {
            return true;
        }
        return false;
    }
    function checkFlagpu($id) {
        $sap = $this->load->database('zsap',TRUE);
        $find_id = $sap->query("SELECT CHR_FLAG_DELETE FROM TM_KANBAN WHERE CHR_PART_NO = '" . $id . "' AND CHR_KANBAN_TYPE = '5'");
    
        if ($find_id->num_rows() > 0) {
            return true;
        }
        return false;
    }
    function checkFlagpup($id) {
        $sap = $this->load->database('zsap',TRUE);
        $find_id = $sap->query("SELECT CHR_FLAG_DELETE FROM TM_KANBAN WHERE CHR_PART_NO = '" . $id . "' AND CHR_KANBAN_TYPE = '6'");
    
        if ($find_id->num_rows() > 0) {
            return true;
        }
        return false;
    }

    function checkpv($id,$id1) {
        $sap = $this->load->database('zsap',TRUE);
        $find_id = $sap->query("SELECT CHR_PART_NO, CHR_WC_VENDOR FROM [dbo].[TM_KANBAN] where CHR_PART_NO = '" . $id . "' AND CHR_WC_VENDOR ='" . $id1 . "' AND CHR_KANBAN_TYPE= '5'");
        if ($find_id->num_rows() > 0) {
            return true;
        }
        return false;
    }

    function checkpvp($id,$id1,$id2) {
        $sap = $this->load->database('zsap',TRUE);
        $find_id = $sap->query("SELECT CHR_PART_NO, CHR_SLOC_FROM, CHR_SLOC_TO FROM [dbo].[TM_KANBAN] where CHR_PART_NO = '" . $id . "' AND CHR_SLOC_FROM ='" . $id1 . "' AND CHR_SLOC_TO ='" . $id2 . "' AND CHR_KANBAN_TYPE= '6'");
        if ($find_id->num_rows() > 0) {
            return true;
        }
        return false;
    }

    function checkpv1($id,$id1) {
        $sap = $this->load->database('zsap',TRUE);
        $find_id = $sap->query("SELECT CHR_PART_NO, CHR_WC_VENDOR FROM [dbo].[TM_KANBAN] where CHR_PART_NO = '" . $id . "' AND CHR_WC_VENDOR ='" . $id1 . "' AND CHR_KANBAN_TYPE= '1'");
        if ($find_id->num_rows() > 0) {
            return $find_id->result();
        }
        return false;
    }

    function checksid($id,$id1) {
        $sap = $this->load->database('zsap',TRUE);
        $find_id = $sap->query("SELECT CHR_PART_NO, CHR_WC_VENDOR FROM [dbo].[TM_KANBAN] where CHR_PART_NO = '" . $id . "' AND CHR_WC_VENDOR ='" . $id1 . "' AND CHR_KANBAN_TYPE= '0'");
        if ($find_id->num_rows() > 0) {
            return true;
        }
        return false;
    }

    function checksid1($id,$id1) {
        $sap = $this->load->database('zsap',TRUE);
        $find_id = $sap->query("SELECT CHR_PART_NO, CHR_WC_VENDOR FROM [dbo].[TM_KANBAN] where CHR_PART_NO = '" . $id . "' AND CHR_WC_VENDOR ='" . $id1 . "' AND CHR_KANBAN_TYPE= '4'");
        if ($find_id->num_rows() > 0) {
            return true;
        }
        return false;
    }

    function getsid1($id) {
        $sap = $this->load->database('zsap',TRUE);
        $find_id = $sap->query("SELECT DISTINCT CHR_WC_VENDOR FROM [dbo].[TM_KANBAN] where CHR_PART_NO = '" . $id . "' AND CHR_KANBAN_TYPE= '4'");
        if ($find_id->num_rows() > 0) {
            return $find_id->result();
        }
        return false;
    }

    
    public function Updateket($updateket) {
       $sap = $this->load->database('zsap',TRUE);
       $query = $sap->query($updateket);
       return $query;
    }

    function check_partno_tm_sto($id,$id2) {
        $sap = $this->load->database('zsap',TRUE);
        $find_id = $sap->query("SELECT CHR_ID_PART FROM TM_STO WHERE CHR_ID_PART = '" . $id . "' AND CHR_KODE_VENDOR = '".$id2."' ");
        if ($find_id->num_rows() > 0) {
            return $find_id->result();
        }
        return false;
    }

    function check_nokanban($id,$id1,$id2) {
        $sap = $this->load->database('zsap',TRUE);
        $find_id = $sap->query("SELECT INT_KANBAN_NO 'nokanban' FROM [dbo].[TM_KANBAN] WHERE CHR_KANBAN_TYPE ='" . $id . "' and CHR_PART_NO ='" . $id1 . "' and CHR_WC_VENDOR ='" . $id2 . "'");
        if ($find_id->num_rows() > 0) {
            return $find_id->result();
        }
        return false;
    }
    
    function check_nokanban_so($id,$id1) {
        $sap = $this->load->database('zsap',TRUE);
        $find_id = $sap->query("SELECT INT_KANBAN_NO 'nokanban' FROM [dbo].[TM_KANBAN] WHERE (CHR_KANBAN_TYPE ='5' or CHR_KANBAN_TYPE ='6')  and CHR_PART_NO ='" . $id1 . "' ");
        if ($find_id->num_rows() > 0) {
            return $find_id->result();
        }
        return false;
    }
    function check_nokanbanpass($id,$id1,$id2) {
        $sap = $this->load->database('zsap',TRUE);
        $find_id = $sap->query("SELECT INT_KANBAN_NO 'nokanban' FROM [dbo].[TM_KANBAN] WHERE CHR_KANBAN_TYPE ='" . $id . "' and CHR_PART_NO ='" . $id1 . "' and CHR_SLOC_TO ='" . $id2 . "'");
        if ($find_id->num_rows() > 0) {
            return $find_id->result();
        }
        return false;
    }

    function check_backno($id) {
        $sap = $this->load->database('zsap',TRUE);
        $find_id = $sap->query("select CHR_BACK_NO from TM_KANBAN where CHR_BACK_NO = '" . $id . "' and (CHR_FLAG_DELETE is null or CHR_FLAG_DELETE = '')");
        if ($find_id->num_rows() > 0) {
            return $find_id->result();
        }
        return false;
    }
    function check_backno2($id) {
        $sap = $this->load->database('zsap',TRUE);
        $find_id = $sap->query("select CHR_BACK_NO from TM_KANBAN where CHR_PART_NO = '" . $id . "'");
        if ($find_id->num_rows() > 0) {
            return $find_id->result();
        }
        return false;
    }
    function checkpart($id) {
        $sap = $this->load->database('zsap',TRUE);
        $find_id = $sap->query("select CHR_PART_NO from TM_KANBAN where CHR_BACK_NO = '" . $id . "'");
        if ($find_id->num_rows() > 0) {
            return $find_id->result();
        }
        return false;
    }

    function check_next($id) {
        $sap = $this->load->database('zsap',TRUE);
        $find_id = $sap->query("SELECT CHR_WORK_CENTER from TM_KANBAN where CHR_PART_NO = '" . $id . "' and CHR_KANBAN_TYPE = '5'");
        if ($find_id->num_rows() > 0) {
            return $find_id->result();
        }
        return false;
    }
    function check_nextpk($id,$id1) {
        $sap = $this->load->database('zsap',TRUE);
        $find_id = $sap->query("SELECT CHR_WORK_CENTER from TM_KANBAN where CHR_PART_NO = '" . $id . "' AND CHR_WC_VENDOR = '". $id1 ."' ");
        if ($find_id->num_rows() > 0) {
            return $find_id->result();
        }
        return false;
    }
    function check_nextpk5($id,$id1) {
        $sap = $this->load->database('zsap',TRUE);
        $find_id = $sap->query("SELECT CHR_WORK_CENTER from TM_KANBAN where CHR_PART_NO = '" . $id . "' AND CHR_WC_VENDOR = '". $id1 ."' AND CHR_KANBAN_TYPE = '5' ");
        if ($find_id->num_rows() > 0) {
            return $find_id->result();
        }
        return false;
    }
    function check_pv($id) {
        $sap = $this->load->database('zsap',TRUE);
        $find_id = $sap->query("SELECT DISTINCT CHR_PV from TM_PROCESS_PARTS where CHR_PART_NO = '" . $id . "'");
        if ($find_id->num_rows() > 0) {
            return $find_id->result();
        }
        return false;
    }

    function addProduct($data, $table){
        $sap = $this->load->database('zsap',TRUE);
        if (is_array($data)) {
            $sql=$sap->insert($table,$data);
            return $sql;
        }

    }

    function getDataprint($sql){
        $sprint = $this->load->database('zprint',TRUE);
        $query = $sprint->query($sql);
        return $query->result();

    }
    function getSelfpro($sql) {
       $sprint = $this->load->database('zprint',TRUE);
       $find_id = $sprint->query($sql);
        return $find_id->result();
    }
    function getPv($id,$id1) {
        $sprint = $this->load->database('zprint',TRUE);
        $find_id = $sprint->query("SELECT CHR_WORK_CENTER FROM [dbo].[TM_PROCESS_PARTS] WHERE  CHR_PART_NO = '" . $id . "' and INT_PV ='" . $id1 . "'");
        if ($find_id->num_rows() > 0) {
            return $find_id->result_array();
        }
        return false;
    }
    function cekType(){
        $sprint = $this->load->database('zprint',TRUE);
        $find_id = $sprint->query($sql);
        return $find_id->num_rows();
    }

    public function search($delivery){
        $sap = $this->load->database('zsap',TRUE);
        $sap->like('CHR_PART_NO', $delivery, 'both');
        return $sap->get('TM_PARTS')->result();
    }
    
    public function searchpartno($delivery){
        $sap = $this->load->database('zsap',TRUE);
        $sap->like('CHR_PART_NO', $delivery, 'both');
        return $sap->get('TM_PROCESS_PARTS')->result();
    }

    public function searchOldOr($delivery){
        $sap = $this->load->database('zsap',TRUE);
        $sap->like('CHR_PART_NO', $delivery, 'both');
        return $sap->get('TM_KANBAN')->result();
    }

    public function searchOldPr($delivery){
        $sap = $this->load->database('zsap',TRUE);
        $sap->like('CHR_PART_NO', $delivery, 'both');
        return $sap->get('TM_KANBAN')->result();
    }

    public function searchOldSp($delivery){
        $sap = $this->load->database('zsap',TRUE);
        $sap->like('CHR_PART_NO', $delivery, 'both');
        return $sap->get('TM_KANBAN')->result();
    }

    public function searchOldPu($delivery){
        $sap = $this->load->database('zsap',TRUE);
        $sap->like('CHR_PART_NO', $delivery, 'both');
        return $sap->get('TM_KANBAN')->result();
    }

    public function searchOldPup($delivery){
        $sap = $this->load->database('zsap',TRUE);
        $sap->like('CHR_PART_NO', $delivery, 'both');
        return $sap->get('TM_KANBAN')->result();
    }

    function cekPartname($id){
        $sap = $this->load->database('zsap',TRUE);
        $find_id = $sap->query("SELECT CHR_PART_NAME from [dbo].[TM_PARTS] where CHR_PART_NO = '" . $id . "'");
        if ($find_id->num_rows() > 0) {
            return $find_id->result();
        }
        return false;
    }
    function cekPartname1($id){
        $sap = $this->load->database('zsap',TRUE);
        $find_id = $sap->query("SELECT CHR_PART_NAME from [dbo].[TM_PARTS] where CHR_PART_NO = '" . $id . "'");
        if ($find_id->num_rows() > 0) {
            return $find_id->result();
        }
        return false;
    }
    function cekSelfpro($id){
        $sap = $this->load->database('zsap',TRUE);
        $find_id = $sap->query("SELECT CHR_WORK_CENTER FROM [dbo].[TM_PROCESS_PARTS] WHERE CHR_PART_NO = '" . $id . "'");
        if ($find_id->num_rows() > 0) {
            return $find_id->result();
        }
        return false;
    }
    function cekSerial($id){
        $sap = $this->load->database('zsap',TRUE);
        $find_id = $sap->query("SELECT INT_KANBAN_NO FROM [dbo].[TM_KANBAN] WHERE CHR_PART_NO = '" . $id . "' AND CHR_KANBAN_TYPE='6' ");
        if ($find_id->num_rows() > 0) {
            return $find_id->result();
        }
        return false;
    }
    function cekSerialPass($id,$id1){
        $sap = $this->load->database('zsap',TRUE);
        $find_id = $sap->query("SELECT INT_KANBAN_NO FROM [dbo].[TM_KANBAN] WHERE CHR_PART_NO = '" . $id . "' AND CHR_SLOC_TO = '" . $id1 . "' AND CHR_KANBAN_TYPE='6' ");
        if ($find_id->num_rows() > 0) {
            return $find_id->result();
        }
        return false;
    }
    function cekFlag($id){
        $sap = $this->load->database('zsap',TRUE);
        $find_id = $sap->query("SELECT CHR_FLAG_DELETE FROM [dbo].[TM_KANBAN] WHERE CHR_PART_NO = '" . $id . "'");
        if ($find_id->num_rows() > 0) {
            return $find_id->result();
        }
        return false;
    }
    function cekFlagU($id){
        $sap = $this->load->database('zsap',TRUE);
        $find_id = $sap->query("SELECT CHR_FLAG_DELETE FROM [dbo].[TM_KANBAN] WHERE CHR_PART_NO = '" . $id . "' AND CHR_FLAG_DELETE = 'X'");
        if ($find_id->num_rows() > 0) {
            return true;
        }
        return false;
    }
    function cekFlagUS($id,$idsp){
        $sap = $this->load->database('zsap',TRUE);
        $find_id = $sap->query("SELECT CHR_FLAG_DELETE FROM [dbo].[TM_KANBAN] WHERE CHR_PART_NO = '" . $id . "' AND CHR_WC_VENDOR = '" . $idsp . "' AND CHR_FLAG_DELETE = 'X'");
        if ($find_id->num_rows() > 0) {
            return true;
        }
        return false;
    }
    function cekFlagUSP($id,$idslt){
        $sap = $this->load->database('zsap',TRUE);
        $find_id = $sap->query("SELECT CHR_FLAG_DELETE FROM [dbo].[TM_KANBAN] WHERE CHR_PART_NO = '" . $id . "' AND CHR_SLOC_TO = '" . $idslt . "' AND CHR_FLAG_DELETE = 'X'");
        if ($find_id->num_rows() > 0) {
            return true;
        }
        return false;
    }
    function cekFlagpass($id){
        $sap = $this->load->database('zsap',TRUE);
        $find_id = $sap->query("SELECT CHR_FLAG_DELETE FROM [dbo].[TM_KANBAN] WHERE CHR_PART_NO = '" . $id . "'");
        if ($find_id->num_rows() > 0) {
            return $find_id->result();
        }
        return false;
    }
    function getQty($id,$id1){
        $sap = $this->load->database('zsap',TRUE);
        $find_id = $sap->query("SELECT INT_QTY_PER_BOX FROM [dbo].[TM_KANBAN] WHERE CHR_PART_NO = '" . $id . "' AND CHR_WC_VENDOR = '" . $id1 . "' AND (CHR_KANBAN_TYPE='5' or CHR_KANBAN_TYPE='6') ");
        if ($find_id->num_rows() > 0) {
            return $find_id->result();
        }
        return false;
    }
    function cekQty($id){
        $sap = $this->load->database('zsap',TRUE);
        $find_id = $sap->query("SELECT INT_QTY_PER_BOX FROM [dbo].[TM_KANBAN] WHERE CHR_PART_NO = '" . $id . "'");
        if ($find_id->num_rows() > 0) {
            return $find_id->result();
        }
        return false;
    }
    function cekPartsp($id){
        $sap = $this->load->database('zsap',TRUE);
        $find_id = $sap->query("SELECT CHR_PART_NO FROM [dbo].[TM_KANBAN] WHERE CHR_PART_NO = '" . $id . "' and CHR_KANBAN_TYPE='4' ");
        if ($find_id->num_rows() > 0) {
            return $find_id->result();
        }
        return false;
    }
    public function searchOld($delivery){
        $sap = $this->load->database('zsap',TRUE);
        $sap->like('CHR_PART_NO', $delivery, 'both');

        return $sap->get('TM_KANBAN')->result();
    }
    function ceknokanban($id,$id1) {
        $sap = $this->load->database('zsap',TRUE);
        $find_id = $sap->query("SELECT INT_KANBAN_NO FROM [dbo].[TM_KANBAN] WHERE CHR_PART_NO='" . $id . "' AND CHR_SLOC_FROM='" . $id1 . "' AND CHR_KANBAN_TYPE='6'");
      
        if ($find_id->num_rows() > 0) {
            return $find_id->result();
        }
        return false;
    }
    function cekSerialsp($id,$id1) {
        $sap = $this->load->database('zsap',TRUE);
        $find_id = $sap->query("SELECT INT_KANBAN_NO from [dbo].[TM_KANBAN] where CHR_PART_NO = '" . $id . "' and CHR_WC_VENDOR = '" . $id1 . "' and CHR_KANBAN_TYPE = '4'");
      
        if ($find_id->num_rows() > 0) {
            return $find_id->result();
        }
        return false;
    }
    function cekSerialCustomOr($id,$id1) {
        $sap = $this->load->database('zsap',TRUE);
        $find_id = $sap->query("SELECT INT_NUM_SERIAL from [dbo].[TM_KANBAN_SERIAL] where INT_NUM_SERIAL = '" . $id . "' and INT_KANBAN_NO = '" . $id1 . "'");
      
        if ($find_id->num_rows() > 0) {
            return $find_id->result();
        }
        return false;
    }
    function checkSuppname($id) {
        $sap = $this->load->database('zsap',TRUE);
        $find_id = $sap->query("SELECT CHR_SUPPLIER_NAME FROM [dbo].[TM_VENDOR] WHERE CHR_SUPPLIER_ID ='" . $id . "'");
        if ($find_id->num_rows() > 0) {
            return $find_id->result();
        }
        return false;
    }

    function checkPartDash($id) {
        $sap = $this->load->database('zsap',TRUE);
        $find_id = $sap->query("SELECT CHR_PART_NO_DASH FROM [dbo].[TM_PARTS] WHERE CHR_PART_NO ='" . $id . "'");
        if ($find_id->num_rows() > 0) {
            return $find_id->result();
        }
        return false;
    }

   

}
