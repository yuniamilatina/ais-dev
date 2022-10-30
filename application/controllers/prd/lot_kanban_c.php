<?php

//Add By bugsMaker 20170812
class lot_kanban_c extends CI_Controller {

    private $layout = '/template/head';
    private $back_to_upload = '/prd/lot_kanban_c/create_lot_kanban/';
    private $back_to_upload_overstock_parts = '/prd/lot_kanban_c/upload_overstock_parts/';
    private $back_to_reupload = '/prd/lot_kanban_c/edit_lot_kanban/';
    private $back_to_index = '/prd/lot_kanban_c/';

    public function __construct() {
        parent::__construct();
        $this->load->model('part/part_m');
        $this->load->model('prd/lot_kanban_m');
        $this->load->model('organization/dept_m');
        $this->load->model('prd/direct_backflush_general_m');
    }

    function index($msg = NULL) {
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(31);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Manage Lot Kanban';
        $data['msg'] = $msg;

        $id_dept = $this->dept_m->get_top_prod_dept()->row()->INT_ID_DEPT;
        $work_center = $this->direct_backflush_general_m->get_top_work_center_by_id_dept($id_dept);
        $all_dept_prod = $this->dept_m->get_all_prod_dept();
        $all_work_centers = $this->direct_backflush_general_m->get_work_center_by_id_dept($id_dept);

        $data['all_dept_prod'] = $all_dept_prod;
        $data['all_work_centers'] = $all_work_centers;
        $data['work_center'] = $work_center;
        $data['id_dept'] = $id_dept;

        $data['data'] = $this->part_m->get_data_part_kanban_by_work_center_for_lot_size($work_center);

        $data['content'] = 'prd/lot_kanban/manage_lot_kanban_v';
        $this->load->view($this->layout, $data);
    }

    function search_lot_kanban($msg = NULL) {
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
        $data['sidebar'] = $this->role_module_m->side_bar(31);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Manage Lot Kanban';
        $data['msg'] = $msg;
        
        $id_dept = $this->input->post('INT_ID_DEPT');
        $work_center = $this->input->post('CHR_WORK_CENTER');
        $all_dept_prod = $this->dept_m->get_all_prod_dept();
        $all_work_centers = $this->direct_backflush_general_m->get_work_center_by_id_dept($id_dept);

        $data['all_dept_prod'] = $all_dept_prod;
        $data['all_work_centers'] = $all_work_centers;
        $data['work_center'] = $work_center;
        $data['id_dept'] = $id_dept;

        $data['data'] = $this->part_m->get_data_part_kanban_by_work_center_for_lot_size($work_center);

        $data['content'] = 'prd/lot_kanban/manage_lot_kanban_v';
        $this->load->view($this->layout, $data);
    }

    function create_lot_kanban($id_dept = null, $work_center = null, $msg= null) {
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
        }

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(31);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Upload Lot Kanban';
        $data['msg'] = $msg;

        $data['work_center'] = $work_center;
        $data['id_dept'] = $id_dept;
        $data['increment'] = 0;
        $data['data'] = array(); 

