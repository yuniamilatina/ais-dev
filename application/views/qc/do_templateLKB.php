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
        <title>Delivery Order From PT Aisin Indonesia</title>
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
                        <td style="width:80px;"> <img src="./assets/image/LogoAisin.png" width="90" height="70"></td>
                        <!-- <td style="width:80px;font-size: 16px"> PT. AISIN INDONESIA <BR> EJIP INDUSTRIAL PARK PLOT 5J, CIKARANG - BEKASI <BR> Telp.(021)8970909 Facs.(021) 8970910</td> -->
                        <td style="font-size: 24px;font-weight: bold;width:610px;padding-left:100px">
                            LEMBAR KERUSAKAN BARANG (LKB)
                        </td>
                    </tr>
                </table>
                <table>
                    <tr>
                        <td style="font-size: 16px;width:610px">Line Process : C/C, C/D, W/R, D/L, D/F,.....</td>
                        <!--<td style="width:80px;"> <img src="/var/www/html/elisa_qa/assets/image/LogoAisin.png" width="200" height="40"></td>-->

                        <!-- <td style="width:100px;"> <img src="/var/www/html/elisa/assets/barcode/delivery_order/<?php echo $do_barcode_tittle ?>.gif" width="180" height="40"></td> -->
                        <!-- <?php 
                            $bar = trim($do_barcode_tittle);
                        ?>
                        <td style="width:100px;"> <img src="./assets/barcode/delivery_order/<?php echo $bar?>.gif" width="180" height="40"></td> -->
                        <!--<td style="width:100px;"> <img src="C:\xampp\htdocs\elisa\assets\barcode\delivery_order\<?php echo $do_barcode_tittle ?>.gif" width="180" height="40"></td>-->
                    </tr>
                </table>
                <table style="width: 800px; padding-top: 10px">
                    <tr>
                        <!--<td style="width:80px;"> <img src="/var/www/html/elisa_qa/assets/image/LogoAisin.png" width="200" height="40"></td>-->
                        <!-- <td style="width:100px;"> <img src="/var/www/html/elisa/assets/barcode/delivery_order/<?php echo $do_barcode_tittle ?>.gif" width="180" height="40"></td> -->
                        <?php 
                            $bar = trim($do_barcode_tittle);
                        ?>
                        <td style="width:100px; padding-left: 300px"> <img src="./assets/barcode/delivery_order/<?php echo $bar?>.gif" width="180" height="40"></td>
                        <!--<td style="width:100px;"> <img src="C:\xampp\htdocs\elisa\assets\barcode\delivery_order\<?php echo $do_barcode_tittle ?>.gif" width="180" height="40"></td>-->
                    </tr>
                </table>
                <table style="margin-top: 10px;width: 800px;font-weight: bold;">
                    <tr>
                        <td style="width:105px; padding-left: 10px" id="content">
                            Doc. Date
                        </td>
                        <td style="width:500px;" colspan="3" id="content">
                            : <?php echo $do_no ?>
                        </td>

                        <td style="width:100px; " id="content">
                            Kode Area
                        </td>
                        <td id="content">
                            : <?php echo $customer ?>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding-left: 10px">
                            LKB Number
                        </td>
                        <td style="" colspan="3">
                            : <?php echo $llist + 1 . "/" . $list_part_do_num ?>
                        </td>

                        <td style="">
                            From
                        </td>
                        <td>
                            : <?php echo $delivery_loc ?>
                        </td>
                    </tr>

                    <tr>
                        <td style="">

                        </td>
                        <td style="" colspan="3">

                        </td>

                        <td style="">
                            To
                        </td>
                        <td>
                            : <?php echo $delivery_loc ?>
                        </td>
                    </tr>

                </table>
                <!--================================================================================================-->
                <table width="465" cellspacing="0" style="margin-top: 2px;margin-left:0px;text-align: center;" border="1">
                    <tr>
                        <th width="8" rowspan="2">No</th>
                        <th width="10" rowspan="2">BACK No.</th>
                        <th width="10" rowspan="2">PARTS No.</th>
                        <th width="30" rowspan="2">PARTS NAME</th>
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
//                    $i = 1;

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
                                <td align="center" height="30" style="text-align: center"><?php echo $i; ?></td>
                                <td align="center">Tembak Back No</td>
                                <td align="center">Tembak Part No</td>
                                <td align="center" style="text-align: left;">Tembak Part Name</td>
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
                                <!-- <td align="center" height="29" style="text-align: center"><?php echo $i; ?></td>
                                <td align="center">Tembak Back No</td>
                                <td align="center">(<?php echo $data->CHR_CUS_PART_NO; ?>)
                                    <?php echo $data->CHR_CUS_PART_NO; ?>
                                </td>
                                <td align="center" style="text-align: left;"><?php echo $data->CHR_PART_NAME; ?></td>
                                <td align="center"></td>
                                <td align="center"><?php echo $data->INT_TOT_KANBAN; ?></td>
                                <td align="center"><?php echo $data->INT_QTY_KANBAN; ?></td>
                                <td align="center"><?php echo $data->INT_TOT_QTY; ?></td>
                                <td align="center"><?php echo $data->CHR_PART_UOM; ?></td>
                                <td align="center"></td>
                                <td align="center"></td>
                                <td align="center"></td> -->
                            </tr>
                            <?php
                            $i++;
                            $total_baris++;
                        }
                    }
                    $num_key_konst +=15;
                    $limit_const +=15;
                    ?>

                    <tr>
                        <th colspan="11" rowspan="2"></th>
                        <th>Total</th>
                        <th></th>
                        <th></th>
                      </tr>
                      <tr>
                        <th>Grand Total</th>
                        <td></td>
                        <td></td>
                    </tr>

                </table>
                <?php if ($list_part_do_num == ($llist + 1)) { ?>
                    <table style="margin-top: 10px;margin-left:0px;text-align: center;width: 600px;bottom: 0px;" border="1">

                    <?php } else { ?>
                        <table style="margin-top: 2px;margin-left:0px;page-break-after: always;text-align: center;width: 600px;bottom: 0px;" border="">
                        <?php }
                        ?>

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
                            <td width="50">Ka. sie</td>
                            <td width="50">Leader</td>
                            <td width="50">KA. BAG</td>
                            <td width="50">KA. SIE</td>
                            <td width="50">LEADER</td>
                            <td width="50" style="text-align: left;">DATE</td>
                        </tr>

                        <!-- <tr>
                            <td colspan="1" style="text-align: center;">Customer</td>
                            <td colspan="4" style="text-align: center;">PT. AISIN INDONESIA</td>

                        </tr>
                        <tr>
                            <td style="width:25%;">Received BY</td>
                            <td style="width:25%;">DRIVER</td>
                            <td>SECURITY</td>
                            <td>FINANCE</td>
                            <td>PPC</td>
                        </tr>
                        <tr>
                            <td style="height:50px;"> </td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="2" style="text-align: center;">Name, Signature & Chop</td>
                            <td colspan="3" style="text-align: center;">Name, Signature & Chop</td>

                        </tr> -->
                    </table>
                <?php } ?>
                </body>
                </html>