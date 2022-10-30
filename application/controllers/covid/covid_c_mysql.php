<?php

class Covid_c extends CI_Controller {

    private $layout_blank = '/template/head_blank';
    private $layout = '/template/head';

    public function __construct() {
        parent::__construct();
        $this->load->model('portal/eform_m');

    }

    public function index($period = null) {

        $data['title'] = 'Covid-19 Dashboard';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(341);
        $data['news'] = $this->news_m->get_news();
        
        $data_detail = $this->eform_m->get_summary();
        $data['dept_case'] = $this->eform_m->get_case_per_dept();
        
        if($period == null){
            $data['period'] = date('Ym');
        }else{
            $data['period'] = $period;
        }

        $data['data_daily_status_case'] = $this->eform_m->get_data_daily_status_case($data['period']);

        foreach ($data_detail as $row) { 
            $data[$row->variabel] = $row->total;
        }

        $data['content'] = 'covid/covid_dashboard_v';
    
        $this->load->view($this->layout, $data);
    }

    public function manage_data_covid($group = null, $msg = null){
        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Creating success </strong> The data is successfully created </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Updating success </strong> The data is successfully updated </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Deleted success </strong> The data is successfully deleted </div >";
        } elseif ($msg == 4) {
            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Choosing failed </strong> You must select at least one data</div >";
        } 

        $data['title'] = 'Manage Data Covid 19';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(342);
        $data['news'] = $this->news_m->get_news();
        $data['msg'] = $msg;

        if($group == null){
            $group = 1;
        }
        $data['group'] = $group;

