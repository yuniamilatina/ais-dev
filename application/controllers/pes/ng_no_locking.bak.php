<?php 

/**
*  NG NO LOCKING
*  @author kb.hartanto@gmail.com
*/
class ng_no_locking extends CI_Controller
{
	//set layout
	private $layout = '/template/head';
	private $breadcrumb;
	function __construct()
	{
		parent::__construct();	
		if (!$this->session->userdata('ROLE')) redirect();
		$this->output->enable_profiler(false);
        // load vars default
        $this->default_vars();

	}
	public function index()
	{
		redirect('/pes/ng_no_locking/area');
	}
	
	public function area() {
		$data['breadcrumb'] = array('Home' => site_url('/basis/home_c'),'No Locking' => site_url('pes/ng_no_locking'), 'Select Area' => '' );
		// get users location
		$user = $this->session->all_userdata();
		$this->nolocking->clear_session();
		//var_dump($user['DEPT']);die();
		if ( in_array($user['DEPT'], array(21,22,23,24) ) )
		{
			$data['location'] = array('WP01','WP02');
		} elseif ( $user ['DEPT'] == 20  ) {
			$data['location'] = array('WH00','PP01','PP02','PP03');
		} elseif ( $user ['DEPT'] == 6)	{ //
			$data['location'] = 'EN01';
		}
		$this->session->flashdata('area');
		$data['area'] = $this->nolocking->execute(array('where'=>'CHR_FLAG_DELETE IS NULL'),'tm_area');
		$this->setVars($data);
	}
	public function engineering()
	{	
		$data = $this->session->flashdata('form');

		// edit sella need change 2016-03-17		
		$data['damage'] = $this->nolocking->execute(array('where'=>'CHR_FLAG_DELETE IS NULL'),'tm_damage');

		$data['error'] = $this->session->flashdata('error');
		// check user as enginnering, if not autorize show 404
		$user = $this->session->all_userdata();
		if ( isset($user['DEPT']) && !in_array($user['DEPT'], array(6,20)) ) show_404();

		$data['ppic'] = ($user['DEPT'] == 20)? true : false ;

		$data['location'] = $this->session->flashdata('location');
	    if(empty($data['location'])) redirect(site_url('pes/ng_no_locking'));
	    
	    $data['table'] = $this->nolocking->screen_table( $this->session->flashdata('area'),'engineering');

		$this->setVars($data);
	}
	public function production()
	{
		$data = $this->session->flashdata('form');

		// edit sella need change 2016-03-17		
		$data['part'] = $this->nolocking->execute(array('where'=>'CHR_FLAG_DELETE IS NULL'),'tm_parts');
		$data['ng'] = $this->nolocking->execute(array('where'=>'CHR_FLAG_DELETE IS NULL'),'tm_ng');
		$data['error'] = $this->session->flashdata('error');
		$data['reject'] = $this->nolocking->execute(array('where'=>'CHR_FLAG_DELETE IS NULL'),'tm_reject');
		//check user as production if no autorize show 404
		$user = $this->session->all_userdata();
		if ( !in_array($user['DEPT'], array(20,21,22,23,24)) ) show_404();
		//get data session and keep session
	    $data['location'] = $this->session->flashdata('location');

	    // if(empty($data['location'])) redirect(site_url('pes/ng_no_locking'));
	    
	    $data['table'] = $this->nolocking->screen_table( $this->session->flashdata('area'),'production');
	    
		$this->setVars($data);
	}
	public function validation()
	{

		$post = $_GET;
		//print_r($_POST);return;
		if ($_GET && isset($_GET['load'])) {
			$data = $this->nolocking->validation();

		} elseif ( $_GET && isset($_GET['save'])) {
			if (isset($post['INT_NUMBER'])){
				$save = $this->nolocking->validation($post);
				if ($save)
				{
					$setPrint['CHR_AREA'] = $_GET['CHR_AREA'];	
					$setPrint['CHR_LKB_NO'] = $save['CHR_LKB_NO'];
					return $this->print_lkb($setPrint);
				}
			} else {
				if (isset($_GET['CHR_AREA']) && empty($_GET['CHR_AREA'])) $data['message'] = "Harap Memasukkan Area yang akan Divalidasi";
				else $data['message'] = "TIdak ada data pada Area yang akan Divalidasi"; 				
			}
		}
		$data['CHR_LKB_NO'] = @$post['CHR_LKB_NO']; 
		$data['area'] = $this->nolocking->execute(array('where'=>'CHR_FLAG_DELETE IS NULL'),'tm_area');
		$data['CHR_AREA'] = @$post['CHR_AREA']; 

		$this->table->set_heading('No', 'Back Number', 'Part Number', 'Part Name','Reject Type', 'NG Category','Damage Code', 'Quantity', 'UOM','<input type="checkbox" class="form-control" id="validAll"/>');
		if ($this->nolocking->total_items('print') > 0 )
		{
			$this->nolocking->clear_session();
			redirect(site_url('/pes/ng_no_locking/validation'));
		}
		$this->setVars(@$data);
	}
	public function receiving_msu($update='')
	{
		@$data['CHR_LKB_NO'] = $this->input->post('CHR_LKB_NO');
		if ($_POST && empty($update))
		{
			$msu = $this->nolocking->generate_msu();
			if (!isset($msu['status']))
			{
				foreach ($msu as $key => $value) {
					$part = $this->nolocking->execute(array('select' => 'CHR_PART_NAME, CHR_PART_UOM','where' => array('CHR_PART_NO' => $value->CHR_PART_NO)),'tm_parts',true);
					$data['table'][$key]['No'] = $key + 1;
					$data['table'][$key]['CHR_BACK_NO'] =  $value->CHR_BACK_NO;
					$data['table'][$key]['CHR_PART_NO'] = $value->CHR_PART_NO;
					$data['table'][$key]['CHR_PART_NAME'] = $part->CHR_PART_NAME;
					$data['table'][$key]['CHR_REJECT_CODE'] = @$this->nolocking->execute(array('where' => array('CHR_REJECT_CODE'=> $value->CHR_REJECT_CODE)),'tm_reject',true)->CHR_REJECT_TYPE;
					$data['table'][$key]['CHR_NG_CATEGORY_CODE'] = @$this->nolocking->execute(array('where' => array('CHR_NG_CATEGORY_CODE'=> $value->CHR_NG_CATEGORY_CODE)),'tm_ng',true)->CHR_NG_CATEGORY;
					$data['table'][$key]['CHR_DAMAGE_CODE'] = $value->CHR_DAMAGE_CODE;
					$data['table'][$key]['INT_TOTAL_QTY'] = $value->INT_TOTAL_QTY;
					$data['table'][$key]['CHR_UOM'] = (!empty($value->CHR_UOM))? $value->CHR_UOM : $part->CHR_PART_UOM ;
							}
			} else {
				$data['error'] = $msu['message'];
			}

		} elseif ($_POST && !empty($update) ) {
			if (isset($data['CHR_LKB_NO']) && empty($data['CHR_LKB_NO'])) {
				$data['error'] = "Masukan No LKB yang valid.";
			}
			if (isset($_POST['nottrue']))
			{
				$save = $this->nolocking->generate_msu($_POST,false);
			} else {
				$save = $this->nolocking->generate_msu($_POST);
			}
			if (isset($save['status']))  $data['error'] = $save['message'];
		}

		$this->setVars(@$data);
	}
	public function print_lkb($bypass = false)
	{
		// check and set data
		if (is_array($bypass))
		{
			$data = $bypass;
		} elseif ($_POST) {
			$data = $_POST;
		} elseif ($_GET) {
			$data = $_GET;
		}

		if ($_POST && !empty($_GET['CHR_LKB_NO']) || $bypass || isset($_GET['CHR_LKB_NO']) && !empty($_GET['CHR_LKB_NO']) ) 
		{
			$print = $this->nolocking->generate_print($data);

			if (isset($print['status'])){
				$data['error'] = $print['message']; 
			} elseif ( empty($print)) {
				$data['error'] = 'RECORD PRINT DATA TIDAK DITEMUKAN.';    
			} else {
				$data['CHR_SLOC_FROM'] = $print[0]->CHR_SLOC_FROM;
				$data['CHR_SLOC_TO'] = $print[0]->CHR_SLOC_TO;
				$data['CHR_VALIDATE_DATE_LEADER'] = date('d F Y',strtotime($print[0]->CHR_VALIDATE_DATE_LEADER));
				$print_ke = $this->nolocking->execute(array('where' => array('CHR_LKB_NO' => $data['CHR_LKB_NO'])),'tt_ng_record_h',true)->CHR_PRINT_STATUS;
				$data['CHR_AREA'] = $this->nolocking->execute(array('where' => array('CHR_LKB_NO' => $data['CHR_LKB_NO'])),'tt_ng_record_h',true)->CHR_AREA;
				$data['print_ke'] = ($print_ke > 0 )? 'Print LKB ke '.$print_ke : '';
				foreach ($print as $key => $value) {
					$parts = $this->nolocking->execute(array('where' => array('CHR_PART_NO' => $value->CHR_PART_NO)),'tm_parts',true);
					$data['table'][$key]['No'] = $key + 1;
					$data['table'][$key]['CHR_BACK_NO'] =  $value->CHR_BACK_NO;
					$data['table'][$key]['CHR_PART_NO'] = @$parts->CHR_PART_NO_DASH;
					$data['table'][$key]['CHR_PART_NAME'] = $parts->CHR_PART_NAME;
					$data['table'][$key]['CHR_REJECT_CODE'] = @$this->nolocking->execute(array('where' => array('CHR_REJECT_CODE'=> $value->CHR_REJECT_CODE)),'tm_reject',true)->CHR_REJECT_TYPE;
					$data['table'][$key]['CHR_NG_CATEGORY_CODE'] = @$this->nolocking->execute(array('where' => array('CHR_NG_CATEGORY_CODE'=> $value->CHR_NG_CATEGORY_CODE)),'tm_ng',true)->CHR_NG_CATEGORY;
					$data['table'][$key]['CHR_DAMAGE_CODE'] = @str_replace(" ", "", $value->CHR_DAMAGE_CODE);
					$damage = $this->nolocking->execute(array('where' => array('CHR_DAMAGE_CODE' => $value->CHR_DAMAGE_CODE)),'tm_damage',true);
					if (isset($_POST['generate']) || $bypass) $data['table'][$key]['CHR_DAMAGE_DESC'] = @str_replace(" ", "",$damage->CHR_DAMAGE_DESC);
					$data['table'][$key]['INT_TOTAL_QTY'] = $value->INT_TOTAL_QTY;
					$data['table'][$key]['CHR_PART_UOB'] = @str_replace(" ", "",$parts->CHR_PART_UOM);

				}
			}
			//print_r($data); return;
			if (isset($_POST['generate']) && isset($data['table'])  || !empty($bypass) && isset($data['table']) ) {
				$this->nolocking->generate_print($data, true); 
				//if (!isset($data['table'])) redirect( $this->agent->referrer() );
				$pdf = $this->load->view('pes/ng_no_locking/ng_nolocking_print',@$data,true);
				$this->nolocking->store_session('print',true);	
				/*				
				echo $pdf;
				echo '<script type="text/javascript">window.onload = function() { window.print(); }</script>';*/
				//print_r($data['check']);
				$this->generate_pdf($pdf);
				return;
			} 
			
		} 
		$data['CHR_LKB_NO'] = isset($_POST['CHR_LKB_NO'])? @$this->input->post('CHR_LKB_NO') : isset($_GET)? @$this->input->get('CHR_LKB_NO') : "" ;
		if ($this->nolocking->total_items('print') > 0 )
		{
			$this->nolocking->clear_session();
			redirect(site_url('/pes/ng_no_locking/print_lkb'));
		}
		$this->setVars(@$data);

	}
	public function history($detail='')
	{
		if ($_GET && empty($detail))
		{
			$post = $this->input->get();
			$find['DATE_FROM'] = (!empty($post['DATE_FROM']))? date('Ymd',strtotime($post['DATE_FROM'])) : ( (!empty($post['DATE_TO']))? date('Ymd',strtotime($post['DATE_TO'])) : "" ) ;
			$find['DATE_TO'] = (!empty($post['DATE_TO']))? date('Ymd',strtotime($post['DATE_TO'])) : ( (!empty($post['DATE_FROM']))? date('Ymd',strtotime($post['DATE_FROM'])) : "" );

			$query_lkb = array('select' => 'DISTINCT TT_NG_RECORD_L.CHR_LKB_NO, TT_NG_RECORD_L.CHR_AREA , TT_NG_RECORD_L.CHR_VALIDATE_DATE_LEADER, TM_AREA.CHR_DESC_AREA, CASE WHEN  TT_NG_RECORD_H.CHR_VALIDATE_MSU IS NULL THEN "PROGRESS" WHEN TT_NG_RECORD_H.CHR_VALIDATE_MSU IS NOT NULL AND TT_NG_RECORD_L.CHR_DEL_FLG IS NOT NULL THEN "DELETED" WHEN TT_NG_RECORD_H.CHR_VALIDATE_MSU IS NOT NULL AND TT_NG_RECORD_L.CHR_REJECT IS NOT NULL THEN "REJECT" WHEN TT_NG_RECORD_H.CHR_VALIDATE_MSU IS NOT NULL AND TT_NG_RECORD_L.CHR_DEL_FLG IS NULL THEN "COMPLETED" END AS STATUS' ,'where' => "TT_NG_RECORD_L.CHR_LKB_NO = '".$post['CHR_LKB_NO']."'",'join' => array('TT_NG_RECORD_H','TT_NG_RECORD_H.INT_NUMBER=TT_NG_RECORD_L.INT_NUMBER','INNER'), 'Join' => array('TM_AREA', 'TT_NG_RECORD_L.CHR_AREA=TM_AREA.CHR_AREA','INNER'));
			$query_date = array('select' => 'DISTINCT TT_NG_RECORD_L.CHR_LKB_NO,TT_NG_RECORD_L.CHR_AREA ,TT_NG_RECORD_L.CHR_VALIDATE_DATE_LEADER, TM_AREA.CHR_DESC_AREA, CASE WHEN TT_NG_RECORD_H.CHR_VALIDATE_MSU IS NULL THEN "PROGRESS" WHEN TT_NG_RECORD_H.CHR_VALIDATE_MSU IS NOT NULL AND TT_NG_RECORD_L.CHR_DEL_FLG IS NOT NULL THEN "DELETED" WHEN TT_NG_RECORD_H.CHR_VALIDATE_MSU IS NOT NULL AND TT_NG_RECORD_L.CHR_REJECT IS NOT NULL THEN "REJECT" WHEN TT_NG_RECORD_H.CHR_VALIDATE_MSU IS NOT NULL AND TT_NG_RECORD_L.CHR_DEL_FLG IS NULL THEN "COMPLETED" END AS STATUS' ,'where' => "CHR_VALIDATE_DATE_LEADER BETWEEN '".$find['DATE_FROM']."' AND '".$find['DATE_TO']."'",'join' => array('TT_NG_RECORD_H','TT_NG_RECORD_H.INT_NUMBER=TT_NG_RECORD_L.INT_NUMBER','INNER'), 'Join' => array('TM_AREA', 'TT_NG_RECORD_L.CHR_AREA=TM_AREA.CHR_AREA','INNER'));
			$query_all = array('select' => 'DISTINCT TT_NG_RECORD_L.CHR_LKB_NO,TT_NG_RECORD_L.CHR_AREA ,TT_NG_RECORD_L.CHR_VALIDATE_DATE_LEADER, TM_AREA.CHR_DESC_AREA, CASE WHEN TT_NG_RECORD_H.CHR_VALIDATE_MSU IS NULL THEN "PROGRESS" WHEN TT_NG_RECORD_H.CHR_VALIDATE_MSU IS NOT NULL AND TT_NG_RECORD_L.CHR_DEL_FLG IS NOT NULL THEN "DELETED" WHEN TT_NG_RECORD_H.CHR_VALIDATE_MSU IS NOT NULL AND TT_NG_RECORD_L.CHR_REJECT IS NOT NULL THEN "REJECT" WHEN TT_NG_RECORD_H.CHR_VALIDATE_MSU IS NOT NULL AND TT_NG_RECORD_L.CHR_DEL_FLG IS NULL THEN "COMPLETED" END AS STATUS' ,'join' => array('TT_NG_RECORD_H','TT_NG_RECORD_H.INT_NUMBER=TT_NG_RECORD_L.INT_NUMBER','INNER'), 'Join' => array('TM_AREA', 'TM_AREA.CHR_AREA=TT_NG_RECORD_L.CHR_AREA','INNER'));

			$history = $this->nolocking->generate_history((!empty($post['CHR_LKB_NO']) && empty($post['DATE_FROM']) && empty($post['DATE_TO']))? $query_lkb : ((empty($post['CHR_LKB_NO']) && empty($post['DATE_FROM']) && empty($post['DATE_TO']))? $query_all : $query_date),true);
			//print_r($query_lkb); die();
			if (!empty($history))
			{
				foreach ($history as $key => $value) {
					$data['table'][$key]['CHR_LKB_NO'] = '<a href="'.site_url("/pes/ng_no_locking/history/$value->CHR_LKB_NO").'">'.$value->CHR_LKB_NO.'</a>';
					$data['table'][$key]['CHR_AREA'] = @$value->CHR_AREA.','.$value->CHR_DESC_AREA;
					$data['table'][$key]['DATE'] = (@$value->CHR_VALIDATE_DATE_LEADER)? date('d-m-Y',strtotime($value->CHR_VALIDATE_DATE_LEADER)) : "";
					$data['table'][$key]['STATUS'] = $value->STATUS;
				}
			}
			//print_r($data); return;
		} elseif (!empty($detail)) {
				$history = $this->nolocking->generate_history($detail);
				if ( $history ) {
					//foreach datas
					foreach ($history as $key => $value) {

						$data['table'][$key]['No'] = $key + 1;
						$data['table'][$key]['CHR_BACK_NO'] =  $value->CHR_BACK_NO;
						$data['table'][$key]['CHR_PART_NO'] = $value->CHR_PART_NO;
						$parts = $this->nolocking->execute(array('where' => array('CHR_PART_NO' => $value->CHR_PART_NO)),'tm_parts',true);
						$data['table'][$key]['CHR_PART_NAME'] = $parts->CHR_PART_NAME;
						//$data['table'][$key]['CHR_PART_UOB'] = $parts->CHR_PART_UOM;
						$data['table'][$key]['CHR_REJECT_CODE'] = @$this->nolocking->execute(array('where' => array('CHR_REJECT_CODE'=> $value->CHR_REJECT_CODE)),'tm_reject',true)->CHR_REJECT_TYPE;
						$data['table'][$key]['CHR_NG_CATEGORY_CODE'] = @$this->nolocking->execute(array('where' => array('CHR_NG_CATEGORY_CODE'=> $value->CHR_NG_CATEGORY_CODE)),'tm_ng',true)->CHR_NG_CATEGORY;
						$data['table'][$key]['CHR_DAMAGE_CODE'] = @$this->nolocking->execute(array('where' => array('CHR_DAMAGE_CODE'=> $value->CHR_DAMAGE_CODE)),'tm_damage',true)->CHR_DAMAGE_DESC; 	
						$data['table'][$key]['INT_TOTAL_QTY'] = $value->INT_TOTAL_QTY;	
						$data['table'][$key]['STATUS'] = $value->STATUS ;	
					}	
			}
			$data['detail'] = $detail;
		} else {
				$data['error'] = 'RECORD DATA TIDAK DITEMUKAN.';
		} 
			
		if (empty($detail)) $this->table->set_heading('LKB Number','Area', 'Date', 'Status');		
		else $this->table->set_heading('No', 'Back Number', 'Part Number', 'Part Name','Reject Type', 'NG Category','Damage Code', 'Quantity', 'Status');
		
		$data['CHR_LKB_NO'] = isset($_POST['CHR_LKB_NO'])? $_POST['CHR_LKB_NO'] : "" ;
		$data['date_from'] = isset($_POST['DATE_FROM'])? $_POST['DATE_FROM'] : "";
		$data['date_to'] = isset($_POST['DATE_TO'])? $_POST['DATE_TO'] : "";

		$this->setVars(@$data);
	}
	private function setVars($data='')
	{
		// set var
		if (is_array($data)) $this->load->vars($data);
		$this->load->view($this->layout);
	}
	public function data($url_query='',$detail="")
	{
		if (!IS_AJAX) show_404();		
		$this->output->enable_profiler(false);

		$get = $this->input->get('term');

		switch ($url_query) {
			case 'area':
				$query = array('select' => "(CHR_AREA+', '+ CHR_DESC_AREA ) as name",'or_like'=>array('CHR_AREA'=>$get,'CHR_DESC_AREA'=>$get),'where'=>'CHR_FLAG_DELETE IS NULL');
				$table = 'tm_area';
				break;
			case 'back_no':
				$query = array('select' => 'CHR_BACK_NO as name, *','distinct' => '','like' => array('CHR_BACK_NO' => $get),'where'=>'CHR_FLAG_DELETE IS NULL');
				$table = 'tm_parts';
				break;
			case 'part_no':
				$query = array('select' => 'CHR_PART_NO as name, *','distinct' => '','like' => array('CHR_PART_NO' => $get),'where'=>'CHR_FLAG_DELETE IS NULL');
				$table = 'tm_parts';
				break;
			case 'reject_code':
				$query = array('select' => "(CHR_REJECT_CODE+', '+ CHR_REJECT_TYPE ) as name",'or_like'=>array('CHR_REJECT_CODE'=>$get,'CHR_REJECT_TYPE'=>$get),'where'=>'CHR_FLAG_DELETE IS NULL');
				$table = 'tm_reject';
				break;
			case 'ng_category':
				$query = array('select' => "(CHR_NG_CATEGORY_CODE+', '+ CHR_NG_CATEGORY ) as name",'or_like'=>array('CHR_NG_CATEGORY_CODE'=>$get,'CHR_NG_CATEGORY'=>$get),'where'=>'CHR_FLAG_DELETE IS NULL');
				$table = 'tm_ng';
				break;
			case 'damage_code':
				$query = array('select' => "(CHR_DAMAGE_CODE+', '+ CHR_DAMAGE_DESC ) as name",'or_like'=>array('CHR_DAMAGE_CODE'=>$get,'CHR_DAMAGE_DESC'=>$get),'where'=>'CHR_FLAG_DELETE IS NULL');
				$table = 'tm_damage';
				break;
			case 'chr_lkb_no':
				$query = array('select' => 'distinct CHR_LKB_NO as name','like'=>array('CHR_LKB_NO'=>$get));
				$table = 'tt_ng_record_l';
				break;
			default:
				break;
		}


		if (isset($query)) $result = $this->nolocking->execute($query,$table);
		if(isset($result) && count($result) > 0) {
			foreach ($result as $key => $row) {
				if ($row->name == null || $row->name == 'lkb' ) continue;
				if (@$detail && $url_query=="part_no") {
					$data[$key]['label'] = $row->CHR_PART_NO;
					$data[$key]['value'] = $row->CHR_BACK_NO;
					$data[$key]['uom'] = $row->CHR_PART_UOM;
				} elseif (@$detail && $url_query=="back_no") {
					$data[$key]['label'] = $row->CHR_BACK_NO;
					$data[$key]['value'] = $row->CHR_PART_NO;
					$data[$key]['uom'] = $row->CHR_PART_UOM;
				} else {
					$data[$key]['label']= $row->name;	
					$data[$key]['value']= $row->name;	
				}
			}
		} elseif (empty($data)) {
			$data = "none";
		}
		echo json_encode($data);
	}
	public function check($type='user',$name='')
	{
		//just post allowed in this method
		if (!$_POST) show_404();
		switch ($type) {
			case 'user':
					if (isset($_POST['ng_area'])) {
					 	$user = $this->session->all_userdata();
						$area = $this->nolocking->execute(array('where' => array('CHR_AREA' => $this->input->post('CHR_AREA'))));
						$this->session->set_flashdata('area',array_shift($area));
						$this->session->set_flashdata('location',$this->input->post('CHR_SLOC_FROM'));
						//check role id department
						if ( in_array($user['DEPT'], array(21,22,23,24) ) )
						{
							$this->session->unset_userdata('production');
					  		redirect('pes/ng_no_locking/production');
						} elseif (in_array($user['DEPT'], array(6,20))) { 
							$this->session->unset_userdata('engineering');
					  		redirect('pes/ng_no_locking/engineering');
						} else {
							redirect( $this->agent->referrer() );
						}
					  // if this nik check is enginneer
					} 
				break;
			case 'validation':
				
				
				redirect( $this->agent->referrer() );	

				break;
			case 'screen':
				if ( $this->nolocking->total_items($name) < 1 ) {
					$this->session->set_flashdata('error','Anda belum memasukan komponen NG.');
					redirect( $this->agent->referrer() );
				}
				if (isset($_POST['RESET']))
				{
					$this->session->unset_userdata($name);
					$store = false;
				} else {
					$post = $this->input->post();
					$store = $this->nolocking->screen_store($post,$name);
				}
				if ( !$store ) {
					redirect( $this->agent->referrer() );	
				} else {
					redirect('pes/ng_no_locking');
				}
				//
				break;
			default:
				break;
		}
	}
	public function add_session($case='')
	{
		if ($case == "engineering" && isset($_POST['CHR_PART_NO'])) {
			$post = $this->input->post();
			unset($_POST['CHR_BACK_NO'], $_POST['CHR_PART_NO']);
		}
		if (array_search("",$_POST))
		{
			$this->session->set_flashdata('error','Seluruh field harus di isi.');
			$this->session->set_flashdata('form',$_POST);
		 	redirect( $this->agent->referrer());
		}

		if (isset($post)) $_POST = $post;
		// check before add
		$part = (!empty($_POST['CHR_BACK_NO']))? $this->nolocking->execute(array('where' => array('CHR_BACK_NO'=> $this->get_id($this->input->post('CHR_BACK_NO')))),'tm_parts') : $this->nolocking->execute(array('where' => array('CHR_PART_NO'=> $this->get_id($this->input->post('CHR_PART_NO')))),'tm_parts');
		if (isset($_POST['CHR_NG_CATEGORY_CODE'])) $category = $this->nolocking->execute(array('where' => array('CHR_NG_CATEGORY_CODE'=> $this->get_id($this->input->post('CHR_NG_CATEGORY_CODE')))),'tm_ng');
		 if (isset($_POST['CHR_DAMAGE_CODE'])) $damage = $this->nolocking->execute(array('where' => array('CHR_DAMAGE_CODE'=> $this->get_id($this->input->post('CHR_DAMAGE_CODE')))),'tm_damage');
		if (isset($_POST['CHR_REJECT_CODE'])) $reject = $this->nolocking->execute(array('where' => array('CHR_REJECT_CODE'=> $this->get_id($this->input->post('CHR_REJECT_CODE')))),'tm_reject');

		switch ($case) {
			case 'production':
				// set data for adding cart
				$data['NO'] = $this->nolocking->total_items('production') + 1;
				$data['CHR_BACK_NO'] = $this->input->post('CHR_BACK_NO');
				$data['CHR_PART_NO'] = $part[0]->CHR_PART_NO;
				$data['CHR_PART_NAME'] = $part[0]->CHR_PART_NAME;
				$data['CHR_REJECT_CODE'] = $this->input->post('CHR_REJECT_CODE');
				$data['CHR_NG_CATEGORY_CODE'] = $this->input->post('CHR_NG_CATEGORY_CODE');
				$data['CHR_DAMAGE_CODE'] = '';
				$data['INT_TOTAL_QTY'] = $this->input->post('INT_TOTAL_QTY');
				$data['CHR_PART_UOM'] = $part[0]->CHR_PART_UOM;
		 	if (empty($part)) $this->session->set_flashdata('error','Back Number Yang Anda Input Salah, Periksa Kembali') ;
		 	if (empty($reject)) $this->session->set_flashdata('error','Reject Type Yang Anda Input Salah, Periksa Kembali') ;
		 	if (empty($category)) $this->session->set_flashdata('error','NG Category Yang Anda Input Salah, Periksa Kembali') ;
		 	if ($part && $reject && $category) $this->nolocking->store_session($case,$data);
				break;
			
			case 'engineering':
				// set data for adding cart
				$data['NO'] = $this->nolocking->total_items('engineering') + 1;
				$data['CHR_BACK_NO'] = $this->input->post('CHR_BACK_NO');
				$data['CHR_PART_NO'] = (isset($_POST['CHR_PART_NO']))? $this->input->post('CHR_PART_NO') : $part[0]->CHR_PART_NO ;
				$data['CHR_PART_NAME'] = $part[0]->CHR_PART_NAME;
				$data['CHR_REJECT_CODE'] = '';
				$data['CHR_NG_CATEGORY_CODE'] = '';
				$data['CHR_DAMAGE_CODE'] = $this->input->post('CHR_DAMAGE_CODE');
				$data['INT_TOTAL_QTY'] = $this->input->post('INT_TOTAL_QTY');
				$data['CHR_UOM'] = (isset($_POST['CHR_UOM']))? $this->input->post('CHR_UOM') : $part[0]->CHR_UOM;

		  if (empty($part)) $this->session->set_flashdata('error','Back Number Yang Anda Input Salah, Periksa Kembali') ;
		  if (empty($damage)) $this->session->set_flashdata('error','Damage Code Yang Anda Input Salah, Periksa Kembali') ;
		  if ($part && $damage) $this->nolocking->store_session($case,$data);
				break;
			
			default:
				break;
		}
		
		redirect( $this->agent->referrer() );
	    //print_r($data); die();
	}

