<?php

class Return_stamping_c extends CI_Controller {
    /* -- define constructor -- */

    private $layout = '/template/head';
    private $breadcrumb;

    public function __construct() {
        parent::__construct();
        $this->load->model('pes/prod_entry_m');
        $this->load->model('pes/return_material_m');
        $this->load->model('organization/dept_m');
        $this->load->model('basis/role_module_m');

        $this->load->model('portal/news_m');
    }

    public function index() {
        // redirect("fail_c");
        $this->role_module_m->authorization('16');
        $this->session->userdata('user_id');

        $data['content'] = 'pes/menu_location_stamping';
        $data['title'] = 'Return Stamping';

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(96);
        $data['news'] = $this->news_m->get_news();

        // $data['first_wcenter'] = $row->CHR_DEPT;

        if ($this->session->userdata('ROLE') == 7 || $this->session->userdata('ROLE') == 1 || $this->session->userdata('ROLE') == 18 || $this->session->userdata('ROLE') == 22 || $this->session->userdata('ROLE') == 21 || $this->session->userdata('ROLE') == 25) {
            $wcenter = $this->prod_entry_m->find('TOP(1) CHR_WCENTER_MN', '', 'CHR_WCENTER_MN');
        } else {
            $row = $this->dept_m->get_data_dept($this->session->userdata('DEPT'))->row();
            $data['dept_crop'] = substr($row->CHR_DEPT, 2, 1);
            $wcenter = $this->prod_entry_m->find('TOP(1) CHR_WCENTER_MN', 'CHR_PROD=' . $data['dept_crop'] . '', 'CHR_WCENTER_MN');
        }
        $data['first_wcenter'] = $wcenter[0]->CHR_WCENTER_MN;

        $this->load->view($this->layout, $data);
    }

    public function menurm(){
        redirect("fail_c");
        $this->role_module_m->authorization('16');
        $npk=$this->session->userdata('user_id');
        $data['content'] = 'pes/menu_location_stamping';
        $data['title'] = 'Return Stamping';

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(96);
        $data['news'] = $this->news_m->get_news();
        $pilih = $this->input->post('pilih');
        $data['pilihX'] = $pilih;
        $this->load->view($this->layout, $data);
    }

    public function pilihLoc(){
        $npk=$this->session->userdata('NPK');
        $pilih = $this->input->post('pilih');
        $data['pilih'] = $pilih;
        $t_data = array('location' => $pilih,
                        'CHR_NPK'=>$npk);

        $this->session->set_userdata('save', 'z');
        $this->session->set_userdata('print', 'z');
        $this->return_material_m->addProduct($t_data, 'TW_FROM_LOC');
        redirect(base_url() . "index.php/pes/return_stamping_c/return_stamping/$pilih", "refresh");
    }
    public function return_stamping($pilih = null) {
        $this->role_module_m->authorization('16');
        $this->session->userdata('user_id');
        $npk=$this->session->userdata('NPK');
        $data['content'] = 'pes/return_stamping_v';
        $data['title'] = 'Return Stamping';
        $data['news'] = $this->news_m->get_news();
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(96);
        $this->load->library('session');

        $pilih = $this->return_material_m->getData("SELECT location 'loc' FROM TW_FROM_LOC WHERE CHR_NPK='$npk' ");
        $data['pilih'] = $pilih[0]->loc;
        $alldata = $this->return_material_m->getData("SELECT * FROM TW_RETURN WHERE CHR_NPK='$npk' ORDER BY no ASC");
        $data['alldata'] = $alldata;
        $data['loop'] = count($alldata);
        $data['save']=$this->session->userdata('save');
        $data['print']=$this->session->userdata('print');
       
        $data['cekprint']=$this->session->userdata('cekprint');

        $this->load->view($this->layout, $data);
    }

