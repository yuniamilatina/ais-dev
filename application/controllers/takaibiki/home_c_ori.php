<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class home_c extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('basis/home_m');
        $this->load->model('portal/param_m');
    }

    function check_session() {
        $user_session = $this->session->all_userdata();
        if ($user_session['NPK'] == '') {
            redirect(base_url('index.php/login_c'));
        }
    }

    function index($msg = null) {
        $this->check_session();
        $user_session = $this->session->all_userdata();
        $row = $this->home_m->get_role($user_session['ROLE'])->row();
        if (($user_session['ROLE'] == '1') or ($user_session['ROLE'] == '2')) {
            $data['logs'] = $this->log_m->get_last_logs();
        } else {
            $data['logs'] = null;
        }
        $title = $row->CHR_ROLE . ' Dashboard';
        //$content = 'dashboard/budget'. $row->INT_ID_ROLE;
        $content = 'takaibiki/manage_part';
        $takaibiki = $this->load->database('takaibiki', TRUE);

        $master_part = $takaibiki->query("select * from t_master_pis")->result();


        $data['master_part'] = $master_part;
        $data['msg'] = $msg;
        $data['title'] = $title;
        $data['content'] = $content;

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(0);
        $data['news'] = $this->news_m->get_news();

        $params = $this->param_m->get_params();
        $data['visits'] = $params[0]->INT_TOT_VISITS;
        $data['temperature'] = $params[0]->INT_TEMPERATURE;
        $data['weather'] = $params[0]->CHR_WEATHER;

        $tot_user = $this->param_m->get_tot_user();
        $data['tot_user'] = $tot_user[0]->TOT_USER;

        $tot_thread = $this->param_m->get_tot_thread();
        $data['tot_thread'] = $tot_thread[0]->TOT_THREAD;

        $tot_tickets = $this->param_m->get_tot_tickets();
        $data['tot_tickets'] = $tot_tickets[0]->TOT_TICKETS;
//
//        $data['m1'] = $this->role_module_m->menu();
//        $data['m2'] = $this->role_module_m->menu2();
//        $data['m3'] = $this->role_module_m->menu3();

        $this->load->view('/template/head', $data);
    }

    function edit_point($back_no) {
        $takaibiki = $this->load->database('takaibiki', TRUE);
        $this->check_session();
        $msg = "";
        $user_session = $this->session->all_userdata();
        $row = $this->home_m->get_role($user_session['ROLE'])->row();
        if (($user_session['ROLE'] == '1') or ($user_session['ROLE'] == '2')) {
            $data['logs'] = $this->log_m->get_last_logs();
        } else {
            $data['logs'] = null;
        }
        $title = $row->CHR_ROLE . ' Dashboard';
        //$content = 'dashboard/budget'. $row->INT_ID_ROLE;
        $content = 'takaibiki/edit_point';

        //cek database
        $part_no = "";
        $part_no_arr = $takaibiki->query("select * from t_master_pis where t_master_pis.b_no = '$back_no'")->row();
        if (count($part_no) > 0) {
            $part_no = $part_no_arr->p_no;
        }
        //get pointer 
        $get_pointer = $takaibiki->query("select * from t_master_cek where p_no = '$part_no'")->result();


        $data['msg'] = $msg;
        $data['title'] = $title;
        $data['content'] = $content;
        $data['pointer'] = $get_pointer;
        $data['back_no'] = $back_no;
        $data['part_no'] = $part_no;

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(0);
        $data['news'] = $this->news_m->get_news();

        $params = $this->param_m->get_params();
        $data['visits'] = $params[0]->INT_TOT_VISITS;
        $data['temperature'] = $params[0]->INT_TEMPERATURE;
        $data['weather'] = $params[0]->CHR_WEATHER;

        $tot_user = $this->param_m->get_tot_user();
        $data['tot_user'] = $tot_user[0]->TOT_USER;

        $tot_thread = $this->param_m->get_tot_thread();
        $data['tot_thread'] = $tot_thread[0]->TOT_THREAD;

        $tot_tickets = $this->param_m->get_tot_tickets();
        $data['tot_tickets'] = $tot_tickets[0]->TOT_TICKETS;
//
//        $data['m1'] = $this->role_module_m->menu();
//        $data['m2'] = $this->role_module_m->menu2();
//        $data['m3'] = $this->role_module_m->menu3();

        $this->load->view('/template/head', $data);
    }

    function save_point() {
        $data = '';
        $takaibiki = $this->load->database('takaibiki', TRUE);
        $p_no = $this->input->post('part_no');
        $left = $this->input->post('left');
        $top = $this->input->post('top');

        //cek point
        $cek_point = $takaibiki->query("select * from t_master_cek where t_master_cek.p_no = '$p_no'")->result();
        $num_cek = count($cek_point);
        $num_order = $num_cek + 1;

        $takaibiki->query("INSERT INTO `t_master_cek` (`p_no`, `cek_no`, `width`, `height`) VALUES ('$p_no', $num_order, $left, $top);");
        echo $data;
    }
    
    function delete_point() {
        $data = '';
        $takaibiki = $this->load->database('takaibiki', TRUE);
        $p_no = $this->input->post('part_no');
        $cek_no = $this->input->post('cek_no');
        $top = $this->input->post('top');

        //cek point
        $cek_point = $takaibiki->query("DELETE FROM `db_picking`.`t_master_cek` WHERE  `p_no`='$p_no' AND `cek_no`=$cek_no LIMIT 1;")->result();
       
        echo $data;
    }

}

?>
