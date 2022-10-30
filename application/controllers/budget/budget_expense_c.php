<?php

class budget_expense_c extends CI_Controller {

    private $layout = '/template/head';
    private $layout_blank = '/template/head_blank';
    private $back_to_upload = 'budget/budget_expense_c/create_expense/';
    private $back_to_manage = 'budget/budget_expense_c/index/';

    public function __construct() {
        parent::__construct();
        $this->load->model('budget/dept_expense_m');
        $this->load->model('budget/budget_expense_m');
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
        $this->load->model('budget/fiscal_m');
        $this->load->model('basis/user_m');
    }

    function index($msg = NULL) {
        $this->role_module_m->authorization('19');
        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Creating success. </strong> The data is successfully created. </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Updating success. </strong> The data is successfully updated. </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Deleting success. </strong> The data is successfully deleted. </div >";
        } elseif ($msg == 4) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Creating failed. </strong> No data amount on this fiscal year recorded. </div >";
        } elseif ($msg == 5) {
            $msg = "<div class = 'alert alert-success'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Commiting success. </strong> The data is successfully updated. </div >";
        } elseif ($msg == 6) {
            $msg = "<div class = 'alert alert-success'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Budget Expense was Approved. </strong> The data was successfully updated. </div >";
        } elseif ($msg == 7) {
            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Budget Expense was Rejected. </strong> The data was successfully updated. </div >";
        } elseif ($msg == 8) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Budget Expense was Unlocked. </strong> The data was successfully updated. </div >";
        } elseif ($msg == 12) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Executing error!</strong> Something is not right. </div >";
        } elseif ($msg == 13) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Executing failed!</strong> No data was selected.</div >";
        } elseif ($msg == 14) {
            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Access denied!</strong> Unbudget Expense cannot be ceated on the Planning session.</div >";
        } elseif ($msg == 15) {
            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Access denied!</strong> Update budget is not allowed.</div >";
        } 

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(19);
        $data['news'] = $this->news_m->get_news();

        $data['title'] = 'Manage Budget Planning Expense';
        $data['msg'] = $msg;
        $session = $this->session->all_userdata();
        $fiscal = $this->fiscal_m->get_id_fiscal_this_year();
        $user_session = $this->session->all_userdata();
        $user = $this->user_m->get_user_org($user_session['NPK']);
        $periode = date("Ym");
        $data['unbudget'] = NULL;
        switch ($session['ROLE']) {
            case '1':
                $data['data'] = $this->budget_expense_m->get_all_budget_expense_on_plan_v($fiscal, $user->INT_ID_COMPANY);
                $data['content'] = 'budget/budget_expense/manage_budget_expense_v';
                $data['header'] = $this->budget_expense_m->get_all_budget_expense_header($fiscal, $user->INT_ID_COMPANY);
                $data['org'] = $user;
                break;
            case '2':
                $data['data'] = $this->budget_expense_m->get_all_budget_expense_on_plan_v($fiscal, $user->INT_ID_COMPANY);
                $data['content'] = 'budget/budget_expense/manage_budget_expense_v';
                $data['header'] = $this->budget_expense_m->get_all_budget_expense_header($fiscal, $user->INT_ID_COMPANY);
                $data['org'] = $user;
                break;
            case '3':
                $this->prepare_approve_expense();
                break;
            case '4':
                $this->prepare_approve_expense();
                break;
            case '5':
                $this->prepare_approve_expense();
                break;
            case '6':
                $data['unbudget'] = $this->budget_expense_m->get_unbudget_status($fiscal, $user->INT_ID_SECTION);
                $data['revise'] = $this->budget_expense_m->get_revise_status($fiscal, $user->INT_ID_SECTION);
                $data['commit'] = $this->budget_expense_m->get_commited_status($fiscal, $user->INT_ID_SECTION);
                $data['data'] = $this->budget_expense_m->get_all_budget_expense($fiscal, $user->INT_ID_SECTION);
                $data['header'] = $this->budget_expense_m->get_all_budget_expense_header($fiscal, $user->INT_ID_SECTION);
                $data['org'] = $user;
                $data['content'] = 'budget/budget_expense/manage_budget_expense_by_section_v';
                break;
            default:
                redirect('fail_c/auth');
                break;
        }
        $this->load->view($this->layout, $data);
    }

    function prepare_approve_unbudget_expense($msg = null) {
        $this->role_module_m->authorization('49');
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(49);
        $data['news'] = $this->news_m->get_news();

        $data['title'] = 'Manage Unbudget Expense';
        $data['msg'] = $msg;

        $session = $this->session->all_userdata();
        $fiscal = $this->fiscal_m->get_id_fiscal_this_year();
        $user_session = $this->session->all_userdata();
        $user = $this->user_m->get_user_org($user_session['NPK']);
        switch ($session['ROLE']) {
            case '1':
                $data['data'] = $this->budget_expense_m->get_all_budget_expense($fiscal, $user->INT_ID_COMPANY);
                $data['content'] = 'budget/budget_expense/manage_budget_expense_v';
                break;
            case '2':
                $data['org'] = $user;
                $data['commit'] = $this->budget_expense_m->get_commited_status($fiscal, $user->INT_ID_COMPANY);
                $data['data'] = $this->budget_expense_m->get_all_budget_expense($fiscal, $user->INT_ID_COMPANY);
                $data['content'] = 'budget/budget_expense/manage_budget_expense_by_admin_v';
                break;
            case '3':
                $data['commit'] = $this->budget_expense_m->get_commited_status($fiscal, $user->INT_ID_DIVISION);
                $data['org'] = $user;
                $data['data'] = $this->budget_expense_m->get_all_budget_expense($fiscal, $user->INT_ID_DIVISION);
                $data['content'] = 'budget/budget_expense/manage_budget_expense_by_div_v';
                break;
            case '4':
                $data['commit'] = $this->budget_expense_m->get_commited_status($fiscal, $user->INT_ID_GROUP_DEPT);
                $data['org'] = $user;
                $data['data'] = $this->budget_expense_m->get_all_budget_expense($fiscal, $user->INT_ID_GROUP_DEPT);


                $data['content'] = 'budget/budget_expense/manage_budget_expense_by_group_dept_v';
                break;
            case '5':
                $data['commit'] = $this->budget_expense_m->get_commited_status($fiscal, $user->INT_ID_DEPT);
                $data['org'] = $user;
                $data['data'] = $this->budget_expense_m->get_all_budget_expense($fiscal, $user->INT_ID_DEPT);

                $data['content'] = 'budget/budget_expense/manage_budget_expense_by_dept_v';

                break;
            default:
                break;
        }

        $this->load->view($this->layout, $data);
    }

    function prepare_approve_expense($msg = null, $INT_ID_FISCAL_YEAR = null, $INT_DIV = null, $INT_GROUP = null, $INT_DEPT = null, $INT_SECT = null) {
        $user_session = $this->session->all_userdata();
        if ($msg == 5) {
            $msg = "<div class = 'alert alert-success'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Commiting success. </strong> The data is successfully updated. </div >";
        } elseif ($msg == 6) {
            $msg = "<div class = 'alert alert-success'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Budget Expense was Approved. </strong> The data was successfully updated. </div >";
        } elseif ($msg == 7) {
            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Budget Expense was Unapproved. </strong> The data was successfully updated. </div >";
        } elseif ($msg == 8) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Budget Expense was Unlocked. </strong> The data was successfully updated. </div >";
        } elseif ($msg == 12) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Executing error!</strong> Something is not right. </div >";
        } elseif ($msg == 13) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Executing failed!</strong> No data was selected.</div >";
        } elseif ($msg == 14) {
            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Access denied!</strong> Unbudget Expense cannot be ceated on the Planning session.</div >";
        }

        $data['INT_ID_FISCAL_YEAR'] = $INT_ID_FISCAL_YEAR;
        $data['INT_DIV'] = $INT_DIV;
        $data['INT_GROUP'] = $INT_GROUP;
        $data['INT_DEPT'] = $INT_DEPT;
        $data['INT_SECT'] = $INT_SECT;

