<?php

class Covid_c extends CI_Controller {

    private $layout = '/template/head';

    public function __construct() {
        parent::__construct();
        $this->load->model('covid/covid_m');

    }

    public function index($div = null, $status = null, $msg = null){
        if ($msg == 2) {
            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Updating success </strong> The data is successfully updated </div >";
        } 

        $data['title'] = 'Manage Data Covid 19';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(341);
        $data['news'] = $this->news_m->get_news();
        $data['msg'] = $msg;
        $session = $this->session->all_userdata();
        $role = $session['ROLE'];
        $npk = $session['NPK'];

        if($status == null){
            $status = 3;
        }

        if($div == null){
            $div = 1;
        }
        $data['status'] = $status;
        $data['div'] = $div;
        $data['role'] = $role;
        $data['npk'] = $npk;

        $data['content'] = 'covid/manage_data_covid_v';
        $data['data'] = $this->covid_m->get_all_user($div,  $status);              
        $this->load->view($this->layout, $data);
    }

    public function manage_data_mp($group = NULL, $msg = NULL) {
        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Creating success </strong> The data is successfully created </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Updating success </strong> The data is successfully updated </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Deleted success </strong> The data is successfully deleted </div >";
        } elseif ($msg == 12) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Executing error !</strong> Something error with parameter </div >";
        }

        if($group == NULL){
            $group = 1;
        }

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(340);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Manage Data MP';
        $data['msg'] = $msg;

        $data['all_group'] = $this->covid_m->get_all_group();
        $data['group'] = $group;
        $data['data'] = $this->covid_m->get_all_data_mp($group);
        $data['content'] = 'covid/manage_data_mp_v';
        $this->load->view($this->layout, $data);
    }

    function update_vaccine(){
        $session = $this->session->all_userdata();
        $npk = $this->input->post('npk');
        $div_id = $this->input->post('div_id');

        if($this->input->post('vaccine1_date') != null || $this->input->post('vaccine1_date') != ''){
            $data_user['CHR_VACCINE1_DATE'] = substr($this->input->post('vaccine1_date'),6,4).''.substr($this->input->post('vaccine1_date'),3,2).''.substr($this->input->post('vaccine1_date'),0,2);
        }

        if($this->input->post('vaccine2_date') != null || $this->input->post('vaccine2_date') != ''){
            $data_user['CHR_VACCINE2_DATE'] = substr($this->input->post('vaccine2_date'),6,4).''.substr($this->input->post('vaccine2_date'),3,2).''.substr($this->input->post('vaccine2_date'),0,2);
        }

        if($this->input->post('vaccine3_date') != null || $this->input->post('vaccine3_date') != ''){
            $data_user['CHR_VACCINE3_DATE'] = substr($this->input->post('vaccine3_date'),6,4).''.substr($this->input->post('vaccine3_date'),3,2).''.substr($this->input->post('vaccine3_date'),0,2);
        }

        $data_user['CHR_MODIFIED_BY'] = $session['USERNAME'];
        $data_user['CHR_MODIFIED_DATE'] = date('Ymd');
        $data_user['CHR_MODIFIED_TIME'] = date('His');

        $id_user = array(
            'CHR_NPK' => $npk
        );

        $this->covid_m->update_user($data_user, $id_user);

        redirect('covid/covid_c/index/'.$div_id.'/3/'.$msg =2);
    }

    function update_data_covid(){
        $session = $this->session->all_userdata();
        $npk = $this->input->post('npk');
        $div_id = $this->input->post('div_id');
        $pcr_date = substr($this->input->post('pcr_date'),6,4).''.substr($this->input->post('pcr_date'),3,2).''.substr($this->input->post('pcr_date'),0,2);
        $pcr_date_new = substr($this->input->post('pcr_date_new'),6,4).''.substr($this->input->post('pcr_date_new'),3,2).''.substr($this->input->post('pcr_date_new'),0,2);
        $flg_quarantine = $this->input->post('flg_quarantine');
        $flg_quarantine_new = $this->input->post('flg_quarantine_new');
        $flg_pcr_positive = $this->input->post('flg_pcr_positive');
        $flg_pcr_positive_new = $this->input->post('flg_pcr_positive_new');
        $created_by = $session['USERNAME'];
        $date = date('Ymd');
        $time = date('His');

        if($flg_pcr_positive == 0){
            $data_case = array(
                'CHR_NPK' => $npk,
                'INT_PCR_COUNT' => 1,
                'INT_CASE_NO' => $this->covid_m->get_id_new_case(),
                'CHR_PCR_DATE' => $pcr_date_new,
                'INT_FLG_PCR_POSITIVE' => $flg_pcr_positive_new,
                'INT_FLG_QUARANTINE' => $flg_quarantine_new,
                'CHR_CREATED_BY' => $created_by,
                'CHR_CREATED_DATE' => $date,
                'CHR_CREATED_TIME' => $time
            );

            $this->covid_m->save_case($data_case);

            $data_user = array(
                'CHR_PCR_DATE' => $pcr_date_new,
                'INT_FLG_PCR_POSITIVE' => $flg_pcr_positive_new,
                'INT_FLG_QUARANTINE' => $flg_quarantine_new,
                'CHR_MODIFIED_BY' => $created_by,
                'CHR_MODIFIED_DATE' => $date,
                'CHR_MODIFIED_TIME' => $time
            );

            $id_user = array(
                'CHR_NPK' => $npk
            );
        
            $this->covid_m->update_user($data_user, $id_user);
        }else{
            $case_no = $this->covid_m->get_last_case_no_by_npk($npk);

            if($pcr_date == $pcr_date_new && $flg_pcr_positive == $flg_pcr_positive_new){
                $data_case = array(
                    'INT_FLG_QUARANTINE' => $flg_quarantine_new,
                    'CHR_MODIFIED_BY' => $created_by,
                    'CHR_MODIFIED_DATE' => $date,
                    'CHR_MODIFIED_TIME' => $time
                );
        
                $id_case = array(
                    'CHR_NPK' => $npk,
                    'INT_CASE_NO' => $case_no
                );

                $this->covid_m->update_case($data_case, $id_case);

                $data_user = array(
                    'INT_FLG_QUARANTINE' => $flg_quarantine_new,
                    'CHR_MODIFIED_BY' => $created_by,
                    'CHR_MODIFIED_DATE' => $date,
                    'CHR_MODIFIED_TIME' => $time
                );

                $id_user = array(
                    'CHR_NPK' => $npk
                );
        
                $this->covid_m->update_user($data_user, $id_user);

            }elseif($pcr_date == $pcr_date_new && $flg_pcr_positive == $flg_pcr_positive_new && $flg_quarantine  == $flg_quarantine_new){
                //no need logic here
            }else{
                $pcr_count = $this->covid_m->get_last_pcr_by_case_npk($case_no, $npk) + 1;

                if($flg_pcr_positive_new == 0){
                    $flg_quarantine_new = 0;
                }

                $data_case = array(
                    'CHR_NPK' => $npk,
                    'INT_PCR_COUNT' => $pcr_count,
                    'INT_CASE_NO' => $case_no,
                    'CHR_PCR_DATE' => $pcr_date_new,
                    'INT_FLG_PCR_POSITIVE' => $flg_pcr_positive_new,
                    'INT_FLG_QUARANTINE' => $flg_quarantine_new,
                    'CHR_CREATED_BY' => $created_by,
                    'CHR_CREATED_DATE' => $date,
                    'CHR_CREATED_TIME' => $time
                );

                $this->covid_m->save_case($data_case);

                $data_user = array(
                    'CHR_PCR_DATE' => $pcr_date_new,
                    'INT_FLG_PCR_POSITIVE' => $flg_pcr_positive_new,
                    'INT_FLG_QUARANTINE' => $flg_quarantine_new,
                    'CHR_MODIFIED_BY' => $created_by,
                    'CHR_MODIFIED_DATE' => $date,
                    'CHR_MODIFIED_TIME' => $time
                );

                $id_user = array(
                    'CHR_NPK' => $npk
                );
        
                $this->covid_m->update_user($data_user, $id_user);

            }

        }

        redirect('covid/covid_c/index/'.$div_id.'/3/'.$msg =2);
    }

    function get_detail_user(){
        $npk = $this->input->post("npk");

        $data_user = $this->covid_m->get_data_user($npk);
        
        $iso = '';
        $hos = '';
        $flg_qua = '';
       
        if($data_user->INT_FLG_QUARANTINE == 1){
            $iso = 'selected';
        }
        if($data_user->INT_FLG_QUARANTINE == 2){
            $hos = 'selected';
        }

        $flg_qua .="<option ".$iso." value='1'>Self Isolation</option><option ".$hos." value='2'>Hospitalized</option>";

        $json_data = array(
            'npk' => $data_user->CHR_NPK,
            'username' => $data_user->CHR_USERNAME,
            'div_id' => $data_user->div_id,
            'vaccine1' => $data_user->vaccine1_date_format,
            'vaccine2' => $data_user->vaccine2_date_format,
            'vaccine3' => $data_user->vaccine3_date_format,
            'flg_pcr_positive' => $data_user->INT_FLG_PCR_POSITIVE,
            'flg_quarantine' => $data_user->INT_FLG_QUARANTINE,
            'flg_qua' => $flg_qua,
            'pcr_date' => $data_user->pcr_date_format
        );

        echo json_encode($json_data);
    }

    function get_detail_case(){
        $npk = $this->input->post("npk");
        $case_detail = $this->covid_m->get_all_case_by_user($npk);
        $data = "";
        $i = 1;
        foreach ($case_detail as $isi) {
            $data .= "<tr class='gradeX'>";
            $data .= "<td style='text-align:center;'>$i</td>";
            $data .= "<td style='text-align:center;'>" . $isi->INT_CASE_NO . "</td>";
            $data .= "<td style='text-align:center;'>" . $isi->pcr_date_format . "</td>";

            if($isi->FLG_STATUS == 0){
                $color = 'background:#06d6a0;color:#FFFFFF;';
            }else{
                $color = 'background:#ff4d6d;color:#FFFFFF;';
            }

            $data .= "<td style='text-align:center;$color'>" . $isi->INT_FLG_PCR_POSITIVE . "</td>";
            $data .= "<td style='text-align:center;'>" . $isi->INT_FLG_QUARANTINE . "</td>";
            $data .= "</tr>";
            
            $i++;
        }

        echo $data;
    }

}