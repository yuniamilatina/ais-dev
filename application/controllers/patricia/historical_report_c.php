<?php

//Add By xcx 20190507
class historical_report_c extends CI_Controller {

    private $layout = '/template/head';
    private $back_to_index = '/patricia/historical_report_c/index/';

    public function __construct() {
        parent::__construct();
        $this->load->model('patricia/historical_report_m');
    }

    function index($msg = NULL) {
        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Download success </strong>  The data is successfully downloaded </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Updating success </strong> The data is successfully updated </div >";
        }
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(78);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Historical Report';
        $data['data'] = $this->historical_report_m->get_historical();
        $data['msg'] = $msg;
        $date = date('Y') . date('m');
        $data['selected_date_awal'] = '';
        $data['selected_date_akhir'] = '';
        $data['selected_status'] = '';
        $data['content'] = 'patricia/report/historical_report_v';
        $this->load->view($this->layout, $data);
    }
    function search()
    {
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(78);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Historical Report';
        $data['msg'] = 0;
        $date1= date("Ymd", strtotime($this->input->post('tanggal_awal'))) ;
        $date2 = date("Ymd", strtotime($this->input->post('tanggal_akhir')));
        $status = $this->input->post('statusChecksheet');
        if($date1 == '19700101' && $date2 != '19700101')
        {

            $data['data'] = $this->historical_report_m->get_historical_by_date2($date2,$status);
        }
        else if($date1 != '19700101' && $date2 == '19700101')
        {
            $data['data'] = $this->historical_report_m->get_historical_by_date1($date1,$status);
        }
        else if($date1 == '19700101' && $date2 == '19700101')
        {
            $data['data'] = $this->historical_report_m->get_historical_by_status($status);   
        }
        else
        {
            $data['data'] = $this->historical_report_m->get_historical_by_date($date1,$date2,$status);    
        }
        
        $data['selected_date_awal'] = $this->input->post('tanggal_awal');
        $data['selected_status'] = $status;
        $data['selected_date_akhir'] = $this->input->post('tanggal_akhir');
        $data['content'] = 'patricia/report/historical_report_v';
        $this->load->view($this->layout, $data);
    }
    
}
?>