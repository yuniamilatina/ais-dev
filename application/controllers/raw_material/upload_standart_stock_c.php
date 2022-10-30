<?php

class Upload_standart_stock_c extends CI_Controller {
    /* -- define constructor -- */

    private $layout = '/template/head';

    public function __construct() {
        parent::__construct();
        $this->load->model('organization/dept_m');
        $this->load->model('raw_material/master_data_stock_m');
    }

    public function index() {
        $this->role_module_m->authorization('151');
        $this->log_m->add_log(9, NULL);
        $this->session->userdata('user_id');

        $data['title'] = 'Master Data Stock';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(161);
        $data['news'] = $this->news_m->get_news();
        $data['content'] = 'raw_material/master_data_stock_v';
        $ymd = date("Ymd");
        $date = date("Ym");
        $data_karyawan = array();
        $data_stock = array();

        $kode_dept = $this->session->userdata('DEPT');
        if ($this->session->userdata('ROLE') == 5 || $this->session->userdata('ROLE') == 14 || $this->session->userdata('ROLE') == 1 || $this->session->userdata('ROLE') == 35 || $this->session->userdata('ROLE') == 33 || $this->session->userdata('ROLE') == 61) { //Manager
            $data['id_prod'] = $this->session->userdata('DEPT');
            $row = $this->dept_m->get_data_dept($this->session->userdata('DEPT'))->row();
            $responsible = '01' . substr($row->CHR_DEPT, 2, 1);
            $kode_dept = $this->session->userdata('DEPT');
            $all_work_centers = $this->master_data_stock_m->get_section($kode_dept);
            $dept_name = $row->CHR_DEPT;
            $data_karyawan = $this->master_data_stock_m->get_data_karyawan($kode_dept);
            $data_stock = $this->master_data_stock_m->get_data_stock($kode_dept);
        }

        $data['kode_dept'] = $kode_dept;
        $data['data_karyawan'] = $data_karyawan;
        $data['data_stock'] = $data_stock;
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

    public function generate_template() {
        $this->load->library('excel');
        $this->load->helper('download');
        
        ob_clean();
        $file_name = 'Template Upload Data Stock.xlsx';
        $file = file_get_contents('./assets/files/Template Upload Data Stock.xlsx');
        
        force_download($file_name, $file);
    }

    public function upload_template_data_stock() {
        //$aortadb = $this->load->database("aorta", TRUE);
        $this->load->library(array('PHPExcel', 'PHPExcel/IOFactory'));

        $this->db->query("TRUNCATE TABLE TW_EXCEEDED_STOCK");
        $pic = $this->session->userdata('NPK');
        $date_now = date("Ymd");
        $time_now = date("His");
        if ($this->input->post("upload_button") == 1) {
            $fileName = $_FILES['import_stock']['name'];
            if (empty($fileName)) {
                echo '<script>alert("Anda Belum Memilih File Untuk diupload");</script>';
                redirect('raw_material/upload_standart_stock_c/index', 'refresh');
            }

            //file untuk submit file excel
            $config['upload_path'] = './assets/files';
            $config['file_name'] = $fileName;
            $config['allowed_types'] = '*';
            $config['max_size'] = 10000;
            $config['encrypt_name'] = FALSE;
            $config['remove_spaces'] = TRUE;
            //code for upload with ci
            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('import_stock')) {
                echo $this->upload->display_errors();
                exit();
            }

            $media = $this->upload->data('import_stock');
            $inputFileName = './assets/files/' . $media['file_name'];

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
            $rowHeader = $sheet->rangeToArray('A1:' . $highestColumn . '1', NULL, TRUE, FALSE);
            if ($rowHeader[0][0] == "Template Upload Data Stock") {
                for ($row = 5; $row <= $highestRow; $row++) {

                    $error_msg = "";
                    $error_stat = 0;
                    $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);
                    
                    $part_no = $rowData[0][1];
                    $back_no = $rowData[0][2];
                    $part_name = $rowData[0][3];
                    $sloc = $rowData[0][4];
                    $box = $rowData[0][5];
                    $qty = $rowData[0][6];
                    $uom = $rowData[0][7];
                    
                    if($box == ''){
                        $box = 0;
                    }
                    if($qty == ''){
                        $qty = 0;
                    }
                    
                    // Check database
                    $cek_partno_backno = "SELECT * FROM TM_KANBAN WHERE CHR_PART_NO = '$part_no'";
                    $cek_data = $this->db->query($cek_partno_backno)->result();
                    $cek_row = $this->db->query($cek_partno_backno)->num_rows();
                    
                    //print_r($cek_row);
                    //exit();
                    
                        if ($cek_row > 0) {
                            foreach($cek_data as $part){
                                $cek_partno = "SELECT * FROM TM_KANBAN WHERE CHR_PART_NO = '$part_no' AND CHR_BACK_NO = '$back_no'";
                                $cek_data_1 = $this->db->query($cek_partno)->result();
                                $cek_row_1 = $this->db->query($cek_partno)->num_rows();
                                if($cek_row_1 == 0){
                                  $error_stat = 1;
                                  $error_msg = " Back No $back_no tidak terdaftar pada Master Data Kanban, Back No = $part->CHR_BACK_NO ";
                                  if($back_no == '' || $back_no == NULL){
                                      $back_no = $part->CHR_BACK_NO;
                                  }
                                }else{
                                   foreach($cek_data_1 as $data_qty){
                                        $cek_qty = "SELECT * FROM TM_KANBAN WHERE CHR_PART_NO = '$part_no' AND CHR_BACK_NO = '$back_no' AND INT_QTY_PER_BOX = '$qty'";
                                        $cek_row_qty = $this->db->query($cek_qty)->num_rows();
                                        if($cek_row_qty == 0){
                                          $error_stat = 1;
                                          $error_msg = " Qty/box dari $part_no seharusnya adalah $data_qty->INT_QTY_PER_BOX  ";  
                                        }
                                   }
                                }
                            }
                        }else{
                            $error_stat = 1;
                            $error_msg = " Part No $part_no tidak terdaftar pada Master Data Kanban ";
                        }
                       
                        // Check BOX
                        if (!is_numeric($box)) {
                            $error_stat = 1;
                            $error_msg = " Pastikan tipe data Box adalah Angka (Number) ";
                        }

                        // Check QTY
                        if (!is_numeric($qty)) {
                            $error_stat = 1;
                            $error_msg = " Pastikan tipe data Qty adalah Angka (Number) ";
                        }
                        
                    //}

                    // Insert to DB TW
                    $sql = "INSERT INTO TW_EXCEEDED_STOCK "
                            . "(CHR_PART_NO, CHR_BACK_NO, CHR_PART_NAME, CHR_SLOC, INT_STD_STOCK, INT_QTY_PER_BOX, "
                            . "INT_QTY_TOTAL, INT_AMOUNT, CHR_UOM, CHR_CREATED_BY, CHR_CREATED_DATE, CHR_CREATED_TIME, INT_FLG_DEL, STATUS, MESSAGE)"
                            . "VALUES ('$part_no', '$back_no', '$part_name', '$sloc', '$box', '$qty', CASE '$uom' WHEN 'KG' THEN CAST('$box' AS INT)*CAST('$qty' AS INT)*1000"
                            . "WHEN 'PC' THEN CAST('$box' AS INT)*CAST('$qty' AS INT) ELSE CAST('$box' AS INT)*CAST('$qty' AS INT) END,"
                            . "'0', CASE '$uom' WHEN 'KG' THEN 'G' WHEN 'PC' THEN 'PC' ELSE 'G' END,'$pic', '$date_now', '$time_now', '0', '$error_stat', '$error_msg')";
                    $this->db->query($sql);
                }
                redirect("raw_material/upload_standart_stock_c/stock_confirmation", "refresh");
            } else {
                echo "<script>alert('Maaf data yang Anda masukan salah, Pastikan Anda menggunakan Template dari sistem')</script>";
            }
        }
    }

    public function stock_confirmation() {
        $this->role_module_m->authorization('151');
        $this->log_m->add_log(9, NULL);
        //$aortadb = $this->load->database("aorta", TRUE);
        $pic = $this->session->userdata('NPK');

        $date_now = date("Ymd");
        $time_now = date("His");

        $data['content'] = 'raw_material/confirm_stock_list_v';
        $data['title'] = 'Confirm Master Data Stock';

        $stock_list = $this->db->query("SELECT * FROM TW_EXCEEDED_STOCK ORDER BY STATUS DESC")->result();
        if (count($stock_list) == 0) {
            redirect("raw_material/upload_standart_stock_c/index", "refresh");
        }

        // Cek upload OK
        $cek_upload_total = $this->db->query("SELECT * FROM TW_EXCEEDED_STOCK")->num_rows();
        $cek_upload_ok = $this->db->query("SELECT * FROM TW_EXCEEDED_STOCK WHERE STATUS = '0'")->num_rows();


        if ($this->input->post("btn-confirm") != '') {

            $range = 0;
            foreach ($stock_list as $value_list) {

                $part_no = trim($value_list->CHR_PART_NO);
                $back_no = trim($value_list->CHR_BACK_NO);
                $part_name = trim($value_list->CHR_PART_NAME);
                $sloc = trim($value_list->CHR_SLOC);
                $box = trim($value_list->INT_STD_STOCK);
                $qty = trim($value_list->INT_QTY_PER_BOX);
                $qty_total = trim($value_list->INT_QTY_TOTAL);
                $uom = trim($value_list->CHR_UOM);
                
                $cek_exist = $this->db->query("SELECT * FROM TM_EXCEEDED_STOCK WHERE CHR_PART_NO='$part_no' AND CHR_SLOC = '$sloc';")->num_rows();
                if($cek_exist > 0){
                    $this->db->query("UPDATE TM_EXCEEDED_STOCK SET INT_STD_STOCK = '$box' , INT_QTY_PER_BOX = '$qty', INT_QTY_TOTAL = '$qty_total', CHR_UOM = '$uom', CHR_CREATED_BY = '$pic', CHR_CREATED_DATE = '$date_now' , CHR_CREATED_TIME = '$time_now' WHERE CHR_PART_NO='$part_no' AND CHR_SLOC = '$sloc';");
                    $range++;
                }
                else{
                    $insert = "INSERT INTO TM_EXCEEDED_STOCK (CHR_PART_NO, CHR_BACK_NO, CHR_PART_NAME, CHR_SLOC, INT_STD_STOCK, INT_QTY_PER_BOX, "
                            . "INT_QTY_TOTAL, CHR_UOM, INT_AMOUNT, CHR_CREATED_BY, CHR_CREATED_DATE, CHR_CREATED_TIME, INT_FLG_DEL)"
                            . "VALUES ('$part_no', '$back_no', '$part_name', '$sloc', '$box', '$qty', '$qty_total', '$uom', "
                            . "'0', '$pic', '$date_now', '$time_now', '0')";
                    $this->db->query($insert);
                    $range++;
                }
            }
            $this->db->query("TRUNCATE TABLE TW_EXCEEDED_STOCK");

            redirect("raw_material/upload_standart_stock_c/index", "refresh");
            //$this->load->view('delivery/print_packing_barcode', $data);
        }



        $data['stock_list'] = $stock_list;
        $data['cek_upload_total'] = $cek_upload_total;
        $data['cek_upload_ok'] = $cek_upload_ok;

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(136);
        $data['news'] = $this->news_m->get_news();

        $this->load->view($this->layout, $data);
    }

}
