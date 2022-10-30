<?php

class master_data_c extends CI_Controller
{

    private $layout = '/template/head';
    private $back_to_manage = 'accounting/master_data_c/index';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('accounting/master_data_m');
    }

    public function index($msg = null)
    {
        $this->role_module_m->authorization('143');
        $this->log_m->add_log(14, null);
        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Creating success </strong> The data is successfully created </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Updating success </strong> The data is successfully updated </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Deleted success </strong> The data is successfully deleted </div >";
        } elseif ($msg == 12) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Executing error !</strong> Something error with parameter </div >";
        } else {
            $msg = "";
        }
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(145);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Manage ECI Category';
        $data['msg'] = $msg;
        $data['data'] = $this->activity_m->find_trans("*", "INT_ID_ACTIVITY<>0", "INT_ID_ACTIVITY");
        $data['content'] = 'eci/activity/manage_activity_v';
        $this->load->view($this->layout, $data);
    }

    public function equalisasi($delete_id = null)
    {
        //WILDAN - NITIP DATA REKONSILIASI ANATARA DATA TESTER DAN HISTORY KANBAN
        $data_tester = $this->db->query("select * from PRD.TX_DATA_TESTER")->result();
        foreach ($data_tester as $value) {
            $id = $value->INT_ID;
            $prod_order_num = $value->CHR_PRD_ORDER_NO;
            $date_tester = $value->CHR_CREATED_DATE;
            $time_tester = $value->CHR_CREATED_TIME;
            $top_kanban_hist = $this->db->query("select top(1) CHR_BARCODE_KANBAN, CHR_BACK_NO from  TT_HISTORY_IN_LINE_SCAN where INT_QTY_PERSCAN <> 0 "
                . "and CHR_PRD_ORDER_NO = '$prod_order_num' and CHR_CREATED_DATE = '$date_tester' and CHR_CREATED_TIME > $time_tester "
                . "ORDER BY CHR_CREATED_TIME ASC")->row();
            if (count($top_kanban_hist) > 0) {

                $this->db->query("update PRD.TX_DATA_TESTER set CHR_SERIAL_KANBAN = '$top_kanban_hist->CHR_BARCODE_KANBAN', CHR_BACK_NO_FG = '$top_kanban_hist->CHR_BACK_NO' where INT_ID = '$id' ");
            }
        }
        // $no = "92 x 00006";

        // echo str_pad($no, 14, "0", STR_PAD_LEFT);
        // exit();

        $data_tester = $this->db->query("select distinct (CHR_SERIAL_KANBAN) from PRD.TX_DATA_TESTER")->result();

        foreach ($data_tester as $value) {
            $seial_asli = trim($value->CHR_SERIAL_KANBAN);
            $serial = trim($value->CHR_SERIAL_KANBAN);
            $serial = str_pad($serial, 14, "0", STR_PAD_LEFT);
            if($serial == '00000000000000'){
                continue;
            }
            $id_pallete = '';
            $po_number = '';
            $CHR_DEL_DATE_ACT  = '';
            $CHR_DEL_NO = '';

            $packing_list = $this->db->query("select CHR_IDPALLET from  TT_SCAN_PREPARE_EXPORT where CHR_KANBAN_NO = '$serial'")->row();
            if(count($packing_list) > 0){
                $id_pallete = trim($packing_list->CHR_IDPALLET);
            }else{
                $id_pallete = "";
                continue;
            }
            
            $get_po_number =  $this->db->query("select CHR_NOPO_SAP from  TT_PACKING_UPLOAD where   (CHR_IDPALLET = '$id_pallete')")->row();
            if(count($get_po_number) > 0){
                $po_number = trim($get_po_number->CHR_NOPO_SAP);
            }else{
                $po_number ="";
                continue;
            }


            $get_del_no = $this->db->query("select CHR_DEL_DATE_ACT , CHR_DEL_NO from  TT_DELIVERY where CHR_PDS_NO = '$po_number' and CHR_GI_DEL = 'C'")->row();
            $CHR_DEL_DATE_ACT = $get_del_no->CHR_DEL_DATE_ACT;
            $CHR_DEL_NO = $get_del_no->CHR_DEL_NO;
            $this->db->query("update PRD.TX_DATA_TESTER set CHR_PACKING_EXPORT = '$id_pallete' , CHR_DELIVERY_DATE = '$CHR_DEL_DATE_ACT' , CHR_DELIVERY_NO = '$CHR_DEL_NO' , CHR_PO_NO = '$po_number '  WHERE CHR_SERIAL_KANBAN = '$seial_asli' ");
        }

       


        exit();

        $session = $this->session->all_userdata();
        $date_now = date("Ymd");
        $time_now = date("His");
        $user = $session['NPK'];

//        Load Parameter Default Page
        $this->role_module_m->authorization('242');
        $this->log_m->add_log(14, null);
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(242);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Manage Master Data Equalisasi';
        $msg = "";

//      Process Data
        //insert, update data
        if ($this->input->post("btn_save")) {
            $id = $this->input->post("id_equalisasi");
            $equalisasi_name = $this->input->post("equalisasi_name");
            $id_exist = $this->db->query("select * from ACC.TM_EQUALISASI where CHR_ID_EQUALISASI = '$id'")->row();

            if (count($id_exist) == 0) {
                $this->db->query("insert ACC.TM_EQUALISASI (CHR_ID_EQUALISASI , CHR_NAME , CHR_CREATE_USER , CHR_CREATE_DATE , CHR_CREATE_TIME) VALUES "
                    . "('$id' , '$equalisasi_name' , '$user' ,  '$date_now' , '$time_now')");
                $msg = "1";
            } else {
                $this->db->query("update ACC.TM_EQUALISASI SET  CHR_NAME = '$equalisasi_name' ,CHR_FLAG_DELETE = '0' , CHR_MODIFIED_USER = '$user' , CHR_MODIFIED_DATE = '$date_now', CHR_MODIFIED_TIME = '$time_now' "
                    . "where CHR_ID_EQUALISASI = '$id'");
                $msg = "2";
            }
        }
        //delete data
        if (!$delete_id == null) {
            $this->db->query("update ACC.TM_EQUALISASI SET  CHR_FLAG_DELETE = '1' , CHR_MODIFIED_USER = '$user' , CHR_MODIFIED_DATE = '$date_now', CHR_MODIFIED_TIME = '$time_now' "
                . "where CHR_ID_EQUALISASI = '$delete_id'");
            $msg = "3";
        }

        //      Message Info
        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Creating success </strong> The data is successfully created </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Updating success </strong> The data is successfully updated </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Deleted success </strong> The data is successfully deleted </div >";
        } elseif ($msg == 12) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Executing error !</strong> Something error with parameter </div >";
        } else {
            $msg = "";
        }

