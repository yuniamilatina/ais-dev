<?php

class export_c extends CI_Controller {
    /* -- define constructor -- */

    private $layout = '/template/head';

    public function __construct() {
        parent::__construct();

        $this->load->model('efaktur/export_m');
        $this->load->library('excel');
        // $this->load->library('PHPExcel');
        $this->load->model('basis/role_module_m');
    }

    public function efaktur_in() {

        $this->role_module_m->authorization('45');

        $msg = "";

        if ($this->input->post('btn_export') != '') {

            $zuonr_low = $this->input->post('ZUONR_LOW');
            $zuonr_high = $this->input->post('ZUONR_HIGH');
            $budat_low = substr($this->input->post('BUDAT_LOW'), 4, 4) . substr($this->input->post('BUDAT_LOW'), 2, 2) . substr($this->input->post('BUDAT_LOW'), 0, 2);
            $budat_high = substr($this->input->post('BUDAT_HIGH'), 4, 4) . substr($this->input->post('BUDAT_HIGH'), 2, 2) . substr($this->input->post('BUDAT_HIGH'), 0, 2);


            if ($zuonr_low == "" && $zuonr_high == "" && $budat_low == "" && $budat_high == "") {
                $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button>Please fill a field </div >";
            } else {
                $this->load->library(array('sapconn'));

                $objTpl = PHPExcel_IOFactory::load("./assets/template/efaktur_in.xlt");
                $objTpl->setActiveSheetIndex(0);

                $this->sapconn->connect();

                $view_data = $this->export_m->select_data_in($zuonr_low, $zuonr_high, $budat_low, $budat_high);
                //var_dump($view_data); exit();
                $i = 1;
                foreach ($view_data as $data):
                    //$objTpl->getActiveSheet()->setCellValue('B1', 'aa');

                    $objTpl->getActiveSheet()->setCellValue('A' . ($i + 1), "FM");
                    //$objTpl->getActiveSheet()->setCellValue('B'.($i + 1), "01");
                    $objTpl->getActiveSheet()->setCellValueExplicit('B' . ($i + 1), "01", PHPExcel_Cell_DataType::TYPE_STRING);
                    $objTpl->getActiveSheet()->setCellValue('C' . ($i + 1), "0");
                    //$objTpl->getActiveSheet()->getStyle('D'.($i + 1))->getNumberFormat()->setFormatCode('00000000');
                    //$objTpl->getActiveSheet()->getStyle('D'.($i + 1))->getNumberFormat()->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
                    //$objTpl->getActiveSheet()->setCellValue('D'.($i + 1), $data["ZUONR"]);
                    $objTpl->getActiveSheet()->setCellValueExplicit('D' . ($i + 1), $data["ZUONR"], PHPExcel_Cell_DataType::TYPE_STRING);
                    $objTpl->getActiveSheet()->setCellValue('E' . ($i + 1), substr($data["BUDAT"], 4, 2));
                    $objTpl->getActiveSheet()->setCellValue('F' . ($i + 1), substr($data["BUDAT"], 0, 4));
                    //$objTpl->getActiveSheet()->setCellValue('G'.($i + 1), $data["SGTXT"]);
                    $objTpl->getActiveSheet()->setCellValue('G' . ($i + 1), ( substr($data["BUDAT"], 6, 2) . "/" . substr($data["BUDAT"], 4, 2) . "/" . substr($data["BUDAT"], 0, 4)));
                    //$objTpl->getActiveSheet()->setCellValue('H'.($i + 1), $data["STCEG"]);
                    $objTpl->getActiveSheet()->setCellValueExplicit('H' . ($i + 1), $data["STCEG"], PHPExcel_Cell_DataType::TYPE_STRING);
                    $objTpl->getActiveSheet()->setCellValue('I' . ($i + 1), $data["NAME1"]);
                    $objTpl->getActiveSheet()->setCellValue('J' . ($i + 1), $data["STRAS"] . " " . $data["MCOD3"]);
                    $objTpl->getActiveSheet()->setCellValue('K' . ($i + 1), round($data["WMWST1"]));
                    $objTpl->getActiveSheet()->setCellValue('L' . ($i + 1), round($data["RMWWR"]));
                    $objTpl->getActiveSheet()->setCellValue('M' . ($i + 1), "0");
                    $objTpl->getActiveSheet()->setCellValue('N' . ($i + 1), "1");

                    /*
                      $objTpl->getActiveSheet()->setCellValue('A'.($i + 1), "FM");
                      $objTpl->getActiveSheet()->setCellValue('B'.($i + 1), "01");
                      $objTpl->getActiveSheet()->setCellValue('C'.($i + 1), "0");
                      $objTpl->getActiveSheet()->setCellValue('D'.($i + 1), "'0001500000267");
                      $objTpl->getActiveSheet()->setCellValue('E'.($i + 1), "4");
                      $objTpl->getActiveSheet()->setCellValue('F'.($i + 1), "2015");
                      $objTpl->getActiveSheet()->setCellValue('G'.($i + 1), "26/04/2015");
                      $objTpl->getActiveSheet()->setCellValue('H'.($i + 1), "010691871004000");
                      $objTpl->getActiveSheet()->setCellValue('I'.($i + 1), "pt.prima sarana elektronik");
                      $objTpl->getActiveSheet()->setCellValue('J'.($i + 1), "" );
                      $objTpl->getActiveSheet()->setCellValue('K'.($i + 1), "15000000");
                      $objTpl->getActiveSheet()->setCellValue('L'.($i + 1), "1500000");
                      $objTpl->getActiveSheet()->setCellValue('M'.($i + 1), "0");
                      $objTpl->getActiveSheet()->setCellValue('N'.($i + 1), "1");
                     */
                    $i = $i + 1;
                endforeach;

                $this->sapconn->close();

                if ($this->input->post('tipe') == 'csv') {

                    $filename = 'Report_efaktur_masukan.csv'; //just some random filename
                    ob_end_clean();
                    header('Content-Type: application/vnd.ms-excel');
                    header('Content-Disposition: attachment;filename="' . trim($filename) . '"');
                    header('Cache-Control: max-age=0');

                    $objWriter = PHPExcel_IOFactory::createWriter($objTpl, 'CSV');
                    $objWriter->save('php://output');
                    exit();
                } else {

                    $filename = 'Report_efaktur_masukan.xls'; //just some random filename
                    ob_end_clean();
                    header('Content-Type: application/vnd.ms-excel');
                    header('Content-Disposition: attachment;filename="' . trim($filename) . '"');
                    header('Cache-Control: max-age=0');

                    $objWriter = PHPExcel_IOFactory::createWriter($objTpl, 'Excel5');
                    $objWriter->save('php://output');
                    exit();
                }

                $msg = "<div class = 'alert alert-success'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Downloading success </strong> The data is successfully created </div >";
            }
        }

        $this->session->userdata('user_id');

        $data['content'] = 'efaktur/efaktur_in_v';
        $data['title'] = 'Export Data e-Faktur Masukan';

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(45);
        $data['news'] = null;

        $data['msg'] = $msg;

        $this->load->view($this->layout, $data);
    }

