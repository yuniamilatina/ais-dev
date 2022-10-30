<?php

class eform_m extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    function get_history_healthy_all($date_from, $date_to) {
        $db_covid = $this->load->database("db_android", TRUE);
        $query = $db_covid->query("SELECT a.npk,a.activity,a.flg_fit,a.flg_fever,a.flg_contact,a.flg_interaction,a.temp,a.flg_sa,a.self_condition,a.fams_condition,a.ill_condition,a.city,a.status,a.date,a.time,b.dept,b.username 
                                    FROM healthy_monitoring as a INNER join user as b 
                                    on a.npk=b.npk where a.date between '$date_from' and '$date_to' 
                                    UNION ALL
                                    SELECT a.npk,NULL AS activity,NULL AS flg_fit,NULL AS flg_fever,NULL AS flg_contact,NULL AS flg_interaction,NULL AS temp,NULL AS flg_sa,NULL AS self_condition,
                                    NULL AS fams_condition,NULL AS ill_condition,NULL AS city,NULL AS status,NULL AS date,NULL AS time,a.dept,a.username FROM user a WHERE NOT EXISTS 
                                    (SELECT * FROM healthy_monitoring b WHERE b.npk=a.npk AND b.date between '$date_from' and '$date_to') ORDER BY npk asc");                            
        return $query->result();
    }

