<?php

class invoice_m extends CI_Model {

    private $table = 'FINANCESOFT_TT_AP';
    private $table_ap = 'FINANCESOFT_TT_AP';
    private $table_user = 'FINANCESOFT_TT_OPERATOR';
    private $table_supplier = 'FINANCESOFT_TM_SUPPLIER';

    public function get_all_sup() {
        $db_1 = $this->load->database('financesoft', TRUE);

        $db_1->select('KODESUP,TGLENTRY');
        $db_1->from('FINANCESOFT_TM_SUPPLIER');
        $query = $db_1->get()->result();
        return $query;
    }
    
    public function find_supp() {
        $db_1 = $this->load->database('financesoft', TRUE);
        
        $db_1->select('DISTINCT KODESUP_SAP');
        $db_1->from('FINANCESOFT_TM_SUPPLIER');
        $db_1->where('KODESUP_SAP <> ', '');
        $db_1->where('KODESUP_SAP_PASS = "" ');
        $query = $db_1->get()->result();
        return $query;
    }
    
    public function find_supp_pass() {
        $db_1 = $this->load->database('financesoft', TRUE);
        
        $db_1->select('DISTINCT KODESUP_SAP, KODESUP_SAP_PASS');
        $db_1->from('FINANCESOFT_TM_SUPPLIER');
        $db_1->where('KODESUP_SAP <> ', '');
        $query = $db_1->get()->result();
        return $query;
    }
    
    public function update_supp_pass($data,$kode_sup_sap) {
        $db_1 = $this->load->database('financesoft', TRUE);

        $db_1->where('KODESUP_SAP', $kode_sup_sap);
        $db_1->update($this->table_supplier, $data);
    }

    public function set_pass_to_all($kodesup, $data) {
        $db_1 = $this->load->database('financesoft', TRUE);
        
        $db_1->where('KODESUP', $kodesup);
        $db_1->update('FINANCESOFT_TM_SUPPLIER', $data);
    }

