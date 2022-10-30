<?php
	/**
	* 
	*/
	class preventive_schedule_c extends CI_Controller
	{
		
		private $layout = '/template/head';
		private $back_to_manage = 'mte/preventive_schedule_c/index/';
		private $back_to_upload_wo = 'mte/preventive_schedule_c/go_to_upload_wo/';

	    public function __construct() {
	        parent::__construct();
	        $this->load->model('mte/preventive_schedule_m');
	    }

	    function index($msg = NULL, $group_line = NULL) {
	        $this->role_module_m->authorization('3');

	        if ($msg == 1) {
	            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Creating success </strong> The data is successfully created </div >";
	        } elseif ($msg == 2) {
	            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Updating success </strong> The data is successfully updated </div >";
	        } elseif ($msg == 3) {
	            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Deleted success </strong> The data is successfully deleted </div >";
	        } elseif ($msg == 4) {
	            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;/button><strong>Choosing failed </strong> You must select at least one data</div >";
	        } elseif ($msg == 12) {
	            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Executing error !</strong> Your part code is exist </div >";
			} elseif ($msg == 13) {
	            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Preventive telah diupdate !</strong> selesai melakukan preventive </div >";
	        } else {
				$msg = "";
			}
			
			if($group_line == '' || $group_line == NULL){
				$group_line = 1;
			}

			if($group_line == 1){
				$group_code = "A";
				$group_type = "MOLD";
			} else if($group_line == 2){
				$group_code = "B";
				$group_type = "DIES STP";
			} else if($group_line == 3){
				$group_code = "C";
				$group_type = "DIES DF";
			} else if($group_line == 4){
				$group_code = "D";
				$group_type = "MACHINE";
			} else if($group_line == 5){
				$group_code = "E";
				$group_type = "JIG (STROKE)";
			} else if($group_line == 6){
				$group_code = "F";
				$group_type = "ELECTRODE";
			} else if($group_line == 7){
				$group_code = "G";
				$group_type = "JIG (SCHEDULE)";
			} else if($group_line == 8){
				$group_code = "H";
				$group_type = "POKAYOKE";
			}

			$data['all_group_line'] = $this->preventive_schedule_m->get_all_product_group_custom();
			$data['group_line'] = $group_line;
			$data['group_type'] = $group_type;

	        $data['msg'] = $msg;
			$data['data'] = $this->preventive_schedule_m->get_parts_mte($group_code);
			// $data['data'] = $this->preventive_schedule_m->get_parts_mte_new($group_line);
			$data['content'] = 'mte/manage_part_preventive_new_v';
			// $data['content'] = 'mte/manage_part_preventive_v';
			$data['subcontent'] = NULL;
	        $data['title'] = 'Manage Part Preventive';
	        $data['news'] = $this->news_m->get_news();
	        $data['app'] = $this->role_module_m->get_app();
	        $data['module'] = $this->role_module_m->get_module();
	        $data['function'] = $this->role_module_m->get_function();
	        $data['sidebar'] = $this->role_module_m->side_bar(47);

	        $this->load->view($this->layout, $data);
		}

		function show_create($group_line = NULL) {
			$data['group_line'] = $group_line;			
			echo $this->load->view('mte/add_new_part_v', $data);
		}

		function show_edit($id = NULL) {
			$id = $this->input->post('id');						
			$get_part = $this->preventive_schedule_m->find_by_id($id);
			$group_code = $get_part->CHR_TYPE;

			if($group_code == "A"){
				$group_line = 1;
				$group_type = "MOLD";
			} else if($group_code == "B"){
				$group_line = 2;
				$group_type = "DIES STP";
			} else if($group_code == "C"){
				$group_line = 3;
				$group_type = "DIES DF";
			} else if($group_code == "D"){
				$group_line = 4;
				$group_type = "MACHINE";
			} else if($group_code == "E"){
				$group_line = 5;
				$group_type = "JIG (STROKE)";
			} else if($group_code == "F"){
				$group_line = 6;
				$group_type = "ELECTRODE";
			} else if($group_code == "G"){
				$group_line = 7;
				$group_type = "JIG (SCHEDULE)";
			} else if($group_code == "H"){
				$group_line = 8;
				$group_type = "POKAYOKE";
			}

			$data['data'] = $this->preventive_schedule_m->get_parts_mte($group_code);
			$data['id'] = $id;
			$data['part'] = $get_part;
			$data['group_line'] = $group_line;
			$data['group_type'] = $group_type;
			$data['all_group_line'] = $this->preventive_schedule_m->get_all_product_group_custom();
			$data['title'] = 'Edit Part preventive';
			$data['msg'] = NULL;
	
			echo $this->load->view('mte/edit_part_preventive_v', $data);
		}
	
		function cancel_create() {
			echo null;
		}
		
		function save() {
			$datenow = date('Ymd');
			$timenow = date('His');
			$session = $this->session->all_userdata();
			$pic = $this->session->userdata('NPK');

			$part_code = trim(strtoupper($this->input->post('CHR_PART_CODE')));
			$part_name = trim(strtoupper($this->input->post('CHR_PART_NAME')));
			$model = trim(strtoupper($this->input->post('CHR_MODEL')));
			$group_line = $this->input->post('GROUP_LINE');

			if($group_line == 1){
				$group_code = "A";
			} else if($group_line == 2){
				$group_code = "B";
			} else if($group_line == 3){
				$group_code = "C";
			} else if($group_line == 4){
				$group_code = "D";
			} else if($group_line == 5){
				$group_code = "E";
			} else if($group_line == 6){
				$group_code = "F";
			} else if($group_line == 7){
				$group_code = "G";
			} else if($group_line == 8){
				$group_code = "H";
			}

			$get_master_data = $this->preventive_schedule_m->get_master_data($part_code);
			if ($get_master_data->num_rows() > 0) {
				redirect($this->back_to_manage . $msg = 12 . '/' . $group_line);
			} 
			else {
				if($group_line == 4){
					$type_prev = $this->input->post('INT_TYPE_PREV');
					$stroke = 0;
					if($type_prev == 3){
						$stroke = 1000;
					} else if($type_prev == 6){
						$stroke = 2000;
					} else if($type_prev == 12){
						$stroke = 4000;
					}
				} else {
					$stroke = $this->input->post('INT_STROKE');
					$type_prev = 0;
				}	
				
				$data = array(
					'CHR_TYPE' => $group_code,
					'CHR_PART_CODE' => $part_code,
					'CHR_PART_CODE2' => $part_code,
					'CHR_PART_NAME' => $part_name,
					'CHR_MODEL' => $model,
					'INT_STROKE_SMALL_PREVENTIVE' => $stroke,
					'CHR_DATE_SMALL_PREVENTIVE' => $datenow,
					'INT_STROKE_BIG_PREVENTIVE' => $stroke,
					'CHR_DATE_BIG_PREVENTIVE' => $datenow,
					'FLG_TYPE_PREV' => $type_prev,
					'CHR_CREATED_BY' => $pic,
					'CHR_CREATED_DATE' => $datenow,
					'CHR_CREATED_TIME' => $timenow,
					'INT_FLAG_DELETE' => '0'
				);
				$this->preventive_schedule_m->save($data);

				redirect($this->back_to_manage . $msg = 1 . '/' . $group_line);
			}
		}

		function update_flag_prev($id) {

			$datenow = date('Ymd');
			$timenow = date('His');
			$pic = $this->session->userdata('NPK');			

			//$part_code = trim($part_code);
			$check_flag = $this->preventive_schedule_m->check_flag($id)->row();
			$part_code = trim($check_flag->CHR_PART_CODE);
			$type = trim($check_flag->CHR_TYPE);
			$flag_small_prev = $check_flag->INT_SMALL_PREVENTIVE;
			$flag_big_prev = $check_flag->INT_BIG_PREVENTIVE;
			$type_preventive = $check_flag->FLG_TYPE_PREV;
			$stroke_small_preventive =  $check_flag->INT_STROKE_SMALL_PREVENTIVE;
			$stroke_big_preventive =  $check_flag->INT_STROKE_BIG_PREVENTIVE;			
				
			// update prev mold mte
			if ($type == 'A') {
				if ($flag_small_prev == 3) {
					// big preventive
					$get_stroke_now = $this->preventive_schedule_m->get_stroke_now_mold($part_code);
					$stroke_now = $get_stroke_now[0]->STROKE;
					$next_stroke_preventive = $stroke_now + $stroke_small_preventive;
					$small_prev_next = 0;
					$big_prev_next = $flag_big_prev + 1;
					$type_prev = 'B';

					$this->preventive_schedule_m->update_big_preventive($part_code, $small_prev_next, $big_prev_next, $datenow, $next_stroke_preventive);
					$this->preventive_schedule_m->insert_transaction_preventive($type, $part_code, $stroke_now, $stroke_big_preventive, $type_prev, $pic, $datenow, $timenow, $id);
				}
				else {
					// small preventive
					$remain_stroke_small_preventive =  $check_flag->INT_REMAIN_SMALL;
					$get_stroke_now = $this->preventive_schedule_m->get_stroke_now_mold($part_code);
					$stroke_now = $get_stroke_now[0]->STROKE;
					$next_stroke_preventive = $stroke_now + $stroke_small_preventive;
					$small_prev_next = $flag_small_prev + 1;
					$type_prev = 'S';
					$this->preventive_schedule_m->update_small_preventive($part_code, $small_prev_next, $datenow, $next_stroke_preventive);
					$this->preventive_schedule_m->insert_transaction_preventive($type, $part_code, $stroke_now, $stroke_big_preventive, $type_prev, $pic, $datenow, $timenow, $id);
				}
			}

			// update prev machine mte
			// start 
			elseif ($type == 'D') {
				// preventive 3 bulan sekali
				if ($type_preventive == 3) {
					if ($flag_small_prev == 3) {
						$flag_small_prev_next = 0;
						$date_small_prev = $datenow;
						$get_production_hour = $this->preventive_schedule_m->get_production_hour($id);
						$last_production_hour = $get_production_hour[0]->INT_PRODUCTION_HOUR;
						$stroke_big_preventive_next = $last_production_hour + 1000;
						$type_prev = '12';
						$this->preventive_schedule_m->update_preventive_machine($id, $flag_small_prev_next, $date_small_prev,  $stroke_big_preventive_next);
						$this->preventive_schedule_m->insert_transaction_preventive_machine($type, $part_code, $last_production_hour, $stroke_big_preventive, $type_prev, $pic, $datenow, $timenow, $id);
					}
					else {
						$flag_small_prev_next = $flag_small_prev + 1;
						$date_small_prev = $datenow;
						$get_production_hour = $this->preventive_schedule_m->get_production_hour($id);
						$last_production_hour = $get_production_hour[0]->INT_PRODUCTION_HOUR;
						$stroke_big_preventive_next = $last_production_hour + 1000;
						$type_prev = '3';
						$this->preventive_schedule_m->update_preventive_machine($id, $flag_small_prev_next, $date_small_prev, $stroke_big_preventive_next);
						$this->preventive_schedule_m->insert_transaction_preventive_machine($type, $part_code, $last_production_hour, $stroke_big_preventive, $type_prev, $pic, $datenow, $timenow, $id);
					}
				}
				// preventive 6 bulan sekali
				elseif ($type_preventive == 6) {					
					if ($flag_small_prev == 2) {						
						$flag_small_prev_next = 0;
						$date_small_prev = $datenow;
						$get_production_hour = $this->preventive_schedule_m->get_production_hour($id);
						$last_production_hour = $get_production_hour[0]->INT_PRODUCTION_HOUR;
						$stroke_big_preventive_next = $last_production_hour + 2000;
						$type_prev = '12';
						$this->preventive_schedule_m->update_preventive_machine($id, $flag_small_prev_next, $date_small_prev,  $stroke_big_preventive_next);
						$this->preventive_schedule_m->insert_transaction_preventive_machine($type, $part_code, $last_production_hour, $stroke_big_preventive, $type_prev, $pic, $datenow, $timenow, $id);
					}
					else {
						$flag_small_prev_next = $flag_small_prev + 2;
						$date_small_prev = $datenow;
						$get_production_hour = $this->preventive_schedule_m->get_production_hour($id);
						$last_production_hour = $get_production_hour[0]->INT_PRODUCTION_HOUR;
						$stroke_big_preventive_next = $last_production_hour + 2000;
						$type_prev = '6';
						$this->preventive_schedule_m->update_preventive_machine($id, $flag_small_prev_next, $date_small_prev, $stroke_big_preventive_next);
						$this->preventive_schedule_m->insert_transaction_preventive_machine($type, $part_code, $last_production_hour, $stroke_big_preventive, $type_prev, $pic, $datenow, $timenow, $id);
					}
				}
				// preventive 12 bulan sekali
				elseif ($type_preventive == 12) {
					$flag_small_prev_next = 0;
					$date_small_prev = $datenow;
					$get_production_hour = $this->preventive_schedule_m->get_production_hour($id);
					$last_production_hour = $get_production_hour[0]->INT_PRODUCTION_HOUR;
					$stroke_big_preventive_next = $last_production_hour + 4000;
					$type_prev = '12';
					$this->preventive_schedule_m->update_preventive_machine($id, $flag_small_prev_next, $date_small_prev,  $stroke_big_preventive_next);
					$this->preventive_schedule_m->insert_transaction_preventive_machine($type, $part_code, $last_production_hour, $stroke_big_preventive, $type_prev, $pic, $datenow, $timenow, $id);
				}
				// end
			} 
			// update prev dies mte 
			elseif ($type == 'B') {
				$get_stroke_now = $this->preventive_schedule_m->get_stroke_now_dies($part_code);
				$stroke_now = $get_stroke_now[0]->stroke;
				// $next_stroke_preventive = $stroke_big_preventive + $stroke_now;
				$next_stroke_preventive = $stroke_small_preventive + $stroke_now; 
				$flag_small_prev_next = $flag_small_prev + 1;
				$date_small_prev = $datenow;
				$last_cum = 0;
				$type_prev = 'S';
				$this->preventive_schedule_m->update_flag_preventive_dies($part_code, $flag_small_prev_next, $date_small_prev, $next_stroke_preventive, $last_cum);
				$this->preventive_schedule_m->insert_transaction_preventive($type, $part_code, $stroke_now, $stroke_big_preventive, $type_prev, $pic, $datenow, $timenow, $id);
			}

			// update prev df mte
			elseif ($type == 'C') {
				$get_stroke_now = $this->preventive_schedule_m->get_stroke_now_df($part_code);
				$stroke_now = $get_stroke_now[0]->stroke;
				// $next_stroke_preventive = $stroke_big_preventive + $stroke_now;
				$next_stroke_preventive = $stroke_small_preventive + $stroke_now;
				$flag_small_prev_next = $flag_small_prev + 1;
				$date_small_prev = $datenow;
				$type_prev = 'S';
				$this->preventive_schedule_m->update_flag_preventive_df($part_code, $flag_small_prev_next, $date_small_prev, $next_stroke_preventive);
				$this->preventive_schedule_m->insert_transaction_preventive($type, $part_code, $stroke_now, $stroke_big_preventive, $type_prev, $pic, $datenow, $timenow, $id);
			}

			// update prev jig
			elseif ($type == 'E') {
				$get_stroke_now = $this->preventive_schedule_m->get_stroke_now_jig($part_code);
				$stroke_now = $get_stroke_now[0]->stroke;
				// $next_stroke_preventive = $stroke_big_preventive + $stroke_now;
				$next_stroke_preventive = $stroke_small_preventive + $stroke_now; 
				$flag_small_prev_next = $flag_small_prev + 1;
				$date_small_prev = $datenow;
				$last_cum = 0;
				$type_prev = 'S';
				$this->preventive_schedule_m->update_flag_preventive_dies($part_code, $flag_small_prev_next, $date_small_prev, $next_stroke_preventive, $last_cum);
				$this->preventive_schedule_m->insert_transaction_preventive($type, $part_code, $stroke_now, $stroke_big_preventive, $type_prev, $pic, $datenow, $timenow, $id);
			}

			$get_header_prev = $this->preventive_schedule_m->get_preventive_header($part_code);
			$id_prev = $get_header_prev->INT_ID;

			$this->preventive_schedule_m->insert_transaction_preventive_detail($id_prev, $id, $part_code, $stroke_now, $pic, $datenow, $timenow);

			if($type == 'A'){
				$group_line = 1;
			} else if($type == 'B'){
				$group_line = 2;
			} else if($type == 'C'){
				$group_line = 3;
			} else if($type == 'D'){
				$group_line = 4;
			} else if($type == 'E'){
				$group_line = 5;
			} else if($type == 'F'){
				$group_line = 6;
			}
			
			//redirect($this->back_to_manage . $msg = 13);
			redirect('mte/report_preventive_c/report_preventive_all/' . $group_line . '/'. 13);
		}

		function update_confirm_prev($group_line, $id) {
			$session = $this->session->all_userdata();
			$user = $this->session->userdata('NPK');
			
			$datenow = date('Ymd');
			$timenow = date('His');

			//===== Update into TT_PREVENTIVE_DETAIL
			$this->db->query("UPDATE MTE.TT_PREVENTIVE_DETAIL SET INT_FLG_CONFIRM = '1', CHR_CONFIRM_BY = '$user', CHR_CONFIRM_DATE = '$datenow', CHR_CONFIRM_TIME = '$timenow' WHERE INT_ID_PREV = '$id'");

			redirect('mte/report_preventive_c/report_history_preventive/' . $group_line);
		}

		function update_confirm_repair($group_line, $id) {
			$session = $this->session->all_userdata();
			$user = $this->session->userdata('NPK');
			
			$datenow = date('Ymd');
			$timenow = date('His');

			//===== Update into TT_PREVENTIVE_DETAIL
			$this->db->query("UPDATE MTE.TT_REPAIR_PREVENTIVE SET INT_FLG_CONFIRM = '1', CHR_CONFIRM_BY = '$user', CHR_CONFIRM_DATE = '$datenow', CHR_CONFIRM_TIME = '$timenow' WHERE INT_ID = '$id'");

			redirect('mte/report_preventive_c/report_history_repair/' . $group_line);
		}
		

		// function get_update_data() {			
		// 	$id = $this->input->post("id");
		// 	// $get_master_data = $this->preventive_schedule_m->find($part_code);
		// 	$get_master_data = $this->preventive_schedule_m->find_by_id($id);
		// 	$data = "";
		// 	$data .= form_open('mte/preventive_schedule_c/update', 'class="form-horizontal"');
		// 	$data .= '
		// 				<input name="CHR_PART_CODE" class="form-control" required type="hidden" value="' . $get_master_data[0]->CHR_PART_CODE . '">
		// 				<div class="form-group">
        //                     <label class="col-sm-4 control-label">Part Code <font style="color:red;">*</font></label>
        //                     <div class="col-sm-8">
        //                         <input name="CHR_PART_CODE" autofocus class="form-control" maxlength="4" required readonly type="text" style="width: 80px;text-transform: uppercase;">
        //                     </div>
        //                 </div>
        //                 <div class="form-group">
        //                     <label class="col-sm-4 control-label">Part Name <font style="color:red;">*</font></label>
        //                     <div class="col-sm-8">
        //                         <input name="CHR_PART_NAME" class="form-control" maxlength="50" required type="text" style="width: 290px;text-transform: uppercase;">
        //                     </div>
        //                 </div>
        //                 <div class="form-group">
        //                     <label class="col-sm-4 control-label">Model <font style="color:red;">*</font></label>
        //                     <div class="col-sm-8">
        //                         <input name="CHR_MODEL" autofocus class="form-control" maxlength="4" required type="text" style="width: 80px;text-transform: uppercase;">
        //                     </div>
        //                 </div>
		// 				<div class="form-group">
		// 					<div class="col-sm-8 col-sm-push-4">
		// 						<div class="btn-group">
		// 							<button type="submit" class="btn btn-primary" data-toggle="tooltip" data-placement="left" title="Update this data"><i class="fa fa-refresh"></i> Update</button>
		// 			';
		// 	$data .= anchor('mte/preventive_schedule_c', 'Cancel', 'class="btn btn-default" data-placement="right" data-toggle="tooltip" title="Back to manage"');
		// 	$data .= '         	</div>
		// 					</div>
		// 				</div>
		// 			';
		// 	$data .= form_close();
		// 	echo $data;
		// }

        function update() {
			$datenow = date('Ymd');
			$timenow = date('His');
			$session = $this->session->all_userdata();
			$pic = $this->session->userdata('NPK');

			$id = $this->input->post('INT_ID');
			$part_code = trim(strtoupper($this->input->post('CHR_PART_CODE')));
			$part_name = trim(strtoupper($this->input->post('CHR_PART_NAME')));
			$model = trim(strtoupper($this->input->post('CHR_MODEL')));
			$group_line = $this->input->post('GROUP_LINE');
			if($group_line == 4){
				$type_prev = $this->input->post('INT_TYPE_PREV');
				$stroke = 0;
				if($type_prev == 3){
					$stroke = 1000;
				} else if($type_prev == 6){
					$stroke = 2000;
				} else if($type_prev == 12){
					$stroke = 4000;
				}
			} else {
				$stroke = $this->input->post('INT_STROKE');
				$type_prev = 0;
			}
			
			$get_data = $this->preventive_schedule_m->find_by_id($id);
			$old_small_prev = $get_data->INT_STROKE_SMALL_PREVENTIVE;
			$old_big_prev = $get_data->INT_STROKE_BIG_PREVENTIVE;
			
			$diff_stroke = 0;
			if($stroke > $old_small_prev){
				$diff_stroke = $stroke - $old_small_prev;
				$new_big_prev = $old_big_prev + $diff_stroke;
			} else if($stroke < $old_small_prev){
				$diff_stroke = $old_small_prev - $stroke;
				$new_big_prev = $old_big_prev - $diff_stroke;
			} else {
				$new_big_prev = $old_big_prev;
			}

			$get_master_data = $this->preventive_schedule_m->cek_double_data($part_code, $id);
			if ($get_master_data->num_rows() >= 1) {
				redirect($this->back_to_manage . $msg = 12 . '/' . $group_line);
			} else {
				$data = array(
					'CHR_PART_CODE' => $part_code,
					'CHR_PART_NAME' => $part_name,
					'CHR_MODEL' => $model,
					'INT_STROKE_SMALL_PREVENTIVE' => $stroke,
					'INT_STROKE_BIG_PREVENTIVE' => $new_big_prev,
					'FLG_TYPE_PREV' => $type_prev,
					'CHR_MODIFIED_BY' => $pic,
					'CHR_MODIFIED_DATE' => $datenow,
					'CHR_MODIFIED_TIME' => $timenow
				);
				$this->preventive_schedule_m->update($data, " INT_ID = " . $id . "");
				
				if($group_line != 4){
					$data = array(
						'CHR_PART_CODE' => $part_code,
						'CHR_MODIFIED_BY' => $pic,
						'CHR_MODIFIED_DATE' => $datenow,
						'CHR_MODIFIED_TIME' => $timenow
					);
					$this->preventive_schedule_m->update_detail($data, " INT_ID_PART = " . $id . "");
				}
	
				redirect($this->back_to_manage . $msg = 2 . '/' . $group_line);
			}
			
		}
	
        function delete($part_code) {
			$datenow = date('Ymd');
			$timenow = date('His');
			$pic = $this->session->userdata('NPK');
            $this->preventive_schedule_m->delete($part_code, $pic, $datenow, $timenow);
	        redirect($this->back_to_manage . $msg = 3);
		}
		
		function add_detail($group_line, $part_code) {
			$data['data'] = $this->preventive_schedule_m->get_detail_data($part_code);

			$part_data = $this->preventive_schedule_m->find($part_code);
			$id = $part_data[0]->INT_ID;
			$data['id_part'] = $id;

			$data['content'] = 'mte/manage_part_preventive_detail_v';
			$data['title'] = 'Add Detail';
			$data['msg'] = null;
			$data['group_line'] = $group_line;
			$data['part_code'] = $part_code;
			$data['news'] = $this->news_m->get_news();
	        $data['app'] = $this->role_module_m->get_app();
	        $data['module'] = $this->role_module_m->get_module();
	        $data['function'] = $this->role_module_m->get_function();
	        $data['sidebar'] = $this->role_module_m->side_bar(47);

        	$this->load->view($this->layout, $data);
		}

		function go_to_upload_wo($msg=NULL) {
			if ($msg == 1) {
	            $msg = "<div class = 'alert alert-success'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Upload sukses </strong> Data berhasil diupload</div >";
	        } elseif ($msg == 2) {
	            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Updating success </strong> The data is successfully updated </div >";
	        } elseif ($msg == 3) {
	            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Deleted success </strong> The data is successfully deleted </div >";
	        } elseif ($msg == 4) {
	            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Choosing failed </strong> You must select at least one data</div >";
	        } elseif ($msg == 12) {
	            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Tidak bisa upload</strong> Mohon periksa data dari template upload anda</div >";
	        }
	        $data['msg'] = $msg;
			$data['data'] = $this->preventive_schedule_m->get_wo();
			$data['content'] = 'mte/upload_wo_v';
			$data['title'] = 'Upload WO';
			$data['news'] = $this->news_m->get_news();
	        $data['app'] = $this->role_module_m->get_app();
	        $data['module'] = $this->role_module_m->get_module();
	        $data['function'] = $this->role_module_m->get_function();
	        $data['sidebar'] = $this->role_module_m->side_bar(47);

        	$this->load->view($this->layout, $data);
		}

		function search()
		{
			$term = $this->input->get('term');
			if ($term) {
				$result = $this->preventive_schedule_m->get_data_part_number($term);
				if (count($result) > 0) {
					foreach ($result as $res) {
						$output = array(
							'part_no' => $res->CHR_PART_NO,
							'back_no' => $res->CHR_BACK_NO,							
							'part_name' => $res->CHR_PART_NAME
						); 
					}
					echo json_encode($output);
				}
			}
		}

		function get_data_work_center(){
			$backno = $this->input->post("CHR_BACK_NO");
			$data_work_center = $this->preventive_schedule_m->get_work_center_by_part_no($backno);
			$data = '';
			foreach ($data_work_center as $row) { 
				$data .="<option selected value='$row->CHR_WORK_CENTER'>".$row->CHR_WORK_CENTER."</option>";
			}
			//$data .="</select>";
			$json_data = array('data' => $data);
			echo json_encode($json_data);
		}

		function get_data_part_number(){
			$backno = $this->input->post("CHR_BACK_NO");
			$data_part_no = $this->preventive_schedule_m->get_data_part_number($backno);
			$data = '';
			foreach ($data_part_no as $row) { 
				$json_data = array(
					'part_no' => $row->CHR_PART_NO,
					'part_name' => $row->CHR_PART_NAME
				);
			}			
			
			echo json_encode($json_data);
		}

		function add_part_no()
		{
			$datenow = date('Ymd');
			$timenow = date('His');
			$pic = $this->session->userdata('NPK');
			$session = $this->session->all_userdata();
			$pic = $this->session->userdata('NPK');

			$part_code = trim($this->input->post('partcode'));
			$id_part = $this->input->post('id_part');
			$back_no = trim($this->input->post('backno'));

			$part_no = trim($this->input->post('partno'));
			$part_name = $this->input->post('partname');
			$work_center = trim($this->input->post('work_center'));


			$data_detail = array(
				'CHR_PART_CODE' => $part_code,
				'CHR_PART_NO' => $part_no,
				'CHR_WORK_CENTER' => $work_center,
				'CHR_BACK_NO' => strtoupper($back_no),
				'CHR_PART_NAME' => $part_name,
				'CHR_CREATED_BY' => $pic,
				'CHR_CREATED_DATE' => $datenow,
				'CHR_CREATED_TIME' => $timenow,
				'INT_FLAG_DELETE' => '0',
				'INT_ID_PART' => $id_part
			);
			$this->preventive_schedule_m->save_detail_data($data_detail);
			redirect('mte/preventive_schedule_c/add_detail/'. $part_code);
		}

		function delete_detail($partcode, $partno) {
			$datenow = date('Ymd');
			$timenow = date('His');
			$pic = $this->session->userdata('NPK');
			$this->preventive_schedule_m->delete_detail_data($partcode, $partno, $pic, $datenow, $timenow);
	        redirect('mte/preventive_schedule_c/add_detail/'.$partcode);
		}

		function generate_template() {
			$this->load->library('excel');
        
			$list_data = $this->preventive_schedule_m->get_data_part_wo();
			$date_now = date("d-M-Y"); 

			// Create new PHPExcel object
			$objPHPExcel = new PHPExcel();

			// Set Properties
			$sheetProperties = $objPHPExcel->getProperties();
			$sheetProperties->setCreator(trim($this->session->userdata('USERNAME')));
			$sheetProperties->setLastModifiedBy(trim($this->session->userdata('USERNAME')));
			$sheetProperties->setTitle("WO data");
			$sheetProperties->setSubject("WO data");
			$sheetProperties->setDescription("WO data");
					
			//Header TR
			$sheetActivate = $objPHPExcel->getActiveSheet();
			$sheetActivate->setCellValue('A1', 'Work Order Spare Parts');
			$sheetActivate->setCellValue('A2', 'Date (ex. 201908)');
			$sheetActivate->setCellValue('B2', 'Part Code');
			$sheetActivate->setCellValue('C2', 'Quantity');
			$sheetActivate->getStyle("A1")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
			$sheetActivate->getStyle("A2:C2")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			
			$sheetActivate->getStyle('A1')->getFont()->setBold(true)->setSize(16);

			$sheetActivate->getColumnDimension('A')->setWidth(20);
			$sheetActivate->getColumnDimension('B')->setWidth(20);
			$sheetActivate->getColumnDimension('C')->setWidth(15);
			
			//Value of All Cells
			$e = 3;
			$i = 3;
			foreach($list_data as $data){
				$sheetActivate->setCellValue('A'.$i, "201908");
				$sheetActivate->setCellValue('B'.$i, trim($data->CHR_PART_CODE));
				$sheetActivate->setCellValue('C'.$i, "0");
				$i++;
			}
			$sheetActivate->getStyle("A".$e.":C".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			
			$styleArray = array(
				'borders' => array(
					'outline' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
					),
				),
			);
			
			$styleArray2 = array(
					'fill' => array(
						'type' => PHPExcel_Style_Fill::FILL_SOLID,
						'color' => array('rgb' => '2E86C1')
				),
				'font'  => array(
					'bold'  => true,
					'color' => array('rgb' => 'FFFFFF'),
					'size'  => 11,
					'name'  => 'Calibri'
				)
			);

			$sheetActivate->getStyle("A2:C2")->applyFromArray($styleArray2);
			
			$filename = "WO upload " . $date_now . ".xls";
			
			ob_end_clean();
			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="' . trim($filename) . '"');
			header('Cache-Control: max-age=0');

			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
			//$objWriter->setIncludeCharts(TRUE);
			$objWriter->save('php://output');
		}

		function upload_wo() {
			$this->load->library(array('PHPExcel', 'PHPExcel/IOFactory'));
			
			$pic = $this->session->userdata('NPK');
			$date_now = date("Ymd");
			$time_now = date("His");

			$fileName = $_FILES['data_wo']['name'];
			if (empty($fileName)) {                
				redirect($this->back_to_create_view . $msg = 4);
			}
			//file untuk submit file excel
			$config['upload_path'] = './assets/file/wo_mte/';
			$config['file_name'] = $fileName;
			$config['allowed_types'] = 'xls';
			$config['max_size'] = 10000;
			
			//code for upload with ci
			$this->load->library('upload', $config);

			
			
			$media = $this->upload->data('data_wo');
			$inputFileName = './assets/file/wo_mte/' . $media['file_name'];

			
			//  Read  Excel workbook
			try {
				$inputFileType = IOFactory::identify($inputFileName);
				$objReader = IOFactory::createReader($inputFileType);
				$objPHPExcel = $objReader->load($inputFileName);
			} catch (Exception $e) {
				die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' . $e->getMessage());
			}

			//  Get worksheet dimensions
			$sheet = $objPHPExcel->getSheet(0);
			$highestRow = $sheet->getHighestRow();
			$highestColumn = $sheet->getHighestColumn();

			$x = 0;
			$y = 0;
			$rowHeader = $sheet->rangeToArray('A1:' . $highestColumn . '1', NULL, TRUE, FALSE);
			if ($rowHeader[0][0] == "Work Order Spare Parts") {
				for ($row = 3; $row <= $highestRow; $row++) {

					$error_msg = "";
					$error_stat = 0;
					$rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);

					$date_periode = $rowData[0][1];
					$part_code = $rowData[0][2];
					$quantity = $rowData[0][3];

					// Check qty_max
					if (!is_numeric($quantity)) {
						redirect($this->back_to_upload_wo . $msg = 12);
					}

					// Check kondisi part code sudah ada atau belum
					$check_part_code = $db_samanta->query("SELECT * FROM TM_LINE_CAPACITY WHERE CHR_PART_CODE = '$part_code' AND CHR_PERIODE = '$date_periode'")->num_rows();
					if ($check_part_code > 0) {
						// update data
						$this->preventive_schedule_m->update_data_upload($date_periode, $part_code, $quantity, $pic, $date_now, $time_now);
					}
					// insert to table
					$this->preventive_schedule_m->insert_data_upload($date_periode, $part_code, $quantity, $pic, $date_now, $time_now);
				}
				redirect($this->back_to_create_view . $msg = 1);
			} else {
				redirect($this->back_to_upload_wo . $msg = 12);
			}
		}

		// menu list preventive, untuk melihat seluruh yang lagi dihitung preventivenya

		function manage_preventive($group) {
			$data['data'] = $this->preventive_schedule_m->get_data_all_preventive_filter($group);
			$data['group_preventive'] = $this->preventive_schedule_m->group_preventive();
			$data['group'] = $group;
			$data['content'] = 'mte/manage_preventive_v';
			$data['title'] = 'View All Data Preventive';
			$data['news'] = $this->news_m->get_news();
	        $data['app'] = $this->role_module_m->get_app();
	        $data['module'] = $this->role_module_m->get_module();
	        $data['function'] = $this->role_module_m->get_function();
	        $data['sidebar'] = $this->role_module_m->side_bar(316);

        	$this->load->view($this->layout, $data);
		}

		// function search_list_preventive($group) {
		// 	$data['data'] = $this->preventive_schedule_m->get_data_all_preventive_filter($group);
		// 	$data['group_preventive'] = $this->preventive_schedule_m->group_preventive();
		// 	$data['content'] = 'mte/manage_preventive_v';
		// 	$data['title'] = 'View All Data Preventive';
		// 	$data['news'] = $this->news_m->get_news();
	    //     $data['app'] = $this->role_module_m->get_app();
	    //     $data['module'] = $this->role_module_m->get_module();
	    //     $data['function'] = $this->role_module_m->get_function();
	    //     $data['sidebar'] = $this->role_module_m->side_bar(316);

        // 	$this->load->view($this->layout, $data);
		// }

		function edit_part_preventive($id) {
			// print_r($id);
			// exit();
			$data['app'] = $this->role_module_m->get_app();
			$data['module'] = $this->role_module_m->get_module();
			$data['function'] = $this->role_module_m->get_function();
			$data['sidebar'] = $this->role_module_m->side_bar(316);
			
			$get_part = $this->preventive_schedule_m->find_by_id($id);
			$group_code = $get_part->CHR_TYPE;

			if($group_code == "A"){
				$group_line = 1;
				$group_type = "MOLD";
			} else if($group_code == "B"){
				$group_line = 2;
				$group_type = "DIES STP";
			} else if($group_code == "C"){
				$group_line = 3;
				$group_type = "DIES DF";
			} else if($group_code == "D"){
				$group_line = 4;
				$group_type = "MACHINE";
			} else if($group_code == "E"){
				$group_line = 5;
				$group_type = "JIG (STROKE)";
			} else if($group_code == "F"){
				$group_line = 6;
				$group_type = "ELECTRODE";
			} else if($group_code == "G"){
				$group_line = 7;
				$group_type = "JIG (SCHEDULE)";
			} else if($group_code == "H"){
				$group_line = 8;
				$group_type = "POKAYOKE";
			}

			$data['data'] = $this->preventive_schedule_m->get_parts_mte($group_code);
			$data['part'] = $get_part;
			$data['group_line'] = $group_line;
			$data['group_type'] = $group_type;
			$data['all_group_line'] = $this->preventive_schedule_m->get_all_product_group_custom();
			$data['title'] = 'Edit Part preventive';
			$data['msg'] = NULL;
			$data['subcontent'] = 'mte/edit_part_preventive_v';
			$data['content'] = 'mte/manage_part_preventive_new_v';
	
			$this->load->view($this->layout, $data);
		}

	}
	
?>