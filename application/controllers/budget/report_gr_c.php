<?php

class report_gr_c extends CI_Controller {
	private $layout = '/template/head';
    private $back_to_manage = 'portal/calendar_c/index/';

    public function __construct() {
        parent::__construct();
        $this->load->model('basis/log_m');
        $this->load->model('basis/role_module_m');
        $this->load->model('budget/fiscal_m');
        $this->load->model('budget/report_gr_m');
        $this->load->model('portal/news_m');
        //$this->load->library('excel');
        //$this->load->library('PHPExcel');
        //$this->load->model('portal/notification_m');
    }
    function index(){
		$fiscal_start = NULL; 
		$bgt_type = NULL;
		$kode_dept = NULL; 
		$kode_sect = NULL;
    	$this->role_module_m->authorization('291');
		$get_fiscal = $this->fiscal_m->get_default_fiscal_year();
        $fiscal_start = $get_fiscal->CHR_FISCAL_YEAR_START;
        $fiscal_end = $get_fiscal->CHR_FISCAL_YEAR_END;
        
        $session = $this->session->all_userdata();
        if ($session['ROLE'] === 2 || $session['ROLE'] === 1 || $session['ROLE'] === 13 || $session['NPK'] === '0483a' || $session['NPK'] === '0483' || $session['NPK'] === '7520') {
            
            if($bgt_type == NULL){
                $bgt_type = 'CAPEX';
            }
            				
            $kode_dept = '';
			$kode_sect = '';
            
            $data['list_sect'] = $this->report_gr_m->get_all_sect($fiscal_start, $bgt_type, $kode_dept);
            $data_contain = $this->report_gr_m->get_gr_actual_capex($fiscal_start, $fiscal_end, $bgt_type, $kode_dept, $kode_sect);
			$data_contain_detail = $this->report_gr_m->get_gr_actual_capex_detail($fiscal_start, $fiscal_end, $bgt_type, $kode_dept, $kode_sect);
           
        } else {
            $id_dept = $this->session->userdata('DEPT');
			$kode_dept = $this->report_gr_m->get_user_dept($id_dept)->CHR_DEPT;
            
            if($kode_dept == 'QA'){
                $kode_dept = 'QCO';
            } else if($kode_dept == 'PC'){
                $kode_dept = 'KQC';
            } else {
                $kode_dept = trim($kode_dept);
            } 
            
            $kode_sect = '';
			                                 
            if($bgt_type == NULL){
                $bgt_type = 'CAPEX';
            }
            
            $data['list_sect'] = $this->report_gr_m->get_all_sect($fiscal_start, $bgt_type, $kode_dept);            
            $data_contain = $this->report_gr_m->get_gr_actual_capex($fiscal_start, $fiscal_end, $bgt_type, $kode_dept, $kode_sect);
            $data_contain_detail = $this->report_gr_m->get_gr_actual_capex_detail($fiscal_start, $fiscal_end, $bgt_type, $kode_dept, $kode_sect);
        } 
        
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(291);
        //$data['news'] = $this->news_m->get_news();
        $data['role'] = $session['ROLE'];
        $data['npk'] = $session['NPK'];
		
		//Send single data
		$data['fiscal_start'] = $fiscal_start;
        $data['fiscal_end'] = $fiscal_end;
        $data['bgt_type'] = $bgt_type;
        $data['kode_dept'] = $kode_dept;
        $data['kode_sect'] = $kode_sect;        
        
        //Send list data
        $data['data_fiscal'] = $this->fiscal_m->get_all_fiscal_year();
        $data['list_budget_type'] = $this->report_gr_m->get_budget_type();
        $data['list_dept'] = $this->report_gr_m->get_all_dept();
        
        $data['list_data'] = $data_contain;
		$data['list_data_detail'] = $data_contain_detail;

        //$data['data'] = $this->report_m->get_all();
        $data['title'] = 'Report GR Actual';
        //$data['data'] = $this->calendar_m->find_trans("*","");
        $data['content'] = 'budget/report_budget/report_gr_v';
        $this->load->view($this->layout, $data);
    }
	
