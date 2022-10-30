<?php

class master_line_part_c extends CI_Controller {

    private $layout = '/template/head';
    private $back_to_upload = 'pes/part_per_line_c/upload_data_part/';
    private $back_to_manage = 'raw_material/master_line_part_c/index/';

    public function __construct() {
        parent::__construct();
        $this->load->model('basis/log_m');
        $this->load->model('basis/role_module_m');
        $this->load->model('portal/news_m');
        $this->load->model('portal/notification_m');
        $this->load->model('raw_material/master_part_line_m');
        $this->load->model('quality/inspection_m');
        $this->load->model('ines/ines_m');
        $this->load->model('organization/dept_m');
        $this->load->model('pes_new/report_prod_part_ng_ok_m');
        $this->load->model('patricia/master_spec_part_m');   
    }

    function index($msg = NULL) {
        $this->role_module_m->authorization('3');

        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>x</button><strong>Creating success </strong> The data is successfully created </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>x</button><strong>Updating success </strong> The data is successfully updated </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>x</button><strong>Deleted success </strong> The data is successfully deleted </div >";
        } elseif ($msg == 4) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>x</button><strong>Data Already Exist !</strong> Silahkan input data part yang lainnya</div >";
        } elseif ($msg == 5) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>x</button>Data Sudah Aktif Kembali</div >";
        }
                
        $data['content'] = 'raw_material/master_part_line/manage_part_line_v';
        $data['title'] = 'Master Device Inpection';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(258);
        $data['news'] = $this->news_m->get_news();
        $data['msg'] = $msg;        
        
        $data['data_dev'] = $this->inspection_m->get_data_dev();
        $this->load->view($this->layout, $data);
    }
    
    function create_data() {
        $data['content'] = 'raw_material/master_part_line/create_data_dev_v';
        $data['title'] = 'Add Inspection Device';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(258);
        $data['news'] = $this->news_m->get_news();
        $data['data_line'] = $this->master_spec_part_m->get_line_prd();
        
        $this->load->view($this->layout, $data);
    }

    function save_device() {
        // $mssql = $this->load->database("mssql", TRUE);
        $time_now = date("His");
        $dtnow = date("Ymd");
    	// $line = trim($this->input->post('CHR_LINE'));
        $devnm = trim($this->input->post('CHR_DEV_NM'));
        $devnm = strtoupper($devnm);
        $caldate = date("Ymd", strtotime($this->input->post('CHR_CAL_DATE')));
        $session = $this->session->all_userdata();

        $cek_seq = $this->db->query("SELECT TOP 1 * FROM TM_SEQUENCE_01 WHERE CHR_COD_EXE = 'DEV-QU'");
        if ($cek_seq->num_rows() == 0){
            $ist_seq = $this->db->query("insert into TM_SEQUENCE_01 (CHR_COD_EXE,CHR_DATE_CREATED,CHR_KEY1,INT_SERIAL_NUMBER) values ('DEV-QU','$dtnow','J901','1')");
            $noseq = 1;
        } else {
            $seq_d = $cek_seq->result();
            $noseq = $seq_d[0]->INT_SERIAL_NUMBER;
            $noseq = $noseq + 1;
            $upt_seq = $this->db->query("update TM_SEQUENCE_01 set INT_SERIAL_NUMBER='$noseq' where CHR_COD_EXE = 'DEV-QU'");
        }
        $seq = strlen($noseq);
        switch ($seq) {
            case 0:
                $x = "00000";
                break;
            case 1:
                $x = "00000";
                break;
            case 2:
                $x = "0000";
                break;
            case 3:
                $x = "000";
                break;
        }
        $dev_id = "DEV-QU-". $x . $noseq;
        
        $data_pl = $this->inspection_m->check_dev($dev_id);
        if ($data_pl == 0) {            
            $data = array(
            'CHR_DEVICE_ID' => $dev_id,
            'CHR_DEVICE_NAME' => $devnm,
            // 'CHR_LINE' => $line,
            'CHR_CALBR_DATE' => $caldate,
            'CHR_CREATED_BY' => $session['NPK'],
            'CHR_CREATED_TIME' => $time_now,
            'CHR_CREATED_DATE' => date("Ymd")
            );
            $this->inspection_m->save_dev($data);
            
            redirect($this->back_to_manage . $msg = 1);
        }else{
            redirect($this->back_to_manage . $msg = 4);
        }        
    }

    function edit_dt_dev($id) {
        $this->role_module_m->authorization('3');
        $data['data'] = $this->inspection_m->get_id_dev($id);
        $data['data_line'] = $this->master_spec_part_m->get_line_prd();

        $data['content'] = 'raw_material/master_part_line/edit_data_dev_v';
        $data['title'] = 'Edit Data Device';
        $data['news'] = $this->news_m->get_news();
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(258);

        $this->load->view($this->layout, $data);
    }

    public function update_dt_dev() {
        $this->load->library('upload');
        $session = $this->session->all_userdata();
        $id = $this->input->post('CHR_ID');
        $devnm = strtoupper($this->input->post('CHR_DEV_NM'));
        // $line = $this->input->post('CHR_LINE');
        $cal = $this->input->post('CHR_CAL_DATE');

        //===== Edit by ANU - 20211018
        //===== Change date format
        $cal = date("Ymd", strtotime($cal));
        //===== End ANU

        $upload_date = date('Ymd');
        $upload_time = date('His');
        
        $data = array(
            'CHR_DEVICE_NAME' => $devnm,
            // 'CHR_LINE' => $line,
            'CHR_CALBR_DATE' => $cal,
            'CHR_MODIFIED_BY' => $session['NPK'],
            'CHR_MODIFIED_TIME' => date("His"),
            'CHR_MODIFIED_DATE' => date("Ymd")
            );
        $this->inspection_m->edit_dev($data,$id);
        
        redirect($this->back_to_manage . $msg = 2);
    }

    function delete_dt_dev($int_id) {
        $this->inspection_m->delete_device($int_id);
        redirect($this->back_to_manage . $msg = 3);
    }

    function undelete_dt_dev($int_id) {
        $this->inspection_m->undelete_device($int_id);
        redirect($this->back_to_manage . $msg = 5);
    }
    
    function reset() {
        $this->part_per_line_m->truncate_temp_data();
        redirect($this->back_to_manage);
    }
   
    function prepare_data_part_line() {
        $this->part_per_line_m->truncate_temp_data();
        redirect($this->back_to_upload);
    }
    
    function edit_part_line($pno,$wcr) {
        $data['content'] = 'raw_material/master_part_line/edit_part_line_v';
        $data['title'] = 'Edit Data Part Per Area';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(249);
        $data['news'] = $this->news_m->get_news();

        $data['data'] = $this->master_part_line_m->get_data_by_id($pno,$wcr);

        $this->load->view($this->layout, $data);
    }
    
    function update_part_line() {
        $this->form_validation->set_rules('CHR_FLAG', 'Stat Aktif', 'required|alpha|char|max_length[1]|min_length[1]');
        
        $pno = $this->input->post('CHR_PNO');
//        $bno = $this->input->post('CHR_BNO');
        $wcr = $this->input->post('CHR_WTR');
        $flag = $this->input->post('CHR_FLAG');
        $flag= strtoupper($flag);
        
        if ($this->form_validation->run() == FALSE) {
            $this->edit_part_line($pno,$wcr);
        } else {
            $data_array = array(
                'CHR_MAIN_STAT' => $flag                
//                'CHR_NPK_UPDATE' => $this->session->userdata('NPK'),
//                'CHR_TIME_UPDATE' => date('His'),
//                'CHR_DATE_UPDATE' => date('Ymd')
            );

            $this->master_part_line_m->update($data_array, $pno,$wcr);
            redirect($this->back_to_manage . $msg = 2);
        }
    }
    
    function new_data_part($part_no = NULL,$back_no = NULL) {
        $this->role_module_m->authorization('14');
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['news'] = $this->news_m->get_news();
        $data['sidebar'] = $this->role_module_m->side_bar(249);
        $session = $this->session->all_userdata();

        $data['title'] = 'New Data Part Per Line';
        $data['part_no_all'] = $this->part_per_line_m->get_all_partno();
        $data['part_no'] = $part_no;
        $data['back_no_all'] = $this->part_per_line_m->get_all_backno();
        $data['back_no'] = $back_no;
//        $data['getFeedback'] = $this->master_feedback_m->get_data_feedback();
//        $data['getMessage'] = $this->master_message_m->get_data_message();

        $data['content'] = 'pes/part_per_line/create_data_per_line_v';
        $this->load->view($this->layout, $data);
    }
    
    function save_data_part() {
        $pno = trim($this->input->post('CHR_PART_NO'));
        $bno = trim($this->input->post('CHR_BACK_NO'));
//        $wrkctr = $this->input->post('CHR_WC');
        $cat = $this->input->post('CHR_CAT');
        $session = $this->session->all_userdata();

//        if (date('G') < 6) {
//            $date = date('Ymd', strtotime(date('Ymd') . ' - 1 days'));
//        } else {
//            $date = date('Ymd');
//        }
//
        $data_prod = $this->db->query("SELECT TOP 1 * FROM PRD.TM_PART_PER_LINE WHERE CHR_PART_NO = '$pno' and CHR_BACK_NO = '$bno' and CHR_CAT='$cat'");
//        $data_prod = $this->db->query("SELECT TOP 1 * FROM PRD.TM_PART_PER_LINE WHERE CHR_PART_NO = '$pno' and CHR_BACK_NO = '$bno' and CHR_WORK_CTR='$wrkctr' and CHR_CAT='$cat'");
        if ($data_prod->num_rows() == 0){
            $data_part = array(
            'CHR_PART_NO' => $pno,
            'CHR_BACK_NO' => $bno,
//            'CHR_WORK_CTR' => strtoupper($wrkctr),
            'CHR_CAT' => $cat,
            'CHR_NPK_CREATE' => $session['NPK'],
            'CHR_DATE_CREATE' => date("Ymd"),
            'CHR_TIME_CREATE' => date("His")
            );
            $this->part_per_line_m->save_dt($data_part);

            redirect($this->back_to_manage . $msg = 1);
        }else{
            redirect($this->back_to_manage . $msg = 4);
        }        
    }
    
    public function search_by($msg = NULL) {
//        $this->role_module_m->authorization('16');

        $sloc = NULL;
        if ($this->input->post('DL') != '') {
            $data['checkboxDL'] = 'checked';
            $sloc = $this->input->post('DL');
        } else {
            $data['checkboxDL'] = '';
        }
        if ($this->input->post('BP') != '') {
            $data['checkboxBP'] = 'checked';
            $sloc = $this->input->post('BP');
        } else {
            $data['checkboxBP'] = '';
        }
        if ($this->input->post('CC') != '') {
            $data['checkboxCC'] = 'checked';
            $sloc = $this->input->post('CC');
        } else {
            $data['checkboxCC'] = '';
        }
        if ($this->input->post('CD') != '') {
            $data['checkboxCD'] = 'checked';
            $sloc = $this->input->post('CD');
        } else {
            $data['checkboxCD'] = '';
        }
        
//        if ($this->input->post('isNegatife') != '') {
//            $data['checkedNeg'] = 'checked';
//        } else {
//            $data['checkedNeg'] = '';
//        }

        $data['content'] = 'raw_material/master_part_line/manage_part_line_v';
        $data['title'] = 'Master Part Per Line';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(258);
        $data['news'] = $this->news_m->get_news();
        $data['msg'] = $msg;
        $data['data_stock'] = $this->master_part_line_m->select_data_part_by($sloc);
//        $data['total'] = $this->report_stock_m->total_data_stock_by($this->input->post('isNegatife'), $sloc);
//        $data['acquired_date'] = $this->report_stock_m->select_acquired_date();
//        $data['load_to_sql'] = $this->report_stock_m->is_load_to_sql();
        $this->load->view($this->layout, $data);
    }
}
