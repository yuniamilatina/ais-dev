
<?php

class report_spare_parts_m extends CI_Model { 
    
    function __construct() {
        parent::__construct();
    }
    
    //Diagram 
    function data_spare_parts_in($date,$loc) {
        $db_samanta = $this->load->database("samanta", TRUE);  
        $query = $db_samanta->query("SELECT SP.CHR_TYPE_TRANS, 
                                        SUM(SP.INT_QTY) AS INT_TOTAL_QTY, 
                                        CAST(SUM(SP.INT_QTY * SP.CHR_PRICE)/1000000 AS FLOAT) AS CHR_AMOUNT,
                                        SUBSTRING(SP.CHR_ENTRIED_DATE,7,2) AS CHR_DATE
                                    FROM TT_SPARE_PARTS SP 
                                    INNER JOIN TM_SPARE_PARTS A ON A.CHR_PART_NO = SP.CHR_PART_NO
                                    WHERE LEFT(SP.CHR_ENTRIED_DATE,6) = '$date' AND SP.CHR_TYPE_TRANS = 'IN' and SP.CHR_SLOC_TRANS like '%".$loc."%'
                                    GROUP BY SP.CHR_TYPE_TRANS, SP.CHR_ENTRIED_DATE ORDER BY SP.CHR_ENTRIED_DATE ASC");

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return 0;
        }
    }
    function data_spare_parts_out($date,$loc) {
        $db_samanta = $this->load->database("samanta", TRUE);  
        $query = $db_samanta->query("SELECT SP.CHR_TYPE_TRANS, 
                                        SUM(SP.INT_QTY) AS INT_TOTAL_QTY, 
                                        CAST(SUM(SP.INT_QTY * SP.CHR_PRICE)/1000000 AS FLOAT) AS CHR_AMOUNT,
                                        SUBSTRING(SP.CHR_ENTRIED_DATE,7,2) AS CHR_DATE
                                    FROM TT_SPARE_PARTS SP 
                                    INNER JOIN TM_SPARE_PARTS A ON A.CHR_PART_NO = SP.CHR_PART_NO
                                    WHERE LEFT(SP.CHR_ENTRIED_DATE,6) = '$date' AND SP.CHR_TYPE_TRANS = 'OUT' and SP.CHR_SLOC_TRANS like '%".$loc."%'
                                    GROUP BY SP.CHR_TYPE_TRANS, SP.CHR_ENTRIED_DATE ORDER BY SP.CHR_ENTRIED_DATE ASC");

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return 0;
        }
    }
    function get_amount_in($date,$loc) {
        $db_samanta = $this->load->database("samanta", TRUE);  
        $query = $db_samanta->query("SELECT SUM(SP.INT_QTY * A.CHR_PRICE) AS CHR_AMOUNT_IN
                                        FROM TT_SPARE_PARTS SP 
                                        INNER JOIN TM_SPARE_PARTS A ON A.CHR_PART_NO = SP.CHR_PART_NO
                                        WHERE LEFT(SP.CHR_ENTRIED_DATE,6) = '$date' AND SP.CHR_TYPE_TRANS = 'IN' and SP.CHR_SLOC_TRANS like '%".$loc."%'");
        return $query;
    }
    function get_amount_out($date,$loc) {
        $db_samanta = $this->load->database("samanta", TRUE);  
        $query = $db_samanta->query("SELECT SUM(SP.INT_QTY * A.CHR_PRICE) AS CHR_AMOUNT_OUT
                                        FROM TT_SPARE_PARTS SP 
                                        INNER JOIN TM_SPARE_PARTS A ON A.CHR_PART_NO = SP.CHR_PART_NO
                                        WHERE LEFT(SP.CHR_ENTRIED_DATE,6) = '$date' AND SP.CHR_TYPE_TRANS = 'OUT' and SP.CHR_SLOC_TRANS like '%".$loc."%'");
        return $query;
    }
    

    function get_amount_inventory($loc) {
        $db_samanta = $this->load->database("samanta", TRUE);  
        $query = $db_samanta->query("SELECT SUM(CAST(INT_QTY * CHR_PRICE AS BIGINT)) AS TOTAL_INVENTORY FROM TM_SPARE_PARTS A 
                                            INNER JOIN TT_SPARE_PARTS_SLOC B ON B.CHR_PART_NO = A.CHR_PART_NO WHERE B.CHR_SLOC = '$loc'");

        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return 0;
        }
    }

    function get_amount_inventory_total() {
        $db_samanta = $this->load->database("samanta", TRUE);  
        $query = $db_samanta->query("SELECT SUM(CAST(INT_QTY * CHR_PRICE AS BIGINT)) AS TOTAL_INVENTORY FROM TM_SPARE_PARTS A 
                                            INNER JOIN TT_SPARE_PARTS_SLOC B ON B.CHR_PART_NO = A.CHR_PART_NO");

        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return 0;
        }
    }

    function get_amount_inventory_history($date, $loc) {
        $db_samanta = $this->load->database("samanta", TRUE);  
        $query = $db_samanta->query("SELECT INT_TOTAL_AMOUNT_INV AS TOTAL_INVENTORY FROM TT_INV_HISTORY WHERE SLOC = '$loc' AND DATE = '$date'");

        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return 0;
        }
    }

    function get_amount_inventory_total_history($date) {
        $db_samanta = $this->load->database("samanta", TRUE);  
        $query = $db_samanta->query("SELECT INT_TOTAL_AMOUNT_INV AS TOTAL_INVENTORY FROM TT_INV_HISTORY WHERE SLOC = 'ALL' AND DATE = '$date'");

        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return 0;
        }
    }

