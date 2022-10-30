<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>Aisin Indonesia </title>
    <meta name="description" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css">

<style>
/*style navbar*/
.navbar {
      margin-bottom: 0;
      border-radius: 0;
	  background-color:#4d94ff;
	  
    }
.ex{
color: #ffffff;}

/*set row*/
.row{
    padding: 50px;
    margin: 10px;
	}

.bgrow{
 border-style: solid;
 border-width: 1px;
 }
	
/* Set gray background color and height */
.col-sm-12 
	{
      padding-top: 15px;
      padding-right: 20px;
      padding-left: 20px;
      background-color:#ccdeff;
      border-style: solid;
      border-color:#4d94ff ;
	}

#button {
    visibility: hidden;
}
</style>
</head>

<body>
<nav class="navbar navbar navbar-fixed-top">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        			<span class="icon-bar"></span>
        			<span class="icon-bar"></span>
        			<span class="icon-bar"></span>                        
      		</button>
			<div class="navbar-brand ex">Transaksi Pengembalian Barang dari Finish Goods (PP01/PP02/PP03) ke Warehouse (WH00)</div>	
		</div>
		<div class="collapse navbar-collapse" id="myNavbar">
			<ul class="nav navbar-nav">
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<li><a href=""><span class="glyphicon glyphicon-user"></span> Welcome</a></li>
				<li><a href="mainpage.php"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
			</ul>
		</div>
	</div>
</nav>

<div class="container-fluid text-center">    
	<div class="row">
		<div class="col-sm-12 text-center"> 
			<div class="panel panel-default">
				<div class="panel-heading">SELAMAT DATANG SILAHKAN SCAN BARANG YANG INGIN ANDA KEMBALIKAN</div>
			</div>
			<p>Scan Barcode "FINISH" untuk menyelesaikan transaksi pengembalian barang</p>
			<div class="container-fluid">
				<div class="row content">
					<div class="col-sm-4">
					<input autocomplete="off" type="text" name="box" id="box" placeholder="0 BOX" style="width:200px;text-align:center;" disabled><br>
					</div>
					<div class="col-sm-4 "> 
						<form class="form" action="" method="post">
							<div style="text-align: center;">
								<input autocomplete="off" type="text" name="barcode" id="barcode" placeholder="Scan Barcode" style="width:200px;text-align:center;" autofocus><br>
								<p><input type="submit" name="submit" value="" id="button"></p>
							</div>
						</form>	
<?php
// aktifkan fungsi session
session_start();

if (isset($_POST['submit'])) {
	$barcode = $_POST['barcode'];

	if (empty($barcode)) {
			echo "Scan Barcode Kanban";
	}
	elseif ($barcode == "CANCEL"){
				$_SESSION['barcode'] = $_POST['barcode'];
				header ("location:mainpage.php");
			}	
}
?>			
					</div>
					<div class="col-sm-4 ">
						<form class="form" action="" method="post">
							<div style="text-align: center;">
								<input autocomplete="off" type="text" name="qtybox" id="qtybox" placeholder="Quantity Box" style="width:200px;text-align:center;"><br>
								<p><input type="submit" name="submit" value="" id="button"></p>
							</div>
						</form>
					</div>	
				</div>
			</div>	
			<div class="container-fluid">
			<p>Barang yang anda kembalikan</p>
				<div class="table-responsive bgrow"> 
				<table class="table">
					<thead>
						<tr>
						<th>No</th>
						<th>Part Number</th>
						<th>Part Name</th>
						<th>Back Number</th>
						<th>Qty/Box</th>
						<th>Jumlah Box</th>
						</tr>
					</thead>
			</table>
			</div>
			
		</div>
		</div>
	</div>
</div>
		
<!-- Latest compiled and minified JavaScript -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="http://code.jquery.com/jquery-2.1.4.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</body>	
</html>