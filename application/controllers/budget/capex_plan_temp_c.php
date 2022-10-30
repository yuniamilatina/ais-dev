<?php

class capex_plan_temp_c extends CI_Controller {

    private $layout = '/template/head';
    private $back_to_manage = 'budget/capex_plan_temp_c/index/';
    private $back_to_approve = 'budget/capex_plan_temp_c/prepare_approve_capex/';

    public function __construct() {
        parent::__construct();
        $this->load->model('budget/capex_plan_temp_m');
        $this->load->model('budget/budgetcapexdetail_m');
        $this->load->model('basis/log_m');
        $this->load->model('basis/role_module_m');
        $this->load->model('budget/fiscal_m');
        $this->load->model('organization/dept_m');
        $this->load->model('organization/section_m');
        $this->load->model('budget/budgetcategory_m');
        $this->load->model('budget/budgetsubcategory_m');
        $this->load->model('portal/news_m');
    }

    //manage by supervisor
    function index($msg = NULL) {
        $this->role_module_m->authorization('18');
        $session = $this->session->all_userdata();

        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Creating success </strong> The data is successfully created </div >";
        } else if ($msg == 2) {
            $msg = "<div class = 'alert alert-`'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Updating success </strong> The data is successfully updated </div >";
        } else if ($msg == 3) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Deleted success </strong> The data is successfully deleted </div >";
        } else if ($msg == 4) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Commited success </strong> The data is successfully commited </div >";
        } else {
            $msg = "";
        }

        $this_fiscal_year = $this->fiscal_m->get_id_fiscal_this_year();

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(18);
        $data['news'] = $this->news_m->get_news();
        $data['msg'] = $msg;

        if ($session['ROLE'] === 2 || $session['ROLE'] === 1) {
            $data_contain = $this->capex_plan_temp_m->get_capex_plan_temp_by_admin($this_fiscal_year);
            $contain = 'budget/budgetcapex/manage_budgetcapex_by_admin_v';
        } else if ($session['ROLE'] === 6) {
            $data_contain = $this->capex_plan_temp_m->get_capex_plan_temp_by_supervisor($session['SECTION'], $this_fiscal_year);
            $contain = 'budget/budgetcapex/manage_budgetcapex_by_section_v';
        }

        $data['fiscal'] = $this->fiscal_m->select_fiscal_year($this_fiscal_year);
        $data['stat_commit'] = $this->capex_plan_temp_m->get_stat_commit($this_fiscal_year);
        $data['permit_approve'] = $this->capex_plan_temp_m->get_permit_approve_by_admin($this_fiscal_year);
        $data['data'] = $data_contain;
        $data['content'] = $contain;
        $data['title'] = 'Manage Planning Capex';
        $data['this_fiscal_year'] = $this_fiscal_year;

        $this->load->view($this->layout, $data);
    }

    //show budget had approve manager by supervisor
    function select_director_approves($msg = null) {
        $this->role_module_m->authorization('18');
        $this_fiscal_year = $this->fiscal_m->get_id_fiscal_this_year();
        $session = $this->session->all_userdata();

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
        $data['sidebar'] = $this->role_module_m->side_bar(18);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Manage Planning Capex';
        $data['msg'] = $msg;

        if ($session['ROLE'] === 2 || $session['ROLE'] === 1) {
            $data_contain = $this->capex_plan_temp_m->get_capex_plan_temp_approve_by_director_by_admin($this_fiscal_year);
            $contain = 'budget/budgetcapex/manage_budgetcapex_by_admin_v';
        } else if ($session['ROLE'] === 6) {
            $data_contain = $this->capex_plan_temp_m->get_capex_plan_temp_approve_by_director_by_section($session['SECTION'], $this_fiscal_year);
            $contain = 'budget/budgetcapex/manage_budgetcapex_by_section_v';
        }

        $data['fiscal'] = $this->fiscal_m->select_fiscal_year($this_fiscal_year);
        $data['permit_approve'] = $this->capex_plan_temp_m->get_permit_approve_by_admin($this_fiscal_year);
        $data['stat_commit'] = $this->capex_plan_temp_m->get_stat_commit($this_fiscal_year);
        $data['data'] = $data_contain;
        $data['content'] = $contain;
        $data['this_fiscal_year'] = $this_fiscal_year;


        $this->load->view($this->layout, $data);
    }

    //show budget had approve manager by supervisor
    function select_manager_approves($msg = null) {
        $this->role_module_m->authorization('18');
        $this_fiscal_year = $this->fiscal_m->get_id_fiscal_this_year();
        $session = $this->session->all_userdata();

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
        $data['sidebar'] = $this->role_module_m->side_bar(18);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Manage Planning Capex';
        $data['msg'] = $msg;

        if ($session['ROLE'] === 2 || $session['ROLE'] === 1) {
            $data_contain = $this->capex_plan_temp_m->get_capex_plan_temp_approve_by_manager_by_admin($this_fiscal_year);
            $contain = 'budget/budgetcapex/manage_budgetcapex_by_admin_v';
        } else if ($session['ROLE'] === 6) {
            $data_contain = $this->capex_plan_temp_m->get_capex_plan_temp_approve_by_manager_by_section($session['SECTION'], $this_fiscal_year);
            $contain = 'budget/budgetcapex/manage_budgetcapex_by_section_v';
        }

        $data['fiscal'] = $this->fiscal_m->select_fiscal_year($this_fiscal_year);
        $data['permit_approve'] = $this->capex_plan_temp_m->get_permit_approve_by_admin($this_fiscal_year);
        $data['stat_commit'] = $this->capex_plan_temp_m->get_stat_commit($this_fiscal_year);
        $data['data'] = $data_contain;
        $data['content'] = $contain;
        $data['this_fiscal_year'] = $this_fiscal_year;


        $this->load->view($this->layout, $data);
    }

    //show budget had approve gm by supervisor
    function select_gm_approves($msg = null) {
        $this->role_module_m->authorization('18');
        $session = $this->session->all_userdata();
        $this_fiscal_year = $this->fiscal_m->get_id_fiscal_this_year();

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
        $data['sidebar'] = $this->role_module_m->side_bar(18);
        $data['title'] = 'Manage Planning Capex';
        $data['news'] = $this->news_m->get_news();
        $data['msg'] = $msg;

        if ($session['ROLE'] === 2 || $session['ROLE'] === 1) {
            $data_contain = $this->capex_plan_temp_m->get_capex_plan_temp_approve_by_gm_by_admin($this_fiscal_year);
            $contain = 'budget/budgetcapex/manage_budgetcapex_by_admin_v';
        } else if ($session['ROLE'] === 6) {
            $data_contain = $this->capex_plan_temp_m->get_capex_plan_temp_approve_by_gm_by_section($session['SECTION'], $this_fiscal_year);
            $contain = 'budget/budgetcapex/manage_budgetcapex_by_section_v';
        }

        $data['fiscal'] = $this->fiscal_m->select_fiscal_year($this_fiscal_year);
        $data['permit_approve'] = $this->capex_plan_temp_m->get_permit_approve_by_admin($this_fiscal_year);
        $data['stat_commit'] = $this->capex_plan_temp_m->get_stat_commit($this_fiscal_year);
        $data['data'] = $data_contain;
        $data['content'] = $contain;
        $data['this_fiscal_year'] = $this_fiscal_year;


        $this->load->view($this->layout, $data);
    }

    //show budget had approve no one by supervisor
    function select_no_approves($msg = null) {
        $this->role_module_m->authorization('18');
        $session = $this->session->all_userdata();
        $this_fiscal_year = $this->fiscal_m->get_id_fiscal_this_year();

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
        $data['sidebar'] = $this->role_module_m->side_bar(18);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Manage Planning Capex';
        $data['msg'] = $msg;

        if ($session['ROLE'] === 2 || $session['ROLE'] === 1) {
            $data_contain = $this->capex_plan_temp_m->get_capex_plan_temp_approve_by_no_one_by_admin($this_fiscal_year);
            $contain = 'budget/budgetcapex/manage_budgetcapex_by_admin_v';
        } else if ($session['ROLE'] === 6) {
            $data_contain = $this->capex_plan_temp_m->get_capex_plan_temp_approve_by_no_one_by_section($session['SECTION'], $this_fiscal_year);
            $contain = 'budget/budgetcapex/manage_budgetcapex_by_section_v';
        }

        $data['fiscal'] = $this->fiscal_m->select_fiscal_year($this_fiscal_year);
        $data['permit_approve'] = $this->capex_plan_temp_m->get_permit_approve_by_admin($this_fiscal_year);
        $data['stat_commit'] = $this->capex_plan_temp_m->get_stat_commit($this_fiscal_year);
        $data['data'] = $data_contain;
        $data['content'] = $contain;
        $data['this_fiscal_year'] = $this_fiscal_year;



        $this->load->view($this->layout, $data);
    }

