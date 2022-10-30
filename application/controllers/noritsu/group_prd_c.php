<?php
	/**
	* 
	*/
	class group_prd_c extends CI_Controller
	{
		
		private $layout = '/template/head';
	    private $back_to_manage = 'noritsu/group_prd_c/index/';

	    public function __construct() {
	        parent::__construct();
	        $this->load->model('noritsu/group_prd_m');
	    }

	    function index($msg = NULL) {
	        $this->role_module_m->authorization('3');

	        if ($msg == 1) {
	            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Creating success </strong> The data is successfully created </div >";
	        } elseif ($msg == 2) {
	            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Updating success </strong> The data is successfully updated </div >";
	        } elseif ($msg == 3) {
	            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Deleted success </strong> The data is successfully deleted </div >";
	        } elseif ($msg == 4) {
	            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Choosing failed </strong> You must select at least one data</div >";
	        } elseif ($msg == 12) {
	            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Executing error !</strong> Something error with parameter </div >";
	        }
	        $data['msg'] = $msg;
	        $data['department'] = NULL;
	        $data['workcenter'] = NULL;
	        $data['groupno'] = NULL;
	        $data['filter'] = 0;
	        $data['data'] = $this->group_prd_m->get_group_prd();
	        $data['dept'] = $this->group_prd_m->get_dept();
	        $data['wc'] = $this->group_prd_m->get_work_center();
	        $data['content'] = 'noritsu/group_prd/manage_group_prd_v';
	        $data['title'] = 'Manage Group Production';
	        $data['news'] = $this->news_m->get_news();
	        $data['app'] = $this->role_module_m->get_app();
	        $data['module'] = $this->role_module_m->get_module();
	        $data['function'] = $this->role_module_m->get_function();
	        $data['sidebar'] = $this->role_module_m->side_bar(184);

	        $this->load->view($this->layout, $data);
	    }

	    function filter_group_prd($dep = NULL, $work = NULL, $nomor = NULL, $msg = NULL) {
	        $this->role_module_m->authorization('3');

	        if ($msg == 1) {
	            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Creating success </strong> The data is successfully created </div >";
	        } elseif ($msg == 2) {
	            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Updating success </strong> The data is successfully updated </div >";
	        } elseif ($msg == 3) {
	            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Deleted success </strong> The data is successfully deleted </div >";
	        } elseif ($msg == 4) {
	            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Choosing failed </strong> You must select at least one data</div >";
	        } elseif ($msg == 12) {
	            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Executing error !</strong> Something error with parameter </div >";
	        }
	        

	        if($dep != NULL && $work != NULL && $nomor != NULL) {
        		$data['data'] = $this->group_prd_m->filter_group_prd($dep,$work,$nomor);

        		$data['msg'] = $msg;
		        $data['filter'] = 1;
		        $data['department'] = $dep;
		        $data['workcenter'] = $work;
		        $data['groupno'] = $nomor;
		        
		        $data['dept'] = $this->group_prd_m->get_dept();
		        $data['wc'] = $this->group_prd_m->get_work_center();
		        $data['mp'] = $this->group_prd_m->get_mp();
		        $data['content'] = 'noritsu/group_prd/manage_group_prd_v';
		        $data['title'] = 'Manage Group Production';
		        $data['news'] = $this->news_m->get_news();
		        $data['app'] = $this->role_module_m->get_app();
		        $data['module'] = $this->role_module_m->get_module();
		        $data['function'] = $this->role_module_m->get_function();
		        $data['sidebar'] = $this->role_module_m->side_bar(184);

		        $this->load->view($this->layout, $data);
        	} else {
        		$dept = $this->input->post('CHR_DEPT_FIL');
		        $workc = $this->input->post('CHR_WORK_CENTER_FIL');
		        $no = $this->input->post('CHR_GROUP_NO_FIL');
		        
		        if ($dept == "0" || $workc == "0" || $no == "0") {
		        	$this->index();
		        } else {
		        	if($dep != NULL && $work != NULL && $nomor != NULL) {
		        		$data['data'] = $this->group_prd_m->filter_group_prd($dep,$work,$nomor);
		        	} else {
		        		$data['data'] = $this->group_prd_m->filter_group_prd($dept,$workc,$no);
		        	}
			        $data['msg'] = $msg;
			        $data['filter'] = 1;
			        $data['department'] = $dept;
			        $data['workcenter'] = $workc;
			        $data['groupno'] = $no;
			        
			        $data['dept'] = $this->group_prd_m->get_dept();
			        $data['wc'] = $this->group_prd_m->get_work_center();
			        $data['mp'] = $this->group_prd_m->get_mp();
			        $data['content'] = 'noritsu/group_prd/manage_group_prd_v';
			        $data['title'] = 'Manage Group Production';
			        $data['news'] = $this->news_m->get_news();
			        $data['app'] = $this->role_module_m->get_app();
			        $data['module'] = $this->role_module_m->get_module();
			        $data['function'] = $this->role_module_m->get_function();
			        $data['sidebar'] = $this->role_module_m->side_bar(184);

			        $this->load->view($this->layout, $data);
		        }
        	}
	    }

	    //prepare to create
	    function create_group_prd() {
	        $this->role_module_m->authorization('3');
	        $data['content'] = 'noritsu/group_prd/create_group_prd_v';
	        $data['title'] = 'Create Group Production';
	        $data['dept'] = $this->group_prd_m->get_dept();
	        $data['wc'] = $this->group_prd_m->get_work_center();
	        $data['mp'] = $this->group_prd_m->get_mp();
	        $data['news'] = $this->news_m->get_news();
	        $data['app'] = $this->role_module_m->get_app();
	        $data['module'] = $this->role_module_m->get_module();
	        $data['function'] = $this->role_module_m->get_function();
	        $data['sidebar'] = $this->role_module_m->side_bar(184);

	        $this->load->view($this->layout, $data);
	    }

	    //saving data
	    function save_group_prd() {
	    	date_default_timezone_set('Asia/Jakarta');
	    	$today1 = date("Y-m-d");
			$today2 =date_create($today1);
			$tgl = date_format($today2,"Ymd");

			$time1 = date("H:i:s");
			$time2 = date_create($time1);
			$time = date_format($time2,"His");

			foreach ($_POST['npknama'] as $isi) {
				$row = explode(':', $isi);
				$npk = $row[0];
				$nama = $row[1];
				$data = array(
	            	'CHR_WORK_CENTER' => $this->input->post('CHR_WORK_CENTER'),
	            	'CHR_GROUP_NO' => $this->input->post('CHR_GROUP_NO'),
	            	'CHR_NPK' => $npk,
	            	'INT_ID_DEPT' => $this->input->post('CHR_DEPT'),
	            	'CHR_NAME' => $nama,
	            	'CHR_CREATED_BY' => $this->session->userdata('USERNAME'),
	            	'CHR_CREATED_DATE' => $tgl,
	            	'CHR_CREATED_TIME' => $time
	            );
	            $this->group_prd_m->save_group_prd($data);
			}
            redirect($this->back_to_manage . $msg = 1);         
	    }

	    function save_mp() {
	    	date_default_timezone_set('Asia/Jakarta');
	    	$today1 = date("Y-m-d");
			$today2 =date_create($today1);
			$tgl = date_format($today2,"Ymd");

			$time1 = date("H:i:s");
			$time2 = date_create($time1);
			$time = date_format($time2,"His");

			$dep = $this->input->post('INT_ID_DEPT');
			$no = $this->input->post('CHR_GROUP_NO');
			$work = $this->input->post('CHR_WORK_CENTER');

			$npk['isi'] = $this->group_prd_m->get_npk($this->input->post('CHR_NPK'));
			foreach ($isi as $row) {
				$cek = $row->CHR_NPK;
			}
			echo $cek;
			if(trim($cek) == trim($this->input->post('CHR_NPK'))) {
				$data = array(
					'CHR_WORK_CENTER' => $this->input->post('CHR_WORK_CENTER'),
	            	'CHR_GROUP_NO' => $this->input->post('CHR_GROUP_NO'),
	            	'CHR_NPK' => $this->input->post('CHR_NPK'),
	            	'INT_ID_DEPT' => $this->input->post('INT_ID_DEPT'),
	            	'CHR_NAME' => $this->input->post('CHR_NAMA'),
					'CHR_FLAG_DEL' => '0' 
				);
				$this->group_prd_m->update_mp($data, $npk);
			} else {
				$data = array(
	            	'CHR_WORK_CENTER' => $this->input->post('CHR_WORK_CENTER'),
	            	'CHR_GROUP_NO' => $this->input->post('CHR_GROUP_NO'),
	            	'CHR_NPK' => $this->input->post('CHR_NPK'),
	            	'INT_ID_DEPT' => $this->input->post('INT_ID_DEPT'),
	            	'CHR_NAME' => $this->input->post('CHR_NAMA'),
	            	'CHR_CREATED_BY' => $this->session->userdata('USERNAME'),
	            	'CHR_CREATED_DATE' => $tgl,
	            	'CHR_CREATED_TIME' => $time
	            );
	            $this->group_prd_m->save_group_prd($data);
			}

			// $data = array(
   //          	'CHR_WORK_CENTER' => $this->input->post('CHR_WORK_CENTER'),
   //          	'CHR_GROUP_NO' => $this->input->post('CHR_GROUP_NO'),
   //          	'CHR_NPK' => $this->input->post('CHR_NPK'),
   //          	'INT_ID_DEPT' => $this->input->post('INT_ID_DEPT'),
   //          	'CHR_NAME' => $this->input->post('CHR_NAMA'),
   //          	'CHR_CREATED_BY' => $this->session->userdata('USERNAME'),
   //          	'CHR_CREATED_DATE' => $tgl,
   //          	'CHR_CREATED_TIME' => $time
   //          );
   //          $this->group_prd_m->save_group_prd($data);
	    }

	    //prepare to editing
	    function edit_group_prd($id) {
	        $this->role_module_m->authorization('3');
	        $data['data'] = $this->group_prd_m->get_data_group_prd($id)->row();
	        $data['content'] = 'noritsu/group_prd/edit_group_prd_v';
	        $data['title'] = 'Edit Group Production';
	        $data['news'] = $this->news_m->get_news();
	        $data['app'] = $this->role_module_m->get_app();
	        $data['module'] = $this->role_module_m->get_module();
	        $data['function'] = $this->role_module_m->get_function();
	        $data['sidebar'] = $this->role_module_m->side_bar(184);

	        $this->load->view($this->layout, $data);
	    }

	    //updating data
	    function update_group_prd() {
	        $id = $this->input->post('INT_ID_GROUP');
	        $msg = 2;

	        date_default_timezone_set('Asia/Jakarta');
	    	$today1 = date("Y-m-d");
			$today2 =date_create($today1);
			$tgl = date_format($today2,"Ymd");

			$time1 = date("H:i:s");
			$time2 = date_create($time1);
			$time = date_format($time2,"His");

			$group = $this->group_prd_m->get_data_group($id);
	        $dep = "";
	        $wc = "";
	        $no = "";

	        foreach ($group as $key) {
	        	$dep = $key->INT_ID_DEPT;
	        	$wc = trim($key->CHR_WORK_CENTER);
	        	$no = $key->CHR_GROUP_NO;
	        }
			
			$data = array(
            	'CHR_WORK_CENTER' => $this->input->post('CHR_WORK_CENTER'),
            	'CHR_GROUP_NO' => $this->input->post('CHR_GROUP_NO'),
            	'INT_ID_DEPT' => $this->input->post('CHR_DEPT'),
            	'CHR_MODIFIED_BY' => $this->session->userdata('USERNAME'),
            	'CHR_MODIFIED_DATE' => $tgl,
            	'CHR_MODIFIED_TIME' => $time
            );

            $this->group_prd_m->update_group_prd($data, $id);

            redirect('noritsu/group_prd_c/filter_group_prd/'. $dep ."/". $wc . "/" . $no . "/" . $msg = 2);					
	    }

	    function delete_group_prd($id) {
	        $this->role_module_m->authorization('3');
	        //Ambil data group yang sudah di filter
	        $group = $this->group_prd_m->get_data_group($id);
	        $dep = "";
	        $wc = "";
	        $no = "";

	        foreach ($group as $key) {
	        	$dep = $key->INT_ID_DEPT;
	        	$wc = trim($key->CHR_WORK_CENTER);
	        	$no = $key->CHR_GROUP_NO;
	        }
	        //Masukin data ke array
	        $data = array(
            	'CHR_FLAG_DEL' => '1',
            	'CHR_MODIFIED_BY' => $this->session->userdata('USERNAME'),
            	'CHR_MODIFIED_DATE' => $tgl,
            	'CHR_MODIFIED_TIME' => $time
            );
	        $this->group_prd_m->update_group_prd($data, $id);
	        //Redirect ke yg sudah difilter
	        redirect('noritsu/group_prd_c/filter_group_prd/'. $dep ."/". $wc . "/" . $no . "/" . $msg = 3);
	    }
	}
?>