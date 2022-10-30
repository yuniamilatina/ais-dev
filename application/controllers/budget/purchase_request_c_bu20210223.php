<?php

class purchase_request_c extends CI_Controller {

    private $layout = '/template/head';
    private $back_to_manage = 'budget/purchase_request_c/index/';
    private $back_to_create = 'budget/purchase_request_c/create_purchase_request/';
    private $back_to_approve = 'budget/purchase_request_c/prepare_approve_purchase_request/';

    public function __construct() {
        parent::__construct();
        $this->load->model('budget/purchase_request_m');
        $this->load->model('budget/budget_expense_m');
        $this->load->model('budget/purchase_request_detail_m');
        $this->load->model('basis/log_m');
        $this->load->model('basis/role_module_m');
        $this->load->model('budget/fiscal_m');
        $this->load->model('basis/user_m');
        $this->load->model('organization/section_m');
        $this->load->model('organization/dept_m');
        $this->load->model('organization/groupdept_m');
        $this->load->model('organization/division_m');
        $this->load->model('portal/news_m');
        $this->load->model('budget/budgetsubcategory_m');
        $this->load->model('budget/budgetcategory_m');
        $this->load->model('budget/capex_plan_m');
    }

    function index($msg = NULL) {
        $this->role_module_m->authorization('31');
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

        $new_fiscal = $this->fiscal_m->get_id_fiscal_this_year();

        $session = $this->session->all_userdata();
        if ($session['ROLE'] === 2 || $session['ROLE'] === 1) {
            $data_contain = $this->purchase_request_m->get_purchase_request_by_admin($new_fiscal);
            $contain = 'budget/purchase_request/manage_purchase_request_v';
        } else if ($session['ROLE'] === 6) {
            $data_contain = $this->purchase_request_m->get_purchase_request_by_supervisor($session['SECTION'], $new_fiscal);
            $contain = 'budget/purchase_request/manage_purchase_request_v';
            $group = $this->section_m->get_name_section($session['SECTION']);
            $data['group'] = $group;
        }

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(31);
        $data['msg'] = $msg;
        $data['title'] = 'Manage Purchase Request';
        $data['news'] = $this->news_m->get_news();

        $data['data_fiscal'] = $this->fiscal_m->get_fiscal();
        $data['fiscal'] = $this->fiscal_m->select_fiscal_year($new_fiscal);
        $data['new_fiscal'] = $new_fiscal;
        $data['data'] = $data_contain;
        $data['content'] = $contain;

        $this->load->view($this->layout, $data);
    }

    function prepare_approve_purchase_request($msg = NULL) {
        $this->role_module_m->authorization('44');
        $new_fiscal = $this->fiscal_m->get_id_fiscal_this_year();

        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Approving success </strong> The data is successfully approved </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Approving failed </strong> You must selected at least one data </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Rejecting success </strong> The data is successfully rejected </div >";
        } else {
            $msg = "";
        }

        $session = $this->session->all_userdata();
        if ($session['ROLE'] === 2 || $session['ROLE'] === 1) {
            $data_contain = $this->purchase_request_m->get_purchase_request_approve_by_admin($new_fiscal);
            $data_containt_detail = $this->purchase_request_m->get_purchase_request_detail_by_admin($new_fiscal);
            $contain = 'budget/purchase_request/approve_by_admin_v';
            $data['group'] = '';
        } else if ($session['ROLE'] === 4) {
            $data_contain = $this->purchase_request_m->get_purchase_request_by_gm($session['GROUPDEPT'], $new_fiscal);
            $data_containt_detail = $this->purchase_request_m->get_purchase_request_detail_by_gm($session['GROUPDEPT'], $new_fiscal);
            $contain = 'budget/purchase_request/approve_by_gm_v';
            $group = $this->groupdept_m->get_name_groupdept($session['GROUPDEPT']);
            $data['group'] = $group;
        } else if ($session['ROLE'] === 5) {
            $data_contain = $this->purchase_request_m->get_purchase_request_by_manager($session['DEPT'], $new_fiscal);
            $data_containt_detail = $this->purchase_request_m->get_purchase_request_detail_by_manager($session['DEPT'], $new_fiscal);
            $contain = 'budget/purchase_request/approve_by_manager_v';
            $group = $this->dept_m->get_name_dept($session['DEPT']);
            $data['group'] = $group;
        }

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(44);
        $data['news'] = $this->news_m->get_news();
        $data['msg'] = $msg;

        $data['data_fiscal'] = $this->fiscal_m->get_fiscal();
        $data['fiscal'] = $this->fiscal_m->select_fiscal_year($new_fiscal);
        $data['new_fiscal'] = $new_fiscal;
        $data['data'] = $data_contain;
        $data['data_pureq_detail'] = $data_containt_detail;

        $data['content'] = $contain;
        $data['title'] = 'Approve Purchase Request';

