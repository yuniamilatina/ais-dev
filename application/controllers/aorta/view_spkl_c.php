<?php

use LDAP\Result;

class view_spkl_c extends CI_Controller
{

    private $layout = '/template/head';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('aorta/overtime_m');
        $this->load->model('aorta/view_spkl_m');
        $this->load->model('organization/dept_m');
        $this->load->model('basis/user_m');
    }
    
    public function check_session()
    {
        $user_session = $this->session->all_userdata();
        if ($user_session['NPK'] == '') {
            redirect(base_url('index.php/login_c'));
        }
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

        if ($role == 1 || $role == 102) {
            if ($dept == NULL) {
                $dept = $this->view_spkl_m->get_top_data_dept_by_division()->row()->CHR_DEPT;
            } else {
                $dept = $dept;
            }
            $data['all_dept'] = $this->view_spkl_m->get_all_dept_by_division_id();
        } else {
            if ($dept == NULL) {
                $dept = $this->view_spkl_m->get_data_dept($id_dept)->row()->CHR_DEPT;
            } else {
                $dept = $dept;
            }
            $data['all_dept'] = $this->view_spkl_m->get_data_dept($id_dept)->result();
        }

        $data['all_section'] = $this->overtime_m->get_all_section_drop($dept);

        if($section == null){
            $section = $this->overtime_m->get_top_section_overtime($dept)->row()->KODE;
        }

        $data['npk'] = $npk;
        $data['role'] = $role;
        $data['dept'] = $dept;
        $data['section'] = $section;
        $data['period'] = $period;

        $data['data'] = $this->view_spkl_m->get_data_overtime($dept, $period, $section);

        $data['content'] = 'aorta/overtime/manage_overtime_by_hrd_v';
        $this->load->view($this->layout, $data);
    }

    function get_data_spkl($period = null, $dept = null,   $msg = NULL)
    {
        // echo $period;
        // exit;

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
        $data['sidebar'] = $this->role_module_m->side_bar(361);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'View SPKL';
        $data['msg'] = $msg;

        // $data['data_view'] = $this->view_spkl_m->get_join_table_nama($dept)->result();
        // $data['option_filter_dept'] = $this->view_spkl_m->get_option_filter_dept()->result();


        $user_session = $this->session->all_userdata();
        $npk = $user_session['NPK'];
        $role = $user_session['ROLE'];
        $id_dept = $user_session['DEPT'];
        $id_group = $user_session['GROUPDEPT'];
        $id_division = $user_session['DIVISION'];

        if ($period == NULL) {
            $period = date('Ym');
        }


        // if ($role == 25) {
        //     if ($dept == NULL) {
        //         $dept = $this->dept_m->get_top_data_dept_by_division($id_division)->row()->CHR_DEPT;
        //     } else {
        //         $dept = $dept;
        //     }
        //     $data['all_dept'] = $this->dept_m->get_dept_by_division_id($id_division);
        // } else {
        //     if ($dept == NULL) {
        //         $dept = $this->dept_m->get_data_dept($id_dept)->row()->CHR_DEPT;
        //     } else {
        //         $dept = $dept;
        //     }
        //     $data['all_dept'] = $this->dept_m->get_data_dept($id_dept)->result();
        // }

        if ($role == 25) {
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

        // $data['all_section'] = $this->view_spkl_m->get_section_overtime($dept);


        // if ($section == NULL) {
        //     $section = 'ALL';
        // } else {
        //     $x = 0;
        //     foreach ($data['all_section'] as $value) {
        //         if (trim($value->KODE) == trim($section)) {
        //             $x = 1;
        //         }
        //     }

        //     if ($x == 0) {
        //         $section = 'ALL';
        //     }
        // }

        $data['npk'] = $npk;
        $data['role'] = $role;
        $data['dept'] = trim($dept);
        // $data['section'] = $section;
        $data['period'] = $period;

        // $data['data'] = $this->view_spkl_m->get_data_overtime($dept, $period, $section);

        $data['data_view'] = $this->view_spkl_m->get_join_table_nama($data['dept'],  $period);
        // $data['option_filter_dept'] = $this->view_spkl_m->get_option_filter_dept()->result();

        // print_r($data['data_view']);?
        // exit;

        $data['content'] = 'aorta/view_spkl/manage_view_spkl_v';
        $this->load->view($this->layout, $data);
    }

    // function load_dept()
    // {


    //     $aortadb = $this->load->database("aorta", TRUE);
    //     $dept_id = $_GET['dept_id'];

    //     $data = $aortadb->get_where('TT_KRY_OVERTIME', ['KD_DEPT' => $dept_id])->result();

    // }
}
