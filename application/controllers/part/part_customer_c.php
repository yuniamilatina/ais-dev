<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class part_customer_c extends CI_Controller
{

    private $back_to_upload = 'part/part_customer_c/manage_part_customer_wi/';
    private $layout = '/template/head';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('part/part_customer_m');
        $this->load->model('part/part_m');
    }

    function check_session()
    {
        $user_session = $this->session->all_userdata();
        if ($user_session['NPK'] == '') {
            redirect(base_url('index.php/login_c'));
        }
    }

    function index()
    {
    }

    function manage_part_customer_wi($msg = null)
    {

        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Creating success </strong> The data is successfully created </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Updating success </strong> The data is successfully updated </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Deleted success </strong> The data is successfully deleted </div >";
        } elseif ($msg == 4) {
            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Duplicate data </strong> Data sudah pernah ada</div >";
        } elseif ($msg == 12) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Executing error !</strong> Something error with parameter </div >";
        } elseif ($msg == 14) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Executing error !</strong> Something error with parameter </div >";
        }

        $data['msg'] = $msg;
        $data['title'] = 'Manage Part Customer WI';
        $data['content'] = 'part/manage_part_customer_v';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(30);
        $data['news'] = $this->news_m->get_news();

        $data['data'] = $this->part_customer_m->get_data_part_customer_wi();
        $this->load->view('/template/head', $data);
    }

    function create_part_customer_wi()
    {
        $msg = "";

        $data['msg'] = $msg;
        $data['title'] = 'Create Part Cust. WI';
        $data['content'] = 'part/create_part_cust_wi_v';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(30);
        $data['news'] = $this->news_m->get_news();

        $data['data_part_cust_no'] = $this->part_customer_m->get_part_no_cust();
        $data['part_no_customer'] = $this->part_customer_m->get_top_part_no_cust();

        $data['data_part_no_aisin'] = $this->part_customer_m->get_data_part_aisin_by_part_cust_no($data['part_no_customer']);

        $this->load->view('/template/head', $data);
    }

    function get_data_part_no_aisin()
    {
        $cust_part_no = $this->input->post("CHR_CUS_PART_NO");

        $part_no_aisin = $this->part_customer_m->get_top_part_aisin_by_part_cust_no($cust_part_no);
        $cust_part_no_aisin = $this->part_customer_m->get_data_part_aisin_by_part_cust_no($cust_part_no);
        $data = '';

        foreach ($cust_part_no_aisin as $row) {
            if (trim($part_no_aisin) == trim($row->CHR_PART_NO)) {
                $data .= "<option selected value='$row->CHR_PART_NO'>" . $row->CHR_PART_NO . "</option>";
            } else {
                $data .= "<option value='$row->CHR_PART_NO'>" . $row->CHR_PART_NO . "</option>";
            }
        }

        $json_data = array('data' => $data);

        echo json_encode($json_data);
    }

    function get_data_cust_no()
    {
        $cust_part_no = $this->input->post("CHR_CUS_PART_NO");

        $top_cust_no = $this->part_customer_m->get_top_cus_no($cust_part_no);
        $cust_no = $this->part_customer_m->get_cus_no($cust_part_no);
        $data = '';

        foreach ($cust_no as $row) {
            if (trim($top_cust_no) == trim($row->CHR_CUS_NO)) {
                $data .= "<option selected value='$row->CHR_CUS_NO'>" . $row->CHR_CUST_NAME . "</option>";
            } else {
                $data .= "<option value='$row->CHR_CUS_NO'>" . $row->CHR_CUST_NAME . "</option>";
            }
        }

        $json_data = array('data' => $data);

        echo json_encode($json_data);
    }

    function upload_part_customer_wi()
    {
        $this->load->library(array('PHPExcel', 'PHPExcel/IOFactory'));
        $this->load->library('upload');

        $cust_part_no = $this->input->post('CHR_CUS_PART_NO');
        $part_no = $this->input->post('CHR_PART_NO');
        $cus_no = $this->input->post('CHR_CUS_NO');
        $upload_date = date('Ymd');
        $upload_time = date('His');

        $fileName = time() . str_replace(' ', '_', $_FILES['CHR_IMG_FILE_NAME']['name']);

        if (empty($fileName)) {
            redirect($this->back_to_upload . $msg = 14);
        }

        $config = array(
            'upload_path' => 'assets/img/wi/',
            'allowed_types' => "gif|JPG|jpg|png|jpeg",
            // 'overwrite' => TRUE,
            'file_name' =>  $fileName,
            'max_size' => "2048000"
        );

        //code for upload with ci
        $this->upload->initialize($config);
        if ($a = $this->upload->do_upload('CHR_IMG_FILE_NAME'))
            $this->upload->display_errors();
        $media = $this->upload->data('CHR_IMG_FILE_NAME');
        $inputFileName = $config['upload_path'] . $media['file_name'];

        if ($this->part_customer_m->get_existing_wi_part_cust_no($cust_part_no) == 0) {
            $data = array(
                'CHR_CUS_PART_NO' => $cust_part_no,
                'CHR_PART_NO' => $part_no,
                'CHR_CUS_NO' => $cus_no,
                'CHR_IMG_FILE_NAME' => $inputFileName,
                'CHR_CREATED_DATE' => $upload_date,
                'CHR_CREATED_TIME' => $upload_time
            );
            $this->part_customer_m->save_wi($data);
        } else {
            redirect($this->back_to_upload . $msg = 4);
        }

        redirect('part/part_customer_c/view_part_customer_wi/' . $cust_part_no);
    }

    function edit_part_customer_wi($cust_part_no, $id)
    {
        $this->check_session();
        $msg = "";

        $data['msg'] = $msg;
        $data['title'] = 'Edit Part Cust. WI';
        $data['content'] = 'part/edit_part_cust_wi_v';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(30);
        $data['news'] = $this->news_m->get_news();

        $data['detail_wi'] = $this->part_customer_m->get_data_wi_by_part_no_cust($cust_part_no);
        $data['data_part_no_cust'] = $this->part_customer_m->get_part_no_cust();
        $data['data_cust'] = $this->part_customer_m->get_cust_by_cust_no($cust_part_no);
        $data['data_part_no_aisin'] = $this->part_customer_m->get_data_part_aisin_by_part_cust_no($cust_part_no);

        $this->load->view('/template/head', $data);
    }

    function reupload_part_customer_wi()
    {
        $this->load->library(array('PHPExcel', 'PHPExcel/IOFactory'));
        $this->load->library('upload');

        $cust_part_no = $this->input->post('CHR_CUS_PART_NO');
        $cust_part_no_old = $this->input->post('CHR_CUS_PART_NO_OLD');
        $part_no = $this->input->post('CHR_PART_NO');
        $cus_no = $this->input->post('CHR_CUS_NO');
        $id = $this->input->post('INT_ID');
        $upload_date = date('Ymd');
        $upload_time = date('His');

        $fileName = time() . str_replace(' ', '_', $_FILES['CHR_IMG_FILE_NAME']['name']);

        if (empty($fileName)) {
            redirect($this->back_to_upload . $msg = 14);
        }

        $config = array(
            'upload_path' => 'assets/img/wi/',
            'allowed_types' => "gif|JPG|jpg|png|jpeg",
            // 'overwrite' => TRUE,
            'file_name' =>  $fileName,
            'max_size' => "2048000"
        );

        //code for upload with ci
        $this->upload->initialize($config);
        if ($a = $this->upload->do_upload('CHR_IMG_FILE_NAME'))
            $this->upload->display_errors();
        $media = $this->upload->data('CHR_IMG_FILE_NAME');
        $inputFileName = $config['upload_path'] . $media['file_name'];

        if ($this->part_customer_m->check_exist_coordinate_by_id($cust_part_no_old)) {
            $data = array(
                'CHR_CUS_PART_NO' => $cust_part_no_old,
                'CHR_PART_NO' => $part_no,
                'CHR_CUS_NO' => $cus_no,
                'CHR_IMG_FILE_NAME' => $inputFileName,
                'CHR_MODIFIED_DATE' => $upload_date,
                'CHR_MODIFIED_TIME' => $upload_time,
                'INT_FLG_MODIFIED' => 1
            );

            $this->part_customer_m->update_wi_by_id($data, $id);
        } else {
            $data_detail = array(
                'CHR_CUS_PART_NO' => $cust_part_no_old
            );

            $this->part_customer_m->delete_coordinate($data_detail);

            $data = array(
                'CHR_CUS_PART_NO' => $cust_part_no,
                'CHR_PART_NO' => $part_no,
                'CHR_CUS_NO' => $cus_no,
                'CHR_IMG_FILE_NAME' => $inputFileName,
                'CHR_MODIFIED_DATE' => $upload_date,
                'CHR_MODIFIED_TIME' => $upload_time,
                'INT_FLG_MODIFIED' => 1
            );

            $this->part_customer_m->update_wi_by_id($data, $id);
        }

        redirect('part/part_customer_c/view_part_customer_wi/' . $cust_part_no);
    }

    function view_part_customer_wi($cust_part_no)
    {
        $this->check_session();
        $msg = "";

        $data['msg'] = $msg;
        $data['title'] = 'View Part Cust. WI';
        $data['content'] = 'part/view_part_customer_v';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(30);
        $data['news'] = $this->news_m->get_news();

        $data['part_no'] = '';
        $data['back_no'] = '';
        $data['cek_no'] = '';
        $data['pointer'] = '';

        $data['data'] = $this->part_customer_m->get_detail_part_customer_by_part_cust_no($cust_part_no);
        $data['data_detail'] = $this->part_customer_m->get_coordinate_part_customer_by_part_cust_no($cust_part_no);

        $this->load->view('/template/head', $data);
    }

    function delete_part_customer_wi($cust_part_no)
    {
        $this->part_customer_m->delete_wi($cust_part_no);
        redirect($this->back_to_upload . $msg = 3);
    }

    function undelete_part_customer_wi($cust_part_no)
    {
        $this->part_customer_m->undelete_wi($cust_part_no);
        redirect($this->back_to_upload . $msg = 3);
    }

    function save_coordinate()
    {
        $cust_part_no = $this->input->post('CHR_CUS_PART_NO');
        $left = $this->input->post('CHR_WIDTH');
        $top = $this->input->post('CHR_HEIGHT');

        $data_detail = array(
            'CHR_WIDTH' => $left,
            'CHR_HEIGHT' => $top,
            'CHR_CUS_PART_NO' => $cust_part_no
        );

        $this->part_customer_m->save_coordinate($data_detail);

        $data = array(
            'INT_FLG_MODIFIED' => 1
        );

        $this->part_customer_m->update_wi($data, $cust_part_no);
    }

    function delete_coordinate()
    {
        $cust_part_no = $this->input->post('CHR_CUS_PART_NO');
        $id = $this->input->post('INT_ID');

        $data_detail = array(
            'CHR_CUS_PART_NO' => $cust_part_no,
            'INT_ID' => $id
        );

        $this->part_customer_m->delete_coordinate($data_detail);

        if ($this->part_customer_m->check_exist_coordinate_by_id($cust_part_no) == 0) {
            $data = array(
                'INT_FLG_MODIFIED' => 0
            );

            $this->part_customer_m->update_wi($data, $cust_part_no);
        }
    }

   
}
