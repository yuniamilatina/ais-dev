<?php

class entry_ng_purging_c extends CI_Controller {
    /* -- define constructor -- */

    private $layout = '/template/head';

    public function __construct() {
        parent::__construct();

        $this->load->model('pes/prod_entry_purging_m');
        $this->load->model('organization/dept_m');
        $this->load->library('PHPExcel');
        $this->load->model('goods_movement/goods_movement_l_m');
        $this->load->model('goods_movement/goods_movement_h_m');
    }

    public function form($date = '', $shift = '') {
        $this->role_module_m->authorization('32');
        if ($date == "" || $shift == "") {
            $date = date("Ymd");
            $shift = "1";
            redirect("pes/entry_ng_purging_c/form/$date/$shift", "refresh");
        }
        
       
        $get_part_purging = $this->prod_entry_purging_m->get_part_purging();
        $data['data_purging']= $this->prod_entry_purging_m->get_data_purging($date,$shift);
        $data['date'] = substr($this->uri->segment(4), 6, 2) . "/" . substr($this->uri->segment(4), 4, 2) . "/" . substr($this->uri->segment(4), 0, 4);
        $data['date_l'] = $this->uri->segment(4);
        $data['shift'] = $this->uri->segment(5);
        $data['part_purging'] = $get_part_purging;
        $data['content'] = 'pes/ng/entry_ng_purging_v';
        $data['title'] = 'Entry Data Purging';

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(172);
        $data['news'] = $this->news_m->get_news();

        $this->load->view($this->layout, $data);
    }
    
    
    public function add_list_purging() {
     
        $session = $this->session->all_userdata();
       
        $part_no = $this->input->post('back_no');
        $part_name = $this->prod_entry_purging_m->get_part_name($part_no);
        $qty = str_replace('.','',$this->input->post('qty'));
        $date = $this->input->post('date');
        $shift = $this->input->post('shift');
        $remarks = 'P'.$date.$part_no;
//        print_r($session);
//        exit();
       
        $data = array(
                'CHR_PART_NO' => $part_no,
                'CHR_PART_NAME' => $part_name->part_name,
                'INT_QTY' => $qty,
                'CHR_SHIFT' => $shift,
                'CHR_CREATED_BY' => $session['NPK'],
                'CHR_CREATED_DATE' => date('Ymd'),
                'CHR_MODIFIED_DATE' => date('Ymd'),
                'CHR_CREATED_TIME' => date('His'),
                'CHR_REMARKS' => $remarks,
                'CHR_MODIFIED_TIME' => date('His'),
                'CHR_DATE_PURGING' => $date
            );
        $data_his = array(
                'CHR_PART_NO' => $part_no,
                'CHR_PART_NAME' => $part_name->part_name,
                'INT_QTY' => $qty,
                'CHR_SHIFT' => $shift,
                'CHR_CREATED_BY' => $session['NPK'],
                'CHR_CREATED_DATE' => date('Ymd'),
                'CHR_CREATED_TIME' => date('His'),
                'CHR_REMARKS' => $remarks,
                'CHR_STATUS' => 'INSERT',
                'CHR_DATE_PURGING' => $date
            );
        $data_movement_h = array(
                'CHR_PLANT' => "600",
                'CHR_DATE' => $date,
                'CHR_TYPE_TRANS' => "STRM",
                'CHR_MVMT_TYPE' => "311",
//              'CHR_IP' => $session['ip_address'],
                'CHR_IP' => $_SERVER['REMOTE_ADDR'],
                'CHR_USER' => 'WEB-ID01',
                'CHR_REMARKS' => $remarks,
                'CHR_NPK' =>  $session['NPK'],
                'CHR_DATE_ENTRY' => date('Ymd'),
                'CHR_TIME_ENTRY' => date('His'),
                'CHR_VALIDATE' => "X"
            );
        
        $this->prod_entry_purging_m->save($data);
        $this->prod_entry_purging_m->save_history($data_his);        
        $this->prod_entry_purging_m->save_movement_h($data_movement_h);
        
        $header_key = $this->prod_entry_purging_m->get_header_key($date,$remarks)->INT_NUMBER;
        $data_good_movement_l = array(
                   'INT_NUMBER' => $header_key,
                   'CHR_PART_NO' => $part_no,
                   'CHR_PART_NAME' => $part_name->part_name,
                   'CHR_SLOC_FROM' => "WP01",
                   'CHR_SLOC_TO' => "RE01",
                   'INT_TOTAL_QTY' => $qty,
                   'CHR_UOM' => 'G',
                   'CHR_BACK_NO' => $part_no,
                   'CHR_IP' => $_SERVER['REMOTE_ADDR'],
                   'CHR_USER' => 'PURGE',
                   'CHR_REMARKS_L' => $remarks,
                   'CHR_MVMT_TYPE_L' => '311',
                   'CHR_DATE_ENTRY' => date('Ymd'),
                   'CHR_TIME_ENTRY' => date('His')
               );
        $this->prod_entry_purging_m->save_movement_l($data_good_movement_l);
        
        redirect("pes/entry_ng_purging_c/form/$date/$shift", "refresh");
         
    }
    
