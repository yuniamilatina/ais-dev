<?php

class quality_problem_m extends CI_Model {

    private $tabel = 'QUA.[TT_QUALITY_PROBLEM]';

    function get_quality_problem($periode) {
        $stored_procedure = "EXEC QUA.zsp_get_all_quality_problem '$periode'";

        $query = $this->db->query($stored_procedure);
        return $query->result();
    }
    
    function get_all_quality_problem() {
        $stored_procedure = "SELECT [INT_ID]
                                    ,[CHR_QPROBLEM_TITLE]
                                    ,[CHR_PART_NAME]
                                    ,[CHR_BACK_NO]
                                    ,[CHR_PIC]
                                    ,[INT_ID_SECTION_PIC]
                                    ,[CHR_REQUESTOR]
                                    ,[INT_ID_SECTION_REQUESTOR]
                                    ,[CHR_START_DATE]
                                    ,[CHR_START_TIME]
                                    ,[CHR_FINISH_DATE]
                                    ,[CHR_FINISH_TIME]
                                    ,[CHR_DUE_DATE]
                                    ,[CHR_DUE_TIME]
                                    ,[CHR_QPROBLEM_DESC]
                                    ,[INT_STATUS]
                                    ,[INT_ACT_FLG]
                                    ,[INT_QTY]
                                    ,[CHR_TR_NO]
                                    ,[CHR_CLASS_PROBLEM]
                            FROM [QUA].[TT_QUALITY_PROBLEM]";

        $query = $this->db->query($stored_procedure);
        return $query->result();
    }
    
    function get_id_latest_problem() {
        $id_problem = "SELECT TOP 1 [INT_ID]
                       FROM [QUA].[TT_QUALITY_PROBLEM]
                       ORDER BY [INT_ID] DESC";

        $query = $this->db->query($id_problem);
        return $query->row();
    }
    
    function get_id_problem() {
        $id_problem = "SELECT TOP 1 [INT_ID],[CHR_TR_NO]
                       FROM [QUA].[TT_QUALITY_PROBLEM]
                       WHERE INT_ID_CHILD = '0'
                       ORDER BY [INT_ID] DESC";

        $query = $this->db->query($id_problem);
        return $query->row();
    }
    
    function get_id_inherit_tr($section) {
        $id_inherit = "SELECT TOP 1 [INT_ID]
                       ,SUBSTRING([CHR_TR_NO],1,3) AS LATEST_ID
                       ,[CHR_TR_NO]
                       FROM [QUA].[TT_QUALITY_PROBLEM]
                       WHERE SUBSTRING([CHR_TR_NO],5,7) = '$section' 
                       ORDER BY [INT_ID] DESC";

        $query = $this->db->query($id_inherit);
        return $query->row();
    }
    
    function get_data_parent($id_parent, $id_child) {
        $id_child_tr = $id_child - 1;
        
        if ($id_child_tr < 0) {
            $id_child_tr = 0;
        }
        
        $id_parent = "SELECT TOP 1 *
                       FROM [QUA].[TT_QUALITY_PROBLEM]
                       WHERE INT_ID_PARENT = '$id_parent' AND INT_ID_CHILD = '$id_child_tr'
                       ORDER BY [INT_ID] DESC";

        $query = $this->db->query($id_parent);
        return $query->row();
    }
    
     function get_related_tr($id, $id_parent) {
        $related_tr = "SELECT *, B.CHR_SECTION AS CHR_SECTION_PIC
                       FROM [QUA].[TT_QUALITY_PROBLEM] A
                       LEFT JOIN TM_SECTION B ON B.INT_ID_SECTION = A.INT_ID_SECTION_PIC
                       WHERE INT_ID_PARENT = '$id_parent' AND INT_ID <> '$id'
                       ORDER BY [INT_ID_CHILD] ASC";

        $query = $this->db->query($related_tr);
        return $query->result();
    }
    
    function get_quality_problem_perday() {
        $stored_procedure = "EXEC QUA.zsp_get_all_quality_problem_perday";

        $query = $this->db->query($stored_procedure);
        return $query->result();
    }
    
