<?php

class setting_display_c extends CI_Controller {

    private $layout = '/template/head';
	private $back_to_manage = 'efiling/setting_display_c/index/';

    public function __construct() {
        parent::__construct();
        $this->load->model('basis/role_module_m');
        $this->load->model('basis/log_m');
        $this->load->model('portal/news_m');
        $this->load->model('portal/notification_m');
		$this->load->model('efiling/doc_m');
    }

    //show all data
    function index($msg = NULL) {
        $this->role_module_m->authorization('67');

        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Creating success </strong> The data is successfully created </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Updating success </strong> The data is successfully updated </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Deleted success </strong> The data is successfully deleted </div >";
        } elseif ($msg == 12) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Executing error !</strong> Something error with parameter </div >";
        }
        $data['msg'] = $msg;
		$data['data'] = $this->doc_m->get_all_doc();
        $data['content'] = 'efiling/setting_display_v';
        $data['title'] = 'Setting Document';
        
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar']=  $this->role_module_m->side_bar(67);
        
        $this->load->view($this->layout, $data);
    }
	
	//updating data
    function update_doc() {
        $id_doc = $this->input->post('INT_ID_DOC');
		//$id_max = $this->doc_m->get_id_max();
		
		$data_false = array(
			'BIT_ACTIVE' => 0
		);
		$this->doc_m->update_false($data_false);
		//$this->doc_m->update_false_pos1($data_false);
		//$this->doc_m->update_false_pos2($data_false);
		//$this->doc_m->update_false_pos3($data_false);
		
		$data = array(
			'BIT_ACTIVE' => 1
		);
		$this->doc_m->update($data, $id_doc);
		//$this->doc_m->update_pos1($data, $id_doc);
		//$this->doc_m->update_pos2($data, $id_doc);
		//$this->doc_m->update_pos3($data, $id_doc);
		/* if($id_doc==1) {
			$this->doc_m->update($data, $id_max);
		}
		else {
			$this->doc_m->update($data, $id_doc - 1);
		} */
		//$this->doc_m->update($data, $id_doc);
		
		/* $data_chosen = array(
			'BIT_CHOSEN' => 1
		);
		$this->doc_m->update($data_chosen, $id_doc); */
		
		$this->log_m->add_log('49', $id_doc);

		redirect($this->back_to_manage . $msg = 2);
        
    }
}
