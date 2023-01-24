<?php

class export_c extends CI_Controller
{

    private $layout = '/template/head';

    public function __construct()
    {
        parent::__construct();

        $this->load->model('delivery/picking_list_m');
        $this->load->model('organization/dept_m');
        $this->load->model('portal/notification_m');
        $this->load->helper(array('form', 'url', 'inflector'));
    }

    public function index($w_center = '', $part_no = '', $back_no = '', $status_del = '')
    {

        //$this->_redirect_if_not_logged_in();
        $this->role_module_m->authorization('16');

        if ($part_no != '' && $back_no != '' && $status_del != '')
            $this->_process_del($w_center, $part_no, $back_no, $status_del);


        //$wcenters	= $this->prod_entry_m->find('DISTINCT(CHR_WCENTER_MN)','','CHR_WCENTER_MN');
        $wcenters = $this->prod_entry_m->find('DISTINCT(CHR_WCENTER_MN)', '', 'CHR_WCENTER_MN');

        if ($w_center == 'ALL') {
            $parts = $this->prod_entry_m->findBySql("SELECT    *
                                                                    FROM         TM_PES_PART");
        } else {
            $parts = $this->prod_entry_m->findBySql(" SELECT    *
                                                                    FROM         TM_PES_PART
                                                                    WHERE     (CHR_WCENTER = '" . $w_center . "')");
        }


        $data['wcenter_l'] = $this->uri->segment(4);
        $data['parts'] = $parts;
        $data['wcenters'] = $wcenters;
        $data['content'] = 'admin/edit';

        $this->session->userdata('user_id');

        $data['content'] = 'pes/maintain_part_v';
        $data['title'] = 'Production Entry';

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(16);
        $data['news'] = $this->news_m->get_news();

        $this->load->view($this->layout, $data);
    }

    public function upload($w_center = '', $part_no = '', $back_no = '')
    {
        $this->load->library(array('PHPExcel', 'PHPExcel/IOFactory'));

        $this->role_module_m->authorization('30');        
        $date_now = date("ymd");
        $this->db->query("truncate table TW_PACKING_UPLOAD");
        $cust_data = $this->db->query("SELECT * FROM   TM_SHIPTO_CUST_EXPORT   order by  CHR_CUST_DESC asc")->result();

        if ($this->input->post("btn-upload") != '') {
            $this->db->query("truncate table TW_PACKING_UPLOAD");
            $delivery_date = $this->input->post('delivery_date');
            $delivery_date = date("Ymd", strtotime($delivery_date));
            $kode_customer = $this->input->post('kode_cust');
            $upload_packing = $this->input->post('upload_packing');
            $area = trim($this->input->post('area'));

            //create id packing 
            $id_packing = $this->db->query("SELECT * FROM  TM_SEQUENCE WHERE CHR_DATE = '$date_now' and CHR_FUNCTION = 'upload_packing'")->row();
            if (count($id_packing) > 0) {
                $renban = $id_packing->INT_RENBAN + 1;
                $this->db->query("update TM_SEQUENCE set INT_RENBAN = INT_RENBAN + 1 WHERE CHR_DATE = '$date_now'");
            } else {
                $renban = 1;
                $this->db->query("INSERT INTO TM_SEQUENCE (CHR_DATE, CHR_FUNCTION, INT_RENBAN) VALUES ('$date_now', 'upload_packing', 1);");
            }

            //what the problem with this length id packing??
            // if (strlen($renban) == 1) {
            //     $renban = "00" . $renban;
            // } else if (strlen($renban) == 2) {
            //     $renban = "00" . $renban;
            // }

            //New logic update by ANU - 20220906
            if (strlen($renban) == 1) {
                $renban = "00" . $renban;
            } else if (strlen($renban) == 2) {
                $renban = "0" . $renban;
            } else if (strlen($renban) == 3) {
                $renban = $renban;
            }

            $id_packing = "PACK" . $date_now . $renban;

            //            echo "$delivery_date || $kode_customer || $upload_packing";
            //            exit();

            if (!empty($delivery_date) and !empty($kode_customer)) {

                $fileName = $_FILES['upload_packing']['name'];
                if (empty($fileName)) {
                    echo '<script>alert("Anda Belum Memilih File Untuk diupload");</script>';
                    redirect('delivery/export_c/upload', 'refresh');
                }

                //file untuk submit file excel
                $config['upload_path'] = './assets/files/';
                $config['file_name'] = $fileName;
                $config['allowed_types'] = 'xls|xlsx';
                $config['max_size'] = 10000;

                //code for upload with ci
                $this->load->library('upload');
                $this->upload->initialize($config);
                if ($a = $this->upload->do_upload('upload_packing'))
                    $this->upload->display_errors();
                $media = $this->upload->data('upload_packing');
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
                $rowHeader = $sheet->rangeToArray('A2:' . $highestColumn . '2', NULL, TRUE, FALSE);
                $this->db->query("truncate table TW_PACKING_UPLOAD");
                for ($row = 2; $row <= $highestRow; $row++) {
                    $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);
                    $part_no = $rowData[0][0];
                    $part_no = trim($part_no);
                    $qty = $rowData[0][1];
                    $no_pallet = $rowData[0][2];
                    $no_po = $rowData[0][3];

                    //Additional info
                    if (isset($rowData[0][4])) {
                        $addtional_info = $rowData[0][4];
                    } else {
                        $addtional_info = "";
                    }
                    if (isset($rowData[0][5])) {
                        $addtional_info1 = $rowData[0][5];
                    } else {
                        $addtional_info1 = "";
                    }

                    //Shipmark
                    if (isset($rowData[0][6])) {
                        $shipmark = $rowData[0][6];
                    } else {
                        $shipmark = "";
                    }

                    //Cust name alias
                    if (isset($rowData[0][7])) {
                        $alias = $rowData[0][7];
                    } else {
                        $alias = "";
                    }

                    //Country
                    if (isset($rowData[0][8])) {
                        $country = $rowData[0][8];
                    } else {
                        $country = "";
                    }

                    //Check PO
                    //sementara cek ke TM_SHIPPING_PART
                    $msg = "";
                    $cek_part_no = $this->db->query("SELECT CHR_CUS_PART_NO FROM TM_SHIPPING_PARTS WHERE CHR_PART_NO = '$part_no'")->row();
                    if (count($cek_part_no) > 0) {
                        $part_no_cust = $cek_part_no->CHR_CUS_PART_NO;
                        $stat = "1";
                        $msg .= "OK";
                    } else {
                        $part_no_cust = "";
                        $stat = "0";
                        $msg .= "Part No Tidak Terdaftar";
                    }

                    //Check Kanban
                    $check_kanban = $this->db->query("SELECT * FROM  TM_KANBAN WHERE CHR_PART_NO = '$part_no' and CHR_KANBAN_TYPE = '5'")->row();

                    if (count($check_kanban) > 0) {
                        $sloc_from = $check_kanban->CHR_SLOC_TO;
                        $back_no = $check_kanban->CHR_BACK_NO;
                        $stat = "1";
                        $msg .= " || OK";
                        $qty_per_box = $check_kanban->INT_QTY_PER_BOX;
                    } else {
                        $back_no = "";
                        $sloc_from = "";
                        $stat = "0";
                        $msg .= " || Tidak ada Master Kanban Packing";
                        $qty_per_box = 0;
                    }

                    //insert
                    $this->db->query("INSERT INTO TW_PACKING_UPLOAD (CHR_IDPACKING, CHR_PART_NO, INT_QTY, INT_NOPALLET, CHR_NOPO_CUST, CHR_NOPO_SAP, CHR_STAT, CHR_MSG , CHR_CUST_CODE , CHR_DATE_DELIVERY , CHR_SLOC_FROM , CHR_BACK_NO, CHR_PARTNO_CUST , INT_QTY_PER_BOX , CHR_ADD_INFO , CHR_ADD_INFO1, CHR_SHIPMARK, CHR_CUST_NAME_ALIAS, CHR_COUNTRY, CHR_AREA) "
                        . "VALUES ('$id_packing', '$part_no', '$qty', '$no_pallet', '$no_po', '$no_po', '$stat', '$msg' , '$kode_customer' , '$delivery_date' , '$sloc_from' , '$back_no', '$part_no_cust', '$qty_per_box' , '$addtional_info' , '$addtional_info1', '$shipmark', '$alias', '$country', '$area');");
                }


                redirect("delivery/export_c/confirmation_upload", "refresh");
            } else {
            }
        }


        if ($this->input->post('btn_save') != '')
            $this->_process_edit($part_no, $back_no, $w_center);

        $this->session->userdata('user_id');

        $data['cust_data'] = $cust_data;
        $data['content'] = 'delivery/upload_packing_list_v';
        $data['title'] = 'Upload Packing Export';
        $data['role'] = $this->session->userdata('NPK');

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(136);
        $data['news'] = $this->news_m->get_news();

        $this->load->view($this->layout, $data);
    }

    //--------------------------------------------------------------------//
    // Confrimation Upload
    //
    //--------------------------------------------------------------------//
    //
    //--------------------------------------------------------------------//
    public function confirmation_upload()
    { //fungsi download
        $this->role_module_m->authorization('30');
        $date_now = date("Ymd");
        $time_now = date("His");
        $this->session->userdata('user_id');

        $data['content'] = 'delivery/confirm_packing_list_v';
        $data['title'] = 'Confirm Packing List';

        $packing_list = $this->db->query("SELECT * FROM   TW_PACKING_UPLOAD")->result();
        if (count($packing_list) == 0) {
            redirect("delivery/export_c/upload", "refresh");
        }
        $kode_cust = $packing_list[0]->CHR_CUST_CODE;
        $delivery_date = $packing_list[0]->CHR_DATE_DELIVERY;
        $packing_id = $packing_list[0]->CHR_IDPACKING;

        if ($kode_cust != NULL && $kode_cust != '') {
            //get Customer
            $get_cust = $this->db->query("SELECT * FROM  TM_CUST WHERE CHR_CUST_NO = '$kode_cust'")->row();
            $cust_name = $get_cust->CHR_CUST_NAME;
        } else {
            $cust_name = '';
        }

        //cek upload ok
        $cek_upload_total = $this->db->query("SELECT * FROM  TW_PACKING_UPLOAD")->num_rows();
        $cek_upload_ok = $this->db->query("SELECT * FROM  TW_PACKING_UPLOAD WHERE CHR_STAT = '1'")->num_rows();


        if ($this->input->post("btn-confirm") != '') {
            $range = 0;
            foreach ($packing_list as $value_packing) {
                $id_pallete = trim($value_packing->CHR_IDPACKING) . "-" . $value_packing->INT_NOPALLET;
                $part_no = $value_packing->CHR_PART_NO;
                $qty = $value_packing->INT_QTY;
                $nopallet = $value_packing->INT_NOPALLET;
                $nopocust = trim($value_packing->CHR_NOPO_CUST);
                $noposap = trim($value_packing->CHR_NOPO_SAP);
                $cust_code = $value_packing->CHR_CUST_CODE;
                $delivery_date = $value_packing->CHR_DATE_DELIVERY;
                $back_no = $value_packing->CHR_BACK_NO;
                $sloc_from = $value_packing->CHR_SLOC_FROM;
                $part_no_cust = $value_packing->CHR_PARTNO_CUST;
                $qty_per_box = $value_packing->INT_QTY_PER_BOX;
                $addtional_info = $value_packing->CHR_ADD_INFO;
                $addtional_info1 = $value_packing->CHR_ADD_INFO1;
                $shipmark = $value_packing->CHR_SHIPMARK;
                $alias = $value_packing->CHR_CUST_NAME_ALIAS;
                $country = $value_packing->CHR_COUNTRY;
                $area = $value_packing->CHR_AREA;
                $this->db->query("INSERT INTO TT_PACKING_UPLOAD (CHR_IDPALLET, CHR_IDPACKING, CHR_PART_NO, INT_QTY, INT_NOPALLET, CHR_NOPO_CUST, CHR_NOPO_SAP, CHR_STAT, CHR_MSG , CHR_CUST_CODE , CHR_DATE_DELIVERY ,CHR_DATE_INSERT , CHR_TIME_INSERT ,CHR_BACK_NO , CHR_SLOC_FROM , CHR_PARTNO_CUST , INT_QTY_PER_BOX , CHR_ADD_INFO , CHR_ADD_INFO1, CHR_SHIPMARK, CHR_CUST_NAME_ALIAS, CHR_COUNTRY, CHR_AREA) "
                    . "VALUES ('$id_pallete', '$value_packing->CHR_IDPACKING' ,'$part_no', $qty, $nopallet, '$nopocust', '$noposap', '0', '' , '$cust_code' , '$delivery_date' , '$date_now' , '$time_now' , '$back_no' , '$sloc_from' , '$part_no_cust' , $qty_per_box , '$addtional_info' , '$addtional_info1', '$shipmark', '$alias', '$country', '$area');");

                //===== QR for Case Mark
                $this->load->library('ciqrcode');
                $params['data'] = "CM $id_pallete $nopocust $date_now $time_now";
                $params['level'] = 'B';
                $params['size'] = 2;
                $params['savename'] = 'assets/file/qrcode_pack/CM_' . $id_pallete . '_' . $date_now . '_' . $time_now . '.png';
                $this->ciqrcode->generate($params);

                //===== QR for Content List
                $this->load->library('ciqrcode');
                $params['data'] = "CL $id_pallete $nopocust $date_now $time_now";
                $params['level'] = 'B';
                $params['size'] = 2;
                $params['savename'] = 'assets/file/qrcode_pack/CL_' . $id_pallete . '_' . $date_now . '_' . $time_now . '.png';
                $this->ciqrcode->generate($params);

                $range++;
            }

            $this->db->query("truncate table TW_PACKING_UPLOAD");



            redirect("delivery/export_c/print_barcode/$value_packing->CHR_IDPACKING", "refresh");
            $this->load->view('delivery/print_kanban_packing', $data);
        }


        $data['packing_id'] = $packing_id;
        $data['delivery_date'] = $delivery_date;
        $data['packing_list'] = $packing_list;
        $data['cek_upload_total'] = $cek_upload_total;
        $data['cek_upload_ok'] = $cek_upload_ok;

        $data['cust_kode'] = $kode_cust;
        $data['cust_name'] = $cust_name;
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(136);
        $data['news'] = $this->news_m->get_news();

        $this->load->view($this->layout, $data);
    }

    public function print_kanban($id_packing)
    {
        // $data['content'] = 'delivery/confirm_packing_list_v';
        $data['title'] = 'Confirm Packing List';

        $packing_list = $this->db->query("SELECT * FROM TT_PACKING_UPLOAD WHERE CHR_IDPACKING = '$id_packing'")->result();
        $kode_cust = $packing_list[0]->CHR_CUST_CODE;
        $delivery_date = $packing_list[0]->CHR_DATE_DELIVERY;
        $po = $packing_list[0]->CHR_NOPO_CUST;
        $packing_id = $packing_list[0]->CHR_IDPACKING;
        $qty_per_box = $packing_list[0]->INT_QTY_PER_BOX;
        $cust_name = $packing_list[0]->CHR_CUST_NAME_ALIAS;
        $country = $packing_list[0]->CHR_COUNTRY;

        if ($packing_list[0]->CHR_CUST_NAME_ALIAS == NULL || $packing_list[0]->CHR_CUST_NAME_ALIAS == '') {
            $get_cust = $this->db->query("SELECT * FROM  TM_SHIPTO_CUST_EXPORT WHERE CHR_KODE_CUST = '$kode_cust'")->row();
            $cust_name = $get_cust->CHR_CUST_DESC;
            $country = $get_cust->CHR_COUNTRY_CODE;
        }

        $data['range'] = $this->db->query("SELECT MAX(INT_NOPALLET) as tot FROM TT_PACKING_UPLOAD WHERE CHR_IDPACKING = '$id_packing'")->row()->tot;

        //cek upload ok
        $cek_upload_total = $this->db->query("SELECT * FROM  TT_PACKING_UPLOAD WHERE CHR_IDPACKING = '$id_packing'")->num_rows();
        $cek_upload_ok = $this->db->query("SELECT * FROM  TT_PACKING_UPLOAD WHERE CHR_STAT = '1' and CHR_IDPACKING = '$id_packing'")->num_rows();

        $data['po'] = $po;
        $data['delivery_date'] = $delivery_date;
        $data['country'] = $country;
        $data['cust_name'] = $cust_name;
        $data['id_packing'] = $id_packing;
        $data['packing_list'] = $packing_list;

        $this->load->view('delivery/print_packing_barcode', $data);
    }

    public function print_barcode($id_packing)
    {

        $packing_list = $this->db->query("SELECT * FROM TT_PACKING_UPLOAD WHERE CHR_IDPACKING = '$id_packing'")->result();
        $kode_cust = $packing_list[0]->CHR_CUST_CODE;
        $delivery_date = $packing_list[0]->CHR_DATE_DELIVERY;
        $po = $packing_list[0]->CHR_NOPO_CUST;
        $cust_name = $packing_list[0]->CHR_CUST_NAME_ALIAS;
        $country = $packing_list[0]->CHR_COUNTRY;

        if ($packing_list[0]->CHR_CUST_NAME_ALIAS == NULL || $packing_list[0]->CHR_CUST_NAME_ALIAS == '') {
            $get_cust = $this->db->query("SELECT * FROM  TM_SHIPTO_CUST_EXPORT WHERE CHR_KODE_CUST = '$kode_cust'")->row();
            $cust_name = $get_cust->CHR_CUST_DESC;
            $country = $get_cust->CHR_COUNTRY_CODE;
        }

        $data['range'] = $this->db->query("SELECT MAX(INT_NOPALLET) AS tot FROM TT_PACKING_UPLOAD WHERE CHR_IDPACKING = '$id_packing'")->row()->tot;
        $data['po'] = $po;
        $data['delivery_date'] = $delivery_date;

        if(strlen($country) < 20){
            $text_country = 16;
        }else{
            $text_country = 12;
        }

        if(strlen($cust_name) < 10){
            $text_size = 25;
        }else if(strlen($cust_name) >= 10 && strlen($cust_name) <= 20){
            $text_size = 16;
        }else if(strlen($cust_name) > 20){
            $array_cust = explode(" ",$cust_name);
            $new_cust = '';
            for($x = 0; $x < count($array_cust); $x++){
                if($x == 3){
                    $new_cust = $new_cust. '<br>' .$array_cust[$x];
                }else{
                    $new_cust = $new_cust. ' ' .$array_cust[$x];
                }
            }
            $cust_name = $new_cust;
            $text_size = 13;
        }

        $data['country'] = $country;
        $data['text_country'] = $text_country;
        $data['cust_name'] = $cust_name;
        $data['text_size'] = $text_size;
        $data['id_packing'] = $id_packing;
        $data['packing_list'] = $packing_list;

        $this->load->view('delivery/print_kanban_packing', $data);
    }

    public function testprintFpdfKanban($id_packing)
    {

        $this->load->library('KanbanPackingFPDF');
        $pdf = $this->kanbanpackingfpdf->getInstance();
        $pdf->SetMargins(5, 5, 5);
        $pdf->AliasNbPages();
        $pdf->AddPage();
        $pdf->SetFont('Arial', '', 8);

        $packing_list = $this->db->query("SELECT * FROM TT_PACKING_UPLOAD WHERE CHR_IDPACKING = '$id_packing'")->result();
        $range = $this->db->query("SELECT MAX(INT_NOPALLET) AS tot FROM TT_PACKING_UPLOAD WHERE CHR_IDPACKING = '$id_packing'")->row()->tot;
        $kode_cust = $packing_list[0]->CHR_CUST_CODE;
        $delivery_date = $packing_list[0]->CHR_DATE_DELIVERY;
        $po = $packing_list[0]->CHR_NOPO_CUST;
        $cust_name = $packing_list[0]->CHR_CUST_NAME_ALIAS;
        $country = $packing_list[0]->CHR_COUNTRY;

        if ($packing_list[0]->CHR_CUST_NAME_ALIAS == NULL || $packing_list[0]->CHR_CUST_NAME_ALIAS == '') {
            $get_cust = $this->db->query("SELECT * FROM  TM_SHIPTO_CUST_EXPORT WHERE CHR_KODE_CUST = '$kode_cust'")->row();
            $cust_name = $get_cust->CHR_CUST_DESC;
            $country = $get_cust->CHR_COUNTRY_CODE;
        }

        $data['range'] = $range;
        $data['po'] = $po;
        $data['delivery_date'] = $delivery_date;
        $data['country'] = $country;
        $data['cust_name'] = $cust_name;
        $data['id_packing'] = $id_packing;
        $data['packing_list'] = $packing_list;

        $pdf->Cell(155, 4, $po, 1, 0, 'L');

        // $pdf->AutoPrint(true);
        $pdf->Output(trim($id_packing) . ".pdf", 'I');

    }

    // download
    public function download()
    { //fungsi download
        $this->load->helper('download');

        ob_clean();
        // $name = 'packing_list.xlsx'; // Old template
        $name = 'packing_list_new.xlsx'; // New template
        $data = file_get_contents("assets/template/delivery/export/$name"); // filenya

        force_download($name, $data);
    }

    public function edit($w_center = '', $part_no = '', $back_no = '')
    {
        $this->role_module_m->authorization('16');

        $where = "CHR_PART_NO='" . $part_no . "' AND CHR_BACK_NO='" . $back_no . "' AND CHR_WCENTER='" . $w_center . "' ";
        $parts = $this->prod_entry_m->find('*', $where);
        $data['parts'] = $parts;
        //$this->data['content'] = 'admin/edit_form';
        if ($this->input->post('btn_save') != '')
            $this->_process_edit($part_no, $back_no, $w_center);
        //$this->load->view('template/layout',$this->data);

        $this->session->userdata('user_id');

        $data['content'] = 'pes/edit_part_v';
        $data['title'] = 'Edit Part';

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(16);
        $data['news'] = $this->news_m->get_news();

        $this->load->view($this->layout, $data);
    }

    public function add($w_center = '')
    {
        $this->role_module_m->authorization('16');

        $data['wcenter'] = $w_center;
        //$this->data['content'] = 'admin/add_form';
        if ($this->input->post('btn_save') != '')
            $this->_process_add();

        $this->session->userdata('user_id');

        $data['content'] = 'pes/add_part_v';
        $data['title'] = 'Add Part';

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(16);
        $data['news'] = $this->news_m->get_news();

        $this->load->view($this->layout, $data);
    }

    private function _process_add()
    {

        $parts = $this->prod_entry_m->find('INT_NO', '', 'INT_NO DESC', '1');

        $part_no = $this->input->post('part_no');
        $part_no_hyp = $this->input->post('part_no_hyp');
        $back_no = $this->input->post('back_no');
        $wcenter = $this->input->post('wcenter');
        $wcenter_mn = $this->input->post('wcenter_mn');
        $part_name = $this->input->post('part_name');
        $type = $this->input->post('type');
        $sloc = $this->input->post('sloc');
        $prod = $this->input->post('prod');
        $flg_delete = $this->input->post('flg_delete');


        $data_insert = array(
            'INT_NO' => ($parts[0]->INT_NO) + 1,
            'CHR_PART_NO' => $part_no,
            'CHR_BACK_NO' => $back_no,
            'CHR_WCENTER' => $wcenter,
            'CHR_PART_NAME' => $part_name,
            'CHR_WCENTER_MN' => $wcenter_mn,
            'CHR_TYPE' => $type,
            'CHR_SLOC' => $sloc,
            'CHR_PART_NO_HYP' => $part_no_hyp,
            'CHR_PROD' => $prod,
            'CHR_FLG_DELETE' => $flg_delete,
        );

        $this->prod_entry_m->add($data_insert);

        redirect('pes/admin_c/index/' . $this->uri->segment(4));
    }

    private function _process_edit($part_no, $back_no, $w_center)
    {

        $where = "CHR_PART_NO='" . $part_no . "' AND CHR_BACK_NO='" . $back_no . "' AND CHR_WCENTER='" . $w_center . "' ";

        $part_no = $this->input->post('part_no');
        $part_no_hyp = $this->input->post('part_no_hyp');
        $back_no = $this->input->post('back_no');
        $wcenter = $this->input->post('wcenter');
        $wcenter_mn = $this->input->post('wcenter_mn');
        $part_name = $this->input->post('part_name');
        $type = $this->input->post('type');
        $sloc = $this->input->post('sloc');
        $prod = $this->input->post('prod');
        $flg_delete = $this->input->post('flg_delete');


        $data_update = array(
            'CHR_PART_NO' => $part_no,
            'CHR_BACK_NO' => $back_no,
            'CHR_WCENTER' => $wcenter,
            'CHR_PART_NAME' => $part_name,
            'CHR_WCENTER_MN' => $wcenter_mn,
            'CHR_TYPE' => $type,
            'CHR_SLOC' => $sloc,
            'CHR_PART_NO_HYP' => $part_no_hyp,
            'CHR_PROD' => $prod,
            'CHR_FLG_DELETE' => $flg_delete,
        );

        $this->prod_entry_m->update($data_update, $where);

        redirect('pes/admin_c/index/' . $this->uri->segment(4));
    }

    private function _process_del($w_center, $part_no, $back_no, $status_del)
    {

        $where = "CHR_PART_NO = '" . $part_no . "' AND CHR_BACK_NO = '" . $back_no . "' AND CHR_WCENTER_MN = '" . $w_center . "' ";
        $data_update = array(
            'CHR_FLG_DELETE' => $status_del,
        );
        $this->prod_entry_m->update($data_update, $where);

        redirect('pes/admin_c/index/' . $this->uri->segment(4));
    }

    private function _redirect_if_not_logged_in()
    {
        if ($this->session->userdata('role_id') != '1') {
            redirect('login/form');
        }
    }

    public function manage_packing($date_from = "", $date_to = "")
    { //fungsi download
        $this->role_module_m->authorization('30');
        $date_now = date("Ymd");
        $time_now = date("Ymd");
        $this->session->userdata('user_id');

        $data['content'] = 'delivery/manage_packing_list_v';
        $data['title'] = 'Manage Packing List';

        if ($this->input->post("btn-upload") == 1) {
            $date_from = $this->input->post("date_from");
            $date_to = $this->input->post("date_to");
            $date_from = date("Ymd", strtotime($date_from));
            $date_to = date("Ymd", strtotime($date_to));
            redirect("delivery/export_c/manage_packing/$date_from/$date_to", "refresh");
        }

        if ($date_from == "") {
            $date_from = date("Ymd");
        }

        if ($date_to == "") {
            $date_to = date("Ymd");
        }

        $date_from = date("Ymd", strtotime($date_from));
        $date_to = date("Ymd", strtotime($date_to));

        $packing_list = $this->db->query("SELECT DISTINCT(CHR_IDPACKING) FROM  TT_PACKING_UPLOAD WHERE CHR_DATE_DELIVERY between '$date_from' and '$date_to' AND INT_FLG_DEL = 0 AND (INT_FLG_FREE_PALLET IS NULL OR INT_FLG_FREE_PALLET = '0') order by CHR_IDPACKING asc")->result();
        $data['packing_list'] = $packing_list;
        $data['date_from'] = $date_from;
        $data['date_to'] = $date_to;

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(137);
        $data['news'] = $this->news_m->get_news();

        $this->load->view($this->layout, $data);
    }

    public function manage_packing_details($id_packing, $date_from, $date_to)
    { //fungsi download
        $this->role_module_m->authorization('30');
        $this->session->userdata('user_id');
        $session = $this->session->all_userdata();
        $data['role'] = $session['ROLE'];
        $data['npk'] = $session['NPK'];


        $data['content'] = 'delivery/manage_packing_list_detail_v';
        $data['title'] = 'Packing List Details ' . $id_packing;
        $packing_list_detail = $this->db->query("SELECT * ,  INT_QTY/ INT_QTY_PER_BOX  AS TOTAL_BOX , INT_QTY_PREPARE/INT_QTY_PER_BOX AS TOTAL_PREPARE_BOX FROM TT_PACKING_UPLOAD WHERE CHR_IDPACKING = '$id_packing' AND INT_FLG_DEL = 0")->result();
        $data['packing_list'] = $packing_list_detail;
        $data['id_packing'] = $id_packing;
        $data['date_from'] = $date_from;
        $data['date_to'] = $date_to;

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(137);
        $data['news'] = $this->news_m->get_news();

        $this->load->view($this->layout, $data);
    }

    public function print_case_mark($id_packing, $no_pallet, $date_from, $date_to)
    { //fungsi download
        $this->role_module_m->authorization('30');
        $this->session->userdata('user_id');
        $session = $this->session->all_userdata();
        $data['role'] = $session['ROLE'];
        $data['npk'] = $session['NPK'];

        $this->db->query("UPDATE TT_PACKING_UPLOAD SET CHR_PRINT_STATUS='1' , CHR_PREPARE_STATUS = '1' WHERE  CHR_IDPALLET='$no_pallet'");
        $data['content'] = 'delivery/manage_packing_list_detail_v';
        $data['title'] = 'Packing List Details ' . $id_packing;
        $packing_list_detail = $this->db->query("SELECT * ,  INT_QTY/ INT_QTY_PER_BOX  AS TOTAL_BOX , INT_QTY_PREPARE/INT_QTY_PER_BOX AS TOTAL_PREPARE_BOX FROM TT_PACKING_UPLOAD WHERE CHR_IDPACKING = '$id_packing' AND INT_FLG_DEL = 0")->result();
        $data['packing_list'] = $packing_list_detail;
        $data['id_packing'] = $id_packing;
        $data['success_notif'] = "Print Success";

        $data['date_from'] = $date_from;
        $data['date_to'] = $date_to;

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(137);
        $data['news'] = $this->news_m->get_news();

        $this->load->view($this->layout, $data);
    }

    function delete_packing($id_packing, $date_from, $date_to)
    {
        $session = $this->session->all_userdata();
        $npk = $session['NPK'];
        $this->picking_list_m->delete($id_packing, $npk);
        redirect("delivery/export_c/manage_packing/$date_from/$date_to", "refresh");
    }

    function manage_invoice_peb($start_date = NULL, $end_date = NULL) {
        $session = $this->session->all_userdata();
        
        $id_function = '352';
        $this->notification_m->has_be_read_by_npk_and_function($session['NPK'], $id_function);

        if ($start_date == NULL || $start_date == '') {
            $start_date = date('Ym') . '01';
        }

        if ($end_date == NULL || $end_date == '') {
            $end_date = date('Ymd');
        }

        $list_pallet = "";
        $list_po = "";
        $list_inv = "";
        $list_cont = "";
        $type = "1"; //=== default by pallet

        $session = $this->session->all_userdata();
        $role = $session['ROLE'];
        $data['role'] = $role; 

        $data['start_date'] = $start_date;  
        $data['end_date'] = $end_date;  
        $data['type'] = $type;
        $data['list_pallet'] = $list_pallet;
        $data['list_po'] = $list_po;
        $data['list_inv'] = $list_inv;
        $data['list_cont'] = $list_cont;
        
        $data['list_po_no'] = $this->picking_list_m->get_list_po_no($start_date, $end_date); 
        $data['list_pack_no'] = $this->picking_list_m->get_list_idpallet($start_date, $end_date); 
        $data['list_inv_no'] = $this->picking_list_m->get_list_inv_no($start_date, $end_date); 
        $data['list_cont_no'] = $this->picking_list_m->get_list_cont_no($start_date, $end_date);   
        
        $data['title'] = 'Manage Invoice & PEB';
        $data['content'] = 'delivery/manage_invoice_peb_v';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(352);
        $data['news'] = $this->news_m->get_news();

        // $data_pallet = $this->db->query("SELECT * FROM TT_PACKING_UPLOAD WHERE (CHR_DATE_DELIVERY BETWEEN '$start_date' AND '$end_date') AND INT_FLG_DEL = '0' AND CHR_PREPARE_STATUS = '1'");

        // if($data_pallet->num_rows() > 0){
        //     $data['data'] = $data_pallet->result();
        // } else {
            $data['data_selected_pallet'] = NULL;
            $data['data_summ_part'] = NULL;
            $data['data'] = NULL;
        // }
        
        
        $this->load->view($this->layout, $data);
    }

    function search_manage_invoice_peb() {
        $session = $this->session->all_userdata();
        
        $type = $this->input->post("CHR_TYPE");
        $start_date = $this->input->post("date_from");
        $start_date = substr($start_date,6,4) . substr($start_date,3,2) . substr($start_date,0,2);
        $end_date = $this->input->post("date_to");
        $end_date = substr($end_date,6,4) . substr($end_date,3,2) . substr($end_date,0,2);
        $pallet = $this->input->post("PACK_NO");
        $po = $this->input->post("PO_NO");
        $inv = $this->input->post("INV_NO"); 
        $cont = $this->input->post("CONT_NO"); 

        $list_pallet = "";
        $list_po = "";
        $list_inv = "";
        $list_cont = "";

        // print_r($this->input->post());

        //===== DOWNLOAD EXCEL NEW TEMPLATE =====//
        if($this->input->post('btn_download_trace')){
            $row = 2;
            
            $this->load->library(array('PHPExcel', 'PHPExcel/IOFactory'));

            $objReader = IOFactory::createReader('Excel5');

            $objPHPExcel = $objReader->load("assets/template/production/template_traceability_HVD_new.xlt");
            $active_sheet = $objPHPExcel->setActiveSheetIndexByName('TESTER & DELIVERY');

            $date_peb = '';
            $no = 1;
            for($i = 0; $i < count($cont); $i++){
                $cont_no = trim($cont[$i]) ;    
                $trace_data = $this->picking_list_m->get_trace_data_by_cont($cont_no); 
                
                foreach ($trace_data as $tr) {

                    $active_sheet->setCellValue("A$row", $no);
                    $active_sheet->setCellValue("B$row", $tr->CHR_QR_PART);

                    $partno_hyp = substr(trim($tr->CHR_PARTNO),0,6) . '-' . substr(trim($tr->CHR_PARTNO),6,5);
                    $serial_no = substr($tr->CHR_QR_PART,12,8);

                    // $qrcode_hyp = substr($tr->CHR_QR_PART,0,38) . $partno_hyp . substr($tr->CHR_QR_PART,50);
                    $active_sheet->setCellValue("C$row", $serial_no);

                    $active_sheet->setCellValue("D$row", $tr->CHR_YEAR);
                    $active_sheet->setCellValue("E$row", $tr->CHR_MONTH);
                    $active_sheet->setCellValue("F$row", $tr->CHR_DAY);
                    $active_sheet->setCellValue("G$row", $tr->CHR_HOUR);
                    $active_sheet->setCellValue("H$row", $tr->CHR_MINUTE);
                    $active_sheet->setCellValue("I$row", $tr->CHR_SECOND);
                    $active_sheet->setCellValue("J$row", $tr->CHR_MASTER_NO);
                    $active_sheet->setCellValue("K$row", $tr->INT_FLG_SCAN);
                    $active_sheet->setCellValue("L$row", trim($tr->CHR_KANBAN_NO));
                    $active_sheet->setCellValue("M$row", $tr->CHR_MODIFIED_DATE);
                    $active_sheet->getStyle("N$row")->getNumberFormat()->setFormatCode('000000');
                    $active_sheet->setCellValue("N$row", $tr->CHR_MODIFIED_TIME);
                    $active_sheet->setCellValue("O$row", trim($tr->CHR_IDPALLET));                    
                    $active_sheet->setCellValue("P$row", trim($tr->CHR_PARTNO_CUST));
                    $active_sheet->setCellValue("Q$row", trim($partno_hyp));
                    $active_sheet->setCellValue("R$row", $tr->CHR_DATE_SCAN);
                    $active_sheet->getStyle("S$row")->getNumberFormat()->setFormatCode('000000');
                    $active_sheet->setCellValue("S$row", $tr->CHR_TIME_SCAN);
                    $active_sheet->setCellValue("T$row", trim($tr->CHR_NOPO_SAP));
                    $active_sheet->setCellValue("U$row", $tr->CHR_DATE_DELIVERY_ACT);
                    $active_sheet->setCellValue("V$row", trim($tr->CHR_CONTAINER_NO));
                    
                    $date_peb = $tr->CHR_DATE_DELIVERY_PEB;
                    $no++;
                    $row++;
                    
                }
            }

            ob_end_clean();
            $list_cont_no = '';
            for($i = 0; $i < count($cont); $i++){
                $cont_no = trim($cont[$i]) ;
                if($i < (count($cont)-1)){
                    $list_cont_no .= "" . trim($cont_no) . " - ";
                } else {
                    $list_cont_no .= "" . trim($cont_no) . "";
                }
            }
            $filename = "Traceability " . $list_cont_no . " (" . $date_peb . ").xls";
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="' . trim($filename) . '"');
            header('Cache-Control: max-age=0');

            $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
            // $objWriter->setIncludeCharts(TRUE);
            $objWriter->save('php://output');
        }

        //===== SAVE & EMAIL EXCEL & TSV =====//
        if($this->input->post('export_to_server') == 'export_to_server'){
            //===== 1. GENERATE EXCEL FORMAT =====//
            $row = 2;
            
            $this->load->library('excel');

            // Create new PHPExcel object
            $objPHPExcel = new PHPExcel();

            $active_sheet =  $objPHPExcel->setActiveSheetIndex(0);
            $active_sheet->setCellValue("A1", "NO");
            $active_sheet->setCellValue("B1", "QR CODE PRODUCT");
            $active_sheet->setCellValue("C1", "SERIAL NO");
            $active_sheet->setCellValue("D1", "YEAR");
            $active_sheet->setCellValue("E1", "MONTH");
            $active_sheet->setCellValue("F1", "DAY");
            $active_sheet->setCellValue("G1", "HOUR");
            $active_sheet->setCellValue("H1", "MINUTE");
            $active_sheet->setCellValue("I1", "SECOND");
            $active_sheet->setCellValue("J1", "MASTER NO");
            $active_sheet->setCellValue("K1", "FLAG SCAN");
            $active_sheet->setCellValue("L1", "KANBAN NO");
            $active_sheet->setCellValue("M1", "SCAN DATE");
            $active_sheet->setCellValue("N1", "SCAN TIME");
            $active_sheet->setCellValue("O1", "ID PALLET");
            $active_sheet->setCellValue("P1", "PART NO CUST");
            $active_sheet->setCellValue("Q1", "AISIN P/N");
            $active_sheet->setCellValue("R1", "PULLING DATE");
            $active_sheet->setCellValue("S1", "PULLING TIME");
            $active_sheet->setCellValue("T1", "PO NO");
            $active_sheet->setCellValue("U1", "DELIVERY DATE");
            $active_sheet->setCellValue("V1", "CONTAINER NO");

            $date_peb = '';
            $no = 1;
            for($i = 0; $i < count($cont); $i++){
                $cont_no = trim($cont[$i]) ;    
                $trace_data = $this->picking_list_m->get_trace_data_by_cont($cont_no); 
                
                foreach ($trace_data as $tr) {

                    $active_sheet->setCellValue("A$row", $no);
                    $active_sheet->setCellValue("B$row", $tr->CHR_QR_PART);

                    $partno_hyp = substr(trim($tr->CHR_PARTNO),0,6) . '-' . substr(trim($tr->CHR_PARTNO),6,5);
                    $serial_no = substr($tr->CHR_QR_PART,12,8);

                    // $qrcode_hyp = substr($tr->CHR_QR_PART,0,38) . $partno_hyp . substr($tr->CHR_QR_PART,50);
                    $active_sheet->setCellValue("C$row", $serial_no);

                    $active_sheet->setCellValue("D$row", $tr->CHR_YEAR);
                    $active_sheet->setCellValue("E$row", $tr->CHR_MONTH);
                    $active_sheet->setCellValue("F$row", $tr->CHR_DAY);
                    $active_sheet->setCellValue("G$row", $tr->CHR_HOUR);
                    $active_sheet->setCellValue("H$row", $tr->CHR_MINUTE);
                    $active_sheet->setCellValue("I$row", $tr->CHR_SECOND);
                    $active_sheet->setCellValue("J$row", $tr->CHR_MASTER_NO);
                    $active_sheet->setCellValue("K$row", $tr->INT_FLG_SCAN);
                    $active_sheet->setCellValue("L$row", trim($tr->CHR_KANBAN_NO));
                    $active_sheet->setCellValue("M$row", $tr->CHR_MODIFIED_DATE);
                    $active_sheet->getStyle("N$row")->getNumberFormat()->setFormatCode('000000');
                    $active_sheet->setCellValue("N$row", $tr->CHR_MODIFIED_TIME);
                    $active_sheet->setCellValue("O$row", trim($tr->CHR_IDPALLET));                    
                    $active_sheet->setCellValue("P$row", trim($tr->CHR_PARTNO_CUST));
                    $active_sheet->setCellValue("Q$row", trim($partno_hyp));
                    $active_sheet->setCellValue("R$row", $tr->CHR_DATE_SCAN);
                    $active_sheet->getStyle("S$row")->getNumberFormat()->setFormatCode('000000');
                    $active_sheet->setCellValue("S$row", $tr->CHR_TIME_SCAN);
                    $active_sheet->setCellValue("T$row", trim($tr->CHR_NOPO_SAP));
                    $active_sheet->setCellValue("U$row", $tr->CHR_DATE_DELIVERY_ACT);
                    $active_sheet->setCellValue("V$row", trim($tr->CHR_CONTAINER_NO));
                    
                    $date_peb = $tr->CHR_DATE_DELIVERY_PEB;
                    $no++;
                    $row++;
                    
                }
            }

            $list_cont_no = '';
            for($i = 0; $i < count($cont); $i++){
                $cont_no = trim($cont[$i]) ;
                if($i < (count($cont)-1)){
                    $list_cont_no .= "" . trim($cont_no) . " - ";
                } else {
                    $list_cont_no .= "" . trim($cont_no) . "";
                }
            }

            $filename = "Traceability " . $list_cont_no . " (" . $date_peb . ").xls";
            // ob_end_clean();
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            // header('Content-Disposition: attachment; filename="' . trim($filename) . '"');
            // header('Cache-Control: max-age=0');
            $objWriter->save(getcwd() . '/assets/Document/mailAttachment/' . trim($filename));

            //===== 2. GENERATE & SAVE TSV FORMAT =====//
            $csv = '';
            $csv .= 'NO';
            $csv .= "\t";
            $csv .= 'QR CODE PRODUCT';
            $csv .= "\t";
            $csv .= 'SERIAL NO';
            $csv .= "\t";
            $csv .= 'YEAR';
            $csv .= "\t";
            $csv .= 'MONTH';
            $csv .= "\t";
            $csv .= 'DAY';
            $csv .= "\t";
            $csv .= 'HOUR';
            $csv .= "\t";
            $csv .= 'MINUTE';
            $csv .= "\t";
            $csv .= 'SECOND';
            $csv .= "\t";
            $csv .= 'MASTER NO';
            $csv .= "\t";
            $csv .= 'FLAG SCAN';
            $csv .= "\t";
            $csv .= 'KANBAN NO';
            $csv .= "\t";
            $csv .= 'SCAN DATE';
            $csv .= "\t";
            $csv .= 'SCAN TIME';
            $csv .= "\t";
            $csv .= 'ID PALLET';
            $csv .= "\t";
            $csv .= 'PART NO CUST';
            $csv .= "\t";
            $csv .= 'AISIN P/N';
            $csv .= "\t";
            $csv .= 'PULLING DATE';
            $csv .= "\t";
            $csv .= 'PULLING TIME';
            $csv .= "\t";
            $csv .= 'PO NO';
            $csv .= "\t";
            $csv .= 'DELIVERY DATE';
            $csv .= "\t";
            $csv .= 'CONTAINER NO';
            $csv .= "\t";

            $csv .= "\n";

            $no = 1;
            $date_peb = '';
            for($i = 0; $i < count($cont); $i++){
                $cont_no = trim($cont[$i]) ;    
                $trace_data = $this->picking_list_m->get_trace_data_by_cont($cont_no); 
                
                foreach ($trace_data as $tr) {

                    $csv .= $no;
                    $csv .= "\t";
                    $csv .= $tr->CHR_QR_PART;
                    $csv .= "\t";

                    $partno_hyp = substr(trim($tr->CHR_PARTNO),0,6) . '-' . substr(trim($tr->CHR_PARTNO),6,5);
                    $serial_no = substr($tr->CHR_QR_PART,12,8);

                    $csv .= $serial_no;
                    $csv .= "\t";
                    $csv .= $tr->CHR_YEAR;
                    $csv .= "\t";
                    $csv .= $tr->CHR_MONTH;
                    $csv .= "\t";
                    $csv .= $tr->CHR_DAY;
                    $csv .= "\t";
                    $csv .= $tr->CHR_HOUR;
                    $csv .= "\t";
                    $csv .= $tr->CHR_MINUTE;
                    $csv .= "\t";
                    $csv .= $tr->CHR_SECOND;
                    $csv .= "\t";
                    $csv .= $tr->CHR_MASTER_NO;
                    $csv .= "\t";
                    $csv .= $tr->INT_FLG_SCAN;
                    $csv .= "\t";
                    $csv .= trim($tr->CHR_KANBAN_NO);
                    $csv .= "\t";
                    $csv .= $tr->CHR_MODIFIED_DATE;
                    $csv .= "\t";
                    $csv .= $tr->CHR_MODIFIED_TIME;
                    $csv .= "\t";
                    $csv .= trim($tr->CHR_IDPALLET);
                    $csv .= "\t";
                    $csv .= trim($tr->CHR_PARTNO_CUST);
                    $csv .= "\t";
                    $csv .= trim($partno_hyp);
                    $csv .= "\t";
                    $csv .= $tr->CHR_DATE_SCAN;
                    $csv .= "\t";
                    $csv .= $tr->CHR_TIME_SCAN;
                    $csv .= "\t";
                    $csv .= trim($tr->CHR_NOPO_SAP);
                    $csv .= "\t";
                    $csv .= $tr->CHR_DATE_DELIVERY_ACT;
                    $csv .= "\t";
                    $csv .= trim($tr->CHR_CONTAINER_NO);
                    $csv .= "\t";

                    $csv .= "\n";

                    $date_peb = $tr->CHR_DATE_DELIVERY_PEB;
                    $no++;
                    
                }
            }

            $list_cont_no = '';
            for($i = 0; $i < count($cont); $i++){
                $cont_no = trim($cont[$i]) ;
                if($i < (count($cont)-1)){
                    $list_cont_no .= "" . trim($cont_no) . " - ";
                } else {
                    $list_cont_no .= "" . trim($cont_no) . "";
                }
            }
            $filename_tsv = "Traceability " . $list_cont_no . " (" . $date_peb . ").tsv";

            $fp = fopen(getcwd() . '/assets/Document/mailAttachment/' . $filename_tsv, 'w');
            
            fwrite($fp,$csv);
            fclose($fp);

            //===== 3. SENDING EMAIL =====//
            $this->load->library('email');
            $this->email->from('it@aisin-indonesia.co.id', 'AIS System');
            $this->email->to('aditya.np@aisin-indonesia.co.id');
            // $this->email->cc('cebong.toro@gmail.com');
            // $this->email->subject('Traceability '. trim($list_cont_no) . ' (' . $date_peb . ')');
            $this->email->subject('Traceability');
            $msg_email = 'Dear Rossi-san & Edwin-san,';
            $msg_email .= '<br>';
            $msg_email .= '<br>';
            // $msg_email .= 'Attached traceability file for container ' . trim($list_cont_no) . '.';
            $msg_email .= 'Attached traceability file for container';
            $msg_email .= '<br>';
            $msg_email .= '<br>';
            $msg_email .= 'Please check items below before sending it to AWA:';
            $msg_email .= '<br>';
            $msg_email .= '1. No blank column of QR tester';
            $msg_email .= '<br>';
            $msg_email .= '2. Total row data same with actual delivery qty';
            $msg_email .= '<br>';
            $msg_email .= '3. No duplicate value of QR tester';
            $msg_email .= '<br>';
            $msg_email .= '<br>';
            $msg_email .= 'Thank You';
            $msg_email .= '<br>';
            $msg_email .= '<br>';
            $msg_email .= 'Best Regards,';
            $msg_email .= '<br>';
            $msg_email .= 'AIS System';
            $this->email->message($msg_email);
            $this->email->attach(DOCROOT . '/assets/Document/mailAttachment/' . $filename);
            $this->email->attach(DOCROOT . '/assets/Document/mailAttachment/' . $filename_tsv);
            $return = $this->email->send();
            
            // if ($return) {
            //     echo 'email sending success';
            // } else {
            //     print_r($this->email->print_debugger());
            // }
        }
        //===== SAVE & EMAIL EXCEL & TSV =====//

        //===== DOWNLOAD TSV FILE =====//
        if($this->input->post('btn_download_tsv')){
            $csv = '';
            $csv .= 'NO';
            $csv .= "\t";
            $csv .= 'QR CODE PRODUCT';
            $csv .= "\t";
            $csv .= 'SERIAL NO';
            $csv .= "\t";
            $csv .= 'YEAR';
            $csv .= "\t";
            $csv .= 'MONTH';
            $csv .= "\t";
            $csv .= 'DAY';
            $csv .= "\t";
            $csv .= 'HOUR';
            $csv .= "\t";
            $csv .= 'MINUTE';
            $csv .= "\t";
            $csv .= 'SECOND';
            $csv .= "\t";
            $csv .= 'MASTER NO';
            $csv .= "\t";
            $csv .= 'FLAG SCAN';
            $csv .= "\t";
            $csv .= 'KANBAN NO';
            $csv .= "\t";
            $csv .= 'SCAN DATE';
            $csv .= "\t";
            $csv .= 'SCAN TIME';
            $csv .= "\t";
            $csv .= 'ID PALLET';
            $csv .= "\t";
            $csv .= 'PART NO CUST';
            $csv .= "\t";
            $csv .= 'AISIN P/N';
            $csv .= "\t";
            $csv .= 'PULLING DATE';
            $csv .= "\t";
            $csv .= 'PULLING TIME';
            $csv .= "\t";
            $csv .= 'PO NO';
            $csv .= "\t";
            $csv .= 'DELIVERY DATE';
            $csv .= "\t";
            $csv .= 'CONTAINER NO';
            $csv .= "\t";

            $csv .= "\n";

            $no = 1;
            $date_peb = '';
            for($i = 0; $i < count($cont); $i++){
                $cont_no = trim($cont[$i]) ;    
                $trace_data = $this->picking_list_m->get_trace_data_by_cont($cont_no);
                
                foreach ($trace_data as $tr) {

                    $csv .= $no;
                    $csv .= "\t";
                    $csv .= $tr->CHR_QR_PART;
                    $csv .= "\t";

                    $partno_hyp = substr(trim($tr->CHR_PARTNO),0,6) . '-' . substr(trim($tr->CHR_PARTNO),6,5);
                    $serial_no = substr($tr->CHR_QR_PART,12,8);

                    $csv .= $serial_no;
                    $csv .= "\t";
                    $csv .= $tr->CHR_YEAR;
                    $csv .= "\t";
                    $csv .= $tr->CHR_MONTH;
                    $csv .= "\t";
                    $csv .= $tr->CHR_DAY;
                    $csv .= "\t";
                    $csv .= $tr->CHR_HOUR;
                    $csv .= "\t";
                    $csv .= $tr->CHR_MINUTE;
                    $csv .= "\t";
                    $csv .= $tr->CHR_SECOND;
                    $csv .= "\t";
                    $csv .= $tr->CHR_MASTER_NO;
                    $csv .= "\t";
                    $csv .= $tr->INT_FLG_SCAN;
                    $csv .= "\t";
                    $csv .= trim($tr->CHR_KANBAN_NO);
                    $csv .= "\t";
                    $csv .= $tr->CHR_MODIFIED_DATE;
                    $csv .= "\t";
                    $csv .= $tr->CHR_MODIFIED_TIME;
                    $csv .= "\t";
                    $csv .= trim($tr->CHR_IDPALLET);
                    $csv .= "\t";
                    $csv .= trim($tr->CHR_PARTNO_CUST);
                    $csv .= "\t";
                    $csv .= trim($partno_hyp);
                    $csv .= "\t";
                    $csv .= $tr->CHR_DATE_SCAN;
                    $csv .= "\t";
                    $csv .= $tr->CHR_TIME_SCAN;
                    $csv .= "\t";
                    $csv .= trim($tr->CHR_NOPO_SAP);
                    $csv .= "\t";
                    $csv .= $tr->CHR_DATE_DELIVERY_ACT;
                    $csv .= "\t";
                    $csv .= trim($tr->CHR_CONTAINER_NO);
                    $csv .= "\t";

                    $csv .= "\n";

                    $date_peb = $tr->CHR_DATE_DELIVERY_PEB;
                    $no++;
                    
                }
            }

            $list_cont_no = '';
            for($i = 0; $i < count($cont); $i++){
                $cont_no = trim($cont[$i]) ;
                if($i < (count($cont)-1)){
                    $list_cont_no .= "" . trim($cont_no) . " - ";
                } else {
                    $list_cont_no .= "" . trim($cont_no) . "";
                }
            }
            $filename = "Traceability " . $list_cont_no . " (" . $date_peb . ").tsv";
            header('Content-Type: text/plain');
            header('Content-Disposition: attachment;filename="' . trim($filename) . '"');
            // $fp = fopen('/assets/Document/mailAttachment/' . $filename, 'w');
            // fputcsv($filename, $csv);
            // fclose($fp);

            echo $csv;
            exit();
        }
        //===== END DOWNLOAD TSV FILE =====//
        
        //===== SAVE TSV TO SERVER FOLDER =====//
        // if($this->input->post('btn_download_tsv')){     

        //     $csv = '';
        //     $csv .= 'NO';
        //     $csv .= "\t";
        //     $csv .= 'QR CODE PRODUCT';
        //     $csv .= "\t";
        //     $csv .= 'SERIAL NO';
        //     $csv .= "\t";
        //     $csv .= 'YEAR';
        //     $csv .= "\t";
        //     $csv .= 'MONTH';
        //     $csv .= "\t";
        //     $csv .= 'DAY';
        //     $csv .= "\t";
        //     $csv .= 'HOUR';
        //     $csv .= "\t";
        //     $csv .= 'MINUTE';
        //     $csv .= "\t";
        //     $csv .= 'SECOND';
        //     $csv .= "\t";
        //     $csv .= 'MASTER NO';
        //     $csv .= "\t";
        //     $csv .= 'FLAG SCAN';
        //     $csv .= "\t";
        //     $csv .= 'KANBAN NO';
        //     $csv .= "\t";
        //     $csv .= 'SCAN DATE';
        //     $csv .= "\t";
        //     $csv .= 'SCAN TIME';
        //     $csv .= "\t";
        //     $csv .= 'ID PALLET';
        //     $csv .= "\t";
        //     $csv .= 'PART NO CUST';
        //     $csv .= "\t";
        //     $csv .= 'AISIN P/N';
        //     $csv .= "\t";
        //     $csv .= 'PULLING DATE';
        //     $csv .= "\t";
        //     $csv .= 'PULLING TIME';
        //     $csv .= "\t";
        //     $csv .= 'PO NO';
        //     $csv .= "\t";
        //     $csv .= 'DELIVERY DATE';
        //     $csv .= "\t";
        //     $csv .= 'CONTAINER NO';
        //     $csv .= "\t";

        //     $csv .= "\n";

        //     $no = 1;
        //     $date_peb = '';
        //     for($i = 0; $i < count($cont); $i++){
        //         $cont_no = trim($cont[$i]) ;    
        //         $trace_data = $this->picking_list_m->get_trace_data_by_cont($cont_no); 
                
        //         foreach ($trace_data as $tr) {

        //             $csv .= $no;
        //             $csv .= "\t";
        //             $csv .= $tr->CHR_QR_PART;
        //             $csv .= "\t";

        //             $partno_hyp = substr(trim($tr->CHR_PARTNO),0,6) . '-' . substr(trim($tr->CHR_PARTNO),6,5);
        //             $serial_no = substr($tr->CHR_QR_PART,12,8);

        //             $csv .= $serial_no;
        //             $csv .= "\t";
        //             $csv .= $tr->CHR_YEAR;
        //             $csv .= "\t";
        //             $csv .= $tr->CHR_MONTH;
        //             $csv .= "\t";
        //             $csv .= $tr->CHR_DAY;
        //             $csv .= "\t";
        //             $csv .= $tr->CHR_HOUR;
        //             $csv .= "\t";
        //             $csv .= $tr->CHR_MINUTE;
        //             $csv .= "\t";
        //             $csv .= $tr->CHR_SECOND;
        //             $csv .= "\t";
        //             $csv .= $tr->CHR_MASTER_NO;
        //             $csv .= "\t";
        //             $csv .= $tr->INT_FLG_SCAN;
        //             $csv .= "\t";
        //             $csv .= trim($tr->CHR_KANBAN_NO);
        //             $csv .= "\t";
        //             $csv .= $tr->CHR_MODIFIED_DATE;
        //             $csv .= "\t";
        //             $csv .= $tr->CHR_MODIFIED_TIME;
        //             $csv .= "\t";
        //             $csv .= trim($tr->CHR_IDPALLET);
        //             $csv .= "\t";
        //             $csv .= trim($tr->CHR_PARTNO_CUST);
        //             $csv .= "\t";
        //             $csv .= trim($partno_hyp);
        //             $csv .= "\t";
        //             $csv .= $tr->CHR_DATE_SCAN;
        //             $csv .= "\t";
        //             $csv .= $tr->CHR_TIME_SCAN;
        //             $csv .= "\t";
        //             $csv .= trim($tr->CHR_NOPO_SAP);
        //             $csv .= "\t";
        //             $csv .= $tr->CHR_DATE_DELIVERY_ACT;
        //             $csv .= "\t";
        //             $csv .= trim($tr->CHR_CONTAINER_NO);
        //             $csv .= "\t";

        //             $csv .= "\n";

        //             $date_peb = $tr->CHR_DATE_DELIVERY_PEB;
        //             $no++;
                    
        //         }
        //     }

        //     $list_cont_no = '';
        //     for($i = 0; $i < count($cont); $i++){
        //         $cont_no = trim($cont[$i]) ;
        //         if($i < (count($cont)-1)){
        //             $list_cont_no .= "" . trim($cont_no) . " - ";
        //         } else {
        //             $list_cont_no .= "" . trim($cont_no) . "";
        //         }
        //     }
        //     $filename = "Traceability " . $list_cont_no . " (" . $date_peb . ").tsv";

        //     $fp = fopen(getcwd() . '/assets/Document/mailAttachment/' . $filename, 'w');
            
        //     fwrite($fp,$csv);
        //     fclose($fp);
        // }
        //===== END SAVE TSV TO SERVER FOLDER =====//

        if($type == '1'){ //by Pallet No
            for($i = 0; $i < count($pallet); $i++){
                $pallet_no = trim($pallet[$i]) ;                   
                
                if($i < (count($pallet)-1)){
                    $list_pallet .= "'" . trim($pallet_no) . "',";
                } else {
                    $list_pallet .= "'" . trim($pallet_no) . "'";
                }
                
            }

            $data_pallet = $this->picking_list_m->get_list_data_packing_by_idpallet($start_date, $end_date, $list_pallet); 
            $data_selected_pallet = NULL; //$this->picking_list_m->get_list_selected_pallet_by_idpallet($start_date, $end_date, $list_pallet); 
            $data_summ_export_by_partno = NULL; //$this->picking_list_m->get_summ_export_by_partno_by_idpallet($start_date, $end_date, $list_pallet); 
        } else if($type == '2'){ //by PO No
            for($i = 0; $i < count($po); $i++){
                $po_no = trim($po[$i]) ;                   
                
                if($i < (count($po)-1)){
                    $list_po .= "'" . trim($po_no) . "',";
                } else {
                    $list_po .= "'" . trim($po_no) . "'";
                }
                
            }

            $data_pallet = $this->picking_list_m->get_list_data_packing_by_po($start_date, $end_date, $list_po);
            $data_selected_pallet = NULL; //$this->picking_list_m->get_list_selected_pallet_by_po($start_date, $end_date, $list_po);  
            $data_summ_export_by_partno = NULL; //$this->picking_list_m->get_summ_export_by_partno_by_po($start_date, $end_date, $list_po); 
        } else if($type == '4'){ //by Invoice No
            for($i = 0; $i < count($inv); $i++){
                $inv_no = trim($inv[$i]) ;                   
                
                if($i < (count($inv)-1)){
                    $list_inv .= "'" . trim($inv_no) . "',";
                } else {
                    $list_inv .= "'" . trim($inv_no) . "'";
                }
                
            }

            $data_pallet = $this->picking_list_m->get_list_data_packing_by_inv($start_date, $end_date, $list_inv);
            $data_selected_pallet = NULL; //$this->picking_list_m->get_list_selected_pallet_by_inv($start_date, $end_date, $list_inv);
            $data_summ_export_by_partno = NULL; //$this->picking_list_m->get_summ_export_by_partno_by_inv($start_date, $end_date, $list_inv); 
        } else if($type == '5'){ //by Container No
            for($i = 0; $i < count($cont); $i++){
                $cont_no = trim($cont[$i]) ;                   
                
                if($i < (count($inv)-1)){
                    $list_cont .= "'" . trim($cont_no) . "',";
                } else {
                    $list_cont .= "'" . trim($cont_no) . "'";
                }
                
            }

            $data_pallet = $this->picking_list_m->get_list_data_packing_by_cont($start_date, $end_date, $list_cont);
            $data_selected_pallet = NULL; //$this->picking_list_m->get_list_selected_pallet_by_cont($start_date, $end_date, $list_inv);
            $data_summ_export_by_partno = NULL; //$this->picking_list_m->get_summ_export_by_partno_by_cont($start_date, $end_date, $list_inv); 
        }

        $session = $this->session->all_userdata();
        $role = $session['ROLE'];
        $data['role'] = $role; 

        $data['start_date'] = $start_date;  
        $data['end_date'] = $end_date;  
        $data['type'] = $type;
        $data['list_pallet'] = $pallet;
        $data['list_po'] = $po;
        $data['list_inv'] = $inv;
        $data['list_cont'] = $cont;

        $data['list_po_no'] = $this->picking_list_m->get_list_po_no($start_date, $end_date); 
        $data['list_pack_no'] = $this->picking_list_m->get_list_idpallet($start_date, $end_date); 
        $data['list_inv_no'] = $this->picking_list_m->get_list_inv_no($start_date, $end_date); 
        $data['list_cont_no'] = $this->picking_list_m->get_list_cont_no($start_date, $end_date);    
        
        $data['title'] = 'Manage Invoice & PEB';
        $data['content'] = 'delivery/manage_invoice_peb_v';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(352);
        $data['news'] = $this->news_m->get_news();
        
        $data['data_selected_pallet'] = $data_selected_pallet;
        $data['data_summ_part'] = $data_summ_export_by_partno;
        $data['data'] = $data_pallet;
        
        $this->load->view($this->layout, $data);
    }

    function get_list_packing(){
        $start_date = $this->input->post("date_start");
        $start_date = substr($start_date,6,4) . substr($start_date,3,2) . substr($start_date,0,2);
        $end_date = $this->input->post("date_end");
        $end_date = substr($end_date,6,4) . substr($end_date,3,2) . substr($end_date,0,2);
        $type = trim($this->input->post("type"));

        if($type == '1'){
            $data_pallet = $this->db->query("SELECT DISTINCT CHR_IDPALLET FROM TT_PACKING_UPLOAD WHERE (CHR_DATE_DELIVERY BETWEEN '$start_date' AND '$end_date') AND INT_FLG_DEL = '0' AND CHR_PREPARE_STATUS = '1'")->result();

            $data = '';
            foreach ($data_pallet as $row) { 
                $data .="<option value='" . trim($row->CHR_IDPALLET) . "'>" . trim($row->CHR_IDPALLET) . "</option>";
            }
        } else if($type == '2'){
            $data_pallet = $this->db->query("SELECT DISTINCT CHR_NOPO_CUST FROM TT_PACKING_UPLOAD WHERE (CHR_DATE_DELIVERY BETWEEN '$start_date' AND '$end_date') AND INT_FLG_DEL = '0' AND CHR_PREPARE_STATUS = '1'")->result();

            $data = '';
            foreach ($data_pallet as $row) { 
                $data .="<option value='" . trim($row->CHR_NOPO_CUST) . "'>" . trim($row->CHR_NOPO_CUST) . "</option>";
            }
        } else if($type == '4'){
            $data_pallet = $this->db->query("SELECT DISTINCT CHR_INVOICE_NO FROM TT_PACKING_UPLOAD WHERE (CHR_DATE_DELIVERY BETWEEN '$start_date' AND '$end_date') AND INT_FLG_DEL = '0' AND CHR_PREPARE_STATUS = '1'")->result();

            $data = '';
            foreach ($data_pallet as $row) { 
                $data .="<option value='" . trim($row->CHR_INVOICE_NO) . "'>" . trim($row->CHR_INVOICE_NO) . "</option>";
            }
        } else if($type == '5'){
            $data_pallet = $this->db->query("SELECT DISTINCT CHR_CONTAINER_NO FROM TT_PACKING_UPLOAD WHERE (CHR_DATE_DELIVERY BETWEEN '$start_date' AND '$end_date') AND INT_FLG_DEL = '0' AND CHR_PREPARE_STATUS = '1'")->result();

            $data = '';
            foreach ($data_pallet as $row) { 
                $data .="<option value='" . trim($row->CHR_CONTAINER_NO) . "'>" . trim($row->CHR_CONTAINER_NO) . "</option>";
            }
        }           

        $json_data = array('data' => $data);

        echo json_encode($json_data);
    }

    function update_data_inv_by_id_pallet(){
        $session = $this->session->all_userdata();
        $user = $session['USERNAME'];
        $date = date("Ymd");
        $time = date("His");

        $id_pallet = trim($this->input->post("pallet_id"));
        $inv_no = trim($this->input->post("invoice"));

        // $inv_no = preg_replace('/\s/','',$inv_no);

        $this->db->query("UPDATE TT_PACKING_UPLOAD 
                        SET CHR_INVOICE_NO = '$inv_no',
                            CHR_USER_UPDATE_INV = '$user',
                            CHR_DATE_UPDATE_INV = '$date',
                            CHR_TIME_UPDATE_INV = '$time'
                        WHERE CHR_IDPALLET = '$id_pallet'");
        echo json_encode("OK");    
    }

    function update_data_inv_batch(){
        $session = $this->session->all_userdata();
        $user = $session['USERNAME'];
        $date = date("Ymd");
        $time = date("His");

        $start_date = $this->input->post("date_start");
        $start_date = substr($start_date,6,4) . substr($start_date,3,2) . substr($start_date,0,2);
        $end_date = $this->input->post("date_end");
        $end_date = substr($end_date,6,4) . substr($end_date,3,2) . substr($end_date,0,2);

        $type = trim($this->input->post("type"));
        $list_param = trim($this->input->post("data_param"));
        $inv_no = trim($this->input->post("inv_no"));
        // $inv_no = preg_replace('/\s/','',$inv_no);        

        $data_param =  explode("," , $list_param);

        for($i = 0; $i < count($data_param); $i++){
            $param = trim($data_param[$i]) ;

            if($type == '1'){
                $this->db->query("UPDATE TT_PACKING_UPLOAD 
                            SET CHR_INVOICE_NO = '$inv_no',
                                CHR_USER_UPDATE_INV = '$user',
                                CHR_DATE_UPDATE_INV = '$date',
                                CHR_TIME_UPDATE_INV = '$time' 
                            WHERE CHR_IDPALLET = '$param' AND (CHR_DATE_DELIVERY BETWEEN '$start_date' AND '$end_date') AND CHR_PREPARE_STATUS = '1' AND INT_FLG_DEL = '0'");
            } else if($type == '2'){
                $this->db->query("UPDATE TT_PACKING_UPLOAD 
                            SET CHR_INVOICE_NO = '$inv_no',
                                CHR_USER_UPDATE_INV = '$user',
                                CHR_DATE_UPDATE_INV = '$date',
                                CHR_TIME_UPDATE_INV = '$time' 
                            WHERE CHR_NOPO_CUST = '$param' AND (CHR_DATE_DELIVERY BETWEEN '$start_date' AND '$end_date') AND CHR_PREPARE_STATUS = '1' AND INT_FLG_DEL = '0'");
            } else if($type == '4'){
                $this->db->query("UPDATE TT_PACKING_UPLOAD 
                            SET CHR_INVOICE_NO = '$inv_no',
                                CHR_USER_UPDATE_INV = '$user',
                                CHR_DATE_UPDATE_INV = '$date',
                                CHR_TIME_UPDATE_INV = '$time' 
                            WHERE CHR_INVOICE_NO = '$param' AND (CHR_DATE_DELIVERY BETWEEN '$start_date' AND '$end_date') AND CHR_PREPARE_STATUS = '1' AND INT_FLG_DEL = '0'");
            } else if($type == '5'){
                $this->db->query("UPDATE TT_PACKING_UPLOAD 
                            SET CHR_INVOICE_NO = '$inv_no',
                                CHR_USER_UPDATE_INV = '$user',
                                CHR_DATE_UPDATE_INV = '$date',
                                CHR_TIME_UPDATE_INV = '$time' 
                            WHERE CHR_CONTAINER_NO = '$param' AND (CHR_DATE_DELIVERY BETWEEN '$start_date' AND '$end_date') AND CHR_PREPARE_STATUS = '1' AND INT_FLG_DEL = '0'");
            }            
        }        
        echo json_encode("OK");    
    }

    function update_data_peb_by_id_pallet(){
        $session = $this->session->all_userdata();
        $user = $session['USERNAME'];
        $date = date("Ymd");
        $time = date("His");

        $id_pallet = trim($this->input->post("pallet_id"));
        $peb_no = trim($this->input->post("peb_id"));
        // $peb_no = preg_replace('/\s/','',$peb_no);
        $container_no = trim($this->input->post("container_id"));
        $vessel_no = trim($this->input->post("vessel_id"));
        $date_del = trim($this->input->post("del_peb"));
        $date_del = substr($date_del,6,4) . substr($date_del,3,2) . substr($date_del,0,2);

        $this->db->query("UPDATE TT_PACKING_UPLOAD 
                            SET CHR_PEB_NO = '$peb_no', 
                                CHR_CONTAINER_NO = '$container_no', 
                                CHR_VESSEL_NO = '$vessel_no', 
                                CHR_DATE_DELIVERY_PEB = '$date_del',
                                CHR_USER_UPDATE_PEB = '$user',
                                CHR_DATE_UPDATE_PEB = '$date',
                                CHR_TIME_UPDATE_PEB = '$time' 
                            WHERE CHR_IDPALLET = '$id_pallet'");

        echo json_encode("OK");         
    }

    function update_data_peb_batch(){
        $session = $this->session->all_userdata();
        $user = $session['USERNAME'];
        $date = date("Ymd");
        $time = date("His");

        $start_date = $this->input->post("date_start");
        $start_date = substr($start_date,6,4) . substr($start_date,3,2) . substr($start_date,0,2);
        $end_date = $this->input->post("date_end");
        $end_date = substr($end_date,6,4) . substr($end_date,3,2) . substr($end_date,0,2);
        
        $type = trim($this->input->post("type"));
        $peb_no = trim($this->input->post("peb_id"));
        // $peb_no = preg_replace('/\s/','',$peb_no);
        $container_no = trim($this->input->post("container_id"));
        $vessel_no = trim($this->input->post("vessel_id"));
        $date_del = trim($this->input->post("del_peb"));
        $date_del = substr($date_del,6,4) . substr($date_del,3,2) . substr($date_del,0,2);
        
        $list_param = trim($this->input->post("data_param"));
        $data_param =  explode("," , $list_param);

        for($i = 0; $i < count($data_param); $i++){
            $param = trim($data_param[$i]) ;

            if($type == '1'){
                $this->db->query("UPDATE TT_PACKING_UPLOAD 
                            SET CHR_PEB_NO = '$peb_no', 
                                CHR_CONTAINER_NO = '$container_no', 
                                CHR_VESSEL_NO = '$vessel_no', 
                                CHR_DATE_DELIVERY_PEB = '$date_del',
                                CHR_USER_UPDATE_PEB = '$user',
                                CHR_DATE_UPDATE_PEB = '$date',
                                CHR_TIME_UPDATE_PEB = '$time'
                            WHERE CHR_IDPALLET = '$param' AND (CHR_DATE_DELIVERY BETWEEN '$start_date' AND '$end_date') AND CHR_PREPARE_STATUS = '1' AND INT_FLG_DEL = '0'");
            } else if($type == '2'){
                $this->db->query("UPDATE TT_PACKING_UPLOAD 
                            SET CHR_PEB_NO = '$peb_no', 
                                CHR_CONTAINER_NO = '$container_no', 
                                CHR_VESSEL_NO = '$vessel_no', 
                                CHR_DATE_DELIVERY_PEB = '$date_del',
                                CHR_USER_UPDATE_PEB = '$user',
                                CHR_DATE_UPDATE_PEB = '$date',
                                CHR_TIME_UPDATE_PEB = '$time' 
                            WHERE CHR_NOPO_CUST = '$param' AND (CHR_DATE_DELIVERY BETWEEN '$start_date' AND '$end_date') AND CHR_PREPARE_STATUS = '1' AND INT_FLG_DEL = '0'");
            } else if($type == '4'){
                $this->db->query("UPDATE TT_PACKING_UPLOAD 
                            SET CHR_PEB_NO = '$peb_no', 
                                CHR_CONTAINER_NO = '$container_no', 
                                CHR_VESSEL_NO = '$vessel_no', 
                                CHR_DATE_DELIVERY_PEB = '$date_del',
                                CHR_USER_UPDATE_PEB = '$user',
                                CHR_DATE_UPDATE_PEB = '$date',
                                CHR_TIME_UPDATE_PEB = '$time' 
                            WHERE CHR_INVOICE_NO = '$param' AND (CHR_DATE_DELIVERY BETWEEN '$start_date' AND '$end_date') AND CHR_PREPARE_STATUS = '1' AND INT_FLG_DEL = '0'");
            } else if($type == '5'){
                $this->db->query("UPDATE TT_PACKING_UPLOAD 
                            SET CHR_PEB_NO = '$peb_no', 
                                CHR_CONTAINER_NO = '$container_no', 
                                CHR_VESSEL_NO = '$vessel_no', 
                                CHR_DATE_DELIVERY_PEB = '$date_del',
                                CHR_USER_UPDATE_PEB = '$user',
                                CHR_DATE_UPDATE_PEB = '$date',
                                CHR_TIME_UPDATE_PEB = '$time' 
                            WHERE CHR_CONTAINER_NO = '$param' AND (CHR_DATE_DELIVERY BETWEEN '$start_date' AND '$end_date') AND CHR_PREPARE_STATUS = '1' AND INT_FLG_DEL = '0'");
            }
            
        }

        $seq_id = $this->notification_m->generate_id();

        $data_notif = array(
            'INT_ID_NOTIF' => $seq_id,
            'CHR_NPK' => '9172',
            'INT_ID_APP' => '26',
            'INT_ID_MODULE' => '74',
            'INT_ID_FUNCTION' => '352',
            'CHR_NOTIF_TITLE' => 'Update Container ' . $container_no,
            'CHR_NOTIF_DESC' => 'Container Data ' . $container_no,
            'CHR_LINK' => "delivery/export_c/manage_invoice_peb/" . $start_date . "/" . $end_date,
            'CHR_CREATED_BY' => 'System',
            'CHR_CREATED_DATE' => date('Ymd'),
            'CHR_CREATED_TIME' => date('His')
        );
        $this->notification_m->insert_notification($data_notif);

        echo json_encode("OK");         
    }

    function update_data_peb_batch_with_email(){
        $session = $this->session->all_userdata();
        $user = $session['USERNAME'];
        $date = date("Ymd");
        $time = date("His");

        $start_date = $this->input->post("date_start");
        $start_date = substr($start_date,6,4) . substr($start_date,3,2) . substr($start_date,0,2);
        $end_date = $this->input->post("date_end");
        $end_date = substr($end_date,6,4) . substr($end_date,3,2) . substr($end_date,0,2);
        
        $type = trim($this->input->post("type"));
        $peb_no = trim($this->input->post("peb_id"));
        // $peb_no = preg_replace('/\s/','',$peb_no);
        $container_no = trim($this->input->post("container_id"));
        $vessel_no = trim($this->input->post("vessel_id"));
        $date_del = trim($this->input->post("del_peb"));
        $date_del = substr($date_del,6,4) . substr($date_del,3,2) . substr($date_del,0,2);
        
        $list_param = trim($this->input->post("data_param"));
        $data_param =  explode("," , $list_param);

        for($i = 0; $i < count($data_param); $i++){
            $param = trim($data_param[$i]) ;

            if($type == '1'){
                $this->db->query("UPDATE TT_PACKING_UPLOAD 
                            SET CHR_PEB_NO = '$peb_no', 
                                CHR_CONTAINER_NO = '$container_no', 
                                CHR_VESSEL_NO = '$vessel_no', 
                                CHR_DATE_DELIVERY_PEB = '$date_del',
                                CHR_USER_UPDATE_PEB = '$user',
                                CHR_DATE_UPDATE_PEB = '$date',
                                CHR_TIME_UPDATE_PEB = '$time'
                            WHERE CHR_IDPALLET = '$param' AND (CHR_DATE_DELIVERY BETWEEN '$start_date' AND '$end_date') AND CHR_PREPARE_STATUS = '1' AND INT_FLG_DEL = '0'");
            } else if($type == '2'){
                $this->db->query("UPDATE TT_PACKING_UPLOAD 
                            SET CHR_PEB_NO = '$peb_no', 
                                CHR_CONTAINER_NO = '$container_no', 
                                CHR_VESSEL_NO = '$vessel_no', 
                                CHR_DATE_DELIVERY_PEB = '$date_del',
                                CHR_USER_UPDATE_PEB = '$user',
                                CHR_DATE_UPDATE_PEB = '$date',
                                CHR_TIME_UPDATE_PEB = '$time' 
                            WHERE CHR_NOPO_CUST = '$param' AND (CHR_DATE_DELIVERY BETWEEN '$start_date' AND '$end_date') AND CHR_PREPARE_STATUS = '1' AND INT_FLG_DEL = '0'");
            
                //===== SAVE & EMAIL EXCEL & TSV =====//
                $get_updated_data = $this->picking_list_m->get_updated_data_by_po($param);
                $country = $get_updated_data->CHR_COUNTRY;
                $po_name = substr($param, 0, 3);
                if($po_name == 'HVD' && $country == 'USA'){
                    //===== 1. GENERATE EXCEL FORMAT =====//
                    $row = 2;
                    
                    $this->load->library('excel');

                    // Create new PHPExcel object
                    $objPHPExcel = new PHPExcel();

                    $active_sheet =  $objPHPExcel->setActiveSheetIndex(0);
                    $active_sheet->setCellValue("A1", "NO");
                    $active_sheet->setCellValue("B1", "QR CODE PRODUCT");
                    $active_sheet->setCellValue("C1", "SERIAL NO");
                    $active_sheet->setCellValue("D1", "YEAR");
                    $active_sheet->setCellValue("E1", "MONTH");
                    $active_sheet->setCellValue("F1", "DAY");
                    $active_sheet->setCellValue("G1", "HOUR");
                    $active_sheet->setCellValue("H1", "MINUTE");
                    $active_sheet->setCellValue("I1", "SECOND");
                    $active_sheet->setCellValue("J1", "MASTER NO");
                    $active_sheet->setCellValue("K1", "FLAG SCAN");
                    $active_sheet->setCellValue("L1", "KANBAN NO");
                    $active_sheet->setCellValue("M1", "SCAN DATE");
                    $active_sheet->setCellValue("N1", "SCAN TIME");
                    $active_sheet->setCellValue("O1", "ID PALLET");
                    $active_sheet->setCellValue("P1", "PART NO CUST");
                    $active_sheet->setCellValue("Q1", "AISIN P/N");
                    $active_sheet->setCellValue("R1", "PULLING DATE");
                    $active_sheet->setCellValue("S1", "PULLING TIME");
                    $active_sheet->setCellValue("T1", "PO NO");
                    $active_sheet->setCellValue("U1", "DELIVERY DATE");
                    $active_sheet->setCellValue("V1", "CONTAINER NO");

                    $date_peb = '';
                    $no = 1;
                    $trace_data = $this->picking_list_m->get_trace_data_by_cont($container_no); 
                        
                    foreach ($trace_data as $tr) {

                        $active_sheet->setCellValue("A$row", $no);
                        $active_sheet->setCellValue("B$row", $tr->CHR_QR_PART);

                        $partno_hyp = substr(trim($tr->CHR_PARTNO),0,6) . '-' . substr(trim($tr->CHR_PARTNO),6,5);
                        $serial_no = substr($tr->CHR_QR_PART,12,8);

                        // $qrcode_hyp = substr($tr->CHR_QR_PART,0,38) . $partno_hyp . substr($tr->CHR_QR_PART,50);
                        $active_sheet->setCellValue("C$row", $serial_no);

                        $active_sheet->setCellValue("D$row", $tr->CHR_YEAR);
                        $active_sheet->setCellValue("E$row", $tr->CHR_MONTH);
                        $active_sheet->setCellValue("F$row", $tr->CHR_DAY);
                        $active_sheet->setCellValue("G$row", $tr->CHR_HOUR);
                        $active_sheet->setCellValue("H$row", $tr->CHR_MINUTE);
                        $active_sheet->setCellValue("I$row", $tr->CHR_SECOND);
                        $active_sheet->setCellValue("J$row", $tr->CHR_MASTER_NO);
                        $active_sheet->setCellValue("K$row", $tr->INT_FLG_SCAN);
                        $active_sheet->setCellValue("L$row", trim($tr->CHR_KANBAN_NO));
                        $active_sheet->setCellValue("M$row", $tr->CHR_MODIFIED_DATE);
                        $active_sheet->getStyle("N$row")->getNumberFormat()->setFormatCode('000000');
                        $active_sheet->setCellValue("N$row", $tr->CHR_MODIFIED_TIME);
                        $active_sheet->setCellValue("O$row", trim($tr->CHR_IDPALLET));                    
                        $active_sheet->setCellValue("P$row", trim($tr->CHR_PARTNO_CUST));
                        $active_sheet->setCellValue("Q$row", trim($partno_hyp));
                        $active_sheet->setCellValue("R$row", $tr->CHR_DATE_SCAN);
                        $active_sheet->getStyle("S$row")->getNumberFormat()->setFormatCode('000000');
                        $active_sheet->setCellValue("S$row", $tr->CHR_TIME_SCAN);
                        $active_sheet->setCellValue("T$row", trim($tr->CHR_NOPO_SAP));
                        $active_sheet->setCellValue("U$row", $tr->CHR_DATE_DELIVERY_ACT);
                        $active_sheet->setCellValue("V$row", trim($tr->CHR_CONTAINER_NO));
                            
                        $date_peb = $tr->CHR_DATE_DELIVERY_PEB;
                        $no++;
                        $row++;
                            
                    }

                    $filename = "Traceability " . $container_no . " (" . $date_peb . ").xls";
                    // ob_end_clean();
                    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
                    // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                    // header('Content-Disposition: attachment; filename="' . trim($filename) . '"');
                    // header('Cache-Control: max-age=0');
                    $objWriter->save(getcwd() . '/assets/Document/mailAttachment/' . trim($filename));

                    //===== 2. GENERATE & SAVE TSV FORMAT =====//
                    $csv = '';
                    $csv .= 'NO';
                    $csv .= "\t";
                    $csv .= 'QR CODE PRODUCT';
                    $csv .= "\t";
                    $csv .= 'SERIAL NO';
                    $csv .= "\t";
                    $csv .= 'YEAR';
                    $csv .= "\t";
                    $csv .= 'MONTH';
                    $csv .= "\t";
                    $csv .= 'DAY';
                    $csv .= "\t";
                    $csv .= 'HOUR';
                    $csv .= "\t";
                    $csv .= 'MINUTE';
                    $csv .= "\t";
                    $csv .= 'SECOND';
                    $csv .= "\t";
                    $csv .= 'MASTER NO';
                    $csv .= "\t";
                    $csv .= 'FLAG SCAN';
                    $csv .= "\t";
                    $csv .= 'KANBAN NO';
                    $csv .= "\t";
                    $csv .= 'SCAN DATE';
                    $csv .= "\t";
                    $csv .= 'SCAN TIME';
                    $csv .= "\t";
                    $csv .= 'ID PALLET';
                    $csv .= "\t";
                    $csv .= 'PART NO CUST';
                    $csv .= "\t";
                    $csv .= 'AISIN P/N';
                    $csv .= "\t";
                    $csv .= 'PULLING DATE';
                    $csv .= "\t";
                    $csv .= 'PULLING TIME';
                    $csv .= "\t";
                    $csv .= 'PO NO';
                    $csv .= "\t";
                    $csv .= 'DELIVERY DATE';
                    $csv .= "\t";
                    $csv .= 'CONTAINER NO';
                    $csv .= "\t";

                    $csv .= "\n";

                    $no = 1;
                    $date_peb = '';
                    $trace_data = $this->picking_list_m->get_trace_data_by_cont($container_no); 
                        
                    foreach ($trace_data as $tr) {

                        $csv .= $no;
                        $csv .= "\t";
                        $csv .= $tr->CHR_QR_PART;
                        $csv .= "\t";

                        $partno_hyp = substr(trim($tr->CHR_PARTNO),0,6) . '-' . substr(trim($tr->CHR_PARTNO),6,5);
                        $serial_no = substr($tr->CHR_QR_PART,12,8);

                        $csv .= $serial_no;
                        $csv .= "\t";
                        $csv .= $tr->CHR_YEAR;
                        $csv .= "\t";
                        $csv .= $tr->CHR_MONTH;
                        $csv .= "\t";
                        $csv .= $tr->CHR_DAY;
                        $csv .= "\t";
                        $csv .= $tr->CHR_HOUR;
                        $csv .= "\t";
                        $csv .= $tr->CHR_MINUTE;
                        $csv .= "\t";
                        $csv .= $tr->CHR_SECOND;
                        $csv .= "\t";
                        $csv .= $tr->CHR_MASTER_NO;
                        $csv .= "\t";
                        $csv .= $tr->INT_FLG_SCAN;
                        $csv .= "\t";
                        $csv .= trim($tr->CHR_KANBAN_NO);
                        $csv .= "\t";
                        $csv .= $tr->CHR_MODIFIED_DATE;
                        $csv .= "\t";
                        $csv .= $tr->CHR_MODIFIED_TIME;
                        $csv .= "\t";
                        $csv .= trim($tr->CHR_IDPALLET);
                        $csv .= "\t";
                        $csv .= trim($tr->CHR_PARTNO_CUST);
                        $csv .= "\t";
                        $csv .= trim($partno_hyp);
                        $csv .= "\t";
                        $csv .= $tr->CHR_DATE_SCAN;
                        $csv .= "\t";
                        $csv .= $tr->CHR_TIME_SCAN;
                        $csv .= "\t";
                        $csv .= trim($tr->CHR_NOPO_SAP);
                        $csv .= "\t";
                        $csv .= $tr->CHR_DATE_DELIVERY_ACT;
                        $csv .= "\t";
                        $csv .= trim($tr->CHR_CONTAINER_NO);
                        $csv .= "\t";

                        $csv .= "\n";

                        $date_peb = $tr->CHR_DATE_DELIVERY_PEB;
                        $no++;
                            
                    }

                    
                    $filename_tsv = "Traceability " . $container_no . " (" . $date_peb . ").tsv";

                    $fp = fopen(getcwd() . '/assets/Document/mailAttachment/' . $filename_tsv, 'w');
                    
                    fwrite($fp,$csv);
                    fclose($fp);

                    //===== 3. SENDING EMAIL =====//
                    $this->load->library('email');
                    $this->email->from('it@aisin-indonesia.co.id', 'AIS System');
                    // $this->email->to('aditya.np@aisin-indonesia.co.id, yunia.milatina@aisin-indonesia.co.id');
                    // $this->email->cc('senastio.andri@aisin-indonesia.co.id, fauzan.hilman@aisin-indonesia.co.id');
                    $this->email->to('rossi@aisin-indonesia.co.id, edwin.susilo@aisin-indonesia.co.id');
                    $this->email->cc('shuutaro.omata@aisin-indonesia.co.id, arief.widodo@aisin-indonesia.co.id, herizal@aisin-indonesia.co.id, aditya.np@aisin-indonesia.co.id');
                    $this->email->subject('Traceability '. trim($container_no) . ' (' . $date_peb . ')');
                    $msg_email = 'Dear Rossi-san & Edwin-san,';
                    $msg_email .= '<br>';
                    $msg_email .= '<br>';
                    $msg_email .= 'Attached latest update of AWA traceability file (.xls & .tsv) for: ';
                    $msg_email .= '<br>';
                    $msg_email .= '&nbsp; PO: <strong><i>' . trim($param) . '</i></strong>';
                    $msg_email .= '<br>';
                    $msg_email .= '&nbsp; Container: <strong><i>' . trim($container_no) . '</i></strong>';
                    $msg_email .= '<br>';
                    $msg_email .= '<br>';
                    $msg_email .= 'Please check items below before sending it (only .tsv file) to AWA:';
                    $msg_email .= '<br>';
                    $msg_email .= '1. No blank column of QR tester';
                    $msg_email .= '<br>';
                    $msg_email .= '2. Total row data same with actual delivery qty';
                    $msg_email .= '<br>';
                    $msg_email .= '3. No duplicate value of QR tester & serial Kanban';
                    $msg_email .= '<br>';
                    $msg_email .= '<br>';
                    $msg_email .= '<strong><i style="color:red;">Note</i></strong>: You can also view traceability data via AIS portal -> Delivery -> Export -> Manage Invoice & PEB';
                    $msg_email .= '<br>';
                    $msg_email .= '<br>';
                    $msg_email .= 'Thank You';
                    $msg_email .= '<br>';
                    $msg_email .= '<br>';
                    $msg_email .= 'Best Regards,';
                    $msg_email .= '<br>';
                    $msg_email .= 'AIS System';
                    $this->email->message($msg_email);
                    $this->email->attach(DOCROOT . '/assets/Document/mailAttachment/' . $filename);
                    $this->email->attach(DOCROOT . '/assets/Document/mailAttachment/' . $filename_tsv);
                    $return = $this->email->send();
                    
                    // if ($return) {
                    //     echo 'email sending success';
                    // } else {
                    //     print_r($this->email->print_debugger());
                    // }
                }
                //===== SAVE & EMAIL EXCEL & TSV =====//

            } else if($type == '4'){
                $this->db->query("UPDATE TT_PACKING_UPLOAD 
                            SET CHR_PEB_NO = '$peb_no', 
                                CHR_CONTAINER_NO = '$container_no', 
                                CHR_VESSEL_NO = '$vessel_no', 
                                CHR_DATE_DELIVERY_PEB = '$date_del',
                                CHR_USER_UPDATE_PEB = '$user',
                                CHR_DATE_UPDATE_PEB = '$date',
                                CHR_TIME_UPDATE_PEB = '$time' 
                            WHERE CHR_INVOICE_NO = '$param' AND (CHR_DATE_DELIVERY BETWEEN '$start_date' AND '$end_date') AND CHR_PREPARE_STATUS = '1' AND INT_FLG_DEL = '0'");
            } else if($type == '5'){
                $this->db->query("UPDATE TT_PACKING_UPLOAD 
                            SET CHR_PEB_NO = '$peb_no', 
                                CHR_CONTAINER_NO = '$container_no', 
                                CHR_VESSEL_NO = '$vessel_no', 
                                CHR_DATE_DELIVERY_PEB = '$date_del',
                                CHR_USER_UPDATE_PEB = '$user',
                                CHR_DATE_UPDATE_PEB = '$date',
                                CHR_TIME_UPDATE_PEB = '$time' 
                            WHERE CHR_CONTAINER_NO = '$param' AND (CHR_DATE_DELIVERY BETWEEN '$start_date' AND '$end_date') AND CHR_PREPARE_STATUS = '1' AND INT_FLG_DEL = '0'");
            }
            
        }

        $seq_id = $this->notification_m->generate_id();

        $data_notif = array(
            'INT_ID_NOTIF' => $seq_id,
            'CHR_NPK' => '9172',
            'INT_ID_APP' => '26',
            'INT_ID_MODULE' => '74',
            'INT_ID_FUNCTION' => '352',
            'CHR_NOTIF_TITLE' => 'Update Container ' . $container_no,
            'CHR_NOTIF_DESC' => 'Container Data ' . $container_no,
            'CHR_LINK' => "delivery/export_c/manage_invoice_peb/" . $start_date . "/" . $end_date,
            'CHR_CREATED_BY' => 'System',
            'CHR_CREATED_DATE' => date('Ymd'),
            'CHR_CREATED_TIME' => date('His')
        );
        $this->notification_m->insert_notification($data_notif);

        echo json_encode("OK");         
    }

    function report_movement_wh($start_date = NULL, $end_date = NULL) {
        $session = $this->session->all_userdata();

        if ($start_date == NULL || $start_date == '') {
            $start_date = date('Ym') . '01';
        }

        if ($end_date == NULL || $end_date == '') {
            $end_date = date('Ymd');
        }

        $data['start_date'] = $start_date;  
        $data['end_date'] = $end_date;  
        
        $data_pallet = $this->picking_list_m->get_history_movement_by_date($start_date, $end_date);
        
        $data['title'] = 'Report Movement WH';
        $data['content'] = 'delivery/report_movement_wh_v';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(353);
        $data['news'] = $this->news_m->get_news();
        $data['data'] = $data_pallet;        
        
        $this->load->view($this->layout, $data);
    }

    function search_report_movement_wh() {
        $session = $this->session->all_userdata();

        $start_date = $this->input->post("date_from");
        $start_date = substr($start_date,6,4) . substr($start_date,3,2) . substr($start_date,0,2);
        $end_date = $this->input->post("date_to");
        $end_date = substr($end_date,6,4) . substr($end_date,3,2) . substr($end_date,0,2);

        $data['start_date'] = $start_date;  
        $data['end_date'] = $end_date;  
        
        $data_pallet = $this->picking_list_m->get_history_movement_by_date($start_date, $end_date);
        
        $data['title'] = 'Report Movement WH';
        $data['content'] = 'delivery/report_movement_wh_v';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(353);
        $data['news'] = $this->news_m->get_news();
        $data['data'] = $data_pallet;        
        
        $this->load->view($this->layout, $data);
    }

    //==== ON HOLD - Dev by ANU ====//
    function migrasi_pallet_data($start_date = NULL, $end_date = NULL) {
        $session = $this->session->all_userdata();

        if ($start_date == NULL || $start_date == '') {
            $start_date = date('Ym') . '01';
        }

        if ($end_date == NULL || $end_date == '') {
            $end_date = date('Ymd');
        }

        $start_date = $this->input->post("date_from");
        $start_date = substr($start_date,6,4) . substr($start_date,3,2) . substr($start_date,0,2);
        $end_date = $this->input->post("date_to");
        $end_date = substr($end_date,6,4) . substr($end_date,3,2) . substr($end_date,0,2);

        $data['start_date'] = $start_date;  
        $data['end_date'] = $end_date;  
        
        $data_pallet = $this->picking_list_m->get_outstd_migrasi_pallet();
        
        $data['title'] = 'Migrasi Pallet Data';
        $data['content'] = 'delivery/migrasi_pallet_data_v';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(353);
        $data['news'] = $this->news_m->get_news();
        $data['data'] = $data_pallet;        
        
        $this->load->view($this->layout, $data);
    }

    function get_detail_pallet(){        
        $pall_from = $this->input->post("pallet_from");
        $pall_to = $this->input->post("pallet_to");
        
        $get_data = $this->picking_list_m->get_detail_pallet_data($pall_from, $pall_to);
        
        $json_response = array('MON01' => number_format($get_data->PBLN01,2,',','.'),
                               'MON02' => number_format($get_data->PBLN02,2,',','.'),
                               'MON03' => number_format($get_data->PBLN03,2,',','.'),
                               'MON04' => number_format($get_data->PBLN04,2,',','.'),
                               'MON05' => number_format($get_data->PBLN05,2,',','.'),
                               'MON06' => number_format($get_data->PBLN06,2,',','.'),
                               'MON07' => number_format($get_data->PBLN07,2,',','.'),
                               'MON08' => number_format($get_data->PBLN08,2,',','.'),
                               'MON09' => number_format($get_data->PBLN09,2,',','.'),
                               'MON10' => number_format($get_data->PBLN10,2,',','.'),
                               'MON11' => number_format($get_data->PBLN11,2,',','.'),
                               'MON12' => number_format($get_data->PBLN12,2,',','.'),
                               'MON13' => number_format($get_data->PBLN13,2,',','.'),
                               'MON14' => number_format($get_data->PBLN14,2,',','.'),
                               'MON15' => number_format($get_data->PBLN15,2,',','.')
                                );    

        echo json_encode($json_response);
    }
    //==== End ON HOLD - Dev by ANU ====//

    public function manage_po_family($date_from = "", $date_to = "")
    { 
        $this->role_module_m->authorization('30');
        $date_now = date("Ymd");
        $time_now = date("Ymd");
        $session = $this->session->all_userdata();
        $role = $session['ROLE'];

        $data['content'] = 'delivery/manage_po_family_v';
        $data['title'] = 'Manage PO Family';
        
        if ($this->input->post("btn-filter") == 1) {
            $date_from = $this->input->post("date_from");
            $date_to = $this->input->post("date_to");
            $date_from = date("Ymd", strtotime($date_from));
            $date_to = date("Ymd", strtotime($date_to));
            redirect("delivery/export_c/manage_po_family/$date_from/$date_to", "refresh");
        }

        if ($date_from == "") {
            $date_from = date("Ym") . '01';
        }

        if ($date_to == "") {
            $date_to = date("Ym") . '30';
        }
        $po_list = $this->picking_list_m->get_data_po_family_by_date($date_from, $date_to);
        if($po_list->num_rows() > 0){
            $data['po_list'] = $po_list->result();
        } else {
            $data['po_list'] = NULL;
        }
        
        $data['date_from'] = $date_from;
        $data['date_to'] = $date_to;

        $data['role'] = $role;
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(359);
        $data['news'] = $this->news_m->get_news();

        $this->load->view($this->layout, $data);
    }

    public function update_container_cap()
    { 
        $session = $this->session->all_userdata();
        $user = $session['USERNAME'];
        $date = date("Ymd");
        $time = date("His");

        $no_po = $this->input->post("no_po");
        $date_from = $this->input->post("date_1");
        $date_to = $this->input->post("date_2");

        $abj = 'A';
        for($i=1; $i<=26; $i++){
            $qty = $this->input->post("cont_" . $no_po . "_" . $abj);
            $date_del = $this->input->post("date_" . $no_po . "_" . $abj);
            $check_cont = $this->db->query("SELECT * FROM TT_CONTAINER_SIZE 
                                        WHERE CHR_NOPO_FAMILY = '$no_po' 
                                            AND CHR_CONTAINER_CODE = '$abj'");
            if($check_cont->num_rows() > 0){
                if($qty > 0){
                    $this->db->query("UPDATE TT_CONTAINER_SIZE 
                                        SET INT_QTY_CONTAINER_MAX = '$qty', 
                                            CHR_DELIVERY_DATE = '$date_del', 
                                            INT_FLG_DEL = '0',
                                            CHR_UPDATED_BY = '$user',
                                            CHR_UPDATED_DATE = '$date',
                                            CHR_UPDATED_TIME = '$time'
                                        WHERE CHR_NOPO_FAMILY = '$no_po' 
                                            AND CHR_CONTAINER_CODE = '$abj'");
                } else {
                    $this->db->query("UPDATE TT_CONTAINER_SIZE 
                                        SET INT_QTY_CONTAINER_MAX = '$qty', 
                                            CHR_DELIVERY_DATE = '$date_del', 
                                            INT_FLG_DEL = '1',
                                            CHR_UPDATED_BY = '$user',
                                            CHR_UPDATED_DATE = '$date',
                                            CHR_UPDATED_TIME = '$time'
                                        WHERE CHR_NOPO_FAMILY = '$no_po' 
                                            AND CHR_CONTAINER_CODE = '$abj'");
                }
            } else {
                if($qty > 0){
                    $this->db->query("INSERT INTO TT_CONTAINER_SIZE 
                                        (CHR_NOPO_FAMILY, CHR_CONTAINER_CODE, INT_QTY_CONTAINER_MAX, CHR_DELIVERY_DATE, CHR_CREATED_BY, CHR_CREATED_DATE, CHR_CREATED_TIME) 
                                        VALUES ('$no_po', '$abj', '$qty', '$date_del', '$user', '$date', '$time')");
                }                
            }
            $abj = ++$abj;
        }  
        
        redirect('delivery/export_c/manage_po_family/' . $date_from . '/' . $date_to, 'refresh');
    }

    public function print_barcode_po_family($po)
    {

        $po_data = $this->db->query("SELECT * FROM TT_PO_FAMILY_UPLOAD WHERE CHR_NOPO_FAMILY = '$po'")->result();
        $cust_name = $po_data[0]->CHR_CUST_NAME_ALIAS;
        $country = $po_data[0]->CHR_COUNTRY;
        $delivery_date = $po_data[0]->CHR_DATE_DELIVERY;

        $data['range'] = $this->db->query("SELECT DISTINCT CHR_NOPO_FAMILY FROM TT_PO_FAMILY_UPLOAD WHERE CHR_NOPO_FAMILY = '$po'")->num_rows();
        $data['po'] = $po;
        $data['po_data'] = $po_data;
        $data['delivery_date'] = $delivery_date;

        if(strlen($country) < 20){
            $text_country = 16;
        }else{
            $text_country = 12;
        }

        if(strlen($cust_name) < 10){
            $text_size = 25;
        }else if(strlen($cust_name) >= 10 && strlen($cust_name) <= 20){
            $text_size = 16;
        }else if(strlen($cust_name) > 20){
            $array_cust = explode(" ",$cust_name);
            $new_cust = '';
            for($x = 0; $x < count($array_cust); $x++){
                if($x == 3){
                    $new_cust = $new_cust. '<br>' .$array_cust[$x];
                }else{
                    $new_cust = $new_cust. ' ' .$array_cust[$x];
                }
            }
            $cust_name = $new_cust;
            $text_size = 13;
        }

        $data['country'] = $country;
        $data['text_country'] = $text_country;
        $data['cust_name'] = $cust_name;
        $data['text_size'] = $text_size;

        $this->load->view('delivery/print_kanban_po_family', $data);
    }

    function view_progress_po() {
        $po = $this->input->post("po_no");

        $get_data = $this->picking_list_m->get_po_family($po);
        $get_po_cust = $this->picking_list_m->get_po_cust_by_po_fam($po);
        $data = '';        
        
        $data .= '              <table id="dataTables4" class="table table-condensed table-striped table-hover display" cellspacing="0" width="100%">';
        $data .= '                  <thead>';
        $data .= '                      <tr>';
        $data .= '                          <th rowspan="2" style="text-align:center;">No</th>';
        $data .= '                          <th rowspan="2" style="text-align:center;">Part No</th>';
        $data .= '                          <th rowspan="2" style="text-align:center;">Back No</th>';
        $tot_po =  $get_po_cust->num_rows();
        foreach($get_po_cust->result() as $dat){
            $data .= '                      <th colspan="3" style="text-align:center;">' . $dat->CHR_NOPO_CUST . '</th>';
        }                                  
        
        $data .= '                          <th rowspan="2" style="text-align:center;">Qty Plan (A)</th>';
        $data .= '                          <th rowspan="2" style="text-align:center;">Qty Act (B)</th>';
        $data .= '                          <th rowspan="2" style="text-align:center;">Qty Prod (C)</th>';
        $data .= '                          <th rowspan="2" style="text-align:center;">Diff (B-A)</th>';
        $data .= '                          <th rowspan="2" style="text-align:center;">(%)</th>';
        $data .= '                          <th rowspan="2" style="text-align:center;">Status</th>';
        $data .= '                      </tr>';
        $data .= '                      <tr>';         
        for($i = 1; $i <= $tot_po; $i++){
            $data .= '                      <th style="text-align:center;">Plan</th>';
            $data .= '                      <th style="text-align:center;">Act</th>';
            $data .= '                      <th style="text-align:center;">Diff</th>';
        }   
        
        $data .= '                      </tr>';
        $data .= '                  </thead>';
        $data .= '                  <tbody>';
        
        $no = 1;
        $qty_prd_tot = 0;
        foreach ($get_data as $val) {
            $data .= '  <tr align="center">';
            $data .= '      <td>' . $no . '</td>';
            $data .= '      <td>' . $val->CHR_PART_NO . '</td>';
            $data .= '      <td>' . $val->CHR_BACK_NO . '</td>';
            
            $qty = 0;
            $qty_prep = 0;
            foreach($get_po_cust->result() as $res){
                $get_qty = $this->picking_list_m->get_qty_po_cust($po, $res->CHR_NOPO_CUST, $val->CHR_PART_NO);                
                if($get_qty->num_rows() <= 0){
                    $data .= '  <td>0</td>';
                    $data .= '  <td style="text-align:center;color:blue;">0</td>';
                    $data .= '  <td style="text-align:center;">0</td>';
                } else {
                    $po_qty = $get_qty->row();
                    $diff = $po_qty->INT_QTY_PREPARE - $po_qty->INT_QTY;
                    $style_diff = '';
                    if($diff != 0){
                        $style_diff = 'color:red;';
                    } else {
                        $style_diff = 'color:green;';
                    }
                    $data .= '  <td>' . $po_qty->INT_QTY . '</td>';
                    $data .= '  <td style="text-align:center;color:blue;">' . $po_qty->INT_QTY_PREPARE . '</td>';
                    $data .= '  <td style="text-align:center;' . $style_diff . '">' . $diff . '</td>';
                    $qty = $qty + $po_qty->INT_QTY;
                    $qty_prep = $qty_prep + $po_qty->INT_QTY_PREPARE;
                }                
            } 
            
            $qty_remain = $qty_prep - $qty;
            $percent = ($qty_prep / $qty) * 100;
            $stat = '';
            $style = '';
            if($percent <= 0){
                $stat = '<img src="' . base_url() . "/assets/img/error1.png" . '" width="25">';
                $style = 'color:red;';
            } else if($percent > 0 && $percent < 100){
                $stat = '<img src="' . base_url() . "/assets/img/onprogress.png" . '" width="25">';
                $style = 'color:red;';
            } else {
                $stat = '<img src="' . base_url() . "/assets/img/check1.png" . '" width="25">';
                $style = 'color:green;';
            }

            $period = '20' . substr($po, 2, 4);
            $qty_prd = 0;
            $get_prd_result = $this->picking_list_m->get_prod_result($period, $val->CHR_PART_NO);
            if($get_prd_result->num_rows() > 0){
                $prd_result = $get_prd_result->row();
                $qty_prd = $prd_result->INT_PROD;
                $qty_prd_tot = $qty_prd_tot + $qty_prd;
            }

            $data .= '      <td align="center"><strong>' . $qty . '</strong></td>';
            $data .= '      <td style="text-align:center;color:blue;"><strong>' . $qty_prep . '</strong></td>';
            $data .= '      <td style="text-align:center;color:grey;"><strong>' . $qty_prd . '</strong></td>';
            $data .= '      <td style="text-align:center;' . $style . '"><strong>' . $qty_remain . '</strong></td>';
            $data .= '      <td align="center"><strong>' . number_format($percent,1,',','.') . '%</strong></td>';
            $data .= '      <td align="center">' . $stat . '</td>';
            $data .= '  </tr>';
            $no++;
        }

        $data .= '      <tr>';
        $data .= '          <td colspan="3" style="text-align:right;"><strong>Total</strong></td>';
        $qty_plan_tot = 0;
        $qty_act_tot = 0;
        $remain_po = 0;        
        foreach($get_po_cust->result() as $dat){
            $remain_po = $dat->INT_QTY_PREPARE - $dat->INT_QTY;
            $style_po = '';
            if($remain_po != 0){
                $style_po = 'color:red;';
            } else {
                $style_po = 'color:green;';
            }
            $data .= '      <td style="text-align:center;"><strong>' . $dat->INT_QTY . '</strong></td>';
            $data .= '      <td style="text-align:center;color:blue;"><strong>' . $dat->INT_QTY_PREPARE . '</strong></td>';
            $data .= '      <td style="text-align:center;' . $style_po . '"><strong>' . $remain_po . '</strong></td>';
            $qty_plan_tot = $qty_plan_tot + $dat->INT_QTY;
            $qty_act_tot = $qty_act_tot + $dat->INT_QTY_PREPARE;
        }

        $qty_remain_tot = $qty_act_tot - $qty_plan_tot;
        $percent_tot = ($qty_act_tot / $qty_plan_tot) * 100;
        $stat_tot = '';
        $style_tot = '';
        if($percent_tot <= 0){
            $stat_tot = '<img src="' . base_url() . "/assets/img/error1.png" . '" width="25">';
            $style_tot = 'color:red;';
        } else if($percent_tot > 0 && $percent_tot < 100){
            $stat_tot = '<img src="' . base_url() . "/assets/img/onprogress.png" . '" width="25">';
            $style_tot = 'color:red;';
        } else {
            $stat_tot = '<img src="' . base_url() . "/assets/img/check1.png" . '" width="25">';
            $style_tot = 'color:green;';
        }
        $data .= '          <td style="text-align:center;"><strong>' . $qty_plan_tot . '</strong></td>';
        $data .= '          <td style="text-align:center;color:blue;"><strong>' . $qty_act_tot . '</strong></td>';
        $data .= '          <td style="text-align:center;color:grey;"><strong>' . $qty_prd_tot . '</strong></td>';
        $data .= '          <td style="text-align:center;' . $style_tot .'"><strong>' . $qty_remain_tot . '</strong></td>';
        $data .= '          <td style="text-align:center;"><strong>' . number_format($percent_tot,1,',','.') . '%</strong></td>';
        $data .= '          <td style="text-align:center;">' . $stat_tot . '</td>';        
        $data .= '      </tr>';

        $data .= '      <tr>';
        $data .= '          <td colspan="3" style="text-align:right;"><strong>(%)</strong></td>';
        foreach($get_po_cust->result() as $dat){
            $data .= '      <td colspan="3" style="text-align:center;"><strong>' . number_format((($dat->INT_QTY_PREPARE / $dat->INT_QTY) * 100),1,',','.'). '%</strong></td>';
        }
        $data .= '          <td colspan="5" style="text-align:right;"></td>';
        $data .= '      </tr>';

        $data .= '      <tr>';
        $data .= '          <td colspan="3" style="text-align:right;"><strong>Status</strong></td>';
        foreach($get_po_cust->result() as $dat){
            $percent_po = (($dat->INT_QTY_PREPARE / $dat->INT_QTY) * 100);
            $stat_po = '';            
            if($percent_po <= 0){
                $stat_po = '<img src="' . base_url() . "/assets/img/error1.png" . '" width="25">';                
            } else if($percent_po > 0 && $percent_po < 100){
                $stat_po = '<img src="' . base_url() . "/assets/img/onprogress.png" . '" width="25">';
            } else {
                $stat_po = '<img src="' . base_url() . "/assets/img/check1.png" . '" width="25">';
            }
            $data .= '      <td colspan="3" style="text-align:center;">' . $stat_po . '</td>';
        }
        $data .= '          <td colspan="5" style="text-align:right;"></td>';
        $data .= '      </tr>';
        
        $data .= '                  </tbody>';
        $data .= '              </table>';
        $data .= '            </div>';

        $json_data = array('data_progress' => $data
        );

        echo json_encode($json_data);
    }

    function view_pallet_po() {
        $po = $this->input->post("nopo");

        $get_data = $this->picking_list_m->get_pallet_po_family($po);
        $data = '';    
        
        $data .= '              <table id="dataTables1" class="table table-condensed table-striped table-hover display" cellspacing="0" width="100%">';
        $data .= '                  <thead>';
        $data .= '                      <tr>';
        $data .= '                          <th rowspan="2" style="text-align:center;">No</th>';
        $data .= '                          <th colspan="10" style="text-align:center;">Palletizing Data</th>';
        $data .= '                          <th colspan="3" style="text-align:center;">Delivery Data</th>';
        $data .= '                      </tr>';
        $data .= '                      <tr>';        
        $data .= '                          <th style="text-align:center;">ID Pallet</th>';
        $data .= '                          <th style="text-align:center;">Container</th>';
        $data .= '                          <th style="text-align:center;">PO Cust</th>';
        $data .= '                          <th style="text-align:center;">WCenter</th>';
        $data .= '                          <th style="text-align:center;">Pallet Type</th>';
        $data .= '                          <th style="text-align:center;">Box Max</th>';
        $data .= '                          <th style="text-align:center;">Tot Part</th>';
        $data .= '                          <th style="text-align:center;">Qty Act</th>';
        $data .= '                          <th style="text-align:center;">Act Box</th>';
        $data .= '                          <th style="text-align:center;">Progress</th>';
        $data .= '                          <th style="text-align:center;">Print</th>';
        $data .= '                          <th style="text-align:center;">Pick List</th>';
        $data .= '                          <th style="text-align:center;">Del Date</th>';
        $data .= '                          <th style="text-align:center;">Stat</th>';        
        $data .= '                      </tr>';
        $data .= '                  </thead>';
        $data .= '                  <tbody>';

        $no = 1;
        foreach ($get_data as $val) {
            $data .= '  <tr align="center">';
            $data .= '      <td>' . $no . '</td>';
            $data .= '      <td><a data-placement="right" data-toggle="modal" title="View detail pallet" onclick="show_detail_pallet(\'' . trim($val->CHR_IDPALLET) . '\');"><strong>' . $val->CHR_IDPALLET . '</strong></a></td>';
            // $data .= '      <td style="font-size;11px;"><a data-placement="right" data-toggle="modal" title="View detail pallet" onclick="show_detail_production(\'' . trim($val->CHR_IDPALLET) . '\');"><strong>' . $val->CHR_IDPALLET . '</strong></a></td>';
            $data .= '      <td><strong>' . $val->CHR_ADD_CODE . '</strong> (' . $val->INT_NOPALLET . '/' . $val->INT_QTY_CONTAINER_MAX . ')' . '</td>';
            $data .= '      <td>' . $val->CHR_NOPO_CUST . '</td>';
            $data .= '      <td>' . $val->CHR_AREA . '</td>';
            $data .= '      <td>' . $val->CHR_PALLET_DESCRIPTION . '</td>';
            if($val->CHR_PREPARE_STATUS == '1'){
                $data .= '      <td>' . $val->INT_QTY_BOX . '</td>';
            } else {
                $data .= '      <td>' . $val->INT_QTY_BOX_MAX . '</td>';
            }
            
            $data .= '      <td>' . $val->TOT_PN . '</td>';
            $data .= '      <td>' . $val->INT_QTY_PREPARE . '</td>';
            $data .= '      <td>' . $val->INT_QTY_BOX . '</td>';

            $diff_box = $val->INT_QTY_BOX - $val->INT_QTY_BOX_MAX;
            if($val->CHR_PREPARE_STATUS == '1'){
                $perc = 100;
            } else {
                if($val->INT_QTY_BOX_MAX == NULL || $val->INT_QTY_BOX_MAX == 0){
                    $perc = 100;
                } else {
                    $perc = ($val->INT_QTY_BOX / $val->INT_QTY_BOX_MAX) * 100;
                }
            }            
            
            $style = '';
            if($val->CHR_PREPARE_STATUS == '1'){
                $style = 'background-color:green;color:white;';
            } else {
                if($perc <= 0){
                    $style = 'background-color:red;color:white;';
                } else if($perc > 0 && $perc < 100) {
                    $style .= 'background-color:yellow;color:black;';
                } else {
                    $style = 'background-color:green;color:white;';
                }
            }
            
            $data .= '  <td style="text-align:center;' . $style . '">' . number_format($perc,1,',','.') . ' %</td>';

            if($val->CHR_PRINT_STATUS == '0'){
                $data .= '  <td><img src="' . base_url() . "/assets/img/error1.png" . '" width="25"></td>';
            } else {
                $data .= '  <td><img src="' . base_url() . "/assets/img/check1.png" . '" width="25"></td>';
            }

            if($val->CHR_DEL_NO == NULL){
                $data .= '  <td>-</td>';
            } else {
                $data .= '  <td>' . $val->CHR_DEL_NO . '</td>';
            }

            if($val->CHR_GI_DEL == 'C'){
                $data .= '  <td>' . $val->CHR_DEL_DATE_ACT . '</td>';
                $data .= '  <td><img src="' . base_url() . "/assets/img/check1.png" . '" width="25"></td>';
            } else {
                $data .= '  <td>-</td>';
                $data .= '  <td><img src="' . base_url() . "/assets/img/error1.png" . '" width="25"></td>';
            }

            $data .= '  </tr>';
            $no++;
        }
        
        $data .= '                  </tbody>';
        $data .= '              </table>';
        $data .= '            </div>';

        $data .= '<script>';
        $data .= '$(document).ready(function() {';
        $data .= '    $("#dataTables1").DataTable({';
        $data .= '        scrollX: true,';
        $data .= '        lengthMenu: [';
        $data .= '            [5, 10, 25, 50, -1],';
        $data .= '            [5, 10, 25, 50, "All"]';
        $data .= '        ]';
        $data .= '        ,fixedColumns: {';
        $data .= '            leftColumns: 2,';
        $data .= '            rightColumns: 8';
        $data .= '        }';
        $data .= '    });';
        $data .= '});';
        $data .= '</script>';
        
        $json_data = array('data_pallet' => $data
        );

        echo json_encode($json_data);
    }

    function view_detail_pallet() {
        $pallet = $this->input->post("pallet_no");

        $get_data = $this->picking_list_m->get_detail_pallet($pallet);
        $data = '';    
        
        $data .= '            <div class="modal-wrapper">';
        $data .= '                <div class="modal-dialog">';
        $data .= '                    <div class="modal-content">';
        $data .= '                        <div class="modal-header">';
        $data .= '                            <button type="button" onclick="hide_detail_pallet()" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>';
        $data .= '                            <h4 class="modal-title" id="modalprogress"><strong>Pallet Details</strong> <a data-placement="right" data-toggle="modal" title="View detail pallet" onclick="show_detail_production(\'' . trim($pallet) . '\');"><strong>(Detail Prod)</strong></a></h4>';
        $data .= '                        </div>';
        $data .= '                       <div class="modal-body" id="view_detail_pallet">';

        $data .= '              <table id="example" class="table table-condensed table-striped table-hover display" cellspacing="0" width="100%">';
        $data .= '                  <thead>';
        $data .= '                      <tr>';
        $data .= '                          <th rowspan="2" style="text-align:center;">No</th>';
        $data .= '                          <th rowspan="2" style="text-align:center;">PO Cust</th>';
        $data .= '                          <th rowspan="2" style="text-align:center;">Part No</th>';
        $data .= '                          <th rowspan="2" style="text-align:center;">Back No</th>';
        $data .= '                          <th rowspan="2" style="text-align:center;">Part No Cust</th>';
        $data .= '                          <th rowspan="2" style="text-align:center;">Qty/Box</th>';
        $data .= '                          <th rowspan="2" style="text-align:center;">Qty Act</th>';
        $data .= '                          <th rowspan="2" style="text-align:center;">Act Box</th>';
        $data .= '                          <th rowspan="2" style="text-align:center;">Prod Detail</th>';
        $data .= '                      </tr>';
        $data .= '                  </thead>';
        $data .= '                  <tbody>';

        $no = 1;
        foreach ($get_data as $val) {
            $data .= '  <tr align="center">';
            $data .= '      <td>' . $no . '</td>';
            $data .= '      <td>' . $val->CHR_NOPO_CUST . '</a></td>';
            $data .= '      <td>' . $val->CHR_PART_NO . '</td>';
            $data .= '      <td>' . $val->CHR_BACK_NO . '</td>';
            $data .= '      <td>' . $val->CHR_PARTNO_CUST . '</td>';
            $data .= '      <td>' . $val->INT_QTY_PER_BOX . '</td>';
            $data .= '      <td>' . $val->INT_QTY_PREPARE . '</td>';
            $data .= '      <td>' . ($val->INT_QTY_PREPARE / $val->INT_QTY_PER_BOX) . '</td>';
            $data .= '      <td><a data-placement="right" data-toggle="modal" title="View detail pallet" onclick="show_detail_production_by_part(\'' . trim($val->CHR_IDPALLET) . ',' . trim($val->CHR_PART_NO) . '\');"><strong>View</strong></a></td>';
            $data .= '  </tr>';
            $no++;
        }
        
        $data .= '                  </tbody>';
        $data .= '              </table>';
        $data .= '           </div>';
        $data .= '         </div>';
        $data .= '       </div>';
        $data .= '    </div>';
        
        $json_data = array('data_pallet' => $data
        );

        echo json_encode($json_data);
    }

    function view_detail_production() {
        $pallet = $this->input->post("pallet_num");

        $get_data = $this->picking_list_m->get_detail_production($pallet);
        $data = '';    
        
        $data .= '            <div class="modal-wrapper">';
        $data .= '                <div class="modal-dialog">';
        $data .= '                    <div class="modal-content">';
        $data .= '                        <div class="modal-header">';
        $data .= '                            <button type="button" onclick="hide_detail_production()" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>';
        $data .= '                            <h4 class="modal-title" id="modalprogress"><strong>List Production Details</strong></h4>';
        $data .= '                        </div>';
        $data .= '                       <div class="modal-body" style="overflow-y: scroll;height: 350px;" id="view_detail_prod">';

        $data .= '              <table id="tables" class="table table-condensed table-striped table-hover display" cellspacing="0" width="100%">';
        $data .= '                  <thead>';
        $data .= '                      <tr>';
        $data .= '                          <th style="text-align:center;">No</th>';
        $data .= '                          <th style="text-align:center;">Serial Kanban</th>';
        $data .= '                          <th style="text-align:center;">Part No Cust</th>';
        $data .= '                          <th style="text-align:center;">Back No</th>';
        $data .= '                          <th style="text-align:center;">Date Scan</th>';
        $data .= '                          <th style="text-align:center;">Time Scan</th>';
        $data .= '                          <th style="text-align:center;">Date Prod</th>';
        $data .= '                          <th style="text-align:center;">Time Prod</th>';
        $data .= '                      </tr>';
        $data .= '                  </thead>';
        $data .= '                  <tbody>';

        $no = 1;
        foreach ($get_data as $val) {
            $data .= '  <tr align="center">';
            $data .= '      <td>' . $no . '</td>';
            $data .= '      <td>' . $val->CHR_KANBAN_NO . '</a></td>';
            $data .= '      <td>' . $val->CHR_PARTNO_CUST . '</td>';
            $data .= '      <td>' . $val->CHR_BACK_NO . '</td>';
            $data .= '      <td>' . $val->CHR_DATE_SCAN . '</td>';
            $data .= '      <td>' . $val->CHR_TIME_SCAN . '</td>';
            $data .= '      <td>' . $val->CHR_INLINE_DATE . '</td>';
            $data .= '      <td>' . $val->CHR_INLINE_DATE . '</td>';
            $data .= '  </tr>';
            $no++;
        }
        
        $data .= '                  </tbody>';
        $data .= '              </table>';
        $data .= '           </div>';
        $data .= '         </div>';
        $data .= '       </div>';
        $data .= '    </div>';
        
        $json_data = array('data_prod' => $data
        );

        echo json_encode($json_data);
    }

    function view_detail_production_by_part() {
        
        $pallet = $this->input->post("case_prd");
        $part = $this->input->post("part_prd");
        
        $get_data = $this->picking_list_m->get_detail_production_by_part($pallet, $part);
        $data = '';    
        
        $data .= '            <div class="modal-wrapper">';
        $data .= '                <div class="modal-dialog">';
        $data .= '                    <div class="modal-content">';
        $data .= '                        <div class="modal-header">';
        $data .= '                            <button type="button" onclick="hide_detail_production_by_part()" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>';
        $data .= '                            <h4 class="modal-title" id="modalprogress"><strong>List Production Details</strong></h4>';
        $data .= '                        </div>';
        $data .= '                       <div class="modal-body" style="overflow-y: scroll;height: 350px;" id="view_detail_prod">';

        $data .= '              <table id="tables" class="table table-condensed table-striped table-hover display" cellspacing="0" width="100%">';
        $data .= '                  <thead>';
        $data .= '                      <tr>';
        $data .= '                          <th style="text-align:center;">No</th>';
        $data .= '                          <th style="text-align:center;">Serial Kanban</th>';
        $data .= '                          <th style="text-align:center;">Part No Cust</th>';
        $data .= '                          <th style="text-align:center;">Back No</th>';
        $data .= '                          <th style="text-align:center;">Date Scan</th>';
        $data .= '                          <th style="text-align:center;">Time Scan</th>';
        $data .= '                          <th style="text-align:center;">Date Prod</th>';
        $data .= '                          <th style="text-align:center;">Time Prod</th>';
        $data .= '                      </tr>';
        $data .= '                  </thead>';
        $data .= '                  <tbody>';

        $no = 1;
        foreach ($get_data as $val) {
            $data .= '  <tr align="center">';
            $data .= '      <td>' . $no . '</td>';
            $data .= '      <td>' . $val->CHR_KANBAN_NO . '</a></td>';
            $data .= '      <td>' . $val->CHR_PARTNO_CUST . '</td>';
            $data .= '      <td>' . $val->CHR_BACK_NO . '</td>';
            $data .= '      <td>' . $val->CHR_DATE_SCAN . '</td>';
            $data .= '      <td>' . $val->CHR_TIME_SCAN . '</td>';
            $data .= '      <td>' . $val->CHR_INLINE_DATE . '</td>';
            $data .= '      <td>' . $val->CHR_INLINE_DATE . '</td>';
            $data .= '  </tr>';
            $no++;
        }
        
        $data .= '                  </tbody>';
        $data .= '              </table>';
        $data .= '           </div>';
        $data .= '         </div>';
        $data .= '       </div>';
        $data .= '    </div>';
        
        $json_data = array('data_prod' => $data
        );

        echo json_encode($json_data);
    }

    function view_container() {
        $po_no = $this->input->post("po_fam");

        $get_data = $this->picking_list_m->get_list_container($po_no);
        
        $data = '';    
        
        $data .= '            <div class="modal-wrapper">';
        $data .= '                <div class="modal-dialog">';
        $data .= '                    <div class="modal-content">';
        $data .= '                        <div class="modal-header">';
        $data .= '                            <button type="button" onclick="hide_container()" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>';
        $data .= '                            <h4 class="modal-title" id="modalprogress"><strong>List Container for Delivery (' . $get_data[0]->CHR_CUST_NAME_ALIAS . ' - PO: ' . $po_no . ')</strong></h4>';
        $data .= '                        </div>';
        $data .= '                       <div class="modal-body" id="view_container">';

        $data .= '              <table id="example" class="table table-condensed table-striped table-hover display" cellspacing="0" width="100%">';
        $data .= '                  <thead>';
        $data .= '                      <tr>';
        $data .= '                          <th rowspan="2" style="text-align:center;">No</th>';
        $data .= '                          <th rowspan="2" style="text-align:center;">Container</th>';
        $data .= '                          <th rowspan="2" style="text-align:center;">Action</th>';
        $data .= '                      </tr>';
        $data .= '                  </thead>';
        $data .= '                  <tbody>';

        $no = 1;
        foreach ($get_data as $val) {
            $data .= '  <tr align="center">';
            $data .= '      <td>' . $no . '</td>';
            $data .= '      <td>' . $val->CHR_ADD_CODE . '</a></td>';
            $data .= '      <td><a href="' . base_url('index.php/delivery/export_c/export_delivery_by_container') . '/' . $po_no . '/' . $val->CHR_ADD_CODE . '" data-placement="right" title="Download" class="btn btn-info"><span class="fa fa-download"></span>Export</a></td>';
            $data .= '  </tr>';
            $no++;
        }
        
        $data .= '                  </tbody>';
        $data .= '              </table>';
        $data .= '           </div>';
        $data .= '         </div>';
        $data .= '       </div>';
        $data .= '    </div>';
        
        $json_data = array('data_pallet' => $data
        );

        echo json_encode($json_data);
    }

    function export_po_family_pallet() {        
        $po = $this->input->post("CHR_NOPO_FAMILY");
        $this->load->library(array('PHPExcel', 'PHPExcel/IOFactory'));

        $row = 3;
        $objReader = IOFactory::createReader('Excel5');

        $objPHPExcel = $objReader->load("assets/template/delivery/export/template_summary_pallet_export_by_po_v2.xlt");
            $active_sheet = $objPHPExcel->setActiveSheetIndexByName('TESTER & DELIVERY');
    
        $no = 1;
        $data = $this->picking_list_m->get_pallet_data_by_po($po); 
                    
        foreach ($data as $tr) {
    
            $active_sheet->setCellValue("A$row", $no);
            $active_sheet->setCellValue("B$row", $tr->CHR_CUST_NAME_ALIAS);
            $active_sheet->setCellValue("C$row", $po);
            $active_sheet->setCellValue("D$row", $tr->CHR_ADD_CODE . " (" . $tr->INT_NOPALLET . "/" . $tr->INT_QTY_CONTAINER_MAX . ")");
            $active_sheet->setCellValue("E$row", $tr->CHR_IDPALLET);
            $active_sheet->setCellValue("F$row", $tr->CHR_NOPO_SAP);
            $active_sheet->setCellValue("G$row", $tr->CHR_PART_NO);
            $active_sheet->setCellValue("H$row", $tr->CHR_BACK_NO);
            $active_sheet->setCellValue("I$row", $tr->CHR_PARTNO_CUST);
            $active_sheet->setCellValue("J$row", $tr->INT_QTY_PER_BOX);
            $active_sheet->setCellValue("K$row", ($tr->INT_QTY_PREPARE / $tr->INT_QTY_PER_BOX));
            $active_sheet->setCellValue("L$row", $tr->INT_QTY_PREPARE);
    
            $get_picklist = $this->db->query("SELECT A.CHR_DEL_NO
                                FROM TT_HISTORY_SCAN_PALLET A
                                LEFT JOIN TT_PACKING_UPLOAD B ON A.CHR_BARCODE = B.CHR_IDPALLET AND B.CHR_NOPO_CUST LIKE (A.CHR_PDS_NO + '%')
                                WHERE CHR_BARCODE = '$tr->CHR_IDPALLET'
                                AND B.CHR_PART_NO = '$tr->CHR_PART_NO'
                                AND A.CHR_PDS_NO = '$tr->CHR_NOPO_SAP'");
            if($get_picklist->num_rows() > 0){
                $picklist = $get_picklist->row();
                $pick_no = $picklist->CHR_DEL_NO;
                $active_sheet->setCellValue("M$row", $pick_no);
            } else {
                $active_sheet->setCellValue("M$row", "-");
            }
    
        
            $no++;
            $row++;
        }
    
        ob_end_clean();
        $filename = "List Pallet Data for PO " . $po . ".xls";
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . trim($filename) . '"');
        header('Cache-Control: max-age=0');

        $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
    }

    function export_delivery_by_container($po, $container) {  
        $this->load->library(array('PHPExcel', 'PHPExcel/IOFactory'));

        $row = 3;
        $objReader = IOFactory::createReader('Excel5');

        $objPHPExcel = $objReader->load("assets/template/delivery/export/template_summary_delivery_by_pallet.xlt");
            $active_sheet = $objPHPExcel->setActiveSheetIndexByName('TESTER & DELIVERY');
    
        $no = 1;
        $data = $this->picking_list_m->get_delivery_by_pallet_v2($po, $container); 
                    
        foreach ($data as $tr) {
    
            $active_sheet->setCellValue("A$row", $no);
            $active_sheet->setCellValue("B$row", $tr->CHR_CUST_NAME_ALIAS);
            $active_sheet->setCellValue("C$row", $container);
            $active_sheet->setCellValue("D$row", $tr->CHR_DEL_NO);
            $active_sheet->setCellValue("E$row", $tr->CHR_PDS_NO);
            $active_sheet->setCellValue("F$row", $tr->CHR_PART_NO);
            $active_sheet->setCellValue("G$row", $tr->CHR_BACK_NO);
            $active_sheet->setCellValue("H$row", $tr->CHR_PARTNO_CUST);
            $active_sheet->setCellValue("I$row", $tr->INT_QTY_PER_BOX);
            $active_sheet->setCellValue("J$row", ($tr->INT_QTY_PREPARE / $tr->INT_QTY_PER_BOX));
            $active_sheet->setCellValue("K$row", $tr->INT_QTY_PREPARE);
    
        
            $no++;
            $row++;
        }
    
        ob_end_clean();
        $filename = "List Pick List for PO " . $po . " - Container " . $container . ".xls";
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . trim($filename) . '"');
        header('Cache-Control: max-age=0');

        $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
    }

    function export_po_family_progress() {        
        $this->load->library(array('PHPExcel', 'PHPExcel/IOFactory'));

        $po = $this->input->post("NOPO_FAMILY");
        
        $get_data = $this->picking_list_m->get_po_family($po);
        $get_po_cust = $this->picking_list_m->get_po_cust_by_po_fam($po);

        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

        // Set Properties
        $objPHPExcel->getProperties()->setCreator(trim($this->session->userdata('USERNAME')));
        $objPHPExcel->getProperties()->setLastModifiedBy(trim($this->session->userdata('USERNAME')));
        $objPHPExcel->getProperties()->setTitle("Progress PO Family: " . $po);
        $objPHPExcel->getProperties()->setSubject("Progress PO Family: " . $po);
        $objPHPExcel->getProperties()->setDescription("Progress PO Family: " . $po);
                
        //Header TR
        $objPHPExcel->getActiveSheet()->setCellValue('A2', 'NO');
        $objPHPExcel->getActiveSheet()->mergeCells("A2:A3");
        $objPHPExcel->getActiveSheet()->getStyle("A2")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("A2")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);        
        $objPHPExcel->getActiveSheet()->setCellValue('B2', 'PART NO');        
        $objPHPExcel->getActiveSheet()->mergeCells("B2:B3");
        $objPHPExcel->getActiveSheet()->getStyle("B2")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("B2")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('C2', 'BACK NO');
        $objPHPExcel->getActiveSheet()->mergeCells("C2:C3");
        $objPHPExcel->getActiveSheet()->getStyle("C2")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("C2")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        
        $col = 'D';
        $col2 = 'D';
        $tot_po =  $get_po_cust->num_rows();
        foreach($get_po_cust->result() as $dat){
            $objPHPExcel->getActiveSheet()->setCellValue($col . '2', $dat->CHR_NOPO_CUST);
            $objPHPExcel->getActiveSheet()->getStyle($col . "2")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);            
            $col_x = $col;
            $col = ++$col;
            $col = ++$col;
            $col_y = $col;
            $col = ++$col;

            $mer1 = $col_x . '2';
            $mer2 = $col_y . '2';
            $objPHPExcel->getActiveSheet()->mergeCells("$mer1:$mer2");
            $objPHPExcel->getActiveSheet()->getStyle("$mer1:$mer2")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

            $objPHPExcel->getActiveSheet()->setCellValue($col2 . '3', 'PLAN');
            $objPHPExcel->getActiveSheet()->getStyle($col2 . "3")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $col2 = ++$col2;
            $objPHPExcel->getActiveSheet()->setCellValue($col2 . '3', 'ACT');
            $objPHPExcel->getActiveSheet()->getStyle($col2 . "3")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $col2 = ++$col2;
            $objPHPExcel->getActiveSheet()->setCellValue($col2 . '3', 'DIFF');
            $objPHPExcel->getActiveSheet()->getStyle($col2 . "3")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $col2 = ++$col2;            
        }

        $objPHPExcel->getActiveSheet()->setCellValue($col2 . '2', 'QTY PLAN');
        $mer1 = $col2 . '2';
        $mer2 = $col2 . '3';
        $objPHPExcel->getActiveSheet()->mergeCells("$mer1:$mer2");
        $objPHPExcel->getActiveSheet()->getStyle("$mer1:$mer2")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("$mer1:$mer2")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        
        $col2 = ++$col2;
        $objPHPExcel->getActiveSheet()->setCellValue($col2 . '2', 'QTY ACTUAL');
        $objPHPExcel->getActiveSheet()->getStyle($col2 . "2")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $mer1 = $col2 . '2';
        $mer2 = $col2 . '3';
        $objPHPExcel->getActiveSheet()->mergeCells("$mer1:$mer2");
        $objPHPExcel->getActiveSheet()->getStyle("$mer1:$mer2")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("$mer1:$mer2")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

        $col2 = ++$col2;
        $objPHPExcel->getActiveSheet()->setCellValue($col2 . '2', 'QTY PROD');
        $objPHPExcel->getActiveSheet()->getStyle($col2 . "2")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $mer1 = $col2 . '2';
        $mer2 = $col2 . '3';
        $objPHPExcel->getActiveSheet()->mergeCells("$mer1:$mer2");
        $objPHPExcel->getActiveSheet()->getStyle("$mer1:$mer2")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("$mer1:$mer2")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        
        $col2 = ++$col2;
        $objPHPExcel->getActiveSheet()->setCellValue($col2 . '2', 'QTY DIFF');
        $objPHPExcel->getActiveSheet()->getStyle($col2 . "2")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $mer1 = $col2 . '2';
        $mer2 = $col2 . '3';
        $objPHPExcel->getActiveSheet()->mergeCells("$mer1:$mer2");
        $objPHPExcel->getActiveSheet()->getStyle("$mer1:$mer2")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("$mer1:$mer2")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        
        $col2 = ++$col2;
        $objPHPExcel->getActiveSheet()->setCellValue($col2 . '2', '(%)');
        $objPHPExcel->getActiveSheet()->getStyle($col2 . "2")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $mer1 = $col2 . '2';
        $mer2 = $col2 . '3';
        $objPHPExcel->getActiveSheet()->mergeCells("$mer1:$mer2");
        $objPHPExcel->getActiveSheet()->getStyle("$mer1:$mer2")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("$mer1:$mer2")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        
        $col2 = ++$col2;
        $objPHPExcel->getActiveSheet()->setCellValue($col2 . '2', 'STATUS');
        $objPHPExcel->getActiveSheet()->getStyle($col2 . "2")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $mer1 = $col2 . '2';
        $mer2 = $col2 . '3';
        $objPHPExcel->getActiveSheet()->mergeCells("$mer1:$mer2");
        $objPHPExcel->getActiveSheet()->getStyle("$mer1:$mer2")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("$mer1:$mer2")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

        $style = $col2 . '3';
        $objPHPExcel->getActiveSheet()->getStyle("A2:$style")->getFont()->setBold(true)->setSize(11);

        $styleArray = array(
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => '99CCFF')
            )
        );
        $objPHPExcel->getActiveSheet()->getStyle("A2:$style")->applyFromArray($styleArray);
        
        //Value of All Cells
        $qty_prd_tot = 0;
        $i = 4;
        $no = 1;        
        foreach ($get_data as $data) {
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$i, $no);
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$i, $data->CHR_PART_NO);
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$i, $data->CHR_BACK_NO);

            $period = '20' . substr($po, 2, 4);
            $qty_prd = 0;
            $get_prd_result = $this->picking_list_m->get_prod_result($period, $data->CHR_PART_NO);
            if($get_prd_result->num_rows() > 0){
                $prd_result = $get_prd_result->row();
                $qty_prd = $prd_result->INT_PROD;
                $qty_prd_tot = $qty_prd_tot + $qty_prd;
            }

            $col3 = 'D';
            $qty = 0;
            $qty_prep = 0;
            foreach($get_po_cust->result() as $res){
                $get_qty = $this->picking_list_m->get_qty_po_cust($po, $res->CHR_NOPO_CUST, $data->CHR_PART_NO);                
                if($get_qty->num_rows() <= 0){

                    $objPHPExcel->getActiveSheet()->setCellValue($col3 . $i, '0');
                    $col3 = ++$col3;
                    $objPHPExcel->getActiveSheet()->setCellValue($col3 . $i, '0');
                    $col3 = ++$col3;
                    $objPHPExcel->getActiveSheet()->setCellValue($col3 . $i, '0');
                    $col3 = ++$col3;
                } else {
                    $po_qty = $get_qty->row();
                    $diff = $po_qty->INT_QTY_PREPARE - $po_qty->INT_QTY;

                    $objPHPExcel->getActiveSheet()->setCellValue($col3 . $i, $po_qty->INT_QTY);
                    $col3 = ++$col3;
                    $objPHPExcel->getActiveSheet()->setCellValue($col3 . $i, $po_qty->INT_QTY_PREPARE);
                    $col3 = ++$col3;
                    $objPHPExcel->getActiveSheet()->setCellValue($col3 . $i, $diff);
                    $col3 = ++$col3;
                    $qty = $qty + $po_qty->INT_QTY;
                    $qty_prep = $qty_prep + $po_qty->INT_QTY_PREPARE;
                } 
                               
            } 

            $qty_remain = $qty_prep - $qty;
            $percent = ($qty_prep / $qty) * 100;
            $stat = '';
            if($percent <= 0){
                $stat = 'NOT YET';
            } else if($percent > 0 && $percent < 100){
                $stat = 'PROGRESS';
            } else {
                $stat = 'OK';
            }

            $objPHPExcel->getActiveSheet()->setCellValue($col3 . $i, $qty );
            $col3 = ++$col3;
            $objPHPExcel->getActiveSheet()->setCellValue($col3 . $i, $qty_prep );
            $col3 = ++$col3;
            $objPHPExcel->getActiveSheet()->setCellValue($col3 . $i, $qty_prd );
            $col3 = ++$col3;
            $objPHPExcel->getActiveSheet()->setCellValue($col3 . $i, $qty_remain );
            $col3 = ++$col3;
            $objPHPExcel->getActiveSheet()->setCellValue($col3 . $i, $percent );
            $col3 = ++$col3;
            $objPHPExcel->getActiveSheet()->setCellValue($col3 . $i, $stat );
                  
            $i++;
            $no++;
        }

        $qty_plan_tot = 0;
        $qty_act_tot = 0;
        $remain_po = 0; 
        $col4 = 'C'; 
        $objPHPExcel->getActiveSheet()->setCellValue("A" . $i, 'Total' );
        $mer1 = 'A' . $i;
        $mer2 = $col4 . $i;
        $objPHPExcel->getActiveSheet()->mergeCells("$mer1:$mer2");
        $objPHPExcel->getActiveSheet()->getStyle("$mer1:$mer2")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        $col4 = ++$col4;      
        foreach($get_po_cust->result() as $dat){
            $remain_po = $dat->INT_QTY_PREPARE - $dat->INT_QTY;
            $objPHPExcel->getActiveSheet()->setCellValue($col4 . $i, $dat->INT_QTY );
            $col4 = ++$col4;
            $objPHPExcel->getActiveSheet()->setCellValue($col4 . $i, $dat->INT_QTY_PREPARE );
            $col4 = ++$col4;
            $objPHPExcel->getActiveSheet()->setCellValue($col4 . $i, $remain_po );
            $col4 = ++$col4;
            $qty_plan_tot = $qty_plan_tot + $dat->INT_QTY;
            $qty_act_tot = $qty_act_tot + $dat->INT_QTY_PREPARE;
        }

        $qty_remain_tot = $qty_act_tot - $qty_plan_tot;
        $percent_tot = ($qty_act_tot / $qty_plan_tot) * 100;
        $objPHPExcel->getActiveSheet()->setCellValue($col4 . $i, $qty_plan_tot );
        $col4 = ++$col4;
        $objPHPExcel->getActiveSheet()->setCellValue($col4 . $i, $qty_act_tot );
        $col4 = ++$col4;
        $objPHPExcel->getActiveSheet()->setCellValue($col4 . $i, $qty_prd_tot );
        $col4 = ++$col4;
        $objPHPExcel->getActiveSheet()->setCellValue($col4 . $i, $qty_remain_tot );
        $col4 = ++$col4;
        $objPHPExcel->getActiveSheet()->setCellValue($col4 . $i, $percent_tot );
        $col4 = ++$col4; 

        $stat2 = '';
        if($percent_tot <= 0){
            $stat2 = 'NOT YET';
        } else if($percent_tot > 0 && $percent_tot < 100){
            $stat2 = 'PROGRESS';
        } else {
            $stat2 = 'OK';
        }

        $objPHPExcel->getActiveSheet()->setCellValue($col4 . $i, $stat2 );

        $mer2 = $col4 . $i;
        $objPHPExcel->getActiveSheet()->getStyle("$mer1:$mer2")->getFont()->setBold(true)->setSize(11);   

        $i++;
        $col5 = 'C';
        $objPHPExcel->getActiveSheet()->setCellValue("A" . $i, '(%)' );
        $mer1 = 'A' . $i;
        $mer2 = $col5 . $i;
        $objPHPExcel->getActiveSheet()->mergeCells("$mer1:$mer2");
        $objPHPExcel->getActiveSheet()->getStyle("$mer1:$mer2")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $col5 = ++$col5;
        foreach($get_po_cust->result() as $dat){
            $objPHPExcel->getActiveSheet()->setCellValue($col5 . $i, number_format((($dat->INT_QTY_PREPARE / $dat->INT_QTY) * 100),1,',','.') );
            $col_x = $col5;
            $col5 = ++$col5;
            $col5 = ++$col5;
            $col_y = $col5;
            $col5 = ++$col5;

            $mer1 = $col_x . $i;
            $mer2 = $col_y . $i;
            $objPHPExcel->getActiveSheet()->mergeCells("$mer1:$mer2");
            $objPHPExcel->getActiveSheet()->getStyle("$mer1:$mer2")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        }
        
        $mer1 = 'A' . $i;
        $mer2 = $col5 . $i;
        $objPHPExcel->getActiveSheet()->getStyle("$mer1:$mer2")->getFont()->setBold(true)->setSize(11);   

        $i++;
        $col6 = 'C';
        $objPHPExcel->getActiveSheet()->setCellValue("A" . $i, 'Status' );
        $mer1 = 'A' . $i;
        $mer2 = $col6 . $i;
        $objPHPExcel->getActiveSheet()->mergeCells("$mer1:$mer2");
        $objPHPExcel->getActiveSheet()->getStyle("$mer1:$mer2")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $col6 = ++$col6;
        foreach($get_po_cust->result() as $dat){
            $percent_po = (($dat->INT_QTY_PREPARE / $dat->INT_QTY) * 100);
            if($percent_po <= 0){
                $objPHPExcel->getActiveSheet()->setCellValue($col6 . $i, 'NOT YET' );           
            } else if($percent_po > 0 && $percent_po < 100){
                $objPHPExcel->getActiveSheet()->setCellValue($col6 . $i, 'PROGRESS' );
            } else {
                $objPHPExcel->getActiveSheet()->setCellValue($col6 . $i, 'OK' );
            }
            $col_x = $col6;
            $col6 = ++$col6;
            $col6 = ++$col6;
            $col_y = $col6;
            $col6 = ++$col6;

            $mer1 = $col_x . $i;
            $mer2 = $col_y . $i;
            $objPHPExcel->getActiveSheet()->mergeCells("$mer1:$mer2");
            $objPHPExcel->getActiveSheet()->getStyle("$mer1:$mer2")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        }

        $mer1 = 'A' . $i;
        $mer2 = $col6 . $i;
        $objPHPExcel->getActiveSheet()->getStyle("$mer1:$mer2")->getFont()->setBold(true)->setSize(11);   
        
        $styleArray = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                ),
            ),
        );
        
        $style = $col3 . $i;
        $objPHPExcel->getActiveSheet()->getStyle("A2:$style")->applyFromArray($styleArray);
        
        $filename = "Progress PO Family ". $po . ".xls";
        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . trim($filename) . '"');
        header('Cache-Control: max-age=0');

        $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
    }

    public function upload_po_family()
    {
        $this->load->library(array('PHPExcel', 'PHPExcel/IOFactory'));

        $period = date('Ym');

        if ($this->input->post("btn-upload") != '') {
            $this->db->query("truncate table TW_PO_FAMILY_UPLOAD");
            $upload_po = $this->input->post('upload_po');
            $period = $this->input->post('month');
            
            $no_upload = substr($period, 2, 4) . '01';            

            $id_po_fam = $this->db->query("SELECT TOP 1 * FROM TT_PO_FAMILY_UPLOAD WHERE CHR_MONTH = '$period' AND CHR_NOPO_FAMILY LIKE '%$no_upload%' AND INT_FLG_DEL = '0' ORDER BY CHR_NOPO_FAMILY DESC");
            if ($id_po_fam->num_rows() > 0) {
                $data_fam = $id_po_fam->row();
                $no_fam = substr($data_fam->CHR_NOPO_FAMILY, 8, 3);
                $new_no = sprintf("%03d", $no_fam + 1);
                // print_r($new_no);
                // exit();
                $new_no_fam = 'PO' . $no_upload . $new_no;
            } else {
                $new_no_fam = 'PO' . $no_upload . '001';
            }

            $fileName = $_FILES['upload_po']['name'];
            if (empty($fileName)) {
                echo '<script>alert("Anda belum memilih file untuk diupload");</script>';
                redirect('delivery/export_c/upload_po_family', 'refresh');
            }

            //file untuk submit file excel
            $config['upload_path'] = './assets/files/';
            $config['file_name'] = $fileName;
            $config['allowed_types'] = 'xls|xlsx';
            $config['max_size'] = 10000;

            //code for upload with ci
            $this->load->library('upload');
            $this->upload->initialize($config);
            if ($a = $this->upload->do_upload('upload_po'))
                $this->upload->display_errors();
            $media = $this->upload->data('upload_po');
            $inputFileName = './assets/files/' . $media['file_name'];

            //  Read  Excel workbook
            try {
                $inputFileType = IOFactory::identify($inputFileName);
                $objReader = IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($inputFileName);
            } catch (Exception $e) {
                //  $this->db->trans_rollback();
                die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' . $e->getMessage());
            }

            //  Get worksheet dimensions
            $sheet = $objPHPExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();

            $x = 0;
            $y = 0;
            $rowHeader = $sheet->rangeToArray('A2:' . $highestColumn . '2', NULL, TRUE, FALSE);
            $this->db->query("truncate table TW_PO_FAMILY_UPLOAD");
            for ($row = 2; $row <= $highestRow; $row++) {
                $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);
                $no_po = $rowData[0][0];
                $part_no = $rowData[0][1];
                $part_no = trim($part_no);
                $part_no_cust = $rowData[0][2];
                $part_no_cust = trim($part_no_cust);
                $qty = $rowData[0][3];
                $wcenter = $rowData[0][4];
                $del_date = $rowData[0][5];

                $msg = "";
                $stat = "0";
                if($no_po == ""){
                    $stat = "1";
                    $msg .= "PO tidak boleh kosong";
                }

                if($part_no == ""){
                    $stat = "1";
                    $msg .= " || Part No tidak boleh kosong";
                }

                if($part_no_cust == ""){
                    $stat = "1";
                    $msg .= " || Part No Cust tidak boleh kosong";
                }

                if($qty <= 0){
                    $stat = "1";
                    $msg .= " || Qty kosong";
                }

                if($wcenter == ""){
                    $stat = "1";
                    $msg .= " || Work Center tidak boleh kosong";
                }

                if($del_date == ""){
                    $stat = "1";
                    $msg .= " || Delivery Date Plan tidak boleh kosong";
                }

                //Additional info
                if (isset($rowData[0][6])) {
                    $addtional_info = $rowData[0][6];
                } else {
                    $addtional_info = "";
                }
                    
                if (isset($rowData[0][7])) {
                    $addtional_info1 = $rowData[0][7];
                } else {
                    $addtional_info1 = "";
                }

                //Shipmark
                if (isset($rowData[0][8])) {
                    $shipmark = $rowData[0][8];
                } else {
                    $shipmark = "";
                }

                //Cust name alias
                if (isset($rowData[0][9])) {
                    $alias = $rowData[0][9];
                } else {
                    $alias = "";
                }

                //Country
                if (isset($rowData[0][10])) {
                    $country = $rowData[0][10];
                } else {
                    $country = "";
                }

                //Check PO                    
                $check_part_no = $this->db->query("SELECT CHR_CUS_PART_NO FROM TM_SHIPPING_PARTS WHERE CHR_PART_NO = '$part_no' AND CHR_CUS_PART_NO = '$part_no_cust'");
                if ($check_part_no->num_rows() <= 0) {
                    $stat = "1";
                    $msg .= " || Part No AII & Part No Cust tidak cocok";
                }

                //Check Kanban
                $check_kanban = $this->db->query("SELECT * FROM TM_KANBAN WHERE CHR_PART_NO = '$part_no' and CHR_KANBAN_TYPE = '5'")->row();

                if (count($check_kanban) > 0) {
                    $back_no = $check_kanban->CHR_BACK_NO;
                    $qty_per_box = $check_kanban->INT_QTY_PER_BOX;
                } else {
                    $back_no = "";
                    $stat = "1";
                    $msg .= " || Tidak ada master Kanban";
                    $qty_per_box = 0;
                }

                //insert
                $this->db->query("INSERT INTO TW_PO_FAMILY_UPLOAD (CHR_NOPO_FAMILY, CHR_NOPO_CUST, CHR_PART_NO, CHR_PARTNO_CUST, CHR_BACK_NO, INT_QTY, INT_QTY_PER_BOX, CHR_WORK_CENTER, CHR_MONTH, CHR_DATE_DELIVERY, CHR_ADD_INFO, CHR_ADD_INFO1, CHR_SHIPMARK, CHR_CUST_NAME_ALIAS, CHR_COUNTRY, INT_FLG_DEL, CHR_MSG) "
                        . "VALUES ('$new_no_fam', '$no_po', '$part_no', '$part_no_cust', '$back_no', '$qty', '$qty_per_box', '$wcenter', '$period', '$del_date', '$addtional_info' , '$addtional_info1', '$shipmark', '$alias', '$country', '$stat', '$msg');");
            }

            redirect("delivery/export_c/confirmation_upload_po_family", "refresh");
        }

        $data['content'] = 'delivery/upload_po_family_v';
        $data['title'] = 'Upload PO Family';
        $data['role'] = $this->session->userdata('NPK');
        $data['period'] = $period;

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(359);
        $data['news'] = $this->news_m->get_news();

        $this->load->view($this->layout, $data);
    }

    public function download_temp_po_family()
    { //fungsi download
        $this->load->helper('download');

        ob_clean();
        $name = 'po_family_upload.xlsx'; // New template
        $data = file_get_contents("assets/template/delivery/export/$name"); // filenya

        force_download($name, $data);
    }

    public function confirmation_upload_po_family()
    { //fungsi download
        $this->role_module_m->authorization('30');
        $date_now = date("Ymd");
        $time_now = date("His");
        $this->session->userdata('user_id');
        $user = $this->session->userdata('NPK');

        $data['content'] = 'delivery/confirm_po_family_v';
        $data['title'] = 'Confirm PO Family';

        $po_family = $this->db->query("SELECT * FROM TW_PO_FAMILY_UPLOAD")->result();
        if (count($po_family) == 0) {
            redirect("delivery/export_c/upload_po_family", "refresh");
        }

        $nopo_family = $po_family[0]->CHR_NOPO_FAMILY;

        //cek upload ok
        $cek_upload_total = $this->db->query("SELECT * FROM TW_PO_FAMILY_UPLOAD")->num_rows();
        $cek_upload_ok = $this->db->query("SELECT * FROM TW_PO_FAMILY_UPLOAD WHERE INT_FLG_DEL = '0'")->num_rows();

        if ($this->input->post("btn-confirm") != '') {
            $range = 0;
            foreach ($po_family as $val) {
                $nopofamily = trim($val->CHR_NOPO_FAMILY);
                $nopocust = trim($val->CHR_NOPO_CUST);
                $part_no = $val->CHR_PART_NO;
                $part_no_cust = $val->CHR_PARTNO_CUST;
                $back_no = $val->CHR_BACK_NO;
                $qty = $val->INT_QTY;
                $qty_per_box = $val->INT_QTY_PER_BOX;
                $wcenter = $val->CHR_WORK_CENTER;
                $period = $val->CHR_MONTH;
                $delivery_date = $val->CHR_DATE_DELIVERY;
                $addtional_info = $val->CHR_ADD_INFO;
                $addtional_info1 = $val->CHR_ADD_INFO1;
                $shipmark = $val->CHR_SHIPMARK;
                $alias = $val->CHR_CUST_NAME_ALIAS;
                $country = $val->CHR_COUNTRY;
                $this->db->query("INSERT INTO TT_PO_FAMILY_UPLOAD (CHR_NOPO_FAMILY, CHR_NOPO_CUST, CHR_PART_NO, CHR_PARTNO_CUST, CHR_BACK_NO, INT_QTY, INT_QTY_PER_BOX, CHR_WORK_CENTER, CHR_MONTH, CHR_DATE_DELIVERY, CHR_ADD_INFO, CHR_ADD_INFO1, CHR_SHIPMARK, CHR_CUST_NAME_ALIAS, CHR_COUNTRY, CHR_USER_INSERT, CHR_DATE_INSERT, CHR_TIME_INSERT) "
                . "VALUES ('$nopofamily', '$nopocust', '$part_no', '$part_no_cust', '$back_no', '$qty', '$qty_per_box', '$wcenter', '$period', '$delivery_date', '$addtional_info' , '$addtional_info1', '$shipmark', '$alias', '$country', '$user', '$date_now', '$time_now');");

                $range++;
            }

            $this->db->query("TRUNCATE TABLE TW_PO_FAMILY_UPLOAD");

            redirect("delivery/export_c/print_barcode_po_family/$val->CHR_NOPO_FAMILY", "refresh");
            $this->load->view('delivery/print_kanban_po_family', $data);
        }

        $data['po_family'] = $po_family;
        $data['nopo_family'] = $nopo_family;
        $data['cek_upload_total'] = $cek_upload_total;
        $data['cek_upload_ok'] = $cek_upload_ok;
        
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(359);
        $data['news'] = $this->news_m->get_news();

        $this->load->view($this->layout, $data);
    }

    function delete_po_family($po_fam, $date_from, $date_to)
    {
        $session = $this->session->all_userdata();
        $npk = $session['NPK'];
        $this->picking_list_m->delete_po_family($po_fam, $npk);
        redirect("delivery/export_c/manage_po_family/$date_from/$date_to", "refresh");
    }

}
