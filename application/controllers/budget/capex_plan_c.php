
<?php

class capex_plan_c extends CI_Controller {

    private $layout = '/template/head';
    private $back_to_manage = 'budget/capex_plan_c/index/';
    private $back_to_approve = 'budget/capex_plan_c/prepare_approve_capex/';

    public function __construct() {
        parent::__construct();
        $this->load->model('budget/capex_plan_m');
        $this->load->model('budget/fiscal_m');
        $this->load->model('organization/division_m');
        $this->load->model('organization/groupdept_m');
        $this->load->model('organization/dept_m');
        $this->load->model('organization/section_m');
        $this->load->model('budget/budgetgroup_m');
        $this->load->model('budget/budgetsubgroup_m');
        $this->load->model('budget/budgettype_m');
        $this->load->model('budget/budgetcategory_m');
        $this->load->model('budget/budgetsubcategory_m');
    }

    function index($msg = NULL) {
        $this->role_module_m->authorization('29');
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

        $new_fiscal = $this->fiscal_m->select_id_fiscal_year();

        $session = $this->session->all_userdata();
        if ($session['ROLE'] === 2 || $session['ROLE'] === 1) {
            $data_contain = $this->capex_plan_m->get_capex_plan_by_admin($new_fiscal);
            $contain = 'budget/budgetcapex/print_report_by_supervisor_v';
        } else if ($session['ROLE'] === 5) {
            $data_contain = $this->capex_plan_m->get_capex_plan_by_manager($session['DEPT'], $new_fiscal);
            $contain = 'budget/budgetcapex/print_report_by_manager_v';
            $group = $this->dept_m->get_name_dept($session['DEPT']);
            $data['group'] = $group;
        } else if ($session['ROLE'] === 6) {
            $data_contain = $this->capex_plan_m->get_capex_plan_by_section($session['SECTION'], $new_fiscal);
            $contain = 'budget/budgetcapex/print_report_by_supervisor_v';
            $group = $this->section_m->get_name_section($session['SECTION']);
            $data['group'] = $group;
        }

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(29);
        $data['news'] = $this->news_m->get_news();

        $data['data_fiscal'] = $this->fiscal_m->get_fiscal();
        $data['fiscal'] = $this->fiscal_m->select_fiscal_year($new_fiscal);

        $data['new_fiscal'] = $new_fiscal;
        $data['msg'] = $msg;
        $data['data'] = $data_contain;
        $data['content'] = $contain;
        $data['title'] = 'Manage Budget Planning';

        $this->load->view($this->layout, $data);
    }

