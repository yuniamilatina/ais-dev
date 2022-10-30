<?php

class authorize_system_c extends CI_Controller {
    /* -- define constructor -- */

    private $layout = '/template/head';

    public function __construct() {
        parent::__construct();
        $this->load->model('organization/dept_m');
        $this->load->model('budget/authorize_system_m');
    }

    function index() {        
        $data['title'] = 'Manage Authorization Upload';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(170);
        $data['news'] = $this->news_m->get_news();
        $data['role'] = $this->session->userdata('ROLE'); 
        
        $data['all_dept'] = $this->authorize_system_m->get_all_dept();
        $data['all_budget_sub_group'] = $this->authorize_system_m->get_all_budget_sub_group();  
        
        $data['content'] = 'budget/authorize_system/authorize_system_v';
        $this->load->view($this->layout, $data);
        
    }
    
    function update_authorized_upload(){    
        $session = $this->session->all_userdata();
        $pic = $session['USERNAME'];
        $date = date("Ymd");
        $time = date("His");
        $all_budget_sub_group = $this->authorize_system_m->get_all_budget_sub_group();
        $all_dept = $this->authorize_system_m->get_all_dept();
        
        if (isset($_POST['update'])) {
            foreach ($all_budget_sub_group as $bgt) {
                $bgt_subgroup = trim($bgt->CHR_BUDGET_SUB_GROUP);
                foreach ($all_dept as $isi) {
                    $dept = trim($isi->CHR_DEPT);
                    $check_name = $bgt_subgroup.$dept;
                    if (isset($_POST["$check_name"])) {                        
                        //--- CONDITION CHECKED
                        $cek_author_dept = $this->db->query("SELECT INT_ID_DEPT
                                                            FROM CPL.TT_MAPPING_AUTHORIZE_UPLOAD
                                                            WHERE INT_FLG_DELETE <> '1' AND INT_ID_BUDGET_SUB_GROUP = '$bgt->INT_ID_BUDGET_SUB_GROUP' AND INT_ID_DEPT = '$isi->INT_ID_DEPT'");                        
                        $count = $cek_author_dept->num_rows();
                        if($count == 0){
                            $insert_author_dept = $this->db->query("INSERT INTO CPL.TT_MAPPING_AUTHORIZE_UPLOAD
                                                    (INT_ID_DEPT, CHR_DEPT, INT_ID_BUDGET_SUB_GROUP, CHR_BUDGET_SUB_GROUP, INT_FLG_UPLOAD, CHR_CREATE_BY, CHR_CREATE_DATE, CHR_CREATE_TIME)
                                                    VALUES
                                                    ('$isi->INT_ID_DEPT', '$dept', '$bgt->INT_ID_BUDGET_SUB_GROUP', '$bgt->CHR_BUDGET_SUB_GROUP', '1', '$pic', '$date', '$time')");
                        } else {
                            $update_author_dept = $this->db->query("UPDATE CPL.TT_MAPPING_AUTHORIZE_UPLOAD
                                                    SET INT_FLG_UPLOAD = '1', CHR_MODI_BY = '$pic', CHR_MODI_DATE = '$date', CHR_MODI_TIME = '$time'
                                                    WHERE INT_ID_DEPT = '$isi->INT_ID_DEPT' AND INT_ID_BUDGET_SUB_GROUP = '$bgt->INT_ID_BUDGET_SUB_GROUP' AND INT_FLG_DELETE <> '1'");
                        }
                    } else {
                        //--- CONDITION UNCHECKED
                        $cek_author_dept = $this->db->query("SELECT INT_ID_DEPT
                                                            FROM CPL.TT_MAPPING_AUTHORIZE_UPLOAD
                                                            WHERE INT_FLG_DELETE <> '1' AND INT_ID_BUDGET_SUB_GROUP = '$bgt->INT_ID_BUDGET_SUB_GROUP' AND INT_ID_DEPT = '$isi->INT_ID_DEPT'");
                        $count = $cek_author_dept->num_rows();
                        if($count != 0){
                            $update_author_dept = $this->db->query("UPDATE CPL.TT_MAPPING_AUTHORIZE_UPLOAD
                                                    SET INT_FLG_UPLOAD = '0', CHR_MODI_BY = '$pic', CHR_MODI_DATE = '$date', CHR_MODI_TIME = '$time'
                                                    WHERE INT_ID_DEPT = '$isi->INT_ID_DEPT' AND INT_ID_BUDGET_SUB_GROUP = '$bgt->INT_ID_BUDGET_SUB_GROUP' AND INT_FLG_DELETE <> '1'");
                        }
                    }
                }
            }
            
            $this->session->set_flashdata('flashSuccess', 'Authorization system berhasil di Update.');
            redirect("budget/authorize_system_c/index");
        }
    }

}
