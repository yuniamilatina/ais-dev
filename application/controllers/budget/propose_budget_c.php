<?php header("Content-type: text/html; charset=iso-8859-1");

class propose_budget_c extends CI_Controller {

    private $layout = '/template/head';
    private $back_to_manage = 'budget/propose_budget_c/index/';

    public function __construct() {
        parent::__construct();
        $this->load->model('budget/propose_budget_m');
        $this->load->model('basis/log_m');
        $this->load->model('basis/role_module_m');
        $this->load->model('portal/news_m');
        $this->load->model('budget/fiscal_m');
        $this->load->model('organization/dept_m');
    }

    //----------------------------// EDIT BY ANP //---------------------------//
    function index($msg = NULL, $fiscal_start = NULL, $year_month = NULL, $kode_dept = NULL) {
        $this->role_module_m->authorization('44');
        
        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>x</button><strong>Approving success </strong> The data is successfully approved </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>x</button><strong>Failed </strong>to approve/reject revision of Master Budget </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>x</button><strong>Rejecting success </strong> The data is successfully rejected </div >";
        } else {
            $msg = "";
        }
        
        if ($fiscal_start == NULL){
            $fiscal_start = $this->fiscal_m->get_default_fiscal_year()->CHR_FISCAL_YEAR_START;
        }
        
        $fiscal_year = $this->fiscal_m->get_selected_fiscal_year($fiscal_start);
        $fiscal_end = $fiscal_year->CHR_FISCAL_YEAR_END;
        
        //$year_month = '201604' + 1;
        if($year_month == NULL){
            $year_month = date("Ym");
        }
        
        $year = substr($year_month,0,4);
        $month = substr($year_month,4,2);
        
        $session = $this->session->all_userdata();
        //FOR --> ADMIN & ADMIN BUDGET
        if ($session['ROLE'] === 2 || $session['ROLE'] === 1) {   
            if($kode_dept == NULL){
                $id_dept = $session['DEPT'];
                $kode_dept = $this->propose_budget_m->get_user_dept($id_dept)->CHR_DEPT;
            }
            
            if($kode_dept == 'MISY'){
                $kode_dept = 'MIS';
            } else if($kode_dept == 'PPIC'){
                $kode_dept = 'PPC';
            } else if($kode_dept == 'QA' || $kode_dept == 'QAS'){
                $kode_dept = 'QCO';  
            } else {
                $kode_dept = trim($kode_dept);
            }
            
            $data['all_propose'] = $this->propose_budget_m->get_all_propose($fiscal_start, $kode_dept, $year, $month);
            
            $contain = 'budget/purposebudget/manage_propose_monthly_budget_v';
            
        //FOR --> MANAGER
        } else if ($session['ROLE'] === 5 || $session['ROLE'] === 39 || $session['ROLE'] === 45 ) {
            $id_dept = $session['DEPT'];
            $kode_dept = $this->propose_budget_m->get_user_dept($id_dept)->CHR_DEPT;
            
            if($session['NPK'] === '0512'){
               $kode_dept = 'KQC'; 
            }
            
            //Mapping dept AIS to BUDGET AII
            if($kode_dept == 'MISY'){
                $kode_dept = 'MIS';
            } else if($kode_dept == 'PPIC'){
                $kode_dept = 'PPC';
            } else if($kode_dept == 'QA' || $kode_dept == 'QAS'){
                $kode_dept = 'QCO';
            } else {
                $kode_dept = trim($kode_dept);
            }
//            print_r($kode_dept);
//            exit();
            //$kode_dept = 'ENG';
            
            $data['all_propose'] = $this->propose_budget_m->get_all_propose($fiscal_start, $kode_dept, $year, $month);
           
            $contain = 'budget/purposebudget/manage_propose_monthly_budget_v';   
        }
                
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(195);
        $data['news'] = $this->news_m->get_news();
        $data['role'] = $session['ROLE'];
        $data['msg'] = $msg;
        
        //--- For list value
        $data['all_dept'] = $this->propose_budget_m->get_all_dept();
        $data['all_fiscal'] = $this->fiscal_m->get_all_fiscal_year();       
        $data['all_budget_type'] = $this->propose_budget_m->get_all_budget_type();
                        
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
//        print_r($year_month);
//        exit();
        if ($fiscal_start == NULL){
            $fiscal_start = $this->fiscal_m->get_default_fiscal_year()->CHR_FISCAL_YEAR_START;
        }
        
        $fiscal_year = $this->fiscal_m->get_selected_fiscal_year($fiscal_start);
        $fiscal_end = $fiscal_year->CHR_FISCAL_YEAR_END;
        
        //$year_month = '201604' + 1;
        $year = substr($year_month,0,4);
        $month = substr($year_month,4,2);
        
//        $data['all_month'] = array(
//                        'MONTH_5' => $fiscal_start . '05',
//                        'MONTH_6' => $fiscal_start . '06',
//                        'MONTH_7' => $fiscal_start . '07',
//                        'MONTH_8' => $fiscal_start . '08',
//                        'MONTH_9' => $fiscal_start . '09',
//                        'MONTH_10' => $fiscal_start . '10',
//                        'MONTH_11' => $fiscal_start . '11',
//                        'MONTH_12' => $fiscal_start . '12',
//                        'MONTH_13' => $fiscal_end . '01',
//                        'MONTH_14' => $fiscal_end . '02',
//                        'MONTH_15' => $fiscal_end . '03',
//                    );
        
        $session = $this->session->all_userdata();
        //FOR --> ADMIN & ADMIN BUDGET
        if ($session['ROLE'] === 2) {            
            
            $contain = 'budget/purposebudget/propose_monthly_budget_v';
            
        //FOR --> MANAGER
        } else if ($session['ROLE'] === 5 || $session['ROLE'] === 1 || $session['ROLE'] === 39 || $session['ROLE'] === 45) {
            $id_dept = $session['DEPT'];
            $kode_dept = $this->propose_budget_m->get_user_dept($id_dept)->CHR_DEPT;
            
            if($session['NPK'] === '0512'){
               $kode_dept = 'KQC'; 
            }
            
            //Mapping dept AIS to BUDGET AII
            if($kode_dept == 'MISY'){
                $kode_dept = 'MIS';
            } else if($kode_dept == 'PPIC'){
                $kode_dept = 'PPC';
            } else if($kode_dept == 'QA' || $kode_dept == 'QAS'){
                $kode_dept = 'QCO';
            } else {
                $kode_dept = trim($kode_dept);
            }
            
            //$kode_dept = 'ENG';
            
            $exist_no_propose =  $this->propose_budget_m->get_exist_no_propose($fiscal_start, $year, $month, $kode_dept);
            if($exist_no_propose == NULL){
                $no_propose = 'PROP/' . trim($kode_dept) . '/' . $year_month . '/0001';
                $get_all_budget = $this->propose_budget_m->get_all_budget($fiscal_start, $kode_dept, $year, $month);
            } else {
                $latest_no = substr($exist_no_propose->CHR_NO_PROPOSE, 16, 4);
                $new_no = sprintf("%04d", $latest_no + 1);
                $no_propose = 'PROP/' . trim($kode_dept) . '/' . $year_month . '/' . $new_no;
                $bgt_type = '';
                $list_exist_no_budget = $this->propose_budget_m->get_exist_no_budget_prop($fiscal_start, $kode_dept, $bgt_type, $year, $month);
                
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
                
                $get_all_budget = $this->propose_budget_m->get_exist_budget($fiscal_start, $kode_dept, $year, $month, $no_budget);
            }
            
            foreach($get_all_budget as $bgt){
                $propose = array(
                            'CHR_NO_PROPOSE' => $no_propose,
                            'CHR_TRANS_DATE' => date('Ymd'),
                            'CHR_DEPT' =>$kode_dept,
                            'CHR_BUDGET_TYPE' => $bgt->CHR_KODE_TYPE_BUDGET,
                            'CHR_NO_BUDGET' => $bgt->CHR_NO_BUDGET,
                            'CHR_BUDGET_DESC' => $bgt->CHR_DESC_BUDGET,
                            'CHR_YEAR_BUDGET' => $bgt->CHR_TAHUN_BUDGET,
                            'CHR_YEAR_ACTUAL' => $year,
                            'CHR_MONTH_ACTUAL' => $month,
                            'CHR_YEAR_PROPOSE' => $year,
                            'CHR_MONTH_PROPOSE' => $month,
                            'MON_PLAN_BLN' => $bgt->TOT_PLAN,
                            'MON_LIMIT_BLN' => $bgt->TOT_LIMIT,
                            'MON_PROPOSE_BLN' => $bgt->TOT_LIMIT
                        );
                $this->propose_budget_m->save_propose_budget($propose);
            }
            
            $data['num_budget'] = count($get_all_budget);
            $data['summary_propose'] = $this->propose_budget_m->get_summary_propose($no_propose);
            $data['propose_capex'] = $this->propose_budget_m->get_propose_capex($no_propose);
            $data['propose_repma'] = $this->propose_budget_m->get_propose_repma($no_propose);
            $data['propose_tooeq'] = $this->propose_budget_m->get_propose_tooeq($no_propose);
            $data['propose_offeq'] = $this->propose_budget_m->get_propose_offeq($no_propose);
            $data['propose_trial'] = $this->propose_budget_m->get_propose_trial($no_propose);
            $data['propose_empwa'] = $this->propose_budget_m->get_propose_empwa($no_propose);
            $data['propose_engfe'] = $this->propose_budget_m->get_propose_engfe($no_propose);
            $data['propose_itexp'] = $this->propose_budget_m->get_propose_itexp($no_propose);
            $data['propose_renta'] = $this->propose_budget_m->get_propose_renta($no_propose);
            $data['propose_rndev'] = $this->propose_budget_m->get_propose_rndev($no_propose);
            $data['propose_donat'] = $this->propose_budget_m->get_propose_donat($no_propose);            
            
            $contain = 'budget/purposebudget/propose_monthly_budget_v';   
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
        $data['sidebar'] = $this->role_module_m->side_bar(195);
        $data['news'] = $this->news_m->get_news();
        $data['role'] = $session['ROLE'];
        $data['msg'] = NULL;
        
        //--- For list value
        $data['all_dept'] = $this->propose_budget_m->get_all_dept();
        $data['list_section'] = $this->propose_budget_m->get_list_section($kode_dept);
        $data['all_fiscal'] = $this->fiscal_m->get_all_fiscal_year();       
        $data['all_budget_type'] = $this->propose_budget_m->get_all_budget_type();
        $data['list_project'] = $this->propose_budget_m->get_list_project();
        $data['list_purpose'] = $this->propose_budget_m->get_list_purpose();
                        
        //--- Value selected
        $data['fiscal_start'] = $fiscal_start;
        $data['fiscal_end'] = $fiscal_end;
        $data['month'] = $month;
        $data['year_month'] = $year_month;
        $data['kode_dept'] = $kode_dept;
        $data['no_propose'] = $no_propose;
        //$switch = $this->propose_budget_m->check_switch($no_propose)->CHR_FLG_SWITCH;
        
        //if(count($switch) == 0){
        //    $data['switch'] = 0;
        //} else {
        //    $data['switch'] = $switch;
        //}
        
        $data['switch'] = 0;
        
        $data['content'] = $contain;
        $data['title'] = 'Propose Monthly Budget';

        $this->load->view($this->layout, $data);
    }
    
