<?php

class dandori_board_c extends CI_Controller
{

    private $back_to_manage = 'prd/dandori_board_c/manageDandoriBoard/';
    private $layout = '/template/head';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('part/part_customer_m');
        $this->load->model('part/process_part_m');
        $this->load->model('kanban/kanban_m');
        $this->load->model('prd/coordinate_m');
        $this->load->model('prd/dandori_board_m');
    }

    public function index()
    {
        $this->load->view('prd/dandori_board_v');
    }

    public function getDetailDandoriActive()
    {
        $work_center = $this->input->post('work_center');
        $part_no = $this->input->post('part_no');
        $data['main_image'] = $this->dandori_board_m->getActiveDandoriCheck($work_center);
        $keypoint = $this->dandori_board_m->getDandoriCheckPoint($work_center);
        $data['keypoint'] = $keypoint->result();
        $data['keypoint_rows'] = $keypoint->num_rows();

        echo json_encode($data);
    }

    public function checkCoordinate()
    {
        $this->dandori_board_m->updateChecked($this->input->post('id_coordinate'));
        echo json_encode(true);
    }

    public function check_session()
    {
        $user_session = $this->session->all_userdata();
        if ($user_session['NPK'] == '') {
            redirect(base_url('index.php/login_c'));
        }
    }

    public function checkExistingWI()
    {
        $part_no = trim($this->input->post('part_no'));
        $id_kanban = intval($this->input->post('id_kanban'));
        $type = $this->input->post('type');
        $serial = $this->input->post('serial');
        $wi = '';
        $base = $_SERVER['SERVER_NAME'];
        $url = explode('index', $_SERVER['REQUEST_URI']);
        $type_kanban = $this->input->post('type');
        $data = array('flg_scan_label' => false, 'flg_show_wi' => false, 'message' => false);

        $data_customer = $this->kanban_m->get_cust_by_barcode($id_kanban, $type, $serial);

        if ($data_customer->num_rows() > 0) {

            $cust_part_no = trim($data_customer->row()->CHR_CUS_PART_NO);
            $cust_no = trim($data_customer->row()->CHR_CUS_NO);

            $data['flg_scan_label'] = $this->part_customer_m->get_existing_master_label($part_no, $id_kanban, $serial);

            if ($data['flg_scan_label'] == false) {
                $master_wi = $this->part_customer_m->get_master_wi($part_no, $cust_no);

                if ($master_wi->num_rows() > 0) {
                    $this->part_customer_m->reset_coordinate_image($part_no);
                    $data['flg_show_wi'] = true;
                    $base_url_picture = "url('http://" . $base . $url[0] . $master_wi->row()->CHR_IMG_FILE_NAME . "')";
                    $wi .= "<div style=\"width:900px;height:660px;background-image: " . $base_url_picture . ";background-size: 900px 660px;background-repeat: no-repeat;margin: 0px 0px 0px 0px;position:relative;\"></div>";

                    $base_url_nunjuk = 'http://' . $base . $url[0] . 'assets/img/pin.png';
                    $base_url_check = 'http://' . $base . $url[0] . 'assets/img/check1.png';

                    $cek = 1;
                    foreach ($master_wi->result() as $row) {
                        $top = $row->CHR_HEIGHT + 20;
                        $left = $row->CHR_WIDTH + 170;
                        $wi .= "<input type='image' id='$cek' src='$base_url_nunjuk'  class='img-button' style='cursor:pointer;width:60px;height:60px;position:absolute;top:" . $top . "px;left:" . $left . "px;' onclick='checkListCoordinate($row->INT_ID);this.src=\"$base_url_check\"' />";
                        $cek++;
                    }

                    $data['wi'] = $wi;
                }
            }
        } else {
            $data['message'] = 'Mohon pindai barcode produksi (kanban salah)';
        }

        if ('IS_AJAX') {
            echo json_encode($data);
        }
    }

    public function getDetailLabel()
    {
        $part_no = trim($this->input->post('part_no'));
        $abstract_barcode = trim($this->input->post('barcode_label'));
        $id_kanban = intval($this->input->post('id_kanban'));
        $serial = intval($this->input->post('serial'));
        $base = $_SERVER['SERVER_NAME'];
        $url = explode('index', $_SERVER['REQUEST_URI']);
        $wi = '';
        $data = array('status' => false, 'message' => false);

        if (substr($abstract_barcode, 11, 4) == '-001' && strlen($abstract_barcode) == 15) {
            // $part_no_cust = 'D' . substr($abstract_barcode,0,11);
            $part_no_cust = substr($abstract_barcode, 0, 11);
            $part_no_cust =  (explode("-", $part_no_cust));
            $part_no_cust =  $part_no_cust[0] . $part_no_cust[1];
        } else {
            $abstract_barcode_array =  (explode(" ", $abstract_barcode));
            $part_no_cust = trim(str_replace('%', ' ', $abstract_barcode_array[0]));
            $part_no_cust = trim(str_replace('L', ' ', $part_no_cust));
            $part_no_cust = trim(str_replace('Q', ' ', $part_no_cust));

            if (strlen($part_no_cust) > 12) {
                $part_no_cust = substr($part_no_cust, 0, 12);
            }
        }

        $master_wi = $this->part_customer_m->get_detail_wi_by_label(trim($part_no_cust), $part_no, $id_kanban, $serial);

        if ($master_wi->num_rows() > 0) {
            $data['status'] = true;
            $this->part_customer_m->reset_coordinate_image($part_no);
            $base_url_picture = "url('http://" . $base . $url[0] . $master_wi->row()->CHR_IMG_FILE_NAME . "')";
            $wi .= "<div style=\"width:900px;height:660px;background-image: " . $base_url_picture . ";background-size: 900px 660px;background-repeat: no-repeat;margin: 0px 0px 0px 0px;position:relative;\"></div>";

            $base_url_nunjuk = 'http://' . $base . $url[0] . 'assets/img/pin.png';
            $base_url_check = 'http://' . $base . $url[0] . 'assets/img/check1.png';

            $cek = 1;
            foreach ($master_wi->result() as $row) {
                $top = $row->CHR_HEIGHT + 20;
                $left = $row->CHR_WIDTH + 170;
                $wi .= "<input type='image' id='$cek' src='$base_url_nunjuk'  class='img-button' style='cursor:pointer;width:60px;height:60px;position:absolute;top:" . $top . "px;left:" . $left . "px;' onclick='checkListCoordinate($row->INT_ID);this.src=\"$base_url_check\"' />";
                $cek++;
            }
            $data['wi'] = $wi;
        } else {
            $data['message'] = 'Barcode Label : ' . $abstract_barcode . '(' . $part_no_cust . '), tidak sesuai dengan master data part customer pada master data WI ';
        }

        if ('IS_AJAX') {
            echo json_encode($data);
        }
    }

    public function manageDandoriBoard($msg = null)
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
        $data['title'] = 'Manage Dandori Board';
        $data['content'] = 'prd/manage_dandori_board_v';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(30);
        $data['news'] = $this->news_m->get_news();

        $data['data'] = $this->coordinate_m->getDataCoordinate();

        $this->load->view($this->layout, $data);
    }

    public function createDandoriBoard($work_center = null)
    {
        $data['msg'] = '';
        $data['title'] = '';
        $data['content'] = 'prd/upload_dandori_board_v';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(30);
        $data['news'] = $this->news_m->get_news();

        $data['data_part_cust_no'] = $this->part_customer_m->get_part_no_cust_by_workcenter($work_center);
        $data['part_no_customer'] = $this->part_customer_m->get_top_part_no_cust_by_workcenter($work_center);
        $data['data_part_no_aisin'] = $this->part_customer_m->get_data_part_aisin_by_part_cust_no_by_workcenter($data['part_no_customer'], $work_center);

        $this->load->view($this->layout, $data);
    }

    public function uploadDandoriBoard()
    {
        $part_no = $this->input->post('CHR_PART_NO');
        $cust_part_no = $this->input->post('CHR_CUS_PART_NO');
        $cus_no = $this->input->post('CHR_CUS_NO');
        $user_session = $this->session->all_userdata();

        $maxsize = 5000000;
        $allow_ekstensi = array('png', 'jpg', 'jpeg', 'gif', 'JPG');

        $size = $_FILES['file']['size'];
        $file = $_FILES['file']['name'];
        $file_tmp = $_FILES['file']['tmp_name'];

        $x = explode('.', $file);
        $ekstensi = strtolower(end($x));

        if (in_array($ekstensi, $allow_ekstensi) === true) {
            if ($size <= $maxsize) {
                $fileName = $part_no . '-' . round(microtime(true)) . '.' . $ekstensi;
                move_uploaded_file($file_tmp, DOCUP . "/wi/" . $fileName);

                $data = array(
                    'CHR_CUS_PART_NO' => $cust_part_no,
                    'CHR_PART_NO' => $part_no,
                    'CHR_CUS_NO' => $cus_no,
                    'CHR_IMG_FILE_NAME' => $fileName,
                    'INT_FLG_DANDORI_BOARD' => 1,
                    'CHR_CREATED_BY' => $user_session['USERNAME'],
                    'CHR_CREATED_DATE' => date('Ymd'),
                    'CHR_CREATED_TIME' => date('His')
                );
                $this->part_customer_m->save_wi($data);

                redirect('prd/dandori_board_c/setCoordinate/' . trim($cust_part_no) . '/' . 1);
            } else {
                //oversize
                redirect($this->back_to_manage . 15);
            }
        } else {
            //miss extension
            redirect($this->back_to_manage . $msg = 14);
        }
    }

    public function reuploadDandoriBoard()
    {
        $part_no = $this->input->post('CHR_PART_NO');
        $id = $this->input->post('INT_ID');
        $user_session = $this->session->all_userdata();

        $maxsize = 5000000;
        $allow_ekstensi = array('png', 'jpg', 'jpeg', 'gif', 'JPG');

        $size = $_FILES['file']['size'];
        $file = $_FILES['file']['name'];
        $file_tmp = $_FILES['file']['tmp_name'];

        $x = explode('.', $file);
        $ekstensi = strtolower(end($x));

        if (in_array($ekstensi, $allow_ekstensi) === true) {
            if ($size <= $maxsize) {
                $fileName = $part_no . '-' . round(microtime(true)) . '.' . $ekstensi;
                move_uploaded_file($file_tmp, DOCUP . "/wi/" . $fileName);

                $array_id = array(
                    'INT_ID' => $id
                );

                $data = array(
                    'CHR_IMG_FILE_NAME' => $fileName,
                    'CHR_CREATED_BY' => $user_session['USERNAME'],
                    'CHR_MODIFIED_DATE' => date('Ymd'),
                    'CHR_MODIFIED_TIME' => date('His')
                );

                $this->part_customer_m->update_wi_by_id($data, $array_id);

                redirect($this->back_to_manage . 2);
            } else {
                //oversize
                redirect($this->back_to_manage . 15);
            }
        } else {
            //miss extension
        }
    }

    public function editDandoriBoard($cust_part_no, $id)
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

    public function setCoordinate($cust_part_no)
    {
        $data['msg'] = '';
        $data['title'] = 'Set Coordinate Dandori Board';
        $data['content'] = 'prd/dandori_board_coordinate_v';
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

        $this->load->view($this->layout, $data);
    }

    public function saveCoordinate()
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

    public function deleteCoordinate()
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

    public function getDataPartAisinbyWorkcenter()
    {
        $cust_part_no = $this->input->post("CHR_CUS_PART_NO");
        $work_center = $this->input->post("CHR_WORK_CENTER");

        $part_no_aisin = $this->part_customer_m->get_top_part_aisin_by_part_cust_no_and_workcenter($cust_part_no, $work_center);
        $all_part_no_aisin = $this->part_customer_m->get_data_part_aisin_by_part_cust_no_by_workcenter($cust_part_no, $work_center);
        $data = '';

        foreach ($all_part_no_aisin as $row) {
            if (trim($part_no_aisin) == trim($row->CHR_PART_NO)) {
                $data .= "<option selected value='$row->CHR_PART_NO'>" . $row->CHR_PART_NO . "</option>";
            } else {
                $data .= "<option value='$row->CHR_PART_NO'>" . $row->CHR_PART_NO . "</option>";
            }
        }

        $json_data = array('data' => $data);

        echo json_encode($json_data);
    }
}
