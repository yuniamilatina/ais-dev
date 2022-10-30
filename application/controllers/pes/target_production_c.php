<?php

class target_production_c extends CI_Controller {

    private $layout = '/template/head';
    private $back_to_upload = 'pes/target_production_c/index_upload_target_production/';
    private $back_to_manage = 'pes/target_production_c/index/';

    public function __construct() {
        parent::__construct();

        $this->load->model('pes/target_production_m');
        $this->load->model('ines/ines_m');
        $this->load->model('organization/dept_m');
        $this->load->model('pes_new/report_prod_part_ng_ok_m');
        $this->load->helper(array('form', 'url', 'inflector'));
        $this->load->library(array('PHPExcel', 'PHPExcel/IOFactory'));
    }

    function index($msg = NULL) {
        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Creating success </strong> The data is successfully created </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Updating success </strong> The data is successfully updated </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Deleted success </strong> The data is successfully deleted </div >";
        }

        $data['content'] = 'pes/target_production/manage_target_production_v';
        $data['title'] = 'Target Production';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(156);
        $data['news'] = $this->news_m->get_news();
        $data['msg'] = $msg;
        $data['selected_date'] = date('Y') . date('m');

        $data['data_target_production'] = $this->target_production_m->get_data($data['selected_date']);

        $this->load->view($this->layout, $data);
    }

    function search_target($date = '', $msg = NULL) {
        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Creating success </strong> The data is successfully created </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Updating success </strong> The data is successfully updated </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Deleted success </strong> The data is successfully deleted </div >";
        }

        $data['content'] = 'pes/target_production/manage_target_production_v';
        $data['title'] = 'Target Production';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(156);
        $data['news'] = $this->news_m->get_news();
        $data['msg'] = $msg;

        $data['all_work_centers'] = $this->ines_m->get_workcenter_inlinescan();
        //$data['work_center'] = $work_center;
        $data['selected_date'] = $date;

        $data['data_target_production'] = $this->target_production_m->get_data($date);

        $this->load->view($this->layout, $data);
    }

    function edit_target_production($id) {

        $data['content'] = 'pes/target_production/edit_target_production_v';
        $data['title'] = 'Edit Target Production';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(156);
        $data['news'] = $this->news_m->get_news();

        $data['data'] = $this->target_production_m->get_data_by_id($id);

        $this->load->view($this->layout, $data);
    }

    function update_target_production() {

        $this->form_validation->set_rules('INT_PLAN_MP1', 'Plan MP', 'numeric|required');
        $this->form_validation->set_rules('INT_CT', 'Cycle Time', 'numeric|required');
        $this->form_validation->set_rules('INT_TARGET_DEL', 'Target Delivery', 'numeric|required');
        $this->form_validation->set_rules('INT_PLAN_SHIFT', 'Shift Plan', 'numeric|required');
        $this->form_validation->set_rules('INT_QTY_PER_JAM_GEDS', 'Qty/Jam (GEDS)', 'numeric|required');
        $this->form_validation->set_rules('INT_PLAN_MP2', 'Jumlah MP', 'numeric|required');

        $id = $this->input->post('INT_ID');
        $ct = $this->input->post('INT_CT');
        $plan_mp1 = $this->input->post('INT_PLAN_MP1');
        $target_del = $this->input->post('INT_TARGET_DEL');
        $plan_shift = $this->input->post('INT_PLAN_SHIFT');
        $qty_per_jam = $this->input->post('INT_QTY_PER_JAM_GEDS');
        $plan_mp2 = $this->input->post('INT_PLAN_MP2');

        if ($this->form_validation->run() == FALSE) {
            $this->edit_target_production($id);
        } else {
            $data_array = array(
                'INT_CT' => $ct,
                'INT_TT' => (7.5 * $plan_shift * 3600) / $target_del,
                'CHR_MH_PC' => round($ct / 3600, 2, PHP_ROUND_HALF_EVEN),
                'CHR_PC_MH' => round(3600 / $ct, 2, PHP_ROUND_HALF_EVEN),
                'INT_PLAN_MP1' => $plan_mp1,
                'INT_QTY_PER_JAM_SWS' => round((3600 / $ct), 2, PHP_ROUND_HALF_EVEN),
                'INT_TARGET_DEL' => $target_del,
                'INT_TARGET_PER_SHIFT' => $target_del / $plan_shift,
                'INT_PLAN_SHIFT' => $plan_shift,
                'INT_QTY_PER_JAM_DELIVERY' => round($target_del / ($plan_shift * 7.5), 2, PHP_ROUND_HALF_EVEN),
                'INT_QTY_PER_JAM_GEDS' => $qty_per_jam,
                'INT_PLAN_MP2' => $plan_mp2,
                'CHR_MODIFIED_BY' => $this->session->userdata('USERNAME'),
                'CHR_MODIFIED_TIME' => date('His'),
                'CHR_MODIFIED_DATE' => date('Ymd')
            );

            $this->target_production_m->update($data_array, $id);
            redirect($this->back_to_manage . $msg = 2);
        }
    }

    function delete_target_production($id) {
        $this->target_production_m->delete($id);
        redirect($this->back_to_manage . $msg = 3);
    }

    function index_upload_target_production($msg = NULL) {
        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Creating success </strong> The data is successfully created </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Updating success </strong> The data is successfully updated </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Deleted success </strong> The data is successfully deleted </div >";
        } elseif ($msg == 12) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>File not exist</strong> You have not selected a file diupload </div >";
        } elseif ($msg == 13) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Data was exist </strong> Data already been uploaded </div >";
        } elseif ($msg == 15) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong> Template salah </strong> Template Upload Anda Salah, Silahkan Coba Lagi Dengan Template Yang Benar </div >";
        } elseif ($msg == 16) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong> Data diexcel ada yang salah </strong> terdapat nilai bukan angka dikolom yang harusnya angka </div >";
        } elseif ($msg == 17) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong> Data kolom BULAN diexcel ada yang salah </strong> terdapat nilai bukan angka dikolom yang harusnya angka </div >";
        } elseif ($msg == 18) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong> Data WORK CENTER salah </strong> mohon periksa kembali kolom work center </div >";
        } elseif ($msg == 19) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong> Data TAHUN salah </strong> mohon periksa kembali kolom tahun </div >";
        }

        $data['content'] = 'pes/target_production/upload_target_production_ppic_v';

        $data['title'] = 'Target Production';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(156);
        $data['news'] = $this->news_m->get_news();
        $data['msg'] = $msg;
        $data['exists'] = $this->target_production_m->get_status_data_temp();
        $data['data_target_production'] = $this->target_production_m->get_data_temp();

        $this->load->view($this->layout, $data);
    }

    function download_template_target_production() {
        $this->load->helper('download');
        ob_clean();
        $name = 'template_target_prod_ppic.xlsx';
        $data = file_get_contents("assets/files/$name");
        force_download($name, $data);
    }

    function upload_target_production() {
        
        $this->target_production_m->truncate_temp_data();
        $upload_date = date('Ymd');

        $fileName = $_FILES['upload_packing']['name'];
        if (empty($fileName)) {
            redirect($this->back_to_upload . $msg = 12);
        }

        $config['upload_path'] = './assets/file/target_production/';
        $config['file_name'] = $fileName;
        $config['allowed_types'] = 'xls|xlsx';
        $config['max_size'] = 10000;

        //code for upload with ci
        $this->load->library('upload');
        $this->upload->initialize($config);
        if ($a = $this->upload->do_upload('upload_packing'))
            $this->upload->display_errors();
        $media = $this->upload->data('upload_packing');
        $inputFileName = './assets/file/target_production/' . $media['file_name'];

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

        $rowHeader = $sheet->rangeToArray('A1:' . $highestColumn . '1', NULL, TRUE, FALSE);

        $bulan = $rowHeader[0][0];
        $tahun = $rowHeader[0][1];
        $line = $rowHeader[0][2];
        $targetdelivery = $rowHeader[0][3];
        $planshift = $rowHeader[0][4];

        if (trim($bulan) == 'BULAN' && trim($tahun) == 'TAHUN' && trim($line) == 'LINE' && trim($targetdelivery) == 'TARGET DELIVERY/DAY' && trim($planshift) == 'Plan Shift') {
            for ($row = 2; $row <= $highestRow; $row++) {
                $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);
                
                if (is_string($rowData[0][1]) || is_string($rowData[0][3]) || is_string($rowData[0][4])) {
                    redirect($this->back_to_upload . $msg = 16);
                }

                $rowData[0][0] = (int) $rowData[0][0];
                $rowData[0][1] = (int) $rowData[0][1];

                if (strlen($rowData[0][0]) == 1) {
                    $bulan = '0' . $rowData[0][0];
                } else {
                    $bulan = $rowData[0][0];
                }

                if ($rowData[0][4] == 0) {
                    $plan_shift = 1;
                } else {
                    $plan_shift = $rowData[0][4];
                }

                $data = array(
                    'INT_BULAN' => $rowData[0][0],
                    'INT_TAHUN' => $rowData[0][1],
                    'CHR_PERIOD' => $rowData[0][1] . $bulan,
                    'CHR_WORK_CENTER' => $rowData[0][2],
                    'INT_TT' => (7.5 * $plan_shift * 3600) / $rowData[0][3],
                    'INT_TARGET_DEL' => $rowData[0][3],
                    'INT_TARGET_PER_SHIFT' => $rowData[0][3] / $plan_shift,
                    'INT_PLAN_SHIFT' => $plan_shift,
                    'INT_QTY_PER_JAM_DELIVERY' => round($rowData[0][3] / ($plan_shift * 7.5), 2, PHP_ROUND_HALF_EVEN),
                    'CHR_CREATED_BY' => $this->session->userdata('USERNAME'),
                    'CHR_CREATED_TIME' => date('His'),
                    'CHR_CREATED_DATE' => $upload_date
                );

                $status_insert = $this->target_production_m->save_temp($data);

                $fail_insert = 0;
                if ($status_insert == 0) {
                    $fail_insert++;
                }
            }
            redirect($this->back_to_upload . $msg = 1);
        } else {
            redirect($this->back_to_upload . $msg = 15);
        }
    }

    function merge_target_production() {
        $this->target_production_m->save();
        $this->target_production_m->truncate_temp_data();
        redirect($this->back_to_manage . $msg = 1);
    }

    function reset() {
        $this->target_production_m->truncate_temp_data();
        redirect($this->back_to_manage);
    }

    function prepare_upload_target_production() {
        $this->target_production_m->truncate_temp_data();
        redirect($this->back_to_upload);
    }

}
