<?php

//Add By xcx 20190507
class part_chart_c extends CI_Controller {

    private $layout = '/template/head';
    private $back_to_index = '/patricia/part_chart_c/index/';

    public function __construct() {
        parent::__construct();
        $this->load->model('patricia/specification_m');
        $this->load->model('patricia/part_chart_m');
        $this->load->model('basis/log_m');
        $this->load->model('basis/role_module_m');
        $this->load->library('excel');
    }

    function index($msg = NULL) {
        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Downloading success </strong>  The data is successfully created </div >";
        }
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(81);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Part Chart';
        $data['list_part'] = $this->part_chart_m->get_component();
        $data['selected_part']='';
        $data['selected_backno']='';
        $data['msg'] = $msg;
        $data['data'] = $this->part_chart_m->get_data(0,0);
        $data['margin'] = $this->part_chart_m->get_margin(0,0);
        // $data['margin'] = null;
        $data['content'] = 'patricia/part_chart/part_chart_v';
        $this->load->view($this->layout, $data);
    }
    function search($partno)
    {
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(81);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Part Chart';
        $data['list_part'] = $this->part_chart_m->get_component();
        $data['list_spek'] = $this->part_chart_m->get_spek($partno);
        $data['selected_part']=$partno;
        $data['selected_spek']='';
        $data['msg'] = NULL;
        $data['data'] = $this->part_chart_m->get_data(0,0);
        $data['margin'] = $this->part_chart_m->get_margin(0,0);
        $data['content'] = 'patricia/part_chart/part_chart_v';
        $this->load->view($this->layout, $data);
        
    }
    function get_chart()
    {
        $selected_part = $this->input->post('CHR_COMPONENT_ID');
        $selected_spek = $this->input->post('CHR_SPEK');

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(81);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Part Chart';
        $data['list_part'] = $this->part_chart_m->get_component();
        $data['list_spek'] = $this->part_chart_m->get_spek($selected_part);
        $data['selected_part']=$selected_part;
        $data['selected_spek']=$selected_spek;
        $data['msg'] = NULL;
        // $data['margin'] = null;
        
        $data['data']= $this->part_chart_m->get_data($selected_part,$selected_spek);
        $data['margin'] = $this->part_chart_m->get_margin($selected_part,$selected_spek);
        $data['content'] = 'patricia/part_chart/part_chart_v';
        $this->load->view($this->layout, $data);
    }

    function get_specification_by_partno(){
        $part_no_comp = $this->input->post("CHR_COMPONENT_ID");

        $list_spek = $this->part_chart_m->get_spek($part_no_comp);
        // $selected_spek = $this->part_chart_m->get_top_spec_by_partno_comp($part_no_comp);

        $data = '';

        foreach ($list_spek as $row) { 
            // if (trim($selected_spek) == trim($row->INT_SPECIFICATION_ID)){ 
            //     $data .="<option selected value='$row->INT_SPECIFICATION_ID'>".$row->INT_SPECIFICATION_ID."</option>";
            // }else{ 
                $data .="<option value='$row->INT_SPECIFICATION_ID'>".$row->CHR_SPECIFICATION."</option>";
            // }
        }
       
        $json_data = array('data' => $data);

        echo json_encode($json_data);
    }

    function get_param_by_partno_inline(){
        $part_id = $this->input->post("CHR_PART_ID");

        $list_param = $this->part_chart_m->get_param($part_id);
        // $selected_spek = $this->part_chart_m->get_top_spec_by_partno_comp($part_no_comp);

        $data = '';

        foreach ($list_param as $prm) { 
            // if (trim($selected_spek) == trim($row->INT_SPECIFICATION_ID)){ 
            //     $data .="<option selected value='$row->INT_SPECIFICATION_ID'>".$row->INT_SPECIFICATION_ID."</option>";
            // }else{ 
                $data .="<option value='$prm->CHR_ID_PARAM'>".$prm->CHR_PARAMETER."</option>";
            // }
        }
       
        $json_data = array('data' => $data);

        echo json_encode($json_data);
    }

    function export($part, $spek)
    {
        // Get Data
        $data = $this->part_chart_m->get_data($part,$spek);
        $margin = $this->part_chart_m->get_margin($part,$spek);
        $spek_name = $this->part_chart_m->get_spek_name($spek)->CHR_SPECIFICATION;
        // EA is Excel Aplication
        $objPHPExcel  = new PHPExcel();  

        // Set properties
        $objPHPExcel->getProperties()->setCreator(trim($this->session->userdata('USERNAME')));
        $objPHPExcel->getProperties()->setLastModifiedBy(trim($this->session->userdata('USERNAME')));
        // Set Properties

        // Set Active Sheet
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setTitle('Data');
        // Set Active Sheet

        // Set Header
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(9);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(9);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
        $objPHPExcel->getActiveSheet()->mergeCells('A1:d1');
        $objPHPExcel->getActiveSheet()->setCellValue('A1', ''.$part.' - '.$spek_name);
        $objPHPExcel->getActiveSheet()->setCellValue('A2', 'Sample');
        $objPHPExcel->getActiveSheet()->setCellValue('B2', 'Nilai');
        $objPHPExcel->getActiveSheet()->setCellValue('C2', 'Margin Atas');
        $objPHPExcel->getActiveSheet()->setCellValue('D2', 'Margin Bawah');

        // Set Data
        $baris =3;
        foreach ($data as $row) {
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$baris, 'Sampel '.($baris-2));
            //$objPHPExcel->getActiveSheet()->getStyle("K".$baris)->applyFromArray($style);
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$baris, $row->DEC_NILAI);
            //$objPHPExcel->getActiveSheet()->getStyle("L".$baris)->applyFromArray($style);
            $baris = $baris +1;
        }
        for($i=0;$i<30;$i++)
        {            
            $objPHPExcel->getActiveSheet()->setCellValue('C'.($i+3), $margin->DEC_STD_MAX); //Margin Atas
            //$objPHPExcel->getActiveSheet()->getStyle("K".$baris)->applyFromArray($style);
            $objPHPExcel->getActiveSheet()->setCellValue('D'.($i+3), $margin->DEC_STD_MIN); //Margin Bawah
            //$objPHPExcel->getActiveSheet()->getStyle("L".$baris)->applyFromArray($style);
        }

        //Data Series Label
        $dsl=array(
            new PHPExcel_Chart_DataSeriesValues('String', "'Data'".'!B2', NULL, 1),
            new PHPExcel_Chart_DataSeriesValues('String', "'Data'".'!C2', NULL, 1),
            new PHPExcel_Chart_DataSeriesValues('String', "'Data'".'!D2', NULL, 1),
        );
          //  $dsl='Nilai';

        // Data Nilai X
        $xal=array(
            new PHPExcel_Chart_DataSeriesValues('String', "'Data'"."!A3:A32", NULL, 30),
        );

        // Nilai yang akan dipakai ke array
        $dsv=array(
            new PHPExcel_Chart_DataSeriesValues('Number', "'Data'"."!B3:B32", NULL, 30),
            new PHPExcel_Chart_DataSeriesValues('Number', "'Data'"."!C3:C32", NULL, 30),
            new PHPExcel_Chart_DataSeriesValues('Number', "'Data'"."!D3:D32", NULL, 30),
        );
        echo count($dsv);

        // new PHPExcel_Chart_DataSeriesValues('Number', 'C2:C32', NULL, 30),
            // new PHPExcel_Chart_DataSeriesValues('Number', 'D2:D32', NULL, 30),
        // Data Series Value
        $ds=new PHPExcel_Chart_DataSeries(
            PHPExcel_Chart_DataSeries::TYPE_LINECHART,PHPExcel_Chart_DataSeries::GROUPING_STANDARD,range(0, 2),$dsl,$xal,$dsv
        );

        // Plot Area and Legend
        $pa=new PHPExcel_Chart_PlotArea(NULL, array($ds));
        $legend=new PHPExcel_Chart_Legend(PHPExcel_Chart_Legend::POSITION_RIGHT, NULL, false);
        $title=new PHPExcel_Chart_Title('Part Chart');

        // Set Chart
        $chart= new PHPExcel_Chart('chart1',$title,$legend,$pa,true,0,NULL,NULL);

        $chart->setTopLeftPosition('I3');
        $chart->setBottomRightPosition('T24');
        $objPHPExcel->getActiveSheet()->addChart($chart);

        $filename = "Part Chart". "-" . date("Y/m/d").$partno . ".xlsx";
        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . trim($filename) . '"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->setIncludeCharts(true);
        $objWriter->save('php://output');
    }

    function export_inline($part, $spek,$date_from,$date_to){
        $data = $this->part_chart_m->get_data_inline($part,$spek,$date_from,$date_to);
        $margin = $this->part_chart_m->get_margin_inline($part,$spek);
        $spek_name = $this->part_chart_m->get_param_name($spek)->CHR_PARAMETER;
        // EA is Excel Aplication
        $objPHPExcel  = new PHPExcel();  

        // Set properties
        $objPHPExcel->getProperties()->setCreator(trim($this->session->userdata('USERNAME')));
        $objPHPExcel->getProperties()->setLastModifiedBy(trim($this->session->userdata('USERNAME')));

        // Set Active Sheet
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setTitle('Data');

        // Set Header
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(9);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
        $objPHPExcel->getActiveSheet()->mergeCells('A1:E1');
        $objPHPExcel->getActiveSheet()->setCellValue('A1', ''.$part.' - '.$spek_name);
        $objPHPExcel->getActiveSheet()->setCellValue('A2', 'No');
        $objPHPExcel->getActiveSheet()->setCellValue('B2', 'Nilai');
        $objPHPExcel->getActiveSheet()->setCellValue('C2', 'Margin Atas');
        $objPHPExcel->getActiveSheet()->setCellValue('D2', 'Margin Bawah');
        $objPHPExcel->getActiveSheet()->setCellValue('E2', 'Tanggal');

        // Set Data
        $baris =3;
        foreach ($data as $row) {
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$baris, ($baris-2));
            //$objPHPExcel->getActiveSheet()->getStyle("K".$baris)->applyFromArray($style);
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$baris, $row->DEC_NILAI);
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$baris, $margin->DEC_STD_MAX);
            $objPHPExcel->getActiveSheet()->setCellValue('D'.$baris, $margin->DEC_STD_MIN);
            $objPHPExcel->getActiveSheet()->setCellValue('E'.$baris, $row->CHR_DATE_CREATE);
            $baris = $baris +1;
        }
        // for($i=0;$i<30;$i++)
        // {            
        //     $objPHPExcel->getActiveSheet()->setCellValue('C'.($i+3), $margin->DEC_STD_MAX); //Margin Atas
        //     //$objPHPExcel->getActiveSheet()->getStyle("K".$baris)->applyFromArray($style);
        //     $objPHPExcel->getActiveSheet()->setCellValue('D'.($i+3), $margin->DEC_STD_MIN); //Margin Bawah
        //     //$objPHPExcel->getActiveSheet()->getStyle("L".$baris)->applyFromArray($style);
        // }

        //Data Series Label
        $dsl=array(
            new PHPExcel_Chart_DataSeriesValues('String', "'Data'".'!B2', NULL, 1),
            new PHPExcel_Chart_DataSeriesValues('String', "'Data'".'!C2', NULL, 1),
            new PHPExcel_Chart_DataSeriesValues('String', "'Data'".'!D2', NULL, 1),
        );
          //  $dsl='Nilai';

        // Data Nilai X
        $xal=array(
            new PHPExcel_Chart_DataSeriesValues('String', "'Data'"."!A3:A18", NULL, 16),
        );

        // Nilai yang akan dipakai ke array
        $dsv=array(
            new PHPExcel_Chart_DataSeriesValues('Number', "'Data'"."!B3:B18", NULL, 16),
            new PHPExcel_Chart_DataSeriesValues('Number', "'Data'"."!C3:C18", NULL, 16),
            new PHPExcel_Chart_DataSeriesValues('Number', "'Data'"."!D3:D18", NULL, 16),
        );
        echo count($dsv);

        // new PHPExcel_Chart_DataSeriesValues('Number', 'C2:C32', NULL, 30),
            // new PHPExcel_Chart_DataSeriesValues('Number', 'D2:D32', NULL, 30),
        // Data Series Value
        $ds=new PHPExcel_Chart_DataSeries(
            PHPExcel_Chart_DataSeries::TYPE_LINECHART,PHPExcel_Chart_DataSeries::GROUPING_STANDARD,range(0, 2),$dsl,$xal,$dsv
        );

        // Plot Area and Legend
        $pa=new PHPExcel_Chart_PlotArea(NULL, array($ds));
        $legend=new PHPExcel_Chart_Legend(PHPExcel_Chart_Legend::POSITION_RIGHT, NULL, false);
        $title=new PHPExcel_Chart_Title('Part Chart');

        // Set Chart
        $chart= new PHPExcel_Chart('chart1',$title,$legend,$pa,true,0,NULL,NULL);

        $chart->setTopLeftPosition('I3');
        $chart->setBottomRightPosition('T24');
        $objPHPExcel->getActiveSheet()->addChart($chart);

        $filename = "QCWIS Chart". "-" . date("Y/m/d").$part . ".xlsx";
        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . trim($filename) . '"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->setIncludeCharts(true);
        $objWriter->save('php://output');
    }

    //===== FUNCTION IN LINE MEASUREMENT - BY ANU 20191002 =====//
    function get_chart_new()
    {
        $selected_part = $this->input->post('CHR_PART_ID');
        $selected_spek = $this->input->post('CHR_PARAM');  
        If ($this->input->post("Search") == 1) {
            $date_from = date("Ymd", strtotime($this->input->post("CHR_DATE_FROM")));
            $date_to = date("Ymd", strtotime($this->input->post("CHR_DATE_TO")));
        } else {
            $date_from = date("Ymd");
            $date_to = date("Ymd");
        }
        // $prod_no = '';
        // $prod_no = $this->input->post('CHR_PRD_ORDER_NO');          

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(299);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Part Chart - In Line';
        $data['list_part'] = $this->part_chart_m->get_part_inline();
        $data['list_param'] = $this->part_chart_m->get_param($selected_part);
        $data['selected_part'] = $selected_part;
        $data['selected_spek'] = $selected_spek;
        $data['date_from'] = $date_from;
        $data['date_to'] = $date_to;
        // if($selected_part == '' && $selected_spek == ''){
        //     $selected_part = '';
        //     $selected_spek = '';
        //     $prod_no = '';
        //     $data['data']= $this->part_chart_m->get_data_inline(0,0,0);
        //     $data['margin'] = $this->part_chart_m->get_margin_inline(0,0,0);
        // } else {
        //     $selected_part = $selected_part;
        //     $selected_spek = $selected_spek;
        //     $prod_no = $prod_no;
            // $data['list_spek'] = $this->part_chart_m->get_spek_inline($selected_part);
            $data['data']= $this->part_chart_m->get_data_inline($selected_part, $selected_spek,$date_from,$date_to);
            $data['margin'] = $this->part_chart_m->get_margin_inline($selected_part, $selected_spek);
            $data['dt_max']= $this->part_chart_m->get_data_max($selected_part, $selected_spek,$date_from,$date_to);
            $data['dt_min']= $this->part_chart_m->get_data_min($selected_part, $selected_spek,$date_from,$date_to);
        // }
                
        // $data['prod_no'] = $this->part_chart_m->get_prod_no_exist($selected_part, $selected_spek);;
        $data['msg'] = NULL;       
        
        $data['content'] = 'patricia/part_chart/part_chart_inline_v';
        $this->load->view($this->layout, $data);
    }

    
    function get_prod_order_by_partno(){
        $part_no_comp = $this->input->post("CHR_COMPONENT_ID");
        // $spek = $this->input->post("CHR_SPEK");
        $spek = '';

        $list_prd_order = $this->part_chart_m->get_prod_order($part_no_comp, $spek);

        $data = '';

        foreach ($list_prd_order as $row) {             
            $data .="<option value='$row->CHR_PRD_ORDER_NO'>".$row->CHR_PRD_ORDER_NO."</option>";
        }
       
        $json_data = array('data' => $data);

        echo json_encode($json_data);
    }
    
}
?>