<?php

class henkaten_method_c extends CI_Controller {

    private $layout = '/template/head';
    private $back_to_manage = 'henkaten/henkaten_method_c/index/';
    private $home = '/basis/home_c';

    public function __construct() {
        parent::__construct();
        $this->load->model('henkaten/henkaten_method_m');
    }

    //show all data
    function index($msg = NULL) {
        $this->role_module_m->authorization('173');
        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Creating success </strong> The data is successfully created </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Updating success </strong> The data is successfully updated </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Deleted success </strong> The data is successfully deleted </div >";
        } elseif ($msg == 12) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Executing error !</strong> Something error with parameter </div >";
        }

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(173);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Manage Henkaten Method';
        $data['msg'] = $msg;

        $data['data'] = $this->henkaten_method_m->get_henkaten_method();
        $data['content'] = 'henkaten/henkaten_method/manage_henkaten_method_v';
        $this->load->view($this->layout, $data);
    }

    //prepare to create
    function create() {
        $this->role_module_m->authorization('173');
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['news'] = $this->news_m->get_news();
        $data['sidebar'] = $this->role_module_m->side_bar(173);

        $data['all_part_no'] = $this->db->query("SELECT A.[CHR_PART_NO]
                                                        ,A.[CHR_PART_NAME]
                                                        ,B.[CHR_BACK_NO]
                                                  FROM [TM_PARTS] A
                                                  LEFT JOIN TM_KANBAN B ON A.CHR_PART_NO = B.CHR_PART_NO
                                                  WHERE (A.CHR_BACK_NO IS NOT NULL AND A.CHR_BACK_NO <> '' AND B.CHR_BACK_NO <> '')
                                                            AND A.CHR_FLAG_DELETE <> '1' 
                                                  GROUP BY A.CHR_PART_NO, A.[CHR_PART_NAME], A.[CHR_BACK_NO], B.[CHR_BACK_NO]
                                                  ORDER BY A.CHR_BACK_NO")->result();

        $data['all_work_center'] = $this->db->query("SELECT CHR_WORK_CENTER FROM TM_INLINE_SCAN")->result();

        $data['title'] = 'Henkaten Method';
        $data['content'] = 'henkaten/henkaten_method/create_henkaten_method_v';
        $this->load->view($this->layout, $data);
    }

    //saving data
    function save_henkaten_method() {
        $session = $this->session->all_userdata();
        $schedule_date = date("Ymd", strtotime($this->input->post('CHR_SCHEDULE_TIME')));
        $schedule = date("His", strtotime($this->input->post('CHR_SCHEDULE_TIME')));
        $actual_date = date("Ymd", strtotime($this->input->post('CHR_ACT_TIME')));
        $actual = date("His", strtotime($this->input->post('CHR_ACT_TIME')));

        $this->form_validation->set_rules('CHR_DETAIL', 'Detail', 'required|min_length[10]|max_length[50]');

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $part_no = trim($this->input->post('CHR_PART_NO'));
            $part_name = $this->db->query("SELECT DISTINCT RTRIM(CHR_PART_NAME) AS CHR_PART_NAME FROM TM_PARTS WHERE CHR_PART_NO = '$part_no'")->row();

            $data = array(
                'CHR_WORK_CENTER' => $this->input->post('CHR_WORK_CENTER'),
                'CHR_DETAIL' => $this->input->post('CHR_DETAIL'),
                'CHR_PART_NO' => $part_no,
                'CHR_PART_NAME' => $part_name->CHR_PART_NAME,
                'CHR_PROCESS_NO' => $this->input->post('CHR_PROCESS_NO'),
                'CHR_CORRECT_ACTION' => $this->input->post('CHR_CORRECT_ACTION'),
                'INT_FLG_QUALITY' => $this->input->post('INT_FLG_QUALITY'),
                'CHR_PIC_QUALITY' => $this->input->post('CHR_PIC_QUALITY'),
                'CHR_SCHEDULE_DATE' => $schedule_date,
                'CHR_SCHEDULE_TIME' => $schedule,
                'CHR_ACT_DATE' => $actual_date,
                'CHR_ACT_TIME' => $actual,
                'CHR_CREATED_BY' => $session['USERNAME']
            );
            $this->henkaten_method_m->save($data);

            redirect($this->back_to_manage . $msg = 1);
        }
    }

    //prepare to editing
    function edit_henkaten_method($id) {
        $this->role_module_m->authorization('173');
        $data['data'] = $this->henkaten_method_m->get_henkaten_method_by_id($id);

        $data['content'] = 'henkaten/henkaten_method/edit_henkaten_method_v';

        $data['all_pic'] = $this->db->query("SELECT U.INT_ID_SUB_SECTION, ISNULL(SS.CHR_SUB_SECTION,'-CHOOSE-') AS CHR_SUB_SECTION FROM TM_USER U
                                                LEFT JOIN TM_SUB_SECTION SS ON SS.INT_ID_SUB_SECTION = U.INT_ID_SUB_SECTION
                                                WHERE U.BIT_FLG_DEL = 0
                                                GROUP BY U.INT_ID_SUB_SECTION, SS.CHR_SUB_SECTION")->result();

        $data['app'] = $this->role_module_m->get_app();
        $data['news'] = $this->news_m->get_news();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(173);

        $data['title'] = 'Edit Problem Quality';
        $this->load->view($this->layout, $data);
    }

    //updating data
    function update_henkaten_method() {
        $session = $this->session->all_userdata();
        $startdate = date("Ymd", strtotime($this->input->post('CHR_START_DATE')));
        $starttime = date("His", strtotime($this->input->post('CHR_START_TIME')));
        $duedate = date("Ymd", strtotime('+4 hours', strtotime($startdate)));
        $duetime = date("His", strtotime('+4 hours', strtotime($starttime)));
        $id = $this->input->post('INT_ID');

        $this->form_validation->set_rules('CHR_QPROBLEM_TITLE', 'Title', 'required|min_length[10]|max_length[40]');
        $this->form_validation->set_rules('CHR_QPROBLEM_DESC', 'Desc', 'required|min_length[10]|max_length[100]');

        if ($this->form_validation->run() == FALSE) {
            $this->edit_henkaten_problem($id);
        } else {

            $data = array(
                'CHR_QPROBLEM_TITLE' => $this->input->post('CHR_QPROBLEM_TITLE'),
                'CHR_BACK_NO' => $this->input->post('CHR_BACK_NO'),
                'CHR_PART_NAME' => $this->input->post('CHR_PART_NAME'),
                'INT_ID_SUB_SECTION_PIC' => $this->input->post('INT_ID_SUB_SECTION'),
                'INT_ID_SUB_SECTION_REQUESTOR' => $session['SUBSECTION'],
                'CHR_START_DATE' => $startdate,
                'CHR_START_TIME' => $starttime,
                'CHR_DUE_DATE' => $duedate,
                'CHR_DUE_TIME' => $duetime,
                'CHR_QPROBLEM_DESC' => $this->input->post('CHR_QPROBLEM_DESC'),
                'CHR_CREATED_BY' => $session['USERNAME']
            );
            $this->henkaten_method_m->update($data);

            redirect($this->back_to_manage . $msg = 1);
        }
    }

    //deleting data
    function delete_henkaten_method($id) {
        $this->role_module_m->authorization('173');
        $this->henkaten_method_m->delete($id);
        redirect($this->back_to_manage . $msg = 3);
    }

    function get_part_name() {
        $back_no = $this->input->post('back_no');
        //$part_name = $this->db->query("SELECT DISTINCT RTRIM(CHR_PART_NAME) AS CHR_PART_NAME FROM TT_PRODUCTION_RESULT WHERE CHR_BACK_NO = '$back_no'")->row();
        $part_name = $this->db->query("SELECT RTRIM([CHR_PART_NAME]) AS CHR_PART_NAME
                                      FROM [TM_PARTS]
                                      WHERE CHR_PART_NO = '$back_no'")->row();

        echo json_encode($part_name->CHR_PART_NAME);
    }

    public function updateAjax() {
        $data = $this->henkaten_method_m->get_henkaten_method();

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
                $status = "<td style='padding:5px;'><img src=" . base_url('assets/quality_assets/img/matrik1.png') . " width='50' height='50'></td>";
            } else if ($isi->INT_STATUS == 1) {
                $status = "<td style='padding:5px;'><img src=" . base_url('assets/quality_assets/img/matrik2.png') . " width='50' height='50'></td>";
            } else if ($isi->INT_STATUS == 2) {
                $status = "<td style='padding:5px;'><img src=" . base_url('assets/quality_assets/img/matrik3.png') . " width='50' height='50'></td>";
            } else {
                $status = "<td style='padding:5px;'><img src=" . base_url('assets/quality_assets/img/matrik4.png') . " width='50' height='50'></td>";
            }

            if ($i % 2 == 0) {
                $data_table .= "<tr class='gradeX' style='background-color:#013D80;'>";
            } else {
                $data_table .= "<tr class='gradeX' style='background-color:#1D6BDD;'>";
            }
            $data_table .= "<td>$i</td>";
            $data_table .= "<td>$isi->CHR_WORK_CENTER</td>";
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
