<?php

class quality_dashboard_c extends CI_Controller {

    private $layout = '/template/head';
    private $back_to_manage = 'room/room_reservation_c/index/';

    public function __construct() {
        parent::__construct();
        $this->load->model('quality/quality_problem_m');
        $this->load->model('quality/quality_feedback_m');
    }

    public function index($periode = NULL) {
        if ($periode == NULL){
            $periode = '201701'; //date('Ym');
        }
        
        $content = 'quality/dashboard/quality_dashboard_v';
        $data['title'] = "Quality Dashboard";

        $data['data_detail'] = $this->quality_problem_m->get_quality_problem_by_id(1);
        $data['data'] = $this->quality_problem_m->get_quality_problem_perday();
        $data['row'] = $this->quality_problem_m->get_problem_count($periode);

        $this->load->view($content, $data);
    }

    public function updateAjax() {
        //$data = $this->quality_problem_m->get_quality_problem_perday();
        $data = $this->quality_problem_m->get_quality_problem_perday();

        $data_table = "";
        $data_table .= "<table style='width:100%;font-weight:600;padding:10px;' border='0px'>";

        $data_table .= "<thead><tr style='height:50px;background:#18181E;'>
                                            <td style='text-align: center;'>NO</th>
                                            <td style='text-align: center;'>REQUESTOR</th>
                                            <td style='text-align: center;'>BEFORE PROCESS</th>
                                            <td style='text-align: center;'>BACK NO</th>
                                            <td style='text-align: center;'>PROBLEM</th>
                                            <td colspan='2' style='text-align: center;'>ACCEPTED DATE</th>
                                            <td colspan='2' style='text-align: center;'>DUE DATE</th>
                                            <td style='text-align: center;'>STATUS</th>
                                        </tr>
                                    </thead><tbody>";
        
        $i = 1;
        foreach ($data as $isi) {
            
            $starttime = date("H:i", strtotime($isi->CHR_START_TIME));
            $duetime = date("H:i", strtotime($isi->CHR_DUE_TIME));
            $startdate = date("d-m-Y", strtotime($isi->CHR_START_DATE));
            $duedate = date("d-m-Y", strtotime($isi->CHR_START_DATE));
            
            if ($isi->INT_STATUS == 0) {
                $status = "<td style='padding:5px;'><img src=" . base_url('assets/quality_assets/img/matrik1.png') . " width='50' height='50'></td>";
            } else if ($isi->INT_STATUS == 1) {
                $status = "<td style='padding:5px;'><img src=" . base_url('assets/quality_assets/img/matrik2.png') . " width='50' height='50'></td>";
            } else if ($isi->INT_STATUS == 2) {
                $status = "<td style='padding:5px;'><img src=" . base_url('assets/quality_assets/img/matrik3.png') . " width='50' height='50'></td>";
            } else {
                $status = "<td style='padding:5px;'><img src=" . base_url('assets/quality_assets/img/matrik4.png') . " width='50' height='50'></td>";
            }

            if ($i % 2 == 0) {
                if ($isi->INT_STATUS == 3){
                    $data_table .= "<tr class='gradeX' style='background-color:#00EE00;'>";
                } else {
                    $data_table .= "<tr class='gradeX' style='background-color:#000000;'>";
                }
            } else {
                if ($isi->INT_STATUS == 3){
                    $data_table .= "<tr class='gradeX' style='background-color:#00EE00;'>";
                } else {
                    $data_table .= "<tr class='gradeX' style='background-color:#333333;'>";
                }
            }
            
            $data_table .= "<td>$i</td>";
            $data_table .= "<td>$isi->CHR_SECTION_REQ</td>";
            $data_table .= "<td>$isi->CHR_SECTION_PIC</td>";
            $data_table .= "<td>$isi->CHR_BACK_NO</td>";
            $data_table .= "<td style='text-align: left;'>$isi->CHR_QPROBLEM_TITLE</td>";
            $data_table .= "<td>$startdate</td>";
            $data_table .= "<td>$starttime</td>";
            $data_table .= "<td style='color: gold;'>$duedate</td>";
            $data_table .= "<td style='color: gold;'>$duetime</td>";
            $data_table .= $status;
            $data_table .= "</tr>";
            $i++;
        }

        $data_table .= "<tbody>";
        $data_table .= "</table>";

        echo json_encode($data_table);
    }

}
