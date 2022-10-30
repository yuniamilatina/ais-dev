<?php

class role_m extends CI_Model
{

    private $tabel = 'TM_ROLE';

    function select_all()
    {
        $hasil = $this->db->query("SELECT * FROM TM_ROLE WHERE BIT_FLG_DEL = 0");
        return $hasil->result();
    }

    function get_user_by_role($id_role)
    {
        $query = $this->db->query("SELECT R.INT_ID_ROLE, R.CHR_ROLE, U.CHR_NPK FROM TM_ROLE R INNER JOIN TM_USER U ON U.INT_ID_ROLE = R.INT_ID_ROLE WHERE R.INT_ID_ROLE = '" . $id_role . "'");
        return $query->result();
    }

    function select_role()
    {
        $hasil = $this->db->query("SELECT * FROM TM_ROLE WHERE BIT_FLG_DEL = 0");
        return $hasil->result();
    }

    function save($data)
    {
        $this->db->insert($this->tabel, $data);
    }

    function get_data($id)
    {
        $this->db->WHERE('INT_ID_ROLE', $id);
        return $this->db->get($this->tabel)->row();
    }

    function delete($id)
    {
        $data = array('BIT_FLG_DEL' => 1);

        $this->db->WHERE('INT_ID_ROLE', $id);
        $this->db->update($this->tabel, $data);
    }

    function update($data, $id)
    {
        $this->db->WHERE('INT_ID_ROLE', $id);
        $this->db->update($this->tabel, $data);
    }

    function check_id($id)
    {
        $find_id = $this->db->query("SELECT * FROM TM_ROLE WHERE INT_ID_ROLE = '" . $id . "'");
        if ($find_id->num_rows() > 0) {
            return $find_id->result();
        }
        return false;
    }
}
