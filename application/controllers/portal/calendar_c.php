<?php

class calendar_c extends CI_Controller {

    private $layout = '/template/head';
    private $back_to_manage = 'portal/calendar_c/index/';

    public function __construct() {
        parent::__construct();
        $this->load->model('portal/calendar_m');
        //$this->load->model('budget/budgetcalendar_m');
        //$this->load->model('budget/budgettype_m');
        $this->load->model('basis/log_m');
        $this->load->model('basis/role_module_m');
        $this->load->model('portal/news_m');
        $this->load->model('portal/notification_m');
    }

    function index($msg = NULL) {
        $this->role_module_m->authorization('58');
        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Creating success </strong> The data is successfully created </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Updating success </strong> The data is successfully updated </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Deleted success </strong> The data is successfully deleted </div >";
        } elseif ($msg == 12) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Executing error !</strong> Something error with parameter </div >";
        } else {
            $msg = "";
        }

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(58);
        $data['news'] = $this->news_m->get_news();


        $data['title'] = 'Manage ECI Category';
        $data['msg'] = $msg;
        $data['data'] = $this->calendar_m->find_trans("*","");
        $data['content'] = 'portal/manage_calendar_v';
        $this->load->view($this->layout, $data);
    }

    //view by id
    function select_by_id($id) {
        $this->role_module_m->authorization('58');
        $data['data'] = $this->budgetcalendar_m->get_data($id)->row();
        $data['data_budgetsubcategory'] = $this->budgetsubcalendar_m->get_budgetsubcategory_by_budgetcategory($id);
        $data['content'] = 'budget/masterbudget/budgetcategory/view_budgetcategory_v';
        $data['title'] = 'View Budget Group';

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(58);
        $data['news'] = $this->news_m->get_news();

        $this->load->view($this->layout, $data);
    }

    function create_calendar() {
        $this->role_module_m->authorization('58');
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(58);
        $data['news'] = $this->news_m->get_news();

        //$data['data_budgettype'] = $this->calendar_m->get_budgettype();


        $data['title'] = 'Create Calendar';
        $data['content'] = 'portal/manage_calendar_v';

        $this->load->view($this->layout, $data);
    }

    function save_calendar() {
        //$this->form_validation->set_rules('CHR_CODE_CATEGORY', 'Id Category', 'required|min_length[5]|max_length[5]|callback_check_id|trim');
        $this->form_validation->set_rules('CHR_DATE', 'Category Desc', 'required');
        $this->form_validation->set_rules('CHR_CODE_DATE', 'Category Desc', 'required');
        $this->form_validation->set_rules('CHR_DESC', 'Category Desc', 'required');

        $id = $this->calendar_m->generate_id_category();
        $session = $this->session->all_userdata();

        if ($this->form_validation->run() == FALSE) {
            
            $this->index();
        } else {
            
            $date_post = substr($this->input->post('CHR_DATE'),6,4).substr($this->input->post('CHR_DATE'),3,2).substr($this->input->post('CHR_DATE'),0,2);
            
            $data = array(
                'CHR_DATE' => $date_post,
                'CHR_CODE_DATE' => $this->input->post('CHR_CODE_DATE'),
                'CHR_DESC' => $this->input->post('CHR_DESC'),
                'CHR_USR_ENTRY' => $session['NPK'],
                'CHR_DATE_ENTRY' => date('Ymd'),
                'CHR_TIME_ENTRY' => date('His')
            );
            $this->calendar_m->add_trans($data);
            //$this->log_m->add_log('3', $data['INT_ID_BUDGET_CATEGORY']);
            redirect($this->back_to_manage . $msg = 1);
        }
    }
    
    function generate_calendar() {

        $session = $this->session->all_userdata();

        $year_post = $this->input->post('YEAR');

        //$no = 0;
        $start = new DateTime(''.$year_post.'-01-01');
        $end   = new DateTime(''.($year_post + 1).'-01-01');
        $interval = DateInterval::createFromDateString('1 day');
        $period = new DatePeriod($start, $interval, $end);
        foreach ($period as $dt)
        {
            if ($dt->format('N') == 6)
            {
                $holiday = $this->calendar_m->find_trans('*', 'CHR_DATE = "' . $dt->format('Ymd') . '" ');

                if (empty($holiday)) {

                    $data = array(
                        'CHR_DATE' => $dt->format('Ymd'),
                        'CHR_CODE_DATE' => 'HS',
                        'CHR_DESC' => 'Hari Sabtu',
                        'CHR_USR_ENTRY' => $session['NPK'],
                        'CHR_DATE_ENTRY' => date('Ymd'),
                        'CHR_TIME_ENTRY' => date('His')
                    );

                    $this->calendar_m->add_trans($data);
                } 

            }

            if ($dt->format('N') == 7)
            {
               $holiday = $this->calendar_m->find_trans('*', 'CHR_DATE = "' . $dt->format('Ymd') . '" ');

                if (empty($holiday)) {

                    $data = array(
                        'CHR_DATE' => $dt->format('Ymd'),
                        'CHR_CODE_DATE' => 'HM',
                        'CHR_DESC' => 'Hari Minggu',
                        'CHR_USR_ENTRY' => $session['NPK'],
                        'CHR_DATE_ENTRY' => date('Ymd'),
                        'CHR_TIME_ENTRY' => date('His')
                    );

                    $this->calendar_m->add_trans($data);
                } 
            }

        }
        //echo $no;
        
        

        redirect($this->back_to_manage . $msg = 1);
     
    }
    

    //Checking Section 
    function check_id($id) {
        $return_value = $this->calendar_m->check_id($id);
        if ($return_value) {
            $this->form_validation->set_message('check_id', "Sorry, Your data Id already exists, please choose another one");
            return FALSE;
        } else {
            return TRUE;
        }
    }

    function edit_calendar($id) {
        $this->role_module_m->authorization('58');
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(58);
        $data['news'] = $this->news_m->get_news();

        $data['title'] = 'Edit ECI Category';
        $data['content'] = 'eci/category/edit_category_v';

        //$data['data'] = $this->calendar_m->get_data($id)->row();
        
        $data['data'] = $this->calendar_m->find_trans("*","CHR_DATE='".$id."'");
        

        $this->load->view($this->layout, $data);
    }

    function update_calendar() {
        $id = $this->input->post('CHR_ID_DATE');
        $session = $this->session->all_userdata();

        $this->form_validation->set_rules('CHR_DATE', 'Category Desc', 'required');
        $this->form_validation->set_rules('CHR_CODE_DATE', 'Category Desc', 'required');
        $this->form_validation->set_rules('CHR_DESC', 'Category Desc', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->index(12);
        } else {
            $data = array(
                
                'CHR_CODE_DATE' => $this->input->post('CHR_CODE_DATE'),
                'CHR_DESC' => $this->input->post('CHR_DESC'),
                'CHR_USR_UPDATE' => $session['NPK'],
                'CHR_DATE_UPDATE' => date('Ymd'),
                'CHR_TIME_UPDATE' => date('His'),
                
            );

            $this->calendar_m->update_trans($data, " CHR_DATE = '".trim($id)."'");
            //$this->log_m->add_log('4', $data['INT_ID_BUDGET_CATEGORY']);
            redirect($this->back_to_manage . $msg = 2);
        }
    }

    function delete_calendar($id) {
        $this->role_module_m->authorization('58');
        

        $this->calendar_m->delete_trans(" CHR_DATE = '".$id."'");
            
        //$this->calendar_m->delete($id);
        //$this->log_m->add_log('5', $id);
        redirect($this->back_to_manage . $msg = 3);
    }
    
    function getUpdate() {
        $data = "";

        $id_activity = $this->input->post("id_activity");
        $id_activity = trim($id_activity);

        $get_data = $this->calendar_m->find_trans("*","CHR_DATE = '".$id_activity."'");
        $data .= form_open('portal/calendar_c/update_calendar', 'class="form-horizontal"');
        $data .= '      
                        <input name="CHR_ID_DATE" class="form-control" required type="hidden" value="'.$get_data[0]->CHR_DATE .'">
                        
                        <div class="form-group dll">
                            <label class="col-sm-4 control-label">Due date</label>
                            <div class="col-sm-5">
                                <input name="CHR_DATE" id="datepicker" class="form-control" required type="text" readonly style="width: 140px;text-transform: uppercase;" value="'.substr($get_data[0]->CHR_DATE,6,2)."/".substr($get_data[0]->CHR_DATE,4,2)."/".substr($get_data[0]->CHR_DATE,0,4).'" >
                            </div>
                        </div>


                        
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Date Initial</label>
                            <div class="col-sm-5">
                              
                                    <select class="form-control" name="CHR_CODE_DATE" id="CHR_CODE_DATE" required style="width:220px;"> ';
                                    if (trim($get_data[0]->CHR_CODE_DATE) =="CB"){$select="SELECTED";}else{$select="";}
                                    $data .=   '<option value="CB" '.$select.'>CB - Cuti Bersama</option>';
                                    if (trim($get_data[0]->CHR_CODE_DATE) =="LN"){$select="SELECTED";}else{$select="";}
                                    $data .=   '<option value="LN" '.$select.'>LN - Libur Nasional</option>';
                                    if (trim($get_data[0]->CHR_CODE_DATE) =="HS"){$select="SELECTED";}else{$select="";}
                                    $data .=   '<option value="HS" '.$select.'>HS - Hari Sabtu</option>';
                                    if (trim($get_data[0]->CHR_CODE_DATE) =="HM"){$select="SELECTED";}else{$select="";}
                                    $data .=   '<option value="HM" '.$select.'>HM - Hari Minggu</option>';

                          $data .=   '          </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-4 control-label">Date Description</label>
                            <div class="col-sm-7">
                                <input name="CHR_DESC" class="form-control" maxlength="40" required type="text" value="'.trim($get_data[0]->CHR_DESC).'">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-5">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-primary" data-toggle="tooltip" data-placement="left" title="Update this data"><i class="fa fa-refresh"></i> Update</button>
                                 ';
        $data .= anchor('portal/calendar_c', 'Cancel', 'class="btn btn-default" data-placement="right" data-toggle="tooltip" title="Back to manage"'); 

        $data .= '                    </div>
                            </div>
                        </div> 

                               ';
        
         $data .=         form_close();
//echo "select * from TM_ECI_PIC where CHR_NPK='$npk'";
        echo $data;
    }

}

?>
