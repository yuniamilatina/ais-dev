<?php

class master_schedule_cust_m extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get_all_customer() {
        $cust = $this->db->query("select ((CHR_DIS_CHANNEL)+(RTRIM(CHR_CUST_NO))) AS CHR_CUST, (RTRIM(CHR_CUST_NO))+ ' '+(CHR_DIS_CHANNEL)+ ' '+(RTRIM(REPLACE(CHR_CUST_NAME,',','.'))) AS CHR_CUST_NAME from TM_CUST where (LEN(CHR_CUST_NO) = '7') ORDER BY CHR_CUST_NAME")->result();
        return $cust;
    }
    
    function get_customer($cust_sap_no, $dist_channel) {
        $cust = $this->db->query("select CHR_DIS_CHANNEL, CHR_CUST_NO, CHR_CUST_NAME, CHR_CUST_ADDRESS from TM_CUST where CHR_CUST_NO = '$cust_sap_no' and CHR_DIS_CHANNEL = '$dist_channel'")->row();
        return $cust;
    }
    
    function get_schedule_delivery($periode) {
        $delivery = $this->db->query("select * from DEL.TM_SCHEDULE_DELIVERY where CHR_PERIODE = '$periode'")->result();
        return $delivery;
    }
    
    function get_schedule_by_id($id) {
        $delivery = $this->db->query("select * from DEL.TM_SCHEDULE_DELIVERY where INT_ID = '$id'")->row();
        return $delivery;
    }
    
    function update($data, $id) {
        $this->db->where('INT_ID', $id);
        $this->db->update('DEL.TM_SCHEDULE_DELIVERY', $data);
    }
    
    //===== BASED ON ABSENT ==================================================//
