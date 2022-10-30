<?php

//Add By bugsMaker 20170812
class part_c extends CI_Controller {

    private $layout = '/template/head';
    private $back_to_upload = '/part/part_c/create_part/';
    private $back_to_reupload = '/part/part_c/edit_part/';
    private $back_to_manage = '/part/part_c/search_part/';
    private $back_to_index = '/part/part_c';

    public function __construct() {
        parent::__construct();
        $this->load->model('part/part_m');
        $this->load->model('part/process_part_m');
        $this->load->model('part/part_customer_m');
        $this->load->model('prd/direct_backflush_general_m');
    }

    function get_data_part_by_work_center(){
        $work_center = $this->input->post("CHR_WCENTER");

        $part_no = $this->part_m->get_top_part_by_work_center($work_center);
        $data_part_no = $this->part_m->get_data_part_by_work_center($work_center);
        $data = '';

        foreach ($data_part_no as $row) { 
            if (trim($part_no) == trim($row->CHR_PART_NO)){ 
                $data .="<option selected value='$row->CHR_PART_NO'>".$row->CHR_PART_NO."</option>";
            }else{ 
                $data .="<option value='$row->CHR_PART_NO'>".$row->CHR_PART_NO."</option>";
            }
        }
       
        $json_data = array('data' => $data);

        echo json_encode($json_data);
    }
    
    function method_part($work_center = null, $msg = null){

        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Creating success </strong> The data is successfully created </div >";
        }else if ($msg == 4) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Delete success </strong> The data is successfully deleted </div >";
        }else if ($msg == 5) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Create failed </strong> The Data is duplicated</div >";
        }

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(262);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Manage Method Scan Part';
        $data['msg'] = $msg;
        if($work_center == null){
            $work_center = $this->direct_backflush_general_m->get_top_data_direct_backflush_general();
        }
        $data['data'] = $this->process_part_m->get_data_part_by_work_center($work_center);

        $data_work_center = $this->direct_backflush_general_m->get_active_data_work_center();
        $data['all_work_centers'] = $data_work_center;
        $data['work_center'] = $work_center;

        $data['data_part_no'] = $this->part_customer_m->get_part_no_cust_by_workcenter($work_center);
        $data['part_no'] = $this->part_customer_m->get_top_part_no_by_workcenter($work_center);
        $data['data_part_no_customer'] = $this->part_customer_m->get_data_part_aisin_by_part_no_by_workcenter($data['part_no'], $work_center);

        $data['content'] = 'part/manage_method_part_v';
        $this->load->view($this->layout, $data);

    }

    function update_method_part(){
        $flg_method = $this->input->post('INT_FLG_METHODS');
        $part_no = $this->input->post('CHR_PART_NO');
        $work_center = $this->input->post('CHR_WORK_CENTER');

        $data = array(
            'INT_FLG_METHODS' => $flg_method
        );

        $id = array(
            'CHR_WORK_CENTER' => $work_center,
            'CHR_PART_NO' => $part_no
        );

        $this->process_part_m->update_methods($data, $id);

        redirect('part/part_c/label_part/' . $work_center . '/' . 1);
    }

    function delete_method_part($work_center, $id){

        $data_array = array(
            'INT_ID' => $id
        );

        $this->part_m->delete_label_part($data_array);

        redirect('part/part_c/label_part/' . $work_center . '/' . 4);
    }

    function get_data_part_no_cust(){
        $part_no = $this->input->post("CHR_PART_NO");
        $work_center = $this->input->post("CHR_WORK_CENTER");

        $part_no_data = $this->part_customer_m->get_part_cust_by_part_no($part_no, $work_center);
        $part_no_selected = $this->part_customer_m->get_top_part_cust_by_part_no($part_no, $work_center);
        $data = '';

        foreach ($part_no_data as $row) { 
            if (trim($part_no_selected) == trim($row->CHR_CUS_PART_NO)){ 
                $data .="<option selected value='".trim($row->CHR_CUS_PART_NO)."'>".trim($row->CHR_CUS_PART_NO)."</option>";
            }else{ 
                $data .="<option value='".trim($row->CHR_CUS_PART_NO)."'>".trim($row->CHR_CUS_PART_NO)."</option>";
            }
        }
       
        $json_data = array('data' => $data);

        echo json_encode($json_data);
    }

    function get_data_part_no_aisin(){
        $cust_part_no = $this->input->post("CHR_CUS_PART_NO");
        $work_center = $this->input->post("CHR_WORK_CENTER");

        $part_no_aisin = $this->part_customer_m->get_top_part_aisin_by_part_cust_no_and_workcenter($cust_part_no, $work_center);
        $cust_part_no_aisin = $this->part_customer_m->get_data_part_aisin_by_part_cust_no_by_workcenter($cust_part_no, $work_center);
        $data = '';

        foreach ($cust_part_no_aisin as $row) { 
            if (trim($part_no_aisin) == trim($row->CHR_PART_NO)){ 
                $data .="<option selected value='$row->CHR_PART_NO'>".$row->CHR_PART_NO."</option>";
            }else{ 
                $data .="<option value='$row->CHR_PART_NO'>".$row->CHR_PART_NO."</option>";
            }
        }
       
        $json_data = array('data' => $data);

        echo json_encode($json_data);
    }


}
