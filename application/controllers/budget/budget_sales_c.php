<?php

class budget_sales_c extends CI_Controller {

    private $layout = '/template/head';
    private $layout_blank = '/template/head_blank';
    private $back_to_upload = 'budget/budget_sales_c/create_sales/';
    private $back_to_manage = 'budget/budget_sales_c/index/';

    public function __construct() {
        parent::__construct();
        $this->load->model('budget/budget_sales_m');
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

    function create_sales($msg = null, $INT_ID_FISCAL_YEAR = null, $INT_ID_BUDGET_TYPE = null, $INT_DIV = null, $INT_DEPT = null, $INT_SECT = null, $CHR_BUDGET_TYPE = null, $INT_ID_BUDGET_CATEGORY = null) {
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
        $data['INT_ID_BUDGET_TYPE'] = 14;
        $data['INT_ID_BUDGET_CATEGORY'] = $INT_ID_BUDGET_CATEGORY;
        $data['INT_DIV'] = $INT_DIV = 2;
        $data['INT_DEPT'] = $INT_DEPT = 17;
        $data['INT_SECT'] = $INT_SECT = 42;
        $data['CHR_BUDGET_TYPE'] = $CHR_BUDGET_TYPE;
        $CHR_BUDGET_CATEGORY = "";
                
        $data['CHR_DIV'] = $this->division_m->get_desc_division($INT_DIV);
        $data['CHR_DEPT'] = $this->dept_m->get_desc_dept($INT_DEPT);
        $data['CHR_SECT'] = $this->section_m->get_desc_section($INT_SECT);
        
//GET DETAIL BUDGET
        if($INT_ID_BUDGET_CATEGORY <> null){
            $data['url_page'] = site_url("budget/budget_sales_c/refresh_table_page/1/$INT_ID_FISCAL_YEAR/$INT_ID_BUDGET_TYPE/$INT_DIV/$INT_DEPT/$INT_SECT/$CHR_BUDGET_TYPE/$CHR_BUDGET_CATEGORY");
        } else {
            $data['url_page'] = "";
        }
        $data['CHR_BUDGET_CATEGORY'] = $CHR_BUDGET_CATEGORY;

//GET DETAIL BUDGET
        if ($CHR_BUDGET_TYPE <> null) {
            $data['detail_confirm'] = $this->budget_sales_m->get_detail_confirm_sales($INT_ID_FISCAL_YEAR, $CHR_BUDGET_TYPE, $CHR_BUDGET_CATEGORY, $INT_DIV, $INT_DEPT, $INT_SECT);
        } else {
            $data['detail_confirm'] = null;
        }

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(211);
        $data['news'] = $this->news_m->get_news();
        $data['msg'] = $msg;
        $data['data_fiscal'] = $this->fiscal_m->get_all_fiscal();  
        $data['category'] = $this->budgetcategory_m->get_budgetcategory_sales();

        $data['title'] = 'Create Budget Sales';
        $data['content'] = 'budget/budget_sales/create_budget_sales_v';

        $session = $this->session->all_userdata();
        $user_session = $this->session->all_userdata();
        //$user = $this->user_m->get_user_org($user_session['NPK']);
        $data['role'] = $user_session['ROLE'];
        
        $this->load->view($this->layout, $data);
    }
    
    function prepare_approve_sales($msg = null, $INT_ID_FISCAL_YEAR = null, $INT_DIV = null, $INT_GROUP = null, $INT_DEPT = null, $INT_ID_BUDGET_CATEGORY = null) {
        $user_session = $this->session->all_userdata();
        if ($msg == 5) {
            $msg = "<div class = 'alert alert-success'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Commiting success. </strong> The data is successfully updated. </div >";
        } elseif ($msg == 6) {
            $msg = "<div class = 'alert alert-success'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Budget Expense was Approved. </strong> The data was successfully updated. </div >";
        } elseif ($msg == 7) {
            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Budget Expense was Unapproved. </strong> The data was successfully updated. </div >";
        } elseif ($msg == 8) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Budget Expense was Unlocked. </strong> The data was successfully updated. </div >";
        } elseif ($msg == 12) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Executing error!</strong> Something is not right. </div >";
        } elseif ($msg == 13) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Executing failed!</strong> No data was selected.</div >";
        } elseif ($msg == 14) {
            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Access denied!</strong> Unbudget Expense cannot be ceated on the Planning session.</div >";
        }
        
        $data['INT_ID_FISCAL_YEAR'] = $INT_ID_FISCAL_YEAR;
        $data['INT_DIV'] = $INT_DIV = 2;
        $data['INT_GROUP'] = $INT_GROUP = 9;
        $data['INT_DEPT'] = $INT_DEPT = 17;   
        $data['INT_ID_BUDGET_CATEGORY'] = $INT_ID_BUDGET_CATEGORY;
        
        $data['CHR_DIV'] = $this->division_m->get_desc_division($INT_DIV);
        $data['CHR_GROUP'] = $this->groupdept_m->get_desc_groupdept($INT_GROUP);
        $data['CHR_DEPT'] = $this->dept_m->get_desc_dept($INT_DEPT);
        
        if($INT_ID_BUDGET_CATEGORY <> null && $INT_ID_FISCAL_YEAR <> null){
            $data['url_page'] = site_url("budget/budget_sales_c/refresh_detail_table_page/1/$INT_ID_FISCAL_YEAR/$INT_DIV/$INT_GROUP/$INT_DEPT/$INT_ID_BUDGET_CATEGORY");
        } else {
            $data['url_page'] = "";
        }
                
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(217);
        $data['news'] = $this->news_m->get_news();
        $data['data_fiscal'] = $this->fiscal_m->get_all_fiscal();  
        $data['category'] = $this->budgetcategory_m->get_budgetcategory_sales();

        $data['title'] = 'Approval for Planning Sales';
        $data['msg'] = $msg; 

        $session = $this->session->all_userdata();
        $user_session = $this->session->all_userdata();
        //$user = $this->user_m->get_user_org($user_session['NPK']);
        $data['role'] = $user_session['ROLE'];
        
        $data['content'] = 'budget/budget_sales/approval_budget_sales_v';
        
        $this->load->view($this->layout, $data);
    }
    
    function refresh_detail_table() {
        $INT_ID_FISCAL_YEAR = $this->input->post("INT_ID_FISCAL_YEAR");
        $INT_DEPT = $this->input->post("INT_DEPT");
        $INT_DIV = $this->input->post("INT_DIV");
        $INT_GROUP = $this->input->post("INT_GROUP");
        $INT_ID_BUDGET_CATEGORY = $this->input->post("INT_ID_BUDGET_CATEGORY");
        
        $url_iframe = site_url("budget/budget_sales_c/refresh_detail_table_page/1/$INT_ID_FISCAL_YEAR/$INT_DIV/$INT_GROUP/$INT_DEPT/$INT_ID_BUDGET_CATEGORY");
        $url_export_excel = site_url("budget/budget_sales_c/download_excel_for_approve/$INT_ID_FISCAL_YEAR/$INT_DIV/$INT_GROUP/$INT_DEPT/$INT_ID_BUDGET_CATEGORY");

        $data = array(
            'url_iframe' => $url_iframe,
            'url_export_excel' => $url_export_excel
        );

//Either you can print value or you can send value to database
        echo json_encode($data);
        
        //echo site_url("budget/budget_sales_c/refresh_detail_table_page/1/$INT_ID_FISCAL_YEAR/$INT_DIV/$INT_GROUP/$INT_DEPT/$INT_ID_BUDGET_CATEGORY");
    }

    function refresh_detail_table_page($msg = null, $INT_ID_FISCAL_YEAR = null, $INT_DIV = null, $INT_GROUP = null, $INT_DEPT = null, $INT_ID_BUDGET_CATEGORY = null) {
        $user_session = $this->session->all_userdata();

        $data['INT_ID_FISCAL_YEAR'] = $INT_ID_FISCAL_YEAR;
        $data['INT_DIV'] = $INT_DIV;
        $data['INT_GROUP'] = $INT_GROUP;
        $data['INT_DEPT'] = $INT_DEPT;
        $data['INT_ID_BUDGET_CATEGORY'] = $INT_ID_BUDGET_CATEGORY;
        
//        print_r($INT_ID_FISCAL_YEAR .'-'.$INT_DIV.'-'.$INT_GROUP.'-'.$INT_DEPT.'-'.$INT_ID_BUDGET_CATEGORY);
//        exit();

        $data['content'] = 'budget/budget_sales/refresh_detail_budget_sales_v';
        $data['sub_category'] = $this->budget_sales_m->get_sub_category_sales_product_aii($INT_ID_BUDGET_CATEGORY);
        
        if($INT_ID_BUDGET_CATEGORY == '16' || $INT_ID_BUDGET_CATEGORY == '17'){
            //SUMMARY SALES PRODUCT AII & AIIA         
            $data['content'] = 'budget/budget_sales/refresh_detail_budget_sales_v';
        } else if ($INT_ID_BUDGET_CATEGORY == '18' || $INT_ID_BUDGET_CATEGORY == '19'){
            //SUMMARY SALES TOOLING AII & AIIA
            $data['content'] = 'budget/budget_sales/refresh_detail_budget_sales_tooling_v';
        } 

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(217);
        $data['news'] = $this->news_m->get_news();
        $data['msg'] = $msg;

        $data['title'] = 'Approval Budget Sales';

        $this->load->view($this->layout_blank, $data);
    }

    function approve_budget_sales() {
        $user_session = $this->session->all_userdata();

        $INT_ID_FISCAL_YEAR = $this->input->post('INT_ID_FISCAL_YEAR');
        $INT_DIV = 2;
        $INT_GROUP = 9;
        $INT_DEPT = 17;
        $INT_ID_BUDGET_CATEGORY = $this->input->post('INT_ID_BUDGET_CATEGORY');   
        
        // $CHR_STAT_REV = 'NEW';
        $CHR_STAT_REV = 'RMB';

        if ($_POST["btn-save"] == 'man') {
            $app_man = $this->db;
            $app_man->trans_begin();

            $app_man->query("UPDATE CPL.TT_BUDGET_SALES SET CHR_FLAG_APP_MAN = '1'
                            WHERE (INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR')
                                    AND (CHR_STAT_REV = '$CHR_STAT_REV')
                                    AND (INT_DIV = '$INT_DIV')
                                    AND (INT_GROUP_DEPT = '$INT_GROUP')
                                    AND (INT_DEPT = '$INT_DEPT')
                                    AND (CHR_BUDGET_CATEGORY IN (SELECT CHR_BUDGET_CATEGORY FROM CPL.TM_BUDGET_CATEGORY WHERE INT_ID_BUDGET_CATEGORY = '$INT_ID_BUDGET_CATEGORY'))");

            $app_man->trans_complete();

            if ($app_man->trans_status() === FALSE) {
                $app_man->trans_rollback();
                redirect("budget/budget_sales_c/prepare_approve_sales/12/$INT_ID_FISCAL_YEAR/$INT_DIV/$INT_GROUP/$INT_DEPT/$INT_ID_BUDGET_CATEGORY");
            } else {
                $app_man->trans_commit();
                redirect("budget/budget_sales_c/prepare_approve_sales/6/$INT_ID_FISCAL_YEAR/$INT_DIV/$INT_GROUP/$INT_DEPT/$INT_ID_BUDGET_CATEGORY");
            }
        } else if ($_POST["btn-save"] == 'gm') {
            $app_gm = $this->db;
            $app_gm->trans_start();

            $app_gm->query("UPDATE CPL.TT_BUDGET_SALES SET CHR_FLAG_APP_GM = '1'
                            WHERE (INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR')
                                    AND (CHR_STAT_REV = '$CHR_STAT_REV')
                                    AND (INT_DIV = '$INT_DIV')
                                    AND (INT_GROUP_DEPT = '$INT_GROUP')
                                    AND (INT_DEPT = '$INT_DEPT')
                                    AND CHR_BUDGET_CATEGORY IN (SELECT CHR_BUDGET_CATEGORY FROM CPL.TM_BUDGET_CATEGORY WHERE INT_ID_BUDGET_CATEGORY = '$INT_ID_BUDGET_CATEGORY')");

            $app_gm->trans_complete();

            if ($app_gm->trans_status() === FALSE) {
                $app_gm->trans_rollback();
                redirect("budget/budget_sales_c/prepare_approve_sales/12/$INT_ID_FISCAL_YEAR/$INT_DIV/$INT_GROUP/$INT_DEPT/$INT_ID_BUDGET_CATEGORY");
            } else {
                $app_gm->trans_commit();
                redirect("budget/budget_sales_c/prepare_approve_sales/6/$INT_ID_FISCAL_YEAR/$INT_DIV/$INT_GROUP/$INT_DEPT/$INT_ID_BUDGET_CATEGORY");
            }
        } else if ($_POST["btn-save"] == 'dir') {
            $app_dir = $this->db;
            $app_dir->trans_start();

            $app_dir->query("UPDATE CPL.TT_BUDGET_SALES SET CHR_FLAG_APP_DIR = '1'
                            WHERE (INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR')
                                    AND (CHR_STAT_REV = '$CHR_STAT_REV')
                                    AND (INT_DIV = '$INT_DIV')
                                    AND (INT_GROUP_DEPT = '$INT_GROUP')
                                    AND (INT_DEPT = '$INT_DEPT')
                                    AND CHR_BUDGET_CATEGORY IN (SELECT CHR_BUDGET_CATEGORY FROM CPL.TM_BUDGET_CATEGORY WHERE INT_ID_BUDGET_CATEGORY = '$INT_ID_BUDGET_CATEGORY')");

            $app_dir->trans_complete();

            if ($app_dir->trans_status() === FALSE) {
                $app_dir->trans_rollback();
                redirect("budget/budget_sales_c/prepare_approve_sales/12/$INT_ID_FISCAL_YEAR/$INT_DIV/$INT_GROUP/$INT_DEPT/$INT_ID_BUDGET_CATEGORY");
            } else {
                $app_dir->trans_commit();
                redirect("budget/budget_sales_c/prepare_approve_sales/6/$INT_ID_FISCAL_YEAR/$INT_DIV/$INT_GROUP/$INT_DEPT/$INT_ID_BUDGET_CATEGORY");
            }
        } else if ($_POST["btn-save"] == 'all') {
            $app_all = $this->db;
            $app_all->trans_start();

            $app_all->query("UPDATE CPL.TT_BUDGET_SALES SET CHR_FLAG_APP_MAN = '1', CHR_FLAG_APP_GM = '1', CHR_FLAG_APP_DIR = '1', CHR_FLAG_APP_COMPLETE = '1'
                            WHERE (INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR')
                                    AND (CHR_STAT_REV = '$CHR_STAT_REV')
                                    AND (INT_DIV = '$INT_DIV')
                                    AND (INT_GROUP_DEPT = '$INT_GROUP')
                                    AND (INT_DEPT = '$INT_DEPT')
                                    AND CHR_BUDGET_CATEGORY IN (SELECT CHR_BUDGET_CATEGORY FROM CPL.TM_BUDGET_CATEGORY WHERE INT_ID_BUDGET_CATEGORY = '$INT_ID_BUDGET_CATEGORY')");

            $app_all->trans_complete();

            if ($app_all->trans_status() === FALSE) {
                $app_all->trans_rollback();
                redirect("budget/budget_sales_c/prepare_approve_sales/12/$INT_ID_FISCAL_YEAR/$INT_DIV/$INT_GROUP/$INT_DEPT/$INT_ID_BUDGET_CATEGORY");
            } else {
                $app_all->trans_commit();
                redirect("budget/budget_sales_c/prepare_approve_sales/6/$INT_ID_FISCAL_YEAR/$INT_DIV/$INT_GROUP/$INT_DEPT/$INT_ID_BUDGET_CATEGORY");
            }
        } else if ($_POST["btn-save"] == 'reject') {
            $app_all = $this->db;
            $app_all->trans_start();

            $app_all->query("UPDATE CPL.TT_BUDGET_SALES SET CHR_FLAG_APP_MAN = '0', CHR_FLAG_APP_GM = '0', CHR_FLAG_APP_DIR = '0', CHR_FLAG_APP_COMPLETE = '0'
                            WHERE (INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR')
                                    AND (CHR_STAT_REV = '$CHR_STAT_REV')
                                    AND (INT_DIV = '$INT_DIV')
                                    AND (INT_GROUP_DEPT = '$INT_GROUP')
                                    AND (INT_DEPT = '$INT_DEPT')
                                    AND CHR_BUDGET_CATEGORY IN (SELECT CHR_BUDGET_CATEGORY FROM CPL.TM_BUDGET_CATEGORY WHERE INT_ID_BUDGET_CATEGORY = '$INT_ID_BUDGET_CATEGORY')");

            $app_all->trans_complete();

            if ($app_all->trans_status() === FALSE) {
                $app_all->trans_rollback();
                redirect("budget/budget_sales_c/prepare_approve_sales/12/$INT_ID_FISCAL_YEAR/$INT_DIV/$INT_GROUP/$INT_DEPT/$INT_ID_BUDGET_CATEGORY");
            } else {
                $app_all->trans_commit();
                redirect("budget/budget_sales_c/prepare_approve_sales/7/$INT_ID_FISCAL_YEAR/$INT_DIV/$INT_GROUP/$INT_DEPT/$INT_ID_BUDGET_CATEGORY");
            }
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
    
    //=========================== NEW UPDATE 08/07/2017 ======================//

    function download_template($budget_category) {
        $this->load->helper('download');
        $category_desc = $this->budgetcategory_m->get_desc_budgetcategory($budget_category);
        $filename = str_replace(" ", "_", trim($category_desc));

        ob_clean();
        $name = 'Template_'.$filename.'.xls';
        $data = file_get_contents("assets/template/budget/Template_$filename.xls");

        force_download($name, $data);
    }

    function upload_budget_sales() {
        $this->load->helper(array('form', 'url', 'inflector'));
        $this->load->library(array('PHPExcel', 'PHPExcel/IOFactory'));
        $INT_ID_FISCAL_YEAR = $this->input->post("INT_ID_FISCAL_YEAR");
        $INT_ID_FISCAL_YEAR = substr($INT_ID_FISCAL_YEAR, 0, 4);
        $INT_DEPT = $this->input->post("INT_ID_DEPT");
        $INT_SECT = $this->input->post("INT_ID_SECT");
        $INT_ID_BUDGET_TYPE = $this->input->post("INT_ID_BUDGET_TYPE");
        $INT_ID_BUDGET_CATEGORY = $this->input->post("INT_ID_BUDGET_CATEGORY");
        $CHR_BUDGET_TYPE_DESC = $this->budgettype_m->get_budget_type($INT_ID_BUDGET_TYPE);
        $CHR_BUDGET_TYPE = trim($CHR_BUDGET_TYPE_DESC->CHR_BUDGET_TYPE);
        $CHR_BUDGET_TYPE_DESC = trim($CHR_BUDGET_TYPE_DESC->CHR_BUDGET_TYPE_DESC);
        $CHR_BUDGET_CATEGORY = trim($this->budgetcategory_m->get_init_budgetcategory($INT_ID_BUDGET_CATEGORY));
        $CHR_BUDGET_CATEGORY_DESC = trim($this->budgetcategory_m->get_desc_budgetcategory($INT_ID_BUDGET_CATEGORY));
        $budget_type_desc_format = str_replace(" ", "_", $CHR_BUDGET_TYPE_DESC);
        $get_gm_div = $this->dept_m->get_gm_div($INT_DEPT)->row();
        $INT_DIV = $get_gm_div->INT_ID_DIVISION;

        //delete existing template
        $this->budget_sales_m->delete_existing_template($CHR_BUDGET_TYPE, $CHR_BUDGET_CATEGORY, $INT_DIV, $INT_DEPT, $INT_SECT);

        $upload_date = date('Ymd');
        $fileName = $_FILES['upload_budget_sales']['name'];
        if (empty($fileName)) {
            redirect($this->back_to_upload . $msg = 12);
        }

//file untuk submit file excel
        $config['upload_path'] = './assets/file/budget_sales/';
        $config['file_name'] = $fileName;
        $config['allowed_types'] = 'xls|xlsx';
        $config['max_size'] = 10000;

//code for upload with ci
        $this->load->library('upload');
        $this->upload->initialize($config);
        if ($a = $this->upload->do_upload('upload_budget_sales'))
            $this->upload->display_errors();
        $media = $this->upload->data('upload_budget_sales');
//cek apakah template sesuai dengan pilihan tipe budget?
        if (strpos($media['file_name'], str_replace(" ", "_", $CHR_BUDGET_CATEGORY_DESC)) === false) {
//jika template tidak sesuai dengan tipe budget

            redirect($this->back_to_upload . $msg = 16);
        }

        $inputFileName = './assets/file/budget_sales/' . $media['file_name'];

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
        $budget_category_template = strtolower($rowHeader[0][99]);
        if ($budget_category_template !== strtolower(trim($CHR_BUDGET_CATEGORY_DESC))) {
            redirect($this->back_to_upload . $msg = 16);
        }
        $get_gm_div = $this->dept_m->get_gm_div($INT_DEPT)->row();
        $INT_GROUP_DEPT = $get_gm_div->INT_ID_GROUP_DEPT;
        $INT_DIV = $get_gm_div->INT_ID_DIVISION;
        
        for ($row = 3; $row <= $highestRow; $row++) {
            $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);
            if ($rowData[0][1] == '') {
                break;
            }
            //===============================   common data   =============================== 
            $CHR_BUDGET_SUB_CATEGORY = $rowData[0][1];
            $CHR_BUDGET_SUB_CATEGORY_DESC = $rowData[0][2];
            $CHR_BUDGET_CATEGORY = $rowData[0][3];
            $CHR_BUDGET_CATEGORY_DESC = $rowData[0][4];
            $CHR_CODE_CATEGORY_A3 = $rowData[0][5];
            $CHR_CODE_CATEGORY_A3_DESC = $rowData[0][6];             
            //=============================== end common data =============================== 
            $CHR_PART_NO = "";
            $CHR_PART_NAME = "";
            $CHR_MATERIAL_NO = "";
            $CHR_PROJECT_NAME = "";
            $CHR_STATUS = "";
            $CHR_PURPOSE = "";
            $CHR_CUSTOMER_NAME = "";
            $CHR_DISTRIBUTION = "";
            $CHR_ORG_CURR = "";
            $CHR_CODE_UNIQ_CUSTOMER = "";
            $CHR_CODE_UNIQ_PRODUCT = "";
            
            $INT_QTY_BLN04 = "0";
            $INT_QTY_BLN05 = "0";
            $INT_QTY_BLN06 = "0";
            $INT_QTY_BLN07 = "0";
            $INT_QTY_BLN08 = "0";
            $INT_QTY_BLN09 = "0";
            $INT_QTY_BLN10 = "0";
            $INT_QTY_BLN11 = "0";
            $INT_QTY_BLN12 = "0";
            $INT_QTY_BLN01 = "0";
            $INT_QTY_BLN02 = "0";
            $INT_QTY_BLN03 = "0";
            //===  TOTAL QTY
            $INT_QTY_SUM = "0";            
            
            $FLT_PRC_BLN04 = "0";
            $FLT_PRC_BLN05 = "0";
            $FLT_PRC_BLN06 = "0";
            $FLT_PRC_BLN07 = "0";
            $FLT_PRC_BLN08 = "0";
            $FLT_PRC_BLN09 = "0";
            $FLT_PRC_BLN10 = "0";
            $FLT_PRC_BLN11 = "0";
            $FLT_PRC_BLN12 = "0";
            $FLT_PRC_BLN01 = "0";
            $FLT_PRC_BLN02 = "0";
            $FLT_PRC_BLN03 = "0";
            //===  TOTAL RATE
            $FLT_PRC_SUM = "0";
            
            $FLT_RAT_BLN04 = "0";
            $FLT_RAT_BLN05 = "0";
            $FLT_RAT_BLN06 = "0";
            $FLT_RAT_BLN07 = "0";
            $FLT_RAT_BLN08 = "0";
            $FLT_RAT_BLN09 = "0";
            $FLT_RAT_BLN10 = "0";
            $FLT_RAT_BLN11 = "0";
            $FLT_RAT_BLN12 = "0";
            $FLT_RAT_BLN01 = "0";
            $FLT_RAT_BLN02 = "0";
            $FLT_RAT_BLN03 = "0";
            //===  TOTAL RATE
            $FLT_RAT_SUM = "0";
            
            $FLT_APR_BLN04 = "0";
            $FLT_APR_BLN05 = "0";
            $FLT_APR_BLN06 = "0";
            $FLT_APR_BLN07 = "0";
            $FLT_APR_BLN08 = "0";
            $FLT_APR_BLN09 = "0";
            $FLT_APR_BLN10 = "0";
            $FLT_APR_BLN11 = "0";
            $FLT_APR_BLN12 = "0";
            $FLT_APR_BLN01 = "0";
            $FLT_APR_BLN02 = "0";
            $FLT_APR_BLN03 = "0";
            //===  TOTAL APR
            $FLT_APR_SUM = "0";
            
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

            //===============================   SALES PRODUCT AII/AIIA   =============================== 
            if($INT_ID_BUDGET_CATEGORY == '16' || $INT_ID_BUDGET_CATEGORY == '17'){
                $CHR_PART_NO = $rowData[0][7];
                $CHR_MATERIAL_NO = $rowData[0][8];
                $CHR_PART_NAME = $rowData[0][9];
                $CHR_STATUS = $rowData[0][10];
                $CHR_PROJECT_NAME = $rowData[0][11];
                $CHR_DISTRIBUTION = $rowData[0][12];
                $CHR_PURPOSE = $rowData[0][13];
                $CHR_CUSTOMER_NAME = $rowData[0][14];
                $CHR_ORG_CURR = $rowData[0][15];
                $CHR_CODE_UNIQ_CUSTOMER = $rowData[0][16];
                $CHR_CODE_UNIQ_PRODUCT = $rowData[0][17];
                
                $INT_QTY_BLN04 = $rowData[0][18];
                $FLT_PRC_BLN04 = $rowData[0][19];
                $FLT_RAT_BLN04 = $rowData[0][20];
                $FLT_APR_BLN04 = $rowData[0][21];
                $MON_AMT_BLN04 = ($INT_QTY_BLN04 * $FLT_PRC_BLN04 * $FLT_RAT_BLN04)+($INT_QTY_BLN04 * $FLT_APR_BLN04);
                
                $INT_QTY_BLN05 = $rowData[0][23];
                $FLT_PRC_BLN05 = $rowData[0][24];
                $FLT_RAT_BLN05 = $rowData[0][25];
                $FLT_APR_BLN05 = $rowData[0][26];
                $MON_AMT_BLN05 = ($INT_QTY_BLN05 * $FLT_PRC_BLN05 * $FLT_RAT_BLN05)+($INT_QTY_BLN05 * $FLT_APR_BLN05);
                
                $INT_QTY_BLN06 = $rowData[0][28];
                $FLT_PRC_BLN06 = $rowData[0][29];
                $FLT_RAT_BLN06 = $rowData[0][30];
                $FLT_APR_BLN06 = $rowData[0][31];
                $MON_AMT_BLN06 = ($INT_QTY_BLN06 * $FLT_PRC_BLN06 * $FLT_RAT_BLN06)+($INT_QTY_BLN06 * $FLT_APR_BLN06);
                
                $INT_QTY_BLN07 = $rowData[0][33];
                $FLT_PRC_BLN07 = $rowData[0][34];
                $FLT_RAT_BLN07 = $rowData[0][35];
                $FLT_APR_BLN07 = $rowData[0][36];
                $MON_AMT_BLN07 = ($INT_QTY_BLN07 * $FLT_PRC_BLN07 * $FLT_RAT_BLN07)+($INT_QTY_BLN07 * $FLT_APR_BLN07);
                
                $INT_QTY_BLN08 = $rowData[0][38];
                $FLT_PRC_BLN08 = $rowData[0][39];
                $FLT_RAT_BLN08 = $rowData[0][40];
                $FLT_APR_BLN08 = $rowData[0][41];
                $MON_AMT_BLN08 = ($INT_QTY_BLN08 * $FLT_PRC_BLN08 * $FLT_RAT_BLN08)+($INT_QTY_BLN08 * $FLT_APR_BLN08);
                
                $INT_QTY_BLN09 = $rowData[0][43];
                $FLT_PRC_BLN09 = $rowData[0][44];
                $FLT_RAT_BLN09 = $rowData[0][45];
                $FLT_APR_BLN09 = $rowData[0][46];
                $MON_AMT_BLN09 = ($INT_QTY_BLN09 * $FLT_PRC_BLN09 * $FLT_RAT_BLN09)+($INT_QTY_BLN09 * $FLT_APR_BLN09);
                
                $INT_QTY_BLN10 = $rowData[0][48];
                $FLT_PRC_BLN10 = $rowData[0][49];
                $FLT_RAT_BLN10 = $rowData[0][50];
                $FLT_APR_BLN10 = $rowData[0][51];
                $MON_AMT_BLN10 = ($INT_QTY_BLN10 * $FLT_PRC_BLN10 * $FLT_RAT_BLN10)+($INT_QTY_BLN10 * $FLT_APR_BLN10);
                
                $INT_QTY_BLN11 = $rowData[0][53];
                $FLT_PRC_BLN11 = $rowData[0][54];
                $FLT_RAT_BLN11 = $rowData[0][55];
                $FLT_APR_BLN11 = $rowData[0][56];
                $MON_AMT_BLN11 = ($INT_QTY_BLN11 * $FLT_PRC_BLN11 * $FLT_RAT_BLN11)+($INT_QTY_BLN11 * $FLT_APR_BLN11);
                
                $INT_QTY_BLN12 = $rowData[0][58];
                $FLT_PRC_BLN12 = $rowData[0][59];
                $FLT_RAT_BLN12 = $rowData[0][60];
                $FLT_APR_BLN12 = $rowData[0][61];
                $MON_AMT_BLN12 = ($INT_QTY_BLN12 * $FLT_PRC_BLN12 * $FLT_RAT_BLN12)+($INT_QTY_BLN12* $FLT_APR_BLN12);
                
                $INT_QTY_BLN01 = $rowData[0][63];
                $FLT_PRC_BLN01 = $rowData[0][64];
                $FLT_RAT_BLN01 = $rowData[0][65];
                $FLT_APR_BLN01 = $rowData[0][66];
                $MON_AMT_BLN01 = ($INT_QTY_BLN01 * $FLT_PRC_BLN01 * $FLT_RAT_BLN01)+($INT_QTY_BLN01 * $FLT_APR_BLN01);
                
                $INT_QTY_BLN02 = $rowData[0][68];
                $FLT_PRC_BLN02 = $rowData[0][69];
                $FLT_RAT_BLN02 = $rowData[0][70];
                $FLT_APR_BLN02 = $rowData[0][71];
                $MON_AMT_BLN02 = ($INT_QTY_BLN02 * $FLT_PRC_BLN02 * $FLT_RAT_BLN02)+($INT_QTY_BLN02 * $FLT_APR_BLN02);
                
                $INT_QTY_BLN03 = $rowData[0][73];
                $FLT_PRC_BLN03 = $rowData[0][74];
                $FLT_RAT_BLN03 = $rowData[0][75];
                $FLT_APR_BLN03 = $rowData[0][76];
                $MON_AMT_BLN03 = ($INT_QTY_BLN03 * $FLT_PRC_BLN03 * $FLT_RAT_BLN03)+($INT_QTY_BLN03 * $FLT_APR_BLN03);
                
                $INT_QTY_SUM = $INT_QTY_BLN04 + $INT_QTY_BLN05 + $INT_QTY_BLN06 + $INT_QTY_BLN07 + $INT_QTY_BLN08 + $INT_QTY_BLN09 + $INT_QTY_BLN10 + $INT_QTY_BLN11 + $INT_QTY_BLN12 + $INT_QTY_BLN01 + $INT_QTY_BLN02 + $INT_QTY_BLN03;
                $FLT_PRC_SUM = $FLT_PRC_BLN04 + $FLT_PRC_BLN05 + $FLT_PRC_BLN06 + $FLT_PRC_BLN07 + $FLT_PRC_BLN08 + $FLT_PRC_BLN09 + $FLT_PRC_BLN10 + $FLT_PRC_BLN11 + $FLT_PRC_BLN12 + $FLT_PRC_BLN01 + $FLT_PRC_BLN02 + $FLT_PRC_BLN03;
                $FLT_RAT_SUM = $FLT_RAT_BLN04 + $FLT_RAT_BLN05 + $FLT_RAT_BLN06 + $FLT_RAT_BLN07 + $FLT_RAT_BLN08 + $FLT_RAT_BLN09 + $FLT_RAT_BLN10 + $FLT_RAT_BLN11 + $FLT_RAT_BLN12 + $FLT_RAT_BLN01 + $FLT_RAT_BLN02 + $FLT_RAT_BLN03;
                $FLT_APR_SUM = $FLT_APR_BLN04 + $FLT_APR_BLN05 + $FLT_APR_BLN06 + $FLT_APR_BLN07 + $FLT_APR_BLN08 + $FLT_APR_BLN09 + $FLT_APR_BLN10 + $FLT_APR_BLN11 + $FLT_APR_BLN12 + $FLT_APR_BLN01 + $FLT_APR_BLN02 + $FLT_APR_BLN03;
                $MON_AMT_SUM = $MON_AMT_BLN04 + $MON_AMT_BLN05 + $MON_AMT_BLN06 + $MON_AMT_BLN07 + $MON_AMT_BLN08 + $MON_AMT_BLN09 + $MON_AMT_BLN10 + $MON_AMT_BLN11 + $MON_AMT_BLN12 + $MON_AMT_BLN01 + $MON_AMT_BLN02 + $MON_AMT_BLN03;
            //=============================== END SALES PRODUCT AII/AIIA =============================== 
            
            //=============================== SALES TOOLING AII/AIIA ===============================    
            } else if ($INT_ID_BUDGET_CATEGORY == '18' || $INT_ID_BUDGET_CATEGORY == '19'){
                $CHR_PROJECT_NAME = $rowData[0][7];
                $CHR_CUSTOMER_NAME = $rowData[0][8];
                
                $MON_AMT_BLN04 = $rowData[0][9];
                $MON_AMT_BLN05 = $rowData[0][10];
                $MON_AMT_BLN06 = $rowData[0][11];
                $MON_AMT_BLN07 = $rowData[0][12];
                $MON_AMT_BLN08 = $rowData[0][13];
                $MON_AMT_BLN09 = $rowData[0][14];
                $MON_AMT_BLN10 = $rowData[0][15];
                $MON_AMT_BLN11 = $rowData[0][16];
                $MON_AMT_BLN12 = $rowData[0][17];
                $MON_AMT_BLN01 = $rowData[0][18];
                $MON_AMT_BLN02 = $rowData[0][19];
                $MON_AMT_BLN03 = $rowData[0][20];
                
                $MON_AMT_SUM = $MON_AMT_BLN04 + $MON_AMT_BLN05 + $MON_AMT_BLN06 + $MON_AMT_BLN07 + $MON_AMT_BLN08 + $MON_AMT_BLN09 + $MON_AMT_BLN10 + $MON_AMT_BLN11 + $MON_AMT_BLN12 + $MON_AMT_BLN01 + $MON_AMT_BLN02 + $MON_AMT_BLN03;            
            //=============================== END SALES TOOLING AII/AIIA ===============================
            }                
                
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
                'CHR_PART_NO' => $CHR_PART_NO,
                'CHR_PART_NAME' => $CHR_PART_NAME,
                'CHR_MATERIAL_NO' => $CHR_MATERIAL_NO,
                'CHR_PROJECT_NAME' => $CHR_PROJECT_NAME,
                'CHR_STATUS' => $CHR_STATUS,
                'CHR_PURPOSE' => $CHR_PURPOSE,
                'CHR_CUSTOMER_NAME' => $CHR_CUSTOMER_NAME,
                'CHR_DISTRIBUTION' => $CHR_DISTRIBUTION,
                'CHR_ORG_CURR' => $CHR_ORG_CURR,
                'CHR_CODE_UNIQ_CUSTOMER' => $CHR_CODE_UNIQ_CUSTOMER,
                'CHR_CODE_UNIQ_PRODUCT' => $CHR_CODE_UNIQ_PRODUCT,
                //QTY
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
                //PRICE ORG
                'FLT_PRC_BLN01' => $FLT_PRC_BLN01,
                'FLT_PRC_BLN02' => $FLT_PRC_BLN02,
                'FLT_PRC_BLN03' => $FLT_PRC_BLN03,
                'FLT_PRC_BLN04' => $FLT_PRC_BLN04,
                'FLT_PRC_BLN05' => $FLT_PRC_BLN05,
                'FLT_PRC_BLN06' => $FLT_PRC_BLN06,
                'FLT_PRC_BLN07' => $FLT_PRC_BLN07,
                'FLT_PRC_BLN08' => $FLT_PRC_BLN08,
                'FLT_PRC_BLN09' => $FLT_PRC_BLN09,
                'FLT_PRC_BLN10' => $FLT_PRC_BLN10,
                'FLT_PRC_BLN11' => $FLT_PRC_BLN11,
                'FLT_PRC_BLN12' => $FLT_PRC_BLN12,
                //RATE
                'FLT_RAT_BLN01' => $FLT_RAT_BLN01,
                'FLT_RAT_BLN02' => $FLT_RAT_BLN02,
                'FLT_RAT_BLN03' => $FLT_RAT_BLN03,
                'FLT_RAT_BLN04' => $FLT_RAT_BLN04,
                'FLT_RAT_BLN05' => $FLT_RAT_BLN05,
                'FLT_RAT_BLN06' => $FLT_RAT_BLN06,
                'FLT_RAT_BLN07' => $FLT_RAT_BLN07,
                'FLT_RAT_BLN08' => $FLT_RAT_BLN08,
                'FLT_RAT_BLN09' => $FLT_RAT_BLN09,
                'FLT_RAT_BLN10' => $FLT_RAT_BLN10,
                'FLT_RAT_BLN11' => $FLT_RAT_BLN11,
                'FLT_RAT_BLN12' => $FLT_RAT_BLN12,
                //APR
                'FLT_APR_BLN01' => $FLT_APR_BLN01,
                'FLT_APR_BLN02' => $FLT_APR_BLN02,
                'FLT_APR_BLN03' => $FLT_APR_BLN03,
                'FLT_APR_BLN04' => $FLT_APR_BLN04,
                'FLT_APR_BLN05' => $FLT_APR_BLN05,
                'FLT_APR_BLN06' => $FLT_APR_BLN06,
                'FLT_APR_BLN07' => $FLT_APR_BLN07,
                'FLT_APR_BLN08' => $FLT_APR_BLN08,
                'FLT_APR_BLN09' => $FLT_APR_BLN09,
                'FLT_APR_BLN10' => $FLT_APR_BLN10,
                'FLT_APR_BLN11' => $FLT_APR_BLN11,
                'FLT_APR_BLN12' => $FLT_APR_BLN12,
                //AMOUNT
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
                'INT_QTY_SUM' => $INT_QTY_SUM,
                'FLT_PRC_SUM' => $FLT_PRC_SUM,
                'FLT_RAT_SUM' => $FLT_RAT_SUM,
                'FLT_APR_SUM' => $FLT_APR_SUM,
                'MON_AMT_SUM' => $MON_AMT_SUM
            );
//SAVE TO DATABASE
            $this->budget_sales_m->save_temp($data);
        }
        redirect("budget/budget_sales_c/confirmation_budget_sales/$INT_ID_FISCAL_YEAR/$INT_ID_BUDGET_TYPE/$INT_DIV/$INT_DEPT/$INT_SECT/$CHR_BUDGET_TYPE/$INT_ID_BUDGET_CATEGORY", "REFRESH");
    }

    function confirmation_budget_sales($INT_ID_FISCAL_YEAR, $INT_ID_BUDGET_TYPE, $INT_DIV, $INT_DEPT, $INT_SECT, $CHR_BUDGET_TYPE, $INT_ID_BUDGET_CATEGORY) {
        $user_session = $this->session->all_userdata();

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(205);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Confirmation Budget Sales';
        $data['subcontent'] = NULL;
        if($INT_ID_BUDGET_CATEGORY == '16' || $INT_ID_BUDGET_CATEGORY == '17'){
            $data['content'] = 'budget/budget_sales/confirmation_budget_sales_product_v';
        } else if ($INT_ID_BUDGET_CATEGORY == '18' || $INT_ID_BUDGET_CATEGORY == '19'){
            $data['content'] = 'budget/budget_sales/confirmation_budget_sales_tooling_v';
        }

        $data['INT_ID_FISCAL_YEAR'] = $INT_ID_FISCAL_YEAR;
        $data['INT_ID_BUDGET_TYPE'] = $INT_ID_BUDGET_TYPE;
        $data['INT_ID_BUDGET_CATEGORY'] = $INT_ID_BUDGET_CATEGORY;
        $data['INT_DIV'] = $INT_DIV;
        $data['INT_DEPT'] = $INT_DEPT;
        $data['INT_SECT'] = $INT_SECT;
        $data['CHR_BUDGET_TYPE'] = $CHR_BUDGET_TYPE;
        $CHR_BUDGET_CATEGORY = $this->budgetcategory_m->get_init_budgetcategory($INT_ID_BUDGET_CATEGORY);
        $data['CHR_BUDGET_CATEGORY'] = $CHR_BUDGET_CATEGORY;

        //GET FISCAL YEAR
        $data['CHR_FISCAL_YEAR'] = $this->fiscal_m->select_fiscal_year($INT_ID_FISCAL_YEAR);
        //GET BUDGET TYPE
        $data['CHR_BUDGET_TYPE_DESC'] = $this->budgettype_m->get_desc_budgettype($INT_ID_BUDGET_TYPE);
        //GET DEPT
        $data['CHR_DEPT_DESC'] = $this->dept_m->get_name_dept($INT_DEPT);
        //GET SECTION 
        $data['CHR_SECTION_DESC'] = $this->section_m->get_desc_section($INT_SECT);
        //GET DETAIL BUDGET
        $data['detail_confirm'] = $this->budget_sales_m->get_detail_confirm_sales($INT_ID_FISCAL_YEAR, $CHR_BUDGET_TYPE, $CHR_BUDGET_CATEGORY, $INT_DIV, $INT_DEPT, $INT_SECT);
        $data['detail_confirm_sum'] = $this->budget_sales_m->get_sum_sales($INT_ID_FISCAL_YEAR, $CHR_BUDGET_TYPE, $CHR_BUDGET_CATEGORY, $INT_DIV, $INT_DEPT, $INT_SECT);
        //GET SUM AMOUNT
        $data['SUM_AMT'] = $this->budget_sales_m->get_sum_amt_confirm_sales($INT_ID_FISCAL_YEAR, $CHR_BUDGET_TYPE, $CHR_BUDGET_CATEGORY, $INT_DIV, $INT_DEPT, $INT_SECT);

        $this->load->view($this->layout, $data);
    }

    function save_budget($INT_ID_FISCAL_YEAR, $INT_ID_BUDGET_TYPE, $INT_DIV, $INT_DEPT, $INT_SECT, $CHR_BUDGET_TYPE, $INT_ID_BUDGET_CATEGORY, $CHR_STAT_REV) {
        $user_session = $this->session->all_userdata();
        $CHR_CREATE_BY = $user_session['USERNAME'];
        $CHR_CREATE_DATE = date("Ymd");
        $CHR_CREATE_TIME = date("his");
        $CHR_BUDGET_CATEGORY = $this->budgetcategory_m->get_init_budgetcategory($INT_ID_BUDGET_CATEGORY);

        //DELETE BUDGET TYPE FOR FISCAL YEAR 
        $this->budget_sales_m->delete_existing_budget($INT_ID_FISCAL_YEAR, $INT_ID_BUDGET_TYPE, $INT_DIV, $INT_DEPT, $INT_SECT, $CHR_BUDGET_TYPE, $CHR_BUDGET_CATEGORY, $CHR_STAT_REV);

        //CHECK SEQUNCE BUDGET NUMBER
        //GET BUDGET NUMBER
        //SAVE DATA FROM TABLE WORK TO TABLE TRANSACTION
        $detail_budget = $this->budget_sales_m->get_detail_confirm_sales($INT_ID_FISCAL_YEAR, $CHR_BUDGET_TYPE, $CHR_BUDGET_CATEGORY, $INT_DIV, $INT_DEPT, $INT_SECT);
        //ASSIGN TO ARRAY
        foreach ($detail_budget as $value) {
            $CHR_NO_BUDGET = $this->budget_sales_m->get_no_budget($INT_ID_FISCAL_YEAR, $INT_ID_BUDGET_TYPE, $INT_DIV, $INT_DEPT, $INT_SECT, $CHR_BUDGET_TYPE, $CHR_STAT_REV);
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
                'CHR_PART_NO' => $value->CHR_PART_NO,
                'CHR_PART_NAME' => $value->CHR_PART_NAME,
                'CHR_MATERIAL_NO' => $value->CHR_MATERIAL_NO,
                'CHR_PROJECT_NAME' => $value->CHR_PROJECT_NAME,
                'CHR_STATUS' => $value->CHR_STATUS,
                'CHR_PURPOSE' => $value->CHR_PURPOSE,
                'CHR_CUSTOMER_NAME' => $value->CHR_CUSTOMER_NAME,
                'CHR_DISTRIBUTION' => $value->CHR_DISTRIBUTION,
                'CHR_ORG_CURR' => $value->CHR_ORG_CURR,
                'CHR_CODE_UNIQ_CUSTOMER' => $value->CHR_CODE_UNIQ_CUSTOMER,
                'CHR_CODE_UNIQ_PRODUCT' => $value->CHR_CODE_UNIQ_PRODUCT,
                //QTY
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
                //PRICE ORG
                'FLT_PRC_BLN01' => $value->FLT_PRC_BLN01,
                'FLT_PRC_BLN02' => $value->FLT_PRC_BLN02,
                'FLT_PRC_BLN03' => $value->FLT_PRC_BLN03,
                'FLT_PRC_BLN04' => $value->FLT_PRC_BLN04,
                'FLT_PRC_BLN05' => $value->FLT_PRC_BLN05,
                'FLT_PRC_BLN06' => $value->FLT_PRC_BLN06,
                'FLT_PRC_BLN07' => $value->FLT_PRC_BLN07,
                'FLT_PRC_BLN08' => $value->FLT_PRC_BLN08,
                'FLT_PRC_BLN09' => $value->FLT_PRC_BLN09,
                'FLT_PRC_BLN10' => $value->FLT_PRC_BLN10,
                'FLT_PRC_BLN11' => $value->FLT_PRC_BLN11,
                'FLT_PRC_BLN12' => $value->FLT_PRC_BLN12,
                'FLT_PRC_SUM' => $value->FLT_PRC_SUM,
                //RATE
                'FLT_RAT_BLN01' => $value->FLT_RAT_BLN01,
                'FLT_RAT_BLN02' => $value->FLT_RAT_BLN02,
                'FLT_RAT_BLN03' => $value->FLT_RAT_BLN03,
                'FLT_RAT_BLN04' => $value->FLT_RAT_BLN04,
                'FLT_RAT_BLN05' => $value->FLT_RAT_BLN05,
                'FLT_RAT_BLN06' => $value->FLT_RAT_BLN06,
                'FLT_RAT_BLN07' => $value->FLT_RAT_BLN07,
                'FLT_RAT_BLN08' => $value->FLT_RAT_BLN08,
                'FLT_RAT_BLN09' => $value->FLT_RAT_BLN09,
                'FLT_RAT_BLN10' => $value->FLT_RAT_BLN10,
                'FLT_RAT_BLN11' => $value->FLT_RAT_BLN11,
                'FLT_RAT_BLN12' => $value->FLT_RAT_BLN12,
                'FLT_RAT_SUM' => $value->FLT_RAT_SUM,
                //APR
                'FLT_APR_BLN01' => $value->FLT_APR_BLN01,
                'FLT_APR_BLN02' => $value->FLT_APR_BLN02,
                'FLT_APR_BLN03' => $value->FLT_APR_BLN03,
                'FLT_APR_BLN04' => $value->FLT_APR_BLN04,
                'FLT_APR_BLN05' => $value->FLT_APR_BLN05,
                'FLT_APR_BLN06' => $value->FLT_APR_BLN06,
                'FLT_APR_BLN07' => $value->FLT_APR_BLN07,
                'FLT_APR_BLN08' => $value->FLT_APR_BLN08,
                'FLT_APR_BLN09' => $value->FLT_APR_BLN09,
                'FLT_APR_BLN10' => $value->FLT_APR_BLN10,
                'FLT_APR_BLN11' => $value->FLT_APR_BLN11,
                'FLT_APR_BLN12' => $value->FLT_APR_BLN12,
                'FLT_APR_SUM' => $value->FLT_APR_SUM,
                //AMOUNT
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
            $this->budget_sales_m->save($data);
        }

        //GET DETAIL BUDGET
        $data['detail_confirm'] = $this->budget_sales_m->get_detail_confirm_sales($INT_ID_FISCAL_YEAR, $CHR_BUDGET_TYPE, CHR_BUDGET_CATEGORY, $INT_DIV, $INT_DEPT, $INT_SECT);
        //GET SUM AMOUNT
        $data['SUM_AMT'] = $this->budget_sales_m->get_sum_amt_confirm_sales($INT_ID_FISCAL_YEAR, $CHR_BUDGET_TYPE, CHR_BUDGET_CATEGORY, $INT_DIV, $INT_DEPT, $INT_SECT);

        redirect("budget/budget_sales_c/create_sales/1/$INT_ID_FISCAL_YEAR/$INT_ID_BUDGET_TYPE/$INT_DIV/$INT_DEPT/$INT_SECT/$CHR_BUDGET_TYPE/$INT_ID_BUDGET_CATEGORY", "REFRESH");
        $this->load->view($this->layout, $data);
    }
    
    function refresh_table() {
        $INT_ID_FISCAL_YEAR = $this->input->post("INT_ID_FISCAL_YEAR");
        $INT_BUDGET_TYPE = '14';
        $INT_ID_BUDGET_CATEGORY = $this->input->post("ID_BUDGET_CATEGORY");        
        $CHR_BUDGET_TYPE = 'SALES';
        $CHR_BUDGET_CATEGORY = $this->budgetcategory_m->get_init_budgetcategory($INT_ID_BUDGET_CATEGORY);
        $INT_DEPT = $this->input->post("INT_DEPT");
        $INT_SECT = $this->input->post("INT_SECT");
        $get_gm_div = $this->dept_m->get_gm_div($INT_DEPT)->row();
        $INT_DIV = $get_gm_div->INT_ID_DIVISION;
        $url_iframe = site_url("budget/budget_sales_c/refresh_table_page/1/$INT_ID_FISCAL_YEAR/$INT_BUDGET_TYPE/$INT_DIV/$INT_DEPT/$INT_SECT/$CHR_BUDGET_TYPE/$CHR_BUDGET_CATEGORY");
        $url_export_excel = site_url("budget/budget_sales_c/download_excel/$INT_ID_FISCAL_YEAR/$INT_BUDGET_TYPE/$INT_DIV/$INT_DEPT/$INT_SECT/$CHR_BUDGET_TYPE/$CHR_BUDGET_CATEGORY");
        
        $status_approve_gm = $this->budget_sales_m->get_status_approve_gm($INT_ID_FISCAL_YEAR, $CHR_BUDGET_TYPE, $CHR_BUDGET_CATEGORY, $INT_DIV, $INT_DEPT);
        
        $data = array(
            'url_iframe' => $url_iframe,
            'url_export_excel' => $url_export_excel,
            'status_approve' => $status_approve_gm->CHR_FLAG_APP_GM
        );

//Either you can print value or you can send value to database
        echo json_encode($data);

        //echo site_url("budget/budget_sales_c/refresh_table_page/1/$INT_ID_FISCAL_YEAR/$INT_BUDGET_TYPE/$INT_DIV/$INT_DEPT/$INT_SECT/$CHR_BUDGET_TYPE/$CHR_BUDGET_CATEGORY");
    }

    function refresh_table_page($msg = null, $INT_ID_FISCAL_YEAR = null, $INT_ID_BUDGET_TYPE = null, $INT_DIV = null, $INT_DEPT = null, $INT_SECT = null, $CHR_BUDGET_TYPE = null, $CHR_BUDGET_CATEGORY = null) {
        $user_session = $this->session->all_userdata();

        $data['INT_ID_FISCAL_YEAR'] = $INT_ID_FISCAL_YEAR;
        $data['INT_ID_BUDGET_TYPE'] = $INT_ID_BUDGET_TYPE;
        $data['INT_DIV'] = $INT_DIV;
        $data['INT_DEPT'] = $INT_DEPT;
        $data['INT_SECT'] = $INT_SECT;
        $data['CHR_BUDGET_TYPE'] = $CHR_BUDGET_TYPE;
        $data['CHR_BUDGET_CATEGORY'] = $CHR_BUDGET_CATEGORY;

//GET DETAIL BUDGET
        if ($CHR_BUDGET_CATEGORY <> null) {
            $data['detail_confirm'] = $this->budget_sales_m->get_detail_sales($INT_ID_FISCAL_YEAR, $CHR_BUDGET_TYPE, $CHR_BUDGET_CATEGORY, $INT_DIV, $INT_DEPT, $INT_SECT);
            $data['detail_confirm_sum'] = $this->budget_sales_m->get_sum_sales($INT_ID_FISCAL_YEAR, $CHR_BUDGET_TYPE, $CHR_BUDGET_CATEGORY, $INT_DIV, $INT_DEPT, $INT_SECT);
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

        $data['title'] = 'Create Budget Sales';

        $data['subcontent'] = NULL;
        if($CHR_BUDGET_CATEGORY == 'SAL3001' || $CHR_BUDGET_CATEGORY == 'SAL3002'){
            $data['content'] = 'budget/budget_sales/refresh_budget_sales_product_v';
        } else {
            $data['content'] = 'budget/budget_sales/refresh_budget_sales_tooling_v';
        }        
        
        $kode_dept = $user_session['DEPT'];
        $data['kode_dept'] = $kode_dept;

        $this->load->view($this->layout_blank, $data);
    }
    
    function download_excel($INT_ID_FISCAL_YEAR = null, $INT_ID_BUDGET_TYPE = null, $INT_DIV = null, $INT_DEPT = null, $INT_SECT = null, $CHR_BUDGET_TYPE = null, $CHR_BUDGET_CATEGORY = null) {
        $row = 8;

        if ($CHR_BUDGET_CATEGORY <> null) {
            $detail_confirm = $this->budget_sales_m->get_detail_sales_dept($INT_ID_FISCAL_YEAR, $CHR_BUDGET_TYPE, $INT_DIV, $INT_DEPT, $INT_SECT, $CHR_BUDGET_CATEGORY);
            $detail_confirm_sum = $this->budget_sales_m->get_sum_sales_dept($INT_ID_FISCAL_YEAR, $CHR_BUDGET_TYPE, $INT_DIV, $INT_DEPT, $INT_SECT, $CHR_BUDGET_CATEGORY);
            $budget_desc = $this->budgettype_m->get_budget_type($INT_ID_BUDGET_TYPE);
            $budget_desc = strtoupper(trim($budget_desc->CHR_BUDGET_TYPE_DESC));

            $CHR_DEPT = trim($this->dept_m->get_name_dept($INT_DEPT));
            $CHR_DEPT_DESC = trim($this->dept_m->get_desc_dept($INT_DEPT));
            $CHR_FISCAL_YEAR_DESC = trim($this->fiscal_m->select_fiscal_year($INT_ID_FISCAL_YEAR));

            $this->load->library('excel');
            $objReader = PHPExcel_IOFactory::createReader('Excel5');
            // Create new PHPExcel object
            
            if($CHR_BUDGET_CATEGORY == 'SAL3001' || $CHR_BUDGET_CATEGORY == 'SAL3002'){
                $objPHPExcel = $objReader->load("assets/template/budget/report/Template_Report_Sales_Product.xls");
            } else {
                $objPHPExcel = $objReader->load("assets/template/budget/report/Template_Report_Sales_Tooling.xls");
            }

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
                $CHR_PURPOSE = $value->CHR_PURPOSE;
                $CHR_STATUS = $value->CHR_STATUS;
                $CHR_MATERIAL_NO = $value->CHR_MATERIAL_NO;
                $CHR_PART_NO = $value->CHR_PART_NO;
                $CHR_PART_NAME = $value->CHR_PART_NAME;
                $CHR_DISTRIBUTION = $value->CHR_DISTRIBUTION;
                $CHR_CUSTOMER_NAME = $value->CHR_CUSTOMER_NAME;
                $CHR_PROJECT_NAME = $value->CHR_PROJECT_NAME;
                $CHR_ORG_CURR = $value->CHR_ORG_CURR;
                $CHR_CODE_UNIQ_CUSTOMER = $value->CHR_CODE_UNIQ_CUSTOMER;
                $CHR_CODE_UNIQ_PRODUCT = $value->CHR_CODE_UNIQ_PRODUCT;
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
                $FLT_PRC_BLN01 = $value->FLT_PRC_BLN01;
                $FLT_PRC_BLN02 = $value->FLT_PRC_BLN02;
                $FLT_PRC_BLN03 = $value->FLT_PRC_BLN03;
                $FLT_PRC_BLN04 = $value->FLT_PRC_BLN04;
                $FLT_PRC_BLN05 = $value->FLT_PRC_BLN05;
                $FLT_PRC_BLN06 = $value->FLT_PRC_BLN06;
                $FLT_PRC_BLN07 = $value->FLT_PRC_BLN07;
                $FLT_PRC_BLN08 = $value->FLT_PRC_BLN08;
                $FLT_PRC_BLN09 = $value->FLT_PRC_BLN09;
                $FLT_PRC_BLN10 = $value->FLT_PRC_BLN10;
                $FLT_PRC_BLN11 = $value->FLT_PRC_BLN11;
                $FLT_PRC_BLN12 = $value->FLT_PRC_BLN12;
                $FLT_PRC_SUM = $value->FLT_PRC_SUM;
                $FLT_RAT_BLN01 = $value->FLT_RAT_BLN01;
                $FLT_RAT_BLN02 = $value->FLT_RAT_BLN02;
                $FLT_RAT_BLN03 = $value->FLT_RAT_BLN03;
                $FLT_RAT_BLN04 = $value->FLT_RAT_BLN04;
                $FLT_RAT_BLN05 = $value->FLT_RAT_BLN05;
                $FLT_RAT_BLN06 = $value->FLT_RAT_BLN06;
                $FLT_RAT_BLN07 = $value->FLT_RAT_BLN07;
                $FLT_RAT_BLN08 = $value->FLT_RAT_BLN08;
                $FLT_RAT_BLN09 = $value->FLT_RAT_BLN09;
                $FLT_RAT_BLN10 = $value->FLT_RAT_BLN10;
                $FLT_RAT_BLN11 = $value->FLT_RAT_BLN11;
                $FLT_RAT_BLN12 = $value->FLT_RAT_BLN12;
                $FLT_RAT_SUM = $value->FLT_RAT_SUM;
                $FLT_APR_BLN01 = $value->FLT_APR_BLN01;
                $FLT_APR_BLN02 = $value->FLT_APR_BLN02;
                $FLT_APR_BLN03 = $value->FLT_APR_BLN03;
                $FLT_APR_BLN04 = $value->FLT_APR_BLN04;
                $FLT_APR_BLN05 = $value->FLT_APR_BLN05;
                $FLT_APR_BLN06 = $value->FLT_APR_BLN06;
                $FLT_APR_BLN07 = $value->FLT_APR_BLN07;
                $FLT_APR_BLN08 = $value->FLT_APR_BLN08;
                $FLT_APR_BLN09 = $value->FLT_APR_BLN09;
                $FLT_APR_BLN10 = $value->FLT_APR_BLN10;
                $FLT_APR_BLN11 = $value->FLT_APR_BLN11;
                $FLT_APR_BLN12 = $value->FLT_APR_BLN12;
                $FLT_APR_SUM = $value->FLT_APR_SUM;
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
                $objPHPExcel->getActiveSheet()->setCellValue("H$row", "$CHR_PART_NO");
                $objPHPExcel->getActiveSheet()->setCellValue("I$row", "$CHR_MATERIAL_NO");
                $objPHPExcel->getActiveSheet()->setCellValue("J$row", "$CHR_PART_NAME");
                $objPHPExcel->getActiveSheet()->setCellValue("K$row", "$CHR_STATUS");
                $objPHPExcel->getActiveSheet()->setCellValue("L$row", "$CHR_PROJECT_NAME");
                $objPHPExcel->getActiveSheet()->setCellValue("M$row", "$CHR_DISTRIBUTION");
                $objPHPExcel->getActiveSheet()->setCellValue("N$row", "$CHR_PURPOSE");
                $objPHPExcel->getActiveSheet()->setCellValue("O$row", "$CHR_CUSTOMER_NAME");
                $objPHPExcel->getActiveSheet()->setCellValue("P$row", "$CHR_ORG_CURR");
                $objPHPExcel->getActiveSheet()->setCellValue("Q$row", "$CHR_CODE_UNIQ_CUSTOMER");
                $objPHPExcel->getActiveSheet()->setCellValue("R$row", "$CHR_CODE_UNIQ_PRODUCT");
                
                $objPHPExcel->getActiveSheet()->setCellValue("S$row", "$INT_QTY_BLN04");
                $objPHPExcel->getActiveSheet()->setCellValue("T$row", "$FLT_PRC_BLN04");
                $objPHPExcel->getActiveSheet()->setCellValue("U$row", "$FLT_RAT_BLN04");
                $objPHPExcel->getActiveSheet()->setCellValue("V$row", "$FLT_APR_BLN04");
                $objPHPExcel->getActiveSheet()->setCellValue("W$row", "$MON_AMT_BLN04");
                
                $objPHPExcel->getActiveSheet()->setCellValue("X$row", "$INT_QTY_BLN05");
                $objPHPExcel->getActiveSheet()->setCellValue("Y$row", "$FLT_PRC_BLN05");
                $objPHPExcel->getActiveSheet()->setCellValue("Z$row", "$FLT_RAT_BLN05");
                $objPHPExcel->getActiveSheet()->setCellValue("AA$row", "$FLT_APR_BLN05");
                $objPHPExcel->getActiveSheet()->setCellValue("AB$row", "$MON_AMT_BLN05");
                
                $objPHPExcel->getActiveSheet()->setCellValue("AC$row", "$INT_QTY_BLN06");
                $objPHPExcel->getActiveSheet()->setCellValue("AD$row", "$FLT_PRC_BLN06");
                $objPHPExcel->getActiveSheet()->setCellValue("AE$row", "$FLT_RAT_BLN06");
                $objPHPExcel->getActiveSheet()->setCellValue("AF$row", "$FLT_APR_BLN06");
                $objPHPExcel->getActiveSheet()->setCellValue("AG$row", "$MON_AMT_BLN06");
                
                $objPHPExcel->getActiveSheet()->setCellValue("AH$row", "$INT_QTY_BLN07");
                $objPHPExcel->getActiveSheet()->setCellValue("AI$row", "$FLT_PRC_BLN07");
                $objPHPExcel->getActiveSheet()->setCellValue("AJ$row", "$FLT_RAT_BLN07");
                $objPHPExcel->getActiveSheet()->setCellValue("AK$row", "$FLT_APR_BLN07");
                $objPHPExcel->getActiveSheet()->setCellValue("AL$row", "$MON_AMT_BLN07");
                
                $objPHPExcel->getActiveSheet()->setCellValue("AM$row", "$INT_QTY_BLN08");
                $objPHPExcel->getActiveSheet()->setCellValue("AN$row", "$FLT_PRC_BLN08");
                $objPHPExcel->getActiveSheet()->setCellValue("AO$row", "$FLT_RAT_BLN08");
                $objPHPExcel->getActiveSheet()->setCellValue("AP$row", "$FLT_APR_BLN08");
                $objPHPExcel->getActiveSheet()->setCellValue("AQ$row", "$MON_AMT_BLN08");
                
                $objPHPExcel->getActiveSheet()->setCellValue("AR$row", "$INT_QTY_BLN09");
                $objPHPExcel->getActiveSheet()->setCellValue("AS$row", "$FLT_PRC_BLN09");
                $objPHPExcel->getActiveSheet()->setCellValue("AT$row", "$FLT_RAT_BLN09");
                $objPHPExcel->getActiveSheet()->setCellValue("AU$row", "$FLT_APR_BLN09");
                $objPHPExcel->getActiveSheet()->setCellValue("AV$row", "$MON_AMT_BLN09");
                
                $objPHPExcel->getActiveSheet()->setCellValue("AW$row", "$INT_QTY_BLN10");
                $objPHPExcel->getActiveSheet()->setCellValue("AX$row", "$FLT_PRC_BLN10");
                $objPHPExcel->getActiveSheet()->setCellValue("AY$row", "$FLT_RAT_BLN10");
                $objPHPExcel->getActiveSheet()->setCellValue("AZ$row", "$FLT_APR_BLN10");
                $objPHPExcel->getActiveSheet()->setCellValue("BA$row", "$MON_AMT_BLN10");
                
                $objPHPExcel->getActiveSheet()->setCellValue("BB$row", "$INT_QTY_BLN11");
                $objPHPExcel->getActiveSheet()->setCellValue("BC$row", "$FLT_PRC_BLN11");
                $objPHPExcel->getActiveSheet()->setCellValue("BD$row", "$FLT_RAT_BLN11");
                $objPHPExcel->getActiveSheet()->setCellValue("BE$row", "$FLT_APR_BLN11");
                $objPHPExcel->getActiveSheet()->setCellValue("BF$row", "$MON_AMT_BLN11");
                
                $objPHPExcel->getActiveSheet()->setCellValue("BG$row", "$INT_QTY_BLN12");
                $objPHPExcel->getActiveSheet()->setCellValue("BH$row", "$FLT_PRC_BLN12");
                $objPHPExcel->getActiveSheet()->setCellValue("BI$row", "$FLT_RAT_BLN12");
                $objPHPExcel->getActiveSheet()->setCellValue("BJ$row", "$FLT_APR_BLN12");
                $objPHPExcel->getActiveSheet()->setCellValue("BK$row", "$MON_AMT_BLN12");
                
                $objPHPExcel->getActiveSheet()->setCellValue("BL$row", "$INT_QTY_BLN01");
                $objPHPExcel->getActiveSheet()->setCellValue("BM$row", "$FLT_PRC_BLN01");
                $objPHPExcel->getActiveSheet()->setCellValue("BN$row", "$FLT_RAT_BLN01");
                $objPHPExcel->getActiveSheet()->setCellValue("BO$row", "$FLT_APR_BLN01");
                $objPHPExcel->getActiveSheet()->setCellValue("BP$row", "$MON_AMT_BLN01");
                
                $objPHPExcel->getActiveSheet()->setCellValue("BQ$row", "$INT_QTY_BLN02");
                $objPHPExcel->getActiveSheet()->setCellValue("BR$row", "$FLT_PRC_BLN02");
                $objPHPExcel->getActiveSheet()->setCellValue("BS$row", "$FLT_RAT_BLN02");
                $objPHPExcel->getActiveSheet()->setCellValue("BT$row", "$FLT_APR_BLN02");
                $objPHPExcel->getActiveSheet()->setCellValue("BU$row", "$MON_AMT_BLN02");
                
                $objPHPExcel->getActiveSheet()->setCellValue("BV$row", "$INT_QTY_BLN03");
                $objPHPExcel->getActiveSheet()->setCellValue("BW$row", "$FLT_PRC_BLN03");
                $objPHPExcel->getActiveSheet()->setCellValue("BX$row", "$FLT_RAT_BLN03");
                $objPHPExcel->getActiveSheet()->setCellValue("BY$row", "$FLT_APR_BLN03");
                $objPHPExcel->getActiveSheet()->setCellValue("BZ$row", "$MON_AMT_BLN03");
                
                $objPHPExcel->getActiveSheet()->setCellValue("CA$row", "$INT_QTY_SUM");
                $objPHPExcel->getActiveSheet()->setCellValue("CB$row", "$FLT_PRC_SUM");
                $objPHPExcel->getActiveSheet()->setCellValue("CC$row", "$FLT_RAT_SUM");
                $objPHPExcel->getActiveSheet()->setCellValue("CD$row", "$FLT_APR_SUM");
                $objPHPExcel->getActiveSheet()->setCellValue("CE$row", "$MON_AMT_SUM");

                $seq++;
                $row++;
            }
//            $objPHPExcel->getActiveSheet()->getStyle("B8:BG$row")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $objPHPExcel->getActiveSheet()->getStyle("B8:CE$row")->applyFromArray(array(
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                )
            ));
            $row++;
            $row_min = $row - 1;
            $objPHPExcel->getActiveSheet()->setCellValue("S$row", "=SUM(S8:S$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("T$row", "=SUM(T8:T$row_min)");
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
            $objPHPExcel->getActiveSheet()->setCellValue("BH$row", "=SUM(BH8:BH$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("BI$row", "=SUM(BI8:BI$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("BJ$row", "=SUM(BJ8:BJ$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("BK$row", "=SUM(BK8:BK$row_min)");
            
            $objPHPExcel->getActiveSheet()->setCellValue("BL$row", "=SUM(BL8:BL$row_min)");            
            $objPHPExcel->getActiveSheet()->setCellValue("BM$row", "=SUM(BM8:BM$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("BN$row", "=SUM(BN8:BN$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("BO$row", "=SUM(BO8:BO$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("BP$row", "=SUM(BP8:BP$row_min)");
            
            $objPHPExcel->getActiveSheet()->setCellValue("BQ$row", "=SUM(BQ8:BQ$row_min)");            
            $objPHPExcel->getActiveSheet()->setCellValue("BR$row", "=SUM(BR8:BR$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("BS$row", "=SUM(BS8:BS$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("BT$row", "=SUM(BT8:BT$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("BU$row", "=SUM(BU8:BU$row_min)");
            
            $objPHPExcel->getActiveSheet()->setCellValue("BV$row", "=SUM(BV8:BV$row_min)");            
            $objPHPExcel->getActiveSheet()->setCellValue("BW$row", "=SUM(BW8:BW$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("BX$row", "=SUM(BX8:BX$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("BY$row", "=SUM(BY8:BY$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("BZ$row", "=SUM(BZ8:BZ$row_min)");
            
            $objPHPExcel->getActiveSheet()->setCellValue("CA$row", "=SUM(CA8:CA$row_min)");            
            $objPHPExcel->getActiveSheet()->setCellValue("CB$row", "=SUM(CB8:CB$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("CC$row", "=SUM(CC8:CC$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("CD$row", "=SUM(CD8:CD$row_min)");
            $objPHPExcel->getActiveSheet()->setCellValue("CE$row", "=SUM(CE8:CE$row_min)");
            
            $objPHPExcel->getActiveSheet()->getStyle("B8:CE$row")->applyFromArray(array(
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
            if($CHR_BUDGET_CATEGORY == 'SAL3001' || $CHR_BUDGET_CATEGORY == 'SAL3002'){
                $objDrawing->setCoordinates("BZ$row");
            } else {
                $objDrawing->setCoordinates("BF$row");
            }
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
    
    function download_excel_for_approve($INT_ID_FISCAL_YEAR = null, $INT_DIV = null, $INT_GROUP = null, $INT_DEPT = null, $INT_ID_BUDGET_CATEGORY = null) {
        $CHR_BUDGET_CATEGORY = $this->budgetcategory_m->get_init_budgetcategory($INT_ID_BUDGET_CATEGORY);
        if ($CHR_BUDGET_CATEGORY <> null) {
            
            $CHR_DEPT = trim($this->dept_m->get_name_dept($INT_DEPT));
            $CHR_DEPT_DESC = trim($this->dept_m->get_desc_dept($INT_DEPT));
            $CHR_FISCAL_YEAR_DESC = trim($this->fiscal_m->select_fiscal_year($INT_ID_FISCAL_YEAR));

            $this->load->library('excel');
            $objReader = PHPExcel_IOFactory::createReader('Excel5');
            // Create new PHPExcel object
            
            if($CHR_BUDGET_CATEGORY == 'SAL3001' || $CHR_BUDGET_CATEGORY == 'SAL3002'){
                $objPHPExcel = $objReader->load("assets/template/budget/report/Template_Approval_Sales_Product.xls");
                
                //================== SALES BY PRODUCT ============================//
                $sub_category = $this->budget_sales_m->get_subcategory_sales($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);

                $row = 8;
                $active_sheet = $objPHPExcel->setActiveSheetIndexByName('PRODUCT');
                $active_sheet->setCellValue("B2", "MASTER BUDGET : SALES BY PRODUCT TAHUN " . $CHR_FISCAL_YEAR_DESC);
                $active_sheet->setCellValue("B3", "DEPARTMENT : " . $CHR_DEPT . " - " . $CHR_DEPT_DESC);

                $tot_qty04_all = 0;
                $tot_qty05_all = 0;
                $tot_qty06_all = 0;
                $tot_qty07_all = 0;
                $tot_qty08_all = 0;
                $tot_qty09_all = 0;
                $tot_qty10_all = 0;
                $tot_qty11_all = 0;
                $tot_qty12_all = 0;
                $tot_qty01_all = 0;
                $tot_qty02_all = 0;
                $tot_qty03_all = 0;
                $tot_qty_all = 0;
                $tot_bln04_all = 0;
                $tot_bln05_all = 0;
                $tot_bln06_all = 0;
                $tot_bln07_all = 0;
                $tot_bln08_all = 0;
                $tot_bln09_all = 0;
                $tot_bln10_all = 0;
                $tot_bln11_all = 0;
                $tot_bln12_all = 0;
                $tot_bln01_all = 0;
                $tot_bln02_all = 0;
                $tot_bln03_all = 0;
                $tot_sum_all = 0;

                foreach($sub_category as $sub){
                    $CHR_SUB_CATEGORY = $sub->CHR_BUDGET_SUB_CATEGORY;
                    $detail_confirm = $this->budget_sales_m->get_sales_by_subcategory($INT_ID_FISCAL_YEAR, $INT_DIV, $INT_GROUP, $INT_DEPT, $CHR_BUDGET_CATEGORY, $CHR_SUB_CATEGORY);

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
                    $tot_qty = 0;
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

                    foreach ($detail_confirm as $value) {
                        $CHR_BUDGET_SUB_CATEGORY_DESC = $value->CHR_BUDGET_SUB_CATEGORY_DESC;
                        $CHR_PURPOSE = $value->CHR_PURPOSE;
                        $CHR_CODE_UNIQ_PRODUCT = $value->CHR_CODE_UNIQ_PRODUCT; 
                        $INT_QTY_BLN01 = $value->INT_QTY_BLN01;
                        $MON_AMT_BLN01 = $value->MON_AMT_BLN01;
                        $INT_QTY_BLN02 = $value->INT_QTY_BLN02;
                        $MON_AMT_BLN02 = $value->MON_AMT_BLN02;
                        $INT_QTY_BLN03 = $value->INT_QTY_BLN03;
                        $MON_AMT_BLN03 = $value->MON_AMT_BLN03;
                        $INT_QTY_BLN04 = $value->INT_QTY_BLN04;
                        $MON_AMT_BLN04 = $value->MON_AMT_BLN04;
                        $INT_QTY_BLN05 = $value->INT_QTY_BLN05;
                        $MON_AMT_BLN05 = $value->MON_AMT_BLN05;
                        $INT_QTY_BLN06 = $value->INT_QTY_BLN06;
                        $MON_AMT_BLN06 = $value->MON_AMT_BLN06;
                        $INT_QTY_BLN07 = $value->INT_QTY_BLN07;
                        $MON_AMT_BLN07 = $value->MON_AMT_BLN07;
                        $INT_QTY_BLN08 = $value->INT_QTY_BLN08;
                        $MON_AMT_BLN08 = $value->MON_AMT_BLN08;
                        $INT_QTY_BLN09 = $value->INT_QTY_BLN09;
                        $MON_AMT_BLN09 = $value->MON_AMT_BLN09;
                        $INT_QTY_BLN10 = $value->INT_QTY_BLN10;
                        $MON_AMT_BLN10 = $value->MON_AMT_BLN10;
                        $INT_QTY_BLN11 = $value->INT_QTY_BLN11;
                        $MON_AMT_BLN11 = $value->MON_AMT_BLN11;
                        $INT_QTY_BLN12 = $value->INT_QTY_BLN12;
                        $MON_AMT_BLN12 = $value->MON_AMT_BLN12;
                        $INT_QTY_SUM = $value->INT_QTY_SUM;
                        $MON_AMT_SUM = $value->MON_AMT_SUM;

                        $active_sheet->setCellValue("B$row", "$CHR_BUDGET_SUB_CATEGORY_DESC");
                        $active_sheet->setCellValue("C$row", "$CHR_PURPOSE");
                        $active_sheet->setCellValue("D$row", "$CHR_CODE_UNIQ_PRODUCT");
                        $active_sheet->setCellValue("E$row", "$INT_QTY_BLN04");
                        $active_sheet->setCellValue("F$row", "$MON_AMT_BLN04");
                        $active_sheet->setCellValue("G$row", "$INT_QTY_BLN05");
                        $active_sheet->setCellValue("H$row", "$MON_AMT_BLN05");
                        $active_sheet->setCellValue("I$row", "$INT_QTY_BLN06");
                        $active_sheet->setCellValue("J$row", "$MON_AMT_BLN06");
                        $active_sheet->setCellValue("K$row", "$INT_QTY_BLN07");
                        $active_sheet->setCellValue("L$row", "$MON_AMT_BLN07");
                        $active_sheet->setCellValue("M$row", "$INT_QTY_BLN08");
                        $active_sheet->setCellValue("N$row", "$MON_AMT_BLN08");
                        $active_sheet->setCellValue("O$row", "$INT_QTY_BLN09");
                        $active_sheet->setCellValue("P$row", "$MON_AMT_BLN09");
                        $active_sheet->setCellValue("Q$row", "$INT_QTY_BLN10");
                        $active_sheet->setCellValue("R$row", "$MON_AMT_BLN10");
                        $active_sheet->setCellValue("S$row", "$INT_QTY_BLN11");
                        $active_sheet->setCellValue("T$row", "$MON_AMT_BLN11");
                        $active_sheet->setCellValue("U$row", "$INT_QTY_BLN12");
                        $active_sheet->setCellValue("V$row", "$MON_AMT_BLN12");
                        $active_sheet->setCellValue("W$row", "$INT_QTY_BLN01");
                        $active_sheet->setCellValue("X$row", "$MON_AMT_BLN01");
                        $active_sheet->setCellValue("Y$row", "$INT_QTY_BLN02");
                        $active_sheet->setCellValue("Z$row", "$MON_AMT_BLN02");
                        $active_sheet->setCellValue("AA$row", "$INT_QTY_BLN03");
                        $active_sheet->setCellValue("AB$row", "$MON_AMT_BLN03");
                        $active_sheet->setCellValue("AC$row", "$INT_QTY_SUM");
                        $active_sheet->setCellValue("AD$row", "$MON_AMT_SUM");

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
                        $tot_qty = $tot_qty + $INT_QTY_SUM;
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

                    $active_sheet->getStyle("B8:AD$row")->applyFromArray(array(
                        'borders' => array(
                            'allborders' => array(
                                'style' => PHPExcel_Style_Border::BORDER_THIN
                            )
                        )
                    ));

                    $active_sheet->setCellValue("E$row", $tot_qty04);
                    $active_sheet->setCellValue("F$row", $tot_bln04);
                    $active_sheet->setCellValue("G$row", $tot_qty05);
                    $active_sheet->setCellValue("H$row", $tot_bln05);
                    $active_sheet->setCellValue("I$row", $tot_qty06);
                    $active_sheet->setCellValue("J$row", $tot_bln06);
                    $active_sheet->setCellValue("K$row", $tot_qty07);
                    $active_sheet->setCellValue("L$row", $tot_bln07);
                    $active_sheet->setCellValue("M$row", $tot_qty08);
                    $active_sheet->setCellValue("N$row", $tot_bln08);
                    $active_sheet->setCellValue("O$row", $tot_qty09);
                    $active_sheet->setCellValue("P$row", $tot_bln09);
                    $active_sheet->setCellValue("Q$row", $tot_qty10);
                    $active_sheet->setCellValue("R$row", $tot_bln10);
                    $active_sheet->setCellValue("S$row", $tot_qty11);
                    $active_sheet->setCellValue("T$row", $tot_bln11);
                    $active_sheet->setCellValue("U$row", $tot_qty12);
                    $active_sheet->setCellValue("V$row", $tot_bln12);
                    $active_sheet->setCellValue("Q$row", $tot_qty01);
                    $active_sheet->setCellValue("X$row", $tot_bln01);
                    $active_sheet->setCellValue("Y$row", $tot_qty02);
                    $active_sheet->setCellValue("Z$row", $tot_bln02);
                    $active_sheet->setCellValue("AA$row", $tot_qty03);
                    $active_sheet->setCellValue("AB$row", $tot_bln03);
                    $active_sheet->setCellValue("AC$row", $tot_qty);
                    $active_sheet->setCellValue("AD$row", $tot_sum);

                    $active_sheet->getStyle("B8:AD$row")->applyFromArray(array(
                        'borders' => array(
                            'allborders' => array(
                                'style' => PHPExcel_Style_Border::BORDER_THIN
                            )
                        ),
                    ));

                    $active_sheet->mergeCells("B$row:D$row");
                    $active_sheet->setCellValue("B$row", "TOTAL");
                    $active_sheet->getStyle("B$row:AD$row")->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('#CCCCCC');

                    $active_sheet->getStyle("B$row:AD$row")->applyFromArray(array(
                        'font' => array(
                            'bold' => true,
                            'size' => 12
                        )
                    ));

                    $tot_qty04_all = $tot_qty04_all + $tot_qty04;
                    $tot_qty05_all = $tot_qty05_all + $tot_qty05;
                    $tot_qty06_all = $tot_qty06_all + $tot_qty06;
                    $tot_qty07_all = $tot_qty07_all + $tot_qty07;
                    $tot_qty08_all = $tot_qty08_all + $tot_qty08;
                    $tot_qty09_all = $tot_qty09_all + $tot_qty09;
                    $tot_qty10_all = $tot_qty10_all + $tot_qty10;
                    $tot_qty11_all = $tot_qty11_all + $tot_qty11;
                    $tot_qty12_all = $tot_qty12_all + $tot_qty12;
                    $tot_qty01_all = $tot_qty01_all + $tot_qty01;
                    $tot_qty02_all = $tot_qty02_all + $tot_qty02;
                    $tot_qty03_all = $tot_qty03_all + $tot_qty03;
                    $tot_qty_all = $tot_qty_all + $tot_qty;
                    $tot_bln04_all = $tot_bln04_all + $tot_bln04;
                    $tot_bln05_all = $tot_bln05_all + $tot_bln05;
                    $tot_bln06_all = $tot_bln06_all + $tot_bln06;
                    $tot_bln07_all = $tot_bln07_all + $tot_bln07;
                    $tot_bln08_all = $tot_bln08_all + $tot_bln08;
                    $tot_bln09_all = $tot_bln09_all + $tot_bln09;
                    $tot_bln10_all = $tot_bln10_all + $tot_bln10;
                    $tot_bln11_all = $tot_bln11_all + $tot_bln11;
                    $tot_bln12_all = $tot_bln12_all + $tot_bln12;
                    $tot_bln01_all = $tot_bln01_all + $tot_bln01;
                    $tot_bln02_all = $tot_bln02_all + $tot_bln02;
                    $tot_bln03_all = $tot_bln03_all + $tot_bln03;
                    $tot_sum_all = $tot_sum_all + $tot_sum;

                    $row = $row + 1;
                }

                $active_sheet->setCellValue("E$row", $tot_qty04_all);
                $active_sheet->setCellValue("F$row", $tot_bln04_all);
                $active_sheet->setCellValue("G$row", $tot_qty05_all);
                $active_sheet->setCellValue("H$row", $tot_bln05_all);
                $active_sheet->setCellValue("I$row", $tot_qty06_all);
                $active_sheet->setCellValue("J$row", $tot_bln06_all);
                $active_sheet->setCellValue("K$row", $tot_qty07_all);
                $active_sheet->setCellValue("L$row", $tot_bln07_all);
                $active_sheet->setCellValue("M$row", $tot_qty08_all);
                $active_sheet->setCellValue("N$row", $tot_bln08_all);
                $active_sheet->setCellValue("O$row", $tot_qty09_all);
                $active_sheet->setCellValue("P$row", $tot_bln09_all);
                $active_sheet->setCellValue("Q$row", $tot_qty10_all);
                $active_sheet->setCellValue("R$row", $tot_bln10_all);
                $active_sheet->setCellValue("S$row", $tot_qty11_all);
                $active_sheet->setCellValue("T$row", $tot_bln11_all);
                $active_sheet->setCellValue("U$row", $tot_qty12_all);
                $active_sheet->setCellValue("V$row", $tot_bln12_all);
                $active_sheet->setCellValue("W$row", $tot_qty01_all);
                $active_sheet->setCellValue("X$row", $tot_bln01_all);
                $active_sheet->setCellValue("Y$row", $tot_qty02_all);
                $active_sheet->setCellValue("Z$row", $tot_bln02_all);
                $active_sheet->setCellValue("AA$row", $tot_qty03_all);
                $active_sheet->setCellValue("AB$row", $tot_bln03_all);
                $active_sheet->setCellValue("AC$row", $tot_qty_all);
                $active_sheet->setCellValue("AD$row", $tot_sum_all);

                $active_sheet->getStyle("B8:AD$row")->applyFromArray(array(
                    'borders' => array(
                        'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                        )
                    ),
                ));

                $active_sheet->mergeCells("B$row:D$row");
                $active_sheet->setCellValue("B$row", "GRAND TOTAL");
                $active_sheet->getStyle("B$row:AD$row")->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('#CCCCCC');

                $active_sheet->getStyle("B$row:AD$row")->applyFromArray(array(
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
                $objDrawing->setCoordinates("Y$row");

                $objDrawing->setWorksheet($active_sheet);
                //================== END SALES BY PRODUCT ========================//

                //================== SALES BY CUSTOMER ============================// 
                $purpose = $this->budget_sales_m->get_purpose_sales($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY);
                $row = 8;
                $active_sheet = $objPHPExcel->setActiveSheetIndexByName('CUSTOMER');
                $active_sheet->setCellValue("B2", "MASTER BUDGET : SALES BY CUSTOMER TAHUN " . $CHR_FISCAL_YEAR_DESC);
                $active_sheet->setCellValue("B3", "DEPARTMENT : " . $CHR_DEPT . " - " . $CHR_DEPT_DESC);

                $tot_qty04_all = 0;
                $tot_qty05_all = 0;
                $tot_qty06_all = 0;
                $tot_qty07_all = 0;
                $tot_qty08_all = 0;
                $tot_qty09_all = 0;
                $tot_qty10_all = 0;
                $tot_qty11_all = 0;
                $tot_qty12_all = 0;
                $tot_qty01_all = 0;
                $tot_qty02_all = 0;
                $tot_qty03_all = 0;
                $tot_qty_all = 0;
                $tot_bln04_all = 0;
                $tot_bln05_all = 0;
                $tot_bln06_all = 0;
                $tot_bln07_all = 0;
                $tot_bln08_all = 0;
                $tot_bln09_all = 0;
                $tot_bln10_all = 0;
                $tot_bln11_all = 0;
                $tot_bln12_all = 0;
                $tot_bln01_all = 0;
                $tot_bln02_all = 0;
                $tot_bln03_all = 0;
                $tot_sum_all = 0;

                foreach($purpose as $sub){
                    $CHR_PURPOSE = $sub->CHR_PURPOSE;
                    $detail_confirm = $this->budget_sales_m->get_sales_by_purpose($INT_ID_FISCAL_YEAR, $INT_DIV, $INT_GROUP, $INT_DEPT, $CHR_BUDGET_CATEGORY, $CHR_PURPOSE);

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
                    $tot_qty = 0;
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

                    foreach ($detail_confirm as $value) {
                        $CHR_BUDGET_SUB_CATEGORY_DESC = $value->CHR_BUDGET_SUB_CATEGORY_DESC;
                        $CHR_PURPOSE = $value->CHR_PURPOSE;
                        $CHR_CODE_UNIQ_CUSTOMER = $value->CHR_CODE_UNIQ_CUSTOMER;
                        $CHR_CUSTOMER_NAME = $value->CHR_CUSTOMER_NAME;
                        $INT_QTY_BLN01 = $value->INT_QTY_BLN01;
                        $MON_AMT_BLN01 = $value->MON_AMT_BLN01;
                        $INT_QTY_BLN02 = $value->INT_QTY_BLN02;
                        $MON_AMT_BLN02 = $value->MON_AMT_BLN02;
                        $INT_QTY_BLN03 = $value->INT_QTY_BLN03;
                        $MON_AMT_BLN03 = $value->MON_AMT_BLN03;
                        $INT_QTY_BLN04 = $value->INT_QTY_BLN04;
                        $MON_AMT_BLN04 = $value->MON_AMT_BLN04;
                        $INT_QTY_BLN05 = $value->INT_QTY_BLN05;
                        $MON_AMT_BLN05 = $value->MON_AMT_BLN05;
                        $INT_QTY_BLN06 = $value->INT_QTY_BLN06;
                        $MON_AMT_BLN06 = $value->MON_AMT_BLN06;
                        $INT_QTY_BLN07 = $value->INT_QTY_BLN07;
                        $MON_AMT_BLN07 = $value->MON_AMT_BLN07;
                        $INT_QTY_BLN08 = $value->INT_QTY_BLN08;
                        $MON_AMT_BLN08 = $value->MON_AMT_BLN08;
                        $INT_QTY_BLN09 = $value->INT_QTY_BLN09;
                        $MON_AMT_BLN09 = $value->MON_AMT_BLN09;
                        $INT_QTY_BLN10 = $value->INT_QTY_BLN10;
                        $MON_AMT_BLN10 = $value->MON_AMT_BLN10;
                        $INT_QTY_BLN11 = $value->INT_QTY_BLN11;
                        $MON_AMT_BLN11 = $value->MON_AMT_BLN11;
                        $INT_QTY_BLN12 = $value->INT_QTY_BLN12;
                        $MON_AMT_BLN12 = $value->MON_AMT_BLN12;
                        $INT_QTY_SUM = $value->INT_QTY_SUM;
                        $MON_AMT_SUM = $value->MON_AMT_SUM;

                        $active_sheet->setCellValue("B$row", "$CHR_PURPOSE");
                        $active_sheet->setCellValue("C$row", "$CHR_CUSTOMER_NAME");
                        $active_sheet->setCellValue("D$row", "$CHR_CODE_UNIQ_CUSTOMER");
                        $active_sheet->setCellValue("E$row", "$INT_QTY_BLN04");
                        $active_sheet->setCellValue("F$row", "$MON_AMT_BLN04");
                        $active_sheet->setCellValue("G$row", "$INT_QTY_BLN05");
                        $active_sheet->setCellValue("H$row", "$MON_AMT_BLN05");
                        $active_sheet->setCellValue("I$row", "$INT_QTY_BLN06");
                        $active_sheet->setCellValue("J$row", "$MON_AMT_BLN06");
                        $active_sheet->setCellValue("K$row", "$INT_QTY_BLN07");
                        $active_sheet->setCellValue("L$row", "$MON_AMT_BLN07");
                        $active_sheet->setCellValue("M$row", "$INT_QTY_BLN08");
                        $active_sheet->setCellValue("N$row", "$MON_AMT_BLN08");
                        $active_sheet->setCellValue("O$row", "$INT_QTY_BLN09");
                        $active_sheet->setCellValue("P$row", "$MON_AMT_BLN09");
                        $active_sheet->setCellValue("Q$row", "$INT_QTY_BLN10");
                        $active_sheet->setCellValue("R$row", "$MON_AMT_BLN10");
                        $active_sheet->setCellValue("S$row", "$INT_QTY_BLN11");
                        $active_sheet->setCellValue("T$row", "$MON_AMT_BLN11");
                        $active_sheet->setCellValue("U$row", "$INT_QTY_BLN12");
                        $active_sheet->setCellValue("V$row", "$MON_AMT_BLN12");
                        $active_sheet->setCellValue("W$row", "$INT_QTY_BLN01");
                        $active_sheet->setCellValue("X$row", "$MON_AMT_BLN01");
                        $active_sheet->setCellValue("Y$row", "$INT_QTY_BLN02");
                        $active_sheet->setCellValue("Z$row", "$MON_AMT_BLN02");
                        $active_sheet->setCellValue("AA$row", "$INT_QTY_BLN03");
                        $active_sheet->setCellValue("AB$row", "$MON_AMT_BLN03");
                        $active_sheet->setCellValue("AC$row", "$INT_QTY_SUM");
                        $active_sheet->setCellValue("AD$row", "$MON_AMT_SUM");

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
                        $tot_qty = $tot_qty + $INT_QTY_SUM;
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

                    $active_sheet->getStyle("B8:AD$row")->applyFromArray(array(
                        'borders' => array(
                            'allborders' => array(
                                'style' => PHPExcel_Style_Border::BORDER_THIN
                            )
                        )
                    ));

                    $active_sheet->setCellValue("E$row", $tot_qty04);
                    $active_sheet->setCellValue("F$row", $tot_bln04);
                    $active_sheet->setCellValue("G$row", $tot_qty05);
                    $active_sheet->setCellValue("H$row", $tot_bln05);
                    $active_sheet->setCellValue("I$row", $tot_qty06);
                    $active_sheet->setCellValue("J$row", $tot_bln06);
                    $active_sheet->setCellValue("K$row", $tot_qty07);
                    $active_sheet->setCellValue("L$row", $tot_bln07);
                    $active_sheet->setCellValue("M$row", $tot_qty08);
                    $active_sheet->setCellValue("N$row", $tot_bln08);
                    $active_sheet->setCellValue("O$row", $tot_qty09);
                    $active_sheet->setCellValue("P$row", $tot_bln09);
                    $active_sheet->setCellValue("Q$row", $tot_qty10);
                    $active_sheet->setCellValue("R$row", $tot_bln10);
                    $active_sheet->setCellValue("S$row", $tot_qty11);
                    $active_sheet->setCellValue("T$row", $tot_bln11);
                    $active_sheet->setCellValue("U$row", $tot_qty12);
                    $active_sheet->setCellValue("V$row", $tot_bln12);
                    $active_sheet->setCellValue("Q$row", $tot_qty01);
                    $active_sheet->setCellValue("X$row", $tot_bln01);
                    $active_sheet->setCellValue("Y$row", $tot_qty02);
                    $active_sheet->setCellValue("Z$row", $tot_bln02);
                    $active_sheet->setCellValue("AA$row", $tot_qty03);
                    $active_sheet->setCellValue("AB$row", $tot_bln03);
                    $active_sheet->setCellValue("AC$row", $tot_qty);
                    $active_sheet->setCellValue("AD$row", $tot_sum);

                    $active_sheet->getStyle("B8:AD$row")->applyFromArray(array(
                        'borders' => array(
                            'allborders' => array(
                                'style' => PHPExcel_Style_Border::BORDER_THIN
                            )
                        ),
                    ));

                    $active_sheet->mergeCells("B$row:D$row");
                    $active_sheet->setCellValue("B$row", "TOTAL");
                    $active_sheet->getStyle("B$row:AD$row")->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('#CCCCCC');

                    $active_sheet->getStyle("B$row:AD$row")->applyFromArray(array(
                        'font' => array(
                            'bold' => true,
                            'size' => 12
                        )
                    ));

                    $tot_qty04_all = $tot_qty04_all + $tot_qty04;
                    $tot_qty05_all = $tot_qty05_all + $tot_qty05;
                    $tot_qty06_all = $tot_qty06_all + $tot_qty06;
                    $tot_qty07_all = $tot_qty07_all + $tot_qty07;
                    $tot_qty08_all = $tot_qty08_all + $tot_qty08;
                    $tot_qty09_all = $tot_qty09_all + $tot_qty09;
                    $tot_qty10_all = $tot_qty10_all + $tot_qty10;
                    $tot_qty11_all = $tot_qty11_all + $tot_qty11;
                    $tot_qty12_all = $tot_qty12_all + $tot_qty12;
                    $tot_qty01_all = $tot_qty01_all + $tot_qty01;
                    $tot_qty02_all = $tot_qty02_all + $tot_qty02;
                    $tot_qty03_all = $tot_qty03_all + $tot_qty03;
                    $tot_qty_all = $tot_qty_all + $tot_qty;
                    $tot_bln04_all = $tot_bln04_all + $tot_bln04;
                    $tot_bln05_all = $tot_bln05_all + $tot_bln05;
                    $tot_bln06_all = $tot_bln06_all + $tot_bln06;
                    $tot_bln07_all = $tot_bln07_all + $tot_bln07;
                    $tot_bln08_all = $tot_bln08_all + $tot_bln08;
                    $tot_bln09_all = $tot_bln09_all + $tot_bln09;
                    $tot_bln10_all = $tot_bln10_all + $tot_bln10;
                    $tot_bln11_all = $tot_bln11_all + $tot_bln11;
                    $tot_bln12_all = $tot_bln12_all + $tot_bln12;
                    $tot_bln01_all = $tot_bln01_all + $tot_bln01;
                    $tot_bln02_all = $tot_bln02_all + $tot_bln02;
                    $tot_bln03_all = $tot_bln03_all + $tot_bln03;
                    $tot_sum_all = $tot_sum_all + $tot_sum;

                    $row = $row + 1;
                }

                $active_sheet->setCellValue("E$row", $tot_qty04_all);
                $active_sheet->setCellValue("F$row", $tot_bln04_all);
                $active_sheet->setCellValue("G$row", $tot_qty05_all);
                $active_sheet->setCellValue("H$row", $tot_bln05_all);
                $active_sheet->setCellValue("I$row", $tot_qty06_all);
                $active_sheet->setCellValue("J$row", $tot_bln06_all);
                $active_sheet->setCellValue("K$row", $tot_qty07_all);
                $active_sheet->setCellValue("L$row", $tot_bln07_all);
                $active_sheet->setCellValue("M$row", $tot_qty08_all);
                $active_sheet->setCellValue("N$row", $tot_bln08_all);
                $active_sheet->setCellValue("O$row", $tot_qty09_all);
                $active_sheet->setCellValue("P$row", $tot_bln09_all);
                $active_sheet->setCellValue("Q$row", $tot_qty10_all);
                $active_sheet->setCellValue("R$row", $tot_bln10_all);
                $active_sheet->setCellValue("S$row", $tot_qty11_all);
                $active_sheet->setCellValue("T$row", $tot_bln11_all);
                $active_sheet->setCellValue("U$row", $tot_qty12_all);
                $active_sheet->setCellValue("V$row", $tot_bln12_all);
                $active_sheet->setCellValue("W$row", $tot_qty01_all);
                $active_sheet->setCellValue("X$row", $tot_bln01_all);
                $active_sheet->setCellValue("Y$row", $tot_qty02_all);
                $active_sheet->setCellValue("Z$row", $tot_bln02_all);
                $active_sheet->setCellValue("AA$row", $tot_qty03_all);
                $active_sheet->setCellValue("AB$row", $tot_bln03_all);
                $active_sheet->setCellValue("AC$row", $tot_qty_all);
                $active_sheet->setCellValue("AD$row", $tot_sum_all);

                $active_sheet->getStyle("B8:AD$row")->applyFromArray(array(
                    'borders' => array(
                        'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                        )
                    ),
                ));

                $active_sheet->mergeCells("B$row:D$row");
                $active_sheet->setCellValue("B$row", "GRAND TOTAL");
                $active_sheet->getStyle("B$row:AD$row")->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('#CCCCCC');

                $active_sheet->getStyle("B$row:AD$row")->applyFromArray(array(
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
                $objDrawing->setCoordinates("Y$row");

                $objDrawing->setWorksheet($active_sheet);
                //================== END SALES BY PRODUCT ========================//
            
            } else {
                $objPHPExcel = $objReader->load("assets/template/budget/report/Template_Approval_Sales_Tooling.xls");
                
                $row = 8;
                $active_sheet = $objPHPExcel->getActiveSheet();
                $active_sheet->setCellValue("B2", "MASTER BUDGET : SALES TOOLING TAHUN " . $CHR_FISCAL_YEAR_DESC);
                $active_sheet->setCellValue("B3", "DEPARTMENT : " . $CHR_DEPT . " - " . $CHR_DEPT_DESC);
                
                $detail_confirm = $this->budget_sales_m->get_sales_tooling($INT_ID_FISCAL_YEAR, $INT_DIV, $INT_GROUP, $INT_DEPT, $CHR_BUDGET_CATEGORY);
                
                foreach ($detail_confirm as $value) {                    
                    $CHR_BUDGET_SUB_CATEGORY = $value->CHR_BUDGET_SUB_CATEGORY;
                    $CHR_BUDGET_SUB_CATEGORY_DESC = $value->CHR_BUDGET_SUB_CATEGORY_DESC;
                    $CHR_PROJECT_NAME = $value->CHR_PROJECT_NAME;
                    $CHR_CUSTOMER_NAME = $value->CHR_CUSTOMER_NAME;                
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
                   
                    $objPHPExcel->getActiveSheet()->setCellValue("B$row", "$CHR_BUDGET_SUB_CATEGORY_DESC");
                    $objPHPExcel->getActiveSheet()->setCellValue("C$row", "$CHR_PROJECT_NAME");
                    $objPHPExcel->getActiveSheet()->setCellValue("D$row", "$CHR_CUSTOMER_NAME");
                    $objPHPExcel->getActiveSheet()->setCellValue("E$row", "$MON_AMT_BLN04");
                    $objPHPExcel->getActiveSheet()->setCellValue("F$row", "$MON_AMT_BLN05");
                    $objPHPExcel->getActiveSheet()->setCellValue("G$row", "$MON_AMT_BLN06");
                    $objPHPExcel->getActiveSheet()->setCellValue("H$row", "$MON_AMT_BLN07");
                    $objPHPExcel->getActiveSheet()->setCellValue("I$row", "$MON_AMT_BLN08");
                    $objPHPExcel->getActiveSheet()->setCellValue("J$row", "$MON_AMT_BLN09");
                    $objPHPExcel->getActiveSheet()->setCellValue("K$row", "$MON_AMT_BLN10");
                    $objPHPExcel->getActiveSheet()->setCellValue("L$row", "$MON_AMT_BLN11");
                    $objPHPExcel->getActiveSheet()->setCellValue("M$row", "$MON_AMT_BLN12");
                    $objPHPExcel->getActiveSheet()->setCellValue("N$row", "$MON_AMT_BLN01");
                    $objPHPExcel->getActiveSheet()->setCellValue("O$row", "$MON_AMT_BLN02");
                    $objPHPExcel->getActiveSheet()->setCellValue("P$row", "$MON_AMT_BLN03");
                    $objPHPExcel->getActiveSheet()->setCellValue("Q$row", "$MON_AMT_SUM");

                    $row++;
                }

                $objPHPExcel->getActiveSheet()->getStyle("B8:Q$row")->applyFromArray(array(
                    'borders' => array(
                        'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                        )
                    )
                ));

                $row_min = $row - 1;
                $objPHPExcel->getActiveSheet()->setCellValue("E$row", "=SUM(E8:E$row_min)");
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
                $objPHPExcel->getActiveSheet()->getStyle("B8:Q$row")->applyFromArray(array(
                    'borders' => array(
                        'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                        )
                    ),
                ));
                $objPHPExcel->getActiveSheet()->mergeCells("B$row:D$row");
                $objPHPExcel->getActiveSheet()->setCellValue("B$row", "TOTAL");
                $objPHPExcel->getActiveSheet()->getStyle("B$row:Q$row")->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('#CCCCCC');
                $objPHPExcel->getActiveSheet()->getStyle("B$row:Q$row")->applyFromArray(array(
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
                //================== END SALES BY PRODUCT ========================//
            }            
            
            ob_end_clean();
            $filename = "$CHR_FISCAL_YEAR_DESC - SALES - $CHR_DEPT.xls";
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