<?php

class testcurl_c extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('aorta/overtime_m');
    }

    function index($period = null, $dept = null, $section = null, $msg = NULL)
    {
        $nospkl = "2022100158";
        $data_detail = $this->overtime_m->get_data_overtime_by_no_spkl($nospkl);
        $data = "";
        $i = 1;
        $tot_saldo = 0;
        $tot_plan = 0;
        $tot_real = 0;
        foreach ($data_detail as $isi) {
            $tot_saldo = $tot_saldo + $isi->SISAPLAN;
            $tot_plan = $tot_plan + ((float) $isi->RENC_DURASI_OV_TIME / 60);
            $tot_real = $tot_real + ((float) $isi->REAL_DURASI_OV_TIME / 60);
            $data .= "<tr class='gradeX'>";
            $data .= "<td>$i</td>";
            $data .= "<td style='vertical-align: middle;text-align:left'>" . $isi->TGL_OVERTIME . "</td>";
            $data .= "<td style='vertical-align: middle;text-align:center'><strong>" . $isi->NPK . "</strong></td>";
            $data .= "<td style='vertical-align: middle;text-align:left'><strong>" . $isi->NAMA . "</strong></td>";
            $data .= "<td style='vertical-align: middle;text-align:center'>" . $isi->KD_SUB_SECTION . "</td>";
            $data .= "<td style='vertical-align: middle;text-align:center'>" . $isi->QUOTA_STD . "</td>";
            $data .= "<td style='vertical-align: middle;text-align:center'>" . $isi->QUOTAPLAN . "</td>";
            $data .= "<td style='vertical-align: middle;text-align:center'>" . number_format($isi->TERPAKAIPLAN, 2, ',', '.') . "</td>";
            $data .= "<td style='vertical-align: middle;text-align:center'><strong>" . number_format($isi->SISAPLAN, 2, ',', '.') . "</strong></td>";
            $data .= "<td style='vertical-align: middle;text-align:center'>" . substr($isi->RENC_MULAI_OV_TIME, 0, 2) . ":" . substr($isi->RENC_MULAI_OV_TIME, 2, 2) . "</td>";
            $data .= "<td style='vertical-align: middle;text-align:center'>" . substr($isi->RENC_SELESAI_OV_TIME, 0, 2) . ":" . substr($isi->RENC_SELESAI_OV_TIME, 2, 2) . "</td>";
            $data .= "<td style='vertical-align: middle;text-align:center'><strong>" . number_format((float) $isi->RENC_DURASI_OV_TIME / 60, 2, ',', '.') . "</strong></td>";
            $data .= "<td style='vertical-align: middle;text-align:center'>" . substr($isi->REAL_MULAI_OV_TIME, 0, 2) . ":" . substr($isi->REAL_MULAI_OV_TIME, 2, 2) . "</td>";
            $data .= "<td style='vertical-align: middle;text-align:center'>" . substr($isi->REAL_SELESAI_OV_TIME, 0, 2) . ":" . substr($isi->REAL_SELESAI_OV_TIME, 2, 2) . "</td>";
            $data .= "<td style='vertical-align: middle;text-align:center'><strong>" . number_format((float) $isi->REAL_DURASI_OV_TIME / 60, 2, ',', '.') . "</strong></td>";
            $data .= "<td style='vertical-align: middle;text-align:center'>$isi->NPK_PIC</td>";
            $data .= "<td style='vertical-align: middle;text-align:center'>-</td>";
            $data .= "</tr>";

            $i++;
        }

        $data .= "<tr>";
        $data .= "<td colspan='8' align='center'><strong>TOTAL</strong></td>";
        $data .= "<td style='vertical-align: middle;text-align:center'><strong>" . number_format($tot_saldo, 2, ',', '.') . "</strong></td>";
        $data .= "<td colspan='2'></td>";
        $data .= "<td style='vertical-align: middle;text-align:center'><strong>" . number_format($tot_plan, 2, ',', '.') . "</strong></td>";
        $data .= "<td colspan='2'></td>";
        $data .= "<td style='vertical-align: middle;text-align:center'><strong>" . number_format($tot_real, 2, ',', '.') . "</strong></td>";
        $data .= "<td colspan='2'></td>";
        $data .= "</tr>";

        echo $data;

    //     msgSend = "Terdapat request OT sbb : \n \n "
    //     msgSend = msgSend + "*###### SPKL : " + obj.ot + " ######*\n\n"

    //     obj.data.forEach(arrData => {
    //         msgSend = msgSend + arrData.npk + " - " + arrData.nama + " - " + arrData.oth + "\n"
    //       });


        $message = "Terdapat request OT sbb : \n \n ";
        $message = $message . "*#### SPKL : " . $nospkl . " ####*\n\n";

        foreach ($data_detail as $isi) {
            $message = $message . trim($isi->NPK) . " - " . substr(trim($isi->NAMA),0,15) . " - " . number_format((float) $isi->REAL_DURASI_OV_TIME / 60, 2, ',', '.')."h\n";
        }

        /* Endpoint */
        $url = 'http://172.16.31.157:8080/';
        
        /* eCurl */
        $curl = curl_init($url);

        $to = "6285959169470@c.us";

        /* Data */
        $data = array( 'to'=>$to,  'message'=> $message);

        /* Set JSON data to POST */
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
            
        /* Define content type */
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
            
        /* Return json */
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            
        /* make request */
        $result = curl_exec($curl);

        echo $result;

        /* close curl */
        curl_close($curl);


    }

}
?>
