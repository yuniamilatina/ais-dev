<?php
$q=' 

<html>
<head>
	<title>Cetak PDF</title>
<style type="text/css">

#kotak{	
	height:80mm;
	width: 182mm;
	margin:0mm;
	border: solid;
	border-width: 1px;
}

#kotak01{
	width:51mm;	
	height:7mm;
	text-align: center;
}

#kotak02{
	width:69mm;	
	height:7mm;
	text-align: center;
}
#kotak11{
	width:51mm;	
	height:15mm;
	border-bottom: solid;
	border-top: solid;
	border-right: solid;
	border-width: 1px;
	font-size: 12px;
	text-align: center;
	padding-top:2mm;
}

#kotak12{
	width:69mm;	
	height:15mm;
	border: solid;
	border-width: 1px;
	text-align: center;
	padding-top:5mm;
	font-size: 40px;
}
#kotak13{
	width:51mm;	
	height:15mm;
	border-bottom: solid;
	border-top: solid;
	border-left: solid;
	border-width: 1px;
	font-size: 12px;
	text-align: center;
	padding-top:2mm;
}

#kotak21{
	width:51mm;	
	height:22mm;
	font-size: 12px;
	padding-top:3mm;
}

#kotak22{
	width:69mm;	
	height:22mm;
	padding-top:3mm;
}
#kotak23{
	width:51mm;	
	height:22mm;
	font-size: 12px;
	padding-top:3mm;
	text-align: right;
}

#kotak31{
	width:51mm;	
	height:5mm;
	border-right: solid;
	border-bottom: solid;
	border-top: solid;
	border-width: 1px;
	font-size: 12px;
}
#kotak32{
	width:69mm;	
	height:5mm;
	margin-top:0px;
}
#kotak33{
	width:51mm;	
	height:5mm;
	border-left: solid;
	border-bottom: solid;
	border-top: solid;
	border-width: 1px;
	font-size: 12px;
}

#kotak41{
	width:51mm;	
	height:9mm;
	border-right: solid;
	border-bottom: solid;
	border-width: 1px;
	text-align: center;
}
#kotak42{
	width:69mm;	
	height:9mm;
	margin-top:0px;
}
#kotak43{
	width:51mm;	
	height:5mm;
	border-left: solid;
	border-width: 1px;
	text-align: center;
}
#kotak51{
	width:51mm;	
	height:5mm;
	border-right: solid;
	border-bottom: solid;
	border-width: 1px;
	font-size: 12px;
}
#kotak52{
	width:34mm;	
	height:5mm;
	margin-top:0px;
	border:solid;
	border-width: 1px;
	text-align: center;
}
#kotak53{
	width:51mm;	
	height:5mm;
	border-top: solid;
	border-left: solid;
	border-width: 1px;
	font-size: 12px;
}

#kotak61{
	width:51mm;	
	height:9mm;
	border-right: solid;
	border-width: 1px;
	text-align: center;
}
#kotak62{
	width:34mm;	
	height:9mm;
	margin-top:0px;
	border-right: solid;
	border-left: solid;
	border-width: 1px;
	text-align: center;
}
#kotak63{
	width:51mm;	
	height:5mm;
	border-left: solid;
	border-top: solid;
	border-width: 1px;
	text-align: center;
}
#kepala{
	width:750px;	
	height:30px;
	padding: 0px;
	margin:0px auto;
}
#table{
	margin-top:0px;
	border-spacing: 0cm;
}
#spasi{
	width: 8mm;
}

</style>
</head>
<body>
<div id="kotak">
		<table id="table">
			<tr>
				<td id="kotak01"></td>
				<td id="spasi"></td>
				<td id="kotak02">PT AISIN INDONESIA</td>
				<td id="spasi"></td>
				<td id="kotak01"></td>
			</tr>
			<tr>
				<td id="kotak01"></td>
				<td id="spasi"></td>
				<td id="kotak02">PROCESS KANBAN</td>
				<td id="spasi"></td>
				<td id="kotak01"></td>
			</tr>
			<tr>
				<td id="kotak11"> Part No: <br><br>'.$partno.'</td>
				<td id="spasi"></td>
				<td id="kotak12">'.$backno.'</td>
				<td id="spasi"></td>
				<td id="kotak13">Side<br><br>'.$cust.'</td>
			</tr>
			<tr>
				<td id="kotak21">Print Date:</td>
				<td id="spasi"></td>
				<td id="kotak22"><barcode type="C128A" value="'.$nokanban.'" label="label" style="width:69mm; height:15mm; color: #770000; font-size: 2mm"></barcode></td>
				<td id="spasi"></td>
				<td id="kotak23">Serial No.</td>
			</tr>
			<tr>
				<td id="kotak31">Self Process</td>
				<td id="spasi"></td>
				<td id="kotak32"></td>
				<td id="spasi"></td>
				<td id="kotak33">Next Process</td>
			</tr>
			<tr>
				<td id="kotak41">'.$selfprocess.'</td>
				<td id="spasi"></td>
				<td id="kotak42"></td>
				<td id="spasi"></td>
				<td id="kotak43">'.$nextprocess.'</td>
			</tr>
			<tr>
				<td id="kotak51">Self Location</td>
				<td id="spasi"></td>
				<td id="kotak52">BOX TYPE &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;QTY/BOX</td>
				<td id="spasi"></td>
				<td id="kotak53">Next location</td>
			</tr>
			<tr>
				<td id="kotak61">'.$selflocation.'</td>
				<td id="spasi"></td>
				<td id="kotak62">'.$boxtype.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$qtyperbox.'</td>
				<td id="spasi"></td>
				<td id="kotak63">'.$nextlocation.'</td>
			</tr>
		</table>
		<!-- <div ></div>
		<div id="kotak2"></div>
		<div id="kotak3"></div>
		<div id="kotak4"></div>
		<div id="kotak3"></div>
		<div id="kotak4"></div> -->
	
</div>


</body>
</html>
';
$this->kb_pdf->WriteHTML($q);
 $this->kb_pdf->Output('exemple.pdf');
