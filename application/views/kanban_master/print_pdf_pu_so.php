<?php

set_time_limit(7200);
ini_set('max_execution_time', 0);
ini_set('memory_limit', '2048M');
$size = "16px";
$p = ' 
<html>
<head>
	<title>Cetak PDF</title>

<style type="text/css">

p.big {
    line-height: 1.125;
}

p.smallbawah {
    line-height: 0.4125;
}
p.smallatas {
    line-height: 0.2125;
}
#kotak{
	height:50mm;
	width: 186mm;
	margin:auto;
	border: solid;
	border-width: 1px;
}

#kotak02{
	height:2mm;
	text-align: center;
	font-size:17px;
	font-weight: bold;
}

#kotak03{
	widows: 50mm;
	height:1mm;
	border:solid;
	border-width: 1px;
	font-size: 12px;
	text-align: center;
	font-weight: bold;
	
}
#kotak1{

	height:3mm;
	border-left: solid;
	border-right:solid;
	border-width: 1px;
	font-size: 12px;
	text-align: center;
	font-weight: bold;
}

#kotak2{
	height:1mm;
	border:solid;
	border-width: 1px;
	text-align: center;
	font-size: 52px;
	font-weight: bold;
}

#kotak11{
	width:50mm;
	height:10mm;
	border-left: solid;
	border-right:solid;
	border-bottom: solid;
	border-width: 1px;
	font-size:' . $size . ';
	text-align: center;
	font-weight: bold;
}

#kotak12{
	width:50mm;
	height:10mm;
	border-left: solid;
	border-right:solid;
	border-bottom: solid;
	border-width: 1px;
	font-size: 16px;
	text-align: center;
	font-weight: bold;
}

#kotak13{
	width:50mm;
	height:10mm;
	border-left: solid;
	border-right:solid;
	border-bottom: solid;
	border-width: 1px;
	font-size: 22px;
	text-align: center;
	font-weight: bold;
}

#kotak14{
	width:50mm;
	height:10mm;
	border-left: solid;
	border-right:solid;
	border-bottom: solid;
	border-width: 1px;
	font-size: 15px;
	text-align: center;
	font-weight: bold;
}


#table{
	margin:auto;;
	border-spacing:0px;
}

</style>
</head>
<body>';

$page = 1;
foreach ($dlp as $value_lp) {
    $part_no_aii = $value_lp->CHR_PART_NO_AII;
                    $part_no_cust = $value_lp->CHR_PART_NO_CUST;
                    $back_no = $value_lp->CHR_BACK_NO;
                    $part_name = $value_lp->CHR_PART_NAME;
                    $self_prcs = $value_lp->CHR_SELF_PRCS;
                    $next_prcs = $value_lp->CHR_NEXT_PRCS;
                    $self_loc = $value_lp->CHR_SELF_LOC;
                    $next_loc = $value_lp->CHR_NEXT_LOC;
                    $qty_per_box = $value_lp->INT_QTY_PER_BOX;
                    $box_type = $value_lp->CHR_BOX_TYPE;
                    $no_kanban = $value_lp->CHR_NO_KANBAN;
                    $no_serial = $value_lp->CHR_SERIAL_NO;
                    $ket = trim($value_lp->CHR_KET);
                    $side = $value_lp->CHR_SIDE;
                    $box_type = $value_lp->CHR_BOX_TYPE;
                    $npk = trim($value_lp->CHR_USER);
                    
                    $split_ket = explode(" ", $ket);
    $p.= '<div id="kotak">
		<table id="table">
			<tr>
				<td colspan="2"id="kotak02 ">PT AISIN INDONESIA</td>
				<td colspan="3" rowspan="2" id="kotak02">PICKUP KANBAN ' . $specialorder . ' <br></td>
				<td></td>
				<td style="font-size:10px;text-align:right;">Delivery Date : '  . $value_lp->CHR_DATE_DELIVERY .  '</td>
				<td></td>
			</tr>
			<tr></tr>
			<tr>
				<td colspan="2" id="kotak03">Part No.AII:</td>
				<td colspan="3" rowspan="2" id="kotak2">' . $back_no . '</td>
				<td></td>
				<td id="kotak03">Self Process</td>
				
			</tr>
			<tr>
				<td colspan="2" id="kotak11">' . $part_no_aii . '</td>
				<td></td>
				<td id="kotak13">' . $self_prcs . '</td>

			</tr>
			<tr>
				<td colspan="2" id="kotak03">Part No.Customer:</td>
				
				<td style = "margin-left:10mm;text-align:center" colspan="3" rowspan="2"><br>&nbsp;&nbsp;<barcode type="C39" value="' . $no_kanban . ' 5 ' . $no_serial . '" label="label" style="width:87mm; height:10mm; color: #000000; font-size: 2mm">&nbsp;</barcode></td>
				<td></td>
				<td id="kotak03">Next Process</td>
				
			</tr>
			<tr>
				<td colspan="2" id="kotak11">' . $part_no_cust . '</td>
				<td></td>
				<td id="kotak13">' . $next_prcs . '</td>
				
			</tr>
			<tr>
				<td>Sloc From:' . $self_loc . '</td>
				<td></td>
				<td colspan="4" style="text-align:center;">' . $part_name . ' <br><br></td>
				<td>Sloc to:' . $next_loc . '<br><span style="font-size:12px;">Cust : </span></td>
				<td></td>
			</tr>
			
			<tr>
				<td style="font-size:10px;">Print Date <br>' . date("Y-m-d") . '</td>
				<td></td>
				<td colspan = "1" style="font-size:11;border:solid;border-width:1px;text-align:center;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;BOX TYPE&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
				<td colspan = "4" style="font-size:11;border:solid;border-width:1px;text-align:center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; QTY &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>	
				<td rowspan="2" colspan="3" style="border:solid;text-align:center;border-width:1px;word-wrap: break-word;font-size:12px;"><br>';
   $length_ket = 0;
    foreach ($split_ket as $value_ket) {
        $ket_value = $value_ket . " ";
        $length_ket = $length_ket + strlen($ket_value);
        if ($length_ket < 25) {
            $p.= $ket_value;
        } else {
            $length_ket = 0;
            $p.= "<br>" . $ket_value;
        }
    }
    $p.= '</td>
			</tr>
			<tr>
				<td> Serial No.' . $no_serial . ' <br>Created by : '. $npk .'</td>
				<td style="font-size:18;font-color:#ff0000;text-align:center;font-weight:bold">' . $side . '</td>
				<td style="font-size:22px;border:solid;border-width:1px;text-align:center">' . $box_type . '</td>
				<td style="font-size:22px;border:solid;border-width:1px;text-align:center"> ' . $qty_per_box . '</td>	
				<td></td>
				<td></td>
			</tr>

		</table>
</div>';

    if (($page % 4) == 0) {
        $p.= "<style = page-break-after:always></style>";
    } elseif (($page % 4) == 1) {
        $p.= "<p class=smallatas></p>";
    } else {
        $p.= "<p class=big></p>";
    }
    $page++;
}


$p .= '</body>
</html>';



$this->kb_pdf->WriteHTML($p);
$this->kb_pdf->Output('exemple.pdf');

?>