    // ========================================================
    // Add report spare parts consumption by group product
    // Update date: 08.03.2019
    
    // Start
    //Diagram CC
    function data_cc_in($date,$loc) {
        $db_samanta = $this->load->database("samanta", TRUE);  
        $query = $db_samanta->query("SELECT SP.CHR_TYPE_TRANS as CHR_TYPE_TRANS, SUM(SP.INT_QTY) AS INT_TOTAL_QTY, CAST(SUM(SP.INT_QTY * SP.CHR_PRICE)/1000000 AS FLOAT) AS CHR_AMOUNT ,SUBSTRING(SP.CHR_ENTRIED_DATE,0,7) AS CHR_DATE
            FROM TT_SPARE_PARTS SP INNER JOIN TM_SPARE_PARTS A ON A.CHR_PART_NO = SP.CHR_PART_NO 
            WHERE LEFT(SP.CHR_ENTRIED_DATE,6) = '$date' AND SP.CHR_TYPE_TRANS = 'IN' and SP.CHR_SLOC_TRANS like '%".$loc."%' and (SP.CHR_COMPONENT ='CC' OR SP.CHR_COMPONENT ='CD')
            GROUP BY SP.CHR_TYPE_TRANS , SUBSTRING(SP.CHR_ENTRIED_DATE,0,7)");

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return 0;
        }
    }

    function data_cc_out($date,$loc) {
        $db_samanta = $this->load->database("samanta", TRUE);  
        $query = $db_samanta->query("SELECT SP.CHR_TYPE_TRANS as CHR_TYPE_TRANS, SUM(SP.INT_QTY) AS INT_TOTAL_QTY, CAST(SUM(SP.INT_QTY * SP.CHR_PRICE)/1000000 AS FLOAT) AS CHR_AMOUNT ,SUBSTRING(SP.CHR_ENTRIED_DATE,0,7) AS CHR_DATE
            FROM TT_SPARE_PARTS SP INNER JOIN TM_SPARE_PARTS A ON A.CHR_PART_NO = SP.CHR_PART_NO 
            WHERE LEFT(SP.CHR_ENTRIED_DATE,6) = '$date' AND SP.CHR_TYPE_TRANS = 'OUT' and SP.CHR_SLOC_TRANS like '%".$loc."%' and (SP.CHR_COMPONENT ='CC' OR SP.CHR_COMPONENT ='CD') 
            GROUP BY SP.CHR_TYPE_TRANS , SUBSTRING(SP.CHR_ENTRIED_DATE,0,7)");

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return 0;
        }
    }

