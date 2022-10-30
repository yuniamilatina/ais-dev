<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class ines_linestop_c extends CI_Controller {

    private $layout = '/template/head';
    private $back_to_manage = 'prd/ines_linestop_c/index/';
    private $back_to_search = 'prd/ines_linestop_c/search_ines_linestop/';

    public function __construct() {
        parent::__construct();
        $this->load->model('prd/direct_backflush_general_m');
        $this->load->model('pes/line_stop_prod_m');
    }

    function check_session() {
        $user_session = $this->session->all_userdata();
        if ($user_session['NPK'] == '') {
            redirect(base_url('index.php/login_c'));
        }
    }

    function index($msg = null) {
        $this->check_session();

        if ($msg == 1) {
            $msg = "<div class = 'alert alert-success'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>The Line stoped </strong> The data is successfully created </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Calling Support Team success </strong> The data is successfully updated </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Line stop has been follow up </strong> The data is successfully updated </div >";
        } elseif ($msg == 4) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Line stop has been closed </strong> The data is successfully updated</div >";
        } 

        $data['msg'] = $msg;
        $data['title'] = 'Line Stop Sub Assy';
        $data['content'] = 'prd/ines_linestop/manage_ines_linestop_v';
        $data['all_work_centers'] = $this->direct_backflush_general_m->get_data_work_center_non_ines();
        
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(296);
        $data['news'] = $this->news_m->get_news();

        $date = date('Ymd');

        $data['data'] = $this->line_stop_prod_m->get_data_ls_subassy($date);
        $this->load->view($this->layout, $data);
    }

    function start_linestop(){
        $user_session = $this->session->all_userdata();
        $work_center = $this->input->post('CHR_WORK_CENTER');
        $shift = $this->input->post('INT_SHIFT');
        $flg_shift = $this->input->post('INT_FLG_SHIFT');
        $ls_code = $this->input->post('CHR_LS_CODE');
        $date = date('Ymd');
        $datenow = date('Ymd');
        $timenow = date('His');

        if($shift == 3 && date('H') < 7){
            $date = date('Ymd',strtotime($datenow . "-1 days"));
        }

        $data_update = array(
            'INT_SHIFT' => $shift,
            'INT_FLG_SHIFT' => $flg_shift,
            'INT_ID_LOSSTIME' => $ls_code,
            'CHR_DATE' => $date,
            'INT_FLG_LS' => 1,
            'CHR_LS_START' => date('Hi')
        );
        $this->line_stop_prod_m->update_linestop_manual($data_update, $work_center);

        $data_insert = array(
            'CHR_LINE_CODE' => $ls_code,
            'CHR_WO_NUMBER' => $work_center.'/'.$date.'/SHIFT'.$shift,
            'CHR_WORK_CENTER' => $work_center,
            'CHR_DATE' => $date,
            'CHR_SHIFT' => $shift,
            'INT_SHIFT_TYPE' => $flg_shift,
            'CHR_CREATED_BY' => $user_session['NPK'],
            'CHR_CREATED_DATE' => $datenow,
            'CHR_CREATED_TIME' => $timenow,
            'CHR_START_DATE' => $datenow,
            'CHR_START_TIME' => $timenow
        );
        $this->line_stop_prod_m->save($data_insert);

        redirect($this->back_to_manage.$msg = 1);

    }

    function call_support_linestop($id, $work_center){

        $data_update = array(
            'CHR_WAITING_DATE' => date('Ymd'),
            'CHR_WAITING_TIME' => date('His')
        );

        $id_update = array(
            'INT_ID_LINE_STOP' => $id
        );

        $this->line_stop_prod_m->update($data_update, $id_update);

        $data_update = array(
            'INT_FLG_FOLLOWUP' => 1,
            'CHR_LS_WAIT' => date('Hi')
        );

        $this->line_stop_prod_m->update_linestop_manual($data_update, $work_center);
        
        redirect($this->back_to_manage.$msg=2);
    }

    function follow_up_linestop($id,  $work_center){

        $user_session = $this->session->all_userdata();
        $username =  $user_session['USERNAME'];
        $npk =  $user_session['NPK'];
        $date = date('Ymd');
        $time = date('His');

        $data_update = array(
            'CHR_FOLLOWUP_BY' => $username,
            'CHR_FOLLOWUP_DATE' => $date,
            'CHR_FOLLOWUP_TIME' => $time
        );

        $id_update = array(
            'INT_ID_LINE_STOP' => $id
        );

        $this->line_stop_prod_m->update($data_update, $id_update);

        $data_update = array(
            'INT_FLG_FOLLOWUP' => 2,
            'CHR_NPK' => $npk,
            'CHR_USERNAME' => $username,
            'CHR_LS_REPAIR' => date('Hi')
        );

        $this->line_stop_prod_m->update_linestop_manual($data_update, $work_center);
 
        redirect($this->back_to_manage.$msg=3);
    }

    function stop_linestop($id,  $work_center) {
        $user_session = $this->session->all_userdata();
        $username =  $user_session['USERNAME'];
        $mpk =  $user_session['NPK'];
        $date = date('Ymd');
        $time = date('His');

        $data_update = array(
            'CHR_MODIFIED_BY' => $npk,
            'CHR_STOP_DATE' => $date,
            'CHR_STOP_TIME' => $time,
            'CHR_MODIFIED_DATE' => $date,
            'CHR_MODIFIED_TIME' => $time
        );

        $id_update = array(
            'INT_ID_LINE_STOP' => $id
        );

        $this->line_stop_prod_m->update($data_update, $id_update);

        $data_update = array(
            'INT_FLG_FOLLOWUP' => 0,
            'INT_FLG_LS' => 0,
            'INT_ID_LOSSTIME' => NULL,
            'CHR_DATE' => NULL,
            'INT_SHIFT' => 0,
            'INT_FLG_SHIFT' => 0,
            'INT_JAM1' => 0,
            'INT_JAM2' => 0,
            'INT_JAM3' => 0,
            'INT_JAM4' => 0,
            'INT_JAM5' => 0,
            'INT_JAM6' => 0,
            'INT_JAM7' => 0,
            'INT_JAM8' => 0,
            'INT_JAM9' => 0,
            'INT_JAM10' => 0,
            'INT_JAM11' => 0,
            'INT_JAM12' => 0,
            'INT_DURASI_WAITING' => 0,
            'INT_DURASI_REPAIR' => 0,
            'INT_DURASI_LINE_STOP' => 0,
            'CHR_LS_START' => NULL,
            'CHR_LS_WAIT' => NULL,
            'CHR_LS_REPAIR' => NULL,
            'CHR_LS_STOP' => NULL,
            'CHR_NPK' => NULL,
            'CHR_USERNAME' => NULL
        );

        $this->line_stop_prod_m->update_linestop_manual($data_update, $work_center);

        redirect($this->back_to_manage.$msg=4);
    }

    
}

?>
