<?php

//Add By xcx 20190507
class master_spec_part_c extends CI_Controller
{

    private $layout = '/template/head';
    private $back_to_index = '/patricia/master_spec_part_c/group_fg/';
    private $back_to_route = '/patricia/master_spec_part_c/main_routing/';
    private $back_to_capa = '/patricia/master_spec_part_c/capacity_line/';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('patricia/master_spec_part_m');
        $this->load->model('organization/dept_m');
        $this->load->model('prd/direct_backflush_general_m');
        $this->load->model('raw_material/raw_material_m');
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

        $data['content'] = 'patricia/spec_part/manage_spec_part_v';

        if ($this->input->post("filter") == 1) {
            $group = $this->input->post("CHR_GROUP");
            $data['data'] = $this->master_spec_part_m->get_data_group($group);
        } else {
            $data['data'] = NULL;
        }

        // $data['all_dept_prod'] = $all_dept_prod;
        // $data['all_work_centers'] = $all_work_centers;
        // $data['work_center'] = $work_center;
        // $data['id_dept'] = $id_dept;
        $this->load->view($this->layout, $data);
    }

    public function generate_data_group()
    {
        $this->load->library('excel');
        $mon_now = date("m-Y");
        $month = date("Ym");
        $list_part = $this->master_spec_part_m->get_part_assy();

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
                redirect("patricia/master_spec_part_c/group_fg", "refresh");
            } else {
                echo "<script>alert('Maaf data yang Anda masukan salah, Pastikan Anda menggunakan Template dari sistem')</script>";
            }
        }
    }

    function create_spec_part($id_dept, $work_center)
    {
        $this->role_module_m->authorization(309);

        $data['content'] = 'patricia/spec_part/create_spec_part_v';
        $data['title'] = 'Create Data Spec Part';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(309);
        $data['news'] = $this->news_m->get_news();

        $data['id_dept'] = $id_dept;
        $data['work_center'] =  $work_center;
        $data['data_assy'] = $this->master_spec_part_m->get_part_assy();
        $data['data_line'] = $this->master_spec_part_m->get_line_param();

        $this->load->view($this->layout, $data);
    }

    function save_data_ukur()
    {
        $params = trim($this->input->post('CHR_PARAM'));
        $partno = trim($this->input->post('CHR_PARTNO'));
        $max = trim($this->input->post('CHR_MAX'));
        $min = trim($this->input->post('CHR_MIN'));
        $dept = trim($this->input->post('CHR_DEPT'));
        $line = trim($this->input->post('CHR_LINE'));
        $session = $this->session->all_userdata();

        $data_prod = $this->db->query("SELECT TOP 1 * FROM PRD.TM_DATA_UKUR_PART WHERE CHR_PARTNO = '$partno' and CHR_ID_SPEC = '$params'");
        if ($data_prod->num_rows() == 0) {
            $data_pr = array(
                'CHR_ID_SPEC' => $params,
                'CHR_PARTNO' => $partno,
                'CHR_STD_MIN' => $min,
                'CHR_STD_MAX' => $max,
                'CHR_NPK_CREATE' => $session['NPK'],
                'CHR_DATE_CREATE' => date("Ymd"),
                'CHR_TIME_CREATE' => date("His")
            );
            $this->master_spec_part_m->save_dtukur($data_pr);

            redirect($this->back_to_index . $dept . '/' . $line . '/' . $msg = 1);
        } else {
            redirect($this->back_to_index . $dept . '/' . $line . '/' . $msg = 4);
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

        $data['data'] = $this->master_spec_part_m->get_spec_id($id);
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

            $this->master_spec_part_m->update_groupfg($data_array, $id);
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

        $data['content'] = 'patricia/pos_line_param/manage_capacity_v';
        $row = $this->dept_m->get_top_prod_dept()->row();
        $responsible = '01' . substr($row->CHR_DEPT, 2, 1);
        $all_work_centers = $this->raw_material_m->get_all_work_center_by_dept($responsible);
        $data['all_work_centers'] = $all_work_centers;

        // if ($this->input->post("filter") == 1) {
        //     $line = $this->input->post("CHR_WC");
        //     $data['data'] = $this->master_spec_part_m->get_data_capacity($line);
        // } else {
        //     $data['data'] = NULL;
        // }

        $data['data'] = $this->master_spec_part_m->get_data_capacity();

        $this->load->view($this->layout, $data);
    }

    function create_capacity()
    {
        $this->role_module_m->authorization(304);

        $data['content'] = 'patricia/pos_line_param/create_capacity_v';
        $data['title'] = 'Create Line Parameter';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(304);
        $data['news'] = $this->news_m->get_news();

        $data['data_line'] = $this->master_spec_part_m->get_line_prd();

        $this->load->view($this->layout, $data);
    }

    function save_capacity()
    {
        $line = trim($this->input->post('CHR_LINE'));
        $cpty = trim($this->input->post('CHR_CAPACITY'));
        $session = $this->session->all_userdata();

        $data_ls = $this->master_spec_part_m->check_cpty($line);
        if ($data_ls == 0) {
            $data_pr = array(
                'CHR_WORK_CENTER' => $line,
                'CHR_PCS_PER_DAY' => $cpty,
                'CHR_CREATE_BY' => $session['NPK'],
                'CHR_CREATE_DATE' => date("Ymd"),
                'CHR_CREATE_TIME' => date("His")
            );
            $this->master_spec_part_m->save_capacity($data_pr);

            redirect($this->back_to_capa  . $msg = 1);
        } else {
            redirect($this->back_to_capa  . $msg = 4);
        }
    }

    function edit_capacity($id)
    {
        $this->role_module_m->authorization(304);
        $data['content'] = 'patricia/pos_line_param/edit_capacity_v';
        $data['title'] = 'Edit Capacity Line';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(304);
        $data['news'] = $this->news_m->get_news();

        $data['data'] = $this->master_spec_part_m->get_line_id($id);
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

            $this->master_spec_part_m->update_cap($data_array, $id);
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
        $all_work_centers = $this->raw_material_m->get_all_work_center_by_dept($responsible);
        $data['all_work_centers'] = $all_work_centers;
        $data['all_part'] = $this->master_spec_part_m->all_part();

        if ($this->input->post("filter") == 1) {
            $part = $this->input->post("CHR_PART");
            $data['data'] = $this->master_spec_part_m->get_routing($part);
        } else {
            $data['data'] = NULL;
        }

        $this->load->view($this->layout, $data);
    }

    function del_routing($partno, $pv)
    {
        $this->master_spec_part_m->del_routing($partno, $pv);
        redirect($this->back_to_route . $msg = 4);
    }

    function aktif_route($partno, $pv)
    {
        $this->master_spec_part_m->aktif_route($partno, $pv);
        redirect($this->back_to_route . $msg = 5);
    }

    function create_param()
    {
        $this->role_module_m->authorization(305);

        $data['content'] = 'patricia/parameter_pos/create_pos_v';
        $data['title'] = 'Create Parameter Pos';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(305);
        $data['news'] = $this->news_m->get_news();


        $this->load->view($this->layout, $data);
    }

    function save_param_pos()
    {
        $params = trim($this->input->post('CHR_PARAMS_DESC'));
        $params = strtoupper($params);
        $session = $this->session->all_userdata();

        $data_prod = $this->db->query("SELECT TOP 1 * FROM PRD.TM_PARAMETER_CEK_PART WHERE CHR_PARAMETER = '$params'");
        if ($data_prod->num_rows() == 0) {
            $data_pr = array(
                'CHR_PARAMETER' => $params,
                'CHR_NPK_ENTRY' => $session['NPK'],
                'CHR_DATE_ENTRY' => date("Ymd"),
                'CHR_TIME_ENTRY' => date("His")
            );
            $this->master_spec_part_m->save_param($data_pr);

            redirect($this->back_to_route . $msg = 1);
        } else {
            redirect($this->back_to_route . $msg = 4);
        }
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

        $data['data'] = $this->master_spec_part_m->get_route_id($partno, $pv);

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

            $this->master_spec_part_m->update_route($data_array, $partno, $pv);
            redirect($this->back_to_route . $msg = 2);
        }
    }
}