    //Diagram DL
    function data_dl_in($date,$loc) {
        $db_samanta = $this->load->database("samanta", TRUE);  
        $query = $db_samanta->query("SELECT SP.CHR_TYPE_TRANS as CHR_TYPE_TRANS, SUM(SP.INT_QTY) AS INT_TOTAL_QTY, CAST(SUM(SP.INT_QTY * SP.CHR_PRICE)/1000000 AS FLOAT) AS CHR_AMOUNT ,SUBSTRING(SP.CHR_ENTRIED_DATE,0,7) AS CHR_DATE
            FROM TT_SPARE_PARTS SP INNER JOIN TM_SPARE_PARTS A ON A.CHR_PART_NO = SP.CHR_PART_NO 
            WHERE LEFT(SP.CHR_ENTRIED_DATE,6) = '$date' AND SP.CHR_TYPE_TRANS = 'IN' and SP.CHR_SLOC_TRANS like '%".$loc."%' and SP.CHR_COMPONENT ='DL' 
            GROUP BY SP.CHR_TYPE_TRANS , SUBSTRING(SP.CHR_ENTRIED_DATE,0,7)");

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return 0;
        }
    }

    function data_dl_out($date,$loc) {
        $db_samanta = $this->load->database("samanta", TRUE);  
        $query = $db_samanta->query("SELECT SP.CHR_TYPE_TRANS as CHR_TYPE_TRANS, SUM(SP.INT_QTY) AS INT_TOTAL_QTY, CAST(SUM(SP.INT_QTY * SP.CHR_PRICE)/1000000 AS FLOAT) AS CHR_AMOUNT ,SUBSTRING(SP.CHR_ENTRIED_DATE,0,7) AS CHR_DATE
            FROM TT_SPARE_PARTS SP INNER JOIN TM_SPARE_PARTS A ON A.CHR_PART_NO = SP.CHR_PART_NO 
            WHERE LEFT(SP.CHR_ENTRIED_DATE,6) = '$date' AND SP.CHR_TYPE_TRANS = 'OUT' and SP.CHR_SLOC_TRANS like '%".$loc."%' and SP.CHR_COMPONENT ='DL' 
            GROUP BY SP.CHR_TYPE_TRANS , SUBSTRING(SP.CHR_ENTRIED_DATE,0,7)");

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return 0;
        }
    }

