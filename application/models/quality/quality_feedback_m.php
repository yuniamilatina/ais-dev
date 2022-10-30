<?php

class quality_feedback_m extends CI_Model {

    private $tabel = 'QUA.[TT_FEEDBACK_PROB_QUALITY]';

    function save($data) {
        $this->db->insert($this->tabel, $data);
    }

    function get_data_by_id($id) {
        $query = $this->db->query("SELECT INT_ID, 
                                        INT_ID_QPROBLEM, 
                                        CHR_FEEDBACK_DESC,
                                        CASE WHEN INT_ACTION_TYPE = 1 THEN 'TEMP' ELSE 'FIX' END AS INT_ACTION_TYPE, 
                                        CHR_CREATED_BY,
                                        US.CHR_USERNAME,
                                        INT_STATUS,
                                        CHR_FILEUPLOAD,
                                        CONVERT(VARCHAR(10),CONVERT(DATE,CHR_CREATED_DATE,106),110) AS CHR_CREATED_DATE, 
                                        LEFT(CHR_CREATED_TIME,5) CHR_CREATED_TIME,                                        
                                        CASE WHEN INT_CAUSE_PROBLEM = 1 THEN 'Occurence' ELSE 'Flow Out' END AS INT_CAUSE_PROBLEM,
                                        CASE WHEN INT_CAUSE_PROBLEM = 1 THEN 'Occurence' ELSE 'Flow Out' END AS INT_CAUSE_PROBLEM,
                                        CASE WHEN CHR_MAN_ANALYSIS = '' THEN '-' ELSE CHR_MAN_ANALYSIS END AS CHR_MAN_ANALYSIS,
                                        CASE WHEN CHR_MACHINE_ANALYSIS = '' THEN '-' ELSE CHR_MACHINE_ANALYSIS END AS CHR_MACHINE_ANALYSIS,
                                        CASE WHEN CHR_MATERIAL_ANALYSIS = '' THEN '-' ELSE CHR_MATERIAL_ANALYSIS END AS CHR_MATERIAL_ANALYSIS,
                                        CASE WHEN CHR_METHODE_ANALYSIS = '' THEN '-' ELSE CHR_METHODE_ANALYSIS END AS CHR_METHODE_ANALYSIS
                                    FROM QUA.TT_FEEDBACK_PROB_QUALITY FB
                                    LEFT JOIN TM_USER US ON US.CHR_NPK = FB.CHR_CREATED_BY
                                    WHERE INT_ID_QPROBLEM = $id AND INT_FLG_DEL = 0");
        return $query;
    }
    
    function get_detail_feedback_by_id($id) {
        $query = $this->db->query("SELECT INT_ID, 
                                        INT_ID_QPROBLEM, 
                                        CHR_FEEDBACK_DESC,
                                        CASE WHEN INT_ACTION_TYPE = 1 THEN 'TEMPORARY ACTION' ELSE 'FIX ACTION' END AS INT_ACTION_TYPE, 
                                        CHR_CREATED_BY,
                                        US.CHR_USERNAME,
                                        CHR_FILEUPLOAD,
                                        INT_STATUS,
                                        CONVERT(VARCHAR(10),CONVERT(DATE,CHR_CREATED_DATE,106),110) AS CHR_CREATED_DATE, 
                                        LEFT(CHR_CREATED_TIME,5) CHR_CREATED_TIME,                                        
                                        CASE WHEN INT_CAUSE_PROBLEM = 1 THEN 'Occurence' ELSE 'Flow Out' END AS INT_CAUSE_PROBLEM,
                                        CASE WHEN INT_CAUSE_PROBLEM = 1 THEN 'Occurence' ELSE 'Flow Out' END AS INT_CAUSE_PROBLEM,
                                        CASE WHEN CHR_MAN_ANALYSIS = '' THEN '-' ELSE CHR_MAN_ANALYSIS END AS CHR_MAN_ANALYSIS,
                                        CASE WHEN CHR_MACHINE_ANALYSIS = '' THEN '-' ELSE CHR_MACHINE_ANALYSIS END AS CHR_MACHINE_ANALYSIS,
                                        CASE WHEN CHR_MATERIAL_ANALYSIS = '' THEN '-' ELSE CHR_MATERIAL_ANALYSIS END AS CHR_MATERIAL_ANALYSIS,
                                        CASE WHEN CHR_METHODE_ANALYSIS = '' THEN '-' ELSE CHR_METHODE_ANALYSIS END AS CHR_METHODE_ANALYSIS
                                    FROM QUA.TT_FEEDBACK_PROB_QUALITY FB
                                    LEFT JOIN TM_USER US ON US.CHR_NPK = FB.CHR_CREATED_BY
                                    WHERE INT_ID = $id AND INT_FLG_DEL = 0");
        return $query;
    }

    function delete($id) {
        $data = array('INT_FLG_DEL' => 1);
        $this->db->where('INT_ID', $id);
        $this->db->update($this->tabel, $data);
    }
    
    function solved($id) {
        $data = array('INT_STATUS' => 2);

        $this->db->where('INT_ID', $id);
        $this->db->update($this->tabel, $data);
    }
    
    function not_solved($id) {
        $data = array('INT_STATUS' => 1);

        $this->db->where('INT_ID', $id);
        $this->db->update($this->tabel, $data);
    }

    function update($data, $id) {
        $this->db->where('INT_ID', $id);
        $this->db->update($this->tabel, $data);
    }
    
    function close_problem($id) {
            $this->db->query("UPDATE QUA.TT_QUALITY_PROBLEM
                               SET INT_STATUS = '3'
                             WHERE INT_ID = '$id'");
    }

}
