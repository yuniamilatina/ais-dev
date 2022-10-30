<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class manage_matrix_dandori_c extends CI_Controller {

    private $layout = '/template/head';
    private $back_to_manage = 'prd/manage_matrix_dandori_c/index/';
    private $back_to_upload = '/prd/manage_matrix_dandori_c/create_matrix_dandori/';
    private $back_to_manage_special = 'prd/manage_matrix_dandori_c/special_print_parts/';

    public function __construct() {
        parent::__construct();
        $this->load->model('prd/manage_matrix_dandori_m');
        $this->load->model('prd/direct_backflush_general_m');
        $this->load->model('organization/dept_m');
        $this->load->model('part/part_m');
    }

    function check_session() {
        $user_session = $this->session->all_userdata();
        if ($user_session['NPK'] == '') {
            redirect(base_url('index.php/login_c'));
        }
    }

    function index($msg = null, $id_dept = null, $work_center = null) {
        $this->check_session();

        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Creating success </strong> The data is successfully created </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Updating success </strong> The data is successfully updated </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Choosing failed </strong> You must select at least one data</div >";
        } elseif ($msg == 4) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Executing error !</strong> Something error with parameter </div >";
        }
        
        $back_no = '';

        if($id_dept == null){
            $id_dept = $this->dept_m->get_top_prod_dept()->row()->INT_ID_DEPT;
        } else if($id_dept == 'pass'){
            $all_work_centers = $this->direct_backflush_general_m->get_work_center_by_id_dept($id_dept);
        }
        
        if($work_center == null){
            $work_center = $this->direct_backflush_general_m->get_top_work_center_by_id_dept($id_dept);
        }
        
        $all_dept_prod = $this->dept_m->get_all_prod_dept();
        if($id_dept != 'pass'){
            $all_work_centers = $this->direct_backflush_general_m->get_work_center_by_id_dept($id_dept);
        }

        $data['all_dept_prod'] = $all_dept_prod;
        $data['all_work_centers'] = $all_work_centers;
        $data['work_center'] = $work_center;
        $data['id_dept'] = $id_dept;

        $data['msg'] = $msg;
        $data['title'] = 'Manage Matrix Dandori Parts';
        $data['content'] = 'prd/manage_matrix_dandori/manage_matrix_dandori_v';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(75);
        $data['news'] = $this->news_m->get_news();

        if($id_dept == 'pass'){
            $data['data'] = $this->manage_matrix_dandori_m->get_data_part_no_passthrough();
        } else {
            $data['data'] = $this->manage_matrix_dandori_m->get_data_part_no($work_center);
        }
        
        $this->load->view($this->layout, $data);
    }

    function search_part_no($msg = NULL) {
        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Creating success </strong> The data is successfully created </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Updating success </strong> The data is successfully updated </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Deleted success </strong> The data is successfully deleted </div >";
        } elseif ($msg == 4) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Executing error !</strong> Something error with parameter </div >";
        }

        $id_dept = $this->input->post('CHR_DEPT');
        $work_center = $this->input->post('CHR_WORK_CENTER');
        $all_dept_prod = $this->dept_m->get_all_prod_dept();
        $all_work_centers = $this->direct_backflush_general_m->get_work_center_by_id_dept($id_dept);

        $data['all_dept_prod'] = $all_dept_prod;
        $data['all_work_centers'] = $all_work_centers;
        $data['work_center'] = $work_center;
        $data['id_dept'] = $id_dept;

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(75);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Manage Matrix Dandori Parts';
        $data['msg'] = $msg;

        if($id_dept == 'pass'){
            $data['data'] = $this->manage_matrix_dandori_m->get_data_part_no_passthrough();
        } else {
            $data['data'] = $this->manage_matrix_dandori_m->get_data_part_no($work_center);
        }

        $data['content'] = 'prd/manage_matrix_dandori/manage_matrix_dandori_v';
        $this->load->view($this->layout, $data);
    }
    
    function update_matrix_part(){
        $user_session = $this->session->all_userdata(); 

        $part_no = $this->input->post('CHR_PART_NO');
        $group = $this->input->post('DANDORI_GROUP');
        $id_dept = $this->input->post('CHR_DEPT');
        $work_center = $this->input->post('CHR_WORK_CENTER');
        
        $this->manage_matrix_dandori_m->update($part_no, $work_center, $group);

        redirect($this->back_to_manage . $msg = 2 . '/' . $id_dept . '/' . $work_center);
    }

    function create_matrix_dandori($msg = null, $id_dept = null, $work_center = null) {
        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Uploading success </strong> The temporary data is successfully created, to confirm click save at the bellow</div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Updating success </strong> The data is successfully updated </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Deleted success </strong> The data is successfully deleted </div >";
        } elseif ($msg == 13) {
            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Lot Reason empty !</strong>Please, Fill the reason of additional quota</div >";
        } elseif ($msg == 14) {
            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>File not Found !</strong>Choose your file to be upload</div >";
        } elseif ($msg == 15) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Executing error !</strong> Template Anda Salah atau sudah diubah, Silahkan Coba Lagi Dengan Template Yang Benar </div >";
        } elseif ($msg == 12) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Executing error !</strong> Something error with parameter </div >";
        } else {
            $msg = null;
        }

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(75);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Upload Matrix Dandori';
        $data['msg'] = $msg;

        $data['work_center'] = $work_center;
        $data['id_dept'] = $id_dept;
        $data['increment'] = 0;
        $data['data'] = array(); 

        $data['content'] = 'prd/manage_matrix_dandori/upload_matrix_dandori_v';
        $this->load->view($this->layout, $data);
    }

    function download_template_matrix_dandori() {
        $this->load->helper('download');

        ob_clean();

        $name = 'template_matrix_dandori.xlsx';
        $data = file_get_contents("assets/template/production/$name");

        force_download($name, $data);
    }

    function upload_matrix_dandori(){
        $this->load->library(array('PHPExcel', 'PHPExcel/IOFactory'));
        $this->load->library('upload');
 
         $id_dept = $this->input->post('INT_ID_DEPT');
         $work_center = $this->input->post('CHR_WORK_CENTER');
         $upload_date = date('Ymd');
         $data_view['work_center'] = $work_center;
         $data_view['id_dept'] = $id_dept;
 
         $fileName = $_FILES['upload_matrix_dandori']['name'];
         if (empty($fileName)) {
             redirect($this->back_to_upload .$msg = 14);
         }
 
         //file untuk submit file excel
         $config['upload_path'] = './assets/file/prd/';
         $config['file_name'] = $fileName;
         $config['allowed_types'] = 'xls|xlsx';
         $config['max_size'] = 10000;
 
         //code for upload with ci
         $this->upload->initialize($config);
         if ($a = $this->upload->do_upload('upload_matrix_dandori'))
             $this->upload->display_errors();
         $media = $this->upload->data('upload_matrix_dandori');
         $inputFileName = './assets/file/prd/' . $media['file_name'];
 
         //  Read  Excel workbook
         try {
             $inputFileType = IOFactory::identify($inputFileName);
             $objReader = IOFactory::createReader($inputFileType);
             $objPHPExcel = $objReader->load($inputFileName);
         } catch (Exception $e) {
             die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' . $e->getMessage());
         }
             //Get worksheet dimensions
             $sheet = $objPHPExcel->getSheet(0);
             $highestRow = $sheet->getHighestRow();
             $highestColumn = $sheet->getHighestColumn();
 
             $rowHeader = $sheet->rangeToArray('A1:' . $highestColumn . '1', NULL, TRUE, FALSE);
 
             $no = $rowHeader[0][0];
             $part_no = $rowHeader[0][1];
             $dandori_group = $rowHeader[0][2];
             
             $i = 0;
             if (trim($no) == 'No' && trim($part_no) == 'Part No' && trim($dandori_group) == 'Dandori Group') {
                     for ($row = 2; $row <= $highestRow; $row++) {
                         $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);
 
                         $data[$i]['FLG_DELETE'] = 0;
                         $data[$i]['ERROR_MESSAGE'] = NULL;
 
                         $flag_existing = $this->part_m->check_existing_part_no($rowData[0][1]);
                         if(!$flag_existing){
                             $data[$i]['FLG_DELETE'] = 1;
                             $data[$i]['ERROR_MESSAGE'] = 'Part No : '.$rowData[0][1]. ' tidak terdaftar';
                         }
 
                         $data[$i]['CHR_PART_NO'] = $rowData[0][1];
                         $data[$i]['CHR_MATRIX_DANDORI'] = $rowData[0][2];
                         if(strlen($rowData[0][2]) != 2){
                             $data[$i]['ERROR_MESSAGE'] = $rowData[0][2]. ' tidak standard, Dandori Group harus diisi 2 karakter (Huruf+Angka)';
                         }
 
                         $i++;
                     }
 
                     $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Uploading success </strong> The temporary data is successfully created, to confirm click save at the bellow</div >";
                     
                     $data_view['app'] = $this->role_module_m->get_app();
                     $data_view['module'] = $this->role_module_m->get_module();
                     $data_view['function'] = $this->role_module_m->get_function();
                     $data_view['sidebar'] = $this->role_module_m->side_bar(72);
                     $data_view['news'] = $this->news_m->get_news();
                     $data_view['title'] = 'Upload Matrix Dandori';
                     $data_view['msg'] = $msg;
 
                     $data_view['increment'] = $i;
                     $data_view['data'] = $data;
 
                     $data_view['content'] = 'prd/manage_matrix_dandori/upload_matrix_dandori_v';
                     $this->load->view($this->layout, $data_view);
 
                 } else {
                     redirect($this->back_to_upload .$msg = 15);
                 }         
     }

     function save_upload_matrix_dandori($msg = null) {
        $msg = 2;
        
        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Creating success </strong> The data is successfully created </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Updating success </strong> The data is successfully updated </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Deleted success </strong> The data is successfully deleted </div >";
        } elseif ($msg == 15) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Executing error !</strong> Template Anda Salah atau sudah diubah, Silahkan Coba Lagi Dengan Template Yang Benar </div >";
        } elseif ($msg == 12) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Executing error !</strong> Something error with parameter </div >";
        }
        
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(75);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Manage Matrix Dandori';
        $data['msg'] = $msg;

        $tableRow = $this->input->post("tableRow");
        $id_dept = $this->input->post('INT_ID_DEPT');
        $work_center = $this->input->post('CHR_WORK_CENTER');
        $created_by = $this->session->userdata('USERNAME');

        foreach ($tableRow as $row) {
            if($row['FLG_DELETE'] == 0){
                if(strlen($row['CHR_MATRIX_DANDORI']) == 2){
                    $part_no = $row['CHR_PART_NO'];
                    $group = $row['CHR_MATRIX_DANDORI'];

                    $this->manage_matrix_dandori_m->update($part_no, $work_center, $group);
                }                
            }
        }

        $all_dept_prod = $this->dept_m->get_all_prod_dept();
        $all_work_centers = $this->direct_backflush_general_m->get_work_center_by_id_dept($id_dept);

        $data['all_dept_prod'] = $all_dept_prod;
        $data['all_work_centers'] = $all_work_centers;
        $data['work_center'] = $work_center;
        $data['id_dept'] = $id_dept;

        $data['data'] = $this->manage_matrix_dandori_m->get_data_part_no($work_center);

        $data['content'] = 'prd/manage_matrix_dandori/manage_matrix_dandori_v';
        $this->load->view($this->layout, $data);
    }

    function update_rack_no(){
        $user_session = $this->session->all_userdata(); 

        $part_no = $this->input->post('CHR_PART_NO');
        $kbn_type = $this->input->post('CHR_KANBAN_TYPE');
        $rackno = $this->input->post('RACKNO');
        $id_dept = $this->input->post('CHR_DEPT');
        $work_center = $this->input->post('CHR_WORK_CENTER');

        if($id_dept == 'pass'){
            $work_center = 'pass';
        }
        
        $this->manage_matrix_dandori_m->update_rack_no(trim($part_no), $kbn_type, trim($rackno));

        redirect($this->back_to_manage . $msg = 2 . '/' . $id_dept . '/' . $work_center);
    }

    function special_print_parts($msg = null, $id_dept = null, $work_center = null) {
        $this->check_session();

        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Creating success </strong> The data is successfully created </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Updating success </strong> The data is successfully updated </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Choosing failed </strong> You must select at least one data</div >";
        } elseif ($msg == 4) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Executing error !</strong> Something error with parameter </div >";
        }
        
        $back_no = '';

        if($id_dept == null){
            // $id_dept = $this->dept_m->get_top_prod_dept()->row()->INT_ID_DEPT;
            $id_dept = 23;
        }

        if($work_center == null){
            // $work_center = $this->direct_backflush_general_m->get_top_work_center_by_id_dept($id_dept);
            $work_center = 'ASCD02';
        }

        $all_dept_prod = $this->manage_matrix_dandori_m->get_all_prod_dept();
        $all_work_centers = $this->direct_backflush_general_m->get_work_center_by_id_dept($id_dept);
        

        $data['all_dept_prod'] = $all_dept_prod;
        $data['all_work_centers'] = $all_work_centers;
        $data['work_center'] = $work_center;
        $data['id_dept'] = $id_dept;
        $data['all_part_no'] = $this->manage_matrix_dandori_m->get_all_part_no($work_center);
        $data['all_printer'] = $this->manage_matrix_dandori_m->get_all_printer($work_center);

        $data['msg'] = $msg;
        $data['title'] = 'Manage Special Print Parts';
        $data['content'] = 'prd/manage_matrix_dandori/manage_special_print_parts_v';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(327);
        $data['news'] = $this->news_m->get_news();

        $data['data'] = $this->manage_matrix_dandori_m->get_data_part_no_special_print($work_center);
        
        $this->load->view($this->layout, $data);
    }

    function search_special_print_parts($msg = NULL) {
        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Creating success </strong> The data is successfully created </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Updating success </strong> The data is successfully updated </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Deleted success </strong> The data is successfully deleted </div >";
        } elseif ($msg == 4) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Executing error !</strong> Something error with parameter </div >";
        }

        $id_dept = $this->input->post('CHR_DEPT');
        $work_center = $this->input->post('CHR_WORK_CENTER');
        $all_dept_prod = $this->dept_m->get_all_prod_dept();
        $all_work_centers = $this->direct_backflush_general_m->get_work_center_by_id_dept($id_dept);

        $data['all_dept_prod'] = $all_dept_prod;
        $data['all_work_centers'] = $all_work_centers;
        $data['work_center'] = $work_center;
        $data['id_dept'] = $id_dept;
        $data['all_part_no'] = $this->manage_matrix_dandori_m->get_all_part_no($work_center);
        $data['all_printer'] = $this->manage_matrix_dandori_m->get_all_printer($work_center);

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(327);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Manage Special Print Parts';
        $data['msg'] = $msg;

        $data['data'] = $this->manage_matrix_dandori_m->get_data_part_no_special_print($work_center);

        $data['content'] = 'prd/manage_matrix_dandori/manage_special_print_parts_v';
        $this->load->view($this->layout, $data);
    }

    function update_special_print_parts($id){
        $date = date('Ymd');
        $time = date('His');
        $session = $this->session->all_userdata();
        $user = $session['NPK'];
        
        $data = $this->manage_matrix_dandori_m->get_data_part_no_special_print_by_id($id);        
        $work_center = $data->CHR_WORK_CENTER;
        $id_dept = $this->direct_backflush_general_m->get_prod_by_work_center($work_center);
        
        $flag = 0;
        if($data->INT_FLG_DEL == 0){
            $flag = 1;
        } else {
            $flag = 0;
        }
        
        $this->manage_matrix_dandori_m->update_special_print_parts($id, $flag, $date, $time, $user);
        
        redirect('prd/manage_matrix_dandori_c/search_special_print_parts/3/' . $id_dept . '/' . $work_center, 'refresh');
    }

    function get_part_name() {
        $part_no = $this->input->post('part_no');
        $part = $this->db->query("SELECT RTRIM(A.CHR_PART_NAME) AS CHR_PART_NAME, RTRIM(B.CHR_BACK_NO) AS CHR_BACK_NO
                            FROM TM_PARTS A
                            LEFT JOIN TM_KANBAN B ON A.CHR_PART_NO = B.CHR_PART_NO
                            WHERE A.CHR_PART_NO = '$part_no'")->row();
        $data = $part->CHR_BACK_NO . ' - ' . $part->CHR_PART_NAME;
        
        echo json_encode($data);
    }

    function add_new_special_part(){
        $id_dept = $this->input->post('dept');
        $work_center = $this->input->post('work_center');
        $part_no = $this->input->post('part_no');
        $id_printer = $this->input->post('printer');

        $date = date('Ymd');
        $time = date('His');
        $session = $this->session->all_userdata();
        $user = $session['NPK'];

        $data_row = array(            
            'CHR_PART_NO' => $part_no,
            'CHR_WORK_CENTER' => $work_center,
            'INT_ID_PRINTER' => $id_printer,
            'CHR_CREATED_BY' => $user,
            'CHR_CREATED_DATE' => $date,
            'CHR_CREATED_TIME' => $time,
            'INT_FLG_DEL' => 0
        ); 
        $this->manage_matrix_dandori_m->add_new_special_part($data_row);

        redirect($this->back_to_manage_special . $msg = 1 . '/' . $id_dept . '/' . $work_center);
    }

    function edit_special_parts(){
        $date = date('Ymd');
        $time = date('His');
        $session = $this->session->all_userdata();
        $user = $session['NPK'];
        
        $id = $this->input->post('id');       
        $work_center = $this->input->post('work_center');
        $id_dept = $this->input->post('dept');
        $id_printer = $this->input->post('printer');
        
        $this->manage_matrix_dandori_m->edit_special_print_parts($id, $id_printer, $date, $time, $user);
        
        redirect('prd/manage_matrix_dandori_c/search_special_print_parts/3/' . $id_dept . '/' . $work_center, 'refresh');
    }
    
}

?>
