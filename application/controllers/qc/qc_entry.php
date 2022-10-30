<?php

class Qc_entry extends CI_Controller {
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
    }

    public function index() {
        $this->role_module_m->authorization('16');
        $this->session->userdata('user_id');
		$this->load->library('form_validation');

        $data['content'] = 'qc/qc_entry';
        $data['title'] = 'QC Entry System';

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(16);
        $data['news'] = $this->news_m->get_news();

        $this->load->view($this->layout, $data);
    }
    public function entry(){
    	$this->session->userdata('user_id');

        $data['content'] = 'qc/qc';
        $data['title'] = 'QC Entry Sheet';

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(76);
		
		$this->load->view($this->layout, $data);
    }
    public function getTableDO(){
    	$no_do = $this->input->post('no_do');
    	$del_item = $this->db->query("select CHR_PART_NO, INT_TOTAL_QTY from TT_DELIVERY_ITEM where CHR_DEL_NO = '$no_do' order by CHR_DEL_ITEM")->result();
    	//$data['del_item'] = $del_item;
    	$data = '<table id="dataTable" width="100%" border="1" >';
    	$data.='<tr><th>No</th><th>Part No</th><th>Delivery Quantity</th>
    	<th>Qty Goods</th><th>Qty Repair</th>
    	<th>Qty Claim to Vendor</th>
    	<th>Qty Scrap</th></tr>';
    	$x = 1;
    	foreach ($del_item as $value) {
    		$data.='<tr>';
    		$data.='<td>'.$x.'</td>';
    		$data.='<td><input type="text" class="form-control" name="partno_'.$x.'" value="'.$value->CHR_PART_NO.'" /></td>';
    		$data.='<td><input type="text" class="form-control" name="del_'.$x.'" value="'.$value->INT_TOTAL_QTY.'" /></td>';
    		$data.='<td><input type="text" class="form-control" name="good_'.$x.'" value="0" /></td>';
    		$data.='<td><input type="text" class="form-control" name="repair_'.$x.'" value="0" /></td>';
    		$data.='<td><input type="text" class="form-control" name="claim_'.$x.'" value="0" /></td>';
    		$data.='<td><input type="text" class="form-control" name="scrap_'.$x.'" value="0" /></td>';
    		$data.='</tr>';
    		$x++;
    		
    	}
    	
    	$data.= '</table>';
    	$data.='<input type="hidden" name="no" value="'.$x.'"/>';
    	
    	echo $data;
    }
    public function saveData(){
    	$no_do = $this->input->post('no_del');
    	$no = $this->input->post('no');
    	$this->db->query("INSERT INTO TT_QCE_H(CHR_DEL_NO) VALUES ('".$no_do."');");
    	echo $this->db->_error_message();
    	$data = $this->db->query("select INT_QCE_NO from TT_QCE_H where CHR_DEL_NO = '".$no_do."'")->result();
    	$no_qce = $data[0]->INT_QCE_NO;
    	for($x = 1; $x<$no; $x++){
    		$good_qty = $this->input->post('good_'.$x);
    		$repair_qty = $this->input->post('repair_'.$x);
    		$claim_qty = $this->input->post('claim_'.$x);
    		$scrap_qty = $this->input->post('scrap_'.$x);
    		$this->db->query("INSERT INTO TT_QCE_L('INT_QCE_NO','INT_QCE_ITEM','CHR_PART_NO',
    		'INT_DEL_QTY','INT_GOODS_QTY','INT_REPAIR_QTY','INT_CLAIM_QTY','INT_SCRAP_QTY') 
    		VALUES ('".$no_qce."','".$x."','','','','','','')");
    	}
    	
    	echo $no_do."<br/>".$no;
    	
    	
    }

}

?>