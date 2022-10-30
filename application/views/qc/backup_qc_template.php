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

<!--<html>
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
        <div class="test">
            //<?php
//            $i = 1;
//            $total_baris = 0;
//            $num_key_konst = 0;
//            $limit_const = 15;
//
//            for ($llist = 0; $llist < $list_part_do_num; $llist++) {
//                ?>
                 Halaman untuk goods 
                <table class="header_cop" style="margin-top: -40px;font-size: 86px;">
                    <tr>
                        <td style="width:100px;"> <img src="C:\xampp\htdocs\elisa\assets\image\LogoAisin.png" width="90" height="70"></td>

                             <td style="width:80px;"> <img src="/var/www/html/elisa/assets/image/LogoAisin.png" width="90" height="70"></td> 
                        <td style="width:80px;"> <img src="./assets/img/LogoAisin.png" width="90" height="70"></td>
                         <td style="width:80px;font-size: 16px"> PT. AISIN INDONESIA <BR> EJIP INDUSTRIAL PARK PLOT 5J, CIKARANG - BEKASI <BR> Telp.(021)8970909 Facs.(021) 8970910</td> 
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
                            : <?php echo "ST/GD/" . $no; ?>
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
                            : <?php echo date('d.m.Y') ?>
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
                            : 
                        </td>

                        <td style="">

                        </td>
                        <td>

                        </td>
                    </tr>

                </table>
                ================================================================================================

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
                    foreach ($goods as $mat_good) {
                        ?>
                        <tr>
                            <td width="20" align="center"><?php echo $a ?></td>
                            <td width="20" align="center"><?php echo $mat_good['sloc_to'] ?></td>
                            <td width="30" align="center"><?php echo $mat_good['part_no'] ?></td>
                            <td width="150" align="center"><?php echo $mat_good['part_name'] ?></td>
                            <td width="30" align="center"><?php echo $mat_good['qty'] ?></td>
                            <td width="30" align="center" bgcolor="green">Goods</td>
                            <td width="30" align="center"><?php echo $mat_good['part_uom'] ?></td>
                        </tr>
                        <?php
                        $a++;
                    }
                    ?>
                </table>

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
                </table>
                  Halaman untuk goods 

                 Halaman untuk repair
                <table class="header_cop" style="margin-top: -40px;font-size: 86px;">
                    <tr>
                        <td style="width:100px;"> <img src="C:\xampp\htdocs\elisa\assets\image\LogoAisin.png" width="90" height="70"></td>

                             <td style="width:80px;"> <img src="/var/www/html/elisa/assets/image/LogoAisin.png" width="90" height="70"></td> 
                        <td style="width:80px;"> <img src="./assets/img/LogoAisin.png" width="90" height="70"></td>
                         <td style="width:80px;font-size: 16px"> PT. AISIN INDONESIA <BR> EJIP INDUSTRIAL PARK PLOT 5J, CIKARANG - BEKASI <BR> Telp.(021)8970909 Facs.(021) 8970910</td> 
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
                            : <?php echo "ST/CL/" . $no; ?>
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
                            : <?php echo date('d.m.Y') ?>
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
                            : 
                        </td>

                        <td style="">

                        </td>
                        <td>

                        </td>
                    </tr>

                </table>
                ================================================================================================

                <table width="100%"  cellspacing="0" style="margin-top: 5px;margin-left:0px;text-align: center;width: 800px" border="1">
                    <tr>
                        <th width="20" align="center">No.</th>
                        <th width="20" align="center">Sloc Tujuan</th>
                        <th width="70" align="center">PARTS No.</th>
                        <th width="180" align="center">PARTS NAME</th>
                        <th width="30" align="center">Qty</th>
                        <th width="30" align="center">Status</th>
                        <th width="30" align="center">UoM</th>
                    </tr>
                    <?php
                    $b = 1;
                    foreach ($repair as $mat_good) {
                        ?>
                        <tr>
                            <td width="20" align="center"><?php echo $b ?></td>
                            <td width="20" align="center"><?php echo $mat_good['sloc_to'] ?></td>
                            <td width="70" align="center"><?php echo $mat_good['part_no'] ?></td>
                            <td width="180" align="center"><?php echo $mat_good['part_name'] ?></td>
                            <td width="30" align="center"><?php echo $mat_good['qty'] ?></td>
                            <td width="30" align="center" bgcolor="red">Will be Repair</td>
                            <td width="30" align="center"><?php echo $mat_good['part_uom'] ?></td>
                        </tr>
                        <?php
                        $b++;
                    }
                    ?>
                </table>

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
                </table>
                  Halaman untuk repair 

                 Halaman untuk claim
                <table class="header_cop" style="margin-top: -40px;font-size: 86px;">
                    <tr>
                        <td style="width:100px;"> <img src="C:\xampp\htdocs\elisa\assets\image\LogoAisin.png" width="90" height="70"></td>

                             <td style="width:80px;"> <img src="/var/www/html/elisa/assets/image/LogoAisin.png" width="90" height="70"></td> 
                        <td style="width:80px;"> <img src="./assets/img/LogoAisin.png" width="90" height="70"></td>
                         <td style="width:80px;font-size: 16px"> PT. AISIN INDONESIA <BR> EJIP INDUSTRIAL PARK PLOT 5J, CIKARANG - BEKASI <BR> Telp.(021)8970909 Facs.(021) 8970910</td> 
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
                            : <?php echo "ST/CL/" . $no; ?>
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
                            : <?php echo date('d.m.Y') ?>
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
                            : 
                        </td>

                        <td style="">

                        </td>
                        <td>

                        </td>
                    </tr>

                </table>
                ================================================================================================

                <table width="100%"  cellspacing="0" style="margin-top: 5px;margin-left:0px;text-align: center;width: 800px" border="1">
                    <tr>
                        <th width="20" align="center">No.</th>
                        <th width="20" align="center">Sloc Tujuan</th>
                        <th width="70" align="center">PARTS No.</th>
                        <th width="180" align="center">PARTS NAME</th>
                        <th width="30" align="center">Qty</th>
                        <th width="30" align="center">Status</th>
                        <th width="30" align="center">UoM</th>
                    </tr>
                    <?php
                    $c = 1;
                    foreach ($claim as $mat_good) {
                        ?>
                        <tr>
                            <td width="20" align="center"><?php echo $c ?></td>
                            <td width="20" align="center">WH00</td>
                            <td width="70" align="center"><?php echo $mat_good['part_no'] ?></td>
                            <td width="180" align="center"><?php echo $mat_good['part_name'] ?></td>
                            <td width="30" align="center"><?php echo $mat_good['qty'] ?></td>
                            <td width="30" align="center" bgcolor="red">Claim to Vendor</td>
                            <td width="30" align="center"><?php echo $mat_good['part_uom'] ?></td>
                        </tr>
                        <?php
                        $c++;
                    }
                    ?>
                </table>

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
                </table>
                  Halaman untuk repair 

                 Halaman untuk scrap
                <table class="header_cop" style="margin-top: -40px;font-size: 86px;">
                    <tr>
                        <td style="width:100px;"> <img src="C:\xampp\htdocs\elisa\assets\image\LogoAisin.png" width="90" height="70"></td>

                             <td style="width:80px;"> <img src="/var/www/html/elisa/assets/image/LogoAisin.png" width="90" height="70"></td> 
                        <td style="width:80px;"> <img src="./assets/img/LogoAisin.png" width="90" height="70"></td>
                         <td style="width:80px;font-size: 16px"> PT. AISIN INDONESIA <BR> EJIP INDUSTRIAL PARK PLOT 5J, CIKARANG - BEKASI <BR> Telp.(021)8970909 Facs.(021) 8970910</td> 
                        <td style="font-size: 24px;font-weight: bold;width:610px;padding-left:100px">
                            LEMBAR KERUSAKAN BARANG (LKB)
                        </td>
                    </tr>
                </table>
                <table>
                    <tr>
                        <td style="font-size: 18px;font-weight: bold;width:610px;">PT. AISIN INDONESIA</td>
                    </tr>
                </table>
                <table style="margin-top: 10px;">
                    <tr>
                        <td style="font-size: 16px;width:610px">Line Process : C/C, C/D, W/R, D/L, D/F,.....</td>
                        <td style="width:100px;"> <img src="./assets/barcode/delivery_order/<?php echo $bar ?>.gif" width="180" height="40"></td> 
                        <td style="width:100px;"> <img src="C:\xampp\htdocs\elisa\assets\barcode\delivery_order\<?php echo $do_barcode_tittle ?>.gif" width="180" height="40"></td>
                    </tr>
                </table>
                <table style="width: 800px; padding-top: 10px">
                    <tr>
                        <td style="width:80px;"> <img src="/var/www/html/elisa_qa/assets/image/LogoAisin.png" width="200" height="40"></td>
                         <td style="width:100px;"> <img src="/var/www/html/elisa/assets/barcode/delivery_order/<?php echo $do_barcode_tittle ?>.gif" width="180" height="40"></td> 
                        <?php
                        //$bar = trim($do_barcode_tittle);
                        ?>
                         <td style="width:100px; padding-left: 300px"> <img src="./assets/barcode/delivery_order/<?php echo $bar ?>.gif" width="180" height="40"></td> 
                        <td style="width:100px;"> <img src="C:\xampp\htdocs\elisa\assets\barcode\delivery_order\<?php echo $do_barcode_tittle ?>.gif" width="180" height="40"></td>
                    </tr>
                </table>
                <table style="margin-top: 10px;width: 800px;font-weight: bold;">
                    <tr>
                        <td style="width:105px; padding-left: 10px" id="content">
                            Doc. Date
                        </td>
                        <td style="width:500px;" colspan="3" id="content">
                            : <?php echo date('d.m.Y') ?>
                        </td>

                        <td style="width:100px; " id="content">
                            Kode Area
                        </td>
                        <td id="content">
                            : 
                        </td>
                    </tr>

                    <tr>
                        <td style="padding-left: 10px">
                            LKB Number
                        </td>
                        <td style="" colspan="3">
                            : 
                        </td>

                        <td style="">
                            From
                        </td>
                        <td>
                            : PP04
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
                            : RE01
                        </td>
                    </tr>

                </table>
                ================================================================================================
                 <table width="86%" cellspacing="0" style="margin-top: 10px;margin-left:0px;text-align: center;" border="1"> 
                <table width="87%" cellspacing="0" style="margin-top: 10px;margin-left:0px;text-align: center;" border="1">
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
                    foreach ($scrap as $mat_good) {
                        ?>
                        <tr>
                            <td align="center" height="30" style="text-align: center; font-size: 12px"><?php echo $d ?></td>
                            <td align="center" style="font-size: 12px">Tembak Back No</td>
                            <td align="center" style="font-size: 12px" ><?php echo $mat_good['part_no'] ?></td>
                            <td align="center" style="font-size: 12px"><?php echo $mat_good['part_name'] ?></td>
                            <td align="center"></td>
                            <td align="center"></td>
                            <td align="center"></td>
                            <td align="center"></td>
                            <td align="center"></td>
                            <td align="center"></td>
                            <td align="center"></td>
                            <td align="center"></td>
                            <td align="center"><?php echo $mat_good['qty'] ?></td>
                            <td align="center"></td>
                        </tr>
                        <?php
                        $d++;
                    }
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
                    <td width="50">Ka. sie</td>
                    <td width="50">Leader</td>
                    <td width="50">KA. BAG</td>
                    <td width="50">KA. SIE</td>
                    <td width="50">LEADER</td>
                    <td width="50" style="text-align: left;">DATE</td>
                </tr>
            </table>
              Halaman untuk scrap 

    </body>
</html>-->