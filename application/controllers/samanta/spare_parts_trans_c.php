<?php

class spare_parts_trans_c extends CI_Controller {
    
    private $layout = '/template/head';
    private $back_to_manage = 'samanta/spare_parts_trans_c/index/';    
   
    /* -- define constructor -- */
    public function __construct() {
        parent::__construct();
        $this->load->model('organization/dept_m');
        $this->load->model('samanta/spare_parts_m');
        $this->load->config('pdf_config');
        $this->load->library('fpdf/fpdf');
        define('FPDF_FONTPATH', $this->config->item('fonts_path'));
    }
    
    function search()
    {
        $get = $this->input->get('term');
        $loc = $this->input->get('loc');
        
        if ($get) {
            $result = $this->spare_parts_m->get_data_spare_parts($get,$loc);
            if (count($result) > 0) {
                foreach ($result as $res) {
                    $output[] = array(
                        'label' => $res->CHR_SPECIFICATION.'- '.$res->CHR_PART_NO,
                        'value' => $res->CHR_PART_NO,
                        'spek' => $res->CHR_SPECIFICATION,
                        'nama' => $res->CHR_SPARE_PART_NAME,
                        'compo' => $res->CHR_COMPONENT,
                        'price' => $res->CHR_PRICE
                    ); 
                }
                echo json_encode($output);
            }
        }
    }
    public function form($date = '', $sloc = '', $set = '', $filter = ''){
        $this->role_module_m->authorization('32');
        $db_samanta = $this->load->database("samanta", TRUE);

        if ($date == "" || $sloc == "" || $set == "") {
            $date = date("Ymd");
            $get_sloc = $db_samanta->query("SELECT TOP 1 CHR_SLOC FROM TT_SPARE_PARTS_SLOC ORDER BY CHR_SLOC ASC")->row();
            $getsloc = $get_sloc->CHR_SLOC;
            if ($getsloc != '') {
                redirect("samanta/spare_parts_trans_c/form/$date/$getsloc/0", "refresh");
            } else {
                redirect("fail_c/auth");
            }
        }

        $wsloc = $this->spare_parts_m->get_all_sloc(); 
        $parts = $this->spare_parts_m->get_all_parts_trans($date, $sloc);
        $full_parts = $this->spare_parts_m->get_data_all_spare_parts_full($sloc);

        $data['date'] = substr($this->uri->segment(4), 6, 2) . "/" . substr($this->uri->segment(4), 4, 2) . "/" . substr($this->uri->segment(4), 0, 4);
        $data['date_l'] = $this->uri->segment(4);
        $data['sloc2'] = $this->uri->segment(5);
        $data['set'] = $this->uri->segment(6);
        $data['w_sloc'] = $wsloc;
        $data['parts'] = $parts;
        $data['full_parts'] = $full_parts;
        $data['footer'] = '1';

        if ($this->input->post('btn_save') != '') {
            $this->processing_data($this->uri->segment(4), $this->uri->segment(5));
        }

        $this->session->userdata('user_id');
        $data['content'] = 'samanta/spare_parts_trans_v';
        $data['title'] = 'Samanta Transaction';

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(159);
        $data['news'] = $this->news_m->get_news();

        $this->load->view($this->layout, $data);
    }

    /*function get_autocomplete_sparepart(){
        if (isset($_GET['term'])) {
            $result = $this->spare_parts_m->get_data_all_spare_parts_2($_GET['term']);
            if (count($result) > 0) {
            foreach ($result as $row)
                $arr_result[] = $row->CHR_PART_NO . " - " . $row->CHR_SPECIFICATION;
                echo json_encode($arr_result);
            }
        }
    }*/

    function save_all_spare_part()
    {
        date_default_timezone_set("Asia/Jakarta");
        $time_now = date('His');
        $npk = $this->session->userdata('NPK');
        $location_from = "GR";
        $parts_no = $this->input->post('sparepart_val_no');
        $rack_no = "";
        $parts_name = $this->input->post('sparepart_val_name');
        $location_to = $this->input->post('location');
        $component =  $this->input->post('sparepart_val_comp');
        $type_trans = "IN";
        $sloc_trans = $this->input->post('location');
        $quantity = $this->input->post('quantity');
        $uom = "PC";
        $price = $this->input->post('sparepart_val_price');
        $entried_date = $this->input->post('date');
        $work_center = NULL;

        for($c=0; $c < count($parts_no);$c++)
        {
            if($component[$c]=="")
            {
                $component[$c] = NULL;
            }
            if($price[$c]=="")
            {
               $price[$c] = NULL; 
            }
            $data1 = array('CHR_PART_NO' => $parts_no[$c], 'CHR_SPARE_PART_NAME' => $parts_name[$c], 'CHR_LOCATION_FROM'=>$location_from, 'CHR_LOCATION_TO' => $location_to[$c], 'CHR_TYPE_TRANS'=>$type_trans, 'CHR_SLOC_TRANS'=>$sloc_trans[$c], 'INT_QTY'=>$quantity[$c], 'CHR_UOM'=>$uom,'CHR_ENTRIED_BY'=>$npk,'CHR_COMPONENT'=>$component[$c] ,'CHR_PRICE'=> $price[$c],'CHR_WORK_CENTER'=>$work_center, 'CHR_ENTRIED_DATE'=>$entried_date[$c], 'CHR_ENTRIED_TIME'=>$time_now);
           $this->spare_parts_m->save_all_data_part($data1);
           $this->spare_parts_m->update_sp_sloc($parts_no[$c],$sloc_trans[$c],$quantity[$c]);
        }
        redirect('samanta/spare_parts_trans_c/form/'.$entried_date[0].'/'.$sloc_trans[0].'/0');

    }


