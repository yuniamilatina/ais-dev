<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class machine_c extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('eng/machine_m');
    }

    public function get_data_by_work_center(){
        $work_center = $this->input->post('work_center');

        $data = $this->machine_m->get_data_machine_by_work_center($work_center);

        echo json_encode($data->CHR_MACHINE_CODE);
    }
    
}

?>
