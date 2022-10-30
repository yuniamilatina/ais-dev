<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class part_label_c extends CI_Controller {

    private $layout = '/template/head';
    private $back_to_manage = 'pes/part_label_c/index/';

    public function __construct() {
        parent::__construct();
        $this->load->model('pes/part_label_m');
        $this->load->model('prd/direct_backflush_general_m');
        $this->load->model('part/part_m');
        $this->load->model('kanban/kanban_m');

    }

    function check_session() {
        $user_session = $this->session->all_userdata();
        if ($user_session['NPK'] == '') {
            redirect(base_url('index.php/login_c'));
        }
    }

    function index($work_center = null, $msg = null) {

        $this->check_session();

        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Creating success </strong> The data is successfully created </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Updating success </strong> The data is successfully updated </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Deleted success </strong> The data is successfully deleted </div >";
        } elseif ($msg == 4) {
            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Choosing failed </strong> You must select at least one data</div >";
        }

        $data['msg'] = $msg;
        $data['title'] = 'Manage Part Label';
        $data['content'] = 'pes/part_label_v';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(44);
        $data['news'] = $this->news_m->get_news();
        
        if($work_center == null || $work_center == ''){
            $work_center = $this->direct_backflush_general_m->get_top_work_center_ines();
        }

        $all_work_centers = $this->direct_backflush_general_m->get_all_work_center_ines();

        $data['all_work_centers'] = $all_work_centers;
        $data['work_center'] = $work_center;

        $data['data'] = $this->part_label_m->get_data_part_label_by_work_center($data['work_center']);
        $this->load->view($this->layout, $data);
    }

    function create_part_label($work_center = null){
        $this->check_session();
        $msg = "";

        $data['msg'] = $msg;
        $data['title'] = 'Create Part Label';
        $data['content'] = 'pes/create_part_label_v';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(44);
        $data['news'] = $this->news_m->get_news();

        $data['all_work_centers'] = $this->direct_backflush_general_m->get_all_work_center_ines();
        $data['work_center'] =  $work_center;

        $data['data_part_no'] = $this->part_m->get_data_part_by_work_center($data['work_center']);
        $data['part_no'] = $this->part_m->get_top_part_by_work_center($data['work_center']);

        $this->load->view($this->layout, $data);
    }

    function save_part_label(){

        $work_center = $this->input->post('work_center');
        $part_no = $this->input->post('part_no');
        $back_no = $this->kanban_m->get_detail_part($part_no)->row()->CHR_BACK_NO;
        $qty = $this->input->post('qty');
        $weight_dus = $this->input->post('weight_dus');
        $weight_per_product = $this->input->post('weight_per_product');
        $weight_total = $this->input->post('weight_total');
        $cust_part_no = $this->input->post('cust_part_no');
        $cust_back_no = $this->input->post('cust_back_no');
        $item_name = $this->input->post('item_name');
        $sloc = $this->input->post('work_center');
        $item_head = $this->input->post('item_head');
        $prod_marking = $this->input->post('prod_marking');
        $box_type = $this->input->post('box_type');
        $customer = $this->input->post('customer');

        $check_existing = $this->part_label_m->check_existing_part_label($part_no);
        if($check_existing == true){
            redirect($this->back_to_manage.$work_center.'/'.$msg = 12);
        }else{
            $data = array(
                'part_no' => $part_no,
                'back_no' => $back_no,
                'qty' => $qty,
                'weight_dus' => $weight_dus,
                'weight_per_product' => $weight_per_product,
                'weight_total' => $weight_total,
                'cust_part_no' => $cust_part_no,
                'cust_back_no' => $cust_back_no,
                'item_name' => $item_name,
                'sloc' => $sloc,
                'item_head' => $item_head,
                'prod_marking' => $prod_marking,
                'box_type' => $box_type,
                'customer' => $customer,
            );
    
            $this->part_label_m->save($data);

            redirect($this->back_to_manage.$work_center.'/'.$msg = 1);
        }
           
    }

    function update_part_label(){

        $work_center = $this->input->post('work_center');
        $part_no = $this->input->post('part_no');
        $back_no = $this->input->post('back_no');
        $qty = $this->input->post('qty');
        $weight_dus = $this->input->post('weight_dus');
        $weight_per_product = $this->input->post('weight_per_product');
        $weight_total = $this->input->post('weight_total');
        $cust_part_no = $this->input->post('cust_part_no');
        $cust_back_no = $this->input->post('cust_back_no');
        $item_name = $this->input->post('item_name');
        $sloc = $this->input->post('sloc');
        $item_head = $this->input->post('item_head');
        $prod_marking = $this->input->post('prod_marking');
        $box_type = $this->input->post('box_type');
        $customer = $this->input->post('customer');

        $data = array(
            'back_no' => $back_no,
            'qty' => $qty,
            'weight_dus' => $weight_dus,
            'weight_per_product' => $weight_per_product,
            'weight_total' => $weight_total,
            'cust_part_no' => $cust_part_no,
            'cust_back_no' => $cust_back_no,
            'item_name' => $item_name,
            'sloc' => $sloc,
            'item_head' => $item_head,
            'prod_marking' => $prod_marking,
            'box_type' => $box_type,
            'customer' => $customer,
        );

        $this->part_label_m->update($data, $part_no);

        redirect($this->back_to_manage.$work_center.'/'.$msg =2);
        
    }
}

?>
