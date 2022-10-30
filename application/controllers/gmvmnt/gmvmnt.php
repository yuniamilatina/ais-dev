<?php

class gmvmnt extends CI_Controller {
    /* -- define constructor -- */

    private $layout = '/template/head';
	//private $back_to_manage = 'pes/promasdat_c/line_stop/';
	//private $back_to_ng = 'pes/promasdat_c/ng/';

    public function __construct() {
        parent::__construct();

        //$this->load->model('pes/prod_entry_m');
		//$this->load->model('pes/prodmasdat_m');
        $this->load->model('organization/dept_m');
        $this->load->model(array('pes/display_m'));
        $this->load->library('form_validation');

        //$this->load->library('excel');
        //$this->load->library('PHPExcel');

        $this->load->model('basis/log_m');
        $this->load->model('basis/role_module_m');
        
        $this->load->model('portal/news_m');
        $this->load->model('portal/notification_m');

        //$this->load->helper(array('url', 'dompdf'));
        $this->load->helper(array('form', 'url', 'download', 'inflector', 'dompdf'));
    }

    public function report($start_date = null, $finish_date = null) {
        $this->role_module_m->authorization('16');
        $this->session->userdata('user_id');
		$this->load->library('form_validation');
redirect("fail_c");
        $data['content'] = 'gmvmnt/gmvmnt_v';
        $data['title'] = 'Error Log Good Movement';

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(114);
        $data['news'] = $this->news_m->get_news();

        if ($this->input->post('btn_filter_by_date')) {
            $start_date = $this->input->post('start_date');
            $finish_date = $this->input->post('finish_date');
            $start_date = date("Ymd", strtotime($start_date));
            $finish_date = date("Ymd", strtotime($finish_date));
            redirect("gmvmnt/gmvmnt/report/$start_date/$finish_date", "refresh");
        }

        if ($start_date == null and $finish_date == null) {
            $start_date = date("Ymd");
            $finish_date = date("Ymd");
        }else if ($start_date == '' and $finish_date == '') {
            $start_date = date("Ymd");
            $finish_date = date("Ymd");
        }else if ($start_date == null) {
            $start_date = date("Ymd");
        }else if ($finish_date == null) {
            $finish_date = date("Ymd");
        }

        //$reportqc = $this->db->query("SELECT * FROM TT_QCE_H WHERE CHR_CREATE_DATE BETWEEN '$start_date' AND '$finish_date'")->result();
        // $errorq = $this->db->query("SELECT * FROM TT_GOODS_MOVEMENT_H AS A INNER JOIN TT_GOODS_MOVEMENT_L AS B
        //     ON A.INT_NUMBER = B.INT_NUMBER WHERE (B.CHR_STATUS = 'E' OR B.CHR_PICK_STATUS = 'E')
        //     AND B.CHR_DATE_UPLOAD BETWEEN '$start_date' AND '$finish_date'")->result();

        $errorq = $this->db->query("SELECT * FROM [DB_AIS].[dbo].[TT_GOODS_MOVEMENT_H] AS A INNER JOIN [DB_AIS].[dbo].[TT_GOODS_MOVEMENT_L] AS B 
            ON A.INT_NUMBER = B.INT_NUMBER WHERE (((B.CHR_STATUS = 'E' OR B.CHR_PICK_STATUS='E' ) 
            AND A.CHR_TYPE_TRANS <> 'STNG' ) OR (B.CHR_STATUS = 'E' AND A.CHR_TYPE_TRANS = 'STNG' AND B.INT_TOTAL_QTY<>'0') ) 
            AND (B.CHR_DATE_UPLOAD BETWEEN '$start_date' AND '$finish_date')")->result();
        
        // $getint = $this->db->query("SELECT * 
        //                             from TT_GOODS_MOVEMENT_H 
        //                             WHERE CHR_TYPE_TRANS <> ' ' or 
        //                                   CHR_TYPE_TRANS is null ")->result();

        // if (!empty($getint)) {
        //   foreach ($getint as  $value) {
        //     $typetrans = $value->CHR_TYPE_TRANS;
        //     $intnumber = $value->INT_NUMBER;
        //     $this->db->query("UPDATE TT_GOODS_MOVEMENT_L SET 
        //                              CHR_TYPE_TRANS_L      = '$typetrans'
        //                       WHERE  INT_NUMBER            = '$intnumber' and 
        //                              CHR_TYPE_TRANS_L      = ' '  ");
        //   }
        // }

        // $this->db->query("UPDATE TT_GOODS_MOVEMENT_L SET 
        //                          CHR_UPLOAD           = 'X'
        //                   WHERE  CHR_STATUS           = 'E' and
        //                          CHR_UPLOAD           = '0' ");  
        $data['error'] = $errorq;
        $data['start_date'] = $start_date;
        $data['finish_date'] = $finish_date;

        $this->load->view($this->layout, $data);
    }
}

?>