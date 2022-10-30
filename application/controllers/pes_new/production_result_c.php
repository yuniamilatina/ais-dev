<?php

class production_result_c extends CI_Controller
{
    /* -- define constructor -- */

    private $layout = '/template/head';
    private $layout_blank = '/template/head_blank';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('prd/group_line_m');
        $this->load->model('pes_new/production_result_m');
        $this->load->model('pes/production_activity_m');
        $this->load->model('prd/direct_backflush_general_m');
    }

    public function report_prod_result($date = '', $id_product_group = '')
    {

        $data['title'] = 'Report Productivity';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(93);
        $data['news'] = $this->news_m->get_news();
        $data['content'] = 'pes_new/report_production_result_by_group_and_period_v.php';

        if ($date == '' || $date == NULL) {
            $date = date('Y') . date('m');
        }

        if ($id_product_group == '' || $id_product_group == NULL) {
            $id_product_group = 1;
        }

        $data['data_production_result'] = $this->production_result_m->get_data_pivot_production_result_by_period_and_group($date, $id_product_group);

        $data['all_product_group'] = $this->group_line_m->get_all_prod_group_product_custom();
        $data['id_product_group'] = $id_product_group;
        $data['selected_date'] = $date;

        $data['first_sunday'] = $this->firstSunday(substr($date, 0, 4) . '-' . substr($date, 4, 2));
        $data['first_saturday'] = $this->firstSaturday(substr($date, 0, 4) . '-' . substr($date, 4, 2));

        $this->load->view($this->layout, $data);
    }

    public function report_performance_production($date = '')
    {
        $data['title'] = 'Report Ratio RIL';
        $data['content'] = 'pes_new/report_performance_prd_v.php';
        $data['monthly'] = '';

        if ($date == '' || $date == NULL) {
            $date = date('Y') . date('m');
        }

        $data['data'] = $this->production_result_m->get_performance_production($date);
        $data['selected_date'] = $date;

        $this->load->view($this->layout_blank, $data);
    }

    public function download_report_prod_result()
    {
        $this->load->library('excel');

        $date = $this->input->post('CHR_DATE_SELECTED');
        $id_product_group = $this->input->post('INT_GROUP_PROD');

        $data_line_stop_machine_by_period = $this->production_result_m->get_data_pivot_production_result_by_period_and_group($date, $id_product_group);

        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

        // Set properties
        $objPHPExcel->getProperties()->setCreator(trim('AIS - Report Production Result'));
        $objPHPExcel->getProperties()->setLastModifiedBy(trim($this->session->userdata('USERNAME')));
        $objPHPExcel->getProperties()->setTitle("Report Production Result");
        $objPHPExcel->getProperties()->setSubject("Report Production Result");
        $objPHPExcel->getProperties()->setDescription("Report Production Result");
        // Set Properties

        //SETUP EXCEL
        $width = 14;
        $objPHPExcel->setActiveSheetIndex();
        $worksheet = $objPHPExcel->getActiveSheet();
        $worksheet->setTitle($date); //sheetname

        //HEADER
        $worksheet->setCellValue('A1', trim($date));

        //TABLE PRODUCTION QTY
        $worksheet->setCellValue('A2', 'No.');
        $worksheet->setCellValue('B2', 'Work Center');
        $worksheet->setCellValue('C2', 'Part No');
        $worksheet->setCellValue('D2', 'Back No');
        $worksheet->setCellValue('E2', 'Part Name');

        $worksheet->mergeCells("F2:BN2");
        $worksheet->setCellValue('F2', 'Date');

        $aop = 3;
        $worksheet->mergeCells("F$aop:G$aop");
        $worksheet->mergeCells("H$aop:I$aop");
        $worksheet->mergeCells("J$aop:K$aop");
        $worksheet->mergeCells("L$aop:M$aop");
        $worksheet->mergeCells("N$aop:O$aop");
        $worksheet->mergeCells("P$aop:Q$aop");
        $worksheet->mergeCells("R$aop:S$aop");
        $worksheet->mergeCells("T$aop:U$aop");
        $worksheet->mergeCells("V$aop:W$aop");
        $worksheet->mergeCells("X$aop:Y$aop");
        $worksheet->mergeCells("Z$aop:AA$aop");
        $worksheet->mergeCells("AB$aop:AC$aop");
        $worksheet->mergeCells("AD$aop:AE$aop");
        $worksheet->mergeCells("AF$aop:AG$aop");
        $worksheet->mergeCells("AH$aop:AI$aop");
        $worksheet->mergeCells("AJ$aop:AK$aop");
        $worksheet->mergeCells("AL$aop:AM$aop");
        $worksheet->mergeCells("AN$aop:AO$aop");
        $worksheet->mergeCells("AP$aop:AQ$aop");
        $worksheet->mergeCells("AR$aop:AS$aop");
        $worksheet->mergeCells("AT$aop:AU$aop");
        $worksheet->mergeCells("AV$aop:AW$aop");
        $worksheet->mergeCells("AX$aop:AY$aop");
        $worksheet->mergeCells("AZ$aop:BA$aop");
        $worksheet->mergeCells("BB$aop:BC$aop");
        $worksheet->mergeCells("BD$aop:BE$aop");
        $worksheet->mergeCells("BF$aop:BG$aop");
        $worksheet->mergeCells("BH$aop:BI$aop");
        $worksheet->mergeCells("BJ$aop:BK$aop");
        $worksheet->mergeCells("BL$aop:BM$aop");
        $worksheet->mergeCells("BN$aop:BO$aop");

        $worksheet->setCellValue('F3', '1');
        $worksheet->setCellValue('H3', '2');
        $worksheet->setCellValue('J3', '3');
        $worksheet->setCellValue('L3', '4');
        $worksheet->setCellValue('N3', '5');
        $worksheet->setCellValue('P3', '6');
        $worksheet->setCellValue('R3', '7');
        $worksheet->setCellValue('T3', '8');
        $worksheet->setCellValue('V3', '9');
        $worksheet->setCellValue('X3', '10');
        $worksheet->setCellValue('Z3', '11');
        $worksheet->setCellValue('AB3', '12');
        $worksheet->setCellValue('AD3', '13');
        $worksheet->setCellValue('AF3', '14');
        $worksheet->setCellValue('AH3', '15');
        $worksheet->setCellValue('AJ3', '16');
        $worksheet->setCellValue('AL3', '17');
        $worksheet->setCellValue('AN3', '18');
        $worksheet->setCellValue('AP3', '19');
        $worksheet->setCellValue('AR3', '20');
        $worksheet->setCellValue('AT3', '21');
        $worksheet->setCellValue('AV3', '22');
        $worksheet->setCellValue('AX3', '23');
        $worksheet->setCellValue('AZ3', '24');
        $worksheet->setCellValue('BB3', '25');
        $worksheet->setCellValue('BD3', '26');
        $worksheet->setCellValue('BF3', '27');
        $worksheet->setCellValue('BH3', '28');
        $worksheet->setCellValue('BJ3', '29');
        $worksheet->setCellValue('BL3', '30');
        $worksheet->setCellValue('BN3', '31');

        $worksheet->setCellValue('F4', 'OK');
        $worksheet->setCellValue('G4', 'NG');
        $worksheet->setCellValue('H4', 'OK');
        $worksheet->setCellValue('I4', 'NG');
        $worksheet->setCellValue('J4', 'OK');
        $worksheet->setCellValue('K4', 'NG');
        $worksheet->setCellValue('L4', 'OK');
        $worksheet->setCellValue('M4', 'NG');
        $worksheet->setCellValue('N4', 'OK');
        $worksheet->setCellValue('O4', 'NG');
        $worksheet->setCellValue('P4', 'OK');
        $worksheet->setCellValue('Q4', 'NG');
        $worksheet->setCellValue('R4', 'OK');
        $worksheet->setCellValue('S4', 'NG');
        $worksheet->setCellValue('T4', 'OK');
        $worksheet->setCellValue('U4', 'NG');
        $worksheet->setCellValue('V4', 'OK');
        $worksheet->setCellValue('W4', 'NG');
        $worksheet->setCellValue('X4', 'OK');
        $worksheet->setCellValue('Y4', 'NG');

        $worksheet->setCellValue('Z4', 'OK');
        $worksheet->setCellValue('AA4', 'NG');
        $worksheet->setCellValue('AB4', 'OK');
        $worksheet->setCellValue('AC4', 'NG');
        $worksheet->setCellValue('AD4', 'OK');
        $worksheet->setCellValue('AE4', 'NG');
        $worksheet->setCellValue('AF4', 'OK');
        $worksheet->setCellValue('AG4', 'NG');
        $worksheet->setCellValue('AH4', 'OK');
        $worksheet->setCellValue('AI4', 'NG');
        $worksheet->setCellValue('AJ4', 'OK');
        $worksheet->setCellValue('AK4', 'NG');
        $worksheet->setCellValue('AL4', 'OK');
        $worksheet->setCellValue('AM4', 'NG');
        $worksheet->setCellValue('AN4', 'OK');
        $worksheet->setCellValue('AO4', 'NG');
        $worksheet->setCellValue('AP4', 'OK');
        $worksheet->setCellValue('AQ4', 'NG');
        $worksheet->setCellValue('AR4', 'OK');
        $worksheet->setCellValue('AS4', 'NG');

        $worksheet->setCellValue('AT4', 'OK');
        $worksheet->setCellValue('AU4', 'NG');
        $worksheet->setCellValue('AV4', 'OK');
        $worksheet->setCellValue('AW4', 'NG');
        $worksheet->setCellValue('AX4', 'OK');
        $worksheet->setCellValue('AY4', 'NG');
        $worksheet->setCellValue('AZ4', 'OK');
        $worksheet->setCellValue('BA4', 'NG');
        $worksheet->setCellValue('BB4', 'OK');
        $worksheet->setCellValue('BC4', 'NG');
        $worksheet->setCellValue('BD4', 'OK');
        $worksheet->setCellValue('BE4', 'NG');
        $worksheet->setCellValue('BF4', 'OK');
        $worksheet->setCellValue('BG4', 'NG');
        $worksheet->setCellValue('BH4', 'OK');
        $worksheet->setCellValue('BI4', 'NG');
        $worksheet->setCellValue('BJ4', 'OK');
        $worksheet->setCellValue('BK4', 'NG');
        $worksheet->setCellValue('BL4', 'OK');
        $worksheet->setCellValue('BM4', 'NG');
        $worksheet->setCellValue('BN4', 'OK');
        $worksheet->setCellValue('BO4', 'NG');
        $worksheet->setCellValue('BP4', 'Total');

        $e = 5;
        $no = 1;
        $total = 0;
        foreach ($data_line_stop_machine_by_period as $row) {

            $total = $row->OK_01 + $row->OK_02 + $row->OK_03 + $row->OK_04 + $row->OK_05 + $row->OK_06 + $row->OK_07 + $row->OK_08 + $row->OK_09 + $row->OK_10 +
                $row->OK_11 + $row->OK_12 + $row->OK_13 + $row->OK_14 + $row->OK_15 + $row->OK_16 + $row->OK_17 + $row->OK_18 + $row->OK_19 + $row->OK_20 +
                $row->OK_21 + $row->OK_22 + $row->OK_23 + $row->OK_24 + $row->OK_25 + $row->OK_26 + $row->OK_27 + $row->OK_28 + $row->OK_29 + $row->OK_30 + $row->OK_31;

            $worksheet->setCellValue("A$e", $no);
            $worksheet->setCellValue("B$e", $row->CHR_WORK_CENTER);
            $worksheet->setCellValue("C$e", $row->CHR_PART_NO);
            $worksheet->setCellValue("D$e", $row->CHR_BACK_NO);
            $worksheet->setCellValue("E$e", $row->CHR_PART_NAME);

            $worksheet->setCellValue("F$e", $row->OK_01);
            $worksheet->setCellValue("G$e", $row->NG_01);
            $worksheet->setCellValue("H$e", $row->OK_02);
            $worksheet->setCellValue("I$e", $row->NG_02);
            $worksheet->setCellValue("J$e", $row->OK_03);
            $worksheet->setCellValue("K$e", $row->NG_03);
            $worksheet->setCellValue("L$e", $row->OK_04);
            $worksheet->setCellValue("M$e", $row->NG_04);
            $worksheet->setCellValue("N$e", $row->OK_05);
            $worksheet->setCellValue("O$e", $row->NG_05);
            $worksheet->setCellValue("P$e", $row->OK_06);
            $worksheet->setCellValue("Q$e", $row->NG_06);
            $worksheet->setCellValue("R$e", $row->OK_07);
            $worksheet->setCellValue("S$e", $row->NG_07);
            $worksheet->setCellValue("T$e", $row->OK_08);
            $worksheet->setCellValue("U$e", $row->NG_08);
            $worksheet->setCellValue("V$e", $row->OK_09);
            $worksheet->setCellValue("W$e", $row->NG_09);
            $worksheet->setCellValue("X$e", $row->OK_10);
            $worksheet->setCellValue("Y$e", $row->NG_10);
            $worksheet->setCellValue("Z$e", $row->OK_11);
            $worksheet->setCellValue("AA$e", $row->NG_11);
            $worksheet->setCellValue("AB$e", $row->OK_12);
            $worksheet->setCellValue("AC$e", $row->NG_12);
            $worksheet->setCellValue("AD$e", $row->OK_13);
            $worksheet->setCellValue("AE$e", $row->NG_13);
            $worksheet->setCellValue("AF$e", $row->OK_14);
            $worksheet->setCellValue("AG$e", $row->NG_14);
            $worksheet->setCellValue("AH$e", $row->OK_15);
            $worksheet->setCellValue("AI$e", $row->NG_15);
            $worksheet->setCellValue("AJ$e", $row->OK_16);
            $worksheet->setCellValue("AK$e", $row->NG_16);
            $worksheet->setCellValue("AL$e", $row->OK_17);
            $worksheet->setCellValue("AM$e", $row->NG_17);
            $worksheet->setCellValue("AN$e", $row->OK_18);
            $worksheet->setCellValue("AO$e", $row->NG_18);
            $worksheet->setCellValue("AP$e", $row->OK_19);
            $worksheet->setCellValue("AQ$e", $row->NG_19);
            $worksheet->setCellValue("AR$e", $row->OK_20);
            $worksheet->setCellValue("AS$e", $row->NG_20);

            $worksheet->setCellValue("AT$e", $row->OK_21);
            $worksheet->setCellValue("AU$e", $row->NG_21);
            $worksheet->setCellValue("AV$e", $row->OK_22);
            $worksheet->setCellValue("AW$e", $row->NG_22);
            $worksheet->setCellValue("AX$e", $row->OK_23);
            $worksheet->setCellValue("AY$e", $row->NG_23);
            $worksheet->setCellValue("AZ$e", $row->OK_24);
            $worksheet->setCellValue("BA$e", $row->NG_24);
            $worksheet->setCellValue("BB$e", $row->OK_25);
            $worksheet->setCellValue("BC$e", $row->NG_25);
            $worksheet->setCellValue("BD$e", $row->OK_26);
            $worksheet->setCellValue("BE$e", $row->NG_26);
            $worksheet->setCellValue("BF$e", $row->OK_27);
            $worksheet->setCellValue("BG$e", $row->NG_27);
            $worksheet->setCellValue("BH$e", $row->OK_28);
            $worksheet->setCellValue("BI$e", $row->NG_28);
            $worksheet->setCellValue("BJ$e", $row->OK_29);
            $worksheet->setCellValue("BK$e", $row->NG_29);
            $worksheet->setCellValue("BL$e", $row->OK_30);
            $worksheet->setCellValue("BM$e", $row->NG_30);
            $worksheet->setCellValue("BN$e", $row->OK_31);
            $worksheet->setCellValue("BO$e", $row->NG_31);

            $worksheet->setCellValue("BP$e", $total);

            $e++;
            $no++;
        }

        $filename = 'report_production_result_' . trim($date) . "-" . date("H:i") . ".xlt";
        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . trim($filename) . '"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        // $objWriter->setIncludeCharts(TRUE);
        $objWriter->save('php://output');
    }

    public function download_report_ril_monthly_part()
    {
        $this->load->library('excel');

        $date = $this->input->post('CHR_DATE_SELECTED');
        $work_center = $this->input->post('CHR_WORK_CENTER');

        $data_ril_part = $this->production_result_m->get_data_ratio_ril_qty_amount_by_period_and_wc($date, $work_center);

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator(trim('AIS - Report RIL Monthly'));
        $objPHPExcel->getProperties()->setLastModifiedBy(trim($this->session->userdata('USERNAME')));
        $objPHPExcel->getProperties()->setTitle("Report RIL Monthly");
        $objPHPExcel->getProperties()->setSubject("Report RIL Monthly");
        $objPHPExcel->getProperties()->setDescription("Report RIL Monthly");
        // Set Properties

        //SETUP EXCEL
        $objPHPExcel->setActiveSheetIndex();
        $worksheet = $objPHPExcel->getActiveSheet();
        $worksheet->setTitle($work_center.$date);  

        //TABLE PRODUCTION QTY
        $worksheet->setCellValue('A1', 'No.');
        $worksheet->setCellValue('B1', 'Work Center');
        $worksheet->setCellValue('C1', 'Part No');
        $worksheet->setCellValue('D1', 'Back No');
        $worksheet->setCellValue('E1', 'Part Name');
        $worksheet->setCellValue('F1', 'Qty OK + RIL');
        $worksheet->setCellValue('G1', 'Qty RIL');
        $worksheet->setCellValue('H1', 'Ratio RIL (%)');
        $worksheet->setCellValue('I1', 'Amount OK + RIL');
        $worksheet->setCellValue('J1', 'Amount RIL');
        $worksheet->setCellValue('K1', 'Ratio Amount RIL (%)');
        $worksheet->setCellValue('L1', 'Qty RIL Process');
        $worksheet->setCellValue('M1', 'Ratio RIL Process (%)');
        $worksheet->setCellValue('N1', 'Amount RIL Process');
        $worksheet->setCellValue('O1', 'Ratio Amount RIL Process (%)');
        $worksheet->setCellValue('P1', 'Qty RIL Broken Test');
        $worksheet->setCellValue('Q1', 'Ratio RIL Broken Test (%)');
        $worksheet->setCellValue('R1', 'Amount RIL Broken Test');
        $worksheet->setCellValue('S1', 'Ratio Amount RIL Broken Test (%)');
        $worksheet->setCellValue('T1', 'Qty RIL Setup');
        $worksheet->setCellValue('U1', 'Ratio RIL Setup (%)');
        $worksheet->setCellValue('V1', 'Amount RIL Setup');
        $worksheet->setCellValue('W1', 'Ratio Amount RIL Setup (%)');
        $worksheet->setCellValue('X1', 'Qty RIL Trial');
        $worksheet->setCellValue('Y1', 'Ratio RIL Trial (%)');
        $worksheet->setCellValue('Z1', 'Amount RIL Trial');
        $worksheet->setCellValue('AA1', 'Ratio Amount RIL Trial (%)');

        $e = 2;
        $no = 1;
        foreach ($data_ril_part as $row) {

            $worksheet->setCellValue("A$e", $no);
            $worksheet->setCellValue("B$e", $row->CHR_WORK_CENTER);
            $worksheet->setCellValue("C$e", $row->CHR_PART_NO);
            $worksheet->setCellValue("D$e", $row->CHR_BACK_NO);
            $worksheet->setCellValue("E$e", $row->CHR_PART_NAME);
            $worksheet->setCellValue("F$e", $row->INT_TOTAL_QTY);
            $worksheet->setCellValue("G$e", $row->INT_TOTAL_NG);
            $worksheet->setCellValue("H$e", $row->RATIO_NG_QTY);
            $worksheet->setCellValue("I$e", $row->INT_TOTAL_AMOUNT);
            $worksheet->setCellValue("J$e", $row->INT_TOTAL_AMOUNT_NG);
            $worksheet->setCellValue("K$e", $row->RATIO_AMOUNT_NG);
            $worksheet->setCellValue("L$e", $row->INT_TOTAL_NG_PR);
            $worksheet->setCellValue("M$e", $row->RATIO_NG_QTY_PR);
            $worksheet->setCellValue("N$e", $row->INT_TOTAL_AMOUNT_NG_PR);
            $worksheet->setCellValue("O$e", $row->RATIO_AMOUNT_NG_PR);
            $worksheet->setCellValue("P$e", $row->INT_TOTAL_NG_BT);
            $worksheet->setCellValue("Q$e", $row->RATIO_NG_QTY_BT);
            $worksheet->setCellValue("R$e", $row->INT_TOTAL_AMOUNT_NG_BT);
            $worksheet->setCellValue("S$e", $row->RATIO_AMOUNT_NG_BT);
            $worksheet->setCellValue("T$e", $row->INT_TOTAL_NG_SU);
            $worksheet->setCellValue("U$e", $row->RATIO_NG_QTY_SU);
            $worksheet->setCellValue("V$e", $row->INT_TOTAL_AMOUNT_NG_SU);
            $worksheet->setCellValue("W$e", $row->RATIO_AMOUNT_NG_SU);
            $worksheet->setCellValue("X$e", $row->INT_TOTAL_NG_TR);
            $worksheet->setCellValue("Y$e", $row->RATIO_NG_QTY_TR);
            $worksheet->setCellValue("Z$e", $row->INT_TOTAL_AMOUNT_NG_TR);
            $worksheet->setCellValue("AA$e", $row->RATIO_AMOUNT_NG_TR);

            $e++;
            $no++;
        }

        $filename = 'report_production_result_' . trim($date) . "-" . date("H:i") . ".xlt";
        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . trim($filename) . '"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
    }

    public function report_ratio_ril($date = null, $work_center = null)
    {
        $data['title'] = 'Report Ratio RIL';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(297);
        $data['news'] = $this->news_m->get_news();
        $data['content'] = 'pes_new/report_ratio_ril_v.php';
        $data['daily'] = '';
        $data['monthly'] = '';

        $start_date = $this->input->post('CHR_START_DATE');
        $end_date = $this->input->post('CHR_END_DATE');

        if ($start_date) {
            $data['daily'] = 'active';
        } else {
            $data['monthly'] = 'active';
        }

        if ($date == '' || $date == NULL) {
            $date = date('Y') . date('m');
        }

        if ($start_date == '' || $start_date == NULL) {
            $start_date = date('Ymd');
        }

        if ($end_date == '' || $end_date == NULL) {
            $end_date = date('Ymd');
        }

        if ($work_center == '' || $work_center == NULL) {
            $work_center = $this->direct_backflush_general_m->get_top_data_direct_backflush_general();
            $data['work_center'] = $work_center;
        }

        $data['data'] = $this->production_result_m->get_data_ratio_ril_qty_amount_by_period($date);
        $data['selected_date'] = $date;

        $data['work_center'] = $work_center;
        $data['data_work_center'] = $this->production_result_m->get_data_ratio_ril_qty_amount_by_period_and_wc($date, $work_center);
        $data_work_center = $this->direct_backflush_general_m->get_active_data_work_center_with_all();
        $data['all_work_centers'] = $data_work_center;

        $data['data_perdate'] = $this->production_result_m->get_data_ratio_ril_qty_amount_by_between_period($start_date, $end_date);
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;

        $this->load->view($this->layout, $data);
    }

    function report_oee($date = '')
    {

        if ($date == NULL || $date == '') {
            $date = date('Ym');
        }

        $data['title'] = 'Report OEE';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(83);
        $data['news'] = $this->news_m->get_news();
        $data['content'] = 'pes_new/report_oee_v.php';

        $data['data'] = $this->production_activity_m->get_act_by_period($date);
        $data['selected_date'] = $date;

        $this->load->view($this->layout, $data);
    }

    function firstSunday($date)
    {
        for ($day = 1; $day <= 7; $day++) {
            $dd = strftime("%A", strtotime($date . '-' . $day));
            if ($dd == 'Sunday') {
                return strftime("%Y-%m-%d", strtotime($date . '-' . $day));
            }
        }
    }

    function firstSaturday($date)
    {
        for ($day = 1; $day <= 7; $day++) {
            $dd = strftime("%A", strtotime($date . '-' . $day));
            if ($dd == 'Saturday') {
                return strftime("%Y-%m-%d", strtotime($date . '-' . $day));
            }
        }
    }

    public function production_activity()
    {

        $date = $this->input->post('CHR_DATE');

        if ($date == NULL || $date == '') {
            $date = date('Ymd');
        }

        $work_center = '';

        $data['title'] = 'Production Activity';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(83);
        $data['news'] = $this->news_m->get_news();
        $data['content'] = 'pes_new/production_activity_v.php';

        $data['data'] = $this->production_activity_m->get_data_production_activity_by_date($date, $work_center);
        $data['date'] = $date;

        $this->load->view($this->layout, $data);
    }
}
