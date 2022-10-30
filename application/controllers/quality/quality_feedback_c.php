<?php

class quality_feedback_c extends CI_Controller {

    private $layout = '/template/head';
    private $back_to_manage = 'quality/quality_feedback_c/index/';
    private $home = '/basis/home_c';

    public function __construct() {
        parent::__construct();
        $this->load->model('quality/quality_feedback_m');
        $this->load->model('quality/quality_problem_m');
    }

    //show all data
    function index($periode = NULL, $msg = NULL) {
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
        
        if($periode == NULL || $periode == ''){
            $periode = date("Ym");
        } else {
            $periode = $periode;
        }

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(168);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Manage Problem Quality';
        $data['msg'] = $msg;
        $data['date_selected'] = $periode;

        $data['data'] = $this->quality_problem_m->get_quality_problem($periode);
        $data['content'] = 'quality/feedback_problem/manage_feedback_v';
        $this->load->view($this->layout, $data);
    }

    //view by id
    function select_quality_problem_by_id($id, $msg = null) {
        $this->role_module_m->authorization('168');
        $session = $this->session->all_userdata();

        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Creating success </strong> The data is successfully created </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Updating success </strong> The data is successfully updated </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Deleted success </strong> The data is successfully deleted </div >";
        } elseif ($msg == 12) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Executing error !</strong> Something error with parameter </div >";
        }
        
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(168);
        $data['news'] = $this->news_m->get_news();
        $data['msg'] = $msg;
        $data['user_logon'] = $session['NPK'];
        $data['user_idsect'] = $session['SECTION'];
        
        $data_detail = $this->quality_problem_m->get_quality_problem_by_id($id);
        $data['user_respon'] = $this->quality_problem_m->get_user_responsibility($data_detail->INT_ID_SECTION_PIC);
        $data['match_user_respon'] = $this->quality_problem_m->get_user_responsibility_by_npk($data_detail->INT_ID_SECTION_PIC, $data['user_logon']);
        $id_parent = $data_detail->INT_ID_PARENT;
        $id_child = $data_detail->INT_ID_CHILD;
        $first_child = $id_child + 1;
        $data['num_child'] = $this->quality_problem_m->get_num_child_tr($id_parent,$first_child);
        
//        print_r($data['match_user_respon']);
//        exit();
        
        $data['data_detail'] = $data_detail;
        $data['data_parent'] = $this->quality_problem_m->get_data_parent($id_parent, $id_child);
        $data['data_related_tr'] = $this->quality_problem_m->get_related_tr($id, $id_parent);
