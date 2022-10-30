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
.row{
    padding: 50px;
    margin: 10px;
	}
.col-sm-8 
	{
      padding-top: 20px;
      background-color:#ccdeff;
	}
#button {
    visibility: hidden;
}
</style>
</head>
<body>
<nav class="navbar">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        			<span class="icon-bar"></span>
        			<span class="icon-bar"></span>
        			<span class="icon-bar"></span>                        
      		</button>
			<div class="navbar-brand ex">Transaksi Barang Raw Material </div>	
		</div>
		<div class="collapse navbar-collapse" id="myNavbar">
			<ul class="nav navbar-nav"></ul>
			<ul class="nav navbar-nav navbar-right">
				<li><a href=""><span class="glyphicon glyphicon-user"></span> Welcome</a></li>
				<li><a href="mainpage.php"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
			</ul>
		</div>
	</div>
</nav>

<div class="container-fluid text-center ">    
	<div class="row">
		<div class="col-sm-8 col-lg-offset-2  text-center "> 
			<div class="panel panel-default">
				<div class="panel-heading">SELAMAT DATANG SILAHKAN PILIH TRANSAKSI YANG AKAN ANDA LAKUKAN</div>
			</div>
			<div class="container-fluid">
				<form class="form" action="" method="post">
					<div style="text-align: center;">
						<input autocomplete="off" type="text" name="pilih" id="pilih" placeholder="TRANSAKSI" style="width:200px;text-align:center;" autofocus><br>
						<p><input type="submit" name="submit" value="" id="button"></p>
					</div>
				</form>
<?php
if (isset($_POST['pilih'])) {
	$pilih = $_POST['pilih'];

	if (empty($pilih)) {
			echo "Pilih Jenis Transaksi Yang Akan Anda Lakukan";
			}
	elseif ($pilih == "PENGAMBILAN"){
				$_SESSION['pilih'] = $_POST['pilih'];
				header ("location:transaksi_who_wip.php");
			}
	elseif ($pilih == "PASSTHROUGH"){
				$_SESSION['pilih'] = $_POST['pilih'];
				header ("location:transaksi_who_FG.php");
			}
	elseif ($pilih == "PENGEMBALIAN"){
				$_SESSION['pilih'] = $_POST['pilih'];
				header ("location:transaksi_wip_who.php");
			}
	elseif ($pilih == "PASSTHROUGHKEMBALI"){
				$_SESSION['pilih'] = $_POST['pilih'];
				header ("location:transaksi_FG_who.php");
			}
	elseif ($pilih == "CANCEL"){
				$_SESSION['pilih'] = $_POST['pilih'];
				header ("location:mainpage.php");
            }
 	}
?>
			</div>
		</div>
	</div>
</div>

<!-- Latest compiled and minified JavaScript -->
<!-- JSON.org on CDNJS CDN -->
<script type="text/javascript" src="http://ajax.cdnjs.com/ajax/libs/json2/20110223/json2.js"></script>
<!-- jQuery tmpl() plug-in on ASPNET CDN -->
<script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.templates/beta1/jquery.tmpl.js"></script>
<!-- jQuery on GOOGLE CDN -->
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="http://code.jquery.com/jquery-2.1.4.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</body>
</html>