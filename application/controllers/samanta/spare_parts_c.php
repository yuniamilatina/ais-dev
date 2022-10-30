<?php

class spare_parts_c extends CI_Controller
{

    private $layout = '/template/head';
    private $back_to_manage = 'samanta/spare_parts_c/index/';
    private $back_to_create_view = 'samanta/spare_parts_c/create_sp/';
    private $list_order_confirmation = 'samanta/spare_parts_c/list_order_confirmation/';
    private $layout_blank = '/template/head_blank';

    /* -- define constructor -- */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('organization/dept_m');
        $this->load->model('samanta/spare_parts_m');
        $this->load->config('pdf_config');
        $this->load->library('fpdf/fpdf');
        define('FPDF_FONTPATH', $this->config->item('fonts_path'));
    }

    public function index($area = NULL, $msg = NULL)
    {
        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Creating success </strong> The data is successfully created </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Updating success </strong> The data is successfully updated </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Deleted success </strong> The data is successfully deleted </div >";
        } elseif ($msg == 4) {
            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button>Anda belum memilih file untuk diupload</div >";
        } elseif ($msg == 6) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Upload data success </strong> The data is successfully uploaded </div >";
        } elseif ($msg == 7) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Tidak ada data yang diupload </strong>, periksa kembali template upload anda </div >";
        } elseif ($msg == 8) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Order list data success uploaded </strong>, The data is successfully saved</div >";
        } elseif ($msg == 9) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Generate stock opname data success </strong>, The data is successfully generated</div >";
        } elseif ($msg == 12) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Image file</strong>, Image data not found</div >";
        } elseif ($msg == 13) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Executing error !</strong> Cannot using dot(.) in name of file</div >";
        }

        $data['msg'] = $msg;
        $data['title'] = 'Master Data Spare Parts';
        $data['news'] = $this->news_m->get_news();
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(210);

        if ($area == NULL) {
            $area = 'EN02';
        }

        $user_session = $this->session->all_userdata();
        $npk = $user_session['NPK'];
        $data['area'] = $area;
        $data['all_area'] = $this->spare_parts_m->get_data_area();
        $data['data'] = $this->spare_parts_m->get_data_all_spare_parts_by_area($data['area']);
        $data['data_order'] = $this->spare_parts_m->getSummaryOrder($npk);
        $data['content'] = 'samanta/spare_parts_v';

        $this->load->view($this->layout, $data);
    }

    function refresh_table()
    {
        $INT_ID_OPT_WCENTER = $this->input->post("INT_ID_OPT_WCENTER");
        $FILTER = $this->input->post("FILTER");

        $url_iframe = site_url("samanta/spare_parts_c/refresh_table_page/$INT_ID_OPT_WCENTER/$FILTER");


        $data = array(
            'url_iframe' => $url_iframe
        );

        //====== Either you can print value or you can send value to database
        echo json_encode($data);
    }

    function refresh_table_page($INT_ID_OPT_WCENTER = null, $FILTER = null, $msg = null)
    {
        $this->role_module_m->authorization('3');
        $user_session = $this->session->all_userdata();

        $data['INT_ID_OPT_WCENTER'] = $INT_ID_OPT_WCENTER;
        $data['FILTER'] = $FILTER;

        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Creating success </strong> The data is successfully created </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Updating success </strong> The data is successfully updated </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Deleted success </strong> The data is successfully deleted </div >";
        } elseif ($msg == 4) {
            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button>Anda belum memilih file untuk diupload</div >";
        } elseif ($msg == 6) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Upload data success </strong> The data is successfully uploaded </div >";
        }
        $data['msg'] = $msg;

        $get_data_area = $this->spare_parts_m->get_data_area();
        $data['all_area'] = $get_data_area;
        $data['title'] = 'Maintenance Spare Parts';
        $data['news'] = $this->news_m->get_news();
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(210);
        $data['selected_area'] = $INT_ID_OPT_WCENTER;
        if ($INT_ID_OPT_WCENTER == 'ALL') {
            $data['data'] = $this->spare_parts_m->get_data_all_spare_parts($FILTER);
            $data['content'] = 'samanta/refresh_spare_parts_v';
            $this->load->view($this->layout_blank, $data);
        } else {
            $data['data'] = $this->spare_parts_m->get_data_all_spare_parts_per_area($INT_ID_OPT_WCENTER, $FILTER);
            $pic = $this->session->userdata('NPK');
            if ($pic == '0000') {
                $data['content'] = 'samanta/refresh_spare_parts_v';
            } else {
                $data['content'] = 'samanta/refresh_spare_parts_v';
            }
            $this->load->view($this->layout_blank, $data);
        }

        // if($REPORT_TYPE == 'FOH'){
        //     $data['content'] = 'budget/report_budget/refresh_report_profit_and_loss_v';
        // } else {
        //     $data['content'] = 'budget/report_budget/refresh_report_profit_and_loss_a3_v';
        // }


        //$this->load->view($this->layout_blank, $data);
    }

    function search_area($area, $msg = NULL)
    {
        $this->role_module_m->authorization('3');
        $user_session = $this->session->all_userdata();

        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Creating success </strong> The data is successfully created </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Updating success </strong> The data is successfully updated </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Deleted success </strong> The data is successfully deleted </div >";
        } elseif ($msg == 4) {
            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button>Anda belum memilih file untuk diupload</div >";
        } elseif ($msg == 6) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Upload data success </strong> The data is successfully uploaded </div >";
        }
        $data['msg'] = $msg;

        $get_data_area = $this->spare_parts_m->get_data_area();

        $data['selected_area'] = $area;
        if ($area == 'ALL') {
            redirect($this->back_to_manage);
        } else {
            $pic = $this->session->userdata('NPK');
            if ($pic == '0000') {
                $data['content'] = 'samanta/spare_parts_v_user';
            } else {
                $data['content'] = 'samanta/spare_parts_v';
            }
            $data['data'] = $this->spare_parts_m->get_data_all_spare_parts_per_area($area);
            $data['all_area'] = $get_data_area;
            $data['title'] = 'Maintenance Spare Parts';
            $data['news'] = $this->news_m->get_news();
            $data['app'] = $this->role_module_m->get_app();
            $data['module'] = $this->role_module_m->get_module();
            $data['function'] = $this->role_module_m->get_function();
            $data['sidebar'] = $this->role_module_m->side_bar(210);

            $this->load->view($this->layout, $data);
        }
    }

    function view_detail_spare_parts()
    {
        $part_no = $this->input->post("part_no");
        //echo $part_no;
        $data_detail = $this->spare_parts_m->get_data_alamat_spare_parts($part_no);
        $data = "";
        $i = 1;
        foreach ($data_detail as $dataTable) {
            $data .= "<tr class='gradeX' style='font-size:20'>";
            $data .= "<td style='vertical-align: middle;text-align:center'>$i</td>";
            $data .= "<td style='vertical-align: middle;text-align:center'>" . $dataTable->CHR_BACK_NO . "</td>";
            $data .= "<td style='vertical-align: middle;text-align:center'><strong>" . $dataTable->CHR_RACK_NO . "</strong></td>";
            $data .= "</tr>";

            $i++;
        }
        echo $data;
    }

    function create_sp($msg = NULL)
    {
        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Creating success </strong> The data is successfully created </div>";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Updating success </strong> The data is successfully updated </div>";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Deleted success </strong> The data is successfully deleted </div>";
        } elseif ($msg == 4) {
            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button>Anda belum memilih file untuk diupload</div>";
        } elseif ($msg == 5) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button>Maaf data yang Anda masukan salah, pastikan Anda menggunakan template dari sistem</div>";
        } elseif ($msg == 6) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button>Spare Part No yang Anda telah digunakan, silahkan input Spare Parts No yang lain</div>";
        }

        $data['msg'] = $msg;
        $data['content'] = 'samanta/create_spare_parts_v';
        $data['title'] = 'New Spare Part';
        $data['news'] = $this->news_m->get_news();
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(210);

        $this->load->view($this->layout, $data);
    }

    function upload_sto()
    {
        $data['content'] = 'samanta/upload_sto_v';
        $data['title'] = 'Update Quantity Spare Part';
        $data['news'] = $this->news_m->get_news();
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(210);

        $this->load->view($this->layout, $data);
    }

    function save_spare_parts()
    {
        $datenow = date('Ymd');
        $timenow = date('His');
        $session = $this->session->all_userdata();
        $pic = $this->session->userdata('NPK');
        $part_no = trim(strtoupper($this->input->post('CHR_PART_NO')));
        $rack_no = trim(strtoupper($this->input->post('CHR_RACK_NO')));
        $back_no = trim(strtoupper($this->input->post('CHR_BACK_NO')));

        $get_master_data = $this->spare_parts_m->get_master_data($part_no);
        if ($get_master_data->num_rows() > 0) {
            redirect($this->back_to_create_view . $msg = 6);
        } else {
            $this->form_validation->set_rules('CHR_PART_NO', 'Spare Part Number', 'required');
            if ($this->form_validation->run() == FALSE) {
                $this->create_sp();
            } else {
                $data = array(
                    'CHR_PART_NO' => $part_no,
                    'CHR_SPARE_PART_NAME' => trim(strtoupper($this->input->post('CHR_SPARE_PART_NAME'))),
                    'CHR_COMPONENT' => $this->input->post('CHR_COMPONENT'),
                    'CHR_MODEL' => trim(strtoupper($this->input->post('CHR_MODEL'))),
                    'CHR_BACK_NO' => $back_no,
                    'CHR_TYPE' => $this->input->post('CHR_TYPE'),
                    'CHR_SPECIFICATION' => trim(strtoupper($this->input->post('CHR_SPECIFICATION'))),
                    'INT_QTY_USE' => $this->input->post('INT_QTY_USE'),
                    'INT_QTY_MIN' => $this->input->post('INT_QTY_MIN'),
                    'INT_QTY_MAX' => $this->input->post('INT_QTY_MAX'),
                    'CHR_PRICE' => $this->input->post('CHR_PRICE'),
                    'CHR_FLAG_DELETE' => 'F',
                    'CHR_CREATED_BY' => $pic,
                    'CHR_CREATED_DATE' => $datenow,
                    'CHR_CREATED_TIME' => $timenow
                );
                $this->spare_parts_m->save_data_sp($data);

                $data_part_sloc = array(
                    'CHR_PART_NO' => $part_no,
                    'CHR_SLOC' => $this->input->post('CHR_SLOC'),
                    'INT_QTY' => '0',
                    'CHR_ENTRIED_BY' => $pic,
                    'CHR_ENTRIED_DATE' => $datenow,
                    'CHR_ENTRIED_TIME' => $timenow
                );
                $this->spare_parts_m->save_data_sloc($data_part_sloc);

                $data_part_routing = array(
                    'CHR_PART_NO' => $part_no,
                    'CHR_BACK_NO' => $back_no,
                    'CHR_RACK_NO' => $rack_no,
                    'CHR_CREATED_BY' => $pic,
                    'CHR_CREATED_DATE' => $datenow,
                    'CHR_CREATED_TIME' => $timenow
                );
                $this->spare_parts_m->save_data_routing($data_part_routing);

                //--------------------------------------------------------------------//
                //make label barcode
                $this->load->library('ciqrcode');
                $params['data'] = "$part_no";
                $params['level'] = 'B';
                $params['size'] = 2;
                $params['savename'] = 'assets/qrcode_spare_parts/' . $part_no . '.png';
                $this->ciqrcode->generate($params);

                redirect($this->back_to_manage . $msg = 1);
            }
        }
    }

    function goto_edit_sp($id)
    {
        $data['data'] = $this->spare_parts_m->get_data_sp($id)->row();
        $data['content'] = 'samanta/edit_spare_parts_v';
        $data['title'] = 'Edit Spare Part Data';
        $data['news'] = $this->news_m->get_news();
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(210);

        $this->load->view($this->layout, $data);
    }

    function update_sp()
    {
        $this->load->library('upload');

        $datenow = date('Ymd');
        $timenow = date('His');
        $session = $this->session->all_userdata();
        $pic = $this->session->userdata('NPK');
        $id = $this->input->post('INT_ID');
        $part_no = $this->input->post('CHR_PART_NO');

        $array_file = explode(".", $_FILES['CHR_FILENAME']['name']);
        if (count($array_file) > 2) {
            redirect($this->back_to_manage . $msg = 13);
        }

        $fileName = time() . str_replace(' ', '-', $_FILES['CHR_FILENAME']['name']);
        if (empty($fileName)) {
            redirect($this->back_to_manage . $msg = 12);
        }

        $config = array(
            'upload_path' => 'assets/img/tools/',
            'allowed_types' => "JPG|jpg|png|jpeg",
            'max_size' => "2048000",
            'file_name' =>  $fileName
        );

        $this->upload->initialize($config);
        if ($a = $this->upload->do_upload('CHR_FILENAME'))
            $this->upload->display_errors();
        $media = $this->upload->data('CHR_FILENAME');

        // $this->form_validation->set_rules('INT_QTY_USE', 'Used Quantity', 'required');
        // $this->form_validation->set_rules('INT_QTY_MIN', 'Minimum Quantity', 'required');
        // $this->form_validation->set_rules('INT_QTY_MAX', 'Maximum Quantity', 'required');

        // if ($this->form_validation->run() == FALSE) {
        //     $this->goto_edit_sp($id);
        // } else {
        $data = array(
            'CHR_SPARE_PART_NAME' => $this->input->post('CHR_SPARE_PART_NAME'),
            'CHR_MODEL' => $this->input->post('CHR_MODEL'),
            'CHR_BACK_NO' => $this->input->post('CHR_BACK_NO'),
            'CHR_SPECIFICATION' => $this->input->post('CHR_SPECIFICATION'),
            'INT_QTY_USE' => $this->input->post('INT_QTY_USE'),
            'INT_QTY_MIN' => $this->input->post('INT_QTY_MIN'),
            'INT_QTY_MAX' => $this->input->post('INT_QTY_MAX'),
            'CHR_PRICE' => $this->input->post('CHR_PRICE'),
            'CHR_FILENAME' => $fileName,
            'CHR_MODIFIED_BY' => $pic,
            'CHR_MODIFIED_DATE' => $datenow,
            'CHR_MODIFIED_TIME' => $timenow
        );
        $this->spare_parts_m->update_sp($data, $id);

        redirect($this->back_to_manage . $msg = 2);
        // }
    }

    function delete_sp($id)
    {
        $this->spare_parts_m->delete_sp($id);
        redirect($this->back_to_manage . $msg = 3);
    }

    function generate_template()
    {
        $this->load->library('excel');
        $this->load->helper('download');

        ob_clean();
        $file_name = 'Upload Spare Parts.xlsx';
        $file = file_get_contents('./assets/file/spare_parts/Upload Spare Parts.xlsx');

        force_download($file_name, $file);
    }

    function generate_template_sto()
    {
        $this->load->library('excel');
        $this->load->helper('download');

        ob_clean();
        $file_name = 'Upload Stock Opname.xlsx';
        $file = file_get_contents('./assets/file/spare_parts/Upload Stock Opname.xlsx');

        force_download($file_name, $file);
    }

    // ===========================================================================================
    // proses improvement kembali terkait upload hasil sto untuk update qty_act
    // ===========================================================================================
    function upload_data_sto()
    {
        $this->load->library(array('PHPExcel', 'PHPExcel/IOFactory'));

        $pic = $this->session->userdata('NPK');
        $date_now = date("Ymd");
        $time_now = date("His");

        if ($this->input->post("upload_sto_button") == 1) {
            $fileName = $_FILES['import_data']['name'];
            if (empty($fileName)) {
                redirect($this->back_to_create_view . $msg = 4);
            }
            //file untuk submit file excel
            $config['upload_path'] = './assets/file/spare_parts/';
            $config['file_name'] = $fileName;
            $config['allowed_types'] = 'xlsx';
            $config['max_size'] = 3000;
            $config['encrypt_name'] = FALSE;
            $config['remove_spaces'] = TRUE;

            //code for upload with ci
            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('import_data')) {
                echo $this->upload->display_errors();
                exit();
            }

            $media = $this->upload->data('import_data');
            $inputFileName = './assets/file/spare_parts/' . $media['file_name'];

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
            if ($rowHeader[0][0] == "UPLOAD DATA QTY SPARE PARTS") {
                for ($row = 4; $row <= $highestRow; $row++) {

                    $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);

                    $part_no = $rowData[0][1];
                    $sloc = $rowData[0][2];
                    $qty_act = $rowData[0][3];

                    // Direct upload to table sloc
                    $this->db->query("UPDATE TT_SPARE_PARTS_SLOC SET 
                                                INT_QTY = '$qty_act',
                                                WHERE CHR_PART_NO = '$part_no' AND CHR_SLOC = '$sloc'");
                }
                redirect($this->back_to_manage . $msg = 2);
            } else {
                redirect($this->back_to_manage . $msg = 7);
            }
        }
    }
    // ===========================================================================================
    // ===========================================================================================

    function upload_data_sp()
    {
        $this->load->library(array('PHPExcel', 'PHPExcel/IOFactory'));
        $db_samanta = $this->load->database("samanta", TRUE);
        $pic = $this->session->userdata('NPK');
        $date_now = date("Ymd");
        $time_now = date("His");

        if ($this->input->post("upload_button") == 1) {
            $fileName = $_FILES['import_data']['name'];
            if (empty($fileName)) {
                redirect($this->back_to_create_view . $msg = 4);
            }
            //file untuk submit file excel
            $config['upload_path'] = './assets/file/spare_parts/';
            $config['file_name'] = $fileName;
            $config['allowed_types'] = 'xlsx';
            $config['max_size'] = 3000;
            $config['encrypt_name'] = FALSE;
            $config['remove_spaces'] = TRUE;

            //code for upload with ci
            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('import_data')) {
                echo $this->upload->display_errors();
                exit();
            }

            $media = $this->upload->data('import_data');
            $inputFileName = './assets/file/spare_parts/' . $media['file_name'];

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
            if ($rowHeader[0][0] == "UPLOAD DATA SPARE PARTS") {
                for ($row = 4; $row <= $highestRow; $row++) {

                    $error_msg = "";
                    $error_stat = 0;
                    $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);

                    $part_no = $rowData[0][1];
                    $rack_no = $rowData[0][2];
                    $part_name = $rowData[0][3];
                    $component = $rowData[0][4];
                    $model = $rowData[0][5];
                    $back_no = $rowData[0][6];
                    $type = $rowData[0][7];
                    $spec = $rowData[0][8];
                    $price = $rowData[0][9];
                    $qty_use = $rowData[0][10];
                    $qty_min = $rowData[0][11];
                    $qty_max = $rowData[0][12];
                    $qty_act = $rowData[0][13];
                    $sloc = $rowData[0][14];

                    // Check karakter $component
                    if (strlen($component) > 3) {
                        $error_stat = 1;
                        $error_msg = "Component hanya boleh maximal 3 karakter ";
                    }

                    // Check karakter $type
                    if (strlen($type) > 1) {
                        $error_stat = 1;
                        $error_msg = "Part type hanya boleh 1 karakter ";
                    }

                    // Check qty_use
                    if (!is_numeric($price)) {
                        $error_stat = 1;
                        $error_msg = " Pastikan tipe data Price/Harga adalah Angka (Number) ";
                    }

                    // Check qty_use
                    if (!is_numeric($qty_use)) {
                        $error_stat = 1;
                        $error_msg = " Pastikan tipe data Qty Use adalah Angka (Number) ";
                    }

                    // Check qty_min
                    if (!is_numeric($qty_min)) {
                        $error_stat = 1;
                        $error_msg = " Pastikan tipe data Qty Minimum adalah Angka (Number) ";
                    }

                    // Check qty_max
                    if (!is_numeric($qty_max)) {
                        $error_stat = 1;
                        $error_msg = " Pastikan tipe data Qty Maximum adalah Angka (Number) ";
                    }

                    // Check kondisi part no sudah ada atau belum
                    $check_pn = $db_samanta->query("SELECT CHR_PART_NO FROM TM_SPARE_PARTS WHERE CHR_PART_NO = '$part_no'")->num_rows();
                    if ($check_pn > 0) {
                        $error_stat = 1;
                        $error_msg = "Unique Number/Spare part number telah ada di master data ";
                    }

                    // Insert to table tw                   
                    $db_samanta->query("INSERT INTO TW_SPARE_PARTS (CHR_PART_NO, CHR_RACK_NO, CHR_SPARE_PART_NAME, CHR_COMPONENT, CHR_MODEL, CHR_BACK_NO, CHR_TYPE, 
                            CHR_SPECIFICATION, INT_QTY_USE, INT_QTY_MIN, INT_QTY_MAX, INT_QTY_ACT, CHR_SLOC, CHR_PRICE, CHR_PART_TYPE, CHR_FILENAME, CHR_FLAG_DELETE, 
                            CHR_CREATED_BY, CHR_CREATED_DATE, CHR_CREATED_TIME, CHR_MODIFIED_BY, CHR_MODIFIED_DATE, CHR_MODIFIED_TIME, STATUS, MESSAGE) 
                            VALUES ('$part_no', '$rack_no', '$part_name', '$component', '$model', '$back_no', '$type', '$spec', '$qty_use', '$qty_min', '$qty_max',
                                    '$qty_act', '$sloc', '$price', NULL, NULL, 'F', '$pic', '$date_now', '$time_now', NULL, NULL, NULL,'$error_stat', '$error_msg')");
                }
                redirect("samanta/spare_parts_c/upload_confirmation", "refresh");
            } else {
                redirect($this->back_to_create_view . $msg = 5);
            }
        }
    }

    public function upload_confirmation()
    {
        $this->role_module_m->authorization('151');
        $this->log_m->add_log(9, NULL);

        $db_samanta = $this->load->database("samanta", TRUE);
        $pic = $this->session->userdata('NPK');

        $error_stat = 0;
        $date_now = date("Ymd");
        $time_now = date("His");


        $data_list = $db_samanta->query("SELECT * FROM TW_SPARE_PARTS ORDER BY STATUS DESC")->result();
        if (count($data_list) == 0) {
            redirect($this->back_to_create_view);
        }
        // Cek upload OK & list yang akan di save
        $check_upload_total = $db_samanta->query("SELECT * FROM TW_SPARE_PARTS")->num_rows();
        $check_upload_ok = $db_samanta->query("SELECT * FROM TW_SPARE_PARTS WHERE STATUS = '0'")->num_rows();

        if ($this->input->post("btn-confirm") != '') {
            $range = 0;
            //$data_list_insert = $db_samanta->query("SELECT * FROM TW_SPARE_PARTS WHERE STATUS = '0' ORDER BY STATUS DESC")->result();
            foreach ($data_list as $value_list) {
                $part_no = trim($value_list->CHR_PART_NO);
                $rack_no = trim($value_list->CHR_RACK_NO);
                $part_name = strtoupper(trim($value_list->CHR_SPARE_PART_NAME));
                $component = trim($value_list->CHR_COMPONENT);
                $model = strtoupper(trim($value_list->CHR_MODEL));
                $back_no_full = strtoupper(trim($value_list->CHR_BACK_NO));
                $type = trim($value_list->CHR_TYPE);
                $spec = trim($value_list->CHR_SPECIFICATION);
                $qty_use = trim($value_list->INT_QTY_USE);
                $qty_min = trim($value_list->INT_QTY_MIN);
                $qty_max = trim($value_list->INT_QTY_MAX);
                $qty_act = trim($value_list->INT_QTY_ACT);
                $sloc = trim($value_list->CHR_SLOC);
                $price = trim($value_list->CHR_PRICE);
                $part_type = trim($value_list->CHR_PART_TYPE);


                $check_exist = $db_samanta->query("SELECT * FROM TM_SPARE_PARTS WHERE CHR_PART_NO = '$part_no'")->num_rows();
                if ($check_exist > 0) {
                    $db_samanta->query("UPDATE TM_SPARE_PARTS SET 
                                                CHR_SPARE_PART_NAME = '$part_name',
                                                CHR_COMPONENT = '$component',
                                                CHR_MODEL = '$model',
                                                CHR_BACK_NO = '$back_no_full',
                                                CHR_TYPE = '$type',
                                                CHR_SPECIFICATION = '$spec',
                                                INT_QTY_USE = '$qty_use', 
                                                INT_QTY_MIN = '$qty_min', 
                                                INT_QTY_MAX = '$qty_max',
                                                CHR_PRICE = '$price', 
                                                CHR_CREATED_BY = '$pic', 
                                                CHR_CREATED_DATE = '$date_now', 
                                                CHR_CREATED_TIME = '$time_now'
                                                WHERE CHR_PART_NO='$part_no'");


                    $check_sp_sloc = $db_samanta->query("SELECT * FROM TT_SPARE_PARTS_SLOC WHERE CHR_PART_NO = '$part_no' AND CHR_SLOC = '$sloc'")->num_rows();
                    if ($check_sp_sloc > 0) {
                        $db_samanta->query("UPDATE TT_SPARE_PARTS_SLOC SET 
                                                    CHR_SLOC = '$sloc',
                                                    INT_QTY = '$qty_act',
                                                    CHR_ENTRIED_BY = '$pic',
                                                    CHR_ENTRIED_DATE = '$date_now', 
                                                    CHR_ENTRIED_TIME = '$time_now'
                                                    WHERE CHR_PART_NO='$part_no' AND CHR_SLOC='$sloc'");
                    } else {
                        $db_samanta->query("INSERT INTO TT_SPARE_PARTS_SLOC (CHR_PART_NO, CHR_SLOC, INT_QTY, CHR_ENTRIED_BY, CHR_ENTRIED_DATE, CHR_ENTRIED_TIME)
                                                                        VALUES ('$part_no', '$sloc', '$qty_act', '$pic', '$date_now','$time_now')");
                    }

                    $check_sp_routing = $db_samanta->query("SELECT * FROM TM_SPARE_PARTS_ROUTING WHERE CHR_PART_NO = '$part_no' AND CHR_RACK_NO = '$rack_no'")->num_rows();
                    if ($check_sp_routing > 0) {
                        $db_samanta->query("UPDATE TM_SPARE_PARTS_ROUTING SET 
                                                    CHR_BACK_NO = '$back_no_full',
                                                    CHR_RACK_NO = '$rack_no',
                                                    CHR_MODIFIED_BY = '$pic', 
                                                    CHR_MODIFIED_DATE = '$date_now', 
                                                    CHR_MODIFIED_TIME = '$time_now'
                                                    WHERE CHR_PART_NO='$part_no' AND CHR_RACK_NO = '$rack_no'");
                    } else {
                        $db_samanta->query("INSERT INTO TM_SPARE_PARTS_ROUTING (CHR_PART_NO, CHR_BACK_NO, CHR_RACK_NO, CHR_CREATED_BY, CHR_CREATED_DATE, CHR_CREATED_TIME)
                                                                        VALUES ('$part_no', '$back_no_full', '$rack_no', '$pic', '$date_now','$time_now')");
                    }
                    $range++;
                } else {
                    // if (strpos($back_no_full, "/") == true) {
                    //     $back_no_full = trim($back_no_full);
                    //     $arr = explode("/", $back_no_full);
                    //     $y = count($arr);
                    //     for ($x = 0; $x < $y; $x++) {
                    //         $back_nox = $arr[$x];
                    //         $sql = "INSERT INTO TT_SPARE_PARTS_ROUTE (CHR_PART_NO, CHR_BACK_NO, CHR_RACK_NO, CHR_ENTRIED_BY, CHR_ENTRIED_DATE, CHR_ENTRIED_TIME) 
                    //                 VALUES ('$part_no', '$back_nox', '$rack_no', '$pic', '$date_now','$time_now')";
                    //         $db_samanta->query($sql);
                    //     }
                    // } else {
                    //     $sql = "INSERT INTO TT_SPARE_PARTS_ROUTE (CHR_PART_NO, CHR_BACK_NO, CHR_RACK_NO, CHR_ENTRIED_BY, CHR_ENTRIED_DATE, CHR_ENTRIED_TIME) 
                    //                 VALUES ('$part_no', '$back_no_full', '$rack_no', '$pic', '$date_now', '$time_now')";
                    //         $db_samanta->query($sql);
                    // }

                    $insert = "INSERT INTO TM_SPARE_PARTS (CHR_PART_NO, CHR_SPARE_PART_NAME, CHR_COMPONENT, CHR_MODEL, CHR_BACK_NO, CHR_TYPE, 
                    CHR_SPECIFICATION, INT_QTY_USE, INT_QTY_MIN, INT_QTY_MAX, CHR_PRICE, CHR_PART_TYPE, CHR_FILENAME, CHR_FLAG_DELETE, 
                    CHR_CREATED_BY, CHR_CREATED_DATE, CHR_CREATED_TIME, CHR_MODIFIED_BY, CHR_MODIFIED_DATE, CHR_MODIFIED_TIME) 
                    VALUES ('$part_no','$part_name','$component','$model', '$back_no_full','$type','$spec', '$qty_use','$qty_min', '$qty_max',
                            '$price',NULL, NULL, 'F', '$pic','$date_now','$time_now', NULL, NULL, NULL)";
                    $db_samanta->query($insert);

                    $sql = "INSERT INTO TT_SPARE_PARTS_SLOC (CHR_PART_NO, CHR_SLOC, INT_QTY, CHR_ENTRIED_BY, CHR_ENTRIED_DATE, CHR_ENTRIED_TIME)
                            VALUES ('$part_no', '$sloc', '$qty_act', '$pic', '$date_now','$time_now')";
                    $db_samanta->query($sql);

                    $db_samanta->query("INSERT INTO TM_SPARE_PARTS_ROUTING (CHR_PART_NO, CHR_BACK_NO, CHR_RACK_NO, CHR_CREATED_BY, CHR_CREATED_DATE, CHR_CREATED_TIME)
                                                                        VALUES ('$part_no', '$back_no_full', '$rack_no', '$pic', '$date_now','$time_now')");

                    $range++;
                }

                //--------------------------------------------------------------------//   
                //make label barcode
                $this->load->library('ciqrcode');
                $params['data'] = "$part_no";
                $params['level'] = 'B';
                $params['size'] = 2;
                $params['savename'] = 'assets/qrcode_spare_parts/' . $part_no . '.png';
                $this->ciqrcode->generate($params);
            }

            $db_samanta->query("TRUNCATE TABLE TW_SPARE_PARTS");

            redirect($this->back_to_manage . $msg = 6);
        }

        $data['content'] = 'samanta/confirm_spare_parts_v';
        $data['title'] = 'Upload Data Confirmation';

        $data['data_list'] = $data_list;
        $data['cek_upload_total'] = $check_upload_total;
        $data['cek_upload_ok'] = $check_upload_ok;

        $data['news'] = $this->news_m->get_news();
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(210);

        $this->load->view($this->layout, $data);
    }

    function cancel_upload()
    {
        $db_samanta = $this->load->database("samanta", TRUE);
        // $npk = $this->session->userdata('NPK');
        // $date_now = date("Ymd");
        // $time_now = date("His");
        // $time = substr($time_now,0,2);
        $db_samanta->query("TRUNCATE TABLE TW_SPARE_PARTS");
        // $this->db->query("DELETE TT_SPARE_PARTS_SLOC WHERE CHR_ENTRIED_BY = '$npk' AND CHR_ENTRIED_DATE = '$date_now' AND CHR_ENTRIED_TIME LIKE '$time%'");                    
        // $this->db->query("DELETE TT_SPARE_PARTS_ROUTE WHERE CHR_ENTRIED_BY = '$npk' AND CHR_ENTRIED_DATE = '$date_now' AND CHR_ENTRIED_TIME LIKE '$time%'");
        redirect($this->back_to_create_view);
    }



    function generate_lable_part()
    {
        $db_samanta = $this->load->database("samanta", TRUE);
        $checked = $this->input->post('options');
        if ($checked == null) {
            redirect($this->back_to_manage);
        }
        $index = 1;
        $index_page = 1;
        $pdf = new FPDF('P', 'mm', 'A4');
        $pdf->SetMargins(3, 3, 3, 0);
        $pdf->SetAutoPageBreak(true, 0);
        $pdf->AliasNbPages();
        $pdf->AddPage();
        $pdf->SetFont('Courier', '', 11);

        for ($i = 0; $i < count($checked); $i++) {
            $x = $checked[$i];
            $data_part = $db_samanta->query("SELECT A.CHR_PART_NO, B.CHR_RACK_NO, A.CHR_SPARE_PART_NAME, A.CHR_SPECIFICATION
                                      from TM_SPARE_PARTS A INNER JOIN TT_SPARE_PARTS_ROUTE B ON B.CHR_PART_NO = A.CHR_PART_NO
                                      where A.INT_ID = '$x'")->result();

            if ($index % 3 == 1) {
                //cell kotakan luar
                $x_kanban1 = $pdf->GetX();
                $y_kanban1 = $pdf->GetY();
                $pdf->Cell(55, 25, "", 1, 1, 'L'); // ukuran kotak luar
                $pdf->SetY($y_kanban1 + 1); // jarak kotak luar dan dalam
                $pdf->SetX($x_kanban1 + 1);

                //column 1
                //cell kotakan dalam
                $x_kanban2 = $pdf->GetX();
                $y_kanban2 = $pdf->GetY();
                $pdf->Cell(22, 23, "", 1, 1, 'L'); //ukuran kotak dalam
                $pdf->SetY($y_kanban2);
                $pdf->SetX($x_kanban2);

                $pdf->SetX($x_kanban2 + 22);
                $pdf->SetFont('Courier', 'B', 12);
                $pdf->Cell(32, 5, $data_part[0]->CHR_RACK_NO, "B", 1, 'L');

                $pdf->SetX($x_kanban2 + 22);
                $pdf->SetFont('Courier', '', 9);
                $pdf->Cell(32, 5, substr($data_part[0]->CHR_PART_NO, 0, 15), "B", 1, 'L');

                $pdf->SetX($x_kanban2 + 22);
                $pdf->SetFont('Courier', '', 9);
                $pdf->Cell(32, 5, substr($data_part[0]->CHR_SPARE_PART_NAME, 0, 15), "B", 1, 'L');

                $pdf->SetX($x_kanban2 + 22);
                $pdf->SetFont('Courier', '', 8);
                $pdf->MultiCell(32, 4, substr($data_part[0]->CHR_SPECIFICATION, 0, 30), 0, "L", 0);

                $pdf->SetY($y_kanban2 + 1);
                $pdf->SetX($x_kanban2);
                $pdf->SetFont('Courier', '', 7);
                $image1 = "./assets/qrcode_spare_parts/" . trim($data_part[0]->CHR_PART_NO) . ".png";
                $pdf->Image($image1, $pdf->GetX() + 1, $pdf->GetY(), 20, 20);

                $pdf->SetX($x_kanban2 + 53);
                //$pdf->SetY(2);


            } elseif ($index % 3 == 2) {
                //mulai untuk kolom baru
                $x_kanban4 = $pdf->GetX();
                $pdf->SetXY($x_kanban4, $y_kanban1);

                $pdf->Cell(4, 8, "", "", 0, 'L');
                $x_kanban1 = $pdf->GetX();
                $y_kanban1 = $pdf->GetY();
                $pdf->Cell(55, 25, "", 1, 1, 'L');
                $pdf->SetY($y_kanban1 + 1);
                $pdf->SetX($x_kanban1 + 1);

                $x_kanban2 = $pdf->GetX();
                $y_kanban2 = $pdf->GetY();
                $pdf->Cell(22, 23, "", 1, 1, 'L');

                //column 2
                $pdf->SetY($y_kanban2);
                $pdf->SetX($x_kanban2);

                $pdf->SetX($x_kanban2 + 22);
                $pdf->SetFont('Courier', 'B', 12);
                $pdf->Cell(32, 5, $data_part[0]->CHR_RACK_NO, "B", 1, 'L');

                $pdf->SetX($x_kanban2 + 22);
                $pdf->SetFont('Courier', '', 9);
                $pdf->Cell(32, 5, substr($data_part[0]->CHR_PART_NO, 0, 15), "B", 1, 'L');

                $pdf->SetX($x_kanban2 + 22);
                $pdf->SetFont('Courier', '', 9);
                $pdf->Cell(32, 5, substr($data_part[0]->CHR_SPARE_PART_NAME, 0, 15), "B", 1, 'L');

                $pdf->SetX($x_kanban2 + 22);
                $pdf->SetFont('Courier', '', 8);
                $pdf->MultiCell(32, 4, substr($data_part[0]->CHR_SPECIFICATION, 0, 30), 0, "L", 0);

                $pdf->SetY($y_kanban2 + 1);
                $pdf->SetX($x_kanban2);
                $pdf->SetFont('Courier', '', 7);
                $image1 = "./assets/qrcode_spare_parts/" . trim($data_part[0]->CHR_PART_NO) . ".png";
                $pdf->Image($image1, $pdf->GetX() + 1, $pdf->GetY(), 20, 20);

                $pdf->SetX($x_kanban2 + 53);
            } elseif ($index % 3 == 0) {
                $x_kanban4 = $pdf->GetX();
                $pdf->SetXY($x_kanban4, $y_kanban1);

                $pdf->Cell(4, 8, "", "", 0, 'L');
                $x_kanban1 = $pdf->GetX();
                $y_kanban1 = $pdf->GetY();
                $pdf->Cell(55, 25, "", 1, 1, 'L');
                $pdf->SetY($y_kanban1 + 1);
                $pdf->SetX($x_kanban1 + 1);

                $x_kanban2 = $pdf->GetX();
                $y_kanban2 = $pdf->GetY();
                $pdf->Cell(22, 23, "", 1, 1, 'L');

                //column 3
                $pdf->SetY($y_kanban2);
                $pdf->SetX($x_kanban2);

                $pdf->SetX($x_kanban2 + 22);
                $pdf->SetFont('Courier', 'B', 12);
                $pdf->Cell(32, 5, $data_part[0]->CHR_RACK_NO, "B", 1, 'L');

                $pdf->SetX($x_kanban2 + 22);
                $pdf->SetFont('Courier', '', 9);
                $pdf->Cell(32, 5, substr($data_part[0]->CHR_PART_NO, 0, 15), "B", 1, 'L');

                $pdf->SetX($x_kanban2 + 22);
                $pdf->SetFont('Courier', '', 9);
                $pdf->Cell(32, 5, substr($data_part[0]->CHR_SPARE_PART_NAME, 0, 15), "B", 1, 'L');

                $pdf->SetX($x_kanban2 + 22);
                $pdf->SetFont('Courier', '', 8);
                $pdf->MultiCell(32, 4, substr($data_part[0]->CHR_SPECIFICATION, 0, 30), 0, "L", 0);

                $pdf->SetY($y_kanban2 + 1);
                $pdf->SetX($x_kanban2);
                $pdf->SetFont('Courier', '', 7);
                $image1 = "./assets/qrcode_spare_parts/" . trim($data_part[0]->CHR_PART_NO) . ".png";
                $pdf->Image($image1, $pdf->GetX() + 1, $pdf->GetY(), 20, 20);

                $pdf->SetXY(3, $pdf->GetY() + 25);

                if ($index_page % 10 == 0) {
                    $pdf->AddPage();
                }
                $index_page++;
            }
            $index++;
        }
        $pdf->Output();
    }

    //======================================================================================================================
    //======================================================================================================================
    // Spare Parts List Order
    //======================================================================================================================

    function list_order()
    {
        $db_samanta = $this->load->database("samanta", TRUE);
        $npk = $this->session->userdata('NPK');
        //$db_samanta->query("DELETE TW_SPARE_PARTS_ORDER WHERE CHR_ENTRIED_BY = '$npk'");

        $datenow = date('Ymd');
        $timenow = date('His');
        $period = date("Y") . date("m");

        /*$data_list_order = $this->spare_parts_m->get_all_parts_trans_2($period);
        foreach ($data_list_order as $value_list_order) {
            $data = array(
                'CHR_PART_NO' => trim($value_list_order->CHR_PART_NO),
                'CHR_SPARE_PART_NAME' => trim($value_list_order->CHR_SPARE_PART_NAME),
                'CHR_SPECIFICATION' => trim($value_list_order->CHR_SPECIFICATION),
                'CHR_COMPONENT' => trim($value_list_order->CHR_COMPONENT),
                'CHR_MODEL' => trim($value_list_order->CHR_MODEL),
                'CHR_PRICE' => $value_list_order->CHR_PRICE,
                'INT_QTY_USE' => $value_list_order->INT_QTY_USE,
                'INT_QTY_MIN' => $value_list_order->INT_QTY_MIN,
                'INT_QTY_MAX' => $value_list_order->INT_QTY_MAX,
                'INT_QTY_ACT' => $value_list_order->INT_QTY_ACT,
                'INT_QTY_OUT' => $value_list_order->INT_TOTAL_QTY,
                'INT_QTY_ORDER' => '0',
                'CHR_UOM' => 'PC',
                'CHR_ENTRIED_BY' => $npk,
                'CHR_ENTRIED_DATE' => $datenow,
                'CHR_ENTRIED_TIME' => $timenow
            );
            $this->spare_parts_m->save_tw_order($data);
        }*/

        if ($this->input->post('btn_create') != '') {
            $this->processing_list_order();
        }

        $data['data_all_parts_trans'] = $this->spare_parts_m->get_all_parts_order($npk);
        $data['content'] = 'samanta/order_v';
        $data['title'] = 'List Order';
        $data['news'] = $this->news_m->get_news();
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(210);

        $this->load->view($this->layout, $data);
    }

    function processing_list_order()
    {
        $db_samanta = $this->load->database("samanta", TRUE);
        $npk = $this->session->userdata('NPK');
        $date_now = date('Ymd');
        $time_now = date('His');

        $arr_part_number = $this->input->post('part_no');
        $arr_qty_order = $this->input->post('qty_order');
        $arr_price = $this->input->post('price');
        $arr_i = $this->input->post('i');

        for ($i = 1; $i <= $arr_i; $i++) {
            $part_number = trim($arr_part_number[$i]);
            $qty_order = str_replace(".", "", $arr_qty_order[$i]);
            $price_per_part_number = str_replace(".", "", $arr_price[$i]);

            $amount = $price_per_part_number * $qty_order;

            $db_samanta->query("UPDATE TW_SPARE_PARTS_ORDER SET 
                                    INT_QTY_ORDER = $qty_order,
                                    CHR_AMOUNT = $amount
                                    WHERE CHR_PART_NO = '$part_number'");
        }
        redirect($this->list_order_confirmation);
    }

    function list_order_confirmation()
    {
        $db_samanta = $this->load->database("samanta", TRUE);
        $npk = $this->session->userdata('NPK');

        $get_total_order = $this->spare_parts_m->get_total_order($npk);
        $qty = $get_total_order[0]->TOTAL_QTY;
        $amount = $get_total_order[0]->TOTAL_AMOUNT;

        $data['data_part_order'] = $this->spare_parts_m->get_all_parts_order_final($npk);
        $data['total_qty'] = $qty;
        $data['total_amount'] = $amount;
        $data['content'] = 'samanta/list_order_confirm_v';
        $data['title'] = 'List Order';
        $data['news'] = $this->news_m->get_news();
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(210);
        $this->load->view($this->layout, $data);
    }

    function save_order_list()
    {
        $db_samanta = $this->load->database("samanta", TRUE);
        $npk = $this->session->userdata('NPK');


        $datenow = date('Ymd');
        $timenow = date('His');
        $period = date("Y") . date("m");

        $dateorder = substr($datenow, 2, 6);

        $check_order_no_seq = $db_samanta->query("SELECT TOP(1) INT_SEQUENCE FROM TT_SPARE_PARTS_ORDER WHERE CHR_ENTRIED_DATE = '$datenow' ORDER BY CHR_ORDER_NO DESC");
        if ($check_order_no_seq->num_rows() == 0) {
            $seq = "0001";
            $order_no = "P" . $dateorder . $seq;
            $sequence_no = 0;
        } else {
            $check_order_no_seq = $check_order_no_seq->row();
            $last_seq = $check_order_no_seq->INT_SEQUENCE;
            $seq = $last_seq + 1;
            $len_seq_num = strlen($seq);
            switch ($len_seq_num) {
                case 0:
                    $x = "0000";
                    break;
                case 1:
                    $x = "000";
                    break;
                case 2:
                    $x = "00";
                    break;
                case 3:
                    $x = "0";
                    break;
                default:
                    break;
            }
            $order_no = "P" . $dateorder . $x . $seq;
            $sequence_no = $seq;
        }

        $data_tt_list_order = $this->spare_parts_m->get_all_parts_order_final($npk);
        foreach ($data_tt_list_order as $value_list_order) {
            $data = array(
                'CHR_ORDER_NO' => $order_no,
                'INT_SEQUENCE' => $sequence_no,
                'CHR_PART_NO' => trim($value_list_order->CHR_PART_NO),
                'CHR_SPARE_PART_NAME' => trim($value_list_order->CHR_SPARE_PART_NAME),
                'CHR_SPECIFICATION' => trim($value_list_order->CHR_SPECIFICATION),
                'CHR_COMPONENT' => trim($value_list_order->CHR_COMPONENT),
                'CHR_MODEL' => trim($value_list_order->CHR_MODEL),
                'CHR_PRICE' => $value_list_order->CHR_PRICE,
                'INT_QTY_USE' => $value_list_order->INT_QTY_USE,
                'INT_QTY_MIN' => $value_list_order->INT_QTY_MIN,
                'INT_QTY_MAX' => $value_list_order->INT_QTY_MAX,
                'INT_QTY_ACT' => $value_list_order->INT_QTY_ACT,
                'INT_QTY_OUT' => $value_list_order->INT_QTY_OUT,
                'INT_QTY_ORDER' => $value_list_order->INT_QTY_ORDER,
                'CHR_UOM' => $value_list_order->CHR_UOM,
                'CHR_AMOUNT' => $value_list_order->CHR_AMOUNT,
                'CHR_ENTRIED_BY' => $npk,
                'CHR_ENTRIED_DATE' => $datenow,
                'CHR_ENTRIED_TIME' => $timenow
            );
            $this->spare_parts_m->save_to_tt_order_list($data);
        }

        $db_samanta->query("DELETE TW_SPARE_PARTS_ORDER WHERE CHR_ENTRIED_BY = '$npk'");
        redirect($this->back_to_manage . $msg = 8);
    }
    //end

    // add function "Add Spare Parts" on Order List
    // update : 11-04-2019
    // start
    function get_wh_by_partno()
    {
        $partno = trim($this->input->post('partno'));

        $wh = $this->spare_parts_m->get_wh_by_part_number($partno);

        $data = "";
        foreach ($wh as $isi) {
            $data .= '<option value=' . $isi->INT_TOTAL . '>&nbsp;&nbsp;&nbsp;&nbsp;' . trim($isi->CHR_SLOC);
        }
        //echo json_encode($data);
        echo trim(json_encode($data), '"');
    }

    function search_sp_ol()
    {
        $get = $this->input->get('term');

        if ($get) {
            $result = $this->spare_parts_m->get_data_spare_parts_ol($get);
            if (count($result) > 0) {
                foreach ($result as $res) {
                    $output[] = array(
                        'label' => $res->CHR_SPECIFICATION . '- ' . $res->CHR_PART_NO,
                        'value' => $res->CHR_PART_NO,
                        'spek' => $res->CHR_SPECIFICATION,
                        'nama' => $res->CHR_SPARE_PART_NAME,
                        'compo' => $res->CHR_COMPONENT,
                        'price' => $res->CHR_PRICE,
                        'model' => $res->CHR_MODEL,
                        'qty_use' => $res->INT_QTY_USE,
                        'qty_min' => $res->INT_QTY_MIN,
                        'qty_max' => $res->INT_QTY_MAX,
                        'qty_act' => $res->INT_QTY_ACT
                    );
                }
                echo json_encode($output);
            }
        }
    }

    function add_sp_ol()
    {
        $npk = $this->session->userdata('NPK');

        $datenow = date('Ymd');
        $timenow = date('His');

        $data = array(
            'CHR_PART_NO' => trim($this->input->post('nopart')),
            'CHR_SPARE_PART_NAME' => trim($this->input->post('namasp')),
            'CHR_SPECIFICATION' => trim($this->input->post('spek')),
            'CHR_COMPONENT' => trim($this->input->post('compsp')),
            'CHR_MODEL' => trim($this->input->post('modelsp')),
            'CHR_PRICE' => $this->input->post('pricesp'),
            'INT_QTY_USE' => $this->input->post('qty_use'),
            'INT_QTY_MIN' => $this->input->post('qty_min'),
            'INT_QTY_MAX' => $this->input->post('qty_max'),
            'INT_QTY_ACT' => $this->input->post('select_warehouse'),
            'INT_QTY_OUT' => '0',
            'INT_QTY_ORDER' => '0',
            'CHR_UOM' => 'PC',
            'CHR_ENTRIED_BY' => $npk,
            'CHR_ENTRIED_DATE' => $datenow,
            'CHR_ENTRIED_TIME' => $timenow
        );
        $this->spare_parts_m->save_tw_order($data);

        redirect('samanta/spare_parts_c/list_order');
    }
    //end
    //======================================================================================================================

    //loop3r 20211229
    public function saveOrderList()
    {
        $part_no_array = $this->input->post("part_no");
        $user_session = $this->session->all_userdata();
        $npk = $user_session['NPK'];
        $area = $this->input->post("area");

        if ($part_no_array == null || $part_no_array == 0) {
            redirect($this->back_to_manage . $area . '/' . 6);
        }

        $orderNo = $this->spare_parts_m->generateOrderNo($npk);

        foreach ($part_no_array as $part_no) {

            $data_sp = $this->spare_parts_m->getDataSparePartByPartNo($part_no);

            $data['CHR_ORDER_NO'] =  $orderNo;
            $data['CHR_PART_NO'] =  $data_sp->CHR_PART_NO;
            $data['CHR_SPARE_PART_NAME'] =  $data_sp->CHR_SPARE_PART_NAME;
            $data['CHR_SPECIFICATION'] =  $data_sp->CHR_SPECIFICATION;
            $data['CHR_COMPONENT'] =  $data_sp->CHR_COMPONENT;
            $data['CHR_MODEL'] =  $data_sp->CHR_MODEL;
            $data['INT_QTY_ORDER'] =  $data_sp->INT_QTY_ORDER;
            $data['CHR_CREATED_BY'] =  $npk;
            $data['CHR_CREATED_DATE'] =  date('Ymd');
            $data['CHR_CREATED_TIME'] =  date('His');

            $this->spare_parts_m->insertTempOrderList($data);
        }

        redirect($this->back_to_manage . $area . '/' . 1);
    }

    //Loop3r 20211229
    public function publishOrderList()
    {
        //TODO: Update INT_STATUS Order List Order
        //choose supplier
    }
}