//GET SUMMARY BUDGET
        if ($INT_ID_FISCAL_YEAR <> null && $INT_DIV <> null) {
            $data['url_page'] = site_url("budget/budget_expense_c/refresh_detail_table_page/1/$INT_ID_FISCAL_YEAR/$INT_DIV/$INT_GROUP/$INT_DEPT/$INT_SECT");
            $data['url_page2'] = site_url("budget/budget_expense_c/refresh_summary_table_page/1/$INT_ID_FISCAL_YEAR/$INT_DIV/$INT_GROUP/$INT_DEPT/$INT_SECT");
        } else {
            $data['url_page'] = "";
            $data['url_page2'] = "";
        }

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(43);
        $data['news'] = $this->news_m->get_news();
        $data['data_fiscal'] = $this->fiscal_m->get_all_fiscal();

        $data['title'] = 'Approval for Planning Expense';
        $data['msg'] = $msg;

        $session = $this->session->all_userdata();
        $user_session = $this->session->all_userdata();
        //$user = $this->user_m->get_user_org($user_session['NPK']);

        $data['role'] = $user_session['ROLE'];
        $kode_div = $user_session['DIVISION'];
        $kode_group = $user_session['GROUPDEPT'];
        $kode_dept = $user_session['DEPT'];

        $data['content'] = 'budget/budget_expense/approval_budget_expense_v';

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
        } else if ($user_session['ROLE'] == 5 || $user_session['ROLE'] == 48 || $user_session['ROLE'] == 49 || $user_session['ROLE'] == 50 || $user_session['ROLE'] == 51 || $user_session['ROLE'] == 52 || $user_session['ROLE'] == 39 || $user_session['ROLE'] == 45 || $user_session['ROLE'] == 70) { //============== Manager            
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

        $url_iframe = site_url("budget/budget_expense_c/refresh_detail_table_page/1/$INT_ID_FISCAL_YEAR/$INT_DIV/$INT_GROUP/$INT_DEPT/$INT_SECT");
        $url_export_excel = site_url("budget/budget_expense_c/download_excel_for_approve/$INT_ID_FISCAL_YEAR/$INT_DIV/$INT_GROUP/$INT_DEPT");

        $data = array(
            'url_iframe' => $url_iframe,
            'url_export_excel' => $url_export_excel
        );

//Either you can print value or you can send value to database
        echo json_encode($data);

        //echo site_url("budget/budget_expense_c/refresh_detail_table_page/1/$INT_ID_FISCAL_YEAR/$INT_DIV/$INT_GROUP/$INT_DEPT/$INT_SECT");
    }

    function refresh_detail_table_page($msg = null, $INT_ID_FISCAL_YEAR = null, $INT_DIV = null, $INT_GROUP = null, $INT_DEPT = null, $INT_SECT = null) {
        $user_session = $this->session->all_userdata();

        $data['INT_ID_FISCAL_YEAR'] = $INT_ID_FISCAL_YEAR;
        $data['INT_DIV'] = $INT_DIV;
        $data['INT_GROUP'] = $INT_GROUP;
        $data['INT_DEPT'] = $INT_DEPT;
        $data['INT_SECT'] = $INT_SECT;

//        print_r($data['INT_SECT']);
//        exit();

        $data['DIV'] = $this->division_m->get_name_division($INT_DIV);
        $data['GROUP'] = $this->groupdept_m->get_name_groupdept($INT_GROUP);
        $data['DEPT'] = $this->dept_m->get_name_dept($INT_DEPT);
        $data['SECT'] = $this->section_m->get_name_section($INT_SECT);

        $data['content'] = 'budget/budget_expense/refresh_detail_budget_expense_v';

        if ($user_session['ROLE'] == 1) {
            //GET DETAIL BUDGET ADMIN 
            //$data['category_foh'] = $this->budget_expense_m->get_category_foh($INT_ID_FISCAL_YEAR, $INT_DIV, $INT_GROUP, $INT_DEPT);
            $data['summary_foh'] = $this->budget_expense_m->get_summary_expense_foh($INT_ID_FISCAL_YEAR, $INT_DIV, $INT_GROUP, $INT_DEPT, $INT_SECT);
            $data['summary_foh_total'] = $this->budget_expense_m->get_summary_expense_foh_total($INT_ID_FISCAL_YEAR, $INT_DIV, $INT_GROUP, $INT_DEPT, $INT_SECT);
            $data['summary_opx'] = $this->budget_expense_m->get_summary_expense_opx($INT_ID_FISCAL_YEAR, $INT_DIV, $INT_GROUP, $INT_DEPT, $INT_SECT);
            $data['summary_opx_total'] = $this->budget_expense_m->get_summary_expense_opx_total($INT_ID_FISCAL_YEAR, $INT_DIV, $INT_GROUP, $INT_DEPT, $INT_SECT);
        } else if ($user_session['ROLE'] == 2) {
            //GET DETAIL BUDGET ADMIN CPL 
            //$data['category_foh'] = $this->budget_expense_m->get_category_foh($INT_ID_FISCAL_YEAR, $INT_DIV, $INT_GROUP, $INT_DEPT);
//            if($INT_DIV == 3){
//                $data['summary_foh'] = $this->budget_expense_m->get_summary_expense_foh_cpl($INT_ID_FISCAL_YEAR, $INT_DIV, $INT_GROUP, $INT_DEPT, $INT_SECT);
//                $data['summary_foh_total'] = $this->budget_expense_m->get_summary_expense_foh_total_cpl($INT_ID_FISCAL_YEAR, $INT_DIV, $INT_GROUP, $INT_DEPT, $INT_SECT);
//                $data['summary_opx'] = $this->budget_expense_m->get_summary_expense_opx_cpl($INT_ID_FISCAL_YEAR, $INT_DIV, $INT_GROUP, $INT_DEPT, $INT_SECT);
//                $data['summary_opx_total'] = $this->budget_expense_m->get_summary_expense_opx_total_cpl($INT_ID_FISCAL_YEAR, $INT_DIV, $INT_GROUP, $INT_DEPT, $INT_SECT);
//            } else {
                $data['summary_foh'] = $this->budget_expense_m->get_summary_expense_foh($INT_ID_FISCAL_YEAR, $INT_DIV, $INT_GROUP, $INT_DEPT, $INT_SECT);
                $data['summary_foh_total'] = $this->budget_expense_m->get_summary_expense_foh_total($INT_ID_FISCAL_YEAR, $INT_DIV, $INT_GROUP, $INT_DEPT, $INT_SECT);
                $data['summary_opx'] = $this->budget_expense_m->get_summary_expense_opx($INT_ID_FISCAL_YEAR, $INT_DIV, $INT_GROUP, $INT_DEPT, $INT_SECT);
                $data['summary_opx_total'] = $this->budget_expense_m->get_summary_expense_opx_total($INT_ID_FISCAL_YEAR, $INT_DIV, $INT_GROUP, $INT_DEPT, $INT_SECT);
//            }
            
        } else if ($user_session['ROLE'] == 3 || $user_session['ROLE'] == 42 || $user_session['ROLE'] == 43) {
            //GET DETAIL BUDGET DIRECTUR
            $data['summary_foh'] = $this->budget_expense_m->get_summary_expense_foh_dir($INT_ID_FISCAL_YEAR, $INT_DIV, $INT_GROUP, $INT_DEPT, $INT_SECT);
            $data['summary_foh_total'] = $this->budget_expense_m->get_summary_expense_foh_total_dir($INT_ID_FISCAL_YEAR, $INT_DIV, $INT_GROUP, $INT_DEPT, $INT_SECT);
            $data['summary_opx'] = $this->budget_expense_m->get_summary_expense_opx_dir($INT_ID_FISCAL_YEAR, $INT_DIV, $INT_GROUP, $INT_DEPT, $INT_SECT);
            $data['summary_opx_total'] = $this->budget_expense_m->get_summary_expense_opx_total_dir($INT_ID_FISCAL_YEAR, $INT_DIV, $INT_GROUP, $INT_DEPT, $INT_SECT);
        } else if ($user_session['ROLE'] == 4 || $user_session['ROLE'] == 44 || $user_session['ROLE'] == 46 || $user_session['ROLE'] == 47 || $user_session['ROLE'] == 107) {
            //GET DETAIL BUDGET GM
            $data['summary_foh'] = $this->budget_expense_m->get_summary_expense_foh_gm($INT_ID_FISCAL_YEAR, $INT_DIV, $INT_GROUP, $INT_DEPT, $INT_SECT);
            $data['summary_foh_total'] = $this->budget_expense_m->get_summary_expense_foh_total_gm($INT_ID_FISCAL_YEAR, $INT_DIV, $INT_GROUP, $INT_DEPT, $INT_SECT);
            $data['summary_opx'] = $this->budget_expense_m->get_summary_expense_opx_gm($INT_ID_FISCAL_YEAR, $INT_DIV, $INT_GROUP, $INT_DEPT, $INT_SECT);
            $data['summary_opx_total'] = $this->budget_expense_m->get_summary_expense_opx_total_gm($INT_ID_FISCAL_YEAR, $INT_DIV, $INT_GROUP, $INT_DEPT, $INT_SECT);
        } else if ($user_session['ROLE'] == 5 || $user_session['ROLE'] == 39 || $user_session['ROLE'] == 45 || $user_session['ROLE'] == 48 || $user_session['ROLE'] == 49 || $user_session['ROLE'] == 50 || $user_session['ROLE'] == 51 || $user_session['ROLE'] == 52 || $user_session['ROLE'] == 70) {
            //GET DETAIL BUDGET MANAGER
            $data['summary_foh'] = $this->budget_expense_m->get_summary_expense_foh_man($INT_ID_FISCAL_YEAR, $INT_DIV, $INT_GROUP, $INT_DEPT, $INT_SECT);
            $data['summary_foh_total'] = $this->budget_expense_m->get_summary_expense_foh_total_man($INT_ID_FISCAL_YEAR, $INT_DIV, $INT_GROUP, $INT_DEPT, $INT_SECT);
            $data['summary_opx'] = $this->budget_expense_m->get_summary_expense_opx_man($INT_ID_FISCAL_YEAR, $INT_DIV, $INT_GROUP, $INT_DEPT, $INT_SECT);
            $data['summary_opx_total'] = $this->budget_expense_m->get_summary_expense_opx_total_man($INT_ID_FISCAL_YEAR, $INT_DIV, $INT_GROUP, $INT_DEPT, $INT_SECT);
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

    function refresh_summary_table() {
        $INT_ID_FISCAL_YEAR = $this->input->post("INT_ID_FISCAL_YEAR");
        $INT_DEPT = $this->input->post("INT_DEPT");
        $INT_SECT = $this->input->post("INT_SECT");
        $INT_DIV = $this->input->post("INT_DIV");
        $INT_GROUP = $this->input->post("INT_GROUP");

        echo site_url("budget/budget_expense_c/refresh_summary_table_page/1/$INT_ID_FISCAL_YEAR/$INT_DIV/$INT_GROUP/$INT_DEPT/$INT_SECT");
    }

    function refresh_summary_table_page($msg = null, $INT_ID_FISCAL_YEAR = null, $INT_DIV = null, $INT_GROUP = null, $INT_DEPT = null, $INT_SECT = null) {
        $user_session = $this->session->all_userdata();

        $data['INT_ID_FISCAL_YEAR'] = $INT_ID_FISCAL_YEAR;
        $data['INT_DIV'] = $INT_DIV;
        $data['INT_GROUP'] = $INT_GROUP;
        $data['INT_DEPT'] = $INT_DEPT;
        $data['INT_SECT'] = $INT_SECT;

        $data['DIV'] = $this->division_m->get_name_division($INT_DIV);
        $data['GROUP'] = $this->groupdept_m->get_name_groupdept($INT_GROUP);
        $data['DEPT'] = $this->dept_m->get_name_dept($INT_DEPT);
        $data['SECT'] = $this->section_m->get_name_section($INT_SECT);

        $data['content'] = 'budget/budget_expense/refresh_summary_budget_expense_v';

        if ($user_session['ROLE'] == 1) {
            //GET SUMMARY BUDGET ADMIN
            $data['summary_exp_div'] = $this->budget_expense_m->get_summary_expense_div_admin($INT_ID_FISCAL_YEAR);
            $data['summary_exp_group'] = $this->budget_expense_m->get_summary_expense_group_admin($INT_ID_FISCAL_YEAR);
            $data['summary_exp_dept'] = $this->budget_expense_m->get_summary_expense_dept_admin($INT_ID_FISCAL_YEAR);
            $data['summary_exp_total'] = $this->budget_expense_m->get_summary_expense_admin_total($INT_ID_FISCAL_YEAR);
        } else if ($user_session['ROLE'] == 2) {
            //GET SUMMARY BUDGET ADMIN
//            if($INT_DIV == 3){
//                $data['summary_exp_div'] = $this->budget_expense_m->get_summary_expense_div_admin_cpl($INT_ID_FISCAL_YEAR);
//                $data['summary_exp_group'] = $this->budget_expense_m->get_summary_expense_group_admin_cpl($INT_ID_FISCAL_YEAR);
//                $data['summary_exp_dept'] = $this->budget_expense_m->get_summary_expense_dept_admin_cpl($INT_ID_FISCAL_YEAR);
//                $data['summary_exp_total'] = $this->budget_expense_m->get_summary_expense_admin_total_cpl($INT_ID_FISCAL_YEAR);
//            } else {
                $data['summary_exp_div'] = $this->budget_expense_m->get_summary_expense_div_admin($INT_ID_FISCAL_YEAR);
                $data['summary_exp_group'] = $this->budget_expense_m->get_summary_expense_group_admin($INT_ID_FISCAL_YEAR);
                $data['summary_exp_dept'] = $this->budget_expense_m->get_summary_expense_dept_admin($INT_ID_FISCAL_YEAR);
                $data['summary_exp_total'] = $this->budget_expense_m->get_summary_expense_admin_total($INT_ID_FISCAL_YEAR);
//            }
            
        } else if ($user_session['ROLE'] == 3 || $user_session['ROLE'] == 42 || $user_session['ROLE'] == 43) {
            //GET DETAIL BUDGET DIRECTUR
            $data['summary_exp_div'] = $this->budget_expense_m->get_summary_expense_div_dir($INT_ID_FISCAL_YEAR, $INT_DIV);
            $data['summary_exp_group'] = $this->budget_expense_m->get_summary_expense_group_dir($INT_ID_FISCAL_YEAR, $INT_DIV);
            $data['summary_exp_dept'] = $this->budget_expense_m->get_summary_expense_dept_dir($INT_ID_FISCAL_YEAR, $INT_DIV);
            $data['summary_exp_total'] = $this->budget_expense_m->get_summary_expense_dir_total($INT_ID_FISCAL_YEAR, $INT_DIV);
        } else if ($user_session['ROLE'] == 4 || $user_session['ROLE'] == 44 || $user_session['ROLE'] == 46 || $user_session['ROLE'] == 47 || $user_session['ROLE'] == 107) {
            //GET DETAIL BUDGET GM
            $data['summary_exp_div'] = null;
            $data['summary_exp_group'] = $this->budget_expense_m->get_summary_expense_group_gm($INT_ID_FISCAL_YEAR, $INT_DIV, $INT_GROUP);
            $data['summary_exp_dept'] = $this->budget_expense_m->get_summary_expense_dept_gm($INT_ID_FISCAL_YEAR, $INT_DIV, $INT_GROUP);
            $data['summary_exp_total'] = $this->budget_expense_m->get_summary_expense_gm_total($INT_ID_FISCAL_YEAR, $INT_DIV, $INT_GROUP);
        } else if ($user_session['ROLE'] == 5 || $user_session['ROLE'] == 39 || $user_session['ROLE'] == 45 || $user_session['ROLE'] == 48 || $user_session['ROLE'] == 49 || $user_session['ROLE'] == 50 || $user_session['ROLE'] == 51 || $user_session['ROLE'] == 52) {
            //GET DETAIL BUDGET MANAGER
            $data['summary_exp_div'] = null;
            $data['summary_exp_group'] = null;
            $data['summary_exp_dept'] = $this->budget_expense_m->get_summary_expense_dept_man($INT_ID_FISCAL_YEAR, $INT_DIV, $INT_GROUP, $INT_DEPT);
            $data['summary_exp_total'] = $this->budget_expense_m->get_summary_expense_man_total($INT_ID_FISCAL_YEAR, $INT_DIV, $INT_GROUP, $INT_DEPT);
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

    function approve_budget_expense() {
        $user_session = $this->session->all_userdata();

        $INT_ID_FISCAL_YEAR = $this->input->post('INT_ID_FISCAL_YEAR');
        $INT_DIV = $this->input->post('INT_ID_DIV');
        $INT_GROUP = $this->input->post('INT_ID_GROUP');
        $INT_DEPT = $this->input->post('INT_ID_DEPT');
        $INT_SECT = $this->input->post('INT_ID_SECT');
        
        // $CHR_STAT_REV = 'NEW';
        $CHR_STAT_REV = 'RMB';

        if ($user_session['ROLE'] == 3 || $user_session['ROLE'] == 42 || $user_session['ROLE'] == 43) {
            $INT_DIV = $user_session['DIVISION'];
        } else if ($user_session['ROLE'] == 4 || $user_session['ROLE'] == 44 || $user_session['ROLE'] == 46 || $user_session['ROLE'] == 47 || $user_session['ROLE'] == 107) {
            $INT_DIV = $user_session['DIVISION'];
            $INT_GROUP = $user_session['GROUPDEPT'];
        } else if ($user_session['ROLE'] == 5 || $user_session['ROLE'] == 39 || $user_session['ROLE'] == 45 || $user_session['ROLE'] == 48 || $user_session['ROLE'] == 49 || $user_session['ROLE'] == 50 || $user_session['ROLE'] == 52) {
            $INT_DIV = $user_session['DIVISION'];
            $INT_GROUP = $user_session['GROUPDEPT'];
            $INT_DEPT = $user_session['DEPT'];
        }

//        print_r($INT_ID_FISCAL_YEAR. '-' .$INT_DIV. '-' . $INT_GROUP . '-' . $INT_DEPT);
//        exit();

        if ($_POST["btn-save"] == 'man') {
            $app_man = $this->db;
            $app_man->trans_begin();

            $app_man->query("UPDATE CPL.TT_BUDGET_EXPENSE SET CHR_FLAG_APP_MAN = '1'
                            WHERE (INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR')
                                    AND (CHR_STAT_REV = '$CHR_STAT_REV')
                                    AND (INT_DIV = '$INT_DIV')
                                    AND (INT_GROUP_DEPT = '$INT_GROUP')
                                    AND (INT_DEPT = '$INT_DEPT')");

            $app_man->query("UPDATE CPL.TT_BUDGET_EXPENSE_AMOUNT SET CHR_FLAG_APP_MAN = '1'
                            WHERE (INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR')
                                    AND (CHR_STAT_REV = '$CHR_STAT_REV')
                                    AND (INT_DIV = '$INT_DIV')
                                    AND (INT_GROUP_DEPT = '$INT_GROUP')
                                    AND (INT_DEPT = '$INT_DEPT')");

            $app_man->trans_complete();

            if ($app_man->trans_status() === FALSE) {
                $app_man->trans_rollback();
                redirect("budget/budget_expense_c/prepare_approve_expense/12/$INT_ID_FISCAL_YEAR/$INT_DIV/$INT_GROUP/$INT_DEPT/$INT_SECT");
            } else {
                $app_man->trans_commit();
                redirect("budget/budget_expense_c/prepare_approve_expense/6/$INT_ID_FISCAL_YEAR/$INT_DIV/$INT_GROUP/$INT_DEPT/$INT_SECT");
            }
        } else if ($_POST["btn-save"] == 'gm') {
            $app_gm = $this->db;
            $app_gm->trans_start();

            $app_gm->query("UPDATE CPL.TT_BUDGET_EXPENSE SET CHR_FLAG_APP_GM = '1'
                            WHERE (INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR')
                                    AND (CHR_STAT_REV = '$CHR_STAT_REV')
                                    AND (INT_DIV = '$INT_DIV')
                                    AND (INT_GROUP_DEPT = '$INT_GROUP')
                                    AND (INT_DEPT = '$INT_DEPT')");

            $app_gm->query("UPDATE CPL.TT_BUDGET_EXPENSE_AMOUNT SET CHR_FLAG_APP_GM = '1'
                            WHERE (INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR')
                                    AND (CHR_STAT_REV = '$CHR_STAT_REV')
                                    AND (INT_DIV = '$INT_DIV')
                                    AND (INT_GROUP_DEPT = '$INT_GROUP')
                                    AND (INT_DEPT = '$INT_DEPT')");

            $app_gm->trans_complete();

            if ($app_gm->trans_status() === FALSE) {
                $app_gm->trans_rollback();
                redirect("budget/budget_expense_c/prepare_approve_expense/12/$INT_ID_FISCAL_YEAR/$INT_DIV/$INT_GROUP/$INT_DEPT/$INT_SECT");
            } else {
                $app_gm->trans_commit();
                redirect("budget/budget_expense_c/prepare_approve_expense/6/$INT_ID_FISCAL_YEAR/$INT_DIV/$INT_GROUP/$INT_DEPT/$INT_SECT");
            }
        } else if ($_POST["btn-save"] == 'dir') {
            $app_dir = $this->db;
            $app_dir->trans_start();

            $app_dir->query("UPDATE CPL.TT_BUDGET_EXPENSE SET CHR_FLAG_APP_DIR = '1'
                            WHERE (INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR')
                                    AND (CHR_STAT_REV = '$CHR_STAT_REV')
                                    AND (INT_DIV = '$INT_DIV')
                                    AND (INT_GROUP_DEPT = '$INT_GROUP')
                                    AND (INT_DEPT = '$INT_DEPT')");

            $app_dir->query("UPDATE CPL.TT_BUDGET_EXPENSE_AMOUNT SET CHR_FLAG_APP_DIR = '1'
                            WHERE (INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR')
                                    AND (CHR_STAT_REV = '$CHR_STAT_REV')
                                    AND (INT_DIV = '$INT_DIV')
                                    AND (INT_GROUP_DEPT = '$INT_GROUP')
                                    AND (INT_DEPT = '$INT_DEPT')");

            $app_dir->trans_complete();

            if ($app_dir->trans_status() === FALSE) {
                $app_dir->trans_rollback();
                redirect("budget/budget_expense_c/prepare_approve_expense/12/$INT_ID_FISCAL_YEAR/$INT_DIV/$INT_GROUP/$INT_DEPT/$INT_SECT");
            } else {
                $app_dir->trans_commit();
                redirect("budget/budget_expense_c/prepare_approve_expense/6/$INT_ID_FISCAL_YEAR/$INT_DIV/$INT_GROUP/$INT_DEPT/$INT_SECT");
            }
        } else if ($_POST["btn-save"] == 'all') {
            $app_all = $this->db;
            $app_all->trans_start();

            $app_all->query("UPDATE CPL.TT_BUDGET_EXPENSE SET CHR_FLAG_APP_MAN = '1', CHR_FLAG_APP_GM = '1', CHR_FLAG_APP_DIR = '1', CHR_FLAG_APP_COMPLETE = '1'
                            WHERE (INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR')
                                    AND (CHR_STAT_REV = '$CHR_STAT_REV')
                                    AND (INT_DIV = '$INT_DIV')
                                    AND (INT_GROUP_DEPT = '$INT_GROUP')
                                    AND (INT_DEPT = '$INT_DEPT')");

            $app_all->query("UPDATE CPL.TT_BUDGET_EXPENSE_AMOUNT SET CHR_FLAG_APP_MAN = '1', CHR_FLAG_APP_GM = '1', CHR_FLAG_APP_DIR = '1', CHR_FLAG_APP_COMPLETE = '1'
                            WHERE (INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR')
                                    AND (CHR_STAT_REV = '$CHR_STAT_REV')
                                    AND (INT_DIV = '$INT_DIV')
                                    AND (INT_GROUP_DEPT = '$INT_GROUP')
                                    AND (INT_DEPT = '$INT_DEPT')");

            $app_all->trans_complete();

            if ($app_all->trans_status() === FALSE) {
                $app_all->trans_rollback();
                redirect("budget/budget_expense_c/prepare_approve_expense/12/$INT_ID_FISCAL_YEAR/$INT_DIV/$INT_GROUP/$INT_DEPT/$INT_SECT");
            } else {
                $app_all->trans_commit();
                redirect("budget/budget_expense_c/prepare_approve_expense/6/$INT_ID_FISCAL_YEAR/$INT_DIV/$INT_GROUP/$INT_DEPT/$INT_SECT");
            }
        } else if ($_POST["btn-save"] == 'reject') {
            $app_all = $this->db;
            $app_all->trans_start();

            $app_all->query("UPDATE CPL.TT_BUDGET_EXPENSE SET CHR_FLAG_APP_MAN = '0', CHR_FLAG_APP_GM = '0', CHR_FLAG_APP_DIR = '0', CHR_FLAG_APP_COMPLETE = '0'
                            WHERE (INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR')
                                    AND (CHR_STAT_REV = '$CHR_STAT_REV')
                                    AND (INT_DIV = '$INT_DIV')
                                    AND (INT_GROUP_DEPT = '$INT_GROUP')
                                    AND (INT_DEPT = '$INT_DEPT')");

            $app_all->query("UPDATE CPL.TT_BUDGET_EXPENSE_AMOUNT SET CHR_FLAG_APP_MAN = '0', CHR_FLAG_APP_GM = '0', CHR_FLAG_APP_DIR = '0', CHR_FLAG_APP_COMPLETE = '0'
                            WHERE (INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR')
                                    AND (CHR_STAT_REV = '$CHR_STAT_REV')
                                    AND (INT_DIV = '$INT_DIV')
                                    AND (INT_GROUP_DEPT = '$INT_GROUP')
                                    AND (INT_DEPT = '$INT_DEPT')");

            $app_all->trans_complete();

            if ($app_all->trans_status() === FALSE) {
                $app_all->trans_rollback();
                redirect("budget/budget_expense_c/prepare_approve_expense/12/$INT_ID_FISCAL_YEAR/$INT_DIV/$INT_GROUP/$INT_DEPT/$INT_SECT");
            } else {
                $app_all->trans_commit();
                redirect("budget/budget_expense_c/prepare_approve_expense/7/$INT_ID_FISCAL_YEAR/$INT_DIV/$INT_GROUP/$INT_DEPT/$INT_SECT");
            }
        }
    }

    function create_expense($msg = null, $INT_ID_FISCAL_YEAR = null, $INT_ID_BUDGET_TYPE = null, $INT_DIV = null, $INT_DEPT = null, $INT_SECT = null, $CHR_BUDGET_TYPE = null) {
        $user_session = $this->session->all_userdata();
        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Creating success. </strong> The data is successfully created. </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Updating success. </strong> The data is successfully updated. </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Deleting success. </strong> The data is successfully deleted. </div >";
        } elseif ($msg == 4) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Creating failed. </strong> No data amount on this fiscal year recorded. </div >";
        } elseif ($msg == 5) {
            $msg = "<div class = 'alert alert-success'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Commiting success. </strong> The data is successfully updated. </div >";
        } elseif ($msg == 6) {
            $msg = "<div class = 'alert alert-success'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Budget Expense was Approved. </strong> The data was successfully updated. </div >";
        } elseif ($msg == 7) {
            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Budget Expense was Rejected. </strong> The data was successfully updated. </div >";
        } elseif ($msg == 8) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Budget Expense was Unlocked. </strong> The data was successfully updated. </div >";
        } elseif ($msg == 12) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Executing error!</strong> Something is not right. </div >";
        } elseif ($msg == 13) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Executing failed!</strong> No data was selected.</div >";
        } elseif ($msg == 14) {
            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Access denied!</strong> Unbudget Expense cannot be ceated on the Planning session.</div >";
        } elseif ($msg == 15) {
            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Access denied!</strong> Update budget is not allowed.</div >";
        } elseif ($msg == 16) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Executing failed!</strong> File template upload not appropriate with budget type. Check your template</div >";
        } elseif ($msg == 17) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Executing failed!</strong> File template upload not appropriate with budget type. Please Check your template</div >";
        } elseif ($msg == 18) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Executing failed!</strong> Please check column Category or Sub Category. Empty is not allowed</div >";
        } elseif ($msg == 19) {
            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Uploading failed!</strong> Kolom pada excel terdapat data yg kosong (Code Category A3 / Name of Category A3) </div >";
        } elseif ($msg == 20) {
            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Uploading failed!</strong> Kolom pada excel terdapat data yg kosong (Code Category / Name of Category) </div >";
        } elseif ($msg == 21) {
            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Uploading failed!</strong> Kolom pada excel terdapat data yg kosong (Code Sub Category / Name of Sub Category) </div >";
        }

        $data['INT_ID_FISCAL_YEAR'] = $INT_ID_FISCAL_YEAR;
        $data['INT_ID_BUDGET_TYPE'] = $INT_ID_BUDGET_TYPE;
        $data['INT_DIV'] = $INT_DIV;
        $data['INT_DEPT'] = $INT_DEPT;
        $data['INT_SECT'] = $INT_SECT;
        $data['CHR_BUDGET_TYPE'] = $CHR_BUDGET_TYPE;

        if ($CHR_BUDGET_TYPE <> null) {
            $data['url_page'] = site_url("budget/budget_expense_c/refresh_table_page/1/$INT_ID_FISCAL_YEAR/$INT_ID_BUDGET_TYPE/$INT_DIV/$INT_DEPT/$INT_SECT/$CHR_BUDGET_TYPE");
        } else {
            $data['url_page'] = "";
        }

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(19);
        $data['news'] = $this->news_m->get_news();
        $data['msg'] = $msg;

        $data['title'] = 'Create Budget Expense';

        $data['subcontent'] = NULL;
        $data['content'] = 'budget/budget_expense/create_budget_expense_v';
        //$data['budget_type'] = $this->budgettype_m->get_budget_type_expense_by_basic_unit();
        $kode_dept = $user_session['DEPT'];
        $data['role'] = $user_session['ROLE'];
        $data['kode_dept'] = $kode_dept;

        if (($user_session['ROLE'] != 1) and ( $user_session['ROLE'] != 2)) {
            $data['data_fiscal'] = $this->fiscal_m->get_all_fiscal();
            $data['dept'] = $this->dept_m->get_name_dept_arr($kode_dept);
            $data['section'] = $this->dept_m->get_name_section_budget($kode_dept);
            $data['subgroup'] = $this->budgetsubgroup_m->get_exp_subgroup();
            $data['budget_type'] = $this->budgettype_m->get_authorize_budgettype_basic_unit($kode_dept);
            $fiscal = $this->fiscal_m->get_id_fiscal_this_year();
            $this->load->view($this->layout, $data);
//            $commit = $this->budget_expense_m->get_commited_status($fiscal, $user_session['SECTION']);
//            if ($unbudget == null) {
//                if ($commit->COMMITED != 0) {
//                    $this->log_m->add_log(124, NULL);
//                    redirect('budget/budget_expense_c');
//                } elseif ($commit->COMMITED == 0) {
//
//                    switch ($user_session['ROLE']) {
//                        case '6':
//                            $data['organization'] = $this->section_m->get_user_section($user_session['NPK']);
//                            $data['data_fiscal'] = $this->fiscal_m->get_fiscal_this_year();
//                            $data['subgroup'] = $this->budgetsubgroup_m->get_exp_subgroup();
//                            break;
//
//                        default:
//                            $this->log_m->add_log(124, NULL);
//                            redirect('fail_c/auth');
//                            break;
//                    }
//                    $this->load->view($this->layout, $data);
//                }
//            } elseif ($unbudget == 'u') {
//                if ($this->budget_expense_m->get_unbudget_status($fiscal, $user_session['SECTION']) == 0) {
//                    $this->log_m->add_log(125, NULL);
//                    $this->index('14');
//                } else {
//
//                    switch ($user_session['ROLE']) {
//                        case '6':
//                            $data['organization'] = $this->section_m->get_user_section($user_session['NPK']);
//                            $data['data_fiscal'] = $this->fiscal_m->get_fiscal_this_year();
//                            $data['subgroup'] = $this->budgetsubgroup_m->get_exp_subgroup();
//                            break;
//
//                        default:
//                            $this->log_m->add_log(124, NULL);
//                            redirect('fail_c/auth');
//                            break;
//                    }
//
//                    $this->load->view($this->layout, $data);
//                }
//            } else {
//                $this->log_m->add_log(124, NULL);
//                redirect('budget/budget_expense_c');
//            }
        } else {
            switch ($user_session['ROLE']) {
                case '1':
                    $data['data_fiscal'] = $this->fiscal_m->get_all_fiscal();
                    //$data['dept'] = $this->dept_m->get_name_dept_arr($kode_dept); //by user dept
                    $data['dept'] = $this->dept_m->get_dept(); //get all dept
                    $data['section'] = $this->dept_m->get_name_section_budget($kode_dept);
                    $data['subgroup'] = $this->budgetsubgroup_m->get_exp_subgroup();
                    //$data['budget_type'] = $this->budgettype_m->get_authorize_budgettype_basic_unit($kode_dept);
                    $data['budget_type'] = $this->budgettype_m->get_budget_type_expense_by_basic_unit();
                    break;
                case '2':
                    $data['data_fiscal'] = $this->fiscal_m->get_all_fiscal();
                    //$data['dept'] = $this->dept_m->get_name_dept_arr($kode_dept); //by user dept
                    $data['dept'] = $this->dept_m->get_dept(); //get all dept
                    $data['section'] = $this->dept_m->get_name_section_budget($kode_dept);
                    $data['subgroup'] = $this->budgetsubgroup_m->get_exp_subgroup();
                    //$data['budget_type'] = $this->budgettype_m->get_authorize_budgettype_basic_unit($kode_dept);
                    $data['budget_type'] = $this->budgettype_m->get_budget_type_expense_by_basic_unit();
                    break;
                default:
                    $this->log_m->add_log(124, NULL);
                    redirect('fail_c/auth');
                    break;
            }

            $data['data_budget_type'] = $this->budgettype_m->get_budgettype();
            $this->load->view($this->layout, $data);
        }
    }

    function show_more() {
        $type = $this->input->post('BUDGET_SUBGROUP', true);


        if ($type == '2') {
            $data['type'] = $this->budgettype_m->get_budget_type_expense();
            echo $this->load->view('budget/budget_expense/create_pure_expense_v', $data);
        } elseif ($type == '3') {
            $data['unit'] = $this->unit_m->get_unit();
            $data['type'] = $this->budgettype_m->get_budget_type_subexpense($this->input->post('INT_ID_DEPT', true));
            echo $this->load->view('budget/budget_expense/create_subexpense_v', $data);
        } else {
            
        }
    }

    function gen_ddl_groupdept() {
        $id_div = $this->input->post('INT_ID_DIV', true);
        $data['group_data'] = $this->groupdept_m->get_groupdept_by_division($id_div);
        $output = null;
        if ($data['group_data'] != NULL) {
            $output .= "<option value=''> -- Select Div (GM) -- </option>";
            foreach ($data['group_data'] as $row) {
                $output .= "<option value='" . $row->INT_ID_GROUP_DEPT . "'>" . $row->CHR_GROUP_DEPT . ' / ' . $row->CHR_GROUP_DEPT_DESC . "</option>";
            }
        } else {
            echo '<option value=""> -- Select Dir First -- </option>';
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
            echo '<option value=""> -- Select Div (GM) First -- </option>';
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

    function gen_ddl_section() {
        $user_session = $this->session->all_userdata();

        $output = null;
        //if ($user_session['ROLE'] == 6 || $user_session['ROLE'] == 12 || $user_session['ROLE'] == 13 || $user_session['ROLE'] == 30 || $user_session['ROLE'] == 40 || $user_session['ROLE'] == 54 || $user_session['ROLE'] == 53 || $user_session['ROLE'] == 55 || $user_session['ROLE'] == 57) {
        if ($user_session['ROLE'] != 1 && $user_session['ROLE'] != 2 && $user_session['ROLE'] != 5 && $user_session['ROLE'] != 39 && $user_session['ROLE'] != 45) {    
            if ($user_session['SECTION'] != NULL || $user_session['SECTION'] != '') {
                $section_code = $this->section_m->get_name_section_budget($user_session['SECTION']);
                $section_desc = $this->section_m->get_desc_section_budget($user_session['SECTION']);
                if ($section_code != NULL || $section_code != '') {
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

    function gen_fiscal_month() {
        $id_fiscal = $this->input->post('INT_ID_FISCAL_YEAR', true);
        if ($id_fiscal != NULL) {
            $data_fiscal = $this->fiscal_m->get_data_fiscal($id_fiscal)->row();
            $mon;
            if ($data_fiscal->CHR_FISCAL_YEAR_START == $data_fiscal->CHR_FISCAL_YEAR_END) {
                $mon = $data_fiscal->CHR_MONTH_END - $data_fiscal->CHR_MONTH_START + 1;
            } else {
                $mon = 12 - $data_fiscal->CHR_MONTH_START + 1 + $data_fiscal->CHR_MONTH_END;
            }
            $month = array('1' => 'January', '2' => 'February', '3' => 'March', '4' => 'April', '5' => 'May', '6' => 'June',
                '7' => 'July', '8' => 'August', '9' => 'September', '10' => 'October', '11' => 'November', '12' => 'December',
                '13' => 'January (2)', '14' => 'February (2)', '15' => 'March (2)', '16' => 'April (2)', '17' => 'May (2)', '18' => 'June (2)',
                '19' => 'July (2)', '20' => 'August (2)', '21' => 'September (2)', '22' => 'October (2)', '23' => 'November (2)', '24' => 'December (2)');
            $start = $data_fiscal->CHR_MONTH_START - 1;
            echo '<hr>';
            for ($i = 1; $i <= $mon; $i++) {
                $a = $start + $i;
                echo '<div class="col-md-2"><input name="MONEY[]" autocomplete="off" placeholder="' . $month[$a] . '" class="form-control" type="text"></div>';
            }
        } else {
            echo NULL;
        }
    }

    function test() {
        echo $this->input->post('INT_ID_DEPT', TRUE) . '-' . $this->input->post('BUDGET_TYPE', TRUE);
    }

    function gen_budget_subcategory_subexpense() {
        $x = $this->input->post('BUDGET_CATEGORY', TRUE);
        if ($x != NULL) {
            $dept = $this->input->post('INT_ID_DEPT', TRUE);
            $dept_subexpense = $this->dept_expense_m->get_dept_subexpense_for_dll($dept, $x);
            if ($dept_subexpense != NULL) {
                $output = null;
                foreach ($dept_subexpense as $row) {
                    $output .= "<option value='" . $row->INT_ID_BUDGET_SUB_CATEGORY . "'>" . $row->CHR_BUDGET_SUB_CATEGORY . ' / ' . $row->CHR_BUDGET_SUB_CATEGORY_DESC . "</option>";
                }
                echo $output;
            } else {
                echo '<option value="">!! Missing Link, Contact the administrator !!</option>';
            }
        } else {
            echo '<option value=""> -- Select Budget Category First -- </option>';
        }
    }

    function gen_budget_category() {
        $x = $this->input->post('BUDGET_TYPE', TRUE);

        if ($x != NULL) {
            $dept = $this->input->post('INT_ID_DEPT', TRUE);
            $dept_expense = $this->dept_expense_m->get_dept_expense_for_dll($dept, $x);
            if ($dept_expense != NULL) {
                $output = null;
                foreach ($dept_expense as $row) {
                    $output .= "<option value='" . $row->INT_ID_BUDGET_CATEGORY . "'>" . $row->CHR_BUDGET_CATEGORY . ' / ' . $row->CHR_BUDGET_CATEGORY_DESC . "</option>";
                }
                echo $output;
            } else {
                echo '<option value="">!! This Department has no previlledge on this Budget Category !!</option>';
            }
        } else {
            echo '<option value=""> -- Select Budget Type First -- </option>';
        }
    }

    function gen_budget_subcategory() {
        $x = $this->input->post('BUDGET_CATEGORY', TRUE);

        if ($x != NULL) {

            $subcategory = $this->budgetsubcategory_m->get_budgetsubcategory_by_category($x);

            if ($subcategory != NULL) {
                $output = null;
                foreach ($subcategory as $row) {
                    $output .= "<option value='" . $row->INT_ID_BUDGET_SUB_CATEGORY . "'>" . $row->CHR_BUDGET_SUB_CATEGORY . ' / ' . $row->CHR_BUDGET_SUB_CATEGORY_DESC . "</option>";
                }
                echo $output;
            } else {
                echo '<option value="">!! Missing Link, Contact the administrator !!</option>';
            } //!! This Department has no previlledge on this Budget Sub Category !!
        } else {
            echo '<option value=""> -- Select Budget Category First -- </option>';
        }
    }

    function null_category() {
        echo '<option value=""> -- Select Budget Type First -- </option>';
    }

    function gen_budget_category_subexpense() {
        $x = $this->input->post('BUDGET_TYPE', TRUE);
        if ($x != NULL) {
            $subexpense_category = $this->budgetcategory_m->get_budgetcategory_by_budgettype($x);

            if (count($subexpense_category) != 0) {
                $output = null;
                foreach ($subexpense_category as $row) {
                    $output .= "<option value='" . $row->INT_ID_BUDGET_CATEGORY . "'>" . $row->CHR_BUDGET_CATEGORY . ' / ' . $row->CHR_BUDGET_CATEGORY_DESC . "</option>";
                }
                echo $output;
            } else {
                echo '<option value="">!! This Department has no previlledge on this Budget Sub Category !!</option>';
            }
        } else {
            echo '<option value=""> -- Select Budget Type First -- </option>';
        }
    }

    private function gen_new_no_budget() {
        if ($this->budget_expense_m->check_any_id()) {
            $id_no_budget = $this->budget_expense_m->get_new_id_budget();
            $id = '2' . date('y') . substr($id_no_budget + 100000, 1);
        } else {
            $id = '2' . date('y') . substr($this->budget_expense_m->get_new_id_budget(), 3);
        }
        return $id;
    }

    function save_budget_expense($unbudget = null) {
        $money = $this->input->post('MONEY');
        $unb = 0;
        if ($unbudget != null) {
            $unb = 1;
        }
        $cx = 0;
        for ($q = 0; $q < count($money); $q++) {
            $cx = $cx + $money[$q];
        }
        if ($cx < 1) {
            $this->index('4');
        } else {
            $user_session = $this->session->all_userdata();
            $sect = $this->input->post('INT_ID_SECT');
            $fiscal_year = $this->input->post('INT_ID_FISCAL_YEAR');
            $subcategory = $this->input->post('BUDGET_SUBCATEGORY');
            $subgroup = $this->input->post('BUDGET_SUBGROUP');
            $id = $this->gen_new_no_budget();
            $data_fiscal = $this->fiscal_m->get_data_fiscal($fiscal_year)->row();

            if ($subgroup == '2') {
                $data = array(
                    'INT_NO_BUDGET_EXP' => $id,
                    'INT_REVISE' => 0,
                    'CHR_BUDGET_NAME' => $this->input->post('CHR_BUDGET_NAME'),
                    'INT_ID_FISCAL_YEAR' => $fiscal_year,
                    'INT_ID_SECTION' => $sect,
                    'INT_ID_BUDGET_SUB_CATEGORY' => $subcategory,
                    'CHR_NPK' => $user_session['NPK'],
                    'INT_ID_UNIT' => 0,
                    'DEC_MONEY_PER_UNIT' => NULL,
                    'CHR_CREATE_BY' => $user_session['USERNAME'],
                    'CHR_CREATE_DATE' => date('Ymd'),
                    'CHR_CREATE_TIME' => date('His'),
                    'BIT_FLG_DEL' => 0,
                    'BIT_UNBUDGET' => $unb,
                    'INT_APPROVE' => 0,
                    'INT_ALLOCATE' => $this->input->post('BUDGET_ALLOCATION'),
                    'BIT_LOCK' => 0
                );

                $this->db->trans_start();
                $this->budget_expense_m->save_expense($data);

                $this->log_m->add_log('63', $data['INT_NO_BUDGET_EXP']);

                $total = NULL;
                for ($i = 0; $i < count($money); $i++) {
                    if (($money[$i] != NULL) or ( $money[$i] != 0)) {
                        $data_expense = array(
                            'INT_NO_BUDGET_EXP' => $id,
                            'INT_REVISE' => 0,
                            'INT_MONTH_PLAN' => $i + $data_fiscal->CHR_MONTH_START, //--------------------------------
                            'DEC_MONEY_EXPENSE' => $money[$i],
                            'BIT_FLG_DEL' => 0
                        );
                        $total = $total + $money[$i];
                        $this->budget_expense_m->save_expense_detail($data_expense, 'e');
                    }
                }
                $data_total = array('DEC_TOTAL' => $total);
                $this->budget_expense_m->update_total($data_total, $id, 0);
                $this->db->trans_complete();
            } else if ($subgroup == '3') {
                $x = $this->input->post('PRICE_PER_UNIT');
                $data = array(
                    'INT_NO_BUDGET_EXP' => $id,
                    'INT_REVISE' => 0,
                    'CHR_BUDGET_NAME' => $this->input->post('CHR_BUDGET_NAME'),
                    'INT_ID_FISCAL_YEAR' => $fiscal_year,
                    'INT_ID_SECTION' => $sect,
                    'INT_ID_BUDGET_SUB_CATEGORY' => $this->input->post('BUDGET_SUBCATEGORY'),
                    'CHR_NPK' => $user_session['NPK'],
                    'INT_ID_UNIT' => $this->input->post('UOM'),
                    'DEC_MONEY_PER_UNIT' => $x,
                    'CHR_CREATE_BY' => $user_session['USERNAME'],
                    'CHR_CREATE_DATE' => date('Ymd'),
                    'CHR_CREATE_TIME' => date('His'),
                    'BIT_FLG_DEL' => 0,
                    'BIT_UNBUDGET' => $unb,
                    'INT_APPROVE' => 0,
                    'INT_ALLOCATE' => $this->input->post('BUDGET_ALLOCATION'),
                    'BIT_LOCK' => 0
                );
                $this->db->trans_start();
                $this->budget_expense_m->save_expense($data);

                $this->log_m->add_log('66', $data['INT_NO_BUDGET_EXP']);

                $money = $this->input->post('MONEY');
                $total = null;
                for ($i = 0; $i < count($money); $i++) {
                    if (($money[$i] != NULL) or ( $money[$i] != 0)) {
                        $data_subexpense = array(
                            'INT_NO_BUDGET_EXP' => $id,
                            'INT_REVISE' => 0,
                            'INT_MONTH_PLAN' => $i + $data_fiscal->CHR_MONTH_START, //--------------------------------
                            'INT_QUANTITY' => $money[$i],
                            'BIT_FLG_DEL' => 0
                        );
                        $total = $total + ($money[$i] * $x);

                        $this->budget_expense_m->save_expense_detail($data_subexpense, 's');
                    }
                }
                $data_total = array('DEC_TOTAL' => $total);
                $this->budget_expense_m->update_total($data_total, $id, 0);
                $this->db->trans_complete();
            }
            $this->index('1');
        }
    }

    function expense_detail($id, $rev, $msg = null) {
        if ($msg == 1) {
            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Deleting success. </strong> The expense detail data was successfully deleted. </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Creating failed. </strong> Make sure not to create detail on the other detail's month. </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Creating success. </strong> The data is successfully created. </div >";
        } elseif ($msg == 4) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Updating success. </strong> The data is successfully saved. </div >";
        } elseif ($msg == 5) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Restore success. </strong> The expense detail data was successfully restored. </div >";
        }
        $this->role_module_m->authorization('19');
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(19);
        $data['news'] = $this->news_m->get_news();

        $data['title'] = 'Budget Expense Details';
        $data['data'] = $this->budget_expense_m->get_expense_head_details($id, $rev);
        $data['msg'] = $msg;
        $data['details'] = NULL;

        if ($data['data']->INT_ID_UNIT == 0) {
            $data['details'] = $this->budget_expense_m->get_expense_details_with_del($id, $rev, 'e');
        } else {
            $data['details'] = $this->budget_expense_m->get_expense_details_with_del($id, $rev, 's');
        }

        if ($data['data']->CHR_FISCAL_YEAR_START == $data['data']->CHR_FISCAL_YEAR_END) {
            $mon = $data['data']->CHR_MONTH_END - $data['data']->CHR_MONTH_START + 1;
        } else {
            $mon = 12 - $data['data']->CHR_MONTH_START + 1 + $data['data']->CHR_MONTH_END;
        }

        $month = array('1' => 'Jan', '2' => 'Feb', '3' => 'Mar', '4' => 'Apr', '5' => 'May', '6' => 'Jun',
            '7' => 'Jul', '8' => 'Aug', '9' => 'Sep', '10' => 'Oct', '11' => 'Nov', '12' => 'Dec',
            '13' => 'Jan (2)', '14' => 'Feb (2)', '15' => 'Mar (2)', '16' => 'Apr (2)', '17' => 'May (2)', '18' => 'June (2)',
            '19' => 'Jul (2)', '20' => 'Aug (2)', '21' => 'Sep (2)', '22' => 'Oct (2)', '23' => 'Nov (2)', '24' => 'Dec (2)');
        $start = $data['data']->CHR_MONTH_START - 1;
        $categories = null;
        $data_budget = null;
        $x = null;
        foreach ($data['details'] as $value) {
            $z = $value->INT_MONTH_PLAN - 1;
            break;
        }
        for ($i = 1; $i <= $mon; $i++) {
            if ($i != 1) {
                $categories = $categories . ',';
                $data_budget = $data_budget . ',';
            }
            $a = $start + $i;
            $categories = $categories . "'$month[$a]'";
            foreach ($data['details'] as $value) {
                if (($value->INT_MONTH_PLAN ) == ($i + $z)) {
                    if ($data['data']->INT_ID_UNIT == 0) {
                        $data_budget = $data_budget . "$value->DEC_MONEY_EXPENSE";
                    } else {
                        $data_budget = $data_budget . "$value->INT_QUANTITY";
                    }
                    $x = $i;
                }
            }
            if ($x != $i) {
                $data_budget = $data_budget . "0";
            }
        }

        $data['categories'] = $categories;
        $data['data_budget'] = $data_budget;
        $data['content'] = 'budget/budget_expense/view_budget_expense_v';
        $this->load->view($this->layout, $data);
    }

    function edit_expense_detail($id, $rev, $month, $type) {
        $session = $this->session->all_userdata();
        $check_comm = $this->budget_expense_m->get_expense_head_details($id, $rev);
        if ($check_comm->BIT_LOCK != 0) {
            redirect('budget/budget_expense_c');
        }
        $this->role_module_m->authorization('19');
        $log = NULL;
        $this->db->trans_start();
        if ($type == 'e') {
            $log = 73;
            $data_expense = array(
                'INT_NO_BUDGET_EXP' => $id,
                'INT_REVISE' => $rev,
                'INT_MONTH_PLAN' => $month,
                'DEC_MONEY_EXPENSE' => $this->input->post('INT_AMOUNT'),
                'BIT_FLG_DEL' => 0
            );
            $this->budget_expense_m->update_expense_detail($id, $rev, $month, $data_expense, $type);
            $amount = $this->budget_expense_m->get_amount_expense_detail($id, $rev, $type);
            $total = null;
            foreach ($amount as $value) {
                $total = $total + $value->DEC_MONEY_EXPENSE;
            }
            $data_total = array(
                'DEC_TOTAL' => $total,
                'CHR_MODI_BY' => $session['USERNAME'],
                'CHR_MODI_DATE' => date('Ymd'),
                'CHR_MODI_TIME' => date('His')
            );
        } elseif ($type == 's') {
            $log = 74;
            $data_expense = array(
                'INT_NO_BUDGET_EXP' => $id,
                'INT_REVISE' => $rev,
                'INT_MONTH_PLAN' => $month,
                'INT_QUANTITY' => $this->input->post('INT_QTY'),
                'BIT_FLG_DEL' => 0
            );
            $this->budget_expense_m->update_expense_detail($id, $rev, $month, $data_expense, $type);

            $amount = $this->budget_expense_m->get_amount_expense_detail($id, $rev, $type);
            $qty = null;
            foreach ($amount as $value) {
                $qty = $qty + $value->INT_QUANTITY;
            }
            $total = $qty * $this->budget_expense_m->get_price_per_unit($id, $rev);
            $data_total = array(
                'DEC_TOTAL' => $total,
                'CHR_MODI_BY' => $session['USERNAME'],
                'CHR_MODI_DATE' => date('Ymd'),
                'CHR_MODI_TIME' => date('His')
            );
        }
        $this->budget_expense_m->update_total($data_total, $id, $rev);

        $this->log_m->add_log($log, "$id/R$rev/M$month");
        $this->db->trans_complete();
        $this->expense_detail($id, $rev, 4);
    }

    function add_detail($id, $rev, $type) {
        $session = $this->session->all_userdata();
        $month = $this->input->post('INT_MONTH');
        $data_detail = $this->budget_expense_m->get_expense_details_with_del($id, $rev, $type);
        $check = null;
        foreach ($data_detail as $value) {
            if ($value->INT_MONTH_PLAN == $month) {
                $check = 1;
            }
        }
        if ($check == 1) {
            if ($type == 'e') {
                $log = 142;
            } else {
                $log = 143;
            }
            $this->log_m->add_log($log, "$id/R$rev/M$month");
            $this->expense_detail($id, $rev, 2);
        } else {
            $this->db->trans_start();

            if ($type == 'e') {
                $log = 140;
                $data_expense = array(
                    'INT_NO_BUDGET_EXP' => $id,
                    'INT_REVISE' => $rev,
                    'INT_MONTH_PLAN' => $month,
                    'DEC_MONEY_EXPENSE' => $this->input->post('INT_AMOUNT'),
                    'BIT_FLG_DEL' => 0
                );

                $this->budget_expense_m->save_expense_detail($data_expense, $type);

                $amount = $this->budget_expense_m->get_amount_expense_detail($id, $rev, $type);
                $total = null;
                foreach ($amount as $value) {
                    $total = $total + $value->DEC_MONEY_EXPENSE;
                }
                $data_total = array(
                    'DEC_TOTAL' => $total,
                    'CHR_MODI_BY' => $session['USERNAME'],
                    'CHR_MODI_DATE' => date('Ymd'),
                    'CHR_MODI_TIME' => date('His')
                );
            } else {
                $log = 141;
                $data_expense = array(
                    'INT_NO_BUDGET_EXP' => $id,
                    'INT_REVISE' => $rev,
                    'INT_MONTH_PLAN' => $month,
                    'INT_QUANTITY' => $this->input->post('INT_QTY'),
                    'BIT_FLG_DEL' => 0
                );

                $this->budget_expense_m->save_expense_detail($data_expense, $type);

                $amount = $this->budget_expense_m->get_amount_expense_detail($id, $rev, $type);
                $qty = null;
                foreach ($amount as $value) {
                    $qty = $qty + $value->INT_QUANTITY;
                }
                $total = $qty * $this->budget_expense_m->get_price_per_unit($id, $rev);
                $data_total = array(
                    'DEC_TOTAL' => $total,
                    'CHR_MODI_BY' => $session['USERNAME'],
                    'CHR_MODI_DATE' => date('Ymd'),
                    'CHR_MODI_TIME' => date('His')
                );
            }
            $this->budget_expense_m->update_total($data_total, $id, $rev);

            $this->log_m->add_log($log, "$id/R$rev/M$month");
            $this->db->trans_complete();
            $this->expense_detail($id, $rev, 3);
        }
    }

    function restore_expense_detail($id, $rev, $mon) {
        $check_comm = $this->budget_expense_m->get_expense_head_details($id, $rev);
        if ($check_comm->BIT_LOCK != 0) {
            $this->log_m->add_log(145, $id . '/R' . $rev . '/M' . $mon);
            $this->index(15);
        } else {
            $session = $this->session->all_userdata();
            $this->role_module_m->authorization('19');
            $this->db->trans_start();
            $data = array(
                'BIT_FLG_DEL' => 0,
                'CHR_MODI_BY' => $session['USERNAME'],
                'CHR_MODI_DATE' => date('Ymd'),
                'CHR_MODI_TIME' => date('His'));
            if ($this->budget_expense_m->is_pure_expense($id)) {
                $this->budget_expense_m->update_expense_detail($id, $rev, $mon, $data, 'e');
                $amount = $this->budget_expense_m->get_amount_expense_detail($id, $rev, 'e');
                $total = null;
                foreach ($amount as $value) {
                    $total = $total + $value->DEC_MONEY_EXPENSE;
                }
                $data_total = array(
                    'DEC_TOTAL' => $total,
                    'CHR_MODI_BY' => $session['USERNAME'],
                    'CHR_MODI_DATE' => date('Ymd'),
                    'CHR_MODI_TIME' => date('His')
                );
                $this->budget_expense_m->update_total($data_total, $id, $rev);
                $this->log_m->add_log('144', $id . '/R' . $rev . '/M' . $mon);
            } else {

                $this->budget_expense_m->update_expense_detail($id, $rev, $mon, $data, 's');
                $amount = $this->budget_expense_m->get_amount_expense_detail($id, $rev, 's');
                $qty = null;
                foreach ($amount as $value) {
                    $qty = $qty + $value->INT_QUANTITY;
                }
                $total = $qty * $this->budget_expense_m->get_price_per_unit($id, $rev);
                $data_total = array(
                    'DEC_TOTAL' => $total,
                    'CHR_MODI_BY' => $session['USERNAME'],
                    'CHR_MODI_DATE' => date('Ymd'),
                    'CHR_MODI_TIME' => date('His')
                );
                $this->budget_expense_m->update_total($data_total, $id, $rev);
                $this->log_m->add_log('144', $id . '/R' . $rev . '/M' . $mon);
            }
            $this->db->trans_complete();
            $this->expense_detail($id, $rev, 5);
        }
    }

    function delete_expense_detail($id, $rev, $mon) {
        $check_comm = $this->budget_expense_m->get_expense_head_details($id, $rev);
        if ($check_comm->BIT_LOCK != 0) {
            $this->log_m->add_log(126, $id . '/R' . $rev . '/M' . $mon . '');
            $this->index(15);
        } else {
            $session = $this->session->all_userdata();
            $this->role_module_m->authorization('19');
            $this->db->trans_start();
            $data = array(
                'BIT_FLG_DEL' => 1,
                'CHR_MODI_BY' => $session['USERNAME'],
                'CHR_MODI_DATE' => date('Ymd'),
                'CHR_MODI_TIME' => date('His'));
            if ($this->budget_expense_m->is_pure_expense($id)) {
                $this->budget_expense_m->update_expense_detail($id, $rev, $mon, $data, 'e');
                $amount = $this->budget_expense_m->get_amount_expense_detail($id, $rev, 'e');
                $total = null;
                foreach ($amount as $value) {
                    $total = $total + $value->DEC_MONEY_EXPENSE;
                }
                $data_total = array(
                    'DEC_TOTAL' => $total,
                    'CHR_MODI_BY' => $session['USERNAME'],
                    'CHR_MODI_DATE' => date('Ymd'),
                    'CHR_MODI_TIME' => date('His')
                );
                $this->budget_expense_m->update_total($data_total, $id, $rev);
                $this->log_m->add_log('71', $id . '/R' . $rev . '/M' . $mon);
            } else {

                $this->budget_expense_m->update_expense_detail($id, $rev, $mon, $data, 's');
                $amount = $this->budget_expense_m->get_amount_expense_detail($id, $rev, 's');
                $qty = null;
                foreach ($amount as $value) {
                    $qty = $qty + $value->INT_QUANTITY;
                }
                $total = $qty * $this->budget_expense_m->get_price_per_unit($id, $rev);
                $data_total = array(
                    'DEC_TOTAL' => $total,
                    'CHR_MODI_BY' => $session['USERNAME'],
                    'CHR_MODI_DATE' => date('Ymd'),
                    'CHR_MODI_TIME' => date('His')
                );
                $this->budget_expense_m->update_total($data_total, $id, $rev);
                $this->log_m->add_log('72', $id . '/R' . $rev . '/M' . $mon);
            }
            $this->db->trans_complete();
            $this->expense_detail($id, $rev, 1);
        }
    }

    function delete_expense($id, $rev) {
        $this->db->trans_start();
        $user_session = $this->session->all_userdata();
        $data['data'] = $this->budget_expense_m->get_expense_head_details($id, $rev);
        if ($this->check_if_admin()) {
            if ($this->budget_expense_m->is_pure_expense($id)) {
                $this->budget_expense_m->delete_expense($id, $rev, 'e');
                $this->log_m->add_log('65', $id);
            } else {
                $this->budget_expense_m->delete_expense($id, $rev, 's');
                $this->log_m->add_log('68', $id);
            }
            $this->db->trans_complete();
            $this->index('3');
        } else {
            if ($data['data']->BIT_LOCK != 0 or $data['data']->BIT_FLG_DEL == 1 or $data['data']->INT_ID_SECTION != $user_session['SECTION']) {
                $this->log_m->add_log(127, $id . '/R' . $rev);
                $this->index(15);
            } else {
                if ($this->budget_expense_m->is_pure_expense($id)) {
                    $this->budget_expense_m->delete_expense($id, $rev, 'e');
                    $this->log_m->add_log('65', $id);
                } else {
                    $this->budget_expense_m->delete_expense($id, $rev, 's');
                    $this->log_m->add_log('68', $id);
                }
                $this->db->trans_complete();
                $this->index('3');
            }
        }
    }

    function edit_expense($id, $rev) {
        $user_session = $this->session->all_userdata();
        $data['data'] = $this->budget_expense_m->get_expense_head_details($id, $rev);
        if ($this->check_if_admin()) {
            $data['app'] = $this->role_module_m->get_app();
            $data['module'] = $this->role_module_m->get_module();
            $data['function'] = $this->role_module_m->get_function();
            $data['sidebar'] = $this->role_module_m->side_bar(19);
            $data['news'] = $this->news_m->get_news();

            $dept = $this->budget_expense_m->get_dept_from_expense($id)->INT_ID_DEPT;

            $data['title'] = 'Manage Budget Planning Expense';

            if ($data['data']->INT_ID_UNIT == 0) {
                $data['type'] = $this->budgettype_m->get_budget_type_expense();
                $data['data_fiscal'] = $this->fiscal_m->get_data_fiscal($data['data']->INT_ID_FISCAL_YEAR)->row();
                $data['content'] = 'budget/budget_expense/edit_pure_expense_v';
            } else {
                $data['unit'] = $this->unit_m->get_unit();
                $data['type'] = $this->budgettype_m->get_budget_type_subexpense($dept);
                $data['data_fiscal'] = $this->fiscal_m->get_data_fiscal($data['data']->INT_ID_FISCAL_YEAR)->row();
                $data['content'] = 'budget/budget_expense/edit_subexpense_v';
            }
            $this->load->view($this->layout, $data);
        } else {

            if ($data['data']->BIT_LOCK != 0 or $data['data']->BIT_FLG_DEL == 1 or $data['data']->INT_ID_SECTION != $user_session['SECTION']) {
                $this->log_m->add_log(127, $id . '/R' . $rev);
                $this->index(15);
            } else {
                $data['app'] = $this->role_module_m->get_app();
                $data['module'] = $this->role_module_m->get_module();
                $data['function'] = $this->role_module_m->get_function();
                $data['sidebar'] = $this->role_module_m->side_bar(19);
                $data['news'] = $this->news_m->get_news();

                $dept = $this->budget_expense_m->get_dept_from_expense($id)->INT_ID_DEPT;

                $data['title'] = 'Manage Budget Planning Expense';

                if ($data['data']->INT_ID_UNIT == 0) {
                    $data['type'] = $this->budgettype_m->get_budget_type_expense();
                    $data['data_fiscal'] = $this->fiscal_m->get_data_fiscal($data['data']->INT_ID_FISCAL_YEAR)->row();
                    $data['content'] = 'budget/budget_expense/edit_pure_expense_v';
                } else {
                    $data['unit'] = $this->unit_m->get_unit();
                    $data['type'] = $this->budgettype_m->get_budget_type_subexpense($dept);
                    $data['data_fiscal'] = $this->fiscal_m->get_data_fiscal($data['data']->INT_ID_FISCAL_YEAR)->row();
                    $data['content'] = 'budget/budget_expense/edit_subexpense_v';
                }
                $this->load->view($this->layout, $data);
            }
        }
    }

    function update_budget_expense($x, $rev) {
        $id = $this->input->post('INT_NO_BUDGET_EXP');
        $session = $this->session->all_userdata();
        $this->db->trans_start();
        if ($x == 'e') {
            $log = '64';
            $data_expense = array(
                'CHR_BUDGET_NAME' => $this->input->post('CHR_BUDGET_NAME'),
                'INT_ALLOCATE' => $this->input->post('BUDGET_ALLOCATION'),
                'INT_ID_BUDGET_SUB_CATEGORY' => $this->input->post('BUDGET_SUBCATEGORY'),
                'CHR_MODI_BY' => $session['USERNAME'],
                'CHR_MODI_DATE' => date('Ymd'),
                'CHR_MODI_TIME' => date('His')
            );
        } else {
            $log = '67';
            $new_money = $this->budget_expense_m->get_new_money_subexpense($id, $rev) * $this->input->post('PRICE_PER_UNIT');

            $data_expense = array(
                'CHR_BUDGET_NAME' => $this->input->post('CHR_BUDGET_NAME'),
                'INT_ALLOCATE' => $this->input->post('BUDGET_ALLOCATION'),
                'INT_ID_BUDGET_SUB_CATEGORY' => $this->input->post('BUDGET_SUBCATEGORY'),
                'INT_ID_UNIT' => $this->input->post('UOM'),
                'DEC_TOTAL' => $new_money,
                'DEC_MONEY_PER_UNIT' => $this->input->post('PRICE_PER_UNIT'),
                'CHR_MODI_BY' => $session['USERNAME'],
                'CHR_MODI_DATE' => date('Ymd'),
                'CHR_MODI_TIME' => date('His')
            );
        }
        $this->budget_expense_m->update_expense($id, $rev, $data_expense);
        $this->log_m->add_log($log, $id);
        $this->db->trans_complete();
        $this->index('2');
    }

    function select_expense_by_section($sect = NULL) {
        $session = $this->session->all_userdata();
        $sect = $sect;
        switch ($session['ROLE']) {
            case '1':
                $data['data'] = $this->budget_expense_m->get_all_budget_expense($fiscal, $user->INT_ID_COMPANY);
                $data['content'] = 'budget/budget_expense/manage_budget_expense_v';
                break;
            case '2':
                $data['org'] = $user;
                $data['commit'] = $this->budget_expense_m->get_commited_status($fiscal, $user->INT_ID_COMPANY);
                $data['data'] = $this->budget_expense_m->get_all_budget_expense($fiscal, $user->INT_ID_COMPANY);
                $data['content'] = 'budget/budget_expense/manage_budget_expense_by_admin_v';
                break;
            case '3':
                $data['commit'] = $this->budget_expense_m->get_commited_status($fiscal, $user->INT_ID_DIVISION);
                $data['org'] = $user;
                $data['data'] = $this->budget_expense_m->get_all_budget_expense($fiscal, $user->INT_ID_DIVISION);
                $data['content'] = 'budget/budget_expense/manage_budget_expense_by_div_v';
                break;
            case '4':
                $data['commit'] = $this->budget_expense_m->get_commited_status($fiscal, $user->INT_ID_GROUP_DEPT);
                $data['org'] = $user;
                $data['data'] = $this->budget_expense_m->get_all_budget_expense($fiscal, $user->INT_ID_GROUP_DEPT);
                $data['content'] = 'budget/budget_expense/manage_budget_expense_by_group_dept_v';
                break;
            case '5':
                $data['commit'] = $this->budget_expense_m->get_commited_status($fiscal, $user->INT_ID_DEPT);
                $data['org'] = $user;
                $data['data'] = $this->budget_expense_m->get_all_budget_expense($fiscal, $user->INT_ID_DEPT);
                $data['content'] = 'budget/budget_expense/manage_budget_expense_by_dept_v';
                break;
            case '6':
                redirect('budget/budget_expense_c');
                break;
            default:
                $this->index();
                break;
        }
        $data['title'] = 'Section\'s Expenses';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(19);
        $data['news'] = $this->news_m->get_news();
        $data['msg'] = null;


        $fiscal = $this->fiscal_m->get_id_fiscal_this_year();
        $data['commit'] = $this->budget_expense_m->get_commited_status($fiscal, $sect);
        $data['data'] = $this->budget_expense_m->get_all_budget_expense($fiscal, $sect);
        $data['org'] = $this->section_m->get_section_org($sect);
        $data['content'] = 'budget/budget_expense/manage_budget_expense_by_section_v';

        $this->load->view($this->layout, $data);
    }

    function select_expense_by_dept($dept = NULL) {
        $session = $this->session->all_userdata();
        switch ($session['ROLE']) {
            case '1':
                $data['data'] = $this->budget_expense_m->get_all_budget_expense($fiscal, $user->INT_ID_COMPANY);
                $data['content'] = 'budget/budget_expense/manage_budget_expense_v';
                break;
            case '2':
                $data['org'] = $user;
                $data['commit'] = $this->budget_expense_m->get_commited_status($fiscal, $user->INT_ID_COMPANY);
                $data['data'] = $this->budget_expense_m->get_all_budget_expense($fiscal, $user->INT_ID_COMPANY);
                $data['content'] = 'budget/budget_expense/manage_budget_expense_by_admin_v';
                break;
            case '3':
                $data['commit'] = $this->budget_expense_m->get_commited_status($fiscal, $user->INT_ID_DIVISION);
                $data['org'] = $user;
                $data['data'] = $this->budget_expense_m->get_all_budget_expense($fiscal, $user->INT_ID_DIVISION);
                $data['content'] = 'budget/budget_expense/manage_budget_expense_by_div_v';
                break;
            case '4':
                $data['commit'] = $this->budget_expense_m->get_commited_status($fiscal, $user->INT_ID_GROUP_DEPT);
                $data['org'] = $user;
                $data['data'] = $this->budget_expense_m->get_all_budget_expense($fiscal, $user->INT_ID_GROUP_DEPT);
                $data['content'] = 'budget/budget_expense/manage_budget_expense_by_group_dept_v';
                break;
            case '5':
                $data['commit'] = $this->budget_expense_m->get_commited_status($fiscal, $user->INT_ID_DEPT);
                $data['org'] = $user;
                $data['data'] = $this->budget_expense_m->get_all_budget_expense($fiscal, $user->INT_ID_DEPT);
                $data['content'] = 'budget/budget_expense/manage_budget_expense_by_dept_v';
                break;
            default:
                $this->index();
                break;
        }
    }

    function select_expense_by_group_dept($gdept = NULL) {
        $session = $this->session->all_userdata();
        switch ($session['ROLE']) {
            case '1':
                $data['data'] = $this->budget_expense_m->get_all_budget_expense($fiscal, $user->INT_ID_COMPANY);
                $data['content'] = 'budget/budget_expense/manage_budget_expense_v';
                break;
            case '2':
                $data['org'] = $user;
                $data['commit'] = $this->budget_expense_m->get_commited_status($fiscal, $user->INT_ID_COMPANY);
                $data['data'] = $this->budget_expense_m->get_all_budget_expense($fiscal, $user->INT_ID_COMPANY);
                $data['content'] = 'budget/budget_expense/manage_budget_expense_by_admin_v';
                break;
            case '3':
                $data['commit'] = $this->budget_expense_m->get_commited_status($fiscal, $user->INT_ID_DIVISION);
                $data['org'] = $user;
                $data['data'] = $this->budget_expense_m->get_all_budget_expense($fiscal, $user->INT_ID_DIVISION);
                $data['content'] = 'budget/budget_expense/manage_budget_expense_by_div_v';
                break;
            case '4':
                $data['commit'] = $this->budget_expense_m->get_commited_status($fiscal, $user->INT_ID_GROUP_DEPT);
                $data['org'] = $user;
                $data['data'] = $this->budget_expense_m->get_all_budget_expense($fiscal, $user->INT_ID_GROUP_DEPT);
                $data['content'] = 'budget/budget_expense/manage_budget_expense_by_group_dept_v';
                break;
            default:
                $this->index();
                break;
        }
    }

    function select_expense_by_div($div = NULL) {
        $session = $this->session->all_userdata();
        switch ($session['ROLE']) {
            case '1':
                $data['data'] = $this->budget_expense_m->get_all_budget_expense($fiscal, $user->INT_ID_COMPANY);
                $data['content'] = 'budget/budget_expense/manage_budget_expense_v';
                break;
            case '2':
                $data['org'] = $user;
                $data['commit'] = $this->budget_expense_m->get_commited_status($fiscal, $user->INT_ID_COMPANY);
                $data['data'] = $this->budget_expense_m->get_all_budget_expense($fiscal, $user->INT_ID_COMPANY);
                $data['content'] = 'budget/budget_expense/manage_budget_expense_by_admin_v';
                break;
            case '3':
                $data['commit'] = $this->budget_expense_m->get_commited_status($fiscal, $user->INT_ID_DIVISION);
                $data['org'] = $user;
                $data['data'] = $this->budget_expense_m->get_all_budget_expense($fiscal, $user->INT_ID_DIVISION);
                $data['content'] = 'budget/budget_expense/manage_budget_expense_by_div_v';
                break;
            default:
                $this->index();
                break;
        }
    }

    function approve_expense($admin_approve = NULL) {
        $budgets = $this->input->post('case');
        if ($budgets == NULL) {
            $this->prepare_approve_expense('13');
        } else {
            $this->db->trans_start();
            $fiscal = $this->fiscal_m->get_id_fiscal_this_year();
            $x = NULL;
            foreach ($budgets as $id) {
                if ($x == NULL) {
                    $x = $id;
                } else {
                    $x = $x . ',' . $id;
                }
                $this->budget_expense_m->approve_expense($id, $fiscal);
            }
            $session = $this->session->all_userdata();
            switch ($session['ROLE']) {
                case 1:
                    $log = $admin_approve;
                    break;
                case 3://ap div
                    $log = 80;
                    break;
                case 4://ap gdept
                    $log = 78;
                    break;
                case 5://ap dept
                    $log = 76;
                    break;
                default:
                    break;
            }

            $this->log_m->add_log($log, $x);
            $this->db->trans_complete();
            $this->prepare_approve_expense('6');
        }
    }

    function reject_expense($id, $admin_reject = NULL) {
        $session = $this->session->all_userdata();
        $user = $this->user_m->get_user_org($session['NPK']);
        switch ($session['ROLE']) {
            case 1:
                $log = $admin_reject;
                break;
            case 2://rej div
                $log = 97;
                break;
            case 3://rej div
                $log = 97;

                break;
            case 4://rej gdept
                $log = 95;
                if (!$this->check_if_admin()) {
                    $org = $this->groupdept_m->get_gdept_id($id);
                    if ($org->INT_ID_GROUP_DEPT != $user->INT_ID_GROUP_DEPT) {
                        $this->log_m->add_log(132, $id);
                        redirect('fail_c/auth');
                    }
                }
                break;
            case 5://rej dept
                $log = 82;
                if (!$this->check_if_admin()) {
                    $org = $this->dept_m->get_dept_id($id);
                    if ($org->INT_ID_DEPT != $user->INT_ID_DEPT) {
                        $this->log_m->add_log(129, $id);
                        redirect('fail_c/auth');
                    }
                }
                break;
            default: // fail whoever doesnt have an auth
                redirect('fail_c/auth');
                break;
        }
        $this->db->trans_start();
        $fiscal = $this->fiscal_m->get_id_fiscal_this_year();
        $rev_budgets = $this->budget_expense_m->reject_expense($id, $fiscal);
        foreach ($rev_budgets as $budget) {
            $next_rev = $budget->INT_REVISE + 1;
            $x = NULL;
            if ($this->budget_expense_m->is_pure_expense($budget->INT_NO_BUDGET_EXP)) {
                $x = 'e';
            } else {
                $x = 's';
            }
            $rev_budgets_details = $this->budget_expense_m->get_reject_detail($budget->INT_NO_BUDGET_EXP, $budget->INT_REVISE, $x);
            $data_head = array(
                'INT_NO_BUDGET_EXP' => $budget->INT_NO_BUDGET_EXP,
                'INT_REVISE' => $next_rev,
                'CHR_BUDGET_NAME' => $budget->CHR_BUDGET_NAME,
                'INT_APPROVE' => $budget->INT_APPROVE,
                'INT_ID_FISCAL_YEAR' => $budget->INT_ID_FISCAL_YEAR,
                'INT_ID_SECTION' => $budget->INT_ID_SECTION,
                'INT_ID_BUDGET_SUB_CATEGORY' => $budget->INT_ID_BUDGET_SUB_CATEGORY,
                'INT_ID_UNIT' => $budget->INT_ID_UNIT,
                'INT_ALLOCATE' => $budget->INT_ALLOCATE,
                'CHR_NPK' => $budget->CHR_NPK,
                'DEC_MONEY_PER_UNIT' => $budget->DEC_MONEY_PER_UNIT,
                'DEC_TOTAL' => $budget->DEC_TOTAL,
                'BIT_LOCK' => 0,
                'BIT_FLG_DEL' => $budget->BIT_FLG_DEL,
                'BIT_UNBUDGET' => $budget->BIT_UNBUDGET,
                'CHR_CREATE_BY' => $budget->CHR_CREATE_BY,
                'CHR_CREATE_DATE' => $budget->CHR_CREATE_DATE,
                'CHR_CREATE_TIME' => $budget->CHR_CREATE_TIME,
                'CHR_MODI_BY' => $session['USERNAME'],
                'CHR_MODI_DATE' => date('Ymd'),
                'CHR_MODI_TIME' => date('His')
            );
            $this->budget_expense_m->save_expense($data_head);
            foreach ($rev_budgets_details as $budget_detail) {
                if ($x == 'e') {
                    $var = "DEC_MONEY_EXPENSE";
                    $val = $budget_detail->DEC_MONEY_EXPENSE;
                } else {
                    $var = "INT_QUANTITY";
                    $val = $budget_detail->INT_QUANTITY;
                }
                $data_detail = array(
                    'INT_NO_BUDGET_EXP' => $budget_detail->INT_NO_BUDGET_EXP,
                    'INT_REVISE' => $next_rev,
                    'INT_MONTH_PLAN' => $budget_detail->INT_MONTH_PLAN,
                    $var => $val,
                    'BIT_FLG_DEL' => $budget_detail->BIT_FLG_DEL,
                    'CHR_MODI_BY' => $session['USERNAME'],
                    'CHR_MODI_DATE' => date('Ymd'),
                    'CHR_MODI_TIME' => date('His')
                );
                $this->budget_expense_m->save_expense_detail($data_detail, $x);
            }
        }
        $this->log_m->add_log($log, $id);
        $this->db->trans_complete();
        $this->prepare_approve_expense('7');
    }

    function unlock_expense($id) {
//bit lock 1->0
// reject => lock = 1
//now reject => lock = 0
        $session = $this->session->all_userdata();
        $user = $this->user_m->get_user_org($session['NPK']);
        switch ($session['ROLE']) {
            case 1:
                $log = $admin_unlock;
                break;
            case 3://unl on div
                $log = 98;
                break;
            case 4://unl on gdept
                $log = 96;
                if (!$this->check_if_admin()) {
                    $org = $this->groupdept_m->get_gdept_id($id);
                    if ($org->INT_ID_GROUP_DEPT != $user->INT_ID_GROUP_DEPT) {
                        $this->log_m->add_log(133, $id);
                        redirect('fail_c/auth');
                    }
                }
                break;
            case 5://unl on dept
                $log = 83;
                if (!$this->check_if_admin()) {
                    $org = $this->dept_m->get_dept_id($id);
                    if ($org->INT_ID_DEPT != $user->INT_ID_DEPT) {
                        $this->log_m->add_log(130, $id);
                        redirect('fail_c/auth');
                    }
                }
                break;
            default:
                break;
        }
        $this->db->trans_start();
        $fiscal = $this->fiscal_m->get_id_fiscal_this_year();
        $this->budget_expense_m->unlock_expense($id, $fiscal);
        $this->log_m->add_log($log, $id);
        $this->db->trans_complete();
        $this->prepare_approve_expense('8');
    }

    private function check_if_admin() {
        $session = $this->session->all_userdata();
        if ($session['ROLE'] == 1 or $session['ROLE'] == 2) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function commit_expense($id, $admin_commit = NULL) {
        $session = $this->session->all_userdata();
        $user = $this->user_m->get_user_org($session['NPK']);
        $fiscal = $this->fiscal_m->get_id_fiscal_this_year();

        switch ($session['ROLE']) {
            case 1:
                $log = $admin_commit;
                break;
            case 2://com admin
                $log = 114;
                break;
            case 3://com div
                $log = 81;
                if (!$this->check_if_admin()) {
                    if ($id != $user->INT_ID_DIVISION) {
                        $this->log_m->add_log(137, $id);
                        redirect('fail_c/auth');
                    }
                }
                break;
            case 4://com gdept
                $log = 79;
                if (!$this->check_if_admin()) {
                    if ($id != $user->INT_ID_GROUP_DEPT) {
                        $this->log_m->add_log(134, $id);
                        redirect('fail_c/auth');
                    }
                }

                break;
            case 5://com dept
                $log = 77;
                if (!$this->check_if_admin()) {
                    if ($id != $user->INT_ID_DEPT) {
                        $this->log_m->add_log(131, $id);
                        redirect('fail_c/auth');
                    }
                }
                break;
            case 6://com sect
                if (!$this->check_if_admin()) {
                    if ($session['SECTION'] != $id) {
                        $this->log_m->add_log(128, $id);
                        redirect('fail_c/auth');
                    }
                }
                $log = 75;
                break;
            default:
                break;
        }
        $this->db->trans_start();
        $this->budget_expense_m->commit_expense($id, $fiscal);
        if ($session['ROLE'] == 2) {
            $final_expenses = $this->budget_expense_m->get_final_expense($id, $fiscal);
            foreach ($final_expenses as $final) {
                $data_final = array(
                    'INT_NO_BUDGET' => $final->INT_NO_BUDGET_EXP,
                    'INT_NO_BUDGET_EXP' => $final->INT_NO_BUDGET_EXP,
                    'INT_NO_BUDGET_CPX' => NULL,
                    'INT_REVISE' => $final->INT_REVISE,
                    'INT_ID_FISCAL_YEAR' => $final->INT_ID_FISCAL_YEAR,
                    'INT_ID_SECTION' => $final->INT_ID_SECTION,
                    'INT_ID_BUDGET_SUB_CATEGORY' => $final->INT_ID_BUDGET_SUB_CATEGORY,
                    'INT_ID_UNIT' => $final->INT_ID_UNIT,
                    'CHR_BUDGET_NAME' => $final->CHR_BUDGET_NAME,
                    'DEC_TOTAL' => $final->DEC_TOTAL,
                    'BIT_FLG_CPX' => 0
                );
                $this->budget_expense_m->save_final_expense($data_final);
//                if ($this->budget_expense_m->is_pure_expense($final->INT_NO_BUDGET_EXP)) {
//                    $x = 'e';
//                } else {
//                    $x = 's';
//                }
//                $com_budgets_details = $this->budget_expense_m->get_reject_detail($final->INT_NO_BUDGET_EXP, $final->INT_REVISE, $x);
//
//                foreach ($com_budgets_details as $budget_detail) {
//                    if ($x == 'e') {
//                        $var = "DEC_MONEY_EXPENSE";
//                        $val = $budget_detail->DEC_MONEY_EXPENSE;
//                    } else {
//                        $var = "INT_QUANTITY";
//                        $val = $budget_detail->INT_QUANTITY;
//                    }
//                    $data_detail = array(
//                        'INT_NO_BUDGET_EXP' => $budget_detail->INT_NO_BUDGET_EXP,
//                        'INT_MONTH_PLAN' => $budget_detail->INT_MONTH_PLAN,
//                        $var => $val,
//                        'CHR_MODI_BY' => $session['USERNAME'],
//                        'CHR_MODI_DATE' => date('Ymd'),
//                        'CHR_MODI_TIME' => date('His')
//                    );
//                    $this->budget_expense_m->save_expense_detail_for_pureq($data_detail, $x);
//                }
            }
        }
        $this->log_m->add_log($log, $id);
        $this->db->trans_complete();
        if ($session['ROLE'] == 6) {
            $this->index('5');
        } else {
            $this->prepare_approve_expense('5');
        }
    }

    function report_planning_expense($msg = null) {
        
    }

    function download_template($budget_type) {
        $this->load->helper('download');
        $budget_desc = $this->budgettype_m->get_budget_type($budget_type);
        $budget_desc_value = trim($budget_desc->CHR_BUDGET_TYPE_DESC);
        $budget_desc_value = str_replace(" ", "_", $budget_desc_value);

        ob_clean();
        $name = "Template_$budget_desc_value.xls";
        // echo $name;
        // exit();
        $data = file_get_contents("assets/template/budget/Template_$budget_desc_value.xls");

        force_download($name, $data);
    }

    function upload_budget_expense() {
        $this->load->helper(array('form', 'url', 'inflector'));
        $this->load->library(array('PHPExcel', 'PHPExcel/IOFactory'));
        $INT_ID_FISCAL_YEAR = $this->input->post("INT_ID_FISCAL_YEAR");
        $INT_ID_FISCAL_YEAR = substr($INT_ID_FISCAL_YEAR, 0, 4);
        $INT_DEPT = $this->input->post("INT_ID_DEPT");
        $INT_SECT = $this->input->post("INT_ID_SECT");
        $INT_ID_BUDGET_TYPE = $this->input->post("INT_ID_BUDGET_TYPE");
        $CHR_BUDGET_TYPE_DESC = $this->budgettype_m->get_budget_type($INT_ID_BUDGET_TYPE);
        $CHR_BUDGET_TYPE = trim($CHR_BUDGET_TYPE_DESC->CHR_BUDGET_TYPE);
        $CHR_BUDGET_TYPE_DESC = trim($CHR_BUDGET_TYPE_DESC->CHR_BUDGET_TYPE_DESC);
        $budget_type_desc_format = str_replace(" ", "_", $CHR_BUDGET_TYPE_DESC);
        $get_gm_div = $this->dept_m->get_gm_div($INT_DEPT)->row();
        $INT_DIV = $get_gm_div->INT_ID_DIVISION;

        $this->budget_expense_m->delete_existing_template($CHR_BUDGET_TYPE, $INT_DIV, $INT_DEPT, $INT_SECT);

        $upload_date = date('Ymd');
        $fileName = $_FILES['upload_budget_expense']['name'];
        if (empty($fileName)) {
            redirect($this->back_to_upload . $msg = 12);
        }

        $config['upload_path'] = './assets/file/budget_expense/';
        $config['file_name'] = $fileName;
        $config['allowed_types'] = 'xls|xlsx';
        $config['max_size'] = 10000;

        $this->load->library('upload');
        $this->upload->initialize($config);
        if ($a = $this->upload->do_upload('upload_budget_expense'))
            $this->upload->display_errors();
        $media = $this->upload->data('upload_budget_expense');

        if (strpos($media['file_name'], str_replace(" ", "_", $CHR_BUDGET_TYPE_DESC)) === false) {
            redirect($this->back_to_upload . $msg = 16);
        }

        $inputFileName = './assets/file/budget_expense/' . $media['file_name'];

        try {
            $inputFileType = IOFactory::identify($inputFileName);
            $objReader = IOFactory::createReader($inputFileType);
            $objPHPExcel = $objReader->load($inputFileName);
        } catch (Exception $e) {
            die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' . $e->getMessage());
        }

        $sheet = $objPHPExcel->getSheet(0);
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();
        $rowHeader = $sheet->rangeToArray('A1:CV1', NULL, TRUE, FALSE);
        $budget_type_template = strtolower($rowHeader[0][99]);
        if ($budget_type_template !== strtolower($CHR_BUDGET_TYPE_DESC)) {
            redirect($this->back_to_upload . $msg = 17);
        }
        $get_gm_div = $this->dept_m->get_gm_div($INT_DEPT)->row();
        $INT_GROUP_DEPT = $get_gm_div->INT_ID_GROUP_DEPT;
        $INT_DIV = $get_gm_div->INT_ID_DIVISION;

        for ($row = 3; $row <= $highestRow; $row++) {
            $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);

            $CHR_BUDGET_SUB_CATEGORY = $rowData[0][1];
            $CHR_BUDGET_SUB_CATEGORY_DESC = $rowData[0][2];
            $CHR_BUDGET_CATEGORY = $rowData[0][3];
            $CHR_BUDGET_CATEGORY_DESC = $rowData[0][4];
            $CHR_CODE_CATEGORY_A3 = $rowData[0][5];
            $CHR_CODE_CATEGORY_A3_DESC = $rowData[0][6];

            if ($CHR_BUDGET_SUB_CATEGORY == NULL || $CHR_BUDGET_SUB_CATEGORY == "" || $CHR_BUDGET_SUB_CATEGORY_DESC == NULL || $CHR_BUDGET_SUB_CATEGORY_DESC == "") {
                redirect($this->back_to_upload . $msg = 21);
            }

            $cek_sub_cat = $this->budget_expense_m->cek_match_sub_category(trim($CHR_BUDGET_SUB_CATEGORY), trim($CHR_BUDGET_SUB_CATEGORY_DESC));
            if($cek_sub_cat == 0){
                echo trim('Kolom B'.$row.' : <b>'. $CHR_BUDGET_SUB_CATEGORY . '</b> Bermasalah <br>');
                echo trim('Kolom C'.$row.' : <b>'. $CHR_BUDGET_SUB_CATEGORY_DESC . '</b> Bermasalah');
                exit();
            }
            
            if ($CHR_BUDGET_CATEGORY == NULL || $CHR_BUDGET_CATEGORY == "" || $CHR_BUDGET_CATEGORY_DESC == NULL || $CHR_BUDGET_CATEGORY_DESC == "") {
                redirect($this->back_to_upload . $msg = 20);
            }

            $cek_cat = $this->budget_expense_m->cek_match_category(trim($CHR_BUDGET_CATEGORY), trim($CHR_BUDGET_CATEGORY_DESC));
            if($cek_cat == 0){
                echo trim('Kolom D'.$row.' : <b>'. $CHR_BUDGET_CATEGORY . '</b> Bermasalah <br>');
                echo trim('Kolom E'.$row.' : <b>'. $CHR_BUDGET_CATEGORY_DESC . '</b> Bermasalah');
                exit();
            }
           
            if ($CHR_CODE_CATEGORY_A3 == NULL || $CHR_CODE_CATEGORY_A3 == "" || $CHR_CODE_CATEGORY_A3_DESC == NULL || $CHR_CODE_CATEGORY_A3_DESC == "") {
                redirect($this->back_to_upload . $msg = 19);
            }

            $cek_cat_a3 = $this->budget_expense_m->cek_match_category_a3(trim($CHR_CODE_CATEGORY_A3), trim($CHR_CODE_CATEGORY_A3_DESC));
            if($cek_cat_a3 == 0){
                echo trim('Kolom F'.$row.' : <b>'. $CHR_CODE_CATEGORY_A3 . '</b> Bermasalah <br>');
                echo trim('Kolom G'.$row.' : <b>'. $CHR_CODE_CATEGORY_A3_DESC . '</b> Bermasalah');
                exit();
            }
            
            if ($INT_ID_BUDGET_TYPE == 25) {
                $CHR_PURPOSE = "";
            } else {
                $CHR_PURPOSE = $rowData[0][7];
            }
//=============================== end common data =============================== 
            $CHR_BUDGET_DESC = "";
            $CHR_ITEM_DESC = "";
            $CHR_SATUAN = "";
            $CHR_ORG_CURR = "";
            $FLT_RATE_CURR = "";
            $FLT_PRICE_CURR = "";
            $CHR_PART_NO = "";
            $CHR_KIND_OF = "";
            $CHR_SHIFT = "";
            $CHR_PROJECT_NAME = "";
            $CHR_PERIODE = "";
            $CHR_ITEM_RENT = "";
            $CHR_SUPPLIER_NAME = "";
            $CHR_CATEGORY_PRODUCT = "";

            $INT_QTY_BLN04 = "0";
            $MON_AMT_BLN04 = "0";
            $INT_QTY_BLN05 = "0";
            $MON_AMT_BLN05 = "0";
            $INT_QTY_BLN06 = "0";
            $MON_AMT_BLN06 = "0";
            $INT_QTY_BLN07 = "0";
            $MON_AMT_BLN07 = "0";
            $INT_QTY_BLN08 = "0";
            $MON_AMT_BLN08 = "0";
            $INT_QTY_BLN09 = "0";
            $MON_AMT_BLN09 = "0";
            $INT_QTY_BLN10 = "0";
            $MON_AMT_BLN10 = "0";
            $INT_QTY_BLN11 = "0";
            $MON_AMT_BLN11 = "0";
            $INT_QTY_BLN12 = "0";
            $MON_AMT_BLN12 = "0";
            $INT_QTY_BLN01 = "0";
            $MON_AMT_BLN01 = "0";
            $INT_QTY_BLN02 = "0";
            $MON_AMT_BLN02 = "0";
            $INT_QTY_BLN03 = "0";
            $MON_AMT_BLN03 = "0";
            $FLT_ADD_BLN01 = "0";
            $FLT_ADD_BLN02 = "0";
            $FLT_ADD_BLN03 = "0";
            $FLT_ADD_BLN04 = "0";
            $FLT_ADD_BLN05 = "0";
            $FLT_ADD_BLN06 = "0";
            $FLT_ADD_BLN07 = "0";
            $FLT_ADD_BLN08 = "0";
            $FLT_ADD_BLN09 = "0";
            $FLT_ADD_BLN10 = "0";
            $FLT_ADD_BLN11 = "0";
            $FLT_ADD_BLN12 = "0";

            $INT_QTY_SUM = "0";
            $MON_AMT_SUM = "0";
            $FLT_ADD_SUM = "0";

//===============================   DONATION   =============================== 
            if ($INT_ID_BUDGET_TYPE === "3") {
                $CHR_ITEM_DESC = $rowData[0][8];
                $CHR_KIND_OF = $rowData[0][9];
                $CHR_CATEGORY_PRODUCT = $rowData[0][10];
                $CHR_SATUAN = $rowData[0][11];
                $CHR_ORG_CURR = $rowData[0][12];
                $FLT_RATE_CURR = str_replace(",", ".", $rowData[0][13]);
                $FLT_PRICE_CURR = $rowData[0][14];

                $INT_QTY_BLN04 = $rowData[0][15];
                $MON_AMT_BLN04 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN04;
                $INT_QTY_BLN05 = $rowData[0][17];
                $MON_AMT_BLN05 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN05;
                $INT_QTY_BLN06 = $rowData[0][19];
                $MON_AMT_BLN06 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN06;
                $INT_QTY_BLN07 = $rowData[0][21];
                $MON_AMT_BLN07 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN07;
                $INT_QTY_BLN08 = $rowData[0][23];
                $MON_AMT_BLN08 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN08;
                $INT_QTY_BLN09 = $rowData[0][25];
                $MON_AMT_BLN09 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN09;
                $INT_QTY_BLN10 = $rowData[0][27];
                $MON_AMT_BLN10 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN10;
                $INT_QTY_BLN11 = $rowData[0][29];
                $MON_AMT_BLN11 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN11;
                $INT_QTY_BLN12 = $rowData[0][31];
                $MON_AMT_BLN12 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN12;
                $INT_QTY_BLN01 = $rowData[0][33];
                $MON_AMT_BLN01 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN01;
                $INT_QTY_BLN02 = $rowData[0][35];
                $MON_AMT_BLN02 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN02;
                $INT_QTY_BLN03 = $rowData[0][37];
                $MON_AMT_BLN03 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN03;
                $INT_QTY_SUM = $rowData[0][39];
                $MON_AMT_SUM = $MON_AMT_BLN04 + $MON_AMT_BLN05 + $MON_AMT_BLN06 + $MON_AMT_BLN07 + $MON_AMT_BLN08 + $MON_AMT_BLN09 + $MON_AMT_BLN10 + $MON_AMT_BLN11 + $MON_AMT_BLN12 + $MON_AMT_BLN01 + $MON_AMT_BLN02 + $MON_AMT_BLN03;
//=============================== END DONATION =============================== 
//===============================   EMPLOYEE WELFARE   =============================== 
            } else if ($INT_ID_BUDGET_TYPE === "4") {
                $CHR_SHIFT = $rowData[0][8];
                $CHR_PERIODE = $rowData[0][9];
                $CHR_KIND_OF = $rowData[0][10];
                $CHR_CATEGORY_PRODUCT = $rowData[0][11];
                $CHR_ITEM_DESC = $rowData[0][12];
                $CHR_SATUAN = $rowData[0][13];
                $CHR_ORG_CURR = $rowData[0][14];
                $FLT_RATE_CURR = str_replace(",", ".", $rowData[0][15]);
                $FLT_PRICE_CURR = $rowData[0][16];


                $INT_QTY_BLN04 = $rowData[0][17];
                $FLT_ADD_BLN04 = $rowData[0][18];
                $MON_AMT_BLN04 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN04 * $FLT_ADD_BLN04;
                $INT_QTY_BLN05 = $rowData[0][20];
                $FLT_ADD_BLN05 = $rowData[0][21];
                $MON_AMT_BLN05 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN05 * $FLT_ADD_BLN05;
                $INT_QTY_BLN06 = $rowData[0][23];
                $FLT_ADD_BLN06 = $rowData[0][24];
                $MON_AMT_BLN06 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN06 * $FLT_ADD_BLN06;
                $INT_QTY_BLN07 = $rowData[0][26];
                $FLT_ADD_BLN07 = $rowData[0][27];
                $MON_AMT_BLN07 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN07 * $FLT_ADD_BLN07;
                $INT_QTY_BLN08 = $rowData[0][29];
                $FLT_ADD_BLN08 = $rowData[0][30];
                $MON_AMT_BLN08 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN08 * $FLT_ADD_BLN08;
                $INT_QTY_BLN09 = $rowData[0][32];
                $FLT_ADD_BLN09 = $rowData[0][33];
                $MON_AMT_BLN09 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN09 * $FLT_ADD_BLN09;
                $INT_QTY_BLN10 = $rowData[0][35];
                $FLT_ADD_BLN10 = $rowData[0][36];
                $MON_AMT_BLN10 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN10 * $FLT_ADD_BLN10;
                $INT_QTY_BLN11 = $rowData[0][38];
                $FLT_ADD_BLN11 = $rowData[0][39];
                $MON_AMT_BLN11 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN11 * $FLT_ADD_BLN11;
                $INT_QTY_BLN12 = $rowData[0][41];
                $FLT_ADD_BLN12 = $rowData[0][42];
                $MON_AMT_BLN12 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN12 * $FLT_ADD_BLN12;
                $INT_QTY_BLN01 = $rowData[0][44];
                $FLT_ADD_BLN01 = $rowData[0][45];
                $MON_AMT_BLN01 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN01 * $FLT_ADD_BLN01;
                $INT_QTY_BLN02 = $rowData[0][47];
                $FLT_ADD_BLN02 = $rowData[0][48];
                $MON_AMT_BLN02 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN02 * $FLT_ADD_BLN02;
                $INT_QTY_BLN03 = $rowData[0][50];
                $FLT_ADD_BLN03 = $rowData[0][51];
                $MON_AMT_BLN03 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN03 * $FLT_ADD_BLN03;
                $INT_QTY_SUM = $rowData[0][53];
                $FLT_ADD_SUM = $rowData[0][54];
                $MON_AMT_SUM = $MON_AMT_BLN04 + $MON_AMT_BLN05 + $MON_AMT_BLN06 + $MON_AMT_BLN07 + $MON_AMT_BLN08 + $MON_AMT_BLN09 + $MON_AMT_BLN10 + $MON_AMT_BLN11 + $MON_AMT_BLN12 + $MON_AMT_BLN01 + $MON_AMT_BLN02 + $MON_AMT_BLN03;
//=============================== END EMPLOYEE WELFARE =============================== 
//===============================   CONSUMABLE   =============================== 
            } else if ($INT_ID_BUDGET_TYPE === "2") {
                $CHR_PART_NO = $rowData[0][8];
                $CHR_ITEM_DESC = $rowData[0][9];
                $CHR_SATUAN = $rowData[0][10];
                $CHR_CATEGORY_PRODUCT = $rowData[0][11];
                $CHR_ORG_CURR = $rowData[0][12];
                $FLT_RATE_CURR = str_replace(",", ".", $rowData[0][13]);
                $FLT_PRICE_CURR = $rowData[0][14];


                $INT_QTY_BLN04 = $rowData[0][15];
                $MON_AMT_BLN04 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN04;
                $INT_QTY_BLN05 = $rowData[0][17];
                $MON_AMT_BLN05 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN05;
                $INT_QTY_BLN06 = $rowData[0][19];
                $MON_AMT_BLN06 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN06;
                $INT_QTY_BLN07 = $rowData[0][21];
                $MON_AMT_BLN07 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN07;
                $INT_QTY_BLN08 = $rowData[0][23];
                $MON_AMT_BLN08 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN08;
                $INT_QTY_BLN09 = $rowData[0][25];
                $MON_AMT_BLN09 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN09;
                $INT_QTY_BLN10 = $rowData[0][27];
                $MON_AMT_BLN10 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN10;
                $INT_QTY_BLN11 = $rowData[0][29];
                $MON_AMT_BLN11 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN11;
                $INT_QTY_BLN12 = $rowData[0][31];
                $MON_AMT_BLN12 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN12;
                $INT_QTY_BLN01 = $rowData[0][33];
                $MON_AMT_BLN01 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN01;
                $INT_QTY_BLN02 = $rowData[0][35];
                $MON_AMT_BLN02 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN02;
                $INT_QTY_BLN03 = $rowData[0][37];
                $MON_AMT_BLN03 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN03;
                $INT_QTY_SUM = $rowData[0][39];
                $MON_AMT_SUM = $MON_AMT_BLN04 + $MON_AMT_BLN05 + $MON_AMT_BLN06 + $MON_AMT_BLN07 + $MON_AMT_BLN08 + $MON_AMT_BLN09 + $MON_AMT_BLN10 + $MON_AMT_BLN11 + $MON_AMT_BLN12 + $MON_AMT_BLN01 + $MON_AMT_BLN02 + $MON_AMT_BLN03;
//=============================== END CONSUMABLE =============================== 
//===============================   IT EXPENSES   =============================== 
            } else if ($INT_ID_BUDGET_TYPE === "7") {
                $CHR_ITEM_DESC = $rowData[0][8];
                $CHR_PERIODE = $rowData[0][9];
                $CHR_CATEGORY_PRODUCT = $rowData[0][10];
                $CHR_SATUAN = $rowData[0][11];
                $CHR_ORG_CURR = $rowData[0][12];
                $FLT_RATE_CURR = str_replace(",", ".", $rowData[0][13]);
                $FLT_PRICE_CURR = $rowData[0][14];


                $INT_QTY_BLN04 = $rowData[0][15];
                $MON_AMT_BLN04 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN04;
                $INT_QTY_BLN05 = $rowData[0][17];
                $MON_AMT_BLN05 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN05;
                $INT_QTY_BLN06 = $rowData[0][19];
                $MON_AMT_BLN06 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN06;
                $INT_QTY_BLN07 = $rowData[0][21];
                $MON_AMT_BLN07 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN07;
                $INT_QTY_BLN08 = $rowData[0][23];
                $MON_AMT_BLN08 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN08;
                $INT_QTY_BLN09 = $rowData[0][25];
                $MON_AMT_BLN09 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN09;
                $INT_QTY_BLN10 = $rowData[0][27];
                $MON_AMT_BLN10 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN10;
                $INT_QTY_BLN11 = $rowData[0][29];
                $MON_AMT_BLN11 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN11;
                $INT_QTY_BLN12 = $rowData[0][31];
                $MON_AMT_BLN12 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN12;
                $INT_QTY_BLN01 = $rowData[0][33];
                $MON_AMT_BLN01 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN01;
                $INT_QTY_BLN02 = $rowData[0][35];
                $MON_AMT_BLN02 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN02;
                $INT_QTY_BLN03 = $rowData[0][37];
                $MON_AMT_BLN03 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN03;
                $INT_QTY_SUM = $rowData[0][39];
                $MON_AMT_SUM = $MON_AMT_BLN04 + $MON_AMT_BLN05 + $MON_AMT_BLN06 + $MON_AMT_BLN07 + $MON_AMT_BLN08 + $MON_AMT_BLN09 + $MON_AMT_BLN10 + $MON_AMT_BLN11 + $MON_AMT_BLN12 + $MON_AMT_BLN01 + $MON_AMT_BLN02 + $MON_AMT_BLN03;
//=============================== END IT EXPENSES =============================== 
//===============================   OFFICE EQUIPMENT   =============================== 
            } else if ($INT_ID_BUDGET_TYPE === "9") {
                $CHR_ITEM_DESC = $rowData[0][8];
                $CHR_CATEGORY_PRODUCT = $rowData[0][9];
                $CHR_SATUAN = $rowData[0][10];
                $CHR_ORG_CURR = $rowData[0][11];
                $FLT_RATE_CURR = str_replace(",", ".", $rowData[0][12]);
                $FLT_PRICE_CURR = $rowData[0][13];


                $INT_QTY_BLN04 = $rowData[0][14];
                $MON_AMT_BLN04 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN04;
                $INT_QTY_BLN05 = $rowData[0][16];
                $MON_AMT_BLN05 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN05;
                $INT_QTY_BLN06 = $rowData[0][18];
                $MON_AMT_BLN06 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN06;
                $INT_QTY_BLN07 = $rowData[0][20];
                $MON_AMT_BLN07 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN07;
                $INT_QTY_BLN08 = $rowData[0][22];
                $MON_AMT_BLN08 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN08;
                $INT_QTY_BLN09 = $rowData[0][24];
                $MON_AMT_BLN09 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN09;
                $INT_QTY_BLN10 = $rowData[0][26];
                $MON_AMT_BLN10 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN10;
                $INT_QTY_BLN11 = $rowData[0][28];
                $MON_AMT_BLN11 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN11;
                $INT_QTY_BLN12 = $rowData[0][30];
                $MON_AMT_BLN12 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN12;
                $INT_QTY_BLN01 = $rowData[0][32];
                $MON_AMT_BLN01 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN01;
                $INT_QTY_BLN02 = $rowData[0][34];
                $MON_AMT_BLN02 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN02;
                $INT_QTY_BLN03 = $rowData[0][36];
                $MON_AMT_BLN03 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN03;
                $INT_QTY_SUM = $rowData[0][38];
                $MON_AMT_SUM = $MON_AMT_BLN04 + $MON_AMT_BLN05 + $MON_AMT_BLN06 + $MON_AMT_BLN07 + $MON_AMT_BLN08 + $MON_AMT_BLN09 + $MON_AMT_BLN10 + $MON_AMT_BLN11 + $MON_AMT_BLN12 + $MON_AMT_BLN01 + $MON_AMT_BLN02 + $MON_AMT_BLN03;
//=============================== END OFFICE EQUIPMENT =============================== 
//===============================   RENTAL EXPENSES   =============================== 
            } else if ($INT_ID_BUDGET_TYPE === "11") {
                $CHR_ITEM_DESC = $rowData[0][8];
                $CHR_ITEM_RENT = $rowData[0][9];
                $CHR_CATEGORY_PRODUCT = $rowData[0][10];
                $CHR_SATUAN = $rowData[0][11];
                $CHR_ORG_CURR = $rowData[0][12];
                $FLT_RATE_CURR = str_replace(",", ".", $rowData[0][13]);
                $FLT_PRICE_CURR = $rowData[0][14];


                $INT_QTY_BLN04 = $rowData[0][15];
                $MON_AMT_BLN04 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN04;
                $INT_QTY_BLN05 = $rowData[0][17];
                $MON_AMT_BLN05 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN05;
                $INT_QTY_BLN06 = $rowData[0][19];
                $MON_AMT_BLN06 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN06;
                $INT_QTY_BLN07 = $rowData[0][21];
                $MON_AMT_BLN07 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN07;
                $INT_QTY_BLN08 = $rowData[0][23];
                $MON_AMT_BLN08 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN08;
                $INT_QTY_BLN09 = $rowData[0][25];
                $MON_AMT_BLN09 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN09;
                $INT_QTY_BLN10 = $rowData[0][27];
                $MON_AMT_BLN10 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN10;
                $INT_QTY_BLN11 = $rowData[0][29];
                $MON_AMT_BLN11 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN11;
                $INT_QTY_BLN12 = $rowData[0][31];
                $MON_AMT_BLN12 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN12;
                $INT_QTY_BLN01 = $rowData[0][33];
                $MON_AMT_BLN01 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN01;
                $INT_QTY_BLN02 = $rowData[0][35];
                $MON_AMT_BLN02 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN02;
                $INT_QTY_BLN03 = $rowData[0][37];
                $MON_AMT_BLN03 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN03;
                $INT_QTY_SUM = $rowData[0][39];
                $MON_AMT_SUM = $MON_AMT_BLN04 + $MON_AMT_BLN05 + $MON_AMT_BLN06 + $MON_AMT_BLN07 + $MON_AMT_BLN08 + $MON_AMT_BLN09 + $MON_AMT_BLN10 + $MON_AMT_BLN11 + $MON_AMT_BLN12 + $MON_AMT_BLN01 + $MON_AMT_BLN02 + $MON_AMT_BLN03;
//=============================== END RENTAL EXPENSES =============================== 
//===============================   REPAIR AND MAINTENANCE   =============================== 
            } else if ($INT_ID_BUDGET_TYPE === "12") {
                $CHR_ITEM_DESC = $rowData[0][8];
                $CHR_SATUAN = $rowData[0][9];
                $CHR_ORG_CURR = $rowData[0][10];
                $FLT_RATE_CURR = str_replace(",", ".", $rowData[0][11]);
                $FLT_PRICE_CURR = $rowData[0][12];


                $INT_QTY_BLN04 = $rowData[0][13];
                $MON_AMT_BLN04 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN04;
                $INT_QTY_BLN05 = $rowData[0][15];
                $MON_AMT_BLN05 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN05;
                $INT_QTY_BLN06 = $rowData[0][17];
                $MON_AMT_BLN06 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN06;
                $INT_QTY_BLN07 = $rowData[0][19];
                $MON_AMT_BLN07 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN07;
                $INT_QTY_BLN08 = $rowData[0][21];
                $MON_AMT_BLN08 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN08;
                $INT_QTY_BLN09 = $rowData[0][23];
                $MON_AMT_BLN09 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN09;
                $INT_QTY_BLN10 = $rowData[0][25];
                $MON_AMT_BLN10 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN10;
                $INT_QTY_BLN11 = $rowData[0][27];
                $MON_AMT_BLN11 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN11;
                $INT_QTY_BLN12 = $rowData[0][29];
                $MON_AMT_BLN12 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN12;
                $INT_QTY_BLN01 = $rowData[0][31];
                $MON_AMT_BLN01 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN01;
                $INT_QTY_BLN02 = $rowData[0][33];
                $MON_AMT_BLN02 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN02;
                $INT_QTY_BLN03 = $rowData[0][35];
                $MON_AMT_BLN03 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN03;
                $INT_QTY_SUM = $rowData[0][37];
                $MON_AMT_SUM = $MON_AMT_BLN04 + $MON_AMT_BLN05 + $MON_AMT_BLN06 + $MON_AMT_BLN07 + $MON_AMT_BLN08 + $MON_AMT_BLN09 + $MON_AMT_BLN10 + $MON_AMT_BLN11 + $MON_AMT_BLN12 + $MON_AMT_BLN01 + $MON_AMT_BLN02 + $MON_AMT_BLN03;
//=============================== END REPAIR AND MAINTENANCE =============================== 
//===============================   RESEARCH AND DEVELOPMENT   =============================== 
            } else if ($INT_ID_BUDGET_TYPE === "13") {
                $CHR_ITEM_DESC = $rowData[0][8];
                $CHR_KIND_OF = $rowData[0][9];
                $CHR_CATEGORY_PRODUCT = $rowData[0][10];
                $CHR_SATUAN = $rowData[0][11];
                $CHR_ORG_CURR = $rowData[0][12];
                $FLT_RATE_CURR = str_replace(",", ".", $rowData[0][13]);
                $FLT_PRICE_CURR = $rowData[0][14];


                $INT_QTY_BLN04 = $rowData[0][15];
                $MON_AMT_BLN04 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN04;
                $INT_QTY_BLN05 = $rowData[0][17];
                $MON_AMT_BLN05 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN05;
                $INT_QTY_BLN06 = $rowData[0][19];
                $MON_AMT_BLN06 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN06;
                $INT_QTY_BLN07 = $rowData[0][21];
                $MON_AMT_BLN07 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN07;
                $INT_QTY_BLN08 = $rowData[0][23];
                $MON_AMT_BLN08 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN08;
                $INT_QTY_BLN09 = $rowData[0][25];
                $MON_AMT_BLN09 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN09;
                $INT_QTY_BLN10 = $rowData[0][27];
                $MON_AMT_BLN10 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN10;
                $INT_QTY_BLN11 = $rowData[0][29];
                $MON_AMT_BLN11 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN11;
                $INT_QTY_BLN12 = $rowData[0][31];
                $MON_AMT_BLN12 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN12;
                $INT_QTY_BLN01 = $rowData[0][33];
                $MON_AMT_BLN01 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN01;
                $INT_QTY_BLN02 = $rowData[0][35];
                $MON_AMT_BLN02 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN02;
                $INT_QTY_BLN03 = $rowData[0][37];
                $MON_AMT_BLN03 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN03;
                $INT_QTY_SUM = $rowData[0][39];
                $MON_AMT_SUM = $MON_AMT_BLN04 + $MON_AMT_BLN05 + $MON_AMT_BLN06 + $MON_AMT_BLN07 + $MON_AMT_BLN08 + $MON_AMT_BLN09 + $MON_AMT_BLN10 + $MON_AMT_BLN11 + $MON_AMT_BLN12 + $MON_AMT_BLN01 + $MON_AMT_BLN02 + $MON_AMT_BLN03;
//=============================== END RESEARCH AND DEVELOPMENT =============================== 
//===============================   SUBCONTRACTOR COST   =============================== 
            } else if ($INT_ID_BUDGET_TYPE === "15") {
                $CHR_PART_NO = $rowData[0][8];
                $CHR_ITEM_DESC = $rowData[0][9];
                $CHR_SUPPLIER_NAME = $rowData[0][10];
                $CHR_SATUAN = $rowData[0][11];
                $CHR_CATEGORY_PRODUCT = $rowData[0][12];
                $CHR_ORG_CURR = $rowData[0][13];
                $FLT_RATE_CURR = str_replace(",", ".", $rowData[0][14]);
                $FLT_PRICE_CURR = $rowData[0][15];


                $INT_QTY_BLN04 = $rowData[0][16];
                $MON_AMT_BLN04 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN04;
                $INT_QTY_BLN05 = $rowData[0][18];
                $MON_AMT_BLN05 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN05;
                $INT_QTY_BLN06 = $rowData[0][20];
                $MON_AMT_BLN06 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN06;
                $INT_QTY_BLN07 = $rowData[0][22];
                $MON_AMT_BLN07 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN07;
                $INT_QTY_BLN08 = $rowData[0][24];
                $MON_AMT_BLN08 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN08;
                $INT_QTY_BLN09 = $rowData[0][26];
                $MON_AMT_BLN09 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN09;
                $INT_QTY_BLN10 = $rowData[0][28];
                $MON_AMT_BLN10 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN10;
                $INT_QTY_BLN11 = $rowData[0][30];
                $MON_AMT_BLN11 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN11;
                $INT_QTY_BLN12 = $rowData[0][32];
                $MON_AMT_BLN12 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN12;
                $INT_QTY_BLN01 = $rowData[0][34];
                $MON_AMT_BLN01 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN01;
                $INT_QTY_BLN02 = $rowData[0][36];
                $MON_AMT_BLN02 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN02;
                $INT_QTY_BLN03 = $rowData[0][38];
                $MON_AMT_BLN03 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN03;
                $INT_QTY_SUM = $rowData[0][40];
                $MON_AMT_SUM = $MON_AMT_BLN04 + $MON_AMT_BLN05 + $MON_AMT_BLN06 + $MON_AMT_BLN07 + $MON_AMT_BLN08 + $MON_AMT_BLN09 + $MON_AMT_BLN10 + $MON_AMT_BLN11 + $MON_AMT_BLN12 + $MON_AMT_BLN01 + $MON_AMT_BLN02 + $MON_AMT_BLN03;
//=============================== END SUBCONTRACTOR COST =============================== 
//===============================   TOOLS AND EQUIPMENT   =============================== 
            } else if ($INT_ID_BUDGET_TYPE === "16") {
                $CHR_ITEM_DESC = $rowData[0][8];
                $CHR_SATUAN = $rowData[0][9];
                $CHR_ORG_CURR = $rowData[0][10];
                $FLT_RATE_CURR = str_replace(",", ".", $rowData[0][11]);
                $FLT_PRICE_CURR = $rowData[0][12];


                $INT_QTY_BLN04 = $rowData[0][13];
                $MON_AMT_BLN04 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN04;
                $INT_QTY_BLN05 = $rowData[0][15];
                $MON_AMT_BLN05 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN05;
                $INT_QTY_BLN06 = $rowData[0][17];
                $MON_AMT_BLN06 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN06;
                $INT_QTY_BLN07 = $rowData[0][19];
                $MON_AMT_BLN07 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN07;
                $INT_QTY_BLN08 = $rowData[0][21];
                $MON_AMT_BLN08 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN08;
                $INT_QTY_BLN09 = $rowData[0][23];
                $MON_AMT_BLN09 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN09;
                $INT_QTY_BLN10 = $rowData[0][25];
                $MON_AMT_BLN10 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN10;
                $INT_QTY_BLN11 = $rowData[0][27];
                $MON_AMT_BLN11 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN11;
                $INT_QTY_BLN12 = $rowData[0][29];
                $MON_AMT_BLN12 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN12;
                $INT_QTY_BLN01 = $rowData[0][31];
                $MON_AMT_BLN01 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN01;
                $INT_QTY_BLN02 = $rowData[0][33];
                $MON_AMT_BLN02 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN02;
                $INT_QTY_BLN03 = $rowData[0][35];
                $MON_AMT_BLN03 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN03;
                $INT_QTY_SUM = $rowData[0][37];
                $MON_AMT_SUM = $MON_AMT_BLN04 + $MON_AMT_BLN05 + $MON_AMT_BLN06 + $MON_AMT_BLN07 + $MON_AMT_BLN08 + $MON_AMT_BLN09 + $MON_AMT_BLN10 + $MON_AMT_BLN11 + $MON_AMT_BLN12 + $MON_AMT_BLN01 + $MON_AMT_BLN02 + $MON_AMT_BLN03;
//=============================== END TOOLS AND EQUIPMENT =============================== 
//===============================   TRAINING   =============================== 
            } else if ($INT_ID_BUDGET_TYPE === "17") {
                $CHR_ITEM_DESC = $rowData[0][8];
                $CHR_KIND_OF = $rowData[0][9];
                $CHR_CATEGORY_PRODUCT = $rowData[0][10];
                $CHR_SATUAN = $rowData[0][11];
                $CHR_ORG_CURR = $rowData[0][12];
                $FLT_RATE_CURR = str_replace(",", ".", $rowData[0][13]);
                $FLT_PRICE_CURR = $rowData[0][14];


                $INT_QTY_BLN04 = $rowData[0][15];
                $MON_AMT_BLN04 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN04;
                $INT_QTY_BLN05 = $rowData[0][17];
                $MON_AMT_BLN05 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN05;
                $INT_QTY_BLN06 = $rowData[0][19];
                $MON_AMT_BLN06 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN06;
                $INT_QTY_BLN07 = $rowData[0][21];
                $MON_AMT_BLN07 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN07;
                $INT_QTY_BLN08 = $rowData[0][23];
                $MON_AMT_BLN08 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN08;
                $INT_QTY_BLN09 = $rowData[0][25];
                $MON_AMT_BLN09 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN09;
                $INT_QTY_BLN10 = $rowData[0][27];
                $MON_AMT_BLN10 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN10;
                $INT_QTY_BLN11 = $rowData[0][29];
                $MON_AMT_BLN11 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN11;
                $INT_QTY_BLN12 = $rowData[0][31];
                $MON_AMT_BLN12 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN12;
                $INT_QTY_BLN01 = $rowData[0][33];
                $MON_AMT_BLN01 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN01;
                $INT_QTY_BLN02 = $rowData[0][35];
                $MON_AMT_BLN02 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN02;
                $INT_QTY_BLN03 = $rowData[0][37];
                $MON_AMT_BLN03 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN03;
                $INT_QTY_SUM = $rowData[0][39];
                $MON_AMT_SUM = $MON_AMT_BLN04 + $MON_AMT_BLN05 + $MON_AMT_BLN06 + $MON_AMT_BLN07 + $MON_AMT_BLN08 + $MON_AMT_BLN09 + $MON_AMT_BLN10 + $MON_AMT_BLN11 + $MON_AMT_BLN12 + $MON_AMT_BLN01 + $MON_AMT_BLN02 + $MON_AMT_BLN03;
//=============================== END TRAINING =============================== 
//===============================   TRIAL AND INSPECTION COST   =============================== 
            } else if ($INT_ID_BUDGET_TYPE === "18") {
                $CHR_ITEM_DESC = $rowData[0][8];
                $CHR_PROJECT_NAME = $rowData[0][9];
                $CHR_CATEGORY_PRODUCT = $rowData[0][10];
                $CHR_SATUAN = $rowData[0][11];
                $CHR_ORG_CURR = $rowData[0][12];
                $FLT_RATE_CURR = str_replace(",", ".", $rowData[0][13]);
                $FLT_PRICE_CURR = $rowData[0][14];


                $INT_QTY_BLN04 = $rowData[0][15];
                $MON_AMT_BLN04 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN04;
                $INT_QTY_BLN05 = $rowData[0][17];
                $MON_AMT_BLN05 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN05;
                $INT_QTY_BLN06 = $rowData[0][19];
                $MON_AMT_BLN06 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN06;
                $INT_QTY_BLN07 = $rowData[0][21];
                $MON_AMT_BLN07 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN07;
                $INT_QTY_BLN08 = $rowData[0][23];
                $MON_AMT_BLN08 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN08;
                $INT_QTY_BLN09 = $rowData[0][25];
                $MON_AMT_BLN09 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN09;
                $INT_QTY_BLN10 = $rowData[0][27];
                $MON_AMT_BLN10 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN10;
                $INT_QTY_BLN11 = $rowData[0][29];
                $MON_AMT_BLN11 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN11;
                $INT_QTY_BLN12 = $rowData[0][31];
                $MON_AMT_BLN12 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN12;
                $INT_QTY_BLN01 = $rowData[0][33];
                $MON_AMT_BLN01 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN01;
                $INT_QTY_BLN02 = $rowData[0][35];
                $MON_AMT_BLN02 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN02;
                $INT_QTY_BLN03 = $rowData[0][37];
                $MON_AMT_BLN03 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN03;
                $INT_QTY_SUM = $rowData[0][39];
                $MON_AMT_SUM = $MON_AMT_BLN04 + $MON_AMT_BLN05 + $MON_AMT_BLN06 + $MON_AMT_BLN07 + $MON_AMT_BLN08 + $MON_AMT_BLN09 + $MON_AMT_BLN10 + $MON_AMT_BLN11 + $MON_AMT_BLN12 + $MON_AMT_BLN01 + $MON_AMT_BLN02 + $MON_AMT_BLN03;
//=============================== END TRIAL AND INSPECTION COST =============================== 
//===============================   UTILITY   =============================== 
            } else if ($INT_ID_BUDGET_TYPE === "22") {
                $CHR_ITEM_DESC = $rowData[0][8];
                $CHR_CATEGORY_PRODUCT = $rowData[0][9];
                $CHR_SATUAN = $rowData[0][10];
                $CHR_ORG_CURR = $rowData[0][11];
                $FLT_RATE_CURR = str_replace(",", ".", $rowData[0][12]);
                $FLT_PRICE_CURR = $rowData[0][13];


                $INT_QTY_BLN04 = $rowData[0][14];
                $MON_AMT_BLN04 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN04;
                $INT_QTY_BLN05 = $rowData[0][16];
                $MON_AMT_BLN05 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN05;
                $INT_QTY_BLN06 = $rowData[0][18];
                $MON_AMT_BLN06 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN06;
                $INT_QTY_BLN07 = $rowData[0][20];
                $MON_AMT_BLN07 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN07;
                $INT_QTY_BLN08 = $rowData[0][22];
                $MON_AMT_BLN08 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN08;
                $INT_QTY_BLN09 = $rowData[0][24];
                $MON_AMT_BLN09 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN09;
                $INT_QTY_BLN10 = $rowData[0][26];
                $MON_AMT_BLN10 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN10;
                $INT_QTY_BLN11 = $rowData[0][28];
                $MON_AMT_BLN11 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN11;
                $INT_QTY_BLN12 = $rowData[0][30];
                $MON_AMT_BLN12 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN12;
                $INT_QTY_BLN01 = $rowData[0][32];
                $MON_AMT_BLN01 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN01;
                $INT_QTY_BLN02 = $rowData[0][34];
                $MON_AMT_BLN02 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN02;
                $INT_QTY_BLN03 = $rowData[0][36];
                $MON_AMT_BLN03 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN03;
                $INT_QTY_SUM = $rowData[0][38];
                $MON_AMT_SUM = $MON_AMT_BLN04 + $MON_AMT_BLN05 + $MON_AMT_BLN06 + $MON_AMT_BLN07 + $MON_AMT_BLN08 + $MON_AMT_BLN09 + $MON_AMT_BLN10 + $MON_AMT_BLN11 + $MON_AMT_BLN12 + $MON_AMT_BLN01 + $MON_AMT_BLN02 + $MON_AMT_BLN03;
//=============================== END UTILITY =============================== 
//===============================   BUSINESS AND TRAVEL   =============================== 
            } else if ($INT_ID_BUDGET_TYPE === "24") {
                $CHR_CATEGORY_PRODUCT = $rowData[0][8];
                $CHR_ITEM_DESC = $rowData[0][9];
                $CHR_SATUAN = $rowData[0][10];
                $CHR_ORG_CURR = $rowData[0][11];
                $FLT_RATE_CURR = str_replace(",", ".", $rowData[0][12]);
                $FLT_PRICE_CURR = $rowData[0][13];


                $INT_QTY_BLN04 = $rowData[0][14];
                $MON_AMT_BLN04 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN04;
                $INT_QTY_BLN05 = $rowData[0][16];
                $MON_AMT_BLN05 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN05;
                $INT_QTY_BLN06 = $rowData[0][18];
                $MON_AMT_BLN06 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN06;
                $INT_QTY_BLN07 = $rowData[0][20];
                $MON_AMT_BLN07 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN07;
                $INT_QTY_BLN08 = $rowData[0][22];
                $MON_AMT_BLN08 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN08;
                $INT_QTY_BLN09 = $rowData[0][24];
                $MON_AMT_BLN09 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN09;
                $INT_QTY_BLN10 = $rowData[0][26];
                $MON_AMT_BLN10 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN10;
                $INT_QTY_BLN11 = $rowData[0][28];
                $MON_AMT_BLN11 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN11;
                $INT_QTY_BLN12 = $rowData[0][30];
                $MON_AMT_BLN12 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN12;
                $INT_QTY_BLN01 = $rowData[0][32];
                $MON_AMT_BLN01 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN01;
                $INT_QTY_BLN02 = $rowData[0][34];
                $MON_AMT_BLN02 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN02;
                $INT_QTY_BLN03 = $rowData[0][36];
                $MON_AMT_BLN03 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN03;
                $INT_QTY_SUM = $rowData[0][38];
                $MON_AMT_SUM = $MON_AMT_BLN04 + $MON_AMT_BLN05 + $MON_AMT_BLN06 + $MON_AMT_BLN07 + $MON_AMT_BLN08 + $MON_AMT_BLN09 + $MON_AMT_BLN10 + $MON_AMT_BLN11 + $MON_AMT_BLN12 + $MON_AMT_BLN01 + $MON_AMT_BLN02 + $MON_AMT_BLN03;
//=============================== END BUSINESS AND TRAVEL =============================== 
//===============================   SALARY   =============================== 
            } else if ($INT_ID_BUDGET_TYPE === "25") {
                $CHR_ITEM_DESC = $rowData[0][7];
                $CHR_SATUAN = $rowData[0][8];
                $CHR_ORG_CURR = $rowData[0][9];
                $FLT_RATE_CURR = str_replace(",", ".", $rowData[0][10]);


                $INT_QTY_BLN04 = $rowData[0][11];
                $FLT_ADD_BLN04 = $rowData[0][12];
                $MON_AMT_BLN04 = $FLT_RATE_CURR * $FLT_ADD_BLN04 * $INT_QTY_BLN04;
                $INT_QTY_BLN05 = $rowData[0][14];
                $FLT_ADD_BLN05 = $rowData[0][15];
                $MON_AMT_BLN05 = $FLT_RATE_CURR * $FLT_ADD_BLN05 * $INT_QTY_BLN05;
                $INT_QTY_BLN06 = $rowData[0][17];
                $FLT_ADD_BLN06 = $rowData[0][18];
                $MON_AMT_BLN06 = $FLT_RATE_CURR * $FLT_ADD_BLN06 * $INT_QTY_BLN06;
                $INT_QTY_BLN07 = $rowData[0][20];
                $FLT_ADD_BLN07 = $rowData[0][21];
                $MON_AMT_BLN07 = $FLT_RATE_CURR * $FLT_ADD_BLN07 * $INT_QTY_BLN07;
                $INT_QTY_BLN08 = $rowData[0][23];
                $FLT_ADD_BLN08 = $rowData[0][24];
                $MON_AMT_BLN08 = $FLT_RATE_CURR * $FLT_ADD_BLN08 * $INT_QTY_BLN08;
                $INT_QTY_BLN09 = $rowData[0][26];
                $FLT_ADD_BLN09 = $rowData[0][27];
                $MON_AMT_BLN09 = $FLT_RATE_CURR * $FLT_ADD_BLN09 * $INT_QTY_BLN09;
                $INT_QTY_BLN10 = $rowData[0][29];
                $FLT_ADD_BLN10 = $rowData[0][30];
                $MON_AMT_BLN10 = $FLT_RATE_CURR * $FLT_ADD_BLN10 * $INT_QTY_BLN10;
                $INT_QTY_BLN11 = $rowData[0][32];
                $FLT_ADD_BLN11 = $rowData[0][33];
                $MON_AMT_BLN11 = $FLT_RATE_CURR * $FLT_ADD_BLN11 * $INT_QTY_BLN11;
                $INT_QTY_BLN12 = $rowData[0][35];
                $FLT_ADD_BLN12 = $rowData[0][36];
                $MON_AMT_BLN12 = $FLT_RATE_CURR * $FLT_ADD_BLN12 * $INT_QTY_BLN12;
                $INT_QTY_BLN01 = $rowData[0][38];
                $FLT_ADD_BLN01 = $rowData[0][39];
                $MON_AMT_BLN01 = $FLT_RATE_CURR * $FLT_ADD_BLN01 * $INT_QTY_BLN01;
                $INT_QTY_BLN02 = $rowData[0][41];
                $FLT_ADD_BLN02 = $rowData[0][42];
                $MON_AMT_BLN02 = $FLT_RATE_CURR * $FLT_ADD_BLN02 * $INT_QTY_BLN02;
                $INT_QTY_BLN03 = $rowData[0][44];
                $FLT_ADD_BLN03 = $rowData[0][45];
                $MON_AMT_BLN03 = $FLT_RATE_CURR * $FLT_ADD_BLN03 * $INT_QTY_BLN03;
                $INT_QTY_SUM = $rowData[0][47];
                $FLT_ADD_SUM = $rowData[0][48];
                $MON_AMT_SUM = $MON_AMT_BLN04 + $MON_AMT_BLN05 + $MON_AMT_BLN06 + $MON_AMT_BLN07 + $MON_AMT_BLN08 + $MON_AMT_BLN09 + $MON_AMT_BLN10 + $MON_AMT_BLN11 + $MON_AMT_BLN12 + $MON_AMT_BLN01 + $MON_AMT_BLN02 + $MON_AMT_BLN03;
//=============================== END SALARY =============================== 
//===============================   TECHNICAL FEE   =============================== 
            } else if ($INT_ID_BUDGET_TYPE === "29") {
                $CHR_ITEM_DESC = $rowData[0][8];
                $CHR_PROJECT_NAME = $rowData[0][9];
                $CHR_CATEGORY_PRODUCT = $rowData[0][10];
                $CHR_SATUAN = $rowData[0][11];
                $CHR_ORG_CURR = $rowData[0][12];
                $FLT_RATE_CURR = str_replace(",", ".", $rowData[0][13]);
                $FLT_PRICE_CURR = $rowData[0][14];


                $INT_QTY_BLN04 = $rowData[0][15];
                $MON_AMT_BLN04 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN04;
                $INT_QTY_BLN05 = $rowData[0][17];
                $MON_AMT_BLN05 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN05;
                $INT_QTY_BLN06 = $rowData[0][19];
                $MON_AMT_BLN06 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN06;
                $INT_QTY_BLN07 = $rowData[0][21];
                $MON_AMT_BLN07 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN07;
                $INT_QTY_BLN08 = $rowData[0][23];
                $MON_AMT_BLN08 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN08;
                $INT_QTY_BLN09 = $rowData[0][25];
                $MON_AMT_BLN09 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN09;
                $INT_QTY_BLN10 = $rowData[0][27];
                $MON_AMT_BLN10 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN10;
                $INT_QTY_BLN11 = $rowData[0][29];
                $MON_AMT_BLN11 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN11;
                $INT_QTY_BLN12 = $rowData[0][31];
                $MON_AMT_BLN12 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN12;
                $INT_QTY_BLN01 = $rowData[0][33];
                $MON_AMT_BLN01 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN01;
                $INT_QTY_BLN02 = $rowData[0][35];
                $MON_AMT_BLN02 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN02;
                $INT_QTY_BLN03 = $rowData[0][37];
                $MON_AMT_BLN03 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN03;
                $INT_QTY_SUM = $rowData[0][39];
                $MON_AMT_SUM = $MON_AMT_BLN04 + $MON_AMT_BLN05 + $MON_AMT_BLN06 + $MON_AMT_BLN07 + $MON_AMT_BLN08 + $MON_AMT_BLN09 + $MON_AMT_BLN10 + $MON_AMT_BLN11 + $MON_AMT_BLN12 + $MON_AMT_BLN01 + $MON_AMT_BLN02 + $MON_AMT_BLN03;
//=============================== END TECHNICAL FEE =============================== 
//===============================   LEGAL PERSONAL   =============================== 
            } else if ($INT_ID_BUDGET_TYPE === "39") {
                $CHR_ITEM_DESC = $rowData[0][8];
                $CHR_CATEGORY_PRODUCT = $rowData[0][9];
                $CHR_SATUAN = $rowData[0][10];
                $CHR_ORG_CURR = $rowData[0][11];
                $FLT_RATE_CURR = str_replace(",", ".", $rowData[0][12]);
                $FLT_PRICE_CURR = $rowData[0][13];


                $INT_QTY_BLN04 = $rowData[0][14];
                $MON_AMT_BLN04 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN04;
                $INT_QTY_BLN05 = $rowData[0][16];
                $MON_AMT_BLN05 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN05;
                $INT_QTY_BLN06 = $rowData[0][18];
                $MON_AMT_BLN06 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN06;
                $INT_QTY_BLN07 = $rowData[0][20];
                $MON_AMT_BLN07 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN07;
                $INT_QTY_BLN08 = $rowData[0][22];
                $MON_AMT_BLN08 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN08;
                $INT_QTY_BLN09 = $rowData[0][24];
                $MON_AMT_BLN09 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN09;
                $INT_QTY_BLN10 = $rowData[0][26];
                $MON_AMT_BLN10 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN10;
                $INT_QTY_BLN11 = $rowData[0][28];
                $MON_AMT_BLN11 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN11;
                $INT_QTY_BLN12 = $rowData[0][30];
                $MON_AMT_BLN12 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN12;
                $INT_QTY_BLN01 = $rowData[0][32];
                $MON_AMT_BLN01 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN01;
                $INT_QTY_BLN02 = $rowData[0][34];
                $MON_AMT_BLN02 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN02;
                $INT_QTY_BLN03 = $rowData[0][36];
                $MON_AMT_BLN03 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN03;
                $INT_QTY_SUM = $rowData[0][38];
                $MON_AMT_SUM = $MON_AMT_BLN04 + $MON_AMT_BLN05 + $MON_AMT_BLN06 + $MON_AMT_BLN07 + $MON_AMT_BLN08 + $MON_AMT_BLN09 + $MON_AMT_BLN10 + $MON_AMT_BLN11 + $MON_AMT_BLN12 + $MON_AMT_BLN01 + $MON_AMT_BLN02 + $MON_AMT_BLN03;
//=============================== END LEGAL PERSONAL =============================== 
//===============================   ENTERTAINMENT EXPENSES   =============================== 
            } else if ($INT_ID_BUDGET_TYPE === "41") {
                $CHR_ITEM_DESC = $rowData[0][8];
                $CHR_CATEGORY_PRODUCT = $rowData[0][9];
                $CHR_SATUAN = $rowData[0][10];
                $CHR_ORG_CURR = $rowData[0][11];
                $FLT_RATE_CURR = str_replace(",", ".", $rowData[0][12]);
                $FLT_PRICE_CURR = $rowData[0][13];


                $INT_QTY_BLN04 = $rowData[0][14];
                $MON_AMT_BLN04 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN04;
                $INT_QTY_BLN05 = $rowData[0][16];
                $MON_AMT_BLN05 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN05;
                $INT_QTY_BLN06 = $rowData[0][18];
                $MON_AMT_BLN06 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN06;
                $INT_QTY_BLN07 = $rowData[0][20];
                $MON_AMT_BLN07 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN07;
                $INT_QTY_BLN08 = $rowData[0][22];
                $MON_AMT_BLN08 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN08;
                $INT_QTY_BLN09 = $rowData[0][24];
                $MON_AMT_BLN09 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN09;
                $INT_QTY_BLN10 = $rowData[0][26];
                $MON_AMT_BLN10 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN10;
                $INT_QTY_BLN11 = $rowData[0][28];
                $MON_AMT_BLN11 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN11;
                $INT_QTY_BLN12 = $rowData[0][30];
                $MON_AMT_BLN12 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN12;
                $INT_QTY_BLN01 = $rowData[0][32];
                $MON_AMT_BLN01 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN01;
                $INT_QTY_BLN02 = $rowData[0][34];
                $MON_AMT_BLN02 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN02;
                $INT_QTY_BLN03 = $rowData[0][36];
                $MON_AMT_BLN03 = $FLT_RATE_CURR * $FLT_PRICE_CURR * $INT_QTY_BLN03;
                $INT_QTY_SUM = $rowData[0][38];
                $MON_AMT_SUM = $MON_AMT_BLN04 + $MON_AMT_BLN05 + $MON_AMT_BLN06 + $MON_AMT_BLN07 + $MON_AMT_BLN08 + $MON_AMT_BLN09 + $MON_AMT_BLN10 + $MON_AMT_BLN11 + $MON_AMT_BLN12 + $MON_AMT_BLN01 + $MON_AMT_BLN02 + $MON_AMT_BLN03;
//=============================== END ENTERTAINMENT EXPENSES =============================== 
//===============================   END   =============================== 
            }

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
                'CHR_PURPOSE' => $CHR_PURPOSE,
                'CHR_BUDGET_DESC' => $CHR_BUDGET_DESC,
                'CHR_ITEM_DESC' => $CHR_ITEM_DESC,
                'CHR_SATUAN' => $CHR_SATUAN,
                'CHR_PART_NO' => $CHR_PART_NO,
                'CHR_KIND_OF' => $CHR_KIND_OF,
                'CHR_SHIFT' => $CHR_SHIFT,
                'CHR_ITEM_RENT' => $CHR_ITEM_RENT,
                'CHR_PROJECT_NAME' => $CHR_PROJECT_NAME,
                'CHR_PERIODE' => $CHR_PERIODE,
                'CHR_SUPPLIER_NAME' => $CHR_SUPPLIER_NAME,
                'CHR_ORG_CURR' => $CHR_ORG_CURR,
                'FLT_RATE_CURR' => $FLT_RATE_CURR,
                'FLT_PRICE_CURR' => $FLT_PRICE_CURR,
                'INT_QTY_BLN01' => $INT_QTY_BLN01,
                'INT_QTY_BLN02' => $INT_QTY_BLN02,
                'INT_QTY_BLN03' => $INT_QTY_BLN03,
                'INT_QTY_BLN04' => $INT_QTY_BLN04,
                'INT_QTY_BLN05' => $INT_QTY_BLN05,
                'INT_QTY_BLN06' => $INT_QTY_BLN06,
                'INT_QTY_BLN07' => $INT_QTY_BLN07,
                'INT_QTY_BLN08' => $INT_QTY_BLN08,
                'INT_QTY_BLN09' => $INT_QTY_BLN09,
                'INT_QTY_BLN10' => $INT_QTY_BLN10,
                'INT_QTY_BLN11' => $INT_QTY_BLN11,
                'INT_QTY_BLN12' => $INT_QTY_BLN12,
                'MON_AMT_BLN01' => $MON_AMT_BLN01,
                'MON_AMT_BLN02' => $MON_AMT_BLN02,
                'MON_AMT_BLN03' => $MON_AMT_BLN03,
                'MON_AMT_BLN04' => $MON_AMT_BLN04,
                'MON_AMT_BLN05' => $MON_AMT_BLN05,
                'MON_AMT_BLN06' => $MON_AMT_BLN06,
                'MON_AMT_BLN07' => $MON_AMT_BLN07,
                'MON_AMT_BLN08' => $MON_AMT_BLN08,
                'MON_AMT_BLN09' => $MON_AMT_BLN09,
                'MON_AMT_BLN10' => $MON_AMT_BLN10,
                'MON_AMT_BLN11' => $MON_AMT_BLN11,
                'MON_AMT_BLN12' => $MON_AMT_BLN12,
                'FLT_ADD_BLN01' => $FLT_ADD_BLN01,
                'FLT_ADD_BLN02' => $FLT_ADD_BLN02,
                'FLT_ADD_BLN03' => $FLT_ADD_BLN03,
                'FLT_ADD_BLN04' => $FLT_ADD_BLN04,
                'FLT_ADD_BLN05' => $FLT_ADD_BLN05,
                'FLT_ADD_BLN06' => $FLT_ADD_BLN06,
                'FLT_ADD_BLN07' => $FLT_ADD_BLN07,
                'FLT_ADD_BLN08' => $FLT_ADD_BLN08,
                'FLT_ADD_BLN09' => $FLT_ADD_BLN09,
                'FLT_ADD_BLN10' => $FLT_ADD_BLN10,
                'FLT_ADD_BLN11' => $FLT_ADD_BLN11,
                'FLT_ADD_BLN12' => $FLT_ADD_BLN12,
                'INT_SECT' => $INT_SECT,
                'INT_DEPT' => $INT_DEPT,
                'INT_GROUP_DEPT' => $INT_GROUP_DEPT,
                'INT_DIV' => $INT_DIV,
                'INT_QTY_SUM' => $INT_QTY_SUM,
                'MON_AMT_SUM' => $MON_AMT_SUM,
                'FLT_ADD_SUM' => $FLT_ADD_SUM,
                'CHR_CATEGORY_PRODUCT_DESC' => $CHR_CATEGORY_PRODUCT
            );
//SAVE TO DATABASE
            $this->budget_expense_m->save_temp($data);
        }

        redirect("budget/budget_expense_c/confirmation_budget_expense/$INT_ID_FISCAL_YEAR/$INT_ID_BUDGET_TYPE/$INT_DIV/$INT_DEPT/$INT_SECT/$CHR_BUDGET_TYPE", "REFRESH");
    }

    function confirmation_budget_expense($INT_ID_FISCAL_YEAR, $INT_ID_BUDGET_TYPE, $INT_DIV, $INT_DEPT, $INT_SECT, $CHR_BUDGET_TYPE) {
        $user_session = $this->session->all_userdata();

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(19);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Confirmation Budget Expense';
        $data['subcontent'] = NULL;
        if ($INT_ID_BUDGET_TYPE == '3') { //== DONATION
            $data['content'] = 'budget/budget_expense/confirmation_budget_expense_v';
        } else if ($INT_ID_BUDGET_TYPE == '4') { //== EMPLOYEE WELFARE
            $data['content'] = 'budget/budget_expense/confirmation_budget_expense_empwa_v';
        } else if ($INT_ID_BUDGET_TYPE == '2') { //== CONSUMABLE
            $data['content'] = 'budget/budget_expense/confirmation_budget_expense_consu_v';
        } else if ($INT_ID_BUDGET_TYPE == '7') { //== IT EXPENSE
            $data['content'] = 'budget/budget_expense/confirmation_budget_expense_itexp_v';
        } else if ($INT_ID_BUDGET_TYPE == '9') { //== OFFICE EXPENSE
            $data['content'] = 'budget/budget_expense/confirmation_budget_expense_offeq_v';
        } else if ($INT_ID_BUDGET_TYPE == '11') { //== RENTAL EXPENSE
            $data['content'] = 'budget/budget_expense/confirmation_budget_expense_renta_v';
        } else if ($INT_ID_BUDGET_TYPE == '12') { //== REPAIR & MAINTENANCE
            $data['content'] = 'budget/budget_expense/confirmation_budget_expense_repma_v';
        } else if ($INT_ID_BUDGET_TYPE == '13') { //== RESEARCH & DEVELOPMENT
            $data['content'] = 'budget/budget_expense/confirmation_budget_expense_rndev_v';
        } else if ($INT_ID_BUDGET_TYPE == '15') { //== SUBCONTRACTOR COST
            $data['content'] = 'budget/budget_expense/confirmation_budget_expense_subco_v';
        } else if ($INT_ID_BUDGET_TYPE == '16') { //== TOOLS & EQUIPMENT
            $data['content'] = 'budget/budget_expense/confirmation_budget_expense_tooeq_v';
        } else if ($INT_ID_BUDGET_TYPE == '17') { //== TRAINING
            $data['content'] = 'budget/budget_expense/confirmation_budget_expense_train_v';
        } else if ($INT_ID_BUDGET_TYPE == '18') { //== TRIAL & INSPECTION
            $data['content'] = 'budget/budget_expense/confirmation_budget_expense_trial_v';
        } else if ($INT_ID_BUDGET_TYPE == '22') { //== UTILITY
            $data['content'] = 'budget/budget_expense/confirmation_budget_expense_utily_v';
        } else if ($INT_ID_BUDGET_TYPE == '24') { //== BUSINESS & TRAVEL
            $data['content'] = 'budget/budget_expense/confirmation_budget_expense_travl_v';
        } else if ($INT_ID_BUDGET_TYPE == '25') { //== SALARY
            $data['content'] = 'budget/budget_expense/confirmation_budget_expense_salry_v';
        } else if ($INT_ID_BUDGET_TYPE == '29') { //== TECHNICAL FEE
            $data['content'] = 'budget/budget_expense/confirmation_budget_expense_tecfe_v';
        } else if ($INT_ID_BUDGET_TYPE == '39') { //== LEGAL PERSONAL
            $data['content'] = 'budget/budget_expense/confirmation_budget_expense_legpr_v';
        } else if ($INT_ID_BUDGET_TYPE == '41') { //== ENTERTAINMENT
            $data['content'] = 'budget/budget_expense/confirmation_budget_expense_enter_v';
        }

        $data['INT_ID_FISCAL_YEAR'] = $INT_ID_FISCAL_YEAR;
        $data['INT_ID_BUDGET_TYPE'] = $INT_ID_BUDGET_TYPE;
        $data['INT_DIV'] = $INT_DIV;
        $data['INT_DEPT'] = $INT_DEPT;
        $data['INT_SECT'] = $INT_SECT;
        $data['CHR_BUDGET_TYPE'] = $CHR_BUDGET_TYPE;

        $data['CHR_FISCAL_YEAR'] = $this->fiscal_m->select_fiscal_year($INT_ID_FISCAL_YEAR);
        $data['CHR_BUDGET_TYPE_DESC'] = $this->budgettype_m->get_desc_budgettype($INT_ID_BUDGET_TYPE);
        $data['CHR_DEPT_DESC'] = $this->dept_m->get_name_dept($INT_DEPT);
        $data['CHR_SECTION_DESC'] = $this->section_m->get_desc_section($INT_SECT);
        $data['detail_confirm'] = $this->budget_expense_m->get_detail_confirm_expense($INT_ID_FISCAL_YEAR, $CHR_BUDGET_TYPE, $INT_DIV, $INT_DEPT, $INT_SECT);
        $data['SUM_AMT'] = $this->budget_expense_m->get_sum_amt_confirm_expense($INT_ID_FISCAL_YEAR, $CHR_BUDGET_TYPE, $INT_DIV, $INT_DEPT, $INT_SECT);
        $data['detail_confirm_sum'] = $this->budget_expense_m->get_sum_confirm_expense($INT_ID_FISCAL_YEAR, $CHR_BUDGET_TYPE, $INT_DIV, $INT_DEPT, $INT_SECT);
        $this->load->view($this->layout, $data);
    }

    function save_budget($INT_ID_FISCAL_YEAR, $INT_ID_BUDGET_TYPE, $INT_DIV, $INT_DEPT, $INT_SECT, $CHR_BUDGET_TYPE, $CHR_STAT_REV) {
        $user_session = $this->session->all_userdata();
        $CHR_CREATE_BY = $user_session['USERNAME'];
        $CHR_CREATE_DATE = date("Ymd");
        $CHR_CREATE_TIME = date("his");

//DELETE BUDGET TYPE FOR FISCAL YEAR 
        $this->budget_expense_m->delete_existing_budget($INT_ID_FISCAL_YEAR, $INT_ID_BUDGET_TYPE, $INT_DIV, $INT_DEPT, $INT_SECT, $CHR_BUDGET_TYPE, $CHR_STAT_REV);

//CHECK SEQUNCE BUDGET NUMBER
//GET BUDGET NUMBER
//SAVE DATA FROM TABLE WORK TO TABLE TRANSACTION
        $detail_budget = $this->budget_expense_m->get_detail_confirm_expense($INT_ID_FISCAL_YEAR, $CHR_BUDGET_TYPE, $INT_DIV, $INT_DEPT, $INT_SECT);
//ASSIGN TO ARRAY
        foreach ($detail_budget as $value) {
            $CHR_NO_BUDGET = $this->budget_expense_m->get_no_budget($INT_ID_FISCAL_YEAR, $INT_ID_BUDGET_TYPE, $INT_DIV, $INT_DEPT, $INT_SECT, $CHR_BUDGET_TYPE, $CHR_STAT_REV);
            $data = array(
                'CHR_NO_BUDGET' => $CHR_NO_BUDGET,
                'CHR_STAT_REV' => $CHR_STAT_REV,
                'CHR_CREATE_BY' => $CHR_CREATE_BY,
                'CHR_CREATE_DATE' => $CHR_CREATE_DATE,
                'CHR_CREATE_TIME' => $CHR_CREATE_TIME,
                'INT_ID_FISCAL_YEAR' => $value->INT_ID_FISCAL_YEAR,
                'CHR_BUDGET_TYPE' => $value->CHR_BUDGET_TYPE,
                'CHR_BUDGET_TYPE_DESC' => $value->CHR_BUDGET_TYPE_DESC,
                'CHR_BUDGET_SUB_CATEGORY' => $value->CHR_BUDGET_SUB_CATEGORY,
                'CHR_BUDGET_SUB_CATEGORY_DESC' => $value->CHR_BUDGET_SUB_CATEGORY_DESC,
                'CHR_BUDGET_CATEGORY' => $value->CHR_BUDGET_CATEGORY,
                'CHR_BUDGET_CATEGORY_DESC' => $value->CHR_BUDGET_CATEGORY_DESC,
                'CHR_CODE_CATEGORY_A3' => $value->CHR_CODE_CATEGORY_A3,
                'CHR_CODE_CATEGORY_A3_DESC' => $value->CHR_CODE_CATEGORY_A3_DESC,
                'CHR_PURPOSE' => $value->CHR_PURPOSE,
                'CHR_BUDGET_DESC' => $value->CHR_BUDGET_DESC,
                'CHR_ITEM_DESC' => $value->CHR_ITEM_DESC,
                'CHR_SATUAN' => $value->CHR_SATUAN,
                'CHR_PART_NO' => $value->CHR_PART_NO,
                'CHR_KIND_OF' => $value->CHR_KIND_OF,
                'CHR_SHIFT' => $value->CHR_SHIFT,
                'CHR_ITEM_RENT' => $value->CHR_ITEM_RENT,
                'CHR_PROJECT_NAME' => $value->CHR_PROJECT_NAME,
                'CHR_PERIODE' => $value->CHR_PERIODE,
                'CHR_SUPPLIER_NAME' => $value->CHR_SUPPLIER_NAME,
                'CHR_ORG_CURR' => $value->CHR_ORG_CURR,
                'FLT_RATE_CURR' => $value->FLT_RATE_CURR,
                'FLT_PRICE_CURR' => $value->FLT_PRICE_CURR,
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
                'FLT_ADD_BLN01' => $value->FLT_ADD_BLN01,
                'FLT_ADD_BLN02' => $value->FLT_ADD_BLN02,
                'FLT_ADD_BLN03' => $value->FLT_ADD_BLN03,
                'FLT_ADD_BLN04' => $value->FLT_ADD_BLN04,
                'FLT_ADD_BLN05' => $value->FLT_ADD_BLN05,
                'FLT_ADD_BLN06' => $value->FLT_ADD_BLN06,
                'FLT_ADD_BLN07' => $value->FLT_ADD_BLN07,
                'FLT_ADD_BLN08' => $value->FLT_ADD_BLN08,
                'FLT_ADD_BLN09' => $value->FLT_ADD_BLN09,
                'FLT_ADD_BLN10' => $value->FLT_ADD_BLN10,
                'FLT_ADD_BLN11' => $value->FLT_ADD_BLN11,
                'FLT_ADD_BLN12' => $value->FLT_ADD_BLN12,
                'FLT_ADD_SUM' => $value->FLT_ADD_SUM,
                'INT_SECT' => $value->INT_SECT,
                'INT_DEPT' => $value->INT_DEPT,
                'INT_GROUP_DEPT' => $value->INT_GROUP_DEPT,
                'INT_DIV' => $value->INT_DIV,
                'CHR_CATEGORY_PRODUCT_DESC' => $value->CHR_CATEGORY_PRODUCT_DESC
            );
            $this->budget_expense_m->save($data);
        }

//GET DETAIL BUDGET
        $data['detail_confirm'] = $this->budget_expense_m->get_detail_confirm_expense($INT_ID_FISCAL_YEAR, $CHR_BUDGET_TYPE, $INT_DIV, $INT_DEPT, $INT_SECT);

//GET SUM AMOUNT
        $data['SUM_AMT'] = $this->budget_expense_m->get_sum_amt_confirm_expense($INT_ID_FISCAL_YEAR, $CHR_BUDGET_TYPE, $INT_DIV, $INT_DEPT, $INT_SECT);

        redirect("budget/budget_expense_c/create_expense/1/$INT_ID_FISCAL_YEAR/$INT_ID_BUDGET_TYPE/$INT_DIV/$INT_DEPT/$INT_SECT/$CHR_BUDGET_TYPE", "REFRESH");
        $this->load->view($this->layout, $data);
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
        $url_iframe = site_url("budget/budget_expense_c/refresh_table_page/1/$INT_ID_FISCAL_YEAR/$INT_BUDGET_TYPE/$INT_DIV/$INT_DEPT/$INT_SECT/$CHR_BUDGET_TYPE");
        //Download Excel per Dept
        $url_export_excel = site_url("budget/budget_expense_c/download_excel/$INT_ID_FISCAL_YEAR/$INT_BUDGET_TYPE/$INT_DIV/$INT_DEPT/$INT_SECT/$CHR_BUDGET_TYPE");
        //Download Excel All Dept
        $url_export_excel_2 = site_url("budget/budget_expense_c/download_excel_all/$INT_ID_FISCAL_YEAR/$INT_BUDGET_TYPE/$CHR_BUDGET_TYPE");

        $data = array(
            'url_iframe' => $url_iframe,
            'url_export_excel' => $url_export_excel,
            'url_export_excel_2' => $url_export_excel_2
        );

//Either you can print value or you can send value to database
        echo json_encode($data);

//        $detail_confirm = $this->budget_expense_m->get_detail_confirm_expense($INT_ID_FISCAL_YEAR, $CHR_BUDGET_TYPE, $INT_DIV, $INT_DEPT, $INT_SECT);
//
//        echo site_url("budget/budget_expense_c/refresh_table_page/1/$INT_ID_FISCAL_YEAR/$INT_BUDGET_TYPE/$INT_DIV/$INT_DEPT/$INT_SECT/$CHR_BUDGET_TYPE");
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

//GET DETAIL BUDGET
        if ($CHR_BUDGET_TYPE <> null) {
//            if($role == 2 && $INT_DIV == 3){
//                $data['detail_confirm'] = $this->budget_expense_m->get_detail_expense_cpl($INT_ID_FISCAL_YEAR, $CHR_BUDGET_TYPE, $INT_DIV, $INT_DEPT, $INT_SECT);
//                $data['detail_confirm_sum'] = $this->budget_expense_m->get_sum_expense_cpl($INT_ID_FISCAL_YEAR, $CHR_BUDGET_TYPE, $INT_DIV, $INT_DEPT, $INT_SECT);
//            } else {
                $data['detail_confirm'] = $this->budget_expense_m->get_detail_expense($INT_ID_FISCAL_YEAR, $CHR_BUDGET_TYPE, $INT_DIV, $INT_DEPT, $INT_SECT);
                $data['detail_confirm_sum'] = $this->budget_expense_m->get_sum_expense($INT_ID_FISCAL_YEAR, $CHR_BUDGET_TYPE, $INT_DIV, $INT_DEPT, $INT_SECT); 
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

        $data['title'] = 'Create Budget Expense';

        $data['subcontent'] = NULL;
        if ($INT_ID_BUDGET_TYPE == '3') { //== DONATION
            $data['content'] = 'budget/budget_expense/refresh_budget_expense_v';
        } else if ($INT_ID_BUDGET_TYPE == '2') { //== CONSUMABLE
            $data['content'] = 'budget/budget_expense/refresh_budget_expense_consu_v';
        } else if ($INT_ID_BUDGET_TYPE == '7') { //== IT EXPENSE
            $data['content'] = 'budget/budget_expense/refresh_budget_expense_itexp_v';
        } else if ($INT_ID_BUDGET_TYPE == '4') { //== EMPLOYEE WELFARE
            $data['content'] = 'budget/budget_expense/refresh_budget_expense_empwa_v';
        } else if ($INT_ID_BUDGET_TYPE == '9') { //== OFFICE EQUIPMENT
            $data['content'] = 'budget/budget_expense/refresh_budget_expense_offeq_v';
        } else if ($INT_ID_BUDGET_TYPE == '11') { //== RENTAL EXPENSE
            $data['content'] = 'budget/budget_expense/refresh_budget_expense_renta_v';
        } else if ($INT_ID_BUDGET_TYPE == '12') { //== REPAIR & MAINTENANCE
            $data['content'] = 'budget/budget_expense/refresh_budget_expense_repma_v';
        } else if ($INT_ID_BUDGET_TYPE == '13') { //== RESEARCH & DEVELOPMENT
            $data['content'] = 'budget/budget_expense/refresh_budget_expense_rndev_v';
        } else if ($INT_ID_BUDGET_TYPE == '15') { //== SUBCONTRACTOR COST
            $data['content'] = 'budget/budget_expense/refresh_budget_expense_subco_v';
        } else if ($INT_ID_BUDGET_TYPE == '16') { //== TOOLS & EQUIPMENT
            $data['content'] = 'budget/budget_expense/refresh_budget_expense_tooeq_v';
        } else if ($INT_ID_BUDGET_TYPE == '17') { //== TRAINING
            $data['content'] = 'budget/budget_expense/refresh_budget_expense_train_v';
        } else if ($INT_ID_BUDGET_TYPE == '18') { //== TRIAL & INSPECTION COST
            $data['content'] = 'budget/budget_expense/refresh_budget_expense_trial_v';
        } else if ($INT_ID_BUDGET_TYPE == '22') { //== UTILITY
            $data['content'] = 'budget/budget_expense/refresh_budget_expense_utily_v';
        } else if ($INT_ID_BUDGET_TYPE == '24') { //== BUSINESS & TRAVEL
            $data['content'] = 'budget/budget_expense/refresh_budget_expense_travl_v';
        } else if ($INT_ID_BUDGET_TYPE == '29') { //== TECHNICAL FEE
            $data['content'] = 'budget/budget_expense/refresh_budget_expense_tecfe_v';
        } else if ($INT_ID_BUDGET_TYPE == '39') { //== LEGAL PERSONAL
            $data['content'] = 'budget/budget_expense/refresh_budget_expense_legpr_v';
        } else if ($INT_ID_BUDGET_TYPE == '25') { //== SALARY
            $data['content'] = 'budget/budget_expense/refresh_budget_expense_salry_v';
        } else if ($INT_ID_BUDGET_TYPE == '41') { //== ENTERTAINMENT EXPENSE
            $data['content'] = 'budget/budget_expense/refresh_budget_expense_enter_v';
        }

        $data['budget_type'] = $this->budgettype_m->get_budget_type_expense_by_basic_unit();
        $kode_dept = $user_session['DEPT'];
        $data['kode_dept'] = $kode_dept;

        $data['data_budget_type'] = $this->budgettype_m->get_budgettype();
        $this->load->view($this->layout_blank, $data);
    }

    function download_excel($INT_ID_FISCAL_YEAR = null, $INT_ID_BUDGET_TYPE = null, $INT_DIV = null, $INT_DEPT = null, $INT_SECT = null, $CHR_BUDGET_TYPE = null) {
        $user_session = $this->session->all_userdata();
        $role = $user_session['ROLE'];
        $row = 8;

        if ($CHR_BUDGET_TYPE <> null) {
//            if($role == 2 && $INT_DIV == 3){
//                $detail_confirm = $this->budget_expense_m->get_detail_expense_dept_cpl($INT_ID_FISCAL_YEAR, $CHR_BUDGET_TYPE, $INT_DIV, $INT_DEPT, $INT_SECT);
//                $detail_confirm_sum = $this->budget_expense_m->get_sum_expense_dept_cpl($INT_ID_FISCAL_YEAR, $CHR_BUDGET_TYPE, $INT_DIV, $INT_DEPT, $INT_SECT);
//            } else {                
                if($role != 1 && $role != 2 && $role != 3 && $role != 4 && $role != 5 && $role != 39 && $role != 45){
                    //DOWNLOAD PER DEPT
                    $detail_confirm = $this->budget_expense_m->get_detail_expense_sect($INT_ID_FISCAL_YEAR, $CHR_BUDGET_TYPE, $INT_DIV, $INT_DEPT, $INT_SECT);
                    $detail_confirm_sum = $this->budget_expense_m->get_sum_expense_sect($INT_ID_FISCAL_YEAR, $CHR_BUDGET_TYPE, $INT_DIV, $INT_DEPT, $INT_SECT);
                } else {
                    //DOWNLOAD PER SECT
                    $detail_confirm = $this->budget_expense_m->get_detail_expense_dept($INT_ID_FISCAL_YEAR, $CHR_BUDGET_TYPE, $INT_DIV, $INT_DEPT, $INT_SECT);
                    $detail_confirm_sum = $this->budget_expense_m->get_sum_expense_dept($INT_ID_FISCAL_YEAR, $CHR_BUDGET_TYPE, $INT_DIV, $INT_DEPT, $INT_SECT);
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
            //DONATION

            if ($INT_ID_BUDGET_TYPE == 3) {
                $objPHPExcel = $objReader->load("assets/template/budget/report/Template_Report_Donation.xls");
            } else if ($INT_ID_BUDGET_TYPE == '2') { //== CONSUMABLE
                $objPHPExcel = $objReader->load("assets/template/budget/report/Template_Report_Consu.xls");
            } else if ($INT_ID_BUDGET_TYPE == '7') { //== IT EXPENSE
                $objPHPExcel = $objReader->load("assets/template/budget/report/Template_Report_Itexp.xls");
            } else if ($INT_ID_BUDGET_TYPE == '4') { //== EMPLOYEE WELFARE
                $objPHPExcel = $objReader->load("assets/template/budget/report/Template_Report_Empwa.xls");
            } else if ($INT_ID_BUDGET_TYPE == '9') { //== OFFICE EQUIPMENT
                $objPHPExcel = $objReader->load("assets/template/budget/report/Template_Report_Offeq.xls");
            } else if ($INT_ID_BUDGET_TYPE == '11') { //== RENTAL EXPENSE
                $objPHPExcel = $objReader->load("assets/template/budget/report/Template_Report_Renta.xls");
            } else if ($INT_ID_BUDGET_TYPE == '12') { //== REPAIR & MAINTENANCE
                $objPHPExcel = $objReader->load("assets/template/budget/report/Template_Report_Repma.xls");
            } else if ($INT_ID_BUDGET_TYPE == '13') { //== RESEARCH & DEVELOPMENT
                $objPHPExcel = $objReader->load("assets/template/budget/report/Template_Report_Rndev.xls");
            } else if ($INT_ID_BUDGET_TYPE == '15') { //== SUBCONTRACTOR COST
                $objPHPExcel = $objReader->load("assets/template/budget/report/Template_Report_Subco.xls");
            } else if ($INT_ID_BUDGET_TYPE == '16') { //== TOOLS & EQUIPMENT
                $objPHPExcel = $objReader->load("assets/template/budget/report/Template_Report_Tooeq.xls");
            } else if ($INT_ID_BUDGET_TYPE == '17') { //== TRAINING
                $objPHPExcel = $objReader->load("assets/template/budget/report/Template_Report_Train.xls");
            } else if ($INT_ID_BUDGET_TYPE == '18') { //== TRIAL & INSPECTION COST
                $objPHPExcel = $objReader->load("assets/template/budget/report/Template_Report_Trial.xls");
            } else if ($INT_ID_BUDGET_TYPE == '22') { //== UTILITY
                $objPHPExcel = $objReader->load("assets/template/budget/report/Template_Report_Utily.xls");
            } else if ($INT_ID_BUDGET_TYPE == '24') { //== BUSINESS & TRAVEL
                $objPHPExcel = $objReader->load("assets/template/budget/report/Template_Report_Travl.xls");
            } else if ($INT_ID_BUDGET_TYPE == '29') { //== TECHNICAL FEE
                $objPHPExcel = $objReader->load("assets/template/budget/report/Template_Report_Tecfe.xls");
            } else if ($INT_ID_BUDGET_TYPE == '39') { //== LEGAL PERSONAL
                $objPHPExcel = $objReader->load("assets/template/budget/report/Template_Report_Legpr.xls");
            } else if ($INT_ID_BUDGET_TYPE == '25') { //== SALARY
                $objPHPExcel = $objReader->load("assets/template/budget/report/Template_Report_Salry.xls");
            } else if ($INT_ID_BUDGET_TYPE == '41') { //== ENTERTAINMENT EXPENSE
                $objPHPExcel = $objReader->load("assets/template/budget/report/Template_Report_Enter.xls");
            }

            $seq = 1;
            $objPHPExcel->getActiveSheet()->setCellValue("B2", "MASTER BUDGET : " . $budget_desc . " TAHUN " . $CHR_FISCAL_YEAR_DESC);
            $objPHPExcel->getActiveSheet()->setCellValue("B3", "DEPARTMENT : " . $CHR_DEPT . " - " . $CHR_DEPT_DESC);
            foreach ($detail_confirm as $value) {

                $INT_SECT = $value->INT_SECT;
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
                $CHR_PURPOSE = $value->CHR_PURPOSE;
                $CHR_BUDGET_DESC = $value->CHR_BUDGET_DESC;
                $CHR_ITEM_DESC = $value->CHR_ITEM_DESC;
                $CHR_SATUAN = $value->CHR_SATUAN;
                $CHR_PART_NO = $value->CHR_PART_NO;
                $CHR_KIND_OF = $value->CHR_KIND_OF;
                $CHR_SHIFT = $value->CHR_SHIFT;
                $CHR_ITEM_RENT = $value->CHR_ITEM_RENT;
                $CHR_PROJECT_NAME = $value->CHR_PROJECT_NAME;
                $CHR_PERIODE = $value->CHR_PERIODE;
                $CHR_SUPPLIER_NAME = $value->CHR_SUPPLIER_NAME;
                $CHR_ORG_CURR = $value->CHR_ORG_CURR;
                $FLT_RATE_CURR = $value->FLT_RATE_CURR;
                $FLT_PRICE_CURR = $value->FLT_PRICE_CURR;
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
                $FLT_ADD_BLN01 = $value->FLT_ADD_BLN01;
                $FLT_ADD_BLN02 = $value->FLT_ADD_BLN02;
                $FLT_ADD_BLN03 = $value->FLT_ADD_BLN03;
                $FLT_ADD_BLN04 = $value->FLT_ADD_BLN04;
                $FLT_ADD_BLN05 = $value->FLT_ADD_BLN05;
                $FLT_ADD_BLN06 = $value->FLT_ADD_BLN06;
                $FLT_ADD_BLN07 = $value->FLT_ADD_BLN07;
                $FLT_ADD_BLN08 = $value->FLT_ADD_BLN08;
                $FLT_ADD_BLN09 = $value->FLT_ADD_BLN09;
                $FLT_ADD_BLN10 = $value->FLT_ADD_BLN10;
                $FLT_ADD_BLN11 = $value->FLT_ADD_BLN11;
                $FLT_ADD_BLN12 = $value->FLT_ADD_BLN12;
                $FLT_ADD_SUM = $value->FLT_ADD_SUM;
                $INT_DEPT = $value->INT_DEPT;
                $INT_GROUP_DEPT = $value->INT_GROUP_DEPT;
                $INT_DIV = $value->INT_DIV;
                $CHR_CATEGORY_PRODUCT = $value->CHR_CATEGORY_PRODUCT_DESC;

                $objPHPExcel->getActiveSheet()->setCellValue("B$row", "$seq");
                $objPHPExcel->getActiveSheet()->setCellValue("C$row", "$CHR_NO_BUDGET");
                $objPHPExcel->getActiveSheet()->setCellValue("D$row", "$CHR_SECTION_DESC");
                $objPHPExcel->getActiveSheet()->setCellValue("E$row", "$CHR_BUDGET_SUB_CATEGORY_DESC");
                $objPHPExcel->getActiveSheet()->setCellValue("F$row", "$CHR_BUDGET_CATEGORY_DESC");
                $objPHPExcel->getActiveSheet()->setCellValue("G$row", "$CHR_CODE_CATEGORY_A3_DESC");
                $objPHPExcel->getActiveSheet()->setCellValue("H$row", "$CHR_PURPOSE");
                $objPHPExcel->getActiveSheet()->setCellValue("I$row", "$CHR_PART_NO");
                $objPHPExcel->getActiveSheet()->setCellValue("J$row", "$CHR_ITEM_DESC");
                $objPHPExcel->getActiveSheet()->setCellValue("K$row", "$CHR_KIND_OF");
                $objPHPExcel->getActiveSheet()->setCellValue("L$row", "$CHR_PROJECT_NAME");
                $objPHPExcel->getActiveSheet()->setCellValue("M$row", "$CHR_PERIODE");
                $objPHPExcel->getActiveSheet()->setCellValue("N$row", "$CHR_ITEM_RENT");
                $objPHPExcel->getActiveSheet()->setCellValue("O$row", "$CHR_KIND_OF");
                $objPHPExcel->getActiveSheet()->setCellValue("P$row", "$CHR_SUPPLIER_NAME");
                $objPHPExcel->getActiveSheet()->setCellValue("Q$row", "$CHR_CATEGORY_PRODUCT");
                $objPHPExcel->getActiveSheet()->setCellValue("R$row", "$CHR_SATUAN");
                $objPHPExcel->getActiveSheet()->setCellValue("S$row", "$CHR_ORG_CURR");
                $objPHPExcel->getActiveSheet()->setCellValue("T$row", "$FLT_RATE_CURR");
                $objPHPExcel->getActiveSheet()->setCellValue("U$row", "$FLT_PRICE_CURR");
                $objPHPExcel->getActiveSheet()->setCellValue("V$row", "$INT_QTY_BLN04");
                $objPHPExcel->getActiveSheet()->setCellValue("W$row", "$FLT_ADD_BLN04");
                $objPHPExcel->getActiveSheet()->setCellValue("X$row", "$MON_AMT_BLN04");
                $objPHPExcel->getActiveSheet()->setCellValue("Y$row", "$INT_QTY_BLN05");
                $objPHPExcel->getActiveSheet()->setCellValue("Z$row", "$FLT_ADD_BLN05");
                $objPHPExcel->getActiveSheet()->setCellValue("AA$row", "$MON_AMT_BLN05");
                $objPHPExcel->getActiveSheet()->setCellValue("AB$row", "$INT_QTY_BLN06");
                $objPHPExcel->getActiveSheet()->setCellValue("AC$row", "$FLT_ADD_BLN06");
                $objPHPExcel->getActiveSheet()->setCellValue("AD$row", "$MON_AMT_BLN06");
                $objPHPExcel->getActiveSheet()->setCellValue("AE$row", "$INT_QTY_BLN07");
                $objPHPExcel->getActiveSheet()->setCellValue("AF$row", "$FLT_ADD_BLN07");
                $objPHPExcel->getActiveSheet()->setCellValue("AG$row", "$MON_AMT_BLN07");
                $objPHPExcel->getActiveSheet()->setCellValue("AH$row", "$INT_QTY_BLN08");
                $objPHPExcel->getActiveSheet()->setCellValue("AI$row", "$FLT_ADD_BLN08");
                $objPHPExcel->getActiveSheet()->setCellValue("AJ$row", "$MON_AMT_BLN08");
                $objPHPExcel->getActiveSheet()->setCellValue("AK$row", "$INT_QTY_BLN09");
                $objPHPExcel->getActiveSheet()->setCellValue("AL$row", "$FLT_ADD_BLN09");
                $objPHPExcel->getActiveSheet()->setCellValue("AM$row", "$MON_AMT_BLN09");
                $objPHPExcel->getActiveSheet()->setCellValue("AN$row", "$INT_QTY_BLN10");
                $objPHPExcel->getActiveSheet()->setCellValue("AO$row", "$FLT_ADD_BLN10");
                $objPHPExcel->getActiveSheet()->setCellValue("AP$row", "$MON_AMT_BLN10");
                $objPHPExcel->getActiveSheet()->setCellValue("AQ$row", "$INT_QTY_BLN11");
                $objPHPExcel->getActiveSheet()->setCellValue("AR$row", "$FLT_ADD_BLN11");
                $objPHPExcel->getActiveSheet()->setCellValue("AS$row", "$MON_AMT_BLN11");
                $objPHPExcel->getActiveSheet()->setCellValue("AT$row", "$INT_QTY_BLN12");
                $objPHPExcel->getActiveSheet()->setCellValue("AU$row", "$FLT_ADD_BLN12");
                $objPHPExcel->getActiveSheet()->setCellValue("AV$row", "$MON_AMT_BLN12");
                $objPHPExcel->getActiveSheet()->setCellValue("AW$row", "$INT_QTY_BLN01");
                $objPHPExcel->getActiveSheet()->setCellValue("AX$row", "$FLT_ADD_BLN01");
                $objPHPExcel->getActiveSheet()->setCellValue("AY$row", "$MON_AMT_BLN01");
                $objPHPExcel->getActiveSheet()->setCellValue("AZ$row", "$INT_QTY_BLN02");
                $objPHPExcel->getActiveSheet()->setCellValue("BA$row", "$FLT_ADD_BLN02");
                $objPHPExcel->getActiveSheet()->setCellValue("BB$row", "$MON_AMT_BLN02");
                $objPHPExcel->getActiveSheet()->setCellValue("BC$row", "$INT_QTY_BLN03");
                $objPHPExcel->getActiveSheet()->setCellValue("BD$row", "$FLT_ADD_BLN03");
                $objPHPExcel->getActiveSheet()->setCellValue("BE$row", "$MON_AMT_BLN03");
                $objPHPExcel->getActiveSheet()->setCellValue("BF$row", "$INT_QTY_SUM");
                $objPHPExcel->getActiveSheet()->setCellValue("BG$row", "$FLT_ADD_SUM");
                $objPHPExcel->getActiveSheet()->setCellValue("BH$row", "$MON_AMT_SUM");

                $seq++;
                $row++;
            }
//            $objPHPExcel->getActiveSheet()->getStyle("B8:BG$row")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $objPHPExcel->getActiveSheet()->getStyle("B8:BH$row")->applyFromArray(array(
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                )
            ));
            $row++;
            $row_min = $row - 1;            
            $objPHPExcel->getActiveSheet()->setCellValue("V$row", "=SUM(V8:V$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("W$row", "=SUM(W8:W$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("X$row", "=SUM(X8:X$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("Y$row", "=SUM(Y8:Y$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("Z$row", "=SUM(Z8:Z$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("AA$row", "=SUM(AA8:AA$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("AB$row", "=SUM(AB8:AB$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("AC$row", "=SUM(AC8:AC$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("AD$row", "=SUM(AD8:AD$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("AE$row", "=SUM(AE8:AE$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("AF$row", "=SUM(AF8:AF$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("AG$row", "=SUM(AG8:AG$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("AH$row", "=SUM(AH8:AH$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("AI$row", "=SUM(AI8:AI$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("AJ$row", "=SUM(AJ8:AJ$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("AK$row", "=SUM(AK8:AK$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("AL$row", "=SUM(AL8:AL$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("AM$row", "=SUM(AM8:AM$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("AN$row", "=SUM(AN8:AN$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("AO$row", "=SUM(AO8:AO$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("AP$row", "=SUM(AP8:AP$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("AQ$row", "=SUM(AQ8:AQ$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("AR$row", "=SUM(AR8:AR$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("AS$row", "=SUM(AS8:AS$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("AT$row", "=SUM(AT8:AT$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("AU$row", "=SUM(AU8:AU$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("AV$row", "=SUM(AV8:AV$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("AW$row", "=SUM(AW8:AW$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("AX$row", "=SUM(AX8:AX$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("AY$row", "=SUM(AY8:AY$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("AZ$row", "=SUM(AZ8:AZ$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("BA$row", "=SUM(BA8:BA$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("BB$row", "=SUM(BB8:BB$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("BC$row", "=SUM(BC8:BC$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("BD$row", "=SUM(BD8:BD$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("BE$row", "=SUM(BE8:BE$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("BF$row", "=SUM(BF8:BF$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("BG$row", "=SUM(BG8:BG$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("BH$row", "=SUM(BH8:BH$row_min)");
            $objPHPExcel->getActiveSheet()->getStyle("B8:BH$row")->applyFromArray(array(
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                ),
            ));
            $objPHPExcel->getActiveSheet()->mergeCells("B$row:U$row");
            $objPHPExcel->getActiveSheet()->setCellValue("B$row", "TOTAL");
            $objPHPExcel->getActiveSheet()->getStyle("B$row:BH$row")->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('#CCCCCC');
            $objPHPExcel->getActiveSheet()->getStyle("B$row:BH$row")->applyFromArray(array(
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
            $objDrawing->setCoordinates("AY$row");
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
    
    function download_excel_per_sect($INT_ID_FISCAL_YEAR = null, $INT_ID_BUDGET_TYPE = null, $INT_DIV = null, $INT_DEPT = null, $INT_SECT = null, $CHR_BUDGET_TYPE = null) {
        $user_session = $this->session->all_userdata();
        $role = $user_session['ROLE'];
        $row = 8;

        if ($CHR_BUDGET_TYPE <> null) {
//            if($role == 2 && $INT_DIV == 3){
//                $detail_confirm = $this->budget_expense_m->get_detail_expense_dept_cpl($INT_ID_FISCAL_YEAR, $CHR_BUDGET_TYPE, $INT_DIV, $INT_DEPT, $INT_SECT);
//                $detail_confirm_sum = $this->budget_expense_m->get_sum_expense_dept_cpl($INT_ID_FISCAL_YEAR, $CHR_BUDGET_TYPE, $INT_DIV, $INT_DEPT, $INT_SECT);
//            } else {
                //DOWNLOAD PER DEPT
                //$detail_confirm = $this->budget_expense_m->get_detail_expense_dept($INT_ID_FISCAL_YEAR, $CHR_BUDGET_TYPE, $INT_DIV, $INT_DEPT, $INT_SECT);
                //$detail_confirm_sum = $this->budget_expense_m->get_sum_expense_dept($INT_ID_FISCAL_YEAR, $CHR_BUDGET_TYPE, $INT_DIV, $INT_DEPT, $INT_SECT);
                //DOWNLOAD PER SECT
                $detail_confirm = $this->budget_expense_m->get_detail_expense_sect($INT_ID_FISCAL_YEAR, $CHR_BUDGET_TYPE, $INT_DIV, $INT_DEPT, $INT_SECT);
                $detail_confirm_sum = $this->budget_expense_m->get_sum_expense_sect($INT_ID_FISCAL_YEAR, $CHR_BUDGET_TYPE, $INT_DIV, $INT_DEPT, $INT_SECT);
//            }
            
            $budget_desc = $this->budgettype_m->get_budget_type($INT_ID_BUDGET_TYPE);
            $budget_desc = strtoupper(trim($budget_desc->CHR_BUDGET_TYPE_DESC));

            $CHR_DEPT = trim($this->dept_m->get_name_dept($INT_DEPT));
            $CHR_DEPT_DESC = trim($this->dept_m->get_desc_dept($INT_DEPT));
            $CHR_FISCAL_YEAR_DESC = trim($this->fiscal_m->select_fiscal_year($INT_ID_FISCAL_YEAR));

            $this->load->library('excel');
            $objReader = PHPExcel_IOFactory::createReader('Excel5');
            // Create new PHPExcel object
            //DONATION

            if ($INT_ID_BUDGET_TYPE == 3) {
                $objPHPExcel = $objReader->load("assets/template/budget/report/Template_Report_Donation.xls");
            } else if ($INT_ID_BUDGET_TYPE == '2') { //== CONSUMABLE
                $objPHPExcel = $objReader->load("assets/template/budget/report/Template_Report_Consu.xls");
            } else if ($INT_ID_BUDGET_TYPE == '7') { //== IT EXPENSE
                $objPHPExcel = $objReader->load("assets/template/budget/report/Template_Report_Itexp.xls");
            } else if ($INT_ID_BUDGET_TYPE == '4') { //== EMPLOYEE WELFARE
                $objPHPExcel = $objReader->load("assets/template/budget/report/Template_Report_Empwa.xls");
            } else if ($INT_ID_BUDGET_TYPE == '9') { //== OFFICE EQUIPMENT
                $objPHPExcel = $objReader->load("assets/template/budget/report/Template_Report_Offeq.xls");
            } else if ($INT_ID_BUDGET_TYPE == '11') { //== RENTAL EXPENSE
                $objPHPExcel = $objReader->load("assets/template/budget/report/Template_Report_Renta.xls");
            } else if ($INT_ID_BUDGET_TYPE == '12') { //== REPAIR & MAINTENANCE
                $objPHPExcel = $objReader->load("assets/template/budget/report/Template_Report_Repma.xls");
            } else if ($INT_ID_BUDGET_TYPE == '13') { //== RESEARCH & DEVELOPMENT
                $objPHPExcel = $objReader->load("assets/template/budget/report/Template_Report_Rndev.xls");
            } else if ($INT_ID_BUDGET_TYPE == '15') { //== SUBCONTRACTOR COST
                $objPHPExcel = $objReader->load("assets/template/budget/report/Template_Report_Subco.xls");
            } else if ($INT_ID_BUDGET_TYPE == '16') { //== TOOLS & EQUIPMENT
                $objPHPExcel = $objReader->load("assets/template/budget/report/Template_Report_Tooeq.xls");
            } else if ($INT_ID_BUDGET_TYPE == '17') { //== TRAINING
                $objPHPExcel = $objReader->load("assets/template/budget/report/Template_Report_Train.xls");
            } else if ($INT_ID_BUDGET_TYPE == '18') { //== TRIAL & INSPECTION COST
                $objPHPExcel = $objReader->load("assets/template/budget/report/Template_Report_Trial.xls");
            } else if ($INT_ID_BUDGET_TYPE == '22') { //== UTILITY
                $objPHPExcel = $objReader->load("assets/template/budget/report/Template_Report_Utily.xls");
            } else if ($INT_ID_BUDGET_TYPE == '24') { //== BUSINESS & TRAVEL
                $objPHPExcel = $objReader->load("assets/template/budget/report/Template_Report_Travl.xls");
            } else if ($INT_ID_BUDGET_TYPE == '29') { //== TECHNICAL FEE
                $objPHPExcel = $objReader->load("assets/template/budget/report/Template_Report_Tecfe.xls");
            } else if ($INT_ID_BUDGET_TYPE == '39') { //== LEGAL PERSONAL
                $objPHPExcel = $objReader->load("assets/template/budget/report/Template_Report_Legpr.xls");
            } else if ($INT_ID_BUDGET_TYPE == '25') { //== SALARY
                $objPHPExcel = $objReader->load("assets/template/budget/report/Template_Report_Salry.xls");
            } else if ($INT_ID_BUDGET_TYPE == '41') { //== ENTERTAINMENT EXPENSE
                $objPHPExcel = $objReader->load("assets/template/budget/report/Template_Report_Enter.xls");
            }

            $seq = 1;
            $objPHPExcel->getActiveSheet()->setCellValue("B2", "MASTER BUDGET : " . $budget_desc . " TAHUN " . $CHR_FISCAL_YEAR_DESC);
            $objPHPExcel->getActiveSheet()->setCellValue("B3", "DEPARTMENT : " . $CHR_DEPT . " - " . $CHR_DEPT_DESC);
            foreach ($detail_confirm as $value) {

                $INT_SECT = $value->INT_SECT;
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
                $CHR_PURPOSE = $value->CHR_PURPOSE;
                $CHR_BUDGET_DESC = $value->CHR_BUDGET_DESC;
                $CHR_ITEM_DESC = $value->CHR_ITEM_DESC;
                $CHR_SATUAN = $value->CHR_SATUAN;
                $CHR_PART_NO = $value->CHR_PART_NO;
                $CHR_KIND_OF = $value->CHR_KIND_OF;
                $CHR_SHIFT = $value->CHR_SHIFT;
                $CHR_ITEM_RENT = $value->CHR_ITEM_RENT;
                $CHR_PROJECT_NAME = $value->CHR_PROJECT_NAME;
                $CHR_PERIODE = $value->CHR_PERIODE;
                $CHR_SUPPLIER_NAME = $value->CHR_SUPPLIER_NAME;
                $CHR_ORG_CURR = $value->CHR_ORG_CURR;
                $FLT_RATE_CURR = $value->FLT_RATE_CURR;
                $FLT_PRICE_CURR = $value->FLT_PRICE_CURR;
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
                $FLT_ADD_BLN01 = $value->FLT_ADD_BLN01;
                $FLT_ADD_BLN02 = $value->FLT_ADD_BLN02;
                $FLT_ADD_BLN03 = $value->FLT_ADD_BLN03;
                $FLT_ADD_BLN04 = $value->FLT_ADD_BLN04;
                $FLT_ADD_BLN05 = $value->FLT_ADD_BLN05;
                $FLT_ADD_BLN06 = $value->FLT_ADD_BLN06;
                $FLT_ADD_BLN07 = $value->FLT_ADD_BLN07;
                $FLT_ADD_BLN08 = $value->FLT_ADD_BLN08;
                $FLT_ADD_BLN09 = $value->FLT_ADD_BLN09;
                $FLT_ADD_BLN10 = $value->FLT_ADD_BLN10;
                $FLT_ADD_BLN11 = $value->FLT_ADD_BLN11;
                $FLT_ADD_BLN12 = $value->FLT_ADD_BLN12;
                $FLT_ADD_SUM = $value->FLT_ADD_SUM;
                $INT_DEPT = $value->INT_DEPT;
                $INT_GROUP_DEPT = $value->INT_GROUP_DEPT;
                $INT_DIV = $value->INT_DIV;
                $CHR_CATEGORY_PRODUCT = $value->CHR_CATEGORY_PRODUCT_DESC;

                $objPHPExcel->getActiveSheet()->setCellValue("B$row", "$seq");
                $objPHPExcel->getActiveSheet()->setCellValue("C$row", "$CHR_NO_BUDGET");
                $objPHPExcel->getActiveSheet()->setCellValue("D$row", "$CHR_SECTION_DESC");
                $objPHPExcel->getActiveSheet()->setCellValue("E$row", "$CHR_BUDGET_SUB_CATEGORY_DESC");
                $objPHPExcel->getActiveSheet()->setCellValue("F$row", "$CHR_BUDGET_CATEGORY_DESC");
                $objPHPExcel->getActiveSheet()->setCellValue("G$row", "$CHR_CODE_CATEGORY_A3_DESC");
                $objPHPExcel->getActiveSheet()->setCellValue("H$row", "$CHR_PURPOSE");
                $objPHPExcel->getActiveSheet()->setCellValue("I$row", "$CHR_PART_NO");
                $objPHPExcel->getActiveSheet()->setCellValue("J$row", "$CHR_ITEM_DESC");
                $objPHPExcel->getActiveSheet()->setCellValue("K$row", "$CHR_KIND_OF");
                $objPHPExcel->getActiveSheet()->setCellValue("L$row", "$CHR_PROJECT_NAME");
                $objPHPExcel->getActiveSheet()->setCellValue("M$row", "$CHR_PERIODE");
                $objPHPExcel->getActiveSheet()->setCellValue("N$row", "$CHR_ITEM_RENT");
                $objPHPExcel->getActiveSheet()->setCellValue("O$row", "$CHR_KIND_OF");
                $objPHPExcel->getActiveSheet()->setCellValue("P$row", "$CHR_SUPPLIER_NAME");
                $objPHPExcel->getActiveSheet()->setCellValue("Q$row", "$CHR_CATEGORY_PRODUCT");
                $objPHPExcel->getActiveSheet()->setCellValue("R$row", "$CHR_SATUAN");
                $objPHPExcel->getActiveSheet()->setCellValue("S$row", "$CHR_ORG_CURR");
                $objPHPExcel->getActiveSheet()->setCellValue("T$row", "$FLT_RATE_CURR");
                $objPHPExcel->getActiveSheet()->setCellValue("U$row", "$FLT_PRICE_CURR");
                $objPHPExcel->getActiveSheet()->setCellValue("V$row", "$INT_QTY_BLN04");
                $objPHPExcel->getActiveSheet()->setCellValue("W$row", "$FLT_ADD_BLN04");
                $objPHPExcel->getActiveSheet()->setCellValue("X$row", "$MON_AMT_BLN04");
                $objPHPExcel->getActiveSheet()->setCellValue("Y$row", "$INT_QTY_BLN05");
                $objPHPExcel->getActiveSheet()->setCellValue("Z$row", "$FLT_ADD_BLN05");
                $objPHPExcel->getActiveSheet()->setCellValue("AA$row", "$MON_AMT_BLN05");
                $objPHPExcel->getActiveSheet()->setCellValue("AB$row", "$INT_QTY_BLN06");
                $objPHPExcel->getActiveSheet()->setCellValue("AC$row", "$FLT_ADD_BLN06");
                $objPHPExcel->getActiveSheet()->setCellValue("AD$row", "$MON_AMT_BLN06");
                $objPHPExcel->getActiveSheet()->setCellValue("AE$row", "$INT_QTY_BLN07");
                $objPHPExcel->getActiveSheet()->setCellValue("AF$row", "$FLT_ADD_BLN07");
                $objPHPExcel->getActiveSheet()->setCellValue("AG$row", "$MON_AMT_BLN07");
                $objPHPExcel->getActiveSheet()->setCellValue("AH$row", "$INT_QTY_BLN08");
                $objPHPExcel->getActiveSheet()->setCellValue("AI$row", "$FLT_ADD_BLN08");
                $objPHPExcel->getActiveSheet()->setCellValue("AJ$row", "$MON_AMT_BLN08");
                $objPHPExcel->getActiveSheet()->setCellValue("AK$row", "$INT_QTY_BLN09");
                $objPHPExcel->getActiveSheet()->setCellValue("AL$row", "$FLT_ADD_BLN09");
                $objPHPExcel->getActiveSheet()->setCellValue("AM$row", "$MON_AMT_BLN09");
                $objPHPExcel->getActiveSheet()->setCellValue("AN$row", "$INT_QTY_BLN10");
                $objPHPExcel->getActiveSheet()->setCellValue("AO$row", "$FLT_ADD_BLN10");
                $objPHPExcel->getActiveSheet()->setCellValue("AP$row", "$MON_AMT_BLN10");
                $objPHPExcel->getActiveSheet()->setCellValue("AQ$row", "$INT_QTY_BLN11");
                $objPHPExcel->getActiveSheet()->setCellValue("AR$row", "$FLT_ADD_BLN11");
                $objPHPExcel->getActiveSheet()->setCellValue("AS$row", "$MON_AMT_BLN11");
                $objPHPExcel->getActiveSheet()->setCellValue("AT$row", "$INT_QTY_BLN12");
                $objPHPExcel->getActiveSheet()->setCellValue("AU$row", "$FLT_ADD_BLN12");
                $objPHPExcel->getActiveSheet()->setCellValue("AV$row", "$MON_AMT_BLN12");
                $objPHPExcel->getActiveSheet()->setCellValue("AW$row", "$INT_QTY_BLN01");
                $objPHPExcel->getActiveSheet()->setCellValue("AX$row", "$FLT_ADD_BLN01");
                $objPHPExcel->getActiveSheet()->setCellValue("AY$row", "$MON_AMT_BLN01");
                $objPHPExcel->getActiveSheet()->setCellValue("AZ$row", "$INT_QTY_BLN02");
                $objPHPExcel->getActiveSheet()->setCellValue("BA$row", "$FLT_ADD_BLN02");
                $objPHPExcel->getActiveSheet()->setCellValue("BB$row", "$MON_AMT_BLN02");
                $objPHPExcel->getActiveSheet()->setCellValue("BC$row", "$INT_QTY_BLN03");
                $objPHPExcel->getActiveSheet()->setCellValue("BD$row", "$FLT_ADD_BLN03");
                $objPHPExcel->getActiveSheet()->setCellValue("BE$row", "$MON_AMT_BLN03");
                $objPHPExcel->getActiveSheet()->setCellValue("BF$row", "$INT_QTY_SUM");
                $objPHPExcel->getActiveSheet()->setCellValue("BG$row", "$FLT_ADD_SUM");
                $objPHPExcel->getActiveSheet()->setCellValue("BH$row", "$MON_AMT_SUM");

                $seq++;
                $row++;
            }
//            $objPHPExcel->getActiveSheet()->getStyle("B8:BG$row")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $objPHPExcel->getActiveSheet()->getStyle("B8:BH$row")->applyFromArray(array(
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                )
            ));
            $row++;
            $row_min = $row - 1;
            $objPHPExcel->getActiveSheet()->setCellValue("V$row", "=SUM(V8:V$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("W$row", "=SUM(W8:W$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("X$row", "=SUM(X8:X$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("Y$row", "=SUM(Y8:Y$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("Z$row", "=SUM(Z8:Z$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("AA$row", "=SUM(AA8:AA$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("AB$row", "=SUM(AB8:AB$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("AC$row", "=SUM(AC8:AC$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("AD$row", "=SUM(AD8:AD$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("AE$row", "=SUM(AE8:AE$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("AF$row", "=SUM(AF8:AF$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("AG$row", "=SUM(AG8:AG$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("AH$row", "=SUM(AH8:AH$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("AI$row", "=SUM(AI8:AI$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("AJ$row", "=SUM(AJ8:AJ$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("AK$row", "=SUM(AK8:AK$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("AL$row", "=SUM(AL8:AL$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("AM$row", "=SUM(AM8:AM$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("AN$row", "=SUM(AN8:AN$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("AO$row", "=SUM(AO8:AO$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("AP$row", "=SUM(AP8:AP$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("AQ$row", "=SUM(AQ8:AQ$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("AR$row", "=SUM(AR8:AR$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("AS$row", "=SUM(AS8:AS$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("AT$row", "=SUM(AT8:AT$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("AU$row", "=SUM(AU8:AU$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("AV$row", "=SUM(AV8:AV$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("AW$row", "=SUM(AW8:AW$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("AX$row", "=SUM(AX8:AX$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("AY$row", "=SUM(AY8:AY$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("AZ$row", "=SUM(AZ8:AZ$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("BA$row", "=SUM(BA8:BA$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("BB$row", "=SUM(BB8:BB$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("BC$row", "=SUM(BC8:BC$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("BD$row", "=SUM(BD8:BD$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("BE$row", "=SUM(BE8:BE$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("BF$row", "=SUM(BF8:BF$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("BG$row", "=SUM(BG8:BG$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("BH$row", "=SUM(BG8:BH$row_min)");
            $objPHPExcel->getActiveSheet()->getStyle("B8:BH$row")->applyFromArray(array(
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                ),
            ));
            $objPHPExcel->getActiveSheet()->mergeCells("B$row:U$row");
            $objPHPExcel->getActiveSheet()->setCellValue("B$row", "TOTAL");
            $objPHPExcel->getActiveSheet()->getStyle("B$row:BH$row")->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('#CCCCCC');
            $objPHPExcel->getActiveSheet()->getStyle("B$row:BH$row")->applyFromArray(array(
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
            $objDrawing->setCoordinates("AY$row");
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

    function download_excel_for_approve($INT_ID_FISCAL_YEAR = null, $INT_DIV = null, $INT_GROUP = null, $INT_DEPT = null) {
        //$category_foh = $this->budgetcategory_m->get_budgetcategory_expense_foh();
        //$category_opx = $this->budgetcategory_m->get_budgetcategory_expense_opx();

        $category_foh = $this->budget_expense_m->get_category_expense_foh($INT_ID_FISCAL_YEAR);
        $category_opx = $this->budget_expense_m->get_category_expense_opx($INT_ID_FISCAL_YEAR);

        $CHR_DEPT = trim($this->dept_m->get_name_dept($INT_DEPT));
        $CHR_DEPT_DESC = trim($this->dept_m->get_desc_dept($INT_DEPT));
        $CHR_FISCAL_YEAR_DESC = trim($this->fiscal_m->select_fiscal_year($INT_ID_FISCAL_YEAR));

        $this->load->library('excel');
        $objReader = PHPExcel_IOFactory::createReader('Excel5');
        // Create new PHPExcel object

        $objPHPExcel = $objReader->load("assets/template/budget/report/Template_Approval_Expense.xls");

        //============== FOH =================================================//
        $row = 8;
        $active_sheet = $objPHPExcel->setActiveSheetIndexByName('FOH');
        $active_sheet->setCellValue("B2", "MASTER BUDGET : EXPENSE FOH TAHUN " . $CHR_FISCAL_YEAR_DESC);
        $active_sheet->setCellValue("B3", "DEPARTMENT : " . $CHR_DEPT . " - " . $CHR_DEPT_DESC);

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

        foreach ($category_foh as $foh) {
            $space = 0;
            $CHR_CATEGORY = $foh->CHR_BUDGET_CATEGORY;
            $detail_confirm_foh = $this->budget_expense_m->get_expense_foh_by_category($INT_ID_FISCAL_YEAR, $INT_DIV, $INT_GROUP, $INT_DEPT, $CHR_CATEGORY);

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

            if ($count != 0) {
                $space = 1;
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
            } else {
                $space = 0;
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

            if($space != 0){
                $row = $row + 1;
            }
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
        $active_sheet->setCellValue("B3", "DEPARTMENT : " . $CHR_DEPT . " - " . $CHR_DEPT_DESC);

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

        foreach ($category_opx as $opx) {
            $space = 0;
            $CHR_CATEGORY = $opx->CHR_BUDGET_CATEGORY;
            $detail_confirm_opx = $this->budget_expense_m->get_expense_opx_by_category($INT_ID_FISCAL_YEAR, $INT_DIV, $INT_GROUP, $INT_DEPT, $CHR_CATEGORY);

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

            if ($count != 0) {
                $space = 1;
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

            if($space != 0){
                $row_x = $row_x + 1;
            }            
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
        $filename = "$CHR_FISCAL_YEAR_DESC - EXPENSE FOH - $CHR_DEPT.xls";
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . trim($filename) . '"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->setIncludeCharts(TRUE);
        $objWriter->save('php://output');
    }
    
    //Without TOTAL per DEPT
    function download_excel_all_before_revision($INT_ID_FISCAL_YEAR = null, $INT_ID_BUDGET_TYPE = null, $CHR_BUDGET_TYPE = null) {
        $row = 8;

        if ($CHR_BUDGET_TYPE <> null) {
            //$all_dept = $this->dept_m->get_dept();  
            $budget_desc = $this->budgettype_m->get_budget_type($INT_ID_BUDGET_TYPE);
            $budget_desc = strtoupper(trim($budget_desc->CHR_BUDGET_TYPE_DESC));

            $CHR_FISCAL_YEAR_DESC = trim($this->fiscal_m->select_fiscal_year($INT_ID_FISCAL_YEAR));

            $this->load->library('excel');
            $objReader = PHPExcel_IOFactory::createReader('Excel5');
            //Create new PHPExcel object

            if ($INT_ID_BUDGET_TYPE == 3) {
                $objPHPExcel = $objReader->load("assets/template/budget/report/Template_Report_Donation.xls");
            } else if ($INT_ID_BUDGET_TYPE == '2') { //== CONSUMABLE
                $objPHPExcel = $objReader->load("assets/template/budget/report/Template_Report_Consu.xls");
            } else if ($INT_ID_BUDGET_TYPE == '7') { //== IT EXPENSE
                $objPHPExcel = $objReader->load("assets/template/budget/report/Template_Report_Itexp.xls");
            } else if ($INT_ID_BUDGET_TYPE == '4') { //== EMPLOYEE WELFARE
                $objPHPExcel = $objReader->load("assets/template/budget/report/Template_Report_Empwa.xls");
            } else if ($INT_ID_BUDGET_TYPE == '9') { //== OFFICE EQUIPMENT
                $objPHPExcel = $objReader->load("assets/template/budget/report/Template_Report_Offeq.xls");
            } else if ($INT_ID_BUDGET_TYPE == '11') { //== RENTAL EXPENSE
                $objPHPExcel = $objReader->load("assets/template/budget/report/Template_Report_Renta.xls");
            } else if ($INT_ID_BUDGET_TYPE == '12') { //== REPAIR & MAINTENANCE
                $objPHPExcel = $objReader->load("assets/template/budget/report/Template_Report_Repma.xls");
            } else if ($INT_ID_BUDGET_TYPE == '13') { //== RESEARCH & DEVELOPMENT
                $objPHPExcel = $objReader->load("assets/template/budget/report/Template_Report_Rndev.xls");
            } else if ($INT_ID_BUDGET_TYPE == '15') { //== SUBCONTRACTOR COST
                $objPHPExcel = $objReader->load("assets/template/budget/report/Template_Report_Subco.xls");
            } else if ($INT_ID_BUDGET_TYPE == '16') { //== TOOLS & EQUIPMENT
                $objPHPExcel = $objReader->load("assets/template/budget/report/Template_Report_Tooeq.xls");
            } else if ($INT_ID_BUDGET_TYPE == '17') { //== TRAINING
                $objPHPExcel = $objReader->load("assets/template/budget/report/Template_Report_Train.xls");
            } else if ($INT_ID_BUDGET_TYPE == '18') { //== TRIAL & INSPECTION COST
                $objPHPExcel = $objReader->load("assets/template/budget/report/Template_Report_Trial.xls");
            } else if ($INT_ID_BUDGET_TYPE == '22') { //== UTILITY
                $objPHPExcel = $objReader->load("assets/template/budget/report/Template_Report_Utily.xls");
            } else if ($INT_ID_BUDGET_TYPE == '24') { //== BUSINESS & TRAVEL
                $objPHPExcel = $objReader->load("assets/template/budget/report/Template_Report_Travl.xls");
            } else if ($INT_ID_BUDGET_TYPE == '29') { //== TECHNICAL FEE
                $objPHPExcel = $objReader->load("assets/template/budget/report/Template_Report_Tecfe.xls");
            } else if ($INT_ID_BUDGET_TYPE == '39') { //== LEGAL PERSONAL
                $objPHPExcel = $objReader->load("assets/template/budget/report/Template_Report_Legpr.xls");
            } else if ($INT_ID_BUDGET_TYPE == '25') { //== SALARY
                $objPHPExcel = $objReader->load("assets/template/budget/report/Template_Report_Salry.xls");
            } else if ($INT_ID_BUDGET_TYPE == '41') { //== ENTERTAINMENT EXPENSE
                $objPHPExcel = $objReader->load("assets/template/budget/report/Template_Report_Enter.xls");
            }

            $seq = 1;
            $objPHPExcel->getActiveSheet()->setCellValue("B2", "MASTER BUDGET : " . $budget_desc . " TAHUN " . $CHR_FISCAL_YEAR_DESC);
            $objPHPExcel->getActiveSheet()->setCellValue("B3", "ALL DEPARTMENT");
            
            $detail_confirm = $this->budget_expense_m->get_detail_expense_all_dept($INT_ID_FISCAL_YEAR, $CHR_BUDGET_TYPE);
            $detail_confirm_sum = $this->budget_expense_m->get_sum_expense_all_dept($INT_ID_FISCAL_YEAR, $CHR_BUDGET_TYPE);
                        
            foreach ($detail_confirm as $value) {

                $INT_SECT = $value->INT_SECT;
                $CHR_DEPT_DESC = trim($this->dept_m->get_desc_dept($value->INT_DEPT));
                $CHR_SECTION_DESC = trim($this->section_m->get_desc_section($value->INT_SECT));
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
                $CHR_PURPOSE = $value->CHR_PURPOSE;
                $CHR_BUDGET_DESC = $value->CHR_BUDGET_DESC;
                $CHR_ITEM_DESC = $value->CHR_ITEM_DESC;
                $CHR_SATUAN = $value->CHR_SATUAN;
                $CHR_PART_NO = $value->CHR_PART_NO;
                $CHR_KIND_OF = $value->CHR_KIND_OF;
                $CHR_SHIFT = $value->CHR_SHIFT;
                $CHR_ITEM_RENT = $value->CHR_ITEM_RENT;
                $CHR_PROJECT_NAME = $value->CHR_PROJECT_NAME;
                $CHR_PERIODE = $value->CHR_PERIODE;
                $CHR_SUPPLIER_NAME = $value->CHR_SUPPLIER_NAME;
                $CHR_ORG_CURR = $value->CHR_ORG_CURR;
                $FLT_RATE_CURR = $value->FLT_RATE_CURR;
                $FLT_PRICE_CURR = $value->FLT_PRICE_CURR;
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
                $FLT_ADD_BLN01 = $value->FLT_ADD_BLN01;
                $FLT_ADD_BLN02 = $value->FLT_ADD_BLN02;
                $FLT_ADD_BLN03 = $value->FLT_ADD_BLN03;
                $FLT_ADD_BLN04 = $value->FLT_ADD_BLN04;
                $FLT_ADD_BLN05 = $value->FLT_ADD_BLN05;
                $FLT_ADD_BLN06 = $value->FLT_ADD_BLN06;
                $FLT_ADD_BLN07 = $value->FLT_ADD_BLN07;
                $FLT_ADD_BLN08 = $value->FLT_ADD_BLN08;
                $FLT_ADD_BLN09 = $value->FLT_ADD_BLN09;
                $FLT_ADD_BLN10 = $value->FLT_ADD_BLN10;
                $FLT_ADD_BLN11 = $value->FLT_ADD_BLN11;
                $FLT_ADD_BLN12 = $value->FLT_ADD_BLN12;
                $FLT_ADD_SUM = $value->FLT_ADD_SUM;
                $INT_DEPT = $value->INT_DEPT;
                $INT_GROUP_DEPT = $value->INT_GROUP_DEPT;
                $INT_DIV = $value->INT_DIV;
                $CHR_CATEGORY_PRODUCT = $value->CHR_CATEGORY_PRODUCT_DESC;

                $objPHPExcel->getActiveSheet()->setCellValue("B$row", "$seq");
                $objPHPExcel->getActiveSheet()->setCellValue("C$row", "$CHR_NO_BUDGET");
                $objPHPExcel->getActiveSheet()->setCellValue("D$row", "$CHR_DEPT_DESC / $CHR_SECTION_DESC");
                $objPHPExcel->getActiveSheet()->setCellValue("E$row", "$CHR_BUDGET_SUB_CATEGORY_DESC");
                $objPHPExcel->getActiveSheet()->setCellValue("F$row", "$CHR_BUDGET_CATEGORY_DESC");
                $objPHPExcel->getActiveSheet()->setCellValue("G$row", "$CHR_CODE_CATEGORY_A3_DESC");
                $objPHPExcel->getActiveSheet()->setCellValue("H$row", "$CHR_PURPOSE");
                $objPHPExcel->getActiveSheet()->setCellValue("I$row", "$CHR_PART_NO");
                $objPHPExcel->getActiveSheet()->setCellValue("J$row", "$CHR_ITEM_DESC");
                $objPHPExcel->getActiveSheet()->setCellValue("K$row", "$CHR_KIND_OF");
                $objPHPExcel->getActiveSheet()->setCellValue("L$row", "$CHR_PROJECT_NAME");
                $objPHPExcel->getActiveSheet()->setCellValue("M$row", "$CHR_PERIODE");
                $objPHPExcel->getActiveSheet()->setCellValue("N$row", "$CHR_ITEM_RENT");
                $objPHPExcel->getActiveSheet()->setCellValue("O$row", "$CHR_KIND_OF");
                $objPHPExcel->getActiveSheet()->setCellValue("P$row", "$CHR_SUPPLIER_NAME");
                $objPHPExcel->getActiveSheet()->setCellValue("Q$row", "$CHR_SATUAN");
                $objPHPExcel->getActiveSheet()->setCellValue("R$row", "$CHR_ORG_CURR");
                $objPHPExcel->getActiveSheet()->setCellValue("S$row", "$FLT_RATE_CURR");
                $objPHPExcel->getActiveSheet()->setCellValue("T$row", "$FLT_PRICE_CURR");
                $objPHPExcel->getActiveSheet()->setCellValue("U$row", "$INT_QTY_BLN04");
                $objPHPExcel->getActiveSheet()->setCellValue("V$row", "$FLT_ADD_BLN04");
                $objPHPExcel->getActiveSheet()->setCellValue("W$row", "$MON_AMT_BLN04");
                $objPHPExcel->getActiveSheet()->setCellValue("X$row", "$INT_QTY_BLN05");
                $objPHPExcel->getActiveSheet()->setCellValue("Y$row", "$FLT_ADD_BLN05");
                $objPHPExcel->getActiveSheet()->setCellValue("Z$row", "$MON_AMT_BLN05");
                $objPHPExcel->getActiveSheet()->setCellValue("AA$row", "$INT_QTY_BLN06");
                $objPHPExcel->getActiveSheet()->setCellValue("AB$row", "$FLT_ADD_BLN06");
                $objPHPExcel->getActiveSheet()->setCellValue("AC$row", "$MON_AMT_BLN06");
                $objPHPExcel->getActiveSheet()->setCellValue("AD$row", "$INT_QTY_BLN07");
                $objPHPExcel->getActiveSheet()->setCellValue("AE$row", "$FLT_ADD_BLN07");
                $objPHPExcel->getActiveSheet()->setCellValue("AF$row", "$MON_AMT_BLN07");
                $objPHPExcel->getActiveSheet()->setCellValue("AG$row", "$INT_QTY_BLN08");
                $objPHPExcel->getActiveSheet()->setCellValue("AH$row", "$FLT_ADD_BLN08");
                $objPHPExcel->getActiveSheet()->setCellValue("AI$row", "$MON_AMT_BLN08");
                $objPHPExcel->getActiveSheet()->setCellValue("AJ$row", "$INT_QTY_BLN09");
                $objPHPExcel->getActiveSheet()->setCellValue("AK$row", "$FLT_ADD_BLN09");
                $objPHPExcel->getActiveSheet()->setCellValue("AL$row", "$MON_AMT_BLN09");
                $objPHPExcel->getActiveSheet()->setCellValue("AM$row", "$INT_QTY_BLN10");
                $objPHPExcel->getActiveSheet()->setCellValue("AN$row", "$FLT_ADD_BLN10");
                $objPHPExcel->getActiveSheet()->setCellValue("AO$row", "$MON_AMT_BLN10");
                $objPHPExcel->getActiveSheet()->setCellValue("AP$row", "$INT_QTY_BLN11");
                $objPHPExcel->getActiveSheet()->setCellValue("AQ$row", "$FLT_ADD_BLN11");
                $objPHPExcel->getActiveSheet()->setCellValue("AR$row", "$MON_AMT_BLN11");
                $objPHPExcel->getActiveSheet()->setCellValue("AS$row", "$INT_QTY_BLN12");
                $objPHPExcel->getActiveSheet()->setCellValue("AT$row", "$FLT_ADD_BLN12");
                $objPHPExcel->getActiveSheet()->setCellValue("AU$row", "$MON_AMT_BLN12");
                $objPHPExcel->getActiveSheet()->setCellValue("AV$row", "$INT_QTY_BLN01");
                $objPHPExcel->getActiveSheet()->setCellValue("AW$row", "$FLT_ADD_BLN01");
                $objPHPExcel->getActiveSheet()->setCellValue("AX$row", "$MON_AMT_BLN01");
                $objPHPExcel->getActiveSheet()->setCellValue("AY$row", "$INT_QTY_BLN02");
                $objPHPExcel->getActiveSheet()->setCellValue("AZ$row", "$FLT_ADD_BLN02");
                $objPHPExcel->getActiveSheet()->setCellValue("BA$row", "$MON_AMT_BLN02");
                $objPHPExcel->getActiveSheet()->setCellValue("BB$row", "$INT_QTY_BLN03");
                $objPHPExcel->getActiveSheet()->setCellValue("BC$row", "$FLT_ADD_BLN03");
                $objPHPExcel->getActiveSheet()->setCellValue("BD$row", "$MON_AMT_BLN03");
                $objPHPExcel->getActiveSheet()->setCellValue("BE$row", "$INT_QTY_SUM");
                $objPHPExcel->getActiveSheet()->setCellValue("BF$row", "$FLT_ADD_SUM");
                $objPHPExcel->getActiveSheet()->setCellValue("BG$row", "$MON_AMT_SUM");

                $seq++;
                $row++;
            }
//            $objPHPExcel->getActiveSheet()->getStyle("B8:BG$row")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $objPHPExcel->getActiveSheet()->getStyle("B8:BG$row")->applyFromArray(array(
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                )
            ));
            $row++;
            $row_min = $row - 1;
            $objPHPExcel->getActiveSheet()->setCellValue("U$row", "=SUM(U8:U$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("V$row", "=SUM(V8:V$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("W$row", "=SUM(W8:W$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("X$row", "=SUM(X8:X$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("Y$row", "=SUM(Y8:Y$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("Z$row", "=SUM(Z8:Z$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("AA$row", "=SUM(AA8:AA$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("AB$row", "=SUM(AB8:AB$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("AC$row", "=SUM(AC8:AC$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("AD$row", "=SUM(AD8:AD$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("AE$row", "=SUM(AE8:AE$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("AF$row", "=SUM(AF8:AF$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("AG$row", "=SUM(AG8:AG$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("AH$row", "=SUM(AH8:AH$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("AI$row", "=SUM(AI8:AI$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("AJ$row", "=SUM(AJ8:AJ$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("AK$row", "=SUM(AK8:AK$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("AL$row", "=SUM(AL8:AL$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("AM$row", "=SUM(AM8:AM$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("AN$row", "=SUM(AN8:AN$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("AO$row", "=SUM(AO8:AO$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("AP$row", "=SUM(AP8:AP$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("AQ$row", "=SUM(AQ8:AQ$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("AR$row", "=SUM(AR8:AR$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("AS$row", "=SUM(AS8:AS$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("AT$row", "=SUM(AT8:AT$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("AU$row", "=SUM(AU8:AU$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("AV$row", "=SUM(AV8:AV$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("AW$row", "=SUM(AW8:AW$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("AX$row", "=SUM(AX8:AX$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("AY$row", "=SUM(AY8:AY$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("AZ$row", "=SUM(AZ8:AZ$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("BA$row", "=SUM(BA8:BA$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("BB$row", "=SUM(BB8:BB$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("BC$row", "=SUM(BC8:BC$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("BD$row", "=SUM(BD8:BD$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("BE$row", "=SUM(BE8:BE$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("BF$row", "=SUM(BF8:BF$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("BG$row", "=SUM(BG8:BG$row_min)");
            $objPHPExcel->getActiveSheet()->getStyle("B8:BG$row")->applyFromArray(array(
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                ),
            ));
            $objPHPExcel->getActiveSheet()->mergeCells("B$row:T$row");
            $objPHPExcel->getActiveSheet()->setCellValue("B$row", "TOTAL");
            $objPHPExcel->getActiveSheet()->getStyle("B$row:BG$row")->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('#CCCCCC');
            $objPHPExcel->getActiveSheet()->getStyle("B$row:BG$row")->applyFromArray(array(
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
            $objDrawing->setCoordinates("AY$row");
            $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());




            ob_end_clean();
            $filename = "$CHR_FISCAL_YEAR_DESC - $budget_desc.xls";
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
    
    
    //With TOTAL per DEPT
    function download_excel_all($INT_ID_FISCAL_YEAR = null, $INT_ID_BUDGET_TYPE = null, $CHR_BUDGET_TYPE = null) {
        $user_session = $this->session->all_userdata();
        $role = $user_session['ROLE'];
        $row = 8;

        if ($CHR_BUDGET_TYPE <> null) {
            $all_dept = $this->dept_m->get_dept();  
            $budget_desc = $this->budgettype_m->get_budget_type($INT_ID_BUDGET_TYPE);
            $budget_desc = strtoupper(trim($budget_desc->CHR_BUDGET_TYPE_DESC));

            $CHR_FISCAL_YEAR_DESC = trim($this->fiscal_m->select_fiscal_year($INT_ID_FISCAL_YEAR));

            $this->load->library('excel');
            $objReader = PHPExcel_IOFactory::createReader('Excel5');
            //Create new PHPExcel object

            if ($INT_ID_BUDGET_TYPE == 3) {
                $objPHPExcel = $objReader->load("assets/template/budget/report/Template_Report_Donation.xls");
            } else if ($INT_ID_BUDGET_TYPE == '2') { //== CONSUMABLE
                $objPHPExcel = $objReader->load("assets/template/budget/report/Template_Report_Consu.xls");
            } else if ($INT_ID_BUDGET_TYPE == '7') { //== IT EXPENSE
                $objPHPExcel = $objReader->load("assets/template/budget/report/Template_Report_Itexp.xls");
            } else if ($INT_ID_BUDGET_TYPE == '4') { //== EMPLOYEE WELFARE
                $objPHPExcel = $objReader->load("assets/template/budget/report/Template_Report_Empwa.xls");
            } else if ($INT_ID_BUDGET_TYPE == '9') { //== OFFICE EQUIPMENT
                $objPHPExcel = $objReader->load("assets/template/budget/report/Template_Report_Offeq.xls");
            } else if ($INT_ID_BUDGET_TYPE == '11') { //== RENTAL EXPENSE
                $objPHPExcel = $objReader->load("assets/template/budget/report/Template_Report_Renta.xls");
            } else if ($INT_ID_BUDGET_TYPE == '12') { //== REPAIR & MAINTENANCE
                $objPHPExcel = $objReader->load("assets/template/budget/report/Template_Report_Repma.xls");
            } else if ($INT_ID_BUDGET_TYPE == '13') { //== RESEARCH & DEVELOPMENT
                $objPHPExcel = $objReader->load("assets/template/budget/report/Template_Report_Rndev.xls");
            } else if ($INT_ID_BUDGET_TYPE == '15') { //== SUBCONTRACTOR COST
                $objPHPExcel = $objReader->load("assets/template/budget/report/Template_Report_Subco.xls");
            } else if ($INT_ID_BUDGET_TYPE == '16') { //== TOOLS & EQUIPMENT
                $objPHPExcel = $objReader->load("assets/template/budget/report/Template_Report_Tooeq.xls");
            } else if ($INT_ID_BUDGET_TYPE == '17') { //== TRAINING
                $objPHPExcel = $objReader->load("assets/template/budget/report/Template_Report_Train.xls");
            } else if ($INT_ID_BUDGET_TYPE == '18') { //== TRIAL & INSPECTION COST
                $objPHPExcel = $objReader->load("assets/template/budget/report/Template_Report_Trial.xls");
            } else if ($INT_ID_BUDGET_TYPE == '22') { //== UTILITY
                $objPHPExcel = $objReader->load("assets/template/budget/report/Template_Report_Utily.xls");
            } else if ($INT_ID_BUDGET_TYPE == '24') { //== BUSINESS & TRAVEL
                $objPHPExcel = $objReader->load("assets/template/budget/report/Template_Report_Travl.xls");
            } else if ($INT_ID_BUDGET_TYPE == '29') { //== TECHNICAL FEE
                $objPHPExcel = $objReader->load("assets/template/budget/report/Template_Report_Tecfe.xls");
            } else if ($INT_ID_BUDGET_TYPE == '39') { //== LEGAL PERSONAL
                $objPHPExcel = $objReader->load("assets/template/budget/report/Template_Report_Legpr.xls");
            } else if ($INT_ID_BUDGET_TYPE == '25') { //== SALARY
                $objPHPExcel = $objReader->load("assets/template/budget/report/Template_Report_Salry.xls");
            } else if ($INT_ID_BUDGET_TYPE == '41') { //== ENTERTAINMENT EXPENSE
                $objPHPExcel = $objReader->load("assets/template/budget/report/Template_Report_Enter.xls");
            }

            $seq = 1;
            $objPHPExcel->getActiveSheet()->setCellValue("B2", "MASTER BUDGET : " . $budget_desc . " TAHUN " . $CHR_FISCAL_YEAR_DESC);
            $objPHPExcel->getActiveSheet()->setCellValue("B3", "ALL DEPARTMENT");
            
            $all_qty04 = 0;
            $all_qty05 = 0;
            $all_qty06 = 0;
            $all_qty07 = 0;
            $all_qty08 = 0;
            $all_qty09 = 0;
            $all_qty10 = 0;
            $all_qty11 = 0;
            $all_qty12 = 0;
            $all_qty01 = 0;
            $all_qty02 = 0;
            $all_qty03 = 0;
            $sum_all_qty = 0;
            
            $all_add04 = 0;
            $all_add05 = 0;
            $all_add06 = 0;
            $all_add07 = 0;
            $all_add08 = 0;
            $all_add09 = 0;
            $all_add10 = 0;
            $all_add11 = 0;
            $all_add12 = 0;
            $all_add01 = 0;
            $all_add02 = 0;
            $all_add03 = 0;
            $sum_all_add = 0;
            
            $all_amo04 = 0;
            $all_amo05 = 0;
            $all_amo06 = 0;
            $all_amo07 = 0;
            $all_amo08 = 0;
            $all_amo09 = 0;
            $all_amo10 = 0;
            $all_amo11 = 0;
            $all_amo12 = 0;
            $all_amo01 = 0;
            $all_amo02 = 0;
            $all_amo03 = 0;
            $sum_all_amo = 0;
            
            foreach($all_dept as $dept){
                $INT_DEPT = $dept->INT_ID_DEPT;
                $INT_DIV = $this->groupdept_m->get_gdept_id($INT_DEPT)->INT_ID_DIVISION;
                $INT_SECT = '';
//                if($role == 2 && $INT_DIV == 3){
//                    $detail_confirm = $this->budget_expense_m->get_detail_expense_dept_cpl($INT_ID_FISCAL_YEAR, $CHR_BUDGET_TYPE, $INT_DIV, $INT_DEPT, $INT_SECT);
//                    $detail_confirm_sum = $this->budget_expense_m->get_sum_expense_dept_cpl($INT_ID_FISCAL_YEAR, $CHR_BUDGET_TYPE, $INT_DIV, $INT_DEPT, $INT_SECT);
//                } else {
                    $detail_confirm = $this->budget_expense_m->get_detail_expense_dept($INT_ID_FISCAL_YEAR, $CHR_BUDGET_TYPE, $INT_DIV, $INT_DEPT, $INT_SECT);
                    $detail_confirm_sum = $this->budget_expense_m->get_sum_expense_dept($INT_ID_FISCAL_YEAR, $CHR_BUDGET_TYPE, $INT_DIV, $INT_DEPT, $INT_SECT);
//                }
                
                $count = count($detail_confirm);
                
                $tot_qty04 = 0;
                $tot_qty05 = 0;
                $tot_qty06 = 0;
                $tot_qty07 = 0;
                $tot_qty08 = 0;
                $tot_qty09 = 0;
                $tot_qty10 = 0;
                $tot_qty11 = 0;
                $tot_qty12 = 0;
                $tot_qty01 = 0;
                $tot_qty02 = 0;
                $tot_qty03 = 0;
                $sum_tot_qty = 0;
                
                $tot_add04 = 0;
                $tot_add05 = 0;
                $tot_add06 = 0;
                $tot_add07 = 0;
                $tot_add08 = 0;
                $tot_add09 = 0;
                $tot_add10 = 0;
                $tot_add11 = 0;
                $tot_add12 = 0;
                $tot_add01 = 0;
                $tot_add02 = 0;
                $tot_add03 = 0;
                $sum_tot_add = 0;
                
                $tot_amo04 = 0;
                $tot_amo05 = 0;
                $tot_amo06 = 0;
                $tot_amo07 = 0;
                $tot_amo08 = 0;
                $tot_amo09 = 0;
                $tot_amo10 = 0;
                $tot_amo11 = 0;
                $tot_amo12 = 0;
                $tot_amo01 = 0;
                $tot_amo02 = 0;
                $tot_amo03 = 0;
                $sum_tot_amo = 0;
                
                if($count > 0){
                    foreach ($detail_confirm as $value) {
                        $INT_SECT = $value->INT_SECT;
                        $CHR_DEPT_DESC = trim($this->dept_m->get_desc_dept($value->INT_DEPT));
                        $CHR_SECTION_DESC = trim($this->section_m->get_desc_section($value->INT_SECT));
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
                        $CHR_PURPOSE = $value->CHR_PURPOSE;
                        $CHR_BUDGET_DESC = $value->CHR_BUDGET_DESC;
                        $CHR_ITEM_DESC = $value->CHR_ITEM_DESC;
                        $CHR_SATUAN = $value->CHR_SATUAN;
                        $CHR_PART_NO = $value->CHR_PART_NO;
                        $CHR_KIND_OF = $value->CHR_KIND_OF;
                        $CHR_SHIFT = $value->CHR_SHIFT;
                        $CHR_ITEM_RENT = $value->CHR_ITEM_RENT;
                        $CHR_PROJECT_NAME = $value->CHR_PROJECT_NAME;
                        $CHR_PERIODE = $value->CHR_PERIODE;
                        $CHR_SUPPLIER_NAME = $value->CHR_SUPPLIER_NAME;
                        $CHR_ORG_CURR = $value->CHR_ORG_CURR;
                        $FLT_RATE_CURR = $value->FLT_RATE_CURR;
                        $FLT_PRICE_CURR = $value->FLT_PRICE_CURR;
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
                        $FLT_ADD_BLN01 = $value->FLT_ADD_BLN01;
                        $FLT_ADD_BLN02 = $value->FLT_ADD_BLN02;
                        $FLT_ADD_BLN03 = $value->FLT_ADD_BLN03;
                        $FLT_ADD_BLN04 = $value->FLT_ADD_BLN04;
                        $FLT_ADD_BLN05 = $value->FLT_ADD_BLN05;
                        $FLT_ADD_BLN06 = $value->FLT_ADD_BLN06;
                        $FLT_ADD_BLN07 = $value->FLT_ADD_BLN07;
                        $FLT_ADD_BLN08 = $value->FLT_ADD_BLN08;
                        $FLT_ADD_BLN09 = $value->FLT_ADD_BLN09;
                        $FLT_ADD_BLN10 = $value->FLT_ADD_BLN10;
                        $FLT_ADD_BLN11 = $value->FLT_ADD_BLN11;
                        $FLT_ADD_BLN12 = $value->FLT_ADD_BLN12;
                        $FLT_ADD_SUM = $value->FLT_ADD_SUM;
                        $INT_DEPT = $value->INT_DEPT;
                        $INT_GROUP_DEPT = $value->INT_GROUP_DEPT;
                        $INT_DIV = $value->INT_DIV;
                        $CHR_CATEGORY_PRODUCT = $value->CHR_CATEGORY_PRODUCT_DESC;

                        $objPHPExcel->getActiveSheet()->setCellValue("B$row", "$seq");
                        $objPHPExcel->getActiveSheet()->setCellValue("C$row", "$CHR_NO_BUDGET");
                        $objPHPExcel->getActiveSheet()->setCellValue("D$row", "$CHR_DEPT_DESC / $CHR_SECTION_DESC");
                        $objPHPExcel->getActiveSheet()->setCellValue("E$row", "$CHR_BUDGET_SUB_CATEGORY_DESC");
                        $objPHPExcel->getActiveSheet()->setCellValue("F$row", "$CHR_BUDGET_CATEGORY_DESC");
                        $objPHPExcel->getActiveSheet()->setCellValue("G$row", "$CHR_CODE_CATEGORY_A3_DESC");
                        $objPHPExcel->getActiveSheet()->setCellValue("H$row", "$CHR_PURPOSE");
                        $objPHPExcel->getActiveSheet()->setCellValue("I$row", "$CHR_PART_NO");
                        $objPHPExcel->getActiveSheet()->setCellValue("J$row", "$CHR_ITEM_DESC");
                        $objPHPExcel->getActiveSheet()->setCellValue("K$row", "$CHR_KIND_OF");
                        $objPHPExcel->getActiveSheet()->setCellValue("L$row", "$CHR_PROJECT_NAME");
                        $objPHPExcel->getActiveSheet()->setCellValue("M$row", "$CHR_PERIODE");
                        $objPHPExcel->getActiveSheet()->setCellValue("N$row", "$CHR_ITEM_RENT");
                        $objPHPExcel->getActiveSheet()->setCellValue("O$row", "$CHR_KIND_OF");
                        $objPHPExcel->getActiveSheet()->setCellValue("P$row", "$CHR_SUPPLIER_NAME");
                        $objPHPExcel->getActiveSheet()->setCellValue("Q$row", "$CHR_CATEGORY_PRODUCT");
                        $objPHPExcel->getActiveSheet()->setCellValue("R$row", "$CHR_SATUAN");
                        $objPHPExcel->getActiveSheet()->setCellValue("S$row", "$CHR_ORG_CURR");
                        $objPHPExcel->getActiveSheet()->setCellValue("T$row", "$FLT_RATE_CURR");
                        $objPHPExcel->getActiveSheet()->setCellValue("U$row", "$FLT_PRICE_CURR");
                        $objPHPExcel->getActiveSheet()->setCellValue("V$row", "$INT_QTY_BLN04");
                        $objPHPExcel->getActiveSheet()->setCellValue("W$row", "$FLT_ADD_BLN04");
                        $objPHPExcel->getActiveSheet()->setCellValue("X$row", "$MON_AMT_BLN04");
                        $objPHPExcel->getActiveSheet()->setCellValue("Y$row", "$INT_QTY_BLN05");
                        $objPHPExcel->getActiveSheet()->setCellValue("Z$row", "$FLT_ADD_BLN05");
                        $objPHPExcel->getActiveSheet()->setCellValue("AA$row", "$MON_AMT_BLN05");
                        $objPHPExcel->getActiveSheet()->setCellValue("AB$row", "$INT_QTY_BLN06");
                        $objPHPExcel->getActiveSheet()->setCellValue("AC$row", "$FLT_ADD_BLN06");
                        $objPHPExcel->getActiveSheet()->setCellValue("AD$row", "$MON_AMT_BLN06");
                        $objPHPExcel->getActiveSheet()->setCellValue("AE$row", "$INT_QTY_BLN07");
                        $objPHPExcel->getActiveSheet()->setCellValue("AF$row", "$FLT_ADD_BLN07");
                        $objPHPExcel->getActiveSheet()->setCellValue("AG$row", "$MON_AMT_BLN07");
                        $objPHPExcel->getActiveSheet()->setCellValue("AH$row", "$INT_QTY_BLN08");
                        $objPHPExcel->getActiveSheet()->setCellValue("AI$row", "$FLT_ADD_BLN08");
                        $objPHPExcel->getActiveSheet()->setCellValue("AJ$row", "$MON_AMT_BLN08");
                        $objPHPExcel->getActiveSheet()->setCellValue("AK$row", "$INT_QTY_BLN09");
                        $objPHPExcel->getActiveSheet()->setCellValue("AL$row", "$FLT_ADD_BLN09");
                        $objPHPExcel->getActiveSheet()->setCellValue("AM$row", "$MON_AMT_BLN09");
                        $objPHPExcel->getActiveSheet()->setCellValue("AN$row", "$INT_QTY_BLN10");
                        $objPHPExcel->getActiveSheet()->setCellValue("AO$row", "$FLT_ADD_BLN10");
                        $objPHPExcel->getActiveSheet()->setCellValue("AP$row", "$MON_AMT_BLN10");
                        $objPHPExcel->getActiveSheet()->setCellValue("AQ$row", "$INT_QTY_BLN11");
                        $objPHPExcel->getActiveSheet()->setCellValue("AR$row", "$FLT_ADD_BLN11");
                        $objPHPExcel->getActiveSheet()->setCellValue("AS$row", "$MON_AMT_BLN11");
                        $objPHPExcel->getActiveSheet()->setCellValue("AT$row", "$INT_QTY_BLN12");
                        $objPHPExcel->getActiveSheet()->setCellValue("AU$row", "$FLT_ADD_BLN12");
                        $objPHPExcel->getActiveSheet()->setCellValue("AV$row", "$MON_AMT_BLN12");
                        $objPHPExcel->getActiveSheet()->setCellValue("AW$row", "$INT_QTY_BLN01");
                        $objPHPExcel->getActiveSheet()->setCellValue("AX$row", "$FLT_ADD_BLN01");
                        $objPHPExcel->getActiveSheet()->setCellValue("AY$row", "$MON_AMT_BLN01");
                        $objPHPExcel->getActiveSheet()->setCellValue("AZ$row", "$INT_QTY_BLN02");
                        $objPHPExcel->getActiveSheet()->setCellValue("BA$row", "$FLT_ADD_BLN02");
                        $objPHPExcel->getActiveSheet()->setCellValue("BB$row", "$MON_AMT_BLN02");
                        $objPHPExcel->getActiveSheet()->setCellValue("BC$row", "$INT_QTY_BLN03");
                        $objPHPExcel->getActiveSheet()->setCellValue("BD$row", "$FLT_ADD_BLN03");
                        $objPHPExcel->getActiveSheet()->setCellValue("BE$row", "$MON_AMT_BLN03");
                        $objPHPExcel->getActiveSheet()->setCellValue("BF$row", "$INT_QTY_SUM");
                        $objPHPExcel->getActiveSheet()->setCellValue("BG$row", "$FLT_ADD_SUM");
                        $objPHPExcel->getActiveSheet()->setCellValue("BH$row", "$MON_AMT_SUM");
                        
                        $tot_qty04 = $tot_qty04 + $INT_QTY_BLN04;
                        $tot_qty05 = $tot_qty05 + $INT_QTY_BLN05;
                        $tot_qty06 = $tot_qty06 + $INT_QTY_BLN06;
                        $tot_qty07 = $tot_qty07 + $INT_QTY_BLN07;
                        $tot_qty08 = $tot_qty08 + $INT_QTY_BLN08;
                        $tot_qty09 = $tot_qty09 + $INT_QTY_BLN09;
                        $tot_qty10 = $tot_qty10 + $INT_QTY_BLN10;
                        $tot_qty11 = $tot_qty11 + $INT_QTY_BLN11;
                        $tot_qty12 = $tot_qty12 + $INT_QTY_BLN12;
                        $tot_qty01 = $tot_qty01 + $INT_QTY_BLN01;
                        $tot_qty02 = $tot_qty02 + $INT_QTY_BLN02;
                        $tot_qty03 = $tot_qty03 + $INT_QTY_BLN03;
                        $sum_tot_qty = $sum_tot_qty + $INT_QTY_SUM;

                        $tot_add04 = $tot_add04 + $FLT_ADD_BLN04;
                        $tot_add05 = $tot_add05 + $FLT_ADD_BLN05;
                        $tot_add06 = $tot_add06 + $FLT_ADD_BLN06;
                        $tot_add07 = $tot_add07 + $FLT_ADD_BLN07;
                        $tot_add08 = $tot_add08 + $FLT_ADD_BLN08;
                        $tot_add09 = $tot_add09 + $FLT_ADD_BLN09;
                        $tot_add10 = $tot_add10 + $FLT_ADD_BLN10;
                        $tot_add11 = $tot_add11 + $FLT_ADD_BLN11;
                        $tot_add12 = $tot_add12 + $FLT_ADD_BLN12;
                        $tot_add01 = $tot_add01 + $FLT_ADD_BLN01;
                        $tot_add02 = $tot_add02 + $FLT_ADD_BLN02;
                        $tot_add03 = $tot_add03 + $FLT_ADD_BLN03;
                        $sum_tot_add = $sum_tot_add + $FLT_ADD_SUM;

                        $tot_amo04 = $tot_amo04 + $MON_AMT_BLN04;
                        $tot_amo05 = $tot_amo05 + $MON_AMT_BLN05;
                        $tot_amo06 = $tot_amo06 + $MON_AMT_BLN06;
                        $tot_amo07 = $tot_amo07 + $MON_AMT_BLN07;
                        $tot_amo08 = $tot_amo08 + $MON_AMT_BLN08;
                        $tot_amo09 = $tot_amo09 + $MON_AMT_BLN09;
                        $tot_amo10 = $tot_amo10 + $MON_AMT_BLN10;
                        $tot_amo11 = $tot_amo11 + $MON_AMT_BLN11;
                        $tot_amo12 = $tot_amo12 + $MON_AMT_BLN12;
                        $tot_amo01 = $tot_amo01 + $MON_AMT_BLN01;
                        $tot_amo02 = $tot_amo02 + $MON_AMT_BLN02;
                        $tot_amo03 = $tot_amo03 + $MON_AMT_BLN03;
                        $sum_tot_amo = $sum_tot_amo + $MON_AMT_SUM;

                        $row++;
                        $seq++;
                    }
                    
                    //$objPHPExcel->getActiveSheet()->getStyle("B8:BH$row")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                    $objPHPExcel->getActiveSheet()->getStyle("B8:BH$row")->applyFromArray(array(
                        'borders' => array(
                            'allborders' => array(
                                'style' => PHPExcel_Style_Border::BORDER_THIN
                            )
                        )
                    ));
                    
                    $objPHPExcel->getActiveSheet()->setCellValue("V$row", "$tot_qty04");
                    $objPHPExcel->getActiveSheet()->setCellValue("W$row", "$tot_add04");
                    $objPHPExcel->getActiveSheet()->setCellValue("X$row", "$tot_amo04");
                    $objPHPExcel->getActiveSheet()->setCellValue("Y$row", "$tot_qty05");
                    $objPHPExcel->getActiveSheet()->setCellValue("Z$row", "$tot_add05");
                    $objPHPExcel->getActiveSheet()->setCellValue("AA$row", "$tot_amo05");
                    $objPHPExcel->getActiveSheet()->setCellValue("AB$row", "$tot_qty06");
                    $objPHPExcel->getActiveSheet()->setCellValue("AC$row", "$tot_add06");
                    $objPHPExcel->getActiveSheet()->setCellValue("AD$row", "$tot_amo06");
                    $objPHPExcel->getActiveSheet()->setCellValue("AE$row", "$tot_qty07");
                    $objPHPExcel->getActiveSheet()->setCellValue("AF$row", "$tot_add07");
                    $objPHPExcel->getActiveSheet()->setCellValue("AG$row", "$tot_amo07");
                    $objPHPExcel->getActiveSheet()->setCellValue("AH$row", "$tot_qty08");
                    $objPHPExcel->getActiveSheet()->setCellValue("AI$row", "$tot_add08");
                    $objPHPExcel->getActiveSheet()->setCellValue("AJ$row", "$tot_amo08");
                    $objPHPExcel->getActiveSheet()->setCellValue("AK$row", "$tot_qty09");
                    $objPHPExcel->getActiveSheet()->setCellValue("AL$row", "$tot_add09");
                    $objPHPExcel->getActiveSheet()->setCellValue("AM$row", "$tot_amo09");
                    $objPHPExcel->getActiveSheet()->setCellValue("AN$row", "$tot_qty10");
                    $objPHPExcel->getActiveSheet()->setCellValue("AO$row", "$tot_add10");
                    $objPHPExcel->getActiveSheet()->setCellValue("AP$row", "$tot_amo10");
                    $objPHPExcel->getActiveSheet()->setCellValue("AQ$row", "$tot_qty11");
                    $objPHPExcel->getActiveSheet()->setCellValue("AR$row", "$tot_add11");
                    $objPHPExcel->getActiveSheet()->setCellValue("AS$row", "$tot_amo11");
                    $objPHPExcel->getActiveSheet()->setCellValue("AT$row", "$tot_qty12");
                    $objPHPExcel->getActiveSheet()->setCellValue("AU$row", "$tot_add12");
                    $objPHPExcel->getActiveSheet()->setCellValue("AV$row", "$tot_amo12");
                    $objPHPExcel->getActiveSheet()->setCellValue("AW$row", "$tot_qty01");
                    $objPHPExcel->getActiveSheet()->setCellValue("AX$row", "$tot_add01");
                    $objPHPExcel->getActiveSheet()->setCellValue("AY$row", "$tot_amo01");
                    $objPHPExcel->getActiveSheet()->setCellValue("AZ$row", "$tot_qty02");
                    $objPHPExcel->getActiveSheet()->setCellValue("BA$row", "$tot_add02");
                    $objPHPExcel->getActiveSheet()->setCellValue("BB$row", "$tot_amo02");
                    $objPHPExcel->getActiveSheet()->setCellValue("BC$row", "$tot_qty03");
                    $objPHPExcel->getActiveSheet()->setCellValue("BD$row", "$tot_add03");
                    $objPHPExcel->getActiveSheet()->setCellValue("BE$row", "$tot_amo03");
                    $objPHPExcel->getActiveSheet()->setCellValue("BF$row", "$sum_tot_qty");
                    $objPHPExcel->getActiveSheet()->setCellValue("BG$row", "$sum_tot_add");
                    $objPHPExcel->getActiveSheet()->setCellValue("BH$row", "$sum_tot_amo");
                    
                    $objPHPExcel->getActiveSheet()->getStyle("B8:BH$row")->applyFromArray(array(
                        'borders' => array(
                            'allborders' => array(
                                'style' => PHPExcel_Style_Border::BORDER_THIN
                            )
                        ),
                    ));
                    
                    $objPHPExcel->getActiveSheet()->mergeCells("B$row:U$row");
                    $objPHPExcel->getActiveSheet()->setCellValue("B$row", "TOTAL");
                    $objPHPExcel->getActiveSheet()->getStyle("B$row:BH$row")->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('#CCCCCC');
                    $objPHPExcel->getActiveSheet()->getStyle("B$row:BH$row")->applyFromArray(array(
                        'font' => array(
                            'bold' => true,
                            'size' => 12
                        )
                    ));
                }
                
                $all_qty04 = $all_qty04 + $tot_qty04;
                $all_qty05 = $all_qty05 + $tot_qty05;
                $all_qty06 = $all_qty06 + $tot_qty06;
                $all_qty07 = $all_qty07 + $tot_qty07;
                $all_qty08 = $all_qty08 + $tot_qty08;
                $all_qty09 = $all_qty09 + $tot_qty09;
                $all_qty10 = $all_qty10 + $tot_qty10;
                $all_qty11 = $all_qty11 + $tot_qty11;
                $all_qty12 = $all_qty12 + $tot_qty12;
                $all_qty01 = $all_qty01 + $tot_qty01;
                $all_qty02 = $all_qty02 + $tot_qty02;
                $all_qty03 = $all_qty03 + $tot_qty03;
                $sum_all_qty = $sum_all_qty + $sum_tot_qty;

                $all_add04 = $all_add04 + $tot_add04;
                $all_add05 = $all_add05 + $tot_add05;
                $all_add06 = $all_add06 + $tot_add06;
                $all_add07 = $all_add07 + $tot_add07;
                $all_add08 = $all_add08 + $tot_add08;
                $all_add09 = $all_add09 + $tot_add09;
                $all_add10 = $all_add10 + $tot_add10;
                $all_add11 = $all_add11 + $tot_add11;
                $all_add12 = $all_add12 + $tot_add12;
                $all_add01 = $all_add01 + $tot_add01;
                $all_add02 = $all_add02 + $tot_add02;
                $all_add03 = $all_add03 + $tot_add03;
                $sum_all_add = $sum_all_add + $sum_tot_add;

                $all_amo04 = $all_amo04 + $tot_amo04;
                $all_amo05 = $all_amo05 + $tot_amo05;
                $all_amo06 = $all_amo06 + $tot_amo06;
                $all_amo07 = $all_amo07 + $tot_amo07;
                $all_amo08 = $all_amo08 + $tot_amo08;
                $all_amo09 = $all_amo09 + $tot_amo09;
                $all_amo10 = $all_amo10 + $tot_amo10;
                $all_amo11 = $all_amo11 + $tot_amo11;
                $all_amo12 = $all_amo12 + $tot_amo12;
                $all_amo01 = $all_amo01 + $tot_amo01;
                $all_amo02 = $all_amo02 + $tot_amo02;
                $all_amo03 = $all_amo03 + $tot_amo03;
                $sum_all_amo = $sum_all_amo + $sum_tot_amo; 
                
                if($count != 0){
                    $row++;
                }
            }

            //$objPHPExcel->getActiveSheet()->getStyle("B8:BG$row")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $objPHPExcel->getActiveSheet()->getStyle("B8:BG$row")->applyFromArray(array(
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                )
            ));

            $objPHPExcel->getActiveSheet()->setCellValue("V$row", "$all_qty04");
            $objPHPExcel->getActiveSheet()->setCellValue("W$row", "$all_add04");
            $objPHPExcel->getActiveSheet()->setCellValue("X$row", "$all_amo04");
            $objPHPExcel->getActiveSheet()->setCellValue("Y$row", "$all_qty05");
            $objPHPExcel->getActiveSheet()->setCellValue("Z$row", "$all_add05");
            $objPHPExcel->getActiveSheet()->setCellValue("AA$row", "$all_amo05");
            $objPHPExcel->getActiveSheet()->setCellValue("AB$row", "$all_qty06");
            $objPHPExcel->getActiveSheet()->setCellValue("AC$row", "$all_add06");
            $objPHPExcel->getActiveSheet()->setCellValue("AD$row", "$all_amo06");
            $objPHPExcel->getActiveSheet()->setCellValue("AE$row", "$all_qty07");
            $objPHPExcel->getActiveSheet()->setCellValue("AF$row", "$all_add07");
            $objPHPExcel->getActiveSheet()->setCellValue("AG$row", "$all_amo07");
            $objPHPExcel->getActiveSheet()->setCellValue("AH$row", "$all_qty08");
            $objPHPExcel->getActiveSheet()->setCellValue("AI$row", "$all_add08");
            $objPHPExcel->getActiveSheet()->setCellValue("AJ$row", "$all_amo08");
            $objPHPExcel->getActiveSheet()->setCellValue("AK$row", "$all_qty09");
            $objPHPExcel->getActiveSheet()->setCellValue("AL$row", "$all_add09");
            $objPHPExcel->getActiveSheet()->setCellValue("AM$row", "$all_amo09");
            $objPHPExcel->getActiveSheet()->setCellValue("AN$row", "$all_qty10");
            $objPHPExcel->getActiveSheet()->setCellValue("AO$row", "$all_add10");
            $objPHPExcel->getActiveSheet()->setCellValue("AP$row", "$all_amo10");
            $objPHPExcel->getActiveSheet()->setCellValue("AQ$row", "$all_qty11");
            $objPHPExcel->getActiveSheet()->setCellValue("AR$row", "$all_add11");
            $objPHPExcel->getActiveSheet()->setCellValue("AS$row", "$all_amo11");
            $objPHPExcel->getActiveSheet()->setCellValue("AT$row", "$all_qty12");
            $objPHPExcel->getActiveSheet()->setCellValue("AU$row", "$all_add12");
            $objPHPExcel->getActiveSheet()->setCellValue("AV$row", "$all_amo12");
            $objPHPExcel->getActiveSheet()->setCellValue("AW$row", "$all_qty01");
            $objPHPExcel->getActiveSheet()->setCellValue("AX$row", "$all_add01");
            $objPHPExcel->getActiveSheet()->setCellValue("AY$row", "$all_amo01");
            $objPHPExcel->getActiveSheet()->setCellValue("AZ$row", "$all_qty02");
            $objPHPExcel->getActiveSheet()->setCellValue("BA$row", "$all_add02");
            $objPHPExcel->getActiveSheet()->setCellValue("BB$row", "$all_amo02");
            $objPHPExcel->getActiveSheet()->setCellValue("BC$row", "$all_qty03");
            $objPHPExcel->getActiveSheet()->setCellValue("BD$row", "$all_add03");
            $objPHPExcel->getActiveSheet()->setCellValue("BE$row", "$all_amo03");
            $objPHPExcel->getActiveSheet()->setCellValue("BF$row", "$sum_all_qty");
            $objPHPExcel->getActiveSheet()->setCellValue("BG$row", "$sum_all_add");
            $objPHPExcel->getActiveSheet()->setCellValue("BH$row", "$sum_all_amo");
            $objPHPExcel->getActiveSheet()->getStyle("B8:BH$row")->applyFromArray(array(
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                ),
            ));
            $objPHPExcel->getActiveSheet()->mergeCells("B$row:U$row");
            $objPHPExcel->getActiveSheet()->setCellValue("B$row", "GRAND TOTAL");
            $objPHPExcel->getActiveSheet()->getStyle("B$row:BH$row")->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('#CCCCCC');
            $objPHPExcel->getActiveSheet()->getStyle("B$row:BH$row")->applyFromArray(array(
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
            $objDrawing->setCoordinates("AY$row");
            $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());




            ob_end_clean();
            $filename = "$CHR_FISCAL_YEAR_DESC - $budget_desc.xls";
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

}

?>