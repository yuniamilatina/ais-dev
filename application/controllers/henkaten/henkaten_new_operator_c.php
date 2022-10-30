<?php

class henkaten_new_operator_c extends CI_Controller {

    private $layout = '/template/head';
    private $back_to_manage = 'henkaten/henkaten_new_operator_c/index/';
    private $home = '/basis/home_c';

    public function __construct() {
        parent::__construct();
        $this->load->model('henkaten/henkaten_new_operator_m');
    }

    //show all data
    function index($msg = NULL) {
        $this->role_module_m->authorization('176');
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
        $data['sidebar'] = $this->role_module_m->side_bar(176);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Manage Henkaten Man';
        $data['msg'] = $msg;

        $data['data'] = $this->henkaten_new_operator_m->get_henkaten_new_operator();
        $data['content'] = 'henkaten/henkaten_new_operator/manage_henkaten_new_operator_v';
        $this->load->view($this->layout, $data);
    }

    //prepare to create
    function create() {
        $this->role_module_m->authorization('176');
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['news'] = $this->news_m->get_news();
        $data['sidebar'] = $this->role_module_m->side_bar(176);

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
        
        $aortadb = $this->load->database("aorta", TRUE);
        $data['all_user'] = $aortadb->query("SELECT * FROM TM_KRY")->result();
        
        $data['title'] = 'Henkaten Man';
        $data['content'] = 'henkaten/henkaten_new_operator/create_henkaten_new_operator_v';
        $this->load->view($this->layout, $data);
    }

    //saving data
    function save_henkaten_new_operator() {
        $session = $this->session->all_userdata();
        $schedule = date("Ymd", strtotime($this->input->post('CHR_START_DATE')));
        $actual = date("Ymd", strtotime($this->input->post('CHR_FINISH_DATE')));
        
        $npk_nama = trim($this->input->post('CHR_NPK'));
        $char = explode('-', $npk_nama);

        $this->form_validation->set_rules('CHR_PROCESS_NAME', 'Process Name', 'required|min_length[5]|max_length[30]');

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $back_no = trim($this->input->post('CHR_PART_NO'));
            $part_name = $this->db->query("SELECT DISTINCT RTRIM(CHR_PART_NAME) AS CHR_PART_NAME FROM TT_PRODUCTION_RESULT WHERE CHR_BACK_NO = '$back_no'")->row();

            $data = array(
                'CHR_WORK_CENTER' => $this->input->post('CHR_WORK_CENTER'),
                'CHR_NPK' => $char[0],
                'CHR_USERNAME' => $char[1],
                'INT_STATUS_ABSEN' => $this->input->post('INT_STATUS_ABSEN'),
                'CHR_PROCESS_NAME' => $this->input->post('CHR_PROCESS_NAME'),
                'CHR_START_DATE' => $schedule,
                'CHR_FINISH_DATE' => $actual,
                'CHR_CREATED_BY' => $session['USERNAME']
            );
            $this->henkaten_new_operator_m->save($data);

            redirect($this->back_to_manage . $msg = 1);
        }
    }
    
    //prepare to editing
    function edit_henkaten_new_operator($id) {
        $this->role_module_m->authorization('176');
        $data['data'] = $this->henkaten_new_operator_m->get_henkaten_new_operator_by_id($id);

        $data['content'] = 'henkaten/henkaten_new_operator/edit_henkaten_new_operator_v';

        $data['all_pic'] = $this->db->query("SELECT U.INT_ID_SUB_SECTION, ISNULL(SS.CHR_SUB_SECTION,'-CHOOSE-') AS CHR_SUB_SECTION FROM TM_USER U
                                                LEFT JOIN TM_SUB_SECTION SS ON SS.INT_ID_SUB_SECTION = U.INT_ID_SUB_SECTION
                                                WHERE U.BIT_FLG_DEL = 0
                                                GROUP BY U.INT_ID_SUB_SECTION, SS.CHR_SUB_SECTION")->result();

        $data['app'] = $this->role_module_m->get_app();
        $data['news'] = $this->news_m->get_news();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(176);

        $data['title'] = 'Edit Problem Quality';
        $this->load->view($this->layout, $data);
    }

    //updating data
    function update_henkaten_new_operator() {
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
            $this->henkaten_new_operator_m->update($data);

            redirect($this->back_to_manage . $msg = 1);
        }
    }

    //deleting data
    function delete_henkaten_new_operator($id) {
        $this->role_module_m->authorization('176');
        $this->henkaten_new_operator_m->delete($id);
        redirect($this->back_to_manage . $msg = 3);
    }

    function get_part_name() {
        $back_no = $id = $this->input->post('back_no');
        //$part_name = $this->db->query("SELECT DISTINCT RTRIM(CHR_PART_NAME) AS CHR_PART_NAME FROM TT_PRODUCTION_RESULT WHERE CHR_BACK_NO = '$back_no'")->row();
        $part_name = $this->db->query("SELECT RTRIM([CHR_PART_NAME]) AS CHR_PART_NAME
                                      FROM [TM_PARTS]
                                      WHERE CHR_PART_NO = '$back_no'")->row();

        echo json_encode($part_name->CHR_PART_NAME);
    }

}
