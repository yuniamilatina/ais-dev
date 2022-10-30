<?php

class ines_spps_c extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('part/part_customer_m');
        $this->load->model('kanban/kanban_m');
    }

    public function line($work_center = null) {
        $data['work_center'] = $work_center;
        $this->load->view('pes/ines_spps_v', $data);
    }

    public function checkExistingWI(){
        $part_no = trim($this->input->post('part_no'));
        $id_kanban = intval($this->input->post('id_kanban'));
        $type = $this->input->post('type');
        $serial = $this->input->post('serial');
        $wi = '';
        $base = $_SERVER['SERVER_NAME'];
        $url = explode('index',$_SERVER['REQUEST_URI']);
        $type_kanban = $this->input->post('type');
        $data = array('flg_scan_label' => false, 'flg_show_wi' => false, 'message' => false);

        $data_customer = $this->kanban_m->get_cust_by_barcode($id_kanban, $type, $serial);

        if($data_customer->num_rows() > 0){

            $cust_part_no = trim($data_customer->row()->CHR_CUS_PART_NO);
            $cust_no = trim($data_customer->row()->CHR_CUS_NO);

            $data['flg_scan_label'] = $this->part_customer_m->get_existing_master_label($part_no, $id_kanban, $serial);

            if($data['flg_scan_label'] == false){
                $master_wi = $this->part_customer_m->get_master_wi($part_no, $cust_no);

                if($master_wi->num_rows() > 0){
                    $this->part_customer_m->reset_coordinate_image($part_no);
                    $data['flg_show_wi'] = true;
                    $base_url_picture = "url('http://".$base.$url[0] . $master_wi->row()->CHR_IMG_FILE_NAME."')";
                    $wi .= "<div style=\"width:900px;height:660px;background-image: ".$base_url_picture.";background-size: 900px 660px;background-repeat: no-repeat;margin: 0px 0px 0px 0px;position:relative;\"></div>";

                    $base_url_nunjuk = 'http://'.$base.$url[0].'assets/img/pin.png';
                    $base_url_check = 'http://'.$base.$url[0].'assets/img/check1.png';

                    $cek = 1;
                    foreach ($master_wi->result() as $row) {
                        $top = $row->CHR_HEIGHT + 20;
                        $left = $row->CHR_WIDTH + 170;
                        $wi .= "<input type='image' id='$cek' src='$base_url_nunjuk'  class='img-button' style='cursor:pointer;width:60px;height:60px;position:absolute;top:".$top."px;left:".$left."px;' onclick='checkListCoordinate($row->INT_ID);this.src=\"$base_url_check\"' />";
                        $cek++;
                    }

                    $data['wi'] = $wi;
                }
            }

        }else{
            $data['message'] = 'Mohon pindai barcode produksi (kanban salah)';
        }

        if ('IS_AJAX') {
            echo json_encode($data);
        }
    }

    public function getDetailLabel() {
        $part_no = trim($this->input->post('part_no'));
        $abstract_barcode = trim($this->input->post('barcode_label'));
        $id_kanban = intval($this->input->post('id_kanban'));
        $serial = intval($this->input->post('serial'));
        $base = $_SERVER['SERVER_NAME'];
        $url = explode('index',$_SERVER['REQUEST_URI']);
        $wi = '';
        $data = array('status' => false, 'message' => false);

        if(substr($abstract_barcode,11,4) == '-001' && strlen($abstract_barcode) == 15){
            // $part_no_cust = 'D' . substr($abstract_barcode,0,11);
            $part_no_cust = substr($abstract_barcode,0,11);
            $part_no_cust =  (explode("-",$part_no_cust));
            $part_no_cust =  $part_no_cust[0].$part_no_cust[1];
        }else{
            $abstract_barcode_array =  (explode(" ",$abstract_barcode));
            $part_no_cust = trim(str_replace('%',' ',$abstract_barcode_array[0]));
            $part_no_cust = trim(str_replace('L',' ',$part_no_cust));
            $part_no_cust = trim(str_replace('Q',' ',$part_no_cust));
    
            if(strlen($part_no_cust) > 12){
                $part_no_cust = substr($part_no_cust,0,12);
            }
        }

        $master_wi = $this->part_customer_m->get_detail_wi_by_label(trim($part_no_cust), $part_no, $id_kanban, $serial);

        if ($master_wi->num_rows() > 0) {
                $data['status'] = true;
                $this->part_customer_m->reset_coordinate_image($part_no);
                $base_url_picture = "url('http://".$base.$url[0] . $master_wi->row()->CHR_IMG_FILE_NAME."')";
                $wi .= "<div style=\"width:900px;height:660px;background-image: ".$base_url_picture.";background-size: 900px 660px;background-repeat: no-repeat;margin: 0px 0px 0px 0px;position:relative;\"></div>";

                $base_url_nunjuk = 'http://'.$base.$url[0].'assets/img/pin.png';
                $base_url_check = 'http://'.$base.$url[0].'assets/img/check1.png';

                $cek = 1;
                foreach ($master_wi->result() as $row) {
                    $top = $row->CHR_HEIGHT + 20;
                    $left = $row->CHR_WIDTH + 170;
                    $wi .= "<input type='image' id='$cek' src='$base_url_nunjuk'  class='img-button' style='cursor:pointer;width:60px;height:60px;position:absolute;top:".$top."px;left:".$left."px;' onclick='checkListCoordinate($row->INT_ID);this.src=\"$base_url_check\"' />";
                    $cek++;
                }
                $data['wi'] = $wi;
        } else {
            $data['message'] = 'Barcode Label : '.$abstract_barcode . '('.$part_no_cust.'), tidak sesuai dengan master data part customer pada master data WI ';
        }

        if ('IS_AJAX') {
            echo json_encode($data);
        }
    }

    public function checkCoordinate(){
        $id_coordinate = $this->input->post('id_coordinate');
        $part_no = $this->input->post('part_no');

        $data['status'] = $this->part_customer_m->checklist_coordinate($id_coordinate);

        if($data['status'] == true){
            $this->part_customer_m->reset_coordinate_image($part_no);
        }

        if ('IS_AJAX') {
            echo json_encode($data);
        }

    }
    
}
