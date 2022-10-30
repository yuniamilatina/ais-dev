<?php

class direct_backflush_general_c extends CI_Controller {

    private $layout = '/template/head';
    private $back_to_approve_mgr = '/prd/direct_backflush_general_c/search_direct_backflush_general_by_mgr/';
    private $back_to_approve_gm = '/prd/direct_backflush_general_c/search_direct_backflush_general_by_gm/';
    private $back_to_approve_dir = '/prd/direct_backflush_general_c/search_direct_backflush_general_by_dir/';
    private $back_to_upload = '/prd/direct_backflush_general_c/create_direct_backflush_general/';
    private $back_to_reupload = '/prd/direct_backflush_general_c/edit_direct_backflush_general/';
    private $back_to_manage = '/prd/direct_backflush_general_c/search_direct_backflush_general/';
    private $back_to_index = '/prd/direct_backflush_general_c';

    public function __construct() {
        parent::__construct();
        $this->load->model('prd/direct_backflush_general_m');
        $this->load->model('part/part_m');
        $this->load->model('organization/dept_m');
    }

    function check_session() {
        $user_session = $this->session->all_userdata();
        if ($user_session['NPK'] == '') {
            redirect(base_url('index.php/login_c'));
        }
    }

    function index($msg = NULL) {
        $this->check_session();
        
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(48);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Manage Work Center';
        $data['msg'] = $msg;

        $data['data'] = $this->direct_backflush_general_m->get_data_direct_backflush_general();
        $data['content'] = 'prd/direct_backflush_general/manage_direct_backflush_general_v';
        $data['dept'] = $this->dept_m->get_all_prod_dept();
        $this->load->view($this->layout, $data);
    }

    function create_direct_backflush_general($qrno = null, $period = null, $dept = null, $msg= null) {
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
        $data['sidebar'] = $this->role_module_m->side_bar(48);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Create Work Center';
        $data['msg'] = $msg;
        
        $data['all_dept'] = $this->direct_backflush_general_m->get_data_direct_backflush_general();
        $data['data'] = $this->direct_backflush_general_m->get_data_direct_backflush_general();
        $data['active_machine'] = $this->direct_backflush_general_m->get_active_machine();
        $data['content'] = 'prd/direct_backflush_general/create_direct_backflush_general_v';
        $data['dept'] = $this->dept_m->get_all_prod_dept();
        $this->load->view($this->layout, $data);
        
    }

    //Preparation Edit Backflush General
    function edit_direct_backflush_general($qrno = null, $period = null, $dept = null, $msg= null) {
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
        $data['sidebar'] = $this->role_module_m->side_bar(48);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Edit Rotation Kanban';
        $data['msg'] = $msg;
        
        $data['all_dept'] = $this->direct_backflush_general_m->get_data_direct_backflush_general();
        $data['data'] = $this->direct_backflush_general_m->get_data_direct_backflush_general();
        $data['active_machine'] = $this->direct_backflush_general_m->get_active_machine();
        $data['content'] = 'prd/direct_backflush_general/edit_direct_backflush_general_v';
        $data['dept'] = $this->dept_m->get_all_prod_dept();
        $this->load->view($this->layout, $data);
        
    }
     //saving data direct_backflush
     function save_direct_backflush() {
        $this->form_validation->set_rules('CHR_DEPT', 'Department', 'required');
        $this->form_validation->set_rules('CHR_WCENTER', 'Work Center', 'required');
        $this->form_validation->set_rules('CHR_REMARK', 'Rotation Kanban (m)', 'required');

        // $id = $this->division_m->generate_id_division();
        $session = $this->session->all_userdata();

        if ($this->form_validation->run() == FALSE) {
            $this->create_master_model_twist();
        } else {
            $data = array(
                'CHR_CREATED_BY' => $session['USERNAME'],
                'CHR_MODEL' => strtoupper($this->input->post('CHR_MODEL')),
                'CHR_MARKING' => strtoupper($this->input->post('CHR_MARKING')),
                'CHR_MODEL_DESCRIPTION' => strtoupper($this->input->post('CHR_MODEL_DESCRIPTION')),
                'BIT_FLG_DEL' => 0
            );
            $this->master_model_twist_m->save_master_model_twist($data);
            $this->log_m->add_log('39', $id);
            redirect($this->back_to_manage . $msg = 1);
        }

    }

    //use by report 20180718
    function get_work_center_by_id_dept(){
        $id_dept = $this->input->post("INT_ID_DEPT");

        $data_work_center = $this->direct_backflush_general_m->get_work_center_by_id_dept($id_dept);
        $work_center = $this->direct_backflush_general_m->get_top_work_center_by_id_dept($id_dept);

        $data = '';

        foreach ($data_work_center as $row) { 
            if (trim($work_center) == trim($row->CHR_WORK_CENTER)){ 
                $data .="<option selected value='$row->CHR_WORK_CENTER'>".$row->CHR_WORK_CENTER."</option>";
            }else{ 
                $data .="<option value='$row->CHR_WORK_CENTER'>".$row->CHR_WORK_CENTER."</option>";
            }
        }
        //$data .="</select>";
       
        $json_data = array('data' => $data);

        echo json_encode($json_data);
    }

}