//        Get Data
        $master_data = $this->db->query("select * FROM ACC.TM_EQUALISASI WHERE CHR_FLAG_DELETE = '0'")->result();
//      Parse to View
        $data['msg'] = $msg;
        $data['master_data'] = $master_data;

        $data['content'] = 'accounting/master_data/equalisasi_v';
        $this->load->view($this->layout, $data);
    }

    public function get_equal()
    {
        $id = $this->input->post('id'); // Use this instead of $_POST['id']
        $data_equal = $this->db->query("select CHR_ID_EQUALISASI, CHR_NAME from ACC.TM_EQUALISASI where  CHR_ID_EQUALISASI = '$id'")->row();

        $name = $data_equal->CHR_NAME;
        echo json_encode(
            array(
                'id' => $id,
                'name' => $name,
            )
        );
    }

    public function get_gl()
    {
        $id = $this->input->post('id'); // Use this instead of $_POST['id']
        $data_equal = $this->db->query("select CHR_GL_ACCOUNT, CHR_NAME from ACC.TM_GL_ACCOUNT where  CHR_GL_ACCOUNT = '$id'")->row();

        $name = $data_equal->CHR_NAME;
        echo json_encode(
            array(
                'id' => $id,
                'name' => $name,
            )
        );
    }

    public function get_ap()
    {
        $id = $this->input->post('id'); // Use this instead of $_POST['id']
        $data_equal = $this->db->query("select CHR_ACC_PAY, CHR_NAME from ACC.TM_ACCOUNT_PAYABLE where  CHR_ACC_PAY  = '$id'")->row();

        $name = $data_equal->CHR_NAME;
        echo json_encode(
            array(
                'id' => $id,
                'name' => $name,
            )
        );
    }

    public function get_ar()
    {
        $id = $this->input->post('id'); // Use this instead of $_POST['id']
        $data_equal = $this->db->query("select CHR_ACC_REC, CHR_NAME from ACC.TM_ACCOUNT_RECEIVABLE where  CHR_ACC_REC  = '$id'")->row();

        $name = $data_equal->CHR_NAME;
        echo json_encode(
            array(
                'id' => $id,
                'name' => $name,
            )
        );
    }

    public function gl_account($delete_id = null)
    {
        $session = $this->session->all_userdata();
        $date_now = date("Ymd");
        $time_now = date("His");
        $user = $session['NPK'];

//        Load Parameter Default Page
        $this->role_module_m->authorization('243');
        $this->log_m->add_log(14, null);
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(243);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Manage Master Data Gl Account';
        $msg = "";

//      Process Data
        //insert, update data
        if ($this->input->post("btn_save")) {
            $id = $this->input->post("id_gl");
            $equalisasi_name = $this->input->post("gl_name");
            $id_exist = $this->db->query("select * from ACC.TM_GL_ACCOUNT where CHR_GL_ACCOUNT = '$id'")->row();

            if (count($id_exist) == 0) {
                $this->db->query("insert ACC.TM_GL_ACCOUNT (CHR_GL_ACCOUNT , CHR_NAME , CHR_CREATE_USER , CHR_CREATE_DATE , CHR_CREATE_TIME) VALUES "
                    . "('$id' , '$equalisasi_name' , '$user' ,  '$date_now' , '$time_now')");
                $msg = "1";
            } else {
                $this->db->query("update ACC.TM_GL_ACCOUNT SET  CHR_NAME = '$equalisasi_name' ,CHR_FLAG_DELETE = '0' , CHR_MODIFIED_USER = '$user' , CHR_MODIFIED_DATE = '$date_now', CHR_MODIFIED_TIME = '$time_now' "
                    . "where CHR_GL_ACCOUNT = '$id'");
                $msg = "2";
            }
        }
        //delete data
        if (!$delete_id == null) {
            $this->db->query("update ACC.TM_GL_ACCOUNT SET  CHR_FLAG_DELETE = '1' , CHR_MODIFIED_USER = '$user' , CHR_MODIFIED_DATE = '$date_now', CHR_MODIFIED_TIME = '$time_now' "
                . "where CHR_GL_ACCOUNT = '$delete_id'");
            $msg = "3";
        }

        //      Message Info
        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Creating success </strong> The data is successfully created </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Updating success </strong> The data is successfully updated </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Deleted success </strong> The data is successfully deleted </div >";
        } elseif ($msg == 12) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Executing error !</strong> Something error with parameter </div >";
        } else {
            $msg = "";
        }