    function get_problem_count($periode){
        $stored_procedure = "EXEC QUA.zsp_get_all_quality_problem '$periode'";

        $query = $this->db->query($stored_procedure);
        return $query->num_rows();
    }

    function save($data) {
        $this->db->insert($this->tabel, $data);
    }

    function get_quality_problem_by_id($id) {
        $stored_procedure = "EXEC QUA.zsp_get_quality_problem_by_id ?";
        $param = array(
            'id' => $id);

        $query = $this->db->query($stored_procedure, $param);
        return $query->row();
    }
    
    function get_user_responsibility($section_pic){
        $pic = $this->db->query("SELECT CHR_NPK FROM QUA.TM_MAPPING_PIC WHERE INT_ID_SECT_RESPONSE = '$section_pic' AND INT_FLG_DELETE <> '1'")->result();
        return $pic;
    }
    
    function get_user_responsibility_by_npk($section_pic, $npk){
        $pic = $this->db->query("SELECT CHR_NPK FROM QUA.TM_MAPPING_PIC WHERE INT_ID_SECT_RESPONSE = '$section_pic' AND CHR_NPK = '$npk' AND INT_FLG_DELETE <> '1'")->num_rows();
        return $pic;
    }

    function delete($id) {
        $data = array('INT_FLG_DEL' => 1);
        $this->db->where('INT_ID', $id);
        $this->db->update($this->tabel, $data);
    }

    function is_complete($id){
        $data = array('INT_STATUS' => 2);

        $this->db->where('INT_ID', $id);
        $this->db->update($this->tabel, $data);
    }
    
    function update($data, $id, $cause) {
        $get_id_parent = $this->db->query("SELECT INT_ID_PARENT FROM [QUA].[TT_QUALITY_PROBLEM] WHERE INT_ID = '$id'")->row();
        $id_parent = $get_id_parent->INT_ID_PARENT;
        if($cause == '1'){
            $this->db->where('INT_ID', $id);
            $this->db->update($this->tabel, $data);
        } else {
            if($data->INT_STATUS == '1'){
                $this->db->where('INT_ID', $id_parent);
                $this->db->update($this->tabel, $data);
            } else {
                $this->db->where('INT_ID_PARENT', $id_parent);
                $this->db->update($this->tabel, $data);
            }
        }        
    }
    
