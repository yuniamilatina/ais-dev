<?php

class manage_mrp_m extends CI_Model
{

	
	function get_data_group($group)
	{
		$mrp_d = $this->load->database("mrp_d", TRUE);
		$mrp_d = $mrp_d->query("SELECT * FROM TM_GROUP_FG where CHR_GROUP='$group' ORDER BY CHR_GROUP ASC");
		return $mrp_d->result();
	}

	public function get_detail_part_no($partno)
    {
        $query = $this->db->query("SELECT A. CHR_PART_NO, A.CHR_PART_NAME, B.CHR_BACK_NO
                    FROM TM_PARTS AS A
					LEFT JOIN (SELECT DISTINCT CHR_PART_NO, CHR_BACK_NO 
						FROM TM_KANBAN 
						WHERE (CHR_KANBAN_TYPE='5' OR CHR_KANBAN_TYPE='1' OR CHR_KANBAN_TYPE='0') AND (CHR_PART_NO  = '$partno')) AS B ON A.CHR_PART_NO = B.CHR_PART_NO
                    WHERE A.CHR_PART_NO = '$partno'");

        return $query;
    }

	public function get_bom_by_part_no($partno)
    {
		$mrp_d = $this->load->database("mrp_d", TRUE);
        $query = $mrp_d->query("SELECT * FROM (SELECT A.INT_ID, 'A' AS BY_SAP, A.CHR_PART_NO_FG, A.CHR_PART_NO_COMP, A.INT_LEVEL_BOM, CAST(A.INT_QTY AS DECIMAL(15,3)) AS QTY, A.CHR_UOM, A.CHR_SLOC, A.CHR_AREA, A.CHR_FLG_PHANTOM, 
							A.CHR_SOURCE, A.CHR_SUPPLIER_ID, A.CHR_USER_CREATE, A.CHR_CREATE_DATE, A.CHR_CREATE_TIME, B.CHR_PART_NAME
                    FROM TM_BOM_SAP A
					LEFT JOIN DB_AIS.dbo.TM_PARTS AS B ON A.CHR_PART_NO_COMP = B.CHR_PART_NO
                    WHERE CHR_PART_NO_FG = '$partno' AND INT_FLG_DELETE = '0'
					UNION
					SELECT A.INT_ID, 'X' AS BY_SAP, A.CHR_PART_NO_FG, A.CHR_PART_NO_COMP, A.INT_LEVEL_BOM, CAST(A.CHR_QTY AS DECIMAL(15,3)) AS QTY, A.CHR_UOM, A.CHR_SLOC, A.CHR_AREA, A.CHR_FLG_PHANTOM, 
							A.CHR_SOURCE, A.CHR_SUPPLIER_ID, A.CHR_USER_CREATE, A.CHR_CREATE_DATE, A.CHR_CREATE_TIME, B.CHR_PART_NAME
                    FROM TM_BOM_EXTEND A
					LEFT JOIN DB_AIS.dbo.TM_PARTS AS B ON A.CHR_PART_NO_COMP = B.CHR_PART_NO
                    WHERE CHR_PART_NO_FG = '$partno' AND INT_FLG_DELETE = '0') AS BOM ORDER BY BY_SAP ASC, INT_ID ASC");

        return $query;
    }

	function get_part_assy()
	{
		$query = $this->db->query("select distinct CHR_PART_NO,CHR_BACK_NO from TM_KANBAN where CHR_KANBAN_TYPE='5' and (CHR_FLAG_DELETE <>'X' or CHR_FLAG_DELETE is null)");
		return $query->result();
	}

	function get_all_part()
	{
		$query = $this->db->query("select distinct CHR_PART_NO,CHR_BACK_NO from TM_KANBAN where (CHR_KANBAN_TYPE='5' or CHR_KANBAN_TYPE='1' or CHR_KANBAN_TYPE='0') and (CHR_FLAG_DELETE <>'X' or CHR_FLAG_DELETE is null) order by CHR_BACK_NO asc");
		return $query->result();
	}

	function get_all_part_by_group($id_group_product)
	{
		$stored_procedure = "EXEC zsp_get_list_part_by_group_product ?";
        $param = array(
            'id_group_product' => $id_group_product
        );

        $query = $this->db->query($stored_procedure, $param);

        return $query->result();
	}

	function get_all_part_by_group_mrp($id_group_product)
	{
		$stored_procedure = "EXEC zsp_get_list_part_by_group_product_mrp ?";
        $param = array(
            'group_product_code' => $id_group_product
        );

        $query = $this->db->query($stored_procedure, $param);

        return $query->result();
	}

	// function get_all_order_type($group, $month)
	// {
	// 	$mrp_d = $this->load->database("mrp_d", TRUE);
	// 	$query = $mrp_d->query("select distinct CHR_TYPE, COUNT(CHR_TYPE) AS TOTAL_TYPE 
	// 							from TT_OPTIMIZE_CAPACITY 
	// 							where CHR_WORK_CENTER in (select CHR_WORK_CENTER from TM_GROUP_PRODUCT where CHR_GROUP_PRODUCT_CODE = '$group' and INT_FLG_DELETE = '0') 
	// 								and CHR_MONTH = '$month' 
	// 								and INT_FLG_DELETE = '0' 
	// 							group by CHR_TYPE");
	// 	return $query->result();
	// }

	function get_all_order_type()
	{
		$mrp_d = $this->load->database("mrp_d", TRUE);
		$query = $mrp_d->query("select distinct CHR_TYPE, INT_PRIORITY, COUNT(CHR_TYPE) AS TOTAL_TYPE 
								from TM_ORDER_TYPE 
								where INT_FLG_DELETE = '0' 
								group by CHR_TYPE, INT_PRIORITY");
		return $query->result();
	}	

	function get_all_capacity($group)
	{
		$mrp_d = $this->load->database("mrp_d", TRUE);
		$query = $mrp_d->query("select distinct CHR_WORK_CENTER, INT_PCS_PER_DAY, INT_PCS_PER_MONTH from TM_CAPACITY_MRP where CHR_WORK_CENTER in (select CHR_WORK_CENTER from TM_GROUP_PRODUCT where CHR_GROUP_PRODUCT_CODE = '$group' and INT_FLG_DELETE = '0')");
		return $query->result();
	}

	function get_group_fg_by_id($id)
	{
		$mrp_d = $this->load->database("mrp_d", TRUE);
		return $mrp_d->query("SELECT * FROM TM_GROUP_FG WHERE INT_ID = '$id'")->row();
	}

	function get_routing($part)
	{
		$mrp_d = $this->load->database("mrp_d", TRUE);
		$mrp_d = $mrp_d->query("SELECT distinct a.*,b.CHR_BACK_NO FROM DB_MRP_DEV.dbo.TM_ROUTING_MRP a inner join DB_AIS.dbo.TM_KANBAN b
								on b.CHR_PART_NO=a.CHR_PART_NO where a.CHR_PART_NO='$part' order by a.CHR_PV asc");
		return $mrp_d->result();
	}

	function get_all_product_group()
	{
		$query = $this->db->query("SELECT distinct INT_ID, CHR_PRODUCT_GROUP FROM PRD.TM_GROUP_PRODUCT WHERE INT_FLG_DELETE = '0' ORDER BY CHR_PRODUCT_GROUP");
		return $query->result();
	}

	function get_all_product_group_mrp()
	{
		$mrp_d = $this->load->database("mrp_d", TRUE);
		$query = $mrp_d->query("SELECT distinct CHR_GROUP_PRODUCT_CODE, CHR_GROUP_PRODUCT_DESC FROM TM_GROUP_PRODUCT WHERE INT_FLG_DELETE = '0' ORDER BY CHR_GROUP_PRODUCT_CODE");
		return $query->result();
	}

	function get_line_prd()
	{
		$query = $this->db->query("SELECT distinct CHR_WCENTER,INT_DEPT FROM TM_DIRECT_BACKFLUSH_GENERAL ORDER BY CHR_WCENTER ASC");
		return $query->result();
	}

	function check_cpty($line)
	{
		$mrp_d = $this->load->database("mrp_d", TRUE);
		$query = $mrp_d->query("SELECT TOP 1 * FROM TM_CAPACITY_MRP WHERE CHR_WORK_CENTER = '$line'");

		if ($query->num_rows() > 0) {
			return 1;
		} else {
			return 0;
		}
	}

	function save_capacity($data_pr)
	{
		$mrp_d = $this->load->database("mrp_d", TRUE);
		$mrp_d->insert('TM_CAPACITY_MRP', $data_pr);
	}

	function get_route_id($partno, $pv)
	{
		$mrp_d = $this->load->database("mrp_d", TRUE);
		return $mrp_d->query("SELECT * FROM TM_ROUTING_MRP WHERE CHR_PART_NO = '$partno' and CHR_PV='$pv'")->row();
	}

	function del_routing($partno, $pv)
	{
		$mrp_d = $this->load->database("mrp_d", TRUE);
		$session = $this->session->all_userdata();
		$data = array(
			'CHR_MAIN_STATUS' => 'X',
			'CHR_UPDATE_BY' => $session['NPK'],
			'CHR_UPDATE_TIME' => date('His'),
			'CHR_UPDATE_DATE' => date('Ymd')
		);

		$mrp_d->where('CHR_PART_NO', $partno);
		$mrp_d->where('CHR_PV', $pv);
		$mrp_d->update('TM_ROUTING_MRP', $data);
	}

	function aktif_route($partno, $pv)
	{
		$mrp_d = $this->load->database("mrp_d", TRUE);
		$session = $this->session->all_userdata();
		$data = array(
			'CHR_MAIN_STATUS' => 'T',
			'CHR_UPDATE_BY' => $session['NPK'],
			'CHR_UPDATE_TIME' => date('His'),
			'CHR_UPDATE_DATE' => date('Ymd')
		);

		$mrp_d->where('CHR_PART_NO', $partno);
		$mrp_d->where('CHR_PV', $pv);
		$mrp_d->update('TM_ROUTING_MRP', $data);
	}

	function get_line_id($id)
	{
		$mrp_d = $this->load->database("mrp_d", TRUE);
		return $mrp_d->query("SELECT * FROM TM_CAPACITY_MRP WHERE INT_ID = '$id'")->row();
	}

	function update_route($data, $partno, $pv)
	{
		$mrp_d = $this->load->database("mrp_d", TRUE);
		$mrp_d->where('CHR_PART_NO', $partno);
		$mrp_d->where('CHR_PV', $pv);
		$mrp_d->update('TM_ROUTING_MRP', $data);
	}

	function all_part()
	{
		$mrp_d = $this->load->database("mrp_d", TRUE);
		$sql = "SELECT distinct CHR_PART_NO 
					FROM TM_ROUTING_MRP";
		return $mrp_d->query($sql)->result();
	}

	function get_data_capacity()
	{
		$mrp_d = $this->load->database("mrp_d", TRUE);
		$sql = "SELECT * 
					FROM TM_CAPACITY_MRP";
		return $mrp_d->query($sql)->result();
	}

	function update_cap($data, $id)
	{
		$mrp_d = $this->load->database("mrp_d", TRUE);
		$mrp_d->where('INT_ID', $id);
		$mrp_d->update('TM_CAPACITY_MRP', $data);
	}

	function update_groupfg($data, $id)
	{
		$mrp_d = $this->load->database("mrp_d", TRUE);
		$mrp_d->where('INT_ID', $id);
		$mrp_d->update('TM_GROUP_FG', $data);
	}

	public function get_data_all_wo($FILTER)
    {
        $mrp_d = $this->load->database("mrp_d", TRUE);
        $query = $mrp_d->query("SELECT * FROM TT_WO_CUST where CHR_MONTH like '%" . $FILTER . "%' or CHR_PARTNO_CUST like '%" . $FILTER . "%' or CHR_PARTNO_AII like '%" . $FILTER . "%' or CHR_PART_NAME like '%" . $FILTER . "%' or CHR_CUST_NAME like '%" . $FILTER . "%'");
        return $query->result();
    }

	function get_month()
    {
        $query = $this->db->query("select distinct CHR_MONTH from TT_WO_CUST");
        return $query->result();
    }

    public function get_data_wo($partno, $mon_now)
    {
        $query = $this->db->query("SELECT * FROM TT_WO_CUST where CHR_MONTH like '%" . $mon_now . "%' and CHR_PARTNO_AII like '%" . $partno . "%' ");
        return $query->result();
    }

    public function get_data_all_wo_per_month($CHR_MONTH, $INT_REV, $FILTER)
    {
        $mrp_d = $this->load->database("mrp_d", TRUE);
        $query = $mrp_d->query("SELECT * FROM TT_WO_CUST 
                where CHR_MONTH = '$CHR_MONTH' and INT_REV = '$INT_REV' and 
                (CHR_PART_NO_CUST like '%" . $FILTER . "%' or CHR_PART_NO like '%" . $FILTER . "%' 
                or CHR_PART_NAME like '%" . $FILTER . "%' or CHR_CUST_NAME like '%" . $FILTER . "%')");
        return $query->result();
    }

    public function get_all_part_cust($month)
    {
        // $mssql = $this->load->database("mssql", TRUE);
        // $query = $this->db->query("SELECT a.*,b.CHR_PART_NAME,c.CHR_CUST_NAME FROM TM_SHIPPING_PARTS a inner join TM_PARTS b on a.CHR_PART_NO=b.CHR_PART_NO 
        //                         inner join TM_CUST c on c.CHR_CUST_NO=a.CHR_CUS_NO where c.CHR_DIS_CHANNEL=a.CHR_DIS_CHANNEL and (a.CHR_PART_NO like '%321%' or a.CHR_PART_NO like '%312%') order by a.CHR_CUS_NO asc");
        $query = $this->db->query("SELECT distinct a.CHR_DIS_CHANNEL,a.CHR_CUS_NO,a.CHR_PART_NO,d.CHR_BACK_NO,a.CHR_CUS_PART_NO,b.CHR_PART_NAME,
                                    c.CHR_CUST_NAME,e.INT_N,e.INT_N1,e.INT_N2,e.INT_N3,e.INT_N4,e.INT_N5,e.INT_N6,e.INT_TOTAL,h.INT_TOTAL_QTY,h.INT_ACTUAL_DEL,i.AKTUAL_PROD  
                                    FROM TM_SHIPPING_PARTS a inner join TM_PARTS b on a.CHR_PART_NO=b.CHR_PART_NO 
                                    inner join TM_CUST c on c.CHR_CUST_NO=a.CHR_CUS_NO 
                                    inner join TM_KANBAN d on d.CHR_PART_NO=b.CHR_PART_NO
                                    inner join TT_WO_CUST e on e.CHR_PARTNO_AII=a.CHR_PART_NO
                                    inner join (select f.CHR_PART_NO,sum(f.INT_TOTAL_QTY) as INT_TOTAL_QTY,sum(f.INT_ACTUAL_DEL) as INT_ACTUAL_DEL 
                                                FROM TT_DELIVERY_ITEM f inner join TT_DELIVERY g on f.CHR_DEL_NO=g.CHR_DEL_NO
                                                WHERE g.CHR_CREATE_DATE like '$month%' and f.CHR_DELETE_FLAG is null
                                                group by f.CHR_PART_NO) h on h.CHR_PART_NO=a.CHR_PART_NO
                                    inner join (select CHR_PART_NO,sum(INT_TOTAL_QTY) as AKTUAL_PROD from TT_PRODUCTION_RESULT 
			                                    where CHR_DATE like '$month%' group by CHR_PART_NO) i on i.CHR_PART_NO=a.CHR_PART_NO
                                    where a.CHR_CUS_PART_NO<>'' and c.CHR_DIS_CHANNEL=a.CHR_DIS_CHANNEL 
                                    and (a.CHR_PART_NO like '321%' or a.CHR_PART_NO like '-321%' or a.CHR_PART_NO like '312%' or a.CHR_PART_NO like '-312%') 
                                    and d.CHR_KANBAN_TYPE='5' and c.CHR_CUST_NAME not like 'other%' and a.CHR_CUS_NO not like '01%' order by a.CHR_CUS_NO asc");
        return $query->result();
    }

    function select_data_by_dept_and_work_center($startdate, $finishdate, $workctr)
    {
        $stored_procedure = "EXEC PPC.zsp_get_stock_kanban_fg ?,?,?";
        $param = array(
            'workctr' => $workctr,
            'date_awal' => $startdate,
            'date_akhir' => $finishdate
        );

        $query = $this->db->query($stored_procedure, $param);

        return $query->result();
    }

    function get_all_work_center_by_dept($dept_crop)
    {
        if ($dept_crop == '011' || $dept_crop == '012' || $dept_crop == '013' || $dept_crop == '014') {
            $query = $this->db->query("select DISTINCT(CHR_WORK_CENTER) FROM TM_PROCESS_PARTS WHERE CHR_PERSON_RESPONSIBLE = $dept_crop ORDER BY CHR_WORK_CENTER");
        } else {
            $query = $this->db->query("select DISTINCT(CHR_WORK_CENTER) FROM TM_PROCESS_PARTS ORDER BY CHR_WORK_CENTER");
        }

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return 0;
        }
    }

    function get_top_work_center_by_dept($dept_crop)
    {
        if ($dept_crop == '011' || $dept_crop == '012' || $dept_crop == '013' || $dept_crop == '014') {
            $query = $this->db->query("select TOP(1) PR.CHR_WORK_CENTER from  TT_PRODUCTION_RESULT PR INNER JOIN 
					TM_PROCESS_PARTS PP ON PR.CHR_WORK_CENTER = PP.CHR_WORK_CENTER AND PR.CHR_PART_NO = PP.CHR_PART_NO AND PP.CHR_PERSON_RESPONSIBLE = $dept_crop
					ORDER BY PR.CHR_WORK_CENTER");
        } else {
            $query = $this->db->query("select TOP(1) PR.CHR_WORK_CENTER from  TT_PRODUCTION_RESULT PR INNER JOIN 
					TM_PROCESS_PARTS PP ON PR.CHR_WORK_CENTER = PP.CHR_WORK_CENTER AND PR.CHR_PART_NO = PP.CHR_PART_NO
					ORDER BY PR.CHR_WORK_CENTER");
        }

        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return 0;
        }
    }

	function get_list_part_group()
	{
		$mrp_d = $this->load->database("mrp_d", TRUE);
		return $mrp_d->query("SELECT * FROM TM_PART_GROUP WHERE INT_FLG_DELETE = '0'")->result();
	}

	function get_list_part_extend($id_group)
	{
		return $this->db->query("SELECT * FROM TM_PARTS WHERE CHR_PART_GROUP LIKE '$id_group%' AND (CHR_FLAG_DELETE = '' OR CHR_FLAG_DELETE IS NULL)  ORDER BY CHR_PART_NO ASC");
	}

	function get_detail_part_extend($id_part)
	{
		return $this->db->query("SELECT * FROM TM_PARTS WHERE CHR_PART_NO LIKE '$id_part%' AND CHR_FLAG_DELETE <> 'X'")->row();
	}

	function check_extend_comp($partno, $partno_comp)
	{
		$mrp_d = $this->load->database("mrp_d", TRUE);
		return $mrp_d->query("SELECT * FROM TM_BOM_EXTEND WHERE CHR_PART_NO_FG = '$partno' AND CHR_PART_NO_COMP = '$partno_comp' AND INT_FLG_DELETE = '0'");
	}

	function get_supplier_by_comp($part_no_comp)
	{
		return $this->db->query("SELECT * FROM TM_VENDOR_PARTS AS A 
					LEFT JOIN TM_VENDOR AS B ON A.CHR_SUPPLIER_ID = B.CHR_SUPPLIER_ID WHERE A.CHR_PART_NO = '$part_no_comp'");
	}

	function save_component($data)
	{
		$mrp_d = $this->load->database("mrp_d", TRUE);
		$mrp_d->insert('TM_BOM_EXTEND', $data);
	}

	function update_component($data, $id)
	{
		$mrp_d = $this->load->database("mrp_d", TRUE);
		$mrp_d->where('INT_ID', $id);
		$mrp_d->update('TM_BOM_EXTEND', $data);
	}

	function explode_material_by_work_center_and_period_chute($work_center, $period){
		$mrp_d = $this->load->database("mrp_d", TRUE);

		$stored_procedure = "EXEC zsp_explode_material_by_work_center_and_period_chute ?,?";
		
		$param = array(
					'wcenter' => $work_center,
					'period' => $period
				);

        $query = $mrp_d->query($stored_procedure, $param);

        return $query->result();
	}

	function explode_material_by_work_center_and_sequence_chute($work_center, $start, $end){
		$mrp_d = $this->load->database("mrp_d", TRUE);

		$stored_procedure = "EXEC zsp_explode_material_by_work_center_and_sequence_chute ?,?,?";
		
		$param = array(
					'wcenter' => $work_center,
					'start' => $start,
					'end' => $end
				);

        $query = $mrp_d->query($stored_procedure, $param);

        return $query->result();
	}

	function explode_material_by_group_and_period_chute($group_prd, $period){
		$mrp_d = $this->load->database("mrp_d", TRUE);

		$stored_procedure = "EXEC zsp_explode_material_by_group_and_period_chute ?,?";
		
		$param = array(
					'group' => $group_prd,
					'period' => $period
				);

        $query = $mrp_d->query($stored_procedure, $param);

        return $query->result();
	}

	function explode_material_by_group_and_sequence_chute($group_prd, $start, $end){
		$mrp_d = $this->load->database("mrp_d", TRUE);

		$stored_procedure = "EXEC zsp_explode_material_by_group_and_sequence_chute ?,?,?";
		
		$param = array(
					'group' => $group_prd,
					'start' => $start,
					'end' => $end
				);

        $query = $mrp_d->query($stored_procedure, $param);

        return $query->result();
	}

	function get_top_group_prd()
	{
		$mrp_d = $this->load->database("mrp_d", TRUE);
		return $mrp_d->query("SELECT DISTINCT TOP 1 CHR_GROUP_PRODUCT_CODE, CHR_GROUP_PRODUCT_DESC FROM TM_GROUP_PRODUCT WHERE INT_FLG_DELETE = '0' ORDER BY CHR_GROUP_PRODUCT_CODE ASC");
	}

	function get_all_group_prd()
	{
		$mrp_d = $this->load->database("mrp_d", TRUE);
		return $mrp_d->query("SELECT DISTINCT CHR_GROUP_PRODUCT_CODE, CHR_GROUP_PRODUCT_DESC FROM TM_GROUP_PRODUCT WHERE INT_FLG_DELETE = '0' ORDER BY CHR_GROUP_PRODUCT_CODE ASC");
	}

	function get_top_work_center_by_group_prd($group_prd)
	{
		$mrp_d = $this->load->database("mrp_d", TRUE);
		return $mrp_d->query("SELECT DISTINCT TOP 1 CHR_WORK_CENTER FROM TM_GROUP_PRODUCT WHERE CHR_GROUP_PRODUCT_CODE = '$group_prd' AND INT_FLG_DELETE = '0' ORDER BY CHR_WORK_CENTER ASC");
	}

	function get_all_work_center_by_group_prd($group_prd)
	{
		$mrp_d = $this->load->database("mrp_d", TRUE);
		return $mrp_d->query("SELECT DISTINCT A.CHR_WORK_CENTER, B.INT_PRIORITY, B.INT_PCS_PER_DAY, B.INT_PCS_PER_MONTH, COUNT(A.CHR_WORK_CENTER) AS TOTAL_WC 
						FROM TM_GROUP_PRODUCT A
						LEFT JOIN TM_CAPACITY_MRP B ON A.CHR_WORK_CENTER = B.CHR_WORK_CENTER
						WHERE A.CHR_GROUP_PRODUCT_CODE = '$group_prd' AND A.INT_FLG_DELETE = '0' 
						GROUP BY A.CHR_WORK_CENTER, B.INT_PRIORITY, B.INT_PCS_PER_DAY, B.INT_PCS_PER_MONTH
						ORDER BY CHR_WORK_CENTER ASC");
	}

	function get_all_work_center_by_group_prd_v2($group_prd)
	{
		$mrp_d = $this->load->database("mrp_d", TRUE);
		return $mrp_d->query("SELECT DISTINCT CHR_ITEM AS CHR_WORK_CENTER, INT_PRIORITY, INT_CAPACITY, COUNT(CHR_ITEM) AS TOTAL_WC 
						FROM TW_OPTIMIZE_CAPACITY
						WHERE CHR_GROUP_PRODUCT_CODE = '$group_prd' AND CHR_CATEGORY = 'WORK_CENTER' 
						GROUP BY CHR_ITEM, INT_PRIORITY, INT_CAPACITY
						ORDER BY INT_PRIORITY ASC");
	}

	function get_all_work_center_mfg_by_group_prd_v2($group_prd)
	{
		$mrp_d = $this->load->database("mrp_d", TRUE);
		return $mrp_d->query("SELECT DISTINCT CHR_ITEM AS CHR_WORK_CENTER, INT_PRIORITY, INT_CAPACITY, COUNT(CHR_ITEM) AS TOTAL_WC_MFG  
						FROM TW_OPTIMIZE_CAPACITY
						WHERE CHR_GROUP_PRODUCT_CODE = '$group_prd' AND CHR_CATEGORY = 'WORK_CENTER_MFG' 
						GROUP BY CHR_ITEM, INT_PRIORITY, INT_CAPACITY
						ORDER BY INT_PRIORITY ASC");
	}

	function get_all_order_type_v2($group_prd)
	{
		$mrp_d = $this->load->database("mrp_d", TRUE);
		$query = $mrp_d->query("SELECT DISTINCT CHR_ITEM AS CHR_TYPE, INT_PRIORITY, COUNT(CHR_ITEM) AS TOTAL_TYPE 
								FROM TW_OPTIMIZE_CAPACITY 
								WHERE CHR_GROUP_PRODUCT_CODE = '$group_prd' AND CHR_CATEGORY = 'ORDER' 
								GROUP BY CHR_ITEM, INT_PRIORITY
								ORDER BY INT_PRIORITY");
		return $query->result();
	}

}
