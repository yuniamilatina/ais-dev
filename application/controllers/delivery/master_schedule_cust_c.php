<?php

class master_schedule_cust_c extends CI_Controller {
    /* -- define constructor -- */

    private $layout = '/template/head';

    public function __construct() {
        parent::__construct();
        $this->load->model('delivery/delia/master_schedule_cust_m');
    }

    public function index($msg = null, $periode = null) {
        if ($msg == 1) {
            $msg = "<div class = 'alert alert-success'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Success. </strong> Master schedule is successfully updated. </div >";
        } else if ($msg == 2) {
            $msg = "<div class = 'alert alert-success'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Failed. </strong> Something wrong, please check your template. </div >";
        } else {
            $msg = null;
        }
        
        $session = $this->session->all_userdata();

        $data['title'] = 'Master Schedule Customer';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(259);
        $data['news'] = $this->news_m->get_news();
        $data['content'] = 'delivery/delia/master_schedule_cust_v';
        $ymd = date("Ymd");
        $date = date("Ym");
        
        if ($periode == null || $periode == '') {
            $date_selected = date("Ym");
        } else {
            $date_selected = $periode;
        }        
       
        $data['selected_date'] = $date_selected;
        $data['schedule'] = $this->master_schedule_cust_m->get_schedule_delivery($date_selected);
        $data['all_customer'] = $this->master_schedule_cust_m->get_all_customer();
        $data['role'] = $session['ROLE'];
        $data['msg'] = $msg;

        $this->load->view($this->layout, $data);
    }

    public function download_template() {
        $this->load->helper('download');
        $filename = 'Temp Upload Schedule Delivery New';
        
        ob_clean();
        $name = $filename.'.xls';
        $data = file_get_contents("assets/template/delivery/$filename.xls");

        force_download($name, $data);
    }

