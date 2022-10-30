<?php

class maria_elkb_c extends CI_Controller
{

    private $layout = '/template/head';
    private $back_to_upload = 'pes/maria_elkb_c/upload_data_part/';
    private $back_to_manage = 'pes/maria_elkb_c/index/';
    private $back_to_trolley = 'pes/maria_elkb_c/trolley_data/';

    public function __construct()
    {
        parent::__construct();

        $this->load->model('pes/maria_elkb_m');
        // $this->load->model('ines/ines_m');
        $this->load->model('organization/dept_m');
        $this->load->model('pes_new/report_prod_part_ng_ok_m');
        $this->load->helper(array('form', 'url', 'inflector'));
        $this->load->library(array('PHPExcel', 'PHPExcel/IOFactory'));
    }

    function index($msg = NULL)
    {
        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Creating success </strong> The data is successfully created </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Updating success </strong> The data is successfully updated </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Deleted success </strong> The data is successfully deleted </div >";
        } elseif ($msg == 4) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Data Already Exist !</strong> Silahkan input data part yang lainnya</div >";
        }

        $data['content'] = 'pes/maria_elkb/manage_data_lkb_v';
        $data['title'] = 'Manage Data E-LKB';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(249);
        $data['news'] = $this->news_m->get_news();
        $data['msg'] = $msg;

        if ($this->input->post("filter") == 1) {
            $date_from = date("Ymd", strtotime($this->input->post("CHR_DATE_FROM")));
            $date_to = date("Ymd", strtotime($this->input->post("CHR_DATE_TO")));
        } else {
            $date_from = date("Ymd");
            $date_to = date("Ymd");
        }

        $data['date_from'] = $date_from;
        $data['date_to'] = $date_to;
        $data['no_troll'] = $this->maria_elkb_m->trolley_rsvn();
        $data['rsvr_troll'] = $this->maria_elkb_m->reserv_trolley_h();
        $this->load->view($this->layout, $data);
    }

    function create_rsv_elkb()
    {
        $data['content'] = 'pes/maria_elkb/create_rsvr_elkb_v';
        $data['title'] = 'Add Data Reservasi E-LKB';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(249);
        $data['news'] = $this->news_m->get_news();
        $data['no_troll'] = $this->maria_elkb_m->trolley_aktif();

        $this->load->view($this->layout, $data);
    }

    function save_data_rsvr()
    {
        $date_now = date("ymd");
        $no_troll = trim($this->input->post('CHR_TROLL'));
        $desc = trim($this->input->post('CHR_DESC'));
        $desc = strtoupper($desc);
        $session = $this->session->all_userdata();

        $cek_seq = $this->db->query("SELECT TOP 1 * FROM TM_SEQUENCE_01 WHERE CHR_COD_EXE = 'RSVN_ELKB' and CHR_DATE_CREATED = '$date_now'");
        if ($cek_seq->num_rows() == 0) {
            $ist_seq = $this->db->query("insert into TM_SEQUENCE_01 (CHR_COD_EXE,CHR_DATE_CREATED,CHR_KEY1,INT_SERIAL_NUMBER) values ('RSVN_ELKB','$date_now','J901','0')");
            $noseq = 0;
        } else {
            $seq_d = $cek_seq->result();
            $noseq = $seq_d[0]->INT_SERIAL_NUMBER;
            $noseq = $noseq + 1;
            $upt_seq = $this->db->query("update TM_SEQUENCE_01 set INT_SERIAL_NUMBER='$noseq' where CHR_COD_EXE = 'RSVN_ELKB' and CHR_DATE_CREATED = '$date_now'");
        }
        $seq = strlen($noseq);
        switch ($seq) {
            case 0:
                $x = "00";
                break;
            case 1:
                $x = "00";
                break;
            case 2:
                $x = "0";
                break;
            case 3:
                $x = "";
                break;
        }
        $id_elkb = "LKB" . $date_now . $x . $seq;

        $lkb_h = $this->db->query("SELECT TOP 1 * FROM TT_RESERVASI_ELKB_H WHERE CHR_TROLLEY_ID = '$no_troll' and CHR_STATUS = 'F'");
        if ($lkb_h->num_rows() == 0) {
            $data_tr = array(
                'CHR_ID_ELKB' => $id_elkb,
                'CHR_TROLLEY_ID' => $no_troll,
                'CHR_DESC' => $desc,
                'CHR_STAT_FINISH' => 'F',
                'CHR_NPK_CREATE' => $session['NPK'],
                'CHR_DATE_CREATE' => date("Ymd"),
                'CHR_TIME_CREATE' => date("His")
            );
            $this->maria_elkb_m->save_rsvn_lkb($data_tr);

            redirect($this->back_to_manage . $msg = 1);
        } else {
            redirect($this->back_to_manage . $msg = 4);
        }
    }

    function back_troll()
    {
        redirect($this->back_to_trolley);
    }

    function back_elkb()
    {
        redirect($this->back_to_manage);
    }

    function trolley_data($msg = NULL)
    {
        $this->role_module_m->authorization('302');

        // $data['data_problem_type'] = $this->problem_type_m->get_problem_type();
        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Creating success </strong> The data is successfully created </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Updating success </strong> The data is successfully updated </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Deleted success </strong> The data is successfully deleted </div >";
        } elseif ($msg == 4) {
            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Sukses re-Explode BOM</strong></div >";
        } elseif ($msg == 12) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Executing error !</strong> Something error with parameter </div >";
        }
        $data['msg'] = $msg;
        $data['data_elina'] = $this->maria_elkb_m->get_data_elina();

        $data['content'] = 'pes/maria_elkb/list_trolley_elkb_v';
        $data['title'] = 'List Prod Nomor';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(302);
        $data['news'] = $this->news_m->get_news();


        $this->load->view($this->layout, $data);
    }

    function reexplode($id)
    {
        $cek_prd = $this->db->query("SELECT TOP 1 * FROM PRD.TT_ELINA_H WHERE INT_ID = '$id'")->result();
        $prdno = $cek_prd[0]->CHR_PRD_ORDER_NO;
        $this->maria_elkb_m->reexplode($id,$prdno);
        redirect($this->back_to_trolley . $msg = 4);
    }

    function create_data_trolley()
    {
        $data['content'] = 'pes/maria_elkb/create_trolley_elkb_v';
        $data['title'] = 'Add Data Trolley Part NG';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(302);
        $data['news'] = $this->news_m->get_news();
        // $data['data'] = $this->maria_elkb_m->get_data_by_id($pno,$bno);

        $this->load->view($this->layout, $data);
    }

    function save_data_trolley()
    {
        $no = trim($this->input->post('CHR_NO'));
        $area = trim($this->input->post('CHR_AREA'));
        // $cat = $this->input->post('CHR_CAT');
        $session = $this->session->all_userdata();
        $no_troll = strlen($no);
        switch ($no_troll) {
            case 0:
                $x = "00";
                break;
            case 1:
                $x = "00";
                break;
            case 2:
                $x = "0";
                break;
            case 3:
                $x = "";
                break;
        }
        $troll_id = $area . $x . $no;
        //        if (date('G') < 6) {
        //            $date = date('Ymd', strtotime(date('Ymd') . ' - 1 days'));
        //        } else {
        //            $date = date('Ymd');
        //        }
        //
        $data_prod = $this->db->query("SELECT TOP 1 * FROM PRD.TM_TROLLEY_NG WHERE CHR_AREA = '$area' and CHR_NO = '$no'");
        if ($data_prod->num_rows() == 0) {
            $data_tr = array(
                'CHR_AREA' => $area,
                'CHR_NO' => $no,
                'CHR_TROLLEY_ID' => $troll_id,
                'CHR_NPK_CREATE' => $session['NPK'],
                'CHR_DATE_CREATE' => date("Ymd"),
                'CHR_TIME_CREATE' => date("His")
            );
            $this->maria_elkb_m->save_troll($data_tr);

            redirect($this->back_to_trolley . $msg = 1);
        } else {
            redirect($this->back_to_trolley . $msg = 4);
        }
    }

    function edit_dt_trolley($id)
    {
        $data['content'] = 'pes/maria_elkb/edit_trolley_elkb_v';
        $data['title'] = 'Edit Data Trolley NG';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(302);
        $data['news'] = $this->news_m->get_news();

        $data['data'] = $this->maria_elkb_m->get_trolley_id($id);

        $this->load->view($this->layout, $data);
    }

    function update_dt_trolley()
    {
        $this->form_validation->set_rules('CHR_FLAG', 'Stat Aktif', 'required|alpha|char|max_length[1]|min_length[1]');

        $troll = $this->input->post('CHR_TROLL');
        $area = $this->input->post('CHR_AREA');
        $flag = $this->input->post('CHR_FLAG');
        $flag = strtoupper($flag);

        if ($this->form_validation->run() == FALSE) {
            $this->edit_dt_trolley($troll);
        } else {
            $data_array = array(
                'CHR_FLAG_STATUS' => $flag,
                'CHR_NPK_UPDATE' => $this->session->userdata('NPK'),
                'CHR_TIME_UPDATE' => date('His'),
                'CHR_DATE_UPDATE' => date('Ymd')
            );

            $this->part_per_line_m->update($data_array, $pno, $bno);
            redirect($this->back_to_trolley . $msg = 2);
        }
    }
}