    function search_budgetcapex() {
        $this->role_module_m->authorization('29');

        $fiscal = $this->input->post('INT_ID_FISCAL_YEAR');

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['news'] = $this->news_m->get_news();

        $data['sidebar'] = $this->role_module_m->side_bar(29);

        $session = $this->session->all_userdata();
        if ($session['ROLE'] === 2 || $session['ROLE'] === 1) {
            $data_contain = $this->capex_plan_m->get_capex_plan_by_admin($fiscal);
            $contain = 'budget/budgetcapex/print_report_by_supervisor_v';
        } else if ($session['ROLE'] === 5) {
            $data_contain = $this->capex_plan_m->get_capex_plan_by_manager($session['DEPT'], $fiscal);
            $contain = 'budget/budgetcapex/print_report_by_manager_v';
            $dept = $this->dept_m->get_name_dept($session['DEPT']);
            $data['group'] = $dept;
        } else if ($session['ROLE'] === 6) {
            $data_contain = $this->capex_plan_m->get_capex_plan_by_section($session['SECTION'], $fiscal);
            $contain = 'budget/budgetcapex/print_report_by_supervisor_v';
            $section = $this->section_m->get_name_section($session['SECTION']);
            $data['group'] = $section;
        }
        $data['data_fiscal'] = $this->fiscal_m->get_fiscal();
        $data['new_fiscal'] = $fiscal;
        $data['fiscal'] = $this->fiscal_m->select_fiscal_year($fiscal);
        $data['msg'] = null;

        $data['data'] = $data_contain;
        $data['content'] = $contain;
        $data['title'] = 'Capex Budget';

        $this->load->view($this->layout, $data);
    }

//
//    function select_by_gm($groupdept, $fiscal) {
//        $this->role_module_m->authorization('29');
//        $data['app'] = $this->role_module_m->get_app();
//        $data['module'] = $this->role_module_m->get_module();
//        $data['function'] = $this->role_module_m->get_function();
//        $data['sidebar'] = $this->role_module_m->side_bar(29);
//
//        $data_contain = $this->capex_plan_m->select_budgetcapex_by_groupdept($groupdept, $fiscal);
//        $contain = 'budget/budgetcapex/list_dept_by_gm_v';
//
//        $data['group'] = $this->groupdept_m->get_name_groupdept($groupdept);
//        $data['fiscal'] = $this->fiscal_m->select_fiscal_year($fiscal);
//        $data['msg'] = null;
//
//        $data['data_fiscal'] = $this->fiscal_m->get_fiscal();
//        $data['title'] = 'Manage Budget Planning';
//        $data['data'] = $data_contain;
//        $data['content'] = $contain;
//
//        $this->load->view($this->layout, $data);
//    }
//
//    function select_by_dept($dept, $fiscal) {
//        $this->role_module_m->authorization('29');
//        $data['app'] = $this->role_module_m->get_app();
//        $data['module'] = $this->role_module_m->get_module();
//        $data['function'] = $this->role_module_m->get_function();
//        $data['sidebar'] = $this->role_module_m->side_bar(29);
//
//        $data_contain = $this->capex_plan_m->select_budgetcapex_by_dept($dept, $fiscal);
//        $contain = 'budget/budgetcapex/list_section_by_dept_v';
//
//        $session = $this->session->all_userdata();
//        if ($session['ROLE'] === 4) {
//            $dept = $session['DEPT'];
//        }
//
//        $data['group'] = $this->dept_m->get_name_dept($dept);
//        $data['fiscal'] = $this->fiscal_m->select_fiscal_year($fiscal);
//        $data['id_dept'] = $dept;
//        $data['id_fiscal'] = $fiscal;
//        $data['msg'] = null;
//
//        $data['data_fiscal'] = $this->fiscal_m->get_fiscal();
//        $data['title'] = 'Manage Budget Planning';
//        $data['data'] = $data_contain;
//        $data['content'] = $contain;
//
//        $this->load->view($this->layout, $data);
//    }