//    function get_history_absent($selected_date){
//        $history = $this->db->query("select a.CHR_PERIODE, a.CHR_CUST, a.CHR_CUST_DESC, 
//                                            a.CHR_CUST_DOCK, a.CHR_DIS_CHANNEL, a.INT_CYCLE, 
//                                            a.CHR_ROUTE, a.CHR_LOG_VENDOR,
//                                            a.CHR_DATE_CHECKIN, a.CHR_TIME_CHECKIN, 
//                                            a.INT_CHECKIN_STAT, b.CHR_AII_ARRIVAL, 
//                                            a.CHR_DATE_CHECKOUT, a.CHR_TIME_CHECKOUT, 
//                                            a.INT_CHECKOUT_STAT, b.CHR_AII_DEPARTURE,
//                                            (CONVERT(FLOAT,(SUM(a.INT_HELM_STAT) + SUM(a.INT_ROMPI_STAT) + SUM(a.INT_IDCARD_STAT) + SUM(a.INT_SEPATU_STAT) + SUM(a.INT_GANJAL_STAT) + SUM(a.INT_SIM_STAT) + SUM(a.INT_OLI_STAT))) / 8) AS SCORING
//                                    from DEL.TT_CHECKIN_DEL_CUST a
//                                    left join DEL.TM_SCHEDULE_DELIVERY b on a.CHR_PERIODE = b.CHR_PERIODE and a.CHR_CUST_SAP_NO = b.CHR_CUST_SAP_NO and a.CHR_CUST_DOCK = b.CHR_CUST_DOCK and a.INT_CYCLE = b.INT_CYCLE
//                                    where a.CHR_DATE_CHECKIN = '$selected_date'
//                                    group by a.CHR_PERIODE, a.CHR_CUST, a.CHR_CUST_DESC, a.CHR_CUST_DOCK, a.CHR_DIS_CHANNEL, a.INT_CYCLE, a.CHR_ROUTE, a.CHR_LOG_VENDOR,
//                                    a.CHR_DATE_CHECKIN, a.CHR_TIME_CHECKIN, a.INT_CHECKIN_STAT, b.CHR_AII_ARRIVAL, a.CHR_DATE_CHECKOUT, a.CHR_TIME_CHECKOUT, a.INT_CHECKOUT_STAT, b.CHR_AII_DEPARTURE
//                                    order by a.CHR_DATE_CHECKIN, a.CHR_TIME_CHECKIN desc")->result();
//        return $history;
//    }
    //===== BASED ON ABSENT ==================================================//
    
    //===== BASED ON SCHEDULE ================================================//    
    function get_history_absent($selected_date){
        $periode = substr($selected_date,0,6);
        $history = $this->db->query("select a.CHR_PERIODE, a.CHR_CUST, a.CHR_CUST_DESC, 
                                            a.CHR_CUST_DOCK, a.CHR_DIS_CHANNEL, a.INT_CYCLE, 
                                            a.CHR_ROUTE, a.CHR_LOG_VENDOR,
                                            b.CHR_DATE_CHECKIN, b.CHR_TIME_CHECKIN, 
                                            b.INT_CHECKIN_STAT, a.CHR_AII_ARRIVAL, 
                                            b.CHR_DATE_CHECKOUT, b.CHR_TIME_CHECKOUT, 
                                            b.INT_CHECKOUT_STAT, a.CHR_AII_DEPARTURE,
                                            b.INT_HELM_STAT, b.INT_ROMPI_STAT, b.INT_IDCARD_STAT, b.INT_SEPATU_STAT, b.INT_GANJAL_STAT, b.INT_SIM_STAT, b.INT_APAR_STAT, b.INT_OLI_STAT,
                                            (CONVERT(FLOAT,(SUM(b.INT_HELM_STAT) + SUM(b.INT_ROMPI_STAT) + SUM(b.INT_IDCARD_STAT) + SUM(b.INT_SEPATU_STAT) + SUM(b.INT_GANJAL_STAT) + SUM(b.INT_SIM_STAT) + SUM(b.INT_APAR_STAT) + SUM(b.INT_OLI_STAT))) / 8) AS SCORING
                                    from DEL.TM_SCHEDULE_DELIVERY a
                                    left join 
                                    (select * from DEL.TT_CHECKIN_DEL_CUST where CHR_DATE_CHECKIN = '$selected_date') b on a.CHR_PERIODE = b.CHR_PERIODE and a.CHR_CUST_SAP_NO = b.CHR_CUST_SAP_NO and a.CHR_CUST_DOCK = b.CHR_CUST_DOCK and a.INT_CYCLE = b.INT_CYCLE
                                    where a.CHR_PERIODE = '$periode'
                                    group by a.CHR_PERIODE, a.CHR_CUST, a.CHR_CUST_DESC, a.CHR_CUST_DOCK, a.CHR_DIS_CHANNEL, a.INT_CYCLE, a.CHR_ROUTE, a.CHR_LOG_VENDOR,
                                    b.CHR_DATE_CHECKIN, b.CHR_TIME_CHECKIN, b.INT_CHECKIN_STAT, a.CHR_AII_ARRIVAL, b.CHR_DATE_CHECKOUT, b.CHR_TIME_CHECKOUT, b.INT_CHECKOUT_STAT, a.CHR_AII_DEPARTURE,
                                    b.INT_HELM_STAT, b.INT_ROMPI_STAT, b.INT_IDCARD_STAT, b.INT_SEPATU_STAT, b.INT_GANJAL_STAT, b.INT_SIM_STAT, b.INT_APAR_STAT, b.INT_OLI_STAT
                                    order by b.CHR_DATE_CHECKIN, b.CHR_TIME_CHECKIN desc")->result();
        return $history;
    }    
    
    function get_history_absent_monthly($periode){
        $history = $this->db->query("select a.CHR_PERIODE, a.CHR_CUST, a.CHR_CUST_DESC, 
                                            a.CHR_CUST_DOCK, a.CHR_DIS_CHANNEL, a.INT_CYCLE, 
                                            a.CHR_ROUTE, a.CHR_LOG_VENDOR,
                                            b.CHR_DATE_CHECKIN, b.CHR_TIME_CHECKIN, 
                                            b.INT_CHECKIN_STAT, a.CHR_AII_ARRIVAL, 
                                            b.CHR_DATE_CHECKOUT, b.CHR_TIME_CHECKOUT, 
                                            b.INT_CHECKOUT_STAT, a.CHR_AII_DEPARTURE,
                                            b.INT_HELM_STAT, b.INT_ROMPI_STAT, b.INT_IDCARD_STAT, b.INT_SEPATU_STAT, b.INT_GANJAL_STAT, b.INT_SIM_STAT, b.INT_APAR_STAT, b.INT_OLI_STAT,
                                            (CONVERT(FLOAT,(SUM(b.INT_HELM_STAT) + SUM(b.INT_ROMPI_STAT) + SUM(b.INT_IDCARD_STAT) + SUM(b.INT_SEPATU_STAT) + SUM(b.INT_GANJAL_STAT) + SUM(b.INT_SIM_STAT) + SUM(b.INT_APAR_STAT) + SUM(b.INT_OLI_STAT))) / 8) AS SCORING
                                    from DEL.TM_SCHEDULE_DELIVERY a
                                    left join 
                                    DEL.TT_CHECKIN_DEL_CUST b on a.CHR_PERIODE = b.CHR_PERIODE and a.CHR_CUST_SAP_NO = b.CHR_CUST_SAP_NO and a.CHR_CUST_DOCK = b.CHR_CUST_DOCK and a.INT_CYCLE = b.INT_CYCLE
                                    where a.CHR_PERIODE = '$periode'
                                    group by a.CHR_PERIODE, a.CHR_CUST, a.CHR_CUST_DESC, a.CHR_CUST_DOCK, a.CHR_DIS_CHANNEL, a.INT_CYCLE, a.CHR_ROUTE, a.CHR_LOG_VENDOR,
                                    b.CHR_DATE_CHECKIN, b.CHR_TIME_CHECKIN, b.INT_CHECKIN_STAT, a.CHR_AII_ARRIVAL, b.CHR_DATE_CHECKOUT, b.CHR_TIME_CHECKOUT, b.INT_CHECKOUT_STAT, a.CHR_AII_DEPARTURE,
                                    b.INT_HELM_STAT, b.INT_ROMPI_STAT, b.INT_IDCARD_STAT, b.INT_SEPATU_STAT, b.INT_GANJAL_STAT, b.INT_SIM_STAT, b.INT_APAR_STAT, b.INT_OLI_STAT
                                    order by b.CHR_DATE_CHECKIN, b.CHR_TIME_CHECKIN desc")->result();
        return $history;
    }
    //===== BASED ON SCHEDULE ================================================//
    
}
