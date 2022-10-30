<?php

class table_m extends CI_Model {

    function get_data_table() {
        $query = $this->db->query("SELECT * FROM INFORMATION_SCHEMA.TABLES
                WHERE TABLE_TYPE='BASE TABLE' ORDER BY TABLE_SCHEMA, TABLE_NAME ASC");
        return $query->result();
    }

    function get_data_table_by_id($catalog, $scheme, $name) {
        $stored_procedure = "EXEC MIS.zsp_get_data_table_by_schema_and_table_name ?,?,?";
        $param = array(
            'table_catalog' => $catalog,
            'table_schema' => $scheme,
            'table_name' => $name);

        $query = $this->db->query($stored_procedure, $param);

        return $query->result();
    }

}
