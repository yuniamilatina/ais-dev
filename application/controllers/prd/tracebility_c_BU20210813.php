<?php

class tracebility_c extends CI_Controller {

    private $layout = '/template/head';
    private $back_to_manage = 'prd/tracebility_c/index/';
    private $back_to_manage_ascc = 'prd/tracebility_c/tracebility_ascc/';
    //private $back_to_approve = 'helpdesk_ticket/helpdesk_ticket_c/prepare_approve_ticket/';
    //public $id_function = '283';

    public function __construct() {
        parent::__construct();
        $this->load->model('prd/tracebility_m');
        $this->load->model('basis/log_m');
        $this->load->model('basis/role_module_m');
        $this->load->model('basis/user_m');
        $this->load->model('portal/notification_m');
        $this->load->model('portal/news_m');        
    }

    function index($msg = NULL) {
        $this->load->model('prd/tracebility_m');
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

    function tracebility_ascc($msg = NULL, $work_center = NULL) {
        $this->load->model('prd/tracebility_m');
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

        if($work_center == NULL){
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
    function tracebility() {
        $this->load->model('prd/tracebility_m');        
        
        $id_qrcode = $this->input->post('id_qrcode');
        if (!empty($id_qrcode)) {
            // 021118134253023
            // 181112093236999

            $date = substr($id_qrcode,0,6);
            $hour = substr($id_qrcode,6,6);
            $hour2 = substr($id_qrcode,6,5);

            $datetimeprod = date('d-M-Y', strtotime($date)) . "  " . date('h:i:s', strtotime($hour));

            //set date
            $day = substr($date,0,2);
            $month = substr($date,2,2);
            $year = substr($date,4,2);
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

        }
        else {
            echo '<script>alert("Data QR tidak ditemukan");</script>';
            redirect('prd/tracebility_c/index', 'refresh');
        }
            
    }

    //get data tracebility by ANU
    function tracebility_new($msg = null) {
        $this->load->model('prd/tracebility_m');

        $data['msg'] = $msg;
        
        $id_qrcode = $this->input->post('id_qrcode');
        // print_r($id_qrcode);
        // exit();

        if (!empty($id_qrcode)) {
            // 181112093236999
            $date = substr($id_qrcode,0,6);
            $hour = substr($id_qrcode,6,6);
            $hour2 = substr($id_qrcode,6,5);
            $date2 = "20" . $date;

            // 190109
            $datetimeprod = date('d-M-Y', strtotime($date2)) . "  " . date('h:i:s', strtotime($hour));
            //set date
            $day = (int) substr($date,4,2);
            $month = (int) substr($date,2,2);
            $year = (int) substr($date,0,2);
            $year = "20" . $year;

            $h = (int) substr($id_qrcode,6,2);
            $m = (int) substr($id_qrcode,8,2);
            $s = (int) substr($id_qrcode,10,2);
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
            if($id_one_way == NULL){
                $get_trace_forward = $this->tracebility_m->get_data_trace_forward($id_qrcode); 
                if($get_trace_forward->num_rows() > 0){                
                    $data_traceforward = $get_trace_forward->row();                
                } else {
                    $data_traceforward = "NULL";
                }
            } else {
                $get_trace_forward = $this->tracebility_m->get_data_trace_forward_v2($id_qrcode); 
                if($get_trace_forward->num_rows() > 0){                
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
    function get_tracebility_ascc($msg = null) {
        $this->load->model('prd/tracebility_m');

        $data['msg'] = $msg;
        
        $work_center = $this->input->post('work_center');
        $id_qrcode = $this->input->post('id_qrcode');

        if (!empty($id_qrcode)) {
            // 181112093236999
            $date = substr($id_qrcode,0,6);
            $hour = substr($id_qrcode,6,6);
            $hour2 = substr($id_qrcode,6,5);
            $date2 = "20" . $date;

            // 190109
            $datetimeprod = date('d-M-Y', strtotime($date2)) . "  " . date('h:i:s', strtotime($hour));
            //set date
            $day = (int) substr($date,4,2);
            $month = (int) substr($date,2,2);
            $year = (int) substr($date,0,2);
            $year = "20" . $year;

            $h = (int) substr($id_qrcode,6,2);
            $m = (int) substr($id_qrcode,8,2);
            $s = (int) substr($id_qrcode,10,2);
            $date_created = $year . "" . $month . "" . $day;

            //get data production order no from TT_DATA_TESTER
            if($work_center == 'ASCC05'){
                $get_data_tester = $this->tracebility_m->get_data_tester_ascc05($year, $month, $day, $h, $m, $s);                
            } else {
                //=== For another line of ASCC - Not yet implemented
                $get_data_tester = $this->tracebility_m->get_data_tester_ascc05($year, $month, $day, $h, $m, $s);
            }
            
            $prd_order = $get_data_tester->CHR_PRD_ORDER_NO;
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
            $data['sidebar'] = $this->role_module_m->side_bar(285);

            $this->load->view($this->layout, $data);

        } else {
            echo '<script>alert("Data QR tidak ditemukan");</script>';
            redirect('prd/tracebility_c/tracebility_ascc', 'refresh');
        }
            
    }
}
