<?php

class invoice_c extends CI_Controller {

    private $layout = '/template/head';
    private $back_to_manage = 'portal/calendar_c/index/';

    public function __construct() {
        parent::__construct();
        $this->load->model('evita/invoice_m');
        $this->load->model('basis/role_module_m');
    }

    function confirm($msg = NULL) {
        $this->role_module_m->authorization('27');
        if ($msg <> "") {
            $msg = $msg;
        } else {
            $msg = "";
        }

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(27);
        $data['news'] = null;


        $data['title'] = 'Invoicing';
        $data['msg'] = $msg;
        $data['content'] = 'evita/confirm_invoice_v';
        $this->load->view($this->layout, $data);
    }
    
    public function scan_invoice($x = null) {
        //$this->cek_session();
        $session = $this->session->all_userdata();
        
        if ($x == NULL) {
            $x = trim($this->input->post('APNO'));
        }
        
        if (strpos($x, "-") != "") {
            $i = explode('-', $x);
        }elseif (strpos($x, "/") != "") {
            $i = explode('/', $x);
        }else{
            //$this->confirm("");
	    }
        
        if (!$this->invoice_m->cek_apno($i[0], $i[1])) {
            $this->confirm('<div class="alert alert-info ">
        AP No ' . $i[0] .'/'. $i[1] . ' doesn\'t exist.</div>');
        } else if (!$this->invoice_m->cek_apno_del($i[0], $i[1])) {
            $this->confirm('<div class="alert alert-info ">
        AP No ' . $i[0] .'/'. $i[1] . ' already deleted</div>');
        }  else {
            $user_session = $this->session->all_userdata();

            $row = $this->invoice_m->get_data($i[0], $i[1])->row();
            $disable = NULL;

            if (trim($row->TGLTRM) == NULL) {
                $now = date('d M, Y');
                //$this->login_model->clear_unconfirm_invoice();
            } else {
                $now = $row->TGLTRM;
                $disable = 'disabled="true"';
            }
            $tmp_minggu = $this->tempo_mingguan();
            $tmp_bulan = $this->tempo_bulanan();
            $tmp_30h = $this->tempo_30_hari();
            $tmp = $tmp_minggu;
            if ($row->TGLJTTEMPO != NULL) {
                $tmp = $row->TGLJTTEMPO;
            }

            $row_sup = $this->invoice_m->get_acc_info($row->KODESUP);
            $data_invoice['data'] = $row;
            $data_invoice['active'] = 'scan';
            $data_invoice['header'] = 'Invoice Preview';
            $data_invoice['title'] = 'Invoice Preview';
            $data_invoice['now'] = $now;
            $data_invoice['disable'] = $disable;
            $data_invoice['tempo'] = $tmp;
            $data_invoice['tempo_minggu'] = $tmp_minggu;
            $data_invoice['tempo_bulan'] = $tmp_bulan;
            $data_invoice['tempo_30d'] = $tmp_30h;
            $data_invoice['user'] = $session['NPK'];
            $data_invoice['bank'] = $row_sup->BANK;
            $data_invoice['acno'] = $row_sup->ACNO;
            $data_invoice['namaac'] = $row_sup->NAMAAC;
            $data_invoice['namasup'] = $row_sup->NAMASUP;

            // $data_invoice['herizal'] = $row;
            // $data_invoice['herizal'] = 'scan';
            // $data_invoice['herizal'] = 'Invoice Preview';
            // $data_invoice['herizal'] = 'Invoice Preview';
            // $data_invoice['herizal'] = $now;
            // $data_invoice['herizal'] = $disable;
            // $data_invoice['herizal'] = $tmp;
            // $data_invoice['herizal'] = $tmp_minggu;
            // $data_invoice['herizal'] = $tmp_bulan;
            // $data_invoice['herizal'] = $tmp_30h;
            // $data_invoice['herizal'] = $session['NPK'];
            // $data_invoice['herizal'] = $row_sup->BANK;
            // $data_invoice['herizal'] = $row_sup->ACNO;
            // $data_invoice['herizal'] = $row_sup->NAMAAC;
            // $data_invoice['herizal'] = $row_sup->NAMASUP;

            //$data_invoice['content_tempo'] = '/cashier/tempo';
            //$data_invoice['content_tempo1'] = '/cashier/tempo1';
            //$data_invoice['content_tempo2'] = '/cashier/tempo2';
            //$data_invoice['content_tempo3'] = '/cashier/tempo3';

            $currency = $row->KD_CURRENCY;
            $hasil = $this->terbilang($row->AMOUNT);
            $cur = $this->invoice_m->get_currency_ind($currency);

            $data_invoice['terbilang'] = strtoupper($hasil) . ' ' . $cur;
            //$data_invoice['content'] = 'cashier/cashier_invoice_view';
            //$this->load->view('template/layout', $data_invoice);

            $this->role_module_m->authorization('27');
            $data_invoice['app'] = $this->role_module_m->get_app();
            $data_invoice['module'] = $this->role_module_m->get_module();
            $data_invoice['function'] = $this->role_module_m->get_function();
            $data_invoice['sidebar'] = $this->role_module_m->side_bar(27);
            $data_invoice['news'] = null;
            
            $msg = "";
            $data_invoice['title'] = 'View for Confirm Invoice';
            $data_invoice['msg'] = $msg;
            $data_invoice['content'] = 'evita/view_confirm_invoice_v';
            $this->load->view($this->layout, $data_invoice);
        
        }
    }

    function view_invoice($msg = NULL) {
        $this->role_module_m->authorization('60');
        if ($msg <> "") {
            $msg = $msg;
        } else {
            $msg = "";
        }

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(60);
        $data['news'] = null;


        $data['title'] = 'Manage ECI Category';
        $data['msg'] = $msg;
        $data['content'] = 'evita/view_invoice_v';
        $this->load->view($this->layout, $data);
    }
    
    function list_invoice($msg = NULL) {
        $this->role_module_m->authorization('60');
        if ($msg <> "") {
            $msg = $msg;
        } else {
            $msg = "";
        }
        
        
        $x = trim($this->input->post('APNO'));
       
        if (strpos($x, "-") != "") {
            $i = explode('-', $x);
        }elseif (strpos($x, "/") != "") {
            $i = explode('/', $x);
        }else{
            //$this->confirm("");
	    }
        
        if (!$this->invoice_m->cek_apno($i[0], $i[1])) {
            $this->view_invoice('<div class="alert alert-info ">
        AP No ' . $i[0] .'/'. $i[1] . ' doesn\'t exist.</div>');
        } else if (!$this->invoice_m->cek_apno_del($i[0], $i[1])) {
            $this->view_invoice('<div class="alert alert-info ">
        AP No ' . $i[0] .'/'. $i[1] . ' already deleted</div>');
        }  else {

            $data['app'] = $this->role_module_m->get_app();
            $data['module'] = $this->role_module_m->get_module();
            $data['function'] = $this->role_module_m->get_function();
            $data['sidebar'] = $this->role_module_m->side_bar(60);
            $data['sidebar'] = $this->role_module_m->side_bar(60);
        }
    }
    
    public function get_all_sup_on() {
        $row_sups = $this->invoice_m->find_supp();
        
        foreach($row_sups as $row_sup):
            $random = substr(md5(rand()), 0, 7);
        
            $data_update = array(
                        'KODESUP_SAP_PASS' => $random,
                        'PASS' => md5($random),
                );
            $this->invoice_m->update_supp_pass($data_update, trim($row_sup->KODESUP_SAP));

        endforeach;
    }
    
    public function get_all_sup_on_pass() {
        $row_sups = $this->invoice_m->find_supp_pass();
        
        foreach($row_sups as $row_sup):
            $pass = substr(($row_sup->KODESUP_SAP_PASS), 0, 7);
        
            $data_update = array(
                        //'KODESUP_SAP_PASS' => $random,
                        'PASS' => md5($pass),
                );
            $this->invoice_m->update_supp_pass($data_update, trim($row_sup->KODESUP_SAP));

        endforeach;
    }
    
    public function view_detail_invoice($x = null) {
        //$this->cek_session();
        $session = $this->session->all_userdata();
        
        if ($x == NULL) {
            $x = trim($this->input->post('APNO'));
        }
        
        if (strpos($x, "-") != "") {
            $i = explode('-', $x);
        }elseif (strpos($x, "/") != "") {
            $i = explode('/', $x);
        }else{
            //$this->confirm("");
	    }

        $user_session = $this->session->all_userdata();

        $row = $this->invoice_m->get_data($i[0],$i[1])->row();
        $disable = NULL;

        if (trim($row->TGLTRM) == NULL) {
            $now = date('d M, Y');
            //$this->login_model->clear_unconfirm_invoice();
        } else {
            $now = $row->TGLTRM;
            $disable = 'disabled="true"';
        }
        $tmp_minggu = $this->tempo_mingguan();
        $tmp_bulan = $this->tempo_bulanan();
        $tmp_30h = $this->tempo_30_hari();
        $tmp = $tmp_minggu;
        if ($row->TGLJTTEMPO != NULL) {
            $tmp = $row->TGLJTTEMPO;
        }

        $row_sup = $this->invoice_m->get_acc_info($row->KODESUP);
        $data_invoice['data'] = $row;
        $data_invoice['active'] = 'scan';
        $data_invoice['header'] = 'Invoice Preview';
        $data_invoice['title'] = 'Invoice Preview';
        $data_invoice['now'] = $now;
        $data_invoice['disable'] = $disable;
        $data_invoice['tempo'] = $tmp;
        $data_invoice['tempo_minggu'] = $tmp_minggu;
        $data_invoice['tempo_bulan'] = $tmp_bulan;
        $data_invoice['tempo_30d'] = $tmp_30h;
        $data_invoice['user'] = $session['NPK'];
        $data_invoice['bank'] = $row_sup->BANK;
        $data_invoice['acno'] = $row_sup->ACNO;
        $data_invoice['namaac'] = $row_sup->NAMAAC;
        $data_invoice['namasup'] = $row_sup->NAMASUP;

        //$data_invoice['content_tempo'] = '/cashier/tempo';

        //$data_invoice['content_tempo1'] = '/cashier/tempo1';
        //$data_invoice['content_tempo2'] = '/cashier/tempo2';
        //$data_invoice['content_tempo3'] = '/cashier/tempo3';

        $currency = $row->KD_CURRENCY;
        $hasil = $this->terbilang($row->AMOUNT);
        $cur = $this->invoice_m->get_currency_ind($currency);

        $data_invoice['terbilang'] = strtoupper($hasil) . ' ' . $cur;
        //$data_invoice['content'] = 'cashier/cashier_invoice_view';
        //$this->load->view('template/layout', $data_invoice);


        $this->role_module_m->authorization('60');
        $data_invoice['app'] = $this->role_module_m->get_app();
        $data_invoice['module'] = $this->role_module_m->get_module();
        $data_invoice['function'] = $this->role_module_m->get_function();
        $data_invoice['sidebar'] = $this->role_module_m->side_bar(60);
        $data_invoice['news'] = null;

        $msg = "";
        $data_invoice['title'] = 'View for Detail Invoice';
        $data_invoice['msg'] = $msg;
        //$data['data'] = $this->calendar_m->find_trans("*","");
        $data_invoice['content'] = 'evita/view_detail_invoice_v';
        $this->load->view($this->layout, $data_invoice);

        
    }
    
    public function due_date($APNO) {
        $session = $this->session->all_userdata();
        
        if (strpos($APNO, "-") != "") {
            $i = explode('-', $APNO);
        }elseif (strpos($APNO, "/") != "") {
            $i = explode('/', $APNO);
        }else{
            //$this->confirm("");
	    }
        
        $jt_tempo = $this->input->post('jt_tempo');
        $date = date('m/d/Y', strtotime($jt_tempo));
        if ($jt_tempo == '') {
            
        } else {

            //$user_session = $this->session->all_userdata();
            $data = array(
                'OPERATOR1' => $session['NPK'],
                'TGLJTTEMPO' => $jt_tempo
            );
            $this->invoice_m->update($data, $i[0], $i[1]);
            echo $date;
        }
    }
    
    public function due_date2($APNO) {
        $session = $this->session->all_userdata();
        
        if (strpos($APNO, "-") != "") {
            $i = explode('-', $APNO);
        }elseif (strpos($APNO, "/") != "") {
            $i = explode('/', $APNO);
        }else{
            //$this->confirm("");
	    }
        
        $TGLJTTEMPO = $this->input->post('TGLJTTEMPO');
        $date = date('m/d/Y', strtotime($TGLJTTEMPO));

        if ($TGLJTTEMPO == '') {
            
        } else {

            $user_session = $this->session->all_userdata();
            $data = array(
                'OPERATOR1' => $session['NPK'],
                'TGLJTTEMPO' => date('Ymd', strtotime($TGLJTTEMPO))
            );
            $this->invoice_model->update($data, $i[0], $i[1]);
            echo $date;
        }
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
        $data['news'] = null;

        $this->load->view($this->layout, $data);
    }

    function create_calendar() {
        $this->role_module_m->authorization('58');
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(58);
        $data['news'] = null;

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
        $data['news'] = null;

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
            redirect($this->back_to_manage . $msg = 2);
        }
    }

    function delete_calendar($id) {
        $this->role_module_m->authorization('58');
        

        $this->calendar_m->delete_trans(" CHR_DATE = '".$id."'");
            
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
    
    
    public function tempo_mingguan() {
        $now = date('Ymd');
        $tmp = date('Ymd', strtotime($now . " + 14 days"));
        $x = date('D', strtotime($now . " + 14 days"));
        switch ($x) {
            case 'Thu':$i = 0;
                break;
            case 'Fri':$i = 6;
                break;
            case 'Sat':$i = 5;
                break;
            case 'Sun':$i = 4;
                break;
            case 'Mon':$i = 3;
                break;
            case 'Tue':$i = 2;
                break;
            case 'Wed':$i = 1;
                break;
            default:
                break;
        }
        $tmp = date('Ymd', strtotime($tmp . " + " . $i . " days"));
        return $tmp;
    }

    public function tempo_30_hari() {
        $now = date('Ymd');
        $tmp = date('Ymd', strtotime($now . " + 30 days"));
        $x = date('D', strtotime($now . " + 30 days"));
        switch ($x) {
            case 'Thu':$i = 0;
                break;
            case 'Fri':$i = 6;
                break;
            case 'Sat':$i = 5;
                break;
            case 'Sun':$i = 4;
                break;
            case 'Mon':$i = 3;
                break;
            case 'Tue':$i = 2;
                break;
            case 'Wed':$i = 1;
                break;
            default:
                break;
        }
        $tmp = date('Ymd', strtotime($tmp . " + " . $i . " days"));

        return $tmp;
    }

    public function tempo_bulanan() {
        $now = date('d');
        if ($now <= 25) {
            $tmp = date('Ym', strtotime(date('Ymd') . " + 1 month"));
        } else {
            $tmp = date('Ym', strtotime(date('Ymd') . " + 2 month"));
        }
        $tmp = $tmp . '25';
        return $tmp;
    }
    
    function terbilang($x) {

        $x = number_format($x, 0, "", ".");

        $pecah = explode(".", $x);
        $string = "";
        for ($i = 0; $i <= count($pecah) - 1; $i++) {

            if ((count($pecah) - $i == 5) && ($pecah[$i] != 0))
                $string .= $this->bilangRatusan($pecah[$i]) . "triliyun ";

            else if ((count($pecah) - $i == 4) && ($pecah[$i] != 0))
                $string .= $this->bilangRatusan($pecah[$i]) . "milyar ";

            else if ((count($pecah) - $i == 3) && ($pecah[$i] != 0))
                $string .= $this->bilangRatusan($pecah[$i]) . "juta ";

            else if ((count($pecah) - $i == 2) && ($pecah[$i] == 1))
                $string .= "seribu ";

            else if ((count($pecah) - $i == 2) && ($pecah[$i] != 0))
                $string .= $this->bilangRatusan($pecah[$i]) . "ribu ";

            else if ((count($pecah) - $i == 1) && ($pecah[$i] != 0))
                $string .= $this->bilangRatusan($pecah[$i]);
        }
        return $string;
    }
    
    function bilangRatusan($x) {

        $kata = array('', 'satu ', 'dua ', 'tiga ', 'empat ', 'lima ', 'enam ', 'tujuh ', 'delapan ', 'sembilan ');
        $string = '';

        $ratusan = floor($x / 100);

        $x = $x % 100;

        if ($ratusan > 1)
            $string .= $kata[$ratusan] . "ratus ";

        else if ($ratusan == 1)
            $string .= "seratus ";
        $puluhan = floor($x / 10);

        $x = $x % 10;

        if ($puluhan > 1) {

            $string .= $kata[$puluhan] . "puluh ";

            $string .= $kata[$x];
        } else if (($puluhan == 1) && ($x > 0))
            $string .= $kata[$x] . "belas ";

        else if (($puluhan == 1) && ($x == 0))
            $string .= $kata[$x] . "sepuluh ";

        else if ($puluhan == 0)
            $string .= $kata[$x];

        return $string;
    }
    
    
    public function cashier_confirm() {
        //$this->cek_session();
        $session = $this->session->all_userdata();
        $APNO = $this->input->post("APNO");
        $YEAR = $this->input->post("YEAR");
        //echo $APNO."#".$YEAR;exit();
        
        $row = $this->invoice_m->get_data($APNO, $YEAR)->row();
        if ($row->TGLTRM == NULL) {
            $now = date('d M, Y');
        } else {
            $now = $row->TGLTRM;
        }
        
        $TGLJTTEMPO = $this->input->post("TGLJTTEMPO");

        $user_session = $this->session->all_userdata();
        $data = array(
            'TGLTRM' => date("Ymd", strtotime($now)),
            'TGLJTTEMPO' => date("Ymd", strtotime($TGLJTTEMPO)),
            'OPERATOR1' => $session['NPK']
        );
        $this->invoice_m->update($data, $APNO, $YEAR);
//        $this->cashier_download_invoice($APNO);

        $this->pdf2($APNO, $YEAR);
    }

    public function reject($APNO) {
        //$this->cek_session();
        
        
        
        $session = $this->session->all_userdata();
        $i = explode('-', $APNO);
        $row = $this->invoice_m->get_data($i[0], $i[1])->row();
        $data_supp =  $this->invoice_m->get_acc_info($row->KODESUP);

        //$user_session = $this->session->all_userdata();
        $data = array(
            'FLG_DELETE' => '1',
            'KET' => 'Reject by Cashier AII'
        );
        $this->invoice_m->update($data, $i[0], $i[1]);
//        $this->cashier_download_invoice($APNO);

       // $this->pdf2($APNO);
	   
	 //  $this->scan_invoice($i[0] .'-'. $i[1]);
        redirect('http://192.168.0.229/Evita/index.php/profile/mail3/'.($data_supp->NAMASUP).'/'.$APNO.'/'.(str_replace("@","-_-",$data_supp->EMAILSUP)).'');
    }
    
    public function reject_by_user($APNO) {
        //$this->cek_session();
        $session = $this->session->all_userdata();
        $i = explode('-', $APNO);
        $row = $this->invoice_m->get_data($i[0], $i[1])->row();
        $data_supp =  $this->invoice_m->get_acc_info($row->KODESUP);

        //$user_session = $this->session->all_userdata();
        $data = array(
            'FLG_DELETE' => '1',
            'KET' => 'Reject by Cashier AII'
        );
        $this->invoice_m->update($data, $i[0], $i[1]);
//        $this->cashier_download_invoice($APNO);

       // $this->pdf2($APNO);
	   
	   //$this->view_invoice("<div class= 'alert alert-info'> AP No $i[0]/$i[1] already deleted</div>");
           //redirect('http://192.168.0.229/Evita/index.php/profile/mail4/RUDI/'.$APNO.'/rudi.yanto-_-aisin-indonesia.co.id');
            redirect('http://192.168.0.229/Evita/index.php/profile/mail4/'.($data_supp->NAMASUP).'/'.$APNO.'/'.(str_replace("@","-_-",$data_supp->EMAILSUP)).'');
        
    }
	
    public function reprint($APNO) {
        //$this->cek_session();
        $session = $this->session->all_userdata();
        
        $i = explode('-', $APNO);
        
        $row = $this->invoice_m->get_pdf_redownload_cashier($i[0], $i[1])->row();
        $reprint = 1;
        if (trim($row->PDF_REDOWNLOAD_KASIR) != NULL) {
            $reprint = $row->PDF_REDOWNLOAD_KASIR + 1;
        }
        $data = array(
            'PDF_REDOWNLOAD_KASIR' => $reprint
        );
        $this->invoice_m->update($data, $i[0], $i[1]);
//        $this->cashier_download_invoice($APNO);

        $this->pdf2($i[0], $i[1]);
    }
    
    public function reprint_all($APNO) {
        //$this->cek_session();
        $session = $this->session->all_userdata();
        
        $i = explode('-', $APNO);
        
        $row = $this->invoice_m->get_pdf_redownload_cashier($i[0], $i[1])->row();
        $reprint = 1;
        if (trim($row->PDF_REDOWNLOAD_KASIR) != NULL) {
            $reprint = $row->PDF_REDOWNLOAD_KASIR + 1;
        }
        $data = array(
            'PDF_REDOWNLOAD_KASIR' => $reprint
        );
        $this->invoice_m->update($data, $i[0], $i[1]);
//        $this->cashier_download_invoice($APNO);

        $this->pdf($i[0], $i[1]);
    }
    

    public function pdf($apno, $year) {
        //$this->cek_session();
        //$apno = (base64_decode(str_replace('-', '=', str_replace('_', '/', $apno))));
		
        //$APNO_lama = (base64_decode(str_replace('-', '=', str_replace('_', '/', $apno))));

        //$APNO_ex = explode('#',$APNO_lama);

        $apno = $apno;
        $YEAR =  $year;

		
        $this->load->library('fpdf17/fpdf');
        $session = $this->session->all_userdata();
        //    $this->load->library('code39');

        define('FPDF_FONTPATH', $this->config->item('fonts_path'));

        $data = $this->invoice_m->get_data($apno, $YEAR)->row();
        $data_sup = $this->invoice_m->get_acc_info($data->KODESUP);
        //$user_session = $this->session->all_userdata();
        $data_pdf = $this->invoice_m->get_pdf_download($apno, $YEAR);
        $down = 1;

        $cur = $this->invoice_m->get_currency_ind($data->KD_CURRENCY);
        $terbilang = strtoupper($this->terbilang($data->AMOUNT)) . ' ' . strtoupper($cur);

        setlocale(LC_MONETARY, 'it_IT');

        $this->fpdf->Open();
        $pdf = new FPDF("P", "cm", "A4");
        $pdf->AliasNbPages();
        $pdf->AddPage();

        $pdf->SetDrawColor(0);


        $pdf->Ln();
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(5, 0.5, 'PT AISIN INDONESIA', 0, 0, 'L');
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(3, 0.5, '', 0, 0, 'L');
        $pdf->Cell(3, 0.7, 'Invoice Receipt', 0, 0, 'L');


        $pdf->Code39(14, 1, $apno."-".$YEAR);
        $pdf->Code39(14, 15, $apno."-".$YEAR);
//        $image = base_url('assets/img/av1_1.jpg');
        //redirect($image);
        //$pdf->Image($image, 15, 1);

        $pdf->SetFont('Arial', '', 10);
        $pdf->Ln();

        $pdf->Cell(10, 0.5, 'EJIP Industrial Park Plot 5J', 0, 0, 'L');
        $pdf->Ln();
        $pdf->Cell(10, 0.5, 'Lemahabang Bekasi', 0, 0, 'L');

        $pdf->Ln(1);
        $pdf->Cell(2, 0.5, 'No. AP', 0, 0, 'L');
        $pdf->Cell(6, 0.5, ': ' . $data->APNO . '/' . $YEAR , 0, 0, 'L');
        $pdf->Ln();
        $pdf->Cell(2, 0.5, 'Supplier', 0, 0, 'L');
        $pdf->Cell(12, 0.5, ': ' . $data_sup->NAMASUP, 0, 0, 'L');
        //$pdf->Cell(5, 0.5, 'Date : 12 Feb, 2012', 1, 0, 'R');

        $pdf->Cell(5, 0.5, 'Date : ' . date('d M, Y', strtotime($data->TGLTRM)), 0, 0, 'R');
        
        $pdf->Ln(1);
        $pdf->Cell(1, 0.7, 'No.', 1, 0, 'C');
        $pdf->Cell(4, 0.7, 'Invoice', 1, 0, 'C');
        $pdf->Cell(3, 0.7, 'Invoice Date', 1, 0, 'C');
        $pdf->Cell(7, 0.7, 'Information', 1, 0, 'C');
        $pdf->Cell(4, 0.7, 'Amount', 1, 0, 'C');
        $pdf->Ln();


        $pdf->Cell(1, 0.7, '1.', 'L', 0, 'C');
        $pdf->Cell(4, 0.7, $data->INVNO, 'L', 0, 'L');
        $pdf->Cell(3, 0.7, date('d M, Y', strtotime($data->TGLINV)), 'L', 0, 'C');
        $pdf->Cell(7, 0.7, $data->KET, 'L', 0, 'L');
        $pdf->Cell(1, 0.7, $data->KD_CURRENCY, 'L', 0, 'L');
        $pdf->Cell(3, 0.7, number_format($data->AMOUNT), 'R', 0, 'R');
        $pdf->Ln();
        $pdf->Cell(1, 0.5, '', 'LB', 0, 'T');
        $pdf->Cell(4, 0.5, '', 'LB', 0, 'T');
        $pdf->Cell(3, 0.5, '', 'LB', 0, 'T');
        $pdf->Cell(7, 0.5, '', 'LB', 0, 'T');
        $pdf->Cell(1, 0.5, '', 'LB', 0, 'T');
        $pdf->Cell(3, 0.5, '', 'RB', 0, 'T');
        $pdf->Ln();
        $pdf->Cell(15, 0.7, 'Total :', 'LB', 0, 'R');
        $pdf->Cell(1, 0.7, $data->KD_CURRENCY, 'LB', 0, 'L');
        $pdf->Cell(3, 0.7, number_format($data->AMOUNT), 'RB', 0, 'R');

        $pdf->Ln(1);
        $pdf->Cell(4, 0.5, 'Amount in words :', 0, 0, 'L');
        $pdf->Ln();
        $pdf->MultiCell(18, 0.5, $terbilang, 0, 'L');

        $pdf->Ln();

        $pdf->Cell(3, 0.7, 'Deliver by', 1, 0, 'C');
        $pdf->Cell(3, 0.7, 'Accepted by', 1, 0, 'C');
        
        $pdf->Cell(0.5, 0.7, '', 0, 0, 'C');
        $pdf->Cell(2, 0.7, 'Bank', 0, 0, 'L');
        $pdf->Cell(0.5, 0.7, ':', 0, 0, 'C');
        $pdf->Cell(6, 0.7, $data_sup->BANK, 0, 0, 'L');
        //$pdf->Cell(4, 0.7, '_________, 12 Feb 2014', 0, 0, 'R');
        
        $pdf->Cell(4, 0.7, '_________, ' . date('d M, Y', strtotime($data->TGLTRM)), 0, 0, 'R');
        
        $pdf->Ln();
        $pdf->Cell(3, 0.7, '', 'LR', 0, 'C');
        $pdf->Cell(3, 0.7, '', 'LR', 0, 'C');
        $pdf->Cell(0.5, 0.7, '', 0, 0, 'C');
        $pdf->Cell(2, 0.7, 'Acc. No', 0, 0, 'L');
        $pdf->Cell(0.5, 0.7, ':', 0, 0, 'C');
        $pdf->Cell(5, 0.7, $data_sup->ACNO, 0, 0, 'L');
        
        
        $pdf->Ln();
        $pdf->Cell(3, 0.7, '', 'LR', 0, 'C');
        $pdf->Cell(3, 0.7, '', 'LR', 0, 'C');
        $pdf->Cell(0.5, 0.7, '', 0, 0, 'C');
        $pdf->Cell(2, 0.7, 'Acc. Name', 0, 0, 'L');
        $pdf->Cell(0.5, 0.7, ':', 0, 0, 'C');
        $pdf->Cell(7.4, 0.7, $data_sup->NAMAAC, 0, 0, 'L');
        //$pdf->Cell(2.6, 0.7, '', 0, 0, 'L');
        
        $pdf->Cell(2.6, 0.7, '( ' . $data->KD_CURRENCY . ' )', 0, 0, 'L');
        $pdf->Ln();
        $pdf->Cell(3, 0.7, '', 1, 0, 'C');
        $pdf->Cell(3, 0.7, trim($session['USERNAME']), 1, 0, 'C');
        //$pdf->Cell(3, 0.7, , 0, 0, 'C');
        
        $pdf->Ln();
        $pdf->Cell(19, 0.7, 'Note :', 0, 0, 'C');
        $pdf->Ln();
        $pdf->Cell(19, 0.7, 'Payment due date : ' . date('d M, Y', strtotime($data->TGLJTTEMPO)), 0, 0, 'C');

       // $pdf->Ln();
//        $pdf->Cell(19, 0.7, 'Note :', 0, 0, 'C');
       // $pdf->Ln();
        //$pdf->Cell(19, 0.7, 'Payment due date : ', 0, 0, 'C');

        

        $pdf->Ln(2.5);
        $pdf->Line(1, 14, 19, 14);
        //$pdf->Line(1, 14, 19, 14);



        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(5, 0.5, 'PT AISIN INDONESIA', 0, 0, 'L');
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(3, 0.5, '', 0, 0, 'L');
        $pdf->Cell(3, 0.7, 'Invoice Receipt', 0, 0, 'L');
        //barcode

        $pdf->SetFont('Arial', '', 10);
        $pdf->Ln();
        $pdf->Cell(10, 0.5, 'EJIP Industrial Park Plot 5J', 0, 0, 'L');
        $pdf->Ln();
        $pdf->Cell(10, 0.5, 'Lemahabang Bekasi', 0, 0, 'L');
        $pdf->Ln(1);
        $pdf->Cell(2, 0.5, 'No. AP', 0, 0, 'L');
        $pdf->Cell(6, 0.5, ': ' . $data->APNO . '/' . date('y'), 0, 0, 'L');
        $pdf->Ln();
        $pdf->Cell(2, 0.5, 'Supplier', 0, 0, 'L');
        $pdf->Cell(12, 0.5, ': ' . $data_sup->NAMASUP, 0, 0, 'L');
        //$pdf->Cell(5, 0.5, 'Date : 12 Feb, 2012', 1, 0, 'R');
        $pdf->Cell(5, 0.5, 'Date : ' . date('d M, Y', strtotime($data->TGLTRM)), 0, 0, 'R');

        $pdf->Ln(1);
        $pdf->Cell(1, 0.7, 'No.', 1, 0, 'C');
        $pdf->Cell(4, 0.7, 'Invoice', 1, 0, 'C');
        $pdf->Cell(3, 0.7, 'Invoice Date', 1, 0, 'C');
        $pdf->Cell(7, 0.7, 'Information', 1, 0, 'C');
        $pdf->Cell(4, 0.7, 'Amount', 1, 0, 'C');
        $pdf->Ln();


        $pdf->Cell(1, 0.7, '1.', 'L', 0, 'C');
        $pdf->Cell(4, 0.7, $data->INVNO, 'L', 0, 'L');
        $pdf->Cell(3, 0.7, date('d M, Y', strtotime($data->TGLINV)), 'L', 0, 'C');
        $pdf->Cell(7, 0.7, $data->KET, 'L', 0, 'L');
        $pdf->Cell(1, 0.7, $data->KD_CURRENCY, 'L', 0, 'L');
        $pdf->Cell(3, 0.7, number_format($data->AMOUNT), 'R', 0, 'R');
        $pdf->Ln();
        $pdf->Cell(1, 0.5, '', 'LB', 0, 'T');
        $pdf->Cell(4, 0.5, '', 'LB', 0, 'T');
        $pdf->Cell(3, 0.5, '', 'LB', 0, 'T');
        $pdf->Cell(7, 0.5, '', 'LB', 0, 'T');
        $pdf->Cell(1, 0.5, '', 'LB', 0, 'T');
        $pdf->Cell(3, 0.5, '', 'RB', 0, 'T');
        $pdf->Ln();
        $pdf->Cell(15, 0.7, 'Total :', 'LB', 0, 'R');
        $pdf->Cell(1, 0.7, $data->KD_CURRENCY, 'LB', 0, 'L');
        $pdf->Cell(3, 0.7, number_format($data->AMOUNT), 'RB', 0, 'R');

        $pdf->Ln(1);
        $pdf->Cell(4, 0.5, 'Amount in words :', 0, 0, 'L');
        $pdf->Ln();
        $pdf->MultiCell(18, 0.5, $terbilang, 0, 'L');

        $pdf->Ln();

        $pdf->Cell(3, 0.7, 'Deliver by', 1, 0, 'C');
        $pdf->Cell(3, 0.7, 'Accepted by', 1, 0, 'C');
        //$pdf->Cell(3, 0.7, trim($session['USERNAME']), 0, 0, 'C');
        $pdf->Cell(0.5, 0.7, '', 0, 0, 'C');
        $pdf->Cell(2, 0.7, 'Bank', 0, 0, 'L');
        $pdf->Cell(0.5, 0.7, ':', 0, 0, 'C');
        $pdf->Cell(6, 0.7, $data_sup->BANK, 0, 0, 'L');
        //$pdf->Cell(4, 0.7, '_________, 12 Feb 2014', 0, 0, 'R');
        
        $pdf->Cell(4, 0.7, '_________, ' . date('d M, Y', strtotime($data->TGLTRM)), 0, 0, 'R');
        $pdf->Ln();
        $pdf->Cell(3, 0.7, '', 'LR', 0, 'C');
        $pdf->Cell(3, 0.7, '', 'LR', 0, 'C');
        $pdf->Cell(0.5, 0.7, '', 0, 0, 'C');
        $pdf->Cell(2, 0.7, 'Acc. No', 0, 0, 'L');
        $pdf->Cell(0.5, 0.7, ':', 0, 0, 'C');
        $pdf->Cell(5, 0.7, $data_sup->ACNO, 0, 0, 'L');
        $pdf->Ln();
        $pdf->Cell(3, 0.7, '', 'LR', 0, 'C');
        $pdf->Cell(3, 0.7, '', 'LR', 0, 'C');
        $pdf->Cell(0.5, 0.7, '', 0, 0, 'C');
        $pdf->Cell(2, 0.7, 'Acc. Name', 0, 0, 'L');
        $pdf->Cell(0.5, 0.7, ':', 0, 0, 'C');
        $pdf->Cell(7.4, 0.7, $data_sup->NAMAAC, 0, 0, 'L');
        //$pdf->Cell(2.6, 0.7, '', 0, 0, 'L');
        
        $pdf->Cell(2.6, 0.7, '( ' . $data->KD_CURRENCY . ' )', 0, 0, 'L');
        $pdf->Ln();
        $pdf->Cell(3, 0.7, '', 1, 0, 'C');
        $pdf->Cell(3, 0.7, trim($session['USERNAME']), 1, 0, 'C');
        $pdf->Ln();
        $pdf->Cell(19, 0.7, 'Note :', 0, 0, 'C');
        $pdf->Ln();
        $pdf->Cell(19, 0.7, 'Payment due date : ' . date('d M, Y', strtotime($data->TGLJTTEMPO)), 0, 0, 'C');

        $filename = $data->APNO . '.pdf';
        $pdf->Output($filename, 'I');
    }
    

    public function pdf2($apno, $YEAR) {

        $this->load->library('fpdf17/fpdf');
        $session = $this->session->all_userdata();

        define('FPDF_FONTPATH', $this->config->item('fonts_path'));
        $user_session = $this->session->all_userdata();

        $data = $this->invoice_m->get_data($apno, $YEAR)->row();
        //data_sup = $this->invoice_m->get_supp_profile($data->KODESUP)->row();

        setlocale(LC_MONETARY, 'it_IT');

        $this->fpdf->Open();
        $pdf = new FPDF("P", "cm", "A4");
        $pdf->AliasNbPages();
        $pdf->AddPage();

        $pdf->SetDrawColor(0);


        $pdf->Ln();
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(5, 0.5, '', 0, 0, 'L');
        $pdf->SetFont('', 'B', 14);
        $pdf->Cell(3, 0.5, '', 0, 0, 'L');
        $pdf->Cell(3, 0.7, ' ', 0, 0, 'L');

        //$pdf->Image($image, 15, 5);

        $pdf->SetFont('Arial', '', 10);
        $pdf->Ln();

        $pdf->Cell(10, 0.5, '', 0, 0, 'L');
        $pdf->Ln();
        $pdf->Cell(10, 0.5, '', 0, 0, 'L');
        $pdf->Ln(1);
        $pdf->Cell(2, 0.5, '', 0, 0, 'L');
        $pdf->Cell(6, 0.5, ' ', 0, 0, 'L');
        $pdf->Ln();
        $pdf->Cell(2, 0.5, '', 0, 0, 'L');
        $pdf->Cell(12, 0.5, '', 0, 0, 'L');
        $pdf->Cell(5, 0.5, 'Date : ' . date('d M, Y', strtotime($data->TGLTRM)), 0, 0, 'R');

        $pdf->Ln(1);
        $pdf->Cell(1, 0.7, '', 0, 0, 'C');
        $pdf->Cell(4, 0.7, '', 0, 0, 'C');
        $pdf->Cell(3, 0.7, '', 0, 0, 'C');
        $pdf->Cell(7, 0.7, '', 0, 0, 'C');
        $pdf->Cell(4, 0.7, '', 0, 0, 'C');
        $pdf->Ln();


        $pdf->Cell(1, 0.7, '', 0, 0, 'C');
        $pdf->Cell(4, 0.7, '', 0, 0, 'L');
        $pdf->Cell(3, 0.7, '', 0, 0, 'C');
        $pdf->Cell(7, 0.7, '', 0, 0, 'L');
        $pdf->Cell(1, 0.7, '', 0, 0, 'L');
        $pdf->Cell(3, 0.7, '', 0, 0, 'R');
        $pdf->Ln();
        $pdf->Cell(1, 0.5, '', 0, 0, 'T');
        $pdf->Cell(4, 0.5, '', 0, 0, 'T');
        $pdf->Cell(3, 0.5, '', 0, 0, 'T');
        $pdf->Cell(7, 0.5, '', 0, 0, 'T');
        $pdf->Cell(1, 0.5, '', 0, 0, 'T');
        $pdf->Cell(3, 0.5, '', 0, 0, 'T');
        $pdf->Ln();
        $pdf->Cell(15, 0.7, '', 0, 0, 'R');
        $pdf->Cell(1, 0.7, '', 0, 0, 'L');
        $pdf->Cell(3, 0.7, '', 0, 0, 'R');

        $pdf->Ln(1);
        $pdf->Cell(4, 0.5, '', 0, 0, 'L');
        $pdf->Ln();
        $pdf->MultiCell(18, 0.5, '', 0, 'L');

        $pdf->Ln();

        $pdf->Cell(3, 0.7, '', 0, 0, 'C');
        $pdf->Cell(3, 0.7, ' ', 0, 0, 'C');
        $pdf->Cell(0.5, 0.7, '', 0, 0, 'C');
        $pdf->Cell(2, 0.7, '', 0, 0, 'L');
        $pdf->Cell(0.5, 0.7, '', 0, 0, 'C');
        $pdf->Cell(6, 0.7, '', 0, 0, 'L');
        $pdf->Cell(4, 0.7, '_________, ' . date('d M, Y', strtotime($data->TGLTRM)), 0, 0, 'R');

        $pdf->Ln();
        $pdf->Cell(3, 0.7, '', 0, 0, 'C');
        $pdf->Cell(3, 0.7, '', 0, 0, 'C');
        $pdf->Cell(0.5, 0.7, '', 0, 0, 'C');
        $pdf->Cell(2, 0.7, '', 0, 0, 'L');
        $pdf->Cell(0.5, 0.7, '', 0, 0, 'C');
        $pdf->Cell(5, 0.7, '', 0, 0, 'L');
        $pdf->Ln();
        $pdf->Cell(3, 0.7, '', 0, 0, 'C');
        $pdf->Cell(3, 0.7, '', 0, 0, 'C');
        $pdf->Cell(0.5, 0.7, '', 0, 0, 'C');
        $pdf->Cell(2, 0.7, '', 0, 0, 'L');
        $pdf->Cell(0.5, 0.7, '', 0, 0, 'C');
        $pdf->Cell(7.4, 0.7, '', 0, 0, 'L');
        $pdf->Cell(2.6, 0.7, '( ' . $data->KD_CURRENCY . ' )', 0, 0, 'L');
        $pdf->Ln();
        $pdf->Cell(3, 0.7, '', 0, 0, 'C');
        $pdf->Cell(3, 0.7, trim($session['USERNAME']), 0, 0, 'C');
        $pdf->Ln();
        $pdf->Cell(19, 0.7, 'Note :', 0, 0, 'C');
        $pdf->Ln();
        $pdf->Cell(19, 0.7, 'Payment due date : ' . date('d M, Y', strtotime($data->TGLJTTEMPO)), 0, 0, 'C');



        $pdf->Ln(2.5);
        $pdf->Line(1, 14, 19, 14);



        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(5, 0.5, '', 0, 0, 'L');
        $pdf->SetFont('', 'B', 14);
        $pdf->Cell(3, 0.5, '', 0, 0, 'L');
        $pdf->Cell(3, 0.7, ' ', 0, 0, 'L');

        //$pdf->Image($image, 15, 5);

        $pdf->SetFont('Arial', '', 10);
        $pdf->Ln();

        $pdf->Cell(10, 0.5, '', 0, 0, 'L');
        $pdf->Ln();
        $pdf->Cell(10, 0.5, '', 0, 0, 'L');
        $pdf->Ln(1);
        $pdf->Cell(2, 0.5, '', 0, 0, 'L');
        $pdf->Cell(6, 0.5, ' ', 0, 0, 'L');
        $pdf->Ln();
        $pdf->Cell(2, 0.5, '', 0, 0, 'L');
        $pdf->Cell(12, 0.5, '', 0, 0, 'L');
        $pdf->Cell(5, 0.5, 'Date : ' . date('d M, Y', strtotime($data->TGLTRM)), 0, 0, 'R');

        $pdf->Ln(1);
        $pdf->Cell(1, 0.7, '', 0, 0, 'C');
        $pdf->Cell(4, 0.7, '', 0, 0, 'C');
        $pdf->Cell(3, 0.7, '', 0, 0, 'C');
        $pdf->Cell(7, 0.7, '', 0, 0, 'C');
        $pdf->Cell(4, 0.7, '', 0, 0, 'C');
        $pdf->Ln();


        $pdf->Cell(1, 0.7, '', 0, 0, 'C');
        $pdf->Cell(4, 0.7, '', 0, 0, 'L');
        $pdf->Cell(3, 0.7, '', 0, 0, 'C');
        $pdf->Cell(7, 0.7, '', 0, 0, 'L');
        $pdf->Cell(1, 0.7, '', 0, 0, 'L');
        $pdf->Cell(3, 0.7, '', 0, 0, 'R');
        $pdf->Ln();
        $pdf->Cell(1, 0.5, '', 0, 0, 'T');
        $pdf->Cell(4, 0.5, '', 0, 0, 'T');
        $pdf->Cell(3, 0.5, '', 0, 0, 'T');
        $pdf->Cell(7, 0.5, '', 0, 0, 'T');
        $pdf->Cell(1, 0.5, '', 0, 0, 'T');
        $pdf->Cell(3, 0.5, '', 0, 0, 'T');
        $pdf->Ln();
        $pdf->Cell(15, 0.7, '', 0, 0, 'R');
        $pdf->Cell(1, 0.7, '', 0, 0, 'L');
        $pdf->Cell(3, 0.7, '', 0, 0, 'R');

        $pdf->Ln(1);
        $pdf->Cell(4, 0.5, '', 0, 0, 'L');
        $pdf->Ln();
        $pdf->MultiCell(18, 0.5, '', 0, 'L');

        $pdf->Ln();

        $pdf->Cell(3, 0.7, '', 0, 0, 'C');
        $pdf->Cell(3, 0.7, ' ', 0, 0, 'C');
        $pdf->Cell(0.5, 0.7, '', 0, 0, 'C');
        $pdf->Cell(2, 0.7, '', 0, 0, 'L');
        $pdf->Cell(0.5, 0.7, '', 0, 0, 'C');
        $pdf->Cell(6, 0.7, '', 0, 0, 'L');
        $pdf->Cell(4, 0.7, '_________, ' . date('d M, Y', strtotime($data->TGLTRM)), 0, 0, 'R');

        $pdf->Ln();
        $pdf->Cell(3, 0.7, '', 0, 0, 'C');
        $pdf->Cell(3, 0.7, '', 0, 0, 'C');
        $pdf->Cell(0.5, 0.7, '', 0, 0, 'C');
        $pdf->Cell(2, 0.7, '', 0, 0, 'L');
        $pdf->Cell(0.5, 0.7, '', 0, 0, 'C');
        $pdf->Cell(5, 0.7, '', 0, 0, 'L');
        $pdf->Ln();
        $pdf->Cell(3, 0.7, '', 0, 0, 'C');
        $pdf->Cell(3, 0.7, '', 0, 0, 'C');
        $pdf->Cell(0.5, 0.7, '', 0, 0, 'C');
        $pdf->Cell(2, 0.7, '', 0, 0, 'L');
        $pdf->Cell(0.5, 0.7, '', 0, 0, 'C');
        $pdf->Cell(7.4, 0.7, '', 0, 0, 'L');
        $pdf->Cell(2.6, 0.7, '( ' . $data->KD_CURRENCY . ' )', 0, 0, 'L');
        $pdf->Ln();
        $pdf->Cell(3, 0.7, '', 0, 0, 'C');
        $pdf->Cell(3, 0.7, trim($session['USERNAME']), 0, 0, 'C');
        $pdf->Ln();
        $pdf->Cell(19, 0.7, 'Note :', 0, 0, 'C');
        $pdf->Ln();
        $pdf->Cell(19, 0.7, 'Payment due date : ' . date('d M, Y', strtotime($data->TGLJTTEMPO)), 0, 0, 'C');

        $filename = $data->APNO . '/'. $YEAR .'_2.pdf';
        $pdf->Output($filename, 'I');
    }

}

?>
