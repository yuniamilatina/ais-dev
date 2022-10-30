<?php

class table_c extends CI_Controller {

    private $layout = '/template/head';
    private $back_to_manage = 'basis/table_c/index/';
    private $home = '/basis/home_c';

    public function __construct() {
        parent::__construct();
        $this->load->model('mis/table_m');
    }

    //show all data
    function index($msg = NULL) {

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(98);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Documentation of Table';
        $data['msg'] = $msg;

        $data['data'] = $this->table_m->get_data_table();
        $data['content'] = 'mis/manage_table_v';
        $this->load->view($this->layout, $data);
    }

    function print_documentation($catalog, $scheme, $name){
        $data = $this->table_m->get_data_table_by_id($catalog, $scheme, $name);
        
        $this->load->library('excel');

        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

        // Set properties
        $objPHPExcel->getProperties()->setCreator(trim($this->session->userdata('USERNAME')));
        $objPHPExcel->getProperties()->setLastModifiedBy(trim($this->session->userdata('USERNAME')));
        $objPHPExcel->getProperties()->setTitle("MIS");
        $objPHPExcel->getProperties()->setSubject("MIS");
        $objPHPExcel->getProperties()->setDescription("MIS");
        // Set Properties
        //SETUP EXCEL
        $width = 16;
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth($width);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth($width);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth($width);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(22);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(26);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth($width);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(22);
        //SETUP EXCEL

        //TABLE PRODUCTION QTY
        $objPHPExcel->getActiveSheet()->setCellValue('A3', 'Ordinal Position');
//        $objPHPExcel->getActiveSheet()->setCellValue('B3', 'Table Catalog');
//        $objPHPExcel->getActiveSheet()->setCellValue('C3', 'Table Schema');
//        $objPHPExcel->getActiveSheet()->setCellValue('D3', 'Table Name');
        $objPHPExcel->getActiveSheet()->setCellValue('B3', 'Column Name');
        $objPHPExcel->getActiveSheet()->setCellValue('C3', 'Data Type');
        $objPHPExcel->getActiveSheet()->setCellValue('D3', 'Character Max Length');
        $objPHPExcel->getActiveSheet()->setCellValue('E3', 'Constraint Type');
        $objPHPExcel->getActiveSheet()->setCellValue('F3', 'Column Default');
        $objPHPExcel->getActiveSheet()->setCellValue('G3', 'Is Nullable');
        
        $objPHPExcel->getActiveSheet()->setCellValue("A1", $catalog.'.'.$scheme.'.'.$name);

        $e = 4;
        foreach ($data as $row) {
                $objPHPExcel->getActiveSheet()->setCellValue("A$e", $row->ORDINAL_POSITION);
//                $objPHPExcel->getActiveSheet()->setCellValue("B$e", $row->TABLE_CATALOG);
//                $objPHPExcel->getActiveSheet()->setCellValue("C$e", $row->TABLE_SCHEMA);
//                $objPHPExcel->getActiveSheet()->setCellValue("D$e", $row->TABLE_NAME);
                $objPHPExcel->getActiveSheet()->setCellValue("B$e", $row->COLUMN_NAME);
                $objPHPExcel->getActiveSheet()->setCellValue("C$e", $row->DATA_TYPE);
                $objPHPExcel->getActiveSheet()->setCellValue("D$e", $row->CHARACTER_MAXIMUM_LENGTH);
                $objPHPExcel->getActiveSheet()->setCellValue("E$e", $row->CONSTRAINT_TYPE);
                $objPHPExcel->getActiveSheet()->setCellValue("F$e", $row->COLUMN_DEFAULT);
                $objPHPExcel->getActiveSheet()->setCellValue("G$e", $row->IS_NULLABLE);
            $e++;
        }

        $e = $e - 1;
        $objPHPExcel->getActiveSheet()->getStyle("A3:G$e")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

        $filename = $catalog.'.'.$scheme.'.'.$name. ".xlt";
        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . trim($filename) . '"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->setIncludeCharts(TRUE);
        $objWriter->save('php://output');
    }


}
