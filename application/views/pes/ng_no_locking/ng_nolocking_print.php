<style type="text/css">
    table.list {padding-top: 70mm;width: 160mm;max-width: 160mm;padding-bottom: 50mm}
    .list td {font-size: 9px;word-wrap: break-word;max-width: 70px;min-width:10px;text-align: center;height: 25px;}
    .isi td {border-top: 1px solid #3c3c3c;border-collapse: collapse;}
    table.footer {margin-left: 20px;padding-bottom: 30px;font-size: 11px;margin-top: 30px}
    .footer-head {text-align: center}
    .footer-middle td {height: 60px;width: 65px;}
    .footer-head .width-130 {height:20px;width: 130px}
    .footer-bottom {text-align: center;}
    //td.15mm {width: 15mm}
    span { line-height: 20px; }
    .header_title {margin-bottom: 0; line-height: 100%;text-align: center;margin-top:50px }
    .barcode {margin: 0 auto;text-align: center;margin-top: 10px}
    .text-11 { font-size: 12px }
    .width-max {width: 120px}
    .width-max2 {width: 80px}
    .width-middle {width: 30px}
    .in-line {display: inline;}
    .align-left {text-align: left;}
    .text-left {margin-left: 50px;padding-top: 10px; min-width:100mm;}
    .text-right {margin-left: 135mm;position: absolute;top:57mm;}
    .barcodes {width:60mm; height:15mm;}
    .padding-top-20 {padding-top: 20px}
    .padding-top-40 {padding-top: 40px}
    .print-ke {font-size: 11px;text-align: center;width: 100%}
    .page-number {position:absolute;margin-left: 650px;margin-top: 40px;}
    .partno {margin-left: 30px}
    img {position:absolute;margin-left:50px;width: 50px;top: 40px}
    .clearfix:after {
        visibility: hidden;
        display: block;
        font-size: 0;
        content: " ";
        clear: both;
        height: 0;
    }
    .clearfix { display: inline-block; }
    /* start commented backslash hack \*/
    * html .clearfix { height: 1%; }
    .clearfix { display: block; }
    /* close commented backslash hack */
</style>
<page backtop="10mm" backbottom="10mm" backleft="6mm" backright="6mm">
    <page_header backleft="10mm" backright="10mm">
        <span class="page-number"> Page: [[page_cu]]/[[page_nb]]</span>
        <p class="header_title" style=""><font size="2" style="font-size: 11pt"><b>LEMBAR KERUSAKAN BARANG (LKB)</b></font></p><br>
        <img src="<?php echo base_url('assets/img/logo.png'); ?>" />
        <div class="text-left text-11 padding-top-20"> Line proses	: C/C, C/D,W/R, D/L, D/F,.... </div><br>
        <div class="barcode">
            <barcode type="C39" value="<?php echo $CHR_LKB_NO; ?>" label="label" class="barcodes" style="color: #000000; font-size: 2mm"></barcode>
        </div><br>
        <div class="text-11 text-after-barcode in-line">
            <div class="text-left">
                <span class=""> Doc. Date : <?php echo $CHR_VALIDATE_DATE_LEADER; ?></span><br>
                <span class=""> LKB No : <?php echo @$CHR_LKB_NO; ?></span>
            </div>
            <div class="text-right">
                <span class=""> Kode Area : <?php echo @$CHR_AREA; ?></span>
            </div>
        </div>
        <div class="clearfix"></div>
    </page_header>
    <page_footer backtop="7mm" backbottom="1mm" backleft="10mm" backright="10mm">
        <table cellspacing="0" border="0" class="footer">
            <tbody><tr class="footer-head">
                    <td style="border-top: 1px solid #3c3c3c; border-bottom: 1px solid #3c3c3c; border-left: 1px solid #3c3c3c; border-right: 1px solid #3c3c3c;text-align: left;" align="left" bgcolor="#FFFFFF" class="width-130"><font color="#000000">NOTE :</font></td>
                    <td style="border-top: 1px solid #000000" align="center" bgcolor="#FFFFFF"><font color="#000000">Mengetahui</font></td>
                    <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" colspan="2" align="center" bgcolor="#FFFFFF"><font color="#000000">Dept. QA</font></td>
                    <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="3" align="center" bgcolor="#FFFFFF"><font color="#000000">Dept. PRODUKSI</font></td>
                    <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-right: 1px solid #000000" align="center" bgcolor="#FFFFFF"><font color="#000000">Dept. MSU</font></td>
                    <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-right: 1px solid #000000" align="center" bgcolor="#FFFFFF"><font color="#000000"></font></td>
                </tr>
                <tr>
                    <td style="border-left: 1px solid #3c3c3c; border-right: 1px solid #3c3c3c" align="left"><font color="#000000"><br></font></td>
                    <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000" align="center"><font color="#000000">PIC</font></td>
                    <td style="border-left: 1px solid #000000; border-right: 1px solid #000000" align="left"><font color="#000000"><br></font></td>
                    <td align="left"><font color="#000000"><br></font></td>
                    <td style="border-left: 1px solid #3c3c3c" align="left"><font color="#000000"><br></font></td>
                    <td style="border-left: 1px solid #000000; border-right: 1px solid #000000" align="center"><font color="#000000"><br></font></td>
                    <td style="border-right: 1px solid #3c3c3c" align="center"><font color="#000000"><br></font></td>
                    <td style="border-right: 1px solid #000000" align="left"><font color="#000000"><br></font></td>
                    <td style="border-right: 1px solid #000000" align="left"><font color="#000000"><br></font></td>
                </tr>
                <tr class="footer-middle">
                    <td style="border-left: 1px solid #3c3c3c; border-right: 1px solid #3c3c3c" align="left"><font color="#000000"><br></font></td>
                    <td align="left"><font color="#000000"><br></font></td>
                    <td style="border-left: 1px solid #3c3c3c; border-right: 1px solid #3c3c3c" align="left"><font color="#000000"><br></font></td>
                    <td align="left"><font color="#000000"><br></font></td>
                    <td style="border-left: 1px solid #3c3c3c" align="left"><font color="#000000"><br></font></td>
                    <td style="border-left: 1px solid #3c3c3c; border-right: 1px solid #3c3c3c" align="left"><font color="#000000"><br></font></td>
                    <td style="border-right: 1px solid #3c3c3c" align="left"><font color="#000000"><br></font></td>
                    <td style="border-right: 1px solid #000000" align="left"><font color="#000000"><br></font></td>
                    <td style="border-right: 1px solid #000000" align="left"><font color="#000000"><br></font></td>
                </tr>
                <tr class="footer-bottom">
                    <td style="border-bottom: 1px solid #3c3c3c; border-left: 1px solid #3c3c3c; border-right: 1px solid #3c3c3c;text-align: left" align="left"><font color="#000000"><br></font></td>
                    <td style="border-bottom: 1px solid #000000" align="left"><font color="#000000">Date.</font></td>
                    <td style="border-bottom: 1px solid #3c3c3c; border-left: 1px solid #3c3c3c; border-right: 1px solid #3c3c3c" align="center"><font color="#000000">Ka. Sie</font></td>
                    <td style="border-bottom: 1px solid #000000" align="center"><font color="#000000">Leader</font></td>
                    <td style="border-bottom: 1px solid #3c3c3c; border-left: 1px solid #3c3c3c" align="center"><font color="#000000">Ka. Bag</font></td>
                    <td style="border-bottom: 1px solid #3c3c3c; border-left: 1px solid #3c3c3c; border-right: 1px solid #3c3c3c" align="center"><font color="#000000">Ka. Sie</font></td>
                    <td style="border-bottom: 1px solid #3c3c3c; border-right: 1px solid #3c3c3c" align="center"><font color="#000000">Leader</font></td>
                    <td style="border-bottom: 1px solid #000000; border-right: 1px solid #000000; text-align:left " align="left"><font color="#000000">Date :</font></td>
                    <td style="border-bottom: 1px solid #000000; border-right: 1px solid #000000; text-align:left " align="left"><font color="#000000"></font></td>
                </tr>
            </tbody></table>
        <div class="print-ke"><?php echo @$print_ke; ?></div>
    </page_footer>
    <table cellspacing="0" border="0" class="list">
        <tbody><tr><b>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" rowspan="2" align="center" valign="middle">No.</td>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000" rowspan="2" align="center" valign="middle">Back No</td>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" rowspan="2" align="center" valign="middle" class="partno">Part No</td>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000" rowspan="2" align="center" valign="middle">Part Name</td>
            <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="2" align="center" valign="middle" bgcolor="#EEECE1">Front</td>
            <td style="border-top: 1px solid #000000" colspan="2" align="center" valign="middle" bgcolor="#EEECE1">Rear</td>
            <td style="border-top: 1px solid #000000; border-left: 1px solid #000000" colspan="4" align="center" valign="middle">Kerusakan</td>
            <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="2" align="center" valign="middle">Quantity</td></b>
        </tr>
        <tr><b>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="center" valign="middle" bgcolor="#EEECE1">RH</td>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign="middle" bgcolor="#EEECE1">LH</td>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000" align="center" valign="middle" bgcolor="#EEECE1">RH</td>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="center" valign="middle" bgcolor="#EEEEEE">LH</td>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign="middle">Jenis Reject</td>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000" align="center" valign="middle">Kategori NG</td>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign="middle" class="width-middle">Kode</td>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000" align="center" valign="middle">Deskripsi</td>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign="middle">Request</td>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-right: 1px solid #000000" align="center" valign="middle" class="width-middle">Sat</td></b>
        </tr>
        <?php foreach ($table as $key => $value): $value['NO'] = $key + 1; ?>
            <tr class="isi">
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"  align="center" valign="middle"><?php echo $value['NO']; ?></td>
                <td style="border-bottom: 1px solid #000000" align="left" valign="middle" class="align-left"><?php echo wordwrap(@$value['CHR_BACK_NO'], 6, "<br>", true); ?></td>
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign="middle" class="width-max2"><?php echo wordwrap(@$value['CHR_PART_NO'], 15, "<br>", true); ?></td>
                <td style="border-bottom: 1px solid #000000" align="left" valign="middle" class="align-left width-max"><?php echo wordwrap(@$value['CHR_PART_NAME'], 25, "<br>", true); ?></td>
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="center" valign="middle" bgcolor="#EEECE1"></td>
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign="middle" bgcolor="#EEECE1"><br></td>
                <td style="border-bottom: 1px solid #000000" align="center" valign="middle" bgcolor="#EEECE1"></td>
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="center" valign="middle" bgcolor="#EEECE1"></td>
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign="middle"><?php echo wordwrap(@$value['CHR_REJECT_CODE'], 8, "<br>", true); ?></td>
                <td style="border-bottom: 1px solid #000000" align="center" valign="middle"><?php echo wordwrap(@$value['CHR_NG_CATEGORY_CODE'], 8, "<br>", true); ?></td>
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign="middle"><?php echo wordwrap(@$value['CHR_DAMAGE_CODE'], 5, "<br>", true); ?></td>
                <td style="border-bottom: 1px solid #000000" align="center" valign="middle" class="align-left width-max"><?php echo wordwrap(@$value['CHR_DAMAGE_DESC'], 20, "<br>", true); ?></td>
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left"><?php echo wordwrap(@$value['INT_TOTAL_QTY'], 5, "<br>", true); ?></td>
                <td style="border-bottom: 1px solid #000000; border-right: 1px solid #000000" align="center" valign="middle"><?php echo wordwrap(@$value['CHR_PART_UOB'], 4, "<br>", true); ?></td>
            </tr>
            <?php
            $data['INT_TOTAL_QTY'][] = $value['INT_TOTAL_QTY'];
            $no = $value['NO'];
        endforeach;
        ?>

<?php for ($no; $no < 10; $no++): ?>

            <tr class="isi">
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"  align="center" valign="middle"></td>
                <td style="border-bottom: 1px solid #000000" align="center" valign="middle"></td>
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign="middle"></td>
                <td style="border-bottom: 1px solid #000000" align="center" valign="middle"></td>
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="center" valign="middle" bgcolor="#EEECE1"></td>
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign="middle" bgcolor="#EEECE1"><br></td>
                <td style="border-bottom: 1px solid #000000" align="center" valign="middle" bgcolor="#EEECE1"></td>
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="center" valign="middle" bgcolor="#EEECE1"></td>
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign="middle"></td>
                <td style="border-bottom: 1px solid #000000" align="center" valign="middle"></td>
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign="middle"></td>
                <td style="border-bottom: 1px solid #000000" align="center" valign="middle"></td>
                <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left"></td>
                <td style="border-bottom: 1px solid #000000; border-right: 1px solid #000000" align="center" valign="middle"></td>
            </tr>

<?php endfor; ?>
        <tr>
            <td height="18" align="left" valign="bottom"><br></td>
            <td align="left" valign="bottom"><br></td>
            <td align="left" valign="bottom"><br></td>
            <td align="left" valign="bottom"><br></td>
            <td align="left" valign="bottom"><br></td>
            <td align="left" valign="bottom"><br></td>
            <td align="left" valign="bottom"><br></td>
            <td align="left" valign="bottom"><br></td>
            <td align="left" valign="bottom"><br></td>
            <td align="left"><br></td>
            <td style="border-right: 1px solid #000000" align="left"><br></td>
            <td style="border-bottom: 1px solid #000000" align="right" valign="center">Total </td>
            <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000;border-right: 1px solid #000000" colspan="2" align="center"><?php echo count($data['INT_TOTAL_QTY']); ?></td>
        </tr>
        <tr>
            <td height="18" align="left" valign="bottom"><br></td>
            <td align="left" valign="bottom"><br></td>
            <td align="left" valign="bottom"><br></td>
            <td align="left" valign="bottom"><br></td>
            <td align="left" valign="bottom"><br></td>
            <td align="left" valign="bottom"><br></td>
            <td align="left" valign="bottom"><br></td>
            <td align="left" valign="bottom"><br></td>
            <td align="left" valign="bottom"><br></td>
            <td align="left"><br></td>
            <td style="border-right: 1px solid #000000" align="left"><br></td>
            <td style="border-bottom: 1px solid #000000" align="right" valign="center">Grand Total</td>
            <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000;border-right: 1px solid #000000" colspan="2" align="center"><?php echo array_sum($data['INT_TOTAL_QTY']); ?></td>
        </tr>
        <tr>
            <td  align="left"><br></td>
            <td align="left"><br></td>
            <td align="left"><br></td>
            <td align="left"><br></td>
            <td align="left"><br></td>
            <td align="left"><br></td>
            <td align="left"><br></td>
            <td align="left"><br></td>
            <td align="left"><br></td>
            <td align="left"><br></td>
            <td align="left"><br></td>
            <td align="left"><br></td>
            <td align="left"><br></td>
            <td align="left"><br></td>
        </tr>
        </tbody></table>
</page>