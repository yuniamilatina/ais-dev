<?php

class tranrmwho_c extends CI_Controller {
    /* -- define constructor -- */

    private $layout = '/template/head';

    public function __construct() {
        parent::__construct();

        $this->load->model('pes/prod_entry_m');
		$this->load->model('pes/tranrmwho_m');
        $this->load->model('organization/dept_m');
        $this->load->model(array('pes/display_m'));
        

        //$this->load->library('excel');
        $this->load->library('PHPExcel');

        $this->load->model('basis/log_m');
        $this->load->model('basis/role_module_m');
        
        $this->load->model('portal/news_m');
        $this->load->model('portal/notification_m');
    }

    public function index() {
        redirect("fail_c");
        $this->role_module_m->authorization('16');
        $this->session->userdata('user_id');

        $data['content'] = 'pes/dashboard_v1';
        $data['title'] = 'Production Entry System';

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(16);
        $data['news'] = $this->news_m->get_news();



        //$data['first_wcenter'] = $row->CHR_DEPT;

        if ($this->session->userdata('ROLE') == 4 || $this->session->userdata('ROLE') == 1) {
            $wcenter = $this->prod_entry_m->find('TOP(1) CHR_WCENTER_MN', '', 'CHR_WCENTER_MN');
        } else {
            $row = $this->dept_m->get_data_dept($this->session->userdata('DEPT'))->row();
            $data['dept_crop'] = substr($row->CHR_DEPT, 2, 1);
            $wcenter = $this->prod_entry_m->find('TOP(1) CHR_WCENTER_MN', 'CHR_PROD=' . $data['dept_crop'] . '', 'CHR_WCENTER_MN');
        }
        $data['first_wcenter'] = $wcenter[0]->CHR_WCENTER_MN;

        $this->load->view($this->layout, $data);
    }

    public function form($date = '', $shift = '', $w_center = '', $set = '', $filter = '') {
        
        $this->session->userdata('user_id');

        $data['content'] = 'pes/tranwhowip_v';
        $data['title'] = 'Transaksi Raw Material Execution';

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(16);
        $data['news'] = $this->news_m->get_news();


        $this->load->view($this->layout, $data);
    }

    public function whowip() {
		
		$this->session->userdata('user_id');

        $data['content'] = 'pes/whowip_v';
        $data['title'] = 'Transaksi Raw Material Execution';

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(16);
        $data['news'] = $this->news_m->get_news();
		
		$input = $this->input->post('barcode');
        $input2 = $this->input->post('qtybox');
        $id = $this->tranrmwho_m->addId();
        $number = 1;
  
        if ($input and $input2) {
                $barcode = $this->input->post('barcode');
                $qtybox = $this->input->post('qtybox');
                $jmlbarcode = strlen($barcode);
                $barcode_scan = explode(" ", $barcode);
                $count = count($barcode_scan); 
                $no = 1;
                $number= 1;

            // lokal
            if ($jmlbarcode == 185) {
                $pno = substr($barcode, 16,13);
                $bna = substr($barcode, 98,4);
                $qtyperbox = substr($barcode, 96,2);
                $menge = $qtyperbox * $qtybox;
                $type = 'L';
            }
            //ckd 
            elseif ($jmlbarcode == 130) {
                    $pno = substr($barcode, 0,11);
                    $bna = substr($barcode, 46,4);
                    $qtyperbox = substr($barcode, 21,2);
                    $menge = $qtyperbox * $qtybox;
                    $type = 'C';
            }
            // E-kanban
            elseif ($jmlbarcode == 40) {
                    $pno = substr($barcode, 19,11);
                    $bna = substr($barcode, 31,4);
                    $qtyperbox = trim($barcode_scan[6]);
                    $menge = $qtyperbox * $qtybox;
                    $type = 'E';
             }

             $t_data = array('CHR_PLANT'=>'600',
                            'CHR_DATE'=>date("Ymd"),
                            'CHR_NUMBER'=>$number,
                            'CHR_NUMBER_ITEM'=>$id,
                            'CHR_PART_NO'=> $pno,
                            'CHR_SLOC_FROM'=>'WH00',
                            'CHR_SLOC_TO'=>'WP01',
                            'CHR_BACK_NO'=>$bna,
                            'INT_QTY_PER_BOX'=>$qtyperbox,
                            'INT_QTY_BOX'=>$qtybox,
                            'CHR_IP'=>$_SERVER['SERVER_ADDR'],
                            'CHR_TIME_ENTRY'=>time("his"),
                            'CHR_DATE_UPLOAD'=>date("Ymd")
              );

            $this->tranrmwho_m->addProduct($t_data,'TW_GOODS_MOVEMENT_L');
            $table_data = $this->kanban_master_m->findBySql("select CHR_NUMBER_ITEM,CHR_PART_NO, from TM_PARTS ");   
            $data['table_data'] = $table_data;
               
        }

        elseif ($input == "FINISH") {
            $number++;
        }
        
       $this->load->view($this->layout,$data);
    }

    private function _redirect_if_not_logged_in() {
        if ($this->session->userdata('role_id') == '') {
            redirect('login/form');
        }
    }

}

?>