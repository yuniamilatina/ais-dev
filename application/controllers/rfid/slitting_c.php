<?php

class Slitting_c extends CI_Controller {
    /* -- define constructor -- */

    private $layout = '/template/head';

    public function __construct() {
        parent::__construct();
        $this->load->model('pes/prod_entry_m');
        $this->load->model('pes/kanban_master_m');
        $this->load->model('organization/dept_m');
        $this->load->model('basis/role_module_m');
        $this->load->model('portal/news_m');

    }

    public function index() {
        $this->role_module_m->authorization('16');
        $this->session->userdata('user_id');

        $data['content'] = 'rfid/slitting_v';
        $data['title'] = 'Goods Movement';

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(73);
        $data['news'] = $this->news_m->get_news();



       // $data['first_wcenter'] = $row->CHR_DEPT;

        if ($this->session->userdata('ROLE') == 4 || $this->session->userdata('ROLE') == 1) {
            $wcenter = $this->prod_entry_m->find('TOP(1) CHR_WCENTER_MN', '', 'CHR_WCENTER_MN');
        } else {
            $row = $this->dept_m->get_data_dept($this->session->userdata('DEPT'))->row();
            $data['dept_crop'] = substr($row->CHR_DEPT, 2, 1);
            $wcenter = $this->prod_entry_m->find('TOP(1) CHR_WCENTER_MN', 'CHR_PROD=' . $data['dept_crop'] . '', 'CHR_WCENTER_MN');
        }
        $data['first_wcenter'] = $wcenter[0]->CHR_WCENTER_MN;

        $this->load->view($this->layout, $data);
    }
   
   
    public function slitting_v() {
        $this->role_module_m->authorization('16');
        $this->session->userdata('user_id');

        $data['content'] = 'rfid/slitting_v';
        $data['title'] = 'Slitting';

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(73);
        
    
        $this->load->view($this->layout, $data);
    }

public function goods_receipt_v() {
        $this->role_module_m->authorization('16');
        $this->session->userdata('user_id');

        $data['content'] = 'rfid/goods_receipt_v';
        $data['title'] = 'Slitting';

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(73);
        
    
        $this->load->view($this->layout, $data);
    }
	
public function goods_receipt_local_v() {
        $this->role_module_m->authorization('16');
        $this->session->userdata('user_id');

        $data['content'] = 'rfid/goods_receipt_local_v';
        $data['title'] = 'Slitting';

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(73);
        
    
        $this->load->view($this->layout, $data);
    }

public function goods_receipt_import_v() {
        $this->role_module_m->authorization('16');
        $this->session->userdata('user_id');

        $data['content'] = 'rfid/goods_receipt_import_v';
        $data['title'] = 'Slitting';

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(73);
        
    
        $this->load->view($this->layout, $data);
    }

public function goods_receipt_local_slitting_v() {
        $this->role_module_m->authorization('16');
        $this->session->userdata('user_id');

        $data['content'] = 'rfid/goods_receipt_local_slitting_v';
        $data['title'] = 'Slitting';

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(73);
        
    
        $this->load->view($this->layout, $data);
    }

public function goods_receipt_import_slitting_v() {
        $this->role_module_m->authorization('16');
        $this->session->userdata('user_id');

        $data['content'] = 'rfid/goods_receipt_import_slitting_v';
        $data['title'] = 'Slitting';

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(73);
        
    
        $this->load->view($this->layout, $data);
    }
	
public function return_wp01_to_steel_v() {
        $this->role_module_m->authorization('16');
        $this->session->userdata('user_id');

        $data['content'] = 'rfid/return_wp01_to_steel_v';
        $data['title'] = 'Slitting';

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(73);
        
    
        $this->load->view($this->layout, $data);
    }

public function inventory_out_RM_v() {
        $this->role_module_m->authorization('16');
        $this->session->userdata('user_id');

        $data['content'] = 'rfid/inventory_out_RM_v';
        $data['title'] = 'Slitting';

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(73);
        
    
        $this->load->view($this->layout, $data);
    }

}