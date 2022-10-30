<?php

class authorize_system_m extends CI_Model {

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
                                    FROM CPL.TM_BUDGET_SUB_GROUP WHERE BIT_FLG_DEL <> '1'")->result();
        return $all_budget_type;
    }
        
}
