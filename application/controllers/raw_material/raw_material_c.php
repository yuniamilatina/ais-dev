<?php

class Raw_material_c extends CI_Controller
{
    /* -- define constructor -- */

    private $layout = '/template/head';
    private $back_to_manage = 'raw_material/raw_material_c/upload_act_rm/';
    private $layout_blank = '/template/head_blank';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('organization/dept_m');
        $this->load->model('basis/role_module_m');
        $this->load->model('portal/news_m');
        $this->load->model('raw_material/raw_material_m');
        $this->load->model('raw_material/good_movement_m');

        $this->load->helper(array('form', 'url', 'inflector'));
        // $this->load->library(array('PHPExcel', 'PHPExcel/IOFactory'));
    }

    public function index()
    {
        $this->role_module_m->authorization('16');
        $this->session->userdata('user_id');

        $data['content'] = 'raw_material/report_wh00_v';
        $data['title'] = 'WH00 Report';

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(119);
        $data['news'] = $this->news_m->get_news();

        $data['pure'] = true;

        $data['new_year'] = date('Y');
        $data['new_month'] = date('m');

        $month = array(
            1 => 'January',
            2 => 'February',
            3 => 'March',
            4 => 'April',
            5 => 'May',
            6 => 'June',
            7 => 'July',
            8 => 'August',
            9 => 'September',
            10 => 'October',
            11 => 'November',
            12 => 'December'
        );

        $period = date('Y') . date('m');
        $data['month'] = $month;

        $data['data_report_wh00'] = $this->raw_material_m->select_data_report_wh00_part_by_period($period);

        $this->load->view($this->layout, $data);
    }

    public function search_report_movement_by_periode()
    {

        $this->role_module_m->authorization('16');
        $this->session->userdata('user_id');

        $data['content'] = 'report/report_wh00_v';
        $data['title'] = 'WH00 Report';

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(119);
        $data['news'] = $this->news_m->get_news();

        $month = array(
            1 => 'January',
            2 => 'February',
            3 => 'March',
            4 => 'April',
            5 => 'May',
            6 => 'June',
            7 => 'July',
            8 => 'August',
            9 => 'September',
            10 => 'October',
            11 => 'November',
            12 => 'December'
        );

        $data['month'] = $month;

        $Month = $this->input->post('INT_ID_MONTH');
        $Year = $this->input->post('INT_ID_YEAR');

        $data['new_year'] = $Year;
        $data['new_month'] = $Month;

        $data['pure'] = false;

        if (strlen($Month) == 1) {
            $period = $Year . '0' . $Month;
        } else {
            $period = $Year . $Month;
        }

        $data['data_movement_part'] = $this->raw_material_m->select_data_movement_part_by_period($period);
        $data['data_sum_movement_part'] = $this->raw_material_m->select_data_sum_movement_part_by_period($period);

        $this->load->view($this->layout, $data);
    }

    public function upload_act_rm($msg = NULL)
    {
        $this->role_module_m->authorization('14');
        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Creating success </strong> The data is successfully created </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Updating success </strong> The data is successfully updated </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Deleted success </strong> The data is successfully deleted </div >";
        } elseif ($msg == 12) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>File not exist</strong> You have not selected a file diupload </div >";
        } elseif ($msg == 13) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Data was exist </strong> Data already been uploaded </div >";
        } elseif ($msg == 15) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong> Template salah </strong> Template Upload Work Order Anda Salah, Silahkan Coba Lagi Dengan Template Yang Benar </div >";
        } elseif ($msg == 16) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong> Data diexcel ada yang salah </strong> terdapat nilai bukan angka dikolom yang harusnya angka </div >";
        }

        $this->role_module_m->authorization('16');
        $this->session->userdata('user_id');

        $periode = $this->raw_material_m->get_temp_data_period();

        if ($periode === 0) {
            $date = 235629;
            $data['temp_data_wh00'] = $this->raw_material_m->get_temp_data_upload_result_raw_material_by_date($date);
            $data['date'] = $date;
            $data['exists'] = 0;
        } else {
            $date = intval(substr($periode['CHR_PERIODE'], -2));
            $data['temp_data_wh00'] = $this->raw_material_m->get_temp_data_upload_result_raw_material_by_date($date);
            $data['date'] = $date;
            $data['exists'] = 1;
        }

        $data['msg'] = $msg;
        $data['content'] = 'raw_material/upload_data_wh00_v';
        $data['title'] = 'Upload Data WH00';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(120);
        $data['news'] = $this->news_m->get_news();

        //$data['exists'] = $this->raw_material_m->check_existence_temp_data();

        $this->load->view($this->layout, $data);
    }

    public function upload_data_raw_material()
    {
        //select all data from temp

        $data_temp_wh00 = $this->raw_material_m->get_temp_data_upload_result_raw_material_by_date($this->input->post('INT_DATE'));
        $periode = $this->raw_material_m->get_temp_data_period();
        $date = substr($periode['CHR_PERIODE'], -2); //01-31

        foreach ($data_temp_wh00 as $isi) {
            $data = array(
                'CHR_PART_NUMBER' => $isi->CHR_PART_NUMBER,
                'CHR_PERIODE' => $isi->CHR_PERIODE_TT,
                'INT_GR_RM_' . $this->input->post('INT_DATE') => $isi->INT_GR_RM,
                'INT_MOVE_RM_' . $this->input->post('INT_DATE') => $isi->INT_MOVE_RM,
                'INT_SALDO_AKHIR_RM' => $isi->INT_SALDO_AKHIR_RM,
                'CHR_AREA' => '-'
            );

            //check per row temp apakah sama dengan per row tt
            $qty = $this->raw_material_m->check_existence_data_raw_material_by_period_and_part_no_and_date($isi->CHR_PERIODE_TT, $isi->CHR_PART_NUMBER, $this->input->post('INT_DATE'));
            $data_exist = $this->raw_material_m->check_existence_data_raw_material_by_period_and_part_no($isi->CHR_PERIODE_TT, $isi->CHR_PART_NUMBER);

            if ($data_exist === 0) {
                //insert to tt
                $status_insert = $this->raw_material_m->save_temp_data_to_data_raw_material($data);
                $fail_insert = 0;
                if ($status_insert === 0) {
                    $part_no_failed[$fail_insert] = $isi->CHR_PART_NUMBER;
                    $fail_insert++;
                }
            } else {
                //update qty by id
                $status_update = $this->raw_material_m->update_qty_data_raw_material_by_id_and_period_and_part_number_and_date($qty['INT_ID_WH00'], $isi->CHR_PERIODE_TT, $isi->CHR_PART_NUMBER, $isi->INT_GR_RM, $isi->INT_MOVE_RM, $isi->INT_SALDO_AKHIR_RM, $this->input->post('INT_DATE'));
                $fail_update = 0;
                if ($status_update === 0) {
                    $part_no_failed[$fail_update] = $isi->CHR_PART_NUMBER;
                    $fail_update++;
                }
            }
        }

        if ($fail_insert === 0) {
            //truncate data tw
            $this->raw_material_m->truncate_temp_data();

            redirect($this->back_to_manage . $msg = 1);
        } else {
            for ($f = 1; $f <= $fail_insert; $f++) {
                echo $part_no_failed[$f];
            }
        }
        if ($fail_update === 0) {
            //truncate data tw
            $this->raw_material_m->truncate_temp_data();

            redirect($this->back_to_manage . $msg = 2);
        } else {
            for ($f = 1; $f <= $fail_update; $f++) {
                echo $part_no_failed[$f];
            }
        }
    }

    //upload data to temp table
    public function insert_temp_data_raw_material()
    {
        $upload_date = date('Ymd');

        $fileName = $_FILES['import']['name'];

        if (empty($fileName)) {
            redirect($this->back_to_manage . $msg = 12);
        }

        $session = $this->session->all_userdata();

        //file untuk submit file excel
        $config['upload_path'] = './assets/files/';
        $config['file_name'] = $fileName;
        $config['allowed_types'] = 'xls|xlsx';
        $config['max_size'] = 10000;

        //code for upload with ci
        $this->load->library('upload');
        $this->upload->initialize($config);
        //            if (!$this->upload->do_upload('import'))
        //                $this->upload->display_errors();
        if ($a = $this->upload->do_upload('import'))
            $this->upload->display_errors();
        $media = $this->upload->data('import');
        $inputFileName = './assets/files/' . $media['file_name'];

        //Read  Excel workbook
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

        $rowHeader = $sheet->rangeToArray('A4:' . $highestColumn . '4', NULL, TRUE, FALSE);

        $h_no = $rowHeader[0][0];
        $h_doc_date = $rowHeader[0][1];
        $h_posting_date = $rowHeader[0][2];
        $h_code = $rowHeader[0][3];
        $h_stock_last_day = $rowHeader[0][4];
        $h_in_buy = $rowHeader[0][5];
        $h_in_otr = $rowHeader[0][6];
        $h_out = $rowHeader[0][7];
        $h_stock_today = $rowHeader[0][8];
        $h_ch = $rowHeader[0][9];
        $h_location = $rowHeader[0][10];

        $rowHeaderDate = $sheet->rangeToArray('A2:' . $highestColumn . '2', NULL, TRUE, FALSE);

        $h_date = explode('.', $rowHeaderDate[0][6]);

        if (trim($h_doc_date) == 'DOC DATE' && trim($h_code) == 'CODE' && trim($h_in_otr) == 'IN OTR (PROD)' && trim($h_out) == 'OUT' && trim($h_stock_today) == 'STOCK TODAY') {
            if ($this->raw_material_m->check_existence_temp_data() === 0) {
                if ($this->raw_material_m->check_existence_data_temp_raw_material_by_period($h_date[2] . $h_date[1] . $h_date[0]) === 0) {
                    for ($row = 5; $row <= $highestRow; $row++) {
                        $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);

                        $date = explode('.', $rowData[0][1]);
                        $part_number = $rowData[0][3];

                        if (($this->raw_material_m->check_existence_part_number_raw_material_by_part_number($part_number) === 0 && $this->raw_material_m->check_existence_data_temp_raw_material_by_period($h_date[2] . $h_date[1] . $h_date[0]) === 1) || ($this->raw_material_m->check_existence_part_number_raw_material_by_part_number($part_number) === 1 && $this->raw_material_m->check_existence_data_temp_raw_material_by_period($h_date[2] . $h_date[1] . $h_date[0]) === 0) || ($this->raw_material_m->check_existence_part_number_raw_material_by_part_number($part_number) === 0 && $this->raw_material_m->check_existence_data_temp_raw_material_by_period($h_date[2] . $h_date[1] . $h_date[0]) === 0)
                        ) {

                            $date_if = intval($date[0]);

                            if (is_string($rowData[0][6]) || is_string($rowData[0][7]) || is_string($rowData[0][8])) {
                                $this->raw_material_m->truncate_temp_data();

                                redirect($this->back_to_manage . $msg = 16);
                            }

                            $data = array(
                                'CHR_PART_NUMBER' => $rowData[0][3],
                                'CHR_PERIODE' => $date[2] . $date[1] . $date[0],
                                'INT_GR_RM_' . $date_if => $rowData[0][6],
                                'INT_MOVE_RM_' . $date_if => $rowData[0][7],
                                'INT_SALDO_AKHIR_RM' => $rowData[0][8],
                                'CHR_AREA' => '-',
                                'CHR_CREATED_BY' => 'Manual',
                                'CHR_CREATED_DATE' => $upload_date
                            );

                            $status_insert = $this->raw_material_m->save_temp_data_raw_material($data);

                            $fail_insert = 0;
                            if ($status_insert === 0) {
                                $part_no_failed[$fail_insert] = $rowData[0][3];
                                $fail_insert++;
                            }
                        } else {
                            echo 'data tidak kesave';
                        }
                    }

                    if ($fail_insert === 0) {
                    } else {
                        echo 'Part Number error :';
                        for ($f = 1; $f <= $fail_insert; $f++) {
                            echo $part_no_failed[$f];
                        }
                        exit();
                    }

                    //redirect($this->back_to_manage. $msg = 1);
                } else {
                    redirect($this->back_to_manage . $msg = 13);
                }
            } else {
                //truncate data tw
                $this->raw_material_m->truncate_temp_data();

                //insert
                for ($row = 2; $row <= $highestRow; $row++) {
                    $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);

                    $date = explode('.', $rowData[0][0]);
                    $part_number = $rowData[0][1];

                    if (($this->raw_material_m->check_existence_part_number_raw_material_by_part_number($part_number) === 0 && $this->raw_material_m->check_existence_data_temp_raw_material_by_period($h_date[2] . $h_date[1] . $h_date[0]) === 1) || ($this->raw_material_m->check_existence_part_number_raw_material_by_part_number($part_number) === 1 && $this->raw_material_m->check_existence_data_temp_raw_material_by_period($h_date[2] . $h_date[1] . $h_date[0]) === 0) || ($this->raw_material_m->check_existence_part_number_raw_material_by_part_number($part_number) === 0 && $this->raw_material_m->check_existence_data_temp_raw_material_by_period($h_date[2] . $h_date[1] . $h_date[0]) === 0)
                    ) {

                        $date_if = intval($date[0]);

                        $data = array(
                            'CHR_PART_NUMBER' => $rowData[0][1],
                            'CHR_PERIODE' => $date[2] . $date[1] . $date[0],
                            'INT_GR_RM_' . $date_if => $rowData[0][2],
                            'INT_MOVE_RM_' . $date_if => $rowData[0][3],
                            'INT_SALDO_AKHIR_RM' => $rowData[0][4],
                            'CHR_AREA' => '-',
                            'CHR_CREATED_BY' => 'Manual',
                            'CHR_CREATED_DATE' => $upload_date
                        );

                        $this->raw_material_m->save_temp_data_raw_material($data);
                    } else {
                        echo 'data tidak kesave';
                    }
                }
                redirect($this->back_to_manage . $msg = 1);
            }
        } else {
            echo '<script>alert("Template Upload Work Order Anda Salah, Silahkan Coba Lagi Dengan Template Yang Benar");</script>';
            //$this->db->trans_rollback();
            redirect($this->back_to_manage . $msg = 15);
        }
    }

    public function download()
    { //fungsi download
        $this->load->helper('download');

        $name = 'template_row_material.xlsx';
        $data = file_get_contents("assets/template/$name"); // filenya

        force_download($name, $data);
        redirect(current_url(), "refresh");
    }

    public function upload_wo()
    {
        $data['title'] = 'Master Data WO Customer';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(118);
        $data['news'] = $this->news_m->get_news();
        $data['content'] = 'inventory/upload_data_wo_v';
        $data['month'] = $this->raw_material_m->get_month();

        // if ($this->input->post("filter") == 1) {
        //     $mon = $this->input->post("CHR_MONTH");
        //     $ver = $this->input->post("CHR_VER");
        // } else{
        //     $mon = '';
        //     $ver = '';
        // }

        // if(($mon == '')&&($ver == '')){
        //     $data['data_wo'] = 'NULL';
        // } else{
        // $data['data_wo'] = $this->raw_material_m->get_data_wo($mon,$ver);
        // }
        // $data['data_wo'] = $this->raw_material_m->get_data_wo();
        $this->load->view($this->layout, $data);
    }

    function refresh_table()
    {
        $CHR_MONTH = $this->input->post("CHR_MONTH");
        $CHR_VERSION = $this->input->post("CHR_VERSION");
        $FILTER = $this->input->post("FILTER");

        $url_iframe = site_url("raw_material/raw_material_c/refresh_table_page/$CHR_MONTH/$CHR_VERSION/$FILTER");

        $data = array(
            'url_iframe' => $url_iframe
        );
        //====== Either you can print value or you can send value to database
        echo json_encode($data);
    }

    function refresh_table_page($CHR_MONTH = null, $CHR_VERSION = null, $FILTER = null, $msg = null)
    {
        $this->role_module_m->authorization('3');
        $user_session = $this->session->all_userdata();

        $data['CHR_MONTH'] = $CHR_MONTH;
        $data['CHR_VERSION'] = $CHR_VERSION;
        $data['FILTER'] = $FILTER;

        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Creating success </strong> The data is successfully created </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Updating success </strong> The data is successfully updated </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Deleted success </strong> The data is successfully deleted </div >";
        } elseif ($msg == 4) {
            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button>Anda belum memilih file untuk diupload</div >";
        } elseif ($msg == 6) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Upload data success </strong> The data is successfully uploaded </div >";
        }
        $data['msg'] = $msg;

        // $get_data_area = $this->spare_parts_m->get_data_area();
        // $data['all_area'] = $get_data_area;
        $data['title'] = 'Manage Data WO Customer';
        $data['news'] = $this->news_m->get_news();
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(118);

        if (($CHR_MONTH == 'ALL') && ($CHR_VERSION == '')) {
            $data['data_wo'] = $this->raw_material_m->get_data_all_wo($FILTER);
            $data['content'] = 'inventory/refresh_data_wo_v';
            $this->load->view($this->layout_blank, $data);
        } else {
            $data['data_wo'] = $this->raw_material_m->get_data_all_wo_per_month($CHR_MONTH, $CHR_VERSION, $FILTER);
            $pic = $this->session->userdata('NPK');
            $data['content'] = 'inventory/refresh_data_wo_v';

            $this->load->view($this->layout_blank, $data);
        }
    }

    public function generate_temp_wo()
    {
        $this->load->library('excel');
        $mon_now = date("m-Y");
        $month = date("Ym");
        $list_part = $this->raw_material_m->get_all_part_cust($month);

        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

        // Set Properties
        $objPHPExcel->getProperties()->setCreator(trim($this->session->userdata('USERNAME')));
        $objPHPExcel->getProperties()->setLastModifiedBy(trim($this->session->userdata('USERNAME')));
        $objPHPExcel->getProperties()->setTitle("UPLOAD WO");
        $objPHPExcel->getProperties()->setSubject("UPLOAD WO");
        $objPHPExcel->getProperties()->setDescription("UPLOAD WO");

        //Header
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'TEMPLATE UPLOAD WO CUSTOMER');
        $objPHPExcel->getActiveSheet()->setCellValue('A2', 'BULAN');
        $objPHPExcel->getActiveSheet()->setCellValue('A3', 'VERSI(isi 0 s/d 5)');
        $objPHPExcel->getActiveSheet()->setCellValue('A5', 'No');
        $objPHPExcel->getActiveSheet()->setCellValue('B5', 'Part No Cust');
        $objPHPExcel->getActiveSheet()->setCellValue('C5', 'Part No AII');
        $objPHPExcel->getActiveSheet()->setCellValue('D5', 'Part Name');
        $objPHPExcel->getActiveSheet()->setCellValue('E5', 'Back No');
        $objPHPExcel->getActiveSheet()->setCellValue('F5', 'OEM/GNP/AM');
        $objPHPExcel->getActiveSheet()->setCellValue('G5', 'Cust Code');
        $objPHPExcel->getActiveSheet()->setCellValue('H5', 'Cust Name');
        $objPHPExcel->getActiveSheet()->setCellValue('I5', '1');
        $objPHPExcel->getActiveSheet()->setCellValue('J5', '2');
        $objPHPExcel->getActiveSheet()->setCellValue('K5', '3');
        $objPHPExcel->getActiveSheet()->setCellValue('L5', '4');
        $objPHPExcel->getActiveSheet()->setCellValue('M5', '5');
        $objPHPExcel->getActiveSheet()->setCellValue('N5', '6');
        $objPHPExcel->getActiveSheet()->setCellValue('O5', '7');
        $objPHPExcel->getActiveSheet()->setCellValue('P5', '8');
        $objPHPExcel->getActiveSheet()->setCellValue('Q5', '9');
        $objPHPExcel->getActiveSheet()->setCellValue('R5', '10');
        $objPHPExcel->getActiveSheet()->setCellValue('S5', '11');
        $objPHPExcel->getActiveSheet()->setCellValue('T5', '12');
        $objPHPExcel->getActiveSheet()->setCellValue('U5', '13');
        $objPHPExcel->getActiveSheet()->setCellValue('V5', '14');
        $objPHPExcel->getActiveSheet()->setCellValue('W5', '15');
        $objPHPExcel->getActiveSheet()->setCellValue('X5', '16');
        $objPHPExcel->getActiveSheet()->setCellValue('Y5', '17');
        $objPHPExcel->getActiveSheet()->setCellValue('Z5', '18');
        $objPHPExcel->getActiveSheet()->setCellValue('AA5', '19');
        $objPHPExcel->getActiveSheet()->setCellValue('AB5', '20');
        $objPHPExcel->getActiveSheet()->setCellValue('AC5', '21');
        $objPHPExcel->getActiveSheet()->setCellValue('AD5', '22');
        $objPHPExcel->getActiveSheet()->setCellValue('AE5', '23');
        $objPHPExcel->getActiveSheet()->setCellValue('AF5', '24');
        $objPHPExcel->getActiveSheet()->setCellValue('AG5', '25');
        $objPHPExcel->getActiveSheet()->setCellValue('AH5', '26');
        $objPHPExcel->getActiveSheet()->setCellValue('AI5', '27');
        $objPHPExcel->getActiveSheet()->setCellValue('AJ5', '28');
        $objPHPExcel->getActiveSheet()->setCellValue('AK5', '29');
        $objPHPExcel->getActiveSheet()->setCellValue('AL5', '30');
        $objPHPExcel->getActiveSheet()->setCellValue('AM5', '31');
        $objPHPExcel->getActiveSheet()->setCellValue('AN5', 'N');
        $objPHPExcel->getActiveSheet()->setCellValue('AO5', 'N+1');
        $objPHPExcel->getActiveSheet()->setCellValue('AP5', 'N+2');
        $objPHPExcel->getActiveSheet()->setCellValue('AQ5', 'N+3');
        $objPHPExcel->getActiveSheet()->setCellValue('AR5', 'N+4');
        $objPHPExcel->getActiveSheet()->setCellValue('AS5', 'N+5');
        $objPHPExcel->getActiveSheet()->setCellValue('AT5', 'N+6');
        $objPHPExcel->getActiveSheet()->setCellValue('AU5', 'Cum. Plan');
        $objPHPExcel->getActiveSheet()->setCellValue('AV5', 'Cum. Act. Prod');
        $objPHPExcel->getActiveSheet()->setCellValue('AW5', 'Cum. Act. Order');
        $objPHPExcel->getActiveSheet()->setCellValue('AX5', 'Cum. Act. Del');

        $objPHPExcel->getActiveSheet()->getStyle('A1:C3')->getFont()->setBold(true)->setSize(11);
        $objPHPExcel->getActiveSheet()->getStyle('A5:AX5')->getFont()->setSize(11);

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(4);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(13);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(13);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('T')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('U')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('V')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('W')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('X')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('Y')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('Z')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AA')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AB')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AC')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AD')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AE')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AF')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AG')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AH')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AI')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AJ')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AK')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AL')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AM')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AN')->setWidth(6);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AO')->setWidth(6);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AP')->setWidth(6);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AQ')->setWidth(6);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AR')->setWidth(6);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AS')->setWidth(6);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AT')->setWidth(6);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AU')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AV')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AW')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AX')->setWidth(15);

        $objPHPExcel->getActiveSheet()->getStyle("A5:AX5")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $objPHPExcel->getActiveSheet()->setCellValue('C2', $mon_now);
        $objPHPExcel->getActiveSheet()->setCellValue('C3', '');

        $i = 6;
        $no = 1;
        foreach ($list_part as $data) {

            $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $no);
            $objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $data->CHR_CUS_PART_NO);
            $objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $data->CHR_PART_NO);
            $objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $data->CHR_PART_NAME);
            $objPHPExcel->getActiveSheet()->setCellValue('E' . $i, $data->CHR_BACK_NO);
            $objPHPExcel->getActiveSheet()->setCellValue('F' . $i, '');
            $objPHPExcel->getActiveSheet()->setCellValue('G' . $i, $data->CHR_CUS_NO);
            $objPHPExcel->getActiveSheet()->setCellValue('H' . $i, $data->CHR_CUST_NAME);
            $objPHPExcel->getActiveSheet()->setCellValue('I' . $i, '');
            $objPHPExcel->getActiveSheet()->setCellValue('J' . $i, '');
            $objPHPExcel->getActiveSheet()->setCellValue('K' . $i, '');
            $objPHPExcel->getActiveSheet()->setCellValue('L' . $i, '');
            $objPHPExcel->getActiveSheet()->setCellValue('M' . $i, '');
            $objPHPExcel->getActiveSheet()->setCellValue('N' . $i, '');
            $objPHPExcel->getActiveSheet()->setCellValue('O' . $i, '');
            $objPHPExcel->getActiveSheet()->setCellValue('P' . $i, '');
            $objPHPExcel->getActiveSheet()->setCellValue('Q' . $i, '');
            $objPHPExcel->getActiveSheet()->setCellValue('R' . $i, '');
            $objPHPExcel->getActiveSheet()->setCellValue('S' . $i, '');
            $objPHPExcel->getActiveSheet()->setCellValue('T' . $i, '');
            $objPHPExcel->getActiveSheet()->setCellValue('U' . $i, '');
            $objPHPExcel->getActiveSheet()->setCellValue('V' . $i, '');
            $objPHPExcel->getActiveSheet()->setCellValue('W' . $i, '');
            $objPHPExcel->getActiveSheet()->setCellValue('X' . $i, '');
            $objPHPExcel->getActiveSheet()->setCellValue('Y' . $i, '');
            $objPHPExcel->getActiveSheet()->setCellValue('Z' . $i, '');
            $objPHPExcel->getActiveSheet()->setCellValue('AA' . $i, '');
            $objPHPExcel->getActiveSheet()->setCellValue('AB' . $i, '');
            $objPHPExcel->getActiveSheet()->setCellValue('AC' . $i, '');
            $objPHPExcel->getActiveSheet()->setCellValue('AD' . $i, '');
            $objPHPExcel->getActiveSheet()->setCellValue('AE' . $i, '');
            $objPHPExcel->getActiveSheet()->setCellValue('AF' . $i, '');
            $objPHPExcel->getActiveSheet()->setCellValue('AG' . $i, '');
            $objPHPExcel->getActiveSheet()->setCellValue('AH' . $i, '');
            $objPHPExcel->getActiveSheet()->setCellValue('AI' . $i, '');
            $objPHPExcel->getActiveSheet()->setCellValue('AJ' . $i, '');
            $objPHPExcel->getActiveSheet()->setCellValue('AK' . $i, '');
            $objPHPExcel->getActiveSheet()->setCellValue('AL' . $i, '');
            $objPHPExcel->getActiveSheet()->setCellValue('AM' . $i, '');
            $objPHPExcel->getActiveSheet()->setCellValue('AN' . $i, $data->INT_N);
            $objPHPExcel->getActiveSheet()->setCellValue('AO' . $i, $data->INT_N1);
            $objPHPExcel->getActiveSheet()->setCellValue('AP' . $i, $data->INT_N2);
            $objPHPExcel->getActiveSheet()->setCellValue('AQ' . $i, $data->INT_N3);
            $objPHPExcel->getActiveSheet()->setCellValue('AR' . $i, $data->INT_N4);
            $objPHPExcel->getActiveSheet()->setCellValue('AS' . $i, $data->INT_N5);
            $objPHPExcel->getActiveSheet()->setCellValue('AT' . $i, $data->INT_N6);
            $objPHPExcel->getActiveSheet()->setCellValue('AU' . $i, $data->INT_TOTAL);
            $objPHPExcel->getActiveSheet()->setCellValue('AV' . $i, $data->AKTUAL_PROD);
            $objPHPExcel->getActiveSheet()->setCellValue('AW' . $i, $data->INT_TOTAL_QTY);
            $objPHPExcel->getActiveSheet()->setCellValue('AX' . $i, $data->INT_ACTUAL_DEL);

            $objPHPExcel->getActiveSheet()->getStyle("A" . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle("B" . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle("C" . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle("D" . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle("E" . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle("F" . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle("G" . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle("H" . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle("I" . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle("J" . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle("K" . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle("L" . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle("M" . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle("N" . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle("O" . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle("P" . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle("Q" . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle("R" . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle("S" . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle("T" . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle("U" . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle("V" . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle("W" . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle("X" . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle("Y" . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle("Z" . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle("AA" . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle("AB" . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle("AC" . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle("AD" . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle("AE" . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle("AF" . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle("AG" . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle("AH" . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle("AI" . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle("AJ" . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle("AK" . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle("AL" . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle("AM" . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle("AN" . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle("AO" . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle("AP" . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle("AQ" . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle("AR" . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle("AS" . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle("AT" . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle("AU" . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle("AV" . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle("AW" . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle("AX" . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

            $i++;
            $no++;
        }
        $x = $i - 1;

        $styleArray2 = array(
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => '99CCFF')
            )
        );

        $styleArray3 = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                ),
            ),
        );

        $objPHPExcel->getActiveSheet()->getStyle("A5:AX5")->applyFromArray($styleArray2);
        $objPHPExcel->getActiveSheet()->getStyle("A5:AX" . $x)->applyFromArray($styleArray3);

        $filename = "Template_Upload_WO.xls";
        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . trim($filename) . '"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        // $objWriter->setIncludeCharts(TRUE);
        $objWriter->save('php://output');
    }

    public function upload_template_data_wo()
    {
        $this->load->library(array('PHPExcel', 'PHPExcel/IOFactory'));
        
        $mrp_d = $this->load->database("mrp_d", TRUE);
        $mon_now = date("mY");
        $date_now = date("Ymd");
        $time_now = date("His");
        $session = $this->session->all_userdata();
        $npk = $session['NPK'];
        if ($this->input->post("upload_button") == 1) {
            $fileName = $_FILES['import_stock']['name'];
            if (empty($fileName)) {
                echo '<script>alert("Anda Belum Memilih File Untuk diupload");</script>';
                redirect('raw_material/Raw_material_c/upload_wo', 'refresh');
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
            $rowData = $sheet->rangeToArray('C3:C3', NULL, TRUE, FALSE);
            $version = $rowData[0][0];

            if (!empty($version)) {
                echo '<script>alert("Anda Belum Mengisi versi WO");</script>';
                redirect('raw_material/raw_material_c/upload_wo', 'refresh');
            }

            $x = 0;
            $y = 0;
            $rowHeader = $sheet->rangeToArray('A1:' . $highestColumn . '1', NULL, TRUE, FALSE);
            if ($rowHeader[0][0] == "TEMPLATE UPLOAD WO CUSTOMER") {
                for ($row = 6; $row <= $highestRow; $row++) {
                    $error_msg = "";
                    $error_stat = 0;
                    $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);

                    $part_no_cust = $rowData[0][1];
                    $part_no_aii = $rowData[0][2];
                    $part_name = $rowData[0][3];
                    $cust_code = $rowData[0][6];
                    $date1 = $rowData[0][8];
                    $date2 = $rowData[0][9];
                    $date3 = $rowData[0][10];
                    $date4 = $rowData[0][11];
                    $date5 = $rowData[0][12];
                    $date6 = $rowData[0][13];
                    $date7 = $rowData[0][14];
                    $date8 = $rowData[0][15];
                    $date9 = $rowData[0][16];
                    $date10 = $rowData[0][17];
                    $date11 = $rowData[0][18];
                    $date12 = $rowData[0][19];
                    $date13 = $rowData[0][20];
                    $date14 = $rowData[0][21];
                    $date15 = $rowData[0][22];
                    $date16 = $rowData[0][23];
                    $date17 = $rowData[0][24];
                    $date18 = $rowData[0][25];
                    $date19 = $rowData[0][26];
                    $date20 = $rowData[0][27];
                    $date21 = $rowData[0][28];
                    $date22 = $rowData[0][29];
                    $date23 = $rowData[0][30];
                    $date24 = $rowData[0][31];
                    $date25 = $rowData[0][32];
                    $date26 = $rowData[0][33];
                    $date27 = $rowData[0][34];
                    $date28 = $rowData[0][35];
                    $date29 = $rowData[0][36];
                    $date30 = $rowData[0][37];
                    $date31 = $rowData[0][38];
                    $total = $date1 + $date2 + $date3 + $date4 + $date5 + $date6 + $date7 + $date8 + $date9 + $date10 + $date11 +
                        $date12 + $date13 + $date14 + $date15 + $date16 + $date17 + $date18 + $date19 + $date20 + $date21 +
                        $date22 + $date23 + $date24 + $date25 + $date26 + $date27 + $date28 + $date29 + $date30 + $date31;
                    $n = $rowData[0][39];
                    $n1 = $rowData[0][41];
                    $n2 = $rowData[0][42];
                    $n3 = $rowData[0][43];
                    $n4 = $rowData[0][44];
                    $n5 = $rowData[0][45];
                    $n6 = $rowData[0][46];

                    // Check database
                    $cek_partno_backno = "SELECT * FROM TT_WO_CUST WHERE CHR_MONTH = '$mon_now' and CHR_VERSION='$version' and CHR_PARTNO_CUST='$part_no_cust' and CHR_PARTNO_AII='$part_no_aii' and CHR_CUST_CODE='$cust_code'";
                    // $cek_row = $this->db->query($cek_partno_backno)->num_rows();
                    $cek_row = $mrp_d->query($cek_partno_backno)->num_rows();
                    if ($cek_row < 1) {
                        $sql = "INSERT INTO TT_WO_CUST (CHR_MONTH, CHR_VERSION, CHR_PARTNO_CUST, CHR_PARTNO_AII, CHR_PART_NAME,CHR_CUST_CODE,
                                INT_HR01,INT_HR02,INT_HR03,INT_HR04,INT_HR05,INT_HR06, INT_HR07, INT_HR08, INT_HR09, INT_HR10, INT_HR11, INT_HR12, 
                                INT_HR13, INT_HR14, INT_HR15,INT_HR16,INT_HR17,INT_HR18,INT_HR19,INT_HR20,INT_HR21,INT_HR22,INT_HR23,INT_HR24,
                                INT_HR25,INT_HR26,INT_HR27,INT_HR28,INT_HR29,INT_HR30,INT_HR31,INT_N,INT_N1,INT_N2,INT_N3,INT_N4,INT_N5,
                                INT_N6,INT_TOTAL,CHR_CREATE_BY,CHR_CREATE_DATE,CHR_CREATE_TIME)VALUES('$mon_now','$version','$part_no_cust',
                                '$part_no_aii', '$part_name', '$cust_code','$date1','$date2','$date3','$date4','$date5','$date6','$date7',
                                '$date8','$date9','$date10','$date11','$date12','$date13','$date14','$date15','$date16','$date17','$date18',
                                '$date19','$date20','$date21','$date22','$date23','$date24','$date25','$date26','$date27','$date28','$date29',
                                '$date30','$date31','$total','$n1','$n2','$n3','$n4','$n5','$n6','$total', '$npk','$date_now', '$time_now')";
                        // $this->db->query($sql);
                        $mrp_d->query($sql);
                    }
                }
                redirect("raw_material/raw_material_c/upload_wo", "refresh");
            } else {
                echo "<script>alert('Maaf data yang Anda masukan salah, Pastikan Anda menggunakan Template dari sistem')</script>";
            }
        }
    }
}
