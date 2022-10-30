<?php header("Content-type: text/html; charset=iso-8859-1");

class new_propose_budget_c extends CI_Controller {

    private $layout = '/template/head';
    private $back_to_manage = 'budget/new_propose_budget_c/index/';

    public function __construct() {
        parent::__construct();
        $this->load->model('budget/new_propose_budget_m');
        $this->load->model('basis/log_m');
        $this->load->model('basis/role_module_m');
        $this->load->model('portal/news_m');
        $this->load->model('budget/fiscal_m');
        $this->load->model('organization/dept_m');
        $this->load->model('portal/notification_m');
        $this->load->model('basis/user_m');
    }

    //----------------------------// EDIT BY ANP //---------------------------//
    function index($msg = NULL, $fiscal_start = NULL, $year_month = NULL, $kode_dept = NULL) {
        $this->role_module_m->authorization('44');
        
        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>x</button><strong>Approving success. </strong> The data is successfully approved </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>x</button><strong>Failed. </strong>to The data is failed to update </div >";
        } elseif ($msg == 4) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>x</button><strong>Deleting success. </strong> The data is successfully deleted </div >";
        } else {
            $msg = "";
        }
        
        if ($fiscal_start == NULL){
            $fiscal_start = $this->fiscal_m->get_default_fiscal_year()->CHR_FISCAL_YEAR_START;
        }
        
        $fiscal_year = $this->fiscal_m->get_selected_fiscal_year($fiscal_start);
        $fiscal_end = $fiscal_year->CHR_FISCAL_YEAR_END;
        
        if($year_month == NULL){
            $year_month = date("Ym");
        }
        
        $year = substr($year_month,0,4);
        $month = substr($year_month,4,2);
        
        $session = $this->session->all_userdata();
        
        //FOR --> ADMIN & ADMIN BUDGET
        if ($session['ROLE'] === 2 || $session['ROLE'] === 1 ) { 
            if($kode_dept == NULL){
                $id_dept = $session['DEPT'];
                $kode_dept = $this->new_propose_budget_m->get_user_dept($id_dept)->CHR_DEPT;
            }
            
            if($kode_dept == 'MISY'){
                $kode_dept = 'MIS';
            } else if($kode_dept == 'PPIC'){
                $kode_dept = 'PPC';
            } else if($kode_dept == 'QUA'){
                $kode_dept = 'QAS';
            } else {
                $kode_dept = trim($kode_dept);
            }
            
            $data['all_propose'] = $this->new_propose_budget_m->get_all_propose($fiscal_start, $kode_dept, $year, $month);
            
            $contain = 'budget/propose_budget/new_manage_propose_monthly_budget_v';
            
        //FOR --> MANAGER
        } else if ($session['ROLE'] === 5 || $session['ROLE'] === 39 || $session['ROLE'] === 45 || $session['ROLE'] === 61 || $session['ROLE'] === 10) {
            $id_dept = $session['DEPT'];
            $kode_dept = $this->new_propose_budget_m->get_user_dept($id_dept)->CHR_DEPT;
            
            if($session['NPK'] === '0512'){
               $kode_dept = 'KQC'; 
            }
            
            //Mapping dept AIS to BUDGET AII
            if($kode_dept == 'MISY'){
                $kode_dept = 'MIS';
            } else if($kode_dept == 'PPIC'){
                $kode_dept = 'PPC';
            } else if($kode_dept == 'QUA'){
                $kode_dept = 'QAS';
            } else {
                $kode_dept = trim($kode_dept);
            }
            
            $data['all_propose'] = $this->new_propose_budget_m->get_all_propose($fiscal_start, $kode_dept, $year, $month);
           
            $contain = 'budget/propose_budget/new_manage_propose_monthly_budget_v';   
        }
                
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(199);
        $data['news'] = $this->news_m->get_news();
        $data['role'] = $session['ROLE'];
        $data['msg'] = $msg;
        
        //--- For list value
        $data['all_dept'] = $this->new_propose_budget_m->get_all_dept();
        $data['all_fiscal'] = $this->fiscal_m->get_all_fiscal_year();       
        $data['all_budget_type'] = $this->new_propose_budget_m->get_all_budget_type();
                        
        //--- Value selected
        $data['fiscal_start'] = $fiscal_start;
        $data['fiscal_end'] = $fiscal_end;
        $data['month'] = $month;
        $data['year_month'] = $year_month;
        $data['kode_dept'] = $kode_dept;
                
        $data['content'] = $contain;
        $data['title'] = 'Manage Propose Monthly Budget';

        $this->load->view($this->layout, $data);
    }
    
    function propose_budget($fiscal_start = NULL, $year_month = NULL, $kode_dept = NULL) {
        $this->role_module_m->authorization('44');
        
        if ($fiscal_start == NULL){
            $fiscal_start = $this->fiscal_m->get_default_fiscal_year()->CHR_FISCAL_YEAR_START;
        }
        
        $fiscal_year = $this->fiscal_m->get_selected_fiscal_year($fiscal_start);
        $fiscal_end = $fiscal_year->CHR_FISCAL_YEAR_END;
        $fiscal = $fiscal_start.$fiscal_end;
        
        $year = substr($year_month,0,4);
        $month = substr($year_month,4,2);
        
        $session = $this->session->all_userdata();
        //FOR --> ADMIN & ADMIN BUDGET
        if ($session['ROLE'] === 2 || $session['ROLE'] === 1 ) {            
            //Mapping dept AIS to BUDGET AII
            if($kode_dept == 'MISY'){
                $kode_dept = 'MIS';
            } else if($kode_dept == 'PPIC'){
                $kode_dept = 'PPC';
            } else if($kode_dept == 'QUA'){
                $kode_dept = 'QAS';
            } else {
                $kode_dept = trim($kode_dept);
            }            
            
            $exist_no_propose =  $this->new_propose_budget_m->get_exist_no_propose($fiscal_start, $year, $month, $kode_dept);
            if($exist_no_propose == NULL){
                $no_propose = 'PROP/' . trim($kode_dept) . '/' . $year_month . '/0001';                
            } else {
                $latest_no = substr($exist_no_propose->CHR_NO_PROPOSE, 16, 4);
                $new_no = sprintf("%04d", $latest_no + 1);
                $no_propose = 'PROP/' . trim($kode_dept) . '/' . $year_month . '/' . $new_no;
            }
            
            $data_propose = array(
                                    'CHR_NO_PROPOSE' => $no_propose,
                                    'CHR_TRANS_DATE' => date('Ymd'),
                                    'CHR_DEPT' => $kode_dept,
                                    'CHR_YEAR_BUDGET' => $fiscal_start,
                                    'CHR_YEAR_PROPOSE' => $year,
                                    'CHR_MONTH_PROPOSE' => $month,
                                    'CHR_FLG_SWITCH' => 0,
                                    'CHR_FLG_DELETE_PROP' => 0,
                                    'CHR_CREATED_BY' => $session['USERNAME'],
                                    'CHR_CREATED_DATE' => date('Ymd'),
                                    'CHR_CREATED_TIME' => date('His')
            );
            
            $this->new_propose_budget_m->insert_new_propose($data_propose);
            //Create notes
            $this->new_propose_budget_m->insert_new_notes($no_propose);
            
            $data['all_list_propose'] = $this->new_propose_budget_m->get_all_list_propose($no_propose);
            
            //$data['detail_all_list_budget'] = $this->new_propose_budget_m->get_detail_all_list_budget($fiscal, $kode_dept, $bgt_type, $no_propose);
            
            $data['propose_capex'] = $this->new_propose_budget_m->get_propose_capex($no_propose);
            $data['propose_repma'] = $this->new_propose_budget_m->get_propose_repma($no_propose);
            $data['propose_right'] = $this->new_propose_budget_m->get_propose_right($no_propose);
            $data['propose_tooeq'] = $this->new_propose_budget_m->get_propose_tooeq($no_propose);
            $data['propose_offeq'] = $this->new_propose_budget_m->get_propose_offeq($no_propose);
            $data['propose_trial'] = $this->new_propose_budget_m->get_propose_trial($no_propose);
            $data['propose_empwa'] = $this->new_propose_budget_m->get_propose_empwa($no_propose);
            $data['propose_engfe'] = $this->new_propose_budget_m->get_propose_engfe($no_propose);
            $data['propose_itexp'] = $this->new_propose_budget_m->get_propose_itexp($no_propose);
            $data['propose_renta'] = $this->new_propose_budget_m->get_propose_renta($no_propose);
            $data['propose_rndev'] = $this->new_propose_budget_m->get_propose_rndev($no_propose);
            $data['propose_donat'] = $this->new_propose_budget_m->get_propose_donat($no_propose);
            $data['propose_enter'] = $this->new_propose_budget_m->get_propose_enter($no_propose);
            
            $contain = 'budget/propose_budget/new_propose_monthly_budget_v';
            
        //FOR --> MANAGER
        } else if ($session['ROLE'] === 5 || $session['ROLE'] === 39 || $session['ROLE'] === 45 || $session['ROLE'] === 61 || $session['ROLE'] === 10) {
            $id_dept = $session['DEPT'];
            $kode_dept = $this->new_propose_budget_m->get_user_dept($id_dept)->CHR_DEPT;
            
            if($session['NPK'] === '0512'){
               $kode_dept = 'KQC'; 
            }
            
            //Mapping dept AIS to BUDGET AII
            if($kode_dept == 'MISY'){
                $kode_dept = 'MIS';
            } else if($kode_dept == 'PPIC'){
                $kode_dept = 'PPC';
            } else if($kode_dept == 'QUA'){
                $kode_dept = 'QAS';
            } else {
                $kode_dept = trim($kode_dept);
            }
            
            $exist_no_propose =  $this->new_propose_budget_m->get_exist_no_propose($fiscal_start, $year, $month, $kode_dept);
            if($exist_no_propose == NULL){
                $no_propose = 'PROP/' . trim($kode_dept) . '/' . $year_month . '/0001';
            } else {
                $latest_no = substr($exist_no_propose->CHR_NO_PROPOSE, 16, 4);
                $new_no = sprintf("%04d", $latest_no + 1);
                $no_propose = 'PROP/' . trim($kode_dept) . '/' . $year_month . '/' . $new_no;
            }
            
            $data_propose = array(
                'CHR_NO_PROPOSE' => $no_propose,
                'CHR_TRANS_DATE' => date('Ymd'),
                'CHR_DEPT' => $kode_dept,
                'CHR_YEAR_BUDGET' => $fiscal_start,
                'CHR_YEAR_PROPOSE' => $year,
                'CHR_MONTH_PROPOSE' => $month,
                'CHR_FLG_SWITCH' => 0,
                'CHR_FLG_DELETE_PROP' => 0,
                'CHR_CREATED_BY' => $session['USERNAME'],
                'CHR_CREATED_DATE' => date('Ymd'),
                'CHR_CREATED_TIME' => date('His')
            );
            
            $this->new_propose_budget_m->insert_new_propose($data_propose);
            //Create notes
            $this->new_propose_budget_m->insert_new_notes($no_propose);
            
            $data['all_list_propose'] = $this->new_propose_budget_m->get_all_list_propose($no_propose);
            
            //$data['summary_propose'] = $this->new_propose_budget_m->get_summary_propose($no_propose);
            $data['propose_capex'] = $this->new_propose_budget_m->get_propose_capex($no_propose);
            $data['propose_repma'] = $this->new_propose_budget_m->get_propose_repma($no_propose);
            $data['propose_right'] = $this->new_propose_budget_m->get_propose_right($no_propose);
            $data['propose_tooeq'] = $this->new_propose_budget_m->get_propose_tooeq($no_propose);
            $data['propose_offeq'] = $this->new_propose_budget_m->get_propose_offeq($no_propose);
            $data['propose_trial'] = $this->new_propose_budget_m->get_propose_trial($no_propose);
            $data['propose_empwa'] = $this->new_propose_budget_m->get_propose_empwa($no_propose);
            $data['propose_engfe'] = $this->new_propose_budget_m->get_propose_engfe($no_propose);
            $data['propose_itexp'] = $this->new_propose_budget_m->get_propose_itexp($no_propose);
            $data['propose_renta'] = $this->new_propose_budget_m->get_propose_renta($no_propose);
            $data['propose_rndev'] = $this->new_propose_budget_m->get_propose_rndev($no_propose);
            $data['propose_donat'] = $this->new_propose_budget_m->get_propose_donat($no_propose);
            $data['propose_enter'] = $this->new_propose_budget_m->get_propose_enter($no_propose);
            
            $contain = 'budget/propose_budget/new_propose_monthly_budget_v';   
        }

        $data['all_month'] = array(
            array($fiscal_start . '04', 'APR '.$fiscal_start),
            array($fiscal_start . '05', 'MAY '.$fiscal_start),
            array($fiscal_start . '06', 'JUN '.$fiscal_start),
            array($fiscal_start . '07', 'JUL '.$fiscal_start),
            array($fiscal_start . '08', 'AGU '.$fiscal_start),
            array($fiscal_start . '09', 'SEP '.$fiscal_start),
            array($fiscal_start . '10', 'OKT '.$fiscal_start),
            array($fiscal_start . '11', 'NOV '.$fiscal_start),
            array($fiscal_start . '12', 'DES '.$fiscal_start),
            array($fiscal_end . '01', 'JAN '.$fiscal_end),
            array($fiscal_end . '02', 'FEB '.$fiscal_end),
            array($fiscal_end . '03', 'MAR '.$fiscal_end),
        );
                
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(199);
        $data['news'] = $this->news_m->get_news();
        $data['role'] = $session['ROLE'];
        $data['msg'] = NULL;
        
        //--- For list value
        $data['all_dept'] = $this->new_propose_budget_m->get_all_dept();
        $data['list_section'] = $this->new_propose_budget_m->get_list_section($kode_dept);
        $data['all_fiscal'] = $this->fiscal_m->get_all_fiscal_year();       
        $data['all_budget_type'] = $this->new_propose_budget_m->get_all_budget_type();
        $data['list_project'] = $this->new_propose_budget_m->get_list_project();
        $data['list_purpose'] = $this->new_propose_budget_m->get_list_purpose();
                        
        //--- Value selected
        $data['fiscal_start'] = $fiscal_start;
        $data['fiscal_end'] = $fiscal_end;
        $data['month'] = $month;
        $data['year_month'] = $year_month;
        $data['kode_dept'] = $kode_dept;
        $data['no_propose'] = $no_propose;
        $data['num_budget'] = count($data['all_list_propose']);
        
        $data['content'] = $contain;
        $data['title'] = 'Propose Monthly Budget';

        $this->load->view($this->layout, $data);
    }
    
    function insert_default_budget($fiscal_start = NULL, $year_month = NULL, $kode_dept = NULL, $no_propose = NULL){        
        $fiscal_year = $this->fiscal_m->get_selected_fiscal_year($fiscal_start);
        $fiscal_end = $fiscal_year->CHR_FISCAL_YEAR_END;
        $fiscal = $fiscal_start.$fiscal_end;  
        $no_propose = str_replace('%3C', '/', $no_propose);
        
        $year = substr($year_month,0,4);
        $month = substr($year_month,4,2);
        
        $session = $this->session->all_userdata(); 
        
        $list_exist_no_budget = $this->new_propose_budget_m->get_exist_all_no_budget($fiscal_start, $kode_dept);        
        
        $i = 1;
        $no_budget = '';
        $no = count($list_exist_no_budget);
        if($no == 0){
            $no_budget .= "''";
        } else {
            foreach($list_exist_no_budget as $list){
                if($i < $no){
                    $no_budget .= "'" . trim($list->CHR_NO_BUDGET) . "',";
                } else {
                    $no_budget .= "'" . trim($list->CHR_NO_BUDGET) . "'";
                }
                $i++;
            }
        }
        
        $all_budget = $this->new_propose_budget_m->get_list_available_budget($fiscal, $kode_dept, $month, $no_budget);
        
        foreach($all_budget as $data){
            $pbln = array(0,$data->PBLN01,$data->PBLN02,$data->PBLN03,$data->PBLN04,
                                $data->PBLN05,$data->PBLN06,$data->PBLN07,$data->PBLN08,
                                $data->PBLN09,$data->PBLN10,$data->PBLN11,$data->PBLN12);
                
            $month = (int)$month; 
            
            $over = 0;
            $tot_proposed = $data->TOT_LIMIT + ($pbln[$month]*0.7);
            $limit = $data->TOT_PLAN * 0.7;
            
            if($tot_proposed > $data->TOT_PLAN){
                $over = 2;
            } else {
                if($tot_proposed > $limit){
                    $over = 1;
                }
            }

            $prop_budget = array(
                                'CHR_NO_PROPOSE' => $no_propose,
                                'CHR_DEPT' => $kode_dept,
                                'CHR_BUDGET_TYPE' => $data->CHR_KODE_TYPE_BUDGET,
                                'CHR_NO_BUDGET' => $data->CHR_NO_BUDGET,
                                'CHR_BUDGET_DESC' => $data->CHR_DESC_BUDGET,
                                'CHR_YEAR_BUDGET' => $fiscal_start,
                                'CHR_ESTIMATE_GR_DATE' => $year_month,
                                'MON_PLAN_BLN' => $data->TOT_PLAN,
                                'MON_LIMIT_BLN' => $data->TOT_LIMIT,
                                'MON_REAL_BLN' => $data->TOT_REAL,
                                'MON_PROPOSE_BLN' => ($pbln[$month]*0.7),
                                'CHR_FLG_UNBUDGET' => $data->CHR_FLG_UNBUDGET,
                                'CHR_FLG_OVERBUDGET' => $over
                            );
            $this->new_propose_budget_m->insert_reschedule($prop_budget);
            
        }
        
        redirect("budget/new_propose_budget_c/view_propose_budget/3/". str_replace('/','<',$no_propose) . "/" . $kode_dept);
    }
    
    function view_propose_budget($msg = NULL, $no_propose = NULL, $kode_dept = NULL) {
        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>x</button><strong>Success. </strong> Budget is successfully proposed </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>x</button><strong>Failed. </strong> Budget failed to propose, please check your data </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>x</button><strong>Success. </strong> Budget is successfully added budget to list </div >";
        } elseif ($msg == 4) {
            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>x</button><strong>Failed. </strong> Failed add budget to list </div >";
        } elseif ($msg == 5) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>x</button><strong>Success. </strong> Budget is successfully updated </div >";
        } elseif ($msg == 6) {
            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>x</button><strong>Failed. </strong> Budget is already proposed, you can't edit again </div >";
        } else {
            $msg = "";
        }
        
        $this->role_module_m->authorization('44');
        
        $no_propose = str_replace('%3C', '/', $no_propose);
        $header_prop = $this->new_propose_budget_m->get_propose($no_propose);
        $fiscal_start = $header_prop->CHR_YEAR_BUDGET;
        $fiscal_end = $header_prop->CHR_YEAR_BUDGET + 1;
        $fiscal = $fiscal_start . $fiscal_end;
        $year_month = $header_prop->CHR_YEAR_PROPOSE . $header_prop->CHR_MONTH_PROPOSE;
        $year = $header_prop->CHR_YEAR_PROPOSE;
        $month = $header_prop->CHR_MONTH_PROPOSE;
        
        $data['year_month'] = $year_month;
        $data['year'] = $year;
        $data['month'] = $month;
        $data['switch'] = $header_prop->CHR_FLG_SWITCH;
        
        $session = $this->session->all_userdata();
        //FOR --> ADMIN & ADMIN BUDGET
        if ($session['ROLE'] === 2 || $session['ROLE'] === 1 ) {            
            //Mapping dept AIS to BUDGET AII
            if($kode_dept == 'MISY'){
                $kode_dept = 'MIS';
            } else if($kode_dept == 'PPIC'){
                $kode_dept = 'PPC';
            } else if($kode_dept == 'QUA'){
                $kode_dept = 'QAS';
            } else {
                $kode_dept = trim($kode_dept);
            }
            
            $data['all_list_propose'] = $this->new_propose_budget_m->get_all_list_propose($no_propose);
            
            //$data['all_budget_type_prop'] = $this->new_propose_budget_m->get_budget_type_prop($no_propose);
            
            $data['propose_capex'] = $this->new_propose_budget_m->get_propose_capex($no_propose);
            $data['propose_repma'] = $this->new_propose_budget_m->get_propose_repma($no_propose);
            $data['propose_right'] = $this->new_propose_budget_m->get_propose_right($no_propose);
            $data['propose_tooeq'] = $this->new_propose_budget_m->get_propose_tooeq($no_propose);
            $data['propose_offeq'] = $this->new_propose_budget_m->get_propose_offeq($no_propose);
            $data['propose_trial'] = $this->new_propose_budget_m->get_propose_trial($no_propose);
            $data['propose_empwa'] = $this->new_propose_budget_m->get_propose_empwa($no_propose);
            $data['propose_engfe'] = $this->new_propose_budget_m->get_propose_engfe($no_propose);
            $data['propose_itexp'] = $this->new_propose_budget_m->get_propose_itexp($no_propose);
            $data['propose_renta'] = $this->new_propose_budget_m->get_propose_renta($no_propose);
            $data['propose_rndev'] = $this->new_propose_budget_m->get_propose_rndev($no_propose);
            $data['propose_donat'] = $this->new_propose_budget_m->get_propose_donat($no_propose);
            $data['propose_enter'] = $this->new_propose_budget_m->get_propose_enter($no_propose);
            
            //$data['summary_budget'] = $this->new_propose_budget_m->get_summary_budget_per_month($fiscal, $kode_dept);
            
            $contain = 'budget/propose_budget/new_propose_monthly_budget_v';
            
        //FOR --> MANAGER
        } else if ($session['ROLE'] === 5 || $session['ROLE'] === 39 || $session['ROLE'] === 45 || $session['ROLE'] === 61 || $session['ROLE'] === 10) {
            $id_dept = $session['DEPT'];
            $kode_dept = $this->new_propose_budget_m->get_user_dept($id_dept)->CHR_DEPT;
            
            if($session['NPK'] === '0512'){
               $kode_dept = 'KQC'; 
            }
            
            //Mapping dept AIS to BUDGET AII
            if($kode_dept == 'MISY'){
                $kode_dept = 'MIS';
            } else if($kode_dept == 'PPIC'){
                $kode_dept = 'PPC';
            } else if($kode_dept == 'QUA'){
                $kode_dept = 'QAS';
            } else {
                $kode_dept = trim($kode_dept);
            }
            
            $data['all_list_propose'] = $this->new_propose_budget_m->get_all_list_propose($no_propose);
            
            $data['propose_capex'] = $this->new_propose_budget_m->get_propose_capex($no_propose);
            $data['propose_repma'] = $this->new_propose_budget_m->get_propose_repma($no_propose);
            $data['propose_right'] = $this->new_propose_budget_m->get_propose_right($no_propose);
            $data['propose_tooeq'] = $this->new_propose_budget_m->get_propose_tooeq($no_propose);
            $data['propose_offeq'] = $this->new_propose_budget_m->get_propose_offeq($no_propose);
            $data['propose_trial'] = $this->new_propose_budget_m->get_propose_trial($no_propose);
            $data['propose_empwa'] = $this->new_propose_budget_m->get_propose_empwa($no_propose);
            $data['propose_engfe'] = $this->new_propose_budget_m->get_propose_engfe($no_propose);
            $data['propose_itexp'] = $this->new_propose_budget_m->get_propose_itexp($no_propose);
            $data['propose_renta'] = $this->new_propose_budget_m->get_propose_renta($no_propose);
            $data['propose_rndev'] = $this->new_propose_budget_m->get_propose_rndev($no_propose);
            $data['propose_donat'] = $this->new_propose_budget_m->get_propose_donat($no_propose);
            $data['propose_enter'] = $this->new_propose_budget_m->get_propose_enter($no_propose);
            
            //$data['summary_budget'] = $this->new_propose_budget_m->get_summary_budget_per_month($fiscal, $kode_dept);
            
            $contain = 'budget/propose_budget/new_propose_monthly_budget_v';   
        }
        
        $data['ori_capex'] = $this->new_propose_budget_m->get_ori_plan_capex($fiscal_start, $year, $month, $kode_dept);
        $data['ori_repma'] = $this->new_propose_budget_m->get_ori_plan_expense($fiscal_start, $year, $month, $kode_dept, $bgt_type = 'REPMA');
        $data['ori_right'] = $this->new_propose_budget_m->get_ori_plan_expense($fiscal_start, $year, $month, $kode_dept, $bgt_type = 'RIGHT');
        $data['ori_tooeq'] = $this->new_propose_budget_m->get_ori_plan_expense($fiscal_start, $year, $month, $kode_dept, $bgt_type = 'TOOEQ');
        $data['ori_offeq'] = $this->new_propose_budget_m->get_ori_plan_expense($fiscal_start, $year, $month, $kode_dept, $bgt_type = 'OFFEQ');
        $data['ori_trial'] = $this->new_propose_budget_m->get_ori_plan_expense($fiscal_start, $year, $month, $kode_dept, $bgt_type = 'TRIAL');
        $data['ori_empwa'] = $this->new_propose_budget_m->get_ori_plan_expense($fiscal_start, $year, $month, $kode_dept, $bgt_type = 'EMPWA');
        $data['ori_engfe'] = $this->new_propose_budget_m->get_ori_plan_expense($fiscal_start, $year, $month, $kode_dept, $bgt_type = 'ENGFE');
        $data['ori_itexp'] = $this->new_propose_budget_m->get_ori_plan_expense($fiscal_start, $year, $month, $kode_dept, $bgt_type = 'ITEXP');
        $data['ori_renta'] = $this->new_propose_budget_m->get_ori_plan_expense($fiscal_start, $year, $month, $kode_dept, $bgt_type = 'RENTA');
        $data['ori_rndev'] = $this->new_propose_budget_m->get_ori_plan_expense($fiscal_start, $year, $month, $kode_dept, $bgt_type = 'RNDEV');
        $data['ori_donat'] = $this->new_propose_budget_m->get_ori_plan_expense($fiscal_start, $year, $month, $kode_dept, $bgt_type = 'DONAT');
        $data['ori_enter'] = $this->new_propose_budget_m->get_ori_plan_expense($fiscal_start, $year, $month, $kode_dept, $bgt_type = 'ENTER');
        
        $data['all_month'] = array(
                        array($fiscal_start . '04', 'APR '.$fiscal_start),
                        array($fiscal_start . '05', 'MAY '.$fiscal_start),
                        array($fiscal_start . '06', 'JUN '.$fiscal_start),
                        array($fiscal_start . '07', 'JUL '.$fiscal_start),
                        array($fiscal_start . '08', 'AGU '.$fiscal_start),
                        array($fiscal_start . '09', 'SEP '.$fiscal_start),
                        array($fiscal_start . '10', 'OKT '.$fiscal_start),
                        array($fiscal_start . '11', 'NOV '.$fiscal_start),
                        array($fiscal_start . '12', 'DES '.$fiscal_start),
                        array($fiscal_end . '01', 'JAN '.$fiscal_end),
                        array($fiscal_end . '02', 'FEB '.$fiscal_end),
                        array($fiscal_end . '03', 'MAR '.$fiscal_end),
                    );
        
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(199);
        $data['news'] = $this->news_m->get_news();
        $data['role'] = $session['ROLE'];
        $data['msg'] = $msg;
        
        //--- For list value
        $data['all_dept'] = $this->new_propose_budget_m->get_all_dept();
        $data['list_section'] = $this->new_propose_budget_m->get_list_section($kode_dept);
        $data['all_fiscal'] = $this->fiscal_m->get_all_fiscal_year();       
        $data['all_budget_type'] = $this->new_propose_budget_m->get_all_budget_type();
        $data['list_project'] = $this->new_propose_budget_m->get_list_project();
        $data['list_purpose'] = $this->new_propose_budget_m->get_list_purpose();
                       
        //--- Value selected
        $data['fiscal_start'] = $fiscal_start;
        $data['fiscal_end'] = $fiscal_end;        
        $data['kode_dept'] = $kode_dept;
        $data['no_propose'] = $no_propose; 
        $data['num_budget'] = count($data['all_list_propose']);
        
        $data['content'] = $contain;
        $data['title'] = 'Propose Monthly Budget';

        $this->load->view($this->layout, $data);
    }
    
    function view_detail_budget_per_month($fiscal_start = NULL, $kode_dept = NULL, $bgt_type = NULL){
        $fiscal_end = $fiscal_start + 1;
        $act_periode = date("Ym");
        $periode_smt2 = $fiscal_start . "10";
        
        if($bgt_type == NULL){
            $bgt_type = 'CAPEX';
        }
        
        $session = $this->session->all_userdata();
        //================= GROUP MANAGER ====================================//
        if($session['ROLE'] === 4 || $session['ROLE'] === 1){
            $id_group = $this->session->userdata('GROUPDEPT');
            $kode_group = '';
            if($id_group == '6'){
                $kode_group = '001';
            } else if($id_group == '7') {
                $kode_group = '003';
            } else if($id_group == '10') {
                $kode_group = '004';
            }
            //Detail budget per month
            $data['detail_budget'] = $this->new_propose_budget_m->get_budget_plan_gm($fiscal_start, $fiscal_end, $bgt_type, $kode_group);
            $data['rev_budget'] = $this->new_propose_budget_m->get_budget_rev_gm($fiscal_start, $fiscal_end, $bgt_type, $kode_group);
            $data['limit_budget'] = $this->new_propose_budget_m->get_budget_limit_gm($fiscal_start, $fiscal_end, $bgt_type, $kode_group, $act_periode, $periode_smt2);
            $data['actual_real'] = $this->new_propose_budget_m->get_actual_real_gm($fiscal_start, $fiscal_end, $bgt_type, $kode_group, $act_periode, $periode_smt2);
       
            //==== ACTUAL GR BY GM ===========================================//
            $list_actual_gr = array();
                for ($no = 1; $no <= 12; $no++){
                    if (($no + 3) <= 12){
                        $start_date = $fiscal_start . sprintf("%02d", $no+3) . '01';
                        $end_date = $fiscal_start . sprintf("%02d", $no+3) . '31';
                        $actual_gr = $this->new_propose_budget_m->get_actual_gr_by_gm($start_date, $end_date, $bgt_type, $kode_group);

                        array_push($list_actual_gr, $actual_gr->TOTAL);                    
                    } else {
                        $start_date = $fiscal_end . sprintf("%02d", $no-9) . '01';
                        $end_date = $fiscal_end . sprintf("%02d", $no-9) . '31';
                        $actual_gr = $this->new_propose_budget_m->get_actual_gr_by_gm($start_date, $end_date, $bgt_type, $kode_group);

                        array_push($list_actual_gr, $actual_gr->TOTAL);                    
                    }
                }
            $data['actual_gr'] = $list_actual_gr;

            //==== ESTIMATE GR BY PROPOSE BUDGET MONTHLY BY GM ===============//
            $est_gr_prop = array();
                for ($no = 1; $no <= 12; $no++){
                    if (($no + 3) <= 12){
                        $year_month = $fiscal_start . sprintf("%02d", $no+3);
                        $get_est_gr_prop = $this->new_propose_budget_m->get_est_gr_prop_by_gm($year_month, $bgt_type, $id_group);

                        array_push($est_gr_prop, $get_est_gr_prop->TOTAL);                    
                    } else {
                        $year_month = $fiscal_end . sprintf("%02d", $no-9);
                        $get_est_gr_prop = $this->new_propose_budget_m->get_est_gr_prop_by_gm($year_month, $bgt_type, $id_group);

                        array_push($est_gr_prop, $get_est_gr_prop->TOTAL);                    
                    }
                }
            $data['est_gr_prop'] = $est_gr_prop;

            //==== ESTIMATE GR BY PURCHASE REQUEST (PR) BY GM ================//
            $est_gr_pr = array();
                for ($no = 1; $no <= 12; $no++){
                    if (($no + 3) <= 12){
                        $year_month = $fiscal_start . sprintf("%02d", $no+3);
                        $get_est_gr_pr = $this->new_propose_budget_m->get_est_gr_pr_by_gm($year_month, $bgt_type, $kode_dept);

                        array_push($est_gr_pr, $get_est_gr_pr->TOTAL);                    
                    } else {
                        $year_month = $fiscal_end . sprintf("%02d", $no-9);
                        $get_est_gr_pr = $this->new_propose_budget_m->get_est_gr_pr_by_gm($year_month, $bgt_type, $kode_dept);

                        array_push($est_gr_pr, $get_est_gr_pr->TOTAL);                    
                    }
                }
            $data['est_gr_pr'] = $est_gr_pr;

        //================= DIRECTOR =========================================//    
        } else if($session['ROLE'] === 3) {
            //Detail budget per month
            $data['detail_budget'] = $this->new_propose_budget_m->get_budget_plan_bod($fiscal_start, $fiscal_end, $bgt_type);
            $data['rev_budget'] = $this->new_propose_budget_m->get_budget_rev_bod($fiscal_start, $fiscal_end, $bgt_type);
            $data['limit_budget'] = $this->new_propose_budget_m->get_budget_limit_bod($fiscal_start, $fiscal_end, $bgt_type, $act_periode, $periode_smt2);
            $data['actual_real'] = $this->new_propose_budget_m->get_actual_real_bod($fiscal_start, $fiscal_end, $bgt_type, $act_periode, $periode_smt2);
       
            //==== ACTUAL GR BY BOD ===========================================//
            $list_actual_gr = array();
                for ($no = 1; $no <= 12; $no++){
                    if (($no + 3) <= 12){
                        $start_date = $fiscal_start . sprintf("%02d", $no+3) . '01';
                        $end_date = $fiscal_start . sprintf("%02d", $no+3) . '31';
                        $actual_gr = $this->new_propose_budget_m->get_actual_gr_by_bod($start_date, $end_date, $bgt_type);

                        array_push($list_actual_gr, $actual_gr->TOTAL);                    
                    } else {
                        $start_date = $fiscal_end . sprintf("%02d", $no-9) . '01';
                        $end_date = $fiscal_end . sprintf("%02d", $no-9) . '31';
                        $actual_gr = $this->new_propose_budget_m->get_actual_gr_by_bod($start_date, $end_date, $bgt_type);

                        array_push($list_actual_gr, $actual_gr->TOTAL);                    
                    }
                }
            $data['actual_gr'] = $list_actual_gr;

            //==== ESTIMATE GR BY PROPOSE BUDGET MONTHLY BY BOD ==============//
            $est_gr_prop = array();
                for ($no = 1; $no <= 12; $no++){
                    if (($no + 3) <= 12){
                        $year_month = $fiscal_start . sprintf("%02d", $no+3);
                        $get_est_gr_prop = $this->new_propose_budget_m->get_est_gr_prop_by_bod($year_month, $bgt_type);

                        array_push($est_gr_prop, $get_est_gr_prop->TOTAL);                    
                    } else {
                        $year_month = $fiscal_end . sprintf("%02d", $no-9);
                        $get_est_gr_prop = $this->new_propose_budget_m->get_est_gr_prop_by_bod($year_month, $bgt_type);

                        array_push($est_gr_prop, $get_est_gr_prop->TOTAL);                    
                    }
                }
            $data['est_gr_prop'] = $est_gr_prop;

            //==== ESTIMATE GR BY PURCHASE REQUEST (PR) BY BOD ===============//
            $est_gr_pr = array();
                for ($no = 1; $no <= 12; $no++){
                    if (($no + 3) <= 12){
                        $year_month = $fiscal_start . sprintf("%02d", $no+3);
                        $get_est_gr_pr = $this->new_propose_budget_m->get_est_gr_pr_by_bod($year_month, $bgt_type);

                        array_push($est_gr_pr, $get_est_gr_pr->TOTAL);                    
                    } else {
                        $year_month = $fiscal_end . sprintf("%02d", $no-9);
                        $get_est_gr_pr = $this->new_propose_budget_m->get_est_gr_pr_by_bod($year_month, $bgt_type);

                        array_push($est_gr_pr, $get_est_gr_pr->TOTAL);                    
                    }
                }
            $data['est_gr_pr'] = $est_gr_pr;
            
        } else {
            //Detail budget per month
            $data['detail_budget'] = $this->new_propose_budget_m->get_budget_plan($fiscal_start, $fiscal_end, $bgt_type, $kode_dept);
            $data['rev_budget'] = $this->new_propose_budget_m->get_budget_rev($fiscal_start, $fiscal_end, $bgt_type, $kode_dept);
            $data['limit_budget'] = $this->new_propose_budget_m->get_budget_limit($fiscal_start, $fiscal_end, $bgt_type, $kode_dept, $act_periode, $periode_smt2);
            $data['actual_real'] = $this->new_propose_budget_m->get_actual_real($fiscal_start, $fiscal_end, $bgt_type, $kode_dept, $act_periode, $periode_smt2);
       
            //==== ACTUAL GR =====================================================//
            $list_actual_gr = array();
                for ($no = 1; $no <= 12; $no++){
                    if (($no + 3) <= 12){
                        $start_date = $fiscal_start . sprintf("%02d", $no+3) . '01';
                        $end_date = $fiscal_start . sprintf("%02d", $no+3) . '31';
                        $actual_gr = $this->new_propose_budget_m->get_actual_gr($start_date, $end_date, $bgt_type, $kode_dept);

                        array_push($list_actual_gr, $actual_gr->TOTAL);                    
                    } else {
                        $start_date = $fiscal_end . sprintf("%02d", $no-9) . '01';
                        $end_date = $fiscal_end . sprintf("%02d", $no-9) . '31';
                        $actual_gr = $this->new_propose_budget_m->get_actual_gr($start_date, $end_date, $bgt_type, $kode_dept);

                        array_push($list_actual_gr, $actual_gr->TOTAL);                    
                    }
                }
            $data['actual_gr'] = $list_actual_gr;

            //==== ESTIMATE GR BY PROPOSE BUDGET MONTHLY =========================//
            $est_gr_prop = array();
                for ($no = 1; $no <= 12; $no++){
                    if (($no + 3) <= 12){
                        $year_month = $fiscal_start . sprintf("%02d", $no+3);
                        $get_est_gr_prop = $this->new_propose_budget_m->get_est_gr_prop($year_month, $bgt_type, $kode_dept);

                        array_push($est_gr_prop, $get_est_gr_prop->TOTAL);                    
                    } else {
                        $year_month = $fiscal_end . sprintf("%02d", $no-9);
                        $get_est_gr_prop = $this->new_propose_budget_m->get_est_gr_prop($year_month, $bgt_type, $kode_dept);

                        array_push($est_gr_prop, $get_est_gr_prop->TOTAL);                    
                    }
                }
            $data['est_gr_prop'] = $est_gr_prop;

            //==== ESTIMATE GR BY PURCHASE REQUEST (PR) ==========================//
            $est_gr_pr = array();
                for ($no = 1; $no <= 12; $no++){
                    if (($no + 3) <= 12){
                        $year_month = $fiscal_start . sprintf("%02d", $no+3);
                        $get_est_gr_pr = $this->new_propose_budget_m->get_est_gr_pr($year_month, $bgt_type, $kode_dept);

                        array_push($est_gr_pr, $get_est_gr_pr->TOTAL);                    
                    } else {
                        $year_month = $fiscal_end . sprintf("%02d", $no-9);
                        $get_est_gr_pr = $this->new_propose_budget_m->get_est_gr_pr($year_month, $bgt_type, $kode_dept);

                        array_push($est_gr_pr, $get_est_gr_pr->TOTAL);                    
                    }
                }
            $data['est_gr_pr'] = $est_gr_pr;
        }
        
        
        $data['all_budget_type'] = $this->new_propose_budget_m->get_all_budget_type();
        $data['kode_dept'] = $kode_dept;
        $data['bgt_type'] = $bgt_type;
        $data['fiscal_start'] = $fiscal_start;
        $data['fiscal_end'] = $fiscal_end;
        
        $data['title'] = 'Detail Budget per Month';
        $contain = 'budget/propose_budget/new_detail_budget_v'; 
        $data['content'] = $contain;
        $this->load->view("/template/head_blank", $data);
    }
    
    function get_list_category() {
        $bgt_type = $this->input->post('type_budget');
        $list_category = $this->new_propose_budget_m->get_list_category($bgt_type);
        $option = '';
        
        foreach ($list_category as $data){
            $option .= '<option value="' . trim($data->CHR_KODE_SUBCATEGORY_BUDGET) . '">' . strtoupper(trim($data->CHR_KODE_SUBCATEGORY_BUDGET)) . ' - ' . substr($data->CHR_DESC_SUBCATEGORY_BUDGET, 0, 40) . '</option>';
        }
        
        echo $option;
    }
    
    function get_budget_list() {
        $bgt_type = $this->input->post('dt_bgt_type');
        $dept = $this->input->post('dt_dept');
        $year_month = $this->input->post('dt_month');        
        
        $fiscal = $this->input->post('dt_fiscal');
        $no_propose = $this->input->post('dt_prop');
        $header_prop = $this->new_propose_budget_m->get_propose($no_propose);
        
        $fis_start = substr($fiscal,0,4);
        $fis_end = substr($fiscal,4,4);
        
        $act_periode = date("Ym");
        $periode_smt2 = $fis_start . '10';

        $list_exist_no_budget = $this->new_propose_budget_m->get_exist_no_budget_prop($fis_start, $dept, $bgt_type);        
        
        $i = 1;
        $no_budget = '';
        $no = count($list_exist_no_budget);
        if($no == 0){
            $no_budget .= "''";
        } else {
            foreach($list_exist_no_budget as $list){
                if($i < $no){
                    $no_budget .= "'" . trim($list->CHR_NO_BUDGET) . "',";
                } else {
                    $no_budget .= "'" . trim($list->CHR_NO_BUDGET) . "'";
                }
                $i++;
            }
        }
        
        //$list_budget = $this->new_propose_budget_m->get_list_available_budget($fiscal, $dept, $bgt_type, $no_budget);
        if($year_month == 'ALL'){
            $year = $header_prop->CHR_YEAR_PROPOSE;
            $month = $header_prop->CHR_MONTH_PROPOSE;
            $list_budget = $this->new_propose_budget_m->get_all_list_budget($fiscal, $dept, $bgt_type, $no_budget, $act_periode, $periode_smt2);
        } else {
            $year = substr($year_month, 0, 4);
            $month = substr($year_month, 4, 2);
            $list_budget = $this->new_propose_budget_m->get_list_budget_per_month($fiscal, $dept, $bgt_type, $month, $no_budget, $act_periode, $periode_smt2); 
        }
        
        $table_budget = '';
        $table_budget .= '<table style="font-size:12px;" id="example" class="table table-condensed table-hover display" cellspacing="0" width="100%">';
        $table_budget .=  '<thead style="border-style:solid;">';
        $table_budget .=    '<tr style="font-weight:bold; background-color: #002a80; color: white;">';
        $table_budget .=        '<td align="center">No</td>';
        $table_budget .=        '<td align="center">No Budget</td>';
        $table_budget .=        '<td align="center">Description</td>'; 
        $table_budget .=        '<td align="center">Planning FY <br/> (a)</td>';
        $table_budget .=        '<td align="center">Proposed FY <br/> (b)</td>';
        $table_budget .=        '<td align="center">Realization FY <br/> (c)</td>';
        $table_budget .=        '<td align="center">Balance FY <br/> (a-c) </td>';
        $table_budget .=        '<td align="center">Saldo FY <br/> (b-c)</td>';       
        $table_budget .=        '<td align="center">Month Plan <br/> (Origin)</td>';
        $table_budget .=        '<td align="center">Month Plan <br/> (70%)</td>';
        $table_budget .=        '<td align="center">Choose</td>';
        $table_budget .=    '</tr>'; 
        $table_budget .=  '</thead>';
        
        if(count($list_budget) == 0){
           $table_budget .= '<tbody>';
           $table_budget .=  '<tr style="background-color:whitesmoke;">';
           $table_budget .=    '<td colspan="11"><strong>No Data Available</strong></td>';
           $table_budget .=  '</tr>';
           $table_budget .= '</tbody>';
        } else {
           $i = 1;
           $table_budget .= '<tbody>';
           
           foreach ($list_budget as $data){
                $pbln = array(0,$data->PBLN01,$data->PBLN02,$data->PBLN03,$data->PBLN04,
                                $data->PBLN05,$data->PBLN06,$data->PBLN07,$data->PBLN08,
                                $data->PBLN09,$data->PBLN10,$data->PBLN11,$data->PBLN12);
                
                $month = (int)$month;
                        
                $table_budget .= '<tr>';
                $table_budget .=    '<td>' . $i . '</td>';
                $table_budget .=    '<td>' . $data->CHR_NO_BUDGET . '</td>';
                $table_budget .=    '<td>' . substr($data->CHR_DESC_BUDGET, 0, 20) . '</td>';
                $table_budget .=    '<td align="right">' . number_format($data->TOT_PLAN,0,',','.') . '</td>';                
                $table_budget .=    '<td align="right">' . number_format($data->TOT_LIMIT,0,',','.') . '</td>';
                $table_budget .=    '<td align="right">' . number_format($data->TOT_REAL,0,',','.') . '</td>';
                $table_budget .=    '<td align="right">' . number_format(($data->TOT_PLAN - $data->TOT_REAL),0,',','.') . '</td>';
                $table_budget .=    '<td align="right" style="font-weight: bold;">' . number_format(($data->TOT_LIMIT - $data->TOT_REAL),0,',','.') . '</td>';
                $table_budget .=    '<td align="right">' . number_format($pbln[$month],0,',','.') . '</td>';
                $table_budget .=    '<td align="right">' . number_format(($pbln[$month]*0.7),0,',','.') . '</td>';
                $table_budget .=    '<td align="center"><input type="checkbox" class="list_bgt" name="res_'. trim($data->CHR_NO_BUDGET) .'" value="1"></td>';
                $table_budget .= '</tr>';
                
                $i++;
            } 
            $table_budget .= '</tbody>';
        }        
        
        $table_budget .= '</table>';
        $table_budget .= '<input type="hidden" class="list_bgt" name="LIST_EXIST_BUDGET" value="'. $no_budget .'">';
        
        echo $table_budget;
    }
    
    function add_reschedule_budget(){
        $session = $this->session->all_userdata();
        $no_propose = $this->input->post('CHR_NO_PROPOSE_RES');
        $header_prop = $this->new_propose_budget_m->get_propose($no_propose);
        
        //Cek apakah sudah dipropose atau belum
        if($header_prop->CHR_FLG_SWITCH > 0){
            redirect("budget/new_propose_budget_c/view_propose_budget/6/". str_replace('/','<',$no_propose) . "/" . $header_prop->CHR_DEPT);
        }
        
        $dept = $this->input->post('CHR_DEPT_RES');
        $fiscal = $this->input->post('CHR_FISCAL_YEAR_RES');
        $ym_prop = $this->input->post('CHR_YM_PROPOSE_RES');
        $ym_res = $this->input->post('CHR_MONTH_RES');
        
        $budget_type = $this->input->post('CHR_BUDGET_TYPE_RES');
        $no_budget = $this->input->post('LIST_EXIST_BUDGET');
        
        $act_periode = date("Ym");
        $periode_smt2 = substr($fiscal, 0, 4) . '10';

        if($ym_res == 'ALL'){
            $month = substr($ym_prop,4,2);
            $all_budget = $this->new_propose_budget_m->get_all_list_budget($fiscal, $dept, $budget_type, $no_budget, $act_periode, $periode_smt2);
        } else {
            $month = substr($ym_res,4,2);
            $all_budget = $this->new_propose_budget_m->get_list_budget_per_month($fiscal, $dept, $budget_type, $month, $no_budget, $act_periode, $periode_smt2);
        }
        
        foreach($all_budget as $data){
            $pbln = array(0,$data->PBLN01,$data->PBLN02,$data->PBLN03,$data->PBLN04,
                                $data->PBLN05,$data->PBLN06,$data->PBLN07,$data->PBLN08,
                                $data->PBLN09,$data->PBLN10,$data->PBLN11,$data->PBLN12);
                
            $month = (int)$month;  
            
            if(isset($_POST["res_".trim($data->CHR_NO_BUDGET)])){
                $over = 0;
                $tot_proposed = $data->TOT_LIMIT + ($pbln[$month]*0.7);
                $limit = $data->TOT_PLAN * 0.7;
                if($tot_proposed > $data->TOT_PLAN){
                    $over = 2;
                } else {
                    if($tot_proposed > $limit){
                        $over = 1;
                    }
                }
            
                $prop_budget = array(
                                    'CHR_NO_PROPOSE' => $no_propose,
                                    'CHR_DEPT' => $dept,
                                    'CHR_BUDGET_TYPE' => $budget_type,
                                    'CHR_NO_BUDGET' => $data->CHR_NO_BUDGET,
                                    'CHR_BUDGET_DESC' => $data->CHR_DESC_BUDGET,
                                    'CHR_YEAR_BUDGET' => substr($fiscal, 0, 4),
                                    'CHR_YEAR_ACTUAL' => substr($ym_res,0,4),
                                    'CHR_MONTH_ACTUAL' => substr($ym_res,4,2),
                                    'CHR_ESTIMATE_GR_DATE' => $ym_prop,
                                    'MON_PLAN_BLN' => $data->TOT_PLAN,
                                    'MON_LIMIT_BLN' => $data->TOT_LIMIT,
                                    'MON_REAL_BLN' => $data->TOT_REAL,
                                    'MON_PROPOSE_BLN' => ($pbln[$month]*0.7),
                                    'CHR_FLG_UNBUDGET' => $data->CHR_FLG_UNBUDGET,
                                    'CHR_FLG_OVERBUDGET' => $over
                                );
                $this->new_propose_budget_m->insert_reschedule($prop_budget);
            }
        }
        
        $updated = array(
                        'CHR_MODI_BY' => $session['USERNAME'],
                        'CHR_MODI_DATE' => date('Ymd'),
                        'CHR_MODI_TIME' => date('His')
                    );
        $this->new_propose_budget_m->update_header_propose($updated, $no_propose);
        
        redirect("budget/new_propose_budget_c/view_propose_budget/3/". str_replace('/','<',$no_propose) . "/" . $dept);
    }
    
    function add_propose_unbudget(){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        $session = $this->session->all_userdata();
        $no_propose = $this->input->post('NO_PROPOSE_UNB');
        $header_prop = $this->new_propose_budget_m->get_propose($no_propose);
        
        //Cek apakah sudah dipropose atau belum
        if($header_prop->CHR_FLG_SWITCH > 0){
            redirect("budget/new_propose_budget_c/view_propose_budget/6/". str_replace('/','<',$no_propose) . "/" . $header_prop->CHR_DEPT);
        }
                
        $dept = $this->input->post('DEPT_UNB');
        $kode_group = $this->new_propose_budget_m->get_kode_group($dept)->CHR_KODE_GROUP;
        $sect = $this->input->post('CHR_SECTION_UNB');
        
        $fis_start = $this->input->post('FIS_START_UNB');
        $ym_prop = $this->input->post('YM_PROPOSE_UNB');
        
        $budget_no = $this->input->post('CHR_NO_BUDGET_UNB');
        $budget_type = $this->input->post('CHR_BUDGET_TYPE_UNB');        
        $category = $this->input->post('CHR_CATEGORY_UNB');
        
        if($this->input->post('CHR_STATUS_UNB')  == 1){
            $status = $this->input->post('CHR_STATUS_UNB');
            $project = $this->input->post('CHR_PROJECT_UNB');
        } else {
            $status = '0';
            $project = '-';
        }
        
        if($this->input->post('CHR_PURPOSE_UNB') != '' || $this->input->post('CHR_PURPOSE_UNB') != NULL){
            $purpose = $this->input->post('CHR_PURPOSE_UNB');
        } else {
            $purpose = 'PCA02';
        }
        
        if($this->input->post('CHR_CIP_UNB') != '' || $this->input->post('CHR_CIP_UNB') != NULL){
            $cip = $this->input->post('CHR_CIP_UNB');
        } else {
            $cip = '0';
        }
        
        $desc = $this->input->post('CHR_DESC_UNB');
        $notes = $this->input->post('CHR_NOTES_UNB');
        
        $get_costcenter = $this->new_propose_budget_m->get_costcenter($sect);
        $userid = $get_costcenter->CHR_USERID;
        $costcenter = $get_costcenter->CHR_USERID;
        
        $req_amo_unb = str_replace('.', '', $this->input->post('REQ_AMO_UNB'));
        $req_qty_unb = str_replace('.', '', $this->input->post('REQ_QTY_UNB'));
        
        // ----------- START SAVE UNBUDGET ----------- //
        $bgt_aii->trans_start();
        
        if($budget_type == 'CAPEX'){
             $unbudget_cpx = array(
                            'CHR_USER' => $userid,
                            'CHR_TAHUN_BUDGET' => $fis_start,
                            'CHR_TAHUN_ACTUAL' => substr($ym_prop, 0, 4),                    
                            'CHR_NO_BUDGET' => $budget_no,
                            'CHR_KODE_DEPARTMENT' => $dept,
                            'CHR_KODE_TYPE_BUDGET' => $budget_type,
                            'CHR_KODE_DIVISI' => '001',
                            'CHR_KODE_GROUP' => $kode_group,
                            'CHR_KODE_SECTION' => $sect,
                            'CHR_KODE_COSTCENTER' => $costcenter,
                            'CHR_KODE_SUBCATEGORY_BUDGET' => $category,
                            'CHR_DESC_BUDGET' => $desc,
                            'CHR_KODE_PURPOSE_BUDGET' => $purpose,                          
                            'CHR_DESC_PROJECT' => $project,
                            'CHR_FLG_PROJECT' => $status,
                            'CHR_FLG_CIP' => $cip,
                            'CHR_FLG_DELETE' => 0,
                            'CHR_FLG_CANCEL' => 0,
                            'CHR_FLG_IF_SAP' => 0,
                            'CHR_FLG_USED' => 0,
                            'CHR_FLG_UNBUDGET' => 1                
                ); 
             $this->new_propose_budget_m->save_master_unbudget($unbudget_cpx, $budget_type);
             
             $prop_unbudget_cpx = array(
                            'CHR_NO_PROPOSE' => $no_propose,
                            'CHR_DEPT' => $dept,
                            'CHR_NO_BUDGET' => $budget_no,
                            'CHR_BUDGET_TYPE' => $budget_type,
                            'CHR_YEAR_BUDGET' => $fis_start,
                            'CHR_YEAR_ACTUAL' => substr($ym_prop, 0, 4),
                            'CHR_MONTH_ACTUAL' => substr($ym_prop, 4, 2),
                            'CHR_ESTIMATE_GR_DATE' => $ym_prop,
                            'MON_PROPOSE_BLN' => $req_amo_unb * $req_qty_unb,
                            'INT_QTY_PROPOSE' => $req_qty_unb,
                            'CHR_BUDGET_DESC' => $desc,
                            'CHR_NOTES' => $notes,
                            'CHR_FLG_UNBUDGET' => 1,
                            'CHR_FLG_OVERBUDGET' => 2
                );
             $this->new_propose_budget_m->save_propose_unbudget($prop_unbudget_cpx);
        } else {            
            if(substr($ym_prop, 0, 4) == $fis_start){
                $unb_exp_start = array(
                            'CHR_USER' => $userid,
                            'CHR_TAHUN_BUDGET' => $fis_start,
                            'CHR_TAHUN_ACTUAL' => substr($ym_prop, 0, 4),                    
                            'CHR_NO_BUDGET' => $budget_no,
                            'CHR_KODE_DEPARTMENT' => $dept,
                            'CHR_KODE_TYPE_BUDGET' => $budget_type,
                            'CHR_KODE_DIVISI' => '001',
                            'CHR_KODE_GROUP' => $kode_group,
                            'CHR_KODE_SECTION' => $sect,
                            'CHR_KODE_COSTCENTER' => $costcenter,
                            'CHR_KODE_CATEGORY_BUDGET' => '-',
                            'CHR_KODE_SUBCATEGORY_BUDGET' => $category,
                            'CHR_KODE_ITEM' => $desc,
                            'CHR_DESC_PROJECT' => $project,
                            'CHR_ALOKASI' => '-',
                            'CHR_FLG_PROJECT' => $status,
                            'CHR_FLG_DELETE' => 0,
                            'CHR_FLG_CANCEL' => 0,
                            'CHR_FLG_IF_SAP' => 0,
                            'CHR_FLG_UNBUDGET' => 1                
                ); 
                $this->new_propose_budget_m->save_master_unbudget($unb_exp_start, $budget_type);
                
                $unb_exp_end = array(
                            'CHR_USER' => $userid,
                            'CHR_TAHUN_BUDGET' => $fis_start,
                            'CHR_TAHUN_ACTUAL' => substr($ym_prop, 0, 4) + 1,                    
                            'CHR_NO_BUDGET' => $budget_no,
                            'CHR_KODE_DEPARTMENT' => $dept,
                            'CHR_KODE_TYPE_BUDGET' => $budget_type,
                            'CHR_KODE_DIVISI' => '001',
                            'CHR_KODE_GROUP' => $kode_group,
                            'CHR_KODE_SECTION' => $sect,
                            'CHR_KODE_COSTCENTER' => $costcenter,
                            'CHR_KODE_CATEGORY_BUDGET' => '-',
                            'CHR_KODE_SUBCATEGORY_BUDGET' => $category,
                            'CHR_KODE_ITEM' => $desc,                            
                            'CHR_DESC_PROJECT' => $project,
                            'CHR_FLG_PROJECT' => $status,
                            'CHR_ALOKASI' => '-',
                            'CHR_FLG_DELETE' => 0,
                            'CHR_FLG_CANCEL' => 0,
                            'CHR_FLG_IF_SAP' => 0,
                            'CHR_FLG_UNBUDGET' => 1                
                ); 
                $this->new_propose_budget_m->save_master_unbudget($unb_exp_end, $budget_type);
            } else {
                $unb_exp_start = array(
                            'CHR_USER' => $userid,
                            'CHR_TAHUN_BUDGET' => $fis_start,
                            'CHR_TAHUN_ACTUAL' => substr($ym_prop, 0, 4)-1,                    
                            'CHR_NO_BUDGET' => $budget_no,
                            'CHR_KODE_DEPARTMENT' => $dept,
                            'CHR_KODE_TYPE_BUDGET' => $budget_type,
                            'CHR_KODE_DIVISI' => '001',
                            'CHR_KODE_GROUP' => $kode_group,
                            'CHR_KODE_SECTION' => $sect,
                            'CHR_KODE_COSTCENTER' => $costcenter,
                            'CHR_KODE_CATEGORY_BUDGET' => '-',
                            'CHR_KODE_SUBCATEGORY_BUDGET' => $category,
                            'CHR_KODE_ITEM' => $desc,                            
                            'CHR_DESC_PROJECT' => $project,
                            'CHR_FLG_PROJECT' => $status,
                            'CHR_ALOKASI' => '-',
                            'CHR_FLG_DELETE' => 0,
                            'CHR_FLG_CANCEL' => 0,
                            'CHR_FLG_IF_SAP' => 0,
                            'CHR_FLG_UNBUDGET' => 1                
                ); 
                $this->new_propose_budget_m->save_master_unbudget($unb_exp_start, $budget_type);
                
                $unb_exp_end = array(
                            'CHR_USER' => $userid,
                            'CHR_TAHUN_BUDGET' => $fis_start,
                            'CHR_TAHUN_ACTUAL' => substr($ym_prop, 0, 4),                    
                            'CHR_NO_BUDGET' => $budget_no,
                            'CHR_KODE_DEPARTMENT' => $dept,
                            'CHR_KODE_TYPE_BUDGET' => $budget_type,
                            'CHR_KODE_DIVISI' => '001',
                            'CHR_KODE_GROUP' => $kode_group,
                            'CHR_KODE_SECTION' => $sect,
                            'CHR_KODE_COSTCENTER' => $costcenter,
                            'CHR_KODE_CATEGORY_BUDGET' => '-',
                            'CHR_KODE_SUBCATEGORY_BUDGET' => $category,
                            'CHR_KODE_ITEM' => $desc,
                            'CHR_DESC_PROJECT' => $project,
                            'CHR_FLG_PROJECT' => $status,
                            'CHR_ALOKASI' => '-',
                            'CHR_FLG_DELETE' => 0,
                            'CHR_FLG_CANCEL' => 0,
                            'CHR_FLG_IF_SAP' => 0,
                            'CHR_FLG_UNBUDGET' => 1                
                ); 
                $this->new_propose_budget_m->save_master_unbudget($unb_exp_end, $budget_type);
            }                        
             $prop_unbudget_exp = array(
                            'CHR_NO_PROPOSE' => $no_propose,
                            'CHR_DEPT' => $dept,
                            'CHR_NO_BUDGET' => $budget_no,
                            'CHR_BUDGET_TYPE' => $budget_type,
                            'CHR_YEAR_BUDGET' => $fis_start,
                            'CHR_YEAR_ACTUAL' => substr($ym_prop, 0, 4),
                            'CHR_MONTH_ACTUAL' => substr($ym_prop, 4, 2),
                            'CHR_ESTIMATE_GR_DATE' => $ym_prop,
                            'MON_PROPOSE_BLN' => $req_amo_unb * $req_qty_unb,
                            'INT_QTY_PROPOSE' => $req_qty_unb,
                            'CHR_BUDGET_DESC' => $desc,
                            'CHR_NOTES' => $notes,
                            'CHR_FLG_UNBUDGET' => 1,
                            'CHR_FLG_OVERBUDGET' => 2 
                );
            $this->new_propose_budget_m->save_propose_unbudget($prop_unbudget_exp);
        }
        
        $bgt_aii->trans_complete();
        
        if ($bgt_aii->trans_status() === FALSE)
        {
            $bgt_aii->trans_rollback();
            redirect("budget/new_propose_budget_c/view_propose_budget/4/". str_replace('/','<',$no_propose) . "/" . $dept);
        }
        else
        {
            $bgt_aii->trans_commit();
            
            $updated = array(
                        'CHR_MODI_BY' => $session['USERNAME'],
                        'CHR_MODI_DATE' => date('Ymd'),
                        'CHR_MODI_TIME' => date('His')
                    );
            $this->new_propose_budget_m->update_header_propose($updated, $no_propose);
            
            redirect("budget/new_propose_budget_c/view_propose_budget/3/". str_replace('/','<',$no_propose) . "/" . $dept);
        }
        
    }
    
    function generate_no_budget() {
        $bgt_type = $this->input->post('id_bgt');
        $dept = $this->input->post('id_dept');
        $sect = $this->input->post('id_sect');
        $year = $this->input->post('id_thn');
        
        if($bgt_type != '' && $dept != '' && $sect != '' && $year != '' ){
            $get_unbudget = $this->new_propose_budget_m->get_exist_unbudget($bgt_type, $year, $dept, $sect);
            $get_prefix = $this->new_propose_budget_m->get_prefix($bgt_type);
            $prefix = $get_prefix->CHR_PREFIX_BUDGET;
            if(count($get_unbudget) > 0){
                $exist_no = substr($get_unbudget->CHR_NO_BUDGET,-4);
                $no = $exist_no + 1;
                $new_no = sprintf("%04d", $no);
                $no_unbudget = $prefix . '/' . trim($sect) . '/UNB/' . substr($year,-2) . $new_no;
            } else {
                $no = 1;
                $new_no = sprintf("%04d", $no);
                $no_unbudget = $prefix . '/' . trim($sect) . '/UNB/' . substr($year,-2) . $new_no;
            }            
        } else {
            $exist_no = '';
            $no_unbudget = '';
        }
                
        echo $no_unbudget;
    }
    
    function manage_approval_monthly_budget($msg = NULL, $fiscal_start = NULL, $year_month = NULL, $kode_dept = NULL) {
        $this->role_module_m->authorization('44');
        
        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>x</button><strong>Success </strong> Budget is successfully approved </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>x</button><strong>Failed </strong> Budget is failed to approved </div >";
        } else {
            $msg = "";
        }
        
        if ($fiscal_start == NULL){
            $fiscal_start = $this->fiscal_m->get_default_fiscal_year()->CHR_FISCAL_YEAR_START;
        }
        
        $fiscal_year = $this->fiscal_m->get_selected_fiscal_year($fiscal_start);
        $fiscal_end = $fiscal_year->CHR_FISCAL_YEAR_END;
        
        if($year_month == NULL){
            $year_month = date('Ym');
            // $year_month = '202104';
        }
        
        $year = substr($year_month,0,4);
        $month = substr($year_month,4,2);
        
        $session = $this->session->all_userdata();
        //FOR --> ADMIN & ADMIN BUDGET
        if ($session['ROLE'] === 2 || $session['ROLE'] === 1) { 
            $data['all_dept'] = $this->new_propose_budget_m->get_all_dept();
            $data['all_propose'] = $this->new_propose_budget_m->get_all_propose_admin($fiscal_start, $kode_dept, $year, $month);
            
            $contain = 'budget/propose_budget/new_manage_approval_monthly_budget_v';
            
        //FOR --> BOD
        } else if ($session['ROLE'] === 3) {
            $data['all_dept'] = $this->new_propose_budget_m->get_all_dept();
            $data['all_propose'] = $this->new_propose_budget_m->get_all_propose_bod($fiscal_start, $kode_dept, $year, $month);
           
            $contain = 'budget/propose_budget/new_manage_approval_monthly_budget_v';   
        
        //FOR --> GM    
        } else if ($session['ROLE'] === 4){
            $id_group = $this->session->userdata('GROUPDEPT');
            if($id_group == '6'){
                $kode_group = '001';
            } else if($id_group == '7') {
                $kode_group = '003';
            } else if($id_group == '10') {
                $kode_group = '004';
            }
            
            $data['all_dept'] = $this->new_propose_budget_m->get_group_dept($kode_group);            
            $data['all_propose'] = $this->new_propose_budget_m->get_all_propose_gm($fiscal_start, $kode_dept, $year, $month);
           
            $contain = 'budget/propose_budget/new_manage_approval_monthly_budget_v';
        }
        
        $data['all_month'] = array(
                        array($fiscal_start . '04', 'APR '.$fiscal_start),
                        array($fiscal_start . '05', 'MAY '.$fiscal_start),
                        array($fiscal_start . '06', 'JUN '.$fiscal_start),
                        array($fiscal_start . '07', 'JUL '.$fiscal_start),
                        array($fiscal_start . '08', 'AGU '.$fiscal_start),
                        array($fiscal_start . '09', 'SEP '.$fiscal_start),
                        array($fiscal_start . '10', 'OKT '.$fiscal_start),
                        array($fiscal_start . '11', 'NOV '.$fiscal_start),
                        array($fiscal_start . '12', 'DES '.$fiscal_start),
                        array($fiscal_end . '01', 'JAN '.$fiscal_end),
                        array($fiscal_end . '02', 'FEB '.$fiscal_end),
                        array($fiscal_end . '03', 'MAR '.$fiscal_end),
                    );
                
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(222);
        $data['news'] = $this->news_m->get_news();
        $data['role'] = $session['ROLE'];
        $data['msg'] = $msg;
        
        //--- For list value        
        $data['all_fiscal'] = $this->fiscal_m->get_all_fiscal_year();       
        $data['all_budget_type'] = $this->new_propose_budget_m->get_all_budget_type();
                        
        //--- Value selected
        $data['fiscal_start'] = $fiscal_start;
        $data['fiscal_end'] = $fiscal_end;
        $data['year_month'] = $year_month;
        $data['month'] = $month;
        $data['kode_dept'] = $kode_dept;
                
        $data['content'] = $contain;
        $data['title'] = 'Manage Propose Monthly Budget';

        $this->load->view($this->layout, $data);
    }
    
    function approval_monthly_budget($msg = NULL, $no_propose = NULL) {
        
        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>x</button><strong>Success </strong> Budget is successfully approved </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>x</button><strong>Failed </strong> Budget is failed to approved </div >";
        } else {
            $msg = "";
        }
        
        $no_propose = str_replace('%3C', '/', $no_propose);
        $propose = $this->new_propose_budget_m->get_propose($no_propose);
        $fiscal_start = $propose->CHR_YEAR_BUDGET;
        $fiscal_end = $propose->CHR_YEAR_BUDGET + 1;
        $kode_dept = $propose->CHR_DEPT;
        $year = $propose->CHR_YEAR_PROPOSE;
        $month = $propose->CHR_MONTH_PROPOSE;
        
        $session = $this->session->all_userdata();
        //FOR --> ADMIN & ADMIN BUDGET
        if ($session['ROLE'] === 2 || $session['ROLE'] === 1 ) {
            $data['all_dept'] = $this->new_propose_budget_m->get_all_dept();
            
            $data['propose_capex'] = $this->new_propose_budget_m->get_propose_capex($no_propose);
            $data['propose_repma'] = $this->new_propose_budget_m->get_propose_repma($no_propose);
            $data['propose_right'] = $this->new_propose_budget_m->get_propose_right($no_propose);
            $data['propose_tooeq'] = $this->new_propose_budget_m->get_propose_tooeq($no_propose);
            $data['propose_offeq'] = $this->new_propose_budget_m->get_propose_offeq($no_propose);
            $data['propose_trial'] = $this->new_propose_budget_m->get_propose_trial($no_propose);
            $data['propose_empwa'] = $this->new_propose_budget_m->get_propose_empwa($no_propose);
            $data['propose_engfe'] = $this->new_propose_budget_m->get_propose_engfe($no_propose);
            $data['propose_itexp'] = $this->new_propose_budget_m->get_propose_itexp($no_propose);
            $data['propose_renta'] = $this->new_propose_budget_m->get_propose_renta($no_propose);
            $data['propose_rndev'] = $this->new_propose_budget_m->get_propose_rndev($no_propose);
            $data['propose_donat'] = $this->new_propose_budget_m->get_propose_donat($no_propose);
            $data['propose_enter'] = $this->new_propose_budget_m->get_propose_enter($no_propose);
            
            $contain = 'budget/propose_budget/new_approval_monthly_budget_v';
            
        //FOR --> BOD
        } else if ($session['ROLE'] === 3) {            
            $data['all_dept'] = $this->new_propose_budget_m->get_all_dept();        
            
            $data['propose_capex'] = $this->new_propose_budget_m->get_propose_capex_bod($no_propose);
            $data['propose_repma'] = $this->new_propose_budget_m->get_propose_repma_bod($no_propose);
            $data['propose_right'] = $this->new_propose_budget_m->get_propose_right_bod($no_propose);
            $data['propose_tooeq'] = $this->new_propose_budget_m->get_propose_tooeq_bod($no_propose);
            $data['propose_offeq'] = $this->new_propose_budget_m->get_propose_offeq_bod($no_propose);
            $data['propose_trial'] = $this->new_propose_budget_m->get_propose_trial_bod($no_propose);
            $data['propose_empwa'] = $this->new_propose_budget_m->get_propose_empwa_bod($no_propose);
            $data['propose_engfe'] = $this->new_propose_budget_m->get_propose_engfe_bod($no_propose);
            $data['propose_itexp'] = $this->new_propose_budget_m->get_propose_itexp_bod($no_propose);
            $data['propose_renta'] = $this->new_propose_budget_m->get_propose_renta_bod($no_propose);
            $data['propose_rndev'] = $this->new_propose_budget_m->get_propose_rndev_bod($no_propose);
            $data['propose_donat'] = $this->new_propose_budget_m->get_propose_donat_bod($no_propose);
            $data['propose_enter'] = $this->new_propose_budget_m->get_propose_enter_bod($no_propose);
                        
            $contain = 'budget/propose_budget/new_approval_monthly_budget_v';   
        
        //FOR --> GM    
        } else if ($session['ROLE'] === 4){
            $id_group = $this->session->userdata('GROUPDEPT');
            if($id_group == '6'){
                $kode_group = '001';
            } else if($id_group == '7') {
                $kode_group = '003';
            } else if($id_group == '10') {
                $kode_group = '004';
            }
            
            $data['all_dept'] = $this->new_propose_budget_m->get_group_dept($kode_group);
            
            $data['propose_capex'] = $this->new_propose_budget_m->get_propose_capex_gm($no_propose);
            $data['propose_repma'] = $this->new_propose_budget_m->get_propose_repma_gm($no_propose);
            $data['propose_right'] = $this->new_propose_budget_m->get_propose_right_gm($no_propose);
            $data['propose_tooeq'] = $this->new_propose_budget_m->get_propose_tooeq_gm($no_propose);
            $data['propose_offeq'] = $this->new_propose_budget_m->get_propose_offeq_gm($no_propose);
            $data['propose_trial'] = $this->new_propose_budget_m->get_propose_trial_gm($no_propose);
            $data['propose_empwa'] = $this->new_propose_budget_m->get_propose_empwa_gm($no_propose);
            $data['propose_engfe'] = $this->new_propose_budget_m->get_propose_engfe_gm($no_propose);
            $data['propose_itexp'] = $this->new_propose_budget_m->get_propose_itexp_gm($no_propose);
            $data['propose_renta'] = $this->new_propose_budget_m->get_propose_renta_gm($no_propose);
            $data['propose_rndev'] = $this->new_propose_budget_m->get_propose_rndev_gm($no_propose);
            $data['propose_donat'] = $this->new_propose_budget_m->get_propose_donat_gm($no_propose);
            $data['propose_enter'] = $this->new_propose_budget_m->get_propose_enter_gm($no_propose);
            
            $contain = 'budget/propose_budget/new_approval_monthly_budget_v';
        }
        
        // if($session['ROLE'] === 4){
            $data['ori_capex'] = $this->new_propose_budget_m->get_ori_plan_capex_fy($fiscal_start, $year, $month, $kode_dept);
        // } else {
        //     $data['ori_capex'] = $this->new_propose_budget_m->get_ori_plan_capex($fiscal_start, $year, $month, $kode_dept);
        // }        
        
        $data['ori_repma'] = $this->new_propose_budget_m->get_ori_plan_expense($fiscal_start, $year, $month, $kode_dept, $bgt_type = 'REPMA');
        $data['ori_right'] = $this->new_propose_budget_m->get_ori_plan_expense($fiscal_start, $year, $month, $kode_dept, $bgt_type = 'RIGHT');
        $data['ori_tooeq'] = $this->new_propose_budget_m->get_ori_plan_expense($fiscal_start, $year, $month, $kode_dept, $bgt_type = 'TOOEQ');
        $data['ori_offeq'] = $this->new_propose_budget_m->get_ori_plan_expense($fiscal_start, $year, $month, $kode_dept, $bgt_type = 'OFFEQ');
        $data['ori_trial'] = $this->new_propose_budget_m->get_ori_plan_expense($fiscal_start, $year, $month, $kode_dept, $bgt_type = 'TRIAL');
        $data['ori_empwa'] = $this->new_propose_budget_m->get_ori_plan_expense($fiscal_start, $year, $month, $kode_dept, $bgt_type = 'EMPWA');
        $data['ori_engfe'] = $this->new_propose_budget_m->get_ori_plan_expense($fiscal_start, $year, $month, $kode_dept, $bgt_type = 'ENGFE');
        $data['ori_itexp'] = $this->new_propose_budget_m->get_ori_plan_expense($fiscal_start, $year, $month, $kode_dept, $bgt_type = 'ITEXP');
        $data['ori_renta'] = $this->new_propose_budget_m->get_ori_plan_expense($fiscal_start, $year, $month, $kode_dept, $bgt_type = 'RENTA');
        $data['ori_rndev'] = $this->new_propose_budget_m->get_ori_plan_expense($fiscal_start, $year, $month, $kode_dept, $bgt_type = 'RNDEV');
        $data['ori_donat'] = $this->new_propose_budget_m->get_ori_plan_expense($fiscal_start, $year, $month, $kode_dept, $bgt_type = 'DONAT');
        $data['ori_enter'] = $this->new_propose_budget_m->get_ori_plan_expense($fiscal_start, $year, $month, $kode_dept, $bgt_type = 'ENTER');
        
        $data['all_month'] = array(
                        array($fiscal_start . '04', 'APR '.$fiscal_start),
                        array($fiscal_start . '05', 'MAY '.$fiscal_start),
                        array($fiscal_start . '06', 'JUN '.$fiscal_start),
                        array($fiscal_start . '07', 'JUL '.$fiscal_start),
                        array($fiscal_start . '08', 'AGU '.$fiscal_start),
                        array($fiscal_start . '09', 'SEP '.$fiscal_start),
                        array($fiscal_start . '10', 'OKT '.$fiscal_start),
                        array($fiscal_start . '11', 'NOV '.$fiscal_start),
                        array($fiscal_start . '12', 'DES '.$fiscal_start),
                        array($fiscal_end . '01', 'JAN '.$fiscal_end),
                        array($fiscal_end . '02', 'FEB '.$fiscal_end),
                        array($fiscal_end . '03', 'MAR '.$fiscal_end),
                    );
        
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(222);
        $data['news'] = $this->news_m->get_news();
        $data['role'] = $session['ROLE'];
        $data['msg'] = $msg;
        
        //--- For list value
        $data['list_section'] = $this->new_propose_budget_m->get_list_section($kode_dept);
        $data['all_fiscal'] = $this->fiscal_m->get_all_fiscal_year();       
        $data['all_budget_type'] = $this->new_propose_budget_m->get_all_budget_type();        
                       
        //--- Value selected
        $data['fiscal_start'] = $fiscal_start;
        $data['fiscal_end'] = $fiscal_end;
        $data['year_month'] = $propose->CHR_YEAR_PROPOSE . $propose->CHR_MONTH_PROPOSE;
        $data['month'] = $propose->CHR_MONTH_PROPOSE;
        $data['switch'] = $propose->CHR_FLG_SWITCH;
        $data['kode_dept'] = $kode_dept;
        $data['no_propose'] = $no_propose;
                
        $data['content'] = $contain;
        $data['title'] = 'Approval Monthly Budget';

        $this->load->view($this->layout, $data);
    }
    
    function save_proposed_budget(){    
        $session = $this->session->all_userdata();
        $no_propose = $this->input->post('CHR_NO_PROPOSE');
        $header_prop = $this->new_propose_budget_m->get_propose($no_propose);
        
        //Cek apakah sudah dipropose atau belum
        if($header_prop->CHR_FLG_SWITCH > 0){
            redirect("budget/new_propose_budget_c/view_propose_budget/6/". str_replace('/','<',$no_propose) . "/" . $header_prop->CHR_DEPT);
        }
        
        $all_budget = $this->new_propose_budget_m->get_list_budget_proposed($no_propose);
        $all_budget_type = $this->new_propose_budget_m->get_list_budget_type($no_propose);
        $sum_all_prop = $this->input->post('summary_all_prop');
        
        if($_POST["save"] == 'save'){
            foreach($all_budget as $bgt){
                $no_budget = trim($bgt->CHR_NO_BUDGET);
                if(isset($_POST["check_".$no_budget])){
                    $note = $this->input->post('note_'.$no_budget);
                    if($note == '' || $note == ' '){
                        $note = NULL;
                    }
                    $gr_date = $this->input->post('month_gr_'.$no_budget);
                    $limit_ori = $bgt->MON_PLAN_BLN * 0.7;                    
                    $prop_amo = str_replace('.','',$this->input->post('amo_'.$no_budget));
                    $tot_prop = $bgt->MON_LIMIT_BLN + $prop_amo;
                    $over = 0;
                    if(round($tot_prop) > round($bgt->MON_PLAN_BLN)){
                        //Total propose over budget
                        $over = 2;
                    } else {
                        if(round($tot_prop) > round($limit_ori)){
                            //Total propose over limit
                            $over = 1;
                        } else {
                            $over = 0;
                        }
                    }

                    $proposed = array(
                                    'CHR_ESTIMATE_GR_DATE' => $gr_date,
                                    'MON_PROPOSE_BLN' => $prop_amo,
                                    'CHR_FLG_OVERBUDGET' => $over,
                                    'CHR_NOTES' => $note
                                );
                    $this->new_propose_budget_m->update_proposed_budget($proposed, $no_propose, $no_budget);
                } else {
                    $this->new_propose_budget_m->delete_proposed_budget($no_propose, $no_budget);
                }
            }
            
            foreach($all_budget_type as $bgt_type){
                $type = strtolower($bgt_type->CHR_BUDGET_TYPE);
                $bgt_note = $this->input->post('notes_'.$type);
                $notes = array('CHR_NOTES_'.$bgt_type->CHR_BUDGET_TYPE => $bgt_note);
                $this->new_propose_budget_m->update_notes_budget($notes, $no_propose);
            }
            
            $updated = array(
                        'CHR_MODI_BY' => $session['USERNAME'],
                        'CHR_MODI_DATE' => date('Ymd'),
                        'CHR_MODI_TIME' => date('His')
                    );
            $this->new_propose_budget_m->update_header_propose($updated, $no_propose);
            
            redirect("budget/new_propose_budget_c/view_propose_budget/5/". str_replace('/','<',$no_propose) . "/" . $header_prop->CHR_DEPT);            
        } else {
            //Kebutuhan mengambil NPK GM untuk notifikasi
            $dept = trim($header_prop->CHR_DEPT);
            if($dept == 'MIS'){
                $dept = 'MISY';
            } else if($dept == 'PPC'){
                $dept = 'PPIC';
            } else if($dept == 'QCO' || $dept == 'QAS'){
                $dept = 'QA';
            } else {
                $dept = trim($dept);
            }

            $id_group = $this->dept_m->get_id_groupdept_by_dept($dept);
            $get_npk_gm = $this->user_m->get_npk_groupdept($id_group);
                        
            foreach($all_budget as $bgt){
                $no_budget = trim($bgt->CHR_NO_BUDGET);
                if(isset($_POST["check_".$no_budget])){
                    $note = $this->input->post('note_'.$no_budget);
                    if($note == '' || $note == ' '){
                        $note = NULL;
                    }
                    $gr_date = $this->input->post('month_gr_'.$no_budget);
                    $limit_ori = $bgt->MON_PLAN_BLN * 0.7;                    
                    $prop_amo = str_replace('.','',$this->input->post('amo_'.$no_budget));
                    $tot_prop = $bgt->MON_LIMIT_BLN + $prop_amo;
                    $over = 0;
                    if($tot_prop > $bgt->MON_PLAN_BLN){
                        //Total propose over budget
                        $over = 2;
                    } else {
                        if($tot_prop > $limit_ori){
                            //Total propose over limit
                            $over = 1;
                        }
                    }

                    $proposed = array(
                                    'CHR_ESTIMATE_GR_DATE' => $gr_date,
                                    'MON_PROPOSE_BLN' => $prop_amo,
                                    'CHR_FLG_OVERBUDGET' => $over,
                                    'CHR_NOTES' => $note,
                                    'CHR_FLG_PROPOSED' => 1
                                );
                    $this->new_propose_budget_m->update_proposed_budget($proposed, $no_propose, $no_budget);
                } else {
                    $this->new_propose_budget_m->delete_proposed_budget($no_propose, $no_budget);
                }
            }
            
            foreach($all_budget_type as $bgt_type){
                $type = strtolower($bgt_type->CHR_BUDGET_TYPE);
                $bgt_note = $this->input->post('notes_'.$type);       
                $notes = array('CHR_NOTES_'.$bgt_type->CHR_BUDGET_TYPE => $bgt_note);
                $this->new_propose_budget_m->update_notes_budget($notes, $no_propose);
            }
            
            $updated = array(
                        'CHR_FLG_SWITCH' => 1,
                        'CHR_MODI_BY' => $session['USERNAME'],
                        'CHR_MODI_DATE' => date('Ymd'),
                        'CHR_MODI_TIME' => date('His')
                    );
            $this->new_propose_budget_m->update_header_propose($updated, $no_propose);
            
            //Send notification
            foreach($get_npk_gm as $gm){
                $seq_id = $this->notification_m->generate_id();

                $data_notif = array(
                        'INT_ID_NOTIF' => $seq_id,
                        'CHR_NPK' => $gm->CHR_NPK,
                        'INT_ID_APP' => '4',
                        'CHR_NOTIF_TITLE' => $no_propose,
                        'CHR_NOTIF_DESC' => $no_propose,
                        'CHR_LINK' => "budget/new_propose_budget_c/approval_monthly_budget/0/" . str_replace('/','<',$no_propose),
                        'CHR_CREATED_BY' => $session['USERNAME'],
                        'CHR_CREATED_DATE' => date('Ymd'),
                        'CHR_CREATED_TIME' => date('His')
                    );
                $this->notification_m->insert_notification($data_notif);
            }

            redirect("budget/new_propose_budget_c/view_propose_budget/1/". str_replace('/','<',$no_propose) . "/" . $header_prop->CHR_DEPT);
        }
    }
    
    function approved_propose_budget_admin(){
        $session = $this->session->all_userdata();
        $no_propose = $this->input->post('CHR_NO_PROPOSE');
        $header_prop = $this->new_propose_budget_m->get_propose($no_propose);
        $all_budget = $this->new_propose_budget_m->get_list_budget_proposed_admin($no_propose);
        $fis_start = $header_prop->CHR_YEAR_BUDGET;
        $year_prop = $header_prop->CHR_YEAR_PROPOSE;
        $month_prop = $header_prop->CHR_MONTH_PROPOSE;
        $ym_prop = $year_prop.$month_prop;
        
        //Kebutuhan mengambil NPK GM untuk notifikasi
        $dept = $header_prop->CHR_DEPT;
        if($dept == 'MIS'){
            $dept = 'MISY';
        } else if($dept == 'PPC'){
            $dept = 'PPIC';
        } else if($dept == 'QCO' || $dept == 'QAS'){
            $dept = 'QA';
        } else {
            $dept = trim($dept);
        }
        
        $id_div = $this->dept_m->get_id_div_by_dept($dept);
        $get_npk_bod = $this->user_m->get_npk_div($id_div);
        
        if($_POST["approve"] == 'gm'){            
            foreach($all_budget as $bgt){
                $no_budget = trim($bgt->CHR_NO_BUDGET);
                if(isset($_POST["check_".$no_budget])){
                    $proposed = array(
                                    'CHR_FLG_APPROVE_GM' => 1
                                );
                    $this->new_propose_budget_m->approved_propose_budget_gm($proposed, $no_propose, $no_budget);
                } else {
                    $note = $this->input->post('note_'.$no_budget);

                    $proposed = array(
                                        'CHR_FLG_PROPOSED' => 2,
                                        'CHR_FLG_DELETE' => 1,
                                        'CHR_REMARK' => $note
                                    );
                    $this->new_propose_budget_m->approved_propose_budget_gm($proposed, $no_propose, $no_budget);
                }
            }        
            
            $header = array(
                'CHR_FLG_SWITCH' => 2,
                'CHR_APPROVE_GM_BY' => strtoupper($session['USERNAME']),
                'CHR_APPROVE_GM_DATE' => date('Ymd'),
                'CHR_APPROVE_GM_TIME' => date('His')
            );
            
            $this->new_propose_budget_m->update_header_propose($header, $no_propose);
            
            //Send notification
            foreach($get_npk_bod as $bod){
                $seq_id = $this->notification_m->generate_id();

                $data_notif = array(
                        'INT_ID_NOTIF' => $seq_id,
                        'CHR_NPK' => $bod->CHR_NPK,
                        'INT_ID_APP' => '4',
                        'CHR_NOTIF_TITLE' => $no_propose,
                        'CHR_NOTIF_DESC' => $no_propose,
                        'CHR_LINK' => "budget/new_propose_budget_c/approval_monthly_budget/0/" . str_replace('/','<',$no_propose),
                        'CHR_CREATED_BY' => $session['USERNAME'],
                        'CHR_CREATED_DATE' => date('Ymd'),
                        'CHR_CREATED_TIME' => date('His')
                    );
                $this->notification_m->insert_notification($data_notif);
            }
            
            redirect("budget/new_propose_budget_c/manage_approval_monthly_budget/1/". $fis_start . "/" . $ym_prop . "/" . trim($header_prop->CHR_DEPT));
        } else if ($_POST["approve"] == 'bod'){
            foreach($all_budget as $bgt){
                $no_budget = trim($bgt->CHR_NO_BUDGET);
                $flag_change = 0;
                if(isset($_POST["check_".$no_budget])){
                    $budget_type = $bgt->CHR_BUDGET_TYPE;
                    $prop_amo = $bgt->MON_PROPOSE_BLN;  
                    $prop_qty = $bgt->INT_QTY_PROPOSE;
                    
                    $sum_budget_fy = $this->new_propose_budget_m->get_sum_no_budget($fis_start, $dept_prop, $budget_type, $no_budget, $year_prop, $month_prop);
                    $limit_budget = $this->new_propose_budget_m->get_limit_bln_budget($fis_start, $dept_prop, $budget_type, $no_budget, $year_prop, $month_prop);
                    $plan_ori_bln = $limit_budget->PLAN_BLN;
                    $qty_ori_bln = $limit_budget->INT_QTY;
                    $limit_ori_fy = $sum_budget_fy->PBLN * 0.7;
                    $limit_fy = $sum_budget_fy->LBLN;
                    $new_limit_fy = $limit_fy + $prop_amo;
                    $limit_prop = $limit_budget->LIMIT_BLN + $prop_amo;                    
                    
                    if($new_limit_fy != $limit_ori_fy){
                        $flag_change = 1;
                    }
                    
                    //Jika UNBUDGET baru, maka perlu menambahkan propose amount ke OUTLOOK, agar nanti bisa dicari ketika ADD BUDGET. 
                    //Default OUTLOOK sesuai PLAN ORIGINAL
                    $out_prop = $plan_ori_bln;
                    $new_qty = $qty_ori_bln;
                    if($bgt->CHR_FLG_UNBUDGET == '1' && $bgt->CHR_YEAR_ACTUAL == $year_prop && $bgt->CHR_MONTH_ACTUAL == $month_prop){
                        $out_prop = $limit_prop;
                        $new_qty = $prop_qty;
                    }
                    
                    $proposed = array(
                                    'CHR_FLG_APPROVE_BOD' => 1,
                                    'CHR_FLG_PROPOSED' => 3
                                );                    
                    
                    if($budget_type == 'CAPEX'){
                        $update_master = array(
                                        'MON_LIMBLN'.$month_prop => $limit_prop,
                                        'MON_OUTBLN'.$month_prop => $out_prop
                                    );    
                    } else {
                        $update_master = array(
                                        'MON_LIMBLN'.$month_prop => $limit_prop,
                                        'INT_QTY_LIMBLN'.$month_prop => $qty_prop,
                                        'MON_OUTBLN'.$month_prop => $out_prop,
                                        'INT_QTY_OUTBLN'.$month_prop => $qty_prop                                        
                                    );  
                    }

                    $update_flag = array(
                                    'CHR_FLG_UNBUDGET' => $bgt->CHR_FLG_UNBUDGET,
                                    'CHR_FLG_CHANGE_AMOUNT' => $flag_change,
                                    'CHR_FLG_APPROVAL_PROCESS' => 2
                                );

                    //Eksekusi query UPDATE master data budget CAPEX & EXPENSE
                    $bgt_aii = $this->load->database("bgt_aii", TRUE);
                    $bgt_aii->trans_begin();
                    $this->new_propose_budget_m->update_master_budget($update_master, $no_budget, $budget_type, $year_prop, $fis_start);
                    $this->new_propose_budget_m->update_flag_master_budget($update_flag, $no_budget, $budget_type);
                    $bgt_aii->trans_complete();

                    if ($bgt_aii->trans_status() === TRUE){
                        //Eksekusi query UPDATE table DETAIL & HEADER PROPOSE BUDGET
                        $this->new_propose_budget_m->approved_propose_budget_bod($proposed, $no_propose, $no_budget);
                    } else {
                        redirect("budget/new_propose_budget_c/manage_approval_monthly_budget/2/". $fis_start . "/" . $ym_prop . "/" . trim($header_prop->CHR_DEPT));
                    }
                } else {
                    $note = $this->input->post('note_'.$no_budget);

                    $proposed = array(
                                        'CHR_FLG_PROPOSED' => 2,
                                        'CHR_FLG_DELETE' => 1,
                                        'CHR_REMARK' => $note
                                    );
                    $this->new_propose_budget_m->approved_propose_budget_bod($proposed, $no_propose, $no_budget);
                }
            }
            
            $header = array(
                'CHR_FLG_SWITCH' => 3,
                'CHR_APPROVE_BOD_BY' => strtoupper($session['USERNAME']),
                'CHR_APPROVE_BOD_DATE' => date('Ymd'),
                'CHR_APPROVE_BOD_TIME' => date('His')
            );
            
            $this->new_propose_budget_m->update_header_propose($header, $no_propose);
            
            redirect("budget/new_propose_budget_c/manage_approval_monthly_budget/1/". $fis_start . "/" . $ym_prop . "/" . trim($header_prop->CHR_DEPT));
        }
    }
    
    function approved_propose_budget_gm(){        
        $session = $this->session->all_userdata();
        $no_propose = $this->input->post('CHR_NO_PROPOSE');
        $header_prop = $this->new_propose_budget_m->get_propose($no_propose);
        $all_budget = $this->new_propose_budget_m->get_list_budget_proposed_gm($no_propose);
        $fis_start = $header_prop->CHR_YEAR_BUDGET;
        $year_prop = $header_prop->CHR_YEAR_PROPOSE;
        $month_prop = $header_prop->CHR_MONTH_PROPOSE;
        $ym_prop = $year_prop.$month_prop;
        
        //Kebutuhan mengambil NPK BOD untuk notifikasi
        $dept = $header_prop->CHR_DEPT;
        if($dept == 'MIS'){
            $dept = 'MISY';
        } else if($dept == 'PPC'){
            $dept = 'PPIC';
        } else if($dept == 'QCO' || $dept == 'QAS'){
            $dept = 'QA';
        } else {
            $dept = trim($dept);
        }
        
        $id_div = $this->dept_m->get_id_div_by_dept($dept);
        $get_npk_bod = $this->user_m->get_npk_div($id_div);
                
        foreach($all_budget as $bgt){
            $no_budget = trim($bgt->CHR_NO_BUDGET);
            if(isset($_POST["check_".$no_budget])){
                $proposed = array(
                                'CHR_FLG_APPROVE_GM' => 1
                            );
                $this->new_propose_budget_m->approved_propose_budget_gm($proposed, $no_propose, $no_budget);
            } else {
                $note = $this->input->post('note_'.$no_budget);

                $proposed = array(
                                    'CHR_FLG_PROPOSED' => 2,
                                    'CHR_FLG_DELETE' => 1,
                                    'CHR_REMARK' => $note
                                );
                $this->new_propose_budget_m->approved_propose_budget_gm($proposed, $no_propose, $no_budget);
            }
        }        

        $header = array(
            'CHR_FLG_SWITCH' => 2,
            'CHR_APPROVE_GM_BY' => strtoupper($session['USERNAME']),
            'CHR_APPROVE_GM_DATE' => date('Ymd'),
            'CHR_APPROVE_GM_TIME' => date('His')
        );

        $this->new_propose_budget_m->update_header_propose($header, $no_propose);
        
        //Send notification
        foreach($get_npk_bod as $bod){
            $seq_id = $this->notification_m->generate_id();

            $data_notif = array(
                    'INT_ID_NOTIF' => $seq_id,
                    'CHR_NPK' => $bod->CHR_NPK,
                    'INT_ID_APP' => '4',
                    'CHR_NOTIF_TITLE' => $no_propose,
                    'CHR_NOTIF_DESC' => $no_propose,
                    'CHR_LINK' => "budget/new_propose_budget_c/approval_monthly_budget/0/" . str_replace('/','<',$no_propose),
                    'CHR_CREATED_BY' => $session['USERNAME'],
                    'CHR_CREATED_DATE' => date('Ymd'),
                    'CHR_CREATED_TIME' => date('His')
                );
            $this->notification_m->insert_notification($data_notif);
        }

        redirect("budget/new_propose_budget_c/manage_approval_monthly_budget/1/". $fis_start . "/" . $ym_prop . "/" . trim($header_prop->CHR_DEPT));
    }
    
    function approved_propose_budget_bod(){        
        $session = $this->session->all_userdata();
        $no_propose = $this->input->post('CHR_NO_PROPOSE');
        $header_prop = $this->new_propose_budget_m->get_propose($no_propose);
        $all_budget = $this->new_propose_budget_m->get_list_budget_proposed_bod($no_propose);
        $fis_start = $header_prop->CHR_YEAR_BUDGET;
        $year_prop = $header_prop->CHR_YEAR_PROPOSE;
        $month_prop = $header_prop->CHR_MONTH_PROPOSE;
        $ym_prop = $year_prop.$month_prop;
        $dept_prop = trim($header_prop->CHR_DEPT);
        
        foreach($all_budget as $bgt){
            $no_budget = trim($bgt->CHR_NO_BUDGET);
            $flag_change = 0;
            if(isset($_POST["check_".$no_budget])){
                $budget_type = $bgt->CHR_BUDGET_TYPE;
                $prop_amo = $bgt->MON_PROPOSE_BLN;
                $prop_qty = $bgt->INT_QTY_PROPOSE;

                $sum_budget_fy = $this->new_propose_budget_m->get_sum_no_budget($fis_start, $dept_prop, $budget_type, $no_budget, $year_prop, $month_prop);
                $limit_budget = $this->new_propose_budget_m->get_limit_bln_budget($fis_start, $dept_prop, $budget_type, $no_budget, $year_prop, $month_prop);
                $plan_ori_bln = $limit_budget->PLAN_BLN;
                $qty_ori_bln = $limit_budget->INT_QTY;
                $limit_ori_fy = $sum_budget_fy->PBLN * 0.7;
                $limit_fy = $sum_budget_fy->LBLN;
                $new_limit_fy = $limit_fy + $prop_amo;
                $limit_prop = $limit_budget->LIMIT_BLN + $prop_amo; 

                if($new_limit_fy != $limit_ori_fy){
                    $flag_change = 1;
                }
                
                //Jika UNBUDGET baru, maka perlu menambahkan propose amount ke OUTLOOK, agar nanti bisa dicari ketika ADD BUDGET. 
                //Default OUTLOOK sesuai PLAN ORIGINAL
                $out_prop = $plan_ori_bln;
                $new_qty = $qty_ori_bln;
                if($bgt->CHR_FLG_UNBUDGET == '1' && $bgt->CHR_YEAR_ACTUAL == $year_prop && $bgt->CHR_MONTH_ACTUAL == $month_prop){
                    $out_prop = $limit_prop;
                    $new_qty = $prop_qty;
                }

                $proposed = array(
                                'CHR_FLG_APPROVE_BOD' => 1,
                                'CHR_FLG_PROPOSED' => 3
                            );                              
                
                if($budget_type == 'CAPEX'){
                    $update_master = array(
                                    'MON_LIMBLN'.$month_prop => $limit_prop,
                                    'MON_OUTBLN'.$month_prop => $out_prop
                                );    
                } else {
                    $update_master = array(
                                    'MON_LIMBLN'.$month_prop => $limit_prop,
                                    'INT_QTY_LIMBLN'.$month_prop => $new_qty,
                                    'MON_OUTBLN'.$month_prop => $out_prop,
                                    'INT_QTY_OUTBLN'.$month_prop => $new_qty
                                );  
                }                      

                $update_flag = array(
                                'CHR_FLG_UNBUDGET' => $bgt->CHR_FLG_UNBUDGET,
                                'CHR_FLG_CHANGE_AMOUNT' => $flag_change,
                                'CHR_FLG_APPROVAL_PROCESS' => 2
                            );
                
                //Eksekusi query UPDATE master data budget CAPEX & EXPENSE
                $bgt_aii = $this->load->database("bgt_aii", TRUE);
                $bgt_aii->trans_begin();
                $this->new_propose_budget_m->update_master_budget($update_master, $no_budget, $budget_type, $year_prop, $fis_start);
                $this->new_propose_budget_m->update_flag_master_budget($update_flag, $no_budget, $budget_type);
                $bgt_aii->trans_complete();
                
                if ($bgt_aii->trans_status() === TRUE){
                    //Eksekusi query UPDATE table DETAIL & HEADER PROPOSE BUDGET
                    $this->new_propose_budget_m->approved_propose_budget_bod($proposed, $no_propose, $no_budget);
                } else {
                    redirect("budget/new_propose_budget_c/manage_approval_monthly_budget/2/". $fis_start . "/" . $ym_prop . "/" . $dept_prop);
                }                
            } else {
                $note = $this->input->post('note_'.$no_budget);

                $proposed = array(
                                    'CHR_FLG_PROPOSED' => 2,
                                    'CHR_FLG_DELETE' => 1,
                                    'CHR_REMARK' => $note
                                );
                $this->new_propose_budget_m->approved_propose_budget_bod($proposed, $no_propose, $no_budget);
            }
        }

        $header = array(
            'CHR_FLG_SWITCH' => 3,
            'CHR_APPROVE_BOD_BY' => strtoupper($session['USERNAME']),
            'CHR_APPROVE_BOD_DATE' => date('Ymd'),
            'CHR_APPROVE_BOD_TIME' => date('His')
        );

        $this->new_propose_budget_m->update_header_propose($header, $no_propose);

        redirect("budget/new_propose_budget_c/manage_approval_monthly_budget/1/". $fis_start . "/" . $ym_prop . "/" . $dept_prop);
    }
    
    function delete_propose_budget($no_propose){
        $session = $this->session->all_userdata();
        $no_propose = str_replace('%3C', '/', $no_propose);
        $prop = $this->new_propose_budget_m->get_propose($no_propose);
        
        $this->db->trans_begin();
        $del_list_proposed = array(
                                    'CHR_FLG_DELETE' => 1
                                );     
        $this->new_propose_budget_m->delete_list_propose_budget($del_list_proposed, $no_propose);
        $del_proposed = array(
                                    'CHR_FLG_DELETE_PROP' => 1,
                                    'CHR_MODI_BY' => $session['USERNAME'],
                                    'CHR_MODI_DATE' => date('Ymd'),
                                    'CHR_MODI_TIME' => date('His')
                                );     
        $this->new_propose_budget_m->delete_propose_budget($del_proposed, $no_propose);
        $this->db->trans_complete();
        
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            redirect("budget/new_propose_budget_c/index/2/". $prop->CHR_YEAR_BUDGET . "/" . $prop->CHR_YEAR_PROPOSE.$prop->CHR_MONTH_PROPOSE . "/" . $prop->CHR_DEPT);
        } else {
            $this->db->trans_commit();
            redirect("budget/new_propose_budget_c/index/4/". $prop->CHR_YEAR_BUDGET . "/" . $prop->CHR_YEAR_PROPOSE.$prop->CHR_MONTH_PROPOSE . "/" . $prop->CHR_DEPT);
        }        
    }
    
    function cancel_propose_budget($no_propose){
        $session = $this->session->all_userdata();
        $no_propose = str_replace('%3C', '/', $no_propose);
        $prop = $this->new_propose_budget_m->get_propose($no_propose);
        
        $this->db->trans_begin();
        $cancel_list_proposed = array(
                                    'CHR_FLG_PROPOSED' => 0
                                );     
        $this->new_propose_budget_m->cancel_list_propose_budget($cancel_list_proposed, $no_propose);
        $cancel_proposed = array(
                                    'CHR_FLG_SWITCH' => 0,
                                    'CHR_MODI_BY' => $session['USERNAME'],
                                    'CHR_MODI_DATE' => date('Ymd'),
                                    'CHR_MODI_TIME' => date('His')
                                );     
        $this->new_propose_budget_m->cancel_propose_budget($cancel_proposed, $no_propose);
        $this->db->trans_complete();
        
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            redirect("budget/new_propose_budget_c/index/2/". $prop->CHR_YEAR_BUDGET . "/" . $prop->CHR_YEAR_PROPOSE.$prop->CHR_MONTH_PROPOSE . "/" . $prop->CHR_DEPT);
        } else {
            $this->db->trans_commit();
            redirect("budget/new_propose_budget_c/index/4/". $prop->CHR_YEAR_BUDGET . "/" . $prop->CHR_YEAR_PROPOSE.$prop->CHR_MONTH_PROPOSE . "/" . $prop->CHR_DEPT);
        }        
    }
    
    function export_excel($no_propose = NULL) {
        $row = 7;
        
        $no_propose = str_replace('%3C', '/', $no_propose);
        
        $header_propose = $this->new_propose_budget_m->get_propose($no_propose);
        $all_list_propose = $this->new_propose_budget_m->get_all_budget_list_propose($no_propose);        

        $kode_dept = trim($header_propose->CHR_DEPT);
        $dept_desc = $this->new_propose_budget_m->get_dept_desc($kode_dept);        
        $year_prop = $header_propose->CHR_YEAR_PROPOSE;
        $month_prop = $header_propose->CHR_MONTH_PROPOSE;        
        $month_name = strtoupper(date("F", mktime(null, null, null, $month_prop)));

        $this->load->library('excel');
        $objReader = PHPExcel_IOFactory::createReader('Excel5');
        // Create new PHPExcel object

        $objPHPExcel = $objReader->load("assets/template/budget/template_propose/Template_Propose_Budget.xls");
//================================== DETAIL PROPOSE ==========================//
        $seq = 1;
        $active_sheet = $objPHPExcel->setActiveSheetIndexByName('DETAIL PROPOSE');
        $active_sheet->setCellValue("B2", "PROPOSE BUDGET " . $month_name . " " . $year_prop . " : " . $no_propose);
        $active_sheet->setCellValue("B3", "DEPARTMENT : " . $kode_dept . " - " . $dept_desc->CHR_DEPARTMENT_DESCRIPTION);
        foreach ($all_list_propose as $value) {
            $year_budget = $value->CHR_YEAR_BUDGET;
            $budget_type = $value->CHR_BUDGET_TYPE;
            $budget_no = $value->CHR_NO_BUDGET;
            $budget_desc = $value->CHR_BUDGET_DESC;
            $amo_plan_fy = $value->MON_PLAN_BLN; 
            $amo_limit_fy = $value->MON_PLAN_BLN * 0.7;
            $amo_real_fy = $value->MON_REAL_BLN; 
            $balance_plan_fy = $amo_plan_fy - $amo_real_fy;
            $proposed_fy = $value->MON_LIMIT_BLN;
            $balance_prop_fy = $proposed_fy - $amo_real_fy;
            $new_proposed = $value->MON_PROPOSE_BLN;
            $estimate_gr = $value->CHR_ESTIMATE_GR_DATE;
            
            $flag_unb = 'No';
            if($value->CHR_FLG_UNBUDGET == '1'){
                $flag_unb = 'Yes';
            }
            
            $flag_over = 'UNDERBUDGET';
            if($value->CHR_FLG_OVERBUDGET == '1'){
                $flag_over = 'OVERLIMIT';
            }else if($value->CHR_FLG_OVERBUDGET == '2'){
                $flag_over = 'OVERBUDGET';
            }
            
            $flag_approve = 'OPEN';
            if($value->CHR_FLG_PROPOSED == '1'){
                $flag_approve = 'WAIT';
            }else if($value->CHR_FLG_PROPOSED == '2'){
                $flag_approve = 'HOLD';
            }else if($value->CHR_FLG_PROPOSED == '3'){
                $flag_approve = 'COMPLETE';
            }

            $active_sheet->setCellValue("B$row", "$seq");
            $active_sheet->setCellValue("C$row", "$year_budget");
            $active_sheet->setCellValue("D$row", "$budget_type");
            $active_sheet->setCellValue("E$row", "$budget_no");
            $active_sheet->setCellValue("F$row", "$budget_desc");
            $active_sheet->setCellValue("G$row", "$amo_plan_fy");
            $active_sheet->setCellValue("H$row", "$amo_limit_fy");
            $active_sheet->setCellValue("I$row", "$amo_real_fy");
            $active_sheet->setCellValue("J$row", "$balance_plan_fy");
            $active_sheet->setCellValue("K$row", "$proposed_fy");
            $active_sheet->setCellValue("L$row", "$balance_prop_fy");
            $active_sheet->setCellValue("M$row", "$new_proposed");
            $active_sheet->setCellValue("N$row", "$estimate_gr");
            $active_sheet->setCellValue("O$row", "$flag_unb");
            $active_sheet->setCellValue("P$row", "$flag_over");
            $active_sheet->setCellValue("Q$row", "$flag_approve");

            $seq++;
            $row++;
        }

        $active_sheet->getStyle("B7:Q$row")->applyFromArray(array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        ));

        $row_min = $row - 1;
        $active_sheet->setCellValue("G$row", "=SUM(G7:G$row_min)");
        $active_sheet->setCellValue("H$row", "=SUM(H7:H$row_min)");
        $active_sheet->setCellValue("I$row", "=SUM(I7:I$row_min)");
        $active_sheet->setCellValue("J$row", "=SUM(J7:J$row_min)");
        $active_sheet->setCellValue("K$row", "=SUM(K7:K$row_min)");
        $active_sheet->setCellValue("L$row", "=SUM(L7:L$row_min)");
        $active_sheet->setCellValue("M$row", "=SUM(M7:M$row_min)");
        $active_sheet->getStyle("B7:Q$row")->applyFromArray(array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            ),
        ));
        
        $active_sheet->mergeCells("B$row:F$row");
        $active_sheet->setCellValue("B$row", "TOTAL");
        $active_sheet->getStyle("B$row")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $active_sheet->getStyle("B$row:Q$row")->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('#CCCCCC');
        $active_sheet->getStyle("B$row:Q$row")->applyFromArray(array(
            'font' => array(
                'bold' => true,
                'size' => 12
            )
        ));

        $row = $row + 3;

        $gdImage = imagecreatefromjpeg('assets/template/budget/template_propose/approval.JPG');
        // Add a drawing to the worksheetecho date('H:i:s') . " Add a drawing to the worksheet\n";
        $objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
        $objDrawing->setName('Sample image');
        $objDrawing->setDescription('Sample image');
        $objDrawing->setImageResource($gdImage);
        $objDrawing->setRenderingFunction(PHPExcel_Worksheet_MemoryDrawing::RENDERING_JPEG);
        $objDrawing->setMimeType(PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_DEFAULT);
        $objDrawing->setHeight(105);
        $objDrawing->setCoordinates("N$row");
        $objDrawing->setWorksheet($active_sheet);
