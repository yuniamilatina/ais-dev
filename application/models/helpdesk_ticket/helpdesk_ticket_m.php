<?php

class helpdesk_ticket_m extends CI_Model {

    private $tabel = 'MIS.TT_HELPDESK_TICKET';

    function get_helpdesk_ticket_by_admin() {
        return $this->db->query("SELECT c.CHR_NPK, a.INT_ID_TICKET,a.CHR_DUE_DATE,a.INT_PRIORITY,a.INT_STATUS,a.INT_APPROVE,
            b.CHR_PROBLEM_TYPE,b.CHR_PROBLEM_TYPE_DESC, a.CHR_ASSET_NAME, a.CHR_PROBLEM_TITLE, a.CHR_PROBLEM_DESC,a.CHR_FINISH_DATE, 
            a.CHR_CREATE_DATE, a.CHR_CREATE_TIME,c.CHR_USERNAME,d.CHR_PROVER, d.CHR_PROVER_DESC, e.CHR_DEPT
            FROM   MIS.TT_HELPDESK_TICKET a
            INNER JOIN MIS.TM_HELPDESK_PROBLEM_TYPE b ON a.INT_ID_PROBLEM_TYPE =b.INT_ID_PROBLEM_TYPE
            INNER JOIN TM_USER c ON a.CHR_NPK = c.CHR_NPK
            INNER JOIN MIS.TM_HELPDESK_PROVER d ON a.INT_ID_PROVER =d.INT_ID_PROVER 
            LEFT JOIN TM_DEPT e ON a.INT_ID_DEPT = e.INT_ID_DEPT
            WHERE a.BIT_FLG_DEL = 0  --AND a.INT_STATUS IN (0,1,2)
            ORDER BY a.INT_PRIORITY ASC, a.CHR_CREATE_DATE DESC")->result();
    }

    function get_close_helpdesk_ticket() {
        $query = $this->db->query("select a.INT_ID_TICKET,a.CHR_DUE_DATE,a.INT_PRIORITY,a.INT_STATUS, b.CHR_PROBLEM_TYPE,b.CHR_PROBLEM_TYPE_DESC, a.CHR_PROBLEM_TITLE,a.CHR_FINISH_DATE, a.CHR_CREATE_DATE, a.CHR_CREATE_TIME,c.CHR_USERNAME,d.CHR_PROVER, e.CHR_DEPT
            from MIS.TT_HELPDESK_TICKET a, MIS.TM_HELPDESK_PROBLEM_TYPE b, TM_USER c, MIS.TM_HELPDESK_PROVER d, TM_DEPT e
            where a.CHR_NPK = c.CHR_NPK and a.INT_ID_PROVER =d.INT_ID_PROVER and a.INT_ID_DEPT =e.INT_ID_DEPT and a.INT_ID_PROBLEM_TYPE =b.INT_ID_PROBLEM_TYPE and a.BIT_FLG_DEL = 0
            and a.INT_STATUS = 2");
        return $query->result();
    }

    function get_helpdesk_ticket_by_prover($id_ticket) {
        $query = $this->db->query("select a.INT_ID_TICKET,a.CHR_DUE_DATE,a.INT_PRIORITY,a.INT_STATUS, b.CHR_PROBLEM_TYPE,b.CHR_PROBLEM_TYPE_DESC, 
            a.CHR_PROBLEM_TITLE,a.CHR_FINISH_DATE, a.CHR_CREATE_DATE, a.CHR_FIX_DATE, a.CHR_FIX_TIME, a.CHR_CREATE_DATE, a.CHR_CREATE_TIME,c.CHR_USERNAME,d.CHR_PROVER, 
            e.CHR_DEPT 

            from MIS.TT_HELPDESK_TICKET a 
                    INNER JOIN MIS.TM_HELPDESK_PROBLEM_TYPE b ON a.INT_ID_PROBLEM_TYPE =b.INT_ID_PROBLEM_TYPE 
                    INNER JOIN TM_USER c ON a.CHR_NPK = c.CHR_NPK
                    INNER JOIN MIS.TM_HELPDESK_PROVER d ON a.INT_ID_PROVER =d.INT_ID_PROVER
                    INNER JOIN TM_DEPT e ON a.INT_ID_DEPT = e.INT_ID_DEPT 

            where  a.INT_ID_PROVER = $id_ticket and a.BIT_FLG_DEL = 0");
        return $query->result();
    }

    function get_helpdesk_ticket_by_staff($npk) {
        return $this->db->query("SELECT c.CHR_NPK, a.INT_ID_TICKET,a.CHR_DUE_DATE,a.INT_PRIORITY,a.INT_STATUS,a.INT_APPROVE,
            b.CHR_PROBLEM_TYPE,b.CHR_PROBLEM_TYPE_DESC, a.CHR_ASSET_NAME, a.CHR_PROBLEM_TITLE,a.CHR_PROBLEM_DESC,a.CHR_FINISH_DATE, 
            a.CHR_CREATE_DATE, a.CHR_CREATE_TIME,c.CHR_USERNAME,d.CHR_PROVER, d.CHR_PROVER_DESC, e.CHR_DEPT
            FROM   MIS.TT_HELPDESK_TICKET a
            INNER JOIN MIS.TM_HELPDESK_PROBLEM_TYPE b ON a.INT_ID_PROBLEM_TYPE =b.INT_ID_PROBLEM_TYPE
            INNER JOIN TM_USER c ON a.CHR_NPK = c.CHR_NPK
            INNER JOIN MIS.TM_HELPDESK_PROVER d ON a.INT_ID_PROVER =d.INT_ID_PROVER 
            LEFT JOIN TM_DEPT e ON a.INT_ID_DEPT = e.INT_ID_DEPT
            WHERE a.BIT_FLG_DEL = 0  --AND a.INT_STATUS IN (0,1,2)
            ORDER BY a.INT_PRIORITY ASC, a.CHR_CREATE_DATE DESC")->result();
    }

    function get_problem_user($npk) {
        return $this->db->query("select COUNT(INT_ID_TICKET) as count from MIS.TT_HELPDESK_TICKET where BIT_FLG_DEL = 0 and CHR_NPK = $npk")->row()->count;
    }

//    function get_problem_by_helpdesk_ticket() {
//        $query = $this->db->query("select b.CHR_PROBLEM_TYPE_DESC,b.INT_ID_PROBLEM_TYPE, COUNT(b.CHR_PROBLEM_TYPE) as 'total'
//            from MIS.TT_HELPDESK_TICKET a, MIS.TM_HELPDESK_PROBLEM_TYPE b
//            where a.INT_ID_PROBLEM_TYPE =b.INT_ID_PROBLEM_TYPE and a.BIT_FLG_DEL = 0
//            group by b.CHR_PROBLEM_TYPE_DESC, b.INT_ID_PROBLEM_TYPE");
//        return $query->result();
//    }

    function get_helpdesk_ticket_by_dept($id_dept, $date) {
        $query = $this->db->query("select a.INT_ID_TICKET,a.CHR_DUE_DATE,a.INT_PRIORITY,b.CHR_PROBLEM_TYPE,b.CHR_PROBLEM_TYPE_DESC, a.CHR_PROBLEM_TITLE,a.CHR_PROBLEM_DESC,a.CHR_ASSET_NAME,a.CHR_FINISH_DATE, a.CHR_CREATE_DATE, a.CHR_CREATE_TIME,c.CHR_USERNAME,d.CHR_PROVER, e.CHR_DEPT
            from MIS.TT_HELPDESK_TICKET a, MIS.TM_HELPDESK_PROBLEM_TYPE b, TM_USER c, MIS.TM_HELPDESK_PROVER d, TM_DEPT e
            where a.CHR_NPK = c.CHR_NPK and a.INT_ID_PROVER =d.INT_ID_PROVER and a.INT_ID_DEPT =e.INT_ID_DEPT and a.INT_ID_PROBLEM_TYPE =b.INT_ID_PROBLEM_TYPE and a.BIT_FLG_DEL = 0
            and a.INT_STATUS = 2 and a.INT_ID_DEPT = $id_dept and LEFT(a.CHR_CREATE_DATE,6) = $date");
        return $query->result();
    }

    function get_helpdesk_ticket_by_problem($id_problem, $date) {
        $query = $this->db->query("select a.INT_ID_TICKET,a.CHR_ASSET_NAME, a.CHR_PROBLEM_DESC,a.CHR_DUE_DATE,a.INT_PRIORITY,b.CHR_PROBLEM_TYPE,b.CHR_PROBLEM_TYPE_DESC, a.CHR_PROBLEM_TITLE,a.CHR_FINISH_DATE, a.CHR_CREATE_DATE,c.CHR_USERNAME,d.CHR_PROVER_DESC, e.CHR_DEPT_DESC
            from MIS.TT_HELPDESK_TICKET a, MIS.TM_HELPDESK_PROBLEM_TYPE b, TM_USER c, MIS.TM_HELPDESK_PROVER d, TM_DEPT e
            where a.CHR_NPK = c.CHR_NPK and a.INT_ID_PROVER =d.INT_ID_PROVER and a.INT_ID_DEPT =e.INT_ID_DEPT and a.INT_ID_PROBLEM_TYPE =b.INT_ID_PROBLEM_TYPE and a.BIT_FLG_DEL = 0
            and a.INT_STATUS = 2 and a.INT_ID_PROBLEM_TYPE = $id_problem and LEFT(a.CHR_CREATE_DATE,6) = $date");
        return $query->result();
    }

    function get_helpdesk_ticket_by_date($date) {
        $query = $this->db->query("select a.INT_ID_TICKET,a.CHR_ASSET_NAME, a.CHR_PROBLEM_DESC,a.CHR_DUE_DATE,a.INT_PRIORITY,b.CHR_PROBLEM_TYPE,b.CHR_PROBLEM_TYPE_DESC, a.CHR_PROBLEM_TITLE,a.CHR_FINISH_DATE, a.CHR_CREATE_DATE,c.CHR_USERNAME,d.CHR_PROVER_DESC, e.CHR_DEPT_DESC
            from MIS.TT_HELPDESK_TICKET a, MIS.TM_HELPDESK_PROBLEM_TYPE b, TM_USER c, MIS.TM_HELPDESK_PROVER d, TM_DEPT e
            where a.CHR_NPK = c.CHR_NPK and a.INT_ID_PROVER =d.INT_ID_PROVER and a.INT_ID_DEPT =e.INT_ID_DEPT and a.INT_ID_PROBLEM_TYPE =b.INT_ID_PROBLEM_TYPE and a.BIT_FLG_DEL = 0
            and LEFT(a.CHR_CREATE_DATE,6) = $date");
        return $query->result();
    }

    function get_helpdesk_ticket_group_by_dept($date) {
        $query = $this->db->query("select e.CHR_DEPT, count(e.CHR_DEPT) as total
            from MIS.TT_HELPDESK_TICKET a, TM_DEPT e
            where a.INT_ID_DEPT =e.INT_ID_DEPT and a.BIT_FLG_DEL = 0
            and LEFT(a.CHR_CREATE_DATE,6) = $date
            group by e.CHR_DEPT");
        return $query->result();
    }

    function get_helpdesk_ticket_group_by_type($date) {
        $query = $this->db->query("select e.CHR_PROBLEM_TYPE_DESC, count(e.CHR_PROBLEM_TYPE_DESC) as total
            from MIS.TT_HELPDESK_TICKET a, MIS.TM_HELPDESK_PROBLEM_TYPE e
            where a.INT_ID_PROBLEM_TYPE =e.INT_ID_PROBLEM_TYPE and a.BIT_FLG_DEL = 0
            and LEFT(a.CHR_CREATE_DATE,6) = $date
            group by e.CHR_PROBLEM_TYPE_DESC");
        return $query->result();
    }

//
//    function get_helpdesk_ticket_by_user($npk) {
//        $query = $this->db->query("select COUNT(INT_ID_TICKET) as 'total_problem_user'
//            from MIS.TT_HELPDESK_TICKET
//            where BIT_FLG_DEL = 0 and CHR_NPK = '.$npk.'")->row_array();
//        $total_problem_user = $query['total_problem_user'];
//        return $total_problem_user;
//    }
//
//    function get_helpdesk_ticket_by_all() {
//        $query = $this->db->query("select COUNT(INT_ID_TICKET) as 'total_problem_all'
//            from MIS.TT_HELPDESK_TICKET
//            where BIT_FLG_DEL = 0")->row_array();
//        $total_problem_all = $query['total_problem_all'];
//        return $total_problem_all;
//    }

    function get_helpdesk_ticket_by_status($status) {
        if ($status == 12) {
            return $this->db->query("select a.INT_ID_TICKET,a.CHR_NPK, a.CHR_DUE_DATE,a.INT_PRIORITY,a.INT_STATUS, b.CHR_PROBLEM_TYPE,
                                b.CHR_PROBLEM_TYPE_DESC, a.CHR_PROBLEM_TITLE, a.CHR_PROBLEM_DESC,a.CHR_ASSET_NAME,a.CHR_FINISH_DATE, 
                                a.CHR_CREATE_DATE, a.CHR_CREATE_TIME,c.CHR_USERNAME,d.CHR_PROVER,d.CHR_PROVER_DESC, e.CHR_DEPT
                                from MIS.TT_HELPDESK_TICKET a, MIS.TM_HELPDESK_PROBLEM_TYPE b, TM_USER c, MIS.TM_HELPDESK_PROVER d, TM_DEPT e
                                where a.CHR_NPK = c.CHR_NPK and a.INT_ID_PROVER =d.INT_ID_PROVER and a.INT_ID_DEPT =e.INT_ID_DEPT and 
                                a.INT_ID_PROBLEM_TYPE =b.INT_ID_PROBLEM_TYPE and a.BIT_FLG_DEL = 0 
                                ORDER BY a.INT_PRIORITY ASC, a.CHR_CREATE_DATE DESC")->result();
        }
        return $this->db->query("select a.INT_ID_TICKET,a.CHR_NPK, a.CHR_DUE_DATE,a.INT_PRIORITY,a.INT_STATUS, b.CHR_PROBLEM_TYPE,
                                b.CHR_PROBLEM_TYPE_DESC, a.CHR_PROBLEM_TITLE, a.CHR_PROBLEM_DESC,a.CHR_ASSET_NAME,a.CHR_FINISH_DATE, 
                                a.CHR_CREATE_DATE, a.CHR_CREATE_TIME,c.CHR_USERNAME,d.CHR_PROVER,d.CHR_PROVER_DESC, e.CHR_DEPT
                                from MIS.TT_HELPDESK_TICKET a, MIS.TM_HELPDESK_PROBLEM_TYPE b, TM_USER c, MIS.TM_HELPDESK_PROVER d, TM_DEPT e
                                where a.CHR_NPK = c.CHR_NPK and a.INT_ID_PROVER =d.INT_ID_PROVER and a.INT_ID_DEPT =e.INT_ID_DEPT and 
                                a.INT_ID_PROBLEM_TYPE =b.INT_ID_PROBLEM_TYPE and a.BIT_FLG_DEL = 0 and a.INT_STATUS= $status
                                ORDER BY a.INT_PRIORITY ASC, a.CHR_CREATE_DATE DESC")->result();
    }

    function get_helpdesk_ticket_by_status_and_npk($status, $npk) {
        if ($status == 12) {
            return $this->db->query("select a.INT_ID_TICKET,a.CHR_DUE_DATE,a.INT_PRIORITY,a.INT_STATUS, b.CHR_PROBLEM_TYPE,
                                b.CHR_PROBLEM_TYPE_DESC, a.CHR_PROBLEM_TITLE, a.CHR_PROBLEM_DESC,a.CHR_ASSET_NAME,a.CHR_FINISH_DATE, 
                                a.CHR_CREATE_DATE, a.CHR_CREATE_TIME,c.CHR_USERNAME,d.CHR_PROVER,d.CHR_PROVER_DESC, e.CHR_DEPT
                                from MIS.TT_HELPDESK_TICKET a, MIS.TM_HELPDESK_PROBLEM_TYPE b, TM_USER c, MIS.TM_HELPDESK_PROVER d, TM_DEPT e
                                where a.CHR_NPK = c.CHR_NPK and a.INT_ID_PROVER =d.INT_ID_PROVER and a.INT_ID_DEPT =e.INT_ID_DEPT and 
                                a.INT_ID_PROBLEM_TYPE =b.INT_ID_PROBLEM_TYPE and a.BIT_FLG_DEL = 0 
                                ORDER BY a.INT_PRIORITY ASC, a.CHR_CREATE_DATE DESC")->result();
        }
        return $this->db->query("select a.INT_ID_TICKET,a.CHR_DUE_DATE,a.INT_PRIORITY,a.INT_STATUS, b.CHR_PROBLEM_TYPE,
                                b.CHR_PROBLEM_TYPE_DESC, a.CHR_PROBLEM_TITLE, a.CHR_PROBLEM_DESC,a.CHR_ASSET_NAME,a.CHR_FINISH_DATE, 
                                a.CHR_CREATE_DATE, a.CHR_CREATE_TIME,c.CHR_USERNAME,d.CHR_PROVER,d.CHR_PROVER_DESC, e.CHR_DEPT
                                from MIS.TT_HELPDESK_TICKET a, MIS.TM_HELPDESK_PROBLEM_TYPE b, TM_USER c, MIS.TM_HELPDESK_PROVER d, TM_DEPT e
                                where a.CHR_NPK = c.CHR_NPK and a.INT_ID_PROVER =d.INT_ID_PROVER and a.INT_ID_DEPT =e.INT_ID_DEPT and 
                                a.INT_ID_PROBLEM_TYPE =b.INT_ID_PROBLEM_TYPE and a.BIT_FLG_DEL = 0 and a.INT_STATUS= $status
                                ORDER BY a.INT_PRIORITY ASC, a.CHR_CREATE_DATE DESC")->result();
    }

    function get_helpdesk_ticket_by_sort($sort, $status) {
        return $this->db->query("select a.INT_ID_TICKET,a.CHR_DUE_DATE,a.INT_PRIORITY,a.INT_STATUS, b.CHR_PROBLEM_TYPE,a.INT_ID_PROBLEM_TYPE,
                                b.CHR_PROBLEM_TYPE_DESC, a.CHR_PROBLEM_TITLE,a.CHR_ASSET_NAME,a.CHR_FINISH_DATE, 
                                a.CHR_CREATE_DATE, a.CHR_CREATE_TIME,c.CHR_USERNAME,d.CHR_PROVER, e.CHR_DEPT
                                from MIS.TT_HELPDESK_TICKET a, MIS.TM_HELPDESK_PROBLEM_TYPE b, TM_USER c, MIS.TM_HELPDESK_PROVER d, TM_DEPT e
                                where a.CHR_NPK = c.CHR_NPK and a.INT_ID_PROVER =d.INT_ID_PROVER and a.INT_ID_DEPT =e.INT_ID_DEPT and 
                                a.INT_ID_PROBLEM_TYPE =b.INT_ID_PROBLEM_TYPE and a.BIT_FLG_DEL = 0 and a.INT_STATUS= $status and a.INT_ID_PROBLEM_TYPE=$sort ")->result();
    }

    function get_helpdesk_ticket_by_type($type) {
        return $this->db->query("select a.INT_ID_TICKET,a.CHR_DUE_DATE,a.INT_PRIORITY,a.INT_STATUS, b.CHR_PROBLEM_TYPE,
                                b.CHR_PROBLEM_TYPE_DESC, a.CHR_PROBLEM_TITLE,a.CHR_ASSET_NAME,a.CHR_FINISH_DATE, 
                                a.CHR_CREATE_DATE, a.CHR_CREATE_TIME,c.CHR_USERNAME,d.CHR_PROVER, e.CHR_DEPT
                                from MIS.TT_HELPDESK_TICKET a, MIS.TM_HELPDESK_PROBLEM_TYPE b, TM_USER c, MIS.TM_HELPDESK_PROVER d, TM_DEPT e
                                where a.CHR_NPK = c.CHR_NPK and a.INT_ID_PROVER =d.INT_ID_PROVER and a.INT_ID_DEPT =e.INT_ID_DEPT and 
                                a.INT_ID_PROBLEM_TYPE =b.INT_ID_PROBLEM_TYPE and a.BIT_FLG_DEL = 0 and a.INT_ID_PROBLEM_TYPE=$type ")->result();
    }

    function get_helpdesk_ticket_by_status_on_staff($status, $npk) {
        return $this->db->query("select a.INT_ID_TICKET,a.CHR_DUE_DATE,a.INT_PRIORITY,a.INT_STATUS, b.CHR_PROBLEM_TYPE,b.CHR_PROBLEM_TYPE_DESC, a.CHR_PROBLEM_TITLE,
                                a.CHR_FINISH_DATE, a.CHR_CREATE_DATE,a.CHR_ASSET_NAME, a.CHR_CREATE_TIME,c.CHR_USERNAME,d.CHR_PROVER
                                from MIS.TT_HELPDESK_TICKET a, MIS.TM_HELPDESK_PROBLEM_TYPE b, TM_USER c, MIS.TM_HELPDESK_PROVER d
                                where a.CHR_NPK = c.CHR_NPK and a.INT_ID_PROVER =d.INT_ID_PROVER 
                                and a.INT_ID_PROBLEM_TYPE =b.INT_ID_PROBLEM_TYPE and a.BIT_FLG_DEL = 0 and a.INT_STATUS=$status and a.CHR_NPK=$npk order by a.CHR_CREATE_DATE desc")->result();
    }

    function get_num_to_approve($dept) {
        return $this->db->query("select COUNT(INT_ID_TICKET) as num
                                from MIS.TT_HELPDESK_TICKET
                                where INT_ID_DEPT=$dept and BIT_FLG_DEL=0 and INT_STATUS=0")->row()->num;
    }

    function get_helpdesk_ticket_by_id_dept($id_dept) {
        return $this->db->query("select a.INT_ID_TICKET,a.CHR_DUE_DATE,a.INT_PRIORITY, a.CHR_FINISH_DATE,a.INT_STATUS, d.CHR_PROVER_DESC, b.CHR_PROBLEM_TYPE, 
                                        b.CHR_PROBLEM_TYPE_DESC, a.CHR_PROBLEM_TITLE, a.CHR_CREATE_DATE,a.INT_STATUS, a.CHR_CREATE_TIME,
                                        c.CHR_USERNAME,d.CHR_PROVER, e.CHR_DEPT, a.CHR_ASSET_NAME, a.CHR_PROBLEM_DESC
                                 from MIS.TT_HELPDESK_TICKET a 
                                         INNER JOIN MIS.TM_HELPDESK_PROBLEM_TYPE b ON a.INT_ID_PROBLEM_TYPE = b.INT_ID_PROBLEM_TYPE
                                         INNER JOIN TM_USER c ON a.CHR_NPK = c.CHR_NPK 
                                         INNER JOIN MIS.TM_HELPDESK_PROVER d ON a.INT_ID_PROVER =d.INT_ID_PROVER
                                         LEFT JOIN TM_DEPT e ON a.INT_ID_DEPT =e.INT_ID_DEPT 
                                 where a.BIT_FLG_DEL = 0 --AND a.INT_ID_DEPT=$id_dept 
                                 ORDER BY a.INT_PRIORITY ASC, a.CHR_CREATE_DATE DESC")->result();
    }

    function save_helpdesk_ticket($data) {
        $this->db->insert($this->tabel, $data);
    }

    function get_data_helpdesk_ticket($id_ticket) {
        $query = $this->db->query("select a.INT_ID_TICKET,a.CHR_DUE_DATE, a.CHR_FIX_DATE, b.CHR_PROBLEM_TYPE_DESC,b.CHR_PROBLEM_TYPE, 
            a.CHR_PROBLEM_TITLE,a.CHR_PROBLEM_DESC, a.INT_PRIORITY, a.CHR_CREATE_DATE, a.CHR_CREATE_TIME, c.CHR_USERNAME,d.CHR_PROVER,d.CHR_PROVER_DESC, e.CHR_DEPT, e.CHR_DEPT_DESC,
            a.INT_STATUS, a.CHR_NPK, a.DEC_COST_SOLVE, a.CHR_DUE_DATE,a.CHR_ASSET_NAME,a.CHR_REJECT_DESC, b.INT_ID_PROBLEM_TYPE,
            CASE a.INT_APPROVE WHEN '0' THEN 'Not Approve' ELSE 'Approve' END as INT_APPROVE,a.CHR_DUE_DATE, a.CHR_CREATE_DATE, a.CHR_FINISH_DATE,
            CASE a.INT_PRIORITY WHEN 3 THEN 'Normal' WHEN 2 THEN 'Important' ELSE 'Urgent' END AS INT_PRIORITY,
            CASE a.INT_STATUS WHEN '0' 
            THEN 'Wait Approve' WHEN '1' 
            THEN 'Not Started' WHEN '2' 
            THEN 'On Progress' WHEN '3' 
            THEN 'Done' ELSE 'Reject' 
            END as CHR_STATUS, 
            a.CHR_IMAGE_URL,
            a.INT_PRIORITY AS CHR_PRIORITY
            from MIS.TT_HELPDESK_TICKET a, MIS.TM_HELPDESK_PROBLEM_TYPE b, TM_USER c, MIS.TM_HELPDESK_PROVER d, TM_DEPT e
            where a.CHR_NPK = c.CHR_NPK and a.INT_ID_PROVER =d.INT_ID_PROVER and a.INT_ID_DEPT =e.INT_ID_DEPT 
            and a.INT_ID_PROBLEM_TYPE =b.INT_ID_PROBLEM_TYPE and a.BIT_FLG_DEL = 0 and a.INT_ID_TICKET = '$id_ticket'
            ORDER BY a.INT_PRIORITY ASC, a.CHR_CREATE_DATE DESC");
        return $query;
    }

    function get_fifo() {
        return $this->db->query("select min(INT_ID_TICKET) as INT_ID_TICKET
                                from MIS.TT_HELPDESK_TICKET
                                where BIT_FLG_DEL=0 and (INT_STATUS=0 or INT_STATUS=2)")->row()->INT_ID_TICKET;
    }

    //haps
    function get_ticket_for_edit($id_ticket) {
        return $this->db->query("select a.INT_ID_TICKET, a.CHR_PROBLEM_TITLE, a.CHR_PROBLEM_DESC, d.INT_ID_PROVER, b.INT_ID_PROBLEM_TYPE,
                                a.CHR_ASSET_NAME, a.INT_PRIORITY, a.CHR_SOLVED_DESC, a.INT_STATUS
                                from MIS.TT_HELPDESK_TICKET a, MIS.TM_HELPDESK_PROBLEM_TYPE b, MIS.TM_HELPDESK_PROVER d
                                where a.INT_ID_PROBLEM_TYPE=b.INT_ID_PROBLEM_TYPE and d.INT_ID_PROVER=a.INT_ID_PROVER
                                and a.BIT_FLG_DEL = 0 and a.INT_ID_TICKET =$id_ticket")->row();
    }

    function delete_helpdesk_ticket($id_ticket) {
        $data = array('BIT_FLG_DEL' => 1,
        );

        $this->db->where('INT_ID_TICKET', $id_ticket);
        $this->db->update($this->tabel, $data);
    }

    function update_helpdesk_ticket($data, $id_ticket) {
        $this->db->where('INT_ID_TICKET', $id_ticket);
        $this->db->update($this->tabel, $data);
    }

    function check_id_helpdesk_ticket($id_ticket) {
        $find_id = $this->db->query("select CHR_PROBLEM_TITLE from MIS.TT_HELPDESK_TICKET where CHR_PROBLEM_TITLE = '" . $id_ticket . "'");
        if ($find_id->num_rows() > 0) {
            return $find_id->result();
        }
        return false;
    }

    function generate_id_helpdesk_ticket() {
        return $this->db->query('select max(INT_ID_TICKET) as a from MIS.TT_HELPDESK_TICKET')->row()->a + 1;
    }

    //bisa di hapus
    function is_not_editable_ticket($id_ticket) {
        $x = $this->db->query("select INT_STATUS as st from MIS.TT_HELPDESK_TICKET where INT_ID_TICKET=$id_ticket")->row();
        if ($x->st > 0) {
            return TRUE;
        } else {
            return false;
        }
    }

    function close_ticket($id) {
        $data = array(
            'INT_STATUS' => 3,
            'CHR_FIX_DATE' => date('Ymd'),
            'CHR_FIX_TIME' => date('His'),
            'CHR_FINISH_DATE' => date('Ymd')
        );
        $this->db->where('INT_ID_TICKET', $id);
        $this->db->update($this->tabel, $data);
    }

    function not_close_ticket($id) {
        $data = array(
            'INT_STATUS' => 4
        );
        $this->db->where('INT_ID_TICKET', $id);
        $this->db->update($this->tabel, $data);
    }
    
    function feedback_ticket($id) {
        $data = array(
            'INT_STATUS' => 2
        );
        $this->db->where('INT_ID_TICKET', $id);
        $this->db->update($this->tabel, $data);
    }

}