    function view_propose_budget($msg = NULL, $no_propose = NULL) {
        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>x</button><strong>Success </strong> Budget is successfully proposed </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>x</button><strong>Failed </strong> Budget failed to propose, please check your data </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>x</button><strong>Success </strong> Budget is successfully added budget to list </div >";
        } elseif ($msg == 4) {
            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>x</button><strong>Failed </strong> Failed add budget to list </div >";
        } elseif ($msg == 5) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>x</button><strong>Success </strong> Budget is successfully updated </div >";
        } else {
            $msg = "";
        }
        
        $this->role_module_m->authorization('44');
        
        $no_propose = str_replace('%3C', '/', $no_propose);
        
        $session = $this->session->all_userdata();
        //FOR --> ADMIN & ADMIN BUDGET
        if ($session['ROLE'] === 2) {            
            
            $contain = 'budget/purposebudget/propose_monthly_budget_v';
            
        //FOR --> MANAGER
        } else if ($session['ROLE'] === 5 || $session['ROLE'] === 1 || $session['ROLE'] === 39 || $session['ROLE'] === 45) {
            $id_dept = $session['DEPT'];
            $kode_dept = $this->propose_budget_m->get_user_dept($id_dept)->CHR_DEPT;
            
            if($session['NPK'] === '0512'){
               $kode_dept = 'KQC'; 
            }
            
            //Mapping dept AIS to BUDGET AII
            if($kode_dept == 'MISY'){
                $kode_dept = 'MIS';
            } else if($kode_dept == 'PPIC'){
                $kode_dept = 'PPC';
            } else if($kode_dept == 'QA' || $kode_dept == 'QC' || $kode_dept == 'QSY' || $kode_dept == 'QAS'){
                $kode_dept = 'QCO';
            } else {
                $kode_dept = trim($kode_dept);
            }
            
            //$kode_dept = 'ENG';
            $propose = $this->propose_budget_m->get_propose($no_propose);
            $fiscal_start = $propose->CHR_YEAR_BUDGET;
            $fiscal_end = $propose->CHR_YEAR_BUDGET + 1;
            $data['year_month'] = $propose->CHR_YEAR_PROPOSE . $propose->CHR_MONTH_PROPOSE;
            $data['month'] = $propose->CHR_MONTH_PROPOSE;
            $data['num_budget'] = 1;
            $data['summary_propose'] = $this->propose_budget_m->get_summary_propose($no_propose);
            
            $data['propose_capex'] = $this->propose_budget_m->get_propose_capex($no_propose);
            $data['propose_repma'] = $this->propose_budget_m->get_propose_repma($no_propose);
            $data['propose_tooeq'] = $this->propose_budget_m->get_propose_tooeq($no_propose);
            $data['propose_offeq'] = $this->propose_budget_m->get_propose_offeq($no_propose);
            $data['propose_trial'] = $this->propose_budget_m->get_propose_trial($no_propose);
            $data['propose_empwa'] = $this->propose_budget_m->get_propose_empwa($no_propose);
            $data['propose_engfe'] = $this->propose_budget_m->get_propose_engfe($no_propose);
            $data['propose_itexp'] = $this->propose_budget_m->get_propose_itexp($no_propose);
            $data['propose_renta'] = $this->propose_budget_m->get_propose_renta($no_propose);
            $data['propose_rndev'] = $this->propose_budget_m->get_propose_rndev($no_propose);
            $data['propose_donat'] = $this->propose_budget_m->get_propose_donat($no_propose);            
            
            $contain = 'budget/purposebudget/propose_monthly_budget_v';   
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
        $data['sidebar'] = $this->role_module_m->side_bar(195);
        $data['news'] = $this->news_m->get_news();
        $data['role'] = $session['ROLE'];
        $data['msg'] = $msg;
        
        //--- For list value
        $data['all_dept'] = $this->propose_budget_m->get_all_dept();
        $data['list_section'] = $this->propose_budget_m->get_list_section($kode_dept);
        $data['all_fiscal'] = $this->fiscal_m->get_all_fiscal_year();       
        $data['all_budget_type'] = $this->propose_budget_m->get_all_budget_type();
        $data['list_project'] = $this->propose_budget_m->get_list_project();
        $data['list_purpose'] = $this->propose_budget_m->get_list_purpose();
                       
        //--- Value selected
        $data['fiscal_start'] = $fiscal_start;
        $data['fiscal_end'] = $fiscal_end;        
        $data['kode_dept'] = $kode_dept;
        $data['no_propose'] = $no_propose;
        $data['switch'] = $this->propose_budget_m->check_switch($no_propose)->CHR_FLG_SWITCH;
                
        $data['content'] = $contain;
        $data['title'] = 'Propose Monthly Budget';

        $this->load->view($this->layout, $data);
    }
    
    function get_list_category() {
        $bgt_type = $this->input->post('type_budget');
        $list_category = $this->propose_budget_m->get_list_category($bgt_type);
        $option = '';
        
        foreach ($list_category as $data){
            $option .= '<option value="' . trim($data->CHR_KODE_SUBCATEGORY_BUDGET) . '">' . strtoupper(trim($data->CHR_KODE_SUBCATEGORY_BUDGET)) . ' - ' . substr($data->CHR_DESC_SUBCATEGORY_BUDGET, 0, 40) . '</option>';
        }
        
        echo $option;
    }
    
    function get_budget_list() {
        $bgt_type = trim($this->input->post('dt_bgt_type'));
        $dept = trim($this->input->post('dt_dept'));
        $year_month = $this->input->post('dt_month');
        $fis_start = $this->input->post('dt_fiscal');
        $year = substr($year_month, 0, 4);
        $month = substr($year_month, 4, 2);
        
        $list_exist_no_budget = $this->propose_budget_m->get_exist_no_budget_prop($fis_start, $dept, $bgt_type, $year, $month);
        
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
        
        $list_budget = $this->propose_budget_m->get_budget_other_month($fis_start, $dept, $bgt_type, $year, $month, $no_budget);
        $table_budget = '';
        $table_budget .= '<table style="font-size:12px;" id="example" class="table table-condensed table-hover display" cellspacing="0" width="100%">';
        $table_budget .=  '<thead>';
        $table_budget .=    '<tr style="font-weight:bold; background-color: #002a80; color: white;">';
        $table_budget .=        '<td align="center">No</td>';
        $table_budget .=        '<td align="center">No Budget</td>';
        $table_budget .=        '<td align="center">Description</td>';
        $table_budget .=        '<td align="center">Budget Plan</td>';
        $table_budget .=        '<td align="center">Budget Limit</td>';
        $table_budget .=        '<td align="center">Realization</td>';
        $table_budget .=        '<td align="center">Saldo</td>';
        $table_budget .=        '<td align="center">Action</td>';
        $table_budget .=    '</tr>'; 
        $table_budget .=  '</thead>';
        
        if(count($list_budget) == 0){
           $table_budget .= '<tbody>';
           $table_budget .=  '<tr style="background-color:whitesmoke;">';
           $table_budget .=    '<td colspan="7"><strong>No Data Available</strong></td>';
           $table_budget .=  '</tr>';
           $table_budget .= '</tbody>';
        } else {
           $i = 1;
           foreach ($list_budget as $data){
                $table_budget .= '<tbody>';
                $table_budget .= '<tr>';
                $table_budget .=    '<td>' . $i . '</td>';
                $table_budget .=    '<td>' . $data->CHR_NO_BUDGET . '</td>';
                $table_budget .=    '<td>' . substr($data->CHR_DESC_BUDGET, 0, 20) . '</td>';
                $table_budget .=    '<td align="right">' . number_format($data->TOT_PLAN,0,',','.') . '</td>';
                $table_budget .=    '<td align="right">' . number_format($data->TOT_LIMIT,0,',','.') . '</td>';
                $table_budget .=    '<td align="right">' . number_format($data->TOT_REAL,0,',','.') . '</td>';
                $table_budget .=    '<td align="right">' . number_format(($data->TOT_LIMIT - $data->TOT_REAL),0,',','.') . '</td>';
                $table_budget .=    '<td align="center"><input type="checkbox" name="res_'. trim($data->CHR_NO_BUDGET) .'" value="1"></td>';
                $table_budget .= '</tr>';
                $table_budget .= '</tbody>';
                $i++;
            } 
        }        
        
        $table_budget .= '</table>';
        
        echo $table_budget;
    }
    
    function add_reschedule_budget(){
        $no_propose = $this->input->post('CHR_NO_PROPOSE_RES');
        
        $dept = $this->input->post('CHR_DEPT_RES');
        $fis_start = $this->input->post('CHR_FIS_START_RES');
        $ym_act = $this->input->post('CHR_MONTH_RES');
        $ym_prop = $this->input->post('CHR_YM_PROPOSE_RES');
        $budget_type = $this->input->post('CHR_BUDGET_TYPE_RES');
        
        $list_exist_no_budget = $this->propose_budget_m->get_exist_no_budget_prop($fis_start, $dept, $bgt_type, $year, $month);
        
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
        
        $budget_other_month = $this->propose_budget_m->get_budget_other_month($fis_start, $dept, $budget_type, substr($ym_act, 0, 4), substr($ym_act, 4, 2), $no_budget);

        foreach($budget_other_month as $data){
            if(isset($_POST["res_".trim($data->CHR_NO_BUDGET)])){
                $prop_budget = array(
                                    'CHR_NO_PROPOSE' => $no_propose,
                                    'CHR_TRANS_DATE' => date('Ymd'),
                                    'CHR_DEPT' => $dept,
                                    'CHR_BUDGET_TYPE' => $budget_type,
                                    'CHR_NO_BUDGET' => $data->CHR_NO_BUDGET,
                                    'CHR_BUDGET_DESC' => $data->CHR_DESC_BUDGET,
                                    'CHR_YEAR_BUDGET' => $fis_start,
                                    'CHR_YEAR_ACTUAL' => substr($ym_act, 0, 4),
                                    'CHR_MONTH_ACTUAL' => substr($ym_act, 4, 2),
                                    'CHR_YEAR_PROPOSE' => substr($ym_prop, 0, 4),
                                    'CHR_MONTH_PROPOSE' => substr($ym_prop, 4, 2),
                                    'MON_PLAN_BLN' => $data->TOT_PLAN,
                                    'MON_LIMIT_BLN' => $data->TOT_LIMIT,
                                    'MON_REAL_BLN' => $data->TOT_REAL,
                                    'MON_PROPOSE_BLN' => $data->TOT_LIMIT,
                                    'INT_QTY' => $data->TOT_QTY,
                                    'CHR_FLG_UNBUDGET' => $data->CHR_FLG_UNBUDGET,
                                    'CHR_FLG_CHANGE_AMOUNT' => $data->CHR_FLG_CHANGE_AMOUNT,
                                    'CHR_FLG_RESCHEDULE' => 1
                                );
                $this->propose_budget_m->insert_reschedule($prop_budget);                
                
            }
        }
        redirect("budget/propose_budget_c/view_propose_budget/3/". str_replace('/','<',$no_propose));
    }
    
    function add_propose_unbudget(){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        $session = $this->session->all_userdata();
                
        $dept = $this->input->post('DEPT_UNB');
        $kode_group = $this->propose_budget_m->get_kode_group($dept)->CHR_KODE_GROUP;
        $sect = $this->input->post('CHR_SECTION_UNB');
        
        $no_propose = $this->input->post('NO_PROPOSE_UNB');
        
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
        
        $get_costcenter = $this->propose_budget_m->get_costcenter($sect);
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
             $this->propose_budget_m->save_master_unbudget($unbudget_cpx, $budget_type);
             
             $prop_unbudget_cpx = array(
                            'CHR_NO_PROPOSE' => $no_propose,
                            'CHR_TRANS_DATE' => date('Ymd'),
                            'CHR_DEPT' => $dept,
                            'CHR_NO_BUDGET' => $budget_no,
                            'CHR_BUDGET_TYPE' => $budget_type,
                            'CHR_YEAR_BUDGET' => $fis_start,
                            'CHR_YEAR_ACTUAL' => substr($ym_prop, 0, 4),
                            'CHR_MONTH_ACTUAL' => substr($ym_prop, 4, 2),
                            'CHR_YEAR_PROPOSE' => substr($ym_prop, 0, 4),
                            'CHR_MONTH_PROPOSE' => substr($ym_prop, 4, 2),                            
                            'MON_PLAN_BLN' => 0,
                            'MON_LIMIT_BLN' => $req_amo_unb,
                            'MON_PROPOSE_BLN' => $req_amo_unb,
                            'INT_QTY' => $req_qty_unb,
                            'CHR_BUDGET_DESC' => $desc,
                            'CHR_NOTES' => $notes,
                            'CHR_FLG_UNBUDGET' => 1                
                );
             $this->propose_budget_m->save_propose_unbudget($prop_unbudget_cpx);
        } else {            
            if(substr($ym_prop, 0, 4) == $fis_start){
                $unb_exp_start = array(
                            'CHR_USER' => $userid,
                            'CHR_TAHUN_BUDGET' => $fis_start,
                            'CHR_TAHUN_ACTUAL' => substr($ym_prop, 0, 4),                    
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
                            'CHR_ALOKASI' => '-',
                            'CHR_FLG_PROJECT' => $status,
                            'CHR_FLG_DELETE' => 0,
                            'CHR_FLG_CANCEL' => 0,
                            'CHR_FLG_IF_SAP' => 0,
                            'CHR_FLG_UNBUDGET' => 1                
                ); 
                $this->propose_budget_m->save_master_unbudget($unb_exp_start, $budget_type);
                
                $unb_exp_end = array(
                            'CHR_USER' => $userid,
                            'CHR_TAHUN_BUDGET' => $fis_start,
                            'CHR_TAHUN_ACTUAL' => substr($ym_prop, 0, 4) + 1,                    
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
                            'CHR_ALOKASI' => '-',
                            'CHR_FLG_DELETE' => 0,
                            'CHR_FLG_CANCEL' => 0,
                            'CHR_FLG_IF_SAP' => 0,
                            'CHR_FLG_UNBUDGET' => 1                
                ); 
                $this->propose_budget_m->save_master_unbudget($unb_exp_end, $budget_type);
            } else {
                $unb_exp_start = array(
                            'CHR_USER' => $userid,
                            'CHR_TAHUN_BUDGET' => $fis_start,
                            'CHR_TAHUN_ACTUAL' => substr($ym_prop, 0, 4)-1,                    
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
                            'CHR_ALOKASI' => '-',
                            'CHR_FLG_DELETE' => 0,
                            'CHR_FLG_CANCEL' => 0,
                            'CHR_FLG_IF_SAP' => 0,
                            'CHR_FLG_UNBUDGET' => 1                
                ); 
                $this->propose_budget_m->save_master_unbudget($unb_exp_start, $budget_type);
                
                $unb_exp_end = array(
                            'CHR_USER' => $userid,
                            'CHR_TAHUN_BUDGET' => $fis_start,
                            'CHR_TAHUN_ACTUAL' => substr($ym_prop, 0, 4),                    
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
                            'CHR_ALOKASI' => '-',
                            'CHR_FLG_DELETE' => 0,
                            'CHR_FLG_CANCEL' => 0,
                            'CHR_FLG_IF_SAP' => 0,
                            'CHR_FLG_UNBUDGET' => 1                
                ); 
                $this->propose_budget_m->save_master_unbudget($unb_exp_end, $budget_type);
            }                        
             $prop_unbudget_exp = array(
                            'CHR_NO_PROPOSE' => $no_propose,
                            'CHR_TRANS_DATE' => date('Ymd'),
                            'CHR_DEPT' => $dept,
                            'CHR_NO_BUDGET' => $budget_no,
                            'CHR_BUDGET_TYPE' => $budget_type,
                            'CHR_YEAR_BUDGET' => $fis_start,
                            'CHR_YEAR_ACTUAL' => substr($ym_prop, 0, 4),
                            'CHR_MONTH_ACTUAL' => substr($ym_prop, 4, 2),
                            'CHR_YEAR_PROPOSE' => substr($ym_prop, 0, 4),
                            'CHR_MONTH_PROPOSE' => substr($ym_prop, 4, 2),
                            'MON_PLAN_BLN' => 0,
                            'MON_LIMIT_BLN' => $req_amo_unb,
                            'MON_PROPOSE_BLN' => $req_amo_unb,
                            'INT_QTY' => $req_qty_unb,
                            'CHR_BUDGET_DESC' => $desc,
                            'CHR_NOTES' => $notes,
                            'CHR_FLG_UNBUDGET' => 1                
                );
            $this->propose_budget_m->save_propose_unbudget($prop_unbudget_exp);
        }
        
        $bgt_aii->trans_complete();
        
        if ($bgt_aii->trans_status() === FALSE)
        {
            $bgt_aii->trans_rollback();
            redirect("budget/propose_budget_c/view_propose_budget/4/". str_replace('/','<',$no_propose));
        }
        else
        {
            $bgt_aii->trans_commit();
            redirect("budget/propose_budget_c/view_propose_budget/3/". str_replace('/','<',$no_propose));
        }
        
    }
    
    function generate_no_budget() {
        $bgt_type = $this->input->post('id_bgt');
        $dept = $this->input->post('id_dept');
        $sect = $this->input->post('id_sect');
        $year = $this->input->post('id_thn');
        
        if($bgt_type != '' && $dept != '' && $sect != '' && $year != '' ){
            $get_unbudget = $this->propose_budget_m->get_exist_unbudget($bgt_type, $year, $dept, $sect);
            $get_prefix = $this->propose_budget_m->get_prefix($bgt_type);
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
        }
        
        $year = substr($year_month,0,4);
        $month = substr($year_month,4,2);
        
        $session = $this->session->all_userdata();
        //FOR --> ADMIN & ADMIN BUDGET
        if ($session['ROLE'] === 2) {            
            
            $contain = 'budget/purposebudget/manage_approval_monthly_budget_v';
            
        //FOR --> BOD
        } else if ($session['ROLE'] === 3) {
            $data['all_dept'] = $this->propose_budget_m->get_all_dept();
            $data['all_propose'] = $this->propose_budget_m->get_all_propose_bod($fiscal_start, $kode_dept, $year, $month);
           
            $contain = 'budget/purposebudget/manage_approval_monthly_budget_v';   
        
        //FOR --> GM    
        } else if ($session['ROLE'] === 4 || $session['ROLE'] === 1 ){
            $id_group = $this->session->userdata('GROUPDEPT');
            if($id_group == '6'){
                $kode_group = '001';
            } else if($id_group == '7') {
                $kode_group = '003';
            } else if($id_group == '10') {
                $kode_group = '004';
            }
            //$kode_group = '003';
            $data['all_dept'] = $this->propose_budget_m->get_group_dept($kode_group);
            
            $data['all_propose'] = $this->propose_budget_m->get_all_propose_gm($fiscal_start, $kode_dept, $year, $month);
           
            $contain = 'budget/purposebudget/manage_approval_monthly_budget_v';
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
        $data['sidebar'] = $this->role_module_m->side_bar(196);
        $data['news'] = $this->news_m->get_news();
        $data['role'] = $session['ROLE'];
        $data['msg'] = $msg;
        
        //--- For list value        
        $data['all_fiscal'] = $this->fiscal_m->get_all_fiscal_year();       
        $data['all_budget_type'] = $this->propose_budget_m->get_all_budget_type();
                        
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
        
        $session = $this->session->all_userdata();
        //FOR --> ADMIN & ADMIN BUDGET
        if ($session['ROLE'] === 2) {            
            
            $contain = 'budget/purposebudget/approval_monthly_budget_v';
            
        //FOR --> BOD
        } else if ($session['ROLE'] === 3) {            
            $propose = $this->propose_budget_m->get_propose($no_propose);
            $fiscal_start = $propose->CHR_YEAR_BUDGET;
            $fiscal_end = $propose->CHR_YEAR_BUDGET + 1;
            $kode_dept = $propose->CHR_DEPT;            
            $data['all_dept'] = $this->propose_budget_m->get_all_dept();        
            
            $data['propose_capex'] = $this->propose_budget_m->get_propose_capex_bod($no_propose);
            $data['propose_repma'] = $this->propose_budget_m->get_propose_repma_bod($no_propose);
            $data['propose_tooeq'] = $this->propose_budget_m->get_propose_tooeq_bod($no_propose);
            $data['propose_offeq'] = $this->propose_budget_m->get_propose_offeq_bod($no_propose);
            $data['propose_trial'] = $this->propose_budget_m->get_propose_trial_bod($no_propose);
            $data['propose_empwa'] = $this->propose_budget_m->get_propose_empwa_bod($no_propose);
            $data['propose_engfe'] = $this->propose_budget_m->get_propose_engfe_bod($no_propose);
            $data['propose_itexp'] = $this->propose_budget_m->get_propose_itexp_bod($no_propose);
            $data['propose_renta'] = $this->propose_budget_m->get_propose_renta_bod($no_propose);
            $data['propose_rndev'] = $this->propose_budget_m->get_propose_rndev_bod($no_propose);
            $data['propose_donat'] = $this->propose_budget_m->get_propose_donat_bod($no_propose);          
                        
            $contain = 'budget/purposebudget/approval_monthly_budget_v';   
        
        //FOR --> GM    
        } else if ($session['ROLE'] === 4 || $session['ROLE'] === 1 ){
            $id_group = $this->session->userdata('GROUPDEPT');
            if($id_group == '6'){
                $kode_group = '001';
            } else if($id_group == '7') {
                $kode_group = '003';
            }
            //$kode_group = '003';
            
            $data['all_dept'] = $this->propose_budget_m->get_group_dept($kode_group);
            $propose = $this->propose_budget_m->get_propose($no_propose);
            $fiscal_start = $propose->CHR_YEAR_BUDGET;
            $fiscal_end = $propose->CHR_YEAR_BUDGET + 1;
            $kode_dept = $propose->CHR_DEPT;
            
            $data['propose_capex'] = $this->propose_budget_m->get_propose_capex_gm($no_propose);
            $data['propose_repma'] = $this->propose_budget_m->get_propose_repma_gm($no_propose);
            $data['propose_tooeq'] = $this->propose_budget_m->get_propose_tooeq_gm($no_propose);
            $data['propose_offeq'] = $this->propose_budget_m->get_propose_offeq_gm($no_propose);
            $data['propose_trial'] = $this->propose_budget_m->get_propose_trial_gm($no_propose);
            $data['propose_empwa'] = $this->propose_budget_m->get_propose_empwa_gm($no_propose);
            $data['propose_engfe'] = $this->propose_budget_m->get_propose_engfe_gm($no_propose);
            $data['propose_itexp'] = $this->propose_budget_m->get_propose_itexp_gm($no_propose);
            $data['propose_renta'] = $this->propose_budget_m->get_propose_renta_gm($no_propose);
            $data['propose_rndev'] = $this->propose_budget_m->get_propose_rndev_gm($no_propose);
            $data['propose_donat'] = $this->propose_budget_m->get_propose_donat_gm($no_propose);   
            
            $contain = 'budget/purposebudget/approval_monthly_budget_v';
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
        $data['sidebar'] = $this->role_module_m->side_bar(196);
        $data['news'] = $this->news_m->get_news();
        $data['role'] = $session['ROLE'];
        $data['msg'] = $msg;
        
        //--- For list value
        $data['list_section'] = $this->propose_budget_m->get_list_section($kode_dept);
        $data['all_fiscal'] = $this->fiscal_m->get_all_fiscal_year();       
        $data['all_budget_type'] = $this->propose_budget_m->get_all_budget_type();        
                       
        //--- Value selected
        $data['fiscal_start'] = $fiscal_start;
        $data['fiscal_end'] = $fiscal_end;
        $data['year_month'] = $propose->CHR_YEAR_PROPOSE . $propose->CHR_MONTH_PROPOSE;
        $data['month'] = $propose->CHR_MONTH_PROPOSE;
        $data['kode_dept'] = $kode_dept;
        $data['no_propose'] = $no_propose;
                
        $data['content'] = $contain;
        $data['title'] = 'Approval Monthly Budget';

        $this->load->view($this->layout, $data);
    }
    
    function save_proposed_budget(){        
        $no_propose = $this->input->post('CHR_NO_PROPOSE');
        $all_budget = $this->propose_budget_m->get_list_budget_proposed($no_propose);
        $sum_all_prop = $this->input->post('summary_all_prop');
        
        if($_POST["save"] == 'save'){
//            print_r('save');
//            exit();
            foreach($all_budget as $bgt){
                if(isset($_POST["check_".trim($bgt->CHR_NO_BUDGET)])){
                    $ym_db = $bgt->CHR_YEAR_ACTUAL . $bgt->CHR_MONTH_ACTUAL;
                    $ym_post = $this->input->post('ym_'.trim($bgt->CHR_NO_BUDGET));
                    $note = $this->input->post('note_'.trim($bgt->CHR_NO_BUDGET));
                    $no_budget = trim($bgt->CHR_NO_BUDGET);
                    if($ym_db == $ym_post){
                        $year = $bgt->CHR_YEAR_ACTUAL;
                        $month = $bgt->CHR_MONTH_ACTUAL;
                        $lim_saldo = $bgt->MON_LIMIT_BLN - $bgt->MON_REAL_BLN;                    
                        $prop_amo = str_replace('.','',$this->input->post('amo_'.$no_budget));
                        $change_amo = 0;
                        if($lim_saldo != $prop_amo){
                            $change_amo = 1;
                        }

                        $proposed = array(
                                        'MON_PROPOSE_BLN' => $prop_amo,
                                        'CHR_FLG_CHANGE_AMOUNT' => $change_amo,
                                        'CHR_NOTES' => $note,
                                        'CHR_FLG_DELETE' => 0
                                    );
                        $this->propose_budget_m->update_proposed_budget($proposed, $no_propose, $no_budget, $year, $month);
                    }                                
                } else {
                    $no_budget = trim($bgt->CHR_NO_BUDGET);
                    $year = $bgt->CHR_YEAR_ACTUAL;
                    $month = $bgt->CHR_MONTH_ACTUAL;
                    $proposed = array(
                                        'CHR_FLG_DELETE' => 1                                    
                                    );
                    $this->propose_budget_m->update_proposed_budget($proposed, $no_propose, $no_budget, $year, $month);
                }
            }
            redirect("budget/propose_budget_c/view_propose_budget/5/". str_replace('/','<',$no_propose));
            
        } else {
            foreach($all_budget as $bgt){
                if(isset($_POST["check_".trim($bgt->CHR_NO_BUDGET)])){
                    $ym_db = $bgt->CHR_YEAR_ACTUAL . $bgt->CHR_MONTH_ACTUAL;
                    $ym_post = $this->input->post('ym_'.trim($bgt->CHR_NO_BUDGET));
                    $note = $this->input->post('note_'.trim($bgt->CHR_NO_BUDGET));
                    $no_budget = trim($bgt->CHR_NO_BUDGET);
                    if($ym_db == $ym_post){
                        $year = $bgt->CHR_YEAR_ACTUAL;
                        $month = $bgt->CHR_MONTH_ACTUAL;
                        $lim_saldo = $bgt->MON_LIMIT_BLN - $bgt->MON_REAL_BLN;                    
                        $prop_amo = str_replace('.','',$this->input->post('amo_'.$no_budget));
                        $change_amo = 0;
                        if($lim_saldo != $prop_amo){
                            $change_amo = 1;
                        }

                        $proposed = array(
                                        'MON_PROPOSE_BLN' => $prop_amo,
                                        'CHR_FLG_CHANGE_AMOUNT' => $change_amo,
                                        'CHR_NOTES' => $note,
                                        'CHR_FLG_PROPOSED' => 1
                                    );
                        $this->propose_budget_m->update_proposed_budget($proposed, $no_propose, $no_budget, $year, $month);
                    }                                
                } else {
                    $no_budget = trim($bgt->CHR_NO_BUDGET);
                    $year = $bgt->CHR_YEAR_ACTUAL;
                    $month = $bgt->CHR_MONTH_ACTUAL;
                    $proposed = array(
                                        'CHR_FLG_PROPOSED' => 2,
                                        'CHR_FLG_DELETE' => 1                                    
                                    );
                    $this->propose_budget_m->update_proposed_budget($proposed, $no_propose, $no_budget, $year, $month);
                }
            }

            if($sum_all_prop <= 0){
                $switch = array(
                    'CHR_FLG_SWITCH' => 3
                );
            } else {
                $switch = array(
                    'CHR_FLG_SWITCH' => 1
                );
            }        

            $this->propose_budget_m->update_switch_propose($switch, $no_propose);
            redirect("budget/propose_budget_c/view_propose_budget/1/". str_replace('/','<',$no_propose));
        }
    }
    
    function approved_propose_budget_gm(){        
        $no_propose = $this->input->post('CHR_NO_PROPOSE');
        $fis_start = $this->input->post('CHR_FIS_START');
        $ym_prop = $this->input->post('CHR_YM_PROPOSE');
        $dept_prop = $this->input->post('CHR_DEPT_PROPOSE');
        $all_budget = $this->propose_budget_m->get_list_budget_proposed_gm($no_propose);
        $sum_all_prop = $this->input->post('summary_all_prop');
                
        foreach($all_budget as $bgt){
            if(isset($_POST["check_".trim($bgt->CHR_NO_BUDGET)])){
                $ym_db = $bgt->CHR_YEAR_ACTUAL . $bgt->CHR_MONTH_ACTUAL;
                $ym_post = $this->input->post('ym_'.trim($bgt->CHR_NO_BUDGET));
                $no_budget = trim($bgt->CHR_NO_BUDGET);
                if($ym_db == $ym_post){
                    $year = $bgt->CHR_YEAR_ACTUAL;
                    $month = $bgt->CHR_MONTH_ACTUAL;
                    $prop_amo = str_replace('.','',$this->input->post('amo_'.$no_budget));
                    $proposed = array(
                                    'CHR_FLG_APPROVE_GM' => 1
                                );
                    $this->propose_budget_m->approved_propose_budget_gm($proposed, $no_propose, $no_budget, $year, $month);
                }                                
            } else {
                $no_budget = trim($bgt->CHR_NO_BUDGET);
                $year = $bgt->CHR_YEAR_ACTUAL;
                $month = $bgt->CHR_MONTH_ACTUAL;
                $note = $this->input->post('note_'.$no_budget);
                
                $proposed = array(
                                    'CHR_FLG_PROPOSED' => 2,
                                    'CHR_FLG_DELETE' => 1,
                                    'CHR_REMARK' => $note
                                );
                $this->propose_budget_m->approved_propose_budget_gm($proposed, $no_propose, $no_budget, $year, $month);
            }
        }
        if($sum_all_prop <= 0){
           $switch = array(
                'CHR_FLG_SWITCH' => 3
            );
        } else {
            $switch = array(
                'CHR_FLG_SWITCH' => 2
            );
        }
        $this->propose_budget_m->update_switch_propose($switch, $no_propose);
        //redirect("budget/propose_budget_c/approval_monthly_budget/1/". str_replace('/','<',$no_propose));
        redirect("budget/propose_budget_c/manage_approval_monthly_budget/1/". $fis_start . "/" . $ym_prop . "/" . $dept_prop);
    }
    
    function approved_propose_budget_bod(){        
        $no_propose = $this->input->post('CHR_NO_PROPOSE');
        $fis_start = $this->input->post('CHR_FIS_START');
        $ym_prop = $this->input->post('CHR_YM_PROPOSE');
        $dept_prop = $this->input->post('CHR_DEPT_PROPOSE');
        $all_budget = $this->propose_budget_m->get_list_budget_proposed_bod($no_propose);
        
        foreach($all_budget as $bgt){
            if(isset($_POST["check_".trim($bgt->CHR_NO_BUDGET)])){
//                print_r('OK');
//                exit();
                $ym_db = $bgt->CHR_YEAR_ACTUAL . $bgt->CHR_MONTH_ACTUAL;
                $ym_post = $this->input->post('ym_'.trim($bgt->CHR_NO_BUDGET));
                $no_budget = trim($bgt->CHR_NO_BUDGET);
                $budget_type = $bgt->CHR_BUDGET_TYPE;
                if($ym_db == $ym_post){
                    $year = $bgt->CHR_YEAR_ACTUAL;
                    $month = $bgt->CHR_MONTH_ACTUAL;
                    $prop_amo = $bgt->MON_PROPOSE_BLN;
                    $prop_qty = $bgt->INT_QTY;
                    $proposed = array(
                                    'CHR_FLG_APPROVE_BOD' => 1,
                                    'CHR_FLG_PROPOSED' => 3
                                    //'CHR_FLG_DELETE' => 1
                                );
                    $this->propose_budget_m->approved_propose_budget_bod($proposed, $no_propose, $no_budget, $year, $month);
                    
                    $year_prop = $bgt->CHR_YEAR_PROPOSE;
                    $month_prop = $bgt->CHR_MONTH_PROPOSE;
                    if($budget_type == 'CAPEX'){
                        if($bgt->CHR_FLG_RESCHEDULE == '1'){
                            $update_master = array(
                                    'CHR_TAHUN_ACTUAL' => $year_prop,
                                    'MON_LIMBLN'.$month => 0,
                                    'MON_LIMBLN'.$month_prop => $prop_amo
                                );
                        } else {
                            $update_master = array(
                                    'CHR_TAHUN_ACTUAL' => $year_prop,
                                    'MON_LIMBLN'.$month_prop => $prop_amo
                                );
                        }
                    } else {
                        if($bgt->CHR_FLG_RESCHEDULE == '1'){
                            $update_master = array(
                                    'CHR_TAHUN_ACTUAL' => $year_prop,
                                    'MON_LIMBLN'.$month => 0,
                                    'MON_LIMBLN'.$month_prop => $prop_amo,
                                    'INT_QTY_LIMBLN'.$month => 0,
                                    'INT_QTY_LIMBLN'.$month_prop => $prop_qty
                                );
                        } else {
                            $update_master = array(
                                    'CHR_TAHUN_ACTUAL' => $year_prop,
                                    'MON_LIMBLN'.$month_prop => $prop_amo,
                                    'INT_QTY_LIMBLN'.$month_prop => $prop_qty
                                );
                        }
                    }                    

                    $update_flag = array(
                                    'CHR_FLG_UNBUDGET' => $bgt->CHR_FLG_UNBUDGET,
                                    'CHR_FLG_RESCHEDULE' => $bgt->CHR_FLG_RESCHEDULE,
                                    'CHR_FLG_CHANGE_AMOUNT' => $bgt->CHR_FLG_CHANGE_AMOUNT
                                );
                    
                    $this->propose_budget_m->update_master_budget($update_master, $no_budget, $budget_type, $year_prop);
                    $this->propose_budget_m->update_flag_master_budget($update_flag, $no_budget, $budget_type);
                }                                
            } else {
//                print_r('NG');
//                exit();
                $no_budget = trim($bgt->CHR_NO_BUDGET);
                $year = $bgt->CHR_YEAR_ACTUAL;
                $month = $bgt->CHR_MONTH_ACTUAL;
                $note = $this->input->post('note_'.$no_budget);
                
                $proposed = array(
                                    'CHR_FLG_PROPOSED' => 2,
                                    'CHR_FLG_DELETE' => 1,
                                    'CHR_REMARK' => $note
                                );
                $this->propose_budget_m->approved_propose_budget_bod($proposed, $no_propose, $no_budget, $year, $month);
                    
            }
        }
        $switch = array(
            'CHR_FLG_SWITCH' => 3
        );
        $this->propose_budget_m->update_switch_propose($switch, $no_propose);
        //redirect("budget/propose_budget_c/approval_monthly_budget/1/". str_replace('/','<',$no_propose));
        redirect("budget/propose_budget_c/manage_approval_monthly_budget/1/". $fis_start . "/" . $ym_prop . "/" . $dept_prop);
    }
    
    function delete_propose_budget($no_propose){
        $no_propose = str_replace('%3C', '/', $no_propose);
        $prop = $this->propose_budget_m->get_propose($no_propose);
        $del_proposed = array(
                                    'CHR_FLG_DELETE_PROP' => 1,
                                    'CHR_FLG_DELETE' => 1
                                );     
        $this->propose_budget_m->delete_propose_budget($del_proposed, $no_propose);
        
        redirect("budget/propose_budget_c/index/4/". $prop->CHR_YEAR_BUDGET . "/" . $prop->CHR_YEAR_PROPOSE.$prop->CHR_MONTH_PROPOSE . "/" . $prop->CHR_DEPT);
    }
    
    function view_detail_budget_per_month($fiscal_start = NULL, $kode_dept = NULL, $bgt_type = NULL){
        $fiscal_end = $fiscal_start + 1;
        
        if($bgt_type == NULL){
            $bgt_type = 'CAPEX';
        }
        
        //Detail budget per month
        $data['detail_budget'] = $this->propose_budget_m->get_budget_detail($fiscal_start, $fiscal_end, $bgt_type, $kode_dept);
        $data['limit_budget'] = $this->propose_budget_m->get_budget_limit($fiscal_start, $fiscal_end, $bgt_type, $kode_dept);
        $data['actual_real'] = $this->propose_budget_m->get_actual_real($fiscal_start, $fiscal_end, $bgt_type, $kode_dept);
//        $data['detail_unbudget'] = $this->new_propose_budget_m->get_unbudget_detail($fiscal_start, $fiscal_end, $bgt_type, $kode_dept);
        $list_actual_gr = array();
            for ($no = 1; $no <= 12; $no++){
                if (($no + 3) <= 12){
                    $start_date = $fiscal_start . sprintf("%02d", $no+3) . '01';
                    $end_date = $fiscal_start . sprintf("%02d", $no+3) . '31';
                    $actual_gr = $this->propose_budget_m->get_actual_gr($start_date, $end_date, $bgt_type, $kode_dept);
                    
                    array_push($list_actual_gr, $actual_gr->TOTAL);                    
                } else {
                    $start_date = $fiscal_end . sprintf("%02d", $no-9) . '01';
                    $end_date = $fiscal_end . sprintf("%02d", $no-9) . '31';
                    $actual_gr = $this->propose_budget_m->get_actual_gr($start_date, $end_date, $bgt_type, $kode_dept);
                   
                    array_push($list_actual_gr, $actual_gr->TOTAL);                    
                }
            }
        $data['actual_gr'] = $list_actual_gr;
        
        $data['all_budget_type'] = $this->propose_budget_m->get_all_budget_type();
        $data['kode_dept'] = $kode_dept;
        $data['bgt_type'] = $bgt_type;
        $data['fiscal_start'] = $fiscal_start;
        $data['fiscal_end'] = $fiscal_end;
        
        $data['title'] = 'Detail Budget per Month';
        $contain = 'budget/purposebudget/detail_usage_budget_v'; 
        $data['content'] = $contain;
        $this->load->view("/template/head_blank", $data);
    }
    
    function export_propose_budget() {        
        $this->load->library('excel');
        
        $no_propose = $this->input->post("CHR_NO_PROPOSE");
        $year_month = $this->input->post("CHR_YEAR_MONTH");
        $dept = $this->input->post("CHR_DEPT");
        
//        $data['propose_capex'] = $this->propose_budget_m->get_propose_capex($no_propose);
//        $data['propose_repma'] = $this->propose_budget_m->get_propose_repma($no_propose);
//        $data['propose_tooeq'] = $this->propose_budget_m->get_propose_tooeq($no_propose);
//        $data['propose_offeq'] = $this->propose_budget_m->get_propose_offeq($no_propose);
//        $data['propose_trial'] = $this->propose_budget_m->get_propose_trial($no_propose);
//        $data['propose_empwa'] = $this->propose_budget_m->get_propose_empwa($no_propose);
//        $data['propose_engfe'] = $this->propose_budget_m->get_propose_engfe($no_propose);
//        $data['propose_itexp'] = $this->propose_budget_m->get_propose_itexp($no_propose);
//        $data['propose_renta'] = $this->propose_budget_m->get_propose_renta($no_propose);
//        $data['propose_rndev'] = $this->propose_budget_m->get_propose_rndev($no_propose);
//        $data['propose_donat'] = $this->propose_budget_m->get_propose_donat($no_propose);
        
        $list_budget = $this->propose_budget_m->get_all_propose_budget($no_propose);

        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

        // Set Properties
        $objPHPExcel->getProperties()->setCreator(trim($this->session->userdata('USERNAME')));
        $objPHPExcel->getProperties()->setLastModifiedBy(trim($this->session->userdata('USERNAME')));
        $objPHPExcel->getProperties()->setTitle("PROPOSED BUDGET");
        $objPHPExcel->getProperties()->setSubject("PROPOSED BUDGET");
        $objPHPExcel->getProperties()->setDescription("PROPOSED BUDGET");
                
        //Header
        $objPHPExcel->getActiveSheet()->setCellValue('A2', 'DEPARTMENT');
        $objPHPExcel->getActiveSheet()->setCellValue('A3', 'PROPOSE NUMBER');
        $objPHPExcel->getActiveSheet()->setCellValue('A4', 'MONTH PROPOSE');
        $objPHPExcel->getActiveSheet()->setCellValue('A6', 'NO');
        $objPHPExcel->getActiveSheet()->setCellValue('B6', 'YEAR BUDGET');
        $objPHPExcel->getActiveSheet()->setCellValue('C6', 'BUDGET TYPE');
        $objPHPExcel->getActiveSheet()->setCellValue('D6', 'NO BUDGET');
        $objPHPExcel->getActiveSheet()->setCellValue('E6', 'DESCRIPTION');
        $objPHPExcel->getActiveSheet()->setCellValue('F6', 'YEAR PLAN');
        $objPHPExcel->getActiveSheet()->setCellValue('G6', 'MONTH PLAN');
        $objPHPExcel->getActiveSheet()->setCellValue('H6', 'AMOUNT PLAN');
        $objPHPExcel->getActiveSheet()->setCellValue('I6', 'AMOUNT LIMIT');
        $objPHPExcel->getActiveSheet()->setCellValue('J6', 'AMOUNT REALIZATION');
        $objPHPExcel->getActiveSheet()->setCellValue('K6', 'AMOUNT PROPOSED');
        $objPHPExcel->getActiveSheet()->setCellValue('L6', 'UNBUDGET');
        $objPHPExcel->getActiveSheet()->setCellValue('M6', 'CHANGE AMOUNT');
        $objPHPExcel->getActiveSheet()->setCellValue('N6', 'RESCHEDULE');
        $objPHPExcel->getActiveSheet()->setCellValue('O6', 'STATUS');
        
        $objPHPExcel->getActiveSheet()->mergeCells('A2:B2');
        $objPHPExcel->getActiveSheet()->mergeCells('A3:B3');
        $objPHPExcel->getActiveSheet()->mergeCells('A4:B4');
        $objPHPExcel->getActiveSheet()->mergeCells('C2:D2');
        $objPHPExcel->getActiveSheet()->mergeCells('C3:D3');
        $objPHPExcel->getActiveSheet()->mergeCells('C4:D4');
        
        $objPHPExcel->getActiveSheet()->getStyle('A2:D4')->getFont()->setBold(true)->setSize(12);
        $objPHPExcel->getActiveSheet()->getStyle('A6:O6')->getFont()->setBold(true)->setSize(12);
        
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(6);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(50);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(18);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(18);
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(18);
        $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(18);
        
        $objPHPExcel->getActiveSheet()->getStyle("A6:O6")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        //Value of All Cells
        $objPHPExcel->getActiveSheet()->setCellValue('C2', ': '. $dept);
        $objPHPExcel->getActiveSheet()->setCellValue('C3', ': '. $no_propose);
        $objPHPExcel->getActiveSheet()->setCellValue('C4', ': '. $year_month);
        
        $i = 7;
        $no = 1;
        foreach($list_budget as $data){
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$i, $no);
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$i, $data->CHR_YEAR_BUDGET);
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$i, $data->CHR_BUDGET_TYPE);
            $objPHPExcel->getActiveSheet()->setCellValue('D'.$i, $data->CHR_NO_BUDGET);
            $objPHPExcel->getActiveSheet()->setCellValue('E'.$i, $data->CHR_BUDGET_DESC);
            $objPHPExcel->getActiveSheet()->setCellValue('F'.$i, $data->CHR_YEAR_ACTUAL);        
            $objPHPExcel->getActiveSheet()->setCellValue('G'.$i, $data->CHR_MONTH_ACTUAL);                
            $objPHPExcel->getActiveSheet()->setCellValue('H'.$i, number_format($data->MON_PLAN_BLN,0,',','.'));        
            $objPHPExcel->getActiveSheet()->setCellValue('I'.$i, number_format($data->MON_LIMIT_BLN,0,',','.'));
            $objPHPExcel->getActiveSheet()->setCellValue('J'.$i, number_format($data->MON_REAL_BLN,0,',','.'));        
            $objPHPExcel->getActiveSheet()->setCellValue('K'.$i, number_format($data->MON_PROPOSE_BLN,0,',','.'));
            
            if ($data->CHR_FLG_UNBUDGET == '1'){
                $unb = 'Yes';
            } else {
                $unb = '-';
            }
            
            $objPHPExcel->getActiveSheet()->setCellValue('L'.$i, $unb);
            
            if ($data->CHR_FLG_CHANGE_AMOUNT == '1'){
                $cha = 'Yes';
            } else {
                $cha = '-';
            }
            
            $objPHPExcel->getActiveSheet()->setCellValue('M'.$i, $cha);
            
            if ($data->CHR_FLG_RESCHEDULE == '1'){
                $res = 'Yes';
            } else {
                $res = '-';
            }
            
            $objPHPExcel->getActiveSheet()->setCellValue('N'.$i, $res);
            
            if ($data->CHR_FLG_PROPOSED == '1'){
                $status = 'Wait Approval';
            } else if ($data->CHR_FLG_PROPOSED == '2') {
                $status = 'Hold';
            } else if ($data->CHR_FLG_PROPOSED == '3') {
                $status = 'Approved';
            } else {
                $status = 'Open';
            }
            
            $objPHPExcel->getActiveSheet()->setCellValue('O'.$i, $status);
            
            $objPHPExcel->getActiveSheet()->getStyle("A".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle("B".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle("C".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle("D".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle("E".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle("F".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle("G".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle("H".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $objPHPExcel->getActiveSheet()->getStyle("I".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $objPHPExcel->getActiveSheet()->getStyle("J".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $objPHPExcel->getActiveSheet()->getStyle("K".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $objPHPExcel->getActiveSheet()->getStyle("L".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle("M".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle("N".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle("O".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            
            $i++;
            $no++;
        }
        
        $x = $i - 1;
        $y = $i + 1;
        $z = $i + 4;
        $objPHPExcel->getActiveSheet()->mergeCells('M'.$y.':O'.$y);
        $objPHPExcel->getActiveSheet()->getStyle('M'.$y.':O'.$y)->getFont()->setBold(true)->setSize(11);
        $objPHPExcel->getActiveSheet()->getStyle("M".$y)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('M'.$y, 'APPROVED');
        
        $objPHPExcel->getActiveSheet()->mergeCells('M'.($y+1).':M'.($y+2));
        $objPHPExcel->getActiveSheet()->mergeCells('N'.($y+1).':N'.($y+2));
        $objPHPExcel->getActiveSheet()->mergeCells('O'.($y+1).':O'.($y+2));
        
        $objPHPExcel->getActiveSheet()->setCellValue('M'.$z, 'DIRECTOR');
        $objPHPExcel->getActiveSheet()->setCellValue('N'.$z, 'GM');
        $objPHPExcel->getActiveSheet()->setCellValue('O'.$z, 'MANAGER');
        $objPHPExcel->getActiveSheet()->getStyle("M".$z.":O".$z)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        $styleArray = array(
            'borders' => array(
                'outline' => array(
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
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                ),
            ),
        );
        
        $objPHPExcel->getActiveSheet()->getStyle("A6:O6")->applyFromArray($styleArray2);
        $objPHPExcel->getActiveSheet()->getStyle("M". $y .":O".$z)->applyFromArray($styleArray3);
        $objPHPExcel->getActiveSheet()->getStyle("A6:O".$x)->applyFromArray($styleArray3);
        
        $filename = "Propose Doc No ". $no_propose ." for " . $kode_dept . " (" . $year_month . ").xls";
        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . trim($filename) . '"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->setIncludeCharts(TRUE);
        $objWriter->save('php://output');
    }
    
    function export_propose_unbudget() {        
        $this->load->library('excel');
        
        $no_propose = $this->input->post("CHR_NO_PROPOSE");
        $year_month = $this->input->post("CHR_YEAR_MONTH");
        $dept = $this->input->post("CHR_DEPT");
        
        $list_budget = $this->propose_budget_m->get_all_propose_budget_unb($no_propose);

        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

        // Set Properties
        $objPHPExcel->getProperties()->setCreator(trim($this->session->userdata('USERNAME')));
        $objPHPExcel->getProperties()->setLastModifiedBy(trim($this->session->userdata('USERNAME')));
        $objPHPExcel->getProperties()->setTitle("PROPOSED UNBUDGET");
        $objPHPExcel->getProperties()->setSubject("PROPOSED UNBUDGET");
        $objPHPExcel->getProperties()->setDescription("PROPOSED UNBUDGET");
                
        //Header
        $objPHPExcel->getActiveSheet()->setCellValue('A2', 'LIST PENGAJUAN UNBUDGET DEPARTMENT '. $dept . ' ' . strtoupper(date("F", mktime(null, null, null, substr($year_month, 4, 2)))) . ' ' . substr($year_month,0,4));
        $objPHPExcel->getActiveSheet()->setCellValue('A4', 'NO');
        $objPHPExcel->getActiveSheet()->setCellValue('B4', 'PROPOSE NUMBER');
        $objPHPExcel->getActiveSheet()->setCellValue('C4', 'BUDGET TYPE');
        $objPHPExcel->getActiveSheet()->setCellValue('D4', 'NO UNBUDGET');
        $objPHPExcel->getActiveSheet()->setCellValue('E4', 'DESCRIPTION');
        $objPHPExcel->getActiveSheet()->setCellValue('F4', 'TIME PROPOSE');
        $objPHPExcel->getActiveSheet()->setCellValue('F5', 'YEAR');
        $objPHPExcel->getActiveSheet()->setCellValue('G5', 'MONTH');
        $objPHPExcel->getActiveSheet()->setCellValue('H4', 'AMOUNT UNBUDGET');
        $objPHPExcel->getActiveSheet()->setCellValue('H5', 'PLAN');
        $objPHPExcel->getActiveSheet()->setCellValue('I5', 'LIMIT (30%)');
        $objPHPExcel->getActiveSheet()->setCellValue('J5', 'REALIZATION');
        $objPHPExcel->getActiveSheet()->setCellValue('K5', 'PROPOSED');
        $objPHPExcel->getActiveSheet()->setCellValue('L4', 'NOTES');
        
        $objPHPExcel->getActiveSheet()->mergeCells('A2:L2');
        $objPHPExcel->getActiveSheet()->mergeCells('A4:A5');
        $objPHPExcel->getActiveSheet()->mergeCells('B4:B5');
        $objPHPExcel->getActiveSheet()->mergeCells('C4:C5');
        $objPHPExcel->getActiveSheet()->mergeCells('D4:D5');
        $objPHPExcel->getActiveSheet()->mergeCells('F4:G4');
        $objPHPExcel->getActiveSheet()->mergeCells('H4:K4');
        $objPHPExcel->getActiveSheet()->mergeCells('L4:L5');
        
        $objPHPExcel->getActiveSheet()->getStyle('A4:L5')->getFont()->setBold(true)->setSize(11);
        $objPHPExcel->getActiveSheet()->getStyle('A2:L2')->getFont()->setBold(true)->setSize(13);
        
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(6);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(22);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(25);
        
        $objPHPExcel->getActiveSheet()->getStyle("A4:L5")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("A4:L5")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("A2")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        $i = 6;
        $no = 1;
        foreach($list_budget as $data){
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$i, $no);
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$i, $no_propose);
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$i, $data->CHR_BUDGET_TYPE);
            $objPHPExcel->getActiveSheet()->setCellValue('D'.$i, $data->CHR_NO_BUDGET);
            $objPHPExcel->getActiveSheet()->setCellValue('E'.$i, $data->CHR_BUDGET_DESC);
            $objPHPExcel->getActiveSheet()->setCellValue('F'.$i, $data->CHR_YEAR_ACTUAL);        
            $objPHPExcel->getActiveSheet()->setCellValue('G'.$i, strtoupper(date("F", mktime(null, null, null, $data->CHR_MONTH_ACTUAL))));                
            $objPHPExcel->getActiveSheet()->setCellValue('H'.$i, 'Rp ' . number_format($data->MON_PLAN_BLN,0,',','.'));        
            $objPHPExcel->getActiveSheet()->setCellValue('I'.$i, 'Rp ' . number_format($data->MON_LIMIT_BLN,0,',','.'));
            $objPHPExcel->getActiveSheet()->setCellValue('J'.$i, 'Rp ' . number_format($data->MON_REAL_BLN,0,',','.'));        
            $objPHPExcel->getActiveSheet()->setCellValue('K'.$i, 'Rp ' . number_format($data->MON_PROPOSE_BLN,0,',','.'));            
            $objPHPExcel->getActiveSheet()->setCellValue('L'.$i, $data->CHR_NOTES);
                        
            $objPHPExcel->getActiveSheet()->getStyle("C".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle("F".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle("G".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle("H".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $objPHPExcel->getActiveSheet()->getStyle("I".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $objPHPExcel->getActiveSheet()->getStyle("J".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $objPHPExcel->getActiveSheet()->getStyle("K".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            
            $objPHPExcel->getActiveSheet()->getStyle("A".$i.":L".$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            
            $objPHPExcel->getActiveSheet()->getStyle("E".$i)->getAlignment()->setWrapText(true);
            $objPHPExcel->getActiveSheet()->getStyle("L".$i)->getAlignment()->setWrapText(true);
            
            $i++;
            $no++;
        }
        
        $x = $i - 1;
        $y = $i + 1;
        $z = $i + 4;
        $objPHPExcel->getActiveSheet()->mergeCells('J'.$y.':L'.$y);
        $objPHPExcel->getActiveSheet()->getStyle('J'.$y.':L'.$y)->getFont()->setBold(true)->setSize(11);
        $objPHPExcel->getActiveSheet()->getStyle("J".$y)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('J'.$y, 'APPROVED');
        
        $objPHPExcel->getActiveSheet()->mergeCells('J'.($y+1).':J'.($y+2));
        $objPHPExcel->getActiveSheet()->mergeCells('K'.($y+1).':K'.($y+2));
        $objPHPExcel->getActiveSheet()->mergeCells('L'.($y+1).':L'.($y+2));
        
        $objPHPExcel->getActiveSheet()->setCellValue('J'.$z, 'DIRECTOR');
        $objPHPExcel->getActiveSheet()->setCellValue('K'.$z, 'GM');
        $objPHPExcel->getActiveSheet()->setCellValue('L'.$z, 'MANAGER');
        $objPHPExcel->getActiveSheet()->getStyle("J".$z.":L".$z)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
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
        
        
        $objPHPExcel->getActiveSheet()->getStyle("A4:L5")->applyFromArray($styleArray2);
        $objPHPExcel->getActiveSheet()->getStyle("A4:L".$x)->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->getStyle("J". $y .":L".$z)->applyFromArray($styleArray);
        
        $filename = "Unbudget Doc No ". $no_propose ." for " . $kode_dept . " (" . $year_month . ").xls";
        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . trim($filename) . '"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->setIncludeCharts(TRUE);
        $objWriter->save('php://output');
    }
    
    function export_only_propose_budget() {        
        $this->load->library('excel');
        
        $no_propose = $this->input->post("CHR_NO_PROPOSE");
        $year_month = $this->input->post("CHR_YEAR_MONTH");
        $dept = $this->input->post("CHR_DEPT");
        
//        $data['propose_capex'] = $this->propose_budget_m->get_propose_capex($no_propose);
//        $data['propose_repma'] = $this->propose_budget_m->get_propose_repma($no_propose);
//        $data['propose_tooeq'] = $this->propose_budget_m->get_propose_tooeq($no_propose);
//        $data['propose_offeq'] = $this->propose_budget_m->get_propose_offeq($no_propose);
//        $data['propose_trial'] = $this->propose_budget_m->get_propose_trial($no_propose);
//        $data['propose_empwa'] = $this->propose_budget_m->get_propose_empwa($no_propose);
//        $data['propose_engfe'] = $this->propose_budget_m->get_propose_engfe($no_propose);
//        $data['propose_itexp'] = $this->propose_budget_m->get_propose_itexp($no_propose);
//        $data['propose_renta'] = $this->propose_budget_m->get_propose_renta($no_propose);
//        $data['propose_rndev'] = $this->propose_budget_m->get_propose_rndev($no_propose);
//        $data['propose_donat'] = $this->propose_budget_m->get_propose_donat($no_propose);
        
        $list_budget = $this->propose_budget_m->get_only_propose_budget($no_propose);

        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

        // Set Properties
        $objPHPExcel->getProperties()->setCreator(trim($this->session->userdata('USERNAME')));
        $objPHPExcel->getProperties()->setLastModifiedBy(trim($this->session->userdata('USERNAME')));
        $objPHPExcel->getProperties()->setTitle("PROPOSED BUDGET");
        $objPHPExcel->getProperties()->setSubject("PROPOSED BUDGET");
        $objPHPExcel->getProperties()->setDescription("PROPOSED BUDGET");
                
        //Header
        $objPHPExcel->getActiveSheet()->setCellValue('A2', 'DEPARTMENT');
        $objPHPExcel->getActiveSheet()->setCellValue('A3', 'PROPOSE NUMBER');
        $objPHPExcel->getActiveSheet()->setCellValue('A4', 'MONTH PROPOSE');
        $objPHPExcel->getActiveSheet()->setCellValue('A6', 'NO');
        $objPHPExcel->getActiveSheet()->setCellValue('B6', 'YEAR BUDGET');
        $objPHPExcel->getActiveSheet()->setCellValue('C6', 'BUDGET TYPE');
        $objPHPExcel->getActiveSheet()->setCellValue('D6', 'NO BUDGET');
        $objPHPExcel->getActiveSheet()->setCellValue('E6', 'DESCRIPTION');
        $objPHPExcel->getActiveSheet()->setCellValue('F6', 'YEAR PLAN');
        $objPHPExcel->getActiveSheet()->setCellValue('G6', 'MONTH PLAN');
        $objPHPExcel->getActiveSheet()->setCellValue('H6', 'AMOUNT PLAN');
        $objPHPExcel->getActiveSheet()->setCellValue('I6', 'AMOUNT LIMIT');
        $objPHPExcel->getActiveSheet()->setCellValue('J6', 'AMOUNT REALIZATION');
        $objPHPExcel->getActiveSheet()->setCellValue('K6', 'AMOUNT PROPOSED');
        $objPHPExcel->getActiveSheet()->setCellValue('L6', 'UNBUDGET');
        $objPHPExcel->getActiveSheet()->setCellValue('M6', 'CHANGE AMOUNT');
        $objPHPExcel->getActiveSheet()->setCellValue('N6', 'RESCHEDULE');
        $objPHPExcel->getActiveSheet()->setCellValue('O6', 'STATUS');
        
        $objPHPExcel->getActiveSheet()->mergeCells('A2:B2');
        $objPHPExcel->getActiveSheet()->mergeCells('A3:B3');
        $objPHPExcel->getActiveSheet()->mergeCells('A4:B4');
        $objPHPExcel->getActiveSheet()->mergeCells('C2:D2');
        $objPHPExcel->getActiveSheet()->mergeCells('C3:D3');
        $objPHPExcel->getActiveSheet()->mergeCells('C4:D4');
        
        $objPHPExcel->getActiveSheet()->getStyle('A2:D4')->getFont()->setBold(true)->setSize(12);
        $objPHPExcel->getActiveSheet()->getStyle('A6:O6')->getFont()->setBold(true)->setSize(12);
        
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(6);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(50);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(18);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(18);
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(18);
        $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(18);
        
        $objPHPExcel->getActiveSheet()->getStyle("A6:O6")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        //Value of All Cells
        $objPHPExcel->getActiveSheet()->setCellValue('C2', ': '. $dept);
        $objPHPExcel->getActiveSheet()->setCellValue('C3', ': '. $no_propose);
        $objPHPExcel->getActiveSheet()->setCellValue('C4', ': '. strtoupper(date("F", mktime(null, null, null, substr($year_month, 4, 2)))). ' ' . substr($year_month,0,4));
        
        $tot_plan = 0;
        $tot_limit = 0;
        $tot_real = 0;
        $tot_prop = 0;
        
        $i = 7;
        $no = 1;
        foreach($list_budget as $data){
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$i, $no);
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$i, $data->CHR_YEAR_BUDGET);
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$i, $data->CHR_BUDGET_TYPE);
            $objPHPExcel->getActiveSheet()->setCellValue('D'.$i, $data->CHR_NO_BUDGET);
            $objPHPExcel->getActiveSheet()->setCellValue('E'.$i, $data->CHR_BUDGET_DESC);
            $objPHPExcel->getActiveSheet()->setCellValue('F'.$i, $data->CHR_YEAR_ACTUAL);        
            $objPHPExcel->getActiveSheet()->setCellValue('G'.$i, $data->CHR_MONTH_ACTUAL);                
            $objPHPExcel->getActiveSheet()->setCellValue('H'.$i, number_format($data->MON_PLAN_BLN,0,',','.'));        
            $objPHPExcel->getActiveSheet()->setCellValue('I'.$i, number_format($data->MON_LIMIT_BLN,0,',','.'));
            $objPHPExcel->getActiveSheet()->setCellValue('J'.$i, number_format($data->MON_REAL_BLN,0,',','.'));        
            $objPHPExcel->getActiveSheet()->setCellValue('K'.$i, number_format($data->MON_PROPOSE_BLN,0,',','.'));
            
            $tot_plan = $tot_plan + $data->MON_PLAN_BLN;
            $tot_limit = $tot_limit + $data->MON_LIMIT_BLN;
            $tot_real = $tot_real + $data->MON_REAL_BLN;
            $tot_prop = $tot_prop + $data->MON_PROPOSE_BLN;
            
            if ($data->CHR_FLG_UNBUDGET == '1'){
                $unb = 'Yes';
            } else {
                $unb = '-';
            }
            
            $objPHPExcel->getActiveSheet()->setCellValue('L'.$i, $unb);
            
            if ($data->CHR_FLG_CHANGE_AMOUNT == '1'){
                $cha = 'Yes';
            } else {
                $cha = '-';
            }
            
            $objPHPExcel->getActiveSheet()->setCellValue('M'.$i, $cha);
            
            if ($data->CHR_FLG_RESCHEDULE == '1'){
                $res = 'Yes';
            } else {
                $res = '-';
            }
            
            $objPHPExcel->getActiveSheet()->setCellValue('N'.$i, $res);
            
            if ($data->CHR_FLG_PROPOSED == '1'){
                $status = 'Wait Approval';
            } else if ($data->CHR_FLG_PROPOSED == '2') {
                $status = 'Hold';
            } else if ($data->CHR_FLG_PROPOSED == '3') {
                $status = 'Approved';
            } else {
                $status = 'Open';
            }
            
            $objPHPExcel->getActiveSheet()->setCellValue('O'.$i, $status);
            
            $objPHPExcel->getActiveSheet()->getStyle("A".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle("B".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle("C".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle("D".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle("E".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle("F".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle("G".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle("H".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $objPHPExcel->getActiveSheet()->getStyle("I".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $objPHPExcel->getActiveSheet()->getStyle("J".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $objPHPExcel->getActiveSheet()->getStyle("K".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $objPHPExcel->getActiveSheet()->getStyle("L".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle("M".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle("N".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle("O".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            
            $i++;
            $no++;
        }
        
        $x = $i - 1;
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$i, "TOTAL"); 
        $objPHPExcel->getActiveSheet()->setCellValue('H'.$i, number_format($tot_plan,0,',','.'));        
        $objPHPExcel->getActiveSheet()->setCellValue('I'.$i, number_format($tot_limit,0,',','.'));
        $objPHPExcel->getActiveSheet()->setCellValue('J'.$i, number_format($tot_real,0,',','.'));        
        $objPHPExcel->getActiveSheet()->setCellValue('K'.$i, number_format($tot_prop,0,',','.'));
        
        $objPHPExcel->getActiveSheet()->mergeCells('A'.$i.':G'.$i);
        $objPHPExcel->getActiveSheet()->mergeCells('L'.$i.':O'.$i);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$i.':O'.$i)->getFont()->setBold(true)->setSize(11);
        $objPHPExcel->getActiveSheet()->getStyle("A".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("H".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $objPHPExcel->getActiveSheet()->getStyle("I".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $objPHPExcel->getActiveSheet()->getStyle("J".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $objPHPExcel->getActiveSheet()->getStyle("K".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $objPHPExcel->getActiveSheet()->getStyle("A".$i.":O".$i)->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('#DDDDDD');
        
        
        $y = $i + 2;
        $z = $i + 5;
        $objPHPExcel->getActiveSheet()->mergeCells('M'.$y.':O'.$y);
        $objPHPExcel->getActiveSheet()->getStyle('M'.$y.':O'.$y)->getFont()->setBold(true)->setSize(11);
        $objPHPExcel->getActiveSheet()->getStyle("M".$y)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('M'.$y, 'APPROVED');
        
        $objPHPExcel->getActiveSheet()->mergeCells('M'.($y+1).':M'.($y+2));
        $objPHPExcel->getActiveSheet()->mergeCells('N'.($y+1).':N'.($y+2));
        $objPHPExcel->getActiveSheet()->mergeCells('O'.($y+1).':O'.($y+2));
        
        $objPHPExcel->getActiveSheet()->setCellValue('M'.$z, 'DIRECTOR');
        $objPHPExcel->getActiveSheet()->setCellValue('N'.$z, 'GM');
        $objPHPExcel->getActiveSheet()->setCellValue('O'.$z, 'MANAGER');
        $objPHPExcel->getActiveSheet()->getStyle("M".$z.":O".$z)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        $styleArray = array(
            'borders' => array(
                'outline' => array(
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
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                ),
            ),
        );
        
        $objPHPExcel->getActiveSheet()->getStyle("A6:O6")->applyFromArray($styleArray2);
        $objPHPExcel->getActiveSheet()->getStyle("M". $y .":O".$z)->applyFromArray($styleArray3);
        $objPHPExcel->getActiveSheet()->getStyle("A6:O".$i)->applyFromArray($styleArray3);
        
        $filename = "Propose Doc No ". $no_propose ." for " . $kode_dept . " (" . $year_month . ").xls";
        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . trim($filename) . '"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->setIncludeCharts(TRUE);
        $objWriter->save('php://output');
    }
    
    //---------------------- END OF PROPOSE BUDGET ---------------------------//

    //----------------------------// EDIT BY ANU - BACK TO OLD LOGIC REVISION - 20220214 //---------------------------//
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
                $id_dept = $this->session->userdata('DEPT');
                $kd_dept =  $id_dept;
                $dept = $this->propose_budget_m->get_user_dept($id_dept)->CHR_DEPT;
            } else {
                $dept = $this->dept_m->get_name_dept($kd_dept);
            }     
            
            //Mapping Dept from AIS to BUDGET
            // if($dept == 'MISY'){
            //     $dept = 'MIS';
            // } else if($dept == 'PPIC'){
            //     $dept = 'PPC';
            // } else if($dept == 'QUA'){
            //     $dept = 'QAS';
            // } else {
            //     $dept = trim($dept);
            // }
                    
            $list_master_budget = $this->propose_budget_m->get_list_master_budget($fiscal_start, $fiscal_end, $budget_type, $dept);
           
            $contain = 'budget/propose_budget/propose_budget_revision_v';
            
        //FOR --> MAN
        } else if ($session['ROLE'] === 5) {
            $kd_dept = $this->session->userdata('DEPT');
            $dept = $this->dept_m->get_name_dept($kd_dept);
            
            //Mapping Dept from AIS to BUDGET
            // if($dept == 'MISY'){
            //     $dept = 'MIS';
            // } else if($dept == 'PPIC'){
            //     $dept = 'PPC';
            // } else if($dept == 'QUA'){
            //     $dept = 'QAS';
            // } else {
            //     $dept = trim($dept);
            // }
            
            $list_master_budget = $this->propose_budget_m->get_list_master_budget($fiscal_start, $fiscal_end, $budget_type, $dept);
                
            $contain = 'budget/propose_budget/propose_budget_revision_v';
        
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
        $data['all_bgt_type'] = $this->propose_budget_m->get_all_budget_type();        
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
        
        $get_data = $this->propose_budget_m->get_detail_budget_by_no($fiscal_start, $fiscal_end, $budget_type, $no_budget);
        
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
            $curr_detail_budget = $this->propose_budget_m->get_curr_detail_budget($fiscal_start, $fiscal_end, $budget_type, $no_budget);
            
            $contain = 'budget/propose_budget/edit_propose_budget_revision_v';
            
        //FOR --> GM
        } else if ($session['ROLE'] === 4) {
                
            $contain = 'budget/propose_budget/edit_propose_budget_revision_v';
        
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
        $fiscal_start = '2021';
        $fiscal_year = $this->fiscal_m->get_selected_fiscal_year($fiscal_start);
        $fiscal_end = $fiscal_year->CHR_FISCAL_YEAR_END;        
        
        $session = $this->session->all_userdata();
        //FOR --> ADMIN & ADMIN BUDGET
        if ($session['ROLE'] === 2 || $session['ROLE'] === 1 ) {
            $role = $session['ROLE'];
            $kode_group = '';
            $dept = '';
            $get_list_dept = $this->propose_budget_m->get_list_dept($role, $kode_group, $dept);
            
            $contain = 'budget/propose_budget/propose_unbudget_v';
            
        //FOR --> GM
        } else if ($session['ROLE'] === 4) {
            $role = $session['ROLE'];
            
            if($session['GROUPDEPT'] == '6'){
                $kode_group = '001';
            } else if($session['GROUPDEPT'] == '7'){
                $kode_group = '003';
            }
            
            $dept = '';
            $get_list_dept = $this->propose_budget_m->get_list_dept($role, $kode_group, $dept);
            
            $contain = 'budget/propose_budget/propose_unbudget_v';
        
        //FOR --> MANAGER
        } else if ($session['ROLE'] === 5) {
            $role = $session['ROLE'];            
            $kode_dept = $session['DEPT'];                       
            $get_dept = $this->propose_budget_m->get_dept($kode_dept);
            
            if($get_dept->CHR_DEPT == 'MISY'){
                $dept = 'MIS';
            } else if ($get_dept->CHR_DEPT == 'PPIC'){
                $dept = 'PPC';
            } else {
                $dept = $get_dept->CHR_DEPT;
            }
            
            $get_list_dept = $this->propose_budget_m->get_list_dept($role, $kode_group, $dept);
            $kode_group = $this->propose_budget_m->get_kode_group($dept)->CHR_KODE_GROUP; 
            
            $contain = 'budget/propose_budget/propose_unbudget_v';
        
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
        $data['all_bgt_type'] = $this->propose_budget_m->get_all_budget_type();
        $data['list_project'] = $this->propose_budget_m->get_list_project();
        $data['list_purpose'] = $this->propose_budget_m->get_list_purpose();        
                
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
        
        $get_no_revisi = $this->propose_budget_m->get_no_revisi($budget_no);
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
                            'CHR_FLG_NOTES' => $notes,
                            'CHR_CREATED_DATE' => $trans_date,
                            'CHR_CREATED_TIME' => date("His"),
                            'CHR_FLG_RESCHEDULE' => $schedule
                        );
            $this->propose_budget_m->save_revision_budget($capex); 

            $data = array(
                            'CHR_FLG_RESCHEDULE' => $schedule,
                            'CHR_FLG_CHANGE_AMOUNT' => $change_amo,                    
                            'CHR_FLG_APPROVAL_PROCESS' => 1
                        );
            $this->propose_budget_m->update_master_budget_new($data, $budget_type, $budget_no);
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
            $this->propose_budget_m->save_revision_budget($expense_start);
            
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
            $this->propose_budget_m->save_revision_budget($expense_end);
            
            $data = array(
                            'CHR_FLG_RESCHEDULE' => $schedule,
                            'CHR_FLG_CHANGE_AMOUNT' => $change_amo,                    
                            'CHR_FLG_APPROVAL_PROCESS' => 1
                        );
            $this->propose_budget_m->update_master_budget_new($data, $budget_type, $budget_no);
        }       
               
        $bgt_aii->trans_complete();
        
        if ($bgt_aii->trans_status() === FALSE)
        {
            $bgt_aii->trans_rollback();
            redirect("budget/propose_budget_c/propose_budget_revision/2/".$fiscal_start."/".$budget_type);
        }
        else
        {
            $bgt_aii->trans_commit();
            redirect("budget/propose_budget_c/propose_budget_revision/1/".$fiscal_start."/".$budget_type);
        }
        
        // print_r($year_act);
        // exit();
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

    //----------------------------// END EDIT BY ANU - BACK TO OLD LOGIC REVISION - 20220214 //---------------------------//

}

?>