<?php

class role_module_c extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    private $layout = '/template/head';

    function index($msg = NULL) {
        $this->role_module_m->authorization('15');
		
        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><h4>Creating success </h4> The data is successfully created </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><h4>Updating success </h4> The data is successfully updated </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><h4>Deleted success </h4> The data is successfully deleted </div >";
        } elseif ($msg == 4) {
            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Creating failed </strong> You must select at least one module </div >";
        } elseif ($msg == 12) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><h4>Executing error !</h4> Something error with parameter </div >";
        }
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar']=  $this->role_module_m->side_bar(15);
        $data['news'] = $this->news_m->get_news();

        $data['title'] = 'Manage Role Module';
        $data['msg'] = $msg;
        $data['data'] = $this->role_module_m->get_all_role()->result();
        $data['subcontent'] = NULL;
        $data['content'] = 'basis/role_module/manage_role_module_v';
		//var_dump($data);die();
        $this->load->view('/template/head', $data);
		
    }

    function create_role() {
        $this->role_module_m->authorization('15');
        
        $data['msg'] = null;
        $data['data'] = $this->role_module_m->get_all_role()->result();

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar']=  $this->role_module_m->side_bar(15);
        $data['news'] = $this->news_m->get_news();
        $data['all_app'] = $this->role_module_m->get_all_app();
        $data['all_module'] = $this->role_module_m->get_all_module();
        $data['all_function'] = $this->role_module_m->get_all_function();
        
        $data['title'] = 'Create Role';
        $data['content'] = 'basis/role_module/create_role_v';
        
        $this->load->view($this->layout, $data);
    }

    function save_role() {
        $id = $this->role_module_m->get_new_id_role();
        $session = $this->session->all_userdata();
//        $module = $this->input->post('INT_ID_FUNCTION');
        $data = array(
            'INT_ID_ROLE' => $id,
            'CHR_ROLE' => $this->input->post('CHR_ROLE'),
            'CHR_CREATE_BY' => $session['USERNAME'],
            'CHR_CREATE_DATE' => date('Ymd'),
            'CHR_CREATE_TIME' => date('His'),
            'BIT_FLG_DEL' => 0
        );
        $this->role_m->save($data);
        //$this->log_m->add_log('57', $id);
//        $master_function = $this->role_module_m->get_function();
//        if ($module != NULL) {
//            for ($i = 0; $i < count($module); $i++) {
//                foreach ($master_function as $f) {
//                    if ($f->INT_ID_FUNCTION == $module[$i]) {
//                        $this->role_module_m->save_role_module($id, $module[$i], $f->INT_ID_MODULE);
//                    }
//                }
//            }
//        }
        $this->index('1');
    }

    function edit_role($id) {
        $this->role_module_m->authorization('15');
        $data['rm'] = $this->role_module_m->get_data_role($id);
        $data['role'] = $this->role_m->get_data($id);

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar']=  $this->role_module_m->side_bar(15);
        $data['news'] = $this->news_m->get_news();
        $data['data'] = $this->role_module_m->get_all_role()->result();
        $data['title'] = 'Edit Role';
        $data['msg'] = NULL;
        $data['content'] = 'basis/role_module/edit_role_module_v';
        //$data['content'] = 'basis/role_module/manage_role_module_v';

        $this->load->view($this->layout, $data);
    }

    function update_role() {
        $id = $this->input->post('INT_ID_ROLE');
        $function = $this->input->post('INT_ID_FUNCTION');
        $session = $this->session->all_userdata();
        $data_role = array(
            'INT_ID_ROLE' => $id,
            'CHR_ROLE' => $this->input->post('CHR_ROLE'),
            'CHR_MODI_BY' => $session['USERNAME'],
            'CHR_MODI_DATE' => date('Ymd'),
            'CHR_MODI_TIME' => date('His')
        );
        $this->role_m->update($data_role, $id);
        $this->log_m->add_log('58', $id);
        if ($this->role_module_m->if_exist($id)) {
            $this->role_module_m->delete_role_module($id);
        }$master_function = $this->role_module_m->get_function();
        if ($function != NULL) {
            for ($i = 0; $i < count($function); $i++) {
                foreach ($master_function as $f) {
                    if ($f->INT_ID_FUNCTION == $function[$i]) {
                        $this->role_module_m->save_role_module($id, $function[$i], $f->INT_ID_MODULE);
                    }
                }
            }
        }
        $this->index('2');
    }

    
    function view_role($id, $msg=null) {
        $this->role_module_m->authorization('15');

        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><h4>Creating success </h4> The data is successfully created </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><h4>Updating success </h4> The data is successfully updated </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><h4>Deleted success </h4> The data is successfully deleted </div >";
        } elseif ($msg == 4) {
            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Creating failed </strong> You must select at least one module </div >";
        } elseif ($msg == 12) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><h4>Executing error !</h4> Something error with parameter </div >";
        }
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar']=  $this->role_module_m->side_bar(15);
        $data['news'] = $this->news_m->get_news();

        $data['title'] = 'View Detail Role Module';
        $data['msg'] = $msg;
        $data['data'] = $this->role_module_m->get_role_module_by_id($id);
        $data['data_role_user'] = $this->role_module_m->get_role_user_by_id($id);
        $data['role'] = $this->role_module_m->get_role_name_by_id($id);
        $data['subcontent'] = NULL;
        $data['content'] = 'basis/role_module/manage_role_module_detail_v';
        $this->load->view($this->layout, $data);
		
    }
    
    function delete_role($id) {
        $this->role_module_m->authorization('15');
        $this->role_m->delete($id);
        $this->role_module_m->delete_role_module($id);
        $this->log_m->add_log('59', $id);
        $this->index('3');
    }

    function role_detail($id) {
        $this->role_module_m->authorization('15');
        $data['rm'] = $this->role_module_m->get_data_role($id);
        $data['role'] = $this->role_m->get_data($id);

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar']=  $this->role_module_m->side_bar(15);
        $data['news'] = $this->news_m->get_news();
        $data['data'] = $this->role_module_m->get_all_role()->result();
        $data['title'] = 'Role Detail';
        $data['msg'] = NULL;
        $data['subcontent'] = 'basis/role_module/view_role_module_v';
        $data['content'] = 'basis/role_module/manage_role_module_v';

        $this->load->view($this->layout, $data);
    }
    
    function remove_user_role($npk, $id_role){
        $this->role_module_m->delete_user_role_module($npk, $id_role);
        $this->index($id_role,2);
    }
    
    function edit_role_module($id_function, $id_role){
        
    }
    
    function update_role_module(){
        $this->role_module_m->_function_role_module($id_function, $id_role);
        $this->view_role($id_role,2);
    }
    
    function delete_role_module($id_function, $id_role){
        $this->role_module_m->delete_function_role_module($id_function, $id_role);
        $this->view_role($id_role,2);
    }

}
