<?php

class qc extends CI_Controller {
    /* -- define constructor -- */

    private $layout = '/template/head';
	//private $back_to_manage = 'pes/promasdat_c/line_stop/';
	//private $back_to_ng = 'pes/promasdat_c/ng/';

    public function __construct() {
        parent::__construct();

        //$this->load->model('pes/prod_entry_m');
		//$this->load->model('pes/prodmasdat_m');
        $this->load->model('organization/dept_m');
        $this->load->model(array('pes/display_m'));
        $this->load->library('form_validation');

        //$this->load->library('excel');
        //$this->load->library('PHPExcel');

        $this->load->model('basis/log_m');
        $this->load->model('basis/role_module_m');
        
        $this->load->model('portal/news_m');
        $this->load->model('portal/notification_m');

        //$this->load->helper(array('url', 'dompdf'));
        $this->load->helper(array('form', 'url', 'download', 'inflector', 'dompdf'));
    }

    public function index() {
        $this->role_module_m->authorization('16');
        $this->session->userdata('user_id');
		$this->load->library('form_validation');

        $data['content'] = 'qc/qc';
        $data['title'] = 'QC Entry System';

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(95);
        $data['news'] = $this->news_m->get_news();

        $this->load->view($this->layout, $data);
    }
    public function getTableDO(){

    	// $npk = $this->session->userdata('NPK');
    	// $username = $this->session->userdata('USERNAME');
    	// $ip  = $this->session->userdata('ip_address');

    	// echo $npk . $username . $ip;

    	$no_do = $this->input->post('no_do');

    	// $jaga_query = $this->db->query("SELECT CHR_DEL_NO FROM TT_DELIVERY WHERE CHR_DEL_NO = '$no_do' AND CHR_DEL_TYPE = 'ZRFM'");
    	$jaga_query = $this->db->query("SELECT CHR_DEL_NO FROM TT_DELIVERY WHERE CHR_DEL_NO = '$no_do' AND CHR_DEL_TYPE = 'ZRFM' AND CHR_GI_DEL = 'C'");

    	if($jaga_query->num_rows() > 0){
    		$del_query = $this->db->query("select CHR_DEL_ITEM, CHR_PART_NO, INT_TOTAL_QTY from TT_DELIVERY_ITEM where CHR_DEL_NO = '$no_do' AND CHR_ITEM_TYPE = 'ZRFM' order by CHR_DEL_ITEM");

	    	if($del_query->num_rows() > 0){
	    		$del_item = $del_query->result();
	    		$data = '<table class="tg" id="dataTable" width="100%" style="margin-top:10px" border="1">';
	    		$data.='<tr><th class="tg-031e" style="text-align:center" width="50">No.</th><th class="tg-031e" style="text-align:center" width="150">Part No.</th><th class="tg-031e" style="text-align:center" width="50">Delivery Quantity</th><th width="70" class="tg-031e" style="text-align:center;">Qty Goods</th><th width="70" class="tg-031e" style="text-align:center;">Qty Repair</th><th width="70" class="tg-031e" style="text-align:center;">Qty Claim to Vendor</th>
	    		<th width="70" class="tg-031e" style="text-align:center;">Qty Scrap</th><th class="tg-031e" style="text-align:center">SLoc To</th><th class="tg-031e" style="text-align:center; width:80px">Status</th></tr>';
	    		$x = 1;
	    		foreach ($del_item as $value) {

	    			$part_no = trim($value->CHR_PART_NO);
        			//$part_no = substr($part_no, 0, 6).'-'.substr($part_no, 6, 11);

					$partno = trim($value->CHR_PART_NO);
                    //$partno = trim('-1234567890abcdef');
                    $length = strlen($partno);
                    $bag1   = substr($partno, 0, 6);
                    $sisa   = (int)$length - 6;
                    //echo $sisa;
                    if($sisa <= 5){
             	        $bag2 = substr($partno, 6, $sisa);
                    }else{
                        $bag2 = substr($partno, 6, 5);
                        $sisa = (int)$length - 11;
                    }
                    //echo $sisa;
                    $partsisa = substr($partno, 11, $sisa);
                    $bag3     = str_split($partsisa, 2);
                    //echo $partsisa;
                    if(substr($bag1, 0, 1) == '-'){
              	        $bag1 = str_replace('-', '', $bag1);
                    }

                    $partnobaru = $bag1.'-'.$bag2;
                    //echo $partnobaru;
                    for($i = 0; $i < sizeof($bag3); $i++){
                        if($bag3[$i] == ''){
                            $partnobaru .= $bag3[$i];
                        }else{
                            $partnobaru .= '-'.$bag3[$i];
                        }
                    }
                    //echo $partnobaru;        			

	    			$data.='<tr>';
	    			$data.='<td class="tg-031e" style="text-align:center"><input type="hidden" name = "item_'.$x.'" value="'.$value->CHR_DEL_ITEM.'"/>'.$x.'</td>';
	    			// $data.='<td class="tg-031e"><input type="text" onkeypress="return (event.charCode >= 48 && event.charCode <= 57)||event.charCode <= 8" style="text-align:center; height:35px" width="100" class="form-control" readonly="readonly" name="partno_'.$x.'" id="partno_'.$x.'" value="'.$part_no.'" /></td>';
	    			$data.='<td class="tg-031e"><input type="text" onkeypress="return (event.charCode >= 48 && event.charCode <= 57)||event.charCode <= 8" style="text-align:center; height:35px" width="100" class="form-control" readonly="readonly" name="partno_'.$x.'" id="partno_'.$x.'" value="'.$partnobaru.'" /></td>';
	    			$data.='<input type="hidden" onkeypress="return (event.charCode >= 48 && event.charCode <= 57)||event.charCode <= 8" style="text-align:center; height:35px" width="100" class="form-control" readonly="readonly" name="partnohid_'.$x.'" id="partnohid_'.$x.'" value="'.$part_no.'" />';
	    			$data.='<td class="tg-031e"><input type="text" onkeypress="return (event.charCode >= 48 && event.charCode <= 57)||event.charCode <= 8" style="text-align:center; height:35px" width="100" class="form-control" readonly="readonly" name="del_'.$x.'" id="del_'.$x.'" value="'.$value->INT_TOTAL_QTY.'" /></td>';
	    			$data.='<td class="tg-031e" width="50"><input type="text" onkeypress="return (event.charCode >= 48 && event.charCode <= 57)||event.charCode <= 8" style="text-align:center; height:35px" class="numberOnly" onchange="checkVal(' . "'" . $x . "'" . ')" name="good_'.$x.'" id="good_'.$x.'" value="0" /></td>';
	    			$data.='<td class="tg-031e" width="50"><input type="text" onkeypress="return (event.charCode >= 48 && event.charCode <= 57)||event.charCode <= 8" style="text-align:center; height:35px" class="numberOnly" onchange="checkVal(' . "'" . $x . "'" . ')" name="repair_'.$x.'" id="repair_'.$x.'"  value="0" /></td>';
	    			$data.='<td class="tg-031e" width="50"><input type="text" onkeypress="return (event.charCode >= 48 && event.charCode <= 57)||event.charCode <= 8" style="text-align:center; height:35px" class="numberOnly" onchange="checkVal(' . "'" . $x . "'" . ')" name="claim_'.$x.'" id="claim_'.$x.'" value="0" /></td>';
	    			$data.='<td class="tg-031e" width="50"><input type="text" onkeypress="return (event.charCode >= 48 && event.charCode <= 57)||event.charCode <= 8" style="text-align:center; height:35px" class="numberOnly" onchange="checkVal(' . "'" . $x . "'" . ')" name="scrap_'.$x.'" id="scrap_'.$x.'" value="0" /></td>';
	    			$data.='<td class="tg-031e" width="50"><select id="slocto_'.$x.'" name="slocto_'.$x.'" style="height: 35px; width: 70px;border-radius: 0 4px 4px 0;-moz-border-radius: 0 4px 4px 0;webkit-border-radius: 0 4px 4px 0;"><option value="PP01">PP01</option><option value="PP02">PP02</option><option value="PP03">PP03</option></select></td>';
	    			$data.='<td class="tg-031e" id="field_'.$x.'" name="field_'.$x.'"><input type="text" style="text-align:center" class="form-control" name="status_'.$x.'" id="status_'.$x.'" value="" readonly="readonly"/></td>';
	    			//$data.='<td style="text-align:center"><input type="text" style="text-align:center" class="form-control" name="status_'.$x.'" value="" readonly="readonly"/></td>';
	    			$data.='</tr>';
	    			$x++;
	    		}
	    		$data.= '</table>';
	    		$data.='<input type="hidden" name="no" id="no" value="'.$x.'"/>';
	    	}
	    	else{
	    		$data = '<div style="padding-left:20px; background-color:white; font-size:12px; font-style:bold"> Data tidak ditemukan.</div>';
	    	}
    	}
    	else{
    		$data = '<div style="padding-left:18px; margin-top:20px; background-color:white; color:red; font-size:12px; border-radius: 5px"> Maaf, Tipe Delivery tidak valid.</div>';
    	}

    	echo $data;
    }
    
