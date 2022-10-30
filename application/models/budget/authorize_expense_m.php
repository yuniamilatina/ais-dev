<?php

class authorize_expense_m extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get_all_dept() {
        $all_dept = $this->db->query("SELECT INT_ID_DEPT, CHR_DEPT, CHR_DEPT_DESC
                                    FROM TM_DEPT WHERE BIT_FLG_DEL <> 1
                                    order by CHR_DEPT")->result();
        return $all_dept;
    }
    
    function get_all_budget_sub_group() {
        $all_budget_type = $this->db->query("SELECT INT_ID_BUDGET_SUB_GROUP, CHR_BUDGET_SUB_GROUP, CHR_BUDGET_SUB_GROUP_DESC
                                    FROM CPL.TM_BUDGET_SUB_GROUP WHERE BIT_FLG_DEL <> '1' AND INT_ID_BUDGET_GROUP = '2'")->result();
        return $all_budget_type;
    }
    
    function get_name_sub_group($INT_ID_BUDGET_SUB_GROUP) {
        $all_budget_type = $this->db->query("SELECT CHR_BUDGET_SUB_GROUP, CHR_BUDGET_SUB_GROUP_DESC
                                    FROM CPL.TM_BUDGET_SUB_GROUP WHERE BIT_FLG_DEL <> '1' AND INT_ID_BUDGET_SUB_GROUP = '$INT_ID_BUDGET_SUB_GROUP'")->row();
        return $all_budget_type;
    }    
    
    function get_all_budget_type($INT_ID_BUDGET_SUB_GROUP) {
        $all_budget_type = $this->db->query("SELECT INT_ID_BUDGET_TYPE, CHR_BUDGET_TYPE, CHR_BUDGET_TYPE_DESC
                                    FROM CPL.TM_BUDGET_TYPE WHERE BIT_FLG_DEL <> '1' AND INT_ID_BUDGET_SUB_GROUP = '$INT_ID_BUDGET_SUB_GROUP'")->result();
        return $all_budget_type;
    }
    
    function get_all_category($INT_ID_BUDGET_TYPE) {
        $all_category = $this->db->query("SELECT DISTINCT A.INT_ID_BUDGET_CATEGORY, A.CHR_BUDGET_CATEGORY, A.CHR_BUDGET_CATEGORY_DESC, B.INT_ID_BUDGET_TYPE, B.CHR_BUDGET_TYPE
                                        FROM CPL.TM_BUDGET_CATEGORY AS A 
                                        LEFT JOIN CPL.TM_BUDGET_TYPE AS B ON A.INT_ID_BUDGET_TYPE = B.INT_ID_BUDGET_TYPE
                                        WHERE A.BIT_FLG_DEL <> '1' AND A.INT_ID_BUDGET_TYPE = '$INT_ID_BUDGET_TYPE'
                                        ORDER BY A.CHR_BUDGET_CATEGORY")->result();
        return $all_category;
    }
        
}
