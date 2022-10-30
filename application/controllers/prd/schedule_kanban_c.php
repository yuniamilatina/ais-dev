<?php

//Add By bugsMaker 20170812
class schedule_kanban_c extends CI_Controller {

    private $layout = '/template/head';
    private $back_to_upload = '/prd/schedule_kanban_c/create_schedule_kanban/';
    private $back_to_index = '/prd/schedule_kanban_c/index/';

    public function __construct() {
        parent::__construct();
        $this->load->model('prd/schedule_kanban_m');
        $this->load->model('part/part_m');
        $this->load->model('organization/dept_m');
        $this->load->model('prd/direct_backflush_general_m');
    }

    function index($msg = NULL) {
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
        
        $status = 0;

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(29);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Manage Schedule Kanban';
        $data['msg'] = $msg;

        $period = date('Ym');
        $id_dept = $this->dept_m->get_top_prod_dept()->row()->INT_ID_DEPT;
        $work_center = $this->direct_backflush_general_m->get_top_work_center_by_id_dept($id_dept);
        $all_dept_prod = $this->dept_m->get_all_prod_dept();
        $all_work_centers = $this->direct_backflush_general_m->get_work_center_by_id_dept($id_dept);

        $data['all_dept_prod'] = $all_dept_prod;
        $data['all_work_centers'] = $all_work_centers;
        $data['work_center'] = $work_center;
        $data['id_dept'] = $id_dept;
        $data['status'] = $status;

        $data['period'] = $period;
        $data['data'] = $this->schedule_kanban_m->get_data_schedule_kanban_by_period_new($period, $work_center, $status);
        $data['content'] = 'prd/schedule_kanban/manage_schedule_kanban_v';
        $this->load->view($this->layout, $data);
    }

    function search_schedule_kanban($period = null, $id_dept = null, $work_center = null, $status = NULL, $msg = NULL) {
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

        if(!$this->direct_backflush_general_m->get_verification_work_center_and_id_dept($id_dept, $work_center)){
            $work_center = $this->direct_backflush_general_m->get_top_work_center_by_id_dept($id_dept);
        }
        
        if($status == NULL){
            $status = 0;
        }

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(29);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Manage Schedule Kanban';
        $data['msg'] = $msg;

        $all_dept_prod = $this->dept_m->get_all_prod_dept();
        $all_work_centers = $this->direct_backflush_general_m->get_work_center_by_id_dept($id_dept);

        $data['all_dept_prod'] = $all_dept_prod;
        $data['all_work_centers'] = $all_work_centers;
        $data['work_center'] = $work_center;
        $data['id_dept'] = $id_dept;
        $data['period'] = $period;
        $data['status'] = $status;

        $data['data'] = $this->schedule_kanban_m->get_data_schedule_kanban_by_period_new($period, $work_center, $status);
        $data['content'] = 'prd/schedule_kanban/manage_schedule_kanban_v';
        $this->load->view($this->layout, $data);
    }

    function create_schedule_kanban($period = null, $id_dept = null, $work_center = null, $msg= null) {
        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Uploading success </strong> The temporary data is successfully created, to confirm click save at the bellow</div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Updating success </strong> The data is successfully updated </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Deleted success </strong> The data is successfully deleted </div >";
        } elseif ($msg == 13) {
            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Schedule Reason empty !</strong>Please, Fill the reason of additional quota</div >";
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
        $data['sidebar'] = $this->role_module_m->side_bar(29);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Upload Schedule Kanban';
        $data['msg'] = $msg;

        $data['work_center'] = $work_center;
        $data['id_dept'] = $id_dept;
        $data['period'] = $period;
        $data['data'] = array(); 
        $data['increment'] = 0;

        $data['content'] = 'prd/schedule_kanban/upload_schedule_kanban_v';
        $this->load->view($this->layout, $data);
    }

    function download_template_schedule_kanban() {
        $this->load->helper('download');

        ob_clean();

        $name = 'template_schedule_kanban_produksi.xlsx';
        $data = file_get_contents("assets/template/production/$name");

        force_download($name, $data);
    }

