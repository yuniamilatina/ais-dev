<?php

class komparasi_kbn_fg_c extends CI_Controller
{

    private $layout = '/template/head';
    private $back_to_manage = 'raw_material/komparasi_kbn_fg_c/index/';
    private $back_to_list = 'raw_material/komparasi_kbn_fg_c/view_list_plan/';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('organization/dept_m');
        $this->load->model('raw_material/raw_material_m');
        $this->load->model('basis/log_m');
        $this->load->model('basis/role_module_m');
        $this->load->model('patricia/master_spec_part_m');
        $this->load->model('prd/direct_backflush_general_m');
    }

    function index($msg = NULL)
    {
        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Creating success </strong> The data is successfully created </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Updating success </strong> The data is successfully updated </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Deleted success </strong> The data is successfully deleted </div >";
        } elseif ($msg == 4) {
            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Data Berhasil Dihapus</strong></div >";
        } elseif ($msg == 5) {
            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Data Aktif Kembali</strong></div >";
        } elseif ($msg == 6) {
            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Data Sudah ada di Database</strong></div >";
        } elseif ($msg == 12) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Executing error !</strong> Something error with parameter </div >";
        }
        $data['msg'] = $msg;
        $this->role_module_m->authorization('143');
        $this->log_m->add_log(14, NULL);
        $this->session->userdata('user_id');

        $finishdate = date("Ymd");
        $startdate = date('Ymd', strtotime($finishdate . ' -1 day'));

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(257);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Master Data Inspection Plan';
        $data['npk'] = $this->session->userdata('NPK');

        $row = $this->dept_m->get_top_prod_dept()->row();
        $responsible = '01' . substr($row->CHR_DEPT, 2, 1);
        $work_center = $this->raw_material_m->get_top_work_center_by_dept($responsible);
        $data['id_prod'] = $row->INT_ID_DEPT;

        if ($this->input->post("filter") == 1) {
            $work_center = $this->input->post("CHR_WC");
            $data['data_qcwis'] = $this->raw_material_m->select_data_by_wc($work_center);
        } else {
            $data['data_qcwis'] = $this->raw_material_m->select_data_all();
        }

        $data['wc'] = $work_center;
        $work_center = $this->raw_material_m->get_top_work_center_by_dept($responsible);
        $all_dept_prod = $this->dept_m->get_all_prod_dept();
        $all_work_centers = $this->raw_material_m->get_all_work_center_by_dept($responsible);
        $data['all_dept_prod'] = $all_dept_prod;
        $data['all_work_centers'] = $all_work_centers;
        $data['work_center'] = trim($work_center['CHR_WORK_CENTER']);
        $data['role'] = $this->session->userdata('ROLE');
        // $data['setup_in'] = $this->raw_material_m->setup_in_fg($startdate,$finishdate);
        // $data['setup_out'] = $this->raw_material_m->setup_out_fg($startdate,$finishdate);
        $data['content'] = 'raw_material/report_komparasi_scan_fg_v';
        $this->load->view($this->layout, $data);
    }

    function create_data()
    {
        $data['content'] = 'raw_material/create_data_plan_v';
        $data['title'] = 'Add Data Inspection Plan';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(257);
        $data['news'] = $this->news_m->get_news();
        $data['data_line'] = $this->master_spec_part_m->get_line_prd();
        $data['data_assy'] = $this->master_spec_part_m->get_part_assy();
        $data['all_part'] = $this->master_spec_part_m->get_all_part();

        $this->load->view($this->layout, $data);
    }

    function save_data()
    {
        $this->load->library('upload');
        $date_now = date("ymd");
        $dtnow = date("Ymd");
        $line = trim($this->input->post('CHR_LINE'));
        $partno = trim($this->input->post('CHR_PARTNO'));
        $model = trim($this->input->post('CHR_MODEL'));
        $model = strtoupper($model);
        $exec = trim($this->input->post('CHR_EXEC'));
        $inspec = trim($this->input->post('CHR_INSPEC'));
        $isdate = date("Ymd", strtotime($this->input->post('CHR_IS_DATE')));
        $rvdate = date("Ymd", strtotime($this->input->post('CHR_RV_DATE')));
        $session = $this->session->all_userdata();

        if ($inspec == 'Receiving Stage') {
            $line = 'QUAR';
        }

        $backno = $this->raw_material_m->get_backno($partno);
        $partnm = $this->raw_material_m->get_partnm($partno);

        $fileName = time() . str_replace(' ', '-', $_FILES['CHR_DRAWING_LOC']['name']);

        if (empty($fileName)) {
            redirect($this->back_to_manage . $msg = 4);
        }

        $config = array(
            'upload_path' => 'assets/img/drawing/',
            'allowed_types' => "gif|JPG|jpg|png|jpeg|JPEG",
            'max_size' => "2096000",
            'file_name' =>  $fileName
        );

        //upload image
        $this->upload->initialize($config);
        if ($a = $this->upload->do_upload('CHR_DRAWING_LOC'))
            $this->upload->display_errors();
        $media = $this->upload->data('CHR_DRAWING_LOC');

        $inputFileName = $config['upload_path'] . $fileName; //$media['file_name']; 
        $inputFileName = preg_replace('/\s+/', '_', $inputFileName);

        $cek_seq = $this->db->query("SELECT TOP 1 * FROM TM_SEQUENCE_01 WHERE CHR_COD_EXE = 'QCWIS' and CHR_DATE_CREATED = '$dtnow'");
        if ($cek_seq->num_rows() == 0) {
            $ist_seq = $this->db->query("insert into TM_SEQUENCE_01 (CHR_COD_EXE,CHR_DATE_CREATED,CHR_KEY1,INT_SERIAL_NUMBER) values ('QCWIS','$dtnow','J901','0')");
            $noseq = 0;
        } else {
            $seq_d = $cek_seq->result();
            $noseq = $seq_d[0]->INT_SERIAL_NUMBER;
            $noseq = $noseq + 1;
            $upt_seq = $this->db->query("update TM_SEQUENCE_01 set INT_SERIAL_NUMBER='$noseq' where CHR_COD_EXE = 'QCWIS' and CHR_DATE_CREATED = '$dtnow'");
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
        $doc_id = "QCWIS" . $date_now . $x . $noseq;

        $data_pl = $this->raw_material_m->check_data($partno, $line);
        if ($data_pl == 0) {
            $data = array(
                'CHR_DOC_ID' => $doc_id,
                'CHR_WORK_CTR' => $line,
                'CHR_PARTNO' => $partno,
                'CHR_BACKNO' => $backno,
                'CHR_PART_NM' => $partnm,
                'CHR_MODEL_NM' => $model,
                'CHR_EXEC_BY' => $exec,
                'CHR_INSPEC_TYPE' => $inspec,
                'CHR_DRAWING_LOC' => $inputFileName,
                'CHR_ISSUE_DATE' => $isdate,
                'CHR_REVISED_DATE' => $rvdate,
                'CHR_CREATE_BY' => $session['NPK'],
                'CHR_CREATED_TIME' => date("His"),
                'CHR_CREATE_DATE' => date("Ymd")
            );
            $this->raw_material_m->save_data($data);

            redirect($this->back_to_manage . $msg = 1);
        } else {
            redirect($this->back_to_manage . $msg = 6);
        }
    }

    function copy_list_plan($docid)
    {
        $data['content'] = 'raw_material/create_copy_plan_v';
        $data['title'] = 'Copy Data Inspection Plan';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(257);
        $data['news'] = $this->news_m->get_news();
        $data['all_part'] = $this->master_spec_part_m->get_all_part();
        $data['doc_id'] = $docid;

        $this->load->view($this->layout, $data);
    }

    function save_copy()
    {
        $session = $this->session->all_userdata();
        $id = $this->input->post('CHR_DOC_ID');
        $partno = trim($this->input->post('CHR_PARTNO'));
        $get_line = $this->raw_material_m->get_list_qcwis_by_part($partno);
        foreach ($get_line as $isi) {
            $data = array(
                'CHR_DOC_ID' => trim($id),
                'CHR_SEQ' => trim($isi->CHR_SEQ),
                'CHR_CHECK_POINT' => trim($isi->CHR_CHECK_POINT),
                'CHR_TYPE' => trim($isi->CHR_TYPE),
                'CHR_RECORDING' => trim($isi->CHR_RECORDING),
                'CHR_SPECIAL_CHAR' => trim($isi->CHR_SPECIAL_CHAR),
                'CHR_CONTROL' => trim($isi->CHR_CONTROL),
                'CHR_TARGET_SL' => trim($isi->CHR_TARGET_SL),
                'CHR_RANGE_SL' => trim($isi->CHR_RANGE_SL),
                'CHR_LSL' => trim($isi->CHR_LSL),
                'CHR_USL' => trim($isi->CHR_USL),
                'CHR_UOM_SL' => trim($isi->CHR_UOM_SL),
                'CHR_TARGET_CL' => trim($isi->CHR_TARGET_CL),
                'CHR_RANGE_CL' => trim($isi->CHR_RANGE_CL),
                'CHR_LCL' => trim($isi->CHR_LCL),
                'CHR_UCL' => trim($isi->CHR_UCL),
                'CHR_UOM_CL' => trim($isi->CHR_UOM_CL),
                'CHR_QLT_CL' => trim($isi->CHR_QLT_CL),
                'CHR_QLT_VAL' => trim($isi->CHR_QLT_VAL),
                'CHR_SAMPLING' => trim($isi->CHR_SAMPLING),
                'CHR_FREQ' => trim($isi->CHR_FREQ),
                'CHR_STRATEGY' => trim($isi->CHR_STRATEGY),
                'CHR_REPETITION' => trim($isi->CHR_REPETITION),
                'CHR_DEVICE_ID' => trim($isi->CHR_DEVICE_ID),
                'CHR_REMARK' => trim($isi->CHR_REMARK),
                'CHR_CREATE_BY' => $session['NPK'],
                'CHR_CREATED_TIME' => date("His"),
                'CHR_CREATE_DATE' => date("Ymd")
            );
            $this->raw_material_m->save_list($data, $id);
        }
        redirect($this->back_to_list . $id . '/' . $msg = 1);
    }

    function edit_plan($id)
    {
        $this->role_module_m->authorization('3');
        $data['data'] = $this->raw_material_m->get_data($id);
        $data['data_line'] = $this->master_spec_part_m->get_line_prd();
        $data['all_part'] = $this->master_spec_part_m->get_all_part();

        $data['content'] = 'raw_material/edit_data_plan_v';
        $data['title'] = 'Edit Inspection Plan';
        $data['news'] = $this->news_m->get_news();
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(257);

        $this->load->view($this->layout, $data);
    }

    public function update_plan()
    {
        $this->load->library('upload');
        $session = $this->session->all_userdata();
        $id = $this->input->post('CHR_DOC_ID');
        $partno = trim($this->input->post('CHR_PARTNO'));
        $inspec = trim($this->input->post('CHR_INSPEC'));
        if ($inspec == "Inprocess Stage") {
            $exec = "Production";
        }
        $draw = trim($this->input->post('CHR_DRAW'));
        $model = $this->input->post('CHR_MODEL_NM');
        $line = trim($this->input->post('CHR_LINE'));
        $rvdate = date("Ymd", strtotime($this->input->post('CHR_RV_DATE')));
        $model = strtoupper($model);
        $backno = $this->raw_material_m->get_backno($partno);
        $partnm = $this->raw_material_m->get_partnm($partno);

        $upload_date = date('Ymd');
        $upload_time = date('His');
        $img = trim($this->input->post('CHR_DRAWING_LOC'));

        $array_file = explode(".", $_FILES['CHR_DRAWING_LOC']['name']);

        if (count($array_file) > 2) {
            redirect($this->back_to_manage . $msg = 13);
        }

        $fileName = time() . str_replace(' ', '-', $_FILES['CHR_DRAWING_LOC']['name']);

        if (empty($fileName)) {
            redirect($this->back_to_manage . $msg = 12);
        }

        $config = array(
            'upload_path' => 'assets/img/drawing/',
            'allowed_types' => "gif|JPG|jpg|png|jpeg",
            'max_size' => "4096000",
            'file_name' =>  $fileName
        );

        //code for upload with ci
        $this->upload->initialize($config);
        if ($a = $this->upload->do_upload('CHR_DRAWING_LOC'))
            $this->upload->display_errors();
        $media = $this->upload->data('CHR_DRAWING_LOC');

        $inputFileName = $config['upload_path'] . $fileName;

        if (strlen($inputFileName) == 29) {
            $inputFileName = $draw;
        }

        $data = array(
            'CHR_MODEL_NM' => $model,
            'CHR_WORK_CTR' => $line,
            'CHR_PARTNO' => $partno,
            'CHR_BACKNO' => $backno,
            'CHR_PART_NM' => $partnm,
            'CHR_DRAWING_LOC' => $inputFileName,
            'CHR_REVISED_DATE' => $rvdate,
            'CHR_EXEC_BY' => $exec,
            'CHR_CHANGE_BY' => $session['NPK'],
            'CHR_CHANGE_TIME' => date("His"),
            'CHR_CHANGE_DATE' => date("Ymd")
        );
        $this->raw_material_m->edit_data($data, $id);

        redirect($this->back_to_manage . $msg = 2);
    }

    function del_plan_h($doc_id)
    {
        $this->raw_material_m->del_plan_h($doc_id);
        redirect($this->back_to_manage . $msg = 4);
    }

    function undel_plan_h($doc_id)
    {
        $this->raw_material_m->undel_plan_h($doc_id);
        redirect($this->back_to_manage . $msg = 5);
    }

    public function search_plan($id_dept = '', $work_center = '', $msg = NULL)
    {

        $data['msg'] = $msg;
        $finishdate = date("Ymd");
        $startdate = date('Ymd', strtotime($finishdate . ' -1 day'));
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(257);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Master Data Inspection Plan';
        $data['content'] = 'raw_material/report_komparasi_scan_fg_v';
        $all_dept_prod = $this->dept_m->get_all_prod_dept();
        $data['id_prod'] = $id_dept;
        $data['data_qcwis'] = $this->raw_material_m->select_data_by_wc($work_center);
        $data_work_center = $this->direct_backflush_general_m->get_work_center_by_id_dept($id_dept);
        $data['all_work_centers'] = $data_work_center;
        $data['all_dept_prod'] = $all_dept_prod;
        $data['work_center'] = $work_center;
        $data['role'] = $this->session->userdata('ROLE');
        $this->load->view($this->layout, $data);
    }

    function view_list_plan($id, $msg = NULL)
    {
        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Creating success </strong> The data is successfully created </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Updating success </strong> The data is successfully updated </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Deleted success </strong> The data is successfully deleted </div >";
        } elseif ($msg == 4) {
            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Data Berhasil Dihapus</strong></div >";
        } elseif ($msg == 5) {
            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Data Aktif Kembali</strong></div >";
        } elseif ($msg == 12) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Executing error !</strong> Something error with parameter </div >";
        }
        $data['msg'] = $msg;
        $data['content'] = 'raw_material/manage_list_plan_v';
        $data['title'] = 'Add List Inspection Plan';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(257);
        $data['news'] = $this->news_m->get_news();
        $data['data_qcwis'] = $this->raw_material_m->select_data_by_id($id);
        $data['doc_id'] = $id;
        $this->load->view($this->layout, $data);
    }

    function add_list_plan($id)
    {
        $data['content'] = 'raw_material/create_list_plan_v';
        $data['title'] = 'Add List Inspection Plan';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(257);
        $data['news'] = $this->news_m->get_news();
        $data['doc_id'] = $id;
        $data['data_uom'] = $this->raw_material_m->get_uom();
        $data['data_dev'] = $this->raw_material_m->get_device();

        $this->load->view($this->layout, $data);
    }

    function save_list_plan()
    {
        $date_now = date("ymd");
        $dtnow = date("Ymd");
        $doc_id = trim($this->input->post('CHR_DOC_ID'));
        $point = trim($this->input->post('CHR_POINT'));
        $point = strtoupper($point);
        $type = trim($this->input->post('CHR_TYPE'));
        $recd = trim($this->input->post('CHR_RECD'));
        $spcl = trim($this->input->post('CHR_SPCL'));
        $cont = trim($this->input->post('CHR_CONT'));
        $tsl = trim($this->input->post('CHR_TSL'));
        $tsl = str_replace(",", ".", $tsl);
        $rsl = trim($this->input->post('CHR_RSL'));
        $rsl = str_replace(",", ".", $rsl);
        $lsl = trim($this->input->post('CHR_LSL'));
        $lsl = str_replace(",", ".", $lsl);
        $usl = trim($this->input->post('CHR_USL'));
        $usl = str_replace(",", ".", $usl);
        $uomsl = trim($this->input->post('CHR_UOMSL'));
        $tcl = trim($this->input->post('CHR_TCL'));
        $tcl = str_replace(",", ".", $tcl);
        $rcl = trim($this->input->post('CHR_RCL'));
        $rcl = str_replace(",", ".", $rcl);
        $lcl = trim($this->input->post('CHR_LCL'));
        $lcl = str_replace(",", ".", $lcl);
        $ucl = trim($this->input->post('CHR_UCL'));
        $ucl = str_replace(",", ".", $ucl);
        $uomcl = trim($this->input->post('CHR_UOMCL'));
        $qltcl = trim($this->input->post('CHR_QLTCL'));
        $qltval = trim($this->input->post('CHR_QLTVAL'));
        $samp = trim($this->input->post('CHR_SAMP'));
        $freq = trim($this->input->post('CHR_FREQ'));
        $strat = trim($this->input->post('CHR_STRAT'));
        $rep = trim($this->input->post('CHR_REP'));
        $equip = trim($this->input->post('CHR_EQUIP'));
        $remark = trim($this->input->post('CHR_REMARK'));
        $remark = strtoupper($remark);
        $session = $this->session->all_userdata();


        // $cek_seq = $this->db->query("SELECT TOP 1 * FROM TM_SEQUENCE_01 WHERE CHR_COD_EXE = 'QCWIS' and CHR_DATE_CREATED = '$dtnow'");
        $cek_seq = $this->raw_material_m->cek_seq($doc_id);
        if ($cek_seq == 0) {
            // $ist_seq = $this->db->query("insert into TM_SEQUENCE_01 (CHR_COD_EXE,CHR_DATE_CREATED,CHR_KEY1,INT_SERIAL_NUMBER) values ('QCWIS','$dtnow','J901','0')");
            $noseq = 1;
        } else {
            $seq_d = $this->raw_material_m->cek_seq1($doc_id);
            $noseq = $seq_d;
            $noseq = $noseq + 1;
            // $upt_seq = $this->db->query("update TM_SEQUENCE_01 set INT_SERIAL_NUMBER='$noseq' where CHR_COD_EXE = 'QCWIS' and CHR_DATE_CREATED = '$dtnow'");
        }
        // echo $seq_d;
        // exit();

        $data_ls = $this->raw_material_m->check_list($doc_id, $noseq);
        if ($data_ls == 0) {
            $data = array(
                'CHR_DOC_ID' => $doc_id,
                'CHR_SEQ' => $noseq,
                'CHR_CHECK_POINT' => $point,
                'CHR_TYPE' => $type,
                'CHR_RECORDING' => $recd,
                'CHR_SPECIAL_CHAR' => $spcl,
                'CHR_CONTROL' => $cont,
                'CHR_TARGET_SL' => $tsl,
                'CHR_RANGE_SL' => $rsl,
                'CHR_LSL' => $lsl,
                'CHR_USL' => $usl,
                'CHR_UOM_SL' => $uomsl,
                'CHR_TARGET_CL' => $tcl,
                'CHR_RANGE_CL' => $rcl,
                'CHR_LCL' => $lcl,
                'CHR_UCL' => $ucl,
                'CHR_UOM_CL' => $uomcl,
                'CHR_QLT_CL' => $qltcl,
                'CHR_QLT_VAL' => $qltval,
                'CHR_SAMPLING' => $samp,
                'CHR_FREQ' => $freq,
                'CHR_STRATEGY' => $strat,
                'CHR_REPETITION' => $rep,
                'CHR_DEVICE_ID' => $equip,
                'CHR_REMARK' => $remark,
                'CHR_CREATE_BY' => $session['NPK'],
                'CHR_CREATED_TIME' => date("His"),
                'CHR_CREATE_DATE' => date("Ymd")
            );
            $this->raw_material_m->save_list($data, $doc_id);

            redirect($this->back_to_list . $doc_id . '/' . $msg = 1);
        } else {
            redirect($this->back_to_list . $doc_id . '/' . $msg = 4);
        }
    }

    function edit_list_plan($id, $seq)
    {
        $this->role_module_m->authorization('3');
        $data['data'] = $this->raw_material_m->get_list_data($id, $seq);

        $data['content'] = 'raw_material/edit_list_plan_v';
        $data['title'] = 'Edit List Inspection Plan';
        $data['news'] = $this->news_m->get_news();
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(257);
        $data['data_uom'] = $this->raw_material_m->get_uom();
        $data['data_dev'] = $this->raw_material_m->get_device();

        $this->load->view($this->layout, $data);
    }

    public function update_list_plan()
    {
        $session = $this->session->all_userdata();
        $id = $this->input->post('CHR_DOC_ID');
        $seq = trim($this->input->post('CHR_SEQ'));
        $tsl = trim($this->input->post('CHR_TSL'));
        $tsl = str_replace(",", ".", $tsl);
        $rsl = trim($this->input->post('CHR_RSL'));
        $rsl = str_replace(",", ".", $rsl);
        $lsl = trim($this->input->post('CHR_LSL'));
        $lsl = str_replace(",", ".", $lsl);
        $usl = trim($this->input->post('CHR_USL'));
        $usl = str_replace(",", ".", $usl);
        $tcl = trim($this->input->post('CHR_TCL'));
        $tcl = str_replace(",", ".", $tcl);
        $rcl = trim($this->input->post('CHR_RCL'));
        $rcl = str_replace(",", ".", $rcl);
        $lcl = trim($this->input->post('CHR_LCL'));
        $lcl = str_replace(",", ".", $lcl);
        $ucl = trim($this->input->post('CHR_UCL'));
        $ucl = str_replace(",", ".", $ucl);
        $rep = trim($this->input->post('CHR_REP'));
        $poin = trim($this->input->post('CHR_CHECK_POINT'));
        $type = trim($this->input->post('CHR_TYPE'));
        $recd = trim($this->input->post('CHR_RECD'));
        $spcl = trim($this->input->post('CHR_SPCL'));
        $cont = trim($this->input->post('CHR_CONT'));
        $uomsl = trim($this->input->post('CHR_UOMSL'));
        $uomcl = trim($this->input->post('CHR_UOMCL'));
        $qltcl = trim($this->input->post('CHR_QLTCL'));
        $qltval = trim($this->input->post('CHR_QLTVAL'));
        $samp = trim($this->input->post('CHR_SAMP'));
        $freq = trim($this->input->post('CHR_FREQ'));
        $strat = trim($this->input->post('CHR_STRAT'));
        $equip = trim($this->input->post('CHR_EQUIP'));

        $upload_date = date('Ymd');
        $upload_time = date('His');
        $id = trim($id);

        $data = array(
            'CHR_CHECK_POINT' => $poin,
            'CHR_TYPE' => $type,
            'CHR_RECORDING' => $recd,
            'CHR_SPECIAL_CHAR' => $spcl,
            'CHR_CONTROL' => $cont,
            'CHR_UOM_SL' => $uomsl,
            'CHR_UOM_CL' => $uomcl,
            'CHR_QLT_CL' => $qltcl,
            'CHR_QLT_VAL' => $qltval,
            'CHR_SAMPLING' => $samp,
            'CHR_FREQ' => $freq,
            'CHR_STRATEGY' => $strat,
            'CHR_TARGET_SL' => $tsl,
            'CHR_RANGE_SL' => $rsl,
            'CHR_LSL' => $lsl,
            'CHR_USL' => $usl,
            'CHR_TARGET_CL' => $tcl,
            'CHR_RANGE_CL' => $rcl,
            'CHR_LCL' => $lcl,
            'CHR_UCL' => $ucl,
            'CHR_REPETITION' => $rep,
            'CHR_DEVICE_ID' => $equip,
            'CHR_CHANGE_BY' => $session['NPK'],
            'CHR_CHANGE_TIME' => date("His"),
            'CHR_CHANGE_DATE' => date("Ymd")
        );
        $this->raw_material_m->edit_list_data($data, $id, $seq);

        redirect($this->back_to_list . $id . '/' . $msg = 2);
    }

    function delete_list_plan($doc_id, $seq)
    {
        $this->raw_material_m->delete_list_plan($doc_id, $seq);
        redirect($this->back_to_list . $doc_id . '/' . $msg = 3);
    }

    function undelete_list_plan($doc_id, $seq)
    {
        $this->raw_material_m->undelete_list_plan($doc_id, $seq);
        redirect($this->back_to_list . $doc_id . '/' . $msg = 5);
    }

    function save_activity_popup()
    {
        $this->role_module_m->authorization('143');

        $this->form_validation->set_rules('activity_name', 'ACTIVITY NAME', 'required|callback_check_id|trim');
        $session = $this->session->all_userdata();

        if ($this->form_validation->run() == FALSE) {
            redirect($this->back_to_manage . $msg = 12);
        } else {
            $data = array(
                'CHR_ACTIVITY_NAME' => strtoupper($this->input->post('activity_name')),
                'CHR_USR_ENTRY' => $session['NPK'],
                'CHR_DATE_ENTRY' => date('Ymd'),
                'CHR_TIME_ENTRY' => date('His')
            );
            $this->activity_m->add_trans($data);
            redirect("eci/schedule_c/activity_project/0/NULL");
        }
    }

    function update_activity()
    {
        $this->role_module_m->authorization('143');
        $id = $this->input->post('id_activity');
        $session = $this->session->all_userdata();
        $this->form_validation->set_rules('activity_name', 'ACTIVITY', 'required|trim');
        if ($this->form_validation->run() == FALSE) {
            redirect($this->back_to_manage . $msg = 12);
        } else {
            $data = array(
                'CHR_ACTIVITY_NAME' => strtoupper($this->input->post('activity_name')),
                'CHR_USR_UPDATE' => $session['NPK'],
                'CHR_DATE_UPDATE' => date('Ymd'),
                'CHR_TIME_UPDATE' => date('His')
            );
            $this->activity_m->update_trans($data, " INT_ID_ACTIVITY = " . $id . "");

            $data2 = array(
                'CHR_ACTIVITY_NAME' => strtoupper($this->input->post('activity_name'))
            );
            $this->eci_l_m->update_trans_l($data2, " INT_ID_ACTIVITY = " . $id . "");

            redirect($this->back_to_manage . $msg = 2);
        }
    }

    function delete_activity($id)
    {
        $this->role_module_m->authorization('143');
        $this->activity_m->delete_trans($id);
        redirect("eci/activity_c/index/3", "refresh");
    }

    function getUpdate()
    {
        $this->role_module_m->authorization('143');
        $id_activity = $this->input->post("id_activity");
        $get_data = $this->activity_m->find_trans("*", "INT_ID_ACTIVITY = " . $id_activity . "");
        $data = "";
        $data .= form_open('eci/activity_c/update_activity', 'class="form-horizontal"');
        $data .= '      
					<input name="id_activity" class="form-control" required type="hidden" value="' . $get_data[0]->INT_ID_ACTIVITY . '">
					<div class="form-group">
						<label class="col-sm-4 control-label">ACTIVITY NAME</label>
						<div class="col-sm-8">
							<input name="activity_name" id="activity_name" autofocus class="form-control" maxlength="50" required type="text" style="width: 290px;text-transform: uppercase;float:left;" value="' . trim($get_data[0]->CHR_ACTIVITY_NAME) . '">
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-8 col-sm-push-4">
							<div class="btn-group">
								<button type="submit" class="btn btn-primary" data-toggle="tooltip" data-placement="left" title="Update this data"><i class="fa fa-refresh"></i> Update</button>
				';
        $data .= anchor('eci/activity_c', 'Cancel', 'class="btn btn-default" data-placement="right" data-toggle="tooltip" title="Back to manage"');
        $data .= '          </div>
						</div>
					</div> 
				';
        $data .= form_close();
        echo $data;
    }

    function check_id($id)
    {
        $this->role_module_m->authorization('143');
        $return_value = $this->activity_m->check_id($id);
        if ($return_value) {
            $this->form_validation->set_message('check_id', "Sorry, Your data Id already exists, please choose another one");
            return FALSE;
        } else {
            return TRUE;
        }
    }
}
