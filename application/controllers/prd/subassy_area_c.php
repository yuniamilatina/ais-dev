<?php

class subassy_area_c extends CI_Controller
{

    private $layout = '/template/head';
    private $back_to_manage = 'prd/subassy_area_c/index/';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('prd/subassy_area_m');
        $this->load->model('prd/direct_backflush_general_m');
        $this->load->model('prd/pos_m');
        
    }

    public function index($msg = null)
    {
        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Creating success </strong> The data is successfully created </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Updating success </strong> The data is successfully updated </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Deleted success </strong> The data is successfully deleted </div >";
        } elseif ($msg == 4) {
            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Choosing failed </strong> You must select at least one data</div >";
        } 

        $data['title'] = 'Sub Assy Area';
        $data['msg'] = $msg;
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['news'] = $this->news_m->get_news();
        $data['sidebar'] = $this->role_module_m->side_bar(346);

        $data['all_work_centers'] = $this->direct_backflush_general_m->get_all_work_center_using_samalona();
        $data['work_center'] =$this->direct_backflush_general_m->get_top_work_center_using_samalona();
        $data['all_pos'] = $this->pos_m->get_ddl_pos_by_work_center($data['work_center']);
        $data['pos'] = $this->pos_m->get_top_pos_by_work_center($data['work_center']);

        $data['content'] = 'prd/subassy_area_v';

        $data['data'] = $this->subassy_area_m->getAllDataSubAssyArea();
        $this->load->view($this->layout, $data);
    }

    public function addSubAssy()
    {
        $msg = "";
        $data['msg'] = $msg;
        $data['title'] = 'Create Pos';
        $data['content'] = 'prd/create_subassy_area_v';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['news'] = $this->news_m->get_news();
        $data['sidebar'] = $this->role_module_m->side_bar(346);

        $this->load->view($this->layout, $data);
    }

    public function saveSubAssySpareSpart()
    {
        $supplier_name = $this->input->post('CHR_PREPAER_AREA_DESC');
        $user_session = $this->session->all_userdata();
        $pos = $this->input->post('CHR_POS_PRD');
        $workcenter = $this->input->post('CHR_WORK_CENTER');

        $subassy_code = $this->subassy_area_m->generateSubAssyCode($workcenter, $pos);

        $data = array(
            'CHR_PREPARE_AREA_CODE' => $workcenter.'-'.$pos.'-'.$subassy_code,
            'CHR_PREPAER_AREA_DESC' => $supplier_name,
            'CHR_POS_PRD' => $pos,
            'CHR_WORK_CENTER' => $workcenter,
            'CHR_CREATED_BY' => $user_session['NPK']
        );
        $this->subassy_area_m->save($data);

        redirect($this->back_to_manage . 1);
    }

    public function updateSubAssyArea(){

        $id = $this->input->post('INT_ID');
        $supplier_code = $this->input->post('CHR_PREPARE_AREA_CODE');
        $supplier_name = $this->input->post('CHR_PREPAER_AREA_DESC');
        $pos = $this->input->post('CHR_POS_PRD');
        $workcenter = $this->input->post('CHR_WORK_CENTER');

        $data = array(
            'CHR_PREPARE_AREA_CODE' => $supplier_code,
            'CHR_PREPAER_AREA_DESC' => $supplier_name,
            'CHR_POS_PRD' => $pos,
            'CHR_WORK_CENTER' => $workcenter,
        );
        $this->subassy_area_m->update($id, $data);

        redirect($this->back_to_manage . 3);
    }

    public function deleteSubAssyArea($id){

        $this->subassy_area_m->delete($id);

        redirect($this->back_to_manage . 4);
    }
}
