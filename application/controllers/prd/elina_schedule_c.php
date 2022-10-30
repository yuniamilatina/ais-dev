<?php

class elina_schedule_c extends CI_Controller {

    private $layout = '/template/head';
    // private $back_to_upload = 'pes/part_per_line_c/upload_data_part/';
    private $back_to_manage = 'prd/elina_schedule_c/index/';

    public function __construct() {
        parent::__construct();

        $this->load->model('prd/elina_schedule_m');
        $this->load->model('ines/ines_m');
        $this->load->model('organization/dept_m');
        $this->load->model('pes_new/report_prod_part_ng_ok_m');
        $this->load->helper(array('form', 'url', 'inflector'));
        $this->load->library(array('PHPExcel', 'PHPExcel/IOFactory'));
    }

    function index($msg = NULL) {
        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Creating success </strong> The data is successfully created </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Updating success </strong> The data is successfully updated </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Deleted success </strong> The data is successfully deleted </div >";
        } elseif ($msg == 4) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Data Already Exist !</strong> Silahkan input data part yang lainnya</div >";
        }
                
        $data['content'] = 'prd/elina_schedule/manage_elina_schedule_v';
        $data['title'] = 'Schedule ELINA Order';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(290);
        $data['news'] = $this->news_m->get_news();
        $data['msg'] = $msg;
        $data['checkboxDL'] = '';
        $data['checkboxBP'] = '';
        $data['checkboxCC'] = '';
        $data['checkboxCD'] = '';
        $data['checkboxST'] = '';
        $data['checkboxIN'] = '';
        
        $data['dt_schedule'] = $this->elina_schedule_m->select_data();
        $this->load->view($this->layout, $data);
    }
    
    
    
    function reset() {
        $this->part_per_line_m->truncate_temp_data();
        redirect($this->back_to_manage);
    }
   
    
    function edit_schedule($id) {
        $data['content'] = 'prd/elina_schedule/edit_elina_schedule_v';
        $data['title'] = 'Edit Schedule ELINA';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(290);
        $data['news'] = $this->news_m->get_news();

        $data['data'] = $this->elina_schedule_m->get_data_by_id($id);

        $this->load->view($this->layout, $data);
    }
    
    function update_schedule() {
        $this->form_validation->set_rules('CHR_FLAG', 'Stat Aktif', 'required|alpha|char|max_length[1]|min_length[1]');
        $this->form_validation->set_rules('CHR_TIME', 'Time', 'required|trim|max_length[4]|min_length[1]');

        $id = $this->input->post('CHR_ID');
        $func = $this->input->post('CHR_FUNCTION');
        $time = $this->input->post('CHR_TIME');
        $flag = $this->input->post('CHR_FLAG');
        $flag= strtoupper($flag);
        
        if ($this->form_validation->run() == FALSE) {
            $this->edit_schedule($id);
        } else {
            $data_array = array(
                'CHR_TIME_EXEC'    => $time,
                'CHR_FUNCTION'    => $func,         
                'CHR_FLAG_DELETE' => $flag,       
                'CHR_USER_CREATE' => $this->session->userdata('NPK'),
                'CHR_CREATE_TIME' => date('His'),
                'CHR_CREATE_DATE' => date('Ymd')
            );

            $this->elina_schedule_m->update($data_array, $id);
            redirect($this->back_to_manage . $msg = 2);
        }
    }
    
    function new_data() {
        $this->role_module_m->authorization('14');
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['news'] = $this->news_m->get_news();
        $data['sidebar'] = $this->role_module_m->side_bar(290);
        $session = $this->session->all_userdata();

        $data['title'] = 'New Data Elina Schedule';
        // $data['part_no_all'] = $this->part_per_line_m->get_all_partno();
        // $data['part_no'] = $part_no;
        

        $data['content'] = 'prd/elina_schedule/create_elina_schedule_v';
        $this->load->view($this->layout, $data);
    }
    
    function save_data() {
        $area = $this->input->post('CHR_AREA');
        $time = $this->input->post('CHR_TIME');
        $func = $this->input->post('CHR_FUNCTION');
        $session = $this->session->all_userdata();

        $data_prod = $this->db->query("SELECT TOP 1 * FROM PRD.TM_ELINA_SCHEDULE WHERE CHR_TIME_EXEC = '$time' and CHR_AREA='$area'");
       
        if ($data_prod->num_rows() == 0){
            $data_part = array(
            'CHR_TIME_EXEC' => $time,
            'CHR_AREA' => $area,
            'CHR_FUNCTION' => $func,
            'CHR_USER_CREATE' => $session['NPK'],
            'CHR_CREATE_DATE' => date("Ymd"),
            'CHR_CREATE_TIME' => date("His")
            );
            $this->elina_schedule_m->save_dt($data_part);

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
            $sloc[] = $this->input->post('DL');
        } else {
            $data['checkboxDL'] = '';
        }
        if ($this->input->post('BP') != '') {
            $data['checkboxBP'] = 'checked';
            $sloc[] = $this->input->post('BP');
        } else {
            $data['checkboxBP'] = '';
        }
        if ($this->input->post('CC') != '') {
            $data['checkboxCC'] = 'checked';
            $sloc[] = $this->input->post('CC');
        } else {
            $data['checkboxCC'] = '';
        }
        if ($this->input->post('CD') != '') {
            $data['checkboxCD'] = 'checked';
            $sloc[] = $this->input->post('CD');
        } else {
            $data['checkboxCD'] = '';
        }
        if ($this->input->post('ST') != '') {
            $data['checkboxST'] = 'checked';
            $sloc[] = $this->input->post('ST');
        } else {
            $data['checkboxST'] = '';
        }
        if ($this->input->post('IN') != '') {
            $data['checkboxIN'] = 'checked';
            $sloc[] = $this->input->post('IN');
        } else {
            $data['checkboxIN'] = '';
        }
      
        $data['content'] = 'prd/elina_schedule/manage_elina_schedule_v';
        $data['title'] = 'Schedule ELINA Order';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(290);
        $data['news'] = $this->news_m->get_news();
        $data['msg'] = $msg;
        $data['dt_schedule'] = $this->elina_schedule_m->select_data_part_by($sloc);

        $this->load->view($this->layout, $data);
    }
}
