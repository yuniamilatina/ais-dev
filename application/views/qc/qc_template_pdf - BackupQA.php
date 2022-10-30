<?php

function get_month($month) {
    switch ($month) {
        case "01":
            $month = "January";
            break;
        case "02":
            $month = "February";
            break;
        case "03":
            $month = "March";
            break;
        case "04":
            $month = "April";
            break;
        case "05":
            $month = "May";
            break;
        case "06":
            $month = "June";
            break;
        case "07":
            $month = "July";
            break;
        case "08":
            $month = "August";
            break;
        case "09":
            $month = "September";
            break;
        case "10":
            $month = "October";
            break;
        case "11":
            $month = "November";
            break;
        case "12":
            $month = "December";
            break;
    }
    return $month;
}

$month_delivery = substr($delivery_date, 3, 2);
$month_delivery = substr(get_month($month_delivery), 0, 3);
$delivery_date = "$month_delivery " . substr($delivery_date, 0, 2) . ", " . substr($delivery_date, 6, 4);

//$month_delivery = substr($date_delivery, 5, 2);
//$month_delivery = get_month($month_delivery);
//$date_delivery = "$month_delivery " . substr($date_delivery, 8, 2) . ", " . substr($date_delivery, 0, 4);
//
//
//$month_issue = substr($issue_date, 5, 2);
//$month_issue = get_month($month_issue);
//$issue_date = "$month_issue " . substr($issue_date, 8, 2) . ", " . substr($issue_date, 0, 4);

$p='
        <style>
            table , th ,tr,td
            {
                /*border: 1.5px solid black;*/
                border-collapse:collapse;
                font-size: 12px;
                /*font-family: "Times New Roman", Georgia, Serif;*/
            }

            td{
                height:20px;
            }

            .border
            {
                border: 1px solid black;
                border-collapse:collapse;
            }
        </style>';

$g='
        <style>
            table , th ,tr,td
            {
                /*border: 1.5px solid black;*/
                border-collapse:collapse;
                font-size: 12px;
                /*font-family: "Times New Roman", Georgia, Serif;*/
            }

            td{
                height:20px;
            }

            .border
            {
                border: 1px solid black;
                border-collapse:collapse;
            }

        </style>';

$r='
        <style>
            table , th ,tr,td
            {
                /*border: 1.5px solid black;*/
                border-collapse:collapse;
                font-size: 12px;
                /*font-family: "Times New Roman", Georgia, Serif;*/
            }

            td{
                height:20px;
            }

            .border
            {
                border: 1px solid black;
                border-collapse:collapse;
            }

        </style>';

