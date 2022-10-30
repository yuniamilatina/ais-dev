<?php

class manage_mrp_c extends CI_Controller
{

    private $layout = '/template/head';
    private $layout_blank = '/template/head_blank';
    private $back_to_index = '/mrp/manage_mrp_c/group_fg/';
    private $back_to_route = '/mrp/manage_mrp_c/main_routing/';
    private $back_to_capa = '/mrp/manage_mrp_c/capacity_line/';
    private $back_to_bom = '/mrp/manage_mrp_c/view_detail_bom/';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('organization/dept_m');
        $this->load->model('prd/direct_backflush_general_m');
        $this->load->model('prd/group_line_m');
        $this->load->model('mrp/manage_mrp_m');
        $this->load->model('part/part_m');
    }

    function manage_bom($msg = null, $id_product_group = null) {
        $session = $this->session->all_userdata();

        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Creating success </strong> The data is successfully created </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Updating success </strong> The data is successfully updated </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Choosing failed </strong> You must select at least one data</div >";
        } elseif ($msg == 4) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Executing error !</strong> Something error with parameter </div >";
        } else {
            $msg = NULL;
        }
        
        if ($id_product_group == '' || $id_product_group == NULL) {
            // $id_product_group = 1;
            $id_product_group = 'CC';
        }

        $data['all_product_group'] = $this->manage_mrp_m->get_all_product_group_mrp();
        // $data['all_product_group'] = $this->manage_mrp_m->get_all_product_group();
        $data['id_product_group'] = $id_product_group;

        $data['msg'] = $msg;
        $data['title'] = 'Manage BOM';
        $data['content'] = 'mrp/manage_bom/manage_bom_v';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(348);
        $data['news'] = $this->news_m->get_news();

        // $data['data'] = $this->manage_mrp_m->get_all_part_by_group($id_product_group);
        $data['data'] = $this->manage_mrp_m->get_all_part_by_group_mrp($id_product_group);
        
        $this->load->view($this->layout, $data);
    }

    function view_detail_bom($msg, $part_no) {
        
        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>x</button><strong>Creating success. </strong> The data is successfully created. </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>x</button><strong>Updating success. </strong> The data is successfully updated. </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>x</button><strong>Deleting success. </strong> The data is successfully deleted. </div >";
        } elseif ($msg == 12) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>x</button><strong>Executing error !</strong> Something is not right. </div >";
        } else {
            $msg = NULL;
        }

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(348);
        $data['news'] = $this->news_m->get_news();

        $get_part_no = $this->manage_mrp_m->get_detail_part_no($part_no)->row();
        $get_part_group = $this->manage_mrp_m->get_list_part_group();
        $get_detail_bom = $this->manage_mrp_m->get_bom_by_part_no($part_no)->result();

        $data['data_part_no'] = $get_part_no;
        $data['data_part_group'] = $get_part_group;
        $data['data'] = $get_detail_bom;
        $data['title'] = 'Manage BOM Structure';
        $data['msg'] = $msg;
        $data['content'] = 'mrp/manage_bom/view_detail_bom_v';
        $this->load->view($this->layout, $data);
    }

    function group_fg($group = null, $msg = NULL)
    {
        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Creating success </strong> The data is successfully created </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Updating success </strong> The data is successfully updated </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Deleted success </strong> The data is successfully deleted </div >";
        } elseif ($msg == 4) {
            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Choosing failed </strong> You must select at least one data</div >";
        } elseif ($msg == 12) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Creating Failed !</strong> The data cannot be duplicate</div >";
        } elseif ($msg == 13) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Creating Failed !</strong> Format gambar tidak boleh ada titik</div >";
        } elseif ($msg == 14) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Uplo !</strong> Something error with parameter </div >";
        }
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(309);
        $data['news'] = $this->news_m->get_news();

        $data['title'] = 'Master Group Part';

        $data['msg'] = $msg;

        $data['content'] = 'mrp/manage_group_part_v';

        if ($this->input->post("filter") == 1) {
            $group = $this->input->post("CHR_GROUP");
            $data['data'] = $this->manage_mrp_m->get_data_group($group);
        } else {
            $data['data'] = NULL;
        }

        $this->load->view($this->layout, $data);
    }

    public function generate_data_group()
    {
        $this->load->library('excel');
        $mon_now = date("m-Y");
        $month = date("Ym");
        $list_part = $this->manage_mrp_m->get_part_assy();

        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

        // Set Properties
        $objPHPExcel->getProperties()->setCreator(trim($this->session->userdata('USERNAME')));
        $objPHPExcel->getProperties()->setLastModifiedBy(trim($this->session->userdata('USERNAME')));
        $objPHPExcel->getProperties()->setTitle("GROUP FG");
        $objPHPExcel->getProperties()->setSubject("GROUP FG");
        $objPHPExcel->getProperties()->setDescription("GROUP FG");

        //Header
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'TEMPLATE UPLOAD GROUPING FG');
        $objPHPExcel->getActiveSheet()->setCellValue('A3', 'No');
        $objPHPExcel->getActiveSheet()->setCellValue('B3', 'Part No');
        $objPHPExcel->getActiveSheet()->setCellValue('C3', 'Back No');
        $objPHPExcel->getActiveSheet()->setCellValue('D3', 'OEM/GNP/AM');

        $objPHPExcel->getActiveSheet()->getStyle('A3:D3')->getFont()->setSize(11);
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(7);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(19);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);

        $objPHPExcel->getActiveSheet()->getStyle("A3:D3")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $i = 4;
        $no = 1;
        foreach ($list_part as $data) {
            $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $no);
            $objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $data->CHR_PART_NO);
            $objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $data->CHR_BACK_NO);
            $objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $data->CHR_GROUP);

            $objPHPExcel->getActiveSheet()->getStyle("A" . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle("B" . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle("C" . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle("D" . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

            $i++;
            $no++;
        }
        $x = $i - 1;

        $styleArray2 = array(
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => '99CCFF')
            )
        );

        $styleArray3 = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                ),
            ),
        );

        $objPHPExcel->getActiveSheet()->getStyle("A3:D3")->applyFromArray($styleArray2);
        $objPHPExcel->getActiveSheet()->getStyle("A3:D" . $x)->applyFromArray($styleArray3);

        $filename = "Template_Group_FG.xls";
        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . trim($filename) . '"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->setIncludeCharts(TRUE);
        $objWriter->save('php://output');
    }

    public function upload_data_group()
    {
        $this->load->library(array('PHPExcel', 'PHPExcel/IOFactory'));
        $mrp_d = $this->load->database("mrp_d", TRUE);
        $mon_now = date("mY");
        $date_now = date("Ymd");
        $time_now = date("His");
        $session = $this->session->all_userdata();
        $npk = $session['NPK'];
        if ($this->input->post("upload_button") == 1) {
            $fileName = $_FILES['import_stock']['name'];
            if (empty($fileName)) {
                echo '<script>alert("Anda Belum Memilih File Untuk diupload");</script>';
                redirect('patricia/master_spec_part_c/group_fg', 'refresh');
            }

            //file untuk submit file excel
            $config['upload_path'] = './assets/files';
            $config['file_name'] = $fileName;
            $config['allowed_types'] = '*';
            $config['max_size'] = 10000;
            $config['encrypt_name'] = FALSE;
            $config['remove_spaces'] = TRUE;
            //code for upload with ci
            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('import_stock')) {
                echo $this->upload->display_errors();
                exit();
            }

            $media = $this->upload->data('import_stock');
            $inputFileName = './assets/files/' . $media['file_name'];

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
            if ($rowHeader[0][0] == "TEMPLATE UPLOAD GROUPING FG") {
                for ($row = 4; $row <= $highestRow; $row++) {
                    $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);

                    $part_no = $rowData[0][1];
                    $back_no = $rowData[0][2];
                    $group = $rowData[0][3];

                    if ($group != '') {
                        // Check database
                        $cek_partno_backno = "SELECT * FROM TM_GROUP_FG WHERE CHR_PART_NO = '$part_no' and CHR_GROUP='$group'";
                        // $cek_row = $this->db->query($cek_partno_backno)->num_rows();
                        $cek_row = $mrp_d->query($cek_partno_backno)->num_rows();
                        if ($cek_row < 1) {
                            $sql = "INSERT INTO TM_GROUP_FG (CHR_PART_NO, CHR_BACK_NO,CHR_GROUP,CHR_CREATE_BY,CHR_CREATE_DATE,CHR_CREATE_TIME)VALUES('$part_no','$back_no','$group','$npk','$date_now', '$time_now')";
                            // $this->db->query($sql);
                            $mrp_d->query($sql);
                        }
                    }
                }
                redirect("mrp/manage_mrp_c/group_fg", "refresh");
            } else {
                echo "<script>alert('Maaf data yang Anda masukan salah, Pastikan Anda menggunakan Template dari sistem')</script>";
            }
        }
    }    

    function edit_groupfg($id)
    {
        $this->role_module_m->authorization(309);
        $data['content'] = 'patricia/spec_part/edit_spec_part_v';
        $data['title'] = 'Edit Group FG';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(309);
        $data['news'] = $this->news_m->get_news();

        $data['data'] = $this->manage_mrp_m->get_group_fg_by_id($id);
        $this->load->view($this->layout, $data);
    }

    function update_groupfg()
    {
        $this->form_validation->set_rules('CHR_GROUP', 'Group', 'required|trim|max_length[10]|min_length[1]');
        // $this->form_validation->set_rules('CHR_MAX', 'Std Max', 'required|trim|max_length[10]|min_length[1]');
        // $this->form_validation->set_rules('CHR_MIN', 'Std Min', 'required|trim|max_length[10]|min_length[1]');

        $id = $this->input->post('CHR_ID');
        $group = $this->input->post('CHR_GROUP');
        // $group = strtoupper($group);

        if ($this->form_validation->run() == FALSE) {
            $this->edit_groupfg($id);
        } else {
            $data_array = array(
                'CHR_GROUP' => $group,
                'CHR_UPDATE_BY' => $this->session->userdata('NPK'),
                'CHR_UPDATE_TIME' => date('His'),
                'CHR_UPDATE_DATE' => date('Ymd')
            );

            $this->manage_mrp_m->update_groupfg($data_array, $id);
            redirect($this->back_to_index . $msg = 2);
        }
    }

    function capacity_line($msg = NULL)
    {
        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Creating success </strong> The data is successfully created </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Updating success </strong> The data is successfully updated </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Deleted success </strong> The data is successfully deleted </div >";
        } elseif ($msg == 4) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button>Data sudah ada di database</div >";
        } elseif ($msg == 12) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Creating Failed !</strong> The data cannot be duplicate</div >";
        } elseif ($msg == 13) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Creating Failed !</strong> Format gambar tidak boleh ada titik</div >";
        } elseif ($msg == 14) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Uplo !</strong> Something error with parameter </div >";
        }
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(304);
        $data['news'] = $this->news_m->get_news();

        $data['title'] = 'Master Data Capacity';

        $data['msg'] = $msg;

        $data['content'] = 'mrp/manage_capacity/manage_capacity_v';
        $row = $this->dept_m->get_top_prod_dept()->row();
        $responsible = '01' . substr($row->CHR_DEPT, 2, 1);
        $all_work_centers = $this->manage_mrp_m->get_all_work_center_by_dept($responsible);
        $data['all_work_centers'] = $all_work_centers;

        // if ($this->input->post("filter") == 1) {
        //     $line = $this->input->post("CHR_WC");
        //     $data['data'] = $this->manage_mrp_m->get_data_capacity($line);
        // } else {
        //     $data['data'] = NULL;
        // }

        $data['data'] = $this->manage_mrp_m->get_data_capacity();

        $this->load->view($this->layout, $data);
    }

    function create_capacity()
    {
        $this->role_module_m->authorization(304);

        $data['content'] = 'mrp/manage_capacity/create_capacity_v';
        $data['title'] = 'Create Line Parameter';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(304);
        $data['news'] = $this->news_m->get_news();

        $data['data_line'] = $this->manage_mrp_m->get_line_prd();

        $this->load->view($this->layout, $data);
    }

    function save_capacity()
    {
        $line = trim($this->input->post('CHR_LINE'));
        $cpty = trim($this->input->post('CHR_CAPACITY'));
        $session = $this->session->all_userdata();

        $data_ls = $this->manage_mrp_m->check_cpty($line);
        if ($data_ls == 0) {
            $data_pr = array(
                'CHR_WORK_CENTER' => $line,
                'CHR_PCS_PER_DAY' => $cpty,
                'CHR_CREATE_BY' => $session['NPK'],
                'CHR_CREATE_DATE' => date("Ymd"),
                'CHR_CREATE_TIME' => date("His")
            );
            $this->manage_mrp_m->save_capacity($data_pr);

            redirect($this->back_to_capa  . $msg = 1);
        } else {
            redirect($this->back_to_capa  . $msg = 4);
        }
    }

    function edit_capacity($id)
    {
        $this->role_module_m->authorization(304);
        $data['content'] = 'mrp/manage_capacity/edit_capacity_v';
        $data['title'] = 'Edit Capacity Line';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(304);
        $data['news'] = $this->news_m->get_news();

        $data['data'] = $this->manage_mrp_m->get_line_id($id);
        $this->load->view($this->layout, $data);
    }

    function update_capacity()
    {
        $session = $this->session->all_userdata();
        $this->form_validation->set_rules('CHR_CAPACITY', 'Capacity', 'required|trim|max_length[10]|min_length[1]');

        $id = trim($this->input->post('CHR_ID'));
        // $line = trim($this->input->post('CHR_LINE'));
        $cpty = trim($this->input->post('CHR_CAPACITY'));

        if ($this->form_validation->run() == FALSE) {
            $this->edit_capacity($id);
        } else {
            $data_array = array(
                'CHR_PCS_PER_DAY' => $cpty,
                'CHR_UPDATE_BY' => $session['NPK'],
                'CHR_UPDATE_TIME' => date('His'),
                'CHR_UPDATE_DATE' => date('Ymd')
            );

            $this->manage_mrp_m->update_cap($data_array, $id);
            redirect($this->back_to_capa . $msg = 2);
        }
    }

    function main_routing($msg = null)
    {
        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Creating success </strong> The data is successfully created </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Updating success </strong> The data is successfully updated </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Deleted success </strong> The data is successfully deleted </div >";
        } elseif ($msg == 4) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button>Non-Aktifkan Main Routing</div >";
        } elseif ($msg == 5) {
            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button>Sukses Pilih Main Routing</div >";
        } elseif ($msg == 13) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Creating Failed !</strong> Format gambar tidak boleh ada titik</div >";
        } elseif ($msg == 14) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Uplo !</strong> Something error with parameter </div >";
        }

        $data['msg'] = $msg;
        $data['title'] = 'Manage Main Routing';
        $data['content'] = 'patricia/parameter_pos/manage_route_v';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(305);
        $data['news'] = $this->news_m->get_news();

        $row = $this->dept_m->get_top_prod_dept()->row();
        $responsible = '01' . substr($row->CHR_DEPT, 2, 1);
        $all_work_centers = $this->manage_mrp_m->get_all_work_center_by_dept($responsible);
        $data['all_work_centers'] = $all_work_centers;
        $data['all_part'] = $this->manage_mrp_m->all_part();

        if ($this->input->post("filter") == 1) {
            $part = $this->input->post("CHR_PART");
            $data['data'] = $this->manage_mrp_m->get_routing($part);
        } else {
            $data['data'] = NULL;
        }

        $this->load->view($this->layout, $data);
    }

    function del_routing($partno, $pv)
    {
        $this->manage_mrp_m->del_routing($partno, $pv);
        redirect($this->back_to_route . $msg = 4);
    }

    function aktif_route($partno, $pv)
    {
        $this->manage_mrp_m->aktif_route($partno, $pv);
        redirect($this->back_to_route . $msg = 5);
    }

    function edit_routing($partno, $pv)
    {
        $this->role_module_m->authorization(305);
        $data['content'] = 'patricia/parameter_pos/edit_route_v';
        $data['title'] = 'Edit Data Routing';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(305);
        $data['news'] = $this->news_m->get_news();

        $data['data'] = $this->manage_mrp_m->get_route_id($partno, $pv);

        $this->load->view($this->layout, $data);
    }

    function update_route()
    {
        $this->form_validation->set_rules('CHR_STATUS', 'Stat Aktif', 'required|alpha|char|max_length[1]|min_length[1]');
        $session = $this->session->all_userdata();
        // $params = trim($this->input->post('CHR_PARAMS_DESC'));
        // $params = strtoupper($params);
        $partno = $this->input->post('CHR_PART_NO');
        $pv = $this->input->post('CHR_PV');
        $flag = $this->input->post('CHR_STATUS');
        $flag = strtoupper($flag);


        if ($this->form_validation->run() == FALSE) {
            $this->edit_routing($partno, $pv);
        } else {
            $data_array = array(
                'CHR_MAIN_STATUS' => $flag,
                'CHR_UPDATE_BY' => $session['NPK'],
                'CHR_UPDATE_TIME' => date('His'),
                'CHR_UPDATE_DATE' => date('Ymd')
            );

            $this->manage_mrp_m->update_route($data_array, $partno, $pv);
            redirect($this->back_to_route . $msg = 2);
        }
    }

    public function upload_wo()
    {
        $data['title'] = 'Master Data WO Customer';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(118);
        $data['news'] = $this->news_m->get_news();
        $data['content'] = 'mrp/manage_wo/upload_data_wo_v';
        $data['month'] = $this->manage_mrp_m->get_month();

        // if ($this->input->post("filter") == 1) {
        //     $mon = $this->input->post("CHR_MONTH");
        //     $ver = $this->input->post("CHR_VER");
        // } else{
        //     $mon = '';
        //     $ver = '';
        // }

        // if(($mon == '')&&($ver == '')){
        //     $data['data_wo'] = 'NULL';
        // } else{
        // $data['data_wo'] = $this->manage_mrp_m->get_data_wo($mon,$ver);
        // }
        // $data['data_wo'] = $this->manage_mrp_m->get_data_wo();
        $this->load->view($this->layout, $data);
    }

    function refresh_table()
    {
        $CHR_MONTH = $this->input->post("CHR_MONTH");
        $INT_REV = $this->input->post("INT_REV");
        $FILTER = $this->input->post("FILTER");

        $url_iframe = site_url("mrp/manage_mrp_c/refresh_table_page/$CHR_MONTH/$INT_REV/$FILTER");

        $data = array(
            'url_iframe' => $url_iframe
        );
        //====== Either you can print value or you can send value to database
        echo json_encode($data);
    }

    function refresh_table_page($CHR_MONTH = null, $INT_REV = null, $FILTER = null, $msg = null)
    {
        $this->role_module_m->authorization('3');
        $user_session = $this->session->all_userdata();

        $data['CHR_MONTH'] = $CHR_MONTH;
        $data['INT_REV'] = $INT_REV;
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

        // $get_data_area = $this->spare_parts_m->get_data_area();
        // $data['all_area'] = $get_data_area;
        $data['title'] = 'Manage Data WO Customer';
        $data['news'] = $this->news_m->get_news();
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(118);

        if (($CHR_MONTH == 'ALL') && ($INT_REV == '')) {
            $data['data_wo'] = $this->manage_mrp_m->get_data_all_wo($FILTER);
            $data['content'] = 'mrp/manage_wo/refresh_data_wo_v';
            $this->load->view($this->layout_blank, $data);
        } else {
            $data['data_wo'] = $this->manage_mrp_m->get_data_all_wo_per_month($CHR_MONTH, $INT_REV, $FILTER);
            $pic = $this->session->userdata('NPK');
            $data['content'] = 'mrp/manage_wo/refresh_data_wo_v';

            $this->load->view($this->layout_blank, $data);
        }
    }

    public function generate_temp_wo()
    {
        $this->load->library('excel');
        $mon_now = date("m-Y");
        $month = date("Ym");
        $list_part = $this->manage_mrp_m->get_all_part_cust($month);

        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

        // Set Properties
        $objPHPExcel->getProperties()->setCreator(trim($this->session->userdata('USERNAME')));
        $objPHPExcel->getProperties()->setLastModifiedBy(trim($this->session->userdata('USERNAME')));
        $objPHPExcel->getProperties()->setTitle("UPLOAD WO");
        $objPHPExcel->getProperties()->setSubject("UPLOAD WO");
        $objPHPExcel->getProperties()->setDescription("UPLOAD WO");

        //Header
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'TEMPLATE UPLOAD WO CUSTOMER');
        $objPHPExcel->getActiveSheet()->setCellValue('A2', 'BULAN');
        $objPHPExcel->getActiveSheet()->setCellValue('A3', 'VERSI(isi 0 s/d 5)');
        $objPHPExcel->getActiveSheet()->setCellValue('A5', 'No');
        $objPHPExcel->getActiveSheet()->setCellValue('B5', 'Part No Cust');
        $objPHPExcel->getActiveSheet()->setCellValue('C5', 'Part No AII');
        $objPHPExcel->getActiveSheet()->setCellValue('D5', 'Part Name');
        $objPHPExcel->getActiveSheet()->setCellValue('E5', 'Back No');
        $objPHPExcel->getActiveSheet()->setCellValue('F5', 'OEM/GNP/AM');
        $objPHPExcel->getActiveSheet()->setCellValue('G5', 'Cust Code');
        $objPHPExcel->getActiveSheet()->setCellValue('H5', 'Cust Name');
        $objPHPExcel->getActiveSheet()->setCellValue('I5', '1');
        $objPHPExcel->getActiveSheet()->setCellValue('J5', '2');
        $objPHPExcel->getActiveSheet()->setCellValue('K5', '3');
        $objPHPExcel->getActiveSheet()->setCellValue('L5', '4');
        $objPHPExcel->getActiveSheet()->setCellValue('M5', '5');
        $objPHPExcel->getActiveSheet()->setCellValue('N5', '6');
        $objPHPExcel->getActiveSheet()->setCellValue('O5', '7');
        $objPHPExcel->getActiveSheet()->setCellValue('P5', '8');
        $objPHPExcel->getActiveSheet()->setCellValue('Q5', '9');
        $objPHPExcel->getActiveSheet()->setCellValue('R5', '10');
        $objPHPExcel->getActiveSheet()->setCellValue('S5', '11');
        $objPHPExcel->getActiveSheet()->setCellValue('T5', '12');
        $objPHPExcel->getActiveSheet()->setCellValue('U5', '13');
        $objPHPExcel->getActiveSheet()->setCellValue('V5', '14');
        $objPHPExcel->getActiveSheet()->setCellValue('W5', '15');
        $objPHPExcel->getActiveSheet()->setCellValue('X5', '16');
        $objPHPExcel->getActiveSheet()->setCellValue('Y5', '17');
        $objPHPExcel->getActiveSheet()->setCellValue('Z5', '18');
        $objPHPExcel->getActiveSheet()->setCellValue('AA5', '19');
        $objPHPExcel->getActiveSheet()->setCellValue('AB5', '20');
        $objPHPExcel->getActiveSheet()->setCellValue('AC5', '21');
        $objPHPExcel->getActiveSheet()->setCellValue('AD5', '22');
        $objPHPExcel->getActiveSheet()->setCellValue('AE5', '23');
        $objPHPExcel->getActiveSheet()->setCellValue('AF5', '24');
        $objPHPExcel->getActiveSheet()->setCellValue('AG5', '25');
        $objPHPExcel->getActiveSheet()->setCellValue('AH5', '26');
        $objPHPExcel->getActiveSheet()->setCellValue('AI5', '27');
        $objPHPExcel->getActiveSheet()->setCellValue('AJ5', '28');
        $objPHPExcel->getActiveSheet()->setCellValue('AK5', '29');
        $objPHPExcel->getActiveSheet()->setCellValue('AL5', '30');
        $objPHPExcel->getActiveSheet()->setCellValue('AM5', '31');
        $objPHPExcel->getActiveSheet()->setCellValue('AN5', 'N');
        $objPHPExcel->getActiveSheet()->setCellValue('AO5', 'N+1');
        $objPHPExcel->getActiveSheet()->setCellValue('AP5', 'N+2');
        $objPHPExcel->getActiveSheet()->setCellValue('AQ5', 'N+3');
        $objPHPExcel->getActiveSheet()->setCellValue('AR5', 'N+4');
        $objPHPExcel->getActiveSheet()->setCellValue('AS5', 'N+5');
        $objPHPExcel->getActiveSheet()->setCellValue('AT5', 'N+6');
        $objPHPExcel->getActiveSheet()->setCellValue('AU5', 'Cum. Plan');
        $objPHPExcel->getActiveSheet()->setCellValue('AV5', 'Cum. Act. Prod');
        $objPHPExcel->getActiveSheet()->setCellValue('AW5', 'Cum. Act. Order');
        $objPHPExcel->getActiveSheet()->setCellValue('AX5', 'Cum. Act. Del');

        $objPHPExcel->getActiveSheet()->getStyle('A1:C3')->getFont()->setBold(true)->setSize(11);
        $objPHPExcel->getActiveSheet()->getStyle('A5:AX5')->getFont()->setSize(11);

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(4);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(13);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(13);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('T')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('U')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('V')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('W')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('X')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('Y')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('Z')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AA')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AB')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AC')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AD')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AE')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AF')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AG')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AH')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AI')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AJ')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AK')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AL')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AM')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AN')->setWidth(6);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AO')->setWidth(6);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AP')->setWidth(6);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AQ')->setWidth(6);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AR')->setWidth(6);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AS')->setWidth(6);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AT')->setWidth(6);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AU')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AV')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AW')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AX')->setWidth(15);

        $objPHPExcel->getActiveSheet()->getStyle("A5:AX5")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $objPHPExcel->getActiveSheet()->setCellValue('C2', $mon_now);
        $objPHPExcel->getActiveSheet()->setCellValue('C3', '');

        $i = 6;
        $no = 1;
        foreach ($list_part as $data) {

            $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $no);
            $objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $data->CHR_CUS_PART_NO);
            $objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $data->CHR_PART_NO);
            $objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $data->CHR_PART_NAME);
            $objPHPExcel->getActiveSheet()->setCellValue('E' . $i, $data->CHR_BACK_NO);
            $objPHPExcel->getActiveSheet()->setCellValue('F' . $i, '');
            $objPHPExcel->getActiveSheet()->setCellValue('G' . $i, $data->CHR_CUS_NO);
            $objPHPExcel->getActiveSheet()->setCellValue('H' . $i, $data->CHR_CUST_NAME);
            $objPHPExcel->getActiveSheet()->setCellValue('I' . $i, '');
            $objPHPExcel->getActiveSheet()->setCellValue('J' . $i, '');
            $objPHPExcel->getActiveSheet()->setCellValue('K' . $i, '');
            $objPHPExcel->getActiveSheet()->setCellValue('L' . $i, '');
            $objPHPExcel->getActiveSheet()->setCellValue('M' . $i, '');
            $objPHPExcel->getActiveSheet()->setCellValue('N' . $i, '');
            $objPHPExcel->getActiveSheet()->setCellValue('O' . $i, '');
            $objPHPExcel->getActiveSheet()->setCellValue('P' . $i, '');
            $objPHPExcel->getActiveSheet()->setCellValue('Q' . $i, '');
            $objPHPExcel->getActiveSheet()->setCellValue('R' . $i, '');
            $objPHPExcel->getActiveSheet()->setCellValue('S' . $i, '');
            $objPHPExcel->getActiveSheet()->setCellValue('T' . $i, '');
            $objPHPExcel->getActiveSheet()->setCellValue('U' . $i, '');
            $objPHPExcel->getActiveSheet()->setCellValue('V' . $i, '');
            $objPHPExcel->getActiveSheet()->setCellValue('W' . $i, '');
            $objPHPExcel->getActiveSheet()->setCellValue('X' . $i, '');
            $objPHPExcel->getActiveSheet()->setCellValue('Y' . $i, '');
            $objPHPExcel->getActiveSheet()->setCellValue('Z' . $i, '');
            $objPHPExcel->getActiveSheet()->setCellValue('AA' . $i, '');
            $objPHPExcel->getActiveSheet()->setCellValue('AB' . $i, '');
            $objPHPExcel->getActiveSheet()->setCellValue('AC' . $i, '');
            $objPHPExcel->getActiveSheet()->setCellValue('AD' . $i, '');
            $objPHPExcel->getActiveSheet()->setCellValue('AE' . $i, '');
            $objPHPExcel->getActiveSheet()->setCellValue('AF' . $i, '');
            $objPHPExcel->getActiveSheet()->setCellValue('AG' . $i, '');
            $objPHPExcel->getActiveSheet()->setCellValue('AH' . $i, '');
            $objPHPExcel->getActiveSheet()->setCellValue('AI' . $i, '');
            $objPHPExcel->getActiveSheet()->setCellValue('AJ' . $i, '');
            $objPHPExcel->getActiveSheet()->setCellValue('AK' . $i, '');
            $objPHPExcel->getActiveSheet()->setCellValue('AL' . $i, '');
            $objPHPExcel->getActiveSheet()->setCellValue('AM' . $i, '');
            $objPHPExcel->getActiveSheet()->setCellValue('AN' . $i, $data->INT_N);
            $objPHPExcel->getActiveSheet()->setCellValue('AO' . $i, $data->INT_N1);
            $objPHPExcel->getActiveSheet()->setCellValue('AP' . $i, $data->INT_N2);
            $objPHPExcel->getActiveSheet()->setCellValue('AQ' . $i, $data->INT_N3);
            $objPHPExcel->getActiveSheet()->setCellValue('AR' . $i, $data->INT_N4);
            $objPHPExcel->getActiveSheet()->setCellValue('AS' . $i, $data->INT_N5);
            $objPHPExcel->getActiveSheet()->setCellValue('AT' . $i, $data->INT_N6);
            $objPHPExcel->getActiveSheet()->setCellValue('AU' . $i, $data->INT_TOTAL);
            $objPHPExcel->getActiveSheet()->setCellValue('AV' . $i, $data->AKTUAL_PROD);
            $objPHPExcel->getActiveSheet()->setCellValue('AW' . $i, $data->INT_TOTAL_QTY);
            $objPHPExcel->getActiveSheet()->setCellValue('AX' . $i, $data->INT_ACTUAL_DEL);

            $objPHPExcel->getActiveSheet()->getStyle("A" . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle("B" . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle("C" . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle("D" . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle("E" . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle("F" . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle("G" . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle("H" . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle("I" . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle("J" . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle("K" . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle("L" . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle("M" . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle("N" . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle("O" . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle("P" . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle("Q" . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle("R" . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle("S" . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle("T" . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle("U" . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle("V" . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle("W" . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle("X" . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle("Y" . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle("Z" . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle("AA" . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle("AB" . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle("AC" . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle("AD" . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle("AE" . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle("AF" . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle("AG" . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle("AH" . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle("AI" . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle("AJ" . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle("AK" . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle("AL" . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle("AM" . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle("AN" . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle("AO" . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle("AP" . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle("AQ" . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle("AR" . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle("AS" . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle("AT" . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle("AU" . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle("AV" . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle("AW" . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->getStyle("AX" . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

            $i++;
            $no++;
        }
        $x = $i - 1;

        $styleArray2 = array(
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => '99CCFF')
            )
        );

        $styleArray3 = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                ),
            ),
        );

        $objPHPExcel->getActiveSheet()->getStyle("A5:AX5")->applyFromArray($styleArray2);
        $objPHPExcel->getActiveSheet()->getStyle("A5:AX" . $x)->applyFromArray($styleArray3);

        $filename = "Template_Upload_WO.xls";
        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . trim($filename) . '"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        // $objWriter->setIncludeCharts(TRUE);
        $objWriter->save('php://output');
    }

    public function upload_template_data_wo()
    {
        $this->load->library(array('PHPExcel', 'PHPExcel/IOFactory'));
        
        $mrp_d = $this->load->database("mrp_d", TRUE);
        $mon_now = date("Ym");
        $date_now = date("Ymd");
        $time_now = date("His");
        $session = $this->session->all_userdata();
        $npk = $session['NPK'];
        if ($this->input->post("upload_button") == 1) {
            $fileName = $_FILES['import_stock']['name'];
            if (empty($fileName)) {
                echo '<script>alert("Anda Belum Memilih File Untuk diupload");</script>';
                redirect('mrp/manage_mrp_c/upload_wo', 'refresh');
            }

            //file untuk submit file excel
            $config['upload_path'] = './assets/files';
            $config['file_name'] = $fileName;
            $config['allowed_types'] = '*';
            $config['max_size'] = 10000;
            $config['encrypt_name'] = FALSE;
            $config['remove_spaces'] = TRUE;
            //code for upload with ci
            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('import_stock')) {
                echo $this->upload->display_errors();
                exit();
            }

            $media = $this->upload->data('import_stock');
            $inputFileName = './assets/files/' . $media['file_name'];

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
            $rowData = $sheet->rangeToArray('C3:C3', NULL, TRUE, FALSE);
            $version = $rowData[0][0];

            if (!empty($version)) {
                echo '<script>alert("Anda Belum Mengisi versi WO");</script>';
                redirect('mrp/manage_mrp_c/upload_wo', 'refresh');
            }

            $x = 0;
            $y = 0;
            $rowHeader = $sheet->rangeToArray('A1:' . $highestColumn . '1', NULL, TRUE, FALSE);
            if ($rowHeader[0][0] == "TEMPLATE UPLOAD WO CUSTOMER") {
                for ($row = 6; $row <= $highestRow; $row++) {
                    $error_msg = "";
                    $error_stat = 0;
                    $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);

                    $part_no_cust = $rowData[0][1];
                    $part_no_aii = $rowData[0][2];
                    $part_name = $rowData[0][3];
                    $cust_code = $rowData[0][6];
                    $date1 = $rowData[0][8];
                    $date2 = $rowData[0][9];
                    $date3 = $rowData[0][10];
                    $date4 = $rowData[0][11];
                    $date5 = $rowData[0][12];
                    $date6 = $rowData[0][13];
                    $date7 = $rowData[0][14];
                    $date8 = $rowData[0][15];
                    $date9 = $rowData[0][16];
                    $date10 = $rowData[0][17];
                    $date11 = $rowData[0][18];
                    $date12 = $rowData[0][19];
                    $date13 = $rowData[0][20];
                    $date14 = $rowData[0][21];
                    $date15 = $rowData[0][22];
                    $date16 = $rowData[0][23];
                    $date17 = $rowData[0][24];
                    $date18 = $rowData[0][25];
                    $date19 = $rowData[0][26];
                    $date20 = $rowData[0][27];
                    $date21 = $rowData[0][28];
                    $date22 = $rowData[0][29];
                    $date23 = $rowData[0][30];
                    $date24 = $rowData[0][31];
                    $date25 = $rowData[0][32];
                    $date26 = $rowData[0][33];
                    $date27 = $rowData[0][34];
                    $date28 = $rowData[0][35];
                    $date29 = $rowData[0][36];
                    $date30 = $rowData[0][37];
                    $date31 = $rowData[0][38];
                    $total = $date1 + $date2 + $date3 + $date4 + $date5 + $date6 + $date7 + $date8 + $date9 + $date10 + $date11 +
                        $date12 + $date13 + $date14 + $date15 + $date16 + $date17 + $date18 + $date19 + $date20 + $date21 +
                        $date22 + $date23 + $date24 + $date25 + $date26 + $date27 + $date28 + $date29 + $date30 + $date31;
                    $n = $rowData[0][39];
                    $n1 = $rowData[0][41];
                    $n2 = $rowData[0][42];
                    $n3 = $rowData[0][43];
                    $n4 = $rowData[0][44];
                    $n5 = $rowData[0][45];
                    $n6 = $rowData[0][46];

                    // Check database
                    $cek_partno_backno = "SELECT * FROM TT_WO_CUST WHERE CHR_MONTH = '$mon_now' and INT_REV = '$version' and CHR_PARTNO_CUST='$part_no_cust' and CHR_PARTNO_AII='$part_no_aii' and CHR_CUST_CODE='$cust_code'";
                    // $cek_row = $this->db->query($cek_partno_backno)->num_rows();
                    $cek_row = $mrp_d->query($cek_partno_backno)->num_rows();
                    if ($cek_row < 1) {
                        $sql = "INSERT INTO TT_WO_CUST (CHR_MONTH, INT_REV, CHR_PART_NO_CUST, CHR_PART_NO, CHR_PART_NAME,CHR_CUST_CODE,
                                INT_DAY_01,INT_DAY_02,INT_DAY_03,INT_DAY_04,INT_DAY_05,INT_DAY_06, INT_DAY_07, INT_DAY_08, INT_DAY_09, INT_DAY_10, INT_DAY_11, INT_DAY_12, 
                                INT_DAY_13, INT_DAY_14, INT_DAY_15,INT_DAY_16,INT_DAY_17,INT_DAY_18,INT_DAY_19,INT_DAY_20,INT_DAY_21,INT_DAY_22,INT_DAY_23,INT_DAY_24,
                                INT_DAY_25,INT_DAY_26,INT_DAY_27,INT_DAY_28,INT_DAY_29,INT_DAY_30,INT_DAY_31,INT_N,INT_N1,INT_N2,INT_N3,INT_N4,INT_N5,
                                INT_N6,INT_TOTAL,CHR_CREATE_BY,CHR_CREATE_DATE,CHR_CREATE_TIME)VALUES('$mon_now','$version','$part_no_cust',
                                '$part_no_aii', '$part_name', '$cust_code','$date1','$date2','$date3','$date4','$date5','$date6','$date7',
                                '$date8','$date9','$date10','$date11','$date12','$date13','$date14','$date15','$date16','$date17','$date18',
                                '$date19','$date20','$date21','$date22','$date23','$date24','$date25','$date26','$date27','$date28','$date29',
                                '$date30','$date31','$total','$n1','$n2','$n3','$n4','$n5','$n6','$total', '$npk','$date_now', '$time_now')";
                        // $this->db->query($sql);
                        $mrp_d->query($sql);
                    }
                }
                redirect("mrp/manage_mrp_c/upload_wo", "refresh");
            } else {
                echo "<script>alert('Maaf data yang Anda masukan salah, Pastikan Anda menggunakan Template dari sistem')</script>";
            }
        }
    }

    function get_list_part_extend(){
        $id_group = $this->input->post("id_grp");
        $data = '';
        if($id_group == '9999'){
            $data .= '<option value="999900001">Label ASCO</option>';
            $data .= '<option value="999900002">Label TAM</option>';
            $data .= '<option value="999900003">Label TMMIN</option>';
        } else {
            $get_list_part = $this->manage_mrp_m->get_list_part_extend($id_group);            
            if($get_list_part->num_rows() > 0){
                $list_part = $get_list_part->result();

                foreach($list_part as $part){
                    $data .= '<option value="' . trim($part->CHR_PART_NO) . '">' . trim($part->CHR_PART_NO) . ' - ' . trim(preg_replace('/[^A-Za-z0-9\-]/', ' ', $part->CHR_PART_NAME)) . '</option>';
                }
            }
        }   

        $json_data = array('data' => $data);

        echo json_encode($json_data);
    }

    function get_uom_part_extend(){
        $part_no_comp = $this->input->post("part_no_comp");

        $get_uom = $this->manage_mrp_m->get_detail_part_extend($part_no_comp);
        $data = $get_uom->CHR_PART_UOM;

        $json_data = array('data' => $data);

        echo json_encode($json_data);
    }

    function get_supplier(){
        $part_no_comp = $this->input->post("part_no_comp");

        $get_supp = $this->manage_mrp_m->get_supplier_by_comp($part_no_comp);
        $data = '';
        if($get_supp->num_rows() > 0){
            $list_supp = $get_supp->result();

            foreach($list_supp as $supp){
                $data .= '<option value="' . trim($supp->CHR_SUPPLIER_ID) . '">' . trim($supp->CHR_SUPPLIER_ID) . ' - ' . trim($supp->CHR_SUPPLIER_NAME) . '</option>';
            }
        }

        $json_data = array('data' => $data);

        echo json_encode($json_data);
    }

    function add_extend_component()
    {
        $session = $this->session->all_userdata();

        $partno = $this->input->post('CHR_PART_NO');
        $partno_comp = $this->input->post('CHR_PART_NO_COMP');
        $uom = $this->input->post('CHR_UOM');
        $pcs = $this->input->post('INT_QTY_COMP');
        $source = $this->input->post('CHR_SOURCE');
        if($source == 'F' || $source == 'X'){
            $supp_id = $this->input->post('CHR_SUPPLIER');
        } else {
            $supp_id = NULL;
        }        
        
        $data_array = array(
            'CHR_PART_NO_FG' => trim($partno),
            'CHR_PART_NO_COMP' => trim($partno_comp),
            'INT_LEVEL_BOM' => '1',
            'CHR_QTY' => $pcs,
            'CHR_SLOC' => 'WH00',
            'CHR_UOM' => $uom,
            'CHR_SOURCE' => $source,
            'CHR_SUPPLIER_ID' => $supp_id,
            'CHR_USER_CREATE' => $session['NPK'],
            'CHR_CREATE_DATE' => date('Ymd'),
            'CHR_CREATE_TIME' => date('His')            
        );

        $this->manage_mrp_m->save_component($data_array);
        redirect($this->back_to_bom . $msg = 2 . '/' . $partno);
    }

    function edit_extend_component()
    {
        $session = $this->session->all_userdata();

        $id = $this->input->post('INT_ID');
        $partno = $this->input->post('CHR_PART_NO');
        $pcs = $this->input->post('INT_QTY_COMP');
        if($source == 'F' || $source == 'X'){
            $supp_id = $this->input->post('CHR_SUPPLIER');
        } else {
            $supp_id = NULL;
        }        
        
        $data_array = array(
            'CHR_QTY' => $pcs,
            'CHR_SUPPLIER_ID' => $supp_id,
            'CHR_USER_UPDATE' => $session['NPK'],
            'CHR_UPDATE_DATE' => date('Ymd'),
            'CHR_UPDATE_TIME' => date('His')            
        );

        $this->manage_mrp_m->update_component($data_array, $id);
        redirect($this->back_to_bom . $msg = 2 . '/' . $partno);
    }

    function delete_extend_component($id, $partno)
    {
        $session = $this->session->all_userdata();
        
        $data_array = array(
            'INT_FLG_DELETE' => 1,
            'CHR_USER_UPDATE' => $session['NPK'],
            'CHR_UPDATE_DATE' => date('Ymd'),
            'CHR_UPDATE_TIME' => date('His')            
        );

        $this->manage_mrp_m->update_component($data_array, $id);
        redirect($this->back_to_bom . $msg = 2 . '/' . $partno);
    }

    function explode_material_by_chute($group_prd = NULL, $work_center = NULL, $period = NULL) {
        $session = $this->session->all_userdata();
        
        if ($group_prd == NULL || $group_prd == '') {
            $group_prd = $this->manage_mrp_m->get_top_group_prd()->row()->CHR_GROUP_PRODUCT_CODE;
        }

        if ($work_center == NULL) {
            $work_center = "";// $this->manage_mrp_m->get_top_work_center_by_group_prd($group_prd);
        }

        if ($period == NULL || $period == '') {
            $period = date('Ym');
        }

        $all_group_prd = $this->manage_mrp_m->get_all_group_prd();
        $all_work_centers = $this->manage_mrp_m->get_all_work_center_by_group_prd($group_prd);
        
        $data['all_group_prd'] = $all_group_prd->result();        
        $data['group_prd'] = $group_prd;
        $data['all_work_centers'] = $all_work_centers->result();
        $data['work_center'] = $work_center;
        $data['period'] = $period;
        
        $data['title'] = 'Explode Component by Chute Digital';
        $data['content'] = 'mrp/explode_material/explode_material_chute_v';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(350);
        $data['news'] = $this->news_m->get_news();

        $data['data'] = NULL;//$this->manage_mrp_m->explode_material_by_chute_by_period($work_center, $period);
        
        $this->load->view($this->layout, $data);
    }

    function search_explode_material_by_chute() {
        $session = $this->session->all_userdata();
        
        $group_prd = $this->input->post("group_prd");
        $work_center = $this->input->post("CHR_WORK_CENTER");
        $type = $this->input->post("CHR_TYPE");
        $period = $this->input->post("PERIODE");
        $start = $this->input->post("start_seq");
        $end = $this->input->post("end_seq");

        $all_group_prd = $this->manage_mrp_m->get_all_group_prd();
        $all_work_centers = $this->manage_mrp_m->get_all_work_center_by_group_prd($group_prd);

        $data['all_group_prd'] = $all_group_prd->result();
        $data['group_prd'] = $group_prd;
        $data['all_work_centers'] = $all_work_centers->result();
        $data['work_center'] = $work_center;        
        $data['type'] = $type;
        $data['period'] = $period;
        $data['start'] = $start;
        $data['end'] = $end;
        
        $data['title'] = 'Explode Component by Chute Digital';
        $data['content'] = 'mrp/explode_material/explode_material_chute_v';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(350);
        $data['news'] = $this->news_m->get_news();

        if($type == '1'){
            if($work_center != ''){
                $data['data'] = $this->manage_mrp_m->explode_material_by_work_center_and_period_chute($work_center, $period);
            } else {
                $data['data'] = $this->manage_mrp_m->explode_material_by_group_and_period_chute($group_prd, $period);
            }            
        } elseif($type == '2') {
            if($work_center != ''){
                $data['data'] = $this->manage_mrp_m->explode_material_by_work_center_and_sequence_chute($work_center, $start, $end);
            } else {
                $data['data'] = $this->manage_mrp_m->explode_material_by_group_and_sequence_chute($group_prd, $start, $end);
            }
        } else {
            $data['data'] = NULL;
        }       
        
        $this->load->view($this->layout, $data);
    }

    function get_work_center_by_group(){
        $group_code = $this->input->post("GROUP_CODE");

        $data_work_center = $this->manage_mrp_m->get_all_work_center_by_group_prd($group_code)->result();

        $data = '';
        $data .="<option selected value=''>All</option>";
        foreach ($data_work_center as $row) { 
            $data .="<option value='$row->CHR_WORK_CENTER'>".$row->CHR_WORK_CENTER."</option>";
        }

        $json_data = array('data' => $data);

        echo json_encode($json_data);
    }

}
