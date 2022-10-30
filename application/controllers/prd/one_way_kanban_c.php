<?php

//Add By bugsMaker 20170812
class one_way_kanban_c extends CI_Controller
{

    private $layout = '/template/head';
    private $back_to_index = '/prd/one_way_kanban_c/';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('part/part_m');
        $this->load->model('prd/one_way_kanban_m');
        $this->load->model('prd/setup_chute_m');
        $this->load->model('organization/dept_m');
        $this->load->model('prd/direct_backflush_general_m');
    }

    function index()
    {
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(65);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'One Way Kanban';

        $id_dept = $this->dept_m->get_top_prod_dept()->row()->INT_ID_DEPT;
        $work_center = $this->direct_backflush_general_m->get_top_work_center_by_id_dept($id_dept);
        $all_dept_prod = $this->dept_m->get_all_prod_dept();
        $all_work_centers = $this->direct_backflush_general_m->get_work_center_by_id_dept($id_dept);
        $date = date('Ymd');

        $user_session = $this->session->all_userdata();
        $role = $user_session['ROLE'];
        $data['role'] = $role;
        $data['npk'] = $user_session['NPK'];

        $data['all_dept_prod'] = $all_dept_prod;
        $data['all_work_centers'] = $all_work_centers;
        $data['work_center'] = $work_center;
        $data['id_dept'] = $id_dept;
        $data['date'] = $date;

        $data['data'] = $this->one_way_kanban_m->get_detail_one_way_kanban_by_date_and_work_center($work_center, $date);

        $data['content'] = 'prd/one_way_kanban/one_way_kanban_v';
        $this->load->view($this->layout, $data);
    }

    function search_one_way_kanban($id_dept = NULL, $work_center = NULL, $date = NULL)
    {

        if ($date == NULL) {
            $date = date('Ymd');
        }

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(65);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'One Way Kanban';

        if ($id_dept == NULL || $id_dept == '') {
            $id_dept = '21';
        }

        if ($work_center == NULL) {
            $work_center = $this->direct_backflush_general_m->get_top_work_center_by_id_dept($id_dept);
        }

        $all_dept_prod = $this->dept_m->get_all_prod_dept();
        $all_work_centers = $this->direct_backflush_general_m->get_work_center_by_id_dept($id_dept);

        $user_session = $this->session->all_userdata();
        $role = $user_session['ROLE'];
        $data['role'] = $role;
        $data['npk'] = $user_session['NPK'];

        $data['all_dept_prod'] = $all_dept_prod;
        $data['all_work_centers'] = $all_work_centers;
        $data['work_center'] = $work_center;
        $data['id_dept'] = $id_dept;
        $data['date'] = $date;

        $data['data'] = $this->one_way_kanban_m->get_detail_one_way_kanban_by_date_and_work_center($work_center, $date);

        $data['content'] = 'prd/one_way_kanban/one_way_kanban_v';
        $this->load->view($this->layout, $data);
    }

    function print_kanban($order_no = null, $wcenter = null, $serial_no = null)
    {
        $date = substr($order_no, 6, 8);
        $order_no = substr($order_no, 0, 6) . '/' . substr($order_no, 6, 8) . '/' . substr($order_no, 14, 3);

        if ($wcenter == null) {
            $wcenter = substr($order_no, 0, 6);
        }


        $data_kanban = $this->db->query("SELECT TOP 1 A.CHR_SERIAL, A.CHR_PART_NO, A.CHR_BACK_NO, A.INT_LOT_SIZE, A.INT_QTY_PER_BOX, A.INT_QTY_PCS, A.CHR_CREATED_DATE,
                    B.CHR_BOX_TYPE, B.CHR_SLOC_FROM, B.CHR_SLOC_TO, B.CHR_RAKNO,
                    C.CHR_PART_NAME,
                    D.CHR_CUS_PART_NO, D.CHR_CUS_NO
                FROM PRD.TT_ONE_WAY_KANBAN A 
                LEFT JOIN TM_KANBAN B ON A.CHR_PART_NO = B.CHR_PART_NO AND A.CHR_BACK_NO = B.CHR_BACK_NO
                LEFT JOIN TM_PARTS C ON A.CHR_PART_NO = C.CHR_PART_NO
                LEFT JOIN TM_SHIPPING_PARTS D ON A.CHR_PART_NO = D.CHR_PART_NO
                WHERE A.CHR_WORK_CENTER = '$wcenter' AND A.CHR_PRD_ORDER_NO = '$order_no' AND A.CHR_SERIAL = '$serial_no' AND B.CHR_KANBAN_TYPE IN ('1','5')
                ORDER BY CHR_SERIAL ASC, B.CHR_KANBAN_TYPE DESC");
        if ($data_kanban->num_rows() > 0) {
            $data = $data_kanban->row();
            $part_no = $data->CHR_PART_NO;
            $back_no = $data->CHR_BACK_NO;
            $lot_size = $data->INT_LOT_SIZE;
            $qty_per_box = $data->INT_QTY_PER_BOX;
            $qty_pcs = $data->INT_QTY_PCS;
            $box_type = trim($data->CHR_BOX_TYPE);
            $part_name = $data->CHR_PART_NAME;
            $part_no_cust = trim($data->CHR_CUS_PART_NO);
            $sloc_from = trim($data->CHR_SLOC_FROM);
            $sloc_to = trim($data->CHR_SLOC_TO);
            $cust_no = trim($data->CHR_CUS_NO);
            $rack_no = trim($data->CHR_RAKNO);

            if ($serial_no == null) {
                $serial_no = $data->CHR_SERIAL;
            }

            $cek_add_info = $this->setup_chute_m->get_additional_info_kanban($part_no);
            $add_info = '';
            if ($cek_add_info->num_rows() > 0) {
                $add_info = $cek_add_info->row()->CHR_KANBAN_ADDITIONAL_INFO;
            }

            $this->load->library('ciqrcode');
            $params['data'] = "$order_no $serial_no $part_no $qty_per_box $part_no_cust $add_info";
            $params['level'] = 'B';
            $params['size'] = 2;
            $params['savename'] = 'assets/file/qrcode_prd/' . str_replace("/", "", $order_no) . '_' . $back_no . '_' . $serial_no . '.png';
            $this->ciqrcode->generate($params);


            //            $out = "$wcenter|$order_no|$part_no|$back_no|$serial_no|$part_no_cust|$lot_size|$qty_per_box|$box_type|$sloc_from|$sloc_to|$cust_no|$part_name";
            //                print_r($out);
            //                exit();

            // $fp = fsockopen("172.16.6.23", 1234, $errno, $errstr, 30);
            // $fp = fsockopen("172.16.31.52", 1234, $errno, $errstr, 30); //=== Laptop ANU
            if($wcenter == 'ASHV01'){
                $fp = fsockopen("192.168.0.204", 1234, $errno, $errstr, 30); //=== LIVE IP
            } else {
                $fp = fsockopen("192.168.0.223", 1234, $errno, $errstr, 30); //=== LIVE IP
            }

            if (!$fp) {
                echo "Tidak bisa akses ke print server, silahkan hubungi MIS <br>";
            } else {

                //Update modified by manual print
                // $this->one_way_kanban_m->update_printed_one_way_kanban($wcenter, $order_no, $serial_no);

                $out = "OK|$order_no|$part_no|$back_no|$serial_no|$part_no_cust|$lot_size|$qty_per_box|$box_type|$sloc_from|$sloc_to|$cust_no|$part_name|$rack_no";
                fwrite($fp, $out);
            }

            fclose($fp);

            $id_dept = $this->direct_backflush_general_m->get_prod_by_work_center($wcenter);
            //$date = $data->CHR_CREATED_DATE;

            redirect('prd/one_way_kanban_c/search_one_way_kanban/' . $id_dept . '/' . $wcenter . '/' . $date);
        } else {
            print_r("DATA KANBAN TIDAK TERSEDIA");
            exit();
        }
    }

    function print_special($msg = NULL)
    {
        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Printing success </strong> Kanban is successfully printed </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Printing error !</strong> Something error with parameter </div >";
        } else {
            $msg = NULL;
        }

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(65);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Print Special';
        $data['msg'] = $msg;

        $data['content'] = 'prd/one_way_kanban/print_special_v';
        $this->load->view($this->layout, $data);
    }

    function print_recovery_one_way($work_center = NULL, $prod_order_no = NULL, $serial = NULL)
    {
        //$prod_order_no = str_replace("-","/",$prod_order_no);
        $prod_order_no = $this->input->post('PRD_ORDER_NO');
        $serial = $this->input->post('SERIAL');
        if ($work_center == NULL) {
            $work_center = substr($prod_order_no, 0, 6);
        }
        // print_r($work_center);
        // exit();

        $data_kbn = $this->setup_chute_m->get_setup_chute_for_one_way_kanban($work_center, $prod_order_no);

        $part_no = trim($data_kbn->CHR_PART_NO);
        $back_no = $data_kbn->CHR_BACK_NO;
        $lot_size = $data_kbn->INT_LOT_SIZE;
        $qty_per_box = trim($data_kbn->INT_QTY_PER_BOX);
        $qty_pcs = $data_kbn->INT_QTY_PCS;
        $box_type = $data_kbn->CHR_BOX_TYPE;
        $part_name = $data_kbn->CHR_PART_NAME;
        $part_no_cust = trim($data_kbn->CHR_CUS_PART_NO);
        $sloc_from = $data_kbn->CHR_SLOC_FROM;
        $sloc_to = $data_kbn->CHR_SLOC_TO;
        $cust_no = $data_kbn->CHR_CUS_NO;
        $rack_no = $data_kbn->CHR_RAKNO;

        $cek_add_info = $this->setup_chute_m->get_additional_info_kanban($part_no);
        $add_info = '';
        if ($cek_add_info->num_rows() > 0) {
            $add_info = $cek_add_info->row()->CHR_KANBAN_ADDITIONAL_INFO;
        }

        if ($serial == NULL) {
            //Insert to table one way kanban, loop depend on lot size
            for ($i = 1; $i <= $lot_size; $i++) {
                $serial = sprintf('%05u', $i);

                $this->load->library('ciqrcode');
                $params['data'] = "$prod_order_no $serial $part_no $qty_per_box $part_no_cust $add_info";
                $params['level'] = 'B';
                $params['size'] = 2;
                $params['savename'] = 'assets/file/qrcode_prd/' . str_replace("/", "", $prod_order_no) . '_' . $back_no . '_' . $serial . '.png';
                $this->ciqrcode->generate($params);

                // $fp = fsockopen("172.16.51.152", 1234, $errno, $errstr, 30); //=== Laptop ANU
                // $fp = fsockopen("172.16.6.15", 1234, $errno, $errstr, 30); //=== Laptop SAN
                if($work_center == 'ASHV01'){
                    $fp = fsockopen("192.168.0.204", 1234, $errno, $errstr, 30); //=== LIVE IP
                } else {
                    $fp = fsockopen("192.168.0.223", 1234, $errno, $errstr, 30); //=== LIVE IP
                }                

                if (!$fp) {
                    echo "Tidak bisa akses ke print server, silahkan hubungi MIS <br>";
                    redirect('prd/one_way_kanban_c/print_special/2');
                } else {
                    //$out = "OK|$prod_order_no|$part_no|$back_no|00002|$part_no_cust|$lot_size|$qty_per_box|$box_type|$sloc_from|$sloc_to|$cust_no|$part_name|$rack_no";
                    $out = "OK|$prod_order_no|$part_no|$back_no|$serial|$part_no_cust|$lot_size|$qty_per_box|$box_type|$sloc_from|$sloc_to|$cust_no|$part_name|$rack_no";
                    fwrite($fp, $out);

                    fclose($fp);
                }
            }
            redirect('prd/one_way_kanban_c/print_special/1');
        } else {
            // $serial = sprintf('%05u', $i);                   

            $this->load->library('ciqrcode');
            $params['data'] = "$prod_order_no $serial $part_no $qty_per_box $part_no_cust $add_info";
            $params['level'] = 'B';
            $params['size'] = 2;
            $params['savename'] = 'assets/file/qrcode_prd/' . str_replace("/", "", $prod_order_no) . '_' . $back_no . '_' . $serial . '.png';
            $this->ciqrcode->generate($params);

            // $fp = fsockopen("172.16.51.152", 1234, $errno, $errstr, 30); //=== Laptop ANU
            // $fp = fsockopen("172.16.6.15", 1234, $errno, $errstr, 30); //=== Laptop SAN
            if($work_center == 'ASHV01'){
                $fp = fsockopen("192.168.0.204", 1234, $errno, $errstr, 30); //=== LIVE IP
            } else {
                $fp = fsockopen("192.168.0.223", 1234, $errno, $errstr, 30); //=== LIVE IP
            }

            if (!$fp) {
                echo "Tidak bisa akses ke print server, silahkan hubungi MIS <br>";
                redirect('prd/one_way_kanban_c/print_special/2');
            } else {
                //$out = "OK|$prod_order_no|$part_no|$back_no|00002|$part_no_cust|$lot_size|$qty_per_box|$box_type|$sloc_from|$sloc_to|$cust_no|$part_name|$rack_no";
                $out = "OK|$prod_order_no|$part_no|$back_no|$serial|$part_no_cust|$lot_size|$qty_per_box|$box_type|$sloc_from|$sloc_to|$cust_no|$part_name|$rack_no";
                fwrite($fp, $out);

                fclose($fp);

                redirect('prd/one_way_kanban_c/print_special/1');
            }
        }
    }

    public function reprintKanban()
    {
        $work_center = $this->input->post('work_center');
        $prod_order_no = $this->input->post('prod_order_no');
        $json_data['status'] = false;

        $data = $this->one_way_kanban_m->get_one_way_kanban_data_by_order_no($prod_order_no, $work_center);
        if ($data) {
            $part_no = trim($data->CHR_PART_NO);
            $back_no = $data->CHR_BACK_NO;
            $lot_size = $data->INT_LOT_SIZE;
            $qty_per_box = $data->INT_QTY_PER_BOX;
            $qty_pcs = $data->INT_QTY_PCS;
            $box_type = $data->CHR_BOX_TYPE;
            $part_name = $data->CHR_PART_NAME;
            $part_no_cust = trim($data->CHR_CUS_PART_NO);
            $sloc_from = $data->CHR_SLOC_FROM;
            $sloc_to = $data->CHR_SLOC_TO;
            $cust_no = $data->CHR_CUS_NO;
            $serial_no = $data->CHR_SERIAL;
            $rack_no = $data->CHR_RAKNO;

            if($work_center == 'ASHV01'){
                $fp = fsockopen("192.168.0.204", 1234, $errno, $errstr, 30); //=== LIVE IP
            } else {
                $fp = fsockopen("192.168.0.223", 1234, $errno, $errstr, 30); //=== LIVE IP
            }

            if (!$fp) {
                $json_data['message'] =  $errno . ' - ' . $errstr;
            } else {
                $out = "OK|$prod_order_no|$part_no|$back_no|$serial_no|$part_no_cust|$lot_size|$qty_per_box|$box_type|$sloc_from|$sloc_to|$cust_no|$part_name|$rack_no";
                fwrite($fp, $out);
                $json_data['status'] = true;
                fclose($fp);
            }
        } else {
            $json_data['message'] = 'Data kanban tidak ter-create.';
        }

        echo json_encode($json_data);
    }

    //Loop3r 202201
    public function CheckScanOneWayKanban($barcode)
    {
        $data = array('status' => true);

        $barcode = str_replace("-", "/", $barcode);
        $barcode = str_replace("-", "/", $barcode);
        $barcode = str_replace("%20%20%20%20%20%20", " ", $barcode);
        $barcode = str_replace("%20%20%20%20%20", " ", $barcode);
        $barcode = str_replace("%20%20%20", " ", $barcode);
        $barcode = str_replace("%20%20", " ", $barcode);
        $barcode = str_replace("%20", " ", $barcode);

        $dataSerial = explode(" ", $barcode);

        if (count($dataSerial) == 4 || count($dataSerial) == 5) {

            $compare_ord_no = $this->setup_chute_m->compareOrderNoRunning($dataSerial[0]);

            if ($compare_ord_no) {

                $data_kanban = $this->one_way_kanban_m->get_history_scan_kanban_by_order_no($dataSerial[0], $dataSerial[1]);

                if ($data_kanban) {
                    $data['status'] = false;
                } else {
                    $data['message'] = "Kanban " . $dataSerial[0] . " dengan serial " . $dataSerial[1] . " Sudah pernah dipindai";
                }
            } else {
                $data['message'] = "Kanban dengan order no " . $dataSerial[0] . " tidak sesuai dengan yang sedang didandori";
            }
        } else {
            $data['message'] = "Salah memindai kanban, pastikan one way kanban yang dipindai - " . $barcode;
        }

        echo json_encode($data);
    }

    //Loop3r 202201
    public function getLabelOneWayKanban()
    {
        $id_setup_chute = trim($this->input->post('id_setup_chute'));

        $history = $this->one_way_kanban_m->get_label_one_way_by_id_setup_chute($id_setup_chute);

        $data = '';

        if ($history->num_rows() > 0) {
            $data .= "<table>";
        } else {
            $data = 'NO DATA ONE WAY KANBAN';
        }

        if ($history->num_rows() > 0 && $history->num_rows() < 11) {
            $x = 0;
            $data .= "<tr>";
            foreach ($history->result() as $value) {
                $data .= "<td>$value->CHR_SERIAL</td>";
                $x++;
            }
            $data .= "</tr>";
        } else if ($history->num_rows() > 10 && $history->num_rows() < 21) {
            $x = 0;
            foreach ($history->result() as $value) {
                $x++;
                if ($x > 0 && $x < 11) {
                    if ($x == 1) {
                        $data .= "<tr><td>$value->CHR_SERIAL</td>";
                    } else if ($x == 10) {
                        $data .= "<td>$value->CHR_SERIAL</td></tr>";
                    } else {
                        $data .= "<td>$value->CHR_SERIAL</td>";
                    }
                } else {
                    if ($x == 11) {
                        $data .= "<tr><td>$value->CHR_SERIAL</td>";
                    } else if ($x == $history->num_rows()) {
                        $data .= "<td>$value->CHR_SERIAL</td></tr>";
                    } else {
                        $data .= "<td>$value->CHR_SERIAL</td>";
                    }
                }
            }
        } else if ($history->num_rows() > 20 && $history->num_rows() < 31) {
            $x = 0;
            foreach ($history->result() as $value) {
                $x++;
                if ($x > 0 && $x < 11) {
                    if ($x == 1) {
                        $data .= "<tr><td>$value->CHR_SERIAL</td>";
                    } else if ($x == 10) {
                        $data .= "<td>$value->CHR_SERIAL</td></tr>";
                    } else {
                        $data .= "<td>$value->CHR_SERIAL</td>";
                    }
                } else if ($x > 10 && $x < 21) {
                    if ($x == 11) {
                        $data .= "<tr><td>$value->CHR_SERIAL</td>";
                    } else if ($x == 20) {
                        $data .= "<td>$value->CHR_SERIAL</td></tr>";
                    } else {
                        $data .= "<td>$value->CHR_SERIAL</td>";
                    }
                } else {
                    if ($x == 21) {
                        $data .= "<tr><td>$value->CHR_SERIAL</td>";
                    } else if ($x == $history->num_rows()) {
                        $data .= "<td>$value->CHR_SERIAL</td></tr>";
                    } else {
                        $data .= "<td>$value->CHR_SERIAL</td>";
                    }
                }
            }
        } else if ($history->num_rows() > 30 && $history->num_rows() < 41) {
            $x = 0;
            foreach ($history->result() as $value) {
                $x++;
                if ($x > 0 && $x < 11) {
                    if ($x == 1) {
                        $data .= "<tr><td>$value->CHR_SERIAL</td>";
                    } else if ($x == 10) {
                        $data .= "<td>$value->CHR_SERIAL</td></tr>";
                    } else {
                        $data .= "<td>$value->CHR_SERIAL</td>";
                    }
                } else if ($x > 10 && $x < 21) {
                    if ($x == 11) {
                        $data .= "<tr><td>$value->CHR_SERIAL</td>";
                    } else if ($x == 20) {
                        $data .= "<td>$value->CHR_SERIAL</td></tr>";
                    } else {
                        $data .= "<td>$value->CHR_SERIAL</td>";
                    }
                } else if ($x > 20 && $x < 31) {
                    if ($x == 21) {
                        $data .= "<tr><td>$value->CHR_SERIAL</td>";
                    } else if ($x == 30) {
                        $data .= "<td>$value->CHR_SERIAL</td></tr>";
                    } else {
                        $data .= "<td>$value->CHR_SERIAL</td>";
                    }
                } else {
                    if ($x == 31) {
                        $data .= "<tr><td>$value->CHR_SERIAL</td>";
                    } else if ($x == $history->num_rows()) {
                        $data .= "<td>$value->CHR_SERIAL</td></tr>";
                    } else {
                        $data .= "<td>$value->CHR_SERIAL</td>";
                    }
                }
            }
        } else if ($history->num_rows() > 40 && $history->num_rows() < 51) {
            $x = 0;
            foreach ($history->result() as $value) {
                $x++;
                if ($x > 0 && $x < 11) {
                    if ($x == 1) {
                        $data .= "<tr><td>$value->CHR_SERIAL</td>";
                    } else if ($x == 10) {
                        $data .= "<td>$value->CHR_SERIAL</td></tr>";
                    } else {
                        $data .= "<td>$value->CHR_SERIAL</td>";
                    }
                } else if ($x > 10 && $x < 21) {
                    if ($x == 11) {
                        $data .= "<tr><td>$value->CHR_SERIAL</td>";
                    } else if ($x == 20) {
                        $data .= "<td>$value->CHR_SERIAL</td></tr>";
                    } else {
                        $data .= "<td>$value->CHR_SERIAL</td>";
                    }
                } else if ($x > 20 && $x < 31) {
                    if ($x == 21) {
                        $data .= "<tr><td>$value->CHR_SERIAL</td>";
                    } else if ($x == 30) {
                        $data .= "<td>$value->CHR_SERIAL</td></tr>";
                    } else {
                        $data .= "<td>$value->CHR_SERIAL</td>";
                    }
                } else if ($x > 30 && $x < 41) {
                    if ($x == 31) {
                        $data .= "<tr><td>$value->CHR_SERIAL</td>";
                    } else if ($x == 40) {
                        $data .= "<td>$value->CHR_SERIAL</td></tr>";
                    } else {
                        $data .= "<td>$value->CHR_SERIAL</td>";
                    }
                } else {
                    if ($x == 41) {
                        $data .= "<tr><td>$value->CHR_SERIAL</td>";
                    } else if ($x == $history->num_rows()) {
                        $data .= "<td>$value->CHR_SERIAL</td></tr>";
                    } else {
                        $data .= "<td>$value->CHR_SERIAL</td>";
                    }
                }
            }
        } else if ($history->num_rows() > 50 && $history->num_rows() < 61) {
            $x = 0;
            foreach ($history->result() as $value) {
                $x++;
                if ($x > 0 && $x < 11) {
                    if ($x == 1) {
                        $data .= "<tr><td>$value->CHR_SERIAL</td>";
                    } else if ($x == 10) {
                        $data .= "<td>$value->CHR_SERIAL</td></tr>";
                    } else {
                        $data .= "<td>$value->CHR_SERIAL</td>";
                    }
                } else if ($x > 10 && $x < 21) {
                    if ($x == 11) {
                        $data .= "<tr><td>$value->CHR_SERIAL</td>";
                    } else if ($x == 20) {
                        $data .= "<td>$value->CHR_SERIAL</td></tr>";
                    } else {
                        $data .= "<td>$value->CHR_SERIAL</td>";
                    }
                } else if ($x > 20 && $x < 31) {
                    if ($x == 21) {
                        $data .= "<tr><td>$value->CHR_SERIAL</td>";
                    } else if ($x == 30) {
                        $data .= "<td>$value->CHR_SERIAL</td></tr>";
                    } else {
                        $data .= "<td>$value->CHR_SERIAL</td>";
                    }
                } else if ($x > 30 && $x < 41) {
                    if ($x == 31) {
                        $data .= "<tr><td>$value->CHR_SERIAL</td>";
                    } else if ($x == 40) {
                        $data .= "<td>$value->CHR_SERIAL</td></tr>";
                    } else {
                        $data .= "<td>$value->CHR_SERIAL</td>";
                    }
                } else if ($x > 40 && $x < 51) {
                    if ($x == 41) {
                        $data .= "<tr><td>$value->CHR_SERIAL</td>";
                    } else if ($x == 50) {
                        $data .= "<td>$value->CHR_SERIAL</td></tr>";
                    } else {
                        $data .= "<td>$value->CHR_SERIAL</td>";
                    }
                } else {
                    if ($x == 51) {
                        $data .= "<tr><td>$value->CHR_SERIAL</td>";
                    } else if ($x == $history->num_rows()) {
                        $data .= "<td>$value->CHR_SERIAL</td></tr>";
                    } else {
                        $data .= "<td>$value->CHR_SERIAL</td>";
                    }
                }
            }
        } else if ($history->num_rows() > 60 && $history->num_rows() < 71) {
            $x = 0;
            foreach ($history->result() as $value) {
                $x++;
                if ($x > 0 && $x < 11) {
                    if ($x == 1) {
                        $data .= "<tr><td>$value->CHR_SERIAL</td>";
                    } else if ($x == 10) {
                        $data .= "<td>$value->CHR_SERIAL</td></tr>";
                    } else {
                        $data .= "<td>$value->CHR_SERIAL</td>";
                    }
                } else if ($x > 10 && $x < 21) {
                    if ($x == 11) {
                        $data .= "<tr><td>$value->CHR_SERIAL</td>";
                    } else if ($x == 20) {
                        $data .= "<td>$value->CHR_SERIAL</td></tr>";
                    } else {
                        $data .= "<td>$value->CHR_SERIAL</td>";
                    }
                } else if ($x > 20 && $x < 31) {
                    if ($x == 21) {
                        $data .= "<tr><td>$value->CHR_SERIAL</td>";
                    } else if ($x == 30) {
                        $data .= "<td>$value->CHR_SERIAL</td></tr>";
                    } else {
                        $data .= "<td>$value->CHR_SERIAL</td>";
                    }
                } else if ($x > 30 && $x < 41) {
                    if ($x == 31) {
                        $data .= "<tr><td>$value->CHR_SERIAL</td>";
                    } else if ($x == 40) {
                        $data .= "<td>$value->CHR_SERIAL</td></tr>";
                    } else {
                        $data .= "<td>$value->CHR_SERIAL</td>";
                    }
                } else if ($x > 40 && $x < 51) {
                    if ($x == 41) {
                        $data .= "<tr><td>$value->CHR_SERIAL</td>";
                    } else if ($x == 50) {
                        $data .= "<td>$value->CHR_SERIAL</td></tr>";
                    } else {
                        $data .= "<td>$value->CHR_SERIAL</td>";
                    }
                } else if ($x > 50 && $x < 61) {
                    if ($x == 51) {
                        $data .= "<tr><td>$value->CHR_SERIAL</td>";
                    } else if ($x == 60) {
                        $data .= "<td>$value->CHR_SERIAL</td></tr>";
                    } else {
                        $data .= "<td>$value->CHR_SERIAL</td>";
                    }
                } else {
                    if ($x == 61) {
                        $data .= "<tr><td>$value->CHR_SERIAL</td>";
                    } else if ($x == $history->num_rows()) {
                        $data .= "<td>$value->CHR_SERIAL</td></tr>";
                    } else {
                        $data .= "<td>$value->CHR_SERIAL</td>";
                    }
                }
            }
        } else {
            $x = 0;
            foreach ($history->result() as $value) {
                $x++;
                if ($x > 0 && $x < 11) {
                    if ($x == 1) {
                        $data .= "<tr><td>$value->CHR_SERIAL</td>";
                    } else if ($x == 10) {
                        $data .= "<td>$value->CHR_SERIAL</td></tr>";
                    } else {
                        $data .= "<td>$value->CHR_SERIAL</td>";
                    }
                } else if ($x > 10 && $x < 21) {
                    if ($x == 11) {
                        $data .= "<tr><td>$value->CHR_SERIAL</td>";
                    } else if ($x == 20) {
                        $data .= "<td>$value->CHR_SERIAL</td></tr>";
                    } else {
                        $data .= "<td>$value->CHR_SERIAL</td>";
                    }
                } else if ($x > 20 && $x < 31) {
                    if ($x == 21) {
                        $data .= "<tr><td>$value->CHR_SERIAL</td>";
                    } else if ($x == 30) {
                        $data .= "<td>$value->CHR_SERIAL</td></tr>";
                    } else {
                        $data .= "<td>$value->CHR_SERIAL</td>";
                    }
                } else if ($x > 30 && $x < 41) {
                    if ($x == 31) {
                        $data .= "<tr><td>$value->CHR_SERIAL</td>";
                    } else if ($x == 40) {
                        $data .= "<td>$value->CHR_SERIAL</td></tr>";
                    } else {
                        $data .= "<td>$value->CHR_SERIAL</td>";
                    }
                } else if ($x > 40 && $x < 51) {
                    if ($x == 41) {
                        $data .= "<tr><td>$value->CHR_SERIAL</td>";
                    } else if ($x == 50) {
                        $data .= "<td>$value->CHR_SERIAL</td></tr>";
                    } else {
                        $data .= "<td>$value->CHR_SERIAL</td>";
                    }
                } else if ($x > 50 && $x < 61) {
                    if ($x == 51) {
                        $data .= "<tr><td>$value->CHR_SERIAL</td>";
                    } else if ($x == 60) {
                        $data .= "<td>$value->CHR_SERIAL</td></tr>";
                    } else {
                        $data .= "<td>$value->CHR_SERIAL</td>";
                    }
                } else if ($x > 60 && $x < 71) {
                    if ($x == 61) {
                        $data .= "<tr><td>$value->CHR_SERIAL</td>";
                    } else if ($x == 70) {
                        $data .= "<td>$value->CHR_SERIAL</td></tr>";
                    } else {
                        $data .= "<td>$value->CHR_SERIAL</td>";
                    }
                } else {
                    if ($x == 71) {
                        $data .= "<tr><td>$value->CHR_SERIAL</td>";
                    } else if ($x == $history->num_rows()) {
                        $data .= "<td>$value->CHR_SERIAL</td></tr>";
                    } else {
                        $data .= "<td>$value->CHR_SERIAL</td>";
                    }
                }
            }
        }


        if ($history->num_rows() > 0) {
            $data .= "</table>";
        }

        $data_send = str_replace('\/', '/', $data);

        if ('IS_AJAX') {
            echo json_encode($data_send);
        }
    }

}
