<?php

//Add By bugsMaker 20170812
class process_part_c extends CI_Controller
{

    private $layout = '/template/head';
    private $back_to_upload = '/part/process_part_c/create_process_part/';
    private $back_to_index = '/part/process_part_c/index/';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('part/process_part_m');
        $this->load->model('part/part_m');
        $this->load->model('organization/dept_m');
        $this->load->model('prd/direct_backflush_general_m');
        $this->load->model('prd/group_line_m');
    }

    function index($work_center = null, $msg = NULL)
    {
        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Creating success </strong> The data is successfully created </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Updating success </strong> The data is successfully updated </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Deleted success </strong> The data is successfully deleted </div >";
        } elseif ($msg == 15) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Executing error !</strong> Template Anda Salah atau sudah diubah, Silahkan Coba Lagi Dengan Template Yang Benar </div >";
        } elseif ($msg == 12) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Executing error !</strong> Something error with parameter </div >";
        }

        if ($work_center == NULL) {
            $work_center = $this->direct_backflush_general_m->get_top_work_center_ines();
        }

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(66);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Upload Cycle Time';
        $data['msg'] = $msg;

        $user_session = $this->session->all_userdata();
        $data['id_group'] = $user_session['GROUPDEPT'];
        $data['id_role'] = $user_session['ROLE'];
        $data['all_work_centers'] = $this->direct_backflush_general_m->get_all_work_center_ines();
        $data['work_center'] = $work_center;

        $data['data'] = $this->process_part_m->downloadDataProcessPart($work_center);
        $data['content'] = 'part/process_part/manage_process_part_v';
        $this->load->view($this->layout, $data);
    }

    function create_process_part($work_center = null, $msg = null)
    {
        if ($msg == 1) {
            $msg = "<div class = 'alert alert-default'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Verification success, Dont forget to Save data </strong> The temporary data is successfully created, to confirm click save at the bellow</div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Updating success </strong> The data is successfully updated </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Deleted success </strong> The data is successfully deleted </div >";
        } elseif ($msg == 13) {
            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Schedule Reason empty !</strong>Please, Fill the reason of additional quota</div >";
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
        $data['sidebar'] = $this->role_module_m->side_bar(66);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Upload Cycle Time';
        $data['msg'] = $msg;

        $data['work_center'] = $work_center;
        $data['all_work_centers'] = $this->direct_backflush_general_m->getWorkCenter();
        $data['data'] = array();
        $data['increment'] = 0;

        $data['data_template'] = $this->process_part_m->downloadDataProcessPart($work_center);

        $data['content'] = 'part/process_part/upload_process_part_v';
        $this->load->view($this->layout, $data);
    }

    function getTemplate($work_center)
    {
        $this->load->library('excel');

        $objPHPExcel = new PHPExcel();

        $style = array(
            'alignment' => array(
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            )
        );

        $objPHPExcel->getDefaultStyle()->applyFromArray($style);

        //SETUP EXCEL
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(3);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(12);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(12);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(12);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(12);

        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'No');
        $objPHPExcel->getActiveSheet()->setCellValue('B1', 'Work Center');
        $objPHPExcel->getActiveSheet()->setCellValue('C1', 'Part No');
        $objPHPExcel->getActiveSheet()->setCellValue('D1', 'Back No');
        $objPHPExcel->getActiveSheet()->setCellValue('E1', 'Cycle Time');
        $objPHPExcel->getActiveSheet()->setCellValue('F1', 'Man power');

        $i = 2;
        $no = 1;
        $data = $this->process_part_m->downloadDataProcessPart($work_center);
        foreach ($data as $isi) {
            $objPHPExcel->getActiveSheet()->setCellValue("A$i", $no);
            $objPHPExcel->getActiveSheet()->setCellValue("B$i", $isi->CHR_WORK_CENTER);
            $objPHPExcel->getActiveSheet()->setCellValue("C$i", $isi->CHR_PART_NO);
            $objPHPExcel->getActiveSheet()->setCellValue("D$i", $isi->CHR_BACK_NO);
            $objPHPExcel->getActiveSheet()->setCellValue("E$i", $isi->INT_CYCLE_TIME);
            $objPHPExcel->getActiveSheet()->setCellValue("F$i", $isi->INT_MP);

            $i++;
            $no++;
        }

        $i = $i - 1;
        $objPHPExcel->getActiveSheet()->getStyle("A1:F$i")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle("A1:F1")->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFFF00');
        $objPHPExcel->getActiveSheet()->getStyle("A1:D$i")->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('f5f5f5');

        $filename = "template-" . $work_center . ".xlsx";
        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . trim($filename) . '"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
    }

    function uploadCycleTime()
    {
        $this->load->library(array('PHPExcel', 'PHPExcel/IOFactory'));
        $this->load->library('upload');

        $work_center = $this->input->post('CHR_WORK_CENTER');

        $fileName = $_FILES['upload_schedule']['name'];
        if (empty($fileName)) {
            redirect($this->back_to_upload . $work_center . '/' . $msg = 14);
        }

        //file untuk submit file excel
        $config['upload_path'] = './assets/file/cycle_time/';
        $config['file_name'] = $fileName;
        $config['allowed_types'] = 'xls|xlsx';
        $config['max_size'] = 10000;

        //code for upload with ci
        $this->upload->initialize($config);
        if ($a = $this->upload->do_upload('upload_schedule'))
            $this->upload->display_errors();

        $media = $this->upload->data('upload_schedule');
        $inputFileName = './assets/file/cycle_time/' . $media['file_name'];

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

        $no = $rowHeader[0][0];
        $work_center_excel = $rowHeader[0][1];
        $part_no = $rowHeader[0][2];
        $back_no = $rowHeader[0][3];
        $ct_excel = $rowHeader[0][4];

        $i = 0;
        if (trim($no) == 'No' && trim($work_center_excel) == 'Work Center' && trim($part_no) == 'Part No' && trim($back_no) == 'Back No' && trim($ct_excel) == 'Cycle Time') {
            for ($row = 2; $row <= $highestRow; $row++) {
                $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);

                $part_no_string = str_replace("'", "", $rowData[0][2]);

                $data[$i]['INT_FLG_DEL'] = 0;
                $data[$i]['ERROR_MESSAGE'] = NULL;

                $flag_routing = $this->part_m->check_process_part_no($rowData[0][1], $part_no_string);
                if (!$flag_routing) {
                    $data[$i]['INT_FLG_DEL'] = 1;
                    $data[$i]['ERROR_MESSAGE'] = 'Part No : ' . $part_no_string . ' tidak terdaftar di work center ' . $rowData[0][1];
                }

                $flag_existing = $this->part_m->check_existing_part_no($part_no_string);
                if (!$flag_existing) {
                    $data[$i]['INT_FLG_DEL'] = 1;
                    $data[$i]['ERROR_MESSAGE'] = 'Part No : ' . $part_no_string . ' tidak terdaftar';
                }

                $data[$i]['INT_SEQUENCE'] = $rowData[0][0];
                $data[$i]['CHR_WORK_CENTER'] = $rowData[0][1];
                $data[$i]['CHR_PART_NO'] = $part_no_string;
                $data[$i]['CHR_BACK_NO'] = $rowData[0][3];
                $data[$i]['INT_CYCLE_TIME'] = $rowData[0][4];
                $data[$i]['INT_MP'] = $rowData[0][5];

                $i++;
            }

            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Uploading success </strong> The temporary data is successfully created, to confirm click save at the bellow</div >";

            $data_view['app'] = $this->role_module_m->get_app();
            $data_view['module'] = $this->role_module_m->get_module();
            $data_view['function'] = $this->role_module_m->get_function();
            $data_view['sidebar'] = $this->role_module_m->side_bar(66);
            $data_view['news'] = $this->news_m->get_news();
            $data_view['title'] = 'Upload Cycle Time';
            $data_view['msg'] = $msg;

            $data_view['work_center'] = $work_center;
            $data_view['all_work_centers'] = $this->direct_backflush_general_m->getWorkCenter();
            $data_view['increment'] = $i;
            $data_view['data'] = $data;
            $data_view['data_template'] = $this->process_part_m->downloadDataProcessPart($work_center);

            $data_view['content'] = 'part/process_part/upload_process_part_v';
            $this->load->view($this->layout, $data_view);
        } else {
            redirect($this->back_to_upload . $work_center . '/' . $msg = 15);
        }
    }

    function saveCycleTime()
    {
        $tableRow = $this->input->post("tableRow");
        $work_center = $this->input->post("CHR_WORK_CENTER");
        $created_by = $this->session->userdata('USERNAME');

        foreach ($tableRow as $row) {

            if ($row['INT_FLG_DEL'] == 0) {

                $data['INT_CYCLE_TIME'] = $row['INT_CYCLE_TIME'];
                $data['INT_MP'] = $row['INT_MP'];
                $data['CHR_PART_NO'] = $row['CHR_PART_NO'];
                $data['CHR_WORK_CENTER'] = $row['CHR_WORK_CENTER'];
                $data['CHR_CREATED_BY'] = $created_by;

                $this->process_part_m->saveCycleTime($data);
            }
        }

        redirect($this->back_to_index . $work_center . '/' . 1);
    }

    function upload_process_part()
    {
        $this->load->library(array('PHPExcel', 'PHPExcel/IOFactory'));
        $this->load->library('upload');

        $work_center = $this->input->post('CHR_WORK_CENTER');

        $fileName = $_FILES['upload_schedule']['name'];
        if (empty($fileName)) {
            redirect($this->back_to_upload . $work_center . '/' . $msg = 14);
        }

        //file untuk submit file excel
        $config['upload_path'] = './assets/file/cycle_time/';
        $config['file_name'] = $fileName;
        $config['allowed_types'] = 'xls|xlsx';
        $config['max_size'] = 10000;

        //code for upload with ci
        $this->upload->initialize($config);
        if ($a = $this->upload->do_upload('upload_schedule'))
            $this->upload->display_errors();

        $media = $this->upload->data('upload_schedule');
        $inputFileName = './assets/file/cycle_time/' . $media['file_name'];

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

        $no = $rowHeader[0][0];
        $work_center_excel = $rowHeader[0][1];
        $part_no = $rowHeader[0][2];
        $back_no = $rowHeader[0][3];
        $ct_excel = $rowHeader[0][4];

        $i = 0;
        if (trim($no) == 'No' && trim($work_center_excel) == 'Work Center' && trim($part_no) == 'Part No' && trim($back_no) == 'Back No' && trim($ct_excel) == 'Cycle Time') {
            for ($row = 2; $row <= $highestRow; $row++) {
                $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);

                $part_no_string = str_replace("'", "", $rowData[0][2]);

                $data[$i]['FLG_DELETE'] = 0;
                $data[$i]['ERROR_MESSAGE'] = NULL;

                $flag_routing = $this->part_m->check_process_part_no($rowData[0][1], $part_no_string);
                if (!$flag_routing) {
                    $data[$i]['FLG_DELETE'] = 1;
                    $data[$i]['ERROR_MESSAGE'] = 'Part No : ' . $part_no_string . ' tidak terdaftar di work center ' . $rowData[0][1];
                }

                $flag_existing = $this->part_m->check_existing_part_no($part_no_string);
                if (!$flag_existing) {
                    $data[$i]['FLG_DELETE'] = 1;
                    $data[$i]['ERROR_MESSAGE'] = 'Part No : ' . $part_no_string . ' tidak terdaftar';
                }

                $data[$i]['INT_SEQUENCE'] = $rowData[0][0];
                $data[$i]['CHR_WORK_CENTER'] = $rowData[0][1];
                $data[$i]['CHR_PART_NO'] = $part_no_string;
                $data[$i]['CHR_BACK_NO'] = $rowData[0][3];
                $data[$i]['INT_CYCLE_TIME'] = $rowData[0][4];
                $data[$i]['INT_MP'] = $rowData[0][5];

                $i++;
            }

            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Uploading success </strong> The temporary data is successfully created, to confirm click save at the bellow</div >";

            $data_view['app'] = $this->role_module_m->get_app();
            $data_view['module'] = $this->role_module_m->get_module();
            $data_view['function'] = $this->role_module_m->get_function();
            $data_view['sidebar'] = $this->role_module_m->side_bar(66);
            $data_view['news'] = $this->news_m->get_news();
            $data_view['title'] = 'Upload Schedule Kanban';
            $data_view['msg'] = $msg;

            $data_view['work_center'] = $work_center;
            $data_view['increment'] = $i;
            $data_view['data'] = $data;
            $data_view['data_template'] = $this->process_part_m->downloadDataProcessPart($work_center);

            $data_view['content'] = 'part/process_part/upload_process_part_v';
            $this->load->view($this->layout, $data_view);
        } else {
            redirect($this->back_to_upload . $work_center . '/' . $msg = 15);
        }
    }

    function update_process_part()
    {

        $cycle_time = $this->input->post('INT_CYCLE_TIME');

        $work_center = $this->input->post('CHR_WORK_CENTER');
        $part_no = $this->input->post('CHR_PART_NO');

        $data_primary = array(
            'INT_CYCLE_TIME' => $cycle_time,
        );

        $id_primary = array(
            'CHR_PART_NO' => $part_no,
            'CHR_WORK_CENTER' => $work_center
        );

        $this->process_part_m->update($data_primary, $id_primary);

        redirect($this->back_to_index . $work_center . '/' . 2);
    }

    function save_process_part()
    {
        //update to saveCycleTime
        $tableRow = $this->input->post("tableRow");
        $work_center = $this->input->post("CHR_WORK_CENTER");
        $created_by = $this->session->userdata('USERNAME');
        $datenow = date('Ymd');
        $timenow = date('His');

        foreach ($tableRow as $row) {

            if ($row['FLG_DELETE'] == 0) {

                $data['INT_CYCLE_TIME'] = $row['INT_CYCLE_TIME'];
                $data['INT_MP'] = $row['INT_MP'];
                $data['CHR_MODIFIED_BY'] = $created_by;
                $data['CHR_MODIFIED_DATE'] = $datenow;
                $data['CHR_MODIFIED_TIME'] = $timenow;

                $id['CHR_PART_NO'] = $row['CHR_PART_NO'];
                $id['CHR_WORK_CENTER'] = $row['CHR_WORK_CENTER'];

                $this->process_part_m->update($data, $id);
            }
        }

        redirect($this->back_to_index . $work_center . '/' . 1);
    }

    function method_part($work_center = null, $msg = null)
    {

        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Creating success </strong> The data is successfully created </div >";
        }

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(313);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Manage Method Scan Part';
        $data['msg'] = $msg;
        if ($work_center == null) {
            $work_center = $this->direct_backflush_general_m->get_top_data_direct_backflush_general();
        }
        $data['data'] = $this->process_part_m->get_data_part_by_work_center($work_center);

        $data_work_center = $this->direct_backflush_general_m->get_active_data_work_center();
        $data['all_work_centers'] = $data_work_center;
        $data['work_center'] = $work_center;

        $data['content'] = 'part/manage_method_part_v';
        $this->load->view($this->layout, $data);
    }

    function update_method_part()
    {
        $flg_method = $this->input->post('INT_FLG_METHODS');
        $part_no = $this->input->post('CHR_PART_NO');
        $work_center = $this->input->post('CHR_WORK_CENTER');

        $data = array(
            'INT_FLG_METHODS' => $flg_method
        );

        $id = array(
            'CHR_WORK_CENTER' => $work_center,
            'CHR_PART_NO' => $part_no
        );

        $this->process_part_m->update_methods($data, $id);

        redirect('part/process_part_c/method_part/' . trim($work_center) . '/' . 1);
    }

    function process_part_target($group = null, $period = null, $msg = NULL)
    {
        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Creating success </strong> The data is successfully created </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Updating success </strong> The data is successfully updated </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Deleted success </strong> The data is successfully deleted </div >";
        } elseif ($msg == 15) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Executing error !</strong> Template Anda Salah atau sudah diubah, Silahkan Coba Lagi Dengan Template Yang Benar </div >";
        } elseif ($msg == 12) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Executing error !</strong> Something error with parameter </div >";
        }

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(117);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Manage Target Parts';
        $data['msg'] = $msg;

        if ($period == null || $period == '') {
            $period = date('Ym');
        }

        if ($group == null || $group == '') {
            $group = 1;
        }

        $data['all_group'] = $this->group_line_m->get_all_prod_group_product();
        $data['group'] = $group;
        $data['period'] = $period;

        $data['data'] = $this->process_part_m->get_data_process_part_target_by_group_and_period($group, $period);
        $data['content'] = 'part/process_part/manage_process_part_target_v';
        $this->load->view($this->layout, $data);
    }

    function create_process_part_target($group = null, $period = null, $msg = null)
    {
        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Uploading success </strong> The temporary data is successfully created, to confirm click save at the bellow</div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Updating success </strong> The data is successfully updated </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Deleted success </strong> The data is successfully deleted </div >";
        } elseif ($msg == 13) {
            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Schedule Reason empty !</strong>Please, Fill the reason of additional quota</div >";
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
        $data['sidebar'] = $this->role_module_m->side_bar(117);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Upload Target parts';
        $data['msg'] = $msg;

        $data['group'] = $group;
        $data['period'] = $period;
        $data['data'] = array();
        $data['increment'] = 0;

        $data['data_template'] = $this->process_part_m->get_data_to_download_process_part_by_group_and_period($group);

        $data['content'] = 'part/process_part/upload_process_part_target_v';
        $this->load->view($this->layout, $data);
    }

    function upload_process_part_target()
    {
        $this->load->library(array('PHPExcel', 'PHPExcel/IOFactory'));
        $this->load->library('upload');

        $group = $this->input->post('INT_PRODUCT_CODE');
        $period = $this->input->post('CHR_PERIOD');

        $upload_date = date('Ymd');

        $fileName = $_FILES['upload_file']['name'];
        if (empty($fileName)) {
            redirect('/part/process_part_c/process_part_target/' . $group . '/' . $period . '/' . $msg = 14);
        }

        //file untuk submit file excel
        $config['upload_path'] = './assets/file/target_production/';
        $config['file_name'] = $fileName;
        $config['allowed_types'] = 'xls|xlsx';
        $config['max_size'] = 10000;

        //code for upload with ci
        $this->upload->initialize($config);
        if ($a = $this->upload->do_upload('upload_file'))
            $this->upload->display_errors();

        $media = $this->upload->data('upload_file');
        $inputFileName = './assets/file/target_production/' . $media['file_name'];

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

        $no_excel = $rowHeader[0][0];
        $work_center_excel = $rowHeader[0][1];
        $part_no_excel = $rowHeader[0][2];
        $pv_excel = $rowHeader[0][3];
        $target_excel = $rowHeader[0][4];

        $i = 0;
        if (trim($no_excel) == 'No' && trim($work_center_excel) == 'Work Center' && trim($part_no_excel) == 'Part No' && trim($pv_excel) == 'PV' && trim($target_excel) == 'Target Production') {
            for ($row = 2; $row <= $highestRow; $row++) {
                $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);

                $part_no_string = str_replace("'", "", $rowData[0][2]);
                $pv_string = str_replace("'", "", $rowData[0][3]);

                $data[$i]['FLG_DELETE'] = 0;
                $data[$i]['ERROR_MESSAGE'] = NULL;

                $flag_routing = $this->part_m->check_process_part_no($rowData[0][1], $part_no_string);
                if (!$flag_routing) {
                    $data[$i]['FLG_DELETE'] = 1;
                    $data[$i]['ERROR_MESSAGE'] = 'Part No : ' . $part_no_string . ' tidak terdaftar di work center ' . $rowData[0][1];
                }

                $flag_existing = $this->part_m->check_existing_part_no($part_no_string);
                if (!$flag_existing) {
                    $data[$i]['FLG_DELETE'] = 1;
                    $data[$i]['ERROR_MESSAGE'] = 'Part No : ' . $part_no_string . ' tidak terdaftar';
                }

                if (is_int((int)$rowData[0][4]) == false) {
                    $data[$i]['FLG_DELETE'] = 1;
                    $data[$i]['ERROR_MESSAGE'] = 'Target Production part : ' . $part_no_string . ' bukan angka';
                }

                $data[$i]['INT_SEQUENCE'] = $rowData[0][0];
                $data[$i]['CHR_WORK_CENTER'] = $rowData[0][1];
                $data[$i]['CHR_PART_NO'] = $part_no_string;
                $data[$i]['CHR_PV'] = $pv_string;
                $data[$i]['INT_TARGET_PRODUCTION'] = (int)$rowData[0][4];

                $i++;
            }

            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Uploading success </strong> The temporary data is successfully created, to confirm click save at the bellow</div >";

            $data_view['app'] = $this->role_module_m->get_app();
            $data_view['module'] = $this->role_module_m->get_module();
            $data_view['function'] = $this->role_module_m->get_function();
            $data_view['sidebar'] = $this->role_module_m->side_bar(66);
            $data_view['news'] = $this->news_m->get_news();
            $data_view['title'] = 'Upload Target Part';
            $data_view['msg'] = $msg;

            $data_view['group'] = $group;
            $data_view['period'] = $period;

            $data_view['increment'] = $i;
            $data_view['data'] = $data;
            $data_view['data_template'] = $this->process_part_m->get_data_to_download_process_part_by_group_and_period($group);

            $data_view['content'] = 'part/process_part/upload_process_part_target_v';
            $this->load->view($this->layout, $data_view);
        } else {
            redirect('/part/process_part_c/process_part_target/' . $group . '/' . $period . '/' . $msg = 15);
        }
    }

    function update_process_part_target()
    {

        $target = $this->input->post('INT_TARGET_PRODUCTION');
        $work_center = $this->input->post('CHR_WORK_CENTER');
        $part_no = $this->input->post('CHR_PART_NO');
        $pv = $this->input->post('CHR_PV');

        $data = array(
            'INT_TARGET_PRODUCTION' => $target,
        );

        $id = array(
            'CHR_PART_NO' => $part_no,
            'CHR_PV' => $pv,
            'CHR_WORK_CENTER' => $work_center,
            'CHR_PERIOD' => $this->input->post('CHR_PERIOD')
        );

        $this->process_part_m->update_target_part($data, $id);

        redirect('/part/process_part_c/process_part_target/' . $this->input->post('INT_PRODUCT_CODE') . '/' . $this->input->post('CHR_PERIOD') . '/' . 2);
    }

    function save_process_part_target()
    {

        foreach ($this->input->post("tableRow") as $row) {

            if ($row['FLG_DELETE'] == 0 && (int)$row['INT_TARGET_PRODUCTION'] != 0) {

                $data['CHR_PERIOD'] = $this->input->post("CHR_PERIOD");
                $data['CHR_PART_NO'] = $row['CHR_PART_NO'];
                $data['CHR_PV'] = $row['CHR_PV'];
                $data['CHR_WORK_CENTER'] = $row['CHR_WORK_CENTER'];
                $data['INT_TARGET_PRODUCTION'] = $row['INT_TARGET_PRODUCTION'];
                $data['CHR_CREATED_BY'] = $this->session->userdata('USERNAME');

                $this->process_part_m->merge_part_target($data);
            }
        }

        redirect('/part/process_part_c/process_part_target/' . $this->input->post("INT_PRODUCT_CODE") . '/' . $this->input->post("CHR_PERIOD") . '/' . 1);
    }

    public function get_part_by_work_center()
    {

        $work_center = $this->input->post("CHR_WORK_CENTER");
        $part_no_aisin = $this->process_part_m->get_data_part_by_workcenter($work_center);

        $data = '';
        foreach ($part_no_aisin as $row) {
            $data .= "<option value='$row->CHR_PART_NO'>" . $row->CHR_PART_NO . "</option>";
        }

        echo json_encode($data);
    }

    //Loop3r
    public function getExistingLabel()
    {
        $part_no = $this->input->post('part_no');
        $work_center = $this->input->post('work_center');
        $data['status'] = false;

        $data_shipping_part = $this->process_part_m->get_data_part_customer_by_work_center($part_no, $work_center);
        if ($data_shipping_part) {
            $data['status'] = true;
        }

        if ('IS_AJAX') {
            echo json_encode($data);
        }
    }

    //Loop3r
    public function compareLabel()
    {
        $part_no = $this->input->post('part_no');
        $label_barcode = trim($this->input->post('label_barcode'));
        $work_center = trim($this->input->post('work_center'));
        $data['status'] = false;

        $label_barcode_array =  (explode(" ", $label_barcode));
        $part_no_cust = trim(str_replace('%', ' ', $label_barcode_array[0]));
        $part_no_cust = trim(str_replace('L', ' ', $part_no_cust));
        $part_no_cust = trim(str_replace('Q', ' ', $part_no_cust));

        if (strlen($part_no_cust) > 12) {
            $part_no_cust = substr($part_no_cust, 0, 12);
        }

        $match_flag = $this->part_customer_m->verify_part_no_with_customer($part_no, $part_no_cust);
        if ($match_flag) {
            $data['status'] = true;
        } else {
            $data['message'] = 'Part ' . $part_no . ' not match with cust part no ' . $part_no_cust;
        }

        if ('IS_AJAX') {
            echo json_encode($data);
        }
    }
}
