<?php

class budget_expense_c extends CI_Controller {

    private $layout = '/template/head';

    public function __construct() {
        parent::__construct();
        $this->load->model('budget/dept_expense_m');
        $this->load->model('budget/budget_expense_m');
        $this->load->model('basis/log_m');
        $this->load->model('basis/user_m');
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
        $this->load->model('basis/role_module_m');
        $this->load->model('portal/news_m');
    }

    function index($msg = NULL) {
        $this->role_module_m->authorization('19');
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

    function prepare_approve_expense($msg = null) {
        $this->role_module_m->authorization('43');
        if ($msg == 5) {
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
        }

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(43);
        $data['news'] = $this->news_m->get_news();

        $data['title'] = 'Manage Budget Planning Expense';
        $data['msg'] = $msg;

        $session = $this->session->all_userdata();
        $fiscal = $this->fiscal_m->get_id_fiscal_this_year();
        $user_session = $this->session->all_userdata();
        $user = $this->user_m->get_user_org($user_session['NPK']);

        switch ($session['ROLE']) {
            case '1':
                echo $fiscal;
                echo $user->INT_ID_COMPANY;
                exit();
                $data['header'] = $this->budget_expense_m->get_all_budget_expense_header($fiscal, $user->INT_ID_COMPANY);
                $data['commit'] = $this->budget_expense_m->get_commited_status($fiscal, $user->INT_ID_COMPANY);
                $data['data'] = $this->budget_expense_m->get_all_budget_expense($fiscal, $user->INT_ID_COMPANY);
                $data['data_status'] = $this->budget_expense_m->get_data_status_org($fiscal, $user->INT_ID_COMPANY);
                $data['org'] = $user;
                $data['content'] = 'budget/budget_expense/manage_budget_expense_by_admin_v';
            case '2':
                $data['header'] = $this->budget_expense_m->get_all_budget_expense_header($fiscal, $user->INT_ID_COMPANY);
                $data['commit'] = $this->budget_expense_m->get_commited_status($fiscal, $user->INT_ID_COMPANY);
                $data['data'] = $this->budget_expense_m->get_all_budget_expense($fiscal, $user->INT_ID_COMPANY);
                $data['data_status'] = $this->budget_expense_m->get_data_status_org($fiscal, $user->INT_ID_COMPANY);
                $data['org'] = $user;
                $data['content'] = 'budget/budget_expense/manage_budget_expense_by_admin_v';
                break;
            case '3':
                $data['commit'] = $this->budget_expense_m->get_commited_status($fiscal, $user->INT_ID_DIVISION);
                $data['header'] = $this->budget_expense_m->get_all_budget_expense_header($fiscal, $user->INT_ID_DIVISION);
                $data['data'] = $this->budget_expense_m->get_all_budget_expense($fiscal, $user->INT_ID_DIVISION);
                $data['data_status'] = $this->budget_expense_m->get_data_status_org($fiscal, $user->INT_ID_DIVISION);
                $data['org'] = $user;
                $data['content'] = 'budget/budget_expense/manage_budget_expense_by_div_v';
                break;
            case '4':
                $data['commit'] = $this->budget_expense_m->get_commited_status($fiscal, $user->INT_ID_GROUP_DEPT);
                $data['header'] = $this->budget_expense_m->get_all_budget_expense_header($fiscal, $user->INT_ID_GROUP_DEPT);
                $data['data'] = $this->budget_expense_m->get_all_budget_expense($fiscal, $user->INT_ID_GROUP_DEPT);
                $data['data_status'] = $this->budget_expense_m->get_data_status_org($fiscal, $user->INT_ID_GROUP_DEPT);
                $data['org'] = $user;
                $data['content'] = 'budget/budget_expense/manage_budget_expense_by_group_dept_v';
                break;
            case '5':
                $data['commit'] = $this->budget_expense_m->get_commited_status($fiscal, $user->INT_ID_DEPT);
                $data['header'] = $this->budget_expense_m->get_all_budget_expense_header($fiscal, $user->INT_ID_DEPT);
                $data['data'] = $this->budget_expense_m->get_all_budget_expense($fiscal, $user->INT_ID_DEPT);
                $data['data_status'] = $this->budget_expense_m->get_data_status_org($fiscal, $user->INT_ID_DEPT);
                $data['org'] = $user;
                $data['content'] = 'budget/budget_expense/manage_budget_expense_by_dept_v';
                break;
            default:
                break;
        }
        $this->load->view($this->layout, $data);
    }

    function create_expense($unbudget = NULL) {

        $this->role_module_m->authorization('19');

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(19);
        $data['news'] = $this->news_m->get_news();

        $data['unbudget'] = $unbudget;
        $data['title'] = 'Create Budget Expense';

        $data['subcontent'] = NULL;
        $data['content'] = 'budget/budget_expense/create_budget_expense_v';

        $user_session = $this->session->all_userdata();
        if (($user_session['ROLE'] != 1) and ($user_session['ROLE'] != 2)) {
            $fiscal = $this->fiscal_m->get_id_fiscal_this_year();
            $commit = $this->budget_expense_m->get_commited_status($fiscal, $user_session['SECTION']);
            if ($unbudget == null) {
                if ($commit->COMMITED != 0) {
                    $this->log_m->add_log(124, NULL);
                    redirect('budget/budget_expense_c');
                } elseif ($commit->COMMITED == 0) {

                    switch ($user_session['ROLE']) {
                        case '6':
                            $data['organization'] = $this->section_m->get_user_section($user_session['NPK']);
                            $data['data_fiscal'] = $this->fiscal_m->get_fiscal_this_year();
                            $data['subgroup'] = $this->budgetsubgroup_m->get_exp_subgroup();
                            break;

                        default:
                            $this->log_m->add_log(124, NULL);
                            redirect('fail_c/auth');
                            break;
                    }
                    $this->load->view($this->layout, $data);
                }
            } elseif ($unbudget == 'u') {
                if ($this->budget_expense_m->get_unbudget_status($fiscal, $user_session['SECTION']) == 0) {
                    $this->log_m->add_log(125, NULL);
                    $this->index('14');
                } else {

                    switch ($user_session['ROLE']) {
                        case '6':
                            $data['organization'] = $this->section_m->get_user_section($user_session['NPK']);
                            $data['data_fiscal'] = $this->fiscal_m->get_fiscal_this_year();
                            $data['subgroup'] = $this->budgetsubgroup_m->get_exp_subgroup();
                            break;

                        default:
                            $this->log_m->add_log(124, NULL);
                            redirect('fail_c/auth');
                            break;
                    }

                    $this->load->view($this->layout, $data);
                }
            } else {
                $this->log_m->add_log(124, NULL);
                redirect('budget/budget_expense_c');
            }
        } else {
            switch ($user_session['ROLE']) {

                case '1':
                    $data['data_fiscal'] = $this->fiscal_m->get_all_fiscal();
                    $data['dept'] = $this->dept_m->get_dept();
                    $data['subgroup'] = $this->budgetsubgroup_m->get_exp_subgroup();
                    break;
                case '2':
                    $data['data_fiscal'] = $this->fiscal_m->get_all_fiscal();
                    $data['dept'] = $this->dept_m->get_dept();
                    $data['subgroup'] = $this->budgetsubgroup_m->get_exp_subgroup();
                    break;
                default:
                    $this->log_m->add_log(124, NULL);
                    redirect('fail_c/auth');
                    break;
            }
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

    function gen_ddl_section() {
        $id_dept = $this->input->post('INT_ID_DEPT', true);
        $data['sect_data'] = $this->section_m->get_section_by_dept($id_dept);
        $output = null;
        if ($data['sect_data'] != NULL) {
            foreach ($data['sect_data'] as $row) {
                $output .= "<option value='" . $row->INT_ID_SECTION . "'>" . $row->CHR_SECTION . ' / ' . $row->CHR_SECTION_DESC . "</option>";
            }
        } else {
            echo '<option value="">!! Missing Link, Contact the administrator !!</option>';
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
                //pure exp
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
                    if (($money[$i] != NULL) or ($money[$i] != 0)) {
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
                //sub exp
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
                    if (($money[$i] != NULL) or ($money[$i] != 0)) {
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
            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Deleting success. </strong> The expense detail data was successfully deleted. </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Creating failed. </strong> Make sure not to create detail on the other detail's month. </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Creating success. </strong> The data is successfully created. </div >";
        } elseif ($msg == 4) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Updating success. </strong> The data is successfully saved. </div >";
        } elseif ($msg == 5) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Restore success. </strong> The expense detail data was successfully restored. </div >";
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

    function getNPK() {
        $get_npk = $this->db->query("select distinct no_delivery from  Z_CEK_SJ_OLD")->result();
        foreach ($get_npk as $value) {
            $pack = $value->no_delivery;
            $get_npk_details = $this->db->query("select no_sj from Z_CEK_SJ_OLD  where no_delivery = '$pack'")->row();
            $npk = $get_npk_details->no_sj;
            $this->db->query("update TT_PACKING_UPLOAD set CHR_NPK = '$npk' where CHR_IDPACKING = '$pack'");
        }
    }

}

?>