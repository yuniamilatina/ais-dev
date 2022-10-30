<?php

class overtime_c extends CI_Controller
{

    private $layout = '/template/head';
    private $back_to_approve_spv = '/aorta/overtime_c/prepare_approve_ot_by_spv/';
    private $back_to_approve_mgr = '/aorta/overtime_c/prepare_approve_ot_by_mgr/';
    private $back_to_approve_gm = '/aorta/overtime_c/prepare_approve_ot_by_gm/';
    private $back_to_approve_mgr_and_gm = '/aorta/overtime_c/prepare_approve_ot_by_mgr_and_gm/';
    private $back_to_index = '/aorta/overtime_c/index/';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('aorta/overtime_m');
        $this->load->model('aorta/quota_employee_m');
        $this->load->model('aorta/history_m');
        $this->load->model('organization/division_m');
        $this->load->model('organization/groupdept_m');
        $this->load->model('organization/dept_m');
    }

    function index($period = null, $dept = null, $section = null, $msg = NULL)
    {
        if ($msg == 1) {
            $msg = "<div class = 'alert alert-success'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Save success </strong> The data is successfully Save </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-success'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Update success </strong> The data is successfully Udpate </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-success'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Approve success </strong> The data is successfully Approve </div >";
        } elseif ($msg == 4) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Delete success </strong> The data is successfully delete </div >";
        } elseif ($msg == 5) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Reject success </strong> The data is successfully Reject </div >";
        } elseif ($msg == 12) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Executing error !</strong> Something error with parameter </div >";
        }

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(89);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Manage OT';
        $data['msg'] = $msg;

        $user_session = $this->session->all_userdata();
        $npk = $user_session['NPK'];
        $role = $user_session['ROLE'];
        $id_dept = $user_session['DEPT'];
        $id_group = $user_session['GROUPDEPT'];
        $id_division = $user_session['DIVISION'];

        if ($period == NULL) {
            $period = date('Ym');
        }

        if ($role == 1) {
            if ($dept == NULL) {
                $dept = $this->dept_m->get_top_data_dept_by_division($id_division)->row()->CHR_DEPT;
            } else {
                $dept = $dept;
            }
            $data['all_dept'] = $this->dept_m->get_dept_by_division_id($id_division);
        } else {
            if ($dept == NULL) {
                $dept = $this->dept_m->get_data_dept($id_dept)->row()->CHR_DEPT;
            } else {
                $dept = $dept;
            }
            $data['all_dept'] = $this->dept_m->get_data_dept($id_dept)->result();
        }

        $data['all_section'] = $this->overtime_m->get_section_overtime($dept);
        $data['top_section'] = $this->overtime_m->get_top_section_overtime($dept);

        if ($section == NULL) {
            $x = 0;
            foreach ($data['top_section'] as $value) {
                if (trim($value->KODE) == trim($section)) {
                    $x = 1;
                }
            }
        }else if ($section == 'ALL') {
            $x = 0;
            foreach ($data['all_section'] as $value) {
                if (trim($value->KODE) == trim($section)) {
                    $x = 1;
                }
            }
            if ($x == 0) {
                foreach ($data['top_section'] as $value) {
                    if (trim($value->KODE) == trim($section)) {
                        $x = 1;
                    }
            }
        }else {
            $x = 0;
            foreach ($data['all_section'] as $value) {
                if (trim($value->KODE) == trim($section)) {
                    $x = 1;
                }
            }
            if ($x == 0) {
                foreach ($data['top_section'] as $value) {
                    if (trim($value->KODE) == trim($section)) {
                        $x = 1;
                    }
            }
        }

        $data['npk'] = $npk;
        $data['role'] = $role;
        $data['dept'] = $dept;
        $data['section'] = $section;
        $data['period'] = $period;

        $data['data'] = $this->overtime_m->get_data_overtime($dept, $period, $section);

        $data['content'] = 'aorta/overtime/manage_overtime_v';
        $this->load->view($this->layout, $data);
    }

    function create_overtime($period = null, $dept = null, $section = null)
    {
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(89);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Create OT';

        $data['dept'] = $dept;
        $data['all_dept'] = $this->overtime_m->get_dept_overtime();
        if ($dept == null || $dept == '') {
            $dept = $this->overtime_m->get_top_dept_overtime()->row()->KODE;
        }
        
        $data['section'] = $section;
        $data['all_section'] = $this->overtime_m->get_section_overtime($dept);
        if ($section == NULL) {
            $section = $this->overtime_m->get_top_section_overtime($dept)->row()->KODE;
        } else {
            $x = 0;
            foreach ($data['all_section'] as $value) {
                if (trim($value->KODE) == trim($section)) {
                    $x = 1;
                }
            }
            if ($x == 0) {
                $section = $this->overtime_m->get_top_section_overtime($dept)->row()->KODE;
            }
        }
        
        // $sub_section = $this->overtime_m->get_top_sub_section_overtime($section);
        // $data['sub_section'] = $sub_section; //->row()->KODE;
        // $data['all_sub_section'] = $this->overtime_m->get_sub_section_overtime($section);

        $data['npk_pic'] = $this->overtime_m->get_top_pic_overtime($section);
        $data['all_pic'] = $this->overtime_m->get_pic_overtime($section);

        $data['all_employee'] = $this->overtime_m->get_employee_by_section($dept, $section);
        $data['all_category'] = $this->overtime_m->get_category();

        $data['cat_ot'] = $this->overtime_m->get_top_category();
        $data['period'] = $period;
        $data['shift'] = 1;
        $data['alasan'] = '';
        $data['date'] = date('d/m/Y');

        $data['data'] = $this->overtime_m->get_temp_data_overtime_by_organization($dept, $section, date('Ymd'));

        $data['content'] = 'aorta/overtime/create_overtime_v';
        $this->load->view($this->layout, $data);
    }

    function edit_overtime($no_spkl, $otdate = null, $dept = null, $section = null)
    {
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(89);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Edit OT';

        $data['dept'] = $dept;
        $data['all_dept'] = $this->overtime_m->get_dept_overtime();

        $data['all_section'] = $this->overtime_m->get_section_overtime($dept);
        $data['section'] = $section;

        $sub_section = $this->overtime_m->get_top_sub_section_overtime($section);
        $data['sub_section'] = $sub_section->row()->KODE;
        $data['all_sub_section'] = $this->overtime_m->get_sub_section_overtime($section);

        $data['npk_pic'] = $this->overtime_m->get_top_pic_overtime($section);
        $data['all_pic'] = $this->overtime_m->get_pic_overtime($section);

        $data['all_employee'] = $this->overtime_m->get_employee_overtime($section);
        $data['all_category'] = $this->overtime_m->get_category();

        $data['cat_ot'] = $this->overtime_m->get_top_category();

        $data['shift'] = 1;

        $data['detail'] = $this->overtime_m->get_top_temp_data_overtime_by_no_spkl($no_spkl);
        $data['alasan'] = '';
        $year = substr($otdate, 0, 4);
        $month = substr($otdate, 4, 2);
        $date = substr($otdate, 6, 2);

        $data['date'] = $date . '/' . $month . '/' . $year;

        $data['data'] = $this->overtime_m->getTempOvertimebyId($no_spkl);
        $data['no_spkl'] = $no_spkl;

        $data['content'] = 'aorta/overtime/edit_overtime_v';
        $this->load->view($this->layout, $data);
    }

    function change_employee_by_dept()
    {
        $dept = $this->input->post("DEPT");

        $data = "";
        $data_employee = $this->overtime_m->get_employee_by_dept($dept);
        $top_employee = $this->overtime_m->get_top_employee_by_dept($dept);
        foreach ($data_employee as $row) {
            if (trim($top_employee->NPK) == trim($row->NPK)) {
                $data .= "<option selected value='$row->NPK'>" . $row->NPK . ' - ' . trim($row->NAMA) . "</option>";
            } else {
                $data .= "<option value='$row->NPK'>" . $row->NPK . ' - ' . trim($row->NAMA) . "</option>";
            }
        }

        $json_data = array('data' => $data);
        echo json_encode($json_data);
    }

    public function getListInProcessOvertime()
    {
        $tgl_overtime_with_slash = $this->input->post("tgl_overtime");
        $tgl_overtime = substr($tgl_overtime_with_slash, 6, 4) . substr($tgl_overtime_with_slash, 3, 2) . substr($tgl_overtime_with_slash, 0, 2);
        $dept = $this->input->post("dept");
        $section = $this->input->post("section");

        $data = "";
        $OvertimeInProcess = $this->overtime_m->getTempOvertimeInProcess($tgl_overtime, $dept, $section);

        foreach ($OvertimeInProcess as $row) {
            $data .= "<option value='$row->NO_SEQUENCE'>" . trim($row->NO_SEQUENCE) . "</option>";
        }

        echo json_encode($data);
    }

    public function getTempOvertime()
    {
        $no_sequence = $this->input->post("no_sequence");

        $data = "";
        $alasan = null;

        $tempOvertime = $this->overtime_m->getTempOvertimebyId($no_sequence);
        $i = 1;
        if ($tempOvertime) {
            foreach ($tempOvertime as $isi) {
                $data .= "<tr class='gradeX'>";
                $data .= "<td>$i</td>";
                $data .= "<td style='vertical-align: middle;text-align:center'><strong>$isi->NPK</strong></td>'";
                $data .= "<td style='vertical-align: middle;text-align:left'><strong>$isi->NAMA</strong></td>'";

                $data .= "<td style='vertical-align: middle;text-align:center'>" . substr($isi->RENC_MULAI_OV_TIME, 0, 2) . ":" . substr($isi->RENC_MULAI_OV_TIME, 2, 2) . "</td>";
                $data .= "<td style='vertical-align: middle;text-align:center'>" . substr($isi->RENC_SELESAI_OV_TIME, 0, 2) . ":" . substr($isi->RENC_SELESAI_OV_TIME, 2, 2) . "</td>";
                $data .= "<td style='vertical-align: middle;text-align:center'><strong>" . number_format((float) $isi->RENC_DURASI_OV_TIME / 60, 2, ',', '.') . "</strong></td>";
                $data .= "<td style='vertical-align: middle;text-align:center'>" . substr($isi->REAL_MULAI_OV_TIME, 0, 2) . ":" . substr($isi->REAL_MULAI_OV_TIME, 2, 2) . "</td>";
                $data .= "<td style='vertical-align: middle;text-align:center'>" . substr($isi->REAL_SELESAI_OV_TIME, 0, 2) . ":" . substr($isi->REAL_SELESAI_OV_TIME, 2, 2) . "</td>";
                $data .= "<td style='vertical-align: middle;text-align:center'><strong>" . number_format((float) $isi->REAL_DURASI_OV_TIME / 60, 2, ',', '.') . "</strong></td>";

                $data .= "<td style='vertical-align: middle;text-align:center'>" . 0 . "</td>";
                $data .= "<td style='vertical-align: middle;text-align:center'><strong>" . 0 . "</strong></td>";
                $data .= "<td style='vertical-align: middle;text-align:center'>";
                $data .= "<a onclick=removeNpk('$no_sequence','" . trim($isi->NPK) . "'); class='label label-danger' data-placement='right' data-toggle='tooltip' title='Remove' ><span class='fa fa-times'></span></a>";
                $data .= "</td>";
                $data .= "</tr>";

                $alasan = $isi->ALASAN;
                $i++;
            }
        } else {
            $data = false;
        }

        $json_data = array('data' => $data, 'alasan' => $alasan, 'no_sequence' => $no_sequence);

        echo json_encode($json_data);
    }

    function saveNpkOvertime()
    {
        $user_session = $this->session->all_userdata();
        $sub_section = '';
        $section = '';
        $dept = '';
        $group = '';
        $div = 'PLNT';
        $created_by = $user_session['USERNAME'];
        $date = date('Ymd');
        $time = date('His');
        $ip = gethostbyaddr($_SERVER['REMOTE_ADDR']);
        $ket = 'CREATE';
        $psnya = "Create Overtime by " . $created_by;

        if (date('N') >= 6) {
            $hari_kj = '1';
        } else {
            $hari_kj = '0';
        }

        $array_tgl = explode('/', $this->input->post("TGL_OVERTIME"));
        $tgl_ot = $array_tgl[2] . $array_tgl[1] . $array_tgl[0];
        $npk = $this->input->post("NPK");
        $cat_ot = $this->input->post("KAT_OT");
        $npk_pic = $this->input->post("NPK_PIC");
        $alasan = $this->input->post("ALASAN");

        if ($this->input->post("END_HOUR") > $this->input->post("START_HOUR")) {
            $jam = $this->input->post("END_HOUR") * 60 - $this->input->post("START_HOUR") * 60;
        } else {
            $jam = $this->input->post("START_HOUR") * 60 - $this->input->post("END_HOUR") * 60;
        }

        if ($this->input->post("END_MINUTE") > $this->input->post("START_MINUTE")) {
            $menit = $this->input->post("END_MINUTE") - $this->input->post("START_MINUTE");
        } else {
            $menit = $this->input->post("START_MINUTE") - $this->input->post("END_MINUTE");
        }

        $duration = $jam + $menit;

        $start = $this->input->post("START_HOUR") . $this->input->post("START_MINUTE") . '00';
        $end = $this->input->post("END_HOUR") . $this->input->post("END_MINUTE") . '00';

        $data_user = $this->overtime_m->get_detail_user_by_npk($npk);

        if ($data_user->num_rows() > 0) {
            $sub_section = $data_user->row()->KD_SUB_SECTION;
            $section = $data_user->row()->KD_SECTION;
            $dept = $data_user->row()->KD_DEPT;
            $group = $data_user->row()->KD_GROUP;
        }

        //$data_temp_overtime = $this->overtime_m->check_ot_by_section($section, $tgl_ot);
        if ($this->input->post("NO_SEQUENCE") == 0 || $this->input->post("NO_SEQUENCE") == null) {
            //bikin spkl
            $no_sequence = $this->overtime_m->get_candidate_id_overtime($array_tgl[2] . $array_tgl[1]);
        } else {
            //notif sudah bikin spkl
            $no_sequence = $this->input->post("NO_SEQUENCE");
        }

        //check duplicate overtime
        $data_temp_ot_npk = $this->overtime_m->check_ot_by_npk($npk, $tgl_ot);
        if ($data_temp_ot_npk == false) {
            //check quota employee
            $data_quota_employee = $this->quota_employee_m->get_data_quota_employee_by_period_and_npk($array_tgl[2] . $array_tgl[1], $npk);
            if ($data_quota_employee) {
                //check sisa quota employee
                $sisa_quota = (int)$data_quota_employee->SISAPLAN * 60;
                $durasi_ot = (int)$duration;
                //$a = $sisa_quota-$durasi_ot;
                if ($sisa_quota - $durasi_ot > 0) {
                    $data_insert = array(
                        'NO_SEQUENCE' => $no_sequence,
                        'TGL_OVERTIME' => $tgl_ot,
                        'KAT_OT' => $cat_ot,
                        'ALASAN' => $alasan,
                        'NPK' => $npk,
                        'NPK_PIC' => $npk_pic,
                        'KD_DEPT' => $dept,
                        'KD_SECTION' => $section,
                        'KD_SUB_SECTION' => $sub_section,
                        'KD_GROUP' => $group,
                        'KD_DIV' => $div,
                        'RENC_MULAI_OV_TIME' => $start,
                        'RENC_SELESAI_OV_TIME' => $end,
                        'RENC_DURASI_OV_TIME' => $duration,
                        'HARI_KJ' => $hari_kj,
                        'OVERTIME_KET' => 0,
                        'OPER_ENTRY' => 'DEV', //$created_by,
                        'TGL_ENTRY' => date('Ymd'),
                        'JAM_ENTRY' => date('His'),
                        'FLG_PRINT' => 1,
                        'OTVERSION' => 'AIS'
                    );

                    $this->overtime_m->save_temp_overtime($data_insert);

                    $data_history = array(
                        'TGLTRANS' => $date,
                        'JAMTRANS' => $time,
                        'OTCPU' => $ip,
                        'TIPETRANS' =>  $ket,
                        'NO_SEQUENCE' => $no_sequence,
                        'OPERTRANS' => $created_by,
                        'OTVERSION' => 'AIS',
                        'KETERANGAN' => $psnya
                    );

                    $this->history_m->save($data_history);

                    $msg = false;
                } else {
                    $msg = 'NPK ' . $npk . ' have not enough quota for this overtime, quota : ' . (int)$data_quota_employee->SISAPLAN . ' hours & overtime :' . (int)$duration / 60 . ' hour';
                }
            } else {
                $msg = 'NPK ' . $npk . ' have not quota for overtime for period ' . $array_tgl[2] . $array_tgl[1];
            }
        } else {
            $msg = 'NPK tersebut sudah terdaftar pada tanggal ' . $this->input->post("TGL_OVERTIME") . ' dengan nomor ' . $data_temp_ot_npk->NO_SEQUENCE;
        }

        $json_data['msg'] = $msg;
        $json_data['no_sequence'] = $no_sequence;

        echo json_encode($json_data);
    }

    function print_overtime($no_spkl)
    {
        $this->load->library('OvertimeFPDF');
        $pdf = $this->overtimefpdf->getInstance();
        $pdf->SetMargins(5, 5, 5);

        $overtime_head = $this->overtime_m->get_data_group_overtime_by_no_spkl($no_spkl);
        $tgl_overtime = date_format(date_create($overtime_head->TGL_OVERTIME), "d-m-Y");

        $pic_name = explode(' ', trim($overtime_head->NAMA));
        if (count($pic_name) > 2) {
            $pic_nickname = $pic_name[0] . ' ' . $pic_name[1] . ' ' . substr($pic_name[2], 0, 1) . '.';
        } else {
            $pic_nickname = trim($overtime_head->NAMA);
        }

        $pic_dept = explode(' ', trim($overtime_head->NAMA_PIC));
        if (count($pic_dept) > 2) {
            $pic_deptnickname = $pic_dept[0] . ' ' . $pic_dept[1] . ' ' . substr($pic_dept[2], 0, 1) . '.';
        } else {
            $pic_deptnickname = trim($overtime_head->NAMA_PIC);
        }

        $flg_approved_spv = $overtime_head->CEK_SPV == 0 ? '' : 'APPROVED';
        $flg_approved_mgr = $overtime_head->CEK_KADEP == 0 ? '' : 'APPROVED';
        $flg_approved_gm = $overtime_head->CEK_GM == 0 ? '' : 'APPROVED';
        $flg_approved_dir = $overtime_head->CEK_DIR == 0 ? '' : 'APPROVED';

        $data_header = array(
            'no_spkl' => $no_spkl,
            'tgl_overtime' => $tgl_overtime,
            'hari_overtime' => $overtime_head->HARI_OT,
            'hari_kerja' => $overtime_head->HARI_KJ,
            'keterangan' => $overtime_head->KETERANGAN,
            'dept' => $overtime_head->DEPT,
            'pic' => $pic_nickname,
            'penganggung_jawab' => $pic_deptnickname,
            'nama' => $overtime_head->NAMA,
            'flg_approved_spv' => $flg_approved_spv, 
            'flg_approved_mgr' => $flg_approved_mgr,
            'flg_approved_gm' => $flg_approved_gm
        );

        $pdf->setDataHeader($data_header);

        $footer_data = array(
            'flg_approved_mgr' => $flg_approved_mgr,
            'flg_approved_gm' => $flg_approved_gm,
            'flg_approved_spv' => $flg_approved_spv, 
            'desc_cat' => $overtime_head->CHR_DESC_CAT,
            'alasan' => $overtime_head->ALASAN,
            'pic' => $pic_nickname,
            'created_date' => date('d-F-Y')
        );

        $pdf->setDataFooter($footer_data);

        $pdf->AliasNbPages();
        $pdf->AddPage();
        $pdf->SetFont('Arial', '', 8);

        $overtime_detail = $this->overtime_m->get_data_overtime_by_no_spkl($no_spkl);

        $row_available = 30;
        $no = 1;
        $count = 1;
        foreach ($overtime_detail as $isi) {
            $name = explode(' ', trim($isi->NAMA));
            if (count($name) > 2) {
                $nickname = $name[0] . ' ' . $name[1] . ' ' . substr($name[2], 0, 1) . '.';
            } else {
                $nickname = trim($isi->NAMA);
            }

            if ($count == 30) {
                $pdf->Cell(155, 4, 'Jumlah MP : ' . $overtime_head->JUM_MP, 1, 0, 'L');
                $pdf->Cell(45, 4, 'Jumlah Quota : ' . $overtime_head->TERPAKAIPLAN, 1, 0, 'l');

                $pdf->AddPage();
                $count = 1;
            } else {
                $pdf->Cell(10, 4, $no, 1, 0, 'C');
                $pdf->Cell(15, 4, $isi->NPK, 1, 0, 'C');
                $pdf->Cell(70, 4, $nickname, 1, 0, 'L');
                $pdf->Cell(15, 4, trim($isi->KD_SECTION), 1, 0, 'C');
                $pdf->Cell(15, 4, $isi->RENCANA_MULAI, 1, 0, 'C');
                $pdf->Cell(15, 4, $isi->RENCANA_END, 1, 0, 'C');
                $pdf->Cell(15, 4, '', 1, 0, 'C');
                if ($isi->CEK_GM == 1) {
                    $pdf->Cell(15, 4, $isi->REALISASI_MULAI, 1, 0, 'C');
                    $pdf->Cell(15, 4, $isi->REALISASI_END, 1, 0, 'C');
                } else {
                    $pdf->Cell(15, 4, '', 1, 0, 'C');
                    $pdf->Cell(15, 4, '', 1, 0, 'C');
                }
                $pdf->Cell(15, 4, $isi->TERPAKAIPLAN, 1, 1, 'C');
            }

            $no++;
            $count++;
        }

        for ($i = 0; $i < $row_available - $no; $i++) {

            if ($i == $row_available - $no - 1) {
                $pdf->Cell(155, 4, 'Jumlah MP : ' . $overtime_head->JUM_MP, 1, 0, 'L');
                $pdf->Cell(45, 4, 'Jumlah Quota : ' . $overtime_head->TERPAKAIPLAN, 1, 0, 'l');
            } else {
                $pdf->Cell(10, 4, '', 1, 0, 'C');
                $pdf->Cell(15, 4, '', 1, 0, 'C');
                $pdf->Cell(70, 4, '', 1, 0, 'L');
                $pdf->Cell(15, 4, '', 1, 0, 'C');
                $pdf->Cell(15, 4, '', 1, 0, 'C');
                $pdf->Cell(15, 4, '', 1, 0, 'C');
                $pdf->Cell(15, 4, '', 1, 0, 'C');
                $pdf->Cell(15, 4, '', 1, 0, 'C');
                $pdf->Cell(15, 4, '', 1, 0, 'C');
                $pdf->Cell(15, 4, '', 1, 1, 'C');
            }
        }

        // $pdf->AutoPrint(false);
        $pdf->Output("OT-" . trim($no_spkl) . ".pdf", 'I');
    }


    function remove_npk()
    {
        $user_session = $this->session->all_userdata();
        $npk = $this->input->post("npk");
        $no_sequence = $this->input->post("no_sequence");
        $created_by = $user_session['USERNAME'];
        $date = date('Ymd');
        $time = date('His');
        $ip = gethostbyaddr($_SERVER['REMOTE_ADDR']);
        $ket = 'DELETE';
        $psnya = "Delete Overtime by " . $created_by;

        $status = $this->overtime_m->remove_npk_temp_ot($no_sequence, $npk);

        $data_history = array(
            'TGLTRANS' => $date,
            'JAMTRANS' => $time,
            'OTCPU' => $ip,
            'TIPETRANS' =>  $ket,
            'NO_SEQUENCE' => $no_sequence,
            'OPERTRANS' => $created_by,
            'OTVERSION' => 'AIS',
            'KETERANGAN' => $psnya
        );

        $this->history_m->save($data_history);

        echo json_encode($status);
    }

    function save_overtime()
    {
        $no_sequence = $this->input->post("NO_SEQUENCE");
        $dept = $this->input->post("KD_DEPT");
        $section = $this->input->post("KD_SECTION");
        $array_tgl = explode('/', $this->input->post("TGL_OVERTIME"));
        $period = $array_tgl[2] . $array_tgl[1];

        $update_status = $this->overtime_m->decrease_quota_employee_by_no_sequence($no_sequence, $period);
        $this->overtime_m->save($no_sequence, $period);

        redirect($this->back_to_index . $period . '/' . $dept . '/' . $section . '/' . 1);
    }

    function delete_overtime($no_sequence)
    {
        $data_ot = $this->overtime_m->getHeaderOvertimebyId($no_sequence);

        $dept = trim($data_ot->KD_DEPT);
        $section = trim($data_ot->KD_SECTION);
        $tgl_overtime = trim($data_ot->TGL_OVERTIME);
        $period = substr($tgl_overtime, 0, 6);

        $update_status = $this->overtime_m->increase_quota_employee_by_no_sequence($no_sequence, $period);
        $this->overtime_m->delete($no_sequence, $tgl_overtime);

        redirect($this->back_to_index . $period . '/' . $dept . '/' . $section . '/' . 4);
    }

    function view_detail_overtime()
    {
        $nospkl = $this->input->post("nospkl");
        $data_detail = $this->overtime_m->get_data_overtime_by_no_spkl($nospkl);
        $data = "";
        $i = 1;
        $tot_saldo = 0;
        $tot_plan = 0;
        $tot_real = 0;
        foreach ($data_detail as $isi) {
            $tot_saldo = $tot_saldo + $isi->SISAPLAN;
            $tot_plan = $tot_plan + ((float) $isi->RENC_DURASI_OV_TIME / 60);
            $tot_real = $tot_real + ((float) $isi->REAL_DURASI_OV_TIME / 60);
            $data .= "<tr class='gradeX'>";
            $data .= "<td>$i</td>";
            $data .= "<td style='vertical-align: middle;text-align:left'>" . $isi->TGL_OVERTIME . "</td>";
            $data .= "<td style='vertical-align: middle;text-align:center'><strong>" . $isi->NPK . "</strong></td>";
            $data .= "<td style='vertical-align: middle;text-align:left'><strong>" . $isi->NAMA . "</strong></td>";
            $data .= "<td style='vertical-align: middle;text-align:center'>" . $isi->KD_SUB_SECTION . "</td>";
            $data .= "<td style='vertical-align: middle;text-align:center'>" . $isi->QUOTA_STD . "</td>";
            $data .= "<td style='vertical-align: middle;text-align:center'>" . $isi->QUOTAPLAN . "</td>";
            $data .= "<td style='vertical-align: middle;text-align:center'>" . number_format($isi->TERPAKAIPLAN, 2, ',', '.') . "</td>";
            $data .= "<td style='vertical-align: middle;text-align:center'><strong>" . number_format($isi->SISAPLAN, 2, ',', '.') . "</strong></td>";
            $data .= "<td style='vertical-align: middle;text-align:center'>" . substr($isi->RENC_MULAI_OV_TIME, 0, 2) . ":" . substr($isi->RENC_MULAI_OV_TIME, 2, 2) . "</td>";
            $data .= "<td style='vertical-align: middle;text-align:center'>" . substr($isi->RENC_SELESAI_OV_TIME, 0, 2) . ":" . substr($isi->RENC_SELESAI_OV_TIME, 2, 2) . "</td>";
            $data .= "<td style='vertical-align: middle;text-align:center'><strong>" . number_format((float) $isi->RENC_DURASI_OV_TIME / 60, 2, ',', '.') . "</strong></td>";
            $data .= "<td style='vertical-align: middle;text-align:center'>" . substr($isi->REAL_MULAI_OV_TIME, 0, 2) . ":" . substr($isi->REAL_MULAI_OV_TIME, 2, 2) . "</td>";
            $data .= "<td style='vertical-align: middle;text-align:center'>" . substr($isi->REAL_SELESAI_OV_TIME, 0, 2) . ":" . substr($isi->REAL_SELESAI_OV_TIME, 2, 2) . "</td>";
            $data .= "<td style='vertical-align: middle;text-align:center'><strong>" . number_format((float) $isi->REAL_DURASI_OV_TIME / 60, 2, ',', '.') . "</strong></td>";
            $data .= "<td style='vertical-align: middle;text-align:center'>$isi->NPK_PIC</td>";
            $data .= "<td style='vertical-align: middle;text-align:center'>-</td>";
            $data .= "</tr>";

            $i++;
        }

        $data .= "<tr>";
        $data .= "<td colspan='8' align='center'><strong>TOTAL</strong></td>";
        $data .= "<td style='vertical-align: middle;text-align:center'><strong>" . number_format($tot_saldo, 2, ',', '.') . "</strong></td>";
        $data .= "<td colspan='2'></td>";
        $data .= "<td style='vertical-align: middle;text-align:center'><strong>" . number_format($tot_plan, 2, ',', '.') . "</strong></td>";
        $data .= "<td colspan='2'></td>";
        $data .= "<td style='vertical-align: middle;text-align:center'><strong>" . number_format($tot_real, 2, ',', '.') . "</strong></td>";
        $data .= "<td colspan='2'></td>";
        $data .= "</tr>";

        echo $data;
    }

    function view_detail_overtime_for_create_ot()
    {
        $nospkl = $this->input->post("nospkl");
        $data_detail = $this->overtime_m->get_data_overtime_by_no_spkl($nospkl);
        $data = "";
        $i = 1;
        $tot_saldo = 0;
        $tot_plan = 0;
        $tot_real = 0;
        foreach ($data_detail as $isi) {
            $tot_saldo = $tot_saldo + $isi->SISAPLAN;
            $tot_plan = $tot_plan + ((float) $isi->RENC_DURASI_OV_TIME / 60);
            $tot_real = $tot_real + ((float) $isi->REAL_DURASI_OV_TIME / 60);
            $data .= "<tr class='gradeX'>";
            $data .= "<td>$i</td>";
            $data .= "<td style='vertical-align: middle;text-align:left'>" . $isi->TGL_OVERTIME . "</td>";
            $data .= "<td style='vertical-align: middle;text-align:center'><strong>" . $isi->NPK . "</strong></td>";
            $data .= "<td style='vertical-align: middle;text-align:center'>" . $isi->KD_SUB_SECTION . "</td>";
            $data .= "<td style='vertical-align: middle;text-align:center'>" . $isi->QUOTA_STD . "</td>";
            $data .= "<td style='vertical-align: middle;text-align:center'>" . $isi->QUOTAPLAN . "</td>";
            $data .= "<td style='vertical-align: middle;text-align:center'>" . number_format($isi->TERPAKAIPLAN, 2, ',', '.') . "</td>";
            $data .= "<td style='vertical-align: middle;text-align:center'><strong>" . number_format($isi->SISAPLAN, 2, ',', '.') . "</strong></td>";
            $data .= "<td style='vertical-align: middle;text-align:center'>" . substr($isi->RENC_MULAI_OV_TIME, 0, 2) . ":" . substr($isi->RENC_MULAI_OV_TIME, 2, 2) . "</td>";
            $data .= "<td style='vertical-align: middle;text-align:center'>" . substr($isi->RENC_SELESAI_OV_TIME, 0, 2) . ":" . substr($isi->RENC_SELESAI_OV_TIME, 2, 2) . "</td>";
            $data .= "<td style='vertical-align: middle;text-align:center'><strong>" . number_format((float) $isi->RENC_DURASI_OV_TIME / 60, 2, ',', '.') . "</strong></td>";
            $data .= "<td style='vertical-align: middle;text-align:center'>" . substr($isi->REAL_MULAI_OV_TIME, 0, 2) . ":" . substr($isi->REAL_MULAI_OV_TIME, 2, 2) . "</td>";
            $data .= "<td style='vertical-align: middle;text-align:center'>" . substr($isi->REAL_SELESAI_OV_TIME, 0, 2) . ":" . substr($isi->REAL_SELESAI_OV_TIME, 2, 2) . "</td>";
            $data .= "<td style='vertical-align: middle;text-align:center'><strong>" . number_format((float) $isi->REAL_DURASI_OV_TIME / 60, 2, ',', '.') . "</strong></td>";
            $data .= "<td style='vertical-align: middle;text-align:center'>$isi->NPK_PIC</td>";
            $data .= "<td>";
            if ($isi->CEK_KADEP == '-' && $isi->CEK_GM == '-') {
                $data .= '';
            } else if ($isi->CEK_KADEP == 0 && $isi->CEK_GM == 0) {
                $data .= "<a disabled href=" . base_url("index.php/aorta/quota_employee_c/remove_employee_from_overtime") . "/" . $isi->NO_SEQUENCE . " class='label label-danger' data-placement='right' data-toggle='tooltip' title='Delete' onclick='return confirm(\"Are you sure want to remove this NPK?\");'><span class='fa fa-times'></span></a>";
            } else {
                $data .= "<a disabled style='cursor: not-allowed;' class='label label-default' data-placement='right' data-toggle='tooltip' title='Delete'><span class='fa fa-times'></span></a>";
            }
            $data .= "</td>";
            $data .= "</tr>";

            $i++;
        }

        $data .= "<tr>";
        $data .= "<td colspan='7' align='center'><strong>TOTAL</strong></td>";
        $data .= "<td style='vertical-align: middle;text-align:center'><strong>" . number_format($tot_saldo, 2, ',', '.') . "</strong></td>";
        $data .= "<td colspan='2'></td>";
        $data .= "<td style='vertical-align: middle;text-align:center'><strong>" . number_format($tot_plan, 2, ',', '.') . "</strong></td>";
        $data .= "<td colspan='2'></td>";
        $data .= "<td style='vertical-align: middle;text-align:center'><strong>" . number_format($tot_real, 2, ',', '.') . "</strong></td>";
        $data .= "<td colspan='2'></td>";
        $data .= "</tr>";

        echo $data;
    }

    //SUPERVISOR
    function prepare_approve_ot_by_spv($period = NULL, $dept = NULL, $section = null, $msg = NULL)
    {
        if ($msg == 4) {
            $msg = "<div class = 'alert alert-success'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Approve success </strong> The data is successfully Approve </div >";
        } elseif ($msg == 5) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Reject success </strong> The data is successfully Reject </div >";
        } elseif ($msg == 12) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Executing error !</strong> Something error with parameter </div >";
        }

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(32);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Approval OT';
        $data['msg'] = $msg;

        $user_session = $this->session->all_userdata();
        $role = $user_session['ROLE'];
        $id_dept = $user_session['DEPT'];
        $id_group = $user_session['GROUPDEPT'];
        $id_division = $user_session['DIVISION'];

        if ($period == NULL) {
            $period = date('Ym');
        }

        if ($role == 1) {
            if ($dept == NULL) {
                $dept = $this->dept_m->get_top_data_dept_by_division($id_division)->row()->CHR_DEPT;
            } else {
                $dept = $dept;
            }
            $data['all_dept'] = $this->dept_m->get_dept_by_division_id($id_division);
        } else {
            if ($dept == NULL) {
                $dept = $this->dept_m->get_data_dept($id_dept)->row()->CHR_DEPT;
            } else {
                $dept = $dept;
            }
            $data['all_dept'] = $this->dept_m->get_data_dept($id_dept)->result();
        }

        $data['all_section'] = $this->overtime_m->get_section_by_dept($dept);

        if ($section == NULL) {
            $section = 'ALL';
        } else {
            $x = 0;
            foreach ($data['all_section'] as $value) {
                if (trim($value->KODE) == trim($section)) {
                    $x = 1;
                }
            }

            if ($x == 0) {
                $section = 'ALL';
            }
        }

        $data['dept'] = trim($dept);
        $data['section'] = $section;
        $data['period'] = $period;

        $data['data'] = $this->overtime_m->get_data_overtime_by_spv(trim($dept), $period, $section);
        $data['content'] = 'aorta/overtime/manage_overtime_by_spv_v';
        $this->load->view($this->layout, $data);
    }

    function approve_form_overtime_by_spv()
    {
        $nospkl = $this->input->post("NO_SEQUENCE");
        $section = $this->input->post("CHR_SECTION");
        $dept = $this->input->post("CHR_DEPT");
        $period = $this->input->post("CHR_PERIOD");
        $created_by = $this->session->userdata('USERNAME');
        $date = date('Ymd');
        $time = date('His');
        $ip = gethostbyaddr($_SERVER['REMOTE_ADDR']);
        $type_action = $this->input->post("submit");

        if ($type_action == 1) {
            $ket = 'APPROVE';
            $psnya = "Approve Dokumen Planning by SPV";
            $msg_no = 4;
        } else {
            $ket = 'UN-APPROVE';
            $psnya = "Un-Approve Dokumen Planning by SPV";
            $msg_no = 5;
        }

        $data = array(
            'CEK_SPV' => $type_action,
            'OPER_EDIT' => $created_by,
            'TGL_EDIT' => $date,
            'JAM_EDIT' => $time
        );

        $this->overtime_m->update_overtime_by_id($data, $nospkl);

        $data_history = array(
            'TGLTRANS' => $date,
            'JAMTRANS' => $time,
            'OTCPU' => $ip,
            'TIPETRANS' =>  $ket,
            'NO_SEQUENCE' => $nospkl,
            'OPERTRANS' => $created_by,
            'OTVERSION' => 'AIS',
            'KETERANGAN' => $psnya
        );

        $this->history_m->save($data_history);

        redirect($this->back_to_approve_spv . $period . '/' . $dept . '/' . $section . '/' . $msg_no);
    }

    function approve_overtime_by_spv($nospkl, $period, $dept, $section = null)
    {
        $created_by = $this->session->userdata('USERNAME');
        $date = date('Ymd');
        $time = date('His');
        $psnya = "Approve Dokumen Planning by SPV";
        $ip = gethostbyaddr($_SERVER['REMOTE_ADDR']);

        $data = array(
            'CEK_SPV' => 1,
            'OPER_EDIT' => $created_by,
            'TGL_EDIT' => $date,
            'JAM_EDIT' => $time
        );

        $this->overtime_m->update_overtime_by_id($data, $nospkl);

        $data_history = array(
            'TGLTRANS' => $date,
            'JAMTRANS' => $time,
            'OTCPU' => $ip,
            'TIPETRANS' => 'APPROVE',
            'NO_SEQUENCE' => $nospkl,
            'OPERTRANS' => $created_by,
            'OTVERSION' => 'AIS',
            'KETERANGAN' => $psnya
        );

        $this->history_m->save($data_history);

        redirect($this->back_to_approve_spv . $period . '/' . $dept . '/' . $section . '/' . 4);
    }

    function unapprove_overtime_by_spv($nospkl, $period, $dept, $section = null)
    {
        $created_by = $this->session->userdata('USERNAME');
        $date = date('Ymd');
        $time = date('His');
        $psnya = "Unapprove Dokumen Planning by SPV";
        $ip = gethostbyaddr($_SERVER['REMOTE_ADDR']);

        $data = array(
            'CEK_SPV' => 0,
            'OPER_EDIT' => $created_by,
            'TGL_EDIT' => $date,
            'JAM_EDIT' => $time
        );

        $this->overtime_m->update_overtime_by_id($data, $nospkl);

        $data_history = array(
            'TGLTRANS' => $date,
            'JAMTRANS' => $time,
            'OTCPU' => $ip,
            'TIPETRANS' => 'UN-APPROVE',
            'NO_SEQUENCE' => $nospkl,
            'OPERTRANS' => $created_by,
            'OTVERSION' => 'AIS',
            'KETERANGAN' => $psnya
        );

        $this->history_m->save($data_history);

        redirect($this->back_to_approve_spv . $period . '/' . $dept . '/' . $section . '/' . 5);
    }

    function approve_all_overtime_by_spv()
    {
        $nospkl_array = $this->input->post("nospkl");
        $created_by = $this->session->userdata('USERNAME');
        $date = date('Ymd');
        $time = date('Hi');
        $psnya = "Approve Dokumen Planning by SPV";
        $ip = gethostbyaddr($_SERVER['REMOTE_ADDR']);

        $dept = $this->input->post("CHR_DEPT_2");
        $section = $this->input->post("CHR_SECTION_2");
        $period = $this->input->post("CHR_PERIOD_2");

        foreach ($nospkl_array as $nospkl) {
            $data = array(
                'OPER_EDIT' => $created_by,
                'TGL_EDIT' => $date,
                'JAM_EDIT' => $time,
                'CEK_SPV' => 1,
                'APP_PLAN' => $date . $time
            );

            $this->overtime_m->update_overtime_by_id($data, $nospkl);

            $data_history = array(
                'TGLTRANS' => $date,
                'JAMTRANS' => $time,
                'OTCPU' => $ip,
                'TIPETRANS' => 'APPROVE',
                'NO_SEQUENCE' => $nospkl,
                'OPERTRANS' => $created_by,
                'OTVERSION' => 'AIS',
                'KETERANGAN' => $psnya
            );

            $this->history_m->save($data_history);
        }

        redirect($this->back_to_approve_spv . $period . '/' . $dept . '/' . $section . '/' . 4);
    }



    //MANAGER
    function prepare_approve_ot_by_mgr($period = NULL, $dept = NULL, $section = null, $msg = NULL)
    {
        if ($msg == 4) {
            $msg = "<div class = 'alert alert-success'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Approve success </strong> The data is successfully Approve </div >";
        } elseif ($msg == 5) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Reject success </strong> The data is successfully Reject </div >";
        } elseif ($msg == 12) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Executing error !</strong> Something error with parameter </div >";
        }

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(32);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Approval OT';
        $data['msg'] = $msg;

        $user_session = $this->session->all_userdata();
        $role = $user_session['ROLE'];
        $id_dept = $user_session['DEPT'];
        $id_group = $user_session['GROUPDEPT'];
        $id_division = $user_session['DIVISION'];

        if ($period == NULL) {
            $period = date('Ym');
        }

        if ($role == 1) {
            if ($dept == NULL) {
                $dept = $this->dept_m->get_top_data_dept_by_division($id_division)->row()->CHR_DEPT;
            } else {
                $dept = $dept;
            }
            $data['all_dept'] = $this->dept_m->get_dept_by_division_id($id_division);
        } else {
            if ($dept == NULL) {
                $dept = $this->dept_m->get_data_dept($id_dept)->row()->CHR_DEPT;
            } else {
                $dept = $dept;
            }
            $data['all_dept'] = $this->dept_m->get_data_dept($id_dept)->result();
        }

        $data['all_section'] = $this->overtime_m->get_all_section_drop($dept);

        if ($section == NULL) {
            $section = 'ALL';
        } else {
            $x = 0;
            foreach ($data['all_section'] as $value) {
                if (trim($value->KODE) == trim($section)) {
                    $x = 1;
                }
            }

            if ($x == 0) {
                $section = 'ALL';
            }
        }

        $data['dept'] = trim($dept);
        $data['section'] = $section;
        $data['period'] = $period;

        $data['data'] = $this->overtime_m->get_data_overtime_by_mgr(trim($dept), $period, $section);
        $data['content'] = 'aorta/overtime/manage_overtime_by_mgr_v';
        $this->load->view($this->layout, $data);
    }

    function approve_form_overtime_by_mgr()
    {
        $nospkl = $this->input->post("NO_SEQUENCE");
        $section = $this->input->post("CHR_SECTION");
        $dept = $this->input->post("CHR_DEPT");
        $period = $this->input->post("CHR_PERIOD");
        $created_by = $this->session->userdata('USERNAME');
        $date = date('Ymd');
        $time = date('His');
        $ip = gethostbyaddr($_SERVER['REMOTE_ADDR']);
        $type_action = $this->input->post("submit");

        if ($type_action == 1) {
            $ket = 'APPROVE';
            $psnya = "Approve Dokumen Planning by Kadept";
            $msg_no = 4;
        } else {
            $ket = 'UN-APPROVE';
            $psnya = "Un-Approve Dokumen Planning by Kadept";
            $msg_no = 5;
        }

        $data = array(
            'CEK_KADEP' => $type_action,
            'OPER_EDIT' => $created_by,
            'TGL_EDIT' => $date,
            'JAM_EDIT' => $time
        );

        $this->overtime_m->update_overtime_by_id($data, $nospkl);

        $data_history = array(
            'TGLTRANS' => $date,
            'JAMTRANS' => $time,
            'OTCPU' => $ip,
            'TIPETRANS' =>  $ket,
            'NO_SEQUENCE' => $nospkl,
            'OPERTRANS' => $created_by,
            'OTVERSION' => 'AIS',
            'KETERANGAN' => $psnya
        );

        $this->history_m->save($data_history);

        redirect($this->back_to_approve_mgr . $period . '/' . $dept . '/' . $section . '/' . $msg_no);
    }

    // function unapprove_form_overtime_by_mgr() {
    //     $nospkl = $this->input->post("NO_SEQUENCE");
    //     $section = $this->input->post("CHR_SECTION");
    //     $dept = $this->input->post("CHR_DEPT");
    //     $period = $this->input->post("CHR_PERIOD");
    //     $created_by = $this->session->userdata('USERNAME');
    //     $date = date('Ymd');
    //     $time = date('His');
    //     $psnya = "Unapprove Dokumen Planning by Kadept";
    //     $ip = gethostbyaddr($_SERVER['REMOTE_ADDR']);

    //     $data = array(
    //         'CEK_KADEP' => 0,
    //         'OPER_EDIT' => $created_by,
    //         'TGL_EDIT' => $date,
    //         'JAM_EDIT' => $time
    //     );

    //     $this->overtime_m->update_overtime_by_id($data, $nospkl);

    //     $data_history = array(
    //         'TGLTRANS' => $date,
    //         'JAMTRANS' => $time,
    //         'OTCPU' => $ip,
    //         'TIPETRANS' => 'UN-APPROVE',
    //         'NO_SEQUENCE' => $nospkl,
    //         'OPERTRANS' => $created_by,
    //         'OTVERSION' => 'AIS',
    //         'KETERANGAN' => $psnya
    //     );

    //     $this->history_m->save($data_history);

    //     redirect($this->back_to_approve_mgr . $period . '/' . $dept . '/' . $section . '/' . 5);
    // }

    function approve_overtime_by_mgr($nospkl, $period, $dept, $section = null)
    {
        $created_by = $this->session->userdata('USERNAME');
        $date = date('Ymd');
        $time = date('His');
        $psnya = "Approve Dokumen Planning by Kadept";
        $ip = gethostbyaddr($_SERVER['REMOTE_ADDR']);

        $data = array(
            'CEK_KADEP' => 1,
            'OPER_EDIT' => $created_by,
            'TGL_EDIT' => $date,
            'JAM_EDIT' => $time
        );

        $this->overtime_m->update_overtime_by_id($data, $nospkl);

        $data_history = array(
            'TGLTRANS' => $date,
            'JAMTRANS' => $time,
            'OTCPU' => $ip,
            'TIPETRANS' => 'APPROVE',
            'NO_SEQUENCE' => $nospkl,
            'OPERTRANS' => $created_by,
            'OTVERSION' => 'AIS',
            'KETERANGAN' => $psnya
        );

        $this->history_m->save($data_history);

        redirect($this->back_to_approve_mgr . $period . '/' . $dept . '/' . $section . '/' . 4);
    }

    function unapprove_overtime_by_mgr($nospkl, $period, $dept, $section = null)
    {
        $created_by = $this->session->userdata('USERNAME');
        $date = date('Ymd');
        $time = date('His');
        $psnya = "Unapprove Dokumen Planning by Kadept";
        $ip = gethostbyaddr($_SERVER['REMOTE_ADDR']);

        $data = array(
            'CEK_KADEP' => 0,
            'OPER_EDIT' => $created_by,
            'TGL_EDIT' => $date,
            'JAM_EDIT' => $time
        );

        $this->overtime_m->update_overtime_by_id($data, $nospkl);

        $data_history = array(
            'TGLTRANS' => $date,
            'JAMTRANS' => $time,
            'OTCPU' => $ip,
            'TIPETRANS' => 'UN-APPROVE',
            'NO_SEQUENCE' => $nospkl,
            'OPERTRANS' => $created_by,
            'OTVERSION' => 'AIS',
            'KETERANGAN' => $psnya
        );

        $this->history_m->save($data_history);

        redirect($this->back_to_approve_mgr . $period . '/' . $dept . '/' . $section . '/' . 5);
    }

    function approve_all_overtime_by_mgr()
    {
        $nospkl_array = $this->input->post("nospkl");
        $created_by = $this->session->userdata('USERNAME');
        $date = date('Ymd');
        $time = date('Hi');
        $psnya = "Approve Dokumen Planning by MGR";
        $ip = gethostbyaddr($_SERVER['REMOTE_ADDR']);

        $dept = $this->input->post("CHR_DEPT_2");
        $section = $this->input->post("CHR_SECTION_2");
        $period = $this->input->post("CHR_PERIOD_2");

        foreach ($nospkl_array as $nospkl) {
            $data = array(
                'OPER_EDIT' => $created_by,
                'TGL_EDIT' => $date,
                'JAM_EDIT' => $time,
                'CEK_KADEP' => 1,
                'APP_PLAN' => $date . $time
            );

            $this->overtime_m->update_overtime_by_id($data, $nospkl);

            $data_history = array(
                'TGLTRANS' => $date,
                'JAMTRANS' => $time,
                'OTCPU' => $ip,
                'TIPETRANS' => 'APPROVE',
                'NO_SEQUENCE' => $nospkl,
                'OPERTRANS' => $created_by,
                'OTVERSION' => 'AIS',
                'KETERANGAN' => $psnya
            );

            $this->history_m->save($data_history);
        }

        redirect($this->back_to_approve_mgr . $period . '/' . $dept . '/' . $section . '/' . 4);
    }

    //GM
    function prepare_approve_ot_by_gm($period = NULL, $dept = NULL, $section = null, $msg = NULL)
    {
        if ($msg == 4) {
            $msg = "<div class = 'alert alert-success'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Approve success </strong> The data is successfully Approve </div >";
        } elseif ($msg == 5) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Reject success </strong> The data is successfully Reject </div >";
        } elseif ($msg == 12) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Executing error !</strong> Something error with parameter </div >";
        }

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(73);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Approval OT';
        $data['msg'] = $msg;

        $user_session = $this->session->all_userdata();
        $role = $user_session['ROLE'];
        $id_dept = $user_session['DEPT'];
        $id_group = $user_session['GROUPDEPT'];
        $id_division = $user_session['DIVISION'];
        $data['group'] = $this->groupdept_m->get_data_groupdept($id_group)->row()->GROUP_DEPT;

        if ($period == NULL) {
            $period = date('Ym');
        }

        if ($role == 1) {
            if ($dept == NULL) {
                $dept = $this->dept_m->get_top_data_dept_by_division($id_division)->row()->CHR_DEPT;
            } else {
                $dept = trim($dept);
            }
            $data['all_dept'] = $this->dept_m->get_dept_by_division_id($id_division);
        } else {
            if ($dept == NULL) {
                $dept = $this->dept_m->get_top_data_dept_by_groupdept($id_group)->row()->CHR_DEPT;
            } else {
                $dept = trim($dept);
            }
            $data['all_dept'] = $this->dept_m->get_dept_by_groupdept($id_group);
        }

        $data['all_section'] = $this->overtime_m->get_all_section_drop($dept);

        if ($section == NULL) {
            $section = 'ALL';
        } else {
            $x = 0;
            foreach ($data['all_section'] as $value) {
                if (trim($value->KODE) == trim($section)) {
                    $x = 1;
                }
            }

            if ($x == 0) {
                $section = 'ALL';
            }
        }

        $data['dept'] = trim($dept);
        $data['section'] = trim($section);
        $data['period'] = $period;
        $data['detail_quota_group'] = $this->overtime_m->get_detail_quota_group_by_periode($period, $data['group']);
        $data['quota_usage_dept'] = $this->overtime_m->get_detail_quota_group_per_dept_by_periode_gm($period, $data['group']);

        $data['data'] = $this->overtime_m->get_data_overtime_by_gm($data['dept'], $period, $data['section']);
        $data['content'] = 'aorta/overtime/manage_overtime_by_gm_v';
        $this->load->view($this->layout, $data);
    }

    function approve_form_overtime_by_gm()
    {
        $nospkl = $this->input->post("NO_SEQUENCE");
        $section = $this->input->post("CHR_SECTION");
        $dept = trim($this->input->post("CHR_DEPT"));
        $period = $this->input->post("CHR_PERIOD");
        $created_by = $this->session->userdata('USERNAME');
        $date = date('Ymd');
        $time = date('His');
        $ip = gethostbyaddr($_SERVER['REMOTE_ADDR']);
        $type_action = $this->input->post("submit");

        if ($type_action == 1) {
            $ket = 'APPROVE';
            $psnya = "Approve Dokumen Planning by GM";
            $msg_no = 4;
        } else {
            $ket = 'UN-APPROVE';
            $psnya = "Un-Approve Dokumen Planning by GM";
            $msg_no = 5;
        }

        $data = array(
            'CEK_GM' => $type_action,
            'APP_PLAN' => $date . $time
        );

        $this->overtime_m->update_overtime_by_id($data, $nospkl);

        $data_history = array(
            'TGLTRANS' => $date,
            'JAMTRANS' => $time,
            'OTCPU' => $ip,
            'TIPETRANS' => $ket,
            'NO_SEQUENCE' => $nospkl,
            'OPERTRANS' => $created_by,
            'OTVERSION' => 'AIS',
            'KETERANGAN' => $psnya
        );

        $this->history_m->save($data_history);

        redirect($this->back_to_approve_gm . $period . '/' . $dept . '/' . $section . '/' . $msg_no);
    }

    //     function unapprove_form_overtime_by_gm() {
    //         $nospkl = $this->input->post("NO_SEQUENCE");
    //         $section = $this->input->post("CHR_SECTION");
    //         $dept = $this->input->post("CHR_DEPT");
    //         $period = $this->input->post("CHR_PERIOD");
    //         $created_by = $this->session->userdata('USERNAME');
    //         $date = date('Ymd');
    //         $time = date('His');
    //         $psnya = "Unapprove Dokumen Planning by GM";
    //         $ip = gethostbyaddr($_SERVER['REMOTE_ADDR']);

    //         $data = array(
    //             'CEK_GM' => 0,
    //             'APP_PLAN' => $date . $time
    //         );

    //         $this->overtime_m->update_overtime_by_id($data, $nospkl);

    //         $data_history = array(
    //             'TGLTRANS' => $date,
    //             'JAMTRANS' => $time,
    //             'OTCPU' => $ip,
    //             'TIPETRANS' => 'UN-APPROVE',
    //             'NO_SEQUENCE' => $nospkl,
    //             'OPERTRANS' => $created_by,
    //             'OTVERSION' => 'AIS',
    //             'KETERANGAN' => $psnya
    //         );

    //         $this->history_m->save($data_history);

    //         redirect($this->back_to_approve_gm . $period . '/' . $dept . '/' . $section . '/' . 5);
    //     }

    function approve_overtime_by_gm($nospkl, $period, $dept, $section = null)
    {
        $created_by = $this->session->userdata('USERNAME');
        $date = date('Ymd');
        $time = date('Hi');
        $psnya = "Approve Dokumen Planning by GM";
        $ip = gethostbyaddr($_SERVER['REMOTE_ADDR']);

        $data = array(
            'CEK_GM' => 1,
            'APP_PLAN' => $date . $time
        );

        $this->overtime_m->update_overtime_by_id($data, $nospkl);

        $data_history = array(
            'TGLTRANS' => $date,
            'JAMTRANS' => $time,
            'OTCPU' => $ip,
            'TIPETRANS' => 'APPROVE',
            'NO_SEQUENCE' => $nospkl,
            'OPERTRANS' => $created_by,
            'OTVERSION' => 'AIS',
            'KETERANGAN' => $psnya
        );

        $this->history_m->save($data_history);

        redirect($this->back_to_approve_gm . $period . '/' . $dept . '/' . $section . '/' . 4);
    }

    function unapprove_overtime_by_gm($nospkl, $period, $dept, $section = null)
    {
        $created_by = $this->session->userdata('USERNAME');
        $date = date('Ymd');
        $time = date('His');
        $psnya = "Unapprove Dokumen Planning by GM";
        $ip = gethostbyaddr($_SERVER['REMOTE_ADDR']);

        $data = array(
            'CEK_GM' => 0,
            'APP_PLAN' => $date . $time
        );

        $this->overtime_m->update_overtime_by_id($data, $nospkl);

        $data_history = array(
            'TGLTRANS' => $date,
            'JAMTRANS' => $time,
            'OTCPU' => $ip,
            'TIPETRANS' => 'UN-APPROVE',
            'NO_SEQUENCE' => $nospkl,
            'OPERTRANS' => $created_by,
            'OTVERSION' => 'AIS',
            'KETERANGAN' => $psnya
        );

        $this->history_m->save($data_history);

        redirect($this->back_to_approve_gm . $period . '/' . $dept . '/' . $section . '/' . 5);
    }

    function approve_all_overtime_by_gm()
    {
        $nospkl_array = $this->input->post("nospkl");
        $created_by = $this->session->userdata('USERNAME');
        $date = date('Ymd');
        $time = date('Hi');
        $psnya = "Approve Dokumen Planning by GM";
        $ip = gethostbyaddr($_SERVER['REMOTE_ADDR']);

        $dept = $this->input->post("CHR_DEPT_2");
        $section = $this->input->post("CHR_SECTION_2");
        $period = $this->input->post("CHR_PERIOD_2");

        foreach ($nospkl_array as $nospkl) {
            $data = array(
                'OPER_EDIT' => $created_by,
                'TGL_EDIT' => $date,
                'JAM_EDIT' => $time,
                'CEK_GM' => 1,
                'APP_PLAN' => $date . $time
            );

            $this->overtime_m->update_overtime_by_id($data, $nospkl);

            $data_history = array(
                'TGLTRANS' => $date,
                'JAMTRANS' => $time,
                'OTCPU' => $ip,
                'TIPETRANS' => 'APPROVE',
                'NO_SEQUENCE' => $nospkl,
                'OPERTRANS' => $created_by,
                'OTVERSION' => 'AIS',
                'KETERANGAN' => $psnya
            );

            $this->history_m->save($data_history);
        }

        redirect($this->back_to_approve_gm . $period . '/' . $dept . '/' . $section . '/' . 4);
    }

    //MANAGER + GM
    function prepare_approve_ot_by_mgr_and_gm($period = NULL, $dept = NULL, $section = NULL, $msg = NULL)
    {

        if ($msg == 4) {
            $msg = "<div class = 'alert alert-success'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Approve success </strong> The data is successfully Approve </div >";
        } elseif ($msg == 5) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Reject success </strong> The data is successfully Reject </div >";
        } elseif ($msg == 12) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Executing error !</strong> Something error with parameter </div >";
        }

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(86);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Approval OT';
        $data['msg'] = $msg;

        $user_session = $this->session->all_userdata();
        $role = $user_session['ROLE'];
        $id_dept = $user_session['DEPT'];
        $id_group = $user_session['GROUPDEPT'];
        $id_division = $user_session['DIVISION'];

        if ($period == NULL) {
            $period = date('Ym');
        }

        if ($role == 1) {
            if ($dept == NULL) {
                $dept = $this->dept_m->get_top_data_dept_by_division($id_division)->row()->CHR_DEPT;
            } else {
                $dept = $dept;
            }
            $data['all_dept'] = $this->dept_m->get_dept_by_division_id($id_division);
        } else {
            if ($dept == NULL) {
                $dept = $this->dept_m->get_top_data_dept_by_groupdept($id_group)->row()->CHR_DEPT;
            } else {
                $dept = $dept;
            }
            $data['all_dept'] = $this->dept_m->get_dept_by_groupdept($id_group);
        }

        $data['all_section'] = $this->overtime_m->get_section_overtime($dept);

        if ($section == NULL) {
            $section = 'ALL';
        } else {
            $x = 0;
            foreach ($data['all_section'] as $value) {
                if (trim($value->KODE) == trim($section)) {
                    $x = 1;
                }
            }

            if ($x == 0) {
                $section = 'ALL';
            }
        }

        $data['dept'] = $dept;
        $data['section'] = $section;
        $data['period'] = $period;
        $data['group'] = $this->groupdept_m->get_data_groupdept($id_group)->row()->GROUP_DEPT;
        $data['detail_quota_group'] = $this->overtime_m->get_detail_quota_group_by_periode($period, $data['group']);
        $data['quota_usage_dept'] = $this->overtime_m->get_detail_quota_group_per_dept_by_periode_gm($period, $data['group']);

        $data['data'] = $this->overtime_m->get_data_overtime_by_mgr($dept, $period, $section);
        $data['content'] = 'aorta/overtime/manage_overtime_by_mgr_and_gm_v';
        $this->load->view($this->layout, $data);
    }

    function approve_all_overtime_by_mgr_and_gm()
    {
        $nospkl_array = $this->input->post("nospkl");
        $created_by = $this->session->userdata('USERNAME');
        $date = date('Ymd');
        $time = date('Hi');
        $psnya = "Approve Dokumen Planning by Kadept + GM";
        $ip = gethostbyaddr($_SERVER['REMOTE_ADDR']);

        $dept = $this->input->post("CHR_DEPT_2");
        $section = $this->input->post("CHR_SECTION_2");
        $period = $this->input->post("CHR_PERIOD_2");

        foreach ($nospkl_array as $nospkl) {
            $data = array(
                'CEK_KADEP' => 1,
                'OPER_EDIT' => $created_by,
                'TGL_EDIT' => $date,
                'JAM_EDIT' => $time,
                'CEK_GM' => 1,
                'APP_PLAN' => $date . $time
            );

            $this->overtime_m->update_overtime_by_id($data, $nospkl);

            $data_history = array(
                'TGLTRANS' => $date,
                'JAMTRANS' => $time,
                'OTCPU' => $ip,
                'TIPETRANS' => 'APPROVE',
                'NO_SEQUENCE' => $nospkl,
                'OPERTRANS' => $created_by,
                'OTVERSION' => 'AIS',
                'KETERANGAN' => $psnya
            );

            $this->history_m->save($data_history);
        }

        redirect($this->back_to_approve_mgr_and_gm . $period . '/' . $dept . '/' . $section . '/' . 4);
    }

    function approve_form_overtime_by_mgr_and_gm()
    {
        $nospkl = $this->input->post("NO_SEQUENCE");
        $section = $this->input->post("CHR_SECTION");
        $dept = $this->input->post("CHR_DEPT");
        $period = $this->input->post("CHR_PERIOD");
        $created_by = $this->session->userdata('USERNAME');
        $date = date('Ymd');
        $time = date('His');
        $ip = gethostbyaddr($_SERVER['REMOTE_ADDR']);
        $type_action = $this->input->post("submit");

        if ($type_action == 1) {
            $ket = 'APPROVE';
            $psnya = "Approve Dokumen Planning by Kadept + GM";
            $msg_no = 4;
        } else {
            $ket = 'UN-APPROVE';
            $psnya = "Un-Approve Dokumen Planning by Kadept + GM";
            $msg_no = 5;
        }

        $data = array(
            'CEK_KADEP' => $type_action,
            'OPER_EDIT' => $created_by,
            'TGL_EDIT' => $date,
            'JAM_EDIT' => $time,
            'CEK_GM' => $type_action,
            'APP_PLAN' => $date . $time
        );

        $this->overtime_m->update_overtime_by_id($data, $nospkl);

        $data_history = array(
            'TGLTRANS' => $date,
            'JAMTRANS' => $time,
            'OTCPU' => $ip,
            'TIPETRANS' => $ket,
            'NO_SEQUENCE' => $nospkl,
            'OPERTRANS' => $created_by,
            'OTVERSION' => 'AIS',
            'KETERANGAN' => $psnya
        );

        $this->history_m->save($data_history);

        redirect($this->back_to_approve_mgr_and_gm . $period . '/' . $dept . '/' . $section . '/' . $msg_no);
    }

    // function unapprove_form_overtime_by_mgr_and_gm() {
    //     $nospkl = $this->input->post("NO_SEQUENCE");
    //     $section = $this->input->post("CHR_SECTION");
    //     $dept = $this->input->post("CHR_DEPT");
    //     $period = $this->input->post("CHR_PERIOD");
    //     $created_by = $this->session->userdata('USERNAME');
    //     $date = date('Ymd');
    //     $time = date('His');
    //     $psnya = "Unapprove Dokumen Planning by Kadept + GM";
    //     $ip = gethostbyaddr($_SERVER['REMOTE_ADDR']);

    //     $data = array(
    //         'CEK_KADEP' => 0,
    //         'OPER_EDIT' => '',
    //         'TGL_EDIT' => '',
    //         'JAM_EDIT' => '',
    //         'CEK_GM' => 0,
    //         'APP_PLAN' => ''
    //     );

    //     $this->overtime_m->update_overtime_by_id($data, $nospkl);

    //     $data_history = array(
    //         'TGLTRANS' => $date,
    //         'JAMTRANS' => $time,
    //         'OTCPU' => $ip,
    //         'TIPETRANS' => 'UN-APPROVE',
    //         'NO_SEQUENCE' => $nospkl,
    //         'OPERTRANS' => $created_by,
    //         'OTVERSION' => 'AIS',
    //         'KETERANGAN' => $psnya
    //     );

    //     $this->history_m->save($data_history);

    //     redirect($this->back_to_approve_mgr_and_gm . $period . '/' . $dept . '/' . $section . '/' . 5);
    // }

    function approve_overtime_by_mgr_and_gm($nospkl, $period, $dept, $section = null)
    {
        $created_by = $this->session->userdata('USERNAME');
        $date = date('Ymd');
        $time = date('Hi');
        $psnya = "Approve Dokumen Planning by Kadept + GM";
        $ip = gethostbyaddr($_SERVER['REMOTE_ADDR']);

        $data = array(
            'CEK_KADEP' => 1,
            'OPER_EDIT' => $created_by,
            'TGL_EDIT' => $date,
            'JAM_EDIT' => $time,
            'CEK_GM' => 1,
            'APP_PLAN' => $date . $time
        );

        $this->overtime_m->update_overtime_by_id($data, $nospkl);

        $data_history = array(
            'TGLTRANS' => $date,
            'JAMTRANS' => $time,
            'OTCPU' => $ip,
            'TIPETRANS' => 'APPROVE',
            'NO_SEQUENCE' => $nospkl,
            'OPERTRANS' => $created_by,
            'OTVERSION' => 'AIS',
            'KETERANGAN' => $psnya
        );

        $this->history_m->save($data_history);

        redirect($this->back_to_approve_mgr_and_gm . $period . '/' . $dept . '/' . $section . '/' . 4);
    }

    function unapprove_overtime_by_mgr_and_gm($nospkl, $period, $dept, $section = null)
    {
        $created_by = $this->session->userdata('USERNAME');
        $date = date('Ymd');
        $time = date('His');
        $psnya = "Unapprove Dokumen Planning by Kadept + GM";
        $ip = gethostbyaddr($_SERVER['REMOTE_ADDR']);

        $data = array(
            'CEK_KADEP' => 0,
            'OPER_EDIT' => '',
            'TGL_EDIT' => '',
            'JAM_EDIT' => '',
            'CEK_GM' => 0,
            'APP_PLAN' => ''
        );

        $this->overtime_m->update_overtime_by_id($data, $nospkl);

        $data_history = array(
            'TGLTRANS' => $date,
            'JAMTRANS' => $time,
            'OTCPU' => $ip,
            'TIPETRANS' => 'UN-APPROVE',
            'NO_SEQUENCE' => $nospkl,
            'OPERTRANS' => $created_by,
            'OTVERSION' => 'AIS',
            'KETERANGAN' => $psnya
        );

        $this->history_m->save($data_history);

        redirect($this->back_to_approve_mgr_and_gm . $period . '/' . $dept . '/' . $section . '/' . 5);
    }

    //View Detail
    function view_detail_ot_section($periode = NULL, $dept = NULL)
    {
        if ($periode == NULL) {
            $periode = date('Ymd');
        }
        $session = $this->session->all_userdata();

        $id_dept = $this->session->userdata('DEPT');
        $dept_name = '';
        if ($dept == NULL) {
            $dept_name = trim($this->overtime_m->get_dept_name($id_dept)->CHR_DEPT);
        } else {
            $dept_name = $dept;
        }

        // $data['detail_quota_section'] = $this->overtime_m->get_detail_quota_section_by_periode($periode, $dept_name);
        $data['detail_quota_section'] = $this->overtime_m->get_detail_quota_section_by_periode_mgr($periode, $dept_name);
        $data['budget_quota'] = $this->overtime_m->get_budget_quota_by_dept_and_period($periode, $dept_name);
        $data['periode'] = $periode;

        $data['title'] = 'Detail Overtime per Section';
        $contain = 'aorta/overtime/detail_ot_section_v';
        $data['content'] = $contain;
        $this->load->view("/template/head_blank", $data);
    }

    function view_detail_ot_section_by_gm($periode = NULL, $dept = NULL)
    {
        if ($periode == NULL) {
            $periode = date('Ymd');
        }
        $session = $this->session->all_userdata();

        $id_dept = $this->session->userdata('DEPT');
        $dept_name = '';
        if ($dept == NULL) {
            $dept_name = trim($this->overtime_m->get_dept_name($id_dept)->CHR_DEPT);
        } else {
            $dept_name = $dept;
        }

        $data['detail_quota_section'] = $this->overtime_m->get_detail_quota_section_by_periode_gm($periode, $dept_name);
        $data['budget_quota'] = $this->overtime_m->get_budget_quota_by_dept_and_period($periode, $dept_name);
        $data['periode'] = $periode;

        $data['title'] = 'Detail Overtime per Section';
        $contain = 'aorta/overtime/detail_ot_section_v';
        $data['content'] = $contain;
        $this->load->view("/template/head_blank", $data);
    }

    function view_detail_ot_group($periode = NULL, $group = NULL)
    {
        if ($periode == NULL) {
            $periode = date('Ymd');
        }
        $session = $this->session->all_userdata();

        $id_group = $this->session->userdata('GROUPDEPT');
        if ($group == NULL) {
            $group = '';
            if ($id_group == '6') { //PRD
                $group = 'PRD';
            } else if ($id_group == '7') { //ENG
                $group = 'ENG';
            }
        }

        $data['detail_quota_group'] = $this->overtime_m->get_detail_quota_group_by_periode($periode, $group);


        $data['title'] = 'Detail Overtime per Group';
        $contain = 'aorta/overtime/detail_ot_group_v';
        $data['content'] = $contain;
        $this->load->view("/template/head_blank", $data);
    }

    function view_detail_ot_plant($periode = NULL)
    {
        if ($periode == NULL) {
            $periode = date('Ymd');
        }
        $session = $this->session->all_userdata();

        $data['detail_quota_plant'] = $this->overtime_m->get_detail_quota_plant_by_periode($periode);

        $data['title'] = 'Detail Overtime per Plant';
        $contain = 'aorta/overtime/detail_ot_plant_v';
        $data['content'] = $contain;
        $this->load->view("/template/head_blank", $data);
    }

    function view_detail_ot_per_month($period = NULL, $dept = NULL)
    {
        //===== Change Fiscal to APR - MAR ===================================//
        if ($period == NULL) {
            $period = date('Ym');
            if (substr($period, 4, 2) > 3) {
                $year = date('Y');
                $year_end = $year + 1;
            } else {
                $year = date('Y') - 1;
                $year_end = date('Y');
            }
        } else {
            if (substr($period, 4, 2) > 3) {
                $year = substr($period, 0, 4);
                $year_end = $year + 1;
            } else {
                $year = substr($period, 0, 4) - 1;
                $year_end = substr($period, 0, 4);
            }
        }

        $session = $this->session->all_userdata();

        //======================= MANAGER ====================================//
        if ($session['ROLE'] === 5 || $session['ROLE'] === 1 || $session['ROLE'] === 39) {
            $id_dept = $this->session->userdata('DEPT');
            $dept_name = '';
            if ($dept == NULL) {
                $dept_name = trim($this->overtime_m->get_dept_name($id_dept)->CHR_DEPT);
            } else {
                $dept_name = $dept;
            }

            $data['detail_quota_std'] = $this->overtime_m->get_detail_quota_std($year, $year_end, $dept_name);
            // $data['detail_quota_plan'] = $this->overtime_m->get_detail_quota_plan($year, $year_end, $dept_name);
            $data['detail_quota_plan'] = $this->overtime_m->get_detail_quota_plan_mgr($year, $year_end, $dept_name);
            $data['detail_quota_used'] = $this->overtime_m->get_detail_quota_used($year, $year_end, $dept_name);
            $data['detail_quota_saldo'] = $this->overtime_m->get_detail_quota_saldo($year, $year_end, $dept_name);
            $data['detail_quota_budget'] = $this->overtime_m->get_detail_quota_budget_mgr($period, $dept_name);
        }

        $data['year'] = $year;
        $data['year_end'] = $year_end;

        $data['title'] = 'Detail Overtime per Month';
        $contain = 'aorta/overtime/detail_ot_per_month_v';
        $data['content'] = $contain;
        $this->load->view("/template/head_blank", $data);
    }

    function view_detail_ot_per_month_gm($period = NULL, $group = NULL)
    {
        //===== Change Fiscal to APR - MAR ===================================//
        if ($period == NULL) {
            $period = date('Ym');
            if (substr($period, 4, 2) > 3) {
                $year = date('Y');
                $year_end = $year + 1;
            } else {
                $year = date('Y') - 1;
                $year_end = date('Y');
            }
        } else {
            if (substr($period, 4, 2) > 3) {
                $year = substr($period, 0, 4);
                $year_end = $year + 1;
            } else {
                $year = substr($period, 0, 4) - 1;
                $year_end = substr($period, 0, 4);
            }
        }
        $session = $this->session->all_userdata();

        //================= GROUP MANAGER ====================================//    
        if ($session['ROLE'] === 4 || $session['ROLE'] === 1) {
            $id_group = $this->session->userdata('GROUPDEPT');
            if ($group == NULL) {
                $group = '';
                if ($id_group == '6') { //PRD
                    $group = 'PRD';
                } else if ($id_group == '7') { //ENG
                    $group = 'ENG';
                }
            }

            $data['detail_quota_std'] = $this->overtime_m->get_detail_quota_std_gm($year, $year_end, $group);
            // $data['detail_quota_plan'] = $this->overtime_m->get_detail_quota_plan_gm($year, $year_end, $group);
            $data['detail_quota_plan'] = $this->overtime_m->get_detail_quota_plan_gm_v2($year, $year_end, $group);
            $data['detail_quota_used'] = $this->overtime_m->get_detail_quota_used_gm($year, $year_end, $group);
            $data['detail_quota_saldo'] = $this->overtime_m->get_detail_quota_saldo_gm($year, $year_end, $group);
            $data['detail_quota_budget'] = $this->overtime_m->get_detail_quota_budget_gm($period, $group);
        }

        $data['year'] = $year;
        $data['year_end'] = $year_end;

        $data['title'] = 'Detail Overtime per Month';
        $contain = 'aorta/overtime/detail_ot_per_month_gm_v';
        $data['content'] = $contain;
        $this->load->view("/template/head_blank", $data);
    }

    function view_detail_ot_per_month_gm_ver2($period = NULL, $group = NULL)
    {
        //===== Change Fiscal to APR - MAR ===================================//
        if ($period == NULL) {
            $period = date('Ym');
            if (substr($period, 4, 2) > 3) {
                $year = date('Y');
                $year_end = $year + 1;
            } else {
                $year = date('Y') - 1;
                $year_end = date('Y');
            }
        } else {
            if (substr($period, 4, 2) > 3) {
                $year = substr($period, 0, 4);
                $year_end = $year + 1;
            } else {
                $year = substr($period, 0, 4) - 1;
                $year_end = substr($period, 0, 4);
            }
        }
        $session = $this->session->all_userdata();

        //================= GROUP MANAGER ====================================//    
        if ($session['ROLE'] === 4 || $session['ROLE'] === 1) {
            $id_group = $this->session->userdata('GROUPDEPT');
            if ($group == NULL) {
                $group = '';
                if ($id_group == '6') { //PRD
                    $group = 'PRD';
                } else if ($id_group == '7') { //ENG
                    $group = 'ENG';
                }
            }

            $data['all_dept'] = $this->overtime_m->get_dept_overtime_by_gm($group);
        }

        $data['year'] = $year;
        $data['year_end'] = $year_end;

        $data['title'] = 'Detail Overtime per Month';
        $contain = 'aorta/overtime/detail_ot_per_month_gm_ver2_v';
        $data['content'] = $contain;
        $this->load->view("/template/head_blank", $data);
    }

    function view_detail_ot_per_month_dir($period = NULL)
    {
        //===== Change Fiscal to APR - MAR ===================================//
        if ($period == NULL) {
            $period = date('Ym');
            if (substr($period, 4, 2) > 3) {
                $year = date('Y');
                $year_end = $year + 1;
            } else {
                $year = date('Y') - 1;
                $year_end = date('Y');
            }
        } else {
            if (substr($period, 4, 2) > 3) {
                $year = substr($period, 0, 4);
                $year_end = $year + 1;
            } else {
                $year = substr($period, 0, 4) - 1;
                $year_end = substr($period, 0, 4);
            }
        }
        $session = $this->session->all_userdata();

        //================= DIRECTOR ====================================//    
        if ($session['ROLE'] === 3 || $session['ROLE'] === 1 || $session['ROLE'] === 4) {
            $div = 'PLNT';
            $data['detail_quota_std'] = $this->overtime_m->get_detail_quota_std_dir($year, $year_end, $div);
            $data['detail_quota_plan'] = $this->overtime_m->get_detail_quota_plan_dir($year, $year_end, $div);
            $data['detail_quota_used'] = $this->overtime_m->get_detail_quota_used_dir($year, $year_end, $div);
            $data['detail_quota_saldo'] = $this->overtime_m->get_detail_quota_saldo_dir($year, $year_end, $div);
            $data['detail_quota_budget'] = $this->overtime_m->get_detail_quota_budget_dir($period, $div);
        }

        $data['year'] = $year;
        $data['year_end'] = $year_end;

        $data['title'] = 'Detail Overtime per Month';
        $contain = 'aorta/overtime/detail_ot_per_month_dir_v';
        $data['content'] = $contain;
        $this->load->view("/template/head_blank", $data);
    }


    function print_overtime_excel($no_spkl)
    {

        $overtime_head = $this->overtime_m->get_data_group_overtime_by_no_spkl($no_spkl);

        $this->load->library('excel');
        $objReader = PHPExcel_IOFactory::createReader('Excel5');
        $objPHPExcel = $objReader->load("assets/template/aorta/spkl.xls");

        $tgl_overtime = date_format(date_create($overtime_head->TGL_OVERTIME), "d-m-Y");

        $objPHPExcel->getActiveSheet()->setCellValue("K3", $no_spkl);
        $objPHPExcel->getActiveSheet()->setCellValue("J6", "*" . $no_spkl . "*");
        $objPHPExcel->getActiveSheet()->setCellValue("J8", ": $overtime_head->HARI_KJ");
        $objPHPExcel->getActiveSheet()->setCellValue("J12", ": $tgl_overtime");
        $objPHPExcel->getActiveSheet()->setCellValue("J13", ": $overtime_head->KETERANGAN");
        $objPHPExcel->getActiveSheet()->setCellValue("I15", ": $overtime_head->DEPT");
        $objPHPExcel->getActiveSheet()->setCellValue("J17", ": $overtime_head->NAMA_PIC");
        $objPHPExcel->getActiveSheet()->setCellValue("B46", "Kategori Overtime: $overtime_head->CHR_DESC_CAT");
        $objPHPExcel->getActiveSheet()->setCellValue("B47", "$overtime_head->ALASAN");
        $objPHPExcel->getActiveSheet()->setCellValue("K53", date('d-F-y'));
        $objPHPExcel->getActiveSheet()->setCellValue("K57", " $overtime_head->NAMA");
        $objPHPExcel->getActiveSheet()->setCellValue("A43", "Jumlah MP: $overtime_head->JUM_MP");
        $objPHPExcel->getActiveSheet()->setCellValue("J43", "Jumlah MP: $overtime_head->TERPAKAIPLAN");

        $overtime_detail = $this->overtime_m->get_data_overtime_by_no_spkl($no_spkl);

        $row = 23;
        $x = 1;
        foreach ($overtime_detail as $isi) {

            $objPHPExcel->getActiveSheet()->setCellValue("A$row", "$x");
            $objPHPExcel->getActiveSheet()->setCellValue("B$row", "$isi->NAMA");
            $objPHPExcel->getActiveSheet()->setCellValue("E$row", "$isi->NPK");
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", "$isi->RENCANA_MULAI");
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", "$isi->RENCANA_END");
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", "$isi->KD_SECTION");
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", "$isi->REALISASI_MULAI");
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", "$isi->REALISASI_END");
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", "$isi->TERPAKAIPLAN");

            $row++;
            $x++;
        }

        ob_end_clean();
        $filename = "$no_spkl.xls";
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . trim($filename) . '"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
    }

    // function check_backdate()
    // {
    //     $array_tgl = explode('/', $this->input->post("TGL_OVERTIME"));
    //     $dept = $this->input->post("DEPT");
    //     $tgl_ot = $array_tgl[2] . $array_tgl[1] . $array_tgl[0];
    //     $date = date('d/m/Y');

    //     $flg_backdate = $this->overtime_m->get_backdate_overtime($tgl_ot, $dept);

    //     $json_data = array('flg_backdate' => $flg_backdate, 'datenow' => $date);

    //     echo json_encode($json_data);
    // }
}
