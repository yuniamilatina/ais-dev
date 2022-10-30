
<?php

class app_control_c extends CI_Controller {

    private $layout = '/template/head';
    private $back_to_manage = 'app_control/app_control_c/index/';

    public function __construct() {
        parent::__construct();
        $this->load->model('app_control/app_control_m');
        $this->load->model('asset/asset_m');
        $this->load->model('organization/dept_m');
    }

    function index($msg = NULL) {
        $this->role_module_m->authorization('3');
        //$date_now = date("Ym");
        $date_now = '201805';

        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Creating success </strong> The data is successfully created </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Updating success </strong> The data is successfully updated </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Deleted success </strong> The data is successfully deleted </div >";
        } elseif ($msg == 4) {
            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Choosing failed </strong> You must select at least one data</div >";
        } elseif ($msg == 12) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Executing error !</strong> Something error with parameter </div >";
        }
        $data['msg'] = $msg;
        $data['data'] = $this->app_control_m->get_data_app_control($date_now);
        $data['content'] = 'app_control/app_control_v';
        $data['title'] = 'Application Control';
        $data['news'] = $this->news_m->get_news();
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(55);

        $this->load->view($this->layout, $data);
    }

    public function generate_template() {
        $this->load->library('excel');
        $this->load->helper('download');

        ob_clean();
        $file_name = 'Template Upload Data App Control.xlsx';
        $file = file_get_contents('./assets/files/Template Upload Data App Control.xlsx');

        force_download($file_name, $file);
    }

    public function upload_data() {
        $this->load->library(array('PHPExcel', 'PHPExcel/IOFactory'));
        $this->db->query("TRUNCATE TABLE INV.TM_APP_CONTROL");
        $pic = $this->session->userdata('NPK');
        $date_now = date("Ymd");
        $time_now = date("His");

        if ($this->input->post("upload_button") == 1) {
            $fileName = $_FILES['import_data']['name'];
            if (empty($fileName)) {
                echo '<script>alert("Anda belum memilih file untuk diupload");</script>';
                redirect('app_control/app_control_c/index', 'refresh');
            }

            //File untuk submit file excel
            $config['upload_path'] = './assets/files';
            $config['file_name'] = $fileName;
            $config['allowed_types'] = 'xlsx';
            $config['max_size'] = 3000;
            $config['encrypt_name'] = FALSE;
            $config['remove_spaces'] = TRUE;

            //Code for upload with CI
            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('import_data')) {
                echo $this->upload->display_errors();
                exit();
            }

            $media = $this->upload->data('import_data');
            $inputFileName = './assets/files/' . $media['file_name'];

            //  Read Excel workbook
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
            $rowHeader = $sheet->rangeToArray('A1:' . $highestColumn . '1', NULL, TRUE, FALSE);
            if ($rowHeader[0][0] == "Template Upload Data") {
                for ($row = 5; $row <= $highestRow; $row++) {

                    $error_msg = "";
                    $error_stat = 0;
                    $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);
                    
                    $post_date = $rowData[0][1];
                    $pds_no = $rowData[0][2];
                    $part_no = $rowData[0][3];
                    $qty_ok = $rowData[0][4];
                    $qty_ng = $rowData[0][5];

                    // Validation Qty Upload (QTY OK dan QTY NG)
                    if (!is_numeric($qty_ok)) {
                        $error_stat = 1;
                        $error_msg = " Pastikan tipe data Qty OK adalah Angka (Number) ";
                    }
                    if (!is_numeric($qty_ng)) {
                        $error_stat = 1;
                        $error_msg = " Pastikan tipe data Qty OK adalah Angka (Number) ";
                    }

                    // Insert to Table Master (INV.TM_APP_CONTROL)
                    $insert_upload_data = "INSERT INTO INV.TM_APP_CONTROL "
                            . "(CHR_POSTING_DATE, CHR_PDS_NO, CHR_PART_NO, INT_TOTAL_QTY, INT_TOTAL_NG) "
                            . "VALUES ('$post_date','$pds_no','$part_no','$qty_ok','$qty_ng')";
                    $this->db->query($insert_upload_data);
                }
                redirect("app_control/app_control_c/index/", "refresh");
            } else {
                echo "<script>alert('Maaf data yang Anda masukan salah, pastikan Anda menggunakan template dari sistem')</script>";
            }
        }
    }

}