    public function efaktur_out() {
        $this->role_module_m->authorization('46');
        $msg = "";

        if ($this->input->post('btn_export') != '') {

            $inv_no_low = $this->input->post('INV_NO_LOW');
            $inv_no_high = $this->input->post('INV_NO_HIGH');


            //$budat_low = substr($this->input->post('BUDAT_LOW'),4,4) . substr($this->input->post('BUDAT_LOW'),2,2) . substr($this->input->post('BUDAT_LOW'),0,2); 
            //$budat_high = substr($this->input->post('BUDAT_HIGH'),4,4) . substr($this->input->post('BUDAT_HIGH'),2,2) . substr($this->input->post('BUDAT_HIGH'),0,2);

            if ($inv_no_low == "" && $inv_no_high == "") {
                $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button>Please fill a field </div >";
            } else {
                $this->load->library(array('sapconn'));

                $objTpl = PHPExcel_IOFactory::load("./assets/template/efaktur_out.xlt");
                $objTpl->setActiveSheetIndex(0);

                $this->sapconn->connect();

                $view_data = $this->export_m->select_data_out($inv_no_low, $inv_no_high);
                // var_dump($view_data['HEADERDATA']); exit();

                $i = 0;
                $temp_bill = 0;
                $temp_bill_ppn = 0;
                $temp_no_faktur = "";
                foreach ($view_data['HEADERDATA'] as $data):
                    //$objTpl->getActiveSheet()->setCellValue('B1', 'aa');                   


                    if ($temp_no_faktur <> $data["TAXNO"]) {
                        
                        $temp_bill = 0;
                        $temp_bill_ppn = 0;

                        foreach ($view_data['LINEDATA'] as $data_line):
                            if ($data["REF_NUMBER"] == $data_line["REF_NUMBER"]) {
                                $temp_bill = $temp_bill + round($data_line["LINE_AMOUNT"]);
                                $temp_bill_ppn = $temp_bill_ppn + round($data_line["LINE_AMOUNT"] * 0.11);
                            }
                        endforeach;

                        $i = $i + 1;

                        /*
                          $objTpl->getActiveSheet()->setCellValue('A'.($i + 3), "FK");
                          //$objTpl->getActiveSheet()->setCellValue('B'.($i + 3), "01");
                          $objTpl->getActiveSheet()->setCellValueExplicit('B'.($i + 3), "01", PHPExcel_Cell_DataType::TYPE_STRING);
                          $objTpl->getActiveSheet()->setCellValue('C'.($i + 3), "0");

                          //$objTpl->getActiveSheet()->setCellValue('D'.($i + 3), $data["TAXNO"]);
                          //$objTpl->getActiveSheet()->setCellValue('D'.($i + 3), str_replace(".","",str_replace("-","",substr($data["TAXNO"],4))));
                          $objTpl->getActiveSheet()->setCellValueExplicit('D'.($i + 3), str_replace(".","",str_replace("-","",substr($data["TAXNO"],4))) , PHPExcel_Cell_DataType::TYPE_STRING);

                          $objTpl->getActiveSheet()->setCellValue('E'.($i + 3), substr($data["BIL_DATE"],4,2));
                          $objTpl->getActiveSheet()->setCellValue('F'.($i + 3), substr($data["BIL_DATE"],0,4));
                          $objTpl->getActiveSheet()->setCellValue('G'.($i + 3), substr($data["BIL_DATE"],6,2) . "/" . substr($data["BIL_DATE"],4,2) . "/" . substr($data["BIL_DATE"],0,4)) ;
                          //$objTpl->getActiveSheet()->setCellValue('H'.($i + 3), $data["BIL_VATNO"]);
                          $objTpl->getActiveSheet()->setCellValueExplicit('H'.($i + 3), $data["BIL_VATNO"], PHPExcel_Cell_DataType::TYPE_STRING);
                          $objTpl->getActiveSheet()->setCellValue('I'.($i + 3), $data["BT_NAME1"]);
                          $objTpl->getActiveSheet()->setCellValue('J'.($i + 3), $data["BT_STREET"]);
                          $objTpl->getActiveSheet()->setCellValue('K'.($i + 3), $temp_bill);
                          $objTpl->getActiveSheet()->setCellValue('L'.($i + 3), $temp_bill_ppn );
                          $objTpl->getActiveSheet()->setCellValue('M'.($i + 3), "0");
                          $objTpl->getActiveSheet()->setCellValue('N'.($i + 3), "");
                          $objTpl->getActiveSheet()->setCellValue('O'.($i + 3), "0");
                          $objTpl->getActiveSheet()->setCellValue('P'.($i + 3), "0");
                          $objTpl->getActiveSheet()->setCellValue('Q'.($i + 3), "0");
                          $objTpl->getActiveSheet()->setCellValue('R'.($i + 3), "0");
                          //$objTpl->getActiveSheet()->setCellValue('S'.($i + 3), $data["BIL_NUMBER"]);
                          $objTpl->getActiveSheet()->setCellValueExplicit('S'.($i + 3), $data["BIL_NUMBER"], PHPExcel_Cell_DataType::TYPE_STRING);


                          $objTpl->getActiveSheet()->setCellValue('A'.($i + 4), "LT");
                          $objTpl->getActiveSheet()->setCellValueExplicit('B'.($i + 4), $data["BIL_VATNO"], PHPExcel_Cell_DataType::TYPE_STRING);
                          $objTpl->getActiveSheet()->setCellValue('C'.($i + 4), $data["BT_NAME1"]);
                          $objTpl->getActiveSheet()->setCellValue('D'.($i + 4), $data["BT_STREET"]);

                          $objTpl->getActiveSheet()->setCellValue('M'.($i + 4), $data["BT_POSTL_CODE"]);
                          $objTpl->getActiveSheet()->setCellValue('N'.($i + 4), $data["BT_TELNUM"]);
                         */

                        if ($this->input->post('tipe_faktur') == 'biasa') {
                            $fg = "0";
                        } else {
                            $fg = "1";
                        }
                        
                        $data_h = array(
                            'CHR_NO_INVOICE' => $data["REF_NUMBER"],
                            'CHR_FK' => "FK",
                            'CHR_KD_JENIS_TRANSAKSI' => "01",
                            'CHR_FG_PENGGANTI' => $fg,
                            'CHR_NOMOR_FAKTUR' => str_replace(".", "", str_replace("-", "", substr($data["TAXNO"], 3))),
                            'CHR_MASA_PAJAK' => substr($data["BIL_DATE"], 4, 2),
                            'CHR_TAHUN_PAJAK' => substr($data["BIL_DATE"], 0, 4),
                            'CHR_TANGGAL_FAKTUR' => substr($data["BIL_DATE"], 6, 2) . "/" . substr($data["BIL_DATE"], 4, 2) . "/" . substr($data["BIL_DATE"], 0, 4),
                            'CHR_NPWP' => $data["BIL_VATNO"],
                            'CHR_NAMA' => $data["BT_NAME1"] . " " . $data["BT_NAME2"],
                            'CHR_ALAMAT_LENGKAP' => $data["BT_STREET"] . $data["BT_CITY1"] . " " . $data["BT_STR_SUPPL3"],
                            'MON_JUMLAH_DPP' => $temp_bill,
                            'MON_JUMLAH_PPN' => $temp_bill_ppn,
                            'MON_JUMLAH_PPNBM' => "0",
                            'CHR_ID_KETERANGAN_TAMBAHAN' => "",
                            'MON_FG_UANG_MUKA' => "0",
                            'MON_UANG_MUKA_DPP' => "0",
                            'MON_UANG_MUKA_PPN' => "0",
                            'MON_UANG_MUKA_PPNBM' => "0",
                            'CHR_REFERENSI' => $data["REF_NUMBER"],
                            'CHR_USER_PRINT' => $this->session->userdata('NPK'),
                        );

                        $this->export_m->add_out_header($data_h);
                        
                        // print_r($data_h);
                        // exit();
                        
                        $data_h_lt = array(
                            'CHR_NO_INVOICE' => $data["REF_NUMBER"],
                            'CHR_LT' => "LT",
                            'CHR_NPWP' => $data["BIL_VATNO"],
                            'CHR_NAMA' => $data["BT_NAME1"] . " " . $data["BT_NAME2"],
                            'CHR_JALAN' => $data["BT_STREET"] . $data["BT_CITY1"] . " " . $data["BT_STR_SUPPL3"],
                            'CHR_KODE_POS' => $data["BT_POSTL_CODE"],
                            'CHR_NOMOR_TELEPON' => $data["BT_TELNUM"],
                            'CHR_USER_PRINT' => $this->session->userdata('NPK'),
                        );

                        $this->export_m->add_out_header_lt($data_h_lt);

                        foreach ($view_data['LINEDATA'] as $data_line):
                            if ($data["REF_NUMBER"] == $data_line["REF_NUMBER"]) {
                                $i = $i + 1;

                                /*
                                  $objTpl->getActiveSheet()->setCellValue('A'.($i + 4), "OF");
                                  //$objTpl->getActiveSheet()->setCellValue('B'.($i + 4), $data_line["MATERIAL"]);
                                  $objTpl->getActiveSheet()->setCellValueExplicit('B'.($i + 4), $data_line["MATERIAL"], PHPExcel_Cell_DataType::TYPE_STRING);
                                  $objTpl->getActiveSheet()->setCellValue('C'.($i + 4), $data_line["MAT_TEXT"]);
                                  $objTpl->getActiveSheet()->setCellValue('D'.($i + 4), $data_line["UNIT_PRICE"]);
                                  $objTpl->getActiveSheet()->setCellValue('E'.($i + 4), $data_line["QUANTITY"]);
                                  $objTpl->getActiveSheet()->setCellValue('F'.($i + 4), $data_line["LINE_AMOUNT"]);
                                  $objTpl->getActiveSheet()->setCellValue('G'.($i + 4), "0");
                                  $objTpl->getActiveSheet()->setCellValue('H'.($i + 4), round($data_line["LINE_AMOUNT"]));
                                  $objTpl->getActiveSheet()->setCellValue('I'.($i + 4), round( $data_line["LINE_AMOUNT"]  * 0.11 ) );
                                  $objTpl->getActiveSheet()->setCellValue('J'.($i + 4), "0");
                                  $objTpl->getActiveSheet()->setCellValue('K'.($i + 4), "0");
                                 */

                                $data_l = array(
                                    'CHR_NO_INVOICE' => $data_line["REF_NUMBER"],
                                    'CHR_OF' => "OF",
                                    'CHR_KODE_OBJEK' => $data_line["MATERIAL"],
                                    'CHR_NAMA' => $data_line["MAT_TEXT"],
                                    'MON_HARGA_SATUAN' => $data_line["UNIT_PRICE"],
                                    'INT_JUMLAH_BARANG' => round($data_line["QUANTITY"]),
                                    'MON_HARGA_TOTAL' => $data_line["LINE_AMOUNT"],
                                    'MON_DISKON' => "0",
                                    'MON_DPP' => round($data_line["LINE_AMOUNT"]),
                                    'MON_PPN' => round($data_line["LINE_AMOUNT"] * 0.11),
                                    'MON_TARIF_PPNBM' => "0",
                                    'MON_PPNBM' => "0",
                                    'CHR_USER_PRINT' => $this->session->userdata('NPK'),
                                );

                                $this->export_m->add_out_detil($data_l);
                            }
                        endforeach;
                        $i = $i + 1;
                    }

                    $temp_no_faktur = $data["TAXNO"];

                endforeach;
                
                //$view_data = $this->export_m->select_data_out($inv_no_low, $inv_no_high);
                //export to excel
                $i = 1;
                $invs = $this->export_m->findBySql('SELECT DISTINCT CHR_NO_INVOICE
                                                    FROM         TW_EFAKTUR_EXPORT_OUT_HEADER
                                                    WHERE     (CHR_USER_PRINT = "' . $this->session->userdata('NPK') . '") ');

                foreach ($invs as $inv):

                    //FK

                    $header = $this->export_m->findBySql('SELECT * FROM TW_EFAKTUR_EXPORT_OUT_HEADER
                                                        WHERE     (CHR_NO_INVOICE = "' . $inv->CHR_NO_INVOICE . '") ');

                    $objTpl->getActiveSheet()->setCellValue('A' . ($i + 3), trim($header[0]->CHR_FK));
                    $objTpl->getActiveSheet()->setCellValueExplicit('B' . ($i + 3), trim($header[0]->CHR_KD_JENIS_TRANSAKSI), PHPExcel_Cell_DataType::TYPE_STRING);
                    $objTpl->getActiveSheet()->setCellValue('C' . ($i + 3), trim($header[0]->CHR_FG_PENGGANTI));
                    $objTpl->getActiveSheet()->setCellValueExplicit('D' . ($i + 3), trim($header[0]->CHR_NOMOR_FAKTUR), PHPExcel_Cell_DataType::TYPE_STRING);
                    $objTpl->getActiveSheet()->setCellValue('E' . ($i + 3), trim($header[0]->CHR_MASA_PAJAK));
                    $objTpl->getActiveSheet()->setCellValue('F' . ($i + 3), trim($header[0]->CHR_TAHUN_PAJAK));
                    $objTpl->getActiveSheet()->setCellValue('G' . ($i + 3), trim($header[0]->CHR_TANGGAL_FAKTUR));
                    if (trim($header[0]->CHR_NAMA) == "OTHERS PERSON") {
                        $objTpl->getActiveSheet()->setCellValueExplicit('H' . ($i + 3), "000000000000000", PHPExcel_Cell_DataType::TYPE_STRING);
                    } else {
                        $objTpl->getActiveSheet()->setCellValueExplicit('H' . ($i + 3), trim($header[0]->CHR_NPWP), PHPExcel_Cell_DataType::TYPE_STRING);
                    }
                    $objTpl->getActiveSheet()->setCellValue('I' . ($i + 3), trim($header[0]->CHR_NAMA));
                    $objTpl->getActiveSheet()->setCellValue('J' . ($i + 3), trim($header[0]->CHR_ALAMAT_LENGKAP));
                    $objTpl->getActiveSheet()->setCellValue('K' . ($i + 3), $header[0]->MON_JUMLAH_DPP);
                    //$objTpl->getActiveSheet()->setCellValue('L'.($i + 3), $header[0]->MON_JUMLAH_PPN) ;
                    $objTpl->getActiveSheet()->setCellValue('L' . ($i + 3), round($header[0]->MON_JUMLAH_DPP * 0.11));
                    $objTpl->getActiveSheet()->setCellValue('M' . ($i + 3), $header[0]->MON_JUMLAH_PPNBM);
                    $objTpl->getActiveSheet()->setCellValue('N' . ($i + 3), trim($header[0]->CHR_ID_KETERANGAN_TAMBAHAN));
                    $objTpl->getActiveSheet()->setCellValue('O' . ($i + 3), $header[0]->MON_FG_UANG_MUKA);
                    $objTpl->getActiveSheet()->setCellValue('P' . ($i + 3), $header[0]->MON_UANG_MUKA_DPP);
                    $objTpl->getActiveSheet()->setCellValue('Q' . ($i + 3), $header[0]->MON_UANG_MUKA_PPN);
                    $objTpl->getActiveSheet()->setCellValue('R' . ($i + 3), $header[0]->MON_UANG_MUKA_PPNBM);
                    $objTpl->getActiveSheet()->setCellValueExplicit('S' . ($i + 3), $header[0]->CHR_REFERENSI, PHPExcel_Cell_DataType::TYPE_STRING);


                    //FK_LT

                    $i = $i + 1;

                    $header_lt = $this->export_m->findBySql('SELECT * FROM TW_EFAKTUR_EXPORT_OUT_HEADER_LT
                                                        WHERE     (CHR_NO_INVOICE = "' . $inv->CHR_NO_INVOICE . '") ');

                    $objTpl->getActiveSheet()->setCellValue('A' . ($i + 3), trim($header_lt[0]->CHR_LT));
                    if (trim($header[0]->CHR_NAMA) == "OTHERS PERSON") {
                        $objTpl->getActiveSheet()->setCellValueExplicit('B' . ($i + 3), "000000000000000", PHPExcel_Cell_DataType::TYPE_STRING);
                    } else {
                        $objTpl->getActiveSheet()->setCellValueExplicit('B' . ($i + 3), trim($header_lt[0]->CHR_NPWP), PHPExcel_Cell_DataType::TYPE_STRING);
                    }
                    $objTpl->getActiveSheet()->setCellValue('C' . ($i + 3), trim($header_lt[0]->CHR_NAMA));
                    $objTpl->getActiveSheet()->setCellValue('D' . ($i + 3), trim($header_lt[0]->CHR_JALAN));

                    $objTpl->getActiveSheet()->setCellValue('M' . ($i + 3), trim($header_lt[0]->CHR_KODE_POS));
                    $objTpl->getActiveSheet()->setCellValue('N' . ($i + 3), trim($header_lt[0]->CHR_NOMOR_TELEPON));

                    //OF
                    $i = $i + 1;
                    $index = 1;
                    $ppn_temp = 0;
                    $dpp_temp = 0;
                    $detils = $this->export_m->findBySql('SELECT     CHR_OF, CHR_KODE_OBJEK, CHR_NAMA, SUM(MON_HARGA_SATUAN) / COUNT(MON_HARGA_SATUAN) AS MON_HARGA_SATUAN, SUM(INT_JUMLAH_BARANG) AS INT_JUMLAH_BARANG, 
                                                            SUM(MON_HARGA_TOTAL) AS MON_HARGA_TOTAL, SUM(MON_DISKON) AS MON_DISKON, SUM(MON_DPP) AS MON_DPP, SUM(MON_PPN) AS MON_PPN, 
                                                            SUM(MON_TARIF_PPNBM) AS MON_TARIF_PPNBM, SUM(MON_PPNBM) AS MON_PPNBM
                                                              FROM         TW_EFAKTUR_EXPORT_OUT_DETIL
                                                              WHERE     (CHR_NO_INVOICE = "' . $inv->CHR_NO_INVOICE . '")
                                                              GROUP BY CHR_OF, CHR_KODE_OBJEK, CHR_NAMA
                                                              ORDER BY CHR_KODE_OBJEK ');

                    foreach ($detils as $detil):
                        $objTpl->getActiveSheet()->setCellValue('A' . ($i + 3), trim($detil->CHR_OF));
                        $objTpl->getActiveSheet()->setCellValueExplicit('B' . ($i + 3), trim($detil->CHR_KODE_OBJEK), PHPExcel_Cell_DataType::TYPE_STRING);
                        $objTpl->getActiveSheet()->setCellValue('C' . ($i + 3), trim($detil->CHR_NAMA));
                        $objTpl->getActiveSheet()->setCellValue('D' . ($i + 3), $detil->MON_HARGA_SATUAN);
                        $objTpl->getActiveSheet()->setCellValue('E' . ($i + 3), $detil->INT_JUMLAH_BARANG);
                        $objTpl->getActiveSheet()->setCellValue('F' . ($i + 3), $detil->MON_HARGA_TOTAL);
                        $objTpl->getActiveSheet()->setCellValue('G' . ($i + 3), $detil->MON_DISKON);
                        $objTpl->getActiveSheet()->setCellValue('H' . ($i + 3), $detil->MON_DPP);
                        $ppn_temp = $ppn_temp + $detil->MON_DPP;
                        //$objTpl->getActiveSheet()->setCellValue('I'.($i + 3), $detil->MON_PPN );
                        $objTpl->getActiveSheet()->setCellValue('I' . ($i + 3), round($detil->MON_DPP * 0.11));
                        $dpp_temp = $dpp_temp + round($detil->MON_DPP * 0.11);
                        $objTpl->getActiveSheet()->setCellValue('J' . ($i + 3), $detil->MON_TARIF_PPNBM);
                        $objTpl->getActiveSheet()->setCellValue('K' . ($i + 3), $detil->MON_PPNBM);
                        $i = $i + 1;
                        $index = $index + 1;
                    endforeach;

                    //UPDATE PEMBULATAN TOTAL
                    $objTpl->getActiveSheet()->setCellValue('K' . ($i + 3 - 1 - $index ), $ppn_temp);
                    $objTpl->getActiveSheet()->setCellValue('L' . ($i + 3 - 1 - $index ), $dpp_temp);

                    //DELETE ALL TW PRINT
                    $this->export_m->delete_out_header('CHR_NO_INVOICE = "' . $inv->CHR_NO_INVOICE . '"');
                    $this->export_m->delete_out_header_lt('CHR_NO_INVOICE = "' . $inv->CHR_NO_INVOICE . '"');
                    $this->export_m->delete_out_detil('CHR_NO_INVOICE = "' . $inv->CHR_NO_INVOICE . '"');

                endforeach;


                $this->sapconn->close();

                if ($this->input->post('tipe') == 'csv') {

                    $filename = $inv_no_low . ' - ' . $inv_no_high . '.csv'; //just some random filename
                    ob_end_clean();
                    header('Content-Type: application/vnd.ms-excel');
                    header('Content-Disposition: attachment;filename="' . trim($filename) . '"');
                    header('Cache-Control: max-age=0');

                    $objWriter = PHPExcel_IOFactory::createWriter($objTpl, 'CSV');
                    $objWriter->save('php://output');
                    exit();
                } else {

                    $filename = $inv_no_low . ' - ' . $inv_no_high . '.xls'; //just some random filename
                    ob_end_clean();
                    header('Content-Type: application/vnd.ms-excel');
                    header('Content-Disposition: attachment;filename="' . trim($filename) . '"');
                    header('Cache-Control: max-age=0');

                    $objWriter = PHPExcel_IOFactory::createWriter($objTpl, 'Excel5');
                    $objWriter->save('php://output');
                    exit();
                }

                $msg = "<div class = 'alert alert-success'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Downloading success </strong> The data is successfully created </div >";
            }
        }

        $this->session->userdata('user_id');

        $data['content'] = 'efaktur/efaktur_out_v';
        $data['title'] = 'Export Data e-Faktur Keluaran';

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(46);
        $data['news'] = null;

        $data['msg'] = $msg;

        $this->load->view($this->layout, $data);
    }

    public function trial_diff_date() {
        $d1 = new DateTime("30-07-2018");
        $d2 = new DateTime();
        $d3 = $d1->diff($d2);
        $d4 = ($d3->y * 12) + $d3->m;
        echo $d4;
    }

    //http://svc.efaktur.pajak.go.id/validasi/faktur/013107743062000/0082193151936/3031300D060960864801650304020105000420E34D113F16E6BD46085BF3CB1C000B665763C6B39C8ED903B15E6200CDAB0BAC

    public function scan_efaktur_in() {
        $this->role_module_m->authorization('51');
        $msg = "";

        date_default_timezone_set("Asia/Jakarta");
        $date_now = date('Ymd');
        $time_now = sprintf("%06s", date('His'));

        $data['data_view'] = "";
        $data['data_view_detil'] = "";

        if ($this->input->post('no_faktur') != '') {

            $aContext = array(
                'http' => array(
                    // 'proxy' => 'tcp://192.168.0.228:3128',
                    'proxy' => null,
                    'request_fulluri' => true,
                )
            );

            $cxContext = stream_context_create($aContext);
            $feed = file_get_contents($this->input->post('no_faktur'), False, $cxContext);
            $xml = simplexml_load_string($feed);
            $where = "CHR_NO_FAKTUR = '" . $xml->nomorFaktur . "' AND CHR_FG_PENGGANTI = '" . $xml->fgPengganti . "' ";
            $trans = $this->export_m->find_trans('*', $where);

            if (empty($trans)) {
                if ($xml->nomorFaktur <> "") {

                    $tgl_faktur = (string) $xml->tanggalFaktur;
                    $lawan_trans = (string) $xml->namaLawanTransaksi;
                    $npwp_lawan = (string) $xml->npwpLawanTransaksi;

                    //20181029, wildan denny , add function expired date
                    $tgl_faktur = str_replace("/", "-", $tgl_faktur);
                    $d1 = new DateTime($tgl_faktur);
                    $d2 = new DateTime();
                    $d3 = $d1->diff($d2);
                    $d4 = ($d3->y * 12) + $d3->m;
                    //end function expired date
                    if (strpos($lawan_trans, 'AISIN') != true && strpos($lawan_trans, 'Aisin') != true && strpos($lawan_trans, 'aisin') != true) {
                        $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times</button>Data Faktur <strong>invalid</strong>. Lawan transaksi bukan PT. AISIN INDONESIA  </div >";
                    } else if ($npwp_lawan != '010653053055000') {
                        $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times</button>Data Faktur <strong>invalid</strong>. NPWP lawan transaksi bukan atas nama PT. AISIN INDONESIA  </div >";
                    } else if ($d4 >= 3) {
                        $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times</button>Data Faktur <strong>Expired</strong>. Tanggal Faktur Pajak  $tgl_faktur</div >";
                    } else {
                        $data_insert = array(
                            'CHR_KODE_JENIS_TRANS' => (string) $xml->kdJenisTransaksi,
                            'CHR_FG_PENGGANTI' => (string) $xml->fgPengganti,
                            'CHR_NO_FAKTUR' => (string) $xml->nomorFaktur,
                            'CHR_TGL_FAKTUR' => (string) $xml->tanggalFaktur,
                            'CHR_NPWP_PENJUAL' => (string) $xml->npwpPenjual,
                            'CHR_NAMA_PENJUAL' => (string) $xml->namaPenjual,
                            'CHR_ALAMAT_PENJUAL' => (string) $xml->alamatPenjual,
                            'CHR_NPWP_LAWAN_TRANS' => (string) $xml->npwpLawanTransaksi,
                            'CHR_NAMA_LAWAN_TRANS' => (string) $xml->namaLawanTransaksi,
                            'CHR_ALAMAT_LAWAN_TRANS' => (string) $xml->alamatLawanTransaksi,
                            'MON_JML_DPP' => $xml->jumlahDpp,
                            'MON_JML_PPN' => $xml->jumlahPpn,
                            'MON_JML_PPNBM' => $xml->jumlahPpnBm,
                            'CHR_STATUS_APP' => (string) $xml->statusApproval,
                            'CHR_STATUS_FAKTUR' => (string) $xml->statusFaktur,
                            'CHR_USER_ENTRY' => $this->session->userdata('NPK'),
                            'CHR_DATE_ENTRY' => $date_now,
                            'CHR_TIME_ENTRY' => $time_now,
                        );

                        $this->export_m->add_trans($data_insert);

                        foreach ($xml->detailTransaksi as $detailTransaksi) {

                            $data_insert_detil = array(
                                'CHR_FG_PENGGANTI' => (string) $xml->fgPengganti,
                                'CHR_NO_FAKTUR' => (string) $xml->nomorFaktur,
                                'CHR_NAMA_TRANS' => (string) $detailTransaksi->nama,
                                'MON_HARGA_SATUAN' => $detailTransaksi->hargaSatuan,
                                'INT_JUMLAH_BARANG' => $detailTransaksi->jumlahBarang,
                                'MON_HARGA_TOTAL' => $detailTransaksi->hargaTotal,
                                'MON_DISKON' => $detailTransaksi->diskon,
                                'MON_DPP' => $detailTransaksi->dpp,
                                'MON_PPN' => $detailTransaksi->ppn,
                                'MON_TARIF_PPNBM' => $detailTransaksi->tarifPpnbm,
                                'MON_PPNBM' => $detailTransaksi->ppnbm,
                            );

                            $this->export_m->add_trans_detil($data_insert_detil);
                        }

                        $data['data_view'] = $this->export_m->find_trans("*", " CHR_NO_FAKTUR = '" . $xml->nomorFaktur . "' AND CHR_FG_PENGGANTI = '" . $xml->fgPengganti . "' ");
                        $data['data_view_detil'] = $this->export_m->find_trans_detil("*", " CHR_NO_FAKTUR = '" . $xml->nomorFaktur . "' AND CHR_FG_PENGGANTI = '" . $xml->fgPengganti . "' ");

                        $msg = "<div class = 'alert alert-success'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times</button>The data is <strong>successfully created</strong> </div >";
                    }
                } else {

                    $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times</button>Data Faktur <strong>invalid</strong>. Please check No Faktur  </div >";
                }
            } else {
                $data['data_view'] = $this->export_m->find_trans("*", " CHR_NO_FAKTUR = '" . $xml->nomorFaktur . "' AND CHR_FG_PENGGANTI = '" . $xml->fgPengganti . "' ");
                $data['data_view_detil'] = $this->export_m->find_trans_detil("*", " CHR_NO_FAKTUR = '" . $xml->nomorFaktur . "' AND CHR_FG_PENGGANTI = '" . $xml->fgPengganti . "' ");

                $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times</button>Data Faktur <strong>already exist</strong>. Please check No Faktur</div >";
            }
        }

        $this->session->userdata('user_id');

        $data['content'] = 'efaktur/scan_efaktur_in_v';
        $data['title'] = 'Scan Data e-Faktur Masukan';

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(51);
        $data['news'] = null;

        $data['msg'] = $msg;

        // exit();
        $this->load->view($this->layout, $data);
    }

    public function scan_efaktur_in_view() {
        $this->role_module_m->authorization('63');
        $msg = "";

        date_default_timezone_set("Asia/Jakarta");
        $date_now = date('Ymd');
        $time_now = sprintf("%06s", date('His'));

        $data['data_view'] = "";
        $data['data_view_detil'] = "";

        if ($this->input->post('no_faktur') != '') {

            $aContext = array(
                'http' => array(
                    // 'proxy' => 'tcp://192.168.0.228:3128',
                    'proxy' => null,
                    'request_fulluri' => true,
                ),
            );

            $cxContext = stream_context_create($aContext);
            $feed = file_get_contents($this->input->post('no_faktur'), False, $cxContext);
            $xml = simplexml_load_string($feed);

            $objTpl = PHPExcel_IOFactory::load("./assets/template/efaktur_in_view.xlt");
            //$objTpl = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');;
            $objTpl->setActiveSheetIndex(0);

            $i = 2;
            if ($xml->nomorFaktur <> "") {

                $objTpl->getActiveSheet()->setCellValueExplicit('A' . ($i + 1), (string) $xml->kdJenisTransaksi, PHPExcel_Cell_DataType::TYPE_STRING);
                $objTpl->getActiveSheet()->setCellValueExplicit('B' . ($i + 1), (string) $xml->fgPengganti, PHPExcel_Cell_DataType::TYPE_STRING);
                $objTpl->getActiveSheet()->setCellValueExplicit('C' . ($i + 1), (string) $xml->nomorFaktur, PHPExcel_Cell_DataType::TYPE_STRING);
                $objTpl->getActiveSheet()->setCellValueExplicit('D' . ($i + 1), (string) $xml->tanggalFaktur, PHPExcel_Cell_DataType::TYPE_STRING);
                $objTpl->getActiveSheet()->setCellValueExplicit('E' . ($i + 1), (string) $xml->npwpPenjual, PHPExcel_Cell_DataType::TYPE_STRING);
                $objTpl->getActiveSheet()->setCellValueExplicit('F' . ($i + 1), (string) $xml->namaPenjual, PHPExcel_Cell_DataType::TYPE_STRING);
                $objTpl->getActiveSheet()->setCellValueExplicit('G' . ($i + 1), (string) $xml->alamatPenjual, PHPExcel_Cell_DataType::TYPE_STRING);
                $objTpl->getActiveSheet()->setCellValueExplicit('H' . ($i + 1), (string) $xml->npwpLawanTransaksi, PHPExcel_Cell_DataType::TYPE_STRING);
                $objTpl->getActiveSheet()->setCellValueExplicit('I' . ($i + 1), (string) $xml->namaLawanTransaksi, PHPExcel_Cell_DataType::TYPE_STRING);
                $objTpl->getActiveSheet()->setCellValueExplicit('J' . ($i + 1), (string) $xml->alamatLawanTransaksi, PHPExcel_Cell_DataType::TYPE_STRING);
                $objTpl->getActiveSheet()->setCellValue('K' . ($i + 1), $xml->jumlahDpp);
                $objTpl->getActiveSheet()->setCellValue('L' . ($i + 1), $xml->jumlahPpn);
                $objTpl->getActiveSheet()->setCellValue('M' . ($i + 1), $xml->jumlahPpnBm);
                $objTpl->getActiveSheet()->setCellValueExplicit('N' . ($i + 1), (string) $xml->statusApproval, PHPExcel_Cell_DataType::TYPE_STRING);
                $objTpl->getActiveSheet()->setCellValueExplicit('O' . ($i + 1), (string) $xml->statusFaktur, PHPExcel_Cell_DataType::TYPE_STRING);


                $i = $i + 4;
                foreach ($xml->detailTransaksi as $detailTransaksi) {

                    $objTpl->getActiveSheet()->setCellValueExplicit('A' . ($i + 1), (string) $xml->nomorFaktur, PHPExcel_Cell_DataType::TYPE_STRING);
                    $objTpl->getActiveSheet()->setCellValueExplicit('B' . ($i + 1), (string) $detailTransaksi->nama, PHPExcel_Cell_DataType::TYPE_STRING);
                    $objTpl->getActiveSheet()->setCellValue('C' . ($i + 1), $detailTransaksi->hargaSatuan);
                    $objTpl->getActiveSheet()->setCellValue('D' . ($i + 1), $detailTransaksi->jumlahBarang);
                    $objTpl->getActiveSheet()->setCellValue('E' . ($i + 1), $detailTransaksi->hargaTotal);
                    $objTpl->getActiveSheet()->setCellValue('F' . ($i + 1), $detailTransaksi->diskon);
                    $objTpl->getActiveSheet()->setCellValue('G' . ($i + 1), $detailTransaksi->dpp);
                    $objTpl->getActiveSheet()->setCellValue('H' . ($i + 1), $detailTransaksi->ppn);
                    $objTpl->getActiveSheet()->setCellValue('I' . ($i + 1), $detailTransaksi->tarifPpnbm);
                    $objTpl->getActiveSheet()->setCellValue('J' . ($i + 1), $detailTransaksi->ppnbm);

                    $i = $i + 1;
                }

                $filename = 'view_efaktur_masukan.xls'; //just some random filename
                ob_end_clean();
                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename="' . trim($filename) . '"');
                header('Cache-Control: max-age=0');

                $objWriter = PHPExcel_IOFactory::createWriter($objTpl, 'Excel5');
                $objWriter->save('php://output');
                //redirect($this->uri->uri_string());
                exit();


                $msg = "<div class = 'alert alert-success'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button>The data is successfully created </div >";
            } else {
                $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button>Data Faktur invalid  </div >";
            }
        }

        $this->session->userdata('user_id');

        $data['content'] = 'efaktur/scan_efaktur_in_v';
        $data['title'] = 'Scan Data e-Faktur Masukan';

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(63);
        $data['news'] = null;

        $data['msg'] = $msg;

        $this->load->view($this->layout, $data);
    }

    public function efaktur_in_scan() {
        $this->role_module_m->authorization('53');
        $msg = "";

        if ($this->input->post('btn_export') != '') {

            $zuonr_low = $this->input->post('ZUONR_LOW');
            $zuonr_high = $this->input->post('ZUONR_HIGH');
            $budat_low = substr($this->input->post('BUDAT_LOW'), 4, 4) . substr($this->input->post('BUDAT_LOW'), 2, 2) . substr($this->input->post('BUDAT_LOW'), 0, 2);
            $budat_high = substr($this->input->post('BUDAT_HIGH'), 4, 4) . substr($this->input->post('BUDAT_HIGH'), 2, 2) . substr($this->input->post('BUDAT_HIGH'), 0, 2);
            $supplier = $this->input->post('SUPP');

            $tgl_faktur_mm = $this->input->post('TGL_FAKTUR_MM');
            $tgl_faktur_yyyy = $this->input->post('TGL_FAKTUR_YYYY');

            if ($zuonr_low == "" && $zuonr_high == "" && $budat_low == "" && $budat_high == "" && $supplier == "" && $tgl_faktur_mm == "" && $tgl_faktur_yyyy == "") {
                $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button>Please fill a field </div >";
            } else {

                $objTpl = PHPExcel_IOFactory::load("./assets/template/efaktur_in.xlt");
                $objTpl->setActiveSheetIndex(0);

                if ($zuonr_low != "" || $zuonr_high != "") {
                    $where = 'CHR_NO_FAKTUR = "' . $zuonr_low . '" ';
                    if ($zuonr_high != "") {
                        $where = 'CHR_NO_FAKTUR BETWEEN "' . $zuonr_low . '" AND "' . $zuonr_high . '" ';
                    }
                }

                if ($budat_low != "" || $budat_high != "") {
                    $where = 'CHR_DATE_ENTRY = "' . $budat_low . '" ';
                    if ($budat_high != "") {
                        $where = 'CHR_DATE_ENTRY BETWEEN "' . $budat_low . '" AND "' . $budat_high . '" ';
                    }
                }

                if ($tgl_faktur_mm != "" || $tgl_faktur_yyyy != "") {
                    $where = 'CHR_TGL_FAKTUR LIKE "%' . $tgl_faktur_mm . '/' . $tgl_faktur_yyyy . '%" ';
                }

                if ($supplier != "") {
                    $where = 'CHR_NAMA_PENJUAL LIKE "%' . $supplier . '%" ';
                }

                //echo $where; exit();
                $view_data = $this->export_m->find_trans('*', $where, '');

                $i = 1;
                foreach ($view_data as $data):


                    $objTpl->getActiveSheet()->setCellValue('A' . ($i + 1), "FM");
                    $objTpl->getActiveSheet()->setCellValueExplicit('B' . ($i + 1), $data->CHR_KODE_JENIS_TRANS, PHPExcel_Cell_DataType::TYPE_STRING);
                    //$objTpl->getActiveSheet()->setCellValue('B'.($i + 1), $data->CHR_KODE_JENIS_TRANS);
                    $objTpl->getActiveSheet()->setCellValue('C' . ($i + 1), $data->CHR_FG_PENGGANTI);

                    $objTpl->getActiveSheet()->setCellValueExplicit('D' . ($i + 1), TRIM($data->CHR_NO_FAKTUR), PHPExcel_Cell_DataType::TYPE_STRING);
                    $objTpl->getActiveSheet()->setCellValue('E' . ($i + 1), substr($data->CHR_TGL_FAKTUR, 3, 2));
                    $objTpl->getActiveSheet()->setCellValue('F' . ($i + 1), substr($data->CHR_TGL_FAKTUR, 6, 4));

                    $objTpl->getActiveSheet()->setCellValue('G' . ($i + 1), $data->CHR_TGL_FAKTUR);

                    $objTpl->getActiveSheet()->setCellValueExplicit('H' . ($i + 1), $data->CHR_NPWP_PENJUAL, PHPExcel_Cell_DataType::TYPE_STRING);
                    $objTpl->getActiveSheet()->setCellValue('I' . ($i + 1), $data->CHR_NAMA_PENJUAL);
                    $objTpl->getActiveSheet()->setCellValue('J' . ($i + 1), $data->CHR_ALAMAT_PENJUAL);
                    $objTpl->getActiveSheet()->setCellValue('K' . ($i + 1), round($data->MON_JML_DPP));
                    $objTpl->getActiveSheet()->setCellValue('L' . ($i + 1), round($data->MON_JML_PPN));
                    $objTpl->getActiveSheet()->setCellValue('M' . ($i + 1), round($data->MON_JML_PPNBM));
                    $objTpl->getActiveSheet()->setCellValue('N' . ($i + 1), "1");
                    $objTpl->getActiveSheet()->setCellValue('O' . ($i + 1), $data->CHR_USER_ENTRY);
                    $objTpl->getActiveSheet()->setCellValue('P' . ($i + 1), $data->CHR_DATE_ENTRY);
                    $objTpl->getActiveSheet()->setCellValue('Q' . ($i + 1), $data->CHR_TIME_ENTRY);


                    $i = $i + 1;
                endforeach;

                if ($this->input->post('tipe') == 'csv') {

                    $filename = 'Report_efaktur_masukan.csv'; //just some random filename
                    ob_end_clean();
                    header('Content-Type: application/vnd.ms-excel');
                    header('Content-Disposition: attachment;filename="' . trim($filename) . '"');
                    header('Cache-Control: max-age=0');

                    $objWriter = PHPExcel_IOFactory::createWriter($objTpl, 'CSV');
                    $objWriter->save('php://output');
                    exit();
                } else {

                    $filename = 'Report_efaktur_masukan.xls'; //just some random filename
                    ob_end_clean();
                    header('Content-Type: application/vnd.ms-excel');
                    header('Content-Disposition: attachment;filename="' . trim($filename) . '"');
                    header('Cache-Control: max-age=0');

                    $objWriter = PHPExcel_IOFactory::createWriter($objTpl, 'Excel5');
                    $objWriter->save('php://output');
                    exit();
                }

                $msg = "<div class = 'alert alert-success'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Downloading success </strong> The data is successfully created </div >";
            }
        }

        $this->session->userdata('user_id');

        $data['content'] = 'efaktur/efaktur_in_scan_v';
        $data['title'] = 'Export Data e-Faktur Masukan by Scan';

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(53);
        $data['news'] = null;

        $data['msg'] = $msg;

        $this->load->view($this->layout, $data);
    }

}
