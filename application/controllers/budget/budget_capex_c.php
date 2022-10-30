<?php

class budget_capex_c extends CI_Controller {

    private $layout = '/template/head';
    private $layout_blank = '/template/head_blank';
    private $back_to_upload = 'budget/budget_capex_c/upload_capex/';
    private $back_to_create = 'budget/budget_capex_c/create_capex/';
    private $back_to_manage = 'budget/budget_capex_c/index/';

    public function __construct() {
        parent::__construct();
        $this->load->model('budget/report_budget_plan_m');
        $this->load->model('budget/budget_capex_m');
        $this->load->model('budget/budgetsubgroup_m');
        $this->load->model('budget/unit_m');
        $this->load->model('budget/budgettype_m');
        $this->load->model('budget/budgetcategory_m');
        $this->load->model('budget/budgetsubcategory_m');
        $this->load->model('organization/section_m');
        $this->load->model('organization/dept_m');
        $this->load->model('organization/groupdept_m');
        $this->load->model('organization/division_m');
        $this->load->model('budget/costcenter_m');
        $this->load->model('budget/purposebudget_m');
        $this->load->model('budget/project_m');
        $this->load->model('budget/product_m');
        $this->load->model('budget/currency_m');
        $this->load->model('budget/fiscal_m');
        $this->load->model('basis/user_m');
    }
    
    //=========================== NEW UPDATE 10/07/2017 ======================//

    function index($msg = null, $INT_ID_FISCAL_YEAR = null, $INT_ID_BUDGET_TYPE = null, $INT_DIV = null, $INT_DEPT = null, $INT_SECT = null, $CHR_BUDGET_TYPE = null) {
        $user_session = $this->session->all_userdata();
        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Creating success. </strong> The data is successfully created. </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Updating success. </strong> The data is successfully updated. </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Deleting success. </strong> The data is successfully deleted. </div >";
        } elseif ($msg == 4) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Creating failed. </strong> No data amount on this fiscal year recorded. </div >";
        } elseif ($msg == 5) {
            $msg = "<div class = 'alert alert-success'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Commiting success. </strong> The data is successfully updated. </div >";
        } elseif ($msg == 6) {
            $msg = "<div class = 'alert alert-success'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Budget Expense was Approved. </strong> The data was successfully updated. </div >";
        } elseif ($msg == 7) {
            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Budget Expense was Rejected. </strong> The data was successfully updated. </div >";
        } elseif ($msg == 8) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Budget Expense was Unlocked. </strong> The data was successfully updated. </div >";
        } elseif ($msg == 12) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Executing error!</strong> Something is not right. </div >";
        } elseif ($msg == 13) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Executing failed!</strong> No data was selected.</div >";
        } elseif ($msg == 14) {
            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Access denied!</strong> Unbudget Expense cannot be ceated on the Planning session.</div >";
        } elseif ($msg == 15) {
            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Access denied!</strong> Update budget is not allowed.</div >";
        } elseif ($msg == 16) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Executing failed!</strong> File template upload not appropriate with budget type. Check your template</div >";
        }

        $data['INT_ID_FISCAL_YEAR'] = $INT_ID_FISCAL_YEAR;
        $data['INT_DIV'] = $INT_DIV;
        if($INT_DEPT == '' || $INT_DEPT == NULL){
            $INT_DEPT = $user_session['DEPT'];            
        }      
        $data['INT_DEPT'] = $INT_DEPT;
        $data['INT_SECT'] = $INT_SECT;
        $data['INT_ID_BUDGET_TYPE'] = 1;
        
