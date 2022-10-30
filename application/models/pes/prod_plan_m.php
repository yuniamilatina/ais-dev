<?php

class prod_plan_m extends CI_Model {

    private $tabel = 'TM_PROD_PLAN';

    function get_prod_plan($id_dept, $work_center, $date) {
        $stored_procedure = "EXEC PRODUCTION.zsp_get_production_planning ?,?,?";
        $param = array(
            'dept' => $id_dept,
            'work_center' => $work_center,
            'date' => $date
        );

        $query = $this->db->query($stored_procedure, $param);

        return $query->result();
    }

    function check_existence($dept, $work_center, $date, $shift, $shift_type) {
        $hasil = $this->db->query("SELECT INT_ID FROM TM_PROD_PLAN WHERE INT_FLG_DEL = 0
                and INT_ID_DEPT = '$dept' AND CHR_WORK_CENTER = '$work_center' AND CHR_DATE = '$date' AND INT_SHIFT = '$shift' AND INT_FLG_SHIFT = '$shift_type'");
        return $hasil;
    }

    function merge($data) {
        $dept = $data['INT_ID_DEPT'];
        $work_center = $data['CHR_WORK_CENTER'];
        $date = $data['CHR_DATE'];
        $shift = $data['INT_SHIFT'];
        $shift_type = $data['INT_FLG_SHIFT'];

        $result = $this->check_existence($dept, $work_center, $date, $shift, $shift_type);

        if ($result->num_rows() > 0) {
            $id = array(
                'INT_ID_DEPT' => $dept,
                'CHR_DATE' => $date,
                'CHR_WORK_CENTER' => $work_center,
                'INT_SHIFT' => $shift,
                'INT_FLG_SHIFT' => $this->input->post('INT_FLG_SHIFT')
            );
            $this->db->where($id);
            $this->db->update($this->tabel, $data);
        } else {
            $this->db->insert($this->tabel, $data);
        }
    }

    function get_data($id) {
        $hasil = $this->db->query("SELECT INT_ID, INT_TARGET_PROD, INT_CYCLE_TIME, CONVERT(VARCHAR(10), CHR_DATE, 106) AS CHR_DATE, INT_SHIFT, CHR_WORK_CENTER, INT_FLG_SHIFT 
                        FROM TM_PROD_PLAN
                        WHERE INT_FLG_DEL = 0 and INT_ID = '" . $id . "'");
        return $hasil;
    }

    function update($data, $id) {
        $this->db->where($id);
        $this->db->update($this->tabel, $data);
    }

}
