<?php

$size = "20px";

$page = 1;
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
	margin-top : 0mm ;
	margin-bottom :  0mm;
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
	font-size: 11px;
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
	font-size: 12px;
	text-align: center;
	font-weight: bold;
}

#table{
	margin:auto;
	border-spacing:0px;
}

</style>
</head>
<body>';


for ($x = 0; $x < 1; $x++) {
	for ($u = 0; $u < $range; $u++) {
		$no_pallet = $u + 1;
		$p .= '<div id="kotak">
		<table id="table">
		
			<tr>
				<td colspan="2"id="kotak02 ">PT AISIN INDONESIA</td>
				<td colspan="3" rowspan="2" id="kotak02">BARCODE PACKING EXPORT<br></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			<tr></tr>
			<tr>
				<td colspan="2" id="kotak03">Content</td>
                                <td colspan="3" rowspan="2" id="kotak2" style="font-size:30px;vertical-align:middle;">Case NO #' . $no_pallet . '/' . $range;

		$p .= '</td>
				<td></td>
				<td id="kotak03">Customer</td>
				
			</tr>
			<tr>';
		$p .= '<td colspan="2" rowspan="4" id="kotak11" style="font-size:16px;">';


		//get part no for palet
		$get_content = $this->db->query("SELECT * FROM TT_PACKING_UPLOAD where INT_NOPALLET = '" . $no_pallet . "' and CHR_IDPACKING = '$id_packing'")->result();
		$qty = 0;
		$qty_box = 0;
		foreach ($get_content as $value_content) {
			$partno = $value_content->CHR_PART_NO;
			$po = $value_content->CHR_NOPO_CUST;

			$partname1 = substr($partno, 0, 6);
			$partname2 = substr($partno, 6, 5);
			$partname3 = substr($partno, 11, 2);
			$partname5 = "-";
			$partno = $partname1 . $partname5 . $partname2 . $partname5 . $partname3;
			$partno = trim($partno);
			$length2 = strlen($partno);
			if (substr($partno, 0, 1) == "-") { //delete - pertama
				$partno = substr($partno, 1);
				$length2 = strlen($partno);
			}
			if (substr($partno, -1) == "-") { //delete minus terakhir
				$partno = rtrim($partno, "-");
			};
			$p .= $partno . '<br>';
			$qty = $qty + $value_content->INT_QTY;
			$qty_box = $qty_box + ($value_content->INT_QTY / $value_content->INT_QTY_PER_BOX);
		}


		$p .= '</td>
				<td></td>
				<td id="kotak13">' . $cust_name;

		$p .= '</td>

			</tr>
			<tr>
				
				
				<td style = "margin-left:10mm;text-align:center" colspan="3" rowspan="2"><br>&nbsp;&nbsp;&nbsp;<barcode type="C39" value="';
		$p .= $value_content->CHR_IDPALLET;
		$p .= '" label="label" style="width:87mm; height:10mm; color: #000000; font-size: 2mm">&nbsp;</barcode></td>
				<td></td>
				<td id="kotak03">Country</td>
				
			</tr>
			<tr>
				<td></td>
				<td id="kotak13" style="font-size:20px;vertical-align:middle;">' . $country . '</td>
				
			</tr>
			<tr>
				
				<td colspan="4" style="text-align:center;"><br><br></td>
				<td  style="font-weight: bold;">Plan Delivery : ' . date("d M Y", strtotime($delivery_date)) . '</td>
			</tr>
			
			<tr>
				<td style="font-size:10px;"></td>
				<td></td>
				<td colspan = "1" style="font-size:11;border:solid;border-width:1px;text-align:center;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;TOTAL BOX&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
				<td colspan = "4" style="font-size:11;border:solid;border-width:1px;text-align:center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;TOTAL QTY &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>	
				<td rowspan="2" colspan="3" style="border:solid;text-align:center;border-width:1px;font-weight: bold;"><br>' . $po . '</td>
			</tr>
			<tr>
				<td>Print Date <br>' . date("d M Y") . '</td>
				<td style="font-size:18;font-color:#ff0000;text-align:center;font-weight:bold"></td>
				<td style="font-size:22px;border:solid;border-width:1px;text-align:center">' . $qty_box . '</td>
				<td style="font-size:22px;border:solid;border-width:1px;text-align:center">' . $qty . '</td>	
				<td></td>
				<td></td>
			</tr>
			
		</table>
</div>';
		if (($page % 4) == 0) {
			$p .= "<style = page-break-after:always></style>";
		} elseif (($page % 4) == 1) {
			$p .= "<p class=smallatas></p>";
		} else {
			$p .= "<p class=big></p>";
		}
		$page++;
	}
}

$p .= '</body>
</html>';

$this->kb_pdf->WriteHTML($p);
$this->kb_pdf->Output('test.pdf');
