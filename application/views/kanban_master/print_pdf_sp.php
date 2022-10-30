<?php
$cekjmlpartno=strlen($partno);
if ($cekjmlpartno>17) {
	$size="16px";
}else{
	$size="20px";
}
$p=' 
<html>
<head>
	<title>Cetak PDF</title>
	

<style type="text/css" rel = "stylesheet" media="print">

 p.breakhere {page-break-after: always;}

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
	font-size: '.$size.';
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
	font-size: 14px;
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
	font-size: 11px;
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
for ($x=0; $x < $printqty  ; $x++) { 

	$p.= '<div id="kotak">
		<table id="table">
		
			<tr>
				<td colspan="2"id="kotak02 ">PT AISIN INDONESIA</td>
				<td colspan="3" rowspan="2" id="kotak02">SUPPLY PARTS KANBAN'.$specialorder.' <br></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			<tr></tr>
			<tr>
				<td colspan="2" id="kotak03">Part No.AII:</td>
				<td colspan="3" rowspan="2" id="kotak2">'.$backno.'</td>
				<td></td>
				<td id="kotak03">Self Process</td>
				
			</tr>
			<tr>
				<td colspan="2" id="kotak11">'.$partno.'</td>
				<td></td>
				<td id="kotak12">J901<br> PT AISIN INDONESIA</td>

			</tr>
			<tr>
				<td colspan="2" id="kotak03">Part No.Customer:</td>
				
				<td style = "margin-left:10mm;text-align:center" colspan="3" rowspan="2"><br>&nbsp;&nbsp;<barcode type="C39" value="'.$nokanban.' '.$kanbantype.' '.$serialno[$x].'" label="label" style="width:87mm; height:10mm; color: #000000; font-size: 2mm"></barcode>&nbsp;</td>
				<td></td>
				<td id="kotak03">Next Process</td>
				
			</tr>
			<tr>
				<td colspan="2" id="kotak11">'.$cust.'</td>
				<td></td>
				<td id="kotak14">'.$nextpro.'<br>'.$befpro.'</td>
				
			</tr>
			<tr>
				<td>Sloc From:'.$selflocation.'</td>
				<td></td>
				<td colspan="4" style="text-align:center;">'.$partname.' <br><br></td>
				<td>Sloc to:'.$nextlocation.'</td>
				<td></td>
			</tr>
			
			<tr>
				<td style="font-size:10px;">Print Date <br>'.date("Y-m-d").'</td>
				<td></td>
				<td colspan = "1" style="font-size:11;border:solid;border-width:1px;text-align:center;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;BOX TYPE&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
				<td colspan = "4" style="font-size:11;border:solid;border-width:1px;text-align:center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; QTY &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>	
				<td rowspan="2" colspan="3" style="border:solid;text-align:center;border-width:1px"><br>'.$keterangan.'</td>
			</tr>
			<tr>
				<td> Serial No.'.$serialno[$x].' </td>
				<td style="font-size:18;font-color:#ff0000;text-align:center;font-weight:bold">'.$side.'</td>
				<td style="font-size:22px;border:solid;border-width:1px;text-align:center">'.$boxtype.'</td>
				<td style="font-size:22px;border:solid;border-width:1px;text-align:center"> '.$qtyperbox.'</td>	
				<td></td>
				<td></td>
			</tr>
			
		</table>
</div>';
if (($page % 4) == 0) {
	
	//var_dump($p);die();
        $p.= "<style = page-break-after:always></style>";
		 
		//var_dump($p);die();
		
    } 
	elseif (($page % 4) == 1) {
        $p.= "<p class=smallatas></p>";
    } 
	else {
        $p.= "<p class=big></p>";
    }
    $page++;
}





$p .= '</body>
</html>';

//var_dump($x);var_dump($printqty);die();
//var_dump($page);die();
$this->kb_pdf->WriteHTML($p);
$this->kb_pdf->Output('exemple.pdf');