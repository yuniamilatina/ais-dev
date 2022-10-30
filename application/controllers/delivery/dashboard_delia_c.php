<?php

class dashboard_delia_c extends CI_Controller {

    public function __construct() {
        parent::__construct();
        //$this->load->model('quality/quality_problem_m');
    }

    public function index() {
        $content = 'delivery/delia/dashboard_delia_v';
        $data['title'] = "Dashboard Delivery Performance";
        $periode = date('Ym');
        $date = date('Ymd');
        $data['date_now'] = $date;
        $data['schedule_cust'] = $this->db->query("select * from DEL.TM_SCHEDULE_DELIVERY where CHR_PERIODE = '$periode'")->result();
        $data['actual_checkin'] = $this->db->query("select a.CHR_PERIODE, a.CHR_CUST, a.CHR_CUST_DESC, a.CHR_CUST_DOCK, a.CHR_DIS_CHANNEL, a.INT_CYCLE, a.CHR_ROUTE, a.CHR_LOG_VENDOR,
                                    a.CHR_DATE_CHECKIN, a.CHR_TIME_CHECKIN, a.INT_CHECKIN_STAT, b.CHR_AII_ARRIVAL, a.CHR_DATE_CHECKOUT, a.CHR_TIME_CHECKOUT, a.INT_CHECKOUT_STAT, b.CHR_AII_DEPARTURE,
                                    (CONVERT(FLOAT,(SUM(a.INT_HELM_STAT) + SUM(a.INT_ROMPI_STAT) + SUM(a.INT_IDCARD_STAT) + SUM(a.INT_SEPATU_STAT) + SUM(a.INT_GANJAL_STAT) + SUM(a.INT_SIM_STAT) + SUM(a.INT_OLI_STAT))) / 8) AS SCORING
                                    from DEL.TT_CHECKIN_DEL_CUST a
                                    left join DEL.TM_SCHEDULE_DELIVERY b on a.CHR_PERIODE = b.CHR_PERIODE and a.CHR_CUST_SAP_NO = b.CHR_CUST_SAP_NO and a.CHR_CUST_DOCK = b.CHR_CUST_DOCK and a.INT_CYCLE = b.INT_CYCLE
                                    where a.CHR_DATE_CHECKIN = '$date'
                                    group by a.CHR_PERIODE, a.CHR_CUST, a.CHR_CUST_DESC, a.CHR_CUST_DOCK, a.CHR_DIS_CHANNEL, a.INT_CYCLE, a.CHR_ROUTE, a.CHR_LOG_VENDOR,
                                    a.CHR_DATE_CHECKIN, a.CHR_TIME_CHECKIN, a.INT_CHECKIN_STAT, b.CHR_AII_ARRIVAL, a.CHR_DATE_CHECKOUT, a.CHR_TIME_CHECKOUT, a.INT_CHECKOUT_STAT, b.CHR_AII_DEPARTURE
                                    order by a.CHR_DATE_CHECKIN, a.CHR_TIME_CHECKIN desc")->result();
        $tot_row = 0;
        if(count($data['actual_checkin']) != 0){
            $tot_row = count($data['actual_checkin']);
        }
        
        $data['tot_row'] = $tot_row;
        
        $this->load->view($content, $data);
    }
    
    public function display_schedule() {
        $content = 'delivery/delia/dashboard_schedule_v';
        $data['title'] = "Dashboard Delivery Schedule";
        $periode = date('Ym');
        $date = date('Ymd');
        $data['date_now'] = $date;
        $data['schedule_cust'] = $this->db->query("select * from DEL.TM_SCHEDULE_DELIVERY where CHR_PERIODE = '$periode' and CHR_FLG_DELETE = '0' order by CHR_AII_ARRIVAL desc")->result();
       
        $tot_row = 0;
        if(count($data['schedule_cust']) != 0){
            $tot_row = count($data['schedule_cust']);
        }
        
        $data['tot_row'] = $tot_row;
        $data['periode'] = $periode;
        
        $this->load->view($content, $data);
    }

//    public function updateAjax() {
//        $date_now = date("Ymd");
//        //$data = $this->sepia_app_m->get_dashboard_result_daily($date_now);
//        $result = $this->db->query("select distinct a.CHR_PDS_NO,b.CHR_SUPPLIER_ID,b.CHR_SUPPLIER_NAME,b.INT_TRUCK,b.CHR_TIME,d.CHR_DELIVERY_DATE,d.CHR_DELIVERY_TIME,SUM (a.INT_QTY) as Part_order, SUM(a.CHR_RECEIPT_PART) as Part_act,c.CHR_DATE_CHECKIN,c.CHR_TIME_CHECKIN,e.CHR_CREATE_DATE,c.CHR_CYCLE_SUPP,
//                            case when ((SUM (a.INT_QTY) = SUM(a.CHR_RECEIPT_PART)) and (c.CHR_TIME_CHECKIN > b.CHR_TIME) and (d.CHR_DELIVERY_DATE = c.CHR_DATE_CHECKIN)) then 'Delayed'
//                            when ((SUM (a.INT_QTY) = SUM(a.CHR_RECEIPT_PART)) and (c.CHR_TIME_CHECKIN > b.CHR_TIME) and (c.CHR_DATE_CHECKIN > d.CHR_DELIVERY_DATE)) then 'Delayed'
//                            when ((SUM (a.INT_QTY) = SUM(a.CHR_RECEIPT_PART)) and (c.CHR_TIME_CHECKIN < b.CHR_TIME) and (c.CHR_DATE_CHECKIN > d.CHR_DELIVERY_DATE)) then 'Delayed'
//                            when ((SUM (a.INT_QTY) <> SUM(a.CHR_RECEIPT_PART)) and (c.CHR_TIME_CHECKIN > b.CHR_TIME) and (d.CHR_DELIVERY_DATE = c.CHR_DATE_CHECKIN)) then 'Delayed'
//                            when ((SUM (a.INT_QTY) <> SUM(a.CHR_RECEIPT_PART)) and (c.CHR_TIME_CHECKIN < b.CHR_TIME) and (d.CHR_DELIVERY_DATE = c.CHR_DATE_CHECKIN)) then 'Delayed'
//                            when ((SUM (a.INT_QTY) <> SUM(a.CHR_RECEIPT_PART)) and (c.CHR_TIME_CHECKIN > b.CHR_TIME) and (c.CHR_DATE_CHECKIN > d.CHR_DELIVERY_DATE)) then 'Delayed'
//                            when ((SUM (a.INT_QTY) <> SUM(a.CHR_RECEIPT_PART)) and (c.CHR_TIME_CHECKIN < b.CHR_TIME) and (c.CHR_DATE_CHECKIN > d.CHR_DELIVERY_DATE)) then 'Delayed'
//                            when ((SUM (a.INT_QTY) <> SUM(a.CHR_RECEIPT_PART)) and (c.CHR_TIME_CHECKIN > b.CHR_TIME) and (d.CHR_DELIVERY_DATE > c.CHR_DATE_CHECKIN)) then 'Advanced'
//                            when ((SUM (a.INT_QTY) <> SUM(a.CHR_RECEIPT_PART)) and (c.CHR_TIME_CHECKIN < b.CHR_TIME) and (d.CHR_DELIVERY_DATE > c.CHR_DATE_CHECKIN)) then 'Advanced'
//                            when ((SUM (a.INT_QTY) = SUM(a.CHR_RECEIPT_PART)) and (c.CHR_TIME_CHECKIN > b.CHR_TIME) and (d.CHR_DELIVERY_DATE > c.CHR_DATE_CHECKIN)) then 'Advanced'
//                            when ((SUM (a.INT_QTY) = SUM(a.CHR_RECEIPT_PART)) and (c.CHR_TIME_CHECKIN < b.CHR_TIME) and (d.CHR_DELIVERY_DATE > c.CHR_DATE_CHECKIN)) then 'Advanced'
//                            when ((SUM (a.INT_QTY) <> SUM(a.CHR_RECEIPT_PART)) and (c.CHR_TIME_CHECKIN < b.CHR_TIME) and (d.CHR_DELIVERY_DATE = c.CHR_DATE_CHECKIN)) then 'Advanced'
//                            when ((SUM (a.INT_QTY) = SUM(a.CHR_RECEIPT_PART)) and (c.CHR_TIME_CHECKIN < b.CHR_TIME) and (d.CHR_DELIVERY_DATE = c.CHR_DATE_CHECKIN)) then 'Advanced'
//                            end as Status,
//                            case when datediff(MINUTE, CAST(d.CHR_DELIVERY_DATE as datetime) + CONVERT(datetime,left(d.CHR_DELIVERY_TIME,2)+':'+SUBSTRING(d.CHR_DELIVERY_TIME,3,2)+':'+right(d.CHR_DELIVERY_TIME,2)), cast(c.CHR_DATE_CHECKIN AS datetime) + CONVERT(datetime,left(c.CHR_TIME_CHECKIN,2)+':'+substring(c.CHR_TIME_CHECKIN,3,2)+':'+right(c.CHR_TIME_CHECKIN,2))) <= -20 then 'A'
//                            when datediff(MINUTE, CAST(d.CHR_DELIVERY_DATE as datetime) + CONVERT(datetime,left(d.CHR_DELIVERY_TIME,2)+':'+SUBSTRING(d.CHR_DELIVERY_TIME,3,2)+':'+right(d.CHR_DELIVERY_TIME,2)), cast(c.CHR_DATE_CHECKIN AS datetime) + CONVERT(datetime,left(c.CHR_TIME_CHECKIN,2)+':'+substring(c.CHR_TIME_CHECKIN,3,2)+':'+right(c.CHR_TIME_CHECKIN,2))) > 20 then 'B'
//                            else 'C' end as Arrival,
//                            (SUM(c.CHR_HELM_STAT) + SUM(c.CHR_ROMPI_STAT) + SUM(c.CHR_IDCARD_STAT) + SUM(c.CHR_SEPATU_STAT) + SUM(c.CHR_GANJAL_STAT))
//                             AS Nilai_awal, 
//                             COUNT(c.CHR_DIRECT_SUPP)*5 AS Pembagi, 
//                             (CONVERT(FLOAT,(SUM(c.CHR_HELM_STAT) + SUM(c.CHR_ROMPI_STAT) + SUM(c.CHR_IDCARD_STAT) + SUM(c.CHR_SEPATU_STAT) + SUM(c.CHR_GANJAL_STAT))))  
//                             / (COUNT(c.CHR_DIRECT_SUPP)*5) AS Nilai_akhir
//                            from TT_ORDERING as a
//                            left join TT_PDS as b on a.CHR_PDS_NO=b.CHR_PDS_NO
//                            left join PPC.TT_CHECKIN_SUPP as c on b.CHR_SUPPLIER_ID=c.CHR_DIRECT_SUPP
//                            left join TT_PURCHASE_ORDER_H as d on d.CHR_PDS_NO=b.CHR_PDS_NO
//                            left join TT_PURCHASE_RECEIPT_H as e on e.CHR_PDS_NO=d.CHR_PDS_NO
//                            where c.CHR_DATE_CHECKIN=e.CHR_CREATE_DATE and c.CHR_DATE_CHECKIN='$date_now' and b.INT_TRUCK=c.CHR_CYCLE_SUPP
//                            group by a.CHR_PDS_NO,b.CHR_SUPPLIER_ID,b.CHR_SUPPLIER_NAME,b.INT_TRUCK,b.CHR_TIME,d.CHR_DELIVERY_DATE,c.CHR_DATE_CHECKIN,c.CHR_TIME_CHECKIN,d.CHR_DELIVERY_TIME,e.CHR_CREATE_DATE,c.CHR_CYCLE_SUPP
//                            union all
//                            select a.CHR_PDS_NO,b.CHR_SUPPLIER_ID,b.CHR_SUPPLIER_NAME,b.INT_TRUCK,b.CHR_TIME,d.CHR_DELIVERY_DATE,d.CHR_DELIVERY_TIME,SUM (a.INT_QTY) as Part_order, SUM(a.CHR_RECEIPT_PART) as Part_act,c.CHR_DATE_CHECKIN,c.CHR_TIME_CHECKIN,e.CHR_CREATE_DATE,c.CHR_CYCLE_SUPP,
//                            case when ((SUM (a.INT_QTY) = SUM(a.CHR_RECEIPT_PART)) and (c.CHR_TIME_CHECKIN > b.CHR_TIME) and (d.CHR_DELIVERY_DATE = c.CHR_DATE_CHECKIN)) then 'Delayed'
//                            when ((SUM (a.INT_QTY) = SUM(a.CHR_RECEIPT_PART)) and (c.CHR_TIME_CHECKIN > b.CHR_TIME) and (c.CHR_DATE_CHECKIN > d.CHR_DELIVERY_DATE)) then 'Delayed'
//                            when ((SUM (a.INT_QTY) = SUM(a.CHR_RECEIPT_PART)) and (c.CHR_TIME_CHECKIN < b.CHR_TIME) and (c.CHR_DATE_CHECKIN > d.CHR_DELIVERY_DATE)) then 'Delayed'
//                            when ((SUM (a.INT_QTY) <> SUM(a.CHR_RECEIPT_PART)) and (c.CHR_TIME_CHECKIN > b.CHR_TIME) and (d.CHR_DELIVERY_DATE = c.CHR_DATE_CHECKIN)) then 'Delayed'
//                            when ((SUM (a.INT_QTY) <> SUM(a.CHR_RECEIPT_PART)) and (c.CHR_TIME_CHECKIN < b.CHR_TIME) and (d.CHR_DELIVERY_DATE = c.CHR_DATE_CHECKIN)) then 'Delayed'
//                            when ((SUM (a.INT_QTY) <> SUM(a.CHR_RECEIPT_PART)) and (c.CHR_TIME_CHECKIN > b.CHR_TIME) and (c.CHR_DATE_CHECKIN > d.CHR_DELIVERY_DATE)) then 'Delayed'
//                            when ((SUM (a.INT_QTY) <> SUM(a.CHR_RECEIPT_PART)) and (c.CHR_TIME_CHECKIN < b.CHR_TIME) and (c.CHR_DATE_CHECKIN > d.CHR_DELIVERY_DATE)) then 'Delayed'
//                            when ((SUM (a.INT_QTY) <> SUM(a.CHR_RECEIPT_PART)) and (c.CHR_TIME_CHECKIN > b.CHR_TIME) and (d.CHR_DELIVERY_DATE > c.CHR_DATE_CHECKIN)) then 'Advanced'
//                            when ((SUM (a.INT_QTY) <> SUM(a.CHR_RECEIPT_PART)) and (c.CHR_TIME_CHECKIN < b.CHR_TIME) and (d.CHR_DELIVERY_DATE > c.CHR_DATE_CHECKIN)) then 'Advanced'
//                            when ((SUM (a.INT_QTY) = SUM(a.CHR_RECEIPT_PART)) and (c.CHR_TIME_CHECKIN > b.CHR_TIME) and (d.CHR_DELIVERY_DATE > c.CHR_DATE_CHECKIN)) then 'Advanced'
//                            when ((SUM (a.INT_QTY) = SUM(a.CHR_RECEIPT_PART)) and (c.CHR_TIME_CHECKIN < b.CHR_TIME) and (d.CHR_DELIVERY_DATE > c.CHR_DATE_CHECKIN)) then 'Advanced'
//                            when ((SUM (a.INT_QTY) <> SUM(a.CHR_RECEIPT_PART)) and (c.CHR_TIME_CHECKIN < b.CHR_TIME) and (d.CHR_DELIVERY_DATE = c.CHR_DATE_CHECKIN)) then 'Advanced'
//                            when ((SUM (a.INT_QTY) = SUM(a.CHR_RECEIPT_PART)) and (c.CHR_TIME_CHECKIN < b.CHR_TIME) and (d.CHR_DELIVERY_DATE = c.CHR_DATE_CHECKIN)) then 'Advanced'
//                            end as Status,
//                            case when datediff(MINUTE, CAST(d.CHR_DELIVERY_DATE as datetime) + CONVERT(datetime,left(d.CHR_DELIVERY_TIME,2)+':'+SUBSTRING(d.CHR_DELIVERY_TIME,3,2)+':'+right(d.CHR_DELIVERY_TIME,2)), cast(c.CHR_DATE_CHECKIN AS datetime) + CONVERT(datetime,left(c.CHR_TIME_CHECKIN,2)+':'+substring(c.CHR_TIME_CHECKIN,3,2)+':'+right(c.CHR_TIME_CHECKIN,2))) <= -20 then 'A'
//                            when datediff(MINUTE, CAST(d.CHR_DELIVERY_DATE as datetime) + CONVERT(datetime,left(d.CHR_DELIVERY_TIME,2)+':'+SUBSTRING(d.CHR_DELIVERY_TIME,3,2)+':'+right(d.CHR_DELIVERY_TIME,2)), cast(c.CHR_DATE_CHECKIN AS datetime) + CONVERT(datetime,left(c.CHR_TIME_CHECKIN,2)+':'+substring(c.CHR_TIME_CHECKIN,3,2)+':'+right(c.CHR_TIME_CHECKIN,2))) > 20 then 'B'
//                            else 'C' end as Arrival,
//                            (SUM(c.CHR_HELM_STAT) + SUM(c.CHR_ROMPI_STAT) + SUM(c.CHR_IDCARD_STAT) + SUM(c.CHR_SEPATU_STAT) + SUM(c.CHR_GANJAL_STAT))
//                             AS Nilai_awal, COUNT(c.CHR_DIRECT_SUPP)*5 AS Pembagi, 
//                             (CONVERT(FLOAT,(SUM(c.CHR_HELM_STAT) + SUM(c.CHR_ROMPI_STAT) + SUM(c.CHR_IDCARD_STAT) + SUM(c.CHR_SEPATU_STAT) + SUM(c.CHR_GANJAL_STAT))))  
//                             / (COUNT(c.CHR_DIRECT_SUPP)*5) AS Nilai_akhir
//                            from TT_ORDERING as a
//                            left join TT_PDS as b on a.CHR_PDS_NO=b.CHR_PDS_NO
//                            left join TT_PURCHASE_ORDER_H as d on d.CHR_PDS_NO=b.CHR_PDS_NO
//                            left join TT_PURCHASE_RECEIPT_H as e on e.CHR_PDS_NO=d.CHR_PDS_NO
//                            left join TM_VENDOR_CYCLE_BIN as f on f.CHR_SUPPLIER_ID=b.CHR_SUPPLIER_ID
//                            left join PPC.TT_CHECKIN_SUPP as c on c.CHR_MILKRUN_SUPP=f.CHR_MILKRUN_ZONE
//                            where c.CHR_DATE_CHECKIN=e.CHR_CREATE_DATE and f.CHR_TRUCK=c.CHR_CYCLE_SUPP and c.CHR_DATE_CHECKIN='$date_now'
//                            group by a.CHR_PDS_NO,b.CHR_SUPPLIER_ID,b.CHR_SUPPLIER_NAME,b.INT_TRUCK,b.CHR_TIME,d.CHR_DELIVERY_DATE,c.CHR_DATE_CHECKIN,c.CHR_TIME_CHECKIN,d.CHR_DELIVERY_TIME,e.CHR_CREATE_DATE,c.CHR_CYCLE_SUPP 
//                            order by c.CHR_DATE_CHECKIN desc, c.CHR_TIME_CHECKIN desc");
//
//        $data = $result->result();
//        $jumlah_data = $result->num_rows();
//
//        $data_table = "";
//        $data_table .= "<table style='width:100%;font-weight:600;padding:10px;' border='0px'>";
//
//        $data_table .= "<thead><tr style='height:50px;background:#18181E;'>
//                                            <td style='text-align: center;'>NO</th>
//                                            <td style='text-align: center;'>NAMA</th>
//                                            <td style='text-align: center;'>PDS NO</th>
//                                            <td style='text-align: center;'>QTY TARGET</th>
//                                            <td style='text-align: center;'>QTY ACT. RECEIVE</th>
//                                            <td style='text-align: center;'>TIME ARRIVAL</th>
//                                            <td style='text-align: center;'>ACT. TIME ARRIVAL</th>
//                                            <td style='text-align: center;'>RESULT</th>
//                                        </tr>
//                                    </thead><tbody>";
//
//        $i = 1;
//        //$a = 20;
//        //$row = count($data);
//        foreach ($data as $isi) {
//
//            //$starttime = date("H:i", strtotime($isi->CHR_START_TIME));
//            //$duetime = date("H:i", strtotime($isi->CHR_DUE_TIME));
//            //$startdate = date("d-m-Y", strtotime($isi->CHR_START_DATE));
//            //$duedate = date("d-m-Y", strtotime($isi->CHR_START_DATE));
//
//
//
//            if ($i % 2 == 0) {
//                $data_table .= "<tr class='gradeX' style='background-color:#000000;'>";
////                if ($isi->INT_STATUS == 3){
////                    $data_table .= "<tr class='gradeX' style='background-color:#00EE00;'>";
////                } else {
////                    $data_table .= "<tr class='gradeX' style='background-color:#000000;'>";
////                }
//            } else {
//                $data_table .= "<tr class='gradeX' style='background-color:#333333;'>";
////                if ($isi->INT_STATUS == 3){
////                    $data_table .= "<tr class='gradeX' style='background-color:#00EE00;'>";
////                } else {
////                    $data_table .= "<tr class='gradeX' style='background-color:#333333;'>";
////                }
//            }
//
//            $data_table .= "<td>$i</td>";
//            $data_table .= "<td>$isi->CHR_SUPPLIER_NAME</td>";
//            $data_table .= "<td>$isi->CHR_PDS_NO</td>";
//            $data_table .= "<td>$isi->Part_order</td>";
//            $data_table .= "<td>$isi->Part_act</td>";
//            $data_table .= "<td >" . date('H:i:s', strtotime($isi->CHR_TIME)) . "</td>";
//            $data_table .= "<td>" . date('H:i:s', strtotime($isi->CHR_TIME_CHECKIN)) . "</td>";
//            if ($isi->Status == 'Delay') {
//                $data_table .= "<td style='background-color:red'>$isi->Status</td>";
//            } else {
//                $data_table .= "<td style='background-color:blue'>$isi->Status</td>";
//            }
//            $i++;
//        }
//
//        $data_table .= "<tbody>";
//        $data_table .= "</table>";
//
//        echo json_encode($data_table);
//    }

}
