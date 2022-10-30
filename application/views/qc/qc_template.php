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
?>

<html>

    <head>
        <title>QC PT Aisin Indonesia</title>
        <style>
            table , th ,tr,td
            {
                /*border: 1.5px solid black;*/
                border-collapse:collapse;
                font-size: 12px;
                font-family: "Times New Roman", Georgia, Serif;
            }

            td{
                height:20px;
            }

            .border
            {
                border: 1px solid black;
                border-collapse:collapse;
            }

        </style>
    </head>
    <body style="margin-left:-40px;">
            <?php
            $i = 1;
            $total_baris = 0;
            $num_key_konst = 0;
            $limit_const = 16;
                if(count($goods) > 0){
                    for ($llist = 1; $llist <= $qc_num; $llist++) {
                        ?>
                        <!-- Halaman untuk goods -->
                        <table class="header_cop" style="font-size: 86px;">
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
                                    <td style="font-size: 26px;font-weight: bold;width:100%; padding-left: 290px; padding-top: 10px; padding-bottom: 5px">Stock Transfer Slip</td>
                                </tr>
                        </table>
                        <table style="margin-top: 5px;width: 800px;font-weight: bold;" border="">
                        <tr>
                                <td style="width:105px;" id="content">
                                    NO
                                </td>
                                <td style="width:560px;" colspan="3" id="content">
                                    : <?php echo "ST/GD/".$no; ?>
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
                                    : <?php echo $delivery_date ?>
                                </td>
                            </tr>

                            <tr>
                                <td style="">
                                    MOVEMENT TYPE
                                </td>
                                <td style="" colspan="3">
                                    : <?php echo $mvt; ?>
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
                                    : <?php echo $llist."/".$qc_num; ?>
                                </td>

                                <td style="">
                                    
                                </td>
                                <td>
                                    
                                </td>
                            </tr>
                                
                        </table>
                        <!--================================================================================================-->
                        
                        <table width="500"  cellspacing="0" style="margin-top: 5px;margin-left:0px;text-align: center;width: 800px" border="1">
                            <tr>
                                <th width="20" align="center">No.</th>
                                <th width="20" align="center">Sloc Tujuan</th>
                                <th width="30" align="center">PARTS No.</th>
                                <th width="150" align="center">PARTS NAME</th>
                                <th width="30" align="center">Qty</th>
                                <th width="30" align="center">Status</th>
                                <th width="30" align="center">UoM</th>
                            </tr>
                            <?php
                            $a = 1;
                            foreach ($goods as $mat_good => $data){

                                if ($mat_good < $num_key_konst) {
                                    if ($num_key_konst != 0) {
                                        continue;
                                    }
                                } elseif ($mat_good >= $limit_const) {
                                    continue;
                                } else {
                                ?>
                                <tr>
                                    <td width="20" align="center"><?php echo $a?></td>
                                    <td width="20" align="center"><?php echo $data['sloc_to']?></td>
                                    <td width="30" align="center">
                                    <?php
                                        //echo substr($data['part_no'], 0, 6).'-'.substr($data['part_no'], 6, 11);
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
                                        echo $partnobaru;
                                    ?>
                                    </td>
                                    <td width="150" align="center"><?php echo $data['part_name']?></td>
                                    <td width="30" align="center"><?php echo $data['qty']?></td>
                                    <td width="30" align="center" bgcolor="green">Goods</td>
                                    <td width="30" align="center"><?php echo $data['part_uom']?></td>
                                </tr>
                                <?php 
                                $i++;
                                $a++;
                                $total_baris++;
                            }
                        }
                        $num_key_konst +=16;
                        $limit_const +=16;
                        ?>
                        </table>
                        <?php if ($qc_num == ($llist + 1)) { ?>
                            <table style="margin-top: 10px;margin-left:0px;page-break-after: always;text-align: center;width: 350px;bottom: 0px;" border="">
                                <tr>
                                    <td colspan="1" style="text-align: left; width: 130px;"><b>DOC HEADER TEXT :</b></td>
                                    <td colspan="4" style="text-align: center;"></td>

                                </tr>
                                <tr>
                                    <td style="height:50px;"></td>
                                    <td style="width:50px;"></td>
                                    <td style="width:50px;"></td>
                                    <td style="width:50px;"></td>
                                    <td style="width:50px;"></td>
                                </tr>
                                <tr>
                                    <td> </td>
                                    <td style="width:260px;"><hr width="50%" align="center" style="height: 0px; color: #343434">PPIC</td>
                                    <td style="width:260px;"><hr width="50%" align="center" style="height: 0px; color: #343434">QC</td>
                                </tr>
                                <?php }
                                else { ?>
                                <table style="margin-top: 10px;margin-left:0px;page-break-after: always;text-align: center;width: 350px;bottom: 0px;" border="">
                                <tr>
                                    <td colspan="1" style="text-align: left; width: 130px;"><b>DOC HEADER TEXT :</b></td>
                                    <td colspan="4" style="text-align: center;"></td>

                                </tr>
                                <tr>
                                    <td style="height:50px;"></td>
                                    <td style="width:50px;"></td>
                                    <td style="width:50px;"></td>
                                    <td style="width:50px;"></td>
                                    <td style="width:50px;"></td>
                                </tr>
                                <tr>
                                    <td> </td>
                                    <td style="width:260px;"><hr width="50%" align="center" style="height: 0px; color: #343434">PPIC</td>
                                    <td style="width:260px;"><hr width="50%" align="center" style="height: 0px; color: #343434">QC</td>
                                </tr>
                                <?php }
                                ?>
                            </table>
                        <?php } ?><?php
                }
            ?>
                    <!--  Halaman untuk goods -->

            <?php
            $i = 1;
            $total_baris = 0;
            $num_key_konst = 0;
            $limit_const = 16;
                if(count($repair) > 0){
                    for ($llist = 1; $llist <= $qc_num; $llist++) {
                        ?>
                        <!-- Halaman untuk goods -->
                        <table class="header_cop" style="font-size: 86px;">
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
                                    <td style="font-size: 26px;font-weight: bold;width:100%; padding-left: 290px; padding-top: 10px; padding-bottom: 5px">Stock Transfer Slip</td>
                                </tr>
                        </table>
                        <table style="margin-top: 5px;width: 800px;font-weight: bold;" border="">
                        <tr>
                                <td style="width:105px;" id="content">
                                    NO
                                </td>
                                <td style="width:560px;" colspan="3" id="content">
                                    : <?php echo "ST/RP/".$no; ?>
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
                                    : <?php echo $delivery_date ?>
                                </td>
                            </tr>

                            <tr>
                                <td style="">
                                    MOVEMENT TYPE
                                </td>
                                <td style="" colspan="3">
                                    : <?php echo $mvt; ?>
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
                                    : <?php echo $llist."/".$qc_num; ?>
                                </td>

                                <td style="">
                                    
                                </td>
                                <td>
                                    
                                </td>
                            </tr>
                                
                        </table>
                        <!--================================================================================================-->
                        
                        <table width="500"  cellspacing="0" style="margin-top: 5px;margin-left:0px;text-align: center;width: 800px" border="1">
                            <tr>
                                <th width="20" align="center">No.</th>
                                <th width="20" align="center">Sloc Tujuan</th>
                                <th width="30" align="center">PARTS No.</th>
                                <th width="150" align="center">PARTS NAME</th>
                                <th width="30" align="center">Qty</th>
                                <th width="30" align="center">Status</th>
                                <th width="30" align="center">UoM</th>
                            </tr>
                            <?php
                            $b = 1;
                            foreach ($repair as $mat_good => $data){

                                if ($mat_good < $num_key_konst) {
                                    if ($num_key_konst != 0) {
                                        continue;
                                    }
                                } elseif ($mat_good >= $limit_const) {
                                    continue;
                                } else {
                                ?>
                                <tr>
                                    <td width="20" align="center"><?php echo $b?></td>
                                    <td width="20" align="center"><?php echo $data['sloc_to'] . '(B)'?></td>
                                    <td width="30" align="center">
                                    <?php
                                        //echo substr($data['part_no'], 0, 6).'-'.substr($data['part_no'], 6, 11);
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
                                        echo $partnobaru;
                                    ?>
                                    </td>
                                    <td width="150" align="center"><?php echo $data['part_name']?></td>
                                    <td width="30" align="center"><?php echo $data['qty']?></td>
                                    <td width="30" align="center" bgcolor="red">Will be Repair</td>
                                    <td width="30" align="center"><?php echo $data['part_uom']?></td>
                                </tr>
                                <?php 
                                $i++;
                                $b++;
                                $total_baris++;
                            }
                        }
                        $num_key_konst +=16;
                        $limit_const +=16;
                        ?>
                        </table>
                        <?php if ($qc_num == ($llist + 1)) { ?>
                            <table style="margin-top: 10px;margin-left:0px;page-break-after: always;text-align: center;width: 350px;bottom: 0px;" border="">
                                <tr>
                                    <td colspan="1" style="text-align: left; width: 130px;"><b>DOC HEADER TEXT :</b></td>
                                    <td colspan="4" style="text-align: center;"></td>

                                </tr>
                                <tr>
                                    <td style="height:50px;"></td>
                                    <td style="width:50px;"></td>
                                    <td style="width:50px;"></td>
                                    <td style="width:50px;"></td>
                                    <td style="width:50px;"></td>
                                </tr>
                                <tr>
                                    <td> </td>
                                    <td style="width:260px;"><hr width="50%" align="center" style="height: 0px; color: #343434">PPIC</td>
                                    <td style="width:260px;"><hr width="50%" align="center" style="height: 0px; color: #343434">QC</td>
                                </tr>
                                <?php }
                                else { ?>
                                <table style="margin-top: 10px;margin-left:0px;page-break-after: always;text-align: center;width: 350px;bottom: 0px;" border="">
                                <tr>
                                    <td colspan="1" style="text-align: left; width: 130px;"><b>DOC HEADER TEXT :</b></td>
                                    <td colspan="4" style="text-align: center;"></td>

                                </tr>
                                <tr>
                                    <td style="height:50px;"></td>
                                    <td style="width:50px;"></td>
                                    <td style="width:50px;"></td>
                                    <td style="width:50px;"></td>
                                    <td style="width:50px;"></td>
                                </tr>
                                <tr>
                                    <td> </td>
                                    <td style="width:260px;"><hr width="50%" align="center" style="height: 0px; color: #343434">PPIC</td>
                                    <td style="width:260px;"><hr width="50%" align="center" style="height: 0px; color: #343434">QC</td>
                                </tr>
                                <?php }
                                ?>
                            </table>
                        <?php } ?><?php
                }
            ?>
                    <!--  Halaman untuk repair -->

            <?php
            $i = 1;
            $total_baris = 0;
            $num_key_konst = 0;
            $limit_const = 16;
                if(count($claim) > 0){
                    for ($llist = 1; $llist <= $qc_num; $llist++) {
                        ?>
                        <!-- Halaman untuk goods -->
                        <table class="header_cop" style="font-size: 86px;">
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
                                    <td style="font-size: 26px;font-weight: bold;width:100%; padding-left: 290px; padding-top: 10px; padding-bottom: 5px">Stock Transfer Slip</td>
                                </tr>
                        </table>
                        <table style="margin-top: 5px;width: 800px;font-weight: bold;" border="">
                        <tr>
                                <td style="width:105px;" id="content">
                                    NO
                                </td>
                                <td style="width:560px;" colspan="3" id="content">
                                    : <?php echo "ST/CL/".$no; ?>
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
                                    : <?php echo $delivery_date ?>
                                </td>
                            </tr>

                            <tr>
                                <td style="">
                                    MOVEMENT TYPE
                                </td>
                                <td style="" colspan="3">
                                    : <?php echo $mvt; ?>
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
                                    : <?php echo $llist."/".$qc_num; ?>
                                </td>

                                <td style="">
                                    
                                </td>
                                <td>
                                    
                                </td>
                            </tr>
                                
                        </table>
                        <!--================================================================================================-->
                        
                        <table width="500"  cellspacing="0" style="margin-top: 5px;margin-left:0px;text-align: center;width: 800px" border="1">
                            <tr>
                                <th width="20" align="center">No.</th>
                                <th width="20" align="center">Sloc Tujuan</th>
                                <th width="30" align="center">PARTS No.</th>
                                <th width="150" align="center">PARTS NAME</th>
                                <th width="30" align="center">Qty</th>
                                <th width="30" align="center">Status</th>
                                <th width="30" align="center">UoM</th>
                            </tr>
                            <?php
                            $c = 1;
                            foreach ($claim as $mat_good => $data){

                                if ($mat_good < $num_key_konst) {
                                    if ($num_key_konst != 0) {
                                        continue;
                                    }
                                } elseif ($mat_good >= $limit_const) {
                                    continue;
                                } else {
                                ?>
                                <tr>
                                    <td width="20" align="center"><?php echo $c?></td>
                                    <td width="20" align="center">WH00 (B)</td>
                                    <td width="30" align="center">
                                    <?php
                                        //echo substr($data['part_no'], 0, 6).'-'.substr($data['part_no'], 6, 11);
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
                                        echo $partnobaru;
                                    ?>
                                    </td>
                                    <td width="150" align="center"><?php echo $data['part_name']?></td>
                                    <td width="30" align="center"><?php echo $data['qty']?></td>
                                    <td width="30" align="center" bgcolor="red">Claim to Vendor</td>
                                    <td width="30" align="center"><?php echo $data['part_uom']?></td>
                                </tr>
                                <?php 
                                $i++;
                                $c++;
                                $total_baris++;
                            }
                        }
                        $num_key_konst +=16;
                        $limit_const +=16;
                        ?>
                        </table>
                        <?php if ($qc_num == ($llist + 1)) { ?>
                            <table style="margin-top: 10px;margin-left:0px;page-break-after: always;text-align: center;width: 350px;bottom: 0px;" border="">
                                <tr>
                                    <td colspan="1" style="text-align: left; width: 130px;"><b>DOC HEADER TEXT :</b></td>
                                    <td colspan="4" style="text-align: center;"></td>

                                </tr>
                                <tr>
                                    <td style="height:50px;"></td>
                                    <td style="width:50px;"></td>
                                    <td style="width:50px;"></td>
                                    <td style="width:50px;"></td>
                                    <td style="width:50px;"></td>
                                </tr>
                                <tr>
                                    <td> </td>
                                    <td style="width:260px;"><hr width="50%" align="center" style="height: 0px; color: #343434">PPIC</td>
                                    <td style="width:260px;"><hr width="50%" align="center" style="height: 0px; color: #343434">QC</td>
                                </tr>
                                <?php }
                                else { ?>
                                <table style="margin-top: 10px;margin-left:0px;page-break-after: always;text-align: center;width: 350px;bottom: 0px;" border="">
                                <tr>
                                    <td colspan="1" style="text-align: left; width: 130px;"><b>DOC HEADER TEXT :</b></td>
                                    <td colspan="4" style="text-align: center;"></td>

                                </tr>
                                <tr>
                                    <td style="height:50px;"></td>
                                    <td style="width:50px;"></td>
                                    <td style="width:50px;"></td>
                                    <td style="width:50px;"></td>
                                    <td style="width:50px;"></td>
                                </tr>
                                <tr>
                                    <td> </td>
                                    <td style="width:260px;"><hr width="50%" align="center" style="height: 0px; color: #343434">PPIC</td>
                                    <td style="width:260px;"><hr width="50%" align="center" style="height: 0px; color: #343434">QC</td>
                                </tr>
                                <?php }
                                ?>
                            </table>
                        <?php } ?><?php
                }
            ?>
                    <!--  Halaman untuk scrap -->
            <?php
            $i = 1;
            $total_baris = 0;
            $num_key_konst = 0;
            $limit_const = 16;
                if(count($scrap) > 0){
                    for ($llist = 0; $llist < $qc_num; $llist++) {
                        ?>
                        <!-- Halaman untuk goods -->
                        <table class="header_cop" style="font-size: 86px;">
                            <tr>
                                <!--<td style="width:100px;"> <img src="C:\xampp\htdocs\elisa\assets\image\LogoAisin.png" width="90" height="70"></td>-->

                                <!-- <td style="width:80px;"> <img src="/var/www/html/elisa/assets/image/LogoAisin.png" width="90" height="70"></td> -->
                                <td align="center" style="padding-left: 10px"><img src="./assets/img/LogoAisin.png" width="65" height="45"/></td>
                                <!-- <td style="width:80px;font-size: 16px"> PT. AISIN INDONESIA <BR> EJIP INDUSTRIAL PARK PLOT 5J, CIKARANG - BEKASI <BR> Telp.(021)8970909 Facs.(021) 8970910</td> -->
                                <td align="center" style="font-size: 24px;font-weight: bold;width:610px;padding-left: 10px">
                                    LEMBAR KERUSAKAN BARANG (LKB)
                                </td>
                                <td style="padding-left: 10px">
                                    PAGE
                                </td>
                                <td align="center" style="width: 50px;" colspan="3">
                                    : <?php echo ($llist+1)."/".$qc_num; ?>
                                </td>
                            </tr>
                        </table>
                        <!-- <table>
                            <tr>
                                <td style="font-size: 18px;font-weight: bold;width:610px;">PT. AISIN INDONESIA</td>
                            </tr>
                        </table> -->
                        <table style="margin-top: 10px;">
                            <tr>
                                <td style="font-size: 14px;width:800px; padding-left:10px"><b>Line Process : C/C, C/D, W/R, D/L, D/F, .....</b></td>
                                <!--<td style="width:100px;"> <img src="./assets/barcode/delivery_order/<?php echo $bar?>.gif" width="180" height="40"></td> -->
                                <!--<td style="width:100px;"> <img src="C:\xampp\htdocs\elisa\assets\barcode\delivery_order\<?php echo $do_barcode_tittle ?>.gif" width="180" height="40"></td>-->
                            </tr>
                        </table>
                        <table style="margin-top: 10px;">
                            <tr>
                                <td align="center" style="width:800px;" align="center">
                                    <img src="./assets/barcode/lkb/<?php echo trim($barcode); ?>.gif" height="50px">
                                    <!-- <img src="<?php echo site_url();?>/qc/qc/saveData/<?php echo $kode;?>"> -->
                                    <!-- <barcode type="C39" value="<?php echo trim($barcode);?>" style="color: #000000; font-size: 2mm"></barcode> -->
                                </td>
                                <!-- <td align="center" style="padding-left: 10px"><img src="./assets/img/LogoAisin.png" width="65" height="45"/></td> -->
                            </tr>
                        </table>
                        <table style="margin-top: 10px;width: 800px;font-weight: bold;">
                            <tr>
                                <td style="width:105px;padding-left: 10px" id="content">
                                    Doc. Date
                                </td>
                                <td style="width:500px;" colspan="3" id="content">
                                    : <?php echo $delivery_date ?>
                                </td>

                                <td style="width:100px; padding-left: 10px" id="content">
                                    Kode Area
                                </td>
                                <td id="content">
                                    : FG-004
                                </td>
                            </tr>

                            <tr>
                                <td style="padding-left: 10px">
                                    LKB Number
                                </td>
                                <td style="" colspan="3">
                                    : <?php echo $lkbno?>
                                </td>

                                <!-- <td style="">
                                    From
                                </td>
                                <td>
                                    : PP04
                                </td> -->
                            </tr>

                            <tr>
                                <td style="">

                                </td>
                                <td style="" colspan="3">

                                </td>

                                <!-- <td style="">
                                    To
                                </td>
                                <td>
                                    : RE01
                                </td> -->
                            </tr>

                        </table>
                        <!--================================================================================================-->
                        
                        <table width="90%" cellspacing="0" style="margin-top: 10px;margin-left:0px;text-align: center;" border="1">
                            <tr>
                                <th width="8" rowspan="2">No</th>
                                <th width="10" rowspan="2">BACK No.</th>
                                <th width="10" rowspan="2">PARTS No.</th>
                                <th width="50" rowspan="2">PARTS NAME</th>
                                <th width="8" colspan="2">Front</th>
                                <th width="8" colspan="2">Rear</th>
                                <th width="50" colspan="4">Kerusakan</th>
                                <th width="50" colspan="2">Quantity</th>
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
                              </tr>
                            <?php
                            $d = 1;
                            foreach ($scrap as $mat_good => $data){

                                if ($mat_good < $num_key_konst) {
                                    if ($num_key_konst != 0) {
                                        continue;
                                    }
                                } elseif ($mat_good >= $limit_const) {
                                    continue;
                                } else {
                                ?>
                                    <tr>
                                        <td align="center" height="30" style="text-align: center; font-size: 11px"><?php echo $d?></td>
                                        <td align="center" style="font-size: 11px">
                                            <?php 
                                                $backnoq = $this->db->query("SELECT CHR_BACK_NO FROM TM_PARTS WHERE CHR_PART_NO = '".trim($data['part_no'])."'")->result();
                                                $backno  = $backnoq[0]->CHR_BACK_NO;
                                                echo $backno;
                                            ?>
                                        </td>
                                        <td align="center" style="font-size: 11px" >
                                            <?php
                                                //echo substr($data['part_no'], 0, 6).'-'.substr($data['part_no'], 6, 11);
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
                                                echo $partnobaru;
                                            ?>
                                        </td>
                                        <td align="center" style="font-size: 11px"><?php echo $data['part_name']?></td>
                                        <td align="center"></td>
                                        <td align="center"></td>
                                        <td align="center"></td>
                                        <td align="center"></td>
                                        <td align="center"></td>
                                        <td align="center"></td>
                                        <td align="center"></td>
                                        <td align="center"></td>
                                        <td align="center" style="font-size: 11px"><?php echo $data['qty']?></td>
                                        <td align="center"></td>
                                    </tr>
                                <?php

                                $i++;
                                $d++;
                                $total_baris++;
                            }
                        }

                        $sisa = $limit_const - count($scrap);
                            if((count($scrap)) < $sisa){
                                for($a = $d; $a < 16; $a++){
                                    ?>
                                    <tr>
                                        <td align="center"><?php echo $a?></td>
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
                                    <?php
                                }
                            }

                        $num_key_konst +=16;
                        $limit_const +=16;
                        ?>
                        <tr>
                            <th colspan="10" rowspan="2"></th>
                            <th colspan="2" style="text-align: right; padding-right: 5px;">Total</th>
                            <th><?php echo count($scrap); ?></th>
                            <th></th>
                        </tr>
                        <tr>
                            <th colspan="2" style="text-align: right; padding-right: 5px;">Grand Total</th>
                            <th>
                                <?php
                                    $grandtot = 0;
                                    foreach ($scrap as $mat_good => $data){
                                        $grandtot += $data['qty'];
                                    }
                                ?>
                                <?php 
                                    echo $grandtot;
                                ?>
                            </th>
                            <td></td>
                        </tr>

                        </table>
                        <?php if ($qc_num == ($llist + 1)) { ?>
                            <table style="margin-top: 20px;margin-left:0px;page-break-after: always;text-align: center;width: 600px;bottom: 0px;" border="1">
                                <tr>
                                    <th colspan="5" style="text-align: left;" width="223">Note</th>
                                    <th width="60">Mengetahui,</th>
                                    <th colspan="2">DEPT. QA</th>
                                    <th width="10" colspan="3">DEPT. PRODUKSI</th>
                                    <th>DEP. MSU</th>
                                  </tr>
                                  <tr>
                                    <td colspan="5" rowspan="4"></td>
                                    <td>PPIC</td>
                                    <td rowspan="3"></td>
                                    <td rowspan="3"></td>
                                    <td rowspan="3"></td>
                                    <td rowspan="3"></td>
                                    <td rowspan="3"></td>
                                    <td rowspan="3"></td>
                                  </tr>
                                  <tr>
                                    <td rowspan="2" height="30"></td>
                                  </tr>
                                  <tr>
                                  </tr>
                                  <tr>
                                    <td style="text-align: left;">Date:</td>
                                    <td width="50">Ka. Sie</td>
                                    <td width="50">Leader</td>
                                    <td width="50">KA. BAG</td>
                                    <td width="50">KA. SIE</td>
                                    <td width="50">LEADER</td>
                                    <td width="50" style="text-align: left;">DATE</td>
                                </tr>
                                <?php }
                        else { ?>
                            <table style="margin-top: 20px;margin-left:0px;page-break-after: always;text-align: center;width: 600px;bottom: 0px;" border="1">
                        <?php }?><?php
                }
            ?>
            </table><?php } ?></body></html>