    //Diagram BP
    function data_bp_in($date,$loc) {
        $db_samanta = $this->load->database("samanta", TRUE);  
        $query = $db_samanta->query("SELECT SP.CHR_TYPE_TRANS as CHR_TYPE_TRANS, SUM(SP.INT_QTY) AS INT_TOTAL_QTY, CAST(SUM(SP.INT_QTY * SP.CHR_PRICE)/1000000 AS FLOAT) AS CHR_AMOUNT ,SUBSTRING(SP.CHR_ENTRIED_DATE,0,7) AS CHR_DATE
            FROM TT_SPARE_PARTS SP INNER JOIN TM_SPARE_PARTS A ON A.CHR_PART_NO = SP.CHR_PART_NO 
            WHERE LEFT(SP.CHR_ENTRIED_DATE,6) = '$date' AND SP.CHR_TYPE_TRANS = 'IN' and SP.CHR_SLOC_TRANS like '%".$loc."%' and (SP.CHR_COMPONENT ='DC' or SP.CHR_COMPONENT ='HL' or SP.CHR_COMPONENT ='DH' or SP.CHR_COMPONENT ='PS' or SP.CHR_COMPONENT ='WR')
            GROUP BY SP.CHR_TYPE_TRANS , SUBSTRING(SP.CHR_ENTRIED_DATE,0,7)");

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return 0;
        }
    }
    function data_bp_out($date,$loc) {
        $db_samanta = $this->load->database("samanta", TRUE);  
        $query = $db_samanta->query("SELECT SP.CHR_TYPE_TRANS as CHR_TYPE_TRANS, SUM(SP.INT_QTY) AS INT_TOTAL_QTY, CAST(SUM(SP.INT_QTY * SP.CHR_PRICE)/1000000 AS FLOAT) AS CHR_AMOUNT ,SUBSTRING(SP.CHR_ENTRIED_DATE,0,7) AS CHR_DATE
            FROM TT_SPARE_PARTS SP INNER JOIN TM_SPARE_PARTS A ON A.CHR_PART_NO = SP.CHR_PART_NO 
            WHERE LEFT(SP.CHR_ENTRIED_DATE,6) = '$date' AND SP.CHR_TYPE_TRANS = 'OUT' and SP.CHR_SLOC_TRANS like '%".$loc."%' and (SP.CHR_COMPONENT ='DC' or SP.CHR_COMPONENT ='HL' or SP.CHR_COMPONENT ='DH' or SP.CHR_COMPONENT ='PS' or SP.CHR_COMPONENT ='WR')
            GROUP BY SP.CHR_TYPE_TRANS , SUBSTRING(SP.CHR_ENTRIED_DATE,0,7)");

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return 0;
        }
    }
    
    // Diragram DF
    function data_df_in($date,$loc) {
        $db_samanta = $this->load->database("samanta", TRUE);  
        $query = $db_samanta->query("SELECT SP.CHR_TYPE_TRANS as CHR_TYPE_TRANS, SUM(SP.INT_QTY) AS INT_TOTAL_QTY, CAST(SUM(SP.INT_QTY * SP.CHR_PRICE)/1000000 AS FLOAT) AS CHR_AMOUNT ,SUBSTRING(SP.CHR_ENTRIED_DATE,0,7) AS CHR_DATE
            FROM TT_SPARE_PARTS SP INNER JOIN TM_SPARE_PARTS A ON A.CHR_PART_NO = SP.CHR_PART_NO 
            WHERE LEFT(SP.CHR_ENTRIED_DATE,6) = '$date' AND SP.CHR_TYPE_TRANS = 'IN' and SP.CHR_SLOC_TRANS like '%".$loc."%' and SP.CHR_COMPONENT ='DF'
            GROUP BY SP.CHR_TYPE_TRANS , SUBSTRING(SP.CHR_ENTRIED_DATE,0,7)");

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return 0;
        }
    }

    function data_df_out($date,$loc) {
        $db_samanta = $this->load->database("samanta", TRUE);  
        $query = $db_samanta->query("SELECT SP.CHR_TYPE_TRANS as CHR_TYPE_TRANS, SUM(SP.INT_QTY) AS INT_TOTAL_QTY, CAST(SUM(SP.INT_QTY * SP.CHR_PRICE)/1000000 AS FLOAT) AS CHR_AMOUNT ,SUBSTRING(SP.CHR_ENTRIED_DATE,0,7) AS CHR_DATE
            FROM TT_SPARE_PARTS SP INNER JOIN TM_SPARE_PARTS A ON A.CHR_PART_NO = SP.CHR_PART_NO 
            WHERE LEFT(SP.CHR_ENTRIED_DATE,6) = '$date' AND SP.CHR_TYPE_TRANS = 'OUT' and SP.CHR_SLOC_TRANS like '%".$loc."%' and SP.CHR_COMPONENT ='DF'
            GROUP BY SP.CHR_TYPE_TRANS , SUBSTRING(SP.CHR_ENTRIED_DATE,0,7)");

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return 0;
        }
    }