	function filter($fiscal_start = NULL, $bgt_type = NULL, $kode_dept = NULL, $kode_sect = NULL){
    	$this->role_module_m->authorization('291');
		
		if($fiscal_start == NULL)
		{
			$get_fiscal = $this->fiscal_m->get_default_fiscal_year();
		}
		else
		{
			$get_fiscal = $this->fiscal_m->get_selected_fiscal_year($fiscal_start);
		}
		$fiscal_start = $get_fiscal->CHR_FISCAL_YEAR_START;
		$fiscal_end = $get_fiscal->CHR_FISCAL_YEAR_END;
        
        $session = $this->session->all_userdata();
        if ($session['ROLE'] === 2 || $session['ROLE'] === 1 || $session['ROLE'] === 13 || $session['NPK'] === '0483a' || $session['NPK'] === '0483' || $session['NPK'] === '7520') {
            
            if($kode_dept == 'QA'){
                $kode_dept = 'QCO';
            } else if($kode_dept == 'PC'){
                $kode_dept = 'KQC';
            } else {
                $kode_dept = trim($kode_dept);
            }            
            
            if($bgt_type == NULL){
                $bgt_type = 'CAPEX';
            }
            
            if($kode_sect == 'ALL'){
                $kode_sect = '';
            }
			
			if($kode_dept == 'ALL') {	
              $kode_dept = '';
			  $kode_sect = '';
			}
            
            $data['list_sect'] = $this->report_gr_m->get_all_sect($fiscal_start, $bgt_type, $kode_dept);
			if($bgt_type == 'CAPEX'){
				 $data_contain = $this->report_gr_m->get_gr_actual_capex($fiscal_start, $fiscal_end, $bgt_type, $kode_dept, $kode_sect);
				 $data_contain_detail = $this->report_gr_m->get_gr_actual_capex_detail($fiscal_start, $fiscal_end, $bgt_type, $kode_dept, $kode_sect);
            }
			else
			{
				$data_contain = $this->report_gr_m->get_gr_actual_expense($fiscal_start, $fiscal_end, $bgt_type, $kode_dept, $kode_sect);
				$data_contain_detail = $this->report_gr_m->get_gr_actual_expense_detail($fiscal_start, $fiscal_end, $bgt_type, $kode_dept, $kode_sect);
			}
           
           
        } else {
            $id_dept = $this->session->userdata('DEPT');
            $kode_dept = $this->report_gr_m->get_user_dept($id_dept)->CHR_DEPT; 
            
            if($kode_dept == 'QA'){
                $kode_dept = 'QCO';
            } else if($kode_dept == 'PC'){
                $kode_dept = 'KQC';
            } else {
                $kode_dept = trim($kode_dept);
            } 
            
            if($kode_sect == 'ALL'){
                $kode_sect = '';
            }        
			
			if($kode_dept == 'ALL') {	
              $kode_dept = '';
			  $kode_sect = '';
            }
            
            
                                 
            if($bgt_type == NULL){
                $bgt_type = 'CAPEX';
            }
            
            $data['list_sect'] = $this->report_gr_m->get_all_sect($fiscal_start, $bgt_type, $kode_dept);            
            if($bgt_type == 'CAPEX'){
				 $data_contain = $this->report_gr_m->get_gr_actual_capex($fiscal_start, $fiscal_end, $bgt_type, $kode_dept, $kode_sect);
				 $data_contain_detail = $this->report_gr_m->get_gr_actual_capex_detail($fiscal_start, $fiscal_end, $bgt_type, $kode_dept, $kode_sect);
            }
			else
			{
				$data_contain = $this->report_gr_m->get_gr_actual_expense($fiscal_start, $fiscal_end, $bgt_type, $kode_dept, $kode_sect);
				$data_contain_detail = $this->report_gr_m->get_gr_actual_expense_detail($fiscal_start, $fiscal_end, $bgt_type, $kode_dept, $kode_sect);
			}
           
        } 
        
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(291);
        //$data['news'] = $this->news_m->get_news();
        $data['role'] = $session['ROLE'];
        $data['npk'] = $session['NPK'];
		
		//Send single data
		$data['fiscal_start'] = $fiscal_start;
        $data['fiscal_end'] = $fiscal_end;
        $data['bgt_type'] = $bgt_type;
        $data['kode_dept'] = $kode_dept;
        $data['kode_sect'] = $kode_sect;        
        
        //Send list data
        $data['data_fiscal'] = $this->fiscal_m->get_all_fiscal_year();
        $data['list_budget_type'] = $this->report_gr_m->get_budget_type();
        $data['list_dept'] = $this->report_gr_m->get_all_dept();
        
        $data['list_data'] = $data_contain;
		$data['list_data_detail'] = $data_contain_detail;

        //$data['data'] = $this->report_m->get_all();
        $data['title'] = 'Report GR Actual';
        //$data['data'] = $this->calendar_m->find_trans("*","");
        $data['content'] = 'budget/report_budget/report_gr_v';
        $this->load->view($this->layout, $data);
    }
    
