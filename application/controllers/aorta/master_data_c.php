<?php

class Master_data_c extends CI_Controller {
    /* -- define constructor -- */

    private $layout = '/template/head';
    private $back_to_manage_dept = 'aorta/master_data_c/manage_dept/';
    private $back_to_manage_section = 'aorta/master_data_c/manage_section/';
    private $back_to_manage_subsection = 'aorta/master_data_c/manage_subsection/';
    private $back_to_manage_policy = 'aorta/master_data_c/manage_policy/';

    public function __construct() {
        parent::__construct();
        $this->load->model('organization/dept_m');
        $this->load->model('aorta/master_data_m');
    }

    public function employee() {
        $this->role_module_m->authorization('151');
        $this->log_m->add_log(9, NULL);
        $this->session->userdata('user_id');

        $data['title'] = 'Master Data Employee';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(151);
        $data['news'] = $this->news_m->get_news();
        $data['content'] = 'aorta/master_employee_v';
        $ymd = date("Ymd");
        $date = date("Ym");
        $data_karyawan = array();

        $kode_dept = $this->session->userdata('DEPT');
        if ($this->session->userdata('ROLE') == 39  || $this->session->userdata('ROLE') == 5 || $this->session->userdata('ROLE') == 14 || $this->session->userdata('ROLE') == 1 || $this->session->userdata('ROLE') == 35 || $this->session->userdata('ROLE') == 33) { //Manager
            $data['id_prod'] = $this->session->userdata('DEPT');
            $row = $this->dept_m->get_data_dept($this->session->userdata('DEPT'))->row();
            $responsible = '01' . substr($row->CHR_DEPT, 2, 1);
            $kode_dept = $this->session->userdata('DEPT');
            //ambil ke matrix AIS to AORTA
            // $get_kode_dept_aorta = $this->master_data_m->get_kd_dept_aorta($kode_dept);
            $all_work_centers = $this->master_data_m->get_section($kode_dept);
            $dept_name = $row->CHR_DEPT;
            $data_karyawan = $this->master_data_m->get_data_karyawan($kode_dept);
        }

        $data['kode_dept'] = $kode_dept;
        $data['data_karyawan'] = $data_karyawan;
        $data['all_work_centers'] = $all_work_centers;
        $data['all_dept_prod'] = $this->dept_m->get_all_prod_dept();
        $data['date'] = date('d/m/Y');
        $data['fulldate'] = date('Ymd');
        $data['work_center'] = 'ALL';
        $data['selected_date_diagram'] = substr($date, 0, 4) . '/' . substr($date, 4, 2);
        $data['selected_date'] = $date;
        $data['d'] = '';
        $data['shift'] = '';
        $data['dept_name'] = $dept_name;
        $data['role'] = $this->session->userdata('ROLE');

        $this->load->view($this->layout, $data);
    }

    public function generate_template($dept) {
        $this->load->library('excel');

        //get data
        $dept_desc = $this->master_data_m->replacer_dept_prd($dept);
        $list_kry = $this->master_data_m->get_data_karyawan($dept);

        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

        // Set properties
        $objPHPExcel->getProperties()->setCreator(trim($this->session->userdata('USERNAME')));
        $objPHPExcel->getProperties()->setLastModifiedBy(trim($this->session->userdata('USERNAME')));
        $objPHPExcel->getProperties()->setTitle("Template upload master employee");
        $objPHPExcel->getProperties()->setSubject("Template upload master employee");
        $objPHPExcel->getProperties()->setDescription("Template upload master employee");

        //Header
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Template Upload Master Data Employee');
        $objPHPExcel->getActiveSheet()->getStyle("A1")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->mergeCells('A1:I1');
        $objPHPExcel->getActiveSheet()->setCellValue('A2', 'Dept');
        $objPHPExcel->getActiveSheet()->setCellValue('B2', ': ' . $dept_desc);

        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true)->setSize(13);
        $objPHPExcel->getActiveSheet()->getStyle('B2')->getFont()->setBold(true)->setSize(13);

