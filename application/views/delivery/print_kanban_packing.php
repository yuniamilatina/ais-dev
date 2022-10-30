<?php
$size = "20px";
$page = 1;
$p = ' 
<html>
<head>
<title>Cetak PDF</title>
<style type="text/css">

#kotak{
	height:50mm;
	width:200mm;
	margin-top:0mm;
	margin-bottom:0mm;
	border:solid;
	border-width: 1px;
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
			<table id="table" border=0>
			<tr style="text-align:center;">
				<td colspan="5" style="width:90mm;border-bottom: solid; border-width: 1px; font-size: 16px; vertical-align:middle;text-align:center;">Contain</td>
				<td colspan="2" rowspan="2" style="border-left:solid;border-right:solid; border-width: 1px; font-size: 16px; vertical-align:bottom;text-align:center;">PACKING EXPORT</td>
				<td style="font-size:14; vertical-align:middle;text-align:center;">PT AISIN INDONESIA</td>
			</tr>
			<tr style="text-align:center;">
				<td style="width:15mm;border-bottom:solid;border-right:solid; border-width: 1px;">W/C</td>
				<td style="width:35mm;border-bottom:solid;border-right:solid;border-width: 1px;">P/N (Cust No)</td>
				<td style="width:8mm;border-bottom:solid;border-right:solid;border-width: 1px;">B/N</td>
				<td style="width:8mm;border-bottom:solid;border-right:solid;border-width: 1px;">Q/Box</td>
				<td style="width:8mm;border-bottom:solid;border-width: 1px;">Qty</td>
				<td style="height:3mm;border-top:solid; border-width: 1px;font-size:12px;font-style:italic;vertical-align:middle;">Plan Delivery : ' . date("d M Y", strtotime($delivery_date)) . '</td>
			</tr>
			<tr style="text-align:center;">';
		$p .= '<td colspan="5" rowspan="5" style="border-right:solid;border-width:1px;">';
		$p .= '<table >';

		$get_content = $this->db->query(";WITH CTE (CHR_WORK_CENTER, CHR_PART_NO) AS (
				SELECT CHR_WORK_CENTER, CHR_PART_NO FROM TM_PROCESS_PARTS PP 
				INNER JOIN TM_DIRECT_BACKFLUSH_GENERAL DB ON DB.CHR_WCENTER = PP.CHR_WORK_CENTER AND INT_LIVE = 1
				WHERE (PP.CHR_FLAG_DELETE IS NULL OR PP.CHR_FLAG_DELETE <> 1) 
				), CTE_FIX (NOR, INT_NOPALLET, CHR_PART_NO, CHR_WORK_CENTER, INT_QTY, CHR_BACK_NO, CHR_NOPO_CUST, INT_QTY_PER_BOX, CHR_IDPALLET, CHR_CUST_CODE) AS (
				SELECT ROW_NUMBER() OVER(PARTITION BY PU.CHR_PART_NO, PU.INT_QTY, PU.INT_NOPALLET, PU.INT_QTY_PER_BOX ORDER BY PU.INT_NOPALLET, PP.CHR_WORK_CENTER, PP.CHR_PART_NO) AS Row_Number,
				INT_NOPALLET, PP.CHR_PART_NO, PP.CHR_WORK_CENTER, PU.INT_QTY, PU.CHR_BACK_NO, PU.CHR_NOPO_CUST, PU.INT_QTY_PER_BOX, PU.CHR_IDPALLET, PU.CHR_CUST_CODE
				FROM TT_PACKING_UPLOAD PU 
				INNER JOIN CTE PP ON PU.CHR_PART_NO = PP.CHR_PART_NO 
				WHERE CHR_IDPACKING = '$id_packing' AND INT_NOPALLET = '$no_pallet'
				)
				
				SELECT INT_NOPALLET,CHR_PART_NO, CHR_WORK_CENTER, INT_QTY, CHR_BACK_NO, CHR_NOPO_CUST, INT_QTY_PER_BOX, CHR_IDPALLET, CHR_CUST_CODE FROM CTE_FIX
				WHERE NOR  = 1 ORDER BY INT_NOPALLET")->result();
		$qty_summary = 0;
		$qty_box_summary = 0;
		$barcode = '';
		foreach ($get_content as $value_content) {
			$partno = $value_content->CHR_PART_NO;
			$backno = $value_content->CHR_BACK_NO;
			$qty = $value_content->INT_QTY;
			$qty_box = $value_content->INT_QTY_PER_BOX;
			$workcenter = $value_content->CHR_WORK_CENTER;
			$po = $value_content->CHR_NOPO_CUST;
			$barcode = $value_content->CHR_IDPALLET;
			$custno = $value_content->CHR_CUST_CODE;

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

			//$p .= $workcenter . '&nbsp;&nbsp;|&nbsp;&nbsp;'. $partno . '&nbsp;&nbsp;|&nbsp;&nbsp;'. $backno . '&nbsp;&nbsp;|&nbsp;&nbsp;'. $qty .'<br>';
			$p .= ' <tr style="text-align:center;">
				<td style="width:15mm;font-size:11px;">' . $workcenter . '</td>
				<td style="width:40mm;font-size:11px;">' . $partno . ' (' . trim($custno) . ')</td>
				<td style="width:8mm;font-size:11px;">' . $backno . '</td>
				<td style="width:10mm;font-size:11px;">' . $qty_box . '</td>
				<td style="width:8mm;font-size:11px;">' . $qty . '</td></tr>';

			$qty_summary = $qty_summary + $value_content->INT_QTY;
			$qty_box_summary = $qty_box_summary + ($value_content->INT_QTY / $value_content->INT_QTY_PER_BOX);
		}

		$p .= '</table>';
		$p .= '</td>';
		$p .= '<td colspan="2" style="height:9mm; border-bottom:solid;border-left:solid;border-right:solid; border-width: 1px; font-weight: bold;font-size:22px;vertical-align:top;text-align:center;">CASE NO #' . $no_pallet . '/' . $range . '</td>
				<td style="background-color:#000;color:#fff;font-size:' . $text_size . 'px;font-weight: bold;border: solid;border-width:1px;text-align:center;vertical-align:middle;">' . $cust_name . '</td>
			</tr>
			<tr style="text-align:center;">
				<td colspan="2" style="font-size:15;vertical-align:middle;text-align:center;">' . $po . '</td>
				<td style=" font-size:12;border-bottom: solid;border-left: solid;border-right:solid;border-width:1px;vertical-align:middle;text-align:center;">Customer</td>
			</tr>
			<tr style="text-align:center;">
				<td colspan="3"  style="height:20mm;vertical-align:middle;text-align:center;">&nbsp;<barcode type="C39" value="' . $barcode . '"label="label" style="width:87mm; height:10mm; color: #000000; font-size: 2mm">&nbsp;</barcode></td>
			</tr>
			<tr style="text-align:center;">
				<td style="width:25mm; font-size:12;border:solid;border-width:1px;vertical-align:middle;text-align:center;">Total Box</td>
				<td style="width:25mm; font-size:12;border:solid;border-width:1px;vertical-align:middle;text-align:center;">Total Qty</td>
				<td style="width:50mm; font-size:' . $text_country . ';font-weight: bold;background-color:#000;color:#fff;text-align:center;">' . $country . '</td>
			</tr>
			<tr style="text-align:center;">
				<td style="width:25mm; height:5mm;font-size:20;font-weight: bold;border:solid;border-width:1px;vertical-align:middle;text-align:center;">' . $qty_box_summary . '</td>
				<td style="width:25mm; height:5mm;font-size:20;font-weight: bold;border:solid;border-width:1px;vertical-align:middle;text-align:center;">' . $qty_summary . '</td>
				<td style="width:50mm;font-size:12px;font-style:italic;vertical-align: middle;">Printed Date : ' . date("d M Y") . '</td>
			</tr>';

		$p .= '</table>
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
