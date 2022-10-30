<?php
$dbcoba = $this->load->database('mssql', TRUE);
?>
<!DOCTYPE html>
<html lang="en">
<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>Aisin Indonesia </title>
    <meta name="description" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css">

<head>
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
	.col-sm-12 	{
			padding-top: 15px;
			padding-right: 20px;
			padding-left: 20px;
			background-color:#ccdeff;
			border-style: solid;
			border-color:#4d94ff ;
		}
	.txt{
	padding-right: 200px;
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
				<div class="navbar-brand ex">Transaksi Pengambilan Barang dari Warehouse (WH00) ke WIP (WP01) </div>	
			</div>
			<div class="collapse navbar-collapse" id="myNavbar">
				<ul class="nav navbar-nav"></ul>
				<ul class="nav navbar-nav navbar-right">
						<li><a href="#"><span class="glyphicon glyphicon-user"></span> Welcome</a></li>
						<li><a href="mainpage.php"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
				</ul>
			</div>
		</div>
	</nav>

	<div class="container-fluid text-center">    
		<div class="row">
			<div class="col-sm-12 text-center"> 
				<div class="panel panel-default">
					<div class="panel-heading">SELAMAT DATANG SILAHKAN SCAN BARANG YANG INGIN ANDA AMBIL</div>
				</div>
				<p>Scan Barcode "FINISH" untuk menyelesaikan transaksi pengambilan barang</p> <br>
				<form class="form-inline" name="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
					<div class ="form-group txt" style="text-align: center;">
						<input autocomplete="off" type="text" name="box" id="box" placeholder="0 BOX" style="text-align:center">
					</div>
					<div class ="form-group txt" style="text-align: center;">
						<input autocomplete="off" type="text" name="barcode" id="barcode" placeholder="Scan Barcode" style="text-align:center" onchange="dua()" autofocus >
					</div>
					<div class ="form-group" style="text-align: center;">
						<input autocomplete="off" type="text" name="jmlbox" id="jmlbox" placeholder="Qty/Box" style="text-align:center" onchange="submit()"  >
					</div>
				</form>	<br>				

				<div class="table-content">
    			<div style="width:100%;margin-left: auto;margin-right: auto;margin-top: 5px;">
        		<table id="example" class="display" cellspacing="0" width="100%">
            		<thead>
            		<th>No</th>
            		<th>Part Number</th>
            		<th>Part Name</th>
            		<th>Back Number</th>
            		<th>Qty/Box</th>
            		<th>Quantity Box</th>
            		</thead> 
        
        		</table>
    			</div>
				</div>
			</div>
		</div>
	</div>

<?php
function test_input($data) {
$data = trim($data);
$data = stripslashes($data);
$data = htmlspecialchars($data);
return $data;
	}
?>
<script>
	function submit () {
		 var key;
		 if (window.event) key = window.event.key;
		 else if (e) key = e.which; {
		 	if (key == "13") {
		 		document.form.submit();
		 	}
		 }
	}
	function dua() {
		 document.getElementById('qtybox').focus();
	}
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="http://code.jquery.com/jquery-2.1.4.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</body>	
</html>