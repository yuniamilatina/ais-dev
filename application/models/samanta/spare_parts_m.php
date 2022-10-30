<?php

class spare_parts_m extends CI_Model
{

    private $table_master = 'TM_SPARE_PARTS';
    private $table_part_sloc = 'TT_SPARE_PARTS_SLOC';
    private $table_part_routing = 'TM_SPARE_PARTS_ROUTING';
    private $table_tw_order = 'TW_SPARE_PARTS_ORDER';
    private $table_tt_order = 'TT_SPARE_PARTS_ORDER';
    private $table_tt_spare_part = 'TT_SPARE_PARTS';

    //Get data spare parts
    function get_data_all_spare_parts($FILTER)
    {
        $db_samanta = $this->load->database("samanta", TRUE);
        $query = $db_samanta->query("SELECT DISTINCT TOP 1000 A.INT_ID, A.CHR_PART_NO, A.CHR_BACK_NO, A.CHR_SPARE_PART_NAME, A.CHR_COMPONENT, A.CHR_MODEL, A.CHR_TYPE, A.CHR_SPECIFICATION, 
                                    A.INT_QTY_USE, A.INT_QTY_MIN, A.INT_QTY_MAX, (CONVERT(FLOAT,A.CHR_PRICE)) AS CHR_PRICE, A.CHR_PART_TYPE, C.INT_QTY AS INT_QTY_ACT, A.CHR_PART_TYPE, A.CHR_FILENAME, A.CHR_FLAG_DELETE, 
                                    A.CHR_CREATED_BY, A.CHR_CREATED_DATE, A.CHR_CREATED_TIME, A.CHR_MODIFIED_BY, A.CHR_MODIFIED_DATE, A.CHR_MODIFIED_TIME
                                    FROM TM_SPARE_PARTS A
                                    INNER JOIN TT_SPARE_PARTS_SLOC C ON C.CHR_PART_NO = A.CHR_PART_NO
                                    WHERE A.CHR_FLAG_DELETE = 'F' and (A.CHR_PART_NO like '%" . $FILTER . "%' or A.CHR_SPARE_PART_NAME like '%" . $FILTER . "%' or A.CHR_SPECIFICATION like '%" . $FILTER . "%' or A.CHR_MODEL like '%" . $FILTER . "%' or A.CHR_COMPONENT like '%" . $FILTER . "%' or A.CHR_BACK_NO like '%" . $FILTER . "%' or A.CHR_TYPE like '%" . $FILTER . "%')
                                    ORDER BY CHR_PRICE DESC");
        return $query->result();
    }

    // filter autocomplete
    function get_data_spare_parts($FILTER, $loc)
    {
        $db_samanta = $this->load->database("samanta", TRUE);
        $query = $db_samanta->query("select a.CHR_SPECIFICATION , a.CHR_PART_NO,a.CHR_SPARE_PART_NAME ,a.CHR_COMPONENT,a.CHR_PRICE
            from TM_SPARE_PARTS as a join TT_SPARE_PARTS_SLOC as b on a.CHR_PART_NO = b.CHR_PART_NO where b.CHR_SLOC = '" . $loc . "' and a.CHR_SPECIFICATION like '%" . $FILTER . "%'");
        return $query->result();
    }
    function findBySql($query)
    {
        $db_samanta = $this->load->database("samanta", TRUE);
        $query = $db_samanta->query($query);
        return $query->result();
    }
    function get_data_all_spare_parts_2($FILTER)
    {
        $db_samanta = $this->load->database("samanta", TRUE);
        $query = $db_samanta->query("SELECT DISTINCT A.INT_ID, A.CHR_PART_NO, A.CHR_BACK_NO, A.CHR_SPARE_PART_NAME, A.CHR_COMPONENT, A.CHR_MODEL, A.CHR_TYPE, A.CHR_SPECIFICATION, 
                                    A.INT_QTY_USE, A.INT_QTY_MIN, A.INT_QTY_MAX, (CONVERT(FLOAT,A.CHR_PRICE)) AS CHR_PRICE, C.INT_QTY AS INT_QTY_ACT, A.CHR_PART_TYPE, A.CHR_FILENAME, A.CHR_FLAG_DELETE, 
                                    A.CHR_CREATED_BY, A.CHR_CREATED_DATE, A.CHR_CREATED_TIME, A.CHR_MODIFIED_BY, A.CHR_MODIFIED_DATE, A.CHR_MODIFIED_TIME
                                    FROM TM_SPARE_PARTS A
                                    INNER JOIN TT_SPARE_PARTS_SLOC C ON C.CHR_PART_NO = A.CHR_PART_NO
                                    WHERE A.CHR_FLAG_DELETE = 'F' and (A.CHR_PART_NO like '%" . $FILTER . "%' or  A.CHR_SPECIFICATION like '%" . $FILTER . "%')
                                    ORDER BY CHR_PART_NO");
        return $query->result();
    }

    function get_data_all_spare_parts_full($sloc)
    {
        $db_samanta = $this->load->database("samanta", TRUE);
        $query = $db_samanta->query("SELECT DISTINCT A.INT_ID, A.CHR_PART_NO, A.CHR_BACK_NO, A.CHR_SPARE_PART_NAME, A.CHR_COMPONENT, A.CHR_MODEL, A.CHR_TYPE, A.CHR_SPECIFICATION, 
                                    A.INT_QTY_USE, A.INT_QTY_MIN, A.INT_QTY_MAX, (CONVERT(FLOAT,A.CHR_PRICE)) AS CHR_PRICE, C.INT_QTY AS INT_QTY_ACT, A.CHR_PART_TYPE, A.CHR_FILENAME, A.CHR_FLAG_DELETE, 
                                    A.CHR_CREATED_BY, A.CHR_CREATED_DATE, A.CHR_CREATED_TIME, A.CHR_MODIFIED_BY, A.CHR_MODIFIED_DATE, A.CHR_MODIFIED_TIME
                                    FROM TM_SPARE_PARTS A
                                    INNER JOIN TT_SPARE_PARTS_SLOC C ON C.CHR_PART_NO = A.CHR_PART_NO
                                    WHERE A.CHR_FLAG_DELETE = 'F' and C.CHR_SLOC = '$sloc' ");
        return $query->result();
    }

    //Get data spare parts
    function get_data_all_spare_parts_with_store_procedure()
    {
        $db_samanta = $this->load->database("samanta", TRUE);
        $stored_procedure = "EXEC zsp_get_all_spare_parts";
        $query = $db_samanta->query($stored_procedure);
        return $query->result();
    }

    // Get data spare parts per area
    function get_data_all_spare_parts_per_area($area, $FILTER)
    {
        $db_samanta = $this->load->database("samanta", TRUE);
        $query = $db_samanta->query("SELECT DISTINCT TOP 1000  A.INT_ID, A.CHR_PART_NO, A.CHR_BACK_NO, A.CHR_SPARE_PART_NAME, A.CHR_COMPONENT, A.CHR_MODEL, A.CHR_TYPE, A.CHR_SPECIFICATION, 
                                    A.INT_QTY_USE, A.INT_QTY_MIN, A.INT_QTY_MAX, (CONVERT(FLOAT,A.CHR_PRICE)) AS CHR_PRICE, A.CHR_PART_TYPE, C.INT_QTY AS INT_QTY_ACT, A.CHR_PART_TYPE, A.CHR_FILENAME, A.CHR_FLAG_DELETE, 
                                    A.CHR_CREATED_BY, A.CHR_CREATED_DATE, A.CHR_CREATED_TIME, A.CHR_MODIFIED_BY, A.CHR_MODIFIED_DATE, A.CHR_MODIFIED_TIME
                                    FROM TM_SPARE_PARTS A
                                    INNER JOIN TT_SPARE_PARTS_SLOC C ON C.CHR_PART_NO = A.CHR_PART_NO
                                    WHERE A.CHR_FLAG_DELETE = 'F' AND C.CHR_SLOC = '$area' and (A.CHR_PART_NO like '%" . $FILTER . "%' or A.CHR_SPARE_PART_NAME like '%" . $FILTER . "%' or A.CHR_SPECIFICATION like '%" . $FILTER . "%' or A.CHR_MODEL like '%" . $FILTER . "%' or A.CHR_COMPONENT like '%" . $FILTER . "%' or A.CHR_BACK_NO like '%" . $FILTER . "%' or A.CHR_TYPE like '%" . $FILTER . "%') 
                                    ORDER BY CHR_PRICE DESC");
        return $query->result();
    }
    function get_data_alamat_spare_parts($part_no)
    {
        $db_samanta = $this->load->database("samanta", TRUE);
        $query = $db_samanta->query("SELECT CHR_PART_NO, CHR_BACK_NO, CHR_RACK_NO FROM TM_SPARE_PARTS_ROUTING WHERE CHR_PART_NO = '$part_no'");
        return $query->result();
    }

    function get_data_area()
    {
        $db_samanta = $this->load->database("samanta", TRUE);
        $query = $db_samanta->query("SELECT CHR_SLOC 
        AS LOCATION, CHR_SLOC_DESC FROM TM_SLOC");
        return $query->result();

                // SELECT 'ALL' AS LOCATION, 'ALL' AS CHR_SLOC_DESC
        // UNION ALL 
        // SELECT DISTINCT 
    }

    function save_data_sp($data)
    {
        $db_samanta = $this->load->database("samanta", TRUE);
        $db_samanta->insert($this->table_master, $data);
    }

    function save_data_sloc($data_part_sloc)
    {
        $db_samanta = $this->load->database("samanta", TRUE);
        $db_samanta->insert($this->table_part_sloc, $data_part_sloc);
    }

    function save_data_routing($data_part_routing)
    {
        $db_samanta = $this->load->database("samanta", TRUE);
        $db_samanta->insert($this->table_part_routing, $data_part_routing);
    }

    function update_sp($data, $id)
    {
        $db_samanta = $this->load->database("samanta", TRUE);
        $db_samanta->where('INT_ID', $id);
        $db_samanta->update($this->table_master, $data);
    }

    function update_sp_sloc($parts_no, $sloc, $quantity)
    {
        $db_samanta = $this->load->database("samanta", TRUE);
        $db_samanta->query("UPDATE $this->table_part_sloc SET INT_QTY = INT_QTY + '$quantity' 
                                                                WHERE CHR_PART_NO = '$parts_no'
                                                                AND CHR_SLOC = '$sloc'");
    }

    // function update_sp_route($rack_no, $part_no) {
    //     $db_samanta = $this->load->database("samanta", TRUE);
    //     $db_samanta->query("UPDATE TT_SPARE_PARTS_ROUTE SET CHR_RACK_NO = '$rack_no' WHERE CHR_PART_NO = '$part_no'");
    // }

    function get_data_sp($id)
    {
        $db_samanta = $this->load->database("samanta", TRUE);
        $query = $db_samanta->query("SELECT * FROM TM_SPARE_PARTS WHERE INT_ID = '$id'");
        return $query;
    }

    function get_master_data($part_no)
    {
        $db_samanta = $this->load->database("samanta", TRUE);
        $query = $db_samanta->query("SELECT CHR_PART_NO FROM TM_SPARE_PARTS WHERE CHR_PART_NO = '$part_no'");
        return $query;
    }

    function delete_sp($id)
    {
        $db_samanta = $this->load->database("samanta", TRUE);
        $db_samanta->query("UPDATE $this->table_master SET CHR_FLAG_DELETE = 'T' WHERE INT_ID = '$id'");
    }

    // ====================================================================================================//
    // ========== SAMANTA - Transaction ===================================================================//

    function get_all_parts_trans($date, $sloc)
    {
        $db_samanta = $this->load->database("samanta", TRUE);
        $query = $db_samanta->query("SELECT A.INT_ID, A.CHR_PART_NO, A.CHR_RACK_NO, RTRIM(A.CHR_SPARE_PART_NAME) CHR_SPARE_PART_NAME, B.CHR_SPECIFICATION, 
                                            A.CHR_LOCATION_FROM, A.CHR_LOCATION_TO, A.CHR_COMPONENT, A.CHR_TYPE_TRANS, A.INT_QTY, 
                                            A.CHR_UOM, A.CHR_PRICE, A.CHR_ENTRIED_BY, A.CHR_ENTRIED_DATE, A.CHR_ENTRIED_TIME 
                                            FROM TT_SPARE_PARTS A INNER JOIN TM_SPARE_PARTS B ON B.CHR_PART_NO = A.CHR_PART_NO
                                            WHERE A.CHR_ENTRIED_DATE = '$date' AND A.CHR_SLOC_TRANS = '$sloc' ORDER BY A.CHR_ENTRIED_TIME DESC");
        return $query->result();
    }

    function get_data_by_part_trans($id)
    {
        $db_samanta = $this->load->database("samanta", TRUE);
        $query = $db_samanta->query("SELECT * FROM TT_SPARE_PARTS WHERE INT_ID = '$id'");
        return $query->result();
    }

    function get_data_by_part_sloc($part_no, $sloc)
    {
        $db_samanta = $this->load->database("samanta", TRUE);
        $query = $db_samanta->query("SELECT * FROM TT_SPARE_PARTS_SLOC WHERE CHR_PART_NO = '$part_no' AND CHR_SLOC = '$sloc'");
        return $query->result();
    }

    function get_all_sloc()
    {
        $db_samanta = $this->load->database("samanta", TRUE);
        $query = $db_samanta->query("SELECT DISTINCT CHR_SLOC FROM TT_SPARE_PARTS_SLOC ORDER BY CHR_SLOC ASC");
        return $query->result();
    }

    function get_top1_sloc()
    {
        $db_samanta = $this->load->database("samanta", TRUE);
        $query = $db_samanta->query("SELECT TOP 1 CHR_SLOC FROM TT_SPARE_PARTS_SLOC ORDER BY CHR_SLOC ASC");
        return $query->row()->CHR_SLOC;
    }

    // end here
    // ==================================================================================================//


    // ==================================================================================================//
    // ========== SAMANTA - List Order ==================================================================//

    function get_all_parts_trans_2($date)
    {
        $db_samanta = $this->load->database("samanta", TRUE);
        $period = intval($date);

        $stored_procedure = "EXEC zsp_get_list_order_sp ?";

        $param = array(
            'period' => $period
        );

        $query = $db_samanta->query($stored_procedure, $param);
        return $query->result();
    }

    function get_all_parts_order($npk)
    {
        $db_samanta = $this->load->database("samanta", TRUE);
        $query = $db_samanta->query("SELECT * FROM TW_SPARE_PARTS_ORDER WHERE CHR_ENTRIED_BY = '$npk' ORDER BY INT_QTY_OUT DESC");
        return $query->result();
    }

    function save_tw_order($data)
    {
        $db_samanta = $this->load->database("samanta", TRUE);
        $db_samanta->insert($this->table_tw_order, $data);
    }

    function save_all_data_part($data)
    {
        $db_samanta = $this->load->database("samanta", TRUE);
        $db_samanta->insert($this->table_tt_spare_part, $data);
    }


    function save_tt_order($data)
    {
        $db_samanta = $this->load->database("samanta", TRUE);
        $db_samanta->insert($this->table_tw_order, $data);
    }

    function save_to_tt_order_list($data)
    {
        $db_samanta = $this->load->database("samanta", TRUE);
        $db_samanta->insert($this->table_tt_order, $data);
    }

    function get_all_parts_order_final($npk)
    {
        $db_samanta = $this->load->database("samanta", TRUE);
        $query = $db_samanta->query("SELECT * FROM TW_SPARE_PARTS_ORDER WHERE INT_QTY_ORDER <> '0' AND CHR_ENTRIED_BY = '$npk' ORDER BY INT_QTY_OUT DESC");
        return $query->result();
    }

    function get_total_order($npk)
    {
        $db_samanta = $this->load->database("samanta", TRUE);
        $query = $db_samanta->query("SELECT SUM(INT_QTY_ORDER) AS TOTAL_QTY, SUM(CONVERT(int, CHR_AMOUNT)) AS TOTAL_AMOUNT FROM TW_SPARE_PARTS_ORDER 
                                            WHERE INT_QTY_ORDER <> '0' AND CHR_ENTRIED_BY = '$npk'");
        return $query->result();
    }

    function get_price_per_part_number($part_no)
    {
        $db_samanta = $this->load->database("samanta", TRUE);
        $query = $db_samanta->query("SELECT TOP(1) CHR_PRICE FROM TM_SPARE_PARTS WHERE CHR_PART_NO = '$part_no'");
        return $query;
    }
    // ==================================================================================================//

    // function check_id_event($var) {
    //     $db_samanta = $this->load->database("samanta", TRUE);
    //     $query = $db_samanta->query("SELECT DISTINCT ID_EVENT FROM TT_SPARE_PARTS_STO WHERE ID_EVENT = '$var'");
    //     return $query;      
    // }

    function get_data_spare_parts_sto()
    {
        $db_samanta = $this->load->database("samanta", TRUE);
        $query = $db_samanta->query("SELECT A.ID_EVENT, A.CHR_PART_NO, B.CHR_SPARE_PART_NAME, B.CHR_SPECIFICATION, A.CHR_SLOC, 
                                            A.INT_QTY_FREEZE, A.INT_QTY_STO, (A.INT_QTY_STO-A.INT_QTY_FREEZE) AS QTY_VARIANCE, 
                                            ((A.INT_QTY_STO-A.INT_QTY_FREEZE)*(CONVERT(FLOAT,B.CHR_PRICE))) AS AMOUNT_VARIANCE, 
                                            (CONVERT(FLOAT,B.CHR_PRICE)) AS CHR_PRICE
                                            FROM TT_SPARE_PARTS_STO A 
                                                    INNER JOIN TM_SPARE_PARTS B ON B.CHR_PART_NO = A.CHR_PART_NO WHERE FLG_EVENT = 0");
        return $query;
    }

    function get_data_area_sto()
    {
        $db_samanta = $this->load->database("samanta", TRUE);
        $query = $db_samanta->query("SELECT DISTINCT CHR_SLOC AS LOCATION FROM TT_SPARE_PARTS_STO ORDER BY CHR_SLOC ASC");
        return $query->result();
    }

    function get_data_spare_parts_sto_by_sloc($sloc)
    {
        $db_samanta = $this->load->database("samanta", TRUE);
        $query = $db_samanta->query("SELECT A.ID_EVENT, A.CHR_PART_NO, B.CHR_SPARE_PART_NAME, B.CHR_SPECIFICATION, A.CHR_SLOC, 
                                            A.INT_QTY_FREEZE, A.INT_QTY_STO, (A.INT_QTY_STO-A.INT_QTY_FREEZE) AS QTY_VARIANCE, 
                                            ((A.INT_QTY_STO-A.INT_QTY_FREEZE)*(CONVERT(FLOAT,B.CHR_PRICE))) AS AMOUNT_VARIANCE, 
                                            (CONVERT(FLOAT,B.CHR_PRICE)) AS CHR_PRICE
                                            FROM TT_SPARE_PARTS_STO A 
                                                    INNER JOIN TM_SPARE_PARTS B ON B.CHR_PART_NO = A.CHR_PART_NO 
                                                    WHERE A.CHR_SLOC = '$sloc' AND A.FLG_EVENT = 0");
        return $query;
    }

    function get_data_area_sto_by_sloc($sloc)
    {
        $db_samanta = $this->load->database("samanta", TRUE);
        $query = $db_samanta->query("SELECT DISTINCT CHR_SLOC AS LOCATION FROM TT_SPARE_PARTS_STO WHERE CHR_SLOC = '$sloc'
                                    ORDER BY CHR_SLOC ASC");
        return $query->result();
    }

    function get_freeze_value()
    {
        $db_samanta = $this->load->database("samanta", TRUE);
        $query = $db_samanta->query("SELECT SUM(CONVERT(BIGINT,(A.INT_QTY_FREEZE)*(B.CHR_PRICE))) AS FREEZE_VALUE
                                        FROM TT_SPARE_PARTS_STO A 
                                        INNER JOIN TM_SPARE_PARTS B ON B.CHR_PART_NO = A.CHR_PART_NO WHERE A.FLG_EVENT = 0");
        // $query = $db_samanta->query("SELECT SUM((A.INT_QTY_FREEZE)*(B.CHR_PRICE)) AS FREEZE_VALUE
        //                                 FROM TT_SPARE_PARTS_STO A 
        //                                 INNER JOIN TM_SPARE_PARTS B ON B.CHR_PART_NO = A.CHR_PART_NO");
        return $query;
    }

    function get_pi_value()
    {
        $db_samanta = $this->load->database("samanta", TRUE);
        $query = $db_samanta->query("SELECT SUM(CONVERT(BIGINT,(A.INT_QTY_STO)*(B.CHR_PRICE))) AS PI_VALUE
                                        FROM TT_SPARE_PARTS_STO A 
                                        INNER JOIN TM_SPARE_PARTS B ON B.CHR_PART_NO = A.CHR_PART_NO WHERE A.FLG_EVENT = 0");
        return $query;
    }

    function get_var_value()
    {
        $db_samanta = $this->load->database("samanta", TRUE);
        $query = $db_samanta->query("SELECT SUM(CONVERT(BIGINT,((A.INT_QTY_STO-A.INT_QTY_FREEZE))*(B.CHR_PRICE))) AS VAR_VALUE
                                        FROM TT_SPARE_PARTS_STO A 
                                        INNER JOIN TM_SPARE_PARTS B ON B.CHR_PART_NO = A.CHR_PART_NO WHERE A.FLG_EVENT = 0");
        return $query;
    }

    function get_total_part()
    {
        $db_samanta = $this->load->database("samanta", TRUE);
        $query = $db_samanta->query("SELECT COUNT(INT_QTY_STO) AS TOTAL_PART FROM TT_SPARE_PARTS_STO WHERE FLG_EVENT = 0");
        return $query;
    }

    function get_counted_part()
    {
        $db_samanta = $this->load->database("samanta", TRUE);
        $query = $db_samanta->query("SELECT COUNT(INT_QTY_STO) AS COUNTED FROM TT_SPARE_PARTS_STO WHERE INT_QTY_STO <> 0 AND FLG_EVENT = 0");
        return $query;
    }

    function get_freeze_value_by_sloc($sloc)
    {
        $db_samanta = $this->load->database("samanta", TRUE);
        $query = $db_samanta->query("SELECT SUM(CONVERT(BIGINT,(A.INT_QTY_FREEZE)*(B.CHR_PRICE))) AS FREEZE_VALUE
                                        FROM TT_SPARE_PARTS_STO A 
                                        INNER JOIN TM_SPARE_PARTS B ON B.CHR_PART_NO = A.CHR_PART_NO WHERE A.CHR_SLOC='$sloc' AND A.FLG_EVENT = 0");
        return $query;
    }

    function get_pi_value_by_sloc($sloc)
    {
        $db_samanta = $this->load->database("samanta", TRUE);
        $query = $db_samanta->query("SELECT SUM(CONVERT(BIGINT,(A.INT_QTY_STO)*(B.CHR_PRICE))) AS PI_VALUE
                                        FROM TT_SPARE_PARTS_STO A 
                                        INNER JOIN TM_SPARE_PARTS B ON B.CHR_PART_NO = A.CHR_PART_NO WHERE A.CHR_SLOC='$sloc' AND A.FLG_EVENT = 0");
        return $query;
    }

    function get_var_value_by_sloc($sloc)
    {
        $db_samanta = $this->load->database("samanta", TRUE);
        $query = $db_samanta->query("SELECT SUM(CONVERT(BIGINT,((A.INT_QTY_STO-A.INT_QTY_FREEZE))*(B.CHR_PRICE))) AS VAR_VALUE
                                        FROM TT_SPARE_PARTS_STO A 
                                        INNER JOIN TM_SPARE_PARTS B ON B.CHR_PART_NO = A.CHR_PART_NO WHERE A.CHR_SLOC='$sloc' AND A.FLG_EVENT = 0");
        return $query;
    }

    function get_total_part_by_sloc($sloc)
    {
        $db_samanta = $this->load->database("samanta", TRUE);
        $query = $db_samanta->query("SELECT COUNT(INT_QTY_STO) AS TOTAL_PART FROM TT_SPARE_PARTS_STO WHERE CHR_SLOC= '$sloc' AND FLG_EVENT = 0");
        return $query;
    }

    function get_counted_part_by_sloc($sloc)
    {
        $db_samanta = $this->load->database("samanta", TRUE);
        $query = $db_samanta->query("SELECT COUNT(INT_QTY_STO) AS COUNTED FROM TT_SPARE_PARTS_STO WHERE INT_QTY_STO <> 0 AND CHR_SLOC= '$sloc' AND FLG_EVENT = 0");
        return $query;
    }

    // select data hasil stock opname, untuk upload data
    function get_sto_data()
    {
        $db_samanta = $this->load->database("samanta", TRUE);
        $query = $db_samanta->query("SELECT * FROM TT_SPARE_PARTS_STO WHERE CHR_SLOC = 'MT03' AND CHR_ENTRIED_DATE > '20190500'  AND FLG_EVENT = 0");
        return $query;
    }

    // add function "Add Spare Parts" on Order List
    // update : 11-04-2019
    // start
    function get_wh_by_part_number($part_no)
    {
        $db_samanta = $this->load->database("samanta", TRUE);
        $query = $db_samanta->query("SELECT CHR_SLOC, SUM(INT_QTY) as INT_TOTAL FROM TT_SPARE_PARTS_SLOC where CHR_PART_NO = '$part_no'
            GROUP BY CHR_SLOC");
        return $query->result();
    }

    function get_data_spare_parts_ol($FILTER)
    {
        $db_samanta = $this->load->database("samanta", TRUE);
        $query = $db_samanta->query("select a.CHR_SPECIFICATION , a.CHR_PART_NO,a.CHR_SPARE_PART_NAME ,a.CHR_COMPONENT,a.CHR_PRICE,
            a.CHR_MODEL, a.INT_QTY_USE, a.INT_QTY_MIN, a.INT_QTY_MAX, SUM(b.INT_QTY) AS INT_QTY_ACT
            from TM_SPARE_PARTS as a join TT_SPARE_PARTS_SLOC as b on a.CHR_PART_NO = b.CHR_PART_NO
            WHERE a.CHR_SPECIFICATION like '%" . $FILTER . "%'
            group by a.CHR_PART_NO, a.CHR_SPECIFICATION, a.CHR_SPARE_PART_NAME , a.Chr_Component,
            a.CHR_PRICE,A.CHR_MODEL,A.INT_QTY_USE, A.INT_QTY_MIN, A.INT_QTY_MAX
            ORDER BY a.CHR_PART_NO");
        return $query->result();
    }
    // end

    // add fitur download excel
    // by   : IJA
    // date : 15.04.2019
    // start
    function get_data_all_spare_parts_excel()
    {
        $db_samanta = $this->load->database("samanta", TRUE);
        $query = $db_samanta->query("SELECT DISTINCT A.INT_ID, A.CHR_PART_NO, A.CHR_BACK_NO, A.CHR_SPARE_PART_NAME, A.CHR_COMPONENT, A.CHR_MODEL, A.CHR_SPECIFICATION, A.INT_QTY_USE, A.INT_QTY_MIN, A.INT_QTY_MAX, (CONVERT(FLOAT,A.CHR_PRICE)) AS CHR_PRICE, C.INT_QTY AS INT_QTY_ACT, A.CHR_PART_TYPE, (CONVERT(FLOAT,A.CHR_PRICE)*C.INT_QTY) as Amount, A.CHR_BACK_NO
                                    FROM TM_SPARE_PARTS A
                                    INNER JOIN TT_SPARE_PARTS_SLOC C ON C.CHR_PART_NO = A.CHR_PART_NO
                                    WHERE A.CHR_FLAG_DELETE = 'F'
                                    ORDER BY CHR_PART_NO");
        return $query->result();
    }

    function get_data_all_spare_parts_excel_type2()
    {
        $db_samanta = $this->load->database("samanta", TRUE);
        $query = $db_samanta->query("SELECT DISTINCT A.INT_ID, A.CHR_PART_NO, A.CHR_BACK_NO, A.CHR_SPARE_PART_NAME, A.CHR_COMPONENT, A.CHR_MODEL, A.CHR_SPECIFICATION, A.INT_QTY_USE, A.INT_QTY_MIN, A.INT_QTY_MAX, (CONVERT(FLOAT,A.CHR_PRICE)) AS CHR_PRICE, C.INT_QTY AS INT_QTY_ACT, A.CHR_PART_TYPE, (CONVERT(FLOAT,A.CHR_PRICE)*C.INT_QTY) as Amount, A.CHR_BACK_NO
                                    FROM TM_SPARE_PARTS A
                                    INNER JOIN TT_SPARE_PARTS_SLOC C ON C.CHR_PART_NO = A.CHR_PART_NO
                                    WHERE A.CHR_FLAG_DELETE = 'F' and A.CHR_PART_TYPE = 1
                                    ORDER BY CHR_PART_NO");
        return $query->result();
    }
    //end

    // add fitur download excel
    // by   : IJA
    // date : 15.04.2019
    // start
    function get_data_detail_per_sloc_per_month($tanggal2, $opt_sloc)
    {
        $db_samanta = $this->load->database("samanta", TRUE);
        $query = $db_samanta->query("SELECT A.CHR_PART_NO, A.CHR_RACK_NO, A.CHR_SPARE_PART_NAME, B.CHR_SPECIFICATION , A.CHR_LOCATION_FROM, A.CHR_LOCATION_TO,
                                        A.CHR_TYPE_TRANS, A.INT_QTY, A.CHR_UOM, A.CHR_ENTRIED_BY, A.CHR_ENTRIED_DATE, A.CHR_ENTRIED_TIME
                                        FROM TT_SPARE_PARTS A 
                                        LEFT JOIN TM_SPARE_PARTS B ON B.CHR_PART_NO = A.CHR_PART_NO 
                                        WHERE A.CHR_ENTRIED_DATE LIKE '$tanggal2%' AND A.CHR_SLOC_TRANS = '$opt_sloc' ORDER BY A.CHR_ENTRIED_DATE");
        return $query->result();
    }

    function get_data_detail_all_per_month($tanggal2)
    {
        $db_samanta = $this->load->database("samanta", TRUE);
        $query = $db_samanta->query("SELECT A.CHR_PART_NO, A.CHR_RACK_NO, A.CHR_SPARE_PART_NAME, B.CHR_SPECIFICATION , A.CHR_LOCATION_FROM, A.CHR_LOCATION_TO,
                                        A.CHR_TYPE_TRANS, A.INT_QTY, A.CHR_UOM, A.CHR_ENTRIED_BY, A.CHR_ENTRIED_DATE, A.CHR_ENTRIED_TIME
                                        FROM TT_SPARE_PARTS A 
                                        LEFT JOIN TM_SPARE_PARTS B ON B.CHR_PART_NO = A.CHR_PART_NO 
                                        WHERE A.CHR_ENTRIED_DATE LIKE '$tanggal2%' ORDER BY A.CHR_ENTRIED_DATE");
        return $query->result();
    }
    //end

    public function get_name_spare_part()
    {
        $db_samanta = $this->load->database("samanta", TRUE);
        $query = $db_samanta->query("SELECT CHR_SPARE_PART_NAME FROm TM_SPARE_PARTS GROUP BY CHR_SPARE_PART_NAME ORDER BY CHR_SPARE_PART_NAME");
        return $query->result();
    }

    public function get_spec_spare_part($spart_part_name)
    {
        $db_samanta = $this->load->database("samanta", TRUE);
        $query = $db_samanta->query("SELECT INT_ID, RTRIM(CHR_SPECIFICATION) CHR_SPECIFICATION, rtrim(CHR_SPARE_PART_NAME) CHR_SPARE_PART_NAME
        FROm TM_SPARE_PARTS WHERE rtrim(CHR_SPARE_PART_NAME) = '$spart_part_name'
        -- AND INT_QTY_MIN >= INT_QTY_USE
        ");
        return $query->result();
    }

    //Loop3r 20211229
    function get_data_all_spare_parts_by_area($area)
    {
        $db_samanta = $this->load->database("samanta", TRUE);

        if ($area == 'ALL') {
            $query = $db_samanta->query("SELECT A.INT_ID, A.CHR_PART_NO, A.CHR_BACK_NO, A.CHR_SPARE_PART_NAME, A.CHR_COMPONENT, A.CHR_MODEL, A.CHR_TYPE, A.CHR_SPECIFICATION, 
            A.INT_QTY_USE, A.INT_QTY_MIN, A.INT_QTY_MAX, (CONVERT(FLOAT,A.CHR_PRICE)) AS CHR_PRICE, A.CHR_PART_TYPE, C.INT_QTY AS INT_QTY_ACT, A.CHR_PART_TYPE, A.CHR_FILENAME, A.CHR_FLAG_DELETE, 
            A.CHR_CREATED_BY, A.CHR_CREATED_DATE, A.CHR_CREATED_TIME, A.CHR_MODIFIED_BY, A.CHR_MODIFIED_DATE, A.CHR_MODIFIED_TIME
            FROM TM_SPARE_PARTS A
            INNER JOIN TT_SPARE_PARTS_SLOC C ON C.CHR_PART_NO = A.CHR_PART_NO
            WHERE A.CHR_FLAG_DELETE = 'F'
            ORDER BY CHR_PRICE DESC");
        } else {
            $query = $db_samanta->query("SELECT A.INT_ID, A.CHR_PART_NO, A.CHR_BACK_NO, A.CHR_SPARE_PART_NAME, A.CHR_COMPONENT, A.CHR_MODEL, A.CHR_TYPE, A.CHR_SPECIFICATION, 
            A.INT_QTY_USE, A.INT_QTY_MIN, A.INT_QTY_MAX, (CONVERT(FLOAT,A.CHR_PRICE)) AS CHR_PRICE, A.CHR_PART_TYPE, C.INT_QTY AS INT_QTY_ACT, A.CHR_PART_TYPE, A.CHR_FILENAME, A.CHR_FLAG_DELETE, 
            A.CHR_CREATED_BY, A.CHR_CREATED_DATE, A.CHR_CREATED_TIME, A.CHR_MODIFIED_BY, A.CHR_MODIFIED_DATE, A.CHR_MODIFIED_TIME
            FROM TM_SPARE_PARTS A
            INNER JOIN TT_SPARE_PARTS_SLOC C ON C.CHR_PART_NO = A.CHR_PART_NO
            WHERE A.CHR_FLAG_DELETE = 'F' and CHR_SLOC = '$area'
            ORDER BY CHR_PRICE DESC");
        }

        return $query->result();
    }

    //Loop3r 20211229
    public function insertTempOrderList($data)
    {
        $db_samanta = $this->load->database("samanta", TRUE);
        $db_samanta->insert("TT_SPARE_PARTS_ORDER", $data);
    }

    //Loop3r 20211229
    public function getSummaryOrder($npk)
    {
        $db_samanta = $this->load->database("samanta", TRUE);
        return $db_samanta->query("SELECT * FROM TT_SPARE_PARTS_ORDER WHERE CHR_CREATED_BY = '$npk'")->result();
    }

    //Loop3r 20211229
    public function generateOrderNo($npk)
    {
        $db_samanta = $this->load->database("samanta", TRUE);
        $query =  $db_samanta->query("SELECT TOP 1
        CHR_CREATED_BY +'-'+ CONVERT(VARCHAR(5),REPLACE(CHR_ORDER_NO, LEFT(CHR_ORDER_NO, 6)+'-','') + 1) OrderNo 
        FROM TT_SPARE_PARTS_ORDER WHERE CHR_CREATED_BY = '$npk' GROUP BY CHR_CREATED_BY, CHR_ORDER_NO
        ORDER BY CHR_ORDER_NO DESC");

        if ($query->num_rows() > 0) {
            return $query->row()->OrderNo;
        } else {
            return $npk . '-' . '1';
        }
    }

    //Loop3r 20211229
    public function getDataSparePartByPartNo($part_no)
    {
        $db_samanta = $this->load->database("samanta", TRUE);

        $query =  $db_samanta->query("SELECT TOP 1 A.CHR_PART_NO, A.CHR_SPARE_PART_NAME, A.CHR_COMPONENT, A.CHR_MODEL, A.CHR_TYPE, A.CHR_SPECIFICATION, 
        A.INT_QTY_USE, A.INT_QTY_MIN, A.INT_QTY_MAX, (CONVERT(FLOAT,A.CHR_PRICE)) AS CHR_PRICE, 0 AS INT_QTY_ORDER
        FROM TM_SPARE_PARTS A
        INNER JOIN TT_SPARE_PARTS_SLOC C ON C.CHR_PART_NO = A.CHR_PART_NO
        WHERE A.CHR_FLAG_DELETE = 'F' AND A.CHR_PART_NO = '$part_no'
        ORDER BY CHR_PRICE DESC");

        return $query->row();
    }

    //Loop3r 20211229
    public function getDataTransactionSparePart($date)
    {
        $db_samanta = $this->load->database("samanta", TRUE);

        return  $db_samanta->query("SELECT A.INT_ID, A.CHR_PART_NO, A.CHR_RACK_NO, RTRIM(A.CHR_SPARE_PART_NAME) CHR_SPARE_PART_NAME, B.CHR_SPECIFICATION, 
        A.CHR_LOCATION_FROM, A.CHR_LOCATION_TO, A.CHR_COMPONENT, B.CHR_MODEL, A.CHR_TYPE_TRANS, A.INT_QTY, 
        A.CHR_UOM, A.CHR_PRICE, A.CHR_ENTRIED_BY, A.CHR_ENTRIED_DATE, A.CHR_ENTRIED_TIME 
        FROM TT_SPARE_PARTS A INNER JOIN TM_SPARE_PARTS B ON B.CHR_PART_NO = A.CHR_PART_NO
        WHERE LEFT(A.CHR_ENTRIED_DATE,6) = '$date' AND A.CHR_SLOC_TRANS IN ('MT01','MT03') ORDER BY A.CHR_ENTRIED_TIME DESC")->result(); //AND A.CHR_ENTRIED_DATE = '$date'
    }

    //Loop3r 20211229
    public function getDataStockSparePart($date)
    {
        $db_samanta = $this->load->database("samanta", TRUE);

        return  $db_samanta->query("SELECT A.CHR_PART_NO, A.CHR_SPARE_PART_NAME, A.CHR_COMPONENT, A.CHR_MODEL, A.CHR_TYPE, A.CHR_SPECIFICATION, 
        A.INT_QTY_USE AS INT_QTY, A.INT_QTY_MIN, A.INT_QTY_MAX, (CONVERT(FLOAT,A.CHR_PRICE)) AS CHR_PRICE, 0 AS INT_QTY_ORDER
        FROM TM_SPARE_PARTS A
        INNER JOIN TT_SPARE_PARTS_SLOC C ON C.CHR_PART_NO = A.CHR_PART_NO
        WHERE A.CHR_FLAG_DELETE = 'F' AND CHR_SLOC IN ('MT01','MT03') AND  LEFT(A.CHR_CREATED_DATE,6) = '$date'
        ORDER BY A.CHR_PRICE DESC")->result();
    }

    //Loop3r 20211229
    public function getDataOrderSparePart()
    {
        $db_samanta = $this->load->database("samanta", TRUE);

        return  $db_samanta->query("SELECT CHR_PART_NO, CHR_SPARE_PART_NAME,CHR_SPECIFICATION, CHR_COMPONENT, CHR_MODEL, INT_QTY_USE AS INT_QTY 
        FROM TT_SPARE_PARTS_ORDER")->result();
    }

}