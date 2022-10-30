<?php
	/**
	* 
	*/
	class mold_c extends CI_Controller
	{
		
		private $layout = '/template/head';
	    private $back_to_manage = 'mte/mold_c/index/';

	    public function __construct() {
	        parent::__construct();
	        $this->load->model('mte/mold_m');
	        // $this->load->model('asset/mold_m');
	    }

	    function index($msg = NULL) {
	        $this->role_module_m->authorization('3');

	        if ($msg == 1) {
	            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Creating success </strong> The data is successfully created </div >";
	        } elseif ($msg == 2) {
	            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Updating success </strong> The data is successfully updated </div >";
	        } elseif ($msg == 3) {
	            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Deleted success </strong> The data is successfully deleted </div >";
	        } elseif ($msg == 4) {
	            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Choosing failed </strong> You must select at least one data</div >";
	        } elseif ($msg == 12) {
	            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Executing error !</strong> Something error with parameter </div >";
	        }
	        $data['msg'] = $msg;
	        $data['data'] = $this->mold_m->get_mold();
	        $data['content'] = 'mte/mold/manage_mold_v';
	        $data['title'] = 'Manage  Mold';
	        $data['news'] = $this->news_m->get_news();
	        $data['app'] = $this->role_module_m->get_app();
	        $data['module'] = $this->role_module_m->get_module();
	        $data['function'] = $this->role_module_m->get_function();
	        $data['sidebar'] = $this->role_module_m->side_bar(47);

	        $this->load->view($this->layout, $data);
	    }

	    function detail_mold($id, $msg = NULL) {
	    	$this->role_module_m->authorization('3');

	        if ($msg == 1) {
	            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Creating success </strong> The data is successfully created </div >";
	        } elseif ($msg == 2) {
	            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Updating success </strong> The data is successfully updated </div >";
	        } elseif ($msg == 3) {
	            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Deleted success </strong> The data is successfully deleted </div >";
	        } elseif ($msg == 4) {
	            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Choosing failed </strong> You must select at least one data</div >";
	        } elseif ($msg == 12) {
	            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Executing error !</strong> Something error with parameter </div >";
	        }
	        $data['msg'] = $msg;
	        $data['kode'] = $id;
	        $data['ttl'] = $this->mold_m->check_name($id);
	    	$data['data'] = $this->mold_m->get_mold_detail($id);
	        $data['content'] = 'mte/mold/manage_mold_detail_v';
	        $data['title'] = 'Manage  Mold';
	        $data['part'] = $this->mold_m->get_part_update($id);
	        $data['news'] = $this->news_m->get_news();
	        $data['app'] = $this->role_module_m->get_app();
	        $data['module'] = $this->role_module_m->get_module();
	        $data['function'] = $this->role_module_m->get_function();
	        $data['sidebar'] = $this->role_module_m->side_bar(47);

	        $this->load->view($this->layout, $data);		
	    }

	    //prepare to create
	    function create_mold($msg = NULL) {
	    	if ($msg == 1) {
	            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Creating failed </strong> Mold code already exist </div >";
	        }
			$data['msg'] = $msg;	        
	        $this->role_module_m->authorization('3');
	        $data['content'] = 'mte/mold/create_mold_v';
	        $data['title'] = 'Create Mold';
	        $data['isi'] = $this->mold_m->get_part();
	        $data['news'] = $this->news_m->get_news();
	        $data['app'] = $this->role_module_m->get_app();
	        $data['module'] = $this->role_module_m->get_module();
	        $data['function'] = $this->role_module_m->get_function();
	        $data['sidebar'] = $this->role_module_m->side_bar(47);

	        $this->load->view($this->layout, $data);
	    }

	    //saving data
	    function save_mold() {
	    	$code="";
	    	$code = $this->mold_m->check_code($this->input->post('CHR_CODE_MOLD'));
	    	if($code == ""){
		    	date_default_timezone_set('Asia/Jakarta');
		    	$today1 = date("Y-m-d");
				$today2 =date_create($today1);
				$tgl = date_format($today2,"Ymd");

				$time1 = date("H:i:s");
				$time2 = date_create($time1);
				$time = date_format($time2,"His");

				$data = array(
					'CHR_CODE_MOLD' => $this->input->post('CHR_CODE_MOLD'),
	            	'CHR_MOLD_NAME' => $this->input->post('CHR_MOLD_NAME'),
	            	'CHR_MODEL' => $this->input->post('CHR_MODEL'),
	            	'CHR_CREATED_DATE' => $tgl,
	            	'CHR_CREATED_TIME' => $time,
	            	'CHR_MODIFIED_DATE' => NULL,
	            	'CHR_MODIFIED_TIME' => NULL,
	            	'INT_FLAG_DELETE' => 1
	            );
	            $this->mold_m->save_mold($data);

	            foreach ($_POST['partnumb'] as $part) {
	            	$partno = explode(":", $part);
	            	$data1 = array(
	            		'CHR_CODE_MOLD' => $this->input->post('CHR_CODE_MOLD'),
	            		'CHR_PART_NO' => $partno[0],
	            		'CHR_WORK_CENTER' => $partno[3],
	            		'CHR_BACK_NO' => $partno[1],
	            		'CHR_PART_NAME' => $partno[2],
	            		'CHR_CREATED_DATE' => $tgl,
		            	'CHR_CREATED_TIME' => $time,
		            	'CHR_MODIFIED_DATE' => NULL,
		            	'CHR_MODIFIED_TIME' => NULL,
	            		'INT_FLAG_DELETE' => 1
	            	);
		    		$this->mold_m->save_mold_detail($data1);
		    	}

	            redirect($this->back_to_manage . $msg = 1);
	        } else {
        		redirect('mte/mold_c/create_mold/' . $msg = 1);
	        }
	    }

	    function save_part() {
	    	$partno = "";
	    	$partno = $this->mold_m->check_part($this->input->post('CHR_CODE_MOLD'), $this->input->post('CHR_PART_NO'), $this->input->post('CHR_WORK_CENTER'));
	    	if($partno == "") {
	    		date_default_timezone_set('Asia/Jakarta');
		    	$today1 = date("Y-m-d");
				$today2 =date_create($today1);
				$tgl = date_format($today2,"Ymd");

				$time1 = date("H:i:s");
				$time2 = date_create($time1);
				$time = date_format($time2,"His");
				$data1 = array(
	        		'CHR_CODE_MOLD' => $this->input->post('CHR_CODE_MOLD'),
	        		'CHR_PART_NO' => $this->input->post('CHR_PART_NO'),
	        		'CHR_WORK_CENTER' => $this->input->post('CHR_WORK_CENTER'),
	        		'CHR_BACK_NO' => $this->input->post('CHR_BACK_NO'),
	        		'CHR_PART_NAME' => $this->input->post('CHR_PART_NAME'),
	        		'CHR_CREATED_DATE' => $tgl,
	            	'CHR_CREATED_TIME' => $time,
	            	'CHR_MODIFIED_DATE' => NULL,
	            	'CHR_MODIFIED_TIME' => NULL,
	        		'INT_FLAG_DELETE' => 1
	        	);
	    		$this->mold_m->save_mold_detail($data1);	
	    	} else {
	    		$part = $this->input->post('CHR_PART_NO');
	    		$id = $this->input->post('CHR_CODE_MOLD');
	    		$wc = $this->input->post('CHR_WORK_CENTER');
	    		$data1 = array(
	        		'INT_FLAG_DELETE' => 1
	        	);
	        	$this->mold_m->update_part($data1, $id, $part, $wc);
	    	}
    			
	    	
	    }

	    //prepare to editing
	    function edit_mold($id) {
	        $this->role_module_m->authorization('3');
	        $data['data'] = $this->mold_m->get_data_mold($id)->row();
	        $data['content'] = 'mte/mold/edit_mold_v';
	        $data['title'] = 'Edit  Mold';
	        $data['news'] = $this->news_m->get_news();
	        $data['app'] = $this->role_module_m->get_app();
	        $data['module'] = $this->role_module_m->get_module();
	        $data['function'] = $this->role_module_m->get_function();
	        $data['sidebar'] = $this->role_module_m->side_bar(47);

	        $this->load->view($this->layout, $data);
	    }

	    //updating data
	    function update_mold() {

	    	$id = $this->input->post('CHR_CODE_MOLD');

	    	date_default_timezone_set('Asia/Jakarta');
	    	$today1 = date("Y-m-d");
			$today2 =date_create($today1);
			$tgl = date_format($today2,"Ymd");

			$time1 = date("H:i:s");
			$time2 = date_create($time1);
			$time = date_format($time2,"His");
	  
			$data = array(
            	'CHR_MOLD_NAME' => $this->input->post('CHR_MOLD_NAME'),
            	'CHR_MODEL' => $this->input->post('CHR_MODEL'),
            	'CHR_MODIFIED_DATE' => $tgl,
            	'CHR_MODIFIED_TIME' => $time
            );

            $this->mold_m->update($data, $id);
            $msg = 2;

            redirect($this->back_to_manage . $msg);
		
	    }

	    function activate($id) {
	        $this->role_module_m->authorization('3');
	        $this->mold_m->delete($id, 1);
	        redirect($this->back_to_manage . $msg = 2);
	    }

	    function deactivate($id) {
	        $this->role_module_m->authorization('3');
	        $this->mold_m->delete($id, 0);
	        redirect($this->back_to_manage . $msg = 2);
	    }

	    function delete_mold_detail($id, $partno, $wc) {
	    	$this->role_module_m->authorization('3');
	        $this->mold_m->delete_mold_detail($id, $partno, $wc);
	        redirect('mte/mold_c/detail_mold/'.$id. '/' . $msg = 3);	
	    }

	    function get_part_list_param($param1 = NULL,$param2 = NULL,$param3 = NULL,$param4 = NULL) {
	        
	        if($param1 == NULL){
	        	$list_part = $this->mold_m->get_part();
	        } else {
	        	$list_part = $this->mold_m->get_part_param($param1,$param2,$param3,$param4);
	        }
	        echo $param1 . $param2 . $param3 . $param4;
	        
	        $table_part = '';
	        $table_part .= '<table style="font-size:12px;" id="example" class="table table-condensed table-hover display" cellspacing="0" width="100%">';
	        $table_part .=  '<thead>';
	        $table_part .=    '<tr style="font-weight:bold; background-color: #002a80; color: white;">';
	        $table_part .=        '<td align="left">No</td>';
	        $table_part .=        '<td align="left">Part No</td>';
	        $table_part .=        '<td align="left">Back No</td>';
	        $table_part .=        '<td align="left">Part Name</td>';
	        $table_part .=        '<td align="left">Work Center</td>';
	        $table_part .=        '<td align="left">Action</td>';
	        $table_part .=    '</tr>'; 
	        $table_part .=  '</thead>';
	        
	        if(count($list_part) == 0){
	           $table_part .= '<tbody>';
	           $table_part .=  '<tr style="background-color:whitesmoke;">';
	           $table_part .=    '<td colspan="5"><strong>No Data Available</strong></td>';
	           $table_part .=  '</tr>';
	           $table_part .= '</tbody>';
	        } else {
	           $i = 1;
	           foreach ($list_part as $data){
	                $table_part .= '<tbody>';
	                $table_part .= '<tr>';
	                $table_part .=    '<td>' . $i . '</td>';
	                $table_part .=    '<td>' . $data->PartNo . '</td>';
	                $table_part .=    '<td>' . $data->BackNo . '</td>';
	                $table_part .=    '<td>' . $data->PartName . '</td>';
	                $table_part .=    '<td>' . $data->WorkCenter . '</td>';
	                $table_part .=    '<td align="center"><input type="checkbox" name="check_list[]" value="'. $data->PartNo .':'. $data->BackNo .':'. $data->PartName .':'. $data->WorkCenter .'"></td>';
	                $table_part .= '</tr>';
	                $table_part .= '</tbody>';
	                $i++;
	            } 
	        }        
	        
	        $table_part .= '</table>';
	        
	        echo $table_part;
	    }

	    function get_part_list() {
	        
	        $list_part = $this->mold_m->get_part();
	        
	        $table_part = '';
	        $table_part .= '<table style="font-size:12px;" id="dataTables1" class="table table-condensed table-hover display" cellspacing="0" width="100%">';
	        $table_part .=  '<thead>';
	        $table_part .=    '<tr style="font-weight:bold; background-color: #002a80; color: white;">';
	        $table_part .=        '<td align="center">No</td>';
	        $table_part .=        '<td align="center">Part No</td>';
	        $table_part .=        '<td align="center">Back No</td>';
	        $table_part .=        '<td align="center">Part Name</td>';
	        $table_part .=        '<td align="center">Work Center</td>';
	        $table_part .=        '<td align="center">Action</td>';
	        $table_part .=    '</tr>'; 
	        $table_part .=  '</thead>';
	        
	        if(count($list_part) == 0){
	           $table_part .= '<tbody>';
	           $table_part .=  '<tr style="background-color:whitesmoke;">';
	           $table_part .=    '<td colspan="5"><strong>No Data Available</strong></td>';
	           $table_part .=  '</tr>';
	           $table_part .= '</tbody>';
	        } else {
	           	$i = 1;
       			$a = "";
       			$b = "";
       			$c = "";
       			$d = "";
       			$partnumber = "";
	            foreach ($list_part as $data){
	           		$partnum = trim($data->PartNo," ");
	           		$n = strlen($partnum);
	           		if($n == 11){
	           			$a = substr($partnum, 0, 6)."-";
           				$b = substr($partnum, 6, 5);
           				$partnumber = $a.$b;
	           		} elseif ($n == 13) {
	           			$a = substr($partnum, 0, 6)."-";
	           			$b = substr($partnum, 6, 5). "-";
	           			$c = substr($partnum, 11, 2);
	           			$partnumber = $a.$b.$c;
	           		} elseif($n > 13) {
	           			$a = substr($partnum, 0, 6)."-";
	           			$b = substr($partnum, 6, 5). "-";
	           			$c = substr($partnum, 11, 2). "-";
	           			$d = substr($partnum, 13, 2);
	           			$partnumber = $a.$b.$c.$d;
	           		}

	                $table_part .= '<tbody>';
	                $table_part .= '<tr>';
	                $table_part .=    '<td>' . $i . '</td>';
	                $table_part .=    '<td>' . $partnumber . '</td>';
	                $table_part .=    '<td>' . $data->BackNo . '</td>';
	                $table_part .=    '<td>' . $data->PartName . '</td>';
	                $table_part .=    '<td>' . $data->WorkCenter . '</td>';
	                $table_part .=    '<td align="center"><input type="checkbox" name="check_list[]" value="'. $data->PartNo .':'. $data->BackNo .':'. $data->PartName .':'. $data->WorkCenter .'"></td>';
	                $table_part .= '</tr>';
	                $table_part .= '</tbody>';
	                $i++;
	            } 
	        }        
	        
	        $table_part .= '</table>';
	        
	        echo $table_part;
	    }

	}
?>