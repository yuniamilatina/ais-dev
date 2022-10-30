<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Scan_Barcode extends CI_Controller {

    public function transaksi_who_wip($barcode = null) {
        $dbcoba = $this->load->database('mssql', TRUE);
        $input = $this->input->post('barcode');
        $input2 = $this->input->post('qtybox');

        if ($this->input->post('qtybox')) {
            $barcode = $this->input->post('barcode');
            $jmlbox = $this->input->post('jmlbox');
            $jmlbarcode = strlen($barcode);
            $barcode_scan = explode(" ", $barcode);

            if ($barcode == '') {
                //continue;
            }
            $kanban_barcode = $barcode;
            $kanban_barcode = str_replace("         ", " ", $kanban_barcode);
            $kanban_barcode = str_replace("        ", " ", $kanban_barcode);
            $kanban_barcode = str_replace("       ", " ", $kanban_barcode);
            $kanban_barcode = str_replace("      ", " ", $kanban_barcode);
            $kanban_barcode = str_replace("     ", " ", $kanban_barcode);
            $kanban_barcode = str_replace("    ", " ", $kanban_barcode);
            $kanban_barcode = str_replace("   ", " ", $kanban_barcode);
            $kanban_barcode = str_replace("  ", " ", $kanban_barcode);

            $kanban_barcode_array = explode(" ", $kanban_barcode);
            if (count($kanban_barcode_array)) {
                if (count($kanban_barcode_array) == 5) {
                    $pno = trim($kanban_barcode_array[3]);
                    $bna = trim($kanban_barcode_array[4]);
                    $qtybox = trim($kanban_barcode_array[3]);
                } elseif (count($kanban_barcode_array) == 4) {
                    $pno = trim($kanban_barcode_array[1]);
                    $bna = trim($kanban_barcode_array[4]);
                    $qtybox = trim($kanban_barcode_array[3]);
                } elseif (count($kanban_barcode_array) == 6) {
                    $pno = trim($kanban_barcode_array[3]);
                    $bna = trim($kanban_barcode_array[4]);
                    $qtybox = trim($kanban_barcode_array[6]);
                } elseif ($jmlbarcode > 60) {
                    $pno = substr($barcode, 17, 18);
                    $bna = substr($barcode, 99, 4);
                    $qtybox = substr($barcode, 93, 6);
                }

                $this->db->query("INSERT INTO TT_RM (no, pno, pna, bna, qty, jml) VALUES ('1','$pno', 'material', '$bna', '$qtybox', '$jmlbox')")->result();
            }
        }
    }

}

//<!--<tbody>
//<?php $no = 1;
//foreach ($t_data as $tdata)
//ini dihapus tanggal 21-12-2016



/*elseif ($barcode == 'FINISH') {
$bldat = date("Y-m-d");
$bltim = time("H:i:s");
$ipf = $_SERVER['SERVER_ADDR'];
$parts = $this->tranrmwho_m->findBySql("INSERT INTO TT_GOODS_MOVEMENT_H SELECT * FROM VT_GOODS_MOVEMENT_H "); */


$pno = trim($barcode_scan[3]);
$bna = trim($barcode_scan[4]);
$qtybox = trim($barcode_scan[3]);
$type = 'E';
