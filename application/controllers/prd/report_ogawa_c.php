<?php

class report_ogawa_c extends CI_Controller {

    private $layout = '/template/head';
    private $back_to_index = '/prd/report_ogawa_c/';

    public function __construct() {
        parent::__construct();
        $this->load->model('part/part_m');
        $this->load->model('prd/report_ogawa_m');
        $this->load->model('organization/dept_m');
        $this->load->model('prd/direct_backflush_general_m');
    }

    function index($msg = NULL) {
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(37);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Report Stock Parts';
        $data['msg'] = $msg;

        // $id_dept = $this->dept_m->get_top_prod_dept()->row()->INT_ID_DEPT;
        // $work_center = $this->direct_backflush_general_m->get_top_work_center_by_id_dept($id_dept);
        $id_dept = 23;        
        $work_center = 'ASCD02';
        $all_dept_prod = $this->dept_m->get_all_prod_dept();
        $all_work_centers = $this->direct_backflush_general_m->get_work_center_by_id_dept($id_dept);

        $data['all_dept_prod'] = $all_dept_prod;
        $data['all_work_centers'] = $all_work_centers;
        $data['work_center'] = $work_center;
        $data['id_dept'] = $id_dept;

        //$data['data'] = $this->report_ogawa_m->get_part_ogawa_by_wcenter($work_center); //=== Only OGAWA Part
        $data['data'] = $this->report_ogawa_m->get_part_by_wcenter($work_center);

        $data['content'] = 'prd/report_ogawa/report_ogawa_v';
        $this->load->view($this->layout, $data);
    }