//    function search_budgetcapex() {
//        $this->role_module_m->authorization('18');
//
//        $fiscal = $this->input->post('INT_ID_FISCAL_YEAR');
//
//        $data['app'] = $this->role_module_m->get_app();
//        $data['module'] = $this->role_module_m->get_module();
//        $data['function'] = $this->role_module_m->get_function();
//        $data['sidebar'] = $this->role_module_m->side_bar(18);
//        $data['news'] = $this->news_m->get_news();
//
//        $session = $this->session->all_userdata();
//        if ($session['ROLE'] === 2 || $session['ROLE'] === 1) {
//            $data_contain = $this->capex_plan_temp_m->get_planning_capex_temp_by_admin($fiscal);
//            $contain = 'budget/budgetcapex/rekap_by_admin_v';
//        } else if ($session['ROLE'] === 3) {
//            $this->load->model('organization/division_m');
//            $data_contain = $this->capex_plan_temp_m->get_capex_plan_temp_by_director($session['DIVISION'], $fiscal);
//            $contain = 'budget/budgetcapex/approve_by_division_v';
//            $division = $this->division_m->get_name_division($session['DIVISION']);
//            $data['group'] = $division;
//        } else if ($session['ROLE'] === 4) {
//            $this->load->model('organization/groupdept_m');
//            $data_contain = $this->capex_plan_temp_m->get_capex_plan_temp_by_gm($session['GROUPDEPT'], $fiscal);
//            $contain = 'budget/budgetcapex/approve_by_gm_v';
//            $group = $this->groupdept_m->get_name_groupdept($session['GROUPDEPT']);
//            $data['group'] = $group;
//        } else if ($session['ROLE'] === 5) {
//            $this->load->model('organization/dept_m');
//            $data_contain = $this->capex_plan_temp_m->get_capex_plan_temp_by_manager($session['DEPT'], $fiscal);
//            $contain = 'budget/budgetcapex/approve_by_dept_v';
//            $dept = $this->dept_m->get_name_dept($session['DEPT']);
//            $data['group'] = $dept;
//        } else if ($session['ROLE'] === 6) {
//            $data_contain = $this->capex_plan_temp_m->get_capex_plan_temp_by_supervisor($session['SECTION'], $fiscal);
//            $contain = 'budget/budgetcapex/rekap_by_admin_v';
//            $group = $this->section_m->get_name_section($session['SECTION']);
//            $data['group'] = $group;
//        }
//
//        $data['data_fiscal'] = $this->fiscal_m->get_fiscal();
//        $data['this_fiscal_year'] = $fiscal;
//        $data['fiscal'] = $this->fiscal_m->select_fiscal_year($fiscal);
//        $data['msg'] = null;
//
//        $data['data'] = $data_contain;
//        $data['content'] = $contain;
//        $data['title'] = 'Capex Budget';
//
//        $this->load->view($this->layout, $data);
//    }
    //prepare to approve 3 layer
    function prepare_approve_capex($msg = NULL) {
        $this->load->model('organization/dept_m');
        $this->load->model('organization/division_m');
        $this->load->model('organization/groupdept_m');
        $this->role_module_m->authorization('42');
        $this_fiscal_year = $this->fiscal_m->get_id_fiscal_this_year();
        $session = $this->session->all_userdata();

        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Approve success </strong> The data is successfully approve </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Approve failed </strong> You must select data to be approve </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Reject success </strong> The data is successfully reject </div >";
        } else {
            $msg = "";
        }

        if ($session['ROLE'] === 1 || $session['ROLE'] === 2) {
            $data_contain = $this->capex_plan_temp_m->get_capex_plan_temp_to_commit_by_admin($this_fiscal_year);
            $data_containt_detail = $this->capex_plan_temp_m->get_capex_plan_temp_detail_to_commit_by_admin($this_fiscal_year);
            $contain = 'budget/budgetcapex/rekap_by_admin_v';
            $data['stat_commit'] = $this->capex_plan_temp_m->get_stat_commit($this_fiscal_year);
            $data['permit_approve'] = $this->capex_plan_temp_m->get_permit_approve_by_admin($this_fiscal_year);
            $group = '';
        } else if ($session['ROLE'] === 3) {
            $data_contain = $this->capex_plan_temp_m->get_capex_plan_temp_by_director($session['DIVISION'], $this_fiscal_year);
            $contain = 'budget/budgetcapex/approve_by_director_v';
            $group = $this->division_m->get_name_division($session['DIVISION']);
            $data_containt_detail = $this->capex_plan_temp_m->get_capex_plan_temp_detail_by_director($session['DIVISION'], $this_fiscal_year);
            $data['permit_approve'] = $this->capex_plan_temp_m->get_permit_approve_by_director($this_fiscal_year);
        } else if ($session['ROLE'] === 4) {
            $data_contain = $this->capex_plan_temp_m->get_capex_plan_temp_by_gm($session['GROUPDEPT'], $this_fiscal_year);
            $contain = 'budget/budgetcapex/approve_by_gm_v';
            $group = $this->groupdept_m->get_name_groupdept($session['GROUPDEPT']);
            $data_containt_detail = $this->capex_plan_temp_m->get_capex_plan_temp_detail_by_gm($session['GROUPDEPT'], $this_fiscal_year);
            $data['permit_approve'] = $this->capex_plan_temp_m->get_permit_approve_by_gm($this_fiscal_year);
        } else if ($session['ROLE'] === 5) {
            $data_contain = $this->capex_plan_temp_m->get_capex_plan_temp_by_manager($session['DEPT'], $this_fiscal_year);
            $contain = 'budget/budgetcapex/approve_by_manager_v';
            $group = $this->dept_m->get_name_dept($session['DEPT']);
            $data_containt_detail = $this->capex_plan_temp_m->get_capex_plan_temp_detail_by_manager($session['DEPT'], $this_fiscal_year);
            $data['permit_approve'] = $this->capex_plan_temp_m->get_permit_approve_by_admin($this_fiscal_year);
        }

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(42);
        $data['news'] = $this->news_m->get_news();
        $data['group'] = $group;
        $data['msg'] = $msg;

        $data['data_fiscal'] = $this->fiscal_m->get_fiscal();
        $data['fiscal'] = $this->fiscal_m->select_fiscal_year($this_fiscal_year);

        $data['this_fiscal_year'] = $this_fiscal_year;
        $data['data_capex_detail'] = $data_containt_detail;
        $data['data'] = $data_contain;
        $data['content'] = $contain;
        $data['title'] = 'Manage Planning Capex';

        $this->load->view($this->layout, $data);
    }

    //search prepare approve 3 layern                 
    function search_prepare_approve_capex($msg = NULL) {
        $this->load->model('organization/dept_m');
        $this->load->model('organization/division_m');
        $this->load->model('organization/groupdept_m');
        $this->role_module_m->authorization('42');
        $session = $this->session->all_userdata();
        $this_fiscal_year = $this->input->post('INT_ID_FISCAL_YEAR');

        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Creating success </strong> The data is successfully created </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Approve failed </strong> You must select data to be approve </div >";
        } else {
            $msg = "";
        }

        if ($session['ROLE'] === 1 || $session['ROLE'] === 2) {
            $data_contain = $this->capex_plan_temp_m->get_capex_plan_temp_to_commit_by_admin($this_fiscal_year);
            $data_containt_detail = $this->capex_plan_temp_m->get_capex_plan_temp_detail_to_commit_by_admin($this_fiscal_year);
            $data['stat_commit'] = $this->capex_plan_temp_m->get_stat_commit($this_fiscal_year);
            $data['permit_approve'] = $this->capex_plan_temp_m->get_permit_approve_by_admin($this_fiscal_year);
            $contain = 'budget/budgetcapex/rekap_by_admin_v';
            $group = '';
        } else if ($session['ROLE'] === 3) {
            $this->load->model('organization/division_m');
            $data_contain = $this->capex_plan_temp_m->get_capex_plan_temp_by_director($session['DIVISION'], $this_fiscal_year);
            $contain = 'budget/budgetcapex/approve_by_director_v';
            $group = $this->division_m->get_name_division($session['DIVISION']);
            $data_containt_detail = $this->capex_plan_temp_m->get_capex_plan_temp_detail_by_director($session['DIVISION'], $this_fiscal_year);
            $data['permit_approve'] = $this->capex_plan_temp_m->get_permit_approve_by_director($this_fiscal_year);
        } else if ($session['ROLE'] === 4) {
            $this->load->model('organization/groupdept_m');
            $data_contain = $this->capex_plan_temp_m->get_capex_plan_temp_by_gm($session['GROUPDEPT'], $this_fiscal_year);
            $contain = 'budget/budgetcapex/approve_by_gm_v';
            $group = $this->groupdept_m->get_name_groupdept($session['GROUPDEPT']);
            $data_containt_detail = $this->capex_plan_temp_m->get_capex_plan_temp_detail_by_gm($session['GROUPDEPT'], $this_fiscal_year);
            $data['permit_approve'] = $this->capex_plan_temp_m->get_permit_approve_by_gm($this_fiscal_year);
        } else if ($session['ROLE'] === 5) {
            $this->load->model('organization/dept_m');
            $data_contain = $this->capex_plan_temp_m->get_capex_plan_temp_by_manager($session['DEPT'], $this_fiscal_year);
            $contain = 'budget/budgetcapex/approve_by_manager_v';
            $group = $this->dept_m->get_name_dept($session['DEPT']);
            $data_containt_detail = $this->capex_plan_temp_m->get_capex_plan_temp_detail_by_manager($session['DEPT'], $this_fiscal_year);
            $data['permit_approve'] = $this->capex_plan_temp_m->get_permit_approve_by_admin($this_fiscal_year);
        }

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(42);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Manage Planning Capex';
        $data['group'] = $group;
        $data['msg'] = $msg;

        $data['data_fiscal'] = $this->fiscal_m->get_fiscal();
        $data['fiscal'] = $this->fiscal_m->select_fiscal_year($this_fiscal_year);
        $data['data_capex_detail'] = $data_containt_detail;
        $data['this_fiscal_year'] = $this_fiscal_year;
        $data['data'] = $data_contain;
        $data['content'] = $contain;

        $this->load->view($this->layout, $data);
    }

    function view_detail_by_div($division, $fiscal) {
        $this->role_module_m->authorization('42');
        $this->load->model('organization/division_m');

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['news'] = $this->news_m->get_news();
        $data['sidebar'] = $this->role_module_m->side_bar(42);
        $data['title'] = 'Manage Budget Planning';
        $data['msg'] = null;

        $data['data'] = $this->capex_plan_temp_m->get_capex_plan_temp_by_director($division, $fiscal);
        $data['data_capex_detail'] = $this->capex_plan_temp_m->get_capex_plan_temp_detail_by_director($division, $fiscal);
        $data['content'] = 'budget/budgetcapex/approve_by_admin_v';

        $data['group'] = $this->division_m->get_name_division($division);
        $data['fiscal'] = $this->fiscal_m->select_fiscal_year($fiscal);
        $data['data_fiscal'] = $this->fiscal_m->get_fiscal();

        $this->load->view($this->layout, $data);
    }

    function view_detail_by_gm($groupdept, $fiscal) {
        $this->role_module_m->authorization('42');
        $this->load->model('organization/groupdept_m');

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['news'] = $this->news_m->get_news();
        $data['sidebar'] = $this->role_module_m->side_bar(42);
        $data['title'] = 'Manage Budget Planning';
        $data['msg'] = null;

        $data['data'] = $this->capex_plan_temp_m->get_capex_plan_temp_by_gm($groupdept, $fiscal);
        $data['data_capex_detail'] = $this->capex_plan_temp_m->get_capex_plan_temp_detail_by_gm($groupdept, $fiscal);
        $data['content'] = 'budget/budgetcapex/approve_by_gm_v';

        $data['group'] = $this->groupdept_m->get_name_groupdept($groupdept);
        $data['fiscal'] = $this->fiscal_m->select_fiscal_year($fiscal);

        $data['data_fiscal'] = $this->fiscal_m->get_fiscal();

        $this->load->view($this->layout, $data);
    }

    function view_detail_by_manager($dept, $fiscal) {
        $this->role_module_m->authorization('42');
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Manage Budget Planning';
        $data['sidebar'] = $this->role_module_m->side_bar(42);
        $data['msg'] = null;

        $contain = 'budget/budgetcapex/approve_by_manager_v';
        $data_contain = $this->capex_plan_temp_m->get_capex_plan_temp_by_manager($dept, $fiscal);
        $data['data_capex_detail'] = $this->capex_plan_temp_m->get_capex_plan_temp_detail_by_manager($dept, $fiscal);

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
        $data['content'] = $contain;

        $this->load->view($this->layout, $data);
    }

    //view breakdown budget plan
    function view_detail_by_supervisor($section, $fiscal) {
        $this->role_module_m->authorization('42');
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['news'] = $this->news_m->get_news();
        $data['sidebar'] = $this->role_module_m->side_bar(42);

        $data['group'] = $this->section_m->get_name_section($section);
        $data['fiscal'] = $this->fiscal_m->select_fiscal_year($fiscal);

        $data_contain = $this->capex_plan_temp_m->get_capex_plan_temp_by_supervisor($section, $fiscal);
        $data['fiscal'] = $this->fiscal_m->select_fiscal_year($fiscal);
        $data['id_section'] = $section;
        $data['id_fiscal'] = $fiscal;
        $contain = 'budget/budgetcapex/list_bc_by_section_v';

        $data['data_fiscal'] = $this->fiscal_m->get_fiscal();
        $data['title'] = 'Manage Budget Planning';
        $data['data'] = $data_contain;
        $data['content'] = $contain;

        $this->load->view($this->layout, $data);
    }

    function view_detail_capex_plan_temp($no_budget_temp, $msg = null) {
        $this->role_module_m->authorization('42');
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

        $this->load->model('budget/budgetproject_m');
        $this->load->model('budget/budgetproduct_m');
        $this->load->model('budget/project_m');
        $this->load->model('budget/product_m');
        $this->load->model('budget/purposebudget_m');
        $this->load->model('budget/unit_m');

        $session = $this->session->all_userdata();
        if ($session['ROLE'] === 6) {
            $contain = 'budget/budgetcapex/view_budgetcapex_by_section_v';
        } else if ($session['ROLE'] === 1 || $session['ROLE'] === 2) {
            $contain = 'budget/budgetcapex/view_budgetcapex_by_admin_v';
        } else if ($session['ROLE'] === 3 || $session['ROLE'] === 4 || $session['ROLE'] === 5) {
            $contain = 'budget/budgetcapex/view_budgetcapex_by_other_v';
        }

        $data['title'] = 'View Budget Capex';
        $data['msg'] = $msg;
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(42);
        $data['news'] = $this->news_m->get_news();

        $data['data_project'] = $this->budgetproject_m->get_data_project($no_budget_temp);
        $data['data_product'] = $this->budgetproduct_m->get_data_product($no_budget_temp);

        $data['data_project_new'] = $this->budgetproject_m->get_current_data_project($no_budget_temp);
        $data['data_product_new'] = $this->budgetproduct_m->get_current_data_product($no_budget_temp);

        $data['data_fiscal'] = $this->fiscal_m->get_fiscal();
        $data['data_budgetsubcategory'] = $this->budgetsubcategory_m->get_budgetsubcategory();
        $data['data_purposebudget'] = $this->purposebudget_m->get_purposebudget();
        $data['unit'] = $this->unit_m->get_unit();
        $data['data_detail'] = $this->budgetcapexdetail_m->get_capex_plan_temp_detail($no_budget_temp);
        $data['data'] = $this->capex_plan_temp_m->get_data_capex_plan_temp($no_budget_temp)->row();
        $data['content'] = $contain;

        $this->load->view($this->layout, $data);
    }

    function view_detail_capex_plan($no_budget_temp, $msg = null) {
        $this->role_module_m->authorization('18');
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

        $this->load->model('budget/budgetproject_m');
        $this->load->model('budget/budgetproduct_m');
        $this->load->model('budget/project_m');
        $this->load->model('budget/product_m');
        //$this->load->model('budget/costcenter_m');
        $this->load->model('budget/purposebudget_m');
        $this->load->model('budget/unit_m');

        $session = $this->session->all_userdata();
        if ($session['ROLE'] === 6) {
            $contain = 'budget/budgetcapex/view_budgetcapex_by_section_v';
        } else if ($session['ROLE'] === 1 || $session['ROLE'] === 2) {
            $contain = 'budget/budgetcapex/view_budgetcapex_by_admin_v';
        } else if ($session['ROLE'] === 3 || $session['ROLE'] === 4 || $session['ROLE'] === 5) {
            $contain = 'budget/budgetcapex/view_budgetcapex_by_other_v';
        }

        $data['title'] = 'View Budget Capex';
        $data['msg'] = $msg;
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(18);
        $data['news'] = $this->news_m->get_news();

        $data['data_project'] = $this->budgetproject_m->get_data_project($no_budget_temp);
        $data['data_product'] = $this->budgetproduct_m->get_data_product($no_budget_temp);

        $data['data_project_new'] = $this->budgetproject_m->get_current_data_project($no_budget_temp);
        $data['data_product_new'] = $this->budgetproduct_m->get_current_data_product($no_budget_temp);

        //$data['data_cost_center'] = $this->costcenter_m->get_costcenter();
        $data['data_fiscal'] = $this->fiscal_m->get_fiscal();
        $data['data_budgetsubcategory'] = $this->budgetsubcategory_m->get_budgetsubcategory();
        $data['data_purposebudget'] = $this->purposebudget_m->get_purposebudget();
        $data['unit'] = $this->unit_m->get_unit();
        $data['data_detail'] = $this->budgetcapexdetail_m->get_capex_plan_temp_detail($no_budget_temp);
        $data['data'] = $this->capex_plan_temp_m->get_data_capex_plan_temp($no_budget_temp)->row();
        $data['content'] = $contain;

        $this->load->view($this->layout, $data);
    }

    function initialFiscal() {
        $fiscal = $this->input->post('id', TRUE);
        $session = $this->session->all_userdata();
        $data_contain = $this->capex_plan_temp_m->select_budgetcapex_by_dept($session['DEPT'], $fiscal);
        $data['data'] = $data_contain;
        $contain = 'budget/budgetcapex/approve_by_dept_v';
        $data['content'] = $contain;

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

    function buildsubcategory() {
        echo $id_budget_category = $this->input->post('id', TRUE);
        $data['data_budgetsubcategory'] = $this->budgetsubcategory_m->get_budgetsubcategory_by_budgetcategory($id_budget_category);
        $output = null;
        foreach ($data['data_budgetsubcategory'] as $row) {
            $output .= "<option value='" . $row->INT_ID_BUDGET_SUB_CATEGORY . "'>" . $row->CHR_BUDGET_SUB_CATEGORY . ' - ' . $row->CHR_BUDGET_SUB_CATEGORY_DESC . "</option>";
        }
        echo $output;
    }

    function create_budgetcapex() {
        $this->role_module_m->authorization('18');
        $this->load->model('budget/project_m');
        $this->load->model('budget/product_m');
        $this->load->model('budget/purposebudget_m');
        $this->load->model('budget/unit_m');
        $data['title'] = 'Create Budget Capex';

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(18);

        $data['news'] = $this->news_m->get_news();
        $data['data_dept'] = $this->dept_m->get_dept();
        $data['data_section'] = $this->section_m->get_section();
        $data['data_fiscal'] = $this->fiscal_m->get_fiscal();
        $data['data_budgetsubcategory'] = $this->budgetsubcategory_m->get_budgetsubcategory();
        $data['data_budgetcategory'] = $this->budgetcategory_m->get_budgetcategory_capex();
        $data['data_purposebudget'] = $this->purposebudget_m->get_purposebudget();
        $data['data_project'] = $this->project_m->get_project();
        $data['data_product'] = $this->product_m->get_product();
        $data['unit'] = $this->unit_m->get_unit();
        $data['this_fiscal_year'] = $this->fiscal_m->get_id_fiscal_this_year();

        $data['content'] = 'budget/budgetcapex/create_budgetcapex_v';

        $this->load->view($this->layout, $data);
    }

    function save_budgetcapex() {
        $this->load->model('budget/budgetproject_m');
        $this->load->model('budget/budgetproduct_m');
        $this->load->model('budget/budgetcapexdetail_m');
        $this->load->model('budget/costcenter_m');
        $session = $this->session->all_userdata();

        if ($session['ROLE'] === 1 || $session['ROLE'] === 2) {
            $this->form_validation->set_rules('INT_ID_SECTION', 'Section', 'required|trim');
            $section = $this->input->post('INT_ID_SECTION');
            $this_fiscal_year = $this->input->post('INT_ID_FISCAL_YEAR');
        } else if ($session['ROLE'] === 6) {
            $section = $session['SECTION'];
            $this_fiscal_year = $data['this_fiscal_year'] = $this->fiscal_m->get_id_fiscal_this_year();
        }

        $subcategory = $this->input->post('INT_ID_BUDGET_SUB_CATEGORY');
        $project = $this->input->post('INT_ID_PROJECT');
        $product = $this->input->post('INT_ID_PRODUCT');

        $no_budget_temp = $this->capex_plan_temp_m->generated_id();

        $this->form_validation->set_rules('CHR_BUDGET_NAME', 'Budget Name', 'required|trim');
        $this->form_validation->set_rules('INT_QUANTITY', 'Quantity', 'required|trim|is_natural_no_zero');
        $this->form_validation->set_rules('DEC_PRICE_PER_UNIT', 'Price per Unit', 'required|trim|is_natural_no_zero');

        if ($this->form_validation->run() == FALSE) {
            $this->create_budgetcapex();
        } else {
            $data = array(
                'INT_NO_BUDGET_CPX_TEMP' => $no_budget_temp,
                'CHR_BUDGET_NAME' => $this->input->post('CHR_BUDGET_NAME'),
                'INT_ID_FISCAL_YEAR' => $this_fiscal_year,
                'INT_ID_UNIT' => $this->input->post('INT_ID_UNIT'),
                'INT_ID_SECTION' => $section,
                'INT_ID_BUDGET_SUB_CATEGORY' => $subcategory,
                'INT_ID_PURPOSE' => $this->input->post('INT_ID_PURPOSE'),
                'BIT_FLG_OWNER' => $this->input->post('BIT_FLG_OWNER'),
                'BIT_FLG_NEW' => $this->input->post('BIT_FLG_NEW'),
                'BIT_FLG_CIP' => $this->input->post('BIT_FLG_CIP'),
                'BIT_FLG_LOCAL' => $this->input->post('BIT_FLG_LOCAL'),
                'INT_APPROVE0' => 0,
                'INT_APPROVE1' => 0,
                'INT_APPROVE2' => 0,
                'INT_APPROVE3' => 0,
                'INT_STATUS' => 0,
                'INT_MONTH_PLAN' => $this->input->post('INT_MONTH_PLAN'),
                'DEC_PRICE_PER_UNIT' => $this->input->post('DEC_PRICE_PER_UNIT'),
                'CHR_DEPCI_DATE' => $this->input->post('CHR_DEPCY2') . $this->input->post('CHR_DEPCY1'),
                'INT_QUANTITY' => $this->input->post('INT_QUANTITY'),
                'INT_REVISE' => 0,
                'CHR_CREATE_BY' => $session['USERNAME'],
                'CHR_CREATE_DATE' => date('Ymd'),
                'CHR_CREATE_TIME' => date('His'),
                'BIT_FLG_DEL' => 0
            );

            $this->capex_plan_temp_m->save($data);

            $data_detail = array(
                'INT_NO_BUDGET_CPX_TEMP' => $no_budget_temp,
                'INT_MONTH_PLAN' => $this->input->post('INT_MONTH_PLAN'),
                'DEC_PRICE_PER_UNIT' => $this->input->post('DEC_PRICE_PER_UNIT'),
                'CHR_DEPCI_DATE' => $this->input->post('CHR_DEPCY2') . $this->input->post('CHR_DEPCY1'),
                'INT_QUANTITY' => $this->input->post('INT_QUANTITY'),
                'INT_APPROVE1' => 0,
                'INT_APPROVE2' => 0,
                'INT_APPROVE3' => 0,
                'INT_REVISE' => 0
            );

            $this->budgetcapexdetail_m->save($data_detail);

            if ($project != NULL) {
                for ($i = 0; $i < count($project); $i++) {
                    $this->budgetproject_m->prepare_save($project[$i], $no_budget_temp, $session['USERNAME']);
                }
            }

            if ($product != NULL) {
                for ($i = 0; $i < count($product); $i++) {
                    $this->budgetproduct_m->prepare_save($product[$i], $no_budget_temp, $session['USERNAME']);
                }
            }


            redirect($this->back_to_manage . $msg = 1);
        }
    }

    function edit_budgetcapex($no_budget_temp) {
        $this->role_module_m->authorization('18');
        $this->load->model('budget/budgetcategory_m');
        $this->load->model('budget/budgetsubcategory_m');
        $this->load->model('budget/fiscal_m');
        $this->load->model('budget/purposebudget_m');
        $this->load->model('budget/project_m');
        $this->load->model('budget/product_m');
        $this->load->model('budget/unit_m');

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(18);
        $data['news'] = $this->news_m->get_news();

        $data_contain = $this->capex_plan_temp_m->get_data_capex_plan_temp($no_budget_temp)->row();

        $data['data_dept'] = $this->dept_m->get_dept();
        $data['data_section'] = $this->section_m->get_section_by_dept($data_contain->INT_ID_DEPT);
        $data['data_fiscal'] = $this->fiscal_m->get_fiscal();

        $data['data_budgetsubcategory'] = $this->budgetsubcategory_m->get_budgetsubcategory_by_budgetcategory($data_contain->INT_ID_BUDGET_CATEGORY);
        $data['data_budgetcategory'] = $this->budgetcategory_m->get_budgetcategory_capex();
        $data['data_purposebudget'] = $this->purposebudget_m->get_purposebudget();
        $data['data_project'] = $this->project_m->get_project();
        $data['data_product'] = $this->product_m->get_product();
        $data['data_unit'] = $this->unit_m->get_unit();
        $data['this_fiscal_year'] = $this->fiscal_m->get_id_fiscal_this_year();

        $data['title'] = 'Edit Budget Capex';
        $data['content'] = 'budget/budgetcapex/edit_budgetcapex_v';

        $data['data'] = $data_contain;

        $this->load->view($this->layout, $data);
    }

    function update_budgetcapex() {
        $no_budget_temp = $this->input->post('INT_NO_BUDGET_CPX_TEMP');
        $session = $this->session->all_userdata();

        $this->form_validation->set_rules('CHR_BUDGET_NAME', 'Budget name', 'required');

        if ($session['ROLE'] === 1 || $session['ROLE'] === 2) {
            $section = $this->input->post('INT_ID_SECTION');
            $this_fiscal_year = $this->input->post('INT_ID_FISCAL_YEAR');
        } else if ($session['ROLE'] === 6) {
            $section = $session['SECTION'];
            $this_fiscal_year = $data['this_fiscal_year'] = $this->fiscal_m->get_id_fiscal_this_year();
        }

        if ($this->form_validation->run() == FALSE) {
            $this->edit_budgetcapex($no_budget_temp);
        } else {
            $data = array(
                'INT_ID_FISCAL_YEAR' => $this_fiscal_year,
                'INT_ID_BUDGET_SUB_CATEGORY' => $this->input->post('INT_ID_BUDGET_SUB_CATEGORY'),
                'INT_ID_SECTION' => $section,
                'INT_ID_PURPOSE' => $this->input->post('INT_ID_PURPOSE'),
                'BIT_FLG_OWNER' => $this->input->post('BIT_FLG_OWNER'),
                'BIT_FLG_NEW' => $this->input->post('BIT_FLG_NEW'),
                'BIT_FLG_CIP' => $this->input->post('BIT_FLG_CIP'),
                'BIT_FLG_LOCAL' => $this->input->post('BIT_FLG_LOCAL'),
                'CHR_BUDGET_NAME' => $this->input->post('CHR_BUDGET_NAME'),
                'INT_ID_UNIT' => $this->input->post('INT_ID_UNIT'),
                'CHR_MODI_BY' => $session['USERNAME'],
                'CHR_MODI_DATE' => date('Ymd'),
                'CHR_MODI_TIME' => date('His'),
            );
            $this->capex_plan_temp_m->update($data, $no_budget_temp);

            redirect($this->back_to_manage . $msg = 2);
        }
    }

    function delete_budgetcapex($no_budget_temp) {
        $this->role_module_m->authorization('18');
        $this->capex_plan_temp_m->delete($no_budget_temp);
        redirect($this->back_to_manage . $msg = 3);
    }

    function reject_capex_plan_temp() {
        $checked = $this->input->post('casereject');

        if ($checked == null) {
            redirect($this->back_to_approve . $msg = 2);
        }

        for ($i = 0; $i < count($checked); $i++) {
            $this->budgetcapexdetail_m->reject($checked[$i]);
        }
        redirect($this->back_to_approve . $msg = 3);
    }

    function approve_capex_by_manager() {
        $id_fiscal = $this->input->post('INT_ID_FISCAL');
        $checked = $this->input->post('case');

        if ($checked == null) {
            redirect($this->back_to_approve . $msg = 2);
        }

        for ($i = 0; $i < count($checked); $i++) {
            $this->budgetcapexdetail_m->approve_by_manager($id_fiscal, $checked[$i]);
        }
        redirect($this->back_to_approve . $msg = 1);
    }

    function reject_capex_by_manager($id_section, $id_fiscal) {
        $this->budgetcapexdetail_m->reject_by_manager($id_fiscal, $id_section);
        redirect($this->back_to_approve . $msg = 3);
    }

    function approve_capex_by_gm() {
        $id_fiscal = $this->input->post('INT_ID_FISCAL');
        $checked = $this->input->post('case');

        if ($checked == null) {
            redirect($this->back_to_approve . $msg = 2);
        }

        for ($i = 0; $i < count($checked); $i++) {
            $this->budgetcapexdetail_m->approve_by_gm($id_fiscal, $checked[$i]);
        }
        redirect($this->back_to_approve . $msg = 1);
    }

    function reject_capex_by_gm($id_dept, $id_fiscal) {
        $this->budgetcapexdetail_m->reject_by_gm($id_fiscal, $id_dept);
        redirect($this->back_to_approve . $msg = 3);
    }

    function approve_capex_by_director() {
        $id_fiscal = $this->input->post('INT_ID_FISCAL');
        $checked = $this->input->post('case');

        if ($checked == null) {
            redirect($this->back_to_approve . $msg = 2);
        }

        for ($i = 0; $i < count($checked); $i++) {
            $this->budgetcapexdetail_m->approve_by_director($id_fiscal, $checked[$i]);
        }
        redirect($this->back_to_approve . $msg = 1);
    }

    function reject_capex_by_director($id_gm, $id_fiscal) {
        $this->budgetcapexdetail_m->reject_by_director($id_fiscal, $id_gm);
        redirect($this->back_to_approve . $msg = 3);
    }

    function recap_capex_plan_temp() {
        $this->budgetcapexdetail_m->recap_by_admin($this->input->post('INT_ID_FISCAL_YEAR'));
        redirect($this->back_to_approve . $msg = 1);
    }

    function commit_capex_plan_temp() {
        $this->budgetcapexdetail_m->commit_by_admin($this->input->post('INT_ID_FISCAL_YEAR'));
        redirect($this->back_to_manage . $msg = 4);
    }

}

?>
