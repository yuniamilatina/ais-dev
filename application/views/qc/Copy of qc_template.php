<script>
    alert("asup");
</script>

<?php

function get_month($month) {
    switch ($month) {
        case "01":
            $nama_bulan = "January";
            break;
        case "02":
            $nama_bulan = "February";
            break;
        case "03":
            $nama_bulan = "March";
            break;
        case "04":
            $nama_bulan = "April";
            break;
        case "05":
            $nama_bulan = "May";
            break;
        case "06":
            $nama_bulan = "June";
            break;
        case "07":
            $nama_bulan = "July";
            break;
        case "08":
            $nama_bulan = "August";
            break;
        case "09":
            $nama_bulan = "September";
            break;
        case "10":
            $nama_bulan = "October";
            break;
        case "11":
            $nama_bulan = "November";
            break;
        case "12":
            $nama_bulan = "December";
            break;
    }
    return $nama_bulan;
}

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
                font-family: "Courier New", Courier, monospace;
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
        <div class="test">
            <?php
            $i = 1;
            $total_baris = 0;
            $num_key_konst = 0;
            $limit_const = 15;

            for ($llist = 0; $llist < $list_part_do_num; $llist++) {
                ?>
                <table class="header_cop" style="margin-top: -40px;font-size: 86px;">
                    <tr>
                        <!--<td style="width:100px;"> <img src="C:\xampp\htdocs\elisa\assets\image\LogoAisin.png" width="90" height="70"></td>-->

                        <!-- <td style="width:80px;"> <img src="/var/www/html/elisa/assets/image/LogoAisin.png" width="90" height="70"></td> -->
                        <td style="width:80px;"> <img src="./assets/img/LogoAisin.png" width="90" height="70"></td>
                        <!-- <td style="width:80px;font-size: 16px"> PT. AISIN INDONESIA <BR> EJIP INDUSTRIAL PARK PLOT 5J, CIKARANG - BEKASI <BR> Telp.(021)8970909 Facs.(021) 8970910</td> -->
                    </tr>
                </table>
                <table>
                    <tr>
                        <td style="font-size: 18px;font-weight: bold;width:610px;">PT. AISIN INDONESIA</td>
                        <!--<td style="width:80px;"> <img src="/var/www/html/elisa_qa/assets/image/LogoAisin.png" width="200" height="40"></td>-->

                        <!-- <td style="width:100px;"> <img src="/var/www/html/elisa/assets/barcode/delivery_order/<?php echo $do_barcode_tittle ?>.gif" width="180" height="40"></td> -->
                        <!-- <?php 
                            $bar = trim($do_barcode_tittle);
                        ?> -->
                        <!-- <td style="width:100px;"> <img src="./assets/barcode/delivery_order/<?php echo $bar?>.gif" width="180" height="40"></td> -->
                        <!--<td style="width:100px;"> <img src="C:\xampp\htdocs\elisa\assets\barcode\delivery_order\<?php echo $do_barcode_tittle ?>.gif" width="180" height="40"></td>-->
                    </tr>
                </table>
                <table>
                        <tr>
                            <td style="font-size: 26px;font-weight: bold;width:100%; padding-left: 250px; padding-top: 10px; padding-bottom: 5px">Stock Transfer Slip</td>
                            <!--<td style="width:80px;"> <img src="/var/www/html/elisa_qa/assets/image/LogoAisin.png" width="200" height="40"></td>-->

                            <!-- <td style="width:100px;"> <img src="/var/www/html/elisa/assets/barcode/delivery_order/<?php echo $do_barcode_tittle ?>.gif" width="180" height="40"></td> -->
                            <!-- <?php 
                                $bar = trim($do_barcode_tittle);
                            ?> -->
                            <!-- <td style="width:100px;"> <img src="./assets/barcode/delivery_order/<?php echo $bar?>.gif" width="180" height="40"></td> -->
                            <!--<td style="width:100px;"> <img src="C:\xampp\htdocs\elisa\assets\barcode\delivery_order\<?php echo $do_barcode_tittle ?>.gif" width="180" height="40"></td>-->
                        </tr>
                </table>
                <table style="margin-top: 5px;width: 800px;font-weight: bold;" border="">
                    <tr>
                        <td style="width:105px;" id="content">
                            FROM
                        </td>
                        <td style="width:560px;" colspan="3" id="content">
                            : <
                        </td>

                        <td style="width:50px;">
                            DOC
                        </td>
                        <td>
                            : 
                        </td>
                    </tr>

                    <tr>
                        <td style="">
                            TO
                        </td>
                        <td style="" colspan="3">
                            : 
                        </td>

                        <td style="">
                            DATE
                        </td>
                        <td>
                            : 
                        </td>
                    </tr>

                    <tr>
                        <td style="">
                            MOVEMENT TYPE: 
                        </td>
                        <td style="" colspan="3">
                            : 
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
                            : 
                        </td>

                        <td style="">
                            
                        </td>
                        <td>
                            
                        </td>
                    </tr>
                        
                </table>
                <!--================================================================================================-->
                
                <table width="100%"  cellspacing="0" style="margin-top: 5px;margin-left:0px;text-align: center;width: 800px" border="1">
                    <tr>
                        <th width="20" align="center">No.</th>
                        <th width="70" align="center">PARTS No.</th>
                        <th width="180" align="center">PARTS NAME</th>
                        <th width="30" align="center">Qty</th>
                        <th width="30" align="center">Status</th>
                        <th width="30" align="center">UoM</th>
                    </tr>

                    <?php
                    $i = 1;

                    foreach ($list_part_do_data as $key => $data) {
                        //awalnya  if ($key <= $num_key_konst) {
                        if ($key < $num_key_konst) {
                            if ($num_key_konst != 0) {
                                continue;
                            }
                        } elseif ($key >= $limit_const) {
                            continue;
                        } else {
                            ?>
                            <tr>
                                <td align="center" height="29" style="text-align: center"><?php echo $i; ?></td>
                                <td align="center"><?php echo $data->CHR_PART_NO;?></td>
                                <td align="center" style="text-align: center;"><?php echo $data->CHR_PART_NAME; ?></td>
                                <td align="center">Tembak</td>
                                <td align="center">Tembak</td>
                                <td align="center">Tembak</td>
                            </tr>
                            <?php
                            $i++;
                            $total_baris++;
                        }
                    }
                    $num_key_konst +=15;
                    $limit_const +=15;
                    ?>
                </table>
                <?php if ($list_part_do_num == ($llist + 1)) { ?>
                    <table style="margin-top: 2px;margin-left:0px;text-align: center;width: 350px;bottom: 0px;" border="">

                    <?php } else { ?>
                        <table style="margin-top: 2px;margin-left:0px;page-break-after: always;text-align: center;width: 350px;bottom: 0px;" border="">
                        <?php }
                        ?>
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
                            <td style="width:130px;"><hr width="50%" align="center" style="height: 0px; color: #343434">PPIC</td>
                            <td style="width:130px;"><hr width="50%" align="center" style="height: 0px; color: #343434">ENGINEERING</td>
                            <td style="width:130px;"><hr width="50%" align="center" style="height: 0px; color: #343434">PC</td>
                            <td style="width:130px;"><hr width="50%" align="center" style="height: 0px; color: #343434">PRODUCTION</td>
                        </tr>
                    </table>
                <?php } ?>
                </body>
                </html>