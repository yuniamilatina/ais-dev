<?php

//Add By xcx 20190507
class progress_c extends CI_Controller {

    private $layout = '/template/head';
    private $back_to_index = '/calsyta/progress_c/index/';

    public function __construct() {
        parent::__construct();
        $this->load->model('calysta/progress_m');
        $this->load->library('excel');
    }

    function index($msg = NULL) {
        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Creating success </strong>  The data is successfully created </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Updating success </strong> The data is successfully updated </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Deleted success </strong> The data is successfully deleted </div >";
        } 
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(308);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Progress Part Inhouse';
        $data['data'] = $this->progress_m->get_technical();
        $data['duration'] = $this->progress_m->get_duration();
        $data['msg'] = $msg;
        $data['selected_date_awal'] = '';
        $data['selected_date_akhir'] = '';
        $data['content'] = 'calysta/progress_v';
        $project = $this->input->post("CHR_PROJECT");
        $data['dropdown'] = $this->progress_m->getDrop($project);
        $this->load->view($this->layout, $data);
    }

    function dashboard() {
         
        $data1 = $this->input->post('CHR_PROJECT');
         $data2 = $this->input->post('CHR_PROJECT_NAME');
     
         $data = array(
            'CHR_PROJECT' => $data1,
            'CHR_PROJECT_NAME' => $data2);
       
        $this->progress_m->get_dashboard($data1,$data2);
        redirect('calysta/progress_c/');
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
        $id = $this->input->post('CHR_TM_NUMBER');
       $mc1 = $this->input->post('MC1');
        $sg =  $this->input->post('SG');
        $wc =  $this->input->post('WC');
        $mc2 = $this->input->post('MC2');
       
        $data = array(
                'CHR_STATUS_MC1' => $this->input->post('MC1'),
                'CHR_STATUS_SG'=> $this->input->post('SG'),
                'CHR_STATUS_WC'=> $this->input->post('WC'),
                'CHR_STATUS_MC2' => $this->input->post('MC2'),
                'INT_FLG_DEL' => 0);
    
            $this->progress_m->update($data,$id);
            redirect('calysta/progress_c');
    }
    function get_data_dropdown(){
        $project = $this->input->post("CHR_PROJECT");
          
        
        $dropdown = $this->progress_m->getDrop($project);
        $data = '';
        
          foreach($dropdown as $row) { 
         $data .="<option value='$row->CHR_PROJECT_NAME'>".$row->CHR_PROJECT_NAME."</option>";
            }
                                    
//       foreach ($dropdown as $row) { 
//            if (trim($project) == 0){ 
//                $data .="<option selected value='$row->CHR_PROJECT_NAME'>".$row->CHR_PROJECT_NAME."</option>";
//            }else{ 
//                $data .="<option value='$row->CHR_PROJECT_NAME'>".$row->CHR_PROJECT_NAME."</option>";
//            }
//        }
//       
        $json_data = array('data' => $data);

        echo json_encode($json_data);
    }
}
?>