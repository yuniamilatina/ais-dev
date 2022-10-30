<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class samalona_c extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('kanban/kanban_m');
        $this->load->model('basis/user_m');
        $this->load->model('prd/pis_pos_material_m');
        $this->load->model('prd/setup_chute_m');
        $this->load->model('prd/pos_material_m');
        $this->load->model('prd/pos_m');
        $this->load->model('prd/pos_line_activity_m');
        // $this->load->model('prd/pos_history_scan_m');
    }

    public function index(){
        redirect('prd/samalona_c/pos/LINE', 'refresh');
    }

    public function pos($wc = null, $pos = null) {
        $data['wc'] = $wc;
        $data['pos'] = $pos;
        $data['dateprod'] = date('Ymd');
        $this->load->view('prd/samalona/samalona_v', $data);
	}

    public function check_npk() {
        $npk = $this->input->post('npk');

        $data = array('npk_exist' => false, 'dateprod' => null);

        $data['npk_exist'] = $this->user_m->get_npk($npk);
        $data['dateprod'] = date('Ymd');

        if ('IS_AJAX') {
            echo json_encode($data);
        }
    }

    function registration(){
        $npk = $this->input->post('npk');
        $wc = $this->input->post('wc');
        $pos = $this->input->post('pos');

        $this->pos_line_activity_m->start_activity($wc, $pos, $npk);

        if ('IS_AJAX') {
            echo json_encode(true);
        }
    }

    function reset_dandori(){
        $work_center = $this->input->post('wc');
        $pos = $this->input->post('pos');

        $data = $this->pis_pos_material_m->update_reset_dandori($work_center, $pos);

        if ('IS_AJAX') {
            echo json_encode($data);
        }
    }

    //check existing uncomplete setup chute
    function check_blockage(){
        $date = $this->input->post('date');
        $work_center = $this->input->post('wc');
        $pos = $this->input->post('pos');
        $data = '';

        $data_send = array('blockage_history_chtue' => false, 'message' => false);

        //get blockage setup chute history
        $history = $this->pis_pos_material_m->get_history_blockage_chute($work_center, $date, $pos);
                
        if ($history->num_rows() > 0 && $history->num_rows() < 11) {
            $x = 0;
            $data .="<tr>";
            foreach ($history->result() as $value) {
                $data .="<td>$value->CHR_BACK_NO</td>";
                $x++;
            }
            $data .="</tr>";
        } else if ($history->num_rows() > 10 && $history->num_rows() < 21) {
            $x = 0;
            foreach ($history->result() as $value) {
                $x++;
                if ($x > 0 && $x < 11) {
                    if ($x == 1) {
                        $data .="<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == 10) {
                        $data .="<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_BACK_NO</td>";
                    }
                } else {
                    if ($x == 11) {
                        $data .="<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == $history->num_rows()) {
                        $data .="<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_BACK_NO</td>";
                    }
                }
            }
        } else if ($history->num_rows() > 20 && $history->num_rows() < 31) {
            $x = 0;
            foreach ($history->result() as $value) {
                $x++;
                if ($x > 0 && $x < 11) {
                    if ($x == 1) {
                        $data .="<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == 10) {
                        $data .="<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_BACK_NO</td>";
                    }
                } else if ($x > 10 && $x < 21) {
                    if ($x == 11) {
                        $data .="<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == 20) {
                        $data .="<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_BACK_NO</td>";
                    }
                } else {
                    if ($x == 21) {
                        $data .="<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == $history->num_rows()) {
                        $data .="<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_BACK_NO</td>";
                    }
                }
            }
        } else if ($history->num_rows() > 30 && $history->num_rows() < 41) {
            $x = 0;
            foreach ($history->result() as $value) {
                $x++;
                if ($x > 0 && $x < 11) {
                    if ($x == 1) {
                        $data .="<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == 10) {
                        $data .="<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_BACK_NO</td>";
                    }
                } else if ($x > 10 && $x < 21) {
                    if ($x == 11) {
                        $data .="<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == 20) {
                        $data .="<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_BACK_NO</td>";
                    }
                } else if ($x > 20 && $x < 31) {
                    if ($x == 21) {
                        $data .="<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == 30) {
                        $data .="<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_BACK_NO</td>";
                    }
                } else {
                    if ($x == 31) {
                        $data .="<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == $history->num_rows()) {
                        $data .="<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_BACK_NO</td>";
                    }
                }
            }
        } else if ($history->num_rows() > 40 && $history->num_rows() < 51) {
            $x = 0;
            foreach ($history->result() as $value) {
                $x++;
                if ($x > 0 && $x < 11) {
                    if ($x == 1) {
                        $data .="<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == 10) {
                        $data .="<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_BACK_NO</td>";
                    }
                } else if ($x > 10 && $x < 21) {
                    if ($x == 11) {
                        $data .="<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == 20) {
                        $data .="<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_BACK_NO</td>";
                    }
                } else if ($x > 20 && $x < 31) {
                    if ($x == 21) {
                        $data .="<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == 30) {
                        $data .="<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_BACK_NO</td>";
                    }
                } else if ($x > 30 && $x < 41) {
                    if ($x == 31) {
                        $data .="<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == 40) {
                        $data .="<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_BACK_NO</td>";
                    }
                } else {
                    if ($x == 41) {
                        $data .="<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == $history->num_rows()) {
                        $data .="<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_BACK_NO</td>";
                    }
                }
            }
        } else if ($history->num_rows() > 50 && $history->num_rows() < 61) {
            $x = 0;
            foreach ($history->result() as $value) {
                $x++;
                if ($x > 0 && $x < 11) {
                    if ($x == 1) {
                        $data .="<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == 10) {
                        $data .="<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_BACK_NO</td>";
                    }
                } else if ($x > 10 && $x < 21) {
                    if ($x == 11) {
                        $data .="<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == 20) {
                        $data .="<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_BACK_NO</td>";
                    }
                } else if ($x > 20 && $x < 31) {
                    if ($x == 21) {
                        $data .="<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == 30) {
                        $data .="<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_BACK_NO</td>";
                    }
                } else if ($x > 30 && $x < 41) {
                    if ($x == 31) {
                        $data .="<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == 40) {
                        $data .="<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_BACK_NO</td>";
                    }
                } else if ($x > 40 && $x < 51) {
                    if ($x == 41) {
                        $data .="<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == 50) {
                        $data .="<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_BACK_NO</td>";
                    }
                } else {
                    if ($x == 51) {
                        $data .="<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == $history->num_rows()) {
                        $data .="<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_BACK_NO</td>";
                    }
                }
            }
        } else if ($history->num_rows() > 60 && $history->num_rows() < 71) {
            $x = 0;
            foreach ($history->result() as $value) {
                $x++;
                if ($x > 0 && $x < 11) {
                    if ($x == 1) {
                        $data .="<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == 10) {
                        $data .="<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_BACK_NO</td>";
                    }
                } else if ($x > 10 && $x < 21) {
                    if ($x == 11) {
                        $data .="<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == 20) {
                        $data .="<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_BACK_NO</td>";
                    }
                } else if ($x > 20 && $x < 31) {
                    if ($x == 21) {
                        $data .="<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == 30) {
                        $data .="<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_BACK_NO</td>";
                    }
                } else if ($x > 30 && $x < 41) {
                    if ($x == 31) {
                        $data .="<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == 40) {
                        $data .="<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_BACK_NO</td>";
                    }
                } else if ($x > 40 && $x < 51) {
                    if ($x == 41) {
                        $data .="<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == 50) {
                        $data .="<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_BACK_NO</td>";
                    }
                } else if ($x > 50 && $x < 61) {
                    if ($x == 51) {
                        $data .="<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == 60) {
                        $data .="<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_BACK_NO</td>";
                    }
                } else {
                    if ($x == 61) {
                        $data .="<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == $history->num_rows()) {
                        $data .="<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_BACK_NO</td>";
                    }
                }
            }
        } else {
            $x = 0;
            foreach ($history->result() as $value) {
                $x++;
                if ($x > 0 && $x < 11) {
                    if ($x == 1) {
                        $data .="<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == 10) {
                        $data .="<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_BACK_NO</td>";
                    }
                } else if ($x > 10 && $x < 21) {
                    if ($x == 11) {
                        $data .="<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == 20) {
                        $data .="<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_BACK_NO</td>";
                    }
                } else if ($x > 20 && $x < 31) {
                    if ($x == 21) {
                        $data .="<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == 30) {
                        $data .="<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_BACK_NO</td>";
                    }
                } else if ($x > 30 && $x < 41) {
                    if ($x == 31) {
                        $data .="<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == 40) {
                        $data .="<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_BACK_NO</td>";
                    }
                } else if ($x > 40 && $x < 51) {
                    if ($x == 41) {
                        $data .="<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == 50) {
                        $data .="<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_BACK_NO</td>";
                    }
                } else if ($x > 50 && $x < 61) {
                    if ($x == 51) {
                        $data .="<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == 60) {
                        $data .="<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_BACK_NO</td>";
                    }
                } else if ($x > 60 && $x < 71) {
                    if ($x == 61) {
                        $data .="<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == 70) {
                        $data .="<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_BACK_NO</td>";
                    }
                } else {
                    if ($x == 71) {
                        $data .="<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == $history->num_rows()) {
                        $data .="<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_BACK_NO</td>";
                    }
                }
            }
        }


        if ($history->num_rows() > 0){
            $data .="</table>";
        }

        $data_send['blockage_history_chtue'] = str_replace('\/', '/', $data);

        //edited by toros 20190423
        if($history->num_rows() > 0){
            $data_send['message'] = 'Komponen belum seluruhnya selesai, Mohon untuk melengkapinya.';
        }

        if ('IS_AJAX') {
            echo json_encode($data_send);
        }
    }

    //normal dandori by click button popup trigger
    function do_normal_dandori(){
        $date = $this->input->post('date');
        $work_center = $this->input->post('wc');
        $pos = $this->input->post('pos');
        $base = $_SERVER['SERVER_NAME'];
        $url = explode('index',$_SERVER['REQUEST_URI']);
        $component = '';
        $count = 0;
        $count_finish = 0;
        $fg = '';

        $data = array('data_setup_chute' => false, 'message' => false, 'component' => false , 'count' => 0 , 'count_finish' => 0 , 'prd_order_no' => false );

        //can distribute data when not exist
        $mother_of_setup_chute = $this->setup_chute_m->get_next_setup_chute($work_center, $date, $pos);

        //new chute
        if ($mother_of_setup_chute->num_rows() > 0) {
            $prd_order_no = $mother_of_setup_chute->row()->CHR_PRD_ORDER_NO;
            $part_no_fg = $mother_of_setup_chute->row()->CHR_PART_NO;

            $master_pos = $this->pos_m->check_existing_pos_by_part_no($part_no_fg);
            if($master_pos->num_rows() > 0){

                $master_pos_material = $this->pos_material_m->check_existing_pos_material_by_part_no($part_no_fg);
                if($master_pos_material->num_rows() > 0){

                    $master_elina = $this->pis_pos_material_m->check_existing_elina_by_wo($prd_order_no);
                    if($master_elina->num_rows() > 0){
                        $data_chute_material = $this->pis_pos_material_m->generate_setup_chute_material($prd_order_no, $work_center, $pos, $part_no_fg);

                        //insert into PIS POS MATERIAL
                        foreach($data_chute_material as $isi){
    
                            if($isi->INT_FLG_IGNORE_SCAN == 1){
                                $box_actual = $isi->INT_ORDER_BOX;
                                $flg_finish = 1;
                            }else{
                                $box_actual = 0;
                                $flg_finish = $isi->INT_FLG_FINISH;
                            }

                            $data_pos = array(
                                'CHR_WORK_CENTER' => $work_center,
                                'CHR_POS_PRD' => $pos,
                                'CHR_DATE' => $isi->CHR_DATE,
                                'CHR_PRD_ORDER_NO' => $isi->CHR_PRD_ORDER_NO,
                                'CHR_PART_NO_FG' => $isi->CHR_PART_NO,
                                'CHR_PART_NO_SA' => $isi->CHR_PART_NO_SA,
                                'CHR_BACK_NO_SA' => $isi->CHR_BACK_NO_SA,
                                'CHR_BACK_NO_FG' => $isi->CHR_BACK_NO,
                                'CHR_IMG_FG_URL' => $isi->CHR_IMG_FILE_NAME,
                                'CHR_PART_NO_COMP' => $isi->CHR_PART_NO_COMP,
                                'CHR_BACK_NO_COMP' => $isi->CHR_BACK_NO_COMP,
                                'CHR_IMG_COMP_URL' => $isi->CHR_IMAGE_PIS_URL,
                                'INT_QTY_PLAN' => $isi->INT_ORDER_PCS,
                                'INT_QTY_ACTUAL' => 0,
                                'INT_BOX_PLAN' => $isi->INT_ORDER_BOX,
                                'INT_BOX_ACTUAL' => $box_actual,
                                'INT_QTY_PCS' => 0,
                                'INT_FLG_IGNORE_SCAN' => $isi->INT_FLG_IGNORE_SCAN,
                                'INT_FLG_FINISH' =>$flg_finish,
                                'CHR_CREATED_BY' => $work_center.'/'.$isi->CHR_DATE.'/'.$pos
                            );
            
                            $this->pis_pos_material_m->save($data_pos);
                        }
            
                        //update setup chute
                        $this->pis_pos_material_m->get_setup_chute_komponen($work_center, $pos);

                        //mapping to view
                        $data_chute_material = $this->pis_pos_material_m->get_data_ready_dandori($work_center, $date, $pos, $prd_order_no);
                        
                        if ($data_chute_material->num_rows() > 0) {
            
                                $data['data_setup_chute'] =  $data_chute_material->row();
            
                                $count = $this->pis_pos_material_m->get_total_component_by_pos($pos, $prd_order_no);
                                $count_finish = $this->pis_pos_material_m->get_total_finish_component_by_pos($pos, $prd_order_no);
            
                                $fg_pict = "http://".$base.$url[0] . "assets/img/no_prod.png";
                            
                                $fg .= "<img src=".$fg_pict." style='max-width:60%;'>";
            
                                foreach($data_chute_material->result() as $isi){
            
                                    if($isi->CHR_PART_NO_SA == NULL){
                                        $back_no = trim($isi->CHR_BACK_NO_COMP);
                                    }else{
                                        $back_no = substr(trim($isi->CHR_BACK_NO_SA), 0, 5);
                                    }
    
                                    $array_img_component = $this->pis_pos_material_m->get_image_component_by_part_no_comp_and_pos($isi->CHR_PART_NO_FG, $isi->CHR_BACK_NO_COMP, $pos, $work_center);
    
                                    if($array_img_component->num_rows() > 0){
                                        $component_image = trim($array_img_component->row()->CHR_IMAGE_PIS_URL) . "?id=".rand(10, 1000);
                                    }else{
                                        $component_image = "http://".$base.$url[0] . trim($isi->CHR_IMG_COMP_URL) . "?id=".rand(10, 1000);
                                    }
    
                                    $mark_picture = "http://".$base.$url[0] . "assets/img/ng_summary.png";
            
                                    $component .= "<li id='$isi->INT_ID' class='side-bar-component'>";
                                    $component .= "<table style='width:100%;border-color:white;border: 1px;font-size:15px; letter-spacing: 15px;background:#FFEB40;'><tr><td>".trim($back_no)."</td></tr></table>";
                                    $component .= "<div class='sekunder-image'>";
                                    $component .= '<img src='.$component_image.' class="image-component"; onclick="show_img_comp_to_center(\''.$isi->INT_ID.'\');">';
                                    $component .= "<div class='sidebar-bottom-right-comp'>";
                                    //$component .= "<img src=".$mark_picture." alt='check' style='width:45%;'>";
                                    $component .= "</div>";
                                    $component .= "</div>";
                                    $component .= "<table style='width:100%;border-color:white;font-size:12px;'><tr style='font-style: italic;'><td style='background:#00FC9B;color:#000000;'>PLAN</td><td style='background:#E84447;color:#FFF'>ACTL</td></tr><tr style='height:50px;font-size:18pt;'><td style='background:#00FC9B;color:#000000;'>".$isi->INT_BOX_PLAN." BOX</td><td style='background:#E84447;color:#FFF;'>".$isi->INT_BOX_ACTUAL." BOX</td></tr></table>";
                                    $component .= "</li>";
            
                                }
            
                                $data['component'] = $component;
                                $data['count'] = $count;
                                $data['count_finish'] =$count_finish;
                                $data['fg'] = $fg;
                                $data['prd_order_no'] = $prd_order_no;
            
                        } else {
                            $data['message'] = 'Error Code 1 - Data setup chute komponen tidak ada';
                        }
                    }else{
                        $data['message'] = 'Error Code 2 - Data elina belum ada, Part komponen belum di prepare';
                    }
                }else{
                    $data['message'] = 'Error Code 3 - Data Mapping komponen dengan pos tidak ada';
                }
            }else{
                $data['message'] = 'Error Code 4 - Data Master pos tidak ada';
            }
        } else {
            $data['message'] = 'Error Code 5 Setup Chute tidak ditemukan.';
        }

        if ('IS_AJAX') {
            echo json_encode($data);
        }
    }

    //direct dandori by click button popup trigger
    function do_direct_dandori(){
        $date = $this->input->post('date');
        $work_center = $this->input->post('wc');
        $pos = $this->input->post('pos');
        $base = $_SERVER['SERVER_NAME'];
        $url = explode('index',$_SERVER['REQUEST_URI']);
        $prd_order_no = $this->input->post('prd_order_no');
        $component = '';
        $count = 0;
        $count_finish = 0;
        $fg = '';

        $data = array('data_setup_chute' => true, 'message' => false, 'component' => false ,'count' => 0 , 'count_finish' => 0, 'prd_order_no' => false );

        //mapping to view
        $data_chute_material = $this->pis_pos_material_m->get_data_ready_dandori($work_center, $date, $pos, $prd_order_no);
    
        if ($data_chute_material->num_rows() > 0) {
                $data['data_setup_chute'] =  $data_chute_material->row();

                $count = $this->pis_pos_material_m->get_total_component_by_pos($pos, $prd_order_no);
                $count_finish = $this->pis_pos_material_m->get_total_finish_component_by_pos($pos, $prd_order_no);
    
                $fg_pict = "http://".$base.$url[0] . "assets/img/no_prod.png";
            
                $fg .= "<img src=".$fg_pict." style='max-width:60%;'>";
    
                foreach($data_chute_material->result() as $isi){

                    $array_img_component = $this->pis_pos_material_m->get_image_component_by_part_no_comp_and_pos($isi->CHR_PART_NO_FG, $isi->CHR_BACK_NO_COMP, $pos, $work_center);

                    if($array_img_component->num_rows() > 0){
                        $component_image = trim($array_img_component->row()->CHR_IMAGE_PIS_URL) . "?id=".rand(10, 1000);
                    }else{
                        $component_image = "http://".$base.$url[0] . trim($isi->CHR_IMG_COMP_URL) . "?id=".rand(10, 1000);
                    }

                    $mark_picture = "http://".$base.$url[0] . "assets/img/ng_summary.png";
    
                    if($isi->INT_BOX_ACTUAL == $isi->INT_BOX_PLAN){
                        $mark_picture = "http://".$base.$url[0] . "assets/img/ok_summary.png";

                        $component .= "<li id='$isi->INT_ID' class='side-bar-component'>";
                        $component .= "<table style='width:100%;border-color:white;border: 1px;font-size:15px; letter-spacing: 15px;background:#FFEB40;'><tr><td>".trim($isi->CHR_BACK_NO_COMP)."</td></tr></table>";
                        $component .= "<div class='sekunder-image'>";
                        $component .= '<img src='.$component_image.' class="image-component"; onclick="show_img_comp_to_center(\''.$isi->INT_ID.'\');">';
                        $component .= "<div class='sidebar-bottom-right-comp'>";
                        //$component .= "<img src=".$mark_picture." alt='check' style='width:45%;'>";
                        $component .= "</div>";
                        $component .= "</div>";
                        $component .= "<table style='width:100%;border-color:white;font-size:12px;'><tr style='font-style: italic;'><td style='background:#00FC9B;color:#000000;'>PLAN</td><td style='background:#00FC9B;color:#000000;'>ACTL</td></tr><tr style='height:50px;font-size:18pt;'><td style='background:#00FC9B;color:#000000;'>".$isi->INT_BOX_PLAN." BOX</td><td style='background:#00FC9B;color:#000000;'>".$isi->INT_BOX_ACTUAL." BOX</td></tr></table>";
                        $component .= "</li>";
                    }else if($isi->INT_BOX_ACTUAL == 0 && $isi->INT_FLG_FINISH == 0){
                        $mark_picture = "http://".$base.$url[0] . "assets/img/ng_summary.png";

                        $component .= "<li id='$isi->INT_ID' class='side-bar-component'>";
                        $component .= "<table style='width:100%;border-color:white;border: 1px;font-size:15px; letter-spacing: 15px;background:#FFEB40;'><tr><td>".trim($isi->CHR_BACK_NO_COMP)."</td></tr></table>";
                        $component .= "<div class='sekunder-image'>";
                        $component .= '<img src='.$component_image.' class="image-component"; onclick="show_img_comp_to_center(\''.$isi->INT_ID.'\');">';
                        $component .= "<div class='sidebar-bottom-right-comp'>";
                        //$component .= "<img src=".$mark_picture." alt='check' style='width:45%;'>";
                        $component .= "</div>";
                        $component .= "</div>";
                        $component .= "<table style='width:100%;border-color:white;font-size:12px;'><tr style='font-style: italic;'><td style='background:#00FC9B;color:#000000;'>PLAN</td><td style='background:#E84447;color:#FFF'>ACTL</td></tr><tr style='height:50px;font-size:18pt;'><td style='background:#00FC9B;color:#000000;'>".$isi->INT_BOX_PLAN." BOX</td><td style='background:#E84447;color:#FFF;'>".$isi->INT_BOX_ACTUAL." BOX</td></tr></table>";
                        $component .= "</li>";
                    }else{
                        $mark_picture = "http://".$base.$url[0] . "assets/img/onprogress_summary.png";

                        $component .= "<li id='$isi->INT_ID' class='side-bar-component'>";
                        $component .= "<table style='width:100%;border-color:white;border: 1px;font-size:15px; letter-spacing: 15px;background:#FFEB40;'><tr><td>".trim($isi->CHR_BACK_NO_COMP)."</td></tr></table>";
                        $component .= "<div class='sekunder-image'>";
                        $component .= '<img src='.$component_image.' class="image-component"; onclick="show_img_comp_to_center(\''.$isi->INT_ID.'\');">';
                        $component .= "<div class='sidebar-bottom-right-comp'>";
                        //$component .= "<img src=".$mark_picture." alt='check' style='width:45%;'>";
                        $component .= "</div>";
                        $component .= "</div>";
                        $component .= "<table style='width:100%;border-color:white;font-size:12px;'><tr style='font-style: italic;'><td style='background:#00FC9B;color:#000000;'>PLAN</td><td style='background:#008FD7;color:#FFF'>ACTL</td></tr><tr style='height:50px;font-size:18pt;'><td style='background:#00FC9B;color:#000000;'>".$isi->INT_BOX_PLAN." BOX</td><td style='background:#008FD7;color:#FFF;'>".$isi->INT_BOX_ACTUAL." BOX</td></tr></table>";
                        $component .= "</li>";
                    }
                }
    
                $data['component'] = $component;
                $data['count'] = $count;
                $data['count_finish'] = $count_finish;
                $data['fg'] = $fg;
                $data['prd_order_no'] = $prd_order_no;
    
        } else {
            $data['message'] = 'Error Code 1.A - Data setup chute komponen tidak ada';
        }

        if ('IS_AJAX') {
            echo json_encode($data);
        }
    }

    function check_order_no(){
        $data_setup_chute['CHR_WORK_CENTER'] =  $this->input->post('wc');
        $data_setup_chute['CHR_POS_PRD'] =  $this->input->post('pos');
        $prd_order_no =  $this->input->post('prd_order_no');
       
        $data_order_no = $this->pis_pos_material_m->get_first_order_no($data_setup_chute);

        //check prd order no
        if($data_order_no->num_rows() > 0){
            if(trim($prd_order_no) == trim($data_order_no->row()->CHR_PRD_ORDER_NO)){
                $data['prd_order_no'] = true;
            }else{
                $data['prd_order_no'] = false;
                $data['message'] = 'Order no tidak sesuai dengan ' .$prd_order_no;
            }
        }else{
            $data['prd_order_no'] = false;
            $data['message'] = 'Kanban tidak sesuai';
        }

        if ('IS_AJAX') {
            echo json_encode($data);
        }
    }

    //lookup kanban and save history kanban
    function lookup_history_scan(){
        $history_data['CHR_WORK_CENTER'] =  $this->input->post('wc');
        $history_data['CHR_POS_PRD'] =  $this->input->post('pos');
        $history_data['CHR_PRD_ORDER_NO'] =  $this->input->post('prd_order_no');
        $history_data['CHR_BARCODE'] =  $this->input->post('kanban');

        $data = array('existing_kanban' => false, 'message' => false);

        // $data_history_scan = $this->pos_history_scan_m->get_data($history_data);

        //check history kanban had scan
        // if($data_history_scan->num_rows() > 0){
        //     $data['existing_kanban'] = true;
        //     $data['message'] = 'Kanban telah dipindai, mohon pindai kanban lain';
        // }

        if ('IS_AJAX') {
            echo json_encode($data);
        }

    }

    //scan kanban and validation logic
    public function go_scan_kanban() {
        $kanban_combine = $this->input->post('kanban_combine');
        $id_kanban = $this->input->post('id_kanban');
        $tipe = $this->input->post('series');
        $serial = $this->input->post('serial');
        $work_center = $this->input->post('wc');
        $dateprod = $this->input->post('dateprod');
        $pos = $this->input->post('pos');
        $prd_order_no = $this->input->post('prd_order_no');
        $npk = $this->input->post('npk');
        $component = '';
        $count = 0;
        $count_finish = 0;
        $fg = '';
        $partno = '';
        $plan_box_active = 0;
        $actual_box_active = 0;
        $back_no_comp = 0;
        $base = $_SERVER['SERVER_NAME'];
        $url = explode('index',$_SERVER['REQUEST_URI']);
        $history_data['CHR_WORK_CENTER'] =  $work_center;
        $history_data['CHR_POS_PRD'] =  $pos;
        $history_data['CHR_PRD_ORDER_NO'] =  $prd_order_no;
        $history_data['CHR_BARCODE'] =  $kanban_combine;
        $history_data['CHR_CREATED_BY'] =  $npk;
        $history_data['CHR_CREATED_DATE'] =  date('Ymd');
        $history_data['CHR_CREATED_TIME'] =  date('His');
        $key_pos_work_center['CHR_WORK_CENTER'] =  $work_center;
        $key_pos_work_center['CHR_POS_PRD'] =  $pos;
        $error_flg['INT_FLG_ERROR'] = 1;
        $normal_flg['INT_FLG_ERROR'] = 0;
        $partno_sa = null;

        $status_kanban = '';

        $data = array('data_setup_chute' => false, 'message' => false, 'component' => false, 'count' => 0 , 'count_finish' => 0,
            'fg' => false, 'actual_box_active' => 0, 'plan_box_active' => 0, 'back_no_comp' => false  );

        if(strlen($id_kanban) > 10 && strlen($serial) > 10){
            $partno = $serial;
            $status_kanban = '1';
        }elseif(strlen($id_kanban) == 11 && strlen($tipe) > 3 && strlen($tipe) < 7){
            $partno = $serial;
            $status_kanban = '2';
        }elseif(strlen($id_kanban) == 8 && strlen($tipe) == 6){
            $partno = $serial;
            $status_kanban = '3';
        }elseif(strlen($id_kanban) > 10 && strlen($serial) < 10){
            $partno = $id_kanban;
            $status_kanban = '4';
        }elseif(strlen($id_kanban) < 10 && strlen($serial) > 10){
            $partno = $serial;
            $status_kanban = '5';
        }elseif(strlen($id_kanban) == 19 && strlen($tipe) == 5){
            $partno = $serial;
            $status_kanban = '6';
        }else{
            $status_kanban = '7';
            $data_kanban = $this->kanban_m->get_kanban_by_barcode($id_kanban, $tipe, $serial);
            if($data_kanban->num_rows() > 0){
                $partno = $data_kanban->row()->CHR_PART_NO;
            }
            else{
                $data_kanban_return = $this->kanban_m->get_kanban_return_by_backno($tipe);
                if($data_kanban_return->num_rows() > 0){
                    $partno = $data_kanban_return->row()->CHR_PART_NO;
                }
            }
        }
        
        // $partno_awal = $partno;
        $status_scan_komponen = $this->pis_pos_material_m->get_status_scan_komponen($prd_order_no, $pos);
            
        if($status_scan_komponen->num_rows() > 0){

            if($partno != '' || $partno != null){

                //check Sub Assy bukan
                $sub_assy_member = $this->pis_pos_material_m->get_registrate_part_comp_in_sub_assy_member($partno, $work_center, $pos, $prd_order_no);
                if($sub_assy_member->num_rows() > 0){
                    $partno_sa = $sub_assy_member->row()->CHR_PART_NO_SA;
                    //$partno = $sub_assy_member->row()->CHR_PART_NO_COMP;
                }
    
                //check finish
                $check_complete_box = $this->pis_pos_material_m->check_finish_actual_perpart($partno, $partno_sa, $work_center, $dateprod, $pos, $prd_order_no);
    
                if($check_complete_box){
    
                    $data_pos_material = $this->pis_pos_material_m->get_data_pos_material_by_pos_material($work_center, $partno, $partno_sa, $prd_order_no, $pos);
    
                    if($data_pos_material->num_rows() > 0){
    
                            $data_component = $this->pis_pos_material_m->update_actual($partno, $partno_sa, $work_center, $dateprod, $pos, $prd_order_no);
    
                            // $this->pos_history_scan_m->save($history_data);
    
                            $img_comp = $data_component->CHR_IMG_COMP_URL;
                            $plan_box = $data_component->INT_BOX_PLAN;
                            $actual_box = $data_component->INT_BOX_ACTUAL;
                            $back_no_component = $data_component->CHR_BACK_NO_COMP;
    
                            $data_chute_material = $this->pis_pos_material_m->get_data_ready_dandori($work_center, $dateprod, $pos, $prd_order_no);
    
                            if ($data_chute_material->num_rows() > 0) {
    
                                    $this->pos_line_activity_m->update($normal_flg, $key_pos_work_center);
    
                                    $data['data_setup_chute'] = $data_chute_material->row();
    
                                    $count = $this->pis_pos_material_m->get_total_component_by_pos($pos, $prd_order_no);
                                    $count_finish = $this->pis_pos_material_m->get_total_finish_component_by_pos($pos, $prd_order_no);
    
                                    foreach($data_chute_material->result() as $isi){
    
                                        if($isi->CHR_PART_NO_SA == NULL){
                                            $back_no = trim($isi->CHR_BACK_NO_COMP);
                                        }else{
                                            $back_no = substr(trim($isi->CHR_BACK_NO_SA), 0, 5);
                                        }
    
                                        $array_img_component = $this->pis_pos_material_m->get_image_component_by_part_no_comp_and_pos($isi->CHR_PART_NO_FG, $isi->CHR_BACK_NO_COMP, $pos, $work_center);

                                        if($array_img_component->num_rows() > 0){
                                            $component_image = trim($array_img_component->row()->CHR_IMAGE_PIS_URL) . "?id=".rand(10, 1000);
                                        }else{
                                            $component_image = "http://".$base.$url[0] . trim($isi->CHR_IMG_COMP_URL) . "?id=".rand(10, 1000);
                                        }

                                        if($isi->INT_BOX_ACTUAL == $isi->INT_BOX_PLAN){
                                            $mark_picture = "http://".$base.$url[0] . "assets/img/ok_summary.png";
    
                                            $component .= "<li id='$isi->INT_ID' class='side-bar-component'>";
                                            $component .= "<table style='width:100%;border-color:white;border: 1px;font-size:15px; letter-spacing: 15px;background:#FFEB40;'><tr><td>".trim($back_no)."</td></tr></table>";
                                            $component .= "<div class='sekunder-image'>";
                                            $component .= '<img src='.$component_image.' class="image-component"; onclick="show_img_comp_to_center(\''.$isi->INT_ID.'\');">';
                                            $component .= "<div class='sidebar-bottom-right-comp'>";
                                            //$component .= "<img src=".$mark_picture." alt='check' style='width:45%;'>";
                                            $component .= "</div>";
                                            $component .= "</div>";
                                            $component .= "<table style='width:100%;border-color:white;font-size:12px;'><tr style='font-style: italic;'><td style='background:#00FC9B;color:#000000;'>PLAN</td><td style='background:#00FC9B;color:#000000;'>ACTL</td></tr><tr style='height:50px;font-size:18pt;'><td style='background:#00FC9B;color:#000000;'>".$isi->INT_BOX_PLAN." BOX</td><td style='background:#00FC9B;color:#000000;'>".$isi->INT_BOX_ACTUAL." BOX</td></tr></table>";
                                            $component .= "</li>";
    
                                            $fg_pict = "http://".$base.$url[0] . $img_comp;
    
                                            $finished_chute = $this->pis_pos_material_m->get_data_finished_dandori($work_center, $dateprod, $pos, $prd_order_no);
    
                                            if($finished_chute){
                                                $fg = "<img src=".$fg_pict." style='max-width:60%;'><div class='float-button-fg'><a class='float-button-fg-fab float-button-fg-large' onclick='show_finish_fg()' id='button-show-fg'><i class='fa fa-check'></i></a></div>";
    
                                            }else{
                                                $fg = "<img src=".$fg_pict." style='max-width:60%;'>";
                                                //$fg = "<img src=".$fg_pict." style='max-width:60%;'><div class='float-button-fg'><a class='float-button-fg-fab float-button-fg-large' onclick='show_finish_fg_exlude_cek_qua()' id='button-show-fg'><i class='fa fa-check'></i></a></div>";  
                                            }
    
                                            $plan_box_active =  $plan_box;
                                            $actual_box_active =  $actual_box;
                                            $back_no_comp = $back_no_component;
    
                                        }else if($isi->INT_BOX_ACTUAL == 0 && $isi->INT_FLG_FINISH == 0){
                                            $mark_picture = "http://".$base.$url[0] . "assets/img/ng_summary.png";
    
                                            $component .= "<li id='$isi->INT_ID' class='side-bar-component'>";
                                            $component .= "<table style='width:100%;border-color:white;border: 1px;font-size:15px; letter-spacing: 15px;background:#FFEB40;'><tr><td>".trim($back_no)."</td></tr></table>";
                                            $component .= "<div class='sekunder-image'>";
                                            $component .= '<img src='.$component_image.' class="image-component"; onclick="show_img_comp_to_center(\''.$isi->INT_ID.'\');">';
                                            $component .= "<div class='sidebar-bottom-right-comp'>";
                                            //$component .= "<img src=".$mark_picture." alt='check' style='width:45%;'>";
                                            $component .= "</div>";
                                            $component .= "</div>";
                                            $component .= "<table style='width:100%;border-color:white;font-size:12px;'><tr style='font-style: italic;'><td style='background:#00FC9B;color:#000000;'>PLAN</td><td style='background:#E84447;color:#FFF'>ACTL</td></tr><tr style='height:50px;font-size:18pt;'><td style='background:#00FC9B;color:#000000;'>".$isi->INT_BOX_PLAN." BOX</td><td style='background:#E84447;color:#FFF;'>".$isi->INT_BOX_ACTUAL." BOX</td></tr></table>";
                                            $component .= "</li>";
    
                                            $fg_pict = "http://".$base.$url[0] . $img_comp;
                                            $fg = "<img src=".$fg_pict." style='max-width:60%;'>";
    
                                            $plan_box_active =  $plan_box;
                                            $actual_box_active =  $actual_box;
                                            $back_no_comp = $back_no_component;
    
                                        }else{
                                            $mark_picture = "http://".$base.$url[0] . "assets/img/onprogress_summary.png";
    
                                            $component .= "<li id='$isi->INT_ID' class='side-bar-component'>";
                                            $component .= "<table style='width:100%;border-color:white;border: 1px;font-size:15px; letter-spacing: 15px;background:#FFEB40;'><tr><td>".trim($back_no)."</td></tr></table>";
                                            $component .= "<div class='sekunder-image'>";
                                            $component .= '<img src='.$component_image.' class="image-component"; onclick="show_img_comp_to_center(\''.$isi->INT_ID.'\');">';
                                            $component .= "<div class='sidebar-bottom-right-comp'>";
                                            //$component .= "<img src=".$mark_picture." alt='check' style='width:45%;'>";
                                            $component .= "</div>";
                                            $component .= "</div>";
                                            $component .= "<table style='width:100%;border-color:white;font-size:12px;'><tr style='font-style: italic;'><td style='background:#00FC9B;color:#000000;'>PLAN</td><td style='background:#008FD7;color:#FFF'>ACTL</td></tr><tr style='height:50px;font-size:18pt;'><td style='background:#00FC9B;color:#000000;'>".$isi->INT_BOX_PLAN." BOX</td><td style='background:#008FD7;color:#FFF;'>".$isi->INT_BOX_ACTUAL." BOX</td></tr></table>";
                                            $component .= "</li>";
    
                                            $fg_pict = "http://".$base.$url[0] . $img_comp;
                                            $fg = "<img src=".$fg_pict." style='max-width:60%;'>";
    
                                            $plan_box_active =  $plan_box;
                                            $actual_box_active =  $actual_box;
                                            $back_no_comp = $back_no_component;
                                        }
    
                                    }
    
                                    $data['component'] = $component;
                                    $data['count'] = $count;
                                    $data['count_finish'] = $count_finish;
                                    $data['fg'] = $fg;
                                    $data['plan_box_active'] = $plan_box_active;
                                    $data['actual_box_active'] = $actual_box_active;
                                    $data['back_no_comp'] = $back_no_comp;
    
                            } 
                    }else{
                        $data['message'] = 'Error Code 6 - Kanban ini tidak terdaftar pada pos di line '. $work_center. ', Hubungi dept ENG';
    
                        $this->pos_line_activity_m->update($error_flg, $key_pos_work_center);
                    }
                }else{
                    $value = $id_kanban .' '.$tipe. ' '.$serial;
                    // if($partno_awal != $partno){
                    //     $error_message = 'Part component '.$partno_awal.' diidentifikasi sebagai part sub assy di pos '. $pos .'. dengan part komponen '.$partno.', mohon check master pos material';
                    // }else{
                        // $error_message = 'Message Code '.$status_kanban.' - kanban '.$value .' dengan part : '. $partno .' sudah complete';
                        $error_message = 'Part komponen '. $partno .' sudah complete';
                    // }
                    $data['message'] = $error_message;
                }
            }else{
                
                $data['message'] = 'Error Code 8 - Kanban tidak sesuai - '.$id_kanban. ' '. $tipe .' '.$serial;
    
                $this->pos_line_activity_m->update($error_flg, $key_pos_work_center);
            }
        }else{
            $data['message'] = 'Semua planning sudah terpenuhi';
        }
        
        if ('IS_AJAX') {
            echo json_encode($data);
        }
    }

    //when sidebar is tap, the view will be refresh 20190507
    function get_gambar_pis_by_id(){
        $component = '';
        $id = $this->input->post('id');

        $data_chute_material = $this->pis_pos_material_m->get_data_pis_pos_material_by_id($id);

        $work_center = $data_chute_material->CHR_WORK_CENTER; 
        $pos = $data_chute_material->CHR_POS_PRD; 
        $prd_order_no = $data_chute_material->CHR_PRD_ORDER_NO; 

        $base = $_SERVER['SERVER_NAME'];
        $url = explode('index',$_SERVER['REQUEST_URI']);

        $fg_pict = "http://".$base.$url[0] . trim($data_chute_material->CHR_IMG_COMP_URL). "?id=".rand(10, 1000);
        $close_pict = "http://".$base.$url[0] . "assets/img/close.png";

        $data['fg'] = "<img src='".$fg_pict."' style='max-width:60%;'>";
        $data['notes'] = "";
        $data['comp'] = "<img src='".$close_pict."' style='width:40%;' onclick='show_fg($id);'>";
        $data['plan_box_active'] = $data_chute_material->INT_BOX_PLAN;
        $data['actual_box_active'] = $data_chute_material->INT_BOX_ACTUAL;
        $data['back_no_comp'] = $data_chute_material->CHR_BACK_NO_COMPONEN;

        $data_chute_material = $this->pis_pos_material_m->get_detail_pos_material_data_recap($work_center, $pos, $prd_order_no);

        if ($data_chute_material->num_rows() > 0) {

            $count = $this->pis_pos_material_m->get_total_component_by_pos($pos, $prd_order_no);
            $count_finish = $this->pis_pos_material_m->get_total_finish_component_by_pos($pos, $prd_order_no);

                foreach($data_chute_material->result() as $isi){

                    if($isi->CHR_PART_NO_SA == NULL){
                        $back_no = trim($isi->CHR_BACK_NO_COMP);
                    }else{
                        $back_no = substr(trim($isi->CHR_BACK_NO_SA), 0, 5);
                    }

                    $array_img_component = $this->pis_pos_material_m->get_image_component_by_part_no_comp_and_pos($isi->CHR_PART_NO_FG, $isi->CHR_BACK_NO_COMP, $pos, $work_center);

                    if($array_img_component->num_rows() > 0){
                        $component_image = trim($array_img_component->row()->CHR_IMAGE_PIS_URL) . "?id=".rand(10, 1000);
                    }else{
                        $component_image = "http://".$base.$url[0] . trim($isi->CHR_IMG_COMP_URL) . "?id=".rand(10, 1000);
                    }

                    if($isi->INT_BOX_ACTUAL == $isi->INT_BOX_PLAN){

                        $component .= "<li id='$isi->INT_ID' class='side-bar-component'>";
                        $component .= "<table style='width:100%;border-color:white;border: 1px;font-size:15px; letter-spacing: 15px;background:#FFEB40;'><tr><td>".trim($back_no)."</td></tr></table>";
                        $component .= "<div class='sekunder-image'>";
                        $component .= '<img src='.$component_image.' class="image-component"; onclick="show_img_comp_to_center(\''.$isi->INT_ID.'\');">';
                        $component .= "<div class='sidebar-bottom-right-comp'>";
                        $component .= "</div>";
                        $component .= "</div>";
                        $component .= "<table style='width:100%;border-color:white;font-size:12px;'><tr style='font-style: italic;'><td style='background:#00FC9B;color:#000000;'>PLAN</td><td style='background:#00FC9B;color:#000000;'>ACTL</td></tr><tr style='height:50px;font-size:18pt;'><td style='background:#00FC9B;color:#000000;'>".$isi->INT_BOX_PLAN." BOX</td><td style='background:#00FC9B;color:#000000;'>".$isi->INT_BOX_ACTUAL." BOX</td></tr></table>";
                        $component .= "</li>";

                    }else if($isi->INT_BOX_ACTUAL == 0 && $isi->INT_FLG_FINISH == 0){

                        $component .= "<li id='$isi->INT_ID' class='side-bar-component'>";
                        $component .= "<table style='width:100%;border-color:white;border: 1px;font-size:15px; letter-spacing: 15px;background:#FFEB40;'><tr><td>".trim($back_no)."</td></tr></table>";
                        $component .= "<div class='sekunder-image'>";
                        $component .= '<img src='.$component_image.' class="image-component"; onclick="show_img_comp_to_center(\''.$isi->INT_ID.'\');">';
                        $component .= "<div class='sidebar-bottom-right-comp'>";
                        $component .= "</div>";
                        $component .= "</div>";
                        $component .= "<table style='width:100%;border-color:white;font-size:12px;'><tr style='font-style: italic;'><td style='background:#00FC9B;color:#000000;'>PLAN</td><td style='background:#E84447;color:#FFF'>ACTL</td></tr><tr style='height:50px;font-size:18pt;'><td style='background:#00FC9B;color:#000000;'>".$isi->INT_BOX_PLAN." BOX</td><td style='background:#E84447;color:#FFF;'>".$isi->INT_BOX_ACTUAL." BOX</td></tr></table>";
                        $component .= "</li>";

                    }else{

                        $component .= "<li id='$isi->INT_ID' class='side-bar-component'>";
                        $component .= "<table style='width:100%;border-color:white;border: 1px;font-size:15px; letter-spacing: 15px;background:#FFEB40;'><tr><td>".trim($back_no)."</td></tr></table>";
                        $component .= "<div class='sekunder-image'>";
                        $component .= '<img src='.$component_image.' class="image-component"; onclick="show_img_comp_to_center(\''.$isi->INT_ID.'\');">';
                        $component .= "<div class='sidebar-bottom-right-comp'>";
                        $component .= "</div>";
                        $component .= "</div>";
                        $component .= "<table style='width:100%;border-color:white;font-size:12px;'><tr style='font-style: italic;'><td style='background:#00FC9B;color:#000000;'>PLAN</td><td style='background:#008FD7;color:#FFF'>ACTL</td></tr><tr style='height:50px;font-size:18pt;'><td style='background:#00FC9B;color:#000000;'>".$isi->INT_BOX_PLAN." BOX</td><td style='background:#008FD7;color:#FFF;'>".$isi->INT_BOX_ACTUAL." BOX</td></tr></table>";
                        $component .= "</li>";

                    }

                }

            $data['component'] = $component;
            $data['count'] = $count;
            $data['count_finish'] = $count_finish;

        }

        if ('IS_AJAX') {
            echo json_encode($data);
        }
    }

    function get_picture_fg(){
        $id = $this->input->post('id');
        $wc = $this->input->post('wc');
        $pos = $this->input->post('pos');

        $data_chute_material = $this->pis_pos_material_m->get_img_fg_by_prod_order_no($id, $wc, $pos);

        $base = $_SERVER['SERVER_NAME'];
        $url = explode('index',$_SERVER['REQUEST_URI']);

        if($data_chute_material){
            $fg_pict = "http://".$base.$url[0] . trim($data_chute_material->CHR_IMG_FG_URL). "?id=".rand(10, 1000);
        }else{
            $fg_pict = "http://".$base.$url[0] . "assets/img/no_prod.png";
        }

        $data['fg'] = "<img src='".$fg_pict."' style='max-width:60%;'>";
        $data['notes'] = $this->pos_m->get_detail_pos_by_workcenter_and_pos($pos, $wc);
        $data['comp'] = "";

        if ('IS_AJAX') {
            echo json_encode($data);
        }
    }

    //show image sub assy/ finish good after finish scan
    function get_finish_picture_fg(){
        $pos = $this->input->post('pos');
        $wc = $this->input->post('wc');

        $data_chute_material = $this->pis_pos_material_m->get_data_prod_order_no($pos, $wc);

        $base = $_SERVER['SERVER_NAME'];
        $url = explode('index',$_SERVER['REQUEST_URI']);

        if($data_chute_material){
            $fg_pict = "http://".$base.$url[0] . trim($data_chute_material->CHR_IMG_FG_URL). "?id=".rand(10, 1000);
        }else{
            $fg_pict = "http://".$base.$url[0] . "assets/img/no_prod.png";
        }

        $data['fg'] = "<img src='".$fg_pict."' style='max-width:60%;'>";
        $data['notes'] = $this->pos_m->get_detail_pos_by_workcenter_and_pos($pos, $wc);

        if ('IS_AJAX') {
            echo json_encode($data);
        }
    }

    //
    function check_already_finish(){
        $work_center = $this->input->post('wc');
        $date = $this->input->post('dateprod');
        $pos = $this->input->post('pos');
        $prd_order_no = $this->input->post('prd_order_no');

        $data = $this->pis_pos_material_m->check_finished_dandori($work_center, $date, $pos, $prd_order_no);

        if ('IS_AJAX') {
            echo json_encode($data);
        }
    }

    // setup chute compenent
    public function get_setup_chute_komponen() {
        $wc = $this->input->post('wc');
        $pos = $this->input->post('pos');

        $this->pis_pos_material_m->get_setup_chute_komponen($wc, $pos);

        if ('IS_AJAX') {
            echo json_encode(true);
        }
    }

    function show_history(){

        $work_center = $this->input->post('wc');
        $pos = $this->input->post('pos');
        $data = '';

        $data_send = array('history_setup_chute' => false, 'status' => true);

        //get blockage setup chute history
        $history = $this->pis_pos_material_m->get_history_setup_chute($work_center, $pos);
        
        if ($history->num_rows() > 0){
            $data .="<table style='width:100%';>";
        }

        if ($history->num_rows() > 0 && $history->num_rows() < 11) {
            $x = 0;
            $data .="<tr>";
            foreach ($history->result() as $value) {
                $data .="<td>$value->CHR_BACK_NO</td>";
                $x++;
            }
            $data .="</tr>";
        } else if ($history->num_rows() > 10 && $history->num_rows() < 21) {
            $x = 0;
            foreach ($history->result() as $value) {
                $x++;
                if ($x > 0 && $x < 11) {
                    if ($x == 1) {
                        $data .="<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == 10) {
                        $data .="<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_BACK_NO</td>";
                    }
                } else {
                    if ($x == 11) {
                        $data .="<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == $history->num_rows()) {
                        $data .="<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_BACK_NO</td>";
                    }
                }
            }
        } else if ($history->num_rows() > 20 && $history->num_rows() < 31) {
            $x = 0;
            foreach ($history->result() as $value) {
                $x++;
                if ($x > 0 && $x < 11) {
                    if ($x == 1) {
                        $data .="<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == 10) {
                        $data .="<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_BACK_NO</td>";
                    }
                } else if ($x > 10 && $x < 21) {
                    if ($x == 11) {
                        $data .="<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == 20) {
                        $data .="<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_BACK_NO</td>";
                    }
                } else {
                    if ($x == 21) {
                        $data .="<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == $history->num_rows()) {
                        $data .="<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_BACK_NO</td>";
                    }
                }
            }
        } else if ($history->num_rows() > 30 && $history->num_rows() < 41) {
            $x = 0;
            foreach ($history->result() as $value) {
                $x++;
                if ($x > 0 && $x < 11) {
                    if ($x == 1) {
                        $data .="<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == 10) {
                        $data .="<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_BACK_NO</td>";
                    }
                } else if ($x > 10 && $x < 21) {
                    if ($x == 11) {
                        $data .="<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == 20) {
                        $data .="<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_BACK_NO</td>";
                    }
                } else if ($x > 20 && $x < 31) {
                    if ($x == 21) {
                        $data .="<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == 30) {
                        $data .="<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_BACK_NO</td>";
                    }
                } else {
                    if ($x == 31) {
                        $data .="<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == $history->num_rows()) {
                        $data .="<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_BACK_NO</td>";
                    }
                }
            }
        } else if ($history->num_rows() > 40 && $history->num_rows() < 51) {
            $x = 0;
            foreach ($history->result() as $value) {
                $x++;
                if ($x > 0 && $x < 11) {
                    if ($x == 1) {
                        $data .="<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == 10) {
                        $data .="<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_BACK_NO</td>";
                    }
                } else if ($x > 10 && $x < 21) {
                    if ($x == 11) {
                        $data .="<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == 20) {
                        $data .="<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_BACK_NO</td>";
                    }
                } else if ($x > 20 && $x < 31) {
                    if ($x == 21) {
                        $data .="<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == 30) {
                        $data .="<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_BACK_NO</td>";
                    }
                } else if ($x > 30 && $x < 41) {
                    if ($x == 31) {
                        $data .="<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == 40) {
                        $data .="<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_BACK_NO</td>";
                    }
                } else {
                    if ($x == 41) {
                        $data .="<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == $history->num_rows()) {
                        $data .="<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_BACK_NO</td>";
                    }
                }
            }
        } else if ($history->num_rows() > 50 && $history->num_rows() < 61) {
            $x = 0;
            foreach ($history->result() as $value) {
                $x++;
                if ($x > 0 && $x < 11) {
                    if ($x == 1) {
                        $data .="<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == 10) {
                        $data .="<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_BACK_NO</td>";
                    }
                } else if ($x > 10 && $x < 21) {
                    if ($x == 11) {
                        $data .="<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == 20) {
                        $data .="<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_BACK_NO</td>";
                    }
                } else if ($x > 20 && $x < 31) {
                    if ($x == 21) {
                        $data .="<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == 30) {
                        $data .="<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_BACK_NO</td>";
                    }
                } else if ($x > 30 && $x < 41) {
                    if ($x == 31) {
                        $data .="<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == 40) {
                        $data .="<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_BACK_NO</td>";
                    }
                } else if ($x > 40 && $x < 51) {
                    if ($x == 41) {
                        $data .="<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == 50) {
                        $data .="<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_BACK_NO</td>";
                    }
                } else {
                    if ($x == 51) {
                        $data .="<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == $history->num_rows()) {
                        $data .="<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_BACK_NO</td>";
                    }
                }
            }
        } else if ($history->num_rows() > 60 && $history->num_rows() < 71) {
            $x = 0;
            foreach ($history->result() as $value) {
                $x++;
                if ($x > 0 && $x < 11) {
                    if ($x == 1) {
                        $data .="<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == 10) {
                        $data .="<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_BACK_NO</td>";
                    }
                } else if ($x > 10 && $x < 21) {
                    if ($x == 11) {
                        $data .="<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == 20) {
                        $data .="<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_BACK_NO</td>";
                    }
                } else if ($x > 20 && $x < 31) {
                    if ($x == 21) {
                        $data .="<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == 30) {
                        $data .="<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_BACK_NO</td>";
                    }
                } else if ($x > 30 && $x < 41) {
                    if ($x == 31) {
                        $data .="<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == 40) {
                        $data .="<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_BACK_NO</td>";
                    }
                } else if ($x > 40 && $x < 51) {
                    if ($x == 41) {
                        $data .="<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == 50) {
                        $data .="<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_BACK_NO</td>";
                    }
                } else if ($x > 50 && $x < 61) {
                    if ($x == 51) {
                        $data .="<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == 60) {
                        $data .="<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_BACK_NO</td>";
                    }
                } else {
                    if ($x == 61) {
                        $data .="<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == $history->num_rows()) {
                        $data .="<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_BACK_NO</td>";
                    }
                }
            }
        } else {
            $x = 0;
            foreach ($history->result() as $value) {
                $x++;
                if ($x > 0 && $x < 11) {
                    if ($x == 1) {
                        $data .="<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == 10) {
                        $data .="<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_BACK_NO</td>";
                    }
                } else if ($x > 10 && $x < 21) {
                    if ($x == 11) {
                        $data .="<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == 20) {
                        $data .="<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_BACK_NO</td>";
                    }
                } else if ($x > 20 && $x < 31) {
                    if ($x == 21) {
                        $data .="<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == 30) {
                        $data .="<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_BACK_NO</td>";
                    }
                } else if ($x > 30 && $x < 41) {
                    if ($x == 31) {
                        $data .="<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == 40) {
                        $data .="<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_BACK_NO</td>";
                    }
                } else if ($x > 40 && $x < 51) {
                    if ($x == 41) {
                        $data .="<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == 50) {
                        $data .="<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_BACK_NO</td>";
                    }
                } else if ($x > 50 && $x < 61) {
                    if ($x == 51) {
                        $data .="<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == 60) {
                        $data .="<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_BACK_NO</td>";
                    }
                } else if ($x > 60 && $x < 71) {
                    if ($x == 61) {
                        $data .="<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == 70) {
                        $data .="<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_BACK_NO</td>";
                    }
                } else {
                    if ($x == 71) {
                        $data .="<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == $history->num_rows()) {
                        $data .="<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_BACK_NO</td>";
                    }
                }
            }
        }

        if ($history->num_rows() > 0){
            $data .="</table>";
        }

        $data_send['history_setup_chute'] = str_replace('\/', '/', $data);

        if($history->num_rows() == 0){
            $data_send['status'] = false;
        }

        if ('IS_AJAX') {
            echo json_encode($data_send);
        }
    }


}