    function search_report_ogawa($msg = NULL) {
        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Creating success </strong> The data is successfully created </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Updating success </strong> The data is successfully updated </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Deleted success </strong> The data is successfully deleted </div >";
        } elseif ($msg == 15) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Executing error !</strong> Template Anda Salah atau sudah diubah, Silahkan Coba Lagi Dengan Template Yang Benar </div >";
        } elseif ($msg == 12) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Executing error !</strong> Something error with parameter </div >";
        }
        
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(37);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Report Stock Parts';
        $data['msg'] = $msg;
        
        $id_dept = $this->input->post('INT_ID_DEPT');
        $work_center = $this->input->post('CHR_WORK_CENTER');
        $all_dept_prod = $this->dept_m->get_all_prod_dept();
        $all_work_centers = $this->direct_backflush_general_m->get_work_center_by_id_dept($id_dept);

        $data['all_dept_prod'] = $all_dept_prod;
        $data['all_work_centers'] = $all_work_centers;
        $data['work_center'] = $work_center;
        $data['id_dept'] = $id_dept;

        //$data['data'] = $this->report_ogawa_m->get_part_ogawa_by_wcenter($work_center); //=== Only OGAWA Part
        $data['data'] = $this->report_ogawa_m->get_part_by_wcenter($work_center);

        $data['content'] = 'prd/report_ogawa/report_ogawa_v';
        $this->load->view($this->layout, $data);
    }

    function update_part_ogawa($msg = NULL){
        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Creating success </strong> The data is successfully created </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Updating success </strong> The data is successfully updated </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Deleted success </strong> The data is successfully deleted </div >";
        } elseif ($msg == 15) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Executing error !</strong> Template Anda Salah atau sudah diubah, Silahkan Coba Lagi Dengan Template Yang Benar </div >";
        } elseif ($msg == 12) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Executing error !</strong> Something error with parameter </div >";
        }

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(37);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Report Ogawa';
        $data['msg'] = $msg;

        // $id_dept = $this->input->post('INT_ID_DEPT');
        // $work_center = $this->input->post('CHR_WORK_CENTER');
        $id_dept = 23;        
        $work_center = 'ASCD02';
        $all_dept_prod = $this->dept_m->get_all_prod_dept();
        $all_work_centers = $this->direct_backflush_general_m->get_work_center_by_id_dept($id_dept);

        $update_data = $this->report_ogawa_m->update_part_ogawa();

        $data['all_dept_prod'] = $all_dept_prod;
        $data['all_work_centers'] = $all_work_centers;
        $data['work_center'] = $work_center;
        $data['id_dept'] = $id_dept;

        $data['data'] = $this->report_ogawa_m->get_part_ogawa_by_wcenter($work_center);

        $data['content'] = 'prd/report_ogawa/report_ogawa_v';
        $this->load->view($this->layout, $data);
    }
    
    function export_inventory($id_dept, $wc){
        $user_session = $this->session->all_userdata();
        $role = $user_session['ROLE'];
        $row = 7;
        $date = date('Ymd');
        
        $this->load->library('excel');
        $objReader = PHPExcel_IOFactory::createReader('Excel5');
        
        $objPHPExcel = $objReader->load("assets/template/production/template_inventory_parts.xls");
        $objPHPExcel->getActiveSheet()->setCellValue("B2", "DETAIL INVENTORY PART BY WORK CENTER : " . $wc);
        $objPHPExcel->getActiveSheet()->setCellValue("B3", "Print Date : " . date('d/m/Y') . ' ' . date('H:i:s'));
        
        $list_tr = $this->report_ogawa_m->get_part_by_wcenter($wc);
        $no = 1;
        foreach ($list_tr as $tr) {
            
            $backno = '';
            $get_backno = $this->db->query("SELECT TOP 1 CHR_BACK_NO FROM TM_KANBAN WHERE CHR_PART_NO = '$tr->CHR_PART_NO' AND CHR_KANBAN_TYPE IN ('5','6') ORDER BY CHR_KANBAN_TYPE");
            if($get_backno->num_rows() > 0){
                $backno = $get_backno->row()->CHR_BACK_NO;
            }

            $cust_partno = '';
            $get_cust_partno = $this->db->query("SELECT TOP 1 CHR_CUS_PART_NO FROM TM_SHIPPING_PARTS WHERE CHR_PART_NO = '$tr->CHR_PART_NO'");
            if($get_cust_partno->num_rows() > 0){
                $cust_partno = $get_cust_partno->row()->CHR_CUS_PART_NO;
            }
            
            $objPHPExcel->getActiveSheet()->setCellValue("B$row", "$no");
            $objPHPExcel->getActiveSheet()->setCellValue("C$row", $tr->CHR_PART_NO);
            $objPHPExcel->getActiveSheet()->setCellValue("D$row", $backno);
            $objPHPExcel->getActiveSheet()->setCellValue("E$row", $cust_partno);
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $tr->CHR_PART_NAME);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", 0);

            $qty_progress = $tr->QTY_PROGRESS_PROD + $tr->QTY_WAIT_PROD;
            
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $qty_progress);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $tr->QTY_FINISH_PROD);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $tr->QTY_READY_DEL);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", $tr->QTY_ONSHIPMENT);
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", 0);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", 0);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $tr->QTY_ONSHIPMENT);

            $tot_process = $qty_progress + $tr->QTY_FINISH_PROD + $tr->QTY_READY_DEL;

            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $tot_process);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", 0);

            $no++;
            $row++;
        }
            
        $objPHPExcel->getActiveSheet()->getStyle("B7:P$row")->applyFromArray(array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        ));
        
        ob_end_clean();
        $filename = "Detail Report Inventory - $wc $date.xls";
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . trim($filename) . '"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        // $objWriter->setIncludeCharts(TRUE);
        $objWriter->save('php://output');
    }

    function history_production_chute($msg = NULL) {
        $user_session = $this->session->all_userdata();
        $role = $user_session['ROLE'];

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(315);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Report Stock Parts';
        $data['msg'] = $msg;

        // $id_dept = $this->dept_m->get_top_prod_dept()->row()->INT_ID_DEPT;
        // $work_center = $this->direct_backflush_general_m->get_top_work_center_by_id_dept($id_dept);
        $id_dept = 23;        
        $work_center = 'ASCD02';        
        $all_dept_prod = $this->dept_m->get_all_prod_dept();
        $all_work_centers = $this->direct_backflush_general_m->get_work_center_by_id_dept($id_dept);

        $data['all_dept_prod'] = $all_dept_prod;
        $data['all_work_centers'] = $all_work_centers;
        $data['work_center'] = $work_center;
        $data['id_dept'] = $id_dept;
        $data['role'] = $role;

        $periode = date('Ym');
        $data['periode'] = $periode;

        $data['data'] = $this->report_ogawa_m->get_history_prod_chute($periode, $work_center);

        $data['content'] = 'prd/report_ogawa/history_prod_chute_v';
        $this->load->view($this->layout, $data);
    }

    function search_history_production_chute($msg = NULL) {
        $user_session = $this->session->all_userdata();
        $role = $user_session['ROLE'];
        
        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Creating success </strong> The data is successfully created </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Updating success </strong> The data is successfully updated </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Deleted success </strong> The data is successfully deleted </div >";
        } elseif ($msg == 15) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Executing error !</strong> Template Anda Salah atau sudah diubah, Silahkan Coba Lagi Dengan Template Yang Benar </div >";
        } elseif ($msg == 12) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Executing error !</strong> Something error with parameter </div >";
        }
        
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(315);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'History Production Chute';
        $data['msg'] = $msg;
        
        $id_dept = $this->input->post('INT_ID_DEPT');
        $work_center = $this->input->post('CHR_WORK_CENTER');
        $all_dept_prod = $this->dept_m->get_all_prod_dept();
        $all_work_centers = $this->direct_backflush_general_m->get_work_center_by_id_dept($id_dept);

        $data['all_dept_prod'] = $all_dept_prod;
        $data['all_work_centers'] = $all_work_centers;
        $data['work_center'] = $work_center;
        $data['id_dept'] = $id_dept;
        $data['role'] = $role;

        $periode = $this->input->post('PERIODE');
        $data['periode'] = $periode;

        $data['data'] = $this->report_ogawa_m->get_history_prod_chute($periode, $work_center);

        $data['content'] = 'prd/report_ogawa/history_prod_chute_v';
        $this->load->view($this->layout, $data);
    }

    function view_history_production_chute($work_center = NULL, $periode = NULL) {
        
        $data['work_center'] = $work_center;
        $data['periode'] = $periode;

        $data['data'] = $this->report_ogawa_m->get_history_prod_chute_with_ng($periode, $work_center);

        $data['content'] = 'prd/report_ogawa/view_history_prod_chute_v';
        $this->load->view("/template/head_blank", $data);
    }

    public function view_actual_lot() {
        
        $back_no = trim($this->input->post("backno"));
        $act_date = $this->input->post("date_act");

        $data = '';
        $data .= '<div class="modal-wrapper">';
        $data .= '  <div class="modal-dialog">';                                    
        $data .= '    <div class="modal-content">';
        $data .= '       <div class="modal-header">';
        $data .= '            <button type="button" onclick="hide_actual_lot()" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>';
        $data .= '            <h4 class="modal-title" id="modalprogress"><strong>Actual Lot Number - ' . $act_date . '</strong></h4>';
        $data .= '       </div>';

        $data .= '       <div class="modal-body">';
        
        $data .= '          <table id="example" class="table table-condensed table-striped table-hover display" cellspacing="0" width="100%">';
        $data .= '              <thead>';
        $data .= '                  <tr>';
        $data .= '                      <th>No</th>';
        $data .= '                      <th>Prod Lot No</th>';
        $data .= '                      <th>Lot Size</th>';
        $data .= '                      <th>Qty Plan</th>';
        $data .= '                      <th>Qty Actual</th>';
        $data .= '                  </tr>';
        $data .= '              </thead>';
        $data .= '              <tbody>';
        
        $no = 1;
        $cek_act = $this->report_ogawa_m->get_actual_lot($back_no, $act_date);
        if ($cek_act->num_rows() > 0) {
            $data_act = $cek_act->result();
            foreach ($data_act as $part) {
                $date_plan = substr($part->CHR_PRD_ORDER_NO, 7, 8);
                if($date_plan != $act_date){
                    $data .= '<tr style="color:red;">';
                } else {
                    $data .= '<tr>';
                }
                
                $data .= '<td>' . $no . '</td>';
                $data .= '<td>' . $part->CHR_PRD_ORDER_NO . '</td>';
                $data .= '<td>' . $part->INT_LOT_SIZE . '</td>';
                $data .= '<td>' . $part->INT_QTY_PCS . '</td>';
                $data .= '<td align="center">' . $part->TOT_SCAN . '</td>';
                $data .= '</tr>';
                
                $no++;
            }
        }
                                                
        $data .= '              </tbody>';
        $data .= '          </table>';
        
        $data .= ' <span style="font-size:9pt">* Red font - Miss production date plan</span>';

        $data .= '        </div>';
        $data .= '    </div>';
        $data .= '  </div>';
        $data .= '</div>';
        
        echo $data;
        
    }

    public function view_plan_lot() {
        
        $back_no = trim($this->input->post("backno"));
        $plan_date = $this->input->post("date_plan");

        $data = '';
        $data .= '<div class="modal-wrapper">';
        $data .= '  <div class="modal-dialog">';                                    
        $data .= '    <div class="modal-content">';
        $data .= '       <div class="modal-header">';
        $data .= '            <button type="button" onclick="hide_plan_lot()" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>';
        $data .= '            <h4 class="modal-title" id="modalprogress"><strong>Plan Lot Number - ' . $plan_date . '</strong></h4>';
        $data .= '       </div>';

        $data .= '       <div class="modal-body">';
        
        $data .= '          <table id="example" class="table table-condensed table-striped table-hover display" cellspacing="0" width="100%">';
        $data .= '              <thead>';
        $data .= '                  <tr>';
        $data .= '                      <th>No</th>';
        $data .= '                      <th>Prod Lot No</th>';
        $data .= '                      <th>Lot Size</th>';
        $data .= '                      <th>Qty Plan</th>';
        // $data .= '                      <th>Qty Actual</th>';
        $data .= '                  </tr>';
        $data .= '              </thead>';
        $data .= '              <tbody>';
        
        $no = 1;
        $cek_plan = $this->report_ogawa_m->get_plan_lot($back_no, $plan_date);
        if ($cek_plan->num_rows() > 0) {
            $data_plan = $cek_plan->result();
            foreach ($data_plan as $part) {
                $data .= '<tr>';
                $data .= '<td>' . $no . '</td>';
                $data .= '<td>' . $part->CHR_PRD_ORDER_NO . '</td>';
                $data .= '<td>' . $part->INT_LOT_SIZE . '</td>';
                $data .= '<td>' . $part->INT_QTY_PCS . '</td>';
                // $data .= '<td align="center">' . $part->TOT_SCAN . '</td>';
                $data .= '</tr>';
                
                $no++;
            }
        }
                                                
        $data .= '              </tbody>';
        $data .= '          </table>';                                                  

        $data .= '        </div>';
        $data .= '    </div>';
        $data .= '  </div>';
        $data .= '</div>';
        
        echo $data;
        
    }

    function view_movement_stock($work_center = NULL, $periode = NULL) {
        
        $data['work_center'] = $work_center;
        $data['periode'] = $periode;

        $sloc = '';
        if(substr($work_center,0,2) == 'AS'){
            $sloc = 'PP';
        } else {
            $sloc = 'WP01';
        }

        $data['data'] = $this->report_ogawa_m->view_stock_part_by_wc($work_center, $sloc);

        $data['content'] = 'prd/report_ogawa/view_movement_stock_v';
        $this->load->view("/template/head_blank", $data);
    }

}