        $data['content'] = 'covid/manage_data_covid_v';
        $data['data'] = $this->eform_m->get_all_user($group);              
        $this->load->view($this->layout, $data);
    }

    function update_vaccine(){
        $session = $this->session->all_userdata();
        $npk = $this->input->post('npk');
        $group_id = $this->input->post('group_id');
        $vaccine1_date = substr($this->input->post('vaccine1_date'),6,4).''.substr($this->input->post('vaccine1_date'),3,2).''.substr($this->input->post('vaccine1_date'),0,2);
        $vaccine2_date = substr($this->input->post('vaccine2_date'),6,4).''.substr($this->input->post('vaccine2_date'),3,2).''.substr($this->input->post('vaccine2_date'),0,2);
        $created_by = $session['USERNAME'];
        $date = date('Ymd');
        $time = date('His');

        $data_user = array(
            'vaccine1_date' => $vaccine1_date,
            'vaccine2_date' => $vaccine2_date,
            'modified_by' => $created_by,
            'modified_date' => $date,
            'modified_time' => $time
        );

        $id_user = array(
            'npk' => $npk
        );

        $this->eform_m->update_user($data_user, $id_user);

        redirect('covid/covid_c/manage_data_covid/'.$group_id.'/'.$msg =2);
    }

    function update_data_covid(){
        $session = $this->session->all_userdata();
        $npk = $this->input->post('npk');
        $group_id = $this->input->post('group_id');
        $pcr_date = substr($this->input->post('pcr_date'),6,4).''.substr($this->input->post('pcr_date'),3,2).''.substr($this->input->post('pcr_date'),0,2);
        $pcr_date_new = substr($this->input->post('pcr_date_new'),6,4).''.substr($this->input->post('pcr_date_new'),3,2).''.substr($this->input->post('pcr_date_new'),0,2);
        $flg_quarantine = $this->input->post('flg_quarantine');
        $flg_quarantine_new = $this->input->post('flg_quarantine_new');
        $flg_pcr_positive = $this->input->post('flg_pcr_positive');
        $flg_pcr_positive_new = $this->input->post('flg_pcr_positive_new');
        $created_by = $session['USERNAME'];
        $date = date('Ymd');
        $time = date('His');

        if($flg_pcr_positive == 0){ //new case
            $data_case = array(
                'npk' => $npk,
                'pcr_count' => 1,
                'case_no' => $this->eform_m->get_id_new_case(),
                'pcr_date' => $pcr_date_new,
                'flg_pcr_positive' => $flg_pcr_positive_new,
                'flg_quarantine' => $flg_quarantine_new,
                'created_by' => $created_by,
                'created_date' => $date,
                'created_time' => $time
            );

            $this->eform_m->save_case($data_case);

            $data_user = array(
                'pcr_date' => $pcr_date_new,
                'flg_pcr_positive' => $flg_pcr_positive_new,
                'flg_quarantine' => $flg_quarantine_new,
                'modified_by' => $created_by,
                'modified_date' => $date,
                'modified_time' => $time
            );

            $id_user = array(
                'npk' => $npk
            );
        
            $this->eform_m->update_user($data_user, $id_user);
        }else{
            $case_no = $this->eform_m->get_last_case_no_by_npk($npk);

            if($pcr_date == $pcr_date_new && $flg_pcr_positive == $flg_pcr_positive_new){
                $data_case = array(
                    'flg_quarantine' => $flg_quarantine_new,
                    'modified_by' => $created_by,
                    'modified_date' => $date,
                    'modified_time' => $time
                );
        
                $id_case = array(
                    'npk' => $npk,
                    'case_no' => $case_no
                );

                $this->eform_m->update_case($data_case, $id_case);

                $data_user = array(
                    'flg_quarantine' => $flg_quarantine_new,
                    'modified_by' => $created_by,
                    'modified_date' => $date,
                    'modified_time' => $time
                );

                $id_user = array(
                    'npk' => $npk
                );
        
                $this->eform_m->update_user($data_user, $id_user);

            }else{
                $pcr_count = $this->eform_m->get_last_pcr_by_case_npk($case_no, $npk) + 1;

                if($flg_pcr_positive_new == 0){
                    $flg_quarantine_new = 0;
                }

                $data_case = array(
                    'npk' => $npk,
                    'pcr_count' => $pcr_count,
                    'case_no' => $case_no,
                    'pcr_date' => $pcr_date_new,
                    'flg_pcr_positive' => $flg_pcr_positive_new,
                    'flg_quarantine' => $flg_quarantine_new,
                    'created_by' => $created_by,
                    'created_date' => $date,
                    'created_time' => $time
                );

                $this->eform_m->save_case($data_case);

                $data_user = array(
                    'pcr_date' => $pcr_date_new,
                    'flg_pcr_positive' => $flg_pcr_positive_new,
                    'flg_quarantine' => $flg_quarantine_new,
                    'modified_by' => $created_by,
                    'modified_date' => $date,
                    'modified_time' => $time
                );

                $id_user = array(
                    'npk' => $npk
                );
        
                $this->eform_m->update_user($data_user, $id_user);

            }

        }

        redirect('covid/covid_c/manage_data_covid/'.$group_id.'/'.$msg =2);
    }

    function get_detail_user(){
        $npk = $this->input->post("npk");

        $data_user = $this->eform_m->get_data_user($npk);
        
        $non = '';
        $iso = '';
        $hos = '';
        $flg_qua = '';
       
        if($data_user->flg_quarantine == 1){
            $iso = 'selected';
        }
        if($data_user->flg_quarantine == 2){
            $hos = 'selected';
        }

        $flg_qua .="<option ".$iso." value='1'>Self Isolation</option><option ".$hos." value='2'>Hospitalized</option>";

        $json_data = array(
            'npk' => $data_user->npk,
            'username' => $data_user->username,
            'group_id' => $data_user->group_id,
            'vaccine1' => $data_user->vaccine1_date_format,
            'vaccine2' => $data_user->vaccine2_date_format,
            'flg_pcr_positive' => $data_user->flg_pcr_positive,
            'flg_quarantine' => $data_user->flg_quarantine,
            'flg_qua' => $flg_qua,
            'pcr_date' => $data_user->pcr_date_format
        );

        echo json_encode($json_data);
    }

    function get_detail_case(){
        $npk = $this->input->post("npk");
        $case_detail = $this->eform_m->get_all_case_by_user($npk);
        $data = "";
        $i = 1;
        foreach ($case_detail as $isi) {
            $data .= "<tr class='gradeX'>";
            $data .= "<td style='text-align:center;'>$i</td>";
            $data .= "<td style='text-align:center;'>" . $isi->case_no . "</td>";
            $data .= "<td style='text-align:center;'>" . $isi->pcr_date_format . "</td>";
            $data .= "<td style='text-align:center;'>" . $isi->flg_pcr_positive . "</td>";
            $data .= "<td style='text-align:center;'>" . $isi->flg_quarantine . "</td>";
            $data .= "</tr>";
            
            $i++;
        }

        echo $data;
    }

}