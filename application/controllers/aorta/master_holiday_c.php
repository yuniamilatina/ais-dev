<?php

class master_holiday_c extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('aorta/master_holiday_m');
        $this->load->model('basis/log_m');
        $this->load->model('basis/role_module_m');
        $this->load->model('portal/news_m');
    }

    private $layout = '/template/head';

    function index($msg = NULL, $year = NULL) {
        $this->role_module_m->authorization('10');
        if($year == NULL){
            $year = date('Y');
        }

        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times</button><strong>Creating success. </strong> The data is successfully created. </div >";
        } else if ($msg == 2) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times</button><strong>Updating success. </strong> The data is successfully updated. </div >";
        } else if ($msg == 3) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times</button><strong>Deleting success. </strong> The data is successfully deleted. </div >";
        } else if ($msg == 12) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times</button><strong>Executing error !</strong> Something is not right. </div >";
        } else if ($msg == 13) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times</button><strong>Executing error !</strong> Date you want to add is already exist. </div >";
        } else {
            $msg = NULL;
        }
        
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(16);
        $data['news'] = $this->news_m->get_news();

        $data['title'] = 'Manage Holiday';
        $data['msg'] = $msg;
        $data['year'] = $year;
        $data['data'] = $this->master_holiday_m->get_holiday($year);
        $data['subcontent'] = NULL;
        $data['content'] = 'aorta/holiday/manage_holiday_v';
        $this->load->view($this->layout, $data);
    }

    function show_create() {
        echo $this->load->view('aorta/holiday/create_holiday_v');
    }

    function cancel_create() {
        echo null;
    }

    function save_holiday() {
        $session = $this->session->all_userdata();
        $date = substr($this->input->post('DATE'),6,4).substr($this->input->post('DATE'),3,2).substr($this->input->post('DATE'),0,2);
        $year = substr($this->input->post('DATE'),6,4);
        $check_date = $this->master_holiday_m->get_data_holiday($date)->num_rows();
        
        if($check_date > 0){
            redirect("aorta/master_holiday_c/index/13/$year", "REFRESH");
        } 
        
        $data = array(
            'TGL_LIBUR' => $date,
            'KETERANGAN' => $this->input->post('DESCRIPTION'),
            'STATUS_LB' => $this->input->post('STATUS'),
            'CHR_TIPE_LB' => $this->input->post('TYPE')
        );
        $this->master_holiday_m->save($data);
        $this->index('1');
    }

    function edit_holiday($year = NULL, $tgl = NULL) {
        $this->role_module_m->authorization('10');
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(16);
        $data['news'] = $this->news_m->get_news();

        $data['data'] = $this->master_holiday_m->get_holiday($year);
        $data['holiday'] = $this->master_holiday_m->get_data_holiday($tgl)->row();
        $data['title'] = 'Edit Holiday';
        $data['msg'] = NULL;
        $data['year'] = $year;
        $data['subcontent'] = 'aorta/holiday/edit_holiday_v';
        $data['content'] = 'aorta/holiday/manage_holiday_v';
        $this->load->view($this->layout, $data);
    }

    function update_holiday() {
        $tgl = $this->input->post('DATE');
        $session = $this->session->all_userdata();
        $data = array(
            'KETERANGAN' => $this->input->post('DESCRIPTION'),
            'STATUS_LB' => $this->input->post('STATUS'),
            'CHR_TIPE_LB' => $this->input->post('TYPE')
        );
        $this->master_holiday_m->update($data, $tgl);
        $this->index('2');
    }

    function delete_holiday($tgl) {
        $this->role_module_m->authorization('10');
        $this->master_holiday_m->delete($tgl);
        $this->index('3');
    }

}

?>