    public function view_invoices() {
        $db_1 = $this->load->database('financesoft', TRUE);
        
        $user_session = $this->session->all_userdata();
        $z = 0;
        $db_1->select('FINANCESOFT_TT_AP.INVNO,
            FINANCESOFT_TT_AP.APNO,
            FINANCESOFT_TT_AP.PO_NO,
            FINANCESOFT_TT_AP.TGLINV,
            FINANCESOFT_TT_AP.TGLTRM,
            FINANCESOFT_TT_AP.TGLJTTEMPO,
            FINANCESOFT_TT_AP.AMOUNT,
            FINANCESOFT_TT_AP.TGLBAYAR,
            FINANCESOFT_TT_AP.KET,
            FINANCESOFT_TT_AP.BAYAR');
        $db_1->where('FINANCESOFT_TT_AP.KODESUP_SAP', $user_session['KODESUP_SAP']);
        $db_1->where('FINANCESOFT_TT_AP.FLG_DELETE', $z);
        $db_1->from('FINANCESOFT_TT_AP');
        //$db_1->join('FINANCESOFT_TM_SUPPLIER', 'FINANCESOFT_TT_AP.KODESUP = FINANCESOFT_TM_SUPPLIER.KODESUP');
        $db_1->order_by('FINANCESOFT_TT_AP.APNO', 'desc');
        $query = $db_1->get();
        return $query->result();
        // $data = $query->result_array(FINANCESOFT_TT_AP);
    }

    public function get_pdf_download($apno) {
        $db_1 = $this->load->database('financesoft', TRUE);

        $db_1->select('PDF_DOWNLOAD');
        $db_1->where('APNO', $apno);
        $db_1->from('FINANCESOFT_TT_AP');
        $query = $db_1->get();
        return $query->row();
        // $data = $query->result_array(FINANCESOFT_TT_AP);
    }

    public function view_top_invoices() {
        $db_1 = $this->load->database('financesoft', TRUE);

        $user_session = $this->session->all_userdata();
        $z = 0;
        $db_1->limit(7);
        $db_1->select('FINANCESOFT_TT_AP.INVNO,
            FINANCESOFT_TT_AP.APNO,
            FINANCESOFT_TT_AP.PO_NO,
            FINANCESOFT_TT_AP.TGLINV,
            FINANCESOFT_TT_AP.TGLTRM,
            FINANCESOFT_TT_AP.TGLJTTEMPO,
            FINANCESOFT_TT_AP.AMOUNT,
            FINANCESOFT_TT_AP.TGLBAYAR,
            FINANCESOFT_TT_AP.KET,
                FINANCESOFT_TT_AP.BAYAR');
        $db_1->where('FINANCESOFT_TT_AP.KODESUP_SAP', $user_session['KODESUP_SAP']);
        $db_1->where('FINANCESOFT_TT_AP.FLG_DELETE', $z);
        $db_1->from('FINANCESOFT_TT_AP');
        //$db_1->join('FINANCESOFT_TM_SUPPLIER', 'FINANCESOFT_TT_AP.KODESUP_SAP = FINANCESOFT_TM_SUPPLIER.KODESUP_SAP');
        $db_1->order_by('FINANCESOFT_TT_AP.APNO', 'desc');
        $query = $db_1->get();

		//echo $user_session['KODESUP_SAP'];
		//exit();
        return $query->result();
        // $data = $query->result_array(FINANCESOFT_TT_AP);
    }

    public function view_new_invoices() {
        $db_1 = $this->load->database('financesoft', TRUE);

        $user_session = $this->session->all_userdata();
        $kodesup = $user_session['KODESUP_SAP'];
        $query = $db_1->query("SELECT FINANCESOFT_TT_AP.APNO, FINANCESOFT_TT_AP.INVNO, FINANCESOFT_TT_AP.PO_NO, FINANCESOFT_TT_AP.TGLINV, 
                      FINANCESOFT_TT_AP.TGLTRM, FINANCESOFT_TT_AP.TGLBAYAR, FINANCESOFT_TT_AP.TGLJTTEMPO, FINANCESOFT_TT_AP.KODESUP, 
                      FINANCESOFT_TT_AP.AMOUNT, FINANCESOFT_TT_AP.KD_CURRENCY, FINANCESOFT_TT_AP.KET, FINANCESOFT_TT_AP.BAYAR
FROM         FINANCESOFT_TT_AP 
WHERE     (FINANCESOFT_TT_AP.KODESUP_SAP = '$kodesup') AND (FINANCESOFT_TT_AP.TGLTRM IS NULL) AND 
                      (FINANCESOFT_TT_AP.FLG_DELETE = '0')
ORDER BY FINANCESOFT_TT_AP.APNO DESC")->result();
        return $query;
    }

    public function view_accepted_invoices() {
        $db_1 = $this->load->database('financesoft', TRUE);


        $now = date('Ymd');
        $user_session = $this->session->all_userdata();
        $kodesup = $user_session['KODESUP_SAP'];
        $query = $db_1->query("SELECT   FINANCESOFT_TT_AP.APNO, FINANCESOFT_TT_AP.INVNO, FINANCESOFT_TT_AP.PO_NO, FINANCESOFT_TT_AP.TGLINV, 
                      FINANCESOFT_TT_AP.TGLTRM, FINANCESOFT_TT_AP.TGLBAYAR, FINANCESOFT_TT_AP.TGLJTTEMPO, FINANCESOFT_TT_AP.KODESUP, 
                      FINANCESOFT_TT_AP.AMOUNT, FINANCESOFT_TT_AP.KD_CURRENCY, FINANCESOFT_TT_AP.KET, FINANCESOFT_TT_AP.BAYAR
FROM         FINANCESOFT_TT_AP 
WHERE     (FINANCESOFT_TT_AP.KODESUP_SAP = '$kodesup') AND (FINANCESOFT_TT_AP.TGLTRM != '') AND (FINANCESOFT_TT_AP.FLG_DELETE = '0') 
                      AND (FINANCESOFT_TT_AP.BAYAR = 'N') AND (FINANCESOFT_TT_AP.TGLJTTEMPO >= $now)
                     
ORDER BY FINANCESOFT_TT_AP.APNO DESC")->result();
        return $query;
    }

    public function view_accepted_invoices_unpaid() {
        $db_1 = $this->load->database('financesoft', TRUE);

        $user_session = $this->session->all_userdata();

        $now = date('Ymd');
        $kodesup = $user_session['KODESUP_SAP'];
        $query = $db_1->query("SELECT   FINANCESOFT_TT_AP.APNO, FINANCESOFT_TT_AP.INVNO, FINANCESOFT_TT_AP.PO_NO, FINANCESOFT_TT_AP.TGLINV, 
                      FINANCESOFT_TT_AP.TGLTRM, FINANCESOFT_TT_AP.TGLBAYAR, FINANCESOFT_TT_AP.TGLJTTEMPO, FINANCESOFT_TT_AP.KODESUP, 
                      FINANCESOFT_TT_AP.AMOUNT, FINANCESOFT_TT_AP.KD_CURRENCY, FINANCESOFT_TT_AP.KET, FINANCESOFT_TT_AP.BAYAR
FROM         FINANCESOFT_TT_AP 
WHERE     (FINANCESOFT_TT_AP.KODESUP_SAP = '$kodesup') AND (FINANCESOFT_TT_AP.TGLTRM != '') AND (FINANCESOFT_TT_AP.FLG_DELETE = '0') 
                      AND (FINANCESOFT_TT_AP.BAYAR = 'N') AND (FINANCESOFT_TT_AP.TGLJTTEMPO < $now)
                      
ORDER BY FINANCESOFT_TT_AP.APNO DESC")->result();
        return $query;
    }

    public function view_paid_invoices() {
        $db_1 = $this->load->database('financesoft', TRUE);

        $user_session = $this->session->all_userdata();
        $kodesup = $user_session['KODESUP_SAP'];
        $query = $db_1->query("SELECT   FINANCESOFT_TT_AP.APNO, FINANCESOFT_TT_AP.INVNO, FINANCESOFT_TT_AP.PO_NO, FINANCESOFT_TT_AP.TGLINV, 
                      FINANCESOFT_TT_AP.TGLTRM,FINANCESOFT_TT_AP.TGLBAYAR, FINANCESOFT_TT_AP.TGLJTTEMPO, FINANCESOFT_TT_AP.KODESUP, 
                      FINANCESOFT_TT_AP.AMOUNT, FINANCESOFT_TT_AP.KD_CURRENCY, FINANCESOFT_TT_AP.KET, FINANCESOFT_TT_AP.BAYAR
FROM         FINANCESOFT_TT_AP 
WHERE     (FINANCESOFT_TT_AP.KODESUP_SAP = '$kodesup') AND (FINANCESOFT_TT_AP.FLG_DELETE = '0') AND 
                      (FINANCESOFT_TT_AP.BAYAR = 'Y') 
ORDER BY FINANCESOFT_TT_AP.APNO DESC")->result();
        return $query;
    }

    public function save($data) {
        $db_1 = $this->load->database('financesoft', TRUE);

        $db_1->insert($this->table, $data);
    }

    public function get_data($APNO, $year) {
        $db_1 = $this->load->database('financesoft', TRUE);

        $db_1->where('APNO', $APNO);
        $db_1->where('right(left(TGLENTRY1,4),2) = ', $year);
        return $db_1->get($this->table);
    }

    public function update($data, $apno, $year) {
        $db_1 = $this->load->database('financesoft', TRUE);

        $db_1->where('APNO', $apno);
        $db_1->where('right(left(TGLENTRY1,4),2) = ', $year);
        $db_1->update($this->table, $data);
    }

    public function delete($apno, $year) {
        $db_1 = $this->load->database('financesoft', TRUE);

        $data = array('FLG_DELETE' => 1);
        $db_1->where('APNO', $apno);
        $db_1->where('right(left(TGLENTRY1,4),2) = ', $year);
        $db_1->update($this->table, $data);
    }

    public function get_new_ap_no() {
        $db_1 = $this->load->database('financesoft', TRUE);

        $db_1->select_max('APNO');
        $db_1->order_by('APNO', 'desc');
        return $db_1->get($this->table);
    }

    public function get_currency($mu) {
        $db_1 = $this->load->database('financesoft', TRUE);

        $db_1->where('KODE_CURR', $mu);
        return $db_1->get('FINANCESOFT_TM_CURRENCY');
    }
	
    public function get_dept() {
        $db_1 = $this->load->database('financesoft', TRUE);

        //$db_1->where('KODE_CURR', $mu);
        return $db_1->get('FINANCESOFT_TM_DEPT')->result();
    }
	
    public function get_rate_user($kodesup_sap) {
        $db_1 = $this->load->database('financesoft', TRUE);

        $db_1->where('FLG_DELETE', '0');
		$db_1->where('KODESUP_SAP', $kodesup_sap);
        return $db_1->get('FINANCESOFT_TM_SUPPLIER')->result();
    }
	
    public function get_supp_profile($kodesup_sap,$curr) {
        $db_1 = $this->load->database('financesoft', TRUE);

        $db_1->where('FLG_DELETE', '0');
		$db_1->where('KODESUP_SAP', $kodesup_sap);
		$db_1->where('KODE_CURRENCY', $curr);
        return $db_1->get('FINANCESOFT_TM_SUPPLIER')->result();
    }

    public function get_currency_eng($mu) {
        if ($mu == 'EUR') {
            return 'Euro';
        } elseif ($mu == 'IDR') {
            return 'Indonesian Rupiah';
        } elseif ($mu == 'JPY') {
            return 'Japan Yen';
        } elseif ($mu == 'THB') {
            return 'Thai Baht';
        } elseif ($mu == 'SGD') {
            return 'Singapore Dollar';
        } elseif ($mu == 'USD') {
            return 'US Dollar';
        }
    }

    public function get_currency_ind($mu) {
        if ($mu == 'EUR') {
            return 'Euro';
        } elseif ($mu == 'IDR') {
            return 'Rupiah';
        } elseif ($mu == 'JPY') {
            return 'Yen';
        } elseif ($mu == 'THB') {
            return 'Baht';
        } elseif ($mu == 'SGD') {
            return 'Dollar Singapore';
        } elseif ($mu == 'USD') {
            return 'Dollar Amerika';
        }
    }

    public function get_count_new_inv($kodesup) {
        $db_1 = $this->load->database('financesoft', TRUE);


        $query = $db_1->query("select count(KODESUP) as 'count' from FINANCESOFT_TT_AP 
            where (KODESUP = '$kodesup' and TGLTRM is NULL and FLG_DELETE = '0')
            ")->row_array();
        $count = $query['count'];
        return $count;
    }

    public function get_count_accepted_inv($kodesup) {
        $db_1 = $this->load->database('financesoft', TRUE);

        $now = date('Ymd');
        $query = $db_1->query("select count(KODESUP) as 'count' from FINANCESOFT_TT_AP 
            where (KODESUP = '$kodesup' and TGLTRM != '' and BAYAR = 'N' and FLG_DELETE = '0' and TGLJTTEMPO >= $now)")->row_array();
        $count = $query['count'];
        return $count;
    }

    public function get_count_accepted_inv_unpaid($kodesup) {
        $db_1 = $this->load->database('financesoft', TRUE);

        $now = date('Ymd');
        $query = $db_1->query("select count(KODESUP) as 'count' from FINANCESOFT_TT_AP 
            where (KODESUP = '$kodesup' and TGLTRM != '' and BAYAR = 'N' and FLG_DELETE = '0' and TGLJTTEMPO < $now)")->row_array();
        $count = $query['count'];
        return $count;
    }

    public function get_count_paid_inv($kodesup) {
        $db_1 = $this->load->database('financesoft', TRUE);

        $query = $db_1->query("select count(KODESUP) as 'count' from FINANCESOFT_TT_AP 
            where (KODESUP = '$kodesup' and BAYAR = 'Y' and FLG_DELETE = '0')")->row_array();
        $count = $query['count'];
        return $count;
    }

    public function get_count_all_inv($kodesup) {
        $db_1 = $this->load->database('financesoft', TRUE);

        $query = $db_1->query("select count(KODESUP) as 'count' from FINANCESOFT_TT_AP 
            where KODESUP = '$kodesup' and FLG_DELETE = '0'")->row_array();
        $count = $query['count'];
        return $count;
    }
    

    public function cashier_view_invoices() {
        $db_1 = $this->load->database('financesoft', TRUE);
        
        $z = 0;
        $db_1->select('FINANCESOFT_TT_AP.INVNO,
            FINANCESOFT_TT_AP.APNO,
            FINANCESOFT_TT_AP.TGLINV,
            FINANCESOFT_TT_AP.TGLTRM,
            FINANCESOFT_TT_AP.TGLJTTEMPO,
            FINANCESOFT_TT_AP.AMOUNT,
            FINANCESOFT_TT_AP.KET');
        $db_1->where('APNO >', '21800');
        $db_1->where('FINANCESOFT_TT_AP.FLG_DELETE', $z);
        $db_1->from('FINANCESOFT_TT_AP');
        $db_1->join('FINANCESOFT_TM_SUPPLIER', 'FINANCESOFT_TT_AP.KODESUP = FINANCESOFT_TM_SUPPLIER.KODESUP');
        $db_1->order_by('FINANCESOFT_TT_AP.APNO', 'desc');
        $query = $db_1->get();
        return $query->result();
        // $data = $query->result_array(FINANCESOFT_TT_AP);
    }

    public function cek_apno($apno, $year) {
        $db_1 = $this->load->database('financesoft', TRUE);
        
        $db_1->where('APNO', $apno);
        $db_1->where('right(left(TGLENTRY1,4),2) = ', $year);
        $query = $db_1->get($this->table_ap);
        if ($query->num_rows == 1) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
	
    public function cek_apno_del($apno, $year) {
        $db_1 = $this->load->database('financesoft', TRUE);
        
        $db_1->where('APNO', $apno);
        $db_1->where('right(left(TGLENTRY1,4),2) = ', $year);
		$db_1->where('FLG_DELETE', '0');
        $query = $db_1->get($this->table_ap);
        if ($query->num_rows == 1) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function cek_apno_empty($apno, $year) {
        $db_1 = $this->load->database('financesoft', TRUE);
        
        $db_1->where('APNO', $apno);
        $db_1->where('right(left(TGLENTRY1,4),2) = ', $year);
        $query = $db_1->get($this->table_ap);
        if ($query->num_rows == 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function get_acc_info($kodesup) {
        $db_1 = $this->load->database('financesoft', TRUE);
        
        $db_1->where('KODESUP', $kodesup);
        return $db_1->get($this->table_supplier)->row();
    }

    public function get_pdf_redownload_cashier($apno,$year) {
        $db_1 = $this->load->database('financesoft', TRUE);
        
        $db_1->select('PDF_REDOWNLOAD_KASIR');
        $db_1->where('APNO', $apno);
        $db_1->where('right(left(TGLENTRY1,4),2) = ', $year);
        return $db_1->get($this->table_ap);
    }

    public function get_data_by_apno($apno, $year){
        
        $db_1 = $this->load->database('financesoft', TRUE);

        $db_1->where('APNO', $apno);
        $db_1->where('right(left(TGLENTRY1,4),2) = ', $year);
        return $db_1->get($this->table_ap);
        
    }
    
}

?>