    function addData() {
        $npk=$this->session->userdata('NPK');
        $this->session->userdata('user_id');
        $pilih = $this->input->post('pilihloc');
        $backno = $this->input->post('backno');
        $quantity = $this->input->post('quantity');
        $uom=$this->input->post('uom');
        $cekbno = strlen($backno);
       
        if ($cekbno == 0) {
            redirect(base_url() . "index.php/pes/return_stamping_c/return_stamping/$pilih", "Refresh");
        }
        $cekqty = strlen($quantity);
        if ($cekqty == 0) {
            redirect(base_url() . "index.php/pes/return_stamping_c/return_stamping/$pilih", "refresh");
        }

        $cekbno =$this->return_material_m->check_backno($backno);
        if ($cekbno==false) {
            $this->session->set_flashdata('message', 'Material Belum Terdaftar');
            redirect(base_url() . "index.php/pes/return_stamping_c/return_stamping/$pilih", "Refresh");
        }

        $cek = $this->return_material_m->cekData($npk);
        if ($cek==false) {
            $id = 0;
            $no = $id + 1;
        }else{
            $id=$cek[0]->no;
            $no = $id + 1;
        }
        
        $q = $this->return_material_m->getData("SELECT * FROM TM_PARTS WHERE CHR_BACK_NO = '$backno'");
        foreach ($q as $key => $value) {
            $bno = $value->CHR_BACK_NO;
            $partno = $value->CHR_PART_NO;
            $partname = $value->CHR_PART_NAME;
        }

        $t_data = array('no'=>$no,
            'CHR_BACK_NO'=>$bno,
            'CHR_PART_NO'=>$partno,
            'CHR_PART_NAME'=>$partname,
            'INT_QTY_PER_BOX'=>$quantity,
            'CHR_PART_UOM'=>$uom,
            'CHR_NPK'=>$npk
        );

        $this->return_material_m->addProduct($t_data, 'TW_RETURN');
        $this->session->set_userdata('save', 'n');
        $this->session->set_userdata('print', 'z');
        $this->session->set_userdata('cekprint', 'o');
        redirect(base_url() . "index.php/pes/return_stamping_c/return_stamping/$pilih", "refresh");
    }

    public function saveData() {
        $npk=$this->session->userdata('NPK');
        $pilih = $this->return_material_m->getData("SELECT location 'loc' FROM TW_FROM_LOC where CHR_NPK='$npk' ");
        $sloc=$pilih[0]->loc;
        $this->session->userdata('user_id');
        $nomor = $this->input->post('no');
        $pno = $this->input->post('pno');
        $bno = $this->input->post('bno');
        $pname = $this->input->post('pna');
        $qty =($this->input->post('qtyperbox'));

        $all = $this->return_material_m->getData("SELECT * FROM TW_RETURN where CHR_NPK='$npk'");
        $allfix = count($all);
        for ($i = 0; $i < $allfix; $i++) {
            $t_data = array('INT_QTY_PER_BOX' => $qty[$i],);
            $this->return_material_m->UpdateReturn($t_data, $nomor[$i],$npk);
        }
        $serialno=$this->return_material_m->getData("SELECT TOP 1 CHR_SERIAL 'serial' from TM_BARCODE_RETURN ORDER BY CHR_SERIAL desc");
        $serialno = $serialno[0]->serial;
        if (!$serialno) {
            $serialno = $serialno[0]->serial;
            $serialno = 0;
        }

        for ($i = 0; $i < $allfix; $i++) {
            $noid=$all[$i]->id;
            $serialno = $serialno + 1;
            $intVal = $serialno;
            $strVal = (string) $intVal;
            $x = strlen($strVal);
            $b = 9;
            $y = $b - $x;
            $no2 = 0;
            for ($u = 0; $u < $y; $u++) {
                $no1 = 0;
                $no2 = $no2 . $no1;
            }
            $serial = $no2 . $strVal;
            $backno = $bno[$i];
            $partno = $pno[$i];
            $partname = $pname[$i];
            $intqty=intval($qty[$i]);
            $intVal1=$qty[$i];
            if ($intVal1=='') {
                $this->session->set_flashdata('message','Harap quantity diisi terlebih dahulu'); 
                redirect(base_url() . "index.php/pes/return_stamping_c/return_stamping/", "refresh");
            }
            $strVal1 = (string) $intVal1;
            $x = strlen($strVal1);
            $b = 6;
            $y = $b - $x;
            $no2 = 0;
            for ($u = 0; $u < $y; $u++) {
                $no1 = 0;
                $no2 = $no2 . $no1;
            }
            $qtyperbox = $no2 . $strVal1;
            $t_data = array('CHR_SERIAL' => $serial,
                'CHR_BACK_NO' => $backno,
                'INT_QTY' =>$intqty,
                'CHR_BARCODE' => $serial . ' ' . $backno . ' ' . $qtyperbox,
                'CHR_NPK'=>$npk
            );
            $this->return_material_m->addProduct($t_data, 'TM_BARCODE_RETURN');
            $t_data = array('CHR_SERIAL' => $serial,
                            'INT_QTY_PER_BOX'=>$intqty);
            $result=$this->return_material_m->UpdateReturn($t_data, $noid, $npk);

        }
        $this->session->set_userdata('save', 'x');
        $this->session->set_userdata('cekprint', 'y');
        if ($result) {
                $this->session->set_flashdata('message','Data berhasil disimpan, Silahkan print'); 
                redirect(base_url() . "index.php/pes/return_stamping_c/return_stamping/", "refresh");
        }else{
            $this->session->set_flashdata('message','Data gagal disimpan'); 
            redirect(base_url() . "index.php/pes/return_stamping_c/return_stamping/", "refresh");  
        }
        
    }

