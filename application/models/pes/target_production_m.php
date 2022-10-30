<?php

class target_production_m extends CI_Model
{

    private $tabel = 'PRD.TM_TARGET_PRODUCTION';
    private $temp_tabel = 'PRD.TW_TARGET_PRODUCTION';

    public function __construct()
    {
        parent::__construct();
    }

    function save()
    {
        if ($this->session->userdata('ROLE') == 6 || $this->session->userdata('ROLE') == 5) {
            if ($this->session->userdata('DEPT') == 21 || $this->session->userdata('DEPT') == 22 || $this->session->userdata('DEPT') == 23) {
                $stored_procedure = "EXEC PRD.zsp_merge_target_production";
            } else if ($this->session->userdata('DEPT') == 24) {
                $stored_procedure = "EXEC PRD.zsp_merge_target_production";
            } else {
                $stored_procedure = "EXEC PRD.zsp_merge_target_production_from_ppic";
            }
        } else {
            $stored_procedure = "EXEC PRD.zsp_merge_target_production_from_ppic";
        }
        $this->db->query($stored_procedure);
    }

    function get_data_target_by_workcenter_and_period($work_center, $period)
    {
        $status = $this->db->query("SELECT INT_TARGET_PER_SHIFT FROM PRD.TM_TARGET_PRODUCTION WHERE CHR_WORK_CENTER = '$work_center' AND CHR_PERIOD = '$period'");

        if ($status->num_rows() > 0) {
            return $status->row()->INT_TARGET_PER_SHIFT;
        } else {
            return 0;
        }
    }

    function delete($id)
    {
        $data = array('INT_FLG_DEL' => 1);

        $this->db->where('INT_ID', $id);
        $this->db->update($this->tabel, $data);
    }

    function update($data, $id)
    {
        $this->db->where('INT_ID', $id);
        $this->db->update($this->tabel, $data);
    }

    function get_data_by_id($id)
    {
        return $this->db->query("SELECT * FROM $this->tabel WHERE INT_ID = $id")->row();
    }

    function get_data($date)
    {
        $data =  $this->db->query("SELECT * FROM $this->tabel WHERE CHR_PERIOD = '$date' AND INT_FLG_DEL = 0")->result();
        return $data;
    }

    function get_data_temp()
    {
        return $this->db->query("SELECT * FROM $this->temp_tabel WHERE INT_FLG_DEL = 0")->result();
    }

    function get_status_data_temp()
    {
        $status = $this->db->query("SELECT * FROM $this->temp_tabel");

        if ($status->num_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    function save_temp($data)
    {
        $this->db->insert($this->temp_tabel, $data);
    }

    function truncate_temp_data()
    {
        $this->db->query("truncate table $this->temp_tabel");
    }

    function get_target_production_by_period_and_work_center($period, $work_center)
    {
        return $this->db->query("SELECT TOP 1 INT_TARGET_PER_SHIFT FROM $this->tabel WHERE CHR_WORK_CENTER = '$work_center' AND INT_BULAN = '$period'");
    }

    function get_target_production_work_center($work_center)
    {

        $stored_procedure = "EXEC PRD.zsp_get_target_production ?";
        $param = array(
            'work_center' => $work_center
        );

        return $this->db->query($stored_procedure, $param);
    }
}
