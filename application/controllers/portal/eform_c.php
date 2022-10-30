<?php

class eform_c extends CI_Controller {

    private $layout = '/template/head';
    private $back_to_manage = 'portal/eform_c/index/';

    public function __construct() {
        parent::__construct();
        $this->load->model('portal/eform_m');
        $this->load->model('organization/dept_m');
    }

    public function index() {
        $data['title'] = 'Report Healthy';
        $data['content'] = 'portal/report_healthy_v';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(194);
        $data['news'] = $this->news_m->get_news();
        $kode_group = $this->session->userdata('GROUPDEPT');
        $id_dept = $this->session->userdata('DEPT');

        $session = $this->session->all_userdata();
        if($session['ROLE'] === 4 ){
            $data['getdept'] = $this->eform_m->get_dept_gm($kode_group);
        } elseif($session['ROLE'] === 39 || $session['ROLE'] === 5 || $session['ROLE'] === 30 || $session['ROLE'] === 40 || $session['ROLE'] === 32 || $session['ROLE'] === 58 || $session['ROLE'] === 27){
            $data['getdept'] = $this->eform_m->get_dept_mgr($kode_group,$id_dept);
        } elseif($session['ROLE'] === 1 || $session['ROLE'] === 3 || $session['ROLE'] === 2 || $session['ROLE'] === 4 || $session['ROLE'] === 47){
            $data['getdept'] = $this->eform_m->get_dept();
        };

        if ($this->input->post("filter") == 1) {
            $date_from = date("Ymd", strtotime($this->input->post("CHR_DATE_FROM")));
            $date_to = date("Ymd", strtotime($this->input->post("CHR_DATE_TO")));
            $dept = $this->input->post("CHR_DEPT_FIL");
        } else {
            $date_from = date("Ymd");
            $date_to = date("Ymd");
            $dept = $this->input->post("CHR_DEPT_FIL");
        }
        $date_now = date("Ymd");
        $data['tgl_cov'] = $this->eform_m->get_tgl($date_now);
        $data['tgl_upd'] = $this->eform_m->get_upd($date_now);

        $data['date_from'] = $date_from;
        $data['date_to'] = $date_to;
        $data['dept'] = $dept;

        if($dept == ''){
            if($session['ROLE'] === 39 || $session['ROLE'] === 5 || $session['ROLE'] === 30 || $session['ROLE'] === 40 || $session['ROLE'] === 32 || $session['ROLE'] === 58 || $session['ROLE'] === 27){
                $dept = $this->eform_m->nama_dept($id_dept);
                $data['dt_healthy'] = $this->eform_m->get_history_healthy_dept($date_from, $date_to,$dept);
            }else{
                $data['dt_healthy'] = 'NULL';
            }
        }elseif($dept == 'ALL'){
            $data['dt_healthy'] = $this->eform_m->get_history_healthy_all($date_from, $date_to);                
        }else{
            $data['dt_healthy'] = $this->eform_m->get_history_healthy_dept($date_from, $date_to,$dept);
        }
        
        $this->load->view($this->layout, $data);
    }