    public function printData() {
        $npk=$this->session->userdata('NPK');
        $this->session->userdata('user_id');
        $all = $this->return_material_m->getData("SELECT * FROM TW_RETURN WHERE CHR_NPK='$npk' ");
        $allfix = count($all);
        $data['allfix']=$allfix;
        for ($i = 0; $i < $allfix; $i++) {
            $t_data = array('CHR_PLANT' => '600',
                            'CHR_DATE' => date("Ymd"),
                            'CHR_MVMT_TYPE' => '311',
                            'CHR_TYPE_TRANS'=>'RERM',
                            'CHR_IP' => $_SERVER['SERVER_ADDR'],
                            'CHR_USER'=>$this->session->userdata('USERNAME'),
                            'CHR_NPK'=>$this->session->userdata('NPK'),
                            'CHR_VALIDATE' => 'X',
                            'CHR_DATE_ENTRY' => date("Ymd"),
                            'CHR_TIME_ENTRY' => date("His"),
            );
            $this->return_material_m->addProduct($t_data, 'TT_GOODS_MOVEMENT_H');
            $sloc1 = $this->return_material_m->getData("SELECT location 'loc' FROM TW_FROM_LOC WHERE CHR_NPK='$npk'");
            $sloc = $sloc1[0]->loc;
            $intnum1 = $this->return_material_m->getData("SELECT TOP 1 INT_NUMBER 'intnum' from TT_GOODS_MOVEMENT_H WHERE CHR_NPK='$npk' ORDER BY INT_NUMBER DESC ");
            $intnum = $intnum1[0]->intnum;
            $partno = $all[$i]->CHR_PART_NO;
            $pdash1 = $this->return_material_m->getData("SELECT CHR_PART_NO_DASH 'pdash' FROM TM_PARTS where CHR_PART_NO = '$partno' ");
            $pdash = $pdash1[0]->pdash;
            $uom1 = $this->return_material_m->getData("SELECT CHR_PART_UOM 'uom' FROM TM_PARTS where CHR_PART_NO = '$partno' ");
            $uom = $uom1[0]->uom;
            $uom = trim($uom);
            $data['uom'][$i]=$uom;
            $qty = $all[$i]->INT_QTY_PER_BOX;
            $data['qty'][$i]=$qty;

            $strVal1 = (string) $qty;
            $x = strlen($strVal1);
            $b = 6;
            $y = $b - $x;
            $no2 = 0;
            for ($u = 0; $u < $y; $u++) {
                $no1 = 0;
                $no2 = $no2 . $no1;
            }
            $qtyperbox = $no2 . $strVal1;
            $data['qtyperbox'][$i]=$qtyperbox;

            $intVal = $all[$i]->no;
            $strVal = (string) $intVal;
            $x = strlen($strVal);
            $b = 9;
            $y = $b - $x;
            $no2 = 0;
            for ($u = 0; $u < $y; $u++) {
                $no1 = 0;
                $no2 = $no2 . $no1;
            }
            $serial = $no2 . $strVal;
                $t_data = array('INT_NUMBER' => $intnum,
                'CHR_PART_NO' => $all[$i]->CHR_PART_NO,
                'CHR_PART_NAME' => $all[$i]->CHR_PART_NAME,
                'CHR_PART_NO_DASH'=>$pdash,
                'CHR_UOM'=>$uom,
                'CHR_SLOC_FROM' => $sloc,
                'CHR_SLOC_TO' => 'WH00',
                'INT_TOTAL_QTY' =>$qty,
                'CHR_BACK_NO' => $all[$i]->CHR_BACK_NO,
                'CHR_DATE_ENTRY' => date("Ymd"),
                'CHR_TIME_ENTRY' => date("His"),
                'CHR_IP' => $_SERVER['SERVER_ADDR'],
                'CHR_USER' => $this->session->userdata('USERNAME'),
            );
            $this->return_material_m->addProduct($t_data, 'TT_GOODS_MOVEMENT_L');
            $serialreturn =$all[$i]->CHR_SERIAL;
            $d[$i] = $this->return_material_m->getData("SELECT * FROM TM_BARCODE_RETURN where CHR_SERIAL = '$serialreturn' AND CHR_NPK='$npk' ");
        }
        $data['all']= $d;
        $this->return_material_m->DeleteData("DELETE FROM TW_RETURN WHERE CHR_NPK='$npk'");
        $this->session->set_userdata('save', 'x');
        $this->session->set_userdata('print', 'x');
        $this->load->view('barcode_return/print_barcode_return', $data);
    }