//========================== END DETAIL PROPOSE ==============================//

//============================== SUMMARY PROPOSE =============================//
        $budget_type_prop = $this->new_propose_budget_m->summary_prop_by_budget_type($no_propose);
        $fis_start = $header_propose->CHR_YEAR_BUDGET;
        $row = 7;
        $seq = 1;
        $active_sheet = $objPHPExcel->setActiveSheetIndexByName('SUMMARY');
        $active_sheet->setCellValue("B2", "SUMMARY BUDGET " . $month_name . " " . $year_prop . " : " . $no_propose);
        $active_sheet->setCellValue("B3", "DEPARTMENT : " . $kode_dept . " - " . $dept_desc->CHR_DEPARTMENT_DESCRIPTION);
        foreach ($budget_type_prop as $value) {
            if(trim($value->CHR_BUDGET_TYPE) == 'CAPEX'){
                $ori_plan = $this->new_propose_budget_m->get_ori_plan_capex($fis_start, $year_prop, $month_prop, $kode_dept);                
            } else {
                $bgt_type = trim($value->CHR_BUDGET_TYPE);
                $ori_plan = $this->new_propose_budget_m->get_ori_plan_expense($fis_start, $year_prop, $month_prop, $kode_dept, $bgt_type);                
            }
            
            $year_budget = $fis_start;
            $budget_type = trim($value->CHR_BUDGET_TYPE);
            $amo_plan_bln = $ori_plan->PBLN;
            $amo_limit_bln = $ori_plan->PBLN * 0.7;
            $amo_real_bln = $ori_plan->OBLN;
            $balace_plan_bln = $amo_plan_bln - $amo_real_bln;
            $proposed_bln = $ori_plan->LBLN;
            $balance_prop_bln = proposed_bln - $amo_real_bln;
            $new_propose = $value->MON_PROPOSE_BLN;
            
            $flag_over = 'UNDERBUDGET';
            if(($new_propose + $proposed_bln) > $amo_limit_bln && ($new_propose + $proposed_bln) <= $amo_plan_bln){
                $flag_over = 'OVERLIMIT';
            }else if($amo_plan_bln < ($new_propose + $proposed_bln)){
                $flag_over = 'OVERBUDGET';
            }

            $active_sheet->setCellValue("B$row", "$seq");
            $active_sheet->setCellValue("C$row", "$year_budget");
            $active_sheet->setCellValue("D$row", "$budget_type");
            $active_sheet->setCellValue("E$row", "$amo_plan_bln");
            $active_sheet->setCellValue("F$row", "$amo_limit_bln");
            $active_sheet->setCellValue("G$row", "$amo_real_bln");
            $active_sheet->setCellValue("H$row", "$balace_plan_bln");
            $active_sheet->setCellValue("I$row", "$proposed_bln");
            $active_sheet->setCellValue("J$row", "$balance_prop_bln");
            $active_sheet->setCellValue("K$row", "$new_propose");
            $active_sheet->setCellValue("L$row", "$flag_over");

            $seq++;
            $row++;
        }

        $active_sheet->getStyle("B7:L$row")->applyFromArray(array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        ));

        $row_min = $row - 1;
        $active_sheet->setCellValue("E$row", "=SUM(E7:E$row_min)");
        $active_sheet->setCellValue("F$row", "=SUM(F7:F$row_min)");
        $active_sheet->setCellValue("G$row", "=SUM(G7:G$row_min)");
        $active_sheet->setCellValue("H$row", "=SUM(H7:H$row_min)");
        $active_sheet->setCellValue("I$row", "=SUM(I7:I$row_min)");
        $active_sheet->setCellValue("J$row", "=SUM(J7:J$row_min)");
        $active_sheet->setCellValue("K$row", "=SUM(K7:K$row_min)");
        $active_sheet->getStyle("B7:L$row")->applyFromArray(array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            ),
        ));
        
        $active_sheet->mergeCells("B$row:D$row");
        $active_sheet->setCellValue("B$row", "TOTAL");
        $active_sheet->getStyle("B$row")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $active_sheet->getStyle("B$row:L$row")->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('#CCCCCC');
        $active_sheet->getStyle("B$row:L$row")->applyFromArray(array(
            'font' => array(
                'bold' => true,
                'size' => 12
            )
        ));

        $row = $row + 3;

        $gdImage = imagecreatefromjpeg('assets/template/budget/template_propose/approval.JPG');
        // Add a drawing to the worksheetecho date('H:i:s') . " Add a drawing to the worksheet\n";
        $objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
        $objDrawing->setName('Sample image');
        $objDrawing->setDescription('Sample image');
        $objDrawing->setImageResource($gdImage);
        $objDrawing->setRenderingFunction(PHPExcel_Worksheet_MemoryDrawing::RENDERING_JPEG);
        $objDrawing->setMimeType(PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_DEFAULT);
        $objDrawing->setHeight(105);
        $objDrawing->setCoordinates("J$row");
        $objDrawing->setWorksheet($active_sheet);
//========================== END SUMMARY PROPOSE =============================//
        
        ob_end_clean();
        $filename = "Propose Budget $no_propose - $kode_dept.xls";
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . trim($filename) . '"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->setIncludeCharts(TRUE);
        $objWriter->save('php://output');
        
    }
    
    //---------------------- END OF PROPOSE BUDGET ---------------------------//

}

?>