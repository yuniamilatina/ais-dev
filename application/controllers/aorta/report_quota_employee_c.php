<?php

class report_quota_employee_c extends CI_Controller
{
    /* -- define constructor -- */

    private $layout = '/template/head';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('aorta/quota_employee_m');
        $this->load->model('aorta/overtime_m');
        $this->load->model('organization/dept_m');
    }

    function index($period = null, $dept = null, $section = null)
    {

        $data['title'] = 'Report Quota Employee';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(230);
        $data['news'] = $this->news_m->get_news();
        $data['content'] = 'aorta/report_quota_employee_v';

        $user_session = $this->session->all_userdata();
        $npk = $user_session['NPK'];
        $role = $user_session['ROLE'];
        $id_section = $user_session['SECTION'];
        $id_dept = $user_session['DEPT'];
        $id_group = $user_session['GROUPDEPT'];
        $id_division = $user_session['DIVISION'];

        if ($period == NULL) {
            $period = date('Ym');
        }

        if ($role == 1 || $role == 4 || $role == 3 || $role == 6) {
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
        $data['role'] = $role;
        $data['npk'] = $npk;
        $data['data'] = $this->quota_employee_m->get_quota_employee_with_group($period, $dept, $section);

        $this->load->view($this->layout, $data);
    }
}
