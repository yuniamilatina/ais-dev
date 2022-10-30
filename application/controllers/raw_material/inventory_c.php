<?php

class inventory_c extends CI_Controller {

    private $layout = '/template/head';

    public function __construct() {
        parent::__construct();
        $this->load->model('raw_material/inventory_m');
        $this->load->model('raw_material/inventory_exceeded_m');
        $this->load->model('raw_material/inventory_summary_m');
        $this->load->model('organization/dept_m');
        $this->load->model('raw_material/report_stock_m');
    }

    public function index() {

        redirect("fail_c/auth"); 
        
        $this->role_module_m->authorization('16');
        $this->log_m->add_log(12, NULL);

        $data['content'] = 'raw_material/report_inventory_v';

        $data['title'] = 'Report Negative Stock';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(141);
        $data['news'] = $this->news_m->get_news();

        $data['role'] = $this->session->userdata('ROLE');

        $data['stat_in_out'] = $this->inventory_m->check_stat_in_out_tmstock();
        $data['acquired_date'] = $this->report_stock_m->select_acquired_date();
        $data['load_to_sql'] = $this->report_stock_m->is_load_to_sql();
        $data['load_to_sql_inout'] = $this->report_stock_m->is_load_to_sql_inout();

        if ($data['load_to_sql'] == 0 && $data['load_to_sql_inout'] == 0) {
            $data['acquired_date_summary'] = $this->inventory_summary_m->select_acquired_date_summary_inventory();

            $data['data_summary_inventory_by_prod'] = $this->inventory_m->select_summary_inventory_by_prod();
            $data['data_data_inventory_by_prod'] = $this->inventory_m->select_data_inventory_by_prod();
            $data['data_summary_inventory_by_date'] = $this->inventory_summary_m->select_summary_inventory_by_date();
            $data['total_row'] = $this->inventory_m->select_total_row();
            $data['total'] = $this->inventory_m->total_data_stock();

            $data['acquired_date_summary_exceeded_stock'] = $this->inventory_summary_m->select_acquired_date_summary_inventory_exceed_stock();

            $data['data_summary_inventory_by_prod_exceeded_stock'] = $this->inventory_exceeded_m->select_summary_inventory_by_prod();
            $data['data_data_inventory_by_prod_exceeded_stock'] = $this->inventory_exceeded_m->select_data_inventory_by_prod();
            $data['data_summary_inventory_by_date_exceeded_stock'] = $this->inventory_summary_m->select_summary_inventory_by_date_exceed_stock();
            $data['total_row_exceeded_stock'] = $this->inventory_exceeded_m->select_total_row();
            $data['total_exceeded_stock'] = $this->inventory_exceeded_m->total_data_stock();
        }
        if ($data['load_to_sql'] == 1 || $data['load_to_sql_inout'] == 1) {
            $data['acquired_date_summary'] = Array();

            $data['data_summary_inventory_by_prod'] = Array();
            $data['data_data_inventory_by_prod'] = Array();
            $data['data_summary_inventory_by_date'] = Array();
            $data['total_row'] = Array();
            $data['total'] = Array();

            $data['acquired_date_summary_exceeded_stock'] = Array();

            $data['data_summary_inventory_by_prod_exceeded_stock'] = Array();
            $data['data_data_inventory_by_prod_exceeded_stock'] = Array();
            $data['data_summary_inventory_by_date_exceeded_stock'] = Array();
            $data['total_row_exceeded_stock'] = Array();
            $data['total_exceeded_stock'] = Array();
        }


        $date = date('Y') . date('m');
        $data['selected_date'] = $date;
        $data['first_sunday'] = $this->firstSunday(substr($date, 0, 4) . '-' . substr($date, 4, 2));
        $data['first_saturday'] = $this->firstSaturday(substr($date, 0, 4) . '-' . substr($date, 4, 2));

        $this->load->view($this->layout, $data);
    }

