<?php

class Report_line_stop_c extends CI_Controller
{
    /* -- define constructor -- */

    private $layout = '/template/head';
    private $layout_blank = '/template/head_blank';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('prd/group_line_m');
        $this->load->model('mte/report_line_stop_m');
        $this->load->model('prd/direct_backflush_general_m');
        $this->load->model('mte/repair_breakdown_m');
        $this->load->model('samanta/spare_parts_m');
    }

    public function index($date = '', $id_product_group = '')
    {
        $data['title'] = 'Report Line Stop Machine';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(226);
        $data['news'] = $this->news_m->get_news();
        $data['content'] = 'mte/report_line_stop_v';

        if ($date == NULL || $date == '') {
            $date = date('Y') . date('m');
        }

        if ($id_product_group == NULL || $id_product_group == '') {
            $id_product_group = $this->group_line_m->get_top_prod_group_product()->row()->INT_ID;
        }
        $data['id_product_group'] = $id_product_group;
        $data['selected_date'] = $date;

        $data['data_trans_sp'] = $this->spare_parts_m->getDataTransactionSparePart($date);
        $data['data_stock_sp'] = $this->spare_parts_m->getDataStockSparePart($date);
        $data['data_order_sp'] = $this->spare_parts_m->getDataOrderSparePart();

        $data['data'] = $this->spare_parts_m->get_data_all_spare_parts_by_area('IT01');
        $data['all_product_group'] = $this->group_line_m->get_all_prod_group_product_custom();
        $data['data_line_stop_machine_by_period'] = $this->report_line_stop_m->select_data_line_stop_machine_by_period($date, $id_product_group);
        $data['role'] = $this->session->userdata('ROLE');

        $this->load->view($this->layout, $data);
    }

    public function get_data_perdate()
    {
        $period = trim($this->input->post('period'));
        $dept = trim($this->input->post('dept'));

        $data_linestop_machine_perdate = $this->report_line_stop_m->status_detail_line_stop_by_date_and_dept_and_work_center($period, $dept);
        if ($data_linestop_machine_perdate == 0) {
            $valuenull = 0;
            echo $valuenull;
        } else {
            $data = "";
            $data .= "<script type='text/javascript'>";
            $data .= "var chart1; ";
            $data .= "$(document).ready(function () {";
            $data .= "chart1 = new Highcharts.Chart({";
            $data .= "chart: {renderTo: 'container', type: 'area', plotBorderWidth: 1},credits: {enabled: false},legend: {borderColor: '#cccccc',borderWidth: 1,borderRadius: 3},tooltip:{split: true,valueSuffix:''},";
            $data .= "title: {text: ''},xAxis: {categories: ['1', '2', '3', '4', '5', '6','7', '8', '9', '10', '11', '12','13', '14', '15', '16', '17', '18','19', '20', '21', '22', '23', '24', '25', '26', '27','28', '29', '30', '31']},";
            $data .= "yAxis: {title: {text: 'Minutes Line Stop Machine '}},series: [";

            foreach ($data_linestop_machine_perdate as $row) {
                $data .= "{name: '$row->CHR_WORK_CENTER',data: [";
                $data .= $row->DATE_01 . ',' . $row->DATE_02 . ',' . $row->DATE_03 . ',' . $row->DATE_04 . ',' . $row->DATE_05 . ',' . $row->DATE_06 . ',' . $row->DATE_07 . ',' . $row->DATE_08 . ',' . $row->DATE_09 . ',' . $row->DATE_10 . ',' . $row->DATE_11 . ',' . $row->DATE_12 . ',' . $row->DATE_13 . ',' . $row->DATE_14 . ',' . $row->DATE_15 . ',' . $row->DATE_16 . ',' . $row->DATE_17 . ',' . $row->DATE_18 . ',' . $row->DATE_19 . ',' . $row->DATE_20 . ',' . $row->DATE_21 . ',' . $row->DATE_22 . ',' . $row->DATE_23 . ',' . $row->DATE_24 . ',' . $row->DATE_25 . ',' . $row->DATE_26 . ',' . $row->DATE_27 . ',' . $row->DATE_28 . ',' . $row->DATE_29 . ',' . $row->DATE_30 . ',' . $row->DATE_31;
                $data .= "]},";
            }

            $data .= "] }); });</script>";

            echo $data;
        }
    }

    public function print_report_line_stop()
    {
        $this->load->library('excel');

        $date = $this->input->post('CHR_DATE_SELECTED');
        $id_product_group = $this->input->post('INT_GROUP_PROD');

        $data_line_stop_machine_by_period = $this->report_line_stop_m->select_data_line_stop_machine_by_period($date, $id_product_group);
        $objPHPExcel = new PHPExcel();

        $objPHPExcel->getProperties()->setCreator(trim('AIS - Report Line Stop Machine'));
        $objPHPExcel->getProperties()->setLastModifiedBy(trim($this->session->userdata('USERNAME')));
        $objPHPExcel->getProperties()->setTitle("Report Line Stop Machine");
        $objPHPExcel->getProperties()->setSubject("Report Line Stop Machine");
        $objPHPExcel->getProperties()->setDescription("Report Line Stop Machine");

        //SETUP EXCEL
        $width = 14;
        $objPHPExcel->setActiveSheetIndex();
        $worksheet = $objPHPExcel->getActiveSheet();
        $worksheet->setTitle('Detail LS Machine');

        //HEADER
        $worksheet->setCellValue('A1', trim($date));

        //TABLE PRODUCTION QTY
        $worksheet->setCellValue('A3', 'No.');
        $worksheet->setCellValue('B3', 'Work Center');
        $worksheet->setCellValue('C3', 'Type');
        $worksheet->setCellValue('D3', 'Date');
        $worksheet->setCellValue('E3', 'Start STOP');
        $worksheet->setCellValue('F3', 'Start CALL');
        $worksheet->setCellValue('G3', 'Durasi WAIT (minutes)');
        $worksheet->setCellValue('H3', 'Start FOLLOW');
        $worksheet->setCellValue('I3', 'Durasi REPAIR (minutes)');
        $worksheet->setCellValue('J3', 'SOLVED');
        $worksheet->setCellValue('K3', 'Follow Up By');
        $worksheet->setCellValue('L3', 'TOTAL Duration (minutes)');
        $worksheet->setCellValue('M3', 'Root Cause');
        $worksheet->setCellValue('N3', 'Problem Desc');
        $worksheet->setCellValue('O3', 'Machine');
        $worksheet->setCellValue('P3', 'Corrective Action');
        $worksheet->setCellValue('Q3', 'Note');
        $worksheet->setCellValue('R3', 'Spare Partname');
        $worksheet->setCellValue('S3', 'Specs');

        $e = 4;
        $no = 1;
        foreach ($data_line_stop_machine_by_period as $row) {
            $worksheet->setCellValue("A$e", $no);
            $worksheet->setCellValue("B$e", $row->CHR_WORK_CENTER);
            $worksheet->setCellValue("C$e", $row->CHR_LINE_STOP);
            $worksheet->setCellValue("D$e", date('d-m-Y', strtotime($row->CHR_CREATED_DATE)));
            $worksheet->setCellValue("E$e", date('H:i', strtotime($row->CHR_START_TIME)));

            if ($row->CHR_WAITING_TIME == NULL) {
                $waiting_time = '-';
            } else {
                $waiting_time = date('H:i', strtotime($row->CHR_WAITING_TIME));
            }

            if ($row->CHR_FOLLOWUP_TIME == NULL) {
                $follow_time = '-';
            } else {
                $follow_time = date('H:i', strtotime($row->CHR_FOLLOWUP_TIME));
            }

            if ($row->CHR_STOP_TIME == ':') {
                $stop_time = '-';
            } else {
                $stop_time = date('H:i', strtotime($row->CHR_STOP_TIME));
            }

            $worksheet->setCellValue("F$e", $waiting_time);
            $worksheet->setCellValue("G$e", $row->INT_DURASI_WAITING);
            $worksheet->setCellValue("H$e", $follow_time);
            $worksheet->setCellValue("I$e", $row->INT_DURASI_REPAIR);
            $worksheet->setCellValue("J$e", $stop_time);
            $worksheet->setCellValue("K$e", $row->CHR_USERNAME);
            $worksheet->setCellValue("L$e", $row->INT_DURASI_LS);
            $worksheet->setCellValue("M$e", $row->CHR_PROBLEM);
            $worksheet->setCellValue("N$e", $row->CHR_PROBLEM_DESC);
            $worksheet->setCellValue("O$e", $row->CHR_MACHINE);
            $worksheet->setCellValue("P$e", $row->CHR_CORRECTIVE_ACTION);
            $worksheet->setCellValue("Q$e", $row->CHR_NOTE);
            $worksheet->setCellValue("R$e", $row->CHR_SPARE_PART_NAME);
            $worksheet->setCellValue("S$e", $row->CHR_SPECIFICATION);
            $e++;
            $no++;
        }

        $filename = 'report_linestop_machine_' . trim($date) . "-" . date("H:i") . ".xlt";
        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . trim($filename) . '"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        // $objWriter->setIncludeCharts(TRUE);
        $objWriter->save('php://output');
    }

    //----- UPDATE COMMENTS --- BY ANU 20190725 -----//
    function update_comments()
    {
        $session = $this->session->all_userdata();
        $date = date('Ymd');
        $time = date('His');
        $user = $session['NPK'];

        $id = $this->input->post('INT_ID_LINE_STOP');
        $periode = $this->input->post('CHR_PERIODE');
        $prod_group = $this->input->post('INT_ID_PRODUCT_GROUP');
        $problem = $this->input->post('PROBLEM');
        $comment = $this->input->post('COMMENT');
        $verified = $this->input->post('CHR_STATUS');

        $data_row = array(
            'CHR_PROBLEM' => $problem,
            'CHR_COMMENTS' => $comment,
            'CHR_COMMENT_BY' => $user,
            'CHR_COMMENT_DATE' => $date,
            'CHR_COMMENT_TIME' => $time,
            'CHR_FLAG_VERIFIED' => $verified,
            'CHR_VERIFIED_BY' => $user,
            'CHR_VERIFIED_DATE' => $date,
            'CHR_VERIFIED_TIME' => $time
        );
        $this->report_line_stop_m->update_comments($data_row, $id);

        redirect('mte/report_line_stop_c/index/' . $periode . '/' . $prod_group, 'refresh');

        print_r("ERROR - Please contact MIS (Ext. 704)");
        exit();
    }
    //----- END -----//

    public function save_repair_breakdown()
    {
        $session = $this->session->all_userdata();
        $date = date('Ymd');
        $time = date('His');
        $username = $session['USERNAME'];

        $periode = $this->input->post('CHR_PERIODE');
        $prod_group = $this->input->post('INT_ID_PRODUCT_GROUP');

        $id = $this->input->post('INT_ID_LINE_STOP');
        $machine = $this->input->post('CHR_MACHINE');
        $problem = $this->input->post('CHR_PROBLEM');
        $problem_desc = $this->input->post('CHR_PROBLEM_DESC');
        $corrective_action = $this->input->post('CHR_CORRECTIVE_ACTION');
        $flg_sparepart = $this->input->post('INT_FLG_SPAREPART');
        $note = $this->input->post('CHR_NOTE');
        $source = $this->input->post("CHR_SP_SOURCES");

        $data = array(
            'INT_ID_LINE_STOP' => $id,
            'CHR_MACHINE' => $machine,
            'CHR_PROBLEM' => $problem,
            'CHR_PROBLEM_DESC' => $problem_desc,
            'CHR_CORRECTIVE_ACTION' => $corrective_action,
            'INT_FLG_SPAREPART' => $flg_sparepart,
            'CHR_NOTE' => $note,
            'CHR_CREATED_BY' => $username,
            'CHR_CREATED_DATE' => $date,
            'CHR_CREATED_TIME' => $time
        );
        $id_ls_detail = $this->repair_breakdown_m->save($data);

        $data_trans_sp = $this->input->post("data_trans_sp");
        $data_stock_sp = $this->input->post("data_stock_sp");
        $data_order_sp = $this->input->post("data_order_sp");

        if ($source == 0) {
        } else if ($source == 1) {

            foreach ($data_trans_sp as $row) {
                if (count($row) == 2) {

                    $data_detail = array(
                        'INT_ID_LS_DETAIL' => $id_ls_detail,
                        'CHR_PART_NO' => $row['PART_NO'],
                        'INT_QTY' => $row['QTY'],
                        'INT_FLG_SOURCE' => $source,
                        'CHR_CREATED_BY' => $username,
                        'CHR_CREATED_DATE' => $date,
                        'CHR_CREATED_TIME' => $time
                    );
                    $this->repair_breakdown_m->saveDetail($data_detail);
                }
            }
        } else if ($source == 2) {

            foreach ($data_stock_sp as $row) {
                if (count($row) == 2) {

                    $data_detail = array(
                        'INT_ID_LS_DETAIL' => $id_ls_detail,
                        'CHR_PART_NO' => $row['PART_NO'],
                        'INT_QTY' => $row['QTY'],
                        'INT_FLG_SOURCE' => $source,
                        'CHR_CREATED_BY' => $username,
                        'CHR_CREATED_DATE' => $date,
                        'CHR_CREATED_TIME' => $time
                    );
                    $this->repair_breakdown_m->saveDetail($data_detail);
                }
            }
        } else if ($source == 3) {

            foreach ($data_order_sp as $row) {

                if (count($row) == 2) {

                    $data_detail = array(
                        'INT_ID_LS_DETAIL' => $id_ls_detail,
                        'CHR_PART_NO' => $row['PART_NO'],
                        'INT_QTY' => $row['QTY'],
                        'INT_FLG_SOURCE' => $source,
                        'CHR_CREATED_BY' => $username,
                        'CHR_CREATED_DATE' => $date,
                        'CHR_CREATED_TIME' => $time
                    );

                    $this->repair_breakdown_m->saveDetail($data_detail);
                }
            }
        }

        redirect('mte/report_line_stop_c/index/' . $periode . '/' . $prod_group, 'refresh');
    }

    function get_data_repair_by_id_ls()
    {
        $id = $this->input->post("INT_ID");
        $data_linestop = $this->report_line_stop_m->get_data_repair_by_id_ls($id);

        $json_data = array(
            'INT_ID_LINE_STOP' => $id,
            'CHR_MACHINE' => $data_linestop->CHR_MACHINE,
            'CHR_PROBLEM' => $data_linestop->CHR_PROBLEM,
            'CHR_PROBLEM_DESC' => $data_linestop->CHR_PROBLEM_DESC,
            'CHR_CORRECTIVE_ACTION' => $data_linestop->CHR_CORRECTIVE_ACTION,
            // 'INT_FLG_SPAREPART' => $data_linestop->INT_FLG_SPAREPART,
            // 'INT_QTY' => $data_linestop->INT_QTY,
            'CHR_NOTE' => $data_linestop->CHR_NOTE,
            'CHR_CREATED_DATE' => $data_linestop->CHR_CREATED_DATE,
            'CHR_LINE_CODE' => $data_linestop->CHR_LINE_CODE
        );

        echo json_encode($json_data);
    }

    function get_spec_spare_part()
    {
        $sparepart = $this->input->post("CHR_SPARE_PART_NAME");
        $data_spare_part = $this->spare_parts_m->get_spec_spare_part(trim($sparepart));

        $data = '';

        foreach ($data_spare_part as $row) {
            if (trim($sparepart) == trim($row->CHR_SPARE_PART_NAME)) {
                $data .= "<option selected value='$row->INT_ID'>" . $row->CHR_SPECIFICATION . "</option>";
            } else {
                $data .= "<option value='$row->INT_ID'>" . $row->CHR_SPECIFICATION . "</option>";
            }
        }

        $json_data = array('data' => $data);

        echo json_encode($json_data);
    }

    // function get_data_spare_part()
    // {
    //     $date = $this->input->post("CHR_ENTRIED_DATE");
    //     $lstype = $this->input->post("LINE_STOP_TYPE");

    //     if ($lstype == 'LS4' || $lstype == 'LS5') {
    //         $sloc = 'MT03';
    //     } else if ($lstype == 'LS23' || $lstype == 'LS24') {
    //         $sloc = 'MT01';
    //     } else {
    //         $sloc = '';
    //     }

    //     $data_spare_part = $this->spare_parts_m->get_all_parts_trans($date, $sloc);

    //     $data = '';
    //     foreach ($data_spare_part as $row) {
    //         $data .= "<option value='$row->CHR_SPARE_PART_NAME'>" . $row->CHR_SPARE_PART_NAME . "</option>";
    //     }

    //     $json_data = array('data' => $data);

    //     echo json_encode($json_data);
    // }

    //MTBF
    function report_mtbf($year = null, $id_product_group = null)
    {

        if ($year == NULL || $year == '') {
            $year = date('Y');
        }

        if ($id_product_group == null ||  $id_product_group == '') {
            $id_product_group = 0;
        }

        $data['title'] = 'Report MTBF';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(85);
        $data['news'] = $this->news_m->get_news();
        $data['content'] = 'mte/report_mtbf_v.php';

        $data['data_mtbf'] = $this->report_line_stop_m->get_data_mtbf_by_year($year, $id_product_group);

        $data['all_product_group'] = $this->group_line_m->get_all_prod_group_product_custom();
        $data['id_product_group'] = $id_product_group;

        $data['selected_year'] = $year;

        $this->load->view($this->layout, $data);
    }

    function chart_mtbf_by_line($year = null, $id_product_group = null)
    {

        if ($year == NULL || $year == '') {
            $year = date('Y');
        }

        if ($id_product_group == null ||  $id_product_group == '') {
            $id_product_group = 0;
        }

        $data['content'] = 'mte/mtbf_chart_subline_v.php';

        $data['data_mtbf'] = $this->report_line_stop_m->get_total_mtbf_by_year($year, $id_product_group);

        $this->load->view($this->layout_blank, $data);
    }

    function chart_mtbf_by_groupline($year = null)
    {

        if ($year == NULL || $year == '') {
            $year = date('Y');
        }

        $data['content'] = 'mte/mtbf_chart_group_line_v.php';

        $data['data_mtbf'] = $this->report_line_stop_m->chart_mtbf_group_line_by_year($year);

        $this->load->view($this->layout_blank, $data);
    }

    function report_mtbf_dies($year = null, $id_product_group = null)
    {

        if ($year == NULL || $year == '') {
            $year = date('Y');
        }

        if ($id_product_group == null ||  $id_product_group == '') {
            $id_product_group = 0;
        }

        $data['title'] = 'Report MTBF';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(294);
        $data['news'] = $this->news_m->get_news();
        $data['content'] = 'mte/report_mtbf_dies_v.php';

        $data['data_mtbf_dies'] = $this->report_line_stop_m->get_data_mtbf_dies_by_year($year, $id_product_group);

        $data['all_product_group'] = $this->group_line_m->get_all_prod_group_product_custom();
        $data['id_product_group'] = $id_product_group;

        $data['selected_year'] = $year;

        $this->load->view($this->layout, $data);
    }

    function chart_mtbf_dies_by_line($year = null, $id_product_group = null)
    {

        if ($year == NULL || $year == '') {
            $year = date('Y');
        }

        if ($id_product_group == null ||  $id_product_group == '') {
            $id_product_group = 0;
        }

        $data['content'] = 'mte/mtbf_dies_chart_subline_v.php';

        $data['data_mtbf_dies'] = $this->report_line_stop_m->get_total_mtbf_dies_by_year($year, $id_product_group);

        $this->load->view($this->layout_blank, $data);
    }

    function chart_mtbf_dies_by_groupline($year = null)
    {

        if ($year == NULL || $year == '') {
            $year = date('Y');
        }

        $data['content'] = 'mte/mtbf_dies_chart_group_line_v.php';

        $data['data_mtbf_dies'] = $this->report_line_stop_m->chart_mtbf_dies_group_line_by_year($year);

        $this->load->view($this->layout_blank, $data);
    }

    //MTTR
    function report_mttr($year = null, $id_product_group = null)
    {

        if ($year == NULL || $year == '') {
            $year = date('Y');
        }
        if ($id_product_group == null ||  $id_product_group == '') {
            $id_product_group = 0;
        }

        $data['title'] = 'Report MTTR';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(108);
        $data['news'] = $this->news_m->get_news();
        $data['content'] = 'mte/report_mttr_v.php';

        $data['data_mttr'] = $this->report_line_stop_m->get_data_mttr_by_year($year, $id_product_group);

        $data['all_product_group'] = $this->group_line_m->get_all_prod_group_product_custom();
        $data['id_product_group'] = $id_product_group;
        $data['selected_date'] = $year;

        $this->load->view($this->layout, $data);
    }

    function chart_mttr_by_line($year = null, $id_product_group = null)
    {

        if ($year == NULL || $year == '') {
            $year = date('Y');
        }

        if ($id_product_group == null ||  $id_product_group == '') {
            $id_product_group = 0;
        }

        $data['content'] = 'mte/mttr_chart_subline_v.php';

        $data['data_mttr'] = $this->report_line_stop_m->get_total_mttr_by_year($year, $id_product_group);

        $this->load->view($this->layout_blank, $data);
    }

    function chart_mttr_by_product($year = null)
    {

        if ($year == NULL || $year == '') {
            $year = date('Y');
        }

        $data['content'] = 'mte/mttr_chart_group_line_v.php';

        $data['data_mttr'] = $this->report_line_stop_m->chart_mttr_group_line_by_year($year);

        $this->load->view($this->layout_blank, $data);
    }

    function report_mttr_dies($year = null, $id_product_group = null)
    {

        if ($year == NULL || $year == '') {
            $year = date('Y');
        }
        if ($id_product_group == null ||  $id_product_group == '') {
            $id_product_group = 0;
        }

        $data['title'] = 'Report MTTR DIES';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(295);
        $data['news'] = $this->news_m->get_news();
        $data['content'] = 'mte/report_mttr_dies_v.php';

        $data['data_mttr_dies'] = $this->report_line_stop_m->get_data_mttr_dies_by_year($year, $id_product_group);

        $data['all_product_group'] = $this->group_line_m->get_all_prod_group_product_custom();
        $data['id_product_group'] = $id_product_group;
        $data['selected_date'] = $year;

        $this->load->view($this->layout, $data);
    }

    function chart_mttr_dies_by_line($year = null, $id_product_group = null)
    {

        if ($year == NULL || $year == '') {
            $year = date('Y');
        }

        if ($id_product_group == null ||  $id_product_group == '') {
            $id_product_group = 0;
        }

        $data['content'] = 'mte/mttr_dies_chart_subline_v.php';

        $data['data_mttr_dies'] = $this->report_line_stop_m->get_total_mttr_dies_by_year($year, $id_product_group);

        $this->load->view($this->layout_blank, $data);
    }

    function chart_mttr_dies_by_product($year = null)
    {

        if ($year == NULL || $year == '') {
            $year = date('Y');
        }

        $data['content'] = 'mte/mttr_dies_chart_group_line_v.php';

        $data['data_mttr_dies'] = $this->report_line_stop_m->chart_mttr_dies_group_line_by_year($year);

        $this->load->view($this->layout_blank, $data);
    }
}
