<?php

class dashboard_sepia_c extends CI_Controller {

    public function __construct() {
        parent::__construct();
        //$this->load->model('quality/quality_problem_m');
    }

    public function index() {
        $content = 'sepia/dashboard_sepia_v';
        $data['title'] = "Dashboard Supplier Performance";
        $date_awal = date("Y-m-01");
        $data['date_awal'] = $date_awal;
        $date_now = date("Ymd");
        $data['date_now'] = $date_now;
        $time_now = date("His");
        $data['time_now'] = $time_now;
        $date_delay = date("Y-m-d");
        $data['date_delay'] = $date_delay;
        $time_delay = date("His");
        $data['time_delay'] = $time_delay;
        $data['list_receive_part'] = $this->db->query("select distinct a.CHR_PDS_NO,b.CHR_SUPPLIER_ID,b.CHR_SUPPLIER_NAME,b.INT_TRUCK,b.CHR_TIME,d.CHR_DELIVERY_DATE,d.CHR_DELIVERY_TIME,SUM (a.INT_QTY) as Part_order, SUM(a.CHR_RECEIPT_PART) as Part_act,c.CHR_DATE_CHECKIN,c.CHR_TIME_CHECKIN,e.CHR_CREATE_DATE,c.CHR_CYCLE_SUPP,
                            case when ((SUM (a.INT_QTY) = SUM(a.CHR_RECEIPT_PART)) and (c.CHR_TIME_CHECKIN > b.CHR_TIME) and (d.CHR_DELIVERY_DATE = c.CHR_DATE_CHECKIN)) then 'Delayed'
                            when ((SUM (a.INT_QTY) = SUM(a.CHR_RECEIPT_PART)) and (c.CHR_TIME_CHECKIN > b.CHR_TIME) and (c.CHR_DATE_CHECKIN > d.CHR_DELIVERY_DATE)) then 'Delayed'
                            when ((SUM (a.INT_QTY) = SUM(a.CHR_RECEIPT_PART)) and (c.CHR_TIME_CHECKIN < b.CHR_TIME) and (c.CHR_DATE_CHECKIN > d.CHR_DELIVERY_DATE)) then 'Delayed'
                            when ((SUM (a.INT_QTY) <> SUM(a.CHR_RECEIPT_PART)) and (c.CHR_TIME_CHECKIN > b.CHR_TIME) and (d.CHR_DELIVERY_DATE = c.CHR_DATE_CHECKIN)) then 'Delayed'
                            when ((SUM (a.INT_QTY) <> SUM(a.CHR_RECEIPT_PART)) and (c.CHR_TIME_CHECKIN < b.CHR_TIME) and (d.CHR_DELIVERY_DATE = c.CHR_DATE_CHECKIN)) then 'Delayed'
                            when ((SUM (a.INT_QTY) <> SUM(a.CHR_RECEIPT_PART)) and (c.CHR_TIME_CHECKIN > b.CHR_TIME) and (c.CHR_DATE_CHECKIN > d.CHR_DELIVERY_DATE)) then 'Delayed'
                            when ((SUM (a.INT_QTY) <> SUM(a.CHR_RECEIPT_PART)) and (c.CHR_TIME_CHECKIN < b.CHR_TIME) and (c.CHR_DATE_CHECKIN > d.CHR_DELIVERY_DATE)) then 'Delayed'
                            when ((SUM (a.INT_QTY) <> SUM(a.CHR_RECEIPT_PART)) and (c.CHR_TIME_CHECKIN > b.CHR_TIME) and (d.CHR_DELIVERY_DATE > c.CHR_DATE_CHECKIN)) then 'Advanced'
                            when ((SUM (a.INT_QTY) <> SUM(a.CHR_RECEIPT_PART)) and (c.CHR_TIME_CHECKIN < b.CHR_TIME) and (d.CHR_DELIVERY_DATE > c.CHR_DATE_CHECKIN)) then 'Advanced'
                            when ((SUM (a.INT_QTY) = SUM(a.CHR_RECEIPT_PART)) and (c.CHR_TIME_CHECKIN > b.CHR_TIME) and (d.CHR_DELIVERY_DATE > c.CHR_DATE_CHECKIN)) then 'Advanced'
                            when ((SUM (a.INT_QTY) = SUM(a.CHR_RECEIPT_PART)) and (c.CHR_TIME_CHECKIN < b.CHR_TIME) and (d.CHR_DELIVERY_DATE > c.CHR_DATE_CHECKIN)) then 'Advanced'
                            when ((SUM (a.INT_QTY) <> SUM(a.CHR_RECEIPT_PART)) and (c.CHR_TIME_CHECKIN < b.CHR_TIME) and (d.CHR_DELIVERY_DATE = c.CHR_DATE_CHECKIN)) then 'Advanced'
                            when ((SUM (a.INT_QTY) = SUM(a.CHR_RECEIPT_PART)) and (c.CHR_TIME_CHECKIN < b.CHR_TIME) and (d.CHR_DELIVERY_DATE = c.CHR_DATE_CHECKIN)) then 'Advanced'
                            end as Status,
                            case when datediff(MINUTE, CAST(d.CHR_DELIVERY_DATE as datetime) + CONVERT(datetime,left(d.CHR_DELIVERY_TIME,2)+':'+SUBSTRING(d.CHR_DELIVERY_TIME,3,2)+':'+right(d.CHR_DELIVERY_TIME,2)), cast(c.CHR_DATE_CHECKIN AS datetime) + CONVERT(datetime,left(c.CHR_TIME_CHECKIN,2)+':'+substring(c.CHR_TIME_CHECKIN,3,2)+':'+right(c.CHR_TIME_CHECKIN,2))) <= -20 then 'A'
                            when datediff(MINUTE, CAST(d.CHR_DELIVERY_DATE as datetime) + CONVERT(datetime,left(d.CHR_DELIVERY_TIME,2)+':'+SUBSTRING(d.CHR_DELIVERY_TIME,3,2)+':'+right(d.CHR_DELIVERY_TIME,2)), cast(c.CHR_DATE_CHECKIN AS datetime) + CONVERT(datetime,left(c.CHR_TIME_CHECKIN,2)+':'+substring(c.CHR_TIME_CHECKIN,3,2)+':'+right(c.CHR_TIME_CHECKIN,2))) > 20 then 'B'
                            else 'C' end as Arrival,
                            (SUM(c.CHR_HELM_STAT) + SUM(c.CHR_ROMPI_STAT) + SUM(c.CHR_IDCARD_STAT) + SUM(c.CHR_SEPATU_STAT) + SUM(c.CHR_GANJAL_STAT) + SUM(c.CHR_EMISI_STAT) + SUM(c.CHR_OLI_STAT) + SUM(c.CHR_APAR_STAT))
                             AS Nilai_awal, COUNT(c.CHR_DIRECT_SUPP)*8 AS Pembagi, 
                             (CONVERT(FLOAT,(SUM(c.CHR_HELM_STAT) + SUM(c.CHR_ROMPI_STAT) + SUM(c.CHR_IDCARD_STAT) + SUM(c.CHR_SEPATU_STAT) + SUM(c.CHR_GANJAL_STAT) + SUM(c.CHR_EMISI_STAT) + SUM(c.CHR_OLI_STAT) + SUM(c.CHR_APAR_STAT))))  
                             / (COUNT(c.CHR_DIRECT_SUPP)*8) AS Nilai_akhir
                            from TT_ORDERING as a
                            left join TT_PDS as b on a.CHR_PDS_NO=b.CHR_PDS_NO
                            left join PPC.TT_CHECKIN_SUPP as c on b.CHR_SUPPLIER_ID=c.CHR_DIRECT_SUPP
                            left join TT_PURCHASE_ORDER_H as d on d.CHR_PDS_NO=b.CHR_PDS_NO
                            left join TT_PURCHASE_RECEIPT_H as e on e.CHR_PDS_NO=d.CHR_PDS_NO
                            where c.CHR_DATE_CHECKIN=e.CHR_CREATE_DATE and c.CHR_DATE_CHECKIN='$date_now' and b.INT_TRUCK=c.CHR_CYCLE_SUPP and b.CHR_SUPPLIER_ID=c.CHR_DIRECT_SUPP and c.CHR_CHECKIN_STAT = '1' and a.INT_RECOVERY=e.INT_PDS_DELNO and b.CHR_SUPPLIER_ID not like 'P%'
                            group by a.CHR_PDS_NO,b.CHR_SUPPLIER_ID,b.CHR_SUPPLIER_NAME,b.INT_TRUCK,b.CHR_TIME,d.CHR_DELIVERY_DATE,c.CHR_DATE_CHECKIN,c.CHR_TIME_CHECKIN,d.CHR_DELIVERY_TIME,e.CHR_CREATE_DATE,c.CHR_CYCLE_SUPP
                            order by c.CHR_DATE_CHECKIN desc, c.CHR_TIME_CHECKIN desc")->result();
        //$data = $result->result();
        $list_receive_part_num = $this->db->query("select distinct a.CHR_PDS_NO,b.CHR_SUPPLIER_ID,b.CHR_SUPPLIER_NAME,b.INT_TRUCK,b.CHR_TIME,d.CHR_DELIVERY_DATE,d.CHR_DELIVERY_TIME,SUM (a.INT_QTY) as Part_order, SUM(a.CHR_RECEIPT_PART) as Part_act,c.CHR_DATE_CHECKIN,c.CHR_TIME_CHECKIN,e.CHR_CREATE_DATE,c.CHR_CYCLE_SUPP,
                            case when ((SUM (a.INT_QTY) = SUM(a.CHR_RECEIPT_PART)) and (c.CHR_TIME_CHECKIN > b.CHR_TIME) and (d.CHR_DELIVERY_DATE = c.CHR_DATE_CHECKIN)) then 'Delayed'
                            when ((SUM (a.INT_QTY) = SUM(a.CHR_RECEIPT_PART)) and (c.CHR_TIME_CHECKIN > b.CHR_TIME) and (c.CHR_DATE_CHECKIN > d.CHR_DELIVERY_DATE)) then 'Delayed'
                            when ((SUM (a.INT_QTY) = SUM(a.CHR_RECEIPT_PART)) and (c.CHR_TIME_CHECKIN < b.CHR_TIME) and (c.CHR_DATE_CHECKIN > d.CHR_DELIVERY_DATE)) then 'Delayed'
                            when ((SUM (a.INT_QTY) <> SUM(a.CHR_RECEIPT_PART)) and (c.CHR_TIME_CHECKIN > b.CHR_TIME) and (d.CHR_DELIVERY_DATE = c.CHR_DATE_CHECKIN)) then 'Delayed'
                            when ((SUM (a.INT_QTY) <> SUM(a.CHR_RECEIPT_PART)) and (c.CHR_TIME_CHECKIN < b.CHR_TIME) and (d.CHR_DELIVERY_DATE = c.CHR_DATE_CHECKIN)) then 'Delayed'
                            when ((SUM (a.INT_QTY) <> SUM(a.CHR_RECEIPT_PART)) and (c.CHR_TIME_CHECKIN > b.CHR_TIME) and (c.CHR_DATE_CHECKIN > d.CHR_DELIVERY_DATE)) then 'Delayed'
                            when ((SUM (a.INT_QTY) <> SUM(a.CHR_RECEIPT_PART)) and (c.CHR_TIME_CHECKIN < b.CHR_TIME) and (c.CHR_DATE_CHECKIN > d.CHR_DELIVERY_DATE)) then 'Delayed'
                            when ((SUM (a.INT_QTY) <> SUM(a.CHR_RECEIPT_PART)) and (c.CHR_TIME_CHECKIN > b.CHR_TIME) and (d.CHR_DELIVERY_DATE > c.CHR_DATE_CHECKIN)) then 'Advanced'
                            when ((SUM (a.INT_QTY) <> SUM(a.CHR_RECEIPT_PART)) and (c.CHR_TIME_CHECKIN < b.CHR_TIME) and (d.CHR_DELIVERY_DATE > c.CHR_DATE_CHECKIN)) then 'Advanced'
                            when ((SUM (a.INT_QTY) = SUM(a.CHR_RECEIPT_PART)) and (c.CHR_TIME_CHECKIN > b.CHR_TIME) and (d.CHR_DELIVERY_DATE > c.CHR_DATE_CHECKIN)) then 'Advanced'
                            when ((SUM (a.INT_QTY) = SUM(a.CHR_RECEIPT_PART)) and (c.CHR_TIME_CHECKIN < b.CHR_TIME) and (d.CHR_DELIVERY_DATE > c.CHR_DATE_CHECKIN)) then 'Advanced'
                            when ((SUM (a.INT_QTY) <> SUM(a.CHR_RECEIPT_PART)) and (c.CHR_TIME_CHECKIN < b.CHR_TIME) and (d.CHR_DELIVERY_DATE = c.CHR_DATE_CHECKIN)) then 'Advanced'
                            when ((SUM (a.INT_QTY) = SUM(a.CHR_RECEIPT_PART)) and (c.CHR_TIME_CHECKIN < b.CHR_TIME) and (d.CHR_DELIVERY_DATE = c.CHR_DATE_CHECKIN)) then 'Advanced'
                            end as Status,
                            case when datediff(MINUTE, CAST(d.CHR_DELIVERY_DATE as datetime) + CONVERT(datetime,left(d.CHR_DELIVERY_TIME,2)+':'+SUBSTRING(d.CHR_DELIVERY_TIME,3,2)+':'+right(d.CHR_DELIVERY_TIME,2)), cast(c.CHR_DATE_CHECKIN AS datetime) + CONVERT(datetime,left(c.CHR_TIME_CHECKIN,2)+':'+substring(c.CHR_TIME_CHECKIN,3,2)+':'+right(c.CHR_TIME_CHECKIN,2))) <= -20 then 'A'
                            when datediff(MINUTE, CAST(d.CHR_DELIVERY_DATE as datetime) + CONVERT(datetime,left(d.CHR_DELIVERY_TIME,2)+':'+SUBSTRING(d.CHR_DELIVERY_TIME,3,2)+':'+right(d.CHR_DELIVERY_TIME,2)), cast(c.CHR_DATE_CHECKIN AS datetime) + CONVERT(datetime,left(c.CHR_TIME_CHECKIN,2)+':'+substring(c.CHR_TIME_CHECKIN,3,2)+':'+right(c.CHR_TIME_CHECKIN,2))) > 20 then 'B'
                            else 'C' end as Arrival,
                            (SUM(c.CHR_HELM_STAT) + SUM(c.CHR_ROMPI_STAT) + SUM(c.CHR_IDCARD_STAT) + SUM(c.CHR_SEPATU_STAT) + SUM(c.CHR_GANJAL_STAT) + SUM(c.CHR_EMISI_STAT) + SUM(c.CHR_OLI_STAT) + SUM(c.CHR_APAR_STAT))
                             AS Nilai_awal, COUNT(c.CHR_DIRECT_SUPP)*8 AS Pembagi, 
                             (CONVERT(FLOAT,(SUM(c.CHR_HELM_STAT) + SUM(c.CHR_ROMPI_STAT) + SUM(c.CHR_IDCARD_STAT) + SUM(c.CHR_SEPATU_STAT) + SUM(c.CHR_GANJAL_STAT) + SUM(c.CHR_EMISI_STAT) + SUM(c.CHR_OLI_STAT) + SUM(c.CHR_APAR_STAT))))  
                             / (COUNT(c.CHR_DIRECT_SUPP)*8) AS Nilai_akhir
                            from TT_ORDERING as a
                            left join TT_PDS as b on a.CHR_PDS_NO=b.CHR_PDS_NO
                            left join PPC.TT_CHECKIN_SUPP as c on b.CHR_SUPPLIER_ID=c.CHR_DIRECT_SUPP
                            left join TT_PURCHASE_ORDER_H as d on d.CHR_PDS_NO=b.CHR_PDS_NO
                            left join TT_PURCHASE_RECEIPT_H as e on e.CHR_PDS_NO=d.CHR_PDS_NO
                            where c.CHR_DATE_CHECKIN=e.CHR_CREATE_DATE and c.CHR_DATE_CHECKIN='$date_now' and b.INT_TRUCK=c.CHR_CYCLE_SUPP and b.CHR_SUPPLIER_ID=c.CHR_DIRECT_SUPP and c.CHR_CHECKIN_STAT = '1' and a.INT_RECOVERY=e.INT_PDS_DELNO and b.CHR_SUPPLIER_ID not like 'P%'
                            group by a.CHR_PDS_NO,b.CHR_SUPPLIER_ID,b.CHR_SUPPLIER_NAME,b.INT_TRUCK,b.CHR_TIME,d.CHR_DELIVERY_DATE,c.CHR_DATE_CHECKIN,c.CHR_TIME_CHECKIN,d.CHR_DELIVERY_TIME,e.CHR_CREATE_DATE,c.CHR_CYCLE_SUPP
                            ")->num_rows();
        $data['list_receive_part_num'] = ceil($list_receive_part_num / 20);
        
        $data['list_delay_part'] = $this->db->query("select distinct b.CHR_SUPPLIER_ID,b.CHR_SUPPLIER_NAME,b.CHR_PROBLEM_STOCK,b.CHR_CA_STOCK,b.CHR_PIC
                                                    from TT_ORDERING as a
                                                    left join TT_PDS as b on a.CHR_PDS_NO=b.CHR_PDS_NO
                                                    left join TT_PURCHASE_RECEIPT_H as c on c.CHR_PDS_NO=b.CHR_PDS_NO
                                                    left join TT_PURCHASE_ORDER_H as d on d.CHR_PDS_NO=b.CHR_PDS_NO
                                                    where (b.CHR_PDS_NO not like 'C%') and (b.CHR_DATE_DELIVERY between '$date_awal' and '$date_delay') and a.CHR_FLAG_REC_END='F' and a.CHR_RECEIPT_PART = '0' and b.INT_RECOVERY = a.INT_RECOVERY
                                                       and b.CHR_SUPPLIER_ID not like 'P%' and ((d.CHR_DELIVERY_DATE < '$date_now' and d.CHR_DELIVERY_TIME > '$time_now') or (d.CHR_DELIVERY_DATE < '$date_now' and d.CHR_DELIVERY_TIME <= '$time_now') 
                                                       or (d.CHR_DELIVERY_DATE = '$date_now' and d.CHR_DELIVERY_TIME <= '$time_now') or (a.INT_RECOVERY > 0 and d.CHR_DELIVERY_DATE > '$date_now' and d.CHR_DELIVERY_TIME <> '$time_now'))
                                                    group by b.CHR_SUPPLIER_ID,b.CHR_SUPPLIER_NAME,b.CHR_PROBLEM_STOCK,b.CHR_CA_STOCK,b.CHR_PIC
                                                    order by b.CHR_SUPPLIER_NAME asc")->result();
        $list_delay_part_num = $this->db->query("select distinct b.CHR_SUPPLIER_ID,b.CHR_SUPPLIER_NAME,b.CHR_PROBLEM_STOCK,b.CHR_CA_STOCK,b.CHR_PIC
                                                    from TT_ORDERING as a
                                                    left join TT_PDS as b on a.CHR_PDS_NO=b.CHR_PDS_NO
                                                    left join TT_PURCHASE_RECEIPT_H as c on c.CHR_PDS_NO=b.CHR_PDS_NO
                                                    left join TT_PURCHASE_ORDER_H as d on d.CHR_PDS_NO=b.CHR_PDS_NO
                                                    where (b.CHR_PDS_NO not like 'C%') and (b.CHR_DATE_DELIVERY between '$date_awal' and '$date_delay') and a.CHR_FLAG_REC_END='F' and a.CHR_RECEIPT_PART = '0' and b.INT_RECOVERY = a.INT_RECOVERY
                                                       and b.CHR_SUPPLIER_ID not like 'P%' and ((d.CHR_DELIVERY_DATE < '$date_now' and d.CHR_DELIVERY_TIME > '$time_now') or (d.CHR_DELIVERY_DATE < '$date_now' and d.CHR_DELIVERY_TIME <= '$time_now') 
                                                       or (d.CHR_DELIVERY_DATE = '$date_now' and d.CHR_DELIVERY_TIME <= '$time_now') or (a.INT_RECOVERY > 0 and d.CHR_DELIVERY_DATE > '$date_now' and d.CHR_DELIVERY_TIME <> '$time_now'))
                                                    group by b.CHR_SUPPLIER_ID,b.CHR_SUPPLIER_NAME,b.CHR_PROBLEM_STOCK,b.CHR_CA_STOCK,b.CHR_PIC
                                                    order by b.CHR_SUPPLIER_NAME asc")->num_rows();
        $data['list_delay_part_num'] = ceil($list_delay_part_num / 20);
        
        $data['list_schedule_part'] = $this->db->query("select distinct a.CHR_DATE_DELIVERY,a.CHR_SUPPLIER_ID,a.CHR_SUPPLIER_NAME,a.INT_TRUCK,a.CHR_TIME,b.CHR_MILKRUN_ZONE 
                                        from TT_PDS a inner join TM_VENDOR_CYCLE_BIN b on a.CHR_SUPPLIER_ID=b.CHR_SUPPLIER_ID
                                        where a.CHR_DATE_DELIVERY='$date_delay' and a.CHR_FLAG='F' and a.CHR_TIME > $time_delay and a.CHR_PREPARED_NAME <> 'Sulatno' and a.CHR_SUPPLIER_ID not like 'P%' and a.INT_TRUCK=b.CHR_TRUCK
                                        order by a.CHR_TIME asc")->result();
        $list_schedule_part_num = $this->db->query("select distinct a.CHR_DATE_DELIVERY,a.CHR_SUPPLIER_ID,a.CHR_SUPPLIER_NAME,a.INT_TRUCK,a.CHR_TIME,b.CHR_MILKRUN_ZONE 
                                        from TT_PDS a inner join TM_VENDOR_CYCLE_BIN b on a.CHR_SUPPLIER_ID=b.CHR_SUPPLIER_ID
                                        where a.CHR_DATE_DELIVERY='$date_delay' and a.CHR_FLAG='F' and a.CHR_TIME > $time_delay and a.CHR_PREPARED_NAME <> 'Sulatno' and a.CHR_SUPPLIER_ID not like 'P%' and a.INT_TRUCK=b.CHR_TRUCK")->num_rows();
        $data['list_schedule_part_num'] = ceil($list_schedule_part_num / 20);
        
        $data['list_order_part'] = $this->db->query("select a.CHR_PDS_NO,a.CHR_SUPPLIER_ID,b.CHR_SUPPLIER_NAME,a.CHR_CREATE_DATE,a.CHR_CREATE_TIME,b.CHR_DATE_DELIVERY,
                                                        b.CHR_SUPPLIER_CYCLE,b.INT_TRUCK,c.CHR_ORDER_TIME
                                                        from TT_PURCHASE_ORDER_H as a inner join TT_PDS as b
                                                        on a.CHR_PDS_NO=b.CHR_PDS_NO
                                                        inner join TM_VENDOR_CYCLE_BIN as c
                                                        on c.CHR_SUPPLIER_ID=a.CHR_SUPPLIER_ID and c.INT_CYCLE_BIN=b.INT_TRUCK
                                                        WHERE a.CHR_CREATE_DATE = '$date_now' and b.CHR_PREPARED_NAME <> 'Sulatno'
                                                        AND a.CHR_FLG_DELETE <> '1' and (a.CHR_PDS_NO like 'D%' or a.CHR_PDS_NO like 'S%') and b.CHR_SUPPLIER_ID not like 'P%'
                                                        order by c.CHR_ORDER_TIME asc")->result();
        $list_order_part_num = $this->db->query("select a.CHR_PDS_NO,a.CHR_SUPPLIER_ID,b.CHR_SUPPLIER_NAME,a.CHR_CREATE_DATE,a.CHR_CREATE_TIME,b.CHR_DATE_DELIVERY,
                                                    b.CHR_SUPPLIER_CYCLE,b.INT_TRUCK,c.CHR_ORDER_TIME
                                                    from TT_PURCHASE_ORDER_H as a inner join TT_PDS as b
                                                    on a.CHR_PDS_NO=b.CHR_PDS_NO
                                                    inner join TM_VENDOR_CYCLE_BIN as c
                                                    on c.CHR_SUPPLIER_ID=a.CHR_SUPPLIER_ID and c.INT_CYCLE_BIN=b.INT_TRUCK
                                                    WHERE a.CHR_CREATE_DATE = '$date_now' and b.CHR_PREPARED_NAME <> 'Sulatno'
                                                    AND a.CHR_FLG_DELETE <> '1' and (a.CHR_PDS_NO like 'D%' or a.CHR_PDS_NO like 'S%') and b.CHR_SUPPLIER_ID not like 'P%'
                                                    order by c.CHR_ORDER_TIME asc")->num_rows();
        $data['list_order_part_num'] = ceil($list_order_part_num / 20);
        
//        $data['list_sum_delay'] = $this->db->query("select b.CHR_PDS_NO,a.INT_RECOVERY,b.CHR_SUPPLIER_ID,b.CHR_SUPPLIER_NAME,b.INT_TRUCK,b.CHR_ISSUE_DATE,d.CHR_DELIVERY_DATE,b.INT_RECOVERY,
//                                                    a.CHR_ID_PART,a.CHR_PART_NAME,a.CHR_BACK_NO,a.INT_QTY, a.CHR_RECEIPT_PART
//                                                    from TT_ORDERING as a
//                                                    left join TT_PDS as b on a.CHR_PDS_NO=b.CHR_PDS_NO
//                                                    left join TT_PURCHASE_RECEIPT_H as c on c.CHR_PDS_NO=b.CHR_PDS_NO
//                                                    left join TT_PURCHASE_ORDER_H as d on d.CHR_PDS_NO=b.CHR_PDS_NO
//                                                    where (b.CHR_PDS_NO not like 'S%') and (b.CHR_PDS_NO not like 'C%') and (b.CHR_DATE_DELIVERY between '$date_awal' and '$date_delay') and a.CHR_FLAG_REC_END='F' and a.CHR_RECEIPT_PART = '0' and b.INT_RECOVERY = a.INT_RECOVERY
//                                                       and ((d.CHR_DELIVERY_DATE < '$date_now' and d.CHR_DELIVERY_TIME > '$time_now') or (d.CHR_DELIVERY_DATE < '$date_now' and d.CHR_DELIVERY_TIME <= '$time_now') 
//                                                       or (d.CHR_DELIVERY_DATE = '$date_now' and d.CHR_DELIVERY_TIME <= '$time_now') or (a.INT_RECOVERY > 0 and d.CHR_DELIVERY_DATE > '$date_now' and d.CHR_DELIVERY_TIME <> '$time_now'))
//                                                    group by b.CHR_PDS_NO,a.INT_RECOVERY,b.CHR_SUPPLIER_ID,b.CHR_SUPPLIER_NAME,b.INT_TRUCK,b.CHR_ISSUE_DATE,d.CHR_DELIVERY_DATE,b.INT_RECOVERY,
//                                                    a.CHR_ID_PART,a.CHR_PART_NAME,a.CHR_BACK_NO,a.INT_QTY, a.CHR_RECEIPT_PART
//                                                    order by b.CHR_SUPPLIER_NAME asc, a.CHR_BACK_NO asc")->result();
//        $list_sum_delay_num = $this->db->query("select b.CHR_PDS_NO,a.INT_RECOVERY,b.CHR_SUPPLIER_ID,b.CHR_SUPPLIER_NAME,b.INT_TRUCK,b.CHR_ISSUE_DATE,d.CHR_DELIVERY_DATE,b.INT_RECOVERY,
//                                                    a.CHR_ID_PART,a.CHR_PART_NAME,a.CHR_BACK_NO,a.INT_QTY, a.CHR_RECEIPT_PART
//                                                    from TT_ORDERING as a
//                                                    left join TT_PDS as b on a.CHR_PDS_NO=b.CHR_PDS_NO
//                                                    left join TT_PURCHASE_RECEIPT_H as c on c.CHR_PDS_NO=b.CHR_PDS_NO
//                                                    left join TT_PURCHASE_ORDER_H as d on d.CHR_PDS_NO=b.CHR_PDS_NO
//                                                    where (b.CHR_PDS_NO not like 'S%') and (b.CHR_PDS_NO not like 'C%') and (b.CHR_DATE_DELIVERY between '$date_awal' and '$date_delay') and a.CHR_FLAG_REC_END='F' and a.CHR_RECEIPT_PART = '0' and b.INT_RECOVERY = a.INT_RECOVERY
//                                                       and ((d.CHR_DELIVERY_DATE < '$date_now' and d.CHR_DELIVERY_TIME > '$time_now') or (d.CHR_DELIVERY_DATE < '$date_now' and d.CHR_DELIVERY_TIME <= '$time_now') 
//                                                       or (d.CHR_DELIVERY_DATE = '$date_now' and d.CHR_DELIVERY_TIME <= '$time_now') or (a.INT_RECOVERY > 0 and d.CHR_DELIVERY_DATE > '$date_now' and d.CHR_DELIVERY_TIME <> '$time_now'))
//                                                    group by b.CHR_PDS_NO,a.INT_RECOVERY,b.CHR_SUPPLIER_ID,b.CHR_SUPPLIER_NAME,b.INT_TRUCK,b.CHR_ISSUE_DATE,d.CHR_DELIVERY_DATE,b.INT_RECOVERY,
//                                                    a.CHR_ID_PART,a.CHR_PART_NAME,a.CHR_BACK_NO,a.INT_QTY, a.CHR_RECEIPT_PART
//                                                    order by b.CHR_SUPPLIER_NAME asc, a.CHR_BACK_NO asc")->num_rows();
//        $data['list_sum_delay_num'] = ceil($list_sum_delay_num / 20);
        $this->load->view($content, $data);
    }

    public function updateAjax() {
        $date_now = date("Ymd");
        //$data = $this->sepia_app_m->get_dashboard_result_daily($date_now);
        $result = $this->db->query("select distinct a.CHR_PDS_NO,b.CHR_SUPPLIER_ID,b.CHR_SUPPLIER_NAME,b.INT_TRUCK,b.CHR_TIME,d.CHR_DELIVERY_DATE,d.CHR_DELIVERY_TIME,SUM (a.INT_QTY) as Part_order, SUM(a.CHR_RECEIPT_PART) as Part_act,c.CHR_DATE_CHECKIN,c.CHR_TIME_CHECKIN,e.CHR_CREATE_DATE,c.CHR_CYCLE_SUPP,
                            case when ((SUM (a.INT_QTY) = SUM(a.CHR_RECEIPT_PART)) and (c.CHR_TIME_CHECKIN > b.CHR_TIME) and (d.CHR_DELIVERY_DATE = c.CHR_DATE_CHECKIN)) then 'Delayed'
                            when ((SUM (a.INT_QTY) = SUM(a.CHR_RECEIPT_PART)) and (c.CHR_TIME_CHECKIN > b.CHR_TIME) and (c.CHR_DATE_CHECKIN > d.CHR_DELIVERY_DATE)) then 'Delayed'
                            when ((SUM (a.INT_QTY) = SUM(a.CHR_RECEIPT_PART)) and (c.CHR_TIME_CHECKIN < b.CHR_TIME) and (c.CHR_DATE_CHECKIN > d.CHR_DELIVERY_DATE)) then 'Delayed'
                            when ((SUM (a.INT_QTY) <> SUM(a.CHR_RECEIPT_PART)) and (c.CHR_TIME_CHECKIN > b.CHR_TIME) and (d.CHR_DELIVERY_DATE = c.CHR_DATE_CHECKIN)) then 'Delayed'
                            when ((SUM (a.INT_QTY) <> SUM(a.CHR_RECEIPT_PART)) and (c.CHR_TIME_CHECKIN < b.CHR_TIME) and (d.CHR_DELIVERY_DATE = c.CHR_DATE_CHECKIN)) then 'Delayed'
                            when ((SUM (a.INT_QTY) <> SUM(a.CHR_RECEIPT_PART)) and (c.CHR_TIME_CHECKIN > b.CHR_TIME) and (c.CHR_DATE_CHECKIN > d.CHR_DELIVERY_DATE)) then 'Delayed'
                            when ((SUM (a.INT_QTY) <> SUM(a.CHR_RECEIPT_PART)) and (c.CHR_TIME_CHECKIN < b.CHR_TIME) and (c.CHR_DATE_CHECKIN > d.CHR_DELIVERY_DATE)) then 'Delayed'
                            when ((SUM (a.INT_QTY) <> SUM(a.CHR_RECEIPT_PART)) and (c.CHR_TIME_CHECKIN > b.CHR_TIME) and (d.CHR_DELIVERY_DATE > c.CHR_DATE_CHECKIN)) then 'Advanced'
                            when ((SUM (a.INT_QTY) <> SUM(a.CHR_RECEIPT_PART)) and (c.CHR_TIME_CHECKIN < b.CHR_TIME) and (d.CHR_DELIVERY_DATE > c.CHR_DATE_CHECKIN)) then 'Advanced'
                            when ((SUM (a.INT_QTY) = SUM(a.CHR_RECEIPT_PART)) and (c.CHR_TIME_CHECKIN > b.CHR_TIME) and (d.CHR_DELIVERY_DATE > c.CHR_DATE_CHECKIN)) then 'Advanced'
                            when ((SUM (a.INT_QTY) = SUM(a.CHR_RECEIPT_PART)) and (c.CHR_TIME_CHECKIN < b.CHR_TIME) and (d.CHR_DELIVERY_DATE > c.CHR_DATE_CHECKIN)) then 'Advanced'
                            when ((SUM (a.INT_QTY) <> SUM(a.CHR_RECEIPT_PART)) and (c.CHR_TIME_CHECKIN < b.CHR_TIME) and (d.CHR_DELIVERY_DATE = c.CHR_DATE_CHECKIN)) then 'Advanced'
                            when ((SUM (a.INT_QTY) = SUM(a.CHR_RECEIPT_PART)) and (c.CHR_TIME_CHECKIN < b.CHR_TIME) and (d.CHR_DELIVERY_DATE = c.CHR_DATE_CHECKIN)) then 'Advanced'
                            end as Status,
                            case when datediff(MINUTE, CAST(d.CHR_DELIVERY_DATE as datetime) + CONVERT(datetime,left(d.CHR_DELIVERY_TIME,2)+':'+SUBSTRING(d.CHR_DELIVERY_TIME,3,2)+':'+right(d.CHR_DELIVERY_TIME,2)), cast(c.CHR_DATE_CHECKIN AS datetime) + CONVERT(datetime,left(c.CHR_TIME_CHECKIN,2)+':'+substring(c.CHR_TIME_CHECKIN,3,2)+':'+right(c.CHR_TIME_CHECKIN,2))) <= -20 then 'A'
                            when datediff(MINUTE, CAST(d.CHR_DELIVERY_DATE as datetime) + CONVERT(datetime,left(d.CHR_DELIVERY_TIME,2)+':'+SUBSTRING(d.CHR_DELIVERY_TIME,3,2)+':'+right(d.CHR_DELIVERY_TIME,2)), cast(c.CHR_DATE_CHECKIN AS datetime) + CONVERT(datetime,left(c.CHR_TIME_CHECKIN,2)+':'+substring(c.CHR_TIME_CHECKIN,3,2)+':'+right(c.CHR_TIME_CHECKIN,2))) > 20 then 'B'
                            else 'C' end as Arrival,
                            (SUM(c.CHR_HELM_STAT) + SUM(c.CHR_ROMPI_STAT) + SUM(c.CHR_IDCARD_STAT) + SUM(c.CHR_SEPATU_STAT) + SUM(c.CHR_GANJAL_STAT))
                             AS Nilai_awal, COUNT(c.CHR_DIRECT_SUPP)*5 AS Pembagi, 
                             (CONVERT(FLOAT,(SUM(c.CHR_HELM_STAT) + SUM(c.CHR_ROMPI_STAT) + SUM(c.CHR_IDCARD_STAT) + SUM(c.CHR_SEPATU_STAT) + SUM(c.CHR_GANJAL_STAT))))  
                             / (COUNT(c.CHR_DIRECT_SUPP)*5) AS Nilai_akhir
                            from TT_ORDERING as a
                            left join TT_PDS as b on a.CHR_PDS_NO=b.CHR_PDS_NO
                            left join PPC.TT_CHECKIN_SUPP as c on b.CHR_SUPPLIER_ID=c.CHR_DIRECT_SUPP
                            left join TT_PURCHASE_ORDER_H as d on d.CHR_PDS_NO=b.CHR_PDS_NO
                            left join TT_PURCHASE_RECEIPT_H as e on e.CHR_PDS_NO=d.CHR_PDS_NO
                            where c.CHR_DATE_CHECKIN=e.CHR_CREATE_DATE and c.CHR_DATE_CHECKIN='$date_now' and b.INT_TRUCK=c.CHR_CYCLE_SUPP
                            group by a.CHR_PDS_NO,b.CHR_SUPPLIER_ID,b.CHR_SUPPLIER_NAME,b.INT_TRUCK,b.CHR_TIME,d.CHR_DELIVERY_DATE,c.CHR_DATE_CHECKIN,c.CHR_TIME_CHECKIN,d.CHR_DELIVERY_TIME,e.CHR_CREATE_DATE,c.CHR_CYCLE_SUPP
                            union all
                            select a.CHR_PDS_NO,b.CHR_SUPPLIER_ID,b.CHR_SUPPLIER_NAME,b.INT_TRUCK,b.CHR_TIME,d.CHR_DELIVERY_DATE,d.CHR_DELIVERY_TIME,SUM (a.INT_QTY) as Part_order, SUM(a.CHR_RECEIPT_PART) as Part_act,c.CHR_DATE_CHECKIN,c.CHR_TIME_CHECKIN,e.CHR_CREATE_DATE,c.CHR_CYCLE_SUPP,
                            case when ((SUM (a.INT_QTY) = SUM(a.CHR_RECEIPT_PART)) and (c.CHR_TIME_CHECKIN > b.CHR_TIME) and (d.CHR_DELIVERY_DATE = c.CHR_DATE_CHECKIN)) then 'Delayed'
                            when ((SUM (a.INT_QTY) = SUM(a.CHR_RECEIPT_PART)) and (c.CHR_TIME_CHECKIN > b.CHR_TIME) and (c.CHR_DATE_CHECKIN > d.CHR_DELIVERY_DATE)) then 'Delayed'
                            when ((SUM (a.INT_QTY) = SUM(a.CHR_RECEIPT_PART)) and (c.CHR_TIME_CHECKIN < b.CHR_TIME) and (c.CHR_DATE_CHECKIN > d.CHR_DELIVERY_DATE)) then 'Delayed'
                            when ((SUM (a.INT_QTY) <> SUM(a.CHR_RECEIPT_PART)) and (c.CHR_TIME_CHECKIN > b.CHR_TIME) and (d.CHR_DELIVERY_DATE = c.CHR_DATE_CHECKIN)) then 'Delayed'
                            when ((SUM (a.INT_QTY) <> SUM(a.CHR_RECEIPT_PART)) and (c.CHR_TIME_CHECKIN < b.CHR_TIME) and (d.CHR_DELIVERY_DATE = c.CHR_DATE_CHECKIN)) then 'Delayed'
                            when ((SUM (a.INT_QTY) <> SUM(a.CHR_RECEIPT_PART)) and (c.CHR_TIME_CHECKIN > b.CHR_TIME) and (c.CHR_DATE_CHECKIN > d.CHR_DELIVERY_DATE)) then 'Delayed'
                            when ((SUM (a.INT_QTY) <> SUM(a.CHR_RECEIPT_PART)) and (c.CHR_TIME_CHECKIN < b.CHR_TIME) and (c.CHR_DATE_CHECKIN > d.CHR_DELIVERY_DATE)) then 'Delayed'
                            when ((SUM (a.INT_QTY) <> SUM(a.CHR_RECEIPT_PART)) and (c.CHR_TIME_CHECKIN > b.CHR_TIME) and (d.CHR_DELIVERY_DATE > c.CHR_DATE_CHECKIN)) then 'Advanced'
                            when ((SUM (a.INT_QTY) <> SUM(a.CHR_RECEIPT_PART)) and (c.CHR_TIME_CHECKIN < b.CHR_TIME) and (d.CHR_DELIVERY_DATE > c.CHR_DATE_CHECKIN)) then 'Advanced'
                            when ((SUM (a.INT_QTY) = SUM(a.CHR_RECEIPT_PART)) and (c.CHR_TIME_CHECKIN > b.CHR_TIME) and (d.CHR_DELIVERY_DATE > c.CHR_DATE_CHECKIN)) then 'Advanced'
                            when ((SUM (a.INT_QTY) = SUM(a.CHR_RECEIPT_PART)) and (c.CHR_TIME_CHECKIN < b.CHR_TIME) and (d.CHR_DELIVERY_DATE > c.CHR_DATE_CHECKIN)) then 'Advanced'
                            when ((SUM (a.INT_QTY) <> SUM(a.CHR_RECEIPT_PART)) and (c.CHR_TIME_CHECKIN < b.CHR_TIME) and (d.CHR_DELIVERY_DATE = c.CHR_DATE_CHECKIN)) then 'Advanced'
                            when ((SUM (a.INT_QTY) = SUM(a.CHR_RECEIPT_PART)) and (c.CHR_TIME_CHECKIN < b.CHR_TIME) and (d.CHR_DELIVERY_DATE = c.CHR_DATE_CHECKIN)) then 'Advanced'
                            end as Status,
                            case when datediff(MINUTE, CAST(d.CHR_DELIVERY_DATE as datetime) + CONVERT(datetime,left(d.CHR_DELIVERY_TIME,2)+':'+SUBSTRING(d.CHR_DELIVERY_TIME,3,2)+':'+right(d.CHR_DELIVERY_TIME,2)), cast(c.CHR_DATE_CHECKIN AS datetime) + CONVERT(datetime,left(c.CHR_TIME_CHECKIN,2)+':'+substring(c.CHR_TIME_CHECKIN,3,2)+':'+right(c.CHR_TIME_CHECKIN,2))) <= -20 then 'A'
                            when datediff(MINUTE, CAST(d.CHR_DELIVERY_DATE as datetime) + CONVERT(datetime,left(d.CHR_DELIVERY_TIME,2)+':'+SUBSTRING(d.CHR_DELIVERY_TIME,3,2)+':'+right(d.CHR_DELIVERY_TIME,2)), cast(c.CHR_DATE_CHECKIN AS datetime) + CONVERT(datetime,left(c.CHR_TIME_CHECKIN,2)+':'+substring(c.CHR_TIME_CHECKIN,3,2)+':'+right(c.CHR_TIME_CHECKIN,2))) > 20 then 'B'
                            else 'C' end as Arrival,
                            (SUM(c.CHR_HELM_STAT) + SUM(c.CHR_ROMPI_STAT) + SUM(c.CHR_IDCARD_STAT) + SUM(c.CHR_SEPATU_STAT) + SUM(c.CHR_GANJAL_STAT))
                             AS Nilai_awal, COUNT(c.CHR_DIRECT_SUPP)*5 AS Pembagi, 
                             (CONVERT(FLOAT,(SUM(c.CHR_HELM_STAT) + SUM(c.CHR_ROMPI_STAT) + SUM(c.CHR_IDCARD_STAT) + SUM(c.CHR_SEPATU_STAT) + SUM(c.CHR_GANJAL_STAT))))  
                             / (COUNT(c.CHR_DIRECT_SUPP)*5) AS Nilai_akhir
                            from TT_ORDERING as a
                            left join TT_PDS as b on a.CHR_PDS_NO=b.CHR_PDS_NO
                            left join TT_PURCHASE_ORDER_H as d on d.CHR_PDS_NO=b.CHR_PDS_NO
                            left join TT_PURCHASE_RECEIPT_H as e on e.CHR_PDS_NO=d.CHR_PDS_NO
                            left join TM_VENDOR_CYCLE_BIN as f on f.CHR_SUPPLIER_ID=b.CHR_SUPPLIER_ID
                            left join PPC.TT_CHECKIN_SUPP as c on c.CHR_MILKRUN_SUPP=f.CHR_MILKRUN_ZONE
                            where c.CHR_DATE_CHECKIN=e.CHR_CREATE_DATE and f.CHR_TRUCK=c.CHR_CYCLE_SUPP and c.CHR_DATE_CHECKIN='$date_now'
                            group by a.CHR_PDS_NO,b.CHR_SUPPLIER_ID,b.CHR_SUPPLIER_NAME,b.INT_TRUCK,b.CHR_TIME,d.CHR_DELIVERY_DATE,c.CHR_DATE_CHECKIN,c.CHR_TIME_CHECKIN,d.CHR_DELIVERY_TIME,e.CHR_CREATE_DATE,c.CHR_CYCLE_SUPP 
                            order by c.CHR_DATE_CHECKIN desc, c.CHR_TIME_CHECKIN desc");

        $data = $result->result();
        $jumlah_data = $result->num_rows();

        $data_table = "";
        $data_table .= "<table style='width:100%;font-weight:600;padding:10px;' border='0px'>";

        $data_table .= "<thead><tr style='height:50px;background:#18181E;'>
                                            <td style='text-align: center;'>NO</th>
                                            <td style='text-align: center;'>NAMA</th>
                                            <td style='text-align: center;'>PDS NO</th>
                                            <td style='text-align: center;'>QTY TARGET</th>
                                            <td style='text-align: center;'>QTY ACT. RECEIVE</th>
                                            <td style='text-align: center;'>TIME ARRIVAL</th>
                                            <td style='text-align: center;'>ACT. TIME ARRIVAL</th>
                                            <td style='text-align: center;'>RESULT</th>
                                        </tr>
                                    </thead><tbody>";

        $i = 1;
        //$a = 20;
        //$row = count($data);
        foreach ($data as $isi) {

            //$starttime = date("H:i", strtotime($isi->CHR_START_TIME));
            //$duetime = date("H:i", strtotime($isi->CHR_DUE_TIME));
            //$startdate = date("d-m-Y", strtotime($isi->CHR_START_DATE));
            //$duedate = date("d-m-Y", strtotime($isi->CHR_START_DATE));



            if ($i % 2 == 0) {
                $data_table .= "<tr class='gradeX' style='background-color:#000000;'>";
//                if ($isi->INT_STATUS == 3){
//                    $data_table .= "<tr class='gradeX' style='background-color:#00EE00;'>";
//                } else {
//                    $data_table .= "<tr class='gradeX' style='background-color:#000000;'>";
//                }
            } else {
                $data_table .= "<tr class='gradeX' style='background-color:#333333;'>";
//                if ($isi->INT_STATUS == 3){
//                    $data_table .= "<tr class='gradeX' style='background-color:#00EE00;'>";
//                } else {
//                    $data_table .= "<tr class='gradeX' style='background-color:#333333;'>";
//                }
            }

            $data_table .= "<td>$i</td>";
            $data_table .= "<td>$isi->CHR_SUPPLIER_NAME</td>";
            $data_table .= "<td>$isi->CHR_PDS_NO</td>";
            $data_table .= "<td>$isi->Part_order</td>";
            $data_table .= "<td>$isi->Part_act</td>";
            $data_table .= "<td >" . date('H:i:s', strtotime($isi->CHR_TIME)) . "</td>";
            $data_table .= "<td>" . date('H:i:s', strtotime($isi->CHR_TIME_CHECKIN)) . "</td>";
            if ($isi->Status == 'Delay') {
                $data_table .= "<td style='background-color:red'>$isi->Status</td>";
            } else {
                $data_table .= "<td style='background-color:blue'>$isi->Status</td>";
            }
            $i++;
        }

        $data_table .= "<tbody>";
        $data_table .= "</table>";

        echo json_encode($data_table);
    }

}