$cl='
        <style>
            table , th ,tr,td
            {
                /*border: 1.5px solid black;*/
                border-collapse:collapse;
                font-size: 12px;
                /*font-family: "Times New Roman", Georgia, Serif;*/
            }

            td{
                height:20px;
            }

            .border
            {
                border: 1px solid black;
                border-collapse:collapse;
            }

        </style>';

    // GOODS
    $i = 1;
    $a = 1;
    $total_baris = 0;
    $num_key_konst = 0;
    $limit_const = 16;
        if(count($goods) > 0){
            for ($llist = 1; $llist <= $qc_num; $llist++) {

                $g .='
                    <page>
                    <table class="header_cop" style="font-size: 86px; margin-top:20px">
                            <tr>
                                <td style="width:80px;"> <img src="./assets/img/LogoAisin.png" width="90" height="70"></td>
                            </tr>
                        </table>
                        <table>
                            <tr>
                                <td style="font-size: 18px;font-weight: bold;width:610px;">PT. AISIN INDONESIA</td>
                            </tr>
                        </table>
                        <table>
                                <tr>
                                    <td style="font-size: 26px;font-weight: bold;width:100%; padding-left: 240px; padding-top: 10px; padding-bottom: 5px">STOCK TRANSFER SLIP</td>
                                </tr>
                        </table>
                        <table style="margin-top: 5px;width: 800px;font-weight: bold;" border="">
                            <tr>
                                <td style="width:105px;" id="content">
                                    NO
                                </td>
                                <td style="width:560px;" colspan="3" id="content">
                                    : ST/GD/'.$no.'
                                </td>
                            </tr>
                            <tr>
                                <td style="width:105px;" id="content">
                                    FROM
                                </td>
                                <td style="width:560px;" colspan="3" id="content">
                                    : PP04
                                </td>
                            </tr>

                            <tr>
                                <td style="">
                                    DATE
                                </td>
                                <td>
                                    : '.$delivery_date.'
                                </td>
                            </tr>

                            <tr>
                                <td style="">
                                    MOVEMENT TYPE
                                </td>
                                <td style="" colspan="3">
                                    : '.$mvt.'
                                </td>

                                <td style="">
                                    
                                </td>
                                <td>
                                    
                                </td>
                            </tr>

                            <tr>
                                <td style="">
                                    PAGE
                                </td>
                                <td style="" colspan="3">
                                    : '. $llist . "/" . $qc_num .'
                                </td>

                                <td style="">
                                    
                                </td>
                                <td>
                                    
                                </td>
                            </tr>
                        </table>
                        <table width="700px" cellspacing="0" style="margin-top: 10px;margin-left:0px;text-align: center;" border="1">
                            <tr>
                                <th width="15" align="center">No.</th>
                                <th width="100" align="center">Sloc Tujuan</th>
                                <th width="100" align="center">PARTS No.</th>
                                <th width="300" align="center">PARTS NAME</th>
                                <th width="50" align="center">Qty</th>
                                <th width="80" align="center">Status</th>
                                <th width="80" align="center">UoM</th>
                            </tr>';
                            
                            foreach ($goods as $mat_good => $data){

                                if ($mat_good < $num_key_konst) {
                                    if ($num_key_konst != 0) {
                                        continue;
                                    }
                                } elseif ($mat_good >= $limit_const) {
                                    continue;
                                } else {
                                    $g .='
                                        <tr>
                                            <td width="20" align="center">'.$a.'</td>
                                            <td width="20" align="center">'.$data['sloc_to'].'</td>
                                            <td width="30" align="center">
                                    ';

                                    $partno = trim($data['part_no']);
                                    //$partno = trim('-1234567890abcdef');
                                    $length = strlen($partno);
                                    $bag1   = substr($partno, 0, 6);
                                    $sisa   = (int)$length - 6;
                                    //echo $sisa;
                                    if($sisa <= 5){
                                        $bag2 = substr($partno, 6, $sisa);
                                    }else{
                                        $bag2 = substr($partno, 6, 5);
                                        $sisa = (int)$length - 11;
                                    }
                                    //echo $sisa;
                                    $partsisa = substr($partno, 11, $sisa);
                                    $bag3     = str_split($partsisa, 2);
                                    //echo $partsisa;
                                    if(substr($bag1, 0, 1) == '-'){
                                        $bag1 = str_replace('-', '', $bag1);
                                    }

                                    $partnobaru = $bag1.'-'.$bag2;
                                    //echo $partnobaru;
                                    for($i = 0; $i < sizeof($bag3); $i++){
                                        if($bag3[$i] == ''){
                                            $partnobaru .= $bag3[$i];
                                        }else{
                                            $partnobaru .= '-'.$bag3[$i];
                                        }
                                    }

                                    $g .='  '.$partnobaru.'
                                            </td>
                                            <td width="150" align="center" style="valign:center">'.wordwrap($data['part_name'], 35, "<br>\n").'</td>
                                            <td width="30" align="center">'.$data['qty'].'</td>
                                            <td width="30" align="center" bgcolor="green">Goods</td>
                                            <td width="30" align="center">'.$data['part_uom'].'</td>
                                        </tr>
                                    ';

                                    $i++;
                                    $a++;
                                    $total_baris++;

                                }
                            }

                            $num_key_konst +=16;
                            $limit_const +=16;

                            $g .= '
                                </table>
                                </page>
                            ';

                            if ($qc_num == ($llist + 1)) {
                                $g .= '
                                    <table width="700px" style="margin-top: 20px;margin-left:0px;page-break-after: always;text-align: center;width: 350px;bottom: 0px;" border="">
                                        <tr>
                                            <td colspan="1" style="text-align: left; width: 130px;"><b>DOC HEADER TEXT :</b></td>
                                            <td colspan="4" style="text-align: center;"></td>

                                        </tr>
                                        <tr>
                                            <td width="110" height="50"></td>
                                            <td width="110" height="50"></td>
                                            <td width="110" height="50"></td>
                                            <td width="110" height="50"></td>
                                            <td width="110" height="50"></td>
                                        </tr>
                                        <tr>
                                            <td width="220"></td>
                                            <td width="100"><hr align="center" style="height: 0px; color: #343434">PPIC</td>
                                            <td width="50"></td>
                                            <td width="100"><hr align="center" style="height: 0px; color: #343434">QC</td>
                                        </tr>
                                ';
                            }else{
                                $g .= '
                                    <table width="700px" style="margin-top: 20px;margin-left:0px;page-break-after: always;text-align: center;width: 350px;bottom: 0px;" border="">
                                        <tr>
                                            <td colspan="1" style="text-align: left; width: 130px;"><b>DOC HEADER TEXT :</b></td>
                                            <td colspan="4" style="text-align: center;"></td>

                                        </tr>
                                        <tr>
                                            <td width="110" height="50"></td>
                                            <td width="110" height="50"></td>
                                            <td width="110" height="50"></td>
                                            <td width="110" height="50"></td>
                                            <td width="110" height="50"></td>
                                        </tr>
                                        <tr>
                                            <td width="220"></td>
                                            <td width="100"><hr align="center" style="height: 0px; color: #343434">PPIC</td>
                                            <td width="50"></td>
                                            <td width="100"><hr align="center" style="height: 0px; color: #343434">QC</td>
                                        </tr>
                                ';
                            }

                            $g .= '
                                </table>
                            ';

            }
            $this->kb_pdf->WriteHTML($g);
        }

    // REPAIR
    $i = 1;
    $b = 1;
    $total_baris = 0;
    $num_key_konst = 0;
    $limit_const = 16;
        if(count($repair) > 0){
            for ($llist = 1; $llist <= $qc_num; $llist++) {
                $r .='
                    <page>
                    <table class="header_cop" style="font-size: 86px; margin-top:20px">
                            <tr>
                                <td style="width:80px;"> <img src="./assets/img/LogoAisin.png" width="90" height="70"></td>
                            </tr>
                        </table>
                        <table>
                            <tr>
                                <td style="font-size: 18px;font-weight: bold;width:610px;">PT. AISIN INDONESIA</td>
                            </tr>
                        </table>
                        <table>
                                <tr>
                                    <td style="font-size: 26px;font-weight: bold;width:100%; padding-left: 240px; padding-top: 10px; padding-bottom: 5px">STOCK TRANSFER SLIP</td>
                                </tr>
                        </table>
                        <table style="margin-top: 5px;width: 800px;font-weight: bold;" border="">
                            <tr>
                                <td style="width:105px;" id="content">
                                    NO
                                </td>
                                <td style="width:560px;" colspan="3" id="content">
                                    : ST/RP/'.$no.'
                                </td>
                            </tr>
                            <tr>
                                <td style="width:105px;" id="content">
                                    FROM
                                </td>
                                <td style="width:560px;" colspan="3" id="content">
                                    : PP04
                                </td>
                            </tr>

                            <tr>
                                <td style="">
                                    DATE
                                </td>
                                <td>
                                    : '.$delivery_date.'
                                </td>
                            </tr>

                            <tr>
                                <td style="">
                                    MOVEMENT TYPE
                                </td>
                                <td style="" colspan="3">
                                    : '.$mvt.'
                                </td>

                                <td style="">
                                    
                                </td>
                                <td>
                                    
                                </td>
                            </tr>

                            <tr>
                                <td style="">
                                    PAGE
                                </td>
                                <td style="" colspan="3">
                                    : '. $llist . "/" . $qc_num .'
                                </td>

                                <td style="">
                                    
                                </td>
                                <td>
                                    
                                </td>
                            </tr>
                        </table>
                        <table width="700px" cellspacing="0" style="margin-top: 10px;margin-left:0px;text-align: center;" border="1">
                            <tr>
                                <th width="15" align="center">No.</th>
                                <th width="100" align="center">Sloc Tujuan</th>
                                <th width="100" align="center">PARTS No.</th>
                                <th width="300" align="center">PARTS NAME</th>
                                <th width="50" align="center">Qty</th>
                                <th width="80" align="center">Status</th>
                                <th width="80" align="center">UoM</th>
                            </tr>';
                            
                            foreach ($repair as $mat_good => $data){

                                if ($mat_good < $num_key_konst) {
                                    if ($num_key_konst != 0) {
                                        continue;
                                    }
                                } elseif ($mat_good >= $limit_const) {
                                    continue;
                                } else {
                                    $r .='
                                        <tr>
                                            <td width="20" align="center" >'.$b.'</td>
                                            <td width="20" align="center" style="valign:center">'.$data['sloc_to'].' (B)</td>
                                            <td width="30" align="center">
                                    ';

                                    $partno = trim($data['part_no']);
                                    //$partno = trim('-1234567890abcdef');
                                    $length = strlen($partno);
                                    $bag1   = substr($partno, 0, 6);
                                    $sisa   = (int)$length - 6;
                                    //echo $sisa;
                                    if($sisa <= 5){
                                        $bag2 = substr($partno, 6, $sisa);
                                    }else{
                                        $bag2 = substr($partno, 6, 5);
                                        $sisa = (int)$length - 11;
                                    }
                                    //echo $sisa;
                                    $partsisa = substr($partno, 11, $sisa);
                                    $bag3     = str_split($partsisa, 2);
                                    //echo $partsisa;
                                    if(substr($bag1, 0, 1) == '-'){
                                        $bag1 = str_replace('-', '', $bag1);
                                    }

                                    $partnobaru = $bag1.'-'.$bag2;
                                    //echo $partnobaru;
                                    for($i = 0; $i < sizeof($bag3); $i++){
                                        if($bag3[$i] == ''){
                                            $partnobaru .= $bag3[$i];
                                        }else{
                                            $partnobaru .= '-'.$bag3[$i];
                                        }
                                    }

                                    $r .='  '.$partnobaru.'
                                            </td>
                                            <td width="150" align="center" style="valign:center">'.wordwrap($data['part_name'], 35, "<br>\n").'</td>
                                            <td width="30" align="center">'.$data['qty'].'</td>
                                            <td width="30" align="center" bgcolor="red" style="valign:center">Will be Repair</td>
                                            <td width="30" align="center">'.$data['part_uom'].'</td>
                                        </tr>
                                    ';

                                    $i++;
                                    $b++;
                                    $total_baris++;

                                }
                            }

                            $num_key_konst +=16;
                            $limit_const +=16;

                            $r .= '
                                </table>
                                </page>
                            ';

                            if ($qc_num == ($llist + 1)) {
                                $r .= '
                                    <table width="700px" style="margin-top: 20px;margin-left:0px;page-break-after: always;text-align: center;width: 350px;bottom: 0px;" border="">
                                        <tr>
                                            <td colspan="1" style="text-align: left; width: 130px;"><b>DOC HEADER TEXT :</b></td>
                                            <td colspan="4" style="text-align: center;"></td>

                                        </tr>
                                        <tr>
                                            <td width="110" height="50"></td>
                                            <td width="110" height="50"></td>
                                            <td width="110" height="50"></td>
                                            <td width="110" height="50"></td>
                                            <td width="110" height="50"></td>
                                        </tr>
                                        <tr>
                                            <td width="220"></td>
                                            <td width="100"><hr align="center" style="height: 0px; color: #343434">PRODUKSI</td>
                                            <td width="50"></td>
                                            <td width="100"><hr align="center" style="height: 0px; color: #343434">QC</td>
                                        </tr>
                                ';
                            }else{
                                $r .= '
                                    <table width="700px" style="margin-top: 20px;margin-left:0px;page-break-after: always;text-align: center;width: 350px;bottom: 0px;" border="">
                                        <tr>
                                            <td colspan="1" style="text-align: left; width: 130px;"><b>DOC HEADER TEXT :</b></td>
                                            <td colspan="4" style="text-align: center;"></td>

                                        </tr>
                                        <tr>
                                            <td width="110" height="50"></td>
                                            <td width="110" height="50"></td>
                                            <td width="110" height="50"></td>
                                            <td width="110" height="50"></td>
                                            <td width="110" height="50"></td>
                                        </tr>
                                        <tr>
                                            <td width="220"></td>
                                            <td width="100"><hr align="center" style="height: 0px; color: #343434">PRODUKSI</td>
                                            <td width="50"></td>
                                            <td width="100"><hr align="center" style="height: 0px; color: #343434">QC</td>
                                        </tr>
                                ';
                            }

                            $r .= '
                                </table>
                            ';
            }
            $this->kb_pdf->WriteHTML($r);
        }

    // CLAIM
    $i = 1;
    $c = 1;
    $total_baris = 0;
    $num_key_konst = 0;
    $limit_const = 16;
        if(count($claim) > 0){
            for ($llist = 1; $llist <= $qc_num; $llist++) {
                $cl .='
                    <page>
                    <table class="header_cop" style="font-size: 86px; margin-top:20px">
                            <tr>
                                <td style="width:80px;"> <img src="./assets/img/LogoAisin.png" width="90" height="70"></td>
                            </tr>
                        </table>
                        <table>
                            <tr>
                                <td style="font-size: 18px;font-weight: bold;width:610px;">PT. AISIN INDONESIA</td>
                            </tr>
                        </table>
                        <table>
                                <tr>
                                    <td style="font-size: 26px;font-weight: bold;width:100%; padding-left: 240px; padding-top: 10px; padding-bottom: 5px">STOCK TRANSFER SLIP</td>
                                </tr>
                        </table>
                        <table style="margin-top: 5px;width: 800px;font-weight: bold;" border="">
                            <tr>
                                <td style="width:105px;" id="content">
                                    NO
                                </td>
                                <td style="width:560px;" colspan="3" id="content">
                                    : ST/CL/'.$no.'
                                </td>
                            </tr>
                            <tr>
                                <td style="width:105px;" id="content">
                                    FROM
                                </td>
                                <td style="width:560px;" colspan="3" id="content">
                                    : PP04
                                </td>
                            </tr>

                            <tr>
                                <td style="">
                                    DATE
                                </td>
                                <td>
                                    : '.$delivery_date.'
                                </td>
                            </tr>

                            <tr>
                                <td style="">
                                    MOVEMENT TYPE
                                </td>
                                <td style="" colspan="3">
                                    : '.$mvt.'
                                </td>

                                <td style="">
                                    
                                </td>
                                <td>
                                    
                                </td>
                            </tr>

                            <tr>
                                <td style="">
                                    PAGE
                                </td>
                                <td style="" colspan="3">
                                    : '. $llist . "/" . $qc_num .'
                                </td>

                                <td style="">
                                    
                                </td>
                                <td>
                                    
                                </td>
                            </tr>
                        </table>
                        <table width="700px" cellspacing="0" style="margin-top: 10px;margin-left:0px;text-align: center;" border="1">
                            <tr>
                                <th width="15" align="center">No.</th>
                                <th width="100" align="center">Sloc Tujuan</th>
                                <th width="100" align="center">PARTS No.</th>
                                <th width="295" align="center">PARTS NAME</th>
                                <th width="50" align="center">Qty</th>
                                <th width="80" align="center">Status</th>
                                <th width="80" align="center">UoM</th>
                            </tr>';
                            
                            foreach ($claim as $mat_good => $data){

                                if ($mat_good < $num_key_konst) {
                                    if ($num_key_konst != 0) {
                                        continue;
                                    }
                                } elseif ($mat_good >= $limit_const) {
                                    continue;
                                } else {
                                    $cl .='
                                        <tr>
                                            <td width="20" align="center" >'.$c.'</td>
                                            <td width="20" align="center" style="valign:center">WH00 (B)</td>
                                            <td width="30" align="center">
                                    ';

                                    $partno = trim($data['part_no']);
                                    //$partno = trim('-1234567890abcdef');
                                    $length = strlen($partno);
                                    $bag1   = substr($partno, 0, 6);
                                    $sisa   = (int)$length - 6;
                                    //echo $sisa;
                                    if($sisa <= 5){
                                        $bag2 = substr($partno, 6, $sisa);
                                    }else{
                                        $bag2 = substr($partno, 6, 5);
                                        $sisa = (int)$length - 11;
                                    }
                                    //echo $sisa;
                                    $partsisa = substr($partno, 11, $sisa);
                                    $bag3     = str_split($partsisa, 2);
                                    //echo $partsisa;
                                    if(substr($bag1, 0, 1) == '-'){
                                        $bag1 = str_replace('-', '', $bag1);
                                    }

                                    $partnobaru = $bag1.'-'.$bag2;
                                    //echo $partnobaru;
                                    for($i = 0; $i < sizeof($bag3); $i++){
                                        if($bag3[$i] == ''){
                                            $partnobaru .= $bag3[$i];
                                        }else{
                                            $partnobaru .= '-'.$bag3[$i];
                                        }
                                    }

                                    $cl .='  '.$partnobaru.'
                                            </td>
                                            <td width="150" align="center" style="valign:center">'.wordwrap($data['part_name'], 35, "<br>\n").'</td>
                                            <td width="30" align="center">'.$data['qty'].'</td>
                                            <td width="30" align="center" bgcolor="red" style="valign:center">Claim to Vendor</td>
                                            <td width="30" align="center">'.$data['part_uom'].'</td>
                                        </tr>
                                    ';

                                    $i++;
                                    $c++;
                                    $total_baris++;

                                }
                            }

                            $num_key_konst +=16;
                            $limit_const +=16;

                            $cl .= '
                                </table>
                                </page>
                            ';

                            if ($qc_num == ($llist + 1)) {
                                $cl .= '
                                    <table width="700px" style="margin-top: 20px;margin-left:0px;page-break-after: always;text-align: center;width: 350px;bottom: 0px;" border="">
                                        <tr>
                                            <td colspan="1" style="text-align: left; width: 130px;"><b>DOC HEADER TEXT :</b></td>
                                            <td colspan="4" style="text-align: center;"></td>

                                        </tr>
                                        <tr>
                                            <td width="110" height="50"></td>
                                            <td width="110" height="50"></td>
                                            <td width="110" height="50"></td>
                                            <td width="110" height="50"></td>
                                            <td width="110" height="50"></td>
                                        </tr>
                                        <tr>
                                            <td width="220"></td>
                                            <td width="100"><hr align="center" style="height: 0px; color: #343434">PPIC</td>
                                            <td width="50"></td>
                                            <td width="100"><hr align="center" style="height: 0px; color: #343434">QC</td>
                                        </tr>
                                ';
                            }else{
                                $cl .= '
                                    <table width="700px" style="margin-top: 20px;margin-left:0px;page-break-after: always;text-align: center;width: 350px;bottom: 0px;" border="">
                                        <tr>
                                            <td colspan="1" style="text-align: left; width: 130px;"><b>DOC HEADER TEXT :</b></td>
                                            <td colspan="4" style="text-align: center;"></td>

                                        </tr>
                                        <tr>
                                            <td width="110" height="50"></td>
                                            <td width="110" height="50"></td>
                                            <td width="110" height="50"></td>
                                            <td width="110" height="50"></td>
                                            <td width="110" height="50"></td>
                                        </tr>
                                        <tr>
                                            <td width="220"></td>
                                            <td width="100"><hr align="center" style="height: 0px; color: #343434">PPIC</td>
                                            <td width="50"></td>
                                            <td width="100"><hr align="center" style="height: 0px; color: #343434">QC</td>
                                        </tr>
                                ';
                            }

                            $cl .= '
                                </table>
                            ';
            }
            $this->kb_pdf->WriteHTML($cl);
        }


    // SCRAPPING
    $i = 1;
    $d = 1;
    $total_baris = 0;
    $num_key_konst = 0;
    $limit_const = 16;
    	if(count($scrap) > 0){
            for ($llist = 0; $llist < $qc_num; $llist++) {
                
            	$p .='
                    <page>
                    <table class="header_cop" style="font-size: 86px; margin-top:20px">
                            <tr>
                                <td align="center" style="padding-left: 10px"><img src="./assets/img/LogoAisin.png" width="65" height="45"/></td>
                                <td style="font-size: 24px;font-weight: bold;width:610px; text-align: center;">
                                    LEMBAR KERUSAKAN BARANG (LKB)
                                </td>
                                <td style="padding-left: 10px">
                                    PAGE
                                </td>
                                <td>
                                    : '. ($llist+1) . "/" . $qc_num .'
                                </td>
                            </tr>
                    </table>
                    <table style="margin-top: 10px;">
                            <tr>
                                <td style="font-size: 14px;width:800px;"><b>Line Process : C/C, C/D, W/R, D/L, D/F, .....</b></td>
                            </tr>
                    </table>
                    <table style="margin-top: 10px;">
                            <tr>
                                <td style="width:750px;" align="center">
                                    <barcode type="C39" value="'.trim($barcode).'" style="color: #000000; font-size: 3mm"></barcode>
                                </td>
                            </tr>
                    </table>
                    <table style="margin-top: 10px;width: 800px;font-weight: bold;">
                            <tr>
                                <td style="width:105px;" id="content">
                                    Doc. Date
                                </td>
                                <td style="width:455px;" id="content">
                                    : '. $delivery_date .' 
                                </td>
                                <td style="width:100px; padding-left: 15px" id="content">
                                    Kode Area
                                </td>
                                <td id="content">
                                    : FG-004
                                </td>
                            </tr>
                            <tr>
                                <td style="width:105px;" id="content">
                                    LKB Number
                                </td>
                                <td style="width:455px;" id="content">
                                    : '. $lkbno .' 
                                </td>
                                <td style="width:100px; padding-left: 10px" id="content">
                                    
                                </td>
                                <td id="content">
                                    
                                </td>
                            </tr>
                            <tr>
                                <td style="width:105px;" id="content">
                                    
                                </td>
                                <td style="width:455px;" id="content">
                                     
                                </td>
                                <td style="width:100px; padding-left: 10px" id="content">
                                    
                                </td>
                                <td id="content">
                                    
                                </td>
                            </tr>
                    </table>
                    <table width="700px" cellspacing="0" style="margin-top: 10px;margin-left:0px;text-align: center;" border="1">
                            <tr>
                                <th width="20" rowspan="2">No.</th>
                                <th width="80" rowspan="2">BACK No.</th>
                                <th width="80" rowspan="2">PARTS No.</th>
                                <th width="170" rowspan="2">PARTS NAME</th>
                                <th width="40" colspan="2">Front</th>
                                <th width="40" colspan="2">Rear</th>
                                <th width="225" colspan="4">Kerusakan</th>
                                <th width="70" colspan="2">Quantity</th>
                              </tr>
                              <tr>
                                <td>RH</td>
                                <td>LH</td>
                                <td>RH</td>
                                <td>LH</td>
                                <td>Jenis Reject</td>
                                <td>Kategori NG</td>
                                <td>Kode</td>
                                <td>Deskripsi</td>
                                <td>Request</td>
                                <td>Sat</td>
                              </tr>';

                            foreach ($scrap as $mat_good => $data){

                                if ($mat_good < $num_key_konst) {
                                    if ($num_key_konst != 0) {
                                        continue;
                                    }
                                } elseif ($mat_good >= $limit_const) {
                                    continue;
                                } else {

                                	$p .= '
                                		<tr>
	                                        <td align="center" height="30" style="text-align: center; font-size:10px;">'. $d .'</td>
	                                        <td align="center" style="font-size:10px;">';
	                                        	$backnoq = $this->db->query("SELECT CHR_BACK_NO FROM TM_PARTS WHERE CHR_PART_NO = '".trim($data['part_no'])."'")->result();
                                                $backno  = $backnoq[0]->CHR_BACK_NO;
	                                        $p .='
	                                        '. $backno .'
	                                        </td>
	                                        <td align="center" style="font-size:10px;">';
	                                        	$partno = trim($data['part_no']);
                                                //$partno = trim('-1234567890abcdef');
                                                $length = strlen($partno);
                                                $bag1   = substr($partno, 0, 6);
                                                $sisa   = (int)$length - 6;
                                                //echo $sisa;
                                                if($sisa <= 5){
                                                    $bag2 = substr($partno, 6, $sisa);
                                                }else{
                                                    $bag2 = substr($partno, 6, 5);
                                                    $sisa = (int)$length - 11;
                                                }
                                                //echo $sisa;
                                                $partsisa = substr($partno, 11, $sisa);
                                                $bag3     = str_split($partsisa, 2);
                                                //echo $partsisa;
                                                if(substr($bag1, 0, 1) == '-'){
                                                    $bag1 = str_replace('-', '', $bag1);
                                                }

                                                $partnobaru = $bag1.'-'.$bag2;
                                                //echo $partnobaru;
                                                for($i = 0; $i < sizeof($bag3); $i++){
                                                    if($bag3[$i] == ''){
                                                        $partnobaru .= $bag3[$i];
                                                    }else{
                                                        $partnobaru .= '-'.$bag3[$i];
                                                    }
                                                }
	                                        $p .='
	                                        '. $partnobaru .'
	                                        </td>
	                                        <td align="center" style="font-size:10px;">'.wordwrap($data['part_name'], 25, "<br>\n").'</td>
	                                        <td align="center"></td>
	                                        <td align="center"></td>
	                                        <td align="center"></td>
	                                        <td align="center"></td>
	                                        <td align="center"></td>
	                                        <td align="center"></td>
	                                        <td align="center"></td>
	                                        <td align="center"></td>
	                                        <td align="center" style="font-size:10px;">'.$data['qty'].'</td>
	                                        <td align="center"></td>
	                                    </tr>';
	                                $i++;
                                    $d++;
                                	$total_baris++;
	                            }
	                        }

	                        $sisa = $limit_const - count($scrap);
                            if((count($scrap)) < $sisa){
                                for($a = $d; $a < 16; $a++){
                                	$p .= '
                                		<tr>
	                                        <td align="center" style="font-size:10px;">'.$a.'</td>
	                                        <td align="center"></td>
	                                        <td align="center"></td>
	                                        <td align="center"></td>
	                                        <td align="center"></td>
	                                        <td align="center"></td>
	                                        <td align="center"></td>
	                                        <td align="center"></td>
	                                        <td align="center"></td>
	                                        <td align="center"></td>
	                                        <td align="center"></td>
	                                        <td align="center"></td>
	                                        <td align="center"></td>
	                                        <td align="center"></td>
	                                    </tr>
                                	';
                                }
                            }

                            $num_key_konst +=16;
                            $limit_const +=16;
                                	
                        if ($qc_num == ($llist + 1)) {
                                $p .= '
                                <tr>
                                    <th colspan="10" rowspan="2"></th>
                                    <th colspan="2" style="text-align: right; padding-right: 5px;font-size:11px;">Total</th>
                                    <th style="font-size:10px;">'.count($scrap).'</th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <th colspan="2" style="text-align: right; padding-right: 5px; font-size:11px;">Grand Total</th>
                                    <th style="font-size:10px;">';
                                        $grandtot = 0;
                                        foreach ($scrap as $mat_good => $data){
                                            $grandtot += $data['qty'];
                                        }
                                $p .= '
                                    '. $grandtot .'
                                    </th>
                                    <td></td>
                                </tr>
                            </table>
                            </page>';
                        }else{
                            $p .= '
                                </table>
                                </page>
                            ';
                        }

                        if ($qc_num == ($llist + 1)) {
                        	$p .='
                        		<table width="700px" style="margin-top: 20px;margin-left:0px;page-break-after: always;text-align: center;bottom: 0px;" border="1">
	                                  <tr>
                                        <th width="148" style="text-align:left; padding-left:5px;">Note :</th>
                                        <th colspan="4"></th>
                                        <th width="80" >Mengetahui, </th>
                                        <th colspan="2">DEPT. QA</th>
                                        <th colspan="3">DEPT. PRODUKSI</th>
                                        <th>DEPT. MSU</th>
                                      </tr>
                                      <tr>
                                        <td height="50" rowspan="2"></td>
                                        <td colspan="4" rowspan="2"></td>
                                        <td height="20">PPIC</td>
                                        <td valign="bottom" width="76" rowspan="2">Ka. Sie</td>
                                        <td valign="bottom" width="76" rowspan="2">Leader</td>
                                        <td valign="bottom" width="76" rowspan="2">Ka. Bag</td>
                                        <td valign="bottom" width="76" rowspan="2">Ka. Sie</td>
                                        <td valign="bottom" width="76" rowspan="2">Leader</td>
                                        <td valign="bottom" align="left" width="76" rowspan="2" style="padding-left:5px;">Date :</td>
                                      </tr>
                                      <tr>
                                        <td height="50" valign="bottom" align="left" style="padding-left:5px;">Date :</td>
                                      </tr>
	                                  ';
	                    }else{
	                    	$p .='
	                             <table width="700px" style="margin-top: 20px;margin-left:0px;page-break-after: always;text-align: center;bottom: 0px;" border="1">
                        	';
	                    }
	                                $p .='
	                             </table>
                        	';

            }
			$this->kb_pdf->WriteHTML($p);
        }

$filename = 'QCSheets'. date('dmY') .'.pdf';

$this->kb_pdf->Output($filename);

?>