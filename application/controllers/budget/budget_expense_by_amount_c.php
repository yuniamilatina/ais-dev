<?php

class budget_expense_by_amount_c extends CI_Controller {

    private $layout = '/template/head';
    private $layout_blank = '/template/head_blank';
    private $back_to_upload = 'budget/budget_expense_by_amount_c/create_expense/';
    private $back_to_manage = 'budget/budget_expense_by_amount_c/index/';

    public function __construct() {
        parent::__construct();
        $this->load->model('budget/dept_expense_m');
        $this->load->model('budget/budget_expense_by_amount_m');
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
    }

    //1
    function create_expense($msg = null, $INT_ID_FISCAL_YEAR = null, $INT_ID_BUDGET_SUB_GROUP = null, $INT_DIV = null, $INT_DEPT = null, $INT_SECT = null) {
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
        } elseif ($msg == 17) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Executing failed!</strong> File template upload not appropriate with budget type. Please Check your template</div >";
        } elseif ($msg == 18) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Executing failed!</strong> Please check column Category or Sub Category. Empty is not allowed</div >";
        }

        $data['INT_ID_FISCAL_YEAR'] = $INT_ID_FISCAL_YEAR;
        $data['INT_ID_BUDGET_SUB_GROUP'] = $INT_ID_BUDGET_SUB_GROUP;
        $data['INT_DIV'] = $INT_DIV;
        $data['INT_DEPT'] = $INT_DEPT;
        $data['INT_SECT'] = $INT_SECT;

