<?php

class helpdesk_ticket_c extends CI_Controller {

    private $layout = '/template/head';
    private $back_to_manage = 'helpdesk_ticket/helpdesk_ticket_c/index/';
    private $back_to_approve = 'helpdesk_ticket/helpdesk_ticket_c/prepare_approve_ticket/';
    public $id_app = '8';
    public $id_module = '13';
    public $id_function = '33';

    public function __construct() {
        parent::__construct();
        $this->load->model('helpdesk_ticket/helpdesk_ticket_m');
        $this->load->model('helpdesk_ticket/problem_type_m');
        $this->load->model('helpdesk_ticket/prover_m');
        $this->load->model('basis/user_m');
    }

    function index($msg = NULL) {
        $this->role_module_m->authorization($this->id_function);
        
        $this->load->model('portal/notification_m');
        $session = $this->session->all_userdata();

        //notif was read
        $this->notification_m->has_be_read_by_npk_and_function($session['NPK'],$this->id_function );

        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Creating success </strong> The data is successfully created </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Updating success </strong> The data is successfully updated </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Deleted success </strong> The data is successfully deleted </div >";
        } elseif ($msg == 4) {
            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Choosing failed </strong> You must select at least one data</div >";
        } elseif ($msg == 12) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Executing error !</strong> Something error with parameter </div >";
        }

        if ($session['ROLE'] == '1' || $session['ROLE'] == '38' || $session['ROLE'] == 7) {
            $data_content = 'helpdesk_ticket/helpdesk_ticket/manage_helpdesk_ticket_v';
            $content = $this->helpdesk_ticket_m->get_helpdesk_ticket_by_admin();
        } else {
            $data_content = 'helpdesk_ticket/helpdesk_ticket/manage_helpdesk_ticket_by_staff_v';
            $content = $this->helpdesk_ticket_m->get_helpdesk_ticket_by_staff($session['NPK']);
        }
        
        $data['msg'] = $msg;
        $data['data'] = $content;
        $data['content'] = $data_content;
        $data['title'] = 'Manage Helpdesk Ticket';
        $data['npk'] = $session['NPK'];
        $data['app'] = $this->role_module_m->get_app();
        $data['news'] = $this->news_m->get_news();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(33);
        $data['news'] = $this->news_m->get_news();

        $this->load->view($this->layout, $data);
    }

    function select_by_status($status, $msg = NULL) {
        $this->role_module_m->authorization($this->id_function);

        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Creating success </strong> The data is successfully created </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Updating success </strong> The data is successfully updated </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Deleted success </strong> The data is successfully deleted </div >";
        } elseif ($msg == 4) {
            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Choosing failed </strong> You must select at least one data</div >";
        } elseif ($msg == 12) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Executing error !</strong> Something error with parameter </div >";
        }

        $data['data'] = $this->helpdesk_ticket_m->get_helpdesk_ticket_by_status($status);

        $session = $this->session->all_userdata();
        if ($session['ROLE'] == '1' || $session['ROLE'] == '38' || $session['ROLE'] == 7) {
            $data['content'] = 'helpdesk_ticket/helpdesk_ticket/manage_helpdesk_ticket_v';
        } else {
            $data['content'] = 'helpdesk_ticket/helpdesk_ticket/manage_helpdesk_ticket_by_staff_v';
        }

        $data['npk'] = $session['NPK'];
        $data['title'] = 'Manage Helpdesk Ticket';
        $data['msg'] = $msg;
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(33);
        $data['news'] = $this->news_m->get_news();

        $this->load->view($this->layout, $data);
    }

    function select_by_status_and_npk($status, $npk, $msg = NULL) {
        $this->role_module_m->authorization($this->id_function);

        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Creating success </strong> The data is successfully created </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Updating success </strong> The data is successfully updated </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Deleted success </strong> The data is successfully deleted </div >";
        } elseif ($msg == 4) {
            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Choosing failed </strong> You must select at least one data</div >";
        } elseif ($msg == 12) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Executing error !</strong> Something error with parameter </div >";
        }

        $data['msg'] = $msg;
        $session = $this->session->all_userdata();
        if ($session['ROLE'] == '1' || $session['ROLE'] == '38' || $session['ROLE'] == 7) {
            $data['in_queue'] = $this->helpdesk_ticket_m->get_fifo();
        } else {
            $data['in_queue'] = NULL;
        }
        $data['sort'] = NULL;
        $data['type'] = NULL;
        $data['data'] = $this->helpdesk_ticket_m->get_helpdesk_ticket_by_status_and_npk($status, $npk);
        $data['content'] = 'helpdesk_ticket/helpdesk_ticket/manage_helpdesk_ticket_by_staff_v';
        $data['title'] = 'Manage Helpdesk Ticket';

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(33);
        $data['news'] = $this->news_m->get_news();

        $this->load->view($this->layout, $data);
    }

    function prepare_approve_ticket($msg = NULL) {
        $this->role_module_m->authorization('38');

        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Approve success </strong> The data is successfully approved </div >";
        } elseif ($msg == 4) {
            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Choosing failed </strong> You must select at least one data</div >";
        } elseif ($msg == 5) {
            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Reject Ticket success </strong> The data is successfully rejected</div >";
        } else {
            $msg = "";
        }
        $session = $this->session->all_userdata();
        if ($session['ROLE'] == '1' || $session['ROLE'] == '38' || $session['ROLE'] == 7) {
            $data['in_queue'] = $this->helpdesk_ticket_m->get_fifo();
        } else {
            $data['in_queue'] = NULL;
        }
        $data['to_approve'] = $this->helpdesk_ticket_m->get_num_to_approve(($session['DEPT']));
        $data['msg'] = $msg;
        $data['data'] = $this->helpdesk_ticket_m->get_helpdesk_ticket_by_id_dept($session['DEPT']);
        $data['content'] = 'helpdesk_ticket/helpdesk_ticket/approve_helpdesk_ticket_v';
        $data['title'] = 'Approval Helpdesk Ticket';

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(38);
        $data['news'] = $this->news_m->get_news();

        $this->load->view($this->layout, $data);
    }

    function reject_helpdesk_ticket() {
        $session = $this->session->all_userdata();

        $data = array(
            'INT_STATUS' => 4,
            'CHR_REJECT_DESC' => $this->input->post('CHR_REJECT_DESC'),
            'CHR_MODI_BY' => $session['USERNAME'],
            'CHR_MODI_DATE' => date('Ymd'),
            'CHR_MODI_TIME' => date('His')
        );

        $this->db->trans_start();
        $this->helpdesk_ticket_m->update_helpdesk_ticket($data, $this->input->post('INT_ID_TICKET'));
        //$this->log_m->add_log('100', $this->input->post('INT_ID_TICKET'));
        $this->db->trans_complete();

        redirect($this->back_to_approve . 5);
    }

