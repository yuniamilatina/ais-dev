<?php

class quality_problem_c extends CI_Controller {

    private $layout = '/template/head';
    private $back_to_manage = 'quality/quality_feedback_c/index/';
    private $back_to_view = 'quality/quality_feedback_c/select_quality_problem_by_id/';
    private $home = '/basis/home_c';

    public function __construct() {
        parent::__construct();
        $this->load->model('quality/quality_problem_m');
        $this->load->model('quality/quality_feedback_m');
    }

    //show all data
    function index($periode = NULL, $msg = NULL) {
        $this->role_module_m->authorization('166');
        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Creating success </strong> The data is successfully created </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Updating success </strong> The data is successfully updated </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Deleted success </strong> The data is successfully deleted </div >";
        } elseif ($msg == 12) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Executing error !</strong> Something error with parameter </div >";
        }
        
        if($periode == NULL || $periode == ''){
            $periode = date("Ym");
        } else {
            $periode = $periode;
        }

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(166);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Manage Problem';
        $data['msg'] = $msg;
        $data['date_selected'] = $periode;

        $data['data'] = $this->quality_problem_m->get_quality_problem($periode);
        $data['content'] = 'quality/reporting_problem/manage_problem_quality_v';
        $this->load->view($this->layout, $data);
    }

    function report($date_selected = NULL, $back_no = NULL, $section = NULL, $status = NULL) {
        $this->role_module_m->authorization('168');
        
        if ($date_selected == NULL) {
            $date_selected = date("Ym");
        }
        
        if ($back_no == 'ALL' || $back_no == NULL || $back_no == ''){
            $back_no = '';
        }
        
        if ($section == 'ALL' || $section == NULL || $section == ''){
            $section = '';
        }
        
        if ($status == 'ALL' || $status == NULL || $status == ''){
            $status = '';
        }
                
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(167);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Report Quality Problem';
        $data['date_selected'] = $date_selected;
        $data['back_no'] = $back_no;
        $data['section'] = $section;
        $data['status'] = $status;
        
        $data['all_section'] = $this->quality_problem_m->get_problem_section($date_selected);
        $data['all_back_no'] = $this->quality_problem_m->get_backno_problem($date_selected);
        $data['data_problem'] = $this->quality_problem_m->get_report_quality($date_selected);
        $data['data_back_no'] = $this->quality_problem_m->get_report_quality_by_backno($date_selected, $back_no, $section, $status);
        $data['content'] = 'quality/reporting_problem/report_problem_quality_v';
        $this->load->view($this->layout, $data);
    }
    
    function report_by_product_per_day($date_selected = NULL, $back_no = NULL, $section = NULL, $status = NULL) {
        $this->role_module_m->authorization('168');
        
        if ($date_selected == NULL) {
            $date_selected = date("Ym");
        }
        
        if ($back_no == 'ALL' || $back_no == NULL || $back_no == ''){
            $back_no = '';
        }
        
        if ($section == 'ALL' || $section == NULL || $section == ''){
            $section = '';
        }
        
        if ($status == 'ALL' || $status == NULL || $status == ''){
            $status = '';
        }
        
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(167);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Report Quality Problem';
        $data['date_selected'] = $date_selected;
        $data['back_no'] = $back_no;
        $data['section'] = $section;
        $data['status'] = $status;        
        
        $data['data_per_day'] = $this->quality_problem_m->get_report_by_product_per_day($date_selected, $back_no, $section, $status);
                
        $data['content'] = 'quality/reporting_problem/report_problem_quality_by_product_per_day_v';
        $this->load->view("/template/head_blank", $data);
    }
    
    function report_by_section_per_day($date_selected = NULL, $back_no = NULL, $section = NULL, $status = NULL) {
        $this->role_module_m->authorization('168');
        
        if ($date_selected == NULL) {
            $date_selected = date("Ym");
        }
        
        if ($back_no == 'ALL' || $back_no == NULL || $back_no == ''){
            $back_no = '';
        }
        
        if ($section == 'ALL' || $section == NULL || $section == ''){
            $section = '';
        }
        
        if ($status == 'ALL' || $status == NULL || $status == ''){
            $status = '';
        }
        
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(167);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Report Quality Problem';
        $data['date_selected'] = $date_selected;
        $data['back_no'] = $back_no;
        $data['section'] = $section;
        $data['status'] = $status;
        
        $data['data_by_section'] = $this->quality_problem_m->get_report_by_section_per_day($date_selected, $back_no, $section, $status);
        $data['content'] = 'quality/reporting_problem/report_problem_quality_by_section_per_day_v';
        $this->load->view("/template/head_blank", $data);
    }
    
    function report_by_product($date_selected = NULL, $back_no = NULL, $section = NULL, $status = NULL) {
        $this->role_module_m->authorization('168');
        
        if ($date_selected == NULL) {
            $date_selected = date("Ym");
        }
        
        if ($back_no == 'ALL' || $back_no == NULL || $back_no == ''){
            $back_no = '';
        }
        
        if ($section == 'ALL' || $section == NULL || $section == ''){
            $section = '';
        }
        
        if ($status == 'ALL' || $status == NULL || $status == ''){
            $status = '';
        }
        
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(181);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Report Problem by Product';
        $data['date_selected'] = $date_selected;
        $data['back_no'] = $back_no;
        $data['section'] = $section;
        $data['status'] = $status;
        
        $data['data_by_product'] = $this->quality_problem_m->get_report_by_product($date_selected, $back_no, $section, $status);
        $data['pareto_product'] = $this->quality_problem_m->get_pareto_problem_by_product($date_selected, $back_no, $section, $status);
                
        $data['content'] = 'quality/reporting_problem/report_problem_quality_by_product_v';
        $this->load->view($this->layout, $data);
    }
    
    function report_by_section($date_selected = NULL, $back_no = NULL, $section = NULL, $status = NULL) {
        $this->role_module_m->authorization('168');
        
        if ($date_selected == NULL) {
            $date_selected = date("Ym");
        }
        
        if ($back_no == 'ALL' || $back_no == NULL || $back_no == ''){
            $back_no = '';
        }
        
        if ($section == 'ALL' || $section == NULL || $section == ''){
            $section = '';
        }
        
        if ($status == 'ALL' || $status == NULL || $status == ''){
            $status = '';
        }
        
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(182);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Report Problem by Product';
        $data['date_selected'] = $date_selected;
        $data['back_no'] = $back_no;
        $data['section'] = $section;
        $data['status'] = $status;
        
        $data['data_by_section'] = $this->quality_problem_m->get_report_by_section($date_selected, $back_no, $section, $status);
        $data['pareto_section'] = $this->quality_problem_m->get_pareto_problem_by_section($date_selected, $back_no, $section, $status);
                
        $data['content'] = 'quality/reporting_problem/report_problem_quality_by_section_v';
        $this->load->view($this->layout, $data);
    }
    
    function report_by_tr_status($date_selected = NULL, $section = NULL, $status = NULL) {
        $this->role_module_m->authorization('168');
        
        if ($date_selected == NULL) {
            $date_selected = date("Ym");
        }
        
        if ($section == 'ALL' || $section == NULL || $section == ''){
            $section = '';
        }
        
        if ($status == 'ALL' || $status == NULL || $status == ''){
            $status = '';
        }
        
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(185);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Report Problem by TR Status';
        $data['date_selected'] = $date_selected;
        $data['section'] = $section;
        $data['status'] = $status;
        
        $data['data_section'] = $this->quality_problem_m->get_problem_section($date_selected);
        $data['data_by_tr_status'] = $this->quality_problem_m->get_report_by_tr_status($date_selected, $section, $status);
        $data['tr_status'] = $this->quality_problem_m->get_tr_status($date_selected, $section, $status);
      
        $data['content'] = 'quality/reporting_problem/report_problem_quality_by_tr_status_v';
        $this->load->view($this->layout, $data);
    }    
    
    //view by id
    function select_quality_problem_by_id($id, $msg = null) {
        $this->role_module_m->authorization('168');

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
        $data['sidebar'] = $this->role_module_m->side_bar(166);
        $data['news'] = $this->news_m->get_news();
        $data['msg'] = $msg;

        $data['data_detail'] = $this->quality_problem_m->get_quality_problem_by_id($id);
        $data['data'] = $this->quality_feedback_m->get_data_by_id($id)->result();
        $data['content'] = 'quality/reporting_problem/view_problem_v';
        $data['title'] = 'View Reporting Problem';
        $this->load->view($this->layout, $data);
    }

    //prepare to create
    function create() {
        $this->role_module_m->authorization('166');
        $session = $this->session->all_userdata();
        $data['inspector_sect'] = $this->quality_problem_m->get_inspector_sect($session['SECTION']);
        
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['news'] = $this->news_m->get_news();
        $data['sidebar'] = $this->role_module_m->side_bar(166);
        
        $data['all_back_no'] = $this->quality_problem_m->get_all_back_no();       
        $data['all_section'] = $this->quality_problem_m->get_all_section();
        $data['all_list_problem'] = $this->quality_problem_m->get_all_list_problem();

//        $data['all_pic'] = $this->db->query("SELECT U.INT_ID_SUB_SECTION, ISNULL(SS.CHR_SUB_SECTION,'-CHOOSE-') AS CHR_SUB_SECTION FROM TM_USER U
//                                                LEFT JOIN TM_SUB_SECTION SS ON SS.INT_ID_SUB_SECTION = U.INT_ID_SUB_SECTION
//                                                WHERE U.BIT_FLG_DEL = 0
//                                                GROUP BY U.INT_ID_SUB_SECTION, SS.CHR_SUB_SECTION")->result();
        
        
        $data['title'] = 'Create Problem Report';
        $data['content'] = 'quality/reporting_problem/create_problem_quality_v';
        $this->load->view($this->layout, $data);
    }
    
    //prepare to create differential TR
    function create_inherit_tr($id) {
        $this->role_module_m->authorization('166');
        $session = $this->session->all_userdata();
        
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['news'] = $this->news_m->get_news();
        $data['sidebar'] = $this->role_module_m->side_bar(166);     
        
        $data['all_back_no'] = $this->quality_problem_m->get_all_back_no();       
        $data['all_section'] = $this->quality_problem_m->get_all_section();
        $data['all_list_problem'] = $this->quality_problem_m->get_all_list_problem();
        
        $data['data_detail'] = $this->quality_problem_m->get_quality_problem_by_id($id);        
        
        $data['title'] = 'Create Problem Report';
        $data['content'] = 'quality/reporting_problem/create_problem_quality_inherit_v';
        $this->load->view($this->layout, $data);
    }

    //saving data
    function save_quality_problem() {
        $this->load->library('upload');
        $session = $this->session->all_userdata();
        $startdate = date("Ymd", strtotime($this->input->post('CHR_START_DATE')));
        $starttime = date("His", strtotime($this->input->post('CHR_START_TIME')));
        $duedate = date("Ymd", strtotime('+4 hours', strtotime($startdate)));
        $duetime = date("His", strtotime('+4 hours', strtotime($starttime)));
        
        $get_latest_id_all_tr = $this->quality_problem_m->get_id_latest_problem()->INT_ID;
        $get_latest_id = $this->quality_problem_m->get_id_problem()->INT_ID;
        $new_latest_id = $get_latest_id + 1;
        $get_id_tr = substr(($this->quality_problem_m->get_id_problem()->CHR_TR_NO),0,3);
        $new_id_tr = ((int)$get_id_tr)+1;
        
        $inspector_sect = $this->quality_problem_m->get_inspector_sect($session['SECTION'])->CHR_SECTION;
        
        $tr_no =  str_pad($new_id_tr, 3, '0', STR_PAD_LEFT).'/'.trim($inspector_sect).'/'.date("Ym");
        
        $fileName = trim($session['NPK']) . '_' . date("YmdHis");
        $input_type = $this->input->post('CHR_TYPE');

        $pic = $this->input->post('CHR_USERNAME');
        
        if (strlen($pic) == 8){
            $pic = substr($pic,2,4);
        } else if (strlen($pic) == 10){
            $pic = substr($pic,2,6);
        } 
        
//        $duedate = date("Ymd", strtotime($this->input->post('CHR_DUE_DATE')));
//        $duetime = date("His", strtotime($this->input->post('CHR_DUE_TIME')));

//        $this->form_validation->set_rules('CHR_QPROBLEM_TITLE', '"Problem Title"', 'required|min_length[10]|max_length[40]');
        $this->form_validation->set_rules('CHR_QPROBLEM_DESC', '"Detail of Problem"', 'required|min_length[10]|max_length[100]');
        
        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $config['upload_path'] = "assets/file/qis_feedback/";
            $config['file_name'] = $fileName;
            $config['allowed_types'] = 'JPEG|jpeg|JPG|jpg|PNG|png|gif';
            $config['max_size'] = 5000;
            
            $ext = end((explode(".", $_FILES['file']['name'])));
            
            $this->upload->initialize($config);
            if (!$this->upload->do_upload('file')) {
                $error = array('error' => $this->upload->display_errors());
                echo $error['error'];
                exit();
            } else {
                $success = array('upload_data' => $this->upload->data());

                if($input_type == '1'){
                    $back_no = trim($this->input->post('CHR_BACK_NO'));
                } else {
                    $back_no = trim($this->input->post('CHR_PART_NO'));
                }
                
                $part_name = $this->db->query("SELECT A.[CHR_PART_NAME]
                                               ,A.[CHR_PART_NO]
                                               ,B.[CHR_BACK_NO]
                                         FROM [TM_PARTS] A
                                         LEFT JOIN TM_KANBAN B ON A.CHR_PART_NO = B.CHR_PART_NO
                                         WHERE A.CHR_BACK_NO =  '$back_no'")->row();
                
                $get_work_center = $this->db->query("SELECT DISTINCT C.[CHR_WORK_CENTER]
                                         FROM [TM_PARTS] A
                                         LEFT JOIN TM_KANBAN B ON A.CHR_PART_NO = B.CHR_PART_NO
                                         LEFT JOIN TM_PROCESS_PARTS C ON A.CHR_PART_NO = C.CHR_PART_NO
                                         WHERE A.CHR_BACK_NO =  '$back_no'")->result();
                $work_center = '';                
                $row = count($get_work_center);
                if($row > 0){
                    $x = 1;
                    foreach($get_work_center as $wc){
                        if($x != $row){
                          $work_center .= trim($wc->CHR_WORK_CENTER) . ';';  
                        } else {
                          $work_center .= trim($wc->CHR_WORK_CENTER); 
                        }                        
                        $x++;
                    }
                }
                
                $pic_name = $this->db->query("SELECT [CHR_USERNAME]
                                         FROM [TM_USER]
                                         WHERE CHR_NPK =  '$pic' AND BIT_FLG_DEL = 'False' AND BIT_FLG_ACTIVE = 'True'")->row();
                
                $id_pic_sect = $this->input->post('INT_ID_SECTION_PIC');
                $id_team = $this->db->query("SELECT DISTINCT [INT_ID_TEAM]
                                         FROM [QUA].[TM_MAPPING_TEAM_PIC]
                                         WHERE INT_ID_SECTION = '$id_pic_sect' AND INT_FLG_DELETE <> 1")->row();
               
                $data = array(
                    'CHR_QPROBLEM_TITLE' => $this->input->post('CHR_QPROBLEM_TITLE'),
                    'CHR_PART_NAME' => $part_name->CHR_PART_NAME,                    
                    'CHR_BACK_NO' => $back_no,
                    'CHR_PART_NO' => $part_name->CHR_PART_NO,
                    'CHR_WORK_CENTER' => $work_center,
                    'CHR_PIC' => $pic_name->CHR_USERNAME,                    
                    'INT_ID_SECTION_PIC' => $this->input->post('INT_ID_SECTION_PIC'),
                    'CHR_REQUESTOR' => $this->input->post('CHR_INSPECTOR'),
                    'INT_ID_SECTION_REQUESTOR' => $session['SECTION'],
                    'CHR_START_DATE' => $startdate,
                    'CHR_START_TIME' => $starttime,
                    'CHR_DUE_DATE' => $duedate,
                    'CHR_DUE_TIME' => $duetime,
                    'INT_QTY' => $this->input->post('INT_QTY'),
                    'CHR_FILENAME' => 'assets/file/qis_feedback/' . $fileName . '.' . $ext,
                    'CHR_QPROBLEM_DESC' => $this->input->post('CHR_QPROBLEM_DESC'),
                    'CHR_CREATED_BY' => $session['NPK'], 
                    'CHR_TR_NO' => $tr_no,
                    'CHR_CLASS_PROBLEM' => $this->input->post('CHR_CLASS_PROBLEM'),
                    'INT_ID_PARENT' => $new_latest_id,
                    'INT_ID_CHILD' => 0,
                    'INT_FLG_REPEAT' => $this->input->post('INT_FLG_REPEAT'),
                    'CHR_UNIT_TYPE' => $this->input->post('CHR_UNIT'),
                    'INT_ID_TEAM' => $id_team->INT_ID_TEAM
                );
                $this->quality_problem_m->save($data);

                $seq_id = $this->notification_m->generate_id();

                $data_notif = array(
                    'INT_ID_NOTIF' => $seq_id,
                    'CHR_NPK' => $pic,
                    'INT_ID_APP' => '22',
                    'CHR_NOTIF_TITLE' => $this->input->post('CHR_QPROBLEM_TITLE'),
                    'CHR_NOTIF_DESC' => $this->input->post('CHR_QPROBLEM_DESC'),
                    'CHR_LINK' => "quality/quality_feedback_c/select_quality_problem_by_id/" . ($get_latest_id_all_tr + 1),
                    //'CHR_LINK' => "quality/quality_feedback_c/",
                    'CHR_CREATED_BY' => $session['USERNAME'],
                    'CHR_CREATED_DATE' => date('Ymd'),
                    'CHR_CREATED_TIME' => date('His')
                );

                $this->notification_m->insert_notification($data_notif);

                redirect($this->back_to_manage . date("Ym") . '/' . $msg = 1);
            }
        }
    }
    
    //saving data TR inheritance
    function save_quality_problem_inherit() {
        $this->load->library('upload');
        $session = $this->session->all_userdata();
        $id = $this->input->post('INT_ID');
        $startdate = date("Ymd", strtotime($this->input->post('CHR_START_DATE')));
        $starttime = date("His", strtotime($this->input->post('CHR_START_TIME')));
        
        $pic = $this->input->post('CHR_USERNAME');
       
        if (strlen($pic) == 8){
            $pic = substr($pic,2,4);
        } else if (strlen($pic) == 10){
            $pic = substr($pic,2,6);
        }
        
        $duedate = date("Ymd", strtotime('+4 hours', strtotime($startdate)));
        $duetime = date("His", strtotime('+4 hours', strtotime($starttime)));
        
        $req_sect = $this->quality_problem_m->get_inspector_sect($session['SECTION'])->CHR_SECTION;
        $get_latest_id = $this->quality_problem_m->get_id_inherit_tr($req_sect);
        
        if($get_latest_id == null){
            $get_latest_id = 0;
        } else {
            $get_latest_id = (int)$get_latest_id->LATEST_ID;
        }
        
        $new_latest_id = $get_latest_id + 1;        
        $new_tr_no =  str_pad($new_latest_id, 3, '0', STR_PAD_LEFT).'/'.trim($req_sect).'/'.date("Ym");              
        
//        $duedate = date("Ymd", strtotime($this->input->post('CHR_DUE_DATE')));
//        $duetime = date("His", strtotime($this->input->post('CHR_DUE_TIME')));

//        $this->form_validation->set_rules('CHR_QPROBLEM_TITLE', '"Problem Title"', 'required|min_length[10]|max_length[40]');
        $this->form_validation->set_rules('CHR_QPROBLEM_DESC', '"Detail of Problem"', 'required|min_length[10]|max_length[100]');
        
        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            
            $pic_name = $this->db->query("SELECT [CHR_USERNAME]
                                         FROM [TM_USER]
                                         WHERE CHR_NPK =  '$pic' AND BIT_FLG_DEL = 'False' AND BIT_FLG_ACTIVE = 'True'")->row();
            
            $id_pic_sect = $this->input->post('INT_ID_SECTION_PIC');
            $id_team = $this->db->query("SELECT DISTINCT [INT_ID_TEAM]
                                         FROM [QUA].[TM_MAPPING_TEAM_PIC]
                                         WHERE INT_ID_SECTION = '$id_pic_sect' AND INT_FLG_DELETE <> 1")->row();
             
            $data = array(
                'CHR_QPROBLEM_TITLE' => $this->input->post('CHR_QPROBLEM_TITLE'),
                'CHR_PART_NAME' => $this->input->post('CHR_PART_NAME'),                    
                'CHR_BACK_NO' => $this->input->post('CHR_BACK_NO'),
                'CHR_PART_NO' => $this->input->post('CHR_PART_NO'),
                'CHR_WORK_CENTER' => $this->input->post('CHR_WORK_CENTER'),
                'CHR_PIC' => $pic_name->CHR_USERNAME,                    
                'INT_ID_SECTION_PIC' => $this->input->post('INT_ID_SECTION_PIC'),
                'CHR_REQUESTOR' => $this->input->post('CHR_INSPECTOR'),
                'INT_ID_SECTION_REQUESTOR' => $this->input->post('INT_ID_SECTION_REQUESTOR'),
                'CHR_START_DATE' => $startdate,
                'CHR_START_TIME' => $starttime,
                'CHR_DUE_DATE' => $duedate,
                'CHR_DUE_TIME' => $duetime,
                'INT_QTY' => $this->input->post('INT_QTY'),
                'CHR_FILENAME' => $this->input->post('FILE_UPLOAD'),
                'CHR_QPROBLEM_DESC' => $this->input->post('CHR_QPROBLEM_DESC'),
                'CHR_CREATED_BY' => $session['NPK'], 
                'CHR_TR_NO' => $new_tr_no,
                'CHR_CLASS_PROBLEM' => $this->input->post('CHR_CLASS_PROBLEM'),
                'INT_ID_PARENT' => $this->input->post('INT_ID_PARENT'),
                'INT_ID_CHILD' => ($this->input->post('INT_ID_CHILD')+1),
                'INT_FLG_REPEAT' => $this->input->post('INT_FLG_REPEAT'),
                'CHR_UNIT_TYPE' => $this->input->post('CHR_UNIT'),
                'INT_ID_TEAM' => $id_team->INT_ID_TEAM
            );
            $this->quality_problem_m->save($data);

            $seq_id = $this->notification_m->generate_id();

            $data_notif = array(
                'INT_ID_NOTIF' => $seq_id,
                'CHR_NPK' => $pic,
                'INT_ID_APP' => '22',
                'CHR_NOTIF_TITLE' => $this->input->post('CHR_QPROBLEM_TITLE'),
                'CHR_NOTIF_DESC' => $this->input->post('CHR_QPROBLEM_DESC'),
                'CHR_LINK' => "quality/quality_feedback_c/select_quality_problem_by_id/$id",
                //'CHR_LINK' => "quality/quality_feedback_c/",
                'CHR_CREATED_BY' => $session['USERNAME'],
                'CHR_CREATED_DATE' => date('Ymd'),
                'CHR_CREATED_TIME' => date('His')
            );

            $this->notification_m->insert_notification($data_notif);

            redirect($this->back_to_view . $id);
        }
    }

    //prepare to editing
    function edit_quality_problem($id) {
        $this->role_module_m->authorization('166');
        $data['data'] = $this->quality_problem_m->get_quality_problem_by_id($id);

        $data['content'] = 'quality/reporting_problem/edit_problem_quality_v';
               
        $data['all_back_no'] = $this->quality_problem_m->get_all_back_no();       
        $data['all_section'] = $this->quality_problem_m->get_all_section();
        $data['all_list_problem'] = $this->quality_problem_m->get_all_list_problem();
        
        $data['app'] = $this->role_module_m->get_app();
        $data['news'] = $this->news_m->get_news();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(166);

        $data['title'] = 'Edit Problem Quality';
        $this->load->view($this->layout, $data);
    }

    //updating data
    function update_quality_problem() {
        $this->load->library('upload');
        
        $session = $this->session->all_userdata();
        $startdate = date("Ymd", strtotime($this->input->post('CHR_START_DATE')));
        $starttime = date("His", strtotime($this->input->post('CHR_START_TIME')));
        $duedate = date("Ymd", strtotime('+4 hours', strtotime($startdate)));
        $duetime = date("His", strtotime('+4 hours', strtotime($starttime)));
        $id = $this->input->post('INT_ID');
        $path = $this->input->post('FILE_UPLOAD');
        $fileName = trim($session['NPK']) . '_' . date("YmdHis");
        $input_type = $this->input->post('CHR_TYPE');
        
        if($input_type == '1'){
            $back_no = $this->input->post('CHR_BACK_NO');
        } else {
            $back_no = $this->input->post('CHR_PART_NO');
        }
        
        $part_name = $this->db->query("SELECT A.[CHR_PART_NAME]
                                               ,A.[CHR_PART_NO]
                                               ,B.[CHR_BACK_NO]
                                         FROM [TM_PARTS] A
                                         LEFT JOIN TM_KANBAN B ON A.CHR_PART_NO = B.CHR_PART_NO
                                         WHERE A.CHR_BACK_NO =  '$back_no'")->row();
        
        $get_work_center = $this->db->query("SELECT DISTINCT C.[CHR_WORK_CENTER]
                                         FROM [TM_PARTS] A
                                         LEFT JOIN TM_KANBAN B ON A.CHR_PART_NO = B.CHR_PART_NO
                                         LEFT JOIN TM_PROCESS_PARTS C ON A.CHR_PART_NO = C.CHR_PART_NO
                                         WHERE A.CHR_BACK_NO =  '$back_no'")->result();
        $work_center = '';                
        $row = count($get_work_center);
        if($row > 0){
            $x = 1;
            foreach($get_work_center as $wc){
                if($x != $row){
                  $work_center .= trim($wc->CHR_WORK_CENTER) . ';';  
                } else {
                  $work_center .= trim($wc->CHR_WORK_CENTER); 
                }                        
                $x++;
            }
        }
        
        $pic = $this->input->post('CHR_USERNAME');
        
        if (strlen($pic) == 8){
            $pic = substr($pic,2,4);
        } else if (strlen($pic) == 10){
            $pic = substr($pic,2,6);
        }
        
        $pic_name = $this->db->query("SELECT [CHR_USERNAME]
                                         FROM [TM_USER]
                                         WHERE CHR_NPK =  '$pic' AND BIT_FLG_DEL = 'False' AND BIT_FLG_ACTIVE = 'True'")->row();
        
        $id_pic_sect = $this->input->post('INT_ID_SECTION_PIC');
        $id_team = $this->db->query("SELECT DISTINCT [INT_ID_TEAM]
                                 FROM [QUA].[TM_MAPPING_TEAM_PIC]
                                 WHERE INT_ID_SECTION = '$id_pic_sect' AND INT_FLG_DELETE <> 1")->row();
                       
        $this->form_validation->set_rules('CHR_QPROBLEM_DESC', 'Desc', 'required|min_length[10]|max_length[100]');

        if ($this->form_validation->run() == FALSE) {
            $this->edit_quality_problem($id);
        } else {
            if ($_FILES['file']['name'] != '')
            {
                if(is_file($path)){
                    unlink($path);
                    $this->db->query("UPDATE QUA.TT_QUALITY_PROBLEM SET CHR_FILENAME = '' WHERE INT_ID = $id");
                }
                
                $config['upload_path'] = "assets/file/qis_feedback/";
                $config['file_name'] = $fileName;
                $config['allowed_types'] = 'JPEG|jpg|png|gif';
                $config['max_size'] = 3000;
                
                $ext = end((explode(".", $_FILES['file']['name'])));
                
                $this->upload->initialize($config);
                if (!$this->upload->do_upload('file')) {
                    $error = array('error' => $this->upload->display_errors());
                    echo $error['error'];
                    exit();
                } else {                 
                    
                    $success = array('upload_data' => $this->upload->data());
                    $data = array(
                            'CHR_QPROBLEM_TITLE' => $this->input->post('CHR_QPROBLEM_TITLE'),
                            'CHR_PART_NAME' => $part_name->CHR_PART_NAME,                    
                            'CHR_BACK_NO' => $back_no,
                            'CHR_PART_NO' => $part_name->CHR_PART_NO,
                            'CHR_WORK_CENTER' => $work_center,
                            'CHR_PIC' => $pic_name->CHR_USERNAME,                    
                            'INT_ID_SECTION_PIC' => $this->input->post('INT_ID_SECTION_PIC'),
                            'CHR_REQUESTOR' => $this->input->post('CHR_INSPECTOR'),
                            'INT_ID_SECTION_REQUESTOR' => $this->input->post('INT_ID_SECTION_REQUESTOR'),
                            'CHR_START_DATE' => $startdate,
                            'CHR_START_TIME' => $starttime,
                            'CHR_DUE_DATE' => $duedate,
                            'CHR_DUE_TIME' => $duetime,
                            'INT_QTY' => $this->input->post('INT_QTY'),
                            'CHR_FILENAME' => 'assets/file/qis_feedback/' . $fileName . '.' . $ext,
                            'CHR_QPROBLEM_DESC' => $this->input->post('CHR_QPROBLEM_DESC'),
                            'CHR_CREATED_BY' => $session['NPK'],
                            'CHR_MODIFED_BY' => $session['NPK'], 
                            'CHR_CLASS_PROBLEM' => $this->input->post('CHR_CLASS_PROBLEM'),
                            'INT_ID_PARENT' => $this->input->post('INT_ID_PARENT'),
                            'INT_ID_CHILD' => $this->input->post('INT_ID_CHILD'),
                            'INT_FLG_REPEAT' => $this->input->post('INT_FLG_REPEAT'),
                            'CHR_MODIFED_DATE' => date('Ymd'),
                            'CHR_MODIFED_TIME' => date('His'),
                            'CHR_UNIT_TYPE' => $this->input->post('CHR_UNIT'),
                            'INT_ID_TEAM' => $id_team->INT_ID_TEAM
                        );
                    $this->quality_problem_m->update($data, $id);
                }
            } else {              
                    $data = array(
                        'CHR_QPROBLEM_TITLE' => $this->input->post('CHR_QPROBLEM_TITLE'),
                        'CHR_PART_NAME' => $part_name->CHR_PART_NAME,                    
                        'CHR_BACK_NO' => $back_no,
                        'CHR_PART_NO' => $part_name->CHR_PART_NO,
                        'CHR_WORK_CENTER' => $work_center,
                        'CHR_PIC' => $pic_name->CHR_USERNAME,                    
                        'INT_ID_SECTION_PIC' => $this->input->post('INT_ID_SECTION_PIC'),
                        'CHR_REQUESTOR' => $this->input->post('CHR_INSPECTOR'),
                        'INT_ID_SECTION_REQUESTOR' => $this->input->post('INT_ID_SECTION_REQUESTOR'),
                        'CHR_START_DATE' => $startdate,
                        'CHR_START_TIME' => $starttime,
                        'CHR_DUE_DATE' => $duedate,
                        'CHR_DUE_TIME' => $duetime,
                        'INT_QTY' => $this->input->post('INT_QTY'),
                        'CHR_FILENAME' => $path,
                        'CHR_QPROBLEM_DESC' => $this->input->post('CHR_QPROBLEM_DESC'),
                        'CHR_CREATED_BY' => $session['NPK'],
                        'CHR_MODIFED_BY' => $session['NPK'], 
                        'CHR_CLASS_PROBLEM' => $this->input->post('CHR_CLASS_PROBLEM'),
                        'INT_ID_PARENT' => $this->input->post('INT_ID_PARENT'),
                        'INT_ID_CHILD' => $this->input->post('INT_ID_CHILD'),
                        'INT_FLG_REPEAT' => $this->input->post('INT_FLG_REPEAT'),
                        'CHR_MODIFED_DATE' => date('Ymd'),
                        'CHR_MODIFED_TIME' => date('His'),
                        'CHR_UNIT_TYPE' => $this->input->post('CHR_UNIT'),
                        'INT_ID_TEAM' => $id_team->INT_ID_TEAM
                    );
                    $this->quality_problem_m->update($data, $id);
            }

            $seq_id = $this->notification_m->generate_id();

            $data_notif = array(
                'INT_ID_NOTIF' => $seq_id,
                'CHR_NPK' => $pic,
                'INT_ID_APP' => '22',
                'CHR_NOTIF_TITLE' => $this->input->post('CHR_QPROBLEM_TITLE'),
                'CHR_NOTIF_DESC' => $this->input->post('CHR_QPROBLEM_DESC'),
                'CHR_LINK' => "quality/quality_feedback_c/select_quality_problem_by_id/$id",
                'CHR_CREATED_BY' => $session['NPK'],
                'CHR_CREATED_DATE' => date('Ymd'),
                'CHR_CREATED_TIME' => date('His')
            );

            $this->notification_m->insert_notification($data_notif);
            redirect($this->back_to_view . $id);
        }
    }

    //deleting data
    function delete_quality_problem($id, $periode) {
        $this->role_module_m->authorization('166');
        $this->quality_problem_m->delete($id);
        redirect($this->back_to_manage . $periode . '/' . $msg = 3);
    }

    function get_part_name() {
        $back_no = $id = $this->input->post('back_no');
        //$part_name = $this->db->query("SELECT DISTINCT RTRIM(CHR_PART_NAME) AS CHR_PART_NAME FROM TT_PRODUCTION_RESULT WHERE CHR_BACK_NO = '$back_no'")->row();
        $part_name = $this->db->query("SELECT RTRIM([CHR_PART_NAME]) AS CHR_PART_NAME
                                      FROM [TM_PARTS] A
                                      LEFT JOIN TM_KANBAN B ON A.CHR_PART_NO = B.CHR_PART_NO
                                      WHERE A.CHR_BACK_NO = '$back_no' OR B.CHR_BACK_NO = '$back_no'")->row();
        
        echo $part_name->CHR_PART_NAME;
        //echo $part_name->CHR_PART_NAME;
    }
    
    function get_user_by_dept() {
        $sect = $this->input->post('id_sect');
        $get_dept = $this->quality_problem_m->get_dept_by_sect($sect)->row();
        $dept = $get_dept->INT_ID_DEPT;
        $user_response = $this->quality_problem_m->get_mapping_pic($dept, $sect)->result();
        $option = NULL;
        
        foreach ($user_response as $data){
            $option .= '<option value="' . trim($data->CHR_NPK) . '">' . strtoupper(trim($data->CHR_USERNAME)) . '</option>';
        }
       
        echo str_replace('\\/', '/', json_encode($option));
       
    }
    
    function export_tr($id){
        $this->load->library('excel');

        //Get detail_tr
        $detail_tr = $this->quality_problem_m->get_quality_problem_by_id($id);
        //Get feedback
        $feedback = $this->quality_feedback_m->get_data_by_id($id)->result();
        $tot_feed = count($feedback);
        
        $i = 1;
        $action = '';
        $man_temp = '';
        $methode_temp = '';
        $machine_temp = '';
        $material_temp = '';
        $man_fix = '';
        $methode_fix = '';
        $machine_fix = '';
        $material_fix = '';
        if($tot_feed != 0 || $tot_feed != NULL){
            foreach($feedback as $feed){
                if($i == $tot_feed){
                    $action .= $feed->CHR_FEEDBACK_DESC . ' (' . $feed->INT_ACTION_TYPE . ')';
                    if($feed->INT_ACTION_TYPE == 'FIX'){
                        $man_fix .= $feed->CHR_MAN_ANALYSIS . ', ';
                        $methode_fix .= $feed->CHR_METHODE_ANALYSIS . ', ';
                        $machine_fix .= $feed->CHR_MACHINE_ANALYSIS . ', ';
                        $material_fix .= $feed->CHR_MATERIAL_ANALYSIS . ', ';
                    } else {
                        $man_temp .= $feed->CHR_MAN_ANALYSIS;
                        $methode_temp .= $feed->CHR_METHODE_ANALYSIS . ', ';
                        $machine_temp .= $feed->CHR_MACHINE_ANALYSIS . ', ';
                        $material_temp .= $feed->CHR_MATERIAL_ANALYSIS . ', ';
                    }                
                } else {
                    $action .= $feed->CHR_FEEDBACK_DESC . ' (' . $feed->INT_ACTION_TYPE . '), ';
                    if($feed->INT_ACTION_TYPE == 'FIX'){
                        $man_fix .= $feed->CHR_MAN_ANALYSIS . ', ';
                        $methode_fix .= $feed->CHR_METHODE_ANALYSIS . ', ';
                        $machine_fix .= $feed->CHR_MACHINE_ANALYSIS . ', ';
                        $material_fix .= $feed->CHR_MATERIAL_ANALYSIS . ', ';
                    } else {
                        $man_temp .= $feed->CHR_MAN_ANALYSIS . ', ';
                        $methode_temp .= $feed->CHR_METHODE_ANALYSIS . ', ';
                        $machine_temp .= $feed->CHR_MACHINE_ANALYSIS . ', ';
                        $material_temp .= $feed->CHR_MATERIAL_ANALYSIS . ', ';
                    }
                }
                $i++;
            }
        }
        
        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

        // Set Properties
        $objPHPExcel->getProperties()->setCreator(trim($this->session->userdata('USERNAME')));
        $objPHPExcel->getProperties()->setLastModifiedBy(trim($this->session->userdata('USERNAME')));
        $objPHPExcel->getProperties()->setTitle("TECHINCAL REPORT");
        $objPHPExcel->getProperties()->setSubject("TECHINCAL REPORT");
        $objPHPExcel->getProperties()->setDescription("TECHINCAL REPORT");
                
        //Header TR
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'PT. Aisin Indonesia');
        $objPHPExcel->getActiveSheet()->getStyle("A1")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->mergeCells('A1:E1');
        $objPHPExcel->getActiveSheet()->setCellValue('A2', 'Quality Dept');
        $objPHPExcel->getActiveSheet()->getStyle("A2")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->mergeCells('A2:E2');
        $objPHPExcel->getActiveSheet()->setCellValue('F1', 'TECHNICAL REPORT');
        $objPHPExcel->getActiveSheet()->getStyle("F1")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("F1")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->mergeCells('F1:J2');        

        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true)->setSize(13);
        $objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true)->setSize(11);
        $objPHPExcel->getActiveSheet()->getStyle('F1')->getFont()->setBold(true)->setSize(18);
        
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(2);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(8);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(8);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(8);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(2);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(8);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(8);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(8);

        //Merge Cells
        $objPHPExcel->getActiveSheet()->mergeCells('A7:A8');
        $objPHPExcel->getActiveSheet()->mergeCells('A9:E9');
        $objPHPExcel->getActiveSheet()->mergeCells('A10:E13');
        $objPHPExcel->getActiveSheet()->mergeCells('A14:E14');
        $objPHPExcel->getActiveSheet()->mergeCells('A15:E20');
        $objPHPExcel->getActiveSheet()->mergeCells('A22:J22');
        $objPHPExcel->getActiveSheet()->mergeCells('A23:E23');
        $objPHPExcel->getActiveSheet()->mergeCells('A24:A26');
        $objPHPExcel->getActiveSheet()->mergeCells('A27:A29');
        $objPHPExcel->getActiveSheet()->mergeCells('A30:A32');
        $objPHPExcel->getActiveSheet()->mergeCells('A33:A35');
        $objPHPExcel->getActiveSheet()->mergeCells('A36:J36');
        $objPHPExcel->getActiveSheet()->mergeCells('A37:E37');
        $objPHPExcel->getActiveSheet()->mergeCells('A38:E41');
        $objPHPExcel->getActiveSheet()->mergeCells('A42:E46');
        
        $objPHPExcel->getActiveSheet()->mergeCells('B7:B8');
        $objPHPExcel->getActiveSheet()->mergeCells('B24:B26');
        $objPHPExcel->getActiveSheet()->mergeCells('B27:B29');
        $objPHPExcel->getActiveSheet()->mergeCells('B30:B32');
        $objPHPExcel->getActiveSheet()->mergeCells('B33:B35');
        
        $objPHPExcel->getActiveSheet()->mergeCells('C21:E21');
        $objPHPExcel->getActiveSheet()->mergeCells('C4:E4');
        $objPHPExcel->getActiveSheet()->mergeCells('C5:E5');
        $objPHPExcel->getActiveSheet()->mergeCells('C6:E6');
        $objPHPExcel->getActiveSheet()->mergeCells('C7:E8');
        $objPHPExcel->getActiveSheet()->mergeCells('C24:E26');
        $objPHPExcel->getActiveSheet()->mergeCells('C27:E29');
        $objPHPExcel->getActiveSheet()->mergeCells('C30:E32');
        $objPHPExcel->getActiveSheet()->mergeCells('C33:E35');
        
        $objPHPExcel->getActiveSheet()->mergeCells('F7:F8');
        $objPHPExcel->getActiveSheet()->mergeCells('F9:J9');
        $objPHPExcel->getActiveSheet()->mergeCells('F10:J20');
        $objPHPExcel->getActiveSheet()->mergeCells('F23:J23');
        $objPHPExcel->getActiveSheet()->mergeCells('F24:F26');
        $objPHPExcel->getActiveSheet()->mergeCells('F27:F29');
        $objPHPExcel->getActiveSheet()->mergeCells('F30:F32');
        $objPHPExcel->getActiveSheet()->mergeCells('F33:F35');
        $objPHPExcel->getActiveSheet()->mergeCells('F37:J37');
        $objPHPExcel->getActiveSheet()->mergeCells('F38:J41');
        $objPHPExcel->getActiveSheet()->mergeCells('F43:F46');
        
        $objPHPExcel->getActiveSheet()->mergeCells('G7:G8');
        $objPHPExcel->getActiveSheet()->mergeCells('G24:G26');
        $objPHPExcel->getActiveSheet()->mergeCells('G27:G29');
        $objPHPExcel->getActiveSheet()->mergeCells('G30:G32');
        $objPHPExcel->getActiveSheet()->mergeCells('G33:G35');
        $objPHPExcel->getActiveSheet()->mergeCells('G42:H42');
        $objPHPExcel->getActiveSheet()->mergeCells('G43:H46');
        
        $objPHPExcel->getActiveSheet()->mergeCells('H4:J4');
        $objPHPExcel->getActiveSheet()->mergeCells('H5:J5');
        $objPHPExcel->getActiveSheet()->mergeCells('H6:J6');
        $objPHPExcel->getActiveSheet()->mergeCells('H7:J8');
        $objPHPExcel->getActiveSheet()->mergeCells('H21:J21');
        $objPHPExcel->getActiveSheet()->mergeCells('H24:J26');
        $objPHPExcel->getActiveSheet()->mergeCells('H27:J29');
        $objPHPExcel->getActiveSheet()->mergeCells('H30:J32');
        $objPHPExcel->getActiveSheet()->mergeCells('H33:J35');
        
        $objPHPExcel->getActiveSheet()->mergeCells('I42:J42');
        $objPHPExcel->getActiveSheet()->mergeCells('I43:J46');
        
        //Alignment of All Cells
        $objPHPExcel->getActiveSheet()->getStyle("A7")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("A10")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
        $objPHPExcel->getActiveSheet()->getStyle("A24")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("A27")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("A30")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("A33")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        
        $objPHPExcel->getActiveSheet()->getStyle("B7")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("B24")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("B27")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("B30")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("B33")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        
        $objPHPExcel->getActiveSheet()->getStyle("C7")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        
        $objPHPExcel->getActiveSheet()->getStyle("F7")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("F24")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("F27")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("F30")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("F33")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        
        $objPHPExcel->getActiveSheet()->getStyle("G7")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("G24")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("G27")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("G30")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("G33")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        
        $objPHPExcel->getActiveSheet()->getStyle("H7")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        
        //Value of All Cells        
        $objPHPExcel->getActiveSheet()->setCellValue('A3', 'No TR');
        $objPHPExcel->getActiveSheet()->setCellValue('A4', 'Back No');
        $objPHPExcel->getActiveSheet()->setCellValue('A5', 'Before Process');
        $objPHPExcel->getActiveSheet()->setCellValue('A6', 'Part Name');
        $objPHPExcel->getActiveSheet()->setCellValue('A7', 'Problem');        
        $objPHPExcel->getActiveSheet()->setCellValue('A9', 'Detail of Problem');                
        $objPHPExcel->getActiveSheet()->setCellValue('A14', 'Temporary/Permanent Action');        
        $objPHPExcel->getActiveSheet()->setCellValue('A21', 'PIC Section BP');
        $objPHPExcel->getActiveSheet()->setCellValue('A22', '4M Analysis');        
        $objPHPExcel->getActiveSheet()->setCellValue('A23', 'Occurence Cause Problem');        
        $objPHPExcel->getActiveSheet()->setCellValue('A24', 'MAN');
        $objPHPExcel->getActiveSheet()->setCellValue('A27', 'MATERIAL');
        $objPHPExcel->getActiveSheet()->setCellValue('A30', 'MACHINE');
        $objPHPExcel->getActiveSheet()->setCellValue('A33', 'METHODE');        
        $objPHPExcel->getActiveSheet()->setCellValue('A36', 'Evidence of Improvement Activity');        
        $objPHPExcel->getActiveSheet()->setCellValue('A37', 'Before Improvement'); 
        
        $objPHPExcel->getActiveSheet()->setCellValue('B3', ':');
        $objPHPExcel->getActiveSheet()->setCellValue('B4', ':');
        $objPHPExcel->getActiveSheet()->setCellValue('B5', ':');
        $objPHPExcel->getActiveSheet()->setCellValue('B6', ':');
        $objPHPExcel->getActiveSheet()->setCellValue('B7', ':');
        $objPHPExcel->getActiveSheet()->setCellValue('B21', ':');
        $objPHPExcel->getActiveSheet()->setCellValue('B24', ':');
        $objPHPExcel->getActiveSheet()->setCellValue('B27', ':');
        $objPHPExcel->getActiveSheet()->setCellValue('B30', ':');
        $objPHPExcel->getActiveSheet()->setCellValue('B33', ':');
        
        $objPHPExcel->getActiveSheet()->setCellValue('F3', 'Defective Date');
        $objPHPExcel->getActiveSheet()->setCellValue('F4', 'Accepted Date');
        $objPHPExcel->getActiveSheet()->setCellValue('F5', 'Class Problem');
        $objPHPExcel->getActiveSheet()->setCellValue('F6', 'Inspector');
        $objPHPExcel->getActiveSheet()->setCellValue('F7', 'Defect Qty');
        $objPHPExcel->getActiveSheet()->setCellValue('F9', 'Image Part NG');
        $objPHPExcel->getActiveSheet()->setCellValue('F21', 'Due Date');
        $objPHPExcel->getActiveSheet()->setCellValue('F23', 'FLow Out Cause Problem');        
        $objPHPExcel->getActiveSheet()->setCellValue('F24', 'MAN');
        $objPHPExcel->getActiveSheet()->setCellValue('F27', 'MATERIAL');
        $objPHPExcel->getActiveSheet()->setCellValue('F30', 'MACHINE');
        $objPHPExcel->getActiveSheet()->setCellValue('F33', 'METHODE');
        $objPHPExcel->getActiveSheet()->setCellValue('F37', 'After Improvement');
        $objPHPExcel->getActiveSheet()->setCellValue('F42', 'Supervisor');
        
        $objPHPExcel->getActiveSheet()->setCellValue('G3', ':');
        $objPHPExcel->getActiveSheet()->setCellValue('G4', ':');
        $objPHPExcel->getActiveSheet()->setCellValue('G5', ':');
        $objPHPExcel->getActiveSheet()->setCellValue('G6', ':');
        $objPHPExcel->getActiveSheet()->setCellValue('G7', ':');
        $objPHPExcel->getActiveSheet()->setCellValue('G21', ':');
        $objPHPExcel->getActiveSheet()->setCellValue('G24', ':');
        $objPHPExcel->getActiveSheet()->setCellValue('G27', ':');
        $objPHPExcel->getActiveSheet()->setCellValue('G30', ':');
        $objPHPExcel->getActiveSheet()->setCellValue('G33', ':');
        $objPHPExcel->getActiveSheet()->setCellValue('G42', 'Quality'); 
                
        $objPHPExcel->getActiveSheet()->setCellValue('I42', 'JP/Leader'); 
        
        //Value of TR
        $objDrawing = new PHPExcel_Worksheet_Drawing();
        $objDrawing->setName('Logo');
        $objDrawing->setDescription('Logo');
        $objDrawing->setPath('assets/img/LogoAisin.png');
        $objDrawing->setOffsetX(8);
        $objDrawing->setOffsetY(70);
        $objDrawing->setCoordinates('A1');
        $objDrawing->setHeight(40);
        $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
        
        $objPHPExcel->getActiveSheet()->setCellValue("A10", $detail_tr->CHR_QPROBLEM_DESC);
        $objPHPExcel->getActiveSheet()->setCellValue("A15", $action);        
        $objPHPExcel->getActiveSheet()->getStyle('A15:E20')->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("A15")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $objPHPExcel->getActiveSheet()->getStyle("A15")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
                      
        $objPHPExcel->getActiveSheet()->setCellValue("C3", $detail_tr->CHR_TR_NO);        
        $objPHPExcel->getActiveSheet()->setCellValue("C4", $detail_tr->CHR_BACK_NO);        
        $objPHPExcel->getActiveSheet()->setCellValue("C5", $detail_tr->CHR_SECTION_PIC);        
        $objPHPExcel->getActiveSheet()->setCellValue("C6", $detail_tr->CHR_PART_NAME);        
        $objPHPExcel->getActiveSheet()->setCellValue("C7", $detail_tr->CHR_QPROBLEM_TITLE); 
        $objPHPExcel->getActiveSheet()->setCellValue("C21", $detail_tr->CHR_PIC);
        
        $objPHPExcel->getActiveSheet()->setCellValue("C24", $man_fix);
        $objPHPExcel->getActiveSheet()->getStyle('C24:E26')->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("C24")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $objPHPExcel->getActiveSheet()->getStyle("C24")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
        
        $objPHPExcel->getActiveSheet()->setCellValue("C27", $material_fix);
        $objPHPExcel->getActiveSheet()->getStyle('C27:E29')->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("C27")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $objPHPExcel->getActiveSheet()->getStyle("C27")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
        
        $objPHPExcel->getActiveSheet()->setCellValue("C30", $machine_fix);
        $objPHPExcel->getActiveSheet()->getStyle('C30:E32')->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("C30")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $objPHPExcel->getActiveSheet()->getStyle("C30")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
        
        $objPHPExcel->getActiveSheet()->setCellValue("C33", $methode_fix);
        $objPHPExcel->getActiveSheet()->getStyle('C33:E35')->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("C33")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $objPHPExcel->getActiveSheet()->getStyle("C33")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
        
        $objDrawing = new PHPExcel_Worksheet_Drawing();
        $objDrawing->setName('Image NG');
        $objDrawing->setDescription('Image NG');
        $objDrawing->setPath($detail_tr->CHR_FILENAME);
        $objDrawing->setOffsetX(8);
        $objDrawing->setOffsetY(70);
        $objDrawing->setCoordinates('F11');
        $objDrawing->setHeight(100);
        $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());        
        
        $objPHPExcel->getActiveSheet()->getStyle("F10")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        $defect_time = substr($detail_tr->CHR_START_TIME,0,2).':'.substr($detail_tr->CHR_START_TIME,3,2);
        $accept_time = substr($detail_tr->CHR_CREATED_TIME,0,2).':'.substr($detail_tr->CHR_CREATED_TIME,3,2);
        $due_time = substr($detail_tr->CHR_DUE_TIME,0,2).':'.substr($detail_tr->CHR_DUE_TIME,3,2);
        
        $objPHPExcel->getActiveSheet()->setCellValue("H3", $detail_tr->CHR_START_DATE . ' ' . $defect_time);        
        $objPHPExcel->getActiveSheet()->setCellValue("H4", $detail_tr->CHR_CREATED_DATE . ' ' . $accept_time);        
        $objPHPExcel->getActiveSheet()->setCellValue("H5", $detail_tr->CHR_CLASS_PROBLEM);        
        $objPHPExcel->getActiveSheet()->setCellValue("H6", $detail_tr->CHR_REQUESTOR);        
        $objPHPExcel->getActiveSheet()->setCellValue("H7", $detail_tr->INT_QTY);        
        $objPHPExcel->getActiveSheet()->getStyle("H7")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $objPHPExcel->getActiveSheet()->setCellValue("H21", $detail_tr->CHR_DUE_DATE . ' ' . $due_time);
        
        $objPHPExcel->getActiveSheet()->setCellValue("H24", $man_temp);
        $objPHPExcel->getActiveSheet()->getStyle('H24:J26')->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("H24")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $objPHPExcel->getActiveSheet()->getStyle("H24")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
        
        $objPHPExcel->getActiveSheet()->setCellValue("H27", $material_temp);
        $objPHPExcel->getActiveSheet()->getStyle('H27:J29')->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("H27")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $objPHPExcel->getActiveSheet()->getStyle("H27")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
        
        $objPHPExcel->getActiveSheet()->setCellValue("H30", $machine_temp);
        $objPHPExcel->getActiveSheet()->getStyle('H30:J32')->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("H30")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $objPHPExcel->getActiveSheet()->getStyle("H30")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
        
        $objPHPExcel->getActiveSheet()->setCellValue("H33", $methode_fix);
        $objPHPExcel->getActiveSheet()->getStyle('H33:J35')->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("H33")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $objPHPExcel->getActiveSheet()->getStyle("H33")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
        
        
        $styleArray = array(
            'borders' => array(
                'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                ),
            ),
        );
        
        $styleArray2 = array(
            'borders' => array(
                'bottom' => array(
                    'style' => PHPExcel_Style_Border::BORDER_DOUBLE,
                ),
            ),
        );
        
        $styleArray3 = array(
            'borders' => array(
                'horizontal' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                ),
            ),
        );
        
        $styleArray4 = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                ),
            ),
        );
        
        $objPHPExcel->getActiveSheet()->getStyle("A1:J46")->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->getStyle("A1:E2")->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->getStyle("A3:J6")->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->getStyle("A7:J8")->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->getStyle("A9:J21")->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->getStyle("A9:J21")->applyFromArray($styleArray3);
        $objPHPExcel->getActiveSheet()->getStyle("A22:J35")->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->getStyle("A22:J35")->applyFromArray($styleArray3);
        $objPHPExcel->getActiveSheet()->getStyle("A36:J41")->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->getStyle("A36:J41")->applyFromArray($styleArray3);
        $objPHPExcel->getActiveSheet()->getStyle("A42:J46")->applyFromArray($styleArray4);
        $objPHPExcel->getActiveSheet()->getStyle("A1:E46")->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->getStyle("A2:J2")->applyFromArray($styleArray2);
        
        $filename = "Technical Report.xls";
        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . trim($filename) . '"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->setIncludeCharts(TRUE);
        $objWriter->save('php://output');
    }
    
    function export_new_tr($id){
        $this->load->library('excel');

        //Get detail_tr
        $detail_tr = $this->quality_problem_m->get_quality_problem_by_id($id);
        //Get feedback
        $feedback = $this->quality_feedback_m->get_data_by_id($id)->result();
        $tot_feed = count($feedback);
        
        $i = 1;
        $action = '';
        $man_temp = '';
        $methode_temp = '';
        $machine_temp = '';
        $material_temp = '';
        $man_fix = '';
        $methode_fix = '';
        $machine_fix = '';
        $material_fix = '';
        if($tot_feed != 0 || $tot_feed != NULL){
            foreach($feedback as $feed){
                if($i == $tot_feed){
                    $action .= $feed->CHR_FEEDBACK_DESC . ' (' . $feed->INT_ACTION_TYPE . ')';
                    if($feed->INT_ACTION_TYPE == 'FIX'){
                        $man_fix .= $feed->CHR_MAN_ANALYSIS . ', ';
                        $methode_fix .= $feed->CHR_METHODE_ANALYSIS . ', ';
                        $machine_fix .= $feed->CHR_MACHINE_ANALYSIS . ', ';
                        $material_fix .= $feed->CHR_MATERIAL_ANALYSIS . ', ';
                    } else {
                        $man_temp .= $feed->CHR_MAN_ANALYSIS;
                        $methode_temp .= $feed->CHR_METHODE_ANALYSIS . ', ';
                        $machine_temp .= $feed->CHR_MACHINE_ANALYSIS . ', ';
                        $material_temp .= $feed->CHR_MATERIAL_ANALYSIS . ', ';
                    }                
                } else {
                    $action .= $feed->CHR_FEEDBACK_DESC . ' (' . $feed->INT_ACTION_TYPE . '), ';
                    if($feed->INT_ACTION_TYPE == 'FIX'){
                        $man_fix .= $feed->CHR_MAN_ANALYSIS . ', ';
                        $methode_fix .= $feed->CHR_METHODE_ANALYSIS . ', ';
                        $machine_fix .= $feed->CHR_MACHINE_ANALYSIS . ', ';
                        $material_fix .= $feed->CHR_MATERIAL_ANALYSIS . ', ';
                    } else {
                        $man_temp .= $feed->CHR_MAN_ANALYSIS . ', ';
                        $methode_temp .= $feed->CHR_METHODE_ANALYSIS . ', ';
                        $machine_temp .= $feed->CHR_MACHINE_ANALYSIS . ', ';
                        $material_temp .= $feed->CHR_MATERIAL_ANALYSIS . ', ';
                    }
                }
                $i++;
            }
        }
        
        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

        // Set Properties
        $objPHPExcel->getProperties()->setCreator(trim($this->session->userdata('USERNAME')));
        $objPHPExcel->getProperties()->setLastModifiedBy(trim($this->session->userdata('USERNAME')));
        $objPHPExcel->getProperties()->setTitle("TECHINCAL REPORT");
        $objPHPExcel->getProperties()->setSubject("TECHINCAL REPORT");
        $objPHPExcel->getProperties()->setDescription("TECHINCAL REPORT");
                
        //Header TR        
        $objDrawing = new PHPExcel_Worksheet_Drawing();
        $objDrawing->setName('Logo');
        $objDrawing->setDescription('Logo');
        $objDrawing->setPath('assets/img/LogoAisin.png');
        $objDrawing->setOffsetX(8);
        $objDrawing->setOffsetY(70);
        $objDrawing->setCoordinates('A1');
        $objDrawing->setHeight(90);
        $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
        
        $objPHPExcel->getActiveSheet()->setCellValue('C1', 'PT. AISIN INDONESIA');
        $objPHPExcel->getActiveSheet()->getStyle("C1")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $objPHPExcel->getActiveSheet()->mergeCells('C1:E1');
        $objPHPExcel->getActiveSheet()->setCellValue('C2', 'Quality Assurance Dept');
        $objPHPExcel->getActiveSheet()->getStyle("C2")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $objPHPExcel->getActiveSheet()->mergeCells('C2:E2');
        $objPHPExcel->getActiveSheet()->setCellValue('C3', 'Customer Claim Section');
        $objPHPExcel->getActiveSheet()->getStyle("C3")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $objPHPExcel->getActiveSheet()->mergeCells('C3:E3');
        $objPHPExcel->getActiveSheet()->setCellValue('C4', 'Ejip Plot 5J Cikarang Selatan');
        $objPHPExcel->getActiveSheet()->getStyle("C4")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $objPHPExcel->getActiveSheet()->mergeCells('C4:E4');
        $objPHPExcel->getActiveSheet()->setCellValue('C5', 'Bekasi 17550');
        $objPHPExcel->getActiveSheet()->getStyle("C5")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $objPHPExcel->getActiveSheet()->mergeCells('C5:E5');
        
        $objPHPExcel->getActiveSheet()->mergeCells('A1:B5');
        $objPHPExcel->getActiveSheet()->mergeCells('A6:E6');
        
        // ----- TITLE DOC ------ //
        $objPHPExcel->getActiveSheet()->setCellValue('F1', 'CLAIM ANSWER SHEET');
        $objPHPExcel->getActiveSheet()->mergeCells('F1:N3');
        $objPHPExcel->getActiveSheet()->getStyle("F1")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("F1")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('F4', 'No Form : FRM - QAS -      -      :     ');
        $objPHPExcel->getActiveSheet()->mergeCells('F4:N5');
        $objPHPExcel->getActiveSheet()->getStyle("F4")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("F4")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
        
        $objPHPExcel->getActiveSheet()->mergeCells('F6:N6');
        $objPHPExcel->getActiveSheet()->mergeCells('F7:M7');
        
        // ------ SIGN APPROVAL ------ //
        $objPHPExcel->getActiveSheet()->setCellValue('O1', 'PT. Aisin Indonesia');
        $objPHPExcel->getActiveSheet()->mergeCells('O1:R1');
        $objPHPExcel->getActiveSheet()->getStyle("O1")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('O2', 'Acknowledge');
        $objPHPExcel->getActiveSheet()->getStyle("O2")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->mergeCells('O3:O5');
        $objPHPExcel->getActiveSheet()->setCellValue('P2', 'Approved');
        $objPHPExcel->getActiveSheet()->getStyle("P2")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->mergeCells('P3:P5');
        $objPHPExcel->getActiveSheet()->setCellValue('Q2', 'Checked');
        $objPHPExcel->getActiveSheet()->getStyle("Q2")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->mergeCells('Q3:Q5');
        $objPHPExcel->getActiveSheet()->setCellValue('R2', 'Prepared');
        $objPHPExcel->getActiveSheet()->getStyle("R2")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->mergeCells('R3:R5');
        
        $objPHPExcel->getActiveSheet()->setCellValue('O6', 'Manager');
        $objPHPExcel->getActiveSheet()->getStyle("O6")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('P6', 'Koordinator');
        $objPHPExcel->getActiveSheet()->getStyle("P6")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('Q6', 'Supervisor');
        $objPHPExcel->getActiveSheet()->getStyle("Q6")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('R6', 'JP');
        $objPHPExcel->getActiveSheet()->getStyle("R6")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                
        //Body TR     
        $objPHPExcel->getActiveSheet()->setCellValue('A7', 'CUSTOMER NAME :');
        $objPHPExcel->getActiveSheet()->mergeCells('A7:B7');
        $objPHPExcel->getActiveSheet()->mergeCells('C7:E7');
        $objPHPExcel->getActiveSheet()->setCellValue('C7', $detail_tr->CHR_REQUESTOR);
        $objPHPExcel->getActiveSheet()->setCellValue('A8', 'Part No :');
        $objPHPExcel->getActiveSheet()->mergeCells('B8:C8');
        $objPHPExcel->getActiveSheet()->setCellValue('B8', $detail_tr->CHR_PART_NO);
        $objPHPExcel->getActiveSheet()->setCellValue('A9', 'Part Name :');
        $objPHPExcel->getActiveSheet()->mergeCells('B9:E9');
        $objPHPExcel->getActiveSheet()->setCellValue('B9', $detail_tr->CHR_PART_NAME);
        $objPHPExcel->getActiveSheet()->setCellValue('A10', 'Class Problem :');
        $objPHPExcel->getActiveSheet()->mergeCells('B10:E10');
        $objPHPExcel->getActiveSheet()->setCellValue('B10', $detail_tr->CHR_CLASS_PROBLEM);
        $objPHPExcel->getActiveSheet()->setCellValue('A11', '1. Detail of Problem');
        $objPHPExcel->getActiveSheet()->mergeCells('A11:E11');
        $objPHPExcel->getActiveSheet()->mergeCells('A12:E20');       
        
        $objDrawing = new PHPExcel_Worksheet_Drawing();
        $objDrawing->setName('Image NG');
        $objDrawing->setDescription('Image NG');
        $objDrawing->setPath($detail_tr->CHR_FILENAME);
        $objDrawing->setOffsetX(8);
        $objDrawing->setOffsetY(70);
        $objDrawing->setCoordinates('A12');
        $objDrawing->setHeight(130);
        $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
        
        $objPHPExcel->getActiveSheet()->setCellValue('A21', $detail_tr->CHR_QPROBLEM_DESC);
        $objPHPExcel->getActiveSheet()->mergeCells('A21:E23');
        $objPHPExcel->getActiveSheet()->getStyle("A21")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
        $objPHPExcel->getActiveSheet()->getStyle("A21")->getAlignment()->setWrapText(true);
        
        $objPHPExcel->getActiveSheet()->setCellValue('A24', '2. Flow Process'); 
        $objPHPExcel->getActiveSheet()->mergeCells('A24:E24');
        $objPHPExcel->getActiveSheet()->mergeCells('A25:E36');
        
        $objPHPExcel->getActiveSheet()->setCellValue('A37', 'Notification : The Report must be follow up by incharge and sent in 2/3 days after received with supported data for preventive and corrective action');
        $objPHPExcel->getActiveSheet()->mergeCells('A37:M37');
        
        $objPHPExcel->getActiveSheet()->setCellValue('N37', 'Copy   1.Related Dept   2.Customer   3.File QA');
        $objPHPExcel->getActiveSheet()->mergeCells('N37:R37');
        $objPHPExcel->getActiveSheet()->getStyle("N37")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        
        $objPHPExcel->getActiveSheet()->setCellValue('D8', 'Model :'); 
        
        $objPHPExcel->getActiveSheet()->setCellValue('F8', 'Problem :');
        $objPHPExcel->getActiveSheet()->mergeCells('F8:F10');
        $objPHPExcel->getActiveSheet()->getStyle("F8")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
        $objPHPExcel->getActiveSheet()->setCellValue('G8', $detail_tr->CHR_QPROBLEM_TITLE);        
        $objPHPExcel->getActiveSheet()->mergeCells('G8:M10');
        $objPHPExcel->getActiveSheet()->getStyle('G8')->getFont()->setBold(true)->setSize(16);
        $objPHPExcel->getActiveSheet()->getStyle("G8")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("G8")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        
        // ----- 4M ANAYLISIS - OCCURENCE ----- //
        $objPHPExcel->getActiveSheet()->setCellValue('F11', '3. 4M Analysis (Occurence Cause Problem)');
        $objPHPExcel->getActiveSheet()->mergeCells('F11:K11');
        $objPHPExcel->getActiveSheet()->setCellValue('G12', 'Why');
        $objPHPExcel->getActiveSheet()->mergeCells('G12:K12');
        $objPHPExcel->getActiveSheet()->getStyle("G12")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        $objPHPExcel->getActiveSheet()->setCellValue('F13', 'Machine');
        $objPHPExcel->getActiveSheet()->mergeCells('F13:F14');        
        $objPHPExcel->getActiveSheet()->getStyle("F13")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('F15', 'Methode');
        $objPHPExcel->getActiveSheet()->mergeCells('F15:F16');
        $objPHPExcel->getActiveSheet()->getStyle("F15")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('F17', 'Man');
        $objPHPExcel->getActiveSheet()->mergeCells('F17:F18');
        $objPHPExcel->getActiveSheet()->getStyle("F17")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('F19', 'Material');
        $objPHPExcel->getActiveSheet()->mergeCells('F19:F20');
        $objPHPExcel->getActiveSheet()->getStyle("F19")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        
        // ----- 4M ANAYLISIS - FLOW OUT ----- //
        $objPHPExcel->getActiveSheet()->setCellValue('F21', 'Flow Out Cause Problem');
        $objPHPExcel->getActiveSheet()->mergeCells('F21:K21');
        $objPHPExcel->getActiveSheet()->setCellValue('G22', 'Why');
        $objPHPExcel->getActiveSheet()->mergeCells('G22:K22');
        $objPHPExcel->getActiveSheet()->getStyle("G22")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        $objPHPExcel->getActiveSheet()->setCellValue('F23', 'Machine');
        $objPHPExcel->getActiveSheet()->mergeCells('F23:F24');  
        $objPHPExcel->getActiveSheet()->getStyle("F23")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('F25', 'Methode');
        $objPHPExcel->getActiveSheet()->mergeCells('F25:F26');
        $objPHPExcel->getActiveSheet()->getStyle("F25")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('F27', 'Man');
        $objPHPExcel->getActiveSheet()->mergeCells('F27:F28');
        $objPHPExcel->getActiveSheet()->getStyle("F27")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('F29', 'Material');
        $objPHPExcel->getActiveSheet()->mergeCells('F29:F30');
        $objPHPExcel->getActiveSheet()->getStyle("F29")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        
        $objPHPExcel->getActiveSheet()->mergeCells('G13:K14');
        $objPHPExcel->getActiveSheet()->setCellValue('G13', $machine_fix);
        $objPHPExcel->getActiveSheet()->getStyle("G13")->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->mergeCells('G15:K16');
        $objPHPExcel->getActiveSheet()->setCellValue('G15', $methode_fix);
        $objPHPExcel->getActiveSheet()->getStyle("G15")->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->mergeCells('G17:K18');
        $objPHPExcel->getActiveSheet()->setCellValue('G17', $man_fix);
        $objPHPExcel->getActiveSheet()->getStyle("G17")->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->mergeCells('G19:K20');
        $objPHPExcel->getActiveSheet()->setCellValue('G19', $material_fix);
        $objPHPExcel->getActiveSheet()->getStyle("G19")->getAlignment()->setWrapText(true);
        
        $objPHPExcel->getActiveSheet()->mergeCells('G23:K24');
        $objPHPExcel->getActiveSheet()->setCellValue('G23', $machine_temp);
        $objPHPExcel->getActiveSheet()->getStyle("G23")->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->mergeCells('G25:K26');
        $objPHPExcel->getActiveSheet()->setCellValue('G25', $methode_temp);
        $objPHPExcel->getActiveSheet()->getStyle("G25")->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->mergeCells('G27:K28');
        $objPHPExcel->getActiveSheet()->setCellValue('G27', $man_temp);
        $objPHPExcel->getActiveSheet()->getStyle("G27")->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->mergeCells('G29:K30');
        $objPHPExcel->getActiveSheet()->setCellValue('G29', $material_temp);
        $objPHPExcel->getActiveSheet()->getStyle("G29")->getAlignment()->setWrapText(true);
        
        $objPHPExcel->getActiveSheet()->setCellValue('F31', '4. Temporary Action');
        $objPHPExcel->getActiveSheet()->mergeCells('F31:I31');
        $objPHPExcel->getActiveSheet()->mergeCells('F32:I36');
        $objPHPExcel->getActiveSheet()->setCellValue('F32', $action);
        $objPHPExcel->getActiveSheet()->getStyle("F32")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
        $objPHPExcel->getActiveSheet()->getStyle("F32")->getAlignment()->setWrapText(true);
        
        $objPHPExcel->getActiveSheet()->setCellValue('J31', 'PIC');
        $objPHPExcel->getActiveSheet()->mergeCells('J32:J36');
        $objPHPExcel->getActiveSheet()->getStyle("J31")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        $objPHPExcel->getActiveSheet()->setCellValue('K31', 'Due Date');
        $objPHPExcel->getActiveSheet()->mergeCells('K32:K36');
        $objPHPExcel->getActiveSheet()->getStyle("K31")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        $objPHPExcel->getActiveSheet()->setCellValue('L11', '5. Permanent Action');
        $objPHPExcel->getActiveSheet()->mergeCells('L11:R11');
        $objPHPExcel->getActiveSheet()->setCellValue('L12', 'Problem');
        $objPHPExcel->getActiveSheet()->mergeCells('L12:M12');
        $objPHPExcel->getActiveSheet()->mergeCells('L13:M20');
        $objPHPExcel->getActiveSheet()->setCellValue('N12', 'Improvement');
        $objPHPExcel->getActiveSheet()->mergeCells('N12:P12');
        $objPHPExcel->getActiveSheet()->mergeCells('N13:P20');
        $objPHPExcel->getActiveSheet()->setCellValue('Q12', 'PIC');
        $objPHPExcel->getActiveSheet()->mergeCells('Q13:Q20');
        $objPHPExcel->getActiveSheet()->getStyle("Q12")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('R12', 'Due Date');
        $objPHPExcel->getActiveSheet()->mergeCells('R13:R20');
        $objPHPExcel->getActiveSheet()->getStyle("R12")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        $objPHPExcel->getActiveSheet()->setCellValue('L21', '6. Evidence Improvement Activity');
        $objPHPExcel->getActiveSheet()->mergeCells('L21:R21');
        $objPHPExcel->getActiveSheet()->mergeCells('L22:R27');
        
        $objPHPExcel->getActiveSheet()->mergeCells('L28:O32');
        
        $objPHPExcel->getActiveSheet()->setCellValue('N7', 'Register No :');
        $objPHPExcel->getActiveSheet()->mergeCells('O7:P7');
        $objPHPExcel->getActiveSheet()->setCellValue('O7', $detail_tr->CHR_TR_NO);
        $objPHPExcel->getActiveSheet()->setCellValue('N8', 'Defective Date :');
        $objPHPExcel->getActiveSheet()->mergeCells('O8:P8');
        $objPHPExcel->getActiveSheet()->setCellValue('O8', $detail_tr->CHR_START_DATE);
        $objPHPExcel->getActiveSheet()->setCellValue('N9', 'Accepted Date :');
        $objPHPExcel->getActiveSheet()->mergeCells('O9:P9');
        $objPHPExcel->getActiveSheet()->setCellValue('O9', $detail_tr->CHR_CREATED_DATE);
        $objPHPExcel->getActiveSheet()->setCellValue('N10', 'PS No :');
        $objPHPExcel->getActiveSheet()->mergeCells('O10:P10');
        
        $objPHPExcel->getActiveSheet()->setCellValue('Q7', 'Defect Qty');
        $objPHPExcel->getActiveSheet()->getStyle("Q7")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->mergeCells('Q7:R7');
        $objPHPExcel->getActiveSheet()->mergeCells('Q8:Q10');
        $objPHPExcel->getActiveSheet()->setCellValue('Q8', $detail_tr->INT_QTY);
        $objPHPExcel->getActiveSheet()->getStyle("Q8")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("Q8")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->mergeCells('R8:R10');
        $objPHPExcel->getActiveSheet()->setCellValue('R8', $detail_tr->CHR_UNIT_TYPE);
        $objPHPExcel->getActiveSheet()->getStyle("R8")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("R8")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        
        // ---- APPROVAL ---- //
        $objPHPExcel->getActiveSheet()->setCellValue('P28', 'Approved');
        $objPHPExcel->getActiveSheet()->mergeCells('P29:P31');
        $objPHPExcel->getActiveSheet()->getStyle("P28")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('Q28', 'Checked');
        $objPHPExcel->getActiveSheet()->mergeCells('Q29:Q31');
        $objPHPExcel->getActiveSheet()->getStyle("Q28")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('R28', 'Prepared');
        $objPHPExcel->getActiveSheet()->mergeCells('R29:R31');
        $objPHPExcel->getActiveSheet()->getStyle("R28")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        $objPHPExcel->getActiveSheet()->setCellValue('L33', 'Note :');
        $objPHPExcel->getActiveSheet()->mergeCells('L33:R33');
        $objPHPExcel->getActiveSheet()->setCellValue('L34', 'Status of Claim :');
        $objPHPExcel->getActiveSheet()->mergeCells('L34:M36');
        $objPHPExcel->getActiveSheet()->getStyle("L34")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        
        $objPHPExcel->getActiveSheet()->setCellValue('N34', 'Accepted');
        $objPHPExcel->getActiveSheet()->mergeCells('N34:O36');
        $objPHPExcel->getActiveSheet()->getStyle("N34")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("N34")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('N34')->getFont()->setBold(true)->setSize(18);
        
        $objPHPExcel->getActiveSheet()->setCellValue('P34', 'Delivery After Improvement');
        $objPHPExcel->getActiveSheet()->mergeCells('P34:R34');
        $objPHPExcel->getActiveSheet()->setCellValue('P35', 'Date :');
        $objPHPExcel->getActiveSheet()->setCellValue('P36', 'Lot Code :');
        $objPHPExcel->getActiveSheet()->mergeCells('Q35:R35');
        $objPHPExcel->getActiveSheet()->mergeCells('Q36:R36');
        
        $objPHPExcel->getActiveSheet()->getStyle('F1')->getFont()->setBold(true)->setSize(20);
        
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(18);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(2);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(18);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(18);
        $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(15);
            
        $styleArray = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_DASHED,
                ),
            ),
        );
        
        $styleArray2 = array(
            'borders' => array(
                'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THICK,
                ),
            ),
        );
        
        $objPHPExcel->getActiveSheet()->getStyle("A1:R37")->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->getStyle("A1:R37")->applyFromArray($styleArray2);
        
        $filename = "Technical Report.xls";
        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . trim($filename) . '"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->setIncludeCharts(TRUE);
        $objWriter->save('php://output');
    }
    
    function export_list_tr($date){
        $user_session = $this->session->all_userdata();
        $role = $user_session['ROLE'];
        $row = 7;
        
        $this->load->library('excel');
        $objReader = PHPExcel_IOFactory::createReader('Excel5');
        
        $objPHPExcel = $objReader->load("assets/template/qis/Template List TR.xls");
        $objPHPExcel->getActiveSheet()->setCellValue("B2", "LIST TECHNICAL REPORT (TR) PERIODE : " . strtoupper(date("F", mktime(null, null, null, substr($date, 4, 2)))). ' ' . substr($date,0,4));
        
        $list_tr = $this->quality_problem_m->get_quality_problem($date);
        $no = 1;
        foreach ($list_tr as $tr) {
            $repeat = 'NO';
            if($tr->INT_FLG_REPEAT == 1){
                $repeat = 'YES';
            }
            
            $status = 'NO FOLLOW UP';
            if($tr->INT_STATUS == '1'){
                $status = 'TEMPORARY ACT';
            } else if($tr->INT_STATUS == '2'){
                $status = 'FIXED ACT';
            } else if($tr->INT_STATUS == '3'){
                $status = 'CLOSED';
            }
            
            $objPHPExcel->getActiveSheet()->setCellValue("B$row", "$no");
            $objPHPExcel->getActiveSheet()->setCellValue("C$row", $tr->CHR_TR_NO);
            $objPHPExcel->getActiveSheet()->setCellValue("D$row", $tr->CHR_QPROBLEM_TITLE);
            $objPHPExcel->getActiveSheet()->setCellValue("E$row", $tr->CHR_CLASS_PROBLEM);
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $tr->CHR_QPROBLEM_DESC);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $tr->CHR_BACK_NO);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $tr->CHR_PART_NO);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $tr->CHR_PART_NAME);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $tr->INT_QTY);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", strtoupper($tr->CHR_REQUESTOR));
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $tr->CHR_SECTION_REQ . " / " . $tr->CHR_SECTION_REQ_DESC);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", strtoupper($tr->CHR_PIC));
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $tr->CHR_SECTION_PIC . " / " . $tr->CHR_SECTION_PIC_DESC);
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", substr($tr->CHR_START_DATE,6,2) . "/" . substr($tr->CHR_START_DATE,4,2) . "/" . substr($tr->CHR_START_DATE,0,4));
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", substr($tr->CHR_START_TIME,0,2) . ":" . substr($tr->CHR_START_TIME,2,2) . ":" . substr($tr->CHR_START_TIME,4,2));
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", substr($tr->CHR_DUE_DATE,6,2) . "/" . substr($tr->CHR_DUE_DATE,4,2) . "/" . substr($tr->CHR_DUE_DATE,0,4));
            $objPHPExcel->getActiveSheet()->setCellValue("R$row", substr($tr->CHR_DUE_TIME,0,2) . ":" . substr($tr->CHR_DUE_TIME,2,2) . ":" . substr($tr->CHR_DUE_TIME,4,2));
            $objPHPExcel->getActiveSheet()->setCellValue("S$row", $repeat);
            $objPHPExcel->getActiveSheet()->setCellValue("T$row", $status);

            $no++;
            $row++;
        }
            
        $objPHPExcel->getActiveSheet()->getStyle("B7:T$row")->applyFromArray(array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        ));
        
        ob_end_clean();
        $filename = "List Technical Report - $date.xls";
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . trim($filename) . '"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->setIncludeCharts(TRUE);
        $objWriter->save('php://output');
    }

}