//GET DETAIL BUDGET
        if ($INT_DEPT <> null) {
            $data['url_page'] = site_url("budget/budget_expense_by_amount_c/refresh_table_page/1/$INT_ID_FISCAL_YEAR/$INT_ID_BUDGET_SUB_GROUP/$INT_DIV/$INT_DEPT/$INT_SECT");
        } else {
            $data['url_page'] = "";
        }

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(205);
        $data['news'] = $this->news_m->get_news();
        $data['msg'] = $msg;

        $data['title'] = 'Create Budget Expense by Amount';

        $data['content'] = 'budget/budget_expense/create_budget_expense_by_amount_v';
        //$data['budget_type'] = $this->budgettype_m->get_budget_type_expense_by_amount();
        $kode_dept = $user_session['DEPT'];
        $data['kode_dept'] = $kode_dept;
        $data['role'] = $user_session['ROLE'];


        if (($user_session['ROLE'] != 1) and ( $user_session['ROLE'] != 2)) {
            $data['data_fiscal'] = $this->fiscal_m->get_all_fiscal();
            $data['dept'] = $this->dept_m->get_name_dept_arr($kode_dept);
            $data['section'] = $this->dept_m->get_name_section_budget($kode_dept);
            $data['subgroup'] = $this->budgetsubgroup_m->get_subgroup_exp_amount();
            $fiscal = $this->fiscal_m->get_id_fiscal_this_year();
            $this->load->view($this->layout, $data);
//            $commit = $this->budget_expense_m->get_commited_status($fiscal, $user_session['SECTION']);
//            if ($unbudget == null) {
//                if ($commit->COMMITED != 0) {
//                    $this->log_m->add_log(124, NULL);
//                    redirect('budget/budget_expense_by_amount_c');
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
//                redirect('budget/budget_expense_by_amount_c');
//            }
        } else {
            switch ($user_session['ROLE']) {
                case '1':
                    $data['data_fiscal'] = $this->fiscal_m->get_all_fiscal();
                    //$data['dept'] = $this->dept_m->get_name_dept_arr($kode_dept); //by user dept
                    $data['dept'] = $this->dept_m->get_dept(); //get all dept
                    $data['section'] = $this->dept_m->get_name_section_budget($kode_dept);
                    $data['subgroup'] = $this->budgetsubgroup_m->get_subgroup_exp_amount();
                    break;
                case '2':
                    $data['data_fiscal'] = $this->fiscal_m->get_all_fiscal();
                    //$data['dept'] = $this->dept_m->get_name_dept_arr($kode_dept); //by user dept
                    $data['dept'] = $this->dept_m->get_dept(); //get all dept
                    $data['section'] = $this->dept_m->get_name_section_budget($kode_dept);
                    $data['subgroup'] = $this->budgetsubgroup_m->get_subgroup_exp_amount();
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

    //2
    function gen_ddl_section() {
        $user_session = $this->session->all_userdata();

        $output = null;
        //if ($user_session['ROLE'] == 6 || $user_session['ROLE'] == 54 || $user_session['ROLE'] == 53 || $user_session['ROLE'] == 55 || $user_session['ROLE'] == 40 || $user_session['ROLE'] == 57 || $user_session['ROLE'] == 58 || $user_session['ROLE'] == 59 || $user_session['ROLE'] == 30 || $user_session['ROLE'] == 13 || $user_session['ROLE'] == 12 || $user_session['ROLE'] == 14) {
        if ($user_session['ROLE'] != 1 && $user_session['ROLE'] != 2 && $user_session['ROLE'] != 5 && $user_session['ROLE'] != 39 && $user_session['ROLE'] != 45) {
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
            $data['sect_data'] = $this->section_m->get_section_by_dept($id_dept);

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

    //=========================== NEW UPDATE 08/07/2017 ======================//

    function download_template($id_dept) {
        $this->load->helper('download');
        $kode_dept = $this->dept_m->get_name_dept($id_dept);
        $filename = 'Template_Expense_Amount_' . trim($kode_dept);

        ob_clean();
        $name = $filename . '.xls';
        $data = file_get_contents("assets/template/budget/template_amount/$filename.xls");

        force_download($name, $data);
    }

    function upload_budget_expense() {
        $this->load->helper(array('form', 'url', 'inflector'));
        $this->load->library(array('PHPExcel', 'PHPExcel/IOFactory'));
        $INT_ID_FISCAL_YEAR = $this->input->post("INT_ID_FISCAL_YEAR");
        $INT_ID_FISCAL_YEAR = substr($INT_ID_FISCAL_YEAR, 0, 4);
        $INT_DEPT = $this->input->post("INT_ID_DEPT");
        $kode_dept = $this->dept_m->get_name_dept($INT_DEPT); //get kode department
        $INT_SECT = $this->input->post("INT_ID_SECT");
        $INT_ID_BUDGET_SUB_GROUP = $this->input->post("INT_ID_BUDGET_SUB_GROUP");
        $get_gm_div = $this->dept_m->get_gm_div($INT_DEPT)->row();
        $INT_GROUP_DEPT = $get_gm_div->INT_ID_GROUP_DEPT;
        $INT_DIV = $get_gm_div->INT_ID_DIVISION;

        //delete existing template
        $this->budget_expense_by_amount_m->delete_existing_template($INT_ID_FISCAL_YEAR, $INT_DIV, $INT_DEPT, $INT_SECT);

        $upload_date = date('Ymd');
        $fileName = $_FILES['upload_budget_expense']['name'];

        if (empty($fileName)) {
            redirect($this->back_to_upload . $msg = 12);
        }

//file untuk submit file excel
        $config['upload_path'] = './assets/file/budget_expense/';
        $config['file_name'] = $fileName;
        $config['allowed_types'] = 'xls|xlsx';
        $config['max_size'] = 10000;

//code for upload with ci
        $this->load->library('upload');
        $this->upload->initialize($config);
        if ($a = $this->upload->do_upload('upload_budget_expense'))
            $this->upload->display_errors();
        $media = $this->upload->data('upload_budget_expense');
//cek apakah template sesuai dengan pilihan tipe budget?
        if (strpos($media['file_name'], trim($kode_dept)) === false) {
//jika template tidak sesuai dengan tipe budget
            redirect($this->back_to_upload . $msg = 16);
        }

        $inputFileName = './assets/file/budget_expense/' . $media['file_name'];

//Read  Excel workbook
        try {
            $inputFileType = IOFactory::identify($inputFileName);
            $objReader = IOFactory::createReader($inputFileType);
            $objPHPExcel = $objReader->load($inputFileName);
        } catch (Exception $e) {
            die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' . $e->getMessage());
        }

//Get worksheet dimensions
        $sheet = $objPHPExcel->getSheet(0);
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();
        $rowHeader = $sheet->rangeToArray('A1:CV1', NULL, TRUE, FALSE);
        $budget_amount_template = strtolower($rowHeader[0][99]);
        if ($budget_amount_template !== strtolower('EXPENSE AMOUNT')) {
            redirect($this->back_to_upload . $msg = 16);
        }

        for ($row = 3; $row <= $highestRow; $row++) {
            $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);
            if ($rowData[0][1] == '') {
                break;
            }
//===============================   common data   =============================== 
            $CHR_BUDGET_SUB_CATEGORY = $rowData[0][1];
            if ($CHR_BUDGET_SUB_CATEGORY == NULL || $CHR_BUDGET_SUB_CATEGORY == "") {
                redirect($this->back_to_upload . $msg = 18);
            }
            $CHR_BUDGET_SUB_CATEGORY_DESC = $rowData[0][2];
            $CHR_BUDGET_CATEGORY = $rowData[0][3];
            if ($CHR_BUDGET_CATEGORY == NULL || $CHR_BUDGET_CATEGORY == "") {
                redirect($this->back_to_upload . $msg = 18);
            }
            $CHR_BUDGET_CATEGORY_DESC = $rowData[0][4];
            $CHR_CODE_CATEGORY_A3 = $rowData[0][5];
            if ($CHR_CODE_CATEGORY_A3 == NULL || $CHR_CODE_CATEGORY_A3 == "") {
                redirect($this->back_to_upload . $msg = 18);
            }
            $CHR_CODE_CATEGORY_A3_DESC = $rowData[0][6];

            $budget_type = $this->budgetcategory_m->get_budgettype_by_code_category($CHR_BUDGET_CATEGORY);
            $CHR_BUDGET_TYPE = $budget_type->CHR_BUDGET_TYPE;
            $CHR_BUDGET_TYPE_DESC = $budget_type->CHR_BUDGET_TYPE_DESC;
//=============================== end common data =============================== 

            $MON_AMT_BLN04 = "0";
            $MON_AMT_BLN05 = "0";
            $MON_AMT_BLN06 = "0";
            $MON_AMT_BLN07 = "0";
            $MON_AMT_BLN08 = "0";
            $MON_AMT_BLN09 = "0";
            $MON_AMT_BLN10 = "0";
            $MON_AMT_BLN11 = "0";
            $MON_AMT_BLN12 = "0";
            $MON_AMT_BLN01 = "0";
            $MON_AMT_BLN02 = "0";
            $MON_AMT_BLN03 = "0";
//===  TOTAL AMOUNT
            $MON_AMT_SUM = "0";


//===============================   FOH/OPEX   =============================== 
            $MON_AMT_BLN04 = $rowData[0][7];
            $MON_AMT_BLN05 = $rowData[0][8];
            $MON_AMT_BLN06 = $rowData[0][9];
            $MON_AMT_BLN07 = $rowData[0][10];
            $MON_AMT_BLN08 = $rowData[0][11];
            $MON_AMT_BLN09 = $rowData[0][12];
            $MON_AMT_BLN10 = $rowData[0][13];
            $MON_AMT_BLN11 = $rowData[0][14];
            $MON_AMT_BLN12 = $rowData[0][15];
            $MON_AMT_BLN01 = $rowData[0][16];
            $MON_AMT_BLN02 = $rowData[0][17];
            $MON_AMT_BLN03 = $rowData[0][18];

            $MON_AMT_SUM = $MON_AMT_BLN04 + $MON_AMT_BLN05 + $MON_AMT_BLN06 + $MON_AMT_BLN07 + $MON_AMT_BLN08 + $MON_AMT_BLN09 + $MON_AMT_BLN10 + $MON_AMT_BLN11 + $MON_AMT_BLN12 + $MON_AMT_BLN01 + $MON_AMT_BLN02 + $MON_AMT_BLN03;
//=============================== END FOH/OPEX =============================== 
//ASSIGN TO ARRAY
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
                'INT_SECT' => $INT_SECT,
                'INT_DEPT' => $INT_DEPT,
                'INT_GROUP_DEPT' => $INT_GROUP_DEPT,
                'INT_DIV' => $INT_DIV,
                'MON_AMT_SUM' => $MON_AMT_SUM,
            );
//SAVE TO DATABASE
            $this->budget_expense_by_amount_m->save_temp($data);
        }
        redirect("budget/budget_expense_by_amount_c/confirmation_budget_expense/$INT_ID_FISCAL_YEAR/$INT_ID_BUDGET_SUB_GROUP/$INT_DIV/$INT_DEPT/$INT_SECT", "REFRESH");
    }

    function confirmation_budget_expense($INT_ID_FISCAL_YEAR, $INT_ID_BUDGET_SUB_GROUP, $INT_DIV, $INT_DEPT, $INT_SECT) {
        $user_session = $this->session->all_userdata();

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(205);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Confirmation Budget Expense by Amount';
        $data['subcontent'] = NULL;
        $data['content'] = 'budget/budget_expense/confirmation_budget_expense_amount_v';

        $data['INT_ID_FISCAL_YEAR'] = $INT_ID_FISCAL_YEAR;
        $data['INT_ID_BUDGET_SUB_GROUP'] = $INT_ID_BUDGET_SUB_GROUP;
        $data['INT_DIV'] = $INT_DIV;
        $data['INT_DEPT'] = $INT_DEPT;
        $data['INT_SECT'] = $INT_SECT;

//GET FISCAL YEAR
        $data['CHR_FISCAL_YEAR'] = $this->fiscal_m->select_fiscal_year($INT_ID_FISCAL_YEAR);
//GET DEPT
        $data['CHR_DEPT_DESC'] = $this->dept_m->get_name_dept($INT_DEPT);
//GET SECTION 
        $data['CHR_SECTION_DESC'] = $this->section_m->get_desc_section($INT_SECT);
//GET DETAIL BUDGET
        $data['detail_confirm'] = $this->budget_expense_by_amount_m->get_detail_confirm_expense($INT_ID_FISCAL_YEAR, $INT_DIV, $INT_DEPT, $INT_SECT);
        $data['detail_confirm_sum'] = $this->budget_expense_by_amount_m->get_sum_confirm_expense($INT_ID_FISCAL_YEAR, $INT_DIV, $INT_DEPT, $INT_SECT);
//GET SUM AMOUNT
        $data['SUM_AMT'] = $this->budget_expense_by_amount_m->get_sum_amt_confirm_expense($INT_ID_FISCAL_YEAR, $INT_DIV, $INT_DEPT, $INT_SECT);

        $this->load->view($this->layout, $data);
    }

    function save_budget($INT_ID_FISCAL_YEAR, $INT_ID_BUDGET_SUB_GROUP, $INT_DIV, $INT_DEPT, $INT_SECT, $CHR_STAT_REV) {
        $user_session = $this->session->all_userdata();
        $CHR_CREATE_BY = $user_session['USERNAME'];
        $CHR_CREATE_DATE = date("Ymd");
        $CHR_CREATE_TIME = date("his");

//DELETE BUDGET TYPE FOR FISCAL YEAR 
        $this->budget_expense_by_amount_m->delete_existing_budget($INT_ID_FISCAL_YEAR, $INT_DIV, $INT_DEPT, $INT_SECT, $CHR_STAT_REV);

//CHECK SEQUNCE BUDGET NUMBER
//GET BUDGET NUMBER
//SAVE DATA FROM TABLE WORK TO TABLE TRANSACTION
        $detail_budget = $this->budget_expense_by_amount_m->get_detail_confirm_expense($INT_ID_FISCAL_YEAR, $INT_DIV, $INT_DEPT, $INT_SECT);
//ASSIGN TO ARRAY
        foreach ($detail_budget as $value) {
            $CHR_BUDGET_TYPE = $value->CHR_BUDGET_TYPE;
            $CHR_BUDGET_TYPE_DESC = $value->CHR_BUDGET_TYPE;
            $CHR_NO_BUDGET = $this->budget_expense_by_amount_m->get_no_budget($INT_ID_FISCAL_YEAR, $INT_DIV, $INT_DEPT, $INT_SECT, $CHR_BUDGET_TYPE, $CHR_STAT_REV);
            $data = array(
                'CHR_NO_BUDGET' => $CHR_NO_BUDGET,
                'CHR_STAT_REV' => $CHR_STAT_REV,
                'CHR_CREATE_BY' => $CHR_CREATE_BY,
                'CHR_CREATE_DATE' => $CHR_CREATE_DATE,
                'CHR_CREATE_TIME' => $CHR_CREATE_TIME,
                'INT_ID_FISCAL_YEAR' => $value->INT_ID_FISCAL_YEAR,
                'CHR_BUDGET_TYPE' => $CHR_BUDGET_TYPE,
                'CHR_BUDGET_TYPE_DESC' => $CHR_BUDGET_TYPE_DESC,
                'CHR_BUDGET_SUB_CATEGORY' => $value->CHR_BUDGET_SUB_CATEGORY,
                'CHR_BUDGET_SUB_CATEGORY_DESC' => $value->CHR_BUDGET_SUB_CATEGORY_DESC,
                'CHR_BUDGET_CATEGORY' => $value->CHR_BUDGET_CATEGORY,
                'CHR_BUDGET_CATEGORY_DESC' => $value->CHR_BUDGET_CATEGORY_DESC,
                'CHR_CODE_CATEGORY_A3' => $value->CHR_CODE_CATEGORY_A3,
                'CHR_CODE_CATEGORY_A3_DESC' => $value->CHR_CODE_CATEGORY_A3_DESC,
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
                'INT_SECT' => $value->INT_SECT,
                'INT_DEPT' => $value->INT_DEPT,
                'INT_GROUP_DEPT' => $value->INT_GROUP_DEPT,
                'INT_DIV' => $value->INT_DIV,
            );
            $this->budget_expense_by_amount_m->save($data);
        }

//GET DETAIL BUDGET
        $data['detail_confirm'] = $this->budget_expense_by_amount_m->get_detail_confirm_expense($INT_ID_FISCAL_YEAR, $CHR_BUDGET_TYPE, $INT_DIV, $INT_DEPT, $INT_SECT);
//GET SUM AMOUNT
        $data['SUM_AMT'] = $this->budget_expense_by_amount_m->get_sum_amt_confirm_expense($INT_ID_FISCAL_YEAR, $CHR_BUDGET_TYPE, $INT_DIV, $INT_DEPT, $INT_SECT);

        redirect("budget/budget_expense_by_amount_c/create_expense/1/$INT_ID_FISCAL_YEAR/$INT_ID_BUDGET_SUB_GROUP/$INT_DIV/$INT_DEPT/$INT_SECT");
        $this->load->view($this->layout, $data);
    }

    function refresh_table() {

        $INT_ID_FISCAL_YEAR = $this->input->post("INT_ID_FISCAL_YEAR");
        $INT_ID_BUDGET_SUB_GROUP = $this->input->post("INT_ID_BUDGET_SUB_GROUP");
        $INT_DEPT = $this->input->post("INT_DEPT");
        $INT_SECT = $this->input->post("INT_SECT");
        $get_gm_div = $this->dept_m->get_gm_div($INT_DEPT)->row();
        $INT_DIV = $get_gm_div->INT_ID_DIVISION;
        $url_iframe = site_url("budget/budget_expense_by_amount_c/refresh_table_page/1/$INT_ID_FISCAL_YEAR/$INT_ID_BUDGET_SUB_GROUP/$INT_DIV/$INT_DEPT/$INT_SECT");
        $url_export_excel = site_url("budget/budget_expense_by_amount_c/download_excel/$INT_ID_FISCAL_YEAR/$INT_ID_BUDGET_SUB_GROUP/$INT_DIV/$INT_DEPT/$INT_SECT");

        $status_approve_gm = $this->budget_expense_by_amount_m->get_status_approve_gm($INT_ID_FISCAL_YEAR, $INT_DIV, $INT_DEPT);

        $data = array(
            'url_iframe' => $url_iframe,
            'url_export_excel' => $url_export_excel,
            'status_approve' => $status_approve_gm->CHR_FLAG_APP_GM
        );

//Either you can print value or you can send value to database
        echo json_encode($data);

        //echo site_url("budget/budget_expense_by_amount_c/refresh_table_page/1/$INT_ID_FISCAL_YEAR/$INT_BUDGET_TYPE/$INT_DIV/$INT_DEPT/$INT_SECT/$CHR_BUDGET_TYPE");
    }

    function refresh_table_page($msg = null, $INT_ID_FISCAL_YEAR = null, $INT_ID_BUDGET_SUB_GROUP = null, $INT_DIV = null, $INT_DEPT = null, $INT_SECT = null) {
        $user_session = $this->session->all_userdata();
        $role = $user_session['ROLE'];

        $data['INT_ID_FISCAL_YEAR'] = $INT_ID_FISCAL_YEAR;
        $data['INT_ID_BUDGET_SUB_GROUP'] = $INT_ID_BUDGET_SUB_GROUP;
        $data['INT_DIV'] = $INT_DIV;
        $data['INT_DEPT'] = $INT_DEPT;
        $data['INT_SECT'] = $INT_SECT;

//GET DETAIL BUDGET
        if ($INT_ID_FISCAL_YEAR <> null) {
//            if($role == 2 && $INT_DIV == 3){
//                $data['detail_confirm'] = $this->budget_expense_by_amount_m->get_detail_expense_cpl($INT_ID_FISCAL_YEAR, $INT_DIV, $INT_DEPT, $INT_SECT);
//                $data['detail_confirm_sum'] = $this->budget_expense_by_amount_m->get_sum_expense_cpl($INT_ID_FISCAL_YEAR, $INT_DIV, $INT_DEPT, $INT_SECT);
//            } else {
                $data['detail_confirm'] = $this->budget_expense_by_amount_m->get_detail_expense($INT_ID_FISCAL_YEAR, $INT_DIV, $INT_DEPT, $INT_SECT);
                $data['detail_confirm_sum'] = $this->budget_expense_by_amount_m->get_sum_expense($INT_ID_FISCAL_YEAR, $INT_DIV, $INT_DEPT, $INT_SECT);
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

        $data['title'] = 'Create Budget Expense by Amount';

        $data['content'] = 'budget/budget_expense/refresh_budget_expense_by_amount_v';

        $data['subgroup'] = $this->budgetsubgroup_m->get_subgroup_exp_amount();
        $kode_dept = $user_session['DEPT'];
        $data['kode_dept'] = $kode_dept;

        $data['data_budget_type'] = $this->budgettype_m->get_budgettype();
        $this->load->view($this->layout_blank, $data);
    }

    function download_excel($INT_ID_FISCAL_YEAR = null, $INT_ID_BUDGET_SUB_GROUP = null, $INT_DIV = null, $INT_DEPT = null, $INT_SECT = null) {
        $user_session = $this->session->all_userdata();
        $role = $user_session['ROLE'];
        $row = 8;

        if ($INT_ID_FISCAL_YEAR <> null) {
//            if($role == 2 && $INT_DIV == 3){
//                $detail_confirm = $this->budget_expense_by_amount_m->get_detail_expense_dept_cpl($INT_ID_FISCAL_YEAR, $INT_DIV, $INT_DEPT, $INT_SECT);
//                $detail_confirm_sum = $this->budget_expense_by_amount_m->get_sum_expense_dept_cpl($INT_ID_FISCAL_YEAR, $INT_DIV, $INT_DEPT, $INT_SECT);
//            } else {
                if($role != 1 && $role != 2 && $role != 3 && $role != 4 && $role != 5 && $role != 39 && $role != 45){
                    $detail_confirm = $this->budget_expense_by_amount_m->get_detail_expense($INT_ID_FISCAL_YEAR, $INT_DIV, $INT_DEPT, $INT_SECT);
                    $detail_confirm_sum = $this->budget_expense_by_amount_m->get_sum_expense($INT_ID_FISCAL_YEAR, $INT_DIV, $INT_DEPT, $INT_SECT);
                } else {
                    $detail_confirm = $this->budget_expense_by_amount_m->get_detail_expense_dept($INT_ID_FISCAL_YEAR, $INT_DIV, $INT_DEPT, $INT_SECT);
                    $detail_confirm_sum = $this->budget_expense_by_amount_m->get_sum_expense_dept($INT_ID_FISCAL_YEAR, $INT_DIV, $INT_DEPT, $INT_SECT);
                }
                
//            }            

            $CHR_DEPT = trim($this->dept_m->get_name_dept($INT_DEPT));
            $CHR_DEPT_DESC = trim($this->dept_m->get_desc_dept($INT_DEPT));
            $CHR_FISCAL_YEAR_DESC = trim($this->fiscal_m->select_fiscal_year($INT_ID_FISCAL_YEAR));
            $CHR_BUDGET_SUB_GROUP = trim($this->budgetsubgroup_m->get_desc_budgetsubgroup($INT_ID_BUDGET_SUB_GROUP));

            $this->load->library('excel');
            $objReader = PHPExcel_IOFactory::createReader('Excel5');
            // Create new PHPExcel object

            $objPHPExcel = $objReader->load("assets/template/budget/report/Template_Report_Exp_Amount.xls");

            $seq = 1;
            $objPHPExcel->getActiveSheet()->setCellValue("B2", "MASTER BUDGET : " . $CHR_BUDGET_SUB_GROUP . " TAHUN " . $CHR_FISCAL_YEAR_DESC);
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
                $objPHPExcel->getActiveSheet()->setCellValue("D$row", "$CHR_SECTION_DESC");
                $objPHPExcel->getActiveSheet()->setCellValue("E$row", "$CHR_BUDGET_SUB_CATEGORY_DESC");
                $objPHPExcel->getActiveSheet()->setCellValue("F$row", "$CHR_BUDGET_CATEGORY_DESC");
                $objPHPExcel->getActiveSheet()->setCellValue("G$row", "$CHR_CODE_CATEGORY_A3_DESC");
                $objPHPExcel->getActiveSheet()->setCellValue("H$row", "$MON_AMT_BLN04");
                $objPHPExcel->getActiveSheet()->setCellValue("I$row", "$MON_AMT_BLN05");
                $objPHPExcel->getActiveSheet()->setCellValue("J$row", "$MON_AMT_BLN06");
                $objPHPExcel->getActiveSheet()->setCellValue("K$row", "$MON_AMT_BLN07");
                $objPHPExcel->getActiveSheet()->setCellValue("L$row", "$MON_AMT_BLN08");
                $objPHPExcel->getActiveSheet()->setCellValue("M$row", "$MON_AMT_BLN09");
                $objPHPExcel->getActiveSheet()->setCellValue("N$row", "$MON_AMT_BLN10");
                $objPHPExcel->getActiveSheet()->setCellValue("O$row", "$MON_AMT_BLN11");
                $objPHPExcel->getActiveSheet()->setCellValue("P$row", "$MON_AMT_BLN12");
                $objPHPExcel->getActiveSheet()->setCellValue("Q$row", "$MON_AMT_BLN01");
                $objPHPExcel->getActiveSheet()->setCellValue("R$row", "$MON_AMT_BLN02");
                $objPHPExcel->getActiveSheet()->setCellValue("S$row", "$MON_AMT_BLN03");
                $objPHPExcel->getActiveSheet()->setCellValue("T$row", "$MON_AMT_SUM");

                $seq++;
                $row++;
            }

            $objPHPExcel->getActiveSheet()->getStyle("B8:T$row")->applyFromArray(array(
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                )
            ));

            $row++;
            $row_min = $row - 1;
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
            $objPHPExcel->getActiveSheet()->setCellValue("S$row", "=SUM(S8:S$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("T$row", "=SUM(T8:T$row_min)");
            $objPHPExcel->getActiveSheet()->getStyle("B8:T$row")->applyFromArray(array(
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                ),
            ));
            $objPHPExcel->getActiveSheet()->mergeCells("B$row:G$row");
            $objPHPExcel->getActiveSheet()->setCellValue("B$row", "TOTAL");
            $objPHPExcel->getActiveSheet()->getStyle("B$row:T$row")->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('#CCCCCC');
            $objPHPExcel->getActiveSheet()->getStyle("B$row:T$row")->applyFromArray(array(
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
            $filename = "$CHR_FISCAL_YEAR_DESC - $CHR_BUDGET_SUB_GROUP - $CHR_DEPT.xls";
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