    function search() {
        $period = trim($this->input->post('period'));
        $part_no = trim($this->input->post('part_no'));
        $test = $this->input->post('part_no');

        $day_combine = $this->get_day_in_date($period);

        $this->load->library(array('sapconn'));
        $werks = "600";
        $this->sapconn->connect();
        $this->sapconn->new_function('ZFM_WDE_ZPPR0013');
        $this->sapconn->import('S_SPMON', $period);
        $this->sapconn->import('S_MATNR', $part_no);
        $this->sapconn->call();
        $data['detail'] = $this->sapconn->fetch('LT_DATA1');

        $data = $this->inventory_m->select_detail_part_in_out($part_no);
        if ($data == 0) {

            $data_table = "";

            $data_table .= "
            <tr class='gradeX'>
            <td style='vertical-align: top;text-align: left;'></td>
            <td style='vertical-align: top;text-align: left;'></td>
            <td style='text-align:center;'></td>
            <td style='text-align:center;'><div class='td-fixed'></div></td>
            <td style='text-align:center;'><div class='td-fixed'></div></td>
            <td style='text-align:center;'><div class='td-fixed'></div></td>
            <td style='text-align:center;'><div class='td-fixed'></div></td>
            <td style='text-align:center;'><div class='td-fixed'></div></td>
            <td style='text-align:center;'><div class='td-fixed'></div></td>
            <td style='text-align:center;'><div class='td-fixed'></div></td>
            <td style='text-align:center;'><div class='td-fixed'></div></td>
            <td style='text-align:center;'><div class='td-fixed'></div></td>
            <td style='text-align:center;'><div class='td-fixed'></div></td>
            <td style='text-align:center;'><div class='td-fixed'></div></td>
            <td style='text-align:center;'><div class='td-fixed'></div></td>
            <td style='text-align:center;'><div class='td-fixed'></div></td>
            <td style='text-align:center;'><div class='td-fixed'></div></td>
            <td style='text-align:center;'><div class='td-fixed'></div></td>
            <td style='text-align:center;'><div class='td-fixed'></div></td>
            <td style='text-align:center;'><div class='td-fixed'></div></td>
            <td style='text-align:center;'><div class='td-fixed'></div></td>
            <td style='text-align:center;'><div class='td-fixed'></div></td>
            <td style='text-align:center;'><div class='td-fixed'></div></td>
            <td style='text-align:center;'><div class='td-fixed'></div></td>
            <td style='text-align:center;'><div class='td-fixed'></div></td>
            <td style='text-align:center;'><div class='td-fixed'></div></td>
            <td style='text-align:center;'><div class='td-fixed'></div></td>
            <td style='text-align:center;'><div class='td-fixed'></div></td>
            <td style='text-align:center;'><div class='td-fixed'></div></td>
            <td style='text-align:center;'><div class='td-fixed'></div></td>
            <td style='text-align:center;'><div class='td-fixed'></div></td>
            <td style='text-align:center;'><div class='td-fixed'></div></td>
            <td style='text-align:center;'><div class='td-fixed'></div></td>
            <td style='text-align:center;'><div class='td-fixed'></div></td>
            <td style='text-align:center;'></td>
            </tr>";

            echo json_encode(array("data_table" => "$data_table", "part_no" => "", "part_name" => ""));
        } else {
            $data_table = "";
            if (count($data) > 0) {
                foreach ($data as $isi) {
                    $part_name = "Part Name :<strong> " . $isi->CHR_PART_NAME . '</strong> <br> Back. No: <strong>' . $isi->CHR_BACK_NO . ' </strong>';
                    $total = 0;
                    $total = str_replace(".000", "", "$isi->DATE_1") +
                            str_replace(".000", "", "$isi->DATE_2") +
                            str_replace(".000", "", "$isi->DATE_3") +
                            str_replace(".000", "", "$isi->DATE_4") +
                            str_replace(".000", "", "$isi->DATE_5") +
                            str_replace(".000", "", "$isi->DATE_6") +
                            str_replace(".000", "", "$isi->DATE_7") +
                            str_replace(".000", "", "$isi->DATE_8") +
                            str_replace(".000", "", "$isi->DATE_9") +
                            str_replace(".000", "", "$isi->DATE_10") +
                            str_replace(".000", "", "$isi->DATE_11") +
                            str_replace(".000", "", "$isi->DATE_12") +
                            str_replace(".000", "", "$isi->DATE_13") +
                            str_replace(".000", "", "$isi->DATE_14") +
                            str_replace(".000", "", "$isi->DATE_15") +
                            str_replace(".000", "", "$isi->DATE_16") +
                            str_replace(".000", "", "$isi->DATE_17") +
                            str_replace(".000", "", "$isi->DATE_18") +
                            str_replace(".000", "", "$isi->DATE_19") +
                            str_replace(".000", "", "$isi->DATE_20") +
                            str_replace(".000", "", "$isi->DATE_21") +
                            str_replace(".000", "", "$isi->DATE_22") +
                            str_replace(".000", "", "$isi->DATE_23") +
                            str_replace(".000", "", "$isi->DATE_24") +
                            str_replace(".000", "", "$isi->DATE_25") +
                            str_replace(".000", "", "$isi->DATE_26") +
                            str_replace(".000", "", "$isi->DATE_27") +
                            str_replace(".000", "", "$isi->DATE_28") +
                            str_replace(".000", "", "$isi->DATE_29") +
                            str_replace(".000", "", "$isi->DATE_30") +
                            str_replace(".000", "", "$isi->DATE_31");
                    $data_table .= "
            <tr class='gradeX'>
            <td style='vertical-align: top;text-align: left;'>" . $isi->CHR_SLOC . "</td>
            <td style='vertical-align: top;text-align: left;'>" . $isi->CHR_FLG . "</td>
            <td style='text-align:center;'>" . str_replace(',', '.', number_format($total)) . " </td>
            <td style='text-align:center;'><div class='td-fixed'>" . str_replace(".000", "", "$isi->DATE_1") . "</div></td>
            <td style='text-align:center;'><div class='td-fixed'>" . str_replace(".000", "", "$isi->DATE_2") . "</div></td>
            <td style='text-align:center;'><div class='td-fixed'>" . str_replace(".000", "", "$isi->DATE_3") . "</div></td>
            <td style='text-align:center;'><div class='td-fixed'>" . str_replace(".000", "", "$isi->DATE_4") . "</div></td>
            <td style='text-align:center;'><div class='td-fixed'>" . str_replace(".000", "", "$isi->DATE_5") . "</div></td>
            <td style='text-align:center;'><div class='td-fixed'>" . str_replace(".000", "", "$isi->DATE_6") . "</div></td>
            <td style='text-align:center;'><div class='td-fixed'>" . str_replace(".000", "", "$isi->DATE_7") . "</div></td>
            <td style='text-align:center;'><div class='td-fixed'>" . str_replace(".000", "", "$isi->DATE_8") . "</div></td>
            <td style='text-align:center;'><div class='td-fixed'>" . str_replace(".000", "", "$isi->DATE_9") . "</div></td>
            <td style='text-align:center;'><div class='td-fixed'>" . str_replace(".000", "", "$isi->DATE_10") . "</div></td>
            <td style='text-align:center;'><div class='td-fixed'>" . str_replace(".000", "", "$isi->DATE_11") . "</div></td>
            <td style='text-align:center;'><div class='td-fixed'>" . str_replace(".000", "", "$isi->DATE_12") . "</div></td>
            <td style='text-align:center;'><div class='td-fixed'>" . str_replace(".000", "", "$isi->DATE_13") . "</div></td>
            <td style='text-align:center;'><div class='td-fixed'>" . str_replace(".000", "", "$isi->DATE_14") . "</div></td>
            <td style='text-align:center;'><div class='td-fixed'>" . str_replace(".000", "", "$isi->DATE_15") . "</div></td>
            <td style='text-align:center;'><div class='td-fixed'>" . str_replace(".000", "", "$isi->DATE_16") . "</div></td>
            <td style='text-align:center;'><div class='td-fixed'>" . str_replace(".000", "", "$isi->DATE_17") . "</div></td>
            <td style='text-align:center;'><div class='td-fixed'>" . str_replace(".000", "", "$isi->DATE_18") . "</div></td>
            <td style='text-align:center;'><div class='td-fixed'>" . str_replace(".000", "", "$isi->DATE_19") . "</div></td>
            <td style='text-align:center;'><div class='td-fixed'>" . str_replace(".000", "", "$isi->DATE_20") . "</div></td>
            <td style='text-align:center;'><div class='td-fixed'>" . str_replace(".000", "", "$isi->DATE_21") . "</div></td>
            <td style='text-align:center;'><div class='td-fixed'>" . str_replace(".000", "", "$isi->DATE_22") . "</div></td>
            <td style='text-align:center;'><div class='td-fixed'>" . str_replace(".000", "", "$isi->DATE_23") . "</div></td>
            <td style='text-align:center;'><div class='td-fixed'>" . str_replace(".000", "", "$isi->DATE_24") . "</div></td>
            <td style='text-align:center;'><div class='td-fixed'>" . str_replace(".000", "", "$isi->DATE_25") . "</div></td>
            <td style='text-align:center;'><div class='td-fixed'>" . str_replace(".000", "", "$isi->DATE_26") . "</div></td>
            <td style='text-align:center;'><div class='td-fixed'>" . str_replace(".000", "", "$isi->DATE_27") . "</div></td>
            <td style='text-align:center;'><div class='td-fixed'>" . str_replace(".000", "", "$isi->DATE_28") . "</div></td>
            <td style='text-align:center;'><div class='td-fixed'>" . str_replace(".000", "", "$isi->DATE_29") . "</div></td>
            <td style='text-align:center;'><div class='td-fixed'>" . str_replace(".000", "", "$isi->DATE_30") . "</div></td>
            <td style='text-align:center;'><div class='td-fixed'>" . str_replace(".000", "", "$isi->DATE_31") . "</div></td>
            <td style='text-align:center;'>" . $isi->FLT_AVE . " </td>
            </tr>";
                }
            }

            echo json_encode(array("data_table" => "$data_table", "part_no" => "$part_no", "part_name" => "$part_name", "day" => "$day_combine"));
        }
    }

