<?php

//Add By bugsMaker 20170812
class quota_employee_c extends CI_Controller
{

    private $layout = '/template/head';
    private $back_to_approve_spv = '/aorta/quota_employee_c/prepare_approve_quota_by_spv/';
    private $back_to_approve_mgr = '/aorta/quota_employee_c/prepare_approve_quota_by_mgr/';
    private $back_to_approve_gm = '/aorta/quota_employee_c/prepare_approve_quota_by_gm/';
    private $back_to_approve_dir = '/aorta/quota_employee_c/prepare_approve_quota_by_dir/';
    private $back_to_upload = '/aorta/quota_employee_c/create_quota_employee/';
    private $back_to_balance = '/aorta/quota_employee_c/balancing_quota/';
    private $back_to_reupload = '/aorta/quota_employee_c/edit_quota_employee/';
    private $back_to_manage = '/aorta/quota_employee_c/index/';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('aorta/quota_employee_m');
        $this->load->model('aorta/master_data_m');
        $this->load->model('organization/dept_m');
        $this->load->model('organization/section_m');
        $this->load->model('aorta/overtime_m');
        $this->load->model('aorta/history_m');
        $this->load->model('organization/groupdept_m');
        $this->load->model('organization/dept_m');
    }

    public function check_session()
    {
        $user_session = $this->session->all_userdata();
        if ($user_session['NPK'] == '') {
            redirect(base_url('index.php/login_c'));
        }
    }

    public function index($period = NULL, $dept = NULL, $section = NULL, $msg = NULL)
    {
        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Creating success </strong> The data is successfully created </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Updating success </strong> The data is successfully updated </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Deleted success </strong> The data is successfully deleted </div >";
        } elseif ($msg == 13) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Delete failed !</strong> Quota ini sudah disetujui / dalam proses persetujuan, tidak bisa didelete </div >";
        } elseif ($msg == 15) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Executing error !</strong> Template Anda Salah atau sudah diubah, Silahkan Coba Lagi Dengan Template Yang Benar </div >";
        } elseif ($msg == 12) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Executing error !</strong> Something error with parameter </div >";
        }

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(176);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Manage Quota Employee';
        $data['msg'] = $msg;

        $user_session = $this->session->all_userdata();
        $role = $user_session['ROLE'];
        $npk = $user_session['NPK'];
        $id_dept = $user_session['DEPT'];
        $id_group = $user_session['GROUPDEPT'];
        $id_division = $user_session['DIVISION'];

        if ($role == 1) {
            if ($dept == NULL) {
                $dept = $this->dept_m->get_top_data_dept_by_division($id_division)->row()->CHR_DEPT;
            } else {
                $dept = $dept;
            }
            $data['all_dept'] = $this->dept_m->get_dept_by_division_id($id_division);
        } else if ($role == 33) {
            if ($dept == NULL) {
                $dept = $this->dept_m->get_top_data_dept_by_groupdept($id_group)->row()->CHR_DEPT;
            } else {
                $dept = $dept;
            }
            $data['all_dept'] = $this->dept_m->get_dept_by_groupdept($id_group);
        } else {
            if ($dept == NULL) {
                $dept = $this->dept_m->get_data_dept($id_dept)->row()->CHR_DEPT;
            } else {
                $dept = $dept;
            }
            $data['all_dept'] = $this->dept_m->get_data_dept($id_dept)->result();
        }

        $data['all_section'] = $this->overtime_m->get_section_by_dept($dept);

        if ($section == NULL) {
            $section = 'ALL';
        } else {
            $x = 0;
            foreach ($data['all_section'] as $value) {
                if (trim($value->KODE) == trim($section)) {
                    $x = 1;
                }
            }

            if ($x == 0) {
                $section = 'ALL';
            }
        }

        if ($period == NULL) {
            $period = date('Ym');
        }

        $data['dept'] = trim($dept);
        $data['section'] = trim($section);
        $data['period'] = $period;
        $data['role'] = $role;
        $data['npk'] = $npk;

        $data['data'] = $this->quota_employee_m->get_data_request_quota_employee($dept, $section, $period);
        $data['content'] = 'aorta/quota_employee/manage_quota_employee_v';
        $this->load->view($this->layout, $data);
    }

    public function create_quota_employee($period = null, $dept = null, $section = null, $msg = null)
    {

        $this->check_session();

        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Uploading success </strong> The temporary data is successfully created, to confirm click save at the bellow</div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Updating success </strong> The data is successfully updated </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Deleted success </strong> The data is successfully deleted </div >";
        } elseif ($msg == 13) {
            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Quota Reason empty !</strong>Please, Fill the reason of additional quota</div >";
        } elseif ($msg == 14) {
            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>File not Found !</strong>Choose your file to upload</div >";
        } elseif ($msg == 15) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Executing error !</strong> Template Anda Salah atau sudah diubah, Silahkan Coba Lagi Dengan Template Yang Benar </div >";
        } elseif ($msg == 12) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Executing error !</strong> Something error with parameter </div >";
        } elseif ($msg == 16) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Eksentsi File Problem!</strong> Mohon save as file dengan ekstensi file .xlsx</div >";
        }

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(176);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Upload Quota Employee';
        $data['msg'] = $msg;

        if ($dept == null || $dept == '') {
            $dept = $this->overtime_m->get_top_dept_overtime()->row()->KODE;
        }

        $data['all_dept'] = $this->overtime_m->get_dept_overtime();

        $data['all_section'] = $this->overtime_m->get_all_section_drop($dept);

        if ($section == NULL) {
            $section = $this->overtime_m->get_top_section_overtime($dept)->row()->KODE;
        } else {
            $x = 0;
            foreach ($data['all_section'] as $value) {
                if (trim($value->KODE) == trim($section)) {
                    $x = 1;
                }
            }

            if ($x == 0) {
                $section = $this->overtime_m->get_top_section_overtime($dept)->row()->KODE;
            }
        }

        if ($period == null || $period == '') {
            $period = date('Ym');
        }

        $data['dept'] = $dept;
        $data['section'] = $section;
        $data['period'] = $period;
        $data['dayCount'] = cal_days_in_month(CAL_GREGORIAN, substr($period, -2), substr($period, 0, 4));
        $data['data_template'] = $this->quota_employee_m->get_data_employee_by_dept_section_and_period($dept, $section);
        $data['data'] = array(); //$this->quota_employee_m->get_temp_data_request_quota_employee_by_qrno($qrno);
        $data['increment'] = 0;

        $data['content'] = 'aorta/quota_employee/upload_quota_employee_v';
        $this->load->view($this->layout, $data);
    }

    public function upload_quota_employee()
    {
        $this->load->library(array('PHPExcel', 'PHPExcel/IOFactory'));
        $this->load->library('upload');

        $period = substr($this->input->post('CHR_PERIOD'), -10, 6);
        $month = (int)substr($period, -2);
        $year = (int)substr($period, 0, 4);
        $day_count = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        $dept = $this->input->post('CHR_DEPT');
        $section = $this->input->post('CHR_SECTION');
        $type_quota = $this->input->post('INT_TYPE_QUOTA');
        $upload_date = date('Ymd');

        $fileName = $_FILES['upload_quota']['name'];
        $ext = pathinfo($fileName, PATHINFO_EXTENSION);

        if (empty($fileName)) {
            redirect($this->back_to_upload . $period . '/' . $dept . '/' . $section . '/' . $msg = 14); ///aorta/quota_employee_c/create_quota_employee/
        } else if ($ext == 'xls') {
            redirect($this->back_to_upload . $period . '/' . $dept . '/' . $section . '/' . $msg = 16);
        } else if ($type_quota == 1 && $this->input->post('CHR_REASON') == '') {
            redirect($this->back_to_upload . $period . '/' . $dept . '/' . $section . '/' . $msg = 13);
        }

        //file untuk submit file excel
        $config['upload_path'] = './assets/file/aorta/quota/';
        $config['file_name'] = $fileName;
        $config['allowed_types'] = 'xlsx';
        $config['max_size'] = 10000;

        //code for upload with ci
        $this->upload->initialize($config);
        if (!$this->upload->do_upload('upload_quota')) {
            $error = array('error' => $this->upload->display_errors());
            redirect($this->back_to_upload . $period . '/' . $dept . '/' . $section . '/' . $msg = 16);
        }

        $media = $this->upload->data('upload_quota');
        $inputFileName = './assets/file/aorta/quota/' . $media['file_name'];

        //  Read  Excel workbook
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

        $rowHeader = $sheet->rangeToArray('A1:' . $highestColumn . '1', NULL, TRUE, FALSE);
        // $checkDate = $sheet->rangeToArray('AE2:' . $highestColumn . '2', NULL, TRUE, FALSE); //28

        // if(trim($checkDate[0][30]) =='28'){

        // }else if(trim($checkDate[0][31]) =='29'){

        // }else if(trim($checkDate[0][32]) =='30'){

        // }else if(trim($checkDate[0][33]) =='31'){

        // }

        $i = 0;
        if (trim($rowHeader[0][0]) == 'No' && trim($rowHeader[0][1]) == 'NPK' && trim($rowHeader[0][2]) == 'Name') {
            for ($row = 3; $row <= $highestRow; $row++) {
                $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);

                $rowData[0][1] = str_replace("'", "", $rowData[0][1]);

                $data[$i]['FLG_DELETE'] = 0;
                $data[$i]['ERROR_MESSAGE'] = NULL;

                if ($day_count == 28) {
                    $data[$i]['QUOTA_PR_DAY_1'] = (float)str_replace(',', '.', $rowData[0][3]);
                    $data[$i]['QUOTA_PR_DAY_2'] = $rowData[0][4];
                    $data[$i]['QUOTA_PR_DAY_3'] = $rowData[0][5];
                    $data[$i]['QUOTA_PR_DAY_4'] = $rowData[0][6];
                    $data[$i]['QUOTA_PR_DAY_5'] = $rowData[0][7];
                    $data[$i]['QUOTA_PR_DAY_6'] = $rowData[0][8];
                    $data[$i]['QUOTA_PR_DAY_7'] = $rowData[0][9];
                    $data[$i]['QUOTA_PR_DAY_8'] = $rowData[0][10];
                    $data[$i]['QUOTA_PR_DAY_9'] = $rowData[0][11];
                    $data[$i]['QUOTA_PR_DAY_10'] = $rowData[0][12];
                    $data[$i]['QUOTA_PR_DAY_11'] = $rowData[0][13];
                    $data[$i]['QUOTA_PR_DAY_12'] = $rowData[0][14];
                    $data[$i]['QUOTA_PR_DAY_13'] = $rowData[0][15];
                    $data[$i]['QUOTA_PR_DAY_14'] = $rowData[0][16];
                    $data[$i]['QUOTA_PR_DAY_15'] = $rowData[0][17];
                    $data[$i]['QUOTA_PR_DAY_16'] = $rowData[0][18];
                    $data[$i]['QUOTA_PR_DAY_17'] = $rowData[0][19];
                    $data[$i]['QUOTA_PR_DAY_18'] = $rowData[0][20];
                    $data[$i]['QUOTA_PR_DAY_19'] = $rowData[0][21];
                    $data[$i]['QUOTA_PR_DAY_20'] = $rowData[0][22];
                    $data[$i]['QUOTA_PR_DAY_21'] = $rowData[0][23];
                    $data[$i]['QUOTA_PR_DAY_22'] = $rowData[0][24];
                    $data[$i]['QUOTA_PR_DAY_23'] = $rowData[0][25];
                    $data[$i]['QUOTA_PR_DAY_24'] = $rowData[0][26];
                    $data[$i]['QUOTA_PR_DAY_25'] = $rowData[0][27];
                    $data[$i]['QUOTA_PR_DAY_26'] = $rowData[0][28];
                    $data[$i]['QUOTA_PR_DAY_27'] = $rowData[0][29];
                    $data[$i]['QUOTA_PR_DAY_28'] = $rowData[0][30];
                    $data[$i]['QUOTA_PR_DAY_29'] = 0;
                    $data[$i]['QUOTA_PR_DAY_30'] = 0;
                    $data[$i]['QUOTA_PR_DAY_31'] = 0;

                    $data[$i]['QUOTA_IM_DAY_1'] = $rowData[0][31];
                    $data[$i]['QUOTA_IM_DAY_2'] = $rowData[0][32];
                    $data[$i]['QUOTA_IM_DAY_3'] = $rowData[0][33];
                    $data[$i]['QUOTA_IM_DAY_4'] = $rowData[0][34];
                    $data[$i]['QUOTA_IM_DAY_5'] = $rowData[0][35];
                    $data[$i]['QUOTA_IM_DAY_6'] = $rowData[0][36];
                    $data[$i]['QUOTA_IM_DAY_7'] = $rowData[0][37];
                    $data[$i]['QUOTA_IM_DAY_8'] = $rowData[0][38];
                    $data[$i]['QUOTA_IM_DAY_9'] = $rowData[0][39];
                    $data[$i]['QUOTA_IM_DAY_10'] = $rowData[0][40];
                    $data[$i]['QUOTA_IM_DAY_11'] = $rowData[0][41];
                    $data[$i]['QUOTA_IM_DAY_12'] = $rowData[0][42];
                    $data[$i]['QUOTA_IM_DAY_13'] = $rowData[0][43];
                    $data[$i]['QUOTA_IM_DAY_14'] = $rowData[0][44];
                    $data[$i]['QUOTA_IM_DAY_15'] = $rowData[0][45];
                    $data[$i]['QUOTA_IM_DAY_16'] = $rowData[0][46];
                    $data[$i]['QUOTA_IM_DAY_17'] = $rowData[0][47];
                    $data[$i]['QUOTA_IM_DAY_18'] = $rowData[0][48];
                    $data[$i]['QUOTA_IM_DAY_19'] = $rowData[0][49];
                    $data[$i]['QUOTA_IM_DAY_20'] = $rowData[0][50];
                    $data[$i]['QUOTA_IM_DAY_21'] = $rowData[0][51];
                    $data[$i]['QUOTA_IM_DAY_22'] = $rowData[0][52];
                    $data[$i]['QUOTA_IM_DAY_23'] = $rowData[0][53];
                    $data[$i]['QUOTA_IM_DAY_24'] = $rowData[0][54];
                    $data[$i]['QUOTA_IM_DAY_25'] = $rowData[0][55];
                    $data[$i]['QUOTA_IM_DAY_26'] = $rowData[0][56];
                    $data[$i]['QUOTA_IM_DAY_27'] = $rowData[0][57];
                    $data[$i]['QUOTA_IM_DAY_28'] = $rowData[0][58];
                    $data[$i]['QUOTA_IM_DAY_29'] = 0;
                    $data[$i]['QUOTA_IM_DAY_30'] = 0;
                    $data[$i]['QUOTA_IM_DAY_31'] = 0;

                    $data[$i]['QUANTITY_QUOTA_PR'] = $rowData[0][59];
                    $data[$i]['QUANTITY_QUOTA_IM'] =  $rowData[0][60];
                } else if ($day_count == 29) {

                    $data[$i]['QUOTA_PR_DAY_1'] = $rowData[0][3];
                    $data[$i]['QUOTA_PR_DAY_2'] = $rowData[0][4];
                    $data[$i]['QUOTA_PR_DAY_3'] = $rowData[0][5];
                    $data[$i]['QUOTA_PR_DAY_4'] = $rowData[0][6];
                    $data[$i]['QUOTA_PR_DAY_5'] = $rowData[0][7];
                    $data[$i]['QUOTA_PR_DAY_6'] = $rowData[0][8];
                    $data[$i]['QUOTA_PR_DAY_7'] = $rowData[0][9];
                    $data[$i]['QUOTA_PR_DAY_8'] = $rowData[0][10];
                    $data[$i]['QUOTA_PR_DAY_9'] = $rowData[0][11];
                    $data[$i]['QUOTA_PR_DAY_10'] = $rowData[0][12];
                    $data[$i]['QUOTA_PR_DAY_11'] = $rowData[0][13];
                    $data[$i]['QUOTA_PR_DAY_12'] = $rowData[0][14];
                    $data[$i]['QUOTA_PR_DAY_13'] = $rowData[0][15];
                    $data[$i]['QUOTA_PR_DAY_14'] = $rowData[0][16];
                    $data[$i]['QUOTA_PR_DAY_15'] = $rowData[0][17];
                    $data[$i]['QUOTA_PR_DAY_16'] = $rowData[0][18];
                    $data[$i]['QUOTA_PR_DAY_17'] = $rowData[0][19];
                    $data[$i]['QUOTA_PR_DAY_18'] = $rowData[0][20];
                    $data[$i]['QUOTA_PR_DAY_19'] = $rowData[0][21];
                    $data[$i]['QUOTA_PR_DAY_20'] = $rowData[0][22];
                    $data[$i]['QUOTA_PR_DAY_21'] = $rowData[0][23];
                    $data[$i]['QUOTA_PR_DAY_22'] = $rowData[0][24];
                    $data[$i]['QUOTA_PR_DAY_23'] = $rowData[0][25];
                    $data[$i]['QUOTA_PR_DAY_24'] = $rowData[0][26];
                    $data[$i]['QUOTA_PR_DAY_25'] = $rowData[0][27];
                    $data[$i]['QUOTA_PR_DAY_26'] = $rowData[0][28];
                    $data[$i]['QUOTA_PR_DAY_27'] = $rowData[0][29];
                    $data[$i]['QUOTA_PR_DAY_28'] = $rowData[0][30];
                    $data[$i]['QUOTA_PR_DAY_29'] = $rowData[0][31];
                    $data[$i]['QUOTA_PR_DAY_30'] = 0;
                    $data[$i]['QUOTA_PR_DAY_31'] = 0;

                    $data[$i]['QUOTA_IM_DAY_1'] = $rowData[0][32];
                    $data[$i]['QUOTA_IM_DAY_2'] = $rowData[0][33];
                    $data[$i]['QUOTA_IM_DAY_3'] = $rowData[0][34];
                    $data[$i]['QUOTA_IM_DAY_4'] = $rowData[0][35];
                    $data[$i]['QUOTA_IM_DAY_5'] = $rowData[0][36];
                    $data[$i]['QUOTA_IM_DAY_6'] = $rowData[0][37];
                    $data[$i]['QUOTA_IM_DAY_7'] = $rowData[0][38];
                    $data[$i]['QUOTA_IM_DAY_8'] = $rowData[0][39];
                    $data[$i]['QUOTA_IM_DAY_9'] = $rowData[0][40];
                    $data[$i]['QUOTA_IM_DAY_10'] = $rowData[0][41];
                    $data[$i]['QUOTA_IM_DAY_11'] = $rowData[0][42];
                    $data[$i]['QUOTA_IM_DAY_12'] = $rowData[0][43];
                    $data[$i]['QUOTA_IM_DAY_13'] = $rowData[0][44];
                    $data[$i]['QUOTA_IM_DAY_14'] = $rowData[0][45];
                    $data[$i]['QUOTA_IM_DAY_15'] = $rowData[0][46];
                    $data[$i]['QUOTA_IM_DAY_16'] = $rowData[0][47];
                    $data[$i]['QUOTA_IM_DAY_17'] = $rowData[0][48];
                    $data[$i]['QUOTA_IM_DAY_18'] = $rowData[0][49];
                    $data[$i]['QUOTA_IM_DAY_19'] = $rowData[0][50];
                    $data[$i]['QUOTA_IM_DAY_20'] = $rowData[0][51];
                    $data[$i]['QUOTA_IM_DAY_21'] = $rowData[0][52];
                    $data[$i]['QUOTA_IM_DAY_22'] = $rowData[0][53];
                    $data[$i]['QUOTA_IM_DAY_23'] = $rowData[0][54];
                    $data[$i]['QUOTA_IM_DAY_24'] = $rowData[0][55];
                    $data[$i]['QUOTA_IM_DAY_25'] = $rowData[0][56];
                    $data[$i]['QUOTA_IM_DAY_26'] = $rowData[0][57];
                    $data[$i]['QUOTA_IM_DAY_27'] = $rowData[0][58];
                    $data[$i]['QUOTA_IM_DAY_28'] = $rowData[0][59];
                    $data[$i]['QUOTA_IM_DAY_29'] = $rowData[0][60];
                    $data[$i]['QUOTA_IM_DAY_30'] = 0;
                    $data[$i]['QUOTA_IM_DAY_31'] = 0;

                    $data[$i]['QUANTITY_QUOTA_PR'] = $rowData[0][61];
                    $data[$i]['QUANTITY_QUOTA_IM'] =  $rowData[0][62];
                } else if ($day_count == 30) {

                    $data[$i]['QUOTA_PR_DAY_1'] = $rowData[0][3];
                    $data[$i]['QUOTA_PR_DAY_2'] = $rowData[0][4];
                    $data[$i]['QUOTA_PR_DAY_3'] = $rowData[0][5];
                    $data[$i]['QUOTA_PR_DAY_4'] = $rowData[0][6];
                    $data[$i]['QUOTA_PR_DAY_5'] = $rowData[0][7];
                    $data[$i]['QUOTA_PR_DAY_6'] = $rowData[0][8];
                    $data[$i]['QUOTA_PR_DAY_7'] = $rowData[0][9];
                    $data[$i]['QUOTA_PR_DAY_8'] = $rowData[0][10];
                    $data[$i]['QUOTA_PR_DAY_9'] = $rowData[0][11];
                    $data[$i]['QUOTA_PR_DAY_10'] = $rowData[0][12];
                    $data[$i]['QUOTA_PR_DAY_11'] = $rowData[0][13];
                    $data[$i]['QUOTA_PR_DAY_12'] = $rowData[0][14];
                    $data[$i]['QUOTA_PR_DAY_13'] = $rowData[0][15];
                    $data[$i]['QUOTA_PR_DAY_14'] = $rowData[0][16];
                    $data[$i]['QUOTA_PR_DAY_15'] = $rowData[0][17];
                    $data[$i]['QUOTA_PR_DAY_16'] = $rowData[0][18];
                    $data[$i]['QUOTA_PR_DAY_17'] = $rowData[0][19];
                    $data[$i]['QUOTA_PR_DAY_18'] = $rowData[0][20];
                    $data[$i]['QUOTA_PR_DAY_19'] = $rowData[0][21];
                    $data[$i]['QUOTA_PR_DAY_20'] = $rowData[0][22];
                    $data[$i]['QUOTA_PR_DAY_21'] = $rowData[0][23];
                    $data[$i]['QUOTA_PR_DAY_22'] = $rowData[0][24];
                    $data[$i]['QUOTA_PR_DAY_23'] = $rowData[0][25];
                    $data[$i]['QUOTA_PR_DAY_24'] = $rowData[0][26];
                    $data[$i]['QUOTA_PR_DAY_25'] = $rowData[0][27];
                    $data[$i]['QUOTA_PR_DAY_26'] = $rowData[0][28];
                    $data[$i]['QUOTA_PR_DAY_27'] = $rowData[0][29];
                    $data[$i]['QUOTA_PR_DAY_28'] = $rowData[0][30];
                    $data[$i]['QUOTA_PR_DAY_29'] = $rowData[0][31];
                    $data[$i]['QUOTA_PR_DAY_30'] = $rowData[0][32];
                    $data[$i]['QUOTA_PR_DAY_31'] = 0;

                    $data[$i]['QUOTA_IM_DAY_1'] = $rowData[0][33];
                    $data[$i]['QUOTA_IM_DAY_2'] = $rowData[0][34];
                    $data[$i]['QUOTA_IM_DAY_3'] = $rowData[0][35];
                    $data[$i]['QUOTA_IM_DAY_4'] = $rowData[0][36];
                    $data[$i]['QUOTA_IM_DAY_5'] = $rowData[0][37];
                    $data[$i]['QUOTA_IM_DAY_6'] = $rowData[0][38];
                    $data[$i]['QUOTA_IM_DAY_7'] = $rowData[0][39];
                    $data[$i]['QUOTA_IM_DAY_8'] = $rowData[0][40];
                    $data[$i]['QUOTA_IM_DAY_9'] = $rowData[0][41];
                    $data[$i]['QUOTA_IM_DAY_10'] = $rowData[0][42];
                    $data[$i]['QUOTA_IM_DAY_11'] = $rowData[0][43];
                    $data[$i]['QUOTA_IM_DAY_12'] = $rowData[0][44];
                    $data[$i]['QUOTA_IM_DAY_13'] = $rowData[0][45];
                    $data[$i]['QUOTA_IM_DAY_14'] = $rowData[0][46];
                    $data[$i]['QUOTA_IM_DAY_15'] = $rowData[0][47];
                    $data[$i]['QUOTA_IM_DAY_16'] = $rowData[0][48];
                    $data[$i]['QUOTA_IM_DAY_17'] = $rowData[0][49];
                    $data[$i]['QUOTA_IM_DAY_18'] = $rowData[0][50];
                    $data[$i]['QUOTA_IM_DAY_19'] = $rowData[0][51];
                    $data[$i]['QUOTA_IM_DAY_20'] = $rowData[0][52];
                    $data[$i]['QUOTA_IM_DAY_21'] = $rowData[0][53];
                    $data[$i]['QUOTA_IM_DAY_22'] = $rowData[0][54];
                    $data[$i]['QUOTA_IM_DAY_23'] = $rowData[0][55];
                    $data[$i]['QUOTA_IM_DAY_24'] = $rowData[0][56];
                    $data[$i]['QUOTA_IM_DAY_25'] = $rowData[0][57];
                    $data[$i]['QUOTA_IM_DAY_26'] = $rowData[0][58];
                    $data[$i]['QUOTA_IM_DAY_27'] = $rowData[0][59];
                    $data[$i]['QUOTA_IM_DAY_28'] = $rowData[0][60];
                    $data[$i]['QUOTA_IM_DAY_29'] = $rowData[0][61];
                    $data[$i]['QUOTA_IM_DAY_30'] = $rowData[0][62];
                    $data[$i]['QUOTA_IM_DAY_31'] = 0;

                    $data[$i]['QUANTITY_QUOTA_PR'] = $rowData[0][63];
                    $data[$i]['QUANTITY_QUOTA_IM'] =  $rowData[0][64];
                } else {

                    $data[$i]['QUOTA_PR_DAY_1'] = $rowData[0][3];
                    $data[$i]['QUOTA_PR_DAY_2'] = $rowData[0][4];
                    $data[$i]['QUOTA_PR_DAY_3'] = $rowData[0][5];
                    $data[$i]['QUOTA_PR_DAY_4'] = $rowData[0][6];
                    $data[$i]['QUOTA_PR_DAY_5'] = $rowData[0][7];
                    $data[$i]['QUOTA_PR_DAY_6'] = $rowData[0][8];
                    $data[$i]['QUOTA_PR_DAY_7'] = $rowData[0][9];
                    $data[$i]['QUOTA_PR_DAY_8'] = $rowData[0][10];
                    $data[$i]['QUOTA_PR_DAY_9'] = $rowData[0][11];
                    $data[$i]['QUOTA_PR_DAY_10'] = $rowData[0][12];
                    $data[$i]['QUOTA_PR_DAY_11'] = $rowData[0][13];
                    $data[$i]['QUOTA_PR_DAY_12'] = $rowData[0][14];
                    $data[$i]['QUOTA_PR_DAY_13'] = $rowData[0][15];
                    $data[$i]['QUOTA_PR_DAY_14'] = $rowData[0][16];
                    $data[$i]['QUOTA_PR_DAY_15'] = $rowData[0][17];
                    $data[$i]['QUOTA_PR_DAY_16'] = $rowData[0][18];
                    $data[$i]['QUOTA_PR_DAY_17'] = $rowData[0][19];
                    $data[$i]['QUOTA_PR_DAY_18'] = $rowData[0][20];
                    $data[$i]['QUOTA_PR_DAY_19'] = $rowData[0][21];
                    $data[$i]['QUOTA_PR_DAY_20'] = $rowData[0][22];
                    $data[$i]['QUOTA_PR_DAY_21'] = $rowData[0][23];
                    $data[$i]['QUOTA_PR_DAY_22'] = $rowData[0][24];
                    $data[$i]['QUOTA_PR_DAY_23'] = $rowData[0][25];
                    $data[$i]['QUOTA_PR_DAY_24'] = $rowData[0][26];
                    $data[$i]['QUOTA_PR_DAY_25'] = $rowData[0][27];
                    $data[$i]['QUOTA_PR_DAY_26'] = $rowData[0][28];
                    $data[$i]['QUOTA_PR_DAY_27'] = $rowData[0][29];
                    $data[$i]['QUOTA_PR_DAY_28'] = $rowData[0][30];
                    $data[$i]['QUOTA_PR_DAY_29'] = $rowData[0][31];
                    $data[$i]['QUOTA_PR_DAY_30'] = $rowData[0][32];
                    $data[$i]['QUOTA_PR_DAY_31'] = $rowData[0][33];

                    $data[$i]['QUOTA_IM_DAY_1'] = $rowData[0][34];
                    $data[$i]['QUOTA_IM_DAY_2'] = $rowData[0][35];
                    $data[$i]['QUOTA_IM_DAY_3'] = $rowData[0][36];
                    $data[$i]['QUOTA_IM_DAY_4'] = $rowData[0][37];
                    $data[$i]['QUOTA_IM_DAY_5'] = $rowData[0][38];
                    $data[$i]['QUOTA_IM_DAY_6'] = $rowData[0][39];
                    $data[$i]['QUOTA_IM_DAY_7'] = $rowData[0][40];
                    $data[$i]['QUOTA_IM_DAY_8'] = $rowData[0][41];
                    $data[$i]['QUOTA_IM_DAY_9'] = $rowData[0][42];
                    $data[$i]['QUOTA_IM_DAY_10'] = $rowData[0][43];
                    $data[$i]['QUOTA_IM_DAY_11'] = $rowData[0][44];
                    $data[$i]['QUOTA_IM_DAY_12'] = $rowData[0][45];
                    $data[$i]['QUOTA_IM_DAY_13'] = $rowData[0][46];
                    $data[$i]['QUOTA_IM_DAY_14'] = $rowData[0][47];
                    $data[$i]['QUOTA_IM_DAY_15'] = $rowData[0][48];
                    $data[$i]['QUOTA_IM_DAY_16'] = $rowData[0][49];
                    $data[$i]['QUOTA_IM_DAY_17'] = $rowData[0][50];
                    $data[$i]['QUOTA_IM_DAY_18'] = $rowData[0][51];
                    $data[$i]['QUOTA_IM_DAY_19'] = $rowData[0][52];
                    $data[$i]['QUOTA_IM_DAY_20'] = $rowData[0][53];
                    $data[$i]['QUOTA_IM_DAY_21'] = $rowData[0][54];
                    $data[$i]['QUOTA_IM_DAY_22'] = $rowData[0][55];
                    $data[$i]['QUOTA_IM_DAY_23'] = $rowData[0][56];
                    $data[$i]['QUOTA_IM_DAY_24'] = $rowData[0][57];
                    $data[$i]['QUOTA_IM_DAY_25'] = $rowData[0][58];
                    $data[$i]['QUOTA_IM_DAY_26'] = $rowData[0][59];
                    $data[$i]['QUOTA_IM_DAY_27'] = $rowData[0][60];
                    $data[$i]['QUOTA_IM_DAY_28'] = $rowData[0][61];
                    $data[$i]['QUOTA_IM_DAY_29'] = $rowData[0][62];
                    $data[$i]['QUOTA_IM_DAY_30'] = $rowData[0][63];
                    $data[$i]['QUOTA_IM_DAY_31'] = $rowData[0][64];

                    $data[$i]['QUANTITY_QUOTA_PR'] = $rowData[0][65];
                    $data[$i]['QUANTITY_QUOTA_IM'] =  $rowData[0][66];
                }

                $data[$i]['NEXT_SALDO_PR'] = 0;
                $data[$i]['SALDO_QUOTA_PR'] = 0;
                $data[$i]['TERPAKAI_QUOTA_PR'] = 0;
                $data[$i]['SISA_QUOTA_PR'] = 0;

                $data[$i]['NEXT_SALDO_IM'] = 0;
                $data[$i]['SALDO_QUOTA_IM'] = 0;
                $data[$i]['TERPAKAI_QUOTA_IM'] = 0;
                $data[$i]['SISA_QUOTA_IM'] = 0;

                $data[$i]['ADJ_QUOTA_PR_BULAN'] = 0;
                $data[$i]['ADJ_QUOTA_IM_BULAN'] = 0;

                $quota_inuse = $this->quota_employee_m->get_data_quota_by_npk_period($rowData[0][1], $period);
                if ($quota_inuse) {
                    $data[$i]['NEXT_SALDO_PR'] = $quota_inuse->QUOTAPLAN + $data[$i]['QUANTITY_QUOTA_PR'];
                    $data[$i]['SALDO_QUOTA_PR'] = $quota_inuse->QUOTAPLAN;
                    $data[$i]['TERPAKAI_QUOTA_PR'] = $quota_inuse->TERPAKAIPLAN;
                    $data[$i]['SISA_QUOTA_PR'] = $quota_inuse->SISAPLAN;

                    $data[$i]['ADJ_QUOTA_PR_BULAN'] = $this->quota_employee_m->get_adjquota($month, $year, $quota_inuse->QUOTAPLAN, $data[$i]['QUANTITY_QUOTA_PR']);

                    $data[$i]['NEXT_SALDO_IM'] = $quota_inuse->QUOTAPLAN1 + $data[$i]['QUANTITY_QUOTA_IM'];
                    $data[$i]['SALDO_QUOTA_IM'] = $quota_inuse->QUOTAPLAN1;
                    $data[$i]['TERPAKAI_QUOTA_IM'] = $quota_inuse->TERPAKAIPLAN1;
                    $data[$i]['SISA_QUOTA_IM'] = $quota_inuse->SISAPLAN1;

                    $data[$i]['ADJ_QUOTA_IM_BULAN'] = $this->quota_employee_m->get_adjquota($month, $year, $quota_inuse->QUOTAPLAN1, $data[$i]['QUANTITY_QUOTA_IM']);

                    $policy_qr = $this->quota_employee_m->get_policy_quota('QR_MAX');
                    if ($quota_inuse->SISAPLAN > $policy_qr->POLICY_VAL) {
                        $data[$i]['FLG_DELETE'] = 1;
                        $data[$i]['ERROR_MESSAGE'] = 'Sisa quota : ' . $quota_inuse->SISAPLAN . ' <br> tidak boleh lebih dari' . $policy_qr->QR_MAX . ' menit';
                    }
                }

                $npk_exist = $this->quota_employee_m->check_existing_npk($rowData[0][1]);
                if ($npk_exist == true) {
                    $data[$i]['FLG_DELETE'] = 1;
                    $data[$i]['ERROR_MESSAGE'] = 'This NPK is not registered or was <i>soft deleted</i>';
                }

                $flag_duplicate = $this->quota_employee_m->check_duplicate_req_quota($rowData[0][1], $period);
                if ($flag_duplicate) {
                    $data[$i]['FLG_DELETE'] = 1;
                    $data[$i]['ERROR_MESSAGE'] = 'Sudah dibuatkan quota request, dengan No <br>' . $flag_duplicate->ID_DOC . ' (' . $flag_duplicate->STATUS . ')';
                }

                if ($type_quota == 0) {
                    $data[$i]['ALASAN'] = 'Quota Standard';
                } else {
                    $data[$i]['ALASAN'] = $this->input->post('CHR_REASON');
                }

                $data[$i]['TGL_DOC'] = $upload_date;
                $data[$i]['TAHUNBULAN'] = $period;
                $data[$i]['NPK'] = $rowData[0][1];
                $data[$i]['NAMA'] = $rowData[0][2];
                $data[$i]['OPER_ENTRY'] = $this->session->userdata('USERNAME');
                $data[$i]['TGL_ENTRY'] = $upload_date;
                $data[$i]['JAM_ENTRY'] = date('His');

                $fail_insert = 0;
                if ($flag_duplicate == false) {
                    $part_no_failed[$fail_insert] = $rowData[0][1];
                    $fail_insert++;
                }

                $i++;
            }

            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button>Uploading quota belum sepenuhnya sukses, Untuk konfirmasi klik save</div >";

            $data_view['app'] = $this->role_module_m->get_app();
            $data_view['module'] = $this->role_module_m->get_module();
            $data_view['function'] = $this->role_module_m->get_function();
            $data_view['sidebar'] = $this->role_module_m->side_bar(176);
            $data_view['news'] = $this->news_m->get_news();
            $data_view['title'] = 'Upload Quota Employee';
            $data_view['msg'] = $msg;

            $data_view['data_template'] = $this->quota_employee_m->get_data_employee_by_dept_and_period($dept);

            $data_view['dept'] = $dept;
            $data_view['section'] = $section;
            $data_view['period'] = $period;
            $data_view['dayCount'] = $day_count;
            $data_view['increment'] = $i;
            $data_view['data'] = $data;

            $data_view['content'] = 'aorta/quota_employee/upload_quota_employee_v';
            $this->load->view($this->layout, $data_view);
        } else {
            redirect($this->back_to_upload . $period . '/' . $dept .  '/' . $section . '/' . $msg = 15);
        }
    }

    public function save_temp_quota_employee()
    {
        $tableRow = $this->input->post("tableRow");
        $period = $this->input->post("CHR_PERIOD");
        $upload_date = date('Ymd');
        $upload_time = date('His');
        $dept = $this->input->post('CHR_DEPT');
        $section = $this->input->post('CHR_SECTION');
        $created_by = $this->session->userdata('USERNAME');
        $qr_code = $this->quota_employee_m->generated_candidate_id_quota_request($period);

        foreach ($tableRow as $row) {

            if ($row['FLG_DELETE'] == 0) {
                if ($row['QUANTITY_QUOTA_PR'] <> 0 || $row['QUANTITY_QUOTA_IM'] <> 0) {

                    $data['ID_DOC'] = $qr_code;
                    $data['TGL_DOC'] = $upload_date;
                    $data['TAHUNBULAN'] = $period;
                    $data['NPK'] = $row['NPK'];
                    $data['QUANTITY_QUOTA_PR'] = str_replace(',', '.', $row['QUANTITY_QUOTA_PR']);
                    $data['SALDO_QUOTA_PR'] =  str_replace(',', '.', $row['SALDO_QUOTA_PR']);
                    $data['TERPAKAI_QUOTA_PR'] = str_replace(',', '.', $row['TERPAKAI_QUOTA_PR']);
                    $data['QUANTITY_QUOTA_IM'] = str_replace(',', '.', $row['QUANTITY_QUOTA_IM']);
                    $data['SALDO_QUOTA_IM'] =  str_replace(',', '.', $row['SALDO_QUOTA_IM']);
                    $data['TERPAKAI_QUOTA_IM'] = str_replace(',', '.', $row['TERPAKAI_QUOTA_IM']);
                    $data['ADJ_QUOTA_PR_BULAN'] = str_replace(',', '.', $row['ADJ_QUOTA_PR_BULAN']);
                    $data['ADJ_QUOTA_IM_BULAN'] = str_replace(',', '.', $row['ADJ_QUOTA_IM_BULAN']);

                    $data['QUOTA_PR_DAY_1']  = str_replace(',', '.',  $row['QUOTA_PR_DAY_1']);
                    $data['QUOTA_PR_DAY_2']  = str_replace(',', '.',  $row['QUOTA_PR_DAY_2']);
                    $data['QUOTA_PR_DAY_3']  = str_replace(',', '.',  $row['QUOTA_PR_DAY_3']);
                    $data['QUOTA_PR_DAY_4']  = str_replace(',', '.',  $row['QUOTA_PR_DAY_4']);
                    $data['QUOTA_PR_DAY_5']  = str_replace(',', '.',  $row['QUOTA_PR_DAY_5']);
                    $data['QUOTA_PR_DAY_6']  = str_replace(',', '.',  $row['QUOTA_PR_DAY_6']);
                    $data['QUOTA_PR_DAY_7']  = str_replace(',', '.',  $row['QUOTA_PR_DAY_7']);
                    $data['QUOTA_PR_DAY_8']  = str_replace(',', '.',  $row['QUOTA_PR_DAY_8']);
                    $data['QUOTA_PR_DAY_9']  = str_replace(',', '.',  $row['QUOTA_PR_DAY_9']);
                    $data['QUOTA_PR_DAY_10'] = str_replace(',', '.', $row['QUOTA_PR_DAY_10']);
                    $data['QUOTA_PR_DAY_11'] = str_replace(',', '.', $row['QUOTA_PR_DAY_11']);
                    $data['QUOTA_PR_DAY_12'] = str_replace(',', '.', $row['QUOTA_PR_DAY_12']);
                    $data['QUOTA_PR_DAY_13'] = str_replace(',', '.', $row['QUOTA_PR_DAY_13']);
                    $data['QUOTA_PR_DAY_14'] = str_replace(',', '.', $row['QUOTA_PR_DAY_14']);
                    $data['QUOTA_PR_DAY_15'] = str_replace(',', '.', $row['QUOTA_PR_DAY_15']);
                    $data['QUOTA_PR_DAY_16'] = str_replace(',', '.', $row['QUOTA_PR_DAY_16']);
                    $data['QUOTA_PR_DAY_17'] = str_replace(',', '.', $row['QUOTA_PR_DAY_17']);
                    $data['QUOTA_PR_DAY_18'] = str_replace(',', '.', $row['QUOTA_PR_DAY_18']);
                    $data['QUOTA_PR_DAY_19'] = str_replace(',', '.', $row['QUOTA_PR_DAY_19']);
                    $data['QUOTA_PR_DAY_20'] = str_replace(',', '.', $row['QUOTA_PR_DAY_20']);
                    $data['QUOTA_PR_DAY_21'] = str_replace(',', '.', $row['QUOTA_PR_DAY_21']);
                    $data['QUOTA_PR_DAY_22'] = str_replace(',', '.', $row['QUOTA_PR_DAY_22']);
                    $data['QUOTA_PR_DAY_23'] = str_replace(',', '.', $row['QUOTA_PR_DAY_23']);
                    $data['QUOTA_PR_DAY_24'] = str_replace(',', '.', $row['QUOTA_PR_DAY_24']);
                    $data['QUOTA_PR_DAY_25'] = str_replace(',', '.', $row['QUOTA_PR_DAY_25']);
                    $data['QUOTA_PR_DAY_26'] = str_replace(',', '.', $row['QUOTA_PR_DAY_26']);
                    $data['QUOTA_PR_DAY_27'] = str_replace(',', '.', $row['QUOTA_PR_DAY_27']);
                    $data['QUOTA_PR_DAY_28'] = str_replace(',', '.', $row['QUOTA_PR_DAY_28']);
                    $data['QUOTA_PR_DAY_29'] = str_replace(',', '.', $row['QUOTA_PR_DAY_29']);
                    $data['QUOTA_PR_DAY_30'] = str_replace(',', '.', $row['QUOTA_PR_DAY_30']);
                    $data['QUOTA_PR_DAY_31'] = str_replace(',', '.', $row['QUOTA_PR_DAY_31']);

                    $data['QUOTA_IM_DAY_1']  = str_replace(',', '.',  $row['QUOTA_IM_DAY_1']);
                    $data['QUOTA_IM_DAY_2']  = str_replace(',', '.',  $row['QUOTA_IM_DAY_2']);
                    $data['QUOTA_IM_DAY_3']  = str_replace(',', '.',  $row['QUOTA_IM_DAY_3']);
                    $data['QUOTA_IM_DAY_4']  = str_replace(',', '.',  $row['QUOTA_IM_DAY_4']);
                    $data['QUOTA_IM_DAY_5']  = str_replace(',', '.',  $row['QUOTA_IM_DAY_5']);
                    $data['QUOTA_IM_DAY_6']  = str_replace(',', '.',  $row['QUOTA_IM_DAY_6']);
                    $data['QUOTA_IM_DAY_7']  = str_replace(',', '.',  $row['QUOTA_IM_DAY_7']);
                    $data['QUOTA_IM_DAY_8']  = str_replace(',', '.',  $row['QUOTA_IM_DAY_8']);
                    $data['QUOTA_IM_DAY_9']  = str_replace(',', '.',  $row['QUOTA_IM_DAY_9']);
                    $data['QUOTA_IM_DAY_10'] = str_replace(',', '.', $row['QUOTA_IM_DAY_10']);
                    $data['QUOTA_IM_DAY_11'] = str_replace(',', '.', $row['QUOTA_IM_DAY_11']);
                    $data['QUOTA_IM_DAY_12'] = str_replace(',', '.', $row['QUOTA_IM_DAY_12']);
                    $data['QUOTA_IM_DAY_13'] = str_replace(',', '.', $row['QUOTA_IM_DAY_13']);
                    $data['QUOTA_IM_DAY_14'] = str_replace(',', '.', $row['QUOTA_IM_DAY_14']);
                    $data['QUOTA_IM_DAY_15'] = str_replace(',', '.', $row['QUOTA_IM_DAY_15']);
                    $data['QUOTA_IM_DAY_16'] = str_replace(',', '.', $row['QUOTA_IM_DAY_16']);
                    $data['QUOTA_IM_DAY_17'] = str_replace(',', '.', $row['QUOTA_IM_DAY_17']);
                    $data['QUOTA_IM_DAY_18'] = str_replace(',', '.', $row['QUOTA_IM_DAY_18']);
                    $data['QUOTA_IM_DAY_19'] = str_replace(',', '.', $row['QUOTA_IM_DAY_19']);
                    $data['QUOTA_IM_DAY_20'] = str_replace(',', '.', $row['QUOTA_IM_DAY_20']);
                    $data['QUOTA_IM_DAY_21'] = str_replace(',', '.', $row['QUOTA_IM_DAY_21']);
                    $data['QUOTA_IM_DAY_22'] = str_replace(',', '.', $row['QUOTA_IM_DAY_22']);
                    $data['QUOTA_IM_DAY_23'] = str_replace(',', '.', $row['QUOTA_IM_DAY_23']);
                    $data['QUOTA_IM_DAY_24'] = str_replace(',', '.', $row['QUOTA_IM_DAY_24']);
                    $data['QUOTA_IM_DAY_25'] = str_replace(',', '.', $row['QUOTA_IM_DAY_25']);
                    $data['QUOTA_IM_DAY_26'] = str_replace(',', '.', $row['QUOTA_IM_DAY_26']);
                    $data['QUOTA_IM_DAY_27'] = str_replace(',', '.', $row['QUOTA_IM_DAY_27']);
                    $data['QUOTA_IM_DAY_28'] = str_replace(',', '.', $row['QUOTA_IM_DAY_28']);
                    $data['QUOTA_IM_DAY_29'] = str_replace(',', '.', $row['QUOTA_IM_DAY_29']);
                    $data['QUOTA_IM_DAY_30'] = str_replace(',', '.', $row['QUOTA_IM_DAY_30']);
                    $data['QUOTA_IM_DAY_31'] = str_replace(',', '.', $row['QUOTA_IM_DAY_31']);

                    $data['OPER_ENTRY'] = $created_by;
                    $data['TGL_ENTRY'] = $upload_date;
                    $data['JAM_ENTRY'] = $upload_time;
                    $data['KADEP_APPROVE'] = 0;
                    $data['GM_APPROVE'] = 0;
                    $data['DIR_APPROVE'] = 0;
                    $data['FLG_FINISH_APPROVE'] = 0;
                    $data['PRESENT_QUOTA_PR'] = 0;
                    $data['FORECAST_QUOTA_PR'] = 0;
                    $data['ALASAN'] =  $row['ALASAN'];
                    $data['FLG_DELETE'] =  0;

                    $this->quota_employee_m->save_upload_result($data);

                    //Initiate 
                    $check_exist = $this->quota_employee_m->check_exist_quota_employee($row['NPK'], $period);
                    if ($check_exist == false) {
                        $data_quota = array(
                            'TAHUNBULAN' => $period,
                            'NPK' => $row['NPK'],
                            'QUOTA_STD' => '0',
                            'QUOTAPLAN' => '0',
                            'TERPAKAIPLAN' => '0',
                            'SISAPLAN' => '0',
                            'QUOTA' => '0',
                            'TERPAKAI' => '0',
                            'SISA' => '0',
                            'QUOTAPLAN1' => '0',
                            'TERPAKAIPLAN1' => '0',
                            'SISAPLAN1' => '0',
                            'QUOTA1' => '0',
                            'TERPAKAI1' => '0',
                            'SISA1' => '0',
                            'OPER_ENTRY' => $created_by,
                            'TGL_ENTRY' => $upload_date,
                            'JAM_ENTRY' => $upload_time,
                            'OPER_EDIT' => '',
                            'TGL_EDIT' => '',
                            'JAM_EDIT' => ''
                        );
                        $this->quota_employee_m->save($data_quota);
                    }
                }
            }
        }

        $ip = gethostbyaddr($_SERVER['REMOTE_ADDR']);
        $ket = 'CREATE';
        $psnya = "Create Quota " . $period . ", Dept " . $dept;

        $data_history = array(
            'TGLTRANS' => date('Ymd'),
            'JAMTRANS' => date('His'),
            'OTCPU' => $ip,
            'TIPETRANS' =>  $ket,
            'NO_SEQUENCE' => $qr_code,
            'OPERTRANS' => $created_by,
            'OTVERSION' => 'AIS',
            'KETERANGAN' => $psnya
        );

        $this->history_m->save($data_history);

        redirect($this->back_to_manage . $period . '/' . $dept . '/' . $section . '/' . 1);
    }

    public function delete_quota_employee($id, $period, $dept, $section)
    {
        $user_session = $this->session->all_userdata();
        $username = $user_session['USERNAME'];

        $data = array(
            'FLG_DELETE' => 1,
            'OPER_DELETE' => $username,
            'TGL_DELETE' => date('Ymd'),
            'JAM_DELETE' => date('His')
        );

        $flg_approval = $this->quota_employee_m->check_flg_approval_quota($id);

        if (!$flg_approval) {
            $this->quota_employee_m->update($id, $data);
            redirect($this->back_to_manage . $period . '/' . $dept . '/' . $section . '/3');
        } else {
            redirect($this->back_to_manage . $period . '/' . $dept . '/' . $section . '/13');
        }
    }

    public function print_quota_employee($id, $period, $dept, $section)
    {
        $this->load->library('QuotaFPDF');
        $pdf = $this->quotafpdf->getInstance();

        $param_pdf = array(
            'id' => $id,
            'dept' => $dept,
            'period' => $period,
        );

        $pdf->setDataHeader($param_pdf);

        $pdf->AliasNbPages();
        $pdf->AddPage();
        $pdf->SetFont('Arial', '', 6);

        $data_quota_request = $this->quota_employee_m->get_data_request_quota_by_id($id)->result();

        $no = 1;
        $count = 1;
        $alasan = '';
        foreach ($data_quota_request as $isi) {
            $name = explode(' ', trim($isi->NAMA));
            if (count($name) > 2) {
                $nickname = $name[0] . ' ' . $name[1] . ' ' . substr($name[2], 0, 1) . '.';
            } else {
                $nickname = trim($isi->NAMA);
            }
            $pdf->Cell(10, 4, $no, 1, 0, 'C');
            $pdf->Cell(10, 4, $isi->NPK, 1, 0, 'C');
            $pdf->Cell(30, 4, $nickname, 1, 0, 'L');
            $pdf->Cell(15, 4, trim($isi->KD_SECTION . ' / ' . $isi->KD_SUB_SECTION), 1, 0, 'C');
            $pdf->Cell(15, 4, $isi->QUANTITY_QUOTA_PR, 1, 0, 'C');
            $pdf->Cell(15, 4, $isi->SALDO_QUOTA_PR, 1, 0, 'C');
            $pdf->Cell(15, 4, $isi->TERPAKAI_QUOTA_PR, 1, 0, 'C');
            $pdf->Cell(15, 4, '0', 1, 0, 'C');
            $pdf->Cell(15, 4, '0', 1, 0, 'C');
            $pdf->Cell(15, 4, '0', 1, 0, 'C');
            $pdf->Cell(15, 4, $isi->QUANTITY_QUOTA_IM, 1, 0, 'C');
            $pdf->Cell(15, 4, $isi->SALDO_QUOTA_IM, 1, 0, 'C');
            $pdf->Cell(15, 4, $isi->TERPAKAI_QUOTA_IM, 1, 0, 'C');
            $pdf->Cell(15, 4, $isi->QUANTITY_QUOTA_TOT, 1, 0, 'C');
            $pdf->Cell(15, 4, $isi->SALDO_QUOTA_TOT, 1, 0, 'C');
            $pdf->Cell(15, 4, $isi->TERPAKAI_QUOTA_TOT, 1, 0, 'C');
            $pdf->Cell(15, 4, $isi->REMARK, 1, 0, 'C');
            $pdf->Cell(15, 4, $isi->FLG_FINISH, 1, 1, 'C');
            $alasan = trim($isi->ALASAN);
            $pdf->setDataFooter($alasan);
            if ($count == 30) {
                $pdf->AddPage();
                $count = 1;
            }
            $no++;
            $count++;
        }

        $pdf->Output("request-quota-" . trim($dept) . "-" . trim($period) . ".pdf", 'I');
    }

    function download_template_balance_employee()
    {
        $this->load->helper('download');

        ob_clean();

        $name = 'Balancing.xlsx';
        $data = file_get_contents("assets/template/aorta/$name");

        force_download($name, $data);
    }

    function edit_quota_employee($qrno = null, $period = null, $dept = null, $msg = null)
    {
        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Uploading success </strong> The temporary data is successfully created, to confirm click save at the bellow</div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Updating success </strong> The data is successfully updated </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Deleted success </strong> The data is successfully deleted </div >";
        } elseif ($msg == 13) {
            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Quota Reason empty !</strong>Please, Fill the reason of additional quota</div >";
        } elseif ($msg == 14) {
            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>File not Found !</strong>Choose your file to be upload</div >";
        } elseif ($msg == 15) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Executing error !</strong> Template Anda Salah atau sudah diubah, Silahkan Coba Lagi Dengan Template Yang Benar </div >";
        } elseif ($msg == 12) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Executing error !</strong> Something error with parameter </div >";
        }

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(176);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Reupload Quota Employee';
        $data['msg'] = $msg;

        $data['id_doc'] = $qrno;
        $data['dept'] = $dept;
        $data['all_dept'] = $this->overtime_m->get_dept_overtime();
        $data['period'] = $period;

        $data['data'] = $this->quota_employee_m->get_data_request_quota_employee_by_qrno($qrno);
        //$data['status'] = $this->quota_employee_m->get_status_editable_quota($qrno);

        $data['content'] = 'aorta/quota_employee/reupload_quota_employee_v';
        $this->load->view($this->layout, $data);
    }

    function reupload_quota_employee()
    {

        $period = $this->input->post('CHR_PERIOD');
        $dept = $this->input->post('CHR_DEPT');
        $type_quota = $this->input->post('INT_TYPE_QUOTA');
        $qr_no = $this->input->post('INT_ID_DOC');

        $this->load->library(array('PHPExcel', 'PHPExcel/IOFactory'));
        $upload_date = date('Ymd');

        $fileName = $_FILES['upload_quota']['name'];
        if (empty($fileName)) {
            redirect($this->back_to_reupload . $qr_no . '/' . $period . '/' . $dept . '/' . $msg = 14);
        }

        if ($type_quota == 1 && $this->input->post('CHR_REASON') == '') {
            redirect($this->back_to_reupload . $qr_no . '/' . $period . '/' . $dept . '/' . $msg = 13);
        }

        //file untuk submit file excel
        $config['upload_path'] = './assets/file/aorta/quota/';
        $config['file_name'] = $fileName;
        $config['allowed_types'] = 'xls|xlsx';
        $config['max_size'] = 10000;

        //code for upload with ci
        $this->load->library('upload');
        $this->upload->initialize($config);
        if ($a = $this->upload->do_upload('upload_quota'))
            $this->upload->display_errors();
        $media = $this->upload->data('upload_quota');
        $inputFileName = './assets/file/aorta/quota/' . $media['file_name'];

        //  Read  Excel workbook
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

        $rowHeader = $sheet->rangeToArray('A6:' . $highestColumn . '6', NULL, TRUE, FALSE);

        $no = $rowHeader[0][0];
        $nama = $rowHeader[0][1];
        $npk = $rowHeader[0][2];
        $quota_std = $rowHeader[0][3];
        $prod_tanggal = $rowHeader[0][5];
        $impv_tanggal = $rowHeader[0][36];
        $total = $rowHeader[0][67];

        $candidate_id = $qr_no;

        if (trim($no) == 'NO' && trim($nama) == 'NAMA' && trim($npk) == 'NPK' && trim($quota_std) == 'QUOTA STD' && $prod_tanggal == 'PRD - TANGGAL' && $impv_tanggal == 'IMPROVEMENT - TANGGAL' && $total == 'TOTAL') {
            for ($row = 8; $row <= $highestRow; $row++) {
                $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);

                $rowData[0][0] = (int) $rowData[0][0];
                $rowData[0][1] = (int) $rowData[0][1];

                if (strlen($rowData[0][2]) == 2) {
                    $rowData[0][2] = '00' . $rowData[0][2];
                } elseif (strlen($rowData[0][2]) == 3) {
                    $rowData[0][2] = '0' . $rowData[0][2];
                } else {
                    $rowData[0][2] = $rowData[0][2];
                }

                $flag_duplicate = $this->quota_employee_m->check_duplicate_overtime($rowData[0][2], $period);
                if ($flag_duplicate == false) {
                    $data['FLG_DELETE'] = 1;
                    $data['ERROR_MESSAGE'] = 'Duplicate NPK : ' . $rowData[0][2] . ' in Period : ' . $period;
                } else {
                    $data['FLG_DELETE'] = 0;
                    $data['ERROR_MESSAGE'] = NULL;
                }

                $npk_exist = $this->quota_employee_m->check_existing_npk($rowData[0][2]);
                if ($npk_exist == true) {
                    $data['FLG_DELETE'] = 1;
                    $data['ERROR_MESSAGE'] = 'NPK : ' . $rowData[0][2] . ' tidak terdaftar atau sudah di<i>softdelete</i>';
                } else {
                    $data['FLG_DELETE'] = 0;
                    $data['ERROR_MESSAGE'] = NULL;
                }

                if ($type_quota == 0) {
                    $data['ALASAN'] = 'Quota Standar';
                } else {
                    $data['ALASAN'] = $this->input->post('CHR_REASON');
                }

                $data['ID_DOC'] = $candidate_id;
                $data['TGL_DOC'] = $upload_date;
                $data['TAHUNBULAN'] = $period;
                $data['NPK'] = $rowData[0][2];
                $data['QUANTITY_QUOTA_PR'] = $rowData[0][67];
                $data['SALDO_QUOTA_PR'] = $rowData[0][67];
                $data['TERPAKAI_QUOTA_PR'] = 0;
                $data['ADJ_QUOTA_PR_BULAN'] = 0;
                $data['QUANTITY_QUOTA_IM'] = 0;
                $data['SALDO_QUOTA_IM'] = $rowData[0][68];
                $data['TERPAKAI_QUOTA_IM'] = 0;
                $data['ADJ_QUOTA_IM_BULAN'] = 0;
                $data['OPER_ENTRY'] = $this->session->userdata('USERNAME');
                $data['TGL_ENTRY'] = $upload_date;
                $data['JAM_ENTRY'] = date('His');

                $this->quota_employee_m->save_upload_result($data);

                $fail_insert = 0;
                if ($flag_duplicate == false) {
                    $part_no_failed[$fail_insert] = $rowData[0][2];
                    $fail_insert++;
                }
            }

            redirect($this->back_to_reupload . $candidate_id . '/' . $period . '/' . $dept . '/' . $msg = 1);
        } else {
            redirect($this->back_to_reupload . $candidate_id . '/' . $period . '/' . $dept . '/' . $msg = 15);
        }
    }

    function view_detail_quota_employee()
    {
        $qrno = $this->input->post("qrno");
        $data_detail = $this->quota_employee_m->get_data_request_quota_employee_by_qrno($qrno);
        $data = "";
        $i = 1;
        foreach ($data_detail as $isi) {
            $data .= "<tr class='gradeX'>";
            $data .= "<td>$i</td>";
            $data .= "<td style='vertical-align: middle;text-align:center'><strong>$isi->NPK</strong></td>";
            $data .= "<td style='vertical-align: middle;text-align:left'>$isi->NAMA</td>";
            $data .= "<td style='vertical-align: middle;text-align:center'>$isi->KD_SECTION</td>";
            $data .= "<td style='vertical-align: middle;text-align:center'>$isi->KD_SUB_SECTION</td>";
            $data .= "<td style='vertical-align: middle;text-align:center'>" . $isi->QUANTITY_QUOTA_PR . "</td>";
            $data .= "<td style='vertical-align: middle;text-align:center'>" . $isi->SALDO_QUOTA_PR . "</td>";
            $data .= "<td style='vertical-align: middle;text-align:center'>" . $isi->TERPAKAI_QUOTA_PR . "</td>";
            $data .= "<td style='vertical-align: middle;text-align:center'>" . $isi->QUANTITY_QUOTA_IM . "</td>";
            $data .= "<td style='vertical-align: middle;text-align:center'>" . $isi->SALDO_QUOTA_IM . "</td>";
            $data .= "<td style='vertical-align: middle;text-align:center'>" . $isi->TERPAKAI_QUOTA_IM . "</td>";
            $data .= "<td>";
            if ($isi->KADEP_APPROVE == 0 && $isi->GM_APPROVE == 0 && $isi->DIR_APPROVE == 0) {
                $data .= "<a disabled href='<?php echo base_url('index.php/aorta/quota_employee_c/remove_employee_from_quota') . '/' . $isi->ID_DOC ?>' class='label label-danger' data-placement='right' data-toggle='tooltip' title='Delete' onclick='return confirm(\"Are you sure want to remove this NPK?\");'><span class='fa fa-times'></span></a>";
            } else {
                $data .= "<a disabled style='cursor: not-allowed;' class='label label-default' data-placement='right' data-toggle='tooltip' title='Delete'><span class='fa fa-times'></span></a>";
            }
            $data .= "</td>";
            $data .= "</tr>";

            $i++;
        }
        echo $data;
    }

    function remove_employee_from_quota()
    {
    }

    function view_detail_quota_employee_by_user()
    {
        $qrno = $this->input->post("qrno");
        $stat = $this->input->post("stat");

        $data_detail = $this->quota_employee_m->get_data_request_quota_employee_by_qrno_for_user($qrno, $stat);
        $data_policy = $this->quota_employee_m->get_policy('QUOTA_MAX_GM');
        $data = "";
        $tot_qr_pr = 0;
        $tot_saldo_pr = 0;
        $tot_qr_im = 0;
        $tot_saldo_im = 0;

        $i = 1;
        foreach ($data_detail as $isi) {
            $saldo_pr = $isi->SALDO_QUOTA_PR - $isi->TERPAKAI_QUOTA_PR;
            $next_saldo_pr = $saldo_pr + $isi->QUANTITY_QUOTA_PR;
            $saldo_im = $isi->SALDO_QUOTA_IM - $isi->TERPAKAI_QUOTA_IM;
            $next_saldo_im = $saldo_im + $isi->QUANTITY_QUOTA_IM;

            $tot_qr_pr = $tot_qr_pr + $isi->QUANTITY_QUOTA_PR;
            $tot_saldo_pr = $tot_saldo_pr + $next_saldo_pr;
            $tot_qr_im = $tot_qr_im + $isi->QUANTITY_QUOTA_IM;
            $tot_saldo_im = $tot_saldo_im + $next_saldo_im;

            $data .= "<tr class='gradeX'>";
            $data .= "<td>$i</td>";
            $data .= "<td style='text-align:center'><strong>$isi->NPK</strong></td>";
            $data .= "<td style='text-align:left'>$isi->NAMA</td>";
            $data .= "<td style='text-align:center'>$isi->KD_SECTION/$isi->KD_SUB_SECTION</td>";

            // $data .= "<td style='text-align:center'>" . number_format($isi->QUOTA_PR_DAY_1, 2, ',', '.') . "</td>";
            // $data .= "<td style='text-align:center'>" . number_format($isi->QUOTA_PR_DAY_2, 2, ',', '.') . "</td>";
            // $data .= "<td style='text-align:center'>" . number_format($isi->QUOTA_PR_DAY_3, 2, ',', '.') . "</td>";
            // $data .= "<td style='text-align:center'>" . number_format($isi->QUOTA_PR_DAY_4, 2, ',', '.') . "</td>";
            // $data .= "<td style='text-align:center'>" . number_format($isi->QUOTA_PR_DAY_5, 2, ',', '.') . "</td>";
            // $data .= "<td style='text-align:center'>" . number_format($isi->QUOTA_PR_DAY_6, 2, ',', '.') . "</td>";
            // $data .= "<td style='text-align:center'>" . number_format($isi->QUOTA_PR_DAY_7, 2, ',', '.') . "</td>";
            // $data .= "<td style='text-align:center'>" . number_format($isi->QUOTA_PR_DAY_8, 2, ',', '.') . "</td>";
            // $data .= "<td style='text-align:center'>" . number_format($isi->QUOTA_PR_DAY_9, 2, ',', '.') . "</td>";
            // $data .= "<td style='text-align:center'>" . number_format($isi->QUOTA_PR_DAY_10, 2, ',', '.') . "</td>";
            // $data .= "<td style='text-align:center'>" . number_format($isi->QUOTA_PR_DAY_11, 2, ',', '.') . "</td>";
            // $data .= "<td style='text-align:center'>" . number_format($isi->QUOTA_PR_DAY_12, 2, ',', '.') . "</td>";
            // $data .= "<td style='text-align:center'>" . number_format($isi->QUOTA_PR_DAY_13, 2, ',', '.') . "</td>";
            // $data .= "<td style='text-align:center'>" . number_format($isi->QUOTA_PR_DAY_14, 2, ',', '.') . "</td>";
            // $data .= "<td style='text-align:center'>" . number_format($isi->QUOTA_PR_DAY_15, 2, ',', '.') . "</td>";
            // $data .= "<td style='text-align:center'>" . number_format($isi->QUOTA_PR_DAY_16, 2, ',', '.') . "</td>";
            // $data .= "<td style='text-align:center'>" . number_format($isi->QUOTA_PR_DAY_17, 2, ',', '.') . "</td>";
            // $data .= "<td style='text-align:center'>" . number_format($isi->QUOTA_PR_DAY_18, 2, ',', '.') . "</td>";
            // $data .= "<td style='text-align:center'>" . number_format($isi->QUOTA_PR_DAY_19, 2, ',', '.') . "</td>";
            // $data .= "<td style='text-align:center'>" . number_format($isi->QUOTA_PR_DAY_20, 2, ',', '.') . "</td>";
            // $data .= "<td style='text-align:center'>" . number_format($isi->QUOTA_PR_DAY_21, 2, ',', '.') . "</td>";
            // $data .= "<td style='text-align:center'>" . number_format($isi->QUOTA_PR_DAY_22, 2, ',', '.') . "</td>";
            // $data .= "<td style='text-align:center'>" . number_format($isi->QUOTA_PR_DAY_23, 2, ',', '.') . "</td>";
            // $data .= "<td style='text-align:center'>" . number_format($isi->QUOTA_PR_DAY_24, 2, ',', '.') . "</td>";
            // $data .= "<td style='text-align:center'>" . number_format($isi->QUOTA_PR_DAY_25, 2, ',', '.') . "</td>";
            // $data .= "<td style='text-align:center'>" . number_format($isi->QUOTA_PR_DAY_26, 2, ',', '.') . "</td>";
            // $data .= "<td style='text-align:center'>" . number_format($isi->QUOTA_PR_DAY_27, 2, ',', '.') . "</td>";
            // $data .= "<td style='text-align:center'>" . number_format($isi->QUOTA_PR_DAY_28, 2, ',', '.') . "</td>";
            // $data .= "<td style='text-align:center'>" . number_format($isi->QUOTA_PR_DAY_29, 2, ',', '.') . "</td>";
            // $data .= "<td style='text-align:center'>" . number_format($isi->QUOTA_PR_DAY_30, 2, ',', '.') . "</td>";
            // $data .= "<td style='text-align:center'>" . number_format($isi->QUOTA_PR_DAY_31, 2, ',', '.') . "</td>";

            $data .= "<td style='text-align:center'><strong>" . number_format($isi->QUANTITY_QUOTA_PR, 2, ',', '.') . "</strong></td>";
            $data .= "<td style='text-align:center'>" . number_format($isi->SALDO_QUOTA_PR, 2, ',', '.') . "</td>";
            $data .= "<td style='text-align:center'>" . number_format($isi->TERPAKAI_QUOTA_PR, 2, ',', '.') . "</td>";
            $data .= "<td style='text-align:center'>" . number_format($saldo_pr, 2, ',', '.') . "</td>";
            $data .= "<td style='text-align:center'><strong>" . number_format($next_saldo_pr, 2, ',', '.') . "</strong></td>";

            // $data .= "<td style='text-align:center'>" . number_format($isi->QUOTA_IM_DAY_1, 2, ',', '.') . "</td>";
            // $data .= "<td style='text-align:center'>" . number_format($isi->QUOTA_IM_DAY_2, 2, ',', '.') . "</td>";
            // $data .= "<td style='text-align:center'>" . number_format($isi->QUOTA_IM_DAY_3, 2, ',', '.') . "</td>";
            // $data .= "<td style='text-align:center'>" . number_format($isi->QUOTA_IM_DAY_4, 2, ',', '.') . "</td>";
            // $data .= "<td style='text-align:center'>" . number_format($isi->QUOTA_IM_DAY_5, 2, ',', '.') . "</td>";
            // $data .= "<td style='text-align:center'>" . number_format($isi->QUOTA_IM_DAY_6, 2, ',', '.') . "</td>";
            // $data .= "<td style='text-align:center'>" . number_format($isi->QUOTA_IM_DAY_7, 2, ',', '.') . "</td>";
            // $data .= "<td style='text-align:center'>" . number_format($isi->QUOTA_IM_DAY_8, 2, ',', '.') . "</td>";
            // $data .= "<td style='text-align:center'>" . number_format($isi->QUOTA_IM_DAY_9, 2, ',', '.') . "</td>";
            // $data .= "<td style='text-align:center'>" . number_format($isi->QUOTA_IM_DAY_10, 2, ',', '.') . "</td>";
            // $data .= "<td style='text-align:center'>" . number_format($isi->QUOTA_IM_DAY_11, 2, ',', '.') . "</td>";
            // $data .= "<td style='text-align:center'>" . number_format($isi->QUOTA_IM_DAY_12, 2, ',', '.') . "</td>";
            // $data .= "<td style='text-align:center'>" . number_format($isi->QUOTA_IM_DAY_13, 2, ',', '.') . "</td>";
            // $data .= "<td style='text-align:center'>" . number_format($isi->QUOTA_IM_DAY_14, 2, ',', '.') . "</td>";
            // $data .= "<td style='text-align:center'>" . number_format($isi->QUOTA_IM_DAY_15, 2, ',', '.') . "</td>";
            // $data .= "<td style='text-align:center'>" . number_format($isi->QUOTA_IM_DAY_16, 2, ',', '.') . "</td>";
            // $data .= "<td style='text-align:center'>" . number_format($isi->QUOTA_IM_DAY_17, 2, ',', '.') . "</td>";
            // $data .= "<td style='text-align:center'>" . number_format($isi->QUOTA_IM_DAY_18, 2, ',', '.') . "</td>";
            // $data .= "<td style='text-align:center'>" . number_format($isi->QUOTA_IM_DAY_19, 2, ',', '.') . "</td>";
            // $data .= "<td style='text-align:center'>" . number_format($isi->QUOTA_IM_DAY_20, 2, ',', '.') . "</td>";
            // $data .= "<td style='text-align:center'>" . number_format($isi->QUOTA_IM_DAY_21, 2, ',', '.') . "</td>";
            // $data .= "<td style='text-align:center'>" . number_format($isi->QUOTA_IM_DAY_22, 2, ',', '.') . "</td>";
            // $data .= "<td style='text-align:center'>" . number_format($isi->QUOTA_IM_DAY_23, 2, ',', '.') . "</td>";
            // $data .= "<td style='text-align:center'>" . number_format($isi->QUOTA_IM_DAY_24, 2, ',', '.') . "</td>";
            // $data .= "<td style='text-align:center'>" . number_format($isi->QUOTA_IM_DAY_25, 2, ',', '.') . "</td>";
            // $data .= "<td style='text-align:center'>" . number_format($isi->QUOTA_IM_DAY_26, 2, ',', '.') . "</td>";
            // $data .= "<td style='text-align:center'>" . number_format($isi->QUOTA_IM_DAY_27, 2, ',', '.') . "</td>";
            // $data .= "<td style='text-align:center'>" . number_format($isi->QUOTA_IM_DAY_28, 2, ',', '.') . "</td>";
            // $data .= "<td style='text-align:center'>" . number_format($isi->QUOTA_IM_DAY_29, 2, ',', '.') . "</td>";
            // $data .= "<td style='text-align:center'>" . number_format($isi->QUOTA_IM_DAY_30, 2, ',', '.') . "</td>";
            // $data .= "<td style='text-align:center'>" . number_format($isi->QUOTA_IM_DAY_31, 2, ',', '.') . "</td>";

            $data .= "<td style='text-align:center'><strong>" . number_format($isi->QUANTITY_QUOTA_IM, 2, ',', '.') . "</strong></td>";
            $data .= "<td style='text-align:center'>" . number_format($isi->SALDO_QUOTA_IM, 2, ',', '.') . "</td>";
            $data .= "<td style='text-align:center'>" . number_format($isi->TERPAKAI_QUOTA_IM, 2, ',', '.') . "</td>";
            $data .= "<td style='text-align:center'>" . number_format($saldo_im, 2, ',', '.') . "</td>";
            $data .= "<td style='text-align:center'><strong>" . number_format($next_saldo_im, 2, ',', '.') . "</strong></td>";
            if ($data_policy->POLICY_VAL >= $isi->QUANTITY_QUOTA_PR) {
                $data .= "<td style='text-align:center'>GM</td>";
            } else {
                $data .= "<td style='text-align:center'>DIR</td>";
            }
            // $data .= "<td style='text-align:center'>$data_policy->POLICY_VAL</td>";
            $data .= "</tr>";

            $i++;
        }

        $data .= "<tr align='center' style='font-weight:bold;'>";
        $data .= "<td colspan='4'>TOTAL</td>";
        // $data .= "<td colspan='31'></td>";
        $data .= "<td>" . number_format($tot_qr_pr, 2, ',', '.') . "</td>";
        $data .= "<td colspan='3'></td>";
        $data .= "<td>" . number_format($tot_saldo_pr, 2, ',', '.') . "</td>";
        // $data .= "<td colspan='31'></td>";
        $data .= "<td>" . number_format($tot_qr_im, 2, ',', '.') . "</td>";
        $data .= "<td colspan='3'></td>";
        $data .= "<td>" . number_format($tot_saldo_im, 2, ',', '.') . "</td>";
        $data .= "<td colspan='1'></td>";
        $data .= "</tr>";

        echo $data;
    }

    //SUPERVISOR
    function view_detail_quota_employee_by_spv()
    {
        $qrno = $this->input->post("qrno");
        $period = '20' . substr($this->input->post("qrno"), 0, 4);
        $data_baseon_qr = $this->quota_employee_m->get_data_request_quota_employee_by_qrno_for_spv($qrno);

        $first_sunday = $this->firstSunday(substr($period, 0, 4) . '-' . substr($period, 4, 2));
        $first_saturday = $this->firstSaturday(substr($period, 0, 4) . '-' . substr($period, 4, 2));

        $data = "";
        $tot_qr_pr = 0;
        $tot_saldo_pr = 0;
        $tot_qr_im = 0;
        $tot_saldo_im = 0;

        $i = 1;
        foreach ($data_baseon_qr as $isi) {
            $saldo_pr = $isi->SALDO_QUOTA_PR - $isi->TERPAKAI_QUOTA_PR;
            $next_saldo_pr = $saldo_pr + $isi->QUANTITY_QUOTA_PR;
            $saldo_im = $isi->SALDO_QUOTA_IM - $isi->TERPAKAI_QUOTA_IM;
            $next_saldo_im = $saldo_im + $isi->QUANTITY_QUOTA_IM;

            $tot_qr_pr = $tot_qr_pr + $isi->QUANTITY_QUOTA_PR;
            $tot_saldo_pr = $tot_saldo_pr + $next_saldo_pr;
            $tot_qr_im = $tot_qr_im + $isi->QUANTITY_QUOTA_IM;
            $tot_saldo_im = $tot_saldo_im + $next_saldo_im;

            $data .= "<tr class='gradeX'>";
            $data .= "<td>$i</td>";
            $data .= "<td style='vertical-align: middle;text-align:center'><strong>$isi->NPK</strong></td>";
            $data .= "<td style='vertical-align: middle;text-align:left'>$isi->NAMA</td>";
            $data .= "<td style='vertical-align: middle;text-align:center'>$isi->KD_SECTION</td>";
            $data .= "<td style='vertical-align: middle;text-align:center'>$isi->KD_SUB_SECTION</td>";
            $data .= "<td style='vertical-align: middle;text-align:center'><strong>" . number_format($isi->QUANTITY_QUOTA_PR, 2, ',', '.') . "</strong></td>";
            $data .= "<td style='vertical-align: middle;text-align:center'>" . number_format($isi->SALDO_QUOTA_PR, 2, ',', '.') . "</td>";
            $data .= "<td style='vertical-align: middle;text-align:center'>" . number_format($isi->TERPAKAI_QUOTA_PR, 2, ',', '.') . "</td>";
            $data .= "<td style='vertical-align: middle;text-align:center'>" . number_format($saldo_pr, 2, ',', '.') . "</td>";
            $data .= "<td style='vertical-align: middle;text-align:center'><strong>" . number_format($next_saldo_pr, 2, ',', '.') . "</strong></td>";
            $data .= "<td style='vertical-align: middle;text-align:center'><strong>" . number_format($isi->QUANTITY_QUOTA_IM, 2, ',', '.') . "</strong></td>";
            $data .= "<td style='vertical-align: middle;text-align:center'>" . number_format($isi->SALDO_QUOTA_IM, 2, ',', '.') . "</td>";
            $data .= "<td style='vertical-align: middle;text-align:center'>" . number_format($isi->TERPAKAI_QUOTA_IM, 2, ',', '.') . "</td>";
            $data .= "<td style='vertical-align: middle;text-align:center'>" . number_format($saldo_im, 2, ',', '.') . "</td>";
            $data .= "<td style='vertical-align: middle;text-align:center'><strong>" . number_format($next_saldo_im, 2, ',', '.') . "</strong></td>";
            $data .= "</tr>";

            $i++;
        }

        $data .= "<tr align='center' style='font-weight:bold;'>";
        $data .= "<td colspan='5'>TOTAL</td>";
        $data .= "<td>" . number_format($tot_qr_pr, 2, ',', '.') . "</td>";
        $data .= "<td colspan='3'></td>";
        $data .= "<td>" . number_format($tot_saldo_pr, 2, ',', '.') . "</td>";
        $data .= "<td>" . number_format($tot_qr_im, 2, ',', '.') . "</td>";
        $data .= "<td colspan='3'></td>";
        $data .= "<td>" . number_format($tot_saldo_im, 2, ',', '.') . "</td>";
        $data .= "</tr>";

        $data_detail = "";

        $j = 1;
        foreach ($data_baseon_qr as $isi) {
            $data_detail .= "<tr class='gradeX'>";
            $data_detail .= "<td>$j</td>";
            $data_detail .= "<td style='text-align:center'>$isi->NPK</td>";
            $data_detail .= "<td style='text-align:left'>$isi->NAMA</td>";
            if ($isi->DAY_1 == 0) {
                $data_detail .= "<td style='text-align:center'>-</td>";
            } else {
                $data_detail .= "<td style='text-align:center'>" . number_format($isi->DAY_1, 1, ',', '.') . "</td>";
            }
            if ($isi->DAY_2 == 0) {
                $data_detail .= "<td style='text-align:center'>-</td>";
            } else {
                $data_detail .= "<td style='text-align:center'>" . number_format($isi->DAY_2, 1, ',', '.') . "</td>";
            }
            if ($isi->DAY_3 == 0) {
                $data_detail .= "<td style='text-align:center'>-</td>";
            } else {
                $data_detail .= "<td style='text-align:center'>" . number_format($isi->DAY_3, 1, ',', '.') . "</td>";
            }
            if ($isi->DAY_4 == 0) {
                $data_detail .= "<td style='text-align:center'>-</td>";
            } else {
                $data_detail .= "<td style='text-align:center'>" . number_format($isi->DAY_4, 1, ',', '.') . "</td>";
            }
            if ($isi->DAY_5 == 0) {
                $data_detail .= "<td style='text-align:center'>-</td>";
            } else {
                $data_detail .= "<td style='text-align:center'>" . number_format($isi->DAY_5, 1, ',', '.') . "</td>";
            }
            if ($isi->DAY_6 == 0) {
                $data_detail .= "<td style='text-align:center'>-</td>";
            } else {
                $data_detail .= "<td style='text-align:center'>" . number_format($isi->DAY_6, 1, ',', '.') . "</td>";
            }
            if ($isi->DAY_7 == 0) {
                $data_detail .= "<td style='text-align:center'>-</td>";
            } else {
                $data_detail .= "<td style='text-align:center'>" . number_format($isi->DAY_7, 1, ',', '.') . "</td>";
            }
            if ($isi->DAY_8 == 0) {
                $data_detail .= "<td style='text-align:center'>-</td>";
            } else {
                $data_detail .= "<td style='text-align:center'>" . number_format($isi->DAY_8, 1, ',', '.') . "</td>";
            }
            if ($isi->DAY_9 == 0) {
                $data_detail .= "<td style='text-align:center'>-</td>";
            } else {
                $data_detail .= "<td style='text-align:center'>" . number_format($isi->DAY_9, 1, ',', '.') . "</td>";
            }
            if ($isi->DAY_10 == 0) {
                $data_detail .= "<td style='text-align:center'>-</td>";
            } else {
                $data_detail .= "<td style='text-align:center'>" . number_format($isi->DAY_10, 1, ',', '.') . "</td>";
            }
            if ($isi->DAY_11 == 0) {
                $data_detail .= "<td style='text-align:center'>-</td>";
            } else {
                $data_detail .= "<td style='text-align:center'>" . number_format($isi->DAY_11, 1, ',', '.') . "</td>";
            }
            if ($isi->DAY_12 == 0) {
                $data_detail .= "<td style='text-align:center'>-</td>";
            } else {
                $data_detail .= "<td style='text-align:center'>" . number_format($isi->DAY_12, 1, ',', '.') . "</td>";
            }
            if ($isi->DAY_13 == 0) {
                $data_detail .= "<td style='text-align:center'>-</td>";
            } else {
                $data_detail .= "<td style='text-align:center'>" . number_format($isi->DAY_13, 1, ',', '.') . "</td>";
            }
            if ($isi->DAY_14 == 0) {
                $data_detail .= "<td style='text-align:center'>-</td>";
            } else {
                $data_detail .= "<td style='text-align:center'>" . number_format($isi->DAY_14, 1, ',', '.') . "</td>";
            }
            if ($isi->DAY_15 == 0) {
                $data_detail .= "<td style='text-align:center'>-</td>";
            } else {
                $data_detail .= "<td style='text-align:center'>" . number_format($isi->DAY_15, 1, ',', '.') . "</td>";
            }
            if ($isi->DAY_16 == 0) {
                $data_detail .= "<td style='text-align:center'>-</td>";
            } else {
                $data_detail .= "<td style='text-align:center'>" . number_format($isi->DAY_16, 1, ',', '.') . "</td>";
            }
            if ($isi->DAY_17 == 0) {
                $data_detail .= "<td style='text-align:center'>-</td>";
            } else {
                $data_detail .= "<td style='text-align:center'>" . number_format($isi->DAY_17, 1, ',', '.') . "</td>";
            }
            if ($isi->DAY_18 == 0) {
                $data_detail .= "<td style='text-align:center'>-</td>";
            } else {
                $data_detail .= "<td style='text-align:center'>" . number_format($isi->DAY_18, 1, ',', '.') . "</td>";
            }
            if ($isi->DAY_19 == 0) {
                $data_detail .= "<td style='text-align:center'>-</td>";
            } else {
                $data_detail .= "<td style='text-align:center'>" . number_format($isi->DAY_19, 1, ',', '.') . "</td>";
            }
            if ($isi->DAY_20 == 0) {
                $data_detail .= "<td style='text-align:center'>-</td>";
            } else {
                $data_detail .= "<td style='text-align:center'>" . number_format($isi->DAY_20, 1, ',', '.') . "</td>";
            }
            if ($isi->DAY_21 == 0) {
                $data_detail .= "<td style='text-align:center'>-</td>";
            } else {
                $data_detail .= "<td style='text-align:center'>" . number_format($isi->DAY_21, 1, ',', '.') . "</td>";
            }
            if ($isi->DAY_22 == 0) {
                $data_detail .= "<td style='text-align:center'>-</td>";
            } else {
                $data_detail .= "<td style='text-align:center'>" . number_format($isi->DAY_22, 1, ',', '.') . "</td>";
            }
            if ($isi->DAY_23 == 0) {
                $data_detail .= "<td style='text-align:center'>-</td>";
            } else {
                $data_detail .= "<td style='text-align:center'>" . number_format($isi->DAY_23, 1, ',', '.') . "</td>";
            }
            if ($isi->DAY_24 == 0) {
                $data_detail .= "<td style='text-align:center'>-</td>";
            } else {
                $data_detail .= "<td style='text-align:center'>" . number_format($isi->DAY_24, 1, ',', '.') . "</td>";
            }
            if ($isi->DAY_25 == 0) {
                $data_detail .= "<td style='text-align:center'>-</td>";
            } else {
                $data_detail .= "<td style='text-align:center'>" . number_format($isi->DAY_25, 1, ',', '.') . "</td>";
            }
            if ($isi->DAY_26 == 0) {
                $data_detail .= "<td style='text-align:center'>-</td>";
            } else {
                $data_detail .= "<td style='text-align:center'>" . number_format($isi->DAY_26, 1, ',', '.') . "</td>";
            }
            if ($isi->DAY_27 == 0) {
                $data_detail .= "<td style='text-align:center'>-</td>";
            } else {
                $data_detail .= "<td style='text-align:center'>" . number_format($isi->DAY_27, 1, ',', '.') . "</td>";
            }
            if ($isi->DAY_28 == 0) {
                $data_detail .= "<td style='text-align:center'>-</td>";
            } else {
                $data_detail .= "<td style='text-align:center'>" . number_format($isi->DAY_28, 1, ',', '.') . "</td>";
            }
            if ($isi->DAY_29 == 0) {
                $data_detail .= "<td style='text-align:center'>-</td>";
            } else {
                $data_detail .= "<td style='text-align:center'>" . number_format($isi->DAY_29, 1, ',', '.') . "</td>";
            }
            if ($isi->DAY_30 == 0) {
                $data_detail .= "<td style='text-align:center'>-</td>";
            } else {
                $data_detail .= "<td style='text-align:center'>" . number_format($isi->DAY_30, 1, ',', '.') . "</td>";
            }
            if ($isi->DAY_31 == 0) {
                $data_detail .= "<td style='text-align:center'>-</td>";
            } else {
                $data_detail .= "<td style='text-align:center'>" . number_format($isi->DAY_31, 1, ',', '.') . "</td>";
            }

            $data_detail .= "</tr>";

            $j++;
        }

        $json_data = array(
            'data' => $data,
            'data_detail' => $data_detail,
            'first_sunday' => $first_sunday,
            'first_saturday' => $first_saturday
        );

        echo json_encode($json_data);
    }

    function prepare_approve_quota_by_spv($period = NULL, $dept = NULL, $section = NULL, $msg = NULL)
    {
        if ($msg == 4) {
            $msg = "<div class = 'alert alert-success'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Approve success </strong> The data is successfully Approve </div >";
        } elseif ($msg == 5) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Reject success </strong> The data is successfully Reject </div >";
        } elseif ($msg == 12) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Executing error !</strong> Something error with parameter </div >";
        }

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(152);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Approval Quota Employee';
        $data['msg'] = $msg;

        $user_session = $this->session->all_userdata();
        $role = $user_session['ROLE'];
        $id_dept = $user_session['DEPT'];
        $id_group = $user_session['GROUPDEPT'];
        $id_division = $user_session['DIVISION'];

        if ($period == NULL) {
            $period = date('Ym');
        }

        if ($role == 1) {
            if ($dept == NULL) {
                $dept = $this->dept_m->get_top_data_dept_by_division($id_division)->row()->CHR_DEPT;
            } else {
                $dept = $dept;
            }
            $data['all_dept'] = $this->dept_m->get_dept_by_division_id($id_division);
        } else {
            if ($dept == NULL) {
                $dept = $this->dept_m->get_data_dept($id_dept)->row()->CHR_DEPT;
            } else {
                $dept = $dept;
            }
            $data['all_dept'] = $this->dept_m->get_data_dept($id_dept)->result();
        }

        $data['all_section'] = $this->overtime_m->get_section_by_dept($dept);

        if ($section == NULL) {
            $section = 'ALL';
        } else {
            $x = 0;
            foreach ($data['all_section'] as $value) {
                if (trim($value->KODE) == trim($section)) {
                    $x = 1;
                }
            }

            if ($x == 0) {
                $section = 'ALL';
            }
        }

        $data['section'] = $section;
        $data['period'] = $period;
        $data['dept'] = $dept;

        $data['data'] = $this->quota_employee_m->get_data_request_quota_employee($dept, $section, $period);
        $data['content'] = 'aorta/quota_employee/manage_quota_employee_by_spv_v';
        $this->load->view($this->layout, $data);
    }

    function approve_form_quota_employee_by_spv()
    {
        $qrno = $this->input->post("ID_DOC");
        $dept = $this->input->post("CHR_DEPT");
        $section = $this->input->post("CHR_SECTION");
        $period = $this->input->post("CHR_PERIOD");
        $date = date('Ymd');
        $time = date('His');

        $data = array(
            'SPV_APPROVE' => 1,
            'OPER_SPV_APPROVE' => $this->session->userdata('USERNAME'),
            'TGL_SPV_APPROVE' => $date,
            'JAM_SPV_APPROVE' => $time
        );

        $data_quota_request = $this->quota_employee_m->get_data_quota_request_by_period($period, $qrno);

        foreach ($data_quota_request as $isi_request) {

            $this->quota_employee_m->update_quota_employee_by_id_and_period_and_npk($data, $qrno, $period, $isi_request->NPK);

            $aortadb = $this->load->database("aorta", TRUE);

            $psnya = "Approve Quota By Kadept NPK : " . $isi_request->NPK . " periode : " . $period . " Production : " . $isi_request->QUANTITY_QUOTA_PR . " dan Improvement : " . $isi_request->QUANTITY_QUOTA_IM;
            $ip = gethostbyaddr($_SERVER['REMOTE_ADDR']);
            $created_by = $this->session->userdata('USERNAME');

            $aortadb->query("INSERT INTO TT_HISTORY(TGLTRANS,JAMTRANS,OTCPU,TIPETRANS,NO_SEQUENCE,OPERTRANS,OTVERSION,KETERANGAN,NPK) VALUES ('$date','$time', '$ip', 'APPROVE','$qrno','$created_by','AIS','$psnya','$isi_request->NPK')");
        }

        redirect($this->back_to_approve_spv . $period . '/' . $dept . '/' . $section . '/' . 4);
    }

    function unapprove_form_quota_employee_by_spv()
    {
        $qrno = $this->input->post("ID_DOC");
        $dept = $this->input->post("CHR_DEPT");
        $section = $this->input->post("CHR_SECTION");
        $period = $this->input->post("CHR_PERIOD");
        $date = date('Ymd');
        $time = date('His');

        $data = array(
            'SPV_APPROVE' => 0,
            'OPER_SPV_APPROVE' => '',
            'TGL_SPV_APPROVE' => '',
            'JAM_SPV_APPROVE' => ''
        );

        $data_quota_request = $this->quota_employee_m->get_data_quota_request_by_period($period, $qrno);

        foreach ($data_quota_request as $isi_request) {

            $this->quota_employee_m->update_quota_employee_by_id_and_period_and_npk($data, $qrno, $period, $isi_request->NPK);

            $aortadb = $this->load->database("aorta", TRUE);

            $psnya = "Unapprove Quota By Kadept NPK : " . $isi_request->NPK . " periode : " . $period . " Production : " . $isi_request->QUANTITY_QUOTA_PR . " dan Improvement : " . $isi_request->QUANTITY_QUOTA_IM;
            $psn = "QUOTA " . $isi_request->NPK;
            $ip = gethostbyaddr($_SERVER['REMOTE_ADDR']);
            $created_by = $this->session->userdata('USERNAME');

            $aortadb->query("INSERT INTO TT_HISTORY(TGLTRANS,JAMTRANS,OTCPU,TIPETRANS,NO_SEQUENCE,OPERTRANS,OTVERSION,KETERANGAN,NPK) VALUES ('$date','$time', '$ip', 'APPROVE','$psn','$created_by','AIS','$psnya','$isi_request->NPK')");
        }

        redirect($this->back_to_approve_spv . $period . '/' . $dept . '/' . $section . '/' . 4);
    }

    function approve_quota_employee_by_spv($qrno, $dept, $section, $period)
    {
        $date = date('Ymd');
        $time = date('His');

        $data = array(
            'SPV_APPROVE' => 1,
            'OPER_SPV_APPROVE' => $this->session->userdata('USERNAME'),
            'TGL_SPV_APPROVE' => $date,
            'JAM_SPV_APPROVE' => $time
        );

        $data_quota_request = $this->quota_employee_m->get_data_quota_request_by_period($period, $qrno);

        foreach ($data_quota_request as $isi_request) {

            $this->quota_employee_m->update_quota_employee_by_id_and_period_and_npk($data, $qrno, $period, $isi_request->NPK);

            $aortadb = $this->load->database("aorta", TRUE);

            $psnya = "Approve Quota By Kadept NPK : " . $isi_request->NPK . " periode : " . $period . " Production : " . $isi_request->QUANTITY_QUOTA_PR . " dan Improvement : " . $isi_request->QUANTITY_QUOTA_IM;
            $ip = gethostbyaddr($_SERVER['REMOTE_ADDR']);
            $created_by = $this->session->userdata('USERNAME');

            $aortadb->query("INSERT INTO TT_HISTORY(TGLTRANS,JAMTRANS,OTCPU,TIPETRANS,NO_SEQUENCE,OPERTRANS,OTVERSION,KETERANGAN,NPK) VALUES ('$date','$time', '$ip', 'APPROVE','$qrno','$created_by','AIS','$psnya','$isi_request->NPK')");
        }

        redirect($this->back_to_approve_spv . $period . '/' . $dept . '/' . $section . '/' . 4);
    }

    function unapprove_quota_employee_by_spv($qrno, $dept, $section, $period)
    {
        $date = date('Ymd');
        $time = date('His');

        $data = array(
            'SPV_APPROVE' => 0,
            'OPER_SPV_APPROVE' => '',
            'TGL_SPV_APPROVE' => '',
            'JAM_SPV_APPROVE' => ''
        );

        $data_quota_request = $this->quota_employee_m->get_data_quota_request_by_period($period, $qrno);

        foreach ($data_quota_request as $isi_request) {

            $this->quota_employee_m->update_quota_employee_by_id_and_period_and_npk($data, $qrno, $period, $isi_request->NPK);

            $aortadb = $this->load->database("aorta", TRUE);

            $psnya = "Unapprove Quota By Kadept NPK : " . $isi_request->NPK . " periode : " . $period . " Production : " . $isi_request->QUANTITY_QUOTA_PR . " dan Improvement : " . $isi_request->QUANTITY_QUOTA_IM;
            $ip = gethostbyaddr($_SERVER['REMOTE_ADDR']);
            $created_by = $this->session->userdata('USERNAME');

            $aortadb->query("INSERT INTO TT_HISTORY(TGLTRANS,JAMTRANS,OTCPU,TIPETRANS,NO_SEQUENCE,OPERTRANS,OTVERSION,KETERANGAN,NPK) VALUES ('$date','$time', '$ip', 'APPROVE','$qrno','$created_by','AIS','$psnya','$isi_request->NPK')");
        }

        redirect($this->back_to_approve_spv . $period . '/' . $dept . '/' . $section . '/' . 4);
    }

    function approve_all_quota_employee_by_spv()
    {

        $no_sequence_array = $this->input->post("noquota");
        $dept = $this->input->post("CHR_DEPT_2");
        $section = $this->input->post("CHR_SECTION_2");
        $period = $this->input->post("CHR_PERIOD_2");
        $date = date('Ymd');
        $time = date('His');

        $aortadb = $this->load->database("aorta", TRUE);

        foreach ($no_sequence_array as $qrno) {

            $data = array(
                'SPV_APPROVE' => 1,
                'OPER_SPV_APPROVE' => $this->session->userdata('USERNAME'),
                'TGL_SPV_APPROVE' => $date,
                'JAM_SPV_APPROVE' => $time
            );

            $data_quota_request = $this->quota_employee_m->get_data_quota_request_by_period($period, $qrno);

            foreach ($data_quota_request as $isi_request) {

                $this->quota_employee_m->update_quota_employee_by_id_and_period_and_npk($data, $qrno, $period, $isi_request->NPK);

                $psnya = "Approve Quota By Kadept NPK : " . $isi_request->NPK . " periode : " . $period . " Production : " . $isi_request->QUANTITY_QUOTA_PR . " dan Improvement : " . $isi_request->QUANTITY_QUOTA_IM;
                $ip = gethostbyaddr($_SERVER['REMOTE_ADDR']);
                $created_by = $this->session->userdata('USERNAME');

                $aortadb->query("INSERT INTO TT_HISTORY(TGLTRANS,JAMTRANS,OTCPU,TIPETRANS,NO_SEQUENCE,OPERTRANS,OTVERSION,KETERANGAN,NPK) VALUES ('$date','$time', '$ip', 'APPROVE','$qrno','$created_by','AIS','$psnya','$isi_request->NPK')");
            }
        }

        redirect($this->back_to_approve_spv . $period . '/' . $dept . '/' . $section . '/' . 4);
    }

    //MANAGER
    function view_detail_quota_employee_by_mgr()
    {
        $qrno = $this->input->post("qrno");
        $period = '20' . substr($this->input->post("qrno"), 0, 4);
        $data_baseon_qr = $this->quota_employee_m->get_data_request_quota_employee_by_qrno_for_mgr($qrno);

        $first_sunday = $this->firstSunday(substr($period, 0, 4) . '-' . substr($period, 4, 2));
        $first_saturday = $this->firstSaturday(substr($period, 0, 4) . '-' . substr($period, 4, 2));

        $data = "";
        $tot_qr_pr = 0;
        $tot_saldo_pr = 0;
        $tot_qr_im = 0;
        $tot_saldo_im = 0;

        $i = 1;
        foreach ($data_baseon_qr as $isi) {
            $saldo_pr = $isi->SALDO_QUOTA_PR - $isi->TERPAKAI_QUOTA_PR;
            $next_saldo_pr = $saldo_pr + $isi->QUANTITY_QUOTA_PR;
            $saldo_im = $isi->SALDO_QUOTA_IM - $isi->TERPAKAI_QUOTA_IM;
            $next_saldo_im = $saldo_im + $isi->QUANTITY_QUOTA_IM;

            $tot_qr_pr = $tot_qr_pr + $isi->QUANTITY_QUOTA_PR;
            $tot_saldo_pr = $tot_saldo_pr + $next_saldo_pr;
            $tot_qr_im = $tot_qr_im + $isi->QUANTITY_QUOTA_IM;
            $tot_saldo_im = $tot_saldo_im + $next_saldo_im;

            $data .= "<tr class='gradeX'>";
            $data .= "<td>$i</td>";
            $data .= "<td style='vertical-align: middle;text-align:center'><strong>$isi->NPK</strong></td>";
            $data .= "<td style='vertical-align: middle;text-align:left'>$isi->NAMA</td>";
            $data .= "<td style='vertical-align: middle;text-align:center'>$isi->KD_SECTION</td>";
            $data .= "<td style='vertical-align: middle;text-align:center'>$isi->KD_SUB_SECTION</td>";
            $data .= "<td style='vertical-align: middle;text-align:center'><strong>" . number_format($isi->QUANTITY_QUOTA_PR, 2, ',', '.') . "</strong></td>";
            $data .= "<td style='vertical-align: middle;text-align:center'>" . number_format($isi->SALDO_QUOTA_PR, 2, ',', '.') . "</td>";
            $data .= "<td style='vertical-align: middle;text-align:center'>" . number_format($isi->TERPAKAI_QUOTA_PR, 2, ',', '.') . "</td>";
            $data .= "<td style='vertical-align: middle;text-align:center'>" . number_format($saldo_pr, 2, ',', '.') . "</td>";
            $data .= "<td style='vertical-align: middle;text-align:center'><strong>" . number_format($next_saldo_pr, 2, ',', '.') . "</strong></td>";
            $data .= "<td style='vertical-align: middle;text-align:center'><strong>" . number_format($isi->QUANTITY_QUOTA_IM, 2, ',', '.') . "</strong></td>";
            $data .= "<td style='vertical-align: middle;text-align:center'>" . number_format($isi->SALDO_QUOTA_IM, 2, ',', '.') . "</td>";
            $data .= "<td style='vertical-align: middle;text-align:center'>" . number_format($isi->TERPAKAI_QUOTA_IM, 2, ',', '.') . "</td>";
            $data .= "<td style='vertical-align: middle;text-align:center'>" . number_format($saldo_im, 2, ',', '.') . "</td>";
            $data .= "<td style='vertical-align: middle;text-align:center'><strong>" . number_format($next_saldo_im, 2, ',', '.') . "</strong></td>";
            $data .= "</tr>";

            $i++;
        }

        $data .= "<tr align='center' style='font-weight:bold;'>";
        $data .= "<td colspan='5'>TOTAL</td>";
        $data .= "<td>" . number_format($tot_qr_pr, 2, ',', '.') . "</td>";
        $data .= "<td colspan='3'></td>";
        $data .= "<td>" . number_format($tot_saldo_pr, 2, ',', '.') . "</td>";
        $data .= "<td>" . number_format($tot_qr_im, 2, ',', '.') . "</td>";
        $data .= "<td colspan='3'></td>";
        $data .= "<td>" . number_format($tot_saldo_im, 2, ',', '.') . "</td>";
        $data .= "</tr>";

        $data_detail = "";

        $j = 1;
        foreach ($data_baseon_qr as $isi) {
            $data_detail .= "<tr class='gradeX'>";
            $data_detail .= "<td>$j</td>";
            $data_detail .= "<td style='text-align:center'>$isi->NPK</td>";
            $data_detail .= "<td style='text-align:left'>$isi->NAMA</td>";
            if ($isi->DAY_1 == 0) {
                $data_detail .= "<td style='text-align:center'>-</td>";
            } else {
                $data_detail .= "<td style='text-align:center'>" . number_format($isi->DAY_1, 1, ',', '.') . "</td>";
            }
            if ($isi->DAY_2 == 0) {
                $data_detail .= "<td style='text-align:center'>-</td>";
            } else {
                $data_detail .= "<td style='text-align:center'>" . number_format($isi->DAY_2, 1, ',', '.') . "</td>";
            }
            if ($isi->DAY_3 == 0) {
                $data_detail .= "<td style='text-align:center'>-</td>";
            } else {
                $data_detail .= "<td style='text-align:center'>" . number_format($isi->DAY_3, 1, ',', '.') . "</td>";
            }
            if ($isi->DAY_4 == 0) {
                $data_detail .= "<td style='text-align:center'>-</td>";
            } else {
                $data_detail .= "<td style='text-align:center'>" . number_format($isi->DAY_4, 1, ',', '.') . "</td>";
            }
            if ($isi->DAY_5 == 0) {
                $data_detail .= "<td style='text-align:center'>-</td>";
            } else {
                $data_detail .= "<td style='text-align:center'>" . number_format($isi->DAY_5, 1, ',', '.') . "</td>";
            }
            if ($isi->DAY_6 == 0) {
                $data_detail .= "<td style='text-align:center'>-</td>";
            } else {
                $data_detail .= "<td style='text-align:center'>" . number_format($isi->DAY_6, 1, ',', '.') . "</td>";
            }
            if ($isi->DAY_7 == 0) {
                $data_detail .= "<td style='text-align:center'>-</td>";
            } else {
                $data_detail .= "<td style='text-align:center'>" . number_format($isi->DAY_7, 1, ',', '.') . "</td>";
            }
            if ($isi->DAY_8 == 0) {
                $data_detail .= "<td style='text-align:center'>-</td>";
            } else {
                $data_detail .= "<td style='text-align:center'>" . number_format($isi->DAY_8, 1, ',', '.') . "</td>";
            }
            if ($isi->DAY_9 == 0) {
                $data_detail .= "<td style='text-align:center'>-</td>";
            } else {
                $data_detail .= "<td style='text-align:center'>" . number_format($isi->DAY_9, 1, ',', '.') . "</td>";
            }
            if ($isi->DAY_10 == 0) {
                $data_detail .= "<td style='text-align:center'>-</td>";
            } else {
                $data_detail .= "<td style='text-align:center'>" . number_format($isi->DAY_10, 1, ',', '.') . "</td>";
            }
            if ($isi->DAY_11 == 0) {
                $data_detail .= "<td style='text-align:center'>-</td>";
            } else {
                $data_detail .= "<td style='text-align:center'>" . number_format($isi->DAY_11, 1, ',', '.') . "</td>";
            }
            if ($isi->DAY_12 == 0) {
                $data_detail .= "<td style='text-align:center'>-</td>";
            } else {
                $data_detail .= "<td style='text-align:center'>" . number_format($isi->DAY_12, 1, ',', '.') . "</td>";
            }
            if ($isi->DAY_13 == 0) {
                $data_detail .= "<td style='text-align:center'>-</td>";
            } else {
                $data_detail .= "<td style='text-align:center'>" . number_format($isi->DAY_13, 1, ',', '.') . "</td>";
            }
            if ($isi->DAY_14 == 0) {
                $data_detail .= "<td style='text-align:center'>-</td>";
            } else {
                $data_detail .= "<td style='text-align:center'>" . number_format($isi->DAY_14, 1, ',', '.') . "</td>";
            }
            if ($isi->DAY_15 == 0) {
                $data_detail .= "<td style='text-align:center'>-</td>";
            } else {
                $data_detail .= "<td style='text-align:center'>" . number_format($isi->DAY_15, 1, ',', '.') . "</td>";
            }
            if ($isi->DAY_16 == 0) {
                $data_detail .= "<td style='text-align:center'>-</td>";
            } else {
                $data_detail .= "<td style='text-align:center'>" . number_format($isi->DAY_16, 1, ',', '.') . "</td>";
            }
            if ($isi->DAY_17 == 0) {
                $data_detail .= "<td style='text-align:center'>-</td>";
            } else {
                $data_detail .= "<td style='text-align:center'>" . number_format($isi->DAY_17, 1, ',', '.') . "</td>";
            }
            if ($isi->DAY_18 == 0) {
                $data_detail .= "<td style='text-align:center'>-</td>";
            } else {
                $data_detail .= "<td style='text-align:center'>" . number_format($isi->DAY_18, 1, ',', '.') . "</td>";
            }
            if ($isi->DAY_19 == 0) {
                $data_detail .= "<td style='text-align:center'>-</td>";
            } else {
                $data_detail .= "<td style='text-align:center'>" . number_format($isi->DAY_19, 1, ',', '.') . "</td>";
            }
            if ($isi->DAY_20 == 0) {
                $data_detail .= "<td style='text-align:center'>-</td>";
            } else {
                $data_detail .= "<td style='text-align:center'>" . number_format($isi->DAY_20, 1, ',', '.') . "</td>";
            }
            if ($isi->DAY_21 == 0) {
                $data_detail .= "<td style='text-align:center'>-</td>";
            } else {
                $data_detail .= "<td style='text-align:center'>" . number_format($isi->DAY_21, 1, ',', '.') . "</td>";
            }
            if ($isi->DAY_22 == 0) {
                $data_detail .= "<td style='text-align:center'>-</td>";
            } else {
                $data_detail .= "<td style='text-align:center'>" . number_format($isi->DAY_22, 1, ',', '.') . "</td>";
            }
            if ($isi->DAY_23 == 0) {
                $data_detail .= "<td style='text-align:center'>-</td>";
            } else {
                $data_detail .= "<td style='text-align:center'>" . number_format($isi->DAY_23, 1, ',', '.') . "</td>";
            }
            if ($isi->DAY_24 == 0) {
                $data_detail .= "<td style='text-align:center'>-</td>";
            } else {
                $data_detail .= "<td style='text-align:center'>" . number_format($isi->DAY_24, 1, ',', '.') . "</td>";
            }
            if ($isi->DAY_25 == 0) {
                $data_detail .= "<td style='text-align:center'>-</td>";
            } else {
                $data_detail .= "<td style='text-align:center'>" . number_format($isi->DAY_25, 1, ',', '.') . "</td>";
            }
            if ($isi->DAY_26 == 0) {
                $data_detail .= "<td style='text-align:center'>-</td>";
            } else {
                $data_detail .= "<td style='text-align:center'>" . number_format($isi->DAY_26, 1, ',', '.') . "</td>";
            }
            if ($isi->DAY_27 == 0) {
                $data_detail .= "<td style='text-align:center'>-</td>";
            } else {
                $data_detail .= "<td style='text-align:center'>" . number_format($isi->DAY_27, 1, ',', '.') . "</td>";
            }
            if ($isi->DAY_28 == 0) {
                $data_detail .= "<td style='text-align:center'>-</td>";
            } else {
                $data_detail .= "<td style='text-align:center'>" . number_format($isi->DAY_28, 1, ',', '.') . "</td>";
            }
            if ($isi->DAY_29 == 0) {
                $data_detail .= "<td style='text-align:center'>-</td>";
            } else {
                $data_detail .= "<td style='text-align:center'>" . number_format($isi->DAY_29, 1, ',', '.') . "</td>";
            }
            if ($isi->DAY_30 == 0) {
                $data_detail .= "<td style='text-align:center'>-</td>";
            } else {
                $data_detail .= "<td style='text-align:center'>" . number_format($isi->DAY_30, 1, ',', '.') . "</td>";
            }
            if ($isi->DAY_31 == 0) {
                $data_detail .= "<td style='text-align:center'>-</td>";
            } else {
                $data_detail .= "<td style='text-align:center'>" . number_format($isi->DAY_31, 1, ',', '.') . "</td>";
            }

            $data_detail .= "</tr>";

            $j++;
        }

        $json_data = array(
            'data' => $data,
            'data_detail' => $data_detail,
            'first_sunday' => $first_sunday,
            'first_saturday' => $first_saturday
        );

        echo json_encode($json_data);
    }

    // function getChartDetailQuotaPlanbyNo($no_sequence){
    //     $data = $this->quota_employee_m->get_plan_quota_by_sequence($no_sequence);
    // }


    //MGR
    function prepare_approve_quota_by_mgr($period = NULL, $dept = NULL, $section = NULL, $msg = NULL)
    {
        if ($msg == 4) {
            $msg = "<div class = 'alert alert-success'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Approve success </strong> The data is successfully Approve </div >";
        } elseif ($msg == 5) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Reject success </strong> The data is successfully Reject </div >";
        } elseif ($msg == 12) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Executing error !</strong> Something error with parameter </div >";
        }

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(152);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Approval Quota Employee';
        $data['msg'] = $msg;

        $user_session = $this->session->all_userdata();
        $role = $user_session['ROLE'];
        $id_dept = $user_session['DEPT'];
        $id_group = $user_session['GROUPDEPT'];
        $id_division = $user_session['DIVISION'];

        if ($period == NULL) {
            $period = date('Ym');
        }

        if ($role == 1) {
            if ($dept == NULL) {
                $dept = $this->dept_m->get_top_data_dept_by_division($id_division)->row()->CHR_DEPT;
            } else {
                $dept = $dept;
            }
            $data['all_dept'] = $this->dept_m->get_dept_by_division_id($id_division);
        } else {
            if ($dept == NULL) {
                $dept = $this->dept_m->get_data_dept($id_dept)->row()->CHR_DEPT;
            } else {
                $dept = $dept;
            }
            $data['all_dept'] = $this->dept_m->get_data_dept($id_dept)->result();
        }

        $data['all_section'] = $this->overtime_m->get_all_section_drop($dept);

        if ($section == NULL) {
            $section = 'ALL';
        } else {
            $x = 0;
            foreach ($data['all_section'] as $value) {
                if (trim($value->KODE) == trim($section)) {
                    $x = 1;
                }
            }

            if ($x == 0) {
                $section = 'ALL';
            }
        }

        $data['section'] = $section;
        $data['period'] = $period;
        $data['dept'] = $dept;

        $data['data'] = $this->quota_employee_m->get_data_request_quota_employee($dept, $section, $period);
        $data['content'] = 'aorta/quota_employee/manage_quota_employee_by_mgr_v';
        $this->load->view($this->layout, $data);
    }

    function approve_form_quota_employee_by_mgr()
    {
        $qrno = $this->input->post("ID_DOC");
        $dept = $this->input->post("CHR_DEPT");
        $section = $this->input->post("CHR_SECTION");
        $period = $this->input->post("CHR_PERIOD");
        $date = date('Ymd');
        $time = date('His');

        $data = array(
            'KADEP_APPROVE' => 1,
            'OPER_KADEP_APPROVE' => $this->session->userdata('USERNAME'),
            'TGL_KADEP_APPROVE' => $date,
            'JAM_KADEP_APPROVE' => $time
        );

        $data_quota_request = $this->quota_employee_m->get_data_quota_request_by_period($period, $qrno);

        foreach ($data_quota_request as $isi_request) {

            $this->quota_employee_m->update_quota_employee_by_id_and_period_and_npk($data, $qrno, $period, $isi_request->NPK);

            $aortadb = $this->load->database("aorta", TRUE);

            $psnya = "Approve Quota By Kadept NPK : " . $isi_request->NPK . " periode : " . $period . " Production : " . $isi_request->QUANTITY_QUOTA_PR . " dan Improvement : " . $isi_request->QUANTITY_QUOTA_IM;
            $ip = gethostbyaddr($_SERVER['REMOTE_ADDR']);
            $created_by = $this->session->userdata('USERNAME');

            $aortadb->query("INSERT INTO TT_HISTORY(TGLTRANS,JAMTRANS,OTCPU,TIPETRANS,NO_SEQUENCE,OPERTRANS,OTVERSION,KETERANGAN,NPK) VALUES ('$date','$time', '$ip', 'APPROVE','$qrno','$created_by','AIS','$psnya','$isi_request->NPK')");
        }

        redirect($this->back_to_approve_mgr . $period . '/' . $dept . '/' . $section . '/' . 4);
    }

    function unapprove_form_quota_employee_by_mgr()
    {
        $qrno = $this->input->post("ID_DOC");
        $dept = $this->input->post("CHR_DEPT");
        $section = $this->input->post("CHR_SECTION");
        $period = $this->input->post("CHR_PERIOD");
        $date = date('Ymd');
        $time = date('His');

        $data = array(
            'KADEP_APPROVE' => 0,
            'OPER_KADEP_APPROVE' => '',
            'TGL_KADEP_APPROVE' => '',
            'JAM_KADEP_APPROVE' => ''
        );

        $data_quota_request = $this->quota_employee_m->get_data_quota_request_by_period($period, $qrno);

        foreach ($data_quota_request as $isi_request) {

            $this->quota_employee_m->update_quota_employee_by_id_and_period_and_npk($data, $qrno, $period, $isi_request->NPK);

            $aortadb = $this->load->database("aorta", TRUE);

            $psnya = "Unapprove Quota By Kadept NPK : " . $isi_request->NPK . " periode : " . $period . " Production : " . $isi_request->QUANTITY_QUOTA_PR . " dan Improvement : " . $isi_request->QUANTITY_QUOTA_IM;
            $psn = "QUOTA " . $isi_request->NPK;
            $ip = gethostbyaddr($_SERVER['REMOTE_ADDR']);
            $created_by = $this->session->userdata('USERNAME');

            $aortadb->query("INSERT INTO TT_HISTORY(TGLTRANS,JAMTRANS,OTCPU,TIPETRANS,NO_SEQUENCE,OPERTRANS,OTVERSION,KETERANGAN,NPK) VALUES ('$date','$time', '$ip', 'APPROVE','$psn','$created_by','AIS','$psnya','$isi_request->NPK')");
        }

        redirect($this->back_to_approve_mgr . $period . '/' . $dept . '/' . $section . '/' . 4);
    }

    function approve_quota_employee_by_mgr($qrno, $dept, $section, $period)
    {
        $date = date('Ymd');
        $time = date('His');

        $data = array(
            'KADEP_APPROVE' => 1,
            'OPER_KADEP_APPROVE' => $this->session->userdata('USERNAME'),
            'TGL_KADEP_APPROVE' => $date,
            'JAM_KADEP_APPROVE' => $time
        );

        $data_quota_request = $this->quota_employee_m->get_data_quota_request_by_period($period, $qrno);

        foreach ($data_quota_request as $isi_request) {

            $this->quota_employee_m->update_quota_employee_by_id_and_period_and_npk($data, $qrno, $period, $isi_request->NPK);

            $aortadb = $this->load->database("aorta", TRUE);

            $psnya = "Approve Quota By Kadept NPK : " . $isi_request->NPK . " periode : " . $period . " Production : " . $isi_request->QUANTITY_QUOTA_PR . " dan Improvement : " . $isi_request->QUANTITY_QUOTA_IM;
            $ip = gethostbyaddr($_SERVER['REMOTE_ADDR']);
            $created_by = $this->session->userdata('USERNAME');

            $aortadb->query("INSERT INTO TT_HISTORY(TGLTRANS,JAMTRANS,OTCPU,TIPETRANS,NO_SEQUENCE,OPERTRANS,OTVERSION,KETERANGAN,NPK) VALUES ('$date','$time', '$ip', 'APPROVE','$qrno','$created_by','AIS','$psnya','$isi_request->NPK')");
        }

        redirect($this->back_to_approve_mgr . $period . '/' . $dept . '/' . $section . '/' . 4);
    }

    function unapprove_quota_employee_by_mgr($qrno, $dept, $section, $period)
    {
        $date = date('Ymd');
        $time = date('His');

        $data = array(
            'KADEP_APPROVE' => 0,
            'OPER_KADEP_APPROVE' => '',
            'TGL_KADEP_APPROVE' => '',
            'JAM_KADEP_APPROVE' => ''
        );

        $data_quota_request = $this->quota_employee_m->get_data_quota_request_by_period($period, $qrno);

        foreach ($data_quota_request as $isi_request) {

            $this->quota_employee_m->update_quota_employee_by_id_and_period_and_npk($data, $qrno, $period, $isi_request->NPK);

            $aortadb = $this->load->database("aorta", TRUE);

            $psnya = "Unapprove Quota By Kadept NPK : " . $isi_request->NPK . " periode : " . $period . " Production : " . $isi_request->QUANTITY_QUOTA_PR . " dan Improvement : " . $isi_request->QUANTITY_QUOTA_IM;
            $ip = gethostbyaddr($_SERVER['REMOTE_ADDR']);
            $created_by = $this->session->userdata('USERNAME');

            $aortadb->query("INSERT INTO TT_HISTORY(TGLTRANS,JAMTRANS,OTCPU,TIPETRANS,NO_SEQUENCE,OPERTRANS,OTVERSION,KETERANGAN,NPK) VALUES ('$date','$time', '$ip', 'APPROVE','$qrno','$created_by','AIS','$psnya','$isi_request->NPK')");
        }

        redirect($this->back_to_approve_mgr . $period . '/' . $dept . '/' . $section . '/' . 4);
    }

    function approve_all_quota_employee_by_mgr()
    {

        $no_sequence_array = $this->input->post("noquota");
        $dept = $this->input->post("CHR_DEPT_2");
        $section = $this->input->post("CHR_SECTION_2");
        $period = $this->input->post("CHR_PERIOD_2");
        $date = date('Ymd');
        $time = date('His');

        $aortadb = $this->load->database("aorta", TRUE);

        foreach ($no_sequence_array as $qrno) {

            $data = array(
                'KADEP_APPROVE' => 1,
                'OPER_KADEP_APPROVE' => $this->session->userdata('USERNAME'),
                'TGL_KADEP_APPROVE' => $date,
                'JAM_KADEP_APPROVE' => $time
            );

            $data_quota_request = $this->quota_employee_m->get_data_quota_request_by_period($period, $qrno);

            foreach ($data_quota_request as $isi_request) {

                $this->quota_employee_m->update_quota_employee_by_id_and_period_and_npk($data, $qrno, $period, $isi_request->NPK);

                $psnya = "Approve Quota By Kadept NPK : " . $isi_request->NPK . " periode : " . $period . " Production : " . $isi_request->QUANTITY_QUOTA_PR . " dan Improvement : " . $isi_request->QUANTITY_QUOTA_IM;
                $ip = gethostbyaddr($_SERVER['REMOTE_ADDR']);
                $created_by = $this->session->userdata('USERNAME');

                $aortadb->query("INSERT INTO TT_HISTORY(TGLTRANS,JAMTRANS,OTCPU,TIPETRANS,NO_SEQUENCE,OPERTRANS,OTVERSION,KETERANGAN,NPK) VALUES ('$date','$time', '$ip', 'APPROVE','$qrno','$created_by','AIS','$psnya','$isi_request->NPK')");
            }
        }

        redirect($this->back_to_approve_mgr . $period . '/' . $dept . '/' . $section . '/' . 4);
    }

    //GM
    function view_detail_quota_employee_by_gm()
    {
        $qrno = $this->input->post("qrno");
        $data_detail = $this->quota_employee_m->get_data_request_quota_employee_by_qrno_for_gm($qrno);
        $data = "";
        $i = 1;
        $tot_qr_pr = 0;
        $tot_saldo_pr = 0;
        $tot_qr_im = 0;
        $tot_saldo_im = 0;
        foreach ($data_detail as $isi) {
            $saldo_pr = $isi->SALDO_QUOTA_PR - $isi->TERPAKAI_QUOTA_PR;
            $next_saldo_pr = $saldo_pr + $isi->QUANTITY_QUOTA_PR;
            $saldo_im = $isi->SALDO_QUOTA_IM - $isi->TERPAKAI_QUOTA_IM;
            $next_saldo_im = $saldo_im + $isi->QUANTITY_QUOTA_IM;

            $tot_qr_pr = $tot_qr_pr + $isi->QUANTITY_QUOTA_PR;
            $tot_saldo_pr = $tot_saldo_pr + $next_saldo_pr;
            $tot_qr_im = $tot_qr_im + $isi->QUANTITY_QUOTA_IM;
            $tot_saldo_im = $tot_saldo_im + $next_saldo_im;

            $data .= "<tr class='gradeX'>";
            $data .= "<td>$i</td>";
            $data .= "<td style='vertical-align: middle;text-align:center'><strong>$isi->NPK</strong></td>";
            $data .= "<td style='vertical-align: middle;text-align:left'>$isi->NAMA</td>";
            $data .= "<td style='vertical-align: middle;text-align:center'>$isi->KD_SECTION</td>";
            $data .= "<td style='vertical-align: middle;text-align:center'>$isi->KD_SUB_SECTION</td>";
            $data .= "<td style='vertical-align: middle;text-align:center'><strong>" . number_format($isi->QUANTITY_QUOTA_PR, 2, ',', '.') . "</strong></td>";
            $data .= "<td style='vertical-align: middle;text-align:center'>" . number_format($isi->SALDO_QUOTA_PR, 2, ',', '.') . "</td>";
            $data .= "<td style='vertical-align: middle;text-align:center'>" . number_format($isi->TERPAKAI_QUOTA_PR, 2, ',', '.') . "</td>";
            $data .= "<td style='vertical-align: middle;text-align:center'>" . number_format($saldo_pr, 2, ',', '.') . "</td>";
            $data .= "<td style='vertical-align: middle;text-align:center'><strong>" . number_format($next_saldo_pr, 2, ',', '.') . "</strong></td>";
            $data .= "<td style='vertical-align: middle;text-align:center'><strong>" . number_format($isi->QUANTITY_QUOTA_IM, 2, ',', '.') . "</strong></td>";
            $data .= "<td style='vertical-align: middle;text-align:center'>" . number_format($isi->SALDO_QUOTA_IM, 2, ',', '.') . "</td>";
            $data .= "<td style='vertical-align: middle;text-align:center'>" . number_format($isi->TERPAKAI_QUOTA_IM, 2, ',', '.') . "</td>";
            $data .= "<td style='vertical-align: middle;text-align:center'>" . number_format($saldo_im, 2, ',', '.') . "</td>";
            $data .= "<td style='vertical-align: middle;text-align:center'><strong>" . number_format($next_saldo_im, 2, ',', '.') . "</strong></td>";
            $data .= "</tr>";

            $i++;
        }

        $data .= "<tr align='center' style='font-weight:bold;'>";
        $data .= "<td colspan='5'>TOTAL</td>";
        $data .= "<td>" . number_format($tot_qr_pr, 2, ',', '.') . "</td>";
        $data .= "<td colspan='3'></td>";
        $data .= "<td>" . number_format($tot_saldo_pr, 2, ',', '.') . "</td>";
        $data .= "<td>" . number_format($tot_qr_im, 2, ',', '.') . "</td>";
        $data .= "<td colspan='3'></td>";
        $data .= "<td>" . number_format($tot_saldo_im, 2, ',', '.') . "</td>";
        $data .= "</tr>";

        echo $data;
    }

    function prepare_approve_quota_by_gm($period = NULL, $dept = NULL, $msg = NULL)
    {
        if ($msg == 4) {
            $msg = "<div class = 'alert alert-success'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Approve success </strong> The data is successfully Approve </div >";
        } elseif ($msg == 5) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Reject success </strong> The data is successfully Reject </div >";
        } elseif ($msg == 6) {
            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Approve Failed </strong> No data has been selected </div >";
        } elseif ($msg == 12) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Executing error !</strong> Something error with parameter </div >";
        }

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(153);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Approval Quota Employee';
        $data['msg'] = $msg;

        $user_session = $this->session->all_userdata();
        $role = $user_session['ROLE'];
        $data['group'] = $this->groupdept_m->get_data_groupdept($user_session['GROUPDEPT'])->row()->GROUP_DEPT;

        if ($period == NULL) {
            $period = date('Ym');
        }

        if ($dept == NULL) {
            $dept = $this->overtime_m->get_top_dept_overtime_by_gm($data['group'])->row()->KODE;
        }

        if ($role == 1) {
            $data['all_dept'] = $this->overtime_m->get_dept_overtime();
        } else {
            $data['all_dept'] = $this->overtime_m->get_dept_overtime_by_gm($data['group']);
        }

        $data['period'] = $period;
        $data['dept'] = $dept;

        $data['detail_quota_group'] = $this->overtime_m->get_detail_quota_group_by_periode_gm($period, $data['group']);
        $data['quota_usage_dept'] = $this->overtime_m->get_detail_quota_group_per_dept_by_periode_gm($period, $data['group']);
        $data['data'] = $this->quota_employee_m->get_data_request_quota_employee_by_gm($data['dept'], $period);

        $data['content'] = 'aorta/quota_employee/manage_quota_employee_by_gm_v';
        $this->load->view($this->layout, $data);
    }

    function approve_form_quota_employee_by_gm()
    {
        $qrno = $this->input->post("ID_DOC");
        $dept = $this->input->post("CHR_DEPT");
        $period = $this->input->post("CHR_PERIOD");
        $date = date('Ymd');
        $time = date('His');
        $ip = gethostbyaddr($_SERVER['REMOTE_ADDR']);
        $created_by = $this->session->userdata('USERNAME');

        $aortadb = $this->load->database("aorta", TRUE);

        $data_quota_request = $this->quota_employee_m->get_data_quota_request_by_period($period, $qrno);

        foreach ($data_quota_request as $isi_request) {

            if ($isi_request->FLG_FINISH_APPROVE_BY_DIR == 0) {

                $data = array(
                    'GM_APPROVE' => 1,
                    'OPER_GM_APPROVE' => $created_by,
                    'TGL_GM_APPROVE' => $date,
                    'JAM_GM_APPROVE' => $time,
                    'FLG_FINISH_APPROVE' => 1,
                    'TGL_POSTING' => $date
                );

                $this->quota_employee_m->update_quota_employee_by_id_and_period_and_npk($data, $qrno, $period, $isi_request->NPK);

                //tt_quota_kry
                $data_quota = $this->quota_employee_m->get_data_quota_employee_by_period_and_npk($period, $isi_request->NPK);

                $quota_plan = (float) str_replace(",", ".", $data_quota->QUOTAPLAN) + (float) $isi_request->QUANTITY_QUOTA_PR;
                if ($quota_plan < 0) {
                    $quota_plan = 0;
                } else {
                    $quota_plan = str_replace(".", ",", $quota_plan);
                }

                $sisa_plan = (float) str_replace(",", ".", $data_quota->SISAPLAN) + (float) $isi_request->QUANTITY_QUOTA_PR;
                if ($sisa_plan < 0) {
                    $sisa_plan = 0;
                } else {
                    $sisa_plan = str_replace(".", ",", $sisa_plan);
                }

                $quota_plan1 = (float) str_replace(",", ".", $data_quota->QUOTAPLAN1) + (float) $isi_request->QUANTITY_QUOTA_IM;
                if ($quota_plan1 < 0) {
                    $quota_plan1 = 0;
                } else {
                    $quota_plan1 = str_replace(".", ",", $quota_plan1);
                }

                $sisa_plan1 = (float) str_replace(",", ".", $data_quota->SISAPLAN1) + (float) $isi_request->QUANTITY_QUOTA_IM;
                if ($sisa_plan1 < 0) {
                    $sisa_plan1 = 0;
                } else {
                    $sisa_plan1 = str_replace(".", ",", $sisa_plan1);
                }

                $quota = (float) str_replace(",", ".", $data_quota->QUOTA) + (float) $isi_request->QUANTITY_QUOTA_PR;
                if ($quota < 0) {
                    $quota = 0;
                } else {
                    $quota = str_replace(".", ",", $quota);
                }

                $sisa = (float) str_replace(",", ".", $data_quota->SISA) + (float) $isi_request->QUANTITY_QUOTA_PR;
                if ($sisa < 0) {
                    $sisa = 0;
                } else {
                    $sisa = str_replace(".", ",", $sisa);
                }

                $quota1 = (float) str_replace(",", ".", $data_quota->QUOTA1) + (float) $isi_request->QUANTITY_QUOTA_IM;
                if ($quota1 < 0) {
                    $quota1 = 0;
                } else {
                    $quota1 = str_replace(".", ",", $quota1);
                }

                $sisa1 = (float) str_replace(",", ".", $data_quota->SISA1) + (float) $isi_request->QUANTITY_QUOTA_IM;
                if ($sisa1 < 0) {
                    $sisa1 = 0;
                } else {
                    $sisa1 = str_replace(".", ",", $sisa1);
                }

                $pr_day1 = $data_quota->QUOTA_PR_DAY_1 + $isi_request->QUOTA_PR_DAY_1;
                $pr_day2 = $data_quota->QUOTA_PR_DAY_2 + $isi_request->QUOTA_PR_DAY_2;
                $pr_day3 = $data_quota->QUOTA_PR_DAY_3 + $isi_request->QUOTA_PR_DAY_3;
                $pr_day4 = $data_quota->QUOTA_PR_DAY_4 + $isi_request->QUOTA_PR_DAY_4;
                $pr_day5 = $data_quota->QUOTA_PR_DAY_5 + $isi_request->QUOTA_PR_DAY_5;
                $pr_day6 = $data_quota->QUOTA_PR_DAY_6 + $isi_request->QUOTA_PR_DAY_6;
                $pr_day7 = $data_quota->QUOTA_PR_DAY_7 + $isi_request->QUOTA_PR_DAY_7;
                $pr_day8 = $data_quota->QUOTA_PR_DAY_8 + $isi_request->QUOTA_PR_DAY_8;
                $pr_day9 = $data_quota->QUOTA_PR_DAY_9 + $isi_request->QUOTA_PR_DAY_9;
                $pr_day10 = $data_quota->QUOTA_PR_DAY_10 + $isi_request->QUOTA_PR_DAY_10;
                $pr_day11 = $data_quota->QUOTA_PR_DAY_11 + $isi_request->QUOTA_PR_DAY_11;
                $pr_day12 = $data_quota->QUOTA_PR_DAY_12 + $isi_request->QUOTA_PR_DAY_12;
                $pr_day13 = $data_quota->QUOTA_PR_DAY_13 + $isi_request->QUOTA_PR_DAY_13;
                $pr_day14 = $data_quota->QUOTA_PR_DAY_14 + $isi_request->QUOTA_PR_DAY_14;
                $pr_day15 = $data_quota->QUOTA_PR_DAY_15 + $isi_request->QUOTA_PR_DAY_15;
                $pr_day16 = $data_quota->QUOTA_PR_DAY_16 + $isi_request->QUOTA_PR_DAY_16;
                $pr_day17 = $data_quota->QUOTA_PR_DAY_17 + $isi_request->QUOTA_PR_DAY_17;
                $pr_day18 = $data_quota->QUOTA_PR_DAY_18 + $isi_request->QUOTA_PR_DAY_18;
                $pr_day19 = $data_quota->QUOTA_PR_DAY_19 + $isi_request->QUOTA_PR_DAY_19;
                $pr_day20 = $data_quota->QUOTA_PR_DAY_20 + $isi_request->QUOTA_PR_DAY_20;
                $pr_day21 = $data_quota->QUOTA_PR_DAY_21 + $isi_request->QUOTA_PR_DAY_21;
                $pr_day22 = $data_quota->QUOTA_PR_DAY_22 + $isi_request->QUOTA_PR_DAY_22;
                $pr_day23 = $data_quota->QUOTA_PR_DAY_23 + $isi_request->QUOTA_PR_DAY_23;
                $pr_day24 = $data_quota->QUOTA_PR_DAY_24 + $isi_request->QUOTA_PR_DAY_24;
                $pr_day25 = $data_quota->QUOTA_PR_DAY_25 + $isi_request->QUOTA_PR_DAY_25;
                $pr_day26 = $data_quota->QUOTA_PR_DAY_26 + $isi_request->QUOTA_PR_DAY_26;
                $pr_day27 = $data_quota->QUOTA_PR_DAY_27 + $isi_request->QUOTA_PR_DAY_27;
                $pr_day28 = $data_quota->QUOTA_PR_DAY_28 + $isi_request->QUOTA_PR_DAY_28;
                $pr_day29 = $data_quota->QUOTA_PR_DAY_29 + $isi_request->QUOTA_PR_DAY_29;
                $pr_day30 = $data_quota->QUOTA_PR_DAY_30 + $isi_request->QUOTA_PR_DAY_30;
                $pr_day31 = $data_quota->QUOTA_PR_DAY_31 + $isi_request->QUOTA_PR_DAY_31;

                $im_day1 = $data_quota->QUOTA_IM_DAY_1 + $isi_request->QUOTA_IM_DAY_1;
                $im_day2 = $data_quota->QUOTA_IM_DAY_2 + $isi_request->QUOTA_IM_DAY_2;
                $im_day3 = $data_quota->QUOTA_IM_DAY_3 + $isi_request->QUOTA_IM_DAY_3;
                $im_day4 = $data_quota->QUOTA_IM_DAY_4 + $isi_request->QUOTA_IM_DAY_4;
                $im_day5 = $data_quota->QUOTA_IM_DAY_5 + $isi_request->QUOTA_IM_DAY_5;
                $im_day6 = $data_quota->QUOTA_IM_DAY_6 + $isi_request->QUOTA_IM_DAY_6;
                $im_day7 = $data_quota->QUOTA_IM_DAY_7 + $isi_request->QUOTA_IM_DAY_7;
                $im_day8 = $data_quota->QUOTA_IM_DAY_8 + $isi_request->QUOTA_IM_DAY_8;
                $im_day9 = $data_quota->QUOTA_IM_DAY_9 + $isi_request->QUOTA_IM_DAY_9;
                $im_day10 = $data_quota->QUOTA_IM_DAY_10 + $isi_request->QUOTA_IM_DAY_10;
                $im_day11 = $data_quota->QUOTA_IM_DAY_11 + $isi_request->QUOTA_IM_DAY_11;
                $im_day12 = $data_quota->QUOTA_IM_DAY_12 + $isi_request->QUOTA_IM_DAY_12;
                $im_day13 = $data_quota->QUOTA_IM_DAY_13 + $isi_request->QUOTA_IM_DAY_13;
                $im_day14 = $data_quota->QUOTA_IM_DAY_14 + $isi_request->QUOTA_IM_DAY_14;
                $im_day15 = $data_quota->QUOTA_IM_DAY_15 + $isi_request->QUOTA_IM_DAY_15;
                $im_day16 = $data_quota->QUOTA_IM_DAY_16 + $isi_request->QUOTA_IM_DAY_16;
                $im_day17 = $data_quota->QUOTA_IM_DAY_17 + $isi_request->QUOTA_IM_DAY_17;
                $im_day18 = $data_quota->QUOTA_IM_DAY_18 + $isi_request->QUOTA_IM_DAY_18;
                $im_day19 = $data_quota->QUOTA_IM_DAY_19 + $isi_request->QUOTA_IM_DAY_19;
                $im_day20 = $data_quota->QUOTA_IM_DAY_20 + $isi_request->QUOTA_IM_DAY_20;
                $im_day21 = $data_quota->QUOTA_IM_DAY_21 + $isi_request->QUOTA_IM_DAY_21;
                $im_day22 = $data_quota->QUOTA_IM_DAY_22 + $isi_request->QUOTA_IM_DAY_22;
                $im_day23 = $data_quota->QUOTA_IM_DAY_23 + $isi_request->QUOTA_IM_DAY_23;
                $im_day24 = $data_quota->QUOTA_IM_DAY_24 + $isi_request->QUOTA_IM_DAY_24;
                $im_day25 = $data_quota->QUOTA_IM_DAY_25 + $isi_request->QUOTA_IM_DAY_25;
                $im_day26 = $data_quota->QUOTA_IM_DAY_26 + $isi_request->QUOTA_IM_DAY_26;
                $im_day27 = $data_quota->QUOTA_IM_DAY_27 + $isi_request->QUOTA_IM_DAY_27;
                $im_day28 = $data_quota->QUOTA_IM_DAY_28 + $isi_request->QUOTA_IM_DAY_28;
                $im_day29 = $data_quota->QUOTA_IM_DAY_29 + $isi_request->QUOTA_IM_DAY_29;
                $im_day30 = $data_quota->QUOTA_IM_DAY_30 + $isi_request->QUOTA_IM_DAY_30;
                $im_day31 = $data_quota->QUOTA_IM_DAY_31 + $isi_request->QUOTA_IM_DAY_31;

                //set quota stdr
                if (trim($data_quota->QUOTA_STD) == "0") {
                    $aortadb->query("UPDATE TT_QUOTA_KRY SET QUOTA_STD='$quota_plan' 
                    WHERE TAHUNBULAN='$period' and NPK='$isi_request->NPK'");
                }

                $aortadb->query("UPDATE TT_QUOTA_KRY SET 
                        QUOTAPLAN='$quota_plan', SISAPLAN='$sisa_plan', QUOTA='$quota', SISA='$sisa', 
                        QUOTAPLAN1='$quota_plan1', SISAPLAN1='$sisa_plan1', QUOTA1='$quota1', SISA1='$sisa1',
                        QUOTA_PR_DAY_1  = $pr_day1 ,
                        QUOTA_PR_DAY_2  = $pr_day2 ,
                        QUOTA_PR_DAY_3  = $pr_day3 ,
                        QUOTA_PR_DAY_4  = $pr_day4 ,
                        QUOTA_PR_DAY_5  = $pr_day5 ,
                        QUOTA_PR_DAY_6  = $pr_day6 ,
                        QUOTA_PR_DAY_7  = $pr_day7 ,
                        QUOTA_PR_DAY_8  = $pr_day8 ,
                        QUOTA_PR_DAY_9  = $pr_day9 ,
                        QUOTA_PR_DAY_10 = $pr_day10,
                        QUOTA_PR_DAY_11 = $pr_day11,
                        QUOTA_PR_DAY_12 = $pr_day12,
                        QUOTA_PR_DAY_13 = $pr_day13,
                        QUOTA_PR_DAY_14 = $pr_day14,
                        QUOTA_PR_DAY_15 = $pr_day15,
                        QUOTA_PR_DAY_16 = $pr_day16,
                        QUOTA_PR_DAY_17 = $pr_day17,
                        QUOTA_PR_DAY_18 = $pr_day18,
                        QUOTA_PR_DAY_19 = $pr_day19,
                        QUOTA_PR_DAY_20 = $pr_day20,
                        QUOTA_PR_DAY_21 = $pr_day21,
                        QUOTA_PR_DAY_22 = $pr_day22,
                        QUOTA_PR_DAY_23 = $pr_day23,
                        QUOTA_PR_DAY_24 = $pr_day24,
                        QUOTA_PR_DAY_25 = $pr_day25,
                        QUOTA_PR_DAY_26 = $pr_day26,
                        QUOTA_PR_DAY_27 = $pr_day27,
                        QUOTA_PR_DAY_28 = $pr_day28,
                        QUOTA_PR_DAY_29 = $pr_day29,
                        QUOTA_PR_DAY_30 = $pr_day30,
                        QUOTA_PR_DAY_31 = $pr_day31,
                        QUOTA_IM_DAY_1  = $im_day1 ,
                        QUOTA_IM_DAY_2  = $im_day2 ,
                        QUOTA_IM_DAY_3  = $im_day3 ,
                        QUOTA_IM_DAY_4  = $im_day4 ,
                        QUOTA_IM_DAY_5  = $im_day5 ,
                        QUOTA_IM_DAY_6  = $im_day6 ,
                        QUOTA_IM_DAY_7  = $im_day7 ,
                        QUOTA_IM_DAY_8  = $im_day8 ,
                        QUOTA_IM_DAY_9  = $im_day9 ,
                        QUOTA_IM_DAY_10 = $im_day10,
                        QUOTA_IM_DAY_11 = $im_day11,
                        QUOTA_IM_DAY_12 = $im_day12,
                        QUOTA_IM_DAY_13 = $im_day13,
                        QUOTA_IM_DAY_14 = $im_day14,
                        QUOTA_IM_DAY_15 = $im_day15,
                        QUOTA_IM_DAY_16 = $im_day16,
                        QUOTA_IM_DAY_17 = $im_day17,
                        QUOTA_IM_DAY_18 = $im_day18,
                        QUOTA_IM_DAY_19 = $im_day19,
                        QUOTA_IM_DAY_20 = $im_day20,
                        QUOTA_IM_DAY_21 = $im_day21,
                        QUOTA_IM_DAY_22 = $im_day22,
                        QUOTA_IM_DAY_23 = $im_day23,
                        QUOTA_IM_DAY_24 = $im_day24,
                        QUOTA_IM_DAY_25 = $im_day25,
                        QUOTA_IM_DAY_26 = $im_day26,
                        QUOTA_IM_DAY_27 = $im_day27,
                        QUOTA_IM_DAY_28 = $im_day28,
                        QUOTA_IM_DAY_29 = $im_day29,
                        QUOTA_IM_DAY_30 = $im_day30,
                        QUOTA_IM_DAY_31 = $im_day31
                        WHERE TAHUNBULAN = '$period' AND NPK='$isi_request->NPK'");

                $psnya = "Approve & Posting Quota By GM NPK : " . $isi_request->NPK . " periode : " . $period . " Production : " . $isi_request->QUANTITY_QUOTA_PR . " dan Improvement : " . $isi_request->QUANTITY_QUOTA_IM;
            } else {
                $data = array(
                    'GM_APPROVE' => 1,
                    'OPER_GM_APPROVE' => $created_by,
                    'TGL_GM_APPROVE' => $date,
                    'JAM_GM_APPROVE' => $time
                );

                $this->quota_employee_m->update_quota_employee_by_id_and_period_and_npk($data, $qrno, $period, $isi_request->NPK);

                $psnya = "Approve Quota By GM NPK : " . $isi_request->NPK . " periode : " . $period . " Production : " . $isi_request->QUANTITY_QUOTA_PR . " dan Improvement : " . $isi_request->QUANTITY_QUOTA_IM;
            }

            $aortadb->query("INSERT INTO TT_HISTORY(TGLTRANS,JAMTRANS,OTCPU,TIPETRANS,NO_SEQUENCE,OPERTRANS,OTVERSION,KETERANGAN,NPK) VALUES ('$date','$time', '$ip', 'APPROVE','$qrno','$created_by','AIS','$psnya','$isi_request->NPK')");
        }

        redirect($this->back_to_approve_gm . $period . '/' . $dept . '/' . 4);
    }

    function unapprove_form_quota_employee_by_gm($period, $dept)
    {
        redirect($this->back_to_approve_gm . $period . '/' . $dept . '/' . 4);
    }

    function approve_quota_employee_by_gm($qrno, $dept, $period)
    {
        $date = date('Ymd');
        $time = date('His');
        $ip = gethostbyaddr($_SERVER['REMOTE_ADDR']);
        $created_by = $this->session->userdata('USERNAME');

        $aortadb = $this->load->database("aorta", TRUE);

        $data_quota_request = $this->quota_employee_m->get_data_quota_request_by_period($period, $qrno);

        foreach ($data_quota_request as $isi_request) {

            if ($isi_request->FLG_FINISH_APPROVE_BY_DIR == 0) {

                $data = array(
                    'GM_APPROVE' => 1,
                    'OPER_GM_APPROVE' => $created_by,
                    'TGL_GM_APPROVE' => $date,
                    'JAM_GM_APPROVE' => $time,
                    'FLG_FINISH_APPROVE' => 1,
                    'TGL_POSTING' => $date
                );

                $this->quota_employee_m->update_quota_employee_by_id_and_period_and_npk($data, $qrno, $period, $isi_request->NPK);

                $data_quota = $this->quota_employee_m->get_data_quota_employee_by_period_and_npk($period, $isi_request->NPK);

                $quota_plan = (float) str_replace(",", ".", $data_quota->QUOTAPLAN) + (float) $isi_request->QUANTITY_QUOTA_PR;
                if ($quota_plan < 0) {
                    $quota_plan = 0;
                } else {
                    $quota_plan = str_replace(".", ",", $quota_plan);
                }

                $sisa_plan = (float) str_replace(",", ".", $data_quota->SISAPLAN) + (float) $isi_request->QUANTITY_QUOTA_PR;
                if ($sisa_plan < 0) {
                    $sisa_plan = 0;
                } else {
                    $sisa_plan = str_replace(".", ",", $sisa_plan);
                }

                $quota_plan1 = (float) str_replace(",", ".", $data_quota->QUOTAPLAN1) + (float) $isi_request->QUANTITY_QUOTA_IM;
                if ($quota_plan1 < 0) {
                    $quota_plan1 = 0;
                } else {
                    $quota_plan1 = str_replace(".", ",", $quota_plan1);
                }

                $sisa_plan1 = (float) str_replace(",", ".", $data_quota->SISAPLAN1) + (float) $isi_request->QUANTITY_QUOTA_IM;
                if ($sisa_plan1 < 0) {
                    $sisa_plan1 = 0;
                } else {
                    $sisa_plan1 = str_replace(".", ",", $sisa_plan1);
                }

                $quota = (float) str_replace(",", ".", $data_quota->QUOTA) + (float) $isi_request->QUANTITY_QUOTA_PR;
                if ($quota < 0) {
                    $quota = 0;
                } else {
                    $quota = str_replace(".", ",", $quota);
                }

                $sisa = (float) str_replace(",", ".", $data_quota->SISA) + (float) $isi_request->QUANTITY_QUOTA_PR;
                if ($sisa < 0) {
                    $sisa = 0;
                } else {
                    $sisa = str_replace(".", ",", $sisa);
                }

                $quota1 = (float) str_replace(",", ".", $data_quota->QUOTA1) + (float) $isi_request->QUANTITY_QUOTA_IM;
                if ($quota1 < 0) {
                    $quota1 = 0;
                } else {
                    $quota1 = str_replace(".", ",", $quota1);
                }

                $sisa1 = (float) str_replace(",", ".", $data_quota->SISA1) + (float) $isi_request->QUANTITY_QUOTA_IM;
                if ($sisa1 < 0) {
                    $sisa1 = 0;
                } else {
                    $sisa1 = str_replace(".", ",", $sisa1);
                }

                $pr_day1 = $data_quota->QUOTA_PR_DAY_1 + $isi_request->QUOTA_PR_DAY_1;
                $pr_day2 = $data_quota->QUOTA_PR_DAY_2 + $isi_request->QUOTA_PR_DAY_2;
                $pr_day3 = $data_quota->QUOTA_PR_DAY_3 + $isi_request->QUOTA_PR_DAY_3;
                $pr_day4 = $data_quota->QUOTA_PR_DAY_4 + $isi_request->QUOTA_PR_DAY_4;
                $pr_day5 = $data_quota->QUOTA_PR_DAY_5 + $isi_request->QUOTA_PR_DAY_5;
                $pr_day6 = $data_quota->QUOTA_PR_DAY_6 + $isi_request->QUOTA_PR_DAY_6;
                $pr_day7 = $data_quota->QUOTA_PR_DAY_7 + $isi_request->QUOTA_PR_DAY_7;
                $pr_day8 = $data_quota->QUOTA_PR_DAY_8 + $isi_request->QUOTA_PR_DAY_8;
                $pr_day9 = $data_quota->QUOTA_PR_DAY_9 + $isi_request->QUOTA_PR_DAY_9;
                $pr_day10 = $data_quota->QUOTA_PR_DAY_10 + $isi_request->QUOTA_PR_DAY_10;
                $pr_day11 = $data_quota->QUOTA_PR_DAY_11 + $isi_request->QUOTA_PR_DAY_11;
                $pr_day12 = $data_quota->QUOTA_PR_DAY_12 + $isi_request->QUOTA_PR_DAY_12;
                $pr_day13 = $data_quota->QUOTA_PR_DAY_13 + $isi_request->QUOTA_PR_DAY_13;
                $pr_day14 = $data_quota->QUOTA_PR_DAY_14 + $isi_request->QUOTA_PR_DAY_14;
                $pr_day15 = $data_quota->QUOTA_PR_DAY_15 + $isi_request->QUOTA_PR_DAY_15;
                $pr_day16 = $data_quota->QUOTA_PR_DAY_16 + $isi_request->QUOTA_PR_DAY_16;
                $pr_day17 = $data_quota->QUOTA_PR_DAY_17 + $isi_request->QUOTA_PR_DAY_17;
                $pr_day18 = $data_quota->QUOTA_PR_DAY_18 + $isi_request->QUOTA_PR_DAY_18;
                $pr_day19 = $data_quota->QUOTA_PR_DAY_19 + $isi_request->QUOTA_PR_DAY_19;
                $pr_day20 = $data_quota->QUOTA_PR_DAY_20 + $isi_request->QUOTA_PR_DAY_20;
                $pr_day21 = $data_quota->QUOTA_PR_DAY_21 + $isi_request->QUOTA_PR_DAY_21;
                $pr_day22 = $data_quota->QUOTA_PR_DAY_22 + $isi_request->QUOTA_PR_DAY_22;
                $pr_day23 = $data_quota->QUOTA_PR_DAY_23 + $isi_request->QUOTA_PR_DAY_23;
                $pr_day24 = $data_quota->QUOTA_PR_DAY_24 + $isi_request->QUOTA_PR_DAY_24;
                $pr_day25 = $data_quota->QUOTA_PR_DAY_25 + $isi_request->QUOTA_PR_DAY_25;
                $pr_day26 = $data_quota->QUOTA_PR_DAY_26 + $isi_request->QUOTA_PR_DAY_26;
                $pr_day27 = $data_quota->QUOTA_PR_DAY_27 + $isi_request->QUOTA_PR_DAY_27;
                $pr_day28 = $data_quota->QUOTA_PR_DAY_28 + $isi_request->QUOTA_PR_DAY_28;
                $pr_day29 = $data_quota->QUOTA_PR_DAY_29 + $isi_request->QUOTA_PR_DAY_29;
                $pr_day30 = $data_quota->QUOTA_PR_DAY_30 + $isi_request->QUOTA_PR_DAY_30;
                $pr_day31 = $data_quota->QUOTA_PR_DAY_31 + $isi_request->QUOTA_PR_DAY_31;

                $im_day1 = $data_quota->QUOTA_IM_DAY_1 + $isi_request->QUOTA_IM_DAY_1;
                $im_day2 = $data_quota->QUOTA_IM_DAY_2 + $isi_request->QUOTA_IM_DAY_2;
                $im_day3 = $data_quota->QUOTA_IM_DAY_3 + $isi_request->QUOTA_IM_DAY_3;
                $im_day4 = $data_quota->QUOTA_IM_DAY_4 + $isi_request->QUOTA_IM_DAY_4;
                $im_day5 = $data_quota->QUOTA_IM_DAY_5 + $isi_request->QUOTA_IM_DAY_5;
                $im_day6 = $data_quota->QUOTA_IM_DAY_6 + $isi_request->QUOTA_IM_DAY_6;
                $im_day7 = $data_quota->QUOTA_IM_DAY_7 + $isi_request->QUOTA_IM_DAY_7;
                $im_day8 = $data_quota->QUOTA_IM_DAY_8 + $isi_request->QUOTA_IM_DAY_8;
                $im_day9 = $data_quota->QUOTA_IM_DAY_9 + $isi_request->QUOTA_IM_DAY_9;
                $im_day10 = $data_quota->QUOTA_IM_DAY_10 + $isi_request->QUOTA_IM_DAY_10;
                $im_day11 = $data_quota->QUOTA_IM_DAY_11 + $isi_request->QUOTA_IM_DAY_11;
                $im_day12 = $data_quota->QUOTA_IM_DAY_12 + $isi_request->QUOTA_IM_DAY_12;
                $im_day13 = $data_quota->QUOTA_IM_DAY_13 + $isi_request->QUOTA_IM_DAY_13;
                $im_day14 = $data_quota->QUOTA_IM_DAY_14 + $isi_request->QUOTA_IM_DAY_14;
                $im_day15 = $data_quota->QUOTA_IM_DAY_15 + $isi_request->QUOTA_IM_DAY_15;
                $im_day16 = $data_quota->QUOTA_IM_DAY_16 + $isi_request->QUOTA_IM_DAY_16;
                $im_day17 = $data_quota->QUOTA_IM_DAY_17 + $isi_request->QUOTA_IM_DAY_17;
                $im_day18 = $data_quota->QUOTA_IM_DAY_18 + $isi_request->QUOTA_IM_DAY_18;
                $im_day19 = $data_quota->QUOTA_IM_DAY_19 + $isi_request->QUOTA_IM_DAY_19;
                $im_day20 = $data_quota->QUOTA_IM_DAY_20 + $isi_request->QUOTA_IM_DAY_20;
                $im_day21 = $data_quota->QUOTA_IM_DAY_21 + $isi_request->QUOTA_IM_DAY_21;
                $im_day22 = $data_quota->QUOTA_IM_DAY_22 + $isi_request->QUOTA_IM_DAY_22;
                $im_day23 = $data_quota->QUOTA_IM_DAY_23 + $isi_request->QUOTA_IM_DAY_23;
                $im_day24 = $data_quota->QUOTA_IM_DAY_24 + $isi_request->QUOTA_IM_DAY_24;
                $im_day25 = $data_quota->QUOTA_IM_DAY_25 + $isi_request->QUOTA_IM_DAY_25;
                $im_day26 = $data_quota->QUOTA_IM_DAY_26 + $isi_request->QUOTA_IM_DAY_26;
                $im_day27 = $data_quota->QUOTA_IM_DAY_27 + $isi_request->QUOTA_IM_DAY_27;
                $im_day28 = $data_quota->QUOTA_IM_DAY_28 + $isi_request->QUOTA_IM_DAY_28;
                $im_day29 = $data_quota->QUOTA_IM_DAY_29 + $isi_request->QUOTA_IM_DAY_29;
                $im_day30 = $data_quota->QUOTA_IM_DAY_30 + $isi_request->QUOTA_IM_DAY_30;
                $im_day31 = $data_quota->QUOTA_IM_DAY_31 + $isi_request->QUOTA_IM_DAY_31;

                //set quota stdr
                if (trim($data_quota->QUOTA_STD) == "0") {
                    $aortadb->query("UPDATE TT_QUOTA_KRY set QUOTA_STD='$quota_plan' WHERE TAHUNBULAN='$period' and NPK='$isi_request->NPK'");
                }

                $aortadb->query("UPDATE TT_QUOTA_KRY SET 
                    QUOTAPLAN='$quota_plan', SISAPLAN='$sisa_plan', QUOTA='$quota', SISA='$sisa', 
                    QUOTAPLAN1='$quota_plan1', SISAPLAN1='$sisa_plan1', QUOTA1='$quota1', SISA1='$sisa1',
                    QUOTA_PR_DAY_1  = $pr_day1 ,
                    QUOTA_PR_DAY_2  = $pr_day2 ,
                    QUOTA_PR_DAY_3  = $pr_day3 ,
                    QUOTA_PR_DAY_4  = $pr_day4 ,
                    QUOTA_PR_DAY_5  = $pr_day5 ,
                    QUOTA_PR_DAY_6  = $pr_day6 ,
                    QUOTA_PR_DAY_7  = $pr_day7 ,
                    QUOTA_PR_DAY_8  = $pr_day8 ,
                    QUOTA_PR_DAY_9  = $pr_day9 ,
                    QUOTA_PR_DAY_10 = $pr_day10,
                    QUOTA_PR_DAY_11 = $pr_day11,
                    QUOTA_PR_DAY_12 = $pr_day12,
                    QUOTA_PR_DAY_13 = $pr_day13,
                    QUOTA_PR_DAY_14 = $pr_day14,
                    QUOTA_PR_DAY_15 = $pr_day15,
                    QUOTA_PR_DAY_16 = $pr_day16,
                    QUOTA_PR_DAY_17 = $pr_day17,
                    QUOTA_PR_DAY_18 = $pr_day18,
                    QUOTA_PR_DAY_19 = $pr_day19,
                    QUOTA_PR_DAY_20 = $pr_day20,
                    QUOTA_PR_DAY_21 = $pr_day21,
                    QUOTA_PR_DAY_22 = $pr_day22,
                    QUOTA_PR_DAY_23 = $pr_day23,
                    QUOTA_PR_DAY_24 = $pr_day24,
                    QUOTA_PR_DAY_25 = $pr_day25,
                    QUOTA_PR_DAY_26 = $pr_day26,
                    QUOTA_PR_DAY_27 = $pr_day27,
                    QUOTA_PR_DAY_28 = $pr_day28,
                    QUOTA_PR_DAY_29 = $pr_day29,
                    QUOTA_PR_DAY_30 = $pr_day30,
                    QUOTA_PR_DAY_31 = $pr_day31,
                    QUOTA_IM_DAY_1  = $im_day1 ,
                    QUOTA_IM_DAY_2  = $im_day2 ,
                    QUOTA_IM_DAY_3  = $im_day3 ,
                    QUOTA_IM_DAY_4  = $im_day4 ,
                    QUOTA_IM_DAY_5  = $im_day5 ,
                    QUOTA_IM_DAY_6  = $im_day6 ,
                    QUOTA_IM_DAY_7  = $im_day7 ,
                    QUOTA_IM_DAY_8  = $im_day8 ,
                    QUOTA_IM_DAY_9  = $im_day9 ,
                    QUOTA_IM_DAY_10 = $im_day10,
                    QUOTA_IM_DAY_11 = $im_day11,
                    QUOTA_IM_DAY_12 = $im_day12,
                    QUOTA_IM_DAY_13 = $im_day13,
                    QUOTA_IM_DAY_14 = $im_day14,
                    QUOTA_IM_DAY_15 = $im_day15,
                    QUOTA_IM_DAY_16 = $im_day16,
                    QUOTA_IM_DAY_17 = $im_day17,
                    QUOTA_IM_DAY_18 = $im_day18,
                    QUOTA_IM_DAY_19 = $im_day19,
                    QUOTA_IM_DAY_20 = $im_day20,
                    QUOTA_IM_DAY_21 = $im_day21,
                    QUOTA_IM_DAY_22 = $im_day22,
                    QUOTA_IM_DAY_23 = $im_day23,
                    QUOTA_IM_DAY_24 = $im_day24,
                    QUOTA_IM_DAY_25 = $im_day25,
                    QUOTA_IM_DAY_26 = $im_day26,
                    QUOTA_IM_DAY_27 = $im_day27,
                    QUOTA_IM_DAY_28 = $im_day28,
                    QUOTA_IM_DAY_29 = $im_day29,
                    QUOTA_IM_DAY_30 = $im_day30,
                    QUOTA_IM_DAY_31 = $im_day31
                    WHERE TAHUNBULAN = '$period' AND NPK='$isi_request->NPK'");

                $psnya = "Approve & Posting Quota By GM NPK : " . $isi_request->NPK . " periode : " . $period . " Production : " . $isi_request->QUANTITY_QUOTA_PR . " dan Improvement : " . $isi_request->QUANTITY_QUOTA_IM;
            } else {
                $data = array(
                    'GM_APPROVE' => 1,
                    'OPER_GM_APPROVE' => $created_by,
                    'TGL_GM_APPROVE' => $date,
                    'JAM_GM_APPROVE' => $time
                );

                $this->quota_employee_m->update_quota_employee_by_id_and_period_and_npk($data, $qrno, $period, $isi_request->NPK);

                $psnya = "Approve Quota By GM NPK : " . $isi_request->NPK . " periode : " . $period . " Production : " . $isi_request->QUANTITY_QUOTA_PR . " dan Improvement : " . $isi_request->QUANTITY_QUOTA_IM;
            }

            $aortadb->query("INSERT INTO TT_HISTORY(TGLTRANS,JAMTRANS,OTCPU,TIPETRANS,NO_SEQUENCE,OPERTRANS,OTVERSION,KETERANGAN,NPK) VALUES ('$date','$time', '$ip', 'APPROVE','$qrno','$created_by','AIS','$psnya','$isi_request->NPK')");
        }

        redirect($this->back_to_approve_gm . $period . '/' . $dept . '/' . 4);
    }

    function unapprove_quota_employee_by_gm($qrno, $dept, $period)
    {

        redirect($this->back_to_approve_gm . $period . '/' . $dept . '/' . 4);
    }

    function approve_all_quota_employee_by_gm()
    {
        $no_sequence_array = $this->input->post("noquota");
        $dept = $this->input->post("CHR_DEPT_2");
        $period = $this->input->post("CHR_PERIOD_2");
        $date = date('Ymd');
        $time = date('His');
        $ip = gethostbyaddr($_SERVER['REMOTE_ADDR']);
        $created_by = $this->session->userdata('USERNAME');

        if ($no_sequence_array == null || $no_sequence_array == 0) {
            redirect($this->back_to_approve_gm . $period . '/' . $dept . '/' . 6);
        }

        $aortadb = $this->load->database("aorta", TRUE);

        foreach ($no_sequence_array as $qrno) {

            $data_quota_request = $this->quota_employee_m->get_data_quota_request_by_period($period, $qrno);

            foreach ($data_quota_request as $isi_request) {

                if ($isi_request->FLG_FINISH_APPROVE_BY_DIR == 0) {

                    $data = array(
                        'GM_APPROVE' => 1,
                        'OPER_GM_APPROVE' => $created_by,
                        'TGL_GM_APPROVE' => $date,
                        'JAM_GM_APPROVE' => $time,
                        'FLG_FINISH_APPROVE' => 1,
                        'TGL_POSTING' => $date
                    );

                    $this->quota_employee_m->update_quota_employee_by_id_and_period_and_npk($data, $qrno, $period, $isi_request->NPK);

                    $data_quota = $this->quota_employee_m->get_data_quota_employee_by_period_and_npk($period, $isi_request->NPK);

                    $quota_plan = (float) str_replace(",", ".", $data_quota->QUOTAPLAN) + (float) $isi_request->QUANTITY_QUOTA_PR;
                    if ($quota_plan < 0) {
                        $quota_plan = 0;
                    } else {
                        $quota_plan = str_replace(".", ",", $quota_plan);
                    }

                    $sisa_plan = (float) str_replace(",", ".", $data_quota->SISAPLAN) + (float) $isi_request->QUANTITY_QUOTA_PR;
                    if ($sisa_plan < 0) {
                        $sisa_plan = 0;
                    } else {
                        $sisa_plan = str_replace(".", ",", $sisa_plan);
                    }

                    $quota_plan1 = (float) str_replace(",", ".", $data_quota->QUOTAPLAN1) + (float) $isi_request->QUANTITY_QUOTA_IM;
                    if ($quota_plan1 < 0) {
                        $quota_plan1 = 0;
                    } else {
                        $quota_plan1 = str_replace(".", ",", $quota_plan1);
                    }

                    $sisa_plan1 = (float) str_replace(",", ".", $data_quota->SISAPLAN1) + (float) $isi_request->QUANTITY_QUOTA_IM;
                    if ($sisa_plan1 < 0) {
                        $sisa_plan1 = 0;
                    } else {
                        $sisa_plan1 = str_replace(".", ",", $sisa_plan1);
                    }

                    $quota = (float) str_replace(",", ".", $data_quota->QUOTA) + (float) $isi_request->QUANTITY_QUOTA_PR;
                    if ($quota < 0) {
                        $quota = 0;
                    } else {
                        $quota = str_replace(".", ",", $quota);
                    }

                    $sisa = (float) str_replace(",", ".", $data_quota->SISA) + (float) $isi_request->QUANTITY_QUOTA_PR;
                    if ($sisa < 0) {
                        $sisa = 0;
                    } else {
                        $sisa = str_replace(".", ",", $sisa);
                    }

                    $quota1 = (float) str_replace(",", ".", $data_quota->QUOTA1) + (float) $isi_request->QUANTITY_QUOTA_IM;
                    if ($quota1 < 0) {
                        $quota1 = 0;
                    } else {
                        $quota1 = str_replace(".", ",", $quota1);
                    }

                    $sisa1 = (float) str_replace(",", ".", $data_quota->SISA1) + (float) $isi_request->QUANTITY_QUOTA_IM;
                    if ($sisa1 < 0) {
                        $sisa1 = 0;
                    } else {
                        $sisa1 = str_replace(".", ",", $sisa1);
                    }

                    $pr_day1 = $data_quota->QUOTA_PR_DAY_1 + $isi_request->QUOTA_PR_DAY_1;
                    $pr_day2 = $data_quota->QUOTA_PR_DAY_2 + $isi_request->QUOTA_PR_DAY_2;
                    $pr_day3 = $data_quota->QUOTA_PR_DAY_3 + $isi_request->QUOTA_PR_DAY_3;
                    $pr_day4 = $data_quota->QUOTA_PR_DAY_4 + $isi_request->QUOTA_PR_DAY_4;
                    $pr_day5 = $data_quota->QUOTA_PR_DAY_5 + $isi_request->QUOTA_PR_DAY_5;
                    $pr_day6 = $data_quota->QUOTA_PR_DAY_6 + $isi_request->QUOTA_PR_DAY_6;
                    $pr_day7 = $data_quota->QUOTA_PR_DAY_7 + $isi_request->QUOTA_PR_DAY_7;
                    $pr_day8 = $data_quota->QUOTA_PR_DAY_8 + $isi_request->QUOTA_PR_DAY_8;
                    $pr_day9 = $data_quota->QUOTA_PR_DAY_9 + $isi_request->QUOTA_PR_DAY_9;
                    $pr_day10 = $data_quota->QUOTA_PR_DAY_10 + $isi_request->QUOTA_PR_DAY_10;
                    $pr_day11 = $data_quota->QUOTA_PR_DAY_11 + $isi_request->QUOTA_PR_DAY_11;
                    $pr_day12 = $data_quota->QUOTA_PR_DAY_12 + $isi_request->QUOTA_PR_DAY_12;
                    $pr_day13 = $data_quota->QUOTA_PR_DAY_13 + $isi_request->QUOTA_PR_DAY_13;
                    $pr_day14 = $data_quota->QUOTA_PR_DAY_14 + $isi_request->QUOTA_PR_DAY_14;
                    $pr_day15 = $data_quota->QUOTA_PR_DAY_15 + $isi_request->QUOTA_PR_DAY_15;
                    $pr_day16 = $data_quota->QUOTA_PR_DAY_16 + $isi_request->QUOTA_PR_DAY_16;
                    $pr_day17 = $data_quota->QUOTA_PR_DAY_17 + $isi_request->QUOTA_PR_DAY_17;
                    $pr_day18 = $data_quota->QUOTA_PR_DAY_18 + $isi_request->QUOTA_PR_DAY_18;
                    $pr_day19 = $data_quota->QUOTA_PR_DAY_19 + $isi_request->QUOTA_PR_DAY_19;
                    $pr_day20 = $data_quota->QUOTA_PR_DAY_20 + $isi_request->QUOTA_PR_DAY_20;
                    $pr_day21 = $data_quota->QUOTA_PR_DAY_21 + $isi_request->QUOTA_PR_DAY_21;
                    $pr_day22 = $data_quota->QUOTA_PR_DAY_22 + $isi_request->QUOTA_PR_DAY_22;
                    $pr_day23 = $data_quota->QUOTA_PR_DAY_23 + $isi_request->QUOTA_PR_DAY_23;
                    $pr_day24 = $data_quota->QUOTA_PR_DAY_24 + $isi_request->QUOTA_PR_DAY_24;
                    $pr_day25 = $data_quota->QUOTA_PR_DAY_25 + $isi_request->QUOTA_PR_DAY_25;
                    $pr_day26 = $data_quota->QUOTA_PR_DAY_26 + $isi_request->QUOTA_PR_DAY_26;
                    $pr_day27 = $data_quota->QUOTA_PR_DAY_27 + $isi_request->QUOTA_PR_DAY_27;
                    $pr_day28 = $data_quota->QUOTA_PR_DAY_28 + $isi_request->QUOTA_PR_DAY_28;
                    $pr_day29 = $data_quota->QUOTA_PR_DAY_29 + $isi_request->QUOTA_PR_DAY_29;
                    $pr_day30 = $data_quota->QUOTA_PR_DAY_30 + $isi_request->QUOTA_PR_DAY_30;
                    $pr_day31 = $data_quota->QUOTA_PR_DAY_31 + $isi_request->QUOTA_PR_DAY_31;

                    $im_day1 = $data_quota->QUOTA_IM_DAY_1 + $isi_request->QUOTA_IM_DAY_1;
                    $im_day2 = $data_quota->QUOTA_IM_DAY_2 + $isi_request->QUOTA_IM_DAY_2;
                    $im_day3 = $data_quota->QUOTA_IM_DAY_3 + $isi_request->QUOTA_IM_DAY_3;
                    $im_day4 = $data_quota->QUOTA_IM_DAY_4 + $isi_request->QUOTA_IM_DAY_4;
                    $im_day5 = $data_quota->QUOTA_IM_DAY_5 + $isi_request->QUOTA_IM_DAY_5;
                    $im_day6 = $data_quota->QUOTA_IM_DAY_6 + $isi_request->QUOTA_IM_DAY_6;
                    $im_day7 = $data_quota->QUOTA_IM_DAY_7 + $isi_request->QUOTA_IM_DAY_7;
                    $im_day8 = $data_quota->QUOTA_IM_DAY_8 + $isi_request->QUOTA_IM_DAY_8;
                    $im_day9 = $data_quota->QUOTA_IM_DAY_9 + $isi_request->QUOTA_IM_DAY_9;
                    $im_day10 = $data_quota->QUOTA_IM_DAY_10 + $isi_request->QUOTA_IM_DAY_10;
                    $im_day11 = $data_quota->QUOTA_IM_DAY_11 + $isi_request->QUOTA_IM_DAY_11;
                    $im_day12 = $data_quota->QUOTA_IM_DAY_12 + $isi_request->QUOTA_IM_DAY_12;
                    $im_day13 = $data_quota->QUOTA_IM_DAY_13 + $isi_request->QUOTA_IM_DAY_13;
                    $im_day14 = $data_quota->QUOTA_IM_DAY_14 + $isi_request->QUOTA_IM_DAY_14;
                    $im_day15 = $data_quota->QUOTA_IM_DAY_15 + $isi_request->QUOTA_IM_DAY_15;
                    $im_day16 = $data_quota->QUOTA_IM_DAY_16 + $isi_request->QUOTA_IM_DAY_16;
                    $im_day17 = $data_quota->QUOTA_IM_DAY_17 + $isi_request->QUOTA_IM_DAY_17;
                    $im_day18 = $data_quota->QUOTA_IM_DAY_18 + $isi_request->QUOTA_IM_DAY_18;
                    $im_day19 = $data_quota->QUOTA_IM_DAY_19 + $isi_request->QUOTA_IM_DAY_19;
                    $im_day20 = $data_quota->QUOTA_IM_DAY_20 + $isi_request->QUOTA_IM_DAY_20;
                    $im_day21 = $data_quota->QUOTA_IM_DAY_21 + $isi_request->QUOTA_IM_DAY_21;
                    $im_day22 = $data_quota->QUOTA_IM_DAY_22 + $isi_request->QUOTA_IM_DAY_22;
                    $im_day23 = $data_quota->QUOTA_IM_DAY_23 + $isi_request->QUOTA_IM_DAY_23;
                    $im_day24 = $data_quota->QUOTA_IM_DAY_24 + $isi_request->QUOTA_IM_DAY_24;
                    $im_day25 = $data_quota->QUOTA_IM_DAY_25 + $isi_request->QUOTA_IM_DAY_25;
                    $im_day26 = $data_quota->QUOTA_IM_DAY_26 + $isi_request->QUOTA_IM_DAY_26;
                    $im_day27 = $data_quota->QUOTA_IM_DAY_27 + $isi_request->QUOTA_IM_DAY_27;
                    $im_day28 = $data_quota->QUOTA_IM_DAY_28 + $isi_request->QUOTA_IM_DAY_28;
                    $im_day29 = $data_quota->QUOTA_IM_DAY_29 + $isi_request->QUOTA_IM_DAY_29;
                    $im_day30 = $data_quota->QUOTA_IM_DAY_30 + $isi_request->QUOTA_IM_DAY_30;
                    $im_day31 = $data_quota->QUOTA_IM_DAY_31 + $isi_request->QUOTA_IM_DAY_31;

                    //set quota stdr
                    if (trim($data_quota->QUOTA_STD) == "0") {
                        $aortadb->query("UPDATE TT_QUOTA_KRY SET QUOTA_STD='$quota_plan' WHERE TAHUNBULAN='$period' and NPK='$isi_request->NPK'");
                    }

                    $aortadb->query("UPDATE TT_QUOTA_KRY SET 
                        QUOTAPLAN='$quota_plan', SISAPLAN='$sisa_plan', QUOTA='$quota', SISA='$sisa', 
                        QUOTAPLAN1='$quota_plan1', SISAPLAN1='$sisa_plan1', QUOTA1='$quota1', SISA1='$sisa1',
                        QUOTA_PR_DAY_1  = $pr_day1 ,
                        QUOTA_PR_DAY_2  = $pr_day2 ,
                        QUOTA_PR_DAY_3  = $pr_day3 ,
                        QUOTA_PR_DAY_4  = $pr_day4 ,
                        QUOTA_PR_DAY_5  = $pr_day5 ,
                        QUOTA_PR_DAY_6  = $pr_day6 ,
                        QUOTA_PR_DAY_7  = $pr_day7 ,
                        QUOTA_PR_DAY_8  = $pr_day8 ,
                        QUOTA_PR_DAY_9  = $pr_day9 ,
                        QUOTA_PR_DAY_10 = $pr_day10,
                        QUOTA_PR_DAY_11 = $pr_day11,
                        QUOTA_PR_DAY_12 = $pr_day12,
                        QUOTA_PR_DAY_13 = $pr_day13,
                        QUOTA_PR_DAY_14 = $pr_day14,
                        QUOTA_PR_DAY_15 = $pr_day15,
                        QUOTA_PR_DAY_16 = $pr_day16,
                        QUOTA_PR_DAY_17 = $pr_day17,
                        QUOTA_PR_DAY_18 = $pr_day18,
                        QUOTA_PR_DAY_19 = $pr_day19,
                        QUOTA_PR_DAY_20 = $pr_day20,
                        QUOTA_PR_DAY_21 = $pr_day21,
                        QUOTA_PR_DAY_22 = $pr_day22,
                        QUOTA_PR_DAY_23 = $pr_day23,
                        QUOTA_PR_DAY_24 = $pr_day24,
                        QUOTA_PR_DAY_25 = $pr_day25,
                        QUOTA_PR_DAY_26 = $pr_day26,
                        QUOTA_PR_DAY_27 = $pr_day27,
                        QUOTA_PR_DAY_28 = $pr_day28,
                        QUOTA_PR_DAY_29 = $pr_day29,
                        QUOTA_PR_DAY_30 = $pr_day30,
                        QUOTA_PR_DAY_31 = $pr_day31,
                        QUOTA_IM_DAY_1  = $im_day1 ,
                        QUOTA_IM_DAY_2  = $im_day2 ,
                        QUOTA_IM_DAY_3  = $im_day3 ,
                        QUOTA_IM_DAY_4  = $im_day4 ,
                        QUOTA_IM_DAY_5  = $im_day5 ,
                        QUOTA_IM_DAY_6  = $im_day6 ,
                        QUOTA_IM_DAY_7  = $im_day7 ,
                        QUOTA_IM_DAY_8  = $im_day8 ,
                        QUOTA_IM_DAY_9  = $im_day9 ,
                        QUOTA_IM_DAY_10 = $im_day10,
                        QUOTA_IM_DAY_11 = $im_day11,
                        QUOTA_IM_DAY_12 = $im_day12,
                        QUOTA_IM_DAY_13 = $im_day13,
                        QUOTA_IM_DAY_14 = $im_day14,
                        QUOTA_IM_DAY_15 = $im_day15,
                        QUOTA_IM_DAY_16 = $im_day16,
                        QUOTA_IM_DAY_17 = $im_day17,
                        QUOTA_IM_DAY_18 = $im_day18,
                        QUOTA_IM_DAY_19 = $im_day19,
                        QUOTA_IM_DAY_20 = $im_day20,
                        QUOTA_IM_DAY_21 = $im_day21,
                        QUOTA_IM_DAY_22 = $im_day22,
                        QUOTA_IM_DAY_23 = $im_day23,
                        QUOTA_IM_DAY_24 = $im_day24,
                        QUOTA_IM_DAY_25 = $im_day25,
                        QUOTA_IM_DAY_26 = $im_day26,
                        QUOTA_IM_DAY_27 = $im_day27,
                        QUOTA_IM_DAY_28 = $im_day28,
                        QUOTA_IM_DAY_29 = $im_day29,
                        QUOTA_IM_DAY_30 = $im_day30,
                        QUOTA_IM_DAY_31 = $im_day31
                        WHERE TAHUNBULAN = '$period' AND NPK='$isi_request->NPK'");

                    $psnya = "Approve & Posting Quota By GM NPK : " . $isi_request->NPK . " periode : " . $period . " Production : " . $isi_request->QUANTITY_QUOTA_PR . " dan Improvement : " . $isi_request->QUANTITY_QUOTA_IM;
                } else {
                    $data = array(
                        'GM_APPROVE' => 1,
                        'OPER_GM_APPROVE' => $created_by,
                        'TGL_GM_APPROVE' => $date,
                        'JAM_GM_APPROVE' => $time
                    );

                    $this->quota_employee_m->update_quota_employee_by_id_and_period_and_npk($data, $qrno, $period, $isi_request->NPK);

                    $psnya = "Approve Quota By GM NPK : " . $isi_request->NPK . " periode : " . $period . " Production : " . $isi_request->QUANTITY_QUOTA_PR . " dan Improvement : " . $isi_request->QUANTITY_QUOTA_IM;
                }
                $aortadb->query("INSERT INTO TT_HISTORY(TGLTRANS,JAMTRANS,OTCPU,TIPETRANS,NO_SEQUENCE,OPERTRANS,OTVERSION,KETERANGAN,NPK) VALUES ('$date','$time', '$ip', 'APPROVE','$qrno','$created_by','AIS','$psnya','$isi_request->NPK')");
            }
        }

        redirect($this->back_to_approve_gm . $period . '/' . $dept . '/' . 4);
    }

    //DIR
    function view_detail_quota_employee_by_dir()
    {
        $qrno = $this->input->post("qrno");
        $data_detail = $this->quota_employee_m->get_data_request_quota_employee_by_qrno_for_dir($qrno);
        $data = "";
        $i = 1;
        $tot_qr_pr = 0;
        $tot_saldo_pr = 0;
        $tot_qr_im = 0;
        $tot_saldo_im = 0;
        foreach ($data_detail as $isi) {
            $saldo_pr = $isi->SALDO_QUOTA_PR - $isi->TERPAKAI_QUOTA_PR;
            $next_saldo_pr = $saldo_pr + $isi->QUANTITY_QUOTA_PR;
            $saldo_im = $isi->SALDO_QUOTA_IM - $isi->TERPAKAI_QUOTA_IM;
            $next_saldo_im = $saldo_im + $isi->QUANTITY_QUOTA_IM;

            $tot_qr_pr = $tot_qr_pr + $isi->QUANTITY_QUOTA_PR;
            $tot_saldo_pr = $tot_saldo_pr + $next_saldo_pr;
            $tot_qr_im = $tot_qr_im + $isi->QUANTITY_QUOTA_IM;
            $tot_saldo_im = $tot_saldo_im + $next_saldo_im;

            $data .= "<tr class='gradeX'>";
            $data .= "<td>$i</td>";
            $data .= "<td style='vertical-align: middle;text-align:center'><strong>$isi->NPK</strong></td>";
            $data .= "<td style='vertical-align: middle;text-align:left'>$isi->NAMA</td>";
            $data .= "<td style='vertical-align: middle;text-align:center'>$isi->KD_SECTION</td>";
            $data .= "<td style='vertical-align: middle;text-align:center'>$isi->KD_SUB_SECTION</td>";
            $data .= "<td style='vertical-align: middle;text-align:center'><strong>" . number_format($isi->QUANTITY_QUOTA_PR, 2, ',', '.') . "</strong></td>";
            $data .= "<td style='vertical-align: middle;text-align:center'>" . number_format($isi->SALDO_QUOTA_PR, 2, ',', '.') . "</td>";
            $data .= "<td style='vertical-align: middle;text-align:center'>" . number_format($isi->TERPAKAI_QUOTA_PR, 2, ',', '.') . "</td>";
            $data .= "<td style='vertical-align: middle;text-align:center'>" . number_format($saldo_pr, 2, ',', '.') . "</td>";
            $data .= "<td style='vertical-align: middle;text-align:center'><strong>" . number_format($next_saldo_pr, 2, ',', '.') . "</strong></td>";
            $data .= "<td style='vertical-align: middle;text-align:center'><strong>" . number_format($isi->QUANTITY_QUOTA_IM, 2, ',', '.') . "</strong></td>";
            $data .= "<td style='vertical-align: middle;text-align:center'>" . number_format($isi->SALDO_QUOTA_IM, 2, ',', '.') . "</td>";
            $data .= "<td style='vertical-align: middle;text-align:center'>" . number_format($isi->TERPAKAI_QUOTA_IM, 2, ',', '.') . "</td>";
            $data .= "<td style='vertical-align: middle;text-align:center'>" . number_format($saldo_im, 2, ',', '.') . "</td>";
            $data .= "<td style='vertical-align: middle;text-align:center'><strong>" . number_format($next_saldo_im, 2, ',', '.') . "</strong></td>";
            $data .= "</tr>";

            $i++;
        }

        $data .= "<tr align='center' style='font-weight:bold;'>";
        $data .= "<td colspan='5'>TOTAL</td>";
        $data .= "<td>" . number_format($tot_qr_pr, 2, ',', '.') . "</td>";
        $data .= "<td colspan='3'></td>";
        $data .= "<td>" . number_format($tot_saldo_pr, 2, ',', '.') . "</td>";
        $data .= "<td>" . number_format($tot_qr_im, 2, ',', '.') . "</td>";
        $data .= "<td colspan='3'></td>";
        $data .= "<td>" . number_format($tot_saldo_im, 2, ',', '.') . "</td>";
        $data .= "</tr>";

        echo $data;
    }

    function prepare_approve_quota_by_dir($period = NULL, $dept = NULL, $msg = NULL)
    {
        if ($msg == 4) {
            $msg = "<div class = 'alert alert-success'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Approve success </strong> The data is successfully Approve </div >";
        } elseif ($msg == 5) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Reject success </strong> The data is successfully Reject </div >";
        } elseif ($msg == 6) {
            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Approve Failed </strong> No data has been selected </div >";
        } elseif ($msg == 12) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Executing error !</strong> Something error with parameter </div >";
        }

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(154);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Approval Quota Employee';
        $data['msg'] = $msg;

        if ($period == NULL) {
            $period = date('Ym');
        }

        if ($dept == NULL) {
            $dept = $this->overtime_m->get_top_dept_overtime()->row()->KODE;
        }

        $data['period'] = $period;
        $data['dept'] = $dept;
        $data['all_dept'] = $this->overtime_m->get_dept_overtime();

        $data['detail_quota_plant'] = $this->overtime_m->get_detail_quota_plant_by_periode_by_dir($period);
        $data['quota_usage_dept'] = $this->overtime_m->get_detail_quota_plant_per_dept_by_periode_by_dir($period);
        $data['data'] = $this->quota_employee_m->get_data_request_quota_employee_by_dir($data['dept'], $period);

        $data['content'] = 'aorta/quota_employee/manage_quota_employee_by_dir_v';
        $this->load->view($this->layout, $data);
    }

    function approve_form_quota_employee_by_dir()
    {
        $qrno = $this->input->post("ID_DOC");
        $dept = $this->input->post("CHR_DEPT");
        $period = $this->input->post("CHR_PERIOD");
        $date = date('Ymd');
        $time = date('His');
        $ip = gethostbyaddr($_SERVER['REMOTE_ADDR']);
        $created_by = $this->session->userdata('USERNAME');

        $aortadb = $this->load->database("aorta", TRUE);

        $data_quota_request = $this->quota_employee_m->get_data_quota_request_approved_by_dir($period, $qrno);

        foreach ($data_quota_request as $isi_request) {

            $data = array(
                'DIR_APPROVE' => 1,
                'OPER_DIR_APPROVE' => $created_by,
                'TGL_DIR_APPROVE' => $date,
                'JAM_DIR_APPROVE' => $time,
                'FLG_FINISH_APPROVE' => 1,
                'TGL_POSTING' => $date
            );

            $this->quota_employee_m->update_quota_employee_by_id_and_period_and_npk($data, $qrno, $period, $isi_request->NPK);

            $data_quota = $this->quota_employee_m->get_data_quota_employee_by_period_and_npk($period, $isi_request->NPK);

            $quota_plan = (float) str_replace(",", ".", $data_quota->QUOTAPLAN) + (float) $isi_request->QUANTITY_QUOTA_PR;
            if ($quota_plan < 0) {
                $quota_plan = 0;
            } else {
                $quota_plan = str_replace(".", ",", $quota_plan);
            }

            $sisa_plan = (float) str_replace(",", ".", $data_quota->SISAPLAN) + (float) $isi_request->QUANTITY_QUOTA_PR;
            if ($sisa_plan < 0) {
                $sisa_plan = 0;
            } else {
                $sisa_plan = str_replace(".", ",", $sisa_plan);
            }

            $quota_plan1 = (float) str_replace(",", ".", $data_quota->QUOTAPLAN1) + (float) $isi_request->QUANTITY_QUOTA_IM;
            if ($quota_plan1 < 0) {
                $quota_plan1 = 0;
            } else {
                $quota_plan1 = str_replace(".", ",", $quota_plan1);
            }

            $sisa_plan1 = (float) str_replace(",", ".", $data_quota->SISAPLAN1) + (float) $isi_request->QUANTITY_QUOTA_IM;
            if ($sisa_plan1 < 0) {
                $sisa_plan1 = 0;
            } else {
                $sisa_plan1 = str_replace(".", ",", $sisa_plan1);
            }

            $quota = (float) str_replace(",", ".", $data_quota->QUOTA) + (float) $isi_request->QUANTITY_QUOTA_PR;
            if ($quota < 0) {
                $quota = 0;
            } else {
                $quota = str_replace(".", ",", $quota);
            }

            $sisa = (float) str_replace(",", ".", $data_quota->SISA) + (float) $isi_request->QUANTITY_QUOTA_PR;
            if ($sisa < 0) {
                $sisa = 0;
            } else {
                $sisa = str_replace(".", ",", $sisa);
            }

            $quota1 = (float) str_replace(",", ".", $data_quota->QUOTA1) + (float) $isi_request->QUANTITY_QUOTA_IM;
            if ($quota1 < 0) {
                $quota1 = 0;
            } else {
                $quota1 = str_replace(".", ",", $quota1);
            }

            $sisa1 = (float) str_replace(",", ".", $data_quota->SISA1) + (float) $isi_request->QUANTITY_QUOTA_IM;
            if ($sisa1 < 0) {
                $sisa1 = 0;
            } else {
                $sisa1 = str_replace(".", ",", $sisa1);
            }

            $pr_day1 = $data_quota->QUOTA_PR_DAY_1 + $isi_request->QUOTA_PR_DAY_1;
            $pr_day2 = $data_quota->QUOTA_PR_DAY_2 + $isi_request->QUOTA_PR_DAY_2;
            $pr_day3 = $data_quota->QUOTA_PR_DAY_3 + $isi_request->QUOTA_PR_DAY_3;
            $pr_day4 = $data_quota->QUOTA_PR_DAY_4 + $isi_request->QUOTA_PR_DAY_4;
            $pr_day5 = $data_quota->QUOTA_PR_DAY_5 + $isi_request->QUOTA_PR_DAY_5;
            $pr_day6 = $data_quota->QUOTA_PR_DAY_6 + $isi_request->QUOTA_PR_DAY_6;
            $pr_day7 = $data_quota->QUOTA_PR_DAY_7 + $isi_request->QUOTA_PR_DAY_7;
            $pr_day8 = $data_quota->QUOTA_PR_DAY_8 + $isi_request->QUOTA_PR_DAY_8;
            $pr_day9 = $data_quota->QUOTA_PR_DAY_9 + $isi_request->QUOTA_PR_DAY_9;
            $pr_day10 = $data_quota->QUOTA_PR_DAY_10 + $isi_request->QUOTA_PR_DAY_10;
            $pr_day11 = $data_quota->QUOTA_PR_DAY_11 + $isi_request->QUOTA_PR_DAY_11;
            $pr_day12 = $data_quota->QUOTA_PR_DAY_12 + $isi_request->QUOTA_PR_DAY_12;
            $pr_day13 = $data_quota->QUOTA_PR_DAY_13 + $isi_request->QUOTA_PR_DAY_13;
            $pr_day14 = $data_quota->QUOTA_PR_DAY_14 + $isi_request->QUOTA_PR_DAY_14;
            $pr_day15 = $data_quota->QUOTA_PR_DAY_15 + $isi_request->QUOTA_PR_DAY_15;
            $pr_day16 = $data_quota->QUOTA_PR_DAY_16 + $isi_request->QUOTA_PR_DAY_16;
            $pr_day17 = $data_quota->QUOTA_PR_DAY_17 + $isi_request->QUOTA_PR_DAY_17;
            $pr_day18 = $data_quota->QUOTA_PR_DAY_18 + $isi_request->QUOTA_PR_DAY_18;
            $pr_day19 = $data_quota->QUOTA_PR_DAY_19 + $isi_request->QUOTA_PR_DAY_19;
            $pr_day20 = $data_quota->QUOTA_PR_DAY_20 + $isi_request->QUOTA_PR_DAY_20;
            $pr_day21 = $data_quota->QUOTA_PR_DAY_21 + $isi_request->QUOTA_PR_DAY_21;
            $pr_day22 = $data_quota->QUOTA_PR_DAY_22 + $isi_request->QUOTA_PR_DAY_22;
            $pr_day23 = $data_quota->QUOTA_PR_DAY_23 + $isi_request->QUOTA_PR_DAY_23;
            $pr_day24 = $data_quota->QUOTA_PR_DAY_24 + $isi_request->QUOTA_PR_DAY_24;
            $pr_day25 = $data_quota->QUOTA_PR_DAY_25 + $isi_request->QUOTA_PR_DAY_25;
            $pr_day26 = $data_quota->QUOTA_PR_DAY_26 + $isi_request->QUOTA_PR_DAY_26;
            $pr_day27 = $data_quota->QUOTA_PR_DAY_27 + $isi_request->QUOTA_PR_DAY_27;
            $pr_day28 = $data_quota->QUOTA_PR_DAY_28 + $isi_request->QUOTA_PR_DAY_28;
            $pr_day29 = $data_quota->QUOTA_PR_DAY_29 + $isi_request->QUOTA_PR_DAY_29;
            $pr_day30 = $data_quota->QUOTA_PR_DAY_30 + $isi_request->QUOTA_PR_DAY_30;
            $pr_day31 = $data_quota->QUOTA_PR_DAY_31 + $isi_request->QUOTA_PR_DAY_31;

            $im_day1 = $data_quota->QUOTA_IM_DAY_1 + $isi_request->QUOTA_IM_DAY_1;
            $im_day2 = $data_quota->QUOTA_IM_DAY_2 + $isi_request->QUOTA_IM_DAY_2;
            $im_day3 = $data_quota->QUOTA_IM_DAY_3 + $isi_request->QUOTA_IM_DAY_3;
            $im_day4 = $data_quota->QUOTA_IM_DAY_4 + $isi_request->QUOTA_IM_DAY_4;
            $im_day5 = $data_quota->QUOTA_IM_DAY_5 + $isi_request->QUOTA_IM_DAY_5;
            $im_day6 = $data_quota->QUOTA_IM_DAY_6 + $isi_request->QUOTA_IM_DAY_6;
            $im_day7 = $data_quota->QUOTA_IM_DAY_7 + $isi_request->QUOTA_IM_DAY_7;
            $im_day8 = $data_quota->QUOTA_IM_DAY_8 + $isi_request->QUOTA_IM_DAY_8;
            $im_day9 = $data_quota->QUOTA_IM_DAY_9 + $isi_request->QUOTA_IM_DAY_9;
            $im_day10 = $data_quota->QUOTA_IM_DAY_10 + $isi_request->QUOTA_IM_DAY_10;
            $im_day11 = $data_quota->QUOTA_IM_DAY_11 + $isi_request->QUOTA_IM_DAY_11;
            $im_day12 = $data_quota->QUOTA_IM_DAY_12 + $isi_request->QUOTA_IM_DAY_12;
            $im_day13 = $data_quota->QUOTA_IM_DAY_13 + $isi_request->QUOTA_IM_DAY_13;
            $im_day14 = $data_quota->QUOTA_IM_DAY_14 + $isi_request->QUOTA_IM_DAY_14;
            $im_day15 = $data_quota->QUOTA_IM_DAY_15 + $isi_request->QUOTA_IM_DAY_15;
            $im_day16 = $data_quota->QUOTA_IM_DAY_16 + $isi_request->QUOTA_IM_DAY_16;
            $im_day17 = $data_quota->QUOTA_IM_DAY_17 + $isi_request->QUOTA_IM_DAY_17;
            $im_day18 = $data_quota->QUOTA_IM_DAY_18 + $isi_request->QUOTA_IM_DAY_18;
            $im_day19 = $data_quota->QUOTA_IM_DAY_19 + $isi_request->QUOTA_IM_DAY_19;
            $im_day20 = $data_quota->QUOTA_IM_DAY_20 + $isi_request->QUOTA_IM_DAY_20;
            $im_day21 = $data_quota->QUOTA_IM_DAY_21 + $isi_request->QUOTA_IM_DAY_21;
            $im_day22 = $data_quota->QUOTA_IM_DAY_22 + $isi_request->QUOTA_IM_DAY_22;
            $im_day23 = $data_quota->QUOTA_IM_DAY_23 + $isi_request->QUOTA_IM_DAY_23;
            $im_day24 = $data_quota->QUOTA_IM_DAY_24 + $isi_request->QUOTA_IM_DAY_24;
            $im_day25 = $data_quota->QUOTA_IM_DAY_25 + $isi_request->QUOTA_IM_DAY_25;
            $im_day26 = $data_quota->QUOTA_IM_DAY_26 + $isi_request->QUOTA_IM_DAY_26;
            $im_day27 = $data_quota->QUOTA_IM_DAY_27 + $isi_request->QUOTA_IM_DAY_27;
            $im_day28 = $data_quota->QUOTA_IM_DAY_28 + $isi_request->QUOTA_IM_DAY_28;
            $im_day29 = $data_quota->QUOTA_IM_DAY_29 + $isi_request->QUOTA_IM_DAY_29;
            $im_day30 = $data_quota->QUOTA_IM_DAY_30 + $isi_request->QUOTA_IM_DAY_30;
            $im_day31 = $data_quota->QUOTA_IM_DAY_31 + $isi_request->QUOTA_IM_DAY_31;

            //set quota stdr
            if (trim($data_quota->QUOTA_STD) == "0") {
                $aortadb->query("UPDATE TT_QUOTA_KRY SET QUOTA_STD='$quota_plan' 
                WHERE TAHUNBULAN='$period' AND NPK='$isi_request->NPK'");
            }

            $aortadb->query("UPDATE TT_QUOTA_KRY SET 
                        QUOTAPLAN='$quota_plan', SISAPLAN='$sisa_plan', QUOTA='$quota', SISA='$sisa', 
                        QUOTAPLAN1='$quota_plan1', SISAPLAN1='$sisa_plan1', QUOTA1='$quota1', SISA1='$sisa1',
                        QUOTA_PR_DAY_1  = $pr_day1 ,
                        QUOTA_PR_DAY_2  = $pr_day2 ,
                        QUOTA_PR_DAY_3  = $pr_day3 ,
                        QUOTA_PR_DAY_4  = $pr_day4 ,
                        QUOTA_PR_DAY_5  = $pr_day5 ,
                        QUOTA_PR_DAY_6  = $pr_day6 ,
                        QUOTA_PR_DAY_7  = $pr_day7 ,
                        QUOTA_PR_DAY_8  = $pr_day8 ,
                        QUOTA_PR_DAY_9  = $pr_day9 ,
                        QUOTA_PR_DAY_10 = $pr_day10,
                        QUOTA_PR_DAY_11 = $pr_day11,
                        QUOTA_PR_DAY_12 = $pr_day12,
                        QUOTA_PR_DAY_13 = $pr_day13,
                        QUOTA_PR_DAY_14 = $pr_day14,
                        QUOTA_PR_DAY_15 = $pr_day15,
                        QUOTA_PR_DAY_16 = $pr_day16,
                        QUOTA_PR_DAY_17 = $pr_day17,
                        QUOTA_PR_DAY_18 = $pr_day18,
                        QUOTA_PR_DAY_19 = $pr_day19,
                        QUOTA_PR_DAY_20 = $pr_day20,
                        QUOTA_PR_DAY_21 = $pr_day21,
                        QUOTA_PR_DAY_22 = $pr_day22,
                        QUOTA_PR_DAY_23 = $pr_day23,
                        QUOTA_PR_DAY_24 = $pr_day24,
                        QUOTA_PR_DAY_25 = $pr_day25,
                        QUOTA_PR_DAY_26 = $pr_day26,
                        QUOTA_PR_DAY_27 = $pr_day27,
                        QUOTA_PR_DAY_28 = $pr_day28,
                        QUOTA_PR_DAY_29 = $pr_day29,
                        QUOTA_PR_DAY_30 = $pr_day30,
                        QUOTA_PR_DAY_31 = $pr_day31,
                        QUOTA_IM_DAY_1  = $im_day1 ,
                        QUOTA_IM_DAY_2  = $im_day2 ,
                        QUOTA_IM_DAY_3  = $im_day3 ,
                        QUOTA_IM_DAY_4  = $im_day4 ,
                        QUOTA_IM_DAY_5  = $im_day5 ,
                        QUOTA_IM_DAY_6  = $im_day6 ,
                        QUOTA_IM_DAY_7  = $im_day7 ,
                        QUOTA_IM_DAY_8  = $im_day8 ,
                        QUOTA_IM_DAY_9  = $im_day9 ,
                        QUOTA_IM_DAY_10 = $im_day10,
                        QUOTA_IM_DAY_11 = $im_day11,
                        QUOTA_IM_DAY_12 = $im_day12,
                        QUOTA_IM_DAY_13 = $im_day13,
                        QUOTA_IM_DAY_14 = $im_day14,
                        QUOTA_IM_DAY_15 = $im_day15,
                        QUOTA_IM_DAY_16 = $im_day16,
                        QUOTA_IM_DAY_17 = $im_day17,
                        QUOTA_IM_DAY_18 = $im_day18,
                        QUOTA_IM_DAY_19 = $im_day19,
                        QUOTA_IM_DAY_20 = $im_day20,
                        QUOTA_IM_DAY_21 = $im_day21,
                        QUOTA_IM_DAY_22 = $im_day22,
                        QUOTA_IM_DAY_23 = $im_day23,
                        QUOTA_IM_DAY_24 = $im_day24,
                        QUOTA_IM_DAY_25 = $im_day25,
                        QUOTA_IM_DAY_26 = $im_day26,
                        QUOTA_IM_DAY_27 = $im_day27,
                        QUOTA_IM_DAY_28 = $im_day28,
                        QUOTA_IM_DAY_29 = $im_day29,
                        QUOTA_IM_DAY_30 = $im_day30,
                        QUOTA_IM_DAY_31 = $im_day31
                        WHERE TAHUNBULAN = '$period' AND NPK='$isi_request->NPK'");

            $psnya = "Approve & Posting Quota By BOD NPK : " . $isi_request->NPK . " periode : " . $period . " Production : " . $isi_request->QUANTITY_QUOTA_PR . " dan Improvement : " . $isi_request->QUANTITY_QUOTA_IM;

            $aortadb->query("INSERT INTO TT_HISTORY(TGLTRANS,JAMTRANS,OTCPU,TIPETRANS,NO_SEQUENCE,OPERTRANS,OTVERSION,KETERANGAN,NPK) VALUES ('$date','$time', '$ip', 'APPROVE','$qrno','$created_by','AIS','$psnya','$isi_request->NPK')");
        }

        redirect($this->back_to_approve_dir . $period . '/' . $dept . '/' . 4);
    }

    function approve_quota_employee_by_dir($qrno, $dept, $period)
    {
        $date = date('Ymd');
        $time = date('His');
        $ip = gethostbyaddr($_SERVER['REMOTE_ADDR']);
        $created_by = $this->session->userdata('USERNAME');

        $aortadb = $this->load->database("aorta", TRUE);

        $data_quota_request = $this->quota_employee_m->get_data_quota_request_approved_by_dir($period, $qrno);

        foreach ($data_quota_request as $isi_request) {

            $data = array(
                'DIR_APPROVE' => 1,
                'OPER_DIR_APPROVE' => $created_by,
                'TGL_DIR_APPROVE' => $date,
                'JAM_DIR_APPROVE' => $time,
                'FLG_FINISH_APPROVE' => 1,
                'TGL_POSTING' => $date
            );

            $this->quota_employee_m->update_quota_employee_by_id_and_period_and_npk($data, $qrno, $period, $isi_request->NPK);

            $data_quota = $this->quota_employee_m->get_data_quota_employee_by_period_and_npk($period, $isi_request->NPK);

            $quota_plan = (float) str_replace(",", ".", $data_quota->QUOTAPLAN) + (float) $isi_request->QUANTITY_QUOTA_PR;
            if ($quota_plan < 0) {
                $quota_plan = 0;
            } else {
                $quota_plan = str_replace(".", ",", $quota_plan);
            }

            $sisa_plan = (float) str_replace(",", ".", $data_quota->SISAPLAN) + (float) $isi_request->QUANTITY_QUOTA_PR;
            if ($sisa_plan < 0) {
                $sisa_plan = 0;
            } else {
                $sisa_plan = str_replace(".", ",", $sisa_plan);
            }

            $quota_plan1 = (float) str_replace(",", ".", $data_quota->QUOTAPLAN1) + (float) $isi_request->QUANTITY_QUOTA_IM;
            if ($quota_plan1 < 0) {
                $quota_plan1 = 0;
            } else {
                $quota_plan1 = str_replace(".", ",", $quota_plan1);
            }

            $sisa_plan1 = (float) str_replace(",", ".", $data_quota->SISAPLAN1) + (float) $isi_request->QUANTITY_QUOTA_IM;
            if ($sisa_plan1 < 0) {
                $sisa_plan1 = 0;
            } else {
                $sisa_plan1 = str_replace(".", ",", $sisa_plan1);
            }

            $quota = (float) str_replace(",", ".", $data_quota->QUOTA) + (float) $isi_request->QUANTITY_QUOTA_PR;
            if ($quota < 0) {
                $quota = 0;
            } else {
                $quota = str_replace(".", ",", $quota);
            }

            $sisa = (float) str_replace(",", ".", $data_quota->SISA) + (float) $isi_request->QUANTITY_QUOTA_PR;
            if ($sisa < 0) {
                $sisa = 0;
            } else {
                $sisa = str_replace(".", ",", $sisa);
            }

            $quota1 = (float) str_replace(",", ".", $data_quota->QUOTA1) + (float) $isi_request->QUANTITY_QUOTA_IM;
            if ($quota1 < 0) {
                $quota1 = 0;
            } else {
                $quota1 = str_replace(".", ",", $quota1);
            }

            $sisa1 = (float) str_replace(",", ".", $data_quota->SISA1) + (float) $isi_request->QUANTITY_QUOTA_IM;
            if ($sisa1 < 0) {
                $sisa1 = 0;
            } else {
                $sisa1 = str_replace(".", ",", $sisa1);
            }

            $pr_day1 = $data_quota->QUOTA_PR_DAY_1 + $isi_request->QUOTA_PR_DAY_1;
            $pr_day2 = $data_quota->QUOTA_PR_DAY_2 + $isi_request->QUOTA_PR_DAY_2;
            $pr_day3 = $data_quota->QUOTA_PR_DAY_3 + $isi_request->QUOTA_PR_DAY_3;
            $pr_day4 = $data_quota->QUOTA_PR_DAY_4 + $isi_request->QUOTA_PR_DAY_4;
            $pr_day5 = $data_quota->QUOTA_PR_DAY_5 + $isi_request->QUOTA_PR_DAY_5;
            $pr_day6 = $data_quota->QUOTA_PR_DAY_6 + $isi_request->QUOTA_PR_DAY_6;
            $pr_day7 = $data_quota->QUOTA_PR_DAY_7 + $isi_request->QUOTA_PR_DAY_7;
            $pr_day8 = $data_quota->QUOTA_PR_DAY_8 + $isi_request->QUOTA_PR_DAY_8;
            $pr_day9 = $data_quota->QUOTA_PR_DAY_9 + $isi_request->QUOTA_PR_DAY_9;
            $pr_day10 = $data_quota->QUOTA_PR_DAY_10 + $isi_request->QUOTA_PR_DAY_10;
            $pr_day11 = $data_quota->QUOTA_PR_DAY_11 + $isi_request->QUOTA_PR_DAY_11;
            $pr_day12 = $data_quota->QUOTA_PR_DAY_12 + $isi_request->QUOTA_PR_DAY_12;
            $pr_day13 = $data_quota->QUOTA_PR_DAY_13 + $isi_request->QUOTA_PR_DAY_13;
            $pr_day14 = $data_quota->QUOTA_PR_DAY_14 + $isi_request->QUOTA_PR_DAY_14;
            $pr_day15 = $data_quota->QUOTA_PR_DAY_15 + $isi_request->QUOTA_PR_DAY_15;
            $pr_day16 = $data_quota->QUOTA_PR_DAY_16 + $isi_request->QUOTA_PR_DAY_16;
            $pr_day17 = $data_quota->QUOTA_PR_DAY_17 + $isi_request->QUOTA_PR_DAY_17;
            $pr_day18 = $data_quota->QUOTA_PR_DAY_18 + $isi_request->QUOTA_PR_DAY_18;
            $pr_day19 = $data_quota->QUOTA_PR_DAY_19 + $isi_request->QUOTA_PR_DAY_19;
            $pr_day20 = $data_quota->QUOTA_PR_DAY_20 + $isi_request->QUOTA_PR_DAY_20;
            $pr_day21 = $data_quota->QUOTA_PR_DAY_21 + $isi_request->QUOTA_PR_DAY_21;
            $pr_day22 = $data_quota->QUOTA_PR_DAY_22 + $isi_request->QUOTA_PR_DAY_22;
            $pr_day23 = $data_quota->QUOTA_PR_DAY_23 + $isi_request->QUOTA_PR_DAY_23;
            $pr_day24 = $data_quota->QUOTA_PR_DAY_24 + $isi_request->QUOTA_PR_DAY_24;
            $pr_day25 = $data_quota->QUOTA_PR_DAY_25 + $isi_request->QUOTA_PR_DAY_25;
            $pr_day26 = $data_quota->QUOTA_PR_DAY_26 + $isi_request->QUOTA_PR_DAY_26;
            $pr_day27 = $data_quota->QUOTA_PR_DAY_27 + $isi_request->QUOTA_PR_DAY_27;
            $pr_day28 = $data_quota->QUOTA_PR_DAY_28 + $isi_request->QUOTA_PR_DAY_28;
            $pr_day29 = $data_quota->QUOTA_PR_DAY_29 + $isi_request->QUOTA_PR_DAY_29;
            $pr_day30 = $data_quota->QUOTA_PR_DAY_30 + $isi_request->QUOTA_PR_DAY_30;
            $pr_day31 = $data_quota->QUOTA_PR_DAY_31 + $isi_request->QUOTA_PR_DAY_31;

            $im_day1 = $data_quota->QUOTA_IM_DAY_1 + $isi_request->QUOTA_IM_DAY_1;
            $im_day2 = $data_quota->QUOTA_IM_DAY_2 + $isi_request->QUOTA_IM_DAY_2;
            $im_day3 = $data_quota->QUOTA_IM_DAY_3 + $isi_request->QUOTA_IM_DAY_3;
            $im_day4 = $data_quota->QUOTA_IM_DAY_4 + $isi_request->QUOTA_IM_DAY_4;
            $im_day5 = $data_quota->QUOTA_IM_DAY_5 + $isi_request->QUOTA_IM_DAY_5;
            $im_day6 = $data_quota->QUOTA_IM_DAY_6 + $isi_request->QUOTA_IM_DAY_6;
            $im_day7 = $data_quota->QUOTA_IM_DAY_7 + $isi_request->QUOTA_IM_DAY_7;
            $im_day8 = $data_quota->QUOTA_IM_DAY_8 + $isi_request->QUOTA_IM_DAY_8;
            $im_day9 = $data_quota->QUOTA_IM_DAY_9 + $isi_request->QUOTA_IM_DAY_9;
            $im_day10 = $data_quota->QUOTA_IM_DAY_10 + $isi_request->QUOTA_IM_DAY_10;
            $im_day11 = $data_quota->QUOTA_IM_DAY_11 + $isi_request->QUOTA_IM_DAY_11;
            $im_day12 = $data_quota->QUOTA_IM_DAY_12 + $isi_request->QUOTA_IM_DAY_12;
            $im_day13 = $data_quota->QUOTA_IM_DAY_13 + $isi_request->QUOTA_IM_DAY_13;
            $im_day14 = $data_quota->QUOTA_IM_DAY_14 + $isi_request->QUOTA_IM_DAY_14;
            $im_day15 = $data_quota->QUOTA_IM_DAY_15 + $isi_request->QUOTA_IM_DAY_15;
            $im_day16 = $data_quota->QUOTA_IM_DAY_16 + $isi_request->QUOTA_IM_DAY_16;
            $im_day17 = $data_quota->QUOTA_IM_DAY_17 + $isi_request->QUOTA_IM_DAY_17;
            $im_day18 = $data_quota->QUOTA_IM_DAY_18 + $isi_request->QUOTA_IM_DAY_18;
            $im_day19 = $data_quota->QUOTA_IM_DAY_19 + $isi_request->QUOTA_IM_DAY_19;
            $im_day20 = $data_quota->QUOTA_IM_DAY_20 + $isi_request->QUOTA_IM_DAY_20;
            $im_day21 = $data_quota->QUOTA_IM_DAY_21 + $isi_request->QUOTA_IM_DAY_21;
            $im_day22 = $data_quota->QUOTA_IM_DAY_22 + $isi_request->QUOTA_IM_DAY_22;
            $im_day23 = $data_quota->QUOTA_IM_DAY_23 + $isi_request->QUOTA_IM_DAY_23;
            $im_day24 = $data_quota->QUOTA_IM_DAY_24 + $isi_request->QUOTA_IM_DAY_24;
            $im_day25 = $data_quota->QUOTA_IM_DAY_25 + $isi_request->QUOTA_IM_DAY_25;
            $im_day26 = $data_quota->QUOTA_IM_DAY_26 + $isi_request->QUOTA_IM_DAY_26;
            $im_day27 = $data_quota->QUOTA_IM_DAY_27 + $isi_request->QUOTA_IM_DAY_27;
            $im_day28 = $data_quota->QUOTA_IM_DAY_28 + $isi_request->QUOTA_IM_DAY_28;
            $im_day29 = $data_quota->QUOTA_IM_DAY_29 + $isi_request->QUOTA_IM_DAY_29;
            $im_day30 = $data_quota->QUOTA_IM_DAY_30 + $isi_request->QUOTA_IM_DAY_30;
            $im_day31 = $data_quota->QUOTA_IM_DAY_31 + $isi_request->QUOTA_IM_DAY_31;

            //set quota stdr
            if (trim($data_quota->QUOTA_STD) == "0") {
                $aortadb->query("UPDATE TT_QUOTA_KRY set QUOTA_STD='$quota_plan' WHERE TAHUNBULAN='$period' and NPK='$isi_request->NPK'");
            }

            $aortadb->query("UPDATE TT_QUOTA_KRY SET 
                QUOTAPLAN='$quota_plan', SISAPLAN='$sisa_plan', QUOTA='$quota', SISA='$sisa', 
                QUOTAPLAN1='$quota_plan1', SISAPLAN1='$sisa_plan1', QUOTA1='$quota1', SISA1='$sisa1',
                QUOTA_PR_DAY_1  = $pr_day1 ,
                QUOTA_PR_DAY_2  = $pr_day2 ,
                QUOTA_PR_DAY_3  = $pr_day3 ,
                QUOTA_PR_DAY_4  = $pr_day4 ,
                QUOTA_PR_DAY_5  = $pr_day5 ,
                QUOTA_PR_DAY_6  = $pr_day6 ,
                QUOTA_PR_DAY_7  = $pr_day7 ,
                QUOTA_PR_DAY_8  = $pr_day8 ,
                QUOTA_PR_DAY_9  = $pr_day9 ,
                QUOTA_PR_DAY_10 = $pr_day10,
                QUOTA_PR_DAY_11 = $pr_day11,
                QUOTA_PR_DAY_12 = $pr_day12,
                QUOTA_PR_DAY_13 = $pr_day13,
                QUOTA_PR_DAY_14 = $pr_day14,
                QUOTA_PR_DAY_15 = $pr_day15,
                QUOTA_PR_DAY_16 = $pr_day16,
                QUOTA_PR_DAY_17 = $pr_day17,
                QUOTA_PR_DAY_18 = $pr_day18,
                QUOTA_PR_DAY_19 = $pr_day19,
                QUOTA_PR_DAY_20 = $pr_day20,
                QUOTA_PR_DAY_21 = $pr_day21,
                QUOTA_PR_DAY_22 = $pr_day22,
                QUOTA_PR_DAY_23 = $pr_day23,
                QUOTA_PR_DAY_24 = $pr_day24,
                QUOTA_PR_DAY_25 = $pr_day25,
                QUOTA_PR_DAY_26 = $pr_day26,
                QUOTA_PR_DAY_27 = $pr_day27,
                QUOTA_PR_DAY_28 = $pr_day28,
                QUOTA_PR_DAY_29 = $pr_day29,
                QUOTA_PR_DAY_30 = $pr_day30,
                QUOTA_PR_DAY_31 = $pr_day31,
                QUOTA_IM_DAY_1  = $im_day1 ,
                QUOTA_IM_DAY_2  = $im_day2 ,
                QUOTA_IM_DAY_3  = $im_day3 ,
                QUOTA_IM_DAY_4  = $im_day4 ,
                QUOTA_IM_DAY_5  = $im_day5 ,
                QUOTA_IM_DAY_6  = $im_day6 ,
                QUOTA_IM_DAY_7  = $im_day7 ,
                QUOTA_IM_DAY_8  = $im_day8 ,
                QUOTA_IM_DAY_9  = $im_day9 ,
                QUOTA_IM_DAY_10 = $im_day10,
                QUOTA_IM_DAY_11 = $im_day11,
                QUOTA_IM_DAY_12 = $im_day12,
                QUOTA_IM_DAY_13 = $im_day13,
                QUOTA_IM_DAY_14 = $im_day14,
                QUOTA_IM_DAY_15 = $im_day15,
                QUOTA_IM_DAY_16 = $im_day16,
                QUOTA_IM_DAY_17 = $im_day17,
                QUOTA_IM_DAY_18 = $im_day18,
                QUOTA_IM_DAY_19 = $im_day19,
                QUOTA_IM_DAY_20 = $im_day20,
                QUOTA_IM_DAY_21 = $im_day21,
                QUOTA_IM_DAY_22 = $im_day22,
                QUOTA_IM_DAY_23 = $im_day23,
                QUOTA_IM_DAY_24 = $im_day24,
                QUOTA_IM_DAY_25 = $im_day25,
                QUOTA_IM_DAY_26 = $im_day26,
                QUOTA_IM_DAY_27 = $im_day27,
                QUOTA_IM_DAY_28 = $im_day28,
                QUOTA_IM_DAY_29 = $im_day29,
                QUOTA_IM_DAY_30 = $im_day30,
                QUOTA_IM_DAY_31 = $im_day31
            WHERE TAHUNBULAN = '$period' AND NPK='$isi_request->NPK'");

            $psnya = "Approve & Posting Quota By BOD NPK : " . $isi_request->NPK . " periode : " . $period . " Production : " . $isi_request->QUANTITY_QUOTA_PR . " dan Improvement : " . $isi_request->QUANTITY_QUOTA_IM;

            $aortadb->query("INSERT INTO TT_HISTORY(TGLTRANS,JAMTRANS,OTCPU,TIPETRANS,NO_SEQUENCE,OPERTRANS,OTVERSION,KETERANGAN,NPK) VALUES ('$date','$time', '$ip', 'APPROVE','$qrno','$created_by','AIS','$psnya','$isi_request->NPK')");
        }

        redirect($this->back_to_approve_dir . $period . '/' . $dept . '/' . 4);
    }

    function approve_all_quota_employee_by_dir()
    {
        $no_sequence_array = $this->input->post("noquota");
        $dept = $this->input->post("CHR_DEPT_2");
        $period = $this->input->post("CHR_PERIOD_2");
        $date = date('Ymd');
        $time = date('His');
        $ip = gethostbyaddr($_SERVER['REMOTE_ADDR']);
        $created_by = $this->session->userdata('USERNAME');

        if ($no_sequence_array == null || $no_sequence_array == 0) {
            redirect($this->back_to_approve_dir . $period . '/' . $dept . '/' . 6);
        }

        $aortadb = $this->load->database("aorta", TRUE);

        foreach ($no_sequence_array as $qrno) {

            $data_quota_request = $this->quota_employee_m->get_data_quota_request_approved_by_dir($period, $qrno);

            foreach ($data_quota_request as $isi_request) {

                $data = array(
                    'DIR_APPROVE' => 1,
                    'OPER_DIR_APPROVE' => $created_by,
                    'TGL_DIR_APPROVE' => $date,
                    'JAM_DIR_APPROVE' => $time,
                    'FLG_FINISH_APPROVE' => 1,
                    'TGL_POSTING' => $date
                );

                $this->quota_employee_m->update_quota_employee_by_id_and_period_and_npk($data, $qrno, $period, $isi_request->NPK);

                $data_quota = $this->quota_employee_m->get_data_quota_employee_by_period_and_npk($period, $isi_request->NPK);

                $quota_plan = (float) str_replace(",", ".", $data_quota->QUOTAPLAN) + (float) $isi_request->QUANTITY_QUOTA_PR;
                if ($quota_plan < 0) {
                    $quota_plan = 0;
                } else {
                    $quota_plan = str_replace(".", ",", $quota_plan);
                }

                $sisa_plan = (float) str_replace(",", ".", $data_quota->SISAPLAN) + (float) $isi_request->QUANTITY_QUOTA_PR;
                if ($sisa_plan < 0) {
                    $sisa_plan = 0;
                } else {
                    $sisa_plan = str_replace(".", ",", $sisa_plan);
                }

                $quota_plan1 = (float) str_replace(",", ".", $data_quota->QUOTAPLAN1) + (float) $isi_request->QUANTITY_QUOTA_IM;
                if ($quota_plan1 < 0) {
                    $quota_plan1 = 0;
                } else {
                    $quota_plan1 = str_replace(".", ",", $quota_plan1);
                }

                $sisa_plan1 = (float) str_replace(",", ".", $data_quota->SISAPLAN1) + (float) $isi_request->QUANTITY_QUOTA_IM;
                if ($sisa_plan1 < 0) {
                    $sisa_plan1 = 0;
                } else {
                    $sisa_plan1 = str_replace(".", ",", $sisa_plan1);
                }

                $quota = (float) str_replace(",", ".", $data_quota->QUOTA) + (float) $isi_request->QUANTITY_QUOTA_PR;
                if ($quota < 0) {
                    $quota = 0;
                } else {
                    $quota = str_replace(".", ",", $quota);
                }

                $sisa = (float) str_replace(",", ".", $data_quota->SISA) + (float) $isi_request->QUANTITY_QUOTA_PR;
                if ($sisa < 0) {
                    $sisa = 0;
                } else {
                    $sisa = str_replace(".", ",", $sisa);
                }

                $quota1 = (float) str_replace(",", ".", $data_quota->QUOTA1) + (float) $isi_request->QUANTITY_QUOTA_IM;
                if ($quota1 < 0) {
                    $quota1 = 0;
                } else {
                    $quota1 = str_replace(".", ",", $quota1);
                }

                $sisa1 = (float) str_replace(",", ".", $data_quota->SISA1) + (float) $isi_request->QUANTITY_QUOTA_IM;
                if ($sisa1 < 0) {
                    $sisa1 = 0;
                } else {
                    $sisa1 = str_replace(".", ",", $sisa1);
                }

                $pr_day1 = $data_quota->QUOTA_PR_DAY_1 + $isi_request->QUOTA_PR_DAY_1;
                $pr_day2 = $data_quota->QUOTA_PR_DAY_2 + $isi_request->QUOTA_PR_DAY_2;
                $pr_day3 = $data_quota->QUOTA_PR_DAY_3 + $isi_request->QUOTA_PR_DAY_3;
                $pr_day4 = $data_quota->QUOTA_PR_DAY_4 + $isi_request->QUOTA_PR_DAY_4;
                $pr_day5 = $data_quota->QUOTA_PR_DAY_5 + $isi_request->QUOTA_PR_DAY_5;
                $pr_day6 = $data_quota->QUOTA_PR_DAY_6 + $isi_request->QUOTA_PR_DAY_6;
                $pr_day7 = $data_quota->QUOTA_PR_DAY_7 + $isi_request->QUOTA_PR_DAY_7;
                $pr_day8 = $data_quota->QUOTA_PR_DAY_8 + $isi_request->QUOTA_PR_DAY_8;
                $pr_day9 = $data_quota->QUOTA_PR_DAY_9 + $isi_request->QUOTA_PR_DAY_9;
                $pr_day10 = $data_quota->QUOTA_PR_DAY_10 + $isi_request->QUOTA_PR_DAY_10;
                $pr_day11 = $data_quota->QUOTA_PR_DAY_11 + $isi_request->QUOTA_PR_DAY_11;
                $pr_day12 = $data_quota->QUOTA_PR_DAY_12 + $isi_request->QUOTA_PR_DAY_12;
                $pr_day13 = $data_quota->QUOTA_PR_DAY_13 + $isi_request->QUOTA_PR_DAY_13;
                $pr_day14 = $data_quota->QUOTA_PR_DAY_14 + $isi_request->QUOTA_PR_DAY_14;
                $pr_day15 = $data_quota->QUOTA_PR_DAY_15 + $isi_request->QUOTA_PR_DAY_15;
                $pr_day16 = $data_quota->QUOTA_PR_DAY_16 + $isi_request->QUOTA_PR_DAY_16;
                $pr_day17 = $data_quota->QUOTA_PR_DAY_17 + $isi_request->QUOTA_PR_DAY_17;
                $pr_day18 = $data_quota->QUOTA_PR_DAY_18 + $isi_request->QUOTA_PR_DAY_18;
                $pr_day19 = $data_quota->QUOTA_PR_DAY_19 + $isi_request->QUOTA_PR_DAY_19;
                $pr_day20 = $data_quota->QUOTA_PR_DAY_20 + $isi_request->QUOTA_PR_DAY_20;
                $pr_day21 = $data_quota->QUOTA_PR_DAY_21 + $isi_request->QUOTA_PR_DAY_21;
                $pr_day22 = $data_quota->QUOTA_PR_DAY_22 + $isi_request->QUOTA_PR_DAY_22;
                $pr_day23 = $data_quota->QUOTA_PR_DAY_23 + $isi_request->QUOTA_PR_DAY_23;
                $pr_day24 = $data_quota->QUOTA_PR_DAY_24 + $isi_request->QUOTA_PR_DAY_24;
                $pr_day25 = $data_quota->QUOTA_PR_DAY_25 + $isi_request->QUOTA_PR_DAY_25;
                $pr_day26 = $data_quota->QUOTA_PR_DAY_26 + $isi_request->QUOTA_PR_DAY_26;
                $pr_day27 = $data_quota->QUOTA_PR_DAY_27 + $isi_request->QUOTA_PR_DAY_27;
                $pr_day28 = $data_quota->QUOTA_PR_DAY_28 + $isi_request->QUOTA_PR_DAY_28;
                $pr_day29 = $data_quota->QUOTA_PR_DAY_29 + $isi_request->QUOTA_PR_DAY_29;
                $pr_day30 = $data_quota->QUOTA_PR_DAY_30 + $isi_request->QUOTA_PR_DAY_30;
                $pr_day31 = $data_quota->QUOTA_PR_DAY_31 + $isi_request->QUOTA_PR_DAY_31;

                $im_day1 = $data_quota->QUOTA_IM_DAY_1 + $isi_request->QUOTA_IM_DAY_1;
                $im_day2 = $data_quota->QUOTA_IM_DAY_2 + $isi_request->QUOTA_IM_DAY_2;
                $im_day3 = $data_quota->QUOTA_IM_DAY_3 + $isi_request->QUOTA_IM_DAY_3;
                $im_day4 = $data_quota->QUOTA_IM_DAY_4 + $isi_request->QUOTA_IM_DAY_4;
                $im_day5 = $data_quota->QUOTA_IM_DAY_5 + $isi_request->QUOTA_IM_DAY_5;
                $im_day6 = $data_quota->QUOTA_IM_DAY_6 + $isi_request->QUOTA_IM_DAY_6;
                $im_day7 = $data_quota->QUOTA_IM_DAY_7 + $isi_request->QUOTA_IM_DAY_7;
                $im_day8 = $data_quota->QUOTA_IM_DAY_8 + $isi_request->QUOTA_IM_DAY_8;
                $im_day9 = $data_quota->QUOTA_IM_DAY_9 + $isi_request->QUOTA_IM_DAY_9;
                $im_day10 = $data_quota->QUOTA_IM_DAY_10 + $isi_request->QUOTA_IM_DAY_10;
                $im_day11 = $data_quota->QUOTA_IM_DAY_11 + $isi_request->QUOTA_IM_DAY_11;
                $im_day12 = $data_quota->QUOTA_IM_DAY_12 + $isi_request->QUOTA_IM_DAY_12;
                $im_day13 = $data_quota->QUOTA_IM_DAY_13 + $isi_request->QUOTA_IM_DAY_13;
                $im_day14 = $data_quota->QUOTA_IM_DAY_14 + $isi_request->QUOTA_IM_DAY_14;
                $im_day15 = $data_quota->QUOTA_IM_DAY_15 + $isi_request->QUOTA_IM_DAY_15;
                $im_day16 = $data_quota->QUOTA_IM_DAY_16 + $isi_request->QUOTA_IM_DAY_16;
                $im_day17 = $data_quota->QUOTA_IM_DAY_17 + $isi_request->QUOTA_IM_DAY_17;
                $im_day18 = $data_quota->QUOTA_IM_DAY_18 + $isi_request->QUOTA_IM_DAY_18;
                $im_day19 = $data_quota->QUOTA_IM_DAY_19 + $isi_request->QUOTA_IM_DAY_19;
                $im_day20 = $data_quota->QUOTA_IM_DAY_20 + $isi_request->QUOTA_IM_DAY_20;
                $im_day21 = $data_quota->QUOTA_IM_DAY_21 + $isi_request->QUOTA_IM_DAY_21;
                $im_day22 = $data_quota->QUOTA_IM_DAY_22 + $isi_request->QUOTA_IM_DAY_22;
                $im_day23 = $data_quota->QUOTA_IM_DAY_23 + $isi_request->QUOTA_IM_DAY_23;
                $im_day24 = $data_quota->QUOTA_IM_DAY_24 + $isi_request->QUOTA_IM_DAY_24;
                $im_day25 = $data_quota->QUOTA_IM_DAY_25 + $isi_request->QUOTA_IM_DAY_25;
                $im_day26 = $data_quota->QUOTA_IM_DAY_26 + $isi_request->QUOTA_IM_DAY_26;
                $im_day27 = $data_quota->QUOTA_IM_DAY_27 + $isi_request->QUOTA_IM_DAY_27;
                $im_day28 = $data_quota->QUOTA_IM_DAY_28 + $isi_request->QUOTA_IM_DAY_28;
                $im_day29 = $data_quota->QUOTA_IM_DAY_29 + $isi_request->QUOTA_IM_DAY_29;
                $im_day30 = $data_quota->QUOTA_IM_DAY_30 + $isi_request->QUOTA_IM_DAY_30;
                $im_day31 = $data_quota->QUOTA_IM_DAY_31 + $isi_request->QUOTA_IM_DAY_31;

                //set quota stdr
                if (trim($data_quota->QUOTA_STD) == "0") {
                    $aortadb->query("UPDATE TT_QUOTA_KRY SET QUOTA_STD='$quota_plan' WHERE TAHUNBULAN='$period' and NPK='$isi_request->NPK'");
                }

                $aortadb->query("UPDATE TT_QUOTA_KRY SET 
                        QUOTAPLAN='$quota_plan', SISAPLAN='$sisa_plan', QUOTA='$quota', SISA='$sisa', 
                        QUOTAPLAN1='$quota_plan1', SISAPLAN1='$sisa_plan1', QUOTA1='$quota1', SISA1='$sisa1',
                        QUOTA_PR_DAY_1  = $pr_day1 ,
                        QUOTA_PR_DAY_2  = $pr_day2 ,
                        QUOTA_PR_DAY_3  = $pr_day3 ,
                        QUOTA_PR_DAY_4  = $pr_day4 ,
                        QUOTA_PR_DAY_5  = $pr_day5 ,
                        QUOTA_PR_DAY_6  = $pr_day6 ,
                        QUOTA_PR_DAY_7  = $pr_day7 ,
                        QUOTA_PR_DAY_8  = $pr_day8 ,
                        QUOTA_PR_DAY_9  = $pr_day9 ,
                        QUOTA_PR_DAY_10 = $pr_day10,
                        QUOTA_PR_DAY_11 = $pr_day11,
                        QUOTA_PR_DAY_12 = $pr_day12,
                        QUOTA_PR_DAY_13 = $pr_day13,
                        QUOTA_PR_DAY_14 = $pr_day14,
                        QUOTA_PR_DAY_15 = $pr_day15,
                        QUOTA_PR_DAY_16 = $pr_day16,
                        QUOTA_PR_DAY_17 = $pr_day17,
                        QUOTA_PR_DAY_18 = $pr_day18,
                        QUOTA_PR_DAY_19 = $pr_day19,
                        QUOTA_PR_DAY_20 = $pr_day20,
                        QUOTA_PR_DAY_21 = $pr_day21,
                        QUOTA_PR_DAY_22 = $pr_day22,
                        QUOTA_PR_DAY_23 = $pr_day23,
                        QUOTA_PR_DAY_24 = $pr_day24,
                        QUOTA_PR_DAY_25 = $pr_day25,
                        QUOTA_PR_DAY_26 = $pr_day26,
                        QUOTA_PR_DAY_27 = $pr_day27,
                        QUOTA_PR_DAY_28 = $pr_day28,
                        QUOTA_PR_DAY_29 = $pr_day29,
                        QUOTA_PR_DAY_30 = $pr_day30,
                        QUOTA_PR_DAY_31 = $pr_day31,
                        QUOTA_IM_DAY_1  = $im_day1 ,
                        QUOTA_IM_DAY_2  = $im_day2 ,
                        QUOTA_IM_DAY_3  = $im_day3 ,
                        QUOTA_IM_DAY_4  = $im_day4 ,
                        QUOTA_IM_DAY_5  = $im_day5 ,
                        QUOTA_IM_DAY_6  = $im_day6 ,
                        QUOTA_IM_DAY_7  = $im_day7 ,
                        QUOTA_IM_DAY_8  = $im_day8 ,
                        QUOTA_IM_DAY_9  = $im_day9 ,
                        QUOTA_IM_DAY_10 = $im_day10,
                        QUOTA_IM_DAY_11 = $im_day11,
                        QUOTA_IM_DAY_12 = $im_day12,
                        QUOTA_IM_DAY_13 = $im_day13,
                        QUOTA_IM_DAY_14 = $im_day14,
                        QUOTA_IM_DAY_15 = $im_day15,
                        QUOTA_IM_DAY_16 = $im_day16,
                        QUOTA_IM_DAY_17 = $im_day17,
                        QUOTA_IM_DAY_18 = $im_day18,
                        QUOTA_IM_DAY_19 = $im_day19,
                        QUOTA_IM_DAY_20 = $im_day20,
                        QUOTA_IM_DAY_21 = $im_day21,
                        QUOTA_IM_DAY_22 = $im_day22,
                        QUOTA_IM_DAY_23 = $im_day23,
                        QUOTA_IM_DAY_24 = $im_day24,
                        QUOTA_IM_DAY_25 = $im_day25,
                        QUOTA_IM_DAY_26 = $im_day26,
                        QUOTA_IM_DAY_27 = $im_day27,
                        QUOTA_IM_DAY_28 = $im_day28,
                        QUOTA_IM_DAY_29 = $im_day29,
                        QUOTA_IM_DAY_30 = $im_day30,
                        QUOTA_IM_DAY_31 = $im_day31
                        WHERE TAHUNBULAN = '$period' AND NPK='$isi_request->NPK'");

                $psnya = "Approve & Posting Quota By BOD NPK : " . $isi_request->NPK . " periode : " . $period . " Production : " . $isi_request->QUANTITY_QUOTA_PR . " dan Improvement : " . $isi_request->QUANTITY_QUOTA_IM;

                $aortadb->query("INSERT INTO TT_HISTORY(TGLTRANS,JAMTRANS,OTCPU,TIPETRANS,NO_SEQUENCE,OPERTRANS,OTVERSION,KETERANGAN,NPK) VALUES ('$date','$time', '$ip', 'APPROVE','$qrno','$created_by','AIS','$psnya','$isi_request->NPK')");
            }
        }

        redirect($this->back_to_approve_dir . $period . '/' . $dept . '/' . 4);
    }

    function reject_quota_employee_by_dir($qrno, $dept, $period)
    {
        $date = date('Ymd');
        $time = date('His');

        redirect($this->back_to_approve_dir . $period . '/' . $dept . '/' . 5);
    }

    function balancing_quota()
    {

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(114);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Balacing Quota Employee';

        $user_session = $this->session->all_userdata();
        $period = $this->input->post("CHR_PERIOD");
        $dept = $this->input->post('CHR_DEPT');
        $section = $this->input->post('CHR_SECTION');
        $role = $user_session['ROLE'];
        $id_dept = $user_session['DEPT'];
        $id_group = $user_session['GROUPDEPT'];
        $id_division = $user_session['DIVISION'];

        if ($user_session['NPK'] == '0608') {
            redirect("fail_c/auth");
        }

        if ($period == '' || $period == NULL) {
            $period = date('Ym');
        }

        if ($role == 1) {
            if ($dept == NULL) {
                $dept = $this->dept_m->get_top_data_dept_by_division($id_division)->row()->CHR_DEPT;
            } else {
                $dept = $dept;
            }
            $data['all_dept'] = $this->dept_m->get_dept_by_division_id($id_division);
        } else if ($role == 33) {
            if ($dept == NULL) {
                $dept = $this->dept_m->get_data_dept($id_dept)->row()->CHR_DEPT;
            } else {
                $dept = $dept;
            }
            $data['all_dept'] = $this->dept_m->get_dept_by_groupdept($id_group);
        } else {
            if ($dept == NULL) {
                $dept = $this->dept_m->get_data_dept($id_dept)->row()->CHR_DEPT;
            } else {
                $dept = $dept;
            }
            $data['all_dept'] = $this->dept_m->get_dept_by_dept($id_dept);
        }

        $data['all_section'] = $this->overtime_m->get_all_section_drop($dept);

        if ($section == NULL) {
            $section = 'ALL';
        } else {
            $x = 0;
            foreach ($data['all_section'] as $value) {
                if (trim($value->KODE) == trim($section)) {
                    $x = 1;
                }
            }

            if ($x == 0) {
                $section = 'ALL';
            }
        }

        $data['dept'] = $dept;
        $data['section'] = $section;
        $data['period'] = $period;

        $data_quota = $this->quota_employee_m->get_quota_employee_by_period_dept_and_section($period, $dept, $section);

        $i = 0;
        if ($data_quota->num_rows() > 0) {
            foreach ($data_quota->result() as $isi) {
                $quota_value[$i]['NO'] = $i + 1;
                $quota_value[$i]['NPK'] = $isi->NPK;
                $quota_value[$i]['NAMA'] = $isi->NAMA;
                $quota_value[$i]['QUOTAPLAN'] = $isi->QUOTAPLAN;
                $quota_value[$i]['TERPAKAIPLAN'] = $isi->TERPAKAIPLAN;
                $quota_value[$i]['SISAPLAN'] = $isi->SISAPLAN;
                $quota_value[$i]['QUOTAPLAN1'] = $isi->QUOTAPLAN1;
                $quota_value[$i]['TERPAKAIPLAN1'] = $isi->TERPAKAIPLAN1;
                $quota_value[$i]['SISAPLAN1'] = $isi->SISAPLAN1;
                $i++;
            }
        } else {
            $quota_value = array();
        }

        $data['data'] = $quota_value;
        $data['content'] = 'aorta/quota_employee/balancing_quota_employee_v';
        $this->load->view($this->layout, $data);
    }

    function update_balancing_quota_employee()
    {

        $tableRow = $this->input->post("tableRow");
        $period = $this->input->post("CHR_PERIOD");
        $upload_date = date('Ymd');
        $upload_time = date('His');
        $dept = $this->input->post('CHR_DEPT');
        $section = $this->input->post('CHR_SECTION');
        $created_by = $this->session->userdata('USERNAME');
        $editor = $this->session->userdata('NPK');

        foreach ($tableRow as $row) {

            $npk = trim($row['NPK']);
            $remain = $row['SISAPLAN'];
            $req = $row['INT_REQ'];
            $flg = $row['INT_FLG_UPDATE'];

            if ((float)str_replace(',', '.', $remain) + ((float) $req) < 0) {
            } else {
                if ($flg == 1 || $flg == '1') {
                    $this->quota_employee_m->update_balance($req, $period, $npk, $editor);

                    $data_history_balancing = array(
                        'CHR_PERIOD' => $period,
                        'CHR_NPK' => $npk,
                        'CHR_DEPT' => $dept,
                        'FLO_ORI_QUOTA' => (float)str_replace(',', '.', $remain),
                        'FLO_NEW_QUOTA' => (float)str_replace(',', '.', $remain) + (float)str_replace(',', '.', $req),
                        'FLO_CHANGED_QUOTA' => (float)str_replace(',', '.', $req),
                        'CHR_CREATED_BY' => $created_by,
                        'CHR_CREATED_DATE' => $upload_date,
                        'CHR_CREATED_TIME' => $upload_time,
                        'INT_FLG_PRODUCTION_QUOTA_TYPE' => 1
                    );

                    $this->history_m->save_history_balancing($data_history_balancing);
                }
            }
        }

        redirect($this->back_to_balance);
    }

    function update_balancing_quota_employee_improvement()
    {
        $tableRow = $this->input->post("tableRowImprovement");
        $period = $this->input->post("CHR_PERIOD");
        $upload_date = date('Ymd');
        $upload_time = date('His');
        $dept = $this->input->post('CHR_DEPT');
        $section = $this->input->post('CHR_SECTION');
        $created_by = $this->session->userdata('USERNAME');
        $editor = $this->session->userdata('NPK');

        foreach ($tableRow as $row) {

            $npk = trim($row['NPK']);
            $remain = $row['SISAPLAN1'];
            $req = $row['INT_REQ'];
            $flg = $row['INT_FLG_UPDATE'];

            if ((float)str_replace(',', '.', $remain) + ((float) $req) < 0) {
            } else {
                if ($flg == 1 || $flg == '1') {
                    $this->quota_employee_m->update_balance_improvement($req, $period, $npk, $editor);

                    $data_history_balancing = array(
                        'CHR_PERIOD' => $period,
                        'CHR_NPK' => $npk,
                        'CHR_DEPT' => $dept,
                        'FLO_ORI_QUOTA' => (float)str_replace(',', '.', $remain),
                        'FLO_NEW_QUOTA' => (float)str_replace(',', '.', $remain) + (float)str_replace(',', '.', $req),
                        'FLO_CHANGED_QUOTA' => (float)str_replace(',', '.', $req),
                        'CHR_CREATED_BY' => $created_by,
                        'CHR_CREATED_DATE' => $upload_date,
                        'CHR_CREATED_TIME' => $upload_time,
                        'INT_FLG_PRODUCTION_QUOTA_TYPE' => 0
                    );

                    $this->history_m->save_history_balancing($data_history_balancing);
                }
            }
        }

        redirect($this->back_to_balance);
    }

    function view_plan_quota_request($period = null, $dept = null, $section = null, $id_doc = NULL)
    {
        $data['period'] = $period;
        $data['dept'] = $dept;

        if ($section == null) {
            $section = 'ALL';
        }

        $data['section'] = $section;
        $data['plan'] = $this->quota_employee_m->get_plan_quota_by_sequence($id_doc);
        $data['first_saturday'] = $this->firstSaturday(substr($period, 0, 4) . '-' . substr($period, 4, 2));

        $data['content'] = 'aorta/quota_employee/summary_plan_quota_request_v';
        $this->load->view("/template/head_blank", $data);
    }

    function view_plan_vs_actual_quota($period = null, $dept = null, $section = null)
    {
        $data['period'] = $period;
        $data['dept'] = $dept;

        if ($section == null) {
            $section = 'ALL';
        }

        $data['section'] = $section;
        $data['plan'] = $this->quota_employee_m->get_plan_quota_by_dept_and_period($period, $dept, $section);
        $data['actl'] = $this->quota_employee_m->get_actl_quota_by_dept_and_period($period, $dept, $section);
        $data['first_sunday'] = $this->firstSunday(substr($period, 0, 4) . '-' . substr($period, 4, 2));
        $data['first_saturday'] = $this->firstSaturday(substr($period, 0, 4) . '-' . substr($period, 4, 2));

        $data['content'] = 'aorta/quota_employee/summary_plan_vs_actual_quota_v';
        $this->load->view("/template/head_blank", $data);
    }

    function view_plan_vs_actual_quota_accumulation($period = null, $dept = null, $section = null)
    {
        $data['period'] = $period;
        $data['dept'] = $dept;

        if ($section == null) {
            $section = 'ALL';
        }

        $data['section'] = $section;
        $data['plan'] = $this->quota_employee_m->get_plan_quota_accumulation_by_dept_and_period($period, $dept, $section);
        $data['actl'] = $this->quota_employee_m->get_actl_quota_accumulation_by_dept_and_period($period, $dept, $section);
        $data['first_sunday'] = $this->firstSunday(substr($period, 0, 4) . '-' . substr($period, 4, 2));
        $data['first_saturday'] = $this->firstSaturday(substr($period, 0, 4) . '-' . substr($period, 4, 2));

        $data['content'] = 'aorta/quota_employee/summary_plan_vs_actual_quota_accumulation_v';
        $this->load->view("/template/head_blank", $data);
    }

    function downloadViewPlanActualQuota($period = null, $dept = null, $section = null)
    {
        if ($section == null) {
            $section = 'ALL';
        }

        $plan = $this->quota_employee_m->get_plan_quota_by_dept_and_period($period, $dept, $section);
        $actl = $this->quota_employee_m->get_actl_quota_by_dept_and_period($period, $dept, $section);
        $data_quota = $this->quota_employee_m->get_plan_quota_by_dept_and_period_detail($period, $dept, $section);

        $this->load->library('excel');
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator(trim('AIS - Quota Plan VS Actual'));
        $objPHPExcel->getProperties()->setLastModifiedBy(trim($this->session->userdata('USERNAME')));
        $objPHPExcel->getProperties()->setTitle("Quota Plan VS Actual");
        $objPHPExcel->getProperties()->setSubject("Quota Plan VS Actual");
        $objPHPExcel->getProperties()->setDescription("Quota Plan VS Actual");

        //SETUP EXCEL
        $objPHPExcel->setActiveSheetIndex();
        $worksheet = $objPHPExcel->getActiveSheet();
        $worksheet->setTitle($period . "_" . $dept);

        //HEADER
        $worksheet->setCellValue('C2', 'Section');
        $worksheet->setCellValue('D2', '1');
        $worksheet->setCellValue('E2', '2');
        $worksheet->setCellValue('F2', '3');
        $worksheet->setCellValue('G2', '4');
        $worksheet->setCellValue('H2', '5');
        $worksheet->setCellValue('I2', '6');
        $worksheet->setCellValue('J2', '7');
        $worksheet->setCellValue('K2', '8');
        $worksheet->setCellValue('L2', '9');
        $worksheet->setCellValue('M2', '10');
        $worksheet->setCellValue('N2', '11');
        $worksheet->setCellValue('O2', '12');
        $worksheet->setCellValue('P2', '13');
        $worksheet->setCellValue('Q2', '14');
        $worksheet->setCellValue('R2', '15');
        $worksheet->setCellValue('S2', '16');
        $worksheet->setCellValue('T2', '17');
        $worksheet->setCellValue('U2', '18');
        $worksheet->setCellValue('V2', '19');
        $worksheet->setCellValue('W2', '20');
        $worksheet->setCellValue('X2', '21');
        $worksheet->setCellValue('Y2', '22');
        $worksheet->setCellValue('Z2', '23');
        $worksheet->setCellValue('AA2', '24');
        $worksheet->setCellValue('AB2', '25');
        $worksheet->setCellValue('AC2', '26');
        $worksheet->setCellValue('AD2', '27');
        $worksheet->setCellValue('AE2', '28');
        $worksheet->setCellValue('AF2', '29');
        $worksheet->setCellValue('AG2', '30');
        $worksheet->setCellValue('AH2', '31');
        $worksheet->setCellValue('AI2', 'Total');

        $total_plan = $plan->DATE_01 + $plan->DATE_02 + $plan->DATE_03 + $plan->DATE_04 + $plan->DATE_05 + $plan->DATE_06 + $plan->DATE_07 + $plan->DATE_08 + $plan->DATE_09 + $plan->DATE_10 +
            $plan->DATE_11 + $plan->DATE_12 + $plan->DATE_13 + $plan->DATE_14 + $plan->DATE_15 + $plan->DATE_16 + $plan->DATE_17 + $plan->DATE_18 + $plan->DATE_19 + $plan->DATE_20 +
            $plan->DATE_21 + $plan->DATE_22 + $plan->DATE_23 + $plan->DATE_24 + $plan->DATE_25 + $plan->DATE_26 + $plan->DATE_27 + $plan->DATE_28 + $plan->DATE_29 + $plan->DATE_30 + $plan->DATE_31;

        $total_actl = $actl->DATE_01 + $actl->DATE_02 + $actl->DATE_03 + $actl->DATE_04 + $actl->DATE_05 + $actl->DATE_06 + $actl->DATE_07 + $actl->DATE_08 + $actl->DATE_09 + $actl->DATE_10 +
            $actl->DATE_11 + $actl->DATE_12 + $actl->DATE_13 + $actl->DATE_14 + $actl->DATE_15 + $actl->DATE_16 + $actl->DATE_17 + $actl->DATE_18 + $actl->DATE_19 + $actl->DATE_20 +
            $actl->DATE_21 + $actl->DATE_22 + $actl->DATE_23 + $actl->DATE_24 + $actl->DATE_25 + $actl->DATE_26 + $actl->DATE_27 + $actl->DATE_28 + $actl->DATE_29 + $actl->DATE_30 + $actl->DATE_31;

        $e = 3;
        $worksheet->setCellValue("B$e", "PLANNING");
        $worksheet->setCellValue("C$e", $section);
        $worksheet->setCellValue("D$e", $plan->DATE_01);
        $worksheet->setCellValue("E$e", $plan->DATE_02);
        $worksheet->setCellValue("F$e", $plan->DATE_03);
        $worksheet->setCellValue("G$e", $plan->DATE_04);
        $worksheet->setCellValue("H$e", $plan->DATE_05);
        $worksheet->setCellValue("I$e", $plan->DATE_06);
        $worksheet->setCellValue("J$e", $plan->DATE_07);
        $worksheet->setCellValue("K$e", $plan->DATE_08);
        $worksheet->setCellValue("L$e", $plan->DATE_09);
        $worksheet->setCellValue("M$e", $plan->DATE_10);
        $worksheet->setCellValue("N$e", $plan->DATE_11);
        $worksheet->setCellValue("O$e", $plan->DATE_12);
        $worksheet->setCellValue("P$e", $plan->DATE_13);
        $worksheet->setCellValue("Q$e", $plan->DATE_14);
        $worksheet->setCellValue("R$e", $plan->DATE_15);
        $worksheet->setCellValue("S$e", $plan->DATE_16);
        $worksheet->setCellValue("T$e", $plan->DATE_17);
        $worksheet->setCellValue("U$e", $plan->DATE_18);
        $worksheet->setCellValue("V$e", $plan->DATE_19);
        $worksheet->setCellValue("W$e", $plan->DATE_20);
        $worksheet->setCellValue("X$e", $plan->DATE_21);
        $worksheet->setCellValue("Y$e", $plan->DATE_22);
        $worksheet->setCellValue("Z$e", $plan->DATE_23);
        $worksheet->setCellValue("AA$e", $plan->DATE_24);
        $worksheet->setCellValue("AB$e", $plan->DATE_25);
        $worksheet->setCellValue("AC$e", $plan->DATE_26);
        $worksheet->setCellValue("AD$e", $plan->DATE_27);
        $worksheet->setCellValue("AE$e", $plan->DATE_28);
        $worksheet->setCellValue("AF$e", $plan->DATE_29);
        $worksheet->setCellValue("AG$e", $plan->DATE_30);
        $worksheet->setCellValue("AH$e", $plan->DATE_31);
        $worksheet->setCellValue("AI$e", $total_plan);

        $e = 4;
        $worksheet->setCellValue("B$e", "ACTUAL");
        $worksheet->setCellValue("C$e", $section);
        $worksheet->setCellValue("D$e", $actl->DATE_01);
        $worksheet->setCellValue("E$e", $actl->DATE_02);
        $worksheet->setCellValue("F$e", $actl->DATE_03);
        $worksheet->setCellValue("G$e", $actl->DATE_04);
        $worksheet->setCellValue("H$e", $actl->DATE_05);
        $worksheet->setCellValue("I$e", $actl->DATE_06);
        $worksheet->setCellValue("J$e", $actl->DATE_07);
        $worksheet->setCellValue("K$e", $actl->DATE_08);
        $worksheet->setCellValue("L$e", $actl->DATE_09);
        $worksheet->setCellValue("M$e", $actl->DATE_10);
        $worksheet->setCellValue("N$e", $actl->DATE_11);
        $worksheet->setCellValue("O$e", $actl->DATE_12);
        $worksheet->setCellValue("P$e", $actl->DATE_13);
        $worksheet->setCellValue("Q$e", $actl->DATE_14);
        $worksheet->setCellValue("R$e", $actl->DATE_15);
        $worksheet->setCellValue("S$e", $actl->DATE_16);
        $worksheet->setCellValue("T$e", $actl->DATE_17);
        $worksheet->setCellValue("U$e", $actl->DATE_18);
        $worksheet->setCellValue("V$e", $actl->DATE_19);
        $worksheet->setCellValue("W$e", $actl->DATE_20);
        $worksheet->setCellValue("X$e", $actl->DATE_21);
        $worksheet->setCellValue("Y$e", $actl->DATE_22);
        $worksheet->setCellValue("Z$e", $actl->DATE_23);
        $worksheet->setCellValue("AA$e", $actl->DATE_24);
        $worksheet->setCellValue("AB$e", $actl->DATE_25);
        $worksheet->setCellValue("AC$e", $actl->DATE_26);
        $worksheet->setCellValue("AD$e", $actl->DATE_27);
        $worksheet->setCellValue("AE$e", $actl->DATE_28);
        $worksheet->setCellValue("AF$e", $actl->DATE_29);
        $worksheet->setCellValue("AG$e", $actl->DATE_30);
        $worksheet->setCellValue("AH$e", $actl->DATE_31);
        $worksheet->setCellValue("AI$e", $total_actl);

        //HEADER
        $worksheet->setCellValue('A6', 'PLANNING');
        $worksheet->setCellValue('B6', 'NPK');
        $worksheet->setCellValue('C6', 'Section');
        $worksheet->setCellValue('D6', '1');
        $worksheet->setCellValue('E6', '2');
        $worksheet->setCellValue('F6', '3');
        $worksheet->setCellValue('G6', '4');
        $worksheet->setCellValue('H6', '5');
        $worksheet->setCellValue('I6', '6');
        $worksheet->setCellValue('J6', '7');
        $worksheet->setCellValue('K6', '8');
        $worksheet->setCellValue('L6', '9');
        $worksheet->setCellValue('M6', '10');
        $worksheet->setCellValue('N6', '11');
        $worksheet->setCellValue('O6', '12');
        $worksheet->setCellValue('P6', '13');
        $worksheet->setCellValue('Q6', '14');
        $worksheet->setCellValue('R6', '15');
        $worksheet->setCellValue('S6', '16');
        $worksheet->setCellValue('T6', '17');
        $worksheet->setCellValue('U6', '18');
        $worksheet->setCellValue('V6', '19');
        $worksheet->setCellValue('W6', '20');
        $worksheet->setCellValue('X6', '21');
        $worksheet->setCellValue('Y6', '26');
        $worksheet->setCellValue('Z6', '23');
        $worksheet->setCellValue('AA6', '24');
        $worksheet->setCellValue('AB6', '25');
        $worksheet->setCellValue('AC6', '26');
        $worksheet->setCellValue('AD6', '27');
        $worksheet->setCellValue('AE6', '28');
        $worksheet->setCellValue('AF6', '29');
        $worksheet->setCellValue('AG6', '30');
        $worksheet->setCellValue('AH6', '31');
        $worksheet->setCellValue('AI6', 'Total');

        $e = 7;
        foreach ($data_quota as $row) {

            $total_plan_req = $row->DATE_01 + $row->DATE_02 + $row->DATE_03 + $row->DATE_04 + $row->DATE_05 + $row->DATE_06 + $row->DATE_07 + $row->DATE_08 + $row->DATE_09 + $row->DATE_10 +
                $row->DATE_11 + $row->DATE_12 + $row->DATE_13 + $row->DATE_14 + $row->DATE_15 + $row->DATE_16 + $row->DATE_17 + $row->DATE_18 + $row->DATE_19 + $row->DATE_20 +
                $row->DATE_21 + $row->DATE_22 + $row->DATE_23 + $row->DATE_24 + $row->DATE_25 + $row->DATE_26 + $row->DATE_27 + $row->DATE_28 + $row->DATE_29 + $row->DATE_30 + $row->DATE_31;

            $worksheet->setCellValue("B$e", $row->NPK);
            $worksheet->setCellValue("C$e", $row->KD_SECTION);
            $worksheet->setCellValue("D$e", $row->DATE_01);
            $worksheet->setCellValue("E$e", $row->DATE_02);
            $worksheet->setCellValue("F$e", $row->DATE_03);
            $worksheet->setCellValue("G$e", $row->DATE_04);
            $worksheet->setCellValue("H$e", $row->DATE_05);
            $worksheet->setCellValue("I$e", $row->DATE_06);
            $worksheet->setCellValue("J$e", $row->DATE_07);
            $worksheet->setCellValue("K$e", $row->DATE_08);
            $worksheet->setCellValue("L$e", $row->DATE_09);
            $worksheet->setCellValue("M$e", $row->DATE_10);
            $worksheet->setCellValue("N$e", $row->DATE_11);
            $worksheet->setCellValue("O$e", $row->DATE_12);
            $worksheet->setCellValue("P$e", $row->DATE_13);
            $worksheet->setCellValue("Q$e", $row->DATE_14);
            $worksheet->setCellValue("R$e", $row->DATE_15);
            $worksheet->setCellValue("S$e", $row->DATE_16);
            $worksheet->setCellValue("T$e", $row->DATE_17);
            $worksheet->setCellValue("U$e", $row->DATE_18);
            $worksheet->setCellValue("V$e", $row->DATE_19);
            $worksheet->setCellValue("W$e", $row->DATE_20);
            $worksheet->setCellValue("X$e", $row->DATE_21);
            $worksheet->setCellValue("Y$e", $row->DATE_22);
            $worksheet->setCellValue("Z$e", $row->DATE_23);
            $worksheet->setCellValue("AA$e", $row->DATE_24);
            $worksheet->setCellValue("AB$e", $row->DATE_25);
            $worksheet->setCellValue("AC$e", $row->DATE_26);
            $worksheet->setCellValue("AD$e", $row->DATE_27);
            $worksheet->setCellValue("AE$e", $row->DATE_28);
            $worksheet->setCellValue("AF$e", $row->DATE_29);
            $worksheet->setCellValue("AG$e", $row->DATE_30);
            $worksheet->setCellValue("AH$e", $row->DATE_31);
            $worksheet->setCellValue("AI$e", $total_plan_req);
            $e++;
        }

        $filename = 'quota_plan_vs_actual_' . trim($dept) . trim($period)  . ".xlt";
        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . trim($filename) . '"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
    }

    function downloadViewPlanActualQuotaAccumulative($period = null, $dept = null, $section = null)
    {
        if ($section == null) {
            $section = 'ALL';
        }

        $plan = $this->quota_employee_m->get_plan_quota_accumulation_by_dept_and_period($period, $dept, $section);
        $actl = $this->quota_employee_m->get_actl_quota_accumulation_by_dept_and_period($period, $dept, $section);

        $this->load->library('excel');
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator(trim('AIS - Quota Plan VS Actual'));
        $objPHPExcel->getProperties()->setLastModifiedBy(trim($this->session->userdata('USERNAME')));
        $objPHPExcel->getProperties()->setTitle("Quota Plan VS Actual");
        $objPHPExcel->getProperties()->setSubject("Quota Plan VS Actual");
        $objPHPExcel->getProperties()->setDescription("Quota Plan VS Actual");

        //SETUP EXCEL
        $objPHPExcel->setActiveSheetIndex();
        $worksheet = $objPHPExcel->getActiveSheet();
        $worksheet->setTitle($period . "_" . $dept);

        //HEADER
        $worksheet->setCellValue('C2', 'Section');
        $worksheet->setCellValue('D2', '1');
        $worksheet->setCellValue('E2', '2');
        $worksheet->setCellValue('F2', '3');
        $worksheet->setCellValue('G2', '4');
        $worksheet->setCellValue('H2', '5');
        $worksheet->setCellValue('I2', '6');
        $worksheet->setCellValue('J2', '7');
        $worksheet->setCellValue('K2', '8');
        $worksheet->setCellValue('L2', '9');
        $worksheet->setCellValue('M2', '10');
        $worksheet->setCellValue('N2', '11');
        $worksheet->setCellValue('O2', '12');
        $worksheet->setCellValue('P2', '13');
        $worksheet->setCellValue('Q2', '14');
        $worksheet->setCellValue('R2', '15');
        $worksheet->setCellValue('S2', '16');
        $worksheet->setCellValue('T2', '17');
        $worksheet->setCellValue('U2', '18');
        $worksheet->setCellValue('V2', '19');
        $worksheet->setCellValue('W2', '20');
        $worksheet->setCellValue('X2', '21');
        $worksheet->setCellValue('Y2', '22');
        $worksheet->setCellValue('Z2', '23');
        $worksheet->setCellValue('AA2', '24');
        $worksheet->setCellValue('AB2', '25');
        $worksheet->setCellValue('AC2', '26');
        $worksheet->setCellValue('AD2', '27');
        $worksheet->setCellValue('AE2', '28');
        $worksheet->setCellValue('AF2', '29');
        $worksheet->setCellValue('AG2', '30');
        $worksheet->setCellValue('AH2', '31');
        $worksheet->setCellValue('AI2', 'Total');

        $total_plan = $plan->DATE_01 + $plan->DATE_02 + $plan->DATE_03 + $plan->DATE_04 + $plan->DATE_05 + $plan->DATE_06 + $plan->DATE_07 + $plan->DATE_08 + $plan->DATE_09 + $plan->DATE_10 +
            $plan->DATE_11 + $plan->DATE_12 + $plan->DATE_13 + $plan->DATE_14 + $plan->DATE_15 + $plan->DATE_16 + $plan->DATE_17 + $plan->DATE_18 + $plan->DATE_19 + $plan->DATE_20 +
            $plan->DATE_21 + $plan->DATE_22 + $plan->DATE_23 + $plan->DATE_24 + $plan->DATE_25 + $plan->DATE_26 + $plan->DATE_27 + $plan->DATE_28 + $plan->DATE_29 + $plan->DATE_30 + $plan->DATE_31;

        $total_actl = $actl->DATE_01 + $actl->DATE_02 + $actl->DATE_03 + $actl->DATE_04 + $actl->DATE_05 + $actl->DATE_06 + $actl->DATE_07 + $actl->DATE_08 + $actl->DATE_09 + $actl->DATE_10 +
            $actl->DATE_11 + $actl->DATE_12 + $actl->DATE_13 + $actl->DATE_14 + $actl->DATE_15 + $actl->DATE_16 + $actl->DATE_17 + $actl->DATE_18 + $actl->DATE_19 + $actl->DATE_20 +
            $actl->DATE_21 + $actl->DATE_22 + $actl->DATE_23 + $actl->DATE_24 + $actl->DATE_25 + $actl->DATE_26 + $actl->DATE_27 + $actl->DATE_28 + $actl->DATE_29 + $actl->DATE_30 + $actl->DATE_31;

        $e = 3;
        $worksheet->setCellValue("C$e", $section);
        $worksheet->setCellValue("D$e", $plan->DATE_01);
        $worksheet->setCellValue("E$e", $plan->DATE_02);
        $worksheet->setCellValue("F$e", $plan->DATE_03);
        $worksheet->setCellValue("G$e", $plan->DATE_04);
        $worksheet->setCellValue("H$e", $plan->DATE_05);
        $worksheet->setCellValue("I$e", $plan->DATE_06);
        $worksheet->setCellValue("J$e", $plan->DATE_07);
        $worksheet->setCellValue("K$e", $plan->DATE_08);
        $worksheet->setCellValue("L$e", $plan->DATE_09);
        $worksheet->setCellValue("M$e", $plan->DATE_10);
        $worksheet->setCellValue("N$e", $plan->DATE_11);
        $worksheet->setCellValue("O$e", $plan->DATE_12);
        $worksheet->setCellValue("P$e", $plan->DATE_13);
        $worksheet->setCellValue("Q$e", $plan->DATE_14);
        $worksheet->setCellValue("R$e", $plan->DATE_15);
        $worksheet->setCellValue("S$e", $plan->DATE_16);
        $worksheet->setCellValue("T$e", $plan->DATE_17);
        $worksheet->setCellValue("U$e", $plan->DATE_18);
        $worksheet->setCellValue("V$e", $plan->DATE_19);
        $worksheet->setCellValue("W$e", $plan->DATE_20);
        $worksheet->setCellValue("X$e", $plan->DATE_21);
        $worksheet->setCellValue("Y$e", $plan->DATE_22);
        $worksheet->setCellValue("Z$e", $plan->DATE_23);
        $worksheet->setCellValue("AA$e", $plan->DATE_24);
        $worksheet->setCellValue("AB$e", $plan->DATE_25);
        $worksheet->setCellValue("AC$e", $plan->DATE_26);
        $worksheet->setCellValue("AD$e", $plan->DATE_27);
        $worksheet->setCellValue("AE$e", $plan->DATE_28);
        $worksheet->setCellValue("AF$e", $plan->DATE_29);
        $worksheet->setCellValue("AG$e", $plan->DATE_30);
        $worksheet->setCellValue("AH$e", $plan->DATE_31);
        $worksheet->setCellValue("AI$e", $total_plan);

        $e = 4;
        $worksheet->setCellValue("C$e", $section);
        $worksheet->setCellValue("D$e", $actl->DATE_01);
        $worksheet->setCellValue("E$e", $actl->DATE_02);
        $worksheet->setCellValue("F$e", $actl->DATE_03);
        $worksheet->setCellValue("G$e", $actl->DATE_04);
        $worksheet->setCellValue("H$e", $actl->DATE_05);
        $worksheet->setCellValue("I$e", $actl->DATE_06);
        $worksheet->setCellValue("J$e", $actl->DATE_07);
        $worksheet->setCellValue("K$e", $actl->DATE_08);
        $worksheet->setCellValue("L$e", $actl->DATE_09);
        $worksheet->setCellValue("M$e", $actl->DATE_10);
        $worksheet->setCellValue("N$e", $actl->DATE_11);
        $worksheet->setCellValue("O$e", $actl->DATE_12);
        $worksheet->setCellValue("P$e", $actl->DATE_13);
        $worksheet->setCellValue("Q$e", $actl->DATE_14);
        $worksheet->setCellValue("R$e", $actl->DATE_15);
        $worksheet->setCellValue("S$e", $actl->DATE_16);
        $worksheet->setCellValue("T$e", $actl->DATE_17);
        $worksheet->setCellValue("U$e", $actl->DATE_18);
        $worksheet->setCellValue("V$e", $actl->DATE_19);
        $worksheet->setCellValue("W$e", $actl->DATE_20);
        $worksheet->setCellValue("X$e", $actl->DATE_21);
        $worksheet->setCellValue("Y$e", $actl->DATE_22);
        $worksheet->setCellValue("Z$e", $actl->DATE_23);
        $worksheet->setCellValue("AA$e", $actl->DATE_24);
        $worksheet->setCellValue("AB$e", $actl->DATE_25);
        $worksheet->setCellValue("AC$e", $actl->DATE_26);
        $worksheet->setCellValue("AD$e", $actl->DATE_27);
        $worksheet->setCellValue("AE$e", $actl->DATE_28);
        $worksheet->setCellValue("AF$e", $actl->DATE_29);
        $worksheet->setCellValue("AG$e", $actl->DATE_30);
        $worksheet->setCellValue("AH$e", $actl->DATE_31);
        $worksheet->setCellValue("AI$e", $total_actl);

        $filename = 'quota_plan_vs_actual_' . trim($dept) . trim($period)  . ".xlt";
        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . trim($filename) . '"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
    }

    function log_balancing($period = null, $dept = null)
    {
        $this->check_session();

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(345);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Manage Quota Employee';

        $user_session = $this->session->all_userdata();
        $role = $user_session['ROLE'];
        $npk = $user_session['NPK'];
        $id_dept = $user_session['DEPT'];
        $id_group = $user_session['GROUPDEPT'];
        $id_division = $user_session['DIVISION'];

        if ($role == 1) {
            if ($dept == NULL) {
                $dept = $this->dept_m->get_top_data_dept_by_division($id_division)->row()->CHR_DEPT;
            } else {
                $dept = $dept;
            }
            $data['all_dept'] = $this->dept_m->get_dept_by_division_id($id_division);
        } else {
            if ($dept == NULL) {
                $dept = $this->dept_m->get_data_dept($id_dept)->row()->CHR_DEPT;
            } else {
                $dept = $dept;
            }
            $data['all_dept'] = $this->dept_m->get_data_dept($id_dept)->result();
        }

        if ($period == NULL) {
            $period = date('Ym');
        }

        $data['period'] = $period;
        $data['dept'] = $dept;
        $data['role'] = $role;
        $data['npk'] = $npk;

        $data['data'] = $this->history_m->get_data_log_balancing($data['dept'], $period);
        $data['content'] = 'aorta/quota_employee/log_balancing_quota_employee_v';
        $this->load->view($this->layout, $data);
    }

    function get_section_by_dept()
    {
        $kode_dept = $this->input->post("KODE");

        $data_section = $this->overtime_m->get_all_section_drop($kode_dept);
        $section = 'ALL';
        $data = '';

        foreach ($data_section as $row) {
            if (trim($section) == trim($row->KODE)) {
                $data .= "<option selected value='$row->KODE'>" . $row->KODE . "</option>";
            } else {
                $data .= "<option value='$row->KODE'>" . $row->KODE . "</option>";
            }
        }

        $json_data = array('data' => $data);

        echo json_encode($json_data);
    }

    function firstSunday($date)
    {
        for ($day = 1; $day <= 7; $day++) {
            $dd = strftime("%A", strtotime($date . '-' . $day));
            if ($dd == 'Sunday') {
                return strftime("%Y-%m-%d", strtotime($date . '-' . $day));
            }
        }
    }

    function firstSaturday($date)
    {
        for ($day = 1; $day <= 7; $day++) {
            $dd = strftime("%A", strtotime($date . '-' . $day));
            if ($dd == 'Saturday') {
                return strftime("%Y-%m-%d", strtotime($date . '-' . $day));
            }
        }
    }

    // function downloadTemplateQuotaRequest($period = null, $dept = null, $section = null)
    // {
    //     if ($section == null) {
    //         $section = 'ALL';
    //     }

    //     $dayCount = cal_days_in_month(CAL_GREGORIAN, substr($period, -2), substr($period, 0, 4));
    //     $data = $this->quota_employee_m->get_data_employee_by_dept_section_and_period($dept, $section);

    //     $this->load->library('excel');
    //     $objPHPExcel = new PHPExcel();
    //     $objPHPExcel->getProperties()->setCreator(trim('AIS-templateGenerator'));
    //     $objPHPExcel->getProperties()->setLastModifiedBy(trim($this->session->userdata('USERNAME')));
    //     $objPHPExcel->getProperties()->setTitle("Template Quota" . $period . " dept " . $dept);
    //     $objPHPExcel->getProperties()->setSubject("Template Quota" . $period . " dept " . $dept);
    //     $objPHPExcel->getProperties()->setDescription("Template Quota" . $period . " dept " . $dept);

    //     //SETUP EXCEL
    //     $objPHPExcel->setActiveSheetIndex();
    //     $worksheet = $objPHPExcel->getActiveSheet();
    //     $worksheet->setTitle($period . "_" . $dept);

    //     //HEADER
    //     $worksheet->setCellValue('A1', 'No');
    //     $worksheet->setCellValue('B1', 'NPK');
    //     $worksheet->setCellValue('C1', 'Name');
    //     $worksheet->setCellValue('D1', 'Production Quota');
    //     $worksheet->setCellValue('AF1', 'Production Quota');
    //     $worksheet->setCellValue('BH1', 'Total');
    //     $worksheet->setCellValue('D2', '1');
    //     $worksheet->setCellValue('E2', '2');
    //     $worksheet->setCellValue('F2', '3');
    //     $worksheet->setCellValue('G2', '4');
    //     $worksheet->setCellValue('H2', '5');
    //     $worksheet->setCellValue('I2', '6');
    //     $worksheet->setCellValue('J2', '7');
    //     $worksheet->setCellValue('K2', '8');
    //     $worksheet->setCellValue('L2', '9');
    //     $worksheet->setCellValue('M2', '10');
    //     $worksheet->setCellValue('N2', '11');
    //     $worksheet->setCellValue('O2', '12');
    //     $worksheet->setCellValue('P2', '13');
    //     $worksheet->setCellValue('Q2', '14');
    //     $worksheet->setCellValue('R2', '15');
    //     $worksheet->setCellValue('S2', '16');
    //     $worksheet->setCellValue('T2', '17');
    //     $worksheet->setCellValue('U2', '18');
    //     $worksheet->setCellValue('V2', '19');
    //     $worksheet->setCellValue('W2', '20');
    //     $worksheet->setCellValue('X2', '21');
    //     $worksheet->setCellValue('Y2', '22');
    //     $worksheet->setCellValue('Z2', '23');
    //     $worksheet->setCellValue('AA2', '24');
    //     $worksheet->setCellValue('AB2', '25');
    //     $worksheet->setCellValue('AC2', '26');
    //     $worksheet->setCellValue('AD2', '27');
    //     $worksheet->setCellValue('AE2', '28');
    //     $worksheet->setCellValue('AF2', '29');
    //     $worksheet->setCellValue('AG2', '30');
    //     $worksheet->setCellValue('AH2', '31');

    //     $e = 3;
    //     $no = 1;
    //     foreach ($data as $isi) {
    //         $worksheet->setCellValue("A$e", $no);
    //         $worksheet->setCellValue("B$e", "'".$isi->NPK);
    //         $worksheet->setCellValue("C$e", $isi->NAMA);
    //         $worksheet->setCellValue("D$e", '0');
    //         $worksheet->setCellValue("E$e", "0");
    //         $worksheet->setCellValue("F$e", "0");
    //         $worksheet->setCellValue("G$e", "0");
    //         $worksheet->setCellValue("H$e", "0");
    //         $worksheet->setCellValue("I$e", "0");
    //         $worksheet->setCellValue("J$e", "0");
    //         $worksheet->setCellValue("K$e", "0");
    //         $worksheet->setCellValue("L$e", "0");
    //         $worksheet->setCellValue("M$e", "0");
    //         $worksheet->setCellValue("N$e", "0");
    //         $worksheet->setCellValue("O$e", "0");
    //         $worksheet->setCellValue("P$e", "0");
    //         $worksheet->setCellValue("Q$e", "0");
    //         $worksheet->setCellValue("R$e", "0");
    //         $worksheet->setCellValue("S$e", "0");
    //         $worksheet->setCellValue("T$e", "0");
    //         $worksheet->setCellValue("U$e", "0");
    //         $worksheet->setCellValue("V$e", "0");
    //         $worksheet->setCellValue("W$e", "0");
    //         $worksheet->setCellValue("X$e", "0");
    //         $worksheet->setCellValue("Y$e", "0");
    //         $worksheet->setCellValue("Z$e", "0");
    //         $worksheet->setCellValue("AA$e", "0");
    //         $worksheet->setCellValue("AB$e", "0");
    //         $worksheet->setCellValue("AC$e", "0");
    //         $worksheet->setCellValue("AD$e", "0");
    //         $worksheet->setCellValue("AE$e", "0");
    //         $worksheet->setCellValue("AF$e", "0");
    //         $worksheet->setCellValue("AG$e", "0");
    //         $worksheet->setCellValue("AH$e", "0");

    //         $no++;
    //         $e++;
    //     }

    //     $filename = 'templateQuota' . trim($dept) . trim($period)  . ".xlt";
    //     ob_end_clean();
    //     header('Content-Type: application/vnd.ms-excel');
    //     header('Content-Disposition: attachment;filename="' . trim($filename) . '"');
    //     header('Cache-Control: max-age=0');

    //     $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
    //     $objWriter->save('php://output');
    // }
}
