<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class news_c extends CI_Controller {

    private $layout = '/template/head';
    private $back_to_manage = '/portal/news_c/maintain_news/';

    public function __construct() {
        parent::__construct();
    }

    function check_session() {
        $user_session = $this->session->all_userdata();
        if ($user_session['NPK'] == '') {
            redirect(base_url('index.php/login_c'));
        }
    }

    function index($msg = null) {
        $data['msg'] = $msg;
        $data['title'] = 'News & Event';
        $data['content'] = 'portal/news_v';

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(40);
        $data['news'] = $this->news_m->get_news();
        $data['news_top'] = $this->news_m->get_top_news();

        $this->load->view($this->layout, $data);
    }

    function detil($id = null) {

        $title = 'News & Event';
        $content = 'portal/news_detil_v';

        $data['title'] = $title;
        $data['content'] = $content;

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(40);
        $data['news'] = $this->news_m->get_news();
        $news_id_data = $this->news_m->get_by_id($id);
        $data['news_id_title'] = $news_id_data[0]->CHR_NEWS_TITLE;
        $data['news_id'] = $news_id_data;

        $this->load->view($this->layout, $data);
    }

    function maintain_news($msg = null) {
        $this->role_module_m->authorization('41');

        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Creating success </strong> The data is successfully created </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Updating success </strong> The data is successfully updated </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Deleted success </strong> The data is successfully deleted </div >";
        } elseif ($msg == 4) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Upload Failed </strong> The data is not uploaded </div >";
        } elseif ($msg == 12) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Executing error !</strong> Something error with parameter </div >";
        }


        $data['msg'] = $msg;
        $data['data'] = $this->news_m->get_news();
        $data['content'] = 'portal/maintain_news_v';
        $data['title'] = 'Manage News Event';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(41);
        $data['news'] = $this->news_m->get_news();

        $this->load->view($this->layout, $data);
    }

    function create_news() {
        $this->role_module_m->authorization('41');

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['news'] = $this->news_m->get_news();
        $data['sidebar'] = $this->role_module_m->side_bar(41);

        $data['title'] = 'Create News';
        $data['content'] = 'portal/create_news_v';
        $this->load->view($this->layout, $data);
    }

    function save_news() {
        $this->form_validation->set_rules('CHR_NEWS_TITLE', 'Title', 'required|min_length[10]|max_length[200]|trim');
        $this->form_validation->set_rules('CHR_NEWS_DESC', 'Description', 'required|trim');

        $session = $this->session->all_userdata();

        $this->load->library(array('PHPExcel', 'PHPExcel/IOFactory'));
        $this->load->library('upload');

        $fileName = $_FILES['CHR_URL_IMAGE']['name'];

        if (empty($fileName)) {
            redirect($this->back_to_manage.$msg = 4);
        }

        $config = array(
            'upload_path' => 'assets/img/news/',
            'allowed_types' => "gif|JPG|jpg|png|jpeg",
            'overwrite' => TRUE,
            'max_size' => "2048000"//,
            //'file_name' = $fileName;
            );

        //code for upload with ci
        $this->upload->initialize($config);
        if ($a = $this->upload->do_upload('CHR_URL_IMAGE'))
            $this->upload->display_errors();
        $media = $this->upload->data('CHR_URL_IMAGE');
        $inputFileName = $config['upload_path'] . $media['file_name'];
        

        if ($this->form_validation->run() == FALSE) {
               $this->create_news();
        } else {
            $data = array(
            'CHR_NEWS_TITLE' => $this->input->post('CHR_NEWS_TITLE'),
            'CHR_NEWS_DESC' => $this->input->post('CHR_NEWS_DESC'),
            'CHR_URL_IMAGE' => $inputFileName,
            'CHR_CREATED_BY' => $session['USERNAME']
            );
            $this->news_m->save($data);

            redirect($this->back_to_manage . $msg = 1);
        }
            
        echo 1;
        
    }
    
    function select_by_id($id){
        $this->role_module_m->authorization('41');
        $data['data'] = $this->news_m->get_data($id)->row();

        $data['content'] = 'portal/view_news_v';
        $data['app'] = $this->role_module_m->get_app();
        $data['news'] = $this->news_m->get_news();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(41);

        $data['title'] = 'View News';

        $this->load->view($this->layout, $data);
    }

    //prepare to editing
    function edit_news($id) {

        $this->role_module_m->authorization('41');
        $data['data'] = $this->news_m->get_data($id)->row();

        $data['content'] = 'portal/edit_news_v';
        $data['app'] = $this->role_module_m->get_app();
        $data['news'] = $this->news_m->get_news();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(41);

        $data['title'] = 'Edit News';

        $this->load->view($this->layout, $data);
    }
    
    //updating data
    function update_news() {
        $id = $this->input->post('INT_ID_NEWS');

        $this->form_validation->set_rules('CHR_NEWS_TITLE', 'Title', 'required');
        $this->form_validation->set_rules('CHR_NEWS_DESC', 'Desc', 'required');
        $session = $this->session->all_newsdata();

        if ($this->form_validation->run() == FALSE) {
            $this->edit_news($id);
        } else {
            $data = array(
                'CHR_NEWS_TITLE' => $this->input->post('CHR_NEWS_TITLE'),
                'CHR_NEWS_DESC' => $this->input->post('CHR_NEWS_DESC'),
                'CHR_CREATED_BY' => $session['USERNAME']
            );
            $this->news_m->update($data, $id);
            redirect($this->back_to_manage . $msg = 2);
        }
    }

    //deleting data
    function delete_news($id) {
        $this->role_module_m->authorization('41');
        $this->news_m->delete($id);
        redirect($this->back_to_manage . $msg = 3);
    }

}

?>