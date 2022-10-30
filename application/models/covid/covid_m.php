<?php

class covid_m extends CI_Model {

    public function __construct() {
        parent::__construct();
    }
    
    public function get_all_user($div_id, $status) {

        $date = date('d-m-Y');

        switch ($status) {
            case 0:
             $status = 'AND P.INT_FLG_PCR_POSITIVE = 0';
              break;
            case 1:
                $status = 'AND P.INT_FLG_PCR_POSITIVE = 1';
              break;
            default:
                $status = '';
          }

        switch ($div_id) {
            case 1:
             $div_id = "AND CHR_DIV = 'PLANT'";
              break;
            case 2:
                $div_id = "AND CHR_DIV = 'HR, IR, GAF, MKT'";
              break;
            case 3:
                $div_id = "AND CHR_DIV='FACC, PURCHASING'";
              break;
            default:
                $div_id = '';
          }

        $db_covid = $this->load->database("db_covid", TRUE);
        $query = $db_covid->query("SELECT CHR_DIV, CHR_GROUP, P.CHR_NPK, CHR_USERNAME, CHR_DEPT, P.INT_FLG_PCR_POSITIVE, P.INT_FLG_QUARANTINE, 
        CASE 
        WHEN CHR_VACCINE1_DATE = '' THEN ''
        WHEN CHR_VACCINE1_DATE IS NULL THEN ''
        ELSE 
        RIGHT(CHR_VACCINE1_DATE,2)+ '-' +SUBSTRING(CHR_VACCINE1_DATE,5,2)+ '-' +LEFT(CHR_VACCINE1_DATE,4)
        END AS vaccine1_date_format,
        CASE 
        WHEN CHR_VACCINE2_DATE = '' THEN ''
        WHEN CHR_VACCINE2_DATE IS NULL THEN ''
        ELSE 
        RIGHT(CHR_VACCINE2_DATE,2)+ '-' +SUBSTRING(CHR_VACCINE2_DATE,5,2)+ '-' +LEFT(CHR_VACCINE2_DATE,4)
        END AS vaccine2_date_format,
        CASE 
        WHEN CHR_VACCINE3_DATE = '' THEN ''
        WHEN CHR_VACCINE3_DATE IS NULL THEN ''
        ELSE 
        RIGHT(CHR_VACCINE3_DATE,2)+ '-' +SUBSTRING(CHR_VACCINE3_DATE,5,2)+ '-' +LEFT(CHR_VACCINE3_DATE,4)
        END AS vaccine3_date_format,
        CASE 
        WHEN P.CHR_PCR_DATE = '' THEN ''
        WHEN P.CHR_PCR_DATE IS NULL THEN ''
        ELSE 
        LEFT(P.CHR_PCR_DATE,4)+ '-' +SUBSTRING(P.CHR_PCR_DATE,5,2)+ '-' +RIGHT(P.CHR_PCR_DATE,2)
        END AS pcr_date_format,
        P.CHR_VACCINE_STATUS,
        CASE P.INT_FLG_PCR_POSITIVE WHEN 0 THEN 'Negative' ELSE 'Positive' END AS status_covid, 
		PCR.INT_CASE_NO,
        CASE CHR_DIV WHEN 'PLANT' THEN 1 WHEN 'HR, IR, GAF, MKT' THEN 2 WHEN 'FACC, PURCHASING'  THEN 3 ELSE 0 END AS div_id,
        CASE P.INT_FLG_QUARANTINE WHEN 0 THEN '' WHEN 1 THEN 'Isoman' ELSE 'Hospitalized' END AS status_quarantine 
        FROM TT_PENYINTAS P LEFT JOIN TT_PCR PCR ON P.CHR_NPK = PCR.CHR_NPK AND P.CHR_PCR_DATE = PCR.CHR_PCR_DATE 
        WHERE P.INT_FLG_DEL = 0  $div_id $status
        ORDER BY P.CHR_PCR_DATE DESC");   

        return $query->result();
    }

    public function get_data_user($npk){
        $db_covid = $this->load->database("db_covid", TRUE);
        $query = $db_covid->query("SELECT TOP 1 CHR_NPK, CHR_USERNAME, 
        CASE CHR_DIV WHEN 'PLANT' THEN 1 WHEN 'HR, IR, GAF, MKT' THEN 2 WHEN 'FACC, PURCHASING'  THEN 3 ELSE 0 END AS div_id,
        CASE 
        WHEN CHR_VACCINE1_DATE = '' THEN NULL
        WHEN CHR_VACCINE1_DATE IS NULL THEN NULL
        ELSE 
        RIGHT(CHR_VACCINE1_DATE,2)+ '-' +SUBSTRING(CHR_VACCINE1_DATE,5,2)+ '-' +LEFT(CHR_VACCINE1_DATE,4)
        END AS vaccine1_date_format,
        CASE 
        WHEN CHR_VACCINE2_DATE = '' THEN NULL
        WHEN CHR_VACCINE2_DATE IS NULL THEN NULL
        ELSE 
        RIGHT(CHR_VACCINE2_DATE,2)+ '-' +SUBSTRING(CHR_VACCINE2_DATE,5,2)+ '-' +LEFT(CHR_VACCINE2_DATE,4)
        END AS vaccine2_date_format,
        CASE 
        WHEN CHR_VACCINE3_DATE = '' THEN NULL
        WHEN CHR_VACCINE3_DATE IS NULL THEN NULL
        ELSE 
        RIGHT(CHR_VACCINE3_DATE,2)+ '-' +SUBSTRING(CHR_VACCINE3_DATE,5,2)+ '-' +LEFT(CHR_VACCINE3_DATE,4)
        END AS vaccine3_date_format,
        CASE 
        WHEN CHR_PCR_DATE = '' THEN ''
        WHEN CHR_PCR_DATE IS NULL THEN ''
        ELSE 
        RIGHT(CHR_PCR_DATE,2)+ '-' +SUBSTRING(CHR_PCR_DATE,5,2)+ '-' +LEFT(CHR_PCR_DATE,4)
        END AS pcr_date_format,
        INT_FLG_PCR_POSITIVE, INT_FLG_QUARANTINE FROM TT_PENYINTAS WHERE CHR_NPK = '$npk'  ");   

        return $query->row();
    }

    public function get_id_new_case(){
        $db_covid = $this->load->database("db_covid", TRUE);
        $query = $db_covid->query("SELECT max(ISNULL(INT_CASE_NO,0)) + 1 id FROM TT_PCR GROUP BY INT_CASE_NO ORDER BY INT_CASE_NO DESC ");   

        return $query->row()->id;
    }

    public function get_last_case_no_by_npk($CHR_NPK){
        $db_covid = $this->load->database("db_covid", TRUE);
        $query = $db_covid->query("SELECT max(INT_CASE_NO) INT_CASE_NO FROM TT_PCR WHERE CHR_NPK = '$CHR_NPK' GROUP BY INT_CASE_NO ORDER BY INT_CASE_NO DESC ");   

        return $query->row()->INT_CASE_NO;
    }

    function get_last_pcr_by_case_npk($INT_CASE_NO, $CHR_NPK){
        $db_covid = $this->load->database("db_covid", TRUE);
        $query = $db_covid->query("SELECT max(INT_PCR_COUNT) INT_PCR_COUNT FROM TT_PCR WHERE INT_CASE_NO = $INT_CASE_NO AND CHR_NPK = '$CHR_NPK' GROUP BY INT_PCR_COUNT ORDER BY INT_PCR_COUNT DESC ");   

        return $query->row()->INT_PCR_COUNT;
    }

    public function save_case($data){
        $db_covid = $this->load->database("db_covid", TRUE);
        $db_covid->insert('TT_PCR', $data);
    }

    public function update_case($data, $id, $data_user, $id_user){
        $db_covid = $this->load->database("db_covid", TRUE);
        $db_covid->update('TT_PCR', $data, $id);
    }

    public function update_user($data, $id){
        $db_covid = $this->load->database("db_covid", TRUE);
        $db_covid->update('TT_PENYINTAS', $data, $id);
    }

    public function get_data_daily_status_case($period){

        $db_covid = $this->load->database("db_covid", TRUE);

        $stored_procedure = "EXEC getSummaryCovidDaily ?";
        $param = array( 'period' => $period);

        $query = $db_covid->query($stored_procedure, $param);

        if($query->num_rows() > 0){
            return $query->result();
        }else{
            return false;
        }
    }

    public function get_data_monthly_status_case($year){

        $db_covid = $this->load->database("db_covid", TRUE);

        $stored_procedure = "EXEC getSummaryCovidMonthly ?";
        $param = array( 'year' => $year);

        $query = $db_covid->query($stored_procedure, $param);

        if($query->num_rows() > 0){
            return $query->result();
        }else{
            return false;
        }
    }
    

    public function get_case_per_div() {

        $db_covid = $this->load->database("db_covid", TRUE);
        $query = $db_covid->query("EXEC getSummarybyGroup");

        if($query->num_rows() > 0){
            return $query->row();
        }else{
            return false;
        }
    }
    
    public function get_summary(){
        $db_covid = $this->load->database("db_covid", TRUE);
        $query = $db_covid->query("EXEC getSummaryCovid");
        if($query->num_rows() > 0){
            return $query->result();
        }else{
            return false;
        }
    }

    function get_all_case_by_user($npk){
        $db_covid = $this->load->database("db_covid", TRUE);
        $query = $db_covid->query("SELECT CHR_NPK, INT_CASE_NO,  INT_FLG_PCR_POSITIVE AS FLG_STATUS,
        CASE INT_FLG_PCR_POSITIVE WHEN 0 THEN 'Negative' ELSE 'Positive' END AS INT_FLG_PCR_POSITIVE, 
        CHR_PCR_DATE,
        LEFT(CHR_PCR_DATE,4)+ '-' +SUBSTRING(CHR_PCR_DATE,5,2)+ '-' +RIGHT(CHR_PCR_DATE,2) AS pcr_date_format,
        CASE INT_FLG_QUARANTINE WHEN 0 THEN '-' WHEN 1 THEN 'Isoman' ELSE 'Hospitalized' END AS INT_FLG_QUARANTINE
        FROM TT_PCR WHERE CHR_NPK = '$npk'");   

        return $query->result();
    }

    public function get_all_data_mp($div_id) {

        switch ($div_id) {
            case 1:
             $div_id = 'PLANT';
              break;
            case 2:
                $div_id = 'HR, IR, GAF, MKT';
              break;
            case 3:
                $div_id = 'FACC, PURCHASING';
              break;
            default:
                $div_id = 'All';
          }
          
        $db_covid = $this->load->database("db_covid", TRUE);
        $query = $db_covid->query("SELECT CHR_DIV, CHR_NPK, CHR_USERNAME, CHR_GROUP, CHR_DEPT, INT_FLG_DIRECT_LABOUR FROM TT_PENYINTAS WHERE INT_FLG_DEL = 0 AND CHR_DIV =  '$div_id' ORDER BY CHR_NPK asc");   

        return $query->result();
    }

    function get_all_group(){
        $db_covid = $this->load->database("db_covid", TRUE);
        $query = $db_covid->query("SELECT CHR_GROUP
        FROM TT_PENYINTAS GROUP BY CHR_GROUP");   

        return $query->result();
    }
}