    function filter_data_in_out_by_part_and_period($period, $part_no) {
        $this->load->library(array('sapconn'));

        $this->sapconn->connect();

        $this->sapconn->new_function('ZFM_WDE_ZPPR0013');
        $this->sapconn->import('S_SPMON', $period);
        $this->sapconn->import('S_MATNR', $part_no);

        $this->sapconn->call();

        $this->sapconn->fetch('LT_DATA1');

        $this->sapconn->close();
    }

    function get_day_in_date($period) {
        $first_sunday = $this->firstSunday(substr($period, 0, 4) . '-' . substr($period, 4, 2));
        $first_saturday = $this->firstSaturday(substr($period, 0, 4) . '-' . substr($period, 4, 2));
        $selected_date = trim($period);

        $date = new DateTime($first_saturday);
        $thisMonth = $date->format('m');

        $z = 0;
        while ($date->format('m') === $thisMonth) {
            $datesaturday[$z] = $date->format('j');
            $date->modify('next Saturday');
            $z++;
        }

        $date1 = new DateTime($first_sunday);
        $thisMonth1 = $date1->format('m');

        $y = 0;
        while ($date1->format('m') === $thisMonth1) {
            $datesunday[$y] = $date1->format('j');
            $date1->modify('next Sunday');
            $y++;
        }

        $k = 0;
        for ($a = 1; $a <= 31; $a++) {
            if ($y == 5 && $z == 5) {
                if ($datesunday[$k] == $a || $datesunday[$k + 1] == $a || $datesunday[$k + 2] == $a || $datesunday[$k + 3] == $a || $datesunday[$k + 4] == $a || $datesaturday[$k] == $a || $datesaturday[$k + 1] == $a || $datesaturday[$k + 2] == $a || $datesaturday[$k + 3] == $a || $datesaturday[$k + 4] == $a) {
                    if (date('Ymj') == $selected_date . $a) {
                        $day[$a] = "<td  style='text-align:center;background:#007FFF;color:white;border-left-width: 0.1em;'>$a</td>";
                    } else {
                        $day[$a] = "<td  style='text-align:center;background:#E34234;color:white;border-left-width: 0.1em;'>$a</td>";
                    }
                } else {
                    if (date('Ymj') == $selected_date . $a) {
                        $day[$a] = "<td  style='text-align:center;background:#007FFF;color:white;border-left-width: 0.1em;'>$a</td>";
                    } else {
                        $day[$a] = "<td  style='text-align:center;background:white;border-left-width: 0.1em;'>$a</td>";
                    }
                }
            }
            if ($y == 4 && $z == 4) {
                if ($datesunday[$k] == $a || $datesunday[$k + 1] == $a || $datesunday[$k + 2] == $a || $datesunday[$k + 3] == $a || $datesaturday[$k] == $a || $datesaturday[$k + 1] == $a || $datesaturday[$k + 2] == $a || $datesaturday[$k + 3] == $a) {
                    if (date('Ymj') == $selected_date . $a) {
                        $day[$a] = "<td  style='text-align:center;background:#007FFF;color:white;border-left-width: 0.1em;'>$a</td>";
                    } else {
                        $day[$a] = "<td  style='text-align:center;background:#E34234;color:white;border-left-width: 0.1em;'>$a</td>";
                    }
                } else {
                    if (date('Ymj') == $selected_date . $a) {
                        $day[$a] = "<td  style='text-align:center;background:#007FFF;color:white;border-left-width: 0.1em;'>$a</td>";
                    } else {
                        $day[$a] = "<td  style='text-align:center;background:white;border-left-width: 0.1em;'>$a</td>";
                    }
                }
            }
            if ($y == 5 && $z == 4) {
                if ($datesunday[$k] == $a || $datesunday[$k + 1] == $a || $datesunday[$k + 2] == $a || $datesunday[$k + 3] == $a || $datesunday[$k + 4] == $a || $datesaturday[$k] == $a || $datesaturday[$k + 1] == $a || $datesaturday[$k + 2] == $a || $datesaturday[$k + 3] == $a) {
                    if (date('Ymj') == $selected_date . $a) {
                        $day[$a] .="<td  style='text-align:center;background:#007FFF;color:white;border-left-width: 0.1em;'>$a</td>";
                    } else {
                        $day[$a] .="<td  style='text-align:center;background:#E34234;color:white;border-left-width: 0.1em;'>$a</td>";
                    }
                } else {
                    if (date('Ymj') == $selected_date . $a) {
                        $day[$a] = "<td  style='text-align:center;background:#007FFF;color:white;border-left-width: 0.1em;'>$a</td>";
                    } else {
                        $day[$a] = "<td  style='text-align:center;background:white;border-left-width: 0.1em;'>$a</td>";
                    }
                }
            }
            if ($y == 4 && $z == 5) {
                if ($datesunday[$k] == $a || $datesunday[$k + 1] == $a || $datesunday[$k + 2] == $a || $datesunday[$k + 3] == $a || $datesaturday[$k] == $a || $datesaturday[$k + 1] == $a || $datesaturday[$k + 2] == $a || $datesaturday[$k + 3] == $a || $datesaturday[$k + 4] == $a) {
                    if (date('Ymj') == $selected_date . $a) {
                        $day[$a] = "<td  style='text-align:center;background:#007FFF;color:white;border-left-width: 0.1em;'>$a</td>";
                    } else {
                        $day[$a] = "<td  style='text-align:center;background:#E34234;color:white;border-left-width: 0.1em;'>$a</td>";
                    }
                } else {
                    if (date('Ymj') == $selected_date . $a) {
                        $day[$a] = "<td  style='text-align:center;background:#007FFF;color:white;border-left-width: 0.1em;'>$a</td>";
                    } else {
                        $day[$a] = "<td  style='text-align:center;background:white;border-left-width: 0.1em;'>$a</td>";
                    }
                }
            }
        }

        $day_combine = '';
        for ($g = 1; $g <= 31; $g++) {
            $day_combine .= $day[$g];
        }

        return $day_combine;
    }