    public function upload_schedule() {        
        $this->load->library(array('PHPExcel', 'PHPExcel/IOFactory'));
        $periode = $this->input->post('periode');
        $pic = $this->session->userdata('NPK');
        
        $this->db->query("delete from DEL.TW_SCHEDULE_DELIVERY where CHR_PERIODE = '$periode'");
        
        $date_now = date("Ymd");
        $time_now = date("His");
        
        if ($this->input->post("upload_button") == 1) {            
            $fileName = $_FILES['import_schedule']['name'];
            
            if (empty($fileName)) {
                echo '<script>alert("Anda belum memilih file untuk diupload");</script>';
                redirect('delivery/master_schedule_cust_c/index', 'refresh');
            }
            // File for submit Excel file
            $config['upload_path'] = './assets/files/';
            $config['file_name'] = $fileName;
            $config['allowed_types'] = '*';
            $config['max_size'] = 10000;

            // Code for upload with CI
            $this->load->library('upload', $config);
            
            if (!$this->upload->do_upload('import_schedule')){
                print_r('ng');
                exit();
                $this->upload->display_errors();
                exit();
            }  
            
            $media = $this->upload->data('import_schedule');
            $inputFileName = './assets/files/' . $media['file_name'];
            
            // Read Excel workbook
            try {
                $inputFileType = IOFactory::identify($inputFileName);
                $objReader = IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($inputFileName);
            } catch (Exception $e) {
            // $this->db->trans_rollback();
                die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' . $e->getMessage());
            }

            $sheet = $objPHPExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();
            
            $x = 0;
            $y = 0;
            $rowHeader = $sheet->rangeToArray('A1:CW1', NULL, TRUE, FALSE);
            $mark_temp = strtolower($rowHeader[0][100]);
            if ($mark_temp == "delivery") {
                for ($row = 3; $row <= $highestRow; $row++) {
                    $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);
                    if ($rowData[0][1] == '') {
                        break;
                    }
                    
                    $cust = $rowData[0][1];
                    $dist_channel = substr($rowData[0][4],0,2);
                    $cust_sap_no = trim($rowData[0][5]);
                    $cycle = $rowData[0][6];
                    if($rowData[0][7] != null || $rowData[0][7] != "" || $rowData[0][7] != " "){
                        $dock = $rowData[0][7];
                    } else {
                        $dock = "-";
                    }
                    
                    if($rowData[0][8] != null || $rowData[0][8] != "" || $rowData[0][8] != " "){
                        $dock_sap = $rowData[0][8];
                    } else {
                        $dock_sap = "-";
                    }
                    
                    if($rowData[0][9] != null || $rowData[0][9] != "" || $rowData[0][9] != " "){
                        $route = $rowData[0][9];
                    } else {
                        $route = "-";
                    }
                    
                    if($rowData[0][10] != null || $rowData[0][10] != "" || $rowData[0][10] != " "){
                        $log_vendor = $rowData[0][10];
                    } else {
                        $log_vendor = "AII";
                    }
                    
                    $start_pull = $rowData[0][11];
                    $end_pull = $rowData[0][12];
                    $start_pdi = $rowData[0][13];
                    $end_pdi = $rowData[0][14];
                    $aii_arrival = $rowData[0][15];
                    $aii_departure = $rowData[0][16];
                    $cust_arrival = $rowData[0][17];
                    $aii_dock = $rowData[0][18];
                    
                    $detail_cust = $this->master_schedule_cust_m->get_customer($cust_sap_no, $dist_channel);
                    $cust_name = $detail_cust->CHR_CUST_NAME;
                    $cust_address = $detail_cust->CHR_CUST_ADDRESS;
                 
                    $this->db->query("insert into DEL.TW_SCHEDULE_DELIVERY (CHR_PERIODE, CHR_CUST, CHR_CUST_DOCK, CHR_CUST_DOCK_SAP, INT_CYCLE, CHR_CUST_DESC, CHR_CUST_ADDRESS, CHR_CUST_SAP_NO, CHR_DIS_CHANNEL, CHR_ROUTE, CHR_LOG_VENDOR, "
                            . "CHR_PULLING_START, CHR_PULLING_END, CHR_TAKAIBIKI_START, CHR_TAKAIBIKI_END, CHR_AII_ARRIVAL, CHR_AII_DEPARTURE, CHR_CUST_ARRIVAL, CHR_AII_DOCK)"
                            . "VALUES ('$periode', '$cust', '$dock', '$dock_sap', '$cycle', '$cust_name', '$cust_address', '$cust_sap_no', '$dist_channel', '$route', '$log_vendor', "
                            . "'$start_pull', '$end_pull', '$start_pdi', '$end_pdi', '$aii_arrival', '$aii_departure' , '$cust_arrival', '$aii_dock');");
                        
                }
                
                redirect("delivery/master_schedule_cust_c/schedule_confirmation/" . $periode, "refresh");
            } else {
                echo "<script>alert('Maaf template yang Anda masukan salah. Pastikan Anda menggunakan template dari sistem')</script>";
            }
                   
        }
    }
    
    public function schedule_confirmation($periode = null) {        
        $pic = $this->session->userdata('NPK');
        $date = date("Ymd");
        $time = date("His");

        $data['content'] = 'delivery/delia/confirm_schedule_v';
        $data['title'] = 'Confirm Master Schedule Customer';

        $schedule = $this->db->query("select * from DEL.TW_SCHEDULE_DELIVERY where CHR_PERIODE = '$periode'")->result();
        if (count($schedule) == 0) {
            redirect("delivery/master_schedule_cust_c/index/2", "refresh");
        }

        if ($this->input->post("btn-confirm") != '') {
            $range = 0;
            foreach ($schedule as $isi) {
                $cust = $isi->CHR_CUST;
                $dist_channel = $isi->CHR_DIS_CHANNEL;
                $cust_sap_no = $isi->CHR_CUST_SAP_NO;
                $cycle = $isi->INT_CYCLE;
                $dock = $isi->CHR_CUST_DOCK;
                $dock_sap = $isi->CHR_CUST_DOCK_SAP;
                $route = $isi->CHR_ROUTE;
                $log_vendor = $isi->CHR_LOG_VENDOR;
                $start_pull = $isi->CHR_PULLING_START;
                $end_pull = $isi->CHR_PULLING_END;
                $start_pdi = $isi->CHR_TAKAIBIKI_START;
                $end_pdi = $isi->CHR_TAKAIBIKI_END;
                $aii_arrival = $isi->CHR_AII_ARRIVAL;
                $aii_departure = $isi->CHR_AII_DEPARTURE;
                $cust_arrival = $isi->CHR_CUST_ARRIVAL;
                $cust_name = $isi->CHR_CUST_DESC;
                $cust_address = $isi->CHR_CUST_ADDRESS;
                $aii_dock = $isi->CHR_AII_DOCK;

                $cek_exist = $this->db->query("select * from DEL.TM_SCHEDULE_DELIVERY where CHR_PERIODE = '$periode' and CHR_CUST_SAP_NO = '$cust_sap_no' and CHR_DIS_CHANNEL = '$dist_channel' and INT_CYCLE = '$cycle' and CHR_CUST_DOCK = '$dock'")->num_rows();
                if($cek_exist > 0){
                    $this->db->query("update DEL.TM_SCHEDULE_DELIVERY set CHR_CUST = '$cust', INT_CYCLE = '$cycle', CHR_CUST_DOCK = '$dock', CHR_CUST_DOCK_SAP = '$dock_sap',CHR_ROUTE = '$route', CHR_LOG_VENDOR = '$log_vendor', "
                            . "CHR_PULLING_START = '$start_pull', CHR_PULLING_END = '$end_pull', CHR_TAKAIBIKI_START = '$start_pdi', CHR_TAKAIBIKI_END = '$end_pdi', CHR_AII_ARRIVAL = '$aii_arrival', CHR_AII_DEPARTURE = '$aii_departure', CHR_CUST_ARRIVAL = '$cust_arrival',"
                        . "CHR_AII_DOCK = '$aii_dock', CHR_MODIFIED_BY = '$pic', CHR_MODIFIED_DATE = '$date', CHR_MODIFIED_TIME = '$time' where CHR_PERIODE = '$periode' and CHR_CUST_SAP_NO = '$cust_sap_no' and CHR_DIS_CHANNEL = '$dist_channel' and INT_CYCLE = '$cycle'");
                    
                    //===== Update schedule preparation - ANU 20180629 =========
//                    $this->db->query("UPDATE DEL.TM_SCHEDULE_DELIVERY
//                                    SET 
//                                    -- TAKAIBIKI END
//                                    DEL.TM_SCHEDULE_DELIVERY.CHR_TAKAIBIKI_END = SUBSTRING(CAST(DATEADD(MINUTE,-240, CAST(SUBSTRING(CHR_AII_ARRIVAL,1,2) + ':' + SUBSTRING(CHR_AII_ARRIVAL,3,2) + ':00'  AS TIME)) AS VARCHAR(20)),1,2) +
//                                    SUBSTRING(CAST(DATEADD(MINUTE,-240, CAST(SUBSTRING(CHR_AII_ARRIVAL,1,2) + ':' + SUBSTRING(CHR_AII_ARRIVAL,3,2) + ':00'  AS TIME)) AS VARCHAR(20)),4,2),
//                                    -- TAKAIBIKI START
//                                    DEL.TM_SCHEDULE_DELIVERY.CHR_TAKAIBIKI_START = SUBSTRING(CAST(DATEADD(MINUTE,-390, CAST(SUBSTRING(CHR_AII_ARRIVAL,1,2) + ':' + SUBSTRING(CHR_AII_ARRIVAL,3,2) + ':00'  AS TIME)) AS VARCHAR(20)),1,2) +
//                                    SUBSTRING(CAST(DATEADD(MINUTE,-390, CAST(SUBSTRING(CHR_AII_ARRIVAL,1,2) + ':' + SUBSTRING(CHR_AII_ARRIVAL,3,2) + ':00'  AS TIME)) AS VARCHAR(20)),4,2),
//                                    -- PULLING END
//                                    DEL.TM_SCHEDULE_DELIVERY.CHR_PULLING_END = SUBSTRING(CAST(DATEADD(MINUTE,-405, CAST(SUBSTRING(CHR_AII_ARRIVAL,1,2) + ':' + SUBSTRING(CHR_AII_ARRIVAL,3,2) + ':00'  AS TIME)) AS VARCHAR(20)),1,2) +
//                                    SUBSTRING(CAST(DATEADD(MINUTE,-405, CAST(SUBSTRING(CHR_AII_ARRIVAL,1,2) + ':' + SUBSTRING(CHR_AII_ARRIVAL,3,2) + ':00'  AS TIME)) AS VARCHAR(20)),4,2),
//                                    -- PULLING START
//                                    DEL.TM_SCHEDULE_DELIVERY.CHR_PULLING_START = SUBSTRING(CAST(DATEADD(MINUTE,-505, CAST(SUBSTRING(CHR_AII_ARRIVAL,1,2) + ':' + SUBSTRING(CHR_AII_ARRIVAL,3,2) + ':00'  AS TIME)) AS VARCHAR(20)),1,2) +
//                                    SUBSTRING(CAST(DATEADD(MINUTE,-505, CAST(SUBSTRING(CHR_AII_ARRIVAL,1,2) + ':' + SUBSTRING(CHR_AII_ARRIVAL,3,2) + ':00'  AS TIME)) AS VARCHAR(20)),4,2)
//                                    FROM DEL.TM_SCHEDULE_DELIVERY
//                                    WHERE CHR_PERIODE = '$periode' and CHR_CUST_SAP_NO = '$cust_sap_no' and CHR_DIS_CHANNEL = '$dist_channel' and INT_CYCLE = '$cycle'");
//                    
                    $range++;
                } else {
                    $this->db->query("insert into DEL.TM_SCHEDULE_DELIVERY (CHR_PERIODE, CHR_CUST, CHR_CUST_DOCK, CHR_CUST_DOCK_SAP, INT_CYCLE, CHR_CUST_DESC, CHR_CUST_ADDRESS, CHR_CUST_SAP_NO, CHR_DIS_CHANNEL, CHR_ROUTE, CHR_LOG_VENDOR, "
                            . "CHR_PULLING_START, CHR_PULLING_END, CHR_TAKAIBIKI_START, CHR_TAKAIBIKI_END, CHR_AII_ARRIVAL, CHR_AII_DEPARTURE, CHR_CUST_ARRIVAL, CHR_AII_DOCK, CHR_CREATED_BY, CHR_CREATED_DATE, CHR_CREATED_TIME)"
                        . "VALUES ('$periode', '$cust', '$dock', '$dock_sap', '$cycle', '$cust_name', '$cust_address', '$cust_sap_no', '$dist_channel', '$route', '$log_vendor', "
                            . "'$start_pull', '$end_pull', '$start_pdi', '$end_pdi', '$aii_arrival', '$aii_departure', '$cust_arrival', '$aii_dock', '$pic', '$date', '$time')");
                    
                    //===== Update schedule preparation - ANU 20180629 =========
//                    $this->db->query("UPDATE DEL.TM_SCHEDULE_DELIVERY
//                                    SET 
//                                    -- TAKAIBIKI END
//                                    DEL.TM_SCHEDULE_DELIVERY.CHR_TAKAIBIKI_END = SUBSTRING(CAST(DATEADD(MINUTE,-240, CAST(SUBSTRING(CHR_AII_ARRIVAL,1,2) + ':' + SUBSTRING(CHR_AII_ARRIVAL,3,2) + ':00'  AS TIME)) AS VARCHAR(20)),1,2) +
//                                    SUBSTRING(CAST(DATEADD(MINUTE,-240, CAST(SUBSTRING(CHR_AII_ARRIVAL,1,2) + ':' + SUBSTRING(CHR_AII_ARRIVAL,3,2) + ':00'  AS TIME)) AS VARCHAR(20)),4,2),
//                                    -- TAKAIBIKI START
//                                    DEL.TM_SCHEDULE_DELIVERY.CHR_TAKAIBIKI_START = SUBSTRING(CAST(DATEADD(MINUTE,-390, CAST(SUBSTRING(CHR_AII_ARRIVAL,1,2) + ':' + SUBSTRING(CHR_AII_ARRIVAL,3,2) + ':00'  AS TIME)) AS VARCHAR(20)),1,2) +
//                                    SUBSTRING(CAST(DATEADD(MINUTE,-390, CAST(SUBSTRING(CHR_AII_ARRIVAL,1,2) + ':' + SUBSTRING(CHR_AII_ARRIVAL,3,2) + ':00'  AS TIME)) AS VARCHAR(20)),4,2),
//                                    -- PULLING END
//                                    DEL.TM_SCHEDULE_DELIVERY.CHR_PULLING_END = SUBSTRING(CAST(DATEADD(MINUTE,-405, CAST(SUBSTRING(CHR_AII_ARRIVAL,1,2) + ':' + SUBSTRING(CHR_AII_ARRIVAL,3,2) + ':00'  AS TIME)) AS VARCHAR(20)),1,2) +
//                                    SUBSTRING(CAST(DATEADD(MINUTE,-405, CAST(SUBSTRING(CHR_AII_ARRIVAL,1,2) + ':' + SUBSTRING(CHR_AII_ARRIVAL,3,2) + ':00'  AS TIME)) AS VARCHAR(20)),4,2),
//                                    -- PULLING START
//                                    DEL.TM_SCHEDULE_DELIVERY.CHR_PULLING_START = SUBSTRING(CAST(DATEADD(MINUTE,-505, CAST(SUBSTRING(CHR_AII_ARRIVAL,1,2) + ':' + SUBSTRING(CHR_AII_ARRIVAL,3,2) + ':00'  AS TIME)) AS VARCHAR(20)),1,2) +
//                                    SUBSTRING(CAST(DATEADD(MINUTE,-505, CAST(SUBSTRING(CHR_AII_ARRIVAL,1,2) + ':' + SUBSTRING(CHR_AII_ARRIVAL,3,2) + ':00'  AS TIME)) AS VARCHAR(20)),4,2)
//                                    FROM DEL.TM_SCHEDULE_DELIVERY
//                                    WHERE CHR_PERIODE = '$periode' and CHR_CUST_SAP_NO = '$cust_sap_no' and CHR_DIS_CHANNEL = '$dist_channel' and INT_CYCLE = '$cycle'");
//                    
                    $range++;
                }                
            }
            
            $this->db->query("delete from DEL.TW_SCHEDULE_DELIVERY where CHR_PERIODE = '$periode'");
            
//            echo "<script>alert('Master schedule delivery berhasil di update')</script>";
            redirect("delivery/master_schedule_cust_c/index/1/" . $periode, "refresh");
        }

        $data['schedule'] = $schedule;

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(259);
        $data['news'] = $this->news_m->get_news();

        $this->load->view($this->layout, $data);
    }
    
    public function update_schedule(){
        $session = $this->session->all_userdata();
        $id = $this->input->post("id_schedule");
        $periode = $this->input->post("periode");
        $aii_arrival = $this->input->post("aii_arrival");
        $aii_departure = $this->input->post("aii_departure");
        $cust_arrival = $this->input->post("cust_arrival");
        
        $data = array(
                'CHR_AII_ARRIVAL' => $aii_arrival,
                'CHR_AII_DEPARTURE' => $aii_departure,
                'CHR_CUST_ARRIVAL' => $cust_arrival,
                'CHR_MODIFIED_BY' => $session['NPK'],
                'CHR_MODIFIED_DATE' => date('Ymd'),
                'CHR_MODIFIED_TIME' => date('His')
        );
        
        $this->master_schedule_cust_m->update($data, $id);
        
        //===== Update schedule preparation - ANU 20180629 =========
//        $this->db->query("UPDATE DEL.TM_SCHEDULE_DELIVERY
//                        SET 
//                        -- TAKAIBIKI END
//                        DEL.TM_SCHEDULE_DELIVERY.CHR_TAKAIBIKI_END = SUBSTRING(CAST(DATEADD(MINUTE,-240, CAST(SUBSTRING(CHR_AII_ARRIVAL,1,2) + ':' + SUBSTRING(CHR_AII_ARRIVAL,3,2) + ':00'  AS TIME)) AS VARCHAR(20)),1,2) +
//                        SUBSTRING(CAST(DATEADD(MINUTE,-240, CAST(SUBSTRING(CHR_AII_ARRIVAL,1,2) + ':' + SUBSTRING(CHR_AII_ARRIVAL,3,2) + ':00'  AS TIME)) AS VARCHAR(20)),4,2),
//                        -- TAKAIBIKI START
//                        DEL.TM_SCHEDULE_DELIVERY.CHR_TAKAIBIKI_START = SUBSTRING(CAST(DATEADD(MINUTE,-390, CAST(SUBSTRING(CHR_AII_ARRIVAL,1,2) + ':' + SUBSTRING(CHR_AII_ARRIVAL,3,2) + ':00'  AS TIME)) AS VARCHAR(20)),1,2) +
//                        SUBSTRING(CAST(DATEADD(MINUTE,-390, CAST(SUBSTRING(CHR_AII_ARRIVAL,1,2) + ':' + SUBSTRING(CHR_AII_ARRIVAL,3,2) + ':00'  AS TIME)) AS VARCHAR(20)),4,2),
//                        -- PULLING END
//                        DEL.TM_SCHEDULE_DELIVERY.CHR_PULLING_END = SUBSTRING(CAST(DATEADD(MINUTE,-405, CAST(SUBSTRING(CHR_AII_ARRIVAL,1,2) + ':' + SUBSTRING(CHR_AII_ARRIVAL,3,2) + ':00'  AS TIME)) AS VARCHAR(20)),1,2) +
//                        SUBSTRING(CAST(DATEADD(MINUTE,-405, CAST(SUBSTRING(CHR_AII_ARRIVAL,1,2) + ':' + SUBSTRING(CHR_AII_ARRIVAL,3,2) + ':00'  AS TIME)) AS VARCHAR(20)),4,2),
//                        -- PULLING START
//                        DEL.TM_SCHEDULE_DELIVERY.CHR_PULLING_START = SUBSTRING(CAST(DATEADD(MINUTE,-505, CAST(SUBSTRING(CHR_AII_ARRIVAL,1,2) + ':' + SUBSTRING(CHR_AII_ARRIVAL,3,2) + ':00'  AS TIME)) AS VARCHAR(20)),1,2) +
//                        SUBSTRING(CAST(DATEADD(MINUTE,-505, CAST(SUBSTRING(CHR_AII_ARRIVAL,1,2) + ':' + SUBSTRING(CHR_AII_ARRIVAL,3,2) + ':00'  AS TIME)) AS VARCHAR(20)),4,2)
//                        FROM DEL.TM_SCHEDULE_DELIVERY
//                        WHERE INT_ID = '$id");
//        
        redirect("delivery/master_schedule_cust_c/index/1/" . $periode, "refresh");
    }
    
    public function delete_schedule($periode, $id){
        $session = $this->session->all_userdata();
        $schedule = $this->master_schedule_cust_m->get_schedule_by_id($id);
        $status = $schedule->CHR_FLG_DELETE;
        
        if($status == 0){
            $data = array(
                    'CHR_FLG_DELETE' => 1,
                    'CHR_MODIFIED_BY' => $session['NPK'],
                    'CHR_MODIFIED_DATE' => date('Ymd'),
                    'CHR_MODIFIED_TIME' => date('His')
            );
        } else {
            $data = array(
                    'CHR_FLG_DELETE' => 0,
                    'CHR_MODIFIED_BY' => $session['NPK'],
                    'CHR_MODIFIED_DATE' => date('Ymd'),
                    'CHR_MODIFIED_TIME' => date('His')
            );
        }
        
        $this->master_schedule_cust_m->update($data, $id);
        redirect("delivery/master_schedule_cust_c/index/1/" . $periode, "refresh");
    }
    
    public function history_absent($date = null) {
        
        $session = $this->session->all_userdata();

        $data['title'] = 'History Absent Milkrun';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(284);
        $data['news'] = $this->news_m->get_news();
        $data['content'] = 'delivery/delia/history_absent_milkrun_v';
        
        if ($date == null || $date == '') {
            $date_selected = date("Ymd");
            $status = 0;
        } else {
            $date_selected = $date;
            $status = 1;
        }        
        
        $data['status'] = $status;
       
        $data['selected_date'] = $date_selected;
        $data['history'] = $this->master_schedule_cust_m->get_history_absent($date_selected);
        $data['role'] = $session['ROLE'];

        $this->load->view($this->layout, $data);
    }
    
    function export_excel($date){
        $user_session = $this->session->all_userdata();
        $role = $user_session['ROLE'];
        $row = 7;
        
        $this->load->library('excel');
        $objReader = PHPExcel_IOFactory::createReader('Excel5');
        
        $objPHPExcel = $objReader->load("assets/template/delivery/Template History Absent.xls");
        $objPHPExcel->getActiveSheet()->setCellValue("B2", "HISTORY ABSENT MILKRUN : " . substr($date,6,2) . ' ' . strtoupper(date("F", mktime(null, null, null, substr($date, 4, 2)))). ' ' . substr($date,0,4));
        
        $history = $this->master_schedule_cust_m->get_history_absent($date);
        $no = 1;
        foreach ($history as $tr) {
            $judge_in = '-';
            if($tr->INT_CHECKIN_STAT == 2 && $tr->CHR_TIME_CHECKIN != NULL){
                $judge_in = 'Delayed';
            } else if($tr->INT_CHECKIN_STAT == 1 && $tr->CHR_TIME_CHECKIN != NULL){
                $judge_in = 'Advanced';
            } else if($tr->INT_CHECKIN_STAT == 0 && $tr->CHR_TIME_CHECKIN != NULL){
                $judge_in = 'On Time';
            }
            
            $judge_out = '-';
            if($tr->INT_CHECKOUT_STAT == 2 && $tr->CHR_TIME_CHECKOUT != NULL){
                $judge_out = 'Delayed';
            } else if($tr->INT_CHECKOUT_STAT == 1 && $tr->CHR_TIME_CHECKOUT != NULL){
                $judge_out = 'Advanced';
            } else if($tr->INT_CHECKIN_STAT == 0 && $tr->CHR_TIME_CHECKOUT != NULL){
                $judge_out = 'On Time';
            }
            
            $judge_lk3 = '-';
            if($tr->SCORING == '1' && $tr->CHR_TIME_CHECKIN != NULL){
                $judge_lk3 = 'Very Good';
            } else if(($tr->SCORING >= 0.8) && ($tr->SCORING <= 0.99) && $tr->CHR_TIME_CHECKIN != NULL){
                $judge_lk3 = 'Good';
            } else if(($tr->SCORING >= 0.7) && ($tr->SCORING <= 0.79) && $tr->CHR_TIME_CHECKIN != NULL){
                $judge_lk3 = 'Fair';
            } else if($tr->SCORING < 0.7 && $tr->CHR_TIME_CHECKIN != NULL){
                $judge_lk3 = 'Poor';
            }
            
            $objPHPExcel->getActiveSheet()->setCellValue("B$row", "$no");
            $objPHPExcel->getActiveSheet()->setCellValue("C$row", $tr->CHR_CUST);
            $objPHPExcel->getActiveSheet()->setCellValue("D$row", $tr->CHR_CUST_DESC);
            $objPHPExcel->getActiveSheet()->setCellValue("E$row", $tr->CHR_DIS_CHANNEL);
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $tr->INT_CYCLE);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $tr->CHR_CUST_DOCK);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $tr->CHR_ROUTE);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $tr->CHR_LOG_VENDOR);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", date('H:i', strtotime($tr->CHR_AII_ARRIVAL)));
            
            if($tr->CHR_TIME_CHECKIN != NULL){
                $objPHPExcel->getActiveSheet()->setCellValue("K$row", date('H:i', strtotime($tr->CHR_TIME_CHECKIN)));
            } else {
                $objPHPExcel->getActiveSheet()->setCellValue("K$row", "-");
            }
            
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $judge_in);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", date('H:i', strtotime($tr->CHR_AII_DEPARTURE)));
            
            if($tr->CHR_TIME_CHECKOUT != NULL){
                $objPHPExcel->getActiveSheet()->setCellValue("N$row", date('H:i', strtotime($tr->CHR_TIME_CHECKOUT)));
            } else {
                $objPHPExcel->getActiveSheet()->setCellValue("N$row", "-");
            }
            
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $judge_out);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $tr->SCORING);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $judge_lk3);
            
            if($tr->INT_HELM_STAT == 1){
                $objPHPExcel->getActiveSheet()->setCellValue("R$row", "v");
            } else {
                $objPHPExcel->getActiveSheet()->setCellValue("R$row", "-");
            }
            
            if($tr->INT_ROMPI_STAT == 1){
                $objPHPExcel->getActiveSheet()->setCellValue("S$row", "v");
            } else {
                $objPHPExcel->getActiveSheet()->setCellValue("S$row", "-");
            }
            
            if($tr->INT_IDCARD_STAT == 1){
                $objPHPExcel->getActiveSheet()->setCellValue("T$row", "v");
            } else {
                $objPHPExcel->getActiveSheet()->setCellValue("T$row", "-");
            }
            
            if($tr->INT_SEPATU_STAT == 1){
                $objPHPExcel->getActiveSheet()->setCellValue("U$row", "v");
            } else {
                $objPHPExcel->getActiveSheet()->setCellValue("U$row", "-");
            }
            
            if($tr->INT_GANJAL_STAT == 1){
                $objPHPExcel->getActiveSheet()->setCellValue("V$row", "v");
            } else {
                $objPHPExcel->getActiveSheet()->setCellValue("V$row", "-");
            }
            
            if($tr->INT_SIM_STAT == 1){
                $objPHPExcel->getActiveSheet()->setCellValue("W$row", "v");
            } else {
                $objPHPExcel->getActiveSheet()->setCellValue("W$row", "-");
            }
            
            if($tr->INT_APAR_STAT == 1){
                $objPHPExcel->getActiveSheet()->setCellValue("X$row", "v");
            } else {
                $objPHPExcel->getActiveSheet()->setCellValue("X$row", "-");
            }
            
            if($tr->INT_OLI_STAT == 1){
                $objPHPExcel->getActiveSheet()->setCellValue("Y$row", "v");
            } else {
                $objPHPExcel->getActiveSheet()->setCellValue("Y$row", "-");
            }

            $no++;
            $row++;
        }
            
        $objPHPExcel->getActiveSheet()->getStyle("B7:Y$row")->applyFromArray(array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        ));
        
        ob_end_clean();
        $filename = "History Absent Delivery - $date.xls";
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . trim($filename) . '"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->setIncludeCharts(TRUE);
        $objWriter->save('php://output');
    }
    
    function export_excel_monthly(){
        $user_session = $this->session->all_userdata();
        $periode = $this->input->post('periode');
        $pic = $this->session->userdata('NPK');
        
        $date_now = date("Ymd");
        $time_now = date("His");
        
        $row = 7;
        
        $this->load->library('excel');
        $objReader = PHPExcel_IOFactory::createReader('Excel5');
        
        $objPHPExcel = $objReader->load("assets/template/delivery/Template History Absent Monthly.xls");
        $objPHPExcel->getActiveSheet()->setCellValue("B2", "HISTORY ABSENT MILKRUN MONTHLY : " . strtoupper(date("F", mktime(null, null, null, substr($periode, 4, 2)))). ' ' . substr($periode,0,4));
        
        $history = $this->master_schedule_cust_m->get_history_absent_monthly($periode);
        $no = 1;
        foreach ($history as $tr) {
            $judge_in = '-';
            if($tr->INT_CHECKIN_STAT == 2 && $tr->CHR_TIME_CHECKIN != NULL){
                $judge_in = 'Delayed';
            } else if($tr->INT_CHECKIN_STAT == 1 && $tr->CHR_TIME_CHECKIN != NULL){
                $judge_in = 'Advanced';
            } else if($tr->INT_CHECKIN_STAT == 0 && $tr->CHR_TIME_CHECKIN != NULL){
                $judge_in = 'On Time';
            }
            
            $judge_out = '-';
            if($tr->INT_CHECKOUT_STAT == 2 && $tr->CHR_TIME_CHECKOUT != NULL){
                $judge_out = 'Delayed';
            } else if($tr->INT_CHECKOUT_STAT == 1 && $tr->CHR_TIME_CHECKOUT != NULL){
                $judge_out = 'Advanced';
            } else if($tr->INT_CHECKIN_STAT == 0 && $tr->CHR_TIME_CHECKOUT != NULL){
                $judge_out = 'On Time';
            }
            
            $judge_lk3 = '-';
            if($tr->SCORING == '1' && $tr->CHR_TIME_CHECKIN != NULL){
                $judge_lk3 = 'Very Good';
            } else if(($tr->SCORING >= 0.8) && ($tr->SCORING <= 0.99) && $tr->CHR_TIME_CHECKIN != NULL){
                $judge_lk3 = 'Good';
            } else if(($tr->SCORING >= 0.7) && ($tr->SCORING <= 0.79) && $tr->CHR_TIME_CHECKIN != NULL){
                $judge_lk3 = 'Fair';
            } else if(($tr->SCORING < 0.7) && $tr->CHR_TIME_CHECKIN == NULL){
                $judge_lk3 = 'Poor';
            }
            
            $objPHPExcel->getActiveSheet()->setCellValue("B$row", "$no");
            $objPHPExcel->getActiveSheet()->setCellValue("C$row", $tr->CHR_DATE_CHECKIN);
            $objPHPExcel->getActiveSheet()->setCellValue("D$row", $tr->CHR_CUST);
            $objPHPExcel->getActiveSheet()->setCellValue("E$row", $tr->CHR_CUST_DESC);
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $tr->CHR_DIS_CHANNEL);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $tr->INT_CYCLE);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $tr->CHR_CUST_DOCK);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $tr->CHR_ROUTE);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $tr->CHR_LOG_VENDOR);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", date('H:i', strtotime($tr->CHR_AII_ARRIVAL)));
            
            if($tr->CHR_TIME_CHECKIN != NULL){
                $objPHPExcel->getActiveSheet()->setCellValue("L$row", date('H:i', strtotime($tr->CHR_TIME_CHECKIN)));
            } else {
                $objPHPExcel->getActiveSheet()->setCellValue("L$row", "-");
            }
            
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", $judge_in);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", date('H:i', strtotime($tr->CHR_AII_DEPARTURE)));
            
            if($tr->CHR_TIME_CHECKOUT != NULL){
                $objPHPExcel->getActiveSheet()->setCellValue("O$row", date('H:i', strtotime($tr->CHR_TIME_CHECKOUT)));
            } else {
                $objPHPExcel->getActiveSheet()->setCellValue("O$row", "-");
            }
            
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $judge_out);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $tr->SCORING);
            $objPHPExcel->getActiveSheet()->setCellValue("R$row", $judge_lk3);
            
            if($tr->INT_HELM_STAT == 1){
                $objPHPExcel->getActiveSheet()->setCellValue("S$row", "v");
            } else {
                $objPHPExcel->getActiveSheet()->setCellValue("S$row", "-");
            }
            
            if($tr->INT_ROMPI_STAT == 1){
                $objPHPExcel->getActiveSheet()->setCellValue("T$row", "v");
            } else {
                $objPHPExcel->getActiveSheet()->setCellValue("T$row", "-");
            }
            
            if($tr->INT_IDCARD_STAT == 1){
                $objPHPExcel->getActiveSheet()->setCellValue("U$row", "v");
            } else {
                $objPHPExcel->getActiveSheet()->setCellValue("U$row", "-");
            }
            
            if($tr->INT_SEPATU_STAT == 1){
                $objPHPExcel->getActiveSheet()->setCellValue("V$row", "v");
            } else {
                $objPHPExcel->getActiveSheet()->setCellValue("V$row", "-");
            }
            
            if($tr->INT_GANJAL_STAT == 1){
                $objPHPExcel->getActiveSheet()->setCellValue("W$row", "v");
            } else {
                $objPHPExcel->getActiveSheet()->setCellValue("W$row", "-");
            }
            
            if($tr->INT_SIM_STAT == 1){
                $objPHPExcel->getActiveSheet()->setCellValue("X$row", "v");
            } else {
                $objPHPExcel->getActiveSheet()->setCellValue("X$row", "-");
            }
            
            if($tr->INT_APAR_STAT == 1){
                $objPHPExcel->getActiveSheet()->setCellValue("Y$row", "v");
            } else {
                $objPHPExcel->getActiveSheet()->setCellValue("Y$row", "-");
            }
            
            if($tr->INT_OLI_STAT == 1){
                $objPHPExcel->getActiveSheet()->setCellValue("Z$row", "v");
            } else {
                $objPHPExcel->getActiveSheet()->setCellValue("Z$row", "-");
            }

            $no++;
            $row++;
        }
            
        $objPHPExcel->getActiveSheet()->getStyle("B7:Z$row")->applyFromArray(array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        ));
        
        ob_end_clean();
        $filename = "History Absent Delivery Monthly - $periode.xls";
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . trim($filename) . '"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->setIncludeCharts(TRUE);
        $objWriter->save('php://output');
    }
    
}
