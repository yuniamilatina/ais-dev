<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class takaibiki_c extends CI_Controller {

    private $back_to_manage = 'takaibiki/takaibiki_c/index/';

    public function __construct() {
        parent::__construct();
    }

    function check_session() {
        $user_session = $this->session->all_userdata();
        if ($user_session['NPK'] == '') {
            redirect(base_url('index.php/login_c'));
        }
    }

    function index($msg = null) {
        $this->check_session();
        
        $data['msg'] = $msg;
        $data['title'] = 'Manage Part Takabiki';
        $data['content'] = 'takaibiki/manage_part';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(64);
        $data['news'] = $this->news_m->get_news();
        
        $takaibiki = $this->load->database('takaibiki', TRUE);
        $master_part = $takaibiki->query("select * from t_master_pis")->result();
        $data['master_part'] = $master_part;
        
        $this->load->view('/template/head', $data);
    }

    function edit_point($back_no) {
        $takaibiki = $this->load->database('takaibiki', TRUE);
        $this->check_session();
        $msg = "";
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
        $data['title'] = 'Edit Pointer Part Takabiki';
        $data['content'] = $content;
        $data['pointer'] = $get_pointer;
        $data['back_no'] = $back_no;
        $data['part_no'] = $part_no;

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(64);
        $data['news'] = $this->news_m->get_news();

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
    
    function new_entry() {
      $back_no  = $this->input->post("part_no");
      redirect(site_url(takaibiki/home_c/new_entry),"refresh");
    }

    function add_new_part($msg = NULL){
        $data['title'] = 'Add New Part Takabiki';

        $data['all_back_no'] = $this->db->query("SELECT DISTINCT CHR_BACK_NO FROM TM_KANBAN WHERE CHR_KANBAN_TYPE IN ('5','6') AND (CHR_FLAG_DELETE IS NULL OR CHR_FLAG_DELETE = '')")->result();

        $data['msg'] = $msg;
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(64);
        $data['news'] = $this->news_m->get_news();

        $data['content'] = 'takaibiki/add_new_part_v';
        $this->load->view('/template/head', $data);
    }

    function get_part_name() {
        $back_no = $this->input->post('back_no');
        //$part_name = $this->db->query("SELECT DISTINCT RTRIM(CHR_PART_NAME) AS CHR_PART_NAME FROM TT_PRODUCTION_RESULT WHERE CHR_BACK_NO = '$back_no'")->row();
        $part_name = $this->db->query("SELECT RTRIM([CHR_PART_NAME]) AS CHR_PART_NAME
                                      FROM [TM_PARTS] A
                                      LEFT JOIN TM_KANBAN B ON A.CHR_PART_NO = B.CHR_PART_NO
                                      WHERE A.CHR_BACK_NO = '$back_no' OR B.CHR_BACK_NO = '$back_no'")->row();
        
        echo json_encode($part_name->CHR_PART_NAME);
    }

    function save_new_part(){
        $this->load->library(array('PHPExcel', 'PHPExcel/IOFactory'));
        $this->load->library('upload');        

        $back_no = trim($this->input->post('CHR_BACK_NO'));
        $part_name = str_replace('"','', $this->input->post('CHR_PART_NAME'));
        
        $part_no_2 = $this->db->query("SELECT RTRIM([CHR_CUST_PART_NO]) AS CHR_PART_NO
                FROM TM_KANBAN WHERE CHR_BACK_NO = '$back_no'")->row();
            
        $part_no_cust = $part_no_2->CHR_PART_NO;        

        if($part_no_cust == '' || $part_no_cust == NULL){
            $part_no = $this->db->query("SELECT RTRIM([CHR_CUS_PART_NO]) AS CHR_PART_NO
                    FROM [TM_PARTS] A
                    LEFT JOIN TM_KANBAN B ON A.CHR_PART_NO = B.CHR_PART_NO
                    WHERE A.CHR_BACK_NO = '$back_no' OR B.CHR_BACK_NO = '$back_no'")->row();
        
            $part_no_cust = $part_no->CHR_PART_NO;
        }

        $fileName = $_FILES['CHR_IMG_FILE_NAME']['name'];   
        $ext = end((explode(".", $fileName))); //--- Get extension         

        if (empty($fileName)) {
            redirect($this->back_to_manage.$msg = 4);
        }        

        $config = array(
            'upload_path' => 'assets/pis_images/',
            'allowed_types' => "gif|JPG|jpg|png|jpeg",
            'overwrite' => TRUE,
            'max_size' => "2048000"//,
            //'file_name' = $fileName;
            );

        //code for upload with ci
        $this->upload->initialize($config);
        
        //upload file to directory
        if($this->upload->do_upload('CHR_IMG_FILE_NAME')){
            $media = $this->upload->data('CHR_IMG_FILE_NAME');
            $inputFileName = $config['upload_path'] . $media['file_name'];

            $takaibiki = $this->load->database('takaibiki', TRUE);
            $check_existing = $takaibiki->query("select * from t_master_pis where t_master_pis.b_no = '$back_no'")->result();          
            
            if(count($check_existing) >= 1){
                redirect($this->back_to_manage.$msg = 4);
            }else{
                $p_no = trim(str_replace('-','',$part_no_cust));
                $picture = trim($back_no) . '.' . $ext;
                $takaibiki->query("INSERT INTO `t_master_pis` (`p_no`, `p_name`, `b_no`, `picture`, `flag_point`) VALUES ('$p_no', '$part_name', '$back_no', '$picture', 'f');");

                redirect($this->back_to_manage.$msg = 1);
            }
        } else {
            print_r('ERROR Upload');
            exit();
        }
    }

}

?>
