<?php

class temp_part_c extends CI_Controller {

	private $layout = '/template/head';
	private $back_to_manage = 'inventory/temp_part_c/index/';

	public function __construct() {
        parent::__construct();

        $this->load->model('inventory/temp_part_m');
        $this->load->model('organization/dept_m');
        $this->load->model('part/part_m');
        $this->load->model('prd/direct_backflush_general_m');
        $this->load->helper(array('form', 'url', 'inflector'));
        $this->load->library(array('PHPExcel', 'PHPExcel/IOFactory'));
    }

    function index($msg = NULL) {
        $this->role_module_m->authorization('323');
        
        // $data['data_problem_type'] = $this->problem_type_m->get_problem_type();
        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Creating success </strong> The data is successfully created </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Updating success </strong> The data is successfully updated </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Deleted success </strong> The data is successfully deleted </div >";
        } elseif ($msg == 4) {
            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Data Trolley Sudah Ada</strong></div >";
        } elseif ($msg == 12) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Executing error !</strong> Something error with parameter </div >";
        }
        $data['msg'] = $msg;
        $data['data_temp'] = $this->temp_part_m->get_data_temp();
        
        $data['content'] = 'inventory/list_temp_part_v';
        $data['title'] = 'Data Temp Part';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(323);
        $data['news'] = $this->news_m->get_news();
        
        $this->load->view($this->layout, $data);
    }

    function create_data_temp() {
        $data['content'] = 'inventory/create_temp_part_v';
        $data['title'] = 'Add Data Temp Part';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(323);
        $data['news'] = $this->news_m->get_news();
        // $data['data'] = $this->maria_elkb_m->get_data_by_id($pno,$bno);

        $this->load->view($this->layout, $data);
    }

    function save_data_temp() {
    	$date_now = date("ymd");
    	$dtnow = date("Ymd");
        $pic = trim($this->input->post('CHR_PIC'));
        $dept = trim($this->input->post('CHR_DEPT'));
        $desc = trim($this->input->post('CHR_DESC'));
        $stdate = date("Ymd", strtotime($this->input->post('CHR_ST_DATE')));
        $fhdate = date("Ymd", strtotime($this->input->post('CHR_FH_DATE')));
        $session = $this->session->all_userdata();

        $cek_seq = $this->db->query("SELECT TOP 1 * FROM TM_SEQUENCE_01 WHERE CHR_COD_EXE = 'TEMP_PART' and CHR_DATE_CREATED = '$dtnow'");
        if ($cek_seq->num_rows() == 0){
            $ist_seq = $this->db->query("insert into TM_SEQUENCE_01 (CHR_COD_EXE,CHR_DATE_CREATED,CHR_KEY1,INT_SERIAL_NUMBER) values ('TEMP_PART','$dtnow','J901','0')");
            $noseq = 0;
        } else {
            $seq_d = $cek_seq->result();
            $noseq = $seq_d[0]->INT_SERIAL_NUMBER;
            $noseq = $noseq + 1;
            $upt_seq = $this->db->query("update TM_SEQUENCE_01 set INT_SERIAL_NUMBER='$noseq' where CHR_COD_EXE = 'TEMP_PART' and CHR_DATE_CREATED = '$dtnow'");
        }
        $seq = strlen($noseq);
        switch ($seq) {
            case 0:
                $x = "00";
                break;
            case 1:
                $x = "00";
                break;
            case 2:
                $x = "0";
                break;
            case 3:
                $x = "";
                break;
        }
        $temp_id = "TEMP". $date_now . $x . $noseq;
        // echo $temp_id;
        // exit();
               
        $data_temp = $this->db->query("SELECT TOP 1 * FROM TT_TEMP_PART WHERE CHR_TEMP_ID = '$temp_id'");
        if ($data_temp->num_rows() == 0){
            $data_tr = array(
            'CHR_TEMP_ID' => $temp_id,
            'CHR_PIC' => $pic,
            'CHR_DEPT' => $dept,
            'CHR_DESC' => $desc,
            'CHR_START_DT' => $stdate,
            'CHR_FINISH_DT' => $fhdate,
            'CHR_FLAG_DEL' => 'F',
            'CHR_NPK_CREATE' => $session['NPK'],
            'CHR_DATE_CREATE' => date("Ymd"),
            'CHR_TIME_CREATE' => date("His")
            );
            $this->temp_part_m->save_temp($data_tr);

            //make label barcode
                $this->load->library('ciqrcode');
                $params['data'] = "$temp_id $pic $dept $desc $stdate $fhdate";
                $params['level'] = 'B';
                $params['size'] = 7;
                $params['savename'] = 'assets/barcode/' . $temp_id . '.png';    
                $this->ciqrcode->generate($params);

            redirect($this->back_to_manage . $msg = 1);
        }else{
            redirect($this->back_to_manage . $msg = 4);
        }        
    }

    function pdf_tempdt($id) {

    	$list_data = $this->db->query("SELECT * 
                                                     from TT_TEMP_PART 
                                                     where CHR_TEMP_ID   ='$id'")->row();
        $data['temp_id'] = $list_data->CHR_TEMP_ID;
        $data['pic'] = $list_data->CHR_PIC;
        $data['dept'] = $list_data->CHR_DEPT;
        $data['desc'] = $list_data->CHR_DESC;
        $data['start_dt'] = $list_data->CHR_START_DT;
        $data['finish_dt'] = $list_data->CHR_FINISH_DT;

    	// Load all views as normal
        $this->load->view('pdf_temppart', $data);
        // Get output html
        $html = $this->output->get_output();
//--------------------------------------------------------------------//
        // Load library
        $this->load->library('dompdf_gen');
//--------------------------------------------------------------------//
        // Convert to PDF
        $this->dompdf->load_html($html);
        $this->dompdf->render();
        $this->dompdf->stream("pds_aisin.pdf", array('Attachment' => 0));
    }

    function manage_phantom_parts($msg = NULL) {
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(220);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Manage Part Phantom';
        $data['msg'] = $msg;

        $id_dept = $this->dept_m->get_top_prod_dept()->row()->INT_ID_DEPT;
        $work_center = $this->direct_backflush_general_m->get_top_work_center_by_id_dept($id_dept);
        $all_dept_prod = $this->dept_m->get_all_prod_dept();
        $all_work_centers = $this->direct_backflush_general_m->get_work_center_by_id_dept($id_dept);
        $all_part_no = $this->temp_part_m->get_data_part_by_work_center($work_center);
        // $part_no = $this->part_m->get_top_part_by_work_center($work_center);

        $data['all_dept_prod'] = $all_dept_prod;
        $data['all_work_centers'] = $all_work_centers;
        $data['all_part_no'] = $all_part_no;
        $data['work_center'] = $work_center;
        $data['id_dept'] = $id_dept;
        // $data['part_no'] = $part_no;

        $data['data'] = $this->temp_part_m->get_data_phantom_parts($work_center);

        $data['content'] = 'inventory/manage_phantom_parts_v';
        $this->load->view($this->layout, $data);
    }

    function search_phantom_parts($msg = NULL, $id_dept = NULL, $work_center = NULL) {
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
        $data['sidebar'] = $this->role_module_m->side_bar(220);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Manage Phantom Parts';
        $data['msg'] = $msg;
        
        $all_dept_prod = $this->dept_m->get_all_prod_dept();
        $all_work_centers = $this->direct_backflush_general_m->get_work_center_by_id_dept($id_dept);
        $all_part_no = $this->temp_part_m->get_data_part_by_work_center($work_center);

        $data['all_dept_prod'] = $all_dept_prod;
        $data['all_work_centers'] = $all_work_centers;
        $data['all_part_no'] = $all_part_no;
        $data['work_center'] = $work_center;
        $data['id_dept'] = $id_dept;

        $data['data'] = $this->temp_part_m->get_data_phantom_parts($work_center);

        $data['content'] = 'inventory/manage_phantom_parts_v';
        $this->load->view($this->layout, $data);
    }

    function add_phantom_part(){
        $session = $this->session->all_userdata();
        $date = date('Ymd');
        $time = date('His');
        $user = $session['USERNAME'];
        
        $id_dept = $this->input->post('INT_ID_DEPT');
        $part_no = trim($this->input->post('chr_part_no'));
        $work_center = trim($this->input->post('chr_work_center'));
        $info = $this->input->post('chr_add_info');
        
        $cek_back_no = $this->temp_part_m->get_back_no_by_part_no($part_no);
        if(count($cek_back_no) == 0){
            redirect('inventory/temp_part_c/search_phantom_parts/12/' . $id_dept .'/' . $work_center , 'refresh');
        }
        
        $data_row = array(
            'CHR_WORK_CENTER' => $work_center,
            'CHR_PART_NO' => $part_no,
            'CHR_FLAG_VALIDATE' => 'P',
            'CHR_CREATED_BY' => $user,
            'CHR_CREATED_DATE' => $date,
            'CHR_CREATED_TIME' => $time
        );        
        $this->temp_part_m->insert_phantom_part($data_row);

        redirect('inventory/temp_part_c/search_phantom_parts/1/' . $id_dept . '/' . $work_center, 'refresh');
    }

    function delete_phantom_part($id, $id_dept, $work_center, $part_no){
        $session = $this->session->all_userdata();
        $date = date('Ymd');
        $time = date('His');
        $user = $session['USERNAME'];
        
        $this->temp_part_m->update_flag_delete_phantom_part($id, $date, $time, $user);

        redirect('inventory/temp_part_c/search_phantom_parts/3/' . $id_dept . '/' . $work_center, 'refresh');
    }

    public function upload_phantom_parts($id_dept = '', $w_center = '') {
        $date_now = date("ymd");

        if ($this->input->post("btn-upload") != '') {
            $this->db->query("TRUNCATE TABLE TW_PHANTOM");            

            $fileName = $_FILES['upload_parts']['name'];
            if (empty($fileName)) {
                echo '<script>alert("Anda Belum Memilih File Untuk diupload");</script>';
                redirect('inventory/temp_part_c/upload', 'refresh');
            }

            //file untuk submit file excel
            $config['upload_path'] = './assets/files/';
            $config['file_name'] = $fileName;
            $config['allowed_types'] = 'xls|xlsx';
            $config['max_size'] = 10000;

            //code for upload with ci
            $this->load->library('upload');
            $this->upload->initialize($config);
            if ($a = $this->upload->do_upload('upload_parts'))
                $this->upload->display_errors();
            $media = $this->upload->data('upload_parts');
            $inputFileName = './assets/files/' . $media['file_name'];

            //  Read  Excel workbook
            try {
                $inputFileType = IOFactory::identify($inputFileName);
                $objReader = IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($inputFileName);
            } catch (Exception $e) {
                die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' . $e->getMessage());
            }

            //  Get worksheet dimensions
            $sheet = $objPHPExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();

            $x = 0;
            $y = 0;
            $rowHeader = $sheet->rangeToArray('A2:' . $highestColumn . '2', NULL, TRUE, FALSE);
                
            for ($row = 2; $row <= $highestRow; $row++) {
                $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);
                $part_no = $rowData[0][0];
                $part_no = trim($part_no);
                $work_center = $rowData[0][1];
                $stat = '0';
                $msg = NULL;

                //===== Cek part
                $cek_tm_phantom = $this->db->query("SELECT * FROM TM_PHANTOM WHERE CHR_PART_NO = '$part_no' AND CHR_WORK_CENTER = '$work_center' AND INT_FLG_DEL = '0'");
                if($cek_tm_phantom->num_rows() == 0){
                    $cek_part = $this->db->query("SELECT * FROM TM_PARTS WHERE CHR_PART_NO = '$part_no'");
                    if($cek_part->num_rows() == 0){
                        $stat = '1';
                        $msg = 'Part No Tersebut Tidak Terdaftar';                    
                    } else {
                        $cek_process_part = $this->db->query("SELECT * FROM TM_PROCESS_PARTS WHERE CHR_PART_NO = '$part_no' AND CHR_WORK_CENTER = '$work_center'");
                        if($cek_process_part->num_rows() == 0){
                            $stat = '1';
                            $msg = 'Part No Tidak Terdaftar di Work Center';
                        }                 
                    }
                } else {
                    $stat = '1';
                    $msg = 'Part No Sudah Terdaftar di List Phantom';
                }                

                //===== Insert temporary table
                $this->db->query("INSERT INTO TW_PHANTOM (CHR_PART_NO, CHR_WORK_CENTER, CHR_STATUS, CHR_MESSAGE) "
                        . "VALUES ('$part_no', '$work_center', '$stat', '$msg');");
            }

            redirect("inventory/temp_part_c/confirmation_upload", "refresh");
        }

        $this->session->userdata('user_id');

        $data['content'] = 'inventory/upload_phantom_parts_v';
        $data['title'] = 'Upload Phantom Parts';

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(220);
        $data['news'] = $this->news_m->get_news();

        $this->load->view($this->layout, $data);
    }

    public function download() { //fungsi download
        $this->load->helper('download');

        ob_clean();
        $name = 'phantom_part.xlsx';
        $data = file_get_contents("assets/template/delivery/$name"); // filenya

        force_download($name, $data);
    }

    public function confirmation_upload() { //fungsi download        
        $this->session->userdata('user_id');

        $data['content'] = 'inventory/confirm_phantom_parts_v';
        $data['title'] = 'Confirm Phantom Parts';

        $phantom_parts = $this->db->query("SELECT * FROM  TW_PHANTOM")->result();
        if (count($phantom_parts) == 0) {
            redirect("inventory/temp_part_c/upload_phantom_parts", "refresh");
        }

        //cek upload ok
        $cek_upload_total = $this->db->query("SELECT * FROM TW_PHANTOM")->num_rows();
        $cek_upload_ok = $this->db->query("SELECT * FROM TW_PHANTOM WHERE CHR_STATUS = '0'")->num_rows();

        if ($this->input->post("btn-confirm") != '') {
            $range = 0;
            foreach ($phantom_parts as $value) {
                $part_no = trim($value->CHR_PART_NO);
                $work_center = $value->CHR_WORK_CENTER;
                $validate = 'P';
                $session = $this->session->all_userdata();
                $date = date('Ymd');
                $time = date('His');
                $user = $session['USERNAME'];
                $this->db->query("INSERT INTO TM_PHANTOM (CHR_PART_NO, CHR_WORK_CENTER, CHR_FLAG_VALIDATE, CHR_CREATED_BY, CHR_CREATED_DATE, CHR_CREATED_TIME, INT_FLG_DEL) "
                        . "VALUES ('$part_no', '$work_center', '$validate', '$user', '$date', '$time', '0');");
                $range++;
            }

            $this->db->query("TRUNCATE TABLE TW_PHANTOM");

            redirect("inventory/temp_part_c/manage_phantom_parts", "refresh");
        }


        $data['cek_upload_total'] = $cek_upload_total;
        $data['cek_upload_ok'] = $cek_upload_ok;
        $data['phantom_parts'] = $phantom_parts;

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(220);
        $data['news'] = $this->news_m->get_news();

        $this->load->view($this->layout, $data);
    }

    function manage_phantom_work_center($msg = NULL, $id_dept = NULL) {
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
        $data['sidebar'] = $this->role_module_m->side_bar(339);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Manage Work Center Phantom ELINA';
        $data['msg'] = $msg;
        // print_r($id_dept);
        // exit();
        if($id_dept == NULL){
            $id_dept = $this->dept_m->get_top_prod_dept()->row()->INT_ID_DEPT;
        }
        
        $all_dept_prod = $this->dept_m->get_all_prod_dept();

        $data['all_dept_prod'] = $all_dept_prod;
        $data['id_dept'] = $id_dept;

        $data['data'] = $this->temp_part_m->get_work_center_phantom_elina($id_dept);

        $data['content'] = 'inventory/manage_work_center_phantom_elina_v';
        $this->load->view($this->layout, $data);
    }

    function edit_phantom_work_center($stat, $id, $id_dept){
        $session = $this->session->all_userdata();
        $date = date('Ymd');
        $time = date('His');
        $user = $session['USERNAME'];

        $flag = 0; //===== Enable
        if($stat == 1){
            $flag = 1; //===== Disable
        }

        $data_row = array(
            'INT_FLG_DELETE' => $flag,
            'CHR_MODIFIED_BY' => $user,
            'CHR_MODIFIED_DATE' => $date,
            'CHR_MODIFIED_TIME' => $time
        );  
        
        $this->temp_part_m->update_phantom_work_center($id, $data_row);

        redirect('inventory/temp_part_c/manage_phantom_work_center/3/' . $id_dept, 'refresh');
    }

    function add_phantom_work_center(){
        $session = $this->session->all_userdata();
        $date = date('Ymd');
        $time = date('His');
        $user = $session['USERNAME'];
        
        $id_dept = $this->input->post('id_dept');
        $work_center = trim($this->input->post('work_center'));
        
        $cek_data = $this->temp_part_m->check_data_phantom_work_center($work_center);
        if($cek_data->num_rows() > 0){
            redirect('inventory/temp_part_c/manage_phantom_work_center/12/' . $id_dept, 'refresh');
        }
        
        $data_row = array(
            'INT_ID_DEPT' => $id_dept,
            'CHR_WORK_CENTER' => $work_center,
            'CHR_CREATED_BY' => $user,
            'CHR_CREATED_DATE' => $date,
            'CHR_CREATED_TIME' => $time
        );        
        $this->temp_part_m->insert_phantom_work_center($data_row);

        redirect('inventory/temp_part_c/manage_phantom_work_center/1/' . $id_dept, 'refresh');
    }

}
