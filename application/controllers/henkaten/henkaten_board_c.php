<?php

class henkaten_board_c extends CI_Controller {

    private $layout = '/template/head';
    private $back_to_manage = 'henkaten/henkaten_board_c/index/';

    public function __construct() {
        parent::__construct();
        $this->load->model('henkaten/henkaten_material_m');
        $this->load->model('henkaten/henkaten_method_m');
        $this->load->model('henkaten/henkaten_man_m');
        $this->load->model('henkaten/henkaten_machine_m');
    }

    public function index() {
        $content = 'henkaten/henkaten_board_v';
        $data['title'] = "Henkaten Board";

        $data['data_henkaten_machine'] = $this->henkaten_machine_m->get_henkaten_machine();
        $data['data_henkaten_method'] = $this->henkaten_method_m->get_henkaten_method();
        $data['data_henkaten_man'] = $this->henkaten_man_m->get_henkaten_man();
        $data['data_henkaten_material'] = $this->henkaten_material_m->get_henkaten_material();

        $this->load->view($content, $data);
    }

    public function updateAjax() {
        $data = $this->henkaten_material_m->get_henkaten_material_perday();

        $data_table = "";
        $data_table .= "<table style='width:100%;font-weight:600;padding:10px;' border='0px'>";

        $data_table .= "<thead><tr style='height:50px;background:#18181E;'>
                                            <td style='text-align: center;'>NO</th>
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
                $status = "<td style='padding:5px;'><img src=" . base_url('assets/henkaten_assets/img/matrik1.png') . " width='50' height='50'></td>";
            } else if ($isi->INT_STATUS == 1) {
                $status = "<td style='padding:5px;'><img src=" . base_url('assets/henkaten_assets/img/matrik2.png') . " width='50' height='50'></td>";
            } else if ($isi->INT_STATUS == 2) {
                $status = "<td style='padding:5px;'><img src=" . base_url('assets/henkaten_assets/img/matrik3.png') . " width='50' height='50'></td>";
            } else {
                $status = "<td style='padding:5px;'><img src=" . base_url('assets/henkaten_assets/img/matrik4.png') . " width='50' height='50'></td>";
            }

            if ($i % 2 == 0) {
                $data_table .= "<tr class='gradeX' style='background-color:#013D80;'>";
            } else {
                $data_table .= "<tr class='gradeX' style='background-color:#1D6BDD;'>";
            }
            $data_table .= "<td>$i</td>";
            $data_table .= "<td>$isi->CHR_SUB_SECTION_PIC</td>";
            $data_table .= "<td>$isi->CHR_BACK_NO</td>";
            $data_table .= "<td style='text-align: left;'>$isi->CHR_QPROBLEM_TITLE</td>";
            $data_table .= "<td>$startdate</td>";
            $data_table .= "<td>$starttime</td>";
            $data_table .= "<td>$duedate</td>";
            $data_table .= "<td>$duetime</td>";
            $data_table .= $status;
            $data_table .= "</tr>";
            $i++;
        }

        $data_table .= "<tbody>";
        $data_table .= "</table>";

        echo json_encode($data_table);
    }

}