//        Get Data
        $master_data = $this->db->query("select * FROM ACC.TM_GL_ACCOUNT WHERE CHR_FLAG_DELETE = '0'")->result();
//      Parse to View
        $data['msg'] = $msg;
        $data['master_data'] = $master_data;

        $data['content'] = 'accounting/master_data/gl_account_v';

        $this->load->view($this->layout, $data);
    }

    public function account_payable($delete_id = null)
    {
        $session = $this->session->all_userdata();
        $date_now = date("Ymd");
        $time_now = date("His");
        $user = $session['NPK'];

//        Load Parameter Default Page
        $this->role_module_m->authorization('244');
        $this->log_m->add_log(14, null);
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(244);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Manage Master Account Payable';
        $msg = "";

//      Process Data
        //insert, update data
        if ($this->input->post("btn_save")) {
            $id = $this->input->post("id_ap");
            $equalisasi_name = $this->input->post("ap_name");
            $id_exist = $this->db->query("select * from ACC.TM_ACCOUNT_PAYABLE where CHR_ACC_PAY = '$id'")->row();

            if (count($id_exist) == 0) {
                $this->db->query("insert ACC.TM_ACCOUNT_PAYABLE (CHR_ACC_PAY , CHR_NAME , CHR_CREATE_USER , CHR_CREATE_DATE , CHR_CREATE_TIME) VALUES "
                    . "('$id' , '$equalisasi_name' , '$user' ,  '$date_now' , '$time_now')");
                $msg = "1";
            } else {
                $this->db->query("update ACC.TM_ACCOUNT_PAYABLE SET  CHR_NAME = '$equalisasi_name' ,CHR_FLAG_DELETE = '0' , CHR_MODIFIED_USER = '$user' , CHR_MODIFIED_DATE = '$date_now', CHR_MODIFIED_TIME = '$time_now' "
                    . "where CHR_ACC_PAY = '$id'");
                $msg = "2";
            }
        }
        //delete data
        if (!$delete_id == null) {
            $this->db->query("update ACC.TM_ACCOUNT_PAYABLE SET  CHR_FLAG_DELETE = '1' , CHR_MODIFIED_USER = '$user' , CHR_MODIFIED_DATE = '$date_now', CHR_MODIFIED_TIME = '$time_now' "
                . "where CHR_ACC_PAY = '$delete_id'");
            $msg = "3";
        }

        //      Message Info
        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Creating success </strong> The data is successfully created </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Updating success </strong> The data is successfully updated </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Deleted success </strong> The data is successfully deleted </div >";
        } elseif ($msg == 12) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Executing error !</strong> Something error with parameter </div >";
        } else {
            $msg = "";
        }

