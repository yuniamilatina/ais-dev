<?php

//Add By xcx 20190507
class part_receiving_c extends CI_Controller {

    private $layout = 'patricia/part_receiving/part_receiving_v';
    private $back_to_index = '/patricia/part_receiving_c/index/';

    public function __construct() {
        parent::__construct();
        $this->load->model('patricia/part_receiving_m');
    }

    function index($msg = NULL) {
        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Downloading success </strong>  The data is successfully created </div >";
        }
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['news'] = $this->news_m->get_news();
        $data['sidebar'] = $this->role_module_m->side_bar(82);
        $data['title'] = 'Part Chart';
        $today1 = date("Y-m-d");
        $today2 =date_create($today1);
        $tgl = date_format($today2,"Ymd");
        $data['data'] = $this->part_receiving_m->get_receiving($tgl);
        $data['msg'] = $msg;
        $data['content'] = 'patricia/part_receiving/part_receiving_v';
        $this->load->view($this->layout, $data);
    }
    function update_check($id)
    {
        $today1 = date("Y-m-d");
        $today2 =date_create($today1);
        $tgl = date_format($today2,"Ymd");
        $status_update = array(
                'CHR_STATUS' => 'Checked');
        $this->part_receiving_m->update($id,$status_update);
        $data['data'] = $this->part_receiving_m->get_receiving($tgl);
        $this->load->view($this->layout, $data);
    }
    function update_same($id)
    {
        $today1 = date("Y-m-d");
        $today2 =date_create($today1);
        $tgl = date_format($today2,"Ymd");

        $status_update = array(
                'CHR_STATUS' => 'Same Lot'
            );

        $this->part_receiving_m->update($id,$status_update);

        $data['data'] = $this->part_receiving_m->get_receiving($tgl);
        $this->load->view($this->layout, $data);
    }

    function update_load_number(){

        $today1 = date("Y-m-d");
        $today2 =date_create($today1);
        $tgl = date_format($today2,"Ymd");
        $load_number = $this->input->post("CHR_LOAD_NUMBER");
        $pds = $this->input->post("CHR_PDS_NUMBER");
        $part_no = $this->input->post("CHR_PART_NO");
        
        $id = array(
            'CHR_PDS_NUMBER' => $pds,
            'CHR_PART_NO' => $part_no
        );

        $status_update = array(
            'CHR_LOAD_NUMBER' => $load_number
        );
               
        $this->part_receiving_m->update_load($id, $status_update);

        $data['data'] = $this->part_receiving_m->get_receiving($tgl);
        $this->load->view($this->layout, $data);
    }
    
    
}
?>