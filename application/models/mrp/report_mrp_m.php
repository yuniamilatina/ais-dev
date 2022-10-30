<?php

class report_mrp_m extends CI_Model
{	
	
	public function get_actual_order_vs_delivey_by_date($period, $cust)
    {
        $mrp_d = $this->load->database("mrp_d", TRUE);

		$stored_procedure = "EXEC zsp_get_actual_order_vs_delivery ?,?";
		
		$param = array(
					'period' => $period,
                    'cust' => $cust
				);

        $query = $mrp_d->query($stored_procedure, $param);

        return $query->result();
    }

    public function get_actual_order_vs_delivey_by_group_and_date($group, $wc, $period, $cust)
    {
        $mrp_d = $this->load->database("mrp_d", TRUE);

		$stored_procedure = "EXEC zsp_get_actual_order_vs_delivery_by_group_and_period ?,?,?,?";
		
		$param = array(
                    'group' => $group,
                    'wc' => $wc,
					'period' => $period,
                    'cust' => $cust
				);

        $query = $mrp_d->query($stored_procedure, $param);

        return $query->result();
    }

    public function get_list_cust()
    {
        $query = $this->db->query("SELECT DISTINCT SUBSTRING(CHR_CUST_NO,1,5) AS CHR_CUST_NO, CHR_CUST_NAME FROM TM_CUST WHERE LEN(CHR_CUST_NO) <= '8'");

        return $query->result();
    }

}