    function get_history_healthy_all2($date_from, $date_to) {
        $db_covid = $this->load->database("db_covid", TRUE);
        $query = $db_covid->query("SELECT a.npk, CASE a.activity WHEN 1 THEN 'SHIFT1' WHEN 2 THEN 'SHIFT2' WHEN 3 THEN 'SHIFT3' WHEN 4 THEN 'NON SHIFT' WHEN 5 THEN 'Di rumah' WHEN 6 THEN 'Bepergian' ELSE '-' END AS activity,
        a.city,a.status,a.date,a.time,b.dept,b.username, 
        CASE a.flg_fit WHEN 0 THEN 'Sehat' WHEN 1 THEN 'Sakit' ELSE '-' END AS flg_fit,
        CASE a.flg_fever WHEN 1 THEN 'Ya' WHEN 0 THEN 'Tidak' ELSE '-' END AS flg_fever,
        CASE a.flg_contact WHEN 1 THEN 'Ya' WHEN 0 THEN 'Tidak' ELSE '-' END AS flg_contact,
        CASE a.flg_interaction WHEN 1 THEN 'Ya' WHEN 0 THEN 'Tidak' ELSE '-' END AS flg_interaction,
        round(a.temp,2) temp,
        a.flg_sa,
        CASE a.self_condition WHEN 0 THEN 'Tidak ada keluhan' WHEN 1 THEN 'Demam' WHEN 2 THEN 'Flu' WHEN 3 THEN 'Batuk' WHEN 4 THEN 'Sesak Nafas'
        WHEN 5 THEN 'Radang' WHEN 6 THEN 'Hilang Kemampuan mengecap rasa' WHEN 7 THEN 'Hilang Kemampuan Mencium bau' WHEN 9 THEN 'Diare' WHEN 10 THEN 'Nyeri Dada'
        ELSE '-' END AS self_condition,
        CASE a.fams_condition WHEN 0 THEN 'Tidak ada keluhan' WHEN 1 THEN 'Demam' WHEN 2 THEN 'Flu' WHEN 3 THEN 'Batuk' WHEN 4 THEN 'Sesak Nafas'
        WHEN 5 THEN 'Radang' WHEN 6 THEN 'Hilang Kemampuan mengecap rasa' WHEN 7 THEN 'Hilang Kemampuan Mencium bau' WHEN 9 THEN 'Diare' WHEN 10 THEN 'Nyeri Dada'
        ELSE '-' END AS fams_condition,
        CASE a.ill_condition WHEN 0 THEN 'Tidak ada keluhan' WHEN 1 THEN 'Auto imun' WHEN 2 THEN 'Supresi imun (HIV-AIDS)' WHEN 3 THEN 'Terapi Kanker' WHEN 4 THEN 'Jantung Kronik'
        WHEN 5 THEN 'Lever' WHEN 6 THEN 'Diabetes Melitus' WHEN 7 THEN 'Gagal Ginjal' WHEN 8 THEN 'Asma / Peradangan Paru' WHEN 9 THEN 'Hipertensi' 
        ELSE '-' END AS ill_condition
                                            FROM healthy_monitoring as a LEFT JOIN user as b 
                                            on a.npk=b.npk where a.date BETWEEN '$date_from' and '$date_to'
                                            UNION ALL
                                            SELECT a.npk,' ' AS  activity,' ' AS  city,' ' AS  status,' ' AS  date,' ' AS  time,a.dept,a.username, ' ' AS  flg_fit,' ' AS  flg_fever,' ' AS  flg_contact,' ' AS  flg_interaction,' ' AS  temp,' ' AS  flg_sa,' ' AS  self_condition,
                                            ' ' AS  fams_condition,' ' AS  ill_condition FROM user a WHERE NOT EXISTS 
                                            (SELECT * FROM healthy_monitoring b WHERE b.npk=a.npk AND b.date between '$date_from' and '$date_to') 
                                                        ORDER BY b.dept,b.npk ");                            
        return $query->result();
    }

    function get_history_healthy_dept($date_from, $date_to,$dept) {
        $db_covid = $this->load->database("db_android", TRUE);

        $query = $db_covid->query("SELECT a.npk,a.activity,a.flg_fit,a.flg_fever,a.flg_contact,a.flg_interaction,a.temp,a.flg_sa,a.self_condition,a.fams_condition,a.ill_condition,a.city,a.status,a.date,a.time,b.dept,b.username 
                                    FROM healthy_monitoring as a INNER join user as b 
                                    on a.npk=b.npk where a.date between '$date_from' and '$date_to' AND b.dept='$dept'
                                    UNION ALL
                                    SELECT a.npk,NULL AS activity,NULL AS flg_fit,NULL AS flg_fever,NULL AS flg_contact,NULL AS flg_interaction,NULL AS temp,NULL AS flg_sa,NULL AS self_condition,
                                    NULL AS fams_condition,NULL AS ill_condition,NULL AS city,NULL AS status,NULL AS date,NULL AS time,a.dept,a.username FROM user a WHERE NOT EXISTS 
                                    (SELECT * FROM healthy_monitoring b WHERE b.npk=a.npk AND b.date between '$date_from' and '$date_to') AND a.dept='$dept' ORDER BY npk asc");                            
        return $query->result();
    }

    function get_dept_gm($kd_dept) {
        $query = $this->db->query("select a.INT_ID_DEPT, a.CHR_DEPT, a.CHR_DEPT_DESC, b.CHR_GROUP_DEPT 
            from TM_DEPT a, TM_GROUP_DEPT b where a.INT_ID_GROUP_DEPT = b.INT_ID_GROUP_DEPT and a.BIT_FLG_DEL = 0 and a.INT_ID_GROUP_DEPT='$kd_dept' "); //and a.INT_ID_DEPT<>'26'
        return $query->result();
    }

    function get_dept_mgr($kd_dept,$id_dept) {
        $query = $this->db->query("select a.INT_ID_DEPT, a.CHR_DEPT, a.CHR_DEPT_DESC, b.CHR_GROUP_DEPT 
            from TM_DEPT a, TM_GROUP_DEPT b where a.INT_ID_GROUP_DEPT = b.INT_ID_GROUP_DEPT and a.BIT_FLG_DEL = 0 and a.INT_ID_GROUP_DEPT='$kd_dept' and a.INT_ID_DEPT='$id_dept' ");
        return $query->result();
    }

    function get_dept() {
        $query = $this->db->query("select a.INT_ID_DEPT, a.CHR_DEPT, a.CHR_DEPT_DESC, b.CHR_GROUP_DEPT 
            from TM_DEPT a, TM_GROUP_DEPT b where a.INT_ID_GROUP_DEPT = b.INT_ID_GROUP_DEPT and a.BIT_FLG_DEL = 0");
        return $query->result();
    }

    function nama_dept($id_dept) {
        $query = $this->db->query("select a.CHR_DEPT
            from TM_DEPT a, TM_GROUP_DEPT b where a.INT_ID_GROUP_DEPT = b.INT_ID_GROUP_DEPT and a.BIT_FLG_DEL = 0 and a.INT_ID_DEPT='$id_dept'");
            if ($query->num_rows() > 0) {
                $data = $query->row_array();
                $dept = $data['CHR_DEPT'];
                return $dept;
            } else {
                return 0;
            }
    }

    function get_tgl($date_now) {
        $db_covid = $this->load->database("db_android", TRUE);
        $query = $db_covid->query("SELECT distinct date_status FROM healthy_monitoring WHERE DATE='$date_now' AND date_status IS NOT null ORDER BY date_status DESC LIMIT 1");

        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return 0;
        }
    }

    function get_upd($date_now) {
        $db_covid = $this->load->database("db_android", TRUE);
        $query = $db_covid->query("SELECT distinct last_date_update FROM healthy_monitoring WHERE DATE='$date_now' AND last_date_update IS NOT null ORDER BY last_date_update DESC LIMIT 1");

        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return 0;
        }
    }

    function get_history_weekly_all($month,$year) {
        $db_covid = $this->load->database("db_android", TRUE);
        $query = $db_covid->query("SELECT a.npk,b.username,b.dept,sum(if(day(DATE)=01 && MONTH(DATE)=$month && YEAR(DATE)=$year,flg_sa + flg_contact + flg_interaction, NULL)) AS t_1,
                                    sum(if(day(DATE)=02 && MONTH(DATE)=$month && YEAR(DATE)=$year,flg_sa + flg_contact + flg_interaction, NULL)) AS t_2,
                                    sum(if(day(DATE)=03 && MONTH(DATE)=$month && YEAR(DATE)=$year,flg_sa + flg_contact + flg_interaction, NULL)) AS t_3,
                                    sum(if(day(DATE)=04 && MONTH(DATE)=$month && YEAR(DATE)=$year,flg_sa + flg_contact + flg_interaction, NULL)) AS t_4,
                                    sum(if(day(DATE)=05 && MONTH(DATE)=$month && YEAR(DATE)=$year,flg_sa + flg_contact + flg_interaction, NULL)) AS t_5,
                                    sum(if(day(DATE)=06 && MONTH(DATE)=$month && YEAR(DATE)=$year,flg_sa + flg_contact + flg_interaction, NULL)) AS t_6,
                                    sum(if(day(DATE)=07 && MONTH(DATE)=$month && YEAR(DATE)=$year,flg_sa + flg_contact + flg_interaction, NULL)) AS t_7,
                                    sum(if(day(DATE)=08 && MONTH(DATE)=$month && YEAR(DATE)=$year,flg_sa + flg_contact + flg_interaction, NULL)) AS t_8,
                                    sum(if(day(DATE)=09 && MONTH(DATE)=$month && YEAR(DATE)=$year,flg_sa + flg_contact + flg_interaction, NULL)) AS t_9,
                                    sum(if(day(DATE)=10 && MONTH(DATE)=$month && YEAR(DATE)=$year,flg_sa + flg_contact + flg_interaction, NULL)) AS t_10,
                                    sum(if(day(DATE)=11 && MONTH(DATE)=$month && YEAR(DATE)=$year,flg_sa + flg_contact + flg_interaction, NULL)) AS t_11,
                                    sum(if(day(DATE)=12 && MONTH(DATE)=$month && YEAR(DATE)=$year,flg_sa + flg_contact + flg_interaction, NULL)) AS t_12,
                                    sum(if(day(DATE)=13 && MONTH(DATE)=$month && YEAR(DATE)=$year,flg_sa + flg_contact + flg_interaction, NULL)) AS t_13,
                                    sum(if(day(DATE)=14 && MONTH(DATE)=$month && YEAR(DATE)=$year,flg_sa + flg_contact + flg_interaction, NULL)) AS t_14,
                                    sum(if(day(DATE)=15 && MONTH(DATE)=$month && YEAR(DATE)=$year,flg_sa + flg_contact + flg_interaction, NULL)) AS t_15,
                                    sum(if(day(DATE)=16 && MONTH(DATE)=$month && YEAR(DATE)=$year,flg_sa + flg_contact + flg_interaction, NULL)) AS t_16,
                                    sum(if(day(DATE)=17 && MONTH(DATE)=$month && YEAR(DATE)=$year,flg_sa + flg_contact + flg_interaction, NULL)) AS t_17,
                                    sum(if(day(DATE)=18 && MONTH(DATE)=$month && YEAR(DATE)=$year,flg_sa + flg_contact + flg_interaction, NULL)) AS t_18,
                                    sum(if(day(DATE)=19 && MONTH(DATE)=$month && YEAR(DATE)=$year,flg_sa + flg_contact + flg_interaction, NULL)) AS t_19,
                                    sum(if(day(DATE)=20 && MONTH(DATE)=$month && YEAR(DATE)=$year,flg_sa + flg_contact + flg_interaction, NULL)) AS t_20,
                                    sum(if(day(DATE)=21 && MONTH(DATE)=$month && YEAR(DATE)=$year,flg_sa + flg_contact + flg_interaction, NULL)) AS t_21,
                                    sum(if(day(DATE)=22 && MONTH(DATE)=$month && YEAR(DATE)=$year,flg_sa + flg_contact + flg_interaction, NULL)) AS t_22,
                                    sum(if(day(DATE)=23 && MONTH(DATE)=$month && YEAR(DATE)=$year,flg_sa + flg_contact + flg_interaction, NULL)) AS t_23,
                                    sum(if(day(DATE)=24 && MONTH(DATE)=$month && YEAR(DATE)=$year,flg_sa + flg_contact + flg_interaction, NULL)) AS t_24,
                                    sum(if(day(DATE)=25 && MONTH(DATE)=$month && YEAR(DATE)=$year,flg_sa + flg_contact + flg_interaction, NULL)) AS t_25,
                                    sum(if(day(DATE)=26 && MONTH(DATE)=$month && YEAR(DATE)=$year,flg_sa + flg_contact + flg_interaction, NULL)) AS t_26,
                                    sum(if(day(DATE)=27 && MONTH(DATE)=$month && YEAR(DATE)=$year,flg_sa + flg_contact + flg_interaction, NULL)) AS t_27,
                                    sum(if(day(DATE)=28 && MONTH(DATE)=$month && YEAR(DATE)=$year,flg_sa + flg_contact + flg_interaction, NULL)) AS t_28,
                                    sum(if(day(DATE)=29 && MONTH(DATE)=$month && YEAR(DATE)=$year,flg_sa + flg_contact + flg_interaction, NULL)) AS t_29,
                                    sum(if(day(DATE)=30 && MONTH(DATE)=$month && YEAR(DATE)=$year,flg_sa + flg_contact + flg_interaction, NULL)) AS t_30,
                                    sum(if(day(DATE)=31 && MONTH(DATE)=$month && YEAR(DATE)=$year,flg_sa + flg_contact + flg_interaction, NULL)) AS t_31 
                                    FROM healthy_monitoring a INNER JOIN user b ON a.npk=b.npk GROUP BY a.npk,b.username,b.dept");                            
        return $query->result();
    }

    function get_history_weekly_dept($month,$year,$dept) {
        $db_covid = $this->load->database("db_android", TRUE);
        $query = $db_covid->query("SELECT a.npk,b.username,b.dept,sum(if(day(DATE)=01 && MONTH(DATE)=$month && YEAR(DATE)=$year,flg_sa + flg_contact + flg_interaction, NULL)) AS t_1,
                                    sum(if(day(DATE)=02 && MONTH(DATE)=$month && YEAR(DATE)=$year,flg_sa + flg_contact + flg_interaction, NULL)) AS t_2,
                                    sum(if(day(DATE)=03 && MONTH(DATE)=$month && YEAR(DATE)=$year,flg_sa + flg_contact + flg_interaction, NULL)) AS t_3,
                                    sum(if(day(DATE)=04 && MONTH(DATE)=$month && YEAR(DATE)=$year,flg_sa + flg_contact + flg_interaction, NULL)) AS t_4,
                                    sum(if(day(DATE)=05 && MONTH(DATE)=$month && YEAR(DATE)=$year,flg_sa + flg_contact + flg_interaction, NULL)) AS t_5,
                                    sum(if(day(DATE)=06 && MONTH(DATE)=$month && YEAR(DATE)=$year,flg_sa + flg_contact + flg_interaction, NULL)) AS t_6,
                                    sum(if(day(DATE)=07 && MONTH(DATE)=$month && YEAR(DATE)=$year,flg_sa + flg_contact + flg_interaction, NULL)) AS t_7,
                                    sum(if(day(DATE)=08 && MONTH(DATE)=$month && YEAR(DATE)=$year,flg_sa + flg_contact + flg_interaction, NULL)) AS t_8,
                                    sum(if(day(DATE)=09 && MONTH(DATE)=$month && YEAR(DATE)=$year,flg_sa + flg_contact + flg_interaction, NULL)) AS t_9,
                                    sum(if(day(DATE)=10 && MONTH(DATE)=$month && YEAR(DATE)=$year,flg_sa + flg_contact + flg_interaction, NULL)) AS t_10,
                                    sum(if(day(DATE)=11 && MONTH(DATE)=$month && YEAR(DATE)=$year,flg_sa + flg_contact + flg_interaction, NULL)) AS t_11,
                                    sum(if(day(DATE)=12 && MONTH(DATE)=$month && YEAR(DATE)=$year,flg_sa + flg_contact + flg_interaction, NULL)) AS t_12,
                                    sum(if(day(DATE)=13 && MONTH(DATE)=$month && YEAR(DATE)=$year,flg_sa + flg_contact + flg_interaction, NULL)) AS t_13,
                                    sum(if(day(DATE)=14 && MONTH(DATE)=$month && YEAR(DATE)=$year,flg_sa + flg_contact + flg_interaction, NULL)) AS t_14,
                                    sum(if(day(DATE)=15 && MONTH(DATE)=$month && YEAR(DATE)=$year,flg_sa + flg_contact + flg_interaction, NULL)) AS t_15,
                                    sum(if(day(DATE)=16 && MONTH(DATE)=$month && YEAR(DATE)=$year,flg_sa + flg_contact + flg_interaction, NULL)) AS t_16,
                                    sum(if(day(DATE)=17 && MONTH(DATE)=$month && YEAR(DATE)=$year,flg_sa + flg_contact + flg_interaction, NULL)) AS t_17,
                                    sum(if(day(DATE)=18 && MONTH(DATE)=$month && YEAR(DATE)=$year,flg_sa + flg_contact + flg_interaction, NULL)) AS t_18,
                                    sum(if(day(DATE)=19 && MONTH(DATE)=$month && YEAR(DATE)=$year,flg_sa + flg_contact + flg_interaction, NULL)) AS t_19,
                                    sum(if(day(DATE)=20 && MONTH(DATE)=$month && YEAR(DATE)=$year,flg_sa + flg_contact + flg_interaction, NULL)) AS t_20,
                                    sum(if(day(DATE)=21 && MONTH(DATE)=$month && YEAR(DATE)=$year,flg_sa + flg_contact + flg_interaction, NULL)) AS t_21,
                                    sum(if(day(DATE)=22 && MONTH(DATE)=$month && YEAR(DATE)=$year,flg_sa + flg_contact + flg_interaction, NULL)) AS t_22,
                                    sum(if(day(DATE)=23 && MONTH(DATE)=$month && YEAR(DATE)=$year,flg_sa + flg_contact + flg_interaction, NULL)) AS t_23,
                                    sum(if(day(DATE)=24 && MONTH(DATE)=$month && YEAR(DATE)=$year,flg_sa + flg_contact + flg_interaction, NULL)) AS t_24,
                                    sum(if(day(DATE)=25 && MONTH(DATE)=$month && YEAR(DATE)=$year,flg_sa + flg_contact + flg_interaction, NULL)) AS t_25,
                                    sum(if(day(DATE)=26 && MONTH(DATE)=$month && YEAR(DATE)=$year,flg_sa + flg_contact + flg_interaction, NULL)) AS t_26,
                                    sum(if(day(DATE)=27 && MONTH(DATE)=$month && YEAR(DATE)=$year,flg_sa + flg_contact + flg_interaction, NULL)) AS t_27,
                                    sum(if(day(DATE)=28 && MONTH(DATE)=$month && YEAR(DATE)=$year,flg_sa + flg_contact + flg_interaction, NULL)) AS t_28,
                                    sum(if(day(DATE)=29 && MONTH(DATE)=$month && YEAR(DATE)=$year,flg_sa + flg_contact + flg_interaction, NULL)) AS t_29,
                                    sum(if(day(DATE)=30 && MONTH(DATE)=$month && YEAR(DATE)=$year,flg_sa + flg_contact + flg_interaction, NULL)) AS t_30,
                                    sum(if(day(DATE)=31 && MONTH(DATE)=$month && YEAR(DATE)=$year,flg_sa + flg_contact + flg_interaction, NULL)) AS t_31 
                                    FROM healthy_monitoring a INNER JOIN user b ON a.npk=b.npk WHERE b.dept='$dept' GROUP BY a.npk,b.username,b.dept");                            
        return $query->result();
    }

    
    public function get_all_user($group) {

        $date = date('d-m-Y');

        switch ($group) {
            case 1:
             $group = 'DIR';
              break;
            case 2:
                $group = 'ADV';
              break;
            case 3:
                $group = 'PRD';
              break;
            case 4:
                $group = 'ENG';
            break;
            case 5:
              $group = 'MKT,HR,IRL,GA';
            break;
            case 6:
              $group = 'FAC,PUR&IMPORT';
            break;
            default:
                $group = 'All';
          }

        $db_covid = $this->load->database("db_covid", TRUE);
        $query = $db_covid->query("SELECT `div`, `group`, npk, username, dept, section,  flg_pcr_positive, flg_quarantine, 
        IFNULL(vaccine1_date,'$date') vaccine1_date, IFNULL(vaccine2_date,'$date') vaccine2_date, IFNULL(pcr_date,'$date') pcr_date, 
        CASE 
        WHEN vaccine1_date = '' THEN ''
        WHEN vaccine1_date IS NULL THEN ''
        ELSE 
        CONCAT (RIGHT(vaccine1_date,2),'-',SUBSTRING(vaccine1_date,4,2),'-',LEFT(vaccine1_date,4) )
        END AS vaccine1_date_format,
        CASE 
        WHEN vaccine2_date = '' THEN ''
        WHEN vaccine2_date IS NULL THEN ''
        ELSE 
        CONCAT (RIGHT(vaccine2_date,2),'-',SUBSTRING(vaccine2_date,4,2),'-',LEFT(vaccine2_date,4) )
        END AS vaccine2_date_format,
        CASE 
        WHEN pcr_date = '' THEN ''
        WHEN pcr_date IS NULL THEN ''
        ELSE 
        CONCAT (RIGHT(pcr_date,2),'-',SUBSTRING(pcr_date,4,2),'-',LEFT(pcr_date,4) )
        END AS pcr_date_format,
        CASE flg_pcr_positive WHEN 0 THEN 'Negative' ELSE 'Positive' END AS status_covid, 
        IFNULL(vaccine1_date,'-') vaccine1, IFNULL(vaccine2_date,'-') vaccine2,
        CASE `group` WHEN 'DIR' THEN 1 WHEN 'ADV' THEN 2  WHEN 'PRD' THEN 3 WHEN 'ENG' THEN 4 WHEN 'MKT,HR,IRL,GA' THEN 5 WHEN 'FAC,PUR&IMPORT' THEN 6 ELSE 0 END AS group_id,
        CASE flg_quarantine WHEN 0 THEN '-' WHEN 1 THEN 'Isoman' ELSE 'Hospitalized' END AS status_quarantine FROM user WHERE flg_delete = 0 AND `group` = '$group' 
        ORDER BY npk asc");   

        return $query->result();
    }

    public function get_data_user($npk){
        $db_covid = $this->load->database("db_covid", TRUE);
        $query = $db_covid->query("SELECT npk, username, 
         CASE `group` WHEN 'DIR' THEN 1 WHEN 'ADV' THEN 2  WHEN 'PRD' THEN 3 WHEN 'ENG' THEN 4 WHEN 'MKT,HR,IRL,GA' THEN 5 WHEN 'FAC,PUR&IMPORT' THEN 6 ELSE 0 END AS group_id,
        IFNULL(vaccine1_date,'') vaccine1, IFNULL(vaccine2_date,'') vaccine2, pcr_date, 
        CASE 
        WHEN vaccine1_date = '' THEN ''
        WHEN vaccine1_date IS NULL THEN ''
        ELSE 
        CONCAT (RIGHT(vaccine1_date,2),'-',SUBSTRING(vaccine1_date,4,2),'-',LEFT(vaccine1_date,4) )
        END AS vaccine1_date_format,
        CASE 
        WHEN vaccine2_date = '' THEN ''
        WHEN vaccine2_date IS NULL THEN ''
        ELSE 
        CONCAT (RIGHT(vaccine2_date,2),'-',SUBSTRING(vaccine2_date,4,2),'-',LEFT(vaccine2_date,4) )
        END AS vaccine2_date_format,
        CASE 
        WHEN pcr_date = '' THEN ''
        WHEN pcr_date IS NULL THEN ''
        ELSE 
        CONCAT (RIGHT(pcr_date,2),'-',SUBSTRING(pcr_date,4,2),'-',LEFT(pcr_date,4) )
        END AS pcr_date_format,
        flg_pcr_positive, flg_quarantine FROM user WHERE npk = '$npk'  LIMIT 1");   

        return $query->row();
    }

    public function get_id_new_case(){
        $db_covid = $this->load->database("db_covid", TRUE);
        $query = $db_covid->query("SELECT max(case_no) + 1 id FROM covid_monitoring GROUP BY case_no ORDER BY case_no DESC LIMIT 1");   

        return $query->row()->id;
    }

    public function get_last_case_no_by_npk($npk){
        $db_covid = $this->load->database("db_covid", TRUE);
        $query = $db_covid->query("SELECT max(case_no) case_no FROM covid_monitoring WHERE npk = '$npk' GROUP BY case_no ORDER BY case_no DESC LIMIT 1");   

        return $query->row()->case_no;
    }

    function get_last_pcr_by_case_npk($case_no, $npk){
        $db_covid = $this->load->database("db_covid", TRUE);
        $query = $db_covid->query("SELECT max(pcr_count) pcr_count FROM covid_monitoring WHERE case_no = $case_no AND npk = '$npk' GROUP BY pcr_count ORDER BY pcr_count DESC LIMIT 1");   

        return $query->row()->pcr_count;
    }

    public function save_case($data){
        $db_covid = $this->load->database("db_covid", TRUE);
        $db_covid->insert('covid_monitoring', $data);
    }

    public function update_case($data, $id, $data_user, $id_user){
        $db_covid = $this->load->database("db_covid", TRUE);
        $db_covid->update('covid_monitoring', $data, $id);
    }

    public function update_user($data, $id){
        $db_covid = $this->load->database("db_covid", TRUE);
        $db_covid->update('user', $data, $id);
    }


    public function get_data_daily_status_case($period){

        $db_covid = $this->load->database("db_covid", TRUE);

        $stored_procedure = "CALL getDataStatusCovid(?)";
        $param = array( 'period' => $period);

        $query = $db_covid->query($stored_procedure, $param);

        if($query->num_rows() > 0){
            return $query->result();
        }else{
            return false;
        }
    }

    public function get_case_per_dept() {

        $db_covid = $this->load->database("db_covid", TRUE);
        $query = $db_covid->query("SELECT `group` AS dept, count(flg_pcr_positive) total FROM user WHERE flg_pcr_positive = 1 GROUP BY `group`
        UNION ALL
        SELECT `group` AS dept, 0 total FROM user WHERE flg_pcr_positive = 0 AND 
        `group` NOT IN (SELECT `group` FROM user WHERE flg_pcr_positive = 1 GROUP BY `group`) GROUP BY `group`");   

        return $query->result();
    }

    public function get_summary(){
        $db_covid = $this->load->database("db_covid", TRUE);
        $query = $db_covid->query("SELECT 'vaksin1' as variabel, COUNT(vaccine1_date) AS total FROM user WHERE vaccine1_date IS NOT NULL
        UNION ALL
        SELECT 'vaksin1_today' as variabel, COUNT(vaccine1_date) AS total FROM user WHERE vaccine1_date IS NOT NULL AND vaccine1_date = date_format(curdate(), '%Y%m%d')
        UNION ALL
        SELECT 'vaksin2',COUNT(vaccine2_date)  FROM user WHERE vaccine2_date IS NOT NULL
        UNION ALL
        SELECT 'vaksin2_today',COUNT(vaccine2_date)  FROM user WHERE vaccine2_date IS NOT NULL AND vaccine2_date = date_format(curdate(), '%Y%m%d')
        UNION ALL
        SELECT 'isoman',COUNT(flg_quarantine) FROM user WHERE flg_quarantine = 1
        UNION ALL
        SELECT 'isoman_today',COUNT(flg_quarantine) FROM user WHERE flg_quarantine = 1 AND created_date = date_format(curdate(), '%Y%m%d')
        UNION ALL
        SELECT 'hospitalized',COUNT(flg_quarantine) FROM user WHERE flg_quarantine = 2
        UNION ALL
        SELECT 'hospitalized_today',COUNT(flg_quarantine) FROM user WHERE flg_quarantine = 2 AND created_date = date_format(curdate(), '%Y%m%d')
        UNION ALL
        SELECT 'active_case',COUNT(flg_pcr_positive) FROM user WHERE flg_pcr_positive = 1
        UNION ALL
        SELECT 'active_case_today',COUNT(flg_pcr_positive) FROM user WHERE flg_pcr_positive = 1 AND created_date = date_format(curdate(), '%Y%m%d')
        UNION ALL
        SELECT 'recovery',COUNT(case_no)  FROM  covid_monitoring WHERE flg_pcr_positive = 0
        UNION ALL
        SELECT 'recovery_today',COUNT(flg_pcr_positive) FROM user WHERE flg_pcr_positive = 0 AND created_date IS NOT NULL AND created_date = date_format(curdate(), '%Y%m%d')
        UNION ALL
        SELECT 'total_user',COUNT(npk) FROM user WHERE flg_delete = 0
        UNION ALL
        SELECT 'total_case', COUNT(case_no)  FROM  covid_monitoring 
        UNION ALL
        SELECT 'total_case_today',COUNT(case_no)  FROM  covid_monitoring  WHERE created_date = date_format(curdate(), '%Y%m%d')
        UNION ALL
        SELECT 'last_case', COUNT(case_no)  FROM  covid_monitoring  WHERE created_date >= '20210601'");   

        return $query->result();
    }

    function get_all_case_by_user($npk){
        $db_covid = $this->load->database("db_covid", TRUE);
        $query = $db_covid->query("SELECT npk, case_no,  
        CASE flg_pcr_positive WHEN 0 THEN 'Negative' ELSE 'Positive' END AS flg_pcr_positive, 
        pcr_date, CONCAT (RIGHT(pcr_date,2),'-',SUBSTRING(pcr_date,4,2),'-',LEFT(pcr_date,4) ) pcr_date_format,
        CASE flg_quarantine WHEN 0 THEN '-' WHEN 1 THEN 'Isoman' ELSE 'Hospitalized' END AS flg_quarantine
        FROM covid_monitoring WHERE npk = '$npk'");   

        return $query->result();
    }

    public function get_all_data_mp($group) {

        $db_covid = $this->load->database("db_covid", TRUE);
        $query = $db_covid->query("SELECT `div`, npk, username, `group`, dept, section,  flg_direct_labour FROM user WHERE flg_delete = 0 AND user.group = '$group' ORDER BY npk asc");   

        return $query->result();
    }
    
    function get_all_group(){
        $db_covid = $this->load->database("db_covid", TRUE);
        $query = $db_covid->query("SELECT DISTINCT user.group
        FROM user");   

        return $query->result();
    }
}