<?php

class direct_backflush_general_m extends CI_Model
{

    private $tabel = 'TM_DIRECT_BACKFLUSH_GENERAL';

    public function __construct()
    {
        parent::__construct();
    }

    function save($data)
    {
        $this->db->insert($this->tabel, $data);
    }

    function update($data, $id)
    {
        $this->db->where($id);
        $this->db->update($this->tabel, $data);
    }

    function delete($id)
    {
        $data = array('INT_FLG_DEL' => 1);

        $this->db->where('INT_ID', $id);
        $this->db->update($this->tabel, $data);
    }

    function get_data_direct_backflush_general()
    {
        $query =  $this->db->query("SELECT ISNULL(CHR_PRODUCT_GROUP,'-') CHR_PRODUCT_GROUP, CHR_WCENTER,CHR_REMARK, INT_LIVE, INT_DEPT, INT_PRODUCT_CODE, INT_PRODUCT_GROUP, 
        CASE WHEN INT_FLG_BREAKDOWN = 0 THEN 'DIES & JIG'
             WHEN INT_FLG_BREAKDOWN = 1 THEN 'JIG'
             WHEN INT_FLG_BREAKDOWN = 2 THEN 'DIES'
        END AS INT_FLG_BREAKDOWN,
        CASE WHEN INT_DEPT = '21' THEN 'PR1'
             WHEN INT_DEPT = '22' THEN 'PR2'
             WHEN INT_DEPT = '23' THEN 'PR3'
             WHEN INT_DEPT = '24' THEN 'PR4'
        END AS [TYPE_PRODUCTION],
        CASE WHEN INT_LIVE ='1' THEN 'ACTIVE'
             WHEN INT_LIVE ='0' THEN 'NON ACTIVE'
        END AS [TYPE_ACTIVE]	  
        FROM TM_DIRECT_BACKFLUSH_GENERAL DBG LEFT JOIN PRD.TM_GROUP_LINE GL ON GL.INT_ID = DBG.INT_PRODUCT_CODE
        ORDER BY CHR_WCENTER");

        return $query->result();
    }

    function get_top_data_direct_backflush_general()
    {
        $sql = "SELECT TOP 1 * FROM $this->tabel";

        return $this->db->query($sql)->row()->CHR_WCENTER;
    }

    function get_active_data_work_center()
    {
        $sql = "SELECT * FROM TM_DIRECT_BACKFLUSH_GENERAL WHERE INT_LIVE = 1";

        return $this->db->query($sql)->result();
    }

    function get_active_data_work_center_with_all()
    {
        $sql = "SELECT 'ALL' AS CHR_WORK_CENTER 
        UNION ALL 
        SELECT CHR_WCENTER AS CHR_WORK_CENTER FROM TM_DIRECT_BACKFLUSH_GENERAL WHERE INT_LIVE = 1 ";

        return $this->db->query($sql)->result();
    }

    function get_detail_direct_backflush_general_by_date_and_work_center($date, $work_center)
    {
        $sql = "SELECT INT_SEQUENCE, CHR_WORK_CENTER, CHR_PART_NO, INT_LOT_SIZE, CHR_DATE FROM $this->tabel 
            WHERE INT_FLG_DEL = 0 AND CHR_WORK_CENTER = '$work_center' AND CHR_DATE = '$date'";

        return $this->db->query($sql)->row();
    }

    function get_detail_direct_backflush_general()
    {
        $sql = "SELECT D.CHR_DEPT, W.* FROM $this->tabel W INNER JOIN TM_DEPT D ON D.INT_ID_DEPT = W.INT_DEPT";

        return $this->db->query($sql)->result();
    }

    function get_sum_qty_by_work_order($wo, $qty_eceran, $qty_per_box, $back_no, $number_ref)
    {
        $stored_procedure = "EXEC PRD.zsp_get_allowance_to_input_retail_part ?, ?, ?, ?, ?";
        $param = array(
            'wo' => $wo,
            'qty_eceran' => $qty_eceran,
            'qty_per_box' => $qty_per_box,
            'back_no' => $back_no,
            'number_ref' => $number_ref
        );

        $query = $this->db->query($stored_procedure, $param);

        return $query->row()->STATUS_ALLOWENCE;
    }

    function get_work_center_by_id_dept($id_dept)
    {
        $query = $this->db->query("SELECT CHR_WCENTER AS CHR_WORK_CENTER FROM $this->tabel WHERE INT_DEPT = '$id_dept' GROUP BY CHR_WCENTER ORDER BY CHR_WCENTER ASC");

        return $query->result();
    }

    function get_all_work_center()
    {
        $query = $this->db->query("SELECT CHR_WCENTER AS CHR_WORK_CENTER FROM $this->tabel GROUP BY CHR_WCENTER ORDER BY CHR_WCENTER ASC");

        return $query->result();
    }

    function get_all_work_center_ines()
    {
        $query = $this->db->query("SELECT CHR_WCENTER AS CHR_WORK_CENTER FROM $this->tabel WHERE INT_LIVE =1 GROUP BY CHR_WCENTER ORDER BY CHR_WCENTER ASC");

        return $query->result();
    }

    function getWorkCenter()
    {
        $query = $this->db->query("SELECT 'ALL' AS CHR_WORK_CENTER
        UNION
        SELECT CHR_WCENTER AS CHR_WORK_CENTER FROM TM_DIRECT_BACKFLUSH_GENERAL 
        WHERE INT_LIVE =1 GROUP BY CHR_WCENTER ");

        return $query->result();
    }

    function get_top_work_center_using_samalona()
    {
        $query = $this->db->query("SELECT TOP 1 CHR_WCENTER CHR_WORK_CENTER FROM $this->tabel B INNER JOIN PRD.TM_POS P ON P.CHR_WORK_CENTER = B.CHR_WCENTER WHERE INT_LIVE =1 AND P.INT_FLG_DEL = 0 GROUP BY CHR_WCENTER ORDER BY CHR_WCENTER ASC")->row();

        return $query->CHR_WORK_CENTER;
    }

    function get_all_work_center_using_samalona()
    {
        $query = $this->db->query("SELECT CHR_WCENTER CHR_WORK_CENTER FROM $this->tabel B INNER JOIN PRD.TM_POS P ON P.CHR_WORK_CENTER = B.CHR_WCENTER WHERE INT_LIVE =1 AND P.INT_FLG_DEL = 0 GROUP BY CHR_WCENTER ORDER BY CHR_WCENTER ASC");

        return $query->result();
    }

    function get_top_work_center_ines()
    {
        $query = $this->db->query("SELECT TOP 1 CHR_WCENTER CHR_WORK_CENTER FROM $this->tabel WHERE INT_LIVE =1 GROUP BY CHR_WCENTER ORDER BY CHR_WCENTER ASC")->row();

        return $query->CHR_WORK_CENTER;
    }


    function get_top_work_center_by_id_dept($id_dept)
    {
        $query = $this->db->query("SELECT TOP 1 CHR_WCENTER CHR_WORK_CENTER FROM $this->tabel WHERE INT_DEPT = '$id_dept' GROUP BY CHR_WCENTER ORDER BY CHR_WCENTER ASC")->row();

        return $query->CHR_WORK_CENTER;
    }

    function get_top_work_center()
    {
        $query = $this->db->query("SELECT TOP 1 CHR_WCENTER CHR_WORK_CENTER FROM $this->tabel GROUP BY CHR_WCENTER ORDER BY CHR_WCENTER ASC")->row();

        return $query->CHR_WORK_CENTER;
    }

    function get_prod_by_work_center($work_center)
    {
        $query = $this->db->query("SELECT TOP 1 INT_DEPT FROM $this->tabel WHERE CHR_WCENTER = '$work_center' GROUP BY INT_DEPT ORDER BY INT_DEPT ASC")->row();

        return $query->INT_DEPT;
    }

    function get_data_work_center_non_ines()
    {

        $query = $this->db->query("SELECT CHR_WCENTER AS CHR_WORK_CENTER FROM $this->tabel WHERE CHR_WCENTER NOT IN (SELECT CHR_WORK_CENTER FROM TM_INLINE_SCAN GROUP BY CHR_WORK_CENTER) AND INT_LIVE = 1")->result();

        return $query;
    }

    function get_verification_work_center_and_id_dept($id_dept, $work_center)
    {
        $query = $this->db->query("SELECT TOP 1 INT_DEPT FROM $this->tabel WHERE CHR_WCENTER = '$work_center' AND INT_DEPT = '$id_dept' GROUP BY INT_DEPT ORDER BY INT_DEPT ASC");

        return $query->result();
    }

    function get_verification_work_center($work_center)
    {
        $query = $this->db->query("SELECT TOP 1 INT_DEPT FROM $this->tabel WHERE CHR_WCENTER = '$work_center' GROUP BY INT_DEPT ORDER BY INT_DEPT ASC");

        return $query->row()->INT_DEPT;
    }

    function get_routing_by_kanban($id, $type)
    {
        $query = $this->db->query("SELECT TM_DIRECT_BACKFLUSH_GENERAL.CHR_WCENTER, TM_DIRECT_BACKFLUSH_GENERAL.CHR_REMARK
            FROM TM_DIRECT_BACKFLUSH_GENERAL INNER JOIN
            TM_PROCESS_PARTS ON TM_DIRECT_BACKFLUSH_GENERAL.CHR_WCENTER = TM_PROCESS_PARTS.CHR_WORK_CENTER INNER JOIN
            TM_KANBAN ON dbo.TM_PROCESS_PARTS.CHR_PART_NO = TM_KANBAN.CHR_PART_NO AND 
            TM_PROCESS_PARTS.CHR_PV = TM_KANBAN.CHR_WC_VENDOR
            where TM_KANBAN.INT_KANBAN_NO = '$id' 
            and TM_KANBAN.CHR_KANBAN_TYPE = '$type'")->row();

        return $query;
    }


    //============ OGAWA PROJECT - Add by ANU ================================//
    function get_routing_by_kanban_oneway($id, $type)
    {
        $query = $this->db->query("select TM_DIRECT_BACKFLUSH_GENERAL.CHR_WCENTER, TM_DIRECT_BACKFLUSH_GENERAL.CHR_REMARK
            from TM_DIRECT_BACKFLUSH_GENERAL 
            inner join TM_PROCESS_PARTS on TM_DIRECT_BACKFLUSH_GENERAL.CHR_WCENTER = TM_PROCESS_PARTS.CHR_WORK_CENTER 
            inner join PRD.TT_ONE_WAY_KANBAN on TM_PROCESS_PARTS.CHR_PART_NO = PRD.TT_ONE_WAY_KANBAN.CHR_PART_NO
            --inner join TM_KANBAN on TM_KANBAN.CHR_PART_NO = PRD.TT_ONE_WAY_KANBAN.CHR_PART_NO and TM_PROCESS_PARTS.CHR_PV = TM_KANBAN.CHR_WC_VENDOR
            where PRD.TT_ONE_WAY_KANBAN.INT_ID = '$id' --and TM_KANBAN.CHR_KANBAN_TYPE = '$type'")->row();

        return $query;
    }
    //============ END OGAWA PROJECT - Add by ANU ============================//


    //============ BACKFLUSH DIRECT - Add by SAN ================================//

    function get_active_machine()
    {
        $query = $this->db->query("SELECT INT_LIVE,
        CASE WHEN INT_LIVE ='1' THEN 'ACTIVE'
             WHEN INT_LIVE ='0' THEN 'NON ACTIVE'
			 END AS [TYPE_ACTIVE]
        FROM TM_DIRECT_BACKFLUSH_GENERAL
        GROUP BY INT_LIVE");

        return $query->result();
    }

    //============ END OFF BACKFLUSH DIRECT - Add by SAN ================================//


    function get_routing_by_id_kanban($id, $type)
    {
        $query = $this->db->query("SELECT TM_DIRECT_BACKFLUSH_GENERAL.CHR_WCENTER, TM_DIRECT_BACKFLUSH_GENERAL.CHR_REMARK
            FROM TM_DIRECT_BACKFLUSH_GENERAL INNER JOIN
            TM_PROCESS_PARTS ON TM_DIRECT_BACKFLUSH_GENERAL.CHR_WCENTER = TM_PROCESS_PARTS.CHR_WORK_CENTER INNER JOIN
            TM_KANBAN ON dbo.TM_PROCESS_PARTS.CHR_PART_NO = TM_KANBAN.CHR_PART_NO AND 
            TM_PROCESS_PARTS.CHR_PV = TM_KANBAN.CHR_WC_VENDOR
            where TM_KANBAN.INT_KANBAN_NO = '$id' 
            and TM_KANBAN.CHR_KANBAN_TYPE = '$type'");

        return $query;
    }

    function get_routing_by_id_kanban_oneway($id, $type)
    {
        $query = $this->db->query("SELECT TM_DIRECT_BACKFLUSH_GENERAL.CHR_WCENTER, TM_DIRECT_BACKFLUSH_GENERAL.CHR_REMARK
            from TM_DIRECT_BACKFLUSH_GENERAL 
            inner join TM_PROCESS_PARTS on TM_DIRECT_BACKFLUSH_GENERAL.CHR_WCENTER = TM_PROCESS_PARTS.CHR_WORK_CENTER 
            inner join PRD.TT_ONE_WAY_KANBAN on TM_PROCESS_PARTS.CHR_PART_NO = PRD.TT_ONE_WAY_KANBAN.CHR_PART_NO
            --inner join TM_KANBAN on TM_KANBAN.CHR_PART_NO = PRD.TT_ONE_WAY_KANBAN.CHR_PART_NO and TM_PROCESS_PARTS.CHR_PV = TM_KANBAN.CHR_WC_VENDOR
            where PRD.TT_ONE_WAY_KANBAN.INT_ID = '$id' --and TM_KANBAN.CHR_KANBAN_TYPE = '$type'");

        return $query;
    }

    //20211217
    function getFlagScan($work_center)
    {
        $query = $this->db->query("SELECT TOP 1 1 FROM TM_DIRECT_BACKFLUSH_GENERAL WHERE CHR_WCENTER = '$work_center' AND INT_FLG_SCAN_CHUTE = 1");

        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }

    }
}
