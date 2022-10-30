<?php

//Add By xcx 20190507
class measurement_device_c extends CI_Controller {

    private $layout = '/template/head';
    private $back_to_manage = '/patricia/measurement_device_c/index/';
    // private $back_to_index = '/patricia/alat_ukur_c';

    public function __construct() {
        parent::__construct();
        $this->load->model('organization/dept_m');
        $this->load->model('patricia/measurement_device_m');
        $this->load->model('prd/direct_backflush_general_m');
    }
    function index($msg = NULL) {
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(79);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Manage Measurement Device';
        $data['data'] = $this->measurement_device_m->get_device();
        $all_dvc_dept = $this->dept_m->get_all_dvc_dept();
        $data['all_dvc_dept'] = $all_dvc_dept;
        
        $data_work_center = $this->direct_backflush_general_m->get_all_work_center();
        $data['all_work_centers'] = $data_work_center;

        if ($msg == 1) {
                $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Creating success </strong> The data is successfully created </div >";
            } elseif ($msg == 2) {
                $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Updating success </strong> The data is successfully updated </div >";
            } elseif ($msg == 3) {
                $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Deleted success </strong> The data is successfully deleted </div >";
            } elseif ($msg == 4) {
                $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button>Data Already in Database</div >";
            } elseif ($msg == 12) {
                $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Executing error !</strong> Something error with parameter </div >";
            }
        $data['msg'] = $msg;
        $data['content'] = 'patricia/measurement_device/manage_measurement_device_v';
        $this->load->view($this->layout, $data);
    }
    function delete($id)
    {
        $data = array(
                'INT_FLG_DEL' => 1);
        $msg = 3;
            $this->measurement_device_m->update($data, $id);
            redirect($this->back_to_manage . $msg);
    }
    function save_device()
    {
        date_default_timezone_set('Asia/Jakarta');
        $today1 = date("Y-m-d");
        $today2 =date_create($today1);
        $tgl = date_format($today2,"Ymd");

        $time1 = date("H:i:s");
        $time2 = date_create($time1);
        $time = date_format($time2,"His");

        $date1= date("Ymd", strtotime($this->input->post('CHR_EXP_DATE'))) ;
        $exp1 =date_create($date1);
        $exp = date_format($exp1,"Ymd");

        $date2= date("Ymd", strtotime($this->input->post('CHR_CLB_DATE'))) ;
        $clb1 =date_create($date2);
        $clb = date_format($clb1,"Ymd");

        $dvc_nm = $this->input->post('CHR_DEVICE_DESC');
        $nm_asset = $this->input->post('CHR_NUMBER_ASSET');
        $ser_no = $this->input->post('CHR_SERIAL_NO'); 

        $data_dvc = $this->db->query("SELECT TOP 1 * FROM TM_MEASUREMENT_DEVICE WHERE CHR_DEVICE_DESC = '$dvc_nm' and CHR_NUMBER_ASSET = '$nm_asset' and CHR_SERIAL_NO = '$ser_no'");
        if ($data_dvc->num_rows() == 0){
        $data = array(
                'CHR_DEVICE_DESC' => $this->input->post('CHR_DEVICE_DESC'),
                'CHR_MODEL' => $this->input->post('CHR_MODEL'),
                'CHR_CREATED_BY' => $this->session->userdata('USERNAME'),
                'CHR_CREATED_DATE' => $tgl,
                'CHR_CREATED_TIME' => $time,
                'CHR_UNIT' => $this->input->post('CHR_UNIT'),
                'CHR_NUMBER_ASSET' => $this->input->post('CHR_NUMBER_ASSET'),
                'CHR_SERIAL_NO' => $this->input->post('CHR_SERIAL_NO'),
                'CHR_CLB_DATE' => $clb,
                'CHR_AREA' => $this->input->post('CHR_AREA'),
                'CHR_WC' => $this->input->post('CHR_WC'),
                'CHR_EXP_DATE' => $exp);
            $this->measurement_device_m->save_device($data);
            redirect($this->back_to_manage . $msg = 1);
        }else{
            redirect($this->back_to_manage.$msg = 4);
        }    
    }
    function update()
    {   
        date_default_timezone_set('Asia/Jakarta');
        $today1 = date("Y-m-d");
        $today2 =date_create($today1);
        $tgl = date_format($today2,"Ymd");

        $time1 = date("H:i:s");
        $time2 = date_create($time1);
        $time = date_format($time2,"His");
        $id = $id = $this->input->post('INT_DEVICE_ID');
        $date1= date("Ymd", strtotime($this->input->post('CHR_EXP_DATE'))) ;
        $exp1 =date_create($date1);
        $exp = date_format($exp1,"Ymd");
        $date2= date("Ymd", strtotime($this->input->post('CHR_CLB_DATE'))) ;
        $clb1 =date_create($date2);
        $clb = date_format($clb1,"Ymd");
        $data = array(
                'CHR_DEVICE_DESC' => $this->input->post('CHR_DEVICE_DESC'),
                'CHR_MODEL' => $this->input->post('CHR_MODEL'),
                'CHR_MODIFIED_BY' => $this->session->userdata('USERNAME'),
                'CHR_MODIFIED_DATE' => $tgl,
                'CHR_MODIFIED_TIME' => $time,
                'CHR_UNIT' => $this->input->post('CHR_UNIT'),
                'CHR_NUMBER_ASSET' => $this->input->post('CHR_NUMBER_ASSET'),
                'CHR_SERIAL_NO' => $this->input->post('CHR_SERIAL_NO'),
                'CHR_CLB_DATE' => $clb,
                'CHR_AREA' => $this->input->post('CHR_AREA'),
                'CHR_WC' => $this->input->post('CHR_WC'),
                'CHR_EXP_DATE' => $exp);
            $this->measurement_device_m->update($data,$id);
            redirect($this->back_to_manage . $msg = 2);
    }
    
}
?>