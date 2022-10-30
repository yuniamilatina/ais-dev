
<?php

class report_budget_c extends CI_Controller {

    private $layout = '/template/head';
    private $back_to_manage = 'budget/report_capex_c/index/';

    public function __construct() {
        parent::__construct();
        //$this->load->model('basis/log_m');
        //$this->load->model('basis/role_module_m');
        $this->load->model('budget/fiscal_m');
        $this->load->model('organization/division_m');
        $this->load->model('organization/groupdept_m');
        $this->load->model('organization/dept_m');
        $this->load->model('organization/section_m');
        $this->load->model('budget/budgetgroup_m');
        $this->load->model('budget/purchase_request_m');
        $this->load->model('budget/budgetsubgroup_m');
        $this->load->model('budget/budgettype_m');
        $this->load->model('budget/budgetcategory_m');
        $this->load->model('budget/budgetsubcategory_m');
        $this->load->model('budget/report_budget_m');
        //$this->load->model('portal/news_m');
    }

    function index($fiscal_start = NULL, $bgt_type = NULL, $kode_dept = NULL, $kode_sect = NULL) {
        $this->role_module_m->authorization('29');

        $get_fiscal = $this->fiscal_m->get_default_fiscal_year();
        if($fiscal_start == NULL){            
            $fiscal_start = $get_fiscal->CHR_FISCAL_YEAR_START;
            $fiscal_end = $get_fiscal->CHR_FISCAL_YEAR_END;
        } else {
            $fiscal_end = $fiscal_start + 1;
        }
        
        
        $act_periode = date("Ym");
        $periode_smt2 = $fiscal_start . '10';
        
        $session = $this->session->all_userdata();
        if ($session['ROLE'] === 2 || $session['ROLE'] === 1 || $session['ROLE'] === 13 || $session['NPK'] === '0483' || $session['NPK'] === '0483a' || $session['NPK'] === '7520' || $session['NPK'] === '1582' || $session['NPK'] === '3394' || $session['NPK'] === '9692' || $session['NPK'] === '1392' || $session['NPK'] === '0799' || $session['NPK'] === '1733' || $session['NPK'] === '5913') {
            
            $id_dept = $this->session->userdata('DEPT');
            if($kode_dept == NULL){
                $kode_dept = $this->report_budget_m->get_user_dept($id_dept)->CHR_DEPT;
                $kode_group = $this->session->userdata('GROUPDEPT');
            } else {
                $kode_group = $this->dept_m->get_groupdept_by_dept($id_dept);
            }
            
            if($kode_group == '7'){
                $kode_group = '003';
            } else if($kode_group == '6') {
                $kode_group = '001';
            } else if($kode_group == '10') {
                $kode_group = '004';
            }
            
            if($kode_dept == 'PC'){
                $kode_dept = 'KQC';
            } else {
                $kode_dept = trim($kode_dept);
            }
            
            if($kode_sect == 'ALL' || $kode_sect == NULL){
                $kode_sect = '';
            }
            
            $data['list_dept'] = $this->report_budget_m->get_all_dept();
            $data['list_sect'] = $this->report_budget_m->get_all_sect($fiscal_start, $bgt_type, $kode_dept);
            $data['data_report_man'] = $this->report_budget_m->get_report_budget_man($fiscal_start, $fiscal_end, $bgt_type, $kode_dept, $kode_sect);
            $data['report_per_sect'] = $this->report_budget_m->get_report_budget_per_sect($fiscal_start, $fiscal_end, $bgt_type, $kode_dept, $kode_sect);
            $data['list_data_smt1'] = $this->report_budget_m->get_report_budget_smt1($fiscal_start, $fiscal_end, $bgt_type, $kode_dept, $kode_sect);
            $data_contain = $this->report_budget_m->get_report_budget($fiscal_start, $fiscal_end, $bgt_type, $kode_dept, $kode_sect);
 
            //===== DETAIL PER DEPT =====//
            $data['detail_budget'] = $this->purchase_request_m->get_new_budget_detail($fiscal_start, $fiscal_start, $fiscal_end, $bgt_type, $kode_dept);
            $data['revisi_budget'] = $this->purchase_request_m->get_new_budget_detail_rev($fiscal_start, $fiscal_start, $fiscal_end, $bgt_type, $kode_dept);
            $data['limit_budget'] = $this->purchase_request_m->get_new_budget_limit($fiscal_start, $fiscal_start, $fiscal_end, $bgt_type, $kode_dept, $act_periode, $periode_smt2);
            $data['actual_real'] = $this->purchase_request_m->get_new_actual_real($fiscal_start, $fiscal_start, $fiscal_end, $bgt_type, $kode_dept, $act_periode, $periode_smt2);
            $list_actual_gr = array();
            for ($no = 1; $no <= 12; $no++){
                if (($no + 3) <= 12){
                    $start_date = $fiscal_start . sprintf("%02d", $no+3) . '01';
                    $end_date = $fiscal_start . sprintf("%02d", $no+3) . '31';
                    
                    $actual_gr = $this->purchase_request_m->get_new_actual_gr($start_date, $end_date, $bgt_type, $kode_dept);
                    
                    array_push($list_actual_gr, $actual_gr->TOTAL);                    
                } else {
                    $start_date = $fiscal_end . sprintf("%02d", $no-9) . '01';
                    $end_date = $fiscal_end . sprintf("%02d", $no-9) . '31';
                    
                    $actual_gr = $this->purchase_request_m->get_new_actual_gr($start_date, $end_date, $bgt_type, $kode_dept);
                   
                    array_push($list_actual_gr, $actual_gr->TOTAL);                    
                }
            }
            
            $data['actual_gr'] = $list_actual_gr;

            //===== DETAIL GROUP =====//
            $data['detail_budget_group'] = $this->purchase_request_m->get_new_budget_detail_gm($fiscal_start, $fiscal_start, $fiscal_end, $bgt_type, $kode_group);
            $data['revisi_budget_group'] = $this->purchase_request_m->get_new_budget_detail_rev_gm($fiscal_start, $fiscal_start, $fiscal_end, $bgt_type, $kode_group);
            $data['limit_budget_group'] = $this->purchase_request_m->get_new_budget_limit_gm($fiscal_start, $fiscal_start, $fiscal_end, $bgt_type, $kode_group, $act_periode, $periode_smt2);
            $data['actual_real_group'] = $this->purchase_request_m->get_new_actual_real_gm($fiscal_start, $fiscal_start, $fiscal_end, $bgt_type, $kode_group, $act_periode, $periode_smt2);
            $list_actual_gr_group = array();
            for ($no = 1; $no <= 12; $no++){
                if (($no + 3) <= 12){
                    $start_date = $fiscal_start . sprintf("%02d", $no+3) . '01';
                    $end_date = $fiscal_start . sprintf("%02d", $no+3) . '31';
                    
                    $actual_gr_group = $this->purchase_request_m->get_new_actual_gr_gm($start_date, $end_date, $bgt_type, $kode_dept, $kode_group);
                    
                    array_push($list_actual_gr_group, $actual_gr_group->TOTAL);                    
                } else {
                    $start_date = $fiscal_end . sprintf("%02d", $no-9) . '01';
                    $end_date = $fiscal_end . sprintf("%02d", $no-9) . '31';
                    
                    $actual_gr = $this->purchase_request_m->get_new_actual_gr_gm($start_date, $end_date, $bgt_type, $kode_dept, $kode_group);
                   
                    array_push($list_actual_gr_group, $actual_gr_group->TOTAL);                    
                }
            }
            
            $data['actual_gr_group'] = $list_actual_gr_group;
            
            //$summary_budget = $this->report_budget_m->get_summary_budget_type($fiscal_start, $fiscal_end, $kode_dept, $bgt_type);
           
            $contain = 'budget/report_budget/report_budget_v';
        } else if ($session['ROLE'] === 5 || $session['ROLE'] === 39 || $session['ROLE'] === 45 || $session['ROLE'] === 61 || $session['ROLE'] === 10) {
            $kode_group = $this->session->userdata('GROUPDEPT');
            $id_dept = $this->session->userdata('DEPT');
            $kode_dept = $this->report_budget_m->get_user_dept($id_dept)->CHR_DEPT;
            
            if($kode_dept == 'PC'){
                $kode_dept = 'KQC';
            } else {
                $kode_dept = trim($kode_dept);
            }
            
            if($kode_sect == 'ALL' || $kode_sect == NULL){
                $kode_sect = '';
            }
            
            $data['list_dept'] = $this->report_budget_m->get_all_dept();
            $data['list_sect'] = $this->report_budget_m->get_all_sect($fiscal_start, $bgt_type, $kode_dept);
            $data['data_report_man'] = $this->report_budget_m->get_report_budget_man($fiscal_start, $fiscal_end, $bgt_type, $kode_dept, $kode_sect);
            $data['report_per_sect'] = $this->report_budget_m->get_report_budget_per_sect($fiscal_start, $fiscal_end, $bgt_type, $kode_dept, $kode_sect);
            $data['list_data_smt1'] = $this->report_budget_m->get_report_budget_smt1($fiscal_start, $fiscal_end, $bgt_type, $kode_dept, $kode_sect);
            $data_contain = $this->report_budget_m->get_report_budget($fiscal_start, $fiscal_end, $bgt_type, $kode_dept, $kode_sect);

            $data['detail_budget'] = $this->purchase_request_m->get_new_budget_detail($fiscal_start, $fiscal_start, $fiscal_end, $bgt_type, $kode_dept);
            $data['revisi_budget'] = $this->purchase_request_m->get_new_budget_detail_rev($fiscal_start, $fiscal_start, $fiscal_end, $bgt_type, $kode_dept);
            $data['limit_budget'] = $this->purchase_request_m->get_new_budget_limit($fiscal_start, $fiscal_start, $fiscal_end, $bgt_type, $kode_dept, $act_periode, $periode_smt2);
            $data['actual_real'] = $this->purchase_request_m->get_new_actual_real($fiscal_start, $fiscal_start, $fiscal_end, $bgt_type, $kode_dept, $act_periode, $periode_smt2);
            $list_actual_gr = array();
            for ($no = 1; $no <= 12; $no++){
                if (($no + 3) <= 12){
                    $start_date = $fiscal_start . sprintf("%02d", $no+3) . '01';
                    $end_date = $fiscal_start . sprintf("%02d", $no+3) . '31';
                    
                    $actual_gr = $this->purchase_request_m->get_new_actual_gr($start_date, $end_date, $bgt_type, $kode_dept);
                    
                    array_push($list_actual_gr, $actual_gr->TOTAL);                    
                } else {
                    $start_date = $fiscal_end . sprintf("%02d", $no-9) . '01';
                    $end_date = $fiscal_end . sprintf("%02d", $no-9) . '31';
                    
                    $actual_gr = $this->purchase_request_m->get_new_actual_gr($start_date, $end_date, $bgt_type, $kode_dept);
                   
                    array_push($list_actual_gr, $actual_gr->TOTAL);                    
                }
            }
            
            $data['actual_gr'] = $list_actual_gr;
            
            //$summary_budget = $this->report_budget_m->get_summary_budget_type($fiscal_start, $fiscal_end, $kode_dept, $bgt_type);
            
            $contain = 'budget/report_budget/report_budget_v';
        } else { //if ($session['ROLE'] === 6 || $session['ROLE'] === 18 || $session['ROLE'] === 30) { //report_budget_c
            $kode_group = $this->session->userdata('GROUPDEPT');
            $id_dept = $this->session->userdata('DEPT');
            $kode_dept = $this->report_budget_m->get_user_dept($id_dept)->CHR_DEPT;
            
            if($kode_dept == 'PC'){
                $kode_dept = 'KQC';
            } else {
                $kode_dept = trim($kode_dept);
            }
            
            if($kode_sect == 'ALL' || $kode_sect == NULL){
                $kode_sect = '';
            }
            
            $data['list_dept'] = $this->report_budget_m->get_all_dept();
            $data['list_sect'] = $this->report_budget_m->get_all_sect($fiscal_start, $bgt_type, $kode_dept);
            $data['data_report_man'] = $this->report_budget_m->get_report_budget_man($fiscal_start, $fiscal_end, $bgt_type, $kode_dept, $kode_sect);
            $data['report_per_sect'] = $this->report_budget_m->get_report_budget_per_sect($fiscal_start, $fiscal_end, $bgt_type, $kode_dept, $kode_sect);
            $data['list_data_smt1'] = $this->report_budget_m->get_report_budget_smt1($fiscal_start, $fiscal_end, $bgt_type, $kode_dept, $kode_sect);
            $data_contain = $this->report_budget_m->get_report_budget($fiscal_start, $fiscal_end, $bgt_type, $kode_dept, $kode_sect);
            //$summary_budget = $this->report_budget_m->get_summary_budget_type($fiscal_start, $fiscal_end, $kode_dept, $bgt_type);

            $data['detail_budget'] = $this->purchase_request_m->get_new_budget_detail($fiscal_start, $fiscal_start, $fiscal_end, $bgt_type, $kode_dept);
            $data['revisi_budget'] = $this->purchase_request_m->get_new_budget_detail_rev($fiscal_start, $fiscal_start, $fiscal_end, $bgt_type, $kode_dept);
            $data['limit_budget'] = $this->purchase_request_m->get_new_budget_limit($fiscal_start, $fiscal_start, $fiscal_end, $bgt_type, $kode_dept, $act_periode, $periode_smt2);
            $data['actual_real'] = $this->purchase_request_m->get_new_actual_real($fiscal_start, $fiscal_start, $fiscal_end, $bgt_type, $kode_dept, $act_periode, $periode_smt2);
            $list_actual_gr = array();
            for ($no = 1; $no <= 12; $no++){
                if (($no + 3) <= 12){
                    $start_date = $fiscal_start . sprintf("%02d", $no+3) . '01';
                    $end_date = $fiscal_start . sprintf("%02d", $no+3) . '31';
                    
                    $actual_gr = $this->purchase_request_m->get_new_actual_gr($start_date, $end_date, $bgt_type, $kode_dept);
                    
                    array_push($list_actual_gr, $actual_gr->TOTAL);                    
                } else {
                    $start_date = $fiscal_end . sprintf("%02d", $no-9) . '01';
                    $end_date = $fiscal_end . sprintf("%02d", $no-9) . '31';
                    
                    $actual_gr = $this->purchase_request_m->get_new_actual_gr($start_date, $end_date, $bgt_type, $kode_dept);
                   
                    array_push($list_actual_gr, $actual_gr->TOTAL);                    
                }
            }
            
            $data['actual_gr'] = $list_actual_gr;
            
            $contain = 'budget/report_budget/report_budget_v';
        }

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(198);
        $data['news'] = $this->news_m->get_news();
        $data['role'] = $session['ROLE'];
        $data['npk'] = $session['NPK'];
        
        //send single data
        $data['fiscal_start'] = $fiscal_start;
        $data['fiscal_end'] = $fiscal_end;
        $data['act_periode'] = $act_periode;
        $data['periode_smt2'] = $periode_smt2;
        $data['bgt_type'] = $bgt_type;
        $data['kode_group'] = $kode_group;
        $data['kode_dept'] = $kode_dept;
        $data['kode_sect'] = $kode_sect;
        
        //send list data
        $data['data_fiscal'] = $this->fiscal_m->get_all_fiscal_year();
        $data['list_budget_type'] = $this->report_budget_m->get_budget_type();        
        
        $data['list_data'] = $data_contain;
        //$data['summary_data'] = $summary_budget;
        
        $data['content'] = $contain;
        $data['title'] = 'Manage Budget Planning';

        $this->load->view($this->layout, $data);
    }
    
    function report_budget_for_bod($fiscal_start = NULL, $bgt_type = NULL, $kode_group = NULL) {
        $get_fiscal = $this->fiscal_m->get_default_fiscal_year();

        if($fiscal_start == NULL){
            $fiscal_start = $get_fiscal->CHR_FISCAL_YEAR_START;
            $fiscal_end = $get_fiscal->CHR_FISCAL_YEAR_END;
        } else {
            $fiscal_end = $fiscal_start + 1;
        }
        
        
        $act_periode = date("Ym");
        $periode_smt2 = $fiscal_start . '10';
        
        $session = $this->session->all_userdata();
        
        $kode_div = '001';
        if($kode_group == 'ALL'){
            $kode_group = '';
        }
        
        $kode_dept = '';

        $data['list_group'] = $this->report_budget_m->get_all_group();
        $data['data_report_bod'] = $this->report_budget_m->get_report_budget_bod($fiscal_start, $fiscal_end, $bgt_type, $kode_div, $kode_group);
        $data['data_report_gm'] = $this->report_budget_m->get_report_budget_gm($fiscal_start, $fiscal_end, $bgt_type, $kode_group, $kode_dept);
        $data['report_per_group'] = $this->report_budget_m->get_report_budget_per_group($fiscal_start, $fiscal_end, $bgt_type, $kode_group);
        $data_contain = $this->report_budget_m->get_report_budget_per_dept($fiscal_start, $fiscal_end, $bgt_type, $kode_group, $kode_dept);

        $contain = 'budget/report_budget/report_budget_bod_v';

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(201);
        $data['news'] = $this->news_m->get_news();
        $data['role'] = $session['ROLE'];
        
        //send single data
        $data['fiscal_start'] = $fiscal_start;
        $data['fiscal_end'] = $fiscal_end;
        $data['act_periode'] = $act_periode;
        $data['periode_smt2'] = $periode_smt2;
        $data['bgt_type'] = $bgt_type;
        $data['kode_group'] = $kode_group;
        
        //send list data
        $data['data_fiscal'] = $this->fiscal_m->get_all_fiscal_year();
        $data['list_budget_type'] = $this->report_budget_m->get_budget_type();        
        
        $data['list_data'] = $data_contain;        
        $data['content'] = $contain;
        $data['title'] = 'Manage Budget Planning';

        $this->load->view($this->layout, $data);
    }
    
    function report_budget_for_gm($fiscal_start = NULL, $bgt_type = NULL, $kode_group = NULL, $kode_dept = NULL) {
        $get_fiscal = $this->fiscal_m->get_default_fiscal_year();
        
        if($fiscal_start == NULL) {
            $fiscal_start = $get_fiscal->CHR_FISCAL_YEAR_START;
            $fiscal_end = $get_fiscal->CHR_FISCAL_YEAR_END;
        } else {
            $fiscal_end = $fiscal_start + 1;
        }
        
        
        $act_periode = date("Ym");
        $periode_smt2 = $fiscal_start . '10';
        
        $session = $this->session->all_userdata();
        
        if($session['ROLE'] == 1 || $session['ROLE'] == 2){
            if($kode_group == NULL){
                $kode_group = $this->session->userdata('GROUPDEPT');
            } else if($kode_group == 'ALL'){
                $kode_group = '';
            }
        } else if($session['ROLE'] == 4) {
            $kode_group = $this->session->userdata('GROUPDEPT');
            if($kode_group == '6'){
                $kode_group = '001';
            } else if($kode_group == '7') {
                $kode_group = '003';
            } else if($kode_group == '10') {
                $kode_group = '004';
            }
        }        

        if ($kode_dept == 'PC' || $kode_dept == 'PCO'){
            $kode_dept = 'KQC';
        } else {
            $kode_dept = trim($kode_dept);
        }
        
        $kode_sect = '';

        $data['list_group'] = $this->report_budget_m->get_all_group();
        $data['list_dept'] = $this->report_budget_m->get_group_dept($kode_group);
        $data['data_report_gm'] = $this->report_budget_m->get_report_budget_gm($fiscal_start, $fiscal_end, $bgt_type, $kode_group, $kode_dept);
        $data['data_report_man'] = $this->report_budget_m->get_report_budget_man($fiscal_start, $fiscal_end, $bgt_type, $kode_dept, $kode_sect);
        $data['report_per_dept'] = $this->report_budget_m->get_report_budget_per_dept($fiscal_start, $fiscal_end, $bgt_type, $kode_group, $kode_dept);
        $data['report_per_sect'] = $this->report_budget_m->get_report_budget_per_sect($fiscal_start, $fiscal_end, $bgt_type, $kode_dept, $kode_sect);
        $data_contain = $this->report_budget_m->get_report_budget($fiscal_start, $fiscal_end, $bgt_type, $kode_dept, $kode_sect);

        $contain = 'budget/report_budget/report_budget_gm_v';

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(202);
        $data['news'] = $this->news_m->get_news();
        $data['role'] = $session['ROLE'];
        
        //send single data
        $data['fiscal_start'] = $fiscal_start;
        $data['fiscal_end'] = $fiscal_end;
        $data['act_periode'] = $act_periode;
        $data['periode_smt2'] = $periode_smt2;
        $data['bgt_type'] = $bgt_type;
        $data['kode_group'] = $kode_group;
        $data['kode_dept'] = $kode_dept;
        
        //send list data
        $data['data_fiscal'] = $this->fiscal_m->get_all_fiscal_year();
        $data['list_budget_type'] = $this->report_budget_m->get_budget_type();        
        
        $data['list_data'] = $data_contain;        
        $data['content'] = $contain;
        $data['title'] = 'Manage Budget Planning';

        $this->load->view($this->layout, $data);
    }
    
    function report_usage_budget($fiscal_start = NULL, $bgt_type = NULL, $kode_dept = NULL, $kode_sect = NULL) {
        $this->role_module_m->authorization('29');

        $get_fiscal = $this->fiscal_m->get_default_fiscal_year();
        if($fiscal_start == NULL){
            $fiscal_start = $get_fiscal->CHR_FISCAL_YEAR_START;
            $fiscal_end = $get_fiscal->CHR_FISCAL_YEAR_END;
        } else {
            $fiscal_end = $fiscal_start + 1;
        }                
        
        $session = $this->session->all_userdata();
        if ($session['ROLE'] === 2 || $session['ROLE'] === 1 || $session['ROLE'] === 13 ||  $session['NPK'] === '0483a' || $session['NPK'] === '0483' || $session['NPK'] === '7520' || $session['NPK'] === '1582'  || $session['NPK'] === '3394' || $session['NPK'] === '9692' || $session['NPK'] === '3333') {
            
            if($kode_dept == 'PC' || $kode_dept == 'PCO'){
                $kode_dept = 'KQC';
            } else {
                $kode_dept = trim($kode_dept);
            }           
            
            if($bgt_type == NULL){
                $bgt_type = 'CAPEX';
            }
            
            if($kode_sect == 'ALL'){
                $kode_sect = '';
            }            
            
        } else if ($session['ROLE'] === 5 || $session['ROLE'] === 39 || $session['ROLE'] === 45 || $session['ROLE'] === 61 || $session['ROLE'] === 6 || $session['ROLE'] === 10 || $session['ROLE'] === 27 || $session['ROLE'] === 40) {
            $id_dept = $this->session->userdata('DEPT');
            $kode_dept = $this->report_budget_m->get_user_dept($id_dept)->CHR_DEPT;
            
            if ($kode_dept == 'PC' || $kode_dept == 'PCO'){
                $kode_dept = 'KQC';
            } else {
                $kode_dept = trim($kode_dept);
            }           
            
            if($bgt_type == NULL){
                $bgt_type = 'CAPEX';
            }
            
            if($kode_sect == 'ALL'){
                $kode_sect = '';
            }
        } else {//if ($session['ROLE'] === 6 || $session['ROLE'] === 30) {
            $id_dept = $this->session->userdata('DEPT');
            $id_sect = $this->session->userdata('SECTION');
            $kode_dept = $this->report_budget_m->get_user_dept($id_dept)->CHR_DEPT;
            $kode_sect = trim($this->report_budget_m->get_user_sect($id_sect)->CHR_SECTION);
            
            if ($kode_dept == 'PC' || $kode_dept == 'PCO'){
                $kode_dept = 'KQC';
            } else {
                $kode_dept = trim($kode_dept);
            }            
            
            if($bgt_type == NULL){
                $bgt_type = 'CAPEX';
            }
        }

        $data['list_sect'] = $this->report_budget_m->get_all_sect($fiscal_start, $bgt_type, $kode_dept);    
        $data['list_pr_no'] = $this->report_budget_m->get_list_pr_no($fiscal_start, $bgt_type, $kode_dept, $kode_sect);  
        $data_contain = $this->report_budget_m->get_usage_budget($fiscal_start, $bgt_type, $kode_dept, $kode_sect);
           
        $contain = 'budget/report_budget/report_usage_budget_v';

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(200);
        $data['news'] = $this->news_m->get_news();
        $data['role'] = $session['ROLE'];
        $data['npk'] = $session['NPK'];
        
        //Send single data
        $data['fiscal_start'] = $fiscal_start;
        $data['fiscal_end'] = $fiscal_end;
        $data['bgt_type'] = $bgt_type;
        $data['kode_dept'] = $kode_dept;
        $data['kode_sect'] = $kode_sect;
        
        //Send list data
        $data['data_fiscal'] = $this->fiscal_m->get_all_fiscal_year();
        $data['list_budget_type'] = $this->report_budget_m->get_budget_type();
        $data['list_dept'] = $this->report_budget_m->get_all_dept();
        
        $data['list_data'] = $data_contain;
        
        $data['content'] = $contain;
        $data['title'] = 'Report Usage Budget';

        $this->load->view($this->layout, $data);
    }
    
