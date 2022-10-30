<?php

class budget_dimat_c extends CI_Controller {

    private $layout = '/template/head';
    private $layout_blank = '/template/head_blank';
    private $back_to_upload = 'budget/budget_dimat_c/create_dimat/';
    private $back_to_manage = 'budget/budget_dimat_c/index/';

    public function __construct() {
        parent::__construct();
        $this->load->model('budget/budget_dimat_m');
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
    
    //=========================== NEW UPDATE 10/07/2017 ======================//

    function create_dimat($msg = null, $INT_ID_FISCAL_YEAR = null, $INT_ID_BUDGET_TYPE = null, $INT_DIV = null, $INT_DEPT = null, $INT_SECT = null, $CHR_BUDGET_TYPE = null) {
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
        $data['INT_ID_BUDGET_TYPE'] = 48;
        $data['INT_DIV'] = $INT_DIV = 1;
        $data['INT_DEPT'] = $INT_DEPT = 1;
        $data['INT_SECT'] = $INT_SECT = 2;
        $data['CHR_BUDGET_TYPE'] = 'DIMAT';

//GET DETAIL BUDGET
        if ($CHR_BUDGET_TYPE <> null) {
            $data['url_page'] = site_url("budget/budget_dimat_c/refresh_table_page/1/$INT_ID_FISCAL_YEAR/$INT_ID_BUDGET_TYPE/$INT_DIV/$INT_DEPT/$INT_SECT/$CHR_BUDGET_TYPE");
        } else {
            $data['url_page'] = "";
        }

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(212);
        $data['news'] = $this->news_m->get_news();
        $data['msg'] = $msg;
        $data['data_fiscal'] = $this->fiscal_m->get_all_fiscal();
        
        $data['title'] = 'Create Budget Direct Material';
        $data['content'] = 'budget/budget_dimat/create_budget_dimat_v';       
        
        $data['CHR_DIV'] = $this->division_m->get_desc_division($INT_DIV);
        $data['CHR_DEPT'] = $this->dept_m->get_desc_dept($INT_DEPT);
        $data['CHR_SECT'] = $this->section_m->get_desc_section($INT_SECT);
        
        $session = $this->session->all_userdata();
        $user_session = $this->session->all_userdata();
        $user = $this->user_m->get_user_org($user_session['NPK']);
        $data['role'] = $user_session['ROLE'];

        $data['data_budget_type'] = $this->budgettype_m->get_budgettype();
        $this->load->view($this->layout, $data);
    }
    
    function prepare_approve_dimat($msg = null, $INT_ID_FISCAL_YEAR = null, $INT_DIV = null, $INT_GROUP = null, $INT_DEPT = null) {
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
        $data['INT_DIV'] = $INT_DIV = 1;
        $data['INT_GROUP'] = $INT_GROUP = 1;
        $data['INT_DEPT'] = $INT_DEPT = 1;          
        
        $data['CHR_DIV'] = $this->division_m->get_desc_division($INT_DIV);
        $data['CHR_GROUP'] = $this->groupdept_m->get_desc_groupdept($INT_GROUP);
        $data['CHR_DEPT'] = $this->dept_m->get_desc_dept($INT_DEPT);
        
        if($INT_ID_FISCAL_YEAR <> null){
            $data['url_page'] = site_url("budget/budget_dimat_c/refresh_detail_table_page/1/$INT_ID_FISCAL_YEAR/$INT_DIV/$INT_GROUP/$INT_DEPT");
        } else {
            $data['url_page'] = "";
        }
                
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(215);
        $data['news'] = $this->news_m->get_news();
        $data['data_fiscal'] = $this->fiscal_m->get_all_fiscal();         

        $data['title'] = 'Approval for Planning Direct Material';
        $data['msg'] = $msg;        

        $session = $this->session->all_userdata();
        $user_session = $this->session->all_userdata();
        //$user = $this->user_m->get_user_org($user_session['NPK']);
        $data['role'] = $user_session['ROLE'];
        
        $data['content'] = 'budget/budget_dimat/approval_budget_dimat_v';
        
        $this->load->view($this->layout, $data);
    }
    
    function refresh_detail_table() {
        $INT_ID_FISCAL_YEAR = $this->input->post("INT_ID_FISCAL_YEAR");
        $INT_DEPT = $this->input->post("INT_DEPT");
        $INT_DIV = $this->input->post("INT_DIV");
        $INT_GROUP = $this->input->post("INT_GROUP");
        
        $url_iframe = site_url("budget/budget_dimat_c/refresh_detail_table_page/1/$INT_ID_FISCAL_YEAR/$INT_DIV/$INT_GROUP/$INT_DEPT");
        $url_export_excel = site_url("budget/budget_dimat_c/download_excel_for_approve/$INT_ID_FISCAL_YEAR/$INT_DIV/$INT_GROUP/$INT_DEPT");

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

        $data['INT_ID_FISCAL_YEAR'] = $INT_ID_FISCAL_YEAR;
        $data['INT_DIV'] = $INT_DIV;
        $data['INT_GROUP'] = $INT_GROUP;
        $data['INT_DEPT'] = $INT_DEPT;

        $data['content'] = 'budget/budget_dimat/refresh_detail_budget_dimat_v';
        
        $data['summary_dimat'] = $this->budget_dimat_m->get_summary_dimat($INT_ID_FISCAL_YEAR, $INT_DIV, $INT_GROUP, $INT_DEPT);
        $data['summary_dimat_total'] = $this->budget_dimat_m->get_summary_dimat_total($INT_ID_FISCAL_YEAR, $INT_DIV, $INT_GROUP, $INT_DEPT);

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(215);
        $data['news'] = $this->news_m->get_news();
        $data['msg'] = $msg;

        $data['title'] = 'Approval Budget Direct Material';

        $this->load->view($this->layout_blank, $data);
    }

    function approve_budget_dimat() {
        $user_session = $this->session->all_userdata();

        $INT_ID_FISCAL_YEAR = $this->input->post('INT_ID_FISCAL_YEAR');
        $INT_DIV = 1;
        $INT_GROUP = 1;
        $INT_DEPT = 1;
        
        // $CHR_STAT_REV = 'NEW';
        $CHR_STAT_REV = 'RMB';

        if ($_POST["btn-save"] == 'man') {
            $app_man = $this->db;
            $app_man->trans_begin();

            $app_man->query("UPDATE CPL.TT_BUDGET_DIRECT_MATERIAL SET CHR_FLAG_APP_MAN = '1'
                            WHERE (INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR')
                                    AND (CHR_STAT_REV = '$CHR_STAT_REV')
                                    AND (INT_DIV = '$INT_DIV')
                                    AND (INT_GROUP_DEPT = '$INT_GROUP')
                                    AND (INT_DEPT = '$INT_DEPT')");

            $app_man->trans_complete();

            if ($app_man->trans_status() === FALSE) {
                $app_man->trans_rollback();
                redirect("budget/budget_dimat_c/prepare_approve_dimat/12/$INT_ID_FISCAL_YEAR/$INT_DIV/$INT_GROUP/$INT_DEPT");
            } else {
                $app_man->trans_commit();
                redirect("budget/budget_dimat_c/prepare_approve_dimat/6/$INT_ID_FISCAL_YEAR/$INT_DIV/$INT_GROUP/$INT_DEPT");
            }
        } else if ($_POST["btn-save"] == 'gm') {
            $app_gm = $this->db;
            $app_gm->trans_start();

            $app_gm->query("UPDATE CPL.TT_BUDGET_DIRECT_MATERIAL SET CHR_FLAG_APP_GM = '1'
                            WHERE (INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR')
                                    AND (CHR_STAT_REV = '$CHR_STAT_REV')
                                    AND (INT_DIV = '$INT_DIV')
                                    AND (INT_GROUP_DEPT = '$INT_GROUP')
                                    AND (INT_DEPT = '$INT_DEPT')");

            $app_gm->trans_complete();

            if ($app_gm->trans_status() === FALSE) {
                $app_gm->trans_rollback();
                redirect("budget/budget_dimat_c/prepare_approve_dimat/12/$INT_ID_FISCAL_YEAR/$INT_DIV/$INT_GROUP/$INT_DEPT");
            } else {
                $app_gm->trans_commit();
                redirect("budget/budget_dimat_c/prepare_approve_dimat/6/$INT_ID_FISCAL_YEAR/$INT_DIV/$INT_GROUP/$INT_DEPT");
            }
        } else if ($_POST["btn-save"] == 'dir') {
            $app_dir = $this->db;
            $app_dir->trans_start();

            $app_dir->query("UPDATE CPL.TT_BUDGET_DIRECT_MATERIAL SET CHR_FLAG_APP_DIR = '1'
                            WHERE (INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR')
                                    AND (CHR_STAT_REV = '$CHR_STAT_REV')
                                    AND (INT_DIV = '$INT_DIV')
                                    AND (INT_GROUP_DEPT = '$INT_GROUP')
                                    AND (INT_DEPT = '$INT_DEPT')");

            $app_dir->trans_complete();

            if ($app_dir->trans_status() === FALSE) {
                $app_dir->trans_rollback();
                redirect("budget/budget_dimat_c/prepare_approve_dimat/12/$INT_ID_FISCAL_YEAR/$INT_DIV/$INT_GROUP/$INT_DEPT");
            } else {
                $app_dir->trans_commit();
                redirect("budget/budget_dimat_c/prepare_approve_dimat/6/$INT_ID_FISCAL_YEAR/$INT_DIV/$INT_GROUP/$INT_DEPT");
            }
        } else if ($_POST["btn-save"] == 'all') {
            $app_all = $this->db;
            $app_all->trans_start();

            $app_all->query("UPDATE CPL.TT_BUDGET_DIRECT_MATERIAL SET CHR_FLAG_APP_MAN = '1', CHR_FLAG_APP_GM = '1', CHR_FLAG_APP_DIR = '1', CHR_FLAG_APP_COMPLETE = '1'
                            WHERE (INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR')
                                    AND (CHR_STAT_REV = '$CHR_STAT_REV')
                                    AND (INT_DIV = '$INT_DIV')
                                    AND (INT_GROUP_DEPT = '$INT_GROUP')
                                    AND (INT_DEPT = '$INT_DEPT')");

            $app_all->trans_complete();

            if ($app_all->trans_status() === FALSE) {
                $app_all->trans_rollback();
                redirect("budget/budget_dimat_c/prepare_approve_dimat/12/$INT_ID_FISCAL_YEAR/$INT_DIV/$INT_GROUP/$INT_DEPT");
            } else {
                $app_all->trans_commit();
                redirect("budget/budget_dimat_c/prepare_approve_dimat/6/$INT_ID_FISCAL_YEAR/$INT_DIV/$INT_GROUP/$INT_DEPT");
            }
        } else if ($_POST["btn-save"] == 'reject') {
            $app_all = $this->db;
            $app_all->trans_start();

            $app_all->query("UPDATE CPL.TT_BUDGET_DIRECT_MATERIAL SET CHR_FLAG_APP_MAN = '0', CHR_FLAG_APP_GM = '0', CHR_FLAG_APP_DIR = '0', CHR_FLAG_APP_COMPLETE = '0'
                            WHERE (INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR')
                                    AND (CHR_STAT_REV = '$CHR_STAT_REV')
                                    AND (INT_DIV = '$INT_DIV')
                                    AND (INT_GROUP_DEPT = '$INT_GROUP')
                                    AND (INT_DEPT = '$INT_DEPT')");

            $app_all->trans_complete();

            if ($app_all->trans_status() === FALSE) {
                $app_all->trans_rollback();
                redirect("budget/budget_dimat_c/prepare_approve_dimat/12/$INT_ID_FISCAL_YEAR/$INT_DIV/$INT_GROUP/$INT_DEPT");
            } else {
                $app_all->trans_commit();
                redirect("budget/budget_dimat_c/prepare_approve_dimat/7/$INT_ID_FISCAL_YEAR/$INT_DIV/$INT_GROUP/$INT_DEPT");
            }
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

    function download_template($budget_type) {
        $this->load->helper('download');
        $filename = 'Template_Direct_Material';
        
        ob_clean();
        $name = $filename.'.xls';
        $data = file_get_contents("assets/template/budget/$filename.xls");

        force_download($name, $data);
    }

    function upload_budget_dimat() {
        $this->load->helper(array('form', 'url', 'inflector'));
        $this->load->library(array('PHPExcel', 'PHPExcel/IOFactory'));
        $INT_ID_FISCAL_YEAR = $this->input->post("INT_ID_FISCAL_YEAR");
        $INT_ID_FISCAL_YEAR = substr($INT_ID_FISCAL_YEAR, 0, 4);
        $INT_DEPT = $this->input->post("INT_ID_DEPT");
        $INT_SECT = $this->input->post("INT_ID_SECT");
        $INT_ID_BUDGET_TYPE = 48;
        $CHR_BUDGET_TYPE_DESC = $this->budgettype_m->get_budget_type($INT_ID_BUDGET_TYPE);
        $CHR_BUDGET_TYPE = trim($CHR_BUDGET_TYPE_DESC->CHR_BUDGET_TYPE);
        $CHR_BUDGET_TYPE_DESC = trim($CHR_BUDGET_TYPE_DESC->CHR_BUDGET_TYPE_DESC);
        $budget_type_desc_format = str_replace(" ", "_", $CHR_BUDGET_TYPE_DESC);
        $get_gm_div = $this->dept_m->get_gm_div($INT_DEPT)->row();
        $INT_DIV = $get_gm_div->INT_ID_DIVISION;

        //delete existing template
        $this->budget_dimat_m->delete_existing_template($CHR_BUDGET_TYPE, $INT_DIV, $INT_DEPT, $INT_SECT);

        $upload_date = date('Ymd');
        $fileName = $_FILES['upload_budget_dimat']['name'];
        if (empty($fileName)) {
            redirect($this->back_to_upload . $msg = 12);
        }

        //file untuk submit file excel
        $config['upload_path'] = './assets/file/budget_direct_material/';
        $config['file_name'] = $fileName;
        $config['allowed_types'] = 'xls|xlsx';
        $config['max_size'] = 10000;

        //code for upload with ci
        $this->load->library('upload');
        $this->upload->initialize($config);
        if ($a = $this->upload->do_upload('upload_budget_dimat'))
            $this->upload->display_errors();
        $media = $this->upload->data('upload_budget_dimat');
        //cek apakah template sesuai dengan pilihan tipe budget?
        if (strpos($media['file_name'], str_replace(" ", "_", $CHR_BUDGET_TYPE_DESC)) === false) {
        //jika template tidak sesuai dengan tipe budget

            redirect($this->back_to_upload . $msg = 16);
        }

        $inputFileName = './assets/file/budget_direct_material/' . $media['file_name'];

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
        $budget_type_template = strtolower($rowHeader[0][99]);
        if ($budget_type_template !== strtolower($CHR_BUDGET_TYPE_DESC)) {
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

            //===============================   DIRECT MATERIAL   =============================== 
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
            //=============================== END DIRECT MATERIAL =============================== 
            
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
            $this->budget_dimat_m->save_temp($data);
        }
        redirect("budget/budget_dimat_c/confirmation_budget_dimat/$INT_ID_FISCAL_YEAR/$INT_ID_BUDGET_TYPE/$INT_DIV/$INT_DEPT/$INT_SECT/$CHR_BUDGET_TYPE", "REFRESH");
    }

    function confirmation_budget_dimat($INT_ID_FISCAL_YEAR, $INT_ID_BUDGET_TYPE, $INT_DIV, $INT_DEPT, $INT_SECT, $CHR_BUDGET_TYPE) {
        $user_session = $this->session->all_userdata();

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(205);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Confirmation Budget Direct Material';
        $data['subcontent'] = NULL;
        $data['content'] = 'budget/budget_dimat/confirmation_budget_dimat_v';

        $data['INT_ID_FISCAL_YEAR'] = $INT_ID_FISCAL_YEAR;
        $data['INT_ID_BUDGET_TYPE'] = $INT_ID_BUDGET_TYPE;
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
        $data['detail_confirm'] = $this->budget_dimat_m->get_detail_confirm_dimat($INT_ID_FISCAL_YEAR, $CHR_BUDGET_TYPE, $INT_DIV, $INT_DEPT, $INT_SECT);
        $data['detail_confirm_sum'] = $this->budget_dimat_m->get_sum_dimat($INT_ID_FISCAL_YEAR, $CHR_BUDGET_TYPE, $INT_DIV, $INT_DEPT, $INT_SECT);
        //GET SUM AMOUNT
        $data['SUM_AMT'] = $this->budget_dimat_m->get_sum_amt_confirm_dimat($INT_ID_FISCAL_YEAR, $CHR_BUDGET_TYPE, $INT_DIV, $INT_DEPT, $INT_SECT);

        $this->load->view($this->layout, $data);
    }

    function save_budget($INT_ID_FISCAL_YEAR, $INT_ID_BUDGET_TYPE, $INT_DIV, $INT_DEPT, $INT_SECT, $CHR_BUDGET_TYPE, $CHR_STAT_REV) {
        $user_session = $this->session->all_userdata();
        $CHR_CREATE_BY = $user_session['USERNAME'];
        $CHR_CREATE_DATE = date("Ymd");
        $CHR_CREATE_TIME = date("his");

        //DELETE BUDGET TYPE FOR FISCAL YEAR 
        $this->budget_dimat_m->delete_existing_budget($INT_ID_FISCAL_YEAR, $INT_ID_BUDGET_TYPE, $INT_DIV, $INT_DEPT, $INT_SECT, $CHR_BUDGET_TYPE, $CHR_STAT_REV);

        //CHECK SEQUNCE BUDGET NUMBER
        //GET BUDGET NUMBER
        //SAVE DATA FROM TABLE WORK TO TABLE TRANSACTION
        $detail_budget = $this->budget_dimat_m->get_detail_confirm_dimat($INT_ID_FISCAL_YEAR, $CHR_BUDGET_TYPE, $INT_DIV, $INT_DEPT, $INT_SECT);
        //ASSIGN TO ARRAY
        foreach ($detail_budget as $value) {
            $CHR_NO_BUDGET = $this->budget_dimat_m->get_no_budget($INT_ID_FISCAL_YEAR, $INT_ID_BUDGET_TYPE, $INT_DIV, $INT_DEPT, $INT_SECT, $CHR_BUDGET_TYPE, $CHR_STAT_REV);
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
            $this->budget_dimat_m->save($data);
        }

        //GET DETAIL BUDGET
        $data['detail_confirm'] = $this->budget_dimat_m->get_detail_confirm_dimat($INT_ID_FISCAL_YEAR, $CHR_BUDGET_TYPE, $INT_DIV, $INT_DEPT, $INT_SECT);
        //GET SUM AMOUNT
        $data['SUM_AMT'] = $this->budget_dimat_m->get_sum_amt_confirm_dimat($INT_ID_FISCAL_YEAR, $CHR_BUDGET_TYPE, $INT_DIV, $INT_DEPT, $INT_SECT);

        redirect("budget/budget_dimat_c/create_dimat/1/$INT_ID_FISCAL_YEAR/$INT_ID_BUDGET_TYPE/$INT_DIV/$INT_DEPT/$INT_SECT/$CHR_BUDGET_TYPE", "REFRESH");
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
        $url_iframe = site_url("budget/budget_dimat_c/refresh_table_page/1/$INT_ID_FISCAL_YEAR/$INT_BUDGET_TYPE/$INT_DIV/$INT_DEPT/$INT_SECT/$CHR_BUDGET_TYPE");
        $url_export_excel = site_url("budget/budget_dimat_c/download_excel/$INT_ID_FISCAL_YEAR/$INT_BUDGET_TYPE/$INT_DIV/$INT_DEPT/$INT_SECT/$CHR_BUDGET_TYPE");
        
        $status_approve_gm = $this->budget_dimat_m->get_status_approve_gm($INT_ID_FISCAL_YEAR, $CHR_BUDGET_TYPE, $INT_DIV, $INT_DEPT);
        
        $data = array(
            'url_iframe' => $url_iframe,
            'url_export_excel' => $url_export_excel,
            'status_approve' => $status_approve_gm->CHR_FLAG_APP_GM
        );

//Either you can print value or you can send value to database
        echo json_encode($data);

        //echo site_url("budget/budget_dimat_c/refresh_table_page/1/$INT_ID_FISCAL_YEAR/$INT_BUDGET_TYPE/$INT_DIV/$INT_DEPT/$INT_SECT/$CHR_BUDGET_TYPE");
    }

    function refresh_table_page($msg = null, $INT_ID_FISCAL_YEAR = null, $INT_ID_BUDGET_TYPE = null, $INT_DIV = null, $INT_DEPT = null, $INT_SECT = null, $CHR_BUDGET_TYPE = null) {
        $user_session = $this->session->all_userdata();

        $data['INT_ID_FISCAL_YEAR'] = $INT_ID_FISCAL_YEAR;
        $data['INT_ID_BUDGET_TYPE'] = $INT_ID_BUDGET_TYPE;
        $data['INT_DIV'] = $INT_DIV;
        $data['INT_DEPT'] = $INT_DEPT;
        $data['INT_SECT'] = $INT_SECT;
        $data['CHR_BUDGET_TYPE'] = $CHR_BUDGET_TYPE;
        
//GET DETAIL BUDGET
        if ($CHR_BUDGET_TYPE <> null) {
            $data['detail_confirm'] = $this->budget_dimat_m->get_detail_dimat($INT_ID_FISCAL_YEAR, $CHR_BUDGET_TYPE, $INT_DIV, $INT_DEPT, $INT_SECT);
            $data['detail_confirm_sum'] = $this->budget_dimat_m->get_sum_dimat($INT_ID_FISCAL_YEAR, $CHR_BUDGET_TYPE, $INT_DIV, $INT_DEPT, $INT_SECT);
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

        $data['title'] = 'Create Budget Direct Material';

        $data['subcontent'] = NULL;
        $data['content'] = 'budget/budget_dimat/refresh_budget_dimat_v';
        
        $data['budget_type'] = $this->budgettype_m->get_budget_type_expense_by_amount();
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
        $row = 8;

        if ($CHR_BUDGET_TYPE <> null) {
            $detail_confirm = $this->budget_dimat_m->get_detail_dimat_dept($INT_ID_FISCAL_YEAR, $CHR_BUDGET_TYPE, $INT_DIV, $INT_DEPT, $INT_SECT);
            $detail_confirm_sum = $this->budget_dimat_m->get_sum_dimat_dept($INT_ID_FISCAL_YEAR, $CHR_BUDGET_TYPE, $INT_DIV, $INT_DEPT, $INT_SECT);
            $budget_desc = $this->budgettype_m->get_budget_type($INT_ID_BUDGET_TYPE);
            $budget_desc = strtoupper(trim($budget_desc->CHR_BUDGET_TYPE_DESC));

            $CHR_DEPT = trim($this->dept_m->get_name_dept($INT_DEPT));
            $CHR_DEPT_DESC = trim($this->dept_m->get_desc_dept($INT_DEPT));
            $CHR_FISCAL_YEAR_DESC = trim($this->fiscal_m->select_fiscal_year($INT_ID_FISCAL_YEAR));

            $this->load->library('excel');
            $objReader = PHPExcel_IOFactory::createReader('Excel5');
            // Create new PHPExcel object

            $objPHPExcel = $objReader->load("assets/template/budget/report/Template_Report_Direct_Material.xls");

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

}

?>