    private function processing_data($date) {
        date_default_timezone_set("Asia/Jakarta");
        $db_samanta = $this->load->database("samanta", TRUE);

        $date_now = date('Ymd');
        $time_now = date('His');
        $npk = $this->session->userdata('NPK');
        $user_name = $this->session->userdata('USERNAME');
        $arr_int_id = $this->input->post('int_id');
        $arr_rack_number = $this->input->post('rack_number');
        $arr_part_number = $this->input->post('part_number');
        $arr_qty_ok = $this->input->post('qty_ok');
        $arr_i = $this->input->post('i');
        for ($i = 1; $i <= $arr_i; $i++) {
            $part_number = $arr_part_number[$i];
            $int_id = $arr_int_id[$i];
            
            
            $qty_ok = str_replace(".", "", $arr_qty_ok[$i]);
            $check_samanta_trans = $this->spare_parts_m->get_data_by_part_trans($int_id);

            //logic ini perlu ada perombakan di sisi transaksi agar lebih mudah di baca 
            //sloc harus di pisah sebagai CHR_SLOC
            $sloc = $check_samanta_trans[0]->CHR_LOCATION_FROM;

            if (trim($check_samanta_trans[0]->CHR_TYPE_TRANS) == 'IN') {
                if ($qty_ok != ($check_samanta_trans[0]->INT_QTY)) {
                    //logic update stock di sloc
                    $check_spare_parts_inv = $this->spare_parts_m->get_data_by_part_sloc($part_number, $sloc);
                    
                    $qty_inv = $check_spare_parts_inv[0]->INT_QTY;

                    $qty_old = $check_samanta_trans[0]->INT_QTY;
                    $qty_inv_rev = $qty_inv - $qty_old;
                    $qty_inv_final = $qty_inv_rev + $qty_ok;

                    $db_samanta->query("UPDATE TT_SPARE_PARTS SET 
                                            INT_QTY = $qty_ok,
                                            CHR_MODIFIED_BY = '$user_name', 
                                            CHR_MODIFIED_DATE = '$date_now', 
                                            CHR_MODIFIED_TIME = '$time_now' 
                                            WHERE INT_ID = '$int_id'");

                    $db_samanta->query("UPDATE TT_SPARE_PARTS_SLOC SET 
                                            INT_QTY = '$qty_inv_final'
                                            WHERE CHR_PART_NO = '$part_number' AND CHR_SLOC = '$sloc'");
                }
            }
            elseif (trim($check_samanta_trans[0]->CHR_TYPE_TRANS) == 'OUT') {
                if ($qty_ok != ($check_samanta_trans[0]->INT_QTY)) {
                    //logic update stock di sloc
                    $check_spare_parts_inv = $this->spare_parts_m->get_data_by_part_sloc($part_number, $sloc);
                    $qty_inv = $check_spare_parts_inv[0]->INT_QTY;

                    $qty_old = $check_samanta_trans[0]->INT_QTY;
                    $qty_inv_rev = $qty_inv + $qty_old;
                    $qty_inv_final = $qty_inv_rev - $qty_ok;

                    $db_samanta->query("UPDATE TT_SPARE_PARTS SET 
                                            INT_QTY = $qty_ok, 
                                            CHR_MODIFIED_BY = '$npk', 
                                            CHR_MODIFIED_DATE = '$date_now', 
                                            CHR_MODIFIED_TIME = '$time_now' 
                                            WHERE INT_ID = '$int_id'");

                    $db_samanta->query("UPDATE TT_SPARE_PARTS_SLOC SET 
                                            INT_QTY = '$qty_inv_final'
                                            WHERE CHR_PART_NO = '$part_number' AND CHR_SLOC = '$sloc'");
                }
            }
        }
        redirect('samanta/spare_parts_trans_c/form/' . $this->uri->segment(4) . '/' . $this->uri->segment(5));
    }
}
