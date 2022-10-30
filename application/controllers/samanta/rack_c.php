<?php

class rack_c extends CI_Controller {
    
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
        $db_samanta = $this->load->database("samanta", TRUE);
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
        } else {
            $msg = null;
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
        $data['content'] = 'samanta/manage_rack/manage_rack_v_2';
        $data['sidebar'] = $this->role_module_m->side_bar(74);       
        
        $this->load->view($this->layout, $data);
    }

    function get_rack($msg = NULL, $area = null) {
        if ($area == null) {
            $data_rack_per_area = null;
        }
        else {
            $data_rack_per_area = $this->spare_parts_rack_m->get_data_rack_per_area($area);
            
        }
        $get_data_area = $this->spare_parts_m->get_data_area();
        
        // print_r($data_rack_per_area);
        // exit();


        $data['msg'] = $msg;
        $data['area'] = $area;
        $data['selected_area'] = $get_data_area;
        $data['all_area'] = $get_data_area;
        $date['data_rack'] = $data_rack_per_area;
        
        $data['title'] = 'Manage Rack';
        $data['news'] = $this->news_m->get_news();
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['content'] = 'samanta/manage_rack/manage_rack_v_2';
        $data['sidebar'] = $this->role_module_m->side_bar(74);
    
        $this->load->view($this->layout, $data);        
    }

    function generate_lable_part() {
        $db_samanta = $this->load->database("samanta", TRUE);
        $checked = $this->input->post('options');
        if ($checked == null) {
            redirect($this->back_to_manage);
        }
        $index = 1;
        $index_page = 1;
        $pdf = new FPDF('P', 'mm', 'A4');
        $pdf->SetMargins(3, 3, 3, 0);
        $pdf->SetAutoPageBreak(true, 0);
        $pdf->AliasNbPages();
        $pdf->AddPage();

        for ($i = 0; $i < count($checked); $i++) {
            $x = $checked[$i];
            $data_part = $db_samanta->query("SELECT A.CHR_PART_NO, A.CHR_RACK_NO, B.CHR_BACK_NO, B.CHR_SPARE_PART_NAME, B.CHR_SPECIFICATION, B.INT_QTY_MIN, B.INT_QTY_MAX
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
                $pdf->SetFont('Arial', 'B', 12);
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

                $pdf->SetY($y_kanban2 + 7);
                $pdf->SetX($x_kanban2 + 15);
                $pdf->Cell(32, 17, "", 1, 0, 'L'); //ukuran kotak PICTURE
                
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
                $pdf->SetFont('Arial', 'B', 10);
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
                $pdf->SetFont('Arial', 'B', 12);
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

                $pdf->SetY($y_kanban2 + 7);
                $pdf->SetX($x_kanban2 + 15);
                $pdf->Cell(32, 17, "", 1, 0, 'L'); //ukuran kotak PICTURE
                
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
                $pdf->SetFont('Arial', 'B', 10);
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
                $pdf->SetFont('Arial', 'B', 12);
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

                $pdf->SetY($y_kanban2 + 7);
                $pdf->SetX($x_kanban2 + 15);
                $pdf->Cell(32, 17, "", 1, 0, 'L'); //ukuran kotak PICTURE
                
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
                $pdf->SetFont('Arial', 'B', 10);
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
