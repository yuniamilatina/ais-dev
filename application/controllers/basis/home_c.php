<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class home_c extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('basis/home_m');
        $this->load->model('portal/param_m');
        $this->load->model('helpdesk_ticket/helpdesk_ticket_m');
    }

    function check_session() {
        $user_session = $this->session->all_userdata();
        if ($user_session['NPK'] == '') {
            redirect(base_url('index.php/login_c'));
        }
    }

    function index($year = null, $period = null, $msg = null) {
        $this->check_session();
        $user_session = $this->session->all_userdata();
        $row = $this->home_m->get_role($user_session['ROLE'])->row();
        $title = ' Dashboard';
        $session = $this->session->all_userdata();
        
        if (($user_session['ROLE'] == '1') or ($user_session['ROLE'] == '2')) {
            $data['logs'] = $this->log_m->get_last_logs();
        } else {
            $data['logs'] = null;
        }

        if($user_session['ROLE'] == 1 || $user_session['ROLE'] == 3 || $user_session['ROLE'] == 4 || $user_session['ROLE'] == 5 
        || $user_session['ROLE'] == 5 || $user_session['ROLE'] == 39 || $user_session['ROLE'] == 45 || $user_session['ROLE'] == 25
        || $user_session['ROLE'] == 47 || $user_session['ROLE'] == 70){
            
            $this->load->model('covid/covid_m');

            $data['case_by_div'] = $this->covid_m->get_case_per_div();
            
            if($period == null){
                $data['period'] = date('Ym');
            }else{
                $data['period'] = $period;
            }

            if($year == null){
                $data['year'] = date('Y');
            }else{
                $data['year'] = $year;
            }

            $data_detail = $this->covid_m->get_summary();

            $data['data_daily_status_case'] = $this->covid_m->get_data_daily_status_case($data['period']);
            $data['data_monthly_status_case'] = $this->covid_m->get_data_monthly_status_case($data['year']);

            foreach ($data_detail as $row) { 
                if($row->variabel)
                $data[$row->variabel] = $row->total;
            }

            $content = 'covid/covid_dashboard_v';
        }else{
            $content = 'dashboard/root_dashboard_v';
        }
        $expired = $session['CHR_EXP_DATE'];

        $url = base_url('index.php/basis/user_c/pre_change_password_user/' . $session['NPK']);

        if($expired <= date('Ymd', strtotime(date('Ymd') . ' + 10 days'))){
            $notif = "<div style='font-size:16px;' class = 'alert alert-danger'><strong>Password anda akan segera kadaluarsa !</strong> <br> Mohon untuk segera mengupdate password anda, agar tetap bisa mengakses portal ini, ketik link ini <a href='$url'>disini</a> untuk mengupdate password </div >";
        }else{
            $notif = NULL;
        }

        $data['msg'] = $msg;
        $data['title'] = $title;
        $data['content'] = $content;
        $data['notif'] = $notif;
        $data['npk'] = $user_session['NPK'];

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module(1);
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(0);
        $data['news'] = $this->news_m->get_news();
        
        $this->load->view('/template/head', $data);
    }
    
    function update_notif($id){
        $notif = $this->notification_m->get_notif_by_id($id);
        $link = $notif->CHR_LINK;
        $this->notification_m->has_be_read($id);
        redirect($link);
    }

}

?>
