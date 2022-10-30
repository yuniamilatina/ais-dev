<?php
	/**
	* 
	*/
	// $fullPathToFile = "C:/xampp/htdocs/AIS/assets/Document/Master_list/WIS-MISY-05.pdf";
	$fullPathToFile = "";
	$no_doc = "";
	$effective_date = "";
	$rev = 0;
	class document_c extends CI_Controller
	{
		
		private $layout = '/template/head';
	    private $back_to_manage = 'efila/document_c/index/';

	    public function __construct() {
	        parent::__construct();
	        $this->load->model('efila/document_m');
	        $this->load->model('basis/role_module_m');
	        $this->load->model('portal/news_m');
	        $this->load->model('portal/notification_m');
	        
	        // $this->load->model('asset/award_m');
	    }

	    function index($msg = NULL) {
	        $this->role_module_m->authorization('3');

	        if ($msg == 1) {
	            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times</button><strong>Creating success </strong> The data is successfully created </div >";
	        } elseif ($msg == 2) {
	            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times</button><strong>Updating success </strong> The data is successfully updated </div >";
	        } elseif ($msg == 3) {
	            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times</button><strong>Deleted success </strong> The data is successfully deleted </div >";
	        } elseif ($msg == 4) {
	            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times</button><strong>Choosing failed </strong> You must select at least one data</div >";
	        } elseif ($msg == 12) {
	            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times</button><strong>Executing error !</strong> Something error with parameter </div >";
	        }
	        $data['msg'] = $msg;
	        $data['cat'] = $this->document_m->get_category();
	        $data['data'] = $this->document_m->get_document();
	        $data['dist'] = $this->document_m->get_distribution_dept();
	        $data['dept'] = $this->document_m->get_department();
	        $data['content'] = 'efila/document/manage_document_v';
	        $data['title'] = 'Master List Document';
	        $data['news'] = $this->news_m->get_news();
	        $data['app'] = $this->role_module_m->get_app();
	        $data['module'] = $this->role_module_m->get_module();
	        $data['function'] = $this->role_module_m->get_function();
			$data['sidebar'] = $this->role_module_m->side_bar(265);
			
			$data['idcat'] = NULL;
		    $data['iddept'] = NULL;

	        $this->load->view($this->layout, $data);
	    }

	    function filter_category() {
	        $this->role_module_m->authorization('3');
	        $idcat = $this->input->post("INT_ID_CATEGORY");
	        $department = $this->input->post("INT_ID_DEPT");
	        if(isset($_POST["export"])){
	        	if($idcat != "" && $department != ""){
		        	$this->export_master_list($department, $idcat);
		        } elseif ($idcat != "" && $department == "") {
		        	$this->export_master_list("a", $idcat);
		        } elseif ($idcat == "" && $department != "") {
		        	$this->export_master_list($department, "a");
		        } else {
		        	$this->export_master_list();
		        }
	        } else {
		        if($idcat != "" && $department != ""){
		        	$data['data'] = $this->document_m->get_document_by_catdept($idcat, $department);
		        	$data['idcat'] = $idcat;
		        	$data['iddept'] = $department;
		        } elseif ($idcat != "" && $department == "") {					
		        	$data['data'] = $this->document_m->get_document_by_cat($idcat);
		        	$data['idcat'] = $idcat;
		        	$data['iddept'] = NULL;
		        } elseif ($idcat == "" && $department != "") {
		        	$data['data'] = $this->document_m->get_document_by_dept($department);
		        	$data['iddept'] = $department;
		        	$data['idcat'] = NULL;
		        } elseif ($idcat == "" && $department == "") {
		        	redirect('efila/document_c');
				}
				
				// print_r($data['idcat']);
				// exit();

		        $data['cat'] = $this->document_m->get_category();
		        $data['dist'] = $this->document_m->get_distribution_dept();
		        $data['dept'] = $this->document_m->get_department();
		        $data['content'] = 'efila/document/manage_document_v';
		        $data['title'] = 'Master List Document';
		        $data['news'] = $this->news_m->get_news();
		        $data['app'] = $this->role_module_m->get_app();
		        $data['module'] = $this->role_module_m->get_module();
		        $data['function'] = $this->role_module_m->get_function();
		        $data['sidebar'] = $this->role_module_m->side_bar(265);

		        $this->load->view($this->layout, $data);
	        }
	    }

	    function list_document() {
	        $data['data'] = $this->document_m->get_list_document();
	        $data['dept'] = $this->document_m->get_dept_name();
	        $data['content'] = 'efila/document/list_document_v';
	        $data['title'] = 'List Document';
	        $data['news'] = $this->news_m->get_news();
	        $data['app'] = $this->role_module_m->get_app();
	        $data['module'] = $this->role_module_m->get_module();
	        $data['function'] = $this->role_module_m->get_function();
	        $data['sidebar'] = $this->role_module_m->side_bar(255);

	        $this->load->view($this->layout, $data);
	    }

	    //prepare to create
	    function create_document() {
	        $this->role_module_m->authorization('3');
	        $data['content'] = 'efila/document/create_document_v';
	        $data['cat'] = $this->document_m->get_category();
	        $data['title'] = 'Create Document';
	        $data['news'] = $this->news_m->get_news();
	        $data['app'] = $this->role_module_m->get_app();
	        $data['module'] = $this->role_module_m->get_module();
	        $data['function'] = $this->role_module_m->get_function();
	        $data['sidebar'] = $this->role_module_m->side_bar(265);

	        $this->load->view($this->layout, $data);
	    }

	    //saving data
	    function save_document() {
	    	date_default_timezone_set('Asia/Jakarta');
	    	$today1 = date("Y-m-d");
	    	$today2 = date_create($today1);
	    	$tgl = date_format($today2,"Ymd");

	    	$time1 = date("H:i:s");
	    	$time2 = date_create($time1);
	    	$time = date_format($time2,"His");
	    	$sec = $this->session->userdata("SECTION");
	    	$username = $this->session->userdata("USERNAME");
	    	
			$maxsize = 5000000;
	    	$size = $_FILES['uploadFile']['size'];
			$ekstensi = array('doc','docx');
			$namaF = $_FILES['uploadFile']['name'];
			$x = explode('.',$namaF);
			$eksten = strtolower(end($x));
			$file_tmp = $_FILES['uploadFile']['tmp_name'];						
						
			if(in_array($eksten, $ekstensi)===true)
			{
				if($size <= $maxsize){
					move_uploaded_file($file_tmp,'./assets/Document/'.$namaF);
					$data = array(
		            	'CHR_DOCUMENT_NAME' => $this->input->post('CHR_DOCUMENT_NAME'),
		            	'CHR_DOCUMENT_DESC' => $this->input->post('CHR_DOCUMENT_DESC'),
		            	'CHR_CREATED_BY' => $username,
		            	'CHR_CREATED_DATE' => $tgl,
		            	'CHR_CREATED_TIME' => $time,
		            	'INT_ID_SECTION' => $sec,
		            	'INT_ID_CATEGORY' => $this->input->post('INT_ID_CATEGORY'),
		            	'CHR_DOC' => $namaF,
		            	'INT_STATUS' => 1
		            );
		            $this->document_m->save_document($data);
		            
		            $id = 0;
		            $iddoc = $this->document_m->get_id_doc();
		            foreach ($iddoc as $isi) {
		            	$id = $isi->id;
		            }
		            $data1 = array(
		            	'INT_ID_DOCUMENT' => $id,
		            	'INT_TYPE' => 1,
		            	'CHR_CREATED_DATE' => $tgl,
		            	'CHR_CREATED_TIME' => $time
		            );
		            $this->document_m->save_approval($data1);

		            redirect($this->back_to_manage . $msg = 1);
				} else {
					redirect($this->back_to_manage . $msg = 15);
				}
			}			
	    }

	    //prepare to editing
	    function edit_document($id) {
	        $this->role_module_m->authorization('3');
	        $data['data'] = $this->document_m->get_data_document($id)->row();
	        $data['content'] = 'efila/document/edit_document_v';
	        $data['title'] = 'Edit  Document';
	        $data['news'] = $this->news_m->get_news();
	        $data['app'] = $this->role_module_m->get_app();
	        $data['module'] = $this->role_module_m->get_module();
	        $data['function'] = $this->role_module_m->get_function();
	        $data['sidebar'] = $this->role_module_m->side_bar(247);

	        $this->load->view($this->layout, $data);
	    }

	    //updating data
	    function update_document() {
	        $id = $this->input->post('INT_ID_DOCUMENT');
	        $msg = 2;

	        $tgl = date_create($this->input->post('CHR_CREATED_DATE'));
			$date = date_format($tgl,"Ymd");

			$maxsize = 5000000;
	    	$size = $_FILES['uploadFoto']['size'];
			$ekstensi = array('doc','docx');
			$namaF = $_FILES['uploadFoto']['name'];
			$x = explode('.',$namaF);
			$eksten = strtolower(end($x));
			$file_tmp = $_FILES['uploadFoto']['tmp_name'];

			if($namaF == ""){
				$namaF = $this->input->post('CHR_DOC_OLD');
				$data = array(
	            	'CHR_DOCUMENT_NAME' => $this->input->post('CHR_DOCUMENT_NAME'),
	            	'CHR_DOCUMENT_DESC' => $this->input->post('CHR_DOCUMENT_DESC'),
	            	'CHR_CREATED_DATE' => $tgl,
		            'CHR_CREATED_TIME' => $time,
	            	'CHR_DOC' => $namaF,
	            	'INT_STATUS' => 1
	            );

	            $this->document_m->update($data, $id);

	            redirect($this->back_to_manage . $msg);
			}						
						
			if(in_array($eksten, $ekstensi)===true)
			{
				if($size <= $maxsize){
					move_uploaded_file($file_tmp,DOCROOT.'/assets/Document/'.$namaF);
					$data = array(
		            	'CHR_DOCUMENT_NAME' => $this->input->post('CHR_DOCUMENT_NAME'),
		            	'CHR_DOCUMENT_DESC' => $this->input->post('CHR_DOCUMENT_DESC'),
		            	'CHR_CREATED_DATE' => $tgl,
		            	'CHR_CREATED_TIME' => $time,
		            	'CHR_DOC' => $namaF,
		            	'INT_STATUS' => 1
		            );

		            $this->document_m->update($data, $id);

		            redirect($this->back_to_manage . $msg);
				} else {
					redirect($this->back_to_manage . $msg = 15);
				}
			}						
					
	    }

	    function delete_document($id) {
	        $this->role_module_m->authorization('3');
	        $this->document_m->delete($id);
	        redirect($this->back_to_manage . $msg = 3);
	    }

	    function revision_doc() {
	    	$id = $this->input->post("INT_ID_DOCUMENT");

	    	$data = array(
	    		'INT_ID_DOCUMENT' => $id,
	    		'INT_TYPE' => 2,
	    		'CHR_INFORMATION' => $this->input->post("CHR_INFORMATION") 
	    	);
	    	$this->document_m->save_revision($data);
	    	$msg = 2;
	    	redirect($this->back_to_manage . $msg);
	    }

	    
	    function view_doc($doc) {
	    	// echo 'start /wait soffice --headless --convert-to pdf --outdir "C:/xampp/htdocs/AIS/assets/Document/Master_list/" "C:/xampp/htdocs/AIS/assets/Document/Master_list/'.$doc.'"';
	    	// exit();
	    	// var_dump(shell_exec('/usr/lib/libreoffice/program/soffice --headless --convert-to pdf --outdir "/var/www/aisin-web/AIS_PP/assets/Document/Master_list/" "/var/www/aisin-web/AIS_PP/assets/Document/Master_list/'.$doc.'" 2>&1'));
	    	// var_dump(shell_exec('cd /usr/lib/libreoffice/program 2>&1'));
	    	// chdir("/usr/lib/libreoffice/program");
	    	// echo getcwd();
	    	// var_dump(shell_exec('soffice --headless --convert-to pdf --outdir "/var/www/aisin-web/AIS_PP/assets/Document/Master_list/" "/var/www/aisin-web/AIS-PP/assets/Document/Master_list/'.$doc.'" 2>&1'));
	    	// shell_exec('soffice --headless --convert-to pdf --outdir "/var/www/aisin-web/AIS_PP/assets/Document/Master_list/" "/var/www/aisin-web/AIS-PP/assets/Document/Master_list/'.$doc.'"')
	    	// var_dump(shell_exec('locate libreoffice 2>&1'));
	    	// var_dump(shell_exec('/usr/share/app-install/desktop/libreoffice --headless --convert-to pdf --outdir "/var/www/aisin-web/AIS_PP/assets/Document/Master_list/" "/var/www/aisin-web/AIS_PP/assets/Document/Master_list/*.docx" 2>&1'));
	    	// var_dump(shell_exec('unoconv -f pdf /var/www/aisin-web/AIS_PP/assets/Document/Master_list/'.$doc.' 2>&1'));
	    	// var_dump(shell_exec("man libreoffice 2>&1"));
	    	// exit();
	    	// var_dump(shell_exec('soffice --help 2>&1'));
	    	// chdir("/var/www/aisin-web/AIS_PP/assets/Document/Master_list");
	    	// echo getcwd();
	    	var_dump(shell_exec('/opt/libreoffice5.4/program/soffice --headless "-env:UserInstallation=file:///tmp/LibreOffice_Conversion_${USER}" --convert-to pdf:writer_pdf_Export --outdir "/var/www/aisin-web/AIS_PP/assets/Document/Master_list/" "/var/www/aisin-web/AIS_PP/assets/Document/Master_list/'.$doc.'" 2>&1'));
	    	// exit();
	    	$filename = explode(".", $doc);
	    	$pat = '';
	    	if(strtoupper($filename[1]) == "DOC" || strtoupper($filename[1]) == "DOCX") {
	    		$pat = APPPATH.'controllers/efila/watermark_word_c.php';	
	    	} else {
	    		$pat = APPPATH.'controllers/efila/watermark_excel_c.php';
	    	}
	    	// $pat = APPPATH.'controllers/efila/watermark_word_c.php';
	    	$pat1 = APPPATH.'controllers/efila/password_pdf_c.php';
	    	// echo APPPATH.'libraries/fpdf/fpdf.php';
	    	// exit();
	    	global $fullPathToFile;
	        // $fullPathToFile = "192.168.0.230/AIS_PP/assets/Document/Master_list/".$filename[0].".pdf";
	        // $fullPathToFile = realpath("/var/www/aisin-web/AIS_PP/assets/Document/Master_list/".$filename[0].".pdf");
			$fullPathToFile = "/var/www/aisin-web/AIS_PP/assets/Document/Master_list/Original_file/".$filename[0].".pdf";
			
			// ---------------------------- DONT DELETE - ORIGINAL PATH BEFORE EDIT----------------------------------------- //
			// $fullPathToFile = "/var/www/aisin-web/AIS_PP/assets/Document/Master_list/".$filename[0].".pdf";
			// ------------------------------------------------------------------------------------------------------------- //

	        echo $fullPathToFile;

	    	$base = $_SERVER['SERVER_NAME'];
        	$url = explode('index',$_SERVER['REQUEST_URI']);

	        // $fullPathToFile = 'http://'.$base.$url[0] . 'assets/Document/Master_list/'.$filename[0].'.pdf';
	        // redirect($fullPathToFile);
	        // echo "Download";
	        // exit();
			global $effective_date;	        		
	        $eff = $this->document_m->get_effective_date($filename[0]);
	        foreach ($eff as $key) {
	        	$tgl = $key->CHR_EFFECTIVE_DATE; 
                $date = date("d-m-Y", strtotime($tgl));
	        	$effective_date = $date;
	        }
	        echo $effective_date;

	        global $rev;
	        $revv = $this->document_m->get_doc_rev($filename[0]);
	        foreach ($revv as $key1) {
	        	$rev = $key1->INT_REVISION;
	        }
	        echo $rev;
	        // exit();
	        global $no_doc;
	        $no_doc = $filename[0];
	    	include($pat);
	    	include($pat1);
	    	
	    }

	    public function export_master_list($iddept=NULL, $idcat=NULL){
			$this->role_module_m->authorization('3');
        
	        $msg = "";
	           
            $this->load->library('excel');

            $objPHPExcel = new PHPExcel();

	        $style = array(
		        'alignment' => array(
		            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
		        )
		    );

		    $head = array(
		        'alignment' => array(
		            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
		        )
		    );

		    $objPHPExcel->getActiveSheet()->mergeCells('A1:H1');
    		$objPHPExcel->getDefaultStyle("A1:H1")->applyFromArray($head);

		    $objPHPExcel->getDefaultStyle()->applyFromArray($style);

			// add some text
			if($iddept == NULL && $idcat == NULL){
            	$view_data = $this->document_m->get_document();
            	$objPHPExcel->getActiveSheet()->setCellValue('A1','Master List Document');
            } elseif ($iddept == "a" && $idcat != NULL) {
            	$view_data = $this->document_m->get_document_by_cat($idcat);
            	$ket = "";
	            foreach ($view_data as $key) {
	            	$ket = $key['CHR_CATEGORY_NAME'];
	            }
	            $objPHPExcel->getActiveSheet()->setCellValue('A1','Master List Document - '.$ket);
            } elseif ($iddept != NULL && $idcat == "a") {
            	$view_data = $this->document_m->get_document_by_dept($iddept);
            	$ket = "";
	            foreach ($view_data as $key) {
	            	$ket = $key['CHR_DEPT'];
	            }
	            $objPHPExcel->getActiveSheet()->setCellValue('A1','Master List Document - '.$ket);
            } else {
            	$view_data = $this->document_m->get_document_by_catdept($idcat, $iddept);
            	$ket = "";
            	$ket1 = "";
	            foreach ($view_data as $key) {
	            	$ket = $key['CHR_CATEGORY_NAME'];
	            	$ket1 = $key['CHR_DEPT'];
	            }
	            $objPHPExcel->getActiveSheet()->setCellValue('A1','Master List Document - '.$ket.' - '.$ket1);
            }

            $objPHPExcel->getActiveSheet()->mergeCells('A2:H2');
    		$objPHPExcel->getDefaultStyle("A2:H2")->applyFromArray($head);
    		$objPHPExcel->getDefaultStyle()->applyFromArray($style);
    		$objPHPExcel->getActiveSheet()->setCellValue('A2','Form No : FRM-xxxxxxxxxxxxxx');

    		// $style1 = array(
		    //     'alignment' => array(
		    //         'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
		    //         'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
		    //     )
		    // );

    		$objPHPExcel->getActiveSheet()->mergeCells('A3:H3');
    		$objPHPExcel->getDefaultStyle("A3:I3")->applyFromArray($head);
    		$objPHPExcel->getDefaultStyle()->applyFromArray($style);
    		$objPHPExcel->getActiveSheet()->setCellValue('A3','EFILA Print Out : '.date('d/m/Y - H:i:s'));

    		// $objPHPExcel->getActiveSheet()->setCellValue('H3','EFILA Print Out');
    		// $objPHPExcel->getActiveSheet()->setCellValue('I3',date('d/m/Y'));
	        
	        //SETUP EXCEL
	        $width = 10;
	        $objPHPExcel->setActiveSheetIndex(0);
	        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
	        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
	        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
	        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(10);
	        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
	        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(10);
	        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
	        // $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
	        $objPHPExcel->getActiveSheet()->getStyle('A3:H999')->getAlignment()->setWrapText(true);

	        $objPHPExcel->getActiveSheet()->setCellValue('A4', 'No.');
	        $objPHPExcel->getActiveSheet()->setCellValue('B4', 'Dept');
	        $objPHPExcel->getActiveSheet()->setCellValue('C4', 'No Doc');
	        $objPHPExcel->getActiveSheet()->setCellValue('D4', 'Doc Name');
	        $objPHPExcel->getActiveSheet()->setCellValue('E4', 'Doc Category');
	        $objPHPExcel->getActiveSheet()->setCellValue('F4', 'Revision');
	        $objPHPExcel->getActiveSheet()->setCellValue('G4', 'PIC');
	        $objPHPExcel->getActiveSheet()->setCellValue('H4', 'Effective Date');
	        // $objPHPExcel->getActiveSheet()->setCellValue('I4', 'Document');

            $i = 5;
            $no = 1;
            

            foreach($view_data as $data){
            	$tgl = $data['CHR_EFFECTIVE_DATE']; 
                $date = date("d-m-Y", strtotime($tgl));
                $objPHPExcel->getActiveSheet()->setCellValue("A$i", $no);
                $objPHPExcel->getActiveSheet()->setCellValue("B$i", $data['CHR_DEPT']);
                $objPHPExcel->getActiveSheet()->setCellValue("C$i", $data['CHR_NO_DOC']);                
                $objPHPExcel->getActiveSheet()->setCellValue("D$i", $data['CHR_DOCUMENT_NAME']);
                $objPHPExcel->getActiveSheet()->setCellValue("E$i", $data['CHR_CATEGORY_NAME']);
                $objPHPExcel->getActiveSheet()->setCellValue("F$i", $data['INT_REVISION']);              
                $objPHPExcel->getActiveSheet()->setCellValue("G$i", $data['CHR_PIC']);
                $objPHPExcel->getActiveSheet()->setCellValue("H$i", $date);
                // $objPHPExcel->getActiveSheet()->setCellValue("I$i", $data['CHR_DOC']);

                $i++;
                $no++;
            }

            $i = $i - 1;
	        $objPHPExcel->getActiveSheet()->getStyle("A3:H$i")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
	        $objPHPExcel->getActiveSheet()->getStyle("A4:H4")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('CCFFFF');

            $filename = 'Master List - '.date("Y/m/d") . ".xlsx";
	        ob_end_clean();
	        header('Content-Type: application/vnd.ms-excel');
	        header('Content-Disposition: attachment;filename="' . trim($filename) . '"');
	        header('Cache-Control: max-age=0');

	        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	        $objWriter->save('php://output');

            
            $msg = "<div class = 'alert alert-success'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Downloading success </strong> The data is successfully created </div >";
	        
	    }
	}
?>