//        Get Data
        $master_data = $this->db->query("select * FROM ACC.TM_ACCOUNT_PAYABLE WHERE CHR_FLAG_DELETE = '0'")->result();
//      Parse to View
        $data['msg'] = $msg;
        $data['master_data'] = $master_data;
        $data['content'] = 'accounting/master_data/acc_pay_v';
        $this->load->view($this->layout, $data);
    }

    public function account_receivable($delete_id = null)
    {
        $session = $this->session->all_userdata();
        $date_now = date("Ymd");
        $time_now = date("His");
        $user = $session['NPK'];

//        Load Parameter Default Page
        $this->role_module_m->authorization('245');
        $this->log_m->add_log(14, null);
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(245);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Manage Master Data ACC Receivable';
        $msg = "";

//      Process Data
        //insert, update data
        if ($this->input->post("btn_save")) {
            $id = $this->input->post("id_ar");
            $rec_name = $this->input->post("ar_name");
            $id_exist = $this->db->query("select * from ACC.TM_ACCOUNT_RECEIVABLE where CHR_ACC_REC = '$id'")->row();

            if (count($id_exist) == 0) {
                $this->db->query("insert ACC.TM_ACCOUNT_RECEIVABLE (CHR_ACC_REC , CHR_NAME , CHR_CREATE_USER , CHR_CREATE_DATE , CHR_CREATE_TIME) VALUES "
                    . "('$id' , '$rec_name' , '$user' ,  '$date_now' , '$time_now')");
                $msg = "1";
            } else {
                $this->db->query("update ACC.TM_ACCOUNT_RECEIVABLE SET  CHR_NAME = '$rec_name' ,CHR_FLAG_DELETE = '0' , CHR_MODIFIED_USER = '$user' , CHR_MODIFIED_DATE = '$date_now', CHR_MODIFIED_TIME = '$time_now' "
                    . "where CHR_ACC_REC = '$id'");
                $msg = "2";
            }
        }
        //delete data
        if (!$delete_id == null) {
            $this->db->query("update ACC.TM_ACCOUNT_RECEIVABLE SET  CHR_FLAG_DELETE = '1' , CHR_MODIFIED_USER = '$user' , CHR_MODIFIED_DATE = '$date_now', CHR_MODIFIED_TIME = '$time_now' "
                . "where CHR_ACC_REC = '$delete_id'");
            $msg = "3";
        }

        //      Message Info
        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Creating success </strong> The data is successfully created </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Updating success </strong> The data is successfully updated </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Deleted success </strong> The data is successfully deleted </div >";
        } elseif ($msg == 12) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Executing error !</strong> Something error with parameter </div >";
        } else {
            $msg = "";
        }

//        Get Data
        $master_data = $this->db->query("select * FROM ACC.TM_ACCOUNT_RECEIVABLE WHERE CHR_FLAG_DELETE = '0'")->result();