    function export_report_gr_actual() {
        $this->load->library('excel');
        
        $fiscal_start = $this->input->post("CHR_FISCAL_EXP");
        $fiscal_end = $fiscal_start + 1;
        $kode_dept = $this->input->post("CHR_DEPT_EXP");
        $kode_sect = $this->input->post("CHR_SECT_EXP");
        $bgt_type = $this->input->post("CHR_BUDGET_TYPE_EXP");
        
        if($kode_sect == 'ALL'){
            $kode_sect = '';
        }
		if($kode_dept == 'ALL'){
            $kode_dept = '';
        }
		
		if($bgt_type == 'CAPEX'){
				 $list_gr_actual = $this->report_gr_m->get_gr_actual_capex($fiscal_start, $fiscal_end, $bgt_type, $kode_dept, $kode_sect);
        }
		else
		{
				$list_gr_actual = $this->report_gr_m->get_gr_actual_expense($fiscal_start, $fiscal_end, $bgt_type, $kode_dept, $kode_sect);
		}  
//        print_r($list_budget);
//        exit();

        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

        // Set Properties
        $objPHPExcel->getProperties()->setCreator(trim($this->session->userdata('USERNAME')));
        $objPHPExcel->getProperties()->setLastModifiedBy(trim($this->session->userdata('USERNAME')));
        $objPHPExcel->getProperties()->setTitle("REPORT GR ACTUAL");
        $objPHPExcel->getProperties()->setSubject("REPORT GR ACTUAL");
        $objPHPExcel->getProperties()->setDescription("REPORT GR ACTUAL");
                
        //Header TR
        $objPHPExcel->getActiveSheet()->setCellValue('A2', 'NO');
        $objPHPExcel->getActiveSheet()->getStyle("A2")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('B2', 'SECTION');
        $objPHPExcel->getActiveSheet()->getStyle("B2")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('C2', 'AMOUNT');
        $objPHPExcel->getActiveSheet()->getStyle("C2")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('C3', 'APRIL '.$fiscal_start);
        $objPHPExcel->getActiveSheet()->getStyle("C3")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('D3', 'MEI '.$fiscal_start);
        $objPHPExcel->getActiveSheet()->getStyle("D3")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('E3', 'JUNI '.$fiscal_start);
        $objPHPExcel->getActiveSheet()->getStyle("E3")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('F3', 'JULI '.$fiscal_start);
        $objPHPExcel->getActiveSheet()->getStyle("F3")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('G3', 'AGUSTUS '.$fiscal_start);
        $objPHPExcel->getActiveSheet()->getStyle("G3")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('H3', 'SEPTEMBER '.$fiscal_start);
        $objPHPExcel->getActiveSheet()->getStyle("H3")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('I3', 'OKTOBER '.$fiscal_start);
        $objPHPExcel->getActiveSheet()->getStyle("I3")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('J3', 'NOVEMBER '.$fiscal_start);
        $objPHPExcel->getActiveSheet()->getStyle("J3")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('K3', 'DESEMBER '.$fiscal_start);
        $objPHPExcel->getActiveSheet()->getStyle("K3")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('L3', 'JANUARI '.$fiscal_end);
        $objPHPExcel->getActiveSheet()->getStyle("L3")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('M3', 'FEBRUARI '.$fiscal_end);
        $objPHPExcel->getActiveSheet()->getStyle("M3")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('N3', 'MARET '.$fiscal_end);
        $objPHPExcel->getActiveSheet()->getStyle("N3")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->setCellValue('O3', 'TOTAL');
        $objPHPExcel->getActiveSheet()->getStyle("O3")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);  
       
                