        $this->load->view($this->layout, $data);
    }

    function search_purchase_request() {
        $this->role_module_m->authorization('44');
        $this->load->model('budget/capex_plan_m');

        $fiscal = $this->input->post('INT_ID_FISCAL_YEAR');

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(44);
        $data['news'] = $this->news_m->get_news();

        $session = $this->session->all_userdata();
        if ($session['ROLE'] === 2 || $session['ROLE'] === 1) {
            $data_contain = $this->purchase_request_m->get_purchase_request_close_by_admin($fiscal);
            $contain = 'budget/purchase_request/manage_purchase_request_v';
        } else if ($session['ROLE'] === 3) {
            $data_contain = $this->purchase_request_m->get_purchase_request_by_director($session['DIVISION'], $fiscal);
            $data_containt_detail = $this->purchase_request_m->get_purchase_request_detail_by_manager($session['DEPT'], $fiscal);
            $contain = 'budget/purchase_request/approve_by_director_v';
            $division = $this->division_m->get_name_division($session['DIVISION']);
            $data['group'] = $division;
        } else if ($session['ROLE'] === 4) {
            $data_contain = $this->purchase_request_m->get_purchase_request_by_gm($session['GROUPDEPT'], $fiscal);
            $data_containt_detail = $this->purchase_request_m->get_purchase_request_detail_by_manager($session['DEPT'], $fiscal);
            $contain = 'budget/purchase_request/approve_by_gm_v';
            $groupdept = $this->groupdept_m->get_name_groupdept($session['GROUPDEPT']);
            $data['group'] = $groupdept;
        } else if ($session['ROLE'] === 5) {
            $data_contain = $this->purchase_request_m->get_purchase_request_by_manager($session['DEPT'], $fiscal);
            $data_containt_detail = $this->purchase_request_m->get_purchase_request_detail_by_manager($session['DEPT'], $fiscal);
            $contain = 'budget/purchase_request/approve_by_manager_v';
            $dept = $this->dept_m->get_name_dept($session['DEPT']);
            $data['group'] = $dept;
            $data['total_plan'] = $this->capex_plan_m->get_total_capex_plan_by_manager($session['DEPT'], $fiscal);
        } else if ($session['ROLE'] === 6) {
            $data_contain = $this->purchase_request_m->get_purchase_request_close_by_section($session['SECTION'], $fiscal);
            $contain = 'budget/purchase_request/manage_purchase_request_v';
            $group = $this->section_m->get_name_section($session['SECTION']);
            $data['group'] = $group;
        }

        $data['data_fiscal'] = $this->fiscal_m->get_fiscal();
        $data['new_fiscal'] = $fiscal;
        $data['fiscal'] = $this->fiscal_m->select_fiscal_year($fiscal);
        $data['msg'] = null;

        $data['data'] = $data_contain;
        $data['data_pureq_detail'] = $data_containt_detail;
        $data['content'] = $contain;
        $data['title'] = 'Purchase Request Budget';

        $this->load->view($this->layout, $data);
    }

    //filtering
    function select_manager_approves($msg = null) {
        $this->role_module_m->authorization('31');
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

        $new_fiscal = $this->fiscal_m->get_id_fiscal_this_year();

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(31);
        $data['news'] = $this->news_m->get_news();
        $data['msg'] = $msg;
        $data['title'] = 'Manage Planning Capex';
        $data['content'] = 'budget/purchase_request/manage_purchase_request_v';

        $data['data'] = $this->purchase_request_m->get_purchase_request_approved_by_manager($new_fiscal);

        $this->load->view($this->layout, $data);
    }

    //filtering
    function select_gm_approves($msg = null) {
        $this->role_module_m->authorization('31');
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

        $new_fiscal = $this->fiscal_m->get_id_fiscal_this_year();

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(31);
        $data['news'] = $this->news_m->get_news();

        $data['msg'] = $msg;
        $data['data'] = $this->purchase_request_m->get_purchase_request_approved_by_gm($new_fiscal);
        $data['content'] = 'budget/purchase_request/manage_purchase_request_v';
        $data['title'] = 'Manage Planning Capex';

        $this->load->view($this->layout, $data);
    }

    //filtering
    function select_no_approves($msg = null) {
        $this->role_module_m->authorization('31');
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

        $new_fiscal = $this->fiscal_m->get_id_fiscal_this_year();

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(31);
        $data['news'] = $this->news_m->get_news();

        $data['msg'] = $msg;
        $data['data'] = $this->purchase_request_m->get_purchase_request_approved_by_no_one($new_fiscal);
        $data['content'] = 'budget/purchase_request/manage_purchase_request_v';
        $data['title'] = 'Manage Planning Capex';

        $this->load->view($this->layout, $data);
    }

    function buildDropSection() {
        echo $id_dept = $this->input->post('id', TRUE);
        $data['data_section'] = $this->section_m->get_section_by_dept($id_dept);
        $output = null;
        foreach ($data['data_section'] as $row) {
            $output .= "<option value='" . $row->INT_ID_SECTION . "'>" . $row->CHR_SECTION . ' - ' . $row->CHR_SECTION_DESC . "</option>";
        }
        echo $output;
    }

    function create_purchase_request($param, $cip = null, $section = null, $dept = null, $msg = null) {
        $this->role_module_m->authorization('31');
        $this->load->model('budget/capex_plan_m');
        $this->load->model('budget/budgettype_m');
        $this->load->model('budget/unit_m');
        $session = $this->session->all_userdata();

        $new_fiscal = $this->fiscal_m->get_id_fiscal_this_year();
        $cip = 0;
        if ($session['ROLE'] === 1 || $session['ROLE'] === 2) {
            $section = $this->input->post('INT_ID_SECTION');
            $dept = $this->input->post('INT_ID_DEPT');
        } else if ($session['ROLE'] === 6) {
            $section = $session['SECTION'];
            $dept = $session['DEPT'];
        }

        if ($param == 1) {
            $this->purchase_request_detail_m->delete();
        }

        $data['stat_cip'] = $cip;
        $data['dept'] = $dept;
        $data['section'] = $section;

        $data['title'] = 'Create Purchase Request';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(31);
        $data['news'] = $this->news_m->get_news();
        $data['msg'] = $msg;

        $data['data_dept'] = $this->dept_m->get_dept();
        $data['data_section'] = $this->section_m->get_section();
        $data['data_unit'] = $this->unit_m->get_unit();
        $data['new_fiscal'] = $this->fiscal_m->get_id_fiscal_this_year();
        $data['data_budgetsubcategory'] = $this->budgetsubcategory_m->get_budgetsubcategory();
        $data['data_budgetcategory'] = $this->budgetcategory_m->get_budgetcategory_capex();

        $data['subcontent'] = null;
        $data['flag'] = $this->purchase_request_detail_m->get_flag_exixs();
        $data['data'] = $this->purchase_request_detail_m->get_budget($new_fiscal, $cip, $section);
        $data['data_pr'] = $this->purchase_request_detail_m->get_purchase_request_detail_temp();
        $data['content'] = 'budget/purchase_request/create_purchase_request_v';

        $this->load->view($this->layout, $data);
    }

    function search_budget_capex($msg = null) {
        $this->role_module_m->authorization('31');
        $this->load->model('budget/capex_plan_m');
        $this->load->model('budget/budgettype_m');
        $this->load->model('budget/unit_m');
        $session = $this->session->all_userdata();

        $param = 1;
        $new_fiscal = $this->fiscal_m->get_id_fiscal_this_year();
        $cip = $this->input->post('BIT_FLG_CIP');

        if ($session['ROLE'] === 1 || $session['ROLE'] === 2) {
            $section = $this->input->post('INT_ID_SECTION');
            $dept = $this->input->post('INT_ID_DEPT');
        } else if ($session['ROLE'] === 6) {
            $section = $session['SECTION'];
            $dept = $session['DEPT'];
        }

        if ($param == 1) {
            $this->purchase_request_detail_m->delete();
        }

        $data['title'] = 'Create Purchase Request';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(31);
        $data['news'] = $this->news_m->get_news();
        $data['msg'] = $msg;

        $data['stat_cip'] = $cip;
        $data['dept'] = $dept;
        $data['section'] = $section;

        $data['data_dept'] = $this->dept_m->get_dept();
        $data['data_unit'] = $this->unit_m->get_unit();
        $data['data_section'] = $this->section_m->get_section();
        $data['data_type'] = $this->budgettype_m->get_budgettype();
        $data['new_fiscal'] = $this->fiscal_m->get_id_fiscal_this_year();
        $data['data_budgetsubcategory'] = $this->budgetsubcategory_m->get_budgetsubcategory();
        $data['data_budgetcategory'] = $this->budgetcategory_m->get_budgetcategory_capex();

        $data['subcontent'] = null;
        $data['flag'] = $this->purchase_request_detail_m->get_flag_exixs();
        $data['data'] = $this->purchase_request_detail_m->get_budget($new_fiscal, $cip, $section);
        $data['data_pr'] = $this->purchase_request_detail_m->get_purchase_request_detail_temp();
        $data['content'] = 'budget/purchase_request/create_purchase_request_v';

        $this->load->view($this->layout, $data);
    }

    function create_purchase_request_e($msg = NULL, $filter = NULL) {
        $this->load->model('budget/budgettype_m');

        $this->role_module_m->authorization('31');
        if ($msg == 1) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Saving failed. </strong> The amount limit exceeded. </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-success'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Saving success. </strong> The data is successfully created. </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Reset table success. </strong> The data is successfully cleared. </div >";
        }
        $data['msg'] = $msg;
        $data['title'] = 'Create Purchase Request';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(31);
        $data['news'] = $this->news_m->get_news();

        $fiscal = $this->fiscal_m->get_id_fiscal_this_year();
        $user_session = $this->session->all_userdata();
        $user = $this->user_m->get_user_org($user_session['NPK']);
        $data['filter'] = 0;
        $data['disable'] = NULL;
        if ($filter != NULL) {
            $data['filter'] = $filter;
        }

        //data budget table
        $data['data'] = $this->purchase_request_detail_m->get_budget_e($fiscal, $user->INT_ID_SECTION, NULL);
        $data['data_minus'] = $this->purchase_request_detail_m->get_minus_budget_e($fiscal, $user->INT_ID_SECTION);
        $data['data_type'] = $this->budgettype_m->get_budgettype_expense($user->INT_ID_SECTION, $fiscal);
        $data['org'] = $user;
        //header budget table
        $data['total_budget'] = $this->purchase_request_detail_m->get_total_budget($fiscal, $user->INT_ID_SECTION);
        $data['total_remain'] = $data['total_budget'] - $this->purchase_request_detail_m->get_total_remain($fiscal, $user->INT_ID_SECTION);

        $data['content'] = 'budget/purchase_request/create_purchase_request_e_v';
        $data['temp_pr'] = null;
        $data['pr_form'] = null;

        //temp table
        $data['temp_table'] = NULL;
        $data['temp_table_total'] = null;
        if ($this->purchase_request_detail_m->get_temp_table($user->INT_ID_SECTION) != NULL) {
            $data['temp_table'] = $this->purchase_request_detail_m->get_temp_table($user->INT_ID_SECTION);
            $data['temp_table_total'] = $this->purchase_request_detail_m->get_temp_table_total($user->INT_ID_SECTION);
            $data['temp_pr'] = 'budget/purchase_request/purchase_request_temp_resume_v';
        }

        $this->load->view($this->layout, $data);
    }

    function search_budget_e($msg = NULL) {
        $this->load->model('budget/budgettype_m');
        $type = $this->input->post('INT_ID_BUDGET_TYPE');


        $this->role_module_m->authorization('31');
        if ($msg == 1) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Saving failed. </strong> The amount limit exceeded. </div >";
        }
        $data['msg'] = $msg;
        $data['title'] = 'Create Purchase Request';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(31);
        $data['news'] = $this->news_m->get_news();

        $fiscal = $this->fiscal_m->get_id_fiscal_this_year();
        $user_session = $this->session->all_userdata();
        $user = $this->user_m->get_user_org($user_session['NPK']);
        $data['data'] = $this->purchase_request_detail_m->get_budget_e($fiscal, $user->INT_ID_SECTION, $type);
        $data['data_minus'] = $this->purchase_request_detail_m->get_minus_budget_e($fiscal, $user->INT_ID_SECTION);
        $data['data_type'] = $this->budgettype_m->get_budgettype_expense($user->INT_ID_SECTION, $fiscal);
        $data['org'] = $user;

        $data['total_budget'] = $this->purchase_request_detail_m->get_total_budget($fiscal, $user->INT_ID_SECTION);
        $data['total_remain'] = $data['total_budget'] - $this->purchase_request_detail_m->get_total_remain($fiscal, $user->INT_ID_SECTION);
        $data['disable'] = NULL;
        $data['filter'] = $type;


        $data['content'] = 'budget/purchase_request/create_purchase_request_e_v';
        $data['temp_pr'] = null;
        $data['pr_form'] = null;

        $data['temp_table'] = NULL;
        $data['temp_table_total'] = null;
        if ($this->purchase_request_detail_m->get_temp_table($user->INT_ID_SECTION) != NULL) {
            $data['temp_table'] = $this->purchase_request_detail_m->get_temp_table($user->INT_ID_SECTION);
            $data['temp_table_total'] = $this->purchase_request_detail_m->get_temp_table_total($user->INT_ID_SECTION);
            $data['temp_pr'] = 'budget/purchase_request/purchase_request_temp_resume_v';
        }

        $this->load->view($this->layout, $data);
    }

    function add_pureq_detail_e($id, $filter, $eos, $full, $msg = NULL) {
        $this->load->model('budget/budgettype_m');

        if ($msg == 1) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Saving failed. </strong> The amount limit exceeded. </div >";
        }

        $data['msg'] = $msg;
        $this->role_module_m->authorization('31');

        $data['title'] = 'Create Purchase Request';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(31);
        $data['news'] = $this->news_m->get_news();
        $data['full'] = $full;

        $fiscal = $this->fiscal_m->get_id_fiscal_this_year();
        $user_session = $this->session->all_userdata();
        $user = $this->user_m->get_user_org($user_session['NPK']);
        $data['total_budget'] = $this->purchase_request_detail_m->get_total_budget($fiscal, $user->INT_ID_SECTION);
        $data['total_remain'] = $data['total_budget'] - $this->purchase_request_detail_m->get_total_remain($fiscal, $user->INT_ID_SECTION);
        $data['data'] = $this->purchase_request_detail_m->get_budget_e($fiscal, $user->INT_ID_SECTION, $filter);
        $data['data_minus'] = $this->purchase_request_detail_m->get_minus_budget_e($fiscal, $user->INT_ID_SECTION);

        //temp table
        $data['temp_table'] = $this->purchase_request_detail_m->get_temp_table($user->INT_ID_SECTION);
        $data['temp_table_total'] = $this->purchase_request_detail_m->get_temp_table_total($user->INT_ID_SECTION);

        //head details budget
        $data['data_head'] = $this->purchase_request_detail_m->get_budget_head_e($id, $fiscal);
        $data['data_head_minus'] = 0;

        $data['total_qty'] = 0;
        if ($eos == 's') {
            $qty_plan = $this->budget_expense_m->get_total_qty_plan($id);
            $qty_real = $this->purchase_request_detail_m->get_total_qty_real($id);
            $data['total_qty'] = $qty_plan - $qty_real;
            if ($data['total_qty'] < 0) {
                $data['total_qty'] = 0;
            }
        }

        $data['data_type'] = $this->budgettype_m->get_budgettype_expense($user->INT_ID_SECTION, $fiscal);
        $data['filter'] = $filter;
        $data['org'] = $user;
        $data['disable'] = NULL;
        $data['eos'] = $eos;

        $data['fiscal'] = $this->fiscal_m->get_data_for_ddl($fiscal);


        $data['content'] = 'budget/purchase_request/create_purchase_request_e_v';
        $data['temp_pr'] = 'budget/purchase_request/purchase_request_temp_resume_v';
        $data['pr_form'] = 'budget/purchase_request/add_purchase_request_detail_e_v';

        $this->load->view($this->layout, $data);
    }

    function add_budget_to_pureq_temp_e($id, $full, $eos) {
        $fiscal = $this->fiscal_m->get_id_fiscal_this_year();
        $session = $this->session->all_userdata();
        $user = $this->user_m->get_user_org($session['NPK']);
        $item = $this->input->post('CHR_PURCHASE_ITEM');
        $supplier = $this->input->post('CHR_SUPPLIER_NAME');
        $pic = $this->input->post('CHR_REQUISIONER');
        $estimate_m = $this->input->post('INT_MONTH');
        $cost;
        $qty = NULL;
        $price_per_unit = NULL;
        if ($eos == 'e') {
            $cost = $this->input->post('INT_COST');
        } else {
            $price_per_unit = $this->input->post('INT_PRICE_PER_UNIT');
            $qty = $this->input->post('INT_QUANTITY');
            $cost = $price_per_unit * $qty;
        }

        //check budget limit
        $data_head = $this->purchase_request_detail_m->get_budget_head_e($id, $fiscal);
        $remain = $data_head->DEC_TOTAL;
        $temp_table = $this->purchase_request_detail_m->get_temp_table($user->INT_ID_SECTION);
        if ($temp_table != NULL) {
            foreach ($temp_table as $temp) {
                if ($temp->INT_NO_BUDGET == $id) {
                    $remain = $remain - $temp->DEC_TOTAL;
                }
            }
        }

        if ($remain < $cost) {
            $this->create_purchase_request_e(1, NULL);
        } else {
            $data = array(
                'INT_ID_SECTION' => $user->INT_ID_SECTION,
                'INT_NO_BUDGET' => $id,
                'DEC_TOTAL' => $cost,
                'INT_QUANTITY' => $qty,
                'DEC_PRICE_PER_UNIT' => $price_per_unit,
                'CHR_PURCHASE_ITEM' => $item,
                'CHR_SUPPLIER_NAME' => $supplier,
                'CHR_REQUESTOR' => $pic,
                'INT_ID_UNIT' => $data_head->INT_ID_UNIT,
                'INT_MONTH_ESTIMATE' => $estimate_m
            );
            $this->db->trans_start();
            $this->purchase_request_detail_m->save_temp_pureq_expense($data);
            $this->log_m->add_log('120', $user->INT_ID_SECTION);
            $this->db->trans_complete();

            $this->create_purchase_request_e(NULL, NULL);
        }
    }

    function reset_purchase_request_e($section) {
        $this->db->trans_start();
        $this->purchase_request_detail_m->delete_temp_pureq_expense($section);
        $this->log_m->add_log('122', $section);
        $this->db->trans_complete();
        $this->create_purchase_request_e('3', NULL);
    }

    function save_purchase_request_e($section) {
        $this->db->trans_start();
        $session = $this->session->all_userdata();
        $user = $this->user_m->get_user_org($session['NPK']);
        $data_temp = $this->purchase_request_detail_m->get_temp_table($section);
        $fiscal = $this->fiscal_m->get_id_fiscal_this_year();

        $data_head = array(
            'INT_NO_PUREQ' => $this->purchase_request_m->generated_id_purchase_request(),
            'INT_ID_FISCAL_YEAR' => $fiscal,
            'INT_ID_SECTION' => $user->INT_ID_SECTION,
            'INT_MONTH_REAL' => date('m'),
            'DEC_TOTAL' => $this->purchase_request_detail_m->get_temp_table_total($user->INT_ID_SECTION),
            'CHR_CREATE_BY' => $session['USERNAME'],
            'CHR_CREATE_DATE' => date('Ymd'),
            'CHR_CREATE_TIME' => date('His'),
            'BIT_FLG_DEL' => 0,
            'BIT_FLG_CPX' => 0
        );
        //save to header
        $this->purchase_request_m->save($data_head);

        foreach ($data_temp as $temp) {
            $data_detail = array(
                'INT_NO_PUREQ' => $data_head['INT_NO_PUREQ'],
                'INT_NO_BUDGET' => $temp->INT_NO_BUDGET,
                'DEC_TOTAL' => $temp->DEC_TOTAL,
                'DEC_PRICE_PER_UNIT' => $temp->DEC_PRICE_PER_UNIT,
                'INT_QUANTITY' => $temp->INT_QUANTITY,
                'CHR_PURCHASE_ITEM' => $temp->CHR_PURCHASE_ITEM,
                'CHR_SUPPLIER_NAME' => $temp->CHR_SUPPLIER_NAME,
                'CHR_REQUESTOR' => $temp->CHR_REQUESTOR,
                'INT_ID_UNIT' => $temp->INT_ID_UNIT,
                'INT_MONTH_ESTIMATE' => $temp->INT_MONTH_ESTIMATE,
            );
            $this->purchase_request_detail_m->save_pureq_detail_expense($data_detail);
        }


        $this->log_m->add_log('115', $data_head['INT_NO_PUREQ']);
        $this->db->trans_complete();
        //then delete the TW pureq
        $this->purchase_request_detail_m->delete_temp_pureq_expense($section);
        $this->create_purchase_request_e('2', NULL);
    }

    function add_pureq_detail($no_budget, $param, $cip, $section, $dept, $msg = null) {
        $this->role_module_m->authorization('31');
        $this->load->model('budget/capex_plan_m');
        $this->load->model('budget/budgettype_m');
        $this->load->model('budget/unit_m');

        if ($msg == 1) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Saving failed. </strong> The amount limit exceeded. </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-success'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Saving success. </strong> The data is successfully created. </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>remove Budget success. </strong> The data is successfully cleared. </div >";
        }


        if ($param == 1) {
            $this->purchase_request_detail_m->delete();
        }

        $new_fiscal = $this->fiscal_m->get_id_fiscal_this_year();
        $data['stat_cip'] = $cip;
        $data['dept'] = $dept;
        $data['section'] = $section;
        $data['new_fiscal'] = $new_fiscal;

        $data['title'] = 'Create Purchase Request';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(31);
        $data['news'] = $this->news_m->get_news();

        $data['data_dept'] = $this->dept_m->get_dept();
        $data['data_unit'] = $this->unit_m->get_unit();
        $data['data_section'] = $this->section_m->get_section();
        $data['data_type'] = $this->budgettype_m->get_budgettype();
        $data['data_fiscal'] = $this->fiscal_m->get_fiscal();
        $data['data_budgetsubcategory'] = $this->budgetsubcategory_m->get_budgetsubcategory();
        $data['data_budgetcategory'] = $this->budgetcategory_m->get_budgetcategory_capex();

        $data['msg'] = $msg;
        $data['flag'] = $this->purchase_request_detail_m->get_flag_exixs();
        $data['data'] = $this->purchase_request_detail_m->get_budget($new_fiscal, $cip, $section);
        $data['data_pr'] = $this->purchase_request_detail_m->get_purchase_request_detail_temp();
        $data['data_detail'] = $this->capex_plan_m->get_data_capex($no_budget)->row();
        $data['content'] = 'budget/purchase_request/create_purchase_request_v';
        $data['subcontent'] = 'budget/purchase_request/add_purchase_request_detail_v';

        $this->load->view($this->layout, $data);
    }

    function save_budget_to_pureq() {
        $no_pureq_temp = $this->purchase_request_m->generated_id_purchase_request_temp();

        $this->form_validation->set_rules('CHR_PURCHASE_ITEM', 'Purchase Item', 'required|trim');
        $this->form_validation->set_rules('INT_QUANTITY', 'Quantity', 'required|trim|callback_check_quantity');
        $this->form_validation->set_rules('CHR_SUPPLIER_NAME', 'Supplier Name', 'required|trim');
        $this->form_validation->set_rules('DEC_PRICE_PER_UNIT', 'Price Per unit', 'required|trim|callback_check_mount');
        $this->form_validation->set_rules('CHR_REQUESTOR', 'Requestor', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            $this->add_pureq_detail($this->input->post('INT_NO_BUDGET'), 0, $this->input->post('BIT_FLG_CIP'), $this->input->post('INT_ID_SECTION'), $this->input->post('INT_ID_DEPT'));
        } else {
            $data = array(
                'INT_NO_PUREQ_TEMP' => $no_pureq_temp,
                'INT_NO_BUDGET' => $this->input->post('INT_NO_BUDGET'),
                'CHR_PURCHASE_ITEM' => $this->input->post('CHR_PURCHASE_ITEM'),
                'CHR_SUPPLIER_NAME' => $this->input->post('CHR_SUPPLIER_NAME'),
                'CHR_REQUESTOR' => $this->input->post('CHR_REQUESTOR'),
                'INT_QUANTITY' => $this->input->post('INT_QUANTITY'),
                'DEC_PRICE_PER_UNIT' => $this->input->post('DEC_PRICE_PER_UNIT')
            );
            $this->purchase_request_detail_m->save($data);
            redirect($this->back_to_create . '0' . '/' . $this->input->post('BIT_FLG_CIP') . '/' . $this->input->post('INT_ID_SECTION') . '/' . $this->input->post('INT_ID_DEPT'));
        }
    }

    function check_quantity() {
        $quantity = $this->input->post('INT_QUANTITY');
        $no_budget = $this->input->post('INT_NO_BUDGET');

        $return_value = $this->purchase_request_m->check_quantity($no_budget, $quantity);
        if ($return_value) {
            $this->form_validation->set_message('check_quantity', "Sorry, You must input quantity under limit number");
            return FALSE;
        } else {
            return TRUE;
        }
    }

    function check_mount() {
        $mount = $this->input->post('DEC_PRICE_PER_UNIT');
        $no_budget = $this->input->post('INT_NO_BUDGET');

        $return_value = $this->purchase_request_m->check_mount($no_budget, $mount);
        if ($return_value) {
            $this->form_validation->set_message('check_mount', "Sorry, You must input price under limit number");
            return FALSE;
        } else {
            return TRUE;
        }
    }

    function save_purchase_request() {
        $session = $this->session->all_userdata();

        if ($session['ROLE'] === 1 || $session['ROLE'] === 2) {
            $section = $this->input->post('INT_ID_SECTION');
            $new_fiscal = $this->input->post('INT_ID_FISCAL_YEAR');
        } else if ($session['ROLE'] === 6) {
            $section = $session['SECTION'];
            $new_fiscal = $data['new_fiscal'] = $this->fiscal_m->get_id_fiscal_this_year();
        }

        $no_purchase_request = $this->purchase_request_m->generated_id_purchase_request();

        $data = array(
            'INT_NO_PUREQ' => $no_purchase_request,
            'INT_ID_FISCAL_YEAR' => $new_fiscal,
            'INT_ID_SECTION' => $section,
            'INT_APPROVE1' => 0,
            'INT_APPROVE2' => 0,
            'CHR_CREATE_BY' => $session['USERNAME'],
            'CHR_CREATE_DATE' => date('Ymd'),
            'CHR_CREATE_TIME' => date('His'),
            'BIT_FLG_DEL' => 0
        );

        $this->purchase_request_m->save($data);

        $this->purchase_request_detail_m->saving($no_purchase_request);

        redirect($this->back_to_manage . $msg = 1);
    }

    function view_detail_by_gm($groupdept, $fiscal) {
        $this->role_module_m->authorization('44');
        $this->load->model('organization/groupdept_m');

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['news'] = $this->news_m->get_news();
        $data['sidebar'] = $this->role_module_m->side_bar(44);
        $data['title'] = 'Approve Purchase Request';
        $data['msg'] = null;

        $data_contain = $this->purchase_request_m->get_purchase_request_by_gm($groupdept, $fiscal);
        $contain = 'budget/purchase_request/approve_by_gm_v';

        $data['group'] = $this->groupdept_m->get_name_groupdept($groupdept);
        $data['fiscal'] = $this->fiscal_m->select_fiscal_year($fiscal);

        $data['data_fiscal'] = $this->fiscal_m->get_fiscal();
        $data['data'] = $data_contain;
        $data['content'] = $contain;

        $this->load->view($this->layout, $data);
    }

    function view_detail_by_manager($dept, $fiscal) {
        $this->role_module_m->authorization('44');
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Approve Purchase Request';
        $data['sidebar'] = $this->role_module_m->side_bar(44);
        $data['msg'] = null;

        $contain = 'budget/purchase_request/approve_by_manager_v';
        $data_contain = $this->purchase_request_m->get_purchase_request_by_manager($dept, $fiscal);
        $data_containt_detail = $this->purchase_request_m->get_purchase_request_detail_by_manager($dept, $fiscal);

        $session = $this->session->all_userdata();
        if ($session['ROLE'] === 4) {
            $dept = $session['DEPT'];
        }

        $data['group'] = $this->dept_m->get_name_dept($dept);
        $data['fiscal'] = $this->fiscal_m->select_fiscal_year($fiscal);
        $data['id_dept'] = $dept;
        $data['id_fiscal'] = $fiscal;

        $data['data_fiscal'] = $this->fiscal_m->get_fiscal();
        $data['data'] = $data_contain;
        $data['data_pureq_detail'] = $data_containt_detail;
        $data['content'] = $contain;

        $this->load->view($this->layout, $data);
    }

    //view breakdown budget plan
    function view_detail_by_supervisor($section, $fiscal) {
        $this->role_module_m->authorization('44');
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['news'] = $this->news_m->get_news();
        $data['sidebar'] = $this->role_module_m->side_bar(44);

        $data['group'] = $this->section_m->get_name_section($section);
        $data['fiscal'] = $this->fiscal_m->select_fiscal_year($fiscal);

        $data_contain = $this->purchase_request_m->get_purchase_request_by_supervisor($section, $fiscal);
        $data['fiscal'] = $this->fiscal_m->select_fiscal_year($fiscal);
        $data['id_section'] = $section;
        $data['id_fiscal'] = $fiscal;
        $contain = 'budget/purchase_request/list_by_supervisor_v';

        $data['data_fiscal'] = $this->fiscal_m->get_fiscal();
        $data['title'] = 'Approve Purchase Request';
        $data['data'] = $data_contain;
        $data['content'] = $contain;

        $this->load->view($this->layout, $data);
    }

    //view detail by adamin and root
    function view_detail_purchase_request($no_purchase_request, $msg = null) {
        $this->role_module_m->authorization('31');
        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Creating success </strong> The data is successfully created </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Updating success </strong> The data is successfully updated </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Deleted success </strong> The data is successfully deleted </div >";
        } elseif ($msg == 5) {
            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Adding failed ! </strong> The data cannot empty </div >";
        } elseif ($msg == 12) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Executing error !</strong> Something error with parameter </div >";
        } else {
            $msg = "";
        }

        $session = $this->session->all_userdata();
        if ($session['ROLE'] === 6) {
            $contain = 'budget/purchase_request/view_purchase_request_by_section_v';
        } else if ($session['ROLE'] === 1 || $session['ROLE'] === 2) {
            $contain = 'budget/purchase_request/view_purchase_request_by_admin_v';
        }

        $data['title'] = 'View Detail Purchase Request';
        $data['msg'] = $msg;
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(31);
        $data['news'] = $this->news_m->get_news();

        $data['data_fiscal'] = $this->fiscal_m->get_fiscal();
        $data['data'] = $this->purchase_request_m->get_data_purchase_request($no_purchase_request)->row();
        $data['data_detail'] = $this->purchase_request_detail_m->get_purchase_request_detail($no_purchase_request);
        $data['content'] = $contain;

        $this->load->view($this->layout, $data);
    }

    function view_detail_purchase_request_by_other($no_purchase_request, $msg = null) {
        $this->role_module_m->authorization('44');
        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Creating success </strong> The data is successfully created </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Updating success </strong> The data is successfully updated </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Deleted success </strong> The data is successfully deleted </div >";
        } elseif ($msg == 5) {
            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Adding failed ! </strong> The data cannot empty </div >";
        } elseif ($msg == 12) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Executing error !</strong> Something error with parameter </div >";
        } else {
            $msg = "";
        }

        $data['title'] = 'View Detail Purchase Request';
        $data['msg'] = $msg;
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(44);
        $data['news'] = $this->news_m->get_news();

        $data['data_fiscal'] = $this->fiscal_m->get_fiscal();
        $data['data'] = $this->purchase_request_m->get_data_purchase_request($no_purchase_request)->row();
        $data['data_detail'] = $this->purchase_request_detail_m->get_purchase_request_detail($no_purchase_request);
        $data['content'] = 'budget/purchase_request/view_purchase_request_by_other_v';

        $this->load->view($this->layout, $data);
    }

    function edit_purchase_request($no_purchase_request) {
        $this->role_module_m->authorization('31');

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(31);
        $data['title'] = 'Edit Purchase Request';
        $data['news'] = $this->news_m->get_news();

        $data['data'] = $this->purchase_request_m->get_data_purchase_request($no_purchase_request)->row();
        $data['data_pr'] = $this->purchase_request_detail_m->get_purchase_request_detail($no_purchase_request);

        $data['subcontent'] = null;
        $data['width'] = 'class="col-md-12"';

        $data['content'] = 'budget/purchase_request/edit_purchase_request_v';

        $this->load->view($this->layout, $data);
    }

    function update_purchase_request() {
        $session = $this->session->all_userdata();

        if ($session['ROLE'] === 1 || $session['ROLE'] === 2) {
            $section = $this->input->post('INT_ID_SECTION');
            $new_fiscal = $this->input->post('INT_ID_FISCAL_YEAR');
        } else if ($session['ROLE'] === 6) {
            $section = $session['SECTION'];
            $new_fiscal = $data['new_fiscal'] = $this->fiscal_m->get_id_fiscal_this_year();
        }

        $data = array(
            'INT_ID_FISCAL_YEAR' => $new_fiscal,
            'INT_ID_SECTION' => $section,
            'INT_MONTH_REAL' => $this->input->post('INT_MONTH_REAL'),
            'CHR_MODI_BY' => $session['USERNAME'],
            'CHR_MODI_DATE' => date('Ymd'),
            'CHR_MODI_TIME' => date('His'),
        );

        $this->purchase_request_m->update($data, $this->input->post('INT_NO_PUREQ'));

        redirect($this->back_to_manage . $msg = 2);
    }

    function delete_purchase_request($no_purchase_request) {
        $this->role_module_m->authorization('31');
        $this->purchase_request_m->delete($no_purchase_request);
        redirect($this->back_to_manage . $msg = 3);
    }

    function approve_purchase_request() {
        $no_pureq = $this->input->post('case');
        $session = $this->session->all_userdata();
        if ($session['ROLE'] === 5) {
            $data = array(
                'INT_APPROVE1' => 1
            );
        } else if ($session['ROLE'] === 4) {
            $data = array(
                'INT_APPROVE2' => 1
            );
        } else if ($session['ROLE'] === 1 || $session['ROLE'] === 2) {
            $data = array(
                'INT_APPROVE2' => 1,
                'INT_APPROVE1' => 1
            );
        }

        if ($no_pureq == null) {
            redirect($this->back_to_approve . $msg = 2);
        }

        for ($i = 0; $i < count($no_pureq); $i++) {
            $this->purchase_request_m->update($data, $no_pureq[$i]);
        }
        redirect($this->back_to_approve . $msg = 1);
    }

    function reject_purchase_request($no_pureq) {
        $session = $this->session->all_userdata();
        if ($session['ROLE'] === 5) {
            $data = array(
                'INT_APPROVE1' => 2
            );
        } else if ($session['ROLE'] === 4) {
            $data = array(
                'INT_APPROVE2' => 2
            );
        } else if ($session['ROLE'] === 1 || $session['ROLE'] === 2) {
            $data = array(
                'INT_APPROVE2' => 2,
                'INT_APPROVE1' => 2
            );
        }

        $this->purchase_request_m->update($data, $no_pureq);
        redirect($this->back_to_approve . $msg = 3);
    }

    function prepare_report_company_budget($msg = null) {
        $this->role_module_m->authorization('30');
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

        $new_fiscal = $this->fiscal_m->get_id_fiscal_this_year();


        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(30);
        $data['news'] = $this->news_m->get_news();
        $data['msg'] = $msg;

        $data['data_fiscal'] = $this->fiscal_m->get_fiscal();
        $data['fiscal'] = $this->fiscal_m->select_fiscal_year($new_fiscal);
        $data['new_fiscal'] = $new_fiscal;
        $data['title'] = 'Report Company Budget';
        $data['content'] = 'budget/purchase_request/print_report_company_budget_v';

        $this->load->view($this->layout, $data);
    }

    function prepare_report_budget_usage($msg = null) {
        $this->role_module_m->authorization('52');
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

        $new_fiscal = $this->fiscal_m->get_id_fiscal_this_year();

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(52);
        $data['news'] = $this->news_m->get_news();
        $data['msg'] = $msg;
        $data['title'] = 'Report Company Budget';
        $data['content'] = 'budget/purchase_request/print_report_budget_usage_v';

        $data['data_fiscal'] = $this->fiscal_m->get_fiscal();
        $data['fiscal'] = $this->fiscal_m->select_fiscal_year($new_fiscal);
        $data['new_fiscal'] = $new_fiscal;
        $data['data'] = $this->purchase_request_m->get_purchase_request_by_admin($new_fiscal);

        $this->load->view($this->layout, $data);
    }

    function search_prepare_report_budget_usage($msg = null) {
        $this->role_module_m->authorization('52');
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

        $new_fiscal = $this->input->post('INT_ID_FISCAL_YEAR');

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(52);
        $data['news'] = $this->news_m->get_news();
        $data['msg'] = $msg;
        $data['title'] = 'Report Company Budget';
        $data['content'] = 'budget/purchase_request/print_report_budget_usage_v';

        $data['data_fiscal'] = $this->fiscal_m->get_fiscal();
        $data['fiscal'] = $this->fiscal_m->select_fiscal_year($new_fiscal);
        $data['new_fiscal'] = $new_fiscal;
        $data['data'] = $this->purchase_request_m->get_purchase_request_by_admin($new_fiscal);

        $this->load->view($this->layout, $data);
    }

    function print_approval_sheet($no_pureq) {
        $this->role_module_m->authorization('31');
        $session = $this->session->all_userdata();
        $this->load->library('fpdf17/fpdf');
        define('FPDF_FONTPATH', $this->config->item('fonts_path'));

        $head = $this->purchase_request_m->get_data_purchase_request($no_pureq)->row();
        $data = $this->purchase_request_detail_m->get_purchase_request_detail($no_pureq);

        $this->fpdf->Open();
        $pdf = new FPDF("L", "cm", "A4");
        $pdf->AliasNbPages();
        $pdf->AddPage();

        /* -------------- Header Judul ------------------------------------------------ */

        $pdf->Line(1, 2, 28, 2);
        $pdf->Ln();
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(27, 1, 'Approval Sheet', 0, 0, 'C');
        $logo = base_url('assets/img/aisin.gif');
        $pdf->Image($logo, 1, 0.3, -100, 'GIF');

        /* -------------- Header table ------------------------------------------------ */

        $pdf->Ln();
        $pdf->SetFont('Times', '', 8);
        $pdf->Cell(2.5, 1, 'DATE', 0, 0, 'L');
        $pdf->Cell(1, 1, ':', 0, 0, 'L');
        $pdf->SetFont('', 'B', 10);
        $pdf->Cell(1, 1, date('d/m/Y'), 0, 0, 'L');

        $pdf->Ln();
        $pdf->SetFont('Times', '', 8);
        $pdf->Cell(2.5, 0.1, 'DEPT', 0, 0, 'L');
        $pdf->Cell(1, 0.1, ':', 0, 0, 'L');
        $pdf->SetFont('', 'B', '');
        $pdf->Cell(1, 0.1, trim($head->CHR_DEPT), 0, 0, 'L');

        $pdf->Ln();
        $pdf->SetFont('Times', '', 8);
        $pdf->Cell(2.5, 1, 'NO PR', 0, 0, 'L');
        $pdf->Cell(1, 1, ':', 0, 0, 'L');
        $pdf->SetFont('', 'B', '');
        $pdf->Cell(1, 1, trim($head->INT_NO_PUREQ), 0, 0, 'L');

        $pdf->Ln();
        $pdf->SetFont('Times', '', 8);
        $pdf->Cell(2.5, 0.1, 'TYPE', 0, 0, 'L');
        $pdf->Cell(1, 0.1, ':', 0, 0, 'L');
        $pdf->SetFont('', 'B', '');
        $pdf->Cell(1, 0.1, 'CAPEX', 0, 0, 'L');


        $pdf->Ln(0.5);
        $pdf->SetFont('Times', 'B', 8);
        $pdf->Cell(0.6, 1, 'No', 1, 'LR', 'L');
        $pdf->Cell(1.5, 1, 'Budget No', 1, 'LR', 'L');
        $pdf->Cell(5, 1, 'Budget Name', 1, 'LR', 'L');
        $pdf->Cell(2, 1, 'Budget Status', 1, 'LR', 'L');
        $pdf->Cell(2.5, 1, 'Category', 1, 'LR', 'L');
        $pdf->Cell(5, 1, 'Purchase Item', 1, 'LR', 'L');
        $pdf->Cell(1, 1, 'Qty', 1, 'LR', 'L');
        $pdf->Cell(1.5, 1, 'UoM', 1, 'LR', 'L');
        $pdf->Cell(2, 1, 'Asset No', 1, 'LR', 'L');
        $pdf->Cell(2.5, 1, 'Supplier', 1, 'LR', 'L');
        $pdf->Cell(2, 1, 'Price', 1, 'LR', 'L');
        $pdf->Cell(2, 1, 'Total', 1, 'LR', 'L');


        $no = 1;
        $max = 1;
        foreach ($data as $row) {
            $pdf->Ln();
            $pdf->SetFont('Times', '', 10);
            $pdf->Cell(0.6, 0.7, $no, 1, 'LR', 'L');
            $pdf->Cell(1.5, 0.7, $row->INT_NO_BUDGET, 1, 'LR', 'L');
            $pdf->Cell(5, 0.7, $row->CHR_BUDGET_NAME, 1, 'LR', 'L');
            $pdf->Cell(2, 0.7, $row->CHR_REMARK, 1, 'LR', 'L');
            $pdf->Cell(2.5, 0.7, $row->CHR_REMARK, 1, 'LR', 'L');
            $pdf->Cell(5, 0.7, $row->CHR_PURCHASE_ITEM, 1, 'LR', 'L');
            $pdf->Cell(1, 0.7, $row->INT_QUANTITY, 1, 'LR', 'L');
            $pdf->Cell(1.5, 0.7, $row->INT_ID_UNIT, 1, 'LR', 'L');
            $pdf->Cell(2, 0.7, $row->CHR_SUPPLIER_NAME, 1, 'LR', 'L');
            $pdf->Cell(2.5, 0.7, $row->CHR_SUPPLIER_NAME, 1, 'LR', 'L');
            $pdf->Cell(2, 0.7, $row->DEC_PRICE_PER_UNIT, 1, 'LR', 'L');
            $pdf->Cell(2, 0.7, $row->TOTAL, 1, 'LR', 'L');
            $no = $no + 1;
            $max = $max + 1;
        }

        $pdf->SetFont('Times', '', 7);
        $pdf->SetXY(25, 1);
        $pdf->Cell(9.5, 0.5, date('d/m/Y') . ' | ' . $session['USERNAME'] . '', 0, 'LR', 'L');

        $pdf->SetXY(17, -8.5);
        $pdf->Cell(4, 0.5, 'BOD', 1, 1, 'C');
        $pdf->SetXY(17, -8);
        $pdf->Cell(2, 0.5, 'APPROVED', 1, 2, 'C');
        $pdf->Cell(2, 1, '', 1, 2, 'R');
        $pdf->Cell(2, 0.5, 'PRESDIR', 1, 1, 'C');
        $pdf->SetXY(19, -8);
        $pdf->Cell(2, 0.5, 'APPROVED', 1, 2, 'C');
        $pdf->Cell(2, 1, '', 1, 2, 'R');
        $pdf->Cell(2, 0.5, 'DIRECTOR', 1, 1, 'C');

        $pdf->SetXY(22, -8.5);
        $pdf->Cell(6, 0.5, 'USER', 1, 1, 'C');
        $pdf->SetXY(22, -8);
        $pdf->Cell(2, 0.5, 'APPROVED', 1, 2, 'C');
        $pdf->Cell(2, 1, '', 1, 2, 'C');
        $pdf->Cell(2, 0.5, 'DIR INCHARGE', 1, 1, 'C');
        $pdf->SetXY(24, -8);
        $pdf->Cell(2, 0.5, 'CHECKED', 1, 2, 'C');
        $pdf->Cell(2, 1, '', 1, 2, 'C');
        $pdf->Cell(2, 0.5, 'DEPT. HEAD', 1, 1, 'C');
        $pdf->SetXY(26, -8);
        $pdf->Cell(2, 0.5, 'APPROVED', 1, 2, 'C');
        $pdf->Cell(2, 1, '', 1, 2, 'C');
        $pdf->Cell(2, 0.5, 'SECT. HEAD', 1, 1, 'C');

        $pdf->SetXY(22, -4.8);
        $pdf->Cell(2, 0.5, 'BUDGET', 1, 1, 'C');
        $pdf->SetXY(22, -4.3 );
        $pdf->Cell(2, 0.5, 'APPROVED', 1, 2, 'C');
        $pdf->Cell(2, 1, '', 1, 2, 'C');
        $pdf->Cell(2, 0.5, 'DIR INCHARGE', 1, 1, 'C');

        $filename = $no_pureq . ".pdf";
        $pdf->Output($filename, 'I');
    }

    function print_report_company_budget() {
        $this->role_module_m->authorization('30');
        $this->load->library('PHPExcel');
    }

    function print_report_budget_usage() {
        $this->role_module_m->authorization('52');
        $this->load->library('PHPExcel');

        $objTpl = PHPExcel_IOFactory::load('./assets/template/CAPEXsectionplan.xls');

        $id_fiscal = $this->input->post('INT_ID_FISCAL_YEAR');

        $data = $this->purchase_request_m->get_purchase_request_by_admin($id_fiscal);

        $fiscal = $this->fiscal_m->select_fiscal_year($id_fiscal);

        $objTpl->setActiveSheetIndex(0);

        $objTpl->getActiveSheet()->setCellValue('A2', 'MASTER REALIZATION: TAHUN ' . trim($fiscal));
        //$objTpl->getActiveSheet()->setCellValue('A3', 'DEPARTMENT: ' . $dept . '/' . $dept_desc);
        $objTpl->getActiveSheet()->setCellValue('M2', 'Date of Print: ' . date('d-M-Y'));

        $e = 7;
        $jum = 1;
        foreach ($data as $row) {
            $objTpl->getActiveSheet()->setCellValue("A$e", $jum);
            $objTpl->getActiveSheet()->setCellValue("B$e", $row->INT_NO_BUDGET);
            $objTpl->getActiveSheet()->setCellValue("C$e", trim($row->BIT_FLG_NEW));
            $objTpl->getActiveSheet()->setCellValue("D$e", trim($row->CHR_BUDGET_CATEGORY_DESC));
            $objTpl->getActiveSheet()->setCellValue("E$e", trim($row->CHR_BUDGET_SUB_CATEGORY_DESC));
            $objTpl->getActiveSheet()->setCellValue("F$e", trim($row->BIT_FLG_OWNER));
            $objTpl->getActiveSheet()->setCellValue("G$e", trim($row->CHR_BUDGET_NAME));
            $objTpl->getActiveSheet()->setCellValue("H$e", trim($row->CHR_PURPOSE_DESC));
            $objTpl->getActiveSheet()->setCellValue("I$e", '');
            $objTpl->getActiveSheet()->setCellValue("J$e", '');
            $objTpl->getActiveSheet()->setCellValue("K$e", '');
            $objTpl->getActiveSheet()->setCellValue("L$e", trim($row->BIT_FLG_CIP));
            $objTpl->getActiveSheet()->setCellValue("M$e", trim($row->BIT_FLG_LOCAL));
            $objTpl->getActiveSheet()->setCellValue("N$e", trim($row->DEC_TOTAL));
            $objTpl->getActiveSheet()->setCellValue("O$e", trim($row->depresiasi));
            if ($row->INT_MONTH_PLAN === 1) {
                $objTpl->getActiveSheet()->setCellValue("Y$e", $row->DEC_TOTAL);
            } else if ($row->INT_MONTH_PLAN === 2) {
                $objTpl->getActiveSheet()->setCellValue("Z$e", $row->DEC_TOTAL);
            } else if ($row->INT_MONTH_PLAN === 3) {
                $objTpl->getActiveSheet()->setCellValue("AA$e", $row->DEC_TOTAL);
            } else if ($row->INT_MONTH_PLAN === 4) {
                $objTpl->getActiveSheet()->setCellValue("P$e", $row->DEC_TOTAL);
            } else if ($row->INT_MONTH_PLAN === 5) {
                $objTpl->getActiveSheet()->setCellValue("Q$e", $row->DEC_TOTAL);
            } else if ($row->INT_MONTH_PLAN === 6) {
                $objTpl->getActiveSheet()->setCellValue("R$e", $row->DEC_TOTAL);
            } else if ($row->INT_MONTH_PLAN === 7) {
                $objTpl->getActiveSheet()->setCellValue("S$e", $row->DEC_TOTAL);
            } else if ($row->INT_MONTH_PLAN === 8) {
                $objTpl->getActiveSheet()->setCellValue("T$e", $row->DEC_TOTAL);
            } else if ($row->INT_MONTH_PLAN === 9) {
                $objTpl->getActiveSheet()->setCellValue("U$e", $row->DEC_TOTAL);
            } else if ($row->INT_MONTH_PLAN === 10) {
                $objTpl->getActiveSheet()->setCellValue("V$e", $row->DEC_TOTAL);
            } else if ($row->INT_MONTH_PLAN === 11) {
                $objTpl->getActiveSheet()->setCellValue("W$e", $row->DEC_TOTAL);
            } else {
                $objTpl->getActiveSheet()->setCellValue("X$e", $row->DEC_TOTAL);
            }
            $e = $e + 1;
            $jum = $jum + 1;
        }

        $filename = trim($fiscal) . "/" . 'admin' . ".xls";
        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;
        filename = "' . trim($filename) . '"');
        header('Cache-Control: max-age = 0');

        $objWriter = PHPExcel_IOFactory::createWriter($objTpl, 'Excel5');
        $objWriter->save('php://output');
    }
    
    //-------------------- // EDITED BY ANP // ------------------------------//
    
    function manage_purchase_request($msg = NULL, $fiscal_start = NULL, $approved_by = 0) {
        $this->role_module_m->authorization('31');
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
        
        if ($fiscal_start == NULL){
            $fiscal_start = date('Y');
        }
        
        $fiscal_year = $this->fiscal_m->get_selected_fiscal_year($fiscal_start);
        
        $session = $this->session->all_userdata();
        if ($session['ROLE'] === 2 || $session['ROLE'] === 1) {
            $data_contain = $this->purchase_request_m->get_all_purchase_request($fiscal_year);
            $contain = 'budget/purchase_request/manage_list_pr_v';
        } else if ($session['ROLE'] === 6) {
            $data_contain = $this->purchase_request_m->get_purchase_request_by_supervisor($session['SECTION'], $new_fiscal);
            $contain = 'budget/purchase_request/manage_list_pr_v';
            $group = $this->section_m->get_name_section($session['SECTION']);
            $data['group'] = $group;
        }

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(189);
        $data['msg'] = $msg;
        $data['title'] = 'Manage Purchase Request';
        $data['news'] = $this->news_m->get_news();
        
        $data['all_fiscal'] = $this->fiscal_m->get_all_fiscal_year();
        $data['fiscal_start'] = $fiscal_start;
        $data['approved_by'] = $approved_by;
        $data['data'] = $data_contain;
        $data['content'] = $contain;

        $this->load->view($this->layout, $data);
    }
    
    //=============== EDITED BY ANU - 9172 ====================================//
    function approval_purchase_request($msg = NULL, $tahun = NULL, $budget_type = NULL, $status_bgt = NULL, $kode_transaksi = NULL) {
        $this->role_module_m->authorization('44');
        
        if($tahun == NULL){
            $tahun = $this->db->query("SELECT INT_ID_FISCAL_YEAR FROM CPL.TM_FISCAL WHERE BIT_FLG_ACTIVE = 1 ORDER BY INT_ID_FISCAL_YEAR ASC")->row()->INT_ID_FISCAL_YEAR;
            //$tahun = date("Y");
        }
        
        //------ UPDATE 16/10/2017 FOR REVISION MASTER BUDGET ----------------//
        $act_periode = date("Ym");
        $periode_smt2 = $tahun . '10';
        //--------------------------------------------------------------------//
        
        if($budget_type == NULL){
            $budget_type = 'CAPEX';
        }
        
        if($status_bgt == NULL){
            $status_bgt = '0';
        }
        
        //=== For Alert Req P.Ariawan === by ANU 20180704 ================//
        if($msg == NULL){
            $alert = 1;
        } else {
            $alert = 0;
        }
       
        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>x</button><strong>Approving success </strong> The data is successfully approved </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>x</button><strong>Approving failed </strong> You must selected at least one data </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>x</button><strong>Unapproving success </strong> The data is successfully unapproved </div >";
        } elseif ($msg == 4) {
            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>x</button><strong>Unapproving failed </strong> You must selected at least one data </div >";
        } else {
            $msg = "";
        }        
        

        $session = $this->session->all_userdata();
        //FOR --> ADMIN & ADMIN BUDGET
        if ($session['ROLE'] === 2) {
            $data['list_kode_transaksi'] = $this->purchase_request_m->get_list_kode_trans($tahun, $budget_type, $status_bgt);
            $get_pr_header = $this->purchase_request_m->get_pr_header_by_admin($tahun, $budget_type, $status_bgt, $kode_transaksi);
            
            if ($get_pr_header == '' || $get_pr_header == NULL){
                $kode_dept = '';
                $no_budget = '';
                $kode_group = '';
                $year_start = '';
                $year_end = '';
                $data['dept_name'] = '';
                $data['pr_date'] = '';
            } else {
                $kode_dept = $get_pr_header->CHR_KODE_DEPARTMENT;
                $kode_group = $get_pr_header->CHR_KODE_GROUP;
                $no_budget = $get_pr_header->CHR_NO_BUDGET;
                $year_start = substr($get_pr_header->CHR_FISCAL_YEAR, 0, 4);
                $year_end = substr($get_pr_header->CHR_FISCAL_YEAR, 7, 4);
                $data['dept_name'] = $get_pr_header->CHR_DEPARTMENT_DESCRIPTION;
                $data['pr_date'] = substr($get_pr_header->CHR_TGL_TRANS, 6, 2).'-'.substr($get_pr_header->CHR_TGL_TRANS, 4, 2).'-'.substr($get_pr_header->CHR_TGL_TRANS, 0, 4);
            }            
            
            $list_purchase_request = $this->purchase_request_m->get_list_pr_by_admin($tahun, $budget_type, $kode_transaksi, $status_bgt);
            
            if($list_purchase_request != NULL){
                $no_budget = $list_purchase_request[0]->CHR_NO_BUDGET;
            } else {
                $no_budget = '';
            }
                        
            $data['group_name'] = $this->purchase_request_m->get_group_dept_name($kode_group, $kode_dept);
            $data['budget_by_no'] = $this->purchase_request_m->get_budget_detail_by_no($budget_type, $no_budget);
            $data['actual_by_bgtno'] = $this->purchase_request_m->get_actual_detail_by_bgtno($budget_type, $no_budget);
            
            //PLAN PER DEPT
            $data['total_budget_plan'] = $this->purchase_request_m->get_total_budget($tahun, $budget_type, $kode_dept);
            $data['total_unbudget_plan'] = $this->purchase_request_m->get_total_unbudget($tahun, $budget_type, $kode_dept);
            $data['total_cip_plan'] = $this->purchase_request_m->get_total_cip($tahun, $budget_type, $kode_dept);
            
            //REALISASI PER DEPT
            $data['total_budget_real'] = $this->purchase_request_m->get_total_budget_real($tahun, $budget_type, $kode_dept);
            $data['total_unbudget_real'] = $this->purchase_request_m->get_total_unbudget_real($tahun, $budget_type, $kode_dept);
            $data['total_cip_real'] = $this->purchase_request_m->get_total_cip_real($tahun, $budget_type, $kode_dept);
            
            //PLAN GROUP DEPT
            $data['total_budget_group'] = $this->purchase_request_m->get_total_budget_group($tahun, $budget_type, $kode_group);
            
            //REALISASI GROUP DEPT
            $data['total_real_group'] = $this->purchase_request_m->get_total_real_group($tahun, $budget_type, $kode_group);
            
            //DETAIL BUDGET DEPT PER MONTH
            $data['detail_budget'] = $this->purchase_request_m->get_budget_detail($year_start, $year_end, $budget_type, $kode_dept);
            $data['limit_budget'] = $this->purchase_request_m->get_budget_limit($year_start, $year_end, $budget_type, $kode_dept);
            $data['actual_real'] = $this->purchase_request_m->get_actual_real($year_start, $year_end, $budget_type, $kode_dept);
            $data['detail_unbudget'] = $this->purchase_request_m->get_unbudget_detail($year_start, $year_end, $budget_type, $kode_dept);
            
            $data['detail_sales'] = $this->purchase_request_m->get_budget_sales($tahun);
            $data['ratio_sales'] = $this->purchase_request_m->get_ratio_sales($tahun, $budget_type);

            $list_actual_gr = array();
            for ($no = 1; $no <= 12; $no++){
                if (($no + 3) <= 12){
                    $start_date = $year_start . sprintf("%02d", $no+3) . '01';
                    $end_date = $year_start . sprintf("%02d", $no+3) . '31';
                    
                    $actual_gr = $this->purchase_request_m->get_actual_gr($start_date, $end_date, $budget_type, $kode_dept);
                    
                    array_push($list_actual_gr, $actual_gr->TOTAL);                    
                } else {
                    $start_date = $year_end . sprintf("%02d", $no-9) . '01';
                    $end_date = $year_end . sprintf("%02d", $no-9) . '31';
                    
                    $actual_gr = $this->purchase_request_m->get_actual_gr($start_date, $end_date, $budget_type, $kode_dept);
                   
                    array_push($list_actual_gr, $actual_gr->TOTAL);                    
                }
            }
            
            $data['actual_gr'] = $list_actual_gr;
            
            $contain = 'budget/purchase_request/approval_pr_by_admin_v';
            
        //FOR --> BOD
        } else if ($session['ROLE'] === 3 ) { 
            $data['list_kode_transaksi'] = $this->purchase_request_m->get_list_kode_trans_bod($tahun, $budget_type, $status_bgt);
            $get_pr_header = $this->purchase_request_m->get_pr_header_by_bod($tahun, $budget_type, $status_bgt, $kode_transaksi);
            $kode_div = '001';
            
            if ($get_pr_header == '' || $get_pr_header == NULL){                
                $kode_dept = '';
                $no_budget = '';
                $year_start = $tahun;
                $year_end = $tahun + 1;
                $data['dept_name'] = '';
                $data['pr_date'] = '';
                $data['est_date'] = '';
            } else {
                $kode_dept = $get_pr_header->CHR_KODE_DEPARTMENT;
                $no_budget = $get_pr_header->CHR_NO_BUDGET;
                $year_start = substr($get_pr_header->CHR_FISCAL_YEAR, 0, 4);
                $year_end = substr($get_pr_header->CHR_FISCAL_YEAR, 7, 4);
                $data['dept_name'] = $get_pr_header->CHR_DEPARTMENT_DESCRIPTION;                
                $data['pr_date'] = substr($get_pr_header->CHR_TGL_TRANS, 6, 2).'-'.substr($get_pr_header->CHR_TGL_TRANS, 4, 2).'-'.substr($get_pr_header->CHR_TGL_TRANS, 0, 4);
                $est_date = $this->purchase_request_m->get_estimate_date($kode_transaksi)->CHR_TGL_ESTIMASI_KEDATANGAN;
                $data['est_date'] = $est_date;
            }            
            
            $list_purchase_request = $this->purchase_request_m->get_list_pr_by_bod($tahun, $budget_type, $status_bgt, $kode_transaksi);
            
            if($list_purchase_request != NULL){
                $no_budget = $list_purchase_request[0]->CHR_NO_BUDGET;
            } else {
                $no_budget = '';
            }
                        
            $data['budget_by_no'] = $this->purchase_request_m->get_budget_detail_by_no($budget_type, $no_budget);
            $data['actual_by_bgtno'] = $this->purchase_request_m->get_actual_detail_by_bgtno($budget_type, $no_budget);
            
            //PLAN PER DEPT
            $data['total_budget_plan'] = $this->purchase_request_m->get_total_budget($tahun, $budget_type, $kode_dept, $act_periode, $periode_smt2);
            $data['total_unbudget_plan'] = $this->purchase_request_m->get_total_unbudget($tahun, $budget_type, $kode_dept);
            $data['total_cip_plan'] = $this->purchase_request_m->get_total_cip($tahun, $budget_type, $kode_dept, $act_periode, $periode_smt2);
            
            //REALISASI PER DEPT
            $data['total_budget_real'] = $this->purchase_request_m->get_new_total_real_dept_nonunbudget($tahun, $year_start, $year_end, $budget_type, $kode_dept);
            $data['total_unbudget_real'] = $this->purchase_request_m->get_new_total_real_dept_unbudget($tahun, $year_start, $year_end, $budget_type, $kode_dept);
            $data['total_cip_real'] = $this->purchase_request_m->get_new_total_real_dept_nonunbudget_cip($tahun, $year_start, $year_end, $budget_type, $kode_dept);
            
            //TOTAL BUDGET PLANT
            $data['total_budget_plant'] = $this->purchase_request_m->get_total_budget_plant($tahun, $budget_type);            
            
            //TOTAL BUDGET REVISI PLANT
            $data['total_all_budget_revisi'] = $this->purchase_request_m->get_total_budget_revisi_plant($tahun, $budget_type);
            
            //TOTAL REALISASI PLANT -------------- NEW UPDATE 04/07/2017
            $data['total_real_plant'] = $this->purchase_request_m->get_new_actual_real_bod($tahun, $year_start, $year_end, $budget_type, $act_periode, $periode_smt2);
            
            //------- REQUEST PAK ARIAWAN --------------- NEW UPDATE 05/06/2018
            $fy_before = $tahun - 1;
            $data['total_budget_plant_fy_before'] = $this->purchase_request_m->get_total_budget_plant($fy_before, $budget_type);
            $data['total_all_budget_revisi_fy_before'] = $this->purchase_request_m->get_total_budget_revisi_plant($fy_before, $budget_type);
            $data['total_real_plant_fy_before'] = $this->purchase_request_m->get_new_total_real_plant($fy_before, $fy_before, $tahun, $budget_type);
            
            //DETAIL BUDGET DIVISION PER MONTH ----------- NEW UPDATE 04/07/2017
            $data['detail_budget'] = $this->purchase_request_m->get_new_budget_detail_bod($tahun, $year_start, $year_end, $budget_type);
            $data['revisi_budget'] = $this->purchase_request_m->get_new_budget_detail_rev_bod($tahun, $year_start, $year_end, $budget_type);
            $data['limit_budget'] = $this->purchase_request_m->get_new_budget_limit_bod($tahun, $year_start, $year_end, $budget_type, $act_periode, $periode_smt2);
            $data['actual_real'] = $this->purchase_request_m->get_new_actual_real_bod($tahun, $year_start, $year_end, $budget_type, $act_periode, $periode_smt2);
            $data['detail_unbudget'] = $this->purchase_request_m->get_new_unbudget_detail_bod($tahun, $year_start, $year_end, $budget_type);
            
            //===== Additional SALES Data --- By ANU 20200421 =====//
            $data['detail_sales'] = $this->purchase_request_m->get_budget_sales($tahun);
            $data['revisi_budget_by_sales'] = $this->purchase_request_m->get_new_budget_detail_rev_bod_by_sales($tahun, $budget_type);
            $data['ratio_sales'] = $this->purchase_request_m->get_ratio_sales($tahun, $budget_type);
            $data['total_cr_plant'] = $this->purchase_request_m->get_total_amount_cr($tahun, $budget_type);
            //===== End Additional SALES Data --- By ANU 20200421 =====//

            $list_actual_gr = array();
            for ($no = 1; $no <= 12; $no++){
                if (($no + 3) <= 12){
                    $start_date = $year_start . sprintf("%02d", $no+3) . '01';
                    $end_date = $year_start . sprintf("%02d", $no+3) . '31';
                    
                    $actual_gr = $this->purchase_request_m->get_new_actual_gr_bod($start_date, $end_date, $budget_type, $kode_dept);
                    
                    array_push($list_actual_gr, $actual_gr->TOTAL);                    
                } else {
                    $start_date = $year_end . sprintf("%02d", $no-9) . '01';
                    $end_date = $year_end . sprintf("%02d", $no-9) . '31';
                    
                    $actual_gr = $this->purchase_request_m->get_new_actual_gr_bod($start_date, $end_date, $budget_type, $kode_dept);
                   
                    array_push($list_actual_gr, $actual_gr->TOTAL);                    
                }
            }
            
            $data['actual_gr'] = $list_actual_gr;
            
            //------- REQUEST PAK ARIAWAN --------------- NEW UPDATE 05/06/2018
            $list_topup = array();
            for ($no = 1; $no <= 12; $no++){
                if (($no + 3) <= 12){
                    $month = sprintf("%02d", $no+3);
                    
                    $topup = $this->purchase_request_m->get_new_topup_bod($year_start, $month, $budget_type, $kode_dept);
                    
                    array_push($list_topup, $topup->TOTAL_TOPUP);                    
                } else {
                    $month = sprintf("%02d", $no-9);
                    
                    $topup = $this->purchase_request_m->get_new_topup_bod($year_start, $month, $budget_type, $kode_dept);
                   
                    array_push($list_topup, $topup->TOTAL_TOPUP);                    
                }
            }
            
            $data['topup_budget'] = $list_topup;
            
            $contain = 'budget/purchase_request/approval_pr_by_bod_v';
            
        //FOR --> GM    
        } else if ($session['ROLE'] === 4) {
            $id_group = $this->session->userdata('GROUPDEPT');
            
            if($id_group == '6'){
                $kode_group = '001';
            } else if($id_group == '7') {
                $kode_group = '003';
            } else if($id_group == '10') {
                $kode_group = '004';
            }

            if($session['ROLE'] === 1){
                $kode_group = '004';
            }
            
            $data['list_kode_transaksi'] = $this->purchase_request_m->get_list_kode_trans_gm($tahun, $budget_type, $status_bgt, $kode_group);
            $get_pr_header = $this->purchase_request_m->get_pr_header_by_gm($tahun, $budget_type, $status_bgt, $kode_transaksi);
            
            if ($get_pr_header == '' || $get_pr_header == NULL){
                $kode_dept = '';
                $year_start = $tahun;
                $year_end = $tahun + 1;
                $data['dept_name'] = '';
                $data['pr_date'] = '';  
                $data['est_date'] = '';
                $data['approve_bod'] = '';
            } else {
                $kode_dept = $get_pr_header->CHR_KODE_DEPARTMENT;
                $year_start = substr($get_pr_header->CHR_FISCAL_YEAR, 0, 4);
                $year_end = substr($get_pr_header->CHR_FISCAL_YEAR, 7, 4);
                $data['dept_name'] = $get_pr_header->CHR_DEPARTMENT_DESCRIPTION;
                $data['pr_date'] = substr($get_pr_header->CHR_TGL_TRANS, 6, 2).'-'.substr($get_pr_header->CHR_TGL_TRANS, 4, 2).'-'.substr($get_pr_header->CHR_TGL_TRANS, 0, 4);
                $est_date = $this->purchase_request_m->get_estimate_date($kode_transaksi)->CHR_TGL_ESTIMASI_KEDATANGAN;
                $data['est_date'] = $est_date;
                $data['approve_bod'] = $get_pr_header->CHR_FLG_APPROVE_BOD;
            }            
            
            $list_purchase_request = $this->purchase_request_m->get_list_pr_by_gm($tahun, $budget_type, $kode_transaksi, $status_bgt);
            
            if($list_purchase_request != NULL){
                $no_budget = $list_purchase_request[0]->CHR_NO_BUDGET;
            } else {
                $no_budget = '';
            }
                        
            $data['group_name'] = $this->purchase_request_m->get_group_dept_name($kode_group, $kode_dept);
            $data['budget_by_no'] = $this->purchase_request_m->get_budget_detail_by_no($budget_type, $no_budget);
            $data['actual_by_bgtno'] = $this->purchase_request_m->get_actual_detail_by_bgtno($budget_type, $no_budget);
            
            //PLAN PER DEPT
            $data['total_budget_plan'] = $this->purchase_request_m->get_total_budget($tahun, $budget_type, $kode_dept, $act_periode, $periode_smt2);
            $data['total_unbudget_plan'] = $this->purchase_request_m->get_total_unbudget($tahun, $budget_type, $kode_dept);
            $data['total_cip_plan'] = $this->purchase_request_m->get_total_cip($tahun, $budget_type, $kode_dept, $act_periode, $periode_smt2);
            
            //REALISASI PER DEPT
            $data['total_budget_real'] = $this->purchase_request_m->get_new_total_real_dept_nonunbudget($tahun, $year_start, $year_end, $budget_type, $kode_dept);
            $data['total_unbudget_real'] = $this->purchase_request_m->get_new_total_real_dept_unbudget($tahun, $year_start, $year_end, $budget_type, $kode_dept);
            $data['total_cip_real'] = $this->purchase_request_m->get_new_total_real_dept_nonunbudget_cip($tahun, $year_start, $year_end, $budget_type, $kode_dept);
            
            //PLAN GROUP DEPT
            $data['total_budget_group'] = $this->purchase_request_m->get_total_budget_group($tahun, $budget_type, $kode_group);
            
            //TOTAL BUDGET REVISI PER GROUP DEPT
            $data['total_all_budget_revisi'] = $this->purchase_request_m->get_total_budget_revisi_group($tahun, $budget_type, $kode_group);
            
            //REALISASI GROUP DEPT ----------- NEW UPDATE 04/07/2017
            $data['total_real_group'] = $this->purchase_request_m->get_new_actual_real_gm($tahun, $year_start, $year_end, $budget_type, $kode_group, $act_periode, $periode_smt2);
            
            //DETAIL BUDGET GROUP PER MONTH ----------- NEW UPDATE 04/07/2017
            $data['detail_budget'] = $this->purchase_request_m->get_new_budget_detail_gm($tahun, $year_start, $year_end, $budget_type, $kode_group);
            $data['revisi_budget'] = $this->purchase_request_m->get_new_budget_detail_rev_gm($tahun, $year_start, $year_end, $budget_type, $kode_group);
            $data['limit_budget'] = $this->purchase_request_m->get_new_budget_limit_gm($tahun, $year_start, $year_end, $budget_type, $kode_group, $act_periode, $periode_smt2);
            $data['actual_real'] = $this->purchase_request_m->get_new_actual_real_gm($tahun, $year_start, $year_end, $budget_type, $kode_group, $act_periode, $periode_smt2);
            $data['detail_unbudget'] = $this->purchase_request_m->get_new_unbudget_detail_gm($tahun, $year_start, $year_end, $budget_type, $kode_group);
            
            //===== Additional SALES Data --- By ANU 20200421 =====//
            $data['detail_sales'] = $this->purchase_request_m->get_budget_sales($tahun);
            $data['revisi_budget_by_sales'] = $this->purchase_request_m->get_new_budget_detail_rev_gm_by_sales($tahun, $budget_type, $kode_group);
            $data['ratio_sales'] = $this->purchase_request_m->get_ratio_sales($tahun, $budget_type);
            $data['total_cr_plant'] = $this->purchase_request_m->get_total_amount_cr($tahun, $budget_type);
            //===== End Additional SALES Data --- By ANU 20200421 =====//

            $list_actual_gr = array();
            for ($no = 1; $no <= 12; $no++){
                if (($no + 3) <= 12){
                    $start_date = $year_start . sprintf("%02d", $no+3) . '01';
                    $end_date = $year_start . sprintf("%02d", $no+3) . '31';
                    
                    $actual_gr = $this->purchase_request_m->get_new_actual_gr_gm($start_date, $end_date, $budget_type, $kode_dept, $kode_group);
                    
                    array_push($list_actual_gr, $actual_gr->TOTAL);                    
                } else {
                    $start_date = $year_end . sprintf("%02d", $no-9) . '01';
                    $end_date = $year_end . sprintf("%02d", $no-9) . '31';
                    
                    $actual_gr = $this->purchase_request_m->get_new_actual_gr_gm($start_date, $end_date, $budget_type, $kode_dept, $kode_group);
                   
                    array_push($list_actual_gr, $actual_gr->TOTAL);                    
                }
            }
            
            $data['actual_gr'] = $list_actual_gr;            
           
            $contain = 'budget/purchase_request/approval_pr_by_gm_v';
        
        //FOR --> MANAGER
        } else if ($session['ROLE'] === 5 || $session['ROLE'] === 39 || $session['ROLE'] === 45 || $session['ROLE'] === 1) {
            $id_dept = $this->session->userdata('DEPT');
            $kode_dept = $this->purchase_request_m->get_user_dept($id_dept)->CHR_DEPT;
            
            if ($kode_dept == 'QUA' || $kode_dept == 'QAS'){
                if($tahun < 2018){
                    $kode_dept = 'QCO';
                } else {
                    $kode_dept = 'QAS';
                }
            } else if($kode_dept == 'PC' || $kode_dept == 'PCO'){
                $kode_dept = 'KQC';
            } else {
                $kode_dept = trim($kode_dept);
            }
            
            if($session['ROLE'] == 1){
                $kode_dept = 'MTE';
            }
            
            $data['dept_name'] = $this->purchase_request_m->get_dept_name($kode_dept)->CHR_DEPARTMENT_DESCRIPTION;
            
            $data['list_kode_transaksi'] = $this->purchase_request_m->get_list_kode_trans_manager($tahun, $budget_type, $status_bgt, $kode_dept);
            $get_pr_header = $this->purchase_request_m->get_pr_header_by_manager($tahun, $budget_type, $status_bgt, $kode_transaksi);
            
            if ($get_pr_header == '' || $get_pr_header == NULL){
                $year_start = $tahun;
                $year_end = $tahun + 1;
                $data['pr_date'] = '';    
                $data['est_date'] = '';
                $data['approve_gm'] = '';
                $data['approve_bod'] = '';
            } else {
                $year_start = substr($get_pr_header->CHR_FISCAL_YEAR, 0, 4);
                $year_end = substr($get_pr_header->CHR_FISCAL_YEAR, 7, 4);
                $data['pr_date'] = substr($get_pr_header->CHR_TGL_TRANS, 6, 2).'-'.substr($get_pr_header->CHR_TGL_TRANS, 4, 2).'-'.substr($get_pr_header->CHR_TGL_TRANS, 0, 4);
                $est_date = $this->purchase_request_m->get_estimate_date($kode_transaksi)->CHR_TGL_ESTIMASI_KEDATANGAN;
                $data['est_date'] = $est_date;
                $data['approve_gm'] = $get_pr_header->CHR_FLG_APPROVE_GM;
                $data['approve_bod'] = $get_pr_header->CHR_FLG_APPROVE_BOD;
            }             
            
            $list_purchase_request = $this->purchase_request_m->get_list_pr_by_manager($tahun, $budget_type, $kode_transaksi, $status_bgt);
           
            if($list_purchase_request != NULL){
                $no_budget = $list_purchase_request[0]->CHR_NO_BUDGET;
            } else {
                $no_budget = '';
            }
                        
            $data['budget_by_no'] = $this->purchase_request_m->get_budget_detail_by_no($budget_type, $no_budget);
            $data['actual_by_bgtno'] = $this->purchase_request_m->get_actual_detail_by_bgtno($budget_type, $no_budget);
            
            //TOTAL BUDGET PLAN PER DEPT
            $data['total_all_budget_plan'] = $this->purchase_request_m->get_total_budget_plan($tahun, $budget_type, $kode_dept);
            
            //TOTAL BUDGET REVISI PER DEPT
            $data['total_all_budget_revisi'] = $this->purchase_request_m->get_total_all_budget_revisi($tahun, $budget_type, $kode_dept);
            
            //TOTAL REALISASI PER DEPT ------------- NEW UPDATE 04/07/2017
            $data['total_all_realisasi'] = $this->purchase_request_m->get_new_actual_real($tahun, $year_start, $year_end, $budget_type, $kode_dept, $act_periode, $periode_smt2);
            
            //PLAN PER DEPT            
            $data['total_budget_plan'] = $this->purchase_request_m->get_total_budget($tahun, $budget_type, $kode_dept, $act_periode, $periode_smt2);
            $data['total_unbudget_plan'] = $this->purchase_request_m->get_total_unbudget($tahun, $budget_type, $kode_dept);
            $data['total_cip_plan'] = $this->purchase_request_m->get_total_cip($tahun, $budget_type, $kode_dept, $act_periode, $periode_smt2);

            //REALISASI PER DEPT
            $data['total_budget_real'] = $this->purchase_request_m->get_new_total_real_dept_nonunbudget($tahun, $year_start, $year_end, $budget_type, $kode_dept);
            $data['total_unbudget_real'] = $this->purchase_request_m->get_new_total_real_dept_unbudget($tahun, $year_start, $year_end, $budget_type, $kode_dept);
            $data['total_cip_real'] = $this->purchase_request_m->get_new_total_real_dept_nonunbudget_cip($tahun, $year_start, $year_end, $budget_type, $kode_dept);
            
            //DETAIL BUDGET DEPT PER MONTH ----------- NEW UPDATE 04/07/2017
            $data['detail_budget'] = $this->purchase_request_m->get_new_budget_detail($tahun, $year_start, $year_end, $budget_type, $kode_dept);
            $data['revisi_budget'] = $this->purchase_request_m->get_new_budget_detail_rev($tahun, $year_start, $year_end, $budget_type, $kode_dept);
            $data['limit_budget'] = $this->purchase_request_m->get_new_budget_limit($tahun, $year_start, $year_end, $budget_type, $kode_dept, $act_periode, $periode_smt2);
            $data['actual_real'] = $this->purchase_request_m->get_new_actual_real($tahun, $year_start, $year_end, $budget_type, $kode_dept, $act_periode, $periode_smt2);            
            $data['detail_unbudget'] = $this->purchase_request_m->get_new_unbudget_detail($tahun, $year_start, $year_end, $budget_type, $kode_dept);
            
            $data['detail_sales'] = $this->purchase_request_m->get_budget_sales($tahun);
            $data['revisi_budget_by_sales'] = $this->purchase_request_m->get_new_budget_detail_rev_by_sales($tahun, $budget_type, $kode_dept);
            $data['ratio_sales'] = $this->purchase_request_m->get_ratio_sales($tahun, $budget_type);
            $data['total_cr_plant'] = $this->purchase_request_m->get_total_amount_cr($tahun, $budget_type);

            $list_actual_gr = array();
            for ($no = 1; $no <= 12; $no++){
                if (($no + 3) <= 12){
                    $start_date = $year_start . sprintf("%02d", $no+3) . '01';
                    $end_date = $year_start . sprintf("%02d", $no+3) . '31';
                    
                    $actual_gr = $this->purchase_request_m->get_new_actual_gr($start_date, $end_date, $budget_type, $kode_dept);
                    
                    array_push($list_actual_gr, $actual_gr->TOTAL);                    
                } else {
                    $start_date = $year_end . sprintf("%02d", $no-9) . '01';
                    $end_date = $year_end . sprintf("%02d", $no-9) . '31';
                    
                    $actual_gr = $this->purchase_request_m->get_new_actual_gr($start_date, $end_date, $budget_type, $kode_dept);
                   
                    array_push($list_actual_gr, $actual_gr->TOTAL);                    
                }
            }
            
            $data['actual_gr'] = $list_actual_gr;            
            $data['alert'] = $alert; //=== Alert ===
           
            $contain = 'budget/purchase_request/approval_pr_by_manager_v';
        }
                
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(186);
        $data['news'] = $this->news_m->get_news();
        $data['msg'] = $msg;
        $data['role'] = $session['ROLE'];
        $data['npk'] = $session['NPK'];
        
        $data['no_budget'] = $no_budget;
        $data['kode_dept'] = $kode_dept;
        $data['tahun'] = $tahun;
        $data['act_periode'] = $act_periode;
        $data['periode_smt2'] = $periode_smt2;
        $data['bgt_type'] = $budget_type;
        $data['bgt_type_name'] = $this->purchase_request_m->get_bgt_type_name($budget_type);
        $data['kode_transaksi'] = $kode_transaksi;
        $data['status_bgt'] = $status_bgt;
        $data['list_budget_type'] = $this->purchase_request_m->get_budget_type();
        $data['list_pr'] = $list_purchase_request;
        
        $data['content'] = $contain;
        $data['title'] = 'Approve Purchase Request';

        $this->load->view($this->layout, $data);
    }
    
    function save_approved_pr_manager($tahun = NULL, $bgt_type = NULL, $status_bgt = NULL, $kode_transaksi = NULL){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        $session = $this->session->all_userdata();
        $npk = $session['NPK'];
        $ip = $this->db->query("SELECT CHR_IP FROM TM_USER WHERE CHR_NPK = '$npk'")->row()->CHR_IP;
        $date = date('Ymd');
        $time = date('His');
        $get_fiscal_year = $this->purchase_request_m->get_pr_fiscal_year($kode_transaksi);
        
        //---- START TRANSACTON -----//
        $bgt_aii->trans_start();
               
        $bgt_aii->query("UPDATE BDGT_TT_BUDGET_PR_HEADER
                        SET CHR_FLG_APPROVE_MAN = '1',
                            CHR_USER_MAN = '$npk',
                            CHR_IP_MAN = '$ip',
                            CHR_DATE_MAN = '$date',
                            CHR_TIME_MAN = '$time'
                        WHERE CHR_KODE_TRANSAKSI = '$kode_transaksi'");
        
        $detail_transaksi =  $this->purchase_request_m->get_detail_transaksi_pr($kode_transaksi);
        foreach($detail_transaksi as $trans){
            $year = substr($trans->CHR_TGL_ESTIMASI_KEDATANGAN,0,4);
            $month = substr($trans->CHR_TGL_ESTIMASI_KEDATANGAN,4,2) . '_MAN';
            $total_price = $trans->MON_TOTAL_PRICE_SUPPLIER;
            $total_qty = $trans->INT_QTY;
            $no_budget = $trans->CHR_NO_BUDGET;
            
            if($bgt_type == 'CAPEX'){
                $bgt_aii->query("UPDATE BDGT_TM_BUDGET_CAPEX 
                                SET [MON_OPRBLN$month] = [MON_OPRBLN$month] + $total_price
                                WHERE CHR_NO_BUDGET = '$no_budget'
                                  AND CHR_KODE_TYPE_BUDGET ='$bgt_type'");
            } else if ($bgt_type == 'CONSU') {
                $bgt_aii->query("UPDATE BDGT_TM_BUDGET_CONSUMABLE 
                                SET [MON_OPRBLN$month] = [MON_OPRBLN$month] + $total_price,
                                    [INT_QTY_OPRBLN$month] = [INT_QTY_OPRBLN$month] + $total_qty
                                WHERE CHR_NO_BUDGET= '$no_budget'
                                  AND CHR_TAHUN_ACTUAL = '$year'
                                  AND CHR_KODE_TYPE_BUDGET='$bgt_type'");
            } else {
                $bgt_aii->query("UPDATE BDGT_TM_BUDGET_EXPENSE 
                                SET [MON_OPRBLN$month] = [MON_OPRBLN$month] + $total_price,
                                    [INT_QTY_OPRBLN$month] = [INT_QTY_OPRBLN$month] + $total_qty
                                WHERE CHR_NO_BUDGET= '$no_budget'
                                  AND CHR_TAHUN_ACTUAL = '$year'
                                  AND CHR_KODE_TYPE_BUDGET='$bgt_type'");
            }            
        }
        $bgt_aii->trans_complete();
        
        if ($bgt_aii->trans_status() === FALSE)
        {
            $bgt_aii->trans_rollback();
            //$this->session->set_flashdata('error', 'Approval PR FAILED.');
            redirect("budget/purchase_request_c/approval_purchase_request/2/".$tahun."/".$bgt_type."/0/".$kode_transaksi);
        }
        else
        {
            $bgt_aii->trans_commit();
            //$this->session->set_flashdata('flashSuccess', 'Approved PR SUCCESS.');
            redirect("budget/purchase_request_c/approval_purchase_request/1/".$tahun."/".$bgt_type."/0/");
        }
        
    }
    
    function save_approved_pr_gm($tahun = NULL, $bgt_type = NULL, $status_bgt = NULL, $kode_transaksi = NULL){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);  
        $session = $this->session->all_userdata();
        $npk = $session['NPK'];
        $ip = $this->db->query("SELECT CHR_IP FROM TM_USER WHERE CHR_NPK = '$npk'")->row()->CHR_IP;
        $date = date('Ymd');
        $time = date('His');
        $get_fiscal_year = $this->purchase_request_m->get_pr_fiscal_year($kode_transaksi);
        
        //---- START TRANSACTON -----//
        $bgt_aii->trans_start();
               
        $bgt_aii->query("UPDATE BDGT_TT_BUDGET_PR_HEADER
                        SET CHR_FLG_APPROVE_GM = '1',
                            CHR_USER_GM = '$npk',
                            CHR_IP_GM = '$ip',
                            CHR_DATE_GM = '$date',
                            CHR_TIME_GM = '$time'
                        WHERE CHR_KODE_TRANSAKSI = '$kode_transaksi'");
        
        $detail_transaksi =  $this->purchase_request_m->get_detail_transaksi_pr($kode_transaksi);
        foreach($detail_transaksi as $trans){
            $year = substr($trans->CHR_TGL_ESTIMASI_KEDATANGAN,0,4);
            $month = substr($trans->CHR_TGL_ESTIMASI_KEDATANGAN,4,2) . '_GM';
            $total_price = $trans->MON_TOTAL_PRICE_SUPPLIER;
            $total_qty = $trans->INT_QTY;
            $no_budget = $trans->CHR_NO_BUDGET;
            
            if($bgt_type == 'CAPEX'){
                $bgt_aii->query("UPDATE BDGT_TM_BUDGET_CAPEX 
                                SET [MON_OPRBLN$month] = [MON_OPRBLN$month] + $total_price
                                WHERE CHR_NO_BUDGET = '$no_budget'
                                  AND CHR_KODE_TYPE_BUDGET ='$bgt_type'");
            } else if ($bgt_type == 'CONSU') {
                $bgt_aii->query("UPDATE BDGT_TM_BUDGET_CONSUMABLE 
                                SET [MON_OPRBLN$month] = [MON_OPRBLN$month] + $total_price,
                                    [INT_QTY_OPRBLN$month] = [INT_QTY_OPRBLN$month] + $total_qty
                                WHERE CHR_NO_BUDGET= '$no_budget'
                                  AND CHR_TAHUN_ACTUAL = '$year'
                                  AND CHR_KODE_TYPE_BUDGET='$bgt_type'");
            } else {
                $bgt_aii->query("UPDATE BDGT_TM_BUDGET_EXPENSE 
                                SET [MON_OPRBLN$month] = [MON_OPRBLN$month] + $total_price,
                                    [INT_QTY_OPRBLN$month] = [INT_QTY_OPRBLN$month] + $total_qty
                                WHERE CHR_NO_BUDGET= '$no_budget'
                                  AND CHR_TAHUN_ACTUAL = '$year'
                                  AND CHR_KODE_TYPE_BUDGET='$bgt_type'");
            }            
        }
        $bgt_aii->trans_complete();
        
        if ($bgt_aii->trans_status() === FALSE)
        {
            $bgt_aii->trans_rollback();
            //$this->session->set_flashdata('error', 'Approval PR FAILED.');
            redirect("budget/purchase_request_c/approval_purchase_request/2/".$tahun."/".$bgt_type."/0/".$kode_transaksi);
        }
        else
        {
            $bgt_aii->trans_commit();
            //$this->session->set_flashdata('flashSuccess', 'Approved PR SUCCESS.');
            redirect("budget/purchase_request_c/approval_purchase_request/1/".$tahun."/".$bgt_type."/0/");
        }
        
    }
    
    function save_approved_pr_bod($tahun = NULL, $bgt_type = NULL, $status_bgt = NULL, $kode_transaksi = NULL){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        $session = $this->session->all_userdata();
        $npk = $session['NPK'];
        $ip = $this->db->query("SELECT CHR_IP FROM TM_USER WHERE CHR_NPK = '$npk'")->row()->CHR_IP;
        $date = date('Ymd');
        $time = date('His');
        $get_fiscal_year = $this->purchase_request_m->get_pr_fiscal_year($kode_transaksi);
        
        //---- START TRANSACTON -----//
        $bgt_aii->trans_start();
               
        $bgt_aii->query("UPDATE BDGT_TT_BUDGET_PR_HEADER
                        SET CHR_FLG_APPROVE_BOD = '1',
                            CHR_USER_BOD = '$npk',
                            CHR_IP_BOD = '$ip',
                            CHR_DATE_BOD = '$date',
                            CHR_TIME_BOD = '$time'
                        WHERE CHR_KODE_TRANSAKSI = '$kode_transaksi'");
        
        $detail_transaksi =  $this->purchase_request_m->get_detail_transaksi_pr($kode_transaksi);
        foreach($detail_transaksi as $trans){
            $year = substr($trans->CHR_TGL_ESTIMASI_KEDATANGAN,0,4);
            $month = substr($trans->CHR_TGL_ESTIMASI_KEDATANGAN,4,2);
            $total_price = $trans->MON_TOTAL_PRICE_SUPPLIER;
            $total_qty = $trans->INT_QTY;
            $no_budget = $trans->CHR_NO_BUDGET;
            
            if($bgt_type == 'CAPEX'){
                $bgt_aii->query("UPDATE BDGT_TM_BUDGET_CAPEX 
                                SET [MON_OPRBLN$month] = [MON_OPRBLN$month] + $total_price
                                WHERE CHR_NO_BUDGET = '$no_budget'
                                  AND CHR_KODE_TYPE_BUDGET ='$bgt_type'");
            } else if ($bgt_type == 'CONSU') {
                $bgt_aii->query("UPDATE BDGT_TM_BUDGET_CONSUMABLE 
                                SET [MON_OPRBLN$month] = [MON_OPRBLN$month] + $total_price,
                                    [INT_QTY_OPRBLN$month] = [INT_QTY_OPRBLN$month] + $total_qty
                                WHERE CHR_NO_BUDGET= '$no_budget'
                                  AND CHR_TAHUN_ACTUAL = '$year'
                                  AND CHR_KODE_TYPE_BUDGET='$bgt_type'");
            } else {
                $bgt_aii->query("UPDATE BDGT_TM_BUDGET_EXPENSE 
                                SET [MON_OPRBLN$month] = [MON_OPRBLN$month] + $total_price,
                                    [INT_QTY_OPRBLN$month] = [INT_QTY_OPRBLN$month] + $total_qty
                                WHERE CHR_NO_BUDGET= '$no_budget'
                                  AND CHR_TAHUN_ACTUAL = '$year'
                                  AND CHR_KODE_TYPE_BUDGET='$bgt_type'");
            }            
        }
        $bgt_aii->trans_complete();
        
        if ($bgt_aii->trans_status() === FALSE)
        {
            $bgt_aii->trans_rollback();
            //$this->session->set_flashdata('error', 'Approval PR FAILED.');
            redirect("budget/purchase_request_c/approval_purchase_request/2/".$tahun."/".$bgt_type."/0/".$kode_transaksi);
        }
        else
        {
            $bgt_aii->trans_commit();
            //$this->session->set_flashdata('flashSuccess', 'Approved PR SUCCESS.');
            redirect("budget/purchase_request_c/approval_purchase_request/1/".$tahun."/".$bgt_type."/0/");
        }
        
    }
    
    function save_unapproved_pr_manager($tahun = NULL, $bgt_type = NULL, $status_bgt = NULL, $kode_transaksi = NULL){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        $session = $this->session->all_userdata();
        $npk = $session['NPK'];
        $ip = $this->db->query("SELECT CHR_IP FROM TM_USER WHERE CHR_NPK = '$npk'")->row()->CHR_IP;
        $date = date('Ymd');
        $time = date('His');
        $get_fiscal_year = $this->purchase_request_m->get_pr_fiscal_year($kode_transaksi);
        
        //---- START TRANSACTON -----//
        $bgt_aii->trans_start();
               
        $bgt_aii->query("UPDATE BDGT_TT_BUDGET_PR_HEADER
                        SET CHR_FLG_APPROVE_MAN = '0',
                            CHR_USER_MAN = '$npk',
                            CHR_IP_MAN = '$ip',
                            CHR_DATE_MAN = '$date',
                            CHR_TIME_MAN = '$time'
                        WHERE CHR_KODE_TRANSAKSI = '$kode_transaksi'");
        
        $detail_transaksi =  $this->purchase_request_m->get_detail_transaksi_pr($kode_transaksi);
        foreach($detail_transaksi as $trans){
            $year = substr($trans->CHR_TGL_ESTIMASI_KEDATANGAN,0,4);
            $month = substr($trans->CHR_TGL_ESTIMASI_KEDATANGAN,4,2) . '_MAN';
            $total_price = $trans->MON_TOTAL_PRICE_SUPPLIER;
            $total_qty = $trans->INT_QTY;
            $no_budget = $trans->CHR_NO_BUDGET;
            
            if($bgt_type == 'CAPEX'){
                $bgt_aii->query("UPDATE BDGT_TM_BUDGET_CAPEX 
                                SET [MON_OPRBLN$month] = [MON_OPRBLN$month] - $total_price
                                WHERE CHR_NO_BUDGET = '$no_budget'
                                  AND CHR_KODE_TYPE_BUDGET ='$bgt_type'");
            } else if ($bgt_type == 'CONSU') {
                $bgt_aii->query("UPDATE BDGT_TM_BUDGET_CONSUMABLE 
                                SET [MON_OPRBLN$month] = [MON_OPRBLN$month] - $total_price,
                                    [INT_QTY_OPRBLN$month] = [INT_QTY_OPRBLN$month] - $total_qty
                                WHERE CHR_NO_BUDGET= '$no_budget'
                                  AND CHR_TAHUN_ACTUAL = '$year' 
                                  AND CHR_KODE_TYPE_BUDGET='$bgt_type'");
            } else {
                $bgt_aii->query("UPDATE BDGT_TM_BUDGET_EXPENSE 
                                SET [MON_OPRBLN$month] = [MON_OPRBLN$month] - $total_price,
                                    [INT_QTY_OPRBLN$month] = [INT_QTY_OPRBLN$month] - $total_qty
                                WHERE CHR_NO_BUDGET= '$no_budget'
                                  AND CHR_TAHUN_ACTUAL = '$year' 
                                  AND CHR_KODE_TYPE_BUDGET='$bgt_type'");
            }            
        }
        $bgt_aii->trans_complete();
        
        if ($bgt_aii->trans_status() === FALSE)
        {
            $bgt_aii->trans_rollback();
            //$this->session->set_flashdata('error', 'Unapproval PR FAILED.');
            redirect("budget/purchase_request_c/approval_purchase_request/4/".$tahun."/".$bgt_type);
        }
        else
        {
            $bgt_aii->trans_commit();
            //$this->session->set_flashdata('flashSuccess', 'Unapproved PR SUCCESS.');
            redirect("budget/purchase_request_c/approval_purchase_request/3/".$tahun."/".$bgt_type."/1/");
        }        
    }
    
    function save_unapproved_pr_gm($tahun = NULL, $bgt_type = NULL, $status_bgt = NULL, $kode_transaksi = NULL){
        $bgt_aii = $this->load->database("bgt_aii", TRUE); 
        $session = $this->session->all_userdata();
        $npk = $session['NPK'];
        $ip = $this->db->query("SELECT CHR_IP FROM TM_USER WHERE CHR_NPK = '$npk'")->row()->CHR_IP;
        $date = date('Ymd');
        $time = date('His');
        $get_fiscal_year = $this->purchase_request_m->get_pr_fiscal_year($kode_transaksi);
        
        //---- START TRANSACTON -----//
        $bgt_aii->trans_start();
               
        $bgt_aii->query("UPDATE BDGT_TT_BUDGET_PR_HEADER
                        SET CHR_FLG_APPROVE_GM = '0',
                            CHR_USER_GM = '$npk',
                            CHR_IP_GM = '$ip',
                            CHR_DATE_GM = '$date',
                            CHR_TIME_GM = '$time'
                        WHERE CHR_KODE_TRANSAKSI = '$kode_transaksi'");
        
        $detail_transaksi =  $this->purchase_request_m->get_detail_transaksi_pr($kode_transaksi);
        foreach($detail_transaksi as $trans){
            $year = substr($trans->CHR_TGL_ESTIMASI_KEDATANGAN,0,4);
            $month = substr($trans->CHR_TGL_ESTIMASI_KEDATANGAN,4,2) . '_GM';
            $total_price = $trans->MON_TOTAL_PRICE_SUPPLIER;
            $total_qty = $trans->INT_QTY;
            $no_budget = $trans->CHR_NO_BUDGET;
            
            if($bgt_type == 'CAPEX'){
                $bgt_aii->query("UPDATE BDGT_TM_BUDGET_CAPEX 
                                SET [MON_OPRBLN$month] = [MON_OPRBLN$month] - $total_price
                                WHERE CHR_NO_BUDGET = '$no_budget'
                                  AND CHR_KODE_TYPE_BUDGET ='$bgt_type'");
            } else if ($bgt_type == 'CONSU') {
                $bgt_aii->query("UPDATE BDGT_TM_BUDGET_CONSUMABLE 
                                SET [MON_OPRBLN$month] = [MON_OPRBLN$month] - $total_price,
                                    [INT_QTY_OPRBLN$month] = [INT_QTY_OPRBLN$month] - $total_qty
                                WHERE CHR_NO_BUDGET= '$no_budget'
                                  AND CHR_TAHUN_ACTUAL = '$year'
                                  AND CHR_KODE_TYPE_BUDGET='$bgt_type'");
            } else {
                $bgt_aii->query("UPDATE BDGT_TM_BUDGET_EXPENSE 
                                SET [MON_OPRBLN$month] = [MON_OPRBLN$month] - $total_price,
                                    [INT_QTY_OPRBLN$month] = [INT_QTY_OPRBLN$month] - $total_qty
                                WHERE CHR_NO_BUDGET= '$no_budget'
                                  AND CHR_TAHUN_ACTUAL = '$year'
                                  AND CHR_KODE_TYPE_BUDGET='$bgt_type'");
            }            
        }
        $bgt_aii->trans_complete();
        
        if ($bgt_aii->trans_status() === FALSE)
        {
            $bgt_aii->trans_rollback();
            //$this->session->set_flashdata('error', 'Unapproval PR FAILED.');
            redirect("budget/purchase_request_c/approval_purchase_request/4/".$tahun."/".$bgt_type);
        }
        else
        {
            $bgt_aii->trans_commit();
            //$this->session->set_flashdata('flashSuccess', 'Unapproved PR SUCCESS.');
            redirect("budget/purchase_request_c/approval_purchase_request/3/".$tahun."/".$bgt_type."/1/");
        }        
    }
    
    function save_unapproved_pr_bod($tahun = NULL, $bgt_type = NULL, $status_bgt = NULL, $kode_transaksi = NULL){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);  
        $session = $this->session->all_userdata();
        $npk = $session['NPK'];
        $ip = $this->db->query("SELECT CHR_IP FROM TM_USER WHERE CHR_NPK = '$npk'")->row()->CHR_IP;
        $date = date('Ymd');
        $time = date('His');
        $get_fiscal_year = $this->purchase_request_m->get_pr_fiscal_year($kode_transaksi);
        
        //---- START TRANSACTON -----//
        $bgt_aii->trans_start();
               
        $bgt_aii->query("UPDATE BDGT_TT_BUDGET_PR_HEADER
                        SET CHR_FLG_APPROVE_BOD = '0',
                            CHR_USER_BOD = '$npk',
                            CHR_IP_BOD = '$ip',
                            CHR_DATE_BOD = '$date',
                            CHR_TIME_BOD = '$time'
                        WHERE CHR_KODE_TRANSAKSI = '$kode_transaksi'");
        
        $detail_transaksi =  $this->purchase_request_m->get_detail_transaksi_pr($kode_transaksi);
        foreach($detail_transaksi as $trans){
            $year = substr($trans->CHR_TGL_ESTIMASI_KEDATANGAN,0,4);
            $month = substr($trans->CHR_TGL_ESTIMASI_KEDATANGAN,4,2);
            $total_price = $trans->MON_TOTAL_PRICE_SUPPLIER;
            $total_qty = $trans->INT_QTY;
            $no_budget = $trans->CHR_NO_BUDGET;
            
            if($bgt_type == 'CAPEX'){
                $bgt_aii->query("UPDATE BDGT_TM_BUDGET_CAPEX 
                                SET [MON_OPRBLN$month] = [MON_OPRBLN$month] - $total_price
                                WHERE CHR_NO_BUDGET = '$no_budget'
                                  AND CHR_KODE_TYPE_BUDGET ='$bgt_type'");
            } else if ($bgt_type == 'CONSU') {
                $bgt_aii->query("UPDATE BDGT_TM_BUDGET_CONSUMABLE 
                                SET [MON_OPRBLN$month] = [MON_OPRBLN$month] - $total_price,
                                    [INT_QTY_OPRBLN$month] = [INT_QTY_OPRBLN$month] - $total_qty
                                WHERE CHR_NO_BUDGET= '$no_budget'
                                  AND CHR_TAHUN_ACTUAL = '$year'
                                  AND CHR_KODE_TYPE_BUDGET='$bgt_type'");
            } else {
                $bgt_aii->query("UPDATE BDGT_TM_BUDGET_EXPENSE 
                                SET [MON_OPRBLN$month] = [MON_OPRBLN$month] - $total_price,
                                    [INT_QTY_OPRBLN$month] = [INT_QTY_OPRBLN$month] - $total_qty
                                WHERE CHR_NO_BUDGET= '$no_budget'
                                  AND CHR_TAHUN_ACTUAL = '$year'  
                                  AND CHR_KODE_TYPE_BUDGET='$bgt_type'");
            }            
        }
        $bgt_aii->trans_complete();
        
        if ($bgt_aii->trans_status() === FALSE)
        {
            $bgt_aii->trans_rollback();
            //$this->session->set_flashdata('error', 'Unapproval PR FAILED.');
            redirect("budget/purchase_request_c/approval_purchase_request/4/".$tahun."/".$bgt_type);
        }
        else
        {
            $bgt_aii->trans_commit();
            //$this->session->set_flashdata('flashSuccess', 'Unapproved PR SUCCESS.');
            redirect("budget/purchase_request_c/approval_purchase_request/3/".$tahun."/".$bgt_type."/1/");
        }        
    }
    
    function approval_budget_revision($msg = NULL, $fiscal_start = NULL, $budget_type = NULL, $no_budget = NULL) {
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
        
        if($budget_type == NULL){
            $budget_type = 'CAPEX';
        }
        
        if($no_budget != NULL){
            $no_budget = str_replace('%3C', '/', $no_budget);
        } else {
            $no_budget = '';
        }
        
        $session = $this->session->all_userdata();
        //FOR --> ADMIN & ADMIN BUDGET
        if ($session['ROLE'] === 2 || $session['ROLE'] === 1 ) {            
            $get_list_budget_rev = $this->purchase_request_m->get_list_budget_rev($fiscal_start, $budget_type);
            $get_curr_detail_budget = $this->purchase_request_m->get_curr_detail_budget($fiscal_start, $fiscal_end, $budget_type, $no_budget);
            $get_req_detail_budget = $this->purchase_request_m->get_req_detail_budget($fiscal_start, $fiscal_end, $budget_type, $no_budget);
            
            if($get_curr_detail_budget != NULL){
                $kode_dept = $get_curr_detail_budget->CHR_KODE_DEPARTMENT;
            } else {
                $kode_dept = '';
            }
            
            //DETAIL REVISI BUDGET
            $get_detail_plan = $this->purchase_request_m->get_detail_plan($fiscal_start, $fiscal_end, $budget_type, $kode_dept);
            $get_detail_rev1 = $this->purchase_request_m->get_detail_rev1($fiscal_start, $fiscal_end, $budget_type, $kode_dept);
            $get_detail_limit = $this->purchase_request_m->get_detail_limit($fiscal_start, $fiscal_end, $budget_type, $kode_dept);
            $get_detail_unbudget = $this->purchase_request_m->get_detail_unbudget($fiscal_start, $fiscal_end, $budget_type, $kode_dept);
            $get_detail_actual = $this->purchase_request_m->get_detail_actual($fiscal_start, $fiscal_end, $budget_type, $kode_dept);
                       
            $contain = 'budget/purchase_request/approval_budget_revision_by_bod_v';
            
        //FOR --> BOD
        } else if ($session['ROLE'] === 3) { 
            $get_list_budget_rev = $this->purchase_request_m->get_list_budget_rev($fiscal_start, $budget_type);
            $get_curr_detail_budget = $this->purchase_request_m->get_curr_detail_budget($fiscal_start, $fiscal_end, $budget_type, $no_budget);
            $get_req_detail_budget = $this->purchase_request_m->get_req_detail_budget($fiscal_start, $fiscal_end, $budget_type, $no_budget);
            
            if($get_curr_detail_budget != NULL){
                $kode_dept = $get_curr_detail_budget->CHR_KODE_DEPARTMENT;
            } else {
                $kode_dept = '';
            }
            
            //DETAIL REVISI BUDGET
            $get_detail_plan = $this->purchase_request_m->get_detail_plan($fiscal_start, $fiscal_end, $budget_type, $kode_dept);
            $get_detail_rev1 = $this->purchase_request_m->get_detail_rev1($fiscal_start, $fiscal_end, $budget_type, $kode_dept);
            $get_detail_limit = $this->purchase_request_m->get_detail_limit($fiscal_start, $fiscal_end, $budget_type, $kode_dept);
            $get_detail_unbudget = $this->purchase_request_m->get_detail_unbudget($fiscal_start, $fiscal_end, $budget_type, $kode_dept);
            $get_detail_actual = $this->purchase_request_m->get_detail_actual($fiscal_start, $fiscal_end, $budget_type, $kode_dept);
                       
            $contain = 'budget/purchase_request/approval_budget_revision_by_bod_v';
            
        //FOR --> GM    
        } else if ($session['ROLE'] === 4) {
            $get_list_budget_rev = $this->purchase_request_m->get_list_budget_rev($fiscal_start, $budget_type);
            $get_curr_detail_budget = $this->purchase_request_m->get_curr_detail_budget($fiscal_start, $fiscal_end, $budget_type, $no_budget);
            $get_req_detail_budget = $this->purchase_request_m->get_req_detail_budget($fiscal_start, $fiscal_end, $budget_type, $no_budget);
            
            if($get_curr_detail_budget != NULL){
                $kode_dept = $get_curr_detail_budget->CHR_KODE_DEPARTMENT;
            } else {
                $kode_dept = '';
            }
            
            //DETAIL REVISI BUDGET
            $get_detail_plan = $this->purchase_request_m->get_detail_plan($fiscal_start, $fiscal_end, $budget_type, $kode_dept);
            $get_detail_rev1 = $this->purchase_request_m->get_detail_rev1($fiscal_start, $fiscal_end, $budget_type, $kode_dept);
            $get_detail_limit = $this->purchase_request_m->get_detail_limit($fiscal_start, $fiscal_end, $budget_type, $kode_dept);
            $get_detail_unbudget = $this->purchase_request_m->get_detail_unbudget($fiscal_start, $fiscal_end, $budget_type, $kode_dept);
            $get_detail_actual = $this->purchase_request_m->get_detail_actual($fiscal_start, $fiscal_end, $budget_type, $kode_dept);
                       
            $contain = 'budget/purchase_request/approval_budget_revision_by_gm_v';
        
        }
                
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(191);
        $data['news'] = $this->news_m->get_news();
        $data['role'] = $session['ROLE'];
        $data['msg'] = $msg;
        
        //--- For list value
        $data['all_fiscal'] = $this->fiscal_m->get_all_fiscal_year();
        $data['all_bgt_type'] = $this->purchase_request_m->get_budget_type();
        $data['list_budget_rev'] = $get_list_budget_rev;
        $data['curr_detail_budget'] = $get_curr_detail_budget;
        $data['req_detail_budget'] = $get_req_detail_budget;
        $data['detail_plan'] = $get_detail_plan;
        $data['detail_rev1'] = $get_detail_rev1;
        $data['detail_limit'] = $get_detail_limit;
        $data['detail_unbudget'] = $get_detail_unbudget;
        $data['detail_actual'] = $get_detail_actual;
                        
        //--- Value selected
        $data['fiscal_start'] = $fiscal_start;
        $data['fiscal_end'] = $fiscal_end;
        $data['budget_type'] = $budget_type;
        $data['no_budget'] = $no_budget;
                
        $data['content'] = $contain;
        $data['title'] = 'Approve Revisi Master Budget';

        $this->load->view($this->layout, $data);
    }
    
    function approval_summary_budget_rev($msg = NULL, $fiscal_start = NULL, $kode_dept = NULL, $month = NULL, $budget_type = NULL) {
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
        
        $year_act = substr($month, 0, 4);
        $month = substr($month, 4, 2);
        
        $session = $this->session->all_userdata();
        //FOR --> ADMIN & ADMIN BUDGET
        if ($session['ROLE'] === 2) {            
            
            $contain = 'budget/purchase_request/approval_budget_revision_by_bod_v';
            
        //FOR --> BOD
        } else if ($session['ROLE'] === 3 || $session['ROLE'] === 1 ) {        
                       
            $contain = 'budget/purchase_request/approval_summary_budget_rev_by_bod_v';
            
        //FOR --> GM    
        } else if ($session['ROLE'] === 4) {
            
            $contain = 'budget/purchase_request/approval_budget_revision_by_gm_v';
        
        }
                
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(191);
        $data['news'] = $this->news_m->get_news();
        $data['role'] = $session['ROLE'];
        $data['msg'] = $msg;
        
        //--- For list value
        $data['all_dept'] = $this->purchase_request_m->get_all_dept();
        $data['all_fiscal'] = $this->fiscal_m->get_all_fiscal_year();       
        $data['all_budget'] = $this->purchase_request_m->get_all_budget($fiscal_start, $kode_dept, $year_act, $month);
        $data['all_detail_budget'] = $this->purchase_request_m->get_all_detail_budget($fiscal_start, $kode_dept, $budget_type, $year_act, $month);
                        
        //--- Value selected
        $data['fiscal_start'] = $fiscal_start;
        $data['fiscal_end'] = $fiscal_end;
        $data['month'] = $year_act.$month;
        $data['kode_dept'] = $kode_dept;
        $data['budget_type'] = $budget_type;
                
        $data['content'] = $contain;
        $data['title'] = 'Approve Revisi Master Budget';

        $this->load->view($this->layout, $data);
    }
    
    function view_detail_budget_rev($fiscal_start = NULL, $budget_type = NULL, $month = NULL, $no_budget = NULL) {
        $this->role_module_m->authorization('44');
        
        if ($fiscal_start == NULL){
            $fiscal_start = $this->fiscal_m->get_default_fiscal_year()->CHR_FISCAL_YEAR_START;
        }
        
        $fiscal_year = $this->fiscal_m->get_selected_fiscal_year($fiscal_start);
        $fiscal_end = $fiscal_year->CHR_FISCAL_YEAR_END;
              
        if($no_budget != NULL){
            $no_budget = str_replace('%3C', '/', $no_budget);
        } else {
            $no_budget = '';
        }
        
        $session = $this->session->all_userdata();
        $get_curr_detail_budget = $this->purchase_request_m->get_curr_detail_budget($fiscal_start, $fiscal_end, $budget_type, $no_budget);
        $get_req_detail_budget = $this->purchase_request_m->get_req_detail_budget($fiscal_start, $fiscal_end, $budget_type, $no_budget);

        if($get_curr_detail_budget != NULL){
            $kode_dept = $get_curr_detail_budget->CHR_KODE_DEPARTMENT;
        } else {
            $kode_dept = '';
        }           

        $contain = 'budget/purchase_request/view_detail_budget_rev_v';
                
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(191);
        $data['news'] = $this->news_m->get_news();
        $data['role'] = $session['ROLE'];
       
        //--- For list value
        $data['all_fiscal'] = $this->fiscal_m->get_all_fiscal_year();
        $data['all_bgt_type'] = $this->purchase_request_m->get_budget_type();
        $data['curr_detail_budget'] = $get_curr_detail_budget;
        $data['req_detail_budget'] = $get_req_detail_budget;        
                        
        //--- Value selected
        $data['fiscal_start'] = $fiscal_start;
        $data['fiscal_end'] = $fiscal_end;
        $data['budget_type'] = $budget_type;
        $data['no_budget'] = $no_budget;
        $data['month'] = $month;
                
        $data['content'] = $contain;
        $data['title'] = 'Approve Revisi Master Budget';

        $this->load->view($this->layout, $data);
    }
    
    function save_approved_rev_budget_bod($fiscal_start, $fiscal_end, $budget_type, $no_budget, $no_revisi){
        $bgt_aii = $this->load->database("bgt_aii", TRUE); 
        
        //---- START TRANSACTON -----//
        $bgt_aii->trans_start();
        
        $no_budget = str_replace('%3C', '/', $no_budget);
        $req_detail_budget = $this->purchase_request_m->get_req_detail_budget($fiscal_start, $fiscal_end, $budget_type, $no_budget);
        
        if($budget_type == 'CAPEX'){
            $get_year_actual = $bgt_aii->query("SELECT CHR_TAHUN_ACTUAL FROM BDGT_TM_BUDGET_CAPEX WHERE CHR_NO_BUDGET = '$no_budget'")->row();
            
            if($get_year_actual->CHR_TAHUN_ACTUAL == $fiscal_start){
               $bgt_aii->query("UPDATE BDGT_TM_BUDGET_CAPEX
                               SET MON_LIMBLN01 = '$req_detail_budget->MON_LIMBLN01'
                                  ,MON_LIMBLN02 = '$req_detail_budget->MON_LIMBLN02'
                                  ,MON_LIMBLN03 = '$req_detail_budget->MON_LIMBLN03'
                                  ,MON_LIMBLN04 = '$req_detail_budget->MON_LIMBLN04'
                                  ,MON_LIMBLN05 = '$req_detail_budget->MON_LIMBLN05'
                                  ,MON_LIMBLN06 = '$req_detail_budget->MON_LIMBLN06'
                                  ,MON_LIMBLN07 = '$req_detail_budget->MON_LIMBLN07'
                                  ,MON_LIMBLN08 = '$req_detail_budget->MON_LIMBLN08'
                                  ,MON_LIMBLN09 = '$req_detail_budget->MON_LIMBLN09'
                                  ,MON_LIMBLN10 = '$req_detail_budget->MON_LIMBLN10'
                                  ,MON_LIMBLN11 = '$req_detail_budget->MON_LIMBLN11'
                                  ,MON_LIMBLN12 = '$req_detail_budget->MON_LIMBLN12'
                                  ,CHR_FLG_APPROVAL_PROCESS = '2'
                            WHERE CHR_TAHUN_ACTUAL = '$fiscal_start'
                                  AND CHR_NO_BUDGET = '$no_budget'");            
            } else if($get_year_actual->CHR_TAHUN_ACTUAL == $fiscal_end){
                $bgt_aii->query("UPDATE BDGT_TM_BUDGET_CAPEX
                               SET MON_LIMBLN01 = '$req_detail_budget->MON_LIMBLN13'
                                  ,MON_LIMBLN02 = '$req_detail_budget->MON_LIMBLN14'
                                  ,MON_LIMBLN03 = '$req_detail_budget->MON_LIMBLN15'
                                  ,CHR_FLG_APPROVAL_PROCESS = '2'
                            WHERE CHR_TAHUN_ACTUAL = '$fiscal_end'
                                  AND CHR_NO_BUDGET = '$no_budget'");
            } else {
                print_r('NO DATA "MASTER BUDGET" AVAILABLE');
                exit();
            }

            $bgt_aii->query("UPDATE BDGT_TT_MASTER_CHANGELOG
                            SET CHR_FLG_SWITCH = '1'
                            WHERE INT_NO_REVISI = '$no_revisi'
                                AND CHR_NO_BUDGET = '$no_budget'
                                AND CHR_TAHUN_BUDGET = '$fiscal_start'");
        } else {
            $bgt_aii->query("UPDATE BDGT_TM_BUDGET_EXPENSE
                               SET MON_LIMBLN01 = '$req_detail_budget->MON_LIMBLN01'
                                  ,MON_LIMBLN02 = '$req_detail_budget->MON_LIMBLN02'
                                  ,MON_LIMBLN03 = '$req_detail_budget->MON_LIMBLN03'
                                  ,MON_LIMBLN04 = '$req_detail_budget->MON_LIMBLN04'
                                  ,MON_LIMBLN05 = '$req_detail_budget->MON_LIMBLN05'
                                  ,MON_LIMBLN06 = '$req_detail_budget->MON_LIMBLN06'
                                  ,MON_LIMBLN07 = '$req_detail_budget->MON_LIMBLN07'
                                  ,MON_LIMBLN08 = '$req_detail_budget->MON_LIMBLN08'
                                  ,MON_LIMBLN09 = '$req_detail_budget->MON_LIMBLN09'
                                  ,MON_LIMBLN10 = '$req_detail_budget->MON_LIMBLN10'
                                  ,MON_LIMBLN11 = '$req_detail_budget->MON_LIMBLN11'
                                  ,MON_LIMBLN12 = '$req_detail_budget->MON_LIMBLN12'
                                  ,CHR_FLG_APPROVAL_PROCESS = '2'
                            WHERE CHR_TAHUN_BUDGET = '$fiscal_start'
                                  AND CHR_TAHUN_ACTUAL = '$fiscal_start'
                                  AND CHR_NO_BUDGET = '$no_budget'");
            
            $bgt_aii->query("UPDATE BDGT_TM_BUDGET_EXPENSE
                               SET MON_LIMBLN01 = '$req_detail_budget->MON_LIMBLN13'
                                  ,MON_LIMBLN02 = '$req_detail_budget->MON_LIMBLN14'
                                  ,MON_LIMBLN03 = '$req_detail_budget->MON_LIMBLN15'
                                  ,MON_LIMBLN04 = '0'
                                  ,MON_LIMBLN05 = '0'
                                  ,MON_LIMBLN06 = '0'
                                  ,MON_LIMBLN07 = '0'
                                  ,MON_LIMBLN08 = '0'
                                  ,MON_LIMBLN09 = '0'
                                  ,MON_LIMBLN10 = '0'
                                  ,MON_LIMBLN11 = '0'
                                  ,MON_LIMBLN12 = '0'
                                  ,CHR_FLG_APPROVAL_PROCESS = '2'
                            WHERE CHR_TAHUN_BUDGET = '$fiscal_start'
                                  AND CHR_TAHUN_ACTUAL = '$fiscal_end'
                                  AND CHR_NO_BUDGET = '$no_budget'");
            
            $bgt_aii->query("UPDATE BDGT_TT_MASTER_CHANGELOG
                            SET CHR_FLG_SWITCH = '1'
                            WHERE INT_NO_REVISI = '$no_revisi'
                                AND CHR_NO_BUDGET = '$no_budget'
                                AND CHR_TAHUN_BUDGET = '$fiscal_start'
                                AND CHR_TAHUN_ACTUAL = '$fiscal_start'");
            
            $bgt_aii->query("UPDATE BDGT_TT_MASTER_CHANGELOG
                            SET CHR_FLG_SWITCH = '1'
                            WHERE INT_NO_REVISI = '$no_revisi'
                                AND CHR_NO_BUDGET = '$no_budget'
                                AND CHR_TAHUN_BUDGET = '$fiscal_start'
                                AND CHR_TAHUN_ACTUAL = '$fiscal_end'");
        }
                
        $bgt_aii->trans_complete();
        
        if ($bgt_aii->trans_status() === FALSE)
        {
            $bgt_aii->trans_rollback();
            print_r("GAGAL");
            exit();
            //$this->session->set_flashdata('error', 'Approval PR FAILED.');
            redirect("budget/purchase_request_c/approval_budget_revision/2/".$fiscal_start."/".$budget_type."/0");
        }
        else
        {
            $bgt_aii->trans_commit();
            print_r("BERHASIL");
            exit();
            //$this->session->set_flashdata('flashSuccess', 'Approved PR SUCCESS.');
            redirect("budget/purchase_request_c/approval_budget_revision/1/".$fiscal_start."/".$budget_type."/1");
        }
    }
    
    function save_rejected_rev_budget_bod($fiscal_start, $fiscal_end, $budget_type, $no_budget, $no_revisi){
        $bgt_aii = $this->load->database("bgt_aii", TRUE); 
        
        //---- START TRANSACTON -----//
        $bgt_aii->trans_start();
        
        $no_budget = str_replace('%3C', '/', $no_budget);
        
        if($budget_type == 'CAPEX'){
            $bgt_aii->query("UPDATE BDGT_TM_BUDGET_CAPEX
                               SET CHR_FLG_APPROVAL_PROCESS = '3'
                               WHERE CHR_NO_BUDGET = '$no_budget'");
        } else {
            $bgt_aii->query("UPDATE BDGT_TM_BUDGET_EXPENSE
                               SET CHR_FLG_APPROVAL_PROCESS = '3'
                               WHERE CHR_NO_BUDGET = '$no_budget'");          
        }
                
        $bgt_aii->trans_complete();
        
        if ($bgt_aii->trans_status() === FALSE)
        {
            $bgt_aii->trans_rollback();
            print_r("GAGAL");
            exit();
            //$this->session->set_flashdata('error', 'Approval PR FAILED.');
            redirect("budget/purchase_request_c/approval_budget_revision/2/".$fiscal_start."/".$budget_type."/0");
        }
        else
        {
            $bgt_aii->trans_commit();
            //$this->session->set_flashdata('flashSuccess', 'Approved PR SUCCESS.');
            redirect("budget/purchase_request_c/approval_budget_revision/3/".$fiscal_start."/".$budget_type."/1");
        }
    }
    
    function download_gr($year = NULL, $bgt_type = NULL, $dept = NULL){
        $user_session = $this->session->all_userdata();
        $role = $user_session['ROLE'];
        $row = 8;

        if ($CHR_BUDGET_TYPE <> null) {
            $detail_gr = $this->purchase_request_m->get_detail_gr($INT_ID_FISCAL_YEAR, $CHR_BUDGET_TYPE, $INT_DIV, $INT_DEPT, $INT_SECT);
                
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
    
    function view_detail_budget_plant($tahun = NULL, $budget_type = NULL){
        if($tahun == NULL){
            $year_start = date('Y');
        } else {
            $year_start = $tahun;
        }  
        
        $year_end = $year_start + 1;
        $act_periode = date("Ym");
        $periode_smt2 = $tahun . '10';
        
        $kode_dept = '';
        
        //DETAIL BUDGET DIVISION PER MONTH ----------- NEW UPDATE 23/07/2018
        $data['detail_budget'] = $this->purchase_request_m->get_new_budget_detail_bod($tahun, $year_start, $year_end, $budget_type);
        $data['revisi_budget'] = $this->purchase_request_m->get_new_budget_detail_rev_bod($tahun, $year_start, $year_end, $budget_type);
        $data['limit_budget'] = $this->purchase_request_m->get_new_budget_limit_bod($tahun, $year_start, $year_end, $budget_type, $act_periode, $periode_smt2);
        $data['actual_real'] = $this->purchase_request_m->get_new_actual_real_bod($tahun, $year_start, $year_end, $budget_type, $act_periode, $periode_smt2);
        $data['detail_unbudget'] = $this->purchase_request_m->get_new_unbudget_detail_bod($tahun, $year_start, $year_end, $budget_type);

        //===== Additional SALES Data --- By ANU 20200421 =====//
        $data['detail_sales'] = $this->purchase_request_m->get_budget_sales($tahun);
        $data['revisi_budget_by_sales'] = $this->purchase_request_m->get_new_budget_detail_rev_bod_by_sales($tahun, $budget_type);
        $data['ratio_sales'] = $this->purchase_request_m->get_ratio_sales($tahun, $budget_type);
        $data['total_cr_plant'] = $this->purchase_request_m->get_total_amount_cr($tahun, $budget_type);
        //===== End Additional SALES Data --- By ANU 20200421 =====//

        $list_actual_gr = array();
        for ($no = 1; $no <= 12; $no++){
            if (($no + 3) <= 12){
                $start_date = $year_start . sprintf("%02d", $no+3) . '01';
                $end_date = $year_start . sprintf("%02d", $no+3) . '31';

                $actual_gr = $this->purchase_request_m->get_new_actual_gr_bod($start_date, $end_date, $budget_type, $kode_dept);

                array_push($list_actual_gr, $actual_gr->TOTAL);                    
            } else {
                $start_date = $year_end . sprintf("%02d", $no-9) . '01';
                $end_date = $year_end . sprintf("%02d", $no-9) . '31';

                $actual_gr = $this->purchase_request_m->get_new_actual_gr_bod($start_date, $end_date, $budget_type, $kode_dept);

                array_push($list_actual_gr, $actual_gr->TOTAL);                    
            }
        }

        $data['actual_gr'] = $list_actual_gr;

        //------- REQUEST PAK ARIAWAN --------------- NEW UPDATE 23/07/2018
        $list_topup = array();
        for ($no = 1; $no <= 12; $no++){
            if (($no + 3) <= 12){
                $month = sprintf("%02d", $no+3);

                $topup = $this->purchase_request_m->get_new_topup_bod($year_start, $month, $budget_type, $kode_dept);

                array_push($list_topup, $topup->TOTAL_TOPUP);                    
            } else {
                $month = sprintf("%02d", $no-9);

                $topup = $this->purchase_request_m->get_new_topup_bod($year_start, $month, $budget_type, $kode_dept);

                array_push($list_topup, $topup->TOTAL_TOPUP);                    
            }
        }

        $data['topup_budget'] = $list_topup;
        $data['act_periode'] = $act_periode;
        $data['periode_smt2'] = $periode_smt2;
        $data['tahun'] = $tahun;
        $data['bgt_type'] = $budget_type;
        
        $data['title'] = 'Detail Budget per Month';
        $contain = 'budget/purchase_request/view_detail_budget_plant_v';
        $data['content'] = $contain;
        $this->load->view("/template/head_blank", $data);
    }
    
    function view_detail_budget_ogawa($tahun = NULL, $budget_type = NULL){
        if($tahun == NULL){
            $year_start = date('Y');
        } else {
            $year_start = $tahun;
        }  
        
        $year_end = $year_start + 1;
        $act_periode = date("Ym");
        $periode_smt2 = $tahun . '10';
        
        $kode_dept = '';
        
        //DETAIL BUDGET OGAWA PER MONTH ----------- NEW UPDATE 24/07/2018
        $data['detail_budget'] = $this->purchase_request_m->get_new_budget_detail_ogawa($tahun, $year_start, $year_end, $budget_type);
        $data['revisi_budget'] = $this->purchase_request_m->get_new_budget_detail_rev_ogawa($tahun, $year_start, $year_end, $budget_type);
        $data['limit_budget'] = $this->purchase_request_m->get_new_budget_limit_ogawa($tahun, $year_start, $year_end, $budget_type, $act_periode, $periode_smt2);
        $data['actual_real'] = $this->purchase_request_m->get_new_actual_real_ogawa($tahun, $year_start, $year_end, $budget_type, $act_periode, $periode_smt2);
        $data['detail_unbudget'] = $this->purchase_request_m->get_new_unbudget_detail_ogawa($tahun, $year_start, $year_end, $budget_type);

        //===== Additional SALES Data --- By ANU 20200421 =====//
        $data['detail_sales'] = $this->purchase_request_m->get_budget_sales($tahun);
        //===== End Additional SALES Data --- By ANU 20200421 =====//

        $list_actual_gr = array();
        for ($no = 1; $no <= 12; $no++){
            if (($no + 3) <= 12){
                $start_date = $year_start . sprintf("%02d", $no+3) . '01';
                $end_date = $year_start . sprintf("%02d", $no+3) . '31';

                $actual_gr = $this->purchase_request_m->get_new_actual_gr_ogawa($start_date, $end_date, $budget_type, $kode_dept);

                array_push($list_actual_gr, $actual_gr->TOTAL);                    
            } else {
                $start_date = $year_end . sprintf("%02d", $no-9) . '01';
                $end_date = $year_end . sprintf("%02d", $no-9) . '31';

                $actual_gr = $this->purchase_request_m->get_new_actual_gr_ogawa($start_date, $end_date, $budget_type, $kode_dept);

                array_push($list_actual_gr, $actual_gr->TOTAL);                    
            }
        }

        $data['actual_gr'] = $list_actual_gr;

        //------- REQUEST PAK ARIAWAN --------------- NEW UPDATE 05/06/2018
//        $list_topup = array();
//        for ($no = 1; $no <= 12; $no++){
//            if (($no + 3) <= 12){
//                $month = sprintf("%02d", $no+3);
//
//                $topup = $this->purchase_request_m->get_new_topup_ogawa($year_start, $month, $budget_type, $kode_dept);
//
//                array_push($list_topup, $topup->TOTAL_TOPUP);                    
//            } else {
//                $month = sprintf("%02d", $no-9);
//
//                $topup = $this->purchase_request_m->get_new_topup_ogawa($year_start, $month, $budget_type, $kode_dept);
//
//                array_push($list_topup, $topup->TOTAL_TOPUP);                    
//            }
//        }

//        $data['topup_budget'] = $list_topup;
        
        $data['act_periode'] = $act_periode;
        $data['periode_smt2'] = $periode_smt2;
        $data['bgt_type'] = $budget_type;
        
        $data['title'] = 'Detail Budget per Month';
        $contain = 'budget/purchase_request/view_detail_budget_ogawa_v';
        $data['content'] = $contain;
        $this->load->view("/template/head_blank", $data);
    }
    
    function view_detail_budget_3pillar($tahun = NULL, $budget_type = NULL){
        if($tahun == NULL){
            $year_start = date('Y');
        } else {
            $year_start = $tahun;
        }  
        
        $year_end = $year_start + 1;
        $act_periode = date("Ym");
        $periode_smt2 = $tahun . '10';
        
        $kode_dept = '';
        
        //DETAIL BUDGET 3 PILLAR PER MONTH ----------- NEW UPDATE 24/07/2018
        $data['detail_budget'] = $this->purchase_request_m->get_new_budget_detail_3pillar($tahun, $year_start, $year_end, $budget_type);
        $data['revisi_budget'] = $this->purchase_request_m->get_new_budget_detail_rev_3pillar($tahun, $year_start, $year_end, $budget_type);
        $data['limit_budget'] = $this->purchase_request_m->get_new_budget_limit_3pillar($tahun, $year_start, $year_end, $budget_type, $act_periode, $periode_smt2);
        $data['actual_real'] = $this->purchase_request_m->get_new_actual_real_3pillar($tahun, $year_start, $year_end, $budget_type, $act_periode, $periode_smt2);
        $data['detail_unbudget'] = $this->purchase_request_m->get_new_unbudget_detail_3pillar($tahun, $year_start, $year_end, $budget_type);

        //===== Additional SALES Data --- By ANU 20200421 =====//
        $data['detail_sales'] = $this->purchase_request_m->get_budget_sales($tahun);
        //===== End Additional SALES Data --- By ANU 20200421 =====//

        $list_actual_gr = array();
        for ($no = 1; $no <= 12; $no++){
            if (($no + 3) <= 12){
                $start_date = $year_start . sprintf("%02d", $no+3) . '01';
                $end_date = $year_start . sprintf("%02d", $no+3) . '31';

                $actual_gr = $this->purchase_request_m->get_new_actual_gr_3pillar($start_date, $end_date, $budget_type, $kode_dept);

                array_push($list_actual_gr, $actual_gr->TOTAL);                    
            } else {
                $start_date = $year_end . sprintf("%02d", $no-9) . '01';
                $end_date = $year_end . sprintf("%02d", $no-9) . '31';

                $actual_gr = $this->purchase_request_m->get_new_actual_gr_3pillar($start_date, $end_date, $budget_type, $kode_dept);

                array_push($list_actual_gr, $actual_gr->TOTAL);                    
            }
        }

        $data['actual_gr'] = $list_actual_gr;
        
        $data['act_periode'] = $act_periode;
        $data['periode_smt2'] = $periode_smt2;
        $data['bgt_type'] = $budget_type;
        
        $data['title'] = 'Detail Budget per Month';
        $contain = 'budget/purchase_request/view_detail_budget_3pillar_v';
        $data['content'] = $contain;
        $this->load->view("/template/head_blank", $data);
    }

    function view_detail_limit_budget($tahun = NULL, $budget_type = NULL){
        $user_session = $this->session->all_userdata();
        $role = $user_session['ROLE'];

        if($tahun == NULL){
            $year_start = date('Y');
        } else {
            $year_start = $tahun;
        }          
        
        $start_date = '20190309';

        $group = $user_session['GROUPDEPT'];
        $dept = $user_session['DEPT'];

        if($group == '6'){
            $group = '001';
        } else if($group == '7'){
            $group = '003';
        } else {
            $group = '004';
        }
        
        //DETAIL BUDGET LIMIT PER MONTH ----------- NEW UPDATE 09/03/2019   
        if($role == 3){
            if($budget_type == 'CAPEX'){
                $data['actual_real'] = $this->purchase_request_m->get_limit_actual_real_bod($tahun, $start_date, $budget_type); 
            } else {
                $data['actual_real'] = $this->purchase_request_m->get_limit_actual_real_bod_exp($tahun, $start_date, $budget_type); 
            }             
        } else if($role == 4 || $role == 1) {
            if($budget_type == 'CAPEX'){
                $data['actual_real'] = $this->purchase_request_m->get_limit_actual_real_gm($tahun, $start_date, $budget_type);  
            } else {
                $data['actual_real'] = $this->purchase_request_m->get_limit_actual_real_gm_exp($tahun, $start_date, $budget_type, $group);  
            }            
        } else {
            if($budget_type == 'CAPEX'){
                $data['actual_real'] = $this->purchase_request_m->get_limit_actual_real_gm($tahun, $start_date, $budget_type);  
            } else {
                $data['actual_real'] = $this->purchase_request_m->get_limit_actual_real_gm_exp($tahun, $start_date, $budget_type, $group);  
            }             
        }             
        
        $data['budget_type'] = $budget_type;
        $data['title'] = 'Detail Budget Limit';
        $contain = 'budget/purchase_request/view_additional_report_v';
        $data['content'] = $contain;
        $this->load->view("/template/head_blank", $data);
    }

}
?>

