<?php

class kanban_cust_m extends CI_Model {


    function get_cust_no() {
        $query = $this->db->query("SELECT DISTINCT TM_SHIPPING_PARTS.CHR_PART_NO,TM_SHIPPING_PARTS.CHR_CUS_PART_NO,
                        TM_PARTS.CHR_PART_NAME,
                        CASE TM_KANBAN.CHR_KANBAN_TYPE WHEN '5' THEN 'PICKUP'
                        WHEN '0' THEN 'ORDER'
                        ELSE '-' END AS [TYPE_KANBAN],
                        CASE WHEN TM_KANBAN.CHR_BACK_NO IS NULL THEN 'NO KANBAN'
                        ELSE TM_KANBAN.CHR_BACK_NO END AS [CHR_BACK_NO]

                        FROM TM_SHIPPING_PARTS
                        FULL JOIN TM_KANBAN ON TM_KANBAN.CHR_PART_NO = TM_SHIPPING_PARTS.CHR_PART_NO
                        FULL JOIN TM_PARTS ON TM_PARTS.CHR_PART_NO = TM_SHIPPING_PARTS.CHR_PART_NO
                        WHERE TM_SHIPPING_PARTS.CHR_PART_NO IS NOT NULL
                        ORDER BY TM_SHIPPING_PARTS.CHR_CUS_PART_NO DESC");
        return $query->result();
    }
   

}
