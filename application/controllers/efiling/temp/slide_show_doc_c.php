<?php

class slide_show_doc_c extends CI_Controller {

    private $layout = '/template/head';

    public function __construct() {
        parent::__construct();
        $this->load->model('basis/role_module_m');
        $this->load->model('basis/log_m');
        $this->load->model('portal/news_m');
        $this->load->model('portal/notification_m');
		$this->load->model('edoc/docu_m');
    }

    //show all data
    function index($id) {
        $this->role_module_m->authorization('66');
		
		$data['data'] = $this->docu_m->get_doc();
        $data['content'] = 'edoc/slide_show_doc_v';
        $data['title'] = 'Slide Show PCB';
        
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar']=  $this->role_module_m->side_bar(66);
        
        $this->load->view($this->layout, $data);
    }
}