    function upload_schedule_kanban(){
       $this->load->library(array('PHPExcel', 'PHPExcel/IOFactory'));
       $this->load->library('upload');

       $period = $this->input->post('CHR_PERIOD');
       $id_dept = $this->input->post('INT_ID_DEPT');
       $work_center = $this->input->post('CHR_WORK_CENTER');

        $upload_date = date('Ymd');

        $fileName = $_FILES['upload_schedule']['name'];
        if (empty($fileName)) {
            redirect($this->back_to_upload .$period.'/'.$id_dept.'/'.$work_center.'/'.$msg = 14);
        }

        //file untuk submit file excel
        $config['upload_path'] = './assets/file/prd/';
        $config['file_name'] = $fileName;
        $config['allowed_types'] = 'xls|xlsx';
        $config['max_size'] = 10000;

        //code for upload with ci
        $this->upload->initialize($config);
        if ($a = $this->upload->do_upload('upload_schedule'))
            $this->upload->display_errors();
        $media = $this->upload->data('upload_schedule');
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
            $work_center_excel = $rowHeader[0][1];
            $part_no = $rowHeader[0][2];
            $date = $rowHeader[0][3];
            $lot_size = $rowHeader[0][4];            
            $so = $rowHeader[0][5];  
            
            $i = 0;
            $r = 0;
            if (trim($no) == 'No' && trim($work_center_excel) == 'Work Center' && trim($part_no) == 'Part No' && $date == 'Tanggal' && trim($lot_size) == 'Jumlah Kanban') {
                    for ($row = 2; $row <= $highestRow; $row++) {
                        $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);

                        $flg_delete = 0;
                        $err_message = NULL;
                        
                        $qty_so = $rowData[0][5];
                        $int_qty_per_box = 0;
                        $int_qty_pcs = 0;
                        $int_flg_so = 0;

                        $flag_routing = $this->part_m->check_routing_part_no($rowData[0][1], $rowData[0][2]);
                        if(!$flag_routing){
                            $flg_delete = 1;
                            $err_message = 'Part No : '.$rowData[0][2]. ' tidak terdaftar di work center ' .$rowData[0][1];
                        }

                        $flag_kanban_exist = $this->part_m->check_exist_kanban_part_no_for_schedule_kanban($rowData[0][1], $rowData[0][2]);
                        if(!$flag_kanban_exist){
                            $flg_delete = 1;
                            $err_message = 'Kanban belum tersedia untuk Part No : '.$rowData[0][2]. ' untuk work center ' .$rowData[0][1];
                        }
                        
                        if(!is_numeric($rowData[0][4])){
                            $err_message = $err_message . ' "'.$rowData[0][4]. '" bukan angka, Lot Size harus angka';
                        }

                        $flag_existing = $this->part_m->check_existing_part_no($rowData[0][2]);                        
                        if(!$flag_existing){
                            $flg_delete = 1;
                            $err_message = $err_message . ' Part No : '.$rowData[0][2]. ' tidak terdaftar';
                        } else {
                            $max_lot = $flag_existing[0]->INT_LOT_SIZE;
                            if($max_lot == NULL || $max_lot == 0){
                                $flg_delete = 1;
                                $err_message = $err_message . ' Part No : '.$rowData[0][2]. ' belum disetting maksimal lot size';
                            } else {
                                if($qty_so != null || $qty_so != '' || $qty_so != 0){
                                    if(!is_numeric($rowData[0][5])){
                                        $err_message = $err_message . ' "'.$rowData[0][5]. '" bukan angka, Qty/box harus angka';
                                    } else {
                                        $int_qty_per_box = $qty_so;
                                        $int_qty_pcs = $int_qty_per_box * $rowData[0][4];
                                        $int_flg_so = 1;
                                    }
                                } else {
                                    //$int_qty_per_box = $this->part_m->get_data_detail_part($rowData[0][2])->INT_QTY_PER_BOX; //=== from TM_PART
                                    $int_qty_per_box = $this->schedule_kanban_m->get_data_detail_part_new($rowData[0][2]); //=== from TM_KANBAN
                                    $int_qty_pcs = $int_qty_per_box * $rowData[0][4];
                                }
                            }                            
                        }

                        if($rowData[0][4] > $max_lot && $flg_delete == 0 && $int_flg_so == 0){
                            $x = floor($rowData[0][4]/$max_lot);
                            $lot_sisa = $rowData[0][4]%$max_lot;
                            
                            for($y = 1; $y <= $x; $y++){
                                $data[$r]['INT_SEQUENCE'] = $rowData[0][0];
                                $data[$r]['CHR_WORK_CENTER'] = $rowData[0][1];
                                $data[$r]['CHR_PART_NO'] = $rowData[0][2];
                                $data[$r]['MAX_LOT_SIZE'] = $max_lot;
                                $data[$r]['INT_LOT_SIZE'] = $max_lot;
                                $data[$r]['CHR_DATE'] = $rowData[0][3];
                                $data[$r]['INT_QTY_PER_BOX'] = $int_qty_per_box;
                                $data[$r]['INT_QTY_PCS'] = $int_qty_per_box*$max_lot;
                                $data[$r]['INT_FLG_SO'] = $int_flg_so;
                                $data[$r]['FLG_DELETE'] = $flg_delete;
                                $data[$r]['ERROR_MESSAGE'] = $err_message;

                                $r++;
                            }

                            if($lot_sisa > 0){                                
                                $data[$r]['INT_SEQUENCE'] = $rowData[0][0];
                                $data[$r]['CHR_WORK_CENTER'] = $rowData[0][1];
                                $data[$r]['CHR_PART_NO'] = $rowData[0][2];
                                $data[$r]['MAX_LOT_SIZE'] = $max_lot;
                                $data[$r]['INT_LOT_SIZE'] = $lot_sisa;
                                $data[$r]['CHR_DATE'] = $rowData[0][3];
                                $data[$r]['INT_QTY_PER_BOX'] = $int_qty_per_box;
                                $data[$r]['INT_QTY_PCS'] = $int_qty_per_box*$lot_sisa;
                                $data[$r]['INT_FLG_SO'] = $int_flg_so;
                                $data[$r]['FLG_DELETE'] = $flg_delete;
                                $data[$r]['ERROR_MESSAGE'] = $err_message;
                                $r++;                                
                            }
                        } else {
                            $data[$r]['INT_SEQUENCE'] = $rowData[0][0];
                            $data[$r]['CHR_WORK_CENTER'] = $rowData[0][1];
                            $data[$r]['CHR_PART_NO'] = $rowData[0][2];
                            $data[$r]['MAX_LOT_SIZE'] = $max_lot;
                            $data[$r]['INT_LOT_SIZE'] = $rowData[0][4];
                            $data[$r]['CHR_DATE'] = $rowData[0][3];
                            $data[$r]['INT_QTY_PER_BOX'] = $int_qty_per_box;
                            $data[$r]['INT_QTY_PCS'] = $int_qty_pcs;
                            $data[$r]['INT_FLG_SO'] = $int_flg_so;
                            $data[$r]['FLG_DELETE'] = $flg_delete;
                            $data[$r]['ERROR_MESSAGE'] = $err_message;
                            $r++;
                        }

                        $i++;
                    }

                    $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Uploading success </strong> The temporary data is successfully created, to confirm click save at the bellow</div >";
                    
                    $data_view['app'] = $this->role_module_m->get_app();
                    $data_view['module'] = $this->role_module_m->get_module();
                    $data_view['function'] = $this->role_module_m->get_function();
                    $data_view['sidebar'] = $this->role_module_m->side_bar(29);
                    $data_view['news'] = $this->news_m->get_news();
                    $data_view['title'] = 'Upload Schedule Kanban';
                    $data_view['msg'] = $msg;

                    $data_view['period'] = $period;
                    $data_view['work_center'] = $work_center;
                    $data_view['id_dept'] = $id_dept;

                    $data_view['increment'] = $r;
                    $data_view['data'] = $data;

                    $data_view['content'] = 'prd/schedule_kanban/upload_schedule_kanban_v';

                    $this->load->view($this->layout, $data_view);

                } else {
                    redirect($this->back_to_upload .$period.'/'.$id_dept.'/'.$work_center.'/'.$msg = 15);
                }
        
    }

    function edit_schedule_kanban($id = null, $work_center = null, $status = null, $msg= null) {
        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Uploading success </strong> The temporary data is successfully created, to confirm click save at the bellow</div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Updating success </strong> The data is successfully updated </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Deleted success </strong> The data is successfully deleted </div >";
        } elseif ($msg == 13) {
            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Schedule Reason empty !</strong>Please, Fill the reason of additional quota</div >";
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
        $data['sidebar'] = $this->role_module_m->side_bar(29);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Reupload Schedule Kanban';
        $data['msg'] = $msg;
        $data['status'] = $status;

        $id_dept = $this->direct_backflush_general_m->get_prod_by_work_center($work_center);

        $data['all_dept_prod'] = $this->dept_m->get_all_prod_dept();
        $data['all_work_centers'] = $this->direct_backflush_general_m->get_work_center_by_id_dept($id_dept);
        $data['work_center'] = $work_center;
        $data['id_dept'] = $id_dept;        
        $data['data_part_no'] = $this->part_m->get_data_part_by_work_center($work_center);

        $data['data'] = $this->schedule_kanban_m->get_detail_schedule_kanban_by_id($id);
        $period = substr($data['data']->CHR_DATE, 0, 6);
        $data['period'] = $period;
        $data['max_seq'] = count($this->schedule_kanban_m->get_data_schedule_kanban_by_period_new($period, $work_center, $status));

        $data['content'] = 'prd/schedule_kanban/edit_schedule_kanban_v';
        $this->load->view($this->layout, $data);
    }

    function update_schedule_kanban(){
        $this->form_validation->set_rules('INT_SEQUENCE', 'Sequence', 'numeric|required');
        $this->form_validation->set_rules('CHR_WORK_CENTER', 'Work Center', 'required');
        $this->form_validation->set_rules('CHR_PART_NO', 'Part No', 'required');

        $id = $this->input->post('INT_ID');
        $user = $this->session->userdata('USERNAME');
        $datenow = date('Ymd');
        $timenow = date('His');
        $old_seq = $this->input->post('INT_SEQUENCE_BEFORE');
        $new_seq = $this->input->post('INT_SEQUENCE');
        $id_dept = $this->input->post('INT_ID_DEPT');
        $work_center = $this->input->post('CHR_WORK_CENTER');
        $part_no = $this->input->post('CHR_PART_NO');
        $date = date( "Ymd", strtotime($this->input->post('CHR_DATE')));
        $lot_size = $this->input->post('INT_LOT_SIZE');
        $qty_per_box = $this->input->post('INT_QTY_PER_BOX');
        
        $status = 0; //default status schedule yang bisa diedit -- atstus belum diproduksi

        if ($this->form_validation->run() == FALSE) {
            $this->edit_schedule_kanban($id , $work_center, $msg = null);
        } else {
            if($new_seq > $old_seq){
                $this->db->query("UPDATE PRD.TT_SCHEDULE_KANBAN SET INT_SEQUENCE = INT_SEQUENCE - 1, CHR_MODIFIED_BY = '$user', CHR_MODIFIED_DATE = '$datenow', CHR_MODIFIED_TIME = '$timenow' WHERE CHR_WORK_CENTER = '$work_center' AND INT_SEQUENCE > $old_seq AND INT_SEQUENCE <= $new_seq");
            } else if($new_seq < $old_seq){
                $this->db->query("UPDATE PRD.TT_SCHEDULE_KANBAN SET INT_SEQUENCE = INT_SEQUENCE + 1, CHR_MODIFIED_BY = '$user', CHR_MODIFIED_DATE = '$datenow', CHR_MODIFIED_TIME = '$timenow' WHERE CHR_WORK_CENTER = '$work_center' AND INT_SEQUENCE < $old_seq AND INT_SEQUENCE >= $new_seq");
            }
            
            $data_primary = array(
                'INT_SEQUENCE' => $new_seq,
                'CHR_WORK_CENTER' => $work_center,
                'CHR_PART_NO' => $part_no,
                'INT_LOT_SIZE' => $lot_size,
                'INT_QTY_PER_BOX' => $qty_per_box,
                'INT_QTY_PCS' => $qty_per_box * $lot_size,
                'CHR_DATE' => $date,
                'CHR_MODIFIED_BY' => $user,
                'CHR_MODIFIED_TIME' => date('His'),
                'CHR_MODIFIED_DATE' => date('Ymd')
            );

            $id_primary = array(
                'INT_ID' => $id
            );

            $this->schedule_kanban_m->update($data_primary, $id_primary);
            
            redirect('/prd/schedule_kanban_c/search_schedule_kanban/' . substr($date, 0, 6) . '/' . $id_dept . '/' . $work_center . '/' . $status . '/' . 2);
        }
    }

    function save_schedule_kanban() {
        $tableRow = $this->input->post("tableRow");
        $period = $this->input->post("CHR_PERIOD");
        $date_create = date("Ymd");
        $time = date("His");
        
        $created_by = $this->session->userdata('USERNAME');
        
        foreach ($tableRow as $row) {
            $wcenter = $row['CHR_WORK_CENTER'];
            if($wcenter != NULL && $wcenter != ''){
                $date_prd = $row['CHR_DATE'];
                //===== Logic delete exist data, change request for always add data to schedule, not replace
                //$del_exist_data = $this->db->query("UPDATE PRD.TT_SCHEDULE_KANBAN SET INT_SEQUENCE = '0', INT_FLG_DEL = '1', CHR_MODIFIED_BY = '$created_by', CHR_MODIFIED_DATE = '$date_create', CHR_MODIFIED_TIME = '$time' WHERE CHR_WORK_CENTER = '$wcenter' AND CHR_DATE = '$date_prd' AND CHR_CREATED_DATE <> '$date_create' AND INT_FLG_PRD = '0' AND INT_FLG_DEL = '0'");
                $last_seq = $this->db->query("SELECT TOP 1 INT_SEQUENCE FROM PRD.TT_SCHEDULE_KANBAN WHERE CHR_WORK_CENTER = '$wcenter' AND INT_FLG_PRD = '0' AND INT_FLG_DEL = '0' ORDER BY INT_SEQUENCE DESC")->row()->INT_SEQUENCE;
                $new_seq = $last_seq + 1;
                
                if($row['FLG_DELETE'] == 0 && is_numeric($row['INT_LOT_SIZE'])){
                    $data['INT_SEQUENCE'] = $new_seq;
                    $data['CHR_WORK_CENTER'] = $row['CHR_WORK_CENTER'];
                    $data['CHR_PART_NO'] = $row['CHR_PART_NO'];
                    $data['CHR_DATE'] = $row['CHR_DATE'];
                    $data['INT_LOT_SIZE'] = $row['INT_LOT_SIZE'];
                    $data['INT_QTY_PER_BOX'] = $row['INT_QTY_PER_BOX'];
                    $data['INT_QTY_PCS'] = $row['INT_QTY_PCS'];
                    $data['INT_FLG_SO'] = $row['INT_FLG_SO'];
                    $data['CHR_CREATED_BY'] = $created_by;
        
                    $this->schedule_kanban_m->save($data);
                }
            }
            
        }        

        redirect($this->back_to_index . 1);
    }

    function delete_schedule_kanban($id) {
        $created_by = $this->session->userdata('USERNAME');
        $date = date('Ymd');
        $time = date('His');
        
        $status = 0; //default status schedule yang bisa dihapus -- atstus belum diproduksi
        
        $data = $this->db->query("SELECT INT_SEQUENCE, CHR_WORK_CENTER, CHR_DATE FROM PRD.TT_SCHEDULE_KANBAN WHERE INT_ID = '$id'")->row();
        $seq = $data->INT_SEQUENCE;
        $wcenter = $data->CHR_WORK_CENTER;
        $period = substr($data->CHR_DATE, 0, 6);
        
        $id_dept = $this->direct_backflush_general_m->get_prod_by_work_center($wcenter);
        
        $this->db->query("UPDATE PRD.TT_SCHEDULE_KANBAN SET INT_SEQUENCE = INT_SEQUENCE - 1, CHR_MODIFIED_BY = '$created_by', CHR_MODIFIED_DATE = '$date', CHR_MODIFIED_TIME = '$time' WHERE CHR_WORK_CENTER = '$wcenter' AND INT_SEQUENCE > $seq");
        
        $this->schedule_kanban_m->delete($id);

        redirect('/prd/schedule_kanban_c/search_schedule_kanban/' . $period . '/' . $id_dept . '/' . $wcenter . '/' . $status . '/' . 3);
    }


}