    function get_all_back_no() {
        $all_back_no = $this->db->query("SELECT A.[CHR_PART_NO]
                                               ,A.[CHR_PART_NAME]
                                               ,B.[CHR_BACK_NO]
                                         FROM [TM_PARTS] A
                                         LEFT JOIN TM_KANBAN B ON A.CHR_PART_NO = B.CHR_PART_NO
                                         WHERE A.CHR_BACK_NO IS NOT NULL 
                                            AND A.CHR_BACK_NO <> '' 
                                            AND B.CHR_BACK_NO <> ''
                                            --AND A.CHR_FLAG_DELETE <> '1'
                                            AND B.CHR_KANBAN_TYPE IN ('5','6','0','1')
                                         GROUP BY A.CHR_PART_NO, A.[CHR_PART_NAME], A.[CHR_BACK_NO], B.[CHR_BACK_NO]
                                         ORDER BY A.CHR_BACK_NO")->result();
        return $all_back_no;
    }
    
    function get_all_section() {
        $all_section = $this->db->query("SELECT A.[INT_ID_SECTION]
                                        ,A.[CHR_SECTION] AS CHR_SECTION
                                        ,A.[CHR_SECTION_DESC] AS CHR_SECTION_DESC
                                        ,A.[INT_ID_DEPT]
                                        ,B.[CHR_DEPT]
                                    FROM [TM_SECTION] A
                                    INNER JOIN [TM_DEPT] B ON A.[INT_ID_DEPT] = B.[INT_ID_DEPT]
                                    WHERE A.[CHR_SECTION] IS NOT NULL 
                                    AND A.[BIT_FLG_DEL] <> 1
                                    AND B.[INT_ID_DEPT] IN ('14','20','21','22','23','24','26','27','28')
                                    ORDER BY A.[CHR_SECTION] ASC")->result();
        return $all_section;
    }
    
    function get_problem_section($periode) {
        $problem_section = $this->db->query("SELECT DISTINCT A.[INT_ID_SECTION_PIC],
                                                    B.CHR_SECTION,
                                                    B.CHR_SECTION_DESC
                                            FROM [QUA].[TT_QUALITY_PROBLEM] A
                                            LEFT JOIN TM_SECTION B ON A.INT_ID_SECTION_PIC = B.INT_ID_SECTION
                                            WHERE INT_FLG_DEL = '0' AND CHR_START_DATE LIKE '$periode%'")->result();
        return $problem_section;
    }
    
    function get_all_list_problem() {
        $all_list_problem = $this->db->query("SELECT [INT_ID]
                                                    ,[CHR_PROBLEM]
                                                    ,[CHR_PROBLEM_DESC]
                                                    ,[INT_FLG_DELETE]
                                                FROM [QUA].[TM_LIST_PROBLEM]
                                                WHERE [INT_FLG_DELETE] <> 1
                                                ORDER BY CHR_PROBLEM ASC")->result();
        return $all_list_problem;
    }
    
    function get_inspector_sect($id_sect) {
        $inspector_sect = $this->db->query("SELECT [INT_ID_SECTION]
                                        ,[CHR_SECTION]
                                        ,[CHR_SECTION_DESC]                                        
                                    FROM [TM_SECTION]
                                    WHERE [INT_ID_SECTION] = '$id_sect'")->row();
        return $inspector_sect;
    }
    
    function get_report_quality($date_selected) {
        $report_quality = $this->db->query("SELECT [CHR_QPROBLEM_TITLE]
                                                   ,COUNT([CHR_QPROBLEM_TITLE]) AS QTY_CASE        
                                            FROM [QUA].[TT_QUALITY_PROBLEM]
                                            WHERE CHR_START_DATE LIKE '$date_selected%' AND INT_ID_CHILD = '0'
                                            GROUP BY [CHR_QPROBLEM_TITLE]                                            
                                            ORDER BY COUNT([CHR_QPROBLEM_TITLE]) DESC")->result();
        return $report_quality;
    }
    
    function get_backno_problem($date_selected) {
        $backno_problem = $this->db->query("SELECT CHR_BACK_NO        
                                            FROM [QUA].[TT_QUALITY_PROBLEM]
                                            WHERE CHR_START_DATE LIKE '$date_selected%'
                                            GROUP BY [CHR_QPROBLEM_TITLE],CHR_BACK_NO                                            
                                            ORDER BY COUNT([CHR_QPROBLEM_TITLE]) DESC")->result();
        return $backno_problem;
    }
    
    function get_report_quality_by_backno($date_selected, $back_no, $section, $status) {
        $report_quality_backno = $this->db->query("SELECT [CHR_QPROBLEM_TITLE]
                                                   ,CHR_BACK_NO
                                                   ,COUNT([CHR_QPROBLEM_TITLE]) AS QTY_CASE        
                                            FROM [QUA].[TT_QUALITY_PROBLEM]
                                            WHERE CHR_START_DATE LIKE '$date_selected%'
                                                AND CHR_BACK_NO LIKE '$back_no%'
                                                AND INT_ID_SECTION_PIC LIKE '$section%'
                                                AND INT_STATUS LIKE '$status%'
                                                AND INT_ID_CHILD = '0'
                                            GROUP BY [CHR_QPROBLEM_TITLE],CHR_BACK_NO                                            
                                            ORDER BY COUNT([CHR_QPROBLEM_TITLE]) DESC")->result();
        return $report_quality_backno;
    }
    
    function get_report_by_product_per_day($date_selected, $back_no, $section, $status) {
        $report_per_day = $this->db->query("SELECT CHR_BACK_NO
                                                   ,CHR_START_DATE
                                                   ,COUNT([CHR_QPROBLEM_TITLE]) AS QTY_CASE        
                                            FROM [QUA].[TT_QUALITY_PROBLEM]
                                            WHERE CHR_START_DATE LIKE '$date_selected%'
                                                AND CHR_BACK_NO LIKE '$back_no%'
                                                AND INT_ID_SECTION_PIC LIKE '$section%'
                                                AND INT_STATUS LIKE '$status%'
                                                AND INT_ID_CHILD = '0'
                                            GROUP BY CHR_BACK_NO, CHR_START_DATE                                          
                                            ORDER BY CHR_START_DATE ASC")->result();
        return $report_per_day;
    }
    
    function get_report_by_section_per_day($date_selected, $back_no, $section, $status) {
        $report_by_section = $this->db->query("SELECT A.INT_ID_SECTION_PIC AS INT_ID_SECTION_PIC
                                                    ,A.CHR_START_DATE AS CHR_START_DATE
                                                    ,B.CHR_SECTION AS CHR_SECTION
                                                    ,COUNT(A.[CHR_QPROBLEM_TITLE]) AS QTY_CASE        
                                                FROM [QUA].[TT_QUALITY_PROBLEM] A
                                                LEFT JOIN [TM_SECTION] B ON A.INT_ID_SECTION_PIC = B.INT_ID_SECTION
                                                WHERE A.CHR_START_DATE LIKE '$date_selected%'
                                                    AND A.CHR_BACK_NO LIKE '$back_no%'
                                                    AND A.INT_ID_SECTION_PIC LIKE '$section%'
                                                    AND A.INT_STATUS LIKE '$status%'
                                                GROUP BY A.INT_ID_SECTION_PIC, A.CHR_START_DATE, B.CHR_SECTION                                          
                                                ORDER BY CHR_START_DATE")->result();
        return $report_by_section;
    }
    
    function get_report_by_product($date_selected, $back_no, $section, $status) {
        $report_by_product = $this->db->query("SELECT CHR_BACK_NO
                                                    ,COUNT([CHR_QPROBLEM_TITLE]) AS QTY_CASE        
                                                FROM [QUA].[TT_QUALITY_PROBLEM]
                                                WHERE CHR_START_DATE LIKE '$date_selected%'
                                                    AND CHR_BACK_NO LIKE '$back_no%'
                                                    AND INT_ID_SECTION_PIC LIKE '$section%'
                                                    AND INT_STATUS LIKE '$status%'
                                                    AND INT_ID_CHILD = '0'
                                                GROUP BY CHR_BACK_NO                                         
                                                ORDER BY COUNT([CHR_QPROBLEM_TITLE]) DESC")->result();
        return $report_by_product;
    }
    
    function get_report_by_section($date_selected, $back_no, $section, $status) {
        $report_by_section = $this->db->query("SELECT A.INT_ID_SECTION_PIC AS INT_ID_SECTION_PIC
                                                    ,B.CHR_SECTION AS CHR_SECTION
                                                    ,B.CHR_SECTION_DESC AS CHR_SECTION_DESC
                                                    ,COUNT(A.[CHR_QPROBLEM_TITLE]) AS QTY_CASE        
                                                FROM [QUA].[TT_QUALITY_PROBLEM] A
                                                LEFT JOIN [TM_SECTION] B ON A.INT_ID_SECTION_PIC = B.INT_ID_SECTION
                                                WHERE A.CHR_START_DATE LIKE '$date_selected%'
                                                    AND A.CHR_BACK_NO LIKE '$back_no%'
                                                    AND A.INT_ID_SECTION_PIC LIKE '$section%'
                                                    AND A.INT_STATUS LIKE '$status%'
                                                GROUP BY A.INT_ID_SECTION_PIC, B.CHR_SECTION, B.CHR_SECTION_DESC                                          
                                                ORDER BY COUNT([CHR_QPROBLEM_TITLE]) DESC")->result();
        return $report_by_section;
    }
    
    function get_pareto_problem_by_product($date_selected, $back_no, $section, $status) {
        $pareto_by_product = $this->db->query("EXEC QUA.zsp_get_pareto_problem_by_product '$date_selected', '$back_no', '$section', '$status'")->result();
        return $pareto_by_product;
    }
    
    function get_pareto_problem_by_section($date_selected, $back_no, $section, $status) {
        $pareto_by_section = $this->db->query("EXEC QUA.zsp_get_pareto_problem_by_section '$date_selected', '$back_no', '$section', '$status'")->result();
        return $pareto_by_section;
    }
    
    function get_dept_by_sect($sect) {
        $dept = $this->db->query("SELECT INT_ID_DEPT
                                  FROM TM_SECTION
                                  WHERE INT_ID_SECTION = '$sect' AND BIT_FLG_DEL = 'False'");
        return $dept;
    }
    
    function get_mapping_pic($dept, $sect){
        $pic = $this->db->query("SELECT A.CHR_NPK
                                        ,B.CHR_USERNAME
                                FROM QUA.TM_MAPPING_PIC A
                                LEFT JOIN TM_USER B ON A.CHR_NPK = B.CHR_NPK
                                WHERE A.INT_ID_DEPT_RESPONSE = '$dept' AND A.INT_ID_SECT_RESPONSE = '$sect' AND INT_FLG_DELETE <> '1'");
        return $pic;
    }
    
    function get_report_by_tr_status($date_selected, $section, $status) {
        $report_by_tr_status = $this->db->query("SELECT A.INT_ID_SECTION_PIC AS INT_ID_SECTION_PIC
                                                    ,B.CHR_SECTION AS CHR_SECTION
                                                    ,B.CHR_SECTION_DESC AS CHR_SECTION_DESC
                                                    ,A.INT_STATUS AS INT_STATUS
                                                    ,COUNT(A.[CHR_QPROBLEM_TITLE]) AS QTY_CASE        
                                                FROM [QUA].[TT_QUALITY_PROBLEM] A
                                                LEFT JOIN [TM_SECTION] B ON A.INT_ID_SECTION_PIC = B.INT_ID_SECTION
                                                WHERE A.CHR_START_DATE LIKE '$date_selected%'
                                                    AND A.INT_ID_SECTION_PIC LIKE '$section%'
                                                    AND A.INT_STATUS LIKE '$status%'
                                                GROUP BY A.INT_ID_SECTION_PIC, B.CHR_SECTION, A.INT_STATUS, B.CHR_SECTION_DESC                                          
                                                ORDER BY COUNT([CHR_QPROBLEM_TITLE]) DESC")->result();
        return $report_by_tr_status;
    }
    
    function get_tr_status($date_selected, $section, $status) {
        $tr_status = $this->db->query("SELECT INT_STATUS
                                           ,CASE WHEN INT_STATUS = '0' THEN 'NO FOLLOW UP'
                                                WHEN INT_STATUS = '1' THEN 'ON PROGRESS'
                                                WHEN INT_STATUS = '2' THEN 'COMPLETE'
                                                ELSE 'CLOSED' END AS STATUS                                                    
                                            ,COUNT([CHR_QPROBLEM_TITLE]) AS QTY_CASE        
                                        FROM [QUA].[TT_QUALITY_PROBLEM] A
                                        WHERE CHR_START_DATE LIKE '$date_selected%'
                                            AND INT_ID_SECTION_PIC LIKE '$section%'
                                            AND INT_STATUS LIKE '$status%'
                                        GROUP BY INT_STATUS                                          
                                        ORDER BY COUNT([CHR_QPROBLEM_TITLE]) DESC")->result();
        return $tr_status;
    }
    
    function get_num_child_tr($id_parent, $first_child){
        $get_data = $this->db->query("SELECT CHR_TR_NO
                                FROM QUA.TT_QUALITY_PROBLEM
                                WHERE INT_ID_PARENT = '$id_parent' AND INT_ID_CHILD = '$first_child'")->num_rows();
        return $get_data;
    }

}
