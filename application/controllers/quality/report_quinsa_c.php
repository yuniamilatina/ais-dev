<?php

class report_quinsa_c extends CI_Controller
{

    private $layout = '/template/head';
    private $layout_blank = '/template/head_blank';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('raw_material/raw_material_sto_m');
        $this->load->model('raw_material/good_movement_m');
        $this->load->model('prd/direct_backflush_general_m');
        $this->load->model('quality/report_quinsa_m');
    }

    public function index()
    {
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(142);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Report QCWIS';

        $date = date('Y') . date('m');
        $data['selected_date'] = $date;
        $data_work_center = $this->direct_backflush_general_m->get_all_work_center();
        $data['all_work_centers'] = $data_work_center;
        $work_center = $this->direct_backflush_general_m->get_top_work_center();
        $data['wc'] = $work_center;
        $allpartno = $this->raw_material_sto_m->get_partno_by_wc($work_center);
        $data['partno'] = $allpartno;
        $item_cek = $this->raw_material_sto_m->get_item_cek($work_center, $allpartno);
        $data['item'] = $item_cek;
        // $data['partno'] = $partno;
        // $data['item'] = $item;

        $data['data_all'] = $this->raw_material_sto_m->select_data_all_by_date_dept($date, $work_center, $allpartno, $item_cek);
        $data['data_range'] = $this->raw_material_sto_m->select_data_range_by_date_dept($date, $work_center, $allpartno, $item_cek);
        $data['data_max'] = $this->raw_material_sto_m->select_data_max_by_date_dept($date, $work_center, $allpartno, $item_cek);
        $data['data_min'] = $this->raw_material_sto_m->select_data_min_by_date_dept($date, $work_center, $allpartno, $item_cek);
        $data['data_ok'] = $this->raw_material_sto_m->select_data_ok_by_date_dept($date, $work_center, $allpartno, $item_cek);
        $data['data_yes'] = $this->raw_material_sto_m->select_data_yes_by_date_dept($date, $work_center, $allpartno, $item_cek);
        $data['content'] = 'raw_material/report_scan_raw_material_sto_v';
        $this->load->view($this->layout, $data);
    }

    public function search_qcwis($date = '', $wc = '', $partno = '', $item = '')
    {
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(142);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Report QCWIS';

        $data_work_center = $this->direct_backflush_general_m->get_all_work_center();
        $data['all_work_centers'] = $data_work_center;
        $work_center = $this->direct_backflush_general_m->get_top_work_center();
        $data['work_center'] = $work_center;
        $allpartno = $this->raw_material_sto_m->get_partno_by_wc($wc);
        $data['allpartno'] = $allpartno;
        $item_cek = $this->raw_material_sto_m->get_item_cek($wc, $partno);
        $data['all_item_cek'] = $item_cek;
        $data['selected_date'] = $date;
        $data['wc'] = $wc;
        $data['partno'] = $partno;
        $data['item'] = $item;

        $data['data_all'] = $this->raw_material_sto_m->select_data_all_by_date_dept($date, $wc, $partno, $item);
        $data['data_range'] = $this->raw_material_sto_m->select_data_range_by_date_dept($date, $wc, $partno, $item);
        $data['data_max'] = $this->raw_material_sto_m->select_data_max_by_date_dept($date, $wc, $partno, $item);
        $data['data_min'] = $this->raw_material_sto_m->select_data_min_by_date_dept($date, $wc, $partno, $item);
        $data['data_ok'] = $this->raw_material_sto_m->select_data_ok_by_date_dept($date, $wc, $partno, $item);
        $data['data_yes'] = $this->raw_material_sto_m->select_data_yes_by_date_dept($date, $wc, $partno, $item);
        $data['content'] = 'raw_material/report_scan_raw_material_sto_v';
        $this->load->view($this->layout, $data);
    }

    public function report_qcwis_new()
    {
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(142);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Report QCWIS';

        $date = date('Y') . date('m');
        $data['selected_date'] = $date;
        $data_work_center = $this->direct_backflush_general_m->get_all_work_center();
        $data['all_work_centers'] = $data_work_center;
        $work_center = $this->direct_backflush_general_m->get_top_work_center();
        $data['wc'] = $work_center;
        $allpartno = $this->raw_material_sto_m->get_partno_by_wc($work_center);
        $data['partno'] = $allpartno;
        $item_cek = $this->raw_material_sto_m->get_item_cek($work_center, $allpartno);
        $data['item'] = $item_cek;
        // $data['partno'] = $partno;
        // $data['item'] = $item;

        $data['data_all'] = $this->raw_material_sto_m->select_data_all_by_date_dept($date, $work_center, $allpartno, $item_cek);
        $data['data_range'] = $this->raw_material_sto_m->select_data_range_by_date_dept($date, $work_center, $allpartno, $item_cek);
        $data['data_max'] = $this->raw_material_sto_m->select_data_max_by_date_dept($date, $work_center, $allpartno, $item_cek);
        $data['data_min'] = $this->raw_material_sto_m->select_data_min_by_date_dept($date, $work_center, $allpartno, $item_cek);
        $data['data_ok'] = $this->raw_material_sto_m->select_data_ok_by_date_dept($date, $work_center, $allpartno, $item_cek);
        $data['data_yes'] = $this->raw_material_sto_m->select_data_yes_by_date_dept($date, $work_center, $allpartno, $item_cek);
        $data['content'] = 'raw_material/report_scan_raw_material_sto_v';
        $this->load->view($this->layout, $data);
    }

    function get_range($date, $wc, $partno, $item)
    {
        $data['data_range'] = $this->raw_material_sto_m->select_data_range_by_date_dept($date, $wc, $partno, $item);
        $get_line = $this->raw_material_sto_m->get_data_range_by_row($date, $wc, $partno, $item);
        $uom = trim($get_line->CHR_UOM_SL);
        $data['uom'] = $uom;
        $stra = trim($get_line->CHR_STRATEGY);
        $data['stra'] = $stra;
        $lot = trim($get_line->CHR_LOT_NOMOR);
        $data['lot'] = $lot;

        $lsl = trim($get_line->CHR_LSL);
        $data['lsl'] = $lsl;
        $lsl_lim = $lsl - 0.3;
        $data['lsl_lim'] = $lsl_lim;

        $usl = trim($get_line->CHR_USL);
        $data['usl'] = $usl;
        $usl_lim = $usl + 0.3;
        $data['usl_lim'] = $usl_lim;
        
        $tsl = trim($get_line->CHR_TARGET_SL);
        $data['tsl'] = $tsl;
        $rsl = trim($get_line->CHR_RANGE_SL);
        $data['upp'] = $tsl + $rsl;
        $data['low'] = $tsl - $rsl;

        $data['content'] = 'raw_material/report_range_qcwis';
        $this->load->view($this->layout_blank, $data);
    }

    function get_max($date, $wc, $partno, $item)
    {
        $data['data_max'] = $this->raw_material_sto_m->select_data_max_by_date_dept($date, $wc, $partno, $item);
        $get_line = $this->raw_material_sto_m->get_data_max_by_row($date, $wc, $partno, $item);
        $uom = trim($get_line->CHR_UOM_SL);
        $data['uom'] = $uom;
        $stra = trim($get_line->CHR_STRATEGY);
        $data['stra'] = $stra;
        $lot = trim($get_line->CHR_LOT_NOMOR);
        $data['lot'] = $lot;
        $lsl = trim($get_line->CHR_LSL);
        $data['lsl'] = $lsl;
        $usl = trim($get_line->CHR_USL);
        $data['usl'] = $usl;
        $usl_lim = $usl + 2.3;
        $data['usl_lim'] = $usl_lim;
        $lsl_lim = $usl - 10;
        $data['lsl_lim'] = $lsl_lim;
        $tsl = trim($get_line->CHR_TARGET_SL);
        $data['tsl'] = $tsl;
        $rsl = trim($get_line->CHR_RANGE_SL);
        $data['upp'] = $tsl + $rsl;
        $data['low'] = $tsl - $rsl;

        $data['content'] = 'raw_material/report_max_qcwis';
        $this->load->view($this->layout_blank, $data);
    }

    function get_min($date, $wc, $partno, $item)
    {
        $data['data_min'] = $this->raw_material_sto_m->select_data_min_by_date_dept($date, $wc, $partno, $item);
        $get_line = $this->raw_material_sto_m->get_data_min_by_row($date, $wc, $partno, $item);
        $uom = trim($get_line->CHR_UOM_SL);
        $data['uom'] = $uom;
        $stra = trim($get_line->CHR_STRATEGY);
        $data['stra'] = $stra;
        $lot = trim($get_line->CHR_LOT_NOMOR);
        $data['lot'] = $lot;
        $lsl = trim($get_line->CHR_LSL);
        $data['lsl'] = $lsl;
        $lsl_lim = $lsl - 2.3;
        $data['lsl_lim'] = $lsl_lim;
        $usl_lim = $lsl + 10;
        $data['usl_lim'] = $usl_lim;
        $usl = trim($get_line->CHR_USL);
        $data['usl'] = $usl;
        $tsl = trim($get_line->CHR_TARGET_SL);
        $data['tsl'] = $tsl;
        $rsl = trim($get_line->CHR_RANGE_SL);
        $data['upp'] = $tsl + $rsl;
        $data['low'] = $tsl - $rsl;

        $data['content'] = 'raw_material/report_min_qcwis';
        $this->load->view($this->layout_blank, $data);
    }

    function get_ok($date, $wc, $partno, $item)
    {
        $data['data_ok'] = $this->raw_material_sto_m->select_data_ok_by_date_dept($date, $wc, $partno, $item);

        $data['content'] = 'raw_material/report_ok_qcwis';
        $this->load->view($this->layout_blank, $data);
    }

    function get_yes($date, $wc, $partno, $item)
    {
        $data['data_yes'] = $this->raw_material_sto_m->select_data_yes_by_date_dept($date, $wc, $partno, $item);

        $data['content'] = 'raw_material/report_yes_qcwis';
        $this->load->view($this->layout_blank, $data);
    }

    function export_detail_report_quinsa() {  
        $this->load->library('excel');        
        
        $wc = $this->input->post("WORK_CENTER");
        $periode = $this->input->post("PERIODE");
        $partno = $this->input->post("PART_NO");
        $item = $this->input->post("ITEM_CHECK");
        
        $quinsa_data = $this->raw_material_sto_m->select_data_all_by_date_dept($periode, $wc, $partno, $item);

        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

        // Set Properties
        $objPHPExcel->getProperties()->setCreator(trim($this->session->userdata('USERNAME')));
        $objPHPExcel->getProperties()->setLastModifiedBy(trim($this->session->userdata('USERNAME')));
        $objPHPExcel->getProperties()->setTitle("REPORT QUINSA");
        $objPHPExcel->getProperties()->setSubject("REPORT QUINSA");
        $objPHPExcel->getProperties()->setDescription("REPORT QUINSA");
                
        //Header TR
        $objPHPExcel->getActiveSheet()->setCellValue('A2', 'NO');        
        $objPHPExcel->getActiveSheet()->setCellValue('B2', 'WORK CENTER');
        $objPHPExcel->getActiveSheet()->setCellValue('C2', 'PART NO');
        $objPHPExcel->getActiveSheet()->setCellValue('D2', 'PART NAME');
        $objPHPExcel->getActiveSheet()->setCellValue('E2', 'MODEL');     
        $objPHPExcel->getActiveSheet()->setCellValue('F2', 'INSP. MASTER DOC');
        $objPHPExcel->getActiveSheet()->setCellValue('G2', 'INSP. AREA');
        $objPHPExcel->getActiveSheet()->setCellValue('H2', 'EXECUTE BY');
        $objPHPExcel->getActiveSheet()->setCellValue('I2', 'ID CHECK');
        $objPHPExcel->getActiveSheet()->setCellValue('J2', 'INSP. NAME');
        $objPHPExcel->getActiveSheet()->setCellValue('K2', 'INSP. TYPE');
        $objPHPExcel->getActiveSheet()->setCellValue('L2', 'SPECIAL CHAR');
        $objPHPExcel->getActiveSheet()->setCellValue('M2', 'CONTROL TYPE');
        $objPHPExcel->getActiveSheet()->setCellValue('N2', 'SAMPLING');
        $objPHPExcel->getActiveSheet()->setCellValue('O2', 'ID INSP. DOC');
        $objPHPExcel->getActiveSheet()->setCellValue('P2', 'LOT NUMBER');
        $objPHPExcel->getActiveSheet()->setCellValue('Q2', 'FIRST/LAST');
        $objPHPExcel->getActiveSheet()->setCellValue('R2', 'REPETITION');
        $objPHPExcel->getActiveSheet()->setCellValue('S2', 'SPECIFICATION LIMIT (SL)');
        $objPHPExcel->getActiveSheet()->setCellValue('X2', 'CONTROL LIMIT (CL)');
        $objPHPExcel->getActiveSheet()->setCellValue('AC2', 'RESULT');
        $objPHPExcel->getActiveSheet()->setCellValue('AD2', 'STATUS');
        $objPHPExcel->getActiveSheet()->setCellValue('AE2', 'REMARK');
        
        $objPHPExcel->getActiveSheet()->getStyle("A2:AE2")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        $objPHPExcel->getActiveSheet()->mergeCells('A2:A3');
        $objPHPExcel->getActiveSheet()->mergeCells('B2:B3');
        $objPHPExcel->getActiveSheet()->mergeCells('C2:C3');
        $objPHPExcel->getActiveSheet()->mergeCells('D2:D3');
        $objPHPExcel->getActiveSheet()->mergeCells('E2:E3');
        $objPHPExcel->getActiveSheet()->mergeCells('F2:F3');
        $objPHPExcel->getActiveSheet()->mergeCells('G2:G3');
        $objPHPExcel->getActiveSheet()->mergeCells('H2:H3');
        $objPHPExcel->getActiveSheet()->mergeCells('I2:I3');
        $objPHPExcel->getActiveSheet()->mergeCells('J2:J3');
        $objPHPExcel->getActiveSheet()->mergeCells('K2:K3');
        $objPHPExcel->getActiveSheet()->mergeCells('L2:L3');
        $objPHPExcel->getActiveSheet()->mergeCells('M2:M3');
        $objPHPExcel->getActiveSheet()->mergeCells('N2:N3');
        $objPHPExcel->getActiveSheet()->mergeCells('O2:O3');
        $objPHPExcel->getActiveSheet()->mergeCells('P2:P3');
        $objPHPExcel->getActiveSheet()->mergeCells('Q2:Q3');
        $objPHPExcel->getActiveSheet()->mergeCells('R2:R3');
        $objPHPExcel->getActiveSheet()->mergeCells('S2:W2');
        $objPHPExcel->getActiveSheet()->mergeCells('X2:AB2');
        $objPHPExcel->getActiveSheet()->mergeCells('AC2:AC2');
        $objPHPExcel->getActiveSheet()->mergeCells('AD2:AD2');
        $objPHPExcel->getActiveSheet()->mergeCells('AE2:AE2');
        
        $objPHPExcel->getActiveSheet()->setCellValue('S3', 'TARGET');        
        $objPHPExcel->getActiveSheet()->setCellValue('T3', 'RANGE');
        $objPHPExcel->getActiveSheet()->setCellValue('U3', 'LSL');
        $objPHPExcel->getActiveSheet()->setCellValue('V3', 'USL');
        $objPHPExcel->getActiveSheet()->setCellValue('W3', 'UoM SL');
        
        $objPHPExcel->getActiveSheet()->setCellValue('X3', 'TARGET');
        $objPHPExcel->getActiveSheet()->setCellValue('Y3', 'RANGE');
        $objPHPExcel->getActiveSheet()->setCellValue('Z3', 'LCL');
        $objPHPExcel->getActiveSheet()->setCellValue('AA3', 'UCL');
        $objPHPExcel->getActiveSheet()->setCellValue('AB3', 'UoM CL');
        
        $objPHPExcel->getActiveSheet()->getStyle("A2:AE3")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A2:AE3')->getFont()->setBold(true)->setSize(12);
        
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(6); $objPHPExcel->getActiveSheet()->getColumnDimension('AA')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10); $objPHPExcel->getActiveSheet()->getColumnDimension('AB')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20); $objPHPExcel->getActiveSheet()->getColumnDimension('AC')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20); $objPHPExcel->getActiveSheet()->getColumnDimension('AD')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15); $objPHPExcel->getActiveSheet()->getColumnDimension('AE')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15); $objPHPExcel->getActiveSheet()->getColumnDimension('AF')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15); $objPHPExcel->getActiveSheet()->getColumnDimension('AG')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15); $objPHPExcel->getActiveSheet()->getColumnDimension('AH')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15); $objPHPExcel->getActiveSheet()->getColumnDimension('AI')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(15); $objPHPExcel->getActiveSheet()->getColumnDimension('AJ')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(15); $objPHPExcel->getActiveSheet()->getColumnDimension('AK')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(15); $objPHPExcel->getActiveSheet()->getColumnDimension('AL')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(15); $objPHPExcel->getActiveSheet()->getColumnDimension('AM')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(15); $objPHPExcel->getActiveSheet()->getColumnDimension('AN')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(15); $objPHPExcel->getActiveSheet()->getColumnDimension('AO')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(15); $objPHPExcel->getActiveSheet()->getColumnDimension('AP')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(15); $objPHPExcel->getActiveSheet()->getColumnDimension('AQ')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(15); $objPHPExcel->getActiveSheet()->getColumnDimension('AR')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(15); $objPHPExcel->getActiveSheet()->getColumnDimension('AS')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('T')->setWidth(15); $objPHPExcel->getActiveSheet()->getColumnDimension('AT')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('U')->setWidth(15); $objPHPExcel->getActiveSheet()->getColumnDimension('AU')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('V')->setWidth(15); $objPHPExcel->getActiveSheet()->getColumnDimension('AV')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('W')->setWidth(15); $objPHPExcel->getActiveSheet()->getColumnDimension('AW')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('X')->setWidth(15); $objPHPExcel->getActiveSheet()->getColumnDimension('AX')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('Y')->setWidth(15); $objPHPExcel->getActiveSheet()->getColumnDimension('AY')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('Z')->setWidth(15); $objPHPExcel->getActiveSheet()->getColumnDimension('AZ')->setWidth(15);
        
        //Value of All Cells
        $i = 4;
        $no = 1;
        foreach($quinsa_data as $data){
            
            //Insert Value to Excel Column
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$i, $no);
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$i, $data->CHR_WORK_CTR);
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$i, $data->CHR_PARTNO);
            $objPHPExcel->getActiveSheet()->setCellValue('D'.$i, $data->CHR_PART_NM);
            $objPHPExcel->getActiveSheet()->setCellValue('E'.$i, $data->CHR_MODEL_NM);
            $objPHPExcel->getActiveSheet()->setCellValue('F'.$i, $data->CHR_REF_MASTER);        
            $objPHPExcel->getActiveSheet()->setCellValue('G'.$i, $data->CHR_INSPEC_TYPE);
            $objPHPExcel->getActiveSheet()->setCellValue('H'.$i, $data->CHR_EXEC_BY);
            $objPHPExcel->getActiveSheet()->setCellValue('I'.$i, $data->CHR_SEQ);
            $objPHPExcel->getActiveSheet()->setCellValue('J'.$i, $data->CHR_CHECK_POINT);
            $objPHPExcel->getActiveSheet()->setCellValue('K'.$i, $data->CHR_TYPE);        
            $objPHPExcel->getActiveSheet()->setCellValue('L'.$i, $data->CHR_SPECIAL_CHAR);
            $objPHPExcel->getActiveSheet()->setCellValue('M'.$i, $data->CHR_CONTROL);
            $objPHPExcel->getActiveSheet()->setCellValue('N'.$i, $data->CHR_SAMPLING);
            $objPHPExcel->getActiveSheet()->setCellValue('O'.$i, $data->CHR_DOC_ID);
            $objPHPExcel->getActiveSheet()->setCellValue('P'.$i, $data->CHR_LOT_NOMOR);        
            $objPHPExcel->getActiveSheet()->setCellValue('Q'.$i, $data->CHR_STRATEGY);
            $objPHPExcel->getActiveSheet()->setCellValue('R'.$i, $data->CHR_REPETITION);
            $objPHPExcel->getActiveSheet()->setCellValue('S'.$i, $data->CHR_TARGET_SL);
            $objPHPExcel->getActiveSheet()->setCellValue('T'.$i, $data->CHR_RANGE_SL);
            $objPHPExcel->getActiveSheet()->setCellValue('U'.$i, $data->CHR_LSL);        
            $objPHPExcel->getActiveSheet()->setCellValue('V'.$i, $data->CHR_USL);
            $objPHPExcel->getActiveSheet()->setCellValue('W'.$i, $data->CHR_UOM_SL);
            $objPHPExcel->getActiveSheet()->setCellValue('X'.$i, $data->CHR_TARGET_CL);
            $objPHPExcel->getActiveSheet()->setCellValue('Y'.$i, $data->CHR_RANGE_CL);
            $objPHPExcel->getActiveSheet()->setCellValue('Z'.$i, $data->CHR_LCL);        
            $objPHPExcel->getActiveSheet()->setCellValue('AA'.$i, $data->CHR_UCL);
            $objPHPExcel->getActiveSheet()->setCellValue('AB'.$i, $data->CHR_UOM_CL);
            $objPHPExcel->getActiveSheet()->setCellValue('AC'.$i, $data->CHR_RESULT);
            $objPHPExcel->getActiveSheet()->setCellValue('AD'.$i, $data->CHR_STATUS);
            $objPHPExcel->getActiveSheet()->setCellValue('AE'.$i, $data->CHR_REMARK);  
            
            $objPHPExcel->getActiveSheet()->getStyle("A".$i.":AE".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $i++;
            $no++;
        }

        $styleArray = array(
            'borders' => array(
                'allborders' => array(
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
        
        $styleArray3 = array(
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('argb' => 'CCCCCC')
            )
        );
        
        $objPHPExcel->getActiveSheet()->getStyle("A2:AE3")->applyFromArray($styleArray2);
        $objPHPExcel->getActiveSheet()->getStyle("A2:AE$i")->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->getStyle("A2:AE3")->getFont()->setBold(true);
        
        
        $filename = "Report QUINSA ". $wc ." for " . $partno . " " . $periode . ".xls";
        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . trim($filename) . '"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->setIncludeCharts(TRUE);
        $objWriter->save('php://output');
    }

    public function approval_qcwis()
    {
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(355);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Approval QCWIS';

        $date = date('Ymd');
        $data['selected_date'] = $date;
        $data_work_center = $this->direct_backflush_general_m->get_all_work_center();
        $data['all_work_centers'] = $data_work_center;
        $work_center = $this->direct_backflush_general_m->get_top_work_center();
        $data['wc'] = $work_center;
        $data['partno'] = NULL;
        $data_qcwis = NULL;
        $data['data_qcwis'] = $data_qcwis;
        $data['approve'] = NULL;

        $data['data_all'] = NULL;
        
        $data['content'] = 'quality/quinsa/approval_qcwis_v';
        $this->load->view($this->layout, $data);
    }

    public function search_approval_qcwis()
    {
        $date = $this->input->post("date_from");
        $date = substr($date,6,4) . substr($date,3,2) . substr($date,0,2); 
        $work_center = $this->input->post("wcenter");
        $partno = $this->input->post("partno");
        
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(355);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Approval QCWIS';

        $data['selected_date'] = $date;
        $data_work_center = $this->direct_backflush_general_m->get_all_work_center();
        $data['all_work_centers'] = $data_work_center;
        $allpartno = $this->report_quinsa_m->get_list_partno_by_wc($work_center, $date);
        $data['allpartno'] = $allpartno->result();
        $data['wc'] = $work_center;
        $data['partno'] = $partno;
        $data_qcwis = $this->report_quinsa_m->get_data_qcwis_by_hourly($work_center, $date, $partno);
        $data['data_qcwis'] = $data_qcwis;
        $get_approve = $this->report_quinsa_m->check_approval_daily($work_center, $date, $partno);
        $data['approve'] = $get_approve;

        $data['data_all'] = $data['data_all'] = $this->report_quinsa_m->select_data_all_by_date_and_partno($date, $work_center, $partno);
        
        $data['content'] = 'quality/quinsa/approval_qcwis_v';
        $this->load->view($this->layout, $data);
    }

    function get_partno_by_wc(){
        $date = $this->input->post("date");
        $date = substr($date,6,4) . substr($date,3,2) . substr($date,0,2);        
        $wcenter = trim($this->input->post("wcenter"));

        $partno = $this->report_quinsa_m->get_list_partno_by_wc($wcenter, $date);

        $data = '';
        if($partno->num_rows() > 0){
            foreach ($partno->result() as $row) { 
                $data .="<option value='" . trim($row->CHR_PARTNO) . "'>" . trim($row->CHR_PARTNO) . ' - ' . trim($row->CHR_BACK_NO) . "</option>";
            }
        }       

        echo json_encode($data);
    }

    function get_chart_qcwis($date, $wc, $partno)
    {   
        $data['title'] = 'Chart QCWIS';
        $data['part_no'] = $partno;
        $data_qcwis = $this->report_quinsa_m->get_data_qcwis_by_hourly($wc, $date, $partno);
        $data['data_qcwis'] = $data_qcwis;

        $data['content'] = 'quality/quinsa/chart_qcwis_v';
        $this->load->view($this->layout_blank, $data);
    }

    public function approval_qcwis_by_date()
    {
        $session = $this->session->all_userdata();
        $npk = $session['npk'];
        $date_now = date('Ymd');
        $time_now = date('His');

        $date = $this->input->post("CHR_DATE");
        $work_center = $this->input->post("CHR_WORK_CENTER");
        $partno = $this->input->post("CHR_PART_NO");

        $this->report_quinsa_m->approve_qcwis_by_date($date, $work_center, $partno, $npk, $date_now, $time_now);
        
        redirect('quality/report_quinsa_c/approval_qcwis/', 'refresh');
    }
}