        $objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true)->setSize(12);
        $objPHPExcel->getActiveSheet()->getStyle('B2')->getFont()->setBold(true)->setSize(12);
        $objPHPExcel->getActiveSheet()->getStyle('C2')->getFont()->setBold(true)->setSize(12);
		$objPHPExcel->getActiveSheet()->getStyle('C3')->getFont()->setBold(true)->setSize(10);
        $objPHPExcel->getActiveSheet()->getStyle('D3')->getFont()->setBold(true)->setSize(10);
        $objPHPExcel->getActiveSheet()->getStyle('E3')->getFont()->setBold(true)->setSize(10);
        $objPHPExcel->getActiveSheet()->getStyle('F3')->getFont()->setBold(true)->setSize(10);
        $objPHPExcel->getActiveSheet()->getStyle('G3')->getFont()->setBold(true)->setSize(10);
        $objPHPExcel->getActiveSheet()->getStyle('H3')->getFont()->setBold(true)->setSize(10);
        $objPHPExcel->getActiveSheet()->getStyle('I3')->getFont()->setBold(true)->setSize(10);
        $objPHPExcel->getActiveSheet()->getStyle('J3')->getFont()->setBold(true)->setSize(10);
        $objPHPExcel->getActiveSheet()->getStyle('K3')->getFont()->setBold(true)->setSize(10);
        $objPHPExcel->getActiveSheet()->getStyle('L3')->getFont()->setBold(true)->setSize(10);
        $objPHPExcel->getActiveSheet()->getStyle('M3')->getFont()->setBold(true)->setSize(10);
        $objPHPExcel->getActiveSheet()->getStyle('N3')->getFont()->setBold(true)->setSize(10);
		$objPHPExcel->getActiveSheet()->getStyle('O3')->getFont()->setBold(true)->setSize(10);
       
        
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(6);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(20);
		
		$objPHPExcel->getActiveSheet()->mergeCells('C2:N2');
        $objPHPExcel->getActiveSheet()->mergeCells('A2:A3');
        $objPHPExcel->getActiveSheet()->mergeCells('B2:B3');
        //$objPHPExcel->getActiveSheet()->mergeCells('02:03');
        
        //Value of All Cells
        $i = 4;
        $no = 1;
        foreach($list_gr_actual as $data){
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$i, $no);
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$i, $data->CHR_SECTION);
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$i, $data->MNY_APRIL);
            $objPHPExcel->getActiveSheet()->setCellValue('D'.$i, $data->MNY_MAY);
            $objPHPExcel->getActiveSheet()->setCellValue('E'.$i, $data->MNY_JUNE);
            $objPHPExcel->getActiveSheet()->setCellValue('F'.$i, $data->MNY_JULY);        
            $objPHPExcel->getActiveSheet()->setCellValue('G'.$i, $data->MNY_AUGUST);                
            $objPHPExcel->getActiveSheet()->setCellValue('H'.$i, $data->MNY_SEPTEMBER);        
            $objPHPExcel->getActiveSheet()->setCellValue('I'.$i, $data->MNY_OCTOBER);
            $objPHPExcel->getActiveSheet()->setCellValue('J'.$i, $data->MNY_NOVEMBER);        
            $objPHPExcel->getActiveSheet()->setCellValue('K'.$i, $data->MNY_DECEMBER);
			$objPHPExcel->getActiveSheet()->setCellValue('L'.$i, $data->MNY_JANUARY);
			$objPHPExcel->getActiveSheet()->setCellValue('M'.$i, $data->MNY_FEBRUARY);
			$objPHPExcel->getActiveSheet()->setCellValue('N'.$i, $data->MNY_MARCH);
			$objPHPExcel->getActiveSheet()->setCellValue('O'.$i, $data->MNY_TOTAL_AMOUNT);
            
            
            
            $objPHPExcel->getActiveSheet()->getStyle("B".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle("C".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle("D".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle("E".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle("F".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle("G".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle("H".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle("I".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle("J".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle("K".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle("L".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle("M".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle("N".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle("O".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            
            $i++;
            $no++;
        }
        
        $styleArray = array(
            'borders' => array(
                'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                ),
            ),
        );
        
        $styleArray2 = array(
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => '99CCFF')
            )
        );
        
        $objPHPExcel->getActiveSheet()->getStyle("A2:O2")->applyFromArray($styleArray2);
        
		if($kode_sect == '')
		{
			$filename = "Report GR ACTUAL ". $bgt_type ." for " . $kode_dept . " " . $fiscal_start . ".xls";
		}
		else
		{
			$filename = "Report GR ACTUAL ". $bgt_type ." for " . $kode_dept . " section ". $kode_sect . " " . $fiscal_start . ".xls";
		}
        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . trim($filename) . '"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->setIncludeCharts(TRUE);
        $objWriter->save('php://output');
    }
	
	function export_report_gr_actual_detail() {
        $this->load->library('excel');
        
        $fiscal_start = $this->input->post("CHR_FISCAL_EXP");
        $fiscal_end = $fiscal_start + 1;
        $kode_dept = $this->input->post("CHR_DEPT_EXP");
        $kode_sect = $this->input->post("CHR_SECT_EXP");
        $bgt_type = $this->input->post("CHR_BUDGET_TYPE_EXP");
        
        if($kode_sect == 'ALL'){
            $kode_sect = '';
        }
		if($kode_dept == 'ALL'){
            $kode_dept = '';
        }
        
        if($bgt_type == 'CAPEX'){
				$list_gr_actual = $this->report_gr_m->get_gr_actual_capex_detail($fiscal_start, $fiscal_end, $bgt_type, $kode_dept, $kode_sect);
        }
		else
		{
				$list_gr_actual = $this->report_gr_m->get_gr_actual_expense_detail($fiscal_start, $fiscal_end, $bgt_type, $kode_dept, $kode_sect);
		}
//        print_r($list_budget);
//        exit();

        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

        // Set Properties
        $objPHPExcel->getProperties()->setCreator(trim($this->session->userdata('USERNAME')));
        $objPHPExcel->getProperties()->setLastModifiedBy(trim($this->session->userdata('USERNAME')));
        $objPHPExcel->getProperties()->setTitle("REPORT GR ACTUAL - DETAIL");
        $objPHPExcel->getProperties()->setSubject("REPORT GR ACTUAL - DETAIL");
        $objPHPExcel->getProperties()->setDescription("REPORT GR ACTUAL - DETAIL");
                
        //Header TR
        $objPHPExcel->getActiveSheet()->setCellValue('A2', 'NO');
        $objPHPExcel->getActiveSheet()->getStyle("A2")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('B2', 'PR NO');
        $objPHPExcel->getActiveSheet()->getStyle("B2")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('C2', 'BUDGET NO');
        $objPHPExcel->getActiveSheet()->getStyle("C2")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('D2', 'ITEM DESCRIPTION');
        $objPHPExcel->getActiveSheet()->getStyle("D2")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('E2', 'GL ACCOUNT');
        $objPHPExcel->getActiveSheet()->getStyle("E2")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('F2', 'COST CENTER SAP');
        $objPHPExcel->getActiveSheet()->getStyle("F2")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('G2', 'GR DATE');
        $objPHPExcel->getActiveSheet()->getStyle("G2")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('H2', 'AMOUNT');
        $objPHPExcel->getActiveSheet()->getStyle("H2")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('I2', 'SUPPLIER');
        $objPHPExcel->getActiveSheet()->getStyle("I2")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('J2', 'PIC');
        $objPHPExcel->getActiveSheet()->getStyle("J2")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
                

        $objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true)->setSize(12);
        $objPHPExcel->getActiveSheet()->getStyle('B2')->getFont()->setBold(true)->setSize(12);
        $objPHPExcel->getActiveSheet()->getStyle('C2')->getFont()->setBold(true)->setSize(12);
        $objPHPExcel->getActiveSheet()->getStyle('D2')->getFont()->setBold(true)->setSize(12);
        $objPHPExcel->getActiveSheet()->getStyle('E2')->getFont()->setBold(true)->setSize(12);
        $objPHPExcel->getActiveSheet()->getStyle('F2')->getFont()->setBold(true)->setSize(12);
        $objPHPExcel->getActiveSheet()->getStyle('G2')->getFont()->setBold(true)->setSize(12);
        $objPHPExcel->getActiveSheet()->getStyle('H2')->getFont()->setBold(true)->setSize(12);
        $objPHPExcel->getActiveSheet()->getStyle('I2')->getFont()->setBold(true)->setSize(12);
        $objPHPExcel->getActiveSheet()->getStyle('J2')->getFont()->setBold(true)->setSize(12);
       
        
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(6);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(36);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(15);

        //$objPHPExcel->getActiveSheet()->mergeCells('02:03');
        
        //Value of All Cells
        $i = 3;
        $no = 1;
        foreach($list_gr_actual as $data){
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$i, $no);
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$i, $data->CHR_NO_PR);
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$i, $data->CHR_NO_BUDGET);
            $objPHPExcel->getActiveSheet()->setCellValue('D'.$i, $data->CHR_ITEM_DESC);
            $objPHPExcel->getActiveSheet()->setCellValue('E'.$i, $data->CHR_GL_ACCOUNT);
            $objPHPExcel->getActiveSheet()->setCellValue('F'.$i, $data->CHR_COST_CENTER_SAP);        
            $objPHPExcel->getActiveSheet()->setCellValue('G'.$i, $data->CHR_GR_DATE);                
            $objPHPExcel->getActiveSheet()->setCellValue('H'.$i, $data->MNY_AMOUNT);        
            $objPHPExcel->getActiveSheet()->setCellValue('I'.$i, $data->CHR_SUPPLIER);
            $objPHPExcel->getActiveSheet()->setCellValue('J'.$i, $data->CHR_PIC);        
      
            
            $objPHPExcel->getActiveSheet()->getStyle("B".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle("C".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle("D".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle("E".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle("F".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle("G".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle("H".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle("I".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle("J".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

            
            $i++;
            $no++;
        }
        
        $styleArray = array(
            'borders' => array(
                'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                ),
            ),
        );
        
        $styleArray2 = array(
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => '99CCFF')
            )
        );
        
        $objPHPExcel->getActiveSheet()->getStyle("A2:J2")->applyFromArray($styleArray2);
        
        if($kode_sect == '')
		{
			$filename = "Report GR ACTUAL - DETAIL ". $bgt_type ." for " . $kode_dept . " " . $fiscal_start . ".xls";
		}
		else
		{
			$filename = "Report GR ACTUAL - DETAIL ". $bgt_type ." for " . $kode_dept . " section ". $kode_sect . " " . $fiscal_start . ".xls";
		}
        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . trim($filename) . '"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->setIncludeCharts(TRUE);
        $objWriter->save('php://output');
    }
}
?>