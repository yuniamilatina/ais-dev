<?php

class report_c extends CI_Controller {

    private $layout = '/template/head';
    private $back_to_manage = 'accounting/reporting_c/index';

    public function __construct() {
        parent::__construct();
        $this->load->model('accounting/master_data_m');
    }

    function index($msg = NULL) {
        $this->role_module_m->authorization('143');
        $this->log_m->add_log(14, NULL);
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

    function equalisasi_tax() {
        $session = $this->session->all_userdata();
        $date_now = date("Ymd");
        $time_now = date("His");
        $user = $session['NPK'];

//        Load Parameter Default Page
        $this->role_module_m->authorization('247');
        $this->log_m->add_log(14, NULL);
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(247);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Report Equalisai Tax';
        $msg = "";
        $doc_num_start = "";
        $doc_num_end = "";
        $fiscal_year_low = "";
        $fiscal_year_high = "";


        if ($this->input->post("search")) {
            $posting_date_start = date("Ymd", strtotime($this->input->post("posting_date_start")));
            $posting_date_end = date("Ymd", strtotime($this->input->post("posting_date_end")));

            $doc_num_start = $this->input->post("doc_num_start");
            $doc_num_end = $this->input->post("doc_num_end");

            // print_r(substr($doc_num_end, -2));
            // exit();

            if ($doc_num_end == '') {
                $doc_num_end = $doc_num_start;
            }

            $fiscal_year_low = $this->input->post("fiscal_year_start");
            $fiscal_year_high = $this->input->post("fiscal_year_end");
            if ($fiscal_year_high == '') {
                $fiscal_year_high = $fiscal_year_low;
            }

            $this->load->library(array('sapconn'));
            $werks = "600";
            $this->sapconn->connect();
            $this->sapconn->new_function('ZFM_WDE_ACC_ZZFIR007');
            $this->sapconn->import('S_BELNR_ARR', $doc_num_start);
            $this->sapconn->import('S_GJAHR_LOW', $fiscal_year_low);
            $this->sapconn->import('S_GJAHR_HIGH', $fiscal_year_high);
            $this->sapconn->import('S_BELNR_LOW1', "$doc_num_start");
            $this->sapconn->import('S_BELNR_LOW2', substr($doc_num_start, -2));
            $this->sapconn->import('S_BELNR_HIGH1', "$doc_num_end");
            $this->sapconn->import('S_BELNR_HIGH2', substr($doc_num_end, -2));
            $this->sapconn->import('S_BUDAT_LOW', $posting_date_start);
            $this->sapconn->import('S_BUDAT_HIGH', $posting_date_end);
            $this->sapconn->import('S_USER', $user);
            $this->sapconn->call();
        } else {
            $posting_date_start = date("Y/m/d");
            $posting_date_end = date("Y/m/d");
        }

        $posting_date_start = date("Y/m/d", strtotime($posting_date_start));
        $posting_date_end = date("Y/m/d", strtotime($posting_date_end));

//        Get Data
        $get_tm_equal = $this->db->query("select CHR_ID_EQUALISASI ,CHR_NAME from ACC.TM_EQUALISASI where CHR_FLAG_DELETE = '0' ORDER BY INT_ORDER_BY")->result();
        $get_no_doc = $this->db->query("select *
                                        from (
                                           select *,
                                                  row_number() over (partition by CHR_DOC_NO order by CHR_DOC_NO) as row_number
                                           from ACC.TW_EQUAL_TAX where CHR_USER = '$user' 
                                           ) as rows
                                        where row_number = 1")->result();
        $get_detail_data = $this->db->query("select * from   ACC.TW_EQUAL_TAX where CHR_USER = '$user'");
//      Parse to View
        $data['fiscal_year_start'] = $fiscal_year_low;
        $data['fiscal_year_end'] = $fiscal_year_high;
        $data['doc_num_start'] = $doc_num_start;
        $data['doc_num_end'] = $doc_num_end;
        $data['msg'] = $msg;
        $data['posting_date_start'] = $posting_date_start;
        $data['posting_date_end'] = $posting_date_end;
        $data['user'] = $user;
        $data['get_tm_equal'] = $get_tm_equal;
        $data['get_no_doc'] = $get_no_doc;


        $data['content'] = 'accounting/reporting/equal_tax_report_v';
        $this->load->view($this->layout, $data);
    }

}

?>
