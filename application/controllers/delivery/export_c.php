<?php

class export_c extends CI_Controller
{

    private $layout = '/template/head';

    public function __construct()
    {
        parent::__construct();

        $this->load->model('delivery/picking_list_m');
        $this->load->model('organization/dept_m');
        $this->load->helper(array('form', 'url', 'inflector'));
        $this->load->library(array('PHPExcel', 'PHPExcel/IOFactory'));
        //$this->load->library(array('sql_server'));
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
            if (strlen($renban) == 1) {
                $renban = "00" . $renban;
            } else if (strlen($renban) == 2) {
                $renban = "00" . $renban;
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

        $packing_list = $this->db->query("SELECT DISTINCT(CHR_IDPACKING) FROM  TT_PACKING_UPLOAD WHERE CHR_DATE_DELIVERY between '$date_from' and '$date_to' AND INT_FLG_DEL = 0 order by CHR_IDPACKING asc")->result();
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
        $this->picking_list_m->delete($id_packing);
        redirect("delivery/export_c/manage_packing/$date_from/$date_to", "refresh");
    }

    function manage_invoice_peb($start_date = NULL, $end_date = NULL) {
        $session = $this->session->all_userdata();

        if ($start_date == NULL || $start_date == '') {
            $start_date = date('Ym') . '01';
        }

        if ($end_date == NULL || $end_date == '') {
            $end_date = date('Ymd');
        }

        $list_pallet = "";
        $list_po = "";
        $list_inv = "";
        $type = "1"; //=== default by pallet

        $data['start_date'] = $start_date;  
        $data['end_date'] = $end_date;  
        $data['type'] = $type;
        $data['list_pallet'] = $list_pallet;
        $data['list_po'] = $list_po;
        $data['list_inv'] = $list_inv;
        
        $data['list_po_no'] = $this->picking_list_m->get_list_po_no($start_date, $end_date); 
        $data['list_pack_no'] = $this->picking_list_m->get_list_idpallet($start_date, $end_date); 
        $data['list_inv_no'] = $this->picking_list_m->get_list_inv_no($start_date, $end_date);  
        // $data['list_peb_no'] = $this->db->query("SELECT DISTINCT CHR_PEB_NO FROM TT_PACKING_UPLOAD WHERE (CHR_DATE_DELIVERY BETWEEN '$start_date' AND '$end_date') AND INT_FLG_DEL = '0' AND CHR_PREPARE_STATUS = '1'")->result();  
        
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

        $list_pallet = "";
        $list_po = "";
        $list_inv = "";

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
        }

        $data['start_date'] = $start_date;  
        $data['end_date'] = $end_date;  
        $data['type'] = $type;
        $data['list_pallet'] = $pallet;
        $data['list_po'] = $po;
        $data['list_inv'] = $inv;

        $data['list_po_no'] = $this->picking_list_m->get_list_po_no($start_date, $end_date); 
        $data['list_pack_no'] = $this->picking_list_m->get_list_idpallet($start_date, $end_date); 
        $data['list_inv_no'] = $this->picking_list_m->get_list_inv_no($start_date, $end_date);  
        // $data['list_peb_no'] = $this->db->query("SELECT DISTINCT CHR_PEB_NO FROM TT_PACKING_UPLOAD WHERE (CHR_DATE_DELIVERY BETWEEN '$start_date' AND '$end_date') AND INT_FLG_DEL = '0' AND CHR_PREPARE_STATUS = '1'")->result();  
        
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
            }
            
        }

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
}
