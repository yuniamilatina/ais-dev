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
	  background-color: #4d94ff;
    }
.ex{
color: #ffffff;}
.ex1{
color: red;}
/*set row*/
.row{
    padding: 50px;
    margin: 10px;
	}

.bgrow{
 border-style: solid;
 border-width: 5px;
 }
	
/* Set gray background color and height */
.col-sm-8 
	{
      padding-top: 20px;
      background-color:#ffffff
	}
body {
    background-color: #cceaff;
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
			<div class="navbar-brand ex">Transaksi Pengambilan Barang dari Warehouse (WH00) Finish Goods (PP01/PP02/PP03)</div>	
		</div>
		<div class="collapse navbar-collapse" id="myNavbar">
			<ul class="nav navbar-nav">
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<li><a href="#"><span class="glyphicon glyphicon-user"></span> Welcome</a></li>
				<li><a href="mainpage.php"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
			</ul>
		</div>
	</div>
</nav>

<div class="container-fluid text-center">    
	<div class="row">
		<div class="col-sm-8 col-lg-offset-2 box text-center"> 
			<div class="panel panel-default">
				<div class="panel-heading">Scan Transaksi yang Ingin Anda Lakukan</div>
			</div>
			<p class="ex1">PASTIKAN ANDA HANYA SCAN BARCODE "PP01" ATAU "PP02" ATAU "PP03"</p>
			<div class="container-fluid">
				<form class="form" action="" method="post">
					<div style="text-align: center;">
						<input autocomplete="off" type="text" name="PP01" id="PP01" placeholder="PP01/PP02/PP03" style="width:200px;text-align:center;" autofocus><br>
						<p><input type="submit" name="submit" value="" id="button"></p>
					</div>
				</form>
<?php
// aktifkan fungsi session
session_start();

if (isset($_POST['PP01'])) {
	$PP01 = $_POST['PP01'];

	if (empty($PP01)) {
			echo "Scan Barcode Kanban";
	}
	elseif ($PP01 == "PP01" || "PP02" || "PP03"){
				$_SESSION['PP01'] = $_POST['PP01'];
				header ("location:transaksi_who_FG1.php");
			}
	elseif ($PP01 == "CANCEL"){
				$_SESSION['PP01'] = $_POST['PP01'];
				header ("location:mainpage.php");
			}
}
?>		
			</div>	
		</div>
	</div>
</div>
		
<!-- Latest compiled and minified JavaScript -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="http://code.jquery.com/jquery-2.1.4.min.js"</script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"
</body>	
</html>