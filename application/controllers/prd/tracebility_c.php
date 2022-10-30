<?php

class tracebility_c extends CI_Controller
{

    private $layout = '/template/head';
    private $back_to_manage = 'prd/tracebility_c/index/';
    private $back_to_manage_ascc = 'prd/tracebility_c/tracebility_ascc/';
    //public $id_function = '283';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('prd/tracebility_m');
        $this->load->model('basis/log_m');
        $this->load->model('basis/role_module_m');
        $this->load->model('basis/user_m');
        $this->load->model('portal/notification_m');
        $this->load->model('portal/news_m');
        $this->load->model('organization/dept_m');
        $this->load->model('prd/direct_backflush_general_m');
        $this->load->model('part/part_m');
    }

    function index($msg = NULL)
    {
        
        $this->role_module_m->authorization(285);

        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Creating success </strong> The data is successfully created </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Data not found</strong> Please check your QR Code </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Deleted success </strong> The data is successfully deleted </div >";
        } elseif ($msg == 4) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Data Already Exist !</strong> Silahkan input data part yang lainnya</div >";
        }

        $data['msg'] = $msg;
        $data['content'] = 'prd/tracebility/tracebility_v';
        $data['title'] = 'Part Tracebility - Clutch Disc (CD)';

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(285);
        $data['news'] = $this->news_m->get_news();
        $data['qr_barcode'] = '';

        $this->load->view($this->layout, $data);
    }

    function tracebility_ascc($msg = NULL, $work_center = NULL)
    {
        $this->role_module_m->authorization(285);

        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Creating success </strong> The data is successfully created </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Data not found</strong> Please check your QR Code </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Deleted success </strong> The data is successfully deleted </div >";
        } elseif ($msg == 4) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Data Already Exist !</strong> Silahkan input data part yang lainnya</div >";
        }

        if ($work_center == NULL) {
            $work_center = 'ASCC05';
        }

        $data['msg'] = $msg;
        $data['content'] = 'prd/tracebility/tracebility_ascc_v';
        $data['title'] = 'Part Tracebility - Clutch Cover (CC)';

        $ascc_wcenters = $this->tracebility_m->get_work_center_ascc();

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(329);
        $data['news'] = $this->news_m->get_news();
        $data['ascc_wcenters'] = $ascc_wcenters;
        $data['work_center'] = $work_center;
        $data['qr_barcode'] = '';

        $this->load->view($this->layout, $data);
    }

    //get data tracebility
    function tracebility()
    {
        $id_qrcode = $this->input->post('id_qrcode');
        if (!empty($id_qrcode)) {
            // 021118134253023
            // 181112093236999

            $date = substr($id_qrcode, 0, 6);
            $hour = substr($id_qrcode, 6, 6);
            $hour2 = substr($id_qrcode, 6, 5);

            $datetimeprod = date('d-M-Y', strtotime($date)) . "  " . date('h:i:s', strtotime($hour));

            //set date
            $day = substr($date, 0, 2);
            $month = substr($date, 2, 2);
            $year = substr($date, 4, 2);
            $year = "20" . $year;
            $date_created = $year . "" . $month . "" . $day;

            //get data production order no from TT_DATA_TESTER
            $get_data_tester = $this->tracebility_m->get_data_tester($date_created, $hour2);
            $prd_order = $get_data_tester->CHR_PRD_ORDER_NO;

            $get_data_elina = $this->tracebility_m->get_detail_data($prd_order);

            $get_elina_h = $this->tracebility_m->get_elina_h($prd_order);
            $back_no = $get_elina_h->CHR_BACK_NO_FG;

            $data['datatester'] = $get_data_tester;
            $data['datadetail'] = $get_data_elina;
            $data['prd_order'] = $prd_order;
            $data['datetime'] = $datetimeprod;
            $data['back_no'] = $back_no;
            $data['qr_barcode'] = $id_qrcode;
            $data['content'] = 'prd/tracebility/tracebility_v';
            $data['title'] = 'Part Tracebility';

            $data['app'] = $this->role_module_m->get_app();
            $data['module'] = $this->role_module_m->get_module();
            $data['function'] = $this->role_module_m->get_function();
            $data['sidebar'] = $this->role_module_m->side_bar(285);
            $this->load->view($this->layout, $data);
        } else {
            echo '<script>alert("Data QR tidak ditemukan");</script>';
            redirect('prd/tracebility_c/index', 'refresh');
        }
    }

    //get data tracebility by ANU
    function tracebility_new($msg = null)
    {
        $data['msg'] = $msg;

        $id_qrcode = $this->input->post('id_qrcode');
        // print_r($id_qrcode);
        // exit();

        if (!empty($id_qrcode)) {
            // 181112093236999
            $date = substr($id_qrcode, 0, 6);
            $hour = substr($id_qrcode, 6, 6);
            $hour2 = substr($id_qrcode, 6, 5);
            $date2 = "20" . $date;

            // 190109
            $datetimeprod = date('d-M-Y', strtotime($date2)) . "  " . date('h:i:s', strtotime($hour));
            //set date
            $day = (int) substr($date, 4, 2);
            $month = (int) substr($date, 2, 2);
            $year = (int) substr($date, 0, 2);
            $year = "20" . $year;

            $h = (int) substr($id_qrcode, 6, 2);
            $m = (int) substr($id_qrcode, 8, 2);
            $s = (int) substr($id_qrcode, 10, 2);
            $date_created = $year . "" . $month . "" . $day;

            //get data production order no from TT_DATA_TESTER
            $get_data_tester = $this->tracebility_m->get_data_tester_new($year, $month, $day, $h, $m, $s);
            $prd_order = $get_data_tester->CHR_PRD_ORDER_NO;
            $id_one_way = $get_data_tester->INT_ID_ONE_WAY_KANBAN;

            if ($prd_order == null) {
                redirect($this->back_to_manage . $msg = 2);
            }

            $get_data_elina = $this->tracebility_m->get_detail_data($prd_order);

            $get_elina_h = $this->tracebility_m->get_elina_h($prd_order);
            $back_no = $get_elina_h->CHR_BACK_NO_FG;

            //===== ADD TRACE FORWARD --- By ANU 20191209 =====//    
            if ($id_one_way == NULL) {
                $get_trace_forward = $this->tracebility_m->get_data_trace_forward($id_qrcode);
                if ($get_trace_forward->num_rows() > 0) {
                    $data_traceforward = $get_trace_forward->row();
                } else {
                    $data_traceforward = "NULL";
                }
            } else {
                $get_trace_forward = $this->tracebility_m->get_data_trace_forward_v2($id_qrcode);
                if ($get_trace_forward->num_rows() > 0) {
                    $data_traceforward = $get_trace_forward->row();
                } else {
                    $data_traceforward = "NULL";
                }
            }

            // print_r($data_traceforward);
            // exit();

            $data['data_traceforward'] = $data_traceforward;
            //===== END =====//

            $data['datatester'] = $get_data_tester;
            $data['datadetail'] = $get_data_elina;
            $data['prd_order'] = $prd_order;
            $data['datetime'] = $datetimeprod;
            $data['back_no'] = $back_no;
            $data['qr_barcode'] = $id_qrcode;
            $data['content'] = 'prd/tracebility/tracebility_v';
            $data['title'] = 'Part Tracebility';

            $data['app'] = $this->role_module_m->get_app();
            $data['module'] = $this->role_module_m->get_module();
            $data['function'] = $this->role_module_m->get_function();
            $data['sidebar'] = $this->role_module_m->side_bar(285);

            $this->load->view($this->layout, $data);
        } else {
            echo '<script>alert("Data QR tidak ditemukan");</script>';
            redirect('prd/tracebility_c/index', 'refresh');
        }
    }

    //get data tracebility ASCC by ANU
    function get_tracebility_ascc($msg = null)
    {
        $data['msg'] = $msg;

        $work_center = $this->input->post('work_center');
        $id_qrcode = $this->input->post('id_qrcode');

        if (!empty($id_qrcode)) {
            // 181112093236999
            $date = substr($id_qrcode, 0, 6);
            $hour = substr($id_qrcode, 6, 6);
            $hour2 = substr($id_qrcode, 6, 5);
            $date2 = "20" . $date;

            // 190109
            $datetimeprod = date('d-M-Y', strtotime($date2)) . "  " . date('h:i:s', strtotime($hour));
            //set date
            $day = (int) substr($date, 4, 2);
            $month = (int) substr($date, 2, 2);
            $year = (int) substr($date, 0, 2);
            $year = "20" . $year;

            $h = (int) substr($id_qrcode, 6, 2);
            $m = (int) substr($id_qrcode, 8, 2);
            $s = (int) substr($id_qrcode, 10, 2);
            $date_created = $year . "" . $month . "" . $day;

            //get data production order no from TT_DATA_TESTER
            if ($work_center == 'ASCC05') {
                $get_data_tester = $this->tracebility_m->get_data_tester_ascc05($year, $month, $day, $h, $m, $s);
            } else {
                //=== For another line of ASCC - Not yet implemented
                $get_data_tester = $this->tracebility_m->get_data_tester_ascc05($year, $month, $day, $h, $m, $s);
            }

            // $prd_order = $get_data_tester->CHR_PRD_ORDER_NO;
            $prd_order = $get_data_tester->CHR_MODIFIED_BY;
            $id_one_way = $get_data_tester->INT_ID_ONE_WAY_KANBAN;

            if ($prd_order == null) {
                redirect($this->back_to_manage_ascc . $msg = 2);
            }

            $get_data_elina = $this->tracebility_m->get_detail_data($prd_order);

            $get_elina_h = $this->tracebility_m->get_elina_h($prd_order);
            $back_no = $get_elina_h->CHR_BACK_NO_FG;

            //===== ADD TRACE FORWARD --- By ANU 20191209 =====//    
            // $get_trace_forward = $this->tracebility_m->get_data_trace_forward_ascc($id_qrcode, $work_center); 
            // if($get_trace_forward->num_rows() > 0){                
            //     $data_traceforward = $get_trace_forward->row();                
            // } else {
                $data_traceforward = "NULL";
            // }

            $data['data_traceforward'] = $data_traceforward;
            //===== END =====//

            $ascc_wcenters = $this->tracebility_m->get_work_center_ascc();
            $data['ascc_wcenters'] = $ascc_wcenters;
            $data['work_center'] = $work_center;

            $data['datatester'] = $get_data_tester;
            $data['datadetail'] = $get_data_elina;
            $data['prd_order'] = $prd_order;
            $data['datetime'] = $datetimeprod;
            $data['back_no'] = $back_no;
            $data['qr_barcode'] = $id_qrcode;
            $data['content'] = 'prd/tracebility/tracebility_ascc_v';
            $data['title'] = 'Part Tracebility';

            $data['app'] = $this->role_module_m->get_app();
            $data['module'] = $this->role_module_m->get_module();
            $data['function'] = $this->role_module_m->get_function();
            $data['sidebar'] = $this->role_module_m->side_bar(329);

            $this->load->view($this->layout, $data);
        } else {
            echo '<script>alert("Data QR tidak ditemukan");</script>';
            redirect('prd/tracebility_c/tracebility_ascc', 'refresh');
        }
    }

    //get data tracebility ASDL
    function get_traceability_asdl()
    {
        $data['content'] = 'prd/tracebility/traceability_asdl_v';
        $data['title'] = 'Part Traceability';
        $work_center = $this->input->post('CHR_WORK_CENTER');
        $barcode = $this->input->post('CHR_UNIQUE_NUMBER');

        if ($work_center == null || $work_center == '') {
            $work_center = 'ASDL06';
        }

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(344);

        $data_traceability = $this->tracebility_m->get_data_tester_by_line($barcode, $work_center);

        if ($_POST) {
            if (!$data_traceability) {
                $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Data not founded </strong>  The data about this qrcode not found </div >";
                $prd_order_no = 'N/A';
                $model = 'N/A';
                $date = 'N/A';
                $time = null;
                $back_no = null;

                $data_traceforward = array();
                $data_history_elina = array();
                $data_elina = array();
            } else {
                $msg = null;
                $prd_order_no = $data_traceability->CHR_MODIFIED_BY;
                $model = $data_traceability->CHR_MODEL;
                $date = date_format(date_create($data_traceability->CHR_CREATED_DATE), "d-m-Y");
                $time = date_format(date_create($data_traceability->CHR_CREATED_TIME), "H:i:s");

                $data_traceforward = array();
                $data_history_elina = $this->tracebility_m->get_detail_data($prd_order_no);
                $data_elina = $this->tracebility_m->get_elina_h($prd_order_no);
                $back_no = $data_elina->CHR_BACK_NO_FG;
            }
        } else {
            $msg = "";
            $prd_order_no = 'N/A';
            $model = 'N/A';
            $date = 'N/A';
            $time = null;
            $back_no = null;

            $data_traceforward = array();
            $data_history_elina = array();
            $data_elina = array();
        }


        $data_detail = array(
            'work_center' => $work_center,
            'qr_barcode' => $barcode,
            'prd_order_no' => $prd_order_no,
            'back_no' => $back_no,
            'model' => $model,
            'datetime' => $date . ' ' . $time,
            'msg' => $msg
        );

        $data['data_traceforward'] = $data_traceforward;
        $data['data_traceability'] = $data_traceability;
        $data['data_elina'] = $data_elina;
        $data['data_history_elina'] = $data_history_elina;
        $data['data_detail'] = $data_detail;

        $this->load->view($this->layout, $data);
    }

    //get data tracebility ASHV by ANU
    function traceability_ashv()
    {
        $data['content'] = 'prd/tracebility/traceability_ashv_v';
        $data['title'] = 'Part Traceability';
        $work_center = $this->input->post('CHR_WORK_CENTER');
        $barcode = $this->input->post('CHR_UNIQUE_NUMBER');

        if ($work_center == null || $work_center == '') {
            $work_center = 'ASHV01';
        }

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(347);

        $data_traceability = $this->tracebility_m->get_data_tester_by_line($barcode, $work_center);

        if ($_POST) {
            if (!$data_traceability) {
                $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Data not founded </strong>  The data about this qrcode not found </div >";
                $prd_order_no = 'N/A';
                $model = 'N/A';
                $date = 'N/A';
                $time = null;
                $back_no = null;

                $data_traceforward = array();
                $data_history_elina = array();
                $data_elina = array();
            } else {
                $msg = null;
                $prd_order_no = $data_traceability->CHR_MODIFIED_BY;
                $model = $data_traceability->CHR_MODEL;
                $date = date_format(date_create($data_traceability->CHR_CREATED_DATE), "d-m-Y");
                $time = date_format(date_create($data_traceability->CHR_CREATED_TIME), "H:i:s");

                $data_traceforward = array();
                $data_history_elina = $this->tracebility_m->get_detail_data($prd_order_no);
                $data_elina = $this->tracebility_m->get_elina_h($prd_order_no);
                $back_no = $data_elina->CHR_BACK_NO_FG;
            }
        } else {
            $msg = "";
            $prd_order_no = 'N/A';
            $model = 'N/A';
            $date = 'N/A';
            $time = null;
            $back_no = null;

            $data_traceforward = array();
            $data_history_elina = array();
            $data_elina = array();
        }

        $data_detail = array(
            'work_center' => $work_center,
            'qr_barcode' => $barcode,
            'prd_order_no' => $prd_order_no,
            'back_no' => $back_no,
            'model' => $model,
            'datetime' => $date . ' ' . $time,
            'msg' => $msg
        );

        $data['data_traceforward'] = $data_traceforward;
        $data['data_traceability'] = $data_traceability;
        $data['data_elina'] = $data_elina;
        $data['data_history_elina'] = $data_history_elina;
        $data['data_detail'] = $data_detail;

        $this->load->view($this->layout, $data);
    }

    function traceability_batch_data($msg = NULL, $start_date = NULL, $end_date = NULL)
    {

        if ($start_date == NULL) {
            $start_date = date("Ymd");
        }

        if ($end_date == NULL) {
            $end_date = date("Ymd");
        }

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(342);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Traceability Data';
        $data['msg'] = $msg;

        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;

        // if($id_dept == NULL){
        $id_dept = '23';
        $work_center = 'ASCD02';
        // $id_dept = $this->dept_m->get_top_prod_dept()->row()->INT_ID_DEPT;
        // $work_center = $this->direct_backflush_general_m->get_top_work_center_by_id_dept($id_dept);
        // }  

        $part_no = $this->tracebility_m->get_top_part_no_by_work_center($work_center)->CHR_PART_NO;

        $all_part_no = $this->tracebility_m->get_part_no_by_work_center($work_center);
        $all_dept_prod = $this->dept_m->get_all_prod_dept();
        $all_work_centers = $this->direct_backflush_general_m->get_work_center_by_id_dept($id_dept);

        $data['all_dept_prod'] = $all_dept_prod;
        $data['all_work_centers'] = $all_work_centers;
        $data['all_part_no'] = $all_part_no;
        $data['work_center'] = $work_center;
        $data['id_dept'] = $id_dept;
        $data['part_no'] = $part_no;

        $data['data'] = $this->tracebility_m->get_traceability_by_part_no_fg($work_center, $part_no, $start_date, $end_date);

        $data['content'] = 'quality/traceability/traceability_batch_' . strtolower(substr($work_center, 0, 4)) . '_v';
        $this->load->view($this->layout, $data);
    }

    function get_data_part_by_work_center()
    {
        $work_center = $this->input->post("CHR_WCENTER");

        $part_no = $this->tracebility_m->get_top_part_no_by_work_center($work_center)->CHR_PART_NO;
        $data_part_no = $this->tracebility_m->get_part_no_by_work_center($work_center);
        $data = '';

        foreach ($data_part_no as $row) {
            if (trim($part_no) == trim($row->CHR_PART_NO)) {
                $data .= "<option selected value='$row->CHR_PART_NO'>" . $row->CHR_PART_NO . " - " . $row->CHR_BACK_NO . "</option>";
            } else {
                $data .= "<option value='$row->CHR_PART_NO'>" . $row->CHR_PART_NO . " - " . $row->CHR_BACK_NO . "</option>";
            }
        }

        $json_data = array('data' => $data);

        echo json_encode($json_data);
    }


    function search_traceability_batch_data($msg = NULL)
    {

        $id_dept = $this->input->post("INT_ID_DEPT");
        $work_center = $this->input->post("CHR_WORK_CENTER");;
        $part_no = $this->input->post("CHR_PART_NO");
        $start_date = date("Ymd", strtotime($this->input->post("START_DATE")));
        $end_date = date("Ymd", strtotime($this->input->post("END_DATE")));

        $trace_data = $this->tracebility_m->get_traceability_by_part_no_fg($work_center, $part_no, $start_date, $end_date);

        if ($this->input->post('export')) {
            $row = 2;

            $this->load->library('excel');
            $objReader = PHPExcel_IOFactory::createReader('Excel5');

            $objPHPExcel = $objReader->load("assets/template/production/template_traceability_report_" . $work_center . ".xlt");
            $active_sheet = $objPHPExcel->setActiveSheetIndexByName('TESTER & DELIVERY');

            $no = 1;
            $lot_no = "";
            $list_lot_no = array();
            foreach ($trace_data as $tr) {
                if ($lot_no != trim($tr->CHR_PRD_ORDER_NO)) {
                    $list_lot_no[] = trim($tr->CHR_PRD_ORDER_NO);
                }

                $lot_no = trim($tr->CHR_PRD_ORDER_NO);

                if ($work_center == "ASCD02") {
                    $active_sheet->setCellValue("A$row", $no);
                    $active_sheet->setCellValue("B$row", $tr->CHR_PRD_ORDER_NO);
                    $active_sheet->setCellValue("C$row", $tr->CHR_PART_NO);
                    $active_sheet->setCellValue("D$row", $tr->CHR_BACK_NO);
                    $active_sheet->setCellValue("E$row", $tr->CHR_MODEL);
                    $active_sheet->setCellValue("F$row", $tr->CHR_QR_PART);
                    $active_sheet->setCellValue("G$row", $tr->CHR_YEAR);
                    $active_sheet->setCellValue("H$row", $tr->CHR_MONTH);
                    $active_sheet->setCellValue("I$row", $tr->CHR_DAY);
                    $active_sheet->setCellValue("J$row", $tr->CHR_HOUR);
                    $active_sheet->setCellValue("K$row", $tr->CHR_MINUTE);
                    $active_sheet->setCellValue("L$row", $tr->CHR_SECOND);
                    $active_sheet->setCellValue("M$row", $tr->CHR_MASTER_NO);
                    $active_sheet->setCellValue("N$row", $tr->INT_FLG_SCAN);
                    $active_sheet->setCellValue("O$row", $tr->CHR_LOW_K1_UPP / 10);
                    $active_sheet->setCellValue("P$row", $tr->CHR_LOW_K1 / 100);
                    $active_sheet->setCellValue("Q$row", $tr->CHR_LOW_K1_LOW / 10);
                    $active_sheet->setCellValue("R$row", $tr->CHR_LOW_H1_UPP / 10);
                    $active_sheet->setCellValue("S$row", $tr->CHR_LOW_H1 / 100);
                    $active_sheet->setCellValue("T$row", $tr->CHR_LOW_H1_LOW / 10);
                    $active_sheet->setCellValue("U$row", $tr->CHR_HIGH_H1_UPP / 10);
                    $active_sheet->setCellValue("V$row", $tr->CHR_HIGH_H1 / 10);
                    $active_sheet->setCellValue("W$row", $tr->CHR_HIGH_H1_LOW / 10);
                    $active_sheet->setCellValue("X$row", $tr->CHR_HIGH_H2_UPP / 10);
                    $active_sheet->setCellValue("Y$row", $tr->CHR_HIGH_H2 / 10);
                    $active_sheet->setCellValue("Z$row", $tr->CHR_HIGH_H2_LOW / 10);
                    $active_sheet->setCellValue("AA$row", $tr->CHR_HIGH_K1_UPP / 1);
                    $active_sheet->setCellValue("AB$row", $tr->CHR_HIGH_K1 / 10);
                    $active_sheet->setCellValue("AC$row", $tr->CHR_HIGH_K1_LOW / 1);
                    $active_sheet->setCellValue("AD$row", $tr->CHR_HIGH_K2_UPP / 1);
                    $active_sheet->setCellValue("AE$row", $tr->CHR_HIGH_K2 / 10);
                    $active_sheet->setCellValue("AF$row", $tr->CHR_HIGH_K2_LOW / 1);
                    $active_sheet->setCellValue("AG$row", $tr->CHR_HIGH_K3_UPP / 1);
                    $active_sheet->setCellValue("AH$row", $tr->CHR_HIGH_K3 / 10);
                    $active_sheet->setCellValue("AI$row", $tr->CHR_HIGH_K3_LOW / 1);
                    $active_sheet->setCellValue("AJ$row", $tr->CHR_HIGH_K4_UPP / 1);
                    $active_sheet->setCellValue("AK$row", $tr->CHR_HIGH_K4 / 10);
                    $active_sheet->setCellValue("AL$row", $tr->CHR_HIGH_K4_LOW / 1);
                    $active_sheet->setCellValue("AM$row", $tr->CHR_PRD_ORDER_NO . ' ' . $tr->CHR_SERIAL);
                    $active_sheet->setCellValue("AN$row", $tr->CHR_MODIFIED_DATE);
                    $active_sheet->setCellValue("AO$row", $tr->CHR_MODIFIED_TIME);
                    $active_sheet->setCellValue("AP$row", $tr->CHR_IDPALLET);
                    $active_sheet->setCellValue("AQ$row", $tr->CHR_PARTNO_CUST);
                    $active_sheet->setCellValue("AR$row", $tr->CHR_DATE_SCAN);
                    $active_sheet->setCellValue("AS$row", $tr->CHR_TIME_SCAN);
                    $active_sheet->setCellValue("AT$row", $tr->CHR_NOPO_SAP);
                    $active_sheet->setCellValue("AU$row", $tr->CHR_DATE_DELIVERY);
                } else if ($work_center == "ASCC05") {
                    $active_sheet->setCellValue("A$row", $no);
                    $active_sheet->setCellValue("B$row", $tr->CHR_PRD_ORDER_NO);
                    $active_sheet->setCellValue("C$row", $tr->CHR_PART_NO);
                    $active_sheet->setCellValue("D$row", $tr->CHR_BACK_NO);
                    $active_sheet->setCellValue("E$row", $tr->CHR_MODEL);
                    $active_sheet->setCellValue("F$row", $tr->CHR_QR_PART);
                    $active_sheet->setCellValue("G$row", $tr->CHR_YEAR);
                    $active_sheet->setCellValue("H$row", $tr->CHR_MONTH);
                    $active_sheet->setCellValue("I$row", $tr->CHR_DAY);
                    $active_sheet->setCellValue("J$row", $tr->CHR_HOUR);
                    $active_sheet->setCellValue("K$row", $tr->CHR_MINUTE);
                    $active_sheet->setCellValue("L$row", $tr->CHR_SECOND);
                    $active_sheet->setCellValue("M$row", $tr->CHR_MASTER_NO);
                    $active_sheet->setCellValue("N$row", $tr->INT_FLG_SCAN);
                    $active_sheet->setCellValue("O$row", $tr->CHR_UPP_FIN_POINT);
                    $active_sheet->setCellValue("P$row", $tr->CHR_RESULT_FIN_POINT);
                    $active_sheet->setCellValue("Q$row", $tr->CHR_LOW_FIN_POINT);
                    $active_sheet->setCellValue("R$row", $tr->CHR_UPP_AMN_MIG);
                    $active_sheet->setCellValue("S$row", $tr->CHR_RESULT_AMN_MIG_1 / 100);
                    $active_sheet->setCellValue("T$row", $tr->CHR_RESULT_AMN_MIG_2 / 100);
                    $active_sheet->setCellValue("U$row", $tr->CHR_RESULT_AMN_MIG_3 / 100);
                    $active_sheet->setCellValue("V$row", $tr->CHR_LOW_AMN_MIG / 100);
                    $active_sheet->setCellValue("W$row", $tr->CHR_UPP_AMN_TRANS / 100);
                    $active_sheet->setCellValue("X$row", $tr->CHR_RESULT_AMN_TRANS / 100);
                    $active_sheet->setCellValue("Y$row", $tr->CHR_LOW_AMN_TRANS / 100);
                    $active_sheet->setCellValue("Z$row", $tr->CHR_UPP_GOING_WEAR);
                    $active_sheet->setCellValue("AA$row", $tr->CHR_RESULT_GOING_WEAR);
                    $active_sheet->setCellValue("AB$row", $tr->CHR_LOW_GOING_WEAR);
                    $active_sheet->setCellValue("AC$row", $tr->CHR_UPP_GOING_SET);
                    $active_sheet->setCellValue("AD$row", $tr->CHR_RESULT_GOING_SET);
                    $active_sheet->setCellValue("AE$row", $tr->CHR_LOW_GOING_SET);
                    $active_sheet->setCellValue("AF$row", $tr->CHR_UPP_RETURN_WEAR);
                    $active_sheet->setCellValue("AG$row", $tr->CHR_RESULT_RETURN_WEAR);
                    $active_sheet->setCellValue("AH$row", $tr->CHR_LOW_RETURN_WEAR);
                    $active_sheet->setCellValue("AI$row", $tr->CHR_UPP_RETURN_SET);
                    $active_sheet->setCellValue("AJ$row", $tr->CHR_RESULT_RETURN_SET);
                    $active_sheet->setCellValue("AK$row", $tr->CHR_LOW_RETURN_SET);
                    $active_sheet->setCellValue("AL$row", $tr->CHR_UPP_HYSTERIS);
                    $active_sheet->setCellValue("AM$row", $tr->CHR_RESULT_HYSTERIS);
                    $active_sheet->setCellValue("AN$row", $tr->CHR_LOW_HYSTERIS);
                    $active_sheet->setCellValue("AO$row", $tr->CHR_PRD_ORDER_NO . ' ' . $tr->CHR_SERIAL);
                    $active_sheet->setCellValue("AP$row", $tr->CHR_MODIFIED_DATE);
                    $active_sheet->setCellValue("AQ$row", $tr->CHR_MODIFIED_TIME);
                    $active_sheet->setCellValue("AR$row", $tr->CHR_IDPALLET);
                    $active_sheet->setCellValue("AS$row", $tr->CHR_PARTNO_CUST);
                    $active_sheet->setCellValue("AT$row", $tr->CHR_DATE_SCAN);
                    $active_sheet->setCellValue("AU$row", $tr->CHR_TIME_SCAN);
                    $active_sheet->setCellValue("AV$row", $tr->CHR_NOPO_SAP);
                    $active_sheet->setCellValue("AW$row", $tr->CHR_DATE_DELIVERY);
                } else if ($work_center == "ASHV01") {
                    $active_sheet->setCellValue("A$row", $no);
                    $active_sheet->setCellValue("B$row", $tr->CHR_PRD_ORDER_NO);
                    $active_sheet->setCellValue("C$row", $tr->CHR_PART_NO);
                    $active_sheet->setCellValue("D$row", $tr->CHR_BACK_NO);
                    $active_sheet->setCellValue("E$row", $tr->CHR_MODEL);
                    $active_sheet->setCellValue("F$row", $tr->CHR_QR_PART);
                    $active_sheet->setCellValue("G$row", $tr->CHR_YEAR);
                    $active_sheet->setCellValue("H$row", $tr->CHR_MONTH);
                    $active_sheet->setCellValue("I$row", $tr->CHR_DAY);
                    $active_sheet->setCellValue("J$row", $tr->CHR_HOUR);
                    $active_sheet->setCellValue("K$row", $tr->CHR_MINUTE);
                    $active_sheet->setCellValue("L$row", $tr->CHR_SECOND);
                    $active_sheet->setCellValue("M$row", $tr->CHR_MASTER_NO);
                    $active_sheet->setCellValue("N$row", $tr->INT_FLG_SCAN);
                    $active_sheet->setCellValue("O$row", $tr->CHR_SMALL_K1_UPP);
                    $active_sheet->setCellValue("P$row", $tr->CHR_SMALL_K1);
                    $active_sheet->setCellValue("Q$row", $tr->CHR_SMALL_K1_LOW);
                    $active_sheet->setCellValue("R$row", $tr->CHR_SMALL_K2_UPP);
                    $active_sheet->setCellValue("S$row", $tr->CHR_SMALL_K2);
                    $active_sheet->setCellValue("T$row", $tr->CHR_SMALL_K2_LOW);
                    $active_sheet->setCellValue("U$row", $tr->CHR_SMALL_H1_UPP);
                    $active_sheet->setCellValue("V$row", $tr->CHR_SMALL_H1);
                    $active_sheet->setCellValue("W$row", $tr->CHR_SMALL_H1_LOW);
                    $active_sheet->setCellValue("X$row", $tr->CHR_SMALL_H2_UPP);
                    $active_sheet->setCellValue("Y$row", $tr->CHR_SMALL_H2);
                    $active_sheet->setCellValue("Z$row", $tr->CHR_SMALL_H2_LOW);
                    $active_sheet->setCellValue("AA$row", $tr->CHR_MIDDLE_K1_UPP);
                    $active_sheet->setCellValue("AB$row", $tr->CHR_MIDDLE_K1);
                    $active_sheet->setCellValue("AC$row", $tr->CHR_MIDDLE_K1_LOW);
                    $active_sheet->setCellValue("AD$row", $tr->CHR_MIDDLE_K2_UPP);
                    $active_sheet->setCellValue("AE$row", $tr->CHR_MIDDLE_K2);
                    $active_sheet->setCellValue("AF$row", $tr->CHR_MIDDLE_K2_LOW);
                    $active_sheet->setCellValue("AG$row", $tr->CHR_MIDDLE_K3_UPP);
                    $active_sheet->setCellValue("AH$row", $tr->CHR_MIDDLE_K3);
                    $active_sheet->setCellValue("AI$row", $tr->CHR_MIDDLE_K3_LOW);
                    $active_sheet->setCellValue("AJ$row", $tr->CHR_MIDDLE_H2_UPP);
                    $active_sheet->setCellValue("AK$row", $tr->CHR_MIDDLE_H2);
                    $active_sheet->setCellValue("AL$row", $tr->CHR_MIDDLE_H2_LOW);
                    $active_sheet->setCellValue("AM$row", $tr->CHR_LARGE_H2_UPP);
                    $active_sheet->setCellValue("AN$row", $tr->CHR_LARGE_H2);
                    $active_sheet->setCellValue("AO$row", $tr->CHR_LARGE_H2_LOW);
                    $active_sheet->setCellValue("AP$row", $tr->CHR_LARGE_K2_UPP);
                    $active_sheet->setCellValue("AQ$row", $tr->CHR_LARGE_K2);
                    $active_sheet->setCellValue("AR$row", $tr->CHR_LARGE_K2_LOW);
                    $active_sheet->setCellValue("AS$row", $tr->CHR_LARGE_K3_UPP);
                    $active_sheet->setCellValue("AT$row", $tr->CHR_LARGE_K3);
                    $active_sheet->setCellValue("AU$row", $tr->CHR_LARGE_K3_LOW);
                    $active_sheet->setCellValue("AV$row", $tr->CHR_LARGE_K4_UPP);
                    $active_sheet->setCellValue("AW$row", $tr->CHR_LARGE_K4);
                    $active_sheet->setCellValue("AX$row", $tr->CHR_LARGE_K4_LOW);
                    $active_sheet->setCellValue("AY$row", $tr->CHR_MIN_UPP);
                    $active_sheet->setCellValue("AZ$row", $tr->CHR_MIN);
                    $active_sheet->setCellValue("BA$row", $tr->CHR_MIN_LOW);
                    $active_sheet->setCellValue("BB$row", $tr->CHR_POS_UPP);
                    $active_sheet->setCellValue("BC$row", $tr->CHR_POS);
                    $active_sheet->setCellValue("BD$row", $tr->CHR_POS_LOW);
                    
                    $active_sheet->setCellValue("BE$row", $tr->CHR_PRD_ORDER_NO . ' ' . $tr->CHR_SERIAL);
                    $active_sheet->setCellValue("BF$row", $tr->CHR_MODIFIED_DATE);
                    $active_sheet->setCellValue("BG$row", $tr->CHR_MODIFIED_TIME);
                    $active_sheet->setCellValue("BH$row", $tr->CHR_IDPALLET);
                    $active_sheet->setCellValue("BI$row", $tr->CHR_PARTNO_CUST);
                    $active_sheet->setCellValue("BJ$row", $tr->CHR_DATE_SCAN);
                    $active_sheet->setCellValue("BK$row", $tr->CHR_TIME_SCAN);
                    $active_sheet->setCellValue("BL$row", $tr->CHR_NOPO_SAP);
                    $active_sheet->setCellValue("BM$row", $tr->CHR_DATE_DELIVERY_ACT);
                }

                $no++;
                $row++;
            }

            $active_sheet_elina = $objPHPExcel->setActiveSheetIndexByName('ELINA');
            $active_sheet_quinsa = $objPHPExcel->setActiveSheetIndexByName('QUINSA');
            $row_elina = 2;
            $no_elina = 1;
            $no_quinsa = 1;
            $row_quinsa = 2;
            foreach ($list_lot_no as $lot) {
                $trace_elina = $this->tracebility_m->get_data_elina_by_lot_no($lot);
                if ($trace_elina->num_rows() > 0) {
                    foreach ($trace_elina->result() as $el) {
                        $active_sheet_elina->setCellValue("A$row_elina", $no_elina);
                        $active_sheet_elina->setCellValue("B$row_elina", $el->CHR_PRD_ORDER_NO);
                        $active_sheet_elina->setCellValue("C$row_elina", $el->CHR_PART_NO);
                        $active_sheet_elina->setCellValue("D$row_elina", $el->CHR_BACK_NO);
                        $active_sheet_elina->setCellValue("E$row_elina", $el->CHR_PART_NAME);
                        $active_sheet_elina->setCellValue("F$row_elina", $el->CHR_PDS_NO);
                        $active_sheet_elina->setCellValue("G$row_elina", $el->CHR_DATE_PDS);
                        $active_sheet_elina->setCellValue("H$row_elina", $el->CHR_TIME_PDS);
                        $active_sheet_elina->setCellValue("I$row_elina", $el->INT_QTY_PCS);
                        $active_sheet_elina->setCellValue("J$row_elina", $el->CHR_SOURCE);
                        $active_sheet_elina->setCellValue("K$row_elina", $el->CHR_PREPARE_AREA);
                        $active_sheet_elina->setCellValue("L$row_elina", $el->CHR_DATE_SCAN);
                        $active_sheet_elina->setCellValue("M$row_elina", $el->CHR_TIME_SCAN);
                        $active_sheet_elina->setCellValue("N$row_elina", $el->CHR_BARCODE);

                        $row_elina++;
                        $no_elina++;
                    }
                }

                $trace_quinsa = $this->tracebility_m->get_data_quinsa_by_lot_no($lot);
                if ($trace_quinsa->num_rows() > 0) {
                    foreach ($trace_quinsa->result() as $qa) {
                        $active_sheet_quinsa->setCellValue("A$row_quinsa", $no_quinsa);
                        $active_sheet_quinsa->setCellValue("B$row_quinsa", $qa->CHR_DOC_ID);
                        $active_sheet_quinsa->setCellValue("C$row_quinsa", $qa->CHR_REF_MASTER);
                        $active_sheet_quinsa->setCellValue("D$row_quinsa", $qa->CHR_LOT_NOMOR);
                        $active_sheet_quinsa->setCellValue("E$row_quinsa", $qa->CHR_PARTNO);
                        $active_sheet_quinsa->setCellValue("F$row_quinsa", $qa->CHR_PART_NM);
                        $active_sheet_quinsa->setCellValue("G$row_quinsa", $qa->CHR_MODEL_NM);
                        $active_sheet_quinsa->setCellValue("H$row_quinsa", $qa->CHR_EXEC_BY);
                        $active_sheet_quinsa->setCellValue("I$row_quinsa", $qa->CHR_INSPEC_TYPE);
                        $active_sheet_quinsa->setCellValue("J$row_quinsa", $qa->CHR_DIEHIGH);
                        $active_sheet_quinsa->setCellValue("K$row_quinsa", $qa->CHR_STATUS);
                        $active_sheet_quinsa->setCellValue("L$row_quinsa", $qa->CHR_CREATED_DATE);
                        $active_sheet_quinsa->setCellValue("M$row_quinsa", $qa->CHR_CREATED_TIME);
                        $active_sheet_quinsa->setCellValue("N$row_quinsa", $qa->CHR_SEQ);
                        $active_sheet_quinsa->setCellValue("O$row_quinsa", $qa->CHR_RECORD_TYPE);
                        $active_sheet_quinsa->setCellValue("P$row_quinsa", $qa->CHR_DEVICE_ID);
                        $active_sheet_quinsa->setCellValue("Q$row_quinsa", $qa->CHR_SAMPLING);
                        $active_sheet_quinsa->setCellValue("R$row_quinsa", $qa->CHR_STRATEGY);
                        $active_sheet_quinsa->setCellValue("S$row_quinsa", $qa->CHR_REPETITION);
                        $active_sheet_quinsa->setCellValue("T$row_quinsa", $qa->CHR_CHECK_POINT);
                        $active_sheet_quinsa->setCellValue("U$row_quinsa", $qa->CHR_TYPE);
                        $active_sheet_quinsa->setCellValue("V$row_quinsa", $qa->CHR_SPECIAL_CHAR);
                        $active_sheet_quinsa->setCellValue("W$row_quinsa", $qa->CHR_CONTROL);
                        $active_sheet_quinsa->setCellValue("X$row_quinsa", $qa->CHR_TARGET_SL);
                        $active_sheet_quinsa->setCellValue("Y$row_quinsa", $qa->CHR_RANGE_SL);
                        $active_sheet_quinsa->setCellValue("Z$row_quinsa", $qa->CHR_LSL);
                        $active_sheet_quinsa->setCellValue("AA$row_quinsa", $qa->CHR_USL);
                        $active_sheet_quinsa->setCellValue("AB$row_quinsa", $qa->CHR_UOM_SL);
                        $active_sheet_quinsa->setCellValue("AC$row_quinsa", $qa->CHR_TARGET_CL);
                        $active_sheet_quinsa->setCellValue("AD$row_quinsa", $qa->CHR_RANGE_CL);
                        $active_sheet_quinsa->setCellValue("AE$row_quinsa", $qa->CHR_LCL);
                        $active_sheet_quinsa->setCellValue("AF$row_quinsa", $qa->CHR_UCL);
                        $active_sheet_quinsa->setCellValue("AG$row_quinsa", $qa->CHR_UOM_CL);
                        $active_sheet_quinsa->setCellValue("AH$row_quinsa", $qa->CHR_QLT_CL);
                        $active_sheet_quinsa->setCellValue("AI$row_quinsa", $qa->CHR_QLT_VAL);
                        $active_sheet_quinsa->setCellValue("AJ$row_quinsa", $qa->CHR_RESULT);
                        $active_sheet_quinsa->setCellValue("AK$row_quinsa", $qa->CHR_STATUS);

                        $row_quinsa++;
                        $no_quinsa++;
                    }
                }
            }


            ob_end_clean();
            $filename = "Traceability Report $part_no (Prod date $start_date - $end_date).xls";
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="' . trim($filename) . '"');
            header('Cache-Control: max-age=0');

            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->setIncludeCharts(TRUE);
            $objWriter->save('php://output');
        }

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(342);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Traceability Data';
        $data['msg'] = $msg;

        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;

        $all_part_no = $this->tracebility_m->get_part_no_by_work_center($work_center);
        $all_dept_prod = $this->dept_m->get_all_prod_dept();
        $all_work_centers = $this->direct_backflush_general_m->get_work_center_by_id_dept($id_dept);

        $data['all_dept_prod'] = $all_dept_prod;
        $data['all_work_centers'] = $all_work_centers;
        $data['all_part_no'] = $all_part_no;
        $data['work_center'] = $work_center;
        $data['id_dept'] = $id_dept;
        $data['part_no'] = $part_no;

        $data['data'] = $trace_data;

        $data['content'] = 'quality/traceability/traceability_batch_' . strtolower(substr($work_center, 0, 4)) . '_v';
        $this->load->view($this->layout, $data);
    }

    public function get_data_elina_by_lot_no()
    {
        $prd_order = trim($this->input->post("lot_no"));

        $get_elina = $this->tracebility_m->get_data_elina_by_lot_no($prd_order);

        $data = '';
        $data .= '<div class="modal-wrapper">';
        $data .= '  <div class="modal-dialog">';
        $data .= '    <div class="modal-content">';
        $data .= '       <div class="modal-header">';
        $data .= '            <button type="button" onclick="hide_elina()" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>';
        $data .= '            <h4 class="modal-title" id="modalprogress"><strong>Historical Components Data</strong></h4>';
        $data .= '       </div>';

        $data .= '       <div class="modal-body">';
        $data .= '             <table id="dataTables1" style="font-size:10px;" class="table table-condensed table-striped table-hover display" cellspacing="0" width="100%">';
        $data .= '               <thead>';
        $data .= '                 <tr align="center">';
        $data .= '                   <th>No</th>';
        $data .= '                   <th>Part No</th>';
        $data .= '                   <th>Part Name</th>';
        $data .= '                   <th>Back No</th>';
        $data .= '                   <th>Area</th>';
        $data .= '                   <th>PDS No</th>';
        $data .= '                   <th>PDS Date</th>';
        $data .= '                   <th>PDS Time</th>';
        $data .= '                   <th>Supplier</th>';
        $data .= '                   <th>Scan Date</th>';
        $data .= '                   <th>Scan Time</th>';
        $data .= '                 </tr>';
        $data .= '               </thead>';
        $data .= '               <tbody>';

        if ($get_elina->num_rows() != 0) {
            $no = '1';
            foreach ($get_elina->result() as $row) {
                $data .= '<tr align="center">';
                $data .= '<td>' . $no . '</td>';
                $data .= '<td>' . trim($row->CHR_PART_NO) . '</td>';
                $data .= '<td>' . trim($row->CHR_PART_NAME) . '</td>';
                $data .= '<td>' . trim($row->CHR_BACK_NO) . '</td>';

                if (trim($row->CHR_PREPARE_AREA) == 'A') {
                    $data .= '<td>CKD</td>';
                } else if (trim($row->CHR_PREPARE_AREA) == 'B') {
                    $data .= '<td>OH</td>';
                } else {
                    $data .= '<td>IH</td>';
                }

                if ($row->CHR_PDS_NO != NULL && $row->CHR_PDS_NO != '') {
                    $data .= '<td>' . trim($row->CHR_PDS_NO) . '</td>';
                } else {
                    $data .= '<td>-</td>';
                }

                if ($row->CHR_DATE_PDS != NULL && $row->CHR_DATE_PDS != '') {
                    $data .= '<td>' . substr($row->CHR_DATE_PDS, 0, 4) . '/' . substr($row->CHR_DATE_PDS, 4, 2) . '/' . substr($row->CHR_DATE_PDS, 6, 2) . '</td>';
                } else {
                    $data .= '<td>-</td>';
                }

                if ($row->CHR_TIME_PDS != NULL && trim($row->CHR_TIME_PDS) != '' && trim($row->CHR_TIME_PDS) != 'NULL') {
                    $data .= '<td>' . substr($row->CHR_TIME_PDS, 0, 2) . ':' . substr($row->CHR_TIME_PDS, 2, 2) . ':' . substr($row->CHR_TIME_PDS, 4, 2) . '</td>';
                } else {
                    $data .= '<td>-</td>';
                }

                if ($row->CHR_SOURCE != NULL && $row->CHR_SOURCE != '') {
                    $data .= '<td>' . trim($row->CHR_SOURCE) . '</td>';
                } else {
                    $data .= '<td>-</td>';
                }

                if ($row->CHR_DATE_SCAN != NULL && $row->CHR_DATE_SCAN != '') {
                    $data .= '<td>' . substr($row->CHR_DATE_SCAN, 0, 4) . '/' . substr($row->CHR_DATE_SCAN, 4, 2) . '/' . substr($row->CHR_DATE_SCAN, 6, 2) . '</td>';
                } else {
                    $data .= '<td>-</td>';
                }

                if ($row->CHR_TIME_SCAN != NULL && $row->CHR_TIME_SCAN != '') {
                    $data .= '<td>' . substr($row->CHR_TIME_SCAN, 0, 2) . ':' . substr($row->CHR_TIME_SCAN, 2, 2) . ':' . substr($row->CHR_TIME_SCAN, 4, 2) . '</td>';
                } else {
                    $data .= '<td>-</td>';
                }

                $data .= '</tr>';
                $no++;
            }
        }

        $data .= '               </tbody>';
        $data .= '             </table>';
        $data .= '        </div>';

        $data .= '    </div>';
        $data .= '  </div>';
        $data .= '</div>';
        $data .= '<script src="' . base_url('assets/plugins/jquery-datatables/js/jquery.dataTables.min.js') . '"></script>';
        $data .= '<script src="' . base_url('assets/plugins/jquery-datatables/js/dataTables.bootstrap.js') . '"></script>';

        $data .= '<script src="' . base_url('assets/js/datatables.js') . '"></script>';
        $data .= '<script src="' . base_url('assets/js/dataTables.tableTools.js') . '"></script>';

        echo $data;
    }

    public function get_data_quinsa_by_lot_no()
    {
        $prd_order = trim($this->input->post("order_no"));

        $get_quinsa = $this->tracebility_m->get_data_quinsa_by_lot_no($prd_order);

        $data = '';
        $data .= '<div class="modal-wrapper">';
        $data .= '  <div class="modal-dialog">';
        $data .= '    <div class="modal-content" style="width: 55%;align:middle;">';
        $data .= '       <div class="modal-header">';
        $data .= '            <button type="button" onclick="hide_quinsa()" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>';
        $data .= '            <h4 class="modal-title" id="modalprogress"><strong>Inspection Data</strong></h4>';
        $data .= '       </div>';

        $data .= '       <div class="modal-body" style="width: 100%; overflow-x: scroll;">';
        $data .= '             <table id="dataTables2" style="font-size: 8px;" class="table table-condensed table-striped table-hover display" cellspacing="0" width="100%">';
        $data .= '               <thead>';
        $data .= '                 <tr align="center">';
        $data .= '                   <th>No</th>';
        $data .= '                   <th>Doc ID</th>';
        $data .= '                   <th>Ref Master</th>';
        $data .= '                   <th>Model</th>';
        $data .= '                   <th>Exec By</th>';
        $data .= '                   <th>Insp. Type</th>';
        $data .= '                   <th>Record Type</th>';
        $data .= '                   <th>Device ID</th>';
        $data .= '                   <th>Method</th>';
        $data .= '                   <th>Sampling</th>';
        $data .= '                   <th>Repetition</th>';
        $data .= '                   <th>Check Point</th>';
        $data .= '                   <th>Type</th>';
        $data .= '                   <th>Special Char.</th>';
        $data .= '                   <th>Control</th>';
        $data .= '                   <th>Target SL</th>';
        $data .= '                   <th>Range SL</th>';
        $data .= '                   <th>LSL</th>';
        $data .= '                   <th>USL</th>';
        $data .= '                   <th>UoM SL</th>';
        $data .= '                   <th>Target CL</th>';
        $data .= '                   <th>Range CL</th>';
        $data .= '                   <th>LCL</th>';
        $data .= '                   <th>UCL</th>';
        $data .= '                   <th>UoM CL</th>';
        $data .= '                   <th>QLT CL</th>';
        $data .= '                   <th>QLT Val</th>';
        $data .= '                   <th>Result</th>';
        $data .= '                   <th>Status</th>';
        $data .= '                   <th>Date</th>';
        $data .= '                   <th>Time</th>';
        $data .= '                 </tr>';
        $data .= '               </thead>';
        $data .= '               <tbody>';

        if ($get_quinsa->num_rows() != 0) {
            $no = '1';
            foreach ($get_quinsa->result() as $row) {
                $data .= '<tr align="center">';
                $data .= '<td>' . $no . '</td>';
                $data .= '<td>' . trim($row->CHR_DOC_ID) . '</td>';
                $data .= '<td>' . trim($row->CHR_REF_MASTER) . '</td>';
                $data .= '<td>' . trim($row->CHR_MODEL_NM) . '</td>';
                $data .= '<td>' . trim($row->CHR_EXEC_BY) . '</td>';
                $data .= '<td>' . trim($row->CHR_INSPEC_TYPE) . '</td>';
                $data .= '<td>' . trim($row->CHR_RECORD_TYPE) . '</td>';
                $data .= '<td>' . trim($row->CHR_DEVICE_ID) . '</td>';
                $data .= '<td>' . trim($row->CHR_SAMPLING) . '</td>';
                $data .= '<td>' . trim($row->CHR_STRATEGY) . '</td>';
                $data .= '<td>' . trim($row->CHR_REPETITION) . '</td>';
                $data .= '<td>' . trim($row->CHR_CHECK_POINT) . '</td>';
                $data .= '<td>' . trim($row->CHR_TYPE) . '</td>';
                $data .= '<td>' . trim($row->CHR_SPECIAL_CHAR) . '</td>';
                $data .= '<td>' . trim($row->CHR_CONTROL) . '</td>';
                $data .= '<td>' . trim($row->CHR_TARGET_SL) . '</td>';
                $data .= '<td>' . trim($row->CHR_RANGE_SL) . '</td>';
                $data .= '<td>' . trim($row->CHR_LSL) . '</td>';
                $data .= '<td>' . trim($row->CHR_USL) . '</td>';
                $data .= '<td>' . trim($row->CHR_UOM_SL) . '</td>';
                $data .= '<td>' . trim($row->CHR_TARGET_CL) . '</td>';
                $data .= '<td>' . trim($row->CHR_RANGE_CL) . '</td>';
                $data .= '<td>' . trim($row->CHR_LCL) . '</td>';
                $data .= '<td>' . trim($row->CHR_UCL) . '</td>';
                $data .= '<td>' . trim($row->CHR_UOM_CL) . '</td>';
                $data .= '<td>' . trim($row->CHR_QLT_CL) . '</td>';
                $data .= '<td>' . trim($row->CHR_QLT_VAL) . '</td>';
                $data .= '<td>' . trim($row->CHR_RESULT) . '</td>';
                $data .= '<td>' . trim($row->CHR_STATUS) . '</td>';
                $data .= '<td>' . trim($row->CHR_CREATED_DATE) . '</td>';
                $data .= '<td>' . trim($row->CHR_CREATED_TIME) . '</td>';

                $data .= '</tr>';
                $no++;
            }
        }


        $data .= '               </tbody>';
        $data .= '             </table>';
        $data .= '        </div>';

        $data .= '    </div>';
        $data .= '  </div>';
        $data .= '</div>';
        $data .= '<script src="' . base_url('assets/plugins/jquery-datatables/js/jquery.dataTables.min.js') . '"></script>';
        $data .= '<script src="' . base_url('assets/plugins/jquery-datatables/js/dataTables.bootstrap.js') . '"></script>';
        $data .= '<script src="' . base_url('assets/js/dataTables.fixedColumns.min.js') . '"></script>';
        $data .= '<script src="' . base_url('assets/js/datatables.js') . '"></script>';
        $data .= '<script src="' . base_url('assets/js/dataTables.tableTools.js') . '"></script>';
        // $data .= '<script>';
        // $data .= '$(document).ready(function() {';
        // $data .= '   $("#dataTables2").DataTable({';
        // $data .= '        scrollX: true,';
        // $data .= '        lengthMenu: [[10, 25, 50, -1], [10, 25, 50]],';
        // $data .= '        fixedColumns: {';
        // $data .= '           leftColumns: 2,';
        // $data .= '           rightColumns: 1';                
        // $data .= '        }';
        // $data .= '    });';
        // $data .= '});';
        // $data .= '</script>';

        echo $data;
    }

    public function get_trace_delivery_ascc(){    
        $id_qrcode = $this->input->post("id_code");
        $work_center = $this->input->post('wcenter');
        $data = '';

        $get_trace_forward = $this->tracebility_m->get_data_trace_forward_ascc($id_qrcode, $work_center); 
        if($get_trace_forward->num_rows() > 0){                
            $data_traceforward = $get_trace_forward->row(); 

            $data .= '<div class="modal-wrapper">';
            $data .= '      <div class="modal-dialog">';                                 
            $data .= '          <div class="modal-content">';
            $data .= '              <div class="modal-header">';
            $data .= '                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>';
            $data .= '                  <h4 class="modal-title" id="modalprogress">TRACE FORWARD</h4>';
            $data .= '              </div>';

            $data .= '              <div class="modal-body">';
            $data .= '                  <h5 class="modal-title" id="modalprogress">Detail Part</h5>';
            $data .= '                  <br>';
            $data .= '                  <table id="example" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">';
            $data .= '                      <thead>';
            $data .= '                         <tr align="center">';
            $data .= '                             <td>Part No</td>';
            $data .= '                             <td>Part No Cust</td>';
            $data .= '                             <td>Back No</td>';
            $data .= '                             <td>ID Kanban</td>';                                                  
            $data .= '                         </tr>';
            $data .= '                      </thead>';
            $data .= '                      <tbody>';
            $data .= '                          <tr align="center">';
            $data .= '                              <td>' . $data_traceforward->CHR_PART_NO . '</td>';
            $data .= '                              <td>' . $data_traceforward->CHR_PARTNO_CUST . '</td>';
            $data .= '                              <td>' . $data_traceforward->CHR_BACK_NO . '</td>';   
            $data .= '                              <td><strong>' . $data_traceforward->CHR_KANBAN_NO . '</strong></td>';
            $data .= '                          </tr>';
            $data .= '                      </tbody>';
            $data .= '                  </table>';
            $data .= '                  <h5 class="modal-title" id="modalprogress">Packing / Pallet</h5>';
            $data .= '                  <br>';
            $data .= '                  <table id="example2" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">';
            $data .= '                      <thead>';
            $data .= '                          <tr align="center">';
            $data .= '                              <td>ID Packing</td>';
            $data .= '                              <td>ID Pallet</td>';                                                    
            $data .= '                              <td>Qty</td>';
            $data .= '                              <td>Qty/Box</td>';                                                   
            $data .= '                              <td>Plan Delivery</td>';
            $data .= '                              <td>Date Scan</td>';
            $data .= '                              <td>Time Scan</td>';
            $data .= '                          </tr>';
            $data .= '                      </thead>';
            $data .= '                      <tbody>';
            $data .= '                          <tr align="center">';
            $data .= '                              <td>' . $data_traceforward->CHR_IDPACKING . '</td>';
            $data .= '                              <td><strong>' . $data_traceforward->CHR_IDPALLET . '</strong></td>';                                                    
            $data .= '                              <td>' . $data_traceforward->INT_QTY . '</td>';
            $data .= '                              <td>' . $data_traceforward->INT_QTY_PER_BOX . '</td>';                                                    
            $data .= '                              <td>' . substr($data_traceforward->CHR_DATE_DELIVERY,6,2) . '/' . substr($data_traceforward->CHR_DATE_DELIVERY,4,2) . '/' . substr($data_traceforward->CHR_DATE_DELIVERY,0,4) . '</td>';
            $data .= '                              <td>' . substr($data_traceforward->CHR_DATE_SCAN,6,2) . '/' . substr($data_traceforward->CHR_DATE_SCAN,4,2) . '/' . substr($data_traceforward->CHR_DATE_SCAN,0,4) . '</td>';
            $data .= '                              <td>' . substr($data_traceforward->CHR_TIME_SCAN,0,2) . ':' . substr($data_traceforward->CHR_TIME_SCAN,2,2) . ':' . substr($data_traceforward->CHR_TIME_SCAN,4,2) . '</td>';
            $data .= '                          </tr>';
            $data .= '                      </tbody>';
            $data .= '                  </table>';
            $data .= '                  <h5 class="modal-title" id="modalprogress">Picking List</h5>';
            $data .= '                  <br>';
            $data .= '                  <table id="example3" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">';
            $data .= '                      <thead>';
            $data .= '                          <tr align="center">';                                                    
            $data .= '                              <td>Picking List</td>';
            $data .= '                              <td>No PO</td>';
            $data .= '                              <td>Cust Dest</td>';
            $data .= '                              <td>Dock</td>';
            $data .= '                              <td>Actual Delivery</td>';
            $data .= '                              <td>GI Status</td>';
            $data .= '                          </tr>';
            $data .= '                      </thead>';
            $data .= '                      <tbody>';
            $data .= '                          <tr align="center">';                                                    
            $data .= '                              <td><strong>' . $data_traceforward->CHR_DEL_NO . '</strong></td>';
            $data .= '                              <td>' . $data_traceforward->CHR_NOPO_SAP . '</td>';
            $data .= '                              <td>' . $data_traceforward->CHR_CUS_DEST . '</td>';
            $data .= '                              <td>' . $data_traceforward->CHR_DOK_NO . '</td>';
            $data .= '                              <td>' . substr($data_traceforward->CHR_DEL_DATE_ACT,6,2) . '/' . substr($data_traceforward->CHR_DEL_DATE_ACT,4,2) . '/' . substr($data_traceforward->CHR_DEL_DATE_ACT,0,4) . '</td>';
            $data .= '                              <td>' . $data_traceforward->CHR_GI_DEL . '</td>';
            $data .= '                         </tr>';
            $data .= '                      </tbody>';
            $data .= '                  </table>';
            $data .= '              </div>';
            $data .= '          </div>';
            $data .= '      </div>';
            $data .= '</div>';
            
        } else {
            $data_traceforward = "NULL";
        }

        echo $data;
    }
}
