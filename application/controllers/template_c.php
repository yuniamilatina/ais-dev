<?php

class template_c extends CI_Controller {
    /* -- define constructor -- */

    private $layout = '/template/head';

    public function __construct() {
        parent::__construct();
        $this->load->model('pes/template_m');
        $this->load->model('organization/dept_m');
        //$this->load->model(array('pes/template_m'));
        $this->load->library('PHPExcel');
        //$this->load->model('basis/log_m');
        //$this->load->model('basis/role_module_m');
        //$this->load->model('portal/news_m');
        //$this->load->model('portal/notification_m');
		
    }

    public function index() {
        $this->role_module_m->authorization('16');
        $this->session->userdata('user_id');

        $data['content'] = 'pes/dashboard_v';
        $data['title'] = 'Production Entry System';

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(16);
        $data['news'] = $this->news_m->get_news();

        if ($this->session->userdata('ROLE') == 4 || $this->session->userdata('ROLE') == 1) {
            $wcenter = $this->template_m->find('TOP(1) CHR_WCENTER_MN', '', 'CHR_WCENTER_MN');
        } else {
            $row = $this->dept_m->get_data_dept($this->session->userdata('DEPT'))->row();
            $data['dept_crop'] = substr($row->CHR_DEPT, 2, 1);
            $wcenter = $this->template_m->find('TOP(1) CHR_WCENTER_MN', 'CHR_PROD=' . $data['dept_crop'] . '', 'CHR_WCENTER_MN');
        }
        $data['first_wcenter'] = $wcenter[0]->CHR_WCENTER_MN;

        $this->load->view($this->layout, $data);
    }
	
	private function _redirect_if_not_logged_in() {
        if ($this->session->userdata('role_id') == '') {
            redirect('login/form');
        }
    }
/////////// -----------------------------------------------------Batas Suci------------------------------------------------------///////////
    		
}

?>