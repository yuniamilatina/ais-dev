<?php

class purposebudget_c extends CI_Controller {

    private $layout = '/template/head';
    private $back_to_manage = 'budget/purposebudget_c/index/';

    public function __construct() {
        parent::__construct();
        $this->load->model('budget/purposebudget_m');
        $this->load->model('basis/log_m');
        $this->load->model('basis/role_module_m');
        $this->load->model('portal/news_m');
        $this->load->model('budget/fiscal_m');
        $this->load->model('organization/dept_m');
    }

    function index($msg = NULL) {
        $this->role_module_m->authorization('17');
        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Creating success </strong> The data is successfully created </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Updating success </strong> The data is successfully updated </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Deleted success </strong> The data is successfully deleted </div >";
        } elseif ($msg == 12) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Executing error !</strong> Something error with parameter </div >";
        } else {
            $msg = "";
        }

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(17);
        $data['news'] = $this->news_m->get_news();


        $data['title'] = 'Manage Purpose Budget';
        $data['msg'] = $msg;
        $data['data'] = $this->purposebudget_m->get_purposebudget();
        $data['content'] = 'budget/purposebudget/manage_purposebudget_v';
        $this->load->view($this->layout, $data);
    }

    //view by id
    function select_by_id($id) {
        $this->role_module_m->authorization('17');
        $data['data'] = $this->purposebudget_m->get_data_purposebudget($id)->row();
        $data['content'] = 'budget/purposebudget/view_purposebudget_v';
        $data['title'] = 'View Purpose Budget';

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(17);
        $data['news'] = $this->news_m->get_news();

        $this->load->view($this->layout, $data);
    }

    function create_purposebudget() {
        $this->role_module_m->authorization('17');
        $this->load->model('budget/budgetgroup_m');

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(17);
        $data['news'] = $this->news_m->get_news();

        $data['data_budget'] = $this->budgetgroup_m->get_budgetgroup();

        $data['title'] = 'Create Purpose Budget';
        $data['content'] = 'budget/purposebudget/create_purposebudget_v';

        $this->load->view($this->layout, $data);
    }

    function save_purposebudget() {
        $this->form_validation->set_rules('CHR_PURPOSE', 'Purpose Budget', 'required|min_length[5]|max_length[5]|callback_check_id|trim');
        $this->form_validation->set_rules('CHR_PURPOSE_DESC', 'Purpose Budget', 'required');

        $id = $this->purposebudget_m->generate_id_purposebudget();
        $session = $this->session->all_userdata();

        if ($this->form_validation->run() == FALSE) {
            $this->create_purposebudget();
        } else {
            $data = array(
                'INT_ID_PURPOSE' => $id,
                'CHR_PURPOSE' => strtoupper($this->input->post('CHR_PURPOSE')),
                'CHR_PURPOSE_DESC' => $this->input->post('CHR_PURPOSE_DESC'),
                'CHR_CREATE_BY' => $session['USERNAME'],
                'CHR_CREATE_DATE' => date('Ymd'),
                'CHR_CREATE_TIME' => date('His'),
                'BIT_FLG_DEL' => 0
            );
            $this->purposebudget_m->save($data);
            $this->log_m->add_log('30', $data['INT_ID_PURPOSE']);
            redirect($this->back_to_manage . $msg = 1);
        }
    }

    //Checking Section 
    function check_id($id) {
        $return_value = $this->purposebudget_m->check_id($id);
        if ($return_value) {
            $this->form_validation->set_message('check_id', "Sorry, Your data Id already exists, please choose another one");
            return FALSE;
        } else {
            return TRUE;
        }
    }

    function edit_purposebudget($id) {
        $this->role_module_m->authorization('17');

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(17);
        $data['news'] = $this->news_m->get_news();

        $data['title'] = 'Edit Purpose Budgets';
        $data['content'] = 'budget/purposebudget/edit_purposebudget_v';

        $data['data'] = $this->purposebudget_m->get_data_purposebudget($id)->row();

        $this->load->view($this->layout, $data);
    }

    function update_purposebudget() {
        $id = $this->input->post('INT_ID_PURPOSE');
        $session = $this->session->all_userdata();

        $this->form_validation->set_rules('CHR_PURPOSE', 'Purpose Budget', 'required|min_length[5]|max_length[5]|trim');
        $this->form_validation->set_rules('CHR_PURPOSE_DESC', 'Purpose Budget', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->edit_purposebudget($id);
        } else {
            $data = array(
                'CHR_PURPOSE' => strtoupper($this->input->post('CHR_PURPOSE')),
                'CHR_PURPOSE_DESC' => $this->input->post('CHR_PURPOSE_DESC'),
                'CHR_MODI_BY' => $session['USERNAME'],
                'CHR_MODI_DATE' => date('Ymd'),
                'CHR_MODI_TIME' => date('His'),
            );
            $this->purposebudget_m->update($data, $id);
            $this->log_m->add_log('31', $data['INT_ID_PURPOSE']);
            redirect($this->back_to_manage . $msg = 2);
        }
    }

    function delete_purposebudget($id) {
        $this->role_module_m->authorization('17');
        $this->purposebudget_m->delete($id);
        $this->log_m->add_log('32', $id);
        redirect($this->back_to_manage . $msg = 3);
    }
    
    //----------------------------// EDIT BY ANP //---------------------------//
    function propose_budget_revision($msg = NULL, $fiscal_start = NULL, $budget_type = NULL, $kd_dept = NULL) {
        $this->role_module_m->authorization('44');
       
        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>x</button><strong>Success </strong>to propose revision of Master Budget </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>x</button><strong>Failed </strong>to propose revision of Master Budget </div >";
        } else {
            $msg = "";
        }
        
        if ($fiscal_start == NULL){
            $fiscal_start = $this->fiscal_m->get_default_fiscal_year()->CHR_FISCAL_YEAR_START;
        }
        
        $fiscal_year = $this->fiscal_m->get_selected_fiscal_year($fiscal_start);
        $fiscal_end = $fiscal_year->CHR_FISCAL_YEAR_END;
        
        if($budget_type == NULL){
            $budget_type = 'CAPEX';
        }
        
        $session = $this->session->all_userdata();
        //FOR --> ADMIN & ADMIN BUDGET
        if ($session['ROLE'] === 2 || $session['ROLE'] === 1 ) {
            if($kd_dept == NULL){
                $dept = '';
            } else {
                $dept = $this->dept_m->get_name_dept($kd_dept);
            }     
            
            //Mapping Dept from AIS to BUDGET
            if($dept == 'MISY'){
                $dept = 'MIS';
            } else if($dept == 'PPIC'){
                $dept = 'PPC';
            } else if($dept == 'QUA'){
                $dept = 'QAS';
            } else {
                $dept = trim($dept);
            }
                    
            $list_master_budget = $this->purposebudget_m->get_list_master_budget($fiscal_start, $fiscal_end, $budget_type, $dept);
           
            $contain = 'budget/purposebudget/propose_budget_revision_v';
            
        //FOR --> GM
        } else if ($session['ROLE'] === 5) {
            $kd_dept = $this->session->userdata('DEPT');
            $dept = $this->dept_m->get_name_dept($kd_dept);
            
            //Mapping Dept from AIS to BUDGET
            if($dept == 'MISY'){
                $dept = 'MIS';
            } else if($dept == 'PPIC'){
                $dept = 'PPC';
            } else if($dept == 'QUA'){
                $dept = 'QAS';
            } else {
                $dept = trim($dept);
            }
            
            $list_master_budget = $this->purposebudget_m->get_list_master_budget($fiscal_start, $fiscal_end, $budget_type, $kd_dept);
                
            $contain = 'budget/purposebudget/propose_budget_revision_v';
        
        }
                
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(190);
        $data['news'] = $this->news_m->get_news();
        $data['role'] = $session['ROLE'];
        $data['msg'] = $msg;
        
        //single data
        $data['fiscal_start'] = $fiscal_start;
        $data['fiscal_end'] = $fiscal_end;
        $data['budget_type'] = $budget_type;
        $data['kd_dept'] = $kd_dept;
        
        //array data
        $data['all_dept'] = $this->dept_m->get_all_dept();
        $data['all_fiscal'] = $this->fiscal_m->get_all_fiscal_year();
        $data['all_bgt_type'] = $this->purposebudget_m->get_all_budget_type();        
        $data['list_master_budget'] = $list_master_budget;
                
        $data['content'] = $contain;
        $data['title'] = 'Propose Revision Master Budget';

        $this->load->view($this->layout, $data);
    }
    
    function get_detail_budget_by_no(){        
        $fiscal_start = $this->input->post("fis_start");
        $fiscal_end = $this->input->post("fis_end");
        $budget_type = $this->input->post("tipe_bgt");
        $no_budget = $this->input->post("nomor_bgt");
        
        $get_data = $this->purposebudget_m->get_detail_budget_by_no($fiscal_start, $fiscal_end, $budget_type, $no_budget);
        
        $json_response = array('MON01' => number_format($get_data->PBLN01,2,',','.'),
                               'MON02' => number_format($get_data->PBLN02,2,',','.'),
                               'MON03' => number_format($get_data->PBLN03,2,',','.'),
                               'MON04' => number_format($get_data->PBLN04,2,',','.'),
                               'MON05' => number_format($get_data->PBLN05,2,',','.'),
                               'MON06' => number_format($get_data->PBLN06,2,',','.'),
                               'MON07' => number_format($get_data->PBLN07,2,',','.'),
                               'MON08' => number_format($get_data->PBLN08,2,',','.'),
                               'MON09' => number_format($get_data->PBLN09,2,',','.'),
                               'MON10' => number_format($get_data->PBLN10,2,',','.'),
                               'MON11' => number_format($get_data->PBLN11,2,',','.'),
                               'MON12' => number_format($get_data->PBLN12,2,',','.'),
                               'MON13' => number_format($get_data->PBLN13,2,',','.'),
                               'MON14' => number_format($get_data->PBLN14,2,',','.'),
                               'MON15' => number_format($get_data->PBLN15,2,',','.')
                                );    

        echo json_encode($json_response);
    }
    
    function edit_budget_revision($fiscal_start = NULL, $budget_type = NULL, $no_budget = NULL) {
        $this->role_module_m->authorization('44');
        
        $no_budget = str_replace('%3C', '/', $no_budget);
        $fiscal_year = $this->fiscal_m->get_selected_fiscal_year($fiscal_start);
        $fiscal_end = $fiscal_year->CHR_FISCAL_YEAR_END;        
        
        $session = $this->session->all_userdata();
        //FOR --> ADMIN & ADMIN BUDGET
        if ($session['ROLE'] === 2 || $session['ROLE'] === 1 ) {            
            $curr_detail_budget = $this->purposebudget_m->get_curr_detail_budget($fiscal_start, $fiscal_end, $budget_type, $no_budget);
            
            $contain = 'budget/purposebudget/edit_propose_budget_revision_v';
            
        //FOR --> GM
        } else if ($session['ROLE'] === 4) {
                
            $contain = 'budget/purposebudget/edit_propose_budget_revision_v';
        
        }
                
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(190);
        $data['news'] = $this->news_m->get_news();
        $data['role'] = $session['ROLE'];
        
        //single data
        $data['fiscal_start'] = $fiscal_start;
        $data['fiscal_end'] = $fiscal_end;
        $data['budget_type'] = $budget_type;
        $data['budget_no'] = $no_budget;
        
        //array data
        $data['all_fiscal'] = $this->fiscal_m->get_all_fiscal_year();
        $data['curr_detail_budget'] = $curr_detail_budget;
                
        $data['content'] = $contain;
        $data['title'] = 'Propose Revision Master Budget';

        $this->load->view($this->layout, $data);
    }
    
    function propose_unbudget() {
        $fiscal_start = '2016';
        $fiscal_year = $this->fiscal_m->get_selected_fiscal_year($fiscal_start);
        $fiscal_end = $fiscal_year->CHR_FISCAL_YEAR_END;        
        
        $session = $this->session->all_userdata();
        //FOR --> ADMIN & ADMIN BUDGET
        if ($session['ROLE'] === 2 || $session['ROLE'] === 1 ) {
            $role = $session['ROLE'];
            $kode_group = '';
            $dept = '';
            $get_list_dept = $this->purposebudget_m->get_list_dept($role, $kode_group, $dept);
            
            $contain = 'budget/purposebudget/propose_unbudget_v';
            
        //FOR --> GM
        } else if ($session['ROLE'] === 4) {
            $role = $session['ROLE'];
            
            if($session['GROUPDEPT'] == '6'){
                $kode_group = '001';
            } else if($session['GROUPDEPT'] == '7'){
                $kode_group = '003';
            }
            
            $dept = '';
            $get_list_dept = $this->purposebudget_m->get_list_dept($role, $kode_group, $dept);
            
            $contain = 'budget/purposebudget/propose_unbudget_v';
        
        //FOR --> MANAGER
        } else if ($session['ROLE'] === 5) {
            $role = $session['ROLE'];            
            $kode_dept = $session['DEPT'];                       
            $get_dept = $this->purposebudget_m->get_dept($kode_dept);
            
            if($get_dept->CHR_DEPT == 'MISY'){
                $dept = 'MIS';
            } else if ($get_dept->CHR_DEPT == 'PPIC'){
                $dept = 'PPC';
            } else {
                $dept = $get_dept->CHR_DEPT;
            }
            
            $get_list_dept = $this->purposebudget_m->get_list_dept($role, $kode_group, $dept);
            $kode_group = $this->purposebudget_m->get_kode_group($dept)->CHR_KODE_GROUP; 
            
            $contain = 'budget/purposebudget/propose_unbudget_v';
        
        }
                
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(190);
        $data['news'] = $this->news_m->get_news();
        $data['role'] = $session['ROLE'];
        
        //single data
        $data['fiscal_start'] = $fiscal_start;
        $data['fiscal_end'] = $fiscal_end;
        $data['dept'] = $dept; 
        $data['kode_group'] = $kode_group;
        
        //array data
        $data['all_fiscal'] = $this->fiscal_m->get_all_fiscal_year();
        $data['list_dept'] = $get_list_dept;
        $data['all_bgt_type'] = $this->purposebudget_m->get_all_budget_type();
        $data['list_project'] = $this->purposebudget_m->get_list_project();
        $data['list_purpose'] = $this->purposebudget_m->get_list_purpose();        
                
        $data['content'] = $contain;
        $data['title'] = 'Propose Unbudget';

        $this->load->view($this->layout, $data);
    }
    
    function save_revision_budget(){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        
        $budget_type = $this->input->post('CHR_TYPE_BUDGET');
        $budget_no = $this->input->post('CHR_NO_BUDGET');
        $fiscal_start = $this->input->post('CHR_FISCAL_START');
        $fiscal_end = $this->input->post('CHR_FISCAL_END');
        $trans_date = date("Ymd");
        $notes = $this->input->post('CHR_NOTES');
                
        //Current amount & qty        
        $curr_tot_amo = str_replace('.', '', $this->input->post('CURR_TOT_AMO'));
        $curr_tot_qty = $this->input->post('CURR_TOT_QTY');
        
        //Detail req amount per month
        $req_amo04 = str_replace('.', '', $this->input->post('REQ_BGT_LIMBLN04'));
        $req_amo05 = str_replace('.', '', $this->input->post('REQ_BGT_LIMBLN05'));
        $req_amo06 = str_replace('.', '', $this->input->post('REQ_BGT_LIMBLN06'));
        $req_amo07 = str_replace('.', '', $this->input->post('REQ_BGT_LIMBLN07'));
        $req_amo08 = str_replace('.', '', $this->input->post('REQ_BGT_LIMBLN08'));
        $req_amo09 = str_replace('.', '', $this->input->post('REQ_BGT_LIMBLN09'));
        $req_amo10 = str_replace('.', '', $this->input->post('REQ_BGT_LIMBLN10'));
        $req_amo11 = str_replace('.', '', $this->input->post('REQ_BGT_LIMBLN11'));
        $req_amo12 = str_replace('.', '', $this->input->post('REQ_BGT_LIMBLN12'));
        $req_amo13 = str_replace('.', '', $this->input->post('REQ_BGT_LIMBLN13'));
        $req_amo14 = str_replace('.', '', $this->input->post('REQ_BGT_LIMBLN14'));
        $req_amo15 = str_replace('.', '', $this->input->post('REQ_BGT_LIMBLN15'));
        $req_tot_amo = str_replace('.', '', $this->input->post('REQ_TOT_AMO'));
        
        //Detail req qty per month
        $req_qty04 = $this->input->post('REQ_QTY_LIMBLN04');
        $req_qty05 = $this->input->post('REQ_QTY_LIMBLN05');
        $req_qty06 = $this->input->post('REQ_QTY_LIMBLN06');
        $req_qty07 = $this->input->post('REQ_QTY_LIMBLN07');
        $req_qty08 = $this->input->post('REQ_QTY_LIMBLN08');
        $req_qty09 = $this->input->post('REQ_QTY_LIMBLN09');
        $req_qty10 = $this->input->post('REQ_QTY_LIMBLN10');
        $req_qty11 = $this->input->post('REQ_QTY_LIMBLN11');
        $req_qty12 = $this->input->post('REQ_QTY_LIMBLN12');
        $req_qty13 = $this->input->post('REQ_QTY_LIMBLN13');
        $req_qty14 = $this->input->post('REQ_QTY_LIMBLN14');
        $req_qty15 = $this->input->post('REQ_QTY_LIMBLN15');
        $req_tot_qty = $this->input->post('REQ_TOT_QTY');
        
        $change_amo = 0;
        if($req_tot_amo != $curr_tot_amo){
            $change_amo = 1;
        }        
        
        $schedule = 0;        
        for($i = 4; $i < 16; $i++){
            $month = sprintf("%02d", $i);
            if($this->input->post('CURR_BGT_LIMBLN'.$month) == 0){
                if($this->input->post('REQ_BGT_LIMBLN'.$month) > 0){
                    $schedule = 1;
                }                
            }
        }      
        
        $get_no_revisi = $this->purposebudget_m->get_no_revisi($budget_no);
        if($get_no_revisi == NULL){
            $no_revisi = 1;
        } else {
            $no_revisi = $get_no_revisi->INT_NO_REVISI + 1;
        }
        
        
//----------- IF YEAR ACTUAL DINAMIC DEPEND REQUEST --------------------------//
//      if($budget_type == "CAPEX"){
//            $act_month = 0;
//            for($m = 4; $m < 16; $m++){
//                $mon = sprintf("%02d", $m);
//                if($this->input->post('REQ_BGT_LIMBLN'.$mon) > 0){
//                    $act_month = $m;
//                }
//            } 
//            
//            if($act_month > 12){
//                $year_act = $fiscal_end;
//            } else {
//                $year_act = $fiscal_start;
//            }
//      }
//----------------------------------------------------------------------------//
         
        $bgt_aii->trans_start();
        
        if($budget_type == "CAPEX"){
            $year_act = $this->purposebudget_m->get_year_actual_cpx($budget_no)->CHR_TAHUN_ACTUAL;
            if($year_act == $fiscal_start){
                $capex = array(
                            'INT_NO_REVISI' => $no_revisi,
                            'CHR_TGL_TRANS' => $trans_date,                    
                            'CHR_TAHUN_BUDGET' => $fiscal_start,
                            'CHR_TAHUN_ACTUAL' => $year_act,                    
                            'CHR_NO_BUDGET' => $budget_no,
                            'CHR_KODE_TYPE_BUDGET' => $budget_type,
                            'MON_LIMBLN04' => $req_amo04,
                            'MON_LIMBLN05' => $req_amo05,
                            'MON_LIMBLN06' => $req_amo06,
                            'MON_LIMBLN07' => $req_amo07,
                            'MON_LIMBLN08' => $req_amo08, 
                            'MON_LIMBLN09' => $req_amo09,
                            'MON_LIMBLN10' => $req_amo10,
                            'MON_LIMBLN11' => $req_amo11,
                            'MON_LIMBLN12' => $req_amo12,
                            'CHR_FLG_SWITCH' => 0,
                            'CHR_FLG_NOTES' => $notes
                        );
                $this->purposebudget_m->save_revision_budget($capex);
                $this->purposebudget_m->update_master_budget_cpx($capex, $budget_no); 
            } else {
                $capex = array(
                            'INT_NO_REVISI' => $no_revisi,
                            'CHR_TGL_TRANS' => $trans_date,                    
                            'CHR_TAHUN_BUDGET' => $fiscal_start,
                            'CHR_TAHUN_ACTUAL' => $year_act,                    
                            'CHR_NO_BUDGET' => $budget_no,
                            'CHR_KODE_TYPE_BUDGET' => $budget_type,
                            'MON_LIMBLN01' => $req_amo13,
                            'MON_LIMBLN02' => $req_amo14,
                            'MON_LIMBLN03' => $req_amo15,                            
                            'CHR_FLG_SWITCH' => 0,
                            'CHR_FLG_NOTES' => $notes
                        );
                $this->purposebudget_m->save_revision_budget($capex);                
            }
            
            $data = array(
                            'CHR_FLG_RESCHEDULE' => $schedule,
                            'CHR_FLG_CHANGE_AMOUNT' => $change_amo,                    
                            'CHR_FLG_APPROVAL_PROCESS' => 1
                        );
            $this->purposebudget_m->update_master_budget($data, $budget_type, $budget_no);
        } else {
            $expense_start = array(
                            'INT_NO_REVISI' => $no_revisi,
                            'CHR_TGL_TRANS' => $trans_date,                    
                            'CHR_TAHUN_BUDGET' => $fiscal_start,
                            'CHR_TAHUN_ACTUAL' => $fiscal_start,                    
                            'CHR_NO_BUDGET' => $budget_no,
                            'CHR_KODE_TYPE_BUDGET' => $budget_type,
                            'MON_LIMBLN04' => $req_amo04,
                            'MON_LIMBLN05' => $req_amo05,
                            'MON_LIMBLN06' => $req_amo06,
                            'MON_LIMBLN07' => $req_amo07,
                            'MON_LIMBLN08' => $req_amo08, 
                            'MON_LIMBLN09' => $req_amo09,
                            'MON_LIMBLN10' => $req_amo10,
                            'MON_LIMBLN11' => $req_amo11,
                            'MON_LIMBLN12' => $req_amo12,                            
                            'INT_QTY_LIMBLN04' => $req_qty04,
                            'INT_QTY_LIMBLN05' => $req_qty05,
                            'INT_QTY_LIMBLN06' => $req_qty06,
                            'INT_QTY_LIMBLN07' => $req_qty07,
                            'INT_QTY_LIMBLN08' => $req_qty08,
                            'INT_QTY_LIMBLN09' => $req_qty09,
                            'INT_QTY_LIMBLN10' => $req_qty10,
                            'INT_QTY_LIMBLN11' => $req_qty11,
                            'INT_QTY_LIMBLN12' => $req_qty12,
                            'CHR_FLG_SWITCH' => 0,
                            'CHR_FLG_NOTES' => $notes
                        );
            $this->purposebudget_m->save_revision_budget($expense_start);
            
            $expense_end = array(
                            'INT_NO_REVISI' => $no_revisi,
                            'CHR_TGL_TRANS' => $trans_date,                    
                            'CHR_TAHUN_BUDGET' => $fiscal_start,
                            'CHR_TAHUN_ACTUAL' => $fiscal_end,                    
                            'CHR_NO_BUDGET' => $budget_no,
                            'CHR_KODE_TYPE_BUDGET' => $budget_type,
                            'MON_LIMBLN01' => $req_amo01,
                            'MON_LIMBLN02' => $req_amo02,
                            'MON_LIMBLN03' => $req_amo03,                                                   
                            'INT_QTY_LIMBLN01' => $req_qty01,
                            'INT_QTY_LIMBLN02' => $req_qty02,
                            'INT_QTY_LIMBLN03' => $req_qty03,                            
                            'CHR_FLG_SWITCH' => 0,
                            'CHR_FLG_NOTES' => $notes
                        );
            $this->purposebudget_m->save_revision_budget($expense_end);
            
            $data = array(
                            'CHR_FLG_RESCHEDULE' => $schedule,
                            'CHR_FLG_CHANGE_AMOUNT' => $change_amo,                    
                            'CHR_FLG_APPROVAL_PROCESS' => 1
                        );
            $this->purposebudget_m->update_master_budget($data, $budget_type, $budget_no);
        }       
               
        $bgt_aii->trans_complete();
        
        if ($bgt_aii->trans_status() === FALSE)
        {
            $bgt_aii->trans_rollback();
            redirect("budget/purposebudget_c/propose_budget_revision/2/".$fiscal_start."/".$budget_type);
        }
        else
        {
            $bgt_aii->trans_commit();
            redirect("budget/purposebudget_c/propose_budget_revision/1/".$fiscal_start."/".$budget_type);
        }
        
        print_r($year_act);
        exit();
    }
    
    function get_list_category() {
        $bgt_type = $this->input->post('type_budget');
        $list_category = $this->purposebudget_m->get_list_category($bgt_type);
        $option = '';
        
        foreach ($list_category as $data){
            $option .= '<option value="' . trim($data->CHR_KODE_SUBCATEGORY_BUDGET) . '">' . strtoupper(trim($data->CHR_KODE_SUBCATEGORY_BUDGET)) . ' - ' . substr($data->CHR_DESC_SUBCATEGORY_BUDGET, 0, 40) . '</option>';
        }
        
        echo $option;
    }
    
    function get_list_section() {
        $kode_dept = $this->input->post('kode_dept');
        $list_section = $this->purposebudget_m->get_list_section($kode_dept);
        $option_sect = '';
        
        $i = 1;
        foreach ($list_section as $data){
            if($i > 1){
                $option_sect .= '<option value="' . trim($data->CHR_DETILGROUP) . '">' . $data->CHR_DETILGROUP . ' (' . $data->CHR_USER_DESC . ')' . '</option>';
            } else {            
                $option_sect .= '<option value="' . trim($data->CHR_DETILGROUP) . '" selected>' . $data->CHR_DETILGROUP . ' (' . $data->CHR_USER_DESC . ')' . '</option>';
            }
            $i++;
        }
        
        echo $option_sect;
    } 
    
    function generate_no_budget() {
        $bgt_type = $this->input->post('id_bgt');
        $dept = $this->input->post('id_dept');
        $sect = $this->input->post('id_sect');
        $year = $this->input->post('id_thn');
        
        if($bgt_type != '' && $dept != '' && $sect != '' && $year != '' ){
            $get_unbudget = $this->purposebudget_m->get_exist_unbudget($bgt_type, $year, $dept, $sect);
            $get_prefix = $this->purposebudget_m->get_prefix($bgt_type);
            $prefix = $get_prefix->CHR_PREFIX_BUDGET;
            if(count($get_unbudget) > 0){
                $exist_no = substr($get_unbudget->CHR_NO_BUDGET,-4);
                $no = $exist_no + 1;
                $new_no = sprintf("%04d", $no);
                $no_unbudget = $prefix . '/' . $sect . '/UNB/' . substr($year,-2) . $new_no;
            } else {
                $no = 1;
                $new_no = sprintf("%04d", $no);
                $no_unbudget = $prefix . '/' . $sect . '/UNB/' . substr($year,-2) . $new_no;
            }            
        } else {
            $exist_no = '';
            $no_unbudget = '';
        }
                
        echo $no_unbudget;
    }
    
    function save_propose_unbudget(){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        $session = $this->session->all_userdata();
        
        $budget_type = $this->input->post('CHR_TYPE_BUDGET');
        $budget_no = $this->input->post('CHR_NO_BUDGET');
        $fiscal_start = $this->input->post('CHR_FISCAL_START');
        $fiscal_end = $this->input->post('CHR_FISCAL_END');
        $trans_date = date("Ymd");
        
        $dept = $this->input->post('CHR_DEPT');
        
        if($session['ROLE'] == 1 || $session['ROLE'] == 2 ){
            $kode_group = $this->purposebudget_m->get_kode_group($dept)->CHR_KODE_GROUP; 
        } else {
            $kode_group = $this->input->post('CHR_KODE_GROUP');
        }        
        
        $sect = $this->input->post('CHR_SECTION');
        $category = $this->input->post('CHR_CATEGORY');
        
        if($this->input->post('CHR_STATUS')  == 1){
            $status = $this->input->post('CHR_STATUS');
            $project = $this->input->post('CHR_PROJECT');
        } else {
            $status = '0';
            $project = '-';
        }
                
        if($this->input->post('CHR_PURPOSE') != '' || $this->input->post('CHR_PURPOSE') != NULL){
            $purpose = $this->input->post('CHR_PURPOSE');
        } else {
            $purpose = 'PCA02';
        }
        
        if($this->input->post('CHR_CIP') != '' || $this->input->post('CHR_CIP') != NULL){
            $cip = $this->input->post('CHR_CIP');
        } else {
            $cip = '0';
        }
        
        $desc = $this->input->post('CHR_DESC');
        $notes = $this->input->post('CHR_NOTES');
        
        $get_costcenter = $this->purposebudget_m->get_costcenter($sect);
        $userid = $get_costcenter->CHR_USERID;
        $costcenter = $get_costcenter->CHR_USERID;
                
        //Detail req amount per month
        $req_amo04 = str_replace('.', '', $this->input->post('REQ_BGT_LIMBLN04'));
        $req_amo05 = str_replace('.', '', $this->input->post('REQ_BGT_LIMBLN05'));
        $req_amo06 = str_replace('.', '', $this->input->post('REQ_BGT_LIMBLN06'));
        $req_amo07 = str_replace('.', '', $this->input->post('REQ_BGT_LIMBLN07'));
        $req_amo08 = str_replace('.', '', $this->input->post('REQ_BGT_LIMBLN08'));
        $req_amo09 = str_replace('.', '', $this->input->post('REQ_BGT_LIMBLN09'));
        $req_amo10 = str_replace('.', '', $this->input->post('REQ_BGT_LIMBLN10'));
        $req_amo11 = str_replace('.', '', $this->input->post('REQ_BGT_LIMBLN11'));
        $req_amo12 = str_replace('.', '', $this->input->post('REQ_BGT_LIMBLN12'));
        $req_amo13 = str_replace('.', '', $this->input->post('REQ_BGT_LIMBLN13'));
        $req_amo14 = str_replace('.', '', $this->input->post('REQ_BGT_LIMBLN14'));
        $req_amo15 = str_replace('.', '', $this->input->post('REQ_BGT_LIMBLN15'));
        $req_tot_amo = str_replace('.', '', $this->input->post('REQ_TOT_AMO'));
        
        //Detail req qty per month
        $req_qty04 = $this->input->post('REQ_QTY_LIMBLN04');
        $req_qty05 = $this->input->post('REQ_QTY_LIMBLN05');
        $req_qty06 = $this->input->post('REQ_QTY_LIMBLN06');
        $req_qty07 = $this->input->post('REQ_QTY_LIMBLN07');
        $req_qty08 = $this->input->post('REQ_QTY_LIMBLN08');
        $req_qty09 = $this->input->post('REQ_QTY_LIMBLN09');
        $req_qty10 = $this->input->post('REQ_QTY_LIMBLN10');
        $req_qty11 = $this->input->post('REQ_QTY_LIMBLN11');
        $req_qty12 = $this->input->post('REQ_QTY_LIMBLN12');
        $req_qty13 = $this->input->post('REQ_QTY_LIMBLN13');
        $req_qty14 = $this->input->post('REQ_QTY_LIMBLN14');
        $req_qty15 = $this->input->post('REQ_QTY_LIMBLN15');
        $req_tot_qty = $this->input->post('REQ_TOT_QTY');
                
        $get_no_revisi = $this->purposebudget_m->get_no_revisi($budget_no);
        if($get_no_revisi == NULL){
            $no_revisi = 1;
        } else {
            $no_revisi = $get_no_revisi->INT_NO_REVISI + 1;
        }
        
        
//----------- IF YEAR ACTUAL DINAMIC DEPEND REQUEST --------------------------//
      if($budget_type == "CAPEX"){
            $act_month = 0;
            for($m = 4; $m < 16; $m++){
                $mon = sprintf("%02d", $m);
                if($this->input->post('REQ_BGT_LIMBLN'.$mon) > 0){
                    $act_month = $m;
                }
            } 
            
            if($act_month > 12){
                $year_act = $fiscal_end;
            } else {
                $year_act = $fiscal_start;
            }
      }
//----------------------------------------------------------------------------//
         
        $bgt_aii->trans_start();
        
        if($budget_type == "CAPEX"){
            if($year_act == $fiscal_start){
                $unbudget_cpx = array(
                            'CHR_USER' => $userid,
                            'CHR_TAHUN_BUDGET' => $fiscal_start,
                            'CHR_TAHUN_ACTUAL' => $year_act,                    
                            'CHR_NO_BUDGET' => $budget_no,
                            'CHR_KODE_DEPARTMENT' => $dept,
                            'CHR_KODE_TYPE_BUDGET' => $budget_type,
                            'CHR_KODE_GROUP' => $kode_group,
                            'CHR_KODE_SECTION' => $sect,
                            'CHR_KODE_COSTCENTER' => $costcenter,
                            'CHR_KODE_SUBCATEGORY_BUDGET' => $category,
                            'CHR_DESC_BUDGET' => $desc,
                            'CHR_KODE_PURPOSE_BUDGET' => $purpose,
                            'MON_LIMBLN04' => $req_amo04,
                            'MON_LIMBLN05' => $req_amo05,
                            'MON_LIMBLN06' => $req_amo06,
                            'MON_LIMBLN07' => $req_amo07,
                            'MON_LIMBLN08' => $req_amo08, 
                            'MON_LIMBLN09' => $req_amo09,
                            'MON_LIMBLN10' => $req_amo10,
                            'MON_LIMBLN11' => $req_amo11,
                            'MON_LIMBLN12' => $req_amo12,
                            'CHR_DESC_PROJECT' => $project,
                            'CHR_FLG_PROJECT' => $status,
                            'CHR_FLG_CIP' => $cip,
                            'CHR_FLG_DELETE' => 0,
                            'CHR_FLG_CANCEL' => 0,
                            'CHR_FLG_IF_SAP' => 0,
                            'CHR_FLG_USED' => 0,
                            'CHR_FLG_UNBUDGET' => 1,
                            'CHR_FLG_APPROVAL_PROCESS' => 1                
                );
                $this->purposebudget_m->save_propose_unbudget($unbudget_cpx, $budget_type);
                
                $capex_rev = array(
                            'INT_NO_REVISI' => 1,
                            'CHR_TGL_TRANS' => $trans_date,                    
                            'CHR_TAHUN_BUDGET' => $fiscal_start,
                            'CHR_TAHUN_ACTUAL' => $year_act,                    
                            'CHR_NO_BUDGET' => $budget_no,
                            'CHR_KODE_TYPE_BUDGET' => $budget_type,
                            'MON_LIMBLN04' => $req_amo04,
                            'MON_LIMBLN05' => $req_amo05,
                            'MON_LIMBLN06' => $req_amo06,
                            'MON_LIMBLN07' => $req_amo07,
                            'MON_LIMBLN08' => $req_amo08, 
                            'MON_LIMBLN09' => $req_amo09,
                            'MON_LIMBLN10' => $req_amo10,
                            'MON_LIMBLN11' => $req_amo11,
                            'MON_LIMBLN12' => $req_amo12,
                            'CHR_FLG_SWITCH' => 0,
                            'CHR_FLG_NOTES' => $notes
                );                
                $this->purposebudget_m->save_revision_budget($capex_rev); 
            } else {
                $unbudget_cpx = array(
                            'CHR_USER' => $userid,
                            'CHR_TAHUN_BUDGET' => $fiscal_start,
                            'CHR_TAHUN_ACTUAL' => $year_act,                    
                            'CHR_NO_BUDGET' => $budget_no,
                            'CHR_KODE_DEPARTMENT' => $dept,
                            'CHR_KODE_TYPE_BUDGET' => $budget_type,
                            'CHR_KODE_GROUP' => $kode_group,
                            'CHR_KODE_SECTION' => $sect,
                            'CHR_KODE_COSTCENTER' => $costcenter,
                            'CHR_KODE_SUBCATEGORY_BUDGET' => $category,
                            'CHR_DESC_BUDGET' => $desc,
                            'CHR_KODE_PURPOSE_BUDGET' => $purpose,
                            'MON_LIMBLN01' => $req_amo13,
                            'MON_LIMBLN02' => $req_amo14,
                            'MON_LIMBLN03' => $req_amo15,
                            'CHR_DESC_PROJECT' => $project,
                            'CHR_FLG_PROJECT' => $status,
                            'CHR_FLG_CIP' => $cip,
                            'CHR_FLG_DELETE' => 0,
                            'CHR_FLG_CANCEL' => 0,
                            'CHR_FLG_IF_SAP' => 0,
                            'CHR_FLG_USED' => 0,
                            'CHR_FLG_UNBUDGET' => 1,
                            'CHR_FLG_APPROVAL_PROCESS' => 1                
                );
                $this->purposebudget_m->save_propose_unbudget($unbudget_cpx, $budget_type);
                
                $capex_rev = array(
                            'INT_NO_REVISI' => 1,
                            'CHR_TGL_TRANS' => $trans_date,                    
                            'CHR_TAHUN_BUDGET' => $fiscal_start,
                            'CHR_TAHUN_ACTUAL' => $year_act,                    
                            'CHR_NO_BUDGET' => $budget_no,
                            'CHR_KODE_TYPE_BUDGET' => $budget_type,
                            'MON_LIMBLN01' => $req_amo13,
                            'MON_LIMBLN02' => $req_amo14,
                            'MON_LIMBLN03' => $req_amo15,                            
                            'CHR_FLG_SWITCH' => 0,
                            'CHR_FLG_NOTES' => $notes
                        );
                $this->purposebudget_m->save_revision_budget($capex_rev);                
            }
        } else {
            $unbudget_exp_start = array(
                            'CHR_USER' => $userid,
                            'CHR_TAHUN_BUDGET' => $fiscal_start,
                            'CHR_TAHUN_ACTUAL' => $fiscal_start,                    
                            'CHR_NO_BUDGET' => $budget_no,
                            'CHR_KODE_DEPARTMENT' => $dept,
                            'CHR_KODE_TYPE_BUDGET' => $budget_type,
                            'CHR_KODE_GROUP' => $kode_group,
                            'CHR_KODE_SECTION' => $sect,
                            'CHR_KODE_COSTCENTER' => $costcenter,
                            'CHR_KODE_CATEGORY_BUDGET' => '-',
                            'CHR_KODE_SUBCATEGORY_BUDGET' => $category,
                            'CHR_KODE_ITEM' => $desc,
                            'CHR_DESC_PROJECT' => $project,
                            'CHR_FLG_PROJECT' => $status,
                            'MON_LIMBLN04' => $req_amo04,
                            'MON_LIMBLN05' => $req_amo05,
                            'MON_LIMBLN06' => $req_amo06,
                            'MON_LIMBLN07' => $req_amo07,
                            'MON_LIMBLN08' => $req_amo08, 
                            'MON_LIMBLN09' => $req_amo09,
                            'MON_LIMBLN10' => $req_amo10,
                            'MON_LIMBLN11' => $req_amo11,
                            'MON_LIMBLN12' => $req_amo12,                            
                            'INT_QTY_LIMBLN04' => $req_qty04,
                            'INT_QTY_LIMBLN05' => $req_qty05,
                            'INT_QTY_LIMBLN06' => $req_qty06,
                            'INT_QTY_LIMBLN07' => $req_qty07,
                            'INT_QTY_LIMBLN08' => $req_qty08,
                            'INT_QTY_LIMBLN09' => $req_qty09,
                            'INT_QTY_LIMBLN10' => $req_qty10,
                            'INT_QTY_LIMBLN11' => $req_qty11,
                            'INT_QTY_LIMBLN12' => $req_qty12,
                            'CHR_ALOKASI' => '-',
                            'CHR_FLG_DELETE' => 0,
                            'CHR_FLG_CANCEL' => 0,
                            'CHR_FLG_IF_SAP' => 0,
                            'CHR_FLG_UNBUDGET' => 1,
                            'CHR_FLG_APPROVAL_PROCESS' => 1
                        );
            $this->purposebudget_m->save_propose_unbudget($unbudget_exp_start, $budget_type);
            
            $unbudget_exp_end = array(
                            'CHR_USER' => $userid,
                            'CHR_TAHUN_BUDGET' => $fiscal_start,
                            'CHR_TAHUN_ACTUAL' => $fiscal_end,                    
                            'CHR_NO_BUDGET' => $budget_no,
                            'CHR_KODE_DEPARTMENT' => $dept,
                            'CHR_KODE_TYPE_BUDGET' => $budget_type,
                            'CHR_KODE_GROUP' => $kode_group,
                            'CHR_KODE_SECTION' => $sect,
                            'CHR_KODE_COSTCENTER' => $costcenter,
                            'CHR_KODE_CATEGORY_BUDGET' => '-',
                            'CHR_KODE_SUBCATEGORY_BUDGET' => $category,
                            'CHR_KODE_ITEM' => $desc,
                            'CHR_DESC_PROJECT' => $project,
                            'CHR_FLG_PROJECT' => $status,
                            'MON_LIMBLN01' => $req_amo13,
                            'MON_LIMBLN02' => $req_amo14,
                            'MON_LIMBLN03' => $req_amo15,                                                   
                            'INT_QTY_LIMBLN01' => $req_qty13,
                            'INT_QTY_LIMBLN02' => $req_qty14,
                            'INT_QTY_LIMBLN03' => $req_qty15,                            
                            'CHR_ALOKASI' => '-',
                            'CHR_FLG_DELETE' => 0,
                            'CHR_FLG_CANCEL' => 0,
                            'CHR_FLG_IF_SAP' => 0,
                            'CHR_FLG_UNBUDGET' => 1,
                            'CHR_FLG_APPROVAL_PROCESS' => 1
                        );
            $this->purposebudget_m->save_propose_unbudget($unbudget_exp_end, $budget_type);
            
            $exp_rev_start = array(
                            'INT_NO_REVISI' => 1,
                            'CHR_TGL_TRANS' => $trans_date,                    
                            'CHR_TAHUN_BUDGET' => $fiscal_start,
                            'CHR_TAHUN_ACTUAL' => $fiscal_start,                    
                            'CHR_NO_BUDGET' => $budget_no,
                            'CHR_KODE_TYPE_BUDGET' => $budget_type,
                            'MON_LIMBLN04' => $req_amo04,
                            'MON_LIMBLN05' => $req_amo05,
                            'MON_LIMBLN06' => $req_amo06,
                            'MON_LIMBLN07' => $req_amo07,
                            'MON_LIMBLN08' => $req_amo08, 
                            'MON_LIMBLN09' => $req_amo09,
                            'MON_LIMBLN10' => $req_amo10,
                            'MON_LIMBLN11' => $req_amo11,
                            'MON_LIMBLN12' => $req_amo12,                            
                            'INT_QTY_LIMBLN04' => $req_qty04,
                            'INT_QTY_LIMBLN05' => $req_qty05,
                            'INT_QTY_LIMBLN06' => $req_qty06,
                            'INT_QTY_LIMBLN07' => $req_qty07,
                            'INT_QTY_LIMBLN08' => $req_qty08,
                            'INT_QTY_LIMBLN09' => $req_qty09,
                            'INT_QTY_LIMBLN10' => $req_qty10,
                            'INT_QTY_LIMBLN11' => $req_qty11,
                            'INT_QTY_LIMBLN12' => $req_qty12,                            
                            'CHR_FLG_SWITCH' => 0,
                            'CHR_FLG_NOTES' => $notes
                        );
            $this->purposebudget_m->save_revision_budget($exp_rev_start); 
            
            $exp_rev_end = array(
                            'INT_NO_REVISI' => 1,
                            'CHR_TGL_TRANS' => $trans_date,                    
                            'CHR_TAHUN_BUDGET' => $fiscal_start,
                            'CHR_TAHUN_ACTUAL' => $fiscal_end,                    
                            'CHR_NO_BUDGET' => $budget_no,
                            'CHR_KODE_TYPE_BUDGET' => $budget_type,
                            'MON_LIMBLN01' => $req_amo13,
                            'MON_LIMBLN02' => $req_amo14,
                            'MON_LIMBLN03' => $req_amo15,                                                       
                            'INT_QTY_LIMBLN01' => $req_qty13,
                            'INT_QTY_LIMBLN02' => $req_qty14,
                            'INT_QTY_LIMBLN03' => $req_qty15,                                                       
                            'CHR_FLG_SWITCH' => 0,
                            'CHR_FLG_NOTES' => $notes
                        );
            $this->purposebudget_m->save_revision_budget($exp_rev_end); 
        }       
               
        $bgt_aii->trans_complete();
        
        if ($bgt_aii->trans_status() === FALSE)
        {
            $bgt_aii->trans_rollback();
            redirect("budget/purposebudget_c/propose_budget_revision/2/".$fiscal_start."/".$budget_type);
        }
        else
        {
            $bgt_aii->trans_commit();
            redirect("budget/purposebudget_c/propose_budget_revision/1/".$fiscal_start."/".$budget_type);
        }
        
        print_r($year_act);
        exit();
    }

}

?>