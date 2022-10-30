<?php

class spare_parts_rack_c_2 extends CI_Controller {
    
    private $layout = '/template/head';
    private $back_to_manage = 'samanta/spare_parts_rack_c_2/index/';
    private $back_to_create_view = 'samanta/spare_parts_rack_c_2/create_rack/';
    private $layout_blank = '/template/head_blank';
   
    /* -- define constructor -- */
    public function __construct() {
        parent::__construct();
        $this->load->model('organization/dept_m');
        $this->load->model('samanta/spare_parts_rack_m');
        $this->load->model('samanta/spare_parts_m');
        $this->load->config('pdf_config');
        $this->load->library('fpdf/fpdf');
        define('FPDF_FONTPATH', $this->config->item('fonts_path'));
    }

    public function index($msg = NULL) {
        $this->role_module_m->authorization('3');

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
        } elseif ($msg == 7) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Tidak ada data yang diupload </strong>, periksa kembali template upload anda </div >";
        }
        $data['msg'] = $msg;

        $get_data_area = $this->spare_parts_m->get_data_area();

        $data['selected_area'] = $get_data_area;
        $data['all_area'] = $get_data_area;

        $data['data'] = $this->spare_parts_rack_m->get_all_rack();
        $data['title'] = 'Manage Rack';
        $data['news'] = $this->news_m->get_news();
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['content'] = 'samanta/manage_rack/manage_rack_v';
        $data['sidebar'] = $this->role_module_m->side_bar(74);       
        
        $this->load->view($this->layout, $data);
    }

    function refresh_table() {
        $INT_ID_OPT_WCENTER = $this->input->post("INT_ID_OPT_WCENTER");
        $FILTER = $this->input->post("FILTER");        

        $url_iframe = site_url("samanta/spare_parts_rack_c_2/refresh_table_page/$INT_ID_OPT_WCENTER/$FILTER");

        $data = array(
            'url_iframe' => $url_iframe
        );
        //====== Either you can print value or you can send value to database
        echo json_encode($data);
    }

    function delete_rack($id) {
        $this->spare_parts_rack_m->delete_rack($id);           
        redirect($this->back_to_manage . $msg = 3);
    }

    function refresh_table_page($INT_ID_OPT_WCENTER = null, $FILTER = null, $msg=null) {
        $this->role_module_m->authorization('3');
        $user_session = $this->session->all_userdata();

        $data['INT_ID_OPT_WCENTER'] = $INT_ID_OPT_WCENTER;
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
        
        $get_data_area = $this->spare_parts_m->get_data_area();
        $data['all_area'] = $get_data_area;
        $data['title'] = 'Manage Rack';
        $data['news'] = $this->news_m->get_news();
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(74);    

        if ($INT_ID_OPT_WCENTER == 'ALL') {
            $data['data_filter'] = $this->spare_parts_rack_m->get_rack_filter($FILTER);
            $data['content'] = 'samanta/manage_rack/refresh_manage_rack_v';
            $this->load->view($this->layout_blank, $data);
        } else {
            $data['data_filter'] = $this->spare_parts_rack_m->get_data_all_rack_per_area($INT_ID_OPT_WCENTER,$FILTER);
            $pic = $this->session->userdata('NPK');
            $data['content'] = 'samanta/manage_rack/refresh_manage_rack_v';
            
            $this->load->view($this->layout_blank, $data);
        }

        //$data['data_filter'] = $this->spare_parts_rack_m->get_rack_filter($FILTER);
        //$data['data'] = $this->spare_parts_m->get_rack_filter($INT_ID_OPT_WCENTER,$FILTER);
        // $pic = $this->session->userdata('NPK');
        // $data['content'] = 'samanta/manage_rack/refresh_manage_rack_v';
        //$this->load->view($this->layout_blank, $data);
    }

    function create_rack($msg = NULL) {
        if ($msg == 1) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Create Rack Number failed </strong> Rack No already exist on database </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-success'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Upload Rack Number success </strong> The data is successfully updated </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-success'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Update Rack Number success </strong> The data is successfully updated </div >";
        }
        
        $data['msg'] = $msg;
        $data['content'] = 'samanta/manage_rack/create_rack_v';
        $data['list_part'] = $this->spare_parts_rack_m->get_spare_part_no();
        $data['title'] = 'New Rack Spare Part';
        $data['news'] = $this->news_m->get_news();
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(74);

        $this->load->view($this->layout, $data);
    }

    function save_rack() {
        $datenow = date('Ymd');
        $timenow = date('His');
        $session = $this->session->all_userdata();
        $npk = $this->session->userdata('NPK');

        $part_no = trim($this->input->post('CHR_PART_NO'));
        $rack_no = trim(strtoupper($this->input->post('CHR_RACK_NO')));

        $get_detil_spare_parts_route = $this->spare_parts_rack_m->get_detil_spare_parts_route($part_no, $rack_no);
        if ($get_detil_spare_parts_route->num_rows() > 0) {
            redirect($this->back_to_create_view . $msg = 1);
        } else {
            $get_detil_back_no = $this->spare_parts_rack_m->get_detil_back_no($part_no)->row();
            $back_no = $get_detil_back_no->CHR_BACK_NO;
            $this->form_validation->set_rules('CHR_PART_NO', 'Spare Part Number', 'required');
            if ($this->form_validation->run() == FALSE) {
                $this->create_sp();
            } else {
                $data = array(
                    'CHR_PART_NO' => $part_no,
                    'CHR_BACK_NO' => $back_no,
                    'CHR_RACK_NO' => $rack_no,
                    'CHR_CREATED_BY' => $npk,
                    'CHR_CREATED_DATE' => $datenow,
                    'CHR_CREATED_TIME' => $timenow
                );
                $this->spare_parts_rack_m->save_sp($data);
                
                redirect($this->back_to_manage . $msg = 1);
            }
        }
    }

    function generate_template() {
        $this->load->library('excel');
        $this->load->helper('download');
        $date_now = date("Ymd");
        ob_clean();

        $file_name = 'Upload Rack [' . $date_now . '].xlsx';
        $file = file_get_contents('./assets/file/spare_parts/Upload Rack.xlsx');

        force_download($file_name, $file);
    }

    function upload_data_rack_sp() {
        $this->load->library(array('PHPExcel', 'PHPExcel/IOFactory'));
        $db_samanta = $this->load->database("samanta", TRUE);
        
        $npk = $this->session->userdata('NPK');
        $date_now = date("Ymd");
        $time_now = date("His");

        if ($this->input->post("upload_button") == 1) {
            $fileName = $_FILES['import_data']['name'];
            if (empty($fileName)) {                
                redirect($this->back_to_create_view);
            }
            //file untuk submit file excel
            $config['upload_path'] = './assets/file/spare_parts/';
            $config['file_name'] = $fileName;
            $config['allowed_types'] = 'xlsx';
            $config['max_size'] = 3000;
            $config['encrypt_name'] = FALSE;
            $config['remove_spaces'] = TRUE;

            //code for upload with ci
            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('import_data')) {
                echo $this->upload->display_errors();
                exit();
            }

            $media = $this->upload->data('import_data');
            $inputFileName = './assets/file/spare_parts/' . $media['file_name'];

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
            if ($rowHeader[0][0] == "UPLOAD RACK SPARE PARTS") {
                for ($row = 4; $row <= $highestRow; $row++) {

                    $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);

                    $part_no = $rowData[0][1];
                    $back_no = $rowData[0][2];
                    $rack_no = $rowData[0][3];
                    $part_no = trim($part_no);
                    $check_pn = $db_samanta->query("SELECT CHR_PART_NO FROM TM_SPARE_PARTS_ROUTING WHERE CHR_PART_NO = '$part_no' AND CHR_RACK_NO = '$rack_no'")->num_rows();
                    if ($check_pn == 0) {
                        $db_samanta->query("INSERT INTO TM_SPARE_PARTS_ROUTING (CHR_PART_NO, CHR_BACK_NO, CHR_RACK_NO, CHR_CREATED_BY, CHR_CREATED_DATE, CHR_CREATED_TIME) 
                            VALUES ('$part_no', '$back_no', '$rack_no', '$npk', '$date_now', '$time_now')");
                    }
                    else { }    
                }
                redirect($this->back_to_create_view . $msg = 2);
            } else {
                redirect($this->back_to_create_view);
            }
        }
    }

    // SPECIAL PART
    // function generate_lable_part_special() {
    //     $db_samanta = $this->load->database("samanta", TRUE);
    //     $checked = $this->input->post('options');
    //     if ($checked == null) {
    //         redirect($this->back_to_manage);
    //     }
        
    // }

    // GENERATE LABLE
    function generate_lable_part() {
        $db_samanta = $this->load->database("samanta", TRUE);
        $checked = $this->input->post('options');
        if ($checked == null) {
            redirect($this->back_to_manage);
        }

        if($this->input->post('gen_label')){
            $value = $this->input->post('gen_label');
            if ($value == 1) {
                $index = 1;
                $index_page = 1;
                $pdf = new FPDF('P', 'mm', 'A4');
                $pdf->SetMargins(3, 3, 3, 0);
                $pdf->SetAutoPageBreak(true, 0);
                $pdf->AliasNbPages();
                $pdf->AddPage();
                $pdf->SetFont('Courier', '', 11);

                for ($i = 0; $i < count($checked); $i++) {
                    $x = $checked[$i];
                    $data_part = $db_samanta->query("SELECT A.CHR_PART_NO, A.CHR_RACK_NO, B.CHR_SPARE_PART_NAME, B.CHR_SPECIFICATION, B.INT_QTY_MIN, B.INT_QTY_MAX
                                                        FROM TM_SPARE_PARTS_ROUTING A INNER JOIN TM_SPARE_PARTS B ON B.CHR_PART_NO = A.CHR_PART_NO
                                                        WHERE A.INT_ID = '$x'")->result();
                    if ($index % 3 == 1) {
                        //cell kotakan luar
                        $x_kanban1 = $pdf->GetX();
                        $y_kanban1 = $pdf->GetY();
                        $pdf->Cell(60, 25, "", 1, 1, 'L'); // ukuran kotak luar
                        $pdf->SetY($y_kanban1 + 1); // jarak kotak luar dan dalam
                        $pdf->SetX($x_kanban1 + 1);

                        //column 1
                        //cell kotakan dalam
                        $x_kanban2 = $pdf->GetX();
                        $y_kanban2 = $pdf->GetY();
                        $pdf->Cell(15, 15, "", 1, 1, 'L'); //ukuran kotak dalam
                        $pdf->SetY($y_kanban2);
                        $pdf->SetX($x_kanban2);

                        $pdf->SetX($x_kanban2 + 15);
                        $pdf->SetFont('Courier', 'B', 12);
                        $pdf->Cell(19, 5, $data_part[0]->CHR_RACK_NO, "B", 0, 'L');

                        $pdf->SetX($x_kanban2 + 34);
                        $pdf->SetFont('Courier', '', 9);
                        $pdf->Cell(25, 5, substr($data_part[0]->CHR_PART_NO,0,13), "B", 1, 'L');

                        $pdf->SetX($x_kanban2 + 15);
                        $pdf->SetFont('Courier', '', 9);
                        $pdf->Cell(44, 5, substr($data_part[0]->CHR_SPARE_PART_NAME,0,18), "B", 1, 'L');
                        
                        $pdf->SetX($x_kanban2 + 15);
                        $pdf->SetFont('Courier', '', 8);
                        $pdf->Cell(44, 5, substr($data_part[0]->CHR_SPECIFICATION,0,23), "B", 1, 'L');

                        $pdf->SetY($y_kanban2 + 17);
                        $pdf->SetX($x_kanban2);
                        $pdf->SetFont('Courier', '', 9);
                        $pdf->Cell(43, 4, "Min Qty:");

                        $pdf->SetY($y_kanban2 + 15);
                        $pdf->SetX($x_kanban2 - 1);
                        $pdf->SetFont('Arial', 'B', 16);
                        $pdf->Cell(30, 9, "           " . $data_part[0]->INT_QTY_MIN, 1, 'L');

                        $pdf->SetY($y_kanban2 + 17);
                        $pdf->SetX($x_kanban2 + 30);
                        $pdf->SetFont('Courier', '', 9);
                        $pdf->Cell(43, 4, "Max Qty:");

                        $pdf->SetY($y_kanban2 + 15);
                        $pdf->SetX($x_kanban2 + 29);
                        $pdf->SetFont('Arial', 'B', 16);
                        $pdf->Cell(30, 9, "           " . $data_part[0]->INT_QTY_MAX, 1, 'L');

                        $pdf->SetY($y_kanban2+1);
                        $pdf->SetX($x_kanban2);
                        $pdf->SetFont('Courier', '', 7);
                        $image1 = "./assets/qrcode_spare_parts/" . trim($data_part[0]->CHR_PART_NO) . ".png";
                        $pdf->Image($image1, $pdf->GetX() + 1, $pdf->GetY(), 13, 13);
                        
                        $pdf->SetX($x_kanban2 + 57);
                        //$pdf->SetY(2);                        
                    } elseif ($index % 3 == 2) {
                        //mulai untuk kolom baru
                        $x_kanban4 = $pdf->GetX();
                        $pdf->SetXY($x_kanban4, $y_kanban1);

                        $pdf->Cell(4, 8, "", "", 0, 'L');
                        $x_kanban1 = $pdf->GetX();
                        $y_kanban1 = $pdf->GetY();
                        $pdf->Cell(60, 25, "", 1, 1, 'L');
                        $pdf->SetY($y_kanban1 + 1);
                        $pdf->SetX($x_kanban1 + 1);

                        $x_kanban2 = $pdf->GetX();
                        $y_kanban2 = $pdf->GetY();
                        $pdf->Cell(15, 15, "", 1, 1, 'L');

                        //column 2
                        $pdf->SetY($y_kanban2);
                        $pdf->SetX($x_kanban2);
                    
                        $pdf->SetX($x_kanban2 + 15);
                        $pdf->SetFont('Courier', 'B', 12);
                        $pdf->Cell(19, 5, $data_part[0]->CHR_RACK_NO, "B", 0, 'L');

                        $pdf->SetX($x_kanban2 + 34);
                        $pdf->SetFont('Courier', '', 9);
                        $pdf->Cell(25, 5, substr($data_part[0]->CHR_PART_NO,0,13), "B", 1, 'L');

                        $pdf->SetX($x_kanban2 + 15);
                        $pdf->SetFont('Courier', '', 9);
                        $pdf->Cell(44, 5, substr($data_part[0]->CHR_SPARE_PART_NAME,0,18), "B", 1, 'L');
                        
                        $pdf->SetX($x_kanban2 + 15);
                        $pdf->SetFont('Courier', '', 8);
                        $pdf->Cell(44, 5, substr($data_part[0]->CHR_SPECIFICATION,0,23), "B", 1, 'L');

                        $pdf->SetY($y_kanban2 + 17);
                        $pdf->SetX($x_kanban2);
                        $pdf->SetFont('Courier', '', 9);
                        $pdf->Cell(43, 4, "Min Qty:");

                        $pdf->SetY($y_kanban2 + 15);
                        $pdf->SetX($x_kanban2 - 1);
                        $pdf->SetFont('Arial', 'B', 16);
                        $pdf->Cell(30, 9, "           " . $data_part[0]->INT_QTY_MIN, 1, 'L');

                        $pdf->SetY($y_kanban2 + 17);
                        $pdf->SetX($x_kanban2 + 30);
                        $pdf->SetFont('Courier', '', 9);
                        $pdf->Cell(43, 4, "Max Qty:");

                        $pdf->SetY($y_kanban2 + 15);
                        $pdf->SetX($x_kanban2 + 29);
                        $pdf->SetFont('Arial', 'B', 16);
                        $pdf->Cell(30, 9, "           " . $data_part[0]->INT_QTY_MAX, 1, 'L');
                        
                        $pdf->SetY($y_kanban2+1);
                        $pdf->SetX($x_kanban2);
                        $pdf->SetFont('Courier', '', 7);
                        $image1 = "./assets/qrcode_spare_parts/" . trim($data_part[0]->CHR_PART_NO) . ".png";
                        $pdf->Image($image1, $pdf->GetX() + 1, $pdf->GetY(), 13, 13);

                        $pdf->SetX($x_kanban2 + 57);
                        
                    } elseif ($index % 3 == 0) {
                        $x_kanban4 = $pdf->GetX();
                        $pdf->SetXY($x_kanban4, $y_kanban1);

                        $pdf->Cell(4, 8, "", "", 0, 'L');
                        $x_kanban1 = $pdf->GetX();
                        $y_kanban1 = $pdf->GetY();
                        $pdf->Cell(60, 25, "", 1, 1, 'L');
                        $pdf->SetY($y_kanban1 + 1);
                        $pdf->SetX($x_kanban1 + 1);

                        $x_kanban2 = $pdf->GetX();
                        $y_kanban2 = $pdf->GetY();
                        $pdf->Cell(15, 15, "", 1, 1, 'L');

                        //column 3
                        $pdf->SetY($y_kanban2);
                        $pdf->SetX($x_kanban2);
                        
                        $pdf->SetX($x_kanban2 + 15);
                        $pdf->SetFont('Courier', 'B', 12);
                        $pdf->Cell(19, 5, $data_part[0]->CHR_RACK_NO, "B", 0, 'L');

                        $pdf->SetX($x_kanban2 + 34);
                        $pdf->SetFont('Courier', '', 9);
                        $pdf->Cell(25, 5, substr($data_part[0]->CHR_PART_NO,0,13), "B", 1, 'L');

                        $pdf->SetX($x_kanban2 + 15);
                        $pdf->SetFont('Courier', '', 9);
                        $pdf->Cell(44, 5, substr($data_part[0]->CHR_SPARE_PART_NAME,0,18), "B", 1, 'L');
                        
                        $pdf->SetX($x_kanban2 + 15);
                        $pdf->SetFont('Courier', '', 8);
                        $pdf->Cell(44, 5, substr($data_part[0]->CHR_SPECIFICATION,0,23), "B", 1, 'L');

                        $pdf->SetY($y_kanban2 + 17);
                        $pdf->SetX($x_kanban2);
                        $pdf->SetFont('Courier', '', 9);
                        $pdf->Cell(43, 4, "Min Qty:");

                        $pdf->SetY($y_kanban2 + 15);
                        $pdf->SetX($x_kanban2 - 1);
                        $pdf->SetFont('Arial', 'B', 16);
                        $pdf->Cell(30, 9, "           " . $data_part[0]->INT_QTY_MIN, 1, 'L');

                        $pdf->SetY($y_kanban2 + 17);
                        $pdf->SetX($x_kanban2 + 30);
                        $pdf->SetFont('Courier', '', 9);
                        $pdf->Cell(43, 4, "Max Qty:");

                        $pdf->SetY($y_kanban2 + 15);
                        $pdf->SetX($x_kanban2 + 29);
                        $pdf->SetFont('Arial', 'B', 16);
                        $pdf->Cell(30, 9, "           " . $data_part[0]->INT_QTY_MAX, 1, 'L');
                        
                        $pdf->SetY($y_kanban2+1);
                        $pdf->SetX($x_kanban2);
                        $pdf->SetFont('Courier', '', 7);
                        $image1 = "./assets/qrcode_spare_parts/" . trim($data_part[0]->CHR_PART_NO) . ".png";
                        $pdf->Image($image1, $pdf->GetX() + 1, $pdf->GetY(), 13, 13);
                        
                        $pdf->SetXY(3, $pdf->GetY() + 25);
                        
                        if ($index_page % 10 == 0) {
                            $pdf->AddPage();
                        }
                        $index_page++;
                    }
                    $index++;
                }
                $pdf->Output();
            }
            else {
                $index = 1;
                $index_page = 1;
                $pdf = new FPDF('P', 'mm', 'A4');
                $pdf->SetMargins(3, 3, 3, 0);
                $pdf->SetAutoPageBreak(true, 0);
                $pdf->AliasNbPages();
                $pdf->AddPage();

                for ($i = 0; $i < count($checked); $i++) {
                    $x = $checked[$i];
                    $data_part = $db_samanta->query("SELECT A.CHR_PART_NO, A.CHR_RACK_NO, B.CHR_BACK_NO, B.CHR_SPARE_PART_NAME, B.CHR_SPECIFICATION, B.INT_QTY_MIN, B.INT_QTY_MAX, B.CHR_FILENAME
                                                        FROM TM_SPARE_PARTS_ROUTING A INNER JOIN TM_SPARE_PARTS B ON B.CHR_PART_NO = A.CHR_PART_NO
                                                        WHERE A.INT_ID = '$x'")->result();
                    if ($index % 3 == 1) {
                        //cell kotakan luar
                        $x_kanban1 = $pdf->GetX();
                        $y_kanban1 = $pdf->GetY();
                        $pdf->Cell(67, 25, "", 1, 1, ''); // ukuran kotak luar
                        $pdf->SetY($y_kanban1 + 1); // jarak kotak luar dan dalam
                        $pdf->SetX($x_kanban1 + 1);

                        //column 1
                        //cell kotakan dalam
                        $x_kanban2 = $pdf->GetX();
                        $y_kanban2 = $pdf->GetY();
                        
                        $pdf->SetY($y_kanban2 - 1);
                        $pdf->SetX($x_kanban2 + 47);
                        $pdf->SetFont('Arial', 'B', 10);
                        $pdf->Cell(19, 8, "  " . $data_part[0]->CHR_BACK_NO, 1, 0, 'L');
                        
                        $pdf->SetY($y_kanban2);
                        $pdf->SetFont('Arial', '', 7.5);
                        $pdf->Cell(48, 3, "Dies Name : " . $data_part[0]->CHR_SPARE_PART_NAME, "B", 0, 'L');

                        $pdf->SetY($y_kanban2 + 4);
                        $pdf->SetFont('Arial', '', 7.5);
                        $pdf->Cell(48, 3, "Part Name  : " .substr($data_part[0]->CHR_SPECIFICATION,0,18), "B", 1, 'L');

                        $pdf->SetY($y_kanban2 + 7);
                        $pdf->SetFont('Arial', '', 5);
                        $pdf->Cell(16, 3, substr($data_part[0]->CHR_PART_NO,0,13), "B", 1, 'L');

                        $pdf->SetY($y_kanban2 + 11);
                        $pdf->SetX($x_kanban2);                
                        $image1 = "./assets/qrcode_spare_parts/" . trim($data_part[0]->CHR_PART_NO) . ".png";
                        $pdf->Image($image1, $pdf->GetX() + 1, $pdf->GetY(), 12, 12);

                        $pdf->SetY($y_kanban2 + 8);
                        $pdf->SetX($x_kanban2 + 15);
                        $image2= "./assets/img/tools/" . trim($data_part[0]->CHR_FILENAME) . "_.jpg";
                        $pdf->Image($image2, $pdf->GetX() + 1, $pdf->GetY(), 30, 15);
                        
                        $pdf->SetY($y_kanban2 + 7);
                        $pdf->SetX($x_kanban2 + 47);
                        $pdf->SetFont('Arial', '', 8);
                        $pdf->Cell(19, 5,"Qty Min: " . $data_part[0]->INT_QTY_MIN, "B", 1, 'L');

                        $pdf->SetY($y_kanban2 + 12);
                        $pdf->SetX($x_kanban2 + 47);
                        $pdf->SetFont('Arial', '', 8);
                        $pdf->Cell(19, 5, "Qty Max: " . $data_part[0]->INT_QTY_MAX, "B", 1, 'L');

                        $pdf->SetY($y_kanban2 + 17);
                        $pdf->SetX($x_kanban2 + 47);
                        $pdf->SetFont('Arial', 'B', 12);
                        $pdf->Cell(19, 9, $data_part[0]->CHR_RACK_NO, 0, 'C');
                        
                        $pdf->SetX($x_kanban2 + 59);
                        //$pdf->SetY(2);
                        
                        
                    } elseif ($index % 3 == 2) {
                        //mulai untuk kolom baru
                        $x_kanban4 = $pdf->GetX();
                        $pdf->SetXY($x_kanban4, $y_kanban1);

                        $pdf->Cell(8, 8, "", "", 0, 'L');
                        $x_kanban1 = $pdf->GetX();
                        $y_kanban1 = $pdf->GetY();
                        $pdf->Cell(67, 25, "", 1, 1, 'L'); // ukuran kotak luar
                        $pdf->SetY($y_kanban1 + 1);
                        $pdf->SetX($x_kanban1 + 1);

                        $x_kanban2 = $pdf->GetX();
                        $y_kanban2 = $pdf->GetY();
                        // $pdf->Cell(15, 15, "", 1, 1, 'L');

                        //column 2
                        $pdf->SetY($y_kanban2);
                        $pdf->SetX($x_kanban2);
                        
                        $pdf->SetY($y_kanban2 - 1);
                        $pdf->SetX($x_kanban2 + 47);
                        $pdf->SetFont('Arial', 'B', 10);
                        $pdf->Cell(19, 8, "  " . $data_part[0]->CHR_BACK_NO, 1, 0, 'L');
                        
                        $pdf->SetY($y_kanban2);
                        $pdf->SetX($x_kanban2 - 1);
                        $pdf->SetFont('Arial', '', 7.5);
                        $pdf->Cell(48, 3, "Dies Name : " . $data_part[0]->CHR_SPARE_PART_NAME, "B", 0, 'L');

                        $pdf->SetY($y_kanban2 + 4);
                        $pdf->SetX($x_kanban2 - 1);
                        $pdf->SetFont('Arial', '', 7.5);
                        $pdf->Cell(48, 3, "Part Name  : " .substr($data_part[0]->CHR_SPECIFICATION,0,18), "B", 1, 'L');

                        $pdf->SetY($y_kanban2 + 7);
                        $pdf->SetX($x_kanban2 - 1);
                        $pdf->SetFont('Arial', '', 5);
                        $pdf->Cell(16, 3, substr($data_part[0]->CHR_PART_NO,0,13), "B", 1, 'L');

                        $pdf->SetY($y_kanban2 + 11);
                        $pdf->SetX($x_kanban2);
                        $image1 = "./assets/qrcode_spare_parts/" . trim($data_part[0]->CHR_PART_NO) . ".png";
                        $pdf->Image($image1, $pdf->GetX() + 1, $pdf->GetY(), 12, 12);

                        $pdf->SetY($y_kanban2 + 8);
                        $pdf->SetX($x_kanban2 + 15);
                        $image2= "./assets/img/tools/" . trim($data_part[0]->CHR_FILENAME) . "_.jpg";
                        $pdf->Image($image2, $pdf->GetX() + 1, $pdf->GetY(), 30, 15);
                        
                        $pdf->SetY($y_kanban2 + 7);
                        $pdf->SetX($x_kanban2 + 47);
                        $pdf->SetFont('Arial', '', 8);
                        $pdf->Cell(19, 5,"Qty Min: " . $data_part[0]->INT_QTY_MIN, "B", 1, 'L');

                        $pdf->SetY($y_kanban2 + 12);
                        $pdf->SetX($x_kanban2 + 47);
                        $pdf->SetFont('Arial', '', 8);
                        $pdf->Cell(19, 5, "Qty Max: " . $data_part[0]->INT_QTY_MAX, "B", 1, 'L');

                        $pdf->SetY($y_kanban2 + 17);
                        $pdf->SetX($x_kanban2 + 47);
                        $pdf->SetFont('Arial', 'B', 12);
                        $pdf->Cell(19, 9, $data_part[0]->CHR_RACK_NO, 0, 'C');

                        $pdf->SetX($x_kanban2 + 59);
                        
                    } elseif ($index % 3 == 0) {
                        $x_kanban4 = $pdf->GetX();
                        $pdf->SetXY($x_kanban4, $y_kanban1);

                        $pdf->Cell(8, 8, "", "", 0, 'L');
                        $x_kanban1 = $pdf->GetX();
                        $y_kanban1 = $pdf->GetY();
                        $pdf->Cell(67, 25, "", 1, 1, 'L'); // ukuran kotak luar
                        $pdf->SetY($y_kanban1 + 1);
                        $pdf->SetX($x_kanban1 + 1);

                        $x_kanban2 = $pdf->GetX();
                        $y_kanban2 = $pdf->GetY();
                        // $pdf->Cell(15, 15, "", 1, 1, 'L');

                        //column 3
                        $pdf->SetY($y_kanban2);
                        $pdf->SetX($x_kanban2);
                        
                        $pdf->SetY($y_kanban2 - 1);
                        $pdf->SetX($x_kanban2 + 47);
                        $pdf->SetFont('Arial', 'B', 10);
                        $pdf->Cell(19, 8, "  " . $data_part[0]->CHR_BACK_NO, 1, 0, 'L');
                        
                        $pdf->SetY($y_kanban2);
                        $pdf->SetX($x_kanban2 - 1);
                        $pdf->SetFont('Arial', '', 7.5);
                        $pdf->Cell(48, 3, "Dies Name : " . $data_part[0]->CHR_SPARE_PART_NAME, "B", 0, 'L');

                        $pdf->SetY($y_kanban2 + 4);
                        $pdf->SetX($x_kanban2 - 1);
                        $pdf->SetFont('Arial', '', 7.5);
                        $pdf->Cell(48, 3, "Part Name  : " .substr($data_part[0]->CHR_SPECIFICATION,0,18), "B", 1, 'L');

                        $pdf->SetY($y_kanban2 + 7);
                        $pdf->SetX($x_kanban2 - 1);
                        $pdf->SetFont('Arial', '', 5);
                        $pdf->Cell(16, 3, substr($data_part[0]->CHR_PART_NO,0,13), "B", 1, 'L');

                        $pdf->SetY($y_kanban2 + 11);
                        $pdf->SetX($x_kanban2);
                        $image1 = "./assets/qrcode_spare_parts/" . trim($data_part[0]->CHR_PART_NO) . ".png";
                        $pdf->Image($image1, $pdf->GetX() + 1, $pdf->GetY(), 12, 12);

                        $pdf->SetY($y_kanban2 + 8);
                        $pdf->SetX($x_kanban2 + 15);
                        $image2= "./assets/img/tools/" . trim($data_part[0]->CHR_FILENAME) . "_.jpg";
                        $pdf->Image($image2, $pdf->GetX() + 1, $pdf->GetY(), 30, 15);
                        
                        $pdf->SetY($y_kanban2 + 7);
                        $pdf->SetX($x_kanban2 + 47);
                        $pdf->SetFont('Arial', '', 8);
                        $pdf->Cell(19, 5,"Qty Min: " . $data_part[0]->INT_QTY_MIN, "B", 1, 'L');

                        $pdf->SetY($y_kanban2 + 12);
                        $pdf->SetX($x_kanban2 + 47);
                        $pdf->SetFont('Arial', '', 8);
                        $pdf->Cell(19, 5, "Qty Max: " . $data_part[0]->INT_QTY_MAX, "B", 1, 'L');

                        $pdf->SetY($y_kanban2 + 17);
                        $pdf->SetX($x_kanban2 + 47);
                        $pdf->SetFont('Arial', 'B', 12);
                        $pdf->Cell(19, 9, $data_part[0]->CHR_RACK_NO, 0, 'C');
                        
                        $pdf->SetXY(3, $pdf->GetY() + 10);
                        
                        if ($index_page % 10 == 0) {
                            $pdf->AddPage();
                        }
                        $index_page++;
                    }
                    $index++;
                }

                $pdf->Output();
            }
        } 
        else {
            redirect($this->back_to_manage);
        }
        
    }

    function goto_edit_rack($id) {
        $this->role_module_m->authorization('3');

        $data['data'] = $this->spare_parts_rack_m->get_data_rack($id)->row();
        $data['content'] = 'samanta/manage_rack/edit_rack_v';
        $data['title'] = 'Edit Spare Part Data';
        $data['news'] = $this->news_m->get_news();
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(74);

        $this->load->view($this->layout, $data);
    }

    function update_rack() {
        $datenow = date('Ymd');
        $timenow = date('His');
        $session = $this->session->all_userdata();
        $pic = $this->session->userdata('NPK');
        $id = $this->input->post('INT_ID');
        $rack_no = $this->input->post('CHR_RACK_NO');

        $this->form_validation->set_rules('CHR_RACK_NO', 'Rack Number', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->goto_edit_rack($id);
        } else {
            $data = array(
                'CHR_RACK_NO' => $this->input->post('CHR_RACK_NO'),
                'CHR_MODIFIED_BY' => $pic,
                'CHR_MODIFIED_DATE' => $datenow,
                'CHR_MODIFIED_TIME' => $timenow
            );
            $this->spare_parts_rack_m->update_rack($data, $id);
            redirect($this->back_to_manage . $msg = 2);
        }
    }
}
