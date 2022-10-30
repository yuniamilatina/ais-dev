<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from vergo-kertas.herokuapp.com/404.html by HTTrack Website Copier/3.x [XR&CO'2013], Tue, 16 Sep 2014 01:38:56 GMT -->
<head>
	<meta charset="utf-8">
	<!--[if IE]>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<![endif]-->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">
	
	<title>Not Authorize</title>
	
        <link rel="icon" href="<?php echo base_url('assets/img/favicon.ico') ?>">
	
	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
	
	<!-- BEGIN CSS FRAMEWORK -->
        <link rel="stylesheet" href="<?php echo base_url('assets/plugins/bootstrap/css/bootstrap.min.css') ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/plugins/font-awesome/css/font-awesome.min.css') ?>">
	<!-- END CSS FRAMEWORK -->
	
	<!-- BEGIN CSS PLUGIN -->
        <link rel="stylesheet" href="<?php echo base_url('assets/plugins/pace/pace-theme-minimal.css') ?>">
	<!-- END CSS PLUGIN -->
	
	<!-- BEGIN CSS TEMPLATE -->
        <link rel="stylesheet" href="<?php echo base_url('assets/css/main.css') ?>">
	
	<!-- END CSS TEMPLATE -->
</head>

<body class="error">
	<div class="outer">
		<div class="middle">
			<div class="inner">
				<div class="row">
					<!-- BEGIN ERROR PAGE -->
					<div class="col-lg-12">
						<!-- BEGIN ERROR -->
						<div class="circle">
							<i class="fa fa-eye-slash bg-blue"></i>
                                                        <span><?php echo '401'; ?></span>
						</div>
						<!-- END ERROR -->
						<!-- BEGIN ERROR DESCRIPTION -->
						<span class="status">Ouch! Authorization Required!</span>
						<span class="detail">You have no authorization to access this page or function. <a href="<?php echo base_url('index.php/basis/home_c'); ?>">Go home instead?</a> or <a href='javascript:history.back(1);'>Back to previous page.</a></span>
						<!-- END ERROR DESCRIPTION -->
					</div>
					<!-- END ERROR PAGE -->
				</div>
			</div>
		</div>
	</div>

	<!-- BEGIN JS FRAMEWORK -->
        <script src="<?php echo base_url('assets/plugins/jquery-2.1.0.min.js') ?>"></script>
        <script src="<?php echo base_url('assets/plugins/bootstrap/js/bootstrap.min.js') ?>"></script>
	
	<!-- END JS FRAMEWORK -->
	
	<!-- BEGIN JS PLUGIN -->
        <script src="<?php echo base_url('assets/plugins/pace/pace.min.js') ?>"></script>
	<!-- END JS PLUGIN -->
</body>

<!-- Mirrored from vergo-kertas.herokuapp.com/404.html by HTTrack Website Copier/3.x [XR&CO'2013], Tue, 16 Sep 2014 01:38:56 GMT -->
</html>