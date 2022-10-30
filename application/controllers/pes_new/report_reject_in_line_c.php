<?php

class Report_reject_in_line_c extends CI_Controller
{
    private $layout = '/template/head';
    private $layout_blank = '/template/head_blank';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('prd/group_line_m');
        $this->load->model('pes_new/production_result_m');
    }

    public function index()
    {
        $data['title'] = 'Report Productivity';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(148);
        $data['news'] = $this->news_m->get_news();
        $data['content'] = 'pes_new/report_reject_in_line_v';

        $date = date('Y') . date('m');

        $id_product_group = $this->group_line_m->get_top_prod_group_product()->row()->INT_ID;

        $data['data_reject_in_line'] = $this->production_result_m->select_data_reject_in_line($date, $id_product_group);
        $data['data_date_update'] = $this->production_result_m->get_date_time_update_merging_reject_in_line($date, $id_product_group);

        $data['detail_reject_in_line'] = $this->production_result_m->select_data_detail_reject_in_line($date, $id_product_group);
        $data['detail_date_update'] = $this->production_result_m->get_date_time_update_merging_production_result($date, $id_product_group);

        $data['all_product_group'] = $this->group_line_m->get_all_prod_group_product_custom();
        $data['selected_date'] = $date;
        $data['id_product_group'] = $id_product_group;

        $data['first_sunday'] = $this->firstSunday(substr($date, 0, 4) . '-' . substr($date, 4, 2));
        $data['first_saturday'] = $this->firstSaturday(substr($date, 0, 4) . '-' . substr($date, 4, 2));

        $this->load->view($this->layout, $data);
    }

    public function filter_by($date = '', $id_product_group = '')
    {
        $data['content'] = 'pes_new/report_reject_in_line_v';
        $data['title'] = 'Report Reject In Line';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(148);
        $data['news'] = $this->news_m->get_news();

        $data['data_reject_in_line'] = $this->production_result_m->select_data_reject_in_line($date, $id_product_group);
        $data['data_date_update'] = $this->production_result_m->get_date_time_update_merging_reject_in_line($date, $id_product_group);

        $data['detail_reject_in_line'] = $this->production_result_m->select_data_detail_reject_in_line($date, $id_product_group);
        $data['detail_date_update'] = $this->production_result_m->get_date_time_update_merging_production_result($date, $id_product_group);

        $data['all_product_group'] = $this->group_line_m->get_all_prod_group_product_custom();
        $data['selected_date'] = $date;
        $data['id_product_group'] = $id_product_group;

        $data['first_sunday'] = $this->firstSunday(substr($date, 0, 4) . '-' . substr($date, 4, 2));
        $data['first_saturday'] = $this->firstSaturday(substr($date, 0, 4) . '-' . substr($date, 4, 2));

        $this->load->view($this->layout, $data);
    }

    function detail_ril($date = '', $id_product_group = '')
    {
        $data['detail_reject_in_line'] = $this->production_result_m->select_data_detail_reject_in_line($date, $id_product_group);
        $data['content'] = 'pes_new/detail_reject_in_line_v';
        $this->load->view($this->layout_blank, $data);
    }

    function firstSunday($date)
    {
        for ($day = 1; $day <= 7; $day++) {
            $dd = strftime("%A", strtotime($date . '-' . $day));
            if ($dd == 'Sunday') {
                return strftime("%Y-%m-%d", strtotime($date . '-' . $day));
            }
        }
    }

    function firstSaturday($date)
    {
        for ($day = 1; $day <= 7; $day++) {
            $dd = strftime("%A", strtotime($date . '-' . $day));
            if ($dd == 'Saturday') {
                return strftime("%Y-%m-%d", strtotime($date . '-' . $day));
            }
        }
    }

    function get_chart_ril($date)
    {
        $data['content'] = 'pes_new/chart_amount_daily_ril_fiscal_v';

        $data['Setup'] = 'checked';
        $data['Process'] = 'checked';
        $data['Trial'] = 'checked';
        $data['BrokenTest'] = 'checked';
        $data['period'] = $date;

        $data['lastUpdate'] = $this->production_result_m->getLastMergeProductionResult();
        $data['ril_per_workcenter'] = $this->production_result_m->select_ril_by_period($date);

        $data['dt'] = $this->production_result_m->query_chart_daily_ril_by_date($date, 1)->row_array();
        $data['bp'] = $this->production_result_m->query_chart_daily_ril_by_date($date, 2)->row_array();
        $data['dl'] = $this->production_result_m->query_chart_daily_ril_by_date($date, 3)->row_array();
        $data['df'] = $this->production_result_m->query_chart_daily_ril_by_date($date, 4)->row_array();
        $data['ma'] = $this->production_result_m->query_chart_daily_ril_by_date($date, 5)->row_array();
        $data['ep'] = $this->production_result_m->query_chart_daily_ril_by_date($date, 6)->row_array();
        $data['all'] = $this->production_result_m->query_chart_daily_ril_by_date_all($date)->row_array();

        $this->load->view($this->layout_blank, $data);
    }

    function chart_fiscal_ril_amount($date)
    {
        $data['content'] = 'pes_new/chart_amount_ril_fiscal_v';

        $data['Setup'] = 'checked';
        $data['Process'] = 'checked';
        $data['Trial'] = 'checked';
        $data['BrokenTest'] = 'checked';
        $data['period'] = $date;

        $data['lastUpdate'] = $this->production_result_m->getLastMergeProductionResult();
        $data['up'] = $this->production_result_m->query_chart_ril_by_fiscal($date, 1)->row_array();
        $data['bp'] = $this->production_result_m->query_chart_ril_by_fiscal($date, 2)->row_array();
        $data['dl'] = $this->production_result_m->query_chart_ril_by_fiscal($date, 3)->row_array();
        $data['df'] = $this->production_result_m->query_chart_ril_by_fiscal($date, 4)->row_array();
        $data['ma'] = $this->production_result_m->query_chart_ril_by_fiscal($date, 5)->row_array();
        $data['all'] = $this->production_result_m->query_chart_ril_by_fiscal_all($date)->row_array();

        $this->load->view($this->layout_blank, $data);
    }

    function chart_fiscal_ril($date)
    {
        $data['content'] = 'pes_new/chart_qty_ril_fiscal_v';

        $data['Setup'] = 'checked';
        $data['Process'] = 'checked';
        $data['Trial'] = 'checked';
        $data['BrokenTest'] = 'checked';
        $data['period'] = $date;

        $data['lastUpdate'] = $this->production_result_m->getLastMergeProductionResult();
        $data['up'] = $this->production_result_m->query_chart_ril_by_fiscal($date, 1)->row_array();
        $data['bp'] = $this->production_result_m->query_chart_ril_by_fiscal($date, 2)->row_array();
        $data['dl'] = $this->production_result_m->query_chart_ril_by_fiscal($date, 3)->row_array();
        $data['df'] = $this->production_result_m->query_chart_ril_by_fiscal($date, 4)->row_array();
        $data['ma'] = $this->production_result_m->query_chart_ril_by_fiscal($date, 5)->row_array();
        $data['all'] = $this->production_result_m->query_chart_ril_by_fiscal_all($date)->row_array();

        $this->load->view($this->layout_blank, $data);
    }

    function search_day_amount_by()
    {
        $date = $this->input->post('period');
        $data['period'] = $this->input->post('period');
        $type = NULL;

        if ($this->input->post('Setup') != '') {
            $data['Setup'] = 'checked';
            $type[] = $this->input->post('Setup');
        } else {
            $data['Setup'] = '';
        }
        if ($this->input->post('Process') != '') {
            $data['Process'] = 'checked';
            $type[] = $this->input->post('Process');
        } else {
            $data['Process'] = '';
        }
        if ($this->input->post('Trial') != '') {
            $data['Trial'] = 'checked';
            $type[] = $this->input->post('Trial');
        } else {
            $data['Trial'] = '';
        }
        if ($this->input->post('BrokenTest') != '') {
            $data['BrokenTest'] = 'checked';
            $type[] = $this->input->post('BrokenTest');
        } else {
            $data['BrokenTest'] = '';
        }

        $data['content'] = 'pes_new/chart_amount_daily_ril_fiscal_v';

        $noqty1 = 0;
        $noqty2 = 0;
        $noqty3 = 0;
        $noqty4 = 0;
        $noqty5 = 0;
        $noqty6 = 0;
        $noqty7 = 0;
        $noqty8 = 0;
        $noqty9 = 0;
        $noqty10 = 0;
        $noqty11 = 0;
        $noqty12 = 0;
        $noqty13 = 0;
        $noqty14 = 0;
        $noqty15 = 0;
        $noqty16 = 0;
        $noqty17 = 0;
        $noqty18 = 0;
        $noqty19 = 0;
        $noqty20 = 0;
        $noqty21 = 0;
        $noqty22 = 0;
        $noqty23 = 0;
        $noqty24 = 0;
        $noqty25 = 0;
        $noqty26 = 0;
        $noqty27 = 0;
        $noqty28 = 0;
        $noqty29 = 0;
        $noqty30 = 0;
        $noqty31 = 0;

        for ($x = 0; $x < count($type); $x++) {

            $row = $this->production_result_m->get_daily_ril_by_period_and_type($type[$x], $date, 1)->row();

            $noqty1 = $noqty1 + $row->ANG_1;
            $noqty2 = $noqty2 + $row->ANG_2;
            $noqty3 = $noqty3 + $row->ANG_3;
            $noqty4 = $noqty4 + $row->ANG_4;
            $noqty5 = $noqty5 + $row->ANG_5;
            $noqty6 = $noqty6 + $row->ANG_6;
            $noqty7 = $noqty7 + $row->ANG_7;
            $noqty8 = $noqty8 + $row->ANG_8;
            $noqty9 = $noqty9 + $row->ANG_9;
            $noqty10 = $noqty10 + $row->ANG_10;
            $noqty11 = $noqty11 + $row->ANG_11;
            $noqty12 = $noqty12 + $row->ANG_12;
            $noqty13 = $noqty13 + $row->ANG_13;
            $noqty14 = $noqty14 + $row->ANG_14;
            $noqty15 = $noqty15 + $row->ANG_15;
            $noqty16 = $noqty16 + $row->ANG_16;
            $noqty17 = $noqty17 + $row->ANG_17;
            $noqty18 = $noqty18 + $row->ANG_18;
            $noqty19 = $noqty19 + $row->ANG_19;
            $noqty20 = $noqty20 + $row->ANG_20;
            $noqty21 = $noqty21 + $row->ANG_21;
            $noqty22 = $noqty22 + $row->ANG_22;
            $noqty23 = $noqty23 + $row->ANG_23;
            $noqty24 = $noqty24 + $row->ANG_24;
            $noqty25 = $noqty25 + $row->ANG_25;
            $noqty26 = $noqty26 + $row->ANG_26;
            $noqty27 = $noqty27 + $row->ANG_27;
            $noqty28 = $noqty28 + $row->ANG_28;
            $noqty29 = $noqty29 + $row->ANG_29;
            $noqty30 = $noqty30 + $row->ANG_30;
            $noqty31 = $noqty31 + $row->ANG_31;
        }

        $data['dt'] = array(
            'ANG_1' => $noqty1,
            'ANG_2' => $noqty2,
            'ANG_3' => $noqty3,
            'ANG_4' => $noqty4,
            'ANG_5' => $noqty5,
            'ANG_6' => $noqty6,
            'ANG_7' => $noqty7,
            'ANG_8' => $noqty8,
            'ANG_9' => $noqty9,
            'ANG_10' => $noqty10,
            'ANG_11' => $noqty11,
            'ANG_12' => $noqty12,
            'ANG_13' => $noqty13,
            'ANG_14' => $noqty14,
            'ANG_15' => $noqty15,
            'ANG_16' => $noqty16,
            'ANG_17' => $noqty17,
            'ANG_18' => $noqty18,
            'ANG_19' => $noqty19,
            'ANG_20' => $noqty20,
            'ANG_21' => $noqty21,
            'ANG_22' => $noqty22,
            'ANG_23' => $noqty23,
            'ANG_24' => $noqty24,
            'ANG_25' => $noqty25,
            'ANG_26' => $noqty26,
            'ANG_27' => $noqty27,
            'ANG_28' => $noqty28,
            'ANG_29' => $noqty29,
            'ANG_30' => $noqty30,
            'ANG_31' => $noqty31,
        );

        $noqty1 = 0;
        $noqty2 = 0;
        $noqty3 = 0;
        $noqty4 = 0;
        $noqty5 = 0;
        $noqty6 = 0;
        $noqty7 = 0;
        $noqty8 = 0;
        $noqty9 = 0;
        $noqty10 = 0;
        $noqty11 = 0;
        $noqty12 = 0;
        $noqty13 = 0;
        $noqty14 = 0;
        $noqty15 = 0;
        $noqty16 = 0;
        $noqty17 = 0;
        $noqty18 = 0;
        $noqty19 = 0;
        $noqty20 = 0;
        $noqty21 = 0;
        $noqty22 = 0;
        $noqty23 = 0;
        $noqty24 = 0;
        $noqty25 = 0;
        $noqty26 = 0;
        $noqty27 = 0;
        $noqty28 = 0;
        $noqty29 = 0;
        $noqty30 = 0;
        $noqty31 = 0;

        for ($x = 0; $x < count($type); $x++) {

            $row = $this->production_result_m->get_daily_ril_by_period_and_type($type[$x], $date, 2)->row();

            $noqty1 = $noqty1 + $row->ANG_1;
            $noqty2 = $noqty2 + $row->ANG_2;
            $noqty3 = $noqty3 + $row->ANG_3;
            $noqty4 = $noqty4 + $row->ANG_4;
            $noqty5 = $noqty5 + $row->ANG_5;
            $noqty6 = $noqty6 + $row->ANG_6;
            $noqty7 = $noqty7 + $row->ANG_7;
            $noqty8 = $noqty8 + $row->ANG_8;
            $noqty9 = $noqty9 + $row->ANG_9;
            $noqty10 = $noqty10 + $row->ANG_10;
            $noqty11 = $noqty11 + $row->ANG_11;
            $noqty12 = $noqty12 + $row->ANG_12;
            $noqty13 = $noqty13 + $row->ANG_13;
            $noqty14 = $noqty14 + $row->ANG_14;
            $noqty15 = $noqty15 + $row->ANG_15;
            $noqty16 = $noqty16 + $row->ANG_16;
            $noqty17 = $noqty17 + $row->ANG_17;
            $noqty18 = $noqty18 + $row->ANG_18;
            $noqty19 = $noqty19 + $row->ANG_19;
            $noqty20 = $noqty20 + $row->ANG_20;
            $noqty21 = $noqty21 + $row->ANG_21;
            $noqty22 = $noqty22 + $row->ANG_22;
            $noqty23 = $noqty23 + $row->ANG_23;
            $noqty24 = $noqty24 + $row->ANG_24;
            $noqty25 = $noqty25 + $row->ANG_25;
            $noqty26 = $noqty26 + $row->ANG_26;
            $noqty27 = $noqty27 + $row->ANG_27;
            $noqty28 = $noqty28 + $row->ANG_28;
            $noqty29 = $noqty29 + $row->ANG_29;
            $noqty30 = $noqty30 + $row->ANG_30;
            $noqty31 = $noqty31 + $row->ANG_31;
        }

        $data['bp'] = array(
            'ANG_1' => $noqty1,
            'ANG_2' => $noqty2,
            'ANG_3' => $noqty3,
            'ANG_4' => $noqty4,
            'ANG_5' => $noqty5,
            'ANG_6' => $noqty6,
            'ANG_7' => $noqty7,
            'ANG_8' => $noqty8,
            'ANG_9' => $noqty9,
            'ANG_10' => $noqty10,
            'ANG_11' => $noqty11,
            'ANG_12' => $noqty12,
            'ANG_13' => $noqty13,
            'ANG_14' => $noqty14,
            'ANG_15' => $noqty15,
            'ANG_16' => $noqty16,
            'ANG_17' => $noqty17,
            'ANG_18' => $noqty18,
            'ANG_19' => $noqty19,
            'ANG_20' => $noqty20,
            'ANG_21' => $noqty21,
            'ANG_22' => $noqty22,
            'ANG_23' => $noqty23,
            'ANG_24' => $noqty24,
            'ANG_25' => $noqty25,
            'ANG_26' => $noqty26,
            'ANG_27' => $noqty27,
            'ANG_28' => $noqty28,
            'ANG_29' => $noqty29,
            'ANG_30' => $noqty30,
            'ANG_31' => $noqty31,
        );

        $noqty1 = 0;
        $noqty2 = 0;
        $noqty3 = 0;
        $noqty4 = 0;
        $noqty5 = 0;
        $noqty6 = 0;
        $noqty7 = 0;
        $noqty8 = 0;
        $noqty9 = 0;
        $noqty10 = 0;
        $noqty11 = 0;
        $noqty12 = 0;
        $noqty13 = 0;
        $noqty14 = 0;
        $noqty15 = 0;
        $noqty16 = 0;
        $noqty17 = 0;
        $noqty18 = 0;
        $noqty19 = 0;
        $noqty20 = 0;
        $noqty21 = 0;
        $noqty22 = 0;
        $noqty23 = 0;
        $noqty24 = 0;
        $noqty25 = 0;
        $noqty26 = 0;
        $noqty27 = 0;
        $noqty28 = 0;
        $noqty29 = 0;
        $noqty30 = 0;
        $noqty31 = 0;

        for ($x = 0; $x < count($type); $x++) {

            $row = $this->production_result_m->get_daily_ril_by_period_and_type($type[$x], $date, 3)->row();

            $noqty1 = $noqty1 + $row->ANG_1;
            $noqty2 = $noqty2 + $row->ANG_2;
            $noqty3 = $noqty3 + $row->ANG_3;
            $noqty4 = $noqty4 + $row->ANG_4;
            $noqty5 = $noqty5 + $row->ANG_5;
            $noqty6 = $noqty6 + $row->ANG_6;
            $noqty7 = $noqty7 + $row->ANG_7;
            $noqty8 = $noqty8 + $row->ANG_8;
            $noqty9 = $noqty9 + $row->ANG_9;
            $noqty10 = $noqty10 + $row->ANG_10;
            $noqty11 = $noqty11 + $row->ANG_11;
            $noqty12 = $noqty12 + $row->ANG_12;
            $noqty13 = $noqty13 + $row->ANG_13;
            $noqty14 = $noqty14 + $row->ANG_14;
            $noqty15 = $noqty15 + $row->ANG_15;
            $noqty16 = $noqty16 + $row->ANG_16;
            $noqty17 = $noqty17 + $row->ANG_17;
            $noqty18 = $noqty18 + $row->ANG_18;
            $noqty19 = $noqty19 + $row->ANG_19;
            $noqty20 = $noqty20 + $row->ANG_20;
            $noqty21 = $noqty21 + $row->ANG_21;
            $noqty22 = $noqty22 + $row->ANG_22;
            $noqty23 = $noqty23 + $row->ANG_23;
            $noqty24 = $noqty24 + $row->ANG_24;
            $noqty25 = $noqty25 + $row->ANG_25;
            $noqty26 = $noqty26 + $row->ANG_26;
            $noqty27 = $noqty27 + $row->ANG_27;
            $noqty28 = $noqty28 + $row->ANG_28;
            $noqty29 = $noqty29 + $row->ANG_29;
            $noqty30 = $noqty30 + $row->ANG_30;
            $noqty31 = $noqty31 + $row->ANG_31;
        }

        $data['dl'] = array(
            'ANG_1' => $noqty1,
            'ANG_2' => $noqty2,
            'ANG_3' => $noqty3,
            'ANG_4' => $noqty4,
            'ANG_5' => $noqty5,
            'ANG_6' => $noqty6,
            'ANG_7' => $noqty7,
            'ANG_8' => $noqty8,
            'ANG_9' => $noqty9,
            'ANG_10' => $noqty10,
            'ANG_11' => $noqty11,
            'ANG_12' => $noqty12,
            'ANG_13' => $noqty13,
            'ANG_14' => $noqty14,
            'ANG_15' => $noqty15,
            'ANG_16' => $noqty16,
            'ANG_17' => $noqty17,
            'ANG_18' => $noqty18,
            'ANG_19' => $noqty19,
            'ANG_20' => $noqty20,
            'ANG_21' => $noqty21,
            'ANG_22' => $noqty22,
            'ANG_23' => $noqty23,
            'ANG_24' => $noqty24,
            'ANG_25' => $noqty25,
            'ANG_26' => $noqty26,
            'ANG_27' => $noqty27,
            'ANG_28' => $noqty28,
            'ANG_29' => $noqty29,
            'ANG_30' => $noqty30,
            'ANG_31' => $noqty31,
        );

        $noqty1 = 0;
        $noqty2 = 0;
        $noqty3 = 0;
        $noqty4 = 0;
        $noqty5 = 0;
        $noqty6 = 0;
        $noqty7 = 0;
        $noqty8 = 0;
        $noqty9 = 0;
        $noqty10 = 0;
        $noqty11 = 0;
        $noqty12 = 0;
        $noqty13 = 0;
        $noqty14 = 0;
        $noqty15 = 0;
        $noqty16 = 0;
        $noqty17 = 0;
        $noqty18 = 0;
        $noqty19 = 0;
        $noqty20 = 0;
        $noqty21 = 0;
        $noqty22 = 0;
        $noqty23 = 0;
        $noqty24 = 0;
        $noqty25 = 0;
        $noqty26 = 0;
        $noqty27 = 0;
        $noqty28 = 0;
        $noqty29 = 0;
        $noqty30 = 0;
        $noqty31 = 0;

        for ($x = 0; $x < count($type); $x++) {

            $row = $this->production_result_m->get_daily_ril_by_period_and_type($type[$x], $date, 4)->row();

            $noqty1 = $noqty1 + $row->ANG_1;
            $noqty2 = $noqty2 + $row->ANG_2;
            $noqty3 = $noqty3 + $row->ANG_3;
            $noqty4 = $noqty4 + $row->ANG_4;
            $noqty5 = $noqty5 + $row->ANG_5;
            $noqty6 = $noqty6 + $row->ANG_6;
            $noqty7 = $noqty7 + $row->ANG_7;
            $noqty8 = $noqty8 + $row->ANG_8;
            $noqty9 = $noqty9 + $row->ANG_9;
            $noqty10 = $noqty10 + $row->ANG_10;
            $noqty11 = $noqty11 + $row->ANG_11;
            $noqty12 = $noqty12 + $row->ANG_12;
            $noqty13 = $noqty13 + $row->ANG_13;
            $noqty14 = $noqty14 + $row->ANG_14;
            $noqty15 = $noqty15 + $row->ANG_15;
            $noqty16 = $noqty16 + $row->ANG_16;
            $noqty17 = $noqty17 + $row->ANG_17;
            $noqty18 = $noqty18 + $row->ANG_18;
            $noqty19 = $noqty19 + $row->ANG_19;
            $noqty20 = $noqty20 + $row->ANG_20;
            $noqty21 = $noqty21 + $row->ANG_21;
            $noqty22 = $noqty22 + $row->ANG_22;
            $noqty23 = $noqty23 + $row->ANG_23;
            $noqty24 = $noqty24 + $row->ANG_24;
            $noqty25 = $noqty25 + $row->ANG_25;
            $noqty26 = $noqty26 + $row->ANG_26;
            $noqty27 = $noqty27 + $row->ANG_27;
            $noqty28 = $noqty28 + $row->ANG_28;
            $noqty29 = $noqty29 + $row->ANG_29;
            $noqty30 = $noqty30 + $row->ANG_30;
            $noqty31 = $noqty31 + $row->ANG_31;
        }

        $data['df'] = array(
            'ANG_1' => $noqty1,
            'ANG_2' => $noqty2,
            'ANG_3' => $noqty3,
            'ANG_4' => $noqty4,
            'ANG_5' => $noqty5,
            'ANG_6' => $noqty6,
            'ANG_7' => $noqty7,
            'ANG_8' => $noqty8,
            'ANG_9' => $noqty9,
            'ANG_10' => $noqty10,
            'ANG_11' => $noqty11,
            'ANG_12' => $noqty12,
            'ANG_13' => $noqty13,
            'ANG_14' => $noqty14,
            'ANG_15' => $noqty15,
            'ANG_16' => $noqty16,
            'ANG_17' => $noqty17,
            'ANG_18' => $noqty18,
            'ANG_19' => $noqty19,
            'ANG_20' => $noqty20,
            'ANG_21' => $noqty21,
            'ANG_22' => $noqty22,
            'ANG_23' => $noqty23,
            'ANG_24' => $noqty24,
            'ANG_25' => $noqty25,
            'ANG_26' => $noqty26,
            'ANG_27' => $noqty27,
            'ANG_28' => $noqty28,
            'ANG_29' => $noqty29,
            'ANG_30' => $noqty30,
            'ANG_31' => $noqty31,
        );

        $noqty1 = 0;
        $noqty2 = 0;
        $noqty3 = 0;
        $noqty4 = 0;
        $noqty5 = 0;
        $noqty6 = 0;
        $noqty7 = 0;
        $noqty8 = 0;
        $noqty9 = 0;
        $noqty10 = 0;
        $noqty11 = 0;
        $noqty12 = 0;
        $noqty13 = 0;
        $noqty14 = 0;
        $noqty15 = 0;
        $noqty16 = 0;
        $noqty17 = 0;
        $noqty18 = 0;
        $noqty19 = 0;
        $noqty20 = 0;
        $noqty21 = 0;
        $noqty22 = 0;
        $noqty23 = 0;
        $noqty24 = 0;
        $noqty25 = 0;
        $noqty26 = 0;
        $noqty27 = 0;
        $noqty28 = 0;
        $noqty29 = 0;
        $noqty30 = 0;
        $noqty31 = 0;

        for ($x = 0; $x < count($type); $x++) {

            $row = $this->production_result_m->get_daily_ril_by_period_and_type($type[$x], $date, 5)->row();

            $noqty1 = $noqty1 + $row->ANG_1;
            $noqty2 = $noqty2 + $row->ANG_2;
            $noqty3 = $noqty3 + $row->ANG_3;
            $noqty4 = $noqty4 + $row->ANG_4;
            $noqty5 = $noqty5 + $row->ANG_5;
            $noqty6 = $noqty6 + $row->ANG_6;
            $noqty7 = $noqty7 + $row->ANG_7;
            $noqty8 = $noqty8 + $row->ANG_8;
            $noqty9 = $noqty9 + $row->ANG_9;
            $noqty10 = $noqty10 + $row->ANG_10;
            $noqty11 = $noqty11 + $row->ANG_11;
            $noqty12 = $noqty12 + $row->ANG_12;
            $noqty13 = $noqty13 + $row->ANG_13;
            $noqty14 = $noqty14 + $row->ANG_14;
            $noqty15 = $noqty15 + $row->ANG_15;
            $noqty16 = $noqty16 + $row->ANG_16;
            $noqty17 = $noqty17 + $row->ANG_17;
            $noqty18 = $noqty18 + $row->ANG_18;
            $noqty19 = $noqty19 + $row->ANG_19;
            $noqty20 = $noqty20 + $row->ANG_20;
            $noqty21 = $noqty21 + $row->ANG_21;
            $noqty22 = $noqty22 + $row->ANG_22;
            $noqty23 = $noqty23 + $row->ANG_23;
            $noqty24 = $noqty24 + $row->ANG_24;
            $noqty25 = $noqty25 + $row->ANG_25;
            $noqty26 = $noqty26 + $row->ANG_26;
            $noqty27 = $noqty27 + $row->ANG_27;
            $noqty28 = $noqty28 + $row->ANG_28;
            $noqty29 = $noqty29 + $row->ANG_29;
            $noqty30 = $noqty30 + $row->ANG_30;
            $noqty31 = $noqty31 + $row->ANG_31;
        }

        $data['ma'] = array(
            'ANG_1' => $noqty1,
            'ANG_2' => $noqty2,
            'ANG_3' => $noqty3,
            'ANG_4' => $noqty4,
            'ANG_5' => $noqty5,
            'ANG_6' => $noqty6,
            'ANG_7' => $noqty7,
            'ANG_8' => $noqty8,
            'ANG_9' => $noqty9,
            'ANG_10' => $noqty10,
            'ANG_11' => $noqty11,
            'ANG_12' => $noqty12,
            'ANG_13' => $noqty13,
            'ANG_14' => $noqty14,
            'ANG_15' => $noqty15,
            'ANG_16' => $noqty16,
            'ANG_17' => $noqty17,
            'ANG_18' => $noqty18,
            'ANG_19' => $noqty19,
            'ANG_20' => $noqty20,
            'ANG_21' => $noqty21,
            'ANG_22' => $noqty22,
            'ANG_23' => $noqty23,
            'ANG_24' => $noqty24,
            'ANG_25' => $noqty25,
            'ANG_26' => $noqty26,
            'ANG_27' => $noqty27,
            'ANG_28' => $noqty28,
            'ANG_29' => $noqty29,
            'ANG_30' => $noqty30,
            'ANG_31' => $noqty31,
        );

        $noqty1 = 0;
        $noqty2 = 0;
        $noqty3 = 0;
        $noqty4 = 0;
        $noqty5 = 0;
        $noqty6 = 0;
        $noqty7 = 0;
        $noqty8 = 0;
        $noqty9 = 0;
        $noqty10 = 0;
        $noqty11 = 0;
        $noqty12 = 0;
        $noqty13 = 0;
        $noqty14 = 0;
        $noqty15 = 0;
        $noqty16 = 0;
        $noqty17 = 0;
        $noqty18 = 0;
        $noqty19 = 0;
        $noqty20 = 0;
        $noqty21 = 0;
        $noqty22 = 0;
        $noqty23 = 0;
        $noqty24 = 0;
        $noqty25 = 0;
        $noqty26 = 0;
        $noqty27 = 0;
        $noqty28 = 0;
        $noqty29 = 0;
        $noqty30 = 0;
        $noqty31 = 0;

        for ($x = 0; $x < count($type); $x++) {

            $row = $this->production_result_m->get_daily_ril_by_period_and_type($type[$x], $date, 6)->row();

            $noqty1 = $noqty1 + $row->ANG_1;
            $noqty2 = $noqty2 + $row->ANG_2;
            $noqty3 = $noqty3 + $row->ANG_3;
            $noqty4 = $noqty4 + $row->ANG_4;
            $noqty5 = $noqty5 + $row->ANG_5;
            $noqty6 = $noqty6 + $row->ANG_6;
            $noqty7 = $noqty7 + $row->ANG_7;
            $noqty8 = $noqty8 + $row->ANG_8;
            $noqty9 = $noqty9 + $row->ANG_9;
            $noqty10 = $noqty10 + $row->ANG_10;
            $noqty11 = $noqty11 + $row->ANG_11;
            $noqty12 = $noqty12 + $row->ANG_12;
            $noqty13 = $noqty13 + $row->ANG_13;
            $noqty14 = $noqty14 + $row->ANG_14;
            $noqty15 = $noqty15 + $row->ANG_15;
            $noqty16 = $noqty16 + $row->ANG_16;
            $noqty17 = $noqty17 + $row->ANG_17;
            $noqty18 = $noqty18 + $row->ANG_18;
            $noqty19 = $noqty19 + $row->ANG_19;
            $noqty20 = $noqty20 + $row->ANG_20;
            $noqty21 = $noqty21 + $row->ANG_21;
            $noqty22 = $noqty22 + $row->ANG_22;
            $noqty23 = $noqty23 + $row->ANG_23;
            $noqty24 = $noqty24 + $row->ANG_24;
            $noqty25 = $noqty25 + $row->ANG_25;
            $noqty26 = $noqty26 + $row->ANG_26;
            $noqty27 = $noqty27 + $row->ANG_27;
            $noqty28 = $noqty28 + $row->ANG_28;
            $noqty29 = $noqty29 + $row->ANG_29;
            $noqty30 = $noqty30 + $row->ANG_30;
            $noqty31 = $noqty31 + $row->ANG_31;
        }

        $data['ep'] = array(
            'ANG_1' => $noqty1,
            'ANG_2' => $noqty2,
            'ANG_3' => $noqty3,
            'ANG_4' => $noqty4,
            'ANG_5' => $noqty5,
            'ANG_6' => $noqty6,
            'ANG_7' => $noqty7,
            'ANG_8' => $noqty8,
            'ANG_9' => $noqty9,
            'ANG_10' => $noqty10,
            'ANG_11' => $noqty11,
            'ANG_12' => $noqty12,
            'ANG_13' => $noqty13,
            'ANG_14' => $noqty14,
            'ANG_15' => $noqty15,
            'ANG_16' => $noqty16,
            'ANG_17' => $noqty17,
            'ANG_18' => $noqty18,
            'ANG_19' => $noqty19,
            'ANG_20' => $noqty20,
            'ANG_21' => $noqty21,
            'ANG_22' => $noqty22,
            'ANG_23' => $noqty23,
            'ANG_24' => $noqty24,
            'ANG_25' => $noqty25,
            'ANG_26' => $noqty26,
            'ANG_27' => $noqty27,
            'ANG_28' => $noqty28,
            'ANG_29' => $noqty29,
            'ANG_30' => $noqty30,
            'ANG_31' => $noqty31,
        );

        $noqty1 = 0;
        $noqty2 = 0;
        $noqty3 = 0;
        $noqty4 = 0;
        $noqty5 = 0;
        $noqty6 = 0;
        $noqty7 = 0;
        $noqty8 = 0;
        $noqty9 = 0;
        $noqty10 = 0;
        $noqty11 = 0;
        $noqty12 = 0;
        $noqty13 = 0;
        $noqty14 = 0;
        $noqty15 = 0;
        $noqty16 = 0;
        $noqty17 = 0;
        $noqty18 = 0;
        $noqty19 = 0;
        $noqty20 = 0;
        $noqty21 = 0;
        $noqty22 = 0;
        $noqty23 = 0;
        $noqty24 = 0;
        $noqty25 = 0;
        $noqty26 = 0;
        $noqty27 = 0;
        $noqty28 = 0;
        $noqty29 = 0;
        $noqty30 = 0;
        $noqty31 = 0;

        for ($x = 0; $x < count($type); $x++) {

            $row = $this->production_result_m->get_daily_ril_by_period_and_type_all($type[$x], $date)->row();

            $noqty1 = $noqty1 + $row->ANG_1;
            $noqty2 = $noqty2 + $row->ANG_2;
            $noqty3 = $noqty3 + $row->ANG_3;
            $noqty4 = $noqty4 + $row->ANG_4;
            $noqty5 = $noqty5 + $row->ANG_5;
            $noqty6 = $noqty6 + $row->ANG_6;
            $noqty7 = $noqty7 + $row->ANG_7;
            $noqty8 = $noqty8 + $row->ANG_8;
            $noqty9 = $noqty9 + $row->ANG_9;
            $noqty10 = $noqty10 + $row->ANG_10;
            $noqty11 = $noqty11 + $row->ANG_11;
            $noqty12 = $noqty12 + $row->ANG_12;
            $noqty13 = $noqty13 + $row->ANG_13;
            $noqty14 = $noqty14 + $row->ANG_14;
            $noqty15 = $noqty15 + $row->ANG_15;
            $noqty16 = $noqty16 + $row->ANG_16;
            $noqty17 = $noqty17 + $row->ANG_17;
            $noqty18 = $noqty18 + $row->ANG_18;
            $noqty19 = $noqty19 + $row->ANG_19;
            $noqty20 = $noqty20 + $row->ANG_20;
            $noqty21 = $noqty21 + $row->ANG_21;
            $noqty22 = $noqty22 + $row->ANG_22;
            $noqty23 = $noqty23 + $row->ANG_23;
            $noqty24 = $noqty24 + $row->ANG_24;
            $noqty25 = $noqty25 + $row->ANG_25;
            $noqty26 = $noqty26 + $row->ANG_26;
            $noqty27 = $noqty27 + $row->ANG_27;
            $noqty28 = $noqty28 + $row->ANG_28;
            $noqty29 = $noqty29 + $row->ANG_29;
            $noqty30 = $noqty30 + $row->ANG_30;
            $noqty31 = $noqty31 + $row->ANG_31;
        }

        $data['all'] = array(
            'ANG_1' => $noqty1,
            'ANG_2' => $noqty2,
            'ANG_3' => $noqty3,
            'ANG_4' => $noqty4,
            'ANG_5' => $noqty5,
            'ANG_6' => $noqty6,
            'ANG_7' => $noqty7,
            'ANG_8' => $noqty8,
            'ANG_9' => $noqty9,
            'ANG_10' => $noqty10,
            'ANG_11' => $noqty11,
            'ANG_12' => $noqty12,
            'ANG_13' => $noqty13,
            'ANG_14' => $noqty14,
            'ANG_15' => $noqty15,
            'ANG_16' => $noqty16,
            'ANG_17' => $noqty17,
            'ANG_18' => $noqty18,
            'ANG_19' => $noqty19,
            'ANG_20' => $noqty20,
            'ANG_21' => $noqty21,
            'ANG_22' => $noqty22,
            'ANG_23' => $noqty23,
            'ANG_24' => $noqty24,
            'ANG_25' => $noqty25,
            'ANG_26' => $noqty26,
            'ANG_27' => $noqty27,
            'ANG_28' => $noqty28,
            'ANG_29' => $noqty29,
            'ANG_30' => $noqty30,
            'ANG_31' => $noqty31,
        );

        $data['lastUpdate'] = $this->production_result_m->getLastMergeProductionResult();
        $this->load->view($this->layout_blank, $data);
    }

    function search_qty_by()
    {
        $date = $this->input->post('period');
        $data['period'] = $this->input->post('period');
        $type = NULL;

        if ($this->input->post('Setup') != '') {
            $data['Setup'] = 'checked';
            $type[] = $this->input->post('Setup');
        } else {
            $data['Setup'] = '';
        }
        if ($this->input->post('Process') != '') {
            $data['Process'] = 'checked';
            $type[] = $this->input->post('Process');
        } else {
            $data['Process'] = '';
        }
        if ($this->input->post('Trial') != '') {
            $data['Trial'] = 'checked';
            $type[] = $this->input->post('Trial');
        } else {
            $data['Trial'] = '';
        }
        if ($this->input->post('BrokenTest') != '') {
            $data['BrokenTest'] = 'checked';
            $type[] = $this->input->post('BrokenTest');
        } else {
            $data['BrokenTest'] = '';
        }

        $data['content'] = 'pes_new/chart_qty_ril_fiscal_v';

        $noqty1 = 0;
        $noqty2 = 0;
        $noqty3 = 0;
        $noqty4 = 0;
        $noqty5 = 0;
        $noqty6 = 0;
        $noqty7 = 0;
        $noqty8 = 0;
        $noqty9 = 0;
        $noqty10 = 0;
        $noqty11 = 0;
        $noqty12 = 0;

        for ($x = 0; $x < count($type); $x++) {

            $row = $this->production_result_m->query_chart_ril_by_fiscal_and_type($type[$x], $date, 1)->row();

            $noqty1 = $noqty1 + $row->NOQTY_1;
            $noqty2 = $noqty2 + $row->NOQTY_2;
            $noqty3 = $noqty3 + $row->NOQTY_3;
            $noqty4 = $noqty4 + $row->NOQTY_4;
            $noqty5 = $noqty5 + $row->NOQTY_5;
            $noqty6 = $noqty6 + $row->NOQTY_6;
            $noqty7 = $noqty7 + $row->NOQTY_7;
            $noqty8 = $noqty8 + $row->NOQTY_8;
            $noqty9 = $noqty9 + $row->NOQTY_9;
            $noqty10 = $noqty10 + $row->NOQTY_10;
            $noqty11 = $noqty11 + $row->NOQTY_11;
            $noqty12 = $noqty12 + $row->NOQTY_12;
        }

        $data['up'] = array(
            'NOQTY_1' => $noqty1,
            'NOQTY_2' => $noqty2,
            'NOQTY_3' => $noqty3,
            'NOQTY_4' => $noqty4,
            'NOQTY_5' => $noqty5,
            'NOQTY_6' => $noqty6,
            'NOQTY_7' => $noqty7,
            'NOQTY_8' => $noqty8,
            'NOQTY_9' => $noqty9,
            'NOQTY_10' => $noqty10,
            'NOQTY_11' => $noqty11,
            'NOQTY_12' => $noqty12,
        );

        $noqty1 = 0;
        $noqty2 = 0;
        $noqty3 = 0;
        $noqty4 = 0;
        $noqty5 = 0;
        $noqty6 = 0;
        $noqty7 = 0;
        $noqty8 = 0;
        $noqty9 = 0;
        $noqty10 = 0;
        $noqty11 = 0;
        $noqty12 = 0;

        for ($x = 0; $x < count($type); $x++) {

            $row = $this->production_result_m->query_chart_ril_by_fiscal_and_type($type[$x], $date, 2)->row();

            $noqty1 = $noqty1 + $row->NOQTY_1;
            $noqty2 = $noqty2 + $row->NOQTY_2;
            $noqty3 = $noqty3 + $row->NOQTY_3;
            $noqty4 = $noqty4 + $row->NOQTY_4;
            $noqty5 = $noqty5 + $row->NOQTY_5;
            $noqty6 = $noqty6 + $row->NOQTY_6;
            $noqty7 = $noqty7 + $row->NOQTY_7;
            $noqty8 = $noqty8 + $row->NOQTY_8;
            $noqty9 = $noqty9 + $row->NOQTY_9;
            $noqty10 = $noqty10 + $row->NOQTY_10;
            $noqty11 = $noqty11 + $row->NOQTY_11;
            $noqty12 = $noqty12 + $row->NOQTY_12;
        }

        $data['bp'] = array(
            'NOQTY_1' => $noqty1,
            'NOQTY_2' => $noqty2,
            'NOQTY_3' => $noqty3,
            'NOQTY_4' => $noqty4,
            'NOQTY_5' => $noqty5,
            'NOQTY_6' => $noqty6,
            'NOQTY_7' => $noqty7,
            'NOQTY_8' => $noqty8,
            'NOQTY_9' => $noqty9,
            'NOQTY_10' => $noqty10,
            'NOQTY_11' => $noqty11,
            'NOQTY_12' => $noqty12,
        );

        $noqty1 = 0;
        $noqty2 = 0;
        $noqty3 = 0;
        $noqty4 = 0;
        $noqty5 = 0;
        $noqty6 = 0;
        $noqty7 = 0;
        $noqty8 = 0;
        $noqty9 = 0;
        $noqty10 = 0;
        $noqty11 = 0;
        $noqty12 = 0;

        for ($x = 0; $x < count($type); $x++) {

            $row = $this->production_result_m->query_chart_ril_by_fiscal_and_type($type[$x], $date, 3)->row();

            $noqty1 = $noqty1 + $row->NOQTY_1;
            $noqty2 = $noqty2 + $row->NOQTY_2;
            $noqty3 = $noqty3 + $row->NOQTY_3;
            $noqty4 = $noqty4 + $row->NOQTY_4;
            $noqty5 = $noqty5 + $row->NOQTY_5;
            $noqty6 = $noqty6 + $row->NOQTY_6;
            $noqty7 = $noqty7 + $row->NOQTY_7;
            $noqty8 = $noqty8 + $row->NOQTY_8;
            $noqty9 = $noqty9 + $row->NOQTY_9;
            $noqty10 = $noqty10 + $row->NOQTY_10;
            $noqty11 = $noqty11 + $row->NOQTY_11;
            $noqty12 = $noqty12 + $row->NOQTY_12;
        }

        $data['dl'] = array(
            'NOQTY_1' => $noqty1,
            'NOQTY_2' => $noqty2,
            'NOQTY_3' => $noqty3,
            'NOQTY_4' => $noqty4,
            'NOQTY_5' => $noqty5,
            'NOQTY_6' => $noqty6,
            'NOQTY_7' => $noqty7,
            'NOQTY_8' => $noqty8,
            'NOQTY_9' => $noqty9,
            'NOQTY_10' => $noqty10,
            'NOQTY_11' => $noqty11,
            'NOQTY_12' => $noqty12,
        );

        $noqty1 = 0;
        $noqty2 = 0;
        $noqty3 = 0;
        $noqty4 = 0;
        $noqty5 = 0;
        $noqty6 = 0;
        $noqty7 = 0;
        $noqty8 = 0;
        $noqty9 = 0;
        $noqty10 = 0;
        $noqty11 = 0;
        $noqty12 = 0;

        for ($x = 0; $x < count($type); $x++) {

            $row = $this->production_result_m->query_chart_ril_by_fiscal_and_type($type[$x], $date, 4)->row();

            $noqty1 = $noqty1 + $row->NOQTY_1;
            $noqty2 = $noqty2 + $row->NOQTY_2;
            $noqty3 = $noqty3 + $row->NOQTY_3;
            $noqty4 = $noqty4 + $row->NOQTY_4;
            $noqty5 = $noqty5 + $row->NOQTY_5;
            $noqty6 = $noqty6 + $row->NOQTY_6;
            $noqty7 = $noqty7 + $row->NOQTY_7;
            $noqty8 = $noqty8 + $row->NOQTY_8;
            $noqty9 = $noqty9 + $row->NOQTY_9;
            $noqty10 = $noqty10 + $row->NOQTY_10;
            $noqty11 = $noqty11 + $row->NOQTY_11;
            $noqty12 = $noqty12 + $row->NOQTY_12;
        }

        $data['df'] = array(
            'NOQTY_1' => $noqty1,
            'NOQTY_2' => $noqty2,
            'NOQTY_3' => $noqty3,
            'NOQTY_4' => $noqty4,
            'NOQTY_5' => $noqty5,
            'NOQTY_6' => $noqty6,
            'NOQTY_7' => $noqty7,
            'NOQTY_8' => $noqty8,
            'NOQTY_9' => $noqty9,
            'NOQTY_10' => $noqty10,
            'NOQTY_11' => $noqty11,
            'NOQTY_12' => $noqty12,
        );

        $noqty1 = 0;
        $noqty2 = 0;
        $noqty3 = 0;
        $noqty4 = 0;
        $noqty5 = 0;
        $noqty6 = 0;
        $noqty7 = 0;
        $noqty8 = 0;
        $noqty9 = 0;
        $noqty10 = 0;
        $noqty11 = 0;
        $noqty12 = 0;

        for ($x = 0; $x < count($type); $x++) {

            $row = $this->production_result_m->query_chart_ril_by_fiscal_and_type($type[$x], $date, 5)->row();

            $noqty1 = $noqty1 + $row->NOQTY_1;
            $noqty2 = $noqty2 + $row->NOQTY_2;
            $noqty3 = $noqty3 + $row->NOQTY_3;
            $noqty4 = $noqty4 + $row->NOQTY_4;
            $noqty5 = $noqty5 + $row->NOQTY_5;
            $noqty6 = $noqty6 + $row->NOQTY_6;
            $noqty7 = $noqty7 + $row->NOQTY_7;
            $noqty8 = $noqty8 + $row->NOQTY_8;
            $noqty9 = $noqty9 + $row->NOQTY_9;
            $noqty10 = $noqty10 + $row->NOQTY_10;
            $noqty11 = $noqty11 + $row->NOQTY_11;
            $noqty12 = $noqty12 + $row->NOQTY_12;
        }

        $data['ma'] = array(
            'NOQTY_1' => $noqty1,
            'NOQTY_2' => $noqty2,
            'NOQTY_3' => $noqty3,
            'NOQTY_4' => $noqty4,
            'NOQTY_5' => $noqty5,
            'NOQTY_6' => $noqty6,
            'NOQTY_7' => $noqty7,
            'NOQTY_8' => $noqty8,
            'NOQTY_9' => $noqty9,
            'NOQTY_10' => $noqty10,
            'NOQTY_11' => $noqty11,
            'NOQTY_12' => $noqty12,
        );

        $noqty1 = 0;
        $noqty2 = 0;
        $noqty3 = 0;
        $noqty4 = 0;
        $noqty5 = 0;
        $noqty6 = 0;
        $noqty7 = 0;
        $noqty8 = 0;
        $noqty9 = 0;
        $noqty10 = 0;
        $noqty11 = 0;
        $noqty12 = 0;

        for ($x = 0; $x < count($type); $x++) {

            $row = $this->production_result_m->query_chart_ril_by_fiscal_and_type_all($type[$x], $date)->row();

            $noqty1 = $noqty1 + $row->NOQTY_1;
            $noqty2 = $noqty2 + $row->NOQTY_2;
            $noqty3 = $noqty3 + $row->NOQTY_3;
            $noqty4 = $noqty4 + $row->NOQTY_4;
            $noqty5 = $noqty5 + $row->NOQTY_5;
            $noqty6 = $noqty6 + $row->NOQTY_6;
            $noqty7 = $noqty7 + $row->NOQTY_7;
            $noqty8 = $noqty8 + $row->NOQTY_8;
            $noqty9 = $noqty9 + $row->NOQTY_9;
            $noqty10 = $noqty10 + $row->NOQTY_10;
            $noqty11 = $noqty11 + $row->NOQTY_11;
            $noqty12 = $noqty12 + $row->NOQTY_12;
        }

        $data['all'] = array(
            'NOQTY_1' => $noqty1,
            'NOQTY_2' => $noqty2,
            'NOQTY_3' => $noqty3,
            'NOQTY_4' => $noqty4,
            'NOQTY_5' => $noqty5,
            'NOQTY_6' => $noqty6,
            'NOQTY_7' => $noqty7,
            'NOQTY_8' => $noqty8,
            'NOQTY_9' => $noqty9,
            'NOQTY_10' => $noqty10,
            'NOQTY_11' => $noqty11,
            'NOQTY_12' => $noqty12,
        );

        $data['lastUpdate'] = $this->production_result_m->getLastMergeProductionResult();
        $this->load->view($this->layout_blank, $data);
    }

    function search_amount_by()
    {

        $date = $this->input->post('period');
        $data['period'] = $this->input->post('period');
        $type = NULL;

        if ($this->input->post('Setup') != '') {
            $data['Setup'] = 'checked';
            $type[] = $this->input->post('Setup');
        } else {
            $data['Setup'] = '';
        }
        if ($this->input->post('Process') != '') {
            $data['Process'] = 'checked';
            $type[] = $this->input->post('Process');
        } else {
            $data['Process'] = '';
        }
        if ($this->input->post('Trial') != '') {
            $data['Trial'] = 'checked';
            $type[] = $this->input->post('Trial');
        } else {
            $data['Trial'] = '';
        }
        if ($this->input->post('BrokenTest') != '') {
            $data['BrokenTest'] = 'checked';
            $type[] = $this->input->post('BrokenTest');
        } else {
            $data['BrokenTest'] = '';
        }

        $data['content'] = 'pes_new/chart_amount_ril_fiscal_v';

        $noamo1 = 0;
        $noamo2 = 0;
        $noamo3 = 0;
        $noamo4 = 0;
        $noamo5 = 0;
        $noamo6 = 0;
        $noamo7 = 0;
        $noamo8 = 0;
        $noamo9 = 0;
        $noamo10 = 0;
        $noamo11 = 0;
        $noamo12 = 0;

        for ($x = 0; $x < count($type); $x++) {

            $row = $this->production_result_m->query_chart_ril_by_fiscal_and_type($type[$x], $date, 1)->row();

            $noamo1 = $noamo1 + $row->NOAMO_1;
            $noamo2 = $noamo2 + $row->NOAMO_2;
            $noamo3 = $noamo3 + $row->NOAMO_3;
            $noamo4 = $noamo4 + $row->NOAMO_4;
            $noamo5 = $noamo5 + $row->NOAMO_5;
            $noamo6 = $noamo6 + $row->NOAMO_6;
            $noamo7 = $noamo7 + $row->NOAMO_7;
            $noamo8 = $noamo8 + $row->NOAMO_8;
            $noamo9 = $noamo9 + $row->NOAMO_9;
            $noamo10 = $noamo10 + $row->NOAMO_10;
            $noamo11 = $noamo11 + $row->NOAMO_11;
            $noamo12 = $noamo12 + $row->NOAMO_12;
        }

        $data['up'] = array(
            'NOAMO_1' => $noamo1,
            'NOAMO_2' => $noamo2,
            'NOAMO_3' => $noamo3,
            'NOAMO_4' => $noamo4,
            'NOAMO_5' => $noamo5,
            'NOAMO_6' => $noamo6,
            'NOAMO_7' => $noamo7,
            'NOAMO_8' => $noamo8,
            'NOAMO_9' => $noamo9,
            'NOAMO_10' => $noamo10,
            'NOAMO_11' => $noamo11,
            'NOAMO_12' => $noamo12,
        );

        $noamo1 = 0;
        $noamo2 = 0;
        $noamo3 = 0;
        $noamo4 = 0;
        $noamo5 = 0;
        $noamo6 = 0;
        $noamo7 = 0;
        $noamo8 = 0;
        $noamo9 = 0;
        $noamo10 = 0;
        $noamo11 = 0;
        $noamo12 = 0;

        for ($x = 0; $x < count($type); $x++) {

            $row = $this->production_result_m->query_chart_ril_by_fiscal_and_type($type[$x], $date, 2)->row();

            $noamo1 = $noamo1 + $row->NOAMO_1;
            $noamo2 = $noamo2 + $row->NOAMO_2;
            $noamo3 = $noamo3 + $row->NOAMO_3;
            $noamo4 = $noamo4 + $row->NOAMO_4;
            $noamo5 = $noamo5 + $row->NOAMO_5;
            $noamo6 = $noamo6 + $row->NOAMO_6;
            $noamo7 = $noamo7 + $row->NOAMO_7;
            $noamo8 = $noamo8 + $row->NOAMO_8;
            $noamo9 = $noamo9 + $row->NOAMO_9;
            $noamo10 = $noamo10 + $row->NOAMO_10;
            $noamo11 = $noamo11 + $row->NOAMO_11;
            $noamo12 = $noamo12 + $row->NOAMO_12;
        }

        $data['bp'] = array(
            'NOAMO_1' => $noamo1,
            'NOAMO_2' => $noamo2,
            'NOAMO_3' => $noamo3,
            'NOAMO_4' => $noamo4,
            'NOAMO_5' => $noamo5,
            'NOAMO_6' => $noamo6,
            'NOAMO_7' => $noamo7,
            'NOAMO_8' => $noamo8,
            'NOAMO_9' => $noamo9,
            'NOAMO_10' => $noamo10,
            'NOAMO_11' => $noamo11,
            'NOAMO_12' => $noamo12,
        );

        $noamo1 = 0;
        $noamo2 = 0;
        $noamo3 = 0;
        $noamo4 = 0;
        $noamo5 = 0;
        $noamo6 = 0;
        $noamo7 = 0;
        $noamo8 = 0;
        $noamo9 = 0;
        $noamo10 = 0;
        $noamo11 = 0;
        $noamo12 = 0;

        for ($x = 0; $x < count($type); $x++) {

            $row = $this->production_result_m->query_chart_ril_by_fiscal_and_type($type[$x], $date, 3)->row();

            $noamo1 = $noamo1 + $row->NOAMO_1;
            $noamo2 = $noamo2 + $row->NOAMO_2;
            $noamo3 = $noamo3 + $row->NOAMO_3;
            $noamo4 = $noamo4 + $row->NOAMO_4;
            $noamo5 = $noamo5 + $row->NOAMO_5;
            $noamo6 = $noamo6 + $row->NOAMO_6;
            $noamo7 = $noamo7 + $row->NOAMO_7;
            $noamo8 = $noamo8 + $row->NOAMO_8;
            $noamo9 = $noamo9 + $row->NOAMO_9;
            $noamo10 = $noamo10 + $row->NOAMO_10;
            $noamo11 = $noamo11 + $row->NOAMO_11;
            $noamo12 = $noamo12 + $row->NOAMO_12;
        }

        $data['dl'] = array(
            'NOAMO_1' => $noamo1,
            'NOAMO_2' => $noamo2,
            'NOAMO_3' => $noamo3,
            'NOAMO_4' => $noamo4,
            'NOAMO_5' => $noamo5,
            'NOAMO_6' => $noamo6,
            'NOAMO_7' => $noamo7,
            'NOAMO_8' => $noamo8,
            'NOAMO_9' => $noamo9,
            'NOAMO_10' => $noamo10,
            'NOAMO_11' => $noamo11,
            'NOAMO_12' => $noamo12,
        );

        $noamo1 = 0;
        $noamo2 = 0;
        $noamo3 = 0;
        $noamo4 = 0;
        $noamo5 = 0;
        $noamo6 = 0;
        $noamo7 = 0;
        $noamo8 = 0;
        $noamo9 = 0;
        $noamo10 = 0;
        $noamo11 = 0;
        $noamo12 = 0;

        for ($x = 0; $x < count($type); $x++) {

            $row = $this->production_result_m->query_chart_ril_by_fiscal_and_type($type[$x], $date, 4)->row();

            $noamo1 = $noamo1 + $row->NOAMO_1;
            $noamo2 = $noamo2 + $row->NOAMO_2;
            $noamo3 = $noamo3 + $row->NOAMO_3;
            $noamo4 = $noamo4 + $row->NOAMO_4;
            $noamo5 = $noamo5 + $row->NOAMO_5;
            $noamo6 = $noamo6 + $row->NOAMO_6;
            $noamo7 = $noamo7 + $row->NOAMO_7;
            $noamo8 = $noamo8 + $row->NOAMO_8;
            $noamo9 = $noamo9 + $row->NOAMO_9;
            $noamo10 = $noamo10 + $row->NOAMO_10;
            $noamo11 = $noamo11 + $row->NOAMO_11;
            $noamo12 = $noamo12 + $row->NOAMO_12;
        }

        $data['df'] = array(
            'NOAMO_1' => $noamo1,
            'NOAMO_2' => $noamo2,
            'NOAMO_3' => $noamo3,
            'NOAMO_4' => $noamo4,
            'NOAMO_5' => $noamo5,
            'NOAMO_6' => $noamo6,
            'NOAMO_7' => $noamo7,
            'NOAMO_8' => $noamo8,
            'NOAMO_9' => $noamo9,
            'NOAMO_10' => $noamo10,
            'NOAMO_11' => $noamo11,
            'NOAMO_12' => $noamo12,
        );

        $noamo1 = 0;
        $noamo2 = 0;
        $noamo3 = 0;
        $noamo4 = 0;
        $noamo5 = 0;
        $noamo6 = 0;
        $noamo7 = 0;
        $noamo8 = 0;
        $noamo9 = 0;
        $noamo10 = 0;
        $noamo11 = 0;
        $noamo12 = 0;

        for ($x = 0; $x < count($type); $x++) {

            $row = $this->production_result_m->query_chart_ril_by_fiscal_and_type($type[$x], $date, 5)->row();

            $noamo1 = $noamo1 + $row->NOAMO_1;
            $noamo2 = $noamo2 + $row->NOAMO_2;
            $noamo3 = $noamo3 + $row->NOAMO_3;
            $noamo4 = $noamo4 + $row->NOAMO_4;
            $noamo5 = $noamo5 + $row->NOAMO_5;
            $noamo6 = $noamo6 + $row->NOAMO_6;
            $noamo7 = $noamo7 + $row->NOAMO_7;
            $noamo8 = $noamo8 + $row->NOAMO_8;
            $noamo9 = $noamo9 + $row->NOAMO_9;
            $noamo10 = $noamo10 + $row->NOAMO_10;
            $noamo11 = $noamo11 + $row->NOAMO_11;
            $noamo12 = $noamo12 + $row->NOAMO_12;
        }

        $data['ma'] = array(
            'NOAMO_1' => $noamo1,
            'NOAMO_2' => $noamo2,
            'NOAMO_3' => $noamo3,
            'NOAMO_4' => $noamo4,
            'NOAMO_5' => $noamo5,
            'NOAMO_6' => $noamo6,
            'NOAMO_7' => $noamo7,
            'NOAMO_8' => $noamo8,
            'NOAMO_9' => $noamo9,
            'NOAMO_10' => $noamo10,
            'NOAMO_11' => $noamo11,
            'NOAMO_12' => $noamo12,
        );

        $noamo1 = 0;
        $noamo2 = 0;
        $noamo3 = 0;
        $noamo4 = 0;
        $noamo5 = 0;
        $noamo6 = 0;
        $noamo7 = 0;
        $noamo8 = 0;
        $noamo9 = 0;
        $noamo10 = 0;
        $noamo11 = 0;
        $noamo12 = 0;

        for ($x = 0; $x < count($type); $x++) {

            $row = $this->production_result_m->query_chart_ril_by_fiscal_and_type_all($type[$x], $date)->row();

            $noamo1 = $noamo1 + $row->NOAMO_1;
            $noamo2 = $noamo2 + $row->NOAMO_2;
            $noamo3 = $noamo3 + $row->NOAMO_3;
            $noamo4 = $noamo4 + $row->NOAMO_4;
            $noamo5 = $noamo5 + $row->NOAMO_5;
            $noamo6 = $noamo6 + $row->NOAMO_6;
            $noamo7 = $noamo7 + $row->NOAMO_7;
            $noamo8 = $noamo8 + $row->NOAMO_8;
            $noamo9 = $noamo9 + $row->NOAMO_9;
            $noamo10 = $noamo10 + $row->NOAMO_10;
            $noamo11 = $noamo11 + $row->NOAMO_11;
            $noamo12 = $noamo12 + $row->NOAMO_12;
        }

        $data['all'] = array(
            'NOAMO_1' => $noamo1,
            'NOAMO_2' => $noamo2,
            'NOAMO_3' => $noamo3,
            'NOAMO_4' => $noamo4,
            'NOAMO_5' => $noamo5,
            'NOAMO_6' => $noamo6,
            'NOAMO_7' => $noamo7,
            'NOAMO_8' => $noamo8,
            'NOAMO_9' => $noamo9,
            'NOAMO_10' => $noamo10,
            'NOAMO_11' => $noamo11,
            'NOAMO_12' => $noamo12,
        );

        $data['lastUpdate'] = $this->production_result_m->getLastMergeProductionResult();
        $this->load->view($this->layout_blank, $data);
    }

}