    function select_by_section($section, $fiscal) {
        $this->role_module_m->authorization('29');
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(29);
        $data['news'] = $this->news_m->get_news();


        $data['group'] = $this->section_m->get_name_section($section);
        $data['fiscal'] = $this->fiscal_m->select_fiscal_year($fiscal);

        $data_contain = $this->capex_plan_m->select_budgetcapex_by_section($section, $fiscal);
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

    function view_detail_capex($no_budget, $msg = null) {
        $this->role_module_m->authorization('29');
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

//        $session = $this->session->all_userdata();
//        if ($session['ROLE'] === 6) {
//            $contain = 'budget/budgetcapex/view_budgetcapex_by_section_v';
//        } else if ($session['ROLE'] === 5 || $session['ROLE'] === 4 || $session['ROLE'] === 3) {
//            $contain = 'budget/budgetcapex/view_budgetcapex_by_section_v';
//        } else if ($session['ROLE'] === 1 || $session['ROLE'] === 2) {
//            $contain = 'budget/budgetcapex/view_budgetcapex_by_admin_v';
//        }

        $data['data_project'] = $this->budgetproject_m->get_data_project_close($no_budget);
        $data['data_product'] = $this->budgetproduct_m->get_data_product_close($no_budget);

//        $data['data_project_new'] = $this->budgetproject_m->get_current_data_project($no_budget);
//        $data['data_product_new'] = $this->budgetproduct_m->get_current_data_product($no_budget);
        //$data['data_cost_center'] = $this->costcenter_m->get_costcenter();
        $data['data_fiscal'] = $this->fiscal_m->get_fiscal();
        $data['data_budgetsubcategory'] = $this->budgetsubcategory_m->get_budgetsubcategory();
        $data['data_purposebudget'] = $this->purposebudget_m->get_purposebudget();

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(29);
        $data['news'] = $this->news_m->get_news();
        $data['msg'] = $msg;

        $data['data'] = $this->capex_plan_m->get_data_capex($no_budget)->row();
        $data['content'] = 'budget/budgetcapex/view_bc_close_v';
        $data['title'] = 'Confirm Budget Capex';

        $this->load->view($this->layout, $data);
    }

//    function select_by_id($no_budget, $msg = null) {
//        $this->role_module_m->authorization('29');
//        if ($msg == 1) {
//            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Creating success </strong> The data is successfully created </div >";
//        } elseif ($msg == 2) {
//            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Updating success </strong> The data is successfully updated </div >";
//        } elseif ($msg == 3) {
//            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Deleted success </strong> The data is successfully deleted </div >";
//        } elseif ($msg == 5) {
//            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Adding failed ! </strong> The data cannot empty </div >";
//        } elseif ($msg == 12) {
//            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Executing error !</strong> Something error with parameter </div >";
//        } else {
//            $msg = "";
//        }
//
//        $this->load->model('budget/budgetproject_m');
//        $this->load->model('budget/budgetproduct_m');
//        $this->load->model('budget/budgetcapexdetail_m');
//        $this->load->model('budget/project_m');
//        $this->load->model('budget/product_m');
//        $this->load->model('budget/costcenter_m');
//        $this->load->model('budget/purposebudget_m');
//        $this->load->model('budget/currency_m');
//        $this->load->model('budget/unit_m');
//
//        $session = $this->session->all_userdata();
//        if ($session['ROLE'] === 6) {
//            $contain = 'budget/budgetcapex/view_budgetcapex_by_section_v';
//        } else if ($session['ROLE'] === 5 || $session['ROLE'] === 4 || $session['ROLE'] === 3) {
//            $contain = 'budget/budgetcapex/confirm_budgetcapex_v';
//        } else if ($session['ROLE'] === 1 || $session['ROLE'] === 2) {
//            $contain = 'budget/budgetcapex/view_budgetcapex_by_admin_v';
//        }
//
//        $data['data_project'] = $this->budgetproject_m->get_data_project($no_budget);
//        $data['data_product'] = $this->budgetproduct_m->get_data_product($no_budget);
//        $data['data_detail'] = $this->budgetcapexdetail_m->get_data_detail($no_budget);
//
//        $data['data_project_new'] = $this->budgetproject_m->get_current_data_project($no_budget);
//        $data['data_product_new'] = $this->budgetproduct_m->get_current_data_product($no_budget);
//
//        $data['data_cost_center'] = $this->costcenter_m->get_costcenter();
//        $data['data_fiscal'] = $this->fiscal_m->get_fiscal();
//        $data['data_budgetsubcategory'] = $this->budgetsubcategory_m->get_budgetsubcategory();
//        $data['data_purposebudget'] = $this->purposebudget_m->get_purposebudget();
//        $data['unit'] = $this->unit_m->get_unit();
//        $data['currency'] = $this->currency_m->get_all_currency();
//
//        $data['app'] = $this->role_module_m->get_app();
//        $data['module'] = $this->role_module_m->get_module();
//        $data['function'] = $this->role_module_m->get_function();
//        $data['sidebar'] = $this->role_module_m->side_bar(29);
//        $data['news'] = $this->news_m->get_news();
//
//        $data['msg'] = $msg;
//        $data['data'] = $this->capex_plan_m->get_data($no_budget)->row();
//        $data['content'] = $contain;
//        $data['title'] = 'View Budget Capex';
//
//        $this->load->view($this->layout, $data);
//    }

//    function recapitulate_capex_plan() {
//        $data = array(
//            'INT_STATUS' => 1
//        );
//        $this->capex_plan_m->update($data, $this->input->post('INT_ID_FISCAL_YEAR'));
//
//        redirect($this->back_to_approve . $msg = 2);
//    }

    function print_capex_by_section() {
        $this->role_module_m->authorization('29');
        $this->load->library('excel');

        $this->load->model('budget/budgetcapexdetail_m');
        $this->load->model('budget/budgetproject_m');
        $this->load->model('budget/budgetproduct_m');
        $this->load->model('organization/section_m');
        $this->load->model('budget/fiscal_m');
        $objTpl = PHPExcel_IOFactory::load('./assets/template/CAPEXsectionplan.xls');

        $session = $this->session->all_userdata();
        $id_fiscal = $this->input->post('INT_ID_FISCAL');

        $data = $this->capex_plan_m->get_capex_plan_by_section($session['SECTION'], $id_fiscal);
        $sect = $this->section_m->get_name_section($session['SECTION']);
        $sect_desc = $this->section_m->get_desc_section($session['SECTION']);
        $fiscal = $this->fiscal_m->select_fiscal_year($id_fiscal);

        foreach ($data as $row) {
            $cek_project = $this->budgetproject_m->cek_project_close($row->INT_NO_BUDGET_CPX);
            if ($cek_project != NULL) {
                $data_project = $this->budgetproject_m->get_data_project_close($row->INT_NO_BUDGET_CPX);
                $i = 0;
                foreach ($data_project as $row_project) {
                    $project[] = $row_project->CHR_PROJECT;
                    $i++;
                }
            }

            $cek_product = $this->budgetproduct_m->cek_product_close($row->INT_NO_BUDGET_CPX);
            if ($cek_product != NULL) {
                $data_product = $this->budgetproduct_m->get_data_product_close($row->INT_NO_BUDGET_CPX);
                $i = 0;
                foreach ($data_product as $row_product) {
                    $product[] = $row_product->CHR_PRODUCT;
                    $i++;
                }
            }
        }

        $objTpl->setActiveSheetIndex(0);

        $objTpl->getActiveSheet()->setCellValue('A2', 'MASTER BUDGET: CAPITAL EXPENDITURE TAHUN ' . trim($fiscal));
        $objTpl->getActiveSheet()->setCellValue('A3', 'SECTION: ' . $sect . '/' . trim($sect_desc));
        $objTpl->getActiveSheet()->setCellValue('M2', 'Date of Print: ' . date('d-M-Y'));

        $e = 7;
        $jum = 1;
        foreach ($data as $row) {
            $objTpl->getActiveSheet()->setCellValue("A$e", $jum);
            $objTpl->getActiveSheet()->setCellValue("B$e", $row->INT_NO_BUDGET_CPX);
            $objTpl->getActiveSheet()->setCellValue("C$e", trim($row->BIT_FLG_NEW));
            $objTpl->getActiveSheet()->setCellValue("D$e", trim($row->CHR_BUDGET_CATEGORY_DESC));
            $objTpl->getActiveSheet()->setCellValue("E$e", trim($row->CHR_BUDGET_SUB_CATEGORY_DESC));
            $objTpl->getActiveSheet()->setCellValue("F$e", trim($row->BIT_FLG_OWNER));
            $objTpl->getActiveSheet()->setCellValue("G$e", trim($row->CHR_BUDGET_NAME));
            $objTpl->getActiveSheet()->setCellValue("H$e", trim($row->CHR_PURPOSE_DESC));
            $objTpl->getActiveSheet()->setCellValue("I$e", '');
            //$objTpl->getActiveSheet()->setCellValue("J$e", $project[0]);
            //$objTpl->getActiveSheet()->setCellValue("K$e", $product[0]);
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

        $filename = trim($fiscal) . "/" . $sect . ".xls";
        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . trim($filename) . '"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objTpl, 'Excel5');
        $objWriter->save('php://output');
    }

    function print_capex_by_dept() {
        $this->role_module_m->authorization('29');
        $this->load->library('excel');

        $this->load->model('budget/budgetcapexdetail_m');
        $this->load->model('budget/budgetproject_m');
        $this->load->model('budget/budgetproduct_m');
        $this->load->model('organization/dept_m');
        $this->load->model('budget/fiscal_m');
        $objTpl = PHPExcel_IOFactory::load('./assets/template/CAPEXsectionplan.xls');

        $session = $this->session->all_userdata();
        $id_fiscal = $this->input->post('INT_ID_FISCAL');

        $data = $this->capex_plan_m->get_capex_plan_by_manager($session['DEPT'], $id_fiscal);
        $dept = $this->dept_m->get_name_dept($session['DEPT']);
        $dept_desc = $this->dept_m->get_desc_dept($session['DEPT']);
        $fiscal = $this->fiscal_m->select_fiscal_year($id_fiscal);

        //$data_project = $this->budgetproject_m->get_data($no_budget)->result();
        //$data_product = $this->budgetproduct_m->get_data($no_budget)->result();

        $objTpl->setActiveSheetIndex(0);

        $objTpl->getActiveSheet()->setCellValue('A2', 'MASTER BUDGET: CAPITAL EXPENDITURE TAHUN ' . trim($fiscal));
        $objTpl->getActiveSheet()->setCellValue('A3', 'DEPARTMENT: ' . $dept . '/' . $dept_desc);
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

        $filename = trim($fiscal) . "/" . $dept . ".xls";
        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . trim($filename) . '"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objTpl, 'Excel5');
        $objWriter->save('php://output');
    }

}

?>