//        
//        print_r($data_detail->CHR_START_DATE);
//        exit();
        
        $data['data_feedback'] = $this->quality_feedback_m->get_data_by_id($id)->result();
        $data['content'] = 'quality/feedback_problem/view_feedback_v';
        $data['title'] = 'View Feedback Problem';
        $this->load->view($this->layout, $data);
    }
    
    //view by id
    function view_detail_feedback($id, $id_problem) {
        $this->role_module_m->authorization('168');
        $session = $this->session->all_userdata();
        
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(168);
        $data['news'] = $this->news_m->get_news();
        $data['user_logon'] = $session['NPK'];
        $data['user_idsect'] = $session['SECTION'];        
        
        $data['data_feedback'] = $this->quality_feedback_m->get_detail_feedback_by_id($id)->row();
        $data['content'] = 'quality/feedback_problem/view_detail_feedback_v';
        $data['title'] = 'View Feedback Problem';
        $this->load->view($this->layout, $data);
    }

    //prepare to create
    function give_feedback() {
        $this->role_module_m->authorization('168');
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['news'] = $this->news_m->get_news();
        $data['sidebar'] = $this->role_module_m->side_bar(168);
        
        $data['title'] = 'Feedback Problem Report';
        $data['content'] = 'quality/reporting_problem/create_feedback_v';
        $this->load->view($this->layout, $data);
    }

    //saving data
    function send_feedback() {
        $this->load->library('upload');        
        $session = $this->session->all_userdata();
       
        $file_path = 'feed_' . trim($session['NPK']) . '_' . date("YmdHis");
        $action = $this->input->post('INT_ACTION_TYPE');
        $cause = $this->input->post('INT_CAUSE_PROBLEM');
        
        $this->form_validation->set_rules('CHR_FEEDBACK_DESC', 'Feedback', 'required|min_length[10]');
        if ($this->form_validation->run() == FALSE) {
            $this->select_quality_problem_by_id($this->input->post('INT_ID_QPROBLEM'),12);
        } else {            
            if(empty($_FILES['CHR_FILEUPLOAD']['name'])){                
                $data = array(
                    'INT_ID_QPROBLEM' => $this->input->post('INT_ID_QPROBLEM'),
                    'CHR_FEEDBACK_DESC' => $this->input->post('CHR_FEEDBACK_DESC'),
                    'INT_STATUS_FEEDBACK' => 1,
                    'INT_ACTION_TYPE' => $action,
                    'CHR_CREATED_BY' => $session['NPK'],
                    'INT_CAUSE_PROBLEM' => $cause,
                    'CHR_MAN_ANALYSIS' => $this->input->post('CHR_MAN_ANALYSIS'),
                    'CHR_MATERIAL_ANALYSIS' => $this->input->post('CHR_MATERIAL_ANALYSIS'),
                    'CHR_MACHINE_ANALYSIS' => $this->input->post('CHR_MACHINE_ANALYSIS'),
                    'CHR_METHODE_ANALYSIS' => $this->input->post('CHR_METHODE_ANALYSIS')
                );
                $this->quality_feedback_m->save($data);
            
                $data_problem = array(
                        'INT_STATUS' => $action,
                        'CHR_FINISH_DATE' => date('Ymd'),
                        'CHR_FINISH_TIME' => date('His')
                    );
                
                $this->quality_problem_m->update($data_problem, $this->input->post('INT_ID_QPROBLEM'), $cause);
                                        
                redirect('quality/quality_feedback_c/select_quality_problem_by_id/' . $this->input->post('INT_ID_QPROBLEM'). '/' .$msg = 1);
            } else {  
                $config['upload_path'] = "assets/file/qis_feedback/";
                $config['allowed_types'] = 'JPEG|jpg|png|gif|doc|docx|xlxs|xls|pdf';
                $config['file_name'] = $file_path;
                $config['max_size'] = 1500;

                $ext = end((explode(".", $_FILES['CHR_FILEUPLOAD']['name'])));
            
                $this->upload->initialize($config);
                if (!$this->upload->do_upload('CHR_FILEUPLOAD')) {
                    $error = array('error' => $this->upload->display_errors());
                    print_r($error);
                    exit();
                } else {
                    $success = array('upload_data' => $this->upload->data());

                    $data = array(
                        'INT_ID_QPROBLEM' => $this->input->post('INT_ID_QPROBLEM'),
                        'CHR_FEEDBACK_DESC' => $this->input->post('CHR_FEEDBACK_DESC'),
                        'INT_STATUS_FEEDBACK' => 1,
                        'INT_ACTION_TYPE' => $action,
                        'CHR_CREATED_BY' => $session['NPK'],
                        'INT_CAUSE_PROBLEM' => $cause,
                        'CHR_MAN_ANALYSIS' => $this->input->post('CHR_MAN_ANALYSIS'),
                        'CHR_MATERIAL_ANALYSIS' => $this->input->post('CHR_MATERIAL_ANALYSIS'),
                        'CHR_MACHINE_ANALYSIS' => $this->input->post('CHR_MACHINE_ANALYSIS'),
                        'CHR_METHODE_ANALYSIS' => $this->input->post('CHR_METHODE_ANALYSIS'),
                        'CHR_FILEUPLOAD' => $file_path . '.' .$ext
                    );
                    $this->quality_feedback_m->save($data);

                    $data_problem = array(
                        'INT_STATUS' => $action,
                        'CHR_FINISH_DATE' => date('Ymd'),
                        'CHR_FINISH_TIME' => date('His')
                    );
                    $this->quality_problem_m->update($data_problem, $this->input->post('INT_ID_QPROBLEM'), $cause);

                    redirect('quality/quality_feedback_c/select_quality_problem_by_id/' . $this->input->post('INT_ID_QPROBLEM'). '/' .$msg = 1);
                }
            }
        }
    }
    
    //prepare to editing
    function edit_quality_problem($id) {
		
        $this->role_module_m->authorization('168');
        $data['data'] = $this->quality_feedback_m->get_data($id)->row();
        $data['content'] = 'quality/edit_quality_v';
        $data['data_subsection'] = $this->subsection_m->get_subsection();
        $data['data_section'] = $this->section_m->get_section();
        $data['data_dept'] = $this->dept_m->get_dept();
        $data['data_groupdept'] = $this->groupdept_m->get_groupdept();
        $data['data_division'] = $this->division_m->get_division();
        $data['data_company'] = $this->company_m->get_company();
        $data['data_role'] = $this->role_m->select_role();

        $data['app'] = $this->role_module_m->get_app();
        $data['news'] = $this->news_m->get_news();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(168);

        $data['title'] = 'Edit User';
		
        $this->load->view($this->layout, $data);
		
    }

    //updating data
    function update_quality_problem() {
        $id = $this->input->post('CHR_NPK');
        $date = $this->input->post('CHR_REGIS_DATE');

        $this->form_validation->set_rules('CHR_USERNAME', 'Username', 'required');
        $this->form_validation->set_rules('CHR_PASS', 'Password', 'required|min_length[7]|trim');
        $this->form_validation->set_rules('CHR_PASS_CONFIRM', 'Password Confirm', 'required|matches[CHR_PASS]|callback_password_check');
        $session = $this->session->all_userdata();
        $code_pass = trim(md5($this->input->post('CHR_PASS') . $date));

        if ($this->form_validation->run() == FALSE) {
            $this->edit_user($id);
        } else {
            $data = array(
                'INT_ID_QPROBLEM' => $this->input->post('INT_ID_QPROBLEM'),
                'CHR_FEEDBACK_DESC' => $this->input->post('CHR_FEEDBACK_DESC')
            );
            $this->quality_feedback_m->update($data, $id);
            $this->log_m->add_log('55', $id);
            redirect($this->back_to_manage . $msg = 2);
        }
    }

    //deleting data
    function delete_feedback_problem($id, $id_master) {
        $this->quality_feedback_m->delete($id);
        redirect('quality/quality_feedback_c/select_quality_problem_by_id/' .$id_master. '/' .$msg = 3);
    }
    
    function solved($id, $id_master){
        $this->quality_feedback_m->solved($id);
        $this->quality_problem_m->is_complete($id_master);
        redirect('quality/quality_problem_c/select_quality_problem_by_id/' .$id_master. '/' .$msg = 2);
    }
    
    function not_solved($id, $id_master){
        $this->quality_feedback_m->not_solved($id);
        redirect('quality/quality_problem_c/select_quality_problem_by_id/' .$id_master. '/' .$msg = 2);
    }
    
    function close_problem($id){
        $this->quality_feedback_m->close_problem($id);
        redirect('quality/quality_feedback_c/select_quality_problem_by_id/' .$id);
    }
    
    function download_evidence($id){
        $this->load->helper('download');
        $file_name = $this->quality_feedback_m->get_detail_feedback_by_id($id)->row()->CHR_FILEUPLOAD;
        
        $data = file_get_contents(base_url('/assets/file/qis_feedback/'.$file_name));
        ob_clean(); 
        force_download($file_name, $data);
    }
    
    //Update 11/09/2017
    function download_template_cm($id) {
        $this->load->helper('download');
        
        ob_clean();
        $name = 'Template CM.xls';
        $data = file_get_contents("assets/template/qis/Template CM.xls");

        force_download($name, $data);
    }
    
}
