<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class pos_c extends CI_Controller
{

    private $layout = '/template/head';
    private $back_to_manage = 'prd/pos_c/index/';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('prd/pos_m');
        $this->load->model('prd/pos_coordinate_m');
        $this->load->model('prd/direct_backflush_general_m');
        $this->load->model('part/part_m');
        $this->load->model('organization/dept_m');
    }

    function check_session()
    {
        $user_session = $this->session->all_userdata();
        if ($user_session['NPK'] == '') {
            redirect(base_url('index.php/login_c'));
        }
    }

    function index($work_center = null, $msg = null)
    {

        $this->check_session();

        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Creating success </strong> The data is successfully created </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Updating success </strong> The data is successfully updated </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Deleted success </strong> The data is successfully deleted </div >";
        } elseif ($msg == 4) {
            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Choosing failed </strong> You must select at least one data</div >";
        } elseif ($msg == 6) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Uploading failed </strong> Ukuran file gambar tidak boleh melebihi 5mb</div >";
        } elseif ($msg == 7) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Uploading failed </strong> Ekstensi tidak diperbolehkan, hanya jpg, jpeg, png dan gif</div >";
        } elseif ($msg == 12) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Executing error !</strong> Something error with parameter </div >";
        } elseif ($msg == 14) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Uploading failed !</strong> The data is failed to created, please try again </div >";
        }

        $data['msg'] = $msg;
        $data['title'] = 'Manage Pos WI';
        $data['content'] = 'prd/pos/manage_pos_v';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(44);
        $data['news'] = $this->news_m->get_news();

        if ($work_center == null || $work_center == '') {
            $work_center = $this->direct_backflush_general_m->get_top_work_center_using_samalona();
        }

        $all_work_centers = $this->direct_backflush_general_m->get_all_work_center_using_samalona();

        $data['all_work_centers'] = $all_work_centers;
        $data['work_center'] = $work_center;


        $data['data'] = $this->pos_m->get_data_pos_by_work_center($data['work_center']);
        $this->load->view($this->layout, $data);
    }

    function create_pos($work_center = null)
    {
        $this->check_session();

        $data['msg'] = "";
        $data['title'] = 'Create Pos';
        $data['content'] = 'prd/pos/create_pos_v';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(44);
        $data['news'] = $this->news_m->get_news();

        $data['all_work_centers'] = $this->direct_backflush_general_m->get_all_work_center_ines();
        $data['work_center'] =  $work_center;
        $data['part_no'] = $this->part_m->get_top_part_by_work_center($data['work_center']);
        $data['data_part_no'] = $this->part_m->get_data_part_by_work_center($data['work_center']);

        $this->load->view($this->layout, $data);
    }

    // function save_pos(){
    //     $this->load->library(array('PHPExcel', 'PHPExcel/IOFactory'));
    //     $this->load->library('upload');

    //     $part_no = $this->input->post('CHR_PART_NO');
    //     $work_center = $this->input->post('CHR_WORK_CENTER');
    //     $pos = $this->input->post('CHR_POS_PRD');

    //     $upload_date = date('Ymd');
    //     $upload_time = date('His');

    //     $array_file = explode(".",$_FILES['CHR_IMG_FILE_NAME']['name']);

    //     if(count($array_file) > 2){
    //         redirect($this->back_to_manage.$work_center.'/'.$msg = 13);
    //     }

    //     $fileName = time().str_replace(' ','_',$_FILES['CHR_IMG_FILE_NAME']['name']);

    //     if (empty($fileName)) {
    //         redirect($this->back_to_manage.$work_center.'/'.$msg = 14);
    //     }

    //     $config = array(
    //         'upload_path' => 'assets/img/wi/',
    //         'allowed_types' => "gif|JPG|jpg|png|jpeg",
    //         'file_name' =>  $fileName,
    //         'max_size' => "2048000"//,
    //     );

    //     //code for upload with ci
    //     $this->upload->initialize($config);

    //     //upload file to directory
    //     if($this->upload->do_upload('CHR_IMG_FILE_NAME')){
    //         $media = $this->upload->data('CHR_IMG_FILE_NAME');
    //         $inputFileName = $config['upload_path'] . $fileName; //$media['file_name'];

    //         $check_existing = $this->pos_m->check_existing_pos($part_no, $work_center, $pos);
    //         if($check_existing == true){
    //             redirect($this->back_to_manage.$work_center.'/'.$msg = 12);
    //         }else{
    //             $data = array(
    //                 'CHR_WORK_CENTER' => $work_center,
    //                 'CHR_PART_NO' => $part_no,
    //                 'CHR_POS_PRD' => $pos,
    //                 'CHR_IMG_FILE_NAME' => $inputFileName,
    //                 'CHR_CREATED_DATE' => $upload_date,
    //                 'CHR_CREATED_TIME' => $upload_time
    //             );
    //             $this->pos_m->save($data);

    //             redirect($this->back_to_manage.$work_center.'/'.$msg = 1);
    //         }
    //     }else{
    //         $error = $this->upload->display_errors();
    //         $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Uploading Failed</strong>$error</div >";

    //         $data['msg'] = $msg;
    //         $data['title'] = 'Create Pos';
    //         $data['content'] = 'prd/pos/create_pos_v';
    //         $data['app'] = $this->role_module_m->get_app();
    //         $data['module'] = $this->role_module_m->get_module();
    //         $data['function'] = $this->role_module_m->get_function();
    //         $data['sidebar'] = $this->role_module_m->side_bar(44);
    //         $data['news'] = $this->news_m->get_news();

    //         $data['all_work_centers'] = $this->direct_backflush_general_m->get_all_work_center_ines();
    //         $data['work_center'] =  $work_center;
    //         $data['part_no'] = $this->part_m->get_top_part_by_work_center($data['work_center']);
    //         $data['data_part_no'] = $this->part_m->get_data_part_by_work_center($data['work_center']);

    //         $this->load->view($this->layout, $data);
    //     }

    // }

    public function uploadPos()
    {
        $part_no = $this->input->post('CHR_PART_NO');
        $work_center = $this->input->post('CHR_WORK_CENTER');
        $pos = $this->input->post('CHR_POS_PRD');
        $user_session = $this->session->all_userdata();
        $maxsize = 5000000;
        $allow_ekstensi = array('png', 'jpg', 'jpeg', 'gif', 'JPG');

        $size = $_FILES['CHR_IMG_FILE_NAME']['size'];
        $file = $_FILES['CHR_IMG_FILE_NAME']['name'];
        $file_tmp = $_FILES['CHR_IMG_FILE_NAME']['tmp_name'];

        $x = explode('.', $file);
        $ekstensi = strtolower(end($x));

        if (in_array($ekstensi, $allow_ekstensi) === true) {
            if ($size <= $maxsize) {
                $fileName = $part_no . '-' . round(microtime(true)) . '.' . $ekstensi;

                // $dest = fopen("ftp://192.168.0.250:password@example.com/" . $fileName, "wb");
                // $src = file_get_contents($fileName);
                // fwrite($dest, $src, strlen($src));
                // fclose($dest);

                move_uploaded_file($file_tmp, DOCROOT . "/assets/img/wi/" . $fileName);

                $data = array(
                    'CHR_WORK_CENTER' => $work_center,
                    'CHR_PART_NO' => $part_no,
                    'CHR_POS_PRD' => $pos,
                    'CHR_IMG_FILE_NAME' => 'assets/img/wi/' . $fileName,
                    'INT_FLG_MODIFIED' => $this->input->post('FLG_LAST_POS'),
                    'CHR_CREATED_BY' => $user_session['USERNAME'],
                    'CHR_CREATED_DATE' => date('Ymd'),
                    'CHR_CREATED_TIME' => date('His')
                );
                $id = $this->pos_m->save($data);

                if ($this->input->post('FLG_LAST_POS') == 1) {
                    redirect('prd/pos_c/setCoordinate/' . $id);
                } else {
                    redirect($this->back_to_manage . $work_center . '/' . 1);
                }
            } else {
                //oversize
                redirect($this->back_to_manage . $work_center . '/' . 6);
            }
        } else {
            //miss extension
            redirect($this->back_to_manage . $work_center . '/' . 7);
        }
    }

    function edit_pos($id, $work_center, $part_no)
    {
        $this->check_session();
        $msg = "";

        $data['msg'] = $msg;
        $data['title'] = 'Edit Pos';
        $data['content'] = 'prd/pos/edit_pos_v';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(44);
        $data['news'] = $this->news_m->get_news();

        $data['all_work_centers'] = $this->direct_backflush_general_m->get_all_work_center_ines();
        $data['work_center'] = $work_center;
        $data['data_part_no'] = $this->part_m->get_data_part_by_work_center($work_center);

        $data['data'] = $this->pos_m->get_detail_pos_by_id($id);

        $this->load->view($this->layout, $data);
    }

    // function view_pos($id) {
    //     $this->check_session();
    //     $msg = "";

    //     $data['msg'] = $msg;
    //     $data['title'] = 'View Pos';
    //     $data['content'] = 'prd/pos/view_pos_v';
    //     $data['app'] = $this->role_module_m->get_app();
    //     $data['module'] = $this->role_module_m->get_module();
    //     $data['function'] = $this->role_module_m->get_function();
    //     $data['sidebar'] = $this->role_module_m->side_bar(44);
    //     $data['news'] = $this->news_m->get_news();

    //     $data['data_detail'] = $this->pos_m->get_detail_pos_by_id($id);

    //     $this->load->view($this->layout, $data);
    // }

    public function reuploadPos()
    {
        $this->load->library(array('PHPExcel', 'PHPExcel/IOFactory'));
        $this->load->library('upload');

        $id = $this->input->post('INT_ID');
        $part_no = $this->input->post('CHR_PART_NO');
        $work_center = $this->input->post('CHR_WORK_CENTER');
        $pos = $this->input->post('CHR_POS_PRD');
        $user_session = $this->session->all_userdata();

        $maxsize = 5000000;
        $allow_ekstensi = array('png', 'jpg', 'jpeg', 'gif', 'JPG');

        $size = $_FILES['CHR_IMG_FILE_NAME']['size'];
        $file = $_FILES['CHR_IMG_FILE_NAME']['name'];
        $file_tmp = $_FILES['CHR_IMG_FILE_NAME']['tmp_name'];

        $x = explode('.', $file);
        $ekstensi = strtolower(end($x));

        if (in_array($ekstensi, $allow_ekstensi) === true) {
            if ($size <= $maxsize) {
                $fileName = $part_no . '-' . round(microtime(true)) . '.' . $ekstensi;
                move_uploaded_file($file_tmp, DOCROOT . "/assets/img/wi/" . $fileName);

                $data = array(
                    'CHR_WORK_CENTER' => $work_center,
                    'CHR_PART_NO' => $part_no,
                    'CHR_POS_PRD' => $pos,
                    'CHR_IMG_FILE_NAME' => 'assets/img/wi/' . $fileName,
                    'INT_FLG_MODIFIED' => $this->input->post('FLG_LAST_POS'),
                    'CHR_MODIFIED_BY' => $user_session['USERNAME'],
                    'CHR_MODIFIED_DATE' => date('Ymd'),
                    'CHR_MODIFIED_TIME' => date('His')
                );

                $this->pos_m->update($data, $id);

                if ($this->input->post('FLG_LAST_POS') == 1) {
                    redirect('prd/pos_c/setCoordinate/' . $id);
                } else {
                    redirect($this->back_to_manage . $work_center . '/' . 2);
                }
            } else {
                //oversize
                redirect($this->back_to_manage . $work_center . '/' . 6);
            }
        } else {
            //miss extension
            redirect($this->back_to_manage . $work_center . '/' . 7);
        }
    }

    function delete_pos($id, $work_center)
    {
        $this->pos_m->delete($id);
        redirect($this->back_to_manage . $work_center . '/' . $msg = 3);
    }

    public function viewCheckPoint($id)
    {
        $this->check_session();
        $msg = "";

        $data['msg'] = $msg;
        $data['title'] = 'View Key Point';
        $data['content'] = 'prd/pos/view_keypoint_v';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(44);
        $data['news'] = $this->news_m->get_news();

        $data['data'] = $this->pos_m->get_detail_pos_by_id($id);
        $data['cek_no'] = '';
        $data['pointer'] = '';
        $data['data_detail'] = $this->pos_coordinate_m->get_coordinate_dandori_board($id);

        $this->load->view($this->layout, $data);
    }

    function update_notes()
    {
        $session = $this->session->all_userdata();
        $work_center = $this->input->post('CHR_WORK_CENTER');
        $notes = $this->input->post('CHR_NOTE');
        $id = $this->input->post('INT_ID');
        $date_modified = date('Ymd');
        $time_modified = date('His');

        $data = array(
            'CHR_NOTE' => $notes,
            'CHR_MODIFIED_BY' => $session['USERNAME'],
            'CHR_MODIFIED_DATE' => $date_modified,
            'CHR_MODIFIED_TIME' => $time_modified
        );

        $data_id = array(
            'INT_ID' => $id
        );

        $this->pos_m->update($data, $id);

        redirect($this->back_to_manage . $work_center . '/' . $msg = 2);
    }

    public function setCoordinate($id)
    {
        $data['msg'] = '';
        $data['title'] = 'Set Coordinate Dandori Board';
        $data['content'] = 'prd/pos/dandori_board_coordinate_v';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(44);
        $data['news'] = $this->news_m->get_news();

        $data['data'] = $this->pos_m->get_detail_pos_by_id($id);
        $data['cek_no'] = '';
        $data['pointer'] = '';
        $data['data_detail'] = $this->pos_coordinate_m->get_coordinate_dandori_board($id);

        $this->load->view($this->layout, $data);
    }

    public function saveCoordinate()
    {
        $key_point = $this->input->post('CHR_KEY_POINT');
        $x = $this->input->post('INT_COOR_X');
        $y = $this->input->post('INT_COOR_Y');
        $id_pos = $this->input->post('INT_ID_POS');
        $user_session = $this->session->all_userdata();

        $data_detail = array(
            'INT_COOR_X' => $x,
            'INT_COOR_Y' => $y,
            'INT_ID_POS' => $id_pos,
            'CHR_CREATED_BY' => $user_session['USERNAME'],
            'CHR_KEY_POINT' => $key_point
        );

        $this->pos_coordinate_m->save($data_detail);

        $data = array(
            'INT_FLG_MODIFIED' => 1
        );

        $this->pos_m->update($data, $id_pos);
    }

    public function deleteCoordinate()
    {
        $id = $this->input->post('INT_ID');
        $id_pos = $this->input->post('INT_ID_POS');

        $this->pos_coordinate_m->delete($id);

        if ($this->pos_coordinate_m->check_exist_coordinate_by_id($id_pos) == 0) {
            $data = array(
                'INT_FLG_MODIFIED' => 0
            );

            $this->pos_m->update($data, $id_pos);
        }
    }

    public function get_pos_by_work_center()
    {
        $work_center = $this->input->post("CHR_WORK_CENTER");

        $pos = $this->pos_m->get_top_pos_by_work_center($work_center);
        $data_pos = $this->pos_m->get_ddl_pos_by_work_center($work_center);
        $data = '';

        foreach ($data_pos as $row) {
            if (trim($pos) == trim($row->CHR_POS_PRD)) {
                $data .= "<option selected value='$row->CHR_POS_PRD'>" . $row->CHR_POS_PRD . "</option>";
            } else {
                $data .= "<option value='$row->CHR_POS_PRD'>" . $row->CHR_POS_PRD . "</option>";
            }
        }

        $json_data = array('data' => $data);

        echo json_encode($json_data);
    }
}