//      Parse to View
        $data['msg'] = $msg;
        $data['master_data'] = $master_data;
        $data['content'] = 'accounting/master_data/acc_rec_v';
        $this->load->view($this->layout, $data);
    }

    public function mapping_gl($id_equal = null)
    {
        $session = $this->session->all_userdata();
        $date_now = date("Ymd");
        $time_now = date("His");
        $user = $session['NPK'];

//        Load Parameter Default Page
        $this->role_module_m->authorization('246');
        $this->log_m->add_log(14, null);
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(246);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Manage Master Data ACC Receivable';
        $msg = "";

//      Process Data
        //insert, update data
        if ($this->input->post("btn_search")) {
            $id = $this->input->post("id_equal");
            redirect("accounting/master_data_c/mapping_gl/$id", "refresh");
        }

        //      Message Info
        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Creating success </strong> The data is successfully created </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Updating success </strong> The data is successfully updated </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Deleted success </strong> The data is successfully deleted </div >";
        } elseif ($msg == 12) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Executing error !</strong> Something error with parameter </div >";
        } else {
            $msg = "";
        }

        if (!$id_equal == null) {
            $master_data = $this->db->query("SELECT    ACC.TM_MAP_EQUAL_GL.CHR_ID_EQUALISASI, ACC.TM_MAP_EQUAL_GL.CHR_GL_ACCOUNT, ACC.TM_MAP_EQUAL_GL.CHR_CREATE_USER,
                      ACC.TM_MAP_EQUAL_GL.CHR_CREATE_DATE, ACC.TM_MAP_EQUAL_GL.CHR_CREATE_TIME, ACC.TM_MAP_EQUAL_GL.CHR_MODIFIED_USER,
                      ACC.TM_MAP_EQUAL_GL.CHR_MODIFIED_DATE, ACC.TM_MAP_EQUAL_GL.CHR_MODIFIED_TIME, ACC.TM_GL_ACCOUNT.CHR_NAME
                      FROM         ACC.TM_MAP_EQUAL_GL INNER JOIN
                      ACC.TM_GL_ACCOUNT ON ACC.TM_MAP_EQUAL_GL.CHR_GL_ACCOUNT = ACC.TM_GL_ACCOUNT.CHR_GL_ACCOUNT WHERE ACC.TM_MAP_EQUAL_GL.CHR_ID_EQUALISASI = '$id_equal'")->result();

            $nmaster_data = $this->db->query("select CHR_GL_ACCOUNT, CHR_NAME from ACC.TM_GL_ACCOUNT where CHR_GL_ACCOUNT not in (select CHR_GL_ACCOUNT FROM ACC.TM_MAP_EQUAL_GL where CHR_ID_EQUALISASI = '$id_equal')")->result();

//            Account Payable (VENDOR)
            if ($id_equal == "0008") {
                $master_data = $this->db->query("SELECT    ACC.TM_MAP_EQUAL_GL.CHR_ID_EQUALISASI, ACC.TM_MAP_EQUAL_GL.CHR_GL_ACCOUNT, ACC.TM_MAP_EQUAL_GL.CHR_CREATE_USER,
                      ACC.TM_MAP_EQUAL_GL.CHR_CREATE_DATE, ACC.TM_MAP_EQUAL_GL.CHR_CREATE_TIME, ACC.TM_MAP_EQUAL_GL.CHR_MODIFIED_USER,
                      ACC.TM_MAP_EQUAL_GL.CHR_MODIFIED_DATE, ACC.TM_MAP_EQUAL_GL.CHR_MODIFIED_TIME, ACC.TM_ACCOUNT_PAYABLE.CHR_NAME
                      FROM         ACC.TM_MAP_EQUAL_GL INNER JOIN
                      ACC.TM_ACCOUNT_PAYABLE ON ACC.TM_MAP_EQUAL_GL.CHR_GL_ACCOUNT = ACC.TM_ACCOUNT_PAYABLE.CHR_ACC WHERE ACC.TM_MAP_EQUAL_GL.CHR_ID_EQUALISASI = '$id_equal'")->result();

                $nmaster_data = $this->db->query("select CHR_ACC as CHR_GL_ACCOUNT, CHR_NAME from ACC.TM_ACCOUNT_PAYABLE where CHR_ACC not in (select CHR_GL_ACCOUNT FROM ACC.TM_MAP_EQUAL_GL where CHR_ID_EQUALISASI = '$id_equal')")->result();
            }

//            Account Receivable
            if ($id_equal == "0009") {
                $master_data = $this->db->query("SELECT    ACC.TM_MAP_EQUAL_GL.CHR_ID_EQUALISASI, ACC.TM_MAP_EQUAL_GL.CHR_GL_ACCOUNT, ACC.TM_MAP_EQUAL_GL.CHR_CREATE_USER,
                      ACC.TM_MAP_EQUAL_GL.CHR_CREATE_DATE, ACC.TM_MAP_EQUAL_GL.CHR_CREATE_TIME, ACC.TM_MAP_EQUAL_GL.CHR_MODIFIED_USER,
                      ACC.TM_MAP_EQUAL_GL.CHR_MODIFIED_DATE, ACC.TM_MAP_EQUAL_GL.CHR_MODIFIED_TIME, ACC.TM_ACCOUNT_RECEIVABLE.CHR_NAME
                      FROM         ACC.TM_MAP_EQUAL_GL INNER JOIN
                      ACC.TM_ACCOUNT_RECEIVABLE ON ACC.TM_MAP_EQUAL_GL.CHR_GL_ACCOUNT = ACC.TM_ACCOUNT_RECEIVABLE.CHR_ACC WHERE ACC.TM_MAP_EQUAL_GL.CHR_ID_EQUALISASI = '$id_equal'")->result();

                $nmaster_data = $this->db->query("select CHR_ACC as CHR_GL_ACCOUNT, CHR_NAME from ACC.TM_ACCOUNT_RECEIVABLE where CHR_ACC not in (select CHR_GL_ACCOUNT FROM ACC.TM_MAP_EQUAL_GL where CHR_ID_EQUALISASI = '$id_equal')")->result();
            }
        } else {
            $master_data = "";
            $nmaster_data = "";
        }

        if ($this->input->post("btn_update")) {
            foreach ($master_data as $value) {
                $gl_acc = trim($value->CHR_GL_ACCOUNT);
                $checked = $this->input->post("cb_dtb_$gl_acc");
                if (!(int) $checked == 1) {
                    $this->db->query("delete from ACC.TM_MAP_EQUAL_GL where CHR_ID_EQUALISASI = '$id_equal' and CHR_GL_ACCOUNT='$gl_acc' ");
                }
            }
        }
        if ($this->input->post("btn_add_gl")) {
            foreach ($nmaster_data as $value) {
                $gl_acc = trim($value->CHR_GL_ACCOUNT);
                $checked = $this->input->post("cb_add_live_$gl_acc");
                if ((int) $checked == 1) {
                    $this->db->query("insert into ACC.TM_MAP_EQUAL_GL (CHR_ID_EQUALISASI , CHR_GL_ACCOUNT , CHR_CREATE_USER , CHR_CREATE_DATE , CHR_CREATE_TIME , CHR_MODIFIED_USER , CHR_MODIFIED_DATE ,CHR_MODIFIED_TIME) "
                        . "VALUES "
                        . "('$id_equal' , '$gl_acc', '$user', '$date_now', '$time_now', '$user', '$date_now' , '$time_now')");
                }
            }
        }

        if (!$id_equal == null) {
            $master_data = $this->db->query("SELECT    ACC.TM_MAP_EQUAL_GL.CHR_ID_EQUALISASI, ACC.TM_MAP_EQUAL_GL.CHR_GL_ACCOUNT, ACC.TM_MAP_EQUAL_GL.CHR_CREATE_USER,
                      ACC.TM_MAP_EQUAL_GL.CHR_CREATE_DATE, ACC.TM_MAP_EQUAL_GL.CHR_CREATE_TIME, ACC.TM_MAP_EQUAL_GL.CHR_MODIFIED_USER,
                      ACC.TM_MAP_EQUAL_GL.CHR_MODIFIED_DATE, ACC.TM_MAP_EQUAL_GL.CHR_MODIFIED_TIME, ACC.TM_GL_ACCOUNT.CHR_NAME
                      FROM         ACC.TM_MAP_EQUAL_GL INNER JOIN
                      ACC.TM_GL_ACCOUNT ON ACC.TM_MAP_EQUAL_GL.CHR_GL_ACCOUNT = ACC.TM_GL_ACCOUNT.CHR_GL_ACCOUNT WHERE ACC.TM_MAP_EQUAL_GL.CHR_ID_EQUALISASI = '$id_equal'")->result();
            $nmaster_data = $this->db->query("select CHR_GL_ACCOUNT, CHR_NAME from ACC.TM_GL_ACCOUNT where CHR_GL_ACCOUNT not in (select CHR_GL_ACCOUNT FROM ACC.TM_MAP_EQUAL_GL where CHR_ID_EQUALISASI = '$id_equal')")->result();
            //            Account Payable (VENDOR)
            if ($id_equal == "0008") {
                $master_data = $this->db->query("SELECT    ACC.TM_MAP_EQUAL_GL.CHR_ID_EQUALISASI, ACC.TM_MAP_EQUAL_GL.CHR_GL_ACCOUNT, ACC.TM_MAP_EQUAL_GL.CHR_CREATE_USER,
                      ACC.TM_MAP_EQUAL_GL.CHR_CREATE_DATE, ACC.TM_MAP_EQUAL_GL.CHR_CREATE_TIME, ACC.TM_MAP_EQUAL_GL.CHR_MODIFIED_USER,
                      ACC.TM_MAP_EQUAL_GL.CHR_MODIFIED_DATE, ACC.TM_MAP_EQUAL_GL.CHR_MODIFIED_TIME, ACC.TM_ACCOUNT_PAYABLE.CHR_NAME
                      FROM         ACC.TM_MAP_EQUAL_GL INNER JOIN
                      ACC.TM_ACCOUNT_PAYABLE ON ACC.TM_MAP_EQUAL_GL.CHR_GL_ACCOUNT = ACC.TM_ACCOUNT_PAYABLE.CHR_ACC WHERE ACC.TM_MAP_EQUAL_GL.CHR_ID_EQUALISASI = '$id_equal'")->result();

                $nmaster_data = $this->db->query("select CHR_ACC as CHR_GL_ACCOUNT, CHR_NAME from ACC.TM_ACCOUNT_PAYABLE where CHR_ACC not in (select CHR_GL_ACCOUNT FROM ACC.TM_MAP_EQUAL_GL where CHR_ID_EQUALISASI = '$id_equal')")->result();
            }

//            Account Receivable
            if ($id_equal == "0009") {
                $master_data = $this->db->query("SELECT    ACC.TM_MAP_EQUAL_GL.CHR_ID_EQUALISASI, ACC.TM_MAP_EQUAL_GL.CHR_GL_ACCOUNT, ACC.TM_MAP_EQUAL_GL.CHR_CREATE_USER,
                      ACC.TM_MAP_EQUAL_GL.CHR_CREATE_DATE, ACC.TM_MAP_EQUAL_GL.CHR_CREATE_TIME, ACC.TM_MAP_EQUAL_GL.CHR_MODIFIED_USER,
                      ACC.TM_MAP_EQUAL_GL.CHR_MODIFIED_DATE, ACC.TM_MAP_EQUAL_GL.CHR_MODIFIED_TIME, ACC.TM_ACCOUNT_RECEIVABLE.CHR_NAME
                      FROM         ACC.TM_MAP_EQUAL_GL INNER JOIN
                      ACC.TM_ACCOUNT_RECEIVABLE ON ACC.TM_MAP_EQUAL_GL.CHR_GL_ACCOUNT = ACC.TM_ACCOUNT_RECEIVABLE.CHR_ACC WHERE ACC.TM_MAP_EQUAL_GL.CHR_ID_EQUALISASI = '$id_equal'")->result();

                $nmaster_data = $this->db->query("select CHR_ACC as CHR_GL_ACCOUNT, CHR_NAME from ACC.TM_ACCOUNT_RECEIVABLE where CHR_ACC not in (select CHR_GL_ACCOUNT FROM ACC.TM_MAP_EQUAL_GL where CHR_ID_EQUALISASI = '$id_equal')")->result();
            }
        } else {
            $master_data = "";
            $nmaster_data = "";
            $id_equal = "";
        }

//        Get Data
        $equaldata = $this->db->query("SELECT CHR_ID_EQUALISASI, CHR_NAME FROM ACC.TM_EQUALISASI where CHR_FLAG_DELETE = '0'")->result();
//      Parse to View
        $data['msg'] = $msg;
        $data['id_equal'] = $id_equal;
        $data['equaldata'] = $equaldata;
        $data['master_data'] = $master_data;
        $data['nmaster_data'] = $nmaster_data;
        $data['content'] = 'accounting/master_data/map_equal_gl_v';
        $this->load->view($this->layout, $data);
    }

}
