<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class pis_comp_c extends CI_Controller {

    private $layout = '/template/head';
    private $back_to_manage = 'prd/pis_comp_c/index/';

    public function __construct() {
        parent::__construct();
        $this->load->model('basis/log_m');
        $this->load->model('basis/role_module_m');
        $this->load->model('portal/news_m');
        $this->load->model('portal/notification_m');
        $this->load->model('prd/pis_comp_m');
    }

    function index($msg = NULL) {
        $this->role_module_m->authorization('3');

        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Creating success </strong> The data is successfully created </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Updating success </strong> The data is successfully updated </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Deleted success </strong> The data is successfully deleted </div >";
        } elseif ($msg == 4) {
            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Choosing failed </strong> You must select at least one data</div >";
        } elseif ($msg == 12) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Executing error !</strong> you must choose file</div >";
        } elseif ($msg == 13) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Executing error !</strong> Cannot using dot(.) in name of file</div >";
        }
        $data['msg'] = $msg;
        $data['data'] = $this->pis_comp_m->get_pis_comp();
        $data['content'] = 'prd/pis_comp/manage_pis_comp_v';
        $data['title'] = 'Manage PIS Component';
        $data['news'] = $this->news_m->get_news();
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(50);

        $this->load->view($this->layout, $data);
    }

    //create PIS component
    function create_pis_comp() {
        $this->role_module_m->authorization('3');
        $data['kanban_data'] = $this->pis_comp_m->get_kanban_data();
        $data['content'] = 'prd/pis_comp/create_pis_comp_v';
        $data['title'] = 'Create PIS Component';
        $data['news'] = $this->news_m->get_news();
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(50);

        $this->load->view($this->layout, $data);
    }

    //edit PIS component
    function edit_pis_comp($id) {
        $this->role_module_m->authorization('3');
        $data['data'] = $this->pis_comp_m->get_data($id);
        $data['content'] = 'prd/pis_comp/edit_pis_comp_v';
        $data['title'] = 'Edit PIS Component';
        $data['news'] = $this->news_m->get_news();
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(50);

        $this->load->view($this->layout, $data);
    }

    //saving create new data
    public function save_pis_comp() {
        $this->load->library('upload');
        
        $back_no = $this->input->post('CHR_BACK_NO');
        $upload_date = date('Ymd');
        $upload_time = date('His');

        $array_file = explode(".",$_FILES['CHR_IMAGE_PIS_URL']['name']);

        if(count($array_file) > 2){
            redirect($this->back_to_manage.$msg = 13);
        }

        $fileName = time().str_replace(' ','-',$_FILES['CHR_IMAGE_PIS_URL']['name']);

        if (empty($fileName)) {
            redirect($this->back_to_manage.$msg = 12);
        }

        $config = array(
            'upload_path' => 'assets/img/pis_comp/',
            'allowed_types' => "gif|JPG|jpg|png|jpeg",
            'max_size' => "2048000",
            'file_name' =>  $fileName
            );

        //upload image
        $this->upload->initialize($config);
        if ($a = $this->upload->do_upload('CHR_IMAGE_PIS_URL'))
            $this->upload->display_errors();
        $media = $this->upload->data('CHR_IMAGE_PIS_URL');

        $inputFileName = $config['upload_path'] . $fileName; //$media['file_name'];
        $this->db->query("UPDATE TM_KANBAN SET CHR_IMAGE_PIS_URL = '$inputFileName' WHERE CHR_BACK_NO='$back_no'");
        $this->db->query("UPDATE PRD.TM_POS_MATERIAL SET CHR_IMAGE_PIS_URL = '$inputFileName' WHERE CHR_BACK_NO_COMP='$back_no'");

        redirect($this->back_to_manage . $msg = 1);
    }
    
    //saving update data
    public function update_pis_comp() {
        $this->load->library('upload');
        
        $id = $this->input->post('INT_KANBAN_NO');
        $back_no = $this->input->post('CHR_BACK_NO');

        $upload_date = date('Ymd');
        $upload_time = date('His');

        $array_file = explode(".",$_FILES['CHR_IMAGE_PIS_URL']['name']);

        if(count($array_file) > 2){
            redirect($this->back_to_manage.$msg = 13);
        }

        $fileName = time().str_replace(' ','-',$_FILES['CHR_IMAGE_PIS_URL']['name']);

        if (empty($fileName)) {
            redirect($this->back_to_manage.$msg = 12);
        }

        $config = array(
            'upload_path' => 'assets/img/pis_comp/',
            'allowed_types' => "gif|JPG|jpg|png|jpeg",
            'max_size' => "2048000",
            'file_name' =>  $fileName
            );

        //code for upload with ci
        $this->upload->initialize($config);
        if ($a = $this->upload->do_upload('CHR_IMAGE_PIS_URL'))
            $this->upload->display_errors();
        $media = $this->upload->data('CHR_IMAGE_PIS_URL');

        $inputFileName = $config['upload_path'] . $fileName; //$media['file_name'];
        
        $this->db->query("UPDATE TM_KANBAN SET CHR_IMAGE_PIS_URL = '$inputFileName' WHERE INT_KANBAN_NO='$id'");
        $this->db->query("UPDATE PRD.TM_POS_MATERIAL SET CHR_IMAGE_PIS_URL = '$inputFileName' WHERE CHR_BACK_NO_COMP='$back_no'");

        redirect($this->back_to_manage . $msg = 2);
    }

    function delete_pis_comp($back_no) {
        $this->db->query("UPDATE TM_KANBAN SET CHR_IMAGE_PIS_URL = NULL
                                        WHERE CHR_BACK_NO = '$back_no'");
        redirect($this->back_to_manage . $msg = 3);
    }

}
