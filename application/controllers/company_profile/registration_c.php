<?php
	/**
	* 
	*/
	class registration_c extends CI_Controller
	{
		
		private $layout = '/template/head';
	    private $back_to_manage = 'company_profile/registration_c/index/';
	    private $suc = 0;

	    public function __construct() {
	        parent::__construct();
	        $this->load->model('company_profile/registration_m');
	        $this->load->helper('email');
	        // $this->load->model('asset/registration_m');
	        require  DOCROOT.'/application/third_party/phpmailer/PHPMailerAutoload.php';
			require  DOCROOT.'/application/third_party/phpmailer/class.phpmailer.php'; 
			
			// echo !extension_loaded('openssl')?"Not Available":"Available";
			
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
	        } elseif ($msg == 15) {
	        	$msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Send Email success </strong> Email has been sent </div >";
	        }
	        $data['msg'] = $msg;
	        $data['data'] = $this->registration_m->get_registration();
	        $data['content'] = 'company_profile/registration/manage_registration_v';
	        $data['title'] = 'Manage  Registration';
	        $data['news'] = $this->news_m->get_news();
	        $data['app'] = $this->role_module_m->get_app();
	        $data['module'] = $this->role_module_m->get_module();
	        $data['function'] = $this->role_module_m->get_function();
	        $data['sidebar'] = $this->role_module_m->side_bar(169);

	        $this->load->view($this->layout, $data);
	    }

	    public function exportExcel(){
	    	$this->role_module_m->authorization('3');
        
	        $msg = "";
	           
            $this->load->library('excel');

            if($this->input->post('CHR_DATE_START') && $this->input->post('CHR_DATE_END')){
            	$str = $this->input->post('CHR_DATE_START');
            	$nd = $this->input->post('CHR_DATE_END');
            	
            	$datestr = date_create($str);
            	$datend = date_create($nd);

            	$start = date_format($datestr,"Ymd");
            	$end = date_format($datend,"Ymd");
            	
            	$view_data = $this->registration_m->get_registration_bydate($start,$end);
            } else {
            	$view_data = $this->registration_m->get_registration();
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
	        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
	        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
	        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
	        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth($width);
	        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth($width);
	        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
	        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
	        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth($width);
	        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth($width);
	        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(20);
	        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(20);
	        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(30);
	        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(30);
	        $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(30);
	        $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(30);
	        $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(30);
	        $objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(30);
	        $objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(30);
	        $objPHPExcel->getActiveSheet()->getColumnDimension('T')->setWidth(30);
	        $objPHPExcel->getActiveSheet()->getColumnDimension('U')->setWidth($width);
	        $objPHPExcel->getActiveSheet()->getStyle('N1:U999')->getAlignment()->setWrapText(true);

	        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'No.');
	        $objPHPExcel->getActiveSheet()->setCellValue('B1', 'Name');
	        $objPHPExcel->getActiveSheet()->setCellValue('C1', 'Place of Birth');
	        $objPHPExcel->getActiveSheet()->setCellValue('D1', 'Date of Birth');
	        $objPHPExcel->getActiveSheet()->setCellValue('E1', 'Height');
	        $objPHPExcel->getActiveSheet()->setCellValue('F1', 'Weight');
	        $objPHPExcel->getActiveSheet()->setCellValue('G1', 'Blood Type');
	        $objPHPExcel->getActiveSheet()->setCellValue('H1', 'Sex');
	        $objPHPExcel->getActiveSheet()->setCellValue('I1', 'Religion');
	        $objPHPExcel->getActiveSheet()->setCellValue('J1', 'Nation');
	        $objPHPExcel->getActiveSheet()->setCellValue('K1', 'KTP');
	        $objPHPExcel->getActiveSheet()->setCellValue('L1', 'KK');
	        $objPHPExcel->getActiveSheet()->setCellValue('M1', 'Email');
	        $objPHPExcel->getActiveSheet()->setCellValue('N1', 'Address KTP');
	        $objPHPExcel->getActiveSheet()->setCellValue('O1', 'Address Region');
	        $objPHPExcel->getActiveSheet()->setCellValue('P1', 'Phone');
	        $objPHPExcel->getActiveSheet()->setCellValue('Q1', 'Final Academic Background');
	        $objPHPExcel->getActiveSheet()->setCellValue('R1', 'University');
	        $objPHPExcel->getActiveSheet()->setCellValue('S1', 'Faculty');
	        $objPHPExcel->getActiveSheet()->setCellValue('T1', 'Departement');
	        $objPHPExcel->getActiveSheet()->setCellValue('U1', 'IPK');

            $i = 2;
            $no = 1;

            foreach($view_data as $data){
            	$tgl = $data->CHR_DATE; 
                $date = date("Y-m-d", strtotime($tgl));
                $objPHPExcel->getActiveSheet()->setCellValue("A$i", $no);
                $objPHPExcel->getActiveSheet()->setCellValue("B$i", $data->CHR_NAME);
                $objPHPExcel->getActiveSheet()->setCellValue("C$i", $data->CHR_PLACE);                
                $objPHPExcel->getActiveSheet()->setCellValue("D$i", $date);
                $objPHPExcel->getActiveSheet()->setCellValue("E$i", $data->DEC_HEIGHT. " cm");
                $objPHPExcel->getActiveSheet()->setCellValue("F$i", $data->DEC_WEIGHT. " kg");              
                $objPHPExcel->getActiveSheet()->setCellValue("G$i", $data->CHR_BLOOD_TYPE);
                $objPHPExcel->getActiveSheet()->setCellValue("H$i", $data->CHR_SEX);
                $objPHPExcel->getActiveSheet()->setCellValue("I$i", $data->CHR_RELIGION);
                $objPHPExcel->getActiveSheet()->setCellValue("J$i", strtoupper($data->CHR_NATION));
                $objPHPExcel->getActiveSheet()->setCellValueExplicit("K$i", $data->CHR_KTP, PHPExcel_Cell_DataType::TYPE_STRING);
                $objPHPExcel->getActiveSheet()->setCellValueExplicit("L$i", $data->CHR_KK, PHPExcel_Cell_DataType::TYPE_STRING);
                $objPHPExcel->getActiveSheet()->setCellValue("M$i", $data->CHR_EMAIL);
                $objPHPExcel->getActiveSheet()->setCellValue("N$i", $data->CHR_ADDRESS_KTP);
                $objPHPExcel->getActiveSheet()->setCellValue("O$i", $data->CHR_ADDRESS_REGION);               
                $objPHPExcel->getActiveSheet()->setCellValueExplicit("P$i", $data->CHR_PHONE, PHPExcel_Cell_DataType::TYPE_STRING);
                $objPHPExcel->getActiveSheet()->setCellValue("Q$i", $data->CHR_FINAL_ACADEMIC);
                $objPHPExcel->getActiveSheet()->setCellValue("R$i", $data->CHR_UNIVERSITY);
                $objPHPExcel->getActiveSheet()->setCellValue("S$i", $data->CHR_FACULTY);
                $objPHPExcel->getActiveSheet()->setCellValue("T$i", $data->CHR_DEPARTEMENT);
                $objPHPExcel->getActiveSheet()->setCellValue("U$i", $data->DEC_IPK);

                $i++;
                $no++;
            }

            $i = $i - 1;
	        $objPHPExcel->getActiveSheet()->getStyle("A1:U$i")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
	        $objPHPExcel->getActiveSheet()->getStyle("A1:U1")->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('CCFFFF');

            $filename = 'Report Data Registration - '.date("Y/m/d") . ".xlt";
	        ob_end_clean();
	        header('Content-Type: application/vnd.ms-excel');
	        header('Content-Disposition: attachment;filename="' . trim($filename) . '"');
	        header('Cache-Control: max-age=0');

	        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	        $objWriter->save('php://output');

            
            $msg = "<div class = 'alert alert-success'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Downloading success </strong> The data is successfully created </div >";

	        
	    }

	    function sendmail($id, $tahap) {
	    	//Load library email
	    	//$this->load->library('email');

	    	//get data
	    	$data = $this->registration_m->get_email($id);
	    	foreach ($data as $isi) {
	    		$email = $isi->CHR_EMAIL;
	    		$vacancy = $isi->CHR_VACANCY_NAME;
	    		$nama = $isi->CHR_NAME;
	    		break;
	    	}
			                              // Enable verbose debug output
			$mail = new PHPMailer();
			$mail->isSMTP(true);
			$mail->SMTPDebug = 2; 
			//Ask for HTML-friendly debug output
			$mail->SMTPSecure = 'tls';
			//$mail->Host = 'smtp.gmail.com';
			$mail->Port = 587;
			//or more succinctly:
			$mail->Host = 'tls://smtp.gmail.com:587';
			$mail->Debugoutput = 'html';
			$mail->SMTPOptions = array(
			    'ssl' => array(
			        'verify_peer' => false,
			        'verify_peer_name' => false,
			        'allow_self_signed' => true
			    )
			);
			//$mail->Host = 'smtp.gmail.com';    
			//$mail->Port = 465;        
			//$mail->SMTPSecure = 'ssl';           
			$mail->SMTPAuth = true;  
			$mail->Username = 'lutfy.firmansyah@gmail.com';
			$mail->Password = 'uvi270412';
			$mail->isHTML(true);
			//$mail->Sendmail = '/usr/sbin/sendmail';
			$mail->setFrom('lutfy.firmansyah@gmail.com','M Lutfy Firmansyah');
			$mail->addAddress($email,'Applicant');     // Add a recipient
			$mail->addReplyTo('lutfy.firmansyah@gmail.com');

			// $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
			// $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

			//$mail->msgHTML(file_get_contents('contents.html'), dirname(__FILE__));
			$mail->Subject = 'Notification';
			if($tahap == 1){
				$mail->Body    = '
				<center><h1>Congratulation!</h1></center><br>
				<table border="1"  width="100%"" cellspacing="0" cellpadding="5">			
						<tr>
							<th>Name</th>
							<th>Position</th>
							<th>Step</th>
						</tr>
						<tr>
							<td>'.$nama.'</td>
							<td>'.$vacancy.'</td>
							<td>Administration</td>
						</tr>

				</table>
				<br/>
				';
			} elseif($tahap == 2){
				$mail->Body    = '
				<center><h1>Congratulation!</h1></center><br>
				<table border="1"  width="100%"" cellspacing="0" cellpadding="5">			
						<tr>
							<th>Name</th>
							<th>Position</th>
							<th>Step</th>
						</tr>
						<tr>
							<td>'.$nama.'</td>
							<td>'.$vacancy.'</td>
							<td>Psikotes</td>
						</tr>

				</table>
				<br/>
				';
			} elseif($tahap == 3){	
				$mail->Body    = '
				<center><h1>Congratulation!</h1></center><br>
				<table border="1"  width="100%"" cellspacing="0" cellpadding="5">			
						<tr>
							<th>Name</th>
							<th>Position</th>
							<th>Step</th>
						</tr>
						<tr>
							<td>'.$nama.'</td>
							<td>'.$vacancy.'</td>
							<td>Interview</td>
						</tr>

				</table>
				<br/>
				';
			} elseif($tahap == 4){
				$mail->Body    = '
				<center><h1>Congratulation!</h1></center><br>
				<table border="1"  width="100%"" cellspacing="0" cellpadding="5">			
						<tr>
							<th>Name</th>
							<th>Position</th>
							<th>Step</th>
						</tr>
						<tr>
							<td>'.$nama.'</td>
							<td>'.$vacancy.'</td>
							<td>Medical Check Up</td>
						</tr>

				</table>
				<br/>
				';
			} elseif($tahap == 5){
				$mail->Body    = '
				<center><h1>Congratulation!</h1></center><br>
				<table border="1"  width="100%"" cellspacing="0" cellpadding="5">			
						<tr>
							<th>Name</th>
							<th>Position</th>
							<th>Step</th>
						</tr>
						<tr>
							<td>'.$nama.'</td>
							<td>'.$vacancy.'</td>
							<td>Accepted</td>
						</tr>

				</table>
				<br/>
				';
			} elseif($tahap == 0) {
				$mail->Body    = '
				<center><h1>Notification</h1></center><br>
				<center>Sorry, You are not accepted as a part of PT Aisin Indonesia</center>
				<br/>
				';
			}
			
			$mail->AltBody = '';
			$mail->XMailer = ' ';
			if(!$mail->send()) {
			    echo 'Message could not be sent.';
			    $this->suc = 1;
			    // echo 'Mailer Error: ' . $mail->ErrorInfo;
			} else {
			    echo 'Message has been sent';
			    if($this->suc == 1){
			    	redirect($this->back_to_manage . $msg = 2);
			    }
			}
	    }

	    function accept($id, $tahap){
	    	$this->role_module_m->authorization('3');
	        $this->registration_m->accept($id, $tahap);
	        $this->sendmail($id, $tahap);
	        redirect($this->back_to_manage . $msg = 2);
	    }

	    function reject_accept_mail(){
	    	$this->role_module_m->authorization('3');
	    	if($this->input->post('accept')){
	    		foreach ($_POST['check_list'] as $id) {
		    		$data['step'] = $this->registration_m->get_data_registration($id);
		    		foreach ($data['step'] as $isi) {
		    			$tahap = $isi->INT_STATUS;
		    			break;
		    		}
		    		$this->sendmail($id, $tahap);
		    		$this->registration_m->accept($id, $tahap);
		    	}
	    	}
	    	elseif($this->input->post('reject')){
	    		foreach ($_POST['check_list'] as $id) {
		    		$data['step'] = $this->registration_m->get_data_registration($id);
		    		$tahap = 0;
		    		$this->sendmail($id, $tahap);
		    		$this->registration_m->reject($id);
		    	}
	    	}
	        redirect($this->back_to_manage . $msg = 2);
	    }

	    function reject($id){
	    	$this->role_module_m->authorization('3');
	        $this->registration_m->reject($id);
	        redirect($this->back_to_manage . $msg = 3);
	    }

	}
?>