    // Diragram AL
    function data_al_in($date,$loc) {
        $db_samanta = $this->load->database("samanta", TRUE);  
        $query = $db_samanta->query("SELECT SP.CHR_TYPE_TRANS as CHR_TYPE_TRANS, SUM(SP.INT_QTY) AS INT_TOTAL_QTY, CAST(SUM(SP.INT_QTY * SP.CHR_PRICE)/1000000 AS FLOAT) AS CHR_AMOUNT ,SUBSTRING(SP.CHR_ENTRIED_DATE,0,7) AS CHR_DATE
            FROM TT_SPARE_PARTS SP INNER JOIN TM_SPARE_PARTS A ON A.CHR_PART_NO = SP.CHR_PART_NO 
            WHERE LEFT(SP.CHR_ENTRIED_DATE,6) = '$date' AND SP.CHR_TYPE_TRANS = 'IN' and SP.CHR_SLOC_TRANS like '%".$loc."%' and SP.CHR_COMPONENT ='AL'
            GROUP BY SP.CHR_TYPE_TRANS , SUBSTRING(SP.CHR_ENTRIED_DATE,0,7)");

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return 0;
        }
    }

    function data_al_out($date,$loc) {
        $db_samanta = $this->load->database("samanta", TRUE);  
        $query = $db_samanta->query("SELECT SP.CHR_TYPE_TRANS as CHR_TYPE_TRANS, SUM(SP.INT_QTY) AS INT_TOTAL_QTY, CAST(SUM(SP.INT_QTY * SP.CHR_PRICE)/1000000 AS FLOAT) AS CHR_AMOUNT ,SUBSTRING(SP.CHR_ENTRIED_DATE,0,7) AS CHR_DATE
            FROM TT_SPARE_PARTS SP INNER JOIN TM_SPARE_PARTS A ON A.CHR_PART_NO = SP.CHR_PART_NO 
            WHERE LEFT(SP.CHR_ENTRIED_DATE,6) = '$date' AND SP.CHR_TYPE_TRANS = 'OUT' and SP.CHR_SLOC_TRANS like '%".$loc."%' and SP.CHR_COMPONENT ='AL'
            GROUP BY SP.CHR_TYPE_TRANS , SUBSTRING(SP.CHR_ENTRIED_DATE,0,7)");

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return 0;
        }
    }
    // End

    // ----------------------------------------------------------------------------------
    // Improvement report
    // Created by   : Ilham Januardy
    // Date         : 23 Oct 2019
    // Function     : Report in out per periode, setiap line perday
    // ----------------------------------------------------------------------------------
    // start

    function get_data_pivot_transaction_out_per_periode($periode, $group) {
        $db_samanta = $this->load->database("samanta", TRUE);  
        $stored_procedure = "EXEC zsp_get_data_transaction_out_per_periode ?,?";
        $param = array(
            'periode' => $periode,
            'group_line' => $group );

        $query = $db_samanta->query($stored_procedure, $param);

        return $query->result();
    }

    function get_data_pivot_transaction_in_per_periode($periode, $group) {
        $db_samanta = $this->load->database("samanta", TRUE);  
        $stored_procedure = "EXEC zsp_get_data_transaction_in_per_periode ?,?";
        $param = array(
            'periode' => $periode,
            'group_line' => $group );

        $query = $db_samanta->query($stored_procedure, $param);
        return $query->result();
    }

    function get_all_product_group_custom() {
        $db_samanta = $this->load->database("samanta", TRUE);
        $query = $db_samanta->query("SELECT (1) AS ID, ('ERP') AS CHR_GROUP_LINE
                                        UNION SELECT (2) AS ID, ('BRP') AS CHR_GROUP_LINE
                                        UNION SELECT (3) AS ID, ('DOORFRAME') AS CHR_GROUP_LINE
                                        UNION SELECT (4) AS ID, ('MFG') AS CHR_GROUP_LINE
                                        UNION SELECT (5) AS ID, ('PPIC') AS CHR_GROUP_LINE
                                        UNION SELECT (6) AS ID, ('OTHERS') AS CHR_GROUP_LINE
                                        UNION SELECT (0) AS ID, ('ALL') AS CHR_GROUP_LINE");
        return $query->result();
    }
    // end
}

?>