    public function saveData(){
        $date = date('Ymd');
        $time = date('Hms');

        	//print_r($this->session->all_userdata());
	        $npk = $this->session->userdata('NPK');
	        $username = $this->session->userdata('USERNAME');
	        $ip  = $this->session->userdata('ip_address');

	        $this->db->trans_begin();

	        $no_do = $this->input->post('no_del');
	        $no = $this->input->post('no');
	        $this->db->query("INSERT INTO TT_QCE_H(CHR_DEL_NO, CHR_CREATE_DATE, CHR_CREATE_TIME, CHR_CREATE_USER) VALUES ('".$no_do."', '".$date."', '".$time."', '".$username."');");
	        //echo $this->db->_error_message();
	        //$data = $this->db->query("select INT_QCE_NO from TT_QCE_H where CHR_DEL_NO = '".$no_do."'")->result();
	        //$no_qce = $data[0]->INT_QCE_NO;

	        $header = $this->db->query('SELECT SCOPE_IDENTITY() AS header_key')->result();
	        $no_qce = $header[0]->header_key;

	        //echo '<script>alert("lalalala")</script>';

	        for($x = 1; $x < $no; $x++){
	            $good_qty = $this->input->post('good_'.$x);
	            $item = $this->input->post('item_'.$x);

	            //$partno = $this->input->post('partno_'.$x);
	            //$partno = str_replace('-', '', $partno);

	            $partno = $this->input->post('partnohid_'.$x);

	            $del_qty = $this->input->post('del_'.$x);
	            $repair_qty = $this->input->post('repair_'.$x);
	            $claim_qty = $this->input->post('claim_'.$x);
	            $scrap_qty = $this->input->post('scrap_'.$x);
	            $sloc_to = $this->input->post('slocto_'.$x);
	            $this->db->query("INSERT INTO TT_QCE_L(INT_QCE_NO,INT_QCE_ITEM,CHR_PART_NO,
	            INT_DEL_QTY,INT_GOODS_QTY,INT_REPAIR_QTY,INT_CLAIM_QTY,INT_SCRAP_QTY, CHR_CREATE_DATE, CHR_CREATE_TIME, CHR_CREATE_USER, CHR_SLOC_TO,CHR_DEL_ITEM) 
	            VALUES ('".$no_qce."','".$x."','".$partno."','".$del_qty."','".$good_qty."','".$repair_qty."','".$claim_qty."','".$scrap_qty."', '".$date."', '".$time."', '".$username."', '".$sloc_to."','".$item."');");
	            if ($good_qty <> 0){
	                $this->db->query("INSERT INTO TT_GOODS_MOVEMENT_H(CHR_PLANT,CHR_DATE,
	                CHR_TYPE_TRANS,CHR_DOCUMENT_DATE,CHR_MVMT_TYPE, CHR_IP, CHR_USER, CHR_NPK, CHR_VALIDATE,CHR_UPLOAD,
	                CHR_STATUS,CHR_REMARKS) VALUES('600','".$date."','DLGD','".$date."','343', '".$ip."', '".$username."', '".$npk."','X','0','0','".$no_do."')");
	                
	                // $header = $this->db->query("SELECT INT_NUMBER AS header_key from TT_GOODS_MOVEMENT_H 
	                // WHERE CHR_REMARKS = '".$no_do."' and CHR_TYPE_TRANS = 'TPGD'")->result();
	                $header = $this->db->query('SELECT SCOPE_IDENTITY() AS header_key')->result();
	                $header_key = $header[0]->header_key;
	                //$this->db->query("DBCC CHECKIDENT ('TT_GOODS_MOVEMENT_L', RESEED, 0)");

	                $part_query = $this->db->query("SELECT CHR_PART_NAME FROM TM_PARTS WHERE CHR_PART_NO = '".$partno."'")->result();
	                $part_name = $part_query[0]->CHR_PART_NAME;
	                
	                $this->db->query("INSERT INTO TT_GOODS_MOVEMENT_L(INT_NUMBER,
	                CHR_PART_NO,CHR_PART_NAME,CHR_SLOC_FROM,CHR_SLOC_TO,INT_TOTAL_QTY,CHR_IP,CHR_USER,CHR_DATE_ENTRY,CHR_TIME_ENTRY) VALUES('".$header_key."','".$partno."',
	                '".$part_name."','PP04','".$sloc_to."','".$good_qty."','".$ip."','".$username."','".$date."','".$time."')");
	            }
	        
	            if ($repair_qty <> 0){
	            	$this->db->query("INSERT INTO TT_GOODS_MOVEMENT_H(CHR_PLANT,CHR_DATE,
	                CHR_TYPE_TRANS,CHR_DOCUMENT_DATE,CHR_MVMT_TYPE,CHR_IP,CHR_USER,CHR_NPK,CHR_VALIDATE,CHR_UPLOAD,
	                CHR_STATUS,CHR_REMARKS) VALUES('600','".$date."','DLRP','".$date."','325','".$ip."','".$username."','".$npk."','X','0','0','".$no_do."')");
	                
	                $header = $this->db->query('SELECT SCOPE_IDENTITY() AS header_key')->result();
	                $header_key = $header[0]->header_key;
	                //$this->db->query("DBCC CHECKIDENT ('TT_GOODS_MOVEMENT_L', RESEED, 0)");

	                $part_query = $this->db->query("SELECT CHR_PART_NAME FROM TM_PARTS WHERE CHR_PART_NO = '".$partno."'")->result();
	                $part_name = $part_query[0]->CHR_PART_NAME;
	                
	                $this->db->query("INSERT INTO TT_GOODS_MOVEMENT_L(INT_NUMBER,
	                CHR_PART_NO,CHR_PART_NAME,CHR_SLOC_FROM,CHR_SLOC_TO,INT_TOTAL_QTY,CHR_IP,CHR_USER,CHR_DATE_ENTRY,CHR_TIME_ENTRY) VALUES('".$header_key."','".$partno."',
	                '".$part_name."','PP04','".$sloc_to."','".$repair_qty."','".$ip."','".$username."','".$date."','".$time."')");
	                
	            }
	            if ($claim_qty <> 0){
	            	$this->db->query("INSERT INTO TT_GOODS_MOVEMENT_H(CHR_PLANT,CHR_DATE,
	                CHR_TYPE_TRANS,CHR_DOCUMENT_DATE,CHR_MVMT_TYPE,CHR_IP,CHR_USER,CHR_NPK,CHR_VALIDATE,CHR_UPLOAD,
	                CHR_STATUS,CHR_REMARKS) VALUES('600','".$date."','DLCL','".$date."','325','".$ip."','".$username."','".$npk."','X','0','0','".$no_do."')");
	                
	                $header = $this->db->query('SELECT SCOPE_IDENTITY() AS header_key')->result();
	                $header_key = $header[0]->header_key;
	                //$this->db->query("DBCC CHECKIDENT ('TT_GOODS_MOVEMENT_L', RESEED, 0)");

	                $part_query = $this->db->query("SELECT CHR_PART_NAME FROM TM_PARTS WHERE CHR_PART_NO = '".$partno."'")->result();
	                $part_name = $part_query[0]->CHR_PART_NAME;
	                
	                $this->db->query("INSERT INTO TT_GOODS_MOVEMENT_L(INT_NUMBER,
	                CHR_PART_NO,CHR_PART_NAME,CHR_SLOC_FROM,CHR_SLOC_TO,INT_TOTAL_QTY,CHR_IP,CHR_USER,CHR_DATE_ENTRY,CHR_TIME_ENTRY) VALUES('".$header_key."','".$partno."',
	                '".$part_name."','PP04','WH00','".$claim_qty."','".$ip."','".$username."','".$date."','".$time."')");
	                
	            }
	            // if ($scrap_qty <> 0){
	            // 	echo "scrap</br>";
	            //     $this->db->query("INSERT INTO TT_GOODS_MOVEMENT_H(CHR_PLANT,CHR_DATE,
	            //     CHR_TYPE_TRANS,CHR_DOCUMENT_DATE,CHR_MVMT_TYPE,CHR_IP,CHR_USER,CHR_NPK,CHR_VALIDATE,CHR_UPLOAD,
	            //     CHR_STATUS,CHR_REMARKS) VALUES('600','".$date."','DLSC','".$date."','343','".$ip."','".$username."','".$npk."','X','0','0','".$no_do."')");
	                
	            //     $header = $this->db->query('SELECT SCOPE_IDENTITY() AS header_key')->result();
	            //     $header_key = $header[0]->header_key;
	            //     //$this->db->query("DBCC CHECKIDENT ('TT_GOODS_MOVEMENT_L', RESEED, 0)");

	            //     $part_query = $this->db->query("SELECT CHR_PART_NAME FROM TM_PARTS WHERE CHR_PART_NO = '".$partno."'")->result();
	            //     $part_name = $part_query[0]->CHR_PART_NAME;
	                
	            //     $this->db->query("INSERT INTO TT_GOODS_MOVEMENT_L(INT_NUMBER,
	            //     CHR_PART_NO,CHR_PART_NAME,CHR_SLOC_FROM,CHR_SLOC_TO,INT_TOTAL_QTY,CHR_IP,CHR_USER,CHR_DATE_ENTRY,CHR_TIME_ENTRY) VALUES('".$header_key."','".$partno."',
	            //     '".$part_name."','PP04','PP04','".$scrap_qty."','".$ip."','".$username."','".$date."','".$time."')");
	            // }   
	        }
	        
	        $scrap_query = $this->db->query("select * from TT_QCE_L WHERE INT_QCE_NO = '".$no_qce."' AND INT_SCRAP_QTY >= 0");
	        
	        $count = 1;
	        if ($scrap_query->num_rows() >= 0){

	        	$date_now  = date('ym');
	        	$data_lkbq = $this->db->query("SELECT COUNT(CHR_LKB_DATE)+1 AS 
	        		LKB_NO FROM TT_NG_RECORD_H WHERE CHR_LKB_DATE = '$date_now'")->result();
	        	$no = $data_lkbq[0]->LKB_NO;
	        	$no_lkb = date('ym').str_pad($no, 6, "0", STR_PAD_LEFT);
	        	$this->db->query("INSERT INTO TT_NG_RECORD_H(CHR_PLANT, CHR_LKB_NO, CHR_LKB_DATE, CHR_LKB_NUM,INT_NPK_MSU,CHR_IP_MSU,CHR_USER_MSU,CHR_STATUS, CHR_PRINT_STATUS, CHR_AREA) VALUES('600','".$no_lkb."','".$date_now."','','".$npk."','".$ip."','".$username."','1','1','FG-004')");
	        	
	        	$header = $this->db->query('SELECT SCOPE_IDENTITY() AS header_key')->result();
	                $header_key = $header[0]->header_key;
	            foreach ($scrap_query->result() as $scrap){
	                //echo ("sasa<br/>");
	                //echo $header_key;
	                $query_material = $this->db->query("SELECT CHR_PART_NO, CHR_BACK_NO FROM TM_PARTS WHERE CHR_PART_NO = '".$scrap->CHR_PART_NO."'")->result();
	                
	                $this->db->query("INSERT INTO TT_NG_RECORD_L(CHR_PLANT,INT_NUMBER,CHR_LKB_NO,
	                CHR_AREA,CHR_PART_NO,CHR_BACK_NO,CHR_SLOC_FROM,CHR_SLOC_TO,INT_TOTAL_QTY,
	                CHR_DAMAGE_CODE,INT_NPK,CHR_IP,CHR_USER,CHR_DATE_UPLOAD,CHR_TIME_UPLOAD,CHR_KODE) VALUES(
	                '600','".$header_key."','lkb','FG-004','".$scrap->CHR_PART_NO."','".$query_material[0]->CHR_BACK_NO."'
	                ,'$scrap->CHR_SLOC_TO','RE01','".$scrap->INT_SCRAP_QTY."','H','".$npk."','".$ip."','".$username."','".date('Ymd')."','".date('Hms')."','1')");
	                $count++;
	            
	            	$this->db->query("UPDATE TT_QCE_L SET CHR_LKB_NO = '".$no_lkb."' WHERE INT_QCE_NO = '".$no_qce."'");
	            }
	        }

	        if ($this->db->trans_status() === FALSE) {
	            $this->db->trans_rollback();
	        }else {
	            $this->db->trans_commit();
	        }
	        echo '<script>window.open("'. base_url(). 'index.php/qc/qc/generate/'. $no_qce .'" ,"_blank")</script>';
	        redirect("qc/qc", 'refresh');

    }

    //echo '<script>window.open("'. base_url(). 'index.php/qc/qc/generate/'. $no_qce .'" ,"_blank")</script>';
    //redirect("qc/qc", 'refresh');

    public function generate($qce_no) {
        $query_qc = $this->db->query("SELECT * FROM TT_QCE_L WHERE INT_QCE_NO = '".$qce_no."'");
        $qc_num   = $query_qc->num_rows();

        $data['mvt'] = '311';
        $goods = array();
        $goods_index = 1;
        $repair = array();
        $repair_index = 1;
        $claim = array();
        $claim_index = 1; 
        $scrap = array();
        $scrap_index = 1;
        $no = $query_qc->result();
        $data['no'] = $no[0]->INT_QCE_NO;
        echo $no[0]->INT_QCE_NO;
        foreach ($query_qc->result() as $data_qc){
        	//$info_part = $this->db->query("select CHR_SLOC CHR_BACK_NO, CHR_PART_UOM, CHR_PART_NAME 
        	//FROM TM_PARTS 
        	//JOIN TM_PARTS_SLOC ON TM_PARTS.CHR_PART_NO = TM_PARTS_SLOC.CHR_PART_NO
        	//WHERE TM_PARTS.CHR_PART_NO LIKE '".$data_qc->CHR_PART_NO."%' AND CHR_SLOC LIKE 'PP%' AND CHR_SLOC LIKE 'PP%'")->result();
        	$info_part = $this->db->query("select CHR_BACK_NO, CHR_PART_UOM, CHR_PART_NAME 
        	FROM TM_PARTS WHERE TM_PARTS.CHR_PART_NO LIKE '".$data_qc->CHR_PART_NO."%'")->result();
        	if($data_qc->INT_GOODS_QTY != 0 ){
        		$goods[$goods_index]['part_no'] = $data_qc->CHR_PART_NO;
        		$goods[$goods_index]['part_name'] = $info_part[0]->CHR_PART_NAME;
        		$goods[$goods_index]['part_uom'] = $info_part[0]->CHR_PART_UOM;
        		$goods[$goods_index]['back_no'] = $info_part[0]->CHR_BACK_NO;
        		$goods[$goods_index]['qty'] = $data_qc->INT_GOODS_QTY;
        		$goods[$goods_index]['sloc_to'] = $data_qc->CHR_SLOC_TO;
        		$goods_index++;
        		
        	}
        	if($data_qc->INT_REPAIR_QTY != 0 ){
        		$repair[$repair_index]['part_no'] = $data_qc->CHR_PART_NO;
        		$repair[$repair_index]['part_name'] = $info_part[0]->CHR_PART_NAME;
        		$repair[$repair_index]['part_uom'] = $info_part[0]->CHR_PART_UOM;
        		$repair[$repair_index]['back_no'] = $info_part[0]->CHR_BACK_NO;
        		$repair[$repair_index]['qty'] = $data_qc->INT_REPAIR_QTY;
        		$repair[$repair_index]['sloc_to'] = $data_qc->CHR_SLOC_TO;
        		$repair_index++;
        		
        	}
        	if($data_qc->INT_CLAIM_QTY != 0 ){
        		$claim[$claim_index]['part_no'] = $data_qc->CHR_PART_NO;
        		$claim[$claim_index]['part_name'] = $info_part[0]->CHR_PART_NAME;
        		$claim[$claim_index]['part_uom'] = $info_part[0]->CHR_PART_UOM;
        		$claim[$claim_index]['back_no'] = $info_part[0]->CHR_BACK_NO;
        		$claim[$claim_index]['qty'] = $data_qc->INT_CLAIM_QTY;
        		$claim[$claim_index]['sloc_to'] = $data_qc->CHR_SLOC_TO;
        		$claim_index++;
        		
        	}
        	if($data_qc->INT_SCRAP_QTY != 0 ){
        		$scrap[$scrap_index]['part_no'] = $data_qc->CHR_PART_NO;
        		$scrap[$scrap_index]['part_name'] = $info_part[0]->CHR_PART_NAME;
        		$scrap[$scrap_index]['part_uom'] = $info_part[0]->CHR_PART_UOM;
        		$scrap[$scrap_index]['back_no'] = $info_part[0]->CHR_BACK_NO;
        		$scrap[$scrap_index]['qty'] = $data_qc->INT_SCRAP_QTY;
        		$scrap[$scrap_index]['sloc_to'] = $data_qc->CHR_SLOC_TO;
        		$scrap_index++;
        		
        	}
        	
        }
        $data['goods'] = $goods;
        $data['repair'] = $repair;
        $data['claim'] = $claim;
        $data['scrap'] = $scrap;

        $a = $query_qc->result();
        $data['scrapsloc'] = $a[0]->CHR_SLOC_TO;
		$data['lkbno']     = $a[0]->CHR_LKB_NO;
        $data['qc_num'] = ceil($qc_num / 15);
      
        // Load all views as normal
        $this->load->view('qc/qc_template',$data);
//        $this->load->view('do_template1', $data);
        // Get output html
        $html = $this->output->get_output();

        // Load library
        $this->load->library('dompdf_gen');
        $this->dompdf->set_paper("Letter", "portrait");
//         Convert to PDF
        $this->dompdf->load_html($html);
        $this->dompdf->render();
        $this->dompdf->stream("stok_transfer_slip_aisin.pdf", array('Attachment' => 0));

        //  or without preview in browser
//        $this->dompdf->stream("welcome.pdf");
    }

    public function cancel() {
        $this->role_module_m->authorization('16');
        $this->session->userdata('user_id');
		$this->load->library('form_validation');

        $data['content'] = 'qc/qc_cancel';
        $data['title'] = 'Cancel QC';

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(104);
        $data['news'] = $this->news_m->get_news();

        $this->load->view($this->layout, $data);
    }

    public function getTableDOCancel(){

    	// $npk = $this->session->userdata('NPK');
    	// $username = $this->session->userdata('USERNAME');
    	// $ip  = $this->session->userdata('ip_address');

    	// echo $npk . $username . $ip;

    	$no_do = $this->input->post('no_do');

    	// $jaga_query = $this->db->query("SELECT CHR_DEL_NO FROM TT_DELIVERY WHERE CHR_DEL_NO = '$no_do' AND CHR_DEL_TYPE = 'ZRFM'");
    	$jaga_query = $this->db->query("SELECT INT_QCE_NO FROM TT_QCE_H WHERE CHR_DEL_NO = '$no_do'");

    	if($jaga_query->num_rows() > 0){

    		$res = $jaga_query->result();
    		$del_query = $this->db->query("SELECT CHR_PART_NO, INT_DEL_QTY, INT_GOODS_QTY, INT_REPAIR_QTY, INT_CLAIM_QTY, INT_SCRAP_QTY, CHR_SLOC_TO FROM TT_QCE_L WHERE INT_QCE_NO = '".$res[0]->INT_QCE_NO."'");

	    	if($del_query->num_rows() > 0){
	    		$del_item = $del_query->result();
	    		$data = '<table class="tg" id="dataTable" width="100%" style="margin-top:10px" border="1">';
	    		$data.='<tr><th class="tg-031e" style="text-align:center" width="50">No.</th><th class="tg-031e" style="text-align:center" width="180">Part No.</th><th class="tg-031e" style="text-align:center" width="425">Part Name</th><th width="70" class="tg-031e" style="text-align:center;">Qty Goods</th><th width="70" class="tg-031e" style="text-align:center;">Qty Repair</th><th width="70" class="tg-031e" style="text-align:center;">Qty Claim to Vendor</th>
	    		<th width="70" class="tg-031e" style="text-align:center;">Qty Scrap</th><th class="tg-031e" style="text-align:center">SLoc To</th></tr>';
	    		$x = 1;
	    		foreach ($del_item as $value) {

	    			$part_no = trim($value->CHR_PART_NO);
	    			$partnameq = $this->db->query("SELECT CHR_PART_NAME FROM TM_PARTS WHERE CHR_PART_NO = '".$part_no."'")->result();
        			//$part_no = substr($part_no, 0, 6).'-'.substr($part_no, 6, 11);

					$partno = trim($value->CHR_PART_NO);
                    //$partno = trim('-1234567890abcdef');
                    $length = strlen($partno);
                    $bag1   = substr($partno, 0, 6);
                    $sisa   = (int)$length - 6;
                    //echo $sisa;
                    if($sisa <= 5){
             	        $bag2 = substr($partno, 6, $sisa);
                    }else{
                        $bag2 = substr($partno, 6, 5);
                        $sisa = (int)$length - 11;
                    }
                    //echo $sisa;
                    $partsisa = substr($partno, 11, $sisa);
                    $bag3     = str_split($partsisa, 2);
                    //echo $partsisa;
                    if(substr($bag1, 0, 1) == '-'){
              	        $bag1 = str_replace('-', '', $bag1);
                    }

                    $partnobaru = $bag1.'-'.$bag2;
                    //echo $partnobaru;
                    for($i = 0; $i < sizeof($bag3); $i++){
                        if($bag3[$i] == ''){
                            $partnobaru .= $bag3[$i];
                        }else{
                            $partnobaru .= '-'.$bag3[$i];
                        }
                    }
                    //echo $partnobaru;        			

	    			$data.='<tr>';
	    			$data.='<td class="tg-031e" style="text-align:center"><input type="hidden" name = "item_'.$x.'"/>'.$x.'</td>';
	    			$data.='<td class="tg-031e" ><input type="text" onkeypress="return (event.charCode >= 48 && event.charCode <= 57)||event.charCode <= 8" style="text-align:center; height:35px" class="form-control" readonly="readonly" name="partno_'.$x.'" id="partno_'.$x.'" value="'.$partnobaru.'" /></td>';
	    			$data.='<td class="tg-031e" style="text-align:center"><input type="text" onkeypress="return (event.charCode >= 48 && event.charCode <= 57)||event.charCode <= 8" style="text-align:center; height:35px"class="form-control" readonly="readonly" name="partno_'.$x.'" id="partno_'.$x.'" value="'.trim($partnameq[0]->CHR_PART_NAME).'" /></td>';
	    			$data.='<td class="tg-031e"><input type="text" onkeypress="return (event.charCode >= 48 && event.charCode <= 57)||event.charCode <= 8" style="text-align:center; height:35px" class="form-control" readonly="readonly" name="partno_'.$x.'" id="partno_'.$x.'" value="'.$value->INT_GOODS_QTY.'" /></td>';
	    			$data.='<td class="tg-031e"><input type="text" onkeypress="return (event.charCode >= 48 && event.charCode <= 57)||event.charCode <= 8" style="text-align:center; height:35px" class="form-control" readonly="readonly" name="partno_'.$x.'" id="partno_'.$x.'" value="'.$value->INT_REPAIR_QTY.'" /></td>';
	    			$data.='<td class="tg-031e"><input type="text" onkeypress="return (event.charCode >= 48 && event.charCode <= 57)||event.charCode <= 8" style="text-align:center; height:35px" class="form-control" readonly="readonly" name="partno_'.$x.'" id="partno_'.$x.'" value="'.$value->INT_CLAIM_QTY.'" /></td>';
	    			$data.='<td class="tg-031e"><input type="text" onkeypress="return (event.charCode >= 48 && event.charCode <= 57)||event.charCode <= 8" style="text-align:center; height:35px" class="form-control" readonly="readonly" name="partno_'.$x.'" id="partno_'.$x.'" value="'.$value->INT_SCRAP_QTY.'" /></td>';
	    			$data.='<td class="tg-031e"><input type="text" onkeypress="return (event.charCode >= 48 && event.charCode <= 57)||event.charCode <= 8" style="text-align:center; height:35px" class="form-control" readonly="readonly" name="partno_'.$x.'" id="partno_'.$x.'" value="'.trim($value->CHR_SLOC_TO).'" /></td>';
	    			$data.='</tr>';
	    			$x++;
	    		}
	    		$data.= '</table>';
	    		$data.='<input type="hidden" name="no" id="no" value="'.$x.'"/>';
	    	}
	    	else{
	    		$data = '<div style="padding-left:20px; background-color:white; font-size:12px; font-style:bold"> Data tidak ditemukan.</div>';
	    	}
    	}
    	else{
    		$data = '<div style="padding-left:18px; margin-top:20px; background-color:white; color:red; font-size:12px; border-radius: 5px"> Maaf, Data tidak ditemukan.</div>';
    	}

    	echo $data;
    }

    public function saveDataCancel(){
        $date = date('Ymd');
        $time = date('Hms');

        	//print_r($this->session->all_userdata());
	        $npk = $this->session->userdata('NPK');
	        $username = $this->session->userdata('USERNAME');
	        $ip  = $this->session->userdata('ip_address');

	        $this->db->trans_begin();

	        $no_do = $this->input->post('no_del');
	        $no = $this->input->post('no');
	        $this->db->query("INSERT INTO TT_QCE_H(CHR_DEL_NO, CHR_CREATE_DATE, CHR_CREATE_TIME, CHR_CREATE_USER) VALUES ('".$no_do."', '".$date."', '".$time."', '".$username."');");
	        //echo $this->db->_error_message();
	        //$data = $this->db->query("select INT_QCE_NO from TT_QCE_H where CHR_DEL_NO = '".$no_do."'")->result();
	        //$no_qce = $data[0]->INT_QCE_NO;

	        $header = $this->db->query('SELECT SCOPE_IDENTITY() AS header_key')->result();
	        $no_qce = $header[0]->header_key;

	        //echo '<script>alert("lalalala")</script>';

	        for($x = 1; $x < $no; $x++){
	            $good_qty = $this->input->post('good_'.$x);
	            $item = $this->input->post('item_'.$x);

	            //$partno = $this->input->post('partno_'.$x);
	            //$partno = str_replace('-', '', $partno);

	            $partno = $this->input->post('partnohid_'.$x);

	            $del_qty = $this->input->post('del_'.$x);
	            $repair_qty = $this->input->post('repair_'.$x);
	            $claim_qty = $this->input->post('claim_'.$x);
	            $scrap_qty = $this->input->post('scrap_'.$x);
	            $sloc_to = $this->input->post('slocto_'.$x);
	            $this->db->query("INSERT INTO TT_QCE_L(INT_QCE_NO,INT_QCE_ITEM,CHR_PART_NO,
	            INT_DEL_QTY,INT_GOODS_QTY,INT_REPAIR_QTY,INT_CLAIM_QTY,INT_SCRAP_QTY, CHR_CREATE_DATE, CHR_CREATE_TIME, CHR_CREATE_USER, CHR_SLOC_TO,CHR_DEL_ITEM) 
	            VALUES ('".$no_qce."','".$x."','".$partno."','".$del_qty."','".$good_qty."','".$repair_qty."','".$claim_qty."','".$scrap_qty."', '".$date."', '".$time."', '".$username."', '".$sloc_to."','".$item."');");
	            if ($good_qty <> 0){
	                $this->db->query("INSERT INTO TT_GOODS_MOVEMENT_H(CHR_PLANT,CHR_DATE,
	                CHR_TYPE_TRANS,CHR_DOCUMENT_DATE,CHR_MVMT_TYPE, CHR_IP, CHR_USER, CHR_NPK, CHR_VALIDATE,CHR_UPLOAD,
	                CHR_STATUS,CHR_REMARKS) VALUES('600','".$date."','DLGD','".$date."','343', '".$ip."', '".$username."', '".$npk."','X','0','0','".$no_do."')");
	                
	                // $header = $this->db->query("SELECT INT_NUMBER AS header_key from TT_GOODS_MOVEMENT_H 
	                // WHERE CHR_REMARKS = '".$no_do."' and CHR_TYPE_TRANS = 'TPGD'")->result();
	                $header = $this->db->query('SELECT SCOPE_IDENTITY() AS header_key')->result();
	                $header_key = $header[0]->header_key;
	                //$this->db->query("DBCC CHECKIDENT ('TT_GOODS_MOVEMENT_L', RESEED, 0)");

	                $part_query = $this->db->query("SELECT CHR_PART_NAME FROM TM_PARTS WHERE CHR_PART_NO = '".$partno."'")->result();
	                $part_name = $part_query[0]->CHR_PART_NAME;
	                
	                $this->db->query("INSERT INTO TT_GOODS_MOVEMENT_L(INT_NUMBER,
	                CHR_PART_NO,CHR_PART_NAME,CHR_SLOC_FROM,CHR_SLOC_TO,INT_TOTAL_QTY,CHR_IP,CHR_USER,CHR_DATE_ENTRY,CHR_TIME_ENTRY) VALUES('".$header_key."','".$partno."',
	                '".$part_name."','PP04','".$sloc_to."','".$good_qty."','".$ip."','".$username."','".$date."','".$time."')");
	            }
	        
	            if ($repair_qty <> 0){
	            	$this->db->query("INSERT INTO TT_GOODS_MOVEMENT_H(CHR_PLANT,CHR_DATE,
	                CHR_TYPE_TRANS,CHR_DOCUMENT_DATE,CHR_MVMT_TYPE,CHR_IP,CHR_USER,CHR_NPK,CHR_VALIDATE,CHR_UPLOAD,
	                CHR_STATUS,CHR_REMARKS) VALUES('600','".$date."','DLRP','".$date."','325','".$ip."','".$username."','".$npk."','X','0','0','".$no_do."')");
	                
	                $header = $this->db->query('SELECT SCOPE_IDENTITY() AS header_key')->result();
	                $header_key = $header[0]->header_key;
	                //$this->db->query("DBCC CHECKIDENT ('TT_GOODS_MOVEMENT_L', RESEED, 0)");

	                $part_query = $this->db->query("SELECT CHR_PART_NAME FROM TM_PARTS WHERE CHR_PART_NO = '".$partno."'")->result();
	                $part_name = $part_query[0]->CHR_PART_NAME;
	                
	                $this->db->query("INSERT INTO TT_GOODS_MOVEMENT_L(INT_NUMBER,
	                CHR_PART_NO,CHR_PART_NAME,CHR_SLOC_FROM,CHR_SLOC_TO,INT_TOTAL_QTY,CHR_IP,CHR_USER,CHR_DATE_ENTRY,CHR_TIME_ENTRY) VALUES('".$header_key."','".$partno."',
	                '".$part_name."','PP04','".$sloc_to."','".$repair_qty."','".$ip."','".$username."','".$date."','".$time."')");
	                
	            }
	            if ($claim_qty <> 0){
	            	$this->db->query("INSERT INTO TT_GOODS_MOVEMENT_H(CHR_PLANT,CHR_DATE,
	                CHR_TYPE_TRANS,CHR_DOCUMENT_DATE,CHR_MVMT_TYPE,CHR_IP,CHR_USER,CHR_NPK,CHR_VALIDATE,CHR_UPLOAD,
	                CHR_STATUS,CHR_REMARKS) VALUES('600','".$date."','DLCL','".$date."','325','".$ip."','".$username."','".$npk."','X','0','0','".$no_do."')");
	                
	                $header = $this->db->query('SELECT SCOPE_IDENTITY() AS header_key')->result();
	                $header_key = $header[0]->header_key;
	                //$this->db->query("DBCC CHECKIDENT ('TT_GOODS_MOVEMENT_L', RESEED, 0)");

	                $part_query = $this->db->query("SELECT CHR_PART_NAME FROM TM_PARTS WHERE CHR_PART_NO = '".$partno."'")->result();
	                $part_name = $part_query[0]->CHR_PART_NAME;
	                
	                $this->db->query("INSERT INTO TT_GOODS_MOVEMENT_L(INT_NUMBER,
	                CHR_PART_NO,CHR_PART_NAME,CHR_SLOC_FROM,CHR_SLOC_TO,INT_TOTAL_QTY,CHR_IP,CHR_USER,CHR_DATE_ENTRY,CHR_TIME_ENTRY) VALUES('".$header_key."','".$partno."',
	                '".$part_name."','PP04','WH00','".$claim_qty."','".$ip."','".$username."','".$date."','".$time."')");
	                
	            }
	            // if ($scrap_qty <> 0){
	            // 	echo "scrap</br>";
	            //     $this->db->query("INSERT INTO TT_GOODS_MOVEMENT_H(CHR_PLANT,CHR_DATE,
	            //     CHR_TYPE_TRANS,CHR_DOCUMENT_DATE,CHR_MVMT_TYPE,CHR_IP,CHR_USER,CHR_NPK,CHR_VALIDATE,CHR_UPLOAD,
	            //     CHR_STATUS,CHR_REMARKS) VALUES('600','".$date."','DLSC','".$date."','343','".$ip."','".$username."','".$npk."','X','0','0','".$no_do."')");
	                
	            //     $header = $this->db->query('SELECT SCOPE_IDENTITY() AS header_key')->result();
	            //     $header_key = $header[0]->header_key;
	            //     //$this->db->query("DBCC CHECKIDENT ('TT_GOODS_MOVEMENT_L', RESEED, 0)");

	            //     $part_query = $this->db->query("SELECT CHR_PART_NAME FROM TM_PARTS WHERE CHR_PART_NO = '".$partno."'")->result();
	            //     $part_name = $part_query[0]->CHR_PART_NAME;
	                
	            //     $this->db->query("INSERT INTO TT_GOODS_MOVEMENT_L(INT_NUMBER,
	            //     CHR_PART_NO,CHR_PART_NAME,CHR_SLOC_FROM,CHR_SLOC_TO,INT_TOTAL_QTY,CHR_IP,CHR_USER,CHR_DATE_ENTRY,CHR_TIME_ENTRY) VALUES('".$header_key."','".$partno."',
	            //     '".$part_name."','PP04','PP04','".$scrap_qty."','".$ip."','".$username."','".$date."','".$time."')");
	            // }   
	        }
	        
	        $scrap_query = $this->db->query("select * from TT_QCE_L WHERE INT_QCE_NO = '".$no_qce."' AND INT_SCRAP_QTY >= 0");
	        
	        $count = 1;
	        if ($scrap_query->num_rows() >= 0){

	        	$date_now  = date('ym');
	        	$data_lkbq = $this->db->query("SELECT COUNT(CHR_LKB_DATE)+1 AS 
	        		LKB_NO FROM TT_NG_RECORD_H WHERE CHR_LKB_DATE = '$date_now'")->result();
	        	$no = $data_lkbq[0]->LKB_NO;
	        	$no_lkb = date('ym').str_pad($no, 6, "0", STR_PAD_LEFT);
	        	$this->db->query("INSERT INTO TT_NG_RECORD_H(CHR_PLANT, CHR_LKB_NO, CHR_LKB_DATE, CHR_LKB_NUM,INT_NPK_MSU,CHR_IP_MSU,CHR_USER_MSU,CHR_STATUS, CHR_PRINT_STATUS, CHR_AREA) VALUES('600','".$no_lkb."','".$date_now."','','".$npk."','".$ip."','".$username."','1','1','FG-004')");
	        	
	        	$header = $this->db->query('SELECT SCOPE_IDENTITY() AS header_key')->result();
	                $header_key = $header[0]->header_key;
	            foreach ($scrap_query->result() as $scrap){
	                //echo ("sasa<br/>");
	                //echo $header_key;
	                $query_material = $this->db->query("SELECT CHR_PART_NO, CHR_BACK_NO FROM TM_PARTS WHERE CHR_PART_NO = '".$scrap->CHR_PART_NO."'")->result();
	                
	                $this->db->query("INSERT INTO TT_NG_RECORD_L(CHR_PLANT,INT_NUMBER,CHR_LKB_NO,
	                CHR_AREA,CHR_PART_NO,CHR_BACK_NO,CHR_SLOC_FROM,CHR_SLOC_TO,INT_TOTAL_QTY,
	                CHR_DAMAGE_CODE,INT_NPK,CHR_IP,CHR_USER,CHR_DATE_UPLOAD,CHR_TIME_UPLOAD,CHR_KODE) VALUES(
	                '600','".$header_key."','lkb','FG-004','".$scrap->CHR_PART_NO."','".$query_material[0]->CHR_BACK_NO."'
	                ,'$scrap->CHR_SLOC_TO','RE01','".$scrap->INT_SCRAP_QTY."','H','".$npk."','".$ip."','".$username."','".date('Ymd')."','".date('Hms')."','1')");
	                $count++;
	            
	            	$this->db->query("UPDATE TT_QCE_L SET CHR_LKB_NO = '".$no_lkb."' WHERE INT_QCE_NO = '".$no_qce."'");
	            }
	        }

	        if ($this->db->trans_status() === FALSE) {
	            $this->db->trans_rollback();
	        }else {
	            $this->db->trans_commit();
	        }
	        echo '<script>window.open("'. base_url(). 'index.php/qc/qc/generate/'. $no_qce .'" ,"_blank")</script>';
	        redirect("qc/qc", 'refresh');

    }

    public function report($start_date = null, $finish_date = null) {
        $this->role_module_m->authorization('16');
        $this->session->userdata('user_id');
		$this->load->library('form_validation');

        $data['content'] = 'qc/qc_report';
        $data['title'] = 'Report QC';

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(105);
        $data['news'] = $this->news_m->get_news();

        $this->load->view($this->layout, $data);


        if ($this->input->post('btn_filter_by_date')) {
            $start_date = $this->input->post('start_date');
            $finish_date = $this->input->post('finish_date');
            $start_date = date("Ymd", strtotime($start_date));
            $finish_date = date("Ymd", strtotime($finish_date));
            redirect("delivery_order/report/$start_date/$finish_date", "refresh");
        }
        if ($start_date == null and $finish_date == null) {
            $start_date = date("Ymd");
            $finish_date = date("Ymd");
        } elseif ($start_date == null) {
            $start_date = date("Ymd");
        } elseif ($finish_date == null) {
            $finish_date = date("Ymd");
        }

        $this->db->query("SELECT * FROM TT_QCE_H WHERE CHR_CREATE_DATE BETWEEN '$start_date' AND '$finish_date'")->result()	;
    }

}

?>