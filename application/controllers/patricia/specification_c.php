
<?php

//Add By xcx 20190507
class specification_c extends CI_Controller {

    private $layout = '/template/head';
    private $back_to_manage = '/patricia/specification_c/detail_spec/';
    private $back_to_index = '/patricia/specification_c/';
    private $layout_blank = '/template/head_blank';

    public function __construct() {
        parent::__construct();
        $this->load->model('patricia/specification_m');
    }

    function index($msg = NULL) {
        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Creating success </strong>  The data is successfully created </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Updating success </strong> The data is successfully updated </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Deleted success </strong> The data is successfully deleted </div >";
        }
        $data['msg'] = $msg;
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(80);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Manage Specification';
        $data['list_part'] = $this->specification_m->get_component();
        $data['device'] = $this->specification_m->get_device();
        $data['data'] = $this->specification_m->get_component_spec();
        $data['content'] = 'patricia/specification/view_component_v';
        $this->load->view($this->layout, $data);
    }
    
    function detail_spec($id,$msg = NULL)
    {
        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Creating success </strong>  The data is successfully created </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Updating success </strong> The data is successfully updated </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Deleted success </strong> The data is successfully deleted </div >";
        } elseif ($msg == 4) {
            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Your File is Too Large! </strong> </div >";
        }
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(80);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Manage Specification';
        $data['msg'] = $msg;
        $data['data'] = $this->specification_m->get_specification($id);
        $data['list_part'] = $this->specification_m->get_component();
        $data['device'] = $this->specification_m->get_device();
        $data['content'] = 'patricia/specification/manage_spec_v';
        $data['idcomponent'] = $id;
        $this->load->view($this->layout, $data);
    }
    function save_specification()
    {
        date_default_timezone_set('Asia/Jakarta');
        $today1 = date("Y-m-d");
        $today2 =date_create($today1);
        $tgl = date_format($today2,"Ymd");

        $time1 = date("H:i:s");
        $time2 = date_create($time1);
        $time = date_format($time2,"His");
        $id = $this->input->post('CHR_COMPONENT_ID');
        $this->update_index($this->input->post('INT_INDEX'),$this->input->post('CHR_COMPONENT_ID'));
        $Max = $this->specification_m->get_max();
        if($Max == '0')
        {
            echo 'a';
            $Spec_code = "SPE-0001";
        }
        else
        {
            $Code= explode ("-", $Max);
            if(($Code[1]+1)<10)
            {
                $Spec_code= $Code[0].'-000'.($Code[1]+1);
            }
            elseif(($Code[1]+1)<100 && ($Code[1]+1)>9)
            {
                $Spec_code= $Code[0].'-00'.($Code[1]+1);
            }
            elseif(($Code[1]+1)<1000 && ($Code[1]+1)>99)
            {
                $Spec_code= $Code[0].'-0'.($Code[1]+1);
            }
            elseif(($Code[1]+1)>999)
            {
                $Spec_code= $Code[0].'-'.($Code[1]+1);
            }

        }
        $ekstensi = array('png','jpg','jpeg');
        $file_tmp = $_FILES['uploadFoto']['tmp_name'];  
        $nama = $_FILES['uploadFoto']['name'];
        $x = explode('.',$nama);
        $eksten = strtolower(end($x));
        $ukuran_gambar=$_FILES['uploadFoto']['size'];
        $ukuran = 2048000;
        $namaGambar = date('dMYHis');
        // $target_file = $target_dir . $namaGambar.'.'.$x[1];
        $namaGambar = $namaGambar.'.'.$x[1];
        if(in_array($eksten, $ekstensi)===true)
        {
            if($ukuran >= $ukuran_gambar){
                move_uploaded_file($file_tmp,DOCUP.'/patricia/SPEC/'.$namaGambar);
                $data = array(
                    'INT_DEVICE_ID' => $this->input->post('INT_DEVICE_ID'),
                    'CHR_COMPONENT_ID' => $this->input->post('CHR_COMPONENT_ID'),
                    'CHR_SPECIFICATION' => $this->input->post('CHR_SPECIFICATION'),
                    'DEC_STD' => $this->input->post('DEC_STD'),
                    'DEC_TOLERANSI_MAX' => $this->input->post('DEC_TOLERANSI_MAX'),
                    'DEC_TOLERANSI_MIN' => $this->input->post('DEC_TOLERANSI_MIN'),
                    'DEC_STD_MIN' => ($this->input->post('DEC_STD') - $this->input->post('DEC_TOLERANSI_MIN')),
                    'DEC_STD_MAX' => ($this->input->post('DEC_STD') + $this->input->post('DEC_TOLERANSI_MAX')),
                    'INT_INDEX' => $this->input->post('INT_INDEX'),
                    'CHR_CREATED_BY' => $this->session->userdata('USERNAME'),
                    'CHR_CREATED_DATE' => $tgl,
                    'CHR_CREATED_TIME' => $time,
                    'CHR_SPEC_CODE' => $Spec_code,
                    'CHR_IMAGE' => $namaGambar);
                    // 'CHR_UNIT' => $this->input->post('CHR_UNIT'));
                $this->specification_m->save_specification($data);
                redirect($this->back_to_manage.$id.'/' . $msg = 1);
            } else {
                redirect($this->back_to_manage.$id.'/' . $msg = 4);
            }
        }
    }
    function save_specification_komponen()
    {
        date_default_timezone_set('Asia/Jakarta');
        $today1 = date("Y-m-d");
        $today2 =date_create($today1);
        $tgl = date_format($today2,"Ymd");

        $time1 = date("H:i:s");
        $time2 = date_create($time1);
        $time = date_format($time2,"His");
        $id = $this->input->post('CHR_COMPONENT_ID');
        $this->update_index($this->input->post('INT_INDEX'),$this->input->post('CHR_COMPONENT_ID'));
        $Max = $this->specification_m->get_max();
        if($Max == '0')
        {
            echo 'a';
            $Spec_code = "SPE-0001";
        }
        else
        {
            $Code= explode ("-", $Max);
            if(($Code[1]+1)<10)
            {
                $Spec_code= $Code[0].'-000'.($Code[1]+1);
            }
            elseif(($Code[1]+1)<100 && ($Code[1]+1)>9)
            {
                $Spec_code= $Code[0].'-00'.($Code[1]+1);
            }
            elseif(($Code[1]+1)<1000 && ($Code[1]+1)>99)
            {
                $Spec_code= $Code[0].'-0'.($Code[1]+1);
            }
            elseif(($Code[1]+1)>999)
            {
                $Spec_code= $Code[0].'-'.($Code[1]+1);
            }

        }
        $ekstensi = array('png','jpg','jpeg');
        $file_tmp = $_FILES['uploadFoto']['tmp_name'];  
        $nama = $_FILES['uploadFoto']['name'];
        $x = explode('.',$nama);
        $eksten = strtolower(end($x));
        $ukuran_gambar=$_FILES['uploadFoto']['size'];
        $ukuran = 2048000;
        $namaGambar = date('dMYHis');
        // $target_file = $target_dir . $namaGambar.'.'.$x[1];
        $namaGambar = $namaGambar.'.'.$x[1];
        if(in_array($eksten, $ekstensi)===true)
        {
            if($ukuran >= $ukuran_gambar){
                move_uploaded_file($file_tmp,DOCUP.'/patricia/SPEC/'.$namaGambar);
                $data = array(
                    'INT_DEVICE_ID' => $this->input->post('INT_DEVICE_ID'),
                    'CHR_COMPONENT_ID' => $this->input->post('CHR_COMPONENT_ID'),
                    'CHR_SPECIFICATION' => $this->input->post('CHR_SPECIFICATION'),
                    'DEC_STD' => $this->input->post('DEC_STD'),
                    'DEC_TOLERANSI_MAX' => $this->input->post('DEC_TOLERANSI_MAX'),
                    'DEC_TOLERANSI_MIN' => $this->input->post('DEC_TOLERANSI_MIN'),
                    'DEC_STD_MIN' => $this->input->post('DEC_TOLERANSI_MIN'),//($this->input->post('DEC_STD') - $this->input->post('DEC_TOLERANSI_MIN')),
                    'DEC_STD_MAX' => $this->input->post('DEC_TOLERANSI_MAX'),//($this->input->post('DEC_STD') + $this->input->post('DEC_TOLERANSI_MAX')),
                    'INT_INDEX' => $this->input->post('INT_INDEX'),
                    'CHR_CREATED_BY' => $this->session->userdata('USERNAME'),
                    'CHR_CREATED_DATE' => $tgl,
                    'CHR_CREATED_TIME' => $time,
                    'CHR_SPEC_CODE' => $Spec_code,
                    'CHR_IMAGE' => $namaGambar);
                    // 'CHR_UNIT' =>$this->input->post('CHR_UNIT'));
                $this->specification_m->save_specification($data);
                $msg = 1;
                redirect($this->back_to_index.'index/'. $msg);
            } else {
                redirect($this->back_to_index.'index/' . $msg = 4);
            }
        }
    }
    function delete($id,$component)
    {
        $data = array(
                'INT_FLG_DEL' => 1);
        $msg = 3;
            $this->specification_m->update($data, $id);
            redirect($this->back_to_manage.$component.'/' . $msg);
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
        $id = $this->input->post('INT_SPECIFICATION_ID');

        $this->update_index($this->input->post('INT_INDEX'),$this->input->post('CHR_COMPONENT_ID'));

        $ekstensi = array('png','jpg','jpeg');
        $file_tmp = $_FILES['uploadFotoEdit']['tmp_name'];  
        $nama = $_FILES['uploadFotoEdit']['name'];
        $x = explode('.',$nama);
        $eksten = strtolower(end($x));
        $ukuran_gambar=$_FILES['uploadFotoEdit']['size'];
        $ukuran = 2048000;
        $namaGambar = date('dMYHis');
        // $target_file = $target_dir . $namaGambar.'.'.$x[1];
        $namaGambar = $namaGambar.'.'.$x[1];
        if($nama != '')
        {
            if(in_array($eksten, $ekstensi)===true)
            {
                if($ukuran >= $ukuran_gambar){                    
                    move_uploaded_file($file_tmp,DOCUP.'/patricia/SPEC/'.$namaGambar);
                    $data = array(
                        'INT_DEVICE_ID' => $this->input->post('INT_DEVICE_ID'),
                        'CHR_COMPONENT_ID' => $this->input->post('CHR_COMPONENT_ID'),
                        'CHR_SPECIFICATION' => $this->input->post('CHR_SPECIFICATION'),
                        'DEC_STD' => $this->input->post('DEC_STD'),
                        'DEC_TOLERANSI_MAX' => $this->input->post('DEC_TOLERANSI_MAX'),
                        'DEC_TOLERANSI_MIN' => $this->input->post('DEC_TOLERANSI_MIN'),
                        'DEC_STD_MIN' => $this->input->post('DEC_TOLERANSI_MIN'),//($this->input->post('DEC_STD') - $this->input->post('DEC_TOLERANSI_MIN')),
                        'DEC_STD_MAX' => $this->input->post('DEC_TOLERANSI_MAX'),//($this->input->post('DEC_STD') + $this->input->post('DEC_TOLERANSI_MAX')),
                        'INT_INDEX' => $this->input->post('INT_INDEX'),
                        'CHR_MODIFIED_BY' => $this->session->userdata('USERNAME'),
                        'CHR_MODIFIED_DATE' => $tgl,
                        'CHR_MODIFIED_TIME' => $time,
                        'CHR_IMAGE' => $namaGambar);
                        // 'CHR_UNIT' => $this->input->post('CHR_UNIT'));
                    $this->specification_m->update($data,$id);
                    $id = $this->input->post('CHR_COMPONENT_ID');
                    redirect($this->back_to_manage.$id.'/' . $msg = 2);
                }
            }
        }
        else
        {
            $data = array(
                'INT_DEVICE_ID' => $this->input->post('INT_DEVICE_ID'),
                'CHR_COMPONENT_ID' => $this->input->post('CHR_COMPONENT_ID'),
                'CHR_SPECIFICATION' => $this->input->post('CHR_SPECIFICATION'),
                'DEC_STD' => $this->input->post('DEC_STD'),
                'DEC_TOLERANSI_MAX' => $this->input->post('DEC_TOLERANSI_MAX'),
                'DEC_TOLERANSI_MIN' => $this->input->post('DEC_TOLERANSI_MIN'),
                'DEC_STD_MIN' => $this->input->post('DEC_TOLERANSI_MIN'),//($this->input->post('DEC_STD') - $this->input->post('DEC_TOLERANSI_MIN')),
                'DEC_STD_MAX' => $this->input->post('DEC_TOLERANSI_MAX'),//($this->input->post('DEC_STD') + $this->input->post('DEC_TOLERANSI_MAX')),
                'INT_INDEX' => $this->input->post('INT_INDEX'),
                'CHR_MODIFIED_BY' => $this->session->userdata('USERNAME'),
                'CHR_MODIFIED_DATE' => $tgl,
                'CHR_MODIFIED_TIME' => $time);
                // 'CHR_UNIT' => $this->input->post('CHR_UNIT'));
            $this->specification_m->update($data,$id);
            $id = $this->input->post('CHR_COMPONENT_ID');
            redirect($this->back_to_manage.$id.'/' . $msg = 2);
        }
            
            
    }
    function update_index($index,$id)
    {
        $daftar_index = $this->specification_m->get_index($id);
        date_default_timezone_set('Asia/Jakarta');
        $today1 = date("Y-m-d");
        $today2 =date_create($today1);
        $tgl = date_format($today2,"Ymd");

        $time1 = date("H:i:s");
        $time2 = date_create($time1);
        $time = date_format($time2,"His");
        $temp_ind =0;
        foreach ($daftar_index as $isi) {
            # code...
            if($isi->INT_INDEX == ($index+ $temp_ind))
            {
                $data = array(
                'INT_INDEX' => ($isi->INT_INDEX +1),
                'CHR_MODIFIED_BY' => $this->session->userdata('USERNAME'),
                'CHR_MODIFIED_DATE' => $tgl,
                'CHR_MODIFIED_TIME' => $time);
                $this->specification_m->update($data,$isi->INT_SPECIFICATION_ID);
                $temp_ind =$temp_ind+1;
            }
        }

    }
}
?>