    public function print_history_healthy() {
        $this->load->library('excel');

        $date_from = $this->input->post('FROM');
        $date_to = $this->input->post('TO');

        $data = $this->eform_m->get_history_healthy_all2($date_from, $date_to); 

        $objPHPExcel = new PHPExcel();

        $objPHPExcel->getProperties()->setCreator(trim('AIS - Report Healthy History'));
        $objPHPExcel->getProperties()->setLastModifiedBy(trim($this->session->userdata('USERNAME')));
        $objPHPExcel->getProperties()->setTitle("Report Healthy History");
        $objPHPExcel->getProperties()->setSubject("Report Healthy History");
        $objPHPExcel->getProperties()->setDescription("Report Healthy History");
        
        //SETUP EXCEL
        $width = 14;
        $objPHPExcel->setActiveSheetIndex();
        $worksheet = $objPHPExcel->getActiveSheet();
        $worksheet->setTitle($date_from.'-'.$date_to); 
       
        //TABLE PRODUCTION QTY
        $worksheet->setCellValue('A1', 'No.');
        $worksheet->setCellValue('B1', 'NPK');
        $worksheet->setCellValue('C1', 'Nama');
        $worksheet->setCellValue('D1', 'Dept');
        $worksheet->setCellValue('E1', 'Suhu');
        $worksheet->setCellValue('F1', 'Aktifitas');
        $worksheet->setCellValue('G1', 'Kondisi');
        $worksheet->setCellValue('H1', 'Demam');
        $worksheet->setCellValue('I1', 'Kontak Covid19');
        $worksheet->setCellValue('J1', 'Tetangga Covid19');
        $worksheet->setCellValue('K1', 'Anda Sakit?');
        $worksheet->setCellValue('L1', 'Keluarga Sakit?');
        $worksheet->setCellValue('M1', 'Sedang Sakit');
        $worksheet->setCellValue('N1', 'Hasil SA');
        $worksheet->setCellValue('O1', 'Tanggal');
        $worksheet->setCellValue('P1', 'Jam');
        $worksheet->setCellValue('Q1', 'Lokasi');
        $worksheet->setCellValue('R1', 'Resiko Area');

        $e = 2;
        $no = 1;
        foreach ($data as $row) {
            $worksheet->setCellValue("A$e", $no);
            $worksheet->setCellValue("B$e", "'".$row->npk);
            $worksheet->setCellValue("C$e", $row->username);
            $worksheet->setCellValue("D$e", $row->dept);
            $worksheet->setCellValue("E$e", $row->temp);
            $worksheet->setCellValue("F$e", $row->activity);
            $worksheet->setCellValue("G$e", $row->status);
            $worksheet->setCellValue("H$e", $row->flg_fever);
            $worksheet->setCellValue("I$e", $row->flg_contact);
            $worksheet->setCellValue("J$e", $row->flg_interaction);
            $worksheet->setCellValue("K$e", $row->flg_fit);
            $worksheet->setCellValue("L$e", $row->fams_condition);
            $worksheet->setCellValue("M$e", $row->ill_condition);
            $worksheet->setCellValue("N$e", $row->flg_sa);
            $worksheet->setCellValue("O$e", $row->date);
            $worksheet->setCellValue("P$e", $row->time);
            $worksheet->setCellValue("Q$e", $row->city);
            $worksheet->setCellValue("R$e", $row->city);
            $e++;
            $no++;
        }

        $filename = 'report_history_healthy_'. date("H:i") . ".xlt";
        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . trim($filename) . '"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->setIncludeCharts(TRUE);
        $objWriter->save('php://output');
    }

    public function weekly_report(){
        $data['title'] = 'Report Healthy';
        $data['content'] = 'portal/weekly_healthy_v';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(119);
        $data['news'] = $this->news_m->get_news();
        $kode_group = $this->session->userdata('GROUPDEPT');
        $id_dept = $this->session->userdata('DEPT');
        
        $session = $this->session->all_userdata();
        if($session['ROLE'] === 4 ){
            $data['getdept'] = $this->eform_m->get_dept_gm($kode_group);
        } elseif($session['ROLE'] === 39 || $session['ROLE'] === 5 || $session['ROLE'] === 30 || $session['ROLE'] === 40 || $session['ROLE'] === 32 || $session['ROLE'] === 58 || $session['ROLE'] === 27){
            $data['getdept'] = $this->eform_m->get_dept_mgr($kode_group,$id_dept);
        } elseif($session['ROLE'] === 1 || $session['ROLE'] === 3 || $session['ROLE'] === 2 || $session['ROLE'] === 4 || $session['ROLE'] === 47){
            $data['getdept'] = $this->eform_m->get_dept();
        };

        if ($this->input->post("filter") == 1) {
            $dept = $this->input->post("CHR_DEPT_FIL");
            $date = ($this->input->post("CHR_DATE"));
            $month = substr($date,4,2);
            $year = substr($date,0,4);
        } else {
            $dept = $this->input->post("CHR_DEPT_FIL");
            $date = date("Ym");
            $month = substr($date,4,2);
            $year = substr($date,0,4);
        }
        $data['selected_date'] = $date;
        $data['dept'] = $dept;

        if($dept == ''){
            if($session['ROLE'] === 39 || $session['ROLE'] === 5 || $session['ROLE'] === 30 || $session['ROLE'] === 40 || $session['ROLE'] === 32 || $session['ROLE'] === 58 || $session['ROLE'] === 27){
                $dept = $this->eform_m->nama_dept($id_dept);
                $data['dt_week'] = $this->eform_m->get_history_weekly_dept($month,$year,$dept);
            }else{
                $data['dt_week'] = 'NULL';
            }
        }elseif($dept == 'ALL'){
            $data['dt_week'] = $this->eform_m->get_history_weekly_all($month,$year);
        } else {
            $data['dt_week'] = $this->eform_m->get_history_weekly_dept($month,$year,$dept);
        }

        $this->load->view($this->layout, $data);
    }

}