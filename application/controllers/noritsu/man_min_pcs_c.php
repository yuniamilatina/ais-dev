<?php
	/**
	* 
	*/
	class man_min_pcs_c extends CI_Controller
	{
		
		private $layout = '/template/head';
	    private $back_to_manage = 'noritsu/man_min_pcs_c/index/';

	    public function __construct() {
	        parent::__construct();
	        $this->load->model('noritsu/man_min_pcs_m');
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
	        } elseif ($msg == 6) {
	        	$msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Update error !</strong> Man Min/Pcs Must Be Number Or Decimal </div >";
	        }
	        $data['msg'] = $msg;
	        $data['data'] = $this->man_min_pcs_m->get_man_min_pcs();
	        $data['dept'] = $this->man_min_pcs_m->get_dept();
	        $data['wc'] = $this->man_min_pcs_m->get_work_center();
	        $data['content'] = 'noritsu/man_min_pcs/manage_man_min_pcs_v';
	        $data['title'] = 'Manage Man Minute / Pcs';
	        $data['news'] = $this->news_m->get_news();
	        $data['app'] = $this->role_module_m->get_app();
	        $data['module'] = $this->role_module_m->get_module();
	        $data['function'] = $this->role_module_m->get_function();
	        $data['sidebar'] = $this->role_module_m->side_bar(284);

	        $this->load->view($this->layout, $data);
	    }


	    //prepare to create
	    function create_man_min_pcs() {
	        $this->role_module_m->authorization('3');
	        $data['content'] = 'noritsu/man_min_pcs/create_man_min_pcs_v';
	        $data['title'] = 'Create Man Minute / Pcs';
	        $data['man_min'] = NULL;
	        $data['dept'] = $this->man_min_pcs_m->get_dept();
	        $data['wc'] = $this->man_min_pcs_m->get_work_center();
	        $data['news'] = $this->news_m->get_news();
	        $data['app'] = $this->role_module_m->get_app();
	        $data['module'] = $this->role_module_m->get_module();
	        $data['function'] = $this->role_module_m->get_function();
	        $data['sidebar'] = $this->role_module_m->side_bar(284);

	        $this->load->view($this->layout, $data);
	    }

	    //saving data
	    function save_man_min_pcs() {

			foreach ($_POST['list'] as $isi) {
				$row = explode(':', $isi);
				$id = $row[0];
				$manmin = $row[1];
				$err = $row[2];

				if($err == "0") {
					$data = array(
		            	'CHR_MAN_MIN_PCS' => $manmin
		            );
	            	$this->man_min_pcs_m->update_man_min_pcs($data, $id);
				}
			}
            redirect($this->back_to_manage . $msg = 1);
	    }

	    

	    //updating data
	    function update_man_min_pcs() {
	        $id = $this->input->post('CHR_PART_NO');
	        $msg = 2;
			$manmin = $this->input->post('CHR_MAN_MIN_PCS');
			if (preg_match('/^[0-9]+(\.[0-9]{1,2})?$/', $manmin)) {
				$data = array(
	            	'CHR_MAN_MIN_PCS' => $this->input->post('CHR_MAN_MIN_PCS')
	            );
	            $this->man_min_pcs_m->update_man_min_pcs($data, $id);

            	redirect($this->back_to_manage . $msg);
            } else {
            	redirect($this->back_to_manage . $msg = 6);
            }

            					
	    }

	  //   function delete_man_min_pcs($id) {
	  //       $this->role_module_m->authorization('3');
	  //       $data = array(
   //          	'CHR_FLAG_DEL' => '1',
   //          	'CHR_MODIFIED_BY' => $this->session->userdata('USERNAME'),
   //          	'CHR_MODIFIED_DATE' => $tgl,
   //          	'CHR_MODIFIED_TIME' => $time
   //          );
	  //       $this->man_min_pcs_m->update_man_min_pcs($data, $id);
	  //       redirect($this->back_to_manage . $msg = 3);
	  //   }

	    function get_template(){
	    	$this->role_module_m->authorization('3');
        
	        $msg = "";
	           
            $this->load->library('excel');

            if($this->input->post('CHR_WORK_CENTER') && $this->input->post('CHR_DEPT')){
            	$wc = $this->input->post('CHR_WORK_CENTER');
            	$dept = $this->input->post('CHR_DEPT');
            	$view_data = $this->man_min_pcs_m->get_data_template($dept,$wc);
            } else {
            	$view_data = $this->man_min_pcs_m->get_man_min_pcs();
            }

            $objPHPExcel = new PHPExcel();

	        $style = array(
		        'alignment' => array(
		            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
		        )
		    );

		    $objPHPExcel->getDefaultStyle()->applyFromArray($style);

	        //SETUP EXCEL
	        $width = 10;
	        $objPHPExcel->setActiveSheetIndex(0);
	        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(6);
	        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
	        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
	        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
	        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(45);
	        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);

	        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'No');
	        $objPHPExcel->getActiveSheet()->setCellValue('B1', 'Work Center');
	        $objPHPExcel->getActiveSheet()->setCellValue('C1', 'Part No');
	        $objPHPExcel->getActiveSheet()->setCellValue('D1', 'Back No');
	        $objPHPExcel->getActiveSheet()->setCellValue('E1', 'Part Name');
	        $objPHPExcel->getActiveSheet()->setCellValue('F1', 'Man Min/Pcs');

            $i = 2;
            $no = 1;

            foreach($view_data as $data){
                $objPHPExcel->getActiveSheet()->setCellValue("A$i", $no);
                $objPHPExcel->getActiveSheet()->setCellValue("B$i", $data->CHR_WORK_CENTER);
                $objPHPExcel->getActiveSheet()->setCellValue("C$i", $data->CHR_PART_NO);                
                $objPHPExcel->getActiveSheet()->setCellValue("D$i", $data->CHR_BACK_NO);
                $objPHPExcel->getActiveSheet()->setCellValue("E$i", $data->CHR_PART_NAME);
                $objPHPExcel->getActiveSheet()->setCellValue("F$i", $data->CHR_MAN_MIN_PCS);

                $i++;
                $no++;
            }

            $i = $i - 1;
	        $objPHPExcel->getActiveSheet()->getStyle("A1:F$i")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
	        $objPHPExcel->getActiveSheet()->getStyle("A1:F1")->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('CCFFFF');

            $filename = "manminpcs.xlsx";
	        ob_end_clean();
	        header('Content-Type: application/vnd.ms-excel');
	        header('Content-Disposition: attachment;filename="' . trim($filename) . '"');
	        header('Cache-Control: max-age=0');

	        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	        $objWriter->save('php://output');

            
            $msg = "<div class = 'alert alert-success'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Downloading success </strong> The data is successfully created </div >";
	    }

	    function upload_man_min_pcs(){
       		$this->load->library(array('PHPExcel', 'PHPExcel/IOFactory'));
	        
	        $fileName = $_FILES['upload_man_min']['name'];
	        //file untuk submit file excel
	        $maxsize = 5000000;
	    	$size = $_FILES['upload_man_min']['size'];
			$ekstensi = array('xls','xlsx');
			$namaF = $_FILES['upload_man_min']['name'];
			$x = explode('.',$namaF);
			$eksten = strtolower(end($x));
			$file_tmp = $_FILES['upload_man_min']['tmp_name'];						
						
	        //code for upload with ci
			if(in_array($eksten, $ekstensi)===true)
			{
				if($size <= $maxsize){
					move_uploaded_file($file_tmp,'./assets/man_min_pcs/'.$namaF);
					
				}
			}

	        
	        $inputFileName = './assets/man_min_pcs/' . $namaF;


	        //  Read  Excel workbook
	        try {
	            $inputFileType = IOFactory::identify($inputFileName);
	            $objReader = IOFactory::createReader($inputFileType);
	            $objPHPExcel = $objReader->load($inputFileName);
	            
	        } catch (Exception $e) {
	            die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' . $e->getMessage());
	        }
            
            //Get worksheet dimensions
            $sheet = $objPHPExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();

            $rowHeader = $sheet->rangeToArray('A1:' . $highestColumn . $highestRow, NULL, TRUE, FALSE);

            $no = $rowHeader[0][0];
            $wc = $rowHeader[0][1];
            $partno = $rowHeader[0][2];
            $backno = $rowHeader[0][3];
            $partname = $rowHeader[0][4];
            $manmin = $rowHeader[0][5];
            // $man_min = [];

            if ($no == 'No' && $wc == 'Work Center' && $partno == 'Part No' && $backno == 'Back No' && $partname == 'Part Name' && $manmin == 'Man Min/Pcs') {

                for ($row = 2; $row <= $highestRow; $row++) {
                    $rowData = $sheet->rangeToArray('A' . $row . ':' . 'F' . $row, NULL, TRUE, FALSE);

                    $workcenter = $rowData[0][1];
                    $partnumber = $rowData[0][2];
                    $backnumber = $rowData[0][3];
                    $name = $rowData[0][4];
                    $manmin = round($rowData[0][5], 2);
                    $error = "";

                    if(is_float($manmin)){
                    	$error = "0";
                    } else {
                    	$error = "Man Min/Pcs Must Be Number Or Decimal";
                    }
      //               if (!preg_match('/^[0-9]+(\.[0-9]{1,2})?$/', $manmin)) {
						// $error = "Man Min/Pcs Must Be Number Or Decimal";                    	
      //               } else {
      //               	$error = "0";
      //               }

           //          array_push($man_min, [
			        //   'CHR_WORK_CENTER' => $workcenter, 
			        //   'CHR_PART_NO' => $partnumber, 
			        //   'CHR_BACK_NO' => $backnumber, 
			        //   'CHR_PART_NAME' => $name,
			        //   'CHR_MAN_MIN_PCS' => $manmin,
			        //   'CHR_ERROR' => $error, 
			        // ]);
			        $man_min[] = array(
			        	'CHR_WORK_CENTER' => $workcenter , 
			        	'CHR_PART_NO' => $partnumber, 
			        	'CHR_BACK_NO' => $backnumber, 
			        	'CHR_PART_NAME' => $name,
			        	'CHR_MAN_MIN_PCS' => $manmin,
			        	'CHR_ERROR' => $error
			        );
                }
                // print_r($man_min);
                // echo $man_min['CHR_WORK_CENTER'];

                $this->role_module_m->authorization('3');
		        $data['content'] = 'noritsu/man_min_pcs/create_man_min_pcs_v';
		        $data['title'] = 'Create Man Minute / Pcs';
		        $data['man_min'] = $man_min;
		        $data['dept'] = $this->man_min_pcs_m->get_dept();
		        $data['wc'] = $this->man_min_pcs_m->get_work_center();
		        $data['news'] = $this->news_m->get_news();
		        $data['app'] = $this->role_module_m->get_app();
		        $data['module'] = $this->role_module_m->get_module();
		        $data['function'] = $this->role_module_m->get_function();
		        $data['sidebar'] = $this->role_module_m->side_bar(284);
                

		        $this->load->view($this->layout, $data);
                
            } else {
                // redirect($this->back_to_upload .$candidate_id.'/'.$period.'/'.$dept.'/'.$msg = 15);
            }

	        
	    }


	}

?>