    public function update_list_purging() {
     
        $session = $this->session->all_userdata();
       
        $part_no = $this->input->post('back_no');
        $Idupdate = $this->input->post('idupdate');
        $qty_before = $this->input->post('qty_before');
        $part_name = $this->prod_entry_purging_m->get_part_name($part_no);
        $qty = str_replace('.','',$this->input->post('qty'));
        $date = $this->input->post('date');
        $shift = $this->input->post('shift');
        $remarks = $this->input->post('remarks');
        
        $mov_typ = '311'; //Add inventory
        $status = 'UPDATE';
        $qty_reverse = 0;
        
        $selisih = $qty - $qty_before;
        
        //Jika selisih minus (kurang dari 0)
        if($selisih < 0 ){
            $mov_typ= '312'; //Reverse inventory
            $status= 'REVERSE';
            $qty_reverse = abs($selisih);
        }
        
//        print_r($selisih);
//        exit();
        
        $data = array(
                'CHR_PART_NO' => $part_no,
                'CHR_PART_NAME' => $part_name->part_name,
                'INT_QTY' => $qty,            
                'INT_QTY_REVERSE' => $qty_reverse,
                'CHR_SHIFT' => $shift,
                'CHR_MODIFIED_BY' => $session['NPK'],
                'CHR_MODIFIED_DATE' => date('Ymd'),
                'CHR_MODIFIED_TIME' => date('His')
            );
        
        $data_his_update = array(
                'CHR_PART_NO' => $part_no,
                'CHR_PART_NAME' => $part_name->part_name,
                'INT_QTY' => abs($selisih),
                'CHR_SHIFT' => $shift,
                'CHR_CREATED_BY' => $session['NPK'],
                'CHR_CREATED_DATE' => date('Ymd'),
                'CHR_CREATED_TIME' => date('His'),
                'CHR_REMARKS' => $remarks,
                'CHR_STATUS' => $status,
                'CHR_DATE_PURGING' => $date
            );            
         
        $this->prod_entry_purging_m->update($data,$Idupdate);
        $this->prod_entry_purging_m->save_history($data_his_update);
        
        $data_movement_h = array(
                'CHR_PLANT' => "600",
                'CHR_DATE' => $date,
                'CHR_TYPE_TRANS' => "STRM",
                'CHR_MVMT_TYPE' => $mov_typ,
//              'CHR_IP' => $session['ip_address'],
                'CHR_IP' => $_SERVER['REMOTE_ADDR'],
                'CHR_USER' => 'WEB-ID01',
                'CHR_REMARKS' => $remarks,
                'CHR_NPK' =>  $session['NPK'],
                'CHR_DATE_ENTRY' => date('Ymd'),
                'CHR_TIME_ENTRY' => date('His'),
                'CHR_VALIDATE' => "X"
             );
               
        $this->prod_entry_purging_m->save_movement_h($data_movement_h);
        
        $header_key = $this->prod_entry_purging_m->get_header_key($date,$remarks)->INT_NUMBER;
        $data_good_movement_l = array(
                   'INT_NUMBER' => $header_key,
                   'CHR_PART_NO' => $part_no,
                   'CHR_PART_NAME' => $part_name->part_name,
                   'CHR_SLOC_FROM' => "WP01",
                   'CHR_SLOC_TO' => "RE01",
                   'INT_TOTAL_QTY' => abs($selisih),
                   'CHR_UOM' => 'G',
                   'CHR_BACK_NO' => $part_no,
                   'CHR_IP' => $_SERVER['REMOTE_ADDR'],
                   'CHR_USER' => 'PURGE',
                   'CHR_MVMT_TYPE_L' => $mov_typ,
                   'CHR_REMARKS_L' => $remarks,
                   'CHR_DATE_ENTRY' => date('Ymd'),
                   'CHR_TIME_ENTRY' => date('His')
               );
        $this->prod_entry_purging_m->save_movement_l($data_good_movement_l);
        
        redirect("pes/entry_ng_purging_c/form/$date/$shift", "refresh");
         
    }


}

?>