    public function deleteData(){
        $npk=$this->session->userdata('NPK');
        $this->session->userdata('user_id');
        $this->return_material_m->DeleteData("DELETE FROM TW_RETURN WHERE CHR_NPK='$npk'");
        $this->return_material_m->DeleteData("DELETE FROM TW_FROM_LOC WHERE CHR_NPK='$npk'");
        $this->session->set_userdata('save', '');
        $this->session->set_userdata('print', '');
        $this->session->set_userdata('cekprint', '');
        
        redirect(base_url() . 'index.php/pes/return_stamping_c/menurm');
        
    }

    function getUom(){
        $backno = $this->input->post('backno');
        $cekuom =$this->return_material_m->checkUom($backno);
        if ($cekuom==false) {
            $cekuom='';
        }else{
            $cekuom = $cekuom[0]->CHR_PART_UOM;
            $cekuom = trim($cekuom);
        }
        echo $cekuom;
    }
    function search(){
        $this->load->model('pes/return_material_m');
        $get = $this->input->get('term');

        if($get){
            // $result = $this->return_material_m->search($get);
            $result = $this->db->query("SELECT TOP 10 CHR_BACK_NO FROM TM_PARTS WHERE CHR_BACK_NO LIKE '$get%'")->result();
            if(count($result) > 0){
                foreach ($result as $res) {
                    $arr_result[] = $res->CHR_BACK_NO;
                }
                echo json_encode($arr_result);
            }
        }
    }


}

?>