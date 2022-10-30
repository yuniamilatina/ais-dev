<?php

$jml = count($all);
 // var_dump($all[0][0]->CHR_BACK_NO);die();
// var_dump($jml);die();


for ($i=0; $i <$jml; $i++) {
	$intVal1 = $all[$i][0]->INT_QTY;
            $strVal1 = (string) $intVal1;
            $x = strlen($strVal1);
            $b = 3;
            $y = $b - $x;
            $no2 = 0;
            for ($u = 0; $u < $y; $u++) {
                $no1 = 0;
                $no2 = $no2 . $no1;
            }
            $qtyperbox = $no2 . $strVal1;
	// $serial = $all[0][$i]->CHR_SERIAL;
	// var_dump($serial);die();
    $backno = $all[$i][0]->CHR_BACK_NO;
    // var_dump($backno);die();
    $partno1 = $this->return_stamping_m->getData("SELECT CHR_PART_NO 'partno' FROM TM_PARTS where CHR_BACK_NO = '$backno'");
    $partname1 = $this->return_stamping_m->getData("SELECT DISTINCT CHR_PART_NAME 'partname' FROM TM_PARTS where CHR_BACK_NO = '$backno'");
    $partno = $partno1[0]->partno;
    // var_dump($partno);die();
    $partname = $partname1[0]->partname;
    // $qty= $all[0][$i]->INT_QTY;
    // var_dump($qty);
    // $barcode = $all[0][$i]->CHR_BARCODE;
// var_dump($all[$i][0]->CHR_BARCODE);die();
	$q=' 

<html>
<head>
	<title>Cetak PDF</title>
<style type="text/css">

#kotak{	
	height:55mm;
	width: 96mm;
	border: solid;
	border-width: 1px;
}

#kotak01{
	width:35mm;	
	height:1mm;
	text-align: left;
	padding-left:10px;
	font-family: Times, serif;
	font-weight: bold;
}

#kotak02{
	width:46mm;	
	height:1mm;
	font-size:18px;
	text-align: right;
	font-weight: bold;
	padding-right:10px;
}
#baris2{
	width:80mm;	
	height:auto;
	font-size:12px;
}
#baris21{
	width:80mm;	
	height:auto;
	font-size:12px;
	font-weight: bold;
}
#baris3{
	width:15mm;	
	font-size:12px;
	padding-left:5px;
}


#kotak41{
	width:35mm;	
	height:1mm;
	font-size:12px;
	padding-left:10px;
}

#kotak42{
	width:46mm;	
	height:1mm;
	font-size:40px;
	text-align: right;
	padding-right:5px;
}

#baris5{
	width:85mm;	
	height:1mm;
	text-align:center;
	font-size:12px;
	padding-left:3px;
	padding-right:3px;

}

#baris6{
	width:80mm;	
	padding-bottom:10px;
	
	font-size:12px;
	padding-left:5px;
	}

#table{
	border-collapse: collapse;
	border-spacing:0px;
}

</style>
</head>
<body>
<div id="kotak">
		<table id="table">
			<tr>
				<td id="kotak01">PT AISIN INDONESIA</td>
				<td id="kotak02"><br>Kanban RETURN STAMPING</td>
			</tr>
			<tr id="baris2">
				<td colspan="2" style="padding-left:10px;" >Part No / Name</td>
			</tr>
			<tr id="baris21">
				<td colspan="2" style="padding-left:10px;">'.$partno.'</td>
			</tr>
			<tr id="baris21">
				<td colspan="2" style="padding-left:10px;">'.$partname.'</td>
			</tr>
			<tr>
				<td colspan="2" style="padding-left:10px;">Qty : <b>'.$all[$i][0]->INT_QTY.'</b> </td>
			</tr>
			<tr>
				<td id="kotak41">Serial : <b>'.$all[$i][0]->CHR_SERIAL.'</b></td>
				<td id="kotak42">'.$all[$i][0]->CHR_BACK_NO.'</td>
			</tr>	
			<tr>
				<td colspan="2" id="baris5"><barcode type="C128" value="'.$all[$i][0]->CHR_SERIAL.' '.$all[$i][0]->CHR_BACK_NO.'&nbsp;'.$qtyperbox.'" label="label" style="width:76mm; height:6mm; color: #000000; font-size: 2mm"></barcode></td>
			</tr>
			<tr id="baris6">
				<td colspan="2" style="padding-left:10px;padding-top:10px;" >Print Date : '.date("M d, Y").' ('.date("H : i").')</td>
			</tr>
		</table>
</div>


</body>
</html>
';
$this->kb_pdf->WriteHTML($q);
}


$this->kb_pdf->Output('exemple.pdf');