        $data['content'] = 'prd/lot_kanban/upload_lot_kanban_v';
        $this->load->view($this->layout, $data);
    }

    function download_template_lot_kanban() {
        $this->load->helper('download');

        ob_clean();

        $name = 'template_lot_kanban_produksi.xlsx';
        $data = file_get_contents("assets/template/production/$name");

        force_download($name, $data);
    }

    function upload_lot_kanban(){
       $this->load->library(array('PHPExcel', 'PHPExcel/IOFactory'));
       $this->load->library('upload');

        $id_dept = $this->input->post('INT_ID_DEPT');
        $work_center = $this->input->post('CHR_WORK_CENTER');
        $upload_date = date('Ymd');
        $data_view['work_center'] = $work_center;
        $data_view['id_dept'] = $id_dept;

        $fileName = $_FILES['upload_lot_kanban']['name'];
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
        if ($a = $this->upload->do_upload('upload_lot_kanban'))
            $this->upload->display_errors();
        $media = $this->upload->data('upload_lot_kanban');
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
            $lot_size = $rowHeader[0][2];
            
            $i = 0;
            if (trim($no) == 'No' && trim($part_no) == 'Part No' && trim($lot_size) == 'Lot Size') {
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
                        $data[$i]['INT_LOT_SIZE'] = $rowData[0][2];
                        if(!is_numeric($rowData[0][2])){
                            $data[$i]['ERROR_MESSAGE'] = $rowData[0][2]. ' bukan angka, Lot Size harus diisi angka';
                        }

                        $i++;
                    }

                    $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Uploading success </strong> The temporary data is successfully created, to confirm click save at the bellow</div >";
                    
                    $data_view['app'] = $this->role_module_m->get_app();
                    $data_view['module'] = $this->role_module_m->get_module();
                    $data_view['function'] = $this->role_module_m->get_function();
                    $data_view['sidebar'] = $this->role_module_m->side_bar(31);
                    $data_view['news'] = $this->news_m->get_news();
                    $data_view['title'] = 'Upload Lot Kanban';
                    $data_view['msg'] = $msg;

                    $data_view['increment'] = $i;
                    $data_view['data'] = $data;

                    $data_view['content'] = 'prd/lot_kanban/upload_lot_kanban_v';
                    $this->load->view($this->layout, $data_view);

                } else {
                    redirect($this->back_to_upload .$msg = 15);
                }
        
    }

    function update_lot_kanban($msg = null){
        $session = $this->session->all_userdata();
        $name = $session['USERNAME'];
        $date = date('Ymd');
        $time = date('His');
        
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
        $data['sidebar'] = $this->role_module_m->side_bar(31);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Manage Lot Kanban';
        $data['msg'] = $msg;

        $part_no = $this->input->post('CHR_PART_NO');
        $lot_size = $this->input->post('INT_LOT_SIZE');
        $id_dept = $this->input->post('INT_ID_DEPT');
        $work_center = $this->input->post('CHR_WORK_CENTER');
        
        $data_row = array(
            'INT_LOT_SIZE' => $lot_size,
            'CHR_LOT_MODIFIED_BY' => $name,
            'CHR_LOT_MODIFIED_DATE' => $date,
            'CHR_LOT_MODIFIED_TIME' => $time
        );
            
        $id = array(
            'CHR_PART_NO' => $part_no
        );
            
        $this->part_m->update($data_row, $id); //search_lot_kanban

        $all_dept_prod = $this->dept_m->get_all_prod_dept();
        $all_work_centers = $this->direct_backflush_general_m->get_work_center_by_id_dept($id_dept);

        $data['all_dept_prod'] = $all_dept_prod;
        $data['all_work_centers'] = $all_work_centers;
        $data['work_center'] = $work_center;
        $data['id_dept'] = $id_dept;

        $data['data'] = $this->part_m->get_data_part_kanban_by_work_center_for_lot_size($work_center);

        $data['content'] = 'prd/lot_kanban/manage_lot_kanban_v';
        $this->load->view($this->layout, $data);
    }

    function update_lot_kanban_upload($msg = null) {
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
        $data['sidebar'] = $this->role_module_m->side_bar(31);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Manage Lot Kanban';
        $data['msg'] = $msg;

        $tableRow = $this->input->post("tableRow");
        $id_dept = $this->input->post('INT_ID_DEPT');
        $work_center = $this->input->post('CHR_WORK_CENTER');
        $created_by = $this->session->userdata('USERNAME');

        $session = $this->session->all_userdata();
        $name = $session['USERNAME'];
        $date = date('Ymd');
        $time = date('His');

        foreach ($tableRow as $row) {
            if($row['FLG_DELETE'] == 0){
                if(is_numeric($row['INT_LOT_SIZE'])){
                    $id['CHR_PART_NO'] = $row['CHR_PART_NO'];
                    $data_parts['INT_LOT_SIZE'] = $row['INT_LOT_SIZE'];
                    $data_parts['CHR_LOT_MODIFIED_BY'] = $name;
                    $data_parts['CHR_LOT_MODIFIED_DATE'] = $date;
                    $data_parts['CHR_LOT_MODIFIED_TIME'] = $time;

                    $this->part_m->update($data_parts, $id);
                }                
            }
        }

        $all_dept_prod = $this->dept_m->get_all_prod_dept();
        $all_work_centers = $this->direct_backflush_general_m->get_work_center_by_id_dept($id_dept);

        $data['all_dept_prod'] = $all_dept_prod;
        $data['all_work_centers'] = $all_work_centers;
        $data['work_center'] = $work_center;
        $data['id_dept'] = $id_dept;

        $data['data'] = $this->part_m->get_data_part_kanban_by_work_center_for_lot_size($work_center);

        $data['content'] = 'prd/lot_kanban/manage_lot_kanban_v';
        $this->load->view($this->layout, $data);
    }
    
    function sequence_lot_kanban($msg = NULL) {
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
        $data['sidebar'] = $this->role_module_m->side_bar(282);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Sequence Lot Kanban';
        $data['msg'] = $msg;
        
        $id_dept = $this->dept_m->get_top_prod_dept()->row()->INT_ID_DEPT;
        $work_center = $this->direct_backflush_general_m->get_top_work_center_by_id_dept($id_dept);
        $all_dept_prod = $this->dept_m->get_all_prod_dept();
        $all_work_centers = $this->direct_backflush_general_m->get_work_center_by_id_dept($id_dept);

        $data['all_dept_prod'] = $all_dept_prod;
        $data['all_work_centers'] = $all_work_centers;
        $data['work_center'] = $work_center;
        $data['id_dept'] = $id_dept;

        $data['data'] = $this->lot_kanban_m->get_sequence_lot_kanban($work_center);

        $data['content'] = 'prd/lot_kanban/view_sequence_lot_kanban_v';
        $this->load->view($this->layout, $data);
    }
    
    function search_sequence_lot_kanban($msg = NULL, $id_dept = NULL, $work_center = NULL) {
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
        } else {
            $msg = NULL;
        }
        
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(282);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Sequence Lot Kanban';
        $data['msg'] = $msg;
        
        if($id_dept == NULL || $id_dept == ''){
            $id_dept = '21';
        }
        
        if($work_center == NULL){
            $work_center = $this->direct_backflush_general_m->get_top_work_center_by_id_dept($id_dept);
        }
        
        $all_dept_prod = $this->dept_m->get_all_prod_dept();
        $all_work_centers = $this->direct_backflush_general_m->get_work_center_by_id_dept($id_dept);

        $data['all_dept_prod'] = $all_dept_prod;
        $data['all_work_centers'] = $all_work_centers;
        $data['work_center'] = $work_center;
        $data['id_dept'] = $id_dept;

        $data['data'] = $this->lot_kanban_m->get_sequence_lot_kanban($work_center);

        $data['content'] = 'prd/lot_kanban/view_sequence_lot_kanban_v';
        $this->load->view($this->layout, $data);
    }
    
    function delete_sequence_lot_kanban($id = NULL){ 
        $session = $this->session->all_userdata();
        $date = date('Ymd');
        $time = date('His');
        $user = $session['NPK'];        
        
        $data_part = $this->lot_kanban_m->get_detail_sequence_lot_kanban_by_id($id);
        $sequence = $data_part->INT_SEQUENCE;        
        $new_seq = 0;
        $work_center = $data_part->CHR_WORK_CENTER;
        $id_dept = $this->direct_backflush_general_m->get_prod_by_work_center($work_center);
        
        $this->lot_kanban_m->update_sequence_other_4($work_center, $sequence, $date, $time, $user); //update another sequence
        $this->lot_kanban_m->update_sequence($new_seq, $id, $date, $time, $user); //update sequence
        
        $this->lot_kanban_m->delete($id);
        
        redirect('prd/lot_kanban_c/search_sequence_lot_kanban/3/' . $id_dept . '/' . $work_center, 'refresh');
    }
    
    function create_special_order($msg= null, $id_dept = null, $work_center = null) {
        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Creating success </strong> The data is successfully created </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Updating success </strong> The data is successfully updated </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Deleted success </strong> The data is successfully deleted </div >";
        } elseif ($msg == 15) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Executing error !</strong> Cannot find BACK NO </div >";
        } elseif ($msg == 12) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Executing error !</strong> Something error with parameter </div >";
        } else {
            $msg = NULL;
        }
        
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(52);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Create Special order';
        $data['msg'] = $msg;
        
        $all_dept_prod = $this->dept_m->get_all_prod_dept();
        $all_work_centers = $this->direct_backflush_general_m->get_work_center_by_id_dept($id_dept);
        $all_part_no = $this->lot_kanban_m->get_all_part_no_by_wc($work_center);

        $data['all_dept_prod'] = $all_dept_prod;
        $data['all_work_centers'] = $all_work_centers;
        $data['all_part_no'] = $all_part_no;
        $data['work_center'] = $work_center;
        $data['id_dept'] = $id_dept;
        $last_seq = $this->lot_kanban_m->get_last_sequence($work_center);
        if(count($last_seq) == 0){
            $data['last_seq'] = 1;
        } else {
            $data['last_seq'] = $last_seq->INT_SEQUENCE + 1;
        }
        
        
        $data['content'] = 'prd/lot_kanban/create_lot_special_order_v';
        $this->load->view($this->layout, $data);
    }
    
    function save_special_order(){
        $session = $this->session->all_userdata();
        $date = date('Ymd');
        $time = date('His');
        $user = $session['NPK'];
        
        $new_sequence = $this->input->post('INT_SEQUENCE');
        $part_no = trim($this->input->post('CHR_PART_NO'));
        $id_dept = $this->input->post('INT_ID_DEPT');
        $work_center = trim($this->input->post('CHR_WORK_CENTER'));
        $lot_size = $this->input->post('INT_LOT_SIZE');
        $qty_per_box = $this->input->post('INT_QTY_PER_BOX');
        
        $cek_back_no = $this->lot_kanban_m->get_back_no_by_part_no($part_no);
        if(count($cek_back_no) == 0){
            redirect('prd/lot_kanban_c/create_special_order/15/' . $id_dept . '/' . $work_center, 'refresh');
        } else {
            $back_no = $cek_back_no->CHR_BACK_NO;
        }
        
        $this->lot_kanban_m->update_sequence_other_3($work_center, $new_sequence, $date, $time, $user); //update another sequence
        
        $data_row = array(
            'INT_SEQUENCE' => $new_sequence,
            'CHR_WORK_CENTER' => $work_center,
            'CHR_DATE' => $date,
            'CHR_PART_NO' => $part_no,
            'INT_LOT_SIZE' => $lot_size,
            'INT_QTY_PER_BOX' => $qty_per_box,
            'INT_QTY_PCS' => $lot_size*$qty_per_box,
            'CHR_CREATED_SYS' => 'DIRECT SO',
            'CHR_CREATED_BY' => $user,
            'CHR_CREATED_DATE' => $date,
            'CHR_CREATED_TIME' => $time,
            'INT_FLG_SO' => 1
        );        
        $this->lot_kanban_m->insert_special_order($data_row); //insert special order

        redirect('prd/lot_kanban_c/search_sequence_lot_kanban/1/' . $id_dept . '/' . $work_center, 'refresh');
    }
    
    function update_sequence_lot_kanban(){
        $session = $this->session->all_userdata();
        $date = date('Ymd');
        $time = date('His');
        $user = $session['NPK'];
        
        $id = $this->input->post('INT_ID');        
        $new_lot = $this->input->post('INT_LOT');
        $new_sequence = $this->input->post('INT_SEQUENCE');
        $part_no = $this->input->post('CHR_PART_NO');
        $id_dept = $this->input->post('INT_ID_DEPT');
        $work_center = $this->input->post('CHR_WORK_CENTER');
        $new_work_center = $this->input->post('CHR_NEW_WORK_CENTER');
        $qty_per_box = $this->input->post('INT_QTY_PER_BOX');
        $old_sequence = $this->input->post('INT_OLD_SEQUENCE');
        
        if($work_center != $new_work_center){
            $cek_last_seq_new_wc = $this->lot_kanban_m->get_last_sequence($new_work_center);
            if(count($cek_last_seq_new_wc) == 0){
                $last_seq_new_wc = 1;
            } else {
                $last_seq_new_wc = $cek_last_seq_new_wc->INT_SEQUENCE + 1;
            }
            
            $this->lot_kanban_m->update_sequence_other_higher($work_center, $old_sequence, $date, $time, $user); //update sequence higher old work center             

            $this->lot_kanban_m->update_move_sequence($new_work_center, $new_lot, $qty_per_box, $last_seq_new_wc, $id, $date, $time, $user); //update selected part no
        } else {
            if($new_sequence < $old_sequence){
                $this->lot_kanban_m->update_sequence_other($work_center, $old_sequence, $new_sequence, $date, $time, $user); //update another sequence
            } else if($new_sequence > $old_sequence) {
                $this->lot_kanban_m->update_sequence_other_2($work_center, $old_sequence, $new_sequence, $date, $time, $user); //update another sequence
            }

            $this->lot_kanban_m->update_new_sequence($new_lot, $qty_per_box, $new_sequence, $id, $date, $time, $user); //update selected part no    
        }

        redirect('prd/lot_kanban_c/search_sequence_lot_kanban/2/' . $id_dept . '/' . $work_center, 'refresh');
    }

    function edit_lot_kanban($id_dept = null, $work_center = null, $part_no = null) {        
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(31);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Edit Lot Kanban';

        $data['work_center'] = $work_center;
        $data['id_dept'] = $id_dept;        

        $data['data'] = $this->part_m->get_data_part_kanban_by_work_center_and_part_no_for_lot_size($work_center, $part_no);

        $data['content'] = 'prd/lot_kanban/edit_lot_kanban_v';
        $this->load->view($this->layout, $data);
    }

    function manage_add_info_kanban($msg = NULL) {
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(337);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Manage Additional Info Kanban';
        $data['msg'] = $msg;

        $id_dept = $this->dept_m->get_top_prod_dept()->row()->INT_ID_DEPT;
        $work_center = $this->direct_backflush_general_m->get_top_work_center_by_id_dept($id_dept);
        $all_dept_prod = $this->dept_m->get_all_prod_dept();
        $all_work_centers = $this->direct_backflush_general_m->get_work_center_by_id_dept($id_dept);
        $all_part_no = $this->part_m->get_data_part_by_work_center($work_center);
        // $part_no = $this->part_m->get_top_part_by_work_center($work_center);

        $data['all_dept_prod'] = $all_dept_prod;
        $data['all_work_centers'] = $all_work_centers;
        $data['all_part_no'] = $all_part_no;
        $data['work_center'] = $work_center;
        $data['id_dept'] = $id_dept;
        // $data['part_no'] = $part_no;

        $data['data'] = $this->lot_kanban_m->get_data_additional_info_kanban($work_center);

        $data['content'] = 'prd/lot_kanban/manage_add_info_kanban_v';
        $this->load->view($this->layout, $data);
    }

    function search_add_info_kanban($msg = NULL, $id_dept = NULL, $work_center = NULL) {
        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Creating success </strong> The data is successfully created </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Updating success </strong> The data is successfully updated </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Deleted success </strong> The data is successfully deleted </div >";
        } elseif ($msg == 15) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Executing error !</strong> Template Anda Salah atau sudah diubah, Silahkan Coba Lagi Dengan Template Yang Benar </div >";
        } elseif ($msg == 12) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Executing error !</strong> Something error with the data </div >";
        }

        if($id_dept == NULL || $id_dept == ''){
            $id_dept = $this->input->post('INT_ID_DEPT');
        }
        
        if($work_center == NULL){
            $work_center = $this->input->post('CHR_WORK_CENTER');
        }
        
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(337);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Manage Additional Info Kanban';
        $data['msg'] = $msg;
        
        $all_dept_prod = $this->dept_m->get_all_prod_dept();
        $all_work_centers = $this->direct_backflush_general_m->get_work_center_by_id_dept($id_dept);
        $all_part_no = $this->part_m->get_data_part_by_work_center($work_center);

        $data['all_dept_prod'] = $all_dept_prod;
        $data['all_work_centers'] = $all_work_centers;
        $data['all_part_no'] = $all_part_no;
        $data['work_center'] = $work_center;
        $data['id_dept'] = $id_dept;

        $data['data'] = $this->lot_kanban_m->get_data_additional_info_kanban($work_center);

        $data['content'] = 'prd/lot_kanban/manage_add_info_kanban_v';
        $this->load->view($this->layout, $data);
    }

    function add_info_kanban(){
        $session = $this->session->all_userdata();
        $date = date('Ymd');
        $time = date('His');
        $user = $session['USERNAME'];
        
        $id_dept = $this->input->post('INT_ID_DEPT');
        $part_no = trim($this->input->post('chr_part_no'));
        $work_center = trim($this->input->post('chr_work_center'));
        $info = $this->input->post('chr_add_info');
        
        $cek_back_no = $this->lot_kanban_m->get_back_no_by_part_no($part_no);
        if(count($cek_back_no) == 0){
            redirect('prd/lot_kanban_c/search_add_info_kanban/12/' . $id_dept .'/' . $work_center , 'refresh');
        }
        
        $data_row = array(
            'CHR_WORK_CENTER' => $work_center,
            'CHR_PART_NO' => $part_no,
            'CHR_KANBAN_ADDITIONAL_INFO' => $info,
            'CHR_CREATED_BY' => $user,
            'CHR_CREATED_DATE' => $date,
            'CHR_CREATED_TIME' => $time
        );        
        $this->lot_kanban_m->insert_additional_info_kanban($data_row);

        redirect('prd/lot_kanban_c/search_add_info_kanban/1/' . $id_dept . '/' . $work_center, 'refresh');
    }

    function update_add_info_kanban(){
        $session = $this->session->all_userdata();
        $date = date('Ymd');
        $time = date('His');
        $user = $session['USERNAME'];

        $id = $this->input->post('INT_ID');
        $id_dept = $this->input->post('INT_ID_DEPT');
        $part_no = trim($this->input->post('CHR_PART_NO'));
        $work_center = trim($this->input->post('CHR_WORK_CENTER'));
        $info = $this->input->post('chr_add_info');
        
        $this->lot_kanban_m->update_add_info_kanban($id, $info, $date, $time, $user);

        redirect('prd/lot_kanban_c/search_add_info_kanban/2/' . $id_dept . '/' . $work_center, 'refresh');
    }

    function delete_add_info_kanban($id, $id_dept, $work_center, $part_no){
        $session = $this->session->all_userdata();
        $date = date('Ymd');
        $time = date('His');
        $user = $session['USERNAME'];
        
        $this->lot_kanban_m->update_flag_delete_add_info_kanban($id, $date, $time, $user);

        redirect('prd/lot_kanban_c/search_add_info_kanban/3/' . $id_dept . '/' . $work_center, 'refresh');
    }

    function manage_overstock_parts($msg = NULL, $id_dept = NULL) {
        
        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Creating success </strong> The data is successfully created </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Updating success </strong> The data is successfully updated </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Deleted success </strong> The data is successfully deleted </div >";
        } elseif ($msg == 15) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Executing error !</strong> Template Anda Salah atau sudah diubah, Silahkan Coba Lagi Dengan Template Yang Benar </div >";
        } elseif ($msg == 12) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Executing error !</strong> Something error with the data </div >";
        } elseif ($msg == 0){
            $msg = NULL;
        }

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(349);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Manage Overstock Parts';
        $data['msg'] = $msg;

        if($id_dept == NULL){
            $id_dept = $this->dept_m->get_top_prod_dept()->row()->INT_ID_DEPT;
        }
        
        $all_dept_prod = $this->dept_m->get_all_prod_dept();
        $all_part_no = $this->lot_kanban_m->get_data_part_by_dept($id_dept);

        $data['all_dept_prod'] = $all_dept_prod;
        $data['all_part_no'] = $all_part_no;
        $data['id_dept'] = $id_dept;

        $data['data'] = $this->lot_kanban_m->get_data_overstock_parts_by_dept($id_dept);

        $data['content'] = 'prd/lot_kanban/manage_overstock_parts_v';
        $this->load->view($this->layout, $data);
    }

    function add_overstock_part(){
        $session = $this->session->all_userdata();
        $date = date('Ymd');
        $time = date('His');
        $user = $session['USERNAME'];
        
        $id_dept = $this->input->post('INT_ID_DEPT');
        $part_no = trim($this->input->post('chr_part_no'));
        $info = $this->input->post('chr_notes');
                
        $data_row = array(
            'CHR_PART_NO' => $part_no,
            'CHR_NOTES' => $info,
            'CHR_CREATED_BY' => $user,
            'CHR_CREATED_DATE' => $date,
            'CHR_CREATED_TIME' => $time
        );        
        $this->lot_kanban_m->insert_overstock_parts($data_row);

        redirect('prd/lot_kanban_c/manage_overstock_parts/1/' . $id_dept, 'refresh');
    }

    function delete_overstock_parts($id_dept, $id){
        $session = $this->session->all_userdata();
        $date = date('Ymd');
        $time = date('His');
        $user = $session['USERNAME'];
        
        $this->lot_kanban_m->update_flag_delete_overstock_parts($id, $date, $time, $user);

        redirect('prd/lot_kanban_c/manage_overstock_parts/3/' . $id_dept, 'refresh');
    }

    function update_overstock_parts(){
        $session = $this->session->all_userdata();
        $date = date('Ymd');
        $time = date('His');
        $user = $session['USERNAME'];

        $id = $this->input->post('INT_ID');
        $id_dept = $this->input->post('INT_ID_DEPT');
        $part_no = trim($this->input->post('CHR_PART_NO'));
        $info = $this->input->post('chr_notes');
        
        $this->lot_kanban_m->update_overstock_parts($id, $info, $date, $time, $user);

        redirect('prd/lot_kanban_c/manage_overstock_parts/2/' . $id_dept, 'refresh');
    }

    function upload_overstock_parts($id_dept = null, $msg= null) {
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
        }

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(349);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Upload Overstock Parts';
        $data['msg'] = $msg;

        $data['id_dept'] = $id_dept;
        $data['increment'] = 0;
        $data['data'] = array(); 

        $data['content'] = 'prd/lot_kanban/upload_overstock_parts_v';
        $this->load->view($this->layout, $data);
    }

    function download_template_overstock_parts() {
        $this->load->helper('download');

        ob_clean();

        $name = 'template_list_overstock_part.xlsx';
        $data = file_get_contents("assets/template/production/$name");

        force_download($name, $data);
    }

    function confirm_upload_overstock_parts(){
        $this->load->library(array('PHPExcel', 'PHPExcel/IOFactory'));
        $this->load->library('upload');
 
         $id_dept = $this->input->post('INT_ID_DEPT');
         $upload_date = date('Ymd');
         $data_view['id_dept'] = $id_dept;
 
         $fileName = $_FILES['upload_overstock_parts']['name'];
         if (empty($fileName)) {
             redirect($this->back_to_upload_overstock_parts .$msg = 14);
         }
 
         //file untuk submit file excel
         $config['upload_path'] = './assets/file/prd/';
         $config['file_name'] = $fileName;
         $config['allowed_types'] = 'xls|xlsx';
         $config['max_size'] = 10000;
 
         //code for upload with ci
         $this->upload->initialize($config);
         if ($a = $this->upload->do_upload('upload_overstock_parts'))
             $this->upload->display_errors();
         $media = $this->upload->data('upload_overstock_parts');
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
        $notes = $rowHeader[0][2];
             
        $i = 0;
        if (trim($no) == 'No' && trim($part_no) == 'Part No' && trim($notes) == 'Notes') {
            for ($row = 2; $row <= $highestRow; $row++) {
                $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);
 
                $data[$i]['FLG_DELETE'] = 0;
                $data[$i]['ERROR_MESSAGE'] = NULL;
                $data[$i]['WARNING_MESSAGE'] = NULL;
 
                $flag_existing = $this->part_m->check_existing_part_no($rowData[0][1]);
                if(!$flag_existing){
                    $data[$i]['FLG_DELETE'] = 1;
                    $data[$i]['ERROR_MESSAGE'] = 'Part No : '.$rowData[0][1]. ' tidak terdaftar';
                }

                $exist_overstock = $this->lot_kanban_m->check_existing_part_no_overstock($rowData[0][1]);
                if($exist_overstock > 0){
                    $data[$i]['WARNING_MESSAGE'] = 'Part No : '.$rowData[0][1]. ' sudah ada, save akan mereplace existing data';
                }
 
                $data[$i]['CHR_PART_NO'] = $rowData[0][1];
                $data[$i]['CHR_NOTES'] = $rowData[0][2];
 
                $i++;
            }
 
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Uploading success </strong> The temporary data is successfully created, to confirm click save at the bellow</div >";
                     
            $data_view['app'] = $this->role_module_m->get_app();
            $data_view['module'] = $this->role_module_m->get_module();
            $data_view['function'] = $this->role_module_m->get_function();
            $data_view['sidebar'] = $this->role_module_m->side_bar(349);
            $data_view['news'] = $this->news_m->get_news();
            $data_view['title'] = 'Upload Overstock Parts';
            $data_view['msg'] = $msg;
 
            $data_view['increment'] = $i;
            $data_view['data'] = $data;
 
            $data_view['content'] = 'prd/lot_kanban/upload_overstock_parts_v';
            $this->load->view($this->layout, $data_view);
 
        } else {
            redirect($this->back_to_upload_overstock_parts .$msg = 15);
        }
         
     }

     function save_overstock_parts_upload() {
        $tableRow = $this->input->post("tableRow");
        $id_dept = $this->input->post('INT_ID_DEPT');
        $created_by = $this->session->userdata('USERNAME');

        $session = $this->session->all_userdata();
        $name = $session['USERNAME'];
        $date = date('Ymd');
        $time = date('His');

        foreach ($tableRow as $row) {
            if($row['FLG_DELETE'] == 0){ 
                $this->lot_kanban_m->update_flag_delete_overstock_parts_by_part_no($row['CHR_PART_NO'], $date, $time, $name);

                $data_parts['CHR_PART_NO'] = $row['CHR_PART_NO'];
                $data_parts['CHR_NOTES'] = $row['CHR_NOTES'];
                $data_parts['CHR_CREATED_BY'] = $name;
                $data_parts['CHR_CREATED_DATE'] = $date;
                $data_parts['CHR_CREATED_TIME'] = $time;

                $this->lot_kanban_m->insert_overstock_parts($data_parts);
            }
        }

        redirect('prd/lot_kanban_c/manage_overstock_parts/1/' . $id_dept, 'refresh');
    }

}
