<?php

class spare_parts_sto_c extends CI_Controller {
    
    private $layout = '/template/head';
    private $back_to_manage = 'samanta/spare_parts_sto_c/index/';
    private $layout_blank = '/template/head_blank';

    /* -- define constructor -- */
    public function __construct() {
        parent::__construct();
        $this->load->model('organization/dept_m');
        $this->load->model('samanta/spare_parts_m');
        $this->load->config('pdf_config');
        $this->load->library('fpdf/fpdf');
        define('FPDF_FONTPATH', $this->config->item('fonts_path'));
    }

    public function index($msg = NULL) {
        $this->role_module_m->authorization('3');

        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Generate stock opname data success </strong>, The data is successfully generated</div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Updating success </strong> The data is successfully updated </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Deleted success </strong> The data is successfully deleted </div >";
        } else {
            $msg = NULL;
        }
        $data['msg'] = $msg;
        
        $all_area = $this->spare_parts_m->get_data_area_sto();

        $data['selected_area'] = $all_area;
        $data['all_area'] = $all_area;
        
        $data['freeze_value'] = $this->spare_parts_m->get_freeze_value()->row();
        $data['pi_value'] = $this->spare_parts_m->get_pi_value()->row();
        $data['var_value'] = $this->spare_parts_m->get_var_value()->row();

        $data['total_part'] = $this->spare_parts_m->get_total_part()->row();
        $data['counted'] = $this->spare_parts_m->get_counted_part()->row();
       

        $data['sto_list'] = $this->spare_parts_m->get_data_spare_parts_sto()->result();
        $data['title'] = 'Stock Opname Spare Parts';
        $data['content'] = 'samanta/stock_opname/spare_parts_sto_v';
        $data['news'] = $this->news_m->get_news();
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(293);
        
        $this->load->view($this->layout, $data);
    }

    function search_sto($msg = NULL, $sloc = NULL) {
        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Generate stock opname data success </strong>, The data is successfully generated</div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Updating success </strong> The data is successfully updated </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Deleted success </strong> The data is successfully deleted </div >";
        } else {
            $msg = NULL;
        }
        $data['msg'] = $msg;

        if ($sloc == 'ALL') {
            redirect($this->back_to_manage);
        }
        //$selected_area = $this->spare_parts_m->get_data_area_sto_by_sloc($sloc);
        $all_area = $this->spare_parts_m->get_data_area_sto();

        $data['selected_area'] = $sloc;
        $data['all_area'] = $all_area;

        $data['freeze_value'] = $this->spare_parts_m->get_freeze_value_by_sloc($sloc)->row();
        $data['pi_value'] = $this->spare_parts_m->get_pi_value_by_sloc($sloc)->row();
        $data['var_value'] = $this->spare_parts_m->get_var_value_by_sloc($sloc)->row();

        $data['total_part'] = $this->spare_parts_m->get_total_part_by_sloc($sloc)->row();
        $data['counted'] = $this->spare_parts_m->get_counted_part_by_sloc($sloc)->row();

        $data['sto_list'] = $this->spare_parts_m->get_data_spare_parts_sto_by_sloc($sloc)->result();
        $data['title'] = 'Stock Opname Spare Parts';
        $data['content'] = 'samanta/stock_opname/spare_parts_sto_v';
        $data['news'] = $this->news_m->get_news();
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(293);
        
        $this->load->view($this->layout, $data);

    }

    // start
    function generate_sto($area) {
        $db_samanta = $this->load->database("samanta", TRUE);
        $npk = $this->session->userdata('NPK');
        $var = 1;

        //$data_tt_list_order = $this->spare_parts_m->check_id_event($var);
        $db_samanta->query("TRUNCATE TABLE TW_SPARE_PARTS_STO");
        $db_samanta->query("TRUNCATE TABLE TT_SPARE_PARTS_STO");

        $db_samanta->query("INSERT INTO TW_SPARE_PARTS_STO (
                                    CHR_PART_NO,
                                    CHR_SLOC,
                                    CHR_RACK_NO
                                )
                                SELECT R.CHR_PART_NO, S.CHR_SLOC, R.CHR_RACK_NO FROM TM_SPARE_PARTS_ROUTING R INNER JOIN TT_SPARE_PARTS_SLOC S ON S.CHR_PART_NO = R.CHR_PART_NO
                                WHERE S.CHR_SLOC = '$area'");

        // $db_samanta->query("INSERT INTO TW_SPARE_PARTS_STO (
        //                             CHR_PART_NO,
        //                             CHR_SLOC,
        //                             CHR_RACK_NO
        //                         )
        //                         SELECT R.CHR_PART_NO, S.CHR_SLOC, R.CHR_RACK_NO FROM TM_SPARE_PARTS_ROUTING R INNER JOIN TT_SPARE_PARTS_SLOC S ON S.CHR_PART_NO = R.CHR_PART_NO
        //                         WHERE S.CHR_SLOC = 'MT02'");

        // $db_samanta->query("INSERT INTO TW_SPARE_PARTS_STO (
        //                             CHR_PART_NO,
        //                             CHR_SLOC,
        //                             CHR_RACK_NO
        //                         )
        //                         SELECT R.CHR_PART_NO, S.CHR_SLOC, R.CHR_RACK_NO FROM TM_SPARE_PARTS_ROUTING R INNER JOIN TT_SPARE_PARTS_SLOC S ON S.CHR_PART_NO = R.CHR_PART_NO
        //                         WHERE S.CHR_SLOC = 'MT03'");

        $db_samanta->query("INSERT INTO TT_SPARE_PARTS_STO (
                                    ID_EVENT,
                                    CHR_PART_NO,
                                    CHR_SLOC,
                                    INT_QTY_FREEZE
                                ) 
                                SELECT CONVERT(VARCHAR(6), GETDATE(), 112) AS ID_EVENT, R.CHR_PART_NO, S.CHR_SLOC, S.INT_QTY FROM TM_SPARE_PARTS R INNER JOIN TT_SPARE_PARTS_SLOC S ON S.CHR_PART_NO = R.CHR_PART_NO
                                WHERE S.CHR_SLOC = '$area'");

        redirect($this->back_to_manage . $msg=1);
    }

    function upload_sto() {
        $db_samanta = $this->load->database("samanta", TRUE);
        $npk = $this->session->userdata('NPK');
        $date_now = date("Ymd");
        $time_now = date("His");

        $get_sto_data = $this->spare_parts_m->get_sto_data()->result();

        foreach ($get_sto_data as $value_sto) {
            $part_no = trim($value_sto->CHR_PART_NO);
            $sloc = trim($value_sto->CHR_SLOC);
            $qty_sto = $value_sto->INT_QTY_STO;

            $check_exist = $db_samanta->query("SELECT * FROM TT_SPARE_PARTS_SLOC WHERE CHR_PART_NO = '$part_no' AND CHR_SLOC = '$sloc'")->num_rows();
            if ($check_exist > 0) {
                $db_samanta->query("UPDATE TT_SPARE_PARTS_SLOC SET
                                            INT_QTY = '$qty_sto',
                                            CHR_ENTRIED_BY = 'UPLOAD_STO',
                                            CHR_ENTRIED_DATE = '$date_now',
                                            CHR_ENTRIED_TIME = '$time_now'
                                            WHERE CHR_PART_NO = '$part_no' AND CHR_SLOC = '$sloc'");
            }
            else {

            }
        }
        redirect($this->back_to_manage . $msg=2);
    }
    // end
}
