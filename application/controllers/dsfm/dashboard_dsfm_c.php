<?php

class dashboard_dsfm_c extends CI_Controller {

    public function __construct() {
        parent::__construct();
        //$this->load->model('quality/quality_problem_m');
    }

    public function index() {
        $content = 'dsfm/dashboard_dsfm_v';
        $data['title'] = "Dashboard Receiving Performance";
        $date_now = date("Ymd");
        $data['date_now'] = $date_now;
        $time_now = date("His");
        $data['time_now'] = $time_now;
        $year_only = substr($date_now, 0, 4);
        $month_only = substr($date_now, 4, 2);
        if ($month_only == '01') {
            $period = 'januari' . $year_only;
        } else if ($month_only == '02') {
            $period = 'februari' . $year_only;
        } else if ($month_only == '03') {
            $period = 'maret' . $year_only;
        } else if ($month_only == '04') {
            $period = 'april' . $year_only;
        } else if ($month_only == '05') {
            $period = 'mei' . $year_only;
        } else if ($month_only == '06') {
            $period = 'juni' . $year_only;
        } else if ($month_only == '07') {
            $period = 'juli' . $year_only;
        } else if ($month_only == '08') {
            $period = 'agustus' . $year_only;
        } else if ($month_only == '09') {
            $period = 'september' . $year_only;
        } else if ($month_only == '10') {
            $period = 'oktober' . $year_only;
        } else if ($month_only == '11') {
            $period = 'november' . $year_only;
        } else {
            $period = 'desember' . $year_only;
        }
        
        $data['list_stock_part'] = $this->db->query("select a.CHR_PART_NO,b.CHR_PART_NAME,b.CHR_BACK_NUMBER,b.INT_QTY_BOX,c.CHR_RAKNO,b.INT_USAGEPERDAY,
                                                    a.INT_PART_QTY,b.CHR_SUPPLIER_NAME,b.CHR_PROBLEM_STOCK,b.CHR_CA_STOCK,b.CHR_PIC,d.CHR_JAM from TT_PARTS_SLOC as a inner join TT_KANBANMIZE as b
                                                    on a.CHR_PART_NO=b.CHR_PART_NUMBER inner join TM_KANBAN as c
                                                    on c.CHR_PART_NO=b.CHR_PART_NUMBER inner join TM_STO as d
                                                    on d.CHR_ID_PART=a.CHR_PART_NO
                                                    where b.CHR_ID like '$period%' and c.CHR_RAKNO <> '' and c.CHR_RAKNO <> 'Passtrough' and a.CHR_SLOC='WH00' and b.CHR_ID_SUPPLIER=c.CHR_WC_VENDOR
                                                    and c.CHR_KANBAN_TYPE='0' and d.CHR_KODE_VENDOR=b.CHR_ID_SUPPLIER and (round((a.INT_PART_QTY)/(b.INT_USAGEPERDAY),2) < 0.5) and b.INT_USAGEPERDAY<>0 
                                                    order by round((a.INT_PART_QTY)/(b.INT_USAGEPERDAY),2) asc")->result();
        $list_stock_part_num = $this->db->query("select a.CHR_PART_NO,b.CHR_PART_NAME,b.CHR_BACK_NUMBER,b.INT_QTY_BOX,c.CHR_RAKNO,b.INT_USAGEPERDAY,
                                                    a.INT_PART_QTY,b.CHR_SUPPLIER_NAME,b.CHR_PROBLEM_STOCK,b.CHR_CA_STOCK,b.CHR_PIC,d.CHR_JAM from TT_PARTS_SLOC as a inner join TT_KANBANMIZE as b
                                                    on a.CHR_PART_NO=b.CHR_PART_NUMBER inner join TM_KANBAN as c
                                                    on c.CHR_PART_NO=b.CHR_PART_NUMBER inner join TM_STO as d
                                                    on d.CHR_ID_PART=a.CHR_PART_NO
                                                    where b.CHR_ID like '$period%' and c.CHR_RAKNO <> '' and c.CHR_RAKNO <> 'Passtrough' and a.CHR_SLOC='WH00' and b.CHR_ID_SUPPLIER=c.CHR_WC_VENDOR
                                                    and c.CHR_KANBAN_TYPE='0' and d.CHR_KODE_VENDOR=b.CHR_ID_SUPPLIER and (round((a.INT_PART_QTY)/(b.INT_USAGEPERDAY),2) < 0.5) and b.INT_USAGEPERDAY<>0 
                                                    order by round((a.INT_PART_QTY)/(b.INT_USAGEPERDAY),2) asc")->num_rows();
        $data['list_stock_part_num'] = ceil($list_stock_part_num / 15);
//        $data['list_order_part'] = $this->db->query("select distinct a.CHR_SUPPLIER_ID,b.CHR_SUPPLIER_NAME,d.CHR_CYCLE_DAY,a.INT_CYCLE_BIN,d.CHR_CYCLE_AFTER,b.INT_TRUCK,a.CHR_ORDER_TIME
//                                                    from TM_VENDOR_CYCLE_BIN as a
//                                                    inner join TT_PDS as b
//                                                    on a.CHR_SUPPLIER_ID=b.CHR_SUPPLIER_ID and a.INT_CYCLE_BIN=b.INT_TRUCK
//                                                    inner join TT_PURCHASE_ORDER_H as c
//                                                    on c.CHR_PDS_NO=b.CHR_PDS_NO
//                                                    inner join TM_VENDOR_CYCLE as d
//                                                    on d.CHR_SUPPLIER_ID=a.CHR_SUPPLIER_ID
//                                                    where a.CHR_ORDER_TIME is not null and b.CHR_PREPARED_NAME <> 'Sulatno'
//                                                    AND c.CHR_FLG_DELETE <> '1' and c.CHR_PDS_NO like 'D%'
//                                                    order by b.CHR_SUPPLIER_NAME asc")->result();
//        $list_order_part_num = $this->db->query("select distinct a.CHR_SUPPLIER_ID,b.CHR_SUPPLIER_NAME,d.CHR_CYCLE_DAY,a.INT_CYCLE_BIN,d.CHR_CYCLE_AFTER,b.INT_TRUCK,a.CHR_ORDER_TIME
//                                                    from TM_VENDOR_CYCLE_BIN as a
//                                                    inner join TT_PDS as b
//                                                    on a.CHR_SUPPLIER_ID=b.CHR_SUPPLIER_ID and a.INT_CYCLE_BIN=b.INT_TRUCK
//                                                    inner join TT_PURCHASE_ORDER_H as c
//                                                    on c.CHR_PDS_NO=b.CHR_PDS_NO
//                                                    inner join TM_VENDOR_CYCLE as d
//                                                    on d.CHR_SUPPLIER_ID=a.CHR_SUPPLIER_ID
//                                                    where a.CHR_ORDER_TIME is not null and b.CHR_PREPARED_NAME <> 'Sulatno'
//                                                    AND c.CHR_FLG_DELETE <> '1' and c.CHR_PDS_NO like 'D%'
//                                                    order by b.CHR_SUPPLIER_NAME asc")->num_rows();
//        $data['list_order_part_num'] = ceil($list_order_part_num / 20);
        
        $this->load->view($content, $data);
    }

}
