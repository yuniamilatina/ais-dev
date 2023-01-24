<?php

class download_spkl_c extends CI_Controller
{

    private $layout = '/template/head';
    private $back_to_approve_mgr = '/aorta/quota_employee_c/prepare_approve_quota_by_mgr/';
    private $back_to_approve_gm = '/aorta/quota_employee_c/prepare_approve_quota_by_gm/';
    private $back_to_approve_dir = '/aorta/quota_employee_c/prepare_approve_quota_by_dir/';
    private $back_to_upload = '/aorta/quota_employee_c/create_quota_employee/';
    private $back_to_balance = '/aorta/quota_employee_c/balancing_quota/';
    private $back_to_reupload = '/aorta/quota_employee_c/edit_quota_employee/';
    private $back_to_manage = '/aorta/quota_employee_c/index/';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('aorta/download_spkl_m');
    }

    public function check_session()
    {
        $user_session = $this->session->all_userdata();
        if ($user_session['NPK'] == '') {
            redirect(base_url('index.php/login_c'));
        }
    }


    function index($msg = NULL)
    {

        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Creating success </strong> The data is successfully created </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Updating success </strong> The data is successfully updated </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Deleted success </strong> The data is successfully deleted </div >";
        } elseif ($msg == 13) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Delete failed !</strong> Quota ini sudah disetujui / dalam proses persetujuan, tidak bisa didelete </div >";
        } elseif ($msg == 15) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Executing error !</strong> Template Anda Salah atau sudah diubah, Silahkan Coba Lagi Dengan Template Yang Benar </div >";
        } elseif ($msg == 12) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Executing error !</strong> Something error with parameter </div >";
        }

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(360);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Download SPKL';
        $data['msg'] = $msg;


        $user_session = $this->session->all_userdata();
        $npk = $user_session['NPK'];
        $role = $user_session['ROLE'];
        $id_dept = $user_session['DEPT'];
        $id_group = $user_session['GROUPDEPT'];
        $id_division = $user_session['DIVISION'];

        $data['npk'] = $npk;
        $data['role'] = $role;

        $mulai = date('Ymd');
        $selesai = date('Ymd');
        $gm = 1;
        $deptart = 'ALL';
        $download = 0;

        $data['tgl_mulai'] = substr($mulai, 0, 4) . '-' . substr($mulai, 4, 2) . '-' . substr($mulai, 6, 2); //untuk merubah format dari 20210701 menjadi 2021-07-01
        $data['tgl_selesai'] = substr($selesai, 0, 4) . '-' . substr($selesai, 4, 2) . '-' . substr($selesai, 6, 2);
        $data['cek_gm'] = $gm;
        $data['dept'] = $deptart;
        $data['status_download'] = $download;

        $data['data_download'] = $this->download_spkl_m->get($mulai, $selesai, $gm, $deptart, $download);

        $data['content'] = 'aorta/download_spkl/manage_download_spkl_v'; // NAMA VIEW 
        $this->load->view($this->layout, $data);
    }

    function downloadMultiple()
    {

        if ($this->input->post("SPKL")) {


            $no_spkl =  $this->input->post("SPKL");

            $len = count($no_spkl);
            $list_spkl = '';
            for ($i = 0; $i < $len; $i++) {
                $spkl = $no_spkl[$i];

                if ($i < $len - 1) {
                    $list_spkl .= "'" . $spkl . "',";
                } else {
                    $list_spkl .= "'" . $spkl . "'";
                }
            }

            // print_r($list_spkl);
            // exit();


            $data['data_download'] = $this->download_spkl_m->status_m($list_spkl);
            $data['data_download'] = $this->download_spkl_m->check_excel_all($list_spkl);

            // print_r($data['data_download']);
            // exit();

            $this->load->library('Excel');


            $objPHPExcel = new PHPExcel();

            $objPHPExcel->getProperties()->setCreator("Aisin Indonesia");
            $objPHPExcel->getProperties()->setLastModifiedBy("Aisin Indonesia");
            $objPHPExcel->getProperties()->setTitle("SPKL");
            $objPHPExcel->getProperties()->setSubject("SPKL");
            $objPHPExcel->getProperties()->setDescription("SPKL");


            $objReader = PHPExcel_IOFactory::createReader('Excel5');

            $objPHPExcel = $objReader->load("assets/template/rpt_aoreal.xls");


            $baris = 2;


            foreach ($data['data_download'] as  $isi) {
                $objPHPExcel->getActiveSheet()->setCellValue('A' . $baris, $isi->Reference);
                $objPHPExcel->getActiveSheet()->setCellValue('B' . $baris, $isi->NPK);
                $objPHPExcel->getActiveSheet()->setCellValue('C' . $baris, $isi->TGL_OVERTIME);
                $objPHPExcel->getActiveSheet()->setCellValue('D' . $baris, $isi->TGL_ENTRY);
                $objPHPExcel->getActiveSheet()->setCellValue('E' . $baris, $isi->TGL_OVERTIME);
                $objPHPExcel->getActiveSheet()->setCellValueExplicit('F' . $baris, $isi->OVT_IN_TIME,PHPExcel_Cell_DataType::TYPE_STRING);
                $objPHPExcel->getActiveSheet()->setCellValue('G' . $baris, $isi->OVT_OUT_DATE);
                $objPHPExcel->getActiveSheet()->setCellValueExplicit('H' . $baris, $isi->OVT_OUT_TIME,PHPExcel_Cell_DataType::TYPE_STRING);
                $objPHPExcel->getActiveSheet()->setCellValue('I' . $baris, $isi->Remark);

                $baris++;
            }


            $filename = "All-" . date("Y-m-d")  . ".xls";
            ob_end_clean();
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="' . trim($filename) . '"');
            header('Cache-Control: max-age=0');


            $writer = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $writer->save('php://output');


            exit;
        } else {
            redirect('index.php/aorta/download_spkl_c');
        }
    }

    function search($msg = NULL)
    {

        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Creating success </strong> The data is successfully created </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Updating success </strong> The data is successfully updated </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Deleted success </strong> The data is successfully deleted </div >";
        } elseif ($msg == 13) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Delete failed !</strong> Quota ini sudah disetujui / dalam proses persetujuan, tidak bisa didelete </div >";
        } elseif ($msg == 15) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Executing error !</strong> Template Anda Salah atau sudah diubah, Silahkan Coba Lagi Dengan Template Yang Benar </div >";
        } elseif ($msg == 12) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Executing error !</strong> Something error with parameter </div >";
        }

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(360);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Download SPKL';
        $data['msg'] = $msg;

        $user_session = $this->session->all_userdata();
        $npk = $user_session['NPK'];
        $role = $user_session['ROLE'];
        $id_dept = $user_session['DEPT'];
        $id_group = $user_session['GROUPDEPT'];
        $id_division = $user_session['DIVISION'];

        $data['npk'] = $npk;
        $data['role'] = $role;

        $mulai = $this->input->post("tgl_mulai");
        $selesai = $this->input->post("tgl_selesai");
        $gm = $this->input->post("cek_gm");
        $deptart = $this->input->post("dept");
        $download = $this->input->post("status_download");

        $data['tgl_mulai'] = $mulai; //mengambil value 2021-07-01 dari view
        $data['tgl_selesai'] = $selesai;
        $data['cek_gm'] = $gm;
        $data['dept'] = $deptart;
        $data['status_download'] = $download;

        $mulai = str_replace("-", "", "$mulai"); //untuk merubah format date dari 2021-07-01 menjadi 20210701
        $selesai = str_replace("-", "", "$selesai");

        if ($this->input->post("download_list")) {
            $this->load->library('Excel');

            $data['data_download'] = $this->download_spkl_m->get($mulai, $selesai, $gm, $deptart, $download);

            $object = new PHPExcel();

            $object->getProperties()->setCreator("Aisin Indonesia");
            $object->getProperties()->setLastModifiedBy("Aisin Indonesia");
            $object->getProperties()->setTitle("SPKL");
            $object->getProperties()->setSubject("SPKL");
            $object->getProperties()->setDescription("SPKL");

            // $object->setActiveSheetIndex(0);

            //SETUP EXCEL
            $object->setActiveSheetIndex();
            $worksheet = $object->getActiveSheet();
            // $worksheet->setTitle($period . "_" . $dept);

            //WIDTH
            $worksheet->getColumnDimension('A')->setWidth(12.14);
            $worksheet->getColumnDimension('B')->setWidth(18.29);
            $worksheet->getColumnDimension('C')->setWidth(13.71);
            $worksheet->getColumnDimension('D')->setWidth(16.14);
            $worksheet->getColumnDimension('E')->setWidth(17.57);
            $worksheet->getColumnDimension('F')->setWidth(17.29);

            $worksheet->getStyle("A:I")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
            // $worksheet->getStyle("A1:I1")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

            //HEADER
            $worksheet->setCellValue('A1', 'SPKL');
            $worksheet->setCellValue('B1', 'Tanggal Overtime');
            $worksheet->setCellValue('C1', 'Dept');
            $worksheet->setCellValue('D1', 'Jumlah Karyawan');
            $worksheet->setCellValue('E1', 'Plan Overtime');
            $worksheet->setCellValue('F1', 'Real Overtime');


            $baris = 2;


            foreach ($data['data_download'] as  $isi) {
                $worksheet->setCellValue('A' . $baris, $isi->SPKL);
                $worksheet->setCellValue('B' . $baris, $isi->TGL_OVERTIME);
                $worksheet->setCellValue('C' . $baris, $isi->KD_DEPT);
                $worksheet->setCellValue('D' . $baris, $isi->Karyawan);
                $worksheet->setCellValue('E' . $baris, $isi->Plan_OT);
                $worksheet->setCellValue('F' . $baris, $isi->Real_OT);


                $baris++;
            }


            $filename = "List"  . ".xlt";
            ob_end_clean();
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="' . trim($filename) . '"');
            header('Cache-Control: max-age=0');

            $writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
            $writer->save('php://output');
        }

        $data['data_download'] = $this->download_spkl_m->get($mulai, $selesai, $gm, $deptart, $download);
        $data['content'] = 'aorta/download_spkl/manage_download_spkl_v'; // NAMA VIEW 
        $this->load->view($this->layout, $data);
    }

    function belum_GM($period = null, $dept = null, $section = null, $msg = NULL)
    {

        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Creating success </strong> The data is successfully created </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Updating success </strong> The data is successfully updated </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Deleted success </strong> The data is successfully deleted </div >";
        } elseif ($msg == 13) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Delete failed !</strong> Quota ini sudah disetujui / dalam proses persetujuan, tidak bisa didelete </div >";
        } elseif ($msg == 15) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Executing error !</strong> Template Anda Salah atau sudah diubah, Silahkan Coba Lagi Dengan Template Yang Benar </div >";
        } elseif ($msg == 12) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Executing error !</strong> Something error with parameter </div >";
        }

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(360);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Download SPKL';
        $data['msg'] = $msg;


        $user_session = $this->session->all_userdata();
        $npk = $user_session['NPK'];
        $role = $user_session['ROLE'];
        $id_dept = $user_session['DEPT'];
        $id_group = $user_session['GROUPDEPT'];
        $id_division = $user_session['DIVISION'];

        if ($period == NULL) {
            $period = date('Ym');
        }

        $data['npk'] = $npk;
        $data['role'] = $role;
        $data['dept'] = $dept;
        $data['section'] = $section;
        $data['period'] = $period;


        $data['belum_GM_data_download'] = $this->download_spkl_m->belum_GM_m();
        // $data['data_if'] = $this->download_spkl_m->get_concat();
        // print_r($data['data_download']);
        // exit;

        $data['content'] = 'aorta/download_spkl/belum_GM_download_spkl_v'; // NAMA VIEW 
        $this->load->view($this->layout, $data);
    }


    function show($no_spkl)
    {

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(360);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Detail SPKL';



        $user_session = $this->session->all_userdata();
        $npk = $user_session['NPK'];
        $role = $user_session['ROLE'];
        $id_dept = $user_session['DEPT'];
        $id_group = $user_session['GROUPDEPT'];
        $id_division = $user_session['DIVISION'];


        $data['npk'] = $npk;
        $data['role'] = $role;
        // $data['SPKL'] = $this->download_spkl_m->excel_m($no_spkl);

        $data['detail_data_download'] = $this->download_spkl_m->detail_m($no_spkl);
        $data['belum_GM_data_download'] = $this->download_spkl_m->detail_m($no_spkl);


        $data['content'] = 'aorta/download_spkl/detail_download_spkl_v'; // NAMA VIEW 
        $this->load->view($this->layout, $data);
    }


    public function excel($no_spkl)
    {
        $this->download_spkl_m->status_m($no_spkl); //untuk update flg_download ketika di download
        $data = $this->download_spkl_m->getDatabyNo($no_spkl); //untuk download sesuai format excel

        $this->load->library('Excel');

        $objPHPExcel = new PHPExcel();

        $objPHPExcel->getProperties()->setCreator("Aisin Indonesia");
        $objPHPExcel->getProperties()->setLastModifiedBy("Aisin Indonesia");
        $objPHPExcel->getProperties()->setTitle("SPKL");
        $objPHPExcel->getProperties()->setSubject("SPKL");
        $objPHPExcel->getProperties()->setDescription("SPKL");

        $objReader = PHPExcel_IOFactory::createReader('Excel5');

        $objPHPExcel = $objReader->load("assets/template/rpt_aoreal.xls");

        $baris = 2;

        foreach ($data as  $isi) {
            
            $objPHPExcel->getActiveSheet()->setCellValue('A' . $baris, $isi->Reference);
            $objPHPExcel->getActiveSheet()->setCellValue('B' . $baris, $isi->NPK);
            $objPHPExcel->getActiveSheet()->setCellValue('C' . $baris, $isi->TGL_OVERTIME);
            $objPHPExcel->getActiveSheet()->setCellValue('D' . $baris, $isi->TGL_ENTRY);
            $objPHPExcel->getActiveSheet()->setCellValue('E' . $baris, $isi->TGL_OVERTIME);
            $objPHPExcel->getActiveSheet()->setCellValueExplicit('F' . $baris, $isi->OVT_IN_TIME,PHPExcel_Cell_DataType::TYPE_STRING);
            $objPHPExcel->getActiveSheet()->setCellValue('G' . $baris, $isi->OVT_OUT_DATE);
            $objPHPExcel->getActiveSheet()->setCellValueExplicit('H' . $baris, $isi->OVT_OUT_TIME,PHPExcel_Cell_DataType::TYPE_STRING);
            $objPHPExcel->getActiveSheet()->setCellValue('I' . $baris, $isi->Remark);

            $baris++;
        }


        $filename = $no_spkl  . ".xls";
        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . trim($filename) . '"');
        header('Cache-Control: max-age=0');

        $writer = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $writer->save('php://output');
    }

    public function excel_list()
    {
        $data['data_download'] = $this->download_spkl_m->get(); //untuk download sesuai format excel

        $this->load->library('Excel');

        $object = new PHPExcel();
        $object->getProperties()->setCreator("Aisin Indonesia");
        $object->getProperties()->setLastModifiedBy("Aisin Indonesia");
        $object->getProperties()->setTitle("SPKL");
        $object->getProperties()->setSubject("SPKL");
        $object->getProperties()->setDescription("SPKL");

        $object->setActiveSheetIndex();
        $worksheet = $object->getActiveSheet();

        //WIDTH
        $worksheet->getColumnDimension('A')->setWidth(12.14);
        $worksheet->getColumnDimension('B')->setWidth(18.29);
        $worksheet->getColumnDimension('C')->setWidth(13.71);
        $worksheet->getColumnDimension('D')->setWidth(16.14);
        $worksheet->getColumnDimension('E')->setWidth(17.57);
        $worksheet->getColumnDimension('F')->setWidth(17.29);

        $worksheet->getStyle("A:I")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
        // $worksheet->getStyle("A1:I1")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

        //HEADER
        $worksheet->setCellValue('A1', 'SPKL');
        $worksheet->setCellValue('B1', 'Tanggal Overtime');
        $worksheet->setCellValue('C1', 'Dept');
        $worksheet->setCellValue('D1', 'Jumlah Karyawan');
        $worksheet->setCellValue('E1', 'Plan Overtime');
        $worksheet->setCellValue('F1', 'Real Overtime');


        $baris = 2;


        foreach ($data['data_download'] as  $isi) {
            $worksheet->setCellValue('A' . $baris, $isi->SPKL);
            $worksheet->setCellValue('B' . $baris, $isi->TGL_OVERTIME);
            $worksheet->setCellValue('C' . $baris, $isi->KD_DEPT);
            $worksheet->setCellValue('D' . $baris, $isi->Karyawan);
            $worksheet->setCellValue('E' . $baris, $isi->Plan_OT);
            $worksheet->setCellValue('F' . $baris, $isi->Real_OT);


            $baris++;
        }


        $filename = "List"  . ".xls";
        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . trim($filename) . '"');
        header('Cache-Control: max-age=0');

        $writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
        $writer->save('php://output');

        exit;
    }

    public function excel_all()
    {

        // $data['data_download'] = $this->download_spkl_m->excel_all();
        $data_all = $this->download_spkl_m->get();

        $this->load->library('Excel');
        foreach ($data_all as  $vall) {
            $no_spkl = $vall->SPKL;
            $this->excel($no_spkl);
        }
    }
}