    function firstSunday($date) {
        for ($day = 1; $day <= 7; $day++) {
            $dd = strftime("%A", strtotime($date . '-' . $day));
            if ($dd == 'Sunday') {
                return strftime("%Y-%m-%d", strtotime($date . '-' . $day));
            }
        }
    }

    function firstSaturday($date) {
        for ($day = 1; $day <= 7; $day++) {
            $dd = strftime("%A", strtotime($date . '-' . $day));
            if ($dd == 'Saturday') {
                return strftime("%Y-%m-%d", strtotime($date . '-' . $day));
            }
        }
    }

    function getDataConsumeFromSAP() {
        $this->load->library(array('sapconn'));
        $werks = "600";
        $this->sapconn->connect();
        $this->sapconn->new_function('CS_WHERE_USED_MAT');
        $this->sapconn->import('WERKS', '600');
        $this->sapconn->import('S_MATNR', '45163211170B0');
        $this->sapconn->import('DATUB', '');
        $this->sapconn->import('DATUV', '');
        $this->sapconn->call();
        $data = $this->sapconn->fetch('WULTB');

        echo var_dump($data);
        exit;
    }

    function print_negative_stock() {
        $this->load->library('excel');

        $acquired_date = $this->report_stock_m->select_acquired_date();
        $data_inventory_by_prod = $this->inventory_m->select_data_inventory_by_prod();
        $stat_in_out = $this->inventory_m->check_stat_in_out_tmstock();

        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

        // Set properties
        $objPHPExcel->getProperties()->setCreator(trim($this->session->userdata('USERNAME')));
        $objPHPExcel->getProperties()->setLastModifiedBy(trim($this->session->userdata('USERNAME')));
        $objPHPExcel->getProperties()->setTitle("Report Negative Stock");
        $objPHPExcel->getProperties()->setSubject("Report Negative Stock");
        $objPHPExcel->getProperties()->setDescription("Report Negative Stock");
        //Set Properties
        //SETUP EXCEL
        $width = 8;
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(4);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth($width);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(16);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth($width);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(24);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth($width);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(60);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(16);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(21);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(16);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(21);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(8);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(16);

        //SETUP EXCEL
        //HEADER
        $objPHPExcel->getActiveSheet()->mergeCells('A1:D1');
        $objPHPExcel->getActiveSheet()->mergeCells('H1:K1');

        $objPHPExcel->getActiveSheet()->getStyle("A3:M3")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle("A1:D1")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle("H1:K1")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

        //TABLE HEADER
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Acquired Date: ' . date("j/F/Y", strtotime($acquired_date['CHR_MODIFED_DATE'])) . ' ' . date("H:i:s", strtotime($acquired_date['CHR_MODIFED_TIME'])));
        $objPHPExcel->getActiveSheet()->setCellValue('A3', 'No.');
        $objPHPExcel->getActiveSheet()->setCellValue('B3', 'Dept');
        $objPHPExcel->getActiveSheet()->setCellValue('C3', 'Part No');
        $objPHPExcel->getActiveSheet()->setCellValue('D3', 'Back No');
        $objPHPExcel->getActiveSheet()->setCellValue('E3', 'Part Name');
        $objPHPExcel->getActiveSheet()->setCellValue('F3', 'Sloc');
        $objPHPExcel->getActiveSheet()->setCellValue('G3', 'Class');
        if ($stat_in_out == 0) {
            $objPHPExcel->getActiveSheet()->setCellValue('H3', 'Qty Beginning Balance');
            $objPHPExcel->getActiveSheet()->setCellValue('I3', 'Qty In');
            $objPHPExcel->getActiveSheet()->setCellValue('J3', 'Qty Out');
        }
        $objPHPExcel->getActiveSheet()->setCellValue('K3', 'Qty Ending Balance');
        $objPHPExcel->getActiveSheet()->setCellValue('L3', 'UOM');
        $objPHPExcel->getActiveSheet()->setCellValue('M3', 'Amount');

        $e = 4;
        $no = 1;
        foreach ($data_inventory_by_prod as $row) {
            $end_bal = intval($row->INT_TOTAL_QTY);
            $qty_in = intval($row->CHR_TRANS_IN);
            $qty_out = intval($row->CHR_TRANS_OUT);
            $begin_bal = $end_bal - $qty_in + $qty_out;
            $objPHPExcel->getActiveSheet()->setCellValue("A$e", $no);
            $objPHPExcel->getActiveSheet()->setCellValue("B$e", $row->DEPT);
            $objPHPExcel->getActiveSheet()->setCellValueExplicit("C$e", $row->CHR_PART_NO, PHPExcel_Cell_DataType::TYPE_STRING);
            $objPHPExcel->getActiveSheet()->setCellValue("D$e", $row->CHR_BACK_NO);
            $objPHPExcel->getActiveSheet()->setCellValue("E$e", $row->CHR_PART_NAME);
            $objPHPExcel->getActiveSheet()->setCellValue("F$e", $row->CHR_SLOC);
            $objPHPExcel->getActiveSheet()->setCellValue("G$e", $row->CLASSNAME);
            if ($stat_in_out == 0) {
                $objPHPExcel->getActiveSheet()->setCellValue("H$e", $begin_bal);
                $objPHPExcel->getActiveSheet()->setCellValue("I$e", $qty_in);
                $objPHPExcel->getActiveSheet()->setCellValue("J$e", $qty_out);
            }
            $objPHPExcel->getActiveSheet()->setCellValue("K$e", $end_bal);
            $objPHPExcel->getActiveSheet()->setCellValue("L$e", $row->CHR_PART_UOM);
            $objPHPExcel->getActiveSheet()->setCellValue("M$e", $row->AMOUNT);
            $e++;
            $no++;
        }

        $objPHPExcel->getActiveSheet()->getStyle("A3:M$e")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

        $filename = "Report_Negative_Stock_Acquired_Date_at-" . trim($acquired_date['CHR_MODIFED_DATE']) . '_' . trim($acquired_date['CHR_MODIFED_TIME']) . ".xlt";
        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . trim($filename) . '"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
    }

