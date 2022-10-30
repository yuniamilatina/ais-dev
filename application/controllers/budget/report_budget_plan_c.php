
<?php

class report_budget_plan_c extends CI_Controller {

    private $layout = '/template/head';
    private $layout_blank = '/template/head_blank';

    public function __construct() {
        parent::__construct();
        $this->load->model('basis/log_m');
        $this->load->model('basis/role_module_m');
        $this->load->model('budget/fiscal_m');
        $this->load->model('budget/budgetgroup_m');
        $this->load->model('budget/budgetsubgroup_m');
        $this->load->model('budget/budgettype_m');
        $this->load->model('budget/budgetcategory_m');
        $this->load->model('budget/budgetsubcategory_m');
        $this->load->model('budget/budget_expense_m');
        $this->load->model('budget/purposebudget_m');
        $this->load->model('budget/report_budget_plan_m');
        $this->load->model('budget/budget_capex_m');
        $this->load->model('portal/news_m');
        $this->load->model('organization/dept_m');
        $this->load->model('organization/section_m');
        $this->load->model('organization/groupdept_m');
    }
    
    function report_summary_company($INT_ID_FISCAL_YEAR = null, $INT_ID_BUDGET_GROUP = null){
        $data['INT_ID_FISCAL_YEAR'] = $INT_ID_FISCAL_YEAR;
        $data['INT_ID_BUDGET_GROUP'] = $INT_ID_BUDGET_GROUP;
        
        if ($INT_ID_FISCAL_YEAR == null){
            $data['url_page'] = null;
        } else {
            $data['url_page'] = site_url("budget/report_budget_plan_c/refresh_summary_table_page/$INT_ID_FISCAL_YEAR/$INT_ID_BUDGET_GROUP");
        }
        
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(221);
        $data['news'] = $this->news_m->get_news();
        $data['data_fiscal'] = $this->fiscal_m->get_all_fiscal();
        $data['all_group'] = $this->budgetgroup_m->get_budgetgroup();

        $data['title'] = 'Report Summary Company';
        $data['content'] = 'budget/report_budget/report_summary_company_v';
        
        $session = $this->session->all_userdata();
        $data['role'] = $session['ROLE'];

        $this->load->view($this->layout, $data);
    }
    
    function refresh_summary_table() {
        $INT_ID_FISCAL_YEAR = $this->input->post("INT_ID_FISCAL_YEAR");
        $INT_ID_BUDGET_GROUP = $this->input->post("INT_ID_BUDGET_GROUP");
        
        $url_iframe = site_url("budget/report_budget_plan_c/refresh_summary_table_page/$INT_ID_FISCAL_YEAR/$INT_ID_BUDGET_GROUP");
        if($INT_ID_BUDGET_GROUP == '2'){
            $url_export_excel = site_url("budget/report_budget_plan_c/download_summary_exp_company/$INT_ID_FISCAL_YEAR");
            $url_export_excel_dept = site_url("budget/report_budget_plan_c/download_expense_per_dept/$INT_ID_FISCAL_YEAR");
            $url_export_excel_group = site_url("budget/report_budget_plan_c/download_expense_per_group/$INT_ID_FISCAL_YEAR");
        } else if($INT_ID_BUDGET_GROUP == '1'){
            $url_export_excel = site_url("budget/report_budget_plan_c/download_summary_company/$INT_ID_FISCAL_YEAR/$INT_ID_BUDGET_GROUP");
            //$url_export_excel_dept = site_url("budget/report_budget_plan_c/download_summary_company_capex/$INT_ID_FISCAL_YEAR");
            $url_export_excel_dept = site_url("budget/report_budget_plan_c/download_summary_company_capex_new/$INT_ID_FISCAL_YEAR");
            $url_export_excel_group = '';
        } else {
            $url_export_excel = site_url("budget/report_budget_plan_c/download_summary_company/$INT_ID_FISCAL_YEAR/$INT_ID_BUDGET_GROUP");
            $url_export_excel_dept = '';
            $url_export_excel_group = '';
        }        

        $data = array(
            'url_iframe' => $url_iframe,
            'url_export_excel' => $url_export_excel,
            'url_export_excel_dept' => $url_export_excel_dept,
            'url_export_excel_group' => $url_export_excel_group
        );

//====== Either you can print value or you can send value to database
        echo json_encode($data);
    }

    function refresh_summary_table_page($INT_ID_FISCAL_YEAR = null, $INT_ID_BUDGET_GROUP = null) {
        $user_session = $this->session->all_userdata();
        $role = $user_session['ROLE'];

        $data['INT_ID_FISCAL_YEAR'] = $INT_ID_FISCAL_YEAR;
        $data['INT_ID_BUDGET_GROUP'] = $INT_ID_BUDGET_GROUP;
        
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(221);
        $data['news'] = $this->news_m->get_news();
        
        if ($INT_ID_BUDGET_GROUP == '1'){
//            if($role == 2){
//                $data['summary_company'] = $this->report_budget_plan_m->get_summary_capex_company_cpl($INT_ID_FISCAL_YEAR);
//                $data['tot_summary_company'] = $this->report_budget_plan_m->tot_summary_capex_company_cpl($INT_ID_FISCAL_YEAR);
//            } else {
                $data['summary_company'] = $this->report_budget_plan_m->get_summary_capex_company($INT_ID_FISCAL_YEAR);
                $data['tot_summary_company'] = $this->report_budget_plan_m->tot_summary_capex_company($INT_ID_FISCAL_YEAR);
//            }            
            $data['content'] = 'budget/report_budget/refresh_report_summary_company_v';
        } else if ($INT_ID_BUDGET_GROUP == '2'){
//            if($role == 2){
//                $data['summary_foh'] = $this->report_budget_plan_m->get_summary_expense_foh_cpl($INT_ID_FISCAL_YEAR);
//                $data['summary_foh_total'] = $this->report_budget_plan_m->get_summary_expense_foh_total_cpl($INT_ID_FISCAL_YEAR);
//                $data['summary_opx'] = $this->report_budget_plan_m->get_summary_expense_opx_cpl($INT_ID_FISCAL_YEAR);
//                $data['summary_opx_total'] = $this->report_budget_plan_m->get_summary_expense_opx_total_cpl($INT_ID_FISCAL_YEAR);
//            } else {
                $data['summary_foh'] = $this->report_budget_plan_m->get_summary_expense_foh($INT_ID_FISCAL_YEAR);
                $data['summary_foh_total'] = $this->report_budget_plan_m->get_summary_expense_foh_total($INT_ID_FISCAL_YEAR);
                $data['summary_opx'] = $this->report_budget_plan_m->get_summary_expense_opx($INT_ID_FISCAL_YEAR);
                $data['summary_opx_total'] = $this->report_budget_plan_m->get_summary_expense_opx_total($INT_ID_FISCAL_YEAR); 
//            }            
            $data['content'] = 'budget/report_budget/refresh_report_summary_exp_company_v';
        } else if ($INT_ID_BUDGET_GROUP == '3'){
            $data['summary_company'] = $this->report_budget_plan_m->get_summary_sales_company($INT_ID_FISCAL_YEAR);
            $data['tot_summary_company'] = $this->report_budget_plan_m->tot_summary_sales_company($INT_ID_FISCAL_YEAR);
            $data['content'] = 'budget/report_budget/refresh_report_summary_company_v';
        } else if ($INT_ID_BUDGET_GROUP == '4') {
            $data['summary_company'] = $this->report_budget_plan_m->get_summary_dimat_company($INT_ID_FISCAL_YEAR);
            $data['tot_summary_company'] = $this->report_budget_plan_m->tot_summary_dimat_company($INT_ID_FISCAL_YEAR);
            $data['content'] = 'budget/report_budget/refresh_report_summary_company_v';
        } else if ($INT_ID_BUDGET_GROUP == '5') {
            $data['summary_company'] = $this->report_budget_plan_m->get_summary_nopin_company($INT_ID_FISCAL_YEAR);
            $data['tot_summary_company'] = $this->report_budget_plan_m->tot_summary_nopin_company($INT_ID_FISCAL_YEAR);
            $data['content'] = 'budget/report_budget/refresh_report_summary_company_v';
        } else {
            $data['summary_company'] = $this->report_budget_plan_m->get_summary_tax_company($INT_ID_FISCAL_YEAR);
            $data['tot_summary_company'] = $this->report_budget_plan_m->tot_summary_tax_company($INT_ID_FISCAL_YEAR);
            $data['content'] = 'budget/report_budget/refresh_report_summary_company_v';
        }

        $data['title'] = 'Report Summary Budget Company'; 
        
        $this->load->view($this->layout_blank, $data);
    }
    
    function report_profit_and_loss($INT_ID_FISCAL_YEAR = null){
        $data['INT_ID_FISCAL_YEAR'] = $INT_ID_FISCAL_YEAR;
        
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(219);
        $data['news'] = $this->news_m->get_news();
        $data['data_fiscal'] = $this->fiscal_m->get_all_fiscal();

        $data['title'] = 'Report Profit and Loss';
        $data['content'] = 'budget/report_budget/report_profit_and_loss_v';
        
        $session = $this->session->all_userdata();
        $data['role'] = $session['ROLE'];

        $this->load->view($this->layout, $data);
    }
    
    function refresh_table() {
        $INT_ID_FISCAL_YEAR = $this->input->post("INT_ID_FISCAL_YEAR");
        $REPORT_TYPE = $this->input->post("REPORT_TYPE");
        
        $url_iframe = site_url("budget/report_budget_plan_c/refresh_table_page/$INT_ID_FISCAL_YEAR/$REPORT_TYPE");
        if($REPORT_TYPE == 'FOH'){
            $url_export_excel = site_url("budget/report_budget_plan_c/download_format_foh/$INT_ID_FISCAL_YEAR");
        } else {
            $url_export_excel = site_url("budget/report_budget_plan_c/download_format_a3/$INT_ID_FISCAL_YEAR");
        }        

        $data = array(
            'url_iframe' => $url_iframe,
            'url_export_excel' => $url_export_excel
        );

//====== Either you can print value or you can send value to database
        echo json_encode($data);
    }

    function refresh_table_page($INT_ID_FISCAL_YEAR = null, $REPORT_TYPE = null) {
        $user_session = $this->session->all_userdata();

        $data['INT_ID_FISCAL_YEAR'] = $INT_ID_FISCAL_YEAR;
        $data['REPORT_TYPE'] = $REPORT_TYPE;
        
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(219);
        $data['news'] = $this->news_m->get_news();
        
        $data['tot_sales_aii'] = $this->report_budget_plan_m->tot_sales_aii($INT_ID_FISCAL_YEAR);
        $data['tot_dimat_aii'] = $this->report_budget_plan_m->tot_dimat_aii($INT_ID_FISCAL_YEAR);
        $data['tot_direct_labor'] = $this->report_budget_plan_m->tot_direct_labor($INT_ID_FISCAL_YEAR);
        $data['tot_foh'] = $this->report_budget_plan_m->tot_foh($INT_ID_FISCAL_YEAR);
        $data['tot_opx'] = $this->report_budget_plan_m->tot_opx($INT_ID_FISCAL_YEAR);
        $data['tot_other_income'] = $this->report_budget_plan_m->tot_other_income($INT_ID_FISCAL_YEAR);
        $data['tot_opin_tooling_aii'] = $this->report_budget_plan_m->tot_opin_tooling_aii($INT_ID_FISCAL_YEAR);
        $data['tot_opin_passthru_aiia'] = $this->report_budget_plan_m->tot_opin_passthru_aiia($INT_ID_FISCAL_YEAR);
        $data['tot_opin_tooling_aiia'] = $this->report_budget_plan_m->tot_opin_tooling_aiia($INT_ID_FISCAL_YEAR);
        $data['tot_nopin'] = $this->report_budget_plan_m->tot_nopin($INT_ID_FISCAL_YEAR);
        $data['tot_tax'] = $this->report_budget_plan_m->tot_tax($INT_ID_FISCAL_YEAR);
        $data['tot_sub_material'] = $this->report_budget_plan_m->tot_sub_material($INT_ID_FISCAL_YEAR);
        $data['tot_other_variable'] = $this->report_budget_plan_m->tot_other_variable($INT_ID_FISCAL_YEAR);
        $data['tot_fixed_cost'] = $this->report_budget_plan_m->tot_fixed_cost($INT_ID_FISCAL_YEAR);
        $data['tot_sga_cost'] = $this->report_budget_plan_m->tot_sga_cost($INT_ID_FISCAL_YEAR);

        $data['title'] = 'Report Budget Profit and Loss';
        
        if($REPORT_TYPE == 'FOH'){
            $data['content'] = 'budget/report_budget/refresh_report_profit_and_loss_v';
        } else {
            $data['content'] = 'budget/report_budget/refresh_report_profit_and_loss_a3_v';
        }
        
        
        $this->load->view($this->layout_blank, $data);
    }
    
    function download_format_foh($INT_ID_FISCAL_YEAR = null) {   
        $this->load->library('excel');
        $objReader = PHPExcel_IOFactory::createReader('Excel5');
        
//====== Create new PHPExcel object
        $objPHPExcel = $objReader->load("assets/template/budget/report/Template_Report_Profit_Loss.xls");
     
        $objPHPExcel->getActiveSheet()->setCellValue("B3", "PROFIT/LOSS MASTER BUDGET TAHUN : " . $INT_ID_FISCAL_YEAR . " - BY CATEGORY FOH/OPEX");
        $CHR_BUDGET_CATEGORY = "";
        
//========================== GET SALES PRODUCT AII ===========================//
        $row = 7;
        $CHR_BUDGET_CATEGORY = 'SAL3001';
        $sales = $this->report_budget_plan_m->get_sales_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
        if($sales <> null){  
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $sales->MON_AMT_BLN04);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $sales->MON_AMT_BLN05);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $sales->MON_AMT_BLN06);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $sales->MON_AMT_BLN07);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $sales->MON_AMT_BLN08);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", $sales->MON_AMT_BLN09);
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $sales->MON_AMT_BLN10);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", $sales->MON_AMT_BLN11);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $sales->MON_AMT_BLN12);
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $sales->MON_AMT_BLN01);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $sales->MON_AMT_BLN02);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $sales->MON_AMT_BLN03);
            //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $sales->MON_AMT_SUM);
        }        
        
//=========================== GET DIRECT MATERIAL ============================//
        $row = 9;
        $CHR_BUDGET_CATEGORY = 'DMA4001';
        $dimat = $this->report_budget_plan_m->get_dimat_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
        if($dimat <> null){           
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $dimat->MON_AMT_BLN04);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $dimat->MON_AMT_BLN05);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $dimat->MON_AMT_BLN06);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $dimat->MON_AMT_BLN07);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $dimat->MON_AMT_BLN08);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", $dimat->MON_AMT_BLN09);
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $dimat->MON_AMT_BLN10);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", $dimat->MON_AMT_BLN11);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $dimat->MON_AMT_BLN12);
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $dimat->MON_AMT_BLN01);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $dimat->MON_AMT_BLN02);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $dimat->MON_AMT_BLN03);
            //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $dimat->MON_AMT_SUM);
        }
        
        $row = 10;
        $CHR_BUDGET_CATEGORY = 'DMA4002';
        $dimat = $this->report_budget_plan_m->get_dimat_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
        if($dimat <> null){           
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $dimat->MON_AMT_BLN04);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $dimat->MON_AMT_BLN05);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $dimat->MON_AMT_BLN06);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $dimat->MON_AMT_BLN07);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $dimat->MON_AMT_BLN08);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", $dimat->MON_AMT_BLN09);
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $dimat->MON_AMT_BLN10);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", $dimat->MON_AMT_BLN11);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $dimat->MON_AMT_BLN12);
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $dimat->MON_AMT_BLN01);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $dimat->MON_AMT_BLN02);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $dimat->MON_AMT_BLN03);
            //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $dimat->MON_AMT_SUM);
        }
        
        $row = 11;
        $CHR_BUDGET_CATEGORY = 'DMA4003';
        $dimat = $this->report_budget_plan_m->get_dimat_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
        if($dimat <> null){           
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $dimat->MON_AMT_BLN04);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $dimat->MON_AMT_BLN05);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $dimat->MON_AMT_BLN06);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $dimat->MON_AMT_BLN07);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $dimat->MON_AMT_BLN08);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", $dimat->MON_AMT_BLN09);
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $dimat->MON_AMT_BLN10);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", $dimat->MON_AMT_BLN11);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $dimat->MON_AMT_BLN12);
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $dimat->MON_AMT_BLN01);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $dimat->MON_AMT_BLN02);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $dimat->MON_AMT_BLN03);
            //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $dimat->MON_AMT_SUM);
        }
        
        $row = 12;
        $CHR_BUDGET_CATEGORY = 'DMA4004';
        $dimat = $this->report_budget_plan_m->get_dimat_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
        if($dimat <> null){           
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $dimat->MON_AMT_BLN04);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $dimat->MON_AMT_BLN05);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $dimat->MON_AMT_BLN06);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $dimat->MON_AMT_BLN07);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $dimat->MON_AMT_BLN08);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", $dimat->MON_AMT_BLN09);
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $dimat->MON_AMT_BLN10);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", $dimat->MON_AMT_BLN11);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $dimat->MON_AMT_BLN12);
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $dimat->MON_AMT_BLN01);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $dimat->MON_AMT_BLN02);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $dimat->MON_AMT_BLN03);
            //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $dimat->MON_AMT_SUM);
        }
        
//========================= GET DIRECT LABOR =================================//
        $row = 15;
        $CHR_BUDGET_CATEGORY = 'FOH5004';
        $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
        if($expense <> null){
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
            //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
        } 

//========================== GET CATEGORY FOH ================================//
        $row = 20;
        $CHR_BUDGET_CATEGORY = 'FOH5001';
        $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
        if($expense <> null){
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
            //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
        }
        
        $row = 21;
        $CHR_BUDGET_CATEGORY = 'FOH5002';
        $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
        if($expense <> null){
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
            //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
        }
        
        $row = 22;
        $CHR_BUDGET_CATEGORY = 'FOH5003';
        $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
        if($expense <> null){
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
            //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
        }
        
        $row = 23;
        $CHR_BUDGET_CATEGORY = 'FOH5005';
        $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
        if($expense <> null){
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
            //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
        }
        
        $row = 24;
        $CHR_BUDGET_CATEGORY = 'FOH5006';
        $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
        if($expense <> null){
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
            //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
        }
        
        $row = 25;
        $CHR_BUDGET_CATEGORY = 'FOH5007';
        $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
        if($expense <> null){
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
            //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
        }
        
        $row = 26;
        $CHR_BUDGET_CATEGORY = 'FOH5008';
        $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
        if($expense <> null){
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
            //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
        }
        
        $row = 27;
        $CHR_BUDGET_CATEGORY = 'FOH5009';
        $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
        if($expense <> null){
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
            //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
        }

        $row = 28;
        $CHR_BUDGET_CATEGORY = 'FOH5020';
        $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
        if($expense <> null){
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
            //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
        }
        
        $row = 29;
        $CHR_BUDGET_CATEGORY = 'FOH5010';
        $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
        if($expense <> null){
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
            //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
        }
        
        $row = 30;
        $CHR_BUDGET_CATEGORY = 'FOH5011';
        $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
        if($expense <> null){
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
            //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
        }
        
        $row = 31;
        $CHR_BUDGET_CATEGORY = 'FOH5012';
        $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
        if($expense <> null){
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
            //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
        }
        
        $row = 32;
        $CHR_BUDGET_CATEGORY = 'FOH5013';
        $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
        if($expense <> null){
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
            //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
        }
        
        $row = 33;
        $CHR_BUDGET_CATEGORY = 'FOH5014';
        $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
        if($expense <> null){
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
            //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
        }
        
        $row = 34;
        $CHR_BUDGET_CATEGORY = 'FOH5015';
        $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
        if($expense <> null){
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
            //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
        }
        
        $row = 35;
        $CHR_BUDGET_CATEGORY = 'FOH5016';
        $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
        if($expense <> null){
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
            //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
        }
        
        $row = 36;
        $CHR_BUDGET_CATEGORY = 'FOH5017';
        $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
        if($expense <> null){
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
            //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
        }
        
        $row = 37;
        $CHR_BUDGET_CATEGORY = 'FOH5018';
        $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
        if($expense <> null){
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
            //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
        }
        
        $row = 38;
        $CHR_BUDGET_CATEGORY = 'FOH5019';
        $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
        if($expense <> null){
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
            //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
        }
        
        $row = 39;
        $CHR_BUDGET_CATEGORY = 'FOH5021';
        $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
        if($expense <> null){
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
            //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
        }
        
        $row = 40;
        $CHR_BUDGET_CATEGORY = 'FOH5022';
        $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
        if($expense <> null){
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
            //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
        }
        
        $row = 41;
        $CHR_BUDGET_CATEGORY = 'FOH5023';
        $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
        if($expense <> null){
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
            //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
        }
        
        $row = 42;
        $CHR_BUDGET_CATEGORY = 'FOH5024';
        $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
        if($expense <> null){
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
            //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
        }
        
        $row = 43;
        $CHR_BUDGET_CATEGORY = 'FOH5025';
        $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
        if($expense <> null){
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
            //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
        }
//=============================== END OF FOH =================================//
        
//========================== GET CATEGORY OPEX ===============================//
        $row = 53;
        $CHR_BUDGET_CATEGORY = 'OPX6001';
        $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
        if($expense <> null){
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
            //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
        }
        
        $row = 54;
        $CHR_BUDGET_CATEGORY = 'OPX6002';
        $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
        if($expense <> null){
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
            //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
        }
        
        $row = 55;
        $CHR_BUDGET_CATEGORY = 'OPX6003';
        $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
        if($expense <> null){
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
            //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
        }
        
        $row = 56;
        $CHR_BUDGET_CATEGORY = 'OPX6004';
        $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
        if($expense <> null){
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
            //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
        }
        
        $row = 57;
        $CHR_BUDGET_CATEGORY = 'OPX6005';
        $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
        if($expense <> null){
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
            //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
        }
        
        $row = 58;
        $CHR_BUDGET_CATEGORY = 'OPX6006';
        $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
        if($expense <> null){
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
            //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
        }
        
        $row = 59;
        $CHR_BUDGET_CATEGORY = 'OPX6007';
        $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
        if($expense <> null){
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
            //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
        }
        
        $row = 60;
        $CHR_BUDGET_CATEGORY = 'OPX6008';
        $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
        if($expense <> null){
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
            //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
        }
        
        $row = 61;
        $CHR_BUDGET_CATEGORY = 'OPX6009';
        $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
        if($expense <> null){
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
            //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
        }
        
        $row = 62;
        $CHR_BUDGET_CATEGORY = 'OPX6010';
        $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
        if($expense <> null){
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
            //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
        }
        
        $row = 63;
        $CHR_BUDGET_CATEGORY = 'OPX6011';
        $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
        if($expense <> null){
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
            //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
        }
        
        $row = 64;
        $CHR_BUDGET_CATEGORY = 'OPX6012';
        $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
        if($expense <> null){
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
            //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
        }
        
        $row = 65;
        $CHR_BUDGET_CATEGORY = 'OPX6013';
        $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
        if($expense <> null){
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
            //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
        }
        
        $row = 66;
        $CHR_BUDGET_CATEGORY = 'OPX6014';
        $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
        if($expense <> null){
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
            //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
        }
        
        $row = 67;
        $CHR_BUDGET_CATEGORY = 'OPX6015';
        $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
        if($expense <> null){
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
            //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
        }
        
        $row = 68;
        $CHR_BUDGET_CATEGORY = 'OPX6016';
        $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
        if($expense <> null){
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
            //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
        }
        
        $row = 69;
        $CHR_BUDGET_CATEGORY = 'OPX6017';
        $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
        if($expense <> null){
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
            //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
        }
        
        $row = 70;
        $CHR_BUDGET_CATEGORY = 'OPX6018';
        $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
        if($expense <> null){
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
            //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
        }
        
        $row = 71;
        $CHR_BUDGET_CATEGORY = 'OPX6019';
        $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
        if($expense <> null){
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
            //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
        }
        
        $row = 72;
        $CHR_BUDGET_CATEGORY = 'OPX6020';
        $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
        if($expense <> null){
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
            //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
        }
        
        $row = 73;
        $CHR_BUDGET_CATEGORY = 'OPX6021';
        $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
        if($expense <> null){
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
            //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
        }
        
        $row = 74;
        $CHR_BUDGET_CATEGORY = 'OPX6022';
        $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
        if($expense <> null){
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
            //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
        }
        
        $row = 75;
        $CHR_BUDGET_CATEGORY = 'OPX6023';
        $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
        if($expense <> null){
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
            //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
        }
        
        $row = 76;
        $CHR_BUDGET_CATEGORY = 'OPX6024';
        $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
        if($expense <> null){
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
            //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
        }
        
        $row = 77;
        $CHR_BUDGET_CATEGORY = 'OPX6025';
        $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
        if($expense <> null){
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
            //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
        }
//=============================== END OF OPEX =================================//
        
//========================= GET OTHER INCOME =================================//
        $row = 83;
        $CHR_BUDGET_CATEGORY = 'NON7049';
        $nopin = $this->report_budget_plan_m->get_nopin_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
        if($nopin <> null){
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $nopin->MON_AMT_BLN04);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $nopin->MON_AMT_BLN05);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $nopin->MON_AMT_BLN06);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $nopin->MON_AMT_BLN07);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $nopin->MON_AMT_BLN08);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", $nopin->MON_AMT_BLN09);
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $nopin->MON_AMT_BLN10);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", $nopin->MON_AMT_BLN11);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $nopin->MON_AMT_BLN12);
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $nopin->MON_AMT_BLN01);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $nopin->MON_AMT_BLN02);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $nopin->MON_AMT_BLN03);
            //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $nopin->MON_AMT_SUM);
        }
        
//========================== GET SALES TOOLING AII ===========================//
        $row = 88;
        $CHR_BUDGET_CATEGORY = 'SAL3003';
        $sales = $this->report_budget_plan_m->get_sales_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
        if($sales <> null){  
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $sales->MON_AMT_BLN04);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $sales->MON_AMT_BLN05);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $sales->MON_AMT_BLN06);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $sales->MON_AMT_BLN07);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $sales->MON_AMT_BLN08);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", $sales->MON_AMT_BLN09);
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $sales->MON_AMT_BLN10);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", $sales->MON_AMT_BLN11);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $sales->MON_AMT_BLN12);
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $sales->MON_AMT_BLN01);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $sales->MON_AMT_BLN02);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $sales->MON_AMT_BLN03);
            //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $sales->MON_AMT_SUM);
        } 
        
//========================== GET COST TOOLING AII ============================//
        $row = 89;
        $CHR_BUDGET_CATEGORY = 'DMA4005';
        $dimat = $this->report_budget_plan_m->get_dimat_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
        if($dimat <> null){           
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $dimat->MON_AMT_BLN04);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $dimat->MON_AMT_BLN05);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $dimat->MON_AMT_BLN06);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $dimat->MON_AMT_BLN07);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $dimat->MON_AMT_BLN08);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", $dimat->MON_AMT_BLN09);
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $dimat->MON_AMT_BLN10);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", $dimat->MON_AMT_BLN11);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $dimat->MON_AMT_BLN12);
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $dimat->MON_AMT_BLN01);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $dimat->MON_AMT_BLN02);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $dimat->MON_AMT_BLN03);
            //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $dimat->MON_AMT_SUM);
        }
        
//========================== GET SALES PRODUCT AIIA ==========================//
        $row = 95;
        $CHR_BUDGET_CATEGORY = 'SAL3002';
        $sales = $this->report_budget_plan_m->get_sales_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
        if($sales <> null){  
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $sales->MON_AMT_BLN04);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $sales->MON_AMT_BLN05);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $sales->MON_AMT_BLN06);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $sales->MON_AMT_BLN07);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $sales->MON_AMT_BLN08);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", $sales->MON_AMT_BLN09);
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $sales->MON_AMT_BLN10);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", $sales->MON_AMT_BLN11);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $sales->MON_AMT_BLN12);
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $sales->MON_AMT_BLN01);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $sales->MON_AMT_BLN02);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $sales->MON_AMT_BLN03);
            //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $sales->MON_AMT_SUM);
        } 
        
//========================= GET COST PASSTHRU AIIA ===========================//
        $row = 96;
        $CHR_BUDGET_CATEGORY = 'DMA4006';
        $dimat = $this->report_budget_plan_m->get_dimat_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
        if($dimat <> null){           
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $dimat->MON_AMT_BLN04);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $dimat->MON_AMT_BLN05);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $dimat->MON_AMT_BLN06);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $dimat->MON_AMT_BLN07);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $dimat->MON_AMT_BLN08);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", $dimat->MON_AMT_BLN09);
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $dimat->MON_AMT_BLN10);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", $dimat->MON_AMT_BLN11);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $dimat->MON_AMT_BLN12);
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $dimat->MON_AMT_BLN01);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $dimat->MON_AMT_BLN02);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $dimat->MON_AMT_BLN03);
            //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $dimat->MON_AMT_SUM);
        }
        
//========================== GET SALES TOOLING AIIA ==========================//
        $row = 102;
        $CHR_BUDGET_CATEGORY = 'SAL3004';
        $sales = $this->report_budget_plan_m->get_sales_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
        if($sales <> null){  
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $sales->MON_AMT_BLN04);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $sales->MON_AMT_BLN05);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $sales->MON_AMT_BLN06);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $sales->MON_AMT_BLN07);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $sales->MON_AMT_BLN08);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", $sales->MON_AMT_BLN09);
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $sales->MON_AMT_BLN10);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", $sales->MON_AMT_BLN11);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $sales->MON_AMT_BLN12);
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $sales->MON_AMT_BLN01);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $sales->MON_AMT_BLN02);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $sales->MON_AMT_BLN03);
            //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $sales->MON_AMT_SUM);
        } 
        
//========================= GET COST TOOLING AIIA ============================//
        $row = 103;
        $CHR_BUDGET_CATEGORY = 'DMA4007';
        $dimat = $this->report_budget_plan_m->get_dimat_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
        if($dimat <> null){           
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $dimat->MON_AMT_BLN04);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $dimat->MON_AMT_BLN05);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $dimat->MON_AMT_BLN06);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $dimat->MON_AMT_BLN07);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $dimat->MON_AMT_BLN08);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", $dimat->MON_AMT_BLN09);
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $dimat->MON_AMT_BLN10);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", $dimat->MON_AMT_BLN11);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $dimat->MON_AMT_BLN12);
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $dimat->MON_AMT_BLN01);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $dimat->MON_AMT_BLN02);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $dimat->MON_AMT_BLN03);
            //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $dimat->MON_AMT_SUM);
        }
        
//======================= GET NON OPERATING INCOME ===========================//
        $row = 110;
        $CHR_BUDGET_CATEGORY = 'NON7010';
        $nopin = $this->report_budget_plan_m->get_nopin_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
        if($nopin <> null){
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $nopin->MON_AMT_BLN04);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $nopin->MON_AMT_BLN05);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $nopin->MON_AMT_BLN06);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $nopin->MON_AMT_BLN07);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $nopin->MON_AMT_BLN08);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", $nopin->MON_AMT_BLN09);
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $nopin->MON_AMT_BLN10);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", $nopin->MON_AMT_BLN11);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $nopin->MON_AMT_BLN12);
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $nopin->MON_AMT_BLN01);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $nopin->MON_AMT_BLN02);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $nopin->MON_AMT_BLN03);
            //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $nopin->MON_AMT_SUM);
        }
        
        $row = 111;
        $CHR_BUDGET_CATEGORY = 'NON7030';
        $nopin = $this->report_budget_plan_m->get_nopin_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
        if($nopin <> null){
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $nopin->MON_AMT_BLN04);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $nopin->MON_AMT_BLN05);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $nopin->MON_AMT_BLN06);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $nopin->MON_AMT_BLN07);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $nopin->MON_AMT_BLN08);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", $nopin->MON_AMT_BLN09);
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $nopin->MON_AMT_BLN10);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", $nopin->MON_AMT_BLN11);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $nopin->MON_AMT_BLN12);
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $nopin->MON_AMT_BLN01);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $nopin->MON_AMT_BLN02);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $nopin->MON_AMT_BLN03);
            //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $nopin->MON_AMT_SUM);
        }
        
        $row = 112;
        $CHR_BUDGET_CATEGORY = 'NON8010';
        $nopin = $this->report_budget_plan_m->get_nopin_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
        if($nopin <> null){
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $nopin->MON_AMT_BLN04);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $nopin->MON_AMT_BLN05);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $nopin->MON_AMT_BLN06);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $nopin->MON_AMT_BLN07);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $nopin->MON_AMT_BLN08);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", $nopin->MON_AMT_BLN09);
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $nopin->MON_AMT_BLN10);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", $nopin->MON_AMT_BLN11);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $nopin->MON_AMT_BLN12);
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $nopin->MON_AMT_BLN01);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $nopin->MON_AMT_BLN02);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $nopin->MON_AMT_BLN03);
            //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $nopin->MON_AMT_SUM);
        }
        
        $row = 113;
        $CHR_BUDGET_CATEGORY = 'NON8020';
        $nopin = $this->report_budget_plan_m->get_nopin_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
        if($nopin <> null){
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $nopin->MON_AMT_BLN04);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $nopin->MON_AMT_BLN05);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $nopin->MON_AMT_BLN06);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $nopin->MON_AMT_BLN07);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $nopin->MON_AMT_BLN08);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", $nopin->MON_AMT_BLN09);
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $nopin->MON_AMT_BLN10);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", $nopin->MON_AMT_BLN11);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $nopin->MON_AMT_BLN12);
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $nopin->MON_AMT_BLN01);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $nopin->MON_AMT_BLN02);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $nopin->MON_AMT_BLN03);
            //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $nopin->MON_AMT_SUM);
        }
//======================= END OF NON OPERATING INCOME ========================//
        
//================================= GET TAX ==================================//
        $row = 120;
        $CHR_BUDGET_CATEGORY = 'TAX8801';
        $tax = $this->report_budget_plan_m->get_tax_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
        if($tax <> null){
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $tax->MON_AMT_BLN04);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $tax->MON_AMT_BLN05);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $tax->MON_AMT_BLN06);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $tax->MON_AMT_BLN07);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $tax->MON_AMT_BLN08);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", $tax->MON_AMT_BLN09);
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $tax->MON_AMT_BLN10);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", $tax->MON_AMT_BLN11);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $tax->MON_AMT_BLN12);
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $tax->MON_AMT_BLN01);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $tax->MON_AMT_BLN02);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $tax->MON_AMT_BLN03);
            //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $tax->MON_AMT_SUM);
        }
        
        $row = 121;
        $CHR_BUDGET_CATEGORY = 'TAX8803';
        $tax = $this->report_budget_plan_m->get_tax_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
        if($tax <> null){
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $tax->MON_AMT_BLN04);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $tax->MON_AMT_BLN05);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $tax->MON_AMT_BLN06);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $tax->MON_AMT_BLN07);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $tax->MON_AMT_BLN08);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", $tax->MON_AMT_BLN09);
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $tax->MON_AMT_BLN10);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", $tax->MON_AMT_BLN11);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $tax->MON_AMT_BLN12);
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $tax->MON_AMT_BLN01);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $tax->MON_AMT_BLN02);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $tax->MON_AMT_BLN03);
            //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $tax->MON_AMT_SUM);
        }
//================================= END TAX ==================================//        
        
        $row = 127;

        $gdImage = imagecreatefromjpeg('assets/template/budget/report/approval.JPG');
        // Add a drawing to the worksheetecho date('H:i:s') . " Add a drawing to the worksheet\n";
        $objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
        $objDrawing->setName('Sample image');
        $objDrawing->setDescription('Sample image');
        $objDrawing->setImageResource($gdImage);
        $objDrawing->setRenderingFunction(PHPExcel_Worksheet_MemoryDrawing::RENDERING_JPEG);
        $objDrawing->setMimeType(PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_DEFAULT);
        $objDrawing->setHeight(105);
        $objDrawing->setCoordinates("O$row");
        $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());

        ob_end_clean();
        $filename = "REPORT PROFIT & LOSS BY FOH OPEX - BUDGET $INT_ID_FISCAL_YEAR .xls";
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . trim($filename) . '"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->setIncludeCharts(TRUE);
        $objWriter->save('php://output');
    }
    
    function download_format_a3($INT_ID_FISCAL_YEAR = null) {   
        $this->load->library('excel');
        $objReader = PHPExcel_IOFactory::createReader('Excel5');
        
//====== Create new PHPExcel object
        $objPHPExcel = $objReader->load("assets/template/budget/report/Template_Report_Profit_Loss_A3.xls");
     
        $objPHPExcel->getActiveSheet()->setCellValue("B3", "PROFIT/LOSS MASTER BUDGET TAHUN : " . $INT_ID_FISCAL_YEAR . " - BY CATEGORY A3");
        $CHR_BUDGET_CATEGORY = "";
        
//========================== GET SALES PRODUCT AII ===========================//
        $row = 7;
        $CHR_BUDGET_CATEGORY = 'SAL3001';
        $sales = $this->report_budget_plan_m->get_sales_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
        if($sales <> null){  
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $sales->MON_AMT_BLN04);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $sales->MON_AMT_BLN05);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $sales->MON_AMT_BLN06);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $sales->MON_AMT_BLN07);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $sales->MON_AMT_BLN08);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", $sales->MON_AMT_BLN09);
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $sales->MON_AMT_BLN10);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", $sales->MON_AMT_BLN11);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $sales->MON_AMT_BLN12);
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $sales->MON_AMT_BLN01);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $sales->MON_AMT_BLN02);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $sales->MON_AMT_BLN03);
            //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $sales->MON_AMT_SUM);
        }        
        
//=========================== GET DIRECT MATERIAL ============================//
        $row = 9;
        $CHR_BUDGET_CATEGORY = 'DMA4001';
        $dimat = $this->report_budget_plan_m->get_dimat_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
        if($dimat <> null){           
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $dimat->MON_AMT_BLN04);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $dimat->MON_AMT_BLN05);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $dimat->MON_AMT_BLN06);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $dimat->MON_AMT_BLN07);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $dimat->MON_AMT_BLN08);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", $dimat->MON_AMT_BLN09);
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $dimat->MON_AMT_BLN10);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", $dimat->MON_AMT_BLN11);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $dimat->MON_AMT_BLN12);
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $dimat->MON_AMT_BLN01);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $dimat->MON_AMT_BLN02);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $dimat->MON_AMT_BLN03);
            //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $dimat->MON_AMT_SUM);
        }
        
        $row = 10;
        $CHR_BUDGET_CATEGORY = 'DMA4002';
        $dimat = $this->report_budget_plan_m->get_dimat_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
        if($dimat <> null){           
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $dimat->MON_AMT_BLN04);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $dimat->MON_AMT_BLN05);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $dimat->MON_AMT_BLN06);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $dimat->MON_AMT_BLN07);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $dimat->MON_AMT_BLN08);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", $dimat->MON_AMT_BLN09);
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $dimat->MON_AMT_BLN10);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", $dimat->MON_AMT_BLN11);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $dimat->MON_AMT_BLN12);
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $dimat->MON_AMT_BLN01);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $dimat->MON_AMT_BLN02);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $dimat->MON_AMT_BLN03);
            //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $dimat->MON_AMT_SUM);
        }
        
        $row = 11;
        $CHR_BUDGET_CATEGORY = 'DMA4003';
        $dimat = $this->report_budget_plan_m->get_dimat_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
        if($dimat <> null){           
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $dimat->MON_AMT_BLN04);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $dimat->MON_AMT_BLN05);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $dimat->MON_AMT_BLN06);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $dimat->MON_AMT_BLN07);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $dimat->MON_AMT_BLN08);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", $dimat->MON_AMT_BLN09);
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $dimat->MON_AMT_BLN10);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", $dimat->MON_AMT_BLN11);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $dimat->MON_AMT_BLN12);
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $dimat->MON_AMT_BLN01);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $dimat->MON_AMT_BLN02);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $dimat->MON_AMT_BLN03);
            //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $dimat->MON_AMT_SUM);
        }
        
        $row = 12;
        $CHR_BUDGET_CATEGORY = 'DMA4004';
        $dimat = $this->report_budget_plan_m->get_dimat_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
        if($dimat <> null){           
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $dimat->MON_AMT_BLN04);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $dimat->MON_AMT_BLN05);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $dimat->MON_AMT_BLN06);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $dimat->MON_AMT_BLN07);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $dimat->MON_AMT_BLN08);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", $dimat->MON_AMT_BLN09);
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $dimat->MON_AMT_BLN10);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", $dimat->MON_AMT_BLN11);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $dimat->MON_AMT_BLN12);
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $dimat->MON_AMT_BLN01);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $dimat->MON_AMT_BLN02);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $dimat->MON_AMT_BLN03);
            //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $dimat->MON_AMT_SUM);
        }
        
//========================= GET VARIABLE COST ================================//
        $row = 16;
        $CHR_BUDGET_CATEGORY = 'FOH5001';
        $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
        if($expense <> null){
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
            //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
        } 
        
        $row = 17;
        $CHR_BUDGET_CATEGORY = 'FOH5002';
        $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
        if($expense <> null){
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
            //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
        }
        
        $row = 18;
        $CHR_BUDGET_CATEGORY = 'FOH5003';
        $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
        if($expense <> null){
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
            //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
        }

        $row = 20;
        $CHR_BUDGET_CATEGORY = 'FOH5004';
        $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
        if($expense <> null){
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
            //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
        }
        
        $row = 21;
        $CHR_BUDGET_CATEGORY = 'FOH5005';
        $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
        if($expense <> null){
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
            //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
        }
        
        $row = 22;
        $CHR_BUDGET_CATEGORY = 'FOH5006';
        $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
        if($expense <> null){
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
            //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
        }
        
        $row = 23;
        $CHR_BUDGET_CATEGORY = 'FOH5007';
        $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
        if($expense <> null){
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
            //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
        }
        
        $row = 24;
        $CHR_BUDGET_CATEGORY = 'FOH5008';
        $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
        if($expense <> null){
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
            //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
        }
        
        $row = 25;
        $CHR_BUDGET_CATEGORY = 'FOH5009';
        $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
        if($expense <> null){
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
            //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
        }

        $row = 26;
        $CHR_BUDGET_CATEGORY = 'FOH5020';
        $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
        if($expense <> null){
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
            //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
        }
        
        $row = 27;
        $CHR_BUDGET_CATEGORY = 'OPX6001';
        $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
        if($expense <> null){
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
            //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
        }
        
        $row = 28;
        $CHR_BUDGET_CATEGORY = 'OPX6002';
        $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
        if($expense <> null){
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
            //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
        }
//========================== END VARIABLE COST ===============================//
        
//============================= FIXED COST ===================================//        
        $row = 35;
        $CHR_BUDGET_CATEGORY = 'FOH5010';
        $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
        if($expense <> null){
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
            //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
        }
        
        $row = 36;
        $CHR_BUDGET_CATEGORY = 'FOH5011';
        $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
        if($expense <> null){
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
            //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
        }
        
        $row = 37;
        $CHR_BUDGET_CATEGORY = 'FOH5012';
        $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
        if($expense <> null){
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
            //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
        }
        
        $row = 38;
        $CHR_BUDGET_CATEGORY = 'FOH5013';
        $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
        if($expense <> null){
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
            //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
        }
        
        $row = 39;
        $CHR_BUDGET_CATEGORY = 'FOH5014';
        $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
        if($expense <> null){
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
            //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
        }
        
        $row = 40;
        $CHR_BUDGET_CATEGORY = 'FOH5015';
        $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
        if($expense <> null){
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
            //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
        }
        
        $row = 41;
        $CHR_BUDGET_CATEGORY = 'FOH5016';
        $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
        if($expense <> null){
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
            //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
        }
        
        $row = 42;
        $CHR_BUDGET_CATEGORY = 'FOH5017';
        $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
        if($expense <> null){
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
            //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
        }
        
        $row = 43;
        $CHR_BUDGET_CATEGORY = 'FOH5018';
        $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
        if($expense <> null){
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
            //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
        }
        
        $row = 44;
        $CHR_BUDGET_CATEGORY = 'FOH5019';
        $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
        if($expense <> null){
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
            //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
        }
        
        $row = 45;
        $CHR_BUDGET_CATEGORY = 'FOH5021';
        $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
        if($expense <> null){
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
            //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
        }
        
        $row = 46;
        $CHR_BUDGET_CATEGORY = 'FOH5022';
        $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
        if($expense <> null){
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
            //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
        }
        
        $row = 47;
        $CHR_BUDGET_CATEGORY = 'FOH5023';
        $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
        if($expense <> null){
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
            //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
        }
        
        $row = 48;
        $CHR_BUDGET_CATEGORY = 'FOH5024';
        $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
        if($expense <> null){
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
            //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
        }
        
        $row = 49;
        $CHR_BUDGET_CATEGORY = 'FOH5025';
        $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
        if($expense <> null){
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
            //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
        }
//=============================== END OF FIXED COST ==========================//
        
//============================= GET SGA COST =================================//
        $row = 53;
        $CHR_BUDGET_CATEGORY = 'OPX6003';
        $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
        if($expense <> null){
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
            //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
        }
        
        $row = 54;
        $CHR_BUDGET_CATEGORY = 'OPX6004';
        $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
        if($expense <> null){
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
            //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
        }
        
        $row = 55;
        $CHR_BUDGET_CATEGORY = 'OPX6005';
        $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
        if($expense <> null){
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
            //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
        }
        
        $row = 56;
        $CHR_BUDGET_CATEGORY = 'OPX6006';
        $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
        if($expense <> null){
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
            //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
        }
        
        $row = 57;
        $CHR_BUDGET_CATEGORY = 'OPX6007';
        $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
        if($expense <> null){
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
            //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
        }
        
        $row = 58;
        $CHR_BUDGET_CATEGORY = 'OPX6008';
        $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
        if($expense <> null){
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
            //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
        }
        
        $row = 59;
        $CHR_BUDGET_CATEGORY = 'OPX6009';
        $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
        if($expense <> null){
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
            //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
        }
        
        $row = 60;
        $CHR_BUDGET_CATEGORY = 'OPX6010';
        $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
        if($expense <> null){
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
            //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
        }
        
        $row = 61;
        $CHR_BUDGET_CATEGORY = 'OPX6011';
        $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
        if($expense <> null){
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
            //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
        }
        
        $row = 62;
        $CHR_BUDGET_CATEGORY = 'OPX6012';
        $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
        if($expense <> null){
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
            //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
        }
        
        $row = 63;
        $CHR_BUDGET_CATEGORY = 'OPX6013';
        $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
        if($expense <> null){
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
            //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
        }
        
        $row = 64;
        $CHR_BUDGET_CATEGORY = 'OPX6014';
        $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
        if($expense <> null){
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
            //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
        }
        
        $row = 65;
        $CHR_BUDGET_CATEGORY = 'OPX6015';
        $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
        if($expense <> null){
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
            //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
        }
        
        $row = 66;
        $CHR_BUDGET_CATEGORY = 'OPX6016';
        $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
        if($expense <> null){
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
            //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
        }
        
        $row = 67;
        $CHR_BUDGET_CATEGORY = 'OPX6017';
        $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
        if($expense <> null){
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
            //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
        }
        
        $row = 68;
        $CHR_BUDGET_CATEGORY = 'OPX6018';
        $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
        if($expense <> null){
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
            //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
        }
        
        $row = 69;
        $CHR_BUDGET_CATEGORY = 'OPX6019';
        $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
        if($expense <> null){
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
            //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
        }
        
        $row = 70;
        $CHR_BUDGET_CATEGORY = 'OPX6020';
        $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
        if($expense <> null){
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
            //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
        }
        
        $row = 71;
        $CHR_BUDGET_CATEGORY = 'OPX6021';
        $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
        if($expense <> null){
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
            //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
        }
        
        $row = 72;
        $CHR_BUDGET_CATEGORY = 'OPX6022';
        $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
        if($expense <> null){
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
            //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
        }
        
        $row = 73;
        $CHR_BUDGET_CATEGORY = 'OPX6023';
        $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
        if($expense <> null){
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
            //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
        }
        
        $row = 74;
        $CHR_BUDGET_CATEGORY = 'OPX6024';
        $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
        if($expense <> null){
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
            //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
        }
        
        $row = 75;
        $CHR_BUDGET_CATEGORY = 'OPX6025';
        $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
        if($expense <> null){
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
            //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
        }
//=============================== END OF SGA COST ============================//
        
//========================= GET OTHER INCOME =================================//
        $row = 81;
        $CHR_BUDGET_CATEGORY = 'NON7049';
        $nopin = $this->report_budget_plan_m->get_nopin_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
        if($nopin <> null){
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $nopin->MON_AMT_BLN04);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $nopin->MON_AMT_BLN05);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $nopin->MON_AMT_BLN06);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $nopin->MON_AMT_BLN07);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $nopin->MON_AMT_BLN08);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", $nopin->MON_AMT_BLN09);
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $nopin->MON_AMT_BLN10);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", $nopin->MON_AMT_BLN11);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $nopin->MON_AMT_BLN12);
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $nopin->MON_AMT_BLN01);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $nopin->MON_AMT_BLN02);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $nopin->MON_AMT_BLN03);
            //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $nopin->MON_AMT_SUM);
        }
        
//========================== GET SALES TOOLING AII ===========================//
        $row = 86;
        $CHR_BUDGET_CATEGORY = 'SAL3003';
        $sales = $this->report_budget_plan_m->get_sales_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
        if($sales <> null){  
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $sales->MON_AMT_BLN04);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $sales->MON_AMT_BLN05);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $sales->MON_AMT_BLN06);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $sales->MON_AMT_BLN07);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $sales->MON_AMT_BLN08);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", $sales->MON_AMT_BLN09);
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $sales->MON_AMT_BLN10);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", $sales->MON_AMT_BLN11);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $sales->MON_AMT_BLN12);
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $sales->MON_AMT_BLN01);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $sales->MON_AMT_BLN02);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $sales->MON_AMT_BLN03);
            //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $sales->MON_AMT_SUM);
        } 
        
//========================== GET COST TOOLING AII ============================//
        $row = 87;
        $CHR_BUDGET_CATEGORY = 'DMA4005';
        $dimat = $this->report_budget_plan_m->get_dimat_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
        if($dimat <> null){           
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $dimat->MON_AMT_BLN04);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $dimat->MON_AMT_BLN05);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $dimat->MON_AMT_BLN06);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $dimat->MON_AMT_BLN07);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $dimat->MON_AMT_BLN08);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", $dimat->MON_AMT_BLN09);
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $dimat->MON_AMT_BLN10);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", $dimat->MON_AMT_BLN11);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $dimat->MON_AMT_BLN12);
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $dimat->MON_AMT_BLN01);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $dimat->MON_AMT_BLN02);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $dimat->MON_AMT_BLN03);
            //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $dimat->MON_AMT_SUM);
        }
        
//========================== GET SALES PRODUCT AIIA ==========================//
        $row = 93;
        $CHR_BUDGET_CATEGORY = 'SAL3002';
        $sales = $this->report_budget_plan_m->get_sales_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
        if($sales <> null){  
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $sales->MON_AMT_BLN04);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $sales->MON_AMT_BLN05);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $sales->MON_AMT_BLN06);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $sales->MON_AMT_BLN07);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $sales->MON_AMT_BLN08);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", $sales->MON_AMT_BLN09);
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $sales->MON_AMT_BLN10);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", $sales->MON_AMT_BLN11);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $sales->MON_AMT_BLN12);
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $sales->MON_AMT_BLN01);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $sales->MON_AMT_BLN02);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $sales->MON_AMT_BLN03);
            //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $sales->MON_AMT_SUM);
        } 
        
//========================= GET COST PASSTHRU AIIA ===========================//
        $row = 94;
        $CHR_BUDGET_CATEGORY = 'DMA4006';
        $dimat = $this->report_budget_plan_m->get_dimat_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
        if($dimat <> null){           
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $dimat->MON_AMT_BLN04);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $dimat->MON_AMT_BLN05);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $dimat->MON_AMT_BLN06);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $dimat->MON_AMT_BLN07);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $dimat->MON_AMT_BLN08);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", $dimat->MON_AMT_BLN09);
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $dimat->MON_AMT_BLN10);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", $dimat->MON_AMT_BLN11);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $dimat->MON_AMT_BLN12);
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $dimat->MON_AMT_BLN01);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $dimat->MON_AMT_BLN02);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $dimat->MON_AMT_BLN03);
            //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $dimat->MON_AMT_SUM);
        }
        
//========================== GET SALES TOOLING AIIA ==========================//
        $row = 100;
        $CHR_BUDGET_CATEGORY = 'SAL3004';
        $sales = $this->report_budget_plan_m->get_sales_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
        if($sales <> null){  
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $sales->MON_AMT_BLN04);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $sales->MON_AMT_BLN05);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $sales->MON_AMT_BLN06);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $sales->MON_AMT_BLN07);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $sales->MON_AMT_BLN08);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", $sales->MON_AMT_BLN09);
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $sales->MON_AMT_BLN10);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", $sales->MON_AMT_BLN11);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $sales->MON_AMT_BLN12);
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $sales->MON_AMT_BLN01);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $sales->MON_AMT_BLN02);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $sales->MON_AMT_BLN03);
            //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $sales->MON_AMT_SUM);
        } 
        
//========================= GET COST TOOLING AIIA ============================//
        $row = 101;
        $CHR_BUDGET_CATEGORY = 'DMA4007';
        $dimat = $this->report_budget_plan_m->get_dimat_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
        if($dimat <> null){           
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $dimat->MON_AMT_BLN04);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $dimat->MON_AMT_BLN05);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $dimat->MON_AMT_BLN06);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $dimat->MON_AMT_BLN07);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $dimat->MON_AMT_BLN08);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", $dimat->MON_AMT_BLN09);
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $dimat->MON_AMT_BLN10);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", $dimat->MON_AMT_BLN11);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $dimat->MON_AMT_BLN12);
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $dimat->MON_AMT_BLN01);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $dimat->MON_AMT_BLN02);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $dimat->MON_AMT_BLN03);
            //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $dimat->MON_AMT_SUM);
        }
        
//======================= GET NON OPERATING INCOME ===========================//
        $row = 108;
        $CHR_BUDGET_CATEGORY = 'NON7010';
        $nopin = $this->report_budget_plan_m->get_nopin_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
        if($nopin <> null){
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $nopin->MON_AMT_BLN04);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $nopin->MON_AMT_BLN05);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $nopin->MON_AMT_BLN06);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $nopin->MON_AMT_BLN07);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $nopin->MON_AMT_BLN08);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", $nopin->MON_AMT_BLN09);
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $nopin->MON_AMT_BLN10);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", $nopin->MON_AMT_BLN11);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $nopin->MON_AMT_BLN12);
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $nopin->MON_AMT_BLN01);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $nopin->MON_AMT_BLN02);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $nopin->MON_AMT_BLN03);
            //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $nopin->MON_AMT_SUM);
        }
        
        $row = 109;
        $CHR_BUDGET_CATEGORY = 'NON7030';
        $nopin = $this->report_budget_plan_m->get_nopin_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
        if($nopin <> null){
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $nopin->MON_AMT_BLN04);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $nopin->MON_AMT_BLN05);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $nopin->MON_AMT_BLN06);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $nopin->MON_AMT_BLN07);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $nopin->MON_AMT_BLN08);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", $nopin->MON_AMT_BLN09);
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $nopin->MON_AMT_BLN10);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", $nopin->MON_AMT_BLN11);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $nopin->MON_AMT_BLN12);
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $nopin->MON_AMT_BLN01);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $nopin->MON_AMT_BLN02);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $nopin->MON_AMT_BLN03);
            //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $nopin->MON_AMT_SUM);
        }
        
        $row = 110;
        $CHR_BUDGET_CATEGORY = 'NON8010';
        $nopin = $this->report_budget_plan_m->get_nopin_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
        if($nopin <> null){
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $nopin->MON_AMT_BLN04);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $nopin->MON_AMT_BLN05);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $nopin->MON_AMT_BLN06);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $nopin->MON_AMT_BLN07);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $nopin->MON_AMT_BLN08);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", $nopin->MON_AMT_BLN09);
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $nopin->MON_AMT_BLN10);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", $nopin->MON_AMT_BLN11);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $nopin->MON_AMT_BLN12);
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $nopin->MON_AMT_BLN01);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $nopin->MON_AMT_BLN02);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $nopin->MON_AMT_BLN03);
            //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $nopin->MON_AMT_SUM);
        }
        
        $row = 111;
        $CHR_BUDGET_CATEGORY = 'NON8020';
        $nopin = $this->report_budget_plan_m->get_nopin_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
        if($nopin <> null){
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $nopin->MON_AMT_BLN04);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $nopin->MON_AMT_BLN05);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $nopin->MON_AMT_BLN06);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $nopin->MON_AMT_BLN07);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $nopin->MON_AMT_BLN08);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", $nopin->MON_AMT_BLN09);
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $nopin->MON_AMT_BLN10);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", $nopin->MON_AMT_BLN11);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $nopin->MON_AMT_BLN12);
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $nopin->MON_AMT_BLN01);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $nopin->MON_AMT_BLN02);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $nopin->MON_AMT_BLN03);
            //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $nopin->MON_AMT_SUM);
        }
//======================= END OF NON OPERATING INCOME ========================//
        
//================================= GET TAX ==================================//
        $row = 118;
        $CHR_BUDGET_CATEGORY = 'TAX8801';
        $tax = $this->report_budget_plan_m->get_tax_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
        if($tax <> null){
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $tax->MON_AMT_BLN04);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $tax->MON_AMT_BLN05);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $tax->MON_AMT_BLN06);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $tax->MON_AMT_BLN07);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $tax->MON_AMT_BLN08);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", $tax->MON_AMT_BLN09);
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $tax->MON_AMT_BLN10);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", $tax->MON_AMT_BLN11);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $tax->MON_AMT_BLN12);
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $tax->MON_AMT_BLN01);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $tax->MON_AMT_BLN02);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $tax->MON_AMT_BLN03);
            //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $tax->MON_AMT_SUM);
        }
        
        $row = 119;
        $CHR_BUDGET_CATEGORY = 'TAX8803';
        $tax = $this->report_budget_plan_m->get_tax_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
        if($tax <> null){
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $tax->MON_AMT_BLN04);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $tax->MON_AMT_BLN05);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $tax->MON_AMT_BLN06);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $tax->MON_AMT_BLN07);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $tax->MON_AMT_BLN08);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", $tax->MON_AMT_BLN09);
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $tax->MON_AMT_BLN10);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", $tax->MON_AMT_BLN11);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $tax->MON_AMT_BLN12);
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $tax->MON_AMT_BLN01);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $tax->MON_AMT_BLN02);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $tax->MON_AMT_BLN03);
            //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $tax->MON_AMT_SUM);
        }
//================================= END TAX ==================================//        
        
        $row = 127;

        $gdImage = imagecreatefromjpeg('assets/template/budget/report/approval.JPG');
        // Add a drawing to the worksheetecho date('H:i:s') . " Add a drawing to the worksheet\n";
        $objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
        $objDrawing->setName('Sample image');
        $objDrawing->setDescription('Sample image');
        $objDrawing->setImageResource($gdImage);
        $objDrawing->setRenderingFunction(PHPExcel_Worksheet_MemoryDrawing::RENDERING_JPEG);
        $objDrawing->setMimeType(PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_DEFAULT);
        $objDrawing->setHeight(105);
        $objDrawing->setCoordinates("O$row");
        $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());

        ob_end_clean();
        $filename = "REPORT PROFIT & LOSS BY CATEGORY A3 - BUDGET $INT_ID_FISCAL_YEAR .xls";
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . trim($filename) . '"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->setIncludeCharts(TRUE);
        $objWriter->save('php://output');
    }
    
    //===== BACKUP FUNCTION - MB FY 2021 =====//
//     function download_format_foh($INT_ID_FISCAL_YEAR = null) {   
//         $this->load->library('excel');
//         $objReader = PHPExcel_IOFactory::createReader('Excel5');
        
// //====== Create new PHPExcel object
//         $objPHPExcel = $objReader->load("assets/template/budget/report/Template_Report_Profit_Loss.xls");
     
//         $objPHPExcel->getActiveSheet()->setCellValue("B3", "PROFIT/LOSS MASTER BUDGET TAHUN : " . $INT_ID_FISCAL_YEAR . " - BY CATEGORY FOH/OPEX");
//         $CHR_BUDGET_CATEGORY = "";
        
// //========================== GET SALES PRODUCT AII ===========================//
//         $row = 7;
//         $CHR_BUDGET_CATEGORY = 'SAL3001';
//         $sales = $this->report_budget_plan_m->get_sales_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
//         if($sales <> null){  
//             $objPHPExcel->getActiveSheet()->setCellValue("F$row", $sales->MON_AMT_BLN04);
//             $objPHPExcel->getActiveSheet()->setCellValue("G$row", $sales->MON_AMT_BLN05);
//             $objPHPExcel->getActiveSheet()->setCellValue("H$row", $sales->MON_AMT_BLN06);
//             $objPHPExcel->getActiveSheet()->setCellValue("I$row", $sales->MON_AMT_BLN07);
//             $objPHPExcel->getActiveSheet()->setCellValue("J$row", $sales->MON_AMT_BLN08);
//             $objPHPExcel->getActiveSheet()->setCellValue("K$row", $sales->MON_AMT_BLN09);
//             $objPHPExcel->getActiveSheet()->setCellValue("L$row", $sales->MON_AMT_BLN10);
//             $objPHPExcel->getActiveSheet()->setCellValue("M$row", $sales->MON_AMT_BLN11);
//             $objPHPExcel->getActiveSheet()->setCellValue("N$row", $sales->MON_AMT_BLN12);
//             $objPHPExcel->getActiveSheet()->setCellValue("O$row", $sales->MON_AMT_BLN01);
//             $objPHPExcel->getActiveSheet()->setCellValue("P$row", $sales->MON_AMT_BLN02);
//             $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $sales->MON_AMT_BLN03);
//             //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $sales->MON_AMT_SUM);
//         }        
        
// //=========================== GET DIRECT MATERIAL ============================//
//         $row = 9;
//         $CHR_BUDGET_CATEGORY = 'DMA4001';
//         $dimat = $this->report_budget_plan_m->get_dimat_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
//         if($dimat <> null){           
//             $objPHPExcel->getActiveSheet()->setCellValue("F$row", $dimat->MON_AMT_BLN04);
//             $objPHPExcel->getActiveSheet()->setCellValue("G$row", $dimat->MON_AMT_BLN05);
//             $objPHPExcel->getActiveSheet()->setCellValue("H$row", $dimat->MON_AMT_BLN06);
//             $objPHPExcel->getActiveSheet()->setCellValue("I$row", $dimat->MON_AMT_BLN07);
//             $objPHPExcel->getActiveSheet()->setCellValue("J$row", $dimat->MON_AMT_BLN08);
//             $objPHPExcel->getActiveSheet()->setCellValue("K$row", $dimat->MON_AMT_BLN09);
//             $objPHPExcel->getActiveSheet()->setCellValue("L$row", $dimat->MON_AMT_BLN10);
//             $objPHPExcel->getActiveSheet()->setCellValue("M$row", $dimat->MON_AMT_BLN11);
//             $objPHPExcel->getActiveSheet()->setCellValue("N$row", $dimat->MON_AMT_BLN12);
//             $objPHPExcel->getActiveSheet()->setCellValue("O$row", $dimat->MON_AMT_BLN01);
//             $objPHPExcel->getActiveSheet()->setCellValue("P$row", $dimat->MON_AMT_BLN02);
//             $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $dimat->MON_AMT_BLN03);
//             //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $dimat->MON_AMT_SUM);
//         }
        
//         $row = 10;
//         $CHR_BUDGET_CATEGORY = 'DMA4002';
//         $dimat = $this->report_budget_plan_m->get_dimat_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
//         if($dimat <> null){           
//             $objPHPExcel->getActiveSheet()->setCellValue("F$row", $dimat->MON_AMT_BLN04);
//             $objPHPExcel->getActiveSheet()->setCellValue("G$row", $dimat->MON_AMT_BLN05);
//             $objPHPExcel->getActiveSheet()->setCellValue("H$row", $dimat->MON_AMT_BLN06);
//             $objPHPExcel->getActiveSheet()->setCellValue("I$row", $dimat->MON_AMT_BLN07);
//             $objPHPExcel->getActiveSheet()->setCellValue("J$row", $dimat->MON_AMT_BLN08);
//             $objPHPExcel->getActiveSheet()->setCellValue("K$row", $dimat->MON_AMT_BLN09);
//             $objPHPExcel->getActiveSheet()->setCellValue("L$row", $dimat->MON_AMT_BLN10);
//             $objPHPExcel->getActiveSheet()->setCellValue("M$row", $dimat->MON_AMT_BLN11);
//             $objPHPExcel->getActiveSheet()->setCellValue("N$row", $dimat->MON_AMT_BLN12);
//             $objPHPExcel->getActiveSheet()->setCellValue("O$row", $dimat->MON_AMT_BLN01);
//             $objPHPExcel->getActiveSheet()->setCellValue("P$row", $dimat->MON_AMT_BLN02);
//             $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $dimat->MON_AMT_BLN03);
//             //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $dimat->MON_AMT_SUM);
//         }
        
//         $row = 11;
//         $CHR_BUDGET_CATEGORY = 'DMA4003';
//         $dimat = $this->report_budget_plan_m->get_dimat_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
//         if($dimat <> null){           
//             $objPHPExcel->getActiveSheet()->setCellValue("F$row", $dimat->MON_AMT_BLN04);
//             $objPHPExcel->getActiveSheet()->setCellValue("G$row", $dimat->MON_AMT_BLN05);
//             $objPHPExcel->getActiveSheet()->setCellValue("H$row", $dimat->MON_AMT_BLN06);
//             $objPHPExcel->getActiveSheet()->setCellValue("I$row", $dimat->MON_AMT_BLN07);
//             $objPHPExcel->getActiveSheet()->setCellValue("J$row", $dimat->MON_AMT_BLN08);
//             $objPHPExcel->getActiveSheet()->setCellValue("K$row", $dimat->MON_AMT_BLN09);
//             $objPHPExcel->getActiveSheet()->setCellValue("L$row", $dimat->MON_AMT_BLN10);
//             $objPHPExcel->getActiveSheet()->setCellValue("M$row", $dimat->MON_AMT_BLN11);
//             $objPHPExcel->getActiveSheet()->setCellValue("N$row", $dimat->MON_AMT_BLN12);
//             $objPHPExcel->getActiveSheet()->setCellValue("O$row", $dimat->MON_AMT_BLN01);
//             $objPHPExcel->getActiveSheet()->setCellValue("P$row", $dimat->MON_AMT_BLN02);
//             $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $dimat->MON_AMT_BLN03);
//             //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $dimat->MON_AMT_SUM);
//         }
        
//         $row = 12;
//         $CHR_BUDGET_CATEGORY = 'DMA4004';
//         $dimat = $this->report_budget_plan_m->get_dimat_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
//         if($dimat <> null){           
//             $objPHPExcel->getActiveSheet()->setCellValue("F$row", $dimat->MON_AMT_BLN04);
//             $objPHPExcel->getActiveSheet()->setCellValue("G$row", $dimat->MON_AMT_BLN05);
//             $objPHPExcel->getActiveSheet()->setCellValue("H$row", $dimat->MON_AMT_BLN06);
//             $objPHPExcel->getActiveSheet()->setCellValue("I$row", $dimat->MON_AMT_BLN07);
//             $objPHPExcel->getActiveSheet()->setCellValue("J$row", $dimat->MON_AMT_BLN08);
//             $objPHPExcel->getActiveSheet()->setCellValue("K$row", $dimat->MON_AMT_BLN09);
//             $objPHPExcel->getActiveSheet()->setCellValue("L$row", $dimat->MON_AMT_BLN10);
//             $objPHPExcel->getActiveSheet()->setCellValue("M$row", $dimat->MON_AMT_BLN11);
//             $objPHPExcel->getActiveSheet()->setCellValue("N$row", $dimat->MON_AMT_BLN12);
//             $objPHPExcel->getActiveSheet()->setCellValue("O$row", $dimat->MON_AMT_BLN01);
//             $objPHPExcel->getActiveSheet()->setCellValue("P$row", $dimat->MON_AMT_BLN02);
//             $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $dimat->MON_AMT_BLN03);
//             //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $dimat->MON_AMT_SUM);
//         }
        
// //========================= GET DIRECT LABOR =================================//
//         $row = 15;
//         $CHR_BUDGET_CATEGORY = 'FOH5004';
//         $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
//         if($expense <> null){
//             $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
//             $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
//             $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
//             $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
//             $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
//             $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
//             $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
//             $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
//             $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
//             $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
//             $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
//             $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
//             //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
//         } 

// //========================== GET CATEGORY FOH ================================//
//         $row = 20;
//         $CHR_BUDGET_CATEGORY = 'FOH5001';
//         $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
//         if($expense <> null){
//             $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
//             $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
//             $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
//             $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
//             $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
//             $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
//             $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
//             $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
//             $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
//             $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
//             $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
//             $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
//             //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
//         }
        
//         $row = 21;
//         $CHR_BUDGET_CATEGORY = 'FOH5002';
//         $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
//         if($expense <> null){
//             $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
//             $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
//             $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
//             $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
//             $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
//             $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
//             $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
//             $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
//             $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
//             $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
//             $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
//             $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
//             //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
//         }
        
//         $row = 22;
//         $CHR_BUDGET_CATEGORY = 'FOH5003';
//         $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
//         if($expense <> null){
//             $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
//             $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
//             $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
//             $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
//             $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
//             $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
//             $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
//             $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
//             $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
//             $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
//             $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
//             $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
//             //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
//         }
        
//         $row = 23;
//         $CHR_BUDGET_CATEGORY = 'FOH5005';
//         $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
//         if($expense <> null){
//             $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
//             $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
//             $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
//             $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
//             $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
//             $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
//             $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
//             $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
//             $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
//             $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
//             $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
//             $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
//             //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
//         }
        
//         $row = 24;
//         $CHR_BUDGET_CATEGORY = 'FOH5006';
//         $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
//         if($expense <> null){
//             $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
//             $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
//             $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
//             $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
//             $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
//             $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
//             $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
//             $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
//             $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
//             $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
//             $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
//             $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
//             //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
//         }
        
//         $row = 25;
//         $CHR_BUDGET_CATEGORY = 'FOH5007';
//         $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
//         if($expense <> null){
//             $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
//             $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
//             $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
//             $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
//             $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
//             $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
//             $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
//             $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
//             $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
//             $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
//             $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
//             $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
//             //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
//         }
        
//         $row = 26;
//         $CHR_BUDGET_CATEGORY = 'FOH5008';
//         $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
//         if($expense <> null){
//             $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
//             $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
//             $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
//             $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
//             $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
//             $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
//             $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
//             $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
//             $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
//             $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
//             $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
//             $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
//             //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
//         }
        
//         $row = 27;
//         $CHR_BUDGET_CATEGORY = 'FOH5009';
//         $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
//         if($expense <> null){
//             $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
//             $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
//             $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
//             $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
//             $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
//             $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
//             $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
//             $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
//             $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
//             $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
//             $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
//             $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
//             //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
//         }
        
//         $row = 28;
//         $CHR_BUDGET_CATEGORY = 'FOH5010';
//         $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
//         if($expense <> null){
//             $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
//             $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
//             $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
//             $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
//             $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
//             $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
//             $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
//             $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
//             $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
//             $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
//             $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
//             $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
//             //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
//         }
        
//         $row = 29;
//         $CHR_BUDGET_CATEGORY = 'FOH5011';
//         $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
//         if($expense <> null){
//             $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
//             $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
//             $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
//             $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
//             $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
//             $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
//             $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
//             $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
//             $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
//             $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
//             $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
//             $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
//             //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
//         }
        
//         $row = 30;
//         $CHR_BUDGET_CATEGORY = 'FOH5012';
//         $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
//         if($expense <> null){
//             $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
//             $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
//             $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
//             $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
//             $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
//             $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
//             $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
//             $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
//             $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
//             $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
//             $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
//             $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
//             //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
//         }
        
//         $row = 31;
//         $CHR_BUDGET_CATEGORY = 'FOH5013';
//         $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
//         if($expense <> null){
//             $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
//             $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
//             $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
//             $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
//             $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
//             $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
//             $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
//             $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
//             $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
//             $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
//             $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
//             $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
//             //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
//         }
        
//         $row = 32;
//         $CHR_BUDGET_CATEGORY = 'FOH5014';
//         $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
//         if($expense <> null){
//             $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
//             $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
//             $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
//             $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
//             $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
//             $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
//             $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
//             $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
//             $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
//             $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
//             $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
//             $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
//             //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
//         }
        
//         $row = 33;
//         $CHR_BUDGET_CATEGORY = 'FOH5015';
//         $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
//         if($expense <> null){
//             $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
//             $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
//             $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
//             $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
//             $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
//             $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
//             $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
//             $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
//             $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
//             $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
//             $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
//             $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
//             //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
//         }
        
//         $row = 34;
//         $CHR_BUDGET_CATEGORY = 'FOH5016';
//         $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
//         if($expense <> null){
//             $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
//             $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
//             $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
//             $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
//             $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
//             $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
//             $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
//             $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
//             $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
//             $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
//             $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
//             $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
//             //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
//         }
        
//         $row = 35;
//         $CHR_BUDGET_CATEGORY = 'FOH5017';
//         $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
//         if($expense <> null){
//             $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
//             $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
//             $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
//             $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
//             $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
//             $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
//             $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
//             $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
//             $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
//             $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
//             $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
//             $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
//             //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
//         }
        
//         $row = 36;
//         $CHR_BUDGET_CATEGORY = 'FOH5018';
//         $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
//         if($expense <> null){
//             $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
//             $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
//             $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
//             $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
//             $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
//             $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
//             $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
//             $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
//             $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
//             $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
//             $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
//             $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
//             //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
//         }
        
//         $row = 37;
//         $CHR_BUDGET_CATEGORY = 'FOH5019';
//         $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
//         if($expense <> null){
//             $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
//             $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
//             $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
//             $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
//             $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
//             $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
//             $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
//             $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
//             $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
//             $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
//             $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
//             $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
//             //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
//         }
        
//         $row = 38;
//         $CHR_BUDGET_CATEGORY = 'FOH5020';
//         $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
//         if($expense <> null){
//             $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
//             $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
//             $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
//             $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
//             $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
//             $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
//             $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
//             $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
//             $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
//             $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
//             $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
//             $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
//             //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
//         }
        
//         $row = 39;
//         $CHR_BUDGET_CATEGORY = 'FOH5021';
//         $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
//         if($expense <> null){
//             $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
//             $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
//             $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
//             $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
//             $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
//             $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
//             $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
//             $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
//             $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
//             $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
//             $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
//             $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
//             //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
//         }
        
//         $row = 40;
//         $CHR_BUDGET_CATEGORY = 'FOH5022';
//         $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
//         if($expense <> null){
//             $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
//             $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
//             $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
//             $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
//             $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
//             $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
//             $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
//             $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
//             $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
//             $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
//             $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
//             $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
//             //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
//         }
        
//         $row = 41;
//         $CHR_BUDGET_CATEGORY = 'FOH5023';
//         $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
//         if($expense <> null){
//             $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
//             $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
//             $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
//             $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
//             $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
//             $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
//             $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
//             $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
//             $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
//             $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
//             $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
//             $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
//             //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
//         }
        
//         $row = 42;
//         $CHR_BUDGET_CATEGORY = 'FOH5024';
//         $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
//         if($expense <> null){
//             $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
//             $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
//             $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
//             $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
//             $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
//             $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
//             $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
//             $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
//             $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
//             $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
//             $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
//             $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
//             //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
//         }
        
//         $row = 43;
//         $CHR_BUDGET_CATEGORY = 'FOH5025';
//         $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
//         if($expense <> null){
//             $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
//             $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
//             $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
//             $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
//             $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
//             $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
//             $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
//             $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
//             $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
//             $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
//             $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
//             $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
//             //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
//         }
// //=============================== END OF FOH =================================//
        
// //========================== GET CATEGORY OPEX ===============================//
//         $row = 53;
//         $CHR_BUDGET_CATEGORY = 'OPX6001';
//         $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
//         if($expense <> null){
//             $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
//             $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
//             $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
//             $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
//             $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
//             $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
//             $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
//             $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
//             $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
//             $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
//             $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
//             $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
//             //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
//         }
        
//         $row = 54;
//         $CHR_BUDGET_CATEGORY = 'OPX6002';
//         $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
//         if($expense <> null){
//             $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
//             $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
//             $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
//             $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
//             $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
//             $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
//             $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
//             $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
//             $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
//             $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
//             $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
//             $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
//             //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
//         }
        
//         $row = 55;
//         $CHR_BUDGET_CATEGORY = 'OPX6003';
//         $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
//         if($expense <> null){
//             $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
//             $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
//             $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
//             $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
//             $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
//             $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
//             $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
//             $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
//             $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
//             $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
//             $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
//             $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
//             //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
//         }
        
//         $row = 56;
//         $CHR_BUDGET_CATEGORY = 'OPX6004';
//         $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
//         if($expense <> null){
//             $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
//             $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
//             $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
//             $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
//             $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
//             $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
//             $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
//             $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
//             $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
//             $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
//             $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
//             $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
//             //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
//         }
        
//         $row = 57;
//         $CHR_BUDGET_CATEGORY = 'OPX6005';
//         $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
//         if($expense <> null){
//             $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
//             $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
//             $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
//             $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
//             $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
//             $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
//             $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
//             $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
//             $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
//             $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
//             $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
//             $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
//             //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
//         }
        
//         $row = 58;
//         $CHR_BUDGET_CATEGORY = 'OPX6006';
//         $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
//         if($expense <> null){
//             $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
//             $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
//             $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
//             $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
//             $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
//             $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
//             $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
//             $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
//             $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
//             $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
//             $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
//             $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
//             //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
//         }
        
//         $row = 59;
//         $CHR_BUDGET_CATEGORY = 'OPX6007';
//         $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
//         if($expense <> null){
//             $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
//             $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
//             $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
//             $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
//             $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
//             $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
//             $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
//             $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
//             $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
//             $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
//             $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
//             $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
//             //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
//         }
        
//         $row = 60;
//         $CHR_BUDGET_CATEGORY = 'OPX6008';
//         $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
//         if($expense <> null){
//             $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
//             $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
//             $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
//             $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
//             $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
//             $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
//             $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
//             $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
//             $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
//             $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
//             $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
//             $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
//             //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
//         }
        
//         $row = 61;
//         $CHR_BUDGET_CATEGORY = 'OPX6009';
//         $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
//         if($expense <> null){
//             $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
//             $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
//             $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
//             $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
//             $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
//             $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
//             $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
//             $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
//             $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
//             $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
//             $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
//             $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
//             //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
//         }
        
//         $row = 62;
//         $CHR_BUDGET_CATEGORY = 'OPX6010';
//         $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
//         if($expense <> null){
//             $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
//             $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
//             $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
//             $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
//             $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
//             $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
//             $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
//             $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
//             $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
//             $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
//             $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
//             $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
//             //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
//         }
        
//         $row = 63;
//         $CHR_BUDGET_CATEGORY = 'OPX6011';
//         $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
//         if($expense <> null){
//             $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
//             $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
//             $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
//             $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
//             $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
//             $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
//             $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
//             $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
//             $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
//             $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
//             $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
//             $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
//             //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
//         }
        
//         $row = 64;
//         $CHR_BUDGET_CATEGORY = 'OPX6012';
//         $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
//         if($expense <> null){
//             $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
//             $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
//             $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
//             $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
//             $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
//             $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
//             $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
//             $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
//             $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
//             $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
//             $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
//             $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
//             //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
//         }
        
//         $row = 65;
//         $CHR_BUDGET_CATEGORY = 'OPX6013';
//         $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
//         if($expense <> null){
//             $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
//             $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
//             $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
//             $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
//             $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
//             $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
//             $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
//             $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
//             $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
//             $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
//             $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
//             $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
//             //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
//         }
        
//         $row = 66;
//         $CHR_BUDGET_CATEGORY = 'OPX6014';
//         $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
//         if($expense <> null){
//             $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
//             $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
//             $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
//             $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
//             $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
//             $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
//             $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
//             $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
//             $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
//             $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
//             $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
//             $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
//             //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
//         }
        
//         $row = 67;
//         $CHR_BUDGET_CATEGORY = 'OPX6015';
//         $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
//         if($expense <> null){
//             $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
//             $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
//             $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
//             $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
//             $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
//             $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
//             $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
//             $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
//             $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
//             $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
//             $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
//             $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
//             //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
//         }
        
//         $row = 68;
//         $CHR_BUDGET_CATEGORY = 'OPX6016';
//         $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
//         if($expense <> null){
//             $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
//             $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
//             $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
//             $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
//             $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
//             $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
//             $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
//             $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
//             $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
//             $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
//             $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
//             $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
//             //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
//         }
        
//         $row = 69;
//         $CHR_BUDGET_CATEGORY = 'OPX6017';
//         $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
//         if($expense <> null){
//             $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
//             $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
//             $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
//             $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
//             $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
//             $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
//             $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
//             $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
//             $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
//             $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
//             $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
//             $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
//             //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
//         }
        
//         $row = 70;
//         $CHR_BUDGET_CATEGORY = 'OPX6018';
//         $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
//         if($expense <> null){
//             $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
//             $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
//             $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
//             $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
//             $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
//             $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
//             $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
//             $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
//             $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
//             $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
//             $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
//             $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
//             //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
//         }
        
//         $row = 71;
//         $CHR_BUDGET_CATEGORY = 'OPX6019';
//         $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
//         if($expense <> null){
//             $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
//             $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
//             $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
//             $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
//             $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
//             $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
//             $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
//             $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
//             $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
//             $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
//             $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
//             $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
//             //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
//         }
        
//         $row = 72;
//         $CHR_BUDGET_CATEGORY = 'OPX6020';
//         $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
//         if($expense <> null){
//             $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
//             $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
//             $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
//             $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
//             $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
//             $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
//             $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
//             $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
//             $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
//             $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
//             $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
//             $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
//             //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
//         }
        
//         $row = 73;
//         $CHR_BUDGET_CATEGORY = 'OPX6021';
//         $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
//         if($expense <> null){
//             $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
//             $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
//             $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
//             $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
//             $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
//             $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
//             $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
//             $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
//             $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
//             $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
//             $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
//             $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
//             //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
//         }
        
//         $row = 74;
//         $CHR_BUDGET_CATEGORY = 'OPX6022';
//         $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
//         if($expense <> null){
//             $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
//             $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
//             $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
//             $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
//             $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
//             $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
//             $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
//             $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
//             $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
//             $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
//             $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
//             $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
//             //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
//         }
        
//         $row = 75;
//         $CHR_BUDGET_CATEGORY = 'OPX6023';
//         $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
//         if($expense <> null){
//             $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
//             $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
//             $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
//             $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
//             $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
//             $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
//             $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
//             $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
//             $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
//             $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
//             $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
//             $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
//             //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
//         }
        
//         $row = 76;
//         $CHR_BUDGET_CATEGORY = 'OPX6024';
//         $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
//         if($expense <> null){
//             $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
//             $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
//             $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
//             $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
//             $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
//             $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
//             $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
//             $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
//             $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
//             $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
//             $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
//             $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
//             //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
//         }
        
//         $row = 77;
//         $CHR_BUDGET_CATEGORY = 'OPX6025';
//         $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
//         if($expense <> null){
//             $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
//             $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
//             $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
//             $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
//             $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
//             $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
//             $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
//             $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
//             $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
//             $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
//             $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
//             $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
//             //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
//         }
// //=============================== END OF OPEX =================================//
        
// //========================= GET OTHER INCOME =================================//
//         $row = 83;
//         $CHR_BUDGET_CATEGORY = 'NON7049';
//         $nopin = $this->report_budget_plan_m->get_nopin_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
//         if($nopin <> null){
//             $objPHPExcel->getActiveSheet()->setCellValue("F$row", $nopin->MON_AMT_BLN04);
//             $objPHPExcel->getActiveSheet()->setCellValue("G$row", $nopin->MON_AMT_BLN05);
//             $objPHPExcel->getActiveSheet()->setCellValue("H$row", $nopin->MON_AMT_BLN06);
//             $objPHPExcel->getActiveSheet()->setCellValue("I$row", $nopin->MON_AMT_BLN07);
//             $objPHPExcel->getActiveSheet()->setCellValue("J$row", $nopin->MON_AMT_BLN08);
//             $objPHPExcel->getActiveSheet()->setCellValue("K$row", $nopin->MON_AMT_BLN09);
//             $objPHPExcel->getActiveSheet()->setCellValue("L$row", $nopin->MON_AMT_BLN10);
//             $objPHPExcel->getActiveSheet()->setCellValue("M$row", $nopin->MON_AMT_BLN11);
//             $objPHPExcel->getActiveSheet()->setCellValue("N$row", $nopin->MON_AMT_BLN12);
//             $objPHPExcel->getActiveSheet()->setCellValue("O$row", $nopin->MON_AMT_BLN01);
//             $objPHPExcel->getActiveSheet()->setCellValue("P$row", $nopin->MON_AMT_BLN02);
//             $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $nopin->MON_AMT_BLN03);
//             //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $nopin->MON_AMT_SUM);
//         }
        
// //========================== GET SALES TOOLING AII ===========================//
//         $row = 88;
//         $CHR_BUDGET_CATEGORY = 'SAL3003';
//         $sales = $this->report_budget_plan_m->get_sales_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
//         if($sales <> null){  
//             $objPHPExcel->getActiveSheet()->setCellValue("F$row", $sales->MON_AMT_BLN04);
//             $objPHPExcel->getActiveSheet()->setCellValue("G$row", $sales->MON_AMT_BLN05);
//             $objPHPExcel->getActiveSheet()->setCellValue("H$row", $sales->MON_AMT_BLN06);
//             $objPHPExcel->getActiveSheet()->setCellValue("I$row", $sales->MON_AMT_BLN07);
//             $objPHPExcel->getActiveSheet()->setCellValue("J$row", $sales->MON_AMT_BLN08);
//             $objPHPExcel->getActiveSheet()->setCellValue("K$row", $sales->MON_AMT_BLN09);
//             $objPHPExcel->getActiveSheet()->setCellValue("L$row", $sales->MON_AMT_BLN10);
//             $objPHPExcel->getActiveSheet()->setCellValue("M$row", $sales->MON_AMT_BLN11);
//             $objPHPExcel->getActiveSheet()->setCellValue("N$row", $sales->MON_AMT_BLN12);
//             $objPHPExcel->getActiveSheet()->setCellValue("O$row", $sales->MON_AMT_BLN01);
//             $objPHPExcel->getActiveSheet()->setCellValue("P$row", $sales->MON_AMT_BLN02);
//             $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $sales->MON_AMT_BLN03);
//             //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $sales->MON_AMT_SUM);
//         } 
        
// //========================== GET COST TOOLING AII ============================//
//         $row = 89;
//         $CHR_BUDGET_CATEGORY = 'DMA4005';
//         $dimat = $this->report_budget_plan_m->get_dimat_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
//         if($dimat <> null){           
//             $objPHPExcel->getActiveSheet()->setCellValue("F$row", $dimat->MON_AMT_BLN04);
//             $objPHPExcel->getActiveSheet()->setCellValue("G$row", $dimat->MON_AMT_BLN05);
//             $objPHPExcel->getActiveSheet()->setCellValue("H$row", $dimat->MON_AMT_BLN06);
//             $objPHPExcel->getActiveSheet()->setCellValue("I$row", $dimat->MON_AMT_BLN07);
//             $objPHPExcel->getActiveSheet()->setCellValue("J$row", $dimat->MON_AMT_BLN08);
//             $objPHPExcel->getActiveSheet()->setCellValue("K$row", $dimat->MON_AMT_BLN09);
//             $objPHPExcel->getActiveSheet()->setCellValue("L$row", $dimat->MON_AMT_BLN10);
//             $objPHPExcel->getActiveSheet()->setCellValue("M$row", $dimat->MON_AMT_BLN11);
//             $objPHPExcel->getActiveSheet()->setCellValue("N$row", $dimat->MON_AMT_BLN12);
//             $objPHPExcel->getActiveSheet()->setCellValue("O$row", $dimat->MON_AMT_BLN01);
//             $objPHPExcel->getActiveSheet()->setCellValue("P$row", $dimat->MON_AMT_BLN02);
//             $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $dimat->MON_AMT_BLN03);
//             //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $dimat->MON_AMT_SUM);
//         }
        
// //========================== GET SALES PRODUCT AIIA ==========================//
//         $row = 95;
//         $CHR_BUDGET_CATEGORY = 'SAL3002';
//         $sales = $this->report_budget_plan_m->get_sales_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
//         if($sales <> null){  
//             $objPHPExcel->getActiveSheet()->setCellValue("F$row", $sales->MON_AMT_BLN04);
//             $objPHPExcel->getActiveSheet()->setCellValue("G$row", $sales->MON_AMT_BLN05);
//             $objPHPExcel->getActiveSheet()->setCellValue("H$row", $sales->MON_AMT_BLN06);
//             $objPHPExcel->getActiveSheet()->setCellValue("I$row", $sales->MON_AMT_BLN07);
//             $objPHPExcel->getActiveSheet()->setCellValue("J$row", $sales->MON_AMT_BLN08);
//             $objPHPExcel->getActiveSheet()->setCellValue("K$row", $sales->MON_AMT_BLN09);
//             $objPHPExcel->getActiveSheet()->setCellValue("L$row", $sales->MON_AMT_BLN10);
//             $objPHPExcel->getActiveSheet()->setCellValue("M$row", $sales->MON_AMT_BLN11);
//             $objPHPExcel->getActiveSheet()->setCellValue("N$row", $sales->MON_AMT_BLN12);
//             $objPHPExcel->getActiveSheet()->setCellValue("O$row", $sales->MON_AMT_BLN01);
//             $objPHPExcel->getActiveSheet()->setCellValue("P$row", $sales->MON_AMT_BLN02);
//             $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $sales->MON_AMT_BLN03);
//             //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $sales->MON_AMT_SUM);
//         } 
        
// //========================= GET COST PASSTHRU AIIA ===========================//
//         $row = 96;
//         $CHR_BUDGET_CATEGORY = 'DMA4006';
//         $dimat = $this->report_budget_plan_m->get_dimat_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
//         if($dimat <> null){           
//             $objPHPExcel->getActiveSheet()->setCellValue("F$row", $dimat->MON_AMT_BLN04);
//             $objPHPExcel->getActiveSheet()->setCellValue("G$row", $dimat->MON_AMT_BLN05);
//             $objPHPExcel->getActiveSheet()->setCellValue("H$row", $dimat->MON_AMT_BLN06);
//             $objPHPExcel->getActiveSheet()->setCellValue("I$row", $dimat->MON_AMT_BLN07);
//             $objPHPExcel->getActiveSheet()->setCellValue("J$row", $dimat->MON_AMT_BLN08);
//             $objPHPExcel->getActiveSheet()->setCellValue("K$row", $dimat->MON_AMT_BLN09);
//             $objPHPExcel->getActiveSheet()->setCellValue("L$row", $dimat->MON_AMT_BLN10);
//             $objPHPExcel->getActiveSheet()->setCellValue("M$row", $dimat->MON_AMT_BLN11);
//             $objPHPExcel->getActiveSheet()->setCellValue("N$row", $dimat->MON_AMT_BLN12);
//             $objPHPExcel->getActiveSheet()->setCellValue("O$row", $dimat->MON_AMT_BLN01);
//             $objPHPExcel->getActiveSheet()->setCellValue("P$row", $dimat->MON_AMT_BLN02);
//             $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $dimat->MON_AMT_BLN03);
//             //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $dimat->MON_AMT_SUM);
//         }
        
// //========================== GET SALES TOOLING AIIA ==========================//
//         $row = 102;
//         $CHR_BUDGET_CATEGORY = 'SAL3004';
//         $sales = $this->report_budget_plan_m->get_sales_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
//         if($sales <> null){  
//             $objPHPExcel->getActiveSheet()->setCellValue("F$row", $sales->MON_AMT_BLN04);
//             $objPHPExcel->getActiveSheet()->setCellValue("G$row", $sales->MON_AMT_BLN05);
//             $objPHPExcel->getActiveSheet()->setCellValue("H$row", $sales->MON_AMT_BLN06);
//             $objPHPExcel->getActiveSheet()->setCellValue("I$row", $sales->MON_AMT_BLN07);
//             $objPHPExcel->getActiveSheet()->setCellValue("J$row", $sales->MON_AMT_BLN08);
//             $objPHPExcel->getActiveSheet()->setCellValue("K$row", $sales->MON_AMT_BLN09);
//             $objPHPExcel->getActiveSheet()->setCellValue("L$row", $sales->MON_AMT_BLN10);
//             $objPHPExcel->getActiveSheet()->setCellValue("M$row", $sales->MON_AMT_BLN11);
//             $objPHPExcel->getActiveSheet()->setCellValue("N$row", $sales->MON_AMT_BLN12);
//             $objPHPExcel->getActiveSheet()->setCellValue("O$row", $sales->MON_AMT_BLN01);
//             $objPHPExcel->getActiveSheet()->setCellValue("P$row", $sales->MON_AMT_BLN02);
//             $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $sales->MON_AMT_BLN03);
//             //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $sales->MON_AMT_SUM);
//         } 
        
// //========================= GET COST TOOLING AIIA ============================//
//         $row = 103;
//         $CHR_BUDGET_CATEGORY = 'DMA4007';
//         $dimat = $this->report_budget_plan_m->get_dimat_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
//         if($dimat <> null){           
//             $objPHPExcel->getActiveSheet()->setCellValue("F$row", $dimat->MON_AMT_BLN04);
//             $objPHPExcel->getActiveSheet()->setCellValue("G$row", $dimat->MON_AMT_BLN05);
//             $objPHPExcel->getActiveSheet()->setCellValue("H$row", $dimat->MON_AMT_BLN06);
//             $objPHPExcel->getActiveSheet()->setCellValue("I$row", $dimat->MON_AMT_BLN07);
//             $objPHPExcel->getActiveSheet()->setCellValue("J$row", $dimat->MON_AMT_BLN08);
//             $objPHPExcel->getActiveSheet()->setCellValue("K$row", $dimat->MON_AMT_BLN09);
//             $objPHPExcel->getActiveSheet()->setCellValue("L$row", $dimat->MON_AMT_BLN10);
//             $objPHPExcel->getActiveSheet()->setCellValue("M$row", $dimat->MON_AMT_BLN11);
//             $objPHPExcel->getActiveSheet()->setCellValue("N$row", $dimat->MON_AMT_BLN12);
//             $objPHPExcel->getActiveSheet()->setCellValue("O$row", $dimat->MON_AMT_BLN01);
//             $objPHPExcel->getActiveSheet()->setCellValue("P$row", $dimat->MON_AMT_BLN02);
//             $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $dimat->MON_AMT_BLN03);
//             //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $dimat->MON_AMT_SUM);
//         }
        
// //======================= GET NON OPERATING INCOME ===========================//
//         $row = 110;
//         $CHR_BUDGET_CATEGORY = 'NON7010';
//         $nopin = $this->report_budget_plan_m->get_nopin_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
//         if($nopin <> null){
//             $objPHPExcel->getActiveSheet()->setCellValue("F$row", $nopin->MON_AMT_BLN04);
//             $objPHPExcel->getActiveSheet()->setCellValue("G$row", $nopin->MON_AMT_BLN05);
//             $objPHPExcel->getActiveSheet()->setCellValue("H$row", $nopin->MON_AMT_BLN06);
//             $objPHPExcel->getActiveSheet()->setCellValue("I$row", $nopin->MON_AMT_BLN07);
//             $objPHPExcel->getActiveSheet()->setCellValue("J$row", $nopin->MON_AMT_BLN08);
//             $objPHPExcel->getActiveSheet()->setCellValue("K$row", $nopin->MON_AMT_BLN09);
//             $objPHPExcel->getActiveSheet()->setCellValue("L$row", $nopin->MON_AMT_BLN10);
//             $objPHPExcel->getActiveSheet()->setCellValue("M$row", $nopin->MON_AMT_BLN11);
//             $objPHPExcel->getActiveSheet()->setCellValue("N$row", $nopin->MON_AMT_BLN12);
//             $objPHPExcel->getActiveSheet()->setCellValue("O$row", $nopin->MON_AMT_BLN01);
//             $objPHPExcel->getActiveSheet()->setCellValue("P$row", $nopin->MON_AMT_BLN02);
//             $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $nopin->MON_AMT_BLN03);
//             //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $nopin->MON_AMT_SUM);
//         }
        
//         $row = 111;
//         $CHR_BUDGET_CATEGORY = 'NON7030';
//         $nopin = $this->report_budget_plan_m->get_nopin_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
//         if($nopin <> null){
//             $objPHPExcel->getActiveSheet()->setCellValue("F$row", $nopin->MON_AMT_BLN04);
//             $objPHPExcel->getActiveSheet()->setCellValue("G$row", $nopin->MON_AMT_BLN05);
//             $objPHPExcel->getActiveSheet()->setCellValue("H$row", $nopin->MON_AMT_BLN06);
//             $objPHPExcel->getActiveSheet()->setCellValue("I$row", $nopin->MON_AMT_BLN07);
//             $objPHPExcel->getActiveSheet()->setCellValue("J$row", $nopin->MON_AMT_BLN08);
//             $objPHPExcel->getActiveSheet()->setCellValue("K$row", $nopin->MON_AMT_BLN09);
//             $objPHPExcel->getActiveSheet()->setCellValue("L$row", $nopin->MON_AMT_BLN10);
//             $objPHPExcel->getActiveSheet()->setCellValue("M$row", $nopin->MON_AMT_BLN11);
//             $objPHPExcel->getActiveSheet()->setCellValue("N$row", $nopin->MON_AMT_BLN12);
//             $objPHPExcel->getActiveSheet()->setCellValue("O$row", $nopin->MON_AMT_BLN01);
//             $objPHPExcel->getActiveSheet()->setCellValue("P$row", $nopin->MON_AMT_BLN02);
//             $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $nopin->MON_AMT_BLN03);
//             //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $nopin->MON_AMT_SUM);
//         }
        
//         $row = 112;
//         $CHR_BUDGET_CATEGORY = 'NON8010';
//         $nopin = $this->report_budget_plan_m->get_nopin_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
//         if($nopin <> null){
//             $objPHPExcel->getActiveSheet()->setCellValue("F$row", $nopin->MON_AMT_BLN04);
//             $objPHPExcel->getActiveSheet()->setCellValue("G$row", $nopin->MON_AMT_BLN05);
//             $objPHPExcel->getActiveSheet()->setCellValue("H$row", $nopin->MON_AMT_BLN06);
//             $objPHPExcel->getActiveSheet()->setCellValue("I$row", $nopin->MON_AMT_BLN07);
//             $objPHPExcel->getActiveSheet()->setCellValue("J$row", $nopin->MON_AMT_BLN08);
//             $objPHPExcel->getActiveSheet()->setCellValue("K$row", $nopin->MON_AMT_BLN09);
//             $objPHPExcel->getActiveSheet()->setCellValue("L$row", $nopin->MON_AMT_BLN10);
//             $objPHPExcel->getActiveSheet()->setCellValue("M$row", $nopin->MON_AMT_BLN11);
//             $objPHPExcel->getActiveSheet()->setCellValue("N$row", $nopin->MON_AMT_BLN12);
//             $objPHPExcel->getActiveSheet()->setCellValue("O$row", $nopin->MON_AMT_BLN01);
//             $objPHPExcel->getActiveSheet()->setCellValue("P$row", $nopin->MON_AMT_BLN02);
//             $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $nopin->MON_AMT_BLN03);
//             //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $nopin->MON_AMT_SUM);
//         }
        
//         $row = 113;
//         $CHR_BUDGET_CATEGORY = 'NON8020';
//         $nopin = $this->report_budget_plan_m->get_nopin_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
//         if($nopin <> null){
//             $objPHPExcel->getActiveSheet()->setCellValue("F$row", $nopin->MON_AMT_BLN04);
//             $objPHPExcel->getActiveSheet()->setCellValue("G$row", $nopin->MON_AMT_BLN05);
//             $objPHPExcel->getActiveSheet()->setCellValue("H$row", $nopin->MON_AMT_BLN06);
//             $objPHPExcel->getActiveSheet()->setCellValue("I$row", $nopin->MON_AMT_BLN07);
//             $objPHPExcel->getActiveSheet()->setCellValue("J$row", $nopin->MON_AMT_BLN08);
//             $objPHPExcel->getActiveSheet()->setCellValue("K$row", $nopin->MON_AMT_BLN09);
//             $objPHPExcel->getActiveSheet()->setCellValue("L$row", $nopin->MON_AMT_BLN10);
//             $objPHPExcel->getActiveSheet()->setCellValue("M$row", $nopin->MON_AMT_BLN11);
//             $objPHPExcel->getActiveSheet()->setCellValue("N$row", $nopin->MON_AMT_BLN12);
//             $objPHPExcel->getActiveSheet()->setCellValue("O$row", $nopin->MON_AMT_BLN01);
//             $objPHPExcel->getActiveSheet()->setCellValue("P$row", $nopin->MON_AMT_BLN02);
//             $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $nopin->MON_AMT_BLN03);
//             //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $nopin->MON_AMT_SUM);
//         }
// //======================= END OF NON OPERATING INCOME ========================//
        
// //================================= GET TAX ==================================//
//         $row = 120;
//         $CHR_BUDGET_CATEGORY = 'TAX8801';
//         $tax = $this->report_budget_plan_m->get_tax_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
//         if($tax <> null){
//             $objPHPExcel->getActiveSheet()->setCellValue("F$row", $tax->MON_AMT_BLN04);
//             $objPHPExcel->getActiveSheet()->setCellValue("G$row", $tax->MON_AMT_BLN05);
//             $objPHPExcel->getActiveSheet()->setCellValue("H$row", $tax->MON_AMT_BLN06);
//             $objPHPExcel->getActiveSheet()->setCellValue("I$row", $tax->MON_AMT_BLN07);
//             $objPHPExcel->getActiveSheet()->setCellValue("J$row", $tax->MON_AMT_BLN08);
//             $objPHPExcel->getActiveSheet()->setCellValue("K$row", $tax->MON_AMT_BLN09);
//             $objPHPExcel->getActiveSheet()->setCellValue("L$row", $tax->MON_AMT_BLN10);
//             $objPHPExcel->getActiveSheet()->setCellValue("M$row", $tax->MON_AMT_BLN11);
//             $objPHPExcel->getActiveSheet()->setCellValue("N$row", $tax->MON_AMT_BLN12);
//             $objPHPExcel->getActiveSheet()->setCellValue("O$row", $tax->MON_AMT_BLN01);
//             $objPHPExcel->getActiveSheet()->setCellValue("P$row", $tax->MON_AMT_BLN02);
//             $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $tax->MON_AMT_BLN03);
//             //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $tax->MON_AMT_SUM);
//         }
        
//         $row = 121;
//         $CHR_BUDGET_CATEGORY = 'TAX8803';
//         $tax = $this->report_budget_plan_m->get_tax_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
//         if($tax <> null){
//             $objPHPExcel->getActiveSheet()->setCellValue("F$row", $tax->MON_AMT_BLN04);
//             $objPHPExcel->getActiveSheet()->setCellValue("G$row", $tax->MON_AMT_BLN05);
//             $objPHPExcel->getActiveSheet()->setCellValue("H$row", $tax->MON_AMT_BLN06);
//             $objPHPExcel->getActiveSheet()->setCellValue("I$row", $tax->MON_AMT_BLN07);
//             $objPHPExcel->getActiveSheet()->setCellValue("J$row", $tax->MON_AMT_BLN08);
//             $objPHPExcel->getActiveSheet()->setCellValue("K$row", $tax->MON_AMT_BLN09);
//             $objPHPExcel->getActiveSheet()->setCellValue("L$row", $tax->MON_AMT_BLN10);
//             $objPHPExcel->getActiveSheet()->setCellValue("M$row", $tax->MON_AMT_BLN11);
//             $objPHPExcel->getActiveSheet()->setCellValue("N$row", $tax->MON_AMT_BLN12);
//             $objPHPExcel->getActiveSheet()->setCellValue("O$row", $tax->MON_AMT_BLN01);
//             $objPHPExcel->getActiveSheet()->setCellValue("P$row", $tax->MON_AMT_BLN02);
//             $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $tax->MON_AMT_BLN03);
//             //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $tax->MON_AMT_SUM);
//         }
// //================================= END TAX ==================================//        
        
//         $row = 127;

//         $gdImage = imagecreatefromjpeg('assets/template/budget/report/approval.JPG');
//         // Add a drawing to the worksheetecho date('H:i:s') . " Add a drawing to the worksheet\n";
//         $objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
//         $objDrawing->setName('Sample image');
//         $objDrawing->setDescription('Sample image');
//         $objDrawing->setImageResource($gdImage);
//         $objDrawing->setRenderingFunction(PHPExcel_Worksheet_MemoryDrawing::RENDERING_JPEG);
//         $objDrawing->setMimeType(PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_DEFAULT);
//         $objDrawing->setHeight(105);
//         $objDrawing->setCoordinates("O$row");
//         $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());

//         ob_end_clean();
//         $filename = "REPORT PROFIT & LOSS BY FOH OPEX - BUDGET $INT_ID_FISCAL_YEAR .xls";
//         header('Content-Type: application/vnd.ms-excel');
//         header('Content-Disposition: attachment;filename="' . trim($filename) . '"');
//         header('Cache-Control: max-age=0');

//         $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
//         $objWriter->setIncludeCharts(TRUE);
//         $objWriter->save('php://output');
//     }
    
//     function download_format_a3($INT_ID_FISCAL_YEAR = null) {   
//         $this->load->library('excel');
//         $objReader = PHPExcel_IOFactory::createReader('Excel5');
        
// //====== Create new PHPExcel object
//         $objPHPExcel = $objReader->load("assets/template/budget/report/Template_Report_Profit_Loss_A3.xls");
     
//         $objPHPExcel->getActiveSheet()->setCellValue("B3", "PROFIT/LOSS MASTER BUDGET TAHUN : " . $INT_ID_FISCAL_YEAR . " - BY CATEGORY A3");
//         $CHR_BUDGET_CATEGORY = "";
        
// //========================== GET SALES PRODUCT AII ===========================//
//         $row = 7;
//         $CHR_BUDGET_CATEGORY = 'SAL3001';
//         $sales = $this->report_budget_plan_m->get_sales_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
//         if($sales <> null){  
//             $objPHPExcel->getActiveSheet()->setCellValue("F$row", $sales->MON_AMT_BLN04);
//             $objPHPExcel->getActiveSheet()->setCellValue("G$row", $sales->MON_AMT_BLN05);
//             $objPHPExcel->getActiveSheet()->setCellValue("H$row", $sales->MON_AMT_BLN06);
//             $objPHPExcel->getActiveSheet()->setCellValue("I$row", $sales->MON_AMT_BLN07);
//             $objPHPExcel->getActiveSheet()->setCellValue("J$row", $sales->MON_AMT_BLN08);
//             $objPHPExcel->getActiveSheet()->setCellValue("K$row", $sales->MON_AMT_BLN09);
//             $objPHPExcel->getActiveSheet()->setCellValue("L$row", $sales->MON_AMT_BLN10);
//             $objPHPExcel->getActiveSheet()->setCellValue("M$row", $sales->MON_AMT_BLN11);
//             $objPHPExcel->getActiveSheet()->setCellValue("N$row", $sales->MON_AMT_BLN12);
//             $objPHPExcel->getActiveSheet()->setCellValue("O$row", $sales->MON_AMT_BLN01);
//             $objPHPExcel->getActiveSheet()->setCellValue("P$row", $sales->MON_AMT_BLN02);
//             $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $sales->MON_AMT_BLN03);
//             //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $sales->MON_AMT_SUM);
//         }        
        
// //=========================== GET DIRECT MATERIAL ============================//
//         $row = 9;
//         $CHR_BUDGET_CATEGORY = 'DMA4001';
//         $dimat = $this->report_budget_plan_m->get_dimat_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
//         if($dimat <> null){           
//             $objPHPExcel->getActiveSheet()->setCellValue("F$row", $dimat->MON_AMT_BLN04);
//             $objPHPExcel->getActiveSheet()->setCellValue("G$row", $dimat->MON_AMT_BLN05);
//             $objPHPExcel->getActiveSheet()->setCellValue("H$row", $dimat->MON_AMT_BLN06);
//             $objPHPExcel->getActiveSheet()->setCellValue("I$row", $dimat->MON_AMT_BLN07);
//             $objPHPExcel->getActiveSheet()->setCellValue("J$row", $dimat->MON_AMT_BLN08);
//             $objPHPExcel->getActiveSheet()->setCellValue("K$row", $dimat->MON_AMT_BLN09);
//             $objPHPExcel->getActiveSheet()->setCellValue("L$row", $dimat->MON_AMT_BLN10);
//             $objPHPExcel->getActiveSheet()->setCellValue("M$row", $dimat->MON_AMT_BLN11);
//             $objPHPExcel->getActiveSheet()->setCellValue("N$row", $dimat->MON_AMT_BLN12);
//             $objPHPExcel->getActiveSheet()->setCellValue("O$row", $dimat->MON_AMT_BLN01);
//             $objPHPExcel->getActiveSheet()->setCellValue("P$row", $dimat->MON_AMT_BLN02);
//             $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $dimat->MON_AMT_BLN03);
//             //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $dimat->MON_AMT_SUM);
//         }
        
//         $row = 10;
//         $CHR_BUDGET_CATEGORY = 'DMA4002';
//         $dimat = $this->report_budget_plan_m->get_dimat_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
//         if($dimat <> null){           
//             $objPHPExcel->getActiveSheet()->setCellValue("F$row", $dimat->MON_AMT_BLN04);
//             $objPHPExcel->getActiveSheet()->setCellValue("G$row", $dimat->MON_AMT_BLN05);
//             $objPHPExcel->getActiveSheet()->setCellValue("H$row", $dimat->MON_AMT_BLN06);
//             $objPHPExcel->getActiveSheet()->setCellValue("I$row", $dimat->MON_AMT_BLN07);
//             $objPHPExcel->getActiveSheet()->setCellValue("J$row", $dimat->MON_AMT_BLN08);
//             $objPHPExcel->getActiveSheet()->setCellValue("K$row", $dimat->MON_AMT_BLN09);
//             $objPHPExcel->getActiveSheet()->setCellValue("L$row", $dimat->MON_AMT_BLN10);
//             $objPHPExcel->getActiveSheet()->setCellValue("M$row", $dimat->MON_AMT_BLN11);
//             $objPHPExcel->getActiveSheet()->setCellValue("N$row", $dimat->MON_AMT_BLN12);
//             $objPHPExcel->getActiveSheet()->setCellValue("O$row", $dimat->MON_AMT_BLN01);
//             $objPHPExcel->getActiveSheet()->setCellValue("P$row", $dimat->MON_AMT_BLN02);
//             $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $dimat->MON_AMT_BLN03);
//             //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $dimat->MON_AMT_SUM);
//         }
        
//         $row = 11;
//         $CHR_BUDGET_CATEGORY = 'DMA4003';
//         $dimat = $this->report_budget_plan_m->get_dimat_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
//         if($dimat <> null){           
//             $objPHPExcel->getActiveSheet()->setCellValue("F$row", $dimat->MON_AMT_BLN04);
//             $objPHPExcel->getActiveSheet()->setCellValue("G$row", $dimat->MON_AMT_BLN05);
//             $objPHPExcel->getActiveSheet()->setCellValue("H$row", $dimat->MON_AMT_BLN06);
//             $objPHPExcel->getActiveSheet()->setCellValue("I$row", $dimat->MON_AMT_BLN07);
//             $objPHPExcel->getActiveSheet()->setCellValue("J$row", $dimat->MON_AMT_BLN08);
//             $objPHPExcel->getActiveSheet()->setCellValue("K$row", $dimat->MON_AMT_BLN09);
//             $objPHPExcel->getActiveSheet()->setCellValue("L$row", $dimat->MON_AMT_BLN10);
//             $objPHPExcel->getActiveSheet()->setCellValue("M$row", $dimat->MON_AMT_BLN11);
//             $objPHPExcel->getActiveSheet()->setCellValue("N$row", $dimat->MON_AMT_BLN12);
//             $objPHPExcel->getActiveSheet()->setCellValue("O$row", $dimat->MON_AMT_BLN01);
//             $objPHPExcel->getActiveSheet()->setCellValue("P$row", $dimat->MON_AMT_BLN02);
//             $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $dimat->MON_AMT_BLN03);
//             //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $dimat->MON_AMT_SUM);
//         }
        
//         $row = 12;
//         $CHR_BUDGET_CATEGORY = 'DMA4004';
//         $dimat = $this->report_budget_plan_m->get_dimat_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
//         if($dimat <> null){           
//             $objPHPExcel->getActiveSheet()->setCellValue("F$row", $dimat->MON_AMT_BLN04);
//             $objPHPExcel->getActiveSheet()->setCellValue("G$row", $dimat->MON_AMT_BLN05);
//             $objPHPExcel->getActiveSheet()->setCellValue("H$row", $dimat->MON_AMT_BLN06);
//             $objPHPExcel->getActiveSheet()->setCellValue("I$row", $dimat->MON_AMT_BLN07);
//             $objPHPExcel->getActiveSheet()->setCellValue("J$row", $dimat->MON_AMT_BLN08);
//             $objPHPExcel->getActiveSheet()->setCellValue("K$row", $dimat->MON_AMT_BLN09);
//             $objPHPExcel->getActiveSheet()->setCellValue("L$row", $dimat->MON_AMT_BLN10);
//             $objPHPExcel->getActiveSheet()->setCellValue("M$row", $dimat->MON_AMT_BLN11);
//             $objPHPExcel->getActiveSheet()->setCellValue("N$row", $dimat->MON_AMT_BLN12);
//             $objPHPExcel->getActiveSheet()->setCellValue("O$row", $dimat->MON_AMT_BLN01);
//             $objPHPExcel->getActiveSheet()->setCellValue("P$row", $dimat->MON_AMT_BLN02);
//             $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $dimat->MON_AMT_BLN03);
//             //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $dimat->MON_AMT_SUM);
//         }
        
// //========================= GET VARIABLE COST ================================//
//         $row = 16;
//         $CHR_BUDGET_CATEGORY = 'FOH5001';
//         $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
//         if($expense <> null){
//             $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
//             $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
//             $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
//             $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
//             $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
//             $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
//             $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
//             $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
//             $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
//             $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
//             $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
//             $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
//             //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
//         } 
        
//         $row = 17;
//         $CHR_BUDGET_CATEGORY = 'FOH5002';
//         $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
//         if($expense <> null){
//             $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
//             $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
//             $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
//             $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
//             $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
//             $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
//             $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
//             $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
//             $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
//             $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
//             $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
//             $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
//             //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
//         }
        
//         $row = 18;
//         $CHR_BUDGET_CATEGORY = 'FOH5003';
//         $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
//         if($expense <> null){
//             $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
//             $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
//             $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
//             $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
//             $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
//             $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
//             $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
//             $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
//             $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
//             $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
//             $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
//             $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
//             //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
//         }

//         $row = 20;
//         $CHR_BUDGET_CATEGORY = 'FOH5004';
//         $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
//         if($expense <> null){
//             $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
//             $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
//             $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
//             $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
//             $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
//             $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
//             $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
//             $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
//             $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
//             $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
//             $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
//             $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
//             //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
//         }
        
//         $row = 21;
//         $CHR_BUDGET_CATEGORY = 'FOH5005';
//         $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
//         if($expense <> null){
//             $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
//             $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
//             $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
//             $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
//             $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
//             $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
//             $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
//             $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
//             $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
//             $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
//             $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
//             $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
//             //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
//         }
        
//         $row = 22;
//         $CHR_BUDGET_CATEGORY = 'FOH5006';
//         $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
//         if($expense <> null){
//             $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
//             $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
//             $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
//             $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
//             $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
//             $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
//             $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
//             $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
//             $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
//             $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
//             $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
//             $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
//             //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
//         }
        
//         $row = 23;
//         $CHR_BUDGET_CATEGORY = 'FOH5007';
//         $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
//         if($expense <> null){
//             $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
//             $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
//             $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
//             $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
//             $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
//             $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
//             $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
//             $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
//             $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
//             $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
//             $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
//             $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
//             //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
//         }
        
//         $row = 24;
//         $CHR_BUDGET_CATEGORY = 'FOH5008';
//         $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
//         if($expense <> null){
//             $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
//             $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
//             $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
//             $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
//             $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
//             $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
//             $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
//             $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
//             $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
//             $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
//             $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
//             $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
//             //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
//         }
        
//         $row = 25;
//         $CHR_BUDGET_CATEGORY = 'FOH5009';
//         $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
//         if($expense <> null){
//             $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
//             $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
//             $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
//             $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
//             $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
//             $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
//             $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
//             $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
//             $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
//             $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
//             $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
//             $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
//             //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
//         }
        
//         $row = 26;
//         $CHR_BUDGET_CATEGORY = 'OPX6001';
//         $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
//         if($expense <> null){
//             $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
//             $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
//             $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
//             $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
//             $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
//             $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
//             $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
//             $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
//             $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
//             $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
//             $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
//             $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
//             //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
//         }
        
//         $row = 27;
//         $CHR_BUDGET_CATEGORY = 'OPX6002';
//         $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
//         if($expense <> null){
//             $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
//             $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
//             $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
//             $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
//             $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
//             $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
//             $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
//             $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
//             $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
//             $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
//             $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
//             $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
//             //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
//         }
// //========================== END VARIABLE COST ===============================//
        
// //============================= FIXED COST ===================================//        
//         $row = 34;
//         $CHR_BUDGET_CATEGORY = 'FOH5010';
//         $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
//         if($expense <> null){
//             $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
//             $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
//             $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
//             $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
//             $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
//             $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
//             $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
//             $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
//             $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
//             $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
//             $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
//             $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
//             //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
//         }
        
//         $row = 35;
//         $CHR_BUDGET_CATEGORY = 'FOH5011';
//         $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
//         if($expense <> null){
//             $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
//             $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
//             $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
//             $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
//             $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
//             $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
//             $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
//             $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
//             $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
//             $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
//             $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
//             $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
//             //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
//         }
        
//         $row = 36;
//         $CHR_BUDGET_CATEGORY = 'FOH5012';
//         $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
//         if($expense <> null){
//             $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
//             $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
//             $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
//             $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
//             $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
//             $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
//             $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
//             $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
//             $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
//             $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
//             $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
//             $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
//             //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
//         }
        
//         $row = 37;
//         $CHR_BUDGET_CATEGORY = 'FOH5013';
//         $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
//         if($expense <> null){
//             $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
//             $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
//             $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
//             $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
//             $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
//             $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
//             $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
//             $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
//             $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
//             $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
//             $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
//             $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
//             //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
//         }
        
//         $row = 38;
//         $CHR_BUDGET_CATEGORY = 'FOH5014';
//         $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
//         if($expense <> null){
//             $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
//             $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
//             $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
//             $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
//             $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
//             $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
//             $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
//             $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
//             $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
//             $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
//             $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
//             $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
//             //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
//         }
        
//         $row = 39;
//         $CHR_BUDGET_CATEGORY = 'FOH5015';
//         $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
//         if($expense <> null){
//             $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
//             $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
//             $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
//             $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
//             $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
//             $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
//             $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
//             $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
//             $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
//             $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
//             $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
//             $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
//             //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
//         }
        
//         $row = 40;
//         $CHR_BUDGET_CATEGORY = 'FOH5016';
//         $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
//         if($expense <> null){
//             $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
//             $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
//             $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
//             $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
//             $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
//             $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
//             $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
//             $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
//             $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
//             $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
//             $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
//             $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
//             //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
//         }
        
//         $row = 41;
//         $CHR_BUDGET_CATEGORY = 'FOH5017';
//         $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
//         if($expense <> null){
//             $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
//             $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
//             $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
//             $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
//             $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
//             $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
//             $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
//             $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
//             $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
//             $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
//             $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
//             $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
//             //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
//         }
        
//         $row = 42;
//         $CHR_BUDGET_CATEGORY = 'FOH5018';
//         $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
//         if($expense <> null){
//             $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
//             $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
//             $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
//             $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
//             $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
//             $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
//             $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
//             $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
//             $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
//             $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
//             $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
//             $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
//             //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
//         }
        
//         $row = 43;
//         $CHR_BUDGET_CATEGORY = 'FOH5019';
//         $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
//         if($expense <> null){
//             $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
//             $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
//             $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
//             $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
//             $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
//             $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
//             $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
//             $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
//             $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
//             $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
//             $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
//             $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
//             //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
//         }
        
//         $row = 44;
//         $CHR_BUDGET_CATEGORY = 'FOH5020';
//         $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
//         if($expense <> null){
//             $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
//             $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
//             $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
//             $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
//             $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
//             $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
//             $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
//             $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
//             $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
//             $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
//             $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
//             $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
//             //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
//         }
        
//         $row = 45;
//         $CHR_BUDGET_CATEGORY = 'FOH5021';
//         $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
//         if($expense <> null){
//             $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
//             $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
//             $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
//             $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
//             $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
//             $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
//             $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
//             $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
//             $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
//             $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
//             $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
//             $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
//             //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
//         }
        
//         $row = 46;
//         $CHR_BUDGET_CATEGORY = 'FOH5022';
//         $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
//         if($expense <> null){
//             $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
//             $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
//             $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
//             $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
//             $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
//             $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
//             $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
//             $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
//             $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
//             $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
//             $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
//             $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
//             //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
//         }
        
//         $row = 47;
//         $CHR_BUDGET_CATEGORY = 'FOH5023';
//         $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
//         if($expense <> null){
//             $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
//             $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
//             $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
//             $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
//             $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
//             $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
//             $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
//             $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
//             $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
//             $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
//             $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
//             $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
//             //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
//         }
        
//         $row = 48;
//         $CHR_BUDGET_CATEGORY = 'FOH5024';
//         $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
//         if($expense <> null){
//             $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
//             $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
//             $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
//             $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
//             $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
//             $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
//             $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
//             $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
//             $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
//             $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
//             $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
//             $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
//             //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
//         }
        
//         $row = 49;
//         $CHR_BUDGET_CATEGORY = 'FOH5025';
//         $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
//         if($expense <> null){
//             $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
//             $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
//             $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
//             $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
//             $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
//             $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
//             $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
//             $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
//             $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
//             $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
//             $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
//             $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
//             //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
//         }
// //=============================== END OF FIXED COST ==========================//
        
// //============================= GET SGA COST =================================//
//         $row = 53;
//         $CHR_BUDGET_CATEGORY = 'OPX6003';
//         $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
//         if($expense <> null){
//             $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
//             $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
//             $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
//             $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
//             $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
//             $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
//             $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
//             $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
//             $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
//             $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
//             $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
//             $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
//             //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
//         }
        
//         $row = 54;
//         $CHR_BUDGET_CATEGORY = 'OPX6004';
//         $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
//         if($expense <> null){
//             $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
//             $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
//             $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
//             $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
//             $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
//             $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
//             $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
//             $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
//             $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
//             $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
//             $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
//             $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
//             //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
//         }
        
//         $row = 55;
//         $CHR_BUDGET_CATEGORY = 'OPX6005';
//         $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
//         if($expense <> null){
//             $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
//             $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
//             $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
//             $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
//             $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
//             $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
//             $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
//             $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
//             $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
//             $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
//             $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
//             $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
//             //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
//         }
        
//         $row = 56;
//         $CHR_BUDGET_CATEGORY = 'OPX6006';
//         $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
//         if($expense <> null){
//             $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
//             $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
//             $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
//             $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
//             $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
//             $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
//             $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
//             $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
//             $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
//             $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
//             $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
//             $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
//             //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
//         }
        
//         $row = 57;
//         $CHR_BUDGET_CATEGORY = 'OPX6007';
//         $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
//         if($expense <> null){
//             $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
//             $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
//             $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
//             $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
//             $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
//             $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
//             $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
//             $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
//             $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
//             $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
//             $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
//             $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
//             //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
//         }
        
//         $row = 58;
//         $CHR_BUDGET_CATEGORY = 'OPX6008';
//         $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
//         if($expense <> null){
//             $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
//             $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
//             $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
//             $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
//             $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
//             $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
//             $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
//             $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
//             $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
//             $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
//             $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
//             $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
//             //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
//         }
        
//         $row = 59;
//         $CHR_BUDGET_CATEGORY = 'OPX6009';
//         $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
//         if($expense <> null){
//             $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
//             $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
//             $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
//             $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
//             $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
//             $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
//             $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
//             $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
//             $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
//             $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
//             $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
//             $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
//             //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
//         }
        
//         $row = 60;
//         $CHR_BUDGET_CATEGORY = 'OPX6010';
//         $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
//         if($expense <> null){
//             $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
//             $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
//             $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
//             $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
//             $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
//             $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
//             $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
//             $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
//             $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
//             $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
//             $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
//             $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
//             //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
//         }
        
//         $row = 61;
//         $CHR_BUDGET_CATEGORY = 'OPX6011';
//         $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
//         if($expense <> null){
//             $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
//             $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
//             $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
//             $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
//             $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
//             $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
//             $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
//             $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
//             $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
//             $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
//             $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
//             $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
//             //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
//         }
        
//         $row = 62;
//         $CHR_BUDGET_CATEGORY = 'OPX6012';
//         $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
//         if($expense <> null){
//             $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
//             $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
//             $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
//             $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
//             $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
//             $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
//             $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
//             $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
//             $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
//             $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
//             $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
//             $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
//             //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
//         }
        
//         $row = 63;
//         $CHR_BUDGET_CATEGORY = 'OPX6013';
//         $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
//         if($expense <> null){
//             $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
//             $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
//             $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
//             $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
//             $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
//             $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
//             $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
//             $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
//             $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
//             $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
//             $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
//             $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
//             //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
//         }
        
//         $row = 64;
//         $CHR_BUDGET_CATEGORY = 'OPX6014';
//         $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
//         if($expense <> null){
//             $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
//             $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
//             $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
//             $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
//             $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
//             $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
//             $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
//             $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
//             $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
//             $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
//             $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
//             $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
//             //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
//         }
        
//         $row = 65;
//         $CHR_BUDGET_CATEGORY = 'OPX6015';
//         $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
//         if($expense <> null){
//             $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
//             $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
//             $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
//             $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
//             $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
//             $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
//             $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
//             $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
//             $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
//             $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
//             $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
//             $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
//             //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
//         }
        
//         $row = 66;
//         $CHR_BUDGET_CATEGORY = 'OPX6016';
//         $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
//         if($expense <> null){
//             $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
//             $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
//             $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
//             $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
//             $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
//             $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
//             $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
//             $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
//             $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
//             $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
//             $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
//             $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
//             //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
//         }
        
//         $row = 67;
//         $CHR_BUDGET_CATEGORY = 'OPX6017';
//         $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
//         if($expense <> null){
//             $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
//             $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
//             $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
//             $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
//             $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
//             $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
//             $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
//             $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
//             $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
//             $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
//             $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
//             $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
//             //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
//         }
        
//         $row = 68;
//         $CHR_BUDGET_CATEGORY = 'OPX6018';
//         $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
//         if($expense <> null){
//             $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
//             $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
//             $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
//             $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
//             $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
//             $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
//             $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
//             $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
//             $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
//             $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
//             $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
//             $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
//             //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
//         }
        
//         $row = 69;
//         $CHR_BUDGET_CATEGORY = 'OPX6019';
//         $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
//         if($expense <> null){
//             $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
//             $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
//             $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
//             $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
//             $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
//             $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
//             $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
//             $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
//             $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
//             $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
//             $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
//             $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
//             //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
//         }
        
//         $row = 70;
//         $CHR_BUDGET_CATEGORY = 'OPX6020';
//         $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
//         if($expense <> null){
//             $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
//             $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
//             $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
//             $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
//             $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
//             $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
//             $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
//             $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
//             $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
//             $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
//             $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
//             $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
//             //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
//         }
        
//         $row = 71;
//         $CHR_BUDGET_CATEGORY = 'OPX6021';
//         $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
//         if($expense <> null){
//             $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
//             $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
//             $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
//             $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
//             $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
//             $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
//             $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
//             $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
//             $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
//             $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
//             $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
//             $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
//             //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
//         }
        
//         $row = 72;
//         $CHR_BUDGET_CATEGORY = 'OPX6022';
//         $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
//         if($expense <> null){
//             $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
//             $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
//             $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
//             $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
//             $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
//             $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
//             $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
//             $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
//             $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
//             $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
//             $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
//             $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
//             //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
//         }
        
//         $row = 73;
//         $CHR_BUDGET_CATEGORY = 'OPX6023';
//         $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
//         if($expense <> null){
//             $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
//             $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
//             $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
//             $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
//             $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
//             $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
//             $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
//             $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
//             $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
//             $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
//             $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
//             $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
//             //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
//         }
        
//         $row = 74;
//         $CHR_BUDGET_CATEGORY = 'OPX6024';
//         $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
//         if($expense <> null){
//             $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
//             $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
//             $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
//             $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
//             $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
//             $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
//             $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
//             $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
//             $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
//             $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
//             $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
//             $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
//             //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
//         }
        
//         $row = 75;
//         $CHR_BUDGET_CATEGORY = 'OPX6025';
//         $expense = $this->report_budget_plan_m->get_expense_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
//         if($expense <> null){
//             $objPHPExcel->getActiveSheet()->setCellValue("F$row", $expense->MON_AMT_BLN04);
//             $objPHPExcel->getActiveSheet()->setCellValue("G$row", $expense->MON_AMT_BLN05);
//             $objPHPExcel->getActiveSheet()->setCellValue("H$row", $expense->MON_AMT_BLN06);
//             $objPHPExcel->getActiveSheet()->setCellValue("I$row", $expense->MON_AMT_BLN07);
//             $objPHPExcel->getActiveSheet()->setCellValue("J$row", $expense->MON_AMT_BLN08);
//             $objPHPExcel->getActiveSheet()->setCellValue("K$row", $expense->MON_AMT_BLN09);
//             $objPHPExcel->getActiveSheet()->setCellValue("L$row", $expense->MON_AMT_BLN10);
//             $objPHPExcel->getActiveSheet()->setCellValue("M$row", $expense->MON_AMT_BLN11);
//             $objPHPExcel->getActiveSheet()->setCellValue("N$row", $expense->MON_AMT_BLN12);
//             $objPHPExcel->getActiveSheet()->setCellValue("O$row", $expense->MON_AMT_BLN01);
//             $objPHPExcel->getActiveSheet()->setCellValue("P$row", $expense->MON_AMT_BLN02);
//             $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $expense->MON_AMT_BLN03);
//             //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $expense->MON_AMT_SUM);
//         }
// //=============================== END OF SGA COST ============================//
        
// //========================= GET OTHER INCOME =================================//
//         $row = 81;
//         $CHR_BUDGET_CATEGORY = 'NON7049';
//         $nopin = $this->report_budget_plan_m->get_nopin_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
//         if($nopin <> null){
//             $objPHPExcel->getActiveSheet()->setCellValue("F$row", $nopin->MON_AMT_BLN04);
//             $objPHPExcel->getActiveSheet()->setCellValue("G$row", $nopin->MON_AMT_BLN05);
//             $objPHPExcel->getActiveSheet()->setCellValue("H$row", $nopin->MON_AMT_BLN06);
//             $objPHPExcel->getActiveSheet()->setCellValue("I$row", $nopin->MON_AMT_BLN07);
//             $objPHPExcel->getActiveSheet()->setCellValue("J$row", $nopin->MON_AMT_BLN08);
//             $objPHPExcel->getActiveSheet()->setCellValue("K$row", $nopin->MON_AMT_BLN09);
//             $objPHPExcel->getActiveSheet()->setCellValue("L$row", $nopin->MON_AMT_BLN10);
//             $objPHPExcel->getActiveSheet()->setCellValue("M$row", $nopin->MON_AMT_BLN11);
//             $objPHPExcel->getActiveSheet()->setCellValue("N$row", $nopin->MON_AMT_BLN12);
//             $objPHPExcel->getActiveSheet()->setCellValue("O$row", $nopin->MON_AMT_BLN01);
//             $objPHPExcel->getActiveSheet()->setCellValue("P$row", $nopin->MON_AMT_BLN02);
//             $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $nopin->MON_AMT_BLN03);
//             //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $nopin->MON_AMT_SUM);
//         }
        
// //========================== GET SALES TOOLING AII ===========================//
//         $row = 86;
//         $CHR_BUDGET_CATEGORY = 'SAL3003';
//         $sales = $this->report_budget_plan_m->get_sales_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
//         if($sales <> null){  
//             $objPHPExcel->getActiveSheet()->setCellValue("F$row", $sales->MON_AMT_BLN04);
//             $objPHPExcel->getActiveSheet()->setCellValue("G$row", $sales->MON_AMT_BLN05);
//             $objPHPExcel->getActiveSheet()->setCellValue("H$row", $sales->MON_AMT_BLN06);
//             $objPHPExcel->getActiveSheet()->setCellValue("I$row", $sales->MON_AMT_BLN07);
//             $objPHPExcel->getActiveSheet()->setCellValue("J$row", $sales->MON_AMT_BLN08);
//             $objPHPExcel->getActiveSheet()->setCellValue("K$row", $sales->MON_AMT_BLN09);
//             $objPHPExcel->getActiveSheet()->setCellValue("L$row", $sales->MON_AMT_BLN10);
//             $objPHPExcel->getActiveSheet()->setCellValue("M$row", $sales->MON_AMT_BLN11);
//             $objPHPExcel->getActiveSheet()->setCellValue("N$row", $sales->MON_AMT_BLN12);
//             $objPHPExcel->getActiveSheet()->setCellValue("O$row", $sales->MON_AMT_BLN01);
//             $objPHPExcel->getActiveSheet()->setCellValue("P$row", $sales->MON_AMT_BLN02);
//             $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $sales->MON_AMT_BLN03);
//             //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $sales->MON_AMT_SUM);
//         } 
        
// //========================== GET COST TOOLING AII ============================//
//         $row = 87;
//         $CHR_BUDGET_CATEGORY = 'DMA4005';
//         $dimat = $this->report_budget_plan_m->get_dimat_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
//         if($dimat <> null){           
//             $objPHPExcel->getActiveSheet()->setCellValue("F$row", $dimat->MON_AMT_BLN04);
//             $objPHPExcel->getActiveSheet()->setCellValue("G$row", $dimat->MON_AMT_BLN05);
//             $objPHPExcel->getActiveSheet()->setCellValue("H$row", $dimat->MON_AMT_BLN06);
//             $objPHPExcel->getActiveSheet()->setCellValue("I$row", $dimat->MON_AMT_BLN07);
//             $objPHPExcel->getActiveSheet()->setCellValue("J$row", $dimat->MON_AMT_BLN08);
//             $objPHPExcel->getActiveSheet()->setCellValue("K$row", $dimat->MON_AMT_BLN09);
//             $objPHPExcel->getActiveSheet()->setCellValue("L$row", $dimat->MON_AMT_BLN10);
//             $objPHPExcel->getActiveSheet()->setCellValue("M$row", $dimat->MON_AMT_BLN11);
//             $objPHPExcel->getActiveSheet()->setCellValue("N$row", $dimat->MON_AMT_BLN12);
//             $objPHPExcel->getActiveSheet()->setCellValue("O$row", $dimat->MON_AMT_BLN01);
//             $objPHPExcel->getActiveSheet()->setCellValue("P$row", $dimat->MON_AMT_BLN02);
//             $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $dimat->MON_AMT_BLN03);
//             //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $dimat->MON_AMT_SUM);
//         }
        
// //========================== GET SALES PRODUCT AIIA ==========================//
//         $row = 93;
//         $CHR_BUDGET_CATEGORY = 'SAL3002';
//         $sales = $this->report_budget_plan_m->get_sales_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
//         if($sales <> null){  
//             $objPHPExcel->getActiveSheet()->setCellValue("F$row", $sales->MON_AMT_BLN04);
//             $objPHPExcel->getActiveSheet()->setCellValue("G$row", $sales->MON_AMT_BLN05);
//             $objPHPExcel->getActiveSheet()->setCellValue("H$row", $sales->MON_AMT_BLN06);
//             $objPHPExcel->getActiveSheet()->setCellValue("I$row", $sales->MON_AMT_BLN07);
//             $objPHPExcel->getActiveSheet()->setCellValue("J$row", $sales->MON_AMT_BLN08);
//             $objPHPExcel->getActiveSheet()->setCellValue("K$row", $sales->MON_AMT_BLN09);
//             $objPHPExcel->getActiveSheet()->setCellValue("L$row", $sales->MON_AMT_BLN10);
//             $objPHPExcel->getActiveSheet()->setCellValue("M$row", $sales->MON_AMT_BLN11);
//             $objPHPExcel->getActiveSheet()->setCellValue("N$row", $sales->MON_AMT_BLN12);
//             $objPHPExcel->getActiveSheet()->setCellValue("O$row", $sales->MON_AMT_BLN01);
//             $objPHPExcel->getActiveSheet()->setCellValue("P$row", $sales->MON_AMT_BLN02);
//             $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $sales->MON_AMT_BLN03);
//             //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $sales->MON_AMT_SUM);
//         } 
        
// //========================= GET COST PASSTHRU AIIA ===========================//
//         $row = 94;
//         $CHR_BUDGET_CATEGORY = 'DMA4006';
//         $dimat = $this->report_budget_plan_m->get_dimat_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
//         if($dimat <> null){           
//             $objPHPExcel->getActiveSheet()->setCellValue("F$row", $dimat->MON_AMT_BLN04);
//             $objPHPExcel->getActiveSheet()->setCellValue("G$row", $dimat->MON_AMT_BLN05);
//             $objPHPExcel->getActiveSheet()->setCellValue("H$row", $dimat->MON_AMT_BLN06);
//             $objPHPExcel->getActiveSheet()->setCellValue("I$row", $dimat->MON_AMT_BLN07);
//             $objPHPExcel->getActiveSheet()->setCellValue("J$row", $dimat->MON_AMT_BLN08);
//             $objPHPExcel->getActiveSheet()->setCellValue("K$row", $dimat->MON_AMT_BLN09);
//             $objPHPExcel->getActiveSheet()->setCellValue("L$row", $dimat->MON_AMT_BLN10);
//             $objPHPExcel->getActiveSheet()->setCellValue("M$row", $dimat->MON_AMT_BLN11);
//             $objPHPExcel->getActiveSheet()->setCellValue("N$row", $dimat->MON_AMT_BLN12);
//             $objPHPExcel->getActiveSheet()->setCellValue("O$row", $dimat->MON_AMT_BLN01);
//             $objPHPExcel->getActiveSheet()->setCellValue("P$row", $dimat->MON_AMT_BLN02);
//             $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $dimat->MON_AMT_BLN03);
//             //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $dimat->MON_AMT_SUM);
//         }
        
// //========================== GET SALES TOOLING AIIA ==========================//
//         $row = 100;
//         $CHR_BUDGET_CATEGORY = 'SAL3004';
//         $sales = $this->report_budget_plan_m->get_sales_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
//         if($sales <> null){  
//             $objPHPExcel->getActiveSheet()->setCellValue("F$row", $sales->MON_AMT_BLN04);
//             $objPHPExcel->getActiveSheet()->setCellValue("G$row", $sales->MON_AMT_BLN05);
//             $objPHPExcel->getActiveSheet()->setCellValue("H$row", $sales->MON_AMT_BLN06);
//             $objPHPExcel->getActiveSheet()->setCellValue("I$row", $sales->MON_AMT_BLN07);
//             $objPHPExcel->getActiveSheet()->setCellValue("J$row", $sales->MON_AMT_BLN08);
//             $objPHPExcel->getActiveSheet()->setCellValue("K$row", $sales->MON_AMT_BLN09);
//             $objPHPExcel->getActiveSheet()->setCellValue("L$row", $sales->MON_AMT_BLN10);
//             $objPHPExcel->getActiveSheet()->setCellValue("M$row", $sales->MON_AMT_BLN11);
//             $objPHPExcel->getActiveSheet()->setCellValue("N$row", $sales->MON_AMT_BLN12);
//             $objPHPExcel->getActiveSheet()->setCellValue("O$row", $sales->MON_AMT_BLN01);
//             $objPHPExcel->getActiveSheet()->setCellValue("P$row", $sales->MON_AMT_BLN02);
//             $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $sales->MON_AMT_BLN03);
//             //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $sales->MON_AMT_SUM);
//         } 
        
// //========================= GET COST TOOLING AIIA ============================//
//         $row = 101;
//         $CHR_BUDGET_CATEGORY = 'DMA4007';
//         $dimat = $this->report_budget_plan_m->get_dimat_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
//         if($dimat <> null){           
//             $objPHPExcel->getActiveSheet()->setCellValue("F$row", $dimat->MON_AMT_BLN04);
//             $objPHPExcel->getActiveSheet()->setCellValue("G$row", $dimat->MON_AMT_BLN05);
//             $objPHPExcel->getActiveSheet()->setCellValue("H$row", $dimat->MON_AMT_BLN06);
//             $objPHPExcel->getActiveSheet()->setCellValue("I$row", $dimat->MON_AMT_BLN07);
//             $objPHPExcel->getActiveSheet()->setCellValue("J$row", $dimat->MON_AMT_BLN08);
//             $objPHPExcel->getActiveSheet()->setCellValue("K$row", $dimat->MON_AMT_BLN09);
//             $objPHPExcel->getActiveSheet()->setCellValue("L$row", $dimat->MON_AMT_BLN10);
//             $objPHPExcel->getActiveSheet()->setCellValue("M$row", $dimat->MON_AMT_BLN11);
//             $objPHPExcel->getActiveSheet()->setCellValue("N$row", $dimat->MON_AMT_BLN12);
//             $objPHPExcel->getActiveSheet()->setCellValue("O$row", $dimat->MON_AMT_BLN01);
//             $objPHPExcel->getActiveSheet()->setCellValue("P$row", $dimat->MON_AMT_BLN02);
//             $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $dimat->MON_AMT_BLN03);
//             //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $dimat->MON_AMT_SUM);
//         }
        
// //======================= GET NON OPERATING INCOME ===========================//
//         $row = 108;
//         $CHR_BUDGET_CATEGORY = 'NON7010';
//         $nopin = $this->report_budget_plan_m->get_nopin_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
//         if($nopin <> null){
//             $objPHPExcel->getActiveSheet()->setCellValue("F$row", $nopin->MON_AMT_BLN04);
//             $objPHPExcel->getActiveSheet()->setCellValue("G$row", $nopin->MON_AMT_BLN05);
//             $objPHPExcel->getActiveSheet()->setCellValue("H$row", $nopin->MON_AMT_BLN06);
//             $objPHPExcel->getActiveSheet()->setCellValue("I$row", $nopin->MON_AMT_BLN07);
//             $objPHPExcel->getActiveSheet()->setCellValue("J$row", $nopin->MON_AMT_BLN08);
//             $objPHPExcel->getActiveSheet()->setCellValue("K$row", $nopin->MON_AMT_BLN09);
//             $objPHPExcel->getActiveSheet()->setCellValue("L$row", $nopin->MON_AMT_BLN10);
//             $objPHPExcel->getActiveSheet()->setCellValue("M$row", $nopin->MON_AMT_BLN11);
//             $objPHPExcel->getActiveSheet()->setCellValue("N$row", $nopin->MON_AMT_BLN12);
//             $objPHPExcel->getActiveSheet()->setCellValue("O$row", $nopin->MON_AMT_BLN01);
//             $objPHPExcel->getActiveSheet()->setCellValue("P$row", $nopin->MON_AMT_BLN02);
//             $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $nopin->MON_AMT_BLN03);
//             //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $nopin->MON_AMT_SUM);
//         }
        
//         $row = 109;
//         $CHR_BUDGET_CATEGORY = 'NON7030';
//         $nopin = $this->report_budget_plan_m->get_nopin_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
//         if($nopin <> null){
//             $objPHPExcel->getActiveSheet()->setCellValue("F$row", $nopin->MON_AMT_BLN04);
//             $objPHPExcel->getActiveSheet()->setCellValue("G$row", $nopin->MON_AMT_BLN05);
//             $objPHPExcel->getActiveSheet()->setCellValue("H$row", $nopin->MON_AMT_BLN06);
//             $objPHPExcel->getActiveSheet()->setCellValue("I$row", $nopin->MON_AMT_BLN07);
//             $objPHPExcel->getActiveSheet()->setCellValue("J$row", $nopin->MON_AMT_BLN08);
//             $objPHPExcel->getActiveSheet()->setCellValue("K$row", $nopin->MON_AMT_BLN09);
//             $objPHPExcel->getActiveSheet()->setCellValue("L$row", $nopin->MON_AMT_BLN10);
//             $objPHPExcel->getActiveSheet()->setCellValue("M$row", $nopin->MON_AMT_BLN11);
//             $objPHPExcel->getActiveSheet()->setCellValue("N$row", $nopin->MON_AMT_BLN12);
//             $objPHPExcel->getActiveSheet()->setCellValue("O$row", $nopin->MON_AMT_BLN01);
//             $objPHPExcel->getActiveSheet()->setCellValue("P$row", $nopin->MON_AMT_BLN02);
//             $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $nopin->MON_AMT_BLN03);
//             //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $nopin->MON_AMT_SUM);
//         }
        
//         $row = 110;
//         $CHR_BUDGET_CATEGORY = 'NON8010';
//         $nopin = $this->report_budget_plan_m->get_nopin_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
//         if($nopin <> null){
//             $objPHPExcel->getActiveSheet()->setCellValue("F$row", $nopin->MON_AMT_BLN04);
//             $objPHPExcel->getActiveSheet()->setCellValue("G$row", $nopin->MON_AMT_BLN05);
//             $objPHPExcel->getActiveSheet()->setCellValue("H$row", $nopin->MON_AMT_BLN06);
//             $objPHPExcel->getActiveSheet()->setCellValue("I$row", $nopin->MON_AMT_BLN07);
//             $objPHPExcel->getActiveSheet()->setCellValue("J$row", $nopin->MON_AMT_BLN08);
//             $objPHPExcel->getActiveSheet()->setCellValue("K$row", $nopin->MON_AMT_BLN09);
//             $objPHPExcel->getActiveSheet()->setCellValue("L$row", $nopin->MON_AMT_BLN10);
//             $objPHPExcel->getActiveSheet()->setCellValue("M$row", $nopin->MON_AMT_BLN11);
//             $objPHPExcel->getActiveSheet()->setCellValue("N$row", $nopin->MON_AMT_BLN12);
//             $objPHPExcel->getActiveSheet()->setCellValue("O$row", $nopin->MON_AMT_BLN01);
//             $objPHPExcel->getActiveSheet()->setCellValue("P$row", $nopin->MON_AMT_BLN02);
//             $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $nopin->MON_AMT_BLN03);
//             //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $nopin->MON_AMT_SUM);
//         }
        
//         $row = 111;
//         $CHR_BUDGET_CATEGORY = 'NON8020';
//         $nopin = $this->report_budget_plan_m->get_nopin_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
//         if($nopin <> null){
//             $objPHPExcel->getActiveSheet()->setCellValue("F$row", $nopin->MON_AMT_BLN04);
//             $objPHPExcel->getActiveSheet()->setCellValue("G$row", $nopin->MON_AMT_BLN05);
//             $objPHPExcel->getActiveSheet()->setCellValue("H$row", $nopin->MON_AMT_BLN06);
//             $objPHPExcel->getActiveSheet()->setCellValue("I$row", $nopin->MON_AMT_BLN07);
//             $objPHPExcel->getActiveSheet()->setCellValue("J$row", $nopin->MON_AMT_BLN08);
//             $objPHPExcel->getActiveSheet()->setCellValue("K$row", $nopin->MON_AMT_BLN09);
//             $objPHPExcel->getActiveSheet()->setCellValue("L$row", $nopin->MON_AMT_BLN10);
//             $objPHPExcel->getActiveSheet()->setCellValue("M$row", $nopin->MON_AMT_BLN11);
//             $objPHPExcel->getActiveSheet()->setCellValue("N$row", $nopin->MON_AMT_BLN12);
//             $objPHPExcel->getActiveSheet()->setCellValue("O$row", $nopin->MON_AMT_BLN01);
//             $objPHPExcel->getActiveSheet()->setCellValue("P$row", $nopin->MON_AMT_BLN02);
//             $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $nopin->MON_AMT_BLN03);
//             //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $nopin->MON_AMT_SUM);
//         }
// //======================= END OF NON OPERATING INCOME ========================//
        
// //================================= GET TAX ==================================//
//         $row = 118;
//         $CHR_BUDGET_CATEGORY = 'TAX8801';
//         $tax = $this->report_budget_plan_m->get_tax_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
//         if($tax <> null){
//             $objPHPExcel->getActiveSheet()->setCellValue("F$row", $tax->MON_AMT_BLN04);
//             $objPHPExcel->getActiveSheet()->setCellValue("G$row", $tax->MON_AMT_BLN05);
//             $objPHPExcel->getActiveSheet()->setCellValue("H$row", $tax->MON_AMT_BLN06);
//             $objPHPExcel->getActiveSheet()->setCellValue("I$row", $tax->MON_AMT_BLN07);
//             $objPHPExcel->getActiveSheet()->setCellValue("J$row", $tax->MON_AMT_BLN08);
//             $objPHPExcel->getActiveSheet()->setCellValue("K$row", $tax->MON_AMT_BLN09);
//             $objPHPExcel->getActiveSheet()->setCellValue("L$row", $tax->MON_AMT_BLN10);
//             $objPHPExcel->getActiveSheet()->setCellValue("M$row", $tax->MON_AMT_BLN11);
//             $objPHPExcel->getActiveSheet()->setCellValue("N$row", $tax->MON_AMT_BLN12);
//             $objPHPExcel->getActiveSheet()->setCellValue("O$row", $tax->MON_AMT_BLN01);
//             $objPHPExcel->getActiveSheet()->setCellValue("P$row", $tax->MON_AMT_BLN02);
//             $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $tax->MON_AMT_BLN03);
//             //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $tax->MON_AMT_SUM);
//         }
        
//         $row = 119;
//         $CHR_BUDGET_CATEGORY = 'TAX8803';
//         $tax = $this->report_budget_plan_m->get_tax_by_category($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
        
//         if($tax <> null){
//             $objPHPExcel->getActiveSheet()->setCellValue("F$row", $tax->MON_AMT_BLN04);
//             $objPHPExcel->getActiveSheet()->setCellValue("G$row", $tax->MON_AMT_BLN05);
//             $objPHPExcel->getActiveSheet()->setCellValue("H$row", $tax->MON_AMT_BLN06);
//             $objPHPExcel->getActiveSheet()->setCellValue("I$row", $tax->MON_AMT_BLN07);
//             $objPHPExcel->getActiveSheet()->setCellValue("J$row", $tax->MON_AMT_BLN08);
//             $objPHPExcel->getActiveSheet()->setCellValue("K$row", $tax->MON_AMT_BLN09);
//             $objPHPExcel->getActiveSheet()->setCellValue("L$row", $tax->MON_AMT_BLN10);
//             $objPHPExcel->getActiveSheet()->setCellValue("M$row", $tax->MON_AMT_BLN11);
//             $objPHPExcel->getActiveSheet()->setCellValue("N$row", $tax->MON_AMT_BLN12);
//             $objPHPExcel->getActiveSheet()->setCellValue("O$row", $tax->MON_AMT_BLN01);
//             $objPHPExcel->getActiveSheet()->setCellValue("P$row", $tax->MON_AMT_BLN02);
//             $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $tax->MON_AMT_BLN03);
//             //$objPHPExcel->getActiveSheet()->setCellValue("R$row", $tax->MON_AMT_SUM);
//         }
// //================================= END TAX ==================================//        
        
//         $row = 127;

//         $gdImage = imagecreatefromjpeg('assets/template/budget/report/approval.JPG');
//         // Add a drawing to the worksheetecho date('H:i:s') . " Add a drawing to the worksheet\n";
//         $objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
//         $objDrawing->setName('Sample image');
//         $objDrawing->setDescription('Sample image');
//         $objDrawing->setImageResource($gdImage);
//         $objDrawing->setRenderingFunction(PHPExcel_Worksheet_MemoryDrawing::RENDERING_JPEG);
//         $objDrawing->setMimeType(PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_DEFAULT);
//         $objDrawing->setHeight(105);
//         $objDrawing->setCoordinates("O$row");
//         $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());

//         ob_end_clean();
//         $filename = "REPORT PROFIT & LOSS BY CATEGORY A3 - BUDGET $INT_ID_FISCAL_YEAR .xls";
//         header('Content-Type: application/vnd.ms-excel');
//         header('Content-Disposition: attachment;filename="' . trim($filename) . '"');
//         header('Cache-Control: max-age=0');

//         $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
//         $objWriter->setIncludeCharts(TRUE);
//         $objWriter->save('php://output');
//     }
    //===== BACKUP FUNCTION - END MB FY 2021=====//
    
    function download_summary_company($INT_ID_FISCAL_YEAR = null, $INT_ID_BUDGET_GROUP = null) {
        $user_session = $this->session->all_userdata();
        $role = $user_session['ROLE'];
        $row = 8;

        if ($INT_ID_FISCAL_YEAR <> null && $INT_ID_BUDGET_GROUP <> null) {
            if ($INT_ID_BUDGET_GROUP == '1'){
//                if($role == 2){
//                    $summary_company = $this->report_budget_plan_m->get_summary_capex_company_cpl($INT_ID_FISCAL_YEAR);
//                    $tot_summary_company = $this->report_budget_plan_m->tot_summary_capex_company_cpl($INT_ID_FISCAL_YEAR);
//                } else {
                    $summary_company = $this->report_budget_plan_m->get_summary_capex_company($INT_ID_FISCAL_YEAR);
                    $tot_summary_company = $this->report_budget_plan_m->tot_summary_capex_company($INT_ID_FISCAL_YEAR);
//                }                
            } else if ($INT_ID_BUDGET_GROUP == '2'){
//                if($role == 2){
//                    $summary_company = $this->report_budget_plan_m->get_summary_expense_company_cpl($INT_ID_FISCAL_YEAR);
//                    $tot_summary_company = $this->report_budget_plan_m->tot_summary_expense_company_cpl($INT_ID_FISCAL_YEAR);
//                } else {
                    $summary_company = $this->report_budget_plan_m->get_summary_expense_company($INT_ID_FISCAL_YEAR);
                    $tot_summary_company = $this->report_budget_plan_m->tot_summary_expense_company($INT_ID_FISCAL_YEAR);
//                }                
            } else if ($INT_ID_BUDGET_GROUP == '3'){
                $summary_company = $this->report_budget_plan_m->get_summary_sales_company($INT_ID_FISCAL_YEAR);
                $tot_summary_company = $this->report_budget_plan_m->tot_summary_sales_company($INT_ID_FISCAL_YEAR);
            } else if ($INT_ID_BUDGET_GROUP == '4') {
                $summary_company = $this->report_budget_plan_m->get_summary_dimat_company($INT_ID_FISCAL_YEAR);
                $tot_summary_company = $this->report_budget_plan_m->tot_summary_dimat_company($INT_ID_FISCAL_YEAR);
            } else if ($INT_ID_BUDGET_GROUP == '5') {
                $summary_company = $this->report_budget_plan_m->get_summary_nopin_company($INT_ID_FISCAL_YEAR);
                $tot_summary_company = $this->report_budget_plan_m->tot_summary_nopin_company($INT_ID_FISCAL_YEAR);
            } else {
                $summary_company = $this->report_budget_plan_m->get_summary_tax_company($INT_ID_FISCAL_YEAR);
                $tot_summary_company = $this->report_budget_plan_m->tot_summary_tax_company($INT_ID_FISCAL_YEAR);
            }
        
            $budget_group_desc = strtoupper(trim($this->budgetgroup_m->get_desc_budgetgroup($INT_ID_BUDGET_GROUP)));
            $CHR_FISCAL_YEAR_DESC = trim($this->fiscal_m->select_fiscal_year($INT_ID_FISCAL_YEAR));

            $this->load->library('excel');
            $objReader = PHPExcel_IOFactory::createReader('Excel5');
            // Create new PHPExcel object

            $objPHPExcel = $objReader->load("assets/template/budget/report/Template_Report_Summary_Company.xls");

            $seq = 1;
            $objPHPExcel->getActiveSheet()->setCellValue("B2", "MASTER BUDGET : " . $budget_group_desc . " TAHUN " . $CHR_FISCAL_YEAR_DESC);
            foreach ($summary_company as $value) {
                $CHR_BUDGET_TYPE = $value->CHR_BUDGET_TYPE;
                $CHR_BUDGET_TYPE_DESC = $value->CHR_BUDGET_TYPE_DESC;
                $CHR_BUDGET_SUB_CATEGORY = $value->CHR_BUDGET_SUB_CATEGORY;
                $CHR_BUDGET_SUB_CATEGORY_DESC = $value->CHR_BUDGET_SUB_CATEGORY_DESC;
                $CHR_BUDGET_CATEGORY = $value->CHR_BUDGET_CATEGORY;
                $CHR_BUDGET_CATEGORY_DESC = $value->CHR_BUDGET_CATEGORY_DESC;
                $CHR_CODE_CATEGORY_A3 = $value->CHR_CODE_CATEGORY_A3;
                $CHR_CODE_CATEGORY_A3_DESC = $value->CHR_CODE_CATEGORY_A3_DESC;                
                $MON_AMT_BLN01 = $value->MON_AMT_BLN01;
                $MON_AMT_BLN02 = $value->MON_AMT_BLN02;
                $MON_AMT_BLN03 = $value->MON_AMT_BLN03;
                $MON_AMT_BLN04 = $value->MON_AMT_BLN04;
                $MON_AMT_BLN05 = $value->MON_AMT_BLN05;
                $MON_AMT_BLN06 = $value->MON_AMT_BLN06;
                $MON_AMT_BLN07 = $value->MON_AMT_BLN07;
                $MON_AMT_BLN08 = $value->MON_AMT_BLN08;
                $MON_AMT_BLN09 = $value->MON_AMT_BLN09;
                $MON_AMT_BLN10 = $value->MON_AMT_BLN10;
                $MON_AMT_BLN11 = $value->MON_AMT_BLN11;
                $MON_AMT_BLN12 = $value->MON_AMT_BLN12;
                $MON_AMT_SUM = $value->MON_AMT_SUM;

                $objPHPExcel->getActiveSheet()->setCellValue("B$row", "$seq");
                $objPHPExcel->getActiveSheet()->setCellValue("C$row", "$CHR_BUDGET_SUB_CATEGORY");
                $objPHPExcel->getActiveSheet()->setCellValue("D$row", "$CHR_BUDGET_SUB_CATEGORY_DESC");
                $objPHPExcel->getActiveSheet()->setCellValue("E$row", "$CHR_BUDGET_CATEGORY");
                $objPHPExcel->getActiveSheet()->setCellValue("F$row", "$CHR_BUDGET_CATEGORY_DESC");
                $objPHPExcel->getActiveSheet()->setCellValue("G$row", "$CHR_CODE_CATEGORY_A3");
                $objPHPExcel->getActiveSheet()->setCellValue("H$row", "$CHR_CODE_CATEGORY_A3_DESC");
                $objPHPExcel->getActiveSheet()->setCellValue("I$row", "$MON_AMT_BLN04");
                $objPHPExcel->getActiveSheet()->setCellValue("J$row", "$MON_AMT_BLN05");
                $objPHPExcel->getActiveSheet()->setCellValue("K$row", "$MON_AMT_BLN06");
                $objPHPExcel->getActiveSheet()->setCellValue("L$row", "$MON_AMT_BLN07");
                $objPHPExcel->getActiveSheet()->setCellValue("M$row", "$MON_AMT_BLN08");
                $objPHPExcel->getActiveSheet()->setCellValue("N$row", "$MON_AMT_BLN09");
                $objPHPExcel->getActiveSheet()->setCellValue("O$row", "$MON_AMT_BLN10");
                $objPHPExcel->getActiveSheet()->setCellValue("P$row", "$MON_AMT_BLN11");
                $objPHPExcel->getActiveSheet()->setCellValue("Q$row", "$MON_AMT_BLN12");
                $objPHPExcel->getActiveSheet()->setCellValue("R$row", "$MON_AMT_BLN01");
                $objPHPExcel->getActiveSheet()->setCellValue("S$row", "$MON_AMT_BLN02");
                $objPHPExcel->getActiveSheet()->setCellValue("T$row", "$MON_AMT_BLN03");
                $objPHPExcel->getActiveSheet()->setCellValue("U$row", "$MON_AMT_SUM");

                $seq++;
                $row++;
            }

            $objPHPExcel->getActiveSheet()->getStyle("B8:U$row")->applyFromArray(array(
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                )
            ));
            
            $row++;
            $row_min = $row - 1;
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", "=SUM(I8:I$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", "=SUM(J8:J$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", "=SUM(K8:K$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", "=SUM(L8:L$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", "=SUM(M8:M$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", "=SUM(N8:N$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", "=SUM(O8:O$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", "=SUM(P8:P$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", "=SUM(Q8:Q$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("R$row", "=SUM(R8:R$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("S$row", "=SUM(S8:S$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("T$row", "=SUM(T8:T$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("U$row", "=SUM(U8:U$row_min)");
            $objPHPExcel->getActiveSheet()->getStyle("B8:U$row")->applyFromArray(array(
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                ),
            ));
            $objPHPExcel->getActiveSheet()->mergeCells("B$row:H$row");
            $objPHPExcel->getActiveSheet()->setCellValue("B$row", "TOTAL");
            $objPHPExcel->getActiveSheet()->getStyle("B$row:U$row")->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('#CCCCCC');
            $objPHPExcel->getActiveSheet()->getStyle("B$row:U$row")->applyFromArray(array(
                'font' => array(
                    'bold' => true,
                    'size' => 12
                )
            ));

            $row = $row + 3;
            
            $gdImage = imagecreatefromjpeg('assets/template/budget/report/approval.JPG');
            // Add a drawing to the worksheetecho date('H:i:s') . " Add a drawing to the worksheet\n";
            $objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
            $objDrawing->setName('Sample image');
            $objDrawing->setDescription('Sample image');
            $objDrawing->setImageResource($gdImage);
            $objDrawing->setRenderingFunction(PHPExcel_Worksheet_MemoryDrawing::RENDERING_JPEG);
            $objDrawing->setMimeType(PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_DEFAULT);
            $objDrawing->setHeight(105);
            $objDrawing->setCoordinates("Q$row");
            $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());

            ob_end_clean();
            $filename = "$CHR_FISCAL_YEAR_DESC - $budget_group_desc.xls";
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="' . trim($filename) . '"');
            header('Cache-Control: max-age=0');

            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->setIncludeCharts(TRUE);
            $objWriter->save('php://output');
        }
    }
    
    function download_summary_exp_company($INT_ID_FISCAL_YEAR = null) {
        $user_session = $this->session->all_userdata();
        $role = $user_session['ROLE'];
//        if($role == 2){
//            $category_foh = $this->budget_expense_m->get_category_expense_foh_cpl($INT_ID_FISCAL_YEAR);
//            $category_opx = $this->budget_expense_m->get_category_expense_opx_cpl($INT_ID_FISCAL_YEAR);
//        } else {
            $category_foh = $this->budget_expense_m->get_category_expense_foh($INT_ID_FISCAL_YEAR);
            $category_opx = $this->budget_expense_m->get_category_expense_opx($INT_ID_FISCAL_YEAR);
//        }
        
        $CHR_FISCAL_YEAR_DESC = trim($this->fiscal_m->select_fiscal_year($INT_ID_FISCAL_YEAR));
        
        $this->load->library('excel');
        $objReader = PHPExcel_IOFactory::createReader('Excel5');
        // Create new PHPExcel object

        $objPHPExcel = $objReader->load("assets/template/budget/report/Template_Report_Summary_Exp_Company.xls");
        
        //============== FOH =================================================//
        $row = 8;
        $active_sheet = $objPHPExcel->setActiveSheetIndexByName('FOH');
        $active_sheet->setCellValue("B2", "MASTER BUDGET : EXPENSE FOH TAHUN " . $CHR_FISCAL_YEAR_DESC);
        
        $tot_bln04_foh = 0;
        $tot_bln05_foh = 0;
        $tot_bln06_foh = 0;
        $tot_bln07_foh = 0;
        $tot_bln08_foh = 0;
        $tot_bln09_foh = 0;
        $tot_bln10_foh = 0;
        $tot_bln11_foh = 0;
        $tot_bln12_foh = 0;
        $tot_bln01_foh = 0;
        $tot_bln02_foh = 0;
        $tot_bln03_foh = 0;
        $tot_sum_foh = 0;        
        
        foreach($category_foh as $foh){
            $CHR_CATEGORY = $foh->CHR_BUDGET_CATEGORY;
//            if($role == 2){
//                $detail_confirm_foh = $this->report_budget_plan_m->get_expense_foh_by_category_cpl($INT_ID_FISCAL_YEAR, $CHR_CATEGORY);
//            } else {
                $detail_confirm_foh = $this->report_budget_plan_m->get_expense_foh_by_category($INT_ID_FISCAL_YEAR, $CHR_CATEGORY);
//            }            
            
            $tot_bln04 = 0;
            $tot_bln05 = 0;
            $tot_bln06 = 0;
            $tot_bln07 = 0;
            $tot_bln08 = 0;
            $tot_bln09 = 0;
            $tot_bln10 = 0;
            $tot_bln11 = 0;
            $tot_bln12 = 0;
            $tot_bln01 = 0;
            $tot_bln02 = 0;
            $tot_bln03 = 0;
            $tot_sum = 0;
            
            $count = count($detail_confirm_foh);
            
            if($count != 0){
                foreach ($detail_confirm_foh as $value) {
                    $CHR_BUDGET_SUB_CATEGORY_DESC = $value->CHR_BUDGET_SUB_CATEGORY_DESC;
                    $CHR_BUDGET_CATEGORY_DESC = $value->CHR_BUDGET_CATEGORY_DESC;
                    $CHR_CODE_CATEGORY_A3_DESC = $value->CHR_CODE_CATEGORY_A3_DESC;                
                    $MON_AMT_BLN01 = $value->MON_AMT_BLN01;
                    $MON_AMT_BLN02 = $value->MON_AMT_BLN02;
                    $MON_AMT_BLN03 = $value->MON_AMT_BLN03;
                    $MON_AMT_BLN04 = $value->MON_AMT_BLN04;
                    $MON_AMT_BLN05 = $value->MON_AMT_BLN05;
                    $MON_AMT_BLN06 = $value->MON_AMT_BLN06;
                    $MON_AMT_BLN07 = $value->MON_AMT_BLN07;
                    $MON_AMT_BLN08 = $value->MON_AMT_BLN08;
                    $MON_AMT_BLN09 = $value->MON_AMT_BLN09;
                    $MON_AMT_BLN10 = $value->MON_AMT_BLN10;
                    $MON_AMT_BLN11 = $value->MON_AMT_BLN11;
                    $MON_AMT_BLN12 = $value->MON_AMT_BLN12;
                    $MON_AMT_SUM = $value->MON_AMT_SUM;

                    $active_sheet->setCellValue("B$row", "$CHR_BUDGET_SUB_CATEGORY_DESC");
                    $active_sheet->setCellValue("C$row", "$CHR_BUDGET_CATEGORY_DESC");
                    $active_sheet->setCellValue("D$row", "$CHR_CODE_CATEGORY_A3_DESC");
                    $active_sheet->setCellValue("E$row", "$MON_AMT_BLN04");
                    $active_sheet->setCellValue("F$row", "$MON_AMT_BLN05");
                    $active_sheet->setCellValue("G$row", "$MON_AMT_BLN06");
                    $active_sheet->setCellValue("H$row", "$MON_AMT_BLN07");
                    $active_sheet->setCellValue("I$row", "$MON_AMT_BLN08");
                    $active_sheet->setCellValue("J$row", "$MON_AMT_BLN09");
                    $active_sheet->setCellValue("K$row", "$MON_AMT_BLN10");
                    $active_sheet->setCellValue("L$row", "$MON_AMT_BLN11");
                    $active_sheet->setCellValue("M$row", "$MON_AMT_BLN12");
                    $active_sheet->setCellValue("N$row", "$MON_AMT_BLN01");
                    $active_sheet->setCellValue("O$row", "$MON_AMT_BLN02");
                    $active_sheet->setCellValue("P$row", "$MON_AMT_BLN03");
                    $active_sheet->setCellValue("Q$row", "$MON_AMT_SUM");

                    $tot_bln04 = $tot_bln04 + $MON_AMT_BLN04;
                    $tot_bln05 = $tot_bln05 + $MON_AMT_BLN05;
                    $tot_bln06 = $tot_bln06 + $MON_AMT_BLN06;
                    $tot_bln07 = $tot_bln07 + $MON_AMT_BLN07;
                    $tot_bln08 = $tot_bln08 + $MON_AMT_BLN08;
                    $tot_bln09 = $tot_bln09 + $MON_AMT_BLN09;
                    $tot_bln10 = $tot_bln10 + $MON_AMT_BLN10;
                    $tot_bln11 = $tot_bln11 + $MON_AMT_BLN11;
                    $tot_bln12 = $tot_bln12 + $MON_AMT_BLN12;
                    $tot_bln01 = $tot_bln01 + $MON_AMT_BLN01;
                    $tot_bln02 = $tot_bln02 + $MON_AMT_BLN02;
                    $tot_bln03 = $tot_bln03 + $MON_AMT_BLN03;
                    $tot_sum = $tot_sum + $MON_AMT_SUM;

                    $row++;
                }            
            
                $active_sheet->getStyle("B8:Q$row")->applyFromArray(array(
                    'borders' => array(
                        'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                        )
                    )
                ));

                $active_sheet->setCellValue("E$row", $tot_bln04);
                $active_sheet->setCellValue("F$row", $tot_bln05);
                $active_sheet->setCellValue("G$row", $tot_bln06);
                $active_sheet->setCellValue("H$row", $tot_bln07);
                $active_sheet->setCellValue("I$row", $tot_bln08);
                $active_sheet->setCellValue("J$row", $tot_bln09);
                $active_sheet->setCellValue("K$row", $tot_bln10);
                $active_sheet->setCellValue("L$row", $tot_bln11);
                $active_sheet->setCellValue("M$row", $tot_bln12);
                $active_sheet->setCellValue("N$row", $tot_bln01);
                $active_sheet->setCellValue("O$row", $tot_bln02);
                $active_sheet->setCellValue("P$row", $tot_bln03);
                $active_sheet->setCellValue("Q$row", $tot_sum);

                $active_sheet->getStyle("B8:Q$row")->applyFromArray(array(
                    'borders' => array(
                        'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                        )
                    ),
                ));

                $active_sheet->mergeCells("B$row:D$row");
                $active_sheet->setCellValue("B$row", "TOTAL");
                $active_sheet->getStyle("B$row:Q$row")->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('#CCCCCC');

                $active_sheet->getStyle("B$row:Q$row")->applyFromArray(array(
                    'font' => array(
                        'bold' => true,
                        'size' => 12
                    )
                ));
            }
            
            $tot_bln04_foh = $tot_bln04_foh + $tot_bln04;
            $tot_bln05_foh = $tot_bln05_foh + $tot_bln05;
            $tot_bln06_foh = $tot_bln06_foh + $tot_bln06;
            $tot_bln07_foh = $tot_bln07_foh + $tot_bln07;
            $tot_bln08_foh = $tot_bln08_foh + $tot_bln08;
            $tot_bln09_foh = $tot_bln09_foh + $tot_bln09;
            $tot_bln10_foh = $tot_bln10_foh + $tot_bln10;
            $tot_bln11_foh = $tot_bln11_foh + $tot_bln11;
            $tot_bln12_foh = $tot_bln12_foh + $tot_bln12;
            $tot_bln01_foh = $tot_bln01_foh + $tot_bln01;
            $tot_bln02_foh = $tot_bln02_foh + $tot_bln02;
            $tot_bln03_foh = $tot_bln03_foh + $tot_bln03;
            $tot_sum_foh = $tot_sum_foh + $tot_sum;
            
            $row = $row + 1;
        }
        
        $active_sheet->setCellValue("E$row", $tot_bln04_foh);
        $active_sheet->setCellValue("F$row", $tot_bln05_foh);
        $active_sheet->setCellValue("G$row", $tot_bln06_foh);
        $active_sheet->setCellValue("H$row", $tot_bln07_foh);
        $active_sheet->setCellValue("I$row", $tot_bln08_foh);
        $active_sheet->setCellValue("J$row", $tot_bln09_foh);
        $active_sheet->setCellValue("K$row", $tot_bln10_foh);
        $active_sheet->setCellValue("L$row", $tot_bln11_foh);
        $active_sheet->setCellValue("M$row", $tot_bln12_foh);
        $active_sheet->setCellValue("N$row", $tot_bln01_foh);
        $active_sheet->setCellValue("O$row", $tot_bln02_foh);
        $active_sheet->setCellValue("P$row", $tot_bln03_foh);
        $active_sheet->setCellValue("Q$row", $tot_sum_foh);

        $active_sheet->getStyle("B8:Q$row")->applyFromArray(array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            ),
        ));

        $active_sheet->mergeCells("B$row:D$row");
        $active_sheet->setCellValue("B$row", "GRAND TOTAL");
        $active_sheet->getStyle("B$row:Q$row")->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('#CCCCCC');

        $active_sheet->getStyle("B$row:Q$row")->applyFromArray(array(
            'font' => array(
                'bold' => true,
                'size' => 12
            )
        ));

        $row = $row + 3;

        $gdImage = imagecreatefromjpeg('assets/template/budget/report/approval.JPG');
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
        //============== END FOH =============================================//
        
        //============== OPEX =================================================//
        $row_x = 8;
        $active_sheet = $objPHPExcel->setActiveSheetIndexByName('OPX');
        $active_sheet->setCellValue("B2", "MASTER BUDGET : EXPENSE OPEX TAHUN " . $CHR_FISCAL_YEAR_DESC);
        
        $tot_bln04_opx = 0;
        $tot_bln05_opx = 0;
        $tot_bln06_opx = 0;
        $tot_bln07_opx = 0;
        $tot_bln08_opx = 0;
        $tot_bln09_opx = 0;
        $tot_bln10_opx = 0;
        $tot_bln11_opx = 0;
        $tot_bln12_opx = 0;
        $tot_bln01_opx = 0;
        $tot_bln02_opx = 0;
        $tot_bln03_opx = 0;
        $tot_sum_opx = 0;
        
        foreach($category_opx as $opx){
            $CHR_CATEGORY = $opx->CHR_BUDGET_CATEGORY;
//            if($role == 2){
//                $detail_confirm_opx = $this->report_budget_plan_m->get_expense_opx_by_category_cpl($INT_ID_FISCAL_YEAR, $CHR_CATEGORY);
//            } else {
                $detail_confirm_opx = $this->report_budget_plan_m->get_expense_opx_by_category($INT_ID_FISCAL_YEAR, $CHR_CATEGORY);
//            }            
            
            $tot_bln04 = 0;
            $tot_bln05 = 0;
            $tot_bln06 = 0;
            $tot_bln07 = 0;
            $tot_bln08 = 0;
            $tot_bln09 = 0;
            $tot_bln10 = 0;
            $tot_bln11 = 0;
            $tot_bln12 = 0;
            $tot_bln01 = 0;
            $tot_bln02 = 0;
            $tot_bln03 = 0;
            $tot_sum = 0;
            
            $count = count($detail_confirm_opx);
            
            if($count != 0){            
                foreach ($detail_confirm_opx as $value) {
                    $CHR_BUDGET_SUB_CATEGORY_DESC = $value->CHR_BUDGET_SUB_CATEGORY_DESC;
                    $CHR_BUDGET_CATEGORY_DESC = $value->CHR_BUDGET_CATEGORY_DESC;
                    $CHR_CODE_CATEGORY_A3_DESC = $value->CHR_CODE_CATEGORY_A3_DESC;                
                    $MON_AMT_BLN01 = $value->MON_AMT_BLN01;
                    $MON_AMT_BLN02 = $value->MON_AMT_BLN02;
                    $MON_AMT_BLN03 = $value->MON_AMT_BLN03;
                    $MON_AMT_BLN04 = $value->MON_AMT_BLN04;
                    $MON_AMT_BLN05 = $value->MON_AMT_BLN05;
                    $MON_AMT_BLN06 = $value->MON_AMT_BLN06;
                    $MON_AMT_BLN07 = $value->MON_AMT_BLN07;
                    $MON_AMT_BLN08 = $value->MON_AMT_BLN08;
                    $MON_AMT_BLN09 = $value->MON_AMT_BLN09;
                    $MON_AMT_BLN10 = $value->MON_AMT_BLN10;
                    $MON_AMT_BLN11 = $value->MON_AMT_BLN11;
                    $MON_AMT_BLN12 = $value->MON_AMT_BLN12;
                    $MON_AMT_SUM = $value->MON_AMT_SUM;

                    $active_sheet->setCellValue("B$row_x", "$CHR_BUDGET_SUB_CATEGORY_DESC");
                    $active_sheet->setCellValue("C$row_x", "$CHR_BUDGET_CATEGORY_DESC");
                    $active_sheet->setCellValue("D$row_x", "$CHR_CODE_CATEGORY_A3_DESC");
                    $active_sheet->setCellValue("E$row_x", "$MON_AMT_BLN04");
                    $active_sheet->setCellValue("F$row_x", "$MON_AMT_BLN05");
                    $active_sheet->setCellValue("G$row_x", "$MON_AMT_BLN06");
                    $active_sheet->setCellValue("H$row_x", "$MON_AMT_BLN07");
                    $active_sheet->setCellValue("I$row_x", "$MON_AMT_BLN08");
                    $active_sheet->setCellValue("J$row_x", "$MON_AMT_BLN09");
                    $active_sheet->setCellValue("K$row_x", "$MON_AMT_BLN10");
                    $active_sheet->setCellValue("L$row_x", "$MON_AMT_BLN11");
                    $active_sheet->setCellValue("M$row_x", "$MON_AMT_BLN12");
                    $active_sheet->setCellValue("N$row_x", "$MON_AMT_BLN01");
                    $active_sheet->setCellValue("O$row_x", "$MON_AMT_BLN02");
                    $active_sheet->setCellValue("P$row_x", "$MON_AMT_BLN03");
                    $active_sheet->setCellValue("Q$row_x", "$MON_AMT_SUM");

                    $tot_bln04 = $tot_bln04 + $MON_AMT_BLN04;
                    $tot_bln05 = $tot_bln05 + $MON_AMT_BLN05;
                    $tot_bln06 = $tot_bln06 + $MON_AMT_BLN06;
                    $tot_bln07 = $tot_bln07 + $MON_AMT_BLN07;
                    $tot_bln08 = $tot_bln08 + $MON_AMT_BLN08;
                    $tot_bln09 = $tot_bln09 + $MON_AMT_BLN09;
                    $tot_bln10 = $tot_bln10 + $MON_AMT_BLN10;
                    $tot_bln11 = $tot_bln11 + $MON_AMT_BLN11;
                    $tot_bln12 = $tot_bln12 + $MON_AMT_BLN12;
                    $tot_bln01 = $tot_bln01 + $MON_AMT_BLN01;
                    $tot_bln02 = $tot_bln02 + $MON_AMT_BLN02;
                    $tot_bln03 = $tot_bln03 + $MON_AMT_BLN03;
                    $tot_sum = $tot_sum + $MON_AMT_SUM;

                    $row_x++;
                }

                $active_sheet->getStyle("B8:Q$row_x")->applyFromArray(array(
                    'borders' => array(
                        'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                        )
                    )
                ));

                $active_sheet->setCellValue("E$row_x", $tot_bln04);
                $active_sheet->setCellValue("F$row_x", $tot_bln05);
                $active_sheet->setCellValue("G$row_x", $tot_bln06);
                $active_sheet->setCellValue("H$row_x", $tot_bln07);
                $active_sheet->setCellValue("I$row_x", $tot_bln08);
                $active_sheet->setCellValue("J$row_x", $tot_bln09);
                $active_sheet->setCellValue("K$row_x", $tot_bln10);
                $active_sheet->setCellValue("L$row_x", $tot_bln11);
                $active_sheet->setCellValue("M$row_x", $tot_bln12);
                $active_sheet->setCellValue("N$row_x", $tot_bln01);
                $active_sheet->setCellValue("O$row_x", $tot_bln02);
                $active_sheet->setCellValue("P$row_x", $tot_bln03);
                $active_sheet->setCellValue("Q$row_x", $tot_sum);

                $active_sheet->getStyle("B8:Q$row_x")->applyFromArray(array(
                    'borders' => array(
                        'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                        )
                    ),
                ));

                $active_sheet->mergeCells("B$row_x:D$row_x");
                $active_sheet->setCellValue("B$row_x", "TOTAL");
                $active_sheet->getStyle("B$row_x:Q$row_x")->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('#CCCCCC');

                $active_sheet->getStyle("B$row_x:Q$row_x")->applyFromArray(array(
                    'font' => array(
                        'bold' => true,
                        'size' => 12
                    )
                ));
            }
            
            $tot_bln04_opx = $tot_bln04_opx + $tot_bln04;
            $tot_bln05_opx = $tot_bln05_opx + $tot_bln05;
            $tot_bln06_opx = $tot_bln06_opx + $tot_bln06;
            $tot_bln07_opx = $tot_bln07_opx + $tot_bln07;
            $tot_bln08_opx = $tot_bln08_opx + $tot_bln08;
            $tot_bln09_opx = $tot_bln09_opx + $tot_bln09;
            $tot_bln10_opx = $tot_bln10_opx + $tot_bln10;
            $tot_bln11_opx = $tot_bln11_opx + $tot_bln11;
            $tot_bln12_opx = $tot_bln12_opx + $tot_bln12;
            $tot_bln01_opx = $tot_bln01_opx + $tot_bln01;
            $tot_bln02_opx = $tot_bln02_opx + $tot_bln02;
            $tot_bln03_opx = $tot_bln03_opx + $tot_bln03;
            $tot_sum_opx = $tot_sum_opx + $tot_sum;
            
            $row_x = $row_x + 1;
        }
        
        $active_sheet->setCellValue("E$row_x", $tot_bln04_opx);
        $active_sheet->setCellValue("F$row_x", $tot_bln05_opx);
        $active_sheet->setCellValue("G$row_x", $tot_bln06_opx);
        $active_sheet->setCellValue("H$row_x", $tot_bln07_opx);
        $active_sheet->setCellValue("I$row_x", $tot_bln08_opx);
        $active_sheet->setCellValue("J$row_x", $tot_bln09_opx);
        $active_sheet->setCellValue("K$row_x", $tot_bln10_opx);
        $active_sheet->setCellValue("L$row_x", $tot_bln11_opx);
        $active_sheet->setCellValue("M$row_x", $tot_bln12_opx);
        $active_sheet->setCellValue("N$row_x", $tot_bln01_opx);
        $active_sheet->setCellValue("O$row_x", $tot_bln02_opx);
        $active_sheet->setCellValue("P$row_x", $tot_bln03_opx);
        $active_sheet->setCellValue("Q$row_x", $tot_sum_opx);

        $active_sheet->getStyle("B8:Q$row_x")->applyFromArray(array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            ),
        ));

        $active_sheet->mergeCells("B$row_x:D$row_x");
        $active_sheet->setCellValue("B$row_x", "GRAND TOTAL");
        $active_sheet->getStyle("B$row_x:Q$row_x")->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('#CCCCCC');

        $active_sheet->getStyle("B$row_x:Q$row_x")->applyFromArray(array(
            'font' => array(
                'bold' => true,
                'size' => 12
            )
        ));

        $row_x = $row_x + 3;

        $gdImage = imagecreatefromjpeg('assets/template/budget/report/approval.JPG');
        // Add a drawing to the worksheetecho date('H:i:s') . " Add a drawing to the worksheet\n";
        $objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
        $objDrawing->setName('Sample image');
        $objDrawing->setDescription('Sample image');
        $objDrawing->setImageResource($gdImage);
        $objDrawing->setRenderingFunction(PHPExcel_Worksheet_MemoryDrawing::RENDERING_JPEG);
        $objDrawing->setMimeType(PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_DEFAULT);
        $objDrawing->setHeight(105);
        $objDrawing->setCoordinates("N$row_x");
        $objDrawing->setWorksheet($active_sheet);
        //============== END OPEX =============================================//

        
        ob_end_clean();
        $filename = "$CHR_FISCAL_YEAR_DESC - EXPENSE FOH OPEX.xls";
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . trim($filename) . '"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->setIncludeCharts(TRUE);
        $objWriter->save('php://output');
    }
    
    function download_expense_per_dept($INT_ID_FISCAL_YEAR = null) { 
        $user_session = $this->session->all_userdata();
        $role = $user_session['ROLE'];
        $all_dept = $this->dept_m->get_dept();  
        
        $CHR_FISCAL_YEAR_DESC = trim($this->fiscal_m->select_fiscal_year($INT_ID_FISCAL_YEAR));
        
        $this->load->library('excel');
        $objReader = PHPExcel_IOFactory::createReader('Excel5');
        // Create new PHPExcel object

        $objPHPExcel = $objReader->load("assets/template/budget/report/Template_Report_Summary_Exp_Company_Dept.xls");
        
        foreach($all_dept as $dept){
            $INT_DEPT = $dept->INT_ID_DEPT;
//            if($role == 2){
//                $category_foh = $this->budget_expense_m->get_category_expense_foh_dept_cpl($INT_ID_FISCAL_YEAR, $INT_DEPT);
//                $category_opx = $this->budget_expense_m->get_category_expense_opx_dept_cpl($INT_ID_FISCAL_YEAR, $INT_DEPT);
//            } else {
                $category_foh = $this->budget_expense_m->get_category_expense_foh_dept($INT_ID_FISCAL_YEAR, $INT_DEPT);
                $category_opx = $this->budget_expense_m->get_category_expense_opx_dept($INT_ID_FISCAL_YEAR, $INT_DEPT);
//            }            
            
            $CHR_DEPT = trim($this->dept_m->get_name_dept($INT_DEPT));
            $CHR_DEPT_DESC = trim($this->dept_m->get_desc_dept($INT_DEPT));
            
            $row = 8;
            $active_sheet = $objPHPExcel->setActiveSheetIndexByName($CHR_DEPT);
            $active_sheet->setCellValue("B2", "MASTER BUDGET : EXPENSE FOH/OPEX TAHUN " . $CHR_FISCAL_YEAR_DESC);
            $active_sheet->setCellValue("B3", "DEPARTMENT : " . $CHR_DEPT . " - " . $CHR_DEPT_DESC);
            
            //============== FOH =================================================//           

            $tot_bln04_foh = 0;
            $tot_bln05_foh = 0;
            $tot_bln06_foh = 0;
            $tot_bln07_foh = 0;
            $tot_bln08_foh = 0;
            $tot_bln09_foh = 0;
            $tot_bln10_foh = 0;
            $tot_bln11_foh = 0;
            $tot_bln12_foh = 0;
            $tot_bln01_foh = 0;
            $tot_bln02_foh = 0;
            $tot_bln03_foh = 0;
            $tot_sum_foh = 0;        

            foreach($category_foh as $foh){
                $CHR_CATEGORY = $foh->CHR_BUDGET_CATEGORY;
//                if($role == 2){
//                    $detail_confirm_foh = $this->report_budget_plan_m->get_expense_foh_by_category_per_dept_cpl($INT_ID_FISCAL_YEAR, $INT_DEPT, $CHR_CATEGORY);
//                } else {
                    $detail_confirm_foh = $this->report_budget_plan_m->get_expense_foh_by_category_per_dept($INT_ID_FISCAL_YEAR, $INT_DEPT, $CHR_CATEGORY);
//                }
                

                $tot_bln04 = 0;
                $tot_bln05 = 0;
                $tot_bln06 = 0;
                $tot_bln07 = 0;
                $tot_bln08 = 0;
                $tot_bln09 = 0;
                $tot_bln10 = 0;
                $tot_bln11 = 0;
                $tot_bln12 = 0;
                $tot_bln01 = 0;
                $tot_bln02 = 0;
                $tot_bln03 = 0;
                $tot_sum = 0;

                $count = count($detail_confirm_foh);

                if($count != 0){
                    foreach ($detail_confirm_foh as $value) {
                        $CHR_BUDGET_SUB_CATEGORY_DESC = $value->CHR_BUDGET_SUB_CATEGORY_DESC;
                        $CHR_BUDGET_CATEGORY_DESC = $value->CHR_BUDGET_CATEGORY_DESC;
                        $CHR_CODE_CATEGORY_A3_DESC = $value->CHR_CODE_CATEGORY_A3_DESC;                
                        $MON_AMT_BLN01 = $value->MON_AMT_BLN01;
                        $MON_AMT_BLN02 = $value->MON_AMT_BLN02;
                        $MON_AMT_BLN03 = $value->MON_AMT_BLN03;
                        $MON_AMT_BLN04 = $value->MON_AMT_BLN04;
                        $MON_AMT_BLN05 = $value->MON_AMT_BLN05;
                        $MON_AMT_BLN06 = $value->MON_AMT_BLN06;
                        $MON_AMT_BLN07 = $value->MON_AMT_BLN07;
                        $MON_AMT_BLN08 = $value->MON_AMT_BLN08;
                        $MON_AMT_BLN09 = $value->MON_AMT_BLN09;
                        $MON_AMT_BLN10 = $value->MON_AMT_BLN10;
                        $MON_AMT_BLN11 = $value->MON_AMT_BLN11;
                        $MON_AMT_BLN12 = $value->MON_AMT_BLN12;
                        $MON_AMT_SUM = $value->MON_AMT_SUM;

                        $active_sheet->setCellValue("B$row", "$CHR_BUDGET_SUB_CATEGORY_DESC");
                        $active_sheet->setCellValue("C$row", "$CHR_BUDGET_CATEGORY_DESC");
                        $active_sheet->setCellValue("D$row", "$CHR_CODE_CATEGORY_A3_DESC");
                        $active_sheet->setCellValue("E$row", "$MON_AMT_BLN04");
                        $active_sheet->setCellValue("F$row", "$MON_AMT_BLN05");
                        $active_sheet->setCellValue("G$row", "$MON_AMT_BLN06");
                        $active_sheet->setCellValue("H$row", "$MON_AMT_BLN07");
                        $active_sheet->setCellValue("I$row", "$MON_AMT_BLN08");
                        $active_sheet->setCellValue("J$row", "$MON_AMT_BLN09");
                        $active_sheet->setCellValue("K$row", "$MON_AMT_BLN10");
                        $active_sheet->setCellValue("L$row", "$MON_AMT_BLN11");
                        $active_sheet->setCellValue("M$row", "$MON_AMT_BLN12");
                        $active_sheet->setCellValue("N$row", "$MON_AMT_BLN01");
                        $active_sheet->setCellValue("O$row", "$MON_AMT_BLN02");
                        $active_sheet->setCellValue("P$row", "$MON_AMT_BLN03");
                        $active_sheet->setCellValue("Q$row", "$MON_AMT_SUM");

                        $tot_bln04 = $tot_bln04 + $MON_AMT_BLN04;
                        $tot_bln05 = $tot_bln05 + $MON_AMT_BLN05;
                        $tot_bln06 = $tot_bln06 + $MON_AMT_BLN06;
                        $tot_bln07 = $tot_bln07 + $MON_AMT_BLN07;
                        $tot_bln08 = $tot_bln08 + $MON_AMT_BLN08;
                        $tot_bln09 = $tot_bln09 + $MON_AMT_BLN09;
                        $tot_bln10 = $tot_bln10 + $MON_AMT_BLN10;
                        $tot_bln11 = $tot_bln11 + $MON_AMT_BLN11;
                        $tot_bln12 = $tot_bln12 + $MON_AMT_BLN12;
                        $tot_bln01 = $tot_bln01 + $MON_AMT_BLN01;
                        $tot_bln02 = $tot_bln02 + $MON_AMT_BLN02;
                        $tot_bln03 = $tot_bln03 + $MON_AMT_BLN03;
                        $tot_sum = $tot_sum + $MON_AMT_SUM;

                        $row++;
                    }            

                    $active_sheet->getStyle("B8:Q$row")->applyFromArray(array(
                        'borders' => array(
                            'allborders' => array(
                                'style' => PHPExcel_Style_Border::BORDER_THIN
                            )
                        )
                    ));

                    $active_sheet->setCellValue("E$row", $tot_bln04);
                    $active_sheet->setCellValue("F$row", $tot_bln05);
                    $active_sheet->setCellValue("G$row", $tot_bln06);
                    $active_sheet->setCellValue("H$row", $tot_bln07);
                    $active_sheet->setCellValue("I$row", $tot_bln08);
                    $active_sheet->setCellValue("J$row", $tot_bln09);
                    $active_sheet->setCellValue("K$row", $tot_bln10);
                    $active_sheet->setCellValue("L$row", $tot_bln11);
                    $active_sheet->setCellValue("M$row", $tot_bln12);
                    $active_sheet->setCellValue("N$row", $tot_bln01);
                    $active_sheet->setCellValue("O$row", $tot_bln02);
                    $active_sheet->setCellValue("P$row", $tot_bln03);
                    $active_sheet->setCellValue("Q$row", $tot_sum);

                    $active_sheet->getStyle("B8:Q$row")->applyFromArray(array(
                        'borders' => array(
                            'allborders' => array(
                                'style' => PHPExcel_Style_Border::BORDER_THIN
                            )
                        ),
                    ));

                    $active_sheet->mergeCells("B$row:D$row");
                    $active_sheet->setCellValue("B$row", "TOTAL");
                    $active_sheet->getStyle("B$row:Q$row")->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('#CCCCCC');

                    $active_sheet->getStyle("B$row:Q$row")->applyFromArray(array(
                        'font' => array(
                            'bold' => true,
                            'size' => 12
                        )
                    ));
                }

                $tot_bln04_foh = $tot_bln04_foh + $tot_bln04;
                $tot_bln05_foh = $tot_bln05_foh + $tot_bln05;
                $tot_bln06_foh = $tot_bln06_foh + $tot_bln06;
                $tot_bln07_foh = $tot_bln07_foh + $tot_bln07;
                $tot_bln08_foh = $tot_bln08_foh + $tot_bln08;
                $tot_bln09_foh = $tot_bln09_foh + $tot_bln09;
                $tot_bln10_foh = $tot_bln10_foh + $tot_bln10;
                $tot_bln11_foh = $tot_bln11_foh + $tot_bln11;
                $tot_bln12_foh = $tot_bln12_foh + $tot_bln12;
                $tot_bln01_foh = $tot_bln01_foh + $tot_bln01;
                $tot_bln02_foh = $tot_bln02_foh + $tot_bln02;
                $tot_bln03_foh = $tot_bln03_foh + $tot_bln03;
                $tot_sum_foh = $tot_sum_foh + $tot_sum;

                $row = $row + 1;
            }

            $active_sheet->setCellValue("E$row", $tot_bln04_foh);
            $active_sheet->setCellValue("F$row", $tot_bln05_foh);
            $active_sheet->setCellValue("G$row", $tot_bln06_foh);
            $active_sheet->setCellValue("H$row", $tot_bln07_foh);
            $active_sheet->setCellValue("I$row", $tot_bln08_foh);
            $active_sheet->setCellValue("J$row", $tot_bln09_foh);
            $active_sheet->setCellValue("K$row", $tot_bln10_foh);
            $active_sheet->setCellValue("L$row", $tot_bln11_foh);
            $active_sheet->setCellValue("M$row", $tot_bln12_foh);
            $active_sheet->setCellValue("N$row", $tot_bln01_foh);
            $active_sheet->setCellValue("O$row", $tot_bln02_foh);
            $active_sheet->setCellValue("P$row", $tot_bln03_foh);
            $active_sheet->setCellValue("Q$row", $tot_sum_foh);

            $active_sheet->getStyle("B8:Q$row")->applyFromArray(array(
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                ),
            ));

            $active_sheet->mergeCells("B$row:D$row");
            $active_sheet->setCellValue("B$row", "GRAND TOTAL");
            $active_sheet->getStyle("B$row:Q$row")->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('#CCCCCC');

            $active_sheet->getStyle("B$row:Q$row")->applyFromArray(array(
                'font' => array(
                    'bold' => true,
                    'size' => 12
                )
            ));

            $row = $row + 3;
            //============== END FOH =============================================//

            //============== OPEX =================================================//
            //$active_sheet = $objPHPExcel->setActiveSheetIndexByName('OPX');
            $active_sheet->setCellValue("B$row", 'Sub Category');
            $active_sheet->setCellValue("C$row", 'Category FOH/OPEX');
            $active_sheet->setCellValue("D$row", 'Category A3');
            $active_sheet->setCellValue("E$row", 'APR');
            $active_sheet->setCellValue("F$row", 'MAY');
            $active_sheet->setCellValue("G$row", 'JUN');
            $active_sheet->setCellValue("H$row", 'JUL');
            $active_sheet->setCellValue("I$row", 'AUG');
            $active_sheet->setCellValue("J$row", 'SEP');
            $active_sheet->setCellValue("K$row", 'OCT');
            $active_sheet->setCellValue("L$row", 'NOV');
            $active_sheet->setCellValue("M$row", 'DEC');
            $active_sheet->setCellValue("N$row", 'JAN');
            $active_sheet->setCellValue("O$row", 'FEB');
            $active_sheet->setCellValue("P$row", 'MAR');
            $active_sheet->setCellValue("Q$row", 'TOTAL BUDGET');
            $row_x = $row + 1;
            $active_sheet->setCellValue("E$row_x", 'PLAN');
            $active_sheet->setCellValue("F$row_x", 'PLAN');
            $active_sheet->setCellValue("G$row_x", 'PLAN');
            $active_sheet->setCellValue("H$row_x", 'PLAN');
            $active_sheet->setCellValue("I$row_x", 'PLAN');
            $active_sheet->setCellValue("J$row_x", 'PLAN');
            $active_sheet->setCellValue("K$row_x", 'PLAN');
            $active_sheet->setCellValue("L$row_x", 'PLAN');
            $active_sheet->setCellValue("M$row_x", 'PLAN');
            $active_sheet->setCellValue("N$row_x", 'PLAN');
            $active_sheet->setCellValue("O$row_x", 'PLAN');
            $active_sheet->setCellValue("P$row_x", 'PLAN');
            $active_sheet->setCellValue("Q$row_x", 'PLAN');
            $row_y = $row + 2;
            $active_sheet->setCellValue("E$row_y", 'AMOUNT');
            $active_sheet->setCellValue("F$row_y", 'AMOUNT');
            $active_sheet->setCellValue("G$row_y", 'AMOUNT');
            $active_sheet->setCellValue("H$row_y", 'AMOUNT');
            $active_sheet->setCellValue("I$row_y", 'AMOUNT');
            $active_sheet->setCellValue("J$row_y", 'AMOUNT');
            $active_sheet->setCellValue("K$row_y", 'AMOUNT');
            $active_sheet->setCellValue("L$row_y", 'AMOUNT');
            $active_sheet->setCellValue("M$row_y", 'AMOUNT');
            $active_sheet->setCellValue("N$row_y", 'AMOUNT');
            $active_sheet->setCellValue("O$row_y", 'AMOUNT');
            $active_sheet->setCellValue("P$row_y", 'AMOUNT');
            $active_sheet->setCellValue("Q$row_y", 'AMOUNT');
            $active_sheet->mergeCells("B$row:B$row_y");
            $active_sheet->mergeCells("C$row:C$row_y");
            $active_sheet->mergeCells("D$row:D$row_y");
            $active_sheet->getStyle("B$row:Q$row_y")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $active_sheet->getStyle("B$row:Q$row_y")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $active_sheet->getStyle("B$row:Q$row_y")->getFont()->setBold(true)->setSize(10);            
            
            $active_sheet->getStyle("B$row:Q$row_y")->applyFromArray(array(
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                )
            ));
            
            $active_sheet->getStyle("B$row:Q$row")->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('#33CCCC');
            $active_sheet->getStyle("E$row_x:Q$row_x")->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('#FFFF00');
            $active_sheet->getStyle("E$row_y:Q$row_y")->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('#969696');
            
            $row = $row + 3;
            
            $tot_bln04_opx = 0;
            $tot_bln05_opx = 0;
            $tot_bln06_opx = 0;
            $tot_bln07_opx = 0;
            $tot_bln08_opx = 0;
            $tot_bln09_opx = 0;
            $tot_bln10_opx = 0;
            $tot_bln11_opx = 0;
            $tot_bln12_opx = 0;
            $tot_bln01_opx = 0;
            $tot_bln02_opx = 0;
            $tot_bln03_opx = 0;
            $tot_sum_opx = 0;

            foreach($category_opx as $opx){
                $CHR_CATEGORY = $opx->CHR_BUDGET_CATEGORY;
//                if($role == 2){
//                    $detail_confirm_opx = $this->report_budget_plan_m->get_expense_opx_by_category_per_dept_cpl($INT_ID_FISCAL_YEAR, $INT_DEPT, $CHR_CATEGORY);
//                } else {
                    $detail_confirm_opx = $this->report_budget_plan_m->get_expense_opx_by_category_per_dept($INT_ID_FISCAL_YEAR, $INT_DEPT, $CHR_CATEGORY);
//                }
                

                $tot_bln04 = 0;
                $tot_bln05 = 0;
                $tot_bln06 = 0;
                $tot_bln07 = 0;
                $tot_bln08 = 0;
                $tot_bln09 = 0;
                $tot_bln10 = 0;
                $tot_bln11 = 0;
                $tot_bln12 = 0;
                $tot_bln01 = 0;
                $tot_bln02 = 0;
                $tot_bln03 = 0;
                $tot_sum = 0;

                $count = count($detail_confirm_opx);

                if($count != 0){            
                    foreach ($detail_confirm_opx as $value) {
                        $CHR_BUDGET_SUB_CATEGORY_DESC = $value->CHR_BUDGET_SUB_CATEGORY_DESC;
                        $CHR_BUDGET_CATEGORY_DESC = $value->CHR_BUDGET_CATEGORY_DESC;
                        $CHR_CODE_CATEGORY_A3_DESC = $value->CHR_CODE_CATEGORY_A3_DESC;                
                        $MON_AMT_BLN01 = $value->MON_AMT_BLN01;
                        $MON_AMT_BLN02 = $value->MON_AMT_BLN02;
                        $MON_AMT_BLN03 = $value->MON_AMT_BLN03;
                        $MON_AMT_BLN04 = $value->MON_AMT_BLN04;
                        $MON_AMT_BLN05 = $value->MON_AMT_BLN05;
                        $MON_AMT_BLN06 = $value->MON_AMT_BLN06;
                        $MON_AMT_BLN07 = $value->MON_AMT_BLN07;
                        $MON_AMT_BLN08 = $value->MON_AMT_BLN08;
                        $MON_AMT_BLN09 = $value->MON_AMT_BLN09;
                        $MON_AMT_BLN10 = $value->MON_AMT_BLN10;
                        $MON_AMT_BLN11 = $value->MON_AMT_BLN11;
                        $MON_AMT_BLN12 = $value->MON_AMT_BLN12;
                        $MON_AMT_SUM = $value->MON_AMT_SUM;

                        $active_sheet->setCellValue("B$row", "$CHR_BUDGET_SUB_CATEGORY_DESC");
                        $active_sheet->setCellValue("C$row", "$CHR_BUDGET_CATEGORY_DESC");
                        $active_sheet->setCellValue("D$row", "$CHR_CODE_CATEGORY_A3_DESC");
                        $active_sheet->setCellValue("E$row", "$MON_AMT_BLN04");
                        $active_sheet->setCellValue("F$row", "$MON_AMT_BLN05");
                        $active_sheet->setCellValue("G$row", "$MON_AMT_BLN06");
                        $active_sheet->setCellValue("H$row", "$MON_AMT_BLN07");
                        $active_sheet->setCellValue("I$row", "$MON_AMT_BLN08");
                        $active_sheet->setCellValue("J$row", "$MON_AMT_BLN09");
                        $active_sheet->setCellValue("K$row", "$MON_AMT_BLN10");
                        $active_sheet->setCellValue("L$row", "$MON_AMT_BLN11");
                        $active_sheet->setCellValue("M$row", "$MON_AMT_BLN12");
                        $active_sheet->setCellValue("N$row", "$MON_AMT_BLN01");
                        $active_sheet->setCellValue("O$row", "$MON_AMT_BLN02");
                        $active_sheet->setCellValue("P$row", "$MON_AMT_BLN03");
                        $active_sheet->setCellValue("Q$row", "$MON_AMT_SUM");

                        $tot_bln04 = $tot_bln04 + $MON_AMT_BLN04;
                        $tot_bln05 = $tot_bln05 + $MON_AMT_BLN05;
                        $tot_bln06 = $tot_bln06 + $MON_AMT_BLN06;
                        $tot_bln07 = $tot_bln07 + $MON_AMT_BLN07;
                        $tot_bln08 = $tot_bln08 + $MON_AMT_BLN08;
                        $tot_bln09 = $tot_bln09 + $MON_AMT_BLN09;
                        $tot_bln10 = $tot_bln10 + $MON_AMT_BLN10;
                        $tot_bln11 = $tot_bln11 + $MON_AMT_BLN11;
                        $tot_bln12 = $tot_bln12 + $MON_AMT_BLN12;
                        $tot_bln01 = $tot_bln01 + $MON_AMT_BLN01;
                        $tot_bln02 = $tot_bln02 + $MON_AMT_BLN02;
                        $tot_bln03 = $tot_bln03 + $MON_AMT_BLN03;
                        $tot_sum = $tot_sum + $MON_AMT_SUM;

                        $row++;
                    }

                    $active_sheet->getStyle("B$row:Q$row")->applyFromArray(array(
                        'borders' => array(
                            'allborders' => array(
                                'style' => PHPExcel_Style_Border::BORDER_THIN
                            )
                        )
                    ));

                    $active_sheet->setCellValue("E$row", $tot_bln04);
                    $active_sheet->setCellValue("F$row", $tot_bln05);
                    $active_sheet->setCellValue("G$row", $tot_bln06);
                    $active_sheet->setCellValue("H$row", $tot_bln07);
                    $active_sheet->setCellValue("I$row", $tot_bln08);
                    $active_sheet->setCellValue("J$row", $tot_bln09);
                    $active_sheet->setCellValue("K$row", $tot_bln10);
                    $active_sheet->setCellValue("L$row", $tot_bln11);
                    $active_sheet->setCellValue("M$row", $tot_bln12);
                    $active_sheet->setCellValue("N$row", $tot_bln01);
                    $active_sheet->setCellValue("O$row", $tot_bln02);
                    $active_sheet->setCellValue("P$row", $tot_bln03);
                    $active_sheet->setCellValue("Q$row", $tot_sum);

                    $active_sheet->getStyle("B$row:Q$row")->applyFromArray(array(
                        'borders' => array(
                            'allborders' => array(
                                'style' => PHPExcel_Style_Border::BORDER_THIN
                            )
                        ),
                    ));

                    $active_sheet->mergeCells("B$row:D$row");
                    $active_sheet->setCellValue("B$row", "TOTAL");
                    $active_sheet->getStyle("B$row:Q$row")->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('#CCCCCC');

                    $active_sheet->getStyle("B$row:Q$row")->applyFromArray(array(
                        'font' => array(
                            'bold' => true,
                            'size' => 12
                        )
                    ));
                }

                $tot_bln04_opx = $tot_bln04_opx + $tot_bln04;
                $tot_bln05_opx = $tot_bln05_opx + $tot_bln05;
                $tot_bln06_opx = $tot_bln06_opx + $tot_bln06;
                $tot_bln07_opx = $tot_bln07_opx + $tot_bln07;
                $tot_bln08_opx = $tot_bln08_opx + $tot_bln08;
                $tot_bln09_opx = $tot_bln09_opx + $tot_bln09;
                $tot_bln10_opx = $tot_bln10_opx + $tot_bln10;
                $tot_bln11_opx = $tot_bln11_opx + $tot_bln11;
                $tot_bln12_opx = $tot_bln12_opx + $tot_bln12;
                $tot_bln01_opx = $tot_bln01_opx + $tot_bln01;
                $tot_bln02_opx = $tot_bln02_opx + $tot_bln02;
                $tot_bln03_opx = $tot_bln03_opx + $tot_bln03;
                $tot_sum_opx = $tot_sum_opx + $tot_sum;

                $row = $row + 1;
            }

            $active_sheet->setCellValue("E$row", $tot_bln04_opx);
            $active_sheet->setCellValue("F$row", $tot_bln05_opx);
            $active_sheet->setCellValue("G$row", $tot_bln06_opx);
            $active_sheet->setCellValue("H$row", $tot_bln07_opx);
            $active_sheet->setCellValue("I$row", $tot_bln08_opx);
            $active_sheet->setCellValue("J$row", $tot_bln09_opx);
            $active_sheet->setCellValue("K$row", $tot_bln10_opx);
            $active_sheet->setCellValue("L$row", $tot_bln11_opx);
            $active_sheet->setCellValue("M$row", $tot_bln12_opx);
            $active_sheet->setCellValue("N$row", $tot_bln01_opx);
            $active_sheet->setCellValue("O$row", $tot_bln02_opx);
            $active_sheet->setCellValue("P$row", $tot_bln03_opx);
            $active_sheet->setCellValue("Q$row", $tot_sum_opx);

            $active_sheet->getStyle("B$row:Q$row")->applyFromArray(array(
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                ),
            ));

            $active_sheet->mergeCells("B$row:D$row");
            $active_sheet->setCellValue("B$row", "GRAND TOTAL");
            $active_sheet->getStyle("B$row:Q$row")->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('#CCCCCC');

            $active_sheet->getStyle("B$row:Q$row")->applyFromArray(array(
                'font' => array(
                    'bold' => true,
                    'size' => 12
                )
            ));

            $row = $row + 3;

            $gdImage = imagecreatefromjpeg('assets/template/budget/report/approval.JPG');
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
            //============== END OPEX =============================================//
        }
        
        ob_end_clean();
        $filename = "$CHR_FISCAL_YEAR_DESC - EXPENSE FOH-OPEX.xls";
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . trim($filename) . '"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->setIncludeCharts(TRUE);
        $objWriter->save('php://output');
    }
    
    function download_expense_per_group($INT_ID_FISCAL_YEAR = null) { 
        $user_session = $this->session->all_userdata();
        $role = $user_session['ROLE'];
        $all_group = $this->groupdept_m->get_groupdept();  
//        print_r($all_group);
//        exit();
        
        $CHR_FISCAL_YEAR_DESC = trim($this->fiscal_m->select_fiscal_year($INT_ID_FISCAL_YEAR));
        
        $this->load->library('excel');
        $objReader = PHPExcel_IOFactory::createReader('Excel5');
        // Create new PHPExcel object

        $objPHPExcel = $objReader->load("assets/template/budget/report/Template_Report_Summary_Exp_Company_Group.xls");
        
        foreach($all_group as $group){
            $INT_GROUP = $group->INT_ID_GROUP_DEPT;
//            if($role == 2){
//                $category_foh = $this->budget_expense_m->get_category_expense_foh_group_cpl($INT_ID_FISCAL_YEAR, $INT_GROUP);
//                $category_opx = $this->budget_expense_m->get_category_expense_opx_group_cpl($INT_ID_FISCAL_YEAR, $INT_GROUP);
//            } else {
                $category_foh = $this->budget_expense_m->get_category_expense_foh_group($INT_ID_FISCAL_YEAR, $INT_GROUP);
                $category_opx = $this->budget_expense_m->get_category_expense_opx_group($INT_ID_FISCAL_YEAR, $INT_GROUP); 
//            }            
            
            $CHR_GROUP = trim($group->CHR_GROUP_DEPT);
            $CHR_GROUP_DESC = trim($group->CHR_GROUP_DEPT_DESC);
            
            $row = 8;
            $active_sheet = $objPHPExcel->setActiveSheetIndexByName($CHR_GROUP);
            $active_sheet->setCellValue("B2", "MASTER BUDGET : EXPENSE FOH/OPEX TAHUN " . $CHR_FISCAL_YEAR_DESC);
            $active_sheet->setCellValue("B3", "GROUP : " . $CHR_GROUP . " - " . $CHR_GROUP_DESC);
            
            //============== FOH =================================================//           

            $tot_bln04_foh = 0;
            $tot_bln05_foh = 0;
            $tot_bln06_foh = 0;
            $tot_bln07_foh = 0;
            $tot_bln08_foh = 0;
            $tot_bln09_foh = 0;
            $tot_bln10_foh = 0;
            $tot_bln11_foh = 0;
            $tot_bln12_foh = 0;
            $tot_bln01_foh = 0;
            $tot_bln02_foh = 0;
            $tot_bln03_foh = 0;
            $tot_sum_foh = 0;        

            foreach($category_foh as $foh){
                $CHR_CATEGORY = $foh->CHR_BUDGET_CATEGORY;
//                if($role == 2){
//                    $detail_confirm_foh = $this->report_budget_plan_m->get_expense_foh_by_category_per_group_cpl($INT_ID_FISCAL_YEAR, $INT_GROUP, $CHR_CATEGORY);
//                } else {
                    $detail_confirm_foh = $this->report_budget_plan_m->get_expense_foh_by_category_per_group($INT_ID_FISCAL_YEAR, $INT_GROUP, $CHR_CATEGORY);
//                }
                

                $tot_bln04 = 0;
                $tot_bln05 = 0;
                $tot_bln06 = 0;
                $tot_bln07 = 0;
                $tot_bln08 = 0;
                $tot_bln09 = 0;
                $tot_bln10 = 0;
                $tot_bln11 = 0;
                $tot_bln12 = 0;
                $tot_bln01 = 0;
                $tot_bln02 = 0;
                $tot_bln03 = 0;
                $tot_sum = 0;

                $count = count($detail_confirm_foh);

                if($count != 0){
                    foreach ($detail_confirm_foh as $value) {
                        $CHR_BUDGET_SUB_CATEGORY_DESC = $value->CHR_BUDGET_SUB_CATEGORY_DESC;
                        $CHR_BUDGET_CATEGORY_DESC = $value->CHR_BUDGET_CATEGORY_DESC;
                        $CHR_CODE_CATEGORY_A3_DESC = $value->CHR_CODE_CATEGORY_A3_DESC;                
                        $MON_AMT_BLN01 = $value->MON_AMT_BLN01;
                        $MON_AMT_BLN02 = $value->MON_AMT_BLN02;
                        $MON_AMT_BLN03 = $value->MON_AMT_BLN03;
                        $MON_AMT_BLN04 = $value->MON_AMT_BLN04;
                        $MON_AMT_BLN05 = $value->MON_AMT_BLN05;
                        $MON_AMT_BLN06 = $value->MON_AMT_BLN06;
                        $MON_AMT_BLN07 = $value->MON_AMT_BLN07;
                        $MON_AMT_BLN08 = $value->MON_AMT_BLN08;
                        $MON_AMT_BLN09 = $value->MON_AMT_BLN09;
                        $MON_AMT_BLN10 = $value->MON_AMT_BLN10;
                        $MON_AMT_BLN11 = $value->MON_AMT_BLN11;
                        $MON_AMT_BLN12 = $value->MON_AMT_BLN12;
                        $MON_AMT_SUM = $value->MON_AMT_SUM;

                        $active_sheet->setCellValue("B$row", "$CHR_BUDGET_SUB_CATEGORY_DESC");
                        $active_sheet->setCellValue("C$row", "$CHR_BUDGET_CATEGORY_DESC");
                        $active_sheet->setCellValue("D$row", "$CHR_CODE_CATEGORY_A3_DESC");
                        $active_sheet->setCellValue("E$row", "$MON_AMT_BLN04");
                        $active_sheet->setCellValue("F$row", "$MON_AMT_BLN05");
                        $active_sheet->setCellValue("G$row", "$MON_AMT_BLN06");
                        $active_sheet->setCellValue("H$row", "$MON_AMT_BLN07");
                        $active_sheet->setCellValue("I$row", "$MON_AMT_BLN08");
                        $active_sheet->setCellValue("J$row", "$MON_AMT_BLN09");
                        $active_sheet->setCellValue("K$row", "$MON_AMT_BLN10");
                        $active_sheet->setCellValue("L$row", "$MON_AMT_BLN11");
                        $active_sheet->setCellValue("M$row", "$MON_AMT_BLN12");
                        $active_sheet->setCellValue("N$row", "$MON_AMT_BLN01");
                        $active_sheet->setCellValue("O$row", "$MON_AMT_BLN02");
                        $active_sheet->setCellValue("P$row", "$MON_AMT_BLN03");
                        $active_sheet->setCellValue("Q$row", "$MON_AMT_SUM");

                        $tot_bln04 = $tot_bln04 + $MON_AMT_BLN04;
                        $tot_bln05 = $tot_bln05 + $MON_AMT_BLN05;
                        $tot_bln06 = $tot_bln06 + $MON_AMT_BLN06;
                        $tot_bln07 = $tot_bln07 + $MON_AMT_BLN07;
                        $tot_bln08 = $tot_bln08 + $MON_AMT_BLN08;
                        $tot_bln09 = $tot_bln09 + $MON_AMT_BLN09;
                        $tot_bln10 = $tot_bln10 + $MON_AMT_BLN10;
                        $tot_bln11 = $tot_bln11 + $MON_AMT_BLN11;
                        $tot_bln12 = $tot_bln12 + $MON_AMT_BLN12;
                        $tot_bln01 = $tot_bln01 + $MON_AMT_BLN01;
                        $tot_bln02 = $tot_bln02 + $MON_AMT_BLN02;
                        $tot_bln03 = $tot_bln03 + $MON_AMT_BLN03;
                        $tot_sum = $tot_sum + $MON_AMT_SUM;

                        $row++;
                    }            

                    $active_sheet->getStyle("B8:Q$row")->applyFromArray(array(
                        'borders' => array(
                            'allborders' => array(
                                'style' => PHPExcel_Style_Border::BORDER_THIN
                            )
                        )
                    ));

                    $active_sheet->setCellValue("E$row", $tot_bln04);
                    $active_sheet->setCellValue("F$row", $tot_bln05);
                    $active_sheet->setCellValue("G$row", $tot_bln06);
                    $active_sheet->setCellValue("H$row", $tot_bln07);
                    $active_sheet->setCellValue("I$row", $tot_bln08);
                    $active_sheet->setCellValue("J$row", $tot_bln09);
                    $active_sheet->setCellValue("K$row", $tot_bln10);
                    $active_sheet->setCellValue("L$row", $tot_bln11);
                    $active_sheet->setCellValue("M$row", $tot_bln12);
                    $active_sheet->setCellValue("N$row", $tot_bln01);
                    $active_sheet->setCellValue("O$row", $tot_bln02);
                    $active_sheet->setCellValue("P$row", $tot_bln03);
                    $active_sheet->setCellValue("Q$row", $tot_sum);

                    $active_sheet->getStyle("B8:Q$row")->applyFromArray(array(
                        'borders' => array(
                            'allborders' => array(
                                'style' => PHPExcel_Style_Border::BORDER_THIN
                            )
                        ),
                    ));

                    $active_sheet->mergeCells("B$row:D$row");
                    $active_sheet->setCellValue("B$row", "TOTAL");
                    $active_sheet->getStyle("B$row:Q$row")->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('#CCCCCC');

                    $active_sheet->getStyle("B$row:Q$row")->applyFromArray(array(
                        'font' => array(
                            'bold' => true,
                            'size' => 12
                        )
                    ));
                }

                $tot_bln04_foh = $tot_bln04_foh + $tot_bln04;
                $tot_bln05_foh = $tot_bln05_foh + $tot_bln05;
                $tot_bln06_foh = $tot_bln06_foh + $tot_bln06;
                $tot_bln07_foh = $tot_bln07_foh + $tot_bln07;
                $tot_bln08_foh = $tot_bln08_foh + $tot_bln08;
                $tot_bln09_foh = $tot_bln09_foh + $tot_bln09;
                $tot_bln10_foh = $tot_bln10_foh + $tot_bln10;
                $tot_bln11_foh = $tot_bln11_foh + $tot_bln11;
                $tot_bln12_foh = $tot_bln12_foh + $tot_bln12;
                $tot_bln01_foh = $tot_bln01_foh + $tot_bln01;
                $tot_bln02_foh = $tot_bln02_foh + $tot_bln02;
                $tot_bln03_foh = $tot_bln03_foh + $tot_bln03;
                $tot_sum_foh = $tot_sum_foh + $tot_sum;

                $row = $row + 1;
            }

            $active_sheet->setCellValue("E$row", $tot_bln04_foh);
            $active_sheet->setCellValue("F$row", $tot_bln05_foh);
            $active_sheet->setCellValue("G$row", $tot_bln06_foh);
            $active_sheet->setCellValue("H$row", $tot_bln07_foh);
            $active_sheet->setCellValue("I$row", $tot_bln08_foh);
            $active_sheet->setCellValue("J$row", $tot_bln09_foh);
            $active_sheet->setCellValue("K$row", $tot_bln10_foh);
            $active_sheet->setCellValue("L$row", $tot_bln11_foh);
            $active_sheet->setCellValue("M$row", $tot_bln12_foh);
            $active_sheet->setCellValue("N$row", $tot_bln01_foh);
            $active_sheet->setCellValue("O$row", $tot_bln02_foh);
            $active_sheet->setCellValue("P$row", $tot_bln03_foh);
            $active_sheet->setCellValue("Q$row", $tot_sum_foh);

            $active_sheet->getStyle("B8:Q$row")->applyFromArray(array(
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                ),
            ));

            $active_sheet->mergeCells("B$row:D$row");
            $active_sheet->setCellValue("B$row", "GRAND TOTAL");
            $active_sheet->getStyle("B$row:Q$row")->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('#CCCCCC');

            $active_sheet->getStyle("B$row:Q$row")->applyFromArray(array(
                'font' => array(
                    'bold' => true,
                    'size' => 12
                )
            ));

            $row = $row + 3;
            //============== END FOH =============================================//

            //============== OPEX =================================================//
            //$active_sheet = $objPHPExcel->setActiveSheetIndexByName('OPX');
            $active_sheet->setCellValue("B$row", 'Sub Category');
            $active_sheet->setCellValue("C$row", 'Category FOH/OPEX');
            $active_sheet->setCellValue("D$row", 'Category A3');
            $active_sheet->setCellValue("E$row", 'APR');
            $active_sheet->setCellValue("F$row", 'MAY');
            $active_sheet->setCellValue("G$row", 'JUN');
            $active_sheet->setCellValue("H$row", 'JUL');
            $active_sheet->setCellValue("I$row", 'AUG');
            $active_sheet->setCellValue("J$row", 'SEP');
            $active_sheet->setCellValue("K$row", 'OCT');
            $active_sheet->setCellValue("L$row", 'NOV');
            $active_sheet->setCellValue("M$row", 'DEC');
            $active_sheet->setCellValue("N$row", 'JAN');
            $active_sheet->setCellValue("O$row", 'FEB');
            $active_sheet->setCellValue("P$row", 'MAR');
            $active_sheet->setCellValue("Q$row", 'TOTAL BUDGET');
            $row_x = $row + 1;
            $active_sheet->setCellValue("E$row_x", 'PLAN');
            $active_sheet->setCellValue("F$row_x", 'PLAN');
            $active_sheet->setCellValue("G$row_x", 'PLAN');
            $active_sheet->setCellValue("H$row_x", 'PLAN');
            $active_sheet->setCellValue("I$row_x", 'PLAN');
            $active_sheet->setCellValue("J$row_x", 'PLAN');
            $active_sheet->setCellValue("K$row_x", 'PLAN');
            $active_sheet->setCellValue("L$row_x", 'PLAN');
            $active_sheet->setCellValue("M$row_x", 'PLAN');
            $active_sheet->setCellValue("N$row_x", 'PLAN');
            $active_sheet->setCellValue("O$row_x", 'PLAN');
            $active_sheet->setCellValue("P$row_x", 'PLAN');
            $active_sheet->setCellValue("Q$row_x", 'PLAN');
            $row_y = $row + 2;
            $active_sheet->setCellValue("E$row_y", 'AMOUNT');
            $active_sheet->setCellValue("F$row_y", 'AMOUNT');
            $active_sheet->setCellValue("G$row_y", 'AMOUNT');
            $active_sheet->setCellValue("H$row_y", 'AMOUNT');
            $active_sheet->setCellValue("I$row_y", 'AMOUNT');
            $active_sheet->setCellValue("J$row_y", 'AMOUNT');
            $active_sheet->setCellValue("K$row_y", 'AMOUNT');
            $active_sheet->setCellValue("L$row_y", 'AMOUNT');
            $active_sheet->setCellValue("M$row_y", 'AMOUNT');
            $active_sheet->setCellValue("N$row_y", 'AMOUNT');
            $active_sheet->setCellValue("O$row_y", 'AMOUNT');
            $active_sheet->setCellValue("P$row_y", 'AMOUNT');
            $active_sheet->setCellValue("Q$row_y", 'AMOUNT');
            $active_sheet->mergeCells("B$row:B$row_y");
            $active_sheet->mergeCells("C$row:C$row_y");
            $active_sheet->mergeCells("D$row:D$row_y");
            $active_sheet->getStyle("B$row:Q$row_y")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $active_sheet->getStyle("B$row:Q$row_y")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $active_sheet->getStyle("B$row:Q$row_y")->getFont()->setBold(true)->setSize(10);            
            
            $active_sheet->getStyle("B$row:Q$row_y")->applyFromArray(array(
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                )
            ));
            
            $active_sheet->getStyle("B$row:Q$row")->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('#33CCCC');
            $active_sheet->getStyle("E$row_x:Q$row_x")->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('#FFFF00');
            $active_sheet->getStyle("E$row_y:Q$row_y")->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('#969696');
            
            $row = $row + 3;
            
            $tot_bln04_opx = 0;
            $tot_bln05_opx = 0;
            $tot_bln06_opx = 0;
            $tot_bln07_opx = 0;
            $tot_bln08_opx = 0;
            $tot_bln09_opx = 0;
            $tot_bln10_opx = 0;
            $tot_bln11_opx = 0;
            $tot_bln12_opx = 0;
            $tot_bln01_opx = 0;
            $tot_bln02_opx = 0;
            $tot_bln03_opx = 0;
            $tot_sum_opx = 0;

            foreach($category_opx as $opx){
                $CHR_CATEGORY = $opx->CHR_BUDGET_CATEGORY;
//                if($role == 2){
//                    $detail_confirm_opx = $this->report_budget_plan_m->get_expense_opx_by_category_per_group_cpl($INT_ID_FISCAL_YEAR, $INT_GROUP, $CHR_CATEGORY);
//                } else {
                    $detail_confirm_opx = $this->report_budget_plan_m->get_expense_opx_by_category_per_group($INT_ID_FISCAL_YEAR, $INT_GROUP, $CHR_CATEGORY);
//                }
                

                $tot_bln04 = 0;
                $tot_bln05 = 0;
                $tot_bln06 = 0;
                $tot_bln07 = 0;
                $tot_bln08 = 0;
                $tot_bln09 = 0;
                $tot_bln10 = 0;
                $tot_bln11 = 0;
                $tot_bln12 = 0;
                $tot_bln01 = 0;
                $tot_bln02 = 0;
                $tot_bln03 = 0;
                $tot_sum = 0;

                $count = count($detail_confirm_opx);

                if($count != 0){            
                    foreach ($detail_confirm_opx as $value) {
                        $CHR_BUDGET_SUB_CATEGORY_DESC = $value->CHR_BUDGET_SUB_CATEGORY_DESC;
                        $CHR_BUDGET_CATEGORY_DESC = $value->CHR_BUDGET_CATEGORY_DESC;
                        $CHR_CODE_CATEGORY_A3_DESC = $value->CHR_CODE_CATEGORY_A3_DESC;                
                        $MON_AMT_BLN01 = $value->MON_AMT_BLN01;
                        $MON_AMT_BLN02 = $value->MON_AMT_BLN02;
                        $MON_AMT_BLN03 = $value->MON_AMT_BLN03;
                        $MON_AMT_BLN04 = $value->MON_AMT_BLN04;
                        $MON_AMT_BLN05 = $value->MON_AMT_BLN05;
                        $MON_AMT_BLN06 = $value->MON_AMT_BLN06;
                        $MON_AMT_BLN07 = $value->MON_AMT_BLN07;
                        $MON_AMT_BLN08 = $value->MON_AMT_BLN08;
                        $MON_AMT_BLN09 = $value->MON_AMT_BLN09;
                        $MON_AMT_BLN10 = $value->MON_AMT_BLN10;
                        $MON_AMT_BLN11 = $value->MON_AMT_BLN11;
                        $MON_AMT_BLN12 = $value->MON_AMT_BLN12;
                        $MON_AMT_SUM = $value->MON_AMT_SUM;

                        $active_sheet->setCellValue("B$row", "$CHR_BUDGET_SUB_CATEGORY_DESC");
                        $active_sheet->setCellValue("C$row", "$CHR_BUDGET_CATEGORY_DESC");
                        $active_sheet->setCellValue("D$row", "$CHR_CODE_CATEGORY_A3_DESC");
                        $active_sheet->setCellValue("E$row", "$MON_AMT_BLN04");
                        $active_sheet->setCellValue("F$row", "$MON_AMT_BLN05");
                        $active_sheet->setCellValue("G$row", "$MON_AMT_BLN06");
                        $active_sheet->setCellValue("H$row", "$MON_AMT_BLN07");
                        $active_sheet->setCellValue("I$row", "$MON_AMT_BLN08");
                        $active_sheet->setCellValue("J$row", "$MON_AMT_BLN09");
                        $active_sheet->setCellValue("K$row", "$MON_AMT_BLN10");
                        $active_sheet->setCellValue("L$row", "$MON_AMT_BLN11");
                        $active_sheet->setCellValue("M$row", "$MON_AMT_BLN12");
                        $active_sheet->setCellValue("N$row", "$MON_AMT_BLN01");
                        $active_sheet->setCellValue("O$row", "$MON_AMT_BLN02");
                        $active_sheet->setCellValue("P$row", "$MON_AMT_BLN03");
                        $active_sheet->setCellValue("Q$row", "$MON_AMT_SUM");

                        $tot_bln04 = $tot_bln04 + $MON_AMT_BLN04;
                        $tot_bln05 = $tot_bln05 + $MON_AMT_BLN05;
                        $tot_bln06 = $tot_bln06 + $MON_AMT_BLN06;
                        $tot_bln07 = $tot_bln07 + $MON_AMT_BLN07;
                        $tot_bln08 = $tot_bln08 + $MON_AMT_BLN08;
                        $tot_bln09 = $tot_bln09 + $MON_AMT_BLN09;
                        $tot_bln10 = $tot_bln10 + $MON_AMT_BLN10;
                        $tot_bln11 = $tot_bln11 + $MON_AMT_BLN11;
                        $tot_bln12 = $tot_bln12 + $MON_AMT_BLN12;
                        $tot_bln01 = $tot_bln01 + $MON_AMT_BLN01;
                        $tot_bln02 = $tot_bln02 + $MON_AMT_BLN02;
                        $tot_bln03 = $tot_bln03 + $MON_AMT_BLN03;
                        $tot_sum = $tot_sum + $MON_AMT_SUM;

                        $row++;
                    }

                    $active_sheet->getStyle("B$row:Q$row")->applyFromArray(array(
                        'borders' => array(
                            'allborders' => array(
                                'style' => PHPExcel_Style_Border::BORDER_THIN
                            )
                        )
                    ));

                    $active_sheet->setCellValue("E$row", $tot_bln04);
                    $active_sheet->setCellValue("F$row", $tot_bln05);
                    $active_sheet->setCellValue("G$row", $tot_bln06);
                    $active_sheet->setCellValue("H$row", $tot_bln07);
                    $active_sheet->setCellValue("I$row", $tot_bln08);
                    $active_sheet->setCellValue("J$row", $tot_bln09);
                    $active_sheet->setCellValue("K$row", $tot_bln10);
                    $active_sheet->setCellValue("L$row", $tot_bln11);
                    $active_sheet->setCellValue("M$row", $tot_bln12);
                    $active_sheet->setCellValue("N$row", $tot_bln01);
                    $active_sheet->setCellValue("O$row", $tot_bln02);
                    $active_sheet->setCellValue("P$row", $tot_bln03);
                    $active_sheet->setCellValue("Q$row", $tot_sum);

                    $active_sheet->getStyle("B$row:Q$row")->applyFromArray(array(
                        'borders' => array(
                            'allborders' => array(
                                'style' => PHPExcel_Style_Border::BORDER_THIN
                            )
                        ),
                    ));

                    $active_sheet->mergeCells("B$row:D$row");
                    $active_sheet->setCellValue("B$row", "TOTAL");
                    $active_sheet->getStyle("B$row:Q$row")->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('#CCCCCC');

                    $active_sheet->getStyle("B$row:Q$row")->applyFromArray(array(
                        'font' => array(
                            'bold' => true,
                            'size' => 12
                        )
                    ));
                }

                $tot_bln04_opx = $tot_bln04_opx + $tot_bln04;
                $tot_bln05_opx = $tot_bln05_opx + $tot_bln05;
                $tot_bln06_opx = $tot_bln06_opx + $tot_bln06;
                $tot_bln07_opx = $tot_bln07_opx + $tot_bln07;
                $tot_bln08_opx = $tot_bln08_opx + $tot_bln08;
                $tot_bln09_opx = $tot_bln09_opx + $tot_bln09;
                $tot_bln10_opx = $tot_bln10_opx + $tot_bln10;
                $tot_bln11_opx = $tot_bln11_opx + $tot_bln11;
                $tot_bln12_opx = $tot_bln12_opx + $tot_bln12;
                $tot_bln01_opx = $tot_bln01_opx + $tot_bln01;
                $tot_bln02_opx = $tot_bln02_opx + $tot_bln02;
                $tot_bln03_opx = $tot_bln03_opx + $tot_bln03;
                $tot_sum_opx = $tot_sum_opx + $tot_sum;

                $row = $row + 1;
            }

            $active_sheet->setCellValue("E$row", $tot_bln04_opx);
            $active_sheet->setCellValue("F$row", $tot_bln05_opx);
            $active_sheet->setCellValue("G$row", $tot_bln06_opx);
            $active_sheet->setCellValue("H$row", $tot_bln07_opx);
            $active_sheet->setCellValue("I$row", $tot_bln08_opx);
            $active_sheet->setCellValue("J$row", $tot_bln09_opx);
            $active_sheet->setCellValue("K$row", $tot_bln10_opx);
            $active_sheet->setCellValue("L$row", $tot_bln11_opx);
            $active_sheet->setCellValue("M$row", $tot_bln12_opx);
            $active_sheet->setCellValue("N$row", $tot_bln01_opx);
            $active_sheet->setCellValue("O$row", $tot_bln02_opx);
            $active_sheet->setCellValue("P$row", $tot_bln03_opx);
            $active_sheet->setCellValue("Q$row", $tot_sum_opx);

            $active_sheet->getStyle("B$row:Q$row")->applyFromArray(array(
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                ),
            ));

            $active_sheet->mergeCells("B$row:D$row");
            $active_sheet->setCellValue("B$row", "GRAND TOTAL");
            $active_sheet->getStyle("B$row:Q$row")->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('#CCCCCC');

            $active_sheet->getStyle("B$row:Q$row")->applyFromArray(array(
                'font' => array(
                    'bold' => true,
                    'size' => 12
                )
            ));

            $row = $row + 3;

            $gdImage = imagecreatefromjpeg('assets/template/budget/report/approval.JPG');
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
            //============== END OPEX =============================================//
        }
        
        ob_end_clean();
        $filename = "$CHR_FISCAL_YEAR_DESC - EXPENSE FOH-OPEX PER GROUP DEPT.xls";
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . trim($filename) . '"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->setIncludeCharts(TRUE);
        $objWriter->save('php://output');
    }
    
    //============ CAPEX PER DEPT ======================================
    function download_summary_company_capex($INT_ID_FISCAL_YEAR = null, $INT_ID_BUDGET_GROUP = null) {
        $user_session = $this->session->all_userdata();
        $role = $user_session['ROLE'];
        $row = 7;

//        if($role == 2){
//            $detail_confirm = $this->report_budget_plan_m->get_detail_capex_cpl($INT_ID_FISCAL_YEAR);
//        } else {
            $detail_confirm = $this->report_budget_plan_m->get_detail_capex($INT_ID_FISCAL_YEAR);
//        }

        $this->load->library('excel');
        $objReader = PHPExcel_IOFactory::createReader('Excel5');
        // Create new PHPExcel object

        $objPHPExcel = $objReader->load("assets/template/budget/report/Template_Report_Capex.xls");

        $seq = 1;
        $objPHPExcel->getActiveSheet()->setCellValue("B2", "MASTER BUDGET : CAPEX TAHUN " . $INT_ID_FISCAL_YEAR);
        $objPHPExcel->getActiveSheet()->setCellValue("B3", "DEPARTMENT : ALL");
        foreach ($detail_confirm as $value) {
            // $CHR_SECTION_DESC = $this->section_m->get_desc_section($value->INT_SECT);
            $CHR_NO_BUDGET = $value->CHR_NO_BUDGET;
            $INT_ID_FISCAL_YEAR = $value->INT_ID_FISCAL_YEAR;
            $CHR_BUDGET_TYPE = $value->CHR_BUDGET_TYPE;
            $CHR_BUDGET_TYPE_DESC = $value->CHR_BUDGET_TYPE_DESC;
            $CHR_BUDGET_SUB_CATEGORY = $value->CHR_BUDGET_SUB_CATEGORY;
            $CHR_BUDGET_SUB_CATEGORY_DESC = $value->CHR_BUDGET_SUB_CATEGORY_DESC;
            $CHR_BUDGET_CATEGORY = $value->CHR_BUDGET_CATEGORY;
            $CHR_BUDGET_CATEGORY_DESC = $value->CHR_BUDGET_CATEGORY_DESC;
            $CHR_CODE_CATEGORY_A3 = $value->CHR_CODE_CATEGORY_A3;
            $CHR_CODE_CATEGORY_A3_DESC = $value->CHR_CODE_CATEGORY_A3_DESC; 
            $CHR_BUDGET_DESC = $value->CHR_BUDGET_DESC; 

            $CHR_PURPOSE = $this->purposebudget_m->get_purposebudget_by_code($value->CHR_PURPOSE)->CHR_PURPOSE_DESC;
            $CHR_PROJECT = $value->CHR_PROJECT;
            $CHR_PRODUCT = $value->CHR_PRODUCT;
            $CHR_PROJECT = $value->CHR_PROJECT;

            if($value->INT_FLG_CIP == 0){
                $INT_FLG_CIP = 'No';
            } else {
                $INT_FLG_CIP = 'Yes';
            }

            $CHR_STATUS = $value->CHR_STATUS_BUDGET;
            $CHR_RUN_DEPC = $value->CHR_RUN_DEPRECIATION;
            $CHR_SUPPLIER = $value->CHR_SUPPLIER_LOCATION;
            $CHR_OWNER = $value->CHR_DIE_OWNER;
            $CHR_UNIT = $value->CHR_SATUAN;
            $CHR_ORG_CURR = $value->CHR_ORG_CURR;
            $FLT_RATE_CURR = $value->FLT_RATE_CURR;
            $CHR_PROJECT = $value->CHR_PROJECT;

            $MON_PRICE_ORI = $value->MON_PRICE_ORI;
            $MON_PRICE_IDR = $value->MON_PRICE_IDR;
            $MON_INKLARING = $value->MON_INKLARING;
            $MON_ENGFEE = $value->MON_ENGFEE;
            $MON_IMPORT_DUTY = $value->MON_IMPORT_DUTY;

            $INT_QTY_BLN01 = $value->INT_QTY_BLN01;
            $INT_QTY_BLN02 = $value->INT_QTY_BLN02;
            $INT_QTY_BLN03 = $value->INT_QTY_BLN03;
            $INT_QTY_BLN04 = $value->INT_QTY_BLN04;
            $INT_QTY_BLN05 = $value->INT_QTY_BLN05;
            $INT_QTY_BLN06 = $value->INT_QTY_BLN06;
            $INT_QTY_BLN07 = $value->INT_QTY_BLN07;
            $INT_QTY_BLN08 = $value->INT_QTY_BLN08;
            $INT_QTY_BLN09 = $value->INT_QTY_BLN09;
            $INT_QTY_BLN10 = $value->INT_QTY_BLN10;
            $INT_QTY_BLN11 = $value->INT_QTY_BLN11;
            $INT_QTY_BLN12 = $value->INT_QTY_BLN12;
            $INT_QTY_SUM = $value->INT_QTY_SUM;

            //PRICE PRE UNIT IDR in MONTH
            $MON_IDR_BLN01 = $MON_PRICE_IDR * $INT_QTY_BLN01;
            $MON_IDR_BLN02 = $MON_PRICE_IDR * $INT_QTY_BLN02;
            $MON_IDR_BLN03 = $MON_PRICE_IDR * $INT_QTY_BLN03;
            $MON_IDR_BLN04 = $MON_PRICE_IDR * $INT_QTY_BLN04;
            $MON_IDR_BLN05 = $MON_PRICE_IDR * $INT_QTY_BLN05;
            $MON_IDR_BLN06 = $MON_PRICE_IDR * $INT_QTY_BLN06;
            $MON_IDR_BLN07 = $MON_PRICE_IDR * $INT_QTY_BLN07;
            $MON_IDR_BLN08 = $MON_PRICE_IDR * $INT_QTY_BLN08;
            $MON_IDR_BLN09 = $MON_PRICE_IDR * $INT_QTY_BLN09;
            $MON_IDR_BLN10 = $MON_PRICE_IDR * $INT_QTY_BLN10;
            $MON_IDR_BLN11 = $MON_PRICE_IDR * $INT_QTY_BLN11;
            $MON_IDR_BLN12 = $MON_PRICE_IDR * $INT_QTY_BLN12;
            $MON_IDR_SUM = $MON_IDR_BLN01 + $MON_IDR_BLN02 + $MON_IDR_BLN03 + $MON_IDR_BLN04 + $MON_IDR_BLN05 + $MON_IDR_BLN06 + $MON_IDR_BLN07 + $MON_IDR_BLN08 + $MON_IDR_BLN09 + $MON_IDR_BLN10 + $MON_IDR_BLN11 + $MON_IDR_BLN12;

            //INKLARING IDR in MONTH
            $MON_INK_BLN01 = $MON_INKLARING * $INT_QTY_BLN01;
            $MON_INK_BLN02 = $MON_INKLARING * $INT_QTY_BLN02;
            $MON_INK_BLN03 = $MON_INKLARING * $INT_QTY_BLN03;
            $MON_INK_BLN04 = $MON_INKLARING * $INT_QTY_BLN04;
            $MON_INK_BLN05 = $MON_INKLARING * $INT_QTY_BLN05;
            $MON_INK_BLN06 = $MON_INKLARING * $INT_QTY_BLN06;
            $MON_INK_BLN07 = $MON_INKLARING * $INT_QTY_BLN07;
            $MON_INK_BLN08 = $MON_INKLARING * $INT_QTY_BLN08;
            $MON_INK_BLN09 = $MON_INKLARING * $INT_QTY_BLN09;
            $MON_INK_BLN10 = $MON_INKLARING * $INT_QTY_BLN10;
            $MON_INK_BLN11 = $MON_INKLARING * $INT_QTY_BLN11;
            $MON_INK_BLN12 = $MON_INKLARING * $INT_QTY_BLN12;
            $MON_INK_SUM = $MON_INK_BLN01 + $MON_INK_BLN02 + $MON_INK_BLN03 + $MON_INK_BLN04 + $MON_INK_BLN05 + $MON_INK_BLN06 + $MON_INK_BLN07 + $MON_INK_BLN08 + $MON_INK_BLN09 + $MON_INK_BLN10 + $MON_INK_BLN11 + $MON_INK_BLN12;

            //ENGFEE IDR in MONTH
            $MON_ENG_BLN01 = $MON_ENGFEE * $INT_QTY_BLN01;
            $MON_ENG_BLN02 = $MON_ENGFEE * $INT_QTY_BLN02;
            $MON_ENG_BLN03 = $MON_ENGFEE * $INT_QTY_BLN03;
            $MON_ENG_BLN04 = $MON_ENGFEE * $INT_QTY_BLN04;
            $MON_ENG_BLN05 = $MON_ENGFEE * $INT_QTY_BLN05;
            $MON_ENG_BLN06 = $MON_ENGFEE * $INT_QTY_BLN06;
            $MON_ENG_BLN07 = $MON_ENGFEE * $INT_QTY_BLN07;
            $MON_ENG_BLN08 = $MON_ENGFEE * $INT_QTY_BLN08;
            $MON_ENG_BLN09 = $MON_ENGFEE * $INT_QTY_BLN09;
            $MON_ENG_BLN10 = $MON_ENGFEE * $INT_QTY_BLN10;
            $MON_ENG_BLN11 = $MON_ENGFEE * $INT_QTY_BLN11;
            $MON_ENG_BLN12 = $MON_ENGFEE * $INT_QTY_BLN12;
            $MON_ENG_SUM = $MON_ENG_BLN01 + $MON_ENG_BLN02 + $MON_ENG_BLN03 + $MON_ENG_BLN04 + $MON_ENG_BLN05 + $MON_ENG_BLN06 + $MON_ENG_BLN07 + $MON_ENG_BLN08 + $MON_ENG_BLN09 + $MON_ENG_BLN10 + $MON_ENG_BLN11 + $MON_ENG_BLN12;

            //IMPORT DUTY IDR in MONTH
            $MON_IMP_BLN01 = $MON_IMPORT_DUTY * $INT_QTY_BLN01;
            $MON_IMP_BLN02 = $MON_IMPORT_DUTY * $INT_QTY_BLN02;
            $MON_IMP_BLN03 = $MON_IMPORT_DUTY * $INT_QTY_BLN03;
            $MON_IMP_BLN04 = $MON_IMPORT_DUTY * $INT_QTY_BLN04;
            $MON_IMP_BLN05 = $MON_IMPORT_DUTY * $INT_QTY_BLN05;
            $MON_IMP_BLN06 = $MON_IMPORT_DUTY * $INT_QTY_BLN06;
            $MON_IMP_BLN07 = $MON_IMPORT_DUTY * $INT_QTY_BLN07;
            $MON_IMP_BLN08 = $MON_IMPORT_DUTY * $INT_QTY_BLN08;
            $MON_IMP_BLN09 = $MON_IMPORT_DUTY * $INT_QTY_BLN09;
            $MON_IMP_BLN10 = $MON_IMPORT_DUTY * $INT_QTY_BLN10;
            $MON_IMP_BLN11 = $MON_IMPORT_DUTY * $INT_QTY_BLN11;
            $MON_IMP_BLN12 = $MON_IMPORT_DUTY * $INT_QTY_BLN12;
            $MON_IMP_SUM = $MON_IMP_BLN01 + $MON_IMP_BLN02 + $MON_IMP_BLN03 + $MON_IMP_BLN04 + $MON_IMP_BLN05 + $MON_IMP_BLN06 + $MON_IMP_BLN07 + $MON_IMP_BLN08 + $MON_IMP_BLN09 + $MON_IMP_BLN10 + $MON_IMP_BLN11 + $MON_IMP_BLN12;

            //TOTAL PRICE IDR in MONTH
            $MON_AMT_BLN01 = $value->MON_AMT_BLN01;
            $MON_AMT_BLN02 = $value->MON_AMT_BLN02;
            $MON_AMT_BLN03 = $value->MON_AMT_BLN03;
            $MON_AMT_BLN04 = $value->MON_AMT_BLN04;
            $MON_AMT_BLN05 = $value->MON_AMT_BLN05;
            $MON_AMT_BLN06 = $value->MON_AMT_BLN06;
            $MON_AMT_BLN07 = $value->MON_AMT_BLN07;
            $MON_AMT_BLN08 = $value->MON_AMT_BLN08;
            $MON_AMT_BLN09 = $value->MON_AMT_BLN09;
            $MON_AMT_BLN10 = $value->MON_AMT_BLN10;
            $MON_AMT_BLN11 = $value->MON_AMT_BLN11;
            $MON_AMT_BLN12 = $value->MON_AMT_BLN12;
            $MON_AMT_SUM = $value->MON_AMT_SUM;

            $INT_SECT = $value->INT_SECT;
            $INT_DEPT = $value->INT_DEPT;
            $INT_GROUP_DEPT = $value->INT_GROUP_DEPT;
            $INT_DIV = $value->INT_DIV;

            $objPHPExcel->getActiveSheet()->setCellValue("B$row", "$seq");
            $objPHPExcel->getActiveSheet()->setCellValue("C$row", "$CHR_NO_BUDGET");
            $objPHPExcel->getActiveSheet()->setCellValue("D$row", "$CHR_STATUS");
            $objPHPExcel->getActiveSheet()->setCellValue("E$row", "$CHR_BUDGET_CATEGORY_DESC");
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", "$CHR_BUDGET_SUB_CATEGORY_DESC");
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", "$CHR_OWNER");
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", "$CHR_BUDGET_DESC");
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", "$CHR_PURPOSE");
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", "$CHR_PURPOSE");
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", "$CHR_PROJECT");
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", "$CHR_PRODUCT");
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", "$INT_FLG_CIP");
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", "$CHR_SUPPLIER");
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", "$MON_PRICE_ORI");
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", "$CHR_ORG_CURR");
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", "$FLT_RATE_CURR");
            $objPHPExcel->getActiveSheet()->setCellValue("R$row", "$CHR_RUN_DEPC");

            $objPHPExcel->getActiveSheet()->setCellValue("S$row", "$MON_IDR_BLN04");
            $objPHPExcel->getActiveSheet()->setCellValue("T$row", "$MON_INK_BLN04");
            $objPHPExcel->getActiveSheet()->setCellValue("U$row", "$MON_ENG_BLN04");
            $objPHPExcel->getActiveSheet()->setCellValue("V$row", "$MON_IMP_BLN04");                
            $objPHPExcel->getActiveSheet()->setCellValue("W$row", "$MON_AMT_BLN04");

            $objPHPExcel->getActiveSheet()->setCellValue("X$row", "$MON_IDR_BLN05");
            $objPHPExcel->getActiveSheet()->setCellValue("Y$row", "$MON_INK_BLN05");
            $objPHPExcel->getActiveSheet()->setCellValue("Z$row", "$MON_ENG_BLN05");
            $objPHPExcel->getActiveSheet()->setCellValue("AA$row", "$MON_IMP_BLN05");
            $objPHPExcel->getActiveSheet()->setCellValue("AB$row", "$MON_AMT_BLN05");

            $objPHPExcel->getActiveSheet()->setCellValue("AC$row", "$MON_IDR_BLN06");
            $objPHPExcel->getActiveSheet()->setCellValue("AD$row", "$MON_INK_BLN06");
            $objPHPExcel->getActiveSheet()->setCellValue("AE$row", "$MON_ENG_BLN06");
            $objPHPExcel->getActiveSheet()->setCellValue("AF$row", "$MON_IMP_BLN06");
            $objPHPExcel->getActiveSheet()->setCellValue("AG$row", "$MON_AMT_BLN06");

            $objPHPExcel->getActiveSheet()->setCellValue("AH$row", "$MON_IDR_BLN07");
            $objPHPExcel->getActiveSheet()->setCellValue("AI$row", "$MON_INK_BLN07");
            $objPHPExcel->getActiveSheet()->setCellValue("AJ$row", "$MON_ENG_BLN07");
            $objPHPExcel->getActiveSheet()->setCellValue("AK$row", "$MON_IMP_BLN07");
            $objPHPExcel->getActiveSheet()->setCellValue("AL$row", "$MON_AMT_BLN07");

            $objPHPExcel->getActiveSheet()->setCellValue("AM$row", "$MON_IDR_BLN08");
            $objPHPExcel->getActiveSheet()->setCellValue("AN$row", "$MON_INK_BLN08");
            $objPHPExcel->getActiveSheet()->setCellValue("AO$row", "$MON_ENG_BLN08");
            $objPHPExcel->getActiveSheet()->setCellValue("AP$row", "$MON_IMP_BLN08");
            $objPHPExcel->getActiveSheet()->setCellValue("AQ$row", "$MON_AMT_BLN08");

            $objPHPExcel->getActiveSheet()->setCellValue("AR$row", "$MON_IDR_BLN09");
            $objPHPExcel->getActiveSheet()->setCellValue("AS$row", "$MON_INK_BLN09");
            $objPHPExcel->getActiveSheet()->setCellValue("AT$row", "$MON_ENG_BLN09");
            $objPHPExcel->getActiveSheet()->setCellValue("AU$row", "$MON_IMP_BLN09");
            $objPHPExcel->getActiveSheet()->setCellValue("AV$row", "$MON_AMT_BLN09");

            $objPHPExcel->getActiveSheet()->setCellValue("AW$row", "$MON_IDR_BLN10");
            $objPHPExcel->getActiveSheet()->setCellValue("AX$row", "$MON_INK_BLN10");
            $objPHPExcel->getActiveSheet()->setCellValue("AY$row", "$MON_ENG_BLN10");
            $objPHPExcel->getActiveSheet()->setCellValue("AZ$row", "$MON_IMP_BLN10");
            $objPHPExcel->getActiveSheet()->setCellValue("BA$row", "$MON_AMT_BLN10");

            $objPHPExcel->getActiveSheet()->setCellValue("BB$row", "$MON_IDR_BLN11");
            $objPHPExcel->getActiveSheet()->setCellValue("BC$row", "$MON_INK_BLN11");
            $objPHPExcel->getActiveSheet()->setCellValue("BD$row", "$MON_ENG_BLN11");
            $objPHPExcel->getActiveSheet()->setCellValue("BE$row", "$MON_IMP_BLN11");
            $objPHPExcel->getActiveSheet()->setCellValue("BF$row", "$MON_AMT_BLN11");

            $objPHPExcel->getActiveSheet()->setCellValue("BG$row", "$MON_IDR_BLN12");
            $objPHPExcel->getActiveSheet()->setCellValue("BH$row", "$MON_INK_BLN12");
            $objPHPExcel->getActiveSheet()->setCellValue("BI$row", "$MON_ENG_BLN12");
            $objPHPExcel->getActiveSheet()->setCellValue("BJ$row", "$MON_IMP_BLN12");
            $objPHPExcel->getActiveSheet()->setCellValue("BK$row", "$MON_AMT_BLN12");

            $objPHPExcel->getActiveSheet()->setCellValue("BL$row", "$MON_IDR_BLN01");
            $objPHPExcel->getActiveSheet()->setCellValue("BM$row", "$MON_INK_BLN01");
            $objPHPExcel->getActiveSheet()->setCellValue("BN$row", "$MON_ENG_BLN01");
            $objPHPExcel->getActiveSheet()->setCellValue("BO$row", "$MON_IMP_BLN01");
            $objPHPExcel->getActiveSheet()->setCellValue("BP$row", "$MON_AMT_BLN01");

            $objPHPExcel->getActiveSheet()->setCellValue("BQ$row", "$MON_IDR_BLN02");
            $objPHPExcel->getActiveSheet()->setCellValue("BR$row", "$MON_INK_BLN02");
            $objPHPExcel->getActiveSheet()->setCellValue("BS$row", "$MON_ENG_BLN02");
            $objPHPExcel->getActiveSheet()->setCellValue("BT$row", "$MON_IMP_BLN02");
            $objPHPExcel->getActiveSheet()->setCellValue("BU$row", "$MON_AMT_BLN02");

            $objPHPExcel->getActiveSheet()->setCellValue("BV$row", "$MON_IDR_BLN03");
            $objPHPExcel->getActiveSheet()->setCellValue("BW$row", "$MON_INK_BLN03");
            $objPHPExcel->getActiveSheet()->setCellValue("BX$row", "$MON_ENG_BLN03");
            $objPHPExcel->getActiveSheet()->setCellValue("BY$row", "$MON_IMP_BLN03");
            $objPHPExcel->getActiveSheet()->setCellValue("BZ$row", "$MON_AMT_BLN03");

            $objPHPExcel->getActiveSheet()->setCellValue("CA$row", "$MON_IDR_SUM");
            $objPHPExcel->getActiveSheet()->setCellValue("CB$row", "$MON_INK_SUM");
            $objPHPExcel->getActiveSheet()->setCellValue("CC$row", "$MON_ENG_SUM");
            $objPHPExcel->getActiveSheet()->setCellValue("CD$row", "$MON_IMP_SUM");
            $objPHPExcel->getActiveSheet()->setCellValue("CE$row", "$MON_AMT_SUM");

            $seq++;
            $row++;
        }

        $objPHPExcel->getActiveSheet()->getStyle("B7:CE$row")->applyFromArray(array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        ));

        $row_min = $row - 1;
        $objPHPExcel->getActiveSheet()->setCellValue("S$row", "=SUM(S7:S$row_min)");
        $objPHPExcel->getActiveSheet()->setCellValue("T$row", "=SUM(T7:T$row_min)");
        $objPHPExcel->getActiveSheet()->setCellValue("U$row", "=SUM(U7:U$row_min)");
        $objPHPExcel->getActiveSheet()->setCellValue("V$row", "=SUM(V7:V$row_min)");
        $objPHPExcel->getActiveSheet()->setCellValue("W$row", "=SUM(W7:W$row_min)");
        $objPHPExcel->getActiveSheet()->setCellValue("X$row", "=SUM(X7:X$row_min)");
        $objPHPExcel->getActiveSheet()->setCellValue("Y$row", "=SUM(Y7:Y$row_min)");
        $objPHPExcel->getActiveSheet()->setCellValue("Z$row", "=SUM(Z7:Z$row_min)");
        $objPHPExcel->getActiveSheet()->setCellValue("AA$row", "=SUM(AA7:AA$row_min)");
        $objPHPExcel->getActiveSheet()->setCellValue("AB$row", "=SUM(AB7:AB$row_min)");
        $objPHPExcel->getActiveSheet()->setCellValue("AC$row", "=SUM(AC7:AC$row_min)");
        $objPHPExcel->getActiveSheet()->setCellValue("AD$row", "=SUM(AD7:AD$row_min)");
        $objPHPExcel->getActiveSheet()->setCellValue("AE$row", "=SUM(AE7:AE$row_min)");
        $objPHPExcel->getActiveSheet()->setCellValue("AF$row", "=SUM(AF7:AF$row_min)");
        $objPHPExcel->getActiveSheet()->setCellValue("AG$row", "=SUM(AG7:AG$row_min)");
        $objPHPExcel->getActiveSheet()->setCellValue("AH$row", "=SUM(AH7:AH$row_min)");
        $objPHPExcel->getActiveSheet()->setCellValue("AI$row", "=SUM(AI7:AI$row_min)");
        $objPHPExcel->getActiveSheet()->setCellValue("AJ$row", "=SUM(AJ7:AJ$row_min)");
        $objPHPExcel->getActiveSheet()->setCellValue("AK$row", "=SUM(AK7:AK$row_min)");
        $objPHPExcel->getActiveSheet()->setCellValue("AL$row", "=SUM(AL7:AL$row_min)");
        $objPHPExcel->getActiveSheet()->setCellValue("AM$row", "=SUM(AM7:AM$row_min)");
        $objPHPExcel->getActiveSheet()->setCellValue("AN$row", "=SUM(AN7:AN$row_min)");
        $objPHPExcel->getActiveSheet()->setCellValue("AO$row", "=SUM(AO7:AO$row_min)");
        $objPHPExcel->getActiveSheet()->setCellValue("AP$row", "=SUM(AP7:AP$row_min)");
        $objPHPExcel->getActiveSheet()->setCellValue("AQ$row", "=SUM(AQ7:AQ$row_min)");
        $objPHPExcel->getActiveSheet()->setCellValue("AR$row", "=SUM(AR7:AR$row_min)");
        $objPHPExcel->getActiveSheet()->setCellValue("AS$row", "=SUM(AS7:AS$row_min)");
        $objPHPExcel->getActiveSheet()->setCellValue("AT$row", "=SUM(AT7:AT$row_min)");
        $objPHPExcel->getActiveSheet()->setCellValue("AU$row", "=SUM(AU7:AU$row_min)");
        $objPHPExcel->getActiveSheet()->setCellValue("AV$row", "=SUM(AV7:AV$row_min)");
        $objPHPExcel->getActiveSheet()->setCellValue("AW$row", "=SUM(AW7:AW$row_min)");
        $objPHPExcel->getActiveSheet()->setCellValue("AX$row", "=SUM(AX7:AX$row_min)");
        $objPHPExcel->getActiveSheet()->setCellValue("AY$row", "=SUM(AY7:AY$row_min)");
        $objPHPExcel->getActiveSheet()->setCellValue("AZ$row", "=SUM(AZ7:AZ$row_min)");
        $objPHPExcel->getActiveSheet()->setCellValue("BA$row", "=SUM(BA7:BA$row_min)");
        $objPHPExcel->getActiveSheet()->setCellValue("BB$row", "=SUM(BB7:BB$row_min)");
        $objPHPExcel->getActiveSheet()->setCellValue("BC$row", "=SUM(BC7:BC$row_min)");
        $objPHPExcel->getActiveSheet()->setCellValue("BD$row", "=SUM(BD7:BD$row_min)");
        $objPHPExcel->getActiveSheet()->setCellValue("BE$row", "=SUM(BE7:BE$row_min)");
        $objPHPExcel->getActiveSheet()->setCellValue("BF$row", "=SUM(BF7:BF$row_min)");
        $objPHPExcel->getActiveSheet()->setCellValue("BG$row", "=SUM(BG7:BG$row_min)");
        $objPHPExcel->getActiveSheet()->setCellValue("BH$row", "=SUM(BH7:BH$row_min)");
        $objPHPExcel->getActiveSheet()->setCellValue("BI$row", "=SUM(BI7:BI$row_min)");
        $objPHPExcel->getActiveSheet()->setCellValue("BJ$row", "=SUM(BJ7:BJ$row_min)");
        $objPHPExcel->getActiveSheet()->setCellValue("BK$row", "=SUM(BK7:BK$row_min)");
        $objPHPExcel->getActiveSheet()->setCellValue("BL$row", "=SUM(BL7:BL$row_min)");
        $objPHPExcel->getActiveSheet()->setCellValue("BM$row", "=SUM(BM7:BM$row_min)");
        $objPHPExcel->getActiveSheet()->setCellValue("BN$row", "=SUM(BN7:BN$row_min)");
        $objPHPExcel->getActiveSheet()->setCellValue("BO$row", "=SUM(BO7:BO$row_min)");
        $objPHPExcel->getActiveSheet()->setCellValue("BP$row", "=SUM(BP7:BP$row_min)");
        $objPHPExcel->getActiveSheet()->setCellValue("BQ$row", "=SUM(BQ7:BQ$row_min)");
        $objPHPExcel->getActiveSheet()->setCellValue("BR$row", "=SUM(BR7:BR$row_min)");
        $objPHPExcel->getActiveSheet()->setCellValue("BS$row", "=SUM(BS7:BS$row_min)");
        $objPHPExcel->getActiveSheet()->setCellValue("BT$row", "=SUM(BT7:BT$row_min)");
        $objPHPExcel->getActiveSheet()->setCellValue("BU$row", "=SUM(BU7:BU$row_min)");
        $objPHPExcel->getActiveSheet()->setCellValue("BV$row", "=SUM(BV7:BV$row_min)");
        $objPHPExcel->getActiveSheet()->setCellValue("BW$row", "=SUM(BW7:BW$row_min)");
        $objPHPExcel->getActiveSheet()->setCellValue("BX$row", "=SUM(BX7:BX$row_min)");
        $objPHPExcel->getActiveSheet()->setCellValue("BY$row", "=SUM(BY7:BY$row_min)");
        $objPHPExcel->getActiveSheet()->setCellValue("BZ$row", "=SUM(BZ7:BZ$row_min)");
        $objPHPExcel->getActiveSheet()->setCellValue("CA$row", "=SUM(CA7:CA$row_min)");
        $objPHPExcel->getActiveSheet()->setCellValue("CB$row", "=SUM(CB7:CB$row_min)");
        $objPHPExcel->getActiveSheet()->setCellValue("CC$row", "=SUM(CC7:CC$row_min)");
        $objPHPExcel->getActiveSheet()->setCellValue("CD$row", "=SUM(CD7:CD$row_min)");
        $objPHPExcel->getActiveSheet()->setCellValue("CE$row", "=SUM(CE7:CE$row_min)");
        $objPHPExcel->getActiveSheet()->getStyle("B7:CE$row")->applyFromArray(array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            ),
        ));
        $objPHPExcel->getActiveSheet()->mergeCells("B$row:R$row");
        $objPHPExcel->getActiveSheet()->setCellValue("B$row", "TOTAL");
        $objPHPExcel->getActiveSheet()->getStyle("B$row:CE$row")->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('#CCCCCC');
        $objPHPExcel->getActiveSheet()->getStyle("B$row:CE$row")->applyFromArray(array(
            'font' => array(
                'bold' => true,
                'size' => 12
            )
        ));

        $row = $row + 3;

        $gdImage = imagecreatefromjpeg('assets/template/budget/report/approval.JPG');
        // Add a drawing to the worksheetecho date('H:i:s') . " Add a drawing to the worksheet\n";
        $objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
        $objDrawing->setName('Sample image');
        $objDrawing->setDescription('Sample image');
        $objDrawing->setImageResource($gdImage);
        $objDrawing->setRenderingFunction(PHPExcel_Worksheet_MemoryDrawing::RENDERING_JPEG);
        $objDrawing->setMimeType(PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_DEFAULT);
        $objDrawing->setHeight(105);
        $objDrawing->setCoordinates("CA$row");
        $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());

        ob_end_clean();
        $filename = "$INT_ID_FISCAL_YEAR - CAPEX.xls";
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . trim($filename) . '"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->setIncludeCharts(TRUE);
        $objWriter->save('php://output');
    }
    
    //============ CAPEX TOTAL PER DEPT ======================================
    function download_summary_company_capex_new($INT_ID_FISCAL_YEAR = null, $INT_ID_BUDGET_GROUP = null) {
        $user_session = $this->session->all_userdata();
        $role = $user_session['ROLE'];
        $row = 7;

        $this->load->library('excel');
        $objReader = PHPExcel_IOFactory::createReader('Excel5');
        // Create new PHPExcel object

        $objPHPExcel = $objReader->load("assets/template/budget/report/Template_Report_Capex.xls");

        $seq = 1;
        $objPHPExcel->getActiveSheet()->setCellValue("B2", "MASTER BUDGET : CAPEX TAHUN " . $INT_ID_FISCAL_YEAR);
        $objPHPExcel->getActiveSheet()->setCellValue("B3", "DEPARTMENT : ALL");
        $all_dept = $this->dept_m->get_dept(); 
        
        //PRICE PRE UNIT IDR in MONTH
        $TOT_IDR_BLN01 = 0;
        $TOT_IDR_BLN02 = 0;
        $TOT_IDR_BLN03 = 0;
        $TOT_IDR_BLN04 = 0;
        $TOT_IDR_BLN05 = 0;
        $TOT_IDR_BLN06 = 0;
        $TOT_IDR_BLN07 = 0;
        $TOT_IDR_BLN08 = 0;
        $TOT_IDR_BLN09 = 0;
        $TOT_IDR_BLN10 = 0;
        $TOT_IDR_BLN11 = 0;
        $TOT_IDR_BLN12 = 0;
        $TOT_IDR_SUM = 0;
        
        //INKLARING IDR in MONTH
        $TOT_INK_BLN01 = 0;
        $TOT_INK_BLN02 = 0;
        $TOT_INK_BLN03 = 0;
        $TOT_INK_BLN04 = 0;
        $TOT_INK_BLN05 = 0;
        $TOT_INK_BLN06 = 0;
        $TOT_INK_BLN07 = 0;
        $TOT_INK_BLN08 = 0;
        $TOT_INK_BLN09 = 0;
        $TOT_INK_BLN10 = 0;
        $TOT_INK_BLN11 = 0;
        $TOT_INK_BLN12 = 0;
        $TOT_INK_SUM = 0;

        //ENGFEE IDR in MONTH
        $TOT_ENG_BLN01 = 0;
        $TOT_ENG_BLN02 = 0;
        $TOT_ENG_BLN03 = 0;
        $TOT_ENG_BLN04 = 0;
        $TOT_ENG_BLN05 = 0;
        $TOT_ENG_BLN06 = 0;
        $TOT_ENG_BLN07 = 0;
        $TOT_ENG_BLN08 = 0;
        $TOT_ENG_BLN09 = 0;
        $TOT_ENG_BLN10 = 0;
        $TOT_ENG_BLN11 = 0;
        $TOT_ENG_BLN12 = 0;
        $TOT_ENG_SUM = 0;

        //IMPORT DUTY IDR in MONTH
        $TOT_IMP_BLN01 = 0;
        $TOT_IMP_BLN02 = 0;
        $TOT_IMP_BLN03 = 0;
        $TOT_IMP_BLN04 = 0;
        $TOT_IMP_BLN05 = 0;
        $TOT_IMP_BLN06 = 0;
        $TOT_IMP_BLN07 = 0;
        $TOT_IMP_BLN08 = 0;
        $TOT_IMP_BLN09 = 0;
        $TOT_IMP_BLN10 = 0;
        $TOT_IMP_BLN11 = 0;
        $TOT_IMP_BLN12 = 0;
        $TOT_IMP_SUM = 0;

        //TOTAL PRICE IDR in MONTH
        $TOT_AMT_BLN01 = 0;
        $TOT_AMT_BLN02 = 0;
        $TOT_AMT_BLN03 = 0;
        $TOT_AMT_BLN04 = 0;
        $TOT_AMT_BLN05 = 0;
        $TOT_AMT_BLN06 = 0;
        $TOT_AMT_BLN07 = 0;
        $TOT_AMT_BLN08 = 0;
        $TOT_AMT_BLN09 = 0;
        $TOT_AMT_BLN10 = 0;
        $TOT_AMT_BLN11 = 0;
        $TOT_AMT_BLN12 = 0;
        $TOT_AMT_SUM = 0;
        
//            if($role == 2){
//                $detail_confirm = $this->report_budget_plan_m->get_detail_capex_dept_cpl($INT_ID_FISCAL_YEAR, $id_dept);
//            } else {
//                $detail_confirm = $this->report_budget_plan_m->get_detail_capex_dept($INT_ID_FISCAL_YEAR, $id_dept);
//            }

        foreach ($all_dept as $dept){

            $id_dept = $dept->INT_ID_DEPT;
            $detail_confirm = $this->budget_capex_m->get_budget_by_dept($INT_ID_FISCAL_YEAR, $id_dept);

            $count = count($detail_confirm);
            
            //PRICE PRE UNIT IDR in MONTH
            $IDR_BLN01 = 0;
            $IDR_BLN02 = 0;
            $IDR_BLN03 = 0;
            $IDR_BLN04 = 0;
            $IDR_BLN05 = 0;
            $IDR_BLN06 = 0;
            $IDR_BLN07 = 0;
            $IDR_BLN08 = 0;
            $IDR_BLN09 = 0;
            $IDR_BLN10 = 0;
            $IDR_BLN11 = 0;
            $IDR_BLN12 = 0;
            $IDR_SUM = 0;

            //INKLARING IDR in MONTH
            $INK_BLN01 = 0;
            $INK_BLN02 = 0;
            $INK_BLN03 = 0;
            $INK_BLN04 = 0;
            $INK_BLN05 = 0;
            $INK_BLN06 = 0;
            $INK_BLN07 = 0;
            $INK_BLN08 = 0;
            $INK_BLN09 = 0;
            $INK_BLN10 = 0;
            $INK_BLN11 = 0;
            $INK_BLN12 = 0;
            $INK_SUM = 0;

            //ENGFEE IDR in MONTH
            $ENG_BLN01 = 0;
            $ENG_BLN02 = 0;
            $ENG_BLN03 = 0;
            $ENG_BLN04 = 0;
            $ENG_BLN05 = 0;
            $ENG_BLN06 = 0;
            $ENG_BLN07 = 0;
            $ENG_BLN08 = 0;
            $ENG_BLN09 = 0;
            $ENG_BLN10 = 0;
            $ENG_BLN11 = 0;
            $ENG_BLN12 = 0;
            $ENG_SUM = 0;

            //IMPORT DUTY IDR in MONTH
            $IMP_BLN01 = 0;
            $IMP_BLN02 = 0;
            $IMP_BLN03 = 0;
            $IMP_BLN04 = 0;
            $IMP_BLN05 = 0;
            $IMP_BLN06 = 0;
            $IMP_BLN07 = 0;
            $IMP_BLN08 = 0;
            $IMP_BLN09 = 0;
            $IMP_BLN10 = 0;
            $IMP_BLN11 = 0;
            $IMP_BLN12 = 0;
            $IMP_SUM = 0;

            //TOTAL PRICE IDR in MONTH
            $AMT_BLN01 = 0;
            $AMT_BLN02 = 0;
            $AMT_BLN03 = 0;
            $AMT_BLN04 = 0;
            $AMT_BLN05 = 0;
            $AMT_BLN06 = 0;
            $AMT_BLN07 = 0;
            $AMT_BLN08 = 0;
            $AMT_BLN09 = 0;
            $AMT_BLN10 = 0;
            $AMT_BLN11 = 0;
            $AMT_BLN12 = 0;
            $AMT_SUM = 0;
            
            if($count > 0){
                foreach ($detail_confirm as $value) {
                    // $CHR_SECTION_DESC = $this->section_m->get_desc_section($value->INT_SECT);
                    $CHR_NO_BUDGET = $value->CHR_NO_BUDGET;
                    $INT_ID_FISCAL_YEAR = $value->INT_ID_FISCAL_YEAR;
                    $CHR_BUDGET_TYPE = $value->CHR_BUDGET_TYPE;
                    $CHR_BUDGET_TYPE_DESC = $value->CHR_BUDGET_TYPE_DESC;
                    $CHR_BUDGET_SUB_CATEGORY = $value->CHR_BUDGET_SUB_CATEGORY;
                    $CHR_BUDGET_SUB_CATEGORY_DESC = $value->CHR_BUDGET_SUB_CATEGORY_DESC;
                    $CHR_BUDGET_CATEGORY = $value->CHR_BUDGET_CATEGORY;
                    $CHR_BUDGET_CATEGORY_DESC = $value->CHR_BUDGET_CATEGORY_DESC;
                    $CHR_CODE_CATEGORY_A3 = $value->CHR_CODE_CATEGORY_A3;
                    $CHR_CODE_CATEGORY_A3_DESC = $value->CHR_CODE_CATEGORY_A3_DESC; 
                    $CHR_BUDGET_DESC = $value->CHR_BUDGET_DESC; 
                    
                    $CHR_PURPOSE = $value->CHR_PURPOSE_DESC;
                    $CHR_PROJECT = $value->CHR_PROJECT_DESC;
                    $CHR_PRODUCT = $value->CHR_PRODUCT_DESC;
                    $INT_FLG_CIP = $value->FLG_CIP;
                    $CHR_STATUS = $value->CHR_STATUS_BUDGET;
                    $CHR_RUN_DEPC = $value->CHR_RUN_DEPRECIATION;
                    $CHR_SUPPLIER = $value->CHR_SUPPLIER_LOCATION;
                    $CHR_OWNER = $value->CHR_DIE_OWNER;
                    $CHR_UNIT = $value->CHR_SATUAN;
                    $CHR_ORG_CURR = $value->CHR_ORG_CURR;
                    $FLT_RATE_CURR = $value->FLT_RATE_CURR;
                    $MON_PRICE_ORI = $value->MON_PRICE_ORI;
                    $MON_PRICE_IDR = $value->MON_PRICE_IDR;
                    $MON_INKLARING = $value->MON_INKLARING;
                    $MON_ENGFEE = $value->MON_ENGFEE;
                    $MON_IMPORT_DUTY = $value->MON_IMPORT_DUTY;

                    $INT_QTY_BLN01 = $value->INT_QTY_BLN01;
                    $INT_QTY_BLN02 = $value->INT_QTY_BLN02;
                    $INT_QTY_BLN03 = $value->INT_QTY_BLN03;
                    $INT_QTY_BLN04 = $value->INT_QTY_BLN04;
                    $INT_QTY_BLN05 = $value->INT_QTY_BLN05;
                    $INT_QTY_BLN06 = $value->INT_QTY_BLN06;
                    $INT_QTY_BLN07 = $value->INT_QTY_BLN07;
                    $INT_QTY_BLN08 = $value->INT_QTY_BLN08;
                    $INT_QTY_BLN09 = $value->INT_QTY_BLN09;
                    $INT_QTY_BLN10 = $value->INT_QTY_BLN10;
                    $INT_QTY_BLN11 = $value->INT_QTY_BLN11;
                    $INT_QTY_BLN12 = $value->INT_QTY_BLN12;
                    $INT_QTY_SUM = $value->INT_QTY_SUM;

                    //PRICE PRE UNIT IDR in MONTH
                    $MON_IDR_BLN01 = $MON_PRICE_IDR * $INT_QTY_BLN01;
                    $MON_IDR_BLN02 = $MON_PRICE_IDR * $INT_QTY_BLN02;
                    $MON_IDR_BLN03 = $MON_PRICE_IDR * $INT_QTY_BLN03;
                    $MON_IDR_BLN04 = $MON_PRICE_IDR * $INT_QTY_BLN04;
                    $MON_IDR_BLN05 = $MON_PRICE_IDR * $INT_QTY_BLN05;
                    $MON_IDR_BLN06 = $MON_PRICE_IDR * $INT_QTY_BLN06;
                    $MON_IDR_BLN07 = $MON_PRICE_IDR * $INT_QTY_BLN07;
                    $MON_IDR_BLN08 = $MON_PRICE_IDR * $INT_QTY_BLN08;
                    $MON_IDR_BLN09 = $MON_PRICE_IDR * $INT_QTY_BLN09;
                    $MON_IDR_BLN10 = $MON_PRICE_IDR * $INT_QTY_BLN10;
                    $MON_IDR_BLN11 = $MON_PRICE_IDR * $INT_QTY_BLN11;
                    $MON_IDR_BLN12 = $MON_PRICE_IDR * $INT_QTY_BLN12;
                    $MON_IDR_SUM = $MON_IDR_BLN01 + $MON_IDR_BLN02 + $MON_IDR_BLN03 + $MON_IDR_BLN04 + $MON_IDR_BLN05 + $MON_IDR_BLN06 + $MON_IDR_BLN07 + $MON_IDR_BLN08 + $MON_IDR_BLN09 + $MON_IDR_BLN10 + $MON_IDR_BLN11 + $MON_IDR_BLN12;

                    //INKLARING IDR in MONTH
                    $MON_INK_BLN01 = $MON_INKLARING * $INT_QTY_BLN01;
                    $MON_INK_BLN02 = $MON_INKLARING * $INT_QTY_BLN02;
                    $MON_INK_BLN03 = $MON_INKLARING * $INT_QTY_BLN03;
                    $MON_INK_BLN04 = $MON_INKLARING * $INT_QTY_BLN04;
                    $MON_INK_BLN05 = $MON_INKLARING * $INT_QTY_BLN05;
                    $MON_INK_BLN06 = $MON_INKLARING * $INT_QTY_BLN06;
                    $MON_INK_BLN07 = $MON_INKLARING * $INT_QTY_BLN07;
                    $MON_INK_BLN08 = $MON_INKLARING * $INT_QTY_BLN08;
                    $MON_INK_BLN09 = $MON_INKLARING * $INT_QTY_BLN09;
                    $MON_INK_BLN10 = $MON_INKLARING * $INT_QTY_BLN10;
                    $MON_INK_BLN11 = $MON_INKLARING * $INT_QTY_BLN11;
                    $MON_INK_BLN12 = $MON_INKLARING * $INT_QTY_BLN12;
                    $MON_INK_SUM = $MON_INK_BLN01 + $MON_INK_BLN02 + $MON_INK_BLN03 + $MON_INK_BLN04 + $MON_INK_BLN05 + $MON_INK_BLN06 + $MON_INK_BLN07 + $MON_INK_BLN08 + $MON_INK_BLN09 + $MON_INK_BLN10 + $MON_INK_BLN11 + $MON_INK_BLN12;

                    //ENGFEE IDR in MONTH
                    $MON_ENG_BLN01 = $MON_ENGFEE * $INT_QTY_BLN01;
                    $MON_ENG_BLN02 = $MON_ENGFEE * $INT_QTY_BLN02;
                    $MON_ENG_BLN03 = $MON_ENGFEE * $INT_QTY_BLN03;
                    $MON_ENG_BLN04 = $MON_ENGFEE * $INT_QTY_BLN04;
                    $MON_ENG_BLN05 = $MON_ENGFEE * $INT_QTY_BLN05;
                    $MON_ENG_BLN06 = $MON_ENGFEE * $INT_QTY_BLN06;
                    $MON_ENG_BLN07 = $MON_ENGFEE * $INT_QTY_BLN07;
                    $MON_ENG_BLN08 = $MON_ENGFEE * $INT_QTY_BLN08;
                    $MON_ENG_BLN09 = $MON_ENGFEE * $INT_QTY_BLN09;
                    $MON_ENG_BLN10 = $MON_ENGFEE * $INT_QTY_BLN10;
                    $MON_ENG_BLN11 = $MON_ENGFEE * $INT_QTY_BLN11;
                    $MON_ENG_BLN12 = $MON_ENGFEE * $INT_QTY_BLN12;
                    $MON_ENG_SUM = $MON_ENG_BLN01 + $MON_ENG_BLN02 + $MON_ENG_BLN03 + $MON_ENG_BLN04 + $MON_ENG_BLN05 + $MON_ENG_BLN06 + $MON_ENG_BLN07 + $MON_ENG_BLN08 + $MON_ENG_BLN09 + $MON_ENG_BLN10 + $MON_ENG_BLN11 + $MON_ENG_BLN12;

                    //IMPORT DUTY IDR in MONTH
                    $MON_IMP_BLN01 = $MON_IMPORT_DUTY * $INT_QTY_BLN01;
                    $MON_IMP_BLN02 = $MON_IMPORT_DUTY * $INT_QTY_BLN02;
                    $MON_IMP_BLN03 = $MON_IMPORT_DUTY * $INT_QTY_BLN03;
                    $MON_IMP_BLN04 = $MON_IMPORT_DUTY * $INT_QTY_BLN04;
                    $MON_IMP_BLN05 = $MON_IMPORT_DUTY * $INT_QTY_BLN05;
                    $MON_IMP_BLN06 = $MON_IMPORT_DUTY * $INT_QTY_BLN06;
                    $MON_IMP_BLN07 = $MON_IMPORT_DUTY * $INT_QTY_BLN07;
                    $MON_IMP_BLN08 = $MON_IMPORT_DUTY * $INT_QTY_BLN08;
                    $MON_IMP_BLN09 = $MON_IMPORT_DUTY * $INT_QTY_BLN09;
                    $MON_IMP_BLN10 = $MON_IMPORT_DUTY * $INT_QTY_BLN10;
                    $MON_IMP_BLN11 = $MON_IMPORT_DUTY * $INT_QTY_BLN11;
                    $MON_IMP_BLN12 = $MON_IMPORT_DUTY * $INT_QTY_BLN12;
                    $MON_IMP_SUM = $MON_IMP_BLN01 + $MON_IMP_BLN02 + $MON_IMP_BLN03 + $MON_IMP_BLN04 + $MON_IMP_BLN05 + $MON_IMP_BLN06 + $MON_IMP_BLN07 + $MON_IMP_BLN08 + $MON_IMP_BLN09 + $MON_IMP_BLN10 + $MON_IMP_BLN11 + $MON_IMP_BLN12;

                    //TOTAL PRICE IDR in MONTH
                    $MON_AMT_BLN01 = $value->MON_AMT_BLN01;
                    $MON_AMT_BLN02 = $value->MON_AMT_BLN02;
                    $MON_AMT_BLN03 = $value->MON_AMT_BLN03;
                    $MON_AMT_BLN04 = $value->MON_AMT_BLN04;
                    $MON_AMT_BLN05 = $value->MON_AMT_BLN05;
                    $MON_AMT_BLN06 = $value->MON_AMT_BLN06;
                    $MON_AMT_BLN07 = $value->MON_AMT_BLN07;
                    $MON_AMT_BLN08 = $value->MON_AMT_BLN08;
                    $MON_AMT_BLN09 = $value->MON_AMT_BLN09;
                    $MON_AMT_BLN10 = $value->MON_AMT_BLN10;
                    $MON_AMT_BLN11 = $value->MON_AMT_BLN11;
                    $MON_AMT_BLN12 = $value->MON_AMT_BLN12;
                    $MON_AMT_SUM = $value->MON_AMT_SUM;

                    $INT_SECT = $value->INT_SECT;
                    $INT_DEPT = $value->INT_DEPT;
                    $INT_GROUP_DEPT = $value->INT_GROUP_DEPT;
                    $INT_DIV = $value->INT_DIV;

                    $objPHPExcel->getActiveSheet()->setCellValue("B$row", "$seq");
                    $objPHPExcel->getActiveSheet()->setCellValue("C$row", "$CHR_NO_BUDGET");
                    $objPHPExcel->getActiveSheet()->setCellValue("D$row", "$CHR_STATUS");
                    $objPHPExcel->getActiveSheet()->setCellValue("E$row", "$CHR_BUDGET_CATEGORY_DESC");
                    $objPHPExcel->getActiveSheet()->setCellValue("F$row", "$CHR_BUDGET_SUB_CATEGORY_DESC");
                    $objPHPExcel->getActiveSheet()->setCellValue("G$row", "$CHR_OWNER");
                    $objPHPExcel->getActiveSheet()->setCellValue("H$row", "$CHR_BUDGET_DESC");
                    $objPHPExcel->getActiveSheet()->setCellValue("I$row", "$CHR_PURPOSE");
                    $objPHPExcel->getActiveSheet()->setCellValue("J$row", "$CHR_PURPOSE");
                    $objPHPExcel->getActiveSheet()->setCellValue("K$row", "$CHR_PROJECT");
                    $objPHPExcel->getActiveSheet()->setCellValue("L$row", "$CHR_PRODUCT");
                    $objPHPExcel->getActiveSheet()->setCellValue("M$row", "$INT_FLG_CIP");
                    $objPHPExcel->getActiveSheet()->setCellValue("N$row", "$CHR_SUPPLIER");
                    $objPHPExcel->getActiveSheet()->setCellValue("O$row", "$MON_PRICE_ORI");
                    $objPHPExcel->getActiveSheet()->setCellValue("P$row", "$CHR_ORG_CURR");
                    $objPHPExcel->getActiveSheet()->setCellValue("Q$row", "$FLT_RATE_CURR");
                    $objPHPExcel->getActiveSheet()->setCellValue("R$row", "$CHR_RUN_DEPC");

                    $objPHPExcel->getActiveSheet()->setCellValue("S$row", "$MON_IDR_BLN04");
                    $objPHPExcel->getActiveSheet()->setCellValue("T$row", "$MON_INK_BLN04");
                    $objPHPExcel->getActiveSheet()->setCellValue("U$row", "$MON_ENG_BLN04");
                    $objPHPExcel->getActiveSheet()->setCellValue("V$row", "$MON_IMP_BLN04");                
                    $objPHPExcel->getActiveSheet()->setCellValue("W$row", "$MON_AMT_BLN04");

                    $objPHPExcel->getActiveSheet()->setCellValue("X$row", "$MON_IDR_BLN05");
                    $objPHPExcel->getActiveSheet()->setCellValue("Y$row", "$MON_INK_BLN05");
                    $objPHPExcel->getActiveSheet()->setCellValue("Z$row", "$MON_ENG_BLN05");
                    $objPHPExcel->getActiveSheet()->setCellValue("AA$row", "$MON_IMP_BLN05");
                    $objPHPExcel->getActiveSheet()->setCellValue("AB$row", "$MON_AMT_BLN05");

                    $objPHPExcel->getActiveSheet()->setCellValue("AC$row", "$MON_IDR_BLN06");
                    $objPHPExcel->getActiveSheet()->setCellValue("AD$row", "$MON_INK_BLN06");
                    $objPHPExcel->getActiveSheet()->setCellValue("AE$row", "$MON_ENG_BLN06");
                    $objPHPExcel->getActiveSheet()->setCellValue("AF$row", "$MON_IMP_BLN06");
                    $objPHPExcel->getActiveSheet()->setCellValue("AG$row", "$MON_AMT_BLN06");

                    $objPHPExcel->getActiveSheet()->setCellValue("AH$row", "$MON_IDR_BLN07");
                    $objPHPExcel->getActiveSheet()->setCellValue("AI$row", "$MON_INK_BLN07");
                    $objPHPExcel->getActiveSheet()->setCellValue("AJ$row", "$MON_ENG_BLN07");
                    $objPHPExcel->getActiveSheet()->setCellValue("AK$row", "$MON_IMP_BLN07");
                    $objPHPExcel->getActiveSheet()->setCellValue("AL$row", "$MON_AMT_BLN07");

                    $objPHPExcel->getActiveSheet()->setCellValue("AM$row", "$MON_IDR_BLN08");
                    $objPHPExcel->getActiveSheet()->setCellValue("AN$row", "$MON_INK_BLN08");
                    $objPHPExcel->getActiveSheet()->setCellValue("AO$row", "$MON_ENG_BLN08");
                    $objPHPExcel->getActiveSheet()->setCellValue("AP$row", "$MON_IMP_BLN08");
                    $objPHPExcel->getActiveSheet()->setCellValue("AQ$row", "$MON_AMT_BLN08");

                    $objPHPExcel->getActiveSheet()->setCellValue("AR$row", "$MON_IDR_BLN09");
                    $objPHPExcel->getActiveSheet()->setCellValue("AS$row", "$MON_INK_BLN09");
                    $objPHPExcel->getActiveSheet()->setCellValue("AT$row", "$MON_ENG_BLN09");
                    $objPHPExcel->getActiveSheet()->setCellValue("AU$row", "$MON_IMP_BLN09");
                    $objPHPExcel->getActiveSheet()->setCellValue("AV$row", "$MON_AMT_BLN09");

                    $objPHPExcel->getActiveSheet()->setCellValue("AW$row", "$MON_IDR_BLN10");
                    $objPHPExcel->getActiveSheet()->setCellValue("AX$row", "$MON_INK_BLN10");
                    $objPHPExcel->getActiveSheet()->setCellValue("AY$row", "$MON_ENG_BLN10");
                    $objPHPExcel->getActiveSheet()->setCellValue("AZ$row", "$MON_IMP_BLN10");
                    $objPHPExcel->getActiveSheet()->setCellValue("BA$row", "$MON_AMT_BLN10");

                    $objPHPExcel->getActiveSheet()->setCellValue("BB$row", "$MON_IDR_BLN11");
                    $objPHPExcel->getActiveSheet()->setCellValue("BC$row", "$MON_INK_BLN11");
                    $objPHPExcel->getActiveSheet()->setCellValue("BD$row", "$MON_ENG_BLN11");
                    $objPHPExcel->getActiveSheet()->setCellValue("BE$row", "$MON_IMP_BLN11");
                    $objPHPExcel->getActiveSheet()->setCellValue("BF$row", "$MON_AMT_BLN11");

                    $objPHPExcel->getActiveSheet()->setCellValue("BG$row", "$MON_IDR_BLN12");
                    $objPHPExcel->getActiveSheet()->setCellValue("BH$row", "$MON_INK_BLN12");
                    $objPHPExcel->getActiveSheet()->setCellValue("BI$row", "$MON_ENG_BLN12");
                    $objPHPExcel->getActiveSheet()->setCellValue("BJ$row", "$MON_IMP_BLN12");
                    $objPHPExcel->getActiveSheet()->setCellValue("BK$row", "$MON_AMT_BLN12");

                    $objPHPExcel->getActiveSheet()->setCellValue("BL$row", "$MON_IDR_BLN01");
                    $objPHPExcel->getActiveSheet()->setCellValue("BM$row", "$MON_INK_BLN01");
                    $objPHPExcel->getActiveSheet()->setCellValue("BN$row", "$MON_ENG_BLN01");
                    $objPHPExcel->getActiveSheet()->setCellValue("BO$row", "$MON_IMP_BLN01");
                    $objPHPExcel->getActiveSheet()->setCellValue("BP$row", "$MON_AMT_BLN01");

                    $objPHPExcel->getActiveSheet()->setCellValue("BQ$row", "$MON_IDR_BLN02");
                    $objPHPExcel->getActiveSheet()->setCellValue("BR$row", "$MON_INK_BLN02");
                    $objPHPExcel->getActiveSheet()->setCellValue("BS$row", "$MON_ENG_BLN02");
                    $objPHPExcel->getActiveSheet()->setCellValue("BT$row", "$MON_IMP_BLN02");
                    $objPHPExcel->getActiveSheet()->setCellValue("BU$row", "$MON_AMT_BLN02");

                    $objPHPExcel->getActiveSheet()->setCellValue("BV$row", "$MON_IDR_BLN03");
                    $objPHPExcel->getActiveSheet()->setCellValue("BW$row", "$MON_INK_BLN03");
                    $objPHPExcel->getActiveSheet()->setCellValue("BX$row", "$MON_ENG_BLN03");
                    $objPHPExcel->getActiveSheet()->setCellValue("BY$row", "$MON_IMP_BLN03");
                    $objPHPExcel->getActiveSheet()->setCellValue("BZ$row", "$MON_AMT_BLN03");

                    $objPHPExcel->getActiveSheet()->setCellValue("CA$row", "$MON_IDR_SUM");
                    $objPHPExcel->getActiveSheet()->setCellValue("CB$row", "$MON_INK_SUM");
                    $objPHPExcel->getActiveSheet()->setCellValue("CC$row", "$MON_ENG_SUM");
                    $objPHPExcel->getActiveSheet()->setCellValue("CD$row", "$MON_IMP_SUM");
                    $objPHPExcel->getActiveSheet()->setCellValue("CE$row", "$MON_AMT_SUM");
                    
                    //PRICE PRE UNIT IDR in MONTH
                    $IDR_BLN01 = $IDR_BLN01 + $MON_IDR_BLN01;
                    $IDR_BLN02 = $IDR_BLN02 + $MON_IDR_BLN02;
                    $IDR_BLN03 = $IDR_BLN03 + $MON_IDR_BLN03;
                    $IDR_BLN04 = $IDR_BLN04 + $MON_IDR_BLN04;
                    $IDR_BLN05 = $IDR_BLN05 + $MON_IDR_BLN05;
                    $IDR_BLN06 = $IDR_BLN06 + $MON_IDR_BLN06;
                    $IDR_BLN07 = $IDR_BLN07 + $MON_IDR_BLN07;
                    $IDR_BLN08 = $IDR_BLN08 + $MON_IDR_BLN08;
                    $IDR_BLN09 = $IDR_BLN09 + $MON_IDR_BLN09;
                    $IDR_BLN10 = $IDR_BLN10 + $MON_IDR_BLN10;
                    $IDR_BLN11 = $IDR_BLN11 + $MON_IDR_BLN11;
                    $IDR_BLN12 = $IDR_BLN12 + $MON_IDR_BLN12;
                    $IDR_SUM = $IDR_SUM + $MON_IDR_SUM;

                    //INKLARING IDR in MONTH
                    $INK_BLN01 = $INK_BLN01 + $MON_INK_BLN01;
                    $INK_BLN02 = $INK_BLN02 + $MON_INK_BLN02;
                    $INK_BLN03 = $INK_BLN03 + $MON_INK_BLN03;
                    $INK_BLN04 = $INK_BLN04 + $MON_INK_BLN04;
                    $INK_BLN05 = $INK_BLN05 + $MON_INK_BLN05;
                    $INK_BLN06 = $INK_BLN06 + $MON_INK_BLN06;
                    $INK_BLN07 = $INK_BLN07 + $MON_INK_BLN07;
                    $INK_BLN08 = $INK_BLN08 + $MON_INK_BLN08;
                    $INK_BLN09 = $INK_BLN09 + $MON_INK_BLN09;
                    $INK_BLN10 = $INK_BLN10 + $MON_INK_BLN10;
                    $INK_BLN11 = $INK_BLN11 + $MON_INK_BLN11;
                    $INK_BLN12 = $INK_BLN12 + $MON_INK_BLN12;
                    $INK_SUM = $INK_SUM + $MON_INK_SUM;

                    //ENGFEE IDR in MONTH
                    $ENG_BLN01 = $ENG_BLN01 + $MON_ENG_BLN01;
                    $ENG_BLN02 = $ENG_BLN02 + $MON_ENG_BLN02;
                    $ENG_BLN03 = $ENG_BLN03 + $MON_ENG_BLN03;
                    $ENG_BLN04 = $ENG_BLN04 + $MON_ENG_BLN04;
                    $ENG_BLN05 = $ENG_BLN05 + $MON_ENG_BLN05;
                    $ENG_BLN06 = $ENG_BLN06 + $MON_ENG_BLN06;
                    $ENG_BLN07 = $ENG_BLN07 + $MON_ENG_BLN07;
                    $ENG_BLN08 = $ENG_BLN08 + $MON_ENG_BLN08;
                    $ENG_BLN09 = $ENG_BLN09 + $MON_ENG_BLN09;
                    $ENG_BLN10 = $ENG_BLN10 + $MON_ENG_BLN10;
                    $ENG_BLN11 = $ENG_BLN11 + $MON_ENG_BLN11;
                    $ENG_BLN12 = $ENG_BLN12 + $MON_ENG_BLN12;
                    $ENG_SUM = $ENG_SUM + $MON_ENG_SUM;

                    //IMPORT DUTY IDR in MONTH
                    $IMP_BLN01 = $IMP_BLN01 + $MON_IMP_BLN01;
                    $IMP_BLN02 = $IMP_BLN02 + $MON_IMP_BLN02;
                    $IMP_BLN03 = $IMP_BLN03 + $MON_IMP_BLN03;
                    $IMP_BLN04 = $IMP_BLN04 + $MON_IMP_BLN04;
                    $IMP_BLN05 = $IMP_BLN05 + $MON_IMP_BLN05;
                    $IMP_BLN06 = $IMP_BLN06 + $MON_IMP_BLN06;
                    $IMP_BLN07 = $IMP_BLN07 + $MON_IMP_BLN07;
                    $IMP_BLN08 = $IMP_BLN08 + $MON_IMP_BLN08;
                    $IMP_BLN09 = $IMP_BLN09 + $MON_IMP_BLN09;
                    $IMP_BLN10 = $IMP_BLN10 + $MON_IMP_BLN10;
                    $IMP_BLN11 = $IMP_BLN11 + $MON_IMP_BLN11;
                    $IMP_BLN12 = $IMP_BLN12 + $MON_IMP_BLN12;
                    $IMP_SUM = $IMP_SUM + $MON_IMP_SUM;

                    //TOTAL PRICE IDR in MONTH
                    $AMT_BLN01 = $AMT_BLN01 + $MON_AMT_BLN01;
                    $AMT_BLN02 = $AMT_BLN02 + $MON_AMT_BLN02;
                    $AMT_BLN03 = $AMT_BLN03 + $MON_AMT_BLN03;
                    $AMT_BLN04 = $AMT_BLN04 + $MON_AMT_BLN04;
                    $AMT_BLN05 = $AMT_BLN05 + $MON_AMT_BLN05;
                    $AMT_BLN06 = $AMT_BLN06 + $MON_AMT_BLN06;
                    $AMT_BLN07 = $AMT_BLN07 + $MON_AMT_BLN07;
                    $AMT_BLN08 = $AMT_BLN08 + $MON_AMT_BLN08;
                    $AMT_BLN09 = $AMT_BLN09 + $MON_AMT_BLN09;
                    $AMT_BLN10 = $AMT_BLN10 + $MON_AMT_BLN10;
                    $AMT_BLN11 = $AMT_BLN11 + $MON_AMT_BLN11;
                    $AMT_BLN12 = $AMT_BLN12 + $MON_AMT_BLN12;
                    $AMT_SUM = $AMT_SUM + $MON_AMT_SUM;

                    $seq++;
                    $row++;
                }
                
                $objPHPExcel->getActiveSheet()->getStyle("B7:CE$row")->applyFromArray(array(
                    'borders' => array(
                        'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                        )
                    )
                ));

                $objPHPExcel->getActiveSheet()->setCellValue("S$row", "$IDR_BLN04");
                $objPHPExcel->getActiveSheet()->setCellValue("T$row", "$INK_BLN04");
                $objPHPExcel->getActiveSheet()->setCellValue("U$row", "$ENG_BLN04");
                $objPHPExcel->getActiveSheet()->setCellValue("V$row", "$IMP_BLN04");
                $objPHPExcel->getActiveSheet()->setCellValue("W$row", "$AMT_BLN04");
                $objPHPExcel->getActiveSheet()->setCellValue("X$row", "$IDR_BLN05");
                $objPHPExcel->getActiveSheet()->setCellValue("Y$row", "$INK_BLN05");
                $objPHPExcel->getActiveSheet()->setCellValue("Z$row", "$ENG_BLN05");
                $objPHPExcel->getActiveSheet()->setCellValue("AA$row", "$IMP_BLN05");
                $objPHPExcel->getActiveSheet()->setCellValue("AB$row", "$AMT_BLN05");
                $objPHPExcel->getActiveSheet()->setCellValue("AC$row", "$IDR_BLN06");
                $objPHPExcel->getActiveSheet()->setCellValue("AD$row", "$INK_BLN06");
                $objPHPExcel->getActiveSheet()->setCellValue("AE$row", "$ENG_BLN06");
                $objPHPExcel->getActiveSheet()->setCellValue("AF$row", "$IMP_BLN06");
                $objPHPExcel->getActiveSheet()->setCellValue("AG$row", "$AMT_BLN06");
                $objPHPExcel->getActiveSheet()->setCellValue("AH$row", "$IDR_BLN07");
                $objPHPExcel->getActiveSheet()->setCellValue("AI$row", "$INK_BLN07");
                $objPHPExcel->getActiveSheet()->setCellValue("AJ$row", "$ENG_BLN07");
                $objPHPExcel->getActiveSheet()->setCellValue("AK$row", "$IMP_BLN07");
                $objPHPExcel->getActiveSheet()->setCellValue("AL$row", "$AMT_BLN07");
                $objPHPExcel->getActiveSheet()->setCellValue("AM$row", "$IDR_BLN08");
                $objPHPExcel->getActiveSheet()->setCellValue("AN$row", "$INK_BLN08");
                $objPHPExcel->getActiveSheet()->setCellValue("AO$row", "$ENG_BLN08");
                $objPHPExcel->getActiveSheet()->setCellValue("AP$row", "$IMP_BLN08");
                $objPHPExcel->getActiveSheet()->setCellValue("AQ$row", "$AMT_BLN08");
                $objPHPExcel->getActiveSheet()->setCellValue("AR$row", "$IDR_BLN09");
                $objPHPExcel->getActiveSheet()->setCellValue("AS$row", "$INK_BLN09");
                $objPHPExcel->getActiveSheet()->setCellValue("AT$row", "$ENG_BLN09");
                $objPHPExcel->getActiveSheet()->setCellValue("AU$row", "$IMP_BLN09");
                $objPHPExcel->getActiveSheet()->setCellValue("AV$row", "$AMT_BLN09");
                $objPHPExcel->getActiveSheet()->setCellValue("AW$row", "$IDR_BLN10");
                $objPHPExcel->getActiveSheet()->setCellValue("AX$row", "$INK_BLN10");
                $objPHPExcel->getActiveSheet()->setCellValue("AY$row", "$ENG_BLN10");
                $objPHPExcel->getActiveSheet()->setCellValue("AZ$row", "$IMP_BLN10");
                $objPHPExcel->getActiveSheet()->setCellValue("BA$row", "$AMT_BLN10");
                $objPHPExcel->getActiveSheet()->setCellValue("BB$row", "$IDR_BLN11");
                $objPHPExcel->getActiveSheet()->setCellValue("BC$row", "$INK_BLN11");
                $objPHPExcel->getActiveSheet()->setCellValue("BD$row", "$ENG_BLN11");
                $objPHPExcel->getActiveSheet()->setCellValue("BE$row", "$IMP_BLN11");
                $objPHPExcel->getActiveSheet()->setCellValue("BF$row", "$AMT_BLN11");
                $objPHPExcel->getActiveSheet()->setCellValue("BG$row", "$IDR_BLN12");
                $objPHPExcel->getActiveSheet()->setCellValue("BH$row", "$INK_BLN12");
                $objPHPExcel->getActiveSheet()->setCellValue("BI$row", "$ENG_BLN12");
                $objPHPExcel->getActiveSheet()->setCellValue("BJ$row", "$IMP_BLN12");
                $objPHPExcel->getActiveSheet()->setCellValue("BK$row", "$AMT_BLN12");
                $objPHPExcel->getActiveSheet()->setCellValue("BL$row", "$IDR_BLN01");
                $objPHPExcel->getActiveSheet()->setCellValue("BM$row", "$INK_BLN01");
                $objPHPExcel->getActiveSheet()->setCellValue("BN$row", "$ENG_BLN01");
                $objPHPExcel->getActiveSheet()->setCellValue("BO$row", "$IMP_BLN01");
                $objPHPExcel->getActiveSheet()->setCellValue("BP$row", "$AMT_BLN01");
                $objPHPExcel->getActiveSheet()->setCellValue("BQ$row", "$IDR_BLN02");
                $objPHPExcel->getActiveSheet()->setCellValue("BR$row", "$INK_BLN02");
                $objPHPExcel->getActiveSheet()->setCellValue("BS$row", "$ENG_BLN02");
                $objPHPExcel->getActiveSheet()->setCellValue("BT$row", "$IMP_BLN02");
                $objPHPExcel->getActiveSheet()->setCellValue("BU$row", "$AMT_BLN02");
                $objPHPExcel->getActiveSheet()->setCellValue("BV$row", "$IDR_BLN03");
                $objPHPExcel->getActiveSheet()->setCellValue("BW$row", "$INK_BLN03");
                $objPHPExcel->getActiveSheet()->setCellValue("BX$row", "$ENG_BLN03");
                $objPHPExcel->getActiveSheet()->setCellValue("BY$row", "$IMP_BLN03");
                $objPHPExcel->getActiveSheet()->setCellValue("BZ$row", "$AMT_BLN03");
                $objPHPExcel->getActiveSheet()->setCellValue("CA$row", "$IDR_SUM");
                $objPHPExcel->getActiveSheet()->setCellValue("CB$row", "$INK_SUM");
                $objPHPExcel->getActiveSheet()->setCellValue("CC$row", "$ENG_SUM");
                $objPHPExcel->getActiveSheet()->setCellValue("CD$row", "$IMP_SUM");
                $objPHPExcel->getActiveSheet()->setCellValue("CE$row", "$AMT_SUM");
                $objPHPExcel->getActiveSheet()->getStyle("B7:CE$row")->applyFromArray(array(
                    'borders' => array(
                        'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                        )
                    ),
                ));
                $objPHPExcel->getActiveSheet()->mergeCells("B$row:R$row");
                $objPHPExcel->getActiveSheet()->setCellValue("B$row", "TOTAL");
                $objPHPExcel->getActiveSheet()->getStyle("B$row:CE$row")->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('#CCCCCC');
                $objPHPExcel->getActiveSheet()->getStyle("B$row:CE$row")->applyFromArray(array(
                    'font' => array(
                        'bold' => true,
                        'size' => 12
                    )
                ));
            }
            
            if($count != 0){
                $row++;
            }
            
            //PRICE PRE UNIT IDR in MONTH
            $TOT_IDR_BLN01 = $TOT_IDR_BLN01 + $IDR_BLN01;
            $TOT_IDR_BLN02 = $TOT_IDR_BLN02 + $IDR_BLN02;
            $TOT_IDR_BLN03 = $TOT_IDR_BLN03 + $IDR_BLN03;
            $TOT_IDR_BLN04 = $TOT_IDR_BLN04 + $IDR_BLN04;
            $TOT_IDR_BLN05 = $TOT_IDR_BLN05 + $IDR_BLN05;
            $TOT_IDR_BLN06 = $TOT_IDR_BLN06 + $IDR_BLN06;
            $TOT_IDR_BLN07 = $TOT_IDR_BLN07 + $IDR_BLN07;
            $TOT_IDR_BLN08 = $TOT_IDR_BLN08 + $IDR_BLN08;
            $TOT_IDR_BLN09 = $TOT_IDR_BLN09 + $IDR_BLN09;
            $TOT_IDR_BLN10 = $TOT_IDR_BLN10 + $IDR_BLN10;
            $TOT_IDR_BLN11 = $TOT_IDR_BLN11 + $IDR_BLN11;
            $TOT_IDR_BLN12 = $TOT_IDR_BLN12 + $IDR_BLN12;
            $TOT_IDR_SUM = $TOT_IDR_SUM + $IDR_SUM;

            //INKLARING IDR in MONTH
            $TOT_INK_BLN01 = $TOT_INK_BLN01 + $INK_BLN01;
            $TOT_INK_BLN02 = $TOT_INK_BLN02 + $INK_BLN02;
            $TOT_INK_BLN03 = $TOT_INK_BLN03 + $INK_BLN03;
            $TOT_INK_BLN04 = $TOT_INK_BLN04 + $INK_BLN04;
            $TOT_INK_BLN05 = $TOT_INK_BLN05 + $INK_BLN05;
            $TOT_INK_BLN06 = $TOT_INK_BLN06 + $INK_BLN06;
            $TOT_INK_BLN07 = $TOT_INK_BLN07 + $INK_BLN07;
            $TOT_INK_BLN08 = $TOT_INK_BLN08 + $INK_BLN08;
            $TOT_INK_BLN09 = $TOT_INK_BLN09 + $INK_BLN09;
            $TOT_INK_BLN10 = $TOT_INK_BLN10 + $INK_BLN10;
            $TOT_INK_BLN11 = $TOT_INK_BLN11 + $INK_BLN11;
            $TOT_INK_BLN12 = $TOT_INK_BLN12 + $INK_BLN12;
            $TOT_INK_SUM = $TOT_INK_SUM + $INK_SUM;

            //ENGFEE IDR in MONTH
            $TOT_ENG_BLN01 = $TOT_ENG_BLN01 + $ENG_BLN01;
            $TOT_ENG_BLN02 = $TOT_ENG_BLN02 + $ENG_BLN02;
            $TOT_ENG_BLN03 = $TOT_ENG_BLN03 + $ENG_BLN03;
            $TOT_ENG_BLN04 = $TOT_ENG_BLN04 + $ENG_BLN04;
            $TOT_ENG_BLN05 = $TOT_ENG_BLN05 + $ENG_BLN05;
            $TOT_ENG_BLN06 = $TOT_ENG_BLN06 + $ENG_BLN06;
            $TOT_ENG_BLN07 = $TOT_ENG_BLN07 + $ENG_BLN07;
            $TOT_ENG_BLN08 = $TOT_ENG_BLN08 + $ENG_BLN08;
            $TOT_ENG_BLN09 = $TOT_ENG_BLN09 + $ENG_BLN09;
            $TOT_ENG_BLN10 = $TOT_ENG_BLN10 + $ENG_BLN10;
            $TOT_ENG_BLN11 = $TOT_ENG_BLN11 + $ENG_BLN11;
            $TOT_ENG_BLN12 = $TOT_ENG_BLN12 + $ENG_BLN12;
            $TOT_ENG_SUM = $TOT_ENG_SUM + $ENG_SUM;

            //IMPORT DUTY IDR in MONTH
            $TOT_IMP_BLN01 = $TOT_IMP_BLN01 + $IMP_BLN01;
            $TOT_IMP_BLN02 = $TOT_IMP_BLN02 + $IMP_BLN02;
            $TOT_IMP_BLN03 = $TOT_IMP_BLN03 + $IMP_BLN03;
            $TOT_IMP_BLN04 = $TOT_IMP_BLN04 + $IMP_BLN04;
            $TOT_IMP_BLN05 = $TOT_IMP_BLN05 + $IMP_BLN05;
            $TOT_IMP_BLN06 = $TOT_IMP_BLN06 + $IMP_BLN06;
            $TOT_IMP_BLN07 = $TOT_IMP_BLN07 + $IMP_BLN07;
            $TOT_IMP_BLN08 = $TOT_IMP_BLN08 + $IMP_BLN08;
            $TOT_IMP_BLN09 = $TOT_IMP_BLN09 + $IMP_BLN09;
            $TOT_IMP_BLN10 = $TOT_IMP_BLN10 + $IMP_BLN10;
            $TOT_IMP_BLN11 = $TOT_IMP_BLN11 + $IMP_BLN11;
            $TOT_IMP_BLN12 = $TOT_IMP_BLN12 + $IMP_BLN12;
            $TOT_IMP_SUM = $TOT_IMP_SUM + $IMP_SUM;

            //TOTAL PRICE IDR in MONTH
            $TOT_AMT_BLN01 = $TOT_AMT_BLN01 + $AMT_BLN01;
            $TOT_AMT_BLN02 = $TOT_AMT_BLN02 + $AMT_BLN02;
            $TOT_AMT_BLN03 = $TOT_AMT_BLN03 + $AMT_BLN03;
            $TOT_AMT_BLN04 = $TOT_AMT_BLN04 + $AMT_BLN04;
            $TOT_AMT_BLN05 = $TOT_AMT_BLN05 + $AMT_BLN05;
            $TOT_AMT_BLN06 = $TOT_AMT_BLN06 + $AMT_BLN06;
            $TOT_AMT_BLN07 = $TOT_AMT_BLN07 + $AMT_BLN07;
            $TOT_AMT_BLN08 = $TOT_AMT_BLN08 + $AMT_BLN08;
            $TOT_AMT_BLN09 = $TOT_AMT_BLN09 + $AMT_BLN09;
            $TOT_AMT_BLN10 = $TOT_AMT_BLN10 + $AMT_BLN10;
            $TOT_AMT_BLN11 = $TOT_AMT_BLN11 + $AMT_BLN11;
            $TOT_AMT_BLN12 = $TOT_AMT_BLN12 + $AMT_BLN12;
            $TOT_AMT_SUM = $TOT_AMT_SUM + $AMT_SUM;
        }

        $objPHPExcel->getActiveSheet()->getStyle("B7:CE$row")->applyFromArray(array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        ));

        $objPHPExcel->getActiveSheet()->setCellValue("S$row", "$TOT_IDR_BLN04");
        $objPHPExcel->getActiveSheet()->setCellValue("T$row", "$TOT_INK_BLN04");
        $objPHPExcel->getActiveSheet()->setCellValue("U$row", "$TOT_ENG_BLN04");
        $objPHPExcel->getActiveSheet()->setCellValue("V$row", "$TOT_IMP_BLN04");
        $objPHPExcel->getActiveSheet()->setCellValue("W$row", "$TOT_AMT_BLN04");
        $objPHPExcel->getActiveSheet()->setCellValue("X$row", "$TOT_IDR_BLN05");
        $objPHPExcel->getActiveSheet()->setCellValue("Y$row", "$TOT_INK_BLN05");
        $objPHPExcel->getActiveSheet()->setCellValue("Z$row", "$TOT_ENG_BLN05");
        $objPHPExcel->getActiveSheet()->setCellValue("AA$row", "$TOT_IMP_BLN05");
        $objPHPExcel->getActiveSheet()->setCellValue("AB$row", "$TOT_AMT_BLN05");
        $objPHPExcel->getActiveSheet()->setCellValue("AC$row", "$TOT_IDR_BLN06");
        $objPHPExcel->getActiveSheet()->setCellValue("AD$row", "$TOT_INK_BLN06");
        $objPHPExcel->getActiveSheet()->setCellValue("AE$row", "$TOT_ENG_BLN06");
        $objPHPExcel->getActiveSheet()->setCellValue("AF$row", "$TOT_IMP_BLN06");
        $objPHPExcel->getActiveSheet()->setCellValue("AG$row", "$TOT_AMT_BLN06");
        $objPHPExcel->getActiveSheet()->setCellValue("AH$row", "$TOT_IDR_BLN07");
        $objPHPExcel->getActiveSheet()->setCellValue("AI$row", "$TOT_INK_BLN07");
        $objPHPExcel->getActiveSheet()->setCellValue("AJ$row", "$TOT_ENG_BLN07");
        $objPHPExcel->getActiveSheet()->setCellValue("AK$row", "$TOT_IMP_BLN07");
        $objPHPExcel->getActiveSheet()->setCellValue("AL$row", "$TOT_AMT_BLN07");
        $objPHPExcel->getActiveSheet()->setCellValue("AM$row", "$TOT_IDR_BLN08");
        $objPHPExcel->getActiveSheet()->setCellValue("AN$row", "$TOT_INK_BLN08");
        $objPHPExcel->getActiveSheet()->setCellValue("AO$row", "$TOT_ENG_BLN08");
        $objPHPExcel->getActiveSheet()->setCellValue("AP$row", "$TOT_IMP_BLN08");
        $objPHPExcel->getActiveSheet()->setCellValue("AQ$row", "$TOT_AMT_BLN08");
        $objPHPExcel->getActiveSheet()->setCellValue("AR$row", "$TOT_IDR_BLN09");
        $objPHPExcel->getActiveSheet()->setCellValue("AS$row", "$TOT_INK_BLN09");
        $objPHPExcel->getActiveSheet()->setCellValue("AT$row", "$TOT_ENG_BLN09");
        $objPHPExcel->getActiveSheet()->setCellValue("AU$row", "$TOT_IMP_BLN09");
        $objPHPExcel->getActiveSheet()->setCellValue("AV$row", "$TOT_AMT_BLN09");
        $objPHPExcel->getActiveSheet()->setCellValue("AW$row", "$TOT_IDR_BLN10");
        $objPHPExcel->getActiveSheet()->setCellValue("AX$row", "$TOT_INK_BLN10");
        $objPHPExcel->getActiveSheet()->setCellValue("AY$row", "$TOT_ENG_BLN10");
        $objPHPExcel->getActiveSheet()->setCellValue("AZ$row", "$TOT_IMP_BLN10");
        $objPHPExcel->getActiveSheet()->setCellValue("BA$row", "$TOT_AMT_BLN10");
        $objPHPExcel->getActiveSheet()->setCellValue("BB$row", "$TOT_IDR_BLN11");
        $objPHPExcel->getActiveSheet()->setCellValue("BC$row", "$TOT_INK_BLN11");
        $objPHPExcel->getActiveSheet()->setCellValue("BD$row", "$TOT_ENG_BLN11");
        $objPHPExcel->getActiveSheet()->setCellValue("BE$row", "$TOT_IMP_BLN11");
        $objPHPExcel->getActiveSheet()->setCellValue("BF$row", "$TOT_AMT_BLN11");
        $objPHPExcel->getActiveSheet()->setCellValue("BG$row", "$TOT_IDR_BLN12");
        $objPHPExcel->getActiveSheet()->setCellValue("BH$row", "$TOT_INK_BLN12");
        $objPHPExcel->getActiveSheet()->setCellValue("BI$row", "$TOT_ENG_BLN12");
        $objPHPExcel->getActiveSheet()->setCellValue("BJ$row", "$TOT_IMP_BLN12");
        $objPHPExcel->getActiveSheet()->setCellValue("BK$row", "$TOT_AMT_BLN12");
        $objPHPExcel->getActiveSheet()->setCellValue("BL$row", "$TOT_IDR_BLN01");
        $objPHPExcel->getActiveSheet()->setCellValue("BM$row", "$TOT_INK_BLN01");
        $objPHPExcel->getActiveSheet()->setCellValue("BN$row", "$TOT_ENG_BLN01");
        $objPHPExcel->getActiveSheet()->setCellValue("BO$row", "$TOT_IMP_BLN01");
        $objPHPExcel->getActiveSheet()->setCellValue("BP$row", "$TOT_AMT_BLN01");
        $objPHPExcel->getActiveSheet()->setCellValue("BQ$row", "$TOT_IDR_BLN02");
        $objPHPExcel->getActiveSheet()->setCellValue("BR$row", "$TOT_INK_BLN02");
        $objPHPExcel->getActiveSheet()->setCellValue("BS$row", "$TOT_ENG_BLN02");
        $objPHPExcel->getActiveSheet()->setCellValue("BT$row", "$TOT_IMP_BLN02");
        $objPHPExcel->getActiveSheet()->setCellValue("BU$row", "$TOT_AMT_BLN02");
        $objPHPExcel->getActiveSheet()->setCellValue("BV$row", "$TOT_IDR_BLN03");
        $objPHPExcel->getActiveSheet()->setCellValue("BW$row", "$TOT_INK_BLN03");
        $objPHPExcel->getActiveSheet()->setCellValue("BX$row", "$TOT_ENG_BLN03");
        $objPHPExcel->getActiveSheet()->setCellValue("BY$row", "$TOT_IMP_BLN03");
        $objPHPExcel->getActiveSheet()->setCellValue("BZ$row", "$TOT_AMT_BLN03");
        $objPHPExcel->getActiveSheet()->setCellValue("CA$row", "$TOT_IDR_SUM");
        $objPHPExcel->getActiveSheet()->setCellValue("CB$row", "$TOT_INK_SUM");
        $objPHPExcel->getActiveSheet()->setCellValue("CC$row", "$TOT_ENG_SUM");
        $objPHPExcel->getActiveSheet()->setCellValue("CD$row", "$TOT_IMP_SUM");
        $objPHPExcel->getActiveSheet()->setCellValue("CE$row", "$TOT_AMT_SUM");
        $objPHPExcel->getActiveSheet()->getStyle("B7:CE$row")->applyFromArray(array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            ),
        ));
        $objPHPExcel->getActiveSheet()->mergeCells("B$row:R$row");
        $objPHPExcel->getActiveSheet()->setCellValue("B$row", "GRAND TOTAL");
        $objPHPExcel->getActiveSheet()->getStyle("B$row:CE$row")->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('#CCCCCC');
        $objPHPExcel->getActiveSheet()->getStyle("B$row:CE$row")->applyFromArray(array(
            'font' => array(
                'bold' => true,
                'size' => 12
            )
        ));

        $row = $row + 3;

        $gdImage = imagecreatefromjpeg('assets/template/budget/report/approval.JPG');
        // Add a drawing to the worksheetecho date('H:i:s') . " Add a drawing to the worksheet\n";
        $objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
        $objDrawing->setName('Sample image');
        $objDrawing->setDescription('Sample image');
        $objDrawing->setImageResource($gdImage);
        $objDrawing->setRenderingFunction(PHPExcel_Worksheet_MemoryDrawing::RENDERING_JPEG);
        $objDrawing->setMimeType(PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_DEFAULT);
        $objDrawing->setHeight(105);
        $objDrawing->setCoordinates("CA$row");
        $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());

        ob_end_clean();
        $filename = "$INT_ID_FISCAL_YEAR - CAPEX.xls";
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . trim($filename) . '"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->setIncludeCharts(TRUE);
        $objWriter->save('php://output');
    }
}

?>
