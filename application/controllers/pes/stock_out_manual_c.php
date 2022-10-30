<?php

class stock_out_manual_c extends CI_Controller {
    /* -- define constructor -- */

    private $layout = '/template/head';

    public function __construct() {
        parent::__construct();

        $this->load->model('pes/stock_out_manual_m');
        $this->load->model('organization/dept_m');
        $this->load->library('form_validation');

        //$this->load->library('excel');
        $this->load->library('PHPExcel');

        $this->load->model('basis/log_m');
        $this->load->model('basis/role_module_m');

        $this->load->model('portal/news_m');
        $this->load->model('portal/notification_m');
    }

    public function index() {
        $this->role_module_m->authorization('16');
        $this->session->userdata('user_id');
        $this->load->library('form_validation');

        $data['content'] = 'pes/stock_out_manual_v';
        $data['title'] = 'Stock Out Manual';

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(110);
        $data['news'] = $this->news_m->get_news();
        $data['sloc'] = $this->stock_out_manual_m->getSloc();
        $this->load->view($this->layout, $data);
    }

    function save_stock() {
        $status = true;
        $linekosong = false;
        $d = array();
        $a = array();
        $x = 0;
        $backNo = $this->input->post('BACK_NO');
        $partNo = $this->input->post('PART_NO');
        $partName = $this->input->post('PART_NAME');
        $qty = $this->input->post('QTY');
        $location = $this->input->post('LOCATION');
        //cek data
        for ($x = 0; $x < count($backNo); $x++) {
            $t_data = array('CHR_BACK_NO' => $backNo[$x]);
            $inserttw = $this->stock_out_manual_m->addProduct($t_data, 'TW_STOCK_OUT_MANUAL');

            if (!$this->check_line($backNo[$x])) {
                $status = false;
                $d[$x] = $x;
            }
            //if ($backNo[$x] != ''){
            if (empty($backNo[$x]) || empty($qty[$x]) || empty($location[$x]) || empty($partNo[$x])) {
                $linekosong = true;
                $status = false;
                $a[$x] = $x + 1;
            }
            //}
        }
        if ($status == true) {
            $user_session = $this->session->all_userdata();
            for ($i = 0; $i < count($backNo); $i++) {
                // insert
                $this->db->trans_begin(); # Starting Transaction
                $this->db->trans_strict(FALSE); # See Note 01. If you wish can remove as well
                // Note 01 : By default Codeigniter runs all transactions in Strict Mode. 
                // When strict mode is enabled, if you are running multiple groups of transactions, 
                // if one group fails all groups will be rolled back. If strict mode is disabled, 
                // each group is treated independently, 
                // meaning a failure of one group will not affect any others.
                $TT_GOODS_MOVEMENT_H = array(
                    'CHR_PLANT' => '600',
                    'CHR_DATE' => date("Ymd"),
                    'CHR_TYPE_TRANS' => 'STRM',
                    'CHR_REMARKS' => 'X',
                    'CHR_MVMT_TYPE' => '311',
                    'CHR_VALIDATE' => 'X',
                    'CHR_IP' => $_SERVER['REMOTE_ADDR'],
                    'CHR_USER' => $user_session["USERNAME"],
                    'CHR_NPK' => $user_session["NPK"],
                        // 'CHR_UPLOAD' => '0', /DELETE BY REZA REQ ALBERT 02/05/2016 INI BEDA DENGAN QAS DAN DEV!!!!
                        // 'CHR_STATUS'  => 'N'
                );
                $this->db->insert('TT_GOODS_MOVEMENT_H', $TT_GOODS_MOVEMENT_H);
                $getInt_Number = $this->db->insert_id();
                $TT_GOODS_MOVEMENT_L = array(
                    'INT_NUMBER' => $getInt_Number,
                    'CHR_PART_NO' => $partNo[$i],
                    // 'CHR_PART_NAME'  => 'STRM', //add by ghina 30/05/2016
                    'CHR_PART_NAME' => $partName[$i],
                    'CHR_PART_NO_TO' => $partNo[$i],
                    'INT_TOTAL_QTY' => $qty[$i],
                    'CHR_SLOC_FROM' => 'WH00',
                    'CHR_SLOC_TO' => $location[$i],
                    'CHR_BACK_NO' => strtoupper($backNo[$i]),
                    'CHR_DATE_ENTRY' => date("Ymd"),
                    'CHR_TIME_ENTRY' => date("his"),
                    'CHR_IP' => $_SERVER['REMOTE_ADDR'],
                    'CHR_USER' => $user_session["USERNAME"],
                    'CHR_UPLOAD' => '0',
                    // 'CHR_STATUS'  => 'N' DELETE BY REZA REQ ALBERT 02/05/2016 INI BEDA DENGAN QAS DAN DEV!!!!
                    'CHR_COMPLETE_STATUS' => 'N'
                );
                $this->db->insert('TT_GOODS_MOVEMENT_L', $TT_GOODS_MOVEMENT_L);
                $TT_STOCK_OUT_MANUAL_H = array(
                    'CHR_DATE_CREATE' => date("Ymd"),
                    'CHR_TIME_CREATE' => date("his"),
                    'CHR_IPUSER' => $_SERVER['REMOTE_ADDR'],
                    'CHR_USERID' => $user_session["NPK"],
                    'CHR_USERNAME' => $user_session["USERNAME"],
                );
                $this->db->insert('TT_STOCK_OUT_MANUAL_H', $TT_STOCK_OUT_MANUAL_H);
                $getInt_NumberTt = $this->db->insert_id();
                $TT_STOCK_OUT_MANUAL_L = array(
                    'INT_NUMBER' => $getInt_NumberTt,
                    'CHR_BACK_NO' => $backNo[$i],
                    'CHR_PART_NO' => $partNo[$i],
                    'CHR_PART_NAME' => $partName[$i],
                    'INT_QTY' => $qty[$i],
                    'CHR_SLOC_TO' => $location[$i]
                );
                $this->db->insert('TT_STOCK_OUT_MANUAL_L', $TT_STOCK_OUT_MANUAL_L);

                $this->db->trans_complete(); # Completing transaction						
                if ($this->db->trans_status() === FALSE) {
                    # Something went wrong.
                    $this->db->trans_rollback();
                    //return FALSE;
                } else {
                    # Everything is Perfect. 
                    # Committing data to the database.
                    //return confirm ("Data Telah Tersimpan");
                    //$this->db->trans_commit();
                    $this->db->trans_commit();
                }
            }
        } else {
            $status = "Sorry, Your data at line " . implode(",", $d) . " already exists, please choose another one";
            if ($linekosong) {
                // $status = "Silakan lengkapi data pada Row " .implode(",",$a);
                $status = 3;
            }
        }
        $this->stock_out_manual_m->DeleteData("DELETE FROM TW_STOCK_OUT_MANUAL");
        echo json_encode($status);
    }

    //Checking Section LIne Stop
    function check_line($back) {
        $return_value = $this->stock_out_manual_m->check_id_line($back);
        if ($return_value) {
            $this->form_validation->set_message('check_line', "Sorry, Your data " . $back . " already exists, please choose another one");
            return FALSE;
        } else {
            return TRUE;
        }
    }

    function get_data() {
        $backNo = $this->input->post('id');
        $getData = $this->stock_out_manual_m->findBySql("select TM_KANBAN.* , TM_PARTS.CHR_PART_NAME, TM_PARTS.CHR_PART_UOM from TM_KANBAN INNER JOIN TM_PARTS ON TM_KANBAN.CHR_PART_NO = TM_PARTS.CHR_PART_NO  where TM_KANBAN.CHR_BACK_NO = '$backNo' AND CHR_KANBAN_TYPE = '0'");
//        $getData = $this->stock_out_manual_m->findBySql("select * from TM_PARTS where CHR_BACK_NO = '$backNo'");
//		$partNo = $getData['CHR_PART_NO'];
//		$partName = $getData['CHR_PART_NAME'];
        echo json_encode($getData);
    }

}

?>	