<?php

class cavity_c extends CI_Controller {

    private $layout = '/template/head';
    private $back_to_manage = 'pes/cavity_c/index/';

    public function __construct() {
        parent::__construct();

        $this->load->model('pes/cavity_m');
        $this->load->model('part/part_m');
        $this->load->model('ines/ines_m');
        $this->load->model('organization/dept_m');
    }

    function index($msg = NULL) {
        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Creating success </strong> The data is successfully created </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Updating success </strong> The data is successfully updated </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Deleted success </strong> The data is successfully deleted </div >";
        }

        $data['content'] = 'pes/cavity/manage_cavity_v';
        $data['title'] = 'Master Part Cavity';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(225);
        $data['news'] = $this->news_m->get_news();
        $data['msg'] = $msg;

        $data_work_center = $this->ines_m->get_top_workcenter_inlinescan();
        $data['all_work_centers'] = $this->ines_m->get_workcenter_inlinescan();
        $data['work_center'] = trim($data_work_center['CHR_WORK_CENTER']);

        $data['data_cavity'] = $this->cavity_m->get_data($data['work_center']);

        $this->load->view($this->layout, $data);
    }

    function search_cavity($work_center = NULL, $msg = NULL) {
        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Creating success </strong> The data is successfully created </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Updating success </strong> The data is successfully updated </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Deleted success </strong> The data is successfully deleted </div >";
        }

        $data['content'] = 'pes/cavity/manage_cavity_v';
        $data['title'] = 'Master Part Cavity';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(225);
        $data['news'] = $this->news_m->get_news();
        $data['msg'] = $msg;

        $data['all_work_centers'] = $this->ines_m->get_workcenter_inlinescan();
        $data['work_center'] = trim($work_center);

        $data['data_cavity'] = $this->cavity_m->get_data($data['work_center']);

        $this->load->view($this->layout, $data);
    }

    function create_cavity() {
        $data['content'] = 'pes/cavity/create_cavity_v';
        $data['title'] = 'Create Cavity';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(225);
        $data['news'] = $this->news_m->get_news();

        $data['data_part_no_mate'] = $this->part_m->get_data_part_mate();
        $data['data_part_no'] = $this->part_m->get_data_part();
        $data['data_work_center'] = $this->ines_m->get_workcenter_inlinescan();

        $this->load->view($this->layout, $data);
    }

    function save_cavity() {
        $part_no = $this->input->post('CHR_PART_NO');
        $part_no_rm = $this->input->post('CHR_PART_NO_MATE');
        $work_center = $this->input->post('CHR_WORK_CENTER');

        $data_array = array(
            'CHR_PART_NO' => $part_no,
            'CHR_PART_NO_MATE' => $part_no_rm,
            'CHR_WORK_CENTER' => $work_center,
            'CHR_CREATED_BY' => $this->session->userdata('USERNAME'),
            'CHR_CREATED_TIME' => date('His'),
            'CHR_CREATED_DATE' => date('Ymd')
        );

        $this->cavity_m->save($data_array);
        redirect($this->back_to_manage . $msg = 1);
    }

    function edit_cavity($id) {

        $data['content'] = 'pes/cavity/edit_cavity_v';
        $data['title'] = 'Edit Master Part Cavity';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(225);
        $data['news'] = $this->news_m->get_news();

        $data['data_part_no_mate'] = $this->part_m->get_data_part_mate();
        $data['data_part_no'] = $this->part_m->get_data_part();
        $data['data_work_center'] = $this->ines_m->get_workcenter_inlinescan();
        $data['data'] = $this->cavity_m->get_data_by_id($id);

        $this->load->view($this->layout, $data);
    }

    function update_cavity() {

        $id = $this->input->post('INT_ID');
        $part_no = $this->input->post('CHR_PART_NO');
        $part_no_rm = $this->input->post('CHR_PART_NO_MATE');
        $work_center = $this->input->post('CHR_WORK_CENTER');

        $data_array = array(
            'CHR_PART_NO' => $part_no,
            'CHR_PART_NO_MATE' => $part_no_rm,
            'CHR_WORK_CENTER' => $work_center,
            'CHR_MODIFIED_BY' => $this->session->userdata('USERNAME'),
            'CHR_MODIFIED_TIME' => date('His'),
            'CHR_MODIFIED_DATE' => date('Ymd')
        );

        $this->cavity_m->update($data_array, $id);
        redirect($this->back_to_manage . $msg = 2);
    }

    function delete_cavity($id) {
        $this->cavity_m->delete($id);
        redirect($this->back_to_manage . $msg = 3);
    }

}