        //Header Table
        $objPHPExcel->getActiveSheet()->setCellValue('A4', 'No');
        $objPHPExcel->getActiveSheet()->setCellValue('B4', 'NPK');
        $objPHPExcel->getActiveSheet()->setCellValue('C4', 'Nama');
        $objPHPExcel->getActiveSheet()->setCellValue('D4', 'Kode Dept');
        $objPHPExcel->getActiveSheet()->setCellValue('E4', 'Kode Group');
        $objPHPExcel->getActiveSheet()->setCellValue('F4', 'Kode Section');
        $objPHPExcel->getActiveSheet()->setCellValue('G4', 'Kode Sub Section');
        $objPHPExcel->getActiveSheet()->setCellValue('H4', "Position " . PHP_EOL . "(Operator / JP / Leader / SPV)");
        $objPHPExcel->getActiveSheet()->setCellValue('I4', "Tunjangan Jabatan " . PHP_EOL . "(Sample : 210000) ");
        $objPHPExcel->getActiveSheet()->setCellValue('J4', "Tunjangan Transport " . PHP_EOL . "(Sample :20000)");
        $objPHPExcel->getActiveSheet()->setCellValue('K4', "Salary " . PHP_EOL . "(Sample : 3500000)");

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getStyle('H')->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle('I')->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle('J')->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle('K')->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);


        $styleArray = array(
            'borders' => array(
                'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                ),
            ),
        );


        for ($index = "A"; $index < "L"; $index++) {
            $objPHPExcel->getActiveSheet()->getStyle($index . "4")->applyFromArray($styleArray);
            $objPHPExcel->getActiveSheet()->getStyle($index . "4")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle($index . "4")->getFont()->setBold(true);
        }

        //data
        $row_no = 5;
        $no = 1;
        foreach ($list_kry as $value) {

            $objPHPExcel->getActiveSheet()->setCellValue("A$row_no", $no);
            $objPHPExcel->getActiveSheet()->setCellValue("B$row_no", "$value->NPK");
            $objPHPExcel->getActiveSheet()->setCellValue("C$row_no", $value->NAMA);
            $objPHPExcel->getActiveSheet()->setCellValue("D$row_no", $value->KD_DEPT);
            $objPHPExcel->getActiveSheet()->setCellValue("E$row_no", $value->KD_GROUP);
            $objPHPExcel->getActiveSheet()->setCellValue("F$row_no", $value->KD_SECTION);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row_no", $value->KD_SUB_SECTION);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row_no", $value->position);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row_no", $value->tunj_jabatan);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row_no", $value->tunj_transport);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row_no", $value->salary);




            for ($index = "A"; $index < "L"; $index++) {
                $objPHPExcel->getActiveSheet()->getStyle($index . $row_no)->applyFromArray($styleArray);
                if ($index <> "C") {
                    $objPHPExcel->getActiveSheet()->getStyle($index . $row_no)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                }
            }

            $row_no++;
            $no++;
        }


        $filename = "Template Upload.xls";
        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . trim($filename) . '"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->setIncludeCharts(TRUE);
        $objWriter->save('php://output');
    }

    public function upload_template_employee() {
        $aortadb = $this->load->database("aorta", TRUE);
        $this->load->library(array('PHPExcel', 'PHPExcel/IOFactory'));

        $aortadb->query("truncate table TW_UPLOAD_TM_KRY");
        $pic = $this->session->userdata('NPK');
        $date_now = date("Ymd");
        $time_now = date("His");
        if ($this->input->post("upload_button") == 1) {
            $fileName = $_FILES['import_salary']['name'];
            if (empty($fileName)) {
                echo '<script>alert("Anda Belum Memilih File Untuk diupload");</script>';
                redirect('delivery/export_c/upload', 'refresh');
            }

            //file untuk submit file excel
            $config['upload_path'] = './assets/files/aorta';
            $config['file_name'] = $fileName;
            $config['allowed_types'] = '*';
            $config['max_size'] = 10000;
            $config['encrypt_name'] = FALSE;
            $config['remove_spaces'] = TRUE;
            //code for upload with ci
            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('import_salary')) {
                echo $this->upload->display_errors();
                exit();
            }

            $media = $this->upload->data('import_salary');
            $inputFileName = './assets/files/aorta/' . $media['file_name'];

            //  Read  Excel workbook
            try {
                $inputFileType = IOFactory::identify($inputFileName);
                $objReader = IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($inputFileName);
            } catch (Exception $e) {
                die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' . $e->getMessage());
            }

            //  Get worksheet dimensions
            $sheet = $objPHPExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();

            $x = 0;
            $y = 0;
            $rowHeader = $sheet->rangeToArray('A2:' . $highestColumn . '2', NULL, TRUE, FALSE);
            if ($rowHeader[0][0] == "Dept") {
                for ($row = 5; $row <= $highestRow; $row++) {

                    $error_msg = "";
                    $error_stat = 0;
                    $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);
                    $npk = $rowData[0][1];
                    if (strlen($npk) == 3) {
                        $npk = "0" . $npk;
                    }
                    $nama = $rowData[0][2];
                    $nama = str_replace("'", "", $nama);
                    $kode_dept = $rowData[0][3];
                    $kode_group = $rowData[0][4];
                    $kode_section = $rowData[0][5];
                    $kode_sub_section = $rowData[0][6];
                    $position = strtolower($rowData[0][7]);
                    $tunj_jabatan = $rowData[0][8];
                    $tunj_transport = $rowData[0][9];
                    $salary = $rowData[0][10];


                    //change to zero
                    if ($tunj_jabatan == '')
                        $tunj_jabatan = 0;
                    if ($tunj_transport == '')
                        $tunj_transport = 0;
                    if ($salary == '')
                        $salary = 0;

                    if ($tunj_jabatan == 0 && $tunj_transport == 0 && $salary == 0) {
                        continue;
                    }
                    $npk = trim(str_pad($npk, 4, '0', STR_PAD_LEFT));


                    //check database
                    $sql = "select * from TM_KRY where npk = '$npk' and kd_dept = '$kode_dept'";
                    $cek_data = $aortadb->query($sql)->num_rows();
                    if ($cek_data > 0) {
                        //check posisition
                        $position = trim($position);
                        if (($position == "operator") or ($position == "jp") or ($position == "leader") or ($position == "spv") or ($position == "admin") or ($position == "")) {
                            
                        } else {
                            $error_stat = 1;
                            $error_msg .= " Pastikan isi posisi dengan (Admin/Operator/JP/Leader/Spv) || ";
                        }

                        //check tunjangan jabatan
                        if (!is_numeric($tunj_jabatan)) {
                            $error_stat = 1;
                            $error_msg .= " Pastikan format amount tunjangan jabatan adalah angka || ";
                        }

                        //check tunjangan transport
                        if (!is_numeric($tunj_transport)) {
                            $error_msg .= " Pastikan format amount tunjangan transport adalah angka || ";
                        }

                        //check tunjangan salary
                        if (!is_numeric($salary)) {
                            $error_stat = 1;
                            $error_msg .= " Pastikan format amount salary adalah angka || ";
                        }
                    } else {
                        $error_stat = 1;
                        $error_msg .= " Format template Anda tidak sesuai, pastikan hanya edit kolom yang berwarna abu-abu";
                    }

                    //insert to db
                    $sql = "INSERT INTO TW_UPLOAD_TM_KRY (NPK, NAMA, KD_GROUP, KD_DEPT, KD_SECTION, KD_SUB_SECTION, "
                            . "OPER_EDIT, TGL_EDIT, JAM_EDIT, salary, position, tunj_jabatan, tunj_transport , stat_error , error_msg) "
                            . "VALUES ('$npk', '$nama', '$kode_group', '$kode_dept', '$kode_section', '$kode_sub_section',"
                            . " '$pic', '$date_now', '$time_now', '$salary', '$position', '$tunj_jabatan', '$tunj_transport' , '$error_stat' , '$error_msg');";
                    $aortadb->query($sql);
                }
                redirect("aorta/master_data_c/employee_confirmation", "refresh");
            } else {
                echo "<script>alert('Maaf data yang Anda masukan salah, Pastikan Anda menggunakan Template dari sistem')</script>";
            }
        }
    }

    public function employee_confirmation() {
        $this->role_module_m->authorization('151');
        $this->log_m->add_log(9, NULL);
        $aortadb = $this->load->database("aorta", TRUE);
        $pic = $this->session->userdata('NPK');



        $date_now = date("Ymd");
        $time_now = date("His");

        $data['content'] = 'aorta/confirm_employee_list_v';
        $data['title'] = 'Confirm Master Data Employee';

        $employee_list = $aortadb->query("select * from  TW_UPLOAD_TM_KRY")->result();
        if (count($employee_list) == 0) {
            redirect("aorta/master_data_c/employee", "refresh");
        }


        //cek upload ok
        $cek_upload_total = $aortadb->query("select * from TW_UPLOAD_TM_KRY")->num_rows();
        $cek_upload_ok = $aortadb->query("select * from TW_UPLOAD_TM_KRY where stat_error = '0'")->num_rows();


        if ($this->input->post("btn-confirm") != '') {

            $range = 0;
            foreach ($employee_list as $value_list) {

                $npk = trim($value_list->NPK);
                $nama = trim($value_list->NAMA);
                $kode_dept = trim($value_list->KD_DEPT);
                $kode_group = trim($value_list->KD_GROUP);
                $kode_section = trim($value_list->KD_SECTION);
                $kode_sub_section = trim($value_list->KD_SUB_SECTION);
                $position = trim($value_list->position);
                $tunj_jabatan = trim($value_list->tunj_jabatan);
                $tunj_transport = trim($value_list->tunj_transport);
                $salary = trim($value_list->salary);


                $aortadb->query("UPDATE TM_KRY SET position = '$position' , salary='$salary', tunj_jabatan='$tunj_jabatan', tunj_transport='$tunj_transport' , TGL_EDIT = '$date_now' , JAM_EDIT = '$time_now' , OPER_EDIT = '$pic'  WHERE  NPK='$npk';");
                $range++;
            }
            $aortadb->query("truncate table TW_UPLOAD_TM_KRY");

            redirect("aorta/master_data_c/employee", "refresh");
            $this->load->view('delivery/print_packing_barcode', $data);
        }



        $data['employee_list'] = $employee_list;
        $data['cek_upload_total'] = $cek_upload_total;
        $data['cek_upload_ok'] = $cek_upload_ok;

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(136);
        $data['news'] = $this->news_m->get_news();

        $this->load->view($this->layout, $data);
    }
    
    //============= MANAGE DEPARTMENT ========================================//
    function manage_dept($msg = NULL){
        $this->role_module_m->authorization('3');

        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times</button><strong>Creating success </strong> The data is successfully created </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times</button><strong>Updating success </strong> The data is successfully updated </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times</button><strong>Deleted success </strong> The data is successfully deleted </div >";
        } elseif ($msg == 4) {
            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times</button><strong>Choosing failed </strong> You must select at least one data</div >";
        } elseif ($msg == 12) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times</button><strong>Executing error !</strong> Something error with parameter </div >";
        }

        $data['msg'] = $msg;
        $data['data'] = $this->master_data_m->get_dept();
        $data['content'] = 'aorta/organization/manage_dept_v';
        $data['title'] = 'Manage Department';
        $data['news'] = $this->news_m->get_news();
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(248);
        
        $this->load->view($this->layout, $data);
    }
    
    function select_dept($id) {
        $this->role_module_m->authorization('3');
        $data['content'] = 'aorta/organization/view_dept_v';
        $data['title'] = 'Create Dept';
        $data['data'] = $this->master_data_m->get_dept_by_id($id);
        $data['news'] = $this->news_m->get_news();
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(248);
        
        $this->load->view($this->layout, $data);
    }
    
    function create_dept($msg = null) {
        if ($msg == 1) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times</button><strong>Creating failed. </strong> The data is already exist. </div >";
        } else if ($msg == 2) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times</button><strong>Creating failed. </strong> Please check your data. </div >";
        } else {
            $msg = '';
        }
        
        $this->role_module_m->authorization('3');
        $data['content'] = 'aorta/organization/create_dept_v';
        $data['title'] = 'Create Dept';
        $data['data_groupdept'] = $this->master_data_m->get_group();
        $data['data_manager'] = $this->master_data_m->get_manager();
        $data['data_category'] = $this->master_data_m->get_ot_category();
        $data['news'] = $this->news_m->get_news();
        $data['msg'] = $msg;
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(248);
        
        $this->load->view($this->layout, $data);
    }
    
    function edit_dept($id) {
        $this->role_module_m->authorization('3');
        $data['content'] = 'aorta/organization/edit_dept_v';
        $data['title'] = 'Create Dept';
        $data['data'] = $this->master_data_m->get_dept_by_id($id);
        $data['data_groupdept'] = $this->master_data_m->get_group();
        $data['data_manager'] = $this->master_data_m->get_manager();
        $data['data_category'] = $this->master_data_m->get_ot_category();
        $data['news'] = $this->news_m->get_news();
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(248);
        
        $this->load->view($this->layout, $data);
    }
    
    function save_dept() {
        $this->form_validation->set_rules('DEPT', 'Dept Code', 'required|min_length[2]|max_length[4]|trim');
        $this->form_validation->set_rules('DEPT_DESC', 'Dept Desc', 'required');
        
        $dept = strtoupper(trim($this->input->post('DEPT')));
        $check_id = $this->master_data_m->get_dept_by_id($dept);
        $session = $this->session->all_userdata();
        
        if(count($check_id) > 0){
            redirect("aorta/master_data_c/create_dept/1", "REFRESH");
        }

        if ($this->form_validation->run() == FALSE) {
            $this->create_dept('2');
        } else {
            $category = $this->input->post("CATEGORY");
            $list_category = '';
            if($category != NULL || $category != '' || $category != 0){ 
                $no = 1;
                for($i = 0; $i < count($category); $i++){
                    if($no == count($category)){
                        $list_category .= trim($category[$i]);
                    } else {
                        $list_category .= trim($category[$i]) . '#';
                    }
                    $no++;
                }
            } else {
                $list_category = '-'; 
            }
            
            $data = array(
                'KODE' => strtoupper($this->input->post('DEPT')),
                'NAMA_DEP' => $this->input->post('DEPT_DESC'),
                'KADEP_NPK' => $this->input->post('MANAGER'),
                'KD_GROUP' => $this->input->post('GROUP_DEPT'),
                'KD_DIV' => $this->input->post('DIVISION'),
                'MIN_BACKDATE' => '-99',
                'OT_CATEGORY' => $list_category,    
                'OPER_ENTRY' => $session['USERNAME'],
                'TGL_ENTRY' => date("Ymd"),
                'JAM_ENTRY' => date("His")
            );
            $this->master_data_m->save_dept($data);
            redirect($this->back_to_manage_dept . $msg = 1);
        }
    }
    
    function update_dept() {
        $dept = $this->input->post('DEPT');

        $this->form_validation->set_rules('DEPT', 'Department Initial', 'required|min_length[2]|max_length[4]|trim');
        $this->form_validation->set_rules('DEPT_DESC', 'Department Desc', 'required');
        $session = $this->session->all_userdata();
        
        if ($this->form_validation->run() == FALSE) {
            $this->edit_dept($dept);
        } else {
            $category = $this->input->post("CATEGORY");
            $list_category = '';
            if($category != NULL || $category != '' || $category != 0){ 
                $no = 1;
                for($i = 0; $i < count($category); $i++){
                    if($no == count($category)){
                        $list_category .= trim($category[$i]);
                    } else {
                        $list_category .= trim($category[$i]) . '#';
                    }
                    $no++;
                }
            } else {
                $list_category = '-'; 
            }
            
            $data = array(
                'NAMA_DEP' => $this->input->post('DEPT_DESC'),
                'KADEP_NPK' => $this->input->post('MANAGER'),
                'KD_GROUP' => $this->input->post('GROUP_DEPT'),
                'KD_DIV' => $this->input->post('DIVISION'),
                'MIN_BACKDATE' => $this->input->post('MIN_BACKDATE'),
                'OT_CATEGORY' => $list_category,    
                'OPER_EDIT' => $session['USERNAME'],
                'TGL_EDIT' => date("Ymd"),
                'JAM_EDIT' => date("His")
            );
            $this->master_data_m->update_dept($data, $dept);
            redirect($this->back_to_manage_dept . $msg);
        }
    }
    
    function delete_dept($dept) {
        $this->role_module_m->authorization('3');
        $this->master_data_m->delete_dept($dept);
        redirect($this->back_to_manage_dept . $msg = 3);
    }
    //========================================================================//
    
    //============= MANAGE SECTION ========================================//
    function manage_section($msg = NULL){
        $this->role_module_m->authorization('3');

        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times</button><strong>Creating success </strong> The data is successfully created </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times</button><strong>Updating success </strong> The data is successfully updated </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times</button><strong>Deleted success </strong> The data is successfully deleted </div >";
        } elseif ($msg == 4) {
            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times</button><strong>Choosing failed </strong> You must select at least one data</div >";
        } elseif ($msg == 12) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times</button><strong>Executing error !</strong> Something error with parameter </div >";
        }

        $data['msg'] = $msg;
        $data['data'] = $this->master_data_m->get_sect();
        $data['content'] = 'aorta/organization/manage_section_v';
        $data['title'] = 'Manage Section';
        $data['news'] = $this->news_m->get_news();
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(250);
        
        $this->load->view($this->layout, $data);
    }
    
    function select_section($id) {
        $this->role_module_m->authorization('3');
        $data['content'] = 'aorta/organization/view_section_v';
        $data['title'] = 'View Section';
        $data['data'] = $this->master_data_m->get_sect_by_id($id);
        $data['news'] = $this->news_m->get_news();
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(250);
        
        $this->load->view($this->layout, $data);
    }
    
    function create_section($msg = null) {
        if ($msg == 1) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times</button><strong>Creating failed. </strong> The data is already exist. </div >";
        } else if ($msg == 2) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times</button><strong>Creating failed. </strong> Please check your data. </div >";
        } else {
            $msg = '';
        }
        
        $this->role_module_m->authorization('3');
        $data['content'] = 'aorta/organization/create_section_v';
        $data['title'] = 'Create Section';
        $data['data_dept'] = $this->master_data_m->get_dept();
        $data['data_secthead'] = $this->master_data_m->get_all_user();
        $data['news'] = $this->news_m->get_news();
        $data['msg'] = $msg;
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(250);
        
        $this->load->view($this->layout, $data);
    }
    
    function edit_section($id) {
        $this->role_module_m->authorization('3');
        $data['content'] = 'aorta/organization/edit_section_v';
        $data['title'] = 'Edit Section';
        $data['data'] = $this->master_data_m->get_sect_by_id($id);
        $data['data_dept'] = $this->master_data_m->get_dept();
        $data['data_secthead'] = $this->master_data_m->get_all_user();
        $data['news'] = $this->news_m->get_news();
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(250);
        
        $this->load->view($this->layout, $data);
    }
    
    function save_section() {
        $this->form_validation->set_rules('SECTION', 'Section Code', 'required|min_length[2]|max_length[4]|trim');
        $this->form_validation->set_rules('SECTION_DESC', 'Section Desc', 'required');
        
        $sect = strtoupper(trim($this->input->post('SECTION')));
        $check_id = $this->master_data_m->get_sect_by_id($sect);
        $session = $this->session->all_userdata();
        
        if(count($check_id) > 0){
            redirect("aorta/master_data_c/create_section/1", "REFRESH");
        }

        if ($this->form_validation->run() == FALSE) {
            $this->create_section('2');
        } else {
            $data = array(
                'KODE' => strtoupper($this->input->post('SECTION')),
                'NAMA_SECTION' => $this->input->post('SECTION_DESC'),
                'KASIE_NPK' => $this->input->post('SECTHEAD'),
                'KODE_DEP' => $this->input->post('DEPT'),
                'OPER_ENTRY' => $session['USERNAME'],
                'TGL_ENTRY' => date("Ymd"),
                'JAM_ENTRY' => date("His")
            );
            $this->master_data_m->save_sect($data);
            redirect($this->back_to_manage_section . $msg = 1);
        }
    }
    
    function update_section() {
        $sect = $this->input->post('SECTION');

        $this->form_validation->set_rules('SECTION', 'Section Initial', 'required|min_length[2]|max_length[4]|trim');
        $this->form_validation->set_rules('SECTION_DESC', 'Section Desc', 'required');
        $session = $this->session->all_userdata();
        
        if ($this->form_validation->run() == FALSE) {
            $this->edit_section($sect);
        } else {            
            $data = array(
                'NAMA_SECTION' => $this->input->post('SECTION_DESC'),
                'KASIE_NPK' => $this->input->post('SECTHEAD'),
                'KODE_DEP' => $this->input->post('DEPT'),
                'OPER_EDIT' => $session['USERNAME'],
                'TGL_EDIT' => date("Ymd"),
                'JAM_EDIT' => date("His")
            );
            $this->master_data_m->update_sect($data, $sect);
            redirect($this->back_to_manage_section . $msg);
        }
    }
    
    function delete_section($sect) {
        $this->role_module_m->authorization('3');
        $this->master_data_m->delete_sect($sect);
        redirect($this->back_to_manage_section . $msg = 3);
    }
    //========================================================================//
    
    //============= MANAGE SUB SECTION =======================================//
    function manage_subsection($msg = NULL){
        $this->role_module_m->authorization('3');

        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times</button><strong>Creating success </strong> The data is successfully created </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times</button><strong>Updating success </strong> The data is successfully updated </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times</button><strong>Deleted success </strong> The data is successfully deleted </div >";
        } elseif ($msg == 4) {
            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times</button><strong>Choosing failed </strong> You must select at least one data</div >";
        } elseif ($msg == 12) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times</button><strong>Executing error !</strong> Something error with parameter </div >";
        }

        $data['msg'] = $msg;
        $data['data'] = $this->master_data_m->get_subsect();
        $data['content'] = 'aorta/organization/manage_subsection_v';
        $data['title'] = 'Manage Sub Section';
        $data['news'] = $this->news_m->get_news();
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(251);
        
        $this->load->view($this->layout, $data);
    }
    
    function select_subsection($id) {
        $this->role_module_m->authorization('3');
        $data['content'] = 'aorta/organization/view_subsection_v';
        $data['title'] = 'View Sub Section';
        $data['data'] = $this->master_data_m->get_subsect_by_id($id);
        $data['news'] = $this->news_m->get_news();
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(251);
        
        $this->load->view($this->layout, $data);
    }
    
    function create_subsection($msg = null) {
        if ($msg == 1) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times</button><strong>Creating failed. </strong> The data is already exist. </div >";
        } else if ($msg == 2) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times</button><strong>Creating failed. </strong> Please check your data. </div >";
        } else {
            $msg = '';
        }
        
        $this->role_module_m->authorization('3');
        $data['content'] = 'aorta/organization/create_subsection_v';
        $data['title'] = 'Create Sub Section';
        $data['data_sect'] = $this->master_data_m->get_sect();
        $data['data_subsecthead'] = $this->master_data_m->get_all_user();
        $data['news'] = $this->news_m->get_news();
        $data['msg'] = $msg;
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(251);
        
        $this->load->view($this->layout, $data);
    }
    
    function edit_subsection($id) {
        $this->role_module_m->authorization('3');
        $data['content'] = 'aorta/organization/edit_subsection_v';
        $data['title'] = 'Edit Sub Section';
        $data['data'] = $this->master_data_m->get_subsect_by_id($id);
        $data['data_sect'] = $this->master_data_m->get_sect();
        $data['data_subsecthead'] = $this->master_data_m->get_all_user();
        $data['news'] = $this->news_m->get_news();
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(251);
        
        $this->load->view($this->layout, $data);
    }
    
    function save_subsection() {
        $this->form_validation->set_rules('SUB_SECTION', 'Sub Section Code', 'required|min_length[2]|max_length[4]|trim');
        $this->form_validation->set_rules('SUB_SECTION_DESC', 'Sub Section Desc', 'required');
        
        $subsect = strtoupper(trim($this->input->post('SUB_SECTION')));
        $check_id = $this->master_data_m->get_subsect_by_id($subsect);
        $session = $this->session->all_userdata();
        
        if(count($check_id) > 0){
            redirect("aorta/master_data_c/create_subsection/1", "REFRESH");
        }

        if ($this->form_validation->run() == FALSE) {
            $this->create_subsection('2');
        } else {
            $data = array(
                'KODE' => strtoupper($this->input->post('SUB_SECTION')),
                'NAMA_SUBSECT' => $this->input->post('SUB_SECTION_DESC'),
                'KASUBS_NPK' => $this->input->post('SUB_SECTHEAD'),
                'KODE_SEC' => $this->input->post('SECTION'),
                'OPER_ENTRY' => $session['USERNAME'],
                'TGL_ENTRY' => date("Ymd"),
                'JAM_ENTRY' => date("His")
            );
            $this->master_data_m->save_subsect($data);
            redirect($this->back_to_manage_subsection . $msg = 1);
        }
    }
    
    function update_subsection() {
        $subsect = $this->input->post('SUB_SECTION');

        $this->form_validation->set_rules('SUB_SECTION', 'Sub Section Initial', 'required|min_length[2]|max_length[4]|trim');
        $this->form_validation->set_rules('SUB_SECTION_DESC', 'Sub Section Desc', 'required');
        $session = $this->session->all_userdata();
        
        if ($this->form_validation->run() == FALSE) {
            $this->edit_subsection($subsect);
        } else {            
            $data = array(
                'NAMA_SUBSECT' => $this->input->post('SUB_SECTION_DESC'),
                'KASUBS_NPK' => $this->input->post('SUB_SECTHEAD'),
                'KODE_SEC' => $this->input->post('SECTION'),
                'OPER_EDIT' => $session['USERNAME'],
                'TGL_EDIT' => date("Ymd"),
                'JAM_EDIT' => date("His")
            );
            $this->master_data_m->update_subsect($data, $subsect);
            redirect($this->back_to_manage_subsection . $msg);
        }
    }
    
    function delete_subsection($subsect) {
        $this->role_module_m->authorization('3');
        $this->master_data_m->delete_subsect($subsect);
        redirect($this->back_to_manage_subsection . $msg = 3);
    }
    //========================================================================//
    
    //============= MANAGE POLICY ============================================//
    function manage_policy($msg = NULL){
        $this->role_module_m->authorization('3');

        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times</button><strong>Creating success </strong> The data is successfully created </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times</button><strong>Updating success </strong> The data is successfully updated </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times</button><strong>Deleted success </strong> The data is successfully deleted </div >";
        } elseif ($msg == 4) {
            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times</button><strong>Choosing failed </strong> You must select at least one data</div >";
        } elseif ($msg == 12) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times</button><strong>Executing error !</strong> Something error with parameter </div >";
        }

        $data['msg'] = $msg;
        $data['data'] = $this->master_data_m->get_policy();
        $data['content'] = 'aorta/organization/manage_policy_v';
        $data['title'] = 'Manage Policy';
        $data['news'] = $this->news_m->get_news();
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(252);
        
        $this->load->view($this->layout, $data);
    }
    
    function select_policy($id) {
        $this->role_module_m->authorization('3');
        $data['content'] = 'aorta/organization/view_policy_v';
        $data['title'] = 'View Policy';
        $data['data'] = $this->master_data_m->get_policy_by_id($id);
        $data['news'] = $this->news_m->get_news();
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(252);
        
        $this->load->view($this->layout, $data);
    }
    
    function create_policy($msg = null) {
        if ($msg == 1) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times</button><strong>Creating failed. </strong> The data is already exist. </div >";
        } else if ($msg == 2) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times</button><strong>Creating failed. </strong> Please check your data. </div >";
        } else {
            $msg = '';
        }
        
        $this->role_module_m->authorization('3');
        $data['content'] = 'aorta/organization/create_policy_v';
        $data['title'] = 'Create Policy';
        $data['data_policy'] = $this->master_data_m->get_policy();
        $data['news'] = $this->news_m->get_news();
        $data['msg'] = $msg;
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(252);
        
        $this->load->view($this->layout, $data);
    }
    
    function edit_policy($id) {
        $this->role_module_m->authorization('3');
        $data['content'] = 'aorta/organization/edit_policy_v';
        $data['title'] = 'Edit Policy';
        $data['data'] = $this->master_data_m->get_policy_by_id($id);
        $data['news'] = $this->news_m->get_news();
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(252);
        
        $this->load->view($this->layout, $data);
    }
    
    function save_policy() {
        $this->form_validation->set_rules('POLICY_KEY', 'Policy Key', 'required|min_length[2]|trim');
        $this->form_validation->set_rules('POLICY_DESC', 'Policy Desc', 'required');
        $this->form_validation->set_rules('POLICY_VAL', 'Policy Val', 'required');
        
        $id = strtoupper(trim($this->input->post('POLICY_KEY')));
        $check_id = $this->master_data_m->get_policy_by_id($id);
        $session = $this->session->all_userdata();
        
        if(count($check_id) > 0){
            redirect("aorta/master_data_c/create_policy/1", "REFRESH");
        }

        if ($this->form_validation->run() == FALSE) {
            $this->create_policy('2');
        } else {
            $data = array(
                'POLICY_KEY' => strtoupper($this->input->post('POLICY_KEY')),
                'POLICY_DESC' => $this->input->post('POLICY_DESC'),
                'POLICY_VAL' => $this->input->post('POLICY_VAL')
            );
            $this->master_data_m->save_policy($data);
            redirect($this->back_to_manage_policy . $msg = 1);
        }
    }
    
    function update_policy() {
        $id = $this->input->post('POLICY_KEY');

        $this->form_validation->set_rules('POLICY_DESC', 'Policy Desc', 'required|min_length[2]|trim');
        $this->form_validation->set_rules('POLICY_VAL', 'Policy Val', 'required');
        $session = $this->session->all_userdata();
        
        if ($this->form_validation->run() == FALSE) {
            $this->edit_policy($id);
        } else {            
            $data = array(
                'POLICY_DESC' => $this->input->post('POLICY_DESC'),
                'POLICY_VAL' => $this->input->post('POLICY_VAL')
            );
            $this->master_data_m->update_policy($data, $id);
            redirect($this->back_to_manage_policy . $msg);
        }
    }
    
    function delete_policy($id) {
        $this->role_module_m->authorization('3');
        $this->master_data_m->delete_policy($id);
        redirect($this->back_to_manage_policy . $msg = 3);
    }
    //========================================================================//

    // add by toro balancing quota
   function get_section_by_dept(){
        $kode_dept = $this->input->post("KODE");

        $data_section = $this->master_data_m->get_sect_by_dept($kode_dept);
        $section = $this->master_data_m->get_top_sect_by_dept($kode_dept);

        $data = '';

        foreach ($data_section as $row) { 
            if (trim($section) == trim($row->KODE)){ 
                $data .="<option selected value='$row->KODE'>".$row->KODE."</option>";
            }else{ 
                $data .="<option value='$row->KODE'>".$row->KODE."</option>";
            }
        }
    
        $json_data = array('data' => $data);

        echo json_encode($json_data);

   }

}
