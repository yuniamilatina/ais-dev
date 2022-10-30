<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class pos_material_c extends CI_Controller
{

    private $layout = '/template/head';
    private $back_to_manage = 'prd/pos_material_c/index/';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('prd/pos_material_m');
        $this->load->model('prd/direct_backflush_general_m');
        $this->load->model('part/part_m');
        $this->load->model('prd/pos_m');
        $this->load->model('kanban/kanban_m');
        $this->load->model('organization/dept_m');
    }

    public function check_session()
    {
        $user_session = $this->session->all_userdata();
        if ($user_session['NPK'] == '') {
            redirect(base_url('index.php/login_c'));
        }
    }

    public function index($work_center = null, $msg = null)
    {
        $this->check_session();

        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Creating success </strong> The data is successfully created </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Updating success </strong> The data is successfully updated </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Deleted success </strong> The data is successfully deleted </div >";
        } elseif ($msg == 4) {
            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Choosing failed </strong> You must select at least one data</div >";
        } elseif ($msg == 12) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Executing error !</strong> Something error with parameter </div >";
        } elseif ($msg == 14) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Executing error !</strong> Something error with parameter </div >";
        }

        $data['msg'] = $msg;
        $data['title'] = 'Manage Pos Material';
        $data['content'] = 'prd/pos_material/manage_pos_material_v';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(49);
        $data['news'] = $this->news_m->get_news();

        if ($work_center == null || $work_center == '') {
            $work_center = $this->direct_backflush_general_m->get_top_work_center_using_samalona();
        }

        $all_work_centers = $this->direct_backflush_general_m->get_all_work_center_using_samalona();

        $data['all_work_centers'] = $all_work_centers;
        $data['work_center'] = $work_center;

        $data['data'] = $this->pos_material_m->get_data_pos_material_by_work_center($work_center);
        $this->load->view($this->layout, $data);
    }

    public function search_component()
    {
        $this->check_session();
        $user_session = $this->session->all_userdata();
        $this->load->library(array('sapconn'));

        $work_center = $this->input->post('CHR_WORK_CENTER');
        $part_no = $this->input->post('CHR_PART_NO');
        $backno = '';
        $img_backno = 'assets/img/pis_comp/noimage.jpg';

        $werks = '600';
        $capid = 'BEST';
        $stlal = '';
        $emeng = '1';

        $this->sapconn->connect();
        $bom_data = $this->part_m->get_data_part_component_by_part($part_no, $werks, $emeng, $capid);
        $this->sapconn->close();

        $this->part_m->delete_by_ip(gethostbyaddr($_SERVER['REMOTE_ADDR']));

        $i = 1;
        $y = 0;
        $x = 1;
        $flag = 0;

        foreach ($bom_data['detail'] as $row) {
            if ((int) substr($row['DGLVL'], '-1') == 1) {
                $flag = 0;
                if ($row['DUMPS'] != 'X') {
                    $qty = explode('.', $row['MNGLG']);
                    $part_no_comp = $row['DOBJT'];
                    $part_name = $row['OJTXP'];
                    $level = (int) substr($row['DGLVL'], '-1');
                    $qty = $qty[0];
                    $flg_phantom = $row['DUMPS'];
                    $data_kanban = $this->kanban_m->get_data_by_partno($part_no_comp);
                    if ($data_kanban->num_rows() > 0) {
                        $backno = $data_kanban->row()->CHR_BACK_NO;
                        if ($data_kanban->row()->CHR_IMAGE_PIS_URL != null || $data_kanban->row()->CHR_IMAGE_PIS_URL != '') {
                            $img_backno = $data_kanban->row()->CHR_IMAGE_PIS_URL;
                        }
                    } else {
                        $backno = $backno;
                        $img_backno = $img_backno;
                    }

                    //20181107, Wildan denny ,  ambil data pos prod jika sebelumnya sudah pernah di setting
                    $pos_material = $this->part_m->check_pos_material_non_sa($part_no, $part_no_comp, $work_center);
                    if (count($pos_material) > 0) {
                        $pos_prd = $pos_material->CHR_POS_PRD;
                        $ignore_scan = $pos_material->INT_FLG_IGNORE_SCAN;
                    } else {
                        $pos_prd = "";
                        $ignore_scan = 0;
                    }

                    // $data_insert_tw['INT_ID_DEPT'] = $id_dept;
                    $data_insert_tw['CHR_PART_NO'] = $part_no;
                    $data_insert_tw['CHR_WORK_CENTER'] = $work_center;
                    $data_insert_tw['CHR_PART_NO_COMP'] = $part_no_comp;
                    $data_insert_tw['CHR_PART_NAME'] = $part_name;
                    $data_insert_tw['CHR_LEVEL'] = $level;
                    $data_insert_tw['INT_QTY'] = $qty;
                    $data_insert_tw['CHR_FLG_PHANTOM'] = $flg_phantom;
                    $data_insert_tw['INT_FLG_IGNORE_SCAN'] = $ignore_scan;
                    $data_insert_tw['CHR_IP'] = gethostbyaddr($_SERVER['REMOTE_ADDR']);
                    $data_insert_tw['CHR_CREATED_BY'] = $user_session['NPK'];
                    $data_insert_tw['CHR_BACK_NO_COMP'] = $backno;
                    $data_insert_tw['CHR_IMAGE_PIS_URL'] = $img_backno;
                    //20181107, Wildan denny ,  ambil data pos prod jika sebelumnya sudah pernah di setting
                    $data_insert_tw['CHR_POS_PRD'] = $pos_prd;

                    $this->part_m->save($data_insert_tw);

                    $i++;
                    $y++;

                    $flag = (int) substr($row['DGLVL'], '-1');
                }
            } else {
                if ($flag >= (int) substr($row['DGLVL'], '-1') || $flag == 0) {

                    if ($row['DUMPS'] != 'X') {

                        $qty = explode('.', $row['MNGLG']);

                        $part_no_comp = $row['DOBJT'];
                        $part_name = $row['OJTXP'];
                        $level = (int) substr($row['DGLVL'], '-1');
                        $qty = $qty[0];
                        $flg_phantom = $row['DUMPS'];

                        $data_kanban = $this->kanban_m->get_data_by_partno($part_no_comp);

                        if ($data_kanban->num_rows() > 0) {
                            $backno = $data_kanban->row()->CHR_BACK_NO;
                            if ($data_kanban->row()->CHR_IMAGE_PIS_URL != null || $data_kanban->row()->CHR_IMAGE_PIS_URL != '') {
                                $img_backno = $data_kanban->row()->CHR_IMAGE_PIS_URL;
                            }
                        } else {
                            $backno = $backno;
                            $img_backno = $img_backno;
                        }

                        //20181107, Wildan denny ,  ambil data pos prod jika sebelumnya sudah pernah di setting
                        $pos_material = $this->part_m->check_pos_material_non_sa($part_no, $part_no_comp, $work_center);
                        if (count($pos_material) > 0) {
                            $pos_prd = $pos_material->CHR_POS_PRD;
                            $ignore_scan = $pos_material->INT_FLG_IGNORE_SCAN;
                        } else {
                            $pos_prd = "";
                            $ignore_scan = 0;
                        }

                        // $data_insert_tw['INT_ID_DEPT'] = $id_dept;
                        $data_insert_tw['CHR_PART_NO'] = $part_no;
                        $data_insert_tw['CHR_WORK_CENTER'] = $work_center;
                        $data_insert_tw['CHR_PART_NO_COMP'] = $part_no_comp;
                        $data_insert_tw['CHR_PART_NAME'] = $part_name;
                        $data_insert_tw['CHR_LEVEL'] = $level;
                        $data_insert_tw['INT_QTY'] = $qty;
                        $data_insert_tw['CHR_FLG_PHANTOM'] = $flg_phantom;
                        $data_insert_tw['INT_FLG_IGNORE_SCAN'] = $ignore_scan;
                        $data_insert_tw['CHR_IP'] = gethostbyaddr($_SERVER['REMOTE_ADDR']);
                        $data_insert_tw['CHR_CREATED_BY'] = $user_session['NPK'];
                        $data_insert_tw['CHR_BACK_NO_COMP'] = $backno;
                        $data_insert_tw['CHR_IMAGE_PIS_URL'] = $img_backno;
                        //20181107, Wildan denny ,  ambil data pos prod jika sebelumnya sudah pernah di setting
                        $data_insert_tw['CHR_POS_PRD'] = $pos_prd;

                        $this->part_m->save($data_insert_tw);

                        $i++;
                        $y++;

                        $flag = (int) substr($row['DGLVL'], '-1');
                    }
                    if ($flag == (int) substr($row['DGLVL'], '-1') and $row['DUMPS'] == 'X') {
                        $flag = 0;
                    }
                }
            }
        }

        $data['data_bom'] = $this->part_m->get_data_bom_by_ip(gethostbyaddr($_SERVER['REMOTE_ADDR']));
        //20181108, wildan denny ambil data SA yang sudah diassign
        $part_sa_from_existing = $this->part_m->get_part_sa($work_center, $part_no);
        if (count($part_sa_from_existing) > 0) {
            foreach ($part_sa_from_existing as $value) {
                //get data bom
                $data_bom = $this->part_m->get_data_existing_bom(trim($value->CHR_PART_NO_COMP));
                if (count($data_bom) > 0) {
                    $data_insert_tw['CHR_PART_NAME'] = $data_bom->CHR_PART_NAME;
                    $data_insert_tw['CHR_LEVEL'] = $data_bom->CHR_LEVEL;
                    $data_insert_tw['INT_QTY'] = $data_bom->INT_QTY;
                    $data_insert_tw['CHR_FLG_PHANTOM'] = $data_bom->CHR_FLG_PHANTOM;
                } else {
                    $data_insert_tw['CHR_PART_NAME'] = "NO DATA IN BOM - BOM UPDATED";
                }
                $data_insert_tw['CHR_PART_NO'] = $part_no;
                $data_insert_tw['CHR_WORK_CENTER'] = $work_center;
                $data_insert_tw['CHR_IP'] = gethostbyaddr($_SERVER['REMOTE_ADDR']);
                $data_insert_tw['CHR_CREATED_BY'] = $user_session['NPK'];
                $data_insert_tw['CHR_PART_NO_COMP'] = $value->CHR_PART_NO_COMP;
                $data_insert_tw['CHR_BACK_NO_COMP'] = $value->CHR_BACK_NO_COMP;
                $data_insert_tw['CHR_IMAGE_PIS_URL'] = $value->CHR_IMAGE_PIS_URL;
                $data_insert_tw['CHR_PART_NO_SA'] = $value->CHR_PART_NO_SA;
                $data_insert_tw['CHR_BACK_NO_SA'] = $value->CHR_BACK_NO_SA;
                $data_insert_tw['CHR_DESC_SA'] = $value->CHR_DESC_SA;
                $data_insert_tw['CHR_POS_PRD'] = $value->CHR_POS_PRD;
                $data_insert_tw['INT_FLG_IGNORE_SCAN'] = $value->INT_FLG_IGNORE_SCAN;
                $this->part_m->save($data_insert_tw);
            }
        }

        $msg = "";
        $data['msg'] = $msg;
        $data['title'] = 'Create pos_material';
        $data['content'] = 'prd/pos_material/mapping_pos_material_v';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(49);
        $data['news'] = $this->news_m->get_news();

        $data['part_no'] = $part_no;
        // $data['id_dept'] = $id_dept;
        $data['work_center'] = $work_center;

        // $data['all_dept_prod'] = $this->dept_m->get_all_prod_dept();
        $data['all_work_centers'] = $this->direct_backflush_general_m->get_all_work_center_ines();
        $data['data_part_no'] = $this->part_m->get_data_part_by_work_center($work_center);
        $data['data_pos'] = $this->pos_m->get_pos_by_work_center_and_part_no($work_center, $part_no);
        $data['pos'] = '1';

        $this->load->view($this->layout, $data);
    }

    public function create_pos_material($work_center = null)
    {
        $this->check_session();
        $msg = "";

        $data['msg'] = $msg;
        $data['title'] = 'Create pos_material';
        $data['content'] = 'prd/pos_material/mapping_pos_material_v';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(49);
        $data['news'] = $this->news_m->get_news();

        $data['all_work_centers'] = $this->direct_backflush_general_m->get_all_work_center_ines();
        $data['work_center'] = $work_center;

        $data['part_no'] = $this->part_m->get_top_part_by_work_center($data['work_center']);
        $data['data_part_no'] = $this->part_m->get_data_part_by_work_center($data['work_center']);

        $data['data_pos'] = $this->pos_m->get_pos_by_work_center_and_part_no($data['work_center'], $data['part_no']);

        $this->load->library(array('sapconn'));

        $part_no = $data['part_no'];
        $werks = '600';
        $capid = 'BEST';
        $stlal = '';
        $emeng = '1';

        $this->sapconn->connect();
        $bom_data = $this->part_m->get_data_part_component_by_part($part_no, $werks, $emeng, $capid);
        $this->sapconn->close();

        $data['data_bom'] = $bom_data;
        $data['data_bom'] = $this->part_m->get_data_bom_by_ip(gethostbyaddr($_SERVER['REMOTE_ADDR']));

        $this->load->view($this->layout, $data);
    }

    public function view_pos_material($id, $part_no, $work_center)
    {
        $this->check_session();
        $msg = "";

        $data['msg'] = $msg;
        $data['title'] = 'View pos_material';
        $data['content'] = 'prd/pos_material/view_pos_material_v';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(49);
        $data['news'] = $this->news_m->get_news();

        $data['work_center'] = $work_center;
        $data['part_no'] = $part_no;
        $data['data'] = $this->pos_material_m->get_data_pos_material_by_id($id);

        $this->load->view($this->layout, $data);
    }

    public function save_pos_material()
    {
        $tableRow = $this->input->post("tableRow");
        $user_session = $this->session->all_userdata();
        $work_center = $this->input->post("CHR_WORK_CENTER");
        $part_no_fg = $this->input->post("CHR_PART_NO_FG");
        $img_backno = 'assets/img/pis_comp/noimage.jpg';
        $pos_prd_arr = $this->input->post("CHR_POS_PRD");
        $flg_ignore_scan_arr = $this->input->post("INT_FLG_IGNORE_SCAN");

        //20181107 , wildan denny , ambil data tw_parts_bom untuk part no SA
        $this->pos_material_m->delete_pos_material($part_no_fg, $work_center);
        $tw_part_bom = $this->part_m->get_data_bom_by_ip(gethostbyaddr($_SERVER['REMOTE_ADDR']));
        foreach ($tw_part_bom as $value_bom) {

            //20181107 , wildan denny , ambil data gambar pis pada tm_kanban
            $data_kanban = $this->kanban_m->get_data_by_partno($value_bom->CHR_PART_NO_COMP);
            if ($data_kanban->num_rows() > 0) {
                if ($data_kanban->row()->CHR_IMAGE_PIS_URL != null || $data_kanban->row()->CHR_IMAGE_PIS_URL != '') {
                    $img_backno = $data_kanban->row()->CHR_IMAGE_PIS_URL;
                }
            }

            $part_no_comp = (trim($value_bom->CHR_PART_NO_COMP));
            $pos_prd = $pos_prd_arr[$part_no_comp];

            if (array_key_exists($part_no_comp, $flg_ignore_scan_arr)) {
                $ignore = 1;
            } else {
                $ignore = 0;
            }

            $id = $this->pos_m->get_id_by_pos_and_part_and_work_center($pos_prd, trim($value_bom->CHR_PART_NO), trim($value_bom->CHR_WORK_CENTER));
            $data['INT_ID_POS'] = $id;
            $data['CHR_WORK_CENTER'] = trim($value_bom->CHR_WORK_CENTER);
            $data['CHR_POS_PRD'] = $pos_prd;
            $data['CHR_PART_NO_FG'] = trim($value_bom->CHR_PART_NO);
            $data['CHR_PART_NO_COMP'] = trim($value_bom->CHR_PART_NO_COMP);
            $data['CHR_BACK_NO_COMP'] = trim($value_bom->CHR_BACK_NO_COMP);
            $data['CHR_IMAGE_PIS_URL'] = $img_backno;
            $data['INT_QTY_PCS'] = (int) trim($value_bom->INT_QTY);
            $data['INT_FLG_IGNORE_SCAN'] = $ignore;
            $data['CHR_CREATED_BY'] = $user_session['USERNAME'];
            $data['CHR_MODIFIED_BY'] = $user_session['USERNAME'];
            $data['CHR_MODIFIED_DATE'] = date('Ymd');
            $data['CHR_MODIFIED_TIME'] = date('His');

            $this->pos_material_m->save($data);
        }

        //20181107 , wildan denny , ambil data tw_parts_bom untuk part no SA
        $data = "";
        $part_no_sa = "";
        $tw_part_sa_bom = $this->part_m->get_data_bom_sa_by_ip(gethostbyaddr($_SERVER['REMOTE_ADDR']));

        if (count($tw_part_sa_bom) > 0) {
            foreach ($tw_part_sa_bom as $value_bom) {
                if ($part_no_sa != trim($value_bom->CHR_PART_NO_SA)) {
                    $id = $this->pos_m->get_id_by_pos_and_part_and_work_center($pos_prd, trim($value_bom->CHR_PART_NO), trim($value_bom->CHR_WORK_CENTER));
                    $data_sa['INT_ID_POS'] = $id;
                    $data_sa['CHR_WORK_CENTER'] = trim($value_bom->CHR_WORK_CENTER);
                    $data_sa['CHR_POS_PRD'] = $value_bom->CHR_POS_PRD;
                    $data_sa['CHR_PART_NO_FG'] = trim($value_bom->CHR_PART_NO);
                    $data_sa['CHR_PART_NO_COMP'] = trim($value_bom->CHR_PART_NO_COMP);
                    $data_sa['CHR_BACK_NO_COMP'] = trim($value_bom->CHR_BACK_NO_COMP);
                    $data_sa['CHR_PART_NO_SA'] = trim($value_bom->CHR_PART_NO_SA);
                    $data_sa['CHR_BACK_NO_SA'] = trim($value_bom->CHR_BACK_NO_SA);
                    $data_sa['CHR_DESC_SA'] = trim($value_bom->CHR_DESC_SA);
                    $data_sa['CHR_IMAGE_PIS_URL'] = trim($value_bom->CHR_IMAGE_PIS_URL);
                    $data_sa['INT_QTY_PCS'] = (int) trim($value_bom->INT_QTY);
                    $data_sa['INT_FLG_IGNORE_SCAN'] = $value_bom->INT_FLG_IGNORE_SCAN;
                    $data_sa['CHR_CREATED_BY'] = $user_session['USERNAME'];
                    $data_sa['CHR_MODIFIED_BY'] = $user_session['USERNAME'];
                    $data_sa['CHR_MODIFIED_DATE'] = date('Ymd');
                    $data_sa['CHR_MODIFIED_TIME'] = date('His');
                    $this->pos_material_m->save($data_sa);
                }

                $part_no_sa = trim($value_bom->CHR_PART_NO_SA);
                $data_sa_detail['CHR_WORK_CENTER'] = trim($value_bom->CHR_WORK_CENTER);
                $data_sa_detail['CHR_POS_PRD'] = $value_bom->CHR_POS_PRD;
                $data_sa_detail['CHR_PART_NO_FG'] = trim($value_bom->CHR_PART_NO);
                $data_sa_detail['CHR_PART_NO_SA'] = trim($value_bom->CHR_PART_NO_SA);
                $data_sa_detail['CHR_BACK_NO_SA'] = trim($value_bom->CHR_BACK_NO_SA);
                $data_sa_detail['CHR_PART_NO_COMP'] = trim($value_bom->CHR_PART_NO_COMP);
                $data_sa_detail['CHR_BACK_NO_COMP'] = trim($value_bom->CHR_BACK_NO_COMP);
                $data_sa_detail['CHR_MODIFIED_BY'] = $user_session['USERNAME'];
                $data_sa_detail['CHR_MODIFIED_DATE'] = date('Ymd');
                $data_sa_detail['CHR_MODIFIED_TIME'] = date('His');

                $this->pos_material_m->save_detail($data_sa_detail);
            }
        }
        redirect($this->back_to_manage . $work_center . '/1');
    }

    public function updating_pos_material()
    {
        $id = $this->input->post("INT_ID");
        $pos = $this->input->post("CHR_POS_PRD");
        $work_center = $this->input->post("CHR_WORK_CENTER");
        $user_session = $this->session->all_userdata();

        $data['CHR_POS_PRD'] = $pos;
        $data['CHR_MODIFIED_BY'] = $user_session['USERNAME'];
        $data['CHR_MODIFIED_DATE'] = date('Ymd');
        $data['CHR_MODIFIED_TIME'] = date('His');

        $id_data['INT_ID'] = $id;

        $this->pos_material_m->update($data, $id_data);

        redirect($this->back_to_manage . $work_center . '/' . $msg = 2);
    }

    public function delete_pos_material($id, $work_center)
    {
        $this->pos_material_m->delete($id);

        redirect($this->back_to_manage . $work_center . '/' . $msg = 3);
    }

    public function get_pos_by_work_center_and_part()
    {
        $pos = $this->input->post("CHR_POS_PRD");
        $part_no = $this->input->post("CHR_PART_NO");
        $work_center = $this->input->post("CHR_WORK_CENTER");

        $data_pos = $this->pos_m->get_pos_by_work_center_and_part($work_center, $part_no);

        $data = '';

        foreach ($data_pos as $row) {
            if (trim($pos) == trim($row->CHR_POS_PRD)) {
                $data .= "<option selected value='$row->CHR_POS_PRD'>" . $row->CHR_POS_PRD . "</option>";
            } else {
                $data .= "<option value='$row->CHR_POS_PRD'>" . $row->CHR_POS_PRD . "</option>";
            }
        }

        $json_data = array('data' => $data);

        echo json_encode($json_data);
    }


    //20181107 , wildan denny, add part sa to TW
    public function add_part_sa_tw()
    {
        $session = $this->session->all_userdata();
        $user = $session['NPK'];
        $desc = $this->input->post("description_sa");
        $pos = $this->input->post("pos_sa");
        $flg_ignore = $this->input->post("INT_FLG_IGNORE_SCAN");
        $work_center = $this->input->post("CHR_WORK_CENTER");
        $part_no = $this->input->post("CHR_PART_NO_FG");
        $db_sa_arr = $this->input->post("cb_part_sa");
        $tw_part_bom = $this->part_m->get_data_bom_by_ip(gethostbyaddr($_SERVER['REMOTE_ADDR']));
        $part_no_sa = "";
        $back_no_sa = "";

        if (count($db_sa_arr) > 0) {
            foreach ($tw_part_bom as $value) {
                $part_no_comp = trim($value->CHR_PART_NO_COMP);
                $cb_sa_stat = $db_sa_arr[$part_no_comp];
                if ($cb_sa_stat == 1) {
                    $part_no_sa .= trim($value->CHR_PART_NO_COMP) . "#";
                    $back_no_sa .= trim($value->CHR_BACK_NO_COMP) . "#";
                }
            }
        }

        $fileName = str_replace("#", "-", $back_no_sa) . ".jpg";
        //movement gambar SA
        $source_file = $_SERVER['DOCUMENT_ROOT'] . "AIS_PP/assets/img/temp/$user/pis.jpg";
        $destination_path = $_SERVER['DOCUMENT_ROOT'] . "AIS_PP/assets/img/pis_sa/";
        rename($source_file, $destination_path . $fileName);

        foreach ($tw_part_bom as $value) {
            $part_no_comp = trim($value->CHR_PART_NO_COMP);
            $cb_sa_stat = $db_sa_arr[$part_no_comp];
            if ($cb_sa_stat == 1) {
                // $data_insert_tw['INT_ID_DEPT'] = $id_dept;
                $data_insert_tw['CHR_PART_NO'] = $part_no;
                $data_insert_tw['CHR_WORK_CENTER'] = $work_center;
                $data_insert_tw['CHR_PART_NO_COMP'] = $part_no_comp;
                $data_insert_tw['CHR_PART_NO_SA'] = $part_no_sa;
                $data_insert_tw['CHR_BACK_NO_SA'] = $back_no_sa;
                $data_insert_tw['CHR_DESC_SA'] = $desc;
                $data_insert_tw['CHR_PART_NAME'] = $value->CHR_PART_NAME;
                $data_insert_tw['CHR_LEVEL'] = $value->CHR_LEVEL;
                $data_insert_tw['INT_QTY'] = $value->INT_QTY;
                $data_insert_tw['CHR_FLG_PHANTOM'] = $value->CHR_FLG_PHANTOM;
                $data_insert_tw['CHR_IP'] = gethostbyaddr($_SERVER['REMOTE_ADDR']);
                $data_insert_tw['CHR_CREATED_BY'] = $session['NPK'];
                $data_insert_tw['CHR_BACK_NO_COMP'] = $value->CHR_BACK_NO_COMP;
                $data_insert_tw['INT_FLG_IGNORE_SCAN'] = $flg_ignore;
                $data_insert_tw['CHR_IMAGE_PIS_URL'] = "assets/img/pis_sa/" . $fileName;
                //20181107, Wildan denny ,  ambil data pos prod jika sebelumnya sudah pernah di setting
                $data_insert_tw['CHR_POS_PRD'] = $pos;
                $this->part_m->save($data_insert_tw);
            }
        }
    }

    //20190222, wildan denny , edit s/a image
    public function edit_part_sa_tw()
    {
        $session = $this->session->all_userdata();
        $user = $session['NPK'];
        $desc = $this->input->post("description_sa");
        $pos = $this->input->post("pos_sa");
        $work_center = $this->input->post("CHR_WORK_CENTER");
        $part_no = $this->input->post("CHR_PART_NO_FG");
        $back_no_sa = $this->input->post("CHR_BACK_NO_SA");

        $fileName = str_replace("#", "-", $back_no_sa) . ".jpg";

        //movement gambar SA
        $source_file = $_SERVER['DOCUMENT_ROOT'] . "AIS_PP/assets/img/temp/$user/pis.jpg";
        $destination_path = $_SERVER['DOCUMENT_ROOT'] . "AIS_PP/assets/img/pis_sa/";
        rename($source_file, $destination_path . $fileName);

        echo $fileName;
    }

    public function select_part_sa()
    {
        $work_center = trim($this->input->post("work_center"));
        $part_no = trim($this->input->post("part_no"));
        $html = "";
        $part_no_sa = "";
        $no = 0;

        //ambil part sa yang sudah diassign
        $part_sa_from_existing = $this->part_m->get_part_sa_tw($work_center, $part_no);
        if (count($part_sa_from_existing) > 0) {
            foreach ($part_sa_from_existing as $value) {
                //hitung part comp sa
                if ($part_no_sa != trim($value->CHR_PART_NO_SA)) {
                    $part_no_sa = trim($value->CHR_PART_NO_SA);
                    $count_pn_comp = 0;
                    foreach ($part_sa_from_existing as $value_sa) {
                        if ($part_no_sa == trim($value_sa->CHR_PART_NO_SA)) {
                            $count_pn_comp++;
                        }
                    }
                    $no++;

                    if ($value_sa->INT_FLG_IGNORE_SCAN == 1) {
                        $flg_ignore = 'checked';
                    } else {
                        $flg_ignore = 'unchecked';
                    }

                    $html .= '<tr>
                                        <td rowspan="' . $count_pn_comp . '" style="text-align:center;vertical-align: middle;background-color:#FFF;">' . $no . '</td>
                                        <td rowspan="' . $count_pn_comp . '"  style="text-align:center;vertical-align: middle;background-color:#FFF;border-right: 1px #DDDDDD solid;" onclick="editImageSubAsyy(\'' . $value->CHR_PART_NO_SA . '\')"><img src="' . base_url() . $value->CHR_IMAGE_PIS_URL . '?_=' . rand(10, 1000) . '" style="max-width:200px;max-height:200px;" ><br>' . $value->CHR_DESC_SA . '</td>
                                        <td style="text-align:center;vertical-align: middle;">' . $value->CHR_PART_NO_COMP . '</td>
                                        <td style="text-align:center;vertical-align: middle;">' . $value->CHR_BACK_NO_COMP . '</td>
                                        <td style="text-align:left;vertical-align: middle;">' . trim($value->CHR_PART_NAME) . '</td>
                                        <td rowspan="' . $count_pn_comp . '" style="text-align:center;vertical-align: middle;background-color:#FFF;border-left: 1px #DDDDDD solid;"><input disabled type="checkbox" value="'.$value->INT_FLG_IGNORE_SCAN.'" '.$flg_ignore.' class="icheck"></td>
                                        <td rowspan="' . $count_pn_comp . '" style="text-align:center;vertical-align: middle;background-color:#FFF;border-left: 1px #DDDDDD solid;">' . $value->CHR_POS_PRD . '</td>
                                        <td rowspan="' . $count_pn_comp . '" style="text-align:center;vertical-align: middle;background-color:#FFF;border-left: 1px #DDDDDD solid;">
                                            <span  class="label label-danger" data-placement="right" data-toggle="tooltip" title="Delete" onclick="delete_material_sa(\'' . $part_no_sa . '\')"><span class="fa fa-times"></span></span>
                                        </td>
                                    </tr>';
                } else {
                    $html .= '<tr>
                                        <td style="text-align:center;vertical-align: middle;">' . $value->CHR_PART_NO_COMP . '</td>
                                        <td style="text-align:center;vertical-align: middle;">' . $value->CHR_BACK_NO_COMP . '</td>
                                        <td style="text-align:left;vertical-align: middle;">' . $value->CHR_PART_NAME . '</td>
                              </tr>';
                }
            }
        }
        echo $html;
    }

    public function delete_material_sa()
    {
        $work_center = trim($this->input->post("work_center"));
        $part_no = trim($this->input->post("part_no"));
        $part_no_sa = trim($this->input->post("part_no_sa"));

        $this->part_m->delete_material_sa($part_no, $work_center, $part_no_sa);
    }

    public function delete_pis_sa_user()
    {
        $session = $this->session->all_userdata();
        $user = $session['NPK'];
        //delete all file on temp user upload
        $files = glob($_SERVER['DOCUMENT_ROOT'] . "AIS_PP/assets/img/temp/$user/*");
        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }
    }

    public function upload_pis_sa()
    {
        $session = $this->session->all_userdata();
        $user = $session['NPK'];
        $upload_date = date('Ymd');
        $upload_time = date('His');

        //cek folder temp untuk user
        $path = "assets/img/temp/$user";
        if (!is_dir($path)) { //create the folder if it's not already exists
            mkdir($path, 0755, true);
        }

        //delete all file on temp user upload
        $files = glob($_SERVER['DOCUMENT_ROOT'] . "AIS_PP/assets/img/temp/$user/*");
        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }

        //upload gambar SA
        $this->load->library('upload');
        $fileName = "pis.jpg";

        $config = array(
            'upload_path' => $path,
            'allowed_types' => "gif|JPG|jpg|png|jpeg",
            'max_size' => "2048000",
            'file_name' => $fileName
        );
        //code for upload with ci
        $this->upload->initialize($config);
        //upload file to directory
        $this->upload->do_upload('userfile');
    }

    //get part no sa
    public function get_detail_part_no_sa()
    {

        $work_center = trim($this->input->post("work_center"));
        $part_no = trim($this->input->post("part_no"));
        $part_no_sa = trim($this->input->post("part_no_sa"));

        // //get from tw
        $detail_sa = $this->part_m->get_sa_detail($work_center, $part_no, $part_no_sa);

        echo json_encode($detail_sa);
    }

    public function get_log_pos_material_uncomplete($msg = null)
    {
        $this->load->model('prd/pis_pos_material_m');

        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Update success </strong> The data is successfully Completed </div >";
        }

        $data['msg'] = $msg;
        $data['title'] = 'Manage Log Pos Material';
        $data['content'] = 'prd/pos_material/manage_pos_material_log_v';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(336);
        $data['news'] = $this->news_m->get_news();

        // if($work_center == null){
        //     $work_center = $this->direct_backflush_general_m->get_top_work_center_using_samalona();
        // }

        // $data['all_work_centers'] = $this->direct_backflush_general_m->get_all_work_center_using_samalona();
        // $data['work_center'] = $work_center;

        $data['data'] = $this->pis_pos_material_m->get_data_uncomplete_pos_material();
        $this->load->view($this->layout, $data);
    }

    public function complete_pos_material($work_center, $pos)
    {
        $this->load->model('prd/pis_pos_material_m');

        $this->pis_pos_material_m->update_log_pos_material($work_center, $pos);

        redirect('prd/pos_material_c/get_log_pos_material_uncomplete/' . $work_center . '/' . $msg = 1);
    }
}
