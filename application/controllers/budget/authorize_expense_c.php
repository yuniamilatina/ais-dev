<?php

class authorize_expense_c extends CI_Controller {
    /* -- define constructor -- */

    private $layout = '/template/head';

    public function __construct() {
        parent::__construct();
        $this->load->model('organization/dept_m');
        $this->load->model('budget/authorize_expense_m');
    }
    
    function index($INT_ID_BUDGET_SUB_GROUP = null) {
        if($INT_ID_BUDGET_SUB_GROUP == null){
            $INT_ID_BUDGET_SUB_GROUP = 2;
        }
        
        $data['title'] = 'Manage Authorization of Menu Budget';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(207);
        $data['news'] = $this->news_m->get_news();
        $data['role'] = $this->session->userdata('ROLE');
        $data['INT_ID_BUDGET_SUB_GROUP'] = $INT_ID_BUDGET_SUB_GROUP; 
        
        $data['all_dept'] = $this->authorize_expense_m->get_all_dept();
        $data['all_budget_sub_group'] = $this->authorize_expense_m->get_all_budget_sub_group(); 
        $data['all_budget_type'] = $this->authorize_expense_m->get_all_budget_type($INT_ID_BUDGET_SUB_GROUP); 
        
        $data['content'] = 'budget/authorize_system/authorize_expense_v';
        $this->load->view($this->layout, $data);
        
    }
    
    function update_authorized_expense(){    
        $session = $this->session->all_userdata();
        $pic = $session['USERNAME'];
        $date = date("Ymd");
        $time = date("His");
        $INT_ID_BUDGET_SUB_GROUP = $this->input->post('INT_ID_BUDGET_SUB_GROUP');
        $name_sub_group = $this->authorize_expense_m->get_name_sub_group($INT_ID_BUDGET_SUB_GROUP);;
        $all_budget_type = $this->authorize_expense_m->get_all_budget_type($INT_ID_BUDGET_SUB_GROUP);
        $all_dept = $this->authorize_expense_m->get_all_dept();
        
        if (isset($_POST['update'])) {
            foreach ($all_budget_type as $bgt) {
                $bgt_type = trim($bgt->CHR_BUDGET_TYPE);
                foreach ($all_dept as $isi) {
                    $dept = trim($isi->CHR_DEPT);
                    $check_name = $bgt_type.$dept;
                    if (isset($_POST["$check_name"])) {                        
                        //--- CONDITION CHECKED
                        $cek_author_dept = $this->db->query("SELECT INT_ID_DEPT
                                                            FROM CPL.TT_MAPPING_AUTHORIZE_EXPENSE
                                                            WHERE INT_FLG_DELETE <> '1' AND INT_ID_BUDGET_TYPE = '$bgt->INT_ID_BUDGET_TYPE' AND INT_ID_DEPT = '$isi->INT_ID_DEPT'");                        
                        $count = $cek_author_dept->num_rows();
                        if($count == 0){
                            $insert_author_dept = $this->db->query("INSERT INTO CPL.TT_MAPPING_AUTHORIZE_EXPENSE
                                                    (INT_ID_DEPT, CHR_DEPT, INT_ID_BUDGET_SUB_GROUP, CHR_BUDGET_SUB_GROUP, INT_ID_BUDGET_TYPE, CHR_BUDGET_TYPE, INT_FLG_PLANNING, CHR_CREATE_BY, CHR_CREATE_DATE, CHR_CREATE_TIME)
                                                    VALUES
                                                    ('$isi->INT_ID_DEPT', '$dept', '$INT_ID_BUDGET_SUB_GROUP', '$name_sub_group->CHR_BUDGET_SUB_GROUP', '$bgt->INT_ID_BUDGET_TYPE', '$bgt_type', '1', '$pic', '$date', '$time')");
                        } else {
                            $update_author_dept = $this->db->query("UPDATE CPL.TT_MAPPING_AUTHORIZE_EXPENSE
                                                    SET INT_FLG_PLANNING = '1', CHR_MODI_BY = '$pic', CHR_MODI_DATE = '$date', CHR_MODI_TIME = '$time'
                                                    WHERE INT_ID_DEPT = '$isi->INT_ID_DEPT' AND INT_ID_BUDGET_TYPE = '$bgt->INT_ID_BUDGET_TYPE' AND INT_FLG_DELETE <> '1'");
                        }
                    } else {
                        //--- CONDITION UNCHECKED
                        $cek_author_dept = $this->db->query("SELECT INT_ID_DEPT
                                                            FROM CPL.TT_MAPPING_AUTHORIZE_EXPENSE
                                                            WHERE INT_FLG_DELETE <> '1' AND INT_ID_BUDGET_TYPE = '$bgt->INT_ID_BUDGET_TYPE' AND INT_ID_DEPT = '$isi->INT_ID_DEPT'");
                        $count = $cek_author_dept->num_rows();
                        if($count != 0){
                            $update_author_dept = $this->db->query("UPDATE CPL.TT_MAPPING_AUTHORIZE_EXPENSE
                                                    SET INT_FLG_PLANNING = '0', CHR_MODI_BY = '$pic', CHR_MODI_DATE = '$date', CHR_MODI_TIME = '$time'
                                                    WHERE INT_ID_DEPT = '$isi->INT_ID_DEPT' AND INT_ID_BUDGET_TYPE = '$bgt->INT_ID_BUDGET_TYPE' AND INT_FLG_DELETE <> '1'");
                        }
                    }
                }
            }
            
            $this->session->set_flashdata('flashSuccess', 'Authorization system berhasil di Update.');
            redirect("budget/authorize_expense_c/index/$INT_ID_BUDGET_SUB_GROUP");
        }
    }

}