//    function approve_helpdesk_ticket() {
//        $checked = $this->input->post('case');
//        $id_ticket = null;
//        if ($checked == null) {
//            redirect($this->back_to_approve . 4);
//        }
//
//        $session = $this->session->all_userdata();
//        $data = array(
//            'INT_STATUS' => 1,
//            'CHR_MODI_BY' => $session['USERNAME'],
//            'CHR_MODI_DATE' => date('Ymd'),
//            'CHR_MODI_TIME' => date('His')
//        );
//
//        $this->db->trans_start();
//        for ($i = 0; $i < count($checked); $i++) {
//            $this->helpdesk_ticket_m->update_helpdesk_ticket($data, $checked[$i]);
//            if ($id_ticket == NULL) {
//                $id_ticket = $checked[$i];
//            } else {
//                $id_ticket = $id_ticket . ',' . $checked[$i];
//            }
//        }
//        $this->log_m->add_log('99', $id_ticket);
//        $this->db->trans_complete();
//        redirect($this->back_to_approve . 1);
//    }

    function approve_ticket($id_ticket) {
        $data = array(
            'INT_STATUS' => 1
        );

        $this->helpdesk_ticket_m->update_helpdesk_ticket($data, $id_ticket);
        redirect('helpdesk_ticket/helpdesk_ticket_c/prepare_to_feedback_helpdesk_ticket/' . $id_ticket);
    }

    function add_reject_desc() {
        $data = array(
            'CHR_REJECT_DESC' => $this->input->post('CHR_REJECT_DESC'),
            'INT_STATUS' => 4
        );
        $this->helpdesk_ticket_m->update_helpdesk_ticket($data, $this->input->post('INT_ID_TICKET'));
        redirect('helpdesk_ticket/helpdesk_ticket_c/prepare_to_feedback_helpdesk_ticket/' . $this->input->post('INT_ID_TICKET'));
    }

    function view_detail_helpdesk_ticket($id_ticket) {
        $this->role_module_m->authorization($this->id_function);
        $this->load->model('helpdesk_ticket/progress_desc_m');

        $data['data'] = $this->helpdesk_ticket_m->get_data_helpdesk_ticket($id_ticket)->row();
        $data['data_progress'] = $this->progress_desc_m->get_data_progress_desc_by_ticket($id_ticket);

        $data['content'] = 'helpdesk_ticket/helpdesk_ticket/view_helpdesk_ticket_by_staff_v';
        $data['title'] = 'View Helpdesk Ticket';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(33);
        $data['news'] = $this->news_m->get_news();

        $this->load->view($this->layout, $data);
    }

    function view_detail_helpdesk_ticket_for_approve($id_ticket) {
        $this->role_module_m->authorization($this->id_function);
        $this->load->model('helpdesk_ticket/progress_desc_m');

        $data['data'] = $this->helpdesk_ticket_m->get_data_helpdesk_ticket($id_ticket)->row();
        $data['data_progress'] = $this->progress_desc_m->get_data_progress_desc_by_ticket($id_ticket);

        $data['content'] = 'helpdesk_ticket/helpdesk_ticket/view_helpdesk_ticket_by_manager_v';
        $data['title'] = 'View Helpdesk Ticket';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(33);
        $data['news'] = $this->news_m->get_news();

        $this->load->view($this->layout, $data);
    }

    function prepare_to_feedback_helpdesk_ticket($id_ticket) {
        $this->role_module_m->authorization($this->id_function);
        $this->load->model('helpdesk_ticket/progress_desc_m');

        $data['data'] = $this->helpdesk_ticket_m->get_data_helpdesk_ticket($id_ticket)->row();
        $data['data_progress'] = $this->progress_desc_m->get_data_progress_desc_by_ticket($id_ticket);
        $data['count_progress'] = $this->progress_desc_m->get_count_progress_desc_by_ticket($id_ticket);

        $data['content'] = 'helpdesk_ticket/helpdesk_ticket/view_helpdesk_ticket_v';
        $data['title'] = 'View Helpdesk Ticket';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(33);
        $data['news'] = $this->news_m->get_news();

        $this->load->view($this->layout, $data);
    }

    function create_helpdesk_ticket() {
        $this->role_module_m->authorization($this->id_function);

        $data['content'] = 'helpdesk_ticket/helpdesk_ticket/create_helpdesk_ticket_v';
        $data['title'] = 'Create Helpdesk Ticket';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(33);
        $data['news'] = $this->news_m->get_news();
        $data['data_user'] = $this->user_m->get_user();

        $data['data_problem_type'] = $this->problem_type_m->get_problem_type();
        $data['data_prover'] = $this->prover_m->get_prover();
        $data['date'] = date('d-m-Y');

        $this->load->view($this->layout, $data);
    }

    function save_helpdesk_ticket() {
        $this->load->model('basis/user_m');
        $this->load->library('upload');

        $session = $this->session->all_userdata();

        $this->form_validation->set_rules('CHR_PROBLEM_TITLE', 'Problem Title', 'required|trim|min_length[5]|max_length[50]|');
        $this->form_validation->set_rules('CHR_ASSET_NAME', 'Asset name', 'required|trim|min_length[5]|max_length[50]|');

        if ($session['ROLE'] == 1 || $session['ROLE'] == 38 || $session['ROLE'] == 7) {
            $this->form_validation->set_rules('CHR_NPK', 'NPK', 'required|trim');
            $npk_user = $this->input->post('CHR_NPK');
            $dept_user = $this->user_m->get_dept_by_npk($this->input->post('CHR_NPK'));
            $prioritas = $this->input->post('INT_PRIORITY');
            $prover = $this->input->post('INT_ID_PROVER');
        } else {
            $npk_user = $session['NPK'];
            $dept_user = $session['DEPT'];
            $prioritas = 3;
            $prover = 1;
        }

        $duedate = date("Ymd", strtotime($this->input->post('CHR_DUE_DATE')));
        $id_ticket = $this->helpdesk_ticket_m->generate_id_helpdesk_ticket();

        $fileName = $_FILES['CHR_IMAGE_URL']['name'];

        if (empty($fileName)) {
            redirect($this->back_to_manage.$msg = 12);
        }

        if ($this->form_validation->run() == FALSE) {
            $this->create_helpdesk_ticket();
        } else {

            $config = array(
                'upload_path' => 'assets/img/helpdesk_ticket_image/',
                'allowed_types' => "gif|JPG|jpg|png|jpeg",
                'overwrite' => TRUE,
                'max_size' => "2048000"//,
                //'file_name' = $fileName;
                );

            //upload image
            $this->upload->initialize($config);
            if ($a = $this->upload->do_upload('CHR_IMAGE_URL'))
                $this->upload->display_errors();
            $media = $this->upload->data('CHR_IMAGE_URL');
            $inputFileName = $config['upload_path'] . $media['file_name'];

            $data = array(
                'INT_ID_TICKET' => $id_ticket,
                'CHR_PROBLEM_TITLE' => trim($this->input->post('CHR_PROBLEM_TITLE')),
                'CHR_PROBLEM_DESC' => trim($this->input->post('CHR_PROBLEM_DESC')),
                'CHR_NPK' => $npk_user,
                'INT_ID_DEPT' => $dept_user,
                'INT_ID_PROBLEM_TYPE' => $this->input->post('INT_ID_PROBLEM_TYPE'),
                'INT_ID_PROVER' => $prover,
                'CHR_ASSET_NAME' => $this->input->post('CHR_ASSET_NAME'),
                'CHR_IMAGE_URL' => $inputFileName,
                'INT_STATUS' => 0, //not approve
                'INT_PRIORITY' => $prioritas,
                'CHR_DUE_DATE' => $duedate,
                //'INT_APPROVE' => 0, //not approve
                'CHR_CREATE_BY' => $session['USERNAME'],
                'CHR_CREATE_DATE' => date("Ymd"),
                'CHR_CREATE_TIME' => date("His")
            );
            $this->db->trans_start();
            $this->helpdesk_ticket_m->save_helpdesk_ticket($data);
            //$this->log_m->add_log('84', $id_ticket);
            $this->db->trans_complete();

            $result = $this->prover_m->get_prover();
            foreach ($result as $row) {
                $seq_id = $this->notification_m->generate_id();

                $data_notif = array(
                    'INT_ID_NOTIF' => $seq_id,
                    'CHR_NPK' => $row->CHR_NPK,
                    'INT_ID_APP' => $this->id_app,
                    'INT_ID_MODULE' => $this->id_module,
                    'INT_ID_FUNCTION' => $this->id_function,
                    'CHR_NOTIF_TITLE' => 'Open Ticket By ' . trim($session['USERNAME']),
                    'CHR_NOTIF_DESC' => trim($this->input->post('CHR_PROBLEM_TITLE')),
                    'CHR_LINK' => "helpdesk_ticket/helpdesk_ticket_c/prepare_to_feedback_helpdesk_ticket/$id_ticket",
                    'CHR_CREATED_BY' => 'System',
                    'CHR_CREATED_DATE' => date('Ymd'),
                    'CHR_CREATED_TIME' => date('His')
                );

                $this->notification_m->insert_notification($data_notif);
            }
            redirect($this->back_to_manage . $msg = 1);
        }
    }

    function edit_helpdesk_ticket($id_ticket) {
        $this->role_module_m->authorization($this->id_function);
        $session = $this->session->all_userdata();

        if ($session['ROLE'] == 1 || $session['ROLE'] == 38 || $session['ROLE'] == 7) {
            $content = 'helpdesk_ticket/helpdesk_ticket/edit_helpdesk_ticket_v';
        } else {
            $content = 'helpdesk_ticket/helpdesk_ticket/edit_helpdesk_ticket_by_staff_v';
        }
        $data['content'] = $content;
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(33);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Edit Helpdesk Ticket';

        $data['data_problem_type'] = $this->problem_type_m->get_problem_type();
        $data['data_prover'] = $this->prover_m->get_prover();
        $data['data'] = $this->helpdesk_ticket_m->get_data_helpdesk_ticket($id_ticket)->row();

        $this->load->view($this->layout, $data);
    }

    function update_helpdesk_ticket() {
        $session = $this->session->all_userdata();

        $this->form_validation->set_rules('CHR_PROBLEM_TITLE', 'Problem Title', 'required|trim|min_length[5]|max_length[50]|');
        $this->form_validation->set_rules('CHR_ASSET_NAME', 'Asset name', 'required|trim|min_length[5]|max_length[50]|');

        $duedate = date("Ymd", strtotime($this->input->post('CHR_DUE_DATE')));

        if ($this->form_validation->run() == FALSE) {
            $this->edit_helpdesk_ticket($this->input->post('INT_ID_TICKET'));
        } else {
            $data = array(
                'INT_ID_PROBLEM_TYPE' => $this->input->post('INT_ID_PROBLEM_TYPE'),
                'CHR_PROBLEM_TITLE' => $this->input->post('CHR_PROBLEM_TITLE'),
                'CHR_PROBLEM_DESC' => $this->input->post('CHR_PROBLEM_DESC'),
                'CHR_ASSET_NAME' => $this->input->post('CHR_ASSET_NAME'),
                'CHR_NPK' => $this->input->post('CHR_NPK'),
                'INT_PRIORITY' => $this->input->post('INT_PRIORITY'),
                'CHR_DUE_DATE' => $duedate,
                'CHR_MODI_BY' => $session['USERNAME'],
                'CHR_MODI_DATE' => date("Ymd"),
                'CHR_MODI_TIME' => date("His")
            );

            $this->db->trans_start();
            $this->helpdesk_ticket_m->update_helpdesk_ticket($data, $this->input->post('INT_ID_TICKET'));
            $this->db->trans_complete();
            redirect($this->back_to_manage . 2);
        }
    }

    function update_helpdesk_ticket_by_staff() {
        $session = $this->session->all_userdata();

        $this->form_validation->set_rules('CHR_PROBLEM_TITLE', 'Problem Title', 'required|trim|min_length[5]|max_length[30]|');
        $this->form_validation->set_rules('CHR_ASSET_NAME', 'Asset name', 'required|trim|min_length[5]|max_length[20]|');

        $duedate = date("Ymd", strtotime($this->input->post('CHR_DUE_DATE')));

        if ($this->form_validation->run() == FALSE) {
            $this->edit_helpdesk_ticket($this->input->post('INT_ID_TICKET'));
        } else {
            $data = array(
                'INT_ID_PROBLEM_TYPE' => $this->input->post('INT_ID_PROBLEM_TYPE'),
                'CHR_PROBLEM_TITLE' => $this->input->post('CHR_PROBLEM_TITLE'),
                'CHR_PROBLEM_DESC' => $this->input->post('CHR_PROBLEM_DESC'),
                'CHR_ASSET_NAME' => $this->input->post('CHR_ASSET_NAME'),
                'INT_STATUS' => 0,
                'CHR_DUE_DATE' => $duedate,
                'CHR_MODI_BY' => $session['USERNAME'],
                'CHR_MODI_DATE' => date("Ymd"),
                'CHR_MODI_TIME' => date("His")
            );

            $this->db->trans_start();
            $this->helpdesk_ticket_m->update_helpdesk_ticket($data, $this->input->post('INT_ID_TICKET'));
            $this->db->trans_complete();
            redirect($this->back_to_manage . 2);
        }
    }

    function delete_helpdesk_ticket($id_ticket) {
        $this->role_module_m->authorization($this->id_function);
        $this->db->trans_start();
        $this->helpdesk_ticket_m->delete_helpdesk_ticket($id_ticket);
        $this->log_m->add_log('86', $id_ticket);
        $this->db->trans_complete();
        redirect($this->back_to_manage . $msg = 3);
    }

    public function print_helpdesk_ticket($no_ticket) {
        $this->load->library('fpdf17/fpdf');

        define('FPDF_FONTPATH', $this->config->item('fonts_path'));
        $this->load->model('helpdesk_ticket/problem_type_m');
        $this->load->model('helpdesk_ticket/prover_m');
        $this->load->model('organization/dept_m');
        $this->load->model('basis/user_m');

        $session = $this->session->all_userdata();
        $head = $this->helpdesk_ticket_m->get_data_helpdesk_ticket($no_ticket)->row();

        $this->fpdf->Open();
        $pdf = new FPDF("P", "cm", "A4");
        $pdf->AliasNbPages();
        $pdf->AddPage();
        $pdf->SetFont('helvetica', 'B', 18);
        $pdf->SetDrawColor(0);

        $pdf->Cell(19, 0.7, 'PT AISIN INDONESIA', 0, 0, 'C');

        $pdf->Ln();
        $pdf->SetFont('helvetica', '', 10);
        $pdf->Cell(19, 0.7, 'Ejip Industrial Park Plot 5J Cikarang Selatan - Bekasi', 0, 0, 'C');


        /* Fungsi Line untuk membuat garis */
        $pdf->Line(1, 2.5, 20, 2.5);

        $pdf->Ln(1);
        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->Cell(19, 1, 'HELPDESK TICKET', 0, 0, 'C');

        $pdf->Ln(1);
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Cell(15, 1, 'NPK : ' . $head->CHR_NPK, 0, 0, 'L');
        $pdf->Cell(15, 1, 'DEPARTMENT : ' . $head->CHR_DEPT, 0, 0, 'L');

        $start_date = date("d/M/Y", strtotime($head->CHR_CREATE_DATE)) . ' ' . date("h:i", strtotime($head->CHR_CREATE_TIME));

        $pdf->Ln();
        $pdf->Cell(15, 0.2, 'TICKET NO : ' . $head->INT_ID_TICKET, 0, 0, 'L');
        $pdf->Cell(15, 0.2, 'DATE : ' . $start_date, 0, 0, 'L');

        $pdf->Ln(1);
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Cell(5, 0.2, 'PROBLEM TITLE : ' . trim($head->CHR_ASSET_NAME) . "-" . trim($head->CHR_PROBLEM_TITLE) . "[ " . trim($head->CHR_PROBLEM_TYPE_DESC) . "] ", 0, 0, 'L');
        $pdf->Ln(1);
        $pdf->Cell(5, 0.2, 'DESCRIPTION : ' . trim($head->CHR_PROBLEM_DESC), 0, 0, 'L');

        /* setting posisi footer 3 cm dari bawah */
        $pdf->SetY(-3);

        /* setting font untuk footer */
        $pdf->SetFont('helvetica', '', 10);

        /* setting cell untuk waktu pencetakan */
        $pdf->Cell(9.5, 0.5, 'Printed on : ' . date('d/m/Y H:i') . ' | Created by : ' . $session['USERNAME'] . '', 0, 'LR', 'L');

        /* setting cell untuk page number */
        $pdf->Cell(9.5, 0.5, 'Page ' . $pdf->PageNo() . '/{nb}', 0, 0, 'R');

        /* generate pdf jika semua konstruktor, data yang akan ditampilkan, dll sudah selesai */
        $filename = trim($head->CHR_NPK) . "|" . trim($head->CHR_DEPT) . "|" . trim($start_date) . ".pdf";
        $pdf->Output($filename, 'I');
    }