    function export_report_summary_budget() {        
        $this->load->library('excel');
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        
        $fiscal_start = $this->input->post("CHR_FISCAL_EXP");
        $fiscal_end = $fiscal_start + 1;
        $kode_dept = $this->input->post("CHR_DEPT_EXP");
        $kode_sect = $this->input->post("CHR_SECT_EXP");
        $bgt_type = $this->input->post("CHR_BUDGET_TYPE_EXP");
        
        if($kode_sect == 'ALL'){
            $kode_sect = '';
        }
        
        $list_budget = $this->report_budget_m->get_report_budget($fiscal_start, $fiscal_end, $bgt_type, $kode_dept, $kode_sect);
//        print_r($list_budget);
//        exit();

        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

        // Set Properties
        $objPHPExcel->getProperties()->setCreator(trim($this->session->userdata('USERNAME')));
        $objPHPExcel->getProperties()->setLastModifiedBy(trim($this->session->userdata('USERNAME')));
        $objPHPExcel->getProperties()->setTitle("REKAP BUDGET");
        $objPHPExcel->getProperties()->setSubject("REKAP BUDGET");
        $objPHPExcel->getProperties()->setDescription("REKAP BUDGET");
                
        //Header TR
        $objPHPExcel->getActiveSheet()->setCellValue('A2', 'NO');        
        $objPHPExcel->getActiveSheet()->setCellValue('B2', 'TAHUN');
        $objPHPExcel->getActiveSheet()->setCellValue('C2', 'NO BUDGET');
        $objPHPExcel->getActiveSheet()->setCellValue('D2', 'DESCRIPTION');
        $objPHPExcel->getActiveSheet()->setCellValue('E2', 'DEPARTMENT');
        $objPHPExcel->getActiveSheet()->setCellValue('F2', 'BUDGET TYPE');
        $objPHPExcel->getActiveSheet()->setCellValue('G2', 'CATEGORY');
        $objPHPExcel->getActiveSheet()->setCellValue('H2', 'PROJECT');
        $objPHPExcel->getActiveSheet()->setCellValue('I2', 'APRIL '.$fiscal_start);
        $objPHPExcel->getActiveSheet()->setCellValue('N2', 'MEI '.$fiscal_start);
        $objPHPExcel->getActiveSheet()->setCellValue('S2', 'JUNI '.$fiscal_start);
        $objPHPExcel->getActiveSheet()->setCellValue('X2', 'JULI '.$fiscal_start);
        $objPHPExcel->getActiveSheet()->setCellValue('AC2', 'AGUSTUS '.$fiscal_start);
        $objPHPExcel->getActiveSheet()->setCellValue('AH2', 'SEPTEMBER '.$fiscal_start);
        $objPHPExcel->getActiveSheet()->setCellValue('AM2', 'OKTOBER '.$fiscal_start);
        $objPHPExcel->getActiveSheet()->setCellValue('AR2', 'NOVEMBER '.$fiscal_start);
        $objPHPExcel->getActiveSheet()->setCellValue('AW2', 'DESEMBER '.$fiscal_start);
        $objPHPExcel->getActiveSheet()->setCellValue('BB2', 'JANUARI '.$fiscal_end);
        $objPHPExcel->getActiveSheet()->setCellValue('BG2', 'FEBRUARI '.$fiscal_end);
        $objPHPExcel->getActiveSheet()->setCellValue('BL2', 'MARET '.$fiscal_end);
        $objPHPExcel->getActiveSheet()->setCellValue('BQ2', 'TOTAL AMOUNT');
        
        $objPHPExcel->getActiveSheet()->getStyle("A2:BV2")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        $objPHPExcel->getActiveSheet()->mergeCells('A2:A3');
        $objPHPExcel->getActiveSheet()->mergeCells('B2:B3');
        $objPHPExcel->getActiveSheet()->mergeCells('C2:C3');
        $objPHPExcel->getActiveSheet()->mergeCells('D2:D3');
        $objPHPExcel->getActiveSheet()->mergeCells('E2:E3');
        $objPHPExcel->getActiveSheet()->mergeCells('F2:F3');
        $objPHPExcel->getActiveSheet()->mergeCells('G2:G3');
        $objPHPExcel->getActiveSheet()->mergeCells('H2:H3');
        $objPHPExcel->getActiveSheet()->mergeCells('I2:M2');
        $objPHPExcel->getActiveSheet()->mergeCells('N2:R2');
        $objPHPExcel->getActiveSheet()->mergeCells('S2:W2');
        $objPHPExcel->getActiveSheet()->mergeCells('X2:AB2');
        $objPHPExcel->getActiveSheet()->mergeCells('AC2:AG2');
        $objPHPExcel->getActiveSheet()->mergeCells('AH2:AL2');
        $objPHPExcel->getActiveSheet()->mergeCells('AM2:AQ2');
        $objPHPExcel->getActiveSheet()->mergeCells('AR2:AV2');
        $objPHPExcel->getActiveSheet()->mergeCells('AW2:BA2');
        $objPHPExcel->getActiveSheet()->mergeCells('BB2:BF2');
        $objPHPExcel->getActiveSheet()->mergeCells('BG2:BK2');
        $objPHPExcel->getActiveSheet()->mergeCells('BL2:BP2');
        $objPHPExcel->getActiveSheet()->mergeCells('BQ2:BV2');
        //APRIL
        $objPHPExcel->getActiveSheet()->setCellValue('I3', 'PLAN');        
        $objPHPExcel->getActiveSheet()->setCellValue('J3', 'LIMIT');
        $objPHPExcel->getActiveSheet()->setCellValue('K3', 'ACTUAL PR');
        $objPHPExcel->getActiveSheet()->setCellValue('L3', 'OUTSTD PR');
        $objPHPExcel->getActiveSheet()->setCellValue('M3', 'ACTUAL GR');
        //MEI
        $objPHPExcel->getActiveSheet()->setCellValue('N3', 'PLAN');
        $objPHPExcel->getActiveSheet()->setCellValue('O3', 'LIMIT');
        $objPHPExcel->getActiveSheet()->setCellValue('P3', 'ACTUAL PR');
        $objPHPExcel->getActiveSheet()->setCellValue('Q3', 'OUTSTD PR');
        $objPHPExcel->getActiveSheet()->setCellValue('R3', 'ACTUAL GR');
        //JUNI
        $objPHPExcel->getActiveSheet()->setCellValue('S3', 'PLAN');
        $objPHPExcel->getActiveSheet()->setCellValue('T3', 'LIMIT');
        $objPHPExcel->getActiveSheet()->setCellValue('U3', 'ACTUAL PR');
        $objPHPExcel->getActiveSheet()->setCellValue('V3', 'OUTSTD PR');
        $objPHPExcel->getActiveSheet()->setCellValue('W3', 'ACTUAL GR');
        //JULI
        $objPHPExcel->getActiveSheet()->setCellValue('X3', 'PLAN');
        $objPHPExcel->getActiveSheet()->setCellValue('Y3', 'LIMIT');
        $objPHPExcel->getActiveSheet()->setCellValue('Z3', 'ACTUAL PR');
        $objPHPExcel->getActiveSheet()->setCellValue('AA3', 'OUTSTD PR');
        $objPHPExcel->getActiveSheet()->setCellValue('AB3', 'ACTUAL GR');
        //AGUSTUS
        $objPHPExcel->getActiveSheet()->setCellValue('AC3', 'PLAN');
        $objPHPExcel->getActiveSheet()->setCellValue('AD3', 'LIMIT');
        $objPHPExcel->getActiveSheet()->setCellValue('AE3', 'ACTUAL PR');
        $objPHPExcel->getActiveSheet()->setCellValue('AF3', 'OUTSTD PR');
        $objPHPExcel->getActiveSheet()->setCellValue('AG3', 'ACTUAL GR');
        //SEPTEMBER
        $objPHPExcel->getActiveSheet()->setCellValue('AH3', 'PLAN');
        $objPHPExcel->getActiveSheet()->setCellValue('AI3', 'LIMIT');
        $objPHPExcel->getActiveSheet()->setCellValue('AJ3', 'ACTUAL PR');
        $objPHPExcel->getActiveSheet()->setCellValue('AK3', 'OUTSTD PR');
        $objPHPExcel->getActiveSheet()->setCellValue('AL3', 'ACTUAL GR');
        //OKTOBER
        $objPHPExcel->getActiveSheet()->setCellValue('AM3', 'PLAN');
        $objPHPExcel->getActiveSheet()->setCellValue('AN3', 'LIMIT');
        $objPHPExcel->getActiveSheet()->setCellValue('AO3', 'ACTUAL PR');
        $objPHPExcel->getActiveSheet()->setCellValue('AP3', 'OUTSTD PR');
        $objPHPExcel->getActiveSheet()->setCellValue('AQ3', 'ACTUAL GR');
        //NOVEMBER
        $objPHPExcel->getActiveSheet()->setCellValue('AR3', 'PLAN');
        $objPHPExcel->getActiveSheet()->setCellValue('AS3', 'LIMIT');
        $objPHPExcel->getActiveSheet()->setCellValue('AT3', 'ACTUAL PR');
        $objPHPExcel->getActiveSheet()->setCellValue('AU3', 'OUTSTD PR');
        $objPHPExcel->getActiveSheet()->setCellValue('AV3', 'ACTUAL GR');
        //DESEMBER
        $objPHPExcel->getActiveSheet()->setCellValue('AW3', 'PLAN');
        $objPHPExcel->getActiveSheet()->setCellValue('AX3', 'LIMIT');
        $objPHPExcel->getActiveSheet()->setCellValue('AY3', 'ACTUAL PR');
        $objPHPExcel->getActiveSheet()->setCellValue('AZ3', 'OUTSTD PR');
        $objPHPExcel->getActiveSheet()->setCellValue('BA3', 'ACTUAL GR');
        //JANUARI
        $objPHPExcel->getActiveSheet()->setCellValue('BB3', 'PLAN');
        $objPHPExcel->getActiveSheet()->setCellValue('BC3', 'LIMIT');
        $objPHPExcel->getActiveSheet()->setCellValue('BD3', 'ACTUAL PR');
        $objPHPExcel->getActiveSheet()->setCellValue('BE3', 'OUTSTD PR');
        $objPHPExcel->getActiveSheet()->setCellValue('BF3', 'ACTUAL GR');
        //FEBRUARI
        $objPHPExcel->getActiveSheet()->setCellValue('BG3', 'PLAN');
        $objPHPExcel->getActiveSheet()->setCellValue('BH3', 'LIMIT');
        $objPHPExcel->getActiveSheet()->setCellValue('BI3', 'ACTUAL PR');
        $objPHPExcel->getActiveSheet()->setCellValue('BJ3', 'OUTSTD PR');
        $objPHPExcel->getActiveSheet()->setCellValue('BK3', 'ACTUAL GR');
        //MARET
        $objPHPExcel->getActiveSheet()->setCellValue('BL3', 'PLAN');
        $objPHPExcel->getActiveSheet()->setCellValue('BM3', 'LIMIT');
        $objPHPExcel->getActiveSheet()->setCellValue('BN3', 'ACTUAL PR');
        $objPHPExcel->getActiveSheet()->setCellValue('BO3', 'OUTSTD PR');
        $objPHPExcel->getActiveSheet()->setCellValue('BP3', 'ACTUAL GR');
        //TOTAL
        $objPHPExcel->getActiveSheet()->setCellValue('BQ3', 'PLAN');
        $objPHPExcel->getActiveSheet()->setCellValue('BR3', 'LIMIT');
        $objPHPExcel->getActiveSheet()->setCellValue('BS3', 'ACTUAL PR');
        $objPHPExcel->getActiveSheet()->setCellValue('BT3', 'OUTSTD PR');
        $objPHPExcel->getActiveSheet()->setCellValue('BU3', 'SALDO');
        $objPHPExcel->getActiveSheet()->setCellValue('BV3', 'ACTUAL GR');
        
        $objPHPExcel->getActiveSheet()->getStyle("I3:BV3")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A2:BV2')->getFont()->setSize(12);
        
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(6); $objPHPExcel->getActiveSheet()->getColumnDimension('AA')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10); $objPHPExcel->getActiveSheet()->getColumnDimension('AB')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25); $objPHPExcel->getActiveSheet()->getColumnDimension('AC')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(50); $objPHPExcel->getActiveSheet()->getColumnDimension('AD')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20); $objPHPExcel->getActiveSheet()->getColumnDimension('AE')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20); $objPHPExcel->getActiveSheet()->getColumnDimension('AF')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20); $objPHPExcel->getActiveSheet()->getColumnDimension('AG')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15); $objPHPExcel->getActiveSheet()->getColumnDimension('AH')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15); $objPHPExcel->getActiveSheet()->getColumnDimension('AI')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(15); $objPHPExcel->getActiveSheet()->getColumnDimension('AJ')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(15); $objPHPExcel->getActiveSheet()->getColumnDimension('AK')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(15); $objPHPExcel->getActiveSheet()->getColumnDimension('AL')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(15); $objPHPExcel->getActiveSheet()->getColumnDimension('AM')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(15); $objPHPExcel->getActiveSheet()->getColumnDimension('AN')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(15); $objPHPExcel->getActiveSheet()->getColumnDimension('AO')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(15); $objPHPExcel->getActiveSheet()->getColumnDimension('AP')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(15); $objPHPExcel->getActiveSheet()->getColumnDimension('AQ')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(15); $objPHPExcel->getActiveSheet()->getColumnDimension('AR')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(15); $objPHPExcel->getActiveSheet()->getColumnDimension('AS')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('T')->setWidth(15); $objPHPExcel->getActiveSheet()->getColumnDimension('AT')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('U')->setWidth(15); $objPHPExcel->getActiveSheet()->getColumnDimension('AU')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('V')->setWidth(15); $objPHPExcel->getActiveSheet()->getColumnDimension('AV')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('W')->setWidth(15); $objPHPExcel->getActiveSheet()->getColumnDimension('AW')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('X')->setWidth(15); $objPHPExcel->getActiveSheet()->getColumnDimension('AX')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('Y')->setWidth(15); $objPHPExcel->getActiveSheet()->getColumnDimension('AY')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('Z')->setWidth(15); $objPHPExcel->getActiveSheet()->getColumnDimension('AZ')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BA')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BB')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BC')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BD')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BE')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BF')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BG')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BH')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BI')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BJ')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BK')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BL')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BM')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BN')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BO')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BP')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BQ')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BR')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BS')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BT')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BU')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BV')->setWidth(15);
        
        //Value of All Cells
        $i = 4;
        $no = 1;
        foreach($list_budget as $data){
            $no_bgt = trim($data->CHR_NO_BUDGET);
            if ($bgt_type == 'CAPEX'){
                $GRBLN = $bgt_aii->query("EXEC zsp_get_gr_capex_by_no_budget '$fiscal_start', '$fiscal_end' , '" . $data->CHR_NO_BUDGET . "', ''");
            } else {
                $GRBLN = $bgt_aii->query("EXEC zsp_get_gr_expense_by_no_budget '$fiscal_start', '$fiscal_end' , '$bgt_type' , '" . $data->CHR_NO_BUDGET . "', ''");
            }
            
            //Get GR Value per Month
            if($GRBLN->num_rows() == 0){
                $GR04 = 0;
                $GR05 = 0;
                $GR06 = 0;
                $GR07 = 0;
                $GR08 = 0;
                $GR09 = 0;
                $GR10 = 0;
                $GR11 = 0;
                $GR12 = 0;
                $GR13 = 0;
                $GR14 = 0;
                $GR15 = 0;
                $tot_gr = 0;
            } else {
                $GR04 = $GRBLN->row()->GRBLN04;
                $GR05 = $GRBLN->row()->GRBLN05;
                $GR06 = $GRBLN->row()->GRBLN06;
                $GR07 = $GRBLN->row()->GRBLN07;
                $GR08 = $GRBLN->row()->GRBLN08;
                $GR09 = $GRBLN->row()->GRBLN09;
                $GR10 = $GRBLN->row()->GRBLN10;
                $GR11 = $GRBLN->row()->GRBLN11;
                $GR12 = $GRBLN->row()->GRBLN12;
                $GR13 = $GRBLN->row()->GRBLN13;
                $GR14 = $GRBLN->row()->GRBLN14;
                $GR15 = $GRBLN->row()->GRBLN15;
                $tot_gr = $GRBLN->row()->TOT_GR;
            }

            $outstd_pr = $this->report_budget_m->get_pr_outstanding_by_no_budget($fiscal_start, $fiscal_end, $bgt_type, $data->CHR_KODE_DEPARTMENT, trim($kode_sect), trim($data->CHR_NO_BUDGET));
            if($outstd_pr->num_rows() == 0){
                $PR04 = 0;
                $PR05 = 0;
                $PR06 = 0;
                $PR07 = 0;
                $PR08 = 0;
                $PR09 = 0;
                $PR10 = 0;
                $PR11 = 0;
                $PR12 = 0;
                $PR13 = 0;
                $PR14 = 0;
                $PR15 = 0;
                $tot_pr_outstd = 0;
            } else {
                $PR04 = $outstd_pr->row()->PR04;
                $PR05 = $outstd_pr->row()->PR05;
                $PR06 = $outstd_pr->row()->PR06;
                $PR07 = $outstd_pr->row()->PR07;
                $PR08 = $outstd_pr->row()->PR08;
                $PR09 = $outstd_pr->row()->PR09;
                $PR10 = $outstd_pr->row()->PR10;
                $PR11 = $outstd_pr->row()->PR11;
                $PR12 = $outstd_pr->row()->PR12;
                $PR13 = $outstd_pr->row()->PR13;
                $PR14 = $outstd_pr->row()->PR14;
                $PR15 = $outstd_pr->row()->PR15;
                $tot_pr_outstd = $outstd_pr->row()->PR_TOT;
            }
            
            //Insert Value to Excel Column
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$i, $no);
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$i, $data->CHR_TAHUN_BUDGET);
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$i, $data->CHR_NO_BUDGET);
            $objPHPExcel->getActiveSheet()->setCellValue('D'.$i, $data->CHR_DESC_BUDGET);
            $objPHPExcel->getActiveSheet()->setCellValue('E'.$i, $data->CHR_KODE_DEPARTMENT);
            $objPHPExcel->getActiveSheet()->setCellValue('F'.$i, $data->CHR_KODE_TYPE_BUDGET);        
            $objPHPExcel->getActiveSheet()->setCellValue('G'.$i, $data->CHR_KODE_SUBCATEGORY_BUDGET);                
            $objPHPExcel->getActiveSheet()->setCellValue('H'.$i, $data->CHR_DESC_PROJECT);   
            //APRIL
            $objPHPExcel->getActiveSheet()->setCellValue('I'.$i, $data->PBLN04);
            $objPHPExcel->getActiveSheet()->setCellValue('J'.$i, $data->LBLN04);        
            $objPHPExcel->getActiveSheet()->setCellValue('K'.$i, $data->OBLN04);
            $objPHPExcel->getActiveSheet()->setCellValue('L'.$i, $PR04);
            $objPHPExcel->getActiveSheet()->setCellValue('M'.$i, $GR04);
            //MEI
            $objPHPExcel->getActiveSheet()->setCellValue('N'.$i, $data->PBLN05);
            $objPHPExcel->getActiveSheet()->setCellValue('O'.$i, $data->LBLN05);        
            $objPHPExcel->getActiveSheet()->setCellValue('P'.$i, $data->OBLN05);
            $objPHPExcel->getActiveSheet()->setCellValue('Q'.$i, $PR05);
            $objPHPExcel->getActiveSheet()->setCellValue('R'.$i, $GR05);
            //JUNI
            $objPHPExcel->getActiveSheet()->setCellValue('S'.$i, $data->PBLN06);
            $objPHPExcel->getActiveSheet()->setCellValue('T'.$i, $data->LBLN06);        
            $objPHPExcel->getActiveSheet()->setCellValue('U'.$i, $data->OBLN06);
            $objPHPExcel->getActiveSheet()->setCellValue('V'.$i, $PR06);
            $objPHPExcel->getActiveSheet()->setCellValue('W'.$i, $GR06);
            //JULI
            $objPHPExcel->getActiveSheet()->setCellValue('X'.$i, $data->PBLN07);
            $objPHPExcel->getActiveSheet()->setCellValue('Y'.$i, $data->LBLN07);        
            $objPHPExcel->getActiveSheet()->setCellValue('Z'.$i, $data->OBLN07);
            $objPHPExcel->getActiveSheet()->setCellValue('AA'.$i, $PR07);
            $objPHPExcel->getActiveSheet()->setCellValue('AB'.$i, $GR07);
            //AGUSTUS
            $objPHPExcel->getActiveSheet()->setCellValue('AC'.$i, $data->PBLN08);
            $objPHPExcel->getActiveSheet()->setCellValue('AD'.$i, $data->LBLN08);        
            $objPHPExcel->getActiveSheet()->setCellValue('AE'.$i, $data->OBLN08);
            $objPHPExcel->getActiveSheet()->setCellValue('AF'.$i, $PR08);
            $objPHPExcel->getActiveSheet()->setCellValue('AG'.$i, $GR08);
            //SEPTEMBER
            $objPHPExcel->getActiveSheet()->setCellValue('AH'.$i, $data->PBLN09);
            $objPHPExcel->getActiveSheet()->setCellValue('AI'.$i, $data->LBLN09);        
            $objPHPExcel->getActiveSheet()->setCellValue('AJ'.$i, $data->OBLN09);
            $objPHPExcel->getActiveSheet()->setCellValue('AK'.$i, $PR09);
            $objPHPExcel->getActiveSheet()->setCellValue('AL'.$i, $GR09);
            //OKTOBER
            $objPHPExcel->getActiveSheet()->setCellValue('AM'.$i, $data->PBLN10);
            $objPHPExcel->getActiveSheet()->setCellValue('AN'.$i, $data->LBLN10);        
            $objPHPExcel->getActiveSheet()->setCellValue('AO'.$i, $data->OBLN10);
            $objPHPExcel->getActiveSheet()->setCellValue('AP'.$i, $PR10);
            $objPHPExcel->getActiveSheet()->setCellValue('AQ'.$i, $GR10);
            //NOVEMBER
            $objPHPExcel->getActiveSheet()->setCellValue('AR'.$i, $data->PBLN11);
            $objPHPExcel->getActiveSheet()->setCellValue('AS'.$i, $data->LBLN11);        
            $objPHPExcel->getActiveSheet()->setCellValue('AT'.$i, $data->OBLN11);
            $objPHPExcel->getActiveSheet()->setCellValue('AU'.$i, $PR11);
            $objPHPExcel->getActiveSheet()->setCellValue('AV'.$i, $GR11);
            //DESEMBER
            $objPHPExcel->getActiveSheet()->setCellValue('AW'.$i, $data->PBLN12);
            $objPHPExcel->getActiveSheet()->setCellValue('AX'.$i, $data->LBLN12);        
            $objPHPExcel->getActiveSheet()->setCellValue('AY'.$i, $data->OBLN12);
            $objPHPExcel->getActiveSheet()->setCellValue('AZ'.$i, $PR12);
            $objPHPExcel->getActiveSheet()->setCellValue('BA'.$i, $GR12);
            //JANUARI
            $objPHPExcel->getActiveSheet()->setCellValue('BB'.$i, $data->PBLN13);
            $objPHPExcel->getActiveSheet()->setCellValue('BC'.$i, $data->LBLN13);        
            $objPHPExcel->getActiveSheet()->setCellValue('BD'.$i, $data->OBLN13);
            $objPHPExcel->getActiveSheet()->setCellValue('BE'.$i, $PR13);
            $objPHPExcel->getActiveSheet()->setCellValue('BF'.$i, $GR13);
            //FEBRUARI
            $objPHPExcel->getActiveSheet()->setCellValue('BG'.$i, $data->PBLN14);
            $objPHPExcel->getActiveSheet()->setCellValue('BH'.$i, $data->LBLN14);        
            $objPHPExcel->getActiveSheet()->setCellValue('BI'.$i, $data->OBLN14);
            $objPHPExcel->getActiveSheet()->setCellValue('BJ'.$i, $PR14);
            $objPHPExcel->getActiveSheet()->setCellValue('BK'.$i, $GR14);
            //MARET
            $objPHPExcel->getActiveSheet()->setCellValue('BL'.$i, $data->PBLN15);
            $objPHPExcel->getActiveSheet()->setCellValue('BM'.$i, $data->LBLN15);        
            $objPHPExcel->getActiveSheet()->setCellValue('BN'.$i, $data->OBLN15);
            $objPHPExcel->getActiveSheet()->setCellValue('BO'.$i, $PR15);
            $objPHPExcel->getActiveSheet()->setCellValue('BP'.$i, $GR15);
            //TOTAL
            // $outstd_pr = $bgt_aii->query("SELECT ISNULL(SUM(MON_TOTAL_PRICE_SUPPLIER),0) AS OUTSTD_PR FROM BDGT_TT_BUDGET_PR_DETAIL
            //                                     WHERE CHR_NO_BUDGET LIKE '%$no_bgt%' AND CHR_KODE_TRANSAKSI IN (SELECT CHR_KODE_TRANSAKSI FROM BDGT_TT_BUDGET_PR_HEADER 
            //                                     WHERE CHR_KODE_TYPE_BUDGET = '$bgt_type' AND CHR_TAHUN_BUDGET = '$fiscal_start' AND CHR_FLG_APPROVE_BOD = '0' AND CHR_FLG_DELETE = '0')")->row();
            
            $tot_plan = $data->PBLN04 + $data->PBLN05 + $data->PBLN06 + $data->PBLN07 + $data->PBLN08 + $data->PBLN09 + $data->PBLN10 + $data->PBLN11 +
                        $data->PBLN12 + $data->PBLN13 + $data->PBLN14 + $data->PBLN15;
            $tot_limit = $data->LBLN04 + $data->LBLN05 + $data->LBLN06 + $data->LBLN07 + $data->LBLN08 + $data->LBLN09 + $data->LBLN10 + $data->LBLN11 +
                        $data->LBLN12 + $data->LBLN13 + $data->LBLN14 + $data->LBLN15;
            $tot_actual = $data->OBLN04 + $data->OBLN05 + $data->OBLN06 + $data->OBLN07 + $data->OBLN08 + $data->OBLN09 + $data->OBLN10 + $data->OBLN11 +
                        $data->OBLN12 + $data->OBLN13 + $data->OBLN14 + $data->OBLN15;
            //$tot_outstd = $outstd_pr->OUTSTD_PR;
            //$saldo = $tot_limit - ($tot_actual + $tot_outstd);
            $saldo = $tot_limit - ($tot_actual + $tot_pr_outstd);
            
            $objPHPExcel->getActiveSheet()->setCellValue('BQ'.$i, $tot_plan);
            $objPHPExcel->getActiveSheet()->setCellValue('BR'.$i, $tot_limit);        
            $objPHPExcel->getActiveSheet()->setCellValue('BS'.$i, $tot_actual);
            //$objPHPExcel->getActiveSheet()->setCellValue('BT'.$i, $tot_outstd);
            $objPHPExcel->getActiveSheet()->setCellValue('BT'.$i, $tot_pr_outstd);
            $objPHPExcel->getActiveSheet()->setCellValue('BU'.$i, $saldo);
            $objPHPExcel->getActiveSheet()->setCellValue('BV'.$i, $tot_gr);
            
            $objPHPExcel->getActiveSheet()->getStyle("A".$i.":C".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle("D".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle("E".$i.":H".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle("I".$i.":BV".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $i++;
            $no++;
        }
        
        $x = $i-1;
        $objPHPExcel->getActiveSheet()->setCellValue("I$i", "=SUM(I4:I$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("J$i", "=SUM(J4:J$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("K$i", "=SUM(K4:K$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("L$i", "=SUM(L4:L$x)");        
        $objPHPExcel->getActiveSheet()->setCellValue("M$i", "=SUM(M4:M$x)");

        $objPHPExcel->getActiveSheet()->setCellValue("N$i", "=SUM(N4:N$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("O$i", "=SUM(O4:O$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("P$i", "=SUM(P4:P$x)");        
        $objPHPExcel->getActiveSheet()->setCellValue("Q$i", "=SUM(Q4:Q$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("R$i", "=SUM(R4:R$x)");

        $objPHPExcel->getActiveSheet()->setCellValue("S$i", "=SUM(S4:S$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("T$i", "=SUM(T4:T$x)");        
        $objPHPExcel->getActiveSheet()->setCellValue("U$i", "=SUM(U4:U$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("V$i", "=SUM(V4:V$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("W$i", "=SUM(W4:W$x)");

        $objPHPExcel->getActiveSheet()->setCellValue("X$i", "=SUM(X4:X$x)");        
        $objPHPExcel->getActiveSheet()->setCellValue("Y$i", "=SUM(Y4:Y$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("Z$i", "=SUM(Z4:Z$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("AA$i", "=SUM(AA4:AA$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("AB$i", "=SUM(AB4:AB$x)");
        
        $objPHPExcel->getActiveSheet()->setCellValue("AC$i", "=SUM(AC4:AC$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("AD$i", "=SUM(AD4:AD$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("AE$i", "=SUM(AE4:AE$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("AF$i", "=SUM(AF4:AF$x)");        
        $objPHPExcel->getActiveSheet()->setCellValue("AG$i", "=SUM(AG4:AG$x)");

        $objPHPExcel->getActiveSheet()->setCellValue("AH$i", "=SUM(AH4:AH$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("AI$i", "=SUM(AI4:AI$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("AJ$i", "=SUM(AJ4:AJ$x)");        
        $objPHPExcel->getActiveSheet()->setCellValue("AK$i", "=SUM(AK4:AK$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("AL$i", "=SUM(AL4:AL$x)");

        $objPHPExcel->getActiveSheet()->setCellValue("AM$i", "=SUM(AM4:AM$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("AN$i", "=SUM(AN4:AN$x)");        
        $objPHPExcel->getActiveSheet()->setCellValue("AO$i", "=SUM(AO4:AO$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("AP$i", "=SUM(AP4:AP$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("AQ$i", "=SUM(AQ4:AQ$x)");

        $objPHPExcel->getActiveSheet()->setCellValue("AR$i", "=SUM(AR4:AR$x)");        
        $objPHPExcel->getActiveSheet()->setCellValue("AS$i", "=SUM(AS4:AS$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("AT$i", "=SUM(AT4:AT$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("AU$i", "=SUM(AU4:AU$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("AV$i", "=SUM(AV4:AV$x)");
        
        $objPHPExcel->getActiveSheet()->setCellValue("AW$i", "=SUM(AW4:AW$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("AX$i", "=SUM(AX4:AX$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("AY$i", "=SUM(AY4:AY$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("AZ$i", "=SUM(AZ4:AZ$x)");        
        $objPHPExcel->getActiveSheet()->setCellValue("BA$i", "=SUM(BA4:BA$x)");

        $objPHPExcel->getActiveSheet()->setCellValue("BB$i", "=SUM(BB4:BB$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("BC$i", "=SUM(BC4:BC$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("BD$i", "=SUM(BD4:BD$x)");        
        $objPHPExcel->getActiveSheet()->setCellValue("BE$i", "=SUM(BE4:BE$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("BF$i", "=SUM(BF4:BF$x)");

        $objPHPExcel->getActiveSheet()->setCellValue("BG$i", "=SUM(BG4:BG$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("BH$i", "=SUM(BH4:BH$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("BI$i", "=SUM(BI4:BI$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("BJ$i", "=SUM(BJ4:BJ$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("BK$i", "=SUM(BK4:BK$x)");

        $objPHPExcel->getActiveSheet()->setCellValue("BL$i", "=SUM(BL4:BL$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("BM$i", "=SUM(BM4:BM$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("BN$i", "=SUM(BN4:BN$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("BO$i", "=SUM(BO4:BO$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("BP$i", "=SUM(BP4:BP$x)");

        $objPHPExcel->getActiveSheet()->setCellValue("BQ$i", "=SUM(BQ4:BQ$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("BR$i", "=SUM(BR4:BR$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("BS$i", "=SUM(BS4:BS$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("BT$i", "=SUM(BT4:BT$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("BU$i", "=SUM(BU4:BU$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("BV$i", "=SUM(BV4:BV$x)");
        
        $styleArray = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                ),
            ),
        );
        
        $styleArray2 = array(
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => '99CCFF')
            )
        );
        
        $styleArray3 = array(
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('argb' => 'CCCCCC')
            )
        );
        
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$i, "TOTAL");
        $objPHPExcel->getActiveSheet()->mergeCells("A$i:H$i");
        $objPHPExcel->getActiveSheet()->getStyle("A".$i.":H".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        $objPHPExcel->getActiveSheet()->getStyle("A2:BV3")->applyFromArray($styleArray2);
        $objPHPExcel->getActiveSheet()->getStyle("A2:BV$i")->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->getStyle("A$i:BV$i")->applyFromArray($styleArray3);
        $objPHPExcel->getActiveSheet()->getStyle("A$i:BV$i")->getFont()->setBold(true);
        
        $filename = "Report Summary Budget ". $bgt_type ." for " . $kode_dept . " " . $fiscal_start . ".xls";
        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . trim($filename) . '"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->setIncludeCharts(TRUE);
        $objWriter->save('php://output');
    }
    
    function export_report_summary_budget_by_sect() {  
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        $this->load->library('excel');        
        
        $fiscal_start = $this->input->post("CHR_FISCAL_SECT");
        $fiscal_end = $fiscal_start + 1;
        $kode_dept = $this->input->post("CHR_DEPT_SECT");
        $kode_sect = $this->input->post("CHR_SECT_SECT");
        $bgt_type = $this->input->post("CHR_BUDGET_TYPE_SECT");
        
        if($kode_sect == 'ALL'){
            $kode_sect = '';
        }
        
        $list_budget = $this->report_budget_m->get_report_budget_per_sect($fiscal_start, $fiscal_end, $bgt_type, $kode_dept, $kode_sect);
//        print_r($list_budget);
//        exit();

        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

        // Set Properties
        $objPHPExcel->getProperties()->setCreator(trim($this->session->userdata('USERNAME')));
        $objPHPExcel->getProperties()->setLastModifiedBy(trim($this->session->userdata('USERNAME')));
        $objPHPExcel->getProperties()->setTitle("REKAP BUDGET");
        $objPHPExcel->getProperties()->setSubject("REKAP BUDGET");
        $objPHPExcel->getProperties()->setDescription("REKAP BUDGET");
                
        //Header TR
        $objPHPExcel->getActiveSheet()->setCellValue('A2', 'NO');        
        $objPHPExcel->getActiveSheet()->setCellValue('B2', 'TAHUN');
        $objPHPExcel->getActiveSheet()->setCellValue('C2', 'DEPARTMENT');
        $objPHPExcel->getActiveSheet()->setCellValue('D2', 'SECTION');
        $objPHPExcel->getActiveSheet()->setCellValue('E2', 'APRIL '.$fiscal_start);
        $objPHPExcel->getActiveSheet()->setCellValue('J2', 'MEI '.$fiscal_start);
        $objPHPExcel->getActiveSheet()->setCellValue('O2', 'JUNI '.$fiscal_start);
        $objPHPExcel->getActiveSheet()->setCellValue('T2', 'JULI '.$fiscal_start);
        $objPHPExcel->getActiveSheet()->setCellValue('Y2', 'AGUSTUS '.$fiscal_start);
        $objPHPExcel->getActiveSheet()->setCellValue('AD2', 'SEPTEMBER '.$fiscal_start);
        $objPHPExcel->getActiveSheet()->setCellValue('AI2', 'OKTOBER '.$fiscal_start);
        $objPHPExcel->getActiveSheet()->setCellValue('AN2', 'NOVEMBER '.$fiscal_start);
        $objPHPExcel->getActiveSheet()->setCellValue('AS2', 'DESEMBER '.$fiscal_start);
        $objPHPExcel->getActiveSheet()->setCellValue('AX2', 'JANUARI '.$fiscal_end);
        $objPHPExcel->getActiveSheet()->setCellValue('BC2', 'FEBRUARI '.$fiscal_end);
        $objPHPExcel->getActiveSheet()->setCellValue('BH2', 'MARET '.$fiscal_end);
        $objPHPExcel->getActiveSheet()->setCellValue('BM2', 'TOTAL AMOUNT');
        
        $objPHPExcel->getActiveSheet()->getStyle("A2:BR2")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        $objPHPExcel->getActiveSheet()->mergeCells('A2:A3');
        $objPHPExcel->getActiveSheet()->mergeCells('B2:B3');
        $objPHPExcel->getActiveSheet()->mergeCells('C2:C3');
        $objPHPExcel->getActiveSheet()->mergeCells('D2:D3');
        $objPHPExcel->getActiveSheet()->mergeCells('E2:I2');
        $objPHPExcel->getActiveSheet()->mergeCells('J2:N2');
        $objPHPExcel->getActiveSheet()->mergeCells('O2:S2');
        $objPHPExcel->getActiveSheet()->mergeCells('T2:X2');
        $objPHPExcel->getActiveSheet()->mergeCells('Y2:AC2');
        $objPHPExcel->getActiveSheet()->mergeCells('AD2:AH2');
        $objPHPExcel->getActiveSheet()->mergeCells('AI2:AM2');
        $objPHPExcel->getActiveSheet()->mergeCells('AN2:AR2');
        $objPHPExcel->getActiveSheet()->mergeCells('AS2:AW2');
        $objPHPExcel->getActiveSheet()->mergeCells('AX2:BB2');
        $objPHPExcel->getActiveSheet()->mergeCells('BC2:BG2');
        $objPHPExcel->getActiveSheet()->mergeCells('BH2:BL2');
        $objPHPExcel->getActiveSheet()->mergeCells('BM2:BR2');
        //APRIL
        $objPHPExcel->getActiveSheet()->setCellValue('E3', 'PLAN');        
        $objPHPExcel->getActiveSheet()->setCellValue('F3', 'LIMIT');
        $objPHPExcel->getActiveSheet()->setCellValue('G3', 'ACTUAL PR');
        $objPHPExcel->getActiveSheet()->setCellValue('H3', 'OUTSTD PR');
        $objPHPExcel->getActiveSheet()->setCellValue('I3', 'ACTUAL GR');
        //MEI
        $objPHPExcel->getActiveSheet()->setCellValue('J3', 'PLAN');
        $objPHPExcel->getActiveSheet()->setCellValue('K3', 'LIMIT');
        $objPHPExcel->getActiveSheet()->setCellValue('L3', 'ACTUAL PR');
        $objPHPExcel->getActiveSheet()->setCellValue('M3', 'OUTSTD PR');
        $objPHPExcel->getActiveSheet()->setCellValue('N3', 'ACTUAL GR');
        //JUNI
        $objPHPExcel->getActiveSheet()->setCellValue('O3', 'PLAN');
        $objPHPExcel->getActiveSheet()->setCellValue('P3', 'LIMIT');
        $objPHPExcel->getActiveSheet()->setCellValue('Q3', 'ACTUAL PR');
        $objPHPExcel->getActiveSheet()->setCellValue('R3', 'OUTSTD PR');
        $objPHPExcel->getActiveSheet()->setCellValue('S3', 'ACTUAL GR');
        //JULI
        $objPHPExcel->getActiveSheet()->setCellValue('T3', 'PLAN');
        $objPHPExcel->getActiveSheet()->setCellValue('U3', 'LIMIT');
        $objPHPExcel->getActiveSheet()->setCellValue('V3', 'ACTUAL PR');
        $objPHPExcel->getActiveSheet()->setCellValue('W3', 'OUTSTD PR');
        $objPHPExcel->getActiveSheet()->setCellValue('X3', 'ACTUAL GR');
        //AGUSTUS
        $objPHPExcel->getActiveSheet()->setCellValue('Y3', 'PLAN');
        $objPHPExcel->getActiveSheet()->setCellValue('Z3', 'LIMIT');
        $objPHPExcel->getActiveSheet()->setCellValue('AA3', 'ACTUAL PR');
        $objPHPExcel->getActiveSheet()->setCellValue('AB3', 'OUTSTD PR');
        $objPHPExcel->getActiveSheet()->setCellValue('AC3', 'ACTUAL GR');
        //SEPTEMBER
        $objPHPExcel->getActiveSheet()->setCellValue('AD3', 'PLAN');
        $objPHPExcel->getActiveSheet()->setCellValue('AE3', 'LIMIT');
        $objPHPExcel->getActiveSheet()->setCellValue('AF3', 'ACTUAL PR');
        $objPHPExcel->getActiveSheet()->setCellValue('AG3', 'OUSTD GR');
        $objPHPExcel->getActiveSheet()->setCellValue('AH3', 'ACTUAL GR');
        //OKTOBER
        $objPHPExcel->getActiveSheet()->setCellValue('AI3', 'PLAN');
        $objPHPExcel->getActiveSheet()->setCellValue('AJ3', 'LIMIT');
        $objPHPExcel->getActiveSheet()->setCellValue('AK3', 'ACTUAL PR');
        $objPHPExcel->getActiveSheet()->setCellValue('AL3', 'OUTSTD PR');
        $objPHPExcel->getActiveSheet()->setCellValue('AM3', 'ACTUAL GR');
        //NOVEMBER
        $objPHPExcel->getActiveSheet()->setCellValue('AN3', 'PLAN');
        $objPHPExcel->getActiveSheet()->setCellValue('AO3', 'LIMIT');
        $objPHPExcel->getActiveSheet()->setCellValue('AP3', 'ACTUAL PR');
        $objPHPExcel->getActiveSheet()->setCellValue('AQ3', 'OUTSTD PR');
        $objPHPExcel->getActiveSheet()->setCellValue('AR3', 'ACTUAL GR');
        //DESEMBER
        $objPHPExcel->getActiveSheet()->setCellValue('AS3', 'PLAN');
        $objPHPExcel->getActiveSheet()->setCellValue('AT3', 'LIMIT');
        $objPHPExcel->getActiveSheet()->setCellValue('AU3', 'ACTUAL PR');
        $objPHPExcel->getActiveSheet()->setCellValue('AV3', 'OUTSTD PR');
        $objPHPExcel->getActiveSheet()->setCellValue('AW3', 'ACTUAL GR');
        //JANUARI
        $objPHPExcel->getActiveSheet()->setCellValue('AX3', 'PLAN');
        $objPHPExcel->getActiveSheet()->setCellValue('AY3', 'LIMIT');
        $objPHPExcel->getActiveSheet()->setCellValue('AZ3', 'ACTUAL PR');
        $objPHPExcel->getActiveSheet()->setCellValue('BA3', 'OUTSTD PR');
        $objPHPExcel->getActiveSheet()->setCellValue('BB3', 'ACTUAL GR');
        //FEBRUARI
        $objPHPExcel->getActiveSheet()->setCellValue('BC3', 'PLAN');
        $objPHPExcel->getActiveSheet()->setCellValue('BD3', 'LIMIT');
        $objPHPExcel->getActiveSheet()->setCellValue('BE3', 'ACTUAL PR');
        $objPHPExcel->getActiveSheet()->setCellValue('BF3', 'OUTSTD PR');
        $objPHPExcel->getActiveSheet()->setCellValue('BG3', 'ACTUAL GR');
        //MARET
        $objPHPExcel->getActiveSheet()->setCellValue('BH3', 'PLAN');
        $objPHPExcel->getActiveSheet()->setCellValue('BI3', 'LIMIT');
        $objPHPExcel->getActiveSheet()->setCellValue('BJ3', 'ACTUAL PR');
        $objPHPExcel->getActiveSheet()->setCellValue('BK3', 'OUTSTD PR');
        $objPHPExcel->getActiveSheet()->setCellValue('BL3', 'ACTUAL GR');
        //TOTAL
        $objPHPExcel->getActiveSheet()->setCellValue('BM3', 'PLAN');
        $objPHPExcel->getActiveSheet()->setCellValue('BN3', 'LIMIT');
        $objPHPExcel->getActiveSheet()->setCellValue('BO3', 'ACTUAL PR');
        $objPHPExcel->getActiveSheet()->setCellValue('BP3', 'OUTSTD PR');
        $objPHPExcel->getActiveSheet()->setCellValue('BQ3', 'SALDO');
        $objPHPExcel->getActiveSheet()->setCellValue('BR3', 'ACTUAL GR');
        
        $objPHPExcel->getActiveSheet()->getStyle("E3:BR3")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A2:BR3')->getFont()->setBold(true)->setSize(12);
        
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(6); $objPHPExcel->getActiveSheet()->getColumnDimension('AA')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10); $objPHPExcel->getActiveSheet()->getColumnDimension('AB')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20); $objPHPExcel->getActiveSheet()->getColumnDimension('AC')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20); $objPHPExcel->getActiveSheet()->getColumnDimension('AD')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15); $objPHPExcel->getActiveSheet()->getColumnDimension('AE')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15); $objPHPExcel->getActiveSheet()->getColumnDimension('AF')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15); $objPHPExcel->getActiveSheet()->getColumnDimension('AG')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15); $objPHPExcel->getActiveSheet()->getColumnDimension('AH')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15); $objPHPExcel->getActiveSheet()->getColumnDimension('AI')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(15); $objPHPExcel->getActiveSheet()->getColumnDimension('AJ')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(15); $objPHPExcel->getActiveSheet()->getColumnDimension('AK')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(15); $objPHPExcel->getActiveSheet()->getColumnDimension('AL')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(15); $objPHPExcel->getActiveSheet()->getColumnDimension('AM')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(15); $objPHPExcel->getActiveSheet()->getColumnDimension('AN')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(15); $objPHPExcel->getActiveSheet()->getColumnDimension('AO')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(15); $objPHPExcel->getActiveSheet()->getColumnDimension('AP')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(15); $objPHPExcel->getActiveSheet()->getColumnDimension('AQ')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(15); $objPHPExcel->getActiveSheet()->getColumnDimension('AR')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(15); $objPHPExcel->getActiveSheet()->getColumnDimension('AS')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('T')->setWidth(15); $objPHPExcel->getActiveSheet()->getColumnDimension('AT')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('U')->setWidth(15); $objPHPExcel->getActiveSheet()->getColumnDimension('AU')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('V')->setWidth(15); $objPHPExcel->getActiveSheet()->getColumnDimension('AV')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('W')->setWidth(15); $objPHPExcel->getActiveSheet()->getColumnDimension('AW')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('X')->setWidth(15); $objPHPExcel->getActiveSheet()->getColumnDimension('AX')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('Y')->setWidth(15); $objPHPExcel->getActiveSheet()->getColumnDimension('AY')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('Z')->setWidth(15); $objPHPExcel->getActiveSheet()->getColumnDimension('AZ')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BA')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BB')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BC')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BD')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BE')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BF')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BG')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BH')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BI')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BJ')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BK')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BL')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BM')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BN')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BO')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BP')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BQ')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BR')->setWidth(15);
        
        //Value of All Cells
        $i = 4;
        $no = 1;
        foreach($list_budget as $data){
            $sect = $data->CHR_KODE_SECTION;
            if ($bgt_type == 'CAPEX'){
                $GRBLN = $bgt_aii->query("EXEC zsp_get_gr_capex_by_sect '$fiscal_start', '$fiscal_end' , '" . $data->CHR_KODE_DEPARTMENT . "', '" . $data->CHR_KODE_SECTION . "', ''");
            } else {
                $GRBLN = $bgt_aii->query("EXEC zsp_get_gr_expense_by_sect '$fiscal_start', '$fiscal_end' , '$bgt_type' , '" . $data->CHR_KODE_DEPARTMENT . "', '" . $data->CHR_KODE_SECTION . "', ''");
            }
            
            //Get GR Value per Month
            if($GRBLN->num_rows() == 0){
                $GR04 = 0;
                $GR05 = 0;
                $GR06 = 0;
                $GR07 = 0;
                $GR08 = 0;
                $GR09 = 0;
                $GR10 = 0;
                $GR11 = 0;
                $GR12 = 0;
                $GR13 = 0;
                $GR14 = 0;
                $GR15 = 0;
                $tot_gr = 0;
            } else {
                $GR04 = $GRBLN->row()->GRBLN04;
                $GR05 = $GRBLN->row()->GRBLN05;
                $GR06 = $GRBLN->row()->GRBLN06;
                $GR07 = $GRBLN->row()->GRBLN07;
                $GR08 = $GRBLN->row()->GRBLN08;
                $GR09 = $GRBLN->row()->GRBLN09;
                $GR10 = $GRBLN->row()->GRBLN10;
                $GR11 = $GRBLN->row()->GRBLN11;
                $GR12 = $GRBLN->row()->GRBLN12;
                $GR13 = $GRBLN->row()->GRBLN13;
                $GR14 = $GRBLN->row()->GRBLN14;
                $GR15 = $GRBLN->row()->GRBLN15;
                $tot_gr = $GRBLN->row()->TOT_GR;
            }

            $outstd_pr = $this->report_budget_m->get_pr_outstanding($fiscal_start, $fiscal_end, $bgt_type, $isi->CHR_KODE_DEPARTMENT, trim($sect));
            if($outstd_pr->num_rows() == 0){
                $PR04 = 0;
                $PR05 = 0;
                $PR06 = 0;
                $PR07 = 0;
                $PR08 = 0;
                $PR09 = 0;
                $PR10 = 0;
                $PR11 = 0;
                $PR12 = 0;
                $PR13 = 0;
                $PR14 = 0;
                $PR15 = 0;
                $tot_pr_outstd = 0;
            } else {
                $PR04 = $outstd_pr->row()->PR04;
                $PR05 = $outstd_pr->row()->PR05;
                $PR06 = $outstd_pr->row()->PR06;
                $PR07 = $outstd_pr->row()->PR07;
                $PR08 = $outstd_pr->row()->PR08;
                $PR09 = $outstd_pr->row()->PR09;
                $PR10 = $outstd_pr->row()->PR10;
                $PR11 = $outstd_pr->row()->PR11;
                $PR12 = $outstd_pr->row()->PR12;
                $PR13 = $outstd_pr->row()->PR13;
                $PR14 = $outstd_pr->row()->PR14;
                $PR15 = $outstd_pr->row()->PR15;
                $tot_pr_outstd = $outstd_pr->row()->PR_TOT;
            }
            
            //Insert Value to Excel Column
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$i, $no);
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$i, $data->CHR_TAHUN_BUDGET);
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$i, $data->CHR_KODE_DEPARTMENT);
            $objPHPExcel->getActiveSheet()->setCellValue('D'.$i, $data->CHR_KODE_SECTION);
            //APRIL
            $objPHPExcel->getActiveSheet()->setCellValue('E'.$i, $data->PBLN04);
            $objPHPExcel->getActiveSheet()->setCellValue('F'.$i, $data->LBLN04);        
            $objPHPExcel->getActiveSheet()->setCellValue('G'.$i, $data->OBLN04);
            $objPHPExcel->getActiveSheet()->setCellValue('H'.$i, $PR04);
            $objPHPExcel->getActiveSheet()->setCellValue('I'.$i, $GR04);
            //MEI
            $objPHPExcel->getActiveSheet()->setCellValue('J'.$i, $data->PBLN05);
            $objPHPExcel->getActiveSheet()->setCellValue('K'.$i, $data->LBLN05);        
            $objPHPExcel->getActiveSheet()->setCellValue('L'.$i, $data->OBLN05);
            $objPHPExcel->getActiveSheet()->setCellValue('M'.$i, $PR05);
            $objPHPExcel->getActiveSheet()->setCellValue('N'.$i, $GR05);
            //JUNI
            $objPHPExcel->getActiveSheet()->setCellValue('O'.$i, $data->PBLN06);
            $objPHPExcel->getActiveSheet()->setCellValue('P'.$i, $data->LBLN06);        
            $objPHPExcel->getActiveSheet()->setCellValue('Q'.$i, $data->OBLN06);
            $objPHPExcel->getActiveSheet()->setCellValue('R'.$i, $PR06);
            $objPHPExcel->getActiveSheet()->setCellValue('S'.$i, $GR06);
            //JULI
            $objPHPExcel->getActiveSheet()->setCellValue('T'.$i, $data->PBLN07);
            $objPHPExcel->getActiveSheet()->setCellValue('U'.$i, $data->LBLN07);        
            $objPHPExcel->getActiveSheet()->setCellValue('V'.$i, $data->OBLN07);
            $objPHPExcel->getActiveSheet()->setCellValue('W'.$i, $PR07);
            $objPHPExcel->getActiveSheet()->setCellValue('X'.$i, $GR07);
            //AGUSTUS
            $objPHPExcel->getActiveSheet()->setCellValue('Y'.$i, $data->PBLN08);
            $objPHPExcel->getActiveSheet()->setCellValue('Z'.$i, $data->LBLN08);        
            $objPHPExcel->getActiveSheet()->setCellValue('AA'.$i, $data->OBLN08);
            $objPHPExcel->getActiveSheet()->setCellValue('AB'.$i, $PR08);
            $objPHPExcel->getActiveSheet()->setCellValue('AC'.$i, $GR08);
            //SEPTEMBER
            $objPHPExcel->getActiveSheet()->setCellValue('AD'.$i, $data->PBLN09);
            $objPHPExcel->getActiveSheet()->setCellValue('AE'.$i, $data->LBLN09);        
            $objPHPExcel->getActiveSheet()->setCellValue('AF'.$i, $data->OBLN09);
            $objPHPExcel->getActiveSheet()->setCellValue('AG'.$i, $PR09);
            $objPHPExcel->getActiveSheet()->setCellValue('AH'.$i, $GR09);
            //OKTOBER
            $objPHPExcel->getActiveSheet()->setCellValue('AI'.$i, $data->PBLN10);
            $objPHPExcel->getActiveSheet()->setCellValue('AJ'.$i, $data->LBLN10);        
            $objPHPExcel->getActiveSheet()->setCellValue('AK'.$i, $data->OBLN10);
            $objPHPExcel->getActiveSheet()->setCellValue('AL'.$i, $PR10);
            $objPHPExcel->getActiveSheet()->setCellValue('AM'.$i, $GR10);
            //NOVEMBER
            $objPHPExcel->getActiveSheet()->setCellValue('AN'.$i, $data->PBLN11);
            $objPHPExcel->getActiveSheet()->setCellValue('AO'.$i, $data->LBLN11);        
            $objPHPExcel->getActiveSheet()->setCellValue('AP'.$i, $data->OBLN11);
            $objPHPExcel->getActiveSheet()->setCellValue('AQ'.$i, $PR11);
            $objPHPExcel->getActiveSheet()->setCellValue('AR'.$i, $GR11);
            //DESEMBER
            $objPHPExcel->getActiveSheet()->setCellValue('AS'.$i, $data->PBLN12);
            $objPHPExcel->getActiveSheet()->setCellValue('AT'.$i, $data->LBLN12);        
            $objPHPExcel->getActiveSheet()->setCellValue('AU'.$i, $data->OBLN12);
            $objPHPExcel->getActiveSheet()->setCellValue('AV'.$i, $PR12);
            $objPHPExcel->getActiveSheet()->setCellValue('AW'.$i, $GR12);
            //JANUARI
            $objPHPExcel->getActiveSheet()->setCellValue('AX'.$i, $data->PBLN13);
            $objPHPExcel->getActiveSheet()->setCellValue('AY'.$i, $data->LBLN13);        
            $objPHPExcel->getActiveSheet()->setCellValue('AZ'.$i, $data->OBLN13);
            $objPHPExcel->getActiveSheet()->setCellValue('BA'.$i, $PR13);
            $objPHPExcel->getActiveSheet()->setCellValue('BB'.$i, $GR13);
            //FEBRUARI
            $objPHPExcel->getActiveSheet()->setCellValue('BC'.$i, $data->PBLN14);
            $objPHPExcel->getActiveSheet()->setCellValue('BD'.$i, $data->LBLN14);        
            $objPHPExcel->getActiveSheet()->setCellValue('BE'.$i, $data->OBLN14);
            $objPHPExcel->getActiveSheet()->setCellValue('BF'.$i, $PR14);
            $objPHPExcel->getActiveSheet()->setCellValue('BG'.$i, $GR14);
            //MARET
            $objPHPExcel->getActiveSheet()->setCellValue('BH'.$i, $data->PBLN15);
            $objPHPExcel->getActiveSheet()->setCellValue('BI'.$i, $data->LBLN15);        
            $objPHPExcel->getActiveSheet()->setCellValue('BJ'.$i, $data->OBLN15);
            $objPHPExcel->getActiveSheet()->setCellValue('BK'.$i, $PR15);
            $objPHPExcel->getActiveSheet()->setCellValue('BL'.$i, $GR15);
            //TOTAL
            // $outstd_pr = $bgt_aii->query("SELECT ISNULL(SUM(MON_TOTAL_PRICE_SUPPLIER),0) AS OUTSTD_PR FROM BDGT_TT_BUDGET_PR_DETAIL
            //                                     WHERE CHR_KODE_TRANSAKSI IN (SELECT CHR_KODE_TRANSAKSI FROM BDGT_TT_BUDGET_PR_HEADER 
            //                                     WHERE CHR_NO_BUDGET LIKE '%$sect%' AND CHR_KODE_TYPE_BUDGET = '$bgt_type' AND CHR_TAHUN_BUDGET = '$fiscal_start' AND CHR_FLG_APPROVE_BOD = '0' AND CHR_FLG_DELETE = '0')")->row();
            
            $tot_plan = $data->PBLN04 + $data->PBLN05 + $data->PBLN06 + $data->PBLN07 + $data->PBLN08 + $data->PBLN09 + $data->PBLN10 + $data->PBLN11 +
                        $data->PBLN12 + $data->PBLN13 + $data->PBLN14 + $data->PBLN15;
            $tot_limit = $data->LBLN04 + $data->LBLN05 + $data->LBLN06 + $data->LBLN07 + $data->LBLN08 + $data->LBLN09 + $data->LBLN10 + $data->LBLN11 +
                        $data->LBLN12 + $data->LBLN13 + $data->LBLN14 + $data->LBLN15;
            $tot_actual = $data->OBLN04 + $data->OBLN05 + $data->OBLN06 + $data->OBLN07 + $data->OBLN08 + $data->OBLN09 + $data->OBLN10 + $data->OBLN11 +
                        $data->OBLN12 + $data->OBLN13 + $data->OBLN14 + $data->OBLN15;
            //$tot_outstd = $outstd_pr->OUTSTD_PR;
            //$saldo = $tot_limit - ($tot_actual + $tot_outstd);
            $saldo = $tot_limit - ($tot_actual + $tot_pr_outstd);
            
            $objPHPExcel->getActiveSheet()->setCellValue('BM'.$i, $tot_plan);
            $objPHPExcel->getActiveSheet()->setCellValue('BN'.$i, $tot_limit);        
            $objPHPExcel->getActiveSheet()->setCellValue('BO'.$i, $tot_actual);
            //$objPHPExcel->getActiveSheet()->setCellValue('BP'.$i, $tot_outstd);
            $objPHPExcel->getActiveSheet()->setCellValue('BP'.$i, $tot_pr_outstd);
            $objPHPExcel->getActiveSheet()->setCellValue('BQ'.$i, $saldo);
            $objPHPExcel->getActiveSheet()->setCellValue('BR'.$i, $tot_gr);
            
            $objPHPExcel->getActiveSheet()->getStyle("A".$i.":D".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle("E".$i.":BR".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $i++;
            $no++;
        }
        
        $x = $i-1;
        $objPHPExcel->getActiveSheet()->setCellValue("E$i", "=SUM(E4:E$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("F$i", "=SUM(F4:F$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("G$i", "=SUM(G4:G$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("H$i", "=SUM(H4:H$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("I$i", "=SUM(I4:I$x)");        
        
        $objPHPExcel->getActiveSheet()->setCellValue("J$i", "=SUM(J4:J$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("K$i", "=SUM(K4:K$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("L$i", "=SUM(L4:L$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("M$i", "=SUM(M4:M$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("N$i", "=SUM(N4:N$x)");
        
        
        $objPHPExcel->getActiveSheet()->setCellValue("O$i", "=SUM(O4:O$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("P$i", "=SUM(P4:P$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("Q$i", "=SUM(Q4:Q$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("R$i", "=SUM(R4:R$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("S$i", "=SUM(S4:S$x)");        
        
        $objPHPExcel->getActiveSheet()->setCellValue("T$i", "=SUM(T4:T$x)");        
        $objPHPExcel->getActiveSheet()->setCellValue("U$i", "=SUM(U4:U$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("V$i", "=SUM(V4:V$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("W$i", "=SUM(W4:W$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("X$i", "=SUM(X4:X$x)");
        
        $objPHPExcel->getActiveSheet()->setCellValue("Y$i", "=SUM(Y4:Y$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("Z$i", "=SUM(Z4:Z$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("AA$i", "=SUM(AA4:AA$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("AB$i", "=SUM(AB4:AB$x)");        
        $objPHPExcel->getActiveSheet()->setCellValue("AC$i", "=SUM(AC4:AC$x)");

        $objPHPExcel->getActiveSheet()->setCellValue("AD$i", "=SUM(AD4:AD$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("AE$i", "=SUM(AE4:AE$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("AF$i", "=SUM(AF4:AF$x)");        
        $objPHPExcel->getActiveSheet()->setCellValue("AG$i", "=SUM(AG4:AG$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("AH$i", "=SUM(AH4:AH$x)");

        $objPHPExcel->getActiveSheet()->setCellValue("AI$i", "=SUM(AI4:AI$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("AJ$i", "=SUM(AJ4:AJ$x)");        
        $objPHPExcel->getActiveSheet()->setCellValue("AK$i", "=SUM(AK4:AK$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("AL$i", "=SUM(AL4:AL$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("AM$i", "=SUM(AM4:AM$x)");

        $objPHPExcel->getActiveSheet()->setCellValue("AN$i", "=SUM(AN4:AN$x)");        
        $objPHPExcel->getActiveSheet()->setCellValue("AO$i", "=SUM(AO4:AO$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("AP$i", "=SUM(AP4:AP$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("AQ$i", "=SUM(AQ4:AQ$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("AR$i", "=SUM(AR4:AR$x)");
        
        $objPHPExcel->getActiveSheet()->setCellValue("AS$i", "=SUM(AS4:AS$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("AT$i", "=SUM(AT4:AT$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("AU$i", "=SUM(AU4:AU$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("AV$i", "=SUM(AV4:AV$x)");        
        $objPHPExcel->getActiveSheet()->setCellValue("AW$i", "=SUM(AW4:AW$x)");

        $objPHPExcel->getActiveSheet()->setCellValue("AX$i", "=SUM(AX4:AX$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("AY$i", "=SUM(AY4:AY$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("AZ$i", "=SUM(AZ4:AZ$x)");        
        $objPHPExcel->getActiveSheet()->setCellValue("BA$i", "=SUM(BA4:BA$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("BB$i", "=SUM(BB4:BB$x)");

        $objPHPExcel->getActiveSheet()->setCellValue("BC$i", "=SUM(BC4:BC$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("BD$i", "=SUM(BD4:BD$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("BE$i", "=SUM(BE4:BE$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("BF$i", "=SUM(BF4:BF$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("BG$i", "=SUM(BG4:BG$x)");

        $objPHPExcel->getActiveSheet()->setCellValue("BH$i", "=SUM(BH4:BH$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("BI$i", "=SUM(BI4:BI$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("BJ$i", "=SUM(BJ4:BJ$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("BK$i", "=SUM(BK4:BK$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("BL$i", "=SUM(BL4:BL$x)");

        $objPHPExcel->getActiveSheet()->setCellValue("BM$i", "=SUM(BM4:BM$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("BN$i", "=SUM(BN4:BN$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("BO$i", "=SUM(BO4:BO$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("BP$i", "=SUM(BP4:BP$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("BQ$i", "=SUM(BQ4:BQ$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("BR$i", "=SUM(BR4:BR$x)");
        
        $styleArray = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                ),
            ),
        );
        
        $styleArray2 = array(
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => '99CCFF')
            )
        );
        
        $styleArray3 = array(
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('argb' => 'CCCCCC')
            )
        );
        
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$i, "TOTAL");
        $objPHPExcel->getActiveSheet()->mergeCells("A$i:D$i");
        $objPHPExcel->getActiveSheet()->getStyle("A".$i.":D".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        $objPHPExcel->getActiveSheet()->getStyle("A2:BR3")->applyFromArray($styleArray2);
        $objPHPExcel->getActiveSheet()->getStyle("A2:BR$i")->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->getStyle("A$i:BR$i")->applyFromArray($styleArray3);
        $objPHPExcel->getActiveSheet()->getStyle("A$i:BR$i")->getFont()->setBold(true);
        
        
        $filename = "Report Budget ". $bgt_type ." by Sect for " . $kode_dept . " " . $fiscal_start . ".xls";
        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . trim($filename) . '"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->setIncludeCharts(TRUE);
        $objWriter->save('php://output');
    }
    
    function export_report_summary_budget_by_dept() {  
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        $this->load->library('excel');        
        
        $fiscal_start = $this->input->post("CHR_FISCAL_DEPT");
        $fiscal_end = $fiscal_start + 1;
        $kode_group = $this->input->post("CHR_GROUP_DEPT");
        $kode_dept = $this->input->post("CHR_DEPT_DEPT");
        $bgt_type = $this->input->post("CHR_BUDGET_TYPE_DEPT");
        
        if($kode_dept == 'ALL'){
            $kode_dept = '';
        }
        
        $list_budget = $this->report_budget_m->get_report_budget_per_dept($fiscal_start, $fiscal_end, $bgt_type, $kode_group, $kode_dept);
//        print_r($list_budget);
//        exit();

        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

        // Set Properties
        $objPHPExcel->getProperties()->setCreator(trim($this->session->userdata('USERNAME')));
        $objPHPExcel->getProperties()->setLastModifiedBy(trim($this->session->userdata('USERNAME')));
        $objPHPExcel->getProperties()->setTitle("REKAP BUDGET");
        $objPHPExcel->getProperties()->setSubject("REKAP BUDGET");
        $objPHPExcel->getProperties()->setDescription("REKAP BUDGET");
                
        //Header TR
        $objPHPExcel->getActiveSheet()->setCellValue('A2', 'NO');        
        $objPHPExcel->getActiveSheet()->setCellValue('B2', 'TAHUN');
        $objPHPExcel->getActiveSheet()->setCellValue('C2', 'DEPARTMENT');
        $objPHPExcel->getActiveSheet()->setCellValue('D2', 'APRIL '.$fiscal_start);
        $objPHPExcel->getActiveSheet()->setCellValue('I2', 'MEI '.$fiscal_start);
        $objPHPExcel->getActiveSheet()->setCellValue('N2', 'JUNI '.$fiscal_start);
        $objPHPExcel->getActiveSheet()->setCellValue('S2', 'JULI '.$fiscal_start);
        $objPHPExcel->getActiveSheet()->setCellValue('X2', 'AGUSTUS '.$fiscal_start);
        $objPHPExcel->getActiveSheet()->setCellValue('AC2', 'SEPTEMBER '.$fiscal_start);
        $objPHPExcel->getActiveSheet()->setCellValue('AH2', 'OKTOBER '.$fiscal_start);
        $objPHPExcel->getActiveSheet()->setCellValue('AM2', 'NOVEMBER '.$fiscal_start);
        $objPHPExcel->getActiveSheet()->setCellValue('AR2', 'DESEMBER '.$fiscal_start);
        $objPHPExcel->getActiveSheet()->setCellValue('AW2', 'JANUARI '.$fiscal_end);
        $objPHPExcel->getActiveSheet()->setCellValue('BA2', 'FEBRUARI '.$fiscal_end);
        $objPHPExcel->getActiveSheet()->setCellValue('BG2', 'MARET '.$fiscal_end);
        $objPHPExcel->getActiveSheet()->setCellValue('BL2', 'TOTAL AMOUNT');
        
        $objPHPExcel->getActiveSheet()->getStyle("A2:BQ2")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        $objPHPExcel->getActiveSheet()->mergeCells('A2:A3');
        $objPHPExcel->getActiveSheet()->mergeCells('B2:B3');
        $objPHPExcel->getActiveSheet()->mergeCells('C2:C3');
        $objPHPExcel->getActiveSheet()->mergeCells('D2:H2');
        $objPHPExcel->getActiveSheet()->mergeCells('I2:M2');
        $objPHPExcel->getActiveSheet()->mergeCells('N2:R2');
        $objPHPExcel->getActiveSheet()->mergeCells('S2:W2');
        $objPHPExcel->getActiveSheet()->mergeCells('X2:AB2');
        $objPHPExcel->getActiveSheet()->mergeCells('AC2:AG2');
        $objPHPExcel->getActiveSheet()->mergeCells('AH2:AL2');
        $objPHPExcel->getActiveSheet()->mergeCells('AM2:AQ2');
        $objPHPExcel->getActiveSheet()->mergeCells('AR2:AV2');
        $objPHPExcel->getActiveSheet()->mergeCells('AW2:BA2');
        $objPHPExcel->getActiveSheet()->mergeCells('BB2:BF2');
        $objPHPExcel->getActiveSheet()->mergeCells('BG2:BK2');
        $objPHPExcel->getActiveSheet()->mergeCells('BL2:BQ2');
        
        //APRIL
        $objPHPExcel->getActiveSheet()->setCellValue('D3', 'PLAN');        
        $objPHPExcel->getActiveSheet()->setCellValue('E3', 'LIMIT');
        $objPHPExcel->getActiveSheet()->setCellValue('F3', 'ACTUAL PR');
        $objPHPExcel->getActiveSheet()->setCellValue('G3', 'OUTSTD PR');
        $objPHPExcel->getActiveSheet()->setCellValue('H3', 'ACTUAL GR');
        //MEI
        $objPHPExcel->getActiveSheet()->setCellValue('I3', 'PLAN');
        $objPHPExcel->getActiveSheet()->setCellValue('J3', 'LIMIT');
        $objPHPExcel->getActiveSheet()->setCellValue('K3', 'ACTUAL PR');
        $objPHPExcel->getActiveSheet()->setCellValue('L3', 'OUTSTD PR');
        $objPHPExcel->getActiveSheet()->setCellValue('M3', 'ACTUAL GR');
        //JUNI
        $objPHPExcel->getActiveSheet()->setCellValue('N3', 'PLAN');
        $objPHPExcel->getActiveSheet()->setCellValue('O3', 'LIMIT');
        $objPHPExcel->getActiveSheet()->setCellValue('P3', 'ACTUAL PR');
        $objPHPExcel->getActiveSheet()->setCellValue('Q3', 'OUTSTD PR');
        $objPHPExcel->getActiveSheet()->setCellValue('R3', 'ACTUAL GR');
        //JULI
        $objPHPExcel->getActiveSheet()->setCellValue('S3', 'PLAN');
        $objPHPExcel->getActiveSheet()->setCellValue('T3', 'LIMIT');
        $objPHPExcel->getActiveSheet()->setCellValue('U3', 'ACTUAL PR');
        $objPHPExcel->getActiveSheet()->setCellValue('V3', 'OUTSTD PR');
        $objPHPExcel->getActiveSheet()->setCellValue('W3', 'ACTUAL GR');
        //AGUSTUS
        $objPHPExcel->getActiveSheet()->setCellValue('X3', 'PLAN');
        $objPHPExcel->getActiveSheet()->setCellValue('Y3', 'LIMIT');
        $objPHPExcel->getActiveSheet()->setCellValue('Z3', 'ACTUAL PR');
        $objPHPExcel->getActiveSheet()->setCellValue('AA3', 'OUTSTD PR');
        $objPHPExcel->getActiveSheet()->setCellValue('AB3', 'ACTUAL GR');
        //SEPTEMBER
        $objPHPExcel->getActiveSheet()->setCellValue('AC3', 'PLAN');
        $objPHPExcel->getActiveSheet()->setCellValue('AD3', 'LIMIT');
        $objPHPExcel->getActiveSheet()->setCellValue('AE3', 'ACTUAL PR');
        $objPHPExcel->getActiveSheet()->setCellValue('AF3', 'OUTSTD PR');
        $objPHPExcel->getActiveSheet()->setCellValue('AG3', 'ACTUAL GR');
        //OKTOBER
        $objPHPExcel->getActiveSheet()->setCellValue('AH3', 'PLAN');
        $objPHPExcel->getActiveSheet()->setCellValue('AI3', 'LIMIT');
        $objPHPExcel->getActiveSheet()->setCellValue('AJ3', 'ACTUAL PR');
        $objPHPExcel->getActiveSheet()->setCellValue('AK3', 'OUTSTD PR');
        $objPHPExcel->getActiveSheet()->setCellValue('AL3', 'ACTUAL GR');
        //NOVEMBER
        $objPHPExcel->getActiveSheet()->setCellValue('AM3', 'PLAN');
        $objPHPExcel->getActiveSheet()->setCellValue('AN3', 'LIMIT');
        $objPHPExcel->getActiveSheet()->setCellValue('AO3', 'ACTUAL PR');
        $objPHPExcel->getActiveSheet()->setCellValue('AP3', 'OUTSTD PR');
        $objPHPExcel->getActiveSheet()->setCellValue('AQ3', 'ACTUAL GR');
        //DESEMBER
        $objPHPExcel->getActiveSheet()->setCellValue('AR3', 'PLAN');
        $objPHPExcel->getActiveSheet()->setCellValue('AS3', 'LIMIT');
        $objPHPExcel->getActiveSheet()->setCellValue('AT3', 'ACTUAL PR');
        $objPHPExcel->getActiveSheet()->setCellValue('AU3', 'OUTSTD PR');
        $objPHPExcel->getActiveSheet()->setCellValue('AV3', 'ACTUAL GR');
        //JANUARI
        $objPHPExcel->getActiveSheet()->setCellValue('AW3', 'PLAN');
        $objPHPExcel->getActiveSheet()->setCellValue('AX3', 'LIMIT');
        $objPHPExcel->getActiveSheet()->setCellValue('AY3', 'ACTUAL PR');
        $objPHPExcel->getActiveSheet()->setCellValue('AZ3', 'OUTSTD PR');
        $objPHPExcel->getActiveSheet()->setCellValue('BA3', 'ACTUAL GR');
        //FEBRUARI
        $objPHPExcel->getActiveSheet()->setCellValue('BB3', 'PLAN');
        $objPHPExcel->getActiveSheet()->setCellValue('BC3', 'LIMIT');
        $objPHPExcel->getActiveSheet()->setCellValue('BD3', 'ACTUAL PR');
        $objPHPExcel->getActiveSheet()->setCellValue('BE3', 'OUTSTD PR');
        $objPHPExcel->getActiveSheet()->setCellValue('BF3', 'ACTUAL GR');
        //MARET
        $objPHPExcel->getActiveSheet()->setCellValue('BG3', 'PLAN');
        $objPHPExcel->getActiveSheet()->setCellValue('BH3', 'LIMIT');
        $objPHPExcel->getActiveSheet()->setCellValue('BI3', 'ACTUAL PR');
        $objPHPExcel->getActiveSheet()->setCellValue('BJ3', 'OUTSTD PR');
        $objPHPExcel->getActiveSheet()->setCellValue('BK3', 'ACTUAL GR');
        //TOTAL
        $objPHPExcel->getActiveSheet()->setCellValue('BL3', 'PLAN');
        $objPHPExcel->getActiveSheet()->setCellValue('BM3', 'LIMIT');
        $objPHPExcel->getActiveSheet()->setCellValue('BN3', 'ACTUAL PR');
        $objPHPExcel->getActiveSheet()->setCellValue('BO3', 'OUTSTD PR');
        $objPHPExcel->getActiveSheet()->setCellValue('BP3', 'SALDO');
        $objPHPExcel->getActiveSheet()->setCellValue('Bq3', 'ACTUAL GR');
        
        $objPHPExcel->getActiveSheet()->getStyle("E3:BQ3")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A2:BQ3')->getFont()->setBold(true)->setSize(12);
        
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(6); $objPHPExcel->getActiveSheet()->getColumnDimension('AA')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10); $objPHPExcel->getActiveSheet()->getColumnDimension('AB')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20); $objPHPExcel->getActiveSheet()->getColumnDimension('AC')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15); $objPHPExcel->getActiveSheet()->getColumnDimension('AD')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15); $objPHPExcel->getActiveSheet()->getColumnDimension('AE')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15); $objPHPExcel->getActiveSheet()->getColumnDimension('AF')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15); $objPHPExcel->getActiveSheet()->getColumnDimension('AG')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15); $objPHPExcel->getActiveSheet()->getColumnDimension('AH')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15); $objPHPExcel->getActiveSheet()->getColumnDimension('AI')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(15); $objPHPExcel->getActiveSheet()->getColumnDimension('AJ')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(15); $objPHPExcel->getActiveSheet()->getColumnDimension('AK')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(15); $objPHPExcel->getActiveSheet()->getColumnDimension('AL')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(15); $objPHPExcel->getActiveSheet()->getColumnDimension('AM')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(15); $objPHPExcel->getActiveSheet()->getColumnDimension('AN')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(15); $objPHPExcel->getActiveSheet()->getColumnDimension('AO')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(15); $objPHPExcel->getActiveSheet()->getColumnDimension('AP')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(15); $objPHPExcel->getActiveSheet()->getColumnDimension('AQ')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(15); $objPHPExcel->getActiveSheet()->getColumnDimension('AR')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(15); $objPHPExcel->getActiveSheet()->getColumnDimension('AS')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('T')->setWidth(15); $objPHPExcel->getActiveSheet()->getColumnDimension('AT')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('U')->setWidth(15); $objPHPExcel->getActiveSheet()->getColumnDimension('AU')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('V')->setWidth(15); $objPHPExcel->getActiveSheet()->getColumnDimension('AV')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('W')->setWidth(15); $objPHPExcel->getActiveSheet()->getColumnDimension('AW')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('X')->setWidth(15); $objPHPExcel->getActiveSheet()->getColumnDimension('AX')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('Y')->setWidth(15); $objPHPExcel->getActiveSheet()->getColumnDimension('AY')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('Z')->setWidth(15); $objPHPExcel->getActiveSheet()->getColumnDimension('AZ')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BA')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BB')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BC')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BD')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BE')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BF')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BG')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BH')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BI')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BJ')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BK')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BL')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BM')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BN')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BO')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BP')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BQ')->setWidth(15);

        
        //Value of All Cells
        $i = 4;
        $no = 1;
        foreach($list_budget as $data){
            if ($bgt_type == 'CAPEX'){
                $GRBLN = $bgt_aii->query("EXEC zsp_get_gr_capex_by_dept '$fiscal_start', '$fiscal_end' , '$kode_group', '" . $data->CHR_KODE_DEPARTMENT . "', ''");
            } else {
                $GRBLN = $bgt_aii->query("EXEC zsp_get_gr_expense_by_dept '$fiscal_start', '$fiscal_end' , '$bgt_type' , '$kode_group', '" . $data->CHR_KODE_DEPARTMENT . "', ''");
            }

            if($GRBLN->num_rows() == 0){
                $GR04 = 0;
                $GR05 = 0;
                $GR06 = 0;
                $GR07 = 0;
                $GR08 = 0;
                $GR09 = 0;
                $GR10 = 0;
                $GR11 = 0;
                $GR12 = 0;
                $GR13 = 0;
                $GR14 = 0;
                $GR15 = 0;
                $tot_gr = 0;
            } else {
                $GR04 = $GRBLN->row()->GRBLN04;
                $GR05 = $GRBLN->row()->GRBLN05;
                $GR06 = $GRBLN->row()->GRBLN06;
                $GR07 = $GRBLN->row()->GRBLN07;
                $GR08 = $GRBLN->row()->GRBLN08;
                $GR09 = $GRBLN->row()->GRBLN09;
                $GR10 = $GRBLN->row()->GRBLN10;
                $GR11 = $GRBLN->row()->GRBLN11;
                $GR12 = $GRBLN->row()->GRBLN12;
                $GR13 = $GRBLN->row()->GRBLN13;
                $GR14 = $GRBLN->row()->GRBLN14;
                $GR15 = $GRBLN->row()->GRBLN15;
                $tot_gr = $GRBLN->row()->TOT_GR;
            }

            $outstd_pr = $this->report_budget_m->get_pr_outstanding_by_dept($fiscal_start, $fiscal_end, $bgt_type, $kode_group, $data->CHR_KODE_DEPARTMENT);
            if($outstd_pr->num_rows() == 0){
                $PR04 = 0;
                $PR05 = 0;
                $PR06 = 0;
                $PR07 = 0;
                $PR08 = 0;
                $PR09 = 0;
                $PR10 = 0;
                $PR11 = 0;
                $PR12 = 0;
                $PR13 = 0;
                $PR14 = 0;
                $PR15 = 0;
                $tot_pr_outstd = 0;
            } else {
                $PR04 = $outstd_pr->row()->PR04;
                $PR05 = $outstd_pr->row()->PR05;
                $PR06 = $outstd_pr->row()->PR06;
                $PR07 = $outstd_pr->row()->PR07;
                $PR08 = $outstd_pr->row()->PR08;
                $PR09 = $outstd_pr->row()->PR09;
                $PR10 = $outstd_pr->row()->PR10;
                $PR11 = $outstd_pr->row()->PR11;
                $PR12 = $outstd_pr->row()->PR12;
                $PR13 = $outstd_pr->row()->PR13;
                $PR14 = $outstd_pr->row()->PR14;
                $PR15 = $outstd_pr->row()->PR15;
                $tot_pr_outstd = $outstd_pr->row()->PR_TOT;
            }
            
            //Insert Value to Excel Column
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$i, $no);
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$i, $data->CHR_TAHUN_BUDGET);
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$i, $data->CHR_KODE_DEPARTMENT);
            //APRIL
            $objPHPExcel->getActiveSheet()->setCellValue('D'.$i, $data->PBLN04);
            $objPHPExcel->getActiveSheet()->setCellValue('E'.$i, $data->LBLN04);        
            $objPHPExcel->getActiveSheet()->setCellValue('F'.$i, $data->OBLN04);
            $objPHPExcel->getActiveSheet()->setCellValue('G'.$i, $PR04);
            $objPHPExcel->getActiveSheet()->setCellValue('H'.$i, $GR04);
            //MEI
            $objPHPExcel->getActiveSheet()->setCellValue('I'.$i, $data->PBLN05);
            $objPHPExcel->getActiveSheet()->setCellValue('J'.$i, $data->LBLN05);        
            $objPHPExcel->getActiveSheet()->setCellValue('K'.$i, $data->OBLN05);
            $objPHPExcel->getActiveSheet()->setCellValue('L'.$i, $PR05);
            $objPHPExcel->getActiveSheet()->setCellValue('M'.$i, $GR05);
            //JUNI
            $objPHPExcel->getActiveSheet()->setCellValue('N'.$i, $data->PBLN06);
            $objPHPExcel->getActiveSheet()->setCellValue('O'.$i, $data->LBLN06);        
            $objPHPExcel->getActiveSheet()->setCellValue('P'.$i, $data->OBLN06);
            $objPHPExcel->getActiveSheet()->setCellValue('Q'.$i, $PR06);
            $objPHPExcel->getActiveSheet()->setCellValue('R'.$i, $GR06);
            //JULI
            $objPHPExcel->getActiveSheet()->setCellValue('S'.$i, $data->PBLN07);
            $objPHPExcel->getActiveSheet()->setCellValue('T'.$i, $data->LBLN07);        
            $objPHPExcel->getActiveSheet()->setCellValue('U'.$i, $data->OBLN07);
            $objPHPExcel->getActiveSheet()->setCellValue('V'.$i, $PR07);
            $objPHPExcel->getActiveSheet()->setCellValue('W'.$i, $GR07);
            //AGUSTUS
            $objPHPExcel->getActiveSheet()->setCellValue('X'.$i, $data->PBLN08);
            $objPHPExcel->getActiveSheet()->setCellValue('Y'.$i, $data->LBLN08);        
            $objPHPExcel->getActiveSheet()->setCellValue('Z'.$i, $data->OBLN08);
            $objPHPExcel->getActiveSheet()->setCellValue('AA'.$i, $PR08);
            $objPHPExcel->getActiveSheet()->setCellValue('AB'.$i, $GR08);
            //SEPTEMBER
            $objPHPExcel->getActiveSheet()->setCellValue('AC'.$i, $data->PBLN09);
            $objPHPExcel->getActiveSheet()->setCellValue('AD'.$i, $data->LBLN09);        
            $objPHPExcel->getActiveSheet()->setCellValue('AE'.$i, $data->OBLN09);
            $objPHPExcel->getActiveSheet()->setCellValue('AF'.$i, $PR09);
            $objPHPExcel->getActiveSheet()->setCellValue('AG'.$i, $GR09);
            //OKTOBER
            $objPHPExcel->getActiveSheet()->setCellValue('AH'.$i, $data->PBLN10);
            $objPHPExcel->getActiveSheet()->setCellValue('AI'.$i, $data->LBLN10);        
            $objPHPExcel->getActiveSheet()->setCellValue('AJ'.$i, $data->OBLN10);
            $objPHPExcel->getActiveSheet()->setCellValue('AK'.$i, $PR10);
            $objPHPExcel->getActiveSheet()->setCellValue('AL'.$i, $GR10);
            //NOVEMBER
            $objPHPExcel->getActiveSheet()->setCellValue('AM'.$i, $data->PBLN11);
            $objPHPExcel->getActiveSheet()->setCellValue('AN'.$i, $data->LBLN11);        
            $objPHPExcel->getActiveSheet()->setCellValue('AO'.$i, $data->OBLN11);
            $objPHPExcel->getActiveSheet()->setCellValue('AP'.$i, $PR11);
            $objPHPExcel->getActiveSheet()->setCellValue('AQ'.$i, $GR11);
            //DESEMBER
            $objPHPExcel->getActiveSheet()->setCellValue('AR'.$i, $data->PBLN12);
            $objPHPExcel->getActiveSheet()->setCellValue('AS'.$i, $data->LBLN12);        
            $objPHPExcel->getActiveSheet()->setCellValue('AT'.$i, $data->OBLN12);
            $objPHPExcel->getActiveSheet()->setCellValue('AU'.$i, $PR12);
            $objPHPExcel->getActiveSheet()->setCellValue('AV'.$i, $GR12);
            //JANUARI
            $objPHPExcel->getActiveSheet()->setCellValue('AW'.$i, $data->PBLN13);
            $objPHPExcel->getActiveSheet()->setCellValue('AX'.$i, $data->LBLN13);        
            $objPHPExcel->getActiveSheet()->setCellValue('AY'.$i, $data->OBLN13);
            $objPHPExcel->getActiveSheet()->setCellValue('AZ'.$i, $PR13);
            $objPHPExcel->getActiveSheet()->setCellValue('BA'.$i, $GR13);
            //FEBRUARI
            $objPHPExcel->getActiveSheet()->setCellValue('BB'.$i, $data->PBLN14);
            $objPHPExcel->getActiveSheet()->setCellValue('BC'.$i, $data->LBLN14);        
            $objPHPExcel->getActiveSheet()->setCellValue('BD'.$i, $data->OBLN14);
            $objPHPExcel->getActiveSheet()->setCellValue('BE'.$i, $PR14);
            $objPHPExcel->getActiveSheet()->setCellValue('BF'.$i, $GR14);
            //MARET
            $objPHPExcel->getActiveSheet()->setCellValue('BG'.$i, $data->PBLN15);
            $objPHPExcel->getActiveSheet()->setCellValue('BH'.$i, $data->LBLN15);        
            $objPHPExcel->getActiveSheet()->setCellValue('BI'.$i, $data->OBLN15);
            $objPHPExcel->getActiveSheet()->setCellValue('BJ'.$i, $PR15);
            $objPHPExcel->getActiveSheet()->setCellValue('BK'.$i, $GR15);
            //TOTAL
            $tot_plan = $data->PBLN04 + $data->PBLN05 + $data->PBLN06 + $data->PBLN07 + $data->PBLN08 + $data->PBLN09 + $data->PBLN10 + $data->PBLN11 +
                        $data->PBLN12 + $data->PBLN13 + $data->PBLN14 + $data->PBLN15;
            $tot_limit = $data->LBLN04 + $data->LBLN05 + $data->LBLN06 + $data->LBLN07 + $data->LBLN08 + $data->LBLN09 + $data->LBLN10 + $data->LBLN11 +
                        $data->LBLN12 + $data->LBLN13 + $data->LBLN14 + $data->LBLN15;
            $tot_actual = $data->OBLN04 + $data->OBLN05 + $data->OBLN06 + $data->OBLN07 + $data->OBLN08 + $data->OBLN09 + $data->OBLN10 + $data->OBLN11 +
                        $data->OBLN12 + $data->OBLN13 + $data->OBLN14 + $data->OBLN15;

            $saldo = $tot_limit - ($tot_actual + $tot_pr_outstd);
            
            $objPHPExcel->getActiveSheet()->setCellValue('BL'.$i, $tot_plan);
            $objPHPExcel->getActiveSheet()->setCellValue('BM'.$i, $tot_limit);        
            $objPHPExcel->getActiveSheet()->setCellValue('BN'.$i, $tot_actual);
            $objPHPExcel->getActiveSheet()->setCellValue('BO'.$i, $tot_pr_outstd);
            $objPHPExcel->getActiveSheet()->setCellValue('BP'.$i, $saldo);
            $objPHPExcel->getActiveSheet()->setCellValue('BQ'.$i, $tot_gr);
            
            $objPHPExcel->getActiveSheet()->getStyle("A".$i.":C".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle("D".$i.":BC".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $i++;
            $no++;
        }
        
        $x = $i-1;
        $objPHPExcel->getActiveSheet()->setCellValue("D$i", "=SUM(D4:D$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("E$i", "=SUM(E4:E$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("F$i", "=SUM(F4:F$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("G$i", "=SUM(G4:G$x)");        
        $objPHPExcel->getActiveSheet()->setCellValue("H$i", "=SUM(H4:H$x)");

        $objPHPExcel->getActiveSheet()->setCellValue("I$i", "=SUM(I4:I$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("J$i", "=SUM(J4:J$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("K$i", "=SUM(K4:K$x)");        
        $objPHPExcel->getActiveSheet()->setCellValue("L$i", "=SUM(L4:L$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("M$i", "=SUM(M4:M$x)");

        $objPHPExcel->getActiveSheet()->setCellValue("N$i", "=SUM(N4:N$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("O$i", "=SUM(O4:O$x)");        
        $objPHPExcel->getActiveSheet()->setCellValue("P$i", "=SUM(P4:P$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("Q$i", "=SUM(Q4:Q$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("R$i", "=SUM(R4:R$x)");

        $objPHPExcel->getActiveSheet()->setCellValue("S$i", "=SUM(S4:S$x)");        
        $objPHPExcel->getActiveSheet()->setCellValue("T$i", "=SUM(T4:T$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("U$i", "=SUM(U4:U$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("V$i", "=SUM(V4:V$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("W$i", "=SUM(W4:W$x)");
        
        $objPHPExcel->getActiveSheet()->setCellValue("X$i", "=SUM(X4:X$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("Y$i", "=SUM(Y4:Y$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("Z$i", "=SUM(Z4:Z$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("AA$i", "=SUM(AA4:AA$x)");        
        $objPHPExcel->getActiveSheet()->setCellValue("AB$i", "=SUM(AB4:AB$x)");

        $objPHPExcel->getActiveSheet()->setCellValue("AC$i", "=SUM(AC4:AC$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("AD$i", "=SUM(AD4:AD$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("AE$i", "=SUM(AE4:AE$x)");        
        $objPHPExcel->getActiveSheet()->setCellValue("AF$i", "=SUM(AF4:AF$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("AG$i", "=SUM(AG4:AG$x)");

        $objPHPExcel->getActiveSheet()->setCellValue("AH$i", "=SUM(AH4:AH$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("AI$i", "=SUM(AI4:AI$x)");        
        $objPHPExcel->getActiveSheet()->setCellValue("AJ$i", "=SUM(AJ4:AJ$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("AK$i", "=SUM(AK4:AK$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("AL$i", "=SUM(AL4:AL$x)");

        $objPHPExcel->getActiveSheet()->setCellValue("AM$i", "=SUM(AM4:AM$x)");        
        $objPHPExcel->getActiveSheet()->setCellValue("AN$i", "=SUM(AN4:AN$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("AO$i", "=SUM(AO4:AO$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("AP$i", "=SUM(AP4:AP$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("AQ$i", "=SUM(AQ4:AQ$x)");
        
        $objPHPExcel->getActiveSheet()->setCellValue("AR$i", "=SUM(AR4:AR$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("AS$i", "=SUM(AS4:AS$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("AT$i", "=SUM(AT4:AT$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("AU$i", "=SUM(AU4:AU$x)");        
        $objPHPExcel->getActiveSheet()->setCellValue("AV$i", "=SUM(AV4:AV$x)");

        $objPHPExcel->getActiveSheet()->setCellValue("AW$i", "=SUM(AW4:AW$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("AX$i", "=SUM(AX4:AX$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("AY$i", "=SUM(AY4:AY$x)");        
        $objPHPExcel->getActiveSheet()->setCellValue("AZ$i", "=SUM(AZ4:AZ$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("BA$i", "=SUM(BA4:BA$x)");

        $objPHPExcel->getActiveSheet()->setCellValue("BB$i", "=SUM(BB4:BB$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("BC$i", "=SUM(BC4:BC$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("BD$i", "=SUM(BD4:BD$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("BE$i", "=SUM(BE4:BE$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("BF$i", "=SUM(BF4:BF$x)");
        
        $objPHPExcel->getActiveSheet()->setCellValue("BG$i", "=SUM(BG4:BG$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("BH$i", "=SUM(BH4:BH$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("BI$i", "=SUM(BI4:BI$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("BJ$i", "=SUM(BJ4:BJ$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("BK$i", "=SUM(BK4:BK$x)");

        $objPHPExcel->getActiveSheet()->setCellValue("BL$i", "=SUM(BL4:BL$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("BM$i", "=SUM(BM4:BM$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("BN$i", "=SUM(BN4:BN$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("BO$i", "=SUM(BO4:BO$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("BP$i", "=SUM(BP4:BP$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("BQ$i", "=SUM(BQ4:BQ$x)");
        
        $styleArray = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                ),
            ),
        );
        
        $styleArray2 = array(
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => '99CCFF')
            )
        );
        
        $styleArray3 = array(
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('argb' => 'CCCCCC')
            )
        );
        
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$i, "TOTAL");
        $objPHPExcel->getActiveSheet()->mergeCells("A$i:C$i");
        $objPHPExcel->getActiveSheet()->getStyle("A".$i.":C".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                
        $objPHPExcel->getActiveSheet()->getStyle("A2:BQ3")->applyFromArray($styleArray2);
        $objPHPExcel->getActiveSheet()->getStyle("A2:BQ$i")->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->getStyle("A$i:BQ$i")->applyFromArray($styleArray3);
        $objPHPExcel->getActiveSheet()->getStyle("A$i:BQ$i")->getFont()->setBold(true);
        
        $filename = "Report Budget ". $bgt_type ." by Dept for " . $kode_dept . " " . $fiscal_start . ".xls";
        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . trim($filename) . '"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->setIncludeCharts(TRUE);
        $objWriter->save('php://output');
    }

    function export_report_usage_budget() {        
        $this->load->library('excel');
        
        $fiscal_start = $this->input->post("CHR_FISCAL_EXP");
        $kode_dept = $this->input->post("CHR_DEPT_EXP");
        $kode_sect = $this->input->post("CHR_SECT_EXP");
        $bgt_type = $this->input->post("CHR_BUDGET_TYPE_EXP");
        
        $list_usage_budget = $this->report_budget_m->get_usage_budget($fiscal_start, $bgt_type, $kode_dept, $kode_sect);
//        print_r($list_usage_budget);
//        exit();

        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

        // Set Properties
        $objPHPExcel->getProperties()->setCreator(trim($this->session->userdata('USERNAME')));
        $objPHPExcel->getProperties()->setLastModifiedBy(trim($this->session->userdata('USERNAME')));
        $objPHPExcel->getProperties()->setTitle("REKAP PENGGUNAAN BUDGET");
        $objPHPExcel->getProperties()->setSubject("REKAP PENGGUNAAN BUDGET");
        $objPHPExcel->getProperties()->setDescription("REKAP PENGGUNAAN BUDGET");
                
        //Header TR
        $objPHPExcel->getActiveSheet()->setCellValue('A2', 'NO');
        $objPHPExcel->getActiveSheet()->getStyle("A2")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('B2', 'DEPT');
        $objPHPExcel->getActiveSheet()->getStyle("B2")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('C2', 'NO BUDGET');
        $objPHPExcel->getActiveSheet()->getStyle("C2")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('D2', 'DESCRIPTION');
        $objPHPExcel->getActiveSheet()->getStyle("D2")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('E2', 'BUDGET PLAN');
        $objPHPExcel->getActiveSheet()->getStyle("E2")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('F2', 'APPROVAL SHEET');
        $objPHPExcel->getActiveSheet()->getStyle("F2")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('G2', 'PURCHASE PART');
        $objPHPExcel->getActiveSheet()->getStyle("G2")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('H2', 'QUANTITY');
        $objPHPExcel->getActiveSheet()->getStyle("H2")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('I2', 'UNIT');
        $objPHPExcel->getActiveSheet()->getStyle("I2")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('J2', 'AMOUNT/UNIT');
        $objPHPExcel->getActiveSheet()->getStyle("J2")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('K2', 'TOTAL AMOUNT');
        $objPHPExcel->getActiveSheet()->getStyle("K2")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('L2', 'STATUS');
        $objPHPExcel->getActiveSheet()->getStyle("L2")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('M2', 'TGL TRANSAKSI');
        $objPHPExcel->getActiveSheet()->getStyle("M2")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('N2', 'TGL EST KEDATANGAN');
        $objPHPExcel->getActiveSheet()->getStyle("N2")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('O2', 'STATUS GR');
        $objPHPExcel->getActiveSheet()->getStyle("O2")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
        $objPHPExcel->getActiveSheet()->setCellValue('P2', 'TGL GR');
        $objPHPExcel->getActiveSheet()->getStyle("P2")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
                

        $objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true)->setSize(12);
        $objPHPExcel->getActiveSheet()->getStyle('B2')->getFont()->setBold(true)->setSize(12);
        $objPHPExcel->getActiveSheet()->getStyle('C2')->getFont()->setBold(true)->setSize(12);
        $objPHPExcel->getActiveSheet()->getStyle('D2')->getFont()->setBold(true)->setSize(12);
        $objPHPExcel->getActiveSheet()->getStyle('E2')->getFont()->setBold(true)->setSize(12);
        $objPHPExcel->getActiveSheet()->getStyle('F2')->getFont()->setBold(true)->setSize(12);
        $objPHPExcel->getActiveSheet()->getStyle('G2')->getFont()->setBold(true)->setSize(12);
        $objPHPExcel->getActiveSheet()->getStyle('H2')->getFont()->setBold(true)->setSize(12);
        $objPHPExcel->getActiveSheet()->getStyle('I2')->getFont()->setBold(true)->setSize(12);
        $objPHPExcel->getActiveSheet()->getStyle('J2')->getFont()->setBold(true)->setSize(12);
        $objPHPExcel->getActiveSheet()->getStyle('K2')->getFont()->setBold(true)->setSize(12);
        $objPHPExcel->getActiveSheet()->getStyle('L2')->getFont()->setBold(true)->setSize(12);
        $objPHPExcel->getActiveSheet()->getStyle('M2')->getFont()->setBold(true)->setSize(12);
        $objPHPExcel->getActiveSheet()->getStyle('N2')->getFont()->setBold(true)->setSize(12);
        $objPHPExcel->getActiveSheet()->getStyle('O2')->getFont()->setBold(true)->setSize(12);
        $objPHPExcel->getActiveSheet()->getStyle('P2')->getFont()->setBold(true)->setSize(12);
        
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(6);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(15);
        
        //Value of All Cells
        $i = 3;
        $no = 1;
        foreach($list_usage_budget as $data){
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$i, $no);
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$i, $data->CHR_KODE_DEPARTMENT);
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$i, $data->CHR_NO_BUDGET);
            $objPHPExcel->getActiveSheet()->setCellValue('D'.$i, $data->CHR_PURCHASE_PART);
            $objPHPExcel->getActiveSheet()->setCellValue('E'.$i, $data->MON_AMOUNT_BUDGET);
            $objPHPExcel->getActiveSheet()->setCellValue('F'.$i, $data->CHR_KODE_TRANSAKSI);        
            $objPHPExcel->getActiveSheet()->setCellValue('G'.$i, $data->CHR_PURCHASE_PART);                
            $objPHPExcel->getActiveSheet()->setCellValue('H'.$i, $data->INT_QTY);        
            $objPHPExcel->getActiveSheet()->setCellValue('I'.$i, $data->CHR_UNIT);
            $objPHPExcel->getActiveSheet()->setCellValue('J'.$i, $data->MON_UNIT_PRICE_SUPPLIER);        
            $objPHPExcel->getActiveSheet()->setCellValue('K'.$i, $data->MON_TOTAL_PRICE_SUPPLIER);
            
            if ($data->CHR_FLG_APPROVE_BOD == '1'){
                $status = 'APPROVED';
            } else {
                $status = '-';
            }
            
            $cek_gr = $this->report_budget_m->cek_status_gr($bgt_type, $data->CHR_KODE_TRANSAKSI, $data->CHR_PURCHASE_PART);
            $match = count($cek_gr);
            if($match == 0){
                $status_gr = '-';
                $date_gr = '-';
            } else {
                $status_gr = 'SUDAH GR';
                $date_gr = $cek_gr->BUDAT;
            }
            
            $objPHPExcel->getActiveSheet()->setCellValue('L'.$i, $status);
            $objPHPExcel->getActiveSheet()->setCellValue('M'.$i, $data->CHR_TGL_TRANS);
            $objPHPExcel->getActiveSheet()->setCellValue('N'.$i, $data->CHR_TGL_ESTIMASI_KEDATANGAN);
            $objPHPExcel->getActiveSheet()->setCellValue('O'.$i, $status_gr);
            $objPHPExcel->getActiveSheet()->setCellValue('P'.$i, $date_gr);
            
            $objPHPExcel->getActiveSheet()->getStyle("B".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle("C".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle("E".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $objPHPExcel->getActiveSheet()->getStyle("F".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle("H".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $objPHPExcel->getActiveSheet()->getStyle("I".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle("J".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $objPHPExcel->getActiveSheet()->getStyle("K".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $objPHPExcel->getActiveSheet()->getStyle("L".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle("M".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle("N".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle("O".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle("P".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            
            $i++;
            $no++;
        }
        
        $styleArray = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                ),
            ),
        );
        
        $styleArray2 = array(
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => '99CCFF')
            )
        );
        
        $x = $i-1;
        $objPHPExcel->getActiveSheet()->getStyle("A2:P$x")->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->getStyle("A2:P2")->applyFromArray($styleArray2);
        
        $filename = "Report Usage Budget ". $bgt_type ." for " . $kode_dept . " " . $fiscal_start . ".xls";
        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . trim($filename) . '"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->setIncludeCharts(TRUE);
        $objWriter->save('php://output');
    }
    
    function new_export_report_usage_budget() {        
        $this->load->library('excel');
        
        $fiscal_start = $this->input->post("CHR_FISCAL_EXP");
        $kode_dept = $this->input->post("CHR_DEPT_EXP");
        $kode_sect = $this->input->post("CHR_SECT_EXP");
        $bgt_type = $this->input->post("CHR_BUDGET_TYPE_EXP");
        
        $list_pr_header = $this->report_budget_m->get_list_pr_header($fiscal_start, $bgt_type, $kode_dept);

        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

        // Set Properties
        $objPHPExcel->getProperties()->setCreator(trim($this->session->userdata('USERNAME')));
        $objPHPExcel->getProperties()->setLastModifiedBy(trim($this->session->userdata('USERNAME')));
        $objPHPExcel->getProperties()->setTitle("REKAP PENGGUNAAN BUDGET");
        $objPHPExcel->getProperties()->setSubject("REKAP PENGGUNAAN BUDGET");
        $objPHPExcel->getProperties()->setDescription("REKAP PENGGUNAAN BUDGET");
                
        //Header TR
        $objPHPExcel->getActiveSheet()->setCellValue('A2', 'NO');
        $objPHPExcel->getActiveSheet()->getStyle("A2")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('B2', 'DEPT');
        $objPHPExcel->getActiveSheet()->getStyle("B2")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('C2', 'NO BUDGET');
        $objPHPExcel->getActiveSheet()->getStyle("C2")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('D2', 'DESCRIPTION');
        $objPHPExcel->getActiveSheet()->getStyle("D2")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('E2', 'BUDGET PLAN');
        $objPHPExcel->getActiveSheet()->getStyle("E2")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('F2', 'APPROVAL SHEET');
        $objPHPExcel->getActiveSheet()->getStyle("F2")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('G2', 'PURCHASE PART');
        $objPHPExcel->getActiveSheet()->getStyle("G2")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('H2', 'QUANTITY');
        $objPHPExcel->getActiveSheet()->getStyle("H2")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('I2', 'UNIT');
        $objPHPExcel->getActiveSheet()->getStyle("I2")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('J2', 'AMOUNT/UNIT');
        $objPHPExcel->getActiveSheet()->getStyle("J2")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('K2', 'TOTAL AMOUNT');
        $objPHPExcel->getActiveSheet()->getStyle("K2")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('L2', 'STATUS');
        $objPHPExcel->getActiveSheet()->getStyle("L2")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('M2', 'TGL TRANSAKSI');
        $objPHPExcel->getActiveSheet()->getStyle("M2")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('N2', 'TGL EST KEDATANGAN');
        $objPHPExcel->getActiveSheet()->getStyle("N2")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('O2', 'STATUS GR');
        $objPHPExcel->getActiveSheet()->getStyle("O2")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
        $objPHPExcel->getActiveSheet()->setCellValue('P2', 'TGL GR');
        $objPHPExcel->getActiveSheet()->getStyle("P2")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
        $objPHPExcel->getActiveSheet()->setCellValue('Q2', 'REMARK');
        //===== Additional detail approval process - by ANU 20211228
        $objPHPExcel->getActiveSheet()->getStyle("Q2")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('R2', 'DATE MGR');
        $objPHPExcel->getActiveSheet()->getStyle("R2")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('S2', 'DATE GM');
        $objPHPExcel->getActiveSheet()->getStyle("S2")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('T2', 'DATE DIR');
        $objPHPExcel->getActiveSheet()->getStyle("T2")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('U2', 'DATE ACC');
        $objPHPExcel->getActiveSheet()->getStyle("U2")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('V2', 'NO ASSET');
        $objPHPExcel->getActiveSheet()->getStyle("V2")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('W2', 'DATE VP');
        $objPHPExcel->getActiveSheet()->getStyle("W2")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('X2', 'DATE PRESDIR');
        $objPHPExcel->getActiveSheet()->getStyle("X2")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('Y2', 'DATE GUD TOOL');
        $objPHPExcel->getActiveSheet()->getStyle("Y2")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('Z2', 'NO PR');
        $objPHPExcel->getActiveSheet()->getStyle("Z2")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('AA2', 'DATE PURC');
        $objPHPExcel->getActiveSheet()->getStyle("AA2")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('AB2', 'NO PO');
        $objPHPExcel->getActiveSheet()->getStyle("AB2")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        //===== End additional detail approval process - by ANU 20211228                

        $objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true)->setSize(12);
        $objPHPExcel->getActiveSheet()->getStyle('B2')->getFont()->setBold(true)->setSize(12);
        $objPHPExcel->getActiveSheet()->getStyle('C2')->getFont()->setBold(true)->setSize(12);
        $objPHPExcel->getActiveSheet()->getStyle('D2')->getFont()->setBold(true)->setSize(12);
        $objPHPExcel->getActiveSheet()->getStyle('E2')->getFont()->setBold(true)->setSize(12);
        $objPHPExcel->getActiveSheet()->getStyle('F2')->getFont()->setBold(true)->setSize(12);
        $objPHPExcel->getActiveSheet()->getStyle('G2')->getFont()->setBold(true)->setSize(12);
        $objPHPExcel->getActiveSheet()->getStyle('H2')->getFont()->setBold(true)->setSize(12);
        $objPHPExcel->getActiveSheet()->getStyle('I2')->getFont()->setBold(true)->setSize(12);
        $objPHPExcel->getActiveSheet()->getStyle('J2')->getFont()->setBold(true)->setSize(12);
        $objPHPExcel->getActiveSheet()->getStyle('K2')->getFont()->setBold(true)->setSize(12);
        $objPHPExcel->getActiveSheet()->getStyle('L2')->getFont()->setBold(true)->setSize(12);
        $objPHPExcel->getActiveSheet()->getStyle('M2')->getFont()->setBold(true)->setSize(12);
        $objPHPExcel->getActiveSheet()->getStyle('N2')->getFont()->setBold(true)->setSize(12);
        $objPHPExcel->getActiveSheet()->getStyle('O2')->getFont()->setBold(true)->setSize(12);
        $objPHPExcel->getActiveSheet()->getStyle('P2')->getFont()->setBold(true)->setSize(12);
        $objPHPExcel->getActiveSheet()->getStyle('Q2')->getFont()->setBold(true)->setSize(12);
        $objPHPExcel->getActiveSheet()->getStyle('R2')->getFont()->setBold(true)->setSize(12);
        $objPHPExcel->getActiveSheet()->getStyle('S2')->getFont()->setBold(true)->setSize(12);
        $objPHPExcel->getActiveSheet()->getStyle('T2')->getFont()->setBold(true)->setSize(12);
        $objPHPExcel->getActiveSheet()->getStyle('U2')->getFont()->setBold(true)->setSize(12);
        $objPHPExcel->getActiveSheet()->getStyle('V2')->getFont()->setBold(true)->setSize(12);
        $objPHPExcel->getActiveSheet()->getStyle('W2')->getFont()->setBold(true)->setSize(12);
        $objPHPExcel->getActiveSheet()->getStyle('X2')->getFont()->setBold(true)->setSize(12);
        $objPHPExcel->getActiveSheet()->getStyle('Y2')->getFont()->setBold(true)->setSize(12);
        $objPHPExcel->getActiveSheet()->getStyle('Z2')->getFont()->setBold(true)->setSize(12);
        $objPHPExcel->getActiveSheet()->getStyle('AA2')->getFont()->setBold(true)->setSize(12);
        $objPHPExcel->getActiveSheet()->getStyle('AB2')->getFont()->setBold(true)->setSize(12);

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(6);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('T')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('U')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('V')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('W')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('X')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('Y')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('Z')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AA')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AB')->setWidth(15);
        
        //Value of All Cells
        $i = 3;
        $no = 1;
        foreach($list_pr_header as $data){
            $no_transaksi = $data->CHR_KODE_TRANSAKSI;
            $dept = $data->CHR_KODE_DEPARTMENT;
            $no_budget = $data->CHR_NO_BUDGET;
            $amount_budget = $data->MON_AMOUNT_BUDGET;
            
            if($bgt_type == 'CAPEX'){
                $data_budget = $this->report_budget_m->get_no_budget_by_pr($bgt_type, $no_transaksi);
                $no_budget = $data_budget->CHR_NO_BUDGET;
                $amount_budget = $data_budget->TOT_BUDGET;
                $budget_desc = $this->report_budget_m->get_no_budget_by_pr($bgt_type, $no_transaksi)->CHR_DESC_BUDGET;
            } else {
                $budget_desc = $this->report_budget_m->get_no_budget_by_pr($bgt_type, $no_transaksi)->CHR_DESC_BUDGET;
            }
            
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$i, $no);
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$i, $dept);
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$i, $no_budget);
            $objPHPExcel->getActiveSheet()->setCellValue('D'.$i, $budget_desc);
            $objPHPExcel->getActiveSheet()->setCellValue('E'.$i, $amount_budget);
            $objPHPExcel->getActiveSheet()->getStyle("B".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle("C".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle("E".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            
            if ($data->CHR_FLG_APPROVE_BOD == '1'){
                $status = 'APPROVED';
            } else {
                $status = '-';
            }
            
            $list_pr_detail = $this->report_budget_m->get_list_pr_detail($no_transaksi);
            
            foreach ($list_pr_detail as $isi){
                $cek_gr = $this->report_budget_m->cek_status_gr($bgt_type, $isi->CHR_KODE_TRANSAKSI, $isi->CHR_PURCHASE_PART);
                $match = count($cek_gr);
                if($match == 0){
                    $status_gr = '-';
                    $date_gr = '-';
                } else {
                    $status_gr = 'SUDAH GR';
                    $date_gr = $cek_gr->BUDAT;
                }
                
                $objPHPExcel->getActiveSheet()->setCellValue('F'.$i, $isi->CHR_KODE_TRANSAKSI);        
                $objPHPExcel->getActiveSheet()->setCellValue('G'.$i, $isi->CHR_PURCHASE_PART);                
                $objPHPExcel->getActiveSheet()->setCellValue('H'.$i, $isi->INT_QTY);        
                $objPHPExcel->getActiveSheet()->setCellValue('I'.$i, $isi->CHR_UNIT);
                $objPHPExcel->getActiveSheet()->setCellValue('J'.$i, $isi->MON_UNIT_PRICE_SUPPLIER);        
                $objPHPExcel->getActiveSheet()->setCellValue('K'.$i, $isi->MON_TOTAL_PRICE_SUPPLIER);

                $objPHPExcel->getActiveSheet()->setCellValue('L'.$i, $status);
                $objPHPExcel->getActiveSheet()->setCellValue('M'.$i, $isi->CHR_TGL_TRANS);
                $objPHPExcel->getActiveSheet()->setCellValue('N'.$i, $isi->CHR_TGL_ESTIMASI_KEDATANGAN);
                $objPHPExcel->getActiveSheet()->setCellValue('O'.$i, $status_gr);
                $objPHPExcel->getActiveSheet()->setCellValue('P'.$i, $date_gr);
                $objPHPExcel->getActiveSheet()->setCellValue('Q'.$i, $isi->CHR_REMARK);

                //===== Additional detail approval process - by ANU 20211228
                if($data->CHR_FLG_APPROVE_MAN == '1'){
                    $objPHPExcel->getActiveSheet()->setCellValue('R'.$i, $data->CHR_DATE_MAN);
                } else {
                    $objPHPExcel->getActiveSheet()->setCellValue('R'.$i, '-');
                }

                if($data->CHR_FLG_APPROVE_GM == '1'){
                    $objPHPExcel->getActiveSheet()->setCellValue('S'.$i, $data->CHR_DATE_GM);
                } else {
                    $objPHPExcel->getActiveSheet()->setCellValue('S'.$i, '-');
                }

                if($data->CHR_FLG_APPROVE_BOD == '1'){
                    $objPHPExcel->getActiveSheet()->setCellValue('T'.$i, $data->CHR_DATE_BOD);
                } else {
                    $objPHPExcel->getActiveSheet()->setCellValue('T'.$i, '-');
                }

                if($data->CHR_FLG_ACC == '1'){
                    $objPHPExcel->getActiveSheet()->setCellValue('U'.$i, $data->CHR_DATE_ACC);
                    $objPHPExcel->getActiveSheet()->setCellValue('V'.$i, $data->CHR_ASSET_NO);
                } else {
                    $objPHPExcel->getActiveSheet()->setCellValue('U'.$i, '-');
                    $objPHPExcel->getActiveSheet()->setCellValue('V'.$i, '-');
                }

                if($data->CHR_FLG_VP == '1'){
                    $objPHPExcel->getActiveSheet()->setCellValue('W'.$i, $data->CHR_DATE_VP);
                } else {
                    $objPHPExcel->getActiveSheet()->setCellValue('W'.$i, '-');
                }

                if($data->CHR_FLG_PRESDIR == '1'){
                    $objPHPExcel->getActiveSheet()->setCellValue('X'.$i, $data->CHR_DATE_PRESDIR);
                } else {
                    $objPHPExcel->getActiveSheet()->setCellValue('X'.$i, '-');
                }

                if($data->CHR_FLG_GUDTOOL == '1'){
                    $objPHPExcel->getActiveSheet()->setCellValue('Y'.$i, $data->CHR_DATE_GUDTOOL);
                    $objPHPExcel->getActiveSheet()->setCellValue('Z'.$i, $data->CHR_PR_NO);
                } else {
                    $objPHPExcel->getActiveSheet()->setCellValue('Y'.$i, '-');
                    $objPHPExcel->getActiveSheet()->setCellValue('Z'.$i, '-');
                }

                if($data->CHR_FLG_PURC == '1'){
                    $objPHPExcel->getActiveSheet()->setCellValue('AA'.$i, $data->CHR_DATE_PURC);
                    $objPHPExcel->getActiveSheet()->setCellValue('AB'.$i, $data->CHR_PR_NO);
                } else {
                    $objPHPExcel->getActiveSheet()->setCellValue('AA'.$i, '-');
                    $objPHPExcel->getActiveSheet()->setCellValue('AB'.$i, '-');
                }
                
                $objPHPExcel->getActiveSheet()->getStyle("F".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle("H".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                $objPHPExcel->getActiveSheet()->getStyle("I".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle("J".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                $objPHPExcel->getActiveSheet()->getStyle("K".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                $objPHPExcel->getActiveSheet()->getStyle("L".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle("M".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle("N".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle("O".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle("P".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $i++;                
            }            
            $no++;
        }
        
        $styleArray = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                ),
            ),
        );
        
        $styleArray2 = array(
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => '99CCFF')
            )
        );
        
        $x = $i-1;
        $objPHPExcel->getActiveSheet()->getStyle("A2:AB$x")->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->getStyle("A2:AB2")->applyFromArray($styleArray2);
        
        $filename = "Report Usage Budget ". $bgt_type ." for " . $kode_dept . " " . $fiscal_start . ".xls";
        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . trim($filename) . '"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->setIncludeCharts(TRUE);
        $objWriter->save('php://output');
    }
    
    function report_tableau(){
        $session = $this->session->all_userdata();
        $role = $session['ROLE'];

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(253);
        $data['news'] = $this->news_m->get_news();
        $data['role'] = $role;
        
        $contain = 'budget/report_budget/report_tableau_v';
        $data['content'] = $contain;
        $data['title'] = 'Report Budget Tabelau';

        $this->load->view($this->layout, $data);
        
    }
    
    function refresh_tableau(){
        $session = $this->session->all_userdata();
        $role = $session['ROLE'];
        
        $year = date('Y');
        $month = date('m');
        $periode = date('Ym');
        $fiscal_start = '';
        $fiscal_end = '';
        if((int)$month > 3){
            $fiscal_start = $year; 
            $fiscal_end = $year + 1;
        } else {
            $fiscal_start = $year - 1;
            $fiscal_end = $year;
        }
        
        $all_div = $this->division_m->get_division();
        foreach($all_div as $div){
            $id_div = $div->INT_ID_DIVISION;
            if($id_div == 3){
                $div_code = '001';
                $budget_type = $this->report_budget_m->get_budget_type();
                foreach($budget_type as $bgt){
                    $bgt_group = '';
                    if($bgt->CHR_BUDGET_TYPE == 'CAPEX'){
                        $bgt_group = 'CAPEX';
                        
                        
                    } else {
                        $bgt_group = 'EXPENSE';
                    }
                    
//                    $all_dept = $this->dept_m->get_dept();
//                    foreach($all_dept as $dept){
//                        
//                    }
                }
            }
            
        }
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        $update = $bgt_aii->query("EXEC zsp_update_summary_budget_usage_group");
        
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(253);
        $data['news'] = $this->news_m->get_news();
        $data['role'] = $role;
        
        $contain = 'budget/report_budget/report_tableau_v';
        $data['content'] = $contain;
        $data['title'] = 'Report Budget Tabelau';

        $this->load->view($this->layout, $data);        
    }
    
    function export_report_summary_budget_smt1() {        
        $this->load->library('excel');
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        
        $fiscal_start = $this->input->post("CHR_FISCAL_EXP");
        $fiscal_end = $fiscal_start + 1;
        $kode_dept = $this->input->post("CHR_DEPT_EXP");
        $kode_sect = $this->input->post("CHR_SECT_EXP");
        $bgt_type = $this->input->post("CHR_BUDGET_TYPE_EXP");
        
        if($kode_sect == 'ALL'){
            $kode_sect = '';
        }
        
        $list_budget = $this->report_budget_m->get_report_budget_smt1($fiscal_start, $fiscal_end, $bgt_type, $kode_dept, $kode_sect);
//        print_r($list_budget);
//        exit();

        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

        // Set Properties
        $objPHPExcel->getProperties()->setCreator(trim($this->session->userdata('USERNAME')));
        $objPHPExcel->getProperties()->setLastModifiedBy(trim($this->session->userdata('USERNAME')));
        $objPHPExcel->getProperties()->setTitle("REKAP BUDGET");
        $objPHPExcel->getProperties()->setSubject("REKAP BUDGET");
        $objPHPExcel->getProperties()->setDescription("REKAP BUDGET");
                
        //Header TR
        $objPHPExcel->getActiveSheet()->setCellValue('A2', 'NO');        
        $objPHPExcel->getActiveSheet()->setCellValue('B2', 'TAHUN');
        $objPHPExcel->getActiveSheet()->setCellValue('C2', 'NO BUDGET');
        $objPHPExcel->getActiveSheet()->setCellValue('D2', 'DESCRIPTION');
        $objPHPExcel->getActiveSheet()->setCellValue('E2', 'DEPARTMENT');
        $objPHPExcel->getActiveSheet()->setCellValue('F2', 'BUDGET TYPE');
        $objPHPExcel->getActiveSheet()->setCellValue('G2', 'CATEGORY');
        $objPHPExcel->getActiveSheet()->setCellValue('H2', 'PROJECT');
        $objPHPExcel->getActiveSheet()->setCellValue('I2', 'APRIL '.$fiscal_start);
        $objPHPExcel->getActiveSheet()->setCellValue('N2', 'MEI '.$fiscal_start);
        $objPHPExcel->getActiveSheet()->setCellValue('S2', 'JUNI '.$fiscal_start);
        $objPHPExcel->getActiveSheet()->setCellValue('X2', 'JULI '.$fiscal_start);
        $objPHPExcel->getActiveSheet()->setCellValue('AC2', 'AGUSTUS '.$fiscal_start);
        $objPHPExcel->getActiveSheet()->setCellValue('AH2', 'SEPTEMBER '.$fiscal_start);
        $objPHPExcel->getActiveSheet()->setCellValue('AM2', 'OKTOBER '.$fiscal_start);
        $objPHPExcel->getActiveSheet()->setCellValue('AR2', 'NOVEMBER '.$fiscal_start);
        $objPHPExcel->getActiveSheet()->setCellValue('AW2', 'DESEMBER '.$fiscal_start);
        $objPHPExcel->getActiveSheet()->setCellValue('BB2', 'JANUARI '.$fiscal_end);
        $objPHPExcel->getActiveSheet()->setCellValue('BG2', 'FEBRUARI '.$fiscal_end);
        $objPHPExcel->getActiveSheet()->setCellValue('BL2', 'MARET '.$fiscal_end);
        $objPHPExcel->getActiveSheet()->setCellValue('BQ2', 'TOTAL AMOUNT');
        
        $objPHPExcel->getActiveSheet()->getStyle("A2:BV2")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        $objPHPExcel->getActiveSheet()->mergeCells('A2:A3');
        $objPHPExcel->getActiveSheet()->mergeCells('B2:B3');
        $objPHPExcel->getActiveSheet()->mergeCells('C2:C3');
        $objPHPExcel->getActiveSheet()->mergeCells('D2:D3');
        $objPHPExcel->getActiveSheet()->mergeCells('E2:E3');
        $objPHPExcel->getActiveSheet()->mergeCells('F2:F3');
        $objPHPExcel->getActiveSheet()->mergeCells('G2:G3');
        $objPHPExcel->getActiveSheet()->mergeCells('H2:H3');
        $objPHPExcel->getActiveSheet()->mergeCells('I2:M2');
        $objPHPExcel->getActiveSheet()->mergeCells('N2:R2');
        $objPHPExcel->getActiveSheet()->mergeCells('S2:W2');
        $objPHPExcel->getActiveSheet()->mergeCells('X2:AB2');
        $objPHPExcel->getActiveSheet()->mergeCells('AC2:AG2');
        $objPHPExcel->getActiveSheet()->mergeCells('AH2:AL2');
        $objPHPExcel->getActiveSheet()->mergeCells('AM2:AQ2');
        $objPHPExcel->getActiveSheet()->mergeCells('AR2:AV2');
        $objPHPExcel->getActiveSheet()->mergeCells('AW2:BA2');
        $objPHPExcel->getActiveSheet()->mergeCells('BB2:BF2');
        $objPHPExcel->getActiveSheet()->mergeCells('BG2:BK2');
        $objPHPExcel->getActiveSheet()->mergeCells('BL2:BP2');
        $objPHPExcel->getActiveSheet()->mergeCells('BQ2:BV2');
        //APRIL
        $objPHPExcel->getActiveSheet()->setCellValue('I3', 'PLAN');        
        $objPHPExcel->getActiveSheet()->setCellValue('J3', 'LIMIT');
        $objPHPExcel->getActiveSheet()->setCellValue('K3', 'ACTUAL PR');
        $objPHPExcel->getActiveSheet()->setCellValue('L3', 'OUTSTD PR');
        $objPHPExcel->getActiveSheet()->setCellValue('M3', 'ACTUAL GR');
        //MEI
        $objPHPExcel->getActiveSheet()->setCellValue('N3', 'PLAN');
        $objPHPExcel->getActiveSheet()->setCellValue('O3', 'LIMIT');
        $objPHPExcel->getActiveSheet()->setCellValue('P3', 'ACTUAL PR');
        $objPHPExcel->getActiveSheet()->setCellValue('Q3', 'OUTSTD PR');
        $objPHPExcel->getActiveSheet()->setCellValue('R3', 'ACTUAL GR');
        //JUNI
        $objPHPExcel->getActiveSheet()->setCellValue('S3', 'PLAN');
        $objPHPExcel->getActiveSheet()->setCellValue('T3', 'LIMIT');
        $objPHPExcel->getActiveSheet()->setCellValue('U3', 'ACTUAL PR');
        $objPHPExcel->getActiveSheet()->setCellValue('V3', 'OUTSTD PR');
        $objPHPExcel->getActiveSheet()->setCellValue('W3', 'ACTUAL GR');
        //JULI
        $objPHPExcel->getActiveSheet()->setCellValue('X3', 'PLAN');
        $objPHPExcel->getActiveSheet()->setCellValue('Y3', 'LIMIT');
        $objPHPExcel->getActiveSheet()->setCellValue('Z3', 'ACTUAL PR');
        $objPHPExcel->getActiveSheet()->setCellValue('AA3', 'OUTSTD PR');
        $objPHPExcel->getActiveSheet()->setCellValue('AB3', 'ACTUAL GR');
        //AGUSTUS
        $objPHPExcel->getActiveSheet()->setCellValue('AC3', 'PLAN');
        $objPHPExcel->getActiveSheet()->setCellValue('AD3', 'LIMIT');
        $objPHPExcel->getActiveSheet()->setCellValue('AE3', 'ACTUAL PR');
        $objPHPExcel->getActiveSheet()->setCellValue('AF3', 'OUTSTD PR');
        $objPHPExcel->getActiveSheet()->setCellValue('AG3', 'ACTUAL GR');
        //SEPTEMBER
        $objPHPExcel->getActiveSheet()->setCellValue('AH3', 'PLAN');
        $objPHPExcel->getActiveSheet()->setCellValue('AI3', 'LIMIT');
        $objPHPExcel->getActiveSheet()->setCellValue('AJ3', 'ACTUAL PR');
        $objPHPExcel->getActiveSheet()->setCellValue('AK3', 'OUTSTD PR');
        $objPHPExcel->getActiveSheet()->setCellValue('AL3', 'ACTUAL GR');
        //OKTOBER
        $objPHPExcel->getActiveSheet()->setCellValue('AM3', 'PLAN');
        $objPHPExcel->getActiveSheet()->setCellValue('AN3', 'LIMIT');
        $objPHPExcel->getActiveSheet()->setCellValue('AO3', 'ACTUAL PR');
        $objPHPExcel->getActiveSheet()->setCellValue('AP3', 'OUTSTD PR');
        $objPHPExcel->getActiveSheet()->setCellValue('AQ3', 'ACTUAL GR');
        //NOVEMBER
        $objPHPExcel->getActiveSheet()->setCellValue('AR3', 'PLAN');
        $objPHPExcel->getActiveSheet()->setCellValue('AS3', 'LIMIT');
        $objPHPExcel->getActiveSheet()->setCellValue('AT3', 'ACTUAL PR');
        $objPHPExcel->getActiveSheet()->setCellValue('AU3', 'OUTSTD PR');
        $objPHPExcel->getActiveSheet()->setCellValue('AV3', 'ACTUAL GR');
        //DESEMBER
        $objPHPExcel->getActiveSheet()->setCellValue('AW3', 'PLAN');
        $objPHPExcel->getActiveSheet()->setCellValue('AX3', 'LIMIT');
        $objPHPExcel->getActiveSheet()->setCellValue('AY3', 'ACTUAL PR');
        $objPHPExcel->getActiveSheet()->setCellValue('AZ3', 'OUTSTD PR');
        $objPHPExcel->getActiveSheet()->setCellValue('BA3', 'ACTUAL GR');
        //JANUARI
        $objPHPExcel->getActiveSheet()->setCellValue('BB3', 'PLAN');
        $objPHPExcel->getActiveSheet()->setCellValue('BC3', 'LIMIT');
        $objPHPExcel->getActiveSheet()->setCellValue('BD3', 'ACTUAL PR');
        $objPHPExcel->getActiveSheet()->setCellValue('BE3', 'OUTSTD PR');
        $objPHPExcel->getActiveSheet()->setCellValue('BF3', 'ACTUAL GR');
        //FEBRUARI
        $objPHPExcel->getActiveSheet()->setCellValue('BG3', 'PLAN');
        $objPHPExcel->getActiveSheet()->setCellValue('BH3', 'LIMIT');
        $objPHPExcel->getActiveSheet()->setCellValue('BI3', 'ACTUAL PR');
        $objPHPExcel->getActiveSheet()->setCellValue('BJ3', 'OUTSTD PR');
        $objPHPExcel->getActiveSheet()->setCellValue('BK3', 'ACTUAL GR');
        //MARET
        $objPHPExcel->getActiveSheet()->setCellValue('BL3', 'PLAN');
        $objPHPExcel->getActiveSheet()->setCellValue('BM3', 'LIMIT');
        $objPHPExcel->getActiveSheet()->setCellValue('BN3', 'ACTUAL PR');
        $objPHPExcel->getActiveSheet()->setCellValue('BO3', 'OUTSTD PR');
        $objPHPExcel->getActiveSheet()->setCellValue('BP3', 'ACTUAL GR');
        //TOTAL
        $objPHPExcel->getActiveSheet()->setCellValue('BQ3', 'PLAN');
        $objPHPExcel->getActiveSheet()->setCellValue('BR3', 'LIMIT');
        $objPHPExcel->getActiveSheet()->setCellValue('BS3', 'ACTUAL PR');
        $objPHPExcel->getActiveSheet()->setCellValue('BT3', 'OUTSTD PR');
        $objPHPExcel->getActiveSheet()->setCellValue('BU3', 'SALDO');
        $objPHPExcel->getActiveSheet()->setCellValue('BV3', 'ACTUAL GR');
        
        $objPHPExcel->getActiveSheet()->getStyle("I3:BV3")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A2:BV2')->getFont()->setSize(12);
        
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(6); $objPHPExcel->getActiveSheet()->getColumnDimension('AA')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10); $objPHPExcel->getActiveSheet()->getColumnDimension('AB')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25); $objPHPExcel->getActiveSheet()->getColumnDimension('AC')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(50); $objPHPExcel->getActiveSheet()->getColumnDimension('AD')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20); $objPHPExcel->getActiveSheet()->getColumnDimension('AE')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20); $objPHPExcel->getActiveSheet()->getColumnDimension('AF')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20); $objPHPExcel->getActiveSheet()->getColumnDimension('AG')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15); $objPHPExcel->getActiveSheet()->getColumnDimension('AH')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15); $objPHPExcel->getActiveSheet()->getColumnDimension('AI')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(15); $objPHPExcel->getActiveSheet()->getColumnDimension('AJ')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(15); $objPHPExcel->getActiveSheet()->getColumnDimension('AK')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(15); $objPHPExcel->getActiveSheet()->getColumnDimension('AL')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(15); $objPHPExcel->getActiveSheet()->getColumnDimension('AM')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(15); $objPHPExcel->getActiveSheet()->getColumnDimension('AN')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(15); $objPHPExcel->getActiveSheet()->getColumnDimension('AO')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(15); $objPHPExcel->getActiveSheet()->getColumnDimension('AP')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(15); $objPHPExcel->getActiveSheet()->getColumnDimension('AQ')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(15); $objPHPExcel->getActiveSheet()->getColumnDimension('AR')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(15); $objPHPExcel->getActiveSheet()->getColumnDimension('AS')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('T')->setWidth(15); $objPHPExcel->getActiveSheet()->getColumnDimension('AT')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('U')->setWidth(15); $objPHPExcel->getActiveSheet()->getColumnDimension('AU')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('V')->setWidth(15); $objPHPExcel->getActiveSheet()->getColumnDimension('AV')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('W')->setWidth(15); $objPHPExcel->getActiveSheet()->getColumnDimension('AW')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('X')->setWidth(15); $objPHPExcel->getActiveSheet()->getColumnDimension('AX')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('Y')->setWidth(15); $objPHPExcel->getActiveSheet()->getColumnDimension('AY')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('Z')->setWidth(15); $objPHPExcel->getActiveSheet()->getColumnDimension('AZ')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BA')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BB')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BC')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BD')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BE')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BF')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BG')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BH')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BI')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BJ')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BK')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BL')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BM')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BN')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BO')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BP')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BQ')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BR')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BS')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BT')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BU')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BV')->setWidth(15);
        
        //Value of All Cells
        $i = 4;
        $no = 1;
        foreach($list_budget as $data){
            $no_bgt = $data->CHR_NO_BUDGET;
            if ($bgt_type == 'CAPEX'){
                $GRBLN = $bgt_aii->query("EXEC zsp_get_gr_capex_by_no_budget '$fiscal_start', '$fiscal_end' , '" . $data->CHR_NO_BUDGET . "', ''");
            } else {
                $GRBLN = $bgt_aii->query("EXEC zsp_get_gr_expense_by_no_budget '$fiscal_start', '$fiscal_end' , '$bgt_type' , '" . $data->CHR_NO_BUDGET . "', ''");
            }
            
            //Get GR Value per Month
            if($GRBLN->num_rows() == 0){
                $GR04 = 0;
                $GR05 = 0;
                $GR06 = 0;
                $GR07 = 0;
                $GR08 = 0;
                $GR09 = 0;
                $GR10 = 0;
                $GR11 = 0;
                $GR12 = 0;
                $GR13 = 0;
                $GR14 = 0;
                $GR15 = 0;
                $tot_gr = 0;
            } else {
                $GR04 = $GRBLN->row()->GRBLN04;
                $GR05 = $GRBLN->row()->GRBLN05;
                $GR06 = $GRBLN->row()->GRBLN06;
                $GR07 = $GRBLN->row()->GRBLN07;
                $GR08 = $GRBLN->row()->GRBLN08;
                $GR09 = $GRBLN->row()->GRBLN09;
                $GR10 = $GRBLN->row()->GRBLN10;
                $GR11 = $GRBLN->row()->GRBLN11;
                $GR12 = $GRBLN->row()->GRBLN12;
                $GR13 = $GRBLN->row()->GRBLN13;
                $GR14 = $GRBLN->row()->GRBLN14;
                $GR15 = $GRBLN->row()->GRBLN15;
                $tot_gr = $GRBLN->row()->TOT_GR;
            }
            
            $outstd_pr = $this->report_budget_m->get_pr_outstanding_by_no_budget($fiscal_start, $fiscal_end, $bgt_type, $data->CHR_KODE_DEPARTMENT, trim($kode_sect), trim($data->CHR_NO_BUDGET));
            if($outstd_pr->num_rows() == 0){
                $PR04 = 0;
                $PR05 = 0;
                $PR06 = 0;
                $PR07 = 0;
                $PR08 = 0;
                $PR09 = 0;
                $PR10 = 0;
                $PR11 = 0;
                $PR12 = 0;
                $PR13 = 0;
                $PR14 = 0;
                $PR15 = 0;
                $tot_pr_outstd = 0;
            } else {
                $PR04 = $outstd_pr->row()->PR04;
                $PR05 = $outstd_pr->row()->PR05;
                $PR06 = $outstd_pr->row()->PR06;
                $PR07 = $outstd_pr->row()->PR07;
                $PR08 = $outstd_pr->row()->PR08;
                $PR09 = $outstd_pr->row()->PR09;
                $PR10 = $outstd_pr->row()->PR10;
                $PR11 = $outstd_pr->row()->PR11;
                $PR12 = $outstd_pr->row()->PR12;
                $PR13 = $outstd_pr->row()->PR13;
                $PR14 = $outstd_pr->row()->PR14;
                $PR15 = $outstd_pr->row()->PR15;
                $tot_pr_outstd = $outstd_pr->row()->PR_TOT;
            }
            
            //Insert Value to Excel Column
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$i, $no);
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$i, $data->CHR_TAHUN_BUDGET);
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$i, $data->CHR_NO_BUDGET);
            $objPHPExcel->getActiveSheet()->setCellValue('D'.$i, $data->CHR_DESC_BUDGET);
            $objPHPExcel->getActiveSheet()->setCellValue('E'.$i, $data->CHR_KODE_DEPARTMENT);
            $objPHPExcel->getActiveSheet()->setCellValue('F'.$i, $data->CHR_KODE_TYPE_BUDGET);        
            $objPHPExcel->getActiveSheet()->setCellValue('G'.$i, $data->CHR_KODE_SUBCATEGORY_BUDGET);                
            $objPHPExcel->getActiveSheet()->setCellValue('H'.$i, $data->CHR_DESC_PROJECT);   
            //APRIL
            $objPHPExcel->getActiveSheet()->setCellValue('I'.$i, $data->PBLN04);
            $objPHPExcel->getActiveSheet()->setCellValue('J'.$i, $data->LBLN04);        
            $objPHPExcel->getActiveSheet()->setCellValue('K'.$i, $data->OBLN04);
            $objPHPExcel->getActiveSheet()->setCellValue('L'.$i, $PR04);
            $objPHPExcel->getActiveSheet()->setCellValue('M'.$i, $GR04);
            //MEI
            $objPHPExcel->getActiveSheet()->setCellValue('N'.$i, $data->PBLN05);
            $objPHPExcel->getActiveSheet()->setCellValue('O'.$i, $data->LBLN05);        
            $objPHPExcel->getActiveSheet()->setCellValue('P'.$i, $data->OBLN05);
            $objPHPExcel->getActiveSheet()->setCellValue('Q'.$i, $PR05);
            $objPHPExcel->getActiveSheet()->setCellValue('R'.$i, $GR04);
            //JUNI
            $objPHPExcel->getActiveSheet()->setCellValue('S'.$i, $data->PBLN06);
            $objPHPExcel->getActiveSheet()->setCellValue('T'.$i, $data->LBLN06);        
            $objPHPExcel->getActiveSheet()->setCellValue('U'.$i, $data->OBLN06);
            $objPHPExcel->getActiveSheet()->setCellValue('V'.$i, $PR06);
            $objPHPExcel->getActiveSheet()->setCellValue('W'.$i, $GR04);
            //JULI
            $objPHPExcel->getActiveSheet()->setCellValue('X'.$i, $data->PBLN07);
            $objPHPExcel->getActiveSheet()->setCellValue('Y'.$i, $data->LBLN07);        
            $objPHPExcel->getActiveSheet()->setCellValue('Z'.$i, $data->OBLN07);
            $objPHPExcel->getActiveSheet()->setCellValue('AA'.$i, $PR07);
            $objPHPExcel->getActiveSheet()->setCellValue('AB'.$i, $GR04);
            //AGUSTUS
            $objPHPExcel->getActiveSheet()->setCellValue('AC'.$i, $data->PBLN08);
            $objPHPExcel->getActiveSheet()->setCellValue('AD'.$i, $data->LBLN08);        
            $objPHPExcel->getActiveSheet()->setCellValue('AE'.$i, $data->OBLN08);
            $objPHPExcel->getActiveSheet()->setCellValue('AF'.$i, $PR08);
            $objPHPExcel->getActiveSheet()->setCellValue('AG'.$i, $GR04);
            //SEPTEMBER
            $objPHPExcel->getActiveSheet()->setCellValue('AH'.$i, $data->PBLN09);
            $objPHPExcel->getActiveSheet()->setCellValue('AI'.$i, $data->LBLN09);        
            $objPHPExcel->getActiveSheet()->setCellValue('AJ'.$i, $data->OBLN09);
            $objPHPExcel->getActiveSheet()->setCellValue('AK'.$i, $PR09);
            $objPHPExcel->getActiveSheet()->setCellValue('AL'.$i, $GR04);
            //OKTOBER
            $objPHPExcel->getActiveSheet()->setCellValue('AM'.$i, $data->PBLN10);
            $objPHPExcel->getActiveSheet()->setCellValue('AN'.$i, $data->LBLN10);        
            $objPHPExcel->getActiveSheet()->setCellValue('AO'.$i, $data->OBLN10);
            $objPHPExcel->getActiveSheet()->setCellValue('AP'.$i, $PR10);
            $objPHPExcel->getActiveSheet()->setCellValue('AQ'.$i, $GR04);
            //NOVEMBER
            $objPHPExcel->getActiveSheet()->setCellValue('AR'.$i, $data->PBLN11);
            $objPHPExcel->getActiveSheet()->setCellValue('AS'.$i, $data->LBLN11);        
            $objPHPExcel->getActiveSheet()->setCellValue('AT'.$i, $data->OBLN11);
            $objPHPExcel->getActiveSheet()->setCellValue('AU'.$i, $PR11);
            $objPHPExcel->getActiveSheet()->setCellValue('AV'.$i, $GR04);
            //DESEMBER
            $objPHPExcel->getActiveSheet()->setCellValue('AW'.$i, $data->PBLN12);
            $objPHPExcel->getActiveSheet()->setCellValue('AX'.$i, $data->LBLN12);        
            $objPHPExcel->getActiveSheet()->setCellValue('AY'.$i, $data->OBLN12);
            $objPHPExcel->getActiveSheet()->setCellValue('AZ'.$i, $PR12);
            $objPHPExcel->getActiveSheet()->setCellValue('BA'.$i, $GR04);
            //JANUARI
            $objPHPExcel->getActiveSheet()->setCellValue('BB'.$i, $data->PBLN13);
            $objPHPExcel->getActiveSheet()->setCellValue('BC'.$i, $data->LBLN13);        
            $objPHPExcel->getActiveSheet()->setCellValue('BD'.$i, $data->OBLN13);
            $objPHPExcel->getActiveSheet()->setCellValue('BE'.$i, $PR13);
            $objPHPExcel->getActiveSheet()->setCellValue('BF'.$i, $GR04);
            //FEBRUARI
            $objPHPExcel->getActiveSheet()->setCellValue('BG'.$i, $data->PBLN14);
            $objPHPExcel->getActiveSheet()->setCellValue('BH'.$i, $data->LBLN14);        
            $objPHPExcel->getActiveSheet()->setCellValue('BI'.$i, $data->OBLN14);
            $objPHPExcel->getActiveSheet()->setCellValue('BJ'.$i, $PR14);
            $objPHPExcel->getActiveSheet()->setCellValue('BK'.$i, $GR04);
            //MARET
            $objPHPExcel->getActiveSheet()->setCellValue('BL'.$i, $data->PBLN15);
            $objPHPExcel->getActiveSheet()->setCellValue('BM'.$i, $data->LBLN15);        
            $objPHPExcel->getActiveSheet()->setCellValue('BN'.$i, $data->OBLN15);
            $objPHPExcel->getActiveSheet()->setCellValue('BO'.$i, $PR15);
            $objPHPExcel->getActiveSheet()->setCellValue('BP'.$i, $GR04);
            //TOTAL
            // $outstd_pr = $bgt_aii->query("SELECT ISNULL(SUM(MON_TOTAL_PRICE_SUPPLIER),0) AS OUTSTD_PR FROM BDGT_TT_BUDGET_PR_DETAIL
            //                                     WHERE CHR_NO_BUDGET LIKE '%$no_bgt%' AND CHR_KODE_TRANSAKSI IN (SELECT CHR_KODE_TRANSAKSI FROM BDGT_TT_BUDGET_PR_HEADER 
            //                                     WHERE CHR_KODE_TYPE_BUDGET = '$bgt_type' AND CHR_TAHUN_BUDGET = '$fiscal_start' AND CHR_FLG_APPROVE_BOD = '0' AND CHR_FLG_DELETE = '0')")->row();
            
            $tot_plan = $data->PBLN04 + $data->PBLN05 + $data->PBLN06 + $data->PBLN07 + $data->PBLN08 + $data->PBLN09 + $data->PBLN10 + $data->PBLN11 +
                        $data->PBLN12 + $data->PBLN13 + $data->PBLN14 + $data->PBLN15;
            $tot_limit = $data->LBLN04 + $data->LBLN05 + $data->LBLN06 + $data->LBLN07 + $data->LBLN08 + $data->LBLN09 + $data->LBLN10 + $data->LBLN11 +
                        $data->LBLN12 + $data->LBLN13 + $data->LBLN14 + $data->LBLN15;
            $tot_actual = $data->OBLN04 + $data->OBLN05 + $data->OBLN06 + $data->OBLN07 + $data->OBLN08 + $data->OBLN09 + $data->OBLN10 + $data->OBLN11 +
                        $data->OBLN12 + $data->OBLN13 + $data->OBLN14 + $data->OBLN15;
            // $tot_outstd = $outstd_pr->OUTSTD_PR;
            // $saldo = $tot_limit - ($tot_actual + $tot_outstd);
            $saldo = $tot_limit - ($tot_actual + $tot_pr_outstd);
            
            $objPHPExcel->getActiveSheet()->setCellValue('BQ'.$i, $tot_plan);
            $objPHPExcel->getActiveSheet()->setCellValue('BR'.$i, $tot_limit);        
            $objPHPExcel->getActiveSheet()->setCellValue('BS'.$i, $tot_actual);
            //$objPHPExcel->getActiveSheet()->setCellValue('BT'.$i, $tot_outstd);
            $objPHPExcel->getActiveSheet()->setCellValue('BT'.$i, $tot_pr_outstd);
            $objPHPExcel->getActiveSheet()->setCellValue('BU'.$i, $saldo);
            $objPHPExcel->getActiveSheet()->setCellValue('BV'.$i, $tot_gr);
            
            $objPHPExcel->getActiveSheet()->getStyle("A".$i.":C".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle("D".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle("E".$i.":H".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle("I".$i.":BV".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $i++;
            $no++;
        }
        
        $x = $i-1;
        $objPHPExcel->getActiveSheet()->setCellValue("I$i", "=SUM(I4:I$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("J$i", "=SUM(J4:J$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("K$i", "=SUM(K4:K$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("L$i", "=SUM(L4:L$x)");        
        $objPHPExcel->getActiveSheet()->setCellValue("M$i", "=SUM(M4:M$x)");

        $objPHPExcel->getActiveSheet()->setCellValue("N$i", "=SUM(N4:N$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("O$i", "=SUM(O4:O$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("P$i", "=SUM(P4:P$x)");        
        $objPHPExcel->getActiveSheet()->setCellValue("Q$i", "=SUM(Q4:Q$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("R$i", "=SUM(R4:R$x)");

        $objPHPExcel->getActiveSheet()->setCellValue("S$i", "=SUM(S4:S$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("T$i", "=SUM(T4:T$x)");        
        $objPHPExcel->getActiveSheet()->setCellValue("U$i", "=SUM(U4:U$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("V$i", "=SUM(V4:V$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("W$i", "=SUM(W4:W$x)");

        $objPHPExcel->getActiveSheet()->setCellValue("X$i", "=SUM(X4:X$x)");        
        $objPHPExcel->getActiveSheet()->setCellValue("Y$i", "=SUM(Y4:Y$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("Z$i", "=SUM(Z4:Z$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("AA$i", "=SUM(AA4:AA$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("AB$i", "=SUM(AB4:AB$x)");
        
        $objPHPExcel->getActiveSheet()->setCellValue("AC$i", "=SUM(AC4:AC$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("AD$i", "=SUM(AD4:AD$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("AE$i", "=SUM(AE4:AE$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("AF$i", "=SUM(AF4:AF$x)");        
        $objPHPExcel->getActiveSheet()->setCellValue("AG$i", "=SUM(AG4:AG$x)");

        $objPHPExcel->getActiveSheet()->setCellValue("AH$i", "=SUM(AH4:AH$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("AI$i", "=SUM(AI4:AI$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("AJ$i", "=SUM(AJ4:AJ$x)");        
        $objPHPExcel->getActiveSheet()->setCellValue("AK$i", "=SUM(AK4:AK$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("AL$i", "=SUM(AL4:AL$x)");

        $objPHPExcel->getActiveSheet()->setCellValue("AM$i", "=SUM(AM4:AM$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("AN$i", "=SUM(AN4:AN$x)");        
        $objPHPExcel->getActiveSheet()->setCellValue("AO$i", "=SUM(AO4:AO$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("AP$i", "=SUM(AP4:AP$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("AQ$i", "=SUM(AQ4:AQ$x)");

        $objPHPExcel->getActiveSheet()->setCellValue("AR$i", "=SUM(AR4:AR$x)");        
        $objPHPExcel->getActiveSheet()->setCellValue("AS$i", "=SUM(AS4:AS$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("AT$i", "=SUM(AT4:AT$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("AU$i", "=SUM(AU4:AU$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("AV$i", "=SUM(AV4:AV$x)");
        
        $objPHPExcel->getActiveSheet()->setCellValue("AW$i", "=SUM(AW4:AW$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("AX$i", "=SUM(AX4:AX$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("AY$i", "=SUM(AY4:AY$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("AZ$i", "=SUM(AZ4:AZ$x)");        
        $objPHPExcel->getActiveSheet()->setCellValue("BA$i", "=SUM(BA4:BA$x)");

        $objPHPExcel->getActiveSheet()->setCellValue("BB$i", "=SUM(BB4:BB$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("BC$i", "=SUM(BC4:BC$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("BD$i", "=SUM(BD4:BD$x)");        
        $objPHPExcel->getActiveSheet()->setCellValue("BE$i", "=SUM(BE4:BE$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("BF$i", "=SUM(BF4:BF$x)");

        $objPHPExcel->getActiveSheet()->setCellValue("BG$i", "=SUM(BG4:BG$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("BH$i", "=SUM(BH4:BH$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("BI$i", "=SUM(BI4:BI$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("BJ$i", "=SUM(BJ4:BJ$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("BK$i", "=SUM(BK4:BK$x)");

        $objPHPExcel->getActiveSheet()->setCellValue("BL$i", "=SUM(BL4:BL$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("BM$i", "=SUM(BM4:BM$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("BN$i", "=SUM(BN4:BN$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("BO$i", "=SUM(BO4:BO$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("BP$i", "=SUM(BP4:BP$x)");

        $objPHPExcel->getActiveSheet()->setCellValue("BQ$i", "=SUM(BQ4:BQ$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("BR$i", "=SUM(BR4:BR$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("BS$i", "=SUM(BS4:BS$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("BT$i", "=SUM(BT4:BT$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("BU$i", "=SUM(BU4:BU$x)");
        $objPHPExcel->getActiveSheet()->setCellValue("BV$i", "=SUM(BV4:BV$x)");
        
        $styleArray = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                ),
            ),
        );
        
        $styleArray2 = array(
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => '99CCFF')
            )
        );
        
        $styleArray3 = array(
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('argb' => 'CCCCCC')
            )
        );
        
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$i, "TOTAL");
        $objPHPExcel->getActiveSheet()->mergeCells("A$i:H$i");
        $objPHPExcel->getActiveSheet()->getStyle("A".$i.":H".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        $objPHPExcel->getActiveSheet()->getStyle("A2:BV3")->applyFromArray($styleArray2);
        $objPHPExcel->getActiveSheet()->getStyle("A2:BV$i")->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->getStyle("A$i:BV$i")->applyFromArray($styleArray3);
        $objPHPExcel->getActiveSheet()->getStyle("A$i:BV$i")->getFont()->setBold(true);
        
        $filename = "Report Summary Budget ". $bgt_type ." for " . $kode_dept . " " . $fiscal_start . ".xls";
        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . trim($filename) . '"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->setIncludeCharts(TRUE);
        $objWriter->save('php://output');
    }

    function view_detail_budget_dept($fiscal_start = NULL, $bgt_type = NULL, $kode_dept = NULL, $kode_sect = NULL){
        if($fiscal_start == NULL){
            $fiscal_start = date('Y');
        }
        
        $fiscal_end = $fiscal_start + 1;
        $act_periode = date("Ym");
        $periode_smt2 = $fiscal_start . '10';
        
        $id_dept = $this->session->userdata('DEPT');
        if($kode_dept == NULL){
            $kode_dept = $this->report_budget_m->get_user_dept($id_dept)->CHR_DEPT;
            $kode_group = $this->session->userdata('GROUPDEPT');
        } else {
            $kode_group = $this->dept_m->get_groupdept_by_dept($id_dept);
        }
            
        if($kode_group == '7'){
            $kode_group = '003';
        } else if($kode_group == '6') {
            $kode_group = '001';
        } else if($kode_group == '10') {
            $kode_group = '004';
        }
            
        if($kode_dept == 'PC'){
            $kode_dept = 'KQC';
        } else {
            $kode_dept = trim($kode_dept);
        }
            
        if($kode_sect == 'ALL' || $kode_sect == NULL){
            $kode_sect = '';
        }

        //TOTAL BUDGET PLANT
        $data['total_budget_plant'] = $this->purchase_request_m->get_total_budget_plant($fiscal_start, $bgt_type)->TOT_BUDGET_PLANT;           
            
        //TOTAL BUDGET REVISI PLANT
        $data['total_all_budget_revisi'] = $this->purchase_request_m->get_total_budget_revisi_plant($fiscal_start, $bgt_type)->TOT_BGTREV;

        //===== DETAIL DEPT =====//
        $data['detail_budget'] = $this->purchase_request_m->get_new_budget_detail($fiscal_start, $fiscal_start, $fiscal_end, $bgt_type, $kode_dept);
        $data['revisi_budget'] = $this->purchase_request_m->get_new_budget_detail_rev($fiscal_start, $fiscal_start, $fiscal_end, $bgt_type, $kode_dept);
        $data['limit_budget'] = $this->purchase_request_m->get_new_budget_limit($fiscal_start, $fiscal_start, $fiscal_end, $bgt_type, $kode_dept, $act_periode, $periode_smt2);
        $data['detail_unbudget'] = $this->purchase_request_m->get_new_unbudget_detail($fiscal_start, $fiscal_start, $fiscal_end, $bgt_type, $kode_dept);
        $data['actual_real'] = $this->purchase_request_m->get_new_actual_real($fiscal_start, $fiscal_start, $fiscal_end, $bgt_type, $kode_dept, $act_periode, $periode_smt2);
        
        //===== Additional SALES Data --- By ANU 20200421 =====//
        $data['detail_sales'] = $this->purchase_request_m->get_budget_sales($fiscal_start);
        $data['revisi_budget_by_sales'] = $this->purchase_request_m->get_new_budget_detail_rev_by_sales($fiscal_start, $bgt_type, $kode_dept);
        $data['ratio_sales'] = $this->purchase_request_m->get_ratio_sales($fiscal_start, $bgt_type);
        $data['total_cr_plant'] = $this->purchase_request_m->get_total_amount_cr($fiscal_start, $bgt_type);
        //===== End Additional SALES Data --- By ANU 20200421 =====//
        
        $list_actual_gr = array();
        for ($no = 1; $no <= 12; $no++){
            if (($no + 3) <= 12){
                $start_date = $fiscal_start . sprintf("%02d", $no+3) . '01';
                $end_date = $fiscal_start . sprintf("%02d", $no+3) . '31';
                    
                $actual_gr = $this->purchase_request_m->get_new_actual_gr($start_date, $end_date, $bgt_type, $kode_dept);
                    
                array_push($list_actual_gr, $actual_gr->TOTAL);                    
            } else {
                $start_date = $fiscal_end . sprintf("%02d", $no-9) . '01';
                $end_date = $fiscal_end . sprintf("%02d", $no-9) . '31';
                    
                $actual_gr = $this->purchase_request_m->get_new_actual_gr($start_date, $end_date, $bgt_type, $kode_dept);
                   
                array_push($list_actual_gr, $actual_gr->TOTAL);                    
            }
        }
            
        $data['actual_gr'] = $list_actual_gr;
        
        $data['act_periode'] = $act_periode;
        $data['periode_smt2'] = $periode_smt2;
        $data['tahun'] = $fiscal_start;
        $data['bgt_type'] = $bgt_type;

        $data['title'] = 'Detail Budget Dept per Month';
        $contain = 'budget/report_budget/view_detail_budget_dept_v';
        $data['content'] = $contain;
        $this->load->view("/template/head_blank", $data);
    }

    function view_detail_budget_gm($fiscal_start = NULL, $bgt_type = NULL, $kode_dept = NULL, $kode_sect = NULL){
        if($fiscal_start == NULL){
            $fiscal_start = date('Y');
        }
        
        $fiscal_end = $fiscal_start + 1;
        $act_periode = date("Ym");
        $periode_smt2 = $fiscal_start . '10';        
        
        if($kode_dept == NULL){
            $id_dept = $this->session->userdata('DEPT');
            $kode_dept = $this->report_budget_m->get_user_dept($id_dept)->CHR_DEPT;
            $kode_group = $this->session->userdata('GROUPDEPT');
        } else {
            $id_dept = $this->dept_m->get_id_dept_by_dept($kode_dept);
            $kode_group = $this->dept_m->get_groupdept_by_dept($id_dept);
        }
            
        if($kode_group == '7'){
            $kode_group = '003';
        } else if($kode_group == '6') {
            $kode_group = '001';
        } else if($kode_group == '10') {
            $kode_group = '004';
        }
            
        if($kode_dept == 'PC'){
            $kode_dept = 'KQC';
        } else {
            $kode_dept = trim($kode_dept);
        }
            
        if($kode_sect == 'ALL' || $kode_sect == NULL){
            $kode_sect = '';
        }

        //TOTAL BUDGET PLANT
        $data['total_budget_plant'] = $this->purchase_request_m->get_total_budget_plant($fiscal_start, $bgt_type)->TOT_BUDGET_PLANT;           
            
        //TOTAL BUDGET REVISI PLANT
        $data['total_all_budget_revisi'] = $this->purchase_request_m->get_total_budget_revisi_plant($fiscal_start, $bgt_type)->TOT_BGTREV;
        
        //===== DETAIL GROUP =====//
        $data['detail_budget'] = $this->purchase_request_m->get_new_budget_detail_gm($fiscal_start, $fiscal_start, $fiscal_end, $bgt_type, $kode_group);
        $data['revisi_budget'] = $this->purchase_request_m->get_new_budget_detail_rev_gm($fiscal_start, $fiscal_start, $fiscal_end, $bgt_type, $kode_group);
        $data['limit_budget'] = $this->purchase_request_m->get_new_budget_limit_gm($fiscal_start, $fiscal_start, $fiscal_end, $bgt_type, $kode_group, $act_periode, $periode_smt2);
        $data['detail_unbudget'] = $this->purchase_request_m->get_new_unbudget_detail_gm($fiscal_start, $fiscal_start, $fiscal_end, $bgt_type, $kode_group);
        $data['actual_real'] = $this->purchase_request_m->get_new_actual_real_gm($fiscal_start, $fiscal_start, $fiscal_end, $bgt_type, $kode_group, $act_periode, $periode_smt2);
        
        //===== Additional SALES Data --- By ANU 20200421 =====//
        $data['detail_sales'] = $this->purchase_request_m->get_budget_sales($fiscal_start);
        $data['revisi_budget_by_sales'] = $this->purchase_request_m->get_new_budget_detail_rev_gm_by_sales($fiscal_start, $bgt_type, $kode_group);
        $data['ratio_sales'] = $this->purchase_request_m->get_ratio_sales($fiscal_start, $bgt_type);
        $data['total_cr_plant'] = $this->purchase_request_m->get_total_amount_cr($fiscal_start, $bgt_type);
        //===== End Additional SALES Data --- By ANU 20200421 =====//

        $list_actual_gr = array();
        for ($no = 1; $no <= 12; $no++){
            if (($no + 3) <= 12){
                $start_date = $fiscal_start . sprintf("%02d", $no+3) . '01';
                $end_date = $fiscal_start . sprintf("%02d", $no+3) . '31';
                    
                $actual_gr = $this->purchase_request_m->get_new_actual_gr_gm($start_date, $end_date, $bgt_type, $kode_dept, $kode_group);
                    
                array_push($list_actual_gr, $actual_gr->TOTAL);                    
            } else {
                $start_date = $fiscal_end . sprintf("%02d", $no-9) . '01';
                $end_date = $fiscal_end . sprintf("%02d", $no-9) . '31';
                    
                $actual_gr = $this->purchase_request_m->get_new_actual_gr_gm($start_date, $end_date, $bgt_type, $kode_dept, $kode_group);
                   
                array_push($list_actual_gr, $actual_gr->TOTAL);                    
            }
        }
            
        $data['actual_gr'] = $list_actual_gr;
        
        $data['act_periode'] = $act_periode;
        $data['periode_smt2'] = $periode_smt2;
        $data['tahun'] = $fiscal_start;
        $data['bgt_type'] = $bgt_type;
        
        $data['title'] = 'Detail Budget Group per Month';
        $contain = 'budget/report_budget/view_detail_budget_group_v';
        $data['content'] = $contain;
        $this->load->view("/template/head_blank", $data);
    }

    function export_report_task_force_budget() {        
        $this->load->library('excel');
        
        $fiscal_start = '2021'; //$this->input->post("CHR_FISCAL_EXP");
        $fiscal_end = $fiscal_start + 1;
        $act_periode = date("Ym");
        $periode_smt2 = $fiscal_start . '10';

        $list_budget_type = $this->report_budget_m->get_budget_type_expense();
                
        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

        // Set Properties
        $objPHPExcel->getProperties()->setCreator(trim($this->session->userdata('USERNAME')));
        $objPHPExcel->getProperties()->setLastModifiedBy(trim($this->session->userdata('USERNAME')));
        $objPHPExcel->getProperties()->setTitle("REKAP ACTUAL PR & GR");
        $objPHPExcel->getProperties()->setSubject("REKAP ACTUAL PR & GR");
        $objPHPExcel->getProperties()->setDescription("REKAP ACTUAL PR & GR");
                
        //Header TR
        $objPHPExcel->getActiveSheet()->setCellValue('A2', 'BUDGET TYPE');
        $objPHPExcel->getActiveSheet()->getStyle("A2")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('B2', 'PR/GR');
        $objPHPExcel->getActiveSheet()->getStyle("B2")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('C2', 'GROUP');
        $objPHPExcel->getActiveSheet()->getStyle("C2")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('D2', 'DEPT');
        $objPHPExcel->getActiveSheet()->getStyle("D2")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('E2', 'APR');
        $objPHPExcel->getActiveSheet()->getStyle("E2")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('F2', 'MAY');
        $objPHPExcel->getActiveSheet()->getStyle("F2")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('G2', 'JUN');
        $objPHPExcel->getActiveSheet()->getStyle("G2")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('H2', 'JUL');
        $objPHPExcel->getActiveSheet()->getStyle("H2")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('I2', 'AUG');
        $objPHPExcel->getActiveSheet()->getStyle("I2")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('J2', 'SEP');
        $objPHPExcel->getActiveSheet()->getStyle("J2")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('K2', 'OCT');
        $objPHPExcel->getActiveSheet()->getStyle("K2")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('L2', 'NOV');
        $objPHPExcel->getActiveSheet()->getStyle("L2")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('M2', 'DEC');
        $objPHPExcel->getActiveSheet()->getStyle("M2")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('N2', 'JAN');
        $objPHPExcel->getActiveSheet()->getStyle("N2")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('O2', 'FEB');
        $objPHPExcel->getActiveSheet()->getStyle("O2")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
        $objPHPExcel->getActiveSheet()->setCellValue('P2', 'MAR');
        $objPHPExcel->getActiveSheet()->getStyle("P2")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
        $objPHPExcel->getActiveSheet()->setCellValue('Q2', 'TOTAL');
        $objPHPExcel->getActiveSheet()->getStyle("Q2")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                

        $objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true)->setSize(11);
        $objPHPExcel->getActiveSheet()->getStyle('B2')->getFont()->setBold(true)->setSize(11);
        $objPHPExcel->getActiveSheet()->getStyle('C2')->getFont()->setBold(true)->setSize(11);
        $objPHPExcel->getActiveSheet()->getStyle('D2')->getFont()->setBold(true)->setSize(11);
        $objPHPExcel->getActiveSheet()->getStyle('E2')->getFont()->setBold(true)->setSize(11);
        $objPHPExcel->getActiveSheet()->getStyle('F2')->getFont()->setBold(true)->setSize(11);
        $objPHPExcel->getActiveSheet()->getStyle('G2')->getFont()->setBold(true)->setSize(11);
        $objPHPExcel->getActiveSheet()->getStyle('H2')->getFont()->setBold(true)->setSize(11);
        $objPHPExcel->getActiveSheet()->getStyle('I2')->getFont()->setBold(true)->setSize(11);
        $objPHPExcel->getActiveSheet()->getStyle('J2')->getFont()->setBold(true)->setSize(11);
        $objPHPExcel->getActiveSheet()->getStyle('K2')->getFont()->setBold(true)->setSize(11);
        $objPHPExcel->getActiveSheet()->getStyle('L2')->getFont()->setBold(true)->setSize(11);
        $objPHPExcel->getActiveSheet()->getStyle('M2')->getFont()->setBold(true)->setSize(11);
        $objPHPExcel->getActiveSheet()->getStyle('N2')->getFont()->setBold(true)->setSize(11);
        $objPHPExcel->getActiveSheet()->getStyle('O2')->getFont()->setBold(true)->setSize(11);
        $objPHPExcel->getActiveSheet()->getStyle('P2')->getFont()->setBold(true)->setSize(11);
        $objPHPExcel->getActiveSheet()->getStyle('Q2')->getFont()->setBold(true)->setSize(11);
        
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(10);
        
        //Value of All Cells
        $i = 3;
        $i_group = 0;
        foreach($list_budget_type as $data){
            $bgt_type = $data->CHR_BUDGET_TYPE;
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$i, $bgt_type);

            for($x = 1; $x <= 2; $x++){
                if($x == 1){
                    $objPHPExcel->getActiveSheet()->setCellValue('B'.$i, "PR");
                } else {
                    $objPHPExcel->getActiveSheet()->setCellValue('B'.$i, "GR");
                }                
                $objPHPExcel->getActiveSheet()->getStyle("B".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

                $amo_mon04 = 0;
                $amo_mon05 = 0;
                $amo_mon06 = 0;
                $amo_mon07 = 0;
                $amo_mon08 = 0;
                $amo_mon09 = 0;
                $amo_mon10 = 0;
                $amo_mon11 = 0;
                $amo_mon12 = 0;
                $amo_mon13 = 0;
                $amo_mon14 = 0;
                $amo_mon15 = 0;
                $amo_tot = 0;

                $list_group = $this->report_budget_m->get_all_group();            
                foreach($list_group as $group){
                    $kode_group = $group->CHR_KODE_GROUP;
                    if($group->CHR_KODE_GROUP == '001'){
                        $name_group = 'PRD';
                    } else if($group->CHR_KODE_GROUP == '003'){
                        $name_group = 'ENG';
                    } else {
                        $name_group = 'PPC';
                    }

                    $objPHPExcel->getActiveSheet()->setCellValue('C'.$i, $name_group);
                    $objPHPExcel->getActiveSheet()->getStyle("C".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    
                    $group_mon04 = 0;
                    $group_mon05 = 0;
                    $group_mon06 = 0;
                    $group_mon07 = 0;
                    $group_mon08 = 0;
                    $group_mon09 = 0;
                    $group_mon10 = 0;
                    $group_mon11 = 0;
                    $group_mon12 = 0;
                    $group_mon13 = 0;
                    $group_mon14 = 0;
                    $group_mon15 = 0;
                    $group_tot = 0;
                    
                    $list_dept = $this->report_budget_m->get_group_dept_new($kode_group);
                    foreach($list_dept as $dept){
                        $kode_dept = $dept->CHR_KODE_DEPARTMENT;
                        $objPHPExcel->getActiveSheet()->setCellValue('D'.$i, $kode_dept);
                        $objPHPExcel->getActiveSheet()->getStyle("D".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

                        if($x == 1){
                            $actual_real = $this->purchase_request_m->get_new_actual_real_v2($fiscal_start, $fiscal_start, $fiscal_end, $bgt_type, $kode_dept, $act_periode, $periode_smt2);
                            
                            if($actual_real->num_rows() <= 0){
                                $objPHPExcel->getActiveSheet()->setCellValue('F'.$i, 0);        
                                $objPHPExcel->getActiveSheet()->setCellValue('G'.$i, 0);                
                                $objPHPExcel->getActiveSheet()->setCellValue('H'.$i, 0);        
                                $objPHPExcel->getActiveSheet()->setCellValue('I'.$i, 0);
                                $objPHPExcel->getActiveSheet()->setCellValue('J'.$i, 0);        
                                $objPHPExcel->getActiveSheet()->setCellValue('K'.$i, 0);
                                $objPHPExcel->getActiveSheet()->setCellValue('L'.$i, 0);
                                $objPHPExcel->getActiveSheet()->setCellValue('M'.$i, 0);
                                $objPHPExcel->getActiveSheet()->setCellValue('N'.$i, 0);
                                $objPHPExcel->getActiveSheet()->setCellValue('O'.$i, 0);
                                $objPHPExcel->getActiveSheet()->setCellValue('P'.$i, 0);
                                $objPHPExcel->getActiveSheet()->setCellValue('Q'.$i, 0);

                                $group_mon04 = $group_mon04 + 0;
                                $group_mon05 = $group_mon05 + 0;
                                $group_mon06 = $group_mon06 + 0;
                                $group_mon07 = $group_mon07 + 0;
                                $group_mon08 = $group_mon08 + 0;
                                $group_mon09 = $group_mon09 + 0;
                                $group_mon10 = $group_mon10 + 0;
                                $group_mon11 = $group_mon11 + 0;
                                $group_mon12 = $group_mon12 + 0;
                                $group_mon13 = $group_mon13 + 0;
                                $group_mon14 = $group_mon14 + 0;
                                $group_mon15 = $group_mon15 + 0;
                                $group_tot = $group_tot + 0;
                            } else {
                                $objPHPExcel->getActiveSheet()->setCellValue('E'.$i, $actual_real->row()->OPRBLN04);
                                $objPHPExcel->getActiveSheet()->setCellValue('F'.$i, $actual_real->row()->OPRBLN05);        
                                $objPHPExcel->getActiveSheet()->setCellValue('G'.$i, $actual_real->row()->OPRBLN06);                
                                $objPHPExcel->getActiveSheet()->setCellValue('H'.$i, $actual_real->row()->OPRBLN07);        
                                $objPHPExcel->getActiveSheet()->setCellValue('I'.$i, $actual_real->row()->OPRBLN08);
                                $objPHPExcel->getActiveSheet()->setCellValue('J'.$i, $actual_real->row()->OPRBLN09);        
                                $objPHPExcel->getActiveSheet()->setCellValue('K'.$i, $actual_real->row()->OPRBLN10);
                                $objPHPExcel->getActiveSheet()->setCellValue('L'.$i, $actual_real->row()->OPRBLN11);
                                $objPHPExcel->getActiveSheet()->setCellValue('M'.$i, $actual_real->row()->OPRBLN12);
                                $objPHPExcel->getActiveSheet()->setCellValue('N'.$i, $actual_real->row()->OPRBLN13);
                                $objPHPExcel->getActiveSheet()->setCellValue('O'.$i, $actual_real->row()->OPRBLN14);
                                $objPHPExcel->getActiveSheet()->setCellValue('P'.$i, $actual_real->row()->OPRBLN15);
                                $objPHPExcel->getActiveSheet()->setCellValue('Q'.$i, $actual_real->row()->TOT_REAL_DEPT);

                                $group_mon04 = $group_mon04 + $actual_real->row()->OPRBLN04;
                                $group_mon05 = $group_mon05 + $actual_real->row()->OPRBLN05;
                                $group_mon06 = $group_mon06 + $actual_real->row()->OPRBLN06;
                                $group_mon07 = $group_mon07 + $actual_real->row()->OPRBLN07;
                                $group_mon08 = $group_mon08 + $actual_real->row()->OPRBLN08;
                                $group_mon09 = $group_mon09 + $actual_real->row()->OPRBLN09;
                                $group_mon10 = $group_mon10 + $actual_real->row()->OPRBLN10;
                                $group_mon11 = $group_mon11 + $actual_real->row()->OPRBLN11;
                                $group_mon12 = $group_mon12 + $actual_real->row()->OPRBLN12;
                                $group_mon13 = $group_mon13 + $actual_real->row()->OPRBLN13;
                                $group_mon14 = $group_mon14 + $actual_real->row()->OPRBLN14;
                                $group_mon15 = $group_mon15 + $actual_real->row()->OPRBLN15;
                                $group_tot = $group_tot + $actual_real->row()->TOT_REAL_DEPT;
                            }
                            
                        } else {
                            $list_gr = array();
                            for ($no = 1; $no <= 12; $no++){
                                if (($no + 3) <= 12){
                                    $start_date = $fiscal_start . sprintf("%02d", $no+3) . '01';
                                    $end_date = $fiscal_start . sprintf("%02d", $no+3) . '31';
                                    
                                    $actual_gr = $this->purchase_request_m->get_new_actual_gr($start_date, $end_date, $bgt_type, $kode_dept);
                                    
                                    array_push($list_gr, $actual_gr->TOTAL);                    
                                } else {
                                    $start_date = $fiscal_end . sprintf("%02d", $no-9) . '01';
                                    $end_date = $fiscal_end . sprintf("%02d", $no-9) . '31';
                                    
                                    $actual_gr = $this->purchase_request_m->get_new_actual_gr($start_date, $end_date, $bgt_type, $kode_dept);
                                
                                    array_push($list_gr, $actual_gr->TOTAL);                    
                                }
                            }

                            $objPHPExcel->getActiveSheet()->setCellValue('E'.$i, $list_gr[0]);
                            $objPHPExcel->getActiveSheet()->setCellValue('F'.$i, $list_gr[1]);        
                            $objPHPExcel->getActiveSheet()->setCellValue('G'.$i, $list_gr[2]);                
                            $objPHPExcel->getActiveSheet()->setCellValue('H'.$i, $list_gr[3]);        
                            $objPHPExcel->getActiveSheet()->setCellValue('I'.$i, $list_gr[4]);
                            $objPHPExcel->getActiveSheet()->setCellValue('J'.$i, $list_gr[5]);        
                            $objPHPExcel->getActiveSheet()->setCellValue('K'.$i, $list_gr[6]);
                            $objPHPExcel->getActiveSheet()->setCellValue('L'.$i, $list_gr[7]);
                            $objPHPExcel->getActiveSheet()->setCellValue('M'.$i, $list_gr[8]);
                            $objPHPExcel->getActiveSheet()->setCellValue('N'.$i, $list_gr[9]);
                            $objPHPExcel->getActiveSheet()->setCellValue('O'.$i, $list_gr[10]);
                            $objPHPExcel->getActiveSheet()->setCellValue('P'.$i, $list_gr[11]);
                            $tot_gr = $list_gr[0] + $list_gr[1] + $list_gr[2] + $list_gr[3] + $list_gr[4] + $list_gr[5] + $list_gr[6] + $list_gr[7] + $list_gr[8] + $list_gr[9] + $list_gr[10] + $list_gr[11];
                            $objPHPExcel->getActiveSheet()->setCellValue('Q'.$i, $tot_gr);

                            $group_mon04 = $group_mon04 + $list_gr[0];
                            $group_mon05 = $group_mon05 + $list_gr[1];
                            $group_mon06 = $group_mon06 + $list_gr[2];
                            $group_mon07 = $group_mon07 + $list_gr[3];
                            $group_mon08 = $group_mon08 + $list_gr[4];
                            $group_mon09 = $group_mon09 + $list_gr[5];
                            $group_mon10 = $group_mon10 + $list_gr[6];
                            $group_mon11 = $group_mon11 + $list_gr[7];
                            $group_mon12 = $group_mon12 + $list_gr[8];
                            $group_mon13 = $group_mon13 + $list_gr[9];
                            $group_mon14 = $group_mon14 + $list_gr[10];
                            $group_mon15 = $group_mon15 + $list_gr[11];
                            $group_tot = $group_tot + $tot_gr;
                        }                            

                        $objPHPExcel->getActiveSheet()->getStyle("E".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                        $objPHPExcel->getActiveSheet()->getStyle("F".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                        $objPHPExcel->getActiveSheet()->getStyle("H".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                        $objPHPExcel->getActiveSheet()->getStyle("I".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                        $objPHPExcel->getActiveSheet()->getStyle("J".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                        $objPHPExcel->getActiveSheet()->getStyle("K".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                        $objPHPExcel->getActiveSheet()->getStyle("L".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                        $objPHPExcel->getActiveSheet()->getStyle("M".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                        $objPHPExcel->getActiveSheet()->getStyle("N".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                        $objPHPExcel->getActiveSheet()->getStyle("O".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                        $objPHPExcel->getActiveSheet()->getStyle("P".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                        $objPHPExcel->getActiveSheet()->getStyle("Q".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                        $i++;
                    }

                    if($x == 1){
                        $objPHPExcel->getActiveSheet()->setCellValue('C'.$i, 'TOTAL PR ' . $bgt_type . ' ' . $name_group);
                    } else {
                        $objPHPExcel->getActiveSheet()->setCellValue('C'.$i, 'TOTAL GR ' . $bgt_type . ' ' . $name_group);
                    }
                    
                    $objPHPExcel->getActiveSheet()->mergeCells("C$i:D$i");
                    $objPHPExcel->getActiveSheet()->getStyle("C".$i.":D".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

                    $objPHPExcel->getActiveSheet()->setCellValue('E'.$i, $group_mon04);
                    $objPHPExcel->getActiveSheet()->setCellValue('F'.$i, $group_mon05);        
                    $objPHPExcel->getActiveSheet()->setCellValue('G'.$i, $group_mon06);                
                    $objPHPExcel->getActiveSheet()->setCellValue('H'.$i, $group_mon07);        
                    $objPHPExcel->getActiveSheet()->setCellValue('I'.$i, $group_mon08);
                    $objPHPExcel->getActiveSheet()->setCellValue('J'.$i, $group_mon09);        
                    $objPHPExcel->getActiveSheet()->setCellValue('K'.$i, $group_mon10);
                    $objPHPExcel->getActiveSheet()->setCellValue('L'.$i, $group_mon11);
                    $objPHPExcel->getActiveSheet()->setCellValue('M'.$i, $group_mon12);
                    $objPHPExcel->getActiveSheet()->setCellValue('N'.$i, $group_mon13);
                    $objPHPExcel->getActiveSheet()->setCellValue('O'.$i, $group_mon14);
                    $objPHPExcel->getActiveSheet()->setCellValue('P'.$i, $group_mon15);
                    $objPHPExcel->getActiveSheet()->setCellValue('Q'.$i, $group_tot);

                    $objPHPExcel->getActiveSheet()->getStyle("E".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                    $objPHPExcel->getActiveSheet()->getStyle("F".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                    $objPHPExcel->getActiveSheet()->getStyle("H".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                    $objPHPExcel->getActiveSheet()->getStyle("I".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                    $objPHPExcel->getActiveSheet()->getStyle("J".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                    $objPHPExcel->getActiveSheet()->getStyle("K".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                    $objPHPExcel->getActiveSheet()->getStyle("L".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                    $objPHPExcel->getActiveSheet()->getStyle("M".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                    $objPHPExcel->getActiveSheet()->getStyle("N".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                    $objPHPExcel->getActiveSheet()->getStyle("O".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                    $objPHPExcel->getActiveSheet()->getStyle("P".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                    $objPHPExcel->getActiveSheet()->getStyle("Q".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                    
                    $amo_mon04 = $amo_mon04 + $group_mon04;
                    $amo_mon05 = $amo_mon05 + $group_mon05;
                    $amo_mon06 = $amo_mon06 + $group_mon06;
                    $amo_mon07 = $amo_mon07 + $group_mon07;
                    $amo_mon08 = $amo_mon08 + $group_mon08;
                    $amo_mon09 = $amo_mon09 + $group_mon09;
                    $amo_mon10 = $amo_mon10 + $group_mon10;
                    $amo_mon11 = $amo_mon11 + $group_mon11;
                    $amo_mon12 = $amo_mon12 + $group_mon12;
                    $amo_mon13 = $amo_mon13 + $group_mon13;
                    $amo_mon14 = $amo_mon14 + $group_mon14;
                    $amo_mon15 = $amo_mon15 + $group_mon15;
                    $amo_tot = $amo_tot + $group_tot;

                    if($x == 1){
                        $styleArray = array(
                                'fill' => array(
                                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                    'color' => array('rgb' => 'FFF700')
                            )
                        );
                    } else {
                        $styleArray = array(
                                'fill' => array(
                                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                    'color' => array('rgb' => '00D5FF')
                            )
                        );
                    }

                    $objPHPExcel->getActiveSheet()->getStyle('C'.$i.':Q'.$i)->applyFromArray($styleArray);

                    $i++;
                }

                if($x == 1){
                    $objPHPExcel->getActiveSheet()->setCellValue('B'.$i, 'TOTAL PR ' . $bgt_type);
                } else {
                    $objPHPExcel->getActiveSheet()->setCellValue('B'.$i, 'TOTAL GR ' . $bgt_type);
                }
                
                $objPHPExcel->getActiveSheet()->mergeCells("B$i:D$i");
                $objPHPExcel->getActiveSheet()->getStyle("B".$i.":D".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

                $objPHPExcel->getActiveSheet()->setCellValue('E'.$i, $amo_mon04);
                $objPHPExcel->getActiveSheet()->setCellValue('F'.$i, $amo_mon05);        
                $objPHPExcel->getActiveSheet()->setCellValue('G'.$i, $amo_mon06);                
                $objPHPExcel->getActiveSheet()->setCellValue('H'.$i, $amo_mon07);        
                $objPHPExcel->getActiveSheet()->setCellValue('I'.$i, $amo_mon08);
                $objPHPExcel->getActiveSheet()->setCellValue('J'.$i, $amo_mon09);        
                $objPHPExcel->getActiveSheet()->setCellValue('K'.$i, $amo_mon10);
                $objPHPExcel->getActiveSheet()->setCellValue('L'.$i, $amo_mon11);
                $objPHPExcel->getActiveSheet()->setCellValue('M'.$i, $amo_mon12);
                $objPHPExcel->getActiveSheet()->setCellValue('N'.$i, $amo_mon13);
                $objPHPExcel->getActiveSheet()->setCellValue('O'.$i, $amo_mon14);
                $objPHPExcel->getActiveSheet()->setCellValue('P'.$i, $amo_mon15);
                $objPHPExcel->getActiveSheet()->setCellValue('Q'.$i, $amo_tot);

                $objPHPExcel->getActiveSheet()->getStyle("E".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                $objPHPExcel->getActiveSheet()->getStyle("F".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                $objPHPExcel->getActiveSheet()->getStyle("H".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                $objPHPExcel->getActiveSheet()->getStyle("I".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                $objPHPExcel->getActiveSheet()->getStyle("J".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                $objPHPExcel->getActiveSheet()->getStyle("K".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                $objPHPExcel->getActiveSheet()->getStyle("L".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                $objPHPExcel->getActiveSheet()->getStyle("M".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                $objPHPExcel->getActiveSheet()->getStyle("N".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                $objPHPExcel->getActiveSheet()->getStyle("O".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                $objPHPExcel->getActiveSheet()->getStyle("P".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                $objPHPExcel->getActiveSheet()->getStyle("Q".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                if($x == 1){
                    $styleArray = array(
                            'fill' => array(
                                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                'color' => array('rgb' => 'FF9A00')
                        )
                    );
                } else {
                    $styleArray = array(
                            'fill' => array(
                                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                'color' => array('rgb' => '0077FF')
                        )
                    );
                }

                $objPHPExcel->getActiveSheet()->getStyle('B'.$i.':Q'.$i)->applyFromArray($styleArray);

                $i++;
            }
            
        }
        
        $styleArray = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                ),
            ),
        );

        $y = $i-1;
        $objPHPExcel->getActiveSheet()->getStyle("A2:Q$y")->applyFromArray($styleArray);

        $styleArray = array(
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => '99CCFF')
            )
        );
        
        $objPHPExcel->getActiveSheet()->getStyle("A2:Q2")->applyFromArray($styleArray);
        
        $filename = "Report Actual PR-GR.xls";
        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . trim($filename) . '"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->setIncludeCharts(TRUE);
        $objWriter->save('php://output');
    }

    function update_progress($step){
        $kode_trans = $this->input->post("KODE_TRANSAKSI");
        $fiscal_start = $this->input->post("FISCAL");
        $bgt_type = $this->input->post("BUDGET_TYPE");
        $kode_dept = $this->input->post("DEPT");
        $kode_sect = $this->input->post("SECT");

        // print_r($kode_trans);
        // exit();

        if($step == 'mgr'){
            $date_mgr_in = $this->input->post("date_mgr_in");            

            if($date_mgr_in == '' || $date_mgr_in == NULL){
                $date_mgr_in = NULL;
            } else { 
                $date_mgr_in = substr($date_mgr_in, 6, 4) . substr($date_mgr_in, 0, 2) . substr($date_mgr_in, 3, 2); 
            }
            
            $this->report_budget_m->update_progress_mgr($kode_trans, $date_mgr_in);
        
        } else if($step == 'gm'){
            $date_gm_in = $this->input->post("date_gm_in");                
    
            if($date_gm_in == '' || $date_gm_in == NULL){
                $date_gm_in = NULL; 
            } else { 
                $date_gm_in = substr($date_gm_in, 6, 4) . substr($date_gm_in, 0, 2) . substr($date_gm_in, 3, 2); 
            }
                
            $this->report_budget_m->update_progress_gm($kode_trans, $date_gm_in);
    
        } else if($step == 'dir'){
            $date_dir_in = $this->input->post("date_dir_in");                
    
            if($date_dir_in == '' || $date_dir_in == NULL){
                $date_dir_in = NULL;
            } else { 
                $date_dir_in = substr($date_dir_in, 6, 4) . substr($date_dir_in, 0, 2) . substr($date_dir_in, 3, 2);                 
            }
                
            $this->report_budget_m->update_progress_dir($kode_trans, $date_dir_in);
    
        } else if($step == 'acc'){
            $flg_acc = $this->input->post("flg_acc");
            
            $date_acc_in = $this->input->post("date_acc_in");
            if($date_acc_in == "" || $date_acc_in == NULL){
                $date_acc_in = NULL;
            } else {
                $date_acc_in = substr($date_acc_in, 6, 4) . substr($date_acc_in, 0, 2) . substr($date_acc_in, 3, 2);
            }
            
            if($flg_acc == 0){
                $date_acc = NULL;
                $asset_no = NULL;
            } else {
                $date_acc = $this->input->post("date_acc");
                $date_acc = substr($date_acc, 6, 4) . substr($date_acc, 0, 2) . substr($date_acc, 3, 2); 
                $asset_no = $this->input->post("asset_no");
            }
            
            $this->report_budget_m->update_progress_acc($kode_trans, $flg_acc, $date_acc, $asset_no, $date_acc_in);

        } else if($step == 'vp'){
            $flg_vp = $this->input->post("flg_vp");
            $date_vp_in = $this->input->post("date_vp_in");
            if($date_vp_in == "" || $date_vp_in == NULL){
                $date_vp_in = NULL;
            } else {
                $date_vp_in = substr($date_vp_in, 6, 4) . substr($date_vp_in, 0, 2) . substr($date_vp_in, 3, 2);
            }
                
            if($flg_vp == 0){
                $date_vp = NULL;
            } else {
                $date_vp = $this->input->post("date_vp");
                $date_vp = substr($date_vp, 6, 4) . substr($date_vp, 0, 2) . substr($date_vp, 3, 2);    
            }

            $this->report_budget_m->update_progress_vp($kode_trans, $flg_vp, $date_vp, $date_vp_in);
 
        } else if($step == 'presdir'){
            $flg_presdir = $this->input->post("flg_presdir");
            $date_presdir_in = $this->input->post("date_presdir_in");
            if($date_presdir_in == "" || $date_presdir_in == NULL){
                $date_presdir_in = NULL;
            } else {
                $date_presdir_in = substr($date_presdir_in, 6, 4) . substr($date_presdir_in, 0, 2) . substr($date_presdir_in, 3, 2);
            }
                    
            if($flg_presdir == 0){
                $date_presdir = NULL;
            } else {
                $date_presdir = $this->input->post("date_presdir");
                $date_presdir = substr($date_presdir, 6, 4) . substr($date_presdir, 0, 2) . substr($date_presdir, 3, 2);    
            }

            $this->report_budget_m->update_progress_presdir($kode_trans, $flg_presdir, $date_presdir, $date_presdir_in);

        } else if($step == 'gudtool'){
            $flg_gudtool = $this->input->post("flg_gudtool");
            $date_gudtool_in = $this->input->post("date_gudtool_in");
            if($date_gudtool_in == "" || $date_gudtool_in == NULL){
                $date_gudtool_in = NULL;
            } else {
                $date_gudtool_in = substr($date_gudtool_in, 6, 4) . substr($date_gudtool_in, 0, 2) . substr($date_gudtool_in, 3, 2); 
            }                

            if($flg_gudtool == 0){
                $date_gudtool = NULL;
                $pr_no = NULL;
            } else {
                $date_gudtool = $this->input->post("date_gudtool");
                $date_gudtool = substr($date_gudtool, 6, 4) . substr($date_gudtool, 0, 2) . substr($date_gudtool, 3, 2); 
                $pr_no = $this->input->post("pr_no");
            }
            
            $this->report_budget_m->update_progress_gudtool($kode_trans, $flg_gudtool, $date_gudtool, $pr_no, $date_gudtool_in);

        } else if($step == 'purc'){
            $flg_purc = $this->input->post("flg_purc");
            $date_purc_in = $this->input->post("date_purc_in");
            if($date_purc_in == "" || $date_purc_in == NULL){
                $date_purc_in = NULL;
            } else {
                $date_purc_in = substr($date_purc_in, 6, 4) . substr($date_purc_in, 0, 2) . substr($date_purc_in, 3, 2);        
            }        

            if($flg_purc == 0){
                $date_purc = NULL;
                $po_no = NULL;
            } else {
                $date_purc = $this->input->post("date_purc");
                $date_purc = substr($date_purc, 6, 4) . substr($date_purc, 0, 2) . substr($date_purc, 3, 2); 
                $po_no = $this->input->post("po_no");
            }
            
            $this->report_budget_m->update_progress_purc($kode_trans, $flg_purc, $date_purc, $po_no, $date_purc_in);

        } else {
            print_r("Error! Please back previouse page");
            exit();
        }
        
        redirect('budget/report_budget_c/report_usage_budget/' . $fiscal_start . '/' . $bgt_type . '/' . $kode_dept . '/' . $kode_sect, 'refresh');
        
    }

    function update_progress_all(){        
        $fiscal_start = $this->input->post("FISCAL");
        $bgt_type = $this->input->post("BUDGET_TYPE");
        $kode_dept = $this->input->post("DEPT");
        $kode_sect = $this->input->post("SECT");
        $kode_transaksi = $this->input->post("KODE_TRANSAKSI");

        $step = $this->input->post("STEP");        

        // print_r($step);
        // exit();

        if($kode_transaksi != NULL || $kode_transaksi != '' || $kode_transaksi != 0){ 
            //===== Manager
            if($step == 'mgr'){ 
                $date_mgr_in = $this->input->post("date_mgr_in");            

                if($date_mgr_in == '' || $date_mgr_in == NULL){
                    $date_mgr_in = NULL;
                } else { 
                    $date_mgr_in = substr($date_mgr_in, 6, 4) . substr($date_mgr_in, 0, 2) . substr($date_mgr_in, 3, 2); 
                }   

                for($i = 0; $i < count($kode_transaksi); $i++){
                    $kode_trans = trim($kode_transaksi[$i]) ;                   
                        
                    $this->report_budget_m->update_progress_mgr($kode_trans, $date_mgr_in);
                }
            
            } else if($step == 'gm'){
                $date_gm_in = $this->input->post("date_gm_in");                
        
                if($date_gm_in == '' || $date_gm_in == NULL){
                    $date_gm_in = NULL; 
                } else { 
                    $date_gm_in = substr($date_gm_in, 6, 4) . substr($date_gm_in, 0, 2) . substr($date_gm_in, 3, 2); 
                }

                for($i = 0; $i < count($kode_transaksi); $i++){
                    $kode_trans = trim($kode_transaksi[$i]) ;                   
                        
                    $this->report_budget_m->update_progress_gm($kode_trans, $date_gm_in);
                }
        
            } else if($step == 'dir'){
                $date_dir_in = $this->input->post("date_dir_in");                
        
                if($date_dir_in == '' || $date_dir_in == NULL){
                    $date_dir_in = NULL;
                } else { 
                    $date_dir_in = substr($date_dir_in, 6, 4) . substr($date_dir_in, 0, 2) . substr($date_dir_in, 3, 2);                 
                }

                for($i = 0; $i < count($kode_transaksi); $i++){
                    $kode_trans = trim($kode_transaksi[$i]) ;                   
                        
                    $this->report_budget_m->update_progress_dir($kode_trans, $date_dir_in);
                }
        
            } else if($step == 'acc'){
                $flg_acc = $this->input->post("flg_acc");
                
                $date_acc_in = $this->input->post("date_acc_in");
                if($date_acc_in == "" || $date_acc_in == NULL){
                    $date_acc_in = NULL;
                } else {
                    $date_acc_in = substr($date_acc_in, 6, 4) . substr($date_acc_in, 0, 2) . substr($date_acc_in, 3, 2);
                }
                
                if($flg_acc == 0){
                    $date_acc = NULL;
                } else {
                    $date_acc = $this->input->post("date_acc");
                    $date_acc = substr($date_acc, 6, 4) . substr($date_acc, 0, 2) . substr($date_acc, 3, 2); 
                }

                for($i = 0; $i < count($kode_transaksi); $i++){
                    $kode_trans = trim($kode_transaksi[$i]) ;                   
                        
                    $this->report_budget_m->update_progress_acc_v2($kode_trans, $flg_acc, $date_acc, $date_acc_in);
                }

            } else if($step == 'vp'){
                $flg_vp = $this->input->post("flg_vp");
                $date_vp_in = $this->input->post("date_vp_in");
                if($date_vp_in == "" || $date_vp_in == NULL){
                    $date_vp_in = NULL;
                } else {
                    $date_vp_in = substr($date_vp_in, 6, 4) . substr($date_vp_in, 0, 2) . substr($date_vp_in, 3, 2);
                }
                    
                if($flg_vp == 0){
                    $date_vp = NULL;
                } else {
                    $date_vp = $this->input->post("date_vp");
                    $date_vp = substr($date_vp, 6, 4) . substr($date_vp, 0, 2) . substr($date_vp, 3, 2);    
                }

                for($i = 0; $i < count($kode_transaksi); $i++){
                    $kode_trans = trim($kode_transaksi[$i]) ;                   
                        
                    $this->report_budget_m->update_progress_vp($kode_trans, $flg_vp, $date_vp, $date_vp_in);
                }                
    
            } else if($step == 'presdir'){
                $flg_presdir = $this->input->post("flg_presdir");
                $date_presdir_in = $this->input->post("date_presdir_in");
                if($date_presdir_in == "" || $date_presdir_in == NULL){
                    $date_presdir_in = NULL;
                } else {
                    $date_presdir_in = substr($date_presdir_in, 6, 4) . substr($date_presdir_in, 0, 2) . substr($date_presdir_in, 3, 2);
                }
                        
                if($flg_presdir == 0){
                    $date_presdir = NULL;
                } else {
                    $date_presdir = $this->input->post("date_presdir");
                    $date_presdir = substr($date_presdir, 6, 4) . substr($date_presdir, 0, 2) . substr($date_presdir, 3, 2);    
                }

                for($i = 0; $i < count($kode_transaksi); $i++){
                    $kode_trans = trim($kode_transaksi[$i]) ;                   
                        
                    $this->report_budget_m->update_progress_presdir($kode_trans, $flg_presdir, $date_presdir, $date_presdir_in);
                }                

            } else if($step == 'gudtool'){
                $flg_gudtool = $this->input->post("flg_gudtool");
                $date_gudtool_in = $this->input->post("date_gudtool_in");
                if($date_gudtool_in == "" || $date_gudtool_in == NULL){
                    $date_gudtool_in = NULL;
                } else {
                    $date_gudtool_in = substr($date_gudtool_in, 6, 4) . substr($date_gudtool_in, 0, 2) . substr($date_gudtool_in, 3, 2); 
                }                

                if($flg_gudtool == 0){
                    $date_gudtool = NULL;
                } else {
                    $date_gudtool = $this->input->post("date_gudtool");
                    $date_gudtool = substr($date_gudtool, 6, 4) . substr($date_gudtool, 0, 2) . substr($date_gudtool, 3, 2);
                }

                for($i = 0; $i < count($kode_transaksi); $i++){
                    $kode_trans = trim($kode_transaksi[$i]) ;                   
                        
                    $this->report_budget_m->update_progress_gudtool_v2($kode_trans, $flg_gudtool, $date_gudtool, $date_gudtool_in);
                }                  

            } else if($step == 'purc'){
                $flg_purc = $this->input->post("flg_purc");
                $date_purc_in = $this->input->post("date_purc_in");
                if($date_purc_in == "" || $date_purc_in == NULL){
                    $date_purc_in = NULL;
                } else {
                    $date_purc_in = substr($date_purc_in, 6, 4) . substr($date_purc_in, 0, 2) . substr($date_purc_in, 3, 2);        
                }        

                if($flg_purc == 0){
                    $date_purc = NULL;
                } else {
                    $date_purc = $this->input->post("date_purc");
                    $date_purc = substr($date_purc, 6, 4) . substr($date_purc, 0, 2) . substr($date_purc, 3, 2); 
                }

                for($i = 0; $i < count($kode_transaksi); $i++){
                    $kode_trans = trim($kode_transaksi[$i]) ;                   
                        
                    $this->report_budget_m->update_progress_purc_v2($kode_trans, $flg_purc, $date_purc, $date_purc_in);
                } 

            } else {
                print_r("Error! Please back previouse page");
                exit();
            }
        } else {
            print_r("Error! Please input Approval Sheet number");
            exit();
        }

        redirect('budget/report_budget_c/report_usage_budget/' . $fiscal_start . '/' . $bgt_type . '/' . $kode_dept . '/' . $kode_sect, 'refresh');
        
    }

    public function edit_progress() {
        
        $pr_code = $this->input->post("id_pr");
        $fiscal_start = $this->input->post("id_fy");
        $kode_dept = $this->input->post("id_dept");
        $bgt_type = $this->input->post("id_type");
        $kode_sect = $this->input->post("id_sect");

        $data_pr = $this->report_budget_m->get_data_pr_by_trans_code($pr_code);

        $data = '';
        $data .= '<div class="modal-wrapper">';
        $data .= '   <div class="modal-dialog" style="font-size:11px;">';
        $data .= '      <div class="modal-content">';
        $data .= '          <div class="modal-header">';
        $data .= '              <button type="button" onclick="hide_edit_progress()" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>';
        $data .= '              <h4 class="modal-title" id="modalprogress"><strong>Edit Approval Progress - ' . $pr_code . '</strong></h4>';
        $data .= '          </div>';        

        $data .= form_open('budget/report_budget_c/update_progress_all');
        $data .= '              <input name="KODE_TRANSAKSI" type="hidden" value="' . trim($pr_code) . '">';
        $data .= '              <input name="FISCAL" value="' . $fiscal_start . '" type="hidden">';
        $data .= '              <input name="DEPT" value="' . $kode_dept . '" type="hidden">';
        $data .= '              <input name="SECT" value="' . $kode_sect . '" type="hidden">';
        $data .= '              <input name="BUDGET_TYPE" value="' . $bgt_type . '" type="hidden">';

        $data .= '          <!-- MANAGER -->';
        $data .= '          <div class="modal-body">';        
        $data .= '              <div class="form-group">';
        $data .= '                  <div class="col-sm-3">';
        $data .= '                      <label control-label"><strong>Finish MGR</strong></label>';
        $data .= '                  </div>';
        $data .= '                  <div class="col-sm-3">';
        $data .= '                      <label control-label">Date In</label>';
        $data .= '                  </div>';
        $data .= '                  <div class="col-sm-3">';
        $data .= '                      <label control-label">Date Out</label>';
        $data .= '                  </div>';
        $data .= '              </div>';
        $data .= '          </div>';
        $data .= '          <div class="modal-body">';
        $data .= '              <div class="form-group">';
        $data .= '                  <div class="col-sm-3">';
         
        if($data_pr->CHR_FLG_APPROVE_MAN == '1'){
            $data .= '                      <input type="radio" class="icheck" disabled name="flg_mgr" value="1" checked="true"> &nbsp; Yes &nbsp;';
            $data .= '                      <input type="radio" class="icheck" disabled name="flg_mgr" value="0"> &nbsp; No';
        } else {
            $data .= '                      <input type="radio" class="icheck" disabled name="flg_mgr" value="1"> &nbsp; Yes &nbsp;';
            $data .= '                      <input type="radio" class="icheck" disabled name="flg_mgr" value="0" checked="true"> &nbsp; No';
        }
              
        $date_in_mgr = '';
        if($data_pr->CHR_DATE_MAN_IN != NULL && $data_pr->CHR_DATE_MAN_IN != ""){ 
            $date_in_mgr = substr(trim($data_pr->CHR_DATE_MAN_IN),4,2) . '/' . substr(trim($data_pr->CHR_DATE_MAN_IN),6,2) . '/' . substr(trim($data_pr->CHR_DATE_MAN_IN),0,4); 
        }

        $date_out_mgr = '';
        if($data_pr->CHR_FLG_APPROVE_MAN == '1'){ 
            $date_out_mgr = substr(trim($data_pr->CHR_DATE_MAN),4,2) . '/' . substr(trim($data_pr->CHR_DATE_MAN),6,2) . '/' . substr(trim($data_pr->CHR_DATE_MAN),0,4);
        }
        
        $data .= '                  </div>';
        $data .= '                  <div class="col-sm-3">';
        $data .= '                      <input type="text" name="date_mgr_in" style="width:110px;" class="datepicker" value="' . $date_in_mgr . '">';
        $data .= '                  </div>';
        $data .= '                  <div class="col-sm-3">';
        $data .= '                      <input type="text" name="date_mgr" disabled style="width:110px;" class="datepicker" value="' . $date_out_mgr .'">';
        $data .= '                  </div>';
        $data .= '              </div>';
        $data .= '          </div>';
        
        $data .= '          <!-- GROUP MANAGER -->';
        $data .= '          <div class="modal-body">';
        $data .= '              <div class="form-group">';
        $data .= '                  <div class="col-sm-3">';
        $data .= '                      <label control-label"><strong>Finish GM</strong></label>';
        $data .= '                  </div>';
        $data .= '                  <div class="col-sm-3">';
        $data .= '                      <label control-label">Date In</label>';
        $data .= '                  </div>';
        $data .= '                  <div class="col-sm-3">';
        $data .= '                      <label control-label">Date Out</label>';
        $data .= '                  </div>';
        $data .= '              </div>';
        $data .= '          </div>';
        $data .= '          <div class="modal-body">';
        $data .= '              <div class="form-group">';
        $data .= '                  <div class="col-sm-3">';
        
        if($data_pr->CHR_FLG_APPROVE_GM == '1'){ 
            $data .= '                      <input type="radio" class="icheck" disabled name="flg_gm" value="1" checked="true"> &nbsp; Yes &nbsp;';
            $data .= '                      <input type="radio" class="icheck" disabled name="flg_gm" value="0"> &nbsp; No';
        } else {
            $data .= '                      <input type="radio" class="icheck" disabled name="flg_gm" value="1"> &nbsp; Yes &nbsp;';
            $data .= '                      <input type="radio" class="icheck" disabled name="flg_gm" value="0" checked="true"> &nbsp; No';
        }  
        
        $date_in_gm = '';
        if($data_pr->CHR_DATE_GM_IN != NULL && $data_pr->CHR_DATE_GM_IN != ""){ 
            $date_in_gm =  substr(trim($data_pr->CHR_DATE_GM_IN),4,2) . '/' . substr(trim($data_pr->CHR_DATE_GM_IN),6,2) . '/' . substr(trim($data_pr->CHR_DATE_GM_IN),0,4);
        }

        $date_out_gm = '';
        if($data_pr->CHR_FLG_APPROVE_GM == '1'){ 
            $date_out_gm = substr(trim($data_pr->CHR_DATE_GM),4,2) . '/' . substr(trim($data_pr->CHR_DATE_GM),6,2) . '/' . substr(trim($data_pr->CHR_DATE_GM),0,4);
        }
        
        $data .= '                  </div>';
        $data .= '                  <div class="col-sm-3">';
        $data .= '                      <input type="text" name="date_gm_in" style="width:110px;" class="datepicker" value="' . $date_in_gm . '">';
        $data .= '                  </div>';
        $data .= '                  <div class="col-sm-3">';
        $data .= '                      <input type="text" name="date_gm" disabled style="width:110px;" class="datepicker" value="' . $date_out_gm . '">';
        $data .= '                  </div>';
        $data .= '              </div>';
        $data .= '          </div>';

        $data .= '          <!-- GROUP DIREKTUR -->';
        $data .= '          <div class="modal-body">';
        $data .= '              <div class="form-group">';
        $data .= '                  <div class="col-sm-3">';
        $data .= '                       <label control-label"><strong>Finish DIR</strong></label>';
        $data .= '                  </div>';
        $data .= '                  <div class="col-sm-3">';
        $data .= '                      <label control-label">Date In</label>';
        $data .= '                  </div>';
        $data .= '                  <div class="col-sm-3">';
        $data .= '                      <label control-label">Date Out</label>';
        $data .= '                  </div>';
        $data .= '              </div>';
        $data .= '          </div>';
        $data .= '          <div class="modal-body">';
        $data .= '              <div class="form-group">';
        $data .= '                  <div class="col-sm-3">';

        if($data_pr->CHR_FLG_APPROVE_BOD == '1'){ 
            $data .= '                          <input type="radio" class="icheck" disabled name="flg_dir" value="1" checked="true"> &nbsp; Yes &nbsp;';
            $data .= '                          <input type="radio" class="icheck" disabled name="flg_dir" value="0"> &nbsp; No';
        } else {
            $data .= '                          <input type="radio" class="icheck" disabled name="flg_dir" value="1"> &nbsp; Yes &nbsp;';
            $data .= '                          <input type="radio" class="icheck" disabled name="flg_dir" value="0" checked="true"> &nbsp; No';
        }

        $date_in_dir = '';
        if($data_pr->CHR_DATE_BOD_IN != NULL && $data_pr->CHR_DATE_BOD_IN != ""){ 
            $date_in_dir = substr(trim($data_pr->CHR_DATE_BOD_IN),4,2) . '/' . substr(trim($data_pr->CHR_DATE_BOD_IN),6,2) . '/' . substr(trim($data_pr->CHR_DATE_BOD_IN),0,4); 
        }

        $date_out_dir = '';
        if($data_pr->CHR_FLG_APPROVE_BOD == '1'){ 
            $date_out_dir = substr(trim($data_pr->CHR_DATE_BOD),4,2) . '/' . substr(trim($data_pr->CHR_DATE_BOD),6,2) . '/' . substr(trim($data_pr->CHR_DATE_BOD),0,4); 
        }

        
        $data .= '                  </div>';
        $data .= '                  <div class="col-sm-3">';
        $data .= '                      <input type="text" name="date_dir_in" style="width:110px;" class="datepicker" value="' . $date_in_dir . '">';
        $data .= '                  </div>';
        $data .= '                  <div class="col-sm-3">';
        $data .= '                      <input type="text" name="date_dir" disabled style="width:110px;" class="datepicker" value="' . $date_out_dir . '">';
        $data .= '                  </div>';
        $data .= '              </div>';
        $data .= '          </div>';

        if($bgt_type == 'CAPEX'){

        $data .= '          <!-- ACCOUNTING -->';
        $data .= '          <div class="modal-body">';
        $data .= '              <div class="form-group">';
        $data .= '                  <div class="col-sm-3">';
        $data .= '                       <label control-label"><strong>Finish Acc</strong></label>';
        $data .= '                  </div>';
        $data .= '                  <div class="col-sm-3">';
        $data .= '                      <label control-label">Date In</label>';
        $data .= '                  </div>';
        $data .= '                  <div class="col-sm-3">';
        $data .= '                      <label control-label">Date Out</label>';
        $data .= '                  </div>';
        $data .= '                  <div class="col-sm-3">';
        $data .= '                      <label control-label">Asset No</label>';
        $data .= '                  </div>';
        $data .= '              </div>';
        $data .= '          </div>';
        $data .= '          <div class="modal-body">';
        $data .= '              <div class="form-group">';
        $data .= '                  <div class="col-sm-3">';

        if($data_pr->CHR_FLG_ACC == '1'){ 
            $data .= '                           <input type="radio" class="icheck" name="flg_acc" value="1" checked="true"> &nbsp; Yes &nbsp;';
            $data .= '                           <input type="radio" class="icheck" name="flg_acc" value="0"> &nbsp; No';
        } else {
            $data .= '                           <input type="radio" class="icheck" name="flg_acc" value="1"> &nbsp; Yes &nbsp;';
            $data .= '                           <input type="radio" class="icheck" name="flg_acc" value="0" checked="true"> &nbsp; No';
        }

        $date_in_acc = '';
        if($data_pr->CHR_DATE_ACC_IN != NULL && $data_pr->CHR_DATE_ACC_IN != ""){ 
            $date_in_acc = substr(trim($data_pr->CHR_DATE_ACC_IN),4,2) . '/' . substr(trim($data_pr->CHR_DATE_ACC_IN),6,2) . '/' . substr(trim($data_pr->CHR_DATE_ACC_IN),0,4); 
        }

        $date_out_acc = '';
        if($data_pr->CHR_FLG_ACC == '1'){
            $date_out_acc = substr(trim($data_pr->CHR_DATE_ACC),4,2) . '/' . substr(trim($data_pr->CHR_DATE_ACC),6,2) . '/' . substr(trim($data_pr->CHR_DATE_ACC),0,4); 
        }

        $asset_no = '';
        if($data_pr->CHR_ASSET_NO != NULL && $data_pr->CHR_ASSET_NO != ""){ 
            $asset_no = $data_pr->CHR_ASSET_NO; 
        }
        
        $data .= '                  </div>';
        $data .= '                  <div class="col-sm-3">';
        $data .= '                      <input type="text" name="date_acc_in" style="width:110px;" class="datepicker" value="' . $date_in_acc . '">';
        $data .= '                  </div>';
        $data .= '                  <div class="col-sm-3">';
        $data .= '                      <input type="text" name="date_acc" style="width:110px;" class="datepicker" value="' . $date_out_acc . '">';
        $data .= '                  </div>';
        $data .= '                  <div class="col-sm-3">';
        $data .= '                      <input type="text" name="asset_no" style="width:110px;" class="form-control" value="' . $asset_no . '">';
        $data .= '                  </div>';
        $data .= '              </div>';
        $data .= '          </div>';
        
        }

        $data .= '          <!-- VP -->';
        $data .= '          <div class="modal-body">';
        $data .= '              <div class="form-group">';
        $data .= '                  <div class="col-sm-3">';
        $data .= '                       <label control-label"><strong>Finish VP</strong></label>';
        $data .= '                  </div>';
        $data .= '                  <div class="col-sm-3">';
        $data .= '                      <label control-label">Date In</label>';
        $data .= '                  </div>';
        $data .= '                  <div class="col-sm-3">';
        $data .= '                      <label control-label">Date Out</label>';
        $data .= '                  </div>';
        $data .= '              </div>';
        $data .= '          </div>';
        $data .= '          <div class="modal-body">';
        $data .= '              <div class="form-group">';
        $data .= '                  <div class="col-sm-3">';

        if($data_pr->CHR_FLG_VP == '1'){ 
            $data .= '                          <input type="radio" class="icheck" name="flg_vp" value="1" checked="true"> &nbsp; Yes &nbsp;';
            $data .= '                          <input type="radio" class="icheck" name="flg_vp" value="0"> &nbsp; No';
        } else {
            $data .= '                          <input type="radio" class="icheck" name="flg_vp" value="1"> &nbsp; Yes &nbsp;';
            $data .= '                          <input type="radio" class="icheck" name="flg_vp" value="0" checked="true"> &nbsp; No';
        }

        $date_in_vp = '';
        if($data_pr->CHR_DATE_VP_IN != NULL && $data_pr->CHR_DATE_VP_IN != ""){ 
            $date_in_vp = substr(trim($data_pr->CHR_DATE_VP_IN),4,2) . '/' . substr(trim($data_pr->CHR_DATE_VP_IN),6,2) . '/' . substr(trim($data_pr->CHR_DATE_VP_IN),0,4); 
        }

        $date_out_vp = '';
        if($data_pr->CHR_FLG_VP == "1"){ 
            $date_out_vp = substr(trim($data_pr->CHR_DATE_VP),4,2) . '/' . substr(trim($data_pr->CHR_DATE_VP),6,2) . '/' . substr(trim($data_pr->CHR_DATE_VP),0,4); 
        }

        $data .= '                  </div>';
        $data .= '                  <div class="col-sm-3">';
        $data .= '                      <input type="text" name="date_vp_in" style="width:110px;" class="datepicker" value="' . $date_in_vp . '">';
        $data .= '                  </div>';
        $data .= '                  <div class="col-sm-3">';
        $data .= '                      <input type="text" name="date_vp" style="width:110px;" class="datepicker" value="' . $date_out_vp . '">';
        $data .= '                  </div>';
        $data .= '              </div>';
        $data .= '          </div>';

        $data .= '          <!-- PRESDIR -->';
        $data .= '          <div class="modal-body">';
        $data .= '              <div class="form-group">';
        $data .= '                  <div class="col-sm-3">';
        $data .= '                      <label control-label"><strong>Finish Presdir</strong></label>';
        $data .= '                  </div>';
        $data .= '                  <div class="col-sm-3">';
        $data .= '                      <label control-label">Date In</label>';
        $data .= '                  </div>';
        $data .= '                  <div class="col-sm-3">';
        $data .= '                      <label control-label">Date Out</label>';
        $data .= '                  </div>';
        $data .= '              </div>';
        $data .= '          </div>';
        $data .= '          <div class="modal-body">';
        $data .= '              <div class="form-group">';
        $data .= '                  <div class="col-sm-3">';

        if($data_pr->CHR_FLG_PRESDIR == '1'){ 
            $data .= '                          <input type="radio" class="icheck" name="flg_presdir" value="1" checked="true"> &nbsp; Yes &nbsp;';
            $data .= '                          <input type="radio" class="icheck" name="flg_presdir" value="0"> &nbsp; No';
        } else {
            $data .= '                          <input type="radio" class="icheck" name="flg_presdir" value="1"> &nbsp; Yes &nbsp;';
            $data .= '                          <input type="radio" class="icheck" name="flg_presdir" value="0" checked="true"> &nbsp; No';
        }

        $date_in_presdir = '';
        if($data_pr->CHR_DATE_PRESDIR_IN != NULL && $data_pr->CHR_DATE_PRESDIR_IN != ""){ 
            $date_in_presdir = substr(trim($data_pr->CHR_DATE_PRESDIR_IN),4,2) . '/' . substr(trim($data_pr->CHR_DATE_PRESDIR_IN),6,2) . '/' . substr(trim($data_pr->CHR_DATE_PRESDIR_IN),0,4); 
        }

        $date_out_presdir = '';
        if($data_pr->CHR_FLG_PRESDIR == "1"){ 
            $date_out_presdir = substr(trim($data_pr->CHR_DATE_PRESDIR),4,2) . '/' . substr(trim($data_pr->CHR_DATE_PRESDIR),6,2) . '/' . substr(trim($data_pr->CHR_DATE_PRESDIR),0,4); 
        }
        
        $data .= '                  </div>';
        $data .= '                  <div class="col-sm-3">';
        $data .= '                      <input type="text" name="date_presdir_in" style="width:110px;" class="datepicker" value="' . $date_in_presdir . '">';
        $data .= '                  </div>';
        $data .= '                  <div class="col-sm-3">';
        $data .= '                      <input type="text" name="date_presdir" style="width:110px;" class="datepicker" value="' . $date_out_presdir . '">';
        $data .= '                  </div>';
        $data .= '              </div>';
        $data .= '          </div>';

        $data .= '          <!-- GUDTOOL -->';
        $data .= '          <div class="modal-body">';
        $data .= '              <div class="form-group">';
        $data .= '                  <div class="col-sm-3">';
        $data .= '                      <label control-label"><strong>Finish Gudang</strong></label>';
        $data .= '                  </div>';
        $data .= '                  <div class="col-sm-3">';
        $data .= '                      <label control-label">Date In</label>';
        $data .= '                  </div>';
        $data .= '                  <div class="col-sm-3">';
        $data .= '                      <label control-label">Date Out</label>';
        $data .= '                  </div>';
        $data .= '                  <div class="col-sm-3">';
        $data .= '                      <label control-label">PR No</label>';
        $data .= '                  </div>';
        $data .= '              </div>';
        $data .= '          </div>';
        $data .= '          <div class="modal-body">';
        $data .= '              <div class="form-group">';
        $data .= '                  <div class="col-sm-3">';

        if($data_pr->CHR_FLG_GUDTOOL == '1'){ 
            $data .= '                          <input type="radio" class="icheck" name="flg_gudtool" value="1" checked="true"> &nbsp; Yes &nbsp;';
            $data .= '                          <input type="radio" class="icheck" name="flg_gudtool" value="0"> &nbsp; No';
        } else {
            $data .= '                          <input type="radio" class="icheck" name="flg_gudtool" value="1"> &nbsp; Yes &nbsp;';
            $data .= '                          <input type="radio" class="icheck" name="flg_gudtool" value="0" checked="true"> &nbsp; No';
        }

        $date_in_gudtool = '';
        if($data_pr->CHR_DATE_GUDTOOL_IN != NULL && $data_pr->CHR_DATE_GUDTOOL_IN != ""){ 
            $date_in_gudtool = substr(trim($data_pr->CHR_DATE_GUDTOOL_IN),4,2) . '/' . substr(trim($data_pr->CHR_DATE_GUDTOOL_IN),6,2) . '/' . substr(trim($data_pr->CHR_DATE_GUDTOOL_IN),0,4); 
        }

        $date_out_gudtool = '';
        if($data_pr->CHR_FLG_GUDTOOL == "1"){ 
            $date_out_gudtool = substr(trim($data_pr->CHR_DATE_GUDTOOL),4,2) . '/' . substr(trim($data_pr->CHR_DATE_GUDTOOL),6,2) . '/' . substr(trim($data_pr->CHR_DATE_GUDTOOL),0,4); 
        }

        $pr_no = '';
        if($data_pr->CHR_PR_NO != NULL && $data_pr->CHR_PR_NO != "") { 
            $pr_no = trim($data_pr->CHR_PR_NO);
        }
        
        $data .= '                  </div>';
        $data .= '                  <div class="col-sm-3">';
        $data .= '                      <input type="text" name="date_gudtool_in" style="width:110px;" class="datepicker" value="' . $date_in_gudtool . '">';
        $data .= '                  </div>';
        $data .= '                  <div class="col-sm-3">';
        $data .= '                      <input type="text" name="date_gudtool" style="width:110px;" class="datepicker" value="' . $date_out_gudtool . '">';
        $data .= '                  </div>';                                               
        $data .= '                  <div class="col-sm-3">';
        $data .= '                      <input type="text" name="pr_no" class="form-control" value="' . $pr_no . '">';
        $data .= '                  </div>';
        $data .= '              </div>';
        $data .= '          </div>';

        $data .= '          <!-- PURCHASING -->';
        $data .= '          <div class="modal-body">';
        $data .= '              <div class="form-group">';
        $data .= '                  <div class="col-sm-3">';
        $data .= '                      <label control-label"><strong>Finish Purch</strong></label>';
        $data .= '                  </div>';
        $data .= '                  <div class="col-sm-3">';
        $data .= '                      <label control-label">Date In</label>';
        $data .= '                  </div>';
        $data .= '                  <div class="col-sm-3">';
        $data .= '                      <label control-label">Date Out</label>';
        $data .= '                  </div>';
        $data .= '                  <div class="col-sm-3">';
        $data .= '                      <label control-label">PO No</label>';
        $data .= '                  </div>';
        $data .= '              </div>';
        $data .= '          </div>';
        $data .= '          <div class="modal-body">';
        $data .= '              <div class="form-group">';
        $data .= '                  <div class="col-sm-3">';

        if($data_pr->CHR_FLG_PURC == '1'){ 
            $data .= '                          <input type="radio" class="icheck" name="flg_purc" value="1" checked="true"> &nbsp; Yes &nbsp;';
            $data .= '                          <input type="radio" class="icheck" name="flg_purc" value="0"> &nbsp; No';
        } else {
            $data .= '                          <input type="radio" class="icheck" name="flg_purc" value="1"> &nbsp; Yes &nbsp;';
            $data .= '                          <input type="radio" class="icheck" name="flg_purc" value="0" checked="true"> &nbsp; No';
        }

        $date_in_pur = '';
        if($data_pr->CHR_DATE_PURC_IN != NULL && $data_pr->CHR_DATE_PURC_IN != ""){ 
            $date_in_pur = substr(trim($data_pr->CHR_DATE_PURC_IN),4,2) . '/' . substr(trim($data_pr->CHR_DATE_PURC_IN),6,2) . '/' . substr(trim($data_pr->CHR_DATE_PURC_IN),0,4); 
        }

        $date_out_pur = '';
        if($data_pr->CHR_FLG_PURC == "1"){ 
            $date_out_pur = substr(trim($data_pr->CHR_DATE_PURC),4,2) . '/' . substr(trim($data_pr->CHR_DATE_PURC),6,2) . '/' . substr(trim($data_pr->CHR_DATE_PURC),0,4); 
        }

        $po_no = '';
        if($data_pr->CHR_PO_NO != NULL && $data_pr->CHR_PO_NO != "") { 
            $po_no = trim($data_pr->CHR_PO_NO);
        }
        
        $data .= '                  </div>';
        $data .= '                  <div class="col-sm-3">';
        $data .= '                      <input type="text" name="date_purc_in" style="width:110px;" class="datepicker" value="' . $date_in_pur . '">';
        $data .= '                  </div>';
        $data .= '                  <div class="col-sm-3">';
        $data .= '                      <input type="text" name="date_purc" style="width:110px;" class="datepicker" value="' . $date_out_pur . '">';
        $data .= '                  </div>';                                               
        $data .= '                  <div class="col-sm-3">';
        $data .= '                      <input type="text" name="po_no" class="form-control" value="' . $po_no . '">';
        $data .= '                  </div>';
        $data .= '              </div>';
        $data .= '          </div>';

        //===== START FOOTER
        $data .= '          <div class="modal-footer">';
        $data .= '              <div class="btn-group">';
        $data .= '                   <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';
        $data .= '                   <button type="submit" style="display:block;" class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Save this data"><i class="fa fa-check"></i> Update</button>';        
        $data .= '              </div>';
        $data .= '          </div>';
        //===== END FOOTER
        $data .= form_close();
        $data .= '       </div>';
        $data .= '   </div>';
        $data .= '</div>';

        $data .= ' <script>';
        $data .= ' $(function() {';
        $data .= '     $( ".datepicker" ).datepicker();';
        $data .= ' });';
        $data .= ' </script>';
    

        echo $data;

    }

    public function edit_progress_v2() {
        
        $step = $this->input->post("id_step");
        $pr_code = $this->input->post("id_pr");
        $fiscal_start = $this->input->post("id_fy");
        $kode_dept = $this->input->post("id_dept");
        $bgt_type = $this->input->post("id_type");
        $kode_sect = $this->input->post("id_sect");

        $data_pr = $this->report_budget_m->get_data_pr_by_trans_code($pr_code);

        $data = '';
        $data .= '<div class="modal-wrapper">';
        $data .= '   <div class="modal-dialog" style="font-size:11px;">';
        $data .= '      <div class="modal-content">';
        $data .= '          <div class="modal-header">';
        $data .= '              <button type="button" onclick="hide_edit_progress()" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>';
        $data .= '              <h4 class="modal-title" id="modalprogress"><strong>Edit Approval Progress - ' . $pr_code . '</strong></h4>';
        $data .= '          </div>';        

        $data .= form_open('budget/report_budget_c/update_progress/' . $step);
        $data .= '              <input name="KODE_TRANSAKSI" type="hidden" value="' . trim($pr_code) . '">';
        $data .= '              <input name="FISCAL" value="' . $fiscal_start . '" type="hidden">';
        $data .= '              <input name="DEPT" value="' . $kode_dept . '" type="hidden">';
        $data .= '              <input name="SECT" value="' . $kode_sect . '" type="hidden">';
        $data .= '              <input name="BUDGET_TYPE" value="' . $bgt_type . '" type="hidden">';

        if($step == 'mgr'){
            $data .= '          <!-- MANAGER -->';
            $data .= '          <div class="modal-body">';        
            $data .= '              <div class="form-group">';
            $data .= '                  <div class="col-sm-3">';
            $data .= '                      <label control-label"><strong>Finish MGR</strong></label>';
            $data .= '                  </div>';
            $data .= '                  <div class="col-sm-3">';
            $data .= '                      <label control-label">Date In</label>';
            $data .= '                  </div>';
            $data .= '                  <div class="col-sm-3">';
            $data .= '                      <label control-label">Date Out</label>';
            $data .= '                  </div>';
            $data .= '              </div>';
            $data .= '          </div>';
            $data .= '          <div class="modal-body">';
            $data .= '              <div class="form-group">';
            $data .= '                  <div class="col-sm-3">';
            
            if($data_pr->CHR_FLG_APPROVE_MAN == '1'){
                $data .= '                      <input type="radio" class="icheck" disabled name="flg_mgr" value="1" checked="true"> &nbsp; Yes &nbsp;';
                $data .= '                      <input type="radio" class="icheck" disabled name="flg_mgr" value="0"> &nbsp; No';
            } else {
                $data .= '                      <input type="radio" class="icheck" disabled name="flg_mgr" value="1"> &nbsp; Yes &nbsp;';
                $data .= '                      <input type="radio" class="icheck" disabled name="flg_mgr" value="0" checked="true"> &nbsp; No';
            }
                
            $date_in_mgr = '';
            if($data_pr->CHR_DATE_MAN_IN != NULL && $data_pr->CHR_DATE_MAN_IN != ""){ 
                $date_in_mgr = substr(trim($data_pr->CHR_DATE_MAN_IN),4,2) . '/' . substr(trim($data_pr->CHR_DATE_MAN_IN),6,2) . '/' . substr(trim($data_pr->CHR_DATE_MAN_IN),0,4); 
            }

            $date_out_mgr = '';
            if($data_pr->CHR_FLG_APPROVE_MAN == '1'){ 
                $date_out_mgr = substr(trim($data_pr->CHR_DATE_MAN),4,2) . '/' . substr(trim($data_pr->CHR_DATE_MAN),6,2) . '/' . substr(trim($data_pr->CHR_DATE_MAN),0,4);
            }
            
            $data .= '                  </div>';
            $data .= '                  <div class="col-sm-3">';
            $data .= '                      <input type="text" name="date_mgr_in" style="width:110px;" class="datepicker" value="' . $date_in_mgr . '">';
            $data .= '                  </div>';
            $data .= '                  <div class="col-sm-3">';
            $data .= '                      <input type="text" name="date_mgr" disabled style="width:110px;" class="datepicker" value="' . $date_out_mgr .'">';
            $data .= '                  </div>';
            $data .= '              </div>';
            $data .= '          </div>';

        } else if($step == 'gm'){
            $data .= '          <!-- GROUP MANAGER -->';
            $data .= '          <div class="modal-body">';
            $data .= '              <div class="form-group">';
            $data .= '                  <div class="col-sm-3">';
            $data .= '                      <label control-label"><strong>Finish GM</strong></label>';
            $data .= '                  </div>';
            $data .= '                  <div class="col-sm-3">';
            $data .= '                      <label control-label">Date In</label>';
            $data .= '                  </div>';
            $data .= '                  <div class="col-sm-3">';
            $data .= '                      <label control-label">Date Out</label>';
            $data .= '                  </div>';
            $data .= '              </div>';
            $data .= '          </div>';
            $data .= '          <div class="modal-body">';
            $data .= '              <div class="form-group">';
            $data .= '                  <div class="col-sm-3">';
            
            if($data_pr->CHR_FLG_APPROVE_GM == '1'){ 
                $data .= '                      <input type="radio" class="icheck" disabled name="flg_gm" value="1" checked="true"> &nbsp; Yes &nbsp;';
                $data .= '                      <input type="radio" class="icheck" disabled name="flg_gm" value="0"> &nbsp; No';
            } else {
                $data .= '                      <input type="radio" class="icheck" disabled name="flg_gm" value="1"> &nbsp; Yes &nbsp;';
                $data .= '                      <input type="radio" class="icheck" disabled name="flg_gm" value="0" checked="true"> &nbsp; No';
            }  
            
            $date_in_gm = '';
            if($data_pr->CHR_DATE_GM_IN != NULL && $data_pr->CHR_DATE_GM_IN != ""){ 
                $date_in_gm =  substr(trim($data_pr->CHR_DATE_GM_IN),4,2) . '/' . substr(trim($data_pr->CHR_DATE_GM_IN),6,2) . '/' . substr(trim($data_pr->CHR_DATE_GM_IN),0,4);
            }

            $date_out_gm = '';
            if($data_pr->CHR_FLG_APPROVE_GM == '1'){ 
                $date_out_gm = substr(trim($data_pr->CHR_DATE_GM),4,2) . '/' . substr(trim($data_pr->CHR_DATE_GM),6,2) . '/' . substr(trim($data_pr->CHR_DATE_GM),0,4);
            }
            
            $data .= '                  </div>';
            $data .= '                  <div class="col-sm-3">';
            $data .= '                      <input type="text" name="date_gm_in" style="width:110px;" class="datepicker" value="' . $date_in_gm . '">';
            $data .= '                  </div>';
            $data .= '                  <div class="col-sm-3">';
            $data .= '                      <input type="text" name="date_gm" disabled style="width:110px;" class="datepicker" value="' . $date_out_gm . '">';
            $data .= '                  </div>';
            $data .= '              </div>';
            $data .= '          </div>';

        } else if($step == 'dir'){
            $data .= '          <!-- DIREKTUR -->';
            $data .= '          <div class="modal-body">';
            $data .= '              <div class="form-group">';
            $data .= '                  <div class="col-sm-3">';
            $data .= '                       <label control-label"><strong>Finish DIR</strong></label>';
            $data .= '                  </div>';
            $data .= '                  <div class="col-sm-3">';
            $data .= '                      <label control-label">Date In</label>';
            $data .= '                  </div>';
            $data .= '                  <div class="col-sm-3">';
            $data .= '                      <label control-label">Date Out</label>';
            $data .= '                  </div>';
            $data .= '              </div>';
            $data .= '          </div>';
            $data .= '          <div class="modal-body">';
            $data .= '              <div class="form-group">';
            $data .= '                  <div class="col-sm-3">';

            if($data_pr->CHR_FLG_APPROVE_BOD == '1'){ 
                $data .= '                          <input type="radio" class="icheck" disabled name="flg_dir" value="1" checked="true"> &nbsp; Yes &nbsp;';
                $data .= '                          <input type="radio" class="icheck" disabled name="flg_dir" value="0"> &nbsp; No';
            } else {
                $data .= '                          <input type="radio" class="icheck" disabled name="flg_dir" value="1"> &nbsp; Yes &nbsp;';
                $data .= '                          <input type="radio" class="icheck" disabled name="flg_dir" value="0" checked="true"> &nbsp; No';
            }

            $date_in_dir = '';
            if($data_pr->CHR_DATE_BOD_IN != NULL && $data_pr->CHR_DATE_BOD_IN != ""){ 
                $date_in_dir = substr(trim($data_pr->CHR_DATE_BOD_IN),4,2) . '/' . substr(trim($data_pr->CHR_DATE_BOD_IN),6,2) . '/' . substr(trim($data_pr->CHR_DATE_BOD_IN),0,4); 
            }

            $date_out_dir = '';
            if($data_pr->CHR_FLG_APPROVE_BOD == '1'){ 
                $date_out_dir = substr(trim($data_pr->CHR_DATE_BOD),4,2) . '/' . substr(trim($data_pr->CHR_DATE_BOD),6,2) . '/' . substr(trim($data_pr->CHR_DATE_BOD),0,4); 
            }

            
            $data .= '                  </div>';
            $data .= '                  <div class="col-sm-3">';
            $data .= '                      <input type="text" name="date_dir_in" style="width:110px;" class="datepicker" value="' . $date_in_dir . '">';
            $data .= '                  </div>';
            $data .= '                  <div class="col-sm-3">';
            $data .= '                      <input type="text" name="date_dir" disabled style="width:110px;" class="datepicker" value="' . $date_out_dir . '">';
            $data .= '                  </div>';
            $data .= '              </div>';
            $data .= '          </div>';

        } else if($step == 'acc'){
            if($bgt_type == 'CAPEX'){

                $data .= '          <!-- ACCOUNTING -->';
                $data .= '          <div class="modal-body">';
                $data .= '              <div class="form-group">';
                $data .= '                  <div class="col-sm-3">';
                $data .= '                       <label control-label"><strong>Finish Acc</strong></label>';
                $data .= '                  </div>';
                $data .= '                  <div class="col-sm-3">';
                $data .= '                      <label control-label">Date In</label>';
                $data .= '                  </div>';
                $data .= '                  <div class="col-sm-3">';
                $data .= '                      <label control-label">Date Out</label>';
                $data .= '                  </div>';
                $data .= '                  <div class="col-sm-3">';
                $data .= '                      <label control-label">Asset No</label>';
                $data .= '                  </div>';
                $data .= '              </div>';
                $data .= '          </div>';
                $data .= '          <div class="modal-body">';
                $data .= '              <div class="form-group">';
                $data .= '                  <div class="col-sm-3">';
        
                if($data_pr->CHR_FLG_ACC == '1'){ 
                    $data .= '                           <input type="radio" class="icheck" name="flg_acc" value="1" checked="true"> &nbsp; Yes &nbsp;';
                    $data .= '                           <input type="radio" class="icheck" name="flg_acc" value="0"> &nbsp; No';
                } else {
                    $data .= '                           <input type="radio" class="icheck" name="flg_acc" value="1"> &nbsp; Yes &nbsp;';
                    $data .= '                           <input type="radio" class="icheck" name="flg_acc" value="0" checked="true"> &nbsp; No';
                }
        
                $date_in_acc = '';
                if($data_pr->CHR_DATE_ACC_IN != NULL && $data_pr->CHR_DATE_ACC_IN != ""){ 
                    $date_in_acc = substr(trim($data_pr->CHR_DATE_ACC_IN),4,2) . '/' . substr(trim($data_pr->CHR_DATE_ACC_IN),6,2) . '/' . substr(trim($data_pr->CHR_DATE_ACC_IN),0,4); 
                }
        
                $date_out_acc = '';
                if($data_pr->CHR_FLG_ACC == '1'){
                    $date_out_acc = substr(trim($data_pr->CHR_DATE_ACC),4,2) . '/' . substr(trim($data_pr->CHR_DATE_ACC),6,2) . '/' . substr(trim($data_pr->CHR_DATE_ACC),0,4); 
                }
        
                $asset_no = '';
                if($data_pr->CHR_ASSET_NO != NULL && $data_pr->CHR_ASSET_NO != ""){ 
                    $asset_no = $data_pr->CHR_ASSET_NO; 
                }
                
                $data .= '                  </div>';
                $data .= '                  <div class="col-sm-3">';
                $data .= '                      <input type="text" name="date_acc_in" style="width:110px;" class="datepicker" value="' . $date_in_acc . '">';
                $data .= '                  </div>';
                $data .= '                  <div class="col-sm-3">';
                $data .= '                      <input type="text" name="date_acc" style="width:110px;" class="datepicker" value="' . $date_out_acc . '">';
                $data .= '                  </div>';
                $data .= '                  <div class="col-sm-3">';
                $data .= '                      <input type="text" name="asset_no" style="width:110px;" class="form-control" value="' . $asset_no . '">';
                $data .= '                  </div>';
                $data .= '              </div>';
                $data .= '          </div>';
                
            }

        } else if($step == 'vp'){
            $data .= '          <!-- VP -->';
            $data .= '          <div class="modal-body">';
            $data .= '              <div class="form-group">';
            $data .= '                  <div class="col-sm-3">';
            $data .= '                       <label control-label"><strong>Finish VP</strong></label>';
            $data .= '                  </div>';
            $data .= '                  <div class="col-sm-3">';
            $data .= '                      <label control-label">Date In</label>';
            $data .= '                  </div>';
            $data .= '                  <div class="col-sm-3">';
            $data .= '                      <label control-label">Date Out</label>';
            $data .= '                  </div>';
            $data .= '              </div>';
            $data .= '          </div>';
            $data .= '          <div class="modal-body">';
            $data .= '              <div class="form-group">';
            $data .= '                  <div class="col-sm-3">';

            if($data_pr->CHR_FLG_VP == '1'){ 
                $data .= '                          <input type="radio" class="icheck" name="flg_vp" value="1" checked="true"> &nbsp; Yes &nbsp;';
                $data .= '                          <input type="radio" class="icheck" name="flg_vp" value="0"> &nbsp; No';
            } else {
                $data .= '                          <input type="radio" class="icheck" name="flg_vp" value="1"> &nbsp; Yes &nbsp;';
                $data .= '                          <input type="radio" class="icheck" name="flg_vp" value="0" checked="true"> &nbsp; No';
            }

            $date_in_vp = '';
            if($data_pr->CHR_DATE_VP_IN != NULL && $data_pr->CHR_DATE_VP_IN != ""){ 
                $date_in_vp = substr(trim($data_pr->CHR_DATE_VP_IN),4,2) . '/' . substr(trim($data_pr->CHR_DATE_VP_IN),6,2) . '/' . substr(trim($data_pr->CHR_DATE_VP_IN),0,4); 
            }

            $date_out_vp = '';
            if($data_pr->CHR_FLG_VP == "1"){ 
                $date_out_vp = substr(trim($data_pr->CHR_DATE_VP),4,2) . '/' . substr(trim($data_pr->CHR_DATE_VP),6,2) . '/' . substr(trim($data_pr->CHR_DATE_VP),0,4); 
            }

            $data .= '                  </div>';
            $data .= '                  <div class="col-sm-3">';
            $data .= '                      <input type="text" name="date_vp_in" style="width:110px;" class="datepicker" value="' . $date_in_vp . '">';
            $data .= '                  </div>';
            $data .= '                  <div class="col-sm-3">';
            $data .= '                      <input type="text" name="date_vp" style="width:110px;" class="datepicker" value="' . $date_out_vp . '">';
            $data .= '                  </div>';
            $data .= '              </div>';
            $data .= '          </div>';

        } else if($step == 'presdir'){
            $data .= '          <!-- PRESDIR -->';
            $data .= '          <div class="modal-body">';
            $data .= '              <div class="form-group">';
            $data .= '                  <div class="col-sm-3">';
            $data .= '                      <label control-label"><strong>Finish Presdir</strong></label>';
            $data .= '                  </div>';
            $data .= '                  <div class="col-sm-3">';
            $data .= '                      <label control-label">Date In</label>';
            $data .= '                  </div>';
            $data .= '                  <div class="col-sm-3">';
            $data .= '                      <label control-label">Date Out</label>';
            $data .= '                  </div>';
            $data .= '              </div>';
            $data .= '          </div>';
            $data .= '          <div class="modal-body">';
            $data .= '              <div class="form-group">';
            $data .= '                  <div class="col-sm-3">';

            if($data_pr->CHR_FLG_PRESDIR == '1'){ 
                $data .= '                          <input type="radio" class="icheck" name="flg_presdir" value="1" checked="true"> &nbsp; Yes &nbsp;';
                $data .= '                          <input type="radio" class="icheck" name="flg_presdir" value="0"> &nbsp; No';
            } else {
                $data .= '                          <input type="radio" class="icheck" name="flg_presdir" value="1"> &nbsp; Yes &nbsp;';
                $data .= '                          <input type="radio" class="icheck" name="flg_presdir" value="0" checked="true"> &nbsp; No';
            }

            $date_in_presdir = '';
            if($data_pr->CHR_DATE_PRESDIR_IN != NULL && $data_pr->CHR_DATE_PRESDIR_IN != ""){ 
                $date_in_presdir = substr(trim($data_pr->CHR_DATE_PRESDIR_IN),4,2) . '/' . substr(trim($data_pr->CHR_DATE_PRESDIR_IN),6,2) . '/' . substr(trim($data_pr->CHR_DATE_PRESDIR_IN),0,4); 
            }

            $date_out_presdir = '';
            if($data_pr->CHR_FLG_PRESDIR == "1"){ 
                $date_out_presdir = substr(trim($data_pr->CHR_DATE_PRESDIR),4,2) . '/' . substr(trim($data_pr->CHR_DATE_PRESDIR),6,2) . '/' . substr(trim($data_pr->CHR_DATE_PRESDIR),0,4); 
            }
            
            $data .= '                  </div>';
            $data .= '                  <div class="col-sm-3">';
            $data .= '                      <input type="text" name="date_presdir_in" style="width:110px;" class="datepicker" value="' . $date_in_presdir . '">';
            $data .= '                  </div>';
            $data .= '                  <div class="col-sm-3">';
            $data .= '                      <input type="text" name="date_presdir" style="width:110px;" class="datepicker" value="' . $date_out_presdir . '">';
            $data .= '                  </div>';
            $data .= '              </div>';
            $data .= '          </div>';
            
        } else if($step == 'gudtool'){
            $data .= '          <!-- GUDTOOL -->';
            $data .= '          <div class="modal-body">';
            $data .= '              <div class="form-group">';
            $data .= '                  <div class="col-sm-3">';
            $data .= '                      <label control-label"><strong>Finish Gudang</strong></label>';
            $data .= '                  </div>';
            $data .= '                  <div class="col-sm-3">';
            $data .= '                      <label control-label">Date In</label>';
            $data .= '                  </div>';
            $data .= '                  <div class="col-sm-3">';
            $data .= '                      <label control-label">Date Out</label>';
            $data .= '                  </div>';
            $data .= '                  <div class="col-sm-3">';
            $data .= '                      <label control-label">PR No</label>';
            $data .= '                  </div>';
            $data .= '              </div>';
            $data .= '          </div>';
            $data .= '          <div class="modal-body">';
            $data .= '              <div class="form-group">';
            $data .= '                  <div class="col-sm-3">';

            if($data_pr->CHR_FLG_GUDTOOL == '1'){ 
                $data .= '                          <input type="radio" class="icheck" name="flg_gudtool" value="1" checked="true"> &nbsp; Yes &nbsp;';
                $data .= '                          <input type="radio" class="icheck" name="flg_gudtool" value="0"> &nbsp; No';
            } else {
                $data .= '                          <input type="radio" class="icheck" name="flg_gudtool" value="1"> &nbsp; Yes &nbsp;';
                $data .= '                          <input type="radio" class="icheck" name="flg_gudtool" value="0" checked="true"> &nbsp; No';
            }

            $date_in_gudtool = '';
            if($data_pr->CHR_DATE_GUDTOOL_IN != NULL && $data_pr->CHR_DATE_GUDTOOL_IN != ""){ 
                $date_in_gudtool = substr(trim($data_pr->CHR_DATE_GUDTOOL_IN),4,2) . '/' . substr(trim($data_pr->CHR_DATE_GUDTOOL_IN),6,2) . '/' . substr(trim($data_pr->CHR_DATE_GUDTOOL_IN),0,4); 
            }

            $date_out_gudtool = '';
            if($data_pr->CHR_FLG_GUDTOOL == "1"){ 
                $date_out_gudtool = substr(trim($data_pr->CHR_DATE_GUDTOOL),4,2) . '/' . substr(trim($data_pr->CHR_DATE_GUDTOOL),6,2) . '/' . substr(trim($data_pr->CHR_DATE_GUDTOOL),0,4); 
            }

            $pr_no = '';
            if($data_pr->CHR_PR_NO != NULL && $data_pr->CHR_PR_NO != "") { 
                $pr_no = trim($data_pr->CHR_PR_NO);
            }
            
            $data .= '                  </div>';
            $data .= '                  <div class="col-sm-3">';
            $data .= '                      <input type="text" name="date_gudtool_in" style="width:110px;" class="datepicker" value="' . $date_in_gudtool . '">';
            $data .= '                  </div>';
            $data .= '                  <div class="col-sm-3">';
            $data .= '                      <input type="text" name="date_gudtool" style="width:110px;" class="datepicker" value="' . $date_out_gudtool . '">';
            $data .= '                  </div>';                                               
            $data .= '                  <div class="col-sm-3">';
            $data .= '                      <input type="text" name="pr_no" class="form-control" value="' . $pr_no . '">';
            $data .= '                  </div>';
            $data .= '              </div>';
            $data .= '          </div>';

        } else if($step == 'purc'){
            $data .= '          <!-- PURCHASING -->';
            $data .= '          <div class="modal-body">';
            $data .= '              <div class="form-group">';
            $data .= '                  <div class="col-sm-3">';
            $data .= '                      <label control-label"><strong>Finish Purch</strong></label>';
            $data .= '                  </div>';
            $data .= '                  <div class="col-sm-3">';
            $data .= '                      <label control-label">Date In</label>';
            $data .= '                  </div>';
            $data .= '                  <div class="col-sm-3">';
            $data .= '                      <label control-label">Date Out</label>';
            $data .= '                  </div>';
            $data .= '                  <div class="col-sm-3">';
            $data .= '                      <label control-label">PO No</label>';
            $data .= '                  </div>';
            $data .= '              </div>';
            $data .= '          </div>';
            $data .= '          <div class="modal-body">';
            $data .= '              <div class="form-group">';
            $data .= '                  <div class="col-sm-3">';
    
            if($data_pr->CHR_FLG_PURC == '1'){ 
                $data .= '                          <input type="radio" class="icheck" name="flg_purc" value="1" checked="true"> &nbsp; Yes &nbsp;';
                $data .= '                          <input type="radio" class="icheck" name="flg_purc" value="0"> &nbsp; No';
            } else {
                $data .= '                          <input type="radio" class="icheck" name="flg_purc" value="1"> &nbsp; Yes &nbsp;';
                $data .= '                          <input type="radio" class="icheck" name="flg_purc" value="0" checked="true"> &nbsp; No';
            }
    
            $date_in_pur = '';
            if($data_pr->CHR_DATE_PURC_IN != NULL && $data_pr->CHR_DATE_PURC_IN != ""){ 
                $date_in_pur = substr(trim($data_pr->CHR_DATE_PURC_IN),4,2) . '/' . substr(trim($data_pr->CHR_DATE_PURC_IN),6,2) . '/' . substr(trim($data_pr->CHR_DATE_PURC_IN),0,4); 
            }
    
            $date_out_pur = '';
            if($data_pr->CHR_FLG_PURC == "1"){ 
                $date_out_pur = substr(trim($data_pr->CHR_DATE_PURC),4,2) . '/' . substr(trim($data_pr->CHR_DATE_PURC),6,2) . '/' . substr(trim($data_pr->CHR_DATE_PURC),0,4); 
            }
    
            $po_no = '';
            if($data_pr->CHR_PO_NO != NULL && $data_pr->CHR_PO_NO != "") { 
                $po_no = trim($data_pr->CHR_PO_NO);
            }
            
            $data .= '                  </div>';
            $data .= '                  <div class="col-sm-3">';
            $data .= '                      <input type="text" name="date_purc_in" style="width:110px;" class="datepicker" value="' . $date_in_pur . '">';
            $data .= '                  </div>';
            $data .= '                  <div class="col-sm-3">';
            $data .= '                      <input type="text" name="date_purc" style="width:110px;" class="datepicker" value="' . $date_out_pur . '">';
            $data .= '                  </div>';                                               
            $data .= '                  <div class="col-sm-3">';
            $data .= '                      <input type="text" name="po_no" class="form-control" value="' . $po_no . '">';
            $data .= '                  </div>';
            $data .= '              </div>';
            $data .= '          </div>';
        }

        $data .= '          <div>&nbsp;</div>';
        //===== START FOOTER
        $data .= '          <div class="modal-footer">';
        $data .= '              <div class="btn-group">';
        $data .= '                   <button type="button" onclick="hide_edit_progress()" class="btn btn-default" data-dismiss="modal">Close</button>';
        $data .= '                   <button type="submit" style="display:block;" class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Save this data"><i class="fa fa-check"></i> Update</button>';        
        $data .= '              </div>';
        $data .= '          </div>';
        //===== END FOOTER
        $data .= form_close();
        $data .= '       </div>';
        $data .= '   </div>';
        $data .= '</div>';

        $data .= ' <script>';
        $data .= ' $(function() {';
        $data .= '     $( ".datepicker" ).datepicker();';
        $data .= ' });';
        $data .= ' </script>';    

        echo $data;

    }

    public function edit_batch() {
        
        $step = $this->input->post("id_step");
        $fiscal_start = $this->input->post("id_fy");
        $kode_dept = $this->input->post("id_dept");
        $bgt_type = $this->input->post("id_type");
        $kode_sect = $this->input->post("id_sect");

        $list_pr_no = $this->report_budget_m->get_list_pr_no($fiscal_start, $bgt_type, $kode_dept, $kode_sect);            
        
        $data = '';
        $data .= '<div class="modal-wrapper">';
        $data .= '   <div class="modal-dialog">';
        $data .= '      <div class="modal-content">';
        $data .= '          <div class="modal-header">';
        $data .= '              <button type="button" onclick="hide_edit_batch()" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>';
        $data .= '              <h4 class="modal-title" id="modalprogress"><strong>Edit Approval Progress - ' . strtoupper($step) . '</strong></h4>';
        $data .= '          </div>';        

        $data .= form_open('budget/report_budget_c/update_progress_batch/' . $step);
        $data .= '              <input name="FISCAL" value="' . $fiscal_start . '" type="hidden">';
        $data .= '              <input name="DEPT" value="' . $kode_dept . '" type="hidden">';
        $data .= '              <input name="SECT" value="' . $kode_sect . '" type="hidden">';
        $data .= '              <input name="BUDGET_TYPE" value="' . $bgt_type . '" type="hidden">';

        $data .= '          <div class="modal-body">'; 
        $data .= '              <div class="form-group">';
        $data .= '                  <label class="col-sm-3 control-label">Approval Sheet No</label>';
        $data .= '                  <div>';
        $data .= '                       <select name="KODE_TRANSAKSI[]" multiple="multiple" id="e1" class="form-control" style="width:300px">';
        
        foreach ($list_pr_no as $isi) {
                $data .= '                   <option value="' . $isi->CHR_KODE_TRANSAKSI . '">' . $isi->CHR_KODE_TRANSAKSI . '</option>';
        }
        
        $data .= '                       </select>';
        $data .= '                  </div>';
        $data .= '               </div>';
        $data .= '          </div>';

        if($step == 'mgr'){
            $data .= '          <!-- MANAGER -->';
            $data .= '          <div class="modal-body">';        
            $data .= '              <div class="form-group">';
            $data .= '                  <div class="col-sm-3">';
            $data .= '                      <label control-label"><strong>Finish MGR</strong></label>';
            $data .= '                  </div>';
            $data .= '                  <div class="col-sm-3">';
            $data .= '                      <label control-label">Date In</label>';
            $data .= '                  </div>';
            $data .= '                  <div class="col-sm-3">';
            $data .= '                      <label control-label">Date Out</label>';
            $data .= '                  </div>';
            $data .= '              </div>';
            $data .= '          </div>';
            $data .= '          <div class="modal-body">';
            $data .= '              <div class="form-group">';
            $data .= '                  <div class="col-sm-3">';            
            $data .= '                      <input type="radio" class="icheck" disabled name="flg_mgr" value="1"> &nbsp; Yes &nbsp;';
            $data .= '                      <input type="radio" class="icheck" disabled name="flg_mgr" value="0"> &nbsp; No';
            $data .= '                  </div>';
            $data .= '                  <div class="col-sm-3">';
            $data .= '                      <input type="text" name="date_mgr_in" style="width:110px;" class="datepicker" value="">';
            $data .= '                  </div>';
            $data .= '                  <div class="col-sm-3">';
            $data .= '                      <input type="text" name="date_mgr" disabled style="width:110px;" class="datepicker" value="">';
            $data .= '                  </div>';
            $data .= '              </div>';
            $data .= '          </div>';

        } else if($step == 'gm'){
            $data .= '          <!-- GROUP MANAGER -->';
            $data .= '          <div class="modal-body">';
            $data .= '              <div class="form-group">';
            $data .= '                  <div class="col-sm-3">';
            $data .= '                      <label control-label"><strong>Finish GM</strong></label>';
            $data .= '                  </div>';
            $data .= '                  <div class="col-sm-3">';
            $data .= '                      <label control-label">Date In</label>';
            $data .= '                  </div>';
            $data .= '                  <div class="col-sm-3">';
            $data .= '                      <label control-label">Date Out</label>';
            $data .= '                  </div>';
            $data .= '              </div>';
            $data .= '          </div>';
            $data .= '          <div class="modal-body">';
            $data .= '              <div class="form-group">';
            $data .= '                  <div class="col-sm-3">';
            $data .= '                      <input type="radio" class="icheck" disabled name="flg_gm" value="1"> &nbsp; Yes &nbsp;';
            $data .= '                      <input type="radio" class="icheck" disabled name="flg_gm" value="0"> &nbsp; No';
            $data .= '                  </div>';
            $data .= '                  <div class="col-sm-3">';
            $data .= '                      <input type="text" name="date_gm_in" style="width:110px;" class="datepicker" value="">';
            $data .= '                  </div>';
            $data .= '                  <div class="col-sm-3">';
            $data .= '                      <input type="text" name="date_gm" disabled style="width:110px;" class="datepicker" value="">';
            $data .= '                  </div>';
            $data .= '              </div>';
            $data .= '          </div>';

        } else if($step == 'dir'){
            $data .= '          <!-- DIREKTUR -->';
            $data .= '          <div class="modal-body">';
            $data .= '              <div class="form-group">';
            $data .= '                  <div class="col-sm-3">';
            $data .= '                       <label control-label"><strong>Finish DIR</strong></label>';
            $data .= '                  </div>';
            $data .= '                  <div class="col-sm-3">';
            $data .= '                      <label control-label">Date In</label>';
            $data .= '                  </div>';
            $data .= '                  <div class="col-sm-3">';
            $data .= '                      <label control-label">Date Out</label>';
            $data .= '                  </div>';
            $data .= '              </div>';
            $data .= '          </div>';
            $data .= '          <div class="modal-body">';
            $data .= '              <div class="form-group">';
            $data .= '                  <div class="col-sm-3">';
            $data .= '                          <input type="radio" class="icheck" disabled name="flg_dir" value="1"> &nbsp; Yes &nbsp;';
            $data .= '                          <input type="radio" class="icheck" disabled name="flg_dir" value="0"> &nbsp; No';
            $data .= '                  </div>';
            $data .= '                  <div class="col-sm-3">';
            $data .= '                      <input type="text" name="date_dir_in" style="width:110px;" class="datepicker" value="">';
            $data .= '                  </div>';
            $data .= '                  <div class="col-sm-3">';
            $data .= '                      <input type="text" name="date_dir" disabled style="width:110px;" class="datepicker" value="">';
            $data .= '                  </div>';
            $data .= '              </div>';
            $data .= '          </div>';

        } else if($step == 'acc'){
            if($bgt_type == 'CAPEX'){

                $data .= '          <!-- ACCOUNTING -->';
                $data .= '          <div class="modal-body">';
                $data .= '              <div class="form-group">';
                $data .= '                  <div class="col-sm-3">';
                $data .= '                       <label control-label"><strong>Finish Acc</strong></label>';
                $data .= '                  </div>';
                $data .= '                  <div class="col-sm-3">';
                $data .= '                      <label control-label">Date In</label>';
                $data .= '                  </div>';
                $data .= '                  <div class="col-sm-3">';
                $data .= '                      <label control-label">Date Out</label>';
                $data .= '                  </div>';
                $data .= '              </div>';
                $data .= '          </div>';
                $data .= '          <div class="modal-body">';
                $data .= '              <div class="form-group">';
                $data .= '                  <div class="col-sm-3">';
                $data .= '                           <input type="radio" class="icheck" name="flg_acc" value="1"> &nbsp; Yes &nbsp;';
                $data .= '                           <input type="radio" class="icheck" name="flg_acc" value="0" checked="true"> &nbsp; No';
                $data .= '                  </div>';
                $data .= '                  <div class="col-sm-3">';
                $data .= '                      <input type="text" name="date_acc_in" style="width:110px;" class="datepicker" value="">';
                $data .= '                  </div>';
                $data .= '                  <div class="col-sm-3">';
                $data .= '                      <input type="text" name="date_acc" style="width:110px;" class="datepicker" value="">';
                $data .= '                  </div>';
                $data .= '              </div>';
                $data .= '          </div>';
                
            }

        } else if($step == 'vp'){
            $data .= '          <!-- VP -->';
            $data .= '          <div class="modal-body">';
            $data .= '              <div class="form-group">';
            $data .= '                  <div class="col-sm-3">';
            $data .= '                       <label control-label"><strong>Finish VP</strong></label>';
            $data .= '                  </div>';
            $data .= '                  <div class="col-sm-3">';
            $data .= '                      <label control-label">Date In</label>';
            $data .= '                  </div>';
            $data .= '                  <div class="col-sm-3">';
            $data .= '                      <label control-label">Date Out</label>';
            $data .= '                  </div>';
            $data .= '              </div>';
            $data .= '          </div>';
            $data .= '          <div class="modal-body">';
            $data .= '              <div class="form-group">';
            $data .= '                  <div class="col-sm-3">';
            $data .= '                          <input type="radio" class="icheck" name="flg_vp" value="1"> &nbsp; Yes &nbsp;';
            $data .= '                          <input type="radio" class="icheck" name="flg_vp" value="0" checked="true"> &nbsp; No';
            $data .= '                  </div>';
            $data .= '                  <div class="col-sm-3">';
            $data .= '                      <input type="text" name="date_vp_in" style="width:110px;" class="datepicker" value="">';
            $data .= '                  </div>';
            $data .= '                  <div class="col-sm-3">';
            $data .= '                      <input type="text" name="date_vp" style="width:110px;" class="datepicker" value="">';
            $data .= '                  </div>';
            $data .= '              </div>';
            $data .= '          </div>';

        } else if($step == 'presdir'){
            $data .= '          <!-- PRESDIR -->';
            $data .= '          <div class="modal-body">';
            $data .= '              <div class="form-group">';
            $data .= '                  <div class="col-sm-3">';
            $data .= '                      <label control-label"><strong>Finish Presdir</strong></label>';
            $data .= '                  </div>';
            $data .= '                  <div class="col-sm-3">';
            $data .= '                      <label control-label">Date In</label>';
            $data .= '                  </div>';
            $data .= '                  <div class="col-sm-3">';
            $data .= '                      <label control-label">Date Out</label>';
            $data .= '                  </div>';
            $data .= '              </div>';
            $data .= '          </div>';
            $data .= '          <div class="modal-body">';
            $data .= '              <div class="form-group">';
            $data .= '                  <div class="col-sm-3">';
            $data .= '                          <input type="radio" class="icheck" name="flg_presdir" value="1"> &nbsp; Yes &nbsp;';
            $data .= '                          <input type="radio" class="icheck" name="flg_presdir" value="0" checked="true"> &nbsp; No';
            $data .= '                  </div>';
            $data .= '                  <div class="col-sm-3">';
            $data .= '                      <input type="text" name="date_presdir_in" style="width:110px;" class="datepicker" value="">';
            $data .= '                  </div>';
            $data .= '                  <div class="col-sm-3">';
            $data .= '                      <input type="text" name="date_presdir" style="width:110px;" class="datepicker" value="">';
            $data .= '                  </div>';
            $data .= '              </div>';
            $data .= '          </div>';
            
        } else if($step == 'gudtool'){
            $data .= '          <!-- GUDTOOL -->';
            $data .= '          <div class="modal-body">';
            $data .= '              <div class="form-group">';
            $data .= '                  <div class="col-sm-3">';
            $data .= '                      <label control-label"><strong>Finish Gudang</strong></label>';
            $data .= '                  </div>';
            $data .= '                  <div class="col-sm-3">';
            $data .= '                      <label control-label">Date In</label>';
            $data .= '                  </div>';
            $data .= '                  <div class="col-sm-3">';
            $data .= '                      <label control-label">Date Out</label>';
            $data .= '                  </div>';
            $data .= '              </div>';
            $data .= '          </div>';
            $data .= '          <div class="modal-body">';
            $data .= '              <div class="form-group">';
            $data .= '                  <div class="col-sm-3">';
            $data .= '                          <input type="radio" class="icheck" name="flg_gudtool" value="1"> &nbsp; Yes &nbsp;';
            $data .= '                          <input type="radio" class="icheck" name="flg_gudtool" value="0" checked="true"> &nbsp; No';
            $data .= '                  </div>';
            $data .= '                  <div class="col-sm-3">';
            $data .= '                      <input type="text" name="date_gudtool_in" style="width:110px;" class="datepicker" value="">';
            $data .= '                  </div>';
            $data .= '                  <div class="col-sm-3">';
            $data .= '                      <input type="text" name="date_gudtool" style="width:110px;" class="datepicker" value="">';
            $data .= '                  </div>';
            $data .= '              </div>';
            $data .= '          </div>';

        } else if($step == 'purc'){
            $data .= '          <!-- PURCHASING -->';
            $data .= '          <div class="modal-body">';
            $data .= '              <div class="form-group">';
            $data .= '                  <div class="col-sm-3">';
            $data .= '                      <label control-label"><strong>Finish Purch</strong></label>';
            $data .= '                  </div>';
            $data .= '                  <div class="col-sm-3">';
            $data .= '                      <label control-label">Date In</label>';
            $data .= '                  </div>';
            $data .= '                  <div class="col-sm-3">';
            $data .= '                      <label control-label">Date Out</label>';
            $data .= '                  </div>';
            $data .= '              </div>';
            $data .= '          </div>';
            $data .= '          <div class="modal-body">';
            $data .= '              <div class="form-group">';
            $data .= '                  <div class="col-sm-3">';
            $data .= '                          <input type="radio" class="icheck" name="flg_purc" value="1"> &nbsp; Yes &nbsp;';
            $data .= '                          <input type="radio" class="icheck" name="flg_purc" value="0" checked="true"> &nbsp; No';
            $data .= '                  </div>';
            $data .= '                  <div class="col-sm-3">';
            $data .= '                      <input type="text" name="date_purc_in" style="width:110px;" class="datepicker" value="">';
            $data .= '                  </div>';
            $data .= '                  <div class="col-sm-3">';
            $data .= '                      <input type="text" name="date_purc" style="width:110px;" class="datepicker" value="">';
            $data .= '                  </div>';
            $data .= '              </div>';
            $data .= '          </div>';
        }

        $data .= '          <div>&nbsp;</div>';
        //===== START FOOTER
        $data .= '          <div class="modal-footer">';
        $data .= '              <div class="btn-group">';
        $data .= '                   <button type="button" onclick="hide_edit_batch()" class="btn btn-default" data-dismiss="modal">Close</button>';
        $data .= '                   <button type="submit" style="display:block;" class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Save this data"><i class="fa fa-check"></i> Update</button>';        
        $data .= '              </div>';
        $data .= '          </div>';
        //===== END FOOTER
        $data .= form_close();
        $data .= '       </div>';
        $data .= '   </div>';
        $data .= '</div>';

        $data .= ' <script>';
        $data .= ' $(function() {';
        $data .= '     $( ".datepicker" ).datepicker();';
        // $data .= '     $("#e1").multiselect();';
        $data .= ' });';
        
        $data .= ' </script>';

        echo $data;

    }

}

?>
