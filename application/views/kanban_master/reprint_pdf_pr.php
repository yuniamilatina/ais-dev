<?php
$cekjmlpartno=strlen($partno);
if ($cekjmlpartno>17) {
	$size="16px";
}else{
	$size="20px";
}
$page = 1;		
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
	font-size:'.$size.';
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
	font-size: 14px;
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
$partname1=substr($partno,0,6);
$partname2=substr($partno,6,5);
$partname3=substr($partno,11,2);
$partname5="-";
$partno=$partname1.$partname5.$partname2.$partname5.$partname3;
$partno=trim($partno);
$length2=strlen($partno);
if(substr($partno,0,1)=="-")//delete - pertama
{
$partno = substr($partno,1);
$length2=strlen($partno);	
}
if(substr($partno, -1) =="-")//delete minus terakhir
{	
$partno=rtrim($partno, "-");
};
							

for($x=0;$x<$printqty;$x++){
for ($u=0; $u < $range  ; $u++) { 
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
				<td colspan="3" rowspan="2" id="kotak2">'.$backno[$u][0].'</td>
				<td></td>
				<td id="kotak03">Self Process</td>
				
			</tr>
			<tr>
				<td colspan="2" id="kotak11">'.$partno.'</td>
				<td></td>
				<td id="kotak23">'.$selfprocess[$u][0].'</td>

			</tr>
			<tr>
				<td colspan="2" id="kotak03">Part No.Customer:</td>
				
				<td style = "margin-left:10mm;text-align:center" colspan="3" rowspan="2"><br>&nbsp;&nbsp;&nbsp;<barcode type="C39" value="'.$nokanban[$u][0].' '.$kanbantype[$u][0].' '.$serialno[$u][0].'" label="label" style="width:87mm; height:10mm; color: #000000; font-size: 2mm">&nbsp;</barcode></td>
				<td></td>
				<td id="kotak03">Next Process</td>
				
			</tr>
			<tr>
				<td colspan="2" id="kotak11">'.$cust[$u][0].'</td>
				<td></td>
				<td id="kotak23">'.$nextprocess[$u][0].'</td>
				
			</tr>
			<tr>
				<td>Sloc From:'.$selflocation[$u][0].'</td>
				<td></td>
				<td colspan="4" style="text-align:center;">'.$partname.' <br><br></td>
				<td>Sloc to:'.$nextlocation[$u][0].'</td>
				<td></td>
			</tr>
			
			<tr>
				<td style="font-size:10px;">Print Date <br>'.date("Y-m-d").'</td>
				<td></td>
				<td colspan = "1" style="font-size:11;border:solid;border-width:1px;text-align:center;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;BOX TYPE&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
				<td colspan = "4" style="font-size:11;border:solid;border-width:1px;text-align:center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; QTY &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>	
				<td rowspan="2" colspan="3" style="border:solid;text-align:center;border-width:1px"><br>' .$keterangan[$u][0]. '</td>
			</tr>
			<tr>
				<td> Serial No.'.$serialno[$u][0].' </td>
				<td style="font-size:18;font-color:#ff0000;text-align:center;font-weight:bold">'.$side[$u][0].'</td>
				<td style="font-size:22px;border:solid;border-width:1px;text-align:center">'.$boxtype[$u][0].'</td>
				<td style="font-size:22px;border:solid;border-width:1px;text-align:center"> '.$qtyperbox[$u][0].'</td>	
				<td></td>
				<td></td>
			</tr>
			
		</table>
</div>';
if (($page % 4) == 0) {
         $p.= "<style = page-break-after:always></style>";
    } 
	elseif (($page % 4) == 1) {
        $p.= "<p class=smallatas></p>";
    } 
	else {
        $p.= "<p class=big></p>";
    }
    $page++;
}
}

$p .= '</body>
</html>';

$this->kb_pdf->WriteHTML($p);
$this->kb_pdf->Output(''.$partno[0].'.pdf');