//    function print_helpdesk_ticke1t($no_ticket) {
//        $this->load->library('PHPExcel');
//
//        $this->load->model('helpdesk_ticket/problem_type_m');
//        $this->load->model('helpdesk_ticket/prover_m');
//        $this->load->model('organization/dept_m');
//        $this->load->model('basis/user_m');
//        $objTpl = PHPExcel_IOFactory::load('./assets/template/ticketing.xls');
//
//        $data = $this->helpdesk_ticket_m->get_data_helpdesk_ticket($no_ticket)->row();
//
//        $objTpl->setActiveSheetIndex(0);
//
//        $objTpl->getActiveSheet()->setCellValue('C2', trim($data->CHR_NPK));
//        $objTpl->getActiveSheet()->setCellValue('C3', trim($data->CHR_DEPT));
//        $objTpl->getActiveSheet()->setCellValue("H2", $data->INT_ID_TICKET);
//        $objTpl->getActiveSheet()->setCellValue("H3", trim($data->CHR_PROBLEM_TYPE_DESC));
//        $objTpl->getActiveSheet()->setCellValue("H4", date('d-M-Y'));
//        $objTpl->getActiveSheet()->setCellValue("C6", trim($data->CHR_ASSET_NAME) . " " . trim($data->CHR_PROBLEM_TITLE));
//        $objTpl->getActiveSheet()->setCellValue("C7", trim($data->CHR_PROBLEM_DESC));
//        $objTpl->getActiveSheet()->setCellValue("C14", trim($data->CHR_CREATE_DATE));
//
//        $filename = $no_ticket . "/" . trim($data->CHR_CREATE_DATE) . "/" . trim($data->CHR_DEPT) . ".xls";
//
//        ob_end_clean();
//        header('Content-Type: application/vnd.ms-excel');
//        header('Content-Disposition: attachment;filename="' . trim($filename) . '"');
//        header('Cache-Control: max-age=0');
//
//        $objWriter = PHPExcel_IOFactory::createWriter($objTpl, 'Excel5');
//        $objWriter->save('php://output');
//    }

    function print_report_helpdesk_ticket_by_dept() {
        $this->role_module_m->authorization('38');
        $this->load->library('excel');
        $this->load->model('organization/dept_m');
        $this->load->model('basis/user_m');
        $objTpl = PHPExcel_IOFactory::load('./assets/template/rpt_helpdesk_ticket.xls');

        $this->form_validation->set_rules('INT_ID_DEPT', 'Department', 'required');

        $month = $this->input->post('INT_MONTH');
        $year = $this->input->post('INT_YEAR');
        $id_dept = $this->input->post('INT_ID_DEPT');
        $date = $year . $month;

        if ($this->input->post('INT_ID_DEPT') == NULL) {
            $data = $this->helpdesk_ticket_m->get_helpdesk_ticket_by_date($date);
            $param = '';
            $param_detail = '';
            $filename = trim($year) . "/" . $month . ".xls";
        } else {
            $data = $this->helpdesk_ticket_m->get_helpdesk_ticket_by_dept($id_dept, $date);
            $param = 'DEPARTMENT :';
            $param_detail = $this->dept_m->get_desc_dept($id_dept);
            $filename = trim($year) . "/" . $month . "/" . $id_dept . ".xls";
        }

        if ($month == '01') {
            $full_month = 'JANUARY';
        } else if ($month == '02') {
            $full_month = 'FEBRUARY';
        } else if ($month == '03') {
            $full_month = 'MARCH';
        } else if ($month == '04') {
            $full_month = 'APRIL';
        } else if ($month == '05') {
            $full_month = 'MAY';
        } else if ($month == '06') {
            $full_month = 'JUNE';
        } else if ($month == '07') {
            $full_month = 'JULY';
        } else if ($month == '08') {
            $full_month = 'AUGUST';
        } else if ($month == '09') {
            $full_month = 'SEPTEMBER';
        } else if ($month == '10') {
            $full_month = 'OCTOBER';
        } else if ($month == '11') {
            $full_month = 'SEPTEMBER';
        } else if ($month == '12') {
            $full_month = 'DECEMBER';
        }

        $objTpl->setActiveSheetIndex(0);
        $objTpl->getActiveSheet()->setCellValue('A2', 'LAPORAN HELPDESK TICKET :' . $full_month . '/' . $year);
        $objTpl->getActiveSheet()->setCellValue('A3', $param . $param_detail);

        $e = 5;
        $jum = 1;
        foreach ($data as $row) {
            $objTpl->getActiveSheet()->setCellValue("A$e", $jum);
            $objTpl->getActiveSheet()->setCellValue("B$e", trim($row->CHR_USERNAME));
            $objTpl->getActiveSheet()->setCellValue("C$e", trim($row->INT_ID_TICKET));
            $objTpl->getActiveSheet()->setCellValue("D$e", trim($row->CHR_PROBLEM_TYPE_DESC));
            $objTpl->getActiveSheet()->setCellValue("E$e", trim($row->CHR_ASSET_NAME));
            $objTpl->getActiveSheet()->setCellValue("F$e", trim($row->CHR_PROBLEM_TITLE));
            $objTpl->getActiveSheet()->setCellValue("G$e", trim($row->CHR_PROBLEM_DESC));
            $objTpl->getActiveSheet()->setCellValue("H$e", trim($row->CHR_CREATE_DATE));
            $objTpl->getActiveSheet()->setCellValue("I$e", trim($row->CHR_FINISH_DATE));
            $objTpl->getActiveSheet()->setCellValue("J$e", trim($row->CHR_PROVER_DESC));
            $objTpl->getActiveSheet()->setCellValue("K$e", trim($row->CHR_DEPT_DESC));
            $e = $e + 1;
            $jum = $jum + 1;
        }

        //sheet2
        if ($this->input->post('INT_ID_DEPT') == NULL) {
            $data = $this->helpdesk_ticket_m->get_helpdesk_ticket_group_by_dept($date);
            $filename = trim($year) . "/" . $month . ".xls";
        }

        $objTpl->setActiveSheetIndex(1);
        $objTpl->getActiveSheet()->setCellValue('A2', 'LAPORAN HELPDESK TICKET :' . $full_month . '/' . $year);
        $objTpl->getActiveSheet()->setCellValue('A4', 'Department');

        $el = 5;
        foreach ($data as $row) {
            $objTpl->getActiveSheet()->setCellValue("A$el", trim($row->CHR_DEPT));
            $objTpl->getActiveSheet()->setCellValue("B$el", trim($row->total));
            $el = $el + 1;
        }

        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . trim($filename) . '"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objTpl, 'Excel5');
        $objWriter->save('php://output');
    }

    function print_report_helpdesk_ticket_by_type() {
        $this->role_module_m->authorization('38');
//        $this->load->library('PHPExcel');
        $this->load->library('excel');
        $this->load->model('helpdesk_ticket/problem_type_m');
        $this->load->model('basis/user_m');
        $objTpl = PHPExcel_IOFactory::load('./assets/template/rpt_helpdesk_ticket.xls');

        //$this->form_validation->set_rules('INT_ID_PROBLEM_TYPE', 'Type of Problem', 'required');

        $month = $this->input->post('INT_MONTH');
        $year = $this->input->post('INT_YEAR');
        $id_problem_type = $this->input->post('INT_ID_PROBLEM_TYPE');
        $date = $year . $month;

        if ($this->input->post('INT_ID_PROBLEM_TYPE') == NULL) {
            $data = $this->helpdesk_ticket_m->get_helpdesk_ticket_by_date($date);
            $param = '';
            $param_detail = '';
            $filename = trim($year) . "/" . $month . ".xls";
        } else {
            $data = $this->helpdesk_ticket_m->get_helpdesk_ticket_by_problem($id_problem_type, $date);
            $param = 'TYPE OF PROBLEM :';
            $param_detail = $this->problem_type_m->get_desc_problem_type($id_problem_type);
            $filename = trim($year) . "/" . $month . "/" . $id_problem_type . ".xls";
        }

//        if ($this->form_validation->run() == FALSE) {
//            $this->prepare_report_ticket();
//        } else {


        if ($month == '01') {
            $full_month = 'JANUARY';
        } else if ($month == '02') {
            $full_month = 'FEBRUARY';
        } else if ($month == '03') {
            $full_month = 'MARCH';
        } else if ($month == '04') {
            $full_month = 'APRIL';
        } else if ($month == '05') {
            $full_month = 'MAY';
        } else if ($month == '06') {
            $full_month = 'JUNE';
        } else if ($month == '07') {
            $full_month = 'JULY';
        } else if ($month == '08') {
            $full_month = 'AUGUST';
        } else if ($month == '09') {
            $full_month = 'SEPTEMBER';
        } else if ($month == '10') {
            $full_month = 'OCTOBER';
        } else if ($month == '11') {
            $full_month = 'SEPTEMBER';
        } else if ($month == '12') {
            $full_month = 'DECEMBER';
        }

        $objTpl->setActiveSheetIndex(0);

        $objTpl->getActiveSheet()->setCellValue('A2', 'LAPORAN HELPDESK TICKET :' . $full_month . '/' . $year);
        $objTpl->getActiveSheet()->setCellValue('A3', $param . $param_detail);

        $e = 5;
        $jum = 1;
        foreach ($data as $row) {
            $objTpl->getActiveSheet()->setCellValue("A$e", $jum);
            $objTpl->getActiveSheet()->setCellValue("B$e", trim($row->CHR_USERNAME));
            $objTpl->getActiveSheet()->setCellValue("C$e", trim($row->INT_ID_TICKET));
            $objTpl->getActiveSheet()->setCellValue("D$e", trim($row->CHR_PROBLEM_TYPE_DESC));
            $objTpl->getActiveSheet()->setCellValue("E$e", trim($row->CHR_ASSET_NAME));
            $objTpl->getActiveSheet()->setCellValue("F$e", trim($row->CHR_PROBLEM_TITLE));
            $objTpl->getActiveSheet()->setCellValue("G$e", trim($row->CHR_PROBLEM_DESC));
            $objTpl->getActiveSheet()->setCellValue("H$e", trim($row->CHR_CREATE_DATE));
            $objTpl->getActiveSheet()->setCellValue("I$e", trim($row->CHR_FINISH_DATE));
            $objTpl->getActiveSheet()->setCellValue("J$e", trim($row->CHR_PROVER_DESC));
            $objTpl->getActiveSheet()->setCellValue("K$e", trim($row->CHR_DEPT_DESC));
            $e = $e + 1;
            $jum = $jum + 1;
        }

        //sheet2
        if ($this->input->post('INT_ID_PROBLEM_TYPE') == NULL) {
            $data = $this->helpdesk_ticket_m->get_helpdesk_ticket_group_by_type($date);
            $filename = trim($year) . "/" . $month . ".xls";
        }

        $objTpl->setActiveSheetIndex(1);
        $objTpl->getActiveSheet()->setCellValue('A2', 'LAPORAN HELPDESK TICKET :' . $full_month . '/' . $year);
        $objTpl->getActiveSheet()->setCellValue('A4', 'Type of Problem');

        $el = 5;
        foreach ($data as $row) {
            $objTpl->getActiveSheet()->setCellValue("A$el", trim($row->CHR_PROBLEM_TYPE_DESC));
            $objTpl->getActiveSheet()->setCellValue("B$el", trim($row->total));
            $el = $el + 1;
        }

        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . trim($filename) . '"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objTpl, 'Excel5');
        $objWriter->save('php://output');
        //}
    }

    function prepare_report_ticket() {
        $this->role_module_m->authorization('35');
        $this->load->model('organization/dept_m');

        $data['data_problem_type'] = $this->problem_type_m->get_problem_type();
        $data['data_dept'] = $this->dept_m->get_dept();

        $data['data'] = $this->helpdesk_ticket_m->get_close_helpdesk_ticket();
        $data['content'] = 'helpdesk_ticket/helpdesk_ticket/report_helpdesk_ticket_v';

        $data['title'] = 'Report Helpdesk Ticket';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(35);
        $data['news'] = $this->news_m->get_news();

        $this->load->view($this->layout, $data);
    }

}