    function print_inventory_exceed() {
        $this->load->library('excel');

        $acquired_date = $this->report_stock_m->select_acquired_date();
        $data_inventory_by_prod = $this->inventory_exceeded_m->select_data_inventory_by_prod();
        $stat_in_out = $this->inventory_m->check_stat_in_out_tmstock();

        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

        // Set properties
        $objPHPExcel->getProperties()->setCreator(trim($this->session->userdata('USERNAME')));
        $objPHPExcel->getProperties()->setLastModifiedBy(trim($this->session->userdata('USERNAME')));
        $objPHPExcel->getProperties()->setTitle("Report Exceeded Stock");
        $objPHPExcel->getProperties()->setSubject("Report Exceeded Stock");
        $objPHPExcel->getProperties()->setDescription("Report Exceeded Stock");
        //Set Properties
        //SETUP EXCEL
        $width = 8;
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(4);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth($width);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(16);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth($width);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(24);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth($width);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(60);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(6);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(21);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(16);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(16);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(16);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(16);
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(16);
        $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(16);
        $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(16);
        $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(16);

        //SETUP EXCEL
        //HEADER
        $objPHPExcel->getActiveSheet()->mergeCells('A1:D1');
        $objPHPExcel->getActiveSheet()->getStyle("A1:D1")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle("A1:D1")->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('CCFFFF');

        //TABLE HEADER
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Acquired Date: ' . date("j/F/Y", strtotime($acquired_date['CHR_MODIFED_DATE'])) . ' ' . date("H:i:s", strtotime($acquired_date['CHR_MODIFED_TIME'])));
        $objPHPExcel->getActiveSheet()->setCellValue('A3', 'No.');
        $objPHPExcel->getActiveSheet()->setCellValue('B3', 'Dept');
        $objPHPExcel->getActiveSheet()->setCellValue('C3', 'Part No');
        $objPHPExcel->getActiveSheet()->setCellValue('D3', 'Back No');
        $objPHPExcel->getActiveSheet()->setCellValue('E3', 'Class');
        $objPHPExcel->getActiveSheet()->setCellValue('F3', 'Sloc');
        $objPHPExcel->getActiveSheet()->setCellValue('G3', 'Part Name');
        $objPHPExcel->getActiveSheet()->setCellValue('H3', 'UOM');
        if ($stat_in_out == 0) {
            $objPHPExcel->getActiveSheet()->setCellValue('I3', 'Qty Beginning Balance');
            $objPHPExcel->getActiveSheet()->setCellValue('J3', 'Qty In');
            $objPHPExcel->getActiveSheet()->setCellValue('K3', 'Qty Out');
        }
        $objPHPExcel->getActiveSheet()->setCellValue('L3', 'Qty Stock');
        $objPHPExcel->getActiveSheet()->setCellValue('M3', 'Amount stock');
        $objPHPExcel->getActiveSheet()->setCellValue('N3', 'Qty max std');
        $objPHPExcel->getActiveSheet()->setCellValue('O3', 'Amount max std');
        $objPHPExcel->getActiveSheet()->setCellValue('P3', 'Qty diff');
        $objPHPExcel->getActiveSheet()->setCellValue('Q3', 'Amount diff');

        $e = 4;
        $no = 1;
        foreach ($data_inventory_by_prod as $row) {
            $end_bal = intval($row->INT_QTY_STOCK);
            $qty_in = intval($row->CHR_TRANS_IN);
            $qty_out = intval($row->CHR_TRANS_OUT);
            $begin_bal = $end_bal - $qty_in + $qty_out;
            $objPHPExcel->getActiveSheet()->setCellValue("A$e", $no);
            $objPHPExcel->getActiveSheet()->setCellValue("B$e", $row->DEPT);
            $objPHPExcel->getActiveSheet()->setCellValueExplicit("C$e", $row->CHR_PART_NO, PHPExcel_Cell_DataType::TYPE_STRING);
            $objPHPExcel->getActiveSheet()->setCellValue("D$e", $row->CHR_BACK_NO);
            $objPHPExcel->getActiveSheet()->setCellValue("E$e", $row->CLASSNAME);
            $objPHPExcel->getActiveSheet()->setCellValue("F$e", $row->CHR_SLOC);
            $objPHPExcel->getActiveSheet()->setCellValue("G$e", $row->CHR_PART_NAME);
            $objPHPExcel->getActiveSheet()->setCellValue("H$e", $row->CHR_PART_UOM);
            if ($stat_in_out == 0) {
                $objPHPExcel->getActiveSheet()->setCellValue("I$e", $begin_bal);
                $objPHPExcel->getActiveSheet()->setCellValue("J$e", $qty_in);
                $objPHPExcel->getActiveSheet()->setCellValue("K$e", $qty_out);
            }
            $objPHPExcel->getActiveSheet()->setCellValue("L$e", $end_bal);
            $objPHPExcel->getActiveSheet()->setCellValue("M$e", $row->AMOUNT_STOCK);
            $objPHPExcel->getActiveSheet()->setCellValue("N$e", $row->INT_QTY_UPLOAD);
            $objPHPExcel->getActiveSheet()->setCellValue("O$e", $row->AMOUNT_UPLOAD);
            $objPHPExcel->getActiveSheet()->setCellValue("P$e", $row->INT_TOTAL_QTY);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$e", $row->AMOUNT);
            $e++;
            $no++;
        }

        $objPHPExcel->getActiveSheet()->getStyle("A3:Q$e")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

        $filename = "Report_Exceeded_Stock_Acquired_Date_at-" . trim($acquired_date['CHR_MODIFED_DATE']) . '_' . trim($acquired_date['CHR_MODIFED_TIME']) . ".xlt";
        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . trim($filename) . '"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
    }

}
