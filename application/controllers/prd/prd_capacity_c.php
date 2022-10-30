<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class prd_capacity_c extends CI_Controller {

    private $layout = '/template/head';
    private $back_to_manage = 'prd/prd_capacity_c/index/';

    public function __construct() {
        parent::__construct();
        $this->load->model('prd/prd_capacity_m');
        $this->load->model('prd/direct_backflush_general_m');
        $this->load->model('organization/dept_m');
    }

    function check_session() {
        $user_session = $this->session->all_userdata();
        if ($user_session['NPK'] == '') {
            redirect(base_url('index.php/login_c'));
        }
    }

    function index($msg = null, $id_dept = null) {
        $this->check_session();

        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Creating success </strong> The data is successfully created </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Updating success </strong> The data is successfully updated </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Deleted success </strong> The data is successfully deleted </div >";
        } elseif ($msg == 4) {
            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Choosing failed </strong> You must select at least one data</div >";
        } elseif ($msg == 12) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Executing error !</strong> Something error with parameter </div >";
        } elseif ($msg == 14) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Executing error !</strong> Something error with parameter </div >";
        } elseif ($msg == 0){
            $msg = '';
        }
        
        if($id_dept == null){
            $id_dept = '21';
        }

        $data['msg'] = $msg;
        $data['title'] = 'Manage Capacity Production';
        $data['content'] = 'prd/prd_capacity/manage_capacity_v';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(289);
        $data['news'] = $this->news_m->get_news();
        
        $data['id_dept'] = $id_dept;
        $data['all_dept_prod'] = $this->dept_m->get_all_prod_dept();
        $data['data'] = $this->prd_capacity_m->get_data_capacity_by_dept($id_dept);
        $this->load->view($this->layout, $data);
    }

    function create_capacity(){
        $this->check_session();
        $msg = "";

        $data['msg'] = $msg;
        $data['title'] = 'Create Capacity Production';
        $data['content'] = 'prd/prd_capacity/create_capacity_v';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(289);
        $data['news'] = $this->news_m->get_news();

        $id_dept = $this->dept_m->get_top_prod_dept()->row()->INT_ID_DEPT;
        $data['all_dept_prod'] = $this->dept_m->get_all_prod_dept();
        $data['all_work_centers'] = $this->direct_backflush_general_m->get_work_center_by_id_dept($id_dept);
        $data['work_center'] = $this->direct_backflush_general_m->get_top_data_direct_backflush_general();

        $this->load->view($this->layout, $data);
    }

    function save_capacity(){
        $this->check_session();
        $user_session = $this->session->all_userdata();
        $work_center = $this->input->post('CHR_WORK_CENTER');
        $id_dept = $this->input->post('INT_ID_DEPT');
        $shift = $this->input->post('INT_SHIFT');
        $capacity = $this->input->post('INT_CAPACITY_PRD');
        $schedule = $this->input->post('CHR_SCHEDULE');
        
        $dept = $this->dept_m->get_name_dept($id_dept);
        $date = date('Ymd');
        $time = date('His');
        
        $exist = $this->prd_capacity_m->check_data_capacity($work_center, $shift);
        if($exist->num_rows() > 0){
            $data_exist = $exist->row();
            $id = $data_exist->INT_ID;
            $data = array(
                'INT_CAPACITY_PRD' => $capacity,
                'CHR_SCHEDULE_CHUTE' => $schedule,
                'INT_SHIFT' => $shift,
                'CHR_MODIFIED_BY' => $user_session['USERNAME'],
                'CHR_MODIFIED_DATE' => date('Ymd'),
                'CHR_MODIFIED_TIME' => date('His')
            );

            $this->prd_capacity_m->update($data, $id);
        } else {
            $data = array(
                'CHR_DEPT' => $dept,
                'CHR_WORK_CENTER' => $work_center,
                'INT_SHIFT' => $shift,
                'CHR_SCHEDULE_CHUTE' => $schedule,
                'INT_CAPACITY_PRD' => $capacity,
                'CHR_CREATED_BY' => $user_session['USERNAME'],
                'CHR_CREATED_DATE' => $date,
                'CHR_CREATED_TIME' => $time
            );
            $this->prd_capacity_m->save($data);
        }
        
        redirect($this->back_to_manage . $msg = 1 . '/' . $id_dept);
    }
    
    function update_capacity(){
        $user_session = $this->session->all_userdata();        
        $id = $this->input->post('INT_ID');
        $id_dept = $this->input->post('ID_DEPT');
        $capacity = $this->input->post('INT_CAPACITY');
        $shift = $this->input->post('INT_SHIFT');
        $schedule = $this->input->post('CHR_SCHEDULE');
        
        $data = array(
            'INT_CAPACITY_PRD' => $capacity,
            'CHR_SCHEDULE_CHUTE' => $schedule,
            'INT_SHIFT' => $shift,
            'CHR_MODIFIED_BY' => $user_session['USERNAME'],
            'CHR_MODIFIED_DATE' => date('Ymd'),
            'CHR_MODIFIED_TIME' => date('His')
        );

        $this->prd_capacity_m->update($data, $id);

        redirect($this->back_to_manage . $msg = 2 . '/' . $id_dept);
    }

    function delete_capacity($id, $id_dept) {
        $this->prd_capacity_m->delete($id);
        redirect($this->back_to_manage . $msg = 3 . '/' . $id_dept);
    }
    
}

?>
