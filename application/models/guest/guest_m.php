<?php

class guest_m extends CI_Model {

    private $tabel = 'TM_GUEST';

    function get_all_guest() {
        $query = $this->db->query("SELECT G.INT_ID, G.CHR_COMPANY, G.CHR_PIC, RTRIM(G.CHR_FIRST_NAME) AS CHR_FIRSTNAME, RTRIM(G.CHR_LAST_NAME) AS CHR_LASTNAME, G.CHR_SCHEDULE_DATE, 
            G.CHR_SCHEDULE_TIME, G.CHR_COMPANY, G.CHR_HOTEL, G.CHR_PROJECT_NAME, 
            CASE WHEN G.INT_FLG_REGIONAL = 0 THEN 'LOCAL' ELSE 'OVERSEAS' END AS INT_FLG_REGIONAL
            FROM TM_GUEST G 
            WHERE G.INT_FLG_DEL = 0 --AND G.CHR_SCHEDULE_DATE = (CONVERT([char](10),getdate(),(112)))
	    ORDER BY G.CHR_SCHEDULE_DATE DESC");
        return $query->result();
    }
    
    function getGuest() {
        $query = $this->db->query("SELECT 
        CHR_COMPANY, 
        RTRIM(CHR_FIRST_NAME) AS CHR_FIRSTNAME, 
        RTRIM(CHR_LAST_NAME) AS CHR_LASTNAME
            FROM TM_GUEST 
            WHERE INT_FLG_DEL = 0 AND CHR_SCHEDULE_DATE = (CONVERT([char](10),getdate(),(112))) 
	    ORDER BY INT_ID ASC");
        return $query->result();
    }
    
    function get_top5_guest() {
        $query = $this->db->query("SELECT TOP 8 G.INT_ID, G.CHR_COMPANY, G.CHR_PIC, RTRIM(G.CHR_FIRST_NAME) AS CHR_FIRSTNAME, RTRIM(G.CHR_LAST_NAME) AS CHR_LASTNAME, G.CHR_SCHEDULE_DATE, 
            G.CHR_SCHEDULE_TIME, G.CHR_COMPANY, G.CHR_HOTEL, G.CHR_PROJECT_NAME, 
            CASE WHEN G.INT_FLG_REGIONAL = 0 THEN 'LOCAL' ELSE 'OVERSEAS' END AS INT_FLG_REGIONAL
            FROM TM_GUEST G 
            WHERE G.INT_FLG_DEL = 0 AND G.CHR_SCHEDULE_DATE = (CONVERT([char](10),getdate(),(112))) 
	    ORDER BY G.INT_ID ASC");
        return $query->result();
    }

    function get_top_guest_1() {
        $query = $this->db->query("SELECT TOP 8 G.INT_ID, G.CHR_COMPANY, G.CHR_PIC, RTRIM(G.CHR_FIRST_NAME) AS CHR_FIRSTNAME, RTRIM(G.CHR_LAST_NAME) AS CHR_LASTNAME, G.CHR_SCHEDULE_DATE, 
            G.CHR_SCHEDULE_TIME, G.CHR_COMPANY, G.CHR_HOTEL, G.CHR_PROJECT_NAME, 
            CASE WHEN G.INT_FLG_REGIONAL = 0 THEN 'LOCAL' ELSE 'OVERSEAS' END AS INT_FLG_REGIONAL
            FROM TM_GUEST G 
            WHERE G.INT_FLG_DEL = 0 AND G.CHR_SCHEDULE_DATE = (CONVERT([char](10),getdate(),(112))) AND G.INT_ID > 276
	    ORDER BY G.INT_ID ASC");
        return $query->result();
    }

    function get_top_guest_2() {
        $query = $this->db->query("SELECT TOP 1 G.INT_ID, G.CHR_COMPANY, G.CHR_PIC, RTRIM(G.CHR_FIRST_NAME) AS CHR_FIRSTNAME, RTRIM(G.CHR_LAST_NAME) AS CHR_LASTNAME, G.CHR_SCHEDULE_DATE, 
            G.CHR_SCHEDULE_TIME, G.CHR_COMPANY, G.CHR_HOTEL, G.CHR_PROJECT_NAME, 
            CASE WHEN G.INT_FLG_REGIONAL = 0 THEN 'LOCAL' ELSE 'OVERSEAS' END AS INT_FLG_REGIONAL
            FROM TM_GUEST G 
            WHERE G.INT_FLG_DEL = 0 AND G.CHR_SCHEDULE_DATE = (CONVERT([char](10),getdate(),(112))) AND G.INT_ID > 276
	    ORDER BY G.INT_ID ASC");
        return $query->result();
    }

    function get_top_guest_3() {
        $query = $this->db->query("SELECT TOP 1 G.INT_ID, G.CHR_COMPANY, G.CHR_PIC, RTRIM(G.CHR_FIRST_NAME) AS CHR_FIRSTNAME, RTRIM(G.CHR_LAST_NAME) AS CHR_LASTNAME, G.CHR_SCHEDULE_DATE, 
            G.CHR_SCHEDULE_TIME, G.CHR_COMPANY, G.CHR_HOTEL, G.CHR_PROJECT_NAME, 
            CASE WHEN G.INT_FLG_REGIONAL = 0 THEN 'LOCAL' ELSE 'OVERSEAS' END AS INT_FLG_REGIONAL
            FROM TM_GUEST G 
            WHERE G.INT_FLG_DEL = 0 AND G.CHR_SCHEDULE_DATE = (CONVERT([char](10),getdate(),(112))) AND G.INT_ID = 216 
	    ORDER BY G.INT_ID ASC");
        return $query->result();
    }

    function save_guest($data) {
        $this->db->insert($this->tabel, $data);
    }

    function get_data_guest($id) {
        $query = $this->db->query("SELECT G.INT_ID, G.CHR_COMPANY, RTRIM(G.CHR_FIRST_NAME) AS CHR_FIRSTNAME, RTRIM(G.CHR_LAST_NAME) AS CHR_LASTNAME, G.CHR_SCHEDULE_DATE, 
            G.CHR_SCHEDULE_TIME, G.CHR_COMPANY, G.CHR_HOTEL, G.CHR_PROJECT_NAME
            FROM TM_GUEST G  WHERE G.INT_FLG_DEL = 0  and INT_ID  = '$id'");

        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return 0;
        }
    }

    function get_data_detail_inlguestcan($id) {
        $query = $this->db->query("select INT_ID, INT_ID_ASSET, CHR_WORK_CENTER, CHR_IP, INT_ID_DEPT, CHR_USAGE
            from TM_INLINE_SCAN where BIT_FLG_ACTIVE = 0 and INT_ID = '" . $id . "'");

        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return 0;
        }
    }
    
    function delete($id) {
        $data = array('INT_FLG_DEL' => 1);

        $this->db->where('INT_ID', $id);
        $this->db->update($this->tabel, $data);
    }

    function update($data, $id) {
        $this->db->where('INT_ID', $id);
        $this->db->update($this->tabel, $data);
    }

}
