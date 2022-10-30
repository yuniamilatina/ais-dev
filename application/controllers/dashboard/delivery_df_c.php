<?php

class delivery_df_c extends CI_Controller {

    private $layout = '/template/head';
    private $back_to_manage = 'eci/schedule_c/list_eci/';

    public function __construct() {
        parent::__construct();
        $this->load->model('eci/category_m');
        $this->load->model('eci/schedule_m');
        //$this->load->model('budget/budgetcategory_m');
        //$this->load->model('budget/budgettype_m');

        $this->load->library('PHPExcel');
        //$this->load->library(array('PHPExcel', 'PHPExcel/PHPExcel_IOFactory'));
        //$this->load->library('PHPExcel/PHPExcel_IOFactory');

        $this->load->model('basis/log_m');
        $this->load->model('basis/role_module_m');
        $this->load->model('portal/news_m');
        $this->load->model('portal/notification_m');
    }


    public function upload_time_table($msg = null) {
        $this->role_module_m->authorization('61');
        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Creating success </strong> The data is successfully created </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Updating success </strong> The data is successfully updated </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Deleted success </strong> The data is successfully deleted </div >";
        } elseif ($msg == 12) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Executing error !</strong> Something error with parameter </div >";
        } else {
            $msg = "";
        }
        $npk_created = TRIM($this->session->userdata("NPK"));

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(61);

        $data['title'] = 'Create New ECI Schedule';
        $data['msg'] = $msg;
        $data['content'] = 'dashboard/delivery_df/upload_time_table_v';


        $this->load->view($this->layout, $data);
    }
    
    public function absen_cust_truck($msg = null) {
        $this->role_module_m->authorization('62');
        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Creating success </strong> The data is successfully created </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Updating success </strong> The data is successfully updated </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Deleted success </strong> The data is successfully deleted </div >";
        } elseif ($msg == 12) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Executing error !</strong> Something error with parameter </div >";
        } else {
            $msg = "";
        }
        $npk_created = TRIM($this->session->userdata("NPK"));

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(62);

        $data['title'] = 'Manage ECI Category';
        $data['msg'] = $msg;
        
        $db_1 = $this->load->database('aiierp', TRUE);
        $data['data'] = $db_1->query("SELECT     CHR_DATE, CHR_CUST_CODE, CHR_CUST_DEST_CODE, CHR_CYCLE, CHR_CUST_NAME, CHR_CUST_DEST, CHR_ARRIVAL_PLAN, CHR_ARRIVAL_ACT, 
                      CHR_DEPARTURE_PLAN, CHR_DEPARTURE_ACT
FROM         TT_DELIVERY_DF
GROUP BY CHR_DATE, CHR_CUST_CODE, CHR_CUST_DEST_CODE, CHR_CYCLE, CHR_CUST_NAME, CHR_CUST_DEST, CHR_ARRIVAL_PLAN, CHR_ARRIVAL_ACT, 
                      CHR_DEPARTURE_PLAN, CHR_DEPARTURE_ACT")->result();
        //$data['data'] = $this->category_m->find_trans("*","CHR_FLG_DELETE='0'");
        $data['content'] = 'dashboard/delivery_df/absen_cust_truck_v';
        $this->load->view($this->layout, $data);

    }
    
    public function submit_timetable() {
        if ($this->input->post('btn_submit')) {
            $row_wo = 1;
        
            //cek apakah sudah ada file?
            $fileName = $_FILES['import']['name'];
            if (empty($fileName)) {
                echo '<script>alert("Anda Belum Memilih File Untuk diupload");</script>';
                redirect('set_kanban/submit_wo', 'refresh');
            }
            echo "<script> document.getElementById('test_modal').click()</script>";
            $this->db->trans_begin();
          

            //file untuk submit file excel
            $config['upload_path'] = './assets/file/dashboard_df_timetable/';
            $config['file_name'] = $fileName;
            $config['allowed_types'] = 'xls|xlsx';
            $config['max_size'] = 10000;

            //code for upload with ci
           // $this->load->library(array('PHPExcel', 'PHPExcel/PHPExcel_IOFactory'));
            $this->load->library('upload');
            $this->upload->initialize($config);
            if ($a = $this->upload->do_upload('import'))
                $this->upload->display_errors();
            $media = $this->upload->data('import');
            $inputFileName = './assets/file/dashboard_df_timetable/' . $media['file_name'];

            //Read  Excel workbook
            try {
                $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($inputFileName);
            } catch (Exception $e) {
                $this->db->trans_rollback();
                die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' . $e->getMessage());
            }

            //  Get worksheet dimensions
            $sheet = $objPHPExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();

            $x = 0;
            $y = 0;


            $rowHeader = $sheet->rangeToArray('A6:' . $highestColumn . '6', NULL, TRUE, FALSE);

            $db_1 = $this->load->database('aiierp', TRUE);
            $db_1->query("TRUNCATE TABLE TM_TIME_TABLE");

            for ($row = 2; $row <= $highestRow; $row++) {                  //  Read a row of data into an array                 
                $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);

                $cust_name = trim($rowData[0][0]);
                $cust_code = trim($rowData[0][1]);
                $cust_code_suffix = trim($rowData[0][2]);
                $cycle = trim($rowData[0][3]);
                $departure = trim($rowData[0][5]);
                $arrival = trim($rowData[0][4]);
                //$arrival = date('H:i',strtotime($departure) - 20*60);
                $pull_start = date('H:i',strtotime($departure) - 180*60);
                $pull_finish = date('H:i',strtotime($departure) - 120*60);
                
                //insert to time table after truncate table
                $db_1->query("INSERT INTO TM_TIME_TABLE ( CHR_CUST, CHR_CUST_CODE, CHR_CUST_CODE_SUFFIX, CHR_CYCLE, CHR_PULL_START, CHR_PULL_END, CHR_AII_ARRIVAL, CHR_AII_LOADING, CHR_AII_DEPARTURE, CHR_PREPARE) VALUES ('".$cust_name."','".$cust_code."','".$cust_code_suffix."','".$cycle."','".$pull_start."','".$pull_finish."','".$arrival."','".$arrival."','".$departure."','".$pull_finish."') ");
                
                if ( trim($cust_code) == "0010-04" && $cust_code_suffix == "01" ){
                    $where = " CHR_CUST_CODE='".substr($cust_code,0,4)."' AND CHR_CUST_DEST_CODE='".substr($cust_code,5,2)."' AND CHR_CUST_DEST='TMMIN 4B' ";
                }elseif ( trim($cust_code) == "0010-04" && $cust_code_suffix == "02" ){
                    $where = " CHR_CUST_CODE='".substr($cust_code,0,4)."' AND CHR_CUST_DEST_CODE='".substr($cust_code,5,2)."' AND CHR_CUST_DEST='TMMIN 53' ";
                }elseif ( trim($cust_code) == "0200-" ){
                    $where = " CHR_CUST_CODE='".substr($cust_code,0,4)."' ";
                }else{
                    $where = " CHR_CUST_CODE='".substr($cust_code,0,4)."' AND CHR_CUST_DEST_CODE='".substr($cust_code,5,2)."' ";
                }
                
                //update tt hari ini
                $db_1->query("UPDATE TT_DELIVERY_DF SET CHR_PREP_PLAN='".$pull_finish."', CHR_ARRIVAL_PLAN='".$arrival."', CHR_DEPARTURE_PLAN='".$departure."' WHERE ".$where." AND CHR_CYCLE='".$cycle."' AND CHR_DATE = '".date("Ymd")."' AND CHR_DEPARTURE_PLAN >= '".date("H:i")."' ");

                //update tt besoknya
                $db_1->query("UPDATE TT_DELIVERY_DF SET CHR_PREP_PLAN='".$pull_finish."', CHR_ARRIVAL_PLAN='".$arrival."', CHR_DEPARTURE_PLAN='".$departure."' WHERE ".$where." AND CHR_CYCLE='".$cycle."' AND CHR_DATE > '".date("Ymd")."'  ");
                
            }

            if ($db_1->trans_status() === FALSE) {
                $db_1->trans_rollback();
            } else {
                $db_1->trans_commit();
                echo '<script>alert("Anda Berhasil Mengupdate Data WO!!! ';
                redirect('dashboard/delivery_df_c/upload_time_table/1', 'refresh');
                
            }
            exit();
            redirect('dashboard/delivery_df_c/upload_time_table', 'refresh');

            //set rollback transaction
            $db_1->trans_rollback();
            redirect('dashboard/delivery_df_c/upload_time_table', 'refresh');
        }
        

        //redirect("dashboard/delivery_df_c/upload_time_table", "refresh");
    }
    

    

}

?>
