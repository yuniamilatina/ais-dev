<?php

class load_tester_c extends CI_Controller {

    private $layout = '/template/head';
    private $back_to_index = '/patricia/load_tester_c/index/';
    private $back_to_upload = '/patricia/load_tester_c/prepare_upload_load_tester/';

    public function __construct() {
        parent::__construct();
        $this->load->model('patricia/load_tester_m');
        $this->load->model('part/part_m');
    }

    function index($period = NULL, $msg = NULL) {
        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Creating success </strong> The data is successfully created </div >";
        } elseif ($msg == 15) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Executing error !</strong> Template Anda Salah atau sudah diubah, Silahkan Coba Lagi Dengan Template Yang Benar </div >";
        } 

        if($period == NULL){
            $data['period'] = date('Ym');
        }else{
            $data['period'] = $period;
        }

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(149);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Load Tester';
        $data['msg'] = $msg;

        $data['data'] = $this->load_tester_m->get_data_by_date($period);

        $data['content'] = 'patricia/load_tester/load_tester_v';

        $this->load->view($this->layout, $data);
    }
    
    function prepare_upload_load_tester($msg = null){
        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Creating success </strong> The data is successfully created </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Updating success </strong> The data is successfully updated </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Deleted success </strong> The data is successfully deleted </div >";
        } elseif ($msg == 14) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Uploading Failed!</strong> File belum diupload</div >";
        } elseif ($msg == 15) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Executing error !</strong> Template Anda Salah atau sudah diubah, Silahkan Coba Lagi Dengan Template Yang Benar </div >";
        } elseif ($msg == 12) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Executing error !</strong> Something error with parameter </div >";
        }

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(149);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Load Tester';
        $data['msg'] = $msg;

        $data['content'] = 'patricia/load_tester/upload_load_tester_v';

        $data['data'] = array();
        $data['data_exist'] = 0;

        $this->load->view($this->layout, $data);
    }

    function update_load_tester(){
        $this->load->library(array('PHPExcel', 'PHPExcel/IOFactory'));
        $this->load->library('upload');
        $upload_date = date('Ymd');
        $msg = NULL;
 
        $fileName = $_FILES['upload_load_tester']['name'];
        $back_no = explode('.',$fileName);
        if (empty($fileName)) {
            redirect($this->back_to_upload .$msg = 14);
        }
        
         //file untuk submit file excel
         $config['upload_path'] = './assets/file/load_tester/';
         $config['file_name'] = $fileName;
         $config['allowed_types'] = 'xls|xlsx';
         $config['max_size'] = 10000;
 
         //code for upload with ci
         $this->upload->initialize($config);
         if ($a = $this->upload->do_upload('upload_load_tester'))
             $this->upload->display_errors();
         $media = $this->upload->data('upload_load_tester');
         $inputFileName = './assets/file/load_tester/' . $media['file_name'];
 
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

             $title_sheet = $sheet->getTitle();

             $filename_explode = explode(".", $fileName);
             $back_no = $filename_explode[0];

            //  echo $title_sheet;

             $rowHeader = $sheet->rangeToArray('F3:' . $highestColumn . '3', NULL, TRUE, FALSE);
             $rowHeaderDetail = $sheet->rangeToArray('F4:' . $highestColumn . '4', NULL, TRUE, FALSE);
             $rowHeaderDetail2 = $sheet->rangeToArray('G5:' . $highestColumn . '5', NULL, TRUE, FALSE);
 
             $sample = trim($rowHeader[0][0]); 
             $sampleDetail = trim($rowHeaderDetail[0][0]); 
             $test1 = trim($rowHeaderDetail[0][1]); 
             $test2 = trim($rowHeaderDetail[0][2]); 
             $test3 = trim($rowHeaderDetail[0][3]); 
             $load1 = trim($rowHeaderDetail2[0][0]); 
             $load2 = trim($rowHeaderDetail2[0][1]); 
             $load3 = trim($rowHeaderDetail2[0][2]);

             $i = 0;
             if ($sample == 'Sample' && $sampleDetail == 'D' &&  $test1 == '1' && $test2 == '2' && $test3 == '3' &&  $load1 == 'LOAD' && $load2 == 'LOAD' && $load3 == 'LOAD') {
                 
                for ($row = 6; $row <= $highestRow; $row++) {
                    $rowData = $sheet->rangeToArray('F' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);
 
                    if($rowData[0][0] == 'JUDGE'){
                        break;
                    }

                     $data[$i]['FLG_DELETE'] = 0;
                     $data[$i]['ERROR_MESSAGE'] = NULL;

                     if(!is_numeric($rowData[0][0])){
                         $data[$i]['FLG_DELETE'] = 1;
                         $data[$i]['ERROR_MESSAGE'] = 'Kolom ini tidak angka';
                     }

                     if(!is_numeric($rowData[0][1])){
                        $data[$i]['FLG_DELETE'] = 1;
                        $data[$i]['ERROR_MESSAGE'] = 'Kolom ini tidak angka';
                    }

                    if(!is_numeric($rowData[0][2])){
                        $data[$i]['FLG_DELETE'] = 1;
                        $data[$i]['ERROR_MESSAGE'] = 'Kolom ini tidak angka';
                    }

                    if(!is_numeric($rowData[0][3])){
                        $data[$i]['FLG_DELETE'] = 1;
                        $data[$i]['ERROR_MESSAGE'] = 'Kolom ini tidak angka';
                    }

                    $data[$i]['CHR_BACK_NO'] = $back_no[0];
                    $data[$i]['INT_SCALE'] = round((float)$rowData[0][0],2);
                    $data[$i]['INT_LOAD1'] = round((float)$rowData[0][1],2);
                    $data[$i]['INT_LOAD2'] = round((float)$rowData[0][2],2);
                    $data[$i]['INT_LOAD3'] = round((float)$rowData[0][3],2);
                    $data[$i]['CHR_CREATED_BY'] = $this->session->userdata('USERNAME');
                    $data[$i]['CHR_CREATED_DATE'] = $upload_date;
                    $data[$i]['CHR_CREATED_TIME'] = date('His');

                    $i++;
                 }

                 $x = 0;
                 for ($row = $i + 11; $row <= $i + 12; $row++) {
                    $rowData = $sheet->rangeToArray('F' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);
                    $data_height[$x]['INT_HEIGHT'] =  str_replace(',','.',$rowData[0][1]);
                    $x++;
                 }

                 $data_view['app'] = $this->role_module_m->get_app();
                 $data_view['module'] = $this->role_module_m->get_module();
                 $data_view['function'] = $this->role_module_m->get_function();
                 $data_view['sidebar'] = $this->role_module_m->side_bar(176);
                 $data_view['news'] = $this->news_m->get_news();
                 $data_view['title'] = 'Upload Load Tester';
                 $data_view['msg'] = $msg;
                 $data_view['backno'] = $back_no;
                 $data_view['partno'] = $this->part_m->get_part_no_by_backno($back_no);
                 $data_view['date_generate'] = substr($title_sheet,4,4) . '' . substr($title_sheet,2,2) . '' .substr($title_sheet,0,2);
                 $data_view['height_a'] = $data_height[0]['INT_HEIGHT'];
                 $data_view['height_b'] = $data_height[1]['INT_HEIGHT'];

                 $data_view['data_exist'] = $i;
                 $data_view['data'] = $data;

                 $data_view['content'] = 'patricia/load_tester/upload_load_tester_v';
                 $this->load->view($this->layout, $data_view);
 
             } else {
                 redirect($this->back_to_upload .$msg = 15);
             }
         
     }
     
     public function update_balancing_load_tester(){
        $tableRow = $this->input->post("tableRow");
        $pds_no = $this->input->post("CHR_PDS_NO");

        $created_by = $this->session->userdata('USERNAME');
        $datenow = date('Ymd');
        $timenow = date('His');

       foreach ($tableRow as $row) {
            
            if($row['FLG_DELETE'] == 0 && $row['INT_FLG_SAVE'] == 1){

                $data['CHR_PDS_NO'] = $pds_no;
                $data['CHR_BACK_NO'] = $row['CHR_BACK_NO'];
                $data['CHR_PART_NO'] = $row['CHR_PART_NO'];
                $data['INT_SCALE'] = $row['INT_SCALE'];
                $data['INT_LOAD1'] = $row['INT_LOAD1'];
                $data['INT_LOAD2'] = $row['INT_LOAD2'];
                $data['INT_LOAD3'] = $row['INT_LOAD3'];
                $data['CHR_TEST_DATE'] = $row['CHR_TEST_DATE'];
                $data['CHR_CREATED_BY'] = $created_by;
                $data['CHR_CREATED_DATE'] = $datenow;
                $data['CHR_CREATED_TIME'] = $timenow;
    
                $this->load_tester_m->save($data);
            }
        }

        redirect($this->back_to_index .date('Ym').'/'.$msg = 1);
     }
    
}
?>