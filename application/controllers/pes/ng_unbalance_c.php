<?php

class ng_unbalance_c extends CI_Controller {
    /* -- define constructor -- */

    private $layout = '/template/head';

    public function __construct() {
        parent::__construct();

        $this->load->model('pes/ng_unbalance_m');
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
            redirect("pes/ng_unbalance_c/form/$date/$shift", "refresh");
        }
        
        
        $data['data_unbalance']= $this->ng_unbalance_m->get_data_unbalance($date, $shift);
        $data['date'] = substr($this->uri->segment(4), 6, 2) . "/" . substr($this->uri->segment(4), 4, 2) . "/" . substr($this->uri->segment(4), 0, 4);
        $data['date_l'] = $this->uri->segment(4);
        $data['shift'] = $this->uri->segment(5);
        $data['back_no'] = $this->ng_unbalance_m->get_part_unbalance();
        $data['content'] = 'pes/ng/ng_unbalance_v';
        $data['title'] = 'Entry Data Unbalance';

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(254);
        $data['news'] = $this->news_m->get_news();
        
        $this->load->view($this->layout, $data);
    }
    
    
    public function save_unb() {
     
        $session = $this->session->all_userdata();
        
        $back_no = $this->input->post('back_no');
        $part_no = $this->ng_unbalance_m->get_part_no($back_no)->part_no;
        $part_name = $this->ng_unbalance_m->get_part_name($part_no)->part_name;
        $qty = str_replace('.','',$this->input->post('qty'));
        $date = $this->input->post('date');
        $shift = $this->input->post('shift');
        $remarks = 'UNB'.$date.$back_no;
//        print_r($session);
//        exit();
       
        $data = array(
                'CHR_REMARKS' => $remarks,
                'CHR_DATE' => $date,
                'CHR_SHIFT' => $shift,
                'CHR_BACK_NO' => $back_no,
                'CHR_PART_NO' => $part_no,
                'CHR_PART_NAME' => $part_name,
                'INT_QTY' => $qty,
                'CHR_CREATED_BY' => $session['NPK'],
                'CHR_CREATED_DATE' => date('Ymd'),
                'CHR_MODIFIED_DATE' => date('Ymd'),
                'CHR_CREATED_TIME' => date('His'),
                'CHR_MODIFIED_TIME' => date('His')                
            );
        $data_movement_h = array(
                'CHR_PLANT' => "600",
                'CHR_DATE' => $date,
                'CHR_TYPE_TRANS' => "STRM",
                'CHR_REMARKS' => $remarks,
                'CHR_MVMT_TYPE' => "311",
                'CHR_IP' => $_SERVER['REMOTE_ADDR'],
                'CHR_USER' => 'WEB-ID01',
                'CHR_NPK' =>  $session['NPK'],
                'CHR_VALIDATE' => "X",
                'CHR_DATE_ENTRY' => date('Ymd'),
                'CHR_TIME_ENTRY' => date('His')
            );
        
        $this->ng_unbalance_m->save_unb($data);       
        $this->ng_unbalance_m->save_movement_h($data_movement_h);
        
        $header_key = $this->ng_unbalance_m->get_header_key($date, $remarks)->INT_NUMBER;
        
        $data_good_movement_l = array(
                   'INT_NUMBER' => $header_key,
                   'CHR_PART_NO' => $part_no,
                   'CHR_PART_NAME' => $part_name,
                   'CHR_SLOC_FROM' => "WP01",
                   'CHR_SLOC_TO' => "RE01",
                   'INT_TOTAL_QTY' => $qty,
                   'CHR_UOM' => 'PC',
                   'CHR_BACK_NO' => $back_no,
                   'CHR_IP' => $_SERVER['REMOTE_ADDR'],
                   'CHR_USER' => $session['NPK'],
                   'CHR_REMARKS_L' => $remarks,
                   'CHR_MVMT_TYPE_L' => '311',
                   'CHR_DATE_ENTRY' => date('Ymd'),
                   'CHR_TIME_ENTRY' => date('His')
               );
        $this->ng_unbalance_m->save_movement_l($data_good_movement_l);
        
        redirect("pes/ng_unbalance_c/form/$date/$shift", "refresh");
         
    }
    
    public function update_unb() {
     
        $session = $this->session->all_userdata();
        $id_unb = $this->input->post('id_unb');
        $part_no = $this->input->post('part_no');
        $part_name = $this->ng_unbalance_m->get_part_name_update($id_unb);
        $back_no = $this->input->post('back_no');
        $qty_before = $this->input->post('qty_before');        
        $qty = str_replace('.','',$this->input->post('qty'));
        $date = $this->input->post('date');
        $shift = $this->input->post('shift');
        $remarks = $this->input->post('remarks');
        $mov_typ = '311';
        $qty_reverse = 0;
        
        $qty_dif = $qty - $qty_before;
        
        //if qty_dif = minus
        if($qty_dif < 0 ){
            $mov_typ= '312'; //Reverse inventory
            $qty_reverse = abs($qty_dif);
        }
        
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
        
        
        $this->ng_unbalance_m->update($data, $id_unb);
        
        $data_movement_h = array(
                'CHR_PLANT' => "600",
                'CHR_DATE' => $date,
                'CHR_TYPE_TRANS' => "STRM",
                'CHR_MVMT_TYPE' => $mov_typ,
                'CHR_IP' => $_SERVER['REMOTE_ADDR'],
                'CHR_USER' => 'WEB-ID01',
                'CHR_REMARKS' => $remarks,
                'CHR_NPK' =>  $session['NPK'],
                'CHR_DATE_ENTRY' => date('Ymd'),
                'CHR_TIME_ENTRY' => date('His'),
                'CHR_VALIDATE' => "X"
             );
              
        $this->ng_unbalance_m->save_movement_h($data_movement_h);
        
        $header_key = $this->ng_unbalance_m->get_header_key($date,$remarks)->INT_NUMBER;
        $data_movement_l = array(
                   'INT_NUMBER' => $header_key,
                   'CHR_PART_NO' => $part_no,
                   'CHR_PART_NAME' => $part_name->part_name,
                   'CHR_SLOC_FROM' => "WP01",
                   'CHR_SLOC_TO' => "RE01",
                   'INT_TOTAL_QTY' => abs($qty_dif),
                   'CHR_UOM' => 'PC',
                   'CHR_BACK_NO' => $back_no,
                   'CHR_IP' => $_SERVER['REMOTE_ADDR'],
                   'CHR_USER' => $session['NPK'],
                   'CHR_MVMT_TYPE_L' => $mov_typ,
                   'CHR_REMARKS_L' => $remarks,
                   'CHR_DATE_ENTRY' => date('Ymd'),
                   'CHR_TIME_ENTRY' => date('His')
               );
        $this->ng_unbalance_m->save_movement_l($data_movement_l);
        
        redirect("pes/ng_unbalance_c/form/$date/$shift", "refresh");
         
    }


}

?>