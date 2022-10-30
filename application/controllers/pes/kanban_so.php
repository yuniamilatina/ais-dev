<?php

set_time_limit(7200);
ini_set('max_execution_time', 0);
ini_set('memory_limit', '2048M');

class Kanban_so extends CI_Controller {

    private $layout = '/template/head';

    public function __construct() {
        parent::__construct();
        $this->load->model('pes/kanban_master_m');
        $this->load->helper(array('form', 'url', 'inflector'));
        $this->load->library(array('PHPExcel', 'PHPExcel/IOFactory'));
        $this->load->helper('download');
    }

    public function print_kanban($type_print = null) {
        $this->role_module_m->authorization('16');
        $this->session->userdata('user_id');
        $npk = $this->session->userdata('NPK');
        $data['content'] = 'kanban_master/print_kanban_so_v';
        $data['title'] = 'Kanban Master System';

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(116);
        $data['news'] = $this->news_m->get_news();

        if ($this->input->post('upload_excel')) {
            $fileName = $_FILES['import']['name'];
            if (empty($fileName)) {
                echo '<script>alert("Anda Belum Memilih File Untuk diupload");</script>';
                redirect('pes/kanban_so/print_kanban', 'refresh');
            }
            $config['upload_path'] = './assets/files/';
            $config['file_name'] = $fileName;
            $config['allowed_types'] = 'xls|xlsx';
            $config['max_size'] = 10000;
            $this->load->library('upload');
            $this->upload->initialize($config);
            if ($a = $this->upload->do_upload('import'))
                $this->upload->display_errors();
            $media = $this->upload->data('import');
            $inputFileName = './assets/files/' . $media['file_name'];
            //  Read  Excel workbook
            try {
                $inputFileType = IOFactory::identify($inputFileName);
                $objReader = IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($inputFileName);
            } catch (Exception $e) {
//                $this->db->trans_rollback();
                die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' . $e->getMessage());
            }


            //  Get worksheet dimensions
            $sheet = $objPHPExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();
            $x = 0;
            $y = 0;


            for ($row = 2; $row <= $highestRow; $row++) {
                $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);

                $part_no_cust = trim($rowData[0][1]);
                $part_no = trim($rowData[0][2]);

                $qty_per_kanban = trim($rowData[0][5]);
                $qty_per_box = $qty_per_kanban;
                if (!is_numeric($qty_per_kanban)) {
                    $qty_per_kanban = 1;
                }

                $print_qty = trim($rowData[0][6]);
                if (!is_numeric($print_qty)) {
                    $print_qty = 1;
                }

                $work_center = $rowData[0][3];
                $deliv_date = $rowData[0][4];
                if (strlen($deliv_date) <> 8) {
                    $deliv_date = date("Ymd");
                }
//validasi jika part no aisin tidak diisi
//                if ($part_no == "") {
//                    $status = "E";
//                    $errmsg = "Part No Aisin Tidak diisi";
//                    $backno = "";
//                    $partno = $part_no;
//                    $self_loc = "";
//                    $next_proc = "";
//                    $next_loc = "";
//                    $qty_per_box = "0";
//                    $jenis_box = "";
//                    $ket = "";
//                    $printqty = $print_qty;
//                    $prodver = "0001";
//                    $side = "";
//                    $cb = "no";
//                    $deliv_date = "";
//                    $self_proc = $work_center;
//                    $partName = "";
//                    $this->insert_tw_kanban_so_upload($part_no_cust, $partno, $backno, $self_proc, $self_loc, $next_proc, $next_loc, $qty_per_box, $jenis_box, $ket, $printqty, $prodver, $side, $cb, $partName, $status, $errmsg, $deliv_date);
//                    continue;
//                }
//                
                if ($part_no_cust == "") {
                    $status = "E";
                    $errmsg = "Part No Customer Tidak diisi";
                    $backno = "";
                    $partno = $part_no;
                    $self_loc = "";
                    $next_proc = "";
                    $next_loc = "";
                    $qty_per_box = "0";
                    $jenis_box = "";
                    $ket = "";
                    $printqty = $print_qty;
                    $prodver = "0001";
                    $side = "";
                    $cb = "no";
                    $deliv_date = "";
                    $self_proc = $work_center;
                    $partName = "";
                    $this->insert_tw_kanban_so_upload($part_no_cust, $partno, $backno, $self_proc, $self_loc, $next_proc, $next_loc, $qty_per_box, $jenis_box, $ket, $printqty, $prodver, $side, $cb, $partName, $status, $errmsg, $deliv_date);
                    continue;
                }

//                validasi cek part no aisin apakah sudah teregristasi atau tidak
//                $part_no_aii_cek = $this->db->query("SELECT CHR_PART_NAME FROM TM_PARTS WHERE     (CHR_PART_NO = '$part_no')")->result();
//                if (count($part_no_aii_cek) == 0) {
//                    $status = "E";
//                    $errmsg = "Part No Aisin Salah/Tidak Terdaftar";
//                    $backno = "";
//                    $partno = $part_no;
//                    $self_loc = "";
//                    $next_proc = "";
//                    $next_loc = "";
//                    $qty_per_box = "0";
//                    $jenis_box = "";
//                    $ket = "";
//                    $printqty = $print_qty;
//                    $prodver = "0001";
//                    $side = "";
//                    $cb = "no";
//                    $deliv_date = "";
//                    $self_proc = $work_center;
//                    $partName = "";
//                    $this->insert_tw_kanban_so_upload($part_no_cust, $partno, $backno, $self_proc, $self_loc, $next_proc, $next_loc, $qty_per_box, $jenis_box, $ket, $printqty, $prodver, $side, $cb, $partName, $status, $errmsg, $deliv_date);
//                    continue;
//                }
//                Validasi Apakah part no customer ada atau tidak
                $part_no_aii_cek = $this->db->query("SELECT CHR_CUS_PART_NO from TM_SHIPPING_PARTS where CHR_CUS_PART_NO = '$part_no_cust'")->result();
                if (count($part_no_aii_cek) == 0) {
                    $status = "E";
                    $errmsg = "Part No Customer Salah/Tidak Terdaftar";
                    $backno = "";
                    $partno = $part_no;
                    $self_loc = "";
                    $next_proc = "";
                    $next_loc = "";
                    $qty_per_box = "0";
                    $jenis_box = "";
                    $ket = "";
                    $printqty = $print_qty;
                    $prodver = "0001";
                    $side = "";
                    $cb = "no";
                    $deliv_date = "";
                    $self_proc = $work_center;
                    $partName = "";
                    $this->insert_tw_kanban_so_upload($part_no_cust, $partno, $backno, $self_proc, $self_loc, $next_proc, $next_loc, $qty_per_box, $jenis_box, $ket, $printqty, $prodver, $side, $cb, $partName, $status, $errmsg, $deliv_date);
                    continue;
                }

                //Check Part No
                if ($part_no_cust != "" and $part_no != "") {
                    $part_no_aii_cek = $this->db->query("SELECT DISTINCT CHR_PART_NO FROM TM_SHIPPING_PARTS WHERE CHR_CUS_PART_NO = '$part_no_cust' and CHR_PART_NO = '$part_no'")->result();
                    if (count($part_no_aii_cek) == 0) {
                        $status = "E";
                        $errmsg = "Part No Customer dan Part No Aisin Tidak Sesuai";
                        $backno = "";
                        $partno = $part_no;
                        $self_loc = "";
                        $next_proc = "";
                        $next_loc = "";
                        $qty_per_box = "0";
                        $jenis_box = "";
                        $ket = "";
                        $printqty = $print_qty;
                        $prodver = "0001";
                        $side = "";
                        $cb = "no";
                        $deliv_date = "";
                        $self_proc = $work_center;
                        $partName = "";
                        $this->insert_tw_kanban_so_upload($part_no_cust, $partno, $backno, $self_proc, $self_loc, $next_proc, $next_loc, $qty_per_box, $jenis_box, $ket, $printqty, $prodver, $side, $cb, $partName, $status, $errmsg, $deliv_date);
                        continue;
                    }
                }

                //ambil part no aii dari part no cust yang ada
                if ($part_no == "") {
                    $data_part = $this->db->query("SELECT CHR_PART_NO  from TM_SHIPPING_PARTS where  LEN(CHR_PART_NO) > 11  and SUBSTRING(CHR_PART_NO, LEN(CHR_PART_NO) - 1 , 2) in ('P0', 'P1' , 'P2' ,'V0' , 'V1' , 'V2') AND  CHR_CUS_PART_NO = '$part_no_cust' ")->row();
                    if (count($data_part) > 0) {
                        $part_no = trim($data_part->CHR_PART_NO);
                    } else {
                        $data_part = $this->db->query("SELECT CHR_PART_NO  from TM_SHIPPING_PARTS where   CHR_CUS_PART_NO = '$part_no_cust' ")->row();
                        $part_no = trim($data_part->CHR_PART_NO);
                    }
                }


                $kanban = $this->db->query("SELECT * FROM TM_KANBAN WHERE (CHR_FLAG_DELETE IS NULL OR CHR_FLAG_DELETE='') AND (CHR_KANBAN_TYPE='5' or  CHR_KANBAN_TYPE='1') AND CHR_PART_NO = '$part_no'")->row();
                if (count($kanban) > 0) {
                    $status = "S";
                    $errmsg = "OK (Ready to Print)";
                    $part_no_aii_cek = $this->db->query("SELECT DISTINCT CHR_PART_NO FROM TM_SHIPPING_PARTS WHERE CHR_CUS_PART_NO = '$part_no_cust' ")->row();
                    $partno = $part_no;
                    $backno = $kanban->CHR_BACK_NO;
                    $self_proc = $work_center;
                    $self_loc = $kanban->CHR_SLOC_FROM;
                    $next_proc = $kanban->CHR_SLOC_TO;
                    $next_loc = "";
//                    $qty_per_box = $kanban->INT_QTY_PER_BOX;
                    $qty_per_box = $qty_per_kanban;
                    $jenis_box = $kanban->CHR_BOX_TYPE;
                    $ket = $kanban->CHR_KETERANGAN;
                    $printqty = $print_qty;
                    $prodver = "0001";
                    $side = $kanban->CHR_SIDE;
                    $cb = "yes";
                    $part_name_query = $this->db->query("SELECT      CHR_PART_NAME
                            FROM         TM_PARTS
                            WHERE     (CHR_PART_NO = '$partno')")->row();
                    if (count($part_name_query)) {
                        $partName = $part_name_query->CHR_PART_NAME;
                    } else {
                        $partName = "";
                    }
                    $this->insert_tw_kanban_so_upload($part_no_cust, $partno, $backno, $self_proc, $self_loc, $next_proc, $next_loc, $qty_per_box, $jenis_box, $ket, $printqty, $prodver, $side, $cb, $partName, $status, $errmsg, $deliv_date);
                } else {
                    $status = "E";
                    $errmsg = "Master Kanban Belum Terdaftar";
                    $backno = "";
                    $partno = $part_no;
                    $self_loc = "";
                    $next_proc = "";
                    $next_loc = "";
                    $qty_per_box = "0";
                    $jenis_box = "";
                    $ket = "";
                    $printqty = $print_qty;
                    $prodver = "0001";
                    $side = "";
                    $cb = "no";
                    $deliv_date = "";
                    $self_proc = $work_center;
                    $partName = "";
                    $this->insert_tw_kanban_so_upload($part_no_cust, $partno, $backno, $self_proc, $self_loc, $next_proc, $next_loc, $qty_per_box, $jenis_box, $ket, $printqty, $prodver, $side, $cb, $partName, $status, $errmsg, $deliv_date);
                }

                $part_no = substr($part_no, 0, 11);
                $kanban = $this->db->query("SELECT * FROM TM_KANBAN WHERE (CHR_FLAG_DELETE IS NULL OR CHR_FLAG_DELETE='') AND (CHR_KANBAN_TYPE='5' or  CHR_KANBAN_TYPE='1') AND CHR_PART_NO = '$part_no'")->row();
                if (count($kanban) > 0) {
                    $status = "S";
                    $errmsg = "OK (Ready to Print)";
                    $part_no_aii_cek = $this->db->query("SELECT DISTINCT CHR_PART_NO FROM TM_SHIPPING_PARTS WHERE CHR_CUS_PART_NO = '$part_no_cust' ")->row();
                    $partno = $part_no;
                    $backno = $kanban->CHR_BACK_NO;
                    $self_proc = $work_center;
                    $self_loc = $kanban->CHR_SLOC_FROM;
                    $next_proc = $kanban->CHR_SLOC_TO;
                    $next_loc = "";
//                    $qty_per_box = $kanban->INT_QTY_PER_BOX;
                    $qty_per_box = $qty_per_kanban;
                    $jenis_box = $kanban->CHR_BOX_TYPE;
                    $ket = $kanban->CHR_KETERANGAN;
                    $printqty = $print_qty;
                    $prodver = "0001";
                    $side = $kanban->CHR_SIDE;
                    $cb = "yes";
                    $part_name_query = $this->db->query("SELECT CHR_PART_NAME FROM TM_PARTS WHERE (CHR_PART_NO = '$partno')")->row();
                    if (count($part_name_query)) {
                        $partName = $part_name_query->CHR_PART_NAME;
                    } else {
                        $partName = "";
                    }
                    $this->insert_tw_kanban_so_upload($part_no_cust, $partno, $backno, $self_proc, $self_loc, $next_proc, $next_loc, $qty_per_box, $jenis_box, $ket, $printqty, $prodver, $side, $cb, $partName, $status, $errmsg, $deliv_date);
                } else {
                    $status = "E";
                    $errmsg = "Master Kanban Belum Terdaftar";
                    $backno = "";
                    $partno = $part_no;
                    $self_loc = "";
                    $next_proc = "";
                    $next_loc = "";
                    $qty_per_box = "0";
                    $jenis_box = "";
                    $ket = "";
                    $printqty = $print_qty;
                    $prodver = "0001";
                    $side = "";
                    $cb = "no";
                    $deliv_date = "";
                    $self_proc = $work_center;
                    $partName = "";
                    $this->insert_tw_kanban_so_upload($part_no_cust, $partno, $backno, $self_proc, $self_loc, $next_proc, $next_loc, $qty_per_box, $jenis_box, $ket, $printqty, $prodver, $side, $cb, $partName, $status, $errmsg, $deliv_date);
                }
            }
            redirect("pes/kanban_so/print_kanban", "refresh");
        }

        //kanban packing
        if ($type_print == 1) {
            $data_list_print = $this->db->query("SELECT *
                      FROM  TW_PRINT_KANBAN_SO where CHR_USER='$npk' and CHR_STATUS = 'S' and (SUBSTRING(CHR_PART_NO_AII, LEN(CHR_PART_NO_AII) - 1, 2) IN ('P0', 'P1', 'P2', 'V0', 'V1', 'V2'))order by  CHR_BACK_NO asc")->result();
            $this->db->query("DELETE FROM TW_PRINT_KANBAN_SO WHERE  CHR_USER='$npk' and (SUBSTRING(CHR_PART_NO_AII, LEN(CHR_PART_NO_AII) - 1, 2) IN ('P0', 'P1', 'P2', 'V0', 'V1', 'V2')) ");

            $data['dlp'] = $data_list_print;
            $data['specialorder'] = "- SPECIAL ORDER";

            $this->load->view('kanban_master/print_pdf_pu_so', $data);
        }

//        kanban non packing
        if ($type_print == 2) {
            $data_list_print = $this->db->query("SELECT *
                      FROM  TW_PRINT_KANBAN_SO where CHR_USER='$npk' and CHR_STATUS = 'S' and (SUBSTRING(CHR_PART_NO_AII, LEN(CHR_PART_NO_AII) - 1, 2) NOT IN ('P0', 'P1', 'P2', 'V0', 'V1', 'V2'))order by  CHR_BACK_NO asc")->result();
            $this->db->query("DELETE FROM TW_PRINT_KANBAN_SO WHERE  CHR_USER='$npk' and (SUBSTRING(CHR_PART_NO_AII, LEN(CHR_PART_NO_AII) - 1, 2) NOT IN ('P0', 'P1', 'P2', 'V0', 'V1', 'V2')) ");
            $data['dlp'] = $data_list_print;
            $data['specialorder'] = "- SPECIAL ORDER";

            $this->load->view('kanban_master/print_pdf_pu_so', $data);
        }

        if ($this->input->post('printpu')) {
            redirect("pes/kanban_so/print_kanban", "refresh");
        //    $data_list_print = $this->db->query("SELECT *
        //              FROM  TW_PRINT_KANBAN_SO where CHR_USER='$npk' and CHR_STATUS = 'S' order by  CHR_BACK_NO asc")->result();
        //    $this->db->query("DELETE FROM TW_PRINT_KANBAN_SO WHERE  CHR_USER='$npk' ");
        //    $data['dlp'] = $data_list_print;
        //    $data['specialorder'] = "- SPECIAL ORDER";

        //    $this->load->view('kanban_master/print_pdf_pu_so', $data);
        }

        if ($this->input->post('cancel')) {
            $this->db->query("DELETE FROM TW_PRINT_KANBAN_SO WHERE  CHR_USER='$npk'");
        }

        $data_list_print = $this->db->query("SELECT Distinct CHR_PART_NO_AII, CHR_PART_NO_CUST, CHR_BACK_NO, CHR_SIDE, CHR_KANBAN_TYPE, CHR_SELF_PRCS, CHR_SELF_LOC, CHR_NEXT_PRCS, 
                      CHR_NEXT_LOC, CHR_BOX_TYPE, INT_QTY_PER_BOX, CHR_KET, CHR_NO_KANBAN, INT_QTY_PRINT, CHR_PART_NAME,  CHR_USER , CHR_STATUS , CHR_ERROR_MESSAGE
                      FROM         TW_PRINT_KANBAN_SO where CHR_USER='$npk'")->result();
        $data['data_list_print'] = $data_list_print;

        $this->load->view($this->layout, $data);
    }

    public function part_no_aii() {
        $option = "";
        $part_no_cust = trim($this->input->post('part_no_cust', TRUE));
        $part_no_aii = $this->kanban_master_m->findBySql("SELECT DISTINCT CHR_PART_NO FROM TM_SHIPPING_PARTS WHERE CHR_CUS_PART_NO = '$part_no_cust'");
        
        if ($part_no_aii) {
            foreach ($part_no_aii as $value_part) {
                $part_no = trim($value_part->CHR_PART_NO);
                $kanban = $this->kanban_master_m->findBySql("SELECT DISTINCT TOP 1 CHR_PART_NO FROM TM_KANBAN WHERE (CHR_FLAG_DELETE IS NULL OR CHR_FLAG_DELETE='') AND (CHR_KANBAN_TYPE='5' OR CHR_KANBAN_TYPE='6') AND CHR_PART_NO = '$part_no'");
                if ($kanban) {
                    $option .= "<option value=\"$part_no\">$part_no</option>";
                } else {
                    $option .= "0";
                }
            }
        } else {
            $option .= "<option value=\"\">No Data</option>";
        }
        
        echo $option;
    }

    public function getCusNo() {
        
        $data = array('status' => false, 'cust_no_option' => false, 'cust_name' => false);

        $part_no_cust = trim($this->input->post('part_no_cust', TRUE));
        $part_no = trim($this->input->post('part_no', TRUE));

        $data_shipping = $this->kanban_master_m->findBySql("SELECT SP.CHR_CUS_NO, C.CHR_CUST_NAME FROM TM_SHIPPING_PARTS SP LEFT JOIN TM_CUST C ON SP.CHR_CUS_NO = C.CHR_CUST_NO
        WHERE  CHR_CUS_PART_NO = '$part_no_cust' AND CHR_PART_NO = '$part_no'
        GROUP BY SP.CHR_CUS_NO, C.CHR_CUST_NAME");
        
        if ($data_shipping) {
            $data['status'] = true;

            foreach ($data_shipping as $value) {
                $cust_no = trim($value->CHR_CUS_NO);
                $data['cust_no_option'] .= "<option value=\"$cust_no\">$cust_no</option>";
                $data['cust_name'] = trim($value->CHR_CUST_NAME);
            }
            
        } else {
            $data['cust_no_option'] .= "<option value=\"\">No Data</option>";
            $data['cust_name'] .= "-";
        }

        echo json_encode($data);
    }

    function getCusName(){
        $data = array('status' => false, 'cust_name' => false);

        $part_no_cust = trim($this->input->post('part_no_cust', TRUE));
        $part_no = trim($this->input->post('part_no', TRUE));
        $cust_no = trim($this->input->post('cust_no', TRUE));

        $data_shipping = $this->db->query("SELECT TOP 1 C.CHR_CUST_NAME FROM TM_SHIPPING_PARTS SP LEFT JOIN TM_CUST C ON SP.CHR_CUS_NO = C.CHR_CUST_NO
        WHERE  CHR_CUS_PART_NO = '$part_no_cust' AND CHR_PART_NO = '$part_no' AND SP.CHR_CUS_NO = '$cust_no'
        GROUP BY C.CHR_CUST_NAME");
        
        if ($data_shipping->num_rows() > 0) {
            $data['status'] = true;
            $data['cust_name'] = trim($data_shipping->row()->CHR_CUST_NAME);
        } else {
            $data['cust_name'] = "-";
        }

        echo json_encode($data);
    }


    function searchPartNoCust() {
        $this->load->model('pes/kanban_master_m');
        $get = $this->input->get('term');

        if ($get) {
            $result = $this->db->query("SELECT DISTINCT TOP 10 CHR_CUS_NO FROM TM_SHIPPING_PARTS WHERE CHR_CUS_NO LIKE '$get%'")->result();
            if (count($result) > 0) {
                foreach ($result as $res) {
                    $arr_result[] = $res->CHR_CUS_NO;
                }
                echo json_encode($arr_result);
            }
        }
    }

    function insert_tw_kanban_so_upload($part_no_cust, $partno, $backno, $self_proc, $self_loc, $next_proc, $next_loc, $qty_per_box, $jenis_box, $ket, $printqty, $prodver, $side, $cb, $partName, $status, $errmsg, $deliv_date) {
        $this->role_module_m->authorization('16');
        $this->session->userdata('user_id');
        $this->load->model('pes/kanban_master_m');

//        $deliv_date = trim($this->input->post('deliv_date', TRUE));
        $partno_old = $partno;
        $data = "";
        $npk = $this->session->userdata('NPK');
        $time = date("His");
        $i = 0;
        if ($self_loc == "0") {
            $slocfrom = "";
        }

        if ($side == "NONE") {
            $side = "";
        }

        $type = 5;

        //add hypen
        $jmlpartno = strlen($partno);
        if ($jmlpartno < 14) {
            $partname1 = substr($partno, 0, 6);
            $partname2 = substr($partno, 6, 5);
            $partname3 = substr($partno, 11, 2);
            $partname5 = "-";
            $partno = $partname1 . $partname5 . $partname2 . $partname5 . $partname3;
            $partno = trim($partno);
            $length2 = strlen($partno);
            if (substr($partno, 0, 1) == "-") {//delete - pertama
                $partno = substr($partno, 1);
                $length2 = strlen($partno);
            }
            if (substr($partno, -1) == "-") {//delete minus terakhir
                $partno = rtrim($partno, "-");
            };
        } elseif ($jmlpartno < 16 AND $jmlpartno > 13) {
            $partname1 = substr($partno, 0, 6);
            $partname2 = substr($partno, 6, 5);
            $partname3 = substr($partno, 11, 2);
            $partname4 = substr($partno, 13, 2);
            $partname5 = "-";
            $partno = $partname1 . $partname5 . $partname2 . $partname5 . $partname3 . $partname5 . $partname4;
            $partno = trim($partno);
            $length2 = strlen($partno);
            if (substr($partno, 0, 1) == "-") {//delete - pertama
                $partno = substr($partno, 1);
                $length2 = strlen($partno);
            }
            if (substr($partno, -1) == "-") {//delete minus terakhir
                $partno = rtrim($partno, "-");
            }
        } elseif ($jmlpartno < 18 AND $jmlpartno > 15) {
            $partname1 = substr($partno, 0, 6);
            $partname2 = substr($partno, 6, 5);
            $partname3 = substr($partno, 11, 2);
            $partname4 = substr($partno, 13, 2);
            $partname6 = substr($partno, 15, 2);
            $partname5 = "-";
            $partno = $partname1 . $partname5 . $partname2 . $partname5 . $partname3 . $partname5 . $partname4 . $partname5 . $partname6;
            $partno = trim($partno);
            $length2 = strlen($partno);
            if (substr($partno, 0, 1) == "-") {//delete - pertama
                $partno = substr($partno, 1);
                $length2 = strlen($partno);
            }
            if (substr($partno, -1) == "-") {//delete minus terakhir
                $partno = rtrim($partno, "-");
            }
        } elseif ($jmlpartno > 17) {
            $partname1 = substr($partno, 0, 6);
            $partname2 = substr($partno, 6, 5);
            $partname3 = substr($partno, 11, 2);
            $partname4 = substr($partno, 13, 2);
            $partname6 = substr($partno, 15, 2);
            $partname7 = substr($partno, 17, 2);
            $partname5 = "-";
            $partno = $partname1 . $partname5 . $partname2 . $partname5 . $partname3 . $partname5 . $partname4 . $partname5 . $partname6 . $partname5 . $partname7;
            $partno = trim($partno);
            $length2 = strlen($partno);
            if (substr($partno, 0, 1) == "-") {//delete - pertama
                $partno = substr($partno, 1);
                $length2 = strlen($partno);
            }
            if (substr($partno, -1) == "-") {//delete minus terakhir
                $partno = rtrim($partno, "-");
            }
        }


        $nokanban = $this->kanban_master_m->check_nokanban_so($type, $partno_old, $side);
        if ($nokanban != false) {
            $kanban_no = $nokanban[0]->nokanban;
        }

        if ($cb == "yes") {
            $serialno = $this->kanban_master_m->findBySql("SELECT TOP 1 INT_NUM_SERIAL 'serialno' FROM [dbo].[TM_KANBAN_SERIAL] WHERE INT_KANBAN_NO = '$kanban_no' AND INT_NUM_SERIAL LIKE '2%' ORDER BY INT_NUM_SERIAL DESC");
            if (!$serialno) {
                $serialno[0]->serialno = '20000'; //untuk pertama select ke tm_kanban_serial ( default 10000 ) untuk special order default ganti ke 20000
            }
            $iserialno = $serialno[0]->serialno;
            $iprintqty = (int) $printqty;

            $get_part_no_cust = $this->db->query("SELECT distinct A.CHR_CUS_NO , B.CHR_CUST_NAME ,A.CHR_CUS_PART_NO   from
                TM_SHIPPING_PARTS as A
                inner join
                TM_CUST as B
                on
                A.CHR_CUS_NO = B.CHR_CUST_NO
                where
                B.CHR_DIS_CHANNEL = A.CHR_DIS_CHANNEL
                and 
                A.CHR_CUS_PART_NO = '$part_no_cust'")->row();
            $cust_dest = $get_part_no_cust->CHR_CUST_NAME;
            $cust_part_no = $get_part_no_cust->CHR_CUS_PART_NO;
            $cust_no = $get_part_no_cust->CHR_CUS_NO;
            for ($i = 0; $i < $iprintqty; $i++) {
                $no = 1 + $i;
                $serial = $iserialno + $no;
                $serial2[$i] = $serial;
                $t_data = array('INT_NUM_SERIAL' => $serial2[$i],
                    'CHR_date_print' => date("Ymd"),
                    'CHR_DATE_CREATE' => date("Ymd"),
                    'CHR_DATE_CHANGE' => date("Ymd"),
                    'INT_QTY_PER_BOX' => $qty_per_box,
                    'CHR_COD_PLANT' => '600',
                    'INT_KANBAN_NO' => $kanban_no,
                    'CHR_CUS_PART_NO' => $cust_part_no,
                    'CHR_CUS_NO' => $cust_no
                );
                $this->kanban_master_m->addProduct($t_data, 'TM_KANBAN_SERIAL'); //insert so
                $this->kanban_master_m->Updateket("UPDATE [dbo].[TM_KANBAN] SET CHR_KETERANGAN = '$ket' where INT_KANBAN_NO = '$kanban_no'");
                $q = $this->kanban_master_m->findBySql("SELECT * FROM [dbo].[TM_KANBAN] WHERE INT_KANBAN_NO ='$kanban_no' ");

                $intVal = $kanban_no;
                $strVal = (string) $intVal;
                $x = strlen($strVal);
                $b = 5;
                $y = $b - $x;
                $no2 = 0;
                for ($u = 0; $u < $y; $u++) {
                    $no1 = 0;
                    $no2 = $no2 . $no1;
                }
                $nokanban = $no2 . $strVal;
                $serial_no = $serial2[$i];
                $specialorder = "-SPECIAL ORDER";
                $serial_no = $serial2[$i];

                $this->db->query("INSERT INTO TW_PRINT_KANBAN_SO "
                        . "(CHR_PART_NO_AII, CHR_PART_NO_CUST, CHR_BACK_NO, CHR_SIDE,"
                        . " CHR_KANBAN_TYPE, CHR_SELF_PRCS, CHR_SELF_LOC, CHR_NEXT_PRCS, CHR_NEXT_LOC, CHR_BOX_TYPE, INT_QTY_PER_BOX, "
                        . "CHR_KET, CHR_NO_KANBAN, INT_QTY_PRINT, CHR_PART_NAME, CHR_SERIAL_NO, CHR_USER, CHR_DATE_DELIVERY , CHR_TIME) "
                        . "VALUES "
                        . "('$partno', '$part_no_cust', '$backno', '', '5', '$self_proc', '$self_loc', '$next_proc', '$next_loc', '$jenis_box', $qty_per_box,"
                        . " '$cust_dest', '$nokanban', 1, '$partName', '$serial_no', '$npk' , '$deliv_date', '$time');");


                $data_list_print = $this->db->query("SELECT      Distinct CHR_PART_NO_AII, CHR_PART_NO_CUST, CHR_BACK_NO, CHR_SIDE, CHR_KANBAN_TYPE, CHR_SELF_PRCS, CHR_SELF_LOC, CHR_NEXT_PRCS, 
                      CHR_NEXT_LOC, CHR_BOX_TYPE, INT_QTY_PER_BOX, CHR_KET, CHR_NO_KANBAN, INT_QTY_PRINT, CHR_PART_NAME,  CHR_USER, CHR_STATUS , CHR_ERROR_MESSAGE
                      FROM         TW_PRINT_KANBAN_SO where CHR_USER='$npk'")->result();

                $data = "";
                foreach ($data_list_print as $value_lp) {
                    $part_no_aii1 = $value_lp->CHR_PART_NO_AII;
                    $part_no_cust1 = $value_lp->CHR_PART_NO_CUST;
                    $back_no1 = $value_lp->CHR_BACK_NO;
                    $part_name1 = $value_lp->CHR_PART_NAME;
                    $self_prcs1 = $value_lp->CHR_SELF_PRCS;
                    $next_prcs1 = $value_lp->CHR_NEXT_PRCS;
                    $self_loc1 = $value_lp->CHR_SELF_LOC;
                    $next_loc1 = $value_lp->CHR_NEXT_LOC;
                    $qty_per_box1 = $value_lp->INT_QTY_PER_BOX;
                    $box_type1 = $value_lp->CHR_BOX_TYPE;
                    $print_qty_arr = $this->db->query("SELECT COUNT(CHR_PART_NO_AII) as TOT FROM TW_PRINT_KANBAN_SO WHERE CHR_PART_NO_AII = '$part_no_aii1' and INT_QTY_PER_BOX = $qty_per_box1")->row();
                    $print_qty1 = $print_qty_arr->TOT;
                    $data .= "<tr>
                                        <td>$part_no_aii1</td>
                                        <td>$part_no_cust1</td>
                                        <td>$back_no1</td>
                                        <td>$part_name1</td>
                                        <td>$self_prcs1</td>
                                        <td>$next_prcs1</td>
                                        <td>$self_loc1</td>
                                        <td>$next_loc1</td>
                                        <td>$qty_per_box1</td>
                                        <td>$box_type1</td>
                                        <td>$print_qty1</td>
                                    </tr>";
                }
            }
        } else {
            $this->db->query("INSERT INTO TW_PRINT_KANBAN_SO "
                    . "(CHR_PART_NO_AII, CHR_PART_NO_CUST, CHR_BACK_NO, CHR_SIDE,"
                    . " CHR_KANBAN_TYPE, CHR_SELF_PRCS, CHR_SELF_LOC, CHR_NEXT_PRCS, CHR_NEXT_LOC, CHR_BOX_TYPE, INT_QTY_PER_BOX, "
                    . "CHR_KET, CHR_NO_KANBAN, INT_QTY_PRINT, CHR_PART_NAME, CHR_SERIAL_NO, CHR_USER, CHR_DATE_DELIVERY , CHR_TIME , "
                    . "CHR_STATUS , CHR_ERROR_MESSAGE) "
                    . "VALUES "
                    . "('$partno', '$part_no_cust', '$backno', '', '5', '$self_proc', '$self_loc', '$next_proc', '$next_loc', '$jenis_box', $qty_per_box,"
                    . " '', '', 1, '$partName', '', '$npk' , '$deliv_date', '$time' , '$status' , '$errmsg');");
        }
    }

    function insert_tw_kanban_so() {
        $this->role_module_m->authorization('16');
        $this->session->userdata('user_id');
        $this->load->model('pes/kanban_master_m');
        $part_no_cust = trim($this->input->post('part_no_cust', TRUE));
        $cust_no = trim($this->input->post('cust_no', TRUE));
        $cust_name = trim($this->input->post('cust_name', TRUE));
        $partno = trim($this->input->post('partno', TRUE));
        $backno = trim($this->input->post('backno', TRUE));
        $self_proc = trim($this->input->post('self_proc', TRUE));
        $self_loc = trim($this->input->post('self_loc', TRUE));
        $next_proc = trim($this->input->post('next_proc', TRUE));
        $next_loc = trim($this->input->post('next_loc', TRUE));
        $qty_per_box = trim($this->input->post('qty_per_box', TRUE));
        $jenis_box = trim($this->input->post('jenis_box', TRUE));
        $ket = trim($this->input->post('ket', TRUE));
        $printqty = trim($this->input->post('printqty', TRUE));
        $prodver = trim($this->input->post('prodver', TRUE));
        $side = trim($this->input->post('side', TRUE));
        $cb = trim($this->input->post('cb', TRUE));
        $partName = trim($this->input->post('partName', TRUE));
        $deliv_date = trim($this->input->post('deliv_date', TRUE));
        $partno_old = $partno;
        $data = "";
        $npk = $this->session->userdata('NPK');
        $time = date("His");
        $i = 0;

        if ($self_loc == "0") {
            $slocfrom = "";
        }

        if ($side == "NONE") {
            $side = "";
        }

        $type = 5;

        //add hypen
        $jmlpartno = strlen($partno);
        if ($jmlpartno < 14) {
            $partname1 = substr($partno, 0, 6);
            $partname2 = substr($partno, 6, 5);
            $partname3 = substr($partno, 11, 2);
            $partname5 = "-";
            $partno = $partname1 . $partname5 . $partname2 . $partname5 . $partname3;
            $partno = trim($partno);
            $length2 = strlen($partno);
            if (substr($partno, 0, 1) == "-") {//delete - pertama
                $partno = substr($partno, 1);
                $length2 = strlen($partno);
            }
            if (substr($partno, -1) == "-") {//delete minus terakhir
                $partno = rtrim($partno, "-");
            };
        } elseif ($jmlpartno < 16 AND $jmlpartno > 13) {
            $partname1 = substr($partno, 0, 6);
            $partname2 = substr($partno, 6, 5);
            $partname3 = substr($partno, 11, 2);
            $partname4 = substr($partno, 13, 2);
            $partname5 = "-";
            $partno = $partname1 . $partname5 . $partname2 . $partname5 . $partname3 . $partname5 . $partname4;
            $partno = trim($partno);
            $length2 = strlen($partno);
            if (substr($partno, 0, 1) == "-") {//delete - pertama
                $partno = substr($partno, 1);
                $length2 = strlen($partno);
            }
            if (substr($partno, -1) == "-") {//delete minus terakhir
                $partno = rtrim($partno, "-");
            }
        } elseif ($jmlpartno < 18 AND $jmlpartno > 15) {
            $partname1 = substr($partno, 0, 6);
            $partname2 = substr($partno, 6, 5);
            $partname3 = substr($partno, 11, 2);
            $partname4 = substr($partno, 13, 2);
            $partname6 = substr($partno, 15, 2);
            $partname5 = "-";
            $partno = $partname1 . $partname5 . $partname2 . $partname5 . $partname3 . $partname5 . $partname4 . $partname5 . $partname6;
            $partno = trim($partno);
            $length2 = strlen($partno);
            if (substr($partno, 0, 1) == "-") {//delete - pertama
                $partno = substr($partno, 1);
                $length2 = strlen($partno);
            }
            if (substr($partno, -1) == "-") {//delete minus terakhir
                $partno = rtrim($partno, "-");
            }
        } elseif ($jmlpartno > 17) {
            $partname1 = substr($partno, 0, 6);
            $partname2 = substr($partno, 6, 5);
            $partname3 = substr($partno, 11, 2);
            $partname4 = substr($partno, 13, 2);
            $partname6 = substr($partno, 15, 2);
            $partname7 = substr($partno, 17, 2);
            $partname5 = "-";
            $partno = $partname1 . $partname5 . $partname2 . $partname5 . $partname3 . $partname5 . $partname4 . $partname5 . $partname6 . $partname5 . $partname7;
            $partno = trim($partno);
            $length2 = strlen($partno);
            if (substr($partno, 0, 1) == "-") {//delete - pertama
                $partno = substr($partno, 1);
                $length2 = strlen($partno);
            }
            if (substr($partno, -1) == "-") {//delete minus terakhir
                $partno = rtrim($partno, "-");
            }
        }


        $nokanban = $this->kanban_master_m->check_nokanban_so($type, $partno_old, $side);
        if (!false) {
            $kanban_no = $nokanban[0]->nokanban;
        }

        if ($cb == "yes") {
            $serialno = $this->kanban_master_m->findBySql("SELECT TOP 1 INT_NUM_SERIAL 'serialno' FROM [dbo].[TM_KANBAN_SERIAL] WHERE INT_KANBAN_NO = '$kanban_no' AND INT_NUM_SERIAL LIKE '2%' ORDER BY INT_NUM_SERIAL DESC");
            if (!$serialno) {
                $serialno[0]->serialno = '20000'; //untuk pertama select ke tm_kanban_serial ( default 10000 ) untuk special order default ganti ke 20000
            }
            $iserialno = $serialno[0]->serialno;
            $iprintqty = (int) $printqty;

            // add by toro - 20201022
            $data_part_no_cust = $this->db->query("SELECT DISTINCT A.CHR_CUS_NO , A.CHR_CUS_PART_NO, B.CHR_CUST_NAME FROM
                TM_SHIPPING_PARTS AS A INNER JOIN TM_CUST AS B ON A.CHR_CUS_NO = B.CHR_CUST_NO
                WHERE B.CHR_DIS_CHANNEL = A.CHR_DIS_CHANNEL AND A.CHR_CUS_PART_NO = '$part_no_cust' AND A.CHR_PART_NO = '$partno_old' ");

            // if($data_part_no_cust->num_rows() > 0){
            //     $cust_name = $data_part_no_cust->row()->CHR_CUST_NAME;
            //     $part_no_cust = $data_part_no_cust->row()->CHR_CUS_PART_NO;
            //     $cust_no = $data_part_no_cust->row()->CHR_CUS_NO;
            // }else{
            //     $data_part_no_cust = $this->db->query("SELECT DISTINCT A.CHR_CUS_NO , A.CHR_CUS_PART_NO, B.CHR_CUST_NAME FROM
            //         TM_SHIPPING_PARTS AS A INNER JOIN TM_CUST AS B ON A.CHR_CUS_NO = B.CHR_CUST_NO
            //         WHERE B.CHR_DIS_CHANNEL = A.CHR_DIS_CHANNEL AND A.CHR_CUS_PART_NO = '$part_no_cust'");

            //     $cust_name = $data_part_no_cust->row()->CHR_CUST_NAME;
            //     $part_no_cust = $data_part_no_cust->row()->CHR_CUS_PART_NO;
            //     $cust_no = $data_part_no_cust->row()->CHR_CUS_NO;
            // }

            // $get_part_no_cust = $this->db->query("SELECT DISTINCT A.CHR_CUS_NO , A.CHR_CUS_PART_NO, B.CHR_CUST_NAME FROM
            //     TM_SHIPPING_PARTS AS A INNER JOIN TM_CUST AS B ON A.CHR_CUS_NO = B.CHR_CUST_NO
            //     WHERE B.CHR_DIS_CHANNEL = A.CHR_DIS_CHANNEL AND A.CHR_CUS_PART_NO = '$part_no_cust'")->row();
                
            // $cust_name = $get_part_no_cust->CHR_CUST_NAME;
            // $part_no_cust = $get_part_no_cust->CHR_CUS_PART_NO;
            // $cust_no = $get_part_no_cust->CHR_CUS_NO;

            for ($i = 0; $i < $iprintqty; $i++) {
                $no = 1 + $i;
                $serial = $iserialno + $no;
                $serial2[$i] = $serial;
                $t_data = array('INT_NUM_SERIAL' => $serial2[$i],
                    'CHR_date_print' => date("Ymd"),
                    'CHR_DATE_CREATE' => date("Ymd"),
                    'CHR_DATE_CHANGE' => date("Ymd"),
                    'INT_QTY_PER_BOX' => $qty_per_box,
                    'CHR_COD_PLANT' => '600',
                    'INT_KANBAN_NO' => $kanban_no,
                    'CHR_CUS_PART_NO' => $part_no_cust,
                    'CHR_CUS_NO' => $cust_no
                );
                $this->kanban_master_m->addProduct($t_data, 'TM_KANBAN_SERIAL'); //insert so
                $this->kanban_master_m->Updateket("UPDATE [dbo].[TM_KANBAN] SET CHR_KETERANGAN = '$ket' where INT_KANBAN_NO = '$kanban_no'");
                $q = $this->kanban_master_m->findBySql("SELECT * FROM [dbo].[TM_KANBAN] WHERE INT_KANBAN_NO ='$kanban_no' ");

                $intVal = $kanban_no;
                $strVal = (string) $intVal;
                $x = strlen($strVal);
                $b = 5;
                $y = $b - $x;
                $no2 = 0;
                for ($u = 0; $u < $y; $u++) {

                    $no1 = 0;
                    $no2 = $no2 . $no1;
                }
                $nokanban = $no2 . $strVal;
                $serial_no = $serial2[$i];
                $specialorder = "-SPECIAL ORDER";
                $serial_no = $serial2[$i];

                $this->db->query("INSERT INTO TW_PRINT_KANBAN_SO "
                        . "(CHR_PART_NO_AII, CHR_PART_NO_CUST, CHR_BACK_NO, CHR_SIDE,"
                        . " CHR_KANBAN_TYPE, CHR_SELF_PRCS, CHR_SELF_LOC, CHR_NEXT_PRCS, CHR_NEXT_LOC, CHR_BOX_TYPE, INT_QTY_PER_BOX, "
                        . "CHR_KET, CHR_NO_KANBAN, INT_QTY_PRINT, CHR_PART_NAME, CHR_SERIAL_NO, CHR_USER, CHR_DATE_DELIVERY , CHR_TIME) "
                        . "VALUES "
                        . "('$partno', '$part_no_cust', '$backno', '', '5', '$self_proc', '$self_loc', '$next_proc', '$next_loc', '$jenis_box', $qty_per_box,"
                        . " '$cust_name', '$nokanban', 1, '$partName', '$serial_no', '$npk' , '$deliv_date', '$time');");


                $data_list_print = $this->db->query("SELECT Distinct CHR_PART_NO_AII, CHR_PART_NO_CUST, CHR_BACK_NO, CHR_SIDE, CHR_KANBAN_TYPE, CHR_SELF_PRCS, CHR_SELF_LOC, CHR_NEXT_PRCS, 
                      CHR_NEXT_LOC, CHR_BOX_TYPE, INT_QTY_PER_BOX, CHR_KET, CHR_NO_KANBAN, INT_QTY_PRINT, CHR_PART_NAME,  CHR_USER , CHR_STATUS , CHR_ERROR_MESSAGE
                      FROM         TW_PRINT_KANBAN_SO where CHR_USER='$npk'")->result();

                $data = "";
                foreach ($data_list_print as $value_lp) {
                    $part_no_aii1 = $value_lp->CHR_PART_NO_AII;
                    $part_no_cust1 = $value_lp->CHR_PART_NO_CUST;
                    $back_no1 = $value_lp->CHR_BACK_NO;
                    $part_name1 = $value_lp->CHR_PART_NAME;
                    $self_prcs1 = $value_lp->CHR_SELF_PRCS;
                    $next_prcs1 = $value_lp->CHR_NEXT_PRCS;
                    $self_loc1 = $value_lp->CHR_SELF_LOC;
                    $next_loc1 = $value_lp->CHR_NEXT_LOC;
                    $qty_per_box1 = $value_lp->INT_QTY_PER_BOX;
                    $box_type1 = $value_lp->CHR_BOX_TYPE;
                    $status = $value_lp->CHR_STATUS;
                    $errmsg = $value_lp->CHR_ERROR_MESSAGE;
                    $print_qty_arr = $this->db->query("SELECT COUNT(CHR_PART_NO_AII) as TOT FROM TW_PRINT_KANBAN_SO WHERE CHR_PART_NO_AII = '$part_no_aii1' and INT_QTY_PER_BOX = $qty_per_box1")->row();
                    $print_qty1 = $print_qty_arr->TOT;
                    $data .= "<tr>
                                        <td>$part_no_aii1</td>
                                        <td>$part_no_cust1</td>
                                        <td>$back_no1</td>
                                        <td>$part_name1</td>
                                        <td>$self_prcs1</td>
                                        <td>$next_prcs1</td>
                                        <td>$self_loc1</td>
                                        <td>$next_loc1</td>
                                        <td>$qty_per_box1</td>
                                        <td>$box_type1</td>
                                        <td>$print_qty1</td>
                                        <td ";
                    if ($status == "S") {
                        $data .= "style='background:#0bf90b;color:black;text-align:center;' ";
                    } else {
                        $data .= "style='background:#f44336;color:white;text-align:center;' ";
                    }

                    $data .= ">$status</td>
                                        <td>$errmsg</td>
                                    </tr>";
                }
            }
            echo $data;
        }
//        $this->db->query("INSERT INTO DB_AIS.dbo.TW_PRINT_KANBAN_SO "
//                . "(CHR_PART_NO_AII, CHR_PART_NO_CUST, CHR_BACK_NO, CHR_SIDE,"
//                . " CHR_KANBAN_TYPE, CHR_SELF_PRCS, CHR_SELF_LOC, CHR_NEXT_PRCS, CHR_NEXT_LOC, CHR_BOX_TYPE, INT_QTY_PER_BOX, "
//                . "CHR_KET, CHR_NO_KANBAN, INT_QTY_PRINT, CHR_PART_NAME, CHR_SERIAL_NO, CHR_USER) "
//                . "VALUES "
//                . "('$partno', '$part_no_cust', '$backno', '', '5', '$self_proc', '$self_loc', '$next_proc', '$next_loc', '$jenis_box', $qty_per_box,"
//                . " '$ket', '', $printqty, '', '', '');");
//
//        echo "INSERT INTO DB_AIS.dbo.TW_PRINT_KANBAN_SO "
//        . "(CHR_PART_NO_AII, CHR_PART_NO_CUST, CHR_BACK_NO, CHR_SIDE,"
//        . " CHR_KANBAN_TYPE, CHR_SELF_PRCS, CHR_SELF_LOC, CHR_NEXT_PRCS, CHR_NEXT_LOC, CHR_BOX_TYPE, INT_QTY_PER_BOX, "
//        . "CHR_KET, CHR_NO_KANBAN, INT_QTY_PRINT, CHR_PART_NAME, CHR_SERIAL_NO, CHR_USER) "
//        . "VALUES "
//        . "('$partno', '$part_no_cust', '$backno', '', '5', '$self_proc', '$self_loc', '$next_proc', '$next_loc', '$jenis_box', $qty_per_box,"
//        . " '$ket', '', $printqty, '', '', '');";
    }

// END FUNCTION PRINTs
// FUNCTION REPRINT
    public function reprint() {
        $this->role_module_m->authorization('16');
        $this->session->userdata('user_id');
        $data['content'] = 'kanban_master/reprint_v';
        $data['title'] = 'Kanban Master System';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(113);
        $data['news'] = $this->news_m->get_news();

        if ($this->input->post('reprintor')) {
            $a['idorder'] = trim($_POST['idorder']);
            $partno = $a;
            $sid = trim($_POST['sid']);
            $partname = $this->input->post('pname');
            $printqty = 1;
            $cek = $this->input->post('optradio');

            $type = '0';
            $x = $this->kanban_master_m->cekFlag($partno['idorder']);
            $x = $x[0]->CHR_FLAG_DELETE;
            if ($x == 'X') {
                $this->session->set_flashdata('message', 'Data Telah Dihapus.');
                redirect(base_url() . 'index.php/pes/kanban_master/reprint');
            }

            if ($cek == 'B') {
                $nokanban = $this->kanban_master_m->findBySql("SELECT INT_KANBAN_NO 'nokanban' FROM [dbo].[TM_KANBAN] WHERE CHR_PART_NO = '$partno[idorder]' AND CHR_WC_VENDOR = '$sid' AND CHR_KANBAN_TYPE='0' ");
                $kanban_no = $nokanban[0]->nokanban;
                $qtyperbox = $this->input->post('qtyperbox');
                $supname = $this->kanban_master_m->checkSuppname($sid);
                if ($supname == false) {
                    $supname1 = '';
                } else {
                    $supname1 = $supname[0]->CHR_SUPPLIER_NAME;
                }
                $custom = $this->input->post('custom');
                $n = strlen($custom);

                if ($n > 5) {
                    $custom = trim($custom);
                    $custom = explode(',', $custom);
                    $range = count($custom);
                    for ($z = 0; $z < $range; $z++) {
                        $custom1 = $custom[$z];
                        $q = $this->kanban_master_m->findBySql("SELECT * FROM [dbo].[TM_KANBAN] LEFT JOIN [dbo].[TM_KANBAN_SERIAL] ON TM_KANBAN.INT_KANBAN_NO  =  TM_KANBAN_SERIAL.INT_KANBAN_NO WHERE TM_KANBAN_SERIAL.INT_KANBAN_NO = '$kanban_no' AND TM_KANBAN.CHR_KANBAN_TYPE = '0' AND TM_KANBAN.CHR_PART_NO = '$partno[idorder]' AND TM_KANBAN_SERIAL.INT_NUM_SERIAL = '$custom1' ");
                        for ($i = 0; $i < $printqty; $i++) {
                            $data['partno'] = $q[0]->CHR_PART_NO;
                            $data['cust'][$z][$i] = $q[0]->CHR_CUST_PART_NO;
                            $data['backno'][$z][$i] = strtoupper($q[0]->CHR_BACK_NO);
                            $side = trim($q[0]->CHR_SIDE);
                            if ($side == "NONE") {
                                $side = '';
                            }
                            $data['side'][$z][$i] = $side;
                            $data['kanbantype'][$z][$i] = $q[0]->CHR_KANBAN_TYPE;
                            $data['selflocation'][$z][$i] = strtoupper($q[0]->CHR_SLOC_FROM);
                            $data['nextprocess'][$z][$i] = $q[0]->CHR_WORK_CENTER;
                            $data['selfprocess'][$z][$i] = $q[0]->CHR_WC_VENDOR;
                            $data['nextlocation'][$z][$i] = strtoupper($q[0]->CHR_SLOC_TO);
                            $data['boxtype'][$z][$i] = strtoupper($q[0]->CHR_BOX_TYPE);
                            $data['qtyperbox'][$z][$i] = $qtyperbox;
                            $data['serialno'][$z][$i] = $custom1;
                            $data['keterangan'][$z][$i] = strtoupper($q[0]->CHR_KETERANGAN);
                            $data['suppname'] = $supname1;
                            $intVal = $q[0]->INT_KANBAN_NO;
                            $strVal = (string) $intVal;
                            $x = strlen($strVal);
                            $b = 5;
                            $y = $b - $x;
                            $no2 = 0;
                            for ($u = 0; $u < $y; $u++) {

                                $no1 = 0;
                                $no2 = $no2 . $no1;
                            }
                            $nokanban = $no2 . $strVal;
                            $data['nokanban'][$z][$i] = $nokanban;
                            $data['partname'] = $partname;
                        }
                    }
                } else if ($n == 5) {
                    $range = 1;
                    $custom = $this->input->post('custom');

                    for ($z = 0; $z < $range; $z++) {
                        $q = $this->kanban_master_m->findBySql("SELECT * FROM [dbo].[TM_KANBAN] LEFT JOIN [dbo].[TM_KANBAN_SERIAL] ON TM_KANBAN.INT_KANBAN_NO  =  TM_KANBAN_SERIAL.INT_KANBAN_NO WHERE TM_KANBAN_SERIAL.INT_KANBAN_NO = '$kanban_no' AND TM_KANBAN.CHR_KANBAN_TYPE = '0' AND TM_KANBAN.CHR_PART_NO = '$partno[idorder]' AND TM_KANBAN_SERIAL.INT_NUM_SERIAL = '$custom' ");
                        for ($i = 0; $i < $printqty; $i++) {

                            $data['partno'] = $q[0]->CHR_PART_NO;
                            $data['cust'][$z][$i] = $q[0]->CHR_CUST_PART_NO;
                            $data['backno'][$z][$i] = strtoupper($q[0]->CHR_BACK_NO);
                            $side = trim($q[0]->CHR_SIDE);
                            if ($side == "NONE") {
                                $side = '';
                            }
                            $data['side'][$z][$i] = $side;
                            $data['kanbantype'][$z][$i] = $q[0]->CHR_KANBAN_TYPE;
                            $data['selflocation'][$z][$i] = strtoupper($q[0]->CHR_SLOC_FROM);
                            $data['nextprocess'][$z][$i] = $q[0]->CHR_WORK_CENTER;
                            $data['selfprocess'][$z][$i] = $q[0]->CHR_WC_VENDOR;
                            $data['nextlocation'][$z][$i] = strtoupper($q[0]->CHR_SLOC_TO);
                            $data['boxtype'][$z][$i] = strtoupper($q[0]->CHR_BOX_TYPE);
                            $data['qtyperbox'][$z][$i] = $qtyperbox;
                            $data['serialno'][$z][$i] = $custom;
                            $data['keterangan'][$z][$i] = strtoupper($q[0]->CHR_KETERANGAN);
                            $data['suppname'] = $supname1;
                            $intVal = $q[0]->INT_KANBAN_NO;
                            $strVal = (string) $intVal;
                            $x = strlen($strVal);
                            $b = 5;
                            $y = $b - $x;
                            $no2 = 0;
                            for ($u = 0; $u < $y; $u++) {

                                $no1 = 0;
                                $no2 = $no2 . $no1;
                            }
                            $nokanban = $no2 . $strVal;
                            $data['nokanban'][$z][$i] = $nokanban;
                            $data['partname'] = $partname;
                        }
                    }
                }
            } elseif ($cek == 'A') {
                $from = $this->input->post('fromor');
                $to = $this->input->post('toor');
                $qtyperbox = $this->input->post('qtyperbox');
                $range = ((int) $to - (int) $from) + 1;
                $supname = $this->kanban_master_m->checkSuppname($sid);
                if ($supname == false) {
                    $supname1 = '';
                } else {
                    $supname1 = $supname[0]->CHR_SUPPLIER_NAME;
                }
                $nokanban = $this->kanban_master_m->findBySql("SELECT INT_KANBAN_NO 'nokanban' FROM [dbo].[TM_KANBAN] WHERE CHR_PART_NO = '$partno[idorder]' AND CHR_WC_VENDOR = '$sid' AND CHR_KANBAN_TYPE='0' ");
                $kanban_no = $nokanban[0]->nokanban;
                $serial = $this->kanban_master_m->findBySql("SELECT INT_NUM_SERIAL FROM [dbo].[TM_KANBAN_SERIAL] where INT_KANBAN_NO = '$kanban_no' AND INT_NUM_SERIAL LIKE '1%' ");
                $serialno = (int) $from - 1;

                for ($z = 0; $z < $range; $z++) {
                    $q = $this->kanban_master_m->findBySql("SELECT * FROM [dbo].[TM_KANBAN] LEFT JOIN [dbo].[TM_KANBAN_SERIAL] ON TM_KANBAN.INT_KANBAN_NO  =  TM_KANBAN_SERIAL.INT_KANBAN_NO WHERE TM_KANBAN_SERIAL.INT_KANBAN_NO = '$kanban_no' AND TM_KANBAN.CHR_KANBAN_TYPE = '0' AND TM_KANBAN.CHR_PART_NO = '$partno[idorder]' AND (TM_KANBAN_SERIAL.INT_NUM_SERIAL BETWEEN '$from' AND '$to') ");
                    for ($i = 0; $i < $printqty; $i++) {
                        $data['partno'] = $q[0]->CHR_PART_NO;
                        $data['cust'][$z][$i] = $q[0]->CHR_CUST_PART_NO;
                        $data['backno'][$z][$i] = strtoupper($q[0]->CHR_BACK_NO);
                        $side = trim($q[0]->CHR_SIDE);
                        if ($side == "NONE") {
                            $side = '';
                        }
                        $data['side'][$z][$i] = $side;
                        $data['kanbantype'][$z][$i] = $q[0]->CHR_KANBAN_TYPE;
                        $data['selflocation'][$z][$i] = strtoupper($q[0]->CHR_SLOC_FROM);
                        $data['nextprocess'][$z][$i] = $q[0]->CHR_WORK_CENTER;
                        $data['selfprocess'][$z][$i] = $q[0]->CHR_WC_VENDOR;
                        $data['nextlocation'][$z][$i] = strtoupper($q[0]->CHR_SLOC_TO);
                        $data['boxtype'][$z][$i] = strtoupper($q[0]->CHR_BOX_TYPE);
                        $data['qtyperbox'][$z][$i] = $qtyperbox;
                        $data['suppname'] = $supname1;
                        $data['serialno'][$z][$i] = $q[$z]->INT_NUM_SERIAL;
                        $data['keterangan'][$z][$i] = strtoupper($q[0]->CHR_KETERANGAN);
                        $intVal = $q[0]->INT_KANBAN_NO;
                        $strVal = (string) $intVal;
                        $x = strlen($strVal);
                        $b = 5;
                        $y = $b - $x;
                        $no2 = 0;
                        for ($u = 0; $u < $y; $u++) {

                            $no1 = 0;
                            $no2 = $no2 . $no1;
                        }
                        $nokanban = $no2 . $strVal;
                        $data['nokanban'][$z][$i] = $nokanban;
                        $data['partname'] = $partname;
                    }
                }
            }
            $data['printqty'] = $printqty;
            $data['range'] = $range;
            $this->load->view('kanban_master/reprint_pdf_or', $data);
        } //end reprint order
        elseif ($this->input->post('reprintpr')) {
            $a['idproses'] = trim($_POST['idproses']);
            $partno = $a;
            $prodver = trim($_POST['prodver1']);
            $range = 1;
            $partname = $this->input->post('pname1');
            $printqty = 1;
            $cek = $this->input->post('optradio');
            $from = $this->input->post('frompr');
            $to = $this->input->post('topr');
            $qtyperbox = $this->input->post('qtyperbox1');
            $selfpro = $this->input->post('selfpro1');
            $nextpro = $this->input->post('nextpro1');
            $slocfrom = trim($this->input->post('storself1'));
            $type = '1';
            $x = $this->kanban_master_m->cekFlag($partno['idproses']);
            $x = $x[0]->CHR_FLAG_DELETE;
            if ($x == 'X') {
                $this->session->set_flashdata('message', 'Data Telah Dihapus.');
                redirect(base_url() . 'index.php/pes/kanban_master/reprint#proses_v');
            }
            if ($slocfrom == "0") {
                $slocfrom = "";
            }
            if ($cek == 'B') {
                $supname = $this->kanban_master_m->checkSuppname($prodver);
                if ($supname == false) {
                    $supname1 = '';
                } else {
                    $supname1 = $supname[0]->CHR_SUPPLIER_NAME;
                }
                $nokanban = $this->kanban_master_m->findBySql("SELECT INT_KANBAN_NO 'nokanban' FROM [dbo].[TM_KANBAN] WHERE CHR_PART_NO = '$partno[idproses]' AND CHR_WC_VENDOR = '$prodver' AND CHR_KANBAN_TYPE='1' ");
                $kanban_no = $nokanban[0]->nokanban;
                $custom = $this->input->post('custom1');
                $n = strlen($custom);
                if ($n > 5) {
                    $custom = trim($custom);
                    $custom = explode(',', $custom);
                    $range = count($custom);

                    for ($z = 0; $z < $range; $z++) {
                        $custom1 = $custom[$z];
                        $q = $this->kanban_master_m->findBySql("SELECT * FROM [dbo].[TM_KANBAN] LEFT JOIN [dbo].[TM_KANBAN_SERIAL] ON TM_KANBAN.INT_KANBAN_NO  =  TM_KANBAN_SERIAL.INT_KANBAN_NO WHERE TM_KANBAN_SERIAL.INT_KANBAN_NO = '$kanban_no' AND TM_KANBAN.CHR_KANBAN_TYPE = '1' AND TM_KANBAN.CHR_PART_NO = '$partno[idproses]' AND TM_KANBAN_SERIAL.INT_NUM_SERIAL = '$custom1' ");

                        for ($i = 0; $i < $printqty; $i++) {
                            $data['partno'] = $q[0]->CHR_PART_NO;
                            $data['cust'][$z][$i] = $q[0]->CHR_CUST_PART_NO;
                            $data['backno'][$z][$i] = strtoupper($q[0]->CHR_BACK_NO);
                            $data['side'][$z][$i] = $q[0]->CHR_SIDE;
                            $data['kanbantype'][$z][$i] = $q[0]->CHR_KANBAN_TYPE;
                            $data['selflocation'][$z][$i] = strtoupper($slocfrom);
                            $data['nextprocess'][$z][$i] = $q[0]->CHR_WORK_CENTER;
                            $data['selfprocess'][$z][$i] = $selfpro;
                            $data['nextlocation'][$z][$i] = strtoupper($q[0]->CHR_SLOC_TO);
                            $data['boxtype'][$z][$i] = strtoupper($q[0]->CHR_BOX_TYPE);
                            $data['qtyperbox'][$z][$i] = $qtyperbox;
                            $data['serialno'][$z][$i] = $custom1;
                            $data['keterangan'][$z][$i] = strtoupper($q[0]->CHR_KETERANGAN);
                            $data['suppname'] = $supname1;
                            $intVal = $q[0]->INT_KANBAN_NO;
                            $strVal = (string) $intVal;
                            $x = strlen($strVal);
                            $b = 5;
                            $y = $b - $x;
                            $no2 = 0;
                            for ($u = 0; $u < $y; $u++) {

                                $no1 = 0;
                                $no2 = $no2 . $no1;
                            }
                            $nokanban = $no2 . $strVal;
                            $data['nokanban'][$z][$i] = $nokanban;
                            $data['partname'] = $partname;
                        }
                    }
                } else if ($n == 5) {
                    $range = 1;
                    $custom = $this->input->post('custom1');

                    for ($z = 0; $z < $range; $z++) {
                        $q = $this->kanban_master_m->findBySql("SELECT * FROM [dbo].[TM_KANBAN] LEFT JOIN [dbo].[TM_KANBAN_SERIAL] ON TM_KANBAN.INT_KANBAN_NO  =  TM_KANBAN_SERIAL.INT_KANBAN_NO WHERE TM_KANBAN_SERIAL.INT_KANBAN_NO = '$kanban_no' AND TM_KANBAN.CHR_KANBAN_TYPE = '1' AND TM_KANBAN.CHR_PART_NO = '$partno[idproses]' AND TM_KANBAN_SERIAL.INT_NUM_SERIAL = '$custom' ");
                        for ($i = 0; $i < $printqty; $i++) {
                            $data['partno'] = $q[0]->CHR_PART_NO;
                            $data['cust'][$z][$i] = $q[0]->CHR_CUST_PART_NO;
                            $data['backno'][$z][$i] = strtoupper($q[0]->CHR_BACK_NO);
                            $data['side'][$z][$i] = $q[0]->CHR_SIDE;
                            $data['kanbantype'][$z][$i] = $q[0]->CHR_KANBAN_TYPE;
                            $data['selflocation'][$z][$i] = strtoupper($slocfrom);
                            $data['nextprocess'][$z][$i] = $q[0]->CHR_WORK_CENTER;
                            $data['selfprocess'][$z][$i] = $selfpro;
                            $data['nextlocation'][$z][$i] = strtoupper($q[0]->CHR_SLOC_TO);
                            $data['boxtype'][$z][$i] = strtoupper($q[0]->CHR_BOX_TYPE);
                            $data['qtyperbox'][$z][$i] = $qtyperbox;
                            $data['serialno'][$z][$i] = $custom;
                            $data['keterangan'][$z][$i] = strtoupper($q[0]->CHR_KETERANGAN);
                            $data['suppname'] = $supname1;
                            $intVal = $q[0]->INT_KANBAN_NO;
                            $strVal = (string) $intVal;
                            $x = strlen($strVal);
                            $b = 5;
                            $y = $b - $x;
                            $no2 = 0;
                            for ($u = 0; $u < $y; $u++) {

                                $no1 = 0;
                                $no2 = $no2 . $no1;
                            }
                            $nokanban = $no2 . $strVal;
                            $data['nokanban'][$z][$i] = $nokanban;
                            $data['partname'] = $partname;
                        }
                    }
                }
            } elseif ($cek == 'A') {
                $range = ((int) $to - (int) $from) + 1;
                $supname = $this->kanban_master_m->checkSuppname($prodver);
                if ($supname == false) {
                    $supname1 = '';
                } else {
                    $supname1 = $supname[0]->CHR_SUPPLIER_NAME;
                }
                $nokanban = $this->kanban_master_m->findBySql("SELECT INT_KANBAN_NO 'nokanban' FROM [dbo].[TM_KANBAN] WHERE CHR_PART_NO = '$partno[idproses]' AND CHR_WC_VENDOR = '$prodver' AND CHR_KANBAN_TYPE='1' ");
                $kanban_no = $nokanban[0]->nokanban;
                $serial = $this->kanban_master_m->findBySql("SELECT INT_NUM_SERIAL FROM [dbo].[TM_KANBAN_SERIAL] where INT_KANBAN_NO = '$kanban_no' AND INT_NUM_SERIAL LIKE '1%' ");
                $serialno = (int) $from - 1;

                for ($z = 0; $z < $range; $z++) {
                    $q = $this->kanban_master_m->findBySql("SELECT * FROM [dbo].[TM_KANBAN] INNER JOIN [dbo].[TM_KANBAN_SERIAL] ON TM_KANBAN.INT_KANBAN_NO  =  TM_KANBAN_SERIAL.INT_KANBAN_NO WHERE TM_KANBAN_SERIAL.INT_KANBAN_NO = '$kanban_no' AND TM_KANBAN.CHR_KANBAN_TYPE = '1' AND TM_KANBAN.CHR_PART_NO = '$partno[idproses]' AND (TM_KANBAN_SERIAL.INT_NUM_SERIAL BETWEEN '$from' AND '$to') ");

                    for ($i = 0; $i < $printqty; $i++) {
                        $data['partno'] = $q[0]->CHR_PART_NO;
                        $data['cust'][$z][$i] = $q[0]->CHR_CUST_PART_NO;
                        $data['backno'][$z][$i] = strtoupper($q[0]->CHR_BACK_NO);
                        $data['side'][$z][$i] = $q[0]->CHR_SIDE;
                        $data['kanbantype'][$z][$i] = $q[0]->CHR_KANBAN_TYPE;
                        $data['selflocation'][$z][$i] = strtoupper($slocfrom);
                        $data['nextprocess'][$z][$i] = $q[0]->CHR_WORK_CENTER;
                        $data['selfprocess'][$z][$i] = $selfpro;
                        $data['nextlocation'][$z][$i] = strtoupper($q[0]->CHR_SLOC_TO);
                        $data['boxtype'][$z][$i] = strtoupper($q[0]->CHR_BOX_TYPE);
                        $data['qtyperbox'][$z][$i] = $qtyperbox;
                        $data['suppname'] = $supname1;
                        $data['keterangan'][$z][$i] = strtoupper($q[0]->CHR_KETERANGAN);
                        $intVal = $q[0]->INT_KANBAN_NO;
                        $strVal = (string) $intVal;
                        $x = strlen($strVal);
                        $b = 5;
                        $y = $b - $x;
                        $no2 = 0;
                        for ($u = 0; $u < $y; $u++) {

                            $no1 = 0;
                            $no2 = $no2 . $no1;
                        }
                        $nokanban = $no2 . $strVal;
                        $data['nokanban'][$z][$i] = $nokanban;
                        $data['partname'] = $partname;
                        $data['serialno'][$z][$i] = $q[$z]->INT_NUM_SERIAL;
                    }
                }
            }

            $data['range'] = $range;
            $data['printqty'] = $printqty;
            $this->load->view('kanban_master/reprint_pdf_pr', $data);
        }//end reprint proses
        elseif ($this->input->post('reprintsp')) {
            $a['idsupply'] = trim($_POST['idsupply']);
            $partno = $a;
            $sid = trim($_POST['sid3']);
            $partname = $this->input->post('pname3');
            $printqty = 1;
            $cek = $this->input->post('optradio');
            $type = '4';
            $x = $this->kanban_master_m->cekFlag($partno['idsupply']);
            $x = $x[0]->CHR_FLAG_DELETE;
            if ($x == 'X') {
                $this->session->set_flashdata('message', 'Data Telah Dihapus.');
                redirect(base_url() . 'index.php/pes/kanban_master/reprint#supplyparts_v');
            }
            if ($cek == 'B') {
                $qtyperbox = $this->input->post('qtyperbox4');
                $supname = $this->kanban_master_m->checkSuppname($sid);
                if ($supname == false) {
                    $supname1 = '';
                } else {
                    $supname1 = $supname[0]->CHR_SUPPLIER_NAME;
                }
                $nokanban = $this->kanban_master_m->findBySql("SELECT INT_KANBAN_NO 'nokanban' FROM [dbo].[TM_KANBAN] WHERE CHR_PART_NO = '$partno[idsupply]' AND CHR_WC_VENDOR = '$sid' AND CHR_KANBAN_TYPE='4' ");
                $kanban_no = $nokanban[0]->nokanban;
                $custom = trim($this->input->post('custom2'));
                $n = strlen($custom);
                if ($n > 5) {
                    $custom = trim($custom);
                    $custom = explode(',', $custom);
                    $range = count($custom);
                    for ($z = 0; $z < $range; $z++) {
                        $custom1 = $custom[$z];
                        $q = $this->kanban_master_m->findBySql("SELECT * FROM [dbo].[TM_KANBAN] LEFT JOIN [dbo].[TM_KANBAN_SERIAL] ON TM_KANBAN.INT_KANBAN_NO  =  TM_KANBAN_SERIAL.INT_KANBAN_NO WHERE TM_KANBAN_SERIAL.INT_KANBAN_NO = '$kanban_no' AND TM_KANBAN.CHR_KANBAN_TYPE = '4' AND TM_KANBAN.CHR_PART_NO = '$partno[idsupply]' AND TM_KANBAN_SERIAL.INT_NUM_SERIAL = '$custom1' ");
                        for ($i = 0; $i < $printqty; $i++) {
                            $data['partno'] = $q[0]->CHR_PART_NO;
                            $data['cust'][$z][$i] = $q[0]->CHR_CUST_PART_NO;
                            $data['backno'][$z][$i] = strtoupper($q[0]->CHR_BACK_NO);
                            $data['side'][$z][$i] = $q[0]->CHR_SIDE;
                            $data['kanbantype'][$z][$i] = $q[0]->CHR_KANBAN_TYPE;
                            $data['selflocation'][$z][$i] = strtoupper($q[0]->CHR_SLOC_FROM);
                            $data['nextprocess'][$z][$i] = $q[0]->CHR_WORK_CENTER;
                            $data['selfprocess'][$z][$i] = $q[0]->CHR_WC_VENDOR;
                            $data['nextlocation'][$z][$i] = strtoupper($q[0]->CHR_SLOC_TO);
                            $data['boxtype'][$z][$i] = $q[0]->CHR_BOX_TYPE;
                            $data['qtyperbox'][$z][$i] = $qtyperbox;
                            $data['serialno'][$z][$i] = $custom1;
                            $data['keterangan'][$z][$i] = strtoupper($q[0]->CHR_KETERANGAN);
                            $data['suppname'] = $supname1;
                            $intVal = $q[0]->INT_KANBAN_NO;
                            $strVal = (string) $intVal;
                            $x = strlen($strVal);
                            $b = 5;
                            $y = $b - $x;
                            $no2 = 0;
                            for ($u = 0; $u < $y; $u++) {

                                $no1 = 0;
                                $no2 = $no2 . $no1;
                            }
                            $nokanban = $no2 . $strVal;
                            $data['nokanban'][$z][$i] = $nokanban;
                            $data['partname'] = $partname;
                        }
                    }
                } else if ($n == 5) {
                    $range = 1;
                    $custom = $this->input->post('custom2');

                    for ($z = 0; $z < $range; $z++) {
                        $q = $this->kanban_master_m->findBySql("SELECT * FROM [dbo].[TM_KANBAN] LEFT JOIN [dbo].[TM_KANBAN_SERIAL] ON TM_KANBAN.INT_KANBAN_NO  =  TM_KANBAN_SERIAL.INT_KANBAN_NO WHERE TM_KANBAN_SERIAL.INT_KANBAN_NO = '$kanban_no' AND TM_KANBAN.CHR_KANBAN_TYPE = '4' AND TM_KANBAN.CHR_PART_NO = '$partno[idsupply]' AND TM_KANBAN_SERIAL.INT_NUM_SERIAL = '$custom' ");

                        for ($i = 0; $i < $printqty; $i++) {
                            $data['partno'] = $q[0]->CHR_PART_NO;
                            $data['cust'][$z][$i] = $q[0]->CHR_CUST_PART_NO;
                            $data['backno'][$z][$i] = strtoupper($q[0]->CHR_BACK_NO);
                            $data['side'][$z][$i] = $q[0]->CHR_SIDE;
                            $data['kanbantype'][$z][$i] = $q[0]->CHR_KANBAN_TYPE;
                            $data['selflocation'][$z][$i] = strtoupper($q[0]->CHR_SLOC_FROM);
                            $data['nextprocess'][$z][$i] = $q[0]->CHR_WORK_CENTER;
                            $data['selfprocess'][$z][$i] = $q[0]->CHR_WC_VENDOR;
                            $data['nextlocation'][$z][$i] = strtoupper($q[0]->CHR_SLOC_TO);
                            $data['boxtype'][$z][$i] = $q[0]->CHR_BOX_TYPE;
                            $data['qtyperbox'][$z][$i] = $qtyperbox;
                            $data['serialno'][$z][$i] = $custom;
                            $data['keterangan'][$z][$i] = strtoupper($q[0]->CHR_KETERANGAN);
                            $data['suppname'] = $supname1;
                            $intVal = $q[0]->INT_KANBAN_NO;
                            $strVal = (string) $intVal;
                            $x = strlen($strVal);
                            $b = 5;
                            $y = $b - $x;
                            $no2 = 0;
                            for ($u = 0; $u < $y; $u++) {

                                $no1 = 0;
                                $no2 = $no2 . $no1;
                            }
                            $nokanban = $no2 . $strVal;
                            $data['nokanban'][$z][$i] = $nokanban;
                            $data['partname'] = $partname;
                        }
                    }
                }
            } elseif ($cek == 'A') {
                $from = $this->input->post('fromsp');
                $to = $this->input->post('tosp');
                $qtyperbox = $this->input->post('qtyperbox4');
                $range = ((int) $to - (int) $from) + 1;
                $supname = $this->kanban_master_m->checkSuppname($sid);
                if ($supname == false) {
                    $supname1 = '';
                } else {
                    $supname1 = $supname[0]->CHR_SUPPLIER_NAME;
                }
                $nokanban = $this->kanban_master_m->findBySql("SELECT INT_KANBAN_NO 'nokanban' FROM [dbo].[TM_KANBAN] WHERE CHR_PART_NO = '$partno[idsupply]' AND CHR_WC_VENDOR = '$sid' AND CHR_KANBAN_TYPE='4' ");
                $kanban_no = $nokanban[0]->nokanban;
                $serial = $this->kanban_master_m->findBySql("SELECT INT_NUM_SERIAL FROM [dbo].[TM_KANBAN_SERIAL] where INT_KANBAN_NO = '$kanban_no' AND INT_NUM_SERIAL LIKE '1%' ");
                $serialno = (int) $from - 1;

                for ($z = 0; $z < $range; $z++) {
                    $q = $this->kanban_master_m->findBySql("SELECT * FROM [dbo].[TM_KANBAN] LEFT JOIN [dbo].[TM_KANBAN_SERIAL] ON TM_KANBAN.INT_KANBAN_NO  =  TM_KANBAN_SERIAL.INT_KANBAN_NO WHERE TM_KANBAN_SERIAL.INT_KANBAN_NO = '$kanban_no' AND TM_KANBAN.CHR_KANBAN_TYPE = '4' AND TM_KANBAN.CHR_PART_NO = '$partno[idsupply]' AND (TM_KANBAN_SERIAL.INT_NUM_SERIAL BETWEEN '$from' AND '$to') ");
                    for ($i = 0; $i < $printqty; $i++) {
                        $data['partno'] = $q[0]->CHR_PART_NO;
                        $data['cust'][$z][$i] = $q[0]->CHR_CUST_PART_NO;
                        $data['backno'][$z][$i] = strtoupper($q[0]->CHR_BACK_NO);
                        $data['side'][$z][$i] = $q[0]->CHR_SIDE;
                        $data['kanbantype'][$z][$i] = $q[0]->CHR_KANBAN_TYPE;
                        $data['selflocation'][$z][$i] = $q[0]->CHR_SLOC_FROM;
                        $data['nextprocess'][$z][$i] = $q[0]->CHR_WORK_CENTER;
                        $data['selfprocess'][$z][$i] = $q[0]->CHR_WC_VENDOR;
                        $data['nextlocation'][$z][$i] = $q[0]->CHR_SLOC_TO;
                        $data['boxtype'][$z][$i] = $q[0]->CHR_BOX_TYPE;
                        $data['qtyperbox'][$z][$i] = $qtyperbox;
                        $data['suppname'] = $supname1;
                        $data['serialno'][$z][$i] = $q[$z]->INT_NUM_SERIAL;
                        $data['keterangan'][$z][$i] = strtoupper($q[0]->CHR_KETERANGAN);
                        $intVal = $q[0]->INT_KANBAN_NO;
                        $strVal = (string) $intVal;
                        $x = strlen($strVal);
                        $b = 5;
                        $y = $b - $x;
                        $no2 = 0;
                        for ($u = 0; $u < $y; $u++) {

                            $no1 = 0;
                            $no2 = $no2 . $no1;
                        }
                        $nokanban = $no2 . $strVal;
                        $data['nokanban'][$z][$i] = $nokanban;
                        $data['partname'] = $partname;
                    }
                }
            }
            $data['printqty'] = $printqty;
            $data['range'] = $range;
            $this->load->view('kanban_master/reprint_pdf_sp', $data);
        } //end reprint supplyparts
        elseif ($this->input->post('reprintpu')) {
            $a['idpickup'] = trim($_POST['idpickup']);
            $partno = $a;
            $prodver = trim($_POST['prodver3']);
            $range = 1;
            $partname = $this->input->post('pnamepu');
            $printqty = 1;
            $cek = $this->input->post('optradio');
            $from = trim($this->input->post('frompu'));
            $to = trim($this->input->post('topu'));
            $qtyperbox = $this->input->post('qtyperbox3');
            $selfpro = $this->input->post('selfpro3');
            $nextpro = $this->input->post('nextpro3');
            $slocfrom = trim($this->input->post('storself3'));
            $type = '5';
            $x = $this->kanban_master_m->cekFlag($partno['idpickup']);
            $x = $x[0]->CHR_FLAG_DELETE;
            if ($x == 'X') {
                $this->session->set_flashdata('message', 'Data Telah Dihapus.');
                redirect(base_url() . 'index.php/pes/kanban_master/reprint#pickup_v');
            }
            if ($slocfrom == "0") {
                $slocfrom = "";
            }

            if ($cek == 'B') {
                $supname = $this->kanban_master_m->checkSuppname($prodver);
                if ($supname == false) {
                    $supname1 = '';
                } else {
                    $supname1 = $supname[0]->CHR_SUPPLIER_NAME;
                }
                $nokanban = $this->kanban_master_m->findBySql("SELECT INT_KANBAN_NO 'nokanban' FROM [dbo].[TM_KANBAN] WHERE CHR_PART_NO = '$partno[idpickup]' AND CHR_WC_VENDOR = '$prodver' and CHR_KANBAN_TYPE='5' ");
                $kanban_no = $nokanban[0]->nokanban;
                $custom = trim($this->input->post('custom4'));
                $n = strlen($custom);

                if ($n > 5) {
                    $custom = trim($custom);
                    $custom = explode(',', $custom);
                    $range = count($custom);

                    for ($z = 0; $z < $range; $z++) {
                        $custom1 = $custom[$z];
                        $q = $this->kanban_master_m->findBySql("SELECT * FROM [dbo].[TM_KANBAN] LEFT JOIN [dbo].[TM_KANBAN_SERIAL] ON TM_KANBAN.INT_KANBAN_NO  =  TM_KANBAN_SERIAL.INT_KANBAN_NO WHERE TM_KANBAN_SERIAL.INT_KANBAN_NO = '$kanban_no' AND TM_KANBAN.CHR_KANBAN_TYPE = '5' AND TM_KANBAN.CHR_PART_NO = '$partno[idpickup]' AND TM_KANBAN_SERIAL.INT_NUM_SERIAL = '$custom1' ");

                        for ($i = 0; $i < $printqty; $i++) {
                            $data['partno'] = $q[0]->CHR_PART_NO;
                            $data['cust'][$z][$i] = $q[0]->CHR_CUST_PART_NO;
                            $data['backno'][$z][$i] = strtoupper($q[0]->CHR_BACK_NO);
                            $data['side'][$z][$i] = $q[0]->CHR_SIDE;
                            $data['kanbantype'][$z][$i] = $q[0]->CHR_KANBAN_TYPE;
                            $data['selflocation'][$z][$i] = $slocfrom;
                            $data['nextprocess'][$z][$i] = $q[0]->CHR_WORK_CENTER;
                            $data['selfprocess'][$z][$i] = $selfpro;
                            $data['nextlocation'][$z][$i] = $q[0]->CHR_SLOC_TO;
                            $data['boxtype'][$z][$i] = $q[0]->CHR_BOX_TYPE;
                            $data['qtyperbox'][$z][$i] = $qtyperbox;
                            $data['serialno'][$z][$i] = $custom1;
                            $data['keterangan'][$z][$i] = strtoupper($q[0]->CHR_KETERANGAN);
                            $data['suppname'] = $supname1;
                            $intVal = $q[0]->INT_KANBAN_NO;
                            $strVal = (string) $intVal;
                            $x = strlen($strVal);
                            $b = 5;
                            $y = $b - $x;
                            $no2 = 0;
                            for ($u = 0; $u < $y; $u++) {

                                $no1 = 0;
                                $no2 = $no2 . $no1;
                            }
                            $nokanban = $no2 . $strVal;
                            $data['nokanban'][$z][$i] = $nokanban;
                            $data['partname'] = $partname;
                        }
                    }
                } else if ($n == 5) {
                    $range = 1;
                    $custom = trim($this->input->post('custom4'));

                    for ($z = 0; $z < $range; $z++) {
                        $q = $this->kanban_master_m->findBySql("SELECT * FROM [dbo].[TM_KANBAN] LEFT JOIN [dbo].[TM_KANBAN_SERIAL] ON TM_KANBAN.INT_KANBAN_NO=TM_KANBAN_SERIAL.INT_KANBAN_NO WHERE TM_KANBAN_SERIAL.INT_KANBAN_NO = '$kanban_no' AND TM_KANBAN.CHR_KANBAN_TYPE = '5' AND TM_KANBAN.CHR_PART_NO = '$partno[idpickup]' AND TM_KANBAN_SERIAL.INT_NUM_SERIAL = '$custom' ");
                        for ($i = 0; $i < $printqty; $i++) {
                            $data['partno'] = $q[0]->CHR_PART_NO;
                            $cust = $q[0]->CHR_CUST_PART_NO;
                            if ($cust == NULL) {
                                $cust = '';
                            }
                            $data['cust'][$z][$i] = $cust;
                            $data['backno'][$z][$i] = strtoupper($q[0]->CHR_BACK_NO);
                            $data['side'][$z][$i] = $q[0]->CHR_SIDE;
                            $data['kanbantype'][$z][$i] = $q[0]->CHR_KANBAN_TYPE;
                            $data['selflocation'][$z][$i] = $slocfrom;
                            $data['nextprocess'][$z][$i] = $q[0]->CHR_WORK_CENTER;
                            $data['selfprocess'][$z][$i] = $selfpro;
                            $data['nextlocation'][$z][$i] = $q[0]->CHR_SLOC_TO;
                            $data['boxtype'][$z][$i] = $q[0]->CHR_BOX_TYPE;
                            $data['qtyperbox'][$z][$i] = $qtyperbox;
                            $data['serialno'][$z][$i] = $custom;
                            $data['keterangan'][$z][$i] = strtoupper($q[0]->CHR_KETERANGAN);
                            $data['suppname'] = $supname1;
                            $intVal = $q[0]->INT_KANBAN_NO;
                            $strVal = (string) $intVal;
                            $x = strlen($strVal);
                            $b = 5;
                            $y = $b - $x;
                            $no2 = 0;
                            for ($u = 0; $u < $y; $u++) {

                                $no1 = 0;
                                $no2 = $no2 . $no1;
                            }
                            $nokanban = $no2 . $strVal;
                            $data['nokanban'][$z][$i] = $nokanban;
                            $data['partname'] = $partname;
                        }
                    }
                }
            } elseif ($cek == 'A') {
                $range = ((int) $to - (int) $from) + 1;
                $supname = $this->kanban_master_m->checkSuppname($prodver);
                if ($supname == false) {
                    $supname1 = '';
                } else {
                    $supname1 = $supname[0]->CHR_SUPPLIER_NAME;
                }
                $nokanban = $this->kanban_master_m->findBySql("SELECT INT_KANBAN_NO 'nokanban' FROM [dbo].[TM_KANBAN] WHERE CHR_PART_NO = '$partno[idpickup]' AND CHR_WC_VENDOR = '$prodver' AND CHR_KANBAN_TYPE='5' ");
                $kanban_no = $nokanban[0]->nokanban;
                $serial = $this->kanban_master_m->findBySql("SELECT INT_NUM_SERIAL FROM [dbo].[TM_KANBAN_SERIAL] where INT_KANBAN_NO = '$kanban_no' AND INT_NUM_SERIAL LIKE '1%' ");
                $serialno = (int) $from - 1;

                for ($z = 0; $z < $range; $z++) {
                    $q = $this->kanban_master_m->findBySql("SELECT * FROM [dbo].[TM_KANBAN] LEFT JOIN [dbo].[TM_KANBAN_SERIAL] ON TM_KANBAN.INT_KANBAN_NO  =  TM_KANBAN_SERIAL.INT_KANBAN_NO WHERE TM_KANBAN_SERIAL.INT_KANBAN_NO = '$kanban_no' AND TM_KANBAN.CHR_KANBAN_TYPE = '5' AND TM_KANBAN.CHR_PART_NO = '$partno[idpickup]' AND (TM_KANBAN_SERIAL.INT_NUM_SERIAL BETWEEN '$from' AND '$to') ");
                    for ($i = 0; $i < $printqty; $i++) {
                        $data['partno'] = $q[0]->CHR_PART_NO;
                        $data['cust'][$z][$i] = $q[0]->CHR_CUST_PART_NO;
                        $data['backno'][$z][$i] = strtoupper($q[0]->CHR_BACK_NO);
                        $data['side'][$z][$i] = $q[0]->CHR_SIDE;
                        $data['kanbantype'][$z][$i] = $q[0]->CHR_KANBAN_TYPE;
                        $data['selflocation'][$z][$i] = $slocfrom;
                        $data['nextprocess'][$z][$i] = $q[0]->CHR_WORK_CENTER;
                        $data['selfprocess'][$z][$i] = $selfpro;
                        $data['nextlocation'][$z][$i] = $q[0]->CHR_SLOC_TO;
                        $data['boxtype'][$z][$i] = $q[0]->CHR_BOX_TYPE;
                        $data['qtyperbox'][$z][$i] = $qtyperbox;
                        $data['suppname'] = $supname1;
                        $data['serialno'][$z][$i] = $q[$z]->INT_NUM_SERIAL;
                        $data['keterangan'][$z][$i] = strtoupper($q[0]->CHR_KETERANGAN);
                        $intVal = $q[0]->INT_KANBAN_NO;
                        $strVal = (string) $intVal;
                        $x = strlen($strVal);
                        $b = 5;
                        $y = $b - $x;
                        $no2 = 0;
                        for ($u = 0; $u < $y; $u++) {

                            $no1 = 0;
                            $no2 = $no2 . $no1;
                        }
                        $nokanban = $no2 . $strVal;
                        $data['nokanban'][$z][$i] = $nokanban;
                        $data['partname'] = $partname;
                    }
                }
            }
            $data['printqty'] = $printqty;
            $data['range'] = $range;
            $this->load->view('kanban_master/reprint_pdf_pu', $data);
        } //end reprint pickup
        elseif ($this->input->post('reprintpup')) {
            $a['idpickupp'] = trim($_POST['idpickupp']);
            $partno = $a;
            $range = 1;
            $partname = $this->input->post('pnamepup');
            $printqty = 1;
            $ss = $this->input->post('storself3p');
            $sn = $this->input->post('stornext3p');
            $qtyperbox = $this->input->post('qtyperbox3p');
            $cek = $this->input->post('optradio');
            $from = $this->input->post('frompup');
            $to = $this->input->post('topup');
            $type = '6';
            $x = $this->kanban_master_m->cekFlagpass($partno['idpickupp']);
            $x = $x[0]->CHR_FLAG_DELETE;
            if ($x == 'X') {
                $this->session->set_flashdata('message', 'Data Telah Dihapus.');
                redirect(base_url() . 'index.php/pes/kanban_master/reprint#pickupp_v');
            }

            if ($cek == 'B') {
                $nokanban = $this->kanban_master_m->findBySql("SELECT INT_KANBAN_NO 'nokanban' FROM [dbo].[TM_KANBAN] WHERE CHR_PART_NO = '$partno[idpickupp]' AND CHR_SLOC_TO = '$sn' AND CHR_KANBAN_TYPE='6' ");
                $kanban_no = $nokanban[0]->nokanban;
                $custom = $this->input->post('custom4p');
                $n = strlen($custom);

                if ($n > 5) {
                    $custom = trim($custom);
                    $custom = explode(',', $custom);
                    $range = count($custom);

                    for ($z = 0; $z < $range; $z++) {
                        $custom1 = $custom[$z];
                        $q = $this->kanban_master_m->findBySql("SELECT * FROM [dbo].[TM_KANBAN] LEFT JOIN [dbo].[TM_KANBAN_SERIAL] ON TM_KANBAN.INT_KANBAN_NO  =  TM_KANBAN_SERIAL.INT_KANBAN_NO WHERE TM_KANBAN_SERIAL.INT_KANBAN_NO = '$kanban_no' AND TM_KANBAN.CHR_KANBAN_TYPE = '6' AND TM_KANBAN.CHR_PART_NO = '$partno[idpickupp]' AND TM_KANBAN_SERIAL.INT_NUM_SERIAL = '$custom1' ");

                        for ($i = 0; $i < $printqty; $i++) {
                            $data['partno'] = $q[0]->CHR_PART_NO;
                            $data['cust'][$z][$i] = $q[0]->CHR_CUST_PART_NO;
                            $data['backno'][$z][$i] = strtoupper($q[0]->CHR_BACK_NO);
                            $data['side'][$z][$i] = $q[0]->CHR_SIDE;
                            $data['kanbantype'][$z][$i] = $q[0]->CHR_KANBAN_TYPE;
                            $data['selflocation'][$z][$i] = $q[0]->CHR_SLOC_FROM;
                            $data['nextlocation'][$z][$i] = $q[0]->CHR_SLOC_TO;
                            $data['boxtype'][$z][$i] = $q[0]->CHR_BOX_TYPE;
                            $data['qtyperbox'][$z][$i] = $qtyperbox;
                            $data['serialno'][$z][$i] = $custom1;
                            $data['keterangan'][$z][$i] = strtoupper($q[0]->CHR_KETERANGAN);
                            $intVal = $q[0]->INT_KANBAN_NO;
                            $strVal = (string) $intVal;
                            $x = strlen($strVal);
                            $b = 5;
                            $y = $b - $x;
                            $no2 = 0;
                            for ($u = 0; $u < $y; $u++) {

                                $no1 = 0;
                                $no2 = $no2 . $no1;
                            }
                            $nokanban = $no2 . $strVal;
                            $data['nokanban'][$z][$i] = $nokanban;
                            $data['partname'] = $partname;
                        }
                    }
                } else if ($n == 5) {
                    $range = 1;
                    $custom = $this->input->post('custom4p');

                    for ($z = 0; $z < $range; $z++) {
                        $q = $this->kanban_master_m->findBySql("SELECT * FROM [dbo].[TM_KANBAN] LEFT JOIN [dbo].[TM_KANBAN_SERIAL] ON TM_KANBAN.INT_KANBAN_NO  =  TM_KANBAN_SERIAL.INT_KANBAN_NO WHERE TM_KANBAN_SERIAL.INT_KANBAN_NO = '$kanban_no' AND TM_KANBAN.CHR_KANBAN_TYPE = '6' AND TM_KANBAN.CHR_PART_NO = '$partno[idpickupp]' AND TM_KANBAN_SERIAL.INT_NUM_SERIAL = '$custom' ");

                        for ($i = 0; $i < $printqty; $i++) {
                            $data['partno'] = $q[0]->CHR_PART_NO;
                            $data['cust'][$z][$i] = $q[0]->CHR_CUST_PART_NO;
                            $data['backno'][$z][$i] = strtoupper($q[0]->CHR_BACK_NO);
                            $data['side'][$z][$i] = $q[0]->CHR_SIDE;
                            $data['kanbantype'][$z][$i] = $q[0]->CHR_KANBAN_TYPE;
                            $data['selflocation'][$z][$i] = $q[0]->CHR_SLOC_FROM;
                            $data['nextlocation'][$z][$i] = $q[0]->CHR_SLOC_TO;
                            $data['boxtype'][$z][$i] = $q[0]->CHR_BOX_TYPE;
                            $data['qtyperbox'][$z][$i] = $qtyperbox;
                            $data['serialno'][$z][$i] = $custom;
                            $data['keterangan'][$z][$i] = strtoupper($q[0]->CHR_KETERANGAN);
                            $intVal = $q[0]->INT_KANBAN_NO;
                            $strVal = (string) $intVal;
                            $x = strlen($strVal);
                            $b = 5;
                            $y = $b - $x;
                            $no2 = 0;
                            for ($u = 0; $u < $y; $u++) {

                                $no1 = 0;
                                $no2 = $no2 . $no1;
                            }
                            $nokanban = $no2 . $strVal;
                            $data['nokanban'][$z][$i] = $nokanban;
                            $data['partname'] = $partname;
                        }
                    }
                }
            } elseif ($cek == 'A') {
                $range = ((int) $to - (int) $from) + 1;
                $nokanban = $this->kanban_master_m->findBySql("SELECT INT_KANBAN_NO 'nokanban' FROM [dbo].[TM_KANBAN] WHERE CHR_PART_NO = '$partno[idpickupp]' AND CHR_SLOC_FROM = '$ss' AND CHR_KANBAN_TYPE='6' ");
                $kanban_no = $nokanban[0]->nokanban;
                $serial = $this->kanban_master_m->findBySql("SELECT INT_NUM_SERIAL FROM [dbo].[TM_KANBAN_SERIAL] where INT_KANBAN_NO = '$kanban_no' AND INT_NUM_SERIAL LIKE '1%' ");
                $serialno = (int) $from - 1;

                for ($z = 0; $z < $range; $z++) {
                    $q = $this->kanban_master_m->findBySql("SELECT * FROM [dbo].[TM_KANBAN] LEFT JOIN [dbo].[TM_KANBAN_SERIAL] ON TM_KANBAN.INT_KANBAN_NO  =  TM_KANBAN_SERIAL.INT_KANBAN_NO WHERE TM_KANBAN_SERIAL.INT_KANBAN_NO = '$kanban_no' AND TM_KANBAN.CHR_KANBAN_TYPE = '6' AND TM_KANBAN.CHR_PART_NO = '$partno[idpickupp]' AND (TM_KANBAN_SERIAL.INT_NUM_SERIAL BETWEEN '$from' AND '$to') ");
                    for ($i = 0; $i < $printqty; $i++) {
                        $data['partno'] = $q[0]->CHR_PART_NO;
                        $data['cust'][$z][$i] = $q[0]->CHR_CUST_PART_NO;
                        $data['backno'][$z][$i] = strtoupper($q[0]->CHR_BACK_NO);
                        $data['side'][$z][$i] = $q[0]->CHR_SIDE;
                        $data['kanbantype'][$z][$i] = $q[0]->CHR_KANBAN_TYPE;
                        $data['selflocation'][$z][$i] = $q[0]->CHR_SLOC_FROM;
                        $data['nextlocation'][$z][$i] = $q[0]->CHR_SLOC_TO;
                        $data['boxtype'][$z][$i] = $q[0]->CHR_BOX_TYPE;
                        $data['qtyperbox'][$z][$i] = $qtyperbox;
                        $data['serialno'][$z][$i] = $q[$z]->INT_NUM_SERIAL;
                        $data['keterangan'][$z][$i] = strtoupper($q[0]->CHR_KETERANGAN);
                        $intVal = $q[0]->INT_KANBAN_NO;
                        $strVal = (string) $intVal;
                        $x = strlen($strVal);
                        $b = 5;
                        $y = $b - $x;
                        $no2 = 0;
                        for ($u = 0; $u < $y; $u++) {

                            $no1 = 0;
                            $no2 = $no2 . $no1;
                        }
                        $nokanban = $no2 . $strVal;
                        $data['nokanban'][$z][$i] = $nokanban;
                        $data['partname'] = $partname;
                    }
                }
            }
            $data['printqty'] = $printqty;
            $data['range'] = $range;
            $this->load->view('kanban_master/reprint_pdf_pup', $data);
        } //end reprint pickup pasthrough

        $this->load->view($this->layout, $data);
    }

// END FUNCTION REPRINT
// FUNCTION MASS PRINT
    public function mass_print() {
        $this->role_module_m->authorization('16');
        $this->session->userdata('user_id');

        $data['content'] = 'kanban_master/mass_print';
        $data['title'] = 'Kanban Master System';
        $data['news'] = $this->news_m->get_news();
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(97);

        $data['idproses'] = $this->kanban_master_m->findBySql("SELECT DISTINCT TM_KANBAN_SERIAL.INT_KANBAN_NO FROM [dbo].[TM_KANBAN_SERIAL] LEFT JOIN [dbo].[TM_KANBAN] ON TM_KANBAN_SERIAL.INT_KANBAN_NO=TM_KANBAN.INT_KANBAN_NO  WHERE TM_KANBAN.CHR_KANBAN_TYPE = '1' ORDER BY TM_KANBAN_SERIAL.INT_KANBAN_NO ASC");
        $data['idpickup'] = $this->kanban_master_m->findBySql("SELECT DISTINCT TM_KANBAN_SERIAL.INT_KANBAN_NO FROM [dbo].[TM_KANBAN_SERIAL] LEFT JOIN [dbo].[TM_KANBAN] ON TM_KANBAN_SERIAL.INT_KANBAN_NO=TM_KANBAN.INT_KANBAN_NO  WHERE TM_KANBAN.CHR_KANBAN_TYPE = '5' ORDER BY TM_KANBAN_SERIAL.INT_KANBAN_NO ASC");

        $this->load->view($this->layout, $data);
    }

    public function massprintpr() {
        $from = $this->input->post('from');
        $to = $this->input->post('to');
        $jml = ((int) $to - (int) $from) + 1;
        $cek = $this->kanban_master_m->getDataprint("SELECT TM_KANBAN.*, TM_KANBAN_SERIAL.INT_NUM_SERIAL FROM [dbo].[TM_KANBAN] INNER JOIN [dbo].[TM_KANBAN_SERIAL] ON TM_KANBAN.INT_KANBAN_NO=TM_KANBAN_SERIAL.INT_KANBAN_NO WHERE (TM_KANBAN.INT_KANBAN_NO BETWEEN '$from' AND '$to') AND TM_KANBAN.CHR_KANBAN_TYPE = '1'");
        $range = count($cek);
        if ($range > 1200) {
            $this->session->set_flashdata('message', 'Error. Maksimal print kanban');
            redirect(base_url() . 'index.php/pes/kanban_master/mass_print');
        } else {
            $alldata = $this->kanban_master_m->getDataprint("SELECT TOP 1200 TM_KANBAN.*, TM_KANBAN_SERIAL.INT_NUM_SERIAL FROM [dbo].[TM_KANBAN] INNER JOIN [dbo].[TM_KANBAN_SERIAL] ON TM_KANBAN.INT_KANBAN_NO=TM_KANBAN_SERIAL.INT_KANBAN_NO WHERE (TM_KANBAN.INT_KANBAN_NO BETWEEN '$from' AND '$to') AND TM_KANBAN.CHR_KANBAN_TYPE = '1'");
            $jumlahkanban = count($alldata);
            $data['jml'] = $jumlahkanban;
            $x = 0;
            for ($i = 0; $i < $jumlahkanban; $i++) {
                $partno = trim($alldata[$i]->CHR_PART_NO);
                $data['backno'][$i] = $alldata[$i]->CHR_BACK_NO;
                $data['cust'][$i] = $alldata[$i]->CHR_CUST_PART_NO;
                $data['nextpro'][$i] = $alldata[$i]->CHR_WORK_CENTER;
                $data['slocfrom'][$i] = $alldata[$i]->CHR_SLOC_FROM;
                $data['slocto'][$i] = $alldata[$i]->CHR_SLOC_TO;
                $data['boxtype'][$i] = $alldata[$i]->CHR_BOX_TYPE;
                $data['qtyperbox'][$i] = $alldata[$i]->INT_QTY_PER_BOX;
                $data['serial'][$i] = $alldata[$i]->INT_NUM_SERIAL;
                $data['type'][$i] = $alldata[$i]->CHR_KANBAN_TYPE;
                $intVal = $alldata[$i]->INT_KANBAN_NO;
                $strVal = (string) $intVal;
                $x = strlen($strVal);
                $b = 5;
                $y = $b - $x;
                $no2 = 0;
                for ($u = 0; $u < $y; $u++) {
                    $no1 = 0;
                    $no2 = $no2 . $no1;
                }
                $nokanban = $no2 . $strVal;
                $data['nokanban'][$i] = $nokanban;
                $pv = $alldata[$i]->CHR_WC_VENDOR;
                $data['keterangan'][$i] = $alldata[$i]->CHR_KETERANGAN;
                $side = $alldata[$i]->CHR_SIDE;
                if ($side = "NONE") {
                    $data['side'][$i] = '';
                }
                $selfpro = $this->kanban_master_m->getSelfpro("SELECT CHR_WORK_CENTER FROM [dbo].[TM_PROCESS_PARTS] WHERE CHR_PART_NO ='$partno' AND CHR_PV = '$pv' ");
                if ($selfpro) {
                    $data['selfpro'][$i] = $selfpro[0]->CHR_WORK_CENTER;
                } else {
                    $data['selfpro'][$i] = '';
                }
                $partname = $this->kanban_master_m->cekPartname($partno);
                if ($partname == false) {
                    $partname = '';
                } else {
                    $partname = $partname[0]->CHR_PART_NAME;
                }
                $data['partname'][$i] = trim($partname);
                $partname1 = substr($partno, 0, 6);
                $partname2 = substr($partno, 6, 5);
                $partname3 = substr($partno, 11, 2);
                $partname4 = substr($partno, 13, 2);
                $partname5 = "-";
                $partno = $partname1 . $partname5 . $partname2 . $partname5 . $partname3;
                $partno = trim($partno);
                $length2 = strlen($partno);
                if (substr($partno, 0, 1) == "-") {//delete - pertama
                    $partno = substr($partno, 1);
                    $length2 = strlen($partno);
                }
                if (substr($partno, -1) == "-") {//delete minus terakhir
                    $partno = rtrim($partno, "-");
                };
                $data['partno'][$i] = $partno;
            }
        }
        $this->load->view('kanban_master/mp_pr', $data);
    }

    public function massprintpu() {
        $from = $this->input->post('from');
        $to = $this->input->post('to');
        $jml = ((int) $to - (int) $from) + 1;
        $cek = $this->kanban_master_m->getDataprint("SELECT INT_NUM_SERIAL FROM [dbo].[TM_KANBAN_SERIAL] WHERE (INT_KANBAN_NO BETWEEN '$from' AND '$to')");
        $range = count($cek);
        if ($range > 1200) {
            $this->session->set_flashdata('message', 'Error. Data melebihi kapasitas maksimal print');
            redirect(base_url() . 'index.php/pes/kanban_master/mass_print');
        } else {
            $alldata = $this->kanban_master_m->getDataprint("SELECT TOP 1200 TM_KANBAN.*, TM_KANBAN_SERIAL.INT_NUM_SERIAL FROM [dbo].[TM_KANBAN] INNER JOIN [dbo].[TM_KANBAN_SERIAL] ON TM_KANBAN.INT_KANBAN_NO=TM_KANBAN_SERIAL.INT_KANBAN_NO WHERE (TM_KANBAN.INT_KANBAN_NO BETWEEN '$from' AND '$to') AND TM_KANBAN.CHR_KANBAN_TYPE = '5'");
            $jumlahkanban = count($alldata);
            $data['jml'] = $jumlahkanban;
            $x = 0;
            for ($i = 0; $i < $jumlahkanban; $i++) {
                $partno = trim($alldata[$i]->CHR_PART_NO);
                $data['backno'][$i] = $alldata[$i]->CHR_BACK_NO;
                $data['cust'][$i] = $alldata[$i]->CHR_CUST_PART_NO;
                $data['slocfrom'][$i] = $alldata[$i]->CHR_SLOC_FROM;
                $data['slocto'][$i] = $alldata[$i]->CHR_SLOC_TO;
                $data['boxtype'][$i] = $alldata[$i]->CHR_BOX_TYPE;
                $data['qtyperbox'][$i] = $alldata[$i]->INT_QTY_PER_BOX;
                $data['serial'][$i] = $alldata[$i]->INT_NUM_SERIAL;
                $data['type'][$i] = $alldata[$i]->CHR_KANBAN_TYPE;
                $data['side'][$i] = $alldata[$i]->CHR_SIDE;
                $intVal = $alldata[$i]->INT_KANBAN_NO;
                $strVal = (string) $intVal;
                $x = strlen($strVal);
                $b = 5;
                $y = $b - $x;
                $no2 = 0;
                for ($u = 0; $u < $y; $u++) {
                    $no1 = 0;
                    $no2 = $no2 . $no1;
                }
                $nokanban = $no2 . $strVal;
                $data['nokanban'][$i] = $nokanban;
                $pv = $alldata[$i]->CHR_WC_VENDOR;
                $ket = $alldata[$i]->CHR_KETERANGAN;
                if ($ket == NULL) {
                    $ket = "";
                }
                $data['keterangan'][$i] = $ket;
// if ($side = "NONE") {
//     $side="";
// }
                $selfpro = $this->kanban_master_m->cekSelfpro($partno);
                if ($selfpro == false) {
                    $selfpro = '';
                } else {
                    $selfpro = $selfpro[0]->CHR_WORK_CENTER;
                }
                $data['selfpro'][$i] = $selfpro;
                $partname = $this->kanban_master_m->cekPartname1($partno);

                if ($partname == false) {
                    $partname = '';
                } else {
                    $partname = $partname[0]->CHR_PART_NAME;
                }
                $data['partname'][$i] = trim($partname);
                $partname1 = substr($partno, 0, 6);
                $partname2 = substr($partno, 6, 5);
                $partname3 = substr($partno, 11, 2);
                $partname5 = "-";
                $partno = $partname1 . $partname5 . $partname2 . $partname5 . $partname3;
                $partno = trim($partno);
                $length2 = strlen($partno);
                if (substr($partno, 0, 1) == "-") {//delete - pertama
                    $partno = substr($partno, 1);
                    $length2 = strlen($partno);
                }if (substr($partno, -1) == "-") {//delete minus terakhir
                    $partno = rtrim($partno, "-");
                };
                $data['partno'][$i] = $partno;
            }
        };
        $this->load->view('kanban_master/mp_pu', $data);
    }

// END FUNCTION MASS PRINT
// FUNCTION SAVE BOXTYPE BARU
    public function box_type() {

        $this->role_module_m->authorization('16');
        $this->session->userdata('user_id');

        $data['content'] = 'kanban_master/box_type_v';
        $data['title'] = 'Master Box Type';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(71);
        $data['news'] = $this->news_m->get_news();

        if ($this->input->post('simpan')) {
            $jnsbox = strtoupper($this->input->post('jnsbox'));
            $panjang = $this->input->post('panjang');
            $lebar = $this->input->post('lebar');
            $tinggi = $this->input->post('tinggi');
            $exp = $this->input->post('exp');
            if ($jnsbox == "" or $panjang == "" or $lebar == "" or $tinggi == "") {
                $this->session->set_flashdata('message', 'Data gagal disimpan. Silahkan Lengkapi Data');
                redirect(base_url() . 'index.php/pes/kanban_master/box_type');
            }

            $cek = $this->kanban_master_m->findBySql("SELECT CHR_BOX_TYPE FROM [dbo].[TM_BOX_TYPE] WHERE CHR_BOX_TYPE = '$jnsbox'");
            if ($cek) {
                echo 'not empty';
                $this->session->set_flashdata('message', 'Boxytpe sudah ada');
                redirect(base_url() . 'index.php/pes/kanban_master/box_type');
            }
            $t_data = array('CHR_BOX_TYPE' => $jnsbox,
                'CHR_LENGTH' => $panjang,
                'CHR_WIDTH' => $lebar,
                'CHR_HEIGHT' => $tinggi,
                'CHR_DESC' => $exp,
            );

            $status = $this->kanban_master_m->addProduct($t_data, 'TM_BOX_TYPE');
            if (isset($status)) {
                echo 'not empty';
                $this->session->set_flashdata('message', 'Data berhasil disimpan');
                redirect(base_url() . 'index.php/pes/kanban_master/box_type');
            } else {
                echo 'not empty';
                $this->session->set_flashdata('message', 'Data gagal disimpan');
                redirect(base_url() . 'index.php/pes/kanban_master/box_type');
            }
        }



        $this->load->view($this->layout, $data);
    }

// END FUNCTION SAVE BOXTYPE BARU
// FUNCTION EDIT BOX TYPE
    public function mj_box() {
        $this->role_module_m->authorization('16');
        $this->session->userdata('user_id');

        $data['content'] = 'kanban_master/mj_box_v';
        $data['title'] = 'Master Box Type';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(71);
        $data['news'] = $this->news_m->get_news();

        $databox = $this->kanban_master_m->findBySql("SELECT DISTINCT * from TM_BOX_TYPE");
        $da = count($databox);
        $data['databox'] = $databox;
        $boxtype = $this->input->post('jnsbox');
        $length = $this->input->post('panjang');
        $width = $this->input->post('lebar');
        $height = $this->input->post('tinggi');
        $exp = $this->input->post('exp');
        $jml = count($boxtype);
        if ($this->input->post('simpan')) {
            for ($i = 0; $i < $jml; $i++) {
                $t_data = array('CHR_LENGTH' => $length[$i],
                    'CHR_WIDTH' => $width[$i],
                    'CHR_HEIGHT' => $height[$i],
                    'CHR_DESC' => $exp[$i]
                );
                $status = $this->kanban_master_m->UpdateBox($t_data, $boxtype[$i]);
            }
            if (isset($status)) {
                $this->session->set_flashdata('message', 'Data berhasil di-update');
                redirect(base_url() . 'index.php/pes/kanban_master/mj_box');
            } else {
                $this->session->set_flashdata('message', 'Data gagal di-update');
                redirect(base_url() . 'index.php/pes/kanban_master/mj_box');
            }
        }
        $this->load->view($this->layout, $data);
    }

// END FUNCTION EDIT BOX TYPE
// FUNCTION AJAX DATABARU
    function cekPartd() {
        $part = trim($this->input->post('pno', true));
        $cek = $this->kanban_master_m->findBySql("SELECT CHR_PART_NO FROM [dbo].[TM_PARTS] WHERE CHR_PART_NO = '$part'");

        echo json_encode($cek);
    }

    function cekPartpro() {
        $part = trim($this->input->post('pno', true));
        $cek = $this->kanban_master_m->findBySql("SELECT CHR_PART_NO FROM [dbo].[TM_PROCESS_PARTS] WHERE CHR_PART_NO = '$part'");

        echo json_encode($cek);
    }

    function cekPartd2() {
        $part = trim($this->input->post('pno', true));
        $cek = $this->kanban_master_m->findBySql("SELECT CHR_PART_NO FROM [dbo].[TM_VENDOR_PARTS] WHERE CHR_PART_NO = '$part'");
        echo json_encode($cek);
    }

    function getPart() {
        $partno = trim($this->input->post('pno'));
        $partname = $this->kanban_master_m->findBySql("SELECT CHR_PART_NAME 'pname' from [dbo].[TM_PARTS] WHERE CHR_PART_NO = '$partno' ");
        if ($partname) {
            echo $partname[0]->pname;
        } else {
            echo '';
        }
    }

    function getSupplier() {
        $partno = trim($this->input->post('pno'));
        $partname = $this->kanban_master_m->findBySql("SELECT CHR_SUPPLIER_ID 'pname' from [dbo].[TM_VENDOR_PARTS] where CHR_PART_NO = '$partno'");
        if (!empty($partname)) {
            foreach ($partname as $key => $value) {
                $option .= "<option value=\"$value->pname\">$value->pname</option>";
            }
        }

        echo $option;
    }

    function getBackno3() {
        $partno = trim($this->input->post('pno'));
        $partname = $this->kanban_master_m->findBySql("SELECT CHR_BACK_NO 'pname' from [dbo].[TM_KANBAN] WHERE CHR_PART_NO = '$partno' ");
        if ($partname) {
            echo $partname[0]->pname;
        } else {
            echo '';
        }
    }

    function getSupplierName() {
        $supplierid1 = trim($this->input->post('supplierid1'));
        $sup = $this->kanban_master_m->findBySql("SELECT CHR_SUPPLIER_NAME 'pname' FROM [dbo].[TM_VENDOR] WHERE CHR_SUPPLIER_ID ='$supplierid1'");
        if ($sup) {
            echo $sup[0]->pname;
        } else {
            echo '';
        }
    }

    function stor() {
        $idorder = trim($this->input->post('idorder'));
        $option = " ";
        $partname = $this->kanban_master_m->findBySql("SELECT CHR_SLOC 'pname' from [dbo].[TM_PARTS_SLOC] where CHR_PART_NO = '$idorder' AND (CHR_FLAG_DELETE IS NULL OR CHR_FLAG_DELETE='') ");
        if (!empty($partname)) {
            foreach ($partname as $key => $value) {
                $option .= "<option value=\"$value->pname\">$value->pname</option>";
            }
        }

        echo $option;
    }

    function cekBackno1() {
        $part = trim($this->input->post('idorder', true));
        $backno = trim($this->input->post('backno1', true));
        $cek = $this->kanban_master_m->check_backno($backno);
        if ($cek == false) {
            $checkbackno == 6;
            echo $cekbackno;
        } else {
            $cek1 = $cek[0]->CHR_BACK_NO;
            $jmldata = strlen($cek1);
            if ($jmldata == 6) {
                $cek2 = $this->kanban_master_m->findBySql("SELECT CHR_BACK_NO FROM [dbo].[TM_KANBAN] WHERE CHR_BACK_NO = '$backno' AND CHR_PART_NO = '$part'");
                if ($cek2) {
                    $cek4 = $cek2[0]->CHR_BACK_NO;
                    $jml = strlen($cek4);
                    if ($jml == 6) {
                        echo $cek4;
                    }
                } else {
                    $backno2 = preg_replace('/\s+/', '', $cek2);
                    echo $backno2;
                }
            }
        }
    }

    function getPartName() {
        $partno = trim($this->input->post('partno'));
        $partname = $this->kanban_master_m->findBySql("SELECT CHR_PART_NAME 'pname' from [dbo].[TM_PARTS] WHERE CHR_PART_NO = '$partno'");
        if ($partname) {
            echo $partname[0]->pname;
        } else {
            echo '';
        }
    }

    function getIntPv() {
        $partno = trim($this->input->post('partno'));
        $option = " ";
        $partname = $this->kanban_master_m->findBySql("SELECT CHR_PV 'pname' from [dbo].[TM_PROCESS_PARTS] where CHR_PART_NO = '$partno' AND (CHR_FLAG_DELETE IS NULL OR CHR_FLAG_DELETE='') ");
        if (!empty($partname)) {
            foreach ($partname as $key => $value) {
                $option .= "<option value=\"$value->pname\">$value->pname</option>";
            }
        }

        echo $option;
    }

    function getStorSelf() {
        $partno = trim($this->input->post('partno'));
        $option = " ";
        $partname = $this->kanban_master_m->findBySql("SELECT CHR_SLOC 'pname' from [dbo].[TM_PARTS_SLOC] where CHR_PART_NO = '$partno' AND (CHR_FLAG_DELETE IS NULL OR CHR_FLAG_DELETE='') ORDER BY CHR_SLOC DESC ");
        if (!empty($partname)) {
            foreach ($partname as $key => $value) {
                $option .= "<option value=\"$value->pname\">$value->pname</option>";
            }
        }

        echo $option;
    }

    function getBackno1() {
        $partno = trim($this->input->post('partno'));
        $partname = $this->kanban_master_m->findBySql("SELECT CHR_BACK_NO 'pname' from [dbo].[TM_KANBAN] WHERE CHR_PART_NO = '$partno' ");
        if ($partname) {
            echo $partname[0]->pname;
        } else {

            echo '';
        }
    }

    function getSelfpro() {
        $prodver = trim($this->input->post('prodver', TRUE));
        $partno = trim($this->input->post('idproses', TRUE));
        $partname = $this->kanban_master_m->findBySql("SELECT CHR_WORK_CENTER 'pname' FROM [dbo].[TM_PROCESS_PARTS] WHERE CHR_PV = '$prodver' AND CHR_PART_NO = '$partno'");
        if ($partname) {
            echo $partname[0]->pname;
        } else {
            echo '';
        }
    }

    function getNextpro() {
        $prodver = trim($this->input->post('prodver', TRUE));
        $partno = trim($this->input->post('idproses', TRUE));
        $partname = $this->kanban_master_m->findBySql("SELECT CHR_WORK_CENTER 'pname' FROM [dbo].[TM_PROCESS_PARTS] WHERE CHR_PV = '$prodver' AND CHR_PART_NO = '$partno'");
        if ($partname) {
            $selfpro = $partname[0]->pname;
            $option = " ";
            $partname = $this->kanban_master_m->findBySql("SELECT DISTINCT CHR_WORK_CENTER 'pname' from [dbo].[TM_PROCESS] WHERE CHR_WORK_CENTER <> '$selfpro' ");
            if (!empty($partname)) {
                foreach ($partname as $key => $value) {
                    $option .= "<option></option><option value=\"$value->pname\">$value->pname</option>";
                }
            }

            echo $option;
        } else {
            echo '';
        }
    }

    function getStorNext() {
        $prodver = trim($this->input->post('prodver', TRUE));
        $partno = trim($this->input->post('idproses', TRUE));
        $partname = $this->kanban_master_m->findBySql("SELECT CHR_SLOC_TO 'pname' from [dbo].[TM_PROCESS_PARTS] where CHR_PART_NO = '$partno' AND CHR_PV ='$prodver' AND (CHR_FLAG_DELETE IS NULL OR CHR_FLAG_DELETE='') ");
        if ($partname) {
            echo $partname[0]->pname;
        } else {
            echo '';
        }
    }

    function cekBackno2() {
        $part = trim($this->input->post('idproses', true));
        $backno = trim($this->input->post('backno', true));
        $cek = $this->kanban_master_m->check_backno($backno);
        if ($cek == false) {
            $checkbackno == 6;
            echo $cekbackno;
        } else {
            $cek1 = $cek[0]->CHR_BACK_NO;
            $jmldata = strlen($cek1);
            if ($jmldata == 6) {
                $cek2 = $this->kanban_master_m->findBySql("SELECT CHR_BACK_NO FROM [dbo].[TM_KANBAN] WHERE CHR_BACK_NO = '$backno' AND CHR_PART_NO = '$part'");
                if ($cek2) {
                    $cek4 = $cek2[0]->CHR_BACK_NO;
                    $jml = strlen($cek4);
                    if ($jml == 6) {
                        echo $cek4;
                    }
                } else {
                    $backno2 = preg_replace('/\s+/', '', $cek2);
                    echo $backno2;
                }
            }
        }
    }

    function getSupplier1() {
        $partno = trim($this->input->post('pno'));
        $option = " ";
        $partname = $this->kanban_master_m->findBySql("SELECT DISTINCT CHR_SUPPLIER_ID 'pname' from [dbo].[TM_VENDOR] ");
        if (!empty($partname)) {
            foreach ($partname as $key => $value) {
                $option .= "<option value=\"$value->pname\">$value->pname</option>";
            }
        }

        echo $option;
    }

    function Stor3() {
        $partno = trim($this->input->post('pno'));
        $option = " ";
        $partname = $this->kanban_master_m->findBySql("SELECT CHR_SLOC 'pname' from [dbo].[TM_PARTS_SLOC] where CHR_PART_NO = '$partno' AND (CHR_FLAG_DELETE IS NULL OR CHR_FLAG_DELETE='')");
        if (!empty($partname)) {
            foreach ($partname as $key => $value) {
                $option .= "<option value=\"$value->pname\">$value->pname</option>";
            }
        }

        echo $option;
    }

    function getSupplierName3() {
        $supplierid3 = trim($this->input->post('supplierid3'));
        $partname = $this->kanban_master_m->findBySql("SELECT CHR_SUPPLIER_NAME 'pname' FROM [dbo].[TM_VENDOR] WHERE CHR_SUPPLIER_ID ='$supplierid3'");
        if ($partname) {
            echo $partname[0]->pname;
        } else {
            echo '';
        }
    }

    function cekBackno3() {
        $part = trim($this->input->post('idsupply', true));
        $backno = trim($this->input->post('backno3', true));
        $cek = $this->kanban_master_m->check_backno($backno);
        if ($cek == false) {
            $checkbackno == 6;
            echo $cekbackno;
        } else {
            $cek1 = $cek[0]->CHR_BACK_NO;
            $jmldata = strlen($cek1);
            if ($jmldata == 6) {
                $cek2 = $this->kanban_master_m->findBySql("SELECT CHR_BACK_NO FROM [dbo].[TM_KANBAN] WHERE CHR_BACK_NO = '$backno' AND CHR_PART_NO = '$part'");
                if ($cek2) {
                    $cek4 = $cek2[0]->CHR_BACK_NO;
                    $jml = strlen($cek4);
                    if ($jml == 6) {
                        echo $cek4;
                    }
                } else {
                    $backno2 = preg_replace('/\s+/', '', $cek2);
                    echo $backno2;
                }
            }
        }
    }

    function getStorSelf1() {
        $partno = trim($this->input->post('idpickup'));
        $option = " ";
        $partname = $this->kanban_master_m->findBySql("SELECT CHR_SLOC 'pname' from [dbo].[TM_PARTS_SLOC] where CHR_PART_NO = '$partno' AND (CHR_FLAG_DELETE IS NULL OR CHR_FLAG_DELETE='') ORDER BY CHR_SLOC DESC ");
        if (!empty($partname)) {
            foreach ($partname as $key => $value) {
                $option .= "<option value=\"$value->pname\">$value->pname</option>";
            }
        }

        echo $option;
    }

    function getBoxtype() {
        $partno = trim($this->input->post('idpickup', TRUE));
        $stornext = $this->kanban_master_m->findBySql("SELECT DISTINCT CHR_BOX_TYPE FROM [dbo].[TM_KANBAN]");
        $option = '';

        foreach ($stornext as $key => $value) {
            $option .= "<option value=\"$value->CHR_BOX_TYPE\">$value->CHR_BOX_TYPE</option>";
        }

        echo $option;
    }

    function getBoxtypePick() {
        $partno = trim($this->input->post('idpickup', TRUE));
        $stornext = $this->kanban_master_m->findBySql("SELECT DISTINCT CHR_BOX_TYPE FROM [dbo].[TM_BOX_TYPE]");
        $option = '';

        foreach ($stornext as $key => $value) {
            $option .= "<option value=\"$value->CHR_BOX_TYPE\">$value->CHR_BOX_TYPE</option>";
        }

        echo $option;
    }

    function getStorNext4d1() {
        $prodver = trim($this->input->post('prodver4', TRUE));
        $partno = trim($this->input->post('idpickup', TRUE));
        $partname = $this->kanban_master_m->findBySql("SELECT DISTINCT CHR_SLOC_TO 'pname' from [dbo].[TM_PROCESS_PARTS] WHERE CHR_PART_NO = '$partno' AND CHR_PV = '$prodver' AND (CHR_FLAG_DELETE IS NULL OR CHR_FLAG_DELETE='') ");
        if (!empty($partname)) {
            echo $partname[0]->pname;
        } else {
            echo '';
        }
    }

    function getSelfpro4() {
        $prodver4 = trim($this->input->post('prodver4', TRUE));
        $partno = trim($this->input->post('idpickup', TRUE));
        $partname = $this->kanban_master_m->findBySql("SELECT CHR_WORK_CENTER 'pname' FROM [dbo].[TM_PROCESS_PARTS] WHERE CHR_PV = '$prodver4' AND CHR_PART_NO = '$partno'");
        if ($partname) {
            echo $partname[0]->pname;
        } else {
            echo '';
        }
    }

    function getNextpro4d() {
        $prodver = trim($this->input->post('prodver4', TRUE));
        $partno = trim($this->input->post('idpickup', TRUE));
        $partname = $this->kanban_master_m->findBySql("SELECT CHR_WORK_CENTER 'pname' FROM [dbo].[TM_PROCESS]");
        if ($partname) {
            $option .= "<option></option>";
            foreach ($partname as $key => $value) {
                $option .= "<option value=\"$value->pname\">$value->pname</option>";
            }
        }

        echo $option;
    }

    function getQtypick() {
        $partno = trim($this->input->post('idpickup', TRUE));
        $qty = $this->kanban_master_m->cekQty($partno);
        if ($qty == false) {
            echo false;
        } else {
            echo $qty[0]->INT_QTY_PER_BOX;
        }
    }

    function cekBackno4() {
        $part = trim($this->input->post('idpickup', true));
        $backno = trim($this->input->post('backno4', true));
        $cek = $this->kanban_master_m->check_backno($backno);
        if ($cek == false) {
            $checkbackno == 6;
            echo $cekbackno;
        } else {
            $cek1 = $cek[0]->CHR_BACK_NO;
            $jmldata = strlen($cek1);
            if ($jmldata == 6) {
                $cek2 = $this->kanban_master_m->findBySql("SELECT CHR_BACK_NO FROM [dbo].[TM_KANBAN] WHERE CHR_BACK_NO = '$backno' AND CHR_PART_NO = '$part'");
                if ($cek2) {
                    $cek4 = $cek2[0]->CHR_BACK_NO;
                    $jml = strlen($cek4);
                    if ($jml == 6) {
                        echo $cek4;
                    }
                } else {
                    $backno2 = preg_replace('/\s+/', '', $cek2);
                    echo $backno2;
                }
            }
        }
    }

    function getStorself4d() {
        $partno = trim($this->input->post('idpickup', TRUE));
        $stornext = $this->kanban_master_m->findBySql("SELECT CHR_SLOC FROM [dbo].[TM_PARTS_SLOC] WHERE CHR_PART_NO = '$partno' AND (CHR_FLAG_DELETE IS NULL OR CHR_FLAG_DELETE='') AND CHR_SLOC !='WH00' ");
        $option = '';
        foreach ($stornext as $key => $value) {
            $option .= "<option value=\"WH00\">WH00</option>";
            $option .= "<option value=\"$value->CHR_SLOC\">$value->CHR_SLOC</option>";
        }

        echo $option;
    }

    function getStorNext4d() {
        $partno = trim($this->input->post('idpickup', TRUE));
        $stornext = $this->kanban_master_m->findBySql("SELECT CHR_SLOC FROM [dbo].[TM_PARTS_SLOC] WHERE CHR_PART_NO = '$partno' AND (CHR_FLAG_DELETE IS NULL OR CHR_FLAG_DELETE='') AND CHR_SLOC !='WH00' ");
        $option = '';
        foreach ($stornext as $key => $value) {
            $option .= "<option value=\"$value->CHR_SLOC\">$value->CHR_SLOC</option>";
        }

        echo $option;
    }

    function getQtypass() {
        $partno = trim($this->input->post('idpickup', TRUE));
        $slocto = trim($this->input->post('slocto', TRUE));
        $qty = $this->kanban_master_m->findBySql("SELECT INT_QTY_PER_BOX 'qty' FROM [dbo].[TM_KANBAN] where CHR_PART_NO = '$partno' AND CHR_KANBAN_TYPE= '6' AND CHR_SLOC_TO='$slocto' ");
        if ($qty) {
            echo $qty[0]->qty;
        } else {
            echo '';
        }
    }

// END FUNCTION AJAX DATABARU


    public function getNextpro4() {
        $prodver = trim($this->input->post('prodver4', TRUE));
        $partno = trim($this->input->post('idpickup', TRUE));
        $partname = $this->kanban_master_m->findBySql("SELECT CHR_WORK_CENTER 'pname' FROM [dbo].[TM_PROCESS_PARTS] WHERE CHR_PV = '$prodver' AND CHR_PART_NO = '$partno'");
        if ($partname) {
            $selfpro = $partname[0]->pname;
            $option = " ";
            $partname = $this->kanban_master_m->findBySql("SELECT DISTINCT CHR_WORK_CENTER 'pname' from [dbo].[TM_PROCESS] WHERE CHR_WORK_CENTER <> '$selfpro' ");
            if (!empty($partname)) {
                foreach ($partname as $key => $value) {
                    $option .= "<option></option><option value=\"$value->pname\">$value->pname</option>";
                }
            }

            echo $option;
        } else {
            echo '';
        }
    }

    public function getSupplierb() {
        $partno = trim($this->input->post('bno'));
        $option = " ";
        $partname = $this->kanban_master_m->findBySql("SELECT CHR_SUPPLIER_ID 'pname' from [dbo].[TM_VENDOR_PARTS] where CHR_BACK_NO = '$partno'");
        if (!empty($partname)) {
            foreach ($partname as $key => $value) {
                $option .= "<option value=\"$value->pname\">$value->pname</option>";
            }
        }

        echo $option;
    }

    function cekPart11() {
        $part = trim($this->input->post('pno', true));
        $cek = $this->kanban_master_m->findBySql("SELECT CHR_PART_NO FROM [dbo].[TM_KANBAN] WHERE CHR_PART_NO = '$part' AND CHR_KANBAN_TYPE = '0'");

        echo json_encode($cek);
    }

    function cekPart12() {
        $part = trim($this->input->post('pno', true));
        $cek = $this->kanban_master_m->findBySql("SELECT CHR_PART_NO FROM [dbo].[TM_KANBAN] WHERE CHR_PART_NO = '$part' AND CHR_KANBAN_TYPE = '1'");

        echo json_encode($cek);
    }

    function cekPart13() {
        $part = trim($this->input->post('pno', true));
        $cek = $this->kanban_master_m->findBySql("SELECT CHR_PART_NO FROM [dbo].[TM_KANBAN] WHERE CHR_PART_NO = '$part' AND CHR_KANBAN_TYPE = '4'");

        echo json_encode($cek);
    }

    function cekPart14() {
        $part = trim($this->input->post('pno', true));
        $cek = $this->kanban_master_m->findBySql("SELECT CHR_PART_NO FROM [dbo].[TM_KANBAN] WHERE CHR_PART_NO = '$part' AND CHR_KANBAN_TYPE = '5'");

        echo json_encode($cek);
    }

    function cekPart14p() {
        $part = trim($this->input->post('pno', true));
        $cek = $this->kanban_master_m->findBySql("SELECT CHR_PART_NO FROM [dbo].[TM_KANBAN] WHERE CHR_PART_NO = '$part' AND CHR_KANBAN_TYPE = '6'");

        echo json_encode($cek);
    }

    function cekBox() {
        $part = trim($this->input->post('pno', true));
        $cek = $this->kanban_master_m->findBySql("SELECT CHR_BOX_TYPE FROM [dbo].[TM_BOX_TYPE] WHERE CHR_BOX_TYPE = '$part'");
        if ($cek) {
            $cek = trim($cek[0]->CHR_BOX_TYPE);
            echo $cek;
        } else {
            echo "tidak ada";
        }
    }

    function cekFlagor() {
        $idorder = trim($this->input->post('idorder', TRUE));
        $sud = trim($this->input->post('sud', TRUE));
        $type = '0';
        $x = $this->kanban_master_m->cekFlag($idorder, $type, $sud);
        if ($x == false) {
            echo true;
        } else {
            $x = $x[0]->CHR_FLAG_DELETE;
            if ($x == 'X') {
                echo false;
            } else {
                echo true;
            }
        }
    }

    function cekFlagpr() {
        $idproses = trim($this->input->post('idproses', TRUE));
        $prodver1 = trim($this->input->post('prodver1', TRUE));
        $type = '1';
        $x = $this->kanban_master_m->cekFlag($idproses, $type, $prodver1);
        if ($x == false) {
            echo true;
        } else {
            $x = $x[0]->CHR_FLAG_DELETE;
            if ($x == 'X') {
                echo false;
            } else {
                echo true;
            }
        }
    }

    function cekFlagsp() {
        $idsupply = trim($this->input->post('idsupply', TRUE));
        $sud = trim($this->input->post('sud2', TRUE));
        $type = '4';
        $x = $this->kanban_master_m->cekFlag($idsupply, $type, $sud);
        if ($x == false) {
            echo true;
        } else {
            $x = $x[0]->CHR_FLAG_DELETE;
            if ($x == 'X') {
                echo false;
            } else {
                echo true;
            }
        }
    }

    function cekFlagpu() {
        $idpickup = trim($this->input->post('idpickup', TRUE));
        $prodver3 = trim($this->input->post('prodver3', TRUE));
        $type = '5';
        $x = $this->kanban_master_m->cekFlag($idpickup, $type, $prodver3);
        if ($x == false) {
            echo true;
        } else {
            $x = $x[0]->CHR_FLAG_DELETE;
            if ($x == 'X') {
                echo false;
            } else {
                echo true;
            }
        }
    }

    function cekFlagpup() {
        $idpickup = trim($this->input->post('idpickup', TRUE));
        $slocto = trim($this->input->post('slocto', TRUE));
        $type = '6';
        $x = $this->kanban_master_m->cekFlagpass($idpickup, $type, $slocto);
        if ($x == false) {
            echo true;
        } else {
            $x = trim($x[0]->CHR_FLAG_DELETE);
            if ($x == "X") {
                echo false;
            } else {
                echo true;
            }
        }
    }

// ajax print
    public function getPart1() {
        $partno = $this->input->post('pno');
        $partno = trim($partno);
        $partname = $this->kanban_master_m->findBySql("SELECT CHR_PART_NAME 'pname' from [dbo].[TM_PARTS] WHERE CHR_PART_NO = '$partno' ");
        if ($partname) {
            echo $partname[0]->pname;
        } else {
            echo '';
        }
    }

    public function back_no1() {
        $partno = $this->input->post('pno');
        $partno = trim($partno);
        $partname = $this->kanban_master_m->findBySql("SELECT CHR_BACK_NO 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO = '$partno' AND CHR_KANBAN_TYPE='1'");
        if ($partname) {
            echo $partname[0]->pname;
        } else {
            echo '';
        }
    }

    public function back_no11() {
        $partno = trim($this->input->post('pno'));
        $partname = $this->kanban_master_m->findBySql("SELECT CHR_BACK_NO 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO = '$partno' AND (CHR_KANBAN_TYPE = '5' or CHR_KANBAN_TYPE = '6') ");
        if ($partname) {
            //echo "SELECT CHR_BACK_NO 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO = '$partno' AND (CHR_KANBAN_TYPE = '5' or CHR_KANBAN_TYPE = '6') ";
            echo $partname[0]->pname;
        } else {
            echo '';
        }
    }

    public function back_nop() {
        $partno = trim($this->input->post('pno'));
        $partname = $this->kanban_master_m->findBySql("SELECT CHR_BACK_NO 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO = '$partno' AND CHR_KANBAN_TYPE = '6'");
        if ($partname) {
            echo $partname[0]->pname;
        } else {
            echo '';
        }
    }

    public function getBackno() {
        $partno = trim($this->input->post('pno'));
        $partname = $this->kanban_master_m->findBySql("SELECT CHR_BACK_NO 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO = '$partno'");
        if ($partname) {
            echo $partname[0]->pname;
        } else {
            echo '';
        }
    }

    public function getIntPv1() {
        $partno = $this->input->post('pno');
        $partno = trim($partno);
        $option = " ";
        $partname = $this->kanban_master_m->findBySql("SELECT DISTINCT CHR_WC_VENDOR 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO = '$partno' AND CHR_KANBAN_TYPE = '1'");
// $partname=$partname[0]->pname;
        if (!empty($partname)) {
            foreach ($partname as $key => $value) {
                $option .= "<option value=\"$value->pname\">$value->pname</option>";
            }
        }

        echo $option;
    }

    public function getIntPv5() {
        $partno = trim($this->input->post('pno'));
        $option = " ";
        $partname = $this->kanban_master_m->findBySql("SELECT DISTINCT CHR_WC_VENDOR 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO = '$partno' AND CHR_KANBAN_TYPE = '5'");
        if (!empty($partname)) {
            foreach ($partname as $key => $value) {
                $option .= "<option value=\"$value->pname\">$value->pname</option>";
            }
        }

        echo $option;
    }

    public function getSupp() {
        $partno = trim($this->input->post('pno'));
        $partname = $this->kanban_master_m->findBySql("SELECT DISTINCT CHR_WC_VENDOR 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO = '$partno' AND CHR_KANBAN_TYPE = '4'");
        if (!empty($partname)) {
            foreach ($partname as $key => $value) {
                $option .= "<option value=\"$value->pname\">$value->pname</option>";
            }
        }

        echo $option;
    }

    public function getSuppu() {
        $partno = trim($this->input->post('pno'));
        $partname = $this->kanban_master_m->getsid1($partno);
        $sid = $this->kanban_master_m->findBySql("SELECT DISTINCT CHR_WC_VENDOR from [dbo].[TM_KANBAN] where CHR_KANBAN_TYPE = '4' AND CHR_PART_NO='$partno' ");
        if ($partname == false) {
            $option = '';
        } else {
            foreach ($partname as $key => $value) {
                $option .= "<option value=\"$value->CHR_WC_VENDOR\">$value->CHR_WC_VENDOR</option>";
            }
        }
        echo $option;
    }

    public function getSupporder() {
        $partno = trim($this->input->post('pno'));
        $option = " ";
        $partname = $this->kanban_master_m->findBySql("SELECT DISTINCT CHR_WC_VENDOR 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO = '$partno' AND CHR_KANBAN_TYPE = '0'");
        if (!empty($partname)) {
            foreach ($partname as $key => $value) {
                $option .= "<option value=\"$value->pname\">$value->pname</option>";
            }
        }

        echo $option;
    }

    public function getSuppName() {
        $partno = trim($this->input->post('idsupply', TRUE));
        $sid = trim($this->input->post('sid3', TRUE));
        $sname = $this->kanban_master_m->findBySql("SELECT CHR_SUPPLIER_NAME 'pname' FROM [dbo].[TM_VENDOR] WHERE CHR_SUPPLIER_ID ='$sid'");
        if ($sname) {
            echo $sname[0]->pname;
        } else {
            echo '';
        }
    }

    public function getSuppName3() {
        $sid = trim($this->input->post('sid', TRUE));
        $sname = $this->kanban_master_m->findBySql("SELECT CHR_SUPPLIER_NAME 'pname' FROM [dbo].[TM_VENDOR] WHERE CHR_SUPPLIER_ID ='$sid'");
        if ($sname) {
            echo $sname[0]->pname;
        } else {
            echo '';
        }
    }

    public function getSuppNameu() {
        $sud2 = trim($this->input->post('sud2'));
        $partname = $this->kanban_master_m->findBySql("SELECT CHR_SUPPLIER_NAME 'pname' FROM [dbo].[TM_VENDOR] WHERE CHR_SUPPLIER_ID ='$sud2'");
        if ($partname) {
            echo $partname[0]->pname;
        } else {
            echo '';
        }
    }

    public function getSuppNameuor() {
        $partno = trim($this->input->post('idorder'));
        $sud = trim($this->input->post('sud'));
        $partname = $this->kanban_master_m->findBySql("SELECT CHR_SUPPLIER_NAME 'pname' FROM [dbo].[TM_VENDOR] WHERE CHR_SUPPLIER_ID ='$sud'");
        if ($partname) {
            echo $partname[0]->pname;
        } else {
            echo '';
        }
    }

    public function storSelf1r() {
        $partno = trim($this->input->post('idpickup'));
        $sud = trim($this->input->post('prodver3'));
        $selfpro = $this->kanban_master_m->findBySql("SELECT DISTINCT CHR_SLOC_FROM 'selfpro' FROM [dbo].[TM_KANBAN] WHERE CHR_PART_NO = '$partno' AND CHR_KANBAN_TYPE= '5' AND CHR_WC_VENDOR = '$sud' ");

        if (!empty($selfpro)) {
            echo $selfpro[0]->selfpro;
        } else {
            echo '';
        }
    }

    public function storSelf1() {
        $partno = trim($this->input->post('idproses'));
        $sud = trim($this->input->post('pv1'));
        $option = " ";
        $selfpro = $this->kanban_master_m->findBySql("SELECT DISTINCT CHR_SLOC_FROM 'selfpro' FROM [dbo].[TM_KANBAN] WHERE CHR_PART_NO = '$partno' AND CHR_KANBAN_TYPE= '1' AND CHR_WC_VENDOR = '$sud' ");
        $selfpro = $selfpro[0]->selfpro;
        $partname = $this->kanban_master_m->findBySql("SELECT DISTINCT CHR_SLOC from [dbo].[TM_PARTS_SLOC] where CHR_PART_NO = '$partno'");

        if ($sud <> '') {
            $option .= "<option value=\"$selfpro\">$selfpro</option>";
            foreach ($partname as $key => $value) {
                $option .= "<option value=\"$value->CHR_SLOC\">$value->CHR_SLOC</option>";
            }
        }

        echo $option;
    }

    public function storSelf1pk() {
        $partno = trim($this->input->post('idproses'));
        $sud = trim($this->input->post('prodver1'));
        $option = " ";
        $selfpro = $this->kanban_master_m->findBySql("SELECT DISTINCT CHR_SLOC_FROM 'selfpro' FROM [dbo].[TM_KANBAN] WHERE CHR_PART_NO = '$partno' AND CHR_KANBAN_TYPE= '1' AND CHR_WC_VENDOR = '$sud' ");

        if ($selfpro) {
            $selfpro = $selfpro[0]->selfpro;
            if ($selfpro == "0") {
                echo '';
            } else {
                echo $selfpro;
            }
        } else {
            echo '';
        }
    }

    public function ss1() {
        $partno = trim($this->input->post('idproses'));
        $sud = trim($this->input->post('prodver1'));
        $selfpro = $this->kanban_master_m->findBySql("SELECT DISTINCT CHR_SLOC_FROM 'selfpro' FROM [dbo].[TM_KANBAN] WHERE CHR_PART_NO = '$partno' AND CHR_KANBAN_TYPE= '1' AND CHR_WC_VENDOR = '$sud' ");
        if (!empty($selfpro)) {
            echo $selfpro = $selfpro[0]->selfpro;
        } else {
            echo '';
        }
    }

    public function storSelf1u() {
        $partno = trim($this->input->post('idpickup'));
        $sud = trim($this->input->post('pv3'));
        $option = " ";
        $selfpro = $this->kanban_master_m->findBySql("SELECT DISTINCT CHR_SLOC_FROM 'selfpro' FROM [dbo].[TM_KANBAN] WHERE CHR_PART_NO = '$partno' AND CHR_KANBAN_TYPE= '5' AND CHR_WC_VENDOR = '$sud' ");
        $selfpro = $selfpro[0]->selfpro;
        $partname = $this->kanban_master_m->findBySql("SELECT DISTINCT CHR_SLOC from [dbo].[TM_PARTS_SLOC] where CHR_PART_NO = '$partno'");

        if (!empty($selfpro)) {
            $option .= "<option value=\"$selfpro\">$selfpro</option>";
        }
        foreach ($partname as $key => $value) {
            $option .= "<option>$value->CHR_SLOC</option>";
        }
        echo $option;
    }

// get storage self process kanban pickup
    public function storSelf1u1() {
        $partno = trim($this->input->post('idpickup'));
        $option = " ";
        $selfpro = $this->kanban_master_m->findBySql("SELECT DISTINCT CHR_SLOC_FROM 'selfpro' FROM [dbo].[TM_KANBAN] WHERE CHR_PART_NO = '$partno' AND CHR_KANBAN_TYPE= '5'");
        $selfpro = $selfpro[0]->selfpro;
        $partname = $this->kanban_master_m->findBySql("SELECT DISTINCT CHR_SLOC from [dbo].[TM_PARTS_SLOC] where CHR_PART_NO = '$partno'");

        if ($partname) {
            $option .= "<option value=\"$selfpro\">$selfpro</option>";
            foreach ($partname as $key => $value) {
                $option .= "<option>$value->CHR_SLOC</option>";
            }
        }

        echo $option;
    }

    public function storSelfpp() {
        $partno = trim($this->input->post('idpickup'));
        $option = " ";
        $selfpro = $this->kanban_master_m->findBySql("SELECT DISTINCT CHR_SLOC_FROM 'selfpro' FROM [dbo].[TM_KANBAN] WHERE CHR_PART_NO = '$partno' AND CHR_KANBAN_TYPE= '6'");

        if (!empty($selfpro)) {
            echo $selfpro[0]->selfpro;
        } else {
            echo '';
        }
    }

    public function storSelf1u2() {
        $partno = trim($this->input->post('idpickup'));
        $option = " ";
        $selfpro = $this->kanban_master_m->findBySql("SELECT DISTINCT CHR_SLOC_TO 'selfpro' FROM [dbo].[TM_KANBAN] WHERE CHR_PART_NO = '$partno' AND CHR_KANBAN_TYPE= '5'");
        $selfpro = $selfpro[0]->selfpro;
        $partname = $this->kanban_master_m->findBySql("SELECT DISTINCT CHR_SLOC from [dbo].[TM_PARTS_SLOC] where CHR_PART_NO = '$partno'");

        if ($partname) {
            $option .= "<option value=\"$selfpro\">$selfpro</option>";
            foreach ($partname as $key => $value) {
                $option .= "<option>$value->CHR_SLOC</option>";
            }
        }

        echo $option;
    }

    public function storNextpass() {
        $partno = trim($this->input->post('idpickup'));
        $option = " ";
        $selfpro = $this->kanban_master_m->findBySql("SELECT DISTINCT CHR_SLOC_TO FROM [dbo].[TM_KANBAN] WHERE CHR_PART_NO = '$partno' AND CHR_KANBAN_TYPE= '6'");
        if ($selfpro) {
            foreach ($selfpro as $key => $value) {
                $option .= "<option>$value->CHR_SLOC_TO</option>";
            }
        }

        echo $option;
    }

    public function storNextpp() {
        $partno = trim($this->input->post('idpickup'));
        $option = " ";
        $selfpro = $this->kanban_master_m->findBySql("SELECT DISTINCT CHR_SLOC_TO 'selfpro' FROM [dbo].[TM_KANBAN] WHERE CHR_PART_NO = '$partno' AND CHR_KANBAN_TYPE= '6'");
        $selfpro = $selfpro[0]->selfpro;
        $partname = $this->kanban_master_m->findBySql("SELECT DISTINCT CHR_SLOC_TO from [dbo].[TM_KANBAN] where CHR_PART_NO = '$partno'");

        if ($partname) {
            $option .= "<option value=\"$selfpro\">$selfpro</option>";
            foreach ($partname as $key => $value) {
                $option .= "<option>$value->CHR_SLOC_TO</option>";
            }
        }

        echo $option;
    }

    public function storSelf11() {
        $idpickup = trim($this->input->post('idpickup', TRUE));
        $prodver3 = trim($this->input->post('prodver3', TRUE));
        $partname = $this->kanban_master_m->findBySql("SELECT DISTINCT CHR_SLOC_FROM 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO = '$idpickup' AND CHR_WC_VENDOR = '$prodver3'");
        if ($partname) {
            $partname = $partname[0]->pname;
            if ($partname == "0") {
                echo '';
            } else {
                echo $partname;
            }
        } else {
            echo '';
        }
    }

    public function storSelf11p() {
        $idpickup = trim($this->input->post('idpickup', TRUE));
        $prodver3 = trim($this->input->post('prodver3', TRUE));
        $partname = $this->kanban_master_m->findBySql("SELECT DISTINCT CHR_SLOC_FROM 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO = '$idpickup' AND CHR_WC_VENDOR = '$prodver3' and CHR_KANBAN_TYPE='5' ");
        if ($partname) {
            $partname = $partname[0]->pname;
            if ($partname == "0") {
                echo '';
            } else {
                echo $partname;
            }
        } else {
            echo '';
        }
    }

    public function getSelfpro1() {
        $prodver1 = $this->input->post('prodver1', TRUE);
        $prodver1 = trim($prodver1);
        $idproses = $this->input->post('idproses', TRUE);
        $idproses = trim($idproses);
        $partname = $this->kanban_master_m->findBySql("SELECT CHR_WORK_CENTER 'pname' from [dbo].[TM_PROCESS_PARTS] where CHR_PART_NO = '$idproses' and CHR_PV = '$prodver1' ");
//   var_dump($partname);die();
        if ($partname) {
            echo $partname[0]->pname;
        } else {
            echo '';
        }
    }

    public function getSelfprou() {
        $pv1 = trim($this->input->post('pv1', TRUE));
        $idproses = trim($this->input->post('idproses', TRUE));
        $partname = $this->kanban_master_m->findBySql("SELECT CHR_WORK_CENTER 'pname' from [dbo].[TM_PROCESS_PARTS] where CHR_PART_NO = '$idproses' and CHR_PV = '$pv1' ");
//   var_dump($partname);die();
        if ($partname) {
            echo $partname[0]->pname;
        } else {
            echo '';
        }
    }

    public function getSelfpro3() {
        $prodver3 = trim($this->input->post('prodver3', TRUE));
        $idpickup = trim($this->input->post('idpickup', TRUE));
        $partname = $this->kanban_master_m->findBySql("SELECT CHR_WORK_CENTER 'pname' from [dbo].[TM_PROCESS_PARTS] where CHR_PART_NO = '$idpickup' and CHR_PV = '$prodver3' ");
// var_dump($partname);die();
        if ($partname) {
            echo $partname[0]->pname;
        } else {
            echo '';
        }
    }

    public function getSelfprou3() {
        $pv3 = trim($this->input->post('pv3', TRUE));
        $idpickup = trim($this->input->post('idpickup', TRUE));
        $partname = $this->kanban_master_m->findBySql("SELECT CHR_WORK_CENTER 'pname' from [dbo].[TM_PROCESS_PARTS] where CHR_PART_NO = '$idpickup' and CHR_PV = '$pv3' ");
// var_dump($partname);die();
        if ($partname) {
            echo $partname[0]->pname;
        } else {
            echo '';
        }
    }

    public function getNextpro1() {
        $partno = trim($this->input->post('idproses', TRUE));
        $pv3 = trim($this->input->post('pv1', TRUE));
        $option = "";
        $partname = $this->kanban_master_m->findBySql("SELECT CHR_WORK_CENTER 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO = '$partno'and CHR_KANBAN_TYPE = '1' AND CHR_WC_VENDOR = '$pv3' ");
        $partname = $partname[0]->pname;
        $nextpro = $this->kanban_master_m->findBySql("SELECT DISTINCT CHR_WORK_CENTER from [dbo].[TM_PROCESS] ");

        if ($nextpro) {

            $option .= "<option value=\"$partname\">$partname</option><option></option>";
            foreach ($nextpro as $key => $value) {
                $option .= "<option value=\"$value->CHR_WORK_CENTER\">$value->CHR_WORK_CENTER</option>";
            }
        }

        echo $option;
    }

    public function getNextpro1pk() {
        $partno = trim($this->input->post('idproses', TRUE));
        $pv3 = trim($this->input->post('prodver1', TRUE));
        $partname = $this->kanban_master_m->findBySql("SELECT CHR_WORK_CENTER from [dbo].[TM_KANBAN] where CHR_PART_NO = '$partno' AND CHR_WC_VENDOR = '$pv3' AND CHR_KANBAN_TYPE = '1' ");
        if ($partname) {
            echo $partname = $partname[0]->CHR_WORK_CENTER;
        } else {

            echo '';
        }
    }

    public function getNextpro5pk() {
        $partno = trim($this->input->post('idpickup', TRUE));
        $pv3 = trim($this->input->post('prodver3', TRUE));
        $partname = $this->kanban_master_m->check_nextpk5($partno, $pv3);
        if ($partname == false) {
            $partname = '';
        } else {
            $partname = $partname[0]->CHR_WORK_CENTER;
            if ($partname == NULL) {
                $partname = '';
            }
        }
        echo $partname;
    }

    public function getnp1() {
        $partno = trim($this->input->post('idproses', TRUE));
        $pv3 = trim($this->input->post('prodver1', TRUE));
        $partname = $this->kanban_master_m->findBySql("SELECT CHR_WORK_CENTER 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO = '$partno'and CHR_KANBAN_TYPE = '1' AND CHR_WC_VENDOR = '$pv3' ");

        if ($partname) {
            echo $partname = $partname[0]->pname;
        } else {
            echo '';
        }
    }

    public function getNextpro5() {
        $partno = trim($this->input->post('idpickup', TRUE));
        $pv3 = trim($this->input->post('pv3', TRUE));
        $partname = $this->kanban_master_m->findBySql("SELECT CHR_WORK_CENTER 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO = '$partno'and CHR_KANBAN_TYPE = '5' AND CHR_WC_VENDOR = '$pv3' ");
        $partname = $partname[0]->pname;
        $option = " ";
        $nextpro = $this->kanban_master_m->findBySql("SELECT DISTINCT CHR_WORK_CENTER from [dbo].[TM_PROCESS] ");

        if ($nextpro) {
            $option .= "<option value=\"$partname\">$partname</option>";
            $option .= "<option></option>";
            foreach ($nextpro as $key => $value) {
                $option .= "<option value=\"$value->CHR_WORK_CENTER\">$value->CHR_WORK_CENTER</option>";
            }
        }

        echo $option;
    }

    public function getNextpro5r() {
        $partno = trim($this->input->post('idpickup', TRUE));
        $pv3 = trim($this->input->post('prodver3', TRUE));
        $partname = $this->kanban_master_m->findBySql("SELECT CHR_WORK_CENTER 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO = '$partno'and CHR_KANBAN_TYPE = '1' AND CHR_WC_VENDOR = '$pv3' ");

        if ($partname) {
            $partname = $partname[0]->pname;
        } else {
            echo '';
        }
    }

    public function storNext1() {
        $partno = trim($this->input->post('pno'));
        $partname = $this->kanban_master_m->findBySql("SELECT DISTINCT CHR_SLOC 'pname' from [dbo].[TM_PARTS_SLOC] where CHR_PART_NO = '$partno' ");
        if ($partname) {
            echo $partname[0]->pname;
        } else {
            echo '';
        }
    }

    public function storNextpk() {
        $partno = trim($this->input->post('idproses', TRUE));
        $pv = trim($this->input->post('prodver1', TRUE));
        $partname = $this->kanban_master_m->findBySql("SELECT DISTINCT CHR_SLOC_TO 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO = '$partno' AND CHR_KANBAN_TYPE = '1' AND CHR_WC_VENDOR = '$pv' ");
        if ($partname) {
            echo $partname[0]->pname;
        } else {
            echo '';
        }
    }

    public function storNext1u() {
        $partno = trim($this->input->post('idproses', TRUE));
        $pv = trim($this->input->post('pv1', TRUE));
        $partname = $this->kanban_master_m->findBySql("SELECT DISTINCT CHR_SLOC_TO 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO = '$partno' AND CHR_KANBAN_TYPE = '1' AND CHR_WC_VENDOR = '$pv' ");
        if ($partname) {
            echo $partname[0]->pname;
        } else {
            echo '';
        }
    }

    public function storNext2u() {
        $partno = trim($this->input->post('idpickup', TRUE));
        $pv = trim($this->input->post('pv3', TRUE));
        $partname = $this->kanban_master_m->findBySql("SELECT DISTINCT CHR_SLOC_TO 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO = '$partno' AND CHR_KANBAN_TYPE = '5' AND CHR_WC_VENDOR = '$pv' ");
        if ($partname) {
            echo $partname[0]->pname;
        } else {
            echo '';
        }
    }

    public function storNext11() {
        $idpickup = trim($this->input->post('idpickup', TRUE));
        $prodver3 = trim($this->input->post('prodver3', TRUE));
        $partname = $this->kanban_master_m->findBySql("SELECT DISTINCT CHR_SLOC_TO 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO = '$idpickup' AND CHR_WC_VENDOR = '$prodver3'");
        if ($partname) {
            echo $partname[0]->pname;
        } else {
            echo '';
        }
    }

    public function storNext11p() {
        $idpickup = trim($this->input->post('idpickup', TRUE));
        $prodver3 = trim($this->input->post('prodver3', TRUE));
        $partname = $this->kanban_master_m->findBySql("SELECT DISTINCT CHR_SLOC_TO 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO = '$idpickup' AND CHR_WC_VENDOR = '$prodver3' and CHR_KANBAN_TYPE='5'");
        if ($partname) {
            echo $partname[0]->pname;
        } else {
            echo '';
        }
    }

    public function qtyPerbox1() {
        $idproses = trim($this->input->post('idproses', TRUE));
        $prodver1 = trim($this->input->post('prodver1', TRUE));
        $partname = $this->kanban_master_m->findBySql("SELECT INT_QTY_PER_BOX 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO = '$idproses' and CHR_WC_VENDOR = '$prodver1' and CHR_KANBAN_TYPE = '1'");
        if ($partname) {
            echo $partname[0]->pname;
        } else {
            echo '';
        }
    }

    public function qtyPerboxu() {
        $idproses = trim($this->input->post('idproses', TRUE));
        $pv1 = trim($this->input->post('pv1', TRUE));
        $partname = $this->kanban_master_m->findBySql("SELECT INT_QTY_PER_BOX 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO = '$idproses' and CHR_WC_VENDOR = '$pv1' and CHR_KANBAN_TYPE = '1'");
        if ($partname) {
            echo $partname[0]->pname;
        } else {
            echo '';
        }
    }

    public function qtyPerboxu2() {
        $idsupply = trim($this->input->post('idsupply', TRUE));
        $sid = trim($this->input->post('sud2', TRUE));
        $partname = $this->kanban_master_m->findBySql("SELECT INT_QTY_PER_BOX 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO = '$idsupply' and CHR_KANBAN_TYPE = '4' and CHR_WC_VENDOR='$sid' ");
        if ($partname) {
            echo $partname[0]->pname;
        } else {
            echo '';
        }
    }

    public function qtyPerbox3() {
        $idpickup = trim($this->input->post('idpickup', TRUE));
        $prodver3 = trim($this->input->post('prodver3', TRUE));
        $partname = $this->kanban_master_m->getQty($idpickup, $prodver3);
        if ($partname == false) {
            echo '';
        } else {
            echo $partname[0]->INT_QTY_PER_BOX;
        }
    }

    public function qtyPerbox3p() {
        $idpickup = trim($this->input->post('idpickup', TRUE));
        $slocto = trim($this->input->post('slocto', TRUE));
        $partname = $this->kanban_master_m->findBySql("SELECT INT_QTY_PER_BOX 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO = '$idpickup' and CHR_SLOC_TO = '$slocto' AND CHR_KANBAN_TYPE = '6'");
        if ($partname) {
            echo $partname[0]->pname;
        } else {
            echo '';
        }
    }

    public function qtyPerboxu3() {
        $idpickup = trim($this->input->post('idpickup', TRUE));
        $pv3 = trim($this->input->post('pv3', TRUE));
        $partname = $this->kanban_master_m->findBySql("SELECT INT_QTY_PER_BOX 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO = '$idpickup' and CHR_WC_VENDOR = '$pv3' and CHR_KANBAN_TYPE = '5'");
        if ($partname) {
            echo $partname[0]->pname;
        } else {
            echo '';
        }
    }

    public function qtyPerbox4() {
        $idsupply = trim($this->input->post('idsupply', TRUE));
        $sid = trim($this->input->post('sid3', TRUE));
        $qtybox = $this->kanban_master_m->findBySql("SELECT INT_QTY_PER_BOX 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO='$idsupply' and CHR_WC_VENDOR='$sid' and CHR_KANBAN_TYPE='4'");
        if ($qtybox) {
            echo $qtybox[0]->pname;
        } else {
            echo '';
        }
    }

    public function qtyPerboxor() {
        $idorder = trim($this->input->post('idorder', TRUE));
        $sid = trim($this->input->post('sid', TRUE));
        $qtybox = $this->kanban_master_m->findBySql("SELECT INT_QTY_PER_BOX 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO = '$idorder' and CHR_WC_VENDOR = '$sid' and CHR_KANBAN_TYPE = '0'");
        if ($qtybox) {
            echo $qtybox[0]->pname;
        } else {
            echo '';
        }
    }

    public function qpbu() {
        $idorder = trim($this->input->post('idorder', TRUE));
        $sud = trim($this->input->post('sud', TRUE));
        $partname = $this->kanban_master_m->findBySql("SELECT INT_QTY_PER_BOX 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO = '$idorder' and CHR_WC_VENDOR = '$sud' and CHR_KANBAN_TYPE = '0'");
        if ($partname) {
            echo $partname[0]->pname;
        } else {
            echo '';
        }
    }

    public function boxType1() {
        $idproses = trim($this->input->post('idproses', TRUE));
        $prodver1 = trim($this->input->post('prodver1', TRUE));
        $partname = $this->kanban_master_m->findBySql("SELECT CHR_BOX_TYPE 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO = '$idproses' and CHR_WC_VENDOR = '$prodver1' and CHR_KANBAN_TYPE = '1'");
        if (!empty($partname)) {
            echo $partname[0]->pname;
        } else {
            echo '';
        }
    }

    public function boxTypeu() {
        $idproses = trim($this->input->post('idproses', TRUE));
        $pv1 = trim($this->input->post('pv1', TRUE));
        $option = '';
        $box = $this->kanban_master_m->findBySql("SELECT CHR_BOX_TYPE FROM [dbo].[TM_BOX_TYPE]");
        $partname = $this->kanban_master_m->findBySql("SELECT CHR_BOX_TYPE 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO = '$idproses' and CHR_WC_VENDOR = '$pv1' and CHR_KANBAN_TYPE = '1'");
        $partname = $partname[0]->pname;
        if ($box) {
            $option .= "<option value=\"$partname\">$partname</option>";
            foreach ($box as $key => $value) {
                $option .= "<option value=\"$value->CHR_BOX_TYPE\">$value->CHR_BOX_TYPE</option>";
            }
        }

        echo $option;
    }

    public function boxTypeu1() {
        $idproses = trim($this->input->post('idproses', TRUE));
        $pv1 = trim($this->input->post('pv1', TRUE));
        $partname = $this->kanban_master_m->findBySql("SELECT CHR_BOX_TYPE 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO = '$idproses' and CHR_WC_VENDOR = '$pv1' and CHR_KANBAN_TYPE = '4'");
        if ($partname) {
            echo $partname[0]->pname;
        } else {
            echo '';
        }
    }

    public function boxTypeu3() {
        $idpickup = trim($this->input->post('idpickup', TRUE));
        $pv3 = trim($this->input->post('pv3', TRUE));
        $option = '';
        $box = $this->kanban_master_m->findBySql("SELECT CHR_BOX_TYPE FROM [dbo].[TM_BOX_TYPE]");
        $partname = $this->kanban_master_m->findBySql("SELECT CHR_BOX_TYPE 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO = '$idpickup' and CHR_WC_VENDOR = '$pv3' and CHR_KANBAN_TYPE = '5'");
        $partname = $partname[0]->pname;
        if ($box) {
            $option .= "<option value=\"$partname\">$partname</option>";
            foreach ($box as $key => $value) {
                $option .= "<option value=\"$value->CHR_BOX_TYPE\">$value->CHR_BOX_TYPE</option>";
            }
        }

        echo $option;
    }

    public function boxTypeu3pp() {
        $idpickup = trim($this->input->post('idpickup', TRUE));
        $slocto = trim($this->input->post('slocto', TRUE));
        $slocfrom = trim($this->input->post('slocfrom', TRUE));
        $option = '';
        $box = $this->kanban_master_m->findBySql("SELECT CHR_BOX_TYPE FROM [dbo].[TM_BOX_TYPE]");
        $partname = $this->kanban_master_m->findBySql("SELECT CHR_BOX_TYPE 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO ='$idpickup' and CHR_SLOC_FROM ='$slocfrom' AND CHR_SLOC_TO='$slocto' and CHR_KANBAN_TYPE ='6'");
        if (!empty($partname)) {
            $partname = $partname[0]->pname;
        } else {
            $partname = '';
        }

        if ($box) {
            $option .= "<option value=\"$partname\">$partname</option>";
            foreach ($box as $key => $value) {
                $option .= "<option value=\"$value->CHR_BOX_TYPE\">$value->CHR_BOX_TYPE</option>";
            }
        }

        echo $option;
    }

    public function boxType3() {
        $idpickup = trim($this->input->post('idpickup', TRUE));
        $prodver3 = trim($this->input->post('prodver3', TRUE));
        $partname = $this->kanban_master_m->findBySql("SELECT CHR_BOX_TYPE 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO = '$idpickup' and CHR_WC_VENDOR = '$prodver3' and (CHR_KANBAN_TYPE = '5' or CHR_KANBAN_TYPE = '6')");
        if ($partname) {
            echo $partname[0]->pname;
        } else {
            echo '';
        }
    }

    public function boxType3p() {
        $idpickup = trim($this->input->post('idpickup', TRUE));
        $slocto = trim($this->input->post('slocto', TRUE));
        $partname = $this->kanban_master_m->findBySql("SELECT CHR_BOX_TYPE 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO = '$idpickup' AND CHR_KANBAN_TYPE = '6' AND CHR_SLOC_TO='$slocto' ");
        if ($partname) {
            echo $partname[0]->pname;
        } else {
            echo '';
        }
    }

    public function boxType4() {
        $idsupply = trim($this->input->post('idsupply', TRUE));
        $sid = trim($this->input->post('sid3', TRUE));
        $partname = $this->kanban_master_m->findBySql("SELECT CHR_BOX_TYPE 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO = '$idsupply' and CHR_WC_VENDOR = '$sid' and CHR_KANBAN_TYPE = '4'");
        if ($partname) {
            echo $partname[0]->pname;
        } else {
            echo '';
        }
    }

    public function boxTypeor() {
        $idorder = trim($this->input->post('idorder', TRUE));
        $sid = $this->input->post('sid', TRUE);
        $partname = $this->kanban_master_m->findBySql("SELECT CHR_BOX_TYPE 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO = '$idorder' and CHR_WC_VENDOR = '$sid' and CHR_KANBAN_TYPE = '0'");
        if ($partname) {
            echo $partname[0]->pname;
        } else {
            echo '';
        }
    }

    public function btu() {
        $idorder = trim($this->input->post('idorder', TRUE));
        $sud = trim($this->input->post('sud', TRUE));
        $option = '';
        $box = $this->kanban_master_m->findBySql("SELECT CHR_BOX_TYPE FROM [dbo].[TM_BOX_TYPE]");
        $partname = $this->kanban_master_m->findBySql("SELECT CHR_BOX_TYPE 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO = '$idorder' and CHR_WC_VENDOR = '$sud' and CHR_KANBAN_TYPE = '0'");
        $partname = $partname[0]->pname;
        if ($box) {
            $option .= "<option value=\"$partname\">$partname</option>";
            foreach ($box as $key => $value) {
                $option .= "<option value=\"$value->CHR_BOX_TYPE\">$value->CHR_BOX_TYPE</option>";
            }
        }

        echo $option;
    }

    public function btu2() {
        $idsupply = trim($this->input->post('idsupply', TRUE));
        $sud = trim($this->input->post('sud2', TRUE));
        $option = '';
        $box = $this->kanban_master_m->findBySql("SELECT CHR_BOX_TYPE FROM [dbo].[TM_BOX_TYPE]");
        $partname = $this->kanban_master_m->findBySql("SELECT CHR_BOX_TYPE 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO = '$idsupply' and CHR_WC_VENDOR = '$sud' and CHR_KANBAN_TYPE = '4'");
        $partname = $partname[0]->pname;
        if ($box) {
            $option .= "<option value=\"$partname\">$partname</option>";
            foreach ($box as $key => $value) {
                $option .= "<option value=\"$value->CHR_BOX_TYPE\">$value->CHR_BOX_TYPE</option>";
            }
        }

        echo $option;
    }

    public function side1() {
        $idproses = trim($this->input->post('idproses', TRUE));
        $prodver1 = trim($this->input->post('prodver1', TRUE));
        $partname = $this->kanban_master_m->findBySql("SELECT CHR_SIDE 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO = '$idproses' and CHR_WC_VENDOR = '$prodver1' and CHR_KANBAN_TYPE = '1'");
        if ($partname) {
            echo $partname[0]->pname;
        } else {
            echo '';
        }
    }

    public function keterangan1() {
        $idproses = trim($this->input->post('idproses', TRUE));
        $prodver1 = trim($this->input->post('prodver1', TRUE));
        if (!$prodver1) {
            echo '';
        } else {
            $partname = $this->kanban_master_m->findBySql("SELECT CHR_KETERANGAN 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO = '$idproses' and CHR_WC_VENDOR = '$prodver1' and CHR_KANBAN_TYPE = '1'");
            if ($partname) {
                echo $partname[0]->pname;
            } else {
                echo '';
            }
        }
    }

    public function keterangan2() {
        $idorder = trim($this->input->post('idorder', TRUE));
        $sid = trim($this->input->post('sid', TRUE));
        $part = $this->kanban_master_m->findBySql("SELECT CHR_KETERANGAN 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO = '$idorder' and CHR_WC_VENDOR = '$sid' and CHR_KANBAN_TYPE = '0'");
        if (!empty($part)) {
            echo $part[0]->pname;
        } else {
            echo '';
        }
    }

    public function keterangan4() {
        $idorder = trim($this->input->post('idsupply', TRUE));
        $sid = trim($this->input->post('sid3', TRUE));
        if ($sid == '') {
            echo '';
        } else {
            $part = $this->kanban_master_m->findBySql("SELECT CHR_KETERANGAN 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO = '$idorder' and CHR_WC_VENDOR = '$sid' and CHR_KANBAN_TYPE = '4'");
            if ($part) {
                echo $part[0]->pname;
            } else {
                echo '';
            }
        }
    }

    public function keterangan3() {
        $idpickup = trim($this->input->post('idpickup', TRUE));
        $prodver1 = trim($this->input->post('prodver3', TRUE));
        if ($prodver1 == '') {
            $partname = '';
        } else {
            $partname = $this->kanban_master_m->findBySql("SELECT CHR_KETERANGAN 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO = '$idpickup' and CHR_WC_VENDOR = '$prodver1' and CHR_KANBAN_TYPE = '5'");
            $partname = $partname[0]->pname;
            if ($partname == NULL or $partname == '') {
                $partname = '';
            }
        }
        echo $partname;
    }

    public function keterangan3pp() {
        $idpickup = trim($this->input->post('idpickup', TRUE));
        $partname = $this->kanban_master_m->findBySql("SELECT CHR_KETERANGAN 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO = '$idpickup' and CHR_KANBAN_TYPE = '6'");
        if ($partname) {
            echo $partname[0]->pname;
        } else {
            echo '';
        }
    }

    public function keterangan3p() {
        $idpickup = trim($this->input->post('idpickup', TRUE));
        $slocto = trim($this->input->post('slocto', TRUE));
        $partname = $this->kanban_master_m->findBySql("SELECT CHR_KETERANGAN 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO = '$idpickup' and  CHR_KANBAN_TYPE = '6' AND CHR_SLOC_TO='$slocto' ");
        if ($partname) {
            echo $partname[0]->pname;
        } else {
            echo '';
        }
    }

    public function sideu() {
        $idorder = trim($this->input->post('idorder', TRUE));
        $sud = $this->input->post('sud', TRUE);
        $partname = $this->kanban_master_m->findBySql("SELECT CHR_SIDE 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO = '$idorder' and CHR_WC_VENDOR = '$sud' and CHR_KANBAN_TYPE = '0'");
        $option = " ";
        if (!empty($partname)) {
            $side = trim($partname[0]->pname);
            $option .= "<option value=\"$side\">$side</option>";

            if ($side == "LH") {
                $option .= "<option></option><option>RH</option><option>LH/RH</option>";
            } else if ($side == "RH") {
                $option .= "<option></option>";
                $option .= "<option>LH</option>";
                $option .= "<option>LH/RH</option>";
            } else if ($side == "LH/RH") {
                $option .= "<option></option><option>RH</option><option>LH</option>";
            } else if ($side == "") {
                $option .= "<option>LH</option><option>RH</option><option>LH/RH</option>";
            }
        } else {
            $option .= "<option></option><option>LH</option><option>RH</option><option>LH/RH</option>";
        }
        echo $option;
    }

    public function sideu1() {
        $idproses = trim($this->input->post('idproses', TRUE));
        $sud = trim($this->input->post('pv1', TRUE));
        $option = " ";
        $partname = $this->kanban_master_m->findBySql("SELECT CHR_SIDE 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO = '$idproses' and CHR_WC_VENDOR = '$sud' and CHR_KANBAN_TYPE = '1'");
        if (!empty($partname)) {
            $side = trim($partname[0]->pname);
            $option .= "<option value=\"$side\">$side</option>";

            if ($side == "LH") {
                $option .= "<option></option><option>RH</option><option>LH/RH</option>";
            } else if ($side == "RH") {
                $option .= "<option></option>";
                $option .= "<option>LH</option>";
                $option .= "<option>LH/RH</option>";
            } else if ($side == "LH/RH") {
                $option .= "<option></option><option>RH</option><option>LH</option>";
            } else if ($side == "") {
                $option .= "<option>LH</option><option>RH</option><option>LH/RH</option>";
            }
        } else {
            $option .= "<option></option><option>LH</option><option>RH</option><option>LH/RH</option>";
        }
        echo $option;
    }

    public function sideu2() {
        $idsupply = trim($this->input->post('idsupply', TRUE));
        $sud2 = trim($this->input->post('sud2', TRUE));
        $partname = $this->kanban_master_m->findBySql("SELECT CHR_SIDE 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO = '$idsupply' and CHR_WC_VENDOR = '$sud2' and CHR_KANBAN_TYPE = '4'");
        if (!empty($partname)) {
            $side = trim($partname[0]->pname);
            $option .= "<option value=\"$side\">$side</option>";

            if ($side == "LH") {
                $option .= "<option></option><option>RH</option><option>LH/RH</option>";
            } else if ($side == "RH") {
                $option .= "<option></option>";
                $option .= "<option>LH</option>";
                $option .= "<option>LH/RH</option>";
            } else if ($side == "LH/RH") {
                $option .= "<option></option><option>RH</option><option>LH</option>";
            } else if ($side == "") {
                $option .= "<option>LH</option><option>RH</option><option>LH/RH</option>";
            }
        } else {
            $option .= "<option></option><option>RH</option><option>LH</option><option>LH/RH</option>";
        }

        echo $option;
    }

    public function side3() {
        $idpickup = trim($this->input->post('idpickup', TRUE));
        $prodver3 = trim($this->input->post('prodver3', TRUE));
        $partname = $this->kanban_master_m->findBySql("SELECT CHR_SIDE 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO = '$idpickup' and CHR_WC_VENDOR = '$prodver3' and CHR_KANBAN_TYPE = '5'");
        if ($partname) {
            echo $partname[0]->pname;
        } else {
            echo '';
        }
    }

    public function side3p() {
        $idpickup = trim($this->input->post('idpickup', TRUE));
        $slocto = trim($this->input->post('slocto', TRUE));
        $partname = $this->kanban_master_m->findBySql("SELECT CHR_SIDE 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO = '$idpickup' and CHR_KANBAN_TYPE = '6' AND CHR_SLOC_TO='$slocto' ");
        if ($partname) {
            echo $partname[0]->pname;
        } else {
            echo '';
        }
    }

    public function sidepp() {
        $idpickup = trim($this->input->post('idpickup', TRUE));
        $partname = $this->kanban_master_m->findBySql("SELECT CHR_SIDE 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO = '$idpickup' and CHR_KANBAN_TYPE = '6' and CHR_SLOC_FROM='WH00' ");
        if ($partname) {
            echo $partname[0]->pname;
        } else {
            echo '';
        }
    }

    public function sideu3() {
        $idpickup = trim($this->input->post('idpickup', TRUE));
        $pv3 = $this->input->post('pv3', TRUE);
        $partname = $this->kanban_master_m->findBySql("SELECT CHR_SIDE 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO = '$idpickup' and CHR_WC_VENDOR = '$pv3' and CHR_KANBAN_TYPE = '5'");
        if (!empty($partname)) {
            $side = trim($partname[0]->pname);
            $option .= "<option value=\"$side\">$side</option>";

            if ($side == "LH") {
                $option .= "<option></option><option>RH</option><option>LH/RH</option>";
            } else if ($side == "RH") {
                $option .= "<option></option>";
                $option .= "<option>LH</option>";
                $option .= "<option>LH/RH</option>";
            } else if ($side == "LH/RH") {
                $option .= "<option></option><option>RH</option><option>LH</option>";
            } else if ($side == "NONE" OR $side == "") {
                $option .= "<option>LH</option><option>RH</option><option>LH/RH</option>";
            }
        } else {
            $option .= "<option></option><option>LH</option><option>RH</option><option>LH/RH</option>";
        }
        echo $option;
    }

    public function sideu3p() {
        $idpickup = trim($this->input->post('idpickup', TRUE));
        $partname = $this->kanban_master_m->findBySql("SELECT CHR_SIDE 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO = '$idpickup' and CHR_KANBAN_TYPE = '6'");
        if (!empty($partname)) {
            $side = trim($partname[0]->pname);
            $option .= "<option value=\"$side\">$side</option>";

            if ($side == "LH") {
                $option .= "<option></option><option>RH</option><option>LH/RH</option>";
            } else if ($side == "RH") {
                $option .= "<option></option>";
                $option .= "<option>LH</option>";
                $option .= "<option>LH/RH</option>";
            } else if ($side == "LH/RH") {
                $option .= "<option></option><option>RH</option><option>LH</option>";
            } else if ($side == "") {
                $option .= "<option>LH</option><option>RH</option><option>LH/RH</option>";
            }
        } else {
            $option .= "<option></option><option>LH</option><option>RH</option><option>LH/RH</option>";
        }
        echo $option;
    }

    public function side4() {
        $idsupply = trim($this->input->post('idsupply', TRUE));
        $partname = $this->kanban_master_m->findBySql("SELECT DISTINCT CHR_WC_VENDOR 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO = '$idsupply' AND CHR_KANBAN_TYPE = '4'");

        if ($partname) {
            $sid = $partname[0]->pname;
            $side = $this->kanban_master_m->findBySql("SELECT CHR_SIDE 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO = '$idsupply' and CHR_WC_VENDOR = '$sid' and CHR_KANBAN_TYPE = '4'");
            if ($side) {
                echo $side[0]->pname;
            } else {
                echo '';
            }
        } else {
            echo '';
        }
    }

    public function spor() {
        $idorder = trim($this->input->post('idorder', TRUE));
        $sid = trim($this->input->post('sid', TRUE));
        $partname = $this->kanban_master_m->findBySql("SELECT CHR_SIDE 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO = '$idorder' and CHR_WC_VENDOR = '$sid' and CHR_KANBAN_TYPE = '0'");
        if ($partname) {
            echo $partname[0]->pname;
        } else {
            echo '';
        }
    }

    public function sideor() {
        $idorder = trim($this->input->post('idorder', TRUE));
        $sud = trim($this->input->post('sud', TRUE));
        $partname = $this->kanban_master_m->findBySql("SELECT CHR_SIDE 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO = '$idorder' and CHR_WC_VENDOR = '$sud' and CHR_KANBAN_TYPE = '0'");
        if ($partname) {
            echo $partname[0]->pname;
        } else {
            echo '';
        }
    }

    public function lastSerial1() {
        $idproses = trim($this->input->post('idproses', TRUE));
        $prodver1 = trim($this->input->post('prodver1', TRUE));
        if (!$prodver1) {
            echo "-";
        } else {
            $part = $this->kanban_master_m->findBySql("SELECT INT_KANBAN_NO 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO = '$idproses' and CHR_WC_VENDOR = '$prodver1' and CHR_KANBAN_TYPE = '1'");
            $partz = $part[0]->pname;
            $partname = $this->kanban_master_m->findBySql("SELECT TOP 1 INT_NUM_SERIAL 'pname' from [dbo].[TM_KANBAN_SERIAL] where INT_KANBAN_NO = '$partz' AND INT_NUM_SERIAL LIKE '1%' order by INT_NUM_SERIAL desc");
            if (!$partname) {
                $partname[0]->pname = "-";
            }
            echo $partname[0]->pname;
        }
    }

    public function fromor() {
        $idorder = trim($this->input->post('idorder', TRUE));
        $sid = trim($this->input->post('sid', TRUE));
        $option = " ";
        $partname = $this->kanban_master_m->findBySql("SELECT TM_KANBAN_SERIAL.INT_NUM_SERIAL 'pname' from [dbo].[TM_KANBAN_SERIAL] inner join [dbo].[TM_KANBAN] on TM_KANBAN_SERIAL.INT_KANBAN_NO = TM_KANBAN.INT_KANBAN_NO where TM_KANBAN.CHR_PART_NO = '$idorder' and TM_KANBAN.CHR_WC_VENDOR = '$sid' AND TM_KANBAN.CHR_KANBAN_TYPE='0' and TM_KANBAN_SERIAL.INT_NUM_SERIAL LIKE '1%' ");
        if (!empty($partname)) {
            foreach ($partname as $key => $value) {
                $option .= "<option value=\"$value->pname\">$value->pname</option>";
            }
        }

        echo $option;
    }

    public function from() {
        $idproses = trim($this->input->post('idproses', TRUE));
        $prodver1 = trim($this->input->post('prodver1', TRUE));
        $option = " ";
        $partname = $this->kanban_master_m->findBySql("SELECT DISTINCT TM_KANBAN_SERIAL.INT_NUM_SERIAL 'pname' from [dbo].[TM_KANBAN_SERIAL] inner join [dbo].[TM_KANBAN] on TM_KANBAN_SERIAL.INT_KANBAN_NO = TM_KANBAN.INT_KANBAN_NO where TM_KANBAN.CHR_PART_NO = '$idproses' and TM_KANBAN.CHR_WC_VENDOR = '$prodver1' ");

        if (!empty($partname)) {
            foreach ($partname as $key => $value) {
                $option .= "<option value=\"$value->pname\">$value->pname</option>";
            }
        }

        echo $option;
    }

    public function fromsp() {
        $idsupply = trim($this->input->post('idsupply', TRUE));
        $sid3 = trim($this->input->post('sid3', TRUE));
        $option = " ";
        $partname = $this->kanban_master_m->findBySql("SELECT TM_KANBAN_SERIAL.INT_NUM_SERIAL 'pname' from [dbo].[TM_KANBAN_SERIAL] inner join [dbo].[TM_KANBAN] on TM_KANBAN_SERIAL.INT_KANBAN_NO = TM_KANBAN.INT_KANBAN_NO where TM_KANBAN.CHR_PART_NO = '$idsupply' and TM_KANBAN.CHR_WC_VENDOR = '$sid3' AND TM_KANBAN.CHR_KANBAN_TYPE='4' and TM_KANBAN_SERIAL.INT_NUM_SERIAL LIKE '1%' ");

        if (!empty($partname)) {
            foreach ($partname as $key => $value) {
                $option .= "<option value=\"$value->pname\">$value->pname</option>";
            }
        }

        echo $option;
    }

    public function frompu() {
        $idpickup = trim($this->input->post('idpickup', TRUE));
        $prodver3 = trim($this->input->post('prodver3', TRUE));
        $option = " ";
        $partname = $this->kanban_master_m->findBySql("SELECT TM_KANBAN_SERIAL.INT_NUM_SERIAL 'pname' from [dbo].[TM_KANBAN_SERIAL] inner join [dbo].[TM_KANBAN] on TM_KANBAN_SERIAL.INT_KANBAN_NO = TM_KANBAN.INT_KANBAN_NO where TM_KANBAN.CHR_PART_NO = '$idpickup' and TM_KANBAN.CHR_WC_VENDOR = '$prodver3' AND TM_KANBAN.CHR_KANBAN_TYPE='5' AND TM_KANBAN_SERIAL.INT_NUM_SERIAL LIKE '1%' ");

        if (!empty($partname)) {
            foreach ($partname as $key => $value) {
                $option .= "<option value=\"$value->pname\">$value->pname</option>";
            }
        }

        echo $option;
    }

    public function frompup() {
        $idpickup = trim($this->input->post('idpickup', TRUE));
        $slocto = trim($this->input->post('slocto', TRUE));
        $option = " ";
        $partname = $this->kanban_master_m->findBySql("SELECT TM_KANBAN_SERIAL.INT_NUM_SERIAL 'pname' from [dbo].[TM_KANBAN_SERIAL] inner join [dbo].[TM_KANBAN] on TM_KANBAN_SERIAL.INT_KANBAN_NO = TM_KANBAN.INT_KANBAN_NO where TM_KANBAN.CHR_PART_NO = '$idpickup' and TM_KANBAN.CHR_SLOC_TO = '$slocto' and TM_KANBAN.CHR_KANBAN_TYPE='6' and TM_KANBAN_SERIAL.INT_NUM_SERIAL LIKE '1%' ");

        if (!empty($partname)) {
            foreach ($partname as $key => $value) {
                $option .= "<option value=\"$value->pname\">$value->pname</option>";
            }
        }

        echo $option;
    }

    public function toor() {
        $idorder = trim($this->input->post('idorder', TRUE));
        $sid = trim($this->input->post('sid', TRUE));
        $option = " ";
        $partname = $this->kanban_master_m->findBySql("SELECT TM_KANBAN_SERIAL.INT_NUM_SERIAL 'pname' from [dbo].[TM_KANBAN_SERIAL] inner join [dbo].[TM_KANBAN] on TM_KANBAN_SERIAL.INT_KANBAN_NO = TM_KANBAN.INT_KANBAN_NO where TM_KANBAN.CHR_PART_NO = '$idorder' and TM_KANBAN.CHR_WC_VENDOR = '$sid' and TM_KANBAN_SERIAL.INT_NUM_SERIAL LIKE '1%'  ");

        if (!empty($partname)) {
            foreach ($partname as $key => $value) {
                $option .= "<option value=\"$value->pname\">$value->pname</option>";
            }
        }

        echo $option;
    }

    public function to() {
        $idproses = trim($this->input->post('idproses', TRUE));
        $prodver1 = trim($this->input->post('prodver1', TRUE));
        $nokanban = $this->kanban_master_m->findBySql("SELECT INT_KANBAN_NO FROM [dbo].[TM_KANBAN] where CHR_PART_NO='$idproses' and CHR_WC_VENDOR='$prodver1' and CHR_KANBAN_TYPE='1' ");
        $nokanban = $nokanban[0]->INT_KANBAN_NO;
        $option = " ";
        $partname = $this->kanban_master_m->findBySql("SELECT DISTINCT INT_NUM_SERIAL 'pname' from [dbo].[TM_KANBAN_SERIAL] where INT_KANBAN_NO = '$nokanban' AND INT_NUM_SERIAL LIKE '1%' ");
        if (!empty($partname)) {
            foreach ($partname as $key => $value) {
                $option .= "<option value=\"$value->pname\">$value->pname</option>";
            }
        }

        echo $option;
    }

    public function tosp() {
        $idsupply = trim($this->input->post('idsupply', TRUE));
        $sid3 = trim($this->input->post('sid3', TRUE));
        $option = " ";
        $partname = $this->kanban_master_m->findBySql("SELECT TM_KANBAN_SERIAL.INT_NUM_SERIAL 'pname' from [dbo].[TM_KANBAN_SERIAL] inner join [dbo].[TM_KANBAN] on TM_KANBAN_SERIAL.INT_KANBAN_NO = TM_KANBAN.INT_KANBAN_NO where TM_KANBAN.CHR_PART_NO = '$idsupply' and TM_KANBAN.CHR_WC_VENDOR = '$sid3' AND TM_KANBAN.CHR_KANBAN_TYPE='4' AND TM_KANBAN_SERIAL.INT_NUM_SERIAL LIKE '1%' ");

        if (!empty($partname)) {
            foreach ($partname as $key => $value) {
                $option .= "<option value=\"$value->pname\">$value->pname</option>";
            }
        }

        echo $option;
    }

    public function topu() {
        $idpickup = trim($this->input->post('idpickup', TRUE));
        $prodver3 = trim($this->input->post('prodver3', TRUE));
        $option = " ";
        $partname = $this->kanban_master_m->findBySql("SELECT TM_KANBAN_SERIAL.INT_NUM_SERIAL 'pname' from [dbo].[TM_KANBAN_SERIAL] inner join [dbo].[TM_KANBAN] on TM_KANBAN_SERIAL.INT_KANBAN_NO = TM_KANBAN.INT_KANBAN_NO where TM_KANBAN.CHR_PART_NO = '$idpickup' and TM_KANBAN.CHR_WC_VENDOR = '$prodver3' AND TM_KANBAN.CHR_KANBAN_TYPE='5' and TM_KANBAN_SERIAL.INT_NUM_SERIAL LIKE '1%' ");

        if (!empty($partname)) {
            foreach ($partname as $key => $value) {
                $option .= "<option value=\"$value->pname\">$value->pname</option>";
            }
        }

        echo $option;
    }

    public function lastSerialu() {
        $idorder = trim($this->input->post('idorder', TRUE));
        $sud = trim($this->input->post('sud', TRUE));
        if (!$sud) {
            echo "-";
        } else {
            $part = $this->kanban_master_m->findBySql("SELECT INT_KANBAN_NO 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO = '$idorder' and CHR_WC_VENDOR = '$sud' and CHR_KANBAN_TYPE = '0'");
            $partz = $part[0]->pname;
            $partname = $this->kanban_master_m->findBySql("SELECT TOP 1 INT_NUM_SERIAL 'pname' from [dbo].[TM_KANBAN_SERIAL] where INT_KANBAN_NO = '$partz' AND INT_NUM_SERIAL LIKE '1%' order by INT_NUM_SERIAL desc");
            if (!$partname) {
                $partname[0]->pname = "-";
            }
            echo $partname[0]->pname;
        }
    }

    public function lastSerialu1() {
        $idproses = trim($this->input->post('idproses', TRUE));
        $pv1 = trim($this->input->post('pv1', TRUE));
        if (!$pv1) {
            echo "-";
        } else {
            $part = $this->kanban_master_m->findBySql("SELECT INT_KANBAN_NO 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO = '$idproses' and CHR_WC_VENDOR = '$pv1' and CHR_KANBAN_TYPE = '1'");
            $partz = $part[0]->pname;
            $partname = $this->kanban_master_m->findBySql("SELECT TOP 1 INT_NUM_SERIAL 'pname' from [dbo].[TM_KANBAN_SERIAL] where INT_KANBAN_NO = '$partz' AND INT_NUM_SERIAL LIKE '1%' order by INT_NUM_SERIAL desc");
            if (!$partname) {
                $partname[0]->pname = "-";
            }
            echo $partname[0]->pname;
        }
    }

    public function lastSerialu2() {
        $idsupply = trim($this->input->post('idsupply', TRUE));
        $sud2 = trim($this->input->post('sud2', TRUE));
        if (!$sud2) {
            echo "-";
        } else {
            $part = $this->kanban_master_m->cekSerialsp($idsupply, $sud2);
            if ($part == false) {
                echo '';
            } else {
                $partz = $part[0]->INT_KANBAN_NO;
                $partname = $this->kanban_master_m->findBySql("SELECT TOP 1 INT_NUM_SERIAL 'pname' from [dbo].[TM_KANBAN_SERIAL] where INT_KANBAN_NO = '$partz' AND INT_NUM_SERIAL LIKE '1%' order by INT_NUM_SERIAL desc");
                if (!$partname) {
                    $partname[0]->pname = "-";
                }
                echo $partname[0]->pname;
            }
        }
    }

    public function lastSerialu3() {
        $idpickup = trim($this->input->post('idpickup', TRUE));
        $pv3 = trim($this->input->post('pv3', TRUE));
        if (!$pv3) {
            echo "-";
        } else {
            $part = $this->kanban_master_m->findBySql("SELECT INT_KANBAN_NO 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO = '$idpickup' and CHR_WC_VENDOR = '$pv3' and CHR_KANBAN_TYPE = '5'");
            $partz = $part[0]->pname;
            $partname = $this->kanban_master_m->findBySql("SELECT TOP 1 INT_NUM_SERIAL 'pname' from [dbo].[TM_KANBAN_SERIAL] where INT_KANBAN_NO = '$partz' AND INT_NUM_SERIAL LIKE '1%' order by INT_NUM_SERIAL desc");
            if (!$partname) {
                $partname[0]->pname = "-";
            }
            echo $partname[0]->pname;
        }
    }

    public function lastSerial3() {
        $idpickup = trim($this->input->post('idpickup', TRUE));
        $sid = trim($this->input->post('prodver3', TRUE));
        if (!$sid) {
            echo "-";
        } else {
            $part = $this->kanban_master_m->findBySql("SELECT INT_KANBAN_NO 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO = '$idpickup' and CHR_WC_VENDOR = '$sid' and CHR_KANBAN_TYPE = '5'");
            $partz = $part[0]->pname;
            $partname = $this->kanban_master_m->findBySql("SELECT TOP 1 INT_NUM_SERIAL 'pname' from [dbo].[TM_KANBAN_SERIAL] where INT_KANBAN_NO = '$partz' AND INT_NUM_SERIAL LIKE '1%' order by INT_NUM_SERIAL desc");
//var_dump($partname);
            if (!$partname) {
                $partname[0]->pname = "-";
            }
            echo $partname[0]->pname;
        }
    }

    public function lastSerial3p() {
        $idpickup = trim($this->input->post('idpickup', TRUE));
        $slocto = trim($this->input->post('slocto', TRUE));
        $part = $this->kanban_master_m->cekSerialPass($idpickup, $slocto);
        if ($part <> false) {
            $partz = $part[0]->INT_KANBAN_NO;
            $partname = $this->kanban_master_m->findBySql("SELECT TOP 1 INT_NUM_SERIAL 'pname' from [dbo].[TM_KANBAN_SERIAL] where INT_KANBAN_NO = '$partz' AND INT_NUM_SERIAL LIKE '1%' order by INT_NUM_SERIAL desc");
            if (!$partname) {
                $partname[0]->pname = "-";
            }
            echo $partname[0]->pname;
        } else {
            echo "-";
        }
    }

    public function lastSerial2() {
        $idorder = trim($this->input->post('idorder', TRUE));
        $sid = trim($this->input->post('sid', TRUE));
        $part = $this->kanban_master_m->findBySql("SELECT INT_KANBAN_NO 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO = '$idorder' and CHR_WC_VENDOR = '$sid' and CHR_KANBAN_TYPE = '0'");
        if ($part) {
            $partz = $part[0]->pname;
            $partname = $this->kanban_master_m->findBySql("SELECT TOP 1 INT_NUM_SERIAL 'pname' from [dbo].[TM_KANBAN_SERIAL] where INT_KANBAN_NO = '$partz' AND INT_NUM_SERIAL LIKE '1%' order by INT_NUM_SERIAL desc");
            if ($partname) {
                echo $partname[0]->pname;
            } else {
                echo "-";
            }
        } else {
            echo '-';
        }
    }

    public function lastSerial4() {
        $idsupply = trim($this->input->post('idsupply', TRUE));
        $sid = trim($this->input->post('sid3', TRUE));
        if ($sid != '') {
            $part = $this->kanban_master_m->findBySql("SELECT INT_KANBAN_NO 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO = '$idsupply' and CHR_WC_VENDOR = '$sid' and CHR_KANBAN_TYPE = '4'");
            if ($part) {
                $partz = $part[0]->pname;
                $partname = $this->kanban_master_m->findBySql("SELECT TOP 1 INT_NUM_SERIAL 'pname' from [dbo].[TM_KANBAN_SERIAL] where INT_KANBAN_NO = '$partz' AND INT_NUM_SERIAL LIKE '1%' order by INT_NUM_SERIAL desc");
                if ($partname) {
                    echo $partname[0]->pname;
                } else {
                    echo "-";
                }
            } else {
                echo '';
            }
        } else {
            echo '';
        }
    }

    public function PrintDate1() {
        $idproses = $this->input->post('idproses', TRUE);
        $prodver1 = $this->input->post('prodver1', TRUE);
        $part = $this->kanban_master_m->findBySql("SELECT INT_KANBAN_NO 'pname' from TM_KANBAN where CHR_PART_NO = '$idproses' and CHR_WC_VENDOR = '$prodver1' and CHR_KANBAN_TYPE = '1'");
        $partz = $part[0]->pname;
        $partname = $this->kanban_master_m->findBySql("SELECT TOP 1 CHR_date_print 'pname' from TM_KANBAN_SERIAL where INT_KANBAN_NO = '$partz' order by INT_NUM_SERIAL desc");
        if (!$partname) {
            $partname[0]->pname = "-";
        }
        echo $partname[0]->pname;
    }

    public function getStor() {
        $partno = trim($this->input->post('idsupply', TRUE));
        $sid = trim($this->input->post('sid3', TRUE));
        $partname = $this->kanban_master_m->findBySql("SELECT DISTINCT CHR_SLOC_FROM 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO = '$partno' AND CHR_KANBAN_TYPE = '4' AND CHR_WC_VENDOR = '$sid' ");
        if ($partname) {
            echo $partname[0]->pname;
        } else {
            echo '';
        }
    }

    public function getStoru2() {
        $partno = trim($this->input->post('idsupply', TRUE));
        $sud = trim($this->input->post('sud2'));
        $option = " ";
        $selfpro = $this->kanban_master_m->findBySql("SELECT DISTINCT CHR_SLOC_FROM 'selfpro' FROM [dbo].[TM_KANBAN] WHERE CHR_PART_NO = '$partno' AND CHR_KANBAN_TYPE= '4' AND CHR_WC_VENDOR = '$sud' ");
        $selfpro = $selfpro[0]->selfpro;
        $partname = $this->kanban_master_m->findBySql("SELECT DISTINCT CHR_SLOC from [dbo].[TM_PARTS_SLOC] where CHR_PART_NO = '$partno'");

        if ($partname) {
            $option .= "<option value=\"$selfpro\">$selfpro</option>";
            foreach ($partname as $key => $value) {
                $option .= "<option>$value->CHR_SLOC</option>";
            }
        }

        echo $option;
    }

    public function getStor2() {
        $partno = trim($this->input->post('idorder'));
        $sud = trim($this->input->post('sud'));
        $option = " ";
        $selfpro = $this->kanban_master_m->findBySql("SELECT DISTINCT CHR_SLOC_FROM 'selfpro' FROM [dbo].[TM_KANBAN] WHERE CHR_PART_NO = '$partno' AND CHR_KANBAN_TYPE= '0' AND CHR_WC_VENDOR = '$sud' ");
        $selfpro = $selfpro[0]->selfpro;
        $partname = $this->kanban_master_m->findBySql("SELECT DISTINCT CHR_SLOC from [dbo].[TM_PARTS_SLOC] where CHR_PART_NO = '$partno'");
        if ($sud <> '') {
            $option .= "<option value=\"$selfpro\">$selfpro</option>";
            foreach ($partname as $key => $value) {
                $option .= "<option>$value->CHR_SLOC</option>";
            }
        }

        echo $option;
    }

    public function getStor2r() {
        $partno = trim($this->input->post('idorder'));
        $sud = trim($this->input->post('sud'));
        $selfpro = $this->kanban_master_m->findBySql("SELECT DISTINCT CHR_SLOC_TO 'selfpro' FROM [dbo].[TM_KANBAN] WHERE CHR_PART_NO ='$partno' AND CHR_KANBAN_TYPE='0' AND CHR_WC_VENDOR ='$sud' ");
        if (!empty($selfpro)) {
            $selfpro = $selfpro[0]->selfpro;
        } else {
            $selfpro = "";
        }

        echo $selfpro;
    }

    public function getStorp() {
        $partno = trim($this->input->post('idorder'));
        $sud = trim($this->input->post('sid'));
        $selfpro = $this->kanban_master_m->findBySql("SELECT DISTINCT CHR_SLOC_TO FROM [dbo].[TM_KANBAN] WHERE CHR_PART_NO = '$partno' AND CHR_KANBAN_TYPE= '0' AND CHR_WC_VENDOR = '$sud' ");
        if ($sud <> '') {
            echo $selfpro[0]->CHR_SLOC_TO;
        } else {
            echo '';
        }
    }

// end ajax print





    public function LastSerial() {
        $partno = $this->input->post('part_no');
        $option = " ";
        $partname = $this->kanban_master_m->findBySql("SELECT INT_LAST_SERIAL 'pname' from [dbo].[TM_KANBAN] ORDER BY INT_LAST_SERIAL DESC");
        echo $partname[0]->pname;
    }

    public function back_no() {
        $partno = $this->input->post('pno');
        $partname = $this->kanban_master_m->findBySql("SELECT CHR_BACK_NO 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO = '$partno'");
        echo $partname[0]->pname;
    }

    public function GetSide() {
        $partno = $this->input->post('part_no');
        $partname = $this->kanban_master_m->findBySql("SELECT CHR_SIDE 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO = '$partno'");
        echo $partname[0]->pname;
    }

    public function str3() {
        $partno = $this->input->post('part_no');
        $partname = $this->kanban_master_m->findBySql("SELECT CHR_SLOC_TO 'pname' from TM_KANBAN where CHR_PART_NO = '$partno'");
        echo $partname[0]->pname;
    }

    public function qty() {
        $partno = $this->input->post('part_no');
        $partname = $this->kanban_master_m->findBySql("SELECT INT_QTY_PER_BOX'pname' from TM_KANBAN where CHR_PART_NO = '$partno'");
        echo $partname[0]->pname;
    }

    public function qty2() {
        $partno = $this->input->post('part_no');
        $partname = $this->kanban_master_m->findBySql("SELECT INT_QTY_PER_BOX'pname' from TM_KANBAN where CHR_PART_NO = '$partno'");
        echo $partname[0]->pname;
    }

    public function cycle() {
        $partno = $this->input->post('supplier_name');
        $partname = $this->kanban_master_m->findBySql("SELECT CHR_CYCLE_BIN 'pname' from TM_VENDOR_CYCLE where CHR_SUPPLIER_ID = '$partno'");
        echo $partname[0]->pname;
    }

    public function box() {
        $partno = $this->input->post('part_no');
        $partname = $this->kanban_master_m->findBySql("SELECT CHR_BOX_TYPE'pname' from TM_KANBAN where CHR_PART_NO = '$partno'");
        echo $partname[0]->pname;
    }

    public function box2() {
        $partno = $this->input->post('part_no');
        $partname = $this->kanban_master_m->findBySql("SELECT CHR_BOX_TYPE'pname' from TM_KANBAN where CHR_PART_NO = '$partno'");
        echo $partname[0]->pname;
    }

    public function PrintDate() {
        $partname = date("Y-m-d");
        echo $partname[0]->pname;
    }

    public function showcipipin() {
// var_dump($this->layout);die();
        $this->load->view('pes/production_counter2', $data);
    }

// ajax
    public function getPartNo() {
        $backno = $this->input->post('bno');
        $partname = $this->kanban_master_m->findBySql("SELECT CHR_PART_NO 'pname' from TM_PARTS WHERE CHR_BACK_NO = '$backno' ");
        if ($partname) {
            echo $partname[0]->pname;
        } else {
            echo '';
        }
    }

    function cekBackno() {
        $part = $this->input->post('pno', true);
        $cek = $this->kanban_master_m->findBySql("SELECT CHR_BACK_NO FROM TM_PARTS WHERE CHR_PART_NO = '$part'");

        echo (!$cek);
    }

// AJAX AUTOCOMPLETE
    function search() {
        $this->load->model('pes/kanban_master_m');
        $get = $this->input->get('term');
        $x = "X";
        if ($get) {
            $result = $this->db->query("SELECT DISTINCT TOP 10 CHR_PART_NO FROM TM_PARTS WHERE (CHR_FLAG_DELETE IS NULL OR CHR_FLAG_DELETE='') AND CHR_PART_NO LIKE '$get%'")->result();
            if (count($result) > 0) {
                foreach ($result as $res) {
                    $arr_result[] = $res->CHR_PART_NO;
                }
                echo json_encode($arr_result);
            }
        }
    }

    function searchpartno() {
        $this->load->model('pes/kanban_master_m');
        $get = $this->input->get('term');

        if ($get) {
            $result = $this->db->query("SELECT DISTINCT TOP 10 CHR_PART_NO FROM TM_PROCESS_PARTS WHERE (CHR_FLAG_DELETE IS NULL OR CHR_FLAG_DELETE='') AND CHR_PART_NO LIKE '$get%'")->result();
            if (count($result) > 0) {
                foreach ($result as $res) {
                    $arr_result[] = $res->CHR_PART_NO;
                }
                echo json_encode($arr_result);
            }
        }
    }

    function searchOldOr() {
        $this->load->model('pes/kanban_master_m');
        $get = $this->input->get('term');

        if ($get) {
            $result = $this->db->query("SELECT DISTINCT TOP 10 CHR_PART_NO FROM TM_KANBAN WHERE (CHR_FLAG_DELETE IS NULL OR CHR_FLAG_DELETE='') AND CHR_KANBAN_TYPE='0' AND CHR_PART_NO LIKE '$get%'")->result();
            if (count($result) > 0) {
                foreach ($result as $res) {
                    $arr_result[] = $res->CHR_PART_NO;
                }
                echo json_encode($arr_result);
            }
        }
    }

    function searchOldPr() {
        $this->load->model('pes/kanban_master_m');
        $get = $this->input->get('term');

        if ($get) {
            $result = $this->db->query("SELECT DISTINCT TOP 10 CHR_PART_NO FROM TM_KANBAN WHERE (CHR_FLAG_DELETE IS NULL OR CHR_FLAG_DELETE='') AND CHR_KANBAN_TYPE='1' AND CHR_PART_NO LIKE '$get%'")->result();
            if (count($result) > 0) {
                foreach ($result as $res) {
                    $arr_result[] = $res->CHR_PART_NO;
                }
                echo json_encode($arr_result);
            }
        }
    }

    function searchOldSp() {
        $this->load->model('pes/kanban_master_m');
        $get = $this->input->get('term');

        if ($get) {
            $result = $this->db->query("SELECT DISTINCT TOP 10 CHR_PART_NO FROM TM_KANBAN WHERE (CHR_FLAG_DELETE IS NULL OR CHR_FLAG_DELETE='') AND CHR_KANBAN_TYPE='4' AND CHR_PART_NO LIKE '$get%'")->result();
            if (count($result) > 0) {
                foreach ($result as $res) {
                    $arr_result[] = $res->CHR_PART_NO;
                }
                echo json_encode($arr_result);
            }
        }
    }

    function searchOldPu() {
        $this->load->model('pes/kanban_master_m');
        $get = $this->input->get('term');

        if ($get) {
            $result = $this->db->query("SELECT DISTINCT TOP 10 CHR_PART_NO FROM TM_KANBAN WHERE (CHR_FLAG_DELETE IS NULL OR CHR_FLAG_DELETE='') AND CHR_KANBAN_TYPE='5' AND CHR_PART_NO LIKE '$get%'")->result();
            if (count($result) > 0) {
                foreach ($result as $res) {
                    $arr_result[] = $res->CHR_PART_NO;
                }
                echo json_encode($arr_result);
            }
        }
    }

    function test() {
        $this->load->model('pes/kanban_master_m');
        $get = $this->input->get('term');

        if ($get) {
            $result = $this->db->query("SELECT DISTINCT TOP 10 CHR_CUS_PART_NO FROM TM_SHIPPING_PARTS WHERE CHR_CUS_PART_NO LIKE '$get%'")->result();
            if (count($result) > 0) {
                foreach ($result as $res) {
                    $arr_result[] = $res->CHR_CUS_PART_NO;
                }
                echo json_encode($arr_result);
            }
        }
    }

    function searchOldPup() {
        $this->load->model('pes/kanban_master_m');
        $get = $this->input->get('term');

        if ($get) {
            $result = $this->db->query("SELECT DISTINCT TOP 10 CHR_PART_NO FROM TM_KANBAN WHERE (CHR_FLAG_DELETE IS NULL OR CHR_FLAG_DELETE='') AND CHR_KANBAN_TYPE='6' AND CHR_PART_NO LIKE '$get%'")->result();
            if (count($result) > 0) {
                foreach ($result as $res) {
                    $arr_result[] = $res->CHR_PART_NO;
                }
                echo json_encode($arr_result);
            }
        }
    }

// END AJAX AUTOCOMPLETE
// AJAX VALIDASI SERIAL PRINT CUSTOM
    function cekSerialCustom() {
        $part = trim($this->input->post('idorder', true));
        $sid = trim($this->input->post('sid', true));
        $custom = trim($this->input->post('custom', true));
        $nokanban = $this->kanban_master_m->findBySql("SELECT INT_KANBAN_NO FROM [dbo].[TM_KANBAN] WHERE CHR_PART_NO='$part' AND CHR_WC_VENDOR='$sid' AND CHR_KANBAN_TYPE='0' ");
        $nokanban = $nokanban[0]->INT_KANBAN_NO;

        if ($custom == '') {
            $status = true;
        } else {
            $karakter = strlen($custom);
            if ($karakter == 5) {
                $cek = $this->kanban_master_m->cekSerialCustomOr($custom, $nokanban);
                if ($cek == false) {
                    $status = '2';
                } else {
                    $status = true;
                }
            } elseif ($karakter < 5) {
                $status = '3';
            } elseif ($karakter > 5) {
                $custom = explode(',', $custom);
                $range = count($custom);
                for ($i = 0; $i < $range; $i++) {
                    $serial = $custom[$i];
                    $karserial = strlen($serial);
                    if ($karserial <> 5) {
                        $status = '4';
                    } else {
                        $cek = $this->kanban_master_m->cekSerialCustomOr($serial, $nokanban);
                        if ($cek == false) {
                            $status = '5';
                        } else {
                            $status = true;
                        }
                    }
                }
            }
        }
        echo $status;
    }

    function cekSerialCustompr() {
        $part = trim($this->input->post('idproses', true));
        $sid = trim($this->input->post('prodver1', true));
        $custom = trim($this->input->post('custom', true));
        $nokanban = $this->kanban_master_m->findBySql("SELECT INT_KANBAN_NO FROM [dbo].[TM_KANBAN] WHERE CHR_PART_NO='$part' AND CHR_WC_VENDOR='$sid' AND CHR_KANBAN_TYPE='1' ");
        $nokanban = $nokanban[0]->INT_KANBAN_NO;

        if ($custom == '') {
            $status = true;
        } else {
            $karakter = strlen($custom);
            if ($karakter == 5) {
                $cek = $this->kanban_master_m->cekSerialCustomOr($custom, $nokanban);
                if ($cek == false) {
                    $status = '2';
                } else {
                    $status = true;
                }
            } elseif ($karakter < 5) {
                $status = '3';
            } elseif ($karakter > 5) {
                $custom = explode(',', $custom);
                $range = count($custom);
                for ($i = 0; $i < $range; $i++) {
                    $serial = $custom[$i];
                    $karserial = strlen($serial);
                    if ($karserial <> 5) {
                        $status = '4';
                    } else {
                        $cek = $this->kanban_master_m->cekSerialCustomOr($serial, $nokanban);
                        if ($cek == false) {
                            $status = '5';
                        } else {
                            $status = true;
                        }
                    }
                }
            }
        }
        echo $status;
    }

    function cekSerialCustomsp() {
        $part = trim($this->input->post('idsupply', true));
        $sid = trim($this->input->post('sid3', true));
        $custom = trim($this->input->post('custom', true));
        $nokanban = $this->kanban_master_m->findBySql("SELECT INT_KANBAN_NO FROM [dbo].[TM_KANBAN] WHERE CHR_PART_NO='$part' AND CHR_WC_VENDOR='$sid' AND CHR_KANBAN_TYPE='4' ");
        $nokanban = $nokanban[0]->INT_KANBAN_NO;

        if ($custom == '') {
            $status = true;
        } else {
            $karakter = strlen($custom);
            if ($karakter == 5) {
                $cek = $this->kanban_master_m->cekSerialCustomOr($custom, $nokanban);
                if ($cek == false) {
                    $status = '2';
                } else {
                    $status = true;
                }
            } elseif ($karakter < 5) {
                $status = '3';
            } elseif ($karakter > 5) {
                $custom = explode(',', $custom);
                $range = count($custom);
                for ($i = 0; $i < $range; $i++) {
                    $serial = $custom[$i];
                    $karserial = strlen($serial);
                    if ($karserial <> 5) {
                        $status = '4';
                    } else {
                        $cek = $this->kanban_master_m->cekSerialCustomOr($serial, $nokanban);
                        if ($cek == false) {
                            $status = '5';
                        } else {
                            $status = true;
                        }
                    }
                }
            }
        }
        echo $status;
    }

    function cekSerialCustompu() {
        $part = trim($this->input->post('idpickup', true));
        $sid = trim($this->input->post('prodver3', true));
        $custom = trim($this->input->post('custom', true));
        $nokanban = $this->kanban_master_m->findBySql("SELECT INT_KANBAN_NO FROM [dbo].[TM_KANBAN] WHERE CHR_PART_NO='$part' AND CHR_WC_VENDOR='$sid' AND CHR_KANBAN_TYPE='5' ");
        $nokanban = $nokanban[0]->INT_KANBAN_NO;

        if ($custom == '') {
            $status = true;
        } else {
            $karakter = strlen($custom);
            if ($karakter == 5) {
                $cek = $this->kanban_master_m->cekSerialCustomOr($custom, $nokanban);
                if ($cek == false) {
                    $status = '2';
                } else {
                    $status = true;
                }
            } elseif ($karakter < 5) {
                $status = '3';
            } elseif ($karakter > 5) {
                $custom = explode(',', $custom);
                $range = count($custom);
                for ($i = 0; $i < $range; $i++) {
                    $serial = $custom[$i];
                    $karserial = strlen($serial);
                    if ($karserial <> 5) {
                        $status = '4';
                    } else {
                        $cek = $this->kanban_master_m->cekSerialCustomOr($serial, $nokanban);
                        if ($cek == false) {
                            $status = '5';
                        } else {
                            $status = true;
                        }
                    }
                }
            }
        }
        echo $status;
    }

    function cekSerialCustompup() {
        $part = trim($this->input->post('idpickup', true));
        $slocfrom = trim($this->input->post('slocfrom', true));
        $custom = trim($this->input->post('custom', true));
        $nokanban = $this->kanban_master_m->ceknokanban($part, $slocfrom);
        if ($nokanban == false) {
            $status = '15';
        } else {
            $nokanban = $nokanban[0]->INT_KANBAN_NO;
            if ($custom == '') {
                $status = true;
            } else {
                $karakter = strlen($custom);
                if ($karakter == 5) {
                    $cek = $this->kanban_master_m->cekSerialCustomOr($custom, $nokanban);
                    if ($cek == false) {
                        $status = '2';
                    } else {
                        $status = true;
                    }
                } elseif ($karakter < 5) {
                    $status = '3';
                } elseif ($karakter > 5) {
                    $custom = explode(',', $custom);
                    $range = count($custom);
                    for ($i = 0; $i < $range; $i++) {
                        $serial = $custom[$i];
                        $karserial = strlen($serial);
                        if ($karserial <> 5) {
                            $status = '4';
                        } else {
                            $cek = $this->kanban_master_m->cekSerialCustomOr($serial, $nokanban);
                            if ($cek == false) {
                                $status = '5';
                            } else {
                                $status = true;
                            }
                        }
                    }
                }
            }
        }
        echo $status;
    }

    public function download() { //fungsi download
        $name = 'kanban_so.xls';
        $data = file_get_contents("assets/$name"); // filenya
        ob_clean();
        force_download($name, $data);
    }

// END AJAX VALIDASI SERIAL PRINT CUSTOM
}

?>