	public function generate_pdf($pdf)
	{
		try {
			ob_clean();
		    $this->kb_pdf->WriteHTML($pdf);
		    return $this->kb_pdf->Output('print.pdf');
				    
		} catch (Exception $e) {var_dump($e);}
	}
	private function default_vars()
	{
		header("Cache-Control: no-store, must-revalidate, max-age=0");
		header("Pragma: no-cache");
		header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
		//echo time();
		
		$this->load->model('pes/prod_entry_m');
        $this->load->model('pes/approval_m');
        $this->load->model('pes/nolocking_m', 'nolocking');
        $this->load->model('organization/dept_m');
        $this->load->model('basis/role_module_m');
        $this->load->model('portal/news_m');
        // load library for create table
		$this->load->library(array('table','cart','user_agent'));
		//set default vars
		$data['content'] = 'pes/ng_no_locking/default';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module(1);
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(0);
        $data['news'] = $this->news_m->get_news();
        // content view 
        $data['__content'] = ($this->uri->segment(3))? $this->uri->segment(3) : 'area' ;
		$data['title'] = 'NG No Locking - '.ucfirst($data['__content']);
        $data['breadcrumb'] =  ($this->uri->segment(3))? array('Home' => site_url(''),'Component NG' => site_url('pes/ng_no_locking'), ucfirst($data['__content']) => site_url('pes/ng_no_locking/'.$this->uri->segment(3))  ) : array('Home' => site_url(''),'No Locking' => site_url('pes/ng_no_locking'));

		$this->table->set_template(array('table_open' => '<table class="table table-hover">'));
		$this->table->set_heading('No', 'Back Number', 'Part Number', 'Part Name','Reject Type', 'NG Category','Damage Code', 'Quantity','UOM');

		// eneble keep session_commit()
		$this->session->keep_flashdata('area');
		$this->session->keep_flashdata('chr_lkb_no');
	    $this->session->keep_flashdata('location');
	    $data['area'] = $this->session->flashdata('area');
        // load vars to view
        $this->load->vars($data);
	}
	public function get_id($data='')
	{
		$explode = explode(',', $data);
		return ($explode[0])? $explode[0] : '';
	}
	/*public function reprint_lkb()
	{
		$data['CHR_LKB_NO'] = @$this->input->post('CHR_LKB_NO');
		$date = @explode(" ", @$this->input->post('CHR_DATE'));
		$data['CHR_DATE'] = array_shift($date);
		if ($_POST)
		{
			$print = $this->nolocking->generate_reprint();
			if (isset($print['status'])){
				$data['error'] = $print['message']; 
			} elseif ( $print && empty($print['CHR_PRINT_STATUS'])) {
				unset($print['CHR_PRINT_STATUS']);
				//foreach datas
				foreach ($print as $key => $value) {
					$data['table'][$key]['No'] = $key + 1;
					$data['table'][$key]['CHR_BACK_NO'] =  $value->CHR_BACK_NO;
					$data['table'][$key]['CHR_PART_NO'] = $value->CHR_PART_NO;
					$parts = $this->nolocking->execute(array('where' => array('CHR_PART_NO' => $value->CHR_PART_NO)),'tm_parts',true);
					$data['table'][$key]['CHR_PART_NAME'] = $parts->CHR_PART_NAME;
					$data['table'][$key]['CHR_PART_UOB'] = $parts->CHR_PART_UOM;
					$data['table'][$key]['CHR_REJECT_CODE'] = $value->CHR_REJECT_CODE;
					$data['table'][$key]['CHR_NG_CATEGORY_CODE'] = $value->CHR_NG_CATEGORY_CODE;
					$data['table'][$key]['CHR_DAMAGE_CODE'] = $value->CHR_DAMAGE_CODE;
					$data['table'][$key]['INT_TOTAL_QTY'] = $value->INT_TOTAL_QTY;
				}
			} else 
			{
				$data['error'] = 'TIDAK ADA DATA PADA AREA';
			}
			if (isset($_POST['generate'])) {
				if (!isset($data['table'])) redirect( $this->agent->referrer() );
				$pdf = $this->load->view('pes/ng_no_locking/ng_nolocking_print',@$data,true);
				//print_r($data['check']);
				$this->nolocking->generate_print('update');
				$this->generate_pdf($pdf);
				return;
			} 
			
		}
	//print_r($data);die();
		$this->setVars(@$data);
	}*/
}