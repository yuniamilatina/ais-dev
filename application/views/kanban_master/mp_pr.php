<?php
// $partname = $this->kanban_master_m->findBySql("select CHR_PART_NAME 'pname' from TM_PARTS WHERE CHR_PART_NO = '$partno' ");
// $cek = array('INT_KANBAN_NO' =>$all[1] , );
//var_dump($all);die();
// // var_dump($qtyperbox);die();
set_time_limit(7200);
ini_set('max_execution_time', 0); 
ini_set('memory_limit','2048M');

// var_dump($partname[42]);die;
$page = 1;		
// $iserialno = (int)$serialno;
//$q.='<br>';

$p=' 
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
	font-size: 21px;
	text-align: center;
	font-weight: bold;
}
#kotak15{
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
#kotak23{
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


#table{
	margin:auto;
	border-spacing:0px;
}

</style>
</head>
<body>';


for ($x=0; $x < $jml  ; $x++) { 

		// var_dump($partno);die();
	$p.= '<div id="kotak">
		<table id="table">
		
			<tr>
				<td colspan="2"id="kotak02 ">PT AISIN INDONESIA</td>
				<td colspan="3" rowspan="2" id="kotak02">PROCESS KANBAN<br></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			<tr></tr>
			<tr>
				<td colspan="2" id="kotak03">Part No.AII:</td>
				<td colspan="3" rowspan="2" id="kotak2">'.$backno[$x].'</td>
				<td></td>
				<td id="kotak03">Self Process</td>
				
			</tr>
			<tr>
				<td colspan="2" id="kotak11">'.$partno[$x].'</td>
				<td></td>
				<td id="kotak23">'.$selfpro[$x].'</td> 

			</tr>
			<tr>
				<td colspan="2" id="kotak03">Part No.Customer:</td>
				
				<td style = "margin-left:10mm;text-align:center" colspan="3" rowspan="2">&nbsp;<barcode type="C39" value="'.$nokanban[$x].' '.$type[$x].' '.$serial[$x].'" label="label" style="width:87mm; height:10mm; color: #000000; font-size: 2mm"></barcode></td>
				<td></td>
				<td id="kotak03">Next Process</td>
				
			</tr>
			<tr>
				<td colspan="2" id="kotak15">'.$cust[$x].'</td>
				<td></td>
				<td id="kotak13">'.$nextpro[$x].'</td>
				
			</tr>
			<tr>
				<td>Sloc From:'.$slocfrom[$x].'</td>
				<td></td>
				<td colspan="4" style="text-align:center;">'.$partname[$x].'<br><br></td>
				<td>Sloc to:'.$slocto[$x].'</td>
				<td></td>
			</tr>
			
			<tr>
				<td style="font-size:10px;">Print Date <br>'.date("Y-m-d").'</td>
				<td></td>
				<td colspan = "1" style="font-size:11;border:solid;border-width:1px;text-align:center;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;BOX TYPE&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
				<td colspan = "4" style="font-size:11;border:solid;border-width:1px;text-align:center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; QTY &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>	
				<td rowspan="2" colspan="3" style="border:solid;text-align:center;border-width:1px"><br>'.$keterangan[$x].'</td>
			</tr>
			<tr>
				<td> Serial No. '.$serial[$x].' </td>
				<td style="font-size:18;font-color:#ff0000;text-align:center;font-weight:bold">'.$side[$x].'</td>
				<td style="font-size:22px;border:solid;border-width:1px;text-align:center">'.$boxtype[$x].'</td>
				<td style="font-size:22px;border:solid;border-width:1px;text-align:center"> '.$qtyperbox[$x].'</td>	
				<td></td>
				<td></td>
			</tr>
			
		</table>
</div>';
if (($page % 4) == 0) {
         $p.= "<style = page-break-after:always></style>";
		//"<div style=PAGE-BREAK-AFTER: always></div> ";
    } 
	elseif (($page % 4) == 1) {
        $p.= "<p class=smallatas></p>";
    } 
	else {
        $p.= "<p class=big></p>";
    }
    $page++;
}





//var_dump($iserialno);die();

$p .= '</body>
</html>';


//var_dump($p);die();
$this->kb_pdf->WriteHTML($p);
$this->kb_pdf->Output('mass_print_process.pdf');