//GET DETAIL BUDGET
        if ($INT_SECT <> null) {
            $data['url_page'] = site_url("budget/budget_capex_c/refresh_table_page/1/$INT_ID_FISCAL_YEAR/$INT_ID_BUDGET_TYPE/$INT_DIV/$INT_DEPT/$INT_SECT/$CHR_BUDGET_TYPE");
        } else {
            $data['url_page'] = "";
        }

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(18);
        $data['news'] = $this->news_m->get_news();
        $data['msg'] = $msg;
        $data['data_fiscal'] = $this->fiscal_m->get_all_fiscal();
        
        $data['title'] = 'Create Budget Capital Expenditure';
        $data['content'] = 'budget/budget_capex/manage_budget_capex_v';       
        
        $user = $this->user_m->get_user_org($user_session['NPK']);        
        $data['role'] = $user_session['ROLE'];
        
        if (($user_session['ROLE'] == 1) || ( $user_session['ROLE'] == 2)) {
            $data['data_fiscal'] = $this->fiscal_m->get_all_fiscal();
            $data['dept'] = $this->dept_m->get_dept(); //get all dept
            $data['section'] = $this->dept_m->get_name_section_budget($INT_DEPT);
        } else {
            $data['data_fiscal'] = $this->fiscal_m->get_all_fiscal();
            $data['CHR_DEPT'] = $this->dept_m->get_name_dept($INT_DEPT); //by user dept
            $data['dept'] = $this->dept_m->get_name_dept_arr($INT_DEPT);
            $data['section'] = $this->dept_m->get_name_section_budget($INT_DEPT);
            $fiscal = $this->fiscal_m->get_id_fiscal_this_year();
        }

        $data['data_budget_type'] = $this->budgettype_m->get_budgettype();
        $this->load->view($this->layout, $data);
    }
    
    function create_budget_capex() {
        $this->role_module_m->authorization('18');
        $user_session = $this->session->all_userdata();
        $data['title'] = 'Create Budget Capex';

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(18);
        
        $data['user_dept'] = $user_session['DEPT'];
        
        $data['news'] = $this->news_m->get_news();
        $data['data_dept'] = $this->dept_m->get_dept();
        $data['data_section'] = $this->section_m->get_section();
        $data['data_costcenter'] = $this->costcenter_m->get_costcenter();
        $data['data_fiscal'] = $this->fiscal_m->get_all_fiscal();
        $data['data_budgetsubcategory'] = $this->budgetsubcategory_m->get_budgetsubcategory();
        $data['data_budgetcategory'] = $this->budgetcategory_m->get_budgetcategory_capex();
        $data['data_purposebudget'] = $this->purposebudget_m->get_purposebudget_capex();
        $data['data_project'] = $this->project_m->get_project();
        $data['data_product'] = $this->product_m->get_product();
        $data['unit'] = $this->unit_m->get_unit();
        $data['all_curr'] = $this->currency_m->get_all_currency();
        
        $fiscal_data = $this->fiscal_m->get_all_fiscal();
        $now = date('Ym');
        foreach ($fiscal_data as $value) {
            $ms = $value->CHR_MONTH_START;
            $me = $value->CHR_MONTH_END;
            if ($value->CHR_MONTH_START < 10) {
                $ms = '0' . $value->CHR_MONTH_START;
            }
            if ($value->CHR_MONTH_END < 10) {
                $me = '0' . $value->CHR_MONTH_START;
            }
            $a = $value->CHR_FISCAL_YEAR_START . $ms;
            $b = $value->CHR_FISCAL_YEAR_END . $me;
            if (($a <= $now) && ($now <= $b)) {
                $data['fiscal_year'] =  $value->INT_ID_FISCAL_YEAR;
                $data['year_start'] = $value->CHR_FISCAL_YEAR_START;
                $data['year_end'] = $value->CHR_FISCAL_YEAR_END;
            }
        } 
        
        $data['content'] = 'budget/budget_capex/create_budget_capex_v';

        $this->load->view($this->layout, $data);
    }
    
    function edit_budget_capex($msg = NULL, $CHR_NO_BUDGET = NULL) {
        if ($msg == 1) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Updating failed. </strong> One number budget only for 1 Qty. </div >";
        } else {
            $msg = NULL;
        }
        $user_session = $this->session->all_userdata();
        $CHR_USERNAME = $user_session['USERNAME'];
        $CHR_NO_BUDGET = str_replace('%3C', '/', $CHR_NO_BUDGET);//  

        //CHECK BUDGET NUMBER
        //GET BUDGET NUMBER
        $detail_budget = $this->budget_capex_m->get_capex_by_no_budget($CHR_NO_BUDGET);
        $data['title'] = 'Edit Budget Capex';

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(18);
        
        $data['no_budget'] = $CHR_NO_BUDGET;
        $data['dept'] = $detail_budget->INT_DEPT;
        $data['sect'] = $detail_budget->INT_SECT;
        $data['costcenter'] = $detail_budget->INT_COST_CENTER;
        $data['category'] = $this->budgetcategory_m->get_id_category($detail_budget->CHR_BUDGET_CATEGORY)->INT_ID_BUDGET_CATEGORY;
        $data['subcategory'] = $this->budgetsubcategory_m->get_id_subcategory($detail_budget->CHR_BUDGET_SUB_CATEGORY)->INT_ID_BUDGET_SUB_CATEGORY;
        $data['purpose'] = $detail_budget->CHR_PURPOSE;
        $data['cip'] = $detail_budget->INT_FLG_CIP;
        $data['budget_desc'] = $detail_budget->CHR_BUDGET_DESC;
        $data['supplier'] = $detail_budget->CHR_SUPPLIER_LOCATION;
        $data['owner'] = $detail_budget->CHR_DIE_OWNER;
        $data['satuan'] = $detail_budget->CHR_SATUAN;
        $data['year_depc'] = substr($detail_budget->CHR_RUN_DEPRECIATION,0,4);
        $data['month_depc'] = substr($detail_budget->CHR_RUN_DEPRECIATION,4,2);
        $data['id_curr'] = $this->currency_m->get_id_currency($detail_budget->CHR_ORG_CURR)->INT_ID_CURRENCY;
        $data['rate'] = $detail_budget->FLT_RATE_CURR;
        $data['satuan'] = $detail_budget->CHR_SATUAN;
        $data['price_ori'] = $detail_budget->MON_PRICE_ORI;
        $data['inkla'] = $detail_budget->MON_INKLARING;
        $data['engfee'] = $detail_budget->MON_ENGFEE;
        $data['impdut'] = $detail_budget->MON_IMPORT_DUTY;
        $data['price_idr'] = $detail_budget->MON_PRICE_IDR + $detail_budget->MON_INKLARING + $detail_budget->MON_ENGFEE + $detail_budget->MON_IMPORT_DUTY;
        $data['tot_qty'] = $detail_budget->INT_QTY_SUM;
        $data['tot_price'] = $detail_budget->MON_AMT_SUM;
        $data['qty01'] = $detail_budget->INT_QTY_BLN01;
        $data['qty02'] = $detail_budget->INT_QTY_BLN02;
        $data['qty03'] = $detail_budget->INT_QTY_BLN03;
        $data['qty04'] = $detail_budget->INT_QTY_BLN04;
        $data['qty05'] = $detail_budget->INT_QTY_BLN05;
        $data['qty06'] = $detail_budget->INT_QTY_BLN06;
        $data['qty07'] = $detail_budget->INT_QTY_BLN07;
        $data['qty08'] = $detail_budget->INT_QTY_BLN08;
        $data['qty09'] = $detail_budget->INT_QTY_BLN09;
        $data['qty10'] = $detail_budget->INT_QTY_BLN10;
        $data['qty11'] = $detail_budget->INT_QTY_BLN11;
        $data['qty12'] = $detail_budget->INT_QTY_BLN12;    
        
        $data['news'] = $this->news_m->get_news();
        $data['msg'] = $msg;
        $data['data_dept'] = $this->dept_m->get_dept();
        $data['data_section'] = $this->section_m->get_section_by_dept($data['dept']);
        $data['data_costcenter'] = $this->costcenter_m->get_costcenter_by_section($data['sect']);
        $data['data_fiscal'] = $this->fiscal_m->get_all_fiscal();
        $data['data_budgetsubcategory'] = $this->budgetsubcategory_m->get_budgetsubcategory_by_budgetcategory($data['category']);
        $data['data_budgetcategory'] = $this->budgetcategory_m->get_budgetcategory_capex();
        $data['data_purposebudget'] = $this->purposebudget_m->get_purposebudget_capex_by_category($data['category']);
        $data['data_project'] = $this->project_m->get_project();
        $data['data_product'] = $this->product_m->get_product();
        $data['unit'] = $this->unit_m->get_unit();
        $data['all_curr'] = $this->currency_m->get_all_currency();
        
        $fiscal_data = $this->fiscal_m->get_all_fiscal();
        $now = date('Ym');
        foreach ($fiscal_data as $value) {
            $ms = $value->CHR_MONTH_START;
            $me = $value->CHR_MONTH_END;
            if ($value->CHR_MONTH_START < 10) {
                $ms = '0' . $value->CHR_MONTH_START;
            }
            if ($value->CHR_MONTH_END < 10) {
                $me = '0' . $value->CHR_MONTH_START;
            }
            $a = $value->CHR_FISCAL_YEAR_START . $ms;
            $b = $value->CHR_FISCAL_YEAR_END . $me;
            if (($a <= $now) && ($now <= $b)) {
                $data['fiscal_year'] =  $value->INT_ID_FISCAL_YEAR;
                $data['year_start'] = $value->CHR_FISCAL_YEAR_START;
                $data['year_end'] = $value->CHR_FISCAL_YEAR_END;
            }
        } 
        
        $data['content'] = 'budget/budget_capex/edit_budget_capex_v';

        $this->load->view($this->layout, $data);
    }
    
    function buildDropSection() {
        $user_session = $this->session->all_userdata();
        echo $id_dept = $this->input->post('id', TRUE);
        $output = null;
        $output = "<option value=''> -- Select Section -- </option>";
        if($user_session['ROLE'] != 1 && $user_session['ROLE'] != 2){
            if ($user_session['SECTION'] != NULL || $user_session['SECTION'] != '') {
                $section_code = $this->section_m->get_name_section_budget($user_session['SECTION']);
                $section_desc = $this->section_m->get_desc_section_budget($user_session['SECTION']);
                if ($section_code != NULL || $section_code != ''){
                    $output .= "<option value='" . $user_session['SECTION'] . "'>" . $section_code . ' / ' . $section_desc . "</option>";
                } else {
                    echo '<option value="">!! Missing Link, Contact the administrator !!</option>';
                }
            } else {
                echo '<option value="">!! Missing Link, Contact the administrator !!</option>';
            }
        } else {
            $data['data_section'] = $this->section_m->get_section_by_dept_budget($id_dept);            
            foreach ($data['data_section'] as $row) {
                $output .= "<option value='" . $row->INT_ID_SECTION . "'>" . $row->CHR_SECTION . ' - ' . $row->CHR_SECTION_DESC . "</option>";
            }
        }
        echo $output;
    }
    
    function buildDropCostCenter() {
        echo $id_sect = $this->input->post('id', TRUE);
        $data['data_costcenter'] = $this->costcenter_m->get_costcenter_by_section($id_sect);
        $output = "";
        $output .= "<option value=''>-- Select Cost Center --</option>";
        foreach ($data['data_costcenter'] as $row) {
            $output .= "<option value='" . $row->INT_ID_COST_CENTER . "'>" . $row->CHR_COST_CENTER . ' - ' . $row->CHR_COST_CENTER_DESC . "</option>";
        }
        echo $output;
    }
    
    function getRateCurr() {
        $id_curr = $this->input->post('id', TRUE);
        $data_curr = $this->currency_m->get_rate_currency($id_curr);
        $rate = $data_curr->NUM_IDR_CURRENCY;        
        echo $rate;
    }

    function buildsubcategory() {
        echo $id_budget_category = $this->input->post('id', TRUE);
        $data['data_budgetsubcategory'] = $this->budgetsubcategory_m->get_budgetsubcategory_by_budgetcategory($id_budget_category);
        $output = null;
        $output .= "<option value=''>-- Select Sub Category --</option>";
        foreach ($data['data_budgetsubcategory'] as $row) {
            $output .= "<option value='" . $row->INT_ID_BUDGET_SUB_CATEGORY . "'>" . $row->CHR_BUDGET_SUB_CATEGORY . ' - ' . $row->CHR_BUDGET_SUB_CATEGORY_DESC . "</option>";
        }
        echo $output;
    }
    
    function buildpurpose() {
        echo $id_budget_category = $this->input->post('id', TRUE);
        $data['data_budgetpurpose'] = $this->purposebudget_m->get_purposebudget_capex_by_category($id_budget_category);
        $output = null;
        $output .= "<option value=''>-- Select Purpose --</option>";
        foreach ($data['data_budgetpurpose'] as $row) {
            $output .= "<option value='" . $row->CHR_PURPOSE . "'>" . $row->CHR_PURPOSE . ' - ' . $row->CHR_PURPOSE_DESC . "</option>";
        }
        echo $output;
    }
    
    function gen_ddl_section() {
        $user_session = $this->session->all_userdata();

        $output = null;
        //if ($user_session['ROLE'] == 6 || $user_session['ROLE'] == 54 || $user_session['ROLE'] == 53 || $user_session['ROLE'] == 55 || $user_session['ROLE'] == 40 || $user_session['ROLE'] == 57 || $user_session['ROLE'] == 58 || $user_session['ROLE'] == 59 || $user_session['ROLE'] == 30 || $user_session['ROLE'] == 13 || $user_session['ROLE'] == 12 || $user_session['ROLE'] == 14) {
        if ($user_session['ROLE'] != 1 && $user_session['ROLE'] != 2) {
            if ($user_session['SECTION'] != NULL || $user_session['SECTION'] != '') {
                $section_code = $this->section_m->get_name_section_budget($user_session['SECTION']);
                $section_desc = $this->section_m->get_desc_section_budget($user_session['SECTION']);
                if ($section_code != NULL || $section_code != ''){
                    $output .= "<option value='" . $user_session['SECTION'] . "'>" . $section_code . ' / ' . $section_desc . "</option>";
                } else {
                    echo '<option value="">!! Missing Link, Contact the administrator !!</option>';
                }
            } else {
                echo '<option value="">!! Missing Link, Contact the administrator !!</option>';
            }
        } else {
            $id_dept = $this->input->post('INT_ID_DEPT', true);
            $data['sect_data'] = $this->section_m->get_section_by_dept_budget($id_dept);

            if ($data['sect_data'] != NULL) {
                foreach ($data['sect_data'] as $row) {
                    $output .= "<option value='" . $row->INT_ID_SECTION . "'>" . $row->CHR_SECTION . ' / ' . $row->CHR_SECTION_DESC . "</option>";
                }
            } else {
                echo '<option value="">!! Missing Link, Contact the administrator !!</option>';
            }
        }
        echo $output;
    }

    
    function prepare_approve_capex($msg = null, $INT_ID_FISCAL_YEAR = null, $INT_DIV = null, $INT_GROUP = null, $INT_DEPT = null, $INT_SECT = null) {
        $user_session = $this->session->all_userdata();
        if ($msg == 5) {
            $msg = "<div class = 'alert alert-success'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Commiting success. </strong> The data is successfully updated. </div >";
        } elseif ($msg == 6) {
            $msg = "<div class = 'alert alert-success'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Budget Capex was Approved. </strong> The data was successfully updated. </div >";
        } elseif ($msg == 7) {
            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Budget Capex was Unapproved. </strong> The data was successfully updated. </div >";
        } elseif ($msg == 8) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Budget Capex was Unlocked. </strong> The data was successfully updated. </div >";
        } elseif ($msg == 12) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Executing error!</strong> Something is not right. </div >";
        } elseif ($msg == 13) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Executing failed!</strong> No data was selected.</div >";
        } elseif ($msg == 14) {
            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Access denied!</strong> Unbudget Capex cannot be ceated on the Planning session.</div >";
        }
        
        $data['INT_ID_FISCAL_YEAR'] = $INT_ID_FISCAL_YEAR;
        $data['INT_DIV'] = $INT_DIV;
        $data['INT_GROUP'] = $INT_GROUP;
        $data['INT_DEPT'] = $INT_DEPT;
        $data['INT_SECT'] = $INT_SECT;
        
        if($INT_ID_FISCAL_YEAR <> null){
            $data['url_page'] = site_url("budget/budget_capex_c/refresh_detail_table_page/1/$INT_ID_FISCAL_YEAR/$INT_DIV/$INT_GROUP/$INT_DEPT");
        } else {
            $data['url_page'] = "";
        }
                
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(42);
        $data['news'] = $this->news_m->get_news();
        $data['data_fiscal'] = $this->fiscal_m->get_all_fiscal();         

        $data['title'] = 'Approval for Planning Capital Expenditure';
        $data['msg'] = $msg;        

        $session = $this->session->all_userdata();
        $user_session = $this->session->all_userdata();
        $user = $this->user_m->get_user_org($user_session['NPK']);

        $data['role'] = $user_session['ROLE'];
        $kode_div = $user_session['DIVISION'];
        $kode_group = $user_session['GROUPDEPT'];
        $kode_dept = $user_session['DEPT'];

        $data['content'] = 'budget/budget_capex/approval_budget_capex_v';

        if ($user_session['ROLE'] == 1 || $user_session['ROLE'] == 2) {
            $data['list_div'] = $this->division_m->get_division();
            $data['list_group'] = $this->groupdept_m->get_groupdept();
            $data['list_dept'] = $this->dept_m->get_all_dept();
            $data['section'] = $this->section_m->get_section_by_dept_budget($kode_dept);
        } else if ($user_session['ROLE'] == 3 || $user_session['ROLE'] == 42 || $user_session['ROLE'] == 43) { //============= BOD            
            $data['INT_DIV'] = $kode_div;

            $data['list_div'] = $this->division_m->get_data_division($kode_div)->result();
            $data['list_group'] = $this->groupdept_m->get_groupdept_by_division($kode_div);
            $data['list_dept'] = $this->dept_m->get_dept_by_division($kode_div);
            $data['section'] = $this->section_m->get_section_by_dept_budget($kode_dept);
        } else if ($user_session['ROLE'] == 4 || $user_session['ROLE'] == 44 || $user_session['ROLE'] == 46 || $user_session['ROLE'] == 47 || $user_session['ROLE'] == 107) { //============== GM            
            $data['INT_DIV'] = $kode_div;
            $data['INT_GROUP'] = $kode_group;

            $data['list_div'] = $this->division_m->get_data_division($kode_div)->result();
            $data['list_group'] = $this->groupdept_m->get_data_groupdept($kode_group)->result();
            $data['list_dept'] = $this->dept_m->get_dept_by_groupdept($kode_group);
            $data['section'] = $this->section_m->get_section_by_dept_budget($kode_dept);
        } else { //if ($user_session['ROLE'] == 5 || $user_session['ROLE'] == 39 || $user_session['ROLE'] == 45) { //============== Manager            
            $data['INT_DIV'] = $kode_div;
            $data['INT_GROUP'] = $kode_group;
            $data['INT_DEPT'] = $kode_dept;

            $data['list_div'] = $this->division_m->get_data_division($kode_div)->result();
            $data['list_group'] = $this->groupdept_m->get_data_groupdept($kode_group)->result();
            $data['list_dept'] = $this->dept_m->get_data_dept($kode_dept)->result();
            $data['section'] = $this->section_m->get_section_by_dept_budget($kode_dept);
        }
        
        $this->load->view($this->layout, $data);
    }
    
    function refresh_detail_table() {
        $INT_ID_FISCAL_YEAR = $this->input->post("INT_ID_FISCAL_YEAR");
        $INT_DEPT = $this->input->post("INT_DEPT");
        $INT_SECT = $this->input->post("INT_SECT");
        $INT_DIV = $this->input->post("INT_DIV");
        $INT_GROUP = $this->input->post("INT_GROUP");
        
        $url_iframe = site_url("budget/budget_capex_c/refresh_detail_table_page/1/$INT_ID_FISCAL_YEAR/$INT_DIV/$INT_GROUP/$INT_DEPT");
        //$url_export_excel = site_url("budget/budget_capex_c/download_excel_for_approve/$INT_ID_FISCAL_YEAR/$INT_DIV/$INT_GROUP/$INT_DEPT");
        $url_export_excel = site_url("budget/budget_capex_c/download_excel/$INT_ID_FISCAL_YEAR/1/$INT_DIV/$INT_DEPT/$INT_SECT/CAPEX");

        $data = array(
            'url_iframe' => $url_iframe,
            'url_export_excel' => $url_export_excel
        );

//Either you can print value or you can send value to database
        echo json_encode($data);

        //echo site_url("budget/budget_dimat_c/refresh_detail_table_page/1/$INT_ID_FISCAL_YEAR/$INT_DIV/$INT_GROUP/$INT_DEPT");
    }

    function refresh_detail_table_page($msg = null, $INT_ID_FISCAL_YEAR = null, $INT_DIV = null, $INT_GROUP = null, $INT_DEPT = null) {
        $user_session = $this->session->all_userdata();
        $role = $user_session['ROLE'];
        
        $data['INT_ID_FISCAL_YEAR'] = $INT_ID_FISCAL_YEAR;
        $data['INT_DIV'] = $INT_DIV;
        $data['INT_GROUP'] = $INT_GROUP;
        $data['INT_DEPT'] = $INT_DEPT;
        $data['role'] = $role;

        $data['content'] = 'budget/budget_capex/refresh_detail_budget_capex_v';
        
//        if($role == 2 && $INT_DIV == 3){
//            $data['summary_capex'] = $this->budget_capex_m->get_summary_capex_cpl($INT_ID_FISCAL_YEAR, $INT_DIV, $INT_GROUP, $INT_DEPT);
//            $data['summary_capex_total'] = $this->budget_capex_m->get_summary_capex_total_cpl($INT_ID_FISCAL_YEAR, $INT_DIV, $INT_GROUP, $INT_DEPT);
//        } else {
            $data['summary_capex'] = $this->budget_capex_m->get_summary_capex($INT_ID_FISCAL_YEAR, $INT_DIV, $INT_GROUP, $INT_DEPT);
            $data['summary_capex_total'] = $this->budget_capex_m->get_summary_capex_total($INT_ID_FISCAL_YEAR, $INT_DIV, $INT_GROUP, $INT_DEPT);
//        }        

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(215);
        $data['news'] = $this->news_m->get_news();
        $data['msg'] = $msg;

        $data['title'] = 'Approval Budget Capital Expenditure';

        $this->load->view($this->layout_blank, $data);
    }
    
    function refresh_summary_table() {
        $INT_ID_FISCAL_YEAR = $this->input->post("INT_ID_FISCAL_YEAR");
        $INT_DEPT = $this->input->post("INT_DEPT");
        $INT_SECT = $this->input->post("INT_SECT");
        $INT_DIV = $this->input->post("INT_DIV");
        $INT_GROUP = $this->input->post("INT_GROUP");

        echo site_url("budget/budget_capex_c/refresh_summary_table_page/1/$INT_ID_FISCAL_YEAR/$INT_DIV/$INT_GROUP/$INT_DEPT/$INT_SECT");
    }

    function refresh_summary_table_page($msg = null, $INT_ID_FISCAL_YEAR = null, $INT_DIV = null, $INT_GROUP = null, $INT_DEPT = null, $INT_SECT = null) {
        $user_session = $this->session->all_userdata();
        $role = $user_session['ROLE'];

        $data['INT_ID_FISCAL_YEAR'] = $INT_ID_FISCAL_YEAR;
        $data['INT_DIV'] = $INT_DIV;
        $data['INT_GROUP'] = $INT_GROUP;
        $data['INT_DEPT'] = $INT_DEPT;
        $data['INT_SECT'] = $INT_SECT;
        $data['role'] = $role;

        $data['DIV'] = $this->division_m->get_name_division($INT_DIV);
        $data['GROUP'] = $this->groupdept_m->get_name_groupdept($INT_GROUP);
        $data['DEPT'] = $this->dept_m->get_name_dept($INT_DEPT);
        $data['SECT'] = $this->section_m->get_name_section($INT_SECT);

        $data['content'] = 'budget/budget_capex/refresh_summary_budget_capex_v';

        if ($user_session['ROLE'] == 1) {
            //GET SUMMARY BUDGET ADMIN
            $data['summary_capex_div'] = $this->budget_capex_m->get_summary_capex_div_admin($INT_ID_FISCAL_YEAR);
            $data['summary_capex_group'] = $this->budget_capex_m->get_summary_capex_group_admin($INT_ID_FISCAL_YEAR);
            $data['summary_capex_dept'] = $this->budget_capex_m->get_summary_capex_dept_admin($INT_ID_FISCAL_YEAR);
            $data['summary_capex_total'] = $this->budget_capex_m->get_summary_capex_admin_total($INT_ID_FISCAL_YEAR);
        } else if ($user_session['ROLE'] == 2) {
            //GET DETAIL BUDGET ADMIN CPL
//            if($INT_DIV == 3){
//                $data['summary_capex_div'] = $this->budget_capex_m->get_summary_capex_div_admin_cpl($INT_ID_FISCAL_YEAR, $INT_DIV);
//                $data['summary_capex_group'] = $this->budget_capex_m->get_summary_capex_group_admin_cpl($INT_ID_FISCAL_YEAR, $INT_DIV);
//                $data['summary_capex_dept'] = $this->budget_capex_m->get_summary_capex_dept_admin_cpl($INT_ID_FISCAL_YEAR, $INT_DIV);
//                $data['summary_capex_total'] = $this->budget_capex_m->get_summary_capex_admin_total_cpl($INT_ID_FISCAL_YEAR, $INT_DIV);
//            } else {
                $data['summary_capex_div'] = $this->budget_capex_m->get_summary_capex_div_admin($INT_ID_FISCAL_YEAR);
                $data['summary_capex_group'] = $this->budget_capex_m->get_summary_capex_group_admin($INT_ID_FISCAL_YEAR);
                $data['summary_capex_dept'] = $this->budget_capex_m->get_summary_capex_dept_admin($INT_ID_FISCAL_YEAR);
                $data['summary_capex_total'] = $this->budget_capex_m->get_summary_capex_admin_total($INT_ID_FISCAL_YEAR);
//            }            
        } else if ($user_session['ROLE'] == 3 || $user_session['ROLE'] == 42 || $user_session['ROLE'] == 43) {
            //GET DETAIL BUDGET DIRECTUR
            $data['summary_capex_div'] = $this->budget_capex_m->get_summary_capex_div_dir($INT_ID_FISCAL_YEAR, $INT_DIV);
            $data['summary_capex_group'] = $this->budget_capex_m->get_summary_capex_group_dir($INT_ID_FISCAL_YEAR, $INT_DIV);
            $data['summary_capex_dept'] = $this->budget_capex_m->get_summary_capex_dept_dir($INT_ID_FISCAL_YEAR, $INT_DIV);
            $data['summary_capex_total'] = $this->budget_capex_m->get_summary_capex_dir_total($INT_ID_FISCAL_YEAR, $INT_DIV);
        } else if ($user_session['ROLE'] == 4 || $user_session['ROLE'] == 44 || $user_session['ROLE'] == 46 || $user_session['ROLE'] == 47 || $user_session['ROLE'] == 107) {
            //GET DETAIL BUDGET GM
            $data['summary_capex_div'] = null;
            $data['summary_capex_group'] = $this->budget_capex_m->get_summary_capex_group_gm($INT_ID_FISCAL_YEAR, $INT_DIV, $INT_GROUP);
            $data['summary_capex_dept'] = $this->budget_capex_m->get_summary_capex_dept_gm($INT_ID_FISCAL_YEAR, $INT_DIV, $INT_GROUP);
            $data['summary_capex_total'] = $this->budget_capex_m->get_summary_capex_gm_total($INT_ID_FISCAL_YEAR, $INT_DIV, $INT_GROUP);
        } else if ($user_session['ROLE'] == 5 || $user_session['ROLE'] == 39 || $user_session['ROLE'] == 45 || $user_session['ROLE'] == 48 || $user_session['ROLE'] == 49 || $user_session['ROLE'] == 50 || $user_session['ROLE'] == 52) {
            //GET DETAIL BUDGET MANAGER
            $data['summary_capex_div'] = null;
            $data['summary_capex_group'] = null;
            $data['summary_capex_dept'] = $this->budget_capex_m->get_summary_capex_dept_man($INT_ID_FISCAL_YEAR, $INT_DIV, $INT_GROUP, $INT_DEPT);
            $data['summary_capex_total'] = $this->budget_capex_m->get_summary_capex_man_total($INT_ID_FISCAL_YEAR, $INT_DIV, $INT_GROUP, $INT_DEPT);
        }

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(19);
        $data['news'] = $this->news_m->get_news();
        $data['msg'] = $msg;

        $data['title'] = 'Approval Budget Expense';

        $this->load->view($this->layout_blank, $data);
    }

    function approve_budget_capex() {
        $user_session = $this->session->all_userdata();

        $INT_ID_FISCAL_YEAR = $this->input->post('INT_ID_FISCAL_YEAR');
        $INT_DIV = $this->input->post('INT_ID_DIV');
        $INT_GROUP = $this->input->post('INT_ID_GROUP');
        $INT_DEPT = $this->input->post('INT_ID_DEPT');
        
        $username = $user_session['USERNAME'];
        $date = date("Ymd");
        $time = date("His");

        if ($_POST["btn-save"] == 'man') {
            $app_man = $this->db;
            $app_man->trans_begin();

            $app_man->query("UPDATE CPL.TT_BUDGET_CAPEX SET CHR_FLAG_APP_MAN = '1', CHR_MODI_BY = '$username', CHR_MODI_DATE = '$date', CHR_MODI_TIME = '$time'
                            WHERE (INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR')
                                    AND (INT_DIV = '$INT_DIV')
                                    AND (INT_GROUP_DEPT = '$INT_GROUP')
                                    AND (INT_DEPT = '$INT_DEPT')");

            $app_man->trans_complete();

            if ($app_man->trans_status() === FALSE) {
                $app_man->trans_rollback();
                redirect("budget/budget_capex_c/prepare_approve_capex/12/$INT_ID_FISCAL_YEAR/$INT_DIV/$INT_GROUP/$INT_DEPT");
            } else {
                $app_man->trans_commit();
                redirect("budget/budget_capex_c/prepare_approve_capex/6/$INT_ID_FISCAL_YEAR/$INT_DIV/$INT_GROUP/$INT_DEPT");
            }
        } else if ($_POST["btn-save"] == 'gm') {
            $app_gm = $this->db;
            $app_gm->trans_start();

            $app_gm->query("UPDATE CPL.TT_BUDGET_CAPEX SET CHR_FLAG_APP_GM = '1', CHR_MODI_BY = '$username', CHR_MODI_DATE = '$date', CHR_MODI_TIME = '$time'
                            WHERE (INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR')
                                    AND (INT_DIV = '$INT_DIV')
                                    AND (INT_GROUP_DEPT = '$INT_GROUP')
                                    AND (INT_DEPT = '$INT_DEPT')");

            $app_gm->trans_complete();

            if ($app_gm->trans_status() === FALSE) {
                $app_gm->trans_rollback();
                redirect("budget/budget_capex_c/prepare_approve_capex/12/$INT_ID_FISCAL_YEAR/$INT_DIV/$INT_GROUP/$INT_DEPT");
            } else {
                $app_gm->trans_commit();
                redirect("budget/budget_capex_c/prepare_approve_capex/6/$INT_ID_FISCAL_YEAR/$INT_DIV/$INT_GROUP/$INT_DEPT");
            }
        } else if ($_POST["btn-save"] == 'dir') {
            $app_dir = $this->db;
            $app_dir->trans_start();

            $app_dir->query("UPDATE CPL.TT_BUDGET_CAPEX SET CHR_FLAG_APP_DIR = '1', CHR_MODI_BY = '$username', CHR_MODI_DATE = '$date', CHR_MODI_TIME = '$time'
                            WHERE (INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR')
                                    AND (INT_DIV = '$INT_DIV')
                                    AND (INT_GROUP_DEPT = '$INT_GROUP')
                                    AND (INT_DEPT = '$INT_DEPT')");

            $app_dir->trans_complete();

            if ($app_dir->trans_status() === FALSE) {
                $app_dir->trans_rollback();
                redirect("budget/budget_capex_c/prepare_approve_capex/12/$INT_ID_FISCAL_YEAR/$INT_DIV/$INT_GROUP/$INT_DEPT");
            } else {
                $app_dir->trans_commit();
                redirect("budget/budget_capex_c/prepare_approve_capex/6/$INT_ID_FISCAL_YEAR/$INT_DIV/$INT_GROUP/$INT_DEPT");
            }
        } else if ($_POST["btn-save"] == 'all') {
            $app_all = $this->db;
            $app_all->trans_start();

            $app_all->query("UPDATE CPL.TT_BUDGET_CAPEX SET CHR_FLAG_APP_MAN = '1', CHR_FLAG_APP_GM = '1', CHR_FLAG_APP_DIR = '1', CHR_FLAG_APP_COMPLETE = '1',
                                CHR_MODI_BY = '$username', CHR_MODI_DATE = '$date', CHR_MODI_TIME = '$time'
                            WHERE (INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR')
                                    AND (INT_DIV = '$INT_DIV')
                                    AND (INT_GROUP_DEPT = '$INT_GROUP')
                                    AND (INT_DEPT = '$INT_DEPT')");

            $app_all->trans_complete();

            if ($app_all->trans_status() === FALSE) {
                $app_all->trans_rollback();
                redirect("budget/budget_capex_c/prepare_approve_capex/12/$INT_ID_FISCAL_YEAR/$INT_DIV/$INT_GROUP/$INT_DEPT");
            } else {
                $app_all->trans_commit();
                redirect("budget/budget_capex_c/prepare_approve_capex/6/$INT_ID_FISCAL_YEAR/$INT_DIV/$INT_GROUP/$INT_DEPT");
            }
        } else if ($_POST["btn-save"] == 'reject') {
            $app_all = $this->db;
            $app_all->trans_start();

            $app_all->query("UPDATE CPL.TT_BUDGET_CAPEX SET CHR_FLAG_APP_MAN = '0', CHR_FLAG_APP_GM = '0', CHR_FLAG_APP_DIR = '0', CHR_FLAG_APP_COMPLETE = '0',
                                CHR_MODI_BY = '$username', CHR_MODI_DATE = '$date', CHR_MODI_TIME = '$time'
                            WHERE (INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR')
                                    AND (INT_DIV = '$INT_DIV')
                                    AND (INT_GROUP_DEPT = '$INT_GROUP')
                                    AND (INT_DEPT = '$INT_DEPT')");

            $app_all->trans_complete();

            if ($app_all->trans_status() === FALSE) {
                $app_all->trans_rollback();
                redirect("budget/budget_capex_c/prepare_approve_capex/12/$INT_ID_FISCAL_YEAR/$INT_DIV/$INT_GROUP/$INT_DEPT");
            } else {
                $app_all->trans_commit();
                redirect("budget/budget_capex_c/prepare_approve_capex/7/$INT_ID_FISCAL_YEAR/$INT_DIV/$INT_GROUP/$INT_DEPT");
            }
        }
    }
    
    function gen_ddl_groupdept() {
        $id_div = $this->input->post('INT_ID_DIV', true);
        $data['group_data'] = $this->groupdept_m->get_groupdept_by_division($id_div);
        $output = null;
        if ($data['group_data'] != NULL) {
            $output .= "<option value=''> -- Select Group Dept -- </option>";
            foreach ($data['group_data'] as $row) {                
                $output .= "<option value='" . $row->INT_ID_GROUP_DEPT . "'>" . $row->CHR_GROUP_DEPT . ' / ' . $row->CHR_GROUP_DEPT_DESC . "</option>";
            }
        } else {
            echo '<option value=""> -- Select Division First -- </option>';
        }
        echo $output;
    }
    
    function gen_ddl_dept() {
        $id_group = $this->input->post('INT_ID_GROUP', true);
        $data['dept_data'] = $this->dept_m->get_dept_by_groupdept($id_group);
        $output = null;
        if ($data['dept_data'] != NULL) {
            $output .= "<option value=''> -- Select Department -- </option>";
            foreach ($data['dept_data'] as $row) {
                $output .= "<option value='" . $row->INT_ID_DEPT . "'>" . $row->CHR_DEPT . ' / ' . $row->CHR_DEPT_DESC . "</option>";
            }
        } else {
            echo '<option value=""> -- Select Group Dept First -- </option>';
        }
        echo $output;
    }
    
    function gen_ddl_section_app() {
        $id_dept = $this->input->post('INT_ID_DEPT', true);
        $data['sect_data'] = $this->section_m->get_section_by_dept_budget($id_dept);
        $output = null;
        if ($data['sect_data'] != NULL) {
            $output .= "<option value=''> -- Select Section -- </option>";
            foreach ($data['sect_data'] as $row) {
                $output .= "<option value='" . $row->INT_ID_SECTION . "'>" . $row->CHR_SECTION . ' / ' . $row->CHR_SECTION_DESC . "</option>";
            }
        } else {
            echo '<option value=""> -- Select Department First -- </option>';
        }
        echo $output;
    }

    function download_template($budget_type) {
        $this->load->helper('download');
        $filename = 'Template_Direct_Material';
        
        ob_clean();
        $name = $filename.'.xls';
        $data = file_get_contents("assets/template/budget/$filename.xls");

        force_download($name, $data);
    }

//    function upload_budget_capex() {
//        $this->load->helper(array('form', 'url', 'inflector'));
//        $this->load->library(array('PHPExcel', 'PHPExcel/IOFactory'));
//        $INT_ID_FISCAL_YEAR = $this->input->post("INT_ID_FISCAL_YEAR");
//        $INT_ID_FISCAL_YEAR = substr($INT_ID_FISCAL_YEAR, 0, 4);
//        $INT_DEPT = $this->input->post("INT_ID_DEPT");
//        $INT_SECT = $this->input->post("INT_ID_SECT");
//        $INT_ID_BUDGET_TYPE = 48;
//        $CHR_BUDGET_TYPE_DESC = $this->budgettype_m->get_budget_type($INT_ID_BUDGET_TYPE);
//        $CHR_BUDGET_TYPE = trim($CHR_BUDGET_TYPE_DESC->CHR_BUDGET_TYPE);
//        $CHR_BUDGET_TYPE_DESC = trim($CHR_BUDGET_TYPE_DESC->CHR_BUDGET_TYPE_DESC);
//        $budget_type_desc_format = str_replace(" ", "_", $CHR_BUDGET_TYPE_DESC);
//        $get_gm_div = $this->dept_m->get_gm_div($INT_DEPT)->row();
//        $INT_DIV = $get_gm_div->INT_ID_DIVISION;
//
//        //delete existing template
//        $this->budget_dimat_m->delete_existing_template($CHR_BUDGET_TYPE, $INT_DIV, $INT_DEPT, $INT_SECT);
//
//        $upload_date = date('Ymd');
//        $fileName = $_FILES['upload_budget_dimat']['name'];
//        if (empty($fileName)) {
//            redirect($this->back_to_upload . $msg = 12);
//        }
//
//        //file untuk submit file excel
//        $config['upload_path'] = './assets/file/budget_direct_material/';
//        $config['file_name'] = $fileName;
//        $config['allowed_types'] = 'xls|xlsx';
//        $config['max_size'] = 10000;
//
//        //code for upload with ci
//        $this->load->library('upload');
//        $this->upload->initialize($config);
//        if ($a = $this->upload->do_upload('upload_budget_dimat'))
//            $this->upload->display_errors();
//        $media = $this->upload->data('upload_budget_dimat');
//        //cek apakah template sesuai dengan pilihan tipe budget?
//        if (strpos($media['file_name'], str_replace(" ", "_", $CHR_BUDGET_TYPE_DESC)) === false) {
//        //jika template tidak sesuai dengan tipe budget
//
//            redirect($this->back_to_upload . $msg = 16);
//        }
//
//        $inputFileName = './assets/file/budget_direct_material/' . $media['file_name'];
//
//        //Read  Excel workbook
//        try {
//            $inputFileType = IOFactory::identify($inputFileName);
//            $objReader = IOFactory::createReader($inputFileType);
//            $objPHPExcel = $objReader->load($inputFileName);
//        } catch (Exception $e) {
//            die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' . $e->getMessage());
//        }
//
//        //Get worksheet dimensions
//        $sheet = $objPHPExcel->getSheet(0);
//        $highestRow = $sheet->getHighestRow();
//        $highestColumn = $sheet->getHighestColumn();
//        $rowHeader = $sheet->rangeToArray('A1:CV1', NULL, TRUE, FALSE);
//        $budget_type_template = strtolower($rowHeader[0][99]);
//        if ($budget_type_template !== strtolower($CHR_BUDGET_TYPE_DESC)) {
//            redirect($this->back_to_upload . $msg = 16);
//        }
//        $get_gm_div = $this->dept_m->get_gm_div($INT_DEPT)->row();
//        $INT_GROUP_DEPT = $get_gm_div->INT_ID_GROUP_DEPT;
//        $INT_DIV = $get_gm_div->INT_ID_DIVISION;
//        
//        for ($row = 3; $row <= $highestRow; $row++) {
//            $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);
//            if ($rowData[0][1] == '') {
//                break;
//            }
//            //===============================   common data   =============================== 
//            $CHR_BUDGET_SUB_CATEGORY = $rowData[0][1];
//            $CHR_BUDGET_SUB_CATEGORY_DESC = $rowData[0][2];
//            $CHR_BUDGET_CATEGORY = $rowData[0][3];
//            $CHR_BUDGET_CATEGORY_DESC = $rowData[0][4];
//            $CHR_CODE_CATEGORY_A3 = $rowData[0][5];
//            $CHR_CODE_CATEGORY_A3_DESC = $rowData[0][6];            
//            //=============================== end common data =============================== 
//            
//            $MON_AMT_BLN04 = "0";
//            $MON_AMT_BLN05 = "0";
//            $MON_AMT_BLN06 = "0";
//            $MON_AMT_BLN07 = "0";
//            $MON_AMT_BLN08 = "0";
//            $MON_AMT_BLN09 = "0";
//            $MON_AMT_BLN10 = "0";
//            $MON_AMT_BLN11 = "0";
//            $MON_AMT_BLN12 = "0";
//            $MON_AMT_BLN01 = "0";
//            $MON_AMT_BLN02 = "0";
//            $MON_AMT_BLN03 = "0";
//            //===  TOTAL AMOUNT
//            $MON_AMT_SUM = "0";
//
//            //===============================   DIRECT MATERIAL   =============================== 
//                $MON_AMT_BLN04 = $rowData[0][7];
//                $MON_AMT_BLN05 = $rowData[0][8];
//                $MON_AMT_BLN06 = $rowData[0][9];
//                $MON_AMT_BLN07 = $rowData[0][10];
//                $MON_AMT_BLN08 = $rowData[0][11];
//                $MON_AMT_BLN09 = $rowData[0][12];
//                $MON_AMT_BLN10 = $rowData[0][13];
//                $MON_AMT_BLN11 = $rowData[0][14];
//                $MON_AMT_BLN12 = $rowData[0][15];
//                $MON_AMT_BLN01 = $rowData[0][16];
//                $MON_AMT_BLN02 = $rowData[0][17];
//                $MON_AMT_BLN03 = $rowData[0][18];
//                
//                $MON_AMT_SUM = $MON_AMT_BLN04 + $MON_AMT_BLN05 + $MON_AMT_BLN06 + $MON_AMT_BLN07 + $MON_AMT_BLN08 + $MON_AMT_BLN09 + $MON_AMT_BLN10 + $MON_AMT_BLN11 + $MON_AMT_BLN12 + $MON_AMT_BLN01 + $MON_AMT_BLN02 + $MON_AMT_BLN03;
//            //=============================== END DIRECT MATERIAL =============================== 
//            
//            //ASSIGN TO ARRAY
//            $data = array(
//                'INT_ID_FISCAL_YEAR' => $INT_ID_FISCAL_YEAR,
//                'CHR_BUDGET_TYPE' => $CHR_BUDGET_TYPE,
//                'CHR_BUDGET_TYPE_DESC' => $CHR_BUDGET_TYPE_DESC,
//                'CHR_BUDGET_SUB_CATEGORY' => $CHR_BUDGET_SUB_CATEGORY,
//                'CHR_BUDGET_SUB_CATEGORY_DESC' => $CHR_BUDGET_SUB_CATEGORY_DESC,
//                'CHR_BUDGET_CATEGORY' => $CHR_BUDGET_CATEGORY,
//                'CHR_BUDGET_CATEGORY_DESC' => $CHR_BUDGET_CATEGORY_DESC,
//                'CHR_CODE_CATEGORY_A3' => $CHR_CODE_CATEGORY_A3,
//                'CHR_CODE_CATEGORY_A3_DESC' => $CHR_CODE_CATEGORY_A3_DESC,                
//                'MON_AMT_BLN01' => $MON_AMT_BLN01,
//                'MON_AMT_BLN02' => $MON_AMT_BLN02,
//                'MON_AMT_BLN03' => $MON_AMT_BLN03,
//                'MON_AMT_BLN04' => $MON_AMT_BLN04,
//                'MON_AMT_BLN05' => $MON_AMT_BLN05,
//                'MON_AMT_BLN06' => $MON_AMT_BLN06,
//                'MON_AMT_BLN07' => $MON_AMT_BLN07,
//                'MON_AMT_BLN08' => $MON_AMT_BLN08,
//                'MON_AMT_BLN09' => $MON_AMT_BLN09,
//                'MON_AMT_BLN10' => $MON_AMT_BLN10,
//                'MON_AMT_BLN11' => $MON_AMT_BLN11,
//                'MON_AMT_BLN12' => $MON_AMT_BLN12,
//                'INT_SECT' => $INT_SECT,
//                'INT_DEPT' => $INT_DEPT,
//                'INT_GROUP_DEPT' => $INT_GROUP_DEPT,
//                'INT_DIV' => $INT_DIV,
//                'MON_AMT_SUM' => $MON_AMT_SUM,
//            );
////SAVE TO DATABASE
//            $this->budget_dimat_m->save_temp($data);
//        }
//        redirect("budget/budget_dimat_c/confirmation_budget_dimat/$INT_ID_FISCAL_YEAR/$INT_ID_BUDGET_TYPE/$INT_DIV/$INT_DEPT/$INT_SECT/$CHR_BUDGET_TYPE", "REFRESH");
//    }
    
    function save_temp_budget_capex() {
        $user_session = $this->session->all_userdata();
//        print_r($this->input->post("CHR_DEPC_YEAR"));
//        exit();
        $INT_ID_FISCAL_YEAR = $this->input->post("INT_ID_FISCAL_YEAR");
        // $INT_DIV = $user_session['DIVISION'];
        // $INT_DEPT = $user_session['DEPT'];
        // $INT_GROUP_DEPT = $user_session['GROUPDEPT'];
        
        $INT_DEPT = $this->input->post("INT_ID_DEPT");
        $INT_DIV = $this->dept_m->get_id_div_by_id_dept($INT_DEPT);
        $INT_GROUP_DEPT = $this->dept_m->get_groupdept_by_dept($INT_DEPT);
        $INT_SECT = $this->input->post("INT_ID_SECTION");
        $INT_COSTCENTER = $this->input->post("INT_ID_COST_CENTER");
        
        $INT_ID_BUDGET_TYPE = 1;
        $CHR_BUDGET_TYPE = 'CAPEX';
        $CHR_BUDGET_TYPE_DESC = $this->budgettype_m->get_desc_budgettype($INT_ID_BUDGET_TYPE);
        $INT_ID_BUDGET_CATEGORY = $this->input->post("CHR_BUDGET_CATEGORY");
        $CHR_BUDGET_CATEGORY = $this->budgetcategory_m->get_init_budgetcategory($INT_ID_BUDGET_CATEGORY);
        $CHR_BUDGET_CATEGORY_DESC = $this->budgetcategory_m->get_desc_budgetcategory($INT_ID_BUDGET_CATEGORY);
        $INT_ID_BUDGET_SUB_CATEGORY = $this->input->post("CHR_BUDGET_SUB_CATEGORY");
        $CHR_BUDGET_SUB_CATEGORY = $this->budgetsubcategory_m->get_init_budgetsubcategory($INT_ID_BUDGET_SUB_CATEGORY);
        $CHR_BUDGET_SUB_CATEGORY_DESC = $this->budgetsubcategory_m->get_desc_budgetsubcategory($INT_ID_BUDGET_SUB_CATEGORY);
        $CHR_CODE_CATEGORY_A3 = '-';
        $CHR_CODE_CATEGORY_A3_DESC = '-';
        $CHR_BUDGET_DESC = $this->input->post("CHR_BUDGET_DESC");
        
        $CHR_PURPOSE = $this->input->post("CHR_PURPOSE");
        $CHR_PROJECT = $this->input->post("CHR_PROJECT");
        
        $list_project = '';
        if($CHR_PROJECT != NULL || $CHR_PROJECT != '' || $CHR_PROJECT != 0){ 
            $no = 1;
            for($i = 0; $i < count($CHR_PROJECT); $i++){
                if($no == count($CHR_PROJECT)){
                    $list_project .= trim($CHR_PROJECT[$i]);
                } else {
                    $list_project .= trim($CHR_PROJECT[$i]) . '#';
                }
                $no++;
            }
        } else {
            $list_project = '-'; 
        }
        
        $CHR_PRODUCT = $this->input->post("CHR_PRODUCT");
        $list_product = '';
        if($CHR_PRODUCT != NULL || $CHR_PRODUCT != '' || $CHR_PRODUCT != 0){ 
            $no = 1;
            for($i = 0; $i < count($CHR_PRODUCT); $i++){
                if($no == count($CHR_PRODUCT)){
                    $list_product .= trim($CHR_PRODUCT[$i]);
                } else {
                    $list_product .= trim($CHR_PRODUCT[$i]) . '#';
                }
                $no++;
            }
        } else {
            $list_product = '-'; 
        }
        
        $CHR_STATUS = $this->input->post("CHR_STATUS_BUDGET");
        $CHR_OWNER = $this->input->post("CHR_OWNER");
        $CHR_SUPPLIER = $this->input->post("CHR_SUPPLIER");
        $CHR_UNIT = $this->input->post("CHR_UNIT");
        $CHR_DEPRECIATION = $this->input->post("CHR_DEPC_YEAR") . $this->input->post("CHR_DEPC_MONTH");
        $INT_ID_ORG_CURR = $this->input->post("CHR_CURRENCY");
        $CHR_CURRENCY = $this->currency_m->get_data_currency($INT_ID_ORG_CURR)->row()->CHR_CURRENCY;
        $RATE_CURRENCY = $this->input->post("RATE_CURRENCY");
        $INT_FLG_CIP = $this->input->post("INT_FLG_CIP");
        
        $PRICE_ORI = $this->input->post("PRICE_PER_UNIT_ORI");
        $PRICE_IDR = $this->input->post("PRICE_PER_UNIT_IDR");
        $PRICE_INK = $this->input->post("PRICE_INKLARING");
        $PRICE_ENG = $this->input->post("PRICE_ENGFEE");
        $PRICE_IMP = $this->input->post("PRICE_IMPORT_DUTY");
        $TOT_PRICE = $this->input->post("TOT_PRICE_IDR");
        
        //DELETE TEMPORARY DATA IN TABLE TW BEFORE SAVE
        $this->budget_capex_m->delete_existing_temp($INT_ID_FISCAL_YEAR, $INT_DIV, $INT_DEPT, $INT_SECT, $INT_COSTCENTER, $CHR_BUDGET_TYPE);
        
        $tot_qty = 0;
        for($i = 4; $i <= 15; $i++){
            $qty = $this->input->post("INT_QTY_".$i);
            $tot_qty = $tot_qty + $qty;
            if($i == 13){
                $month = '01';
            } else if($i == 14){
                $month = '02';
            } else if($i == 15){
                $month = '03';
            } else {
                $month = sprintf("%02d", $i);
            }
            
            if($qty > 0){
                for($x = 1; $x <= $qty; $x++){
                    $data = array(
                            'INT_ID_FISCAL_YEAR' => $INT_ID_FISCAL_YEAR,
                            'CHR_BUDGET_TYPE' => $CHR_BUDGET_TYPE,
                            'CHR_BUDGET_TYPE_DESC' => $CHR_BUDGET_TYPE_DESC,
                            'CHR_BUDGET_SUB_CATEGORY' => $CHR_BUDGET_SUB_CATEGORY,
                            'CHR_BUDGET_SUB_CATEGORY_DESC' => $CHR_BUDGET_SUB_CATEGORY_DESC,
                            'CHR_BUDGET_CATEGORY' => $CHR_BUDGET_CATEGORY,
                            'CHR_BUDGET_CATEGORY_DESC' => $CHR_BUDGET_CATEGORY_DESC,
                            'CHR_CODE_CATEGORY_A3' => $CHR_CODE_CATEGORY_A3,
                            'CHR_CODE_CATEGORY_A3_DESC' => $CHR_CODE_CATEGORY_A3_DESC, 
                            'INT_DIV' => $INT_DIV,
                            'INT_GROUP_DEPT' => $INT_GROUP_DEPT,
                            'INT_DEPT' => $INT_DEPT,
                            'INT_SECT' => $INT_SECT,
                            'INT_COST_CENTER' => $INT_COSTCENTER,
                            'CHR_PURPOSE' => $CHR_PURPOSE,
                            'CHR_PROJECT' => $list_project,
                            'CHR_PRODUCT' => $list_product,
                            'INT_FLG_CIP' => $INT_FLG_CIP,
                            'CHR_BUDGET_DESC' => $CHR_BUDGET_DESC,
                            'CHR_STATUS_BUDGET' => $CHR_STATUS,
                            'CHR_RUN_DEPRECIATION' => $CHR_DEPRECIATION,
                            'CHR_SUPPLIER_LOCATION' => $CHR_SUPPLIER,
                            'CHR_DIE_OWNER' => $CHR_OWNER,
                            'CHR_SATUAN' => $CHR_UNIT,
                            'CHR_ORG_CURR' => $CHR_CURRENCY,
                            'FLT_RATE_CURR' => $RATE_CURRENCY,
                            'MON_PRICE_ORI' => $PRICE_ORI,
                            'MON_PRICE_IDR' => $PRICE_IDR,
                            'MON_INKLARING' => $PRICE_INK,
                            'MON_ENGFEE' => $PRICE_ENG,
                            'MON_IMPORT_DUTY' => $PRICE_IMP,
                            'INT_QTY_BLN'.$month => 1,
                            'INT_QTY_SUM' => 1,
                            'MON_AMT_BLN'.$month => $TOT_PRICE,
                            'MON_AMT_SUM' => $TOT_PRICE
                        );
                    //SAVE TO DATABASE
                    $this->budget_capex_m->save_temp($data);
                }
            }
        }
            
        redirect("budget/budget_capex_c/confirmation_budget_capex/$INT_ID_FISCAL_YEAR/$INT_ID_BUDGET_TYPE/$INT_DIV/$INT_DEPT/$INT_SECT/$CHR_BUDGET_TYPE", "REFRESH");
    }

    function confirmation_budget_capex($INT_ID_FISCAL_YEAR = NULL, $INT_ID_BUDGET_TYPE = NULL, $INT_DIV = NULL, $INT_DEPT = NULL, $INT_SECT = NULL, $CHR_BUDGET_TYPE = NULL) {
        $user_session = $this->session->all_userdata();
        
//        print_r('OK');
//        exit();
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(212);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Confirmation Budget Capital Expenditure';
        $data['subcontent'] = NULL;
        $data['content'] = 'budget/budget_capex/confirmation_budget_capex_v';
        
        $data['INT_ID_FISCAL_YEAR'] = $INT_ID_FISCAL_YEAR;
        $data['INT_ID_BUDGET_TYPE'] = 1;
        $data['INT_DIV'] = $INT_DIV;
        $data['INT_DEPT'] = $INT_DEPT;
        $data['INT_SECT'] = $INT_SECT;
        $data['CHR_BUDGET_TYPE'] = $CHR_BUDGET_TYPE;

        //GET FISCAL YEAR
        $data['CHR_FISCAL_YEAR'] = $this->fiscal_m->select_fiscal_year($INT_ID_FISCAL_YEAR);
        //GET BUDGET TYPE
        $data['CHR_BUDGET_TYPE_DESC'] = $this->budgettype_m->get_desc_budgettype($INT_ID_BUDGET_TYPE);
        //GET DEPT
        $data['CHR_DEPT_DESC'] = $this->dept_m->get_name_dept($INT_DEPT);
        //GET SECTION 
        $data['CHR_SECTION_DESC'] = $this->section_m->get_desc_section($INT_SECT);
        //GET DETAIL BUDGET
        $data['detail_confirm'] = $this->budget_capex_m->get_detail_confirm_capex($INT_ID_FISCAL_YEAR, $CHR_BUDGET_TYPE, $INT_DIV, $INT_DEPT, $INT_SECT);
        $data['detail_confirm_sum'] = $this->budget_capex_m->get_sum_capex($INT_ID_FISCAL_YEAR, $CHR_BUDGET_TYPE, $INT_DIV, $INT_DEPT, $INT_SECT);
        //GET SUM AMOUNT
        $data['SUM_AMT'] = $this->budget_capex_m->get_sum_amt_confirm_capex($INT_ID_FISCAL_YEAR, $CHR_BUDGET_TYPE, $INT_DIV, $INT_DEPT, $INT_SECT);

        $this->load->view($this->layout, $data);
    }

    function save_budget_capex($INT_ID_FISCAL_YEAR = NULL, $INT_ID_BUDGET_TYPE = NULL, $INT_DIV = NULL, $INT_DEPT = NULL, $INT_SECT = NULL, $CHR_BUDGET_TYPE = NULL) {
        $user_session = $this->session->all_userdata();
        $CHR_CREATE_BY = $user_session['USERNAME'];
        $CHR_CREATE_DATE = date("Ymd");
        $CHR_CREATE_TIME = date("his");

        //CHECK SEQUNCE BUDGET NUMBER
        //GET BUDGET NUMBER
        //SAVE DATA FROM TABLE WORK TO TABLE TRANSACTION
        $detail_budget = $this->budget_capex_m->get_detail_confirm_capex($INT_ID_FISCAL_YEAR, $CHR_BUDGET_TYPE, $INT_DIV, $INT_DEPT, $INT_SECT);
        //ASSIGN TO ARRAY
        foreach ($detail_budget as $value) {
            // $CHR_STAT_REV = $value->CHR_STATUS_BUDGET;
            $CHR_STAT_REV = 'NEW';
            $CHR_NO_BUDGET = $this->budget_capex_m->get_no_budget($INT_ID_FISCAL_YEAR, $INT_ID_BUDGET_TYPE, $INT_DIV, $INT_DEPT, $INT_SECT, $CHR_BUDGET_TYPE, $CHR_STAT_REV);
            
            $data = array(
                    'CHR_NO_BUDGET' => trim($CHR_NO_BUDGET),
                    'CHR_STAT_REV' => $CHR_STAT_REV,
                    'INT_ID_FISCAL_YEAR' => $INT_ID_FISCAL_YEAR,
                    'CHR_BUDGET_TYPE' => $CHR_BUDGET_TYPE,
                    'CHR_BUDGET_TYPE_DESC' => $value->CHR_BUDGET_TYPE_DESC,
                    'CHR_BUDGET_SUB_CATEGORY' => $value->CHR_BUDGET_SUB_CATEGORY,
                    'CHR_BUDGET_SUB_CATEGORY_DESC' => $value->CHR_BUDGET_SUB_CATEGORY_DESC,
                    'CHR_BUDGET_CATEGORY' => $value->CHR_BUDGET_CATEGORY,
                    'CHR_BUDGET_CATEGORY_DESC' => $value->CHR_BUDGET_CATEGORY_DESC,
                    'CHR_CODE_CATEGORY_A3' => $value->CHR_CODE_CATEGORY_A3,
                    'CHR_CODE_CATEGORY_A3_DESC' => $value->CHR_CODE_CATEGORY_A3_DESC, 
                    'INT_DIV' => $INT_DIV,
                    'INT_GROUP_DEPT' => $value->INT_GROUP_DEPT,
                    'INT_DEPT' => $INT_DEPT,
                    'INT_SECT' => $INT_SECT,
                    'INT_COST_CENTER' => $value->INT_COST_CENTER,
                    'CHR_PURPOSE' => $value->CHR_PURPOSE,
                    'CHR_PROJECT' => $value->CHR_PROJECT,
                    'CHR_PRODUCT' => $value->CHR_PRODUCT,
                    'INT_FLG_CIP' => $value->INT_FLG_CIP,
                    'CHR_BUDGET_DESC' => $value->CHR_BUDGET_DESC,
                    'CHR_STATUS_BUDGET' => $value->CHR_STATUS_BUDGET,
                    'CHR_RUN_DEPRECIATION' => $value->CHR_RUN_DEPRECIATION,
                    'CHR_SUPPLIER_LOCATION' => $value->CHR_SUPPLIER_LOCATION,
                    'CHR_DIE_OWNER' => $value->CHR_DIE_OWNER,
                    'CHR_SATUAN' => $value->CHR_SATUAN,
                    'CHR_ORG_CURR' => $value->CHR_ORG_CURR,
                    'FLT_RATE_CURR' => $value->FLT_RATE_CURR,
                    'MON_PRICE_ORI' => $value->MON_PRICE_ORI,
                    'MON_PRICE_IDR' => $value->MON_PRICE_IDR,
                    'MON_INKLARING' => $value->MON_INKLARING,
                    'MON_ENGFEE' => $value->MON_ENGFEE,
                    'MON_IMPORT_DUTY' => $value->MON_IMPORT_DUTY,
                    'INT_QTY_BLN01' => $value->INT_QTY_BLN01,
                    'INT_QTY_BLN02' => $value->INT_QTY_BLN02,
                    'INT_QTY_BLN03' => $value->INT_QTY_BLN03,
                    'INT_QTY_BLN04' => $value->INT_QTY_BLN04,
                    'INT_QTY_BLN05' => $value->INT_QTY_BLN05,
                    'INT_QTY_BLN06' => $value->INT_QTY_BLN06,
                    'INT_QTY_BLN07' => $value->INT_QTY_BLN07,
                    'INT_QTY_BLN08' => $value->INT_QTY_BLN08,
                    'INT_QTY_BLN09' => $value->INT_QTY_BLN09,
                    'INT_QTY_BLN10' => $value->INT_QTY_BLN10,
                    'INT_QTY_BLN11' => $value->INT_QTY_BLN11,
                    'INT_QTY_BLN12' => $value->INT_QTY_BLN12,
                    'INT_QTY_SUM' => $value->INT_QTY_SUM,
                    'MON_AMT_BLN01' => $value->MON_AMT_BLN01,
                    'MON_AMT_BLN02' => $value->MON_AMT_BLN02,
                    'MON_AMT_BLN03' => $value->MON_AMT_BLN03,
                    'MON_AMT_BLN04' => $value->MON_AMT_BLN04,
                    'MON_AMT_BLN05' => $value->MON_AMT_BLN05,
                    'MON_AMT_BLN06' => $value->MON_AMT_BLN06,
                    'MON_AMT_BLN07' => $value->MON_AMT_BLN07,
                    'MON_AMT_BLN08' => $value->MON_AMT_BLN08,
                    'MON_AMT_BLN09' => $value->MON_AMT_BLN09,
                    'MON_AMT_BLN10' => $value->MON_AMT_BLN10,
                    'MON_AMT_BLN11' => $value->MON_AMT_BLN11,
                    'MON_AMT_BLN12' => $value->MON_AMT_BLN12,
                    'MON_AMT_SUM' => $value->MON_AMT_SUM,
                    'CHR_CREATE_BY' => $CHR_CREATE_BY,
                    'CHR_CREATE_DATE' => $CHR_CREATE_DATE,
                    'CHR_CREATE_TIME' => $CHR_CREATE_TIME
                );
            $this->budget_capex_m->save($data);
        }

        //GET DETAIL BUDGET
        $data['detail_confirm'] = $this->budget_capex_m->get_detail_confirm_capex($INT_ID_FISCAL_YEAR, $CHR_BUDGET_TYPE, $INT_DIV, $INT_DEPT, $INT_SECT);
        //GET SUM AMOUNT
        $data['SUM_AMT'] = $this->budget_capex_m->get_sum_amt_confirm_capex($INT_ID_FISCAL_YEAR, $CHR_BUDGET_TYPE, $INT_DIV, $INT_DEPT, $INT_SECT);

        redirect("budget/budget_capex_c/index/1/$INT_ID_FISCAL_YEAR/$INT_ID_BUDGET_TYPE/$INT_DIV/$INT_DEPT/$INT_SECT/$CHR_BUDGET_TYPE", "REFRESH");
        $this->load->view($this->layout, $data);
    }
    
    function update_budget_capex() {
        $user_session = $this->session->all_userdata();
        $date = date('Ymd');
        $time = date('His');
        $username = $user_session['USERNAME'];
        
        $CHR_NO_BUDGET = $this->input->post("CHR_NO_BUDGET");
        $CHR_NO_BUDGET_EDIT = str_replace('/', '%3C', $CHR_NO_BUDGET);
        $count_month = 0;
        $new_qty = 0;
        for($i = 4; $i <= 15; $i++){
            $qty = $this->input->post("INT_QTY_".$i);  
            $new_qty = $new_qty + $qty;
            if($qty > 0){
                $count_month = $count_month + 1;
                if($count_month > 1){                    
                    redirect("budget/budget_capex_c/edit_budget_capex/1/$CHR_NO_BUDGET_EDIT", "REFRESH");
                } 
            }
            
            if($new_qty > 1){
                redirect("budget/budget_capex_c/edit_budget_capex/1/$CHR_NO_BUDGET_EDIT", "REFRESH");
            }
        }
        
        $INT_ID_FISCAL_YEAR = $this->input->post("INT_ID_FISCAL_YEAR");
        $INT_DIV = $user_session['DIVISION'];
        $INT_DEPT = $user_session['DEPT'];
        $INT_GROUP_DEPT = $user_session['GROUPDEPT'];
        $INT_SECT = $this->input->post("INT_ID_SECTION");
        $INT_COSTCENTER = $this->input->post("INT_ID_COST_CENTER");
        
        $INT_ID_BUDGET_TYPE = 1;
        $CHR_BUDGET_TYPE = 'CAPEX';
        $CHR_BUDGET_TYPE_DESC = $this->budgettype_m->get_desc_budgettype($INT_ID_BUDGET_TYPE);
        $INT_ID_BUDGET_CATEGORY = $this->input->post("CHR_BUDGET_CATEGORY");
        $CHR_BUDGET_CATEGORY = $this->budgetcategory_m->get_init_budgetcategory($INT_ID_BUDGET_CATEGORY);
        $CHR_BUDGET_CATEGORY_DESC = $this->budgetcategory_m->get_desc_budgetcategory($INT_ID_BUDGET_CATEGORY);
        $INT_ID_BUDGET_SUB_CATEGORY = $this->input->post("CHR_BUDGET_SUB_CATEGORY");
        $CHR_BUDGET_SUB_CATEGORY = $this->budgetsubcategory_m->get_init_budgetsubcategory($INT_ID_BUDGET_SUB_CATEGORY);
        $CHR_BUDGET_SUB_CATEGORY_DESC = $this->budgetsubcategory_m->get_desc_budgetsubcategory($INT_ID_BUDGET_SUB_CATEGORY);
        $CHR_CODE_CATEGORY_A3 = '-';
        $CHR_CODE_CATEGORY_A3_DESC = '-';
        $CHR_BUDGET_DESC = $this->input->post("CHR_BUDGET_DESC");
        
        $CHR_PURPOSE = $this->input->post("CHR_PURPOSE");
        $CHR_PROJECT = $this->input->post("CHR_PROJECT");
        
        $list_project = '';
        if($CHR_PROJECT != NULL || $CHR_PROJECT != '' || $CHR_PROJECT != 0){ 
            $no = 1;
            for($i = 0; $i < count($CHR_PROJECT); $i++){
                if($no == count($CHR_PROJECT)){
                    $list_project .= trim($CHR_PROJECT[$i]);
                } else {
                    $list_project .= trim($CHR_PROJECT[$i]) . '#';
                }
                $no++;
            }
        } else {
            $list_project = '-'; 
        }
        
        $CHR_PRODUCT = $this->input->post("CHR_PRODUCT");
        $list_product = '';
        if($CHR_PRODUCT != NULL || $CHR_PRODUCT != '' || $CHR_PRODUCT != 0){ 
            $no = 1;
            for($i = 0; $i < count($CHR_PRODUCT); $i++){
                if($no == count($CHR_PRODUCT)){
                    $list_product .= trim($CHR_PRODUCT[$i]);
                } else {
                    $list_product .= trim($CHR_PRODUCT[$i]) . '#';
                }
                $no++;
            }
        } else {
            $list_product = '-'; 
        }
        
        $CHR_STATUS = $this->input->post("CHR_STATUS_BUDGET");
        $CHR_OWNER = $this->input->post("CHR_OWNER");
        $CHR_SUPPLIER = $this->input->post("CHR_SUPPLIER");
        $CHR_UNIT = $this->input->post("CHR_UNIT");
        $CHR_DEPRECIATION = $this->input->post("CHR_DEPC_YEAR") . $this->input->post("CHR_DEPC_MONTH");
        $INT_ID_ORG_CURR = $this->input->post("CHR_CURRENCY");
        $CHR_CURRENCY = $this->currency_m->get_data_currency($INT_ID_ORG_CURR)->row()->CHR_CURRENCY;
        $RATE_CURRENCY = $this->input->post("RATE_CURRENCY");
        $INT_FLG_CIP = $this->input->post("INT_FLG_CIP");
        
        $PRICE_ORI = $this->input->post("PRICE_PER_UNIT_ORI");
        $PRICE_IDR = $this->input->post("PRICE_PER_UNIT_IDR");
        $PRICE_INK = $this->input->post("PRICE_INKLARING");
        $PRICE_ENG = $this->input->post("PRICE_ENGFEE");
        $PRICE_IMP = $this->input->post("PRICE_IMPORT_DUTY");
        $TOT_PRICE = $this->input->post("TOT_PRICE_IDR");
        
        $QTY_BLN04 = $this->input->post("INT_QTY_4");
        $QTY_BLN05 = $this->input->post("INT_QTY_5");
        $QTY_BLN06 = $this->input->post("INT_QTY_6");
        $QTY_BLN07 = $this->input->post("INT_QTY_7");
        $QTY_BLN08 = $this->input->post("INT_QTY_8");
        $QTY_BLN09 = $this->input->post("INT_QTY_9");
        $QTY_BLN10 = $this->input->post("INT_QTY_10");
        $QTY_BLN11 = $this->input->post("INT_QTY_11");
        $QTY_BLN12 = $this->input->post("INT_QTY_12");
        $QTY_BLN01 = $this->input->post("INT_QTY_13");
        $QTY_BLN02 = $this->input->post("INT_QTY_14");
        $QTY_BLN03 = $this->input->post("INT_QTY_15");
        
        $QTY_SUM = $this->input->post("TOT_QTY_ALL");
            
        $data = array(
                'INT_ID_FISCAL_YEAR' => $INT_ID_FISCAL_YEAR,
                'CHR_BUDGET_TYPE' => $CHR_BUDGET_TYPE,
                'CHR_BUDGET_TYPE_DESC' => $CHR_BUDGET_TYPE_DESC,
                'CHR_BUDGET_SUB_CATEGORY' => $CHR_BUDGET_SUB_CATEGORY,
                'CHR_BUDGET_SUB_CATEGORY_DESC' => $CHR_BUDGET_SUB_CATEGORY_DESC,
                'CHR_BUDGET_CATEGORY' => $CHR_BUDGET_CATEGORY,
                'CHR_BUDGET_CATEGORY_DESC' => $CHR_BUDGET_CATEGORY_DESC,
                'CHR_CODE_CATEGORY_A3' => $CHR_CODE_CATEGORY_A3,
                'CHR_CODE_CATEGORY_A3_DESC' => $CHR_CODE_CATEGORY_A3_DESC, 
                'INT_DIV' => $INT_DIV,
                'INT_GROUP_DEPT' => $INT_GROUP_DEPT,
                'INT_DEPT' => $INT_DEPT,
                'INT_SECT' => $INT_SECT,
                'INT_COST_CENTER' => $INT_COSTCENTER,
                'CHR_PURPOSE' => $CHR_PURPOSE,
                'CHR_PROJECT' => $list_project,
                'CHR_PRODUCT' => $list_product,
                'INT_FLG_CIP' => $INT_FLG_CIP,
                'CHR_BUDGET_DESC' => $CHR_BUDGET_DESC,
                'CHR_STATUS_BUDGET' => $CHR_STATUS,
                'CHR_RUN_DEPRECIATION' => $CHR_DEPRECIATION,
                'CHR_SUPPLIER_LOCATION' => $CHR_SUPPLIER,
                'CHR_DIE_OWNER' => $CHR_OWNER,
                'CHR_SATUAN' => $CHR_UNIT,
                'CHR_ORG_CURR' => $CHR_CURRENCY,
                'FLT_RATE_CURR' => $RATE_CURRENCY,
                'MON_PRICE_ORI' => $PRICE_ORI,
                'MON_PRICE_IDR' => $PRICE_IDR,
                'MON_INKLARING' => $PRICE_INK,
                'MON_ENGFEE' => $PRICE_ENG,
                'MON_IMPORT_DUTY' => $PRICE_IMP,
                'INT_QTY_BLN01' => $QTY_BLN01,
                'INT_QTY_BLN02' => $QTY_BLN02,
                'INT_QTY_BLN03' => $QTY_BLN03,
                'INT_QTY_BLN04' => $QTY_BLN04,
                'INT_QTY_BLN05' => $QTY_BLN05,
                'INT_QTY_BLN06' => $QTY_BLN06,
                'INT_QTY_BLN07' => $QTY_BLN07,
                'INT_QTY_BLN08' => $QTY_BLN08,
                'INT_QTY_BLN09' => $QTY_BLN09,
                'INT_QTY_BLN10' => $QTY_BLN10,
                'INT_QTY_BLN11' => $QTY_BLN11,
                'INT_QTY_BLN12' => $QTY_BLN12,
                'INT_QTY_SUM' => $QTY_SUM,
                'MON_AMT_BLN01' => $TOT_PRICE * $QTY_BLN01,
                'MON_AMT_BLN02' => $TOT_PRICE * $QTY_BLN02,
                'MON_AMT_BLN03' => $TOT_PRICE * $QTY_BLN03,
                'MON_AMT_BLN04' => $TOT_PRICE * $QTY_BLN04,
                'MON_AMT_BLN05' => $TOT_PRICE * $QTY_BLN05,
                'MON_AMT_BLN06' => $TOT_PRICE * $QTY_BLN06,
                'MON_AMT_BLN07' => $TOT_PRICE * $QTY_BLN07,
                'MON_AMT_BLN08' => $TOT_PRICE * $QTY_BLN08,
                'MON_AMT_BLN09' => $TOT_PRICE * $QTY_BLN09,
                'MON_AMT_BLN10' => $TOT_PRICE * $QTY_BLN10,
                'MON_AMT_BLN11' => $TOT_PRICE * $QTY_BLN11,
                'MON_AMT_BLN12' => $TOT_PRICE * $QTY_BLN12,
                'MON_AMT_SUM' => $TOT_PRICE * $QTY_SUM,
                'CHR_MODI_DATE' => $date,
                'CHR_MODI_TIME' => $time,
                'CHR_MODI_BY' => $username
            );
        //SAVE TO DATABASE
        $this->budget_capex_m->update_capex($data, $CHR_NO_BUDGET);
            
        //GET DETAIL BUDGET
        $data['detail_confirm'] = $this->budget_capex_m->get_detail_confirm_capex($INT_ID_FISCAL_YEAR, $CHR_BUDGET_TYPE, $INT_DIV, $INT_DEPT, $INT_SECT);
        //GET SUM AMOUNT
        $data['SUM_AMT'] = $this->budget_capex_m->get_sum_amt_confirm_capex($INT_ID_FISCAL_YEAR, $CHR_BUDGET_TYPE, $INT_DIV, $INT_DEPT, $INT_SECT);

        redirect("budget/budget_capex_c/index/1/$INT_ID_FISCAL_YEAR/$INT_ID_BUDGET_TYPE/$INT_DIV/$INT_DEPT/$INT_SECT/$CHR_BUDGET_TYPE", "REFRESH");
        $this->load->view($this->layout, $data);
    }
    
    function delete_budget_capex($CHR_NO_BUDGET = NULL) {
        $user_session = $this->session->all_userdata();
        $CHR_MODI_BY = $user_session['USERNAME'];
        $CHR_MODI_DATE = date("Ymd");
        $CHR_MODI_TIME = date("his");
        $CHR_NO_BUDGET = str_replace('%3C', '/', $CHR_NO_BUDGET);
//        print($CHR_NO_BUDGET);
//        exit();

        //CHECK BUDGET NUMBER
        //GET BUDGET NUMBER
        $detail_budget = $this->budget_capex_m->get_capex_by_no_budget($CHR_NO_BUDGET);
        $INT_ID_FISCAL_YEAR = $detail_budget->INT_ID_FISCAL_YEAR;
        $INT_ID_BUDGET_TYPE = 1; //CAPEX
        $CHR_BUDGET_TYPE = 'CAPEX';
        $INT_DIV = $detail_budget->INT_DIV;
        $INT_DEPT = $detail_budget->INT_DEPT;
        $INT_SECT = $detail_budget->INT_SECT;

        //UPDATE DATA FROM TABLE WORK TO TABLE TRANSACTION
        $this->db->query("UPDATE CPL.TT_BUDGET_CAPEX SET BIT_FLG_DEL = '1', CHR_MODI_DATE = '$CHR_MODI_DATE', CHR_MODI_TIME = '$CHR_MODI_TIME', CHR_MODI_BY = '$CHR_MODI_BY' WHERE CHR_NO_BUDGET = '$CHR_NO_BUDGET'");

        //GET DETAIL BUDGET
        //$data['detail_confirm'] = $this->budget_capex_m->get_detail_confirm_capex($INT_ID_FISCAL_YEAR, $CHR_BUDGET_TYPE, $INT_DIV, $INT_DEPT, $INT_SECT);
        //GET SUM AMOUNT
        //$data['SUM_AMT'] = $this->budget_capex_m->get_sum_amt_confirm_capex($INT_ID_FISCAL_YEAR, $CHR_BUDGET_TYPE, $INT_DIV, $INT_DEPT, $INT_SECT);

        redirect("budget/budget_capex_c/refresh_table_page/1/$INT_ID_FISCAL_YEAR/$INT_ID_BUDGET_TYPE/$INT_DIV/$INT_DEPT/$INT_SECT/$CHR_BUDGET_TYPE", "REFRESH");
        //$this->load->view($this->layout, $data);
    }
    
    function refresh_table() {

        $INT_ID_FISCAL_YEAR = $this->input->post("INT_ID_FISCAL_YEAR");
        $INT_BUDGET_TYPE = $this->input->post("CHR_BUDGET_TYPE");
        $budget_desc = $this->budgettype_m->get_budget_type($INT_BUDGET_TYPE);
        $CHR_BUDGET_TYPE = $budget_desc->CHR_BUDGET_TYPE;
        $INT_DEPT = $this->input->post("INT_DEPT");
        $INT_SECT = $this->input->post("INT_SECT");
        $get_gm_div = $this->dept_m->get_gm_div($INT_DEPT)->row();
        $INT_DIV = $get_gm_div->INT_ID_DIVISION;
        $url_iframe = site_url("budget/budget_capex_c/refresh_table_page/1/$INT_ID_FISCAL_YEAR/$INT_BUDGET_TYPE/$INT_DIV/$INT_DEPT/$INT_SECT/$CHR_BUDGET_TYPE");
        $url_export_excel = site_url("budget/budget_capex_c/download_excel/$INT_ID_FISCAL_YEAR/$INT_BUDGET_TYPE/$INT_DIV/$INT_DEPT/$INT_SECT/$CHR_BUDGET_TYPE");

        $data = array(
            'url_iframe' => $url_iframe,
            'url_export_excel' => $url_export_excel
        );

//Either you can print value or you can send value to database
        echo json_encode($data);

        //echo site_url("budget/budget_dimat_c/refresh_table_page/1/$INT_ID_FISCAL_YEAR/$INT_BUDGET_TYPE/$INT_DIV/$INT_DEPT/$INT_SECT/$CHR_BUDGET_TYPE");
    }

    function refresh_table_page($msg = null, $INT_ID_FISCAL_YEAR = null, $INT_ID_BUDGET_TYPE = null, $INT_DIV = null, $INT_DEPT = null, $INT_SECT = null, $CHR_BUDGET_TYPE = null) {
        $user_session = $this->session->all_userdata();
        $role = $user_session['ROLE'];

        $data['INT_ID_FISCAL_YEAR'] = $INT_ID_FISCAL_YEAR;
        $data['INT_ID_BUDGET_TYPE'] = $INT_ID_BUDGET_TYPE;
        $data['INT_DIV'] = $INT_DIV;
        $data['INT_DEPT'] = $INT_DEPT;
        $data['INT_SECT'] = $INT_SECT;
        $data['CHR_BUDGET_TYPE'] = $CHR_BUDGET_TYPE;
        $data['role'] = $role;
        
//GET DETAIL BUDGET
        if ($CHR_BUDGET_TYPE <> null) {
//            if($role == 2 && $INT_DIV == 3){
//                $data['detail_confirm'] = $this->budget_capex_m->get_detail_capex_cpl($INT_ID_FISCAL_YEAR, $CHR_BUDGET_TYPE, $INT_DIV, $INT_DEPT, $INT_SECT);
//                $data['detail_confirm_sum'] = $this->budget_capex_m->get_sum_capex_cpl($INT_ID_FISCAL_YEAR, $CHR_BUDGET_TYPE, $INT_DIV, $INT_DEPT, $INT_SECT);
//            } else {
                $data['detail_confirm'] = $this->budget_capex_m->get_detail_capex($INT_ID_FISCAL_YEAR, $CHR_BUDGET_TYPE, $INT_DIV, $INT_DEPT, $INT_SECT);
                $data['detail_confirm_sum'] = $this->budget_capex_m->get_sum_capex($INT_ID_FISCAL_YEAR, $CHR_BUDGET_TYPE, $INT_DIV, $INT_DEPT, $INT_SECT);
//            }            
        } else {
            $data['detail_confirm'] = null;
            $data['detail_confirm_sum'] = null;
        }

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(19);
        $data['news'] = $this->news_m->get_news();
        $data['msg'] = $msg;

        $data['title'] = 'Create Budget Capital Expenditure';

        $data['subcontent'] = NULL;
        $data['content'] = 'budget/budget_capex/refresh_budget_capex_v';
        
        //$data['budget_type'] = $this->budgettype_m->get_budget_type_expense_by_amount();
        $kode_dept = $user_session['DEPT'];
        $data['kode_dept'] = $kode_dept;

        $data['data_budget_type'] = $this->budgettype_m->get_budgettype();
        $this->load->view($this->layout_blank, $data);
    }
    
    function download_excel_for_approve($INT_ID_FISCAL_YEAR = null, $INT_DIV = null, $INT_GROUP = null, $INT_DEPT = null) {
        $row = 8;
        $INT_ID_BUDGET_TYPE = 48;
        $detail_confirm = $this->budget_dimat_m->get_summary_dimat($INT_ID_FISCAL_YEAR, $INT_DIV, $INT_GROUP, $INT_DEPT);
        $budget_desc = $this->budgettype_m->get_budget_type($INT_ID_BUDGET_TYPE);
        $budget_desc = strtoupper(trim($budget_desc->CHR_BUDGET_TYPE_DESC));

        $CHR_DEPT = trim($this->dept_m->get_name_dept($INT_DEPT));
        $CHR_DEPT_DESC = trim($this->dept_m->get_desc_dept($INT_DEPT));
        $CHR_FISCAL_YEAR_DESC = trim($this->fiscal_m->select_fiscal_year($INT_ID_FISCAL_YEAR));

        $this->load->library('excel');
        $objReader = PHPExcel_IOFactory::createReader('Excel5');
        // Create new PHPExcel object

        $objPHPExcel = $objReader->load("assets/template/budget/report/Template_Approval_Direct_Material.xls");

        $seq = 1;
        $objPHPExcel->getActiveSheet()->setCellValue("B2", "MASTER BUDGET : " . $budget_desc . " TAHUN " . $CHR_FISCAL_YEAR_DESC);
        $objPHPExcel->getActiveSheet()->setCellValue("B3", "DEPARTMENT : " . $CHR_DEPT . " - " . $CHR_DEPT_DESC);
        foreach ($detail_confirm as $value) {
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

            $objPHPExcel->getActiveSheet()->setCellValue("B$row", "$seq");
            $objPHPExcel->getActiveSheet()->setCellValue("C$row", "$CHR_CODE_CATEGORY_A3_DESC");
            $objPHPExcel->getActiveSheet()->setCellValue("D$row", "$CHR_BUDGET_CATEGORY_DESC");
            $objPHPExcel->getActiveSheet()->setCellValue("E$row", "$CHR_BUDGET_SUB_CATEGORY_DESC");
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", "$MON_AMT_BLN04");
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", "$MON_AMT_BLN05");
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", "$MON_AMT_BLN06");
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", "$MON_AMT_BLN07");
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", "$MON_AMT_BLN08");
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", "$MON_AMT_BLN09");
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", "$MON_AMT_BLN10");
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", "$MON_AMT_BLN11");
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", "$MON_AMT_BLN12");
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", "$MON_AMT_BLN01");
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", "$MON_AMT_BLN02");
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", "$MON_AMT_BLN03");
            $objPHPExcel->getActiveSheet()->setCellValue("R$row", "$MON_AMT_SUM");

            $seq++;
            $row++;
        }

        $objPHPExcel->getActiveSheet()->getStyle("B8:R$row")->applyFromArray(array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        ));

        $row++;
        $row_min = $row - 1;
        $objPHPExcel->getActiveSheet()->setCellValue("F$row", "=SUM(F8:F$row_min)");
        $objPHPExcel->getActiveSheet()->setCellValue("G$row", "=SUM(G8:G$row_min)");
        $objPHPExcel->getActiveSheet()->setCellValue("H$row", "=SUM(H8:H$row_min)");
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
        $objPHPExcel->getActiveSheet()->getStyle("B8:R$row")->applyFromArray(array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            ),
        ));
        $objPHPExcel->getActiveSheet()->mergeCells("B$row:E$row");
        $objPHPExcel->getActiveSheet()->setCellValue("B$row", "TOTAL");
        $objPHPExcel->getActiveSheet()->getStyle("B$row:R$row")->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('#CCCCCC');
        $objPHPExcel->getActiveSheet()->getStyle("B$row:R$row")->applyFromArray(array(
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
        $objDrawing->setCoordinates("O$row");
        $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());

        ob_end_clean();
        $filename = "$CHR_FISCAL_YEAR_DESC - $budget_desc - $CHR_DEPT.xls";
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . trim($filename) . '"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->setIncludeCharts(TRUE);
        $objWriter->save('php://output');
    }
    
    function download_excel($INT_ID_FISCAL_YEAR = null, $INT_ID_BUDGET_TYPE = null, $INT_DIV = null, $INT_DEPT = null, $INT_SECT = null, $CHR_BUDGET_TYPE = null) {
        $user_session = $this->session->all_userdata();
        $role = $user_session['ROLE'];
        $row = 7;

        if ($CHR_BUDGET_TYPE <> null) {
//            if($role == 2 && $INT_DIV == 3){
//                $detail_confirm = $this->budget_capex_m->get_detail_capex_dept_cpl($INT_ID_FISCAL_YEAR, $CHR_BUDGET_TYPE, $INT_DIV, $INT_DEPT, $INT_SECT);
//                $detail_confirm_sum = $this->budget_capex_m->get_sum_capex_dept_cpl($INT_ID_FISCAL_YEAR, $CHR_BUDGET_TYPE, $INT_DIV, $INT_DEPT, $INT_SECT);
//            } else {
                if($role != 1 && $role != 2 && $role != 3 && $role != 4 && $role != 5 && $role != 39 && $role != 45){
                    $detail_confirm = $this->budget_capex_m->get_budget_capex_by_dept($INT_ID_FISCAL_YEAR, $CHR_BUDGET_TYPE, $INT_DIV, $INT_DEPT);
                    // $detail_confirm = $this->budget_capex_m->get_detail_capex($INT_ID_FISCAL_YEAR, $CHR_BUDGET_TYPE, $INT_DIV, $INT_DEPT, $INT_SECT);
                    $detail_confirm_sum = $this->budget_capex_m->get_sum_capex($INT_ID_FISCAL_YEAR, $CHR_BUDGET_TYPE, $INT_DIV, $INT_DEPT, $INT_SECT);
                } else {
                    $detail_confirm = $this->budget_capex_m->get_budget_capex_by_section($INT_ID_FISCAL_YEAR, $CHR_BUDGET_TYPE, $INT_DIV, $INT_DEPT, $INT_SECT);
                    // $detail_confirm = $this->budget_capex_m->get_detail_capex_dept($INT_ID_FISCAL_YEAR, $CHR_BUDGET_TYPE, $INT_DIV, $INT_DEPT, $INT_SECT);
                    $detail_confirm_sum = $this->budget_capex_m->get_sum_capex_dept($INT_ID_FISCAL_YEAR, $CHR_BUDGET_TYPE, $INT_DIV, $INT_DEPT, $INT_SECT);
                }
                
//            }
            
            $budget_desc = $this->budgettype_m->get_budget_type($INT_ID_BUDGET_TYPE);
            $budget_desc = strtoupper(trim($budget_desc->CHR_BUDGET_TYPE_DESC));

            $CHR_DEPT = trim($this->dept_m->get_name_dept($INT_DEPT));
            $CHR_DEPT_DESC = trim($this->dept_m->get_desc_dept($INT_DEPT));
            $CHR_FISCAL_YEAR_DESC = trim($this->fiscal_m->select_fiscal_year($INT_ID_FISCAL_YEAR));

            $this->load->library('excel');
            $objReader = PHPExcel_IOFactory::createReader('Excel5');
            // Create new PHPExcel object

            $objPHPExcel = $objReader->load("assets/template/budget/report/Template_Report_Capex.xls");

            $seq = 1;
            $objPHPExcel->getActiveSheet()->setCellValue("B2", "MASTER BUDGET : " . $budget_desc . " TAHUN " . $CHR_FISCAL_YEAR_DESC);
            $objPHPExcel->getActiveSheet()->setCellValue("B3", "DEPARTMENT : " . $CHR_DEPT . " - " . $CHR_DEPT_DESC);
            foreach ($detail_confirm as $value) {
                $CHR_SECTION_DESC = $this->section_m->get_desc_section($INT_SECT);
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
            $filename = "$CHR_FISCAL_YEAR_DESC - $budget_desc - $CHR_DEPT.xls";
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="' . trim($filename) . '"');
            header('Cache-Control: max-age=0');

            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->setIncludeCharts(TRUE);
            $objWriter->save('php://output');
        } else {
            $data['detail_confirm'] = null;
            $data['detail_confirm_sum'] = null;
        }
    }

    function get_project_by_purpose(){
        $purpose = trim($this->input->post('chr_purpose'));

        $flg_new = 0;
        if($purpose == 'PCA02'){
            $flg_new = 1;
        }
        $data_project = $this->budget_capex_m->get_project_by_purpose($flg_new);

        $data = "";
        // $data .= "<select name='CHR_PROJECT[]' multiple id='e1' class='form-control' style='width:300px'>";
       
        foreach ($data_project as $isi) {
            $data .=  "<option value='" . $isi->CHR_PROJECT ."'>". $isi->CHR_PROJECT . " - " . $isi->CHR_PROJECT_DESC . "</option>";
        }
        // $data .= "</select>";     

        $json['data'] = $data;

        if ('IS_AJAX') {
            echo json_encode($